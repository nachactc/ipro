<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption"><i class="fa fa-map-marker font-green-haze"></i> <span class="caption-subject bold uppercase">Casual Leasing - <?php echo $is_edit ? 'Edit' : 'Tambah'; ?> Lokasi</span><span class="caption-helper">Zona atau lokasi di dalam mall.</span></div>
        <div class="actions">
          <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/master_lokasi'); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
      </div>
      <div class="portlet-body form">
        <?php if (!empty($msg)) { ?>
          <div class="alert alert-success"><i class="fa fa-check"></i> <?php echo htmlspecialchars($msg); ?></div>
        <?php } ?>
        <?php if (!empty($err)) { ?>
          <div class="alert alert-danger"><i class="fa fa-warning"></i> <?php echo htmlspecialchars($err); ?></div>
        <?php } ?>

        <?php echo form_open(site_url('casualleasing/casualleasing/master_lokasi_save'), array('id' => 'frmLokasi', 'class' => 'form-horizontal')); ?>
          <div class="form-body">
            <input type="hidden" name="lokasi_id" value="<?php echo $is_edit ? (int)$row['lokasi_id'] : 0; ?>">

            <div class="form-group">
              <label class="control-label col-md-3">Tipe <span class="required">*</span></label>
              <div class="col-md-5">
                <select name="tipe_id" class="form-control">
                  <option value="">-- pilih tipe --</option>
                  <?php foreach ($tipes as $t) { ?>
                    <option value="<?php echo htmlspecialchars($t['tipe_id']); ?>" <?php echo (isset($row['tipe_id']) && $row['tipe_id'] === $t['tipe_id'] ? 'selected' : ''); ?>><?php echo htmlspecialchars($t['tipe_id'] . ' - ' . $t['tipe_name']); ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">Lantai/Area</label>
              <div class="col-md-4">
                <select name="lantai_id" class="form-control">
                  <option value="">-- tidak dipetakan --</option>
                  <?php foreach ((array)$lantais as $lt) { ?>
                    <option value="<?php echo (int)$lt['lantai_id']; ?>" <?php echo (isset($row['lantai_id']) && (int)$row['lantai_id'] === (int)$lt['lantai_id'] ? 'selected' : ''); ?>><?php echo htmlspecialchars($lt['lantai_code'] . ' - ' . $lt['lantai_name']); ?></option>
                  <?php } ?>
                </select>
                <span class="help-block">Opsional; dipakai untuk ringkasan denah per lantai (Master Lantai).</span>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">Nama <span class="required">*</span></label>
              <div class="col-md-6">
                <input type="hidden" name="lokasi_code" value="<?php echo htmlspecialchars((string)(isset($row['lokasi_code']) ? $row['lokasi_code'] : '')); ?>">
                <input type="text" name="lokasi_name" class="form-control" maxlength="50" value="<?php echo htmlspecialchars((string)(isset($row['lokasi_name']) ? $row['lokasi_name'] : '')); ?>">
                <span class="help-block">Kode lokasi otomatis mengikuti nama (huruf besar).</span>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">Kapasitas NLA (m&sup2;)</label>
              <div class="col-md-4">
                <div class="input-group">
                  <input type="text" name="lokasi_nla" class="form-control text-right" value="<?php echo htmlspecialchars(number_format((float)(isset($row['lokasi_nla']) ? $row['lokasi_nla'] : 0), 2, '.', ',')); ?>" placeholder="0.00">
                  <span class="input-group-addon">m&sup2;</span>
                </div>
                <span class="help-block">Khusus lokasi berkapasitas (mis. Atrium). Selisih kapasitas ditampilkan sebagai <b>belum dibuat unit</b>, bukan VACANT. Isi 0 bila tidak dipakai.</span>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3">Urut</label>
              <div class="col-md-2">
                <input type="text" name="lokasi_order" class="form-control" value="<?php echo (int)(isset($row['lokasi_order']) ? $row['lokasi_order'] : 0); ?>">
                <span class="help-block">Urutan tampil.</span>
              </div>
            </div>

            <div class="form-group last">
              <label class="control-label col-md-3">Status</label>
              <div class="col-md-5">
                <input type="hidden" name="lokasi_isactive" value="0">
                <label class="checkbox-inline"><input type="checkbox" name="lokasi_isactive" value="1" <?php echo (!isset($row['lokasi_isactive']) || !empty($row['lokasi_isactive']) ? 'checked' : ''); ?>> Aktif</label>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <div class="row">
              <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/master_lokasi'); ?>">Batal</a>
              </div>
            </div>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
