<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption"><i class="fa fa-building font-green-haze"></i> <span class="caption-subject bold uppercase">Casual Leasing - <?php echo $is_edit ? 'Edit' : 'Tambah'; ?> Lantai/Area</span><span class="caption-helper">Referensi posisi fisik untuk denah statis.</span></div>
        <div class="actions">
          <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/master_lantai'); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
      </div>
      <div class="portlet-body form">
        <?php if (!empty($msg)) { ?>
          <div class="alert alert-success"><i class="fa fa-check"></i> <?php echo htmlspecialchars($msg); ?></div>
        <?php } ?>
        <?php if (!empty($err)) { ?>
          <div class="alert alert-danger"><i class="fa fa-warning"></i> <?php echo htmlspecialchars($err); ?></div>
        <?php } ?>

        <?php echo form_open_multipart(site_url('casualleasing/casualleasing/master_lantai_save'), array('id' => 'frmLantai', 'class' => 'form-horizontal')); ?>
          <div class="form-body">
            <input type="hidden" name="lantai_id" value="<?php echo $is_edit ? (int)$row['lantai_id'] : 0; ?>">

            <div class="form-group">
              <label class="control-label col-md-3">Kode <span class="required">*</span></label>
              <div class="col-md-4">
                <input type="text" name="lantai_code" class="form-control" maxlength="10" placeholder="mis. LG, GF, F1, OTHER" value="<?php echo htmlspecialchars((string)(isset($row['lantai_code']) ? $row['lantai_code'] : '')); ?>">
                <span class="help-block">Kode unik, huruf/angka. Kode <code>OTHER</code> wajib berjenis AREA.</span>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">Nama <span class="required">*</span></label>
              <div class="col-md-6">
                <input type="text" name="lantai_name" class="form-control" maxlength="100" placeholder="mis. Lower Ground" value="<?php echo htmlspecialchars((string)(isset($row['lantai_name']) ? $row['lantai_name'] : '')); ?>">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">Jenis <span class="required">*</span></label>
              <div class="col-md-4">
                <select name="lantai_jenis" class="form-control">
                  <option value="LANTAI" <?php echo ((isset($row['lantai_jenis']) ? $row['lantai_jenis'] : 'LANTAI') === 'LANTAI' ? 'selected' : ''); ?>>LANTAI</option>
                  <option value="AREA" <?php echo ((isset($row['lantai_jenis']) ? $row['lantai_jenis'] : '') === 'AREA' ? 'selected' : ''); ?>>AREA (bukan lantai: PARKIRAN, GUDANG, dll)</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">Urut</label>
              <div class="col-md-2">
                <input type="text" name="lantai_order" class="form-control" value="<?php echo (int)(isset($row['lantai_order']) ? $row['lantai_order'] : 0); ?>">
                <span class="help-block">Urutan tampil.</span>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">Denah (PNG/JPG)</label>
              <div class="col-md-5">
                <input type="file" name="map_file" class="form-control" accept="image/png,image/jpeg">
                <?php $mf = $is_edit && isset($row['map_file']) ? trim((string)$row['map_file']) : ''; ?>
                <?php if ($mf !== '') { ?>
                  <span class="help-block">Denah saat ini: <code><?php echo htmlspecialchars($mf); ?></code>. Biarkan kosong untuk mempertahankan denah lama.</span>
                <?php } else { ?>
                  <span class="help-block">Opsional. Denah statis ditampilkan sebagai gambaran prospek/occupied/vacant.</span>
                <?php } ?>
              </div>
            </div>

            <div class="form-group last">
              <label class="control-label col-md-3">Status</label>
              <div class="col-md-5">
                <input type="hidden" name="lantai_isactive" value="0">
                <label class="checkbox-inline"><input type="checkbox" name="lantai_isactive" value="1" <?php echo (!isset($row['lantai_isactive']) || !empty($row['lantai_isactive']) ? 'checked' : ''); ?>> Aktif</label>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <div class="row">
              <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/master_lantai'); ?>">Batal</a>
              </div>
            </div>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
