<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$v = function($k, $default = '') use ($row) { return isset($row[$k]) && $row[$k] !== null ? $row[$k] : $default; };
$sel = function($val, $cur) { return (string)$val === (string)$cur ? ' selected' : ''; };
$num = function($x) { return number_format((float)$x, 2, '.', ','); };
?>
<script type="text/javascript">
var LOKASI_ALL = <?php echo json_encode(array_map(function($l){
    return array(
        'lokasi_id' => (int)$l['lokasi_id'],
        'tipe_id'   => $l['tipe_id'],
        'code'      => $l['lokasi_code'],
        'name'      => $l['lokasi_name'],
        'cap'       => isset($l['lokasi_nla']) ? (float)$l['lokasi_nla'] : 0,
        'used'      => isset($l['used_nla']) ? (float)$l['used_nla'] : 0,
        'next_no'   => isset($l['next_no']) ? (int)$l['next_no'] : 1
    );
}, $lokasis)); ?>;
var IS_EDIT = <?php echo !empty($is_edit) ? 'true' : 'false'; ?>;
var AUTO_NO = '';

function clNumber(v){ if (v === null || v === undefined || v === '') return ''; return $.number(v, 2, '.', ','); }
function clRaw(v){
    if (v === null || v === undefined) return 0;
    var s = String(v).replace(/\s/g, '');
    if (s === '') return 0;
    var lc = s.lastIndexOf(','), ld = s.lastIndexOf('.');
    if (lc >= 0 && ld >= 0) {
        if (lc > ld) { s = s.replace(/\./g, '').replace(/,/g, '.'); }
        else { s = s.replace(/,/g, ''); }
    } else if (lc >= 0) {
        if (/^\d{1,3}(,\d{3})+$/.test(s)) { s = s.replace(/,/g, ''); }
        else { s = s.replace(/,/g, '.'); }
    } else if ((s.match(/\./g) || []).length > 1) {
        s = s.replace(/\./g, '');
    }
    var n = parseFloat(s);
    return isNaN(n) ? 0 : n;
}

function clLokasiInfo() {
    var id = $('#lokasi_id').val();
    var lok = null;
    $.each(LOKASI_ALL, function(i, l){ if (String(l.lokasi_id) === String(id)) { lok = l; return false; } });
    if (!lok) {
        $('#lokasi_info').html('<span class="text-muted">Pilih lokasi untuk melihat kapasitas NLA.</span>');
        return;
    }
    var sisa = lok.cap > 0 ? Math.max(0, lok.cap - lok.used) : 0;
    var over = lok.cap > 0 ? Math.max(0, lok.used - lok.cap) : 0;
    var html = 'Kapasitas: <b>' + (lok.cap > 0 ? clNumber(lok.cap) + ' m&sup2;' : '-') + '</b>' +
               ' &middot; NLA unit aktif: <b>' + clNumber(lok.used) + ' m&sup2;</b>';
    if (lok.cap > 0) {
        html += ' &middot; sisa: <b>' + clNumber(sisa) + ' m&sup2;</b>';
        if (over > 0) { html += ' <span class="text-danger">&middot; OVER ' + clNumber(over) + ' m&sup2;</span>'; }
    }
    $('#lokasi_info').html(html);

    if (!IS_EDIT && ( $('#unit_no').val() === '' || $('#unit_no').val() === AUTO_NO )) {
        AUTO_NO = String(lok.next_no);
        $('#unit_no').val(AUTO_NO);
    }
}

$(document).ready(function(){
    if ($.fn.select2) { $('#lokasi_id').select2({ width: '100%' }); }
    clLokasiInfo();
    $('#lokasi_id').on('change', clLokasiInfo);

    $('#nla').each(function(){ $(this).val($.number(clRaw($(this).val()), 2, '.', ',')); });
    $('#nla').on('change blur', function(){ $(this).val($.number(clRaw($(this).val()), 2, '.', ',')); });

    $('#frmUnitMaster').on('submit', function(){
        $('#nla').val(clRaw($('#nla').val()));
        return true;
    });
});
</script>

<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-cube font-green-haze"></i>
          <span class="caption-subject bold uppercase"><?php echo !empty($is_edit) ? 'Edit Unit' : 'Tambah Unit'; ?></span>
          <span class="caption-helper">Unit fisik dan NLA. Budget tidak diinput di halaman ini.</span>
        </div>
        <div class="actions">
          <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/unit_master'); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
      </div>
      <div class="portlet-body form">
        <?php if (!empty($msg)) { ?>
          <div class="alert alert-success"><i class="fa fa-check"></i> <?php echo htmlspecialchars($msg); ?></div>
        <?php } ?>
        <?php if (!empty($err)) { ?>
          <div class="alert alert-danger"><i class="fa fa-warning"></i> <?php echo htmlspecialchars($err); ?></div>
        <?php } ?>

        <?php echo form_open(site_url('casualleasing/casualleasing/unit_master_save'), array('id' => 'frmUnitMaster', 'class' => 'form-horizontal')); ?>
          <div class="form-body">
            <input type="hidden" name="unit_master_id" value="<?php echo (int)$v('unit_master_id', 0); ?>">

            <div class="form-group">
              <label class="control-label col-md-3">Lokasi <span class="required">*</span></label>
              <div class="col-md-6">
                <select name="lokasi_id" id="lokasi_id" class="form-control" required>
                  <option value="">- pilih lokasi -</option>
                  <?php foreach ($lokasis as $l) {
                    $lbl = $l['tipe_id'] . ' ' . $l['lokasi_code'] . ' - ' . $l['lokasi_name'];
                    echo '<option value="' . (int)$l['lokasi_id'] . '"' . $sel($l['lokasi_id'], $v('lokasi_id')) . '>' . htmlspecialchars($lbl) . '</option>';
                  } ?>
                </select>
                <div class="well well-sm" id="lokasi_info" style="margin-top:8px;"></div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">No. Unit <span class="required">*</span></label>
              <div class="col-md-3">
                <input type="text" name="unit_no" id="unit_no" class="form-control" value="<?php echo htmlspecialchars((string)$v('unit_no')); ?>" placeholder="1" required>
                <span class="help-block">Unik per lokasi.</span>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">Nama Unit <span class="required">*</span></label>
              <div class="col-md-6">
                <input type="text" name="unit_name" id="unit_name" class="form-control" maxlength="150" value="<?php echo htmlspecialchars((string)$v('unit_name')); ?>" placeholder="Contoh: ATRIUM, LGC 03, PARKIR" required>
                <span class="help-block">Nama boleh sama untuk unit berbeda; identitas unik adalah lokasi + no. unit.</span>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">NLA (m&sup2;) <span class="required">*</span></label>
              <div class="col-md-3">
                <div class="input-group">
                  <input type="text" name="nla" id="nla" class="form-control text-right" value="<?php echo htmlspecialchars($num($v('nla', 0))); ?>" placeholder="0.00" required>
                  <span class="input-group-addon">m&sup2;</span>
                </div>
                <span class="help-block">Isi 0 bila unit tidak memiliki NLA (mis. parkir).</span>
              </div>
            </div>

            <div class="form-group last">
              <label class="control-label col-md-3">Status</label>
              <div class="col-md-5">
                <input type="hidden" name="unit_isactive" value="0">
                <label class="checkbox-inline"><input type="checkbox" name="unit_isactive" value="1" <?php echo (!isset($row['unit_isactive']) || !empty($row['unit_isactive']) ? 'checked' : ''); ?>> Aktif</label>
                <span class="help-block">Unit nonaktif tidak muncul saat memilih unit di form Budget, tetapi budget lama tetap tersimpan.</span>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <div class="row">
              <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/unit_master'); ?>">Batal</a>
              </div>
            </div>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
