<?php $chid=get_setting("channel_id");?>
<script>

  $(document).ready(function(){  
    
    $.fn.modal.Constructor.prototype.enforceFocus = $.noop;

    //caluptotal();
    $('#frmJurnal').on('submit', function(e) {
      //var ttotamount=$("#jumlah_idr").val();		
      let submitButton = e.originalEvent.submitter;
      let btnName = $(submitButton).attr('name');
      var jurnal_id = $('#jurnal_id').val();
      var period = $('#iperiod').val();
      var bookdateInput = $('#jurnal_bookdate').val().split('-');
      var periodeInputCheck = bookdateInput[0].substring(4,2)+bookdateInput[1];
      var balance = $('.balance').text();
      balance = balance.replace(/[\$,]/g, '');

      if (btnName=='delete') {
        if (confirm(`Are you sure to delete journal ${jurnal_id} ?`) == false) {
          return false;
        }
      } else {
          
        if("'"+period+"'" !== "'"+periodeInputCheck+"'") {
          handleAlert('Periode Berbeda Dengan Bookdate!');
          return false;
        }

        if (parseFloat(balance) !== 0) {
          handleAlert('Nilai Jurnal belum balance.');    
          return false;
        }      

        if($('#book_date').val() == ''){
          handleAlert('Book Date Belum Di masukkan');
          return false;
        }
      }

    });

    $(document).on("focusin", "#itenant", function() {
      $(this).prop('readonly', true);  
    });

    $(document).on("focusout", "#itenant", function() {
      $(this).prop('readonly', false); 
    });


    $('#iregion').select2({placeholder: 'Select a business unit'});
    $('#iutype').select2({placeholder: 'Choose unit ..'});
    $('#istruk').select2({placeholder: 'Choose strukturunit ..'});
    $('#iperiod').select2();
    //$('#iperiod').prop('disabled', true);
    $('.region-sel').select2();
    $('.branch-sel').select2();
    $('.struktur-sel').select2();

    $('.account').select2({
      dropdownCssClass: 'dropdown-store',
      tokenSeparators: [',', ' '],
      minimumInputLength: 2,
      minimumResultsForSearch: 10,
      allowClear: true,
      placeholder: 'Choose an Account ..',
    });

    $('.account').on('select2:open', function(e){
      $('.dropdown-store').parent().css('z-index', 99999);
    }); 

    $('#pnl_edit-cbo_strukturunit_id').select2({
      dropdownCssClass: 'dropdown-store',
      tokenSeparators: [',', ' '],
      //minimumInputLength: 2,
      minimumResultsForSearch: 10,
      //allowClear: true,
      placeholder: 'Choose a Struktur Unit',
    });

    $('#pnl_edit-cbo_strukturunit_id').on('select2:open', function(e){
      $('.dropdown-store').parent().css('z-index', 99999);
    });

    $('#ibranch').on('select2:select', function (e) {
      var bra = e.params.data;    

      $('#iregion').val(bra.region).trigger('change');      

      $('#cboregion').val(bra.region);  

      listunit = branchData.filter(function (data) { return data.branch == bra.id });   
          
    });  


    $('#ibranch').select2({
        placeholder: 'Select an option',
        minimumInputLength: 2,
        //tags: true,
        minimumResultsForSearch: 10,
        tokenSeparators: [',', ' '],
        ajax: {
            url: '<?php echo site_url('jvoucher2/jvoucher2/branch_select')?>',
            dataType: 'json',
            type: "POST",
            data: function (term) {
                return {
                  term: term,
                  region: $('#iregion').val()               
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.items, function (item) {

                          //console.log(data.items);
                        return {

                            text: item.branch_name,
                            region: item.region_id,
                            id: item.branch_id
                        }
                    })
                };
            }
        }
    });


    $('#pnl_edit-cbo_branch_id').on('select2:open', function(e){
      $('.dropdown-store').parent().css('z-index', 99999);
    });

    $('#pnl_edit-cbo_branch_id').select2({
        dropdownCssClass: 'dropdown-store',
        placeholder: 'Select an option',
        minimumInputLength: 2,
        //tags: true,
        minimumResultsForSearch: 10,
        tokenSeparators: [',', ' '],
        ajax: {
            url: '<?php echo site_url('jvoucher2/jvoucher2/branch_select')?>',
            dataType: 'json',
            type: "POST",
            data: function (term) {
                return {
                  term: term,
                  region: $('#iregion').val()  
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.items, function (item) {

                          //console.log(data.items);
                        return {

                            text: item.branch_name,
                            region: item.region_id,
                            id: item.branch_id
                        }
                    })
                };
            }
        }
    });

    $("#itenant").on('keydown paste', function(e){
        e.preventDefault();
    });

    $("#idebtor").on('keydown paste', function(e){
      e.preventDefault();
    });

    var tenantParams = { 
      line: 0,
      branch_id: $('#ibranch'),
      criteria: $('#searchTenant')
    } 
    
    let $lastPopOver = null;
    let jurnalDetilRows = [];
    let jurnalDetilDeleted = [];
    var $popoverTenant = $('#popover_tenant');
    var tenantTable = handleTenantTable("table_tenant", tenantParams);
    var tblJournalDetil = handleJournalDetil();

    /*
    tblJournalDetil.on('dblclick', 'tr', function () {

      let data = tblJournalDetil.row(this).data();
      var trId = data.rowid;
      var form = document.getElementById("frmJurnalDetil");
      let formId = form.setAttribute("formid", trId);

      tblJournalDetil.row(`#${trId}`).select();
      //console.log(tblJournalDetil.row(`#${trId}`).data());

      $.blockUI({message: 'Opening Data, Please Wait...'});

      setTimeout( ()=> {

        $('#pnl_edit-txt_jurnaldetil_line').val(data.jurnaldetil_line);
        $('#pnl_edit-txt_jurnaldetil_descr').val(data.jurnaldetil_descr);
        $('#pnl_edit-txt_jurnaldetil_idr').val(data.jurnaldetil_idr);
        $('#pnl_edit-txt_rekanan_id').val(data.rekanan_id);
        $('#pnl_edit-txt_rekanan_name').val(data.rekanan_name);
        $('#pnl_edit-txt_rekananshipping_line').val(data.rekananshipping_line);
        $('#pnl_edit-txt_rekananshipping_name').val(data.rekananshipping_name);
        $('#pnl_edit-cbo_acc_id').val(data.acc_id).trigger('change');
        $('#pnl_edit-cbo_branch_id').val(data.branch_id).trigger('change');
        $('#pnl_edit-cbo_strukturunit_id').val(data.strukturunit_id).trigger('change');
        
        $("#dlgDetail .modal-title").show().html('Edit Row');
        $("#dlgDetail").modal("show"); 
        //$('#rowDetail').collapse('show');
        $.unblockUI();
      }, 100);

    });
    */

    var $deletePopOver = null;    
    var popOpts = {
      placement: 'right',
      title: 'Delete Item',
      html: true,
      content: `
        Are you sure you want to delete this item?<br>
        <button class="btn btn-danger popover-submit" type="button" name="yes">
          <i class="fa fa-check"></i> Yes
        </button>
        <button class="btn btn-default" type="button"><i class="fa fa-close"></i> No</button>`
    };

    tblJournalDetil.on('click', 'a.delete', function (e) {

      e.preventDefault(); // Mencegah default action

      // Inisialisasi popover untuk elemen yang diklik
      var $delete = $(this);
      if ($deletePopOver != null) $delete.popover('destroy').popover(popOpts);  
      $delete.popover(popOpts).popover('show');

      // Event handler saat popover sudah ditampilkan
      $delete.on('shown.bs.popover', function () {
          var $form = $delete.closest('form');
          var $pop = $form.find('.popover');
          $deletePopOver = $delete;

          // Menangani klik pada tombol dalam popover
          $pop.find('button').click(function () {
              if ($(this).is('.popover-submit')) {
                  
                $.blockUI({message: 'Removing Data, Please Wait...'});

                let row = tblJournalDetil.row($delete.parents('tr'));
                let datarow = row.data();

                setTimeout( ()=> {
                  jurnalDetilDeleted.push(datarow);
                  $('#row_jurnaldeleted').val( JSON.stringify({ jurnalDetilDeleted }) );
                  row.remove().draw();
                  $.unblockUI();
                }, 100);
                //console.log(row.data());
              }
              //$delete.popover('hide');
              $delete.popover('destroy').popover(popOpts);  
          });
      });


      $('body').on('click', function (e) {
          $('[data-toggle=popover]').each(function () {
              // hide any open popovers when the anywhere else in the body is clicked
              if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                  $(this).popover('hide');                  
                  //$delete.popover('destroy').popover(popOpts);  
              }
          });
      });

    });

    tblJournalDetil.on('draw.dt', function () {

      $('a.edit', this).on('click', function() {

        var data = tblJournalDetil.row($(this).closest('tr')).data();
        var trId = data.rowid;
        var form = document.getElementById("frmJurnalDetil");
        let formId = form.setAttribute("formid", trId);

        tblJournalDetil.row(`#${trId}`).select();

        $.blockUI({message: 'Opening Data, Please Wait...'});

        setTimeout( ()=> {

          $('#pnl_edit-txt_jurnaldetil_line').val(data.jurnaldetil_line);
          $('#pnl_edit-txt_jurnaldetil_descr').val(data.jurnaldetil_descr);
          $('#pnl_edit-txt_jurnaldetil_idr').val(data.jurnaldetil_idr);
          $('#pnl_edit-txt_rekanan_id').val(data.rekanan_id);
          $('#pnl_edit-txt_rekanan_name').val(data.rekanan_name);
          $('#pnl_edit-txt_rekananshipping_line').val(data.rekananshipping_line);
          $('#pnl_edit-txt_rekananshipping_name').val(data.rekananshipping_name);
          $('#pnl_edit-cbo_acc_id').val(data.acc_id).trigger('change');
          $('#pnl_edit-cbo_branch_id').val(data.branch_id).trigger('change');
          $('#pnl_edit-cbo_strukturunit_id').val(data.strukturunit_id).trigger('change');
          
          $("#dlgDetail .modal-title").show().html('Edit Row');
          $("#dlgDetail").modal("show"); 
          //$('#rowDetail').collapse('show');
          $.unblockUI();
        }, 100);        
      });       

    });

    $("#tabedit").trigger('click');

    $('#addRow').click(function() {

      if (($('#iregion option:selected').length == 0) || ($('#ibranch').val() =='') ) { 
        
        display_modal('Alert!', 'Please select Bussiness Unit, Store, Tenant.');
      } else {

        let trid;
        var form = document.getElementById("frmJurnalDetil");
        let countRows = tblJournalDetil.rows().count();
        let jurnaldetil_line = 0;

        if (countRows!=0) {
          jurnaldetil_line = tblJournalDetil.cell(countRows-1, 2).data();
        }

        jurnaldetil_line = Number(jurnaldetil_line) + 10;  
        trid = `jDetil-row-${jurnaldetil_line}`;

        let formId = form.setAttribute("formid", trid);

        let rekanan_id = $('#htenant').val();
        let rekanan_name = $('#itenant').val();
        let rekananshipping_line = $('#hbrand').val();
        let rekananshipping_name = $('#ibrand').val();
        let branch_id = $('#ibranch').val();
        let strukturunit_id = $('#istruk').val();
        let jurnal_descr = $('#jurnal_descr').val();

        //$('#pState').val('NEW');
        $('#pnl_edit-txt_jurnaldetil_line').val(jurnaldetil_line);
        $('#pnl_edit-txt_jurnaldetil_descr').val(jurnal_descr);
        $('#pnl_edit-txt_jurnaldetil_idr').val(0);
        $('#pnl_edit-txt_rekanan_id').val(rekanan_id);
        $('#pnl_edit-txt_rekanan_name').val(rekanan_name);
        $('#pnl_edit-txt_rekananshipping_line').val(rekananshipping_line);
        $('#pnl_edit-txt_rekananshipping_name').val(rekananshipping_name);
        $('#pnl_edit-cbo_acc_id').val('').trigger('change');
        $('#pnl_edit-cbo_branch_id').val(branch_id).trigger('change');
        $('#pnl_edit-cbo_strukturunit_id').val(strukturunit_id).trigger('change');

        $("#dlgDetail").modal("show");
        $("#dlgDetail .modal-title").show().html('Add New Row');
      }

    });

    $('#tabedit').click(function() {

      display_modal('Alert!', 'Please, select data from list.');
    });

    $('#frmJurnalDetil').on('submit', function(e) {

      e.preventDefault();

      var isValid = true;
      //var form = document.getElementById("frmJurnalDetil");
      var formId = $(this).attr("formid");
      var formDataArray = $(this).serializeArray();
      var formDataObject = {};
      let branch_name = $("#pnl_edit-cbo_branch_id option:selected").text();
      let acc_name = $("#pnl_edit-cbo_acc_id option:selected").text();
      let strukturunit_name = $("#pnl_edit-cbo_strukturunit_id option:selected").text();

      $.blockUI({message: 'Saving Data, Please Wait...'});

      setTimeout( ()=> {

        $.each(formDataArray, function(i, field) {
          formDataObject[field.name] = field.value;
        });

        formDataObject.branch_name = branch_name;
        formDataObject.acc_name = acc_name;
        formDataObject.strukturunit_name = strukturunit_name;

        let lastRowData = insertRow(formId, tblJournalDetil, formDataObject);
        //let lastRowData = tblJournalDetil.row(`#${formId}`).data();
        let lastLine = Number(lastRowData.jurnaldetil_line) + 10;
        //let countRows = tblJournalDetil.rows().count();
        //let lastLine = tblJournalDetil.cell(countRows-1, 0).data();
        jurnalDetilRows.push(lastRowData);
        $('#row_jurnaldetil').val( JSON.stringify({ jurnalDetilRows }) );

        $('#pnl_edit-txt_jurnaldetil_line').val(lastLine);

        $("#dlgDetail").modal("hide"); 

        $.unblockUI();
      }, 120);
      
    })

    $('#dlgDetail').on('hidden.bs.modal', function () {
      // do something…
      tblJournalDetil.rows().deselect()
    })
      
    function display_modal(title, message){
      $("#mdlinfo").modal("show");
      $("#mdltitle").show().html(title);
      $("#mdlbody").show().html(message);
    }

    $('.deci').number( true, 2 );
    $('.bulet').number( true, 0 );

    $('.deci').on('input', function (e) {
      $(this).css("color", ""); 
      $(this).toggleClass('redForeground', $(this).val() < 0);    
    });

    function handlePopupTenant(dt)
    {

      $('.search-tenant').each(function() {
        var $searchTenant = $(this);

        // Dapatkan container dari atribut data
        var tenantContainer = $searchTenant.closest('.form');

        $searchTenant.popover({
            html        : true,
            container   : tenantContainer,
            placement   : 'bottom',
            content     : '<input hidden name="rowItemId">'
        }).on("show.bs.popover", function(){
            var $popContainerMember = $(this).data('bs.popover').tip();
            $popContainerMember.css({minWidth: '720px', maxWidth: '720px'});
            if ($lastPopOver != null) $lastPopOver.popover('hide');
            $lastPopOver = $searchTenant;
            //console.log($lastPopOver)
            $popoverTenant.show();

        }).on('shown.bs.popover', function(){
            var 
                $popContainerMember = $(this).data('bs.popover').tip(),
                $popcontent   = $popContainerMember.find('.popover-content');
            $popContainerMember.find('.popover-content').append($popoverTenant);

        }).on('hide.bs.popover', function(){
            $popoverTenant.hide();
            $popoverTenant.appendTo($('.form'));
            $lastPopOver = null;

        }).on('hidden.bs.popover', function(){
          console.log('hidden.bs.popover')
          //$(this).popover('dispose');
        }).on('click', function(e){
            dt.draw();
            e.preventDefault();
        });

        $('.popover-close').click(function(){
            //$('.search-member').popover('hide');
        });

        $('body').on('click', function (e) {
            $('[data-toggle=popover]').each(function () {
                // hide any open popovers when the anywhere else in the body is clicked
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });

      });
    }

    function handleTenantTable(namatable, params)
    {
      var popoverTenant = $('#popover_tenant');
      var dt = $('#'+namatable).DataTable({ 

        autoWidth: false,
        "pageLength": 10,
        'lengthMenu': [[5, 10, 25, 50], [5, 10, 25, 50]],
        "processing": true, 
        "serverSide": true, 
        "order": [],
        "searching": true,
        "ajax": {
          "url": `<?php echo site_url('jvoucher2/jvoucher2/controler_gridpop')?>`,
          "type": "POST",
          "data": function(o) {  
            o.params = {
              branch_id: params.branch_id.val()
            }
          }
        },
        columnDefs: [
          { 'width': '35px', 'targets': [0, 3], "className": "text-center" }, // Atur lebar kolom yang spesifik
          { 'width': 'auto', 'targets': [1, 2] } // Biarkan kolom ke-2 (index 1) mengambil sisa ruang
        ]

      });

      dt.on('draw.dt', function () {
        $('a.select', this).on('click', function() {

          var data = dt.row($(this).closest('tr')).data();
          console.log(data);
          // Menampilkan data di console (atau lakukan sesuatu dengan data tersebut)          
          $lastPopOver.closest('.input-group').find('.rekanan_name').val(data[1]);
          $lastPopOver.closest('.input-group').find('.rekanan_id').val(data[4]);
          $lastPopOver.closest('.input-group').find('.rekananshipping_line').val(data[5]);
          $lastPopOver.closest('.form').find('.rekananshipping_name').val(data[2]);

          $lastPopOver.trigger('click');
          $('.popover').hide();
        });
      })
      
      //$('#table_user_wrapper .dataTables_filter input').addClass("form-control input-medium input-inline"); // modify table search input
      //$('#table_user_wrapper .dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown
      
      popoverTenant.hide();
      return dt;
    }
    
    function handleJournalDetil() {

      var dt = $('#jDetil').DataTable({

        autoWidth: false,
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
        orderable: false,
        order: [],
        processing: true,
        ajax: {
          url: '<?php echo site_url('jvoucher2/jvoucher2/listJurnalDetail')?>',
          type: 'POST',
          data: function () {  
            return {
              jurnal_id: $('#jurnal_id').val()
            }
          },
        },
        rowId: 'rowid',

        columns: [
          {            
            className: 'text-center',
            width: '0px',
            data: null,
            defaultContent: '<a href="javascript:;" class="edit" ><i class="fa fa-pencil fa-lg"/></a>',
            orderable: false
          },
          {            
            className: 'text-center',
            width: '0px',
            data: null,
            defaultContent: '<a href="javascript:;" class="delete" data-toggle="popover"><i class="fa fa-trash fa-lg"/></a>',
            orderable: false
          },
          { data: 'jurnaldetil_line' },
          { data: 'descr' },
          { data: function (row) {
              return Math.abs(row.debit);
            } 
          },
          { data: function (row) {
              return Math.abs(row.credit);
            } 
          }
        ],

        columnDefs: [
          //{ targets: [0], width: '10px', className: "text-center"},
          { targets: [2], width: '15px', className: "text-center" },
          { targets: [3], width: 'auto' },
          { targets: [4], width: '100px', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 2, '') },
          { targets: [5], width: '100px', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 2, '') }
        ],

        
        footerCallback: function (row, data, start, end, display) {

          let api = this.api();
  
          // Remove the formatting to get integer data for summation
          let intVal = function (i) {
            return typeof i === 'string'
              ? i.replace(/[\$,]/g, '') * 1
              : typeof i === 'number'
              ? i
              : 0;
          };
  
          // Total over all pages
          var totalDebit = api
            .column(4)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);

          var totalCredit = api
            .column(5)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);

          var balance = totalDebit-totalCredit;

          totalDebit = totalDebit.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
          totalCredit = totalCredit.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

          api.column(4).footer().innerHTML = totalDebit;
          api.column(5).footer().innerHTML = totalCredit;

          $('tr:eq(1) th:eq(2)', api.table().footer()).html(balance.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        }
        

      });

      return dt;
    }

    handlePopupTenant(tenantTable);

  });


  $.fn.datepicker.defaults.format = "yyyy-mm-dd";
  $.fn.datepicker.defaults.autoclose = true;

  function selectionGrid(vlink, namatable, optsearch, pLength=10, aCenter=[], params) {
      
    var dt = $('#'+namatable).DataTable({ 

      "pageLength": pLength,
      "processing": true, 
      "serverSide": true, 
      "order": [],
      "searching" : true,
      "ajax": {
        "url": vlink,
        "type": "POST",
        "data": function(o){
          
          let criteria = '';
          let branch_id = '';

          if (typeof params.criteria == 'object') {
            criteria = params.criteria.val();
          }

          if (typeof params.branch_id == 'object') {
            branch_id = params.branch_id.val();
          }

          o.params = {
            line_no: params.line,
            search: criteria,
            branch_id: branch_id
          }
        }  
      },   

      "columnDefs": [
        { "targets": [ -1 ], "orderable": false },
        { "targets": aCenter, "className": "text-center" },
        { "orderable": false, "className": 'select-checkbox', "targets": 0 }
      ],

      select: {
          style:    'os',
          selector: 'td:first-child'
      },  

      dom:optsearch

    });
    
    return dt;
  }

  function insertRow(rowid, dt, obj) {
    
    // Cari baris yang cocok dengan ID
    var matchRow = dt.row( function ( idx, rowdata, node ) {
      return rowdata.rowid === rowid ? true : false;
    });
    var matchData = matchRow.data();
    var dataRow;

    var descr = `      
      <div>
        <div style="font-weight: bold;"><span style="font-size: 0.8em; margin-right: 3px; vertical-align: top;">${obj.acc_id}</span>${obj.acc_name.toUpperCase()}</div>
      </div>
      <div style="padding: 0px 0px 0px 10px; font-style: italic;">${obj.jurnaldetil_descr}</div>
      <div style="font-size: 0.85em;">${obj.branch_name} - ${obj.rekanan_name.toUpperCase()} - ${obj.strukturunit_name}</div>
    `;

    var debit = parseFloat(obj.jurnaldetil_idr) > 0 ? obj.jurnaldetil_idr : '';
    var credit = parseFloat(obj.jurnaldetil_idr) < 0 ? obj.jurnaldetil_idr : '';

    // Jika baris ditemukan, perbarui datanya
    if (matchData===undefined) {
      dt.row.add({
        'rowid': rowid,
        'jurnaldetil_line': obj.jurnaldetil_line,
        'descr': descr,
        'debit': debit,
        'credit': credit,
        'jurnaldetil_descr': obj.jurnaldetil_descr,
        'jurnaldetil_idr': obj.jurnaldetil_idr,
        'acc_id': obj.acc_id,
        'branch_id': obj.branch_id,
        'rekanan_id': obj.rekanan_id,
        'rekanan_name': obj.rekanan_name,
        'strukturunit_id': obj.strukturunit_id,
        'rekananshipping_line': obj.rekananshipping_line,
        '_state': 'NEW'
      })
      .draw();
    } else {      
      matchData.jurnaldetil_line = obj.jurnaldetil_line
      matchData.descr = descr
      matchData.debit = debit
      matchData.credit = credit
      matchData.jurnaldetil_descr = obj.jurnaldetil_descr
      matchData.jurnaldetil_idr = obj.jurnaldetil_idr
      matchData.acc_id = obj.acc_id
      matchData.branch_id = obj.branch_id
      matchData.rekanan_id = obj.rekanan_id
      matchData.rekanan_name = obj.rekanan_name
      matchData.strukturunit_id = obj.strukturunit_id
      matchData.rekananshipping_line = obj.rekananshipping_line
      matchRow.data(matchData).draw();
    }

    dataRow = dt.row(`#${rowid}`).data();
    return dataRow;
  }

  function handleAlert(msg) {
    
    App.alert({
      container: '#formAlert',
      place: 'prepend',
      type: 'danger',
      message: msg,
      close: true,
      reset: true,
      focus: true,
      closeInSeconds: 10,
      icon: 'exclamation-triangle'
    });
  }

  $(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );

</script>

<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

#jDetil th, #jDetil td, #jDetil label {
  font-size: 9pt;
}

table#jDetil.dataTable tbody tr:hover {
  background-color: #fddf66 !important;
}

table#jDetil.dataTable tbody>tr.selectRow {
  /* background: #FF8C00 !important; */
  background-image: linear-gradient(to top, rgba(129, 112, 15, 0.5) 30%, rgba(170, 166, 57, 0.7) 100%) !important;
}

table#jDetil.dataTable tbody>tr.selected {
    /* background: #FF8C00 !important; */
    background-image: linear-gradient(to top, rgb(47, 72, 214, 0.5) 30%, rgba(47, 72, 214, 0.7) 100%);
}

#DgvRef th, #DgvRef td, #DgvRef label {

    font-size: 9pt;
    white-space: nowrap;    
}

#DgvRes th, #DgvRes td, #DgvRes label {
    font-size: 9pt;
    white-space: nowrap;    
}

#loanTab th, #loanTab td, #loanTab label {
    font-size: 9pt;
    white-space: nowrap;    
}

.redForeground {
    color: red;
}

label {
  font-size: 9pt;
  font-weight: bold;
}

.select2-container {
  min-width:120px;
}

.dataTables_wrapper tbody tr {
  cursor: default;
}

</style>

    <!-- Popover Tenant -->
    <div id="popover_tenant" class="row" style="display:none;">
      <div class="col-md-12">
        <div class="head">
          <button type="button" class="close popover-close" aria-hidden="true"></button>
        </div>        
          <br>
          <table class="table table-condensed table-striped table-bordered table-hover compact" id="table_tenant">
            <thead>
              <tr role="row" class="heading">
                <th><div class="text-center">Debtor No</div></th>
                <th><div class="text-center">Tenant</div></th>
                <th><div class="text-center">Brand</div></th>
                <th><div class="text-center">Action</div></th>
              </tr>
            </thead>
            <tbody>                
            </tbody>
          </table>        
      </div>
    </div> 

    <div class="modal" id="mdlinfo" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header" >
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="mdltitle">Success!</h4>
          </div>
          <div class="modal-body" id="mdlbody" style="text-align: center">
            <p>Data has been saved&hellip;</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default center-block" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    
    <!-- /.row-add/ edit-detail -->
    <div class="modal fade" id="dlgDetail" tabindex="-1" role="basic" aria-hidden="true" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            </button>
            <h4 class="modal-title">
              Detail
            </h4>
          </div>
          
          <div class="portlet-body form">

            <form action="#" id="frmJurnalDetil" role="form" class="form form-horizontal">

              <div class="form-body">

                <div class="form-group form-md-line-input">
                  <label for="pnl_edit-txt_jurnaldetil_line" class="col-md-3 control-label">Line</label>
                  <div class = "col-md-6">
                    <input type="text"  id="pnl_edit-txt_jurnaldetil_line" name="jurnaldetil_line" class="form-control" readonly>
                    <!--<input type="hidden" id = "pID" name="pID">-->
                    <!--<input type="hidden" id = "pState" name="pState">-->
                    <div class="form-control-focus"></div>
                  </div>
                </div>

                <div class="form-group form-group-sm form-md-line-input">
                  <label for="pnl_edit-cbo_acc_id" class="col-md-3 control-label">Account</label>
                  <div class = "col-md-9">
                    <?php echo form_dropdownext('acc_id', $account, '', 'id ="pnl_edit-cbo_acc_id" class="form-control input-sm account" style="width: 100%;" required');?>                         
                    <div class="form-control-focus"></div>
                  </div> 
                </div>
              
                <div class="form-group form-group-sm form-md-line-input">
                  <label for="pnl_edit-txt_jurnaldetil_descr" class="col-md-3 control-label">Descr</label> 
                  <div class="col-md-9">                
                    <input  type="text" id="pnl_edit-txt_jurnaldetil_descr" name="jurnaldetil_descr" class="form-control" required>
                    <div class="form-control-focus"></div>
                    <span class="error-msg text-danger"></span>
                  </div>
                </div>


                <div class="form-group form-group-sm form-md-line-input">
                  <label for="pnl_edit-txt_jurnaldetil_idr" class="col-md-3 control-label">IDR</label>
                  <div class="col-md-9">
                    <input type="text" id="pnl_edit-txt_jurnaldetil_idr" name="jurnaldetil_idr" class="deci form-control" value="0" style="text-align: right; font-weight: bold;" required>
                    <div class="form-control-focus"></div>
                  </div>
                </div>
              

                <div class="form-group form-group-sm form-md-line-input">
                  <label for="pnl_edit-cbo_branch_id" class="col-md-3 control-label">Branch</label>
                  <div class = "col-md-9">
                    <?php echo form_dropdownext('branch_id', $branch, '', 'id ="pnl_edit-cbo_branch_id" class="form-control" style="width: 100%;" required');?>                       
                    <div class="form-control-focus"></div>
                  </div> 
                </div>
              

                <div class="form-group form-md-line-input">
                  <label for="pnl_edit-txt_rekanan_id" class="col-md-3 control-label">Tenant</label>
                  <div class = "col-md-9">
                    
                    <div class="input-group input-group-sm">
                      <div class="input-group-control">
                        <input type="text" id = "pnl_edit-txt_rekanan_name" name="rekanan_name" class="form-control input-sm rekanan_name" readonly value="" required>                            
                        <div class="form-control-focus"></div>
                      </div>
                      <span class="input-group-btn">
                        <button id ="bTenantPopUp" type="button" class="btn btn-primary search-tenant" data-bs-toggle="popover"><i class="fa fa-search"></i></button>
                      </span> 
                      <input type="hidden" id="pnl_edit-txt_rekanan_id" name="rekanan_id" class="rekanan_id"> 
                      <input type="hidden" id="pnl_edit-txt_rekananshipping_name" name="rekananshipping_name" class="rekananshipping_name"> 
                      <input type="hidden" id="pnl_edit-txt_rekananshipping_line" name="rekananshipping_line" class="rekananshipping_line">
                    </div>
                  </div> 
                </div>


                <div class="form-group form-group-sm form-md-line-input">
                  <label for="pnl_edit-cbo_strukturunit_id" class="col-md-3 control-label">Strukturunit</label>
                  <div class = "col-md-9">
                    <?php echo form_dropdownext('strukturunit_id', $struktur, '', 'id ="pnl_edit-cbo_strukturunit_id" class="form-control" style="width: 100%;" required');?>
                    <div class="form-control-focus"></div>
                  </div> 
                </div>

              </div>

              <div class="form-actions">
                <div class="row">
                  <div class = "col-md-offset-3 col-md-9">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                    <button id="submitFormDetail" type="submit" class="btn green-haze"><i class="fa fa-save"></i> Save</button>
                  </div>
                </div>
              </div>

            </form>

          </div>

          <div class="modal-footer">
          </div>

        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <div id="formAlert"></div>
    <!-- CONTENT -->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-title">
            <div class="caption" align="right">
              <div class="actions">
                <div class="btn-group">
                  <a class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> <i class="fa fa-search"></i> Advanced Search
                  <i class="fa fa-angle-down"></i>
                  </a>
                  <ul class="dropdown-menu pull-right">
                    <br>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="contain">
                          Author
                        </label>
                        <input class="form-control" type="text" />
                      </div>
                      <div class="form-group">
                        <label for="contain">
                          Contains the words
                        </label>
                        <input class="form-control" type="text" />
                      </div>
                      <div class="form-group">
                        <label for="contain">
                          Select Option
                        </label>
                        <select class="form-control">
                          <option>
                            Option 1
                          </option>
                          <option>
                            Option 2
                          </option>
                          <option>
                            Option 3
                          </option>
                          <option>
                            Option 4
                          </option>
                          <option>
                            Option 5
                          </option>
                        </select>
                        <br>
                        <button type="search" class="btn blue">
                          Search
                        </button>
                      </div>
                    </div>
                  </ul>
                </div>
                <div class="btn-group">
                  <a class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> <i class="fa fa-print"></i> Export
                  <i class="fa fa-angle-down"></i>
                  </a>
                  <ul class="dropdown-menu pull-right">
                    <li>
                      <a href="javascript:;">
                      <i class="fa fa-file-pdf-o"></i> PDF </a>
                    </li>
                    <li>
                      <a href="javascript:;">
                      <i class="fa fa-file-excel-o"></i> EXCEL </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="tools">
              <a href="javascript:;" class="collapse"> </a>
              <a href="#portlet-config" data-toggle="modal" class="config"> </a>
            </div>
          </div>
          <div class="portlet-body">
            <div class="tabbable-custom ">
              <ul class="nav nav-tabs ">
                <li class="active">
                  <a href="<?php echo base_url('index.php/jvoucher2/jvoucher2/jvoucherlist'); ?>" id='tablist'> LIST </a>
                </li>
                <li>                          
                  <a href="<?php echo base_url('index.php/jvoucher2/jvoucher2/jvoucheradd'); ?>" id='tabdata'> INPUT </a>
                </li>
                <li>
                  <a href="#editdata" data-toggle="tab"  id='tabedit'> EDIT </a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane" id="editdata">
                  <div class="portlet-body form">
                    <form action="<?php echo site_url('jvoucher2/jvoucher2/updateJournal');?>" method="post" id="frmJurnal">

                      <div class="form-body">
      
                      <?php
                      if(isset($result)){
                        //print_r($result);
                        foreach($result as $row){ ?>
                        <input type="hidden" id="hbrand" name="hbrand" value="<?php echo $row->rekananshipping_line;?>">
                        <input type="hidden" id="jurnal_detil" name="jurnal_detil"/>
                        <div class="row">

                          <div style="color:red"> <?php echo validation_errors(); ?> </div>

                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label>ID</label>
                              <label class="post checkbox-inline pull-right"><input id="jurnal_isposted" type="checkbox" <?php if ($row->jurnal_isposted == 1) echo 'checked= "checked"';?> disabled><b>Posted</b></label>
                              <label class="post checkbox-inline pull-right"><input type="checkbox" <?php if ($row->jurnal_isdisabled == 1) echo 'checked= "checked"';?> disabled><b>Disabled</b>&nbsp;</label>
                              <label class="post checkbox-inline pull-right"><input type="checkbox" <?php if ($row->jurnal_isreversed == 1) echo 'checked= "checked"';?> disabled><b>Reversed</b>&nbsp;</label>
                              <input  type="text" id="jurnal_id" name="jurnal_id" class="form-control input-sm" value="<?php echo $row->jurnal_id;?>" readonly>
                            </div>
                          </div>   

                          <div class="col-md-4 form-group form-group-sm row">
                            <div class="col-xs-12">
                            <label>Business Unit</label>
                              <?php echo form_dropdown('iregion', $region, $row->region_id, 'id ="iregion" class="form-control" style="width: 100%;" required '); ?>
                            </div>
                            <input type="hidden" id = "cboregion" name="cboregion" value="<?php echo $row->region_id; ?>">
                          </div>          

                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label>Channel</label>
                                <input type="text" id = "channel_id" name="channel_id" class="form-control input-sm" value="<?php echo $row->channel_id;?>" readonly>
                            </div>
                          </div>     


                          <div class="col-md-4 form-group form-group-sm row">
                            <div class="col-xs-12">
                            <label>Periode</label>
                            <?php 
                              if ($row->jurnal_isposted == 1)
                              {
                                echo form_dropdown('iperiod', $periodall, $row->periode_id, 'id ="iperiod" class="form-control" style="width: 100%;" required'); 
                              }else{
                                echo form_dropdown('iperiod', $period, $row->periode_id, 'id ="iperiod" class="form-control" style="width: 100%;" required'); 
                              }
                            ?>                                   
                            </div>
                          </div>


                          <div class="col-md-4 form-group form-group-sm row">
                            <div class="col-xs-12">
                              <label>Store</label>
                                <select data-placeholder="Select a Store" id= "ibranch" name= "cbobranch" style="width: 100%;" required>
                                  <option value="<?php echo $row->branch_id;?>" selected="selected" ><?php echo $row->branch_name;?></option>
                                </select>
                            </div>
                          </div>  
                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label>Jurnal Type</label>
                                <input type="text" id = "jurnaltype_id" name="jurnaltype_id" class="form-control input-sm" value="<?php echo $row->jurnaltype_id;?>" readonly>
                            </div>
                          </div>  
                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label>Book Date</label>
                              <div class="input-group date" data-provide="datepicker">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control input-sm pull-right" id="jurnal_bookdate" name="jurnal_bookdate" value = "<?php echo $row->jurnal_bookdate;?>">
                              </div>
                            </div>
                          </div>                                     
                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label>Rekanan/ Tenant</label>
                              <div class="input-group input-group-sm">
                                <input type="text" id = "itenant" name="itenant" class="form-control input-sm rekanan_name" value="<?php echo $row->rekanan_name;?>" required autocomplete="off">
                                <span class="input-group-btn">
                                  <button id ="bttenant" type="button" class="btn btn-primary search-tenant"><i class="fa fa-search"></i></button>
                                </span> 
                                <input type="hidden" id = "htenant" name="htenant" class="rekanan_id" value="<?=$row->rekanan_id;?>"/>
                                <input type="hidden" id = "ibrand" name="ibrand" class="form-control input-sm rekananshipping_line" value="<?=$row->rekananshipping_line;?>"/>
                              </div>
                            </div>
                          </div>  

                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label>Brand</label>
                                <input type="text" id = "ibrand" name="ibrand" class="form-control input-sm rekananshipping_name" readonly value="<?php echo $row->rekananshipping_name;?>">
                            </div>
                          </div>

                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label>Jurnal Source</label>
                                <input type="text" id = "jurnal_source" name="jurnal_source" class="form-control input-sm" value="<?php echo $row->jurnal_source;?>" readonly>
                            </div>
                          </div> 

                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label>Due Date</label>
                              <div class="input-group date" data-provide="datepicker">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control input-sm pull-right" id="jurnal_duedate" name="jurnal_duedate" value = "<?php echo $row->jurnal_duedate;?>">
                              </div>
                            </div>
                          </div>              

                          <div class="col-md-4 form-group form-group-sm row">
                            <div class="col-xs-12">
                              <label>Strukturunit</label>                                        
                                <?php echo form_dropdown('istruk', $struktur, $row->strukturunit_id, 'id ="istruk" class="form-control" style="width: 100%;" required '); ?>
                            </div>
                          </div>

                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                                <label>Faktur/Invoice</label>                                        
                                <input type="text" id = "jurnal_faktur" name="jurnal_faktur" class="form-control input-sm" value="<?php echo $row->jurnal_faktur;?>" readonly>
                            </div>
                          </div>          

                          <div class="col-md-11 form-group row">                                    
                            <div class="col-xs-12">
                              <label>Description:</label>
                              <textarea id = "jurnal_descr" name="jurnal_descr" class="form-control input-sm" required rows="2" ><?php echo $row->jurnal_descr;?></textarea>
                            </div>                                    
                          </div>

                          <div class="col-md-12 form-group row"></div>
                          <div class="col-md-4 form-group row"></div>

                          <div class="col-md-12">                                  
                          <br>
                          <a href="javascript:void(0)" id="addRow"><strong>Add Row</strong></a>
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                              <ul class="detil nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab" role= "tab">Detail</a></li>
                                <li><a href="#tab_2" data-toggle="tab" role = "tab">Reference</a></li>
                                <li><a href="#tab_3" data-toggle="tab" role = "tab">Response</a></li>
                                <li><a href="#tab_4" data-toggle="tab" role = "tab">Record</a></li>
                              </ul>
                              <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                  <div class ="table-container">
                                    <input type="hidden" id="row_jurnaldetil" name="row_jurnaldetil"/>
                                    <input type="hidden" id="row_jurnaldeleted" name="row_jurnaldeleted"/>
                                    <table class="table responsive hover" id='jDetil' style="width:100%">
                                      <thead>
                                        <tr>
                                          <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;"></th>
                                          <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;"></th>
                                          <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                          <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Description</th>
                                          <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Debit</th>
                                          <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Credit</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                      <tfoot>
                                        <tr>                                          
                                          <th colspan="4" style="text-align:right">Total</th>
                                          <th style="text-align:right; padding-right:10px"></th>
                                          <th style="text-align:right; padding-right:10px"></th>
                                        </tr>
                                        <tr>
                                          <th colspan="4" style="text-align:right">Balance</th>
                                          <th></th>
                                          <th class="balance" style="text-align:right; padding-right:10px;color:red;">0</th>
                                        </tr>
                                      </tfoot>
                                    </table>
                                  </div>
                                  </div>
                                  <!-- reference -->
                                  <div class="tab-pane" id="tab_2">
                                    <div class ="table-responsive">     
                                      <table class="table table-bordered table-striped" id='DgvRef' style="border:solid 1px #999; #999; border-radius:0px;">
                                        <thead>
                                          <tr>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">ID</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Line</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Bookdate</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Account</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:150px;width:150px;">IDR</th> 
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:320px;width:320px;">Descr</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:310px;width:310px;">Rekanan</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:220px;width:220px;">Brand</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                          <?php if(count($resultRef) > 0) { 
                                            foreach($resultRef as $rows) {
                                          ?>
                                          <tr>
                                            <td><?php echo $rows['jurnal_id']; ?></td>
                                            <td><?php echo $rows['jurnaldetil_line']; ?></td>
                                            <td><?php echo $rows['jurnal_bookdate']; ?></td>
                                            <td><?php echo $rows['acc_id'].'||'.$rows['acc_name']; ?></td>
                                            <td><?php echo number_format($rows['jurnaldetil_idr'],2); ?></td>
                                            <td><?php echo $rows['jurnaldetil_descr']; ?></td>
                                            <td><?php echo $rows['rekanan_id'].'||'.$rows['rekanan_name']; ?></td>
                                            <td><?php echo $rows['rekananshipping_line'].'||'.$rows['rekananshipping_name']; ?></td>
                                          </tr>
                                          <?php }} ?>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <!-- reference end -->
                                  <!-- response -->
                                  <div class="tab-pane" id="tab_3">
                                    <div class ="table-responsive">
                                      <table class="table table-bordered table-striped" id='DgvRes' style="border:solid 1px #999; #999; border-radius:0px;">
                                        <thead>
                                          <tr>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">ID</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Line</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Bookdate</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Account</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:150px;width:150px;">IDR</th> 
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:320px;width:320px;">Descr</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:310px;width:310px;">Rekanan</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:220px;width:220px;">Brand</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                          <?php if(count($resultRes) > 0) { 
                                            foreach($resultRes as $rows) {
                                          ?>
                                          <tr>
                                            <td><?php echo $rows['jurnal_id']; ?></td>
                                            <td><?php echo $rows['jurnaldetil_line']; ?></td>
                                            <td><?php echo $rows['jurnal_bookdate']; ?></td>
                                            <td><?php echo $rows['acc_id'].'||'.$rows['acc_name']; ?></td>
                                            <td><?php echo number_format($rows['jurnaldetil_idr'],2); ?></td>
                                            <td><?php echo $rows['jurnaldetil_descr']; ?></td>
                                            <td><?php echo $rows['rekanan_id'].'||'.$rows['rekanan_name']; ?></td>
                                            <td><?php echo $rows['rekananshipping_line'].'||'.$rows['rekananshipping_name']; ?></td>
                                          </tr>
                                          <?php }} ?>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>         
                                  <!-- response end -->         
                                  <!-- Record -->                          
                                  <div class="tab-pane" id="tab_4">
                                    <div class="row">
                                    <div class="col-md-6">
                                      <div class="col-xs-8">
                                        <label>Create By</label>
                                        <input type="text" id= "jurnal_createby" name="jurnal_createby" class="form-control input-sm" value="<?php echo $row->jurnal_createby;?>" readonly>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="col-xs-8">
                                        <label>Create Date</label>
                                        <input type="text" id="jurnal_createdate" name="jurnal_createdate" class="form-control input-sm" value="<?php echo $row->jurnal_createdate;?>" readonly>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="col-xs-8">
                                        <label>Modify By</label>
                                        <input type="text" id= "jurnal_modifyby"  name="jurnal_modifyby" class="form-control input-sm" value="<?php echo $row->jurnal_modifyby;?>" readonly />
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="col-xs-8">
                                        <label>Modify Date</label>
                                        <input type="text" id="jurnal_modifydate" name="jurnal_modifydate" class="form-control input-sm" value="<?php echo $row->jurnal_modifydate;?>" readonly />
                                      </div>
                                    </div>
                                    </div>
                                  </div>
                                  <!-- Record End -->
                                <!-- /.tab-pane -->
                              </div>
                              <!-- /.tab-content -->
                            </div>
                            <!-- nav-tabs-custom -->
                          </div>
                          <!-- /.col -->
                        </div>
                      </div>
                      <div class="form-actions right">
                        <div class="row">
                          <div class="col-md-12">
                            <button type="submit" name="submit" class="btn btn-primary"  <?php echo ($row->jurnaltype_id) === 'JV' && (!($row->jurnal_isposted)) ? '' : 'disabled';?> ><i class="fa fa-save"></i> Submit</button>
                            <button type="submit" name="delete" class="btn btn-danger" <?php echo ($row->jurnaltype_id) === 'JV' && (!($row->jurnal_isposted)) ? '' : 'disabled';?> ><i class="fa fa-ban"></i> Delete</button>
                          </div>
                        </div>
                      </div>
                    </form>
                      <?php if ($row->jurnal_isposted == 1){?>
                      <script>
                        $('#iperiod').prop('disabled', true);
                      </script>
                      <?php }?>
                    <?php }}?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END OF CONTENT -->


