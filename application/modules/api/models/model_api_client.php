<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * Model kredensial client API.
 * SEMUA query pakai binding "?" — TIDAK concat string (standar modul API).
 */

class Model_api_client extends CI_Model {

    /**
     * Ambil satu client aktif berdasar api_key.
     * @return array|null
     */
    public function get_by_api_key($api_key)
    {
        $sql = "SELECT api_client_id, client_name, api_key, api_secret,
                       is_active, rate_limit_per_minute
                FROM   api_client
                WHERE  api_key = ?
                  AND  is_active = 1";

        $row = $this->db->query($sql, array($api_key))->row_array();

        if ($row !== NULL && (int) $row['is_active'] !== 1)
        {
            return NULL;
        }

        return $row;
    }
}
