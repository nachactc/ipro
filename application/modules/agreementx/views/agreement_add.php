
<script>

function validateb4submit(){
  var max=GetDgvLineMaxNum('agreeDetil',0);
  if (max < 1 ){    
    display_modal('Alert!', 'Please, Add Term & Condition !');
    return false;
  }
}

$(document).on("focusin", "#itenant", function() {
   $(this).prop('readonly', true);  
});

$(document).on("focusout", "#itenant", function() {
   $(this).prop('readonly', false); 
});

$(document).ready(function(){  

  var branchData=[];
  var listunit=[];
  var Region;

  function getUnit(){
       var ajax = $.get('<?php echo site_url('agreement/agreement/unit_selectbybranch')?>', function(data){}, 'json');
       return ajax;
  }

  getUnit().done(function(results){

    branchData = results.data;   

    listunit = branchData.filter(function (data) { return data.branch == '' });; 

  });   

  unitOptions = {
    ajax: {
      transport: function(params, success, failure) {
      items = listunit;        

        if (params.data && params.data.q) {
          items = items.filter(function(item) {

            return new RegExp(params.data.q, "i").test(item.text);
          });
        }

        promise = new Promise(function(resolve, reject) {
          resolve({
            results: items
          });
        });

        promise.then(success);
        promise.catch(failure);
      }
    }
  };     

  if ($('.post').attr('checked')){

    $('.submit').prop('disabled',true);

  }else{

    $('.submit').prop("disabled", false);

  }

  $('#isflat').on('change', function() {
    if($(this).is(':checked')){
      $('#agreement_installmentflat').prop("readonly", false);
      $('#_isflat').val(1);
    }else{      
      $('#agreement_installmentflat').prop('readonly',true);
      $('#_isflat').val(0);
    }
  });  

  $('#iregion').val([]);  
  $('#istruk').val([]);
  $('#iutype').val([]);  

  $('#iregion').select2({placeholder: 'Select a business unit'});
  $('#iutype').select2({placeholder: 'Choose unit ..'});
  $('#istruk').select2({placeholder: 'Choose strukturunit ..'});
  $('#icalc').select2({placeholder: 'Choose calculation type ..'}); 
  $('.dropunit').select2(unitOptions);

  $('#ibranch').on('select2:select', function (e) {
    var bra = e.params.data;    

    $('#iregion').val(bra.region).trigger('change');      

    $('#cboregion').val(bra.region);  

    listunit = branchData.filter(function (data) { return data.branch == bra.id });   
        
  });

  $('#branchSearch').select2({placeholder: 'Choose a store ..'});

  $('#ibranch').select2({
      placeholder: 'Select an option',
      minimumInputLength: 2,
      //tags: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('loo/loo/branch_select')?>',
          dataType: 'json',
          type: "GET",
          data: function (term) {
              return {
                  term: term
                  //region: $("#iregion").val()
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

  $("#agreement_term").keyup(function() {

    var startDate = new Date($('#agreement_startperiod').val());
    var mTerm = parseInt($('input:text[name=agreement_term]').val());

    startDate.setMonth(startDate.getMonth() + mTerm); //number  of days to add, e.x. 15 days
    startDate.setDate(startDate.getDate() + -1); //number  of days to add, e.x. 15 days

    var dateFormated = startDate.toISOString().substr(0,10);    

    $('#agreement_endperiod').val(dateFormated);

  });

  $("#agreement_startperiod").on('change keyup', function() {

    var startDate = new Date($('input:text[name=agreement_startperiod]').val());
    var mTerm = parseInt($('#agreement_term').val());

    startDate.setMonth(startDate.getMonth() + mTerm); //number  of days to add, e.x. 15 days
    startDate.setDate(startDate.getDate() + -1); //number  of days to add, e.x. 15 days

    var dateFormated = startDate.toISOString().substr(0,10);    

    $('#agreement_endperiod').val(dateFormated);
    
  });

  $("#itenant").on('keydown paste', function(e){
      e.preventDefault();
  });

  $("#ibrand").on('keydown paste', function(e){
    e.preventDefault();
  });

  $("#idebtor").on('keydown paste', function(e){
    e.preventDefault();
  });

	var arrid= [];
	//lfrtip =default
	var oTable = popgrid("<?php echo site_url('agreement/agreement/controler_griddialog')?>","uLoader","trp", 10);

  var rTable = popgrid("<?php echo site_url('agreement/agreement/controler_gridpop')?>","popLoader","trp", 10);

  var newTable = popgrid("<?php echo site_url('agreement/agreement/controler_gridnew')?>","newLoader","trp", 5);

  var newDetil = popgrid("<?php echo site_url('agreement/agreement/controler_gridnewdetil')?>","newDetil","trp", 5);

  $('#btnload').click( function() {
      var searchName = $("#sUnitName").val();
      var searchID  = $("#sID").val();
      var searchBranch = $("#ibranch").val();
      var searchRegion  = $("#iregion").val();

      oTable.search('');      

      oTable.column(0).search(searchID);
      oTable.column(1).search(searchRegion);
      oTable.column(2).search(searchBranch);
      oTable.draw();
  });


	$("#tabdata").trigger('click');

  $('#btTemplate').click(function() {
	  if (($('#iregion option:selected').length == 0) || ($('#ibranch').val() =='') || ($('#iutype').val() ==null)) { 

	   //alert("Please select Bussiness Unit and Store and Unit Type");
     display_modal('Alert!', 'Please select Bussiness Unit and Store and Unit Type.');
	  }else{

    var searchID  = $("#iutype").val();    

    scTable.search(searchID).draw();
    
    scTable.rows('.selected').deselect();
    $("#tempdialog").modal("show");
	  }

  });

  $('#bttenant').click(function() {

    if (($('#ibranch option:selected').length == 0) || ($('#ibranch').val() =='')) { 
      
      display_modal('Alert!', 'Please select Bussiness Unit or Store.');
    }else{

      var searchBranch = $('#ibranch').val();    

      rTable.search(searchBranch).draw();

      rTable.rows('.selected').deselect();
      $("#tedialog").modal("show");
    }
  });

  $('#btnrek').click(function() {
    var searchTenant  = $("#searchTenant").val();

    rTable.search(searchTenant).draw();
  });

  $('#btdetil').click(function() {

    if (($('#iregion option:selected').length == 0) || ($('#ibranch').val() =='')) { 
    	
      display_modal('Alert!', 'Please select Bussiness Unit or Store.');
    }else{
        var activetab = $('.detil .active').text();
        switch(activetab) {

            case 'Rental':
                addRow();               
                break;

            case 'Charge':
                addRowCharge();
                break;

            case 'Deposit':
                addRowDeposit();
                break;

            case 'Loan':
                addRowLoan();
                break;

        }
    }
	

  });

	$('#tabedit').click(function() {

    display_modal('Alert!', 'Please, select data from list.');
	});

  $('#btdialog').click(function () {

      var linenum=0;
      var oData = oTable.rows('.selected').data();

       for (var i=0; i < oData.length; i++){

          var rid     = oData[i][0];
          var runit   = oData[i][1];
          var rsize   = oData[i][2];
          var nlantai = oData[i][3];
          var rlantai = oData[i][4];          
          var Branch  = $("#ibranch").val();
          var Region  = $("#iregion").val();
          var Tenant  = $("#htenant").val();
          var Brand  = $("#hbrand").val();

          var max=GetDgvLineMaxNum('unittab',0)
          linenum= Number(max) + 10;
          var t="tcharge"+linenum;

          $('#unittab tbody').append('<tr>'+
            '<td>' + linenum + '<input type="hidden" name="uline[]" value="'+ linenum +'"/></td>'+
            '<td>'+ rid +'<input type="hidden" name="uunit[]" value="'+ rid +'"/></td>'+
            '<td>'+ runit +'</td>'+
            '<td>'+ rsize +'<input type="hidden" name="usize[]" value="'+ rsize +'"/></td>'+
            '<td>'+ nlantai +'<input type="hidden" name="ulantai[]" value="'+ rlantai +'"/>'+
            '<input type="hidden" name="rregion[]" value="'+ Region +'"/>'+
            '<input type="hidden" name="rbranch[]" value="'+ Branch +'"/>'+
            '<input type="hidden" name="rtenant[]" value="'+ Tenant +'"/>'+
            '<input type="hidden" name="rbrand[]" value="'+ Brand +'"/>'+
            '</td>'+
            '<td><a id= "uDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a></td></tr>');

          listunit.push({id: rid, text: runit, region: Region, branch: Branch, tenant: Tenant, brand: Brand});

       }


      if ($('.dropunit').val() == null){        

        $('.dropunit').append(new Option(oData[0][1], oData[0][0], false, false)).trigger('change');
        $('.dReg').val($("#iregion").val());
        $('.dBra').val($("#ibranch").val());
        $('.dTen').val($("#htenant").val());
        $('.dBran').val($("#hbrand").val());
      }
              
  });

  $('#addtenant').click(function () {

      var linenum=0;
       var rData = rTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid       = rData[i][0];
          var tname     = rData[i][1];
          var tline     = rData[i][2];
          var tbrand    = rData[i][3];
          var tdebtor   = rData[i][4];          

          $('#htenant').val(tid);
          $('#itenant').val(tname);
          $('#hbrand').val(tline);
          $('#ibrand').val(tbrand);
          $('#idebtor').val(tdebtor);
          //$('#ivirtual').val(get_va(tdebtor));

      }

  });

  $('input[name=lookup]').click(function() {

      if ($('input[name=lookup]:checked').val() == 'oto'){

          $('.nav-tabs a[href="#tab_1_find"]').tab('show');

      } else {
          $('.nav-tabs a[href="#tab_3_manual"]').tab('show');
      }
  });

  $('#nextnew').click( function(){

      var looData = newTable.rows('.selected').data();      
      var searchID  = looData[0][0];      

      newDetil.search('');
      newDetil.search(searchID).draw();

      $('.nav-tabs a[href="#tab_2_detil"]').tab('show');

  });

  $('#addnew').click(function () {

      var linenum=0; 
      var row = 10;   
      var sLooDate;
      var eFormated;      

      var looData = newTable.rows('.selected').data();  
      var rekData = newDetil.rows('.selected').data();   
      var _id     = looData[0][0];      
      var _rek    = rekData[0][1];
      var _bra    = looData[0][8];

      //console.log(looData);
      $('#agreement_term').val(looData[0][14]);
      $('#iregion').val(looData[0][7]).trigger('change');
      $('#cboregion').val(looData[0][7]);      
      $('#ibranch').append(new Option(looData[0][6], _bra, true, true)).trigger('change');
      $('#htenant').val(_rek);
      $('#itenant').val(rekData[0][2]);
      $('#hbrand').val(rekData[0][3]);
      $('#ibrand').val(rekData[0][4]);
      $('#agreement_startperiod').val(looData[0][1]);
      $('#agreement_endperiod').val(looData[0][2]);
      $('#agreement_loonumber').val(looData[0][0]);
      $('#idebtor').val(rekData[0][5]);
      $('#transaksi_id').val('Pencatatan Leasing');
      $('#htransaksi').val('100920');
      $('#size_indoor').val(looData[0][9]);
      $('#size_outdoor').val(looData[0][10]);
      $('#fitting_out').val(looData[0][11]);
      $('#grace_periode').val(looData[0][12]);
      $('#product_name').val(looData[0][13]);

      listunit = branchData.filter(function (data) { return data.branch == _bra });          

      function getDataLoo (){
         var ajax = $.get('<?php echo site_url('agreement/agreement/agreement_getdataloo')?>','id='+_id+'&rekanan='+_rek+'&branch='+_bra, function(data){
           //do something with data here               
         }, 'json');
         return ajax;
      }
       
      getDataLoo().done(function(results){

        dLoo = results.data;            
        
        for (var i=0; i<dLoo.length; i++){

            if (dLoo[i][2] === 'RENTAL' || dLoo[i][2] === 'RENTAL TEMP'){

                if (dLoo[i][1] === '1000' || dLoo[i][1] === '2000') {                      

                    if (dLoo[i][3] > 0 && dLoo[i][4] > 0) {    

                        /* Row Pertama ambil persentase LOO */
                        addRow(row);
                        $('#r_type_'+row).val(dLoo[i][1]).trigger('change');
                        $('#r_per_'+row).val(dLoo[i][3]);
                        $('#r_int_'+row).val(dLoo[i][5]);
                        $('#r_spdate_'+row).val(dLoo[i][6]);
                        $('#r_sdate_'+row).val(dLoo[i][6]);
                        sLooDate = new Date(dLoo[i][6]);                       
                        sLooDate.setMonth(sLooDate.getMonth() + 1);
                        sLooDate.setDate(sLooDate.getDate() + -1);
                        eFormated = sLooDate.toISOString().substr(0,10);   
                        $('#r_edate_'+row).val(eFormated);
                        $('#r_base_'+row).val(dLoo[i][8]);
                        $('#r_unit_'+row).append(new Option(dLoo[i][9], dLoo[i][11])).trigger('change');
                        $('#r_space_'+row).val(dLoo[i][10]);
                        $('#r_una_'+row).val(dLoo[i][9]);
                        row++;

                        /* Row Kedua ambil persentase LOI */
                        addRow(row);
                        $('#r_type_'+row).val(dLoo[i][1]).trigger('change');
                        $('#r_per_'+row).val(dLoo[i][4]);
                        $('#r_int_'+row).val(dLoo[i][5]);
                        $('#r_spdate_'+row).val(dLoo[i][6]);
                        $('#r_sdate_'+row).val(dLoo[i][6]);
                        sLooDate = new Date(dLoo[i][6]);                       
                        sLooDate.setMonth(sLooDate.getMonth() + 1);
                        sLooDate.setDate(sLooDate.getDate() + -1);
                        eFormated = sLooDate.toISOString().substr(0,10);  
                        $('#r_edate_'+row).val(eFormated);
                        $('#r_base_'+row).val(dLoo[i][8]);
                        $('#r_unit_'+row).append(new Option(dLoo[i][9], dLoo[i][11])).trigger('change');
                        $('#r_space_'+row).val(dLoo[i][10]);
                        $('#r_una_'+row).val(dLoo[i][9]);
                        row++;

                    } else {
                        /* Row berikut ambil persentase LOO dari field */                            
                        addRow(row);
                        $('#r_type_'+row).val(dLoo[i][1]).trigger('change');
                        $('#r_per_'+row).val(dLoo[i][12]);
                        $('#r_int_'+row).val(dLoo[i][5]);
                        $('#r_spdate_'+row).val(dLoo[i][6]);
                        $('#r_sdate_'+row).val(dLoo[i][6]);
                        sLooDate = new Date(dLoo[i][6]);                       
                        sLooDate.setMonth(sLooDate.getMonth() + 1);
                        sLooDate.setDate(sLooDate.getDate() + -1);
                        eFormated = sLooDate.toISOString().substr(0,10);  
                        $('#r_edate_'+row).val(eFormated);
                        $('#r_base_'+row).val(dLoo[i][8]);
                        $('#r_unit_'+row).append(new Option(dLoo[i][9], dLoo[i][11])).trigger('change');
                        $('#r_space_'+row).val(dLoo[i][10]);
                        $('#r_una_'+row).val(dLoo[i][9]);                            
                        row++;
                    }                        
                } else {
                    addRow(row);
                    $('#r_type_'+row).val(dLoo[i][1]).trigger('change');
                    $('#r_per_'+row).val(dLoo[i][12]);
                    $('#r_int_'+row).val(dLoo[i][5]);
                    $('#r_spdate_'+row).val(dLoo[i][6]);
                    $('#r_sdate_'+row).val(dLoo[i][6]);
                    $('#r_edate_'+row).val(dLoo[i][7]);
                    $('#r_base_'+row).val(dLoo[i][8]);
                    $('#r_unit_'+row).append(new Option(dLoo[i][9], dLoo[i][11])).trigger('change');
                    $('#r_space_'+row).val(dLoo[i][10]);
                    $('#r_una_'+row).val(dLoo[i][9]);
                    $('#r_pinst_'+row).val(dLoo[i][13]);
                    $('#r_rinstm_'+row).val(dLoo[i][13]);
                    row++;
                }
            }

            if (dLoo[i][2] === 'SERVICE' || dLoo[i][2] === 'OTHER'){

                if (dLoo[i][8] > 0) {
                    if (dLoo[i][14] === 'SERVICE CHARGE' || dLoo[i][14] === 'PROMOTION LEVY' || dLoo[i][14] === 'FOOD COURT LEVY') {

                      addRowCharge(row);
                      $('#c_type_'+row).val(dLoo[i][1]).trigger('change');
                      $('#c_per_'+row).val(dLoo[i][12]);
                      $('#c_int_'+row).val(dLoo[i][5]);
                      $('#c_spdate_'+row).val(dLoo[i][6]);
                      $('#c_sdate_'+row).val(dLoo[i][6]);
                      $('#c_edate_'+row).val(dLoo[i][7]);
                      $('#c_base_'+row).val(dLoo[i][8]);
                      $('#c_unit_'+row).append(new Option(dLoo[i][9], dLoo[i][11])).trigger('change');
                      $('#c_space_'+row).val(dLoo[i][10]);
                      $('#c_una_'+row).val(dLoo[i][9]);   
                      $('#c_pinst_'+row).val(dLoo[i][13] / dLoo[i][5]);      
                      $('#c_rinstm_'+row).val(dLoo[i][13]);              
                      row++;

                    } else {
                        addRowCharge(row);
                        $('#c_type_'+row).val(dLoo[i][1]).trigger('change');
                        $('#c_per_'+row).val(dLoo[i][12]);
                        $('#c_int_'+row).val(dLoo[i][5]);
                        $('#c_spdate_'+row).val(dLoo[i][6]);
                        $('#c_sdate_'+row).val(dLoo[i][6]);
                        $('#c_edate_'+row).val(dLoo[i][7]);
                        $('#c_base_'+row).val(dLoo[i][8]);
                        $('#c_unit_'+row).append(new Option(dLoo[i][9], dLoo[i][11])).trigger('change');
                        $('#_space_'+row).val(dLoo[i][10]);
                        $('#c_una_'+row).val(dLoo[i][9]);                        
                        $('#c_lump_'+row).prop('checked', true);
                        $('#c_lumpsum_'+row).val(1);
                        $('#c_pinst_'+row).val(1);      
                        $('#c_rinstm_'+row).val(1);
                        row++;
                    }
                }
            }
/*
            if (dLoo[i][2] === 'LOAN'){

                if (dLoo[i][8] > 0) {

                      addRow(row);
                      $('#c_type_'+row).val(dLoo[i][1]).trigger('change');
                      $('#c_per_'+row).val(dLoo[i][12]);
                      $('#c_int_'+row).val(dLoo[i][5]);
                      $('#c_spdate_'+row).val(dLoo[i][6]);
                      $('#c_sdate_'+row).val(dLoo[i][6]);
                      $('#c_edate_'+row).val(dLoo[i][7]);
                      $('#c_base_'+row).val(dLoo[i][8]);
                      $('#c_unit_'+row).append(new Option(dLoo[i][9], dLoo[i][11])).trigger('change');
                      $('#c_space_'+row).val(dLoo[i][10]);
                      $('#c_una_'+row).val(dLoo[i][9]);           
                      $('#c_pinst_'+row).val(dLoo[i][13] / dLoo[i][5]);      
                      $('#c_rinstm_'+row).val(dLoo[i][13]);              
                      row++;                   
                }
            }
*/
            if (dLoo[i][2] === 'DEPOSIT'){

                if (dLoo[i][1] > 7500) {                    

                    addRowDeposit(row);
                    $('#d_type_'+row).val(dLoo[i][1]).trigger('change');
                    $('#d_due_'+row).val(dLoo[i][5]);
                    $('#d_sdate_'+row).val(dLoo[i][6]);
                    $('#d_mia_'+row).val(dLoo[i][8]);
                    $('#d_unit_'+row).append(new Option(dLoo[i][9], dLoo[i][11])).trigger('change');
                    $('#d_una_'+row).val(dLoo[i][9]);   
                    $('#d_space_'+row).val(dLoo[i][10]);                            
                    $('#d_lump_'+row).prop('checked', true);
                    $('#d_lumpsum_'+row).val(1);        
                    $('#d_per_'+row).val(dLoo[i][12]);
                    row++;

                } else {
                    addRowDeposit(row);
                    $('#d_type_'+row).val(dLoo[i][1]).trigger('change');
                    $('#d_due_'+row).val(dLoo[i][5]);
                    $('#d_sdate_'+row).val(dLoo[i][6]);
                    $('#d_base_'+row).val(dLoo[i][8]);
                    $('#d_unit_'+row).append(new Option(dLoo[i][9], dLoo[i][11])).trigger('change');
                    $('#d_una_'+row).val(dLoo[i][9]);   
                    $('#d_space_'+row).val(dLoo[i][10]);
                    $('#d_per_'+row).val(dLoo[i][12]);
                    row++;                    
                }
            }
        }               

      });      

  });

  $("#rentalTab").on('click','#rDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }
      $(this).closest('tr').remove();
  });

  $("#chargeTab").on('click','#cDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }
      $(this).closest('tr').remove();
  });

  $("#depositTab").on('click','#dDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }
      $(this).closest('tr').remove();
  });

  $("#rentalTab").on('change', "input[type='checkbox']", function (e) {

      //$(this).closest('tr').find('input[type="text"]').eq(0).prop('readonly', e.target.checked ? true: false);
      //$(this).closest('tr').find('input[type="text"]').eq(1).prop('readonly', e.target.checked ? false: true);
      $(this).closest('tr').find('input[type="hidden"]').eq(0).val(e.target.checked ? 1: 0);

  });

  $("#depositTab").on('change', ".chkLump", function (e) {     

      $(this).closest('tr').find('input[type="hidden"]').eq(2).val(e.target.checked ? 1: 0);
      //console.log($(this).closest('tr').find('input[type="hidden"]').eq(0).val());

  });

  $("#unittab").on('click','#uDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }

      var cari =0;
      var deleted = $(this).closest('tr').find('td:eq(1)').text();

      $('.dropunit').each(function(){
            if (deleted == $(this).val()){

                display_modal('Alert!', 'Unit #'+deleted+'# Is Already Chosen.');
                cari = 1;
                return false;
            }

      });

      if (cari == 0)  {

        for (var i = 0; i < listunit.length; i++){

          if (listunit[i].id && listunit[i].id === deleted) {

              listunit.splice(i, 1);
          }
        }

        $(this).closest('tr').remove();

      }

  });


  $.fn.datepicker.defaults.format = "yyyy-mm-dd";
  $.fn.datepicker.defaults.autoclose = true;

  function addRow(ci) {      

      var linenum=0;

      var max=GetDgvLineMaxNum('rentalTab', 0);
      linenum= Number(max) + 10;      

      if (typeof ci === 'undefined') { ci = linenum}

      $('#rentalTab tbody').append('<tr>'+
        '<td>' + linenum + '<input type="hidden" name="rline[]" value="'+ linenum +'" readonly class="nogaris"/></td>'+
        '<td><div class="form-group form-group-sm"><?php echo form_dropdownext('rtype[]',$renttype, '', 'id="r_type_\'+ci+\'" class="droprental form-control input-sm" style="width: 100%;" required');?></div></td>'+
        '<td><input type="text" id="r_spdate_'+ci+'" name="rspdate[]" value="<?php echo date('Y-m-d');?>" class="tanggal form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="r_pinst_'+ci+'" name="rpinst[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="r_sdate_'+ci+'" name="rsdate[]" value="<?php echo date('Y-m-d');?>" class="tanggal form-control input-sm" /></td>'+
        '<td><input type="text" id="r_rinstm_'+ci+'" name="rrinstm[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="r_rinstd_'+ci+'" name="rrinstd[]" value="0" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="r_edate_'+ci+'" name="redate[]" value="<?php echo date('Y-m-d');?>" class="tanggal form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="r_int_'+ci+'" name="rint[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><?php echo form_dropdownext('rtitype[]',$titype, 'MONTH', 'id="r_time_\'+ci+\'" class="detil form-control input-sm" required');?></td>'+
        '<td><input type="text" id="r_per_'+ci+'" name="rper[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "r_unit_'+ci+'" name= "runit[]" required class="dropunit form-control input-sm" style="width: 100%;">'+
            '</select></div><input type="hidden" id="r_una_'+ci+'" name="runa[]" value="" /></td>'+
        '<td><?php echo form_dropdownext('runitspot[]', $outdoor, 'Indoor', 'id="r_unitspot_\'+ci+\'" class="detil form-control input-sm" required');?></td>'+
        '<td><input type="text" id="r_space_'+ci+'" name="rspace[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><input type="checkbox" id="lump_'+ci+'" >'+
            '<input type="hidden" id="r_lumpsum_'+ci+'" name="rlumpsum[]" value="0"/></td>'+
        '<td><input type="text" id="r_base_'+ci+'" name="rbase[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="text" id="r_mia_'+ci+'" name="rmia[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="text" id="r_vat_'+ci+'" name="rvat[]" value="10" class="form-control input-sm" style= "text-align: right;" /></td>'+        
        '<td><input type="checkbox" id="aden_'+ci+' style="text-align:right;"><input type="hidden" id="r_adendum_'+ci+'" name="radendum[]" value="0"/></td>'+
        '<td><input type="text" id="r_ninst_'+ci+'" name="tninst[]" value="" class="form-control input-sm"/></td>'+
        '<td><input type="text" id="r_descr'+ci+'" name="rdescr[]" value="" class="pops form-control input-sm"/>'+
        '</td>'+
        '<td><a id= "rDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');          

      $('.deci').number( true, 2 );
      $('.bulet').number( true, 0 );     

      $('.tanggal').datepicker();

      $('.dropunit').select2(unitOptions);      
      $('.droprental').select2({placeholder: 'Choose agreement type..'});

      $('#r_rinstm_'+ci).on('change keyup', function() {

        var startDate = new Date($('#r_sdate_'+ci).val());
        var mTerm = parseInt($('#r_rinstm_'+ci).val());

        startDate.setMonth(startDate.getMonth() + mTerm);
        startDate.setDate(startDate.getDate() + -1);

        var dateFormated = startDate.toISOString().substr(0,10);

        $('#r_edate_'+ci).val(dateFormated);

      });
     
      $('.pops').popover({   
            trigger: 'manual',    
            placement: 'left',
            title: function(){
              var line = $(this).closest('tr').find('td:eq(0)').text();
              var frm = 'Descr Line: '+line;

              return frm;
            },
            html:true,
            content: function() {          
              var olddesc = $(this).val();

              $('#popover-form').find('textarea[name="txtContent"]').text(olddesc);

              return $('#popover-form').html();
            } 
        }).on('click', function(){
          // had to put it within the on click action so it grabs the correct info on submit
          var $popup = $(this);

          $(this).popover('show');

          $('.btn-primary').click(function(){

            var newdesc = $('.popover #txtContent').val();

            $($popup[0]).val(newdesc);

            $popup.popover('hide');

          });

          $('.btn-default').click(function(){

            $popup.popover('hide');
            
          });

      });

      $('body').on('click', function (e) {
        $('.pops').each(function () {
            // hide any open popovers when the anywhere else in the body is clicked
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });   
      });       

      $('.dropunit').on("select2:select", function(e){
        var uData = e.params.data;

        /* console.log(uData); */        
        $(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['text']);
        
      });

  }

  function addRowCharge(ci) {      

      var linenum = 0;
      var counter = 10;

      var max=GetDgvLineMaxNum('chargeTab', 0);

      if (max === 0) { counter = 5 }
      linenum= Number(max) + counter;

      if (typeof ci === 'undefined') { ci = linenum }

      $('#chargeTab tbody').append('<tr>'+
        '<td>' + linenum + '<input type="hidden" name="cline[]" value="'+ linenum +'" readonly class="nogaris"/></td>'+
        '<td><div class="form-group form-group-sm"><?php echo form_dropdownext('ctype[]',$chgtype, '', 'id="c_type_\'+ci+\'" class="dropcharge form-control input-sm" style="width: 100%;" required');?></div></td>'+
        '<td><input type="text" id="c_spdate" name="cspdate[]" value="<?php echo date('Y-m-d');?>" class="tanggal form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="c_pinst_'+ci+'" name="cpinst[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="c_sdate_'+ci+'" name="csdate[]" value="<?php echo date('Y-m-d');?>" class="tanggal form-control input-sm" /></td>'+
        '<td><input type="text" id="c_rinstm_'+ci+'" name="crinstm[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="c_rinstd_'+ci+'" name="crinstd[]" value="0" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="c_edate_'+ci+'" name="cedate[]" value="<?php echo date('Y-m-d');?>" class="end form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="c_int_'+ci+'" name="cint[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><?php echo form_dropdownext('ctitype[]',$titype, 'MONTH', 'id="c_time_\'+ci+\'" class="detil form-control input-sm" required');?></td>'+
        '<td><input type="text" id="c_per_'+ci+'" name="cper[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "c_unit_'+ci+'" name= "cunit[]" required class="dropunit form-control input-sm" style="width: 100%;">'+
            '</select></div><input type="hidden" id="c_una_'+ci+'" name="cuna[]" value="" /></td>'+
        '<td><?php echo form_dropdownext('cunitspot[]', $outdoor, 'Indoor', 'id="c_unitspot_\'+ci+\'" class="detil form-control input-sm" required');?></td>'+
        '<td><input type="text" id="c_space_'+ci+'" name="cspace[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><input type="checkbox" id="c_lump_'+ci+'" >'+
            '<input type="hidden" id="c_lumpsum_'+ci+'" name="clumpsum[]" value="0"/></td>'+
        '<td><input type="text" id="c_base_'+ci+'" name="cbase[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="text" id="c_mia_'+ci+'" name="cmia[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="text" id="c_vat_'+ci+'" name="cvat[]" value="10" class="form-control input-sm" style= "text-align: right;" /></td>'+        
        '<td><input type="checkbox" id="c_aden_'+ci+' style="text-align:right;"><input type="hidden" id="c_adendum_'+ci+'" name="cadendum[]" value="0"/></td>'+
        '<td><input type="text" id="c_ninst_'+ci+'" name="cninst[]" value="" class="form-control input-sm"/></td>'+
        '<td><input type="text" id="c_descr'+ci+'" name="cdescr[]" value="" class="pops form-control input-sm"/>'+
        '</td>'+
        '<td><a id= "cDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');          

      $('.deci').number( true, 2 );
      $('.bulet').number( true, 0 );      

      $('.tanggal').datepicker();

      $('.dropunit').select2(unitOptions);      
      $('.dropcharge').select2({placeholder: 'Choose agreement type..'});

      $('#c_rinstm_'+ci).on('change keyup', function() {

        var startDate = new Date($('#c_sdate_'+ci).val());
        var mTerm = parseInt($(this).val());

        startDate.setMonth(startDate.getMonth() + mTerm);
        startDate.setDate(startDate.getDate() + -1);

        var dateFormated = startDate.toISOString().substr(0,10);

        $('#c_edate_'+ci).val(dateFormated);

      });

      $('.pops').popover({   
            trigger: 'manual',    
            placement: 'left',
            title: function(){
              var line = $(this).closest('tr').find('td:eq(0)').text();
              var frm = 'Descr Line: '+line;

              return frm;
            },
            html:true,
            content: function() {          
              var olddesc = $(this).val();

              $('#popover-form').find('textarea[name="txtContent"]').text(olddesc);

              return $('#popover-form').html();
            } 
        }).on('click', function(){
          // had to put it within the on click action so it grabs the correct info on submit
          var $popup = $(this);

          $(this).popover('show');

          $('.btn-primary').click(function(){

            var newdesc = $('.popover #txtContent').val();

            $($popup[0]).val(newdesc);

            $popup.popover('hide');

          });

          $('.btn-default').click(function(){

            $popup.popover('hide');
            
          });

      });

      $('body').on('click', function (e) {
        $('.pops').each(function () {
            // hide any open popovers when the anywhere else in the body is clicked
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });   
      });       

      $('.dropunit').on("select2:select", function(e){
        var uData = e.params.data;

        /* console.log(uData); */        
        $(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['text']);
        
      });

  }

  function addRowDeposit(ci) {      

      var linenum=0;

      var max=GetDgvLineMaxNum('depositTab', 0);
      linenum= Number(max) + 10;

      if (typeof ci === 'undefined') { ci = linenum}

      $('#depositTab tbody').append('<tr>'+
        '<td>' + linenum + '<input type="hidden" name="dline[]" value="'+ linenum +'" readonly class="nogaris"/></td>'+
        '<td><div class="form-group form-group-sm"><?php echo form_dropdownext('dtype[]',$deptype, '', 'id="d_type_\'+ci+\'" class="dropdepo form-control input-sm" style="width: 100%;" required');?></div></td>'+
        '<td><input type="text" id="d_sdate_'+ci+'" name="dsdate[]" value="<?php echo date('Y-m-d');?>" class="tanggal form-control input-sm" /></td>'+
        '<td><input type="text" id="d_due_'+ci+'" name="ddue[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><?php echo form_dropdownext('dtitype[]', $titype, 'MONTH', 'id="d_time_\'+ci+\'" class="detil form-control input-sm" required');?></td>'+
        '<td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "d_unit_'+ci+'" name= "dunit[]" required class="dropunit form-control input-sm" style="width: 100%;">'+
            '</select></div><input type="hidden" id="d_una_'+ci+'" name="duna[]" value="" /></td>'+
        '<td><input type="text" id="d_space_'+ci+'" name="dspace[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><input type="checkbox" id="d_lump_'+ci+'" class="chkLump" >'+
            '<input type="hidden" id="d_lumpsum_'+ci+'" name="dlumpsum[]" value="0"/></td>'+
        '<td><input type="text" id="d_base_'+ci+'" name="dbase[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="text" id="d_mia_'+ci+'" name="dmia[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="text" id="d_vat_'+ci+'" name="dvat[]" value="10" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><a id= "dDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');          

      $('.deci').number( true, 2 );
      $('.bulet').number( true, 0 );      

      $('.tanggal').datepicker();

      $('.dropunit').select2(unitOptions);      
      $('.dropdepo').select2({placeholder: 'Choose agreement type..'});
      $('.pops').popover({   
            trigger: 'manual',    
            placement: 'left',
            title: function(){
              var line = $(this).closest('tr').find('td:eq(0)').text();
              var frm = 'Descr Line: '+line;

              return frm;
            },
            html:true,
            content: function() {          
              var olddesc = $(this).val();

              $('#popover-form').find('textarea[name="txtContent"]').text(olddesc);

              return $('#popover-form').html();
            } 
        }).on('click', function(){
          // had to put it within the on click action so it grabs the correct info on submit
          var $popup = $(this);

          $(this).popover('show');

          $('.btn-primary').click(function(){

            var newdesc = $('.popover #txtContent').val();

            $($popup[0]).val(newdesc);

            $popup.popover('hide');

          });

          $('.btn-default').click(function(){

            $popup.popover('hide');
            
          });

      });

      $('body').on('click', function (e) {
        $('.pops').each(function () {
            // hide any open popovers when the anywhere else in the body is clicked
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });   
      });       

      $('.dropunit').on("select2:select", function(e){
        var uData = e.params.data;

        /* console.log(uData); */        
        $(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['text']);
        
      });

  }

  function addRowLoan(ci) {      

      var linenum=0;

      var max=GetDgvLineMaxNum('loanTab', 0);
      linenum= Number(max) + 10;

      if (typeof ci === 'undefined') { ci = linenum}

      $('#loanTab tbody').append('<tr>'+
        '<td>' + linenum + '<input type="hidden" name="lline[]" value="'+ linenum +'" readonly class="nogaris"/></td>'+
        '<td><div class="form-group form-group-sm"><?php echo form_dropdownext('ltype[]',$loatype, '', 'id="l_type_\'+ci+\'" class="droploa form-control input-sm" style="width: 100%;" required');?></div></td>'+
        '<td><input type="text" id="l_pinst_'+ci+'" name="lpinst[]" value="0" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="l_sdate_'+ci+'" name="lsdate[]" value="<?php echo date('Y-m-d');?>" class="tanggal form-control input-sm" /></td>'+
        '<td><input type="text" id="l_rinstm_'+ci+'" name="lrinstm[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="l_edate" name="ledate[]" value="<?php echo date('Y-m-d');?>" class="end form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="l_int_'+ci+'" name="lint[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><?php echo form_dropdownext('ltitype[]', $titype, 'MONTH', 'id="l_time_\'+ci+\'" class="detil form-control input-sm" required');?></td>'+
        '<td><input type="text" id="l_per_'+ci+'" name="lper[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "l_unit_'+ci+'" name= "lunit[]" required class="dropunit form-control input-sm" style="width: 100%;">'+
            '</select></div><input type="hidden" id="l_una_'+ci+'" name="luna[]" value="" /></td>'+
        '<td><input type="text" id="l_space_'+ci+'" name="lspace[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><input type="text" id="l_IDR_'+ci+'" name="lIDR[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="text" id="l_vat_'+ci+'" name="lvat[]" value="10" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><a id= "dDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');          

      $('.deci').number( true, 2 );
      $('.bulet').number( true, 0 );      

      $('.tanggal').datepicker();

      $('.dropunit').select2(unitOptions);      
      $('.droploa').select2({placeholder: 'Choose agreement type..'});
      $('.pops').popover({   
            trigger: 'manual',    
            placement: 'left',
            title: function(){
              var line = $(this).closest('tr').find('td:eq(0)').text();
              var frm = 'Descr Line: '+line;

              return frm;
            },
            html:true,
            content: function() {          
              var olddesc = $(this).val();

              $('#popover-form').find('textarea[name="txtContent"]').text(olddesc);

              return $('#popover-form').html();
            } 
        }).on('click', function(){
          // had to put it within the on click action so it grabs the correct info on submit
          var $popup = $(this);

          $(this).popover('show');

          $('.btn-primary').click(function(){

            var newdesc = $('.popover #txtContent').val();

            $($popup[0]).val(newdesc);

            $popup.popover('hide');

          });

          $('.btn-default').click(function(){

            $popup.popover('hide');
            
          });

      });

      $('body').on('click', function (e) {
        $('.pops').each(function () {
            // hide any open popovers when the anywhere else in the body is clicked
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });   
      });       

      $('.dropunit').on("select2:select", function(e){
        var uData = e.params.data;

        /* console.log(uData); */        
        $(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['text']);
        
      });

  }

  function display_modal(title, message){
     $("#mdlinfo").modal("show");
     $("#mdltitle").show().html(title);
     $("#mdlbody").show().html(message);
  }  

  $('.pops').popover({   
        trigger: 'manual',    
        placement: 'left',
        title: 'Popover Form',
        html:true,
        content: function() {          
          var olddesc = $(this).val();

          $('#popover-form').find('textarea[name="txtContent"]').text(olddesc);

          return $('#popover-form').html();
        } 
    }).on('click', function(){
      // had to put it within the on click action so it grabs the correct info on submit
      var $popup = $(this);

      $(this).popover('show');

      $('.btn-primary').click(function(){

        var newdesc = $('.popover #txtContent').val();

        $($popup[0]).val(newdesc);

        $popup.popover('hide');

      });

      $('.btn-default').click(function(){

        $popup.popover('hide');
        
      });
  });

  $('body').on('click', function (e) {
    $('.pops').each(function () {
        // hide any open popovers when the anywhere else in the body is clicked
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });   
  });


  $('.deci').number( true, 2 );
  $('.bulet').number( true, 0 );
  

});

$(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );

$(window).load(function() {    

    //$('#tedialog').show();
    $("#tempdialog").modal("show");
});

</script>

<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

#rentalTab th, td, label {

    font-size: 9pt;
    white-space: nowrap;    
}

#chargeTab th, td, label {

    font-size: 9pt;
    white-space: nowrap;    
}

#depositTab th, td, label {

    font-size: 9pt;
    white-space: nowrap;    
}

#loanTab th, td, label {

    font-size: 9pt;
    white-space: nowrap;    
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
    padding: 2px;
}

label {
  font-size: 9pt;
  font-weight: bold;
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
        
              <div class="modal fade" id="mdldialog" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                      </button>
                      <h4 class="modal-title">
                        Data Unit
                      </h4>
                    </div>
                    <div class="modal-body">
                      <form action="#" id="form" class="form-horizontal">                            
                      <div class="row">
                        <div class="col-md-4">
                           <label>Unit</label>
                          <input  type="text" id="sID" class="form-control input-sm" placeholder="Search Unit" >
                        </div>
                        <div class="col-md-4">
                          <label>Lantai</label>
                          <input  type="text" id="sUnitName" class="form-control input-sm" placeholder="Search Lantai" >
                        </div>
                        <div class="col-md-4" align="right">
                          <br>
                          <input type="button" id="btnload" value = "LOAD" class="btn btn-sm btn-info"/>
                        </div>
                      </div>
                     <div class="portlet-body">
                      <div class="table-container">
                        <div class="table-scrollable">
                          <table class="table table-striped table-bordered table-hover nowrap compact" id='uLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                            <thead>
                             <tr>
                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Name</th>
                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Sqm</th>
                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Lantai</th>
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
                      <button type="button" class="btn green" data-dismiss="modal" id="btdialog">
                        Add Selected Data
                      </button>
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
                          <table class="table table-striped table-bordered table-hover compact nowrap" id='popLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                            <thead>
                             <tr>
                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Brand</th>
                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Debt No.</th>
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

            <!-- /.popup-new-data-LOO -->
            <div class="modal fade" id="tempdialog" tabindex="-1" role="basic" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    </button>
                    <h4 class="modal-title">
                      New Agreement
                    </h4>
                  </div>
                  <div class="modal-body">
                    <form action="#" id="form" class="form-horizontal">
                      <div class="row">
                        <div class="col-md-12">
                          <label class="radio-inline">
                            <input type="radio" name="lookup" value="oto" checked="checked" /><b>Input By LOO</b>
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="lookup" value="man" /><b>Input Manual</b>
                          </label>
                          
                        </div>
                      </div>
                      <br>
                      <!-- Custom Tabs -->
                      <div class="nav-tabs-custom">
                        <ul class="custom nav nav-tabs">
                          <li class="active"><a href="#tab_1_find" role= "tab">Finding LOO</a></li>
                          <li><a href="#tab_2_detil" role= "tab" >Detil LOO</a></li>
                          <li><a href="#tab_3_manual"role= "tab" >Manual</a></li>
                        </ul>
                        <div class="tab-content">                                    
                          <div class="tab-pane active" id="tab_1_find">
                            <div class="row">
                             <div class="col-md-6">
                              <div class="col-xs-12">
                                 <label>LOO No.</label>
                                 <input type="text" id= "agreement_createby" name="agreement_createby" class="form-control input-sm" value="">
                              </div>
                             </div>
                             <div class="col-md-6">
                              <div class="col-xs-12">
                                  <label>Tenant</label>
                                  <div class="input-group input-group-sm">
                                    <input type="text" id = "tenantSearch" name="tenantSearch" class="form-control input-sm" value="" required autocomplete="off">
                                      <span class="input-group-btn">
                                        <button id ="btnSeaTenant" type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                      </span>
                                  </div>
                              </div>
                             </div>  
                              <div class="col-md-6">
                              <div class="col-xs-12">
                                 <label>Business Unit</label>
                                 <input type="text" id="agreement_createdate" name="agreement_createdate" class="form-control input-sm" value="">
                              </div>
                             </div>                                     
                             <div class="col-md-6">
                              <div class="col-xs-12">
                                 <label>Trade Name</label>
                                 <input type="text" id="agreement_modifydate" name="agreement_modifydate" class="form-control input-sm" value="">
                              </div>
                             </div>
                             <div class="col-md-6">
                              <div class="col-xs-12">
                                 <label>Store</label>
                                 <select id="branchSearch" class="form-control" style="width: 100%;"> </select> 
                              </div>
                             </div>
                             <div class="col-md-6" align="right">
                              <div class="col-xs-12">
                                <br>
                               <button id="btnSearch" type="button" class="btn btn-sm btn-primary">
                                  <i class="fa fa-history"></i> LOAD LOO
                               </button>
                              </div>
                             </div>
                            </div>                                  
                            <div class="portlet-body">
                              <div class="table-container">
                                <div class="table-scrollable">
                                  <table class="table table-striped table-bordered nowrap" id='newLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                                    <thead>
                                     <tr>
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">LOO No.</th>
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Start Date</th>
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">End Date</th>
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Create By</th>
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Create Date</th>
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Business Unit.</th>
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Store Location</th>
                                     </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                            <div class="row">   
                              <div class="col-md-12">
                                <div class="pull-right">
                                  <div class="btn-group" role="group" aria-label="First group">                                 
                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">
                                      Cancel
                                    </button>
                                  </div>
                                  <div class="btn-group" role="group" aria-label="Second group">
                                    <button type="button" class="btn btn-primary" id="nextnew">
                                      Next >>
                                    </button>                                        
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="tab-pane" id="tab_2_detil">
                           <div class="portlet-body">
                             <div class ="table-container">
                              <div class="table-scrollable">
                                <table class="table table-bordered table-striped nowrap" id='newDetil' style="border:solid 1px #999; #999; border-radius:0px;">
                                  <thead>
                                    <tr>
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">LOO No.</th>
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant ID</th>
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant Name</th>
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Brand ID</th>
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Brand Name</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                             </div>
                           </div>
                           <div class="row">   
                            <div class="col-md-12">
                              <div class="pull-right">
                                <div class="btn-group" role="group" aria-label="First group">                                 
                                  <button type="button" class="btn dark btn-outline" data-dismiss="modal">
                                    Close
                                  </button>
                                </div>
                                <div class="btn-group" role="group" aria-label="Second group">
                                  <button type="button" class="btn green" data-dismiss="modal" id="addnew">
                                    Accept
                                  </button>                                        
                                </div>
                              </div>
                            </div>
                           </div>
                          </div>
                          <div class="tab-pane" id="tab_3_manual">                          
                           <div class="row">   
                            <div class="col-md-12">
                              <div class="pull-right">
                                <div class="btn-group" role="group" aria-label="First group">                                 
                                  <button type="button" class="btn dark btn-outline" data-dismiss="modal">
                                    Close
                                  </button>
                                </div>
                                <div class="btn-group" role="group" aria-label="Second group">
                                  <button type="button" class="btn green" data-dismiss="modal" id="addmanual">
                                    Accept
                                  </button>                                        
                                </div>
                              </div>
                            </div>
                           </div>
                          </div>
                          <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                      </div>
                      <!-- nav-tabs-custom -->                            
                    </form>
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
                          <a href="<?php echo base_url('index.php/agreement/agreement/agreementlist'); ?>" id='tablist'> LIST </a>
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
                         <form action="<?php echo site_url('agreement/agreement/agreement_add');?>" method="post" onsubmit="return validateb4submit();">
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
                                      <input  type="text" id="agreement_id" name="agreement_id" class="form-control input-sm" value="<?php echo $row->agreement_id;?>" readonly>
                                    </div>
                                  </div>                                 
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                        <label>Debtor No.</label>
                                        <input type="text" id = "idebtor" name="idebtor" class="form-control input-sm" value="" readonly required autocomplete="off">
                                    </div>
                                  </div>  
                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                      <label>Calculation Type</label>                                        
                                        <?php echo form_dropdown('cbocalctype',$calculation, $row->agreement_formula,'id ="icalc" class="form-control" style="width: 100%;" required '); ?>
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                      <label>Store</label>
                                        <select data-placeholder="Select a store" id= "ibranch" name= "cbobranch" required>
                                          <option value="<?php echo $row->branch_id;?>" selected="selected" ><?php echo $row->branch_id;?></option>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                    <label>Business Unit</label>
                                      <?php echo form_dropdown('iregion',$region,'','id ="iregion" class="form-control" style="width: 100%;" required disabled '); ?>
                                    </div>
                                    <input type="hidden" id = "cboregion" name="cboregion" value="">
                                  </div>
                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                      <label>Strukturunit</label>                                        
                                        <?php echo form_dropdown('cbostruktur',$strukturunit,'','id ="istruk" class="form-control" style="width: 100%;" required '); ?>
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Tenant</label>
                                      <div class="input-group input-group-sm">
                                        <input type="text" id = "itenant" name="itenant" class="form-control input-sm" value="" required autocomplete="off">
                                        <span class="input-group-btn">
                                          <button id ="bttenant" type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                        </span> 
                                      <input type="hidden" id = "htenant" name="htenant" value="">
                                      </div>
                                    </div>
                                  </div>    
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                        <label>Brand Name</label>
                                        <input type="hidden" id = "hbrand" name="hbrand" value="">
                                        <input type="text" id = "ibrand" name="ibrand" class="form-control input-sm" value="" readonly required autocomplete="off">
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                        <label>Virtual Account</label>
                                        <input type="text" id = "ivirtual" name="ivirtual" class="form-control input-sm" value="" readonly required autocomplete="off">
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
                                      <label>LOO/LOC No.</label>
                                        <input type="text" id = "agreement_loonumber" name="agreement_loonumber" class="form-control input-sm" readonly>
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label class="checkbox-inline" style="font-weight: bold;">
                                          <input id="isflat" type="checkbox">Installment Flat
                                          <input type="hidden" id="_isflat" name="_isflat" value="0"/>
                                      </label>
                                      <div class="input-group input-group-sm">
                                        <input type="text" id = "agreement_installmentflat" name="agreement_installmentflat" value="0"
                                          class="deci form-control input-sm" style="text-align: right;" readonly>
                                        <span class="input-group-addon" style="font-style: italic;">(Month)</span>
                                      </div>
                                    </div>
                                  </div>                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Start Date</label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="agreement_startperiod" name="agreement_startperiod" value = "<?php echo $row->agreement_startdate;?>">
                                      </div>
                                    </div>
                                  </div>     
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-6">
                                      <label>Terms</label>  
                                      <div class="input-group input-group-sm">
                                        <input type="text" id = "agreement_term" name="agreement_term" class="bulet form-control input-sm"
                                          style="text-align: right;" value="0">
                                        <span class="input-group-addon" style="font-style: italic;">(M)</span>
                                      </div>
                                    </div>
                                    <div class="col-xs-6">
                                      <label></label>  
                                      <div class="input-group input-group-sm">
                                        <input type="text" id = "agreement_dayterm" name="agreement_dayterm" class="bulet form-control input-sm"
                                          style="text-align: right;" value="0">
                                        <span class="input-group-addon" style="font-style: italic;">(D)</span>
                                      </div>
                                    </div>
                                  </div>                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>End Date</label>
                                      <div class="input-group date">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="agreement_endperiod" name="agreement_endperiod" value = "<?php echo $row->agreement_enddate;?>" readonly>
                                      </div>
                                    </div>
                                  </div>                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Size Indoor</label>
                                        <input data-placeholder="Size Indoor (Angka)" type="text" id = "size_indoor" name="size_indoor" 
                                          class="bulet form-control input-sm" value="0" style="text-align: right;">
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Size Outdoor</label>
                                        <input data-placeholder="Size Outdoor (Angka)" type="text" id = "size_outdoor" name="size_outdoor" 
                                          class="bulet form-control input-sm" value="0" style="text-align: right;">
                                    </div>
                                  </div>                                                            
								                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Fitting Out</label>
                                        <input data-placeholder="Fitting Out (Angka)" type="text" id = "fitting_out" name="fitting_out" 
                                          class="bulet form-control input-sm" value="0" style="text-align: right;">
                                    </div>
                                  </div>
								                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Grace Period</label>
                                        <input data-placeholder="Grace Period (Angka)" type="text" id = "grace_periode" name="grace_periode" 
                                          class="bulet form-control input-sm" value="0" style="text-align: right;">
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                        <label>Product Name:</label> 
                                        <input data-placeholder="Product Name" type="text" id = "product_name" name="product_name" class="form-control input-sm" value="<?php echo $row->product_name;?>">
                                    </div>
                                  </div>
                                   <div class="col-md-4 form-group row">
                                   <div class="col-xs-12">
                                      <label class="post checkbox-inline"><input type="checkbox" disabled>Closed</label>
                                      <label class="post checkbox-inline"><input type="checkbox" disabled>Approved</label>
                                   </div>
                                  </div>
                                  <div class="col-md-11 form-group row">                                    
                                    <div class="col-xs-12">
                                      <label>Description:</label>
                                      <textarea id = "agreement_descr" name="agreement_descr" class="form-control input-sm" required rows="2" ></textarea>
                                    </div>                                    
                                  </div>       
                                  <div class="col-md-12 form-group row"></div>
                                  <div class="col-md-4 form-group row"></div>
                                  <div class="col-md-4 form-group row"></div>
                                  <div class="col-md-4 form-group row form-group-sm">
                                    <label class="col-sm-4">Base Rent Rate</label>        
                                    <div class = "col-sm-8">                    
                                      <input type="text" class="bulet form-control" id="agreement_idr" name="agreement_idr" value="0" style="text-align: right">
                                    </div>                                            
                                  </div> 
                                  <div class="col-md-12 form-group row"></div>
                                  <div class="col-md-4 form-group row"></div>
                                  <div class="col-md-4 form-group row"></div>
                                  <div class="col-md-4 form-group row form-group-sm">
                                    <label class="col-sm-4">Total Lease Value</label>        
                                    <div class = "col-sm-8">                    
                                      <input type="text" class="bulet form-control" id="agreement_tlv" name="agreement_tlv" value="0" style = "text-align: right">
                                    </div> 
                                  </div> 
                                  <div class="col-md-12">                                  
                                  <br>
                                    <a href="javascript:void(0)" id="btdetil"><strong>Add Row</strong></a>
                                      <!-- Custom Tabs -->
                                      <div class="nav-tabs-custom">
                                        <ul class="detil nav nav-tabs">
                                          <li class="active"><a href="#tab_1" data-toggle="tab" role= "tab">Rental</a></li>
                                          <li><a href="#tab_2" data-toggle="tab" role = "tab">Charge</a></li>
                                          <li><a href="#tab_3" data-toggle="tab" role = "tab">Deposit</a></li>
                                          <li><a href="#tab_4" data-toggle="tab" role = "tab">Loan</a></li>
                                          <li><a href="#tab_5" data-toggle="tab" role = "tab">Record</a></li>
                                        </ul>
                                        <div class="tab-content">
                                          <div class="tab-pane active" id="tab_1">
                                            <div class ="table-responsive">                                             
                                              <div style="overflow-y: scroll; height: 300px">
                                              <table class="table table-bordered table-striped" id='rentalTab' style="border:solid 1px #999; #999; border-radius:0px;">
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
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Type</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Start Date Trans.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Len.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Time Type</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Unit</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Space</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Lump.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Base Rent IDR</th>
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
                                             <div class="tab-pane" id="tab_4">
                                             <div class ="table-responsive">
                                              <table class="table table-bordered table-striped" id='loanTab' style="border:solid 1px #999; #999; border-radius:0px;">
                                                <thead>
                                                  <tr>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Transaction Type</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">P. Inst</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Start Date Trans.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">R.Ins(M)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">End Date Trans.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Intval.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Time Unit</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Percent</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Unit</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Space</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Total IDR.</th>
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
                                                 <input type="text" id= "agreement_createby" name="agreement_createby" class="form-control" value="<?php echo $row->agreement_createby;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Create Date</label>
                                                 <input type="text" id="agreement_createdate" name="agreement_createdate" class="form-control " value="<?php echo $row->agreement_createdate;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Modify By</label>
                                                 <input type="text" id= "agreement_modifyby"  name="agreement_modifyby" class="form-control " value="<?php echo $row->agreement_modifyby;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Modify Date</label>
                                                 <input type="text" id="agreement_modifydate" name="agreement_modifydate" class="form-control" value="<?php echo $row->agreement_modifydate;?>">
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
