<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption"><i class="fa fa-calendar font-green-haze"></i> <span class="caption-subject bold uppercase">Casual Leasing - <?php echo $is_edit ? 'Edit' : 'Tambah'; ?> Periode</span><span class="caption-helper">Bucket <b>pelaporan bulanan</b> untuk angka W1-W4, bukan jangka waktu kontrak.</span></div>
        <div class="actions">
          <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/master_periode'); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
      </div>
      <div class="portlet-body form">
        <?php if (!empty($msg)) { ?>
          <div class="alert alert-success"><i class="fa fa-check"></i> <?php echo htmlspecialchars($msg); ?></div>
        <?php } ?>
        <?php if (!empty($err)) { ?>
          <div class="alert alert-danger"><i class="fa fa-warning"></i> <?php echo htmlspecialchars($err); ?></div>
        <?php } ?>

        <?php echo form_open(site_url('casualleasing/casualleasing/master_periode_save'), array('id' => 'frmPeriode', 'class' => 'form-horizontal')); ?>
          <div class="form-body">
            <input type="hidden" name="is_new" value="<?php echo $is_edit ? '0' : '1'; ?>">
            <input type="hidden" name="periode_id_old" value="<?php echo $is_edit ? htmlspecialchars($row['periode_id']) : ''; ?>">

            <div class="form-group">
              <label class="control-label col-md-3">Kode <span class="required">*</span></label>
              <div class="col-md-4">
                <?php if ($is_edit) { ?>
                  <p class="form-control-static"><code><?php echo htmlspecialchars($row['periode_id']); ?></code></p>
                  <input type="hidden" name="periode_id" value="<?php echo htmlspecialchars($row['periode_id']); ?>">
                <?php } else { ?>
                  <input type="text" name="periode_id" class="form-control" maxlength="7" placeholder="YYYY-MM, mis. 2026-11" value="<?php echo htmlspecialchars((string)(isset($row['periode_id']) ? $row['periode_id'] : '')); ?>">
                  <span class="help-block">Tanggal mulai &amp; selesai diisi otomatis sesuai bulan.</span>
                <?php } ?>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">Nama</label>
              <div class="col-md-6">
                <input type="text" name="periode_name" class="form-control" maxlength="30" placeholder="<?php echo $is_edit ? '' : 'Kosongkan = otomatis (NOVEMBER 2026)'; ?>" value="<?php echo htmlspecialchars((string)(isset($row['periode_name']) ? $row['periode_name'] : '')); ?>">
              </div>
            </div>

            <div class="form-group last">
              <label class="control-label col-md-3">Status</label>
              <div class="col-md-5">
                <input type="hidden" name="periode_isactive" value="0">
                <label class="checkbox-inline"><input type="checkbox" name="periode_isactive" value="1" <?php echo (!isset($row['periode_isactive']) || !empty($row['periode_isactive']) ? 'checked' : ''); ?>> Aktif</label>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <div class="row">
              <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/master_periode'); ?>">Batal</a>
              </div>
            </div>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
