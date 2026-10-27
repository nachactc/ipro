<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page cl-master-list">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-users font-green-haze"></i>
          <span class="caption-subject bold uppercase">Casual Leasing - Master PIC</span>
          <span class="caption-helper">Kelola penanggung jawab data Casual Leasing.</span>
        </div>
        <div class="actions">
          <a class="btn green" href="<?php echo site_url('casualleasing/casualleasing/master_pic_form'); ?>"><i class="fa fa-plus"></i> Tambah PIC</a>
        </div>
      </div>
      <div class="portlet-body">
        <?php if (!empty($msg)) { ?>
          <div class="alert alert-success"><i class="fa fa-check"></i> <?php echo htmlspecialchars($msg); ?></div>
        <?php } ?>

        <table class="table table-striped table-bordered table-hover cl-master-table" id="clPicTable">
          <thead>
              <tr>
                <th style="width:160px;">Kode PIC</th>
                <th>Nama</th>
                <th class="text-center" style="width:100px;">Status</th>
                <th class="text-center" style="width:110px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pics as $p) { ?>
                <tr>
                  <td><code><?php echo htmlspecialchars((string)$p['pic_id']); ?></code></td>
                  <td><?php echo htmlspecialchars((string)$p['pic_name']); ?></td>
                  <td class="text-center"><?php echo ((int)$p['pic_isactive'] === 1 ? '<span class="label label-sm label-success">Aktif</span>' : '<span class="label label-sm label-default">Nonaktif</span>'); ?></td>
                  <td class="text-center cl-master-row-actions">
                    <a class="btn btn-xs default" href="<?php echo site_url('casualleasing/casualleasing/master_pic_view/' . rawurlencode($p['pic_id'])); ?>" title="Detail" aria-label="Detail PIC"><i class="fa fa-eye"></i></a>
                    <a class="btn btn-xs blue" href="<?php echo site_url('casualleasing/casualleasing/master_pic_form/' . rawurlencode($p['pic_id'])); ?>" title="Edit" aria-label="Edit PIC"><i class="fa fa-pencil"></i></a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

        <script type="text/javascript">
        $(document).ready(function(){
            $('#clPicTable').DataTable({
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
                    { "orderable": false, "targets": [3] }
                ]
            });
        });
        </script>
      </div>
    </div>
  </div>
</div>
