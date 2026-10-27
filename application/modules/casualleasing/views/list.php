<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$sel_periode = isset($periode) ? $periode : '';
$cb = function($arr, $sel) {
    $h = '';
    foreach ($arr as $k => $v) { $h .= '<option value="' . htmlspecialchars($k) . '"' . ($k == $sel ? ' selected' : '') . '>' . htmlspecialchars($v) . '</option>'; }
    return $h;
};
?>
<script src="<?php echo base_url(); ?>assets/plugins/exportexcel/xlsx.full.min.js"></script>
<script type="text/javascript">
var CL = {
    urlGrid : '<?php echo site_url("casualleasing/casualleasing/grid"); ?>',
    urlSetOccupied : '<?php echo site_url("casualleasing/casualleasing/setoccupied"); ?>',
    urlDelete : '<?php echo site_url("casualleasing/casualleasing/delete"); ?>',
    urlSetOccupiedBulk : '<?php echo site_url("casualleasing/casualleasing/setoccupied_bulk"); ?>',
    urlDeleteBulk : '<?php echo site_url("casualleasing/casualleasing/delete_bulk"); ?>',
    urlEdit : '<?php echo site_url("casualleasing/casualleasing/edit"); ?>',
    urlView : '<?php echo site_url("casualleasing/casualleasing/view"); ?>',
    urlPrint : '<?php echo site_url("casualleasing/casualleasing/unit_print"); ?>',
    urlLabel : '<?php echo site_url("casualleasing/casualleasing/unit_label"); ?>',
    periode : '<?php echo $sel_periode; ?>'
};

function clNumber(v){ if (v === null || v === undefined || v === '') return ''; return $.number(v, 2, '.', ','); }
function clEsc(s){ return $('<div>').text(s == null ? '' : s).html(); }
function clStatus(s){
    var map = { 'OCCUPIED':'label label-sm label-success', 'RENEWAL':'label label-sm label-warning', 'VACANT':'label label-sm label-default' };
    return '<span class="' + (map[s]||'label label-sm label-default') + '">' + s + '</span>';
}

/* ARR = nilai Rp / NLA, mengikuti kolom ARR pada template Excel. */
function clArrRate(value, nla){
    nla = parseFloat(nla) || 0;
    return nla > 0 ? (parseFloat(value) || 0) / nla : 0;
}

function clUnitExportAoa(rows){
    var head = ['NO','PERIODE','TIPE','LOKASI','UNIT','PIC','NLA (m2)','STATUS','TENANT',
                'TIPE PERIODE','MULAI','SELESAI','BUDGET','OCCUPIED','W1','W2','W3','W4','PROSPEK',
                'FCST CLOSING','ARR BUDGET','ARR OCCUPIED','ARR PROSPEK','ARR FCST','CATATAN'];
    var aoa = [head];
    var tot = { nla:0, budget:0, occupied:0, w1:0, w2:0, w3:0, w4:0, prospek:0, fcst:0 };

    rows.forEach(function(r, i){
        var nla = parseFloat(r.nla) || 0;
        var budget = parseFloat(r.budget) || 0;
        var occupied = parseFloat(r.occupied) || 0;
        var w1 = parseFloat(r.w1) || 0;
        var w2 = parseFloat(r.w2) || 0;
        var w3 = parseFloat(r.w3) || 0;
        var w4 = parseFloat(r.w4) || 0;
        var prospek = w1 + w2 + w3 + w4;
        var fcst = occupied + prospek;
        tot.nla += nla; tot.budget += budget; tot.occupied += occupied;
        tot.w1 += w1; tot.w2 += w2; tot.w3 += w3; tot.w4 += w4;
        tot.prospek += prospek; tot.fcst += fcst;

        aoa.push([
            i + 1,
            r.periode || '',
            r.tipe || '',
            r.lokasi || '',
            r.unit || '',
            r.pic || '',
            nla,
            r.status || '',
            r.tenant || '',
            r.periode_type || '',
            r.periode_start || '',
            r.periode_end || '',
            budget,
            occupied,
            w1,
            w2,
            w3,
            w4,
            prospek,
            fcst,
            clArrRate(budget, nla),
            clArrRate(occupied, nla),
            clArrRate(prospek, nla),
            clArrRate(fcst, nla),
            r.remarks || ''
        ]);
    });

    aoa.push([
        'TOTAL','','','','','',tot.nla,'','','','','',
        tot.budget,tot.occupied,tot.w1,tot.w2,tot.w3,tot.w4,tot.prospek,tot.fcst,
        clArrRate(tot.budget,tot.nla),clArrRate(tot.occupied,tot.nla),
        clArrRate(tot.prospek,tot.nla),clArrRate(tot.fcst,tot.nla),''
    ]);
    return aoa;
}

function clUnitExportBuild(rows, pname){
    var aoa = clUnitExportAoa(rows);
    var ws = XLSX.utils.aoa_to_sheet(aoa);
    ws['!cols'] = [6,20,10,8,18,7,11,10,24,13,11,11,15,15,15,15,15,15,15,15,13,13,13,13,24].map(function(w){ return { wch:w }; });
    ws['!autofilter'] = { ref: 'A1:Y' + (aoa.length - 1) };

    var numCols = [6,12,13,14,15,16,17,18,19,20,21,22,23];
    for (var R = 1; R < aoa.length; R++) {
        numCols.forEach(function(C){
            var addr = XLSX.utils.encode_cell({ r:R, c:C });
            if (ws[addr]) { ws[addr].z = '#,##0.00'; }
        });
    }

    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'CL BUDGET');
    var safe = String(pname || 'periode').replace(/[^A-Za-z0-9]+/g, '_').replace(/^_+|_+$/g, '');
    return { aoa:aoa, ws:ws, wb:wb, fname:'CL_BUDGET_' + safe + '.xlsx' };
}

function clUnitExportFile(rows, pname){
    var out = clUnitExportBuild(rows, pname);
    XLSX.writeFile(out.wb, out.fname);
    return out;
}

/* Toast pengganti alert(); pesan boleh mengandung markup sederhana. */
function clToast(msg, type){
    var cls = type === 'error' ? 'alert-danger' : (type === 'warn' ? 'alert-warning' : 'alert-success');
    var $t = $('<div class="alert ' + cls + ' cl-toast">' + msg + '</div>');
    $('#clToast').append($t);
    setTimeout(function(){ $t.fadeOut(250, function(){ $(this).remove(); }); }, 3500);
    return $t;
}

/* Konfirmasi bergaya Metronic (pengganti confirm()). */
var clConfirmCb = null;
function clConfirm(msg, okLabel, okClass, cb){
    clConfirmCb = cb;
    $('#clConfirmMsg').html(msg);
    $('#clConfirmOk').text(okLabel || 'Ya, Lanjutkan')
        .removeClass('btn-primary btn-success btn-danger green red blue')
        .addClass(okClass || 'btn-primary');
    $('#clConfirm').modal('show');
}
$(document).on('click', '#clConfirmOk', function(){
    $('#clConfirm').modal('hide');
    var cb = clConfirmCb; clConfirmCb = null;
    if (cb) { cb(); }
});
$(document).on('hidden.bs.modal', '#clConfirm', function(){ clConfirmCb = null; });

$(document).ready(function(){
    var params = function(){
        return {
            p: $('#fPeriode').val(),
            tipe: $('#fTipe').val(),
            lokasi: $('#fLokasi').val(),
            status: $('#fStatus').val(),
            q: $('#fSearch').val()
        };
    };

    var table = $('#clTable').DataTable({
        "processing": true,
        "serverSide": false,
        "searching": false,
        "order": [],
        "pageLength": 25,
        "lengthMenu": [[10,25,50,100,-1],[10,25,50,100,"Semua"]],
        "language": {
            "processing": "Memuat data...",
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
        "ajax": {
            "url": CL.urlGrid,
            "type": "GET",
            "data": function(d){ var p = params(); d.p = p.p; d.tipe = p.tipe; d.lokasi = p.lokasi; d.status = p.status; d.q = p.q; }
        },
        "columns": [
            { "data": null, "orderable": false, "className":"text-center cl-sel", "width":"30px", "render": function(d, t, row){
                return '<input type="checkbox" class="cl-check" value="' + row.unit_id + '">';
            } },
            { "data": "no", "className":"text-center", "width":"40px" },
            { "data": "tipe" },
            { "data": "lokasi" },
            { "data": "unit", "className":"cl-col-unit", "render": function(d, t, row){
                return '<div class="cl-cell-main">' + clEsc(d) + '</div>' +
                       '<div class="cl-cell-sub">' + clEsc(row.tipe) + ' &middot; ' + clEsc(row.lokasi) +
                       '<br>' + clEsc(row.periode) + '</div>';
            } },
            { "data": "pic", "className":"text-center" },
            { "data": "nla", "className":"text-right", "render": function(d){ return clNumber(d); } },
            { "data": "status", "className":"text-center", "render": function(d, t, row){
                return clStatus(d) + '<div class="cl-cell-sub">' + clEsc(row.week) + '</div>';
            } },
            { "data": "periode", "className":"cl-col-period" },
            { "data": "tenant", "className":"cl-col-tenant", "render": function(d, type){
                if (type !== 'display') { return d; }
                var $tenant = $('<div>').addClass('cl-tenant-text').text(d == null ? '' : d);
                $tenant.attr('title', $tenant.text());
                return $tenant.prop('outerHTML');
            } },
            { "data": "budget", "className":"text-right", "render": function(d){ return clNumber(d); } },
            { "data": "occupied", "className":"text-right", "render": function(d){ return clNumber(d); } },
            { "data": "w1", "className":"text-right cl-col-week", "render": function(d){ return (parseFloat(d)||0) ? clNumber(d) : ''; } },
            { "data": "w2", "className":"text-right cl-col-week", "render": function(d){ return (parseFloat(d)||0) ? clNumber(d) : ''; } },
            { "data": "w3", "className":"text-right cl-col-week", "render": function(d){ return (parseFloat(d)||0) ? clNumber(d) : ''; } },
            { "data": "w4", "className":"text-right cl-col-week", "render": function(d){ return (parseFloat(d)||0) ? clNumber(d) : ''; } },
            { "data": "prospek", "className":"text-right", "render": function(d){ return clNumber(d); } },
            { "data": "fcst", "className":"text-right", "render": function(d, t, row){
                return clNumber(d) +
                       '<div class="cl-cell-sub">Occ ' + clNumber(row.occupied) +
                       ' / Pros ' + clNumber(row.prospek) + '</div>';
            } },
            { "data": null, "orderable": false, "className":"text-center cl-col-actions", "width":"110px", "render": function(d, t, row){
                var id = parseInt(row.unit_id, 10) || 0;
                return '<button type="button" class="btn btn-sm default cl-row-action-toggle" aria-haspopup="true" aria-expanded="false"' +
                       ' data-id="' + id + '"' +
                       ' data-unit="' + clEsc(row.unit) + '"' +
                       ' data-tenant="' + clEsc(row.tenant || '') + '"' +
                       ' data-status="' + clEsc(row.status) + '">' +
                       ' Actions <span class="caret"></span></button>';
            } }
        ],
        "footerCallback": function (tfoot, data) {
            var api = this.api();
            var sum = function(col){ var t=0; api.column(col, {search:'applied'}).data().each(function(v){ t += parseFloat(v)||0; }); return t; };
            [6,10,11,12,13,14,15,16,17].forEach(function(col){
                $(api.column(col).footer()).html(clNumber(sum(col)));
            });
        }
    });

    // Tampilan ringkas (default) / lengkap. Hanya visibilitas kolom,
    // data dan laporan tetap lengkap.
    var compactHidden = [1, 2, 3, 5, 8, 10, 11, 12, 13, 14, 15, 16];
    function clSetView(mode) {
        var compact = mode !== 'full';
        $('.cl-page').toggleClass('cl-view-compact', compact);
        $.each(compactHidden, function(i, idx){ table.column(idx).visible(!compact, false); });
        $(table.column(4).header()).html(compact ? 'Unit / Lokasi' : 'Unit');
        $(table.column(6).header()).html(compact ? 'NLA' : 'NLA (m&sup2;)');
        $(table.column(17).header()).html(compact ? 'Nilai' : 'Fcst Closing');
        $('#clModeCompact').toggleClass('active', compact);
        $('#clModeFull').toggleClass('active', !compact);
        $('#clModeCompact').attr('aria-pressed', compact ? 'true' : 'false');
        $('#clModeFull').attr('aria-pressed', compact ? 'false' : 'true');
        table.columns.adjust().draw(false);
        try { localStorage.setItem('cl_unit_view_v2', compact ? 'compact' : 'full'); } catch (e) {}
    }
    $('#clModeCompact').on('click', function(){ clSetView('compact'); });
    $('#clModeFull').on('click', function(){ clSetView('full'); });
    var clSavedView = null;
    try { clSavedView = localStorage.getItem('cl_unit_view_v2'); } catch (e) {}
    // Default Lengkap agar kolom W1-W4 langsung terlihat.
    clSetView(clSavedView === 'compact' ? 'compact' : 'full');

    var $clActionMenu = null;
    var $clActionTrigger = null;
    function clCloseActionMenu() {
        if ($clActionTrigger) { $clActionTrigger.attr('aria-expanded', 'false'); }
        if ($clActionMenu) { $clActionMenu.remove(); }
        $clActionMenu = null;
        $clActionTrigger = null;
    }

    function clOpenActionMenu($trigger) {
        clCloseActionMenu();

        var id = parseInt($trigger.attr('data-id'), 10) || 0;
        var unit = $trigger.attr('data-unit') || '';
        var tenant = $trigger.attr('data-tenant') || '';
        var status = $trigger.attr('data-status') || '';
        var $menu = $('<div class="cl-action-menu" role="menu"></div>');
        $menu.append($('<a role="menuitem"><i class="fa fa-eye text-primary"></i> Lihat Detail</a>')
            .attr('href', CL.urlView + '/' + id));

        var $edit = $('<a role="menuitem"><i class="fa fa-pencil"></i> Edit</a>')
            .attr('href', CL.urlEdit + '/' + id + '?p=' + encodeURIComponent(CL.periode));
        $menu.append($edit);

        $menu.append($('<a role="menuitem" target="_blank"><i class="fa fa-tag text-primary"></i> Print Label</a>')
            .attr('href', CL.urlLabel + '/' + id + '?auto=1'));

        if (status !== 'OCCUPIED') {
            $menu.append($('<a href="#" role="menuitem" class="cl-occupy"><i class="fa fa-check text-success"></i> Jadikan Occupied</a>')
                .attr('data-id', id).attr('data-unit', unit));
        }

        $menu.append('<div class="cl-action-menu-divider" role="separator"></div>');
        $menu.append($('<a href="#" role="menuitem" class="cl-delete text-danger"><i class="fa fa-trash"></i> Hapus</a>')
            .attr('data-id', id).attr('data-unit', unit).attr('data-tenant', tenant));

        $('body').append($menu);
        $clActionMenu = $menu;
        $clActionTrigger = $trigger;
        $trigger.attr('aria-expanded', 'true');

        var triggerRect = $trigger[0].getBoundingClientRect();
        var menuRect = $menu[0].getBoundingClientRect();
        var margin = 8;
        var left = Math.max(margin, Math.min(
            triggerRect.right - menuRect.width,
            window.innerWidth - menuRect.width - margin
        ));
        var belowTop = triggerRect.bottom + 7;
        var aboveTop = triggerRect.top - menuRect.height - 7;
        var placeAbove = belowTop + menuRect.height > window.innerHeight - margin &&
                         aboveTop >= margin;
        var top = placeAbove ? aboveTop : Math.min(belowTop, window.innerHeight - menuRect.height - margin);
        top = Math.max(margin, top);
        var arrowLeft = Math.max(14, Math.min(
            triggerRect.left + triggerRect.width / 2 - left - 7,
            menuRect.width - 21
        ));

        $menu.toggleClass('cl-action-menu-above', placeAbove)
            .css({ left: left + 'px', top: top + 'px' });
        $menu[0].style.setProperty('--cl-action-arrow-left', arrowLeft + 'px');
    }

    $(document).on('click', '.cl-row-action-toggle', function(e) {
        e.preventDefault();
        e.stopPropagation();
        if ($clActionTrigger && $clActionTrigger[0] === this) {
            clCloseActionMenu();
        } else {
            clOpenActionMenu($(this));
        }
    });
    $(document).on('click', '.cl-action-menu', function(e) { e.stopPropagation(); });
    $(document).on('click', function() { clCloseActionMenu(); });
    $(window).on('resize scroll', clCloseActionMenu);
    $('.table-scrollable').on('scroll', clCloseActionMenu);
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') { clCloseActionMenu(); }
    });
    table.on('draw.dt', clCloseActionMenu);

    // Perubahan filter -> muat ulang data
    $('#fPeriode').on('change', function(){ CL.periode = $(this).val(); table.ajax.reload(); });
    $('#fTipe, #fLokasi, #fStatus').on('change', function(){ table.ajax.reload(); });
    var tmr = null;
    $('#fSearch').on('keyup', function(){ clearTimeout(tmr); tmr = setTimeout(function(){ table.ajax.reload(); }, 300); });
    $('#btnResetFilter').on('click', function(){
        $('#fTipe, #fLokasi, #fStatus').val('');
        $('#fSearch').val('');
        table.ajax.reload(null, true);
    });

    // Jadikan Occupied
    $(document).on('click', '.cl-action-menu .cl-occupy', function(e){
        e.preventDefault();
        var $action = $(this);
        var id = $action.attr('data-id');
        var row = { unit: $action.attr('data-unit') || '' };
        clCloseActionMenu();
        var msg = 'Pindahkan seluruh nilai <b>Prospek W1&ndash;W4</b> ke <b>Occupied</b> dan ubah status unit <b>' +
                  clEsc(row.unit) + '</b> menjadi <b>OCCUPIED</b>?';
        clConfirm(msg, 'Ya, Jadikan Occupied', 'btn green', function(){
            $.post(CL.urlSetOccupied, { unit_id: id }, function(res){
                if (res && res.ok) {
                    clToast('Status unit <b>' + clEsc(row.unit) + '</b> berhasil diubah menjadi OCCUPIED.');
                    table.ajax.reload(null, false);
                } else {
                    clToast('Gagal mengubah status unit.', 'error');
                }
            }, 'json').fail(function(){
                clToast('Gagal mengubah status (koneksi/server).', 'error');
            });
        });
    });

    // Hapus
    $(document).on('click', '.cl-action-menu .cl-delete', function(e){
        e.preventDefault();
        var $action = $(this);
        var id = $action.attr('data-id');
        var row = {
            unit: $action.attr('data-unit') || '',
            tenant: $action.attr('data-tenant') || ''
        };
        clCloseActionMenu();
        var msg = 'Hapus data unit <b>' + clEsc(row.unit) + '</b>' +
                  (row.tenant ? ' (tenant: <b>' + clEsc(row.tenant) + '</b>)' : '') +
                  '?<br><span class="text-muted" style="font-size:11px;">Data yang dihapus tidak dapat dikembalikan.</span>';
        clConfirm(msg, 'Ya, Hapus', 'btn red', function(){
            $.post(CL.urlDelete, { unit_id: id }, function(res){
                if (res && res.ok) {
                    clToast('Data unit <b>' + clEsc(row.unit) + '</b> berhasil dihapus.');
                    table.ajax.reload(null, false);
                } else {
                    clToast('Gagal menghapus data unit.', 'error');
                }
            }, 'json').fail(function(){
                clToast('Gagal menghapus data (koneksi/server).', 'error');
            });
        });
    });

    // ================= AKSI MASSAL =================
    function clSelected(){
        var ids = [];
        $('#clTable tbody input.cl-check:checked').each(function(){ ids.push($(this).val()); });
        return ids;
    }
    function clSyncBulk(){
        var n = clSelected().length;
        $('#clBulkCount').text(n > 0 ? n + ' dipilih' : '');
        $('#btnBulkOccupy, #btnBulkDelete, #btnBulkLabel').prop('disabled', n === 0);
    }

    $('#clCheckAll').on('change', function(){
        var on = $(this).is(':checked');
        $('#clTable tbody input.cl-check').prop('checked', on);
        clSyncBulk();
    });
    $('#clTable').on('change', 'input.cl-check', function(){
        var total = $('#clTable tbody input.cl-check').length;
        var sel = clSelected().length;
        $('#clCheckAll').prop('checked', total > 0 && sel === total);
        clSyncBulk();
    });
    $('#clTable').on('draw.dt', function(){
        $('#clCheckAll').prop('checked', false);
        clSyncBulk();
    });

    $('#btnBulkOccupy').on('click', function(){
        var ids = clSelected();
        if (ids.length === 0) { clToast('Pilih minimal satu budget.', 'warn'); return; }
        clConfirm('Pindahkan seluruh nilai <b>Prospek W1&ndash;W4</b> ke <b>Occupied</b> dan ubah status <b>' + ids.length +
                  ' budget</b> terpilih menjadi <b>OCCUPIED</b>?', 'Ya, Jadikan Occupied', 'btn green', function(){
            $.post(CL.urlSetOccupiedBulk, { unit_id: ids }, function(res){
                if (res && res.ok) {
                    clToast('<b>' + res.count + ' budget</b> berhasil diubah menjadi OCCUPIED.');
                    table.ajax.reload(null, false);
                } else {
                    clToast('Tidak ada unit yang berhasil diubah.', 'error');
                }
            }, 'json').fail(function(){ clToast('Gagal mengubah status (koneksi/server).', 'error'); });
        });
    });

    $('#btnBulkLabel').on('click', function(){
        var ids = clSelected();
        if (ids.length === 0) { clToast('Pilih minimal satu budget.', 'warn'); return; }
        window.open(CL.urlLabel + '?auto=1&ids=' + encodeURIComponent(ids.join(',')), '_blank');
    });

    $('#btnBulkDelete').on('click', function(){
        var ids = clSelected();
        if (ids.length === 0) { clToast('Pilih minimal satu budget.', 'warn'); return; }
        clConfirm('Hapus <b>' + ids.length + ' budget</b> terpilih?<br><span class="text-muted" style="font-size:11px;">Data yang dihapus tidak dapat dikembalikan.</span>',
                  'Ya, Hapus', 'btn red', function(){
            $.post(CL.urlDeleteBulk, { unit_id: ids }, function(res){
                if (res && res.ok) {
                    clToast('<b>' + res.count + ' budget</b> berhasil dihapus.');
                    table.ajax.reload(null, false);
                } else {
                    clToast('Tidak ada budget yang berhasil dihapus.', 'error');
                }
            }, 'json').fail(function(){ clToast('Gagal menghapus data (koneksi/server).', 'error'); });
        });
    });

    // Export Excel daftar unit (mengikuti filter yang aktif)
    $('#btnExportUnit').on('click', function(){
        var rows = table.rows().data().toArray();
        if (!rows.length) { clToast('Tidak ada data untuk diexport.', 'warn'); return; }
        if (typeof XLSX === 'undefined') { clToast('Library Excel tidak termuat.', 'error'); return; }
        var pname = $('#fPeriode option:selected').text() || CL.periode || 'periode';
        try {
            var out = clUnitExportFile(rows, pname);
            clToast('File Excel <b>' + clEsc(out.fname) + '</b> berhasil dibuat.');
        } catch (e) {
            clToast('Gagal membuat Excel: ' + clEsc(e.message), 'error');
        }
    });

    // Cetak daftar unit (A4 landscape) mengikuti filter aktif
    $('#btnPrintUnit').on('click', function(){
        window.open(CL.urlPrint + '?' + $.param(params()), '_blank');
    });
});
</script>

<?php include __DIR__ . '/_style.php'; ?>

<div class="row cl-page">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="icon-basket font-green-haze"></i>
          <span class="caption-subject bold uppercase">CL BUDGET</span>
          <span class="caption-helper">Daftar budget, status, dan nilai prospek per minggu. Pilih unit master saat input.</span>
        </div>
        <div class="actions">
          <a class="btn green" href="<?php echo site_url('casualleasing/casualleasing/add'); ?>"><i class="fa fa-plus"></i> Input Budget</a>
          <a class="btn purple" href="<?php echo site_url('casualleasing/casualleasing/import'); ?>"><i class="fa fa-upload"></i> Import</a>
          <button type="button" class="btn green" id="btnExportUnit"><i class="fa fa-file-excel-o"></i> Excel</button>
          <button type="button" class="btn default" id="btnPrintUnit"><i class="fa fa-print"></i> Cetak</button>
        </div>
      </div>
      <div class="portlet-body">
        <?php if (!empty($msg)) { ?>
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo htmlspecialchars($msg); ?></div>
        <?php } ?>
        <div class="row cl-filter">
          <div class="col-md-2 col-sm-6 col-xs-6">
            <label class="cl-filter-label" for="fPeriode">Periode</label>
            <select id="fPeriode" class="form-control input-sm"><?php echo $cb($periodes, $sel_periode); ?></select>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-6">
            <label class="cl-filter-label" for="fTipe">Tipe</label>
            <select id="fTipe" class="form-control input-sm">
              <option value="">Semua Tipe</option>
              <?php echo $cb($tipes, ''); ?>
            </select>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-6">
            <label class="cl-filter-label" for="fLokasi">Lokasi</label>
            <select id="fLokasi" class="form-control input-sm">
              <option value="">Semua Lokasi</option>
              <?php foreach ($lokasis as $l) { echo '<option value="' . (int)$l['lokasi_id'] . '">' . htmlspecialchars($l['tipe_id'] . ' ' . $l['lokasi_code']) . '</option>'; } ?>
            </select>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-6">
            <label class="cl-filter-label" for="fStatus">Status</label>
            <select id="fStatus" class="form-control input-sm">
              <option value="">Semua Status</option>
              <?php echo $cb($statuses, ''); ?>
            </select>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-12">
            <label class="cl-filter-label" for="fSearch">Pencarian</label>
            <div class="input-group input-group-sm">
              <span class="input-group-addon"><i class="fa fa-search"></i></span>
              <input type="text" id="fSearch" class="form-control" placeholder="Unit / tenant / PIC">
            </div>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-6">
            <label class="cl-filter-label">&nbsp;</label>
            <button type="button" class="btn default btn-sm btn-block" id="btnResetFilter"><i class="fa fa-refresh"></i> Reset</button>
          </div>
        </div>

        <div class="cl-bulk-bar clearfix">
          <div class="pull-left">
            <button type="button" class="btn btn-sm green" id="btnBulkOccupy" disabled><i class="fa fa-check"></i> Jadikan Occupied (terpilih)</button>
            <button type="button" class="btn btn-sm blue" id="btnBulkLabel" disabled><i class="fa fa-tag"></i> Print Label (terpilih)</button>
            <button type="button" class="btn btn-sm red" id="btnBulkDelete" disabled><i class="fa fa-trash"></i> Hapus (terpilih)</button>
            <span id="clBulkCount" class="cl-bulk-count"></span>
          </div>
          <div class="pull-right">
            <span class="cl-view-toggle-label">Tampilan</span>
            <div class="btn-group btn-group-sm cl-view-toggle" role="group" aria-label="Tampilan tabel">
              <button type="button" class="btn default" id="clModeCompact" aria-pressed="false">Ringkas</button>
              <button type="button" class="btn default active" id="clModeFull" aria-pressed="true">Lengkap</button>
            </div>
          </div>
        </div>

        <table class="table table-striped table-bordered table-hover" id="clTable">
          <thead>
            <tr>
              <th class="cl-sel"><input type="checkbox" id="clCheckAll" title="Pilih semua"></th>
              <th>No</th>
              <th>Tipe</th>
              <th>Lokasi</th>
              <th>Unit</th>
              <th class="text-center">PIC</th>
              <th class="text-right">NLA (m&sup2;)</th>
              <th class="text-center">Status</th>
              <th>Periode</th>
              <th>Tenant</th>
              <th class="text-right">Budget</th>
              <th class="text-right">Occupied</th>
              <th class="text-right">W1</th>
              <th class="text-right">W2</th>
              <th class="text-right">W3</th>
              <th class="text-right">W4</th>
              <th class="text-right">Prospek</th>
              <th class="text-right">Fcst Closing</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th>TOTAL</th>
              <th></th>
              <th class="text-right"></th>
              <th></th>
              <th></th>
              <th></th>
              <th class="text-right"></th>
              <th class="text-right"></th>
              <th class="text-right"></th>
              <th class="text-right"></th>
              <th class="text-right"></th>
              <th class="text-right"></th>
              <th class="text-right"></th>
              <th class="text-right"></th>
              <th></th>
            </tr>
          </tfoot>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- ================= MODAL: konfirmasi (pengganti confirm()) ================= -->
<div class="modal fade" id="clConfirm" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Konfirmasi</h4>
      </div>
      <div class="modal-body" id="clConfirmMsg"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="clConfirmOk">Ya, Lanjutkan</button>
      </div>
    </div>
  </div>
</div>

<div id="clToast"></div>
