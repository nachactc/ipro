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

    xhr.open('POST', '<?php echo site_url('listrik/listrikdo/uploadExcel');?>', true);
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
        var vd_line;


        for (var i = 0; i < uRows.length; i++) {        

            vd_line = $(uRows[i]).find('input[type="hidden"]').eq(1).val();    
            var fields = vd_line.split('#');     

            r_id    = fields[2];
            r_line  = fields[1];
            r_reg   = $(uRows[i]).find('input[type="hidden"]').eq(2).val();     

            console.log(r_id);
            console.log(r_line);
            console.log(r_reg);

            $.map(uploadData, function(val, key) {
              console.log(val);
                if (val.TENANT_ID == r_id && val.TOKO_ID == r_line && val.REG_ID == r_reg) {

                    var $standAkhir_WBP = $(uRows[i]).find('input[type="text"]').eq(1);
                    var $standAkhir_LWBP = $(uRows[i]).find('input[type="text"]').eq(4);

                    $standAkhir_WBP.val(val.STAND_AKHIR_WBP);
                    $standAkhir_WBP.css('color', 'red');
                    $standAkhir_LWBP.val(val.STAND_AKHIR_LWBP);
                    $standAkhir_LWBP.css('color', 'red');
                }
            });                
        }

        $.ajax({
          type: 'POST',
          data: { 'path': urlExcel },
          url: '<?php echo site_url('listrik/listrikdo/deleteExcel');?>',
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


  $('.deci').number(true, 2);

  $.fn.modal.Constructor.prototype.enforceFocus = $.noop;

  var rTable = checkgrid("<?php echo site_url('listrik/listrikdo/controler_gridreg')?>","regLoader","trp", 10, [], $('#ibranch'), $('#ibranch'));

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
          url: '<?php echo site_url('listrik/listrikdo/branch_select')?>',
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
          url: '<?php echo site_url('listrik/listrikdo/periode_select')?>',
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

      var utilitiesID = $('#utilitieslistrik_id').val();   

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

      xhr.open('POST', '<?php echo site_url('listrik/listrikdo/uploadBerita');?>', true);
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

      var gData = gTable.rows('.selected').data();    

      var aId = gData[0]['id'];
      var gLine = gData[0]['line'];      
      
      var uRows = $('#detailTab tbody >tr');
      var uColumns;

      for (var i = 0; i < uRows.length; i++) {  

          uLine = $(uRows[i]).find('td').eq(1).text();

          if (uLine === gLine) {

            $(uRows[i]).find('input[type="text"]').eq(12).val(aId);
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
              url: "<?php echo site_url('listrik/listrikdo/getTenantbyid'); ?>",
              data: {                  
                  date: $('#utilitieslistrik_date').val(),
                  region: $('#cboregion').val(),
                  branch: $('#ibranch').val(),
                  tenant: tenantId,
                  brand: brandLine
              },              
              success: function (d) {                                                  
                  //oTable.rows.add(d.data);      
                  console.log(d);
                  nilbebabankva = d[0].rekananutilitieslistrik_kva+'#'+d[0].rekananutilitieslistrik_phase+'#'+d[0].rekananutilitieslistrik_faktor+'#'+d[0].rekananutilitieslistrik_bpju+'#'+d[0].rekananutilitieslistrik_admamount+'#'+d[0].rekananutilitieslistrik_admpercent+'#'+d[0].rekananutilitieslistrik_reglimit+'#'+d[0].utilitieslistrikdetil_standawalwbp+'#'+d[0].utilitieslistrikdetil_standawallwbp;
                  addRow(linenum, tenantId, brandLine, tenantName, brandName, regNo, nilbebabankva);                  
                  $('#d_brandline_'+linenum).val(brandLine);
                  $('#d_tenantid_'+linenum).val(tenantId);
                  $('#d_rekname_'+linenum).val(tenantName);
                  $('#d_rekshop_'+linenum).val(brandName);
                  $('#d_reg_'+linenum).val(regNo);
                  $('#d_descr_'+linenum).val('');              
                  $('#d_phase_'+linenum).val(d[0].rekananutilitieslistrik_phase);
                  //$('#d_bebankva_'+linenum).val(d[0].rekananutilitieslistrik_kva);
                  $('#d_faktor_'+linenum).val(d[0].rekananutilitieslistrik_faktor);
                  $('#d_standawalwbp_'+linenum).val(d[0].utilitieslistrikdetil_standawalwbp);
                  $('#d_standawallwbp_'+linenum).val(d[0].utilitieslistrikdetil_standawallwbp);
                  $('#d_wbptotal_'+linenum).val(d[0].utilitieslistrikdetil_wbptotal);
                  $('#d_lwbptotal_'+linenum).val(d[0].utilitieslistrikdetil_lwbptotal);
                  $('#d_tarifwbp_'+linenum).val(d[0].utilitieslistrikdetil_tarifwbp);
                  $('#d_tariflwbp_'+linenum).val(d[0].utilitieslistrikdetil_tariflwbp);
                  $('#d_selisihwbplalu_'+linenum).val(d[0].utilitieslistrikdetil_selisihwbplalu);
                  $('#d_selisihlwbplalu_'+linenum).val(d[0].utilitieslistrikdetil_selisihlwbplalu);
                  $('#d_selisihwbpavg_'+linenum).val(d[0].utilitieslistrikdetil_selisihwbpavg);
                  $('#d_selisihlwbpavg_'+linenum).val(d[0].utilitieslistrikdetil_selisihlwbpavg);
                  $('#d_agreement_'+linenum).val(d[0].agreement_id);     
              }
          });           
       }
  });

  $('#btnrek').click(function() {
    var searchTenant  = $("#searchTenant").val();

    rTable.search(searchTenant).draw();
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
          { "data": "standawallwbp" },
          { "data": "standakhirlwbp" },
          { "data": "selisihlwbp" },
          { "data": "standawalwbp" },          
          { "data": "standakhirwbp" },
          { "data": "selisihwbp" },
          { "data": "selisihwbplalu" },
          { "data": "selisihlwbplalu" },
          { "data": "selisihwbpavg" },
          { "data": "selisihlwbpavg" },
          { "data": "adjustment"},
          { "data": "descr" },
          { "data": "reg" },
          { "data": "agr" },
          { "data": "bagr" },
          { "data": "amp" },          
          { "data": "bkva", className: "text-right" },
          { "data": "phase", className: "text-right"},
          { "data": "faktor", className: "text-right" },
          { "data": "bpjumaster", className: "text-right" },
          { "data": "admamountmaster", className: "text-right" },
          { "data": "admpercentmaster", className: "text-right" },
          { "data": "reglimitmaster", className: "text-right" },
          { "data": "wbptotal", className: "text-right"},
          { "data": "lwbptotal", className: "text-right" },
          { "data": "pemakaianwbp" },
          { "data": "pemakaianlwbp" },
          { "data": "tarifwbp" },
          { "data": "tariflwbp" },
          { "data": "biayawbp", className: "text-right" },
          { "data": "biayalwbp", className: "text-right" },
          { "data": "biaya", className: "text-right" },
          { "data": "bpju", className: "text-right" },
          { "data": "tagihan", className: "text-right" },
          { "data": "denda" },
          { "data": "administrasi", className: "text-right" },
          { "data": "pemeliharaan", className: "text-right" },
          { "data": "jumlah", className: "text-right" },
          { "data": "tax"},
          { "data": "berita"},
          { "data": "link"}
      ],
      dom:'t',
      "autoWidth": false
      /*buttons: [
        { 
            extend: 'excel',
            exportOptions: {
              columns: [2, 3, 21]
            }
        }
      ]
      */
    
  });

  new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 4 } ); 

  /** retrieve grid detil **/
  $.ajax({
      type: "GET",
      dataType: "json",
      url: "<?php echo site_url('listrik/listrikdo/griddetil'); ?>",
      data: {
          id: $('#utilitieslistrik_id').val(), 
          date: $('#utilitieslistrik_date').val(),
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

          $.get("<?php echo site_url('listrik/listrikdo/gridagreement'); ?>",
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

      var _id = $('#utilitieslistrik_id').val();
      var _date = $('#utilitieslistrik_date').val();
      var _region = $('#cboregion').val();
      var _branch = $('#ibranch').val();

      $.ajax({
          type: "GET",
          dataType: "json",
          url: "<?php echo site_url('listrik/listrikdo/recalculate'); ?>",
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

  function addRow(ci, tID, bID, tName, bName, reg_no, nilbebabankva) {      

      var linenum=0;

      var max=GetDgvLineMaxNum('detailTab', 1);
      linenum= Number(max) + 10;      

      if (typeof ci === 'undefined') { ci = linenum}

        nildline = linenum+'#'+bID+'#'+tID+'#'+tName+'#'+bName;        

         oTable.rows.add([{
              'posted': '<input type="checkbox" id="posted" disabled>',
              'line':  linenum,
              'tenant': tName,
              'brand': bName,                            
              'standawallwbp': '<input type="text" id="d_standawallwbp_'+ci+'" name="dstandawallwbp[]" value="0" class="detil form-control input-sm"  style= "text-align: right;" readonly/>',              
              'standakhirlwbp': '<input type="text" id="d_standakhirlwbp_'+ci+'" name="dstandakhirlwbp[]" value="0" class="detil form-control input-sm"  style= "text-align: right;"/>',
              'selisihlwbp': '<input type="text" id="d_selisihlwbp_'+ci+'" name="dselisihlwbp[]" value="0" class="detil form-control input-sm" style= "text-align: right;" readonly/>',              
              'standawalwbp': '<input type="text" id="d_standawalwbp_'+ci+'" name="dstandawalwbp[]" value="0" class="detil form-control input-sm"  style= "text-align: right;" readonly/>',
              'standakhirwbp': '<input type="text" id="d_standakhirwbp_'+ci+'" name="dstandakhirwbp[]" value="0" class="detil form-control input-sm"  style= "text-align: right;"/>',
              'selisihwbp': '<input type="text" id="d_selisihwbp_'+ci+'" name="dselisihwbp[]" value="0" class="detil form-control input-sm" style= "text-align: right;" readonly/>',              
              'selisihwbplalu': '<input type="text" id="d_selisihwbplalu_'+ci+'" name="dselisihwbplalu[]" value="0" class="detil form-control input-sm" style= "text-align: right;" readonly/>',
              'selisihlwbplalu': '<input type="text" id="d_selisihlwbplalu_'+ci+'" name="dselisihlwbplalu[]" value="0" class="detil form-control input-sm" style= "text-align: right;" readonly/>',
              'selisihwbpavg': '<input type="text" id="d_selisihwbpavg_'+ci+'" name="dselisihwbpavg[]" value="0" class="detil form-control input-sm" style= "text-align: right;" readonly/>',                                      
              'selisihlwbpavg': '<input type="text" id="d_selisihlwbpavg_'+ci+'" name="dselisihlwbpavg[]" value="0" class="detil form-control input-sm" style= "text-align: right;" readonly/>',
              'adjustment': '<input type="text" id="d_adjust_'+ci+'" name="dadjust[]" value="0" class="detil deci form-control input-sm" style= "text-align: right;"/>',
              'descr': '<input id="d_descr_'+ci+'" type="text" name="ddescr[]" value="" class="pops form-control input-sm"/>'+              
                       '<input id="d_posted_'+ci+'" type="hidden" name="dposted[]" value = 0 >'+
                       '<input id="d_line_'+ci+'" type="hidden" name="dline[]" value="'+ nildline +'"/>',
              'reg': reg_no+'<input type="hidden" id="d_reg_'+ci+'" name="dreg[]" value = ""/>',
              'agr': '<input type="text" id ="d_agreement" name="dagreement[]" value="" class="form-control input-sm text-center"/>',
              'bagr': '<a id ="btnAgr" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></a>',
              'amp': '<input type="text" id="d_amp_'+ci+'" name="damp[]" value="0" class="detil form-control input-sm"  style= "text-align: right;"/>',
              'bkva': 0+'<input type="hidden" id="d_bebankva_'+ci+'" name="dbebankva[]" value="'+nilbebabankva+'"/>',
              'phase': 0+'<input type="hidden" id="d_phase_'+ci+'" name="dphase[]" value="0"/>',              
              'faktor': 0,
              'bpjumaster':0,
              'admamountmaster':0,
              'admpercentmaster':0,
              'reglimitmaster':0,
              'wbptotal': 1+'<input type="hidden" id="d_wbptotal'+ci+'" name="dwbptotal[]" value="0"/>',
              'lwbptotal': 1+'<input type="hidden" id="d_lwbptotal'+ci+'" name="dlwbptotal[]" value="0"/>',
              'pemakaianwbp': '<input type="text" id="d_pemakaianwbp_'+ci+'" name="dpemakaianwbp[]" value="0" class="detil form-control input-sm" style= "text-align: right;"/>',
              'pemakaianlwbp': '<input type="text" id="d_pemakaianlwbp_'+ci+'" name="dpemakaianlwbp[]" value="0" class="detil form-control input-sm" style= "text-align: right;"/>',
              'tarifwbp': '<input type="text" id="d_tarifwbp_'+ci+'" name="dtarifwbp[]" value="0" class="detil form-control input-sm" style= "text-align: right;" readonly/>',
              'tariflwbp': '<input type="text" id="d_tariflwbp_'+ci+'" name="dtariflwbp[]" value="0" class="detil form-control input-sm" style= "text-align: right;" readonly/>',
              'biayawbp': 0+'<input type="hidden" id="d_biayawbp_'+ci+'" name="dbiayawbp[]" value="0"/>',
              'biayalwbp': 0+'<input type="hidden" id="d_biayalwbp_'+ci+'" name="dbiayalwbp[]" value="0"/>',
              'biaya': 0+'<input type="hidden" id="d_biaya_'+ci+'" name="dbiaya[]" value="0"/>',
              'bpju': 0+'<input type="hidden" id="d_bpju_'+ci+'" name="dbpju[]" value="0"/>',
              'tagihan': 0+'<input type="hidden" id="d_tagihan_'+ci+'" name="dtagihan[]" value="0"/>',
              'denda': '<input type="text" id="d_denda_'+ci+'" name="ddenda[]" value="0" class="detil form-control input-sm" style= "text-align: right;"/>',
              'administrasi': 0+'<input type="hidden" id="d_administrasi_'+ci+'" name="dadministrasi[]" value="0"/>',
              'pemeliharaan': 0+'<input type="hidden" id="d_pemeliharaan_'+ci+'" name="dpemeliharaan[]" value="0"/>',
              'jumlah': 0+'<input type="hidden" id="d_jumlah_'+ci+'" name="djumlah[]" value="0"/>',
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
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">KVA</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Adm.(%)</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">BPJU</th>
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
                <a href="<?php echo base_url('index.php/listrik/listrikdo/listriklist'); ?>" id='tablist'> LIST </a>
              </li>
              <li>
                <a href="<?php echo base_url('index.php/listrik/listrikdo/listrikadd'); ?>" id='tabdata'> INPUT </a>
              </li>
              <li>
                <a href="#editdata" data-toggle="tab" id='tabedit'> EDIT </a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane" id="editdata">
                <div class="portlet-body form">
                  <form id="formSave" action="<?php echo site_url('listrik/listrikdo/listrik_edit');?>" method="post">
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
                              <input  type="text" id="utilitieslistrik_id" name="utilitieslistrik_id" class="form-control input-sm" value="<?php echo $row->utilitieslistrik_id;?>" readonly>
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
                                <input type="text" class="form-control input-sm pull-right" id="utilitieslistrik_date" name="utilitieslistrik_date" value = "<?php echo $row->utilitieslistrik_date;?>" readonly>
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
                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label>WBP Gedung</label>
                                <input type="text" id = "utilitieslistrik_wbpgedung" name="utilitieslistrik_wbpgedung" value="<?php echo $row->utilitieslistrik_wbpgedung;?>" class="deci form-control input-sm" style="text-align: right;">
                            </div>                                    
                          </div> 
                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label>LWBP Gedung</label>
                                <input type="text" id = "utilitieslistrik_lwbpgedung" name="utilitieslistrik_lwbpgedung" value="<?php echo $row->utilitieslistrik_lwbpgedung;?>" class="deci form-control input-sm" style="text-align: right;">
                            </div>                                    
                          </div>                           
                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label>Description:</label>
                              <textarea id = "utilitieslistrik_descr" name="utilitieslistrik_descr" class="form-control input-sm" rows="2" ><?php echo $row->utilitieslistrik_descr.$descr;?></textarea>
                            </div>                                    
                          </div> 
                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label>Tarif WBP</label>
                                <input type="text" id = "utilitieslistrik_wbptarif" name="utilitieslistrik_wbptarif" value="<?php echo $row->utilitieslistrik_wbptarif;?>" class="deci form-control input-sm" style="text-align: right;">
                            </div>                                    
                          </div>  
                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label>Tarif LWBP</label>
                                <input type="text" id = "utilitieslistrik_lwbptarif" name="utilitieslistrik_lwbptarif" value="<?php echo $row->utilitieslistrik_lwbptarif;?>" class="deci form-control input-sm" style="text-align: right;">
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
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Awal LWBP</th>                                            
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Akhir LWBP</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Selisih LWBP</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Awal WBP</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Akhir WBP</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Selisih WBP</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Selisih WBP[lalu]</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Selisih LWBP[lalu]</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Selisih WBP[avg]</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Selisih LWBP[avg]</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Adjustment</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Descr</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Reg</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Agreement Number</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;"></th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Ampere</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Beban KVA</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Phase</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">F.Meter</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">BPJU</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Adm.</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Adm (%)</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Reg Limit</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">WBP Gdg</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">LWBP Gdg</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Pakai WBP</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Pakai LWBP</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tarif WBP</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tarif LWBP</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Biaya WBP</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Biaya LWBP</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Biaya</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">BPJU</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tagihan</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Denda (Rp)</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Administrasi</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Pemeliharaan</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Jumlah</th>
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
                                       <input type="text" id= "utilitieslistrik_createby" name="utilitieslistrik_createby" class="form-control input-sm" value="<?php echo $row->utilitieslistrik_createby;?>">
                                    </div>
                                   </div>
                                   <div class="col-md-6">
                                    <div class="col-xs-8">
                                       <label>Create Date</label>
                                       <input type="text" id="utilitieslistrik_createdate" name="utilitieslistrik_createdate" class="form-control input-sm" value="<?php echo $row->utilitieslistrik_createdate;?>">
                                    </div>
                                   </div>
                                   <div class="col-md-6">
                                    <div class="col-xs-8">
                                       <label>Modify By</label>
                                       <input type="text" id= "utilitieslistrik_modifyby"  name="utilitieslistrik_modifyby" class="form-control input-sm" value="<?php echo $row->utilitieslistrik_modifyby;?>">
                                    </div>
                                   </div>
                                   <div class="col-md-6">
                                    <div class="col-xs-8">
                                       <label>Modify Date</label>
                                       <input type="text" id="utilitieslistrik_modifydate" name="utilitieslistrik_modifydate" class="form-control input-sm" value="<?php echo $row->utilitieslistrik_modifydate;?>">
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