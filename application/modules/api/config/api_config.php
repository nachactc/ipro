<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/*
 * Konfigurasi modul API v1.
 *
 * File ini berada di dalam modul — dimuat via MX_Loader dari folder
 * modul aktif (modules/api/config), TIDAK perlu mengubah
 * application/config/autoload.php maupun routes.php.
 *
 * PENTING: file ini TIDAK menyimpan secret. Secret tiap client
 * disimpan di tabel api_client, token user di tabel api_token,
 * sehingga rotasi cukup lewat SQL, bukan edit file.
 */

$config['api_name']                = 'IPRO API';
$config['api_version']             = '1.0';
$config['api_env']                 = 'v1';

/* Toleransi timestamp request terhadap jam server (detik).
   Bila melebihi, request ditolak 401 — anti replay. */
$config['api_timestamp_tolerance'] = 300;

/* Rate limit default (request/menit) bila kolom
   api_client.rate_limit_per_minute NULL/0. */
$config['api_default_rate_limit']  = 60;

/* Umur Bearer token user dari auth/login (detik). Default 24 jam. */
$config['api_token_ttl_seconds']   = 86400;

/* CORS dikaitkan ke base_url aplikasi (config utama CI) secara otomatis:
   origin = scheme://host[:port] milik base_url.
   Bila butuh origin TAMBAHAN (mis. portal lain yang memanggil API ini),
   isi di sini. array('*') = izinkan semua (HANYA dev/testing).
   Kosongkan di produksi. */
$config['api_cors_extra_origins']  = array('*');
