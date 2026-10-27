# IPRO API v1 — Modul API (read-only + auth user)

Modul API self-contained: **semua file ada di folder `modules/api/` ini** — tidak
mengubah `application/config/`, `routes.php`, `autoload.php`, `core/` maupun
folder lain. Deploy = copy folder ini (+ eksekusi SQL di bawah).

## Endpoint

| Endpoint | Method | Bearer? | Keterangan |
|---|---|---|---|
| `index.php/api/v1/ping` | GET | – | tes koneksi + verifikasi kunci transport |
| `index.php/api/v1/auth/login` | POST | – | {username,password} → Bearer token |
| `index.php/api/v1/auth/me` | GET | **wajib** | profil user dari token |
| `index.php/api/v1/auth/logout` | POST | **wajib** | revoke token |
| `index.php/api/v1/tenant/get?id=` | GET | – | detail tenant (rekanantype_id=105) |
| `index.php/api/v1/tenant/search?q=&limit=` | GET | – | cari tenant LIKE |
| `index.php/api/v1/invoice/get?id=` | GET | – | header+detil invoice (schedulepayment) |
| `index.php/api/v1/invoice/search?q=&limit=` | GET | – | cari invoice LIKE |

## Auth dua lapis

### Lapis 1 — TRANSPORT (wajib semua endpoint)
Identitas perangkat/broker, bukan user. Header:

| Header | Isi |
|---|---|
| `X-Api-Key` | `api_client.api_key` |
| `X-Timestamp` | Unix epoch detik, toleransi ±300 s |
| `X-Signature` | hex lowercase HMAC-SHA256 (lihat string-to-sign) |

**String-to-sign (v2 — sejak auth diveril):**

```
METHOD|REQUEST_URI|API_KEY|TIMESTAMP|SHA256(body)
```

- `METHOD` uppercase; `REQUEST_URI` = persis `$_SERVER['REQUEST_URI']` (path+query).
- Bagian ke-5 = SHA-256 hex dari body mentah (raw bytes) — **GET (body kosong)**
  tetap `e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855`
  (`sha256('')`). Ini mencegah body POST ditamper dalam window replay.
- **Normalisasi**: body `CRLF` dinormalkan ke `LF` sebelum di-hash (server DAN
  script Postman melakukannya sama-sama — body identik berline-ending beda tetap cocok).
- **Gotcha Postman**: `pm.request.body.raw` masih berisi template `{{var}}`
  sedangkan yang dikirim adalah nilai hasil substitusi — script di collection
  sudah me-resolve manual, jadi pastikan memakai collection **versi baru**.
- `signature = hash_hmac('sha256', string_to_sign, api_secret)`

### Lapis 2 — IDENTITY (endpoint `auth/*` + endpoint yang memerlukan user)
`auth/login` memvalidasi username+password dari `master_user`
(hash **MD5 legacy**, konsisten dengan login web) lalu menerbitkan token:

```
Authorization: Bearer <token>
```

- Token plaintext HANYA dikembalikan sekali di respon login; di DB tersimpan
  SHA-256 (`api_token.token_hash`).
- TTL default 24 jam (`api.token_ttl_seconds` di config modul). `me`/`logout`
  memperbarui `last_used_at`, TTL tidak sliding.
- Multi token per user diperbolehkan (logout module satu token tidak ikut-ikut
  revoke token milik device lain).
- Token non valued setelah `logout` (revoked) atau lewat `expires_at`.
- Perbaikan dari login web legacy: API menolak user `user_isdisabled = 1`.

## Setup database (sekali, idempotent)

1. `sql/001_api_tables.sql` — tabel `api_client` + `api_log` + seed client.
2. `sql/002_api_token.sql` — tabel `api_token` (token user).
3. Kredensial: `SELECT api_key, api_secret FROM api_client WHERE is_active = 1;`

## CORS

Semata dari `base_url` aplikasi (`application/config/config.php`) — origin
`scheme://host[:port]` base_url otomatis diizinkan. Kalau perlu lagi,
tambahkan di `config/api_config.php` `$config['api_cors_extra_origins']`.

## Contoh client PHP (server-to-server, termasuk login)

```php
<?php
$BASE     = 'https://TARGET/ipro';
$API_KEY  = 'xx-accesss';
$SECRET   = 'xx-secret';

function call_ipro($path, $method = 'GET', $body = null, $token = null)
{
    global $BASE, $API_KEY, $SECRET;
    $ts  = time();
    // REQUEST_URI server = path relatif aplikasi; sesuaikan bila base beda
    $uri = '/ipro/index.php'.$path;
    $raw = $body !== null ? json_encode($body) : '';
    $sig = hash_hmac('sha256',
        strtoupper($method).'|'.$uri.'|'.$API_KEY.'|'.$ts.'|'.hash('sha256', $raw),
        $SECRET);

    $headers = array(
        'X-Api-Key: '.$API_KEY,
        'X-Timestamp: '.$ts,
        'X-Signature: '.$sig,
        'Content-Type: application/json',
    );
    if ($token) $headers[] = 'Authorization: Bearer '.$token;

    $ch = curl_init($BASE.$path);
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => $method,
        CURLOPT_POSTFIELDS     => ($method === 'GET' ? array() : $raw),
        CURLOPT_HTTPHEADER     => $headers,
    ));
    return json_decode(curl_exec($ch), true);
}

// 1) login → Bearer token
$login = call_ipro('/api/v1/auth/login', 'POST',
    array('username' => 'demo', 'password' => '...'));
$token = $login['data']['token'];

// 2) pakai token di endpoint user-specific
$me = call_ipro('/api/v1/auth/me', 'GET', null, $token);

// 3) logout (revoke token)
call_ipro('/api/v1/auth/logout', 'POST', array(), $token);
```

Atau langsung ke Postman: import `postman/ipro-api-v1.postman_collection.json`
(script Pre-request hitung HMAC+body hash otomatis; login menyimpan
`apiToken` ke variable collection).

## Troubleshooting

| HTTP | Arti | Tipikal penyebab |
|---|---|---|
| 401 | header kurang / salah format | lupa salah satu header transport |
| 401 | timestamp di luar ±300 s | jam client vs server beda (W32time/VM) |
| 401 | signature tidak valid | REQUEST_URI/scret tidak persis; body POST berubah setelah sign; sha256('') salah |
| 401 | Token tidak valid/kadaluwarsa/revoke | Bearer kedaluwarsa (24 jam) atau sudah logout |
| 405 | metode tak diberi izin | POST/DELETE di endpoint read-only |
| 422 | parameter wajib kosong | `id`/`q` tidak dikirim, body login kosong |
| 429 | rate limit | > rate_limit_per_minute dalam 60 detik (semua attempt dihitung) |
| 500 | "script SQL belum dieksekusi" | `api_client`/`api_log`/`api_token` belum ada |

## Desain, keamanan & batasan

- **Rate limit** : `api_log` 60 detik rolling, semua attempt (termasuk gagal) dihitung.
- **Log** ke `api_log` karena `log_threshold` app = 0. **Password tidak pernah terlog** (body tidak dilog).
- **Query semua binding `?`** — melanggar pattern concat lama, sesuai AGENTS.md.
- **Flashpoint** : HTTP error 404 bawaan CI (page HTML) untuk method tak dikenal = acceptable v1.
- **HTTPS** wajib bila lewat internet — HMAC menangkal tamper/replay tapi tidak mengenkripsi.
- `user_isdisabled` kini dicek pada login API (login web legacy belum).

## Peta file modul

```
modules/api/
├── config/api_config.php                 # setting modul (tanpa secret)
├── controllers/v1/{ping,tenant,invoice,auth}.php
├── helpers/api_response_helper.php       # api_output()
├── libraries/Api_controller.php          # base: HMAC + body-hash + Bearer + log
├── models/{model_api_client,model_api_log,model_api_auth,model_api_tenant,model_api_invoice}.php
├── postman/ipro-api-v1.postman_collection.json
└── sql/{001_api_tables,002_api_token}.sql
```
