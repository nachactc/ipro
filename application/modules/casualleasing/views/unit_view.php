<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$v = function($k, $default = '') use ($row) { return isset($row[$k]) && $row[$k] !== null ? $row[$k] : $default; };
$num = function($x) { return number_format((float)$x, 2, '.', ','); };
$dt = function($d) { if (!$d) return '-'; $t = strtotime($d); return $t ? date('d-m-Y H:i', $t) : $d; };
$status = strtoupper((string)$v('unit_status', 'VACANT'));
$statusClass = $status === 'OCCUPIED' ? 'success' : ($status === 'RENEWAL' ? 'warning' : 'default');
?>
<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page cl-master-view">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-cube font-green-haze"></i>
          <span class="caption-subject bold uppercase">CL BUDGET - DETAIL BUDGET</span>
          <span class="caption-helper">Informasi unit, periode, nilai, dan ARR.</span>
        </div>
        <div class="actions">
          <a class="btn blue" href="<?php echo site_url('casualleasing/casualleasing/edit/' . (int)$v('unit_id')); ?>"><i class="fa fa-pencil"></i> Edit</a>
          <a class="btn default" target="_blank" href="<?php echo site_url('casualleasing/casualleasing/unit_label/' . (int)$v('unit_id')) . '?auto=1'; ?>"><i class="fa fa-tag"></i> Print Label</a>
          <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/load?p=' . urlencode((string)$v('periode_id'))); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
      </div>
      <div class="portlet-body">
        <h4 class="form-section"><i class="fa fa-building-o"></i> Identitas Unit</h4>
        <table class="table table-striped table-bordered cl-master-detail-table">
          <tbody>
            <tr><th style="width:240px;">Periode</th><td><?php echo htmlspecialchars((string)$v('periode_id')); ?></td></tr>
            <tr><th>Tipe</th><td><?php echo htmlspecialchars((string)($v('tipe_name') ?: $v('tipe_id'))); ?></td></tr>
            <tr><th>Lokasi</th><td><?php echo htmlspecialchars(trim((string)$v('lokasi_code') . ' - ' . (string)$v('lokasi_name'), ' -')); ?></td></tr>
            <tr><th>No. Unit</th><td><?php echo $v('unit_no') === '' ? '-' : (int)$v('unit_no'); ?></td></tr>
            <tr><th>Nama Unit</th><td><?php echo htmlspecialchars((string)$v('unit_name')); ?></td></tr>
            <tr><th>PIC</th><td><?php echo htmlspecialchars((string)($v('pic_name') ?: $v('pic_id'))); ?></td></tr>
            <tr><th>NLA</th><td><?php echo $num($v('nla', 0)); ?> m&sup2;</td></tr>
            <tr><th>Status</th><td><span class="label label-sm label-<?php echo $statusClass; ?>"><?php echo htmlspecialchars($status); ?></span></td></tr>
          </tbody>
        </table>

        <h4 class="form-section"><i class="fa fa-calendar"></i> Periode &amp; Tenant</h4>
        <table class="table table-striped table-bordered cl-master-detail-table">
          <tbody>
            <tr><th style="width:240px;">Tipe Periode</th><td><?php echo htmlspecialchars((string)$v('periode_type', '-')); ?></td></tr>
            <tr><th>Tanggal</th><td><?php echo htmlspecialchars((string)$periode_display); ?></td></tr>
            <tr><th>Tenant</th><td><?php echo htmlspecialchars((string)$v('tenant', '-')); ?></td></tr>
            <tr><th>Remarks</th><td><?php echo nl2br(htmlspecialchars((string)$v('remarks', '-'))); ?></td></tr>
          </tbody>
        </table>

        <h4 class="form-section"><i class="fa fa-money"></i> Nilai &amp; ARR</h4>
        <table class="table table-striped table-bordered cl-master-detail-table">
          <thead>
            <tr>
              <th style="width:240px;">Komponen</th>
              <th class="text-right">Nilai (Rp)</th>
              <th class="text-right">ARR (Rp/m&sup2;)</th>
            </tr>
          </thead>
          <tbody>
            <tr><th>Budget</th><td class="text-right"><?php echo $num($v('budget', 0)); ?></td><td class="text-right"><?php echo $num($arr['budget']); ?></td></tr>
            <tr><th>Occupied</th><td class="text-right"><?php echo $num($v('occupied', 0)); ?></td><td class="text-right"><?php echo $num($arr['occupied']); ?></td></tr>
            <tr><th>W1</th><td class="text-right"><?php echo $num($v('w1', 0)); ?></td><td class="text-right">-</td></tr>
            <tr><th>W2</th><td class="text-right"><?php echo $num($v('w2', 0)); ?></td><td class="text-right">-</td></tr>
            <tr><th>W3</th><td class="text-right"><?php echo $num($v('w3', 0)); ?></td><td class="text-right">-</td></tr>
            <tr><th>W4</th><td class="text-right"><?php echo $num($v('w4', 0)); ?></td><td class="text-right">-</td></tr>
            <tr><th>Total Prospek</th><td class="text-right"><?php echo $num($v('prospek', 0)); ?></td><td class="text-right"><?php echo $num($arr['prospek']); ?></td></tr>
            <tr><th>Fcst Closing</th><td class="text-right"><?php echo $num($fcst); ?></td><td class="text-right"><?php echo $num($arr['fcst']); ?></td></tr>
          </tbody>
        </table>

        <h4 class="form-section"><i class="fa fa-clock-o"></i> Audit</h4>
        <table class="table table-striped table-bordered cl-master-detail-table">
          <tbody>
            <tr><th style="width:240px;">Dibuat</th><td><?php echo htmlspecialchars($v('createby', '-')); ?> &middot; <?php echo htmlspecialchars($dt($v('createdate'))); ?></td></tr>
            <tr><th>Diubah</th><td><?php echo htmlspecialchars($v('modifyby', '-')); ?> &middot; <?php echo htmlspecialchars($dt($v('modifydate'))); ?></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
