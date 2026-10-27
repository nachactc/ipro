<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption"><i class="fa fa-list font-green-haze"></i> <span class="caption-subject bold uppercase">Casual Leasing - <?php echo $is_edit ? 'Edit' : 'Tambah'; ?> Tipe</span><span class="caption-helper">Kategori tipe lokasi casual leasing.</span></div>
        <div class="actions">
          <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/master_tipe'); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
      </div>
      <div class="portlet-body form">
        <?php if (!empty($msg)) { ?>
          <div class="alert alert-success"><i class="fa fa-check"></i> <?php echo htmlspecialchars($msg); ?></div>
        <?php } ?>
        <?php if (!empty($err)) { ?>
          <div class="alert alert-danger"><i class="fa fa-warning"></i> <?php echo htmlspecialchars($err); ?></div>
        <?php } ?>

        <?php echo form_open(site_url('casualleasing/casualleasing/master_tipe_save'), array('id' => 'frmTipe', 'class' => 'form-horizontal')); ?>
          <div class="form-body">
            <input type="hidden" name="is_new" value="<?php echo $is_edit ? '0' : '1'; ?>">
            <input type="hidden" name="tipe_id_old" value="<?php echo $is_edit ? htmlspecialchars($row['tipe_id']) : ''; ?>">

            <div class="form-group">
              <label class="control-label col-md-3">Kode <span class="required">*</span></label>
              <div class="col-md-4">
                <?php if ($is_edit) { ?>
                  <p class="form-control-static"><code><?php echo htmlspecialchars($row['tipe_id']); ?></code></p>
                  <input type="hidden" name="tipe_id" value="<?php echo htmlspecialchars($row['tipe_id']); ?>">
                <?php } else { ?>
                  <input type="text" name="tipe_id" class="form-control" maxlength="20" placeholder="mis. EVENT" value="<?php echo htmlspecialchars((string)(isset($row['tipe_id']) ? $row['tipe_id'] : '')); ?>">
                  <span class="help-block">Kode unik tipe, maksimal 20 karakter.</span>
                <?php } ?>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">Nama <span class="required">*</span></label>
              <div class="col-md-6">
                <input type="text" name="tipe_name" class="form-control" maxlength="50" value="<?php echo htmlspecialchars((string)(isset($row['tipe_name']) ? $row['tipe_name'] : '')); ?>">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">Urut</label>
              <div class="col-md-2">
                <input type="text" name="tipe_order" class="form-control" value="<?php echo (int)(isset($row['tipe_order']) ? $row['tipe_order'] : 0); ?>">
                <span class="help-block">Urutan tampil.</span>
              </div>
            </div>

            <div class="form-group last">
              <label class="control-label col-md-3">Status</label>
              <div class="col-md-5">
                <input type="hidden" name="tipe_isactive" value="0">
                <label class="checkbox-inline"><input type="checkbox" name="tipe_isactive" value="1" <?php echo (!isset($row['tipe_isactive']) || !empty($row['tipe_isactive']) ? 'checked' : ''); ?>> Aktif</label>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <div class="row">
              <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/master_tipe'); ?>">Batal</a>
              </div>
            </div>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
