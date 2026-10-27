<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$row  = $row;
$mode = $mode;
$has_master = !empty($has_unit_master);
$v = function($k, $default = '') use ($row) { return isset($row[$k]) && $row[$k] !== null ? $row[$k] : $default; };
$sel = function($val, $cur) { return (string)$val === (string)$cur ? ' selected' : ''; };
$dmy = function($d) { if (!$d) return ''; $t = strtotime($d); return $t ? date('d-m-Y', $t) : $d; };
$title = $mode === 'edit' ? 'Edit Budget' : 'Input Budget';
?>
<script type="text/javascript">
var HAS_UNIT_MASTER = <?php echo $has_master ? 'true' : 'false'; ?>;
var LOKASI_ALL = <?php echo json_encode(array_map(function($l){
    return array(
        'lokasi_id' => (int)$l['lokasi_id'],
        'tipe_id'   => $l['tipe_id'],
        'code'      => $l['lokasi_code'],
        'name'      => $l['lokasi_name'],
        'nla'       => isset($l['lokasi_nla']) ? (float)$l['lokasi_nla'] : 0
    );
}, $lokasis)); ?>;

function clNumber(v){ if (v === null || v === undefined || v === '') return ''; return $.number(v, 2, '.', ','); }
/* Baca angka format #,##0.00 (1,429,022.08) maupun format Indonesia (1.429.022,08). */
function clRaw(v){
    if (v === null || v === undefined) return 0;
    var s = String(v).replace(/\s/g, '');
    if (s === '') return 0;
    var lc = s.lastIndexOf(','), ld = s.lastIndexOf('.');
    if (lc >= 0 && ld >= 0) {
        if (lc > ld) { s = s.replace(/\./g, '').replace(/,/g, '.'); }   // 1.429.022,08
        else { s = s.replace(/,/g, ''); }                               // 1,429,022.08
    } else if (lc >= 0) {
        if (/^\d{1,3}(,\d{3})+$/.test(s)) { s = s.replace(/,/g, ''); }  // 1,429,022
        else { s = s.replace(/,/g, '.'); }                              // 0,5
    } else if ((s.match(/\./g) || []).length > 1) {
        s = s.replace(/\./g, '');                                       // 1.429.022
    }
    var n = parseFloat(s);
    return isNaN(n) ? 0 : n;
}
function clFmtVal(v){ return $.number(clRaw(v), 2, '.', ','); }
function clFmtInput(el){ var $e = $(el); $e.val(clFmtVal($e.val())); }

function clLokasiInfo() {
    var id = $('#lokasi_id').val();
    var lok = null;
    $.each(LOKASI_ALL, function(i, l){ if (String(l.lokasi_id) === String(id)) { lok = l; return false; } });
    if (lok && lok.nla > 0) {
        $('#lokasi_nla_help').html('Kapasitas lokasi: <b>' + clNumber(lok.nla) + ' m&sup2;</b>.');
    } else {
        $('#lokasi_nla_help').html('NLA unit diambil dari master unit.');
    }
}

function clFilterLokasi() {
    var tipe = $('#tipe_id').val();
    var cur  = $('#lokasi_id').val();
    var $s   = $('#lokasi_id');
    $s.empty().append('<option value="">- pilih -</option>');
    $.each(LOKASI_ALL, function(i, l){
        if (l.tipe_id === tipe) {
            var label = l.tipe_id + ' - ' + l.code;
            if (l.nla > 0) { label += ' (kap. ' + clNumber(l.nla) + ' m2)'; }
            $s.append($('<option>').val(l.lokasi_id).text(label));
        }
    });
    if (cur && $s.find('option[value="' + cur + '"]').length) { $s.val(cur); }
    clLokasiInfo();
}

function clUnitInfo() {
    if (!HAS_UNIT_MASTER) { return; }
    var $opt = $('#unit_master_id option:selected');
    var id = $opt.val();
    if (!id) {
        $('#unit_info').html('<span class="text-muted">Pilih unit untuk melihat lokasi dan NLA.</span>');
        $('#nla').val(0);
        return;
    }
    var nla = parseFloat($opt.attr('data-nla')) || 0;
    var tipe = $opt.attr('data-tipe') || '';
    var lokasi = $opt.attr('data-lokasi') || '';
    var unit = $opt.attr('data-unit') || '';
    $('#nla').val(nla);
    $('#unit_info').html(
        '<i class="fa fa-cube text-primary"></i> <b>' + $('<div>').text(unit).html() + '</b>' +
        '<span class="text-muted"> &middot; ' + $('<div>').text(tipe + ' ' + lokasi).html() + '</span><br>' +
        '<span class="text-muted">NLA: </span><b>' + clNumber(nla) + ' m&sup2;</b>'
    );
}

function clHitungProspek() {
    var total = clRaw($('#w1').val()) + clRaw($('#w2').val()) + clRaw($('#w3').val()) + clRaw($('#w4').val());
    $('#prospek_total').val(clFmtVal(total));
}

$(document).ready(function(){
    if ($.fn.datepicker) {
        $('.cl-date').datepicker({ format: 'dd-mm-yyyy', autoclose: true, todayHighlight: true, orientation: 'bottom auto' });
    }
    $('.cl-date-addon').on('click', function(){ $(this).siblings('.cl-date').focus(); });
    if ($.fn.select2) {
        $('#tipe_id, #lokasi_id, #pic_id, #unit_status, #periode_type, #periode_id, #unit_master_id').select2({ width: '100%' });
    }

    if (HAS_UNIT_MASTER) {
        clUnitInfo();
        $('#unit_master_id').on('change', clUnitInfo);
    } else {
        clFilterLokasi();
        $('#tipe_id').on('change', clFilterLokasi);
        $('#lokasi_id').on('change', clLokasiInfo);
    }

    $('#nla, #budget, #w1, #w2, #w3, #w4, #prospek_total').each(function(){ clFmtInput(this); });
    clHitungProspek();

    $('#nla, #budget').on('change blur', function(){ clFmtInput(this); });
    $('#w1, #w2, #w3, #w4').on('change blur', function(){
        clHitungProspek();
        clFmtInput(this);
    });

    $('#frmBudget').on('submit', function(){
        $('#nla, #budget, #w1, #w2, #w3, #w4').each(function(){
            $(this).val(clRaw($(this).val()));
        });
        // tanggal dd-mm-yyyy -> yyyy-mm-dd untuk disimpan
        $('.cl-date').each(function(){
            var s = $.trim($(this).val());
            var m = s.match(/^(\d{1,2})-(\d{1,2})-(\d{4})$/);
            if (m) {
                $(this).val(m[3] + '-' + ('0' + m[2]).slice(-2) + '-' + ('0' + m[1]).slice(-2));
            }
        });
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
          <i class="icon-note font-green-haze"></i>
          <span class="caption-subject bold uppercase"><?php echo $title; ?></span>
          <span class="caption-helper">Pilih unit, lalu input nilai W1&ndash;W4.</span>
        </div>
        <div class="actions">
          <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/load?p=' . urlencode($v('periode_id'))); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
      </div>
      <div class="portlet-body form">
        <?php if (!empty($err)) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo htmlspecialchars($err); ?></div>
        <?php } ?>
        <?php if ($has_master && count($unit_masters) == 0) { ?>
        <div class="alert alert-warning"><i class="fa fa-warning"></i> Belum ada unit master. Tambahkan unit dan NLA di menu <b>CL Unit</b> terlebih dahulu.</div>
        <?php } ?>
        <?php echo form_open($action, array('id' => 'frmBudget', 'class' => 'form-horizontal')); ?>
          <div class="form-body">
            <h4 class="form-section"><i class="fa fa-building-o"></i> Periode, Unit &amp; Tenant</h4>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-4 control-label">Periode <span class="required">*</span></label>
                  <div class="col-md-8">
                    <select name="periode_id" id="periode_id" class="form-control" required>
                      <?php foreach ($periodes as $k => $nm) { echo '<option value="' . htmlspecialchars($k) . '"' . $sel($k, $v('periode_id')) . '>' . htmlspecialchars($nm) . '</option>'; } ?>
                    </select>
                  </div>
                </div>

                <?php if ($has_master) { ?>
                <div class="form-group">
                  <label class="col-md-4 control-label">Unit <span class="required">*</span></label>
                  <div class="col-md-8">
                    <select name="unit_master_id" id="unit_master_id" class="form-control" required>
                      <option value="">- pilih unit -</option>
                      <?php foreach ($unit_masters as $m) {
                        $lbl = $m['tipe_name'] . ' - ' . $m['lokasi_code'] . ' - No. ' . (int)$m['unit_no'] . ' ' . $m['unit_name'];
                        if ((int)$m['unit_isactive'] !== 1) { $lbl .= ' (nonaktif)'; }
                        $lbl .= ' (' . number_format((float)$m['nla'], 2, '.', ',') . ' m2)';
                        echo '<option value="' . (int)$m['unit_master_id'] . '"' .
                             ' data-tipe="' . htmlspecialchars($m['tipe_id']) . '"' .
                             ' data-lokasi="' . htmlspecialchars($m['lokasi_code']) . '"' .
                             ' data-unit="' . htmlspecialchars($m['unit_name']) . '"' .
                             ' data-nla="' . (float)$m['nla'] . '"' .
                             $sel($m['unit_master_id'], $v('unit_master_id')) . '>' .
                             htmlspecialchars($lbl) . '</option>';
                      } ?>
                    </select>
                    <div class="well well-sm cl-unit-info" id="unit_info" style="margin-top:8px;"></div>
                    <span class="help-block">NLA dan ARR mengikuti master unit. Ubah NLA di menu <b>CL Unit</b>.</span>
                  </div>
                </div>
                <input type="hidden" name="nla" id="nla" value="<?php echo htmlspecialchars($v('nla', 0)); ?>">
                <?php } else { ?>
                <div class="form-group">
                  <label class="col-md-4 control-label">Tipe Lokasi <span class="required">*</span></label>
                  <div class="col-md-8">
                    <select name="tipe_id" id="tipe_id" class="form-control" required>
                      <option value="">- pilih -</option>
                      <?php foreach ($tipes as $k => $nm) { echo '<option value="' . htmlspecialchars($k) . '"' . $sel($k, $v('tipe_id')) . '>' . htmlspecialchars($nm) . '</option>'; } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Lokasi <span class="required">*</span></label>
                  <div class="col-md-8">
                    <select name="lokasi_id" id="lokasi_id" class="form-control" required>
                      <option value="">- pilih -</option>
                      <?php foreach ($lokasis as $l) {
                        $cap = isset($l['lokasi_nla']) ? (float)$l['lokasi_nla'] : 0;
                        $lbl = $l['tipe_id'] . ' - ' . $l['lokasi_code'] . ($cap > 0 ? ' (kap. ' . number_format($cap, 2, '.', ',') . ' m2)' : '');
                        echo '<option value="' . (int)$l['lokasi_id'] . '"' . $sel($l['lokasi_id'], $v('lokasi_id')) . '>' . htmlspecialchars($lbl) . '</option>';
                      } ?>
                    </select>
                    <span class="help-block" id="lokasi_nla_help"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Unit <span class="required">*</span></label>
                  <div class="col-md-8">
                    <input type="text" name="unit_name" id="unit_name" class="form-control" value="<?php echo htmlspecialchars($v('unit_name')); ?>" placeholder="Contoh: ATRIUM GF-01" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">No Urut</label>
                  <div class="col-md-8">
                    <input type="text" name="unit_no" id="unit_no" class="form-control" value="<?php echo htmlspecialchars($v('unit_no')); ?>" placeholder="Nomor urut unit">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">NLA (m&sup2;) <span class="required">*</span></label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <input type="text" name="nla" id="nla" class="form-control text-right" value="<?php echo htmlspecialchars($v('nla')); ?>" required>
                      <span class="input-group-addon">m&sup2;</span>
                    </div>
                  </div>
                </div>
                <?php } ?>

                <div class="form-group">
                  <label class="col-md-4 control-label">PIC</label>
                  <div class="col-md-8">
                    <select name="pic_id" id="pic_id" class="form-control">
                      <option value="">- pilih -</option>
                      <?php foreach ($pics as $k => $nm) { echo '<option value="' . htmlspecialchars($k) . '"' . $sel($k, $v('pic_id')) . '>' . htmlspecialchars($nm) . '</option>'; } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group last">
                  <label class="col-md-4 control-label">Status <span class="required">*</span></label>
                  <div class="col-md-8">
                    <?php if ($v('unit_status') === 'OCCUPIED') { ?><input type="hidden" name="unit_status" value="OCCUPIED"><?php } ?>
                    <select <?php echo $v('unit_status') === 'OCCUPIED' ? 'disabled ' : 'name="unit_status" '; ?>id="unit_status" class="form-control" required>
                      <?php foreach ($statuses as $k => $nm) { ?>
                        <option value="<?php echo htmlspecialchars($k); ?>"<?php echo $sel($k, $v('unit_status', 'VACANT')); ?><?php echo $k === 'OCCUPIED' ? ' disabled' : ''; ?>><?php echo htmlspecialchars($nm); ?></option>
                      <?php } ?>
                    </select>
                    <span class="help-block">Aksi <strong>Jadikan Occupied</strong> di daftar memindahkan prospek ke Occupied dan mengosongkan W1&ndash;W4.</span>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-4 control-label">Tenant</label>
                  <div class="col-md-8">
                    <input type="text" name="tenant" id="tenant" class="form-control" value="<?php echo htmlspecialchars($v('tenant')); ?>" placeholder="Nama tenant / calon tenant">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Tipe Periode</label>
                  <div class="col-md-8">
                    <select name="periode_type" id="periode_type" class="form-control">
                      <option value="">- pilih -</option>
                      <?php foreach ($periodetypes as $pt) { echo '<option value="' . htmlspecialchars($pt) . '"' . $sel($pt, $v('periode_type')) . '>' . htmlspecialchars($pt) . '</option>'; } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Periode Mulai</label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <span class="input-group-addon cl-date-addon" title="Pilih tanggal"><i class="fa fa-calendar"></i></span>
                      <input type="text" name="periode_start" id="periode_start" class="form-control cl-date" value="<?php echo htmlspecialchars($dmy($v('periode_start'))); ?>" placeholder="dd-mm-yyyy">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Periode Selesai</label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <span class="input-group-addon cl-date-addon" title="Pilih tanggal"><i class="fa fa-calendar"></i></span>
                      <input type="text" name="periode_end" id="periode_end" class="form-control cl-date" value="<?php echo htmlspecialchars($dmy($v('periode_end'))); ?>" placeholder="dd-mm-yyyy">
                    </div>
                  </div>
                </div>
                <div class="form-group last">
                  <label class="col-md-4 control-label">Catatan</label>
                  <div class="col-md-8">
                    <textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Catatan tambahan (opsional)"><?php echo htmlspecialchars($v('remarks')); ?></textarea>
                  </div>
                </div>
              </div>
            </div>

            <h4 class="form-section"><i class="fa fa-calculator"></i> Nilai &amp; Prospek</h4>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-4 control-label">Budget (Rp)</label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <span class="input-group-addon">Rp</span>
                      <input type="text" name="budget" id="budget" class="form-control text-right" value="<?php echo htmlspecialchars($v('budget', 0)); ?>">
                    </div>
                    <span class="help-block">Input langsung nilai budget untuk unit ini.</span>
                  </div>
                </div>
                <div class="form-group last">
                  <label class="col-md-4 control-label">Occupied (Rp)</label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <span class="input-group-addon">Rp</span>
                      <input type="text" id="occupied" class="form-control text-right" value="<?php echo htmlspecialchars($v('occupied', 0)); ?>" disabled>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-4 control-label">W1 (Rp)</label>
                  <div class="col-md-8">
                    <input type="text" name="w1" id="w1" class="form-control text-right" value="<?php echo htmlspecialchars($v('w1', 0)); ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">W2 (Rp)</label>
                  <div class="col-md-8">
                    <input type="text" name="w2" id="w2" class="form-control text-right" value="<?php echo htmlspecialchars($v('w2', 0)); ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">W3 (Rp)</label>
                  <div class="col-md-8">
                    <input type="text" name="w3" id="w3" class="form-control text-right" value="<?php echo htmlspecialchars($v('w3', 0)); ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">W4 (Rp)</label>
                  <div class="col-md-8">
                    <input type="text" name="w4" id="w4" class="form-control text-right" value="<?php echo htmlspecialchars($v('w4', 0)); ?>">
                  </div>
                </div>
                <div class="form-group last">
                  <label class="col-md-4 control-label">Prospek</label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <span class="input-group-addon">Rp</span>
                      <input type="text" id="prospek_total" class="form-control text-right" value="0.00" readonly>
                    </div>
                    <span class="help-block">Jumlah nilai W1&ndash;W4.</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <div class="row">
              <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn green"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/load?p=' . urlencode($v('periode_id'))); ?>"><i class="fa fa-times"></i> Batal</a>
              </div>
            </div>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
