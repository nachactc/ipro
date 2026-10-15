<?php $chid = get_setting("channel_id");?>
<script>

  function caluptotal()
  {
    var vjml=0;
    var nilmin=0;
    var nilplus=0.0;
    var nilselisih=0;
    var table = $("#jDetil tbody");

    table.find('tr').each(function (i) {

      var $row = $(this).closest("tr"); 
      var clsidr = $row.find(".clsidr").val();
      clsidr = clsidr.replace(/,/g, "");
      
      var vidr = parseFloat(clsidr)||0;
      vjml = parseFloat(vjml)+vidr;
      
      
      var cnilmin = $row.find(".clsidr").val();

      cnilmin = cnilmin.replace(/,/g, "");

      var vmin = parseFloat(cnilmin)||0;
      if (vmin < 0){
        nilmin = nilmin+vmin;
      }
      
      var cnilplus = $row.find(".clsidr").val();
      cnilplus = cnilplus.replace(/,/g, "");
      
      var vplus = parseFloat(cnilplus)||0;
      
      if (vplus > 0){
        nilplus = nilplus+vplus;
      }
    
    
    });

    vjml = vjml.toFixed(2);
    
    
    nilselisih=nilmin+nilplus
    $("#tselisih").val(vjml*-1);
    $("#jumlah_idr").val(nilplus);
  }

  function validateb4submit(){
    var max=GetDgvLineMaxNum('jDetil',0);
    if (max < 1 ){    
      display_modal('Alert!', 'Please, Add Term & Condition !');
      return false;
    }
  }
  function app(text)
  {
        var TheTextBox = document.getElementById("nilcounter");
    TheTextBox.value='';
        TheTextBox.value = TheTextBox.value + text;
  }
	function getrekid(nil)
  {
        var Txtrekid = document.getElementById("trek_id"+nil).value; 
    //alert(Txtrekid);
    document.getElementById("temprekid").value=Txtrekid;
    
  }

  $(document).on("focusin", "#itenant", function() {
    $(this).prop('readonly', true);  
  });

  $(document).ready(function(){  
    $.fn.modal.Constructor.prototype.enforceFocus = $.noop;

    var arrid= [];
    //lfrtip =default  
    var tenantParams = { 
      line: 0,
      branch_id: $('#ibranch'),
      criteria: $('#searchTenant')
    }
    
    let $lastPopOver = null;
    let jurnalDetilRows = [];
    var $popoverTenant = $('#popover_tenant');

    var tTable = $('#detailLoader').DataTable();
    var tenantTable = tenantGrid("table_tenant", tenantParams);
    var tblJournalDetil = handleJournalDetil();

 
    $('#frmJurnal').submit( function(e) {
      //var ttotamount=$("#jumlah_idr").val();
      
      var period = $('#iperiod').val();
      var bookdateInput = $('#jurnal_bookdate').val().split('-');
      var periodeInputCheck = bookdateInput[0].substring(4,2)+bookdateInput[1];
          
      if("'"+period+"'" !== "'"+periodeInputCheck+"'")
      {
        alert('Periode Berbeda Dengan Bookdate!');
        return false; 
      } 
      
      if($('#tselisih').val() !== '0'){
        alert('Nilai Jurnal belum balance');
        return false;
      }


      if($('#book_date').val() == ''){
        alert('Book Date Belum Di masukkan');
        return false;        
      }
    });
	
    if ($('.post').attr('checked'))
    {

      $('.submit').prop('disabled',true);

    }else{

      $('.submit').prop("disabled", false);

    }  
  
    $('#iregion').select2({placeholder: 'Select a business unit'});
    $('#istruk').select2({placeholder: 'Select a struktur unit'});
    $('#iperiod').select2();
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

      // listunit = branchData.filter(function (data) { return data.branch == bra.id });          
    });  

    $('#ibranch').select2({
        placeholder: 'Select an option',
        minimumInputLength: 2,
        //tags: true,
        minimumResultsForSearch: 10,
        tokenSeparators: [',', ' '],
        ajax: {
            url: '<?php echo site_url('jvoucher/jvoucher/branch_select')?>',
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
            url: '<?php echo site_url('jvoucher/jvoucher/branch_select')?>',
            dataType: 'json',
            type: "GET",
            data: function (term) {
                return {
                    term: term
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

    $("#tabdata").trigger('click');

    $('#btdetil').click(function() {
      
      if (($('#iregion option:selected').length == 0) || ($('#ibranch').val() =='') ) { 
        
        display_modal('Alert!', 'Please select Bussiness Unit, Store, Tenant.');
      } else {

        let trid;
        //var form = document.getElementById("frmJurnalDetil");
        let countRows = tblJournalDetil.rows().count();
        let jurnaldetil_line = 0;

        //console.log(form);

        if (countRows!=0) {
          jurnaldetil_line = tblJournalDetil.cell(countRows-1, 0).data();
        }

        jurnaldetil_line = Number(jurnaldetil_line) + 10;  
        trid = `jDetil-row-${jurnaldetil_line}`;

        //let formId = form.setAttribute("formid", trid);

        //$("#dlgDetail").modal("show"); 
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
        $('#pnl_edit-txt_rekanan_id').val(rekanan_id);
        $('#pnl_edit-txt_rekanan_name').val(rekanan_name);
        $('#pnl_edit-txt_rekananshipping_line').val(rekananshipping_line);
        $('#pnl_edit-txt_rekananshipping_name').val(rekananshipping_name);
        //$('#pnl_edit-cbo_acc_id').val(['0']).trigger('change');
        $('#pnl_edit-cbo_branch_id').val(branch_id).trigger('change');
        $('#pnl_edit-cbo_strukturunit_id').val(strukturunit_id).trigger('change');


        $('#rowDetail').collapse('show');
      }

    }e);

    $('#tabedit').click(function() {

      display_modal('Alert!', 'Please, select data from list.');
    });   

    tblJournalDetil.on('dblclick', 'tr', function () {

      $.blockUI({message: 'Opening Data, Please Wait...'});
      stTimeout( ()=> {

        let data = tblJournalDetil.row(this).data();

        $('#pnl_edit-txt_jurnaldetil_line').val(data.jurnaldetil_line);
        $('#pnl_edit-txt_jurnaldetil_descr').val(data.jurnaldetil_descr);
        $('#pnl_edit-txt_rekanan_id').val(data.rekanan_id);
        $('#pnl_edit-txt_rekanan_name').val(data.rekanan_name);
        $('#pnl_edit-txt_rekananshipping_line').val(data.rekananshipping_line);
        $('#pnl_edit-txt_rekananshipping_name').val(data.rekananshipping_name);
        $('#pnl_edit-cbo_acc_id').val(data.acc_id).trigger('change');
        $('#pnl_edit-cbo_branch_id').val(data.branch_id).trigger('change');
        $('#pnl_edit-cbo_strukturunit_id').val(data.strukturunit_id).trigger('change');
        
        $("#dlgDetail").modal("show"); 
        //$('#rowDetail').collapse('show');
        $.unblockUI();
      }, 200);
        
    });

    $("#jDetil").on('click','#rDelete',function(){
      if (confirm("Are you sure to delete this row ?") == false) {
                return false;
            }
        $(this).closest('tr').remove();
      caluptotal();
    });

    $('#addRow').click( function(){

      var formDataDetail = {}
      var jurnaldetil_line = $('#pnl_edit-txt_jurnaldetil_line').val();
      var jurnaldetil_descr = $('#pnl_edit-txt_jurnaldetil_descr').val();
      var acc_id = $('#pnl_edit-cbo_acc_id').val();
      let acc_name = $("#pnl_edit-cbo_acc_id option:selected").text();
      var branch_id = $('#pnl_edit-cbo_branch_id').val();
      let branch_name = $("#pnl_edit-cbo_branch_id option:selected").text();
      var strukturunit_id = $('#pnl_edit-cbo_strukturunit_id').val();
      let strukturunit_name = $("#pnl_edit-cbo_strukturunit_id option:selected").text();
      var rekanan_id = $('#pnl_edit-txt_rekanan_id').val();
      var rekanan_name = $('#pnl_edit-txt_rekanan_name').val();
      var rekananshipping_line = $('#pnl_edit-txt_rekananshipping_line').val();
      var rekananshipping_name = $('#pnl_edit-txt_rekananshipping_name').val();      
      let trid;

      trid = `jDetil-row-${jurnaldetil_line}`;

      formDataDetail.jurnaldetil_line = jurnaldetil_line;
      formDataDetail.jurnaldetil_descr = jurnaldetil_descr;
      formDataDetail.acc_id = acc_id;
      formDataDetail.acc_name = acc_name;
      formDataDetail.branch_id = branch_id;
      formDataDetail.branch_name = branch_name;
      formDataDetail.strukturunit_id = strukturunit_id;
      formDataDetail.strukturunit_name = strukturunit_name;
      formDataDetail.rekanan_id = rekanan_id;
      formDataDetail.rekanan_name = rekanan_name;
      formDataDetail.rekananshipping_line = rekananshipping_line;
      formDataDetail.rekananshipping_name = rekananshipping_name;
      formDataDetail.rowid = trid;

      //console.log(formDataObject);
      jurnalDetilRows.push(formDataDetail);
      $('#row_jurnaldetil').val( JSON.stringify({ jurnalDetilRows }) );


      insertRow(trid, tblJournalDetil, formDataDetail); 

      let countRows = tblJournalDetil.rows().count();
      let lastLine = tblJournalDetil.cell(countRows-1, 0).data();

      lastLine = Number(lastLine) + 10;
      $('#pnl_edit-txt_jurnaldetil_line').val(lastLine);

      
      $('#rowDetail').collapse('hide');
    });
    
    $('#frmJurnalDetil').on('submit', function(e) {

      e.preventDefault();

      var isValid = true;
      //var form = document.getElementById("frmJurnalDetil");
      //var formId = form.getAttribute("formid");
      var formDataArray = $(this).serializeArray();
      var formDataObject = {};
      let branch_name = $("#pnl_edit-cbo_branch_id option:selected").text();
      let acc_name = $("#pnl_edit-cbo_acc_id option:selected").text();
      let strukturunit_name = $("#pnl_edit-cbo_strukturunit_id option:selected").text();

      $.each(formDataArray, function(i, field) {
        formDataObject[field.name] = field.value;
      });

      formDataObject.branch_name = branch_name;
      formDataObject.acc_name = acc_name;
      formDataObject.strukturunit_name = strukturunit_name;

      //console.log(formDataObject);
      jurnalDetilRows.push(formDataObject);
      $('#row_jurnaldetil').val( JSON.stringify({ jurnalDetilRows }) );

      insertRow(tblJournalDetil, formDataObject); 

      let countRows = tblJournalDetil.rows().count();
      let lastLine = tblJournalDetil.cell(countRows-1, 0).data();

      lastLine = Number(lastLine) + 10;
      $('#pnl_edit-txt_jurnaldetil_line').val(lastLine);
    })
      
    function display_modal(title, message)
    {
      $("#mdlinfo").modal("show");
      $("#mdltitle").show().html(title);
      $("#mdlbody").show().html(message);
    }

    $('.deci').number( true, 2 );
    $('.bulet').number( true, 0 );    
    
    function handleSearchTenant(dt)
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

    function tenantGrid(namatable, params)
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
          "url": `<?php echo site_url('jvoucher/jvoucher/controler_gridpop')?>`,
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
          // Menampilkan data di console (atau lakukan sesuatu dengan data tersebut)          
          $lastPopOver.closest('.input-group').find('.rekanan_name').val(data[1]);
          $lastPopOver.closest('.input-group').find('.rekanan_id').val(data[4]);
          $lastPopOver.closest('.input-group').find('.rekananshipping_line').val(data[5]);
          $lastPopOver.closest('.form').find('.rekananshipping_name').val(data[2]);

          $lastPopOver.trigger('click');
          $('.popover').hide();
        });
      })
      
      $('#table_user_wrapper .dataTables_filter input').addClass("form-control input-medium input-inline"); // modify table search input
      $('#table_user_wrapper .dataTables_length select').addClass("form-control input-xsmall input-inline"); // modify table per page dropdown
      
      popoverTenant.hide();
      return dt;
    }

    function handleJournalDetil() {

      var dt = $('#jDetil').DataTable({
      
        autoWidth: false,
        orderable: false,
        order: [],
        processing: true,

        columns: [
          { data: 'jurnaldetil_line' },
          { data: 'descr' },
          { data: 'kredit' },
          { data: 'rowid' }
        ],

        columnDefs: [          
          { targets: [0], width: '20px' },
          { targets: [1], width: 'auto' },
          { targets: [2], width: '100px', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 2, '') },
          { targets: [3], visible: false },
        ],
        select: {
          style: 'multi',
          selector: 'td:first-child'
        },
        //dom: 'frtip'
      });

      return dt;
    }

    //handleMember(tenantParams);
    handleSearchTenant(tenantTable);

  });


  $.fn.datepicker.defaults.format = "yyyy-mm-dd";
  $.fn.datepicker.defaults.autoclose = true;

  function selectionGrid(vlink, namatable, optsearch, pLength=10, aCenter=[], params)
  {
      
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

    console.log(matchRow.data());

    var descr = `      
      <div>
        <div style="font-weight: bold;"><span style="font-size: 0.8em; margin-right: 3px; vertical-align: top;">${obj.acc_id}</span>${obj.acc_name.toUpperCase()}</div>
      </div>
      <div style="font-style: italic; margin-bottom: 3px;">${obj.jurnaldetil_descr}</div>
      <div style="font-size: 0.85em;">${obj.strukturunit_name} - ${obj.branch_name} - ${obj.rekanan_name.toUpperCase()}</div>
    `;

    // Jika baris ditemukan, perbarui datanya
    if (matchRow.data()==undefined) {
      dt.row.add({
        'rowid': obj.rowid,
        'jurnaldetil_line': obj.jurnaldetil_line,
        'descr': descr,
        'kredit': obj.jurnaldetil_idr,
        'jurnaldetil_descr': obj.jurnaldetil_descr,
        'jurnaldetil_idr': obj.jurnaldetil_idr,
        'acc_id': obj.acc_id,
        'branch_id': obj.branch_id,
        'rekanan_id': obj.rekanan_id,
        'rekanan_name': obj.rekanan_name,
        'strukturunit_id': obj.strukturunit_id,
        'rekananshipping_line': obj.rekananshipping_line,
      })
      .draw();
    } else {

      var matchData = matchRow.data();
      matchData.descr = 'UPdate';
      matchRow.data( matchData ).draw();
    }

  }

  $(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );

</script>

<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

#jDetil td, #jDetil label {
  font-size: 9pt;
}

#jDetil th {
  font-size: 10pt;
}


.detil {
    padding: 2px;
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

    <div id="popover-form" class="hide">
      <div class="form-group">
        <textarea rows="4" name="txtContent" id="txtContent" class="form-control input-sm"></textarea>        
        <br>
        <button id="btnOk" type="button" class="btn btn-primary">
          <span class="glyphicon glyphicon-ok"></span>&nbsp;
        </button>  
        <button id="btnCancel" type="button" class="btn btn-default">
          <span class="glyphicon glyphicon-remove"></span>&nbsp;
        </button>
      </div>
    </div>


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
              <div class="modal-body" id="mdlbody">
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

            <!-- CONTENT -->
            <div class="row">
              <div class="col-md-12">
                <div class="portlet">
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
                          <a href="<?php echo base_url('index.php/jvoucher/jvoucher/jvoucherlist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>                          
                          <a href="#newdata" data-toggle="tab" id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane" id="newdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('jvoucher/jvoucher/saveJournal');?>" method="post" id="frmJurnal">
                          <input type="hidden" id="row_jurnaldetil" name="row_jurnaldetil"/>
							
                            <?php
                              if(isset($result)){
                               //print_r($result);
                               foreach($result as $row){ ?>
                                <div class="row">
                                  <div class="col-md-12">
                                    <div style="color:red"> <?php echo validation_errors(); ?> </div>
                                      <div class="col-md-4 form-group row">
                                        <div class="col-xs-12">
                                          <label>ID</label>
                                          <label class="post checkbox-inline pull-right"><input type="checkbox" disabled><b>Posted</b></label>
                                          <label class="post checkbox-inline pull-right"><input type="checkbox" disabled><b>Disabled</b>&nbsp;</label>
                                          <label class="post checkbox-inline pull-right"><input type="checkbox" disabled><b>Reversed</b>&nbsp;</label>
                                          <input  type="text" id="jurnal_id" name="jurnal_id" class="form-control input-sm" value="<?php echo $row->jurnal_id;?>" readonly>
                                        </div>
                                      </div>   
                                      <div class="col-md-4 form-group form-group-sm row">
                                        <div class="col-xs-12">
                                        <label>Business Unit</label>
                                          <?php echo form_dropdown('iregion', $region, $row->region_id, 'id ="iregion" class="form-control" style="width: 100%;" required  '); ?>
                                        </div>
                                        <input type="hidden" id = "cboregion" name="cboregion" value="<?php echo $row->region_id; ?>">
                                      </div>                                           
                                      <div class="col-md-4 form-group row">
                                        <div class="col-xs-12">
                                          <label>Channel</label>
                                            <input type="text" id = "channel_id" name="channel_id" class="form-control input-sm" value="<?php echo $chid;?>" readonly>
                                        </div>
                                      </div>                     
                                      <div class="col-md-4 form-group form-group-sm row">
                                        <div class="col-xs-12">
                                        <label>Periode</label>
                                          <?php echo form_dropdown('iperiod', $period, $row->periode_id, 'id ="iperiod" class="form-control" style="width: 100%;" required'); ?>
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
                                            <input type="text" id = "itenant" name="itenant" class="form-control input-sm rekanan_name" value="" required autocomplete="off">
                                            <span class="input-group-btn">
                                              <button id ="bttenant" type="button" class="btn btn-primary search-tenant" ><i class="fa fa-search"></i></button>
                                            </span>
                                            <input type="hidden" id = "htenant" name="htenant" class="rekanan_id" value="">
                                            <input type="hidden" id="hbrand" name="hbrand" class="rekananshipping_line">
                                          </div>
                                        </div>
                                      </div>   

                                      
                                      <div class="col-md-4 form-group row">
                                        <div class="col-xs-12">
                                          <label>Brand</label>
                                            <input type="text" id = "ibrand" name="ibrand" class="form-control input-sm rekananshipping_name" readonly>
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
                                      

                                      <div class="col-md-12">                                  
                                        <br>
                                        <a href="javascript:void(0)" id="btdetil" ><strong>Add Row</strong></a>
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
                                              <div id="rowDetail" class="col-md-12 collapse">
                                                <div class="portlet light">
                                                  <div class="portlet-body form">
                                                    <form action="#" id="frmJurnalDetil" role="form" class="form horizontal-form">
                                                      <div class="form-body">

                                                        <div class="row">
                                                          <div class="col-md-4 form-group form-group-sm">
                                                            <label>Line</label>
                                                            <input type="text"  id="pnl_edit-txt_jurnaldetil_line" name="jurnaldetil_line" class="form-control" readonly>
                                                          </div>
                                                        
                                                          <div class="col-md-4 form-group form-group-sm">
                                                            <label>Account</label>
                                                            <?php echo form_dropdownext('acc_id', $account, '', 'id ="pnl_edit-cbo_acc_id" class="form-control input-sm account" style="width: 100%;" required');?>  
                                                          </div>
                                                          
                                                          <div class="col-md-4 form-group form-group-sm">
                                                            <label>Descr 3</label>                
                                                            <input  type="text" id="pnl_edit-txt_jurnaldetil_descr" name="jurnaldetil_descr" class="form-control" required>
                                                          </div>

                                                        </div>
                                                        
                                                        <div class="row">
                                                          <div class="col-md-4 form-group form-group-sm">
                                                            <label>IDR</label>
                                                            <input type="text" id="pnl_edit-txt_jurnaldetil_idr" name="jurnaldetil_idr" class="deci form-control" value="0" style="text-align: right; font-weight: bold;" required>
                                                          </div>
                                                        
                                                          <div class="col-md-4 form-group form-group-sm">
                                                            <label>Branch</label>
                                                            <?php echo form_dropdownext('branch_id', $branch, '', 'id ="pnl_edit-cbo_branch_id" class="form-control" style="width: 100%;" required');?>       
                                                          </div>
                                                          
                                                          <div class="col-md-4 form-group form-group-sm">
                                                            <label>Tenant</label>
                                                            <div class="input-group input-group-sm">
                                                              <input type="text" id = "pnl_edit-txt_rekanan_name" name="rekanan_name" class="form-control input-sm rekanan_name" readonly value="" required autocomplete="off">
                                                              <span class="input-group-btn">
                                                                <button id ="bTenantPopUp" type="button" class="btn btn-primary search-tenant" data-bs-toggle="popover"><i class="fa fa-search"></i></button>
                                                              </span> 
                                                              <input type="hidden" id="pnl_edit-txt_rekanan_id" name="rekanan_id" class="rekanan_id"> 
                                                              <input type="hidden" id="pnl_edit-txt_rekananshipping_name" name="rekananshipping_name" class="rekananshipping_name"> 
                                                              <input type="hidden" id="pnl_edit-txt_rekananshipping_line" name="rekananshipping_line" class="rekananshipping_line">
                                                            </div>
                                                          </div>

                                                        </div>
                                                        
                                                        
                                                        <div class="row">
                                                          <div class="col-md-4 form-group form-group-sm">
                                                            <label>Struktur Unit</label>
                                                            <?php echo form_dropdownext('strukturunit_id', $struktur, '', 'id ="pnl_edit-cbo_strukturunit_id" class="form-control" style="width: 100%;" required');?>
                                                          </div>
                                                        </div>

                                                      </div>
                                                      <div class="form-actions right"> 
                                                        <button id="addRow" type="button" class="btn green">Add</button>
                                                        <button type="button" class="btn default" data-toggle="collapse" data-target="#rowDetail">Close</button>
                                                      </div>
                                                    </form>  
                                                  </div>
                                                </div>
                                              </div>

                                              <div class ="table-container">
                                                <input type="hidden" id="temprekid" name="temprekid" />
                
                                                <table class="table responsive  hover" id='jDetil' style="border:solid 1px #999; #999; border-radius:0px;">
                                                  <thead>
                                                    <tr>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Description</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Amount</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>                                                  
                                                  </tbody>
                                                </table>
                                              </div>
                                            </div>
                                            <div class="tab-pane" id="tab_2">
                                            <div class ="table-responsive">                                             
                                              <table class="table table-bordered table-striped" id='chargeTab' style="border:solid 1px #999; #999; border-radius:0px;">
                                                <thead>
                                                  <tr>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Transaction Type</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Start Date Paym.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">P. Inst</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Start Date Trans.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">R.Ins(M)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">R.Ins(D)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">End Date Trans.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Intval.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Time Unit.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Per(%)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Unit</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Ind./Outd.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Space</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Lump.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Base Rent IDR</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Monthly Installment</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">VAT(%)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Adend.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">n-Inst.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Descr</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Delete</th>
                                                  </tr>
                                                </thead>
                                                <tbody>                                                  
                                                </tbody>
                                              </table>
                                            </div>
                                            </div>
                                            <div class="tab-pane" id="tab_3">
                                              <div class ="table-responsive">
                                                <table class="table table-bordered table-striped" id='depositTab' style="border:solid 1px #999; #999; border-radius:0px;">
                                                  <thead>
                                                    <tr>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Transaction Type</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Start Date Trans.</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Len.</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Time Type</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Unit</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Space</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Lump.</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Base Rent/Total</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Monthly Installment</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">VAT</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Delete</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>                                                   
                                                  </tbody>
                                                </table>
                                              </div>
                                            </div>                                            
                                            <div class="tab-pane" id="tab_5">
                                              <div class="row">
                                              <div class="col-md-6">
                                                <div class="col-xs-8">
                                                  <label>Create By</label>
                                                  <input type="text" id= "jurnal_createby" name="jurnal_createby" class="form-control input-sm" value="<?php echo $row->jurnal_createby;?>">
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="col-xs-8">
                                                  <label>Create Date</label>
                                                  <input type="text" id="jurnal_createdate" name="jurnal_createdate" class="form-control input-sm" value="<?php echo $row->jurnal_createdate;?>">
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="col-xs-8">
                                                  <label>Modify By</label>
                                                  <input type="text" id= "jurnal_modifyby"  name="jurnal_modifyby" class="form-control input-sm" value="<?php echo $row->jurnal_modifyby;?>">
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="col-xs-8">
                                                  <label>Modify Date</label>
                                                  <input type="text" id="jurnal_modifydate" name="jurnal_modifydate" class="form-control input-sm" value="<?php echo $row->jurnal_modifydate;?>">
                                                </div>
                                              </div>
                                              </div>
                                            </div>
                                            <!-- /.tab-pane -->
                                          </div>
                                          <!-- /.tab-content -->
                                        </div>
                                        <!-- nav-tabs-custom -->
                                      </div>
                                      <!-- /.col -->

                                      <div class="col-md-4 form-group row"></div>
                                      <div class="col-md-4 form-group row">
                                        <label class="col-sm-4">Jumlah Foreign</label>        
                                        <div class = "col-sm-8">                                                        
                                            <input type="text" id = "agreement_idr" name="agreement_idr" class="bulet form-control input-sm" style="text-align: right;font-weight: bold;" value="0" readonly>
                                        </div>  
                                      </div>  

                                      <div class="col-md-4 form-group row form-group-sm">
                                        <label class="col-sm-4">Jumlah</label>        
                                        <div class = "col-sm-8">                    
                                          <div class="input-group input-group-sm">                                            
                                            <span class="input-group-addon" style="font-style: italic;">Rp.</span>
                                            <input type="text" id = "jumlah_idr" name="jumlah_idr" class="deci form-control input-sm" style="text-align: right;font-weight: bold;" value="0" readonly>
                                          </div>
                                        </div>  
                                      </div> 

                                      <div class="col-md-12 form-group row"></div>
                                      <div class="col-md-4 form-group row"></div>

                                      <div class="col-md-4 form-group row">
                                        <label class="col-sm-4">Selisih Foreign</label>        
                                        <div class = "col-sm-8">                                                        
                                            <input type="text" class="bulet form-control input-sm" style="text-align: right;font-weight: bold;" value="0" readonly>
                                        </div>  
                                      </div>

                                      <div class="col-md-4 form-group row form-group-sm">
                                        <label class="col-sm-4">Selisih</label>        
                                        <div class = "col-sm-8">
                                          <div class="input-group input-group-sm">
                                            <span class="input-group-addon" style="font-style: italic;">Rp.</span>
                                            <input type="text" id = "tselisih" name="tselisih" class="deci form-control input-sm" style="text-align: right;font-weight: bold;" value="0" readonly>
                                          </div>
                                        </div> 
                                      </div> 

                                    <div class="col-xs-12">
                                      <br /><input type="submit" value="SUBMIT" class="btn btn-sm btn-info" />
                                    </div>
                                  </div>
                                </div>
                            </form>
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
