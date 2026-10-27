<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * Model API read-only: INVOICE.
 * Struktur mengikuti pola di modules/schedule_payment/models/model_schedule_payment.php:
 *   header  = transaksi_schedulepayment      (join master tabel utk nama)
 *   detil   = transaksi_schedulepaymentdetil (invoice_id, faktur_id, line, idr)
 * Kolom detil diverifikasi lewat sys.columns sebelum dipakai.
 */

class Model_api_invoice extends CI_Model {

    /** Header satu invoice berdasar schedulepayment_id. */
    public function get_header($schedulepayment_id)
    {
        $sql = "SELECT a.schedulepayment_id, a.schedulepayment_descr,
                       a.schedulepayment_contractno,
                       a.schedulepayment_isapproved, a.schedulepayment_isclosed,
                       a.schedulepayment_createby, a.schedulepayment_createdate,
                       a.schedulepayment_modifyby, a.schedulepayment_modifydate,
                       a.ref_id, a.ref_line, a.transaksi_id,
                       a.schedulepayment_virtualaccount,
                       a.branch_id, b.branch_name,
                       a.region_id, c.region_name,
                       a.rekanan_id, e.rekanan_name,
                       a.rekananshipping_line, f.rekananshipping_name
                FROM   transaksi_schedulepayment a
                       LEFT JOIN master_branch b ON a.branch_id = b.branch_id
                       LEFT JOIN master_region c ON a.region_id = c.region_id
                       LEFT JOIN master_rekanan e ON a.rekanan_id = e.rekanan_id
                       LEFT JOIN master_rekananshipping f
                              ON a.rekananshipping_line = f.rekananshipping_line
                             AND a.rekanan_id = f.rekanan_id
                WHERE  a.schedulepayment_id = ?";

        return $this->db->query($sql, array($schedulepayment_id))->row_array();
    }

    /** Baris detil satu invoice — kolom sesuai sys.columns (50 kolom asli,
     *  subset yang relevan untuk read-only reporting). */
    public function get_lines($schedulepayment_id)
    {
        $sql = "SELECT d.schedulepaymentdetil_line, d.agreementtype_id,
                       d.schedulepaymentdetil_date, d.schedulepaymentdetil_duedate,
                       d.schedulepaymentdetil_amount, d.schedulepaymentdetil_idr,
                       d.schedulepaymentdetil_foreign, d.schedulepaymentdetil_foreignrate,
                       d.schedulepaymentdetil_tax, d.currency_id,
                       d.schedulepaymentdetil_descr, d.schedulepaymentdetil_unit,
                       d.invoice_id, d.faktur_id, d.faktur_date,
                       d.schedulepaymentdetil_isposted, d.schedulepaymentdetil_posteddate
                FROM   transaksi_schedulepaymentdetil d
                WHERE  d.schedulepayment_id = ?
                ORDER BY d.schedulepaymentdetil_line";

        return $this->db->query($sql, array($schedulepayment_id))->result_array();
    }

    /**
     * Cari invoice: schedulepayment_id / contractno / nama rekanan.
     * TOP via int-cast; keyword pakai binding.
     */
    public function search($keyword, $limit = 20)
    {
        $limit = (int) $limit;
        if ($limit < 1)  { $limit = 20; }
        if ($limit > 100) { $limit = 100; }

        $kw = '%'.$keyword.'%';

        $sql = "SELECT TOP ".$limit."
                       a.schedulepayment_id, a.schedulepayment_contractno,
                       a.schedulepayment_descr, a.schedulepayment_isapproved,
                       a.schedulepayment_isclosed, a.schedulepayment_createdate,
                       a.rekanan_id, e.rekanan_name
                FROM   transaksi_schedulepayment a
                       LEFT JOIN master_rekanan e ON a.rekanan_id = e.rekanan_id
                WHERE  a.schedulepayment_id LIKE ?
                   OR  a.schedulepayment_contractno LIKE ?
                   OR  e.rekanan_name LIKE ?
                ORDER BY a.schedulepayment_id";

        return $this->db->query($sql, array($kw, $kw, $kw))->result_array();
    }
}
