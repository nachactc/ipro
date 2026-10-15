<script src="<?php echo base_url('assets/jsinternal/xlsx.full.min.js');?>" type="text/javascript"></script>
<script> 

$(document).ready(function(){  

  var tenantTable=popgrid("<?php echo site_url('pajakkeluaran/pajakkeluaran/controler_gridtenant')?>","popLoader","trp", 10);
  var regionTable=popgrid("<?php echo site_url('pajakkeluaran/pajakkeluaran/controler_gridregion')?>","regionLoader","trp", 10);
  var branchTable=popgrid("<?php echo site_url('pajakkeluaran/pajakkeluaran/controler_gridbranch')?>","branchLoader","trp", 10);
  var brandTable=popgrid("<?php echo site_url('pajakkeluaran/pajakkeluaran/controler_gridbrand')?>","brandLoader","trp", 10);
  var agrtypeTable=popgrid("<?php echo site_url('pajakkeluaran/pajakkeluaran/controler_gridagrtype')?>","agrtypeLoader","trp", 10);

  $('#bttenant').click(function() {
    var search  = $("#hbranch").val();
    tenantTable.search(search).draw();
    //tenantTable.rows('.selected').deselect();
    $("#tedialog").modal("show");
  });

  $('#btregion').click(function() {
    regionTable.rows('.selected').deselect();
    $("#regiondialog").modal("show");
  });

  $('#btbranch').click(function() {

    var search  = $("#hregion").val();
    branchTable.search(search).draw();
    //branchTable.rows('.selected').deselect();
    $("#storedialog").modal("show");
  });

  $('#btbrand').click(function() {
    var search  = $("#htenant").val();
    brandTable.search(search).draw();
    //brandTable.rows('.selected').deselect();
    $("#branddialog").modal("show");
  });

  $('#btagrtype').click(function() {
    agrtypeTable.rows('.selected').deselect();
    $("#agrtypedialog").modal("show");
  });
  
  $('#addtenant').click(function () {
      var linenum=0;
       var rData = tenantTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid     = rData[i][0];
          var tname   = rData[i][1];

          $('#htenant').val(tid);
          $('#itenant').val(tname);

          $('#hbrand').val('');
          $('#ibrand').val('');
          $('#hagrtype').val('');
          $('#iagrtype').val('');
      }
  });

  $('#addregion').click(function () {
      var linenum=0;
       var rData = regionTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid     = rData[i][0];
          var tname   = rData[i][1];

          $('#hregion').val(tid);
          $('#iregion').val(tname);

          $('#hbranch').val('');
          $('#ibranch').val('');
          $('#htenant').val('');
          $('#itenant').val('');
          $('#hbrand').val('');
          $('#ibrand').val('');
          $('#hagrtype').val('');
          $('#iagrtype').val('');
      }
  });

  $('#addstore').click(function () {
      var linenum=0;
       var rData = branchTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid     = rData[i][0];
          var tname   = rData[i][1];

          $('#hbranch').val(tid);
          $('#ibranch').val(tname);

          $('#htenant').val('');
          $('#itenant').val('');
          $('#hbrand').val('');
          $('#ibrand').val('');
          $('#hagrtype').val('');
          $('#iagrtype').val('');
      }
  });

  $('#addbrand').click(function () {
      var linenum=0;
       var rData = brandTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid     = rData[i][0];
          var tname   = rData[i][1];

          $('#hbrand').val(tid);
          $('#ibrand').val(tname);
      }
  });

  $('#addagrtype').click(function () {
      var linenum=0;
       var rData = agrtypeTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid     = rData[i][0];
          var tname   = rData[i][1];

          $('#hagrtype').val(tid);
          $('#iagrtype').val(tname);
      }
  });

  $('#btnrek').click(function() {
      var searchTenant  = $("#searchTenant").val();
	  var searchBranch  = $("#hbranch").val();

	  tenantTable.search('');
      tenantTable.column(0).search(searchTenant);
      tenantTable.column(1).search(searchBranch);
      tenantTable.draw();
      
    });

    $('#btnregion').click(function() {
        var search  = $("#searchRegion").val();

        regionTable.search(search).draw();
      });

    $('#btnstore').click(function() {
        var search  = $("#searchStore").val();
        branchTable.search(search).draw();
      });

    $('#btnbrand').click(function() {
        var search  = $("#searchbrand").val();
      brandTable.search(search).draw();
      });

    $('#btnagrtype').click(function() {
        var search  = $("#searchagrtype").val();
      agrtypeTable.search(search).draw();
      });




      $('#cbunit').change(function(){
        if($(this).is(':checked')){
            $('#btregion').prop('disabled',false);
        } else {
            //alert('not checked');
            //$('#iregion').prop('readonly',false);
            $('#btregion').prop('disabled',true);
            $('#hregion').val('');
            $('#iregion').val('');
        }
      })

      $('#cbranch').change(function(){
        if($(this).is(':checked')){
            $('#btbranch').prop('disabled',false);
        } else {
            $('#btbranch').prop('disabled',true);
            $('#hbranch').val('');
            $('#ibranch').val('');
        }
      })
      $('#ctenant').change(function(){
        if($(this).is(':checked')){
            $('#bttenant').prop('disabled',false);
        } else {
            $('#bttenant').prop('disabled',true);
            $('#htenant').val('');
            $('#itenant').val('');
        }
      })
      $('#cbrand').change(function(){
        if($(this).is(':checked')){
            $('#btbrand').prop('disabled',false);
        } else {
            $('#btbrand').prop('disabled',true);
            $('#hbrand').val('');
            $('#ibrand').val('');
        }
      })
      $('#cagrtype').change(function(){
        if($(this).is(':checked')){
            $('#btagrtype').prop('disabled',false);
        } else {
            $('#btagrtype').prop('disabled',true);
            $('#hagrtype').val('');
            $('#iagrtype').val('');
        }
      })
      $('#cstartdate').change(function(){
        if($(this).is(':checked')){
			//$('#istartdate').val('1');
        } else {
            $('#istartdate').val('');
        }
      })
	  $('#cenddate').change(function(){
        if($(this).is(':checked')){
			//$('#ienddate').val('1');
        } else {
            $('#ienddate').val('');
        }
      })
      $('#cperiodeend').change(function(){
        if($(this).is(':checked')){

        } else {
            $('#iperiodeend').val('');
        }
      })
      $('#cproforma').change(function(){
        if($(this).is(':checked')){

        } else {
            $('#iproforma').val('');
        }
      })
      $('#cfakturnofrom').change(function(){
        if($(this).is(':checked')){
            $('#ifakturnofrom').prop('readonly',false);
			$('#ifakturnoend').prop('readonly',false);
			$('#cfakturnoend').prop('checked',true);
        } else {
            $('#ifakturnofrom').prop('readonly',true);
			$('#ifakturnoend').prop('readonly',true);
			$('#cfakturnoend').prop('checked',false);
        }
      })
      $('#cfakturnoend').change(function(){
        if($(this).is(':checked')){
            $('#ifakturnofrom').prop('readonly',false);
			$('#ifakturnoend').prop('readonly',false);
			$('#cfakturnoend').prop('checked',true);
        } else {
            $('#ifakturnofrom').prop('readonly',true);
			$('#ifakturnoend').prop('readonly',true);
			$('#cfakturnoend').prop('checked',false);
        }
      })
      $('#cseparator').change(function(){
        if($(this).is(':checked')){
            $('#iseparator').prop('readonly',false);
        } else {
            $('#iseparator').prop('readonly',true);
        }
      })	
	  $('#cprefix').change(function(){
        if($(this).is(':checked')){
            $('#iprefix').prop('readonly',false);
        } else {
            $('#iprefix').prop('readonly',true);
        }
      })  

  var urlExcel = '';

  $('#xlf').on('change', function() { 
    
    var file = $(this).prop('files')[0];
    var formData = new FormData();

    var label = $(this).val().replace(/\\/g, '/').replace(/.*\//, '');

    $('#brojo').val(label);

    formData.append('kampretFile', file, file.name);     

    var xhr = new XMLHttpRequest();

    xhr.open('POST', '<?php echo site_url('downloadpajak/downloadpajak/uploadExcel');?>', true);
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

                    //$(uRows[i]).find('input[type="text"]').eq(4).val(val.STAND_AKHIR);
                    $standAkhir = $(uRows[i]).find('input[type="text"]').eq(0);
                    $standAkhir.val(val.STAND_AKHIR);
                    $standAkhir.css('color', 'red');
                }
            });                
        }

        $.ajax({
          type: 'POST',
          data: { 'path': urlExcel },
          url: '<?php echo site_url('downloadpajak/downloadpajak/deleteExcel');?>',
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

  var rTable = checkgrid("<?php echo site_url('downloadpajak/downloadpajak/controler_gridreg')?>","regLoader","trp", 10, [], $('#ibranch'), $('#ibranch'));
  var fTable = $('#fLoader').DataTable(); 

  //$('#iregion').select2({placeholder: 'Select a Business Unit'});  
  //$('#istruk').select2({placeholder: 'Choose Strukturunit ..'});

  //$('#ibranch').select2();

  //$('#regionSearch').select2({placeholder: 'Select a Business Unit'});

  $('#storeSearch').select2({        
      dropdownCssClass: 'dropdown-store',
      placeholder: 'Select an option',
      minimumInputLength: 2,
      allowClear: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('downloadpajak/downloadpajak/branch_select')?>',
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
          url: '<?php echo site_url('downloadpajak/downloadpajak/periode_select')?>',
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

  $('#btncalc').click(function() {   
      fTable.destroy();
      fTable= checkgrid("<?php echo site_url('downloadpajak/downloadpajak/controler_gridformula')?>","fLoader","trp", 10, [], $('#ibranch'), $('#ibranch'));    
      rTable.rows().deselect(); 

      $("#fdialog").modal("show");    
  });

  $('#addformula').click(function () {

      var fData = fTable.rows('.selected').data();
      //console.log(fData);
      for (var i=0; i < fData.length ;i++){

        var f_id       = fData[i][1];
        //var f_name     = fData[i][1];        
        $('#utilitiesairgas_calcmethodid').val(f_id);
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

      xhr.open('POST', '<?php echo site_url('downloadpajak/downloadpajak/uploadBerita');?>', true);
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

            $(uRows[i]).find('input[type="text"]').eq(3).val(aId);
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
              url: "<?php echo site_url('downloadpajak/downloadpajak/getTenantbyid'); ?>",
              data: {                  
                  date: $('#utilitiesairgas_date').val(),
                  region: $('#cboregion').val(),
                  branch: $('#ibranch').val(),
                  tenant: tenantId,
                  brand: brandLine,
                  calcid: $('#utilitiesairgas_calcmethodid').val()
              },              
              success: function (d) {                                                  
                  //oTable.rows.add(d.data);      
                  //console.log(d[0].rekanan_id);                  
                  addRow(linenum, tenantName, brandName, regNo);                  
                  $('#d_brandline_'+linenum).val(brandLine);
                  $('#d_tenantid_'+linenum).val(tenantId);
                  $('#d_rekname_'+linenum).val(tenantName);
                  $('#d_rekshop_'+linenum).val(brandName);
                  $('#d_reg_'+linenum).val(regNo);
                  $('#d_descr_'+linenum).val('');              
                  $('#d_pipa_'+linenum).val(d[0].utilitiesairgasdetil_diameterpipa);
                  $('#d_blok1_'+linenum).val(d[0].utilitiesairgasdetil_spec1meter);
                  $('#d_tarifb1_'+linenum).val(d[0].utilitiesairgasdetil_spec1tarif);
                  $('#d_totalb1_'+linenum).val(d[0].utilitiesairgasdetil_spec1amount);
                  $('#d_blok2_'+linenum).val(d[0].utilitiesairgasdetil_spec2meter);
                  $('#d_tarifb2_'+linenum).val(d[0].utilitiesairgasdetil_spec2tarif);
                  $('#d_totalb2_'+linenum).val(d[0].utilitiesairgasdetil_spec2amount);
                  $('#d_blok3_'+linenum).val(d[0].utilitiesairgasdetil_spec3meter);
                  $('#d_tarifb3_'+linenum).val(d[0].utilitiesairgasdetil_spec3tarif);
                  $('#d_totalb3_'+linenum).val(d[0].utilitiesairgasdetil_spec3amount);
                  $('#d_blok4_'+linenum).val(d[0].utilitiesairgasdetil_spec4meter);
                  $('#d_tarifb4_'+linenum).val(d[0].utilitiesairgasdetil_spec4tarif);
                  $('#d_totalb4_'+linenum).val(d[0].utilitiesairgasdetil_spec4amount);
                  $('#d_totalpakai_'+linenum).val(d[0].utilitiesairgasdetil_specamounttotal);
                  $('#d_pelihara_'+linenum).val(d[0].utilitiesairgasdetil_pemeliharaan);
                  $('#d_phairkotor_'+linenum).val(d[0].utilitiesairgasdetil_phairkotor);
                  $('#d_phmeter_'+linenum).val(d[0].utilitiesairgasdetil_phmeter);
                  $('#d_pemakaian_'+linenum).val(d[0].utilitiesairgasdetil_pemakaian);
                  $('#d_pemakaianlalu_'+linenum).val(d[0].utilitiesairgasdetil_pemakaianlalu);
                  $('#d_pemakaianavg_'+linenum).val(d[0].utilitiesairgasdetil_pemakaianavg);
                  $('#d_standawal_'+linenum).val(d[0].utilitiesairgasdetil_standawal);
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
          { "data": "A" },
		  { "data": "B" },
		  { "data": "C" },
		  { "data": "D" },
		  { "data": "E" },
		  { "data": "F" },
		  { "data": "G" },
		  { "data": "H" },
		  { "data": "I" },
		  { "data": "J" },
		  { "data": "K" },
		  { "data": "L" },
		  { "data": "M" },
		  { "data": "N" },
		  { "data": "O" },
		  { "data": "P" },
		  { "data": "Q" },
		  { "data": "R" },
		  { "data": "S" },
		  { "data": "nom" },
      ],
      dom:'t',
      "autoWidth": false   
  });
  /** retrieve grid detil **/
  
  $.ajax({
      type: "GET",
      dataType: "json",
      url: "<?php echo site_url('downloadpajak/downloadpajak/griddetil'); ?>",
      data: {
          id: $('#utilitiesairgas_id').val(), 
          date: $('#utilitiesairgas_date').val(),
          region: $('#cboregion').val(),
          branch: $('#ibranch').val(), 
          calc: $('#utilitiesairgas_calcmethodid').val()
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

          $.get("<?php echo site_url('downloadpajak/downloadpajak/gridagreement'); ?>",
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
   $('#btnsave2').click(function() {
	$("#loading").show();
   });
    $('#btnsave').click(function() {
	
	$("#loading").show();
	$("#btnload").hide();
	$("#btnsave").hide();
	$("#btnexport").hide();
	
	console.log('loading');
	// return;
	var url = "<?= site_url('downloadpajak/downloadpajak/insert2table');?>";
	var urldelete = "<?= site_url('downloadpajak/downloadpajak/deletetable');?>";
	//delete table
	var ID ='';
	var ajax = $.post( urldelete, { ID: ID} )
		.done(function(e){
			//var obj = $.parseJSON(pesan);
			//console.log(obj.pesan);					
		}, 'json');
		
	
		
        var rData = oTable.rows('.selected').data();		
		
        var sproformadate= $("#iproformadate").val();
		

//insert2table
	var table = $("#detailTab tbody");
	var clsA=""; 
	
	table.find('tr').each(function (i) {
	const  postid = [];
    var pRow = [];
	var $row = $(this).closest("tr"); 
	clsA= $row.find(".A").val();
	//clsA= clsA.replace(/,/g, "");
	pRow[0]= $row.find(".A").val();
	pRow[1]= $row.find(".B").val();
	pRow[2]= $row.find(".C").val();
	pRow[3]= $row.find(".D").val();
	pRow[4]= $row.find(".E").val();
	pRow[5]= $row.find(".F").val();
	pRow[6]= $row.find(".G").val();
	pRow[7]= $row.find(".H").val();
	pRow[8]= $row.find(".I").val();
	pRow[9]= $row.find(".J").val();
	pRow[10]= $row.find(".K").val();
	pRow[11]= $row.find(".L").val();
	pRow[12]= $row.find(".M").val();
	pRow[13]= $row.find(".N").val();
	pRow[14]= $row.find(".O").val();
	pRow[15]= $row.find(".P").val();
	pRow[16]= $row.find(".Q").val();
	pRow[17]= $row.find(".R").val();
	pRow[18]= $row.find(".S").val();
	pRow[19]= $row.find(".nom").val();
	postid.push(pRow);  
	pRow = [];
	       
	
        grab ={};
        grab['postid'] = postid;

		
        $.ajax({
			
           url      : "<?php echo site_url('downloadpajak/downloadpajak/insert2table');?>",
           type     : "POST",
		   dataType : 'json',
           data     : grab,
		   beforeSend: function() {
               $("#loading").show();
			},
           
           success: function(e) {              			
              if (e.success){                

				 // alert('DONE');
				  //$("#loading").hide();
 

              }
			else
			{
				//alert(e.data);
				// alert('DONE');
				// console.log(e.data.text);
 				$("#loading").hide();
			}
           },
           error: function(xhr) {              
                if (xhr.status == 500) {                      
                  // alert('Internal error.');
				  // $("#loading").hide();
                } else {
                     
					// alert('DONE');
					// $("#loading").hide();
					
                }                 
           }          
        });
	});
	//alert('DONE');
	
	setTimeout(function(){ 
		alert("DONE"); 
		$("#loading").hide();
		$("#btnload").show();
		$("#btnsave").show();
		$("#btnexport").show();
		}, 120000
	);
	// $("#loading").hide();
  });
  
  $('#btnsave_').click(function() {
	$("#loading").show();
	var urldelete = "<?= site_url('downloadpajak/downloadpajak/deletetable');?>";
	var url = "<?= site_url('downloadpajak/downloadpajak/insert2table');?>";
	//delete table
	var ID ='';
	var ajax = $.post( urldelete, { ID: ID} )
		.done(function(pesan){
			var obj = $.parseJSON(pesan);
			//console.log(obj.pesan);					
		}, 'json');	
	
	oTable.rows().select();
	var lastnom = "";
	var lastrownom = "";
	//cari nom terakhir
	var table2 = $("#detailTab tbody");
	
	table2.find('tr').each(function (i) {
	var $row = $(this).closest("tr"); 	
	lastnom= $row.find(".nom").val(); 
	});
	
	//insert2table
	var table = $("#detailTab tbody");
	var clsA="";
	table.find('tr').each(function (i) {
	var $row = $(this).closest("tr"); 
	clsA= $row.find(".A").val();
	//clsA= clsA.replace(/,/g, "");
	clsA= $row.find(".A").val();
	clsB= $row.find(".B").val();
	clsC= $row.find(".C").val();
	clsD= $row.find(".D").val();
	clsE= $row.find(".E").val();
	clsF= $row.find(".F").val();
	clsG= $row.find(".G").val();
	clsH= $row.find(".H").val();
	clsI= $row.find(".I").val();
	clsJ= $row.find(".J").val();
	clsK= $row.find(".K").val();
	clsL= $row.find(".L").val();
	clsM= $row.find(".M").val();
	clsN= $row.find(".N").val();
	clsO= $row.find(".O").val();
	clsP= $row.find(".P").val();
	clsQ= $row.find(".Q").val();
	clsR= $row.find(".R").val();
	clsS= $row.find(".S").val();
	clsnom= $row.find(".nom").val();
	lastrownom= $row.find(".nom").val();
	url = "<?= site_url('downloadpajak/downloadpajak/insert2table/');?>"+clsA+"/"+clsnom;
	//alert(clsA);
	var ajax = $.post( url, { A: clsA, B: clsB, C: clsC, D: clsD, E: clsE, F: clsF, G: clsG, H: clsH, I : clsI, J : clsJ, K : clsK, L: clsL, M: clsM, N: clsN, O: clsO, P: clsP, Q: clsQ, R: clsR, S: clsS, nom: clsnom} )
		.done(function(pesan){
			var obj = $.parseJSON(pesan); 					
		}, 'json');	
		
	
	
	});
	
	if (lastnom == lastrownom) {
		alert(lastnom);
		alert(lastrownom);
		$("#loading").hide();
	}
  
  
  
  });
  $('#btnexport_').click(function() {
	var cprefix = $('#cprefix').val();
	var iprefix =  $('#iprefix').val();
	var url = "<?= site_url('downloadpajak/downloadpajak/export_data/');?>"+cprefix+"/"+iprefix;
	window.open(url,"_blank");
	//window.location.href = "<?= site_url('downloadpajak/downloadpajak/export_data/');?>"+cprefix+"/"+iprefix;  
  });
  var detik = 10;
  function hitung() {
	setTimeout(function(){ alert("Hello"); }, 3000);
	
	$("#loading").show();
	//var detik = 1604644600000;
	var menit = 3;
	var jam = 0;
	//var countDownDate = new Date().getTime() + 150000;
	setTimeout(hitung,1000);
	detik --;
	//alert(detik);
	$('#ifakturnofrom').val(detik);
	if(detik < 0) {
		//alert('STOP');
		$("#loading").hide();
		clearInterval(hitung);
		
	}
  };
  function myFunction() {
	
	setTimeout(function(){ alert("DONE"); }, 5000);
	
	}
  $('#btnload_').click(function() {
	$("#loading").show();
	$("#loading").show();
	setTimeout(function(){ alert("DONE"); }, 5000);
	$("#loading").hide();
  });
  
  
  $('#btnload').click(function() {    
		
	//Delete
	var urldelete = "<?= site_url('downloadpajak/downloadpajak/deletetable');?>";
    var ID ='';
	var ajax = $.post( urldelete, { ID: ID} )
		.done(function(e){
			//var obj = $.parseJSON(pesan);
			//console.log(obj.pesan);					
		}, 'json');	

      
      var _startdate = $('#istartdate').val();
	  var _enddate = $('#ienddate').val();
	  var _region = $('#hregion').val();
      var _branch = $('#hbranch').val();
      var _tenant = $('#htenant').val();
      var _brand = $('#hbrand').val();
	  var _fakturfrom = $('#ifakturnofrom').val();
	  var _fakturend = $('#ifakturnoend').val();
	  var _agrtype = $('#hagrtype').val();
	  //var _iTable = oTable.draw();
	  oTable.clear().draw();
	  //alert(_iTable);

      $.ajax({
          type: "GET",
          dataType: "json",
          url: "<?php echo site_url('downloadpajak/downloadpajak/griddetil'); ?>",
          data: {
              startdate: _startdate, 
              enddate: _enddate,
              region: _region,
              branch: _branch,
              tenant: _tenant,
			  brand: _brand,
			  fakturfrom: _fakturfrom,
			  fakturend: _fakturend,
			  agrtype: _agrtype
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

  function addRow(ci, tenant, brand, reg_no) {      

      var linenum=0;

      var max=GetDgvLineMaxNum('detailTab', 1);
      linenum= Number(max) + 10;      

      if (typeof ci === 'undefined') { ci = linenum}

         oTable.rows.add([{
              'posted': '<input type="checkbox" id="posted" disabled>',
              'line':  linenum,
              'tenant': tenant,
              'brand': brand,
              'standakhir': '<input type="text" id="d_standakhir_'+ci+'" name="dstandakhir[]" value="0" class="detil form-control input-sm" style= "text-align: right;"/>',
              'standawal': '<input type="text" id="d_standawal_'+ci+'" name="dstandawal[]" value="0" class="detil form-control input-sm" style= "text-align: right;" readonly/>',              
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
              'unit': '<input type="hidden" id="d_unit_'+ci+'" name="dunit[]" value = ""/>',
              'agr': '<input type="text" id ="d_agreement_'+ci+'" name="dagreement[]" value="" class="detil form-control input-sm text-center"/>',
              'bagr': '<a id ="btnAgr" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></a>',              
              'pipa': 0+'<input type="hidden" id="d_pipa_'+ci+'" name="dpipa[]" value = "0"/>',
              'blok1': 0+'<input type="hidden" id="d_blok1_'+ci+'" name="dblok1[]" value="0"/>',
              'tarifb1': 0+'<input type="hidden" id="d_tarifb1_'+ci+'" name="dtarifb1[]" value="0"/>',
              'totalb1': 0+'<input type="hidden" id="d_totalb1_'+ci+'" name="dtotalb1[]" value="0"/>',
              'blok2': 0+'<input type="hidden" id="d_blok2_'+ci+'" name="dblok2[]" value="0"/>',
              'tarifb2': 0+'<input type="hidden" id="d_tarifb2_'+ci+'" name="dtarifb2[]" value="0"/>',
              'totalb2': 0+'<input type="hidden" id="d_totalb2_'+ci+'" name="dtotalb2[]" value="0"/>',
              'blok3': 0+'<input type="hidden" id="d_blok3_'+ci+'" name="dblok3[]" value="0"/>',
              'tarifb3': 0+'<input type="hidden" id="d_tarifb3_'+ci+'" name="dtarifb3[]" value="0"/>',
              'totalb3': 0+'<input type="hidden" id="d_totalb3_'+ci+'" name="dtotalb3[]" value="0"/>',
              'blok4': 0+'<input type="hidden" id="d_blok4_'+ci+'" name="dblok4[]" value="0"/>',
              'tarifb4': 0+'<input type="hidden" id="d_tarifb4_'+ci+'" name="dtarifb4[]" value="0"/>',
              'totalb4': 0+'<input type="hidden" id="d_totalb4_'+ci+'" name="dtotalb4[]" value="0"/>',
              'totalpakai': 0+'<input type="hidden" id="d_totalpakai_'+ci+'" name="dtotalpakai[]" value="0"/>',
              'pelihara': 0+'<input type="hidden" id="d_pelihara_'+ci+'" name="dpelihara[]" value="0"/>',
              'phairkotor': 0+'<input type="hidden" id="d_phairkotor_'+ci+'" name="dphairkotor[]" value="0"/>',
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
 <div class="modal fade" id="tedialog" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         </button>
         <h4 class="modal-title">
           Data Tenant
         </h4>
       </div>
       <div class="modal-body">
         <form action="#" id="form" class="form-horizontal">
           <div class="row">
           <div class="col-md-8">
              <label>Search Tenant</label>
             <input  type="text" id="searchTenant" class="form-control input-sm" placeholder="Search Tenant" >
           </div>
           <div class="col-md-4" align="right">
             <br>
             <input type="button" id="btnrek" value = "LOAD" class="btn btn-sm btn-info"/>

           </div>
         </div>

        <div class="portlet-body">
         <div class="table-container">
           <div class="table-scrollable">
             <table class="table table-striped table-bordered table-hover compact nowrap" id='popLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
               <thead>
                <tr>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
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
         <button type="button" class="btn green" data-dismiss="modal" id="addtenant">
           Add Selected Data
         </button>
       </div>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>

 <!-- /.popup-region -->
 <div class="modal fade" id="regiondialog" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         </button>
         <h4 class="modal-title">
           Data Business Unit
         </h4>
       </div>
       <div class="modal-body">
         <form action="#" id="form" class="form-horizontal">
           <div class="row">
           <div class="col-md-8">
              <label>Search Business Unit</label>
             <input  type="text" id="searchRegion" class="form-control input-sm" placeholder="Search Region" name ="" >
           </div>
           <div class="col-md-4" align="right">
             <br>
             <input type="button" id="btnregion" value = "LOAD" class="btn btn-sm btn-info"/>
           </div>
         </div>

        <div class="portlet-body">
         <div class="table-container">
           <div class="table-scrollable">
             <table class="table table-striped table-bordered table-hover compact nowrap" id='regionLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
               <thead>
                <tr>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Name</th>
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
         <button type="button" class="btn green" data-dismiss="modal" id="addregion">
           Add Selected Data
         </button>
       </div>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>

 <!-- /.popup-branch -->
 <div class="modal fade" id="storedialog" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         </button>
         <h4 class="modal-title">
           Data Store
         </h4>
       </div>
       <div class="modal-body">
         <form action="#" id="form" class="form-horizontal">
           <div class="row">
           <div class="col-md-8">
              <label>Search Store</label>
             <input  type="text" id="searchStore" class="form-control input-sm" placeholder="Search Store" >
           </div>
           <div class="col-md-4" align="right">
             <br>
             <input type="button" id="btnstore" value = "LOAD" class="btn btn-sm btn-info"/>
           </div>
         </div>

        <div class="portlet-body">
         <div class="table-container">
           <div class="table-scrollable">
             <table class="table table-striped table-bordered table-hover compact nowrap" id='branchLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
               <thead>
                <tr>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Name</th>
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
         <button type="button" class="btn green" data-dismiss="modal" id="addstore">
           Add Selected Data
         </button>
       </div>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>

 <!-- /.popup-Shipping -->
 <div class="modal fade" id="branddialog" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         </button>
         <h4 class="modal-title">
           Data Brand
         </h4>
       </div>
       <div class="modal-body">
         <form action="#" id="form" class="form-horizontal">
           <div class="row">
           <div class="col-md-8">
              <label>Search Brand</label>
             <input  type="text" id="searchbrand" class="form-control input-sm" placeholder="Search Brand" >
           </div>
           <div class="col-md-4" align="right">
             <br>
             <input type="button" id="btnbrand" value = "LOAD" class="btn btn-sm btn-info"/>
           </div>
         </div>

        <div class="portlet-body">
         <div class="table-container">
           <div class="table-scrollable">
             <table class="table table-striped table-bordered table-hover compact nowrap" id='brandLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
               <thead>
                <tr>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Name</th>
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
         <button type="button" class="btn green" data-dismiss="modal" id="addbrand">
           Add Selected Data
         </button>
       </div>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>

 <!-- /.popup-Shipping -->
 <div class="modal fade" id="agrtypedialog" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         </button>
         <h4 class="modal-title">
           Data Agreement Type
         </h4>
       </div>
       <div class="modal-body">
         <form action="#" id="form" class="form-horizontal">
           <div class="row">
           <div class="col-md-8">
              <label>Search Agreement Type</label>
             <input  type="text" id="searchagrtype" class="form-control input-sm" placeholder="Search agrtype" >
           </div>
           <div class="col-md-4" align="right">
             <br>
             <input type="button" id="btnagrtype" value = "LOAD" class="btn btn-sm btn-info"/>
           </div>
         </div>

        <div class="portlet-body">
         <div class="table-container">
           <div class="table-scrollable">
             <table class="table table-striped table-bordered table-hover compact nowrap" id='agrtypeLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
               <thead>
                <tr>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Name</th>
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
         <button type="button" class="btn green" data-dismiss="modal" id="addagrtype">
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
        <div class="portlet-body">
                <div class="portlet-body form">
                  <form id="formSave" action="<?php echo site_url('downloadpajak/downloadpajak/export_data');?>" method="post" target = "_blank">
                    <div class="row">
                      <div class="col-md-12">
						<div class="col-md-4">
						  <label class="checkbox-inline"><input type="checkbox" id="cstartdate">Start Date</label>
						  <div class="input-group date" data-provide="datepicker">
							<div class="input-group-addon">
							  <i class="fa fa-calendar"></i>
							</div>
							  <input type="text" class="form-control input-sm pull-right" id="istartdate" name="istartdate" value = "" readonly>
						  </div>
						</div>
						
						<div class="col-md-4">
						  <label class="checkbox-inline"><input type="checkbox" id="cenddate">End Date</label>
						  <div class="input-group date" data-provide="datepicker">
							<div class="input-group-addon">
							  <i class="fa fa-calendar"></i>
							</div>
							  <input type="text" class="form-control input-sm pull-right" id="ienddate" name="ienddate" value = "" readonly>
						  </div>
						</div>   
						
						<div class="col-md-4">
						  <label class="checkbox-inline"><input type="checkbox" id="cbunit">Business Unit</label>
						  <div class="input-group input-group-sm">
							<input type="text" id = "iregion" name="iregion" class="form-control input-sm" value="" required autocomplete="off" readonly>
							<span class="input-group-btn">
							  <button id ="btregion" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
							</span>
						  <input type="hidden" id = "hregion" name="hregion" value="">
						  </div>				  
						</div>

						<div class="col-md-4">
							<label class="checkbox-inline"><input type="checkbox" id="cbranch">Store</label>
							<div class="input-group input-group-sm">
							  <input type="text" id = "ibranch" name="ibranch" class="form-control input-sm" value="" required autocomplete="off" readonly>
							  <span class="input-group-btn">
								<button id ="btbranch" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
							  </span>
							<input type="hidden" id = "hbranch" name="hbranch" value="">
							</div>
						</div>



						<div class="col-md-4">
							<label class="checkbox-inline"><input type="checkbox" id="ctenant">Tenant</label>
							<div class="input-group input-group-sm">
							  <input type="text" id = "itenant" name="itenant" class="form-control input-sm" value="" required autocomplete="off" readonly>
							  <span class="input-group-btn">
								<button id ="bttenant" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
							  </span>
							<input type="hidden" id = "htenant" name="htenant" value="">
							</div>
						</div>

						<div class="col-md-4">
							<label class="checkbox-inline"><input type="checkbox" id="cbrand">Brand</label>
							<div class="input-group input-group-sm">
							  <input type="text" id = "ibrand" name="ibrand" class="form-control input-sm" value="" required autocomplete="off" readonly>
							  <span class="input-group-btn">
								<button id ="btbrand" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
							  </span>
							<input type="hidden" id = "hbrand" name="hbrand" value="">
							</div>
						</div>
						
						<div class="col-md-4">
						  <label class="checkbox-inline"><input type="checkbox" id="cagrtype">Agr Type</label>
							<div class="input-group input-group-sm">
							  <input type="text" id = "iagrtype" name="iagrtype" class="form-control input-sm" value="" required autocomplete="off" readonly>
							  <span class="input-group-btn">
								<button id ="btagrtype" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
							  </span>
							<input type="hidden" id = "hagrtype" name="hagrtype" value="">
							<input type="hidden" id = "hcriteria" name="hcriteria" value=" schedulepaymentdetil_isposted ='0' and schedulepaymentdetil_ischeked = '0'">
							</div>
						</div>
						
						<div class="col-md-4">
							<label class="checkbox-inline"><input type="checkbox" id="cfakturnofrom" name="cfakturnofrom">Faktur No. Start</label>
							<div class="input-group input-group-sm">
							  <input type="text" id = "ifakturnofrom" name="ifakturnofrom" style="width: 100%;" class="form-control input-sm" value="" required autocomplete="off" readonly>
							</div>
						</div>             
						
						<div class="col-md-4">
							<label class="checkbox-inline"><input type="checkbox" id="cfakturnoend" name="cfakturnoend">Faktur No. End</label>
							<div class="input-group input-group-sm">
							<input type="text" id = "ifakturnoend" name="ifakturnoend" class="form-control input-sm" value="" required autocomplete="off" readonly>
							</div>
						</div>
						
						<div class="col-md-4">
							<label class="checkbox-inline"><input type="checkbox" id="cprefix" name="cprefix">Prefix</label>
							<div class="input-group input-group-sm">
							<input type="text" id = "iprefix" name="iprefix" class="form-control input-sm" value="0" required autocomplete="off" readonly>
							</div>
						</div>
                                                   
                          <div class="col-md-12">
                            <!-- Custom Tabs -->                          
                                  <div class="col-md-6 form-group row"> 
                                    <br>
									<button type="button" class="btn purple btn-circle btn-outline btn-sm" id="btnload"><i class="fa fa-calculator"></i>LOAD DATA</button>
									<button id="btnsave" name="btnsave" class="btn blue btn-circle btn-outline btn-sm" type="button" value="SAVE"><i class="fa fa-save"></i> SAVE DATA</button>
									<button id="btnexport" name="btnexport" class="btn green btn-circle btn-outline btn-sm" type="submit" value="EXPORT"><i class="fa fa-cloud-download"></i> EXPORT</button>
                                    <img src="<?php echo base_url('assets/img/broken.gif');?>" id="loading" style="display:none"  width='32px' height='32px'/>                                    
									
								  </div>  
                                  <div class ="table-container">                                    
                                    <table class="table table-striped compact nowrap" id='detailTab' style="border:solid 1px #999; #999; border-radius:1px; width:100%">
                                      <thead>
                                        <tr>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">A</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">B</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">C</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">D</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">E</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">F</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">G</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">H</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">I</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">J</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">K</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">L</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">M</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">N</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">O</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">P</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Q</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">R</th>
                                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">S</th> 
											<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">nom</th>
                                        </tr>
                                      </thead>
                                      <tbody>                                       
                                      </tbody>
                                    </table>                                    
                                  </div>
                                 
                          </div>
                          <!-- /.col -->
                    </div>
                   </div>
                  </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END OF CONTENT -->