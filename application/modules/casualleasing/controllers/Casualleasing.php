<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller modul Casual Leasing (CL).
 * URL: index.php/casualleasing/casualleasing/<method>
 */
class Casualleasing extends CI_Controller {

    const base = 'casualleasing/casualleasing';

    function __construct() {
        parent::__construct();
        check_user_login();
        $this->load->model('model_casualleasing');
        $this->load->library('breadcrumbcomponent');
    }

    function index() {
        redirect(self::base . '/load');
    }

    private function _periode() {
        $p = $this->input->get('p');
        if (!$p) { $p = $this->input->post('periode_id'); }
        if (!$p) { $p = $this->model_casualleasing->get_active_periode(); }
        return $p;
    }

    // ==================================================================
    //  LIST
    // ==================================================================
    function load() {
        $data['periode']  = $this->_periode();
        $data['periodes'] = $this->model_casualleasing->get_periode_options();
        $data['tipes']    = $this->model_casualleasing->get_tipe_options();
        $data['lokasis']  = $this->model_casualleasing->get_lokasi_options();
        $data['statuses'] = array('VACANT' => 'VACANT', 'RENEWAL' => 'RENEWAL', 'OCCUPIED' => 'OCCUPIED');
        $data['msg'] = $this->session->flashdata('cl_msg');
        if ($data['msg'] !== null) { $this->session->unset_userdata('cl_msg'); }

        $this->breadcrumbcomponent->add('CL Budget');
        $this->load->view('template/v_header');
        $this->load->view('casualleasing/list', $data);
        $this->load->view('template/v_footer');
    }

    /** JSON data untuk DataTables (difilter di server) */
    function grid() {
        $periode  = $this->_periode();
        $tipe     = $this->input->get('tipe');     $tipe = $tipe === null ? '' : $tipe;
        $lokasi   = $this->input->get('lokasi');   $lokasi = $lokasi === null ? '' : $lokasi;
        $status   = $this->input->get('status');   $status = $status === null ? '' : $status;
        $keyword  = $this->input->get('q');        $keyword = $keyword === null ? '' : $keyword;

        $units = $this->model_casualleasing->get_units($periode, $tipe, $lokasi, $status, $keyword);

        $data = array();
        $no = 0;
        foreach ($units as $u) {
            $no++;
            $fcst = (float)$u['occupied'] + (float)$u['prospek'];
            $data[] = array(
                'unit_id'   => (int)$u['unit_id'],
                'no'        => $no,
                'tipe'      => $u['tipe_name'],
                'lokasi'    => $u['lokasi_code'],
                'unit'      => $u['unit_name'],
                'pic'       => $u['pic_id'],
                'nla'       => (float)$u['nla'],
                'status'    => $u['unit_status'],
                'periode'   => $this->_periode_display($u),
                'periode_type' => $u['periode_type'],
                'periode_start' => !empty($u['periode_start']) ? date('d-m-Y', strtotime($u['periode_start'])) : '',
                'periode_end'   => !empty($u['periode_end']) ? date('d-m-Y', strtotime($u['periode_end'])) : '',
                'tenant'    => $u['tenant'],
                'budget'    => (float)$u['budget'],
                'occupied'  => (float)$u['occupied'],
                'w1'        => (float)$u['w1'],
                'w2'        => (float)$u['w2'],
                'w3'        => (float)$u['w3'],
                'w4'        => (float)$u['w4'],
                'prospek'   => (float)$u['prospek'],
                'fcst'      => $fcst,
                'arr_budget' => $this->_arr($u['budget'], $u['nla']),
                'arr_occupied' => $this->_arr($u['occupied'], $u['nla']),
                'arr_prospek' => $this->_arr($u['prospek'], $u['nla']),
                'arr_fcst' => $this->_arr($fcst, $u['nla']),
                'week'      => $u['week'],
                'remarks'   => $u['remarks']
            );
        }
        echo json_encode(array('data' => $data, 'periode' => $periode));
    }

    private function _periode_display($u) {
        if (!empty($u['periode_start']) && !empty($u['periode_end'])) {
            return date('d-m-Y', strtotime($u['periode_start'])) . ' s/d ' . date('d-m-Y', strtotime($u['periode_end']));
        }
        return (string)$u['periode_text'];
    }

    /** ARR = nilai Rp / NLA (m2), mengikuti kolom ARR pada template Excel. */
    private function _arr($value, $nla) {
        $nla = (float)$nla;
        return $nla > 0 ? (float)$value / $nla : 0;
    }

    // ==================================================================
    //  FORM
    // ==================================================================
    private function _form_data($include_master_id = 0) {
        $data['periodes']  = $this->model_casualleasing->get_periode_options();
        $data['tipes']     = $this->model_casualleasing->get_tipe_options();
        $data['lokasis']   = $this->model_casualleasing->get_lokasi_options();
        $data['pics']      = $this->model_casualleasing->get_pic_options();
        $data['statuses']  = array('VACANT' => 'VACANT', 'RENEWAL' => 'RENEWAL', 'OCCUPIED' => 'OCCUPIED');
        $data['periodetypes'] = array('WEEKLY', 'MONTHLY', '3 MONTHS', '4 MONTHS', '6 MONTHS', 'YEARLY');
        $data['has_unit_master'] = $this->model_casualleasing->has_unit_master();
        $data['unit_masters'] = $data['has_unit_master']
            ? $this->model_casualleasing->get_unit_master_options($include_master_id)
            : array();
        return $data;
    }

    function add() {
        $data = $this->_form_data();
        $data['mode']     = 'add';
        $data['action']   = site_url(self::base . '/save');
        $data['row']      = $this->_blank_row();
        $data['err']      = $this->session->flashdata('cl_err');
        if ($data['err'] !== null) { $this->session->unset_userdata('cl_err'); }
        $old = $this->_old_input();
        if (!empty($old)) { $data['row'] = array_merge($data['row'], $old); }
        $this->breadcrumbcomponent->add('CL Budget', self::base . '/load')->add('Input Budget');
        $this->load->view('template/v_header');
        $this->load->view('casualleasing/form', $data);
        $this->load->view('template/v_footer');
    }

    function edit() {
        $unit_id = $this->uri->segment(4);
        $row = $this->model_casualleasing->get_unit($unit_id);
        if (!$row) { redirect(self::base . '/load'); return; }
        $data = $this->_form_data(isset($row['unit_master_id']) ? (int)$row['unit_master_id'] : 0);
        $data['mode']   = 'edit';
        $data['action'] = site_url(self::base . '/update/' . $unit_id);
        $data['row']    = $row;
        $data['err']    = $this->session->flashdata('cl_err');
        if ($data['err'] !== null) { $this->session->unset_userdata('cl_err'); }
        $old = $this->_old_input();
        if (!empty($old)) { $data['row'] = array_merge($data['row'], $old); }
        $this->breadcrumbcomponent->add('CL Budget', self::base . '/load')->add('Edit Budget');
        $this->load->view('template/v_header');
        $this->load->view('casualleasing/form', $data);
        $this->load->view('template/v_footer');
    }

    function view() {
        $unit_id = (int)$this->uri->segment(4);
        $row = $this->model_casualleasing->get_unit_detail($unit_id);
        if (!$row) { redirect(self::base . '/load'); return; }
        $fcst = (float)$row['occupied'] + (float)$row['prospek'];
        $data['row'] = $row;
        $data['fcst'] = $fcst;
        $data['periode_display'] = $this->_periode_display($row);
        $data['arr'] = array(
            'budget'   => $this->_arr($row['budget'], $row['nla']),
            'occupied' => $this->_arr($row['occupied'], $row['nla']),
            'prospek'  => $this->_arr($row['prospek'], $row['nla']),
            'fcst'     => $this->_arr($fcst, $row['nla'])
        );
        $this->breadcrumbcomponent->add('CL Budget', self::base . '/load')->add('Detail Budget');
        $this->load->view('template/v_header');
        $this->load->view('casualleasing/unit_view', $data);
        $this->load->view('template/v_footer');
    }

    private function _blank_row() {
        return array(
            'unit_id' => '', 'unit_master_id' => '', 'periode_id' => $this->_periode(), 'tipe_id' => '', 'lokasi_id' => '',
            'unit_no' => '', 'unit_name' => '', 'pic_id' => '', 'nla' => '', 'unit_status' => 'VACANT',
            'tenant' => '', 'periode_type' => 'MONTHLY', 'periode_start' => '', 'periode_end' => '',
            'periode_text' => '', 'budget' => '', 'occupied' => 0,
            'w1' => 0, 'w2' => 0, 'w3' => 0, 'w4' => 0, 'prospek' => 0,
            'remarks' => ''
        );
    }

    /** Validasi server-side form Budget. */
    private function _unit_error($exclude_unit_id = 0, $current_master_id = 0) {
        $periode = trim((string)$this->input->post('periode_id'));
        if (!preg_match('/^\d{4}-\d{2}$/', $periode)) { return 'Periode wajib dipilih.'; }
        if (!$this->model_casualleasing->get_periode($periode)) { return 'Periode tidak dikenal.'; }

        $use_master = $this->model_casualleasing->has_unit_master();
        if ($use_master) {
            $mid = (int)$this->input->post('unit_master_id');
            if ($mid <= 0) { return 'Unit wajib dipilih.'; }
            $master = $this->model_casualleasing->get_unit_master_row($mid);
            if (!$master) { return 'Unit tidak ditemukan di master unit.'; }
            if ((int)$master['unit_isactive'] !== 1 && $mid !== (int)$current_master_id) {
                return 'Unit ini nonaktif. Pilih unit aktif atau aktifkan kembali di menu CL Unit.';
            }
            if ($this->model_casualleasing->budget_unit_used($periode, $mid, $exclude_unit_id)) {
                return 'Unit ' . $master['unit_name'] . ' sudah memiliki budget pada periode ' . $periode . '.';
            }
        } else {
            $tipe = trim((string)$this->input->post('tipe_id'));
            if ($tipe === '') { return 'Tipe lokasi wajib dipilih.'; }

            $lokasi = (int)$this->input->post('lokasi_id');
            if ($lokasi <= 0) { return 'Lokasi wajib dipilih.'; }
            $lokasi_valid = false;
            foreach ($this->model_casualleasing->get_lokasi_options($tipe) as $l) {
                if ((int)$l['lokasi_id'] === $lokasi) { $lokasi_valid = true; break; }
            }
            if (!$lokasi_valid) { return 'Lokasi tidak sesuai dengan tipe yang dipilih.'; }

            $unit = trim((string)$this->input->post('unit_name'));
            if ($unit === '') { return 'Nama unit wajib diisi.'; }
            if (function_exists('mb_strlen') && mb_strlen($unit) > 150) {
                return 'Nama unit maksimal 150 karakter.';
            }

            $unit_no = trim((string)$this->input->post('unit_no'));
            if ($unit_no !== '' && (!preg_match('/^\d+$/', $unit_no) || (float)$unit_no > 2147483647)) {
                return 'No. unit harus berupa angka yang valid.';
            }
        }

        if (function_exists('mb_strlen')) {
            if (mb_strlen(trim((string)$this->input->post('tenant'))) > 200) {
                return 'Nama tenant maksimal 200 karakter.';
            }
            if (mb_strlen(trim((string)$this->input->post('remarks'))) > 255) {
                return 'Remarks maksimal 255 karakter.';
            }
        }

        $ptype = strtoupper(trim((string)$this->input->post('periode_type')));
        if ($ptype !== '' && !in_array($ptype, array('WEEKLY', 'MONTHLY', '3 MONTHS', '4 MONTHS', '6 MONTHS', 'YEARLY'), true)) {
            return 'Tipe periode tidak valid.';
        }

        $status = strtoupper(trim((string)$this->input->post('unit_status')));
        $current = $exclude_unit_id > 0 ? $this->model_casualleasing->get_unit($exclude_unit_id) : null;
        $current_status = $current ? strtoupper(trim((string)$current['unit_status'])) : '';
        if (!in_array($status, array('VACANT', 'RENEWAL'), true) &&
            !($status === 'OCCUPIED' && $current_status === 'OCCUPIED')) {
            return 'Status unit tidak valid.';
        }

        $numeric = array('budget', 'w1', 'w2', 'w3', 'w4');
        if (!$use_master) { array_unshift($numeric, 'nla'); }
        foreach ($numeric as $k) {
            $raw = trim((string)$this->input->post($k));
            if ($raw !== '' && !preg_match('/^-?[0-9.,\s]+$/', $raw)) {
                return 'Format nilai ' . strtoupper($k) . ' tidak valid.';
            }
            if ($this->model_casualleasing->parse_number($raw) < 0) {
                return 'Nilai ' . strtoupper($k) . ' tidak boleh negatif.';
            }
        }

        $ps_raw = trim((string)$this->input->post('periode_start'));
        $pe_raw = trim((string)$this->input->post('periode_end'));
        $ps = $this->model_casualleasing->parse_date($ps_raw);
        $pe = $this->model_casualleasing->parse_date($pe_raw);
        if ($ps_raw !== '' && $ps === null) { return 'Tanggal mulai tidak valid.'; }
        if ($pe_raw !== '' && $pe === null) { return 'Tanggal akhir tidak valid.'; }

        return true;
    }

    function save() {
        $err = $this->_unit_error();
        if ($err !== true) {
            $this->_form_fail(site_url(self::base . '/add'), $err);
            return;
        }
        $id = $this->model_casualleasing->save_unit();
        if (!$id) {
            $this->_form_fail(site_url(self::base . '/add'), 'Gagal menyimpan budget. Silakan coba lagi.');
            return;
        }
        $this->session->set_flashdata('cl_msg', 'Budget berhasil ditambahkan.');
        redirect(self::base . '/load?p=' . urlencode($this->input->post('periode_id')));
    }

    function update() {
        $unit_id = (int)$this->uri->segment(4);
        $row = $this->model_casualleasing->get_unit($unit_id);
        if ($unit_id <= 0 || !$row) {
            redirect(self::base . '/load');
            return;
        }
        $err = $this->_unit_error($unit_id, isset($row['unit_master_id']) ? (int)$row['unit_master_id'] : 0);
        if ($err !== true) {
            $this->_form_fail(site_url(self::base . '/edit/' . $unit_id), $err);
            return;
        }
        if (!$this->model_casualleasing->update_unit($unit_id)) {
            $this->_form_fail(site_url(self::base . '/edit/' . $unit_id), 'Gagal memperbarui budget. Silakan coba lagi.');
            return;
        }
        $this->session->set_flashdata('cl_msg', 'Budget berhasil diperbarui.');
        redirect(self::base . '/load?p=' . urlencode($this->input->post('periode_id')));
    }

    function delete() {
        $unit_id = (int)$this->input->post('unit_id');
        $ok = $this->model_casualleasing->delete_unit($unit_id);
        $this->_json(array('ok' => (bool)$ok));
    }

    function setoccupied() {
        $unit_id = (int)$this->input->post('unit_id');
        $ok = $this->model_casualleasing->set_occupied($unit_id);
        $this->_json(array('ok' => (bool)$ok));
    }

    /** Output JSON bersih (hindari whitespace/newline dari include lain). */
    private function _json($data) {
        if (!headers_sent()) { header('Content-Type: application/json; charset=utf-8'); }
        echo json_encode($data);
    }

    // ==================================================================
    //  BUDGET (halaman utama)
    // ==================================================================
    function budget() {
        $periode = $this->_periode();
        $data['periode']   = $periode;
        $data['periodes']  = $this->model_casualleasing->get_periode_options();
        $data['periodeRow']= $this->model_casualleasing->get_periode($periode);
        $data['summary']   = $this->model_casualleasing->get_summary($periode);
        $this->breadcrumbcomponent->add('CL Budget', self::base . '/load')->add('Ringkasan Budget');
        $this->load->view('template/v_header');
        $this->load->view('casualleasing/summary', $data);
        $this->load->view('template/v_footer');
    }

    /** URL lama Summary diarahkan ke Budget. */
    function summary() {
        $q = $this->input->get('p');
        redirect(self::base . '/budget' . ($q ? '?p=' . urlencode($q) : ''));
    }

    function setoccupied_bulk() {
        $ids = $this->input->post('unit_id');
        $n = $this->model_casualleasing->set_occupied_bulk($ids);
        $this->_json(array('ok' => $n > 0, 'count' => (int)$n));
    }

    function delete_bulk() {
        $ids = $this->input->post('unit_id');
        $n = $this->model_casualleasing->delete_bulk($ids);
        $this->_json(array('ok' => $n > 0, 'count' => (int)$n));
    }

    // ==================================================================
    //  IMPORT / EXPORT
    // ==================================================================
    function import() {
        $data['periodes']    = $this->model_casualleasing->get_periode_options();
        $data['sel_periode'] = $this->_periode();
        $data['result']      = $this->session->flashdata('cl_import_result');
        if ($data['result'] !== null) { $this->session->unset_userdata('cl_import_result'); }
        $this->breadcrumbcomponent->add('CL Budget', self::base . '/load')->add('Import Excel');
        $this->load->view('template/v_header');
        $this->load->view('casualleasing/import', $data);
        $this->load->view('template/v_footer');
    }

    function do_import() {
        $periode = $this->input->post('periode_id');
        $mode    = $this->input->post('mode') === 'replace' ? 'replace' : 'append';

        if (!preg_match('/^\d{4}-\d{2}$/', (string)$periode)) {
            $this->session->set_flashdata('cl_import_result', array('error' => 'Periode tujuan tidak valid.'));
            redirect(self::base . '/import'); return;
        }

        $upload_path = './assets/uploads/casualleasing/';
        if (!is_dir($upload_path)) { @mkdir($upload_path, 0777, true); }

        $config = array(
            'upload_path'   => $upload_path,
            'allowed_types' => 'xlsx',
            'max_size'      => 10240,
            'file_name'     => 'cl_' . date('YmdHis') . '.xlsx'
        );
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file_excel')) {
            $this->session->set_flashdata('cl_import_result', array('error' => 'Upload gagal: ' . $this->upload->display_errors('', '')));
            redirect(self::base . '/import'); return;
        }
        $info = $this->upload->data();
        $read = $this->model_casualleasing->read_xlsx_rows($info['full_path']);
        if (isset($read['error'])) {
            @unlink($info['full_path']);
            $this->session->set_flashdata('cl_import_result', array('error' => $read['error']));
            redirect(self::base . '/import'); return;
        }
        $rows = $read['rows'];
        @unlink($info['full_path']);   // file tidak diperlukan setelah dibaca
        if (count($rows) == 0) {
            $this->session->set_flashdata('cl_import_result', array('error' => 'Tidak ada baris data yang terbaca. Pastikan nama sheet ATRIUM / KORIDOR / VACANT UNIT / OTHER dan kolom NO terisi.'));
            redirect(self::base . '/import'); return;
        }

        $res = $this->model_casualleasing->import_rows($periode, $rows, $mode);
        $res['rows_read'] = count($rows);
        $res['mode']      = $mode;
        $res['periode']   = $periode;
        $res['file']      = $info['file_name'];
        $this->session->set_flashdata('cl_import_result', $res);
        redirect(self::base . '/import');
    }

    function download_template() {
        $path = FCPATH . 'docs/Template_CL_OCT_2026_CIBUBUR.xlsx';
        if (!is_file($path)) { show_404(); return; }
        $this->load->helper('download');
        force_download('Template_CL_CIBUBUR.xlsx', file_get_contents($path));
    }

    function budget_print() {
        $periode = $this->_periode();
        $data['periode']    = $periode;
        $data['periodeRow'] = $this->model_casualleasing->get_periode($periode);
        $data['summary']    = $this->model_casualleasing->get_summary($periode);
        $this->load->view('casualleasing/summary_print', $data);
    }

    /** Kompatibilitas URL lama. */
    function summary_print() { $this->budget_print(); }

    /** Lengkapi baris unit dengan fcst, ARR, dan teks periode. */
    private function _decorate_units($units) {
        foreach ($units as &$u) {
            $u['fcst'] = (float)$u['occupied'] + (float)$u['prospek'];
            $u['arr_budget']   = $this->_arr($u['budget'], $u['nla']);
            $u['arr_occupied'] = $this->_arr($u['occupied'], $u['nla']);
            $u['arr_prospek']  = $this->_arr($u['prospek'], $u['nla']);
            $u['arr_fcst']     = $this->_arr($u['fcst'], $u['nla']);
            $u['periode_display'] = $this->_periode_display($u);
        }
        unset($u);
        return $units;
    }

    private function _unit_filter_text($tipe, $lokasi, $status, $keyword) {
        $parts = array();
        if ($tipe !== '') {
            $tipe_label = $tipe;
            foreach ($this->model_casualleasing->get_tipe_options() as $id => $name) {
                if ((string)$id === (string)$tipe) { $tipe_label = $name; break; }
            }
            $parts[] = 'Tipe: ' . $tipe_label;
        }
        if ($lokasi !== '') {
            foreach ($this->model_casualleasing->get_lokasi_options() as $l) {
                if ((string)$l['lokasi_id'] === (string)$lokasi) {
                    $parts[] = 'Lokasi: ' . $l['tipe_id'] . ' ' . $l['lokasi_code'];
                    break;
                }
            }
        }
        if ($status !== '') { $parts[] = 'Status: ' . $status; }
        if ($keyword !== '') { $parts[] = 'Cari: "' . $keyword . '"'; }
        return count($parts) ? implode(' · ', $parts) : 'Semua data';
    }

    /** Cetak daftar unit (A4 landscape) sesuai filter yang sedang aktif. */
    function unit_print() {
        $periode = $this->_periode();
        $tipe    = (string)$this->input->get('tipe');
        $lokasi  = (string)$this->input->get('lokasi');
        $status  = (string)$this->input->get('status');
        $keyword = (string)$this->input->get('q');

        $data['periode']     = $periode;
        $data['periodeRow']  = $this->model_casualleasing->get_periode($periode);
        $data['units']       = $this->_decorate_units($this->model_casualleasing->get_units($periode, $tipe, $lokasi, $status, $keyword));
        $data['filter_text'] = $this->_unit_filter_text($tipe, $lokasi, $status, $keyword);
        $this->load->view('casualleasing/unit_print', $data);
    }

    /** Label tenant: satu id (unit_label/{id}) atau banyak id (?ids=1,2,3). */
    function unit_label() {
        $ids = array();
        $raw = $this->input->get('ids');
        if ($raw !== null && $raw !== '') {
            foreach (explode(',', $raw) as $x) {
                $x = (int)$x;
                if ($x > 0) { $ids[] = $x; }
            }
        }
        if (!count($ids)) {
            $segment = (int)$this->uri->segment(4);
            if ($segment > 0) { $ids[] = $segment; }
        }
        $ids = array_values(array_unique($ids));
        if (!count($ids)) { show_404(); return; }

        $units = array();
        foreach ($ids as $id) {
            $u = $this->model_casualleasing->get_unit($id);
            if ($u) {
                $u['periode_display'] = $this->_periode_display($u);
                $units[] = $u;
            }
        }
        if (!count($units)) { show_404(); return; }

        $data['units'] = $units;
        $this->load->view('casualleasing/unit_label', $data);
    }

    // ==================================================================
    //  MASTER — pola standar: list -> view -> form
    // ==================================================================
    private function _master_page($view, $title, $data = array()) {
        if (!isset($data['msg'])) {
            $data['msg'] = $this->session->flashdata('cl_msg');
            if ($data['msg'] !== null) { $this->session->unset_userdata('cl_msg'); }
        }
        if (!isset($data['err'])) {
            $data['err'] = $this->session->flashdata('cl_err');
            if ($data['err'] !== null) { $this->session->unset_userdata('cl_err'); }
        }
        $this->breadcrumbcomponent->add('CL Unit', self::base . '/unit_master')->add($title);
        $this->load->view('template/v_header');
        $this->load->view('casualleasing/' . $view, $data);
        $this->load->view('template/v_footer');
    }

    /** Input lama setelah validasi gagal (disimpan sementara di session). */
    private function _old_input() {
        $old = $this->session->flashdata('cl_old');
        if ($old !== null) { $this->session->unset_userdata('cl_old'); }
        return is_array($old) ? $old : array();
    }

    private function _form_fail($url, $message) {
        $this->session->set_flashdata('cl_err', $message);
        $this->session->set_flashdata('cl_old', $this->input->post());
        redirect($url);
    }

    /** URL lama -> halaman master pertama */
    function master() { redirect(self::base . '/master_lokasi'); }

    /** Lokasi + statistik unit master untuk form/list. */
    private function _lokasi_unit_stats() {
        $lokasis = $this->model_casualleasing->get_lokasi_options();
        $stats = $this->model_casualleasing->get_unit_master_stats();
        foreach ($lokasis as &$l) {
            $lid = (int)$l['lokasi_id'];
            $s = isset($stats[$lid]) ? $stats[$lid] : null;
            $l['unit_count'] = $s ? (int)$s['unit_count'] : 0;
            $l['used_nla']   = $s ? (float)$s['used_nla'] : 0;
            $l['next_no']    = $s ? ((int)$s['max_no'] + 1) : 1;
        }
        unset($l);
        return $lokasis;
    }

    // ---------- UNIT MASTER (unit fisik + NLA) ----------
    function unit_master() {
        $q      = trim((string)$this->input->get('q'));
        $lokasi = (int)$this->input->get('lokasi');
        $status = $this->input->get('status');
        $status = ($status === '0' || $status === '1') ? $status : '';

        $this->_master_page('unit_master_list', 'Daftar Unit', array(
            'rows'       => $this->model_casualleasing->get_unit_master_list(array(
                'q' => $q, 'lokasi_id' => $lokasi, 'isactive' => $status
            )),
            'lokasis'    => $this->_lokasi_unit_stats(),
            'available'  => $this->model_casualleasing->has_unit_master(),
            'q'          => $q,
            'sel_lokasi' => $lokasi,
            'sel_status' => $status
        ));
    }

    function unit_master_view($id = 0) {
        $row = $this->model_casualleasing->get_unit_master_row((int)$id);
        if (!$row) { show_404(); return; }
        $stats = $this->model_casualleasing->get_unit_master_stats();
        $lid = (int)$row['lokasi_id'];
        $data = array(
            'row'     => $row,
            'budgets' => $this->model_casualleasing->get_unit_master_budgets((int)$row['unit_master_id']),
            'used'    => isset($stats[$lid]) ? (float)$stats[$lid]['used_nla'] : 0
        );
        $this->_master_page('unit_master_view', 'Detail Unit', $data);
    }

    function unit_master_form($id = 0) {
        if (!$this->model_casualleasing->has_unit_master()) {
            $this->session->set_flashdata('cl_err', 'Tabel master unit belum tersedia. Jalankan migrasi 06 terlebih dahulu.');
            redirect(self::base . '/unit_master');
            return;
        }
        $id = (int)$id;
        if ($id > 0) {
            $row = $this->model_casualleasing->get_unit_master_row($id);
            if (!$row) { show_404(); return; }
        } else {
            $row = array(
                'unit_master_id' => 0,
                'lokasi_id' => '',
                'unit_no' => '',
                'unit_name' => '',
                'nla' => 0,
                'unit_isactive' => 1
            );
        }
        $old = $this->_old_input();
        if (!empty($old)) { $row = array_merge($row, $old); }
        $this->_master_page('unit_master_form', $id > 0 ? 'Edit Unit' : 'Tambah Unit', array(
            'row' => $row,
            'is_edit' => $id > 0,
            'lokasis' => $this->_lokasi_unit_stats()
        ));
    }

    function unit_master_save() {
        if ($this->input->method() !== 'post') { show_404(); return; }
        $id = (int)$this->input->post('unit_master_id');
        $url = self::base . '/unit_master_form' . ($id > 0 ? '/' . $id : '');
        $res = $this->model_casualleasing->save_unit_master_row(
            $id,
            $this->input->post('lokasi_id'),
            $this->input->post('unit_no'),
            $this->input->post('unit_name'),
            $this->input->post('nla'),
            $this->input->post('unit_isactive')
        );
        if ($res !== true) { $this->_form_fail(site_url($url), $res); return; }
        $this->session->set_flashdata('cl_msg', $id > 0 ? 'Unit berhasil diperbarui.' : 'Unit baru berhasil ditambahkan.');
        redirect(self::base . '/unit_master');
    }

    // ---------- PIC ----------
    function master_pic() {
        $this->_master_page('master_pic_list', 'Master PIC', array(
            'pics' => $this->model_casualleasing->get_pic_list()
        ));
    }

    function master_pic_view($id = '') {
        $row = $this->model_casualleasing->get_pic_row($id);
        if (!$row) { show_404(); return; }
        $this->_master_page('master_pic_view', 'Detail PIC', array(
            'row'  => $row,
            'used' => $this->model_casualleasing->count_units(array('pic_id' => $row['pic_id']))
        ));
    }

    function master_pic_form($id = '') {
        $is_edit = ($id !== '');
        $row = $is_edit ? $this->model_casualleasing->get_pic_row($id) : array();
        if ($is_edit && !$row) { show_404(); return; }
        $old = $this->_old_input();
        if (!empty($old)) { $row = array_merge($row, $old); }
        $this->_master_page('master_pic_form', $is_edit ? 'Edit PIC' : 'Tambah PIC', array(
            'row' => $row, 'is_edit' => $is_edit
        ));
    }

    function master_pic_save() {
        if ($this->input->method() !== 'post') { show_404(); return; }
        $is_new = ($this->input->post('is_new') === '1');
        $id     = $is_new ? '' : trim((string)$this->input->post('pic_id_old'));
        $url    = self::base . '/master_pic_form' . ($is_new ? '' : '/' . rawurlencode($id));
        $res = $this->model_casualleasing->save_pic_row(
            $id,
            $this->input->post('pic_id'),
            $this->input->post('pic_name'),
            $this->input->post('pic_isactive'),
            $is_new
        );
        if ($res !== true) { $this->_form_fail($url, $res); return; }
        $this->session->set_flashdata('cl_msg', $is_new ? 'PIC baru berhasil ditambahkan.' : 'PIC berhasil diperbarui.');
        redirect(self::base . '/master_pic');
    }

    // ---------- Tipe ----------
    function master_tipe() {
        $this->_master_page('master_tipe_list', 'Master Tipe', array(
            'tipes' => $this->model_casualleasing->get_tipe_list()
        ));
    }

    function master_tipe_view($id = '') {
        $row = $this->model_casualleasing->get_tipe_row($id);
        if (!$row) { show_404(); return; }
        $this->_master_page('master_tipe_view', 'Detail Tipe', array(
            'row'     => $row,
            'lokasi'  => $this->model_casualleasing->count_lokasi($row['tipe_id']),
            'used'    => $this->model_casualleasing->count_units(array('tipe_id' => $row['tipe_id']))
        ));
    }

    function master_tipe_form($id = '') {
        $is_edit = ($id !== '');
        $row = $is_edit ? $this->model_casualleasing->get_tipe_row($id) : array();
        if ($is_edit && !$row) { show_404(); return; }
        $old = $this->_old_input();
        if (!empty($old)) { $row = array_merge($row, $old); }
        $this->_master_page('master_tipe_form', $is_edit ? 'Edit Tipe' : 'Tambah Tipe', array(
            'row' => $row, 'is_edit' => $is_edit
        ));
    }

    function master_tipe_save() {
        if ($this->input->method() !== 'post') { show_404(); return; }
        $is_new = ($this->input->post('is_new') === '1');
        $id     = $is_new ? '' : trim((string)$this->input->post('tipe_id_old'));
        $url    = self::base . '/master_tipe_form' . ($is_new ? '' : '/' . rawurlencode($id));
        $res = $this->model_casualleasing->save_tipe_row(
            $id,
            $this->input->post('tipe_id'),
            $this->input->post('tipe_name'),
            $this->input->post('tipe_order'),
            $this->input->post('tipe_isactive'),
            $is_new
        );
        if ($res !== true) { $this->_form_fail($url, $res); return; }
        $this->session->set_flashdata('cl_msg', $is_new ? 'Tipe baru berhasil ditambahkan.' : 'Tipe berhasil diperbarui.');
        redirect(self::base . '/master_tipe');
    }

    // ---------- Lokasi ----------
    function master_lokasi() {
        $this->_master_page('master_lokasi_list', 'Master Lokasi', array(
            'lokasis' => $this->model_casualleasing->get_lokasi_list()
        ));
    }

    function master_lokasi_view($id = 0) {
        $row = $this->model_casualleasing->get_lokasi_row($id);
        if (!$row) { show_404(); return; }
        $this->_master_page('master_lokasi_view', 'Detail Lokasi', array(
            'row'  => $row,
            'used' => $this->model_casualleasing->count_units(array('lokasi_id' => $row['lokasi_id']))
        ));
    }

    function master_lokasi_form($id = 0) {
        $id = (int)$id;
        $row = $id > 0 ? $this->model_casualleasing->get_lokasi_row($id) : array();
        if ($id > 0 && !$row) { show_404(); return; }
        $old = $this->_old_input();
        if (!empty($old)) { $row = array_merge($row, $old); }
        $this->_master_page('master_lokasi_form', $id > 0 ? 'Edit Lokasi' : 'Tambah Lokasi', array(
            'row' => $row, 'is_edit' => $id > 0,
            'tipes' => $this->model_casualleasing->get_tipe_list(),
            'lantais' => $this->model_casualleasing->get_lantai_options()
        ));
    }

    function master_lokasi_save() {
        if ($this->input->method() !== 'post') { show_404(); return; }
        $id     = (int)$this->input->post('lokasi_id');
        $is_new = ($id <= 0);
        $url    = self::base . '/master_lokasi_form' . ($is_new ? '' : '/' . $id);
        $res = $this->model_casualleasing->save_lokasi_row(
            $id,
            $this->input->post('tipe_id'),
            $this->input->post('lokasi_code') ? $this->input->post('lokasi_code') : $this->input->post('lokasi_name'), // baru: kode = nama; edit: kode lama dipertahankan
            $this->input->post('lokasi_name'),
            $this->input->post('lokasi_order'),
            $this->input->post('lokasi_isactive'),
            $is_new,
            $this->input->post('lokasi_nla'),
            $this->input->post('lantai_id')
        );
        if ($res !== true) { $this->_form_fail($url, $res); return; }
        $this->session->set_flashdata('cl_msg', $is_new ? 'Lokasi baru berhasil ditambahkan.' : 'Lokasi berhasil diperbarui.');
        redirect(self::base . '/master_lokasi');
    }

    // ---------- Lantai / Area (denah statis) ----------
    function master_lantai() {
        $this->_master_page('master_lantai_list', 'Master Lantai', array(
            'lantais' => $this->model_casualleasing->get_lantai_list()
        ));
    }

    function master_lantai_view($id = 0) {
        $id  = (int)$id;
        $row = $this->model_casualleasing->get_lantai_row($id);
        if (!$row) { show_404(); return; }
        $periode = $this->_periode();
        $this->_master_page('master_lantai_view', 'Detail Lantai', array(
            'row'       => $row,
            'summary'   => $this->model_casualleasing->get_lantai_summary($id, $periode),
            'periode'   => $periode,
            'periodes'  => $this->model_casualleasing->get_periode_options(),
            'sel_periode' => $periode
        ));
    }

    function master_lantai_form($id = 0) {
        $id  = (int)$id;
        $row = $id > 0 ? $this->model_casualleasing->get_lantai_row($id) : array();
        if ($id > 0 && !$row) { show_404(); return; }
        $old = $this->_old_input();
        if (!empty($old)) { $row = array_merge($row, $old); }
        $this->_master_page('master_lantai_form', $id > 0 ? 'Edit Lantai' : 'Tambah Lantai', array(
            'row' => $row, 'is_edit' => $id > 0
        ));
    }

    function master_lantai_save() {
        if ($this->input->method() !== 'post') { show_404(); return; }
        $id     = (int)$this->input->post('lantai_id');
        $is_new = ($id <= 0);
        $url    = self::base . '/master_lantai_form' . ($is_new ? '' : '/' . $id);

        // Upload denah statis (opsional; file lama tetap dipakai bila kosong).
        $map_file = null;
        if (!empty($_FILES['map_file']['name'])) {
            $dir = './assets/uploads/casualleasing/lantai/';
            if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
            $code = strtoupper(trim((string)$this->input->post('lantai_code')));
            $config = array(
                'upload_path'   => $dir,
                'allowed_types' => 'png|jpg|jpeg',
                'max_size'      => 5120,
                'file_name'     => 'map_' . ($code !== '' ? $code : ($id > 0 ? 'l' . $id : 'x')) . '_' . date('YmdHis')
            );
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('map_file')) {
                $this->_form_fail($url, 'Upload denah gagal: ' . $this->upload->display_errors('', ''));
                return;
            }
            $info    = $this->upload->data();
            $map_file = $info['file_name'];
        }

        $res = $this->model_casualleasing->save_lantai_row(
            $id,
            $this->input->post('lantai_code'),
            $this->input->post('lantai_name'),
            $this->input->post('lantai_order'),
            $this->input->post('lantai_jenis'),
            $this->input->post('lantai_isactive'),
            $is_new,
            $map_file
        );
        if ($res !== true) { $this->_form_fail($url, $res); return; }
        $this->session->set_flashdata('cl_msg', $is_new ? 'Lantai/area baru berhasil ditambahkan.' : 'Lantai/area berhasil diperbarui.');
        redirect(self::base . '/master_lantai');
    }

    // ---------- Periode ----------
    function master_periode() {
        $this->_master_page('master_periode_list', 'Master Periode', array(
            'periodes'     => $this->model_casualleasing->get_periode_list(),
            'periodes_opt' => $this->model_casualleasing->get_periode_options(),
            'sel_periode'  => $this->_periode()
        ));
    }

    function master_periode_view($id = '') {
        $row = $this->model_casualleasing->get_periode($id);
        if (!$row) { show_404(); return; }
        $this->_master_page('master_periode_view', 'Detail Periode', array(
            'row'  => $row,
            'used' => $this->model_casualleasing->count_units(array('periode_id' => $row['periode_id']))
        ));
    }

    function master_periode_form($id = '') {
        $is_edit = ($id !== '');
        $row = $is_edit ? $this->model_casualleasing->get_periode($id) : array();
        if ($is_edit && !$row) { show_404(); return; }
        $old = $this->_old_input();
        if (!empty($old)) { $row = array_merge($row, $old); }
        $this->_master_page('master_periode_form', $is_edit ? 'Edit Periode' : 'Tambah Periode', array(
            'row' => $row, 'is_edit' => $is_edit
        ));
    }

    function master_periode_save() {
        if ($this->input->method() !== 'post') { show_404(); return; }
        $is_new = ($this->input->post('is_new') === '1');
        $id     = $is_new ? '' : trim((string)$this->input->post('periode_id_old'));
        $url    = self::base . '/master_periode_form' . ($is_new ? '' : '/' . rawurlencode($id));
        $res = $this->model_casualleasing->save_periode_row(
            $id,
            $this->input->post('periode_id'),
            $this->input->post('periode_name'),
            $this->input->post('periode_isactive'),
            $is_new
        );
        if ($res !== true) { $this->_form_fail($url, $res); return; }
        $this->session->set_flashdata('cl_msg', $is_new ? 'Periode baru berhasil ditambahkan.' : 'Periode berhasil diperbarui.');
        redirect(self::base . '/master_periode');
    }

    function fix_dates() {
        $periode = $this->input->post('periode_id');
        $n = $this->model_casualleasing->fix_periode_dates($periode);
        $this->session->set_flashdata('cl_msg', $n . ' baris tanggal berhasil dilengkapi dari teks periode.');
        redirect(self::base . '/master_periode');
    }
}
