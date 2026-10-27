<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * API v1 — endpoint TENANT.
 *
 * URL : index.php/api/v1/tenant/get?id=<rekanan_id>
 *       index.php/api/v1/tenant/search?q=<keyword>&limit=20
 *
 * Wajib header auth (lihat modules/api/README.md):
 *   X-Api-Key, X-Timestamp, X-Signature
 */

if ( ! class_exists('Api_controller'))
{
    require_once APPPATH.'modules/api/libraries/Api_controller.php';
}

class Tenant extends Api_controller {

    function __construct()
    {
        // parent::__construct() menjalankan CORS + method check + auth + rate limit
        parent::__construct();

        $this->load->model('model_api_tenant');
    }

    /** GET tenant/get?id=... — detail satu tenant */
    function get()
    {
        $id = $this->input->get('id', TRUE);

        if ($id === NULL OR trim($id) === '')
        {
            $this->fail('Parameter id wajib diisi.', 422);
        }

        $data = $this->model_api_tenant->get_by_id($id);

        if ($data === NULL)
        {
            $this->fail('Tenant tidak ditemukan.', 404);
        }

        $this->ok($data);
    }

    /** GET tenant/search?q=...&limit=20 — pencarian LIKE */
    function search()
    {
        $q     = $this->input->get('q', TRUE);
        $limit = $this->input->get('limit', TRUE);

        if ($q === NULL OR trim($q) === '')
        {
            $this->fail('Parameter q wajib diisi.', 422);
        }

        $rows = $this->model_api_tenant->search($q, ($limit !== NULL ? (int) $limit : 20));

        if ($rows === NULL OR count($rows) === 0)
        {
            $this->fail('Tenant tidak ditemukan.', 404);
        }

        $this->ok($rows);
    }
}
