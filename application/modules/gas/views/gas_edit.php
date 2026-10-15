<script src="<?php echo base_url('assets/jsinternal/xlsx.full.min.js');?>" type="text/javascript"></script>
<script> 

$(document).ready(function(){  

  var urlExcel = '';

  $('#xlf').on('change', function() { 
    
    var file = $(this).prop('files')[0];
    var formData = new FormData();

    var label = $(this).val().replace(/\\/g, '/').replace(/.*\//, '');

    $('#brojo').val(label);

    formData.append('kampretFile', file, file.name);     

    var xhr = new XMLHttpRequest();

    xhr.open('POST', '<?php echo site_url('gas/gas/uploadExcel');?>', true);
    xhr.onload = function (e) {
      if (xhr.status === 200) {
        // File(s) uploaded.
        data = JSON.parse(xhr.responseText);
        //console.log(data.files['url']);
        urlExcel = data.files['url'];
      } else {
        alert('An error occurred!');
      }
    };

    xhr.send(formData);
      
  });

  $('#upload').on('click', function() { 

      //var url = "http://localhost/agc4/assets/uploads/Template-2018_09_27_11_50_40.xls";
      var urlUpload = '<?php echo base_url('/assets/uploads/');?>'+urlExcel;
      //console.log(urlUpload);
      var oReq = new XMLHttpRequest();
      oReq.open("GET", urlUpload, true);
      oReq.responseType = "arraybuffer";

      oReq.onload = function(e) {
        var arraybuffer = oReq.response;

        /* convert data to binary string */
        var data = new Uint8Array(arraybuffer);
        var arr = new Array();
        for(var i = 0; i != data.length; ++i) arr[i] = String.fromCharCode(data[i]);
        var bstr = arr.join("");

        /* Call XLSX */
        var workbook = XLSX.read(bstr, {type:"binary"});

        /* DO SOMETHING WITH workbook HERE */
        var first_sheet_name = workbook.SheetNames[0];
        /* Get worksheet */
        var worksheet = workbook.Sheets[first_sheet_name];

        //console.log(XLSX.utils.sheet_to_json(worksheet,{raw:true}));
        uploadData = XLSX.utils.sheet_to_json(worksheet, {raw:true});

        //console.log(uploadData);
        var uRows = $('#detailTab tbody >tr');
        var uColumns;
        var r_id;
        var r_line;
        var r_reg;
        var r_saldo;

        for (var i = 0; i < uRows.length; i++) {              

            r_id    = $(uRows[i]).find('input[type="hidden"]').eq(3).val();
            r_line  = $(uRows[i]).find('input[type="hidden"]').eq(2).val();
            r_reg   = $(uRows[i]).find('input[type="hidden"]').eq(6).val();            

            $.map(uploadData, function(val, key) {
                if (val.TENANT_ID == r_id && val.TOKO_ID == r_line && val.REG_ID == r_reg) {
                    
                    $standAkhir = $(uRows[i]).find('input[type="text"]').eq(0);
                    $standAkhir.val(val.STAND_AKHIR);
                    $standAkhir.css('color', 'red');
                }
            });                
        }

        $.ajax({
          type: 'POST',
          data: { 'path': urlExcel },
          url: '<?php echo site_url('gas/gas/deleteExcel');?>',
          dataType: 'json',
          success: function (response) {
             if (response.status === true) {
                $("#xlf").val('');
                alert ('Import Success!');
             }else alert ('Something Went Wrong!');
          }

        });        
      }

      oReq.send();
      
  });


  $.fn.modal.Constructor.prototype.enforceFocus = $.noop;

  var rTable = checkgrid("<?php echo site_url('gas/gas/controler_gridreg')?>","regLoader","trp", 10, [], $('#ibranch'), $('#ibranch'));

  $('#iregion').select2({placeholder: 'Select a Business Unit'});  
  $('#istruk').select2({placeholder: 'Choose Strukturunit ..'});

  $('#ibranch').select2();

  $('#regionSearch').select2({placeholder: 'Select a Business Unit'});

  $('#storeSearch').select2({        
      dropdownCssClass: 'dropdown-store',
      placeholder: 'Select an option',
      minimumInputLength: 2,
      allowClear: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('gas/gas/branch_select')?>',
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

                      return {

                          text: item.branch_name,
                          region_id: item.region_id,
                          id: item.branch_id,
                          region_name: item.region_name
                      }
                  })
              };
          }
      }
  });   

  $('#periodSearch').select2({        
      dropdownCssClass: 'dropdown-period',
      placeholder: 'Select an option',
      ajax: {
          url: '<?php echo site_url('gas/gas/periode_select')?>',
          dataType: 'json',
          processResults: function (data) {
              return {
                  results: $.map(data.items, function (item) {

                      return {

                          text: item.periode_name,                          
                          id: item.periode_id
                      }
                  })
              };
          }
      }
  });   

  $('#storeSearch').on('select2:open', function(e){
      $('.dropdown-store').parent().css('z-index', 99999);
  });

  $('#periodSearch').on('select2:open', function(e){
      $('.dropdown-period').parent().css('z-index', 99999);
  });

  $('#storeSearch').on("select2:select", function(e) {
    var region = e.params.data;
    
    var data = {
      text: region.region_name,
      id: region.region_id
    };     

    var newOption = new Option(data.text, data.id, true, true);
    $('#regionSearch').select2({data: [{id: '', text: ''}]});   
    $('#regionSearch').append(newOption).trigger('change');
    $('#regionSearch_hidden').val(e.params.data.region_id); 
  });

  $("#tabedit").trigger('click');  

  $('#btdetil').click(function() {

      var activetab = $('.detil .active').text();
      switch(activetab) {

          case 'Detail':
              rTable.rows('.selected').deselect();
              $("#redialog").modal("show");             
              break;
      }

  });


  $("#detailTab").on('click','#addBerita',function(){

      var utilitiesID = $('#utilitiesairgas_id').val();   

      if ( utilitiesID == 'auto') {
          return false;
      } 
    
      var file = $(this).closest('tr').find('input[type="file"]').eq(0).prop('files')[0];
      var formData = new FormData();
      var urlUpload = $(this).closest('tr').find('div.link-url a');
      //var urlUpload = $(this).closest('tr').find('td#link-url');           
      var utilitiesLine = $(this).closest('tr').find('input[type="hidden"]').eq(1).val();
      var td = $(this).next("button");     
  
      formData.append('id', utilitiesID);        
      formData.append('line', utilitiesLine);
      formData.append('dfile', file, file.name); 

      var xhr = new XMLHttpRequest();

      xhr.open('POST', '<?php echo site_url('gas/gas/uploadBerita');?>', true);
      xhr.onload = function (e) {
        if (xhr.status === 200) {

          data = JSON.parse(xhr.responseText);
          if (data.files['error'] === '') {
            
            urlUpload.attr("href", '<?php echo base_url('/assets/uploads/');?>'+data.files['url']);
            //$('#d_link_').val(label)
            td.html('&#10004;');
          }else{
            alert(data.files['error']);
            td.html('X');
          }          
        }
      };

      xhr.send(formData);
  });

  $('#addagr').click( function() {

      gData = gTable.rows('.selected').data();    

      aId = gData[0]['id'];
      gLine = gData[0]['line'];      
      
      var uRows = $('#detailTab tbody >tr');
      var uColumns;

      for (var i = 0; i < uRows.length; i++) {  

          uLine = $(uRows[i]).find('td').eq(1).text();

          if (uLine === gLine) {

            $(uRows[i]).find('input[type="text"]').eq(6).val(aId);
          }
                        
      }
  });    

  $('#addreg').click( function() {

      var linenum=0;
      var rData = rTable.rows('.selected').data();

       for (var i=0; i < rData.length; i++){

          var tenantId    = rData[i][1];
          var tenantName  = rData[i][2];
          var brandLine   = rData[i][3];
          var brandName   = rData[i][4];
          var regNo       = rData[i][5];        

          //console.log(brandName);
          //linenum +=1;
          var linenum=0;

          var max=GetDgvLineMaxNum('detailTab', 1);
          linenum= Number(max) + 10;  

          $.ajax({
              type: "GET",
              dataType: "json",
              url: "<?php echo site_url('gas/gas/getTenantbyid'); ?>",
              data: {                  
                  date: $('#utilitiesairgas_date').val(),
                  region: $('#cboregion').val(),
                  branch: $('#ibranch').val(),
                  tenant: tenantId,
                  brand: brandLine
              },              
              success: function (d) {                                                  
                  //oTable.rows.add(d.data);      
                  //console.log(d);
                  var _pressure = d[0].rekananutilitiesgas_pressure;
                  var _mfactor = d[0].rekananutilitiesgas_mfaktor;
                  var _tarif = d[0].utilitiesairgasdetil_harga;

                  addRow(linenum, tenantName, brandName, regNo, _pressure, _mfactor, _tarif);                  

                  $('#d_brandline_'+linenum).val(brandLine);
                  $('#d_tenantid_'+linenum).val(tenantId);
                  $('#d_rekname_'+linenum).val(tenantName);
                  $('#d_rekshop_'+linenum).val(brandName);
                  $('#d_reg_'+linenum).val(regNo);
                  $('#d_descr_'+linenum).val('');              
                  $('#d_standawal_'+linenum).val(d[0].utilitiesairgasdetil_standawal);
                  $('#d_standakhir_'+linenum).val(d[0].utilitiesairgasdetil_standakhir);
                  $('#d_agreement_'+linenum).val(d[0].agreement_id);
                  $('#d_pressure_'+linenum).val(_pressure);
                  $('#d_mfactor_'+linenum).val(_mfactor);
                  $('#d_tarif_'+linenum).val(_tarif);
                  $('#d_administrasi_'+linenum).val(d[0].utilitiesairgasdetil_adm);
                  $('#d_phmeter_'+linenum).val(d[0].rekananutilitiesgas_phmeter);
                  $('#d_materai_'+linenum).val(d[0].utilitiesairgasdetil_materai);
                  $('#d_denda_'+linenum).val(d[0].utilitiesairgasdetil_denda);
                  $('#d_tax_'+linenum).val(d[0].rekananshipping_tax);
                  $('#d_pemakaian_'+linenum).val(d[0].utilitiesairgasdetil_pemakaian);
                  $('#d_pemakaianlalu_'+linenum).val(d[0].utilitiesairgasdetil_pemakaianlalu);
                  $('#d_pemakaianavg_'+linenum).val(d[0].utilitiesairgasdetil_pemakaianavg);   
                  $('#d_conversion_'+linenum).val(d[0].utilitiesairgasdetil_conversionfactor);   
                  $('#d_massalpg_'+linenum).val(d[0].utilitiesairgasdetil_massalpg);

              }
          });           
       }
  });

  $('#btnrek').click(function() {
    var searchTenant  = $("#searchTenant").val();

    rTable.search(searchTenant).draw();
  }); 

  $('#searchTenant').keypress(function (e) {
    var key = e.which;
    if(key == 13)  // the enter key code
    {
      $('#btnrek').click();
      return false;  
    }
  });

  $('#tabedit').click(function() {

    display_modal('Alert!', 'Please, select data from list.');
  }); 

  var gTable = $('#agrLoader').DataTable({      
      "paging": false,
      "ordering": false,     
      "processing": true,
      "columns":[
          { "data": "checked" },
          { "data": "id" },          
          { "data": "debtor" },
          { "data": "virtualacc" },
          { "data": "brand" },
          { "data": "tenant" },
          { "data": "region" },
          { "data": "store" },
          { "data": "start" },
          { "data": "end" },
          { "data": "deduct" },
          { "data": "line" }
      ],
      columnDefs: [{
          orderable: false,
          className: 'select-checkbox',
          targets:   0
      }],
      select: {
          style:    'os',
          selector: 'td:first-child'
      },      
      dom:'t',
      "autoWidth": false
    
  });

  var oTable = $('#detailTab').DataTable({
      "scrollY": "300px",
      "scrollCollapse": true,
      "scrollX": true,
      "paging": false,
      "ordering": false,     
      "processing": true,
      "columns":[
          { "data": "posted", className: "dt-body-center" },          
          { "data": "line" },
          { "data": "tenant" },
          { "data": "brand" },
          { "data": "standakhir" },
          { "data": "standawal" },
          { "data": "pemakaian" },
          { "data": "pemakaianlalu" },
          { "data": "pemakaianavg" },
          { "data": "descr" },
          { "data": "reg" },
          { "data": "agr" },
          { "data": "bagr" },
          { "data": "mfactor", className: "text-right" },
          { "data": "pressure", className: "text-right" },
          { "data": "conversion", className: "text-right" },
          { "data": "massalpg", className: "text-right" },
          { "data": "tarif", className: "text-right" },
          { "data": "jumlah", className: "text-right" },
          { "data": "phmeter", className: "text-right" },
          { "data": "materai" },
          { "data": "denda" },
          { "data": "subtotal", className: "text-right" },
          { "data": "administrasi", className: "text-right" },
          { "data": "total", className: "text-right" },
          { "data": "tax" },
          { "data": "berita"},
          { "data": "link"}
      ],
      dom:'t',
      "autoWidth": false   
  });

  new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 4 } ); 

  /** retrieve grid detil **/
  $.ajax({
      type: "GET",
      dataType: "json",
      url: "<?php echo site_url('gas/gas/griddetil'); ?>",
      data: {
          id: $('#utilitiesairgas_id').val(), 
          date: $('#utilitiesairgas_date').val(),
          region: $('#cboregion').val(),
          branch: $('#ibranch').val() 
      },
      beforeSend: function() {
          $("#loading").show();
      },
      success: function (d) {              
          oTable.clear();
          oTable.rows.add(d.data);                   
          oTable.draw();             
          $("#loading").hide();
      }
  }); 

  $("#detailTab").on('click','#btnDelete',function(){

    var posted = $(this).closest('tr').find('input[type=checkbox]').eq(0).is(':checked');

    if ( posted ) return false;

    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }  
      var deleted = $(this).closest('tr').find('td:eq(1)').text();

      $('#formSave').prepend('<input type="hidden" name="deleted[]" value="'+deleted+'" />');   

      oTable
        .row( $(this).parents('tr') )
        .remove()
        .draw();
  });

  $("#detailTab").on('click','#btnAgr',function(){      

      var posted = $(this).closest('tr').find('input[type=checkbox]').eq(0).is(':checked');
      var gLine = $(this).closest('tr').find('td').eq(1).text();

      //console.log(gLine);
      if ( !posted ) {

          var r_id    = $(this).closest('tr').find('input[type="hidden"]').eq(3).val();
          var r_line  = $(this).closest('tr').find('input[type="hidden"]').eq(2).val();
          var region  = $('#cboregion').val();
          var branch  = $('#ibranch').val();

          gTable.clear().draw();

          $.get("<?php echo site_url('gas/gas/gridagreement'); ?>",
            'rid= '+r_id+
            '&rline= '+r_line+
            '&region= '+region+
            '&branch= '+branch, 
            function(d){
                gTable.clear();
                aData = d.data;
                aData.map( function(a) {
                    a.line = gLine;
                });                
                gTable.rows.add(aData);                
                gTable.draw();
          }, 'json' );        
          
          $("#agdialog").modal("show");
      }      

  });

  $('#recalc').click(function() {    

      oTable.clear().draw();

      var _id = $('#utilitiesairgas_id').val();
      var _date = $('#utilitiesairgas_date').val();
      var _region = $('#cboregion').val();
      var _branch = $('#ibranch').val();

      $.ajax({
          type: "GET",
          dataType: "json",
          url: "<?php echo site_url('gas/gas/recalculate'); ?>",
          data: {
              id: _id, 
              date: _date,
              region: _region,
              branch: _branch 
          },
          beforeSend: function() {
               $("#loading").show();
          },
          success: function (d) {              
              oTable.clear();
              oTable.rows.add(d.data);                   
              oTable.draw();             
              $("#loading").hide();
          }
      }); 

  });

  $.fn.datepicker.defaults.format = "yyyy-mm-dd";
  $.fn.datepicker.defaults.autoclose = true;

  function addRow(ci, tenant, brand, reg_no, pressure, mfactor, tarif) {      

      var linenum=0;

      var max=GetDgvLineMaxNum('detailTab', 1);
      linenum= Number(max) + 10;      

      if (typeof ci === 'undefined') { ci = linenum}

         oTable.rows.add([{
              'posted': '<input type="checkbox" id="posted" disabled>',
              'line':  linenum,
              'tenant': tenant,
              'brand': brand,
              'standakhir': '<input type="text" id="d_standakhir_'+ci+'" name="dstandakhir[]" value="0" class="detil deci form-control input-sm" style= "text-align: right;"/>',
              'standawal': '<input type="text" id="d_standawal_'+ci+'" name="dstandawal[]" value="0" class="detil form-control input-sm" style= "text-align: right;" />',
              'pemakaian': '<input type="text" id="d_pemakaian_'+ci+'" name="dpemakaian[]" value="0" class="detil form-control input-sm" style= "text-align: right;" readonly/>',
              'pemakaianlalu': '<input type="text" id="d_pemakaianlalu_'+ci+'" name="dpemakaianlalu[]" value="0" class="detil form-control input-sm" style= "text-align: right;" readonly/>',
              'pemakaianavg': '<input type="text" id="d_pemakaianavg_'+ci+'" name="dpemakaianavg[]" value="0" class="detil form-control input-sm" style= "text-align: right;" readonly/>',
              'descr': '<input id="d_descr_'+ci+'" type="text" name="ddescr[]" value="" class="pops form-control input-sm"/>'+              
                       '<input id="d_posted_'+ci+'" type="hidden" name="dposted[]" value = 0 >'+
                       '<input id="d_line_'+ci+'" type="hidden" name="dline[]" value="'+ linenum +'"/>'+
                       '<input id="d_brandline_'+ci+'" type="hidden" name="dbrand_line[]" value = 0 >'+
                       '<input id="d_tenantid_'+ci+'" type="hidden" name="dtenant_id[]" value = ""/>'+                       
                       '<input id="d_rekname_'+ci+'" type="hidden" name="drek_name[]" value = ""/>'+
                       '<input id="d_rekshop_'+ci+'" type="hidden" name="drek_shop[]" value = ""/>',
              'reg': reg_no+'<input type="hidden" id="d_reg_'+ci+'" name="dreg[]" value = ""/>',
              'agr': '<input type="text" id ="d_agreement_'+ci+'" name="dagreement[]" value="" class="detil form-control input-sm text-center"/>',
              'bagr': '<a id ="btnAgr" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></a>',
              'mfactor': mfactor+'<input type="hidden" id="d_mfactor_'+ci+'" name="dmfactor[]" value="0"/>',
              'pressure': pressure+ '<input type="hidden" id="d_pressure_'+ci+'" name="dpressure[]" value="0"/>',
              'conversion': 0+'<input type="hidden" id="d_conversion_'+ci+'" name="dconversion[]" value="0"/>',
              'massalpg': 0+'<input type="hidden" id="d_massalpg_'+ci+'" name="dmassalpg[]" value="0"/>',
              'tarif': tarif+ '<input type="hidden" id="d_tarif_'+ci+'" name="dtarif[]" value="0" />',
              'jumlah': 0+'<input type="hidden" id="d_jumlah_'+ci+'" name="djumlah[]" value="0"/>',
              'phmeter': 0+'<input type="hidden" id="d_phmeter_'+ci+'" name="dphmeter[]" value="0"/>',
              'materai': '<input type="text" id="d_materai_'+ci+'" name="dmaterai[]" value="0" class="detil form-control input-sm" style= "text-align: right;"/>',
              'denda': '<input type="text" id="d_denda_'+ci+'" name="ddenda[]" value="0" class="detil form-control input-sm" style= "text-align: right;"/>',
              'subtotal': 0+'<input type="hidden" id="d_subtotal_'+ci+'" name="dsubtotal[]" value="0"/>',
              'administrasi': 0+'<input type="hidden" id="d_administrasi_'+ci+'" name="dadministrasi[]" value="0"/>',
              'total': 0+'<input type="hidden" id="d_total_'+ci+'" name="dtotal[]" value="0"/>',
              'tax': '<input type="text" id="d_tax_'+ci+'" name="dtax[]" value=10 class="detil form-control input-sm" style= "text-align: right;"/>'+
                     '<input type="hidden" id="d_state_'+ci+'" name="dstate[]" value="insert"/>',
              'berita': '<div class="input-group input-group-sm">'+
                          '<label class="input-group-btn">'+
                            '<span class="btn btn-primary">'+
                              '<i class="fa fa-folder-open"></i><input type="file" style="display: none;" id="d_file_'+ci+'" name="dfile">'+
                            '</span>'+
                          '</label>'+
                          '<input id="d_link_'+ci+'" name="dlink[]" type="text" class="form-control" value = "" readonly>'+
                            '<span class="input-group-btn">'+
                              '<button id ="addBerita" type="button" class="btn blue btn-outline btn-sm"><i class="fa fa-cloud-upload"></i></button>'+
                                '<button class="btn blue btn-outline" disabled></button>'+
                            '</span>'+
                        '</div>',                                      
              'link': '<div class="link-url"><a href="javascript:;" class="btn btn-sm green btn-primary" target="_blank"><i class="fa fa-file-text-o"></i> Download</a></div>'
          }]).draw();

  }


});



$(function () { $("input,select").not("[type=submit]").jqBootstrapValidation(); } );

</script>

<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;    
}

#newLoader th, td, label {
    font-size: 9pt;
    white-space: nowrap;
}

#newDetil th, td, label {
    font-size: 9pt;
    white-space: nowrap;
}

.detil {
    padding: 1px;
}

label {
  font-size: 9pt;
  font-weight: bold;
}

.DTFC_LeftBodyLiner {

overflow-x: hidden;

}

.DTFC_RightBodyLiner {

overflow-x: hidden;

}

.dataTables_wrapper {
    font-family: Segoe UI;
    font-size: 10px;    
    position: relative;
    clear: both;
    *zoom: 1;
    zoom: 1;
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

  <!-- /.popup-tenant -->
  <div class="modal fade" id="redialog" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Data Tenant</h4>
        </div>
        <div class="modal-body">
          <form action="#" id="form" class="form-horizontal">
            <div class="row">
              <div class="col-md-8">
                <label>Search Tenant || Brand</label>
                <input  type="text" id="searchTenant" class="form-control input-sm" placeholder="Search Tenant" >
              </div>                           
              <div class="col-md-4" align="right">
                <br>                              
                <button id="btnrek" type="button" class="btn btn-sm btn-primary" style="margin-right: 5px;" >
                <i class="fa fa-history"></i> LOAD
                </button>
              </div>
            </div>
            <div class="portlet-body">
              <div class="table-container">
                <div class="table-scrollable">
                  <table class="table table-striped table-bordered table-hover compact nowrap" id='regLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                    <thead>
                      <tr>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">&nbsp;#</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Brand</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Reg No.</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">M Faktor</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Pressure</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">pH Meter</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tarif</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Adm.(%)</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <br />
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn dark btn-outline" data-dismiss="modal">
            Close
          </button>
          <button type="button" class="btn green" data-dismiss="modal" id="addreg">
            Add Selected Data
          </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <!-- /.popup-agreement -->
  <div class="modal fade" id="agdialog" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">Data Agreement</h4>
        </div>
        <div class="modal-body">          
            <div class="row">
              <div class="col-md-8">
                <label>Search Agreement</label>
                <input  type="text" id="searchAgreement" class="form-control input-sm" placeholder="Search Agreement" >
              </div>                           
              <div class="col-md-4" align="right">
                <br>                              
                <button id="btnrek" type="button" class="btn btn-sm btn-primary" style="margin-right: 5px;" >
                <i class="fa fa-history"></i> LOAD
                </button>
              </div>
            </div>
            <div class="portlet-body">
              <div class="table-container">
                <div class="table-scrollable">
                  <table class="table table-striped table-bordered table-hover compact nowrap" id='agrLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                    <thead>
                      <tr>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Check</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Debt.No</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Virtual Acc.</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Brand</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Region</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Store</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Start</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">End</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Deduct</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">line</th>
                    </thead>
                      </tr>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <br />          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn dark btn-outline" data-dismiss="modal">
            Close
          </button>
          <button type="button" class="btn green" data-dismiss="modal" id="addagr">
            Add Selected Data
          </button>
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
                <a href="<?php echo base_url('index.php/gas/gas/gaslist'); ?>" id='tablist'> LIST </a>
              </li>
              <li>
                <a href="<?php echo base_url('index.php/gas/gas/gasadd'); ?>" id='tabdata'> INPUT </a>
              </li>
              <li>
                <a href="#editdata" data-toggle="tab" id='tabedit'> EDIT </a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane" id="editdata">
                <div class="portlet-body form">
                  <form id="formSave" action="<?php echo site_url('gas/gas/gas_edit');?>" method="post">
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
                              <input  type="text" id="utilitiesairgas_id" name="utilitiesairgas_id" class="form-control input-sm" value="<?php echo $row->utilitiesairgas_id;?>" readonly>
                            </div>
                          </div>                           
                          <div class="col-md-4 form-group row">                                    
                            <div class="col-xs-12">
                              <label>Channel</label>
                              <input id = "channel_id" name="channel_id" class="form-control input-sm" value="<?php echo $row->channel_id;?>" readonly>
                            </div>                                    
                          </div>
                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label>Date</label>
                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control input-sm pull-right" id="utilitiesairgas_date" name="utilitiesairgas_date" value = "<?php echo $row->utilitiesairgas_date;?>" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4 form-group form-group-sm row">
                            <div class="col-xs-12">
                              <label>Store</label>
                                <select id= "ibranch" class="form-control" disabled style="width: 100%" >
                                  <option value="<?php echo $row->branch_id;?>" selected="selected" ><?php echo $row->branch_name.$store;?></option>
                                </select>
                                <input type="hidden" id = "cbobranch" name="cbobranch" value="<?php echo $row->branch_id;?>">
                            </div>
                          </div>
                          <div class="col-md-4 form-group form-group-sm row">
                            <div class="col-xs-12">
                            <label>Business Unit</label>
                              <?php echo form_dropdown('iregion',$region,$row->region_id,'id ="iregion" class="form-control" style="width: 100%;" required disabled '); ?>
                            </div>
                            <input type="hidden" id = "cboregion" name="cboregion" value="<?php echo $row->region_id;?>">
                          </div>
                          <div class="col-md-4 form-group form-group-sm row">
                            <div class="col-xs-12">
                              <label>Strukturunit</label>                                        
                                <?php echo form_dropdown('cbostruktur',$strukturunit,$row->strukturunit_id,'id ="istruk" class="form-control" style="width: 100%;" required '); ?>
                            </div>
                          </div>
                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label>Transaksi</label>
                                <input type="text" id = "transaksi_id" name="transaksi_id" value="<?php echo $row->transaksi_name;?>" class="form-control input-sm" readonly>
                                <input type="hidden" id = "htransaksi" name="htransaksi" value="<?php echo $row->transaksi_id; ?>">
                            </div>                                    
                          </div>                                    
                          <div class="col-md-11 form-group row">
                            <div class="col-xs-12">
                              <label>Description:</label>
                              <textarea id = "utilitiesairgas_descr" name="utilitiesairgas_descr" class="form-control input-sm" rows="2" ><?php echo $row->utilitiesairgas_descr.$descr;?></textarea>
                            </div>                                    
                          </div>               
                          <div class="col-md-12 form-group row">   
                            <br>
                            <div class="col-xs-6">
                              <a href="javascript:void(0)" id="btdetil"><i class="fa fa-plus"></i><strong> Add Row</strong></a>
                            </div>
                          </div>                         
                          <div class="col-md-12">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                              <ul class="detil nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab" role= "tab">Detail</a></li>
                                <li><a href="#tab_2" data-toggle="tab" role = "tab">Record</a></li>
                              </ul>
                              <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                  <div class="col-md-6 form-group row">
                                    <div class="col-md-12 row">
                                      <label>Import /Export Stand Akhir:</label>
                                      <div class="input-group input-group-sm">
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary">
                                                Browse&hellip; <input type="file" style="display: none;" name="kampretFile" id="xlf">
                                            </span>
                                        </label>
                                        <input id="brojo" type="text" class="form-control" readonly>
                                      </div>
                                    </div>
                                  </div>                          
                                  <div class="col-md-6 form-group row"> 
                                    <br>
                                    <button id="upload" type="button" class="btn blue btn-circle btn-outline btn-sm"><i class="fa fa-cloud-upload"></i> Import</button>                                     
                                    <button type="button" class="btn purple btn-circle btn-outline btn-sm" id="recalc"><i class="fa fa-calculator"></i> Recalculate</button>                                    
                                    <button name="button" class="btn green btn-circle btn-outline btn-sm" type="submit" value="EXCEL"><i class="fa fa-cloud-download"></i> Download</button>
                                    <img src="<?php echo base_url('assets/img/broken.gif');?>" id="loading" style="display:none"  width='32px' height='32px'/>                                    
                                  </div>  
                                  <div class ="table-container">                                    
                                    <table class="table table-striped compact nowrap" id='detailTab' style="border:solid 1px #999; #999; border-radius:1px; width:100%">
                                      <thead>
                                        <tr>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Post</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant Name</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Trade</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Stand Akhir</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Stand Awal</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Pemakaian</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Pemakaian[lalu]</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Pemakaian[avg]</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Descr</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Reg</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Agreement Number</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;"></th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">m. Factor</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Pressure(mBar)</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Conv. Factor</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Massa LPG</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tarif</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Jumlah</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">pH Meter</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Materai</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Denda</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Subtotal</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Administrasi</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Total</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">PPN (%)</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Berita Acara Permasalahan </th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">[...]</th>
                                        </tr>
                                      </thead>
                                      <tbody>                                       
                                      </tbody>
                                    </table>                                    
                                  </div>
                                </div>
                                <div class="tab-pane" id="tab_2">
                                  <div class="row">
                                   <div class="col-md-6">
                                    <div class="col-xs-8">
                                       <label>Create By</label>
                                       <input type="text" id= "utilitiesairgas_createby" name="utilitiesairgas_createby" class="form-control input-sm" value="<?php echo $row->utilitiesairgas_createby;?>" readonly>
                                    </div>
                                   </div>
                                   <div class="col-md-6">
                                    <div class="col-xs-8">
                                       <label>Create Date</label>
                                       <input type="text" id="utilitiesairgas_createdate" name="utilitiesairgas_createdate" class="form-control input-sm" value="<?php echo $row->utilitiesairgas_createdate;?>" readonly>
                                    </div>
                                   </div>
                                   <div class="col-md-6">
                                    <div class="col-xs-8">
                                       <label>Modify By</label>
                                       <input type="text" id= "utilitiesairgas_modifyby"  name="utilitiesairgas_modifyby" class="form-control input-sm" value="<?php echo $row->utilitiesairgas_modifyby;?>" readonly>
                                    </div>
                                   </div>
                                   <div class="col-md-6">
                                    <div class="col-xs-8">
                                       <label>Modify Date</label>
                                       <input type="text" id="utilitiesairgas_modifydate" name="utilitiesairgas_modifydate" class="form-control input-sm" value="<?php echo $row->utilitiesairgas_modifydate;?>" readonly>
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
                        <div class="col-xs-12">
                          <br /><input id="btnSave" type="submit" value="SUBMIT" class="btn btn-sm btn-info" />
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