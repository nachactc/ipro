<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $fmt = function($d) { return $d ? date('d-m-Y', strtotime($d)) : '-'; }; ?>

<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page cl-master-list">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-calendar font-green-haze"></i>
          <span class="caption-subject bold uppercase">Casual Leasing - Master Periode</span>
          <span class="caption-helper">Periode <b>pelaporan</b> bulanan (bucket angka W1-W4). Tanggal kontrak/unit ada di CL Budget, bukan di sini.</span>
        </div>
        <div class="actions">
          <a class="btn green" href="<?php echo site_url('casualleasing/casualleasing/master_periode_form'); ?>"><i class="fa fa-plus"></i> Tambah Periode</a>
        </div>
      </div>
      <div class="portlet-body">
        <?php if (!empty($msg)) { ?>
          <div class="alert alert-success"><i class="fa fa-check"></i> <?php echo htmlspecialchars($msg); ?></div>
        <?php } ?>

        <table class="table table-striped table-bordered table-hover cl-master-table" id="clPeriodeTable">
          <thead>
              <tr>
                <th style="width:140px;">Kode</th>
                <th>Nama</th>
                <th class="text-center" style="width:130px;">Awal Bulan</th>
                <th class="text-center" style="width:130px;">Akhir Bulan</th>
                <th class="text-center" style="width:100px;">Status</th>
                <th class="text-center" style="width:110px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($periodes as $p) { ?>
                <tr>
                  <td><code><?php echo htmlspecialchars($p['periode_id']); ?></code></td>
                  <td><?php echo htmlspecialchars($p['periode_name']); ?></td>
                  <td class="text-center"><?php echo $fmt($p['periode_start']); ?></td>
                  <td class="text-center"><?php echo $fmt($p['periode_end']); ?></td>
                  <td class="text-center"><?php echo ((int)$p['periode_isactive'] === 1 ? '<span class="label label-sm label-success">Aktif</span>' : '<span class="label label-sm label-default">Nonaktif</span>'); ?></td>
                  <td class="text-center cl-master-row-actions">
                    <a class="btn btn-xs default" href="<?php echo site_url('casualleasing/casualleasing/master_periode_view/' . rawurlencode($p['periode_id'])); ?>" title="Detail" aria-label="Detail periode"><i class="fa fa-eye"></i></a>
                    <a class="btn btn-xs blue" href="<?php echo site_url('casualleasing/casualleasing/master_periode_form/' . rawurlencode($p['periode_id'])); ?>" title="Edit" aria-label="Edit periode"><i class="fa fa-pencil"></i></a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

        <script type="text/javascript">
        $(document).ready(function(){
            $('#clPeriodeTable').DataTable({
                "searching": false,
                "order": [],
                "autoWidth": false,
                "pageLength": 25,
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "zeroRecords": "Tidak ada data yang cocok",
                    "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "paginate": {
                        "first": "Awal",
                        "last": "Akhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "columnDefs": [
                    { "orderable": false, "targets": [5] }
                ]
            });
        });
        </script>

        <div class="cl-period-tools">
          <h4><i class="fa fa-magic font-green-haze"></i> Lengkapi Tanggal dari Teks Periode</h4>
          <p class="text-muted cl-period-tools-help">
            Untuk baris lama yang tanggalnya kosong tetapi teks periodenya ada (mis. <code>17 NOV-16 DES</code>),
            sistem menebak tahun dari periode terpilih. Tanggal yang tidak valid (mis. 31 NOV) disesuaikan ke akhir bulan.
          </p>
          <form class="form-inline" method="post" action="<?php echo site_url('casualleasing/casualleasing/fix_dates'); ?>">
            <div class="row">
              <div class="col-md-4 col-sm-6">
                <label class="cl-filter-label" for="clFixDatesPeriod">Periode target</label>
                <select name="periode_id" id="clFixDatesPeriod" class="form-control input-sm">
                  <?php foreach ($periodes_opt as $k => $nm) { echo '<option value="' . htmlspecialchars($k) . '"' . ($k == $sel_periode ? ' selected' : '') . '>' . htmlspecialchars($nm) . '</option>'; } ?>
                </select>
              </div>
              <div class="col-md-3 col-sm-6 cl-period-tools-action">
                <button type="submit" class="btn btn-sm blue"><i class="fa fa-check"></i> Lengkapi Tanggal</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
