<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$v = function($k, $default = '') use ($row) { return isset($row[$k]) && $row[$k] !== null ? $row[$k] : $default; };
$num = function($x) { return number_format((float)$x, 2, '.', ','); };
$cap = (float)$v('lokasi_nla', 0);
$sisa = $cap > 0 ? max(0, $cap - (float)$used) : 0;
$over = $cap > 0 ? max(0, (float)$used - $cap) : 0;
?>
<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page cl-master-view">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-cube font-green-haze"></i>
          <span class="caption-subject bold uppercase">CL UNIT - DETAIL UNIT</span>
          <span class="caption-helper">Master unit fisik dan NLA. Budget tidak diinput di sini.</span>
        </div>
        <div class="actions">
          <a class="btn blue" href="<?php echo site_url('casualleasing/casualleasing/unit_master_form/' . (int)$v('unit_master_id')); ?>"><i class="fa fa-pencil"></i> Edit</a>
          <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/unit_master'); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
      </div>
      <div class="portlet-body">
        <h4 class="form-section"><i class="fa fa-building-o"></i> Identitas Unit</h4>
        <table class="table table-striped table-bordered cl-master-detail-table">
          <tbody>
            <tr><th style="width:240px;">Tipe</th><td><?php echo htmlspecialchars((string)($v('tipe_name') ?: $v('tipe_id'))); ?></td></tr>
            <tr><th>Lokasi</th><td><?php echo htmlspecialchars(trim((string)$v('lokasi_code') . ' - ' . (string)$v('lokasi_name'), ' -')); ?></td></tr>
            <tr><th>No. Unit</th><td><?php echo (int)$v('unit_no'); ?></td></tr>
            <tr><th>Nama Unit</th><td><?php echo htmlspecialchars((string)$v('unit_name')); ?></td></tr>
            <tr><th>NLA</th><td><?php echo $num($v('nla', 0)); ?> m&sup2;</td></tr>
            <tr><th>Status</th><td><?php echo ((int)$v('unit_isactive', 1) === 1 ? '<span class="label label-sm label-success">Aktif</span>' : '<span class="label label-sm label-default">Nonaktif</span>'); ?></td></tr>
            <tr><th>Dipakai di Budget</th><td><?php echo count($budgets); ?> baris</td></tr>
          </tbody>
        </table>

        <?php if ($cap > 0) { ?>
        <h4 class="form-section"><i class="fa fa-th-large"></i> Kapasitas Lokasi</h4>
        <table class="table table-striped table-bordered cl-master-detail-table">
          <tbody>
            <tr><th style="width:240px;">Kapasitas NLA</th><td><?php echo $num($cap); ?> m&sup2;</td></tr>
            <tr><th>Total NLA unit aktif</th><td><?php echo $num($used); ?> m&sup2;</td></tr>
            <tr><th>Sisa kapasitas</th><td><?php echo $num($sisa); ?> m&sup2;<?php echo $over > 0 ? ' <span class="text-danger">(OVER ' . $num($over) . ' m&sup2;)</span>' : ''; ?></td></tr>
          </tbody>
        </table>
        <?php } ?>

        <h4 class="form-section"><i class="fa fa-list"></i> Budget yang Menggunakan Unit Ini</h4>
        <div class="table-responsive">
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th style="width:120px;">Periode</th>
                <th style="width:110px;">Status</th>
                <th>Tenant</th>
                <th class="text-right">Budget</th>
                <th class="text-right">Occupied</th>
                <th class="text-right">Prospek</th>
                <th class="text-center" style="width:80px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($budgets)) { ?>
                <tr><td colspan="7" class="text-center text-muted">Belum dipakai di budget mana pun.</td></tr>
              <?php } ?>
              <?php foreach ($budgets as $b) { ?>
                <tr>
                  <td><?php echo htmlspecialchars($b['periode_id']); ?></td>
                  <td><span class="label label-sm label-<?php echo $b['unit_status'] === 'OCCUPIED' ? 'success' : ($b['unit_status'] === 'RENEWAL' ? 'warning' : 'default'); ?>"><?php echo htmlspecialchars($b['unit_status']); ?></span></td>
                  <td><?php echo htmlspecialchars((string)$b['tenant']); ?></td>
                  <td class="text-right"><?php echo $num($b['budget']); ?></td>
                  <td class="text-right"><?php echo $num($b['occupied']); ?></td>
                  <td class="text-right"><?php echo $num($b['prospek']); ?></td>
                  <td class="text-center"><a class="btn btn-xs default" href="<?php echo site_url('casualleasing/casualleasing/view/' . (int)$b['unit_id']); ?>" title="Lihat Budget"><i class="fa fa-eye"></i></a></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
