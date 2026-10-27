<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page cl-master-list">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-building font-green-haze"></i>
          <span class="caption-subject bold uppercase">Casual Leasing - Master Lantai</span>
          <span class="caption-helper">Referensi posisi fisik (LG, GF, F1-F3) dan area non-lantai (OTHER).</span>
        </div>
        <div class="actions">
          <a class="btn green" href="<?php echo site_url('casualleasing/casualleasing/master_lantai_form'); ?>"><i class="fa fa-plus"></i> Tambah Lantai/Area</a>
        </div>
      </div>
      <div class="portlet-body">
        <?php if (!empty($msg)) { ?>
          <div class="alert alert-success"><i class="fa fa-check"></i> <?php echo htmlspecialchars($msg); ?></div>
        <?php } ?>

        <table class="table table-striped table-bordered table-hover cl-master-table" id="clLantaiTable">
          <thead>
              <tr>
                <th style="width:110px;">Kode</th>
                <th>Nama</th>
                <th class="text-center" style="width:90px;">Jenis</th>
                <th class="text-center" style="width:130px;">Denah</th>
                <th class="text-center" style="width:80px;">Urut</th>
                <th class="text-center" style="width:100px;">Status</th>
                <th class="text-center" style="width:110px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($lantais as $l) { ?>
                <tr>
                  <td><code><?php echo htmlspecialchars($l['lantai_code']); ?></code></td>
                  <td><?php echo htmlspecialchars($l['lantai_name']); ?></td>
                  <td class="text-center"><?php echo (strtoupper($l['lantai_jenis']) === 'AREA'
                      ? '<span class="label label-sm label-warning">AREA</span>'
                      : '<span class="label label-sm label-info">LANTAI</span>'); ?></td>
                  <td class="text-center"><?php $mf = isset($l['map_file']) ? trim((string)$l['map_file']) : ''; if ($mf !== '') { ?>
                    <a class="btn btn-xs default" href="<?php echo site_url('casualleasing/casualleasing/master_lantai_view/' . (int)$l['lantai_id']); ?>" title="Lihat denah" aria-label="Lihat denah"><i class="fa fa-eye"></i></a>
                  <?php } else { ?>
                    <span class="label label-sm label-default">Belum ada</span>
                  <?php } ?></td>
                  <td class="text-center"><?php echo (int)$l['lantai_order']; ?></td>
                  <td class="text-center"><?php echo ((int)$l['lantai_isactive'] === 1 ? '<span class="label label-sm label-success">Aktif</span>' : '<span class="label label-sm label-default">Nonaktif</span>'); ?></td>
                  <td class="text-center cl-master-row-actions">
                    <a class="btn btn-xs default" href="<?php echo site_url('casualleasing/casualleasing/master_lantai_view/' . (int)$l['lantai_id']); ?>" title="Detail &amp; Ringkasan denah" aria-label="Detail lantai"><i class="fa fa-eye"></i></a>
                    <a class="btn btn-xs blue" href="<?php echo site_url('casualleasing/casualleasing/master_lantai_form/' . (int)$l['lantai_id']); ?>" title="Edit" aria-label="Edit lantai"><i class="fa fa-pencil"></i></a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

        <script type="text/javascript">
        $(document).ready(function(){
            $('#clLantaiTable').DataTable({
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
                    { "orderable": false, "targets": [6] }
                ]
            });
        });
        </script>
      </div>
    </div>
  </div>
</div>
