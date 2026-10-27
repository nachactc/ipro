<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$chunks = array_chunk($units, 10);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Label Tenant - Casual Leasing</title>
<style>
    @page { size: A4 portrait; margin: 8mm; }
    * { box-sizing: border-box; }
    body {
        margin: 0;
        padding: 9mm;
        background: #eef2f5;
        color: #15202b;
        font-family: Arial, Helvetica, sans-serif;
    }
    .noprint {
        max-width: 184mm;
        margin: 0 auto 7mm;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .noprint button {
        padding: 8px 18px;
        border: 0;
        border-radius: 3px;
        background: #2f80b9;
        color: #fff;
        font-weight: 700;
        cursor: pointer;
    }
    .noprint span { color: #607080; font-size: 12px; }
    .label-page {
        display: grid;
        grid-template-columns: repeat(2, 90mm);
        grid-auto-rows: 50mm;
        gap: 4mm;
        justify-content: center;
        margin: 0 auto 8mm;
        page-break-after: always;
        break-after: page;
    }
    .label-page:last-child { page-break-after: auto; break-after: auto; }
    .label-card {
        width: 90mm;
        height: 50mm;
        padding: 4mm 4.5mm;
        border: 1px dashed #9aa8b5;
        background: #fff;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        page-break-inside: avoid;
        break-inside: avoid;
    }
    .label-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 3mm;
        padding-bottom: 2mm;
        border-bottom: 1px solid #d8e0e7;
    }
    .brand {
        font-size: 8px;
        font-weight: 700;
        letter-spacing: .8px;
        text-transform: uppercase;
        color: #61707e;
    }
    .status {
        padding: 1.2mm 2.2mm;
        border-radius: 2px;
        font-size: 8px;
        font-weight: 700;
        letter-spacing: .4px;
        line-height: 1;
        white-space: nowrap;
    }
    .status-occupied { background: #e4f5eb; color: #1d7a45; }
    .status-renewal  { background: #fff1dc; color: #a45a00; }
    .status-vacant   { background: #edf1f4; color: #4d5b68; }
    .tenant {
        flex: 1 1 auto;
        min-height: 0;
        margin-top: 2.2mm;
        font-size: 17px;
        font-weight: 700;
        line-height: 1.15;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        word-break: break-word;
    }
    .tenant.empty { color: #8995a1; font-weight: 400; }
    .meta {
        flex: 0 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3mm;
        margin-top: 1.8mm;
        padding-top: 1.8mm;
        border-top: 1px solid #e2e8ed;
    }
    .meta .k {
        display: block;
        font-size: 7.5px;
        font-weight: 700;
        letter-spacing: .6px;
        color: #7a8794;
        text-transform: uppercase;
    }
    .meta .v {
        display: block;
        margin-top: .6mm;
        font-size: 11px;
        font-weight: 700;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .period {
        flex: 0 0 auto;
        margin-top: 1.5mm;
        font-size: 8px;
        color: #6b7885;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    @media print {
        body { padding: 0; background: #fff; }
        .noprint { display: none; }
        .label-page { margin: 0; }
        .label-card { border: 1px solid #b2bdc7; }
        .status { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }
</style>
</head>
<body>

<div class="noprint">
    <button type="button" onclick="window.print()">Cetak Label</button>
    <span><?php echo count($units); ?> label &middot; 90 &times; 50 mm &middot; maks. 10 label per A4</span>
</div>

<?php foreach ($chunks as $chunk) { ?>
<div class="label-page">
    <?php foreach ($chunk as $u) {
        $status = strtoupper((string)$u['unit_status']);
        $status_cls = strtolower($status);
        if (!in_array($status_cls, array('occupied', 'renewal', 'vacant'), true)) { $status_cls = 'vacant'; }
        $tenant = trim((string)$u['tenant']);
    ?>
    <div class="label-card">
        <div class="label-head">
            <span class="brand">Casual Leasing</span>
            <span class="status status-<?php echo $status_cls; ?>"><?php echo htmlspecialchars($status); ?></span>
        </div>

        <div class="tenant<?php echo $tenant === '' ? ' empty' : ''; ?>"><?php echo $tenant === '' ? 'Tanpa tenant' : htmlspecialchars($tenant); ?></div>

        <div class="meta">
            <div>
                <span class="k">Unit</span>
                <span class="v"><?php echo htmlspecialchars($u['unit_name']); ?></span>
            </div>
            <div>
                <span class="k">Size</span>
                <span class="v"><?php echo number_format((float)$u['nla'], 2, '.', ','); ?> m&sup2;</span>
            </div>
        </div>
        <div class="period"><?php echo htmlspecialchars($u['periode_display']); ?></div>
    </div>
    <?php } ?>
</div>
<?php } ?>

<?php if (!isset($_GET['noauto']) || $_GET['noauto'] !== '1') { ?>
<script>
window.addEventListener('load', function(){
    setTimeout(function(){ window.print(); }, 350);
});
</script>
<?php } ?>
</body>
</html>
