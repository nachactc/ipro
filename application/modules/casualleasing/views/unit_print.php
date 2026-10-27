<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$pname = isset($periodeRow['periode_name']) && $periodeRow['periode_name'] ? $periodeRow['periode_name'] : $periode;
$total = array('nla' => 0, 'budget' => 0, 'occupied' => 0,
               'w1' => 0, 'w2' => 0, 'w3' => 0, 'w4' => 0,
               'prospek' => 0, 'fcst' => 0);

function clp_num($v) { return number_format((float)$v, 2, '.', ','); }
function clp_arr($v, $nla) {
    $nla = (float)$nla;
    return $nla > 0 ? (float)$v / $nla : 0;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>CL Budget - <?php echo htmlspecialchars($pname); ?></title>
<style>
    @page { size: A4 landscape; margin: 7mm; }
    * { box-sizing: border-box; }
    body {
        margin: 0;
        padding: 9mm;
        background: #f2f5f8;
        color: #15202b;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9px;
    }
    .sheet {
        width: 100%;
        max-width: 285mm;
        margin: 0 auto;
        padding: 8mm;
        background: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,.12);
    }
    .noprint { margin: 0 auto 7mm; max-width: 285mm; }
    .noprint button {
        padding: 7px 16px;
        border: 0;
        border-radius: 3px;
        background: #2f80b9;
        color: #fff;
        font-weight: 700;
        cursor: pointer;
    }
    .noprint span { margin-left: 10px; color: #607080; font-size: 11px; }
    h1 { margin: 0 0 2mm; font-size: 15px; letter-spacing: .2px; }
    .sub { display: flex; justify-content: space-between; gap: 10mm; margin-bottom: 4mm; color: #4b5b6b; }
    .sub .right { text-align: right; white-space: nowrap; }
    .meta { font-size: 9px; line-height: 1.45; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 3px 3px; border: 1px solid #aebbc7; vertical-align: top; }
    th { background: #e9f0f5; text-align: center; font-size: 8px; line-height: 1.2; }
    td { font-size: 8px; line-height: 1.3; }
    .num { text-align: right; white-space: nowrap; }
    .ctr { text-align: center; white-space: nowrap; }
    .tenant { min-width: 28mm; }
    .period { min-width: 27mm; }
    tfoot td { background: #eef3f7; font-weight: 700; border-top: 2px solid #8096a8; }
    .empty { padding: 10mm; text-align: center; color: #758494; border: 1px solid #cbd5de; }
    @media print {
        body { padding: 0; background: #fff; font-size: 8px; }
        .sheet { max-width: none; padding: 0; box-shadow: none; }
        .noprint { display: none; }
        th, td { font-size: 5.5pt; padding: 2px 2px; }
        th { background: #e9f0f5 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        tfoot td { background: #eef3f7 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        thead { display: table-header-group; }
        tr { page-break-inside: avoid; }
    }
</style>
</head>
<body>

<div class="noprint">
    <button type="button" onclick="window.print()">Cetak / Simpan PDF</button>
    <span>Daftar budget mengikuti filter yang aktif.</span>
</div>

<div class="sheet">
    <h1>CASUAL LEASING &mdash; DAFTAR BUDGET</h1>
    <div class="sub">
        <div class="meta">
            <div><b>Periode:</b> <?php echo htmlspecialchars($pname); ?></div>
            <div><b>Filter:</b> <?php echo htmlspecialchars($filter_text); ?></div>
        </div>
        <div class="right meta">
            <div><b>Jumlah budget:</b> <?php echo count($units); ?></div>
            <div>Dicetak: <?php echo date('d-m-Y H:i'); ?></div>
        </div>
    </div>

    <?php if (count($units) === 0) { ?>
        <div class="empty">Tidak ada unit yang cocok dengan filter.</div>
    <?php } else { ?>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>TIPE</th>
                <th>LOKASI</th>
                <th>UNIT</th>
                <th>PIC</th>
                <th>NLA<br>(m&sup2;)</th>
                <th>STATUS</th>
                <th>TENANT</th>
                <th>PERIODE</th>
                <th>BUDGET</th>
                <th>OCCUPIED</th>
                <th>W1</th>
                <th>W2</th>
                <th>W3</th>
                <th>W4</th>
                <th>PROSPEK</th>
                <th>FCST<br>CLOSING</th>
                <th>ARR<br>BUDGET</th>
                <th>ARR<br>OCCUPIED</th>
                <th>ARR<br>PROSPEK</th>
                <th>ARR<br>FCST</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 0; foreach ($units as $u) {
            $no++;
            $nla  = (float)$u['nla'];
            $budget = (float)$u['budget'];
            $occ  = (float)$u['occupied'];
            $w1 = (float)$u['w1']; $w2 = (float)$u['w2'];
            $w3 = (float)$u['w3']; $w4 = (float)$u['w4'];
            $pros = $w1 + $w2 + $w3 + $w4;
            $fcst = $occ + $pros;
            $total['nla'] += $nla;
            $total['budget'] += $budget;
            $total['occupied'] += $occ;
            $total['w1'] = (isset($total['w1']) ? $total['w1'] : 0) + $w1;
            $total['w2'] = (isset($total['w2']) ? $total['w2'] : 0) + $w2;
            $total['w3'] = (isset($total['w3']) ? $total['w3'] : 0) + $w3;
            $total['w4'] = (isset($total['w4']) ? $total['w4'] : 0) + $w4;
            $total['prospek'] += $pros;
            $total['fcst'] += $fcst;
        ?>
            <tr>
                <td class="ctr"><?php echo $no; ?></td>
                <td><?php echo htmlspecialchars($u['tipe_name']); ?></td>
                <td class="ctr"><?php echo htmlspecialchars($u['lokasi_code']); ?></td>
                <td><?php echo htmlspecialchars($u['unit_name']); ?></td>
                <td class="ctr"><?php echo htmlspecialchars($u['pic_id']); ?></td>
                <td class="num"><?php echo clp_num($nla); ?></td>
                <td class="ctr"><?php echo htmlspecialchars($u['unit_status']); ?></td>
                <td class="tenant"><?php echo htmlspecialchars($u['tenant']); ?></td>
                <td class="period"><?php echo htmlspecialchars($u['periode_display']); ?></td>
                <td class="num"><?php echo clp_num($budget); ?></td>
                <td class="num"><?php echo clp_num($occ); ?></td>
                <td class="num"><?php echo clp_num($w1); ?></td>
                <td class="num"><?php echo clp_num($w2); ?></td>
                <td class="num"><?php echo clp_num($w3); ?></td>
                <td class="num"><?php echo clp_num($w4); ?></td>
                <td class="num"><?php echo clp_num($pros); ?></td>
                <td class="num"><?php echo clp_num($fcst); ?></td>
                <td class="num"><?php echo clp_num(clp_arr($budget, $nla)); ?></td>
                <td class="num"><?php echo clp_num(clp_arr($occ, $nla)); ?></td>
                <td class="num"><?php echo clp_num(clp_arr($pros, $nla)); ?></td>
                <td class="num"><?php echo clp_num(clp_arr($fcst, $nla)); ?></td>
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">TOTAL</td>
                <td class="num"><?php echo clp_num($total['nla']); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="num"><?php echo clp_num($total['budget']); ?></td>
                <td class="num"><?php echo clp_num($total['occupied']); ?></td>
                <td class="num"><?php echo clp_num($total['w1']); ?></td>
                <td class="num"><?php echo clp_num($total['w2']); ?></td>
                <td class="num"><?php echo clp_num($total['w3']); ?></td>
                <td class="num"><?php echo clp_num($total['w4']); ?></td>
                <td class="num"><?php echo clp_num($total['prospek']); ?></td>
                <td class="num"><?php echo clp_num($total['fcst']); ?></td>
                <td class="num"><?php echo clp_num(clp_arr($total['budget'], $total['nla'])); ?></td>
                <td class="num"><?php echo clp_num(clp_arr($total['occupied'], $total['nla'])); ?></td>
                <td class="num"><?php echo clp_num(clp_arr($total['prospek'], $total['nla'])); ?></td>
                <td class="num"><?php echo clp_num(clp_arr($total['fcst'], $total['nla'])); ?></td>
            </tr>
        </tfoot>
    </table>
    <?php } ?>
</div>

<?php if (!isset($_GET['noauto']) || $_GET['noauto'] !== '1') { ?>
<script>
window.addEventListener('load', function(){
    setTimeout(function(){ window.print(); }, 300);
});
</script>
<?php } ?>
</body>
</html>
