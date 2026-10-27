<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * Helper respons API modul api (read-only).
 * Dimuat via MX_Loader: $this->load->helper('api_response')
 * -> modules/api/helpers/api_response_helper.php
 */

if ( ! function_exists('api_output'))
{
    /**
     * Kirim respons JSON konsisten dan hentikan eksekusi.
     *
     * @param string|null $message pesan singkat untuk client
     * @param int         $http    kode HTTP
     * @param mixed       $data    payload di key 'data'
     */
    function api_output($message, $http = 200, $data = NULL)
    {
        http_response_code($http);
        header('Content-Type: application/json; charset=utf-8');
        header('X-Content-Type-Options: nosniff');

        echo json_encode(array(
            'ok'      => ($http >= 200 && $http < 300),
            'message' => $message,
            'data'    => $data,
        ), JSON_UNESCAPED_UNICODE);

        exit(EXIT_SUCCESS);
    }
}
