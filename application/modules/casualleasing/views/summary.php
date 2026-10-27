<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$rows  = $summary['rows'];
$grand = $summary['grand'];
$pname = isset($periodeRow['periode_name']) && $periodeRow['periode_name'] ? $periodeRow['periode_name'] : $periode;

function cl_num($v) { return number_format((float)$v, 2, '.', ','); }
function cl_pct($a, $b) { return $b > 0 ? number_format($a / $b * 100, 1, '.', ',') . '%' : '-'; }

function cl_bucket_cells($m2, $rp, $nla_total) {
    return '<td class="text-right">' . cl_num($m2) . '</td>'
         . '<td class="text-right">' . cl_pct($m2, $nla_total) . '</td>'
         . '<td class="text-right">' . cl_num($rp) . '</td>';
}

$cb = function($arr, $sel) {
    $h = '';
    foreach ($arr as $k => $v) { $h .= '<option value="' . htmlspecialchars($k) . '"' . ($k == $sel ? ' selected' : '') . '>' . htmlspecialchars($v) . '</option>'; }
    return $h;
};
?>
<script src="<?php echo base_url(); ?>assets/plugins/exportexcel/xlsx.full.min.js"></script>
<script type="text/javascript">
var CL_SUMMARY = <?php echo json_encode(array('pname' => $pname, 'rows' => $rows, 'grand' => $grand)); ?>;

function clPctNum(a, b){ return b > 0 ? Math.round(a / b * 1000) / 10 : 0; }

function clExportExcel(){
    var d = CL_SUMMARY;
    var aoa = [];
    aoa.push(['LOKASI','BUDGET',null,null,'OCCUPIED',null,null,'RENEWAL',null,null,'VACANT',null,null,'TOTAL',null,null,'TARGET DEAL RENEWAL/PROSPECT',null,null,null,null]);
    aoa.push(['','NLA (m2)','%','Rp.','M2','%','Rp.','M2','%','Rp.','M2','%','Rp.','M2','%','Rp.','W1','W2','W3','W4','TOTAL']);

    function pushRow(label, r){
        aoa.push([label,
            +r.nla, clPctNum(r.nla, r.nla), +r.budget,
            +r.occ_m2, clPctNum(r.occ_m2, r.nla), +r.occ_rp,
            +r.ren_m2, clPctNum(r.ren_m2, r.nla), +r.ren_rp,
            +r.vac_m2, clPctNum(r.vac_m2, r.nla), +r.vac_rp,
            +r.tot_m2, clPctNum(r.tot_m2, r.nla), +r.tot_rp,
            +r.w1, +r.w2, +r.w3, +r.w4, +r.wtot]);
    }
    d.rows.forEach(function(r){ pushRow(r.label, r); });
    pushRow('TOTAL', d.grand);

    var ws = XLSX.utils.aoa_to_sheet(aoa);
    ws['!merges'] = [
        { s:{r:0,c:0},  e:{r:1,c:0} },
        { s:{r:0,c:1},  e:{r:0,c:3} },
        { s:{r:0,c:4},  e:{r:0,c:6} },
        { s:{r:0,c:7},  e:{r:0,c:9} },
        { s:{r:0,c:10}, e:{r:0,c:12} },
        { s:{r:0,c:13}, e:{r:0,c:15} },
        { s:{r:0,c:16}, e:{r:0,c:20} }
    ];
    var widths = [22,12,8,16,12,8,16,12,8,16,12,8,16,12,8,16,14,14,14,14,16];
    ws['!cols'] = widths.map(function(w){ return { wch: w }; });

    var range = XLSX.utils.decode_range(ws['!ref']);
    for (var R = 2; R <= range.e.r; R++) {
        for (var C = 1; C <= 20; C++) {
            var addr = XLSX.utils.encode_cell({ r: R, c: C });
            if (!ws[addr]) continue;
            ws[addr].z = (C === 2 || C === 5 || C === 8 || C === 11 || C === 14) ? '0.0"%"' : '#,##0.00';
        }
    }

    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'BUDGET');

    // Sheet alokasi NLA untuk lokasi yang memiliki kapasitas (Atrium).
    var alloc = [];
    d.rows.forEach(function(r){
        if ((parseFloat(r.cap_m2) || 0) > 0) {
            var sisaUnit = (r.uncreated_m2 !== undefined ? r.uncreated_m2 : r.auto_vac_m2);
            alloc.push([r.label, +r.cap_m2, +r.terpakai_m2, +sisaUnit, +r.over_m2]);
        }
    });
    if (alloc.length) {
        var aoaAlloc = [['LOKASI','KAPASITAS NLA (m2)','TERPAKAI (m2)','BELUM DIBUAT UNIT (m2)','OVER (m2)']];
        alloc.forEach(function(a){ aoaAlloc.push(a); });
        var wsAlloc = XLSX.utils.aoa_to_sheet(aoaAlloc);
        wsAlloc['!cols'] = [22,18,15,18,12].map(function(w){ return { wch:w }; });
        for (var RA = 1; RA < aoaAlloc.length; RA++) {
            for (var CA = 1; CA <= 4; CA++) {
                var addrA = XLSX.utils.encode_cell({ r: RA, c: CA });
                if (wsAlloc[addrA]) { wsAlloc[addrA].z = '#,##0.00'; }
            }
        }
        XLSX.utils.book_append_sheet(wb, wsAlloc, 'ALOKASI NLA');
    }

    var fname = 'CL_BUDGET_' + String(d.pname || 'periode').replace(/[^A-Za-z0-9]+/g, '_') + '.xlsx';
    XLSX.writeFile(wb, fname);
}

$(document).ready(function(){
    $('#btnExportExcel').on('click', clExportExcel);
});
</script>
<style>
#clSummary td, #clSummary th { font-size: 8.5pt; white-space: nowrap; border: 1px solid #dfe3e8 !important; }
#clSummary thead th { background: #4b77a0; color: #fff; text-align: center; vertical-align: middle; }
#clSummary thead tr.sub th { background: #6b93b8; font-weight: normal; }
#clSummary tfoot th { background: #eef3f7; font-weight: 700; }
#clSummary td.lbl { font-weight: 600; background: #fafcfe; }
#clSummary .cl-sum-label-sub { display: block; margin-top: 2px; font-size: 8px; font-weight: 400; color: #6b7f91; }
#clSummary tr.cl-over-cap td { background: #fff7f5; }
</style>

<div class="row">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption"><i class="icon-bar-chart"></i> <span class="caption-subject bold uppercase">RINGKASAN BUDGET</span> <small>&nbsp;<?php echo htmlspecialchars($pname); ?></small></div>
        <div class="actions">
          <form class="form-inline" method="get" action="<?php echo site_url('casualleasing/casualleasing/budget'); ?>" style="display:inline-block;margin-right:6px;">
            <select name="p" class="form-control input-sm" onchange="this.form.submit()"><?php echo $cb($periodes, $periode); ?></select>
          </form>
          <a class="btn purple" href="<?php echo site_url('casualleasing/casualleasing/load?p=' . urlencode($periode)); ?>"><i class="fa fa-list"></i> Daftar Budget</a>
          <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/unit_master'); ?>"><i class="fa fa-cube"></i> Master Unit</a>
          <button type="button" class="btn green" id="btnExportExcel"><i class="fa fa-file-excel-o"></i> Excel</button>
          <a class="btn blue" target="_blank" href="<?php echo site_url('casualleasing/casualleasing/budget_print') . '?p=' . urlencode($periode); ?>"><i class="fa fa-print"></i> Cetak / PDF</a>
        </div>
      </div>
      <div class="portlet-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="clSummary">
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
                <tr><td colspan="21" class="text-center">Belum ada data pada periode ini.</td></tr>
              <?php } ?>
              <?php foreach ($rows as $r) {
                $cap = isset($r['cap_m2']) ? (float)$r['cap_m2'] : 0;
                $sisa = isset($r['uncreated_m2']) ? (float)$r['uncreated_m2'] : (isset($r['auto_vac_m2']) ? (float)$r['auto_vac_m2'] : 0);
                $over = isset($r['over_m2']) ? (float)$r['over_m2'] : 0;
              ?>
                <tr class="<?php echo $over > 0 ? 'cl-over-cap' : ''; ?>">
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
                  <td class="text-right"><?php echo cl_num($r['w1']); ?></td>
                  <td class="text-right"><?php echo cl_num($r['w2']); ?></td>
                  <td class="text-right"><?php echo cl_num($r['w3']); ?></td>
                  <td class="text-right"><?php echo cl_num($r['w4']); ?></td>
                  <td class="text-right"><?php echo cl_num($r['wtot']); ?></td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <th class="text-right">TOTAL</th>
                <?php
                  echo cl_bucket_cells($grand['nla'],    $grand['budget'], $grand['nla']);
                  echo cl_bucket_cells($grand['occ_m2'], $grand['occ_rp'], $grand['nla']);
                  echo cl_bucket_cells($grand['ren_m2'], $grand['ren_rp'], $grand['nla']);
                  echo cl_bucket_cells($grand['vac_m2'], $grand['vac_rp'], $grand['nla']);
                  echo cl_bucket_cells($grand['tot_m2'], $grand['tot_rp'], $grand['nla']);
                ?>
                <th class="text-right"><?php echo cl_num($grand['w1']); ?></th>
                <th class="text-right"><?php echo cl_num($grand['w2']); ?></th>
                <th class="text-right"><?php echo cl_num($grand['w3']); ?></th>
                <th class="text-right"><?php echo cl_num($grand['w4']); ?></th>
                <th class="text-right"><?php echo cl_num($grand['wtot']); ?></th>
              </tr>
            </tfoot>
          </table>
        </div>
        <p class="text-muted" style="font-size:11px;margin-top:8px;">
          Nilai Rp pada OCCUPIED/RENEWAL/VACANT dihitung dari (Occupied + Prospek) sesuai status budget.
          Kolom TARGET = jumlah nilai Prospek pada W1&ndash;W4.
          VACANT = unit master yang belum dibuatkan budget pada periode ini, ditambah budget berstatus VACANT.
          Kapasitas lokasi hanya menjadi validasi; selisih kapasitas yang belum memiliki unit ditampilkan terpisah sebagai
          &ldquo;belum dibuat unit&rdquo;.
        </p>
      </div>
    </div>
  </div>
</div>
