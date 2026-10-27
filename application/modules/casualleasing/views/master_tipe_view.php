<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page cl-master-view">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-list font-green-haze"></i>
          <span class="caption-subject bold uppercase">Casual Leasing - Detail Tipe</span>
          <span class="caption-helper">Informasi kategori tipe lokasi.</span>
        </div>
        <div class="actions">
          <a class="btn blue" href="<?php echo site_url('casualleasing/casualleasing/master_tipe_form/' . rawurlencode($row['tipe_id'])); ?>"><i class="fa fa-pencil"></i> Edit</a>
          <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/master_tipe'); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
      </div>
      <div class="portlet-body">
        <table class="table table-striped table-bordered cl-master-detail-table">
          <tbody>
            <tr><th style="width:240px;">Kode</th><td><code><?php echo htmlspecialchars($row['tipe_id']); ?></code></td></tr>
            <tr><th>Nama</th><td><?php echo htmlspecialchars($row['tipe_name']); ?></td></tr>
            <tr><th>Urut</th><td><?php echo (int)$row['tipe_order']; ?></td></tr>
            <tr><th>Status</th><td><?php echo ((int)$row['tipe_isactive'] === 1 ? '<span class="label label-sm label-success">Aktif</span>' : '<span class="label label-sm label-default">Nonaktif</span>'); ?></td></tr>
            <tr><th>Jumlah lokasi</th><td><?php echo (int)$lokasi; ?> lokasi</td></tr>
            <tr><th>Dipakai unit</th><td><?php echo (int)$used; ?> baris unit</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
