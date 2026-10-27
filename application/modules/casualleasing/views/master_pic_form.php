<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption"><i class="fa fa-users font-green-haze"></i> <span class="caption-subject bold uppercase">Casual Leasing - <?php echo $is_edit ? 'Edit' : 'Tambah'; ?> PIC</span><span class="caption-helper">Penanggung jawab data casual leasing.</span></div>
        <div class="actions">
          <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/master_pic'); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
      </div>
      <div class="portlet-body form">
        <?php if (!empty($msg)) { ?>
          <div class="alert alert-success"><i class="fa fa-check"></i> <?php echo htmlspecialchars($msg); ?></div>
        <?php } ?>
        <?php if (!empty($err)) { ?>
          <div class="alert alert-danger"><i class="fa fa-warning"></i> <?php echo htmlspecialchars($err); ?></div>
        <?php } ?>

        <?php echo form_open(site_url('casualleasing/casualleasing/master_pic_save'), array('id' => 'frmPic', 'class' => 'form-horizontal')); ?>
          <div class="form-body">
            <input type="hidden" name="is_new" value="<?php echo $is_edit ? '0' : '1'; ?>">
            <input type="hidden" name="pic_id_old" value="<?php echo $is_edit ? htmlspecialchars((string)$row['pic_id']) : ''; ?>">

            <div class="form-group">
              <label class="control-label col-md-3">Kode PIC <span class="required">*</span></label>
              <div class="col-md-4">
                <?php if ($is_edit) { ?>
                  <p class="form-control-static"><code><?php echo htmlspecialchars((string)$row['pic_id']); ?></code></p>
                  <input type="hidden" name="pic_id" value="<?php echo htmlspecialchars((string)$row['pic_id']); ?>">
                <?php } else { ?>
                  <input type="text" name="pic_id" class="form-control" maxlength="10" placeholder="mis. AB" value="<?php echo htmlspecialchars((string)(isset($row['pic_id']) ? $row['pic_id'] : '')); ?>">
                  <span class="help-block">Kode unik PIC, maksimal 10 karakter.</span>
                <?php } ?>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">Nama <span class="required">*</span></label>
              <div class="col-md-6">
                <input type="text" name="pic_name" class="form-control" maxlength="50" value="<?php echo htmlspecialchars((string)(isset($row['pic_name']) ? $row['pic_name'] : '')); ?>">
              </div>
            </div>

            <div class="form-group last">
              <label class="control-label col-md-3">Status</label>
              <div class="col-md-5">
                <input type="hidden" name="pic_isactive" value="0">
                <label class="checkbox-inline"><input type="checkbox" name="pic_isactive" value="1" <?php echo (!isset($row['pic_isactive']) || !empty($row['pic_isactive']) ? 'checked' : ''); ?>> Aktif</label>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <div class="row">
              <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/master_pic'); ?>">Batal</a>
              </div>
            </div>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
