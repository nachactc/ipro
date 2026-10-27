<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * Base controller modul API v1.
 *
 * Semua controller endpoint di modules/api/controllers/v1/ EXTEND class ini
 * (require_once di bagian atas file controller).
 *
 * Kenapa class ini di libraries/ bukan core/:
 *   kendala deployment — hanya folder modules/ yang boleh berubah,
 *   jadi base class harus tinggal di dalam modul (file ini).
 *
 * Lapis auth (server-to-server):
 *   1. TRANSPORT (wajib semua endpoint):
 *      X-Api-Key, X-Timestamp (±toleransi), X-Signature — HMAC-SHA256 atas
 *      "METHOD|REQUEST_URI|API_KEY|TIMESTAMP|SHA256(body)"  dgn api_secret.
 *      SHA256(body) menjamin body POST tidak bisa ditamper dalam window replay.
 *   2. IDENTITY (endpoint yang butuh user):
 *      Authorization: Bearer <token> — diterbitkan oleh auth/login,
 *      tervalidasi ke tabel api_token. Aktifkan via $require_token = TRUE
 *      di subclass, atau panggil $this->_bearer() manual di method.
 *
 * CATATAN KEAMANAN:
 *   - BUKAN kelanjutan pattern check_user_login() — API stateless.
 *   - Semua query model di modul ini wajib pakai binding (bukan concat).
 */

class Api_controller extends CI_Controller {

    /* Read-only bawaan; subclass boleh menambah 'POST' (dgn body-hash). */
    protected $allowed_methods = array('GET');

    /* TRUE = setelah HMAC wajib juga Bearer token user.
       FALSE (default read-only) = cukup HMAC. */
    protected $require_token = FALSE;

    /** @var array|null baris api_client yang lolos auth */
    protected $client = NULL;

    /** @var array|null baris api_token + profil user (bila Bearer aktif) */
    protected $token = NULL;

    protected $request_method;
    protected $request_uri;

    function __construct()
    {
        parent::__construct();

        $this->request_method = strtoupper($this->input->method(TRUE));
        $this->request_uri    = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

        // konfig/helper/model milik modul API (resolusi oleh MX_Loader)
        $this->load->config('api_config');
        $this->load->helper('api_response');
        $this->load->model('model_api_client');
        $this->load->model('model_api_log');

        $this->_cors_headers();

        if ( ! in_array($this->request_method, $this->allowed_methods, TRUE))
        {
            $this->fail('Metode HTTP tidak diperbolehkan untuk endpoint ini.', 405);
        }

        try
        {
            $this->client = $this->_authenticate_hmac();

            if ($this->require_token)
            {
                $this->token = $this->_load_bearer();
            }
        }
        catch (Exception $e)
        {
            // Pesan generik — detail exception tidak boleh bocor ke client.
            $this->fail('Kesalahan server (500). Pastikan script SQL modul API sudah dieksekusi di database.', 500);
        }
    }

    /* =========================== AUTH ================================ */

    private function _authenticate_hmac()
    {
        $api_key = $this->input->get_request_header('X-Api-Key', TRUE);
        $ts      = $this->input->get_request_header('X-Timestamp', TRUE);
        $sig     = $this->input->get_request_header('X-Signature', TRUE);

        if ($api_key === NULL OR $ts === NULL OR $sig === NULL)
        {
            $this->fail('Header autentikasi tidak lengkap. Butuh X-Api-Key, X-Timestamp, X-Signature.', 401);
        }

        if ( ! ctype_digit((string) $ts))
        {
            $this->fail('X-Timestamp harus Unix epoch detik (integer).', 401);
        }

        $tolerance = (int) config_item('api_timestamp_tolerance');
        if (abs(time() - (int) $ts) > $tolerance)
        {
            $this->fail('X-Timestamp di luar toleransi +'.$tolerance.'/-'.$tolerance.' detik. Sinkronkan jam client dengan server.', 401);
        }

        $client = $this->model_api_client->get_by_api_key($api_key);
        if ($client === NULL)
        {
            $this->fail('API key tidak dikenal atau tidak aktif.', 401);
        }

        // Rate limit dihitung dari api_log (semua attempt, sukses/gagal)
        $used  = $this->model_api_log->count_recent((int) $client['api_client_id'], 60);
        $limit = (int) ($client['rate_limit_per_minute'] > 0 ? $client['rate_limit_per_minute'] : config_item('api_default_rate_limit'));
        if ($used >= $limit)
        {
            $this->fail('Rate limit tercapai ('.$limit.' request/menit).', 429);
        }

        // Signature mencakup SHA-256 body — body POST tidak bisa ditamper.
        // Normalisasi CRLF -> LF: Postman/BE di Windows bisa memakai \r\n di body;
        // keduanya memproduksi byte yang BERBEDA padahal JSON-nya identik.
        $raw = (string) $this->input->raw_input_stream;
        $body_hash = hash('sha256', str_replace("\r\n", "\n", $raw));
        $string_to_sign = $this->request_method.'|'.$this->request_uri.'|'.$api_key.'|'.$ts.'|'.$body_hash;
        $expected       = hash_hmac('sha256', $string_to_sign, $client['api_secret']);
        if ( ! hash_equals($expected, strtolower($sig)))
        {
            $this->fail('Signature tidak valid. Cek: (1) string-to-sign = METHOD|REQUEST_URI|API_KEY|TIMESTAMP|SHA256(body), (2) body yang di-hash = body yang dikirim, (3) SHA256 body kosong = e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 401);
        }

        return $client;
    }

    /**
     * Wajibkan Bearer token — dipanggil otomatis (constructor) bila
     * $require_token = TRUE, atau manual di method tertentu (auth/logout).
     * @return array baris api_token + profil user
     */
    protected function _bearer()
    {
        if ($this->token === NULL)
        {
            $this->token = $this->_load_bearer();
        }
        return $this->token;
    }

    private function _load_bearer()
    {
        $this->load->model('model_api_auth');

        $header = $this->input->get_request_header('Authorization', TRUE);
        if ($header === NULL OR stripos($header, 'bearer ') !== 0)
        {
            $this->fail('Header Authorization: Bearer <token> wajib diisi.', 401);
        }

        $plain = trim(substr($header, 7));
        if ($plain === '')
        {
            $this->fail('Token kosong di header Authorization.', 401);
        }

        $row = $this->model_api_auth->validate_token($plain);
        if ($row === NULL)
        {
            $this->fail('Token tidak valid, kadaluwarsa, atau sudah di-revoke. Silakan login kembali.', 401);
        }

        $this->model_api_auth->touch($row['token_hash']);
        return $row;
    }

    /* =========================== UTIL ================================ */

    /** Body request: JSON raw, fallback ke form POST (ua). */
    protected function _body()
    {
        $raw  = $this->input->raw_input_stream;
        $data = array();

        if ($raw !== NULL AND trim($raw) !== '')
        {
            $decoded = json_decode($raw, TRUE);
            if (is_array($decoded)) { $data = $decoded; }
        }

        if (empty($data))
        {
            $post = $this->input->post(NULL, TRUE);
            if (is_array($post)) { $data = $post; }
        }

        return $data;
    }

    private function _cors_headers()
    {
        // CORS otomatis dari base_url aplikasi (tanpa duplikasi config)
        $allowed = array();
        $parts   = parse_url(config_item('base_url'));
        if ( ! empty($parts['host']))
        {
            $scheme    = ( ! empty($parts['scheme'])) ? $parts['scheme'] : (($_SERVER['HTTPS'] ?? '') === 'on' ? 'https' : 'http');
            $allowed[] = $scheme.'://'.$parts['host'].(isset($parts['port']) ? ':'.$parts['port'] : '');
        }

        // tambahan origin manual bila perlu (config api_cors_extra_origins)
        $extra = (array) config_item('api_cors_extra_origins');
        $allowed = array_unique(array_merge($allowed, $extra));
        if (empty($allowed))
        {
            return; // server-to-server, CORS tidak relevan
        }

        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        if ($origin === '' OR $origin === FALSE)
        {
            return;
        }

        if (in_array('*', $extra, TRUE))
        {
            header('Access-Control-Allow-Origin: *');
        }
        elseif (in_array($origin, $allowed, TRUE))
        {
            header('Access-Control-Allow-Origin: '.$origin);
            header('Vary: Origin');
        }
    }

    private function _log($http_status, $error_message, $extra = array())
    {
        try
        {
            $this->model_api_log->insert(array(
                'api_client_id' => ($this->client !== NULL ? (int) $this->client['api_client_id'] : NULL),
                'api_key'       => $this->input->get_request_header('X-Api-Key', TRUE),
                'http_method'   => $this->request_method,
                'uri_path'      => substr($this->request_uri, 0, 255),
                'http_status'   => $http_status,
                'ip_address'    => $this->input->ip_address(),
                'error_message' => ($error_message !== NULL ? substr($error_message, 0, 500) : NULL),
            ));
        }
        catch (Exception $e)
        {
            // Logging tidak boleh mematikan endpoint; diam-diam lanjut.
        }
    }

    /* ========================= RESPONSE ============================== */

    protected function fail($message, $http = 400, $extra = array())
    {
        $this->_log($http, $message, $extra);
        api_output($message, $http, $extra);
    }

    protected function ok($data = NULL)
    {
        $this->_log(200, NULL, array());
        api_output('OK', 200, $data);
    }
}
