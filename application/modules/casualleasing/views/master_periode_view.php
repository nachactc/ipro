<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $fmt = function($d) { return $d ? date('d-m-Y', strtotime($d)) : '-'; }; ?>

<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page cl-master-view">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-calendar font-green-haze"></i>
          <span class="caption-subject bold uppercase">Casual Leasing - Detail Periode</span>
          <span class="caption-helper">Informasi periode pelaporan bulanan.</span>
        </div>
        <div class="actions">
          <a class="btn blue" href="<?php echo site_url('casualleasing/casualleasing/master_periode_form/' . rawurlencode($row['periode_id'])); ?>"><i class="fa fa-pencil"></i> Edit</a>
          <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/master_periode'); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
      </div>
      <div class="portlet-body">
        <table class="table table-striped table-bordered cl-master-detail-table">
          <tbody>
            <tr><th style="width:240px;">Kode</th><td><code><?php echo htmlspecialchars($row['periode_id']); ?></code></td></tr>
            <tr><th>Nama</th><td><?php echo htmlspecialchars($row['periode_name']); ?></td></tr>
            <tr><th>Awal Bulan</th><td><?php echo $fmt($row['periode_start']); ?></td></tr>
            <tr><th>Akhir Bulan</th><td><?php echo $fmt($row['periode_end']); ?></td></tr>
            <tr><th>Status</th><td><?php echo ((int)$row['periode_isactive'] === 1 ? '<span class="label label-sm label-success">Aktif</span>' : '<span class="label label-sm label-default">Nonaktif</span>'); ?></td></tr>
            <tr><th>Baris budget</th><td><?php echo (int)$used; ?> baris</td></tr>
            <tr><th>Catatan</th><td><span class="text-muted">Periode ini hanya bucket pelaporan uang (W1-W4). Tanggal <b>kontrak</b> tiap tenant diatur di baris CL Budget (kolom periode mulai/akhir).</span></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
