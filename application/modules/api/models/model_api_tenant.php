<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * Model API read-only: TENANT (master_rekanan, rekanantype_id = 105).
 * Skema mengikuti pattern modules/master_rekanan — kolom verifikasi
 * lewat sys.columns, bukan mengarang.
 */

class Model_api_tenant extends CI_Model {

    /** Detail satu tenant berdasar rekanan_id.
     *  CATATAN: master_rekanan TIDAK punya kolom region_id (terverifikasi
     *  sys.columns) — nama region tidak tersedia di level master_rekanan. */
    public function get_by_id($rekanan_id)
    {
        $sql = "SELECT r.rekanan_id, r.rekanan_badanhukum, r.rekanan_name,
                       r.rekanan_namereport, r.rekanan_address, r.rekanan_city,
                       r.rekanan_telp, r.rekanan_fax, r.rekanan_email, r.rekanan_nohp,
                       r.rekanan_taxprefix, r.rekanan_taxaddress, r.rekanan_creditlimit,
                       r.rekanan_isdisabled, r.rekanan_create_date,
                       r.grouptenant_id, r.rekanantype_id
                FROM   master_rekanan r
                WHERE  r.rekanan_id = ?
                  AND  r.rekanantype_id = 105";

        return $this->db->query($sql, array($rekanan_id))->row_array();
    }

    /** Cari tenant LIKE keyword, pakai binding. TOP via int-cast, bukan string user. */
    public function search($keyword, $limit = 20)
    {
        $limit = (int) $limit;
        if ($limit < 1)  { $limit = 20; }
        if ($limit > 100) { $limit = 100; }

        $kw = '%'.$keyword.'%';

        $sql = "SELECT TOP ".$limit."
                       r.rekanan_id, r.rekanan_name, r.rekanan_badanhukum,
                       r.rekanan_city, r.rekanan_telp, r.rekanan_email,
                       r.rekanan_isdisabled
                FROM   master_rekanan r
                WHERE  r.rekanantype_id = 105
                  AND  r.rekanan_isdisabled = 0
                  AND  (r.rekanan_id LIKE ? OR r.rekanan_name LIKE ?)
                ORDER BY r.rekanan_name";

        return $this->db->query($sql, array($kw, $kw))->result_array();
    }
}
