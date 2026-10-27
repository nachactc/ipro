<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php if (!defined('CL_PAGE_STYLE_LOADED')): define('CL_PAGE_STYLE_LOADED', true); ?>
<style id="cl-page-style">
/* =====================================================================
   Casual Leasing - scoped styling
   Hanya berlaku di halaman yang memakai wrapper .cl-page.
   Dipakai untuk mengembalikan spacing form Metronic 4.7 yang di-override
   oleh style global template (.form-group margin-bottom: 1px) dan untuk
   merapikan toolbar/daftar unit CL.
   ===================================================================== */

/* ---------------------------------------------------------------- Form */
.cl-page .form-group {
    margin-bottom: 15px !important;
}

.cl-page .form-group.last {
    margin-bottom: 0 !important;
}

.cl-page .form-actions {
    margin-top: 5px;
}

.cl-page .help-block {
    font-size: 12px;
    color: #8a97a6;
    margin-bottom: 0;
}

.cl-page .portlet-body.form > .alert {
    margin-left: 15px;
    margin-right: 15px;
}

.cl-page .portlet-body.form > form > .form-body {
    padding-top: 10px;
}

.cl-page .form-section {
    margin: 4px 0 18px;
    padding-bottom: 8px;
    border-bottom: 1px solid #e7ecf1;
    font-size: 13px;
    font-weight: 600;
    color: #3f444a;
    letter-spacing: .3px;
    text-transform: uppercase;
}

.cl-page .form-section:first-child {
    margin-top: 0;
}

.cl-page .form-section i {
    color: #32c2cf;
    margin-right: 6px;
}

.cl-page .control-label {
    color: #3f444a;
    font-weight: 500;
}

.cl-page .form-control[readonly] {
    background: #f2f4f6;
    cursor: not-allowed;
}

.cl-page .input-group-addon {
    background: #f7f9fa;
    color: #5e738b;
}

.cl-page .cl-date-addon {
    cursor: pointer;
}

.cl-page .cl-date-addon:hover {
    color: #32c2cf;
}

.cl-page .form-actions .btn + .btn {
    margin-left: 6px;
}

/* --------------------------------------------------------------- Master */
.cl-master-list .cl-master-table {
    margin-bottom: 0;
}

.cl-master-list .cl-master-table thead th {
    background: #f7f9fa;
    color: #5e738b;
    font-weight: 600;
    vertical-align: middle;
}

.cl-master-list .cl-master-table tbody td {
    vertical-align: middle;
}

.cl-master-list .cl-master-table .cl-master-row-actions {
    white-space: nowrap;
}

.cl-master-list .cl-master-row-actions .btn + .btn {
    margin-left: 3px;
}

.cl-master-view .cl-master-detail-table {
    max-width: 900px;
    margin-bottom: 0;
}

.cl-master-view .cl-master-detail-table th {
    width: 240px;
    background: #f7f9fa;
    font-weight: 600;
}

/* ------------------------------------------------------------ Denah */
.cl-page .cl-denah-box {
    max-width: 900px;
    margin-top: 16px;
    padding-top: 14px;
    border-top: 1px solid #e7ecf1;
}

.cl-page .cl-denah-box .cl-denah-title {
    margin: 0 0 10px;
    font-size: 14px;
    font-weight: 600;
}

.cl-page .cl-denah-box .cl-denah-title i {
    color: #32c2cf;
    margin-right: 6px;
}

.cl-page .cl-denah-img {
    max-width: 100%;
    border: 1px solid #e7ecf1;
    border-radius: 4px;
    background: #ffffff;
}

/* Tabel ringkasan denah: ukuran seperti tabel CL Unit + scroll aman. */
.cl-page .cl-denah-scroll {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.cl-page table.cl-denah-table {
    margin-bottom: 0;
}

.cl-page table.cl-denah-table th,
.cl-page table.cl-denah-table td {
    font-size: 9pt;
    white-space: nowrap;
    vertical-align: middle;
}

.cl-page table.cl-denah-table thead th {
    background: #f7f9fa;
    color: #5e738b;
    font-weight: 600;
}

.cl-page table.cl-denah-table tfoot th {
    background: #f0f4f7;
    font-weight: 600;
}

.cl-page table.cl-denah-table td.cl-denah-lokasi {
    white-space: normal;
    min-width: 130px;
}

.cl-page .cl-denah-legend {
    margin-top: 10px;
    font-size: 12px;
}

.cl-page .cl-denah-legend .label {
    font-size: 10px;
    font-weight: 600;
    line-height: 1.4;
    padding: 2px 6px;
    margin-right: 4px;
}

.cl-period-tools {
    margin-top: 20px;
    padding: 16px;
    border: 1px solid #e7ecf1;
    border-radius: 4px;
    background: #f9fbfc;
}

.cl-period-tools h4 {
    margin: 0 0 8px;
    font-size: 14px;
    font-weight: 600;
}

.cl-period-tools .cl-period-tools-help {
    margin-bottom: 12px;
    font-size: 12px;
}

.cl-period-tools .cl-filter-label {
    display: block;
    margin: 0 0 4px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .3px;
    text-transform: uppercase;
    color: #8a97a6;
}

.cl-period-tools .form-control {
    width: 100%;
}

.cl-period-tools-action {
    padding-top: 22px;
}

/* ---------------------------------------------------------------- List */
.cl-page .portlet-title .btn-group {
    margin-left: 6px;
}

.cl-page .cl-filter {
    margin-bottom: 12px;
}

.cl-page .cl-filter-label {
    display: block;
    margin: 0 0 4px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .3px;
    text-transform: uppercase;
    color: #8a97a6;
}

.cl-page .cl-filter .form-control {
    width: 100%;
}

.cl-page .cl-bulk-bar {
    margin-bottom: 10px;
    padding: 8px 10px;
    background: #f9fbfc;
    border: 1px solid #e7ecf1;
    border-radius: 4px;
}

.cl-page .cl-bulk-bar .btn {
    margin-right: 4px;
}

.cl-page .cl-bulk-count {
    margin-left: 8px;
    font-size: 12px;
    color: #8a97a6;
}

.cl-page .cl-view-toggle-label {
    display: inline-block;
    margin-right: 6px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: .3px;
    text-transform: uppercase;
    color: #8a97a6;
    vertical-align: middle;
}

.cl-page .cl-bulk-bar .btn-group {
    vertical-align: middle;
}

.cl-page .cl-view-toggle .btn {
    background: #ffffff;
    border-color: #cfd6dc;
    color: #5e738b;
    box-shadow: none;
}

.cl-page .cl-view-toggle .btn:hover,
.cl-page .cl-view-toggle .btn:focus {
    background: #f2f6f8;
    border-color: #aebbc5;
    color: #3f5364;
}

.cl-page .cl-view-toggle .btn.active,
.cl-page .cl-view-toggle .btn.active:hover,
.cl-page .cl-view-toggle .btn.active:focus {
    background: #267f89;
    border-color: #206e77;
    color: #ffffff;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, .16);
}

.cl-page .cl-cell-sub {
    display: none;
    margin-top: 2px;
    font-size: 11px;
    line-height: 1.35;
    color: #8a97a6;
    white-space: normal;
}

.cl-page.cl-view-compact .cl-cell-sub {
    display: block;
}

.cl-page.cl-view-compact #clTable td {
    vertical-align: top;
}

.cl-page.cl-view-compact #clTable td,
.cl-page.cl-view-compact #clTable th {
    padding-left: 4px;
    padding-right: 4px;
}

.cl-page.cl-view-compact #clTable .label {
    font-size: 10px;
    font-weight: 600;
    line-height: 1.2;
    padding: 1px 4px;
}

@media (max-width: 767px) {
    .cl-page .cl-bulk-bar .pull-left,
    .cl-page .cl-bulk-bar .pull-right {
        float: none !important;
    }

    .cl-page .cl-bulk-bar .pull-right {
        margin-top: 8px;
    }
}

.cl-page #clTable td,
.cl-page #clTable th {
    font-size: 9pt;
    white-space: nowrap;
}

.cl-page #clTable thead th {
    background: #f7f9fa;
    vertical-align: middle;
}

.cl-page #clTable th.cl-sel,
.cl-page #clTable td.cl-sel {
    width: 30px;
    padding-left: 6px;
    padding-right: 6px;
    text-align: center;
}

.cl-page #clTable tbody td {
    vertical-align: middle;
}

.cl-page #clTable tfoot th {
    background: #f0f4f7;
    font-weight: 600;
}

.cl-page #clTable td.cl-col-unit,
.cl-page #clTable td.cl-col-period,
.cl-page #clTable td.cl-col-tenant {
    min-width: 140px;
    max-width: 220px;
    line-height: 1.35;
    white-space: normal;
}

.cl-page #clTable .cl-tenant-text {
    max-width: 220px;
    line-height: 1.35;
    white-space: normal;
    overflow-wrap: anywhere;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
}

.cl-page #clTable .cl-row-action-toggle {
    min-width: 92px;
    min-height: 34px;
    padding: 6px 10px;
    text-align: left;
}

.cl-action-menu {
    position: fixed;
    z-index: 100050;
    display: block;
    min-width: 190px;
    padding: 5px 0;
    border: 1px solid #d9e0e5;
    border-radius: 4px;
    background: #ffffff;
    box-shadow: 0 5px 14px rgba(0, 0, 0, .2);
    text-align: left;
}

.cl-action-menu:before,
.cl-action-menu:after {
    position: absolute;
    left: var(--cl-action-arrow-left, 24px);
    width: 0;
    height: 0;
    border-right: 7px solid transparent;
    border-left: 7px solid transparent;
    content: "";
}

.cl-action-menu:before {
    top: -8px;
    border-bottom: 7px solid #d9e0e5;
}

.cl-action-menu:after {
    top: -6px;
    border-bottom: 7px solid #ffffff;
}

.cl-action-menu.cl-action-menu-above:before,
.cl-action-menu.cl-action-menu-above:after {
    top: auto;
    transform: rotate(180deg);
}

.cl-action-menu.cl-action-menu-above:before {
    bottom: -8px;
}

.cl-action-menu.cl-action-menu-above:after {
    bottom: -6px;
}

.cl-action-menu > a {
    display: block;
    padding: 8px 14px;
    color: #5e738b;
    white-space: nowrap;
}

.cl-action-menu > a:hover,
.cl-action-menu > a:focus {
    background: #f2f6f8;
    color: #3f5364;
    text-decoration: none;
}

.cl-action-menu > a i {
    width: 20px;
    text-align: center;
}

.cl-action-menu .cl-action-menu-divider {
    height: 1px;
    margin: 5px 0;
    background: #e7ecf1;
}

.cl-page #clTable th.cl-col-actions,
.cl-page #clTable td.cl-col-actions,
.cl-page #clTable tfoot th:last-child {
    position: -webkit-sticky;
    position: sticky;
    right: 0;
    z-index: 2;
    background: #ffffff;
    box-shadow: -4px 0 6px -5px rgba(0, 0, 0, .45);
}

.cl-page #clTable thead th.cl-col-actions {
    z-index: 4;
    background: #f7f9fa;
}

.cl-page #clTable tbody tr:nth-child(odd) td.cl-col-actions {
    background: #f9f9f9;
}

.cl-page #clTable tfoot th:last-child {
    z-index: 3;
    background: #f0f4f7;
}

/* --------------------------------------------------- Toast & modal CL */
#clToast {
    position: fixed;
    top: 76px;
    right: 18px;
    z-index: 100001;
    width: 330px;
}

#clToast .cl-toast {
    box-shadow: 0 2px 10px rgba(0, 0, 0, .18);
    font-size: 12px;
    margin-bottom: 8px;
    padding: 10px 12px;
}

#clConfirm .modal-header {
    background-color: #32c2cf;
    border-bottom: 0;
}

#clConfirm .modal-title {
    color: #ffffff;
    font-weight: 600;
}

#clConfirm .modal-content {
    border-radius: 4px;
}

#clConfirm .modal-footer {
    padding: 12px 15px;
}

@media (max-width: 767px) {
    .cl-master-view .cl-master-detail-table th {
        width: 38%;
    }

    .cl-period-tools-action {
        padding-top: 10px;
    }
}
</style>
<?php endif; ?>
