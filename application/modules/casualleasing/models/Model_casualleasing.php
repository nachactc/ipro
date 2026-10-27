<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Casual Leasing (CL)
 * Semua data disimpan di tabel berprefix cl_ (terpisah dari data ipro).
 */
class Model_casualleasing extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /** Cache pemeriksaan kolom; dipakai agar kode tetap aman sebelum migrasi 05a. */
    private $_schema_cols = array();

    private function _has_col($table, $column) {
        $key = $table . '.' . $column;
        if (array_key_exists($key, $this->_schema_cols)) { return $this->_schema_cols[$key]; }
        $q = $this->db->query("SELECT COL_LENGTH('dbo." . str_replace("'", "''", $table) . "','" . str_replace("'", "''", $column) . "') AS l");
        $r = $q ? $q->row() : null;
        $this->_schema_cols[$key] = ($r && $r->l !== null);
        return $this->_schema_cols[$key];
    }

    function has_week_columns() {
        return $this->_has_col('cl_unit', 'w1') && $this->_has_col('cl_unit', 'w4');
    }

    function has_lokasi_capacity() {
        return $this->_has_col('cl_lokasi', 'lokasi_nla');
    }

    /** Cache pemeriksaan tabel; aman sebelum migrasi 06. */
    private $_schema_tables = array();

    private function _table_exists($table) {
        if (array_key_exists($table, $this->_schema_tables)) { return $this->_schema_tables[$table]; }
        $q = $this->db->query("SELECT OBJECT_ID('dbo." . str_replace("'", "''", $table) . "','U') AS o");
        $r = $q ? $q->row() : null;
        $this->_schema_tables[$table] = ($r && $r->o !== null);
        return $this->_schema_tables[$table];
    }

    /** Master unit + relasi unit_master_id sudah tersedia (migrasi 06). */
    function has_unit_master() {
        return $this->_table_exists('cl_unit_master') && $this->_has_col('cl_unit', 'unit_master_id');
    }

    /**
     * Nilai W1..W4 untuk satu unit.
     * Sebelum migrasi, nilai prospek lama dipetakan ke kolom week_target.
     */
    private function _week_values($u) {
        $w = array('w1' => 0, 'w2' => 0, 'w3' => 0, 'w4' => 0);
        if (isset($u['w1']) || isset($u['w2']) || isset($u['w3']) || isset($u['w4'])) {
            foreach ($w as $k => $v) { $w[$k] = isset($u[$k]) ? (float)$u[$k] : 0; }
        }
        $sum = $w['w1'] + $w['w2'] + $w['w3'] + $w['w4'];
        $prospek = isset($u['prospek']) ? (float)$u['prospek'] : 0;
        if ($sum <= 0 && $prospek > 0) {
            $wk = strtolower((string)(isset($u['week_target']) ? $u['week_target'] : ''));
            if (in_array($wk, array('w1', 'w2', 'w3', 'w4'), true)) {
                $w[$wk] = $prospek;
            } else {
                $w['w1'] = $prospek;
            }
        }
        return $w;
    }

    /** Lengkapi baris unit dengan W1..W4 dan prospek hasil jumlah kolom. */
    private function _normalize_unit($u) {
        $w = $this->_week_values($u);
        $u['w1'] = $w['w1']; $u['w2'] = $w['w2']; $u['w3'] = $w['w3']; $u['w4'] = $w['w4'];
        $u['prospek'] = $w['w1'] + $w['w2'] + $w['w3'] + $w['w4'];
        $weeks = array();
        foreach (array('w1' => 'W1', 'w2' => 'W2', 'w3' => 'W3', 'w4' => 'W4') as $k => $label) {
            if ($u[$k] > 0) { $weeks[] = $label; }
        }
        $u['week'] = implode(', ', $weeks);
        if (array_key_exists('periode_type', $u)) {
            $pt = strtoupper(trim((string)$u['periode_type']));
            if ($pt === '6 MONTHLY') { $pt = '6 MONTHS'; } // koreksi nilai legacy
            $u['periode_type'] = $pt;
        }
        return $u;
    }

    private function _first_week($w) {
        foreach (array('w1' => 'W1', 'w2' => 'W2', 'w3' => 'W3', 'w4' => 'W4') as $k => $label) {
            if ((float)(isset($w[$k]) ? $w[$k] : 0) > 0) { return $label; }
        }
        return null;
    }

    // ==================================================================
    //  PERIODE
    // ==================================================================
    function get_periode_options() {
        $q = $this->db->query("SELECT periode_id, periode_name FROM cl_periode WHERE periode_isactive = 1 ORDER BY periode_id DESC");
        $ret = array();
        foreach ($q->result() as $r) { $ret[$r->periode_id] = $r->periode_name; }
        return $ret;
    }

    function get_active_periode() {
        $q = $this->db->query("SELECT TOP 1 periode_id FROM cl_periode WHERE periode_isactive = 1 ORDER BY periode_id DESC");
        $r = $q->row();
        return $r ? $r->periode_id : null;
    }

    function get_periode($periode_id) {
        $q = $this->db->query("SELECT * FROM cl_periode WHERE periode_id = " . $this->db->escape($periode_id));
        return $q->row_array();
    }

    // ==================================================================
    //  MASTER
    // ==================================================================
    function get_tipe_options() {
        $q = $this->db->query("SELECT tipe_id, tipe_name FROM cl_tipe WHERE tipe_isactive = 1 ORDER BY tipe_order, tipe_id");
        $ret = array();
        foreach ($q->result() as $r) { $ret[$r->tipe_id] = $r->tipe_name; }
        return $ret;
    }

    function get_lokasi_options($tipe_id = null) {
        $w = $tipe_id === null || $tipe_id === '' ? '' : " AND tipe_id = " . $this->db->escape($tipe_id);
        $cap = $this->has_lokasi_capacity()
            ? "lokasi_nla"
            : "CAST(0 AS decimal(18,2)) AS lokasi_nla";
        $q = $this->db->query("SELECT lokasi_id, tipe_id, lokasi_code, lokasi_name, $cap FROM cl_lokasi WHERE lokasi_isactive = 1 $w ORDER BY tipe_id, lokasi_order, lokasi_code");
        return $q->result_array();
    }

    function get_pic_options() {
        $q = $this->db->query("SELECT pic_id, pic_name FROM cl_pic WHERE pic_isactive = 1 ORDER BY pic_id");
        $ret = array();
        foreach ($q->result() as $r) { $ret[$r->pic_id] = ($r->pic_name != '' ? $r->pic_name : $r->pic_id); }
        return $ret;
    }

    function get_pic_list() {
        return $this->db->query("SELECT * FROM cl_pic ORDER BY pic_id")->result_array();
    }

    // ==================================================================
    //  MASTER UNIT (unit fisik + NLA)
    // ==================================================================
    private function _capacity_select() {
        return $this->has_lokasi_capacity()
            ? 'l.lokasi_nla AS lokasi_nla'
            : 'CAST(0 AS decimal(18,2)) AS lokasi_nla';
    }

    function get_unit_master_list($filters = array()) {
        if (!$this->has_unit_master()) { return array(); }

        $this->db->select("m.*, l.tipe_id, l.lokasi_code, l.lokasi_name, l.lokasi_order, " . $this->_capacity_select() . ", t.tipe_name, t.tipe_order,
            (SELECT COUNT(*) FROM cl_unit u WHERE u.unit_master_id = m.unit_master_id) AS budget_count", false);
        $this->db->from('cl_unit_master m');
        $this->db->join('cl_lokasi l', 'l.lokasi_id = m.lokasi_id', 'left');
        $this->db->join('cl_tipe t', 't.tipe_id = l.tipe_id', 'left');

        if (!empty($filters['lokasi_id'])) {
            $this->db->where('m.lokasi_id', (int)$filters['lokasi_id']);
        }
        if (isset($filters['isactive']) && $filters['isactive'] !== '') {
            $this->db->where('m.unit_isactive', (int)$filters['isactive']);
        }
        if (!empty($filters['q'])) {
            $q = trim((string)$filters['q']);
            $this->db->group_start()
                ->like('m.unit_name', $q)
                ->or_like('l.lokasi_code', $q)
                ->or_like('l.lokasi_name', $q);
            if (preg_match('/^\d+$/', $q)) { $this->db->or_where('m.unit_no', (int)$q); }
            $this->db->group_end();
        }

        $this->db->order_by('t.tipe_order, l.lokasi_order, m.unit_no, m.unit_master_id');
        return $this->db->get()->result_array();
    }

    function get_unit_master_row($id) {
        if (!$this->has_unit_master()) { return null; }
        $sql = "SELECT m.*, l.tipe_id, l.lokasi_code, l.lokasi_name, l.lokasi_order, " . $this->_capacity_select() . ", t.tipe_name, t.tipe_order,
                       (SELECT COUNT(*) FROM cl_unit u WHERE u.unit_master_id = m.unit_master_id) AS budget_count
                FROM cl_unit_master m
                LEFT JOIN cl_lokasi l ON l.lokasi_id = m.lokasi_id
                LEFT JOIN cl_tipe t ON t.tipe_id = l.tipe_id
                WHERE m.unit_master_id = " . (int)$id;
        $q = $this->db->query($sql);
        return $q ? $q->row_array() : null;
    }

    /** Pilihan unit untuk form Budget. Unit nonaktif tetap disertakan bila sedang diedit. */
    function get_unit_master_options($include_id = 0) {
        if (!$this->has_unit_master()) { return array(); }
        $this->db->select("m.*, l.tipe_id, l.lokasi_code, l.lokasi_name, l.lokasi_order, " . $this->_capacity_select() . ", t.tipe_name, t.tipe_order", false);
        $this->db->from('cl_unit_master m');
        $this->db->join('cl_lokasi l', 'l.lokasi_id = m.lokasi_id', 'left');
        $this->db->join('cl_tipe t', 't.tipe_id = l.tipe_id', 'left');
        $this->db->group_start()
            ->where('m.unit_isactive', 1);
        if ((int)$include_id > 0) { $this->db->or_where('m.unit_master_id', (int)$include_id); }
        $this->db->group_end();
        $this->db->order_by('t.tipe_order, l.lokasi_order, m.unit_no, m.unit_master_id');
        return $this->db->get()->result_array();
    }

    function get_unit_master_by_locno($lokasi_id, $unit_no) {
        if (!$this->has_unit_master()) { return null; }
        $q = $this->db->query("SELECT * FROM cl_unit_master
                               WHERE lokasi_id = " . (int)$lokasi_id . "
                                 AND unit_no = " . (int)$unit_no);
        return $q ? $q->row_array() : null;
    }

    function next_unit_no($lokasi_id) {
        if (!$this->has_unit_master()) { return 1; }
        $q = $this->db->query("SELECT ISNULL(MAX(unit_no), 0) + 1 AS n
                               FROM cl_unit_master
                               WHERE lokasi_id = " . (int)$lokasi_id);
        $r = $q ? $q->row() : null;
        return $r ? (int)$r->n : 1;
    }

    /** Statistik per lokasi untuk form master unit: NLA terpakai, jumlah unit, no berikutnya. */
    function get_unit_master_stats() {
        if (!$this->has_unit_master()) { return array(); }
        $q = $this->db->query("SELECT lokasi_id,
                                      COUNT(*) AS unit_count,
                                      ISNULL(SUM(CASE WHEN unit_isactive = 1 THEN nla ELSE 0 END), 0) AS used_nla,
                                      ISNULL(MAX(unit_no), 0) AS max_no
                               FROM cl_unit_master
                               GROUP BY lokasi_id");
        $ret = array();
        foreach ($q->result_array() as $r) { $ret[(int)$r['lokasi_id']] = $r; }
        return $ret;
    }

    function get_unit_master_budgets($id) {
        if (!$this->has_unit_master()) { return array(); }
        $sql = "SELECT u.unit_id, u.periode_id, u.unit_status, u.tenant, u.budget, u.occupied, u.prospek,
                       u.periode_type, u.periode_start, u.periode_end, p.periode_name
                FROM cl_unit u
                LEFT JOIN cl_periode p ON p.periode_id = u.periode_id
                WHERE u.unit_master_id = " . (int)$id . "
                ORDER BY u.periode_id DESC, u.unit_id DESC";
        return $this->db->query($sql)->result_array();
    }

    /** @return true|string pesan error */
    function save_unit_master_row($id, $lokasi_id, $unit_no, $unit_name, $nla, $isactive) {
        if (!$this->has_unit_master()) {
            return 'Tabel master unit belum tersedia. Jalankan migrasi 06 terlebih dahulu.';
        }

        $id        = (int)$id;
        $lokasi_id = (int)$lokasi_id;
        $raw_no    = trim((string)$unit_no);
        $unit_name = trim((string)$unit_name);
        $nla       = $this->_num($nla);
        $isactive  = $isactive ? 1 : 0;

        $lokasi = $lokasi_id > 0 ? $this->get_lokasi_row($lokasi_id) : null;
        if (!$lokasi) { return 'Lokasi wajib dipilih.'; }
        if ($raw_no === '' || !preg_match('/^\d+$/', $raw_no)) {
            return 'No. unit wajib diisi dengan angka bulat lebih dari 0.';
        }
        $unit_no = (int)$raw_no;
        if ($unit_no <= 0) { return 'No. unit wajib diisi dengan angka lebih dari 0.'; }
        if ($unit_no > 2147483647) { return 'No. unit terlalu besar.'; }
        if ($unit_name === '') { return 'Nama unit wajib diisi.'; }
        if (function_exists('mb_strlen') && mb_strlen($unit_name) > 150) {
            return 'Nama unit maksimal 150 karakter.';
        }
        if ($nla < 0) { return 'NLA tidak boleh negatif.'; }

        if ($id > 0 && !$this->get_unit_master_row($id)) {
            return 'Unit tidak ditemukan.';
        }

        $q = $this->db->query("SELECT unit_master_id FROM cl_unit_master
                               WHERE lokasi_id = " . $lokasi_id . "
                                 AND unit_no = " . $unit_no . "
                                 AND unit_master_id <> " . $id);
        if ($q->num_rows() > 0) {
            return 'No. unit ' . $unit_no . ' sudah dipakai di lokasi ini.';
        }

        $cap = isset($lokasi['lokasi_nla']) ? (float)$lokasi['lokasi_nla'] : 0;
        if ($isactive && $cap > 0) {
            $q = $this->db->query("SELECT ISNULL(SUM(nla), 0) AS used
                                   FROM cl_unit_master
                                   WHERE lokasi_id = " . $lokasi_id . "
                                     AND unit_isactive = 1
                                     AND unit_master_id <> " . $id);
            $used = $q->row() ? (float)$q->row()->used : 0;
            if ($used + $nla > $cap + 0.005) {
                return 'Total NLA unit aktif (' . number_format($used + $nla, 2, '.', ',') .
                       ') melebihi kapasitas lokasi (' . number_format($cap, 2, '.', ',') . ' m2).';
            }
        }

        $username = $this->session->userdata('username');
        $now = date('Y-m-d H:i:s');
        $data = array(
            'lokasi_id'     => $lokasi_id,
            'unit_no'       => $unit_no,
            'unit_name'     => $unit_name,
            'nla'           => $nla,
            'unit_isactive' => $isactive
        );

        if ($id > 0) {
            $data['modifyby'] = $username;
            $data['modifydate'] = $now;
            $this->db->where('unit_master_id', $id);
            if (!$this->db->update('cl_unit_master', $data)) { return 'Gagal memperbarui master unit.'; }

            // Budget memakai identitas unit master; sinkronkan agar NLA/ARR tidak berbeda.
            $sync = array(
                'tipe_id'   => $lokasi['tipe_id'],
                'lokasi_id' => $lokasi_id,
                'unit_no'   => $unit_no,
                'unit_name' => $unit_name,
                'nla'       => $nla
            );
            $this->db->where('unit_master_id', $id);
            $this->db->update('cl_unit', $sync);
            return true;
        }

        $data['createby'] = $username;
        $data['createdate'] = $now;
        return $this->db->insert('cl_unit_master', $data) ? true : 'Gagal menyimpan master unit.';
    }

    /** Baris master unit aktif untuk ringkasan Budget. */
    function get_unit_master_summary_rows() {
        if (!$this->has_unit_master()) { return array(); }
        $sql = "SELECT m.unit_master_id, m.lokasi_id, m.unit_no, m.unit_name, m.nla, m.unit_isactive,
                       l.tipe_id, l.lokasi_code, l.lokasi_name, l.lokasi_order,
                       t.tipe_name, t.tipe_order
                FROM cl_unit_master m
                LEFT JOIN cl_lokasi l ON l.lokasi_id = m.lokasi_id
                LEFT JOIN cl_tipe t ON t.tipe_id = l.tipe_id
                WHERE m.unit_isactive = 1
                ORDER BY t.tipe_order, l.lokasi_order, m.unit_no, m.unit_master_id";
        return $this->db->query($sql)->result_array();
    }

    /** Cek apakah unit sudah punya budget pada periode tertentu. */
    function budget_unit_used($periode_id, $unit_master_id, $exclude_unit_id = 0) {
        if (!$this->has_unit_master()) { return false; }
        $q = $this->db->query("SELECT COUNT(*) AS c FROM cl_unit
                               WHERE periode_id = " . $this->db->escape($periode_id) . "
                                 AND unit_master_id = " . (int)$unit_master_id . "
                                 AND unit_id <> " . (int)$exclude_unit_id);
        $r = $q->row();
        return $r && (int)$r->c > 0;
    }

    // ==================================================================
    //  UNIT
    // ==================================================================
    function get_units($periode_id, $tipe = '', $lokasi_id = '', $status = '', $keyword = '') {
        $this->db->select('u.*, b.tipe_name, b.tipe_order, l.lokasi_code, l.lokasi_name, l.lokasi_order');
        $this->db->from('cl_unit u');
        $this->db->join('cl_tipe b', 'b.tipe_id = u.tipe_id');
        $this->db->join('cl_lokasi l', 'l.lokasi_id = u.lokasi_id');
        $this->db->where('u.periode_id', $periode_id);
        $this->db->where('u.unit_isactive', 1);
        if ($tipe !== '')      { $this->db->where('u.tipe_id', $tipe); }
        if ($lokasi_id !== '') { $this->db->where('u.lokasi_id', (int)$lokasi_id); }
        if ($status !== '')    { $this->db->where('u.unit_status', $status); }
        if ($keyword !== '') {
            $this->db->group_start()
                 ->like('u.unit_name', $keyword)
                 ->or_like('u.tenant', $keyword)
                 ->or_like('u.pic_id', $keyword)
                 ->or_like('l.lokasi_code', $keyword)
                 ->group_end();
        }
        $this->db->order_by('b.tipe_order, l.lokasi_order, u.unit_no, u.unit_id');
        $rows = $this->db->get()->result_array();
        foreach ($rows as &$row) { $row = $this->_normalize_unit($row); }
        unset($row);
        return $rows;
    }

    function get_unit($unit_id) {
        $q = $this->db->query("SELECT * FROM cl_unit WHERE unit_id = " . (int)$unit_id);
        $row = $q->row_array();
        return $row ? $this->_normalize_unit($row) : $row;
    }

    /** Detail unit + nama tipe/lokasi/PIC untuk halaman view. */
    function get_unit_detail($unit_id) {
        $q = $this->db->query("SELECT u.*, b.tipe_name, l.lokasi_code, l.lokasi_name, p.pic_name
                               FROM cl_unit u
                               LEFT JOIN cl_tipe b ON b.tipe_id = u.tipe_id
                               LEFT JOIN cl_lokasi l ON l.lokasi_id = u.lokasi_id
                               LEFT JOIN cl_pic p ON p.pic_id = u.pic_id
                               WHERE u.unit_id = " . (int)$unit_id);
        $row = $q->row_array();
        return $row ? $this->_normalize_unit($row) : $row;
    }

    /** Parser angka publik untuk validasi di controller. */
    function parse_number($v) {
        return $this->_num($v);
    }

    /** Normalisasi tanggal form (dd-mm-yyyy / yyyy-mm-dd) ke format SQL yyyy-mm-dd. */
    function parse_date($s) {
        $s = trim((string)$s);
        if ($s === '') { return null; }
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $s, $m)) {
            return checkdate((int)$m[2], (int)$m[3], (int)$m[1]) ? $s : null;
        }
        if (preg_match('/^(\d{1,2})[-\/.](\d{1,2})[-\/.](\d{4})$/', $s, $m)) {
            $d = (int)$m[1]; $mo = (int)$m[2]; $y = (int)$m[3];
            return checkdate($mo, $d, $y) ? sprintf('%04d-%02d-%02d', $y, $mo, $d) : null;
        }
        $t = strtotime($s);
        return $t ? date('Y-m-d', $t) : null;
    }

    function save_unit() {
        $username = $this->session->userdata('username');
        $now = date('Y-m-d H:i:s');
        $d = $this->_unit_post();
        $d['createby'] = $username;
        $d['createdate'] = $now;
        $this->db->insert('cl_unit', $d);
        return $this->db->insert_id();
    }

    function update_unit($unit_id) {
        $username = $this->session->userdata('username');
        $current = $this->get_unit($unit_id);
        if (!$current) { return false; }
        $d = $this->_unit_post();
        $d['occupied'] = (float)$current['occupied'];
        $d['modifyby'] = $username;
        $d['modifydate'] = date('Y-m-d H:i:s');
        $this->db->where('unit_id', (int)$unit_id);
        return $this->db->update('cl_unit', $d);
    }

    function delete_unit($unit_id) {
        $unit_id = (int)$unit_id;
        if ($unit_id <= 0) { return false; }
        $this->db->where('unit_id', $unit_id);
        $this->db->delete('cl_unit');
        return $this->db->affected_rows() > 0;
    }

    /** Pindahkan seluruh prospek (W1..W4) -> occupied dan ubah status menjadi OCCUPIED. */
    function set_occupied($unit_id) {
        $unit = $this->get_unit($unit_id);
        if (!$unit) { return false; }
        $occupied = (float)$unit['occupied'] + (float)$unit['prospek'];
        $data = array(
            'unit_status' => 'OCCUPIED',
            'occupied'    => $occupied,
            'prospek'     => 0,
            'modifyby'    => $this->session->userdata('username'),
            'modifydate'  => date('Y-m-d H:i:s')
        );
        if ($this->has_week_columns()) {
            $data['w1'] = 0; $data['w2'] = 0; $data['w3'] = 0; $data['w4'] = 0;
        } elseif ($this->_has_col('cl_unit', 'week_target')) {
            $data['week_target'] = null;
        }
        $this->db->where('unit_id', (int)$unit_id);
        return $this->db->update('cl_unit', $data);
    }

    /** Parsing angka: format #,##0.00 (1,429,022.08), format Indonesia (1.429.022,08), atau polos. */
    private function _num($v) {
        $v = str_replace(' ', '', trim((string)$v));
        if ($v === '') return 0.0;
        $lc = strrpos($v, ',');
        $ld = strrpos($v, '.');
        if ($lc !== false && $ld !== false) {
            if ($lc > $ld) {                       // 1.429.022,08 -> koma desimal
                $v = str_replace('.', '', $v);
                $v = str_replace(',', '.', $v);
            } else {                               // 1,429,022.08 -> titik desimal
                $v = str_replace(',', '', $v);
            }
        } elseif ($lc !== false) {
            if (preg_match('/^\d{1,3}(,\d{3})+$/', $v)) { $v = str_replace(',', '', $v); } // 1,429,022
            else { $v = str_replace(',', '.', $v); }                                     // 0,5
        } elseif (substr_count($v, '.') > 1) {     // 1.429.022 -> titik ribuan
            $v = str_replace('.', '', $v);
        }
        return (float)$v;
    }

    /** Ambil & bersihkan input form unit */
    private function _unit_post() {
        $f = function($k, $d = null) { $v = $this->input->post($k); return ($v === null || $v === '') ? $d : $v; };
        $n = function($k) { return $this->_num($this->input->post($k)); };

        $periode_type = $f('periode_type');
        if ($periode_type !== null) { $periode_type = strtoupper(trim((string)$periode_type)); }
        $ps = $this->parse_date($f('periode_start'));
        $pe = $this->parse_date($f('periode_end'));
        $periode_text = $this->_periode_text($ps, $pe);

        $w = array('w1' => $n('w1'), 'w2' => $n('w2'), 'w3' => $n('w3'), 'w4' => $n('w4'));
        $prospek = $w['w1'] + $w['w2'] + $w['w3'] + $w['w4'];
        $postedProspek = $n('prospek');

        $master = null;
        $unit_master_id = (int)$f('unit_master_id', 0);
        if ($this->has_unit_master() && $unit_master_id > 0) {
            $master = $this->get_unit_master_row($unit_master_id);
        }

        $data = array(
            'periode_id'   => $f('periode_id'),
            'tipe_id'      => $f('tipe_id'),
            'lokasi_id'    => (int)$f('lokasi_id', 0),
            'unit_no'      => ($f('unit_no') !== null) ? (int)$f('unit_no') : null,
            'unit_name'    => $f('unit_name', ''),
            'pic_id'       => $f('pic_id'),
            'nla'          => $n('nla'),
            'unit_status'  => strtoupper($f('unit_status', 'VACANT')),
            'tenant'       => $f('tenant'),
            'periode_type' => $periode_type,
            'periode_start'=> $ps,
            'periode_end'  => $pe,
            'periode_text' => $periode_text,
            'budget'       => $n('budget'),
            'occupied'     => 0,
            'prospek'      => $prospek > 0 ? $prospek : $postedProspek,
            'remarks'      => $f('remarks'),
            'unit_isactive'=> 1
        );

        // Bila memilih unit master, identitas + NLA selalu diambil dari master.
        if ($master) {
            $data['tipe_id']   = $master['tipe_id'];
            $data['lokasi_id'] = (int)$master['lokasi_id'];
            $data['unit_no']   = (int)$master['unit_no'];
            $data['unit_name'] = $master['unit_name'];
            $data['nla']       = (float)$master['nla'];
        }
        if ($this->_has_col('cl_unit', 'unit_master_id')) {
            $data['unit_master_id'] = $master ? (int)$master['unit_master_id'] : ($unit_master_id > 0 ? $unit_master_id : null);
        }

        if ($this->has_week_columns()) {
            $data['w1'] = $w['w1']; $data['w2'] = $w['w2'];
            $data['w3'] = $w['w3']; $data['w4'] = $w['w4'];
        } elseif ($this->_has_col('cl_unit', 'week_target')) {
            // Kompatibilitas sebelum migrasi: total tetap tersimpan, distribusi minggu pertama.
            $data['week_target'] = $this->_first_week($w);
        }
        return $data;
    }

    private function _periode_text($ps, $pe) {
        $bulan = array(1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des');
        $fmt = function($d) use ($bulan) {
            $t = strtotime($d);
            if (!$t) return null;
            return date('j', $t) . ' ' . $bulan[(int)date('n', $t)] . ' ' . date('Y', $t);
        };
        $a = $ps ? $fmt($ps) : null;
        $b = $pe ? $fmt($pe) : null;
        if ($a && $b) return $a . ' - ' . $b;
        if ($a) return $a;
        if ($b) return $b;
        return null;
    }

    // ==================================================================
    //  SUMMARY (laporan)
    // ==================================================================
    /**
     * Ringkasan per tipe/lokasi (halaman Budget).
     * - Nilai bucket = fcst (occupied + prospek), dikelompokkan menurut status.
     * - Target W1..W4 = jumlah nilai prospek pada masing-masing kolom minggu.
     * - Lokasi dengan kapasitas NLA (mis. Atrium): sisa kapasitas otomatis
     *   masuk bucket VACANT, tanpa membuat baris unit baru.
     */
    function get_summary($periode_id) {
        if (!$this->has_unit_master()) { return $this->_get_summary_legacy($periode_id); }

        $masters = $this->get_unit_master_summary_rows();
        $budgets = $this->get_units($periode_id);

        $byMaster = array();
        $legacy   = array();
        foreach ($budgets as $b) {
            $mid = isset($b['unit_master_id']) ? (int)$b['unit_master_id'] : 0;
            if ($mid > 0 && !isset($byMaster[$mid])) {
                $byMaster[$mid] = $b;
            } else {
                $legacy[] = $b;
            }
        }

        $caps   = array();
        $groups = array();
        $order  = array();

        $blank = array(
            'nla' => 0, 'budget' => 0,
            'occ_m2' => 0, 'occ_rp' => 0,
            'ren_m2' => 0, 'ren_rp' => 0,
            'vac_m2' => 0, 'vac_rp' => 0,
            'tot_m2' => 0, 'tot_rp' => 0,
            'w1' => 0, 'w2' => 0, 'w3' => 0, 'w4' => 0, 'wtot' => 0,
            'cap_m2' => 0, 'terpakai_m2' => 0, 'auto_vac_m2' => 0, 'uncreated_m2' => 0,
            'over_m2' => 0, 'lokasi_id' => 0, 'allow_cap' => 0
        );

        foreach ($this->get_lokasi_list() as $l) {
            if ((int)$l['lokasi_isactive'] !== 1) { continue; }
            $lid = (int)$l['lokasi_id'];
            $cap = (float)$l['lokasi_nla'];
            $caps[$lid] = $cap;
            if ($cap <= 0 || $l['tipe_id'] === 'VACANT' || $l['tipe_id'] === 'OTHER') { continue; }
            $key = $l['tipe_id'] . '|' . $lid;
            if (!isset($groups[$key])) {
                $groups[$key] = $blank;
                $groups[$key]['label'] = (($l['tipe_name'] !== null && $l['tipe_name'] !== '') ? $l['tipe_name'] : $l['tipe_id']) . ' ' . $l['lokasi_code'];
                $groups[$key]['lokasi_id'] = $lid;
                $groups[$key]['allow_cap'] = 1;
                $order[$key] = array((int)$l['tipe_order'], (int)$l['lokasi_order']);
            }
        }

        $add = function($key, $label, $order_pair, $nla, $budget, $status, $occ, $prosp,
                        $w1, $w2, $w3, $w4, $allow_cap, $lokasi_id) use (&$groups, &$order, $blank) {
            if (!isset($groups[$key])) {
                $groups[$key] = $blank;
                $groups[$key]['label'] = $label;
                $groups[$key]['lokasi_id'] = (int)$lokasi_id;
                $groups[$key]['allow_cap'] = $allow_cap;
                $order[$key] = $order_pair;
            }

            $nla  = (float)$nla;
            $fcst = (float)$occ + (float)$prosp;
            $groups[$key]['nla']         += $nla;
            $groups[$key]['budget']      += (float)$budget;
            $groups[$key]['tot_m2']      += $nla;
            $groups[$key]['terpakai_m2'] += $nla;
            $groups[$key]['tot_rp']      += $fcst;

            if ($status === 'OCCUPIED') {
                $groups[$key]['occ_m2'] += $nla;
                $groups[$key]['occ_rp'] += $fcst;
            } elseif ($status === 'RENEWAL') {
                $groups[$key]['ren_m2'] += $nla;
                $groups[$key]['ren_rp'] += $fcst;
            } else {
                $groups[$key]['vac_m2'] += $nla;
                $groups[$key]['vac_rp'] += $fcst;
            }

            $groups[$key]['w1'] += (float)$w1;
            $groups[$key]['w2'] += (float)$w2;
            $groups[$key]['w3'] += (float)$w3;
            $groups[$key]['w4'] += (float)$w4;
            $groups[$key]['wtot'] += (float)$prosp;
        };

        foreach ($masters as $m) {
            $key = $m['tipe_id'] === 'VACANT' ? 'VACANT'
                 : ($m['tipe_id'] === 'OTHER' ? 'OTHER' : $m['tipe_id'] . '|' . (int)$m['lokasi_id']);
            $label = $m['tipe_id'] === 'VACANT' ? 'VACANT UNIT'
                   : ($m['tipe_id'] === 'OTHER' ? 'OTHER'
                   : (($m['tipe_name'] !== null && $m['tipe_name'] !== '') ? $m['tipe_name'] : $m['tipe_id']) . ' ' . $m['lokasi_code']);
            $allowCap = ($m['tipe_id'] === 'VACANT' || $m['tipe_id'] === 'OTHER') ? 0 : 1;
            $orderPair = array((int)$m['tipe_order'], (int)$m['lokasi_order']);
            $mid = (int)$m['unit_master_id'];

            $nla = (float)$m['nla'];
            if (isset($byMaster[$mid])) {
                $b = $byMaster[$mid];
                unset($byMaster[$mid]);
                $add($key, $label, $orderPair, $nla, $b['budget'], $b['unit_status'],
                     $b['occupied'], $b['prospek'], $b['w1'], $b['w2'], $b['w3'], $b['w4'], $allowCap, $m['lokasi_id']);
            } else {
                // Unit aktif yang belum dibuatkan budget pada periode ini = VACANT.
                $add($key, $label, $orderPair, $nla, 0, 'VACANT',
                     0, 0, 0, 0, 0, 0, $allowCap, $m['lokasi_id']);
            }
        }

        // Budget lama yang belum terhubung / unit nonaktif tetap ditampilkan.
        foreach ($legacy as $b) {
            $key = $b['tipe_id'] === 'VACANT' ? 'VACANT'
                 : ($b['tipe_id'] === 'OTHER' ? 'OTHER' : $b['tipe_id'] . '|' . (int)$b['lokasi_id']);
            $label = $b['tipe_id'] === 'VACANT' ? 'VACANT UNIT'
                   : ($b['tipe_id'] === 'OTHER' ? 'OTHER' : $b['tipe_name'] . ' ' . $b['lokasi_code']);
            $allowCap = ($b['tipe_id'] === 'VACANT' || $b['tipe_id'] === 'OTHER') ? 0 : 1;
            $orderPair = array((int)$b['tipe_order'], (int)$b['lokasi_order']);
            $add($key, $label, $orderPair, $b['nla'], $b['budget'], $b['unit_status'],
                 $b['occupied'], $b['prospek'], $b['w1'], $b['w2'], $b['w3'], $b['w4'], $allowCap, $b['lokasi_id']);
        }

        foreach ($groups as $key => &$g) {
            $cap = ((int)$g['allow_cap'] === 1 && isset($caps[$g['lokasi_id']])) ? (float)$caps[$g['lokasi_id']] : 0;
            $g['cap_m2'] = $cap;
            $g['auto_vac_m2'] = 0; // VACANT berasal dari unit yang belum dibudgetkan.
            $g['uncreated_m2'] = $cap > 0 ? max(0, $cap - (float)$g['terpakai_m2']) : 0;
            $g['over_m2'] = $cap > 0 ? max(0, (float)$g['terpakai_m2'] - $cap) : 0;
        }
        unset($g);

        uksort($groups, function($a, $b) use ($order) {
            $oa = isset($order[$a]) ? $order[$a] : array(999, 999);
            $ob = isset($order[$b]) ? $order[$b] : array(999, 999);
            if ($oa[0] != $ob[0]) return $oa[0] - $ob[0];
            return $oa[1] - $ob[1];
        });

        $rows = array();
        $grand = $blank;
        foreach ($groups as $g) {
            $rows[] = $g;
            foreach (array_keys($blank) as $k) { $grand[$k] += (isset($g[$k]) ? $g[$k] : 0); }
        }
        return array('rows' => $rows, 'grand' => $grand);
    }

    function _get_summary_legacy($periode_id) {
        $units = $this->get_units($periode_id);

        $caps   = array();
        $groups = array();
        $order  = array();

        $blank = array(
            'nla' => 0, 'budget' => 0,
            'occ_m2' => 0, 'occ_rp' => 0,
            'ren_m2' => 0, 'ren_rp' => 0,
            'vac_m2' => 0, 'vac_rp' => 0,
            'tot_m2' => 0, 'tot_rp' => 0,
            'w1' => 0, 'w2' => 0, 'w3' => 0, 'w4' => 0, 'wtot' => 0,
            'cap_m2' => 0, 'terpakai_m2' => 0, 'auto_vac_m2' => 0,
            'over_m2' => 0, 'lokasi_id' => 0, 'allow_cap' => 0
        );

        // Lokasi berkapasitas tetap tampil sebagai baris VACANT walau belum punya unit.
        foreach ($this->get_lokasi_list() as $l) {
            if ((int)$l['lokasi_isactive'] !== 1) { continue; }
            $lid = (int)$l['lokasi_id'];
            $cap = (float)$l['lokasi_nla'];
            $caps[$lid] = $cap;
            if ($cap <= 0 || $l['tipe_id'] === 'VACANT' || $l['tipe_id'] === 'OTHER') { continue; }
            $key = $l['tipe_id'] . '|' . $lid;
            if (!isset($groups[$key])) {
                $groups[$key] = $blank;
                $groups[$key]['label'] = (($l['tipe_name'] !== null && $l['tipe_name'] !== '') ? $l['tipe_name'] : $l['tipe_id']) . ' ' . $l['lokasi_code'];
                $groups[$key]['lokasi_id'] = $lid;
                $groups[$key]['allow_cap'] = 1;
                $order[$key] = array((int)$l['tipe_order'], (int)$l['lokasi_order']);
            }
        }

        foreach ($units as $u) {
            // label & pengelompokan (VACANT/OTHER digabung satu baris, seperti sheet SUMMARY)
            if ($u['tipe_id'] === 'VACANT')     { $key = 'VACANT'; $label = 'VACANT UNIT'; $allowCap = 0; }
            elseif ($u['tipe_id'] === 'OTHER')  { $key = 'OTHER';  $label = 'OTHER'; $allowCap = 0; }
            else { $key = $u['tipe_id'] . '|' . $u['lokasi_id']; $label = $u['tipe_name'] . ' ' . $u['lokasi_code']; $allowCap = 1; }

            if (!isset($groups[$key])) {
                $groups[$key] = $blank;
                $groups[$key]['label'] = $label;
                $groups[$key]['lokasi_id'] = (int)$u['lokasi_id'];
                $groups[$key]['allow_cap'] = $allowCap;
                $order[$key] = array($u['tipe_order'], $u['lokasi_order']);
            }

            $nla   = (float)$u['nla'];
            $fcst  = (float)$u['occupied'] + (float)$u['prospek'];
            $prosp = (float)$u['prospek'];

            $groups[$key]['nla']        += $nla;
            $groups[$key]['budget']     += (float)$u['budget'];
            $groups[$key]['tot_m2']     += $nla;
            $groups[$key]['terpakai_m2']+= $nla;
            $groups[$key]['tot_rp']     += $fcst;

            if ($u['unit_status'] === 'OCCUPIED')      { $groups[$key]['occ_m2'] += $nla; $groups[$key]['occ_rp'] += $fcst; }
            elseif ($u['unit_status'] === 'RENEWAL')   { $groups[$key]['ren_m2'] += $nla; $groups[$key]['ren_rp'] += $fcst; }
            else                                       { $groups[$key]['vac_m2'] += $nla; $groups[$key]['vac_rp'] += $fcst; }

            $groups[$key]['w1'] += (float)$u['w1'];
            $groups[$key]['w2'] += (float)$u['w2'];
            $groups[$key]['w3'] += (float)$u['w3'];
            $groups[$key]['w4'] += (float)$u['w4'];
            $groups[$key]['wtot'] += $prosp;
        }

        // Terapkan sisa kapasitas lokasi (Atrium) sebagai VACANT otomatis.
        foreach ($groups as $key => &$g) {
            $cap = ((int)$g['allow_cap'] === 1 && isset($caps[$g['lokasi_id']])) ? (float)$caps[$g['lokasi_id']] : 0;
            $g['cap_m2'] = $cap;
            if ($cap > 0) {
                $auto = max(0, $cap - (float)$g['terpakai_m2']);
                $over = max(0, (float)$g['terpakai_m2'] - $cap);
                $g['auto_vac_m2'] = $auto;
                $g['over_m2']     = $over;
                // Bila data melebihi kapasitas, tetap tampilkan total terpakai agar bucket konsisten.
                $g['nla']    = max($cap, (float)$g['terpakai_m2']);
                $g['tot_m2'] = $g['nla'];
                $g['vac_m2'] += $auto;
            }
        }
        unset($g);

        // urutkan sesuai tipe_order, lokasi_order
        uksort($groups, function($a, $b) use ($order) {
            if ($order[$a][0] != $order[$b][0]) return $order[$a][0] - $order[$b][0];
            return $order[$a][1] - $order[$b][1];
        });

        $rows = array();
        $grand = $blank;
        foreach ($groups as $g) {
            $rows[] = $g;
            foreach (array_keys($blank) as $k) { $grand[$k] += (isset($g[$k]) ? $g[$k] : 0); }
        }
        return array('rows' => $rows, 'grand' => $grand);
    }

    // ==================================================================
    //  CRUD SATU BARIS (halaman list / view / form)
    // ==================================================================
    function get_pic_row($id) {
        return $this->db->get_where('cl_pic', array('pic_id' => $id))->row_array();
    }

    /** @return true|string pesan error */
    function save_pic_row($id, $pic_id, $name, $isactive, $is_new) {
        $pic_id = strtoupper(trim($pic_id));
        $name   = trim($name);
        if ($pic_id === '') { return 'Kode PIC wajib diisi.'; }
        if ($name === '')   { return 'Nama PIC wajib diisi.'; }

        if ($is_new) {
            if ($this->db->get_where('cl_pic', array('pic_id' => $pic_id))->num_rows() > 0) {
                return 'Kode PIC "' . $pic_id . '" sudah digunakan.';
            }
            $this->db->insert('cl_pic', array(
                'pic_id' => $pic_id, 'pic_name' => $name, 'pic_isactive' => $isactive ? 1 : 0
            ));
            return true;
        }

        $this->db->where('pic_id', $id);
        $this->db->update('cl_pic', array('pic_name' => $name, 'pic_isactive' => $isactive ? 1 : 0));
        return true;
    }

    function get_tipe_row($id) {
        return $this->db->get_where('cl_tipe', array('tipe_id' => $id))->row_array();
    }

    /** @return true|string pesan error */
    function save_tipe_row($id, $tipe_id, $name, $order, $isactive, $is_new) {
        $tipe_id = strtoupper(trim($tipe_id));
        $name    = trim($name);
        if ($tipe_id === '') { return 'Kode tipe wajib diisi.'; }
        if ($name === '')    { return 'Nama tipe wajib diisi.'; }

        $data = array(
            'tipe_name'     => $name,
            'tipe_order'    => ($order === '' || $order === null) ? 0 : (int)$order,
            'tipe_isactive' => $isactive ? 1 : 0
        );
        if ($is_new) {
            if ($this->db->get_where('cl_tipe', array('tipe_id' => $tipe_id))->num_rows() > 0) {
                return 'Kode tipe "' . $tipe_id . '" sudah digunakan.';
            }
            $data['tipe_id'] = $tipe_id;
            $this->db->insert('cl_tipe', $data);
            return true;
        }

        $this->db->where('tipe_id', $id);
        $this->db->update('cl_tipe', $data);
        return true;
    }

    function get_lokasi_row($id) {
        $join_lantai = '';
        if ($this->_table_exists('cl_lantai')) {
            $join_lantai = " LEFT JOIN cl_lantai la ON la.lantai_id = l.lantai_id";
        }
        $row = $this->db->query(
            "SELECT l.*, t.tipe_name" .
            ($this->_table_exists('cl_lantai') ? ", la.lantai_code, la.lantai_name AS lantai_name_master" : "") .
            "  FROM cl_lokasi l" .
            ($join_lantai !== '' ? $join_lantai : "") .
            "  LEFT JOIN cl_tipe t ON t.tipe_id = l.tipe_id".
            " WHERE l.lokasi_id = " . $this->db->escape((int)$id)
        )->row_array();
        if ($row && !array_key_exists('lokasi_nla', $row)) { $row['lokasi_nla'] = 0; }
        return $row;
    }

    /** @return true|string pesan error */
    function save_lokasi_row($id, $tipe_id, $code, $name, $order, $isactive, $is_new, $nla = null, $lantai_id = null) {
        $id      = (int)$id;
        $tipe_id = strtoupper(trim($tipe_id));
        $code    = strtoupper(trim($code));
        $name    = trim($name);
        if ($tipe_id === '') { return 'Tipe wajib dipilih.'; }
        if ($code === '')    { return 'Kode lokasi wajib diisi.'; }
        if ($name === '')    { return 'Nama lokasi wajib diisi.'; }

        $this->db->where('tipe_id', $tipe_id)->where('lokasi_code', $code);
        if (!$is_new) { $this->db->where('lokasi_id !=', $id); }
        if ($this->db->count_all_results('cl_lokasi') > 0) {
            return 'Kombinasi tipe dan kode lokasi "' . $code . '" sudah digunakan.';
        }

        $data = array(
            'tipe_id'         => $tipe_id,
            'lokasi_code'     => $code,
            'lokasi_name'     => $name,
            'lokasi_order'    => ($order === '' || $order === null) ? 0 : (int)$order,
            'lokasi_isactive' => $isactive ? 1 : 0
        );
        if ($this->has_lokasi_capacity()) {
            $data['lokasi_nla'] = max(0, $this->_num($nla));
        }
        if ($this->has_lokasi_lantai()) {
            $data['lantai_id'] = ($lantai_id === '' || $lantai_id === null) ? null : (int)$lantai_id;
        }
        if ($is_new) {
            $this->db->insert('cl_lokasi', $data);
        } else {
            $this->db->where('lokasi_id', $id);
            $this->db->update('cl_lokasi', $data);
        }
        return true;
    }

    /** @return true|string pesan error */
    function save_periode_row($id, $periode_id, $name, $isactive, $is_new) {
        $periode_id = trim($periode_id);
        $name       = trim($name);

        if ($is_new) {
            if (!preg_match('/^\d{4}-\d{2}$/', $periode_id)) {
                return 'Kode periode harus berformat YYYY-MM, mis. 2026-11.';
            }
            $m = (int)substr($periode_id, 5, 2);
            if ($m < 1 || $m > 12) {
                return 'Bulan pada kode periode harus 01 sampai 12.';
            }
            if ($this->db->get_where('cl_periode', array('periode_id' => $periode_id))->num_rows() > 0) {
                return 'Kode periode "' . $periode_id . '" sudah digunakan.';
            }
            $bulan = array(1=>'JANUARY',2=>'FEBRUARY',3=>'MARCH',4=>'APRIL',5=>'MAY',6=>'JUNE',7=>'JULY',8=>'AUGUST',9=>'SEPTEMBER',10=>'OCTOBER',11=>'NOVEMBER',12=>'DECEMBER');
            if ($name === '') {
                $m = (int)substr($periode_id, 5, 2);
                $name = ($m >= 1 && $m <= 12) ? $bulan[$m] . ' ' . substr($periode_id, 0, 4) : $periode_id;
            }
            $this->db->insert('cl_periode', array(
                'periode_id'       => $periode_id,
                'periode_name'     => $name,
                'periode_start'    => $periode_id . '-01',
                'periode_end'      => date('Y-m-t', strtotime($periode_id . '-01')),
                'periode_isactive' => $isactive ? 1 : 0,
                'createby'         => $this->session->userdata('username'),
                'createdate'       => date('Y-m-d H:i:s')
            ));
            return true;
        }

        if ($name === '') { return 'Nama periode wajib diisi.'; }
        $this->db->where('periode_id', $id);
        $this->db->update('cl_periode', array('periode_name' => $name, 'periode_isactive' => $isactive ? 1 : 0));
        return true;
    }

    function count_units($where = array()) {
        if (!empty($where)) { $this->db->where($where); }
        return (int)$this->db->count_all_results('cl_unit');
    }

    function count_lokasi($tipe_id) {
        return (int)$this->db->where('tipe_id', $tipe_id)->count_all_results('cl_lokasi');
    }

    // ==================================================================
    //  LANTAI / AREA (denah statis)
    // ==================================================================
    /** Kolom mapping lantai_id sudah tersedia di cl_lokasi (migrasi 07). */
    function has_lokasi_lantai() {
        return $this->_has_col('cl_lokasi', 'lantai_id');
    }

    /** Tabel cl_lantai + mapping sudah tersedia (migrasi 07). */
    function has_lantai() {
        return $this->_table_exists('cl_lantai') && $this->has_lokasi_lantai();
    }

    function get_lantai_options() {
        if (!$this->_table_exists('cl_lantai')) { return array(); }
        return $this->db->select('lantai_id, lantai_code, lantai_name, lantai_jenis')
            ->where('lantai_isactive', 1)->order_by('lantai_order, lantai_code')
            ->get('cl_lantai')->result_array();
    }

    function get_lantai_list() {
        if (!$this->_table_exists('cl_lantai')) { return array(); }
        return $this->db->order_by('lantai_order, lantai_code')->get('cl_lantai')->result_array();
    }

    function get_lantai_row($id) {
        if (!$this->_table_exists('cl_lantai')) { return null; }
        return $this->db->get_where('cl_lantai', array('lantai_id' => (int)$id))->row_array();
    }

    /** @return true|string pesan error */
    function save_lantai_row($id, $code, $name, $order, $jenis, $isactive, $is_new, $map_file = null) {
        $id    = (int)$id;
        $code  = strtoupper(trim($code));
        $name  = trim($name);
        $jenis = strtoupper(trim($jenis));

        if ($code === '')   { return 'Kode lantai/area wajib diisi.'; }
        if ($name === '')   { return 'Nama lantai/area wajib diisi.'; }
        if ($jenis !== 'LANTAI' && $jenis !== 'AREA') { return 'Jenis harus LANTAI atau AREA.'; }
        // OTHER bukan lantai, tetap area (PARKIRAN/GUDANG/dll).
        if ($code === 'OTHER' && $jenis !== 'AREA') { return 'Kode OTHER harus berjenis AREA.'; }
        if (!preg_match('/^[A-Z0-9]{1,10}$/', $code)) {
            return 'Kode hanya boleh huruf/angka, maksimal 10 karakter.';
        }

        $this->db->where('lantai_code', $code);
        if (!$is_new) { $this->db->where('lantai_id !=', $id); }
        if ($this->db->count_all_results('cl_lantai') > 0) {
            return 'Kode lantai/area "' . $code . '" sudah digunakan.';
        }

        $data = array(
            'lantai_name'     => $name,
            'lantai_order'    => ($order === '' || $order === null) ? 0 : (int)$order,
            'lantai_jenis'    => $jenis,
            'lantai_isactive' => $isactive ? 1 : 0,
            'modifyby'        => $this->session->userdata('username'),
            'modifydate'      => date('Y-m-d H:i:s')
        );
        // Denah hanya dioverride bila file baru diupload.
        if ($map_file !== null) { $data['map_file'] = $map_file; }

        if ($is_new) {
            $data['lantai_code'] = $code;
            $data['createby']    = $this->session->userdata('username');
            $data['createdate']  = date('Y-m-d H:i:s');
            $this->db->insert('cl_lantai', $data);
        } else {
            $this->db->where('lantai_id', $id);
            $this->db->update('cl_lantai', $data);
        }
        return true;
    }

    /** Lokasi yang dipetakan ke sebuah lantai. */
    function get_lokasi_by_lantai($lantai_id) {
        if (!$this->has_lokasi_lantai()) { return array(); }
        $cap = $this->has_lokasi_capacity() ? "lokasi_nla" : "CAST(0 AS decimal(18,2)) AS lokasi_nla";
        return $this->db->query(
            "SELECT lokasi_id, tipe_id, lokasi_code, lokasi_name, $cap, lokasi_isactive
               FROM cl_lokasi
              WHERE lantai_id = " . $this->db->escape((int)$lantai_id) . "
              ORDER BY tipe_id, lokasi_order, lokasi_code"
        )->result_array();
    }

    /**
     * Ringkasan denah statis satu lantai: OCCUPIED/RENEWAL/VACANT
     * dari data budget periode terpilih atas lokasi yang dipetakan.
     * @return array|null null bila migrasi 07 belum dijalankan
     */
    function get_lantai_summary($lantai_id, $periode_id) {
        if (!$this->has_lantai()) { return null; }

        $lokasis = $this->get_lokasi_by_lantai($lantai_id);
        $ids = array();
        $per_lokasi = array();
        foreach ($lokasis as $l) {
            $ids[] = (int)$l['lokasi_id'];
            $per_lokasi[(int)$l['lokasi_id']] = array(
                'code'      => $l['lokasi_code'],
                'name'      => $l['lokasi_name'],
                'tipe'      => $l['tipe_id'],
                'nla'       => (float)$l['lokasi_nla'],
                'isactive'  => (int)$l['lokasi_isactive'],
                'budget_n'  => 0, 'budget_rp' => 0,
                'occ_n' => 0, 'occ_rp' => 0,
                'ren_n' => 0, 'ren_rp' => 0,
                'vac_n' => 0, 'vac_rp' => 0,
                'w1' => 0, 'w2' => 0, 'w3' => 0, 'w4' => 0
            );
        }

        $total = array(
            'budget_n' => 0, 'budget_rp' => 0,
            'occ_n' => 0, 'occ_rp' => 0,
            'ren_n' => 0, 'ren_rp' => 0,
            'vac_n' => 0, 'vac_rp' => 0,
            'w1' => 0, 'w2' => 0, 'w3' => 0, 'w4' => 0
        );

        if ($ids && $periode_id) {
            $units = $this->get_units($periode_id);
            foreach ($units as $u) {
                $lid = (int)(isset($u['lokasi_id']) ? $u['lokasi_id'] : 0);
                if (!isset($per_lokasi[$lid])) { continue; }
                $nla   = (float)$u['nla'];
                $rp    = (float)$u['occupied'] + (float)$u['prospek'];
                $s     = $u['unit_status'];
                $idx   = ($s === 'OCCUPIED') ? 'occ_n' : (($s === 'RENEWAL') ? 'ren_n' : 'vac_n');
                $per_lokasi[$lid]['budget_n']++;
                $per_lokasi[$lid]['budget_rp'] += (float)$u['budget'];
                $per_lokasi[$lid][$idx]++;
                $per_lokasi[$lid][substr($idx, 0, 3) . '_rp'] += $rp;
                $per_lokasi[$lid]['w1'] += (float)$u['w1'];
                $per_lokasi[$lid]['w2'] += (float)$u['w2'];
                $per_lokasi[$lid]['w3'] += (float)$u['w3'];
                $per_lokasi[$lid]['w4'] += (float)$u['w4'];

                $total['budget_n']++; $total['budget_rp'] += (float)$u['budget'];
                $total[$idx]++;       $total[substr($idx, 0, 3) . '_rp'] += $rp;
                $total['w1'] += (float)$u['w1'];
                $total['w2'] += (float)$u['w2'];
                $total['w3'] += (float)$u['w3'];
                $total['w4'] += (float)$u['w4'];
            }
        }

        $master_n = 0;
        if ($ids) {
            $q = $this->db->query(
                "SELECT COUNT(*) AS c FROM cl_unit_master
                  WHERE unit_isactive = 1 AND lokasi_id IN (" . implode(',', $ids) . ")"
            );
            $r = $q ? $q->row() : null;
            $master_n = $r ? (int)$r->c : 0;
        }

        return array(
            'periode_id' => $periode_id,
            'lokasis'    => $lokasis,
            'rows'       => array_values($per_lokasi),
            'total'      => $total,
            'master_n'   => $master_n
        );
    }

    // ==================================================================
    //  AKSI MASSAL
    // ==================================================================
    function set_occupied_bulk($ids) {
        $n = 0;
        foreach ((array)$ids as $id) { if ($this->set_occupied($id)) { $n++; } }
        return $n;
    }

    function delete_bulk($ids) {
        $n = 0;
        foreach ((array)$ids as $id) { if ($this->delete_unit($id)) { $n++; } }
        return $n;
    }

    // ==================================================================
    //  PARSER TEKS PERIODE (baris tanpa tanggal lengkap)
    // ==================================================================
    /**
     * Ubah teks periode seperti "17 NOV-16 DES", "30 NIV - 6 DES 2026",
     * "1 NOV - 31 NO V 2026" menjadi array(start, end) format Y-m-d.
     * $base_ym = 'YYYY-MM' (periode) untuk menebak tahun bila teks tanpa tahun.
     * Return null bila tidak bisa di-parse.
     */
    function parse_periode_text($text, $base_ym = null) {
        if ($text === null) return null;
        $t = strtoupper(trim((string)$text));
        if ($t === '') return null;
        $t = str_replace(array('S/D', 'SD', '.', ','), ' ', $t);
        $t = preg_replace('/\s+/', '', $t);            // buang semua spasi (termasuk 'NO V')
        $t = preg_replace('/[^A-Z0-9]+/', '-', $t);    // pemisah lain jadi '-'
        $t = trim($t, '-');
        if (strpos($t, '-') === false) return null;
        $parts = explode('-', $t);
        if (count($parts) < 2) return null;

        $bulan = array(
            'JAN'=>1,'JANUARI'=>1,'JANUARY'=>1,
            'FEB'=>2,'FEBRUARI'=>2,'FEBRUARY'=>2,
            'MAR'=>3,'MARET'=>3,'MARCH'=>3,
            'APR'=>4,'APRIL'=>4,
            'MEI'=>5,'MAY'=>5,
            'JUN'=>6,'JUNI'=>6,'JUNE'=>6,
            'JUL'=>7,'JULI'=>7,'JULY'=>7,
            'AGU'=>8,'AGS'=>8,'AUG'=>8,'AGUSTUS'=>8,'AUGUST'=>8,
            'SEP'=>9,'SEPT'=>9,'SEPTEMBER'=>9,
            'OKT'=>10,'OCT'=>10,'OKTOBER'=>10,'OCTOBER'=>10,
            'NOV'=>11,'NOVEMBER'=>11,'NIV'=>11,'NOP'=>11,
            'DES'=>12,'DEC'=>12,'DESEMBER'=>12,'DECEMBER'=>12
        );

        $parse = function($s) use ($bulan) {
            if (!preg_match('/^(\d{1,2})([A-Z]+)(\d{2,4})?$/', $s, $m)) return null;
            if (!isset($bulan[$m[2]])) return null;
            $yr = (isset($m[3]) && $m[3] !== '') ? (int)$m[3] : null;
            if ($yr !== null && $yr < 100) { $yr += 2000; }
            return array('d' => (int)$m[1], 'm' => $bulan[$m[2]], 'y' => $yr);
        };

        $a = $parse($parts[0]);
        $b = $parse($parts[1]);
        // dukung bentuk "16-22 NOV 2026" (bagian awal hanya tanggal)
        if (!$a && $b && preg_match('/^(\d{1,2})$/', $parts[0])) {
            $a = array('d' => (int)$parts[0], 'm' => $b['m'], 'y' => $b['y']);
        }
        if (!$a || !$b) return null;

        $baseY = ($base_ym !== null && strlen((string)$base_ym) >= 4) ? (int)substr((string)$base_ym, 0, 4) : (int)date('Y');
        if ($a['y'] === null && $b['y'] === null) {
            $a['y'] = $baseY;
            $b['y'] = ($b['m'] < $a['m']) ? $baseY + 1 : $baseY;
        } elseif ($a['y'] === null) {
            $a['y'] = ($a['m'] > $b['m']) ? $b['y'] - 1 : $b['y'];
        } elseif ($b['y'] === null) {
            $b['y'] = ($b['m'] < $a['m']) ? $a['y'] + 1 : $a['y'];
        }

        $mk = function($p) {
            $last = (int)date('t', mktime(0, 0, 0, $p['m'], 1, $p['y']));
            $d = $p['d'];
            if ($d > $last) { $d = $last; }   // mis. 31 NOV -> 30
            if ($d < 1) { $d = 1; }
            return sprintf('%04d-%02d-%02d', $p['y'], $p['m'], $d);
        };

        return array($mk($a), $mk($b));
    }

    /** Lengkapi tanggal dari periode_text untuk unit yang belum punya tanggal. */
    function fix_periode_dates($periode_id) {
        $q = $this->db->query("SELECT unit_id, periode_text FROM cl_unit WHERE periode_id = " . $this->db->escape($periode_id) . " AND (periode_start IS NULL OR periode_end IS NULL)");
        $fixed = 0;
        foreach ($q->result_array() as $r) {
            $p = $this->parse_periode_text($r['periode_text'], $periode_id);
            if (!$p) continue;
            $this->db->where('unit_id', (int)$r['unit_id']);
            $this->db->update('cl_unit', array('periode_start' => $p[0], 'periode_end' => $p[1]));
            $fixed++;
        }
        return $fixed;
    }

    // ==================================================================
    //  MASTER: tipe, lokasi, periode
    // ==================================================================
    function get_tipe_list() {
        return $this->db->query("SELECT * FROM cl_tipe ORDER BY tipe_order, tipe_id")->result_array();
    }

    function get_lokasi_list() {
        $rows = $this->db
            ->select('l.*, t.tipe_name, t.tipe_order')
            ->from('cl_lokasi l')
            ->join('cl_tipe t', 't.tipe_id = l.tipe_id', 'left')
            ->order_by('t.tipe_order, l.lokasi_order, l.lokasi_code')
            ->get()->result_array();
        foreach ($rows as &$row) {
            if (!array_key_exists('lokasi_nla', $row)) { $row['lokasi_nla'] = 0; }
        }
        unset($row);
        return $rows;
    }

    function get_periode_list() {
        return $this->db->query("SELECT * FROM cl_periode ORDER BY periode_id DESC")->result_array();
    }

    // ==================================================================
    //  IMPORT DARI EXCEL (.xlsx)
    // ==================================================================
    /** Baca file xlsx template CL -> array('rows'=>...) atau array('error'=>...). */
    function read_xlsx_rows($path) {
        if (!class_exists('ZipArchive')) return array('error' => 'Ekstensi zip PHP tidak tersedia.');
        $zip = new ZipArchive();
        if ($zip->open($path) !== true) return array('error' => 'File tidak bisa dibuka (pastikan format .xlsx).');

        $shared = array();
        $z = $zip->getFromName('xl/sharedStrings.xml');
        if ($z !== false) {
            $sx = @simplexml_load_string($z);
            if ($sx !== false) {
                foreach ($sx->si as $si) {
                    $txt = '';
                    if (isset($si->t)) { $txt = (string)$si->t; }
                    else { foreach ($si->r as $r) { $txt .= (string)$r->t; } }
                    $shared[] = $txt;
                }
            }
        }
        $wb   = @simplexml_load_string($zip->getFromName('xl/workbook.xml'));
        $rels = @simplexml_load_string($zip->getFromName('xl/_rels/workbook.xml.rels'));
        if ($wb === false || $rels === false) { $zip->close(); return array('error' => 'Struktur workbook tidak dikenali.'); }

        $relMap = array();
        foreach ($rels->Relationship as $r) { $relMap[(string)$r['Id']] = (string)$r['Target']; }
        $sheets = array();
        foreach ($wb->sheets->sheet as $sh) {
            $rid = (string)$sh->attributes('http://schemas.openxmlformats.org/officeDocument/2006/relationships')->id;
            if (!isset($relMap[$rid])) continue;
            $t = $relMap[$rid]; if ($t[0] !== '/') { $t = 'xl/' . $t; }
            $sheets[] = array('name' => strtoupper(trim((string)$sh['name'])), 'path' => ltrim($t, '/'));
        }

        $valid = array('ATRIUM', 'KORIDOR', 'VACANT UNIT', 'OTHER');
        $rows = array();
        foreach ($sheets as $s) {
            if (!in_array($s['name'], $valid, true)) continue;
            $xml = $zip->getFromName($s['path']);
            if ($xml === false) continue;
            $sx2 = @simplexml_load_string($xml);
            if ($sx2 === false) continue;

            $sheetRows = array();
            foreach ($sx2->sheetData->row as $row) {
                $rn = (int)$row['r'];
                foreach ($row->c as $c) {
                    $ref = (string)$c['r'];
                    if (!preg_match('/^([A-Z]+)/', $ref, $mm)) continue;
                    $col = $mm[1]; $ci = 0;
                    for ($i = 0; $i < strlen($col); $i++) { $ci = $ci * 26 + (ord($col[$i]) - 64); }
                    $ci--;
                    $type = (string)$c['t'];
                    $v = isset($c->v) ? (string)$c->v : '';
                    if ($type === 's') { $v = isset($shared[(int)$v]) ? $shared[(int)$v] : ''; }
                    elseif ($type === 'inlineStr') { $v = isset($c->is->t) ? (string)$c->is->t : ''; }
                    $v = trim($v);
                    if ($v !== '') { $sheetRows[$rn][$ci] = $v; }
                }
            }
            ksort($sheetRows);

            foreach ($sheetRows as $rn => $cols) {
                if (!isset($cols[0]) || !is_numeric(trim($cols[0]))) continue;   // baris data diawali NO
                $g = function($i) use ($cols) { return isset($cols[$i]) ? trim($cols[$i]) : ''; };
                $row = array(
                    'sheet' => $s['name'], 'no' => $g(0), 'lokasi' => $g(1), 'unit' => $g(2), 'pic' => $g(3),
                    'nla' => $g(4), 'status' => $g(5), 'ptype' => '', 'periode' => '', 'tenant' => '',
                    'budget' => 0, 'occupied' => 0, 'prospek' => 0, 'w1' => 0, 'w2' => 0, 'w3' => 0, 'w4' => 0,
                    'remarks' => ''
                );
                if ($s['name'] === 'ATRIUM') {
                    $row['ptype']    = $g(6);  $row['periode']  = $g(7);  $row['tenant']   = $g(8);
                    $row['budget']   = $this->_num($g(10)); $row['occupied'] = $this->_num($g(11)); $row['prospek'] = $this->_num($g(12));
                    $row['w1'] = $this->_num($g(14)); $row['w2'] = $this->_num($g(15)); $row['w3'] = $this->_num($g(16)); $row['w4'] = $this->_num($g(17));
                } elseif ($s['name'] === 'OTHER') {
                    $row['remarks']  = $g(6);  $row['periode']  = $g(7);  $row['tenant']   = $g(9);
                    $row['budget']   = $this->_num($g(11)); $row['occupied'] = $this->_num($g(12)); $row['prospek'] = $this->_num($g(13));
                    $row['w1'] = $this->_num($g(15)); $row['w2'] = $this->_num($g(16)); $row['w3'] = $this->_num($g(17)); $row['w4'] = $this->_num($g(18));
                } else { // KORIDOR / VACANT UNIT
                    // Kolom 6 pada template berisi tipe periode (header lama: REMARKS/PERIODE).
                    $row['ptype']    = $g(6);  $row['periode']  = $g(7);  $row['tenant']   = $g(8);
                    $row['budget']   = $this->_num($g(9));  $row['occupied'] = $this->_num($g(10)); $row['prospek'] = $this->_num($g(11));
                    $row['w1'] = $this->_num($g(13)); $row['w2'] = $this->_num($g(14)); $row['w3'] = $this->_num($g(15)); $row['w4'] = $this->_num($g(16));
                }
                $row['week'] = '';
                foreach (array('w1' => 'W1', 'w2' => 'W2', 'w3' => 'W3', 'w4' => 'W4') as $k => $lab) {
                    if ($row[$k] > 0) { $row['week'] = $lab; break; }
                }
                $rows[] = $row;
            }
        }
        $zip->close();
        return array('rows' => $rows);
    }

    /**
     * Import baris hasil read_xlsx_rows ke cl_unit.
     * $mode = 'append' (lewati duplikat) | 'replace' (hapus dulu data periode ini).
     */
    function import_rows($periode_id, $rows, $mode = 'append') {
        $lokMap = array();
        foreach ($this->get_lokasi_options() as $l) {
            $code = strtoupper(preg_replace('/\s+/', ' ', trim($l['lokasi_code'])));
            $lokMap[$l['tipe_id']][$code] = (int)$l['lokasi_id'];
        }
        $pics     = $this->get_pic_options();
        $hasMaster = $this->has_unit_master();

        $res = array('inserted' => 0, 'skipped' => 0, 'errors' => array());
        $username = $this->session->userdata('username');
        $now = date('Y-m-d H:i:s');

        if ($mode === 'replace') {
            $this->db->where('periode_id', $periode_id);
            $this->db->delete('cl_unit');
        }

        $existing = array();
        $existingMaster = array();
        $selMaster = $hasMaster ? ", unit_master_id" : "";
        $q = $this->db->query("SELECT tipe_id, lokasi_id, unit_name" . $selMaster . ", CONVERT(varchar(10), periode_start, 120) AS ps, CONVERT(varchar(10), periode_end, 120) AS pe, ISNULL(periode_text,'') AS periode_text FROM cl_unit WHERE periode_id = " . $this->db->escape($periode_id));
        foreach ($q->result_array() as $e) {
            $base = $e['tipe_id'] . '|' . $e['lokasi_id'] . '|' . strtoupper(trim($e['unit_name']));
            $existing[$base . '|T|' . strtoupper(trim($e['periode_text']))] = 1;
            if ($e['ps'] && $e['pe']) { $existing[$base . '|D|' . $e['ps'] . '|' . $e['pe']] = 1; }
            if ($hasMaster && !empty($e['unit_master_id'])) { $existingMaster[(int)$e['unit_master_id']] = 1; }
        }

        foreach ($rows as $r) {
            $tipe = $r['sheet'];
            if ($tipe === 'VACANT UNIT') { $tipe = 'VACANT'; }

            $code = strtoupper(trim($r['lokasi']));
            $code = preg_replace('/\s*VACANT\s*$/', '', $code);
            $code = preg_replace('/\s+/', ' ', $code);
            $lokasi_id = isset($lokMap[$tipe][$code]) ? $lokMap[$tipe][$code] : null;
            if ($lokasi_id === null && $code === 'OTHER' && isset($lokMap[$tipe]['ALL'])) {
                $lokasi_id = $lokMap[$tipe]['ALL'];
            }
            if ($lokasi_id === null && isset($lokMap[$tipe]) && count($lokMap[$tipe]) === 1) {
                $lokasi_id = reset($lokMap[$tipe]);
            }
            if ($lokasi_id === null) {
                $res['errors'][] = 'Lokasi "' . $r['lokasi'] . '" tidak dikenal untuk tipe ' . $tipe . ' (unit ' . $r['unit'] . ')';
                continue;
            }

            $pdate = $this->parse_periode_text($r['periode'], $periode_id);
            $unit_no = is_numeric($r['no']) ? (int)$r['no'] : null;
            $master = null;

            if ($hasMaster) {
                if ($unit_no === null || $unit_no <= 0) {
                    $res['errors'][] = 'No. unit tidak valid untuk unit ' . $r['unit'] . ' (lokasi ' . $r['lokasi'] . ').';
                    continue;
                }
                $master = $this->get_unit_master_by_locno($lokasi_id, $unit_no);
                if (!$master) {
                    $mk = $this->save_unit_master_row(0, $lokasi_id, $unit_no, $r['unit'], $this->_num($r['nla']), 1);
                    if ($mk !== true) {
                        $res['errors'][] = 'Gagal membuat unit ' . $r['unit'] . ' (no. ' . $unit_no . '): ' . $mk;
                        continue;
                    }
                    $master = $this->get_unit_master_by_locno($lokasi_id, $unit_no);
                }
                if (!$master) {
                    $res['errors'][] = 'Master unit ' . $r['unit'] . ' tidak ditemukan setelah dibuat.';
                    continue;
                }
                if (isset($existingMaster[(int)$master['unit_master_id']])) {
                    $res['skipped']++;
                    continue;
                }
            } else {
                $base = $tipe . '|' . $lokasi_id . '|' . strtoupper(trim($r['unit']));
                $dup  = isset($existing[$base . '|T|' . strtoupper(trim($r['periode']))]);
                if (!$dup && $pdate) { $dup = isset($existing[$base . '|D|' . $pdate[0] . '|' . $pdate[1]]); }
                if ($dup) { $res['skipped']++; continue; }
            }

            $nla    = $master ? (float)$master['nla'] : $this->_num($r['nla']);
            $budget = $this->_num($r['budget']);

            $pic = trim($r['pic']);
            if ($pic !== '' && !isset($pics[$pic])) { $pic = null; }

            $w = array('w1' => 0, 'w2' => 0, 'w3' => 0, 'w4' => 0);
            foreach ($w as $k => $v) { $w[$k] = $this->_num(isset($r[$k]) ? $r[$k] : 0); }
            $wSum = $w['w1'] + $w['w2'] + $w['w3'] + $w['w4'];
            $prospek = $this->_num($r['prospek']);
            // Total PROSPEK adalah nilai otoritatif. Bila Excel hanya mengisi satu
            // kolom minggu dan totalnya berbeda (mis. GFC 01A), pakai total agar
            // prospek = W1+W2+W3+W4 dan forecast konsisten.
            if ($wSum > 0 && $prospek > 0 && abs($wSum - $prospek) > 0.01) {
                $nz = array();
                foreach ($w as $k => $v) { if ($v > 0) { $nz[$k] = $v; } }
                if (count($nz) === 1) {
                    $only = key($nz);
                    $w[$only] = $prospek;
                    $wSum = $prospek;
                }
            }
            if ($wSum <= 0 && $prospek > 0) {
                $first = strtolower((string)(isset($r['week']) ? $r['week'] : 'w1'));
                if (!in_array($first, array('w1', 'w2', 'w3', 'w4'), true)) { $first = 'w1'; }
                $w[$first] = $prospek;
                $wSum = $prospek;
            }

            $occupied = $this->_num(isset($r['occupied']) ? $r['occupied'] : 0);
            // Status OCCUPIED tidak boleh masih menyimpan prospek. Bila Excel salah
            // (status OCCUPIED tetapi ada W/prospek), pindahkan nilainya ke occupied.
            if (strtoupper(trim((string)(isset($r['status']) ? $r['status'] : ''))) === 'OCCUPIED'
                && ($wSum > 0 || $prospek > 0)) {
                $occupied += ($wSum > 0) ? $wSum : $prospek;
                $w = array('w1' => 0, 'w2' => 0, 'w3' => 0, 'w4' => 0);
                $wSum = 0;
            }

            $data = array(
                'periode_id'   => $periode_id,
                'tipe_id'      => $tipe,
                'lokasi_id'    => $lokasi_id,
                'unit_no'      => $master ? (int)$master['unit_no'] : $unit_no,
                'unit_name'    => $master ? $master['unit_name'] : $r['unit'],
                'pic_id'       => $pic,
                'nla'          => $nla,
                'unit_status'  => ($r['status'] !== '' ? strtoupper($r['status']) : 'VACANT'),
                'tenant'       => $r['tenant'],
                'periode_type' => $r['ptype'],
                'periode_start'=> $pdate ? $pdate[0] : null,
                'periode_end'  => $pdate ? $pdate[1] : null,
                'periode_text' => $r['periode'],
                'budget'       => $budget,
                'occupied'     => $occupied,
                'prospek'      => $wSum,
                'remarks'      => $r['remarks'],
                'unit_isactive'=> 1,
                'createby'     => $username,
                'createdate'   => $now
            );
            if ($this->_has_col('cl_unit', 'unit_master_id')) {
                $data['unit_master_id'] = $master ? (int)$master['unit_master_id'] : null;
            }
            if ($this->has_week_columns()) {
                $data['w1'] = $w['w1']; $data['w2'] = $w['w2'];
                $data['w3'] = $w['w3']; $data['w4'] = $w['w4'];
            } elseif ($this->_has_col('cl_unit', 'week_target')) {
                $data['week_target'] = $this->_first_week($w);
            }
            if ($this->db->insert('cl_unit', $data)) {
                if ($master) {
                    $existingMaster[(int)$master['unit_master_id']] = 1;
                } else {
                    $base = $tipe . '|' . $lokasi_id . '|' . strtoupper(trim($r['unit']));
                    $existing[$base . '|T|' . strtoupper(trim($r['periode']))] = 1;
                    if ($pdate) { $existing[$base . '|D|' . $pdate[0] . '|' . $pdate[1]] = 1; }
                }
                $res['inserted']++;
            } else {
                $res['errors'][] = 'Gagal simpan unit ' . $r['unit'];
            }
        }
        return $res;
    }
}
