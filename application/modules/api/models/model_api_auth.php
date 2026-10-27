<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * Model autentikasi user API v1.
 *
 * Pola auth dua lapis:
 *   1. TRANSPORT  : api_key + api_secret (HMAC, tabel api_client) — bisa
 *                   perangkat/broker, TIDAK langsung dikenali si username.
 *   2. IDENTITY   : endpoint auth/login memvalidasi username+password
 *                   (master_user, hash MD5 legacy — konsisten dengan login web)
 *                   lalu menerbitkan Bearer token (tabel api_token).
 *
 * Keamanan:
 *   - Token di DB = SHA-256 hex (CHAR 64). Plaintext hanya di response sekali.
 *   - Perbandingan password pakai hash_equals (timing-safe).
 *   - user_isdisabled diperiksa (login web legacy TIDAK memeriksa — perbaikan di API).
 *   - Semua query pakai binding "?".
 */

class Model_api_auth extends CI_Model {

    /** Ambil kredensial user berdasar username (lowercase). */
    public function get_user($username)
    {
        $sql = "SELECT u.username, u.user_password, u.user_fullname,
                       u.user_isdisabled, u.user_isnew, u.user_level,
                       u.branch_id, u.region_id, u.user_default_channel_id
                FROM   master_user u
                WHERE  u.username = ?";

        return $this->db->query($sql, array($username))->row_array();
    }

    /**
     * Terbitkan token: plaintext dikembalikan (disimpan sebagai SHA-256).
     * Kedaluwarsa dihitung oleh jam DATABASE (GETDATE) — aman dari
     * mismatch timezone PHP vs SQL Server.
     * Sekalian housekeeping: hapus expired > 1 hari.
     * @return array{token:string, expires_at:string, expires_epoch:int}
     */
    public function create_token($api_client_id, $username)
    {
        $ttl   = (int) (config_item('api_token_ttl_seconds') ?: 86400);
        $plain = bin2hex($this->_random_bytes(32));                 // 64 hex

        // housekeeping — token lewati kedaluwarsa >1 hari dibuang
        $this->db->query(
            "DELETE FROM api_token WHERE expires_at < DATEADD(DAY, -1, GETDATE())"
        );

        $this->db->query(
            "INSERT INTO api_token (token_hash, api_client_id, username, expires_at)
             VALUES (?, ?, ?, DATEADD(SECOND, ?, GETDATE()))",
            array(hash('sha256', $plain), (int) $api_client_id, $username, $ttl)
        );

        $row = $this->db->query(
            "SELECT expires_at FROM api_token WHERE token_hash = ?",
            array(hash('sha256', $plain))
        )->row_array();

        return array(
            'token'        => $plain,
            'expires_at'   => ($row !== NULL ? $row['expires_at'] : ''),
            'expires_epoch'=> ($row !== NULL && $row['expires_at'] instanceof DateTime
                                ? $row['expires_at']->getTimestamp() : 0),
        );
    }

    /**
     * Validasi Bearer token: gabung user profile dalam satu query.
     * @return array|null  baris token + profil user
     */
    public function validate_token($token_plain)
    {
        $sql = "SELECT t.api_token_id, t.token_hash, t.api_client_id, t.username,
                       t.expires_at, t.last_used_at,
                       u.user_fullname, u.user_level, u.user_isdisabled,
                       u.branch_id, u.region_id, u.user_default_channel_id
                FROM   api_token t
                       JOIN master_user u ON u.username = t.username
                WHERE  t.token_hash = ?
                  AND  t.revoked_at IS NULL
                  AND  t.expires_at > GETDATE()";

        $row = $this->db->query($sql, array(hash('sha256', $token_plain)))->row_array();

        if ($row === NULL || (int) $row['user_isdisabled'] === 1)
        {
            return NULL;
        }

        return $row;
    }

    /** Tandai waktu pemakaian terakhir (sliding visibility). */
    public function touch($token_hash)
    {
        $this->db->query(
            "UPDATE api_token SET last_used_at = GETDATE() WHERE token_hash = ?",
            array($token_hash)
        );
    }

    /** Cabut token (logout). */
    public function revoke($token_hash)
    {
        $this->db->query(
            "UPDATE api_token SET revoked_at = GETDATE()
             WHERE  token_hash = ? AND revoked_at IS NULL",
            array($token_hash)
        );
    }

    protected function _random_bytes($length)
    {
        if (function_exists('random_bytes')) return random_bytes($length);
        // fallback PHP 5 era (paragonie pola lama): hash byte stream
        $out = '';
        while (strlen($out) < $length) { $out .= hash('sha256', mt_rand(), TRUE); }
        return substr($out, 0, $length);
    }
}
