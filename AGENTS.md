# IPRO — Catatan Pengetahuan untuk AI/Agent

> Dokumen internal, ditulis untuk memberi konteks cepat kepada AI agent / developer baru.
> Terakhir diperbarui: Oktober 2026.
> Tidak perlu membaca seluruh codebase — dokumen ini dirangkum dari analisis penuh (lihat bagian "Statistik" untuk angka aktual).

---

## 1. Apa Aplikasi Ini

**IPRO** = aplikasi billing / ERP untuk pengelolaan properti (mall/transmart) dan utility.
Nama internal database: `e-frm3-tsm-cibubur` (lihat juga varian region lain di komentar `application/config/database.php`).

Domain yang dicakup:

- **Perizinan & kontrak tenant** — LOO (Letter of Offer), LOC, Agreement (memakai stored procedure SQL Server)
- **Billing & invoice** — invoicing (proforma, monthly, region-specific: cibubur/makassar/surabaya), invoice discount, faktur, pajak keluaran
- **Pembayaran** — schedule_payment, payment_history, refund (deposit/alokasi/tenant), writeoff, orunallocate
- **Aging & reporting** — aging, report_ar, rpt_kartupiutang, soa, summaryinvoice, smreport, dsb.
- **Utility** — listrik / air / gas (per branch: listrik_tkm, listrikdo, air_transmart, ...)
- **Master data** — rekanan, branch, region, source_acc, program, user
- **Pajak** — faktur, downloadpajak, taxbranch, taxledger, taxnumber, orpajak, wapu
- **Admin** — user, userprogram, setting, logbook, backlog

## 2. Stack & Lingkungan

| Item | Nilai |
|---|---|
| Framework | CodeIgniter 3 (stock, belum diupgrade) |
| Arsitektur | HMVC via Wiredesignz Modular Extensions v5.5 (`application/third_party/MX/`) |
| Database | **Microsoft SQL Server** driver `sqlsrv` — bukan MySQL/MariaDB |
| Bahasa SQL | T-SQL (TOP, ROW_NUMBER() OVER, WITH CTE, CONVERT(VARCHAR,...,112), stored procedure) |
| PHP | Kode PHP 5-era, tanpa type hinting |
| PDF | mPDF (vendored di `third_party/mpdf/`), domPDF (boilerplate CI2-era) |
| Excel | PHPExcel (`application/libraries/Excel/`) — **EOL, harus diganti PhpSpreadsheet**; plus Spout, simplexlsxgen |
| Server | Laragon (dev, Windows), IIS (production, ada `web.config` root) |
| VCS | Git (repo diinisialisasi 2026) |

**Entry point** = `index.php` (stock CI3, unmodified). `ENVIRONMENT` default `'development'` jika `CI_ENV` tidak di-set → `display_errors=1`.

## 3. Statistik Codebase (terukur)

- 197 modul di `application/modules/`
- 2.309 file PHP di modules (±1,19 juta baris): 1.649 view / 370 controller / 252 model
- Distribusi LOC: **view 72%** — view monolitik (HTML + CSS + JS inline per halaman)
- 991 file (43%) byte-identical duplikat → ±19 MB terbuang
- 8.556 pemanggilan `->query()` mentah; 379 pemakaian `addslashes()` (anggapan itu bisa mengamankan SQL — keliru)
- `html_escape()` = 0  •  `password_verify()` = 0  •  `session_regenerate_id()` = 0
- Test otomatis: 0. PHPUnit hanya tersedia via stock composer.json CI3, tidak diadopsi.

## 4. Arsitektur — Critical untuk Agent

### 4.1 HMVC
- Modul standar: `application/modules/<nama>/controllers/`, `models/`, `views/`
- **Tidak ada** `config/`, `helpers/`, `libraries/` di level modul (semua di `application/`)
- `application/core/` hanya 2 stub 191-byte: `MY_Router.php` & `MY_Loader.php` (passthru ke MX_Router/MX_Loader)
- Resolusi URL: `module/controller/method` atau `module/subdir/controller/method` — dikonfirmasi `MX/Router::locate()`

### 4.2 TIDAK ADA base controller / base model
- `extends CI_Controller` = 333 controller, `extends MX_Controller` = 37 (migrasi HMVC berhenti di tengah)
- **Tidak ada `MY_Controller.php`** — maknanya: AUTH & LAYOUT tidak ada di satu tempat
- Pattern konstruktor yang konsisten (370 controller):

```php
class Invoice extends CI_Controller {
    function __construct(){
        parent::__construct();
        check_user_login();                                // satu-satunya auth gate
        $this->load->model('model_invoice');
        $this->load->library('breadcrumbcomponent');
        $this->load->library('form_validation');
        $this->session->keep_flashdata('message');
    }
```

- Load model lintas modul pakai path relatif manual: `$this->load->model('login/mdl_login')`
- Layout: dua sistem bersamaan:
  - (a) include langsung: `$this->load->view('template/v_header')` + view modul + `('template/v_footer')`
  - (b) `Modules::run("templates/login_template", $data)` — hanya dipakai di login
- `modules/template/` berisi `models/master_m.php` + `views/v_header.php`, `v_footer.php` — layout global via include

### 4.3 Auth (pola yang ADA, bukan yang ideal)
- `check_user_login()` di `application/helpers/check_login_helper.php` — hanya cek `session userdata('logged_in')`
- Login di `modules/login/controllers/login.php` — password MD5 (`md5($password) == $user_password`, ada 30+ copy-paste di controller approval lain)
- Session data di-set: `username`, `user_fullname`, `user_level`, `branch_id`, `channel_id`, `logged_in`, `last_activity`
- ⚠️ **`user_level` disebut tapi TIDAK PERNAH dibaca** — tidak ada otorisasi per role/module di seluruh aplikasi
- Otorisasi "granular" sebenarnya hanya menu DB: `master_userprogramweb` / `master_groupweb` / `master_programweb` (dibaca via `lib_menu.php` & `util_helper.php`)
- Hook `Checksession` (application/hooks/checksession.php) **TIDAK AKTIF** — `application/config/hooks.php` masih kosong

### 4.4 Pola grid Data Tables (server-side)
- Setiap controller punya fungsi `initialize_grid($qry_alldata,$qry_filtered,$qry_totalall,$arcari,$cariOptional='')` — **di-copy-paste ke 329/370 controller**
- Konvensi model: method `qry_alldata()` / `qry_filtered()` / `qry_totalall()` (versi dialog: `*_dialog`)
- ⚠️ `initialize_grid` merakit `$sWhere` dari `$_POST['search']['value']` dengan `addslashes()` — **sumber SQLi yang diduplikasi 329×**

## 5. Configuration State (state penting)

`application/config/config.php`:
| Kunci | Nilai | Catatan |
|---|---|---|
| `base_url` | dinamis dari `$_SERVER` | auto-detect, aman lintas host |
| `index_page` | `'index.php'` | pretty URL OFF (no rewrite; web.config juga stock IIS) |
| `encryption_key` | `''` | **kosong — perlu diisi** |
| `sess_driver` | `files` | |
| `sess_save_path` | `sys_get_temp_dir()` | shared temp; better: custom path |
| `cookie_httponly` | default FALSE | perlu TRUE |
| `cookie_secure` | FALSE | perlu TRUE di produksi HTTPS |
| `csrf_protection` | **FALSE** | perlu TRUE |
| `log_threshold` | **0** | logging mati total — perlu ≥1 di produksi |
| `global_xss_filtering` | FALSE | benar (deprecated), tapi escaping output harus manual |

`application/config/database.php`:
- ⚠️ **Kredensial plaintext** (`hostname`, `username`, `password`, `database`) — termasuk akun `sa` SQL Server, plus banyak kredensial environment lain sebagai komentar. JANGAN pernah print value ini ke user/export; referensi saja file-nya.
- Aktif: group `default`, host `172.21.8.102,1433`, db `e-frm3-tsm-cibubur`, driver `sqlsrv`
- `save_queries = TRUE` — pada query count 8.500+ ini membebani memori jika nanti di-set produksi; pertimbangkan FALSE
- `.gitignore` sudah mencantumkan `application/config/database.php` (tidak boleh berubah makna)

`application/config/routes.php`:
- Hanya 3 baris aktif: `default_controller`=`login`, `404_override`='', `translate_uri_dashes`=FALSE
- Tidak ada allowlist → **semua 197 modul bisa diakses via URL**, termasuk semua varian arsip `_old`/`_bak`/`__`

`application/config/autoload.php`:
- libraries: `database, session, custom_constants, custom_templates, pagination`
- helpers: `url, form, text, string, util_helper, util_menu_helper, util_print, check_login`
- config & model: kosong

## 6. Konvensi Nama & Pola yang Dipakai

- Nama modul: lowercase, underscore. Prefix `-`/`--`/`___`/suffix `_`/`_old`/`_bak`/` copy`/angka = **marker siklus hidup**, bukan nama fungsional.
  - prefix `__` = pra-arsip; suffix `_`/angka = post-fork per client/region; `_old`/`_bak` = backup in-place.
  - Contoh: `aging` punya 5 implementasi siap pakai yang hidup bersamaan (`aging`, `aging2`, `agingx`, `agingnew`, `aging_inv`). `invoicing` punya 8 varian, hampir identik (84 file sama, 69 identical byte-per-byte dengan `invoicing_`).
- Nama model TIDAK seragam: `Model_invoice`, `model_invoice`, `Model_dashboard`, `mdl_login`, `master_m`, `model_aging_cl` (suffix peran/region)
- Naming gaya campur Indonesia/Inggris di satu kelas: `globalsearch_list`, `controler_gridlist` (typo `controler`), `$angka1`, `$nonum`, `$vclose`, `$rkn`
- Indentasi pakai tab (dari `.editorconfig`), bukan PSR-2 (4 spasi). Style Allman campur.
- Visibility method: mayoritas `function` tanpa `public` (±15.919 vs 1.358 `public function`)
- Helper string generator ID di `util_helper.php`: `generate_id_int`, `get_one_id`, `gen_id_loo`, `gen_id_conf`, `gen_id_agree`, `update_looid`, `Terbilang`, `number_to_words`
- Konstanta app di `application/libraries/custom_constants.php` (autoload sebagai library): `login_page_url`, `admin_page_url='dashboard'`, `logout_url`, dsb. **90% isi file ini vestigial** (constants belum dipakai; sisa starter kit, ada `const main_site_url = "http://lewnelson.com"`)

## 7. Checklist Masalah (Known Issues)

Urut berdasarkan severity, semuanya **masih terbuka** (belum difix):

1. **[KRITIS] Tidak ada authorization layer** — cek bagian 4.3. Setiap user login bisa panggil endpoint mana pun.
2. **[KRITIS] Password hash bocor ke browser** — `modules/user/controllers/user.php:216` mengirim `user_password` di JSON DataTables. HAPUS baris itu (fix 1 baris).
3. **[KRITIS] Password plaintext & MD5** — `model_user.php:364` insert POST password langsung; login pakai `md5()` + `==` (bukan `password_verify`).
4. **[KRITIS] SQL injection** — template `$where = "... LIKE '%$search%' ..."` + string concat; juga SP call dari POST: `EXEC [lm03_TrnAgreement_Update] '$_createby', ...`. **Tetap ini tidak memakai binding.** 379× `addslashes()` salah dipakai sebagai defense.
5. **[KRITIS] XSS tersimpan** — ±17.999 output mentah `$var` di view tanpa `html_escape()`; justru ada 14× `htmlspecialchars_decode`.
6. **[KRITIS] Kredensial plaintext** — `database.php` (lihat §5).
7. **[TINGGI] File upload tanpa validasi** — modul generasi lama (prefix `__`): `move_uploaded_file($_FILES[...], FCPATH.'/assets/uploads/'.$Name)` dengan nama file yang dikontrol penyerang. Modul baru (`upload/controllers/uploaddoc.php`) sudah benar pakai allowlist CI `pdf|jpg|png`.
8. **[TINGGI] Session fixation** — `session_regenerate_id()` = 0. Fix: tambahkan di login sukses.
9. **[SEDANG] CSRF off, encryption_key kosong, log_threshold 0** (lihat §5).
10. **[SEDANG] Brute force tidak diimplementasi** — `num_login_attempts`, `black_list_timeout` didefinisikan di `custom_constants.php` tapi 0 pemakaian.
11. **[SEDANG] Environment default `development`** (stack trace exposed bila `CI_ENV` tidak di-set).
12. **[SEDANG] Duplicate & arsip** — 991 file (43%) byte-identical; 50+ folder varian (`__*`, `_*`, `*_old`, `*_bak`, `* copy`, angka). Semuanya tetap routable karena routes.php kosong.
13. **[RENDA] Dead code** — hook `Checksession` tidak pernah dieksekusi; `Welcome.php` di controllers root sisa default; file `.bak`/tanggal nyasar di `helpers/`; 21 archive `.7z/.zip` di modules; `PHPExcel` EOL.

## 8. Yang TIDAK Perlu Diubah / Yang Benar

- **Transaksi database disiplin** — 376 `trans_begin` / 371 `trans_rollback` / 365 `trans_commit`. Ini praktik yang bagus, pertahankan.
- **Nol command injection / deserialization** — tidak ada `eval`, `unserialize`, `exec`, `shell_exec`, `system`, `assert`, `proc_open`. (Validasi sendiri sebelum refactor.)
- Logika bisnis ditulis ke stored procedure SQL Server — perilaku `lm03_*` dll. jangan diubah tanpa review kolom-ke-kolom.
- Modul `upload` versi baru sudah pola benar.
- `.gitignore` sudah benar (database.php ke-list).

## 9. Roadmap yang Sudah Disepakati (JANGAN diubah urutannya)

Urutan sebelumnya (lihat juga `todo.md` untuk task spesifik cancel invoice jurnal):

1. **[HARI INI] Non-invasif (1-2 baris)**
   - Hapus baris hash password ke JSON (`user.php:216`)
   - `ENVIRONMENT=production`, isi `encryption_key`, `cookie_httponly=TRUE`, `log_threshold=1`
   - Rotasi kredensial `sa` + remove komentar password lama di `database.php`
2. **[MINGGU INI] Base controller**
   - Buat `application/core/MY_Controller.php`:
     - enforce `user_level` dari session + scoping branch/region
     - load view header/footer otomatis (lihat bagian 4.2 pattern)
   - Migrasi bertahap controller inheritance (`CI_Controller` → `MY_Controller`)
   - `session_regenerate_id(true)` di login sukses
3. **[MINGGU INI] Evidence-based report**
   - Rapikan HANYA folder varian `_old`/`_bak`/`__` (cek dulu apakah masih dirujuk) — JANGAN hapus pada commit ini; pindah ke luar webroot dulu / rename ke `__archive_`
4. **[SPRINT] Refactor bertahap**
   - Ekstrak `initialize_grid()` ke satu tempat (base controller / library) — menghapus ±18.000 baris duplikat + menutup 329 salinan SQLi sekaligus
   - Ganti `md5` + `==` → `password_verify()`; migrasi hash saat user login sukses (dual-check sementara)
   - Buat allowlist route di `routes.php`
5. **[SPRINT lanjut] Upgrades**
   - PHPExcel → PhpSpreadsheet (PHPExcel EOL sejak 2017)
   - Helper escaping tunggal + backfill sink terparah (mulai dari view file terbesar)
6. **[JANGAN SEBELUM #4] Hapus** modul varian setelah route allowlist aktif → menghemat ±19 MB

## 10. Panduan kerja untuk Agent

- **Jangan pernah print kredensial** dari `application/config/database.php`.
- **Jangan hapus folder modul** tanpa konfirmasi user (bisa jadi masih routable — lihat §7 #12).
- Modifikasi per-file di `modules/` harus **mempertahankan pattern yang dipakai file tetangganya** (cek §6), jangan gaya sendiri.
- **Hindari menjadikan refactor gigantik tanpa test.** Tidak ada test suite; selalu tambahkan minimal PHPUnit di model transaksi (`agreement`, `jvoucher`, `schedule_payment`) SEBELUM mengubahnya.
- Target SQL adalah **T-SQL**, bukan MySQL — jangan pakai backtick, `LIMIT`, `NOW()`, `IFNULL`.
- Referensi view lintas-modul Resolve relatif modul: `MX/Loader.php:299` prepend path view.
- Backup file lama: `application/helpers/util_helper.22032019` & `util_helper.bak-18032019` — tidak di-autoload (bukan .php), jadi aman diabaikan.

## 11. File Kunci (Path Referensi Cepat)

| Kebutuhan | Path |
|---|---|
| Entry point | `index.php` |
| Routing | `application/config/routes.php` |
| DB config | `application/config/database.php` |
| App config | `application/config/config.php` |
| Autoload | `application/config/autoload.php` |
| Auth helper | `application/helpers/check_login_helper.php` |
| Util (ID generator, dll) | `application/helpers/util_helper.php` |
| Konstanta | `application/libraries/custom_constants.php` |
| Templates menu/library | `application/libraries/custom_templates.php`, `lib_menu.php` |
| HMVC core | `application/third_party/MX/` |
| Stub core | `application/core/MY_Loader.php`, `application/core/MY_Router.php` |
| Modul besar | `modules/invoicing/` (116 KB invoice controller), `modules/agreement/` |
| Layout view | `modules/template/views/v_header.php`, `v_footer.php` |
| **Modul API (baru, Okt 2026)** | `modules/api/` + dokumentasi `modules/api/README.md` |
| TODO spesifik | `todo.md` (root) |

## Modul API v1 (read-only + auth user) — Okt 2026

Modul `application/modules/api/` — API server-to-server self-contained, SEMUA file di dalam folder modul (konstrain deployment: hanya folder `modules/` yang boleh di-copy ke produksi).

- **Auth 2 lapis**: TRANSPORT = HMAC-SHA256 (`X-Api-Key` + `X-Timestamp` ±300 s + `X-Signature` atas string `METHOD|REQUEST_URI|API_KEY|TIMESTAMP|SHA256(body)`, key/secret di tabel `api_client`); IDENTITY = `auth/login` (username+password vs `master_user`, MD5 legacy, cek `user_isdisabled`) menerbitkan Bearer token (tabel `api_token`, TTL 24 jam, hanya SHA-256 di DB).
- **Endpoint**: `ping`, `auth/login|me|logout` (POST login/logout), `tenant/get|search`, `invoice/get|search` — method tak-kenal di read-only → 405.
- **DB baru (sudah dieksekusi di `e-frm3-tsm-cibubur`)**: `api_client`, `api_log`, `api_token` via `modules/api/sql/{001,002}*.sql` (idempotent). Dev key/secret & user test (`apitest_user`) sudah dibuat & dihapus lagi — login flow ditest 12/12 PASS.
- **Base class** `modules/api/libraries/Api_controller.php` (require_once manual) — `$require_token = TRUE` dgn endpoint butuh user; atau panggil `$this->_bearer()` manual.
- **Signature v2 mencakup SHA-256 body** — body POST tidak bisa ditamper dalam window replay. GANTI URL/secret = GANTI juga string-to-sign di semua client.
- **CORS otomatis dari `base_url` aplikasi** + `api_cors_extra_origins` jika perlu.
- **Semua query pakai binding `?`**; password tidak pernah terlog.
- Postman: `modules/api/postman/ipro-api-v1.postman_collection.json` (script pre-request hitung HMAC+body hash; login menyimpan `apiToken` otomatis). **Gotcha yang sudah ditangani script**: `pm.request.body.raw` masih template `{{var}}` (diresolve manual) + normalisasi CRLF→LF (server juga normalisasi). Error "Signature tidak valid" di Postman hampir selalu berarti collection LAMA (skema tanpa body-hash) — minta re-import.
- Contoh client PHP + troubleshooting ada di `modules/api/README.md`
