<?php
// If access is requested from anywhere other than index.php then exit
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if ($this->uri->segment(4) == "" || $this->uri->segment(4) == "list") {
    ?>
    <!-- load datatable script for datagrid table -->
    <!--<script src="<?php //echo base_url('/assets/js/datagrid/datatables/datatables.bundle.js'); ?>"></script>
    <script src="<?php //echo base_url('/assets/js/datagrid/datatables/datatables.export.js'); ?>"></script>
    -->
    <script src="<?php echo base_url('/assets/js/formplugins/inputmask/inputmask.bundle.js'); ?>"></script>
    <script src="<?php echo base_url('/assets/js/formplugins/jquery.number.min.js'); ?>"></script>
    <!-- load datepicker -->
    <script src="<?php echo base_url('/assets/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js'); ?>"></script>
    <script src="<?php echo base_url('/assets/js/formplugins/select2/select2.bundle.js'); ?>"></script>
    <script src="<?php echo base_url('/assets/js/exceljs.min.js'); ?>"></script>
    <script src="<?php echo base_url('/assets/js/FileSaver.min.js'); ?>"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js" integrity="sha512-UnrKxsCMN9hFk7M56t4I4ckB4N/2HHi0w/7+B/1JsXIX3DmyBcsGpT3/BsuZMZf+6mAr0vP81syWtfynHJ69JA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script><!-- comment -->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js" ></script><!-- comment -->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js" integrity="sha512-dlPw+ytv/6JyepmelABrgeYgHI0O+frEwgfnPdXDTOIZz+eDgfW07QXG02/O8COfivBdGNINy+Vex+lYmJ5rxw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>-->
    <script>

        class EasyHTTP {

            // Make an HTTP GET Request
            async get(url) {

                // Awaiting for fetch response
                const response = await fetch(url);

                // Awaiting for response.json()
                const resData = await response.json();

                // Returning result data
                return resData;
            }

            // Make an HTTP POST Request
            async post(url, data) {

                // Awaiting for fetch response and
                // defining method, headers and body
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                // Awaiting response.json()
                const resData = await response.json();

                // Returning result data
                return resData;
            }
        }

        $(document).bind("ajaxSend", function () {
            $('#loading').show();
        }).bind("ajaxComplete", function () {
            $("#loading").hide();
        });

        var lastday = function (y, m) {
            return  new Date(y, m, 0).getDate();
        }

        function addMonth(dateStart, month_interval) {
            var date = new Date(dateStart);
            date.setMonth(date.getMonth() + month_interval);
            return date;
        }

        const colorHeader = 'FF808080';
        const colorGrey1 = 'FFA9A9A9';
        const colorGrey2 = 'FFD3D3D3';
        const colorGrey3 = 'FFDEDEDE';
        const fontName = 'Arial';
        const formatNumber = '#,##0.00';
        const borderStyle = {top: {style: 'thin'}, left: {style: 'thin'}, bottom: {style: 'thin'}, right: {style: 'thin'}};
        function styleFont(cell, values, isNumber, fontSize, boldState, alignments = 'Left', borders = false, borderStyle = 'thin') {
            cell.value = values;
            if (isNumber) {
                cell.numFmt = formatNumber;
                cell.alignment = {vertical: 'middle', horizontal: 'right'};
            }
            if (alignments !== 'Left') {
                cell.alignment = {vertical: 'middle', horizontal: alignments};
            }
            cell.font = {name: fontName, size: fontSize, bold: boldState};
            if (borders) {
                cell.border = {top: {style: borderStyle}, left: {style: borderStyle}, bottom: {style: borderStyle}, right: {style: borderStyle}};
        }
        }
        function styleFontColor(cell, values, fgColors, isNumber, fontSize, boldState, alignments = 'Left', borders = false, borderStyle = 'thin') {
            cell.value = values;
            if (isNumber) {
                cell.numFmt = formatNumber;
                cell.alignment = {vertical: 'middle', horizontal: 'right'};
            }
            if (alignments !== 'Left') {
                cell.alignment = {vertical: 'middle', horizontal: alignments};
            }
            cell.font = {name: fontName, size: fontSize, bold: boldState};
            cell.fill = {type: 'pattern', pattern: 'solid', fgColor: {argb: fgColors}};
            if (borders) {
                cell.border = {top: {style: borderStyle}, left: {style: borderStyle}, bottom: {style: borderStyle}, right: {style: borderStyle}};
        }
        }

        var runDatePicker = function ()
        {
            $('#txtPeriodeEnd').datepicker({
                todayHighlight: true,
                todayBtn: "linked",
                format: 'yyyy-mm-dd',
                clearBtn: true,
                orientation: "top left",
                autoclose: true,
            });

        }
        function addSpinner() {
            //console.log('1');
            $("#btload").append('<span id="spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        }

        function isEmpty(str) {
            return (!str || str.length === 0);
        }

        function processExcell(id, pageNumber, rowsOfPage) {
            console.log(pageNumber);
            console.log(rowsOfPage);
            var data = {
                id: id,
                pageNumber: pageNumber,
                rowsOfPage: rowsOfPage
            }
            var url = '<?php echo base_url(custom_constants::running_modules . "/" . $parent . "/" . $child) . "/loaddatareport"; ?>';
            var http = new EasyHTTP;
            http.post(url, data)
                    // resolving promise for response data
                    .then(data => console.log(data))
                    // resolving promise for error
                    .catch(err => console.log(err));
        }

        $(document).ready(function ()
        {
            //console.log($('#cboSelector').val())
            $('#cboRegionName').select2();
            $('#cboBranchName').select2();
            $(function ()
            {
                // handler masking
                //$(":input").inputmask();
                // handler datepicker
                runDatePicker();
            });

            $("#cboReportType").on('change', function () {
                var rpttype = $(this).val();

                if (rpttype.slice(-1) == 'R') {
                    $('#cboRegionName').prop('disabled', false);
                    $('#cboRegionName').prop('required', true);
                    $('#cboRegionName').val('').change();
                    $('#cboBranchName').val('').change();
                    $('#cboBranchName').prop('disabled', true);
                    $('#cboBranchName').prop('required', false);
                } else {
                    $('#cboRegionName').prop('disabled', true);
                    $('#cboRegionName').prop('required', false);
                    $('#cboRegionName').val('').change();
                    $('#cboBranchName').val('').change();
                    $('#cboBranchName').prop('disabled', false);
                    $('#cboBranchName').prop('required', true);
                }

            });
            $("#cboCoverage").on('change', function (e) {
                var coverage = $(this).val();
                //console.log(todayStr);
                if (coverage == 'REGION') {
                    $("#cboBranchName").prop('disabled', true);
                    $("#cboBranchName").val('').change();
                } else {
                    $("#cboBranchName").prop('disabled', false);
                }
            });

            $(".js-data-branch-ajax").select2({
                ajax: {
                    placeholder: 'Type Store Name',
                    url: "<?php echo base_url(custom_constants::running_modules . "/" . $parent . "/" . $child . "/getstore"); ?>",
                    dataType: 'json',
                    type: "POST",
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            region: $(".js-data-region-ajax").val(),
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;
                        return {
                            results: data,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                placeholder: 'Search for a repository',
                escapeMarkup: function (markup) {
                    return markup;
                } // let our custom formatter work
                //minimumInputLength: 1
            });
            /*
             $(".js-data-account-ajax").select2({
             ajax:{
             placeholder: 'Type Account Name',
             url: "<?php echo base_url(custom_constants::running_modules . "/" . $parent . "/" . $child . "/getaccount"); ?>",
             dataType: 'json',
             type: "POST",
             delay: 250,
             data: function(params){
             return {
             q: params.term, // search term
             //region: $(".js-data-region-ajax").val(),
             };
             },
             processResults: function(data, params){
             // parse the results into the format expected by Select2
             // since we are using custom formatting functions we do not need to
             // alter the remote JSON data, except to indicate that infinite
             // scrolling can be used
             params.page = params.page || 1;
             return {
             results: data,
             pagination:{
             more: (params.page * 30) < data.total_count
             }
             };
             },
             cache: true
             },
             placeholder: 'Search for a repository',
             escapeMarkup: function(markup){
             return markup;
             } // let our custom formatter work
             //minimumInputLength: 1
             });*/

            $(".js-data-tenant-ajax").select2({
                ajax:
                        {
                            placeholder: 'Select Rekanan Maximum 2 Items',
                            url: "<?php echo base_url(custom_constants::running_modules . "/" . $parent . "/" . $child) . "/gettenant"; ?>",
                            dataType: 'json',
                            type: "GET",
                            delay: 250,
                            data: function (params) {
                                return {
                                    q: params.term, // search term
                                };
                            },
                            processResults: function (data, params) {
                                // parse the results into the format expected by Select2
                                // since we are using custom formatting functions we do not need to
                                // alter the remote JSON data, except to indicate that infinite
                                // scrolling can be used
                                params.page = params.page || 1;

                                return {
                                    results: data,
                                    pagination: {
                                        more: (params.page * 30) < data.total_count
                                    }
                                };
                            },
                            cache: true
                        },
                placeholder: 'Search for a repository',
                escapeMarkup: function (markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 2,
                maximumSelectionLength: 10,

            });
            $('#cboAccountName').select2({
                placeholder: 'Type Account Name',
                allowClear: true,
            });

            $("#chkPost").on('change', function (e) {
                if ($(this).prop("checked") == true) {
                    $(this).val(1);
                    //console.log('checkbox true');
                }
                if ($(this).prop("checked") == false) {
                    $(this).val(0);
                    //console.log('checkbox false');
                }
            });

            $('#btload').on('click', function (e) {
                addSpinner();
                setTimeout(() => {
                    $('#spinner').remove();
                }, 5000);
                //}
            });

            $('#btload2').on('click', function (e) {

                e.preventDefault();
                var types = $('#cboReportType').val();
                if (types == 'JSDTR') {
                    var id = '';
                    var num = 0;
                    var i = 1;
                    var rownumber = 4;
                    var pageNumber = 1;
                    var rowsOfPage = 100000;
                    var lastPage = 0;
                    var jsData = [];

                    $.ajax({
                        url: '<?php echo base_url(custom_constants::running_modules . "/" . $parent . "/" . $child) . "/generatedatareport"; ?>',
                        type: "POST",
                        dataType: "json",
                        data: {
                            //txtPeriodeStart: $('#txtPeriodeStart').val(),
                            txtPeriodeEnd: $('#txtPeriodeEnd').val(),
                            cboBranchName: $('#cboBranchName').val(),
                            cboRegionName: $('#cboRegionName').val(),
                            cboReportType: $('#cboReportType').val(),
                            cboAccountName: $('#cboAccountName').val(),
                            cboGroupAccount: $('#cboGroupAccount').val(),
                        },
                        cache: false,
                        timeout: 0,

                    }).then(function (data) {
                                //console.log(data);
                                id = data[0]['id'];
                                num = parseInt(data[0]['num']);

                                lastPage = Math.ceil(num / rowsOfPage);
                                //console.log(id,num,lastPage);
                                loadDataPartial(id, pageNumber, rowsOfPage, lastPage, jsData);

                            })

                } else {


                    $.ajax({
                        url: '<?php echo base_url(custom_constants::running_modules . "/" . $parent . "/" . $child) . "/getdatareport"; ?>',
                        //async: true,
                        type: "POST",
                        dataType: "json",
                        data: {
                            //txtPeriodeStart: $('#txtPeriodeStart').val(),
                            txtPeriodeEnd: $('#txtPeriodeEnd').val(),
                            cboBranchName: $('#cboBranchName').val(),
                            cboRegionName: $('#cboRegionName').val(),
                            cboReportType: $('#cboReportType').val(),
                            cboAccountName: $('#cboAccountName').val(),
                            cboGroupAccount: $('#cboGroupAccount').val(),
                        },
                        global: true,
                        timeout: 0,
                        success: function (data) {
                            const typerpt= types.substring(0,3);
                            switch (typerpt) {
                              	case "JSM":
                                    exportToExcelJSM(data);
                                    break;
                                case "JSS":
                                    exportToExcelJSS(data);
                                    break;
                                case "JSD":
                                    exportToExcelJSD(data);
                                    break;
                            }
                            
                        },

                    });

                }
            });



            $('#btload3').on('click', function (e) {
                e.preventDefault();

                var id = '';
                var num = 0;
                var i = 1;
                var rownumber = 4;
                var pageNumber = 1;
                var rowsOfPage = 100000;
                var lastPage = 0;
                var jsData = [];

                $.ajax({
                    url: '<?php echo base_url(custom_constants::running_modules . "/" . $parent . "/" . $child) . "/generatedatareport"; ?>',
                    type: "POST",
                    dataType: "json",
                    data: {
                        //txtPeriodeStart: $('#txtPeriodeStart').val(),
                        txtPeriodeEnd: $('#txtPeriodeEnd').val(),
                        cboBranchName: $('#cboBranchName').val(),
                        cboRegionName: $('#cboRegionName').val(),
                        cboReportType: $('#cboReportType').val(),
                        cboAccountName: $('#cboAccountName').val(),
                    },
                    cache: false,
                    timeout: 0,

                })
                        .then(function (data) {
                            console.log(data);
                            id = data[0]['id'];
                            num = parseInt(data[0]['num']);

                            lastPage = Math.ceil(num / rowsOfPage);
                            console.log(id, num, lastPage);


                            loadDataPartial(id, pageNumber, rowsOfPage, lastPage, jsData);



                        })

            });

            function loadDataPartial(id, pageNumber, rowsOfPage, lastPage, jsData) {

                if (pageNumber > lastPage) {
                        console.log('first-step');
                        $.post('<?php echo base_url(custom_constants::running_modules . "/" . $parent . "/" . $child) . "/getresult"; ?>')
                            .done(function (dt){
                                //console.log(jsData);
                                loadToExcel(jsData, id);
                        });
                        //console.log('finish-step');
                return $.Deferred().resolve().promise();

                                        
                }

                return $.post('<?php echo base_url(custom_constants::running_modules . "/" . $parent . "/" . $child) . "/loaddatareport"; ?>', {id: id, PageNumber: pageNumber, RowsOfPage: rowsOfPage})
                .done(function (data) {
                            console.log('page ' + pageNumber.toString());
                            //console.log(data);
                            jsData.push(data);

                            pageNumber += 1;


                })
                .fail(function (e) {
                // if a batch fails, say server returns 500,
                // do something here.
                            console.log(e);
                })
                .then(function () {
                            //alert(awal);
                return loadDataPartial(id, pageNumber, rowsOfPage, lastPage, jsData);
                });
            }

            function deleteDataReport(id) {
                //$.post('<?php echo base_url(custom_constants::running_modules . "/" . $parent . "/" . $child) . "/deletedatareport"; ?>', {id: id})
                $.ajax({
                    url: '<?php echo base_url(custom_constants::running_modules . "/" . $parent . "/" . $child) . "/deletedatareport"; ?>',
                    type: "POST",
                    dataType: "json",
                    data: {
                        id: id
                    },
                    global: true,
                    timeout: 0,
                    success: function (data) {
                        console.log(data);
                    }
                });

            }

            function loadToExcel(jsData, id) {
                txtPeriodeEnd = $('#txtPeriodeEnd').val()
                cboBranchName = $('#cboBranchName').val()
                cboRegionName = $('#cboRegionName').val()
                cboReportType = $('#cboReportType').val()

                title = $('#cboReportType option:selected').text();
                region = $('#cboRegionName option:selected').text();
                branch = $('#cboBranchName option:selected').text();

                const workbook = new ExcelJS.Workbook();
                workbook.creator = 'Phantom';
                workbook.lastModifiedBy = 'Phantom';
                workbook.created = new Date();
                workbook.modified = new Date();
                const worksheet = workbook.addWorksheet('Summary Jurnal Detil', {
                    pageSetup: {paperSize: 9, orientation: 'landscape'}
                });
                worksheet.columns = [
                    {key: 'Account1', width: 10},
                    {key: 'Account2', width: 20},
                    {key: 'Account3', width: 10},
                    {key: 'Account4', width: 10},
                    {key: 'Description', width: 40},
                    {key: 'SaldoAwal', width: 20},
                    {key: 'Debet', width: 20},
                    {key: 'Kredit', width: 20},
                    {key: 'Mutasi', width: 20},
                    {key: 'SaldoAkhir', width: 20},
                    {key: 'Account', width: 10},
                    {key: 'Region', width: 20},
                    {key: 'Branch', width: 20},
                    {key: 'StrukturUnit', width: 20},
                    {key: 'Rekanan', width: 20},
                ];

                cellTitle = worksheet.getCell('A1');
                styleFont(cellTitle, title, false, 13, true);
                if (cboReportType.substr(-1) == "R") {
                    cellTitle = worksheet.getCell('A2');
                    styleFont(cellTitle, "Region : " + region, false, 11, true);

                } else {
                    cellTitle = worksheet.getCell('A2');
                    styleFont(cellTitle, "Branch : " + branch, false, 11, true);

                }

                cellTitle = worksheet.getCell('A3');
                styleFont(cellTitle, "Date : " + txtPeriodeEnd, false, 11, true);


                worksheet.mergeCells('A4:E4');
                cellHeader = worksheet.getCell('A4');
                styleFontColor(cellHeader, 'Account', colorHeader, false, 10, true);
                //worksheet.mergeCells('D4:D5');
                cellHeader = worksheet.getCell('F4');
                styleFontColor(cellHeader, 'Saldo Awal', colorHeader, false, 10, true, 'center');
                //worksheet.mergeCells('E4:E5');
                cellHeader = worksheet.getCell('G4');
                styleFontColor(cellHeader, 'Debet', colorHeader, false, 10, true, 'center');
                //worksheet.mergeCells('F4:G4');
                styleFontColor(worksheet.getCell('H4'), 'Kredit', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('I4'), 'Mutasi', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('J4'), 'Saldo Akhir', colorHeader, false, 10, true, 'center');
                //worksheet.mergeCells('H4:I4');
                styleFontColor(worksheet.getCell('K4'), 'Account', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('L4'), 'Region', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('M4'), 'Branch', colorHeader, false, 10, true, 'center');
                //worksheet.mergeCells('J4:K4');
                styleFontColor(worksheet.getCell('N4'), 'Struktur Unit', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('O4'), 'Rekanan', colorHeader, false, 10, true, 'center');

                let rownumber = 4;
                //let rownum = 5;
                let i = 0;
                let account_current = "";

                let saldoawal_sumall = 0;
                let debet_sumall = 0;
                let kredit_sumall = 0;
                let mutasi_sumall = 0;
                let saldoakhir_sumall = 0;

                let saldoawal_sum = 0;
                let debet_sum = 0;
                let kredit_sum = 0;
                let mutasi_sum = 0;
                let saldoakhir_sum = 0;

                let saldoawal = 0;
                let debet = 0;
                let kredit = 0;
                let mutasi = 0;
                let saldoakhir = 0;
                //console.log(jsData);
                $.each(jsData, function (index, data) {
                    console.log(index);
                    dataku = JSON.parse(data);
                    $.each(dataku, function (index, row) {
                        //console.log(i);
                        var acc_id = row['acc_id'];
                        var acc_name = row['acc_name'];
                        var jurnal_id = row['jurnal_id'];
                        var jurnal_source = row['jurnal_source'];
                        var jurnal_bookdate = isEmpty(row['jurnal_bookdate']) ? '' : row['jurnal_bookdate'].substring(0, 10);
                        var jurnal_descr = row['jurnal_descr'];
                        var region = row['region_name'];
                        var branch = row['branch_name'];
                        var strukturunit = row['strukturunit_name'];
                        var rekanan = row['rekanan_name'];
                        var saldoawal = parseFloat(row['jurnalsaldoawal_idr']);
                        var debet = parseFloat(row['jurnalsaldodebet_idr']);
                        var kredit = -1 * parseFloat(row['jurnalsaldokredit_idr']);
                        var mutasi = parseFloat(row['jurnalsaldomutasi_idr']);
                        var saldoakhir = parseFloat(row['jurnalsaldoakhir_idr']);

                        if (account_current != acc_id && acc_id != '') {

                            if (account_current != '') {

                                i += 1;
                                worksheet.mergeCells('A' + (i + rownumber).toString() + ':E' + (i + rownumber).toString());
                                styleFontColor(worksheet.getCell('A' + (i + rownumber).toString()), "Total " + account_current, colorGrey2, false, 10, true);
                                styleFontColor(worksheet.getCell('F' + (i + rownumber).toString()), saldoawal_sum, colorGrey2, true, 10, true);
                                styleFontColor(worksheet.getCell('G' + (i + rownumber).toString()), debet_sum, colorGrey2, true, 10, true);
                                styleFontColor(worksheet.getCell('H' + (i + rownumber).toString()), kredit_sum, colorGrey2, true, 10, true);
                                styleFontColor(worksheet.getCell('I' + (i + rownumber).toString()), mutasi_sum, colorGrey2, true, 10, true);
                                styleFontColor(worksheet.getCell('J' + (i + rownumber).toString()), saldoakhir_sum, colorGrey2, true, 10, true);
                                styleFontColor(worksheet.getCell('K' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                                styleFontColor(worksheet.getCell('L' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                                styleFontColor(worksheet.getCell('M' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                                styleFontColor(worksheet.getCell('N' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                                styleFontColor(worksheet.getCell('O' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);

                            }

                            saldoawal_sum = 0;
                            debet_sum = 0;
                            kredit_sum = 0;
                            mutasi_sum = 0;
                            saldoakhir_sum = 0;

                            i += 2;
                            styleFontColor(worksheet.getCell('A' + (i + rownumber).toString()), acc_id, colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('B' + (i + rownumber).toString()), acc_name, colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('C' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('D' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('E' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('F' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('G' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('H' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('I' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('J' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('K' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('L' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('M' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('N' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('O' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                        }

                        i += 1;
                        styleFont(worksheet.getCell('B' + (i + rownumber).toString()), jurnal_id, false, 9, false);
                        styleFont(worksheet.getCell('C' + (i + rownumber).toString()), jurnal_bookdate, false, 9, false);
                        styleFont(worksheet.getCell('D' + (i + rownumber).toString()), jurnal_source, false, 9, false);
                        styleFont(worksheet.getCell('E' + (i + rownumber).toString()), jurnal_descr, false, 9, false);
                        styleFont(worksheet.getCell('F' + (i + rownumber).toString()), saldoawal, true, 9, false);
                        styleFont(worksheet.getCell('G' + (i + rownumber).toString()), debet, true, 9, false);
                        styleFont(worksheet.getCell('H' + (i + rownumber).toString()), kredit, true, 9, false);
                        styleFont(worksheet.getCell('I' + (i + rownumber).toString()), mutasi, true, 9, false);
                        styleFont(worksheet.getCell('J' + (i + rownumber).toString()), saldoakhir, true, 9, false);
                        styleFont(worksheet.getCell('K' + (i + rownumber).toString()), acc_id, false, 9, false);
                        styleFont(worksheet.getCell('L' + (i + rownumber).toString()), region, false, 9, false);
                        styleFont(worksheet.getCell('M' + (i + rownumber).toString()), branch, false, 9, false);
                        styleFont(worksheet.getCell('N' + (i + rownumber).toString()), strukturunit, false, 9, false);
                        styleFont(worksheet.getCell('O' + (i + rownumber).toString()), rekanan, false, 9, false);

                        account_current = acc_id;

                        saldoawal_sum += saldoawal;
                        debet_sum += debet;
                        kredit_sum += kredit;
                        mutasi_sum += mutasi;
                        saldoakhir_sum += saldoakhir;

                        saldoawal_sumall += saldoawal;
                        debet_sumall += debet;
                        kredit_sumall += kredit;
                        mutasi_sumall += mutasi;
                        saldoakhir_sumall += saldoakhir;


                    });
                });
                i += 1;
                worksheet.mergeCells('A' + (i + rownumber).toString() + ':E' + (i + rownumber).toString());
                styleFontColor(worksheet.getCell('A' + (i + rownumber).toString()), "Total " + account_current, colorGrey2, false, 10, true);
                styleFontColor(worksheet.getCell('F' + (i + rownumber).toString()), saldoawal_sum, colorGrey2, true, 10, true);
                styleFontColor(worksheet.getCell('G' + (i + rownumber).toString()), debet_sum, colorGrey2, true, 10, true);
                styleFontColor(worksheet.getCell('H' + (i + rownumber).toString()), kredit_sum, colorGrey2, true, 10, true);
                styleFontColor(worksheet.getCell('I' + (i + rownumber).toString()), mutasi_sum, colorGrey2, true, 10, true);
                styleFontColor(worksheet.getCell('J' + (i + rownumber).toString()), saldoakhir_sum, colorGrey2, true, 10, true);
                styleFontColor(worksheet.getCell('K' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                styleFontColor(worksheet.getCell('L' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                styleFontColor(worksheet.getCell('M' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                styleFontColor(worksheet.getCell('N' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                styleFontColor(worksheet.getCell('O' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);

                i += 1;
                worksheet.mergeCells('A' + (i + rownumber).toString() + ':E' + (i + rownumber).toString());
                styleFontColor(worksheet.getCell('A' + (i + rownumber).toString()), "Jumlah Total", colorHeader, false, 10, true);
                styleFontColor(worksheet.getCell('F' + (i + rownumber).toString()), saldoawal_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('G' + (i + rownumber).toString()), debet_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('H' + (i + rownumber).toString()), kredit_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('I' + (i + rownumber).toString()), mutasi_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('J' + (i + rownumber).toString()), saldoakhir_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('K' + (i + rownumber).toString()), "", colorHeader, false, 10, true);
                styleFontColor(worksheet.getCell('L' + (i + rownumber).toString()), "", colorHeader, false, 10, true);
                styleFontColor(worksheet.getCell('M' + (i + rownumber).toString()), "", colorHeader, false, 10, true);
                styleFontColor(worksheet.getCell('N' + (i + rownumber).toString()), "", colorHeader, false, 10, true);
                styleFontColor(worksheet.getCell('O' + (i + rownumber).toString()), "", colorHeader, false, 10, true);


                console.log('ok');

                workbook.xlsx.writeBuffer().then((data) => {
                    const blob = new Blob([data], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'});
                    saveAs(blob, 'Jurnal Summary Detil.xlsx');
                });

                deleteDataReport(id);

            }

            function exportToExcelJSD(data) {

                txtPeriodeEnd = $('#txtPeriodeEnd').val()
                cboBranchName = $('#cboBranchName').val()
                cboRegionName = $('#cboRegionName').val()
                cboReportType = $('#cboReportType').val()

                title = $('#cboReportType option:selected').text();
                region = $('#cboRegionName option:selected').text();
                branch = $('#cboBranchName option:selected').text();

                const workbook = new ExcelJS.Workbook();
                workbook.creator = 'Phantom';
                workbook.lastModifiedBy = 'Phantom';
                workbook.created = new Date();
                workbook.modified = new Date();
                const worksheet = workbook.addWorksheet('Summary Jurnal Detil', {
                    pageSetup: {paperSize: 9, orientation: 'landscape'}
                });
                worksheet.columns = [
                    {key: 'Account1', width: 10},
                    {key: 'Account2', width: 20},
                    {key: 'Account3', width: 10},
                    {key: 'Account4', width: 10},
                    {key: 'Description', width: 40},
                    {key: 'SaldoAwal', width: 20},
                    {key: 'Debet', width: 20},
                    {key: 'Kredit', width: 20},
                    {key: 'Mutasi', width: 20},
                    {key: 'SaldoAkhir', width: 20},
                    {key: 'Account', width: 10},
                    {key: 'Region', width: 20},
                    {key: 'Branch', width: 20},
                    {key: 'StrukturUnit', width: 20},
                    {key: 'Rekanan', width: 20},
                ];

                cellTitle = worksheet.getCell('A1');
                styleFont(cellTitle, title, false, 13, true);
                if (cboReportType.substr(-1) == "R") {
                    cellTitle = worksheet.getCell('A2');
                    styleFont(cellTitle, "Region : " + region, false, 11, true);

                } else {
                    cellTitle = worksheet.getCell('A2');
                    styleFont(cellTitle, "Branch : " + branch, false, 11, true);

                }

                cellTitle = worksheet.getCell('A3');
                styleFont(cellTitle, "Date : " + txtPeriodeEnd, false, 11, true);


                worksheet.mergeCells('A4:E4');
                cellHeader = worksheet.getCell('A4');
                styleFontColor(cellHeader, 'Account', colorHeader, false, 10, true);
                //worksheet.mergeCells('D4:D5');
                cellHeader = worksheet.getCell('F4');
                styleFontColor(cellHeader, 'Saldo Awal', colorHeader, false, 10, true, 'center');
                //worksheet.mergeCells('E4:E5');
                cellHeader = worksheet.getCell('G4');
                styleFontColor(cellHeader, 'Debet', colorHeader, false, 10, true, 'center');
                //worksheet.mergeCells('F4:G4');
                styleFontColor(worksheet.getCell('H4'), 'Kredit', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('I4'), 'Mutasi', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('J4'), 'Saldo Akhir', colorHeader, false, 10, true, 'center');
                //worksheet.mergeCells('H4:I4');
                styleFontColor(worksheet.getCell('K4'), 'Account', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('L4'), 'Region', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('M4'), 'Branch', colorHeader, false, 10, true, 'center');
                //worksheet.mergeCells('J4:K4');
                styleFontColor(worksheet.getCell('N4'), 'Struktur Unit', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('O4'), 'Rekanan', colorHeader, false, 10, true, 'center');

                let rownumber = 4;
                //let rownum = 5;
                let i = 0;
                let account_current = "";

                let saldoawal_sumall = 0;
                let debet_sumall = 0;
                let kredit_sumall = 0;
                let mutasi_sumall = 0;
                let saldoakhir_sumall = 0;

                let saldoawal_sum = 0;
                let debet_sum = 0;
                let kredit_sum = 0;
                let mutasi_sum = 0;
                let saldoakhir_sum = 0;

                let saldoawal = 0;
                let debet = 0;
                let kredit = 0;
                let mutasi = 0;
                let saldoakhir = 0;

                $.each(data, function (index, row) {
                    var acc_id = row['acc_id'];
                    var acc_name = row['acc_name'];
                    var jurnal_id = row['jurnal_id'];
                    var jurnal_source = row['jurnal_source'];
                    var jurnal_bookdate = isEmpty(row['jurnal_bookdate']) ? '' : row['jurnal_bookdate'].substring(0, 10);
                    var jurnal_descr = row['jurnal_descr'];
                    var region = row['region_name'];
                    var branch = row['branch_name'];
                    var strukturunit = row['strukturunit_name'];
                    var rekanan = row['rekanan_name'];
                    var saldoawal = parseFloat(row['jurnalsaldoawal_idr']);
                    var debet = parseFloat(row['jurnalsaldodebet_idr']);
                    var kredit = -1 * parseFloat(row['jurnalsaldokredit_idr']);
                    var mutasi = parseFloat(row['jurnalsaldomutasi_idr']);
                    var saldoakhir = parseFloat(row['jurnalsaldoakhir_idr']);

                    if (account_current != acc_id && acc_id != '') {

                        if (account_current != '') {

                            i += 1;
                            worksheet.mergeCells('A' + (i + rownumber).toString() + ':E' + (i + rownumber).toString());
                            styleFontColor(worksheet.getCell('A' + (i + rownumber).toString()), "Total " + account_current, colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('F' + (i + rownumber).toString()), saldoawal_sum, colorGrey2, true, 10, true);
                            styleFontColor(worksheet.getCell('G' + (i + rownumber).toString()), debet_sum, colorGrey2, true, 10, true);
                            styleFontColor(worksheet.getCell('H' + (i + rownumber).toString()), kredit_sum, colorGrey2, true, 10, true);
                            styleFontColor(worksheet.getCell('I' + (i + rownumber).toString()), mutasi_sum, colorGrey2, true, 10, true);
                            styleFontColor(worksheet.getCell('J' + (i + rownumber).toString()), saldoakhir_sum, colorGrey2, true, 10, true);
                            styleFontColor(worksheet.getCell('K' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('L' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('M' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('N' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('O' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);

                        }

                        saldoawal_sum = 0;
                        debet_sum = 0;
                        kredit_sum = 0;
                        mutasi_sum = 0;
                        saldoakhir_sum = 0;

                        i += 2;
                        styleFontColor(worksheet.getCell('A' + (i + rownumber).toString()), acc_id, colorGrey2, false, 10, true);
                        styleFontColor(worksheet.getCell('B' + (i + rownumber).toString()), acc_name, colorGrey2, false, 10, true);
                        styleFontColor(worksheet.getCell('C' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                        styleFontColor(worksheet.getCell('D' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                        styleFontColor(worksheet.getCell('E' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                        styleFontColor(worksheet.getCell('F' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                        styleFontColor(worksheet.getCell('G' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                        styleFontColor(worksheet.getCell('H' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                        styleFontColor(worksheet.getCell('I' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                        styleFontColor(worksheet.getCell('J' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                        styleFontColor(worksheet.getCell('K' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                        styleFontColor(worksheet.getCell('L' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                        styleFontColor(worksheet.getCell('M' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                        styleFontColor(worksheet.getCell('N' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                        styleFontColor(worksheet.getCell('O' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                    }

                    i += 1;
                    styleFont(worksheet.getCell('B' + (i + rownumber).toString()), jurnal_id, false, 9, false);
                    styleFont(worksheet.getCell('C' + (i + rownumber).toString()), jurnal_bookdate, false, 9, false);
                    styleFont(worksheet.getCell('D' + (i + rownumber).toString()), jurnal_source, false, 9, false);
                    styleFont(worksheet.getCell('E' + (i + rownumber).toString()), jurnal_descr, false, 9, false);
                    styleFont(worksheet.getCell('F' + (i + rownumber).toString()), saldoawal, true, 9, false);
                    styleFont(worksheet.getCell('G' + (i + rownumber).toString()), debet, true, 9, false);
                    styleFont(worksheet.getCell('H' + (i + rownumber).toString()), kredit, true, 9, false);
                    styleFont(worksheet.getCell('I' + (i + rownumber).toString()), mutasi, true, 9, false);
                    styleFont(worksheet.getCell('J' + (i + rownumber).toString()), saldoakhir, true, 9, false);
                    styleFont(worksheet.getCell('K' + (i + rownumber).toString()), acc_id, false, 9, false);
                    styleFont(worksheet.getCell('L' + (i + rownumber).toString()), region, false, 9, false);
                    styleFont(worksheet.getCell('M' + (i + rownumber).toString()), branch, false, 9, false);
                    styleFont(worksheet.getCell('N' + (i + rownumber).toString()), strukturunit, false, 9, false);
                    styleFont(worksheet.getCell('O' + (i + rownumber).toString()), rekanan, false, 9, false);

                    account_current = acc_id;

                    saldoawal_sum += saldoawal;
                    debet_sum += debet;
                    kredit_sum += kredit;
                    mutasi_sum += mutasi;
                    saldoakhir_sum += saldoakhir;

                    saldoawal_sumall += saldoawal;
                    debet_sumall += debet;
                    kredit_sumall += kredit;
                    mutasi_sumall += mutasi;
                    saldoakhir_sumall += saldoakhir;


                });

                i += 1;
                worksheet.mergeCells('A' + (i + rownumber).toString() + ':E' + (i + rownumber).toString());
                styleFontColor(worksheet.getCell('A' + (i + rownumber).toString()), "Total " + account_current, colorGrey2, false, 10, true);
                styleFontColor(worksheet.getCell('F' + (i + rownumber).toString()), saldoawal_sum, colorGrey2, true, 10, true);
                styleFontColor(worksheet.getCell('G' + (i + rownumber).toString()), debet_sum, colorGrey2, true, 10, true);
                styleFontColor(worksheet.getCell('H' + (i + rownumber).toString()), kredit_sum, colorGrey2, true, 10, true);
                styleFontColor(worksheet.getCell('I' + (i + rownumber).toString()), mutasi_sum, colorGrey2, true, 10, true);
                styleFontColor(worksheet.getCell('J' + (i + rownumber).toString()), saldoakhir_sum, colorGrey2, true, 10, true);
                styleFontColor(worksheet.getCell('K' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                styleFontColor(worksheet.getCell('L' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                styleFontColor(worksheet.getCell('M' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                styleFontColor(worksheet.getCell('N' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);
                styleFontColor(worksheet.getCell('O' + (i + rownumber).toString()), "", colorGrey2, false, 10, true);

                i += 1;
                worksheet.mergeCells('A' + (i + rownumber).toString() + ':E' + (i + rownumber).toString());
                styleFontColor(worksheet.getCell('A' + (i + rownumber).toString()), "Jumlah Total", colorHeader, false, 10, true);
                styleFontColor(worksheet.getCell('F' + (i + rownumber).toString()), saldoawal_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('G' + (i + rownumber).toString()), debet_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('H' + (i + rownumber).toString()), kredit_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('I' + (i + rownumber).toString()), mutasi_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('J' + (i + rownumber).toString()), saldoakhir_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('K' + (i + rownumber).toString()), "", colorHeader, false, 10, true);
                styleFontColor(worksheet.getCell('L' + (i + rownumber).toString()), "", colorHeader, false, 10, true);
                styleFontColor(worksheet.getCell('M' + (i + rownumber).toString()), "", colorHeader, false, 10, true);
                styleFontColor(worksheet.getCell('N' + (i + rownumber).toString()), "", colorHeader, false, 10, true);
                styleFontColor(worksheet.getCell('O' + (i + rownumber).toString()), "", colorHeader, false, 10, true);

                workbook.xlsx.writeBuffer().then((data) => {
                    const blob = new Blob([data], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'});
                    saveAs(blob, 'Jurnal Summary Detil.xlsx');
                });
            }

            function exportToExcelJSM(data) {

                txtPeriodeEnd = $('#txtPeriodeEnd').val()
                cboBranchName = $('#cboBranchName').val()
                cboRegionName = $('#cboRegionName').val()
                cboReportType = $('#cboReportType').val()

                title = $('#cboReportType option:selected').text();
                region = $('#cboRegionName option:selected').text();
                branch = $('#cboBranchName option:selected').text();

                const workbook = new ExcelJS.Workbook();
                workbook.creator = 'Phantom';
                workbook.lastModifiedBy = 'Phantom';
                workbook.created = new Date();
                workbook.modified = new Date();
                const worksheet = workbook.addWorksheet('Summary Jurnal', {
                    pageSetup: {paperSize: 9, orientation: 'landscape'}
                });
                worksheet.columns = [
                    {key: 'Account1', width: 10},
                    {key: 'Description', width: 40},
                    {key: 'SaldoAwal', width: 20},
                    {key: 'Debet', width: 20},
                    {key: 'Kredit', width: 20},
                    {key: 'Mutasi', width: 20},
                    {key: 'SaldoAkhir', width: 20},
                ];

                cellTitle = worksheet.getCell('A1');
                styleFont(cellTitle, title, false, 13, true);
                if (cboReportType.substr(-1) == "R") {
                    cellTitle = worksheet.getCell('A2');
                    styleFont(cellTitle, "Region : " + region, false, 11, true);

                } else {
                    cellTitle = worksheet.getCell('A2');
                    styleFont(cellTitle, "Branch : " + branch, false, 11, true);

                }

                cellTitle = worksheet.getCell('A3');
                styleFont(cellTitle, "Date : " + txtPeriodeEnd, false, 11, true);


                styleFontColor(worksheet.getCell('A4'), 'Account', colorHeader, false, 10, true);
                styleFontColor(worksheet.getCell('B4'), 'Description', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('C4'), 'Saldo Awal', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('D4'), 'Debet', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('E4'), 'Kredit', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('F4'), 'Mutasi', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('G4'), 'Saldo Akhir', colorHeader, false, 10, true, 'center');

                let rownumber = 4;
                //let rownum = 5;
                let i = 0;
                let account_current = "";

                let saldoawal_sumall = 0;
                let debet_sumall = 0;
                let kredit_sumall = 0;
                let mutasi_sumall = 0;
                let saldoakhir_sumall = 0;

                //let saldoawal_sum = 0;
                //let debet_sum = 0;
                //let kredit_sum = 0;
                //let mutasi_sum = 0;
                //let saldoakhir_sum = 0;

                let saldoawal = 0;
                let debet = 0;
                let kredit = 0;
                let mutasi = 0;
                let saldoakhir = 0;

                $.each(data, function (index, row) {
                    var acc_id = row['acc_id'];
                    var acc_name = row['acc_name'];
                    var jurnal_id = row['jurnal_id'];
                    var jurnal_source = row['jurnal_source'];
                    var jurnal_bookdate = isEmpty(row['jurnal_bookdate']) ? '' : row['jurnal_bookdate'].substring(0, 10);
                    var jurnal_descr = row['jurnal_descr'];
                    var region = row['region_name'];
                    var branch = row['branch_name'];
                    var strukturunit = row['strukturunit_name'];
                    var rekanan = row['rekanan_name'];
                    var saldoawal = parseFloat(row['jurnalsaldoawal_idr']);
                    var debet = parseFloat(row['jurnalsaldodebet_idr']);
                    var kredit = -1 * parseFloat(row['jurnalsaldokredit_idr']);
                    var mutasi = parseFloat(row['jurnalsaldomutasi_idr']);
                    var saldoakhir = parseFloat(row['jurnalsaldoakhir_idr']);

                    i += 1;
                    styleFont(worksheet.getCell('A' + (i + rownumber).toString()), acc_id, false, 9, false);
                    styleFont(worksheet.getCell('B' + (i + rownumber).toString()), acc_name, false, 9, false);
                    styleFont(worksheet.getCell('C' + (i + rownumber).toString()), saldoawal, true, 9, false);
                    styleFont(worksheet.getCell('D' + (i + rownumber).toString()), debet, true, 9, false);
                    styleFont(worksheet.getCell('E' + (i + rownumber).toString()), kredit, true, 9, false);
                    styleFont(worksheet.getCell('F' + (i + rownumber).toString()), mutasi, true, 9, false);
                    styleFont(worksheet.getCell('G' + (i + rownumber).toString()), saldoakhir, true, 9, false);

                    saldoawal_sumall += saldoawal;
                    debet_sumall += debet;
                    kredit_sumall += kredit;
                    mutasi_sumall += mutasi;
                    saldoakhir_sumall += saldoakhir;


                });

                i += 1;
                worksheet.mergeCells('A' + (i + rownumber).toString() + ':B' + (i + rownumber).toString());
                styleFontColor(worksheet.getCell('A' + (i + rownumber).toString()), "Jumlah Total", colorHeader, false, 10, true);
                styleFontColor(worksheet.getCell('C' + (i + rownumber).toString()), saldoawal_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('D' + (i + rownumber).toString()), debet_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('E' + (i + rownumber).toString()), kredit_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('F' + (i + rownumber).toString()), mutasi_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('G' + (i + rownumber).toString()), saldoakhir_sumall, colorHeader, true, 10, true);

                workbook.xlsx.writeBuffer().then((data) => {
                    const blob = new Blob([data], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'});
                    saveAs(blob, 'Jurnal Summary.xlsx');
                });
            }

            function exportToExcelJSS(data) {

                txtPeriodeEnd = $('#txtPeriodeEnd').val()
                cboBranchName = $('#cboBranchName').val()
                cboRegionName = $('#cboRegionName').val()
                cboReportType = $('#cboReportType').val()

                title = $('#cboReportType option:selected').text();
                region = $('#cboRegionName option:selected').text();
                branch = $('#cboBranchName option:selected').text();

                const workbook = new ExcelJS.Workbook();
                workbook.creator = 'Phantom';
                workbook.lastModifiedBy = 'Phantom';
                workbook.created = new Date();
                workbook.modified = new Date();
                const worksheet = workbook.addWorksheet('SubSummary Jurnal', {
                    pageSetup: {paperSize: 9, orientation: 'landscape'}
                });
                worksheet.columns = [
                    {key: 'Account1', width: 10},
                    {key: 'Account2', width: 5},
                    {key: 'Description', width: 40},
                    {key: 'SaldoAwal', width: 20},
                    {key: 'Debet', width: 20},
                    {key: 'Kredit', width: 20},
                    {key: 'Mutasi', width: 20},
                    {key: 'SaldoAkhir', width: 20},
                ];

                cellTitle = worksheet.getCell('A1');
                styleFont(cellTitle, title, false, 13, true);
                if (cboReportType.substr(-1) == "R") {
                    cellTitle = worksheet.getCell('A2');
                    styleFont(cellTitle, "Region : " + region, false, 11, true);
                } else {
                    cellTitle = worksheet.getCell('A2');
                    styleFont(cellTitle, "Branch : " + branch, false, 11, true);
                }

                cellTitle = worksheet.getCell('A3');
                styleFont(cellTitle, "Date : " + txtPeriodeEnd, false, 11, true);


                worksheet.mergeCells('A4:B4');
                styleFontColor(worksheet.getCell('A4'), 'Account', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('C4'), 'Description', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('D4'), 'Saldo Awal', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('E4'), 'Debit', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('F4'), 'Kredit', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('G4'), 'Mutasi', colorHeader, false, 10, true, 'center');
                styleFontColor(worksheet.getCell('H4'), 'Saldo Akhir', colorHeader, false, 10, true, 'center');

                let rownumber = 4;
                //let rownum = 5;
                let i = 0;
                let account_current = "";

                let saldoawal_sumall = 0;
                let debet_sumall = 0;
                let kredit_sumall = 0;
                let mutasi_sumall = 0;
                let saldoakhir_sumall = 0;

                let saldoawal_sum = 0;
                let debet_sum = 0;
                let kredit_sum = 0;
                let mutasi_sum = 0;
                let saldoakhir_sum = 0;

                let saldoawal = 0;
                let debet = 0;
                let kredit = 0;
                let mutasi = 0;
                let saldoakhir = 0;

                $.each(data, function (index, row) {
                    var acc_id = row['acc_id'];
                    var acc_name = row['acc_name'];
                    var jurnal_id = row['jurnal_id'];
                    var jurnal_source = row['jurnal_source'];
                    var jurnal_bookdate = isEmpty(row['jurnal_bookdate']) ? '' : row['jurnal_bookdate'].substring(0, 10);
                    var jurnal_descr = row['jurnal_descr'];
                    var region = row['region_name'];
                    var branch = row['branch_name'];
                    var strukturunit = row['strukturunit_name'];
                    var rekanan = row['rekanan_name'];
                    var saldoawal = parseFloat(row['jurnalsaldoawal_idr']);
                    var debet = parseFloat(row['jurnalsaldodebet_idr']);
                    var kredit = -1 * parseFloat(row['jurnalsaldokredit_idr']);
                    var mutasi = parseFloat(row['jurnalsaldomutasi_idr']);
                    var saldoakhir = parseFloat(row['jurnalsaldoakhir_idr']);

                    if (account_current != acc_id && acc_id != '') {

                        if (account_current != '') {

                            i += 1;
                            worksheet.mergeCells('A' + (i + rownumber).toString() + ':C' + (i + rownumber).toString());
                            styleFontColor(worksheet.getCell('A' + (i + rownumber).toString()), "Total " + account_current, colorGrey2, false, 10, true);
                            styleFontColor(worksheet.getCell('D' + (i + rownumber).toString()), saldoawal_sum, colorGrey2, true, 10, true);
                            styleFontColor(worksheet.getCell('E' + (i + rownumber).toString()), debet_sum, colorGrey2, true, 10, true);
                            styleFontColor(worksheet.getCell('F' + (i + rownumber).toString()), kredit_sum, colorGrey2, true, 10, true);
                            styleFontColor(worksheet.getCell('G' + (i + rownumber).toString()), mutasi_sum, colorGrey2, true, 10, true);
                            styleFontColor(worksheet.getCell('H' + (i + rownumber).toString()), saldoakhir_sum, colorGrey2, true, 10, true);

                        }

                        saldoawal_sum = 0;
                        debet_sum = 0;
                        kredit_sum = 0;
                        mutasi_sum = 0;
                        saldoakhir_sum = 0;

                        i += 2;
                        worksheet.mergeCells('B' + (i + rownumber).toString() + ':H' + (i + rownumber).toString());
                        styleFontColor(worksheet.getCell('A' + (i + rownumber).toString()), acc_id, colorGrey2, false, 10, true);
                        styleFontColor(worksheet.getCell('B' + (i + rownumber).toString()), acc_name, colorGrey2, false, 10, true);
                    }

                    i += 1;
                    //styleFont(worksheet.getCell('A' + (i + rownumber).toString()), acc_id, false, 9, false);
                    styleFont(worksheet.getCell('C' + (i + rownumber).toString()), rekanan, false, 9, false);
                    styleFont(worksheet.getCell('D' + (i + rownumber).toString()), saldoawal, true, 9, false);
                    styleFont(worksheet.getCell('E' + (i + rownumber).toString()), debet, true, 9, false);
                    styleFont(worksheet.getCell('F' + (i + rownumber).toString()), kredit, true, 9, false);
                    styleFont(worksheet.getCell('G' + (i + rownumber).toString()), mutasi, true, 9, false);
                    styleFont(worksheet.getCell('H' + (i + rownumber).toString()), saldoakhir, true, 9, false);

                    account_current = acc_id;

                    saldoawal_sum += saldoawal;
                    debet_sum += debet;
                    kredit_sum += kredit;
                    mutasi_sum += mutasi;
                    saldoakhir_sum += saldoakhir;

                    saldoawal_sumall += saldoawal;
                    debet_sumall += debet;
                    kredit_sumall += kredit;
                    mutasi_sumall += mutasi;
                    saldoakhir_sumall += saldoakhir;


                });

                i += 1;
                worksheet.mergeCells('A' + (i + rownumber).toString() + ':C' + (i + rownumber).toString());
                styleFontColor(worksheet.getCell('A' + (i + rownumber).toString()), "Total " + account_current, colorGrey2, false, 10, true);
                styleFontColor(worksheet.getCell('D' + (i + rownumber).toString()), saldoawal_sum, colorGrey2, true, 10, true);
                styleFontColor(worksheet.getCell('E' + (i + rownumber).toString()), debet_sum, colorGrey2, true, 10, true);
                styleFontColor(worksheet.getCell('F' + (i + rownumber).toString()), kredit_sum, colorGrey2, true, 10, true);
                styleFontColor(worksheet.getCell('G' + (i + rownumber).toString()), mutasi_sum, colorGrey2, true, 10, true);
                styleFontColor(worksheet.getCell('H' + (i + rownumber).toString()), saldoakhir_sum, colorGrey2, true, 10, true);

                i += 2;
                worksheet.mergeCells('A' + (i + rownumber).toString() + ':C' + (i + rownumber).toString());
                styleFontColor(worksheet.getCell('A' + (i + rownumber).toString()), "Jumlah Total", colorHeader, false, 10, true);
                styleFontColor(worksheet.getCell('D' + (i + rownumber).toString()), saldoawal_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('E' + (i + rownumber).toString()), debet_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('F' + (i + rownumber).toString()), kredit_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('G' + (i + rownumber).toString()), mutasi_sumall, colorHeader, true, 10, true);
                styleFontColor(worksheet.getCell('H' + (i + rownumber).toString()), saldoakhir_sumall, colorHeader, true, 10, true);

                workbook.xlsx.writeBuffer().then((data) => {
                    const blob = new Blob([data], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'});
                    saveAs(blob, 'Jurnal SubSummary.xlsx');
                });
            }



            data = '<?php echo isset($err_message) ? $err_message : ''; ?>';
            if (data != '') {
                bootbox.alert(
                        {
                            title: "<h3><strong>Saved Massage</strong></h3>",
                            message: '<h4><span class="text-danger">' + data + '</span></h4>',
                            size: 'medium'
                        })
            }




        });

    </script>

    <?php
}
?>
