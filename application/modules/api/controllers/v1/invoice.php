<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * API v1 — endpoint INVOICE.
 *
 * URL : index.php/api/v1/invoice/get?id=<schedulepayment_id>
 *       index.php/api/v1/invoice/search?q=<keyword>&limit=20
 *
 * Wajib header auth (lihat modules/api/README.md):
 *   X-Api-Key, X-Timestamp, X-Signature
 */

if ( ! class_exists('Api_controller'))
{
    require_once APPPATH.'modules/api/libraries/Api_controller.php';
}

class Invoice extends Api_controller {

    function __construct()
    {
        // parent::__construct() menjalankan CORS + method check + auth + rate limit
        parent::__construct();

        $this->load->model('model_api_invoice');
    }

    /** GET invoice/get?id=... — header + detil satu invoice */
    function get()
    {
        $id = $this->input->get('id', TRUE);

        if ($id === NULL OR trim($id) === '')
        {
            $this->fail('Parameter id wajib diisi.', 422);
        }

        $header = $this->model_api_invoice->get_header($id);

        if ($header === NULL)
        {
            $this->fail('Invoice tidak ditemukan.', 404);
        }

        $header['detil'] = $this->model_api_invoice->get_lines($id);

        $this->ok($header);
    }

    /** GET invoice/search?q=...&limit=20 — pencarian ID/contractno/nama rekanan */
    function search()
    {
        $q     = $this->input->get('q', TRUE);
        $limit = $this->input->get('limit', TRUE);

        if ($q === NULL OR trim($q) === '')
        {
            $this->fail('Parameter q wajib diisi.', 422);
        }

        $rows = $this->model_api_invoice->search($q, ($limit !== NULL ? (int) $limit : 20));

        if ($rows === NULL OR count($rows) === 0)
        {
            $this->fail('Invoice tidak ditemukan.', 404);
        }

        $this->ok($rows);
    }
}
