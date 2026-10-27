<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$rows  = $summary['rows'];
$grand = $summary['grand'];
$pname = isset($periodeRow['periode_name']) && $periodeRow['periode_name'] ? $periodeRow['periode_name'] : $periode;

function cl_num($v) { return number_format((float)$v, 2, '.', ','); }
function cl_pct($a, $b) { return $b > 0 ? number_format($a / $b * 100, 1, '.', ',') . '%' : '-'; }
function cl_bucket_cells($m2, $rp, $nla_total) {
    return '<td class="num">' . cl_num($m2) . '</td>'
         . '<td class="num">' . cl_pct($m2, $nla_total) . '</td>'
         . '<td class="num">' . cl_num($rp) . '</td>';
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Progress Casual Leasing - <?php echo htmlspecialchars($pname); ?></title>
<style>
  @page { size: A4 landscape; margin: 10mm; }
  body { font-family: Arial, Helvetica, sans-serif; font-size: 8pt; color: #222; }
  h2 { margin: 0 0 2px 0; font-size: 14pt; }
  .sub { color: #555; margin-bottom: 10px; }
  table { border-collapse: collapse; width: 100%; }
  th, td { border: 1px solid #999; padding: 3px 4px; vertical-align: middle; }
  thead th { background: #4b77a0; color: #fff; text-align: center; }
  thead tr.sub th { background: #6b93b8; font-weight: normal; }
  tfoot th, tfoot td { background: #eef3f7; font-weight: bold; }
  td.lbl { font-weight: bold; background: #fafcfe; white-space: nowrap; }
  td.lbl .cl-sum-label-sub { display: block; margin-top: 2px; font-size: 6.5pt; font-weight: normal; color: #555; }
  td.num, th.num { text-align: right; white-space: nowrap; }
  .foot { margin-top: 8px; font-size: 7.5pt; color: #666; }
  .noprint { margin-bottom: 10px; }
  @media print { .noprint { display: none; } }
</style>
</head>
<body>

<div class="noprint">
  <button onclick="window.print()">Cetak / Simpan PDF</button>
  <button onclick="window.close()">Tutup</button>
</div>

<h2>CL BUDGET</h2>
<div class="sub"><?php echo htmlspecialchars($pname); ?> &middot; dicetak <?php echo date('d-m-Y H:i'); ?></div>

<table>
  <thead>
    <tr>
      <th rowspan="2">LOKASI</th>
      <th colspan="3">BUDGET</th>
      <th colspan="3">OCCUPIED</th>
      <th colspan="3">RENEWAL</th>
      <th colspan="3">VACANT</th>
      <th colspan="3">TOTAL</th>
      <th colspan="5">TARGET DEAL RENEWAL/PROSPECT</th>
    </tr>
    <tr class="sub">
      <th>NLA (m&sup2;)</th><th>%</th><th>Rp.</th>
      <th>M2</th><th>%</th><th>Rp.</th>
      <th>M2</th><th>%</th><th>Rp.</th>
      <th>M2</th><th>%</th><th>Rp.</th>
      <th>M2</th><th>%</th><th>Rp.</th>
      <th>W1</th><th>W2</th><th>W3</th><th>W4</th><th>TOTAL</th>
    </tr>
  </thead>
  <tbody>
    <?php if (count($rows) == 0) { ?>
      <tr><td colspan="21" style="text-align:center;">Belum ada data pada periode ini.</td></tr>
    <?php } ?>
    <?php foreach ($rows as $r) {
      $cap = isset($r['cap_m2']) ? (float)$r['cap_m2'] : 0;
      $sisa = isset($r['uncreated_m2']) ? (float)$r['uncreated_m2'] : (isset($r['auto_vac_m2']) ? (float)$r['auto_vac_m2'] : 0);
      $over = isset($r['over_m2']) ? (float)$r['over_m2'] : 0;
    ?>
      <tr>
        <td class="lbl"><?php echo htmlspecialchars($r['label']); ?>
          <?php if ($cap > 0) { ?>
            <span class="cl-sum-label-sub">Kapasitas <?php echo cl_num($cap); ?> m&sup2; &middot; belum dibuat unit <?php echo cl_num($sisa); ?> m&sup2;<?php echo $over > 0 ? ' &middot; OVER ' . cl_num($over) . ' m&sup2;' : ''; ?></span>
          <?php } ?>
        </td>
        <?php
          echo cl_bucket_cells($r['nla'],    $r['budget'], $r['nla']);
          echo cl_bucket_cells($r['occ_m2'], $r['occ_rp'], $r['nla']);
          echo cl_bucket_cells($r['ren_m2'], $r['ren_rp'], $r['nla']);
          echo cl_bucket_cells($r['vac_m2'], $r['vac_rp'], $r['nla']);
          echo cl_bucket_cells($r['tot_m2'], $r['tot_rp'], $r['nla']);
        ?>
        <td class="num"><?php echo cl_num($r['w1']); ?></td>
        <td class="num"><?php echo cl_num($r['w2']); ?></td>
        <td class="num"><?php echo cl_num($r['w3']); ?></td>
        <td class="num"><?php echo cl_num($r['w4']); ?></td>
        <td class="num"><?php echo cl_num($r['wtot']); ?></td>
      </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <tr>
      <th class="num">TOTAL</th>
      <?php
        echo cl_bucket_cells($grand['nla'],    $grand['budget'], $grand['nla']);
        echo cl_bucket_cells($grand['occ_m2'], $grand['occ_rp'], $grand['nla']);
        echo cl_bucket_cells($grand['ren_m2'], $grand['ren_rp'], $grand['nla']);
        echo cl_bucket_cells($grand['vac_m2'], $grand['vac_rp'], $grand['nla']);
        echo cl_bucket_cells($grand['tot_m2'], $grand['tot_rp'], $grand['nla']);
      ?>
      <th class="num"><?php echo cl_num($grand['w1']); ?></th>
      <th class="num"><?php echo cl_num($grand['w2']); ?></th>
      <th class="num"><?php echo cl_num($grand['w3']); ?></th>
      <th class="num"><?php echo cl_num($grand['w4']); ?></th>
      <th class="num"><?php echo cl_num($grand['wtot']); ?></th>
    </tr>
  </tfoot>
</table>

<div class="foot">
  Nilai Rp pada OCCUPIED/RENEWAL/VACANT dihitung dari (Occupied + Prospek) sesuai status budget.
  Kolom TARGET = jumlah nilai Prospek pada W1&ndash;W4.
  VACANT = unit master yang belum dibuatkan budget pada periode ini, ditambah budget berstatus VACANT.
  Selisih kapasitas yang belum memiliki unit ditampilkan terpisah sebagai &ldquo;belum dibuat unit&rdquo;.
</div>

<script>window.onload = function(){ window.print(); };</script>
</body>
</html>
