<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * Ping endpoint — uji tangan cepat + verifikasi kunci.
 *
 * URL : index.php/api/v1/ping
 * Respon data: { server_time, server_date, client_name, rate_limit }
 */

if ( ! class_exists('Api_controller'))
{
    require_once APPPATH.'modules/api/libraries/Api_controller.php';
}

class Ping extends Api_controller {

    /** GET ping — auth wajib, tanpa akses data bisnis. */
    function index()
    {
        $this->ok(array(
            'server_time'       => date('H:i d-m-y'),
            'server_epoch'      => time(),
            'client_name'       => $this->client['client_name'],
            'rate_limit_per_min'=> (int) $this->client['rate_limit_per_minute'],
            'api_name'          => config_item('api_name'),
            'api_version'       => config_item('api_version'),
        ));
    }
}
