<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page cl-master-list">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-cube font-green-haze"></i>
          <span class="caption-subject bold uppercase">CL UNIT</span>
          <span class="caption-helper">Master unit fisik dan NLA. Budget dibuat dari unit di halaman CL Budget.</span>
        </div>
        <div class="actions">
          <?php if (!empty($available)) { ?>
            <a class="btn green" href="<?php echo site_url('casualleasing/casualleasing/unit_master_form'); ?>"><i class="fa fa-plus"></i> Tambah Unit</a>
          <?php } else { ?>
            <button type="button" class="btn green" disabled><i class="fa fa-plus"></i> Tambah Unit</button>
          <?php } ?>
        </div>
      </div>
      <div class="portlet-body">
        <?php if (!empty($msg)) { ?>
          <div class="alert alert-success"><i class="fa fa-check"></i> <?php echo htmlspecialchars($msg); ?></div>
        <?php } ?>
        <?php if (empty($available)) { ?>
          <div class="alert alert-warning"><i class="fa fa-warning"></i> Tabel master unit belum tersedia. Jalankan migrasi <code>06_unit_master_add.sql</code> terlebih dahulu.</div>
        <?php } ?>

        <form class="form-inline cl-filter" method="get" action="<?php echo site_url('casualleasing/casualleasing/unit_master'); ?>" style="margin-bottom:14px;">
          <div class="form-group">
            <label class="cl-filter-label" for="fLokasi">Lokasi</label>
            <select name="lokasi" id="fLokasi" class="form-control input-sm">
              <option value="">Semua Lokasi</option>
              <?php foreach ($lokasis as $l) { ?>
                <option value="<?php echo (int)$l['lokasi_id']; ?>" <?php echo ((int)$sel_lokasi === (int)$l['lokasi_id'] ? 'selected' : ''); ?>><?php echo htmlspecialchars($l['tipe_id'] . ' ' . $l['lokasi_code']); ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label class="cl-filter-label" for="fStatus">Status</label>
            <select name="status" id="fStatus" class="form-control input-sm">
              <option value="">Semua Status</option>
              <option value="1" <?php echo $sel_status === '1' ? 'selected' : ''; ?>>Aktif</option>
              <option value="0" <?php echo $sel_status === '0' ? 'selected' : ''; ?>>Nonaktif</option>
            </select>
          </div>
          <div class="form-group">
            <label class="cl-filter-label" for="fSearch">Pencarian</label>
            <input type="text" name="q" id="fSearch" class="form-control input-sm" value="<?php echo htmlspecialchars($q); ?>" placeholder="No / nama unit / lokasi">
          </div>
          <button type="submit" class="btn default btn-sm"><i class="fa fa-search"></i> Filter</button>
          <a class="btn default btn-sm" href="<?php echo site_url('casualleasing/casualleasing/unit_master'); ?>"><i class="fa fa-refresh"></i> Reset</a>
        </form>

        <table class="table table-striped table-bordered table-hover cl-master-table" id="clUnitTable">
          <thead>
              <tr>
                <th style="width:120px;">Tipe</th>
                <th style="width:130px;">Lokasi</th>
                <th class="text-center" style="width:80px;">No.</th>
                <th>Nama Unit</th>
                <th class="text-right" style="width:130px;">NLA (m&sup2;)</th>
                <th class="text-center" style="width:100px;">Dipakai</th>
                <th class="text-center" style="width:100px;">Status</th>
                <th class="text-center" style="width:110px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $r) { ?>
                <tr>
                  <td><code><?php echo htmlspecialchars($r['tipe_id']); ?></code></td>
                  <td><?php echo htmlspecialchars($r['lokasi_code']); ?></td>
                  <td class="text-center"><?php echo (int)$r['unit_no']; ?></td>
                  <td><?php echo htmlspecialchars($r['unit_name']); ?></td>
                  <td class="text-right"><?php echo number_format((float)$r['nla'], 2, '.', ','); ?></td>
                  <td class="text-center"><span class="label label-sm label-info"><?php echo (int)$r['budget_count']; ?> budget</span></td>
                  <td class="text-center"><?php echo ((int)$r['unit_isactive'] === 1 ? '<span class="label label-sm label-success">Aktif</span>' : '<span class="label label-sm label-default">Nonaktif</span>'); ?></td>
                  <td class="text-center cl-master-row-actions">
                    <a class="btn btn-xs default" href="<?php echo site_url('casualleasing/casualleasing/unit_master_view/' . (int)$r['unit_master_id']); ?>" title="Detail" aria-label="Detail unit"><i class="fa fa-eye"></i></a>
                    <a class="btn btn-xs blue" href="<?php echo site_url('casualleasing/casualleasing/unit_master_form/' . (int)$r['unit_master_id']); ?>" title="Edit" aria-label="Edit unit"><i class="fa fa-pencil"></i></a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

        <script type="text/javascript">
        $(document).ready(function(){
            $('#clUnitTable').DataTable({
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
                    { "orderable": false, "targets": [7] }
                ]
            });
        });
        </script>
      </div>
    </div>
  </div>
</div>
