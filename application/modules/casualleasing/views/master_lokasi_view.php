<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page cl-master-view">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-map-marker font-green-haze"></i>
          <span class="caption-subject bold uppercase">Casual Leasing - Detail Lokasi</span>
          <span class="caption-helper">Informasi zona dan penggunaan lokasi.</span>
        </div>
        <div class="actions">
          <a class="btn blue" href="<?php echo site_url('casualleasing/casualleasing/master_lokasi_form/' . (int)$row['lokasi_id']); ?>"><i class="fa fa-pencil"></i> Edit</a>
          <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/master_lokasi'); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
      </div>
      <div class="portlet-body">
        <table class="table table-striped table-bordered cl-master-detail-table">
          <tbody>
            <tr><th style="width:240px;">ID Lokasi</th><td><?php echo (int)$row['lokasi_id']; ?></td></tr>
            <tr><th>Tipe</th><td><?php echo htmlspecialchars($row['tipe_name']); ?> <span class="text-muted">(<?php echo htmlspecialchars($row['tipe_id']); ?>)</span></td></tr>
            <tr><th>Kode</th><td><?php echo htmlspecialchars($row['lokasi_code']); ?></td></tr>
            <tr><th>Nama</th><td><?php echo htmlspecialchars($row['lokasi_name']); ?></td></tr>
            <tr><th>Kapasitas NLA</th><td><?php echo number_format((float)(isset($row['lokasi_nla']) ? $row['lokasi_nla'] : 0), 2, '.', ','); ?> m&sup2;</td></tr>
            <tr><th>Lantai/Area</th><td><?php $lcode = isset($row['lantai_code']) ? trim((string)$row['lantai_code']) : ''; echo ($lcode !== ''
                ? '<code>' . htmlspecialchars($lcode) . '</code>' . (isset($row['lantai_name_master']) && $row['lantai_name_master'] !== '' ? ' ' . htmlspecialchars($row['lantai_name_master']) : '')
                : '<span class="text-muted">Tidak dipetakan</span>'); ?></td></tr>
            <tr><th>Urut</th><td><?php echo (int)$row['lokasi_order']; ?></td></tr>
            <tr><th>Status</th><td><?php echo ((int)$row['lokasi_isactive'] === 1 ? '<span class="label label-sm label-success">Aktif</span>' : '<span class="label label-sm label-default">Nonaktif</span>'); ?></td></tr>
            <tr><th>Dipakai unit</th><td><?php echo (int)$used; ?> baris unit</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
