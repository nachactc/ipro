<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * API v1 — endpoint AUTH (lapis identity user).
 *
 * URL : POST index.php/api/v1/auth/login   { username, password }
 *       GET  index.php/api/v1/auth/me      (Bearer token)
 *       POST index.php/api/v1/auth/logout  (Bearer token — revoke)
 *
 * Lapis auth:
 *   - TRANSPORT: X-Api-Key/X-Timestamp/X-Signature (HMAC) — tetap wajib di
 *     endpoint ini; merupakat kunci perangkat/broker, bukan user.
 *   - IDENTITY : username+password dari master_user (hash MD5 legacy,
 *     konsisten dengan login web: md5($password) == user_password).
 *     login mengembalikan Bearer token; token dipakai di endpoint berikutnya.
 *
 * Nama field respons user mengikuti field session web:
 * username, user_fullname, user_level, branch_id, channel_id, region_id.
 */

if ( ! class_exists('Api_controller'))
{
    require_once APPPATH.'modules/api/libraries/Api_controller.php';
}

class Auth extends Api_controller {

    /* login & logout memakai POST (body ditandai pada signature) */
    protected $allowed_methods = array('GET', 'POST');

    function __construct()
    {
        // parent::__construct() menjalankan CORS + method check + HMAC auth.
        // Bearer TIDAK dipaksa di sini (login belum punya token);
        // me() dan logout() memanggil _bearer() manual.
        parent::__construct();

        $this->load->model('model_api_auth');
    }

    /** POST auth/login — kredensial user, hasil token Bearer. */
    function login()
    {
        $body     = $this->_body();
        $username = isset($body['username']) ? strtolower(trim((string) $body['username'])) : '';
        $password = isset($body['password']) ? (string) $body['password'] : '';

        if ($username === '' OR $password === '')
        {
            $this->fail('Field username & password wajib dikirim (JSON body atau form).', 422);
        }
        if (strlen($username) > 50)
        {
            $this->fail('Username terlalu panjang.', 422);
        }

        $user = $this->model_api_auth->get_user($username);

        $valid = FALSE;
        if ($user !== NULL AND (int) $user['user_isdisabled'] === 0)
        {
            // hash MD5 legacy dari database (konsisten login web), timing-safe
            $valid = ($user['user_password'] !== '' AND hash_equals((string) $user['user_password'], md5($password)));
        }

        if ( ! $valid)
        {
            // Pesan generik — bocor username tidak dikenal / password salah lebih baik dihindari
            $this->fail('Username atau password salah.', 401);
        }

        // user_isdisabled = 0 dan password cocok
        $token = $this->model_api_auth->create_token((int) $this->client['api_client_id'], $user['username']);

        $this->ok(array(
            'token_type'    => 'Bearer',
            'token'         => $token['token'],
            'expires_at'    => $token['expires_at'],
            'expires_epoch' => $token['expires_epoch'],
            'user' => array(
                'username'    => $user['username'],
                'user_fullname'=> $user['user_fullname'],
                'user_level'  => $user['user_level'],
                'branch_id'   => $user['branch_id'],
                'channel_id'  => $user['user_default_channel_id'],
                'region_id'   => $user['region_id'],
            ),
        ));
    }

    /** GET auth/me — profil user dari token aktif. */
    function me()
    {
        $t = $this->_bearer();

        $this->ok(array(
            'username'    => $t['username'],
            'user_fullname' => $t['user_fullname'],
            'user_level'  => $t['user_level'],
            'branch_id'   => $t['branch_id'],
            'channel_id'  => $t['user_default_channel_id'],
            'region_id'   => $t['region_id'],
            'expires_at'  => ($t['expires_at'] instanceof DateTime ? $t['expires_at']->format('Y-m-d H:i:s') : (string) $t['expires_at']),
            'last_used_at'=> ($t['last_used_at'] instanceof DateTime ? $t['last_used_at']->format('Y-m-d H:i:s') : (string) $t['last_used_at']),
        ));
    }

    /** POST auth/logout — revoke token aktif. */
    function logout()
    {
        $t = $this->_bearer();

        $this->model_api_auth->revoke($t['token_hash']);

        $this->ok(array('revoked' => TRUE, 'username' => $t['username']));
    }
}
