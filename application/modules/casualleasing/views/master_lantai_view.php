<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page cl-master-view">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-building font-green-haze"></i>
          <span class="caption-subject bold uppercase">Casual Leasing - Detail Lantai</span>
          <span class="caption-helper">Denah statis dan ringkasan status unit per lantai/area.</span>
        </div>
        <div class="actions">
          <a class="btn blue" href="<?php echo site_url('casualleasing/casualleasing/master_lantai_form/' . (int)$row['lantai_id']); ?>"><i class="fa fa-pencil"></i> Edit</a>
          <a class="btn default" href="<?php echo site_url('casualleasing/casualleasing/master_lantai'); ?>"><i class="fa fa-arrow-left"></i> Kembali</a>
        </div>
      </div>
      <div class="portlet-body">
        <table class="table table-striped table-bordered cl-master-detail-table">
          <tbody>
            <tr><th style="width:240px;">ID Lantai</th><td><?php echo (int)$row['lantai_id']; ?></td></tr>
            <tr><th>Kode</th><td><code><?php echo htmlspecialchars($row['lantai_code']); ?></code></td></tr>
            <tr><th>Nama</th><td><?php echo htmlspecialchars($row['lantai_name']); ?></td></tr>
            <tr><th>Jenis</th><td><?php echo (strtoupper($row['lantai_jenis']) === 'AREA'
                ? '<span class="label label-sm label-warning">AREA</span>'
                : '<span class="label label-sm label-info">LANTAI</span>'); ?></td></tr>
            <tr><th>Urut</th><td><?php echo (int)$row['lantai_order']; ?></td></tr>
            <tr><th>Status</th><td><?php echo ((int)$row['lantai_isactive'] === 1 ? '<span class="label label-sm label-success">Aktif</span>' : '<span class="label label-sm label-default">Nonaktif</span>'); ?></td></tr>
            <tr><th>Unit master aktif</th><td><?php echo (int)(isset($summary['master_n']) ? $summary['master_n'] : 0); ?> unit</td></tr>
          </tbody>
        </table>

        <?php $mf = isset($row['map_file']) ? trim((string)$row['map_file']) : ''; ?>
        <div class="cl-denah-box">
          <h4 class="cl-denah-title"><i class="fa fa-picture-o"></i> Denah <?php echo htmlspecialchars($row['lantai_code']); ?></h4>
          <?php if ($mf !== '') { ?>
            <button type="button" class="btn btn-sm default" id="btnViewDenah" aria-controls="denahWrap">
              <i class="fa fa-eye"></i> View Denah
            </button>
            <div id="denahWrap" style="display:none;">
              <img class="cl-denah-img" data-src="<?php echo base_url('assets/uploads/casualleasing/lantai/' . rawurlencode($mf)); ?>" alt="Denah <?php echo htmlspecialchars($row['lantai_code']); ?>">
            </div>
          <?php } else { ?>
            <div class="alert alert-info" style="margin-bottom:0;"><i class="fa fa-info-circle"></i> Denah belum diupload. Upload PNG/JPG melalui tombol Edit.</div>
          <?php } ?>
        </div>
      </div>
    </div>

    <?php if (!empty($summary) && (int)$row['lantai_isactive'] === 1) { ?>
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-pie-chart font-green-haze"></i>
          <span class="caption-subject bold uppercase">Ringkasan Denah - <?php echo htmlspecialchars($row['lantai_code']); ?></span>
          <span class="caption-helper">Status unit dari data CL Budget periode <?php echo htmlspecialchars((string)(isset($periode) ? $periode : '')); ?>, dihitung dari lokasi yang dipetakan.</span>
        </div>
        <div class="actions">
          <form method="get" action="<?php echo site_url('casualleasing/casualleasing/master_lantai_view/' . (int)$row['lantai_id']); ?>" class="form-inline" style="margin:0;">
            <select name="p" class="form-control input-sm" onchange="this.form.submit()">
              <?php foreach ($periodes as $pid => $pname) { ?>
                <option value="<?php echo htmlspecialchars($pid); ?>" <?php echo ($sel_periode == $pid ? 'selected' : ''); ?>><?php echo htmlspecialchars($pname); ?></option>
              <?php } ?>
            </select>
          </form>
        </div>
      </div>
      <div class="portlet-body">
        <div class="cl-denah-scroll">
        <table class="table table-striped table-bordered table-hover cl-denah-table" id="clDenahTable">
          <thead>
            <tr>
              <th>Lokasi</th>
              <th class="text-center">Budget (baris)</th>
              <th class="text-center">OCCUPIED</th>
              <th class="text-center">RENEWAL</th>
              <th class="text-center">VACANT</th>
              <th class="text-right">Budget (Rp)</th>
              <th class="text-right">Fcst Occupied (Rp)</th>
              <th class="text-right">Fcst Renewal (Rp)</th>
              <th class="text-right">Fcst Vacant (Rp)</th>
              <th class="text-right">Kapasitas NLA (m&sup2;)</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($summary['rows'])) { foreach ($summary['rows'] as $s) { ?>
              <tr>
                <td class="cl-denah-lokasi"><code><?php echo htmlspecialchars($s['code']); ?></code>
                  <span class="text-muted"><?php echo htmlspecialchars($s['tipe']); ?></span> <?php echo htmlspecialchars($s['name']); ?></td>
                <td class="text-center"><?php echo (int)$s['budget_n']; ?></td>
                <td class="text-center"><?php echo (int)$s['occ_n']; ?></td>
                <td class="text-center"><?php echo (int)$s['ren_n']; ?></td>
                <td class="text-center"><?php echo (int)$s['vac_n']; ?></td>
                <td class="text-right"><?php echo number_format($s['budget_rp'], 2, '.', ','); ?></td>
                <td class="text-right"><?php echo number_format($s['occ_rp'], 2, '.', ','); ?></td>
                <td class="text-right"><?php echo number_format($s['ren_rp'], 2, '.', ','); ?></td>
                <td class="text-right"><?php echo number_format($s['vac_rp'], 2, '.', ','); ?></td>
                <td class="text-right"><?php echo number_format($s['nla'], 2, '.', ','); ?></td>
              </tr>
            <?php } } else { ?>
              <tr><td colspan="10" class="text-center text-muted">Belum ada lokasi yang dipetakan ke lantai ini. Petakan melalui Master Lokasi.</td></tr>
            <?php } ?>
          </tbody>
          <?php if (!empty($summary['rows'])) { ?>
          <tfoot>
            <tr>
              <th>Total</th>
              <th class="text-center"><?php echo (int)$summary['total']['budget_n']; ?></th>
              <th class="text-center"><?php echo (int)$summary['total']['occ_n']; ?></th>
              <th class="text-center"><?php echo (int)$summary['total']['ren_n']; ?></th>
              <th class="text-center"><?php echo (int)$summary['total']['vac_n']; ?></th>
              <th class="text-right"><?php echo number_format($summary['total']['budget_rp'], 2, '.', ','); ?></th>
              <th class="text-right"><?php echo number_format($summary['total']['occ_rp'], 2, '.', ','); ?></th>
              <th class="text-right"><?php echo number_format($summary['total']['ren_rp'], 2, '.', ','); ?></th>
              <th class="text-right"><?php echo number_format($summary['total']['vac_rp'], 2, '.', ','); ?></th>
              <th class="text-right"></th>
            </tr>
          </tfoot>
          <?php } ?>
        </table>
        </div>

        <div class="cl-denah-legend">
          <span class="label" style="background:#c9253b;">OCCUPIED</span>
          <span class="label" style="background:#e08e0b;">RENEWAL</span>
          <span class="label" style="background:#32c5d2;">VACANT</span>
          <span class="text-muted" style="font-size:12px;">Denah statis hanya gambaran; angka pada tabel ini sumber kebenaran.</span>
        </div>
      </div>
    </div>
    <?php } elseif ((int)$row['lantai_isactive'] !== 1) { ?>
      <div class="portlet light bordered">
        <div class="portlet-body">
          <div class="alert alert-warning" style="margin-bottom:0;"><i class="fa fa-warning"></i> Lantai nonaktif: ringkasan denah tidak ditampilkan.</div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#btnViewDenah').on('click', function(){
        var $img  = $('#denahWrap').find('img.cl-denah-img');
        var open  = $('#denahWrap').is(':visible');
        if ($img.attr('src') !== $img.attr('data-src')) { $img.attr('src', $img.attr('data-src')); }
        $('#denahWrap').toggle(!open);
        $(this).html(open ? '<i class="fa fa-eye"></i> View Denah' : '<i class="fa fa-eye-slash"></i> Tutup Denah');
    });
});
</script>
