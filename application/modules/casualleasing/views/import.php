<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
$(document).ready(function(){
    var replaceConfirmed = false;

    function showImportError(msg) {
        $('#importAlert').text(msg).show();
    }

    $('#frmImport').on('submit', function(){
        $('#importAlert').hide();
        var f = $('#file_excel')[0];
        if (!f.files || !f.files.length) { showImportError('Pilih file Excel (.xlsx) terlebih dahulu.'); return false; }
        var name = f.files[0].name || '';
        if (!/\.xlsx$/i.test(name)) { showImportError('File harus berformat .xlsx.'); return false; }
        if ($('input[name=mode]:checked').val() === 'replace' && !replaceConfirmed) {
            $('#modalReplace').modal('show');
            return false;
        }
        return true;
    });

    $('#btnReplaceConfirm').on('click', function(){
        replaceConfirmed = true;
        $('#modalReplace').modal('hide');
        $('#frmImport')[0].submit();
    });
});
</script>

<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption"><i class="icon-cloud-upload font-green-haze"></i> <span class="caption-subject bold uppercase">Casual Leasing - Import Budget</span><span class="caption-helper">Unggah budget / prospek; unit yang belum ada dibuat otomatis di master unit.</span></div>
        <div class="actions">
          <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/load'); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
          <a class="btn blue" href="<?php echo site_url('casualleasing/casualleasing/download_template'); ?>"><i class="fa fa-download"></i> Unduh Template</a>
        </div>
      </div>
      <div class="portlet-body form">
        <div id="importAlert" class="alert alert-danger" style="display:none;"></div>

        <?php if (!empty($result)) { ?>
          <?php if (!empty($result['error'])) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <?php echo htmlspecialchars($result['error']); ?></div>
          <?php } else { ?>
            <div class="alert alert-success">
              <b>Import selesai.</b>
              File: <code><?php echo htmlspecialchars(isset($result['file']) ? $result['file'] : '-'); ?></code>,
              periode <b><?php echo htmlspecialchars(isset($result['periode']) ? $result['periode'] : '-'); ?></b>,
              mode <b><?php echo (isset($result['mode']) && $result['mode'] === 'replace' ? 'GANTI' : 'TAMBAH'); ?></b>.<br>
              Baris terbaca: <b><?php echo (int)(isset($result['rows_read']) ? $result['rows_read'] : 0); ?></b> &middot;
              Disimpan: <b><?php echo (int)$result['inserted']; ?></b> &middot;
              Dilewati (duplikat): <b><?php echo (int)$result['skipped']; ?></b> &middot;
              Error: <b><?php echo count($result['errors']); ?></b>
              <div style="margin-top:8px;">
                <a class="btn btn-xs green" href="<?php echo site_url('casualleasing/casualleasing/load?p=' . urlencode(isset($result['periode']) ? $result['periode'] : '')); ?>">Lihat Data</a>
                <a class="btn btn-xs blue" href="<?php echo site_url('casualleasing/casualleasing/budget?p=' . urlencode(isset($result['periode']) ? $result['periode'] : '')); ?>">Lihat Budget</a>
              </div>
            </div>
            <?php if (!empty($result['errors'])) { ?>
              <div class="alert alert-warning">
                <b>Baris yang tidak bisa diproses:</b>
                <ul style="margin:6px 0 0 18px;">
                  <?php foreach (array_slice($result['errors'], 0, 30) as $err) { ?>
                    <li><?php echo htmlspecialchars($err); ?></li>
                  <?php } ?>
                </ul>
                <?php if (count($result['errors']) > 30) { ?>
                  <div class="text-muted" style="margin-top:4px;">... dan <?php echo count($result['errors']) - 30; ?> lainnya.</div>
                <?php } ?>
              </div>
            <?php } ?>
          <?php } ?>
        <?php } ?>

        <?php echo form_open_multipart(site_url('casualleasing/casualleasing/do_import'), array('id' => 'frmImport', 'class' => 'form-horizontal')); ?>
          <div class="form-body">
            <div class="form-group">
              <label class="col-md-3 control-label">Periode Tujuan <span class="required">*</span></label>
              <div class="col-md-4">
                <select name="periode_id" class="form-control" required>
                  <?php foreach ($periodes as $k => $nm) { echo '<option value="' . htmlspecialchars($k) . '"' . ($k == $sel_periode ? ' selected' : '') . '>' . htmlspecialchars($nm) . '</option>'; } ?>
                </select>
                <span class="help-block" style="font-size:11px;">Semua baris file akan masuk ke periode ini.</span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Mode Import</label>
              <div class="col-md-6">
                <label class="radio-inline">
                  <input type="radio" name="mode" value="append" checked> Tambah (lewati duplikat)
                </label>
                <label class="radio-inline">
                  <input type="radio" name="mode" value="replace"> Ganti semua data periode
                </label>
                <span class="help-block" style="font-size:11px;">
                  Duplikat = unit master + periode yang sama. Bila No. unit di lokasi tersebut belum ada,
                  sistem membuat master unit dari kolom NO, UNIT, dan NLA.
                  Mode <b>Ganti</b> menghapus seluruh budget pada periode terpilih lebih dulu
                  (master unit tidak dihapus).
                </span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">File Excel <span class="required">*</span></label>
              <div class="col-md-6">
                <input type="file" name="file_excel" id="file_excel" class="form-control" accept=".xlsx">
                <span class="help-block" style="font-size:11px;">Format <b>.xlsx</b> dengan sheet <code>ATRIUM</code>, <code>KORIDOR</code>, <code>VACANT UNIT</code>, dan/atau <code>OTHER</code>.</span>
              </div>
            </div>
          </div>
          <div class="form-actions">
            <div class="row">
              <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green"><i class="fa fa-upload"></i> Proses Import</button>
                <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/load'); ?>">Batal</a>
              </div>
            </div>
          </div>
        <?php echo form_close(); ?>

        <hr>
        <h4><i class="fa fa-info-circle"></i> Format yang dibaca</h4>
        <ul class="text-muted" style="font-size:12px;">
          <li>Sheet: <b>ATRIUM</b>, <b>KORIDOR</b>, <b>VACANT UNIT</b>, <b>OTHER</b> (nama tidak peka huruf besar/kecil).</li>
          <li>Baris data dikenali dari kolom <b>A (NO)</b> yang berisi angka.</li>
          <li>Kolom: NO, LOKASI, UNIT, PIC, NLA, STATUS, PERIODE (tipe &amp; teks), TENANT, BUDGET, OCCUPIED, PROSPEK, W1&ndash;W4.</li>
          <li><b>NO + LOKASI</b> menjadi identitas unit. Bila belum ada, unit master dibuat otomatis dengan NLA dari file; NLA unit yang sudah ada tidak ditimpa.</li>
          <li>W1&ndash;W4 dibaca sebagai nilai prospek per minggu; total prospek = W1 + W2 + W3 + W4. Kolom PROSPEK hanya dipakai sebagai cadangan bila seluruh W kosong.</li>
          <li>Budget diambil langsung dari kolom BUDGET; ARR dihitung otomatis dari budget &divide; NLA.</li>
          <li>Tanggal periode di-parse dari teks; teks tanpa tahun memakai tahun periode tujuan.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalReplace" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-warning"></i> Konfirmasi Mode Ganti</h4>
      </div>
      <div class="modal-body">
        Mode <b>GANTI</b> akan menghapus <b>semua data unit</b> pada periode terpilih, lalu mengisinya dari file.
        Tindakan ini tidak bisa dibatalkan. Lanjutkan?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Batal</button>
        <button type="button" class="btn red" id="btnReplaceConfirm"><i class="fa fa-check"></i> Ya, Ganti Data</button>
      </div>
    </div>
  </div>
</div>
