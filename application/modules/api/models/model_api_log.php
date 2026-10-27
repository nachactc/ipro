<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * Model log request API — sekaligus sumber rate limiting
 * (log_threshold aplikasi = 0 dan tidak boleh diubah dari modul).
 */

class Model_api_log extends CI_Model {

    /** Tulis satu baris log request. */
    public function insert($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('api_log', $data);
    }

    /**
     * Hitung attempt client dalam N detik terakhir
     * (semua status dihitung, supaya brute force ikut ketahuan).
     */
    public function count_recent($api_client_id, $seconds = 60)
    {
        $sql = "SELECT COUNT(*) AS jml
                FROM   api_log
                WHERE  api_client_id = ?
                  AND  created_at > DATEADD(SECOND, ?, GETDATE())";

        $row = $this->db->query($sql, array((int) $api_client_id, -1 * (int) $seconds))->row_array();

        return (int) ($row !== NULL ? $row['jml'] : 0);
    }
}
