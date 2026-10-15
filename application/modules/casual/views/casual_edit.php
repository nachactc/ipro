
<script>

  function validateb4submit(){
    var max=GetDgvLineMaxNum('rentalTab',0);
    if (max < 1 ){    
      display_modal('Alert!', 'Please, Add Term & Condition !');
      return false;
    }
  }
  
function minmaxsp(value, min, max) 
{
value=parseFloat(value.replace(/,/g, ''));
    if(value < min || isNaN(value)) 
        return min; 
    else if(value > max) {
        //return max; 
	alert('Max Nilai Space:10000');
	return 0;
}
		
    else return value;
}

  function minmax(value, min, max) 
{
    if(parseInt(value) < min || isNaN(parseInt(value))) 
        return min; 
    else if(parseInt(value) > max) {
        //return max; 
		alert('Max Nilai R.Instalment(M):12');
		return 0;
}
		
    else return value;
}

  $(document).on("focusin", "#itenant", function() {
    $(this).prop('readonly', true);  
  });

  $(document).on("focusout", "#itenant", function() {
    $(this).prop('readonly', false); 
  });

$(document).ready(function(){ 
  
  $.fn.modal.Constructor.prototype.enforceFocus = $.noop; 
 
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

  
  $('#iregion').select2({placeholder: 'Select a business unit'});
  $('#iutype').select2({placeholder: 'Choose unit ..'});
  $('#istruk').select2({placeholder: 'Choose strukturunit ..'});
  $('#icalc').select2({placeholder: 'Choose calculation type ..'});   
  $('.droprental').select2({placeholder: 'Choose agreement type..'});
  $('.dropdepo').select2({placeholder: 'Choose agreement type..'});
  $('.droppro').select2({placeholder: 'Choose agreement type..'});

  $('#ibranch').on('select2:select', function (e) {
    var bra = e.params.data;    

    $('#iregion').val(bra.region).trigger('change');      

    $('#cboregion').val(bra.region);  

    //listunit = branchData.filter(function (data) { return data.branch == bra.id });   
        
  });

  $('.dropunit').select2({    
      minimumInputLength: 0,
      placeholder: 'Select an option',
      ajax: {
          url: '<?php echo site_url('casual/casual/unit_select')?>',
          dataType: 'json',
          type: "GET",
          data: function (term) {
              return {
                  term: term,
                  branch: $('#ibranch').val(),
                  region: $('#iregion').val(),
                  loonum: $('#agreement_loonumber').val()
              };
          },
          processResults: function (data) {
              return {
                  results: $.map(data.items, function (item) {                        
                      return {
                          sqm: item.unit_sqm,
                          text: item.unit_name,
                          region: item.region_id,
                          id: item.unit_id
                      }
                  })
              };
          }
      }

  });

  $('#ibranch').select2({
      placeholder: 'Select an option',
      minimumInputLength: 2,
      //tags: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('casual/casual/branch_select')?>',
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
    var dTerm = parseInt($('input:text[name=agreement_dayterm]').val());

    startDate.setMonth(startDate.getMonth() + mTerm); //number  of days to add, e.x. 15 days
    startDate.setDate(startDate.getDate() + -1); //number  of days to add, e.x. 15 days
    startDate.setDate(startDate.getDate() + dTerm); //number  of days to add, e.x. 15 days

    var dateFormated = startDate.toISOString().substr(0,10);    

    $('#agreement_endperiod').val(dateFormated);

  });

  $("#agreement_dayterm").keyup(function() {

    var startDate = new Date($('#agreement_startperiod').val());
    var mTerm = parseInt($('input:text[name=agreement_term]').val());
    var dTerm = parseInt($('input:text[name=agreement_dayterm]').val());

    startDate.setMonth(startDate.getMonth() + mTerm); //number  of days to add, e.x. 15 days
    startDate.setDate(startDate.getDate() + -1); //number  of days to add, e.x. 15 days
    startDate.setDate(startDate.getDate() + dTerm); //number  of days to add, e.x. 15 days

    var dateFormated = startDate.toISOString().substr(0,10);    

    $('#agreement_endperiod').val(dateFormated);

  });

  $("#agreement_startperiod").on('change keyup', function() {

    var startDate = new Date($('input:text[name=agreement_startperiod]').val());
    var mTerm = parseInt($('#agreement_term').val());
    var dTerm = parseInt($('#agreement_dayterm').val());

    startDate.setMonth(startDate.getMonth() + mTerm);
    startDate.setDate(startDate.getDate() + -1);
    startDate.setDate(startDate.getDate() + dTerm);

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
  var oTable=popgrid("<?php echo site_url('casual/casual/controler_griddialog')?>","uLoader","trp", 10);
  var rTable= $('#popLoader').DataTable(); 
  var pTable= $('#proLoader').DataTable();

  var locTable = popgrid("<?php echo site_url('casual/casual/controler_gridloc')?>","newLoader","trp", 5);
  var locDetil = popgrid("<?php echo site_url('casual/casual/controler_gridlocdetil')?>","newDetil","trp", 5);

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


  $("#tabedit").trigger('click');

  $('#btRenewal').click(function() {  

    if ($('.isclosed').attr('checked')) { 
      display_modal('Alert!', 'Agreement that have been closed cannot be renewal.');
    }else{
      $("#tempdialog").modal("show");
    }

  });

  $('#bttenant').click(function() {

    if (($('#ibranch option:selected').length == 0) || ($('#ibranch').val() =='')) { 
      
      display_modal('Alert!', 'Please select Bussiness Unit or Store.');
    }else{

      var searchBranch = $('#ibranch').val();   

      rTable.destroy();
      rTable= checkgrid("<?php echo site_url('casual/casual/controler_gridpop')?>","popLoader","trp", 10, [], $('#ibranch'), $('#ibranch'));    
      rTable.rows().deselect(); 
      //rTable.search(searchBranch).draw();
      //rTable.rows('.selected').deselect();
      $("#tedialog").modal("show");
    }
  });

  $("#profitsTab").on('click','#plook',function(){      

      //var gLine = $(this).closest('tr').find('td').eq(0);
      var pLine = $(this).closest('tr').find('input[type="hidden"]').eq(0);
      //console.log(pLine);
      
      pTable.destroy();
      pTable = checkgrid("<?php echo site_url('casual/casual/controler_gridpro')?>","proLoader","trp", 10, [], pLine, $('#ibranch'));    
      pTable.rows().deselect();
          
      $("#psdialog").modal("show");    

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

            case 'Profit Sharing':
                var row = 0; 
                var _term = ( $('#agreement_term').val() == null || $('#agreement_term').val() == '' ) ? 0 : $('#agreement_term').val();
                var _dayterm = ( $('#agreement_dayterm').val() == null || $('#agreement_dayterm').val() == '' ) ? 0 : $('#agreement_dayterm').val();

                var max = GetDgvLineMaxNum('profitsTab', 0);
                row = Number(max) + 10;    

                var _sdate = $('#p_edate_'+(row -10)).val();                
                var _edate;

                if ( typeof _sdate === 'undefined' ) { 
                  _sdate = $('#agreement_startperiod').val() 
                }else{                    
                  _sdate = new Date(_sdate);
                  _sdate.setDate(_sdate.getDate() +1);
                  _sdate = _sdate.toISOString().substr(0,10);   
                }

                addRowProfits(row);
                //$('#p_sdate_'+row).val(_sdate);
                $('#p_sdate_'+row).datepicker('setDate', _sdate);
                $('#p_term_'+row).val(_term);
                $('#p_dayterm_'+row).val(_dayterm);                
                _edate = new Date(_sdate);                       
                _edate.setMonth(_edate.getMonth() + parseInt(_term));                
                _edate.setDate(_edate.getDate() + -1);
                _edate.setDate(_edate.getDate() + parseInt(_dayterm));
                var eFormated = _edate.toISOString().substr(0,10);   
                $('#p_edate_'+row).val(eFormated);

                break;
        }
    }
  

  });

  $('#tabedit').click(function() {

    display_modal('Alert!', 'Please, select data from list.');
  });  

  $('#addtenant').click(function () {

      var linenum=0;
       var rData = rTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid       = rData[i][1];
          var tname     = rData[i][2];
          var tline     = rData[i][3];
          var tbrand    = rData[i][4];
          var tdebtor   = rData[i][5];          

          $('#htenant').val(tid);
          $('#itenant').val(tname);
          $('#hbrand').val(tline);
          $('#ibrand').val(tbrand);
          $('#idebtor').val(tdebtor);
          //$('#ivirtual').val(get_va(tdebtor));
      }

  });  

  $('#addProfitID').click( function() {

      var pData = pTable.rows('.selected').data(); 
      //console.log(pData);
      var pId = pData[0][1];
      var pDescr = pData[0][2];  
      var pLine = pData[0][3];      
      
      var uRows = $('#profitsTab tbody >tr');
      var uColumns;

      for (var i = 0; i < uRows.length; i++) {  

          var uLine = $(uRows[i]).find('td').eq(0).text();

          if (uLine === pLine) {
            $(uRows[i]).find('input[type="text"]').eq(5).val(pId);
            $(uRows[i]).find('input[type="text"]').eq(6).val(pDescr);
          }
                        
      }
  });    

  $('input[name=lookup]').click(function() {

    if ($('input[name=lookup]:checked').val() == 'oto'){

        $('.nav-tabs a[href="#tab_1_find"]').tab('show');

    } else {
        $('.nav-tabs a[href="#tab_3_manual"]').tab('show');
    }
  });

  $('#branchSearch').select2({
      dropdownCssClass: 'dropdown-store',
      placeholder: 'Choose a Store ..',
      allowClear: true,
      minimumInputLength: 2,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('casual/casual/branch_select')?>',
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
                          region: item.region_id,
                          id: item.branch_id
                      }
                  })
              };
          }
      }

  });

  $('#branchSearch').on('select2:open', function(e){
      $('.dropdown-store').parent().css('z-index', 99999);
  });

  $('#branchSearch').on('select2:select', function (e) {
    var bra = e.params.data;    

    $('#regionSearch').val(bra.region).trigger('change');            
  });

  $("#branchSearch").on("change", function (e) {

    var currentValue = $(this).val();  // I want null when unselect is fired

    if (currentValue === null ){
      $('#regionSearch').val(null).trigger('change');
    }

  });

  $('#regionSearch').val([]); 
  $('#regionSearch').select2({placeholder: 'Choose a Business Unit'});  

  $('#btnSearch').click( function() {

    var sID = $('#locSearch').val();
    var sRegion = '';
    var sBranch = '';      

    sRegion = ( $('#regionSearch').val() == null ) ? '' : $('#regionSearch').val();
    sBranch = ( $('#branchSearch').val() == null ) ? '' : $('#branchSearch').val();

    locTable.search('');      
    locTable.column(0).search(sID);
    locTable.column(1).search(sRegion);
    locTable.column(2).search(sBranch);
    locTable.draw();
  });

  $('#addmanual').click(function () {

    var linenum=0; 
    var row = 10;   
    var sLooDate;
    var eFormated;      
    var ref_no = $('#agreement_id').val();

    //console.log(looData);
    //$('#rentalTab').remove();
    $('#agreement_renewalno').val(ref_no);

    $("#rentalTab > tbody").empty();
    $("#chargeTab > tbody").empty();
    $("#depositTab > tbody").empty();
    $("#profitsTab > tbody").empty();

    $('.post input:checkbox').prop('checked', false);
    $('.isrenewal input:checkbox').prop('checked', true);
    $('#hrenewal').val(1);

    $('#agreement_id').val('auto');    
    $('#agreement_loonumber').val('');    
    //$('#agreement_term').val(looData[0][14]);             

  });

  $('#nextnew').click( function(){

    var locData = locTable.rows('.selected').data();      
    var searchID  = locData[0][0];      

    console.log(searchID);

    locDetil.search('');
    locDetil.search(searchID).draw();

    $('.nav-tabs a[href="#tab_2_detil"]').tab('show');

  });

  $('#addnew').click(function () {

      var linenum=0; 
      var row = 10;   
      var sLocDate;
      var locTerm;
      var eFormated;      
      var ref_no = $('#agreement_id').val();

      var locData = locTable.rows('.selected').data();  
      var rekData = locDetil.rows('.selected').data();   
      var _id     = locData[0][0];      
      var _rek    = rekData[0][1];
      var _bra    = locData[0][8];
      
      //console.log(locData);  
      $('#agreement_term').val(locData[0][14]);
      $('#iregion').val(locData[0][7]).trigger('change');
      $('#cboregion').val(locData[0][7]);      
      $('#ibranch').append(new Option(locData[0][6], _bra, true, true)).trigger('change');
      $('#htenant').val(_rek);
      $('#itenant').val(rekData[0][2]);
      $('#hbrand').val(rekData[0][3]);
      $('#ibrand').val(rekData[0][4]);
      $('#agreement_startperiod').val(locData[0][1]);
      $('#agreement_endperiod').val(locData[0][2]);
      $('#agreement_loonumber').val(locData[0][0]);
      $('#idebtor').val(rekData[0][5]);
      $('#transaksi_id').val('Pencatatan Casual Leasing');
      $('#htransaksi').val('100910');
      $('#size_indoor').val(locData[0][9]);
      $('#size_outdoor').val(locData[0][10]);
      $('#fitting_out').val(locData[0][11]);
      $('#grace_periode').val(locData[0][12]);
      $('#product_name').val(locData[0][13]);
      $('#agreement_descr').val('RENEWAL');   
      $('#agreement_contractlongnumber').val('');
      //$('#icalc').val(0);
      $('#icalc').val('0').trigger('change');   

      $('.post input:checkbox').prop('checked', false);
      $('.isrenewal input:checkbox').prop('checked', true);
      $('#hrenewal').val(1);
      $('#agreement_renewalno').val(ref_no);

      $("#rentalTab > tbody").empty();
      $("#chargeTab > tbody").empty();
      $("#depositTab > tbody").empty();
      $("#profitsTab > tbody").empty();      
      
      $('#agreement_id').val('auto');
      $('#agreement_tlv').val(0);
      //listunit = branchData.filter(function (data) { return data.branch == _bra });          

      function getDataLoc (){
        var ajax = $.get('<?php echo site_url('casual/casual/casual_getdataloc')?>','id='+_id+'&rekanan='+_rek+'&branch='+_bra, function(data){
          //do something with data here               
        }, 'json');
        return ajax;
      }
      
      getDataLoc().done(function(results){

        dLoc = results.data;     
        //console.log(dLoc);        
        for (var i=0; i<dLoc.length; i++){

            if (dLoc[i][2] === 'SERVICE TEMP' || dLoc[i][2] === 'RENTAL TEMP'){                
                /* Row berikut ambil persentase Loc dari field */                            
                addRow(row);
                $('#r_type_'+row).val(dLoc[i][1]).trigger('change');
                $('#r_per_'+row).val(dLoc[i][12]);
                $('#r_int_'+row).val(dLoc[i][5]);
                $('#r_spdate_'+row).val(dLoc[i][6]);
                $('#r_sdate_'+row).datepicker('setDate', dLoc[i][6]);
                $('#r_pinst_'+row).val(dLoc[i][13]);
                $('#r_rinstm_'+row).val(dLoc[i][13]);
                locTerm = dLoc[i][13];
                sLocDate = new Date(dLoc[i][6]);                       
                sLocDate.setMonth(sLocDate.getMonth() + locTerm);
                sLocDate.setDate(sLocDate.getDate() + -1);
                eFormated = sLocDate.toISOString().substr(0,10);  
                $('#r_edate_'+row).val(eFormated);
                $('#r_base_'+row).val(dLoc[i][8]);
                $('#r_unit_'+row).append(new Option(dLoc[i][9], dLoc[i][11])).trigger('change');
                $('#r_space_'+row).val(dLoc[i][10]);
                $('#r_una_'+row).val(dLoc[i][9]);                            
                row++;                            
            }

            if (dLoc[i][2] === 'UTILITIES TEMP' || dLoc[i][2] === 'OTHER'){

                if (dLoc[i][8] > 0) {
                    if (dLoc[i][14] === 'SERVICE CHARGE' || dLoc[i][14] === 'PROMOTION LEVY' || dLoc[i][14] === 'FOOD COURT LEVY') {

                      addRowCharge(row);
                      $('#c_type_'+row).val(dLoc[i][1]).trigger('change');
                      $('#c_per_'+row).val(dLoc[i][12]);
                      $('#c_int_'+row).val(dLoc[i][5]);
                      $('#c_spdate_'+row).val(dLoc[i][6]);
                      $('#c_sdate_'+row).datepicker('setDate', dLoc[i][6]);
                      $('#c_pinst_'+row).val(dLoc[i][13]/dLoc[i][5]);
                      $('#c_rinstm_'+row).val(dLoc[i][13]);
                      locTerm = dLoc[i][13];
                      sLocDate = new Date(dLoc[i][6]);                       
                      sLocDate.setMonth(sLocDate.getMonth() + locTerm);
                      sLocDate.setDate(sLocDate.getDate() + -1);
                      eFormated = sLocDate.toISOString().substr(0,10); 
                      $('#c_edate_'+row).val(eFormated);
                      $('#c_base_'+row).val(dLoc[i][8]);
                      $('#c_unit_'+row).append(new Option(dLoc[i][9], dLoc[i][11])).trigger('change');
                      $('#c_space_'+row).val(dLoc[i][10]);
                      $('#c_una_'+row).val(dLoc[i][9]);   
                      $('#c_pinst_'+row).val(dLoc[i][13] / dLoc[i][5]);      
                      $('#c_rinstm_'+row).val(dLoc[i][13]);              
                      row++;

                    } else {
                        addRowCharge(row);
                        $('#c_type_'+row).val(dLoc[i][1]).trigger('change');
                        $('#c_per_'+row).val(0);
                        $('#c_int_'+row).val(dLoc[i][5]);
                        $('#c_spdate_'+row).val(dLoc[i][6]);
                        $('#c_sdate_'+row).datepicker('setDate', dLoc[i][6]);
                        $('#c_pinst_'+row).val(1);
                        $('#c_rinstm_'+row).val(1);
                        sLocDate = new Date(dLoc[i][6]);                       
                        sLocDate.setMonth(sLocDate.getMonth() + 1);
                        sLocDate.setDate(sLocDate.getDate() + -1);
                        eFormated = sLocDate.toISOString().substr(0,10); 
                        $('#c_edate_'+row).val(eFormated);
                        $('#c_base_'+row).val(dLoc[i][8]);
                        $('#c_unit_'+row).append(new Option(dLoc[i][9], dLoc[i][11])).trigger('change');
                        $('#_space_'+row).val(dLoc[i][10]);
                        $('#c_una_'+row).val(dLoc[i][9]);                        
                        $('#c_lump_'+row).prop('checked', true);
                        $('#c_lumpsum_'+row).val(1);
                        $('#c_pinst_'+row).val(1);      
                        $('#c_rinstm_'+row).val(1);
                        row++;
                    }
                }
            }

            if (dLoc[i][2] === 'PS'){
                /* Row berikut ambil persentase Loc dari field */                            
                addRow(row);
                $('#p_type_'+row).val(dLoc[i][1]).trigger('change');
                $('#p_per_'+row).val(dLoc[i][12]);
                $('#p_int_'+row).val(dLoc[i][5]);
                $('#p_spdate_'+row).val(dLoc[i][6]);
                $('#p_sdate_'+row).datepicker('setDate', dLoc[i][6]);
                $('#p_edate_'+row).val(eFormated);
                $('#p_base_'+row).val(dLoc[i][8]);
                $('#p_unit_'+row).append(new Option(dLoc[i][9], dLoc[i][11])).trigger('change');
                $('#p_space_'+row).val(dLoc[i][10]);
                $('#p_una_'+row).val(dLoc[i][9]);                            
                row++;                            
            }

            if (dLoc[i][2] === 'DEPOSIT'){

                if (dLoc[i][1] > 7500) {                    

                    addRowDeposit(row);
                    $('#d_type_'+row).val(dLoc[i][1]).trigger('change');
                    $('#d_due_'+row).val(dLoc[i][5]);
                    $('#d_sdate_'+row).datepicker('setDate', dLoc[i][6]);
                    $('#d_mia_'+row).val(dLoc[i][8]);
                    $('#d_unit_'+row).append(new Option(dLoc[i][9], dLoc[i][11])).trigger('change');
                    $('#d_una_'+row).val(dLoc[i][9]);   
                    $('#d_space_'+row).val(dLoc[i][10]);                            
                    $('#d_lump_'+row).prop('checked', true);
                    $('#d_lumpsum_'+row).val(1);        
                    $('#d_per_'+row).val(dLoc[i][12]);
                    row++;

                } else {
                    addRowDeposit(row);
                    $('#d_type_'+row).val(dLoc[i][1]).trigger('change');
                    $('#d_due_'+row).val(dLoc[i][5]);
                    $('#d_sdate_'+row).datepicker('setDate', dLoc[i][6]);
                    $('#d_base_'+row).val(dLoc[i][8]);
                    $('#d_unit_'+row).append(new Option(dLoc[i][9], dLoc[i][11])).trigger('change');
                    $('#d_una_'+row).val(dLoc[i][9]);   
                    $('#d_space_'+row).val(dLoc[i][10]);
                    $('#d_per_'+row).val(dLoc[i][12]);
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

      deleted = 'rental|'+$(this).closest('tr').find('td:eq(0)').text();

      $('#agreement_save').prepend('<input type="hidden" name="deleted[]" value="'+deleted+'" />');        
      $(this).closest('tr').remove();
  });

  $("#chargeTab").on('click','#cDelete',function(){  

    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }

      deleted = 'charge|'+$(this).closest('tr').find('td:eq(0)').text();

      $('#agreement_save').prepend('<input type="hidden" name="deleted[]" value="'+deleted+'" />');        
      $(this).closest('tr').remove();
  });

  $("#depositTab").on('click','#dDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }

      deleted = 'deposit|'+$(this).closest('tr').find('td:eq(0)').text();

      $('#agreement_save').prepend('<input type="hidden" name="deleted[]" value="'+deleted+'" />');        
      $(this).closest('tr').remove();
  });  

  $("#profitsTab").on('click','#pDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }

      deleted = 'profits|'+$(this).closest('tr').find('td:eq(0)').text();

      $('#agreement_save').prepend('<input type="hidden" name="deleted[]" value="'+deleted+'" />');        
      $(this).closest('tr').remove();
  });  

  $("#rentalTab").on('change', ".rLump", function (e) {
      
      $(this).closest('tr').find('input[type="hidden"]').eq(2).val(e.target.checked ? 1: 0);

  });

  $("#chargeTab").on('change', ".cLump", function (e) {
      
      $(this).closest('tr').find('input[type="hidden"]').eq(2).val(e.target.checked ? 1: 0);

  });


  $("#depositTab").on('change', ".chkLump", function (e) {     

      $(this).closest('tr').find('input[type="hidden"]').eq(2).val(e.target.checked ? 1: 0);      

  });

  $("#profitsTab").on('change', ".pLump", function (e) {     

      $(this).closest('tr').find('input[type="hidden"]').eq(4).val(e.target.checked ? 1: 0);      

  });

  function addRow(ci) {      

      var linenum=0;

      var max=GetDgvLineMaxNum('rentalTab', 0);
      linenum= Number(max) + 10;      

      if (typeof ci === 'undefined') { ci = linenum}

      $('#rentalTab tbody').append('<tr>'+
        '<td>' + linenum + '<input type="hidden" name="rline[]" value="'+ linenum +'" readonly /></td>'+
        '<td><div class="form-group form-group-sm"><?php echo form_dropdownext('rtype[]',$renttype, '', 'id="r_type_\'+ci+\'" class="droprental form-control input-sm" style="width: 100%;" required');?></div></td>'+    
		'<td><input type="text" id="invdate_'+ci+'" name="invdate[]" value="<?php echo date('Y-m-d');?>" class="tanggal form-control input-sm" /></td>'+   
		'<td><input type="text" id="tgldue_'+ci+'" name="tgldue[]" class="tanggal2 form-control input-sm" required/></td>'+ 		
        '<td><input type="text" id="r_pinst_'+ci+'" name="rpinst[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="r_sdate_'+ci+'" name="rsdate[]" value="<?php echo date('Y-m-d');?>" class="tanggal form-control input-sm" /></td>'+
        '<td><input type="text" id="r_rinstm_'+ci+'" name="rrinstm[]"  value="0" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="r_rinstd_'+ci+'" name="rrinstd[]" value="0" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="r_edate_'+ci+'" name="redate[]" value="<?php echo date('Y-m-d');?>" class="form-control input-sm" style= "text-align: center;" readonly/></td>'+
        '<td><input type="text" id="r_int_'+ci+'" name="rint[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;" /></td>'+
        '<td><?php echo form_dropdownext('rtitype[]',$titype, 'MONTH', 'id="r_time_\'+ci+\'" class="detil form-control input-sm" required');?></td>'+
        '<td><input type="text" id="r_per_'+ci+'" name="rper[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "r_unit_'+ci+'" name= "runit[]" required class="dropunit form-control input-sm" style="width: 100%;">'+
           '</select></div><input type="hidden" id="r_una_'+ci+'" name="runa[]" value="" /></td>'+
        '<td><input type="text" id="r_space_'+ci+'" name="rspace[]" onkeyup="this.value = minmaxsp(this.value, 0, 10000)" value="0" class="detil deci form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><input type="checkbox" id="lump_'+ci+'" class="rLump">'+
            '<input type="hidden" id="r_lumpsum_'+ci+'" name="rlumpsum[]" value="0"/></td>'+
        '<td><input type="text" id="r_base_'+ci+'" name="rbase[]" value="0" class="detil deci form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="text" id="r_mia_'+ci+'" name="rmia[]" value="0" class="detil deci form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="text" id="r_vat_'+ci+'" name="rvat[]" value="11" class="form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="text" id="r_ninst_'+ci+'" name="tninst[]" value="" class="form-control input-sm"/></td>'+
        '<td><input type="text" id="r_descr'+ci+'" name="rdescr[]" value="" class="pops form-control input-sm"/>'+
        '<input type="hidden" name="rstate[]" value="insert"/></td>'+
        '<td><a id= "rDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');          

      $('.deci').number( true, 2 );
      $('.bulet').number( true, 0 );     

      $('.tanggal').datepicker();
$('.tanggal2').datepicker();
      $('.dropunit').select2({    
          minimumInputLength: 0,
          placeholder: 'Select an option',
          ajax: {
              url: '<?php echo site_url('casual/casual/unit_select')?>',
              dataType: 'json',
              type: "GET",
              data: function (term) {
                  return {
                      term: term,
                      branch: $('#ibranch').val(),
                      region: $('#iregion').val(),
                      loonum: $('#agreement_loonumber').val()
                  };
              },
              processResults: function (data) {
                  return {
                      results: $.map(data.items, function (item) {                        
                          return {

                              sqm: item.unit_sqm,
                              text: item.unit_name,
                              region: item.region_id,
                              id: item.unit_id
                          }
                      })
                  };
              }
          }

      });      
      $('.droprental').select2({placeholder: 'Choose agreement type..'});

      $('#r_sdate_'+ci).on('change keyup', function() {

        var startDate = new Date($(this).val());
        var mTerm = parseInt($('#r_rinstm_'+ci).val());
        var dTerm = parseInt($('#r_rinstd_'+ci).val());
         
        $(this).closest('tr').find('input[type="text"]').eq(0).val(startDate.toISOString().substr(0,10)); 

        startDate.setMonth(startDate.getMonth() + mTerm);
        startDate.setDate(startDate.getDate() + -1);
        startDate.setDate(startDate.getDate() + dTerm);

        var dateFormated = startDate.toISOString().substr(0,10);

        $('#r_edate_'+ci).val(dateFormated);

      }); 

      $('#r_rinstm_'+ci).on('change keyup', function() {

        var startDate = new Date($('#r_sdate_'+ci).val());
        var mTerm = parseInt($(this).val());
        var dTerm = parseInt($('#r_rinstd_'+ci).val());

        startDate.setMonth(startDate.getMonth() + mTerm);
        startDate.setDate(startDate.getDate() + -1);
        startDate.setDate(startDate.getDate() + dTerm);

        var dateFormated = startDate.toISOString().substr(0,10);

        $('#r_edate_'+ci).val(dateFormated);

      });

      $('#r_rinstd_'+ci).on('change keyup', function() {

        var startDate = new Date($('#r_sdate_'+ci).val());
        var mTerm = parseInt($('#r_rinstm_'+ci).val());
        var dTerm = parseInt($(this).val());

        startDate.setMonth(startDate.getMonth() + mTerm);
        startDate.setDate(startDate.getDate() + -1);
        startDate.setDate(startDate.getDate() + dTerm);

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
        $(this).closest('tr').find('input[type="text"]').eq(9).val(uData['sqm']);
        
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
        '<td><input type="text" id="c_pinst_'+ci+'" name="cpinst[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
		'<td><input type="text" id="invdatesc_'+ci+'" name="invdatesc[]" value="<?php echo date('Y-m-d');?>" class="tanggal form-control input-sm" /></td>'+ 
		'<td><input type="text" id="tglduesc_'+ci+'" name="tglduesc[]" class="tanggal form-control input-sm" required/></td>'+ 	
        '<td><input type="text" id="c_sdate_'+ci+'" name="csdate[]" value="<?php echo date('Y-m-d');?>" class="tanggal form-control input-sm" /></td>'+
        '<td><input type="text" id="c_rinstm_'+ci+'" name="crinstm[]"  value="1" class="cinstm detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="c_rinstd_'+ci+'" name="crinstd[]" value="0" class="cinstd detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="c_edate_'+ci+'" name="cedate[]" value="<?php echo date('Y-m-d');?>" class="end form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="c_int_'+ci+'" name="cint[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><?php echo form_dropdownext('ctitype[]',$titype, 'MONTH', 'id="c_time_\'+ci+\'" class="detil form-control input-sm" required');?></td>'+
        '<td><input type="text" id="c_per_'+ci+'" name="cper[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "c_unit_'+ci+'" name= "cunit[]" required class="dropunit form-control input-sm" style="width: 100%;">'+
            '</select></div><input type="hidden" id="c_una_'+ci+'" name="cuna[]" value="" /></td>'+
        '<td><input type="text" id="c_space_'+ci+'" name="cspace[]" onkeyup="this.value = minmaxsp(this.value, 0, 10000)" value="0" class="detil deci form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><input type="checkbox" id="c_lump_'+ci+'" class="cLump" >'+
            '<input type="hidden" id="c_lumpsum_'+ci+'" name="clumpsum[]" value="0"/></td>'+
        '<td><input type="text" id="c_base_'+ci+'" name="cbase[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="text" id="c_mia_'+ci+'" name="cmia[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="text" id="c_vat_'+ci+'" name="cvat[]" value="11" class="form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="text" id="c_ninst_'+ci+'" name="cninst[]" value="" class="form-control input-sm"/></td>'+
        '<td><input type="text" id="c_descr'+ci+'" name="cdescr[]" value="" class="pops form-control input-sm"/>'+
        '<input type="hidden" name="cstate[]" value="insert"/></td>'+
        '<td><a id= "cDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');          

      $('.deci').number( true, 2 );
      $('.bulet').number( true, 0 );      

      $('.tanggal').datepicker();

      $('.dropunit').select2({    
          minimumInputLength: 0,
          placeholder: 'Select an option',
          ajax: {
              url: '<?php echo site_url('agreement/agreement/unit_select')?>',
              dataType: 'json',
              type: "GET",
              data: function (term) {
                  return {
                      term: term,
                      branch: $('#ibranch').val(),
                      region: $('#iregion').val(),
                      loonum: $('#agreement_loonumber').val()
                  };
              },
              processResults: function (data) {
                  return {
                      results: $.map(data.items, function (item) {                        
                          return {

                              sqm: item.unit_sqm,
                              text: item.unit_name,
                              region: item.region_id,
                              id: item.unit_id
                          }
                      })
                  };
              }
          }

      });    
      $('.dropcharge').select2({placeholder: 'Choose agreement type..'});

      $('#c_sdate_'+ci).on('change keyup', function() {

        var startDate = new Date($(this).val());
        var mTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(4).val());

        $(this).closest('tr').find('input[type="text"]').eq(1).val(startDate.toISOString().substr(0,10));

        startDate.setMonth(startDate.getMonth() + mTerm);
        startDate.setDate(startDate.getDate() + -1);

        var dateFormated = startDate.toISOString().substr(0,10);

        $('#c_edate_'+ci).val(dateFormated);

      });      

      $('#c_rinstm_'+ci).on('change keyup', function() {

        var startDate = new Date($('#c_sdate_'+ci).val());
        var mTerm = parseInt($(this).val());

        startDate.setMonth(startDate.getMonth() + mTerm);
        startDate.setDate(startDate.getDate() + -1);

        var dateFormated = startDate.toISOString().substr(0,10);

        $('#c_edate_'+ci).val(dateFormated);

      });
	  
	   $('#c_rinstd_'+ci).on('change keyup', function() {

        var startDate = new Date($('#c_sdate_'+ci).val());
        var mTerm = parseInt($('#c_rinstm_'+ci).val());
        var dTerm = parseInt($(this).val());

        startDate.setMonth(startDate.getMonth() + mTerm);
        startDate.setDate(startDate.getDate() + -1);
        startDate.setDate(startDate.getDate() + dTerm);

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
        $(this).closest('tr').find('input[type="text"]').eq(9).val(uData['sqm']);
        
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
        '<td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "d_unit_'+ci+'" name= "dunit[]" required class="dropunitd form-control input-sm" style="width: 100%;">'+
            '</select></div><input type="hidden" id="d_una_'+ci+'" name="duna[]" value="" /></td>'+
        '<td><input type="text" id="d_space_'+ci+'" name="dspace[]" value="0" class="detil deci form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><input type="checkbox" id="d_lump_'+ci+'" class="chkLump" >'+
            '<input type="hidden" id="d_lumpsum_'+ci+'" name="dlumpsum[]" value="0"/></td>'+
        '<td><input type="text" id="d_base_'+ci+'" name="dbase[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="text" id="d_mia_'+ci+'" name="dmia[]" value="0" class="clsmia detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="text" id="d_vat_'+ci+'" name="dvat[]" readonly value="0" class="detil bulet form-control input-sm" style= "text-align: right;" />'+
        '<input type="hidden" name="dstate[]" value="insert"/></td>'+
        '<td><a id= "dDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');          

      $('.deci').number( true, 2 );
      $('.bulet').number( true, 0 );      

      $('.tanggal').datepicker();

      $('.dropunitd').select2({    
          minimumInputLength: 0,
          placeholder: 'Select an option',
          ajax: {
              url: '<?php echo site_url('agreement/agreement/unit_select')?>',
              dataType: 'json',
              type: "GET",
              data: function (term) {
                  return {
                      term: term,
                      branch: $('#ibranch').val(),
                      region: $('#iregion').val(),
                      loonum: $('#agreement_loonumber').val()
                  };
              },
              processResults: function (data) {
                  return {
                      results: $.map(data.items, function (item) {                        
                          return {

                              sqm: item.unit_sqm,
                              text: item.unit_name,
                              region: item.region_id,
                              id: item.unit_id
                          }
                      })
                  };
              }
          }

      });     
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

      $('.dropunitd').on("select2:select", function(e){
        var uData = e.params.data;

        /* console.log(uData); */        
        $(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['text']);
        $(this).closest('tr').find('input[type="text"]').eq(2).val(uData['sqm']);
        
      });

	

	$( ".clsmia" ).keyup(function() {
  		var $select = $(".dropdepo").parent().find("select"); 
	 	var SelectedOptionText=$(this).closest('tr').find(':selected').eq(0).val();
		var nilcn=$(this).closest('tr').find('input[type="text"]').eq(4).val();
		if (SelectedOptionText=='7200'){
			if(nilcn >= 0){
				alert('Credit Note Must be in negative value');
			}
		}
		
		
	});

  }

  function addRowProfits(ci) {      

      var linenum=0;

      var max=GetDgvLineMaxNum('profitsTab', 0);
      linenum= Number(max) + 10;

      if (typeof ci === 'undefined') { ci = linenum}

      $('#profitsTab tbody').append('<tr>'+
        '<td>' + linenum + '<input type="hidden" name="pline[]" value="'+ linenum +'" readonly class="nogaris"/></td>'+
        '<td><input type="checkbox" id="upload" class="chkUpload" disabled><input type="hidden" id="p_upload" name="pupload[]" value=0 /></td>'+
        '<td><input type="checkbox" id="post" class="chkPost" disabled><input type="hidden" id="p_post" name="ppost[]" value=0 /></td>'+        
        '<td><div class="form-group form-group-sm"><?php echo form_dropdownext('ptype[]',$protype, '', 'id="p_type_\'+ci+\'" class="droppro form-control input-sm" style="width: 100%;" required');?></div></td>'+
        '<td><input type="text" id="p_sdate_'+ci+'" name="psdate[]" value="<?php echo date('Y-m-d');?>" class="tanggal form-control input-sm" /></td>'+
        '<td><input type="text" id="p_term_'+ci+'" name="pterm[]" value="0" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="p_dayterm_'+ci+'" name="pdayterm[]" value="0" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
        '<td><input type="text" id="p_edate_'+ci+'" name="pedate[]" value="<?php echo date('Y-m-d');?>" class="form-control input-sm" style= "text-align: center;" readonly/></td>'+
        '<td><?php echo form_dropdownext('ptitype[]', $titype, 'MONTH', 'id="p_time_\'+ci+\'" class="detil form-control input-sm" required');?></td>'+
        '<td><div class="form-group form-group-sm">'+
          '<select data-placeholder = "Select unit" id="p_unit" name= "punit[]" required class="dropunitcs form-control input-sm" style="width: 100%;">'+          
          '</select></div><input type="hidden" id="p_una_'+ci+'" name="puna[]" value="" /></td>'+
        '<td><input type="text" id="p_space" name="pspace[]" value="0" class="detil deci form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><div class="input-group input-group-sm"><input type="text" id="p_idps" name="pidps[]" value="" class="detil form-control input-sm" />'+
          '<span class="input-group-btn">'+
            '<button id ="plook" type="button" class="btn blue btn-primary btn-sm"><i class="fa fa-search"></i></button>'+
           '</span></div></td>'+
        '<td><input type="text" id="p_psdesc" name="ppsdesc[]" value="" class="detil form-control input-sm" /></td>'+
        '<td><a id= "plook" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i></a></td>'+
        '<td><input type="text" id="p_omset" name="pomset[]" value="0" class="detil form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="checkbox" id="lump" class="pLump"><input type="hidden" id="p_lumpsum" name="plumpsum[]" value="0"/></td>'+
        '<td><input type="text" id="p_mia" name="pmia[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><input type="text" id="p_vat" name="pvat[]" value="11" class="detil bulet form-control input-sm" style= "text-align: right;" />'+
        '<input type="hidden" name="pstate[]" value="insert"/></td>'+
        '<td><a id= "pDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');

      $('.deci').number( true, 2 );
      $('.bulet').number( true, 0 );      

      $('.tanggal').datepicker();

      $('.dropunitcs').select2({    
          minimumInputLength: 0,
          placeholder: 'Select an option',
          ajax: {
              url: '<?php echo site_url('casual/casual/unit_select')?>',
              dataType: 'json',
              type: "GET",
              data: function (term) {
                  return {
                      term: term,
                      branch: $('#ibranch').val(),
                      region: $('#iregion').val(),
                      loonum: $('#agreement_loonumber').val()
                  };
              },
              processResults: function (data) {
                  return {
                      results: $.map(data.items, function (item) {                        
                          return {

                              sqm: item.unit_sqm,
                              text: item.unit_name,
                              region: item.region_id,
                              id: item.unit_id
                          }
                      })
                  };
              }
          }

      });  

      $('#p_sdate_'+ci).on('change keyup', function() {

        var startDate = new Date($(this).val());
        var mTerm = parseInt($('#p_term_'+ci).val());
        var dTerm = parseInt($('#p_dayterm_'+ci).val());

        startDate.setMonth(startDate.getMonth() + mTerm);
        startDate.setDate(startDate.getDate() + -1);
        startDate.setDate(startDate.getDate() + dTerm);

        var dateFormated = startDate.toISOString().substr(0,10);

        $('#p_edate_'+ci).val(dateFormated);

      }); 

      $('#p_term_'+ci).on('change keyup', function() {
        
        var startDate = new Date($('#p_sdate_'+ci).val());
        var mTerm = parseInt($(this).val());
        var dTerm = parseInt($('#p_dayterm_'+ci).val());

        //$(this).closest('tr').find('input[type="text"]').eq(0).val(startDate.toISOString().substr(0,10)); 
        startDate.setMonth(startDate.getMonth() + mTerm);
        startDate.setDate(startDate.getDate() + -1);
        startDate.setDate(startDate.getDate() + dTerm);

        var dateFormated = startDate.toISOString().substr(0,10);

        $('#p_edate_'+ci).val(dateFormated);

      }); 

      $('#p_dayterm_'+ci).on('change keyup', function() {
        
        var startDate = new Date($('#p_sdate_'+ci).val());
        var mTerm = parseInt($('#p_term_'+ci).val());
        var dTerm = parseInt($(this).val());

        //$(this).closest('tr').find('input[type="text"]').eq(0).val(startDate.toISOString().substr(0,10)); 
        startDate.setMonth(startDate.getMonth() + mTerm);
        startDate.setDate(startDate.getDate() + -1);
        startDate.setDate(startDate.getDate() + dTerm);

        var dateFormated = startDate.toISOString().substr(0,10);

        $('#p_edate_'+ci).val(dateFormated);

      }); 

      $('.droppro').select2({placeholder: 'Choose agreement type..'});
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
        //$(this).closest('tr').find('input[type="hidden"]').eq(2).val(uData['text']);
        $('#p_una_'+ci).val(uData['text']);
        $(this).closest('tr').find('input[type="text"]').eq(5).val(uData['sqm']);                
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


  $.fn.datepicker.defaults.format = "yyyy-mm-dd";
  $.fn.datepicker.defaults.autoclose = true;

$(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );

</script>

<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

#rentalTab th, #rentalTab td, #rentalTab label {

    font-size: 9pt;
    white-space: nowrap;    
}

#chargeTab th, #chargeTab td, #chargeTab label {

    font-size: 9pt;
    white-space: nowrap;    
}

#depositTab th, #depositTab td, #depositTab label {
    font-size: 9pt;
    white-space: nowrap;    
}

#profitsTab th, #profitsTab td, #profitsTab label {
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

.select2-container {
  min-width:120px;
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
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">&nbsp;#</th>
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

<!-- /.popup-profit sharing -->
<div class="modal fade" id="psdialog" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        </button>
        <h4 class="modal-title">
          Table Profit Sharing
        </h4>
      </div>
      <div class="modal-body">
        <form action="#" id="form" class="form-horizontal">
        <div class="row">
        <div class="col-md-8">
           <label>Search Profit ID</label>
          <input  type="text" id="searchProfit" class="form-control input-sm" placeholder="Search Profit" >
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
            <table class="table table-striped table-bordered table-hover compact nowrap" id='proLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
              <thead>
               <tr>
                <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">&nbsp;#</th>
                <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Description</th>
                <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
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
        <button type="button" class="btn green" data-dismiss="modal" id="addProfitID">
          Add Selected Data
        </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

            <!-- /.popup-loc-renewal -->
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
                            <input type="radio" name="lookup" value="oto" checked="checked" /><b>Renewal By LOC</b>
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="lookup" value="man" /><b>Renewal Manual</b>
                          </label>
                          
                        </div>
                      </div>
                      <br>
                      <!-- Custom Tabs -->
                      <div class="nav-tabs-custom">
                        <ul class="custom nav nav-tabs">
                          <li class="active"><a href="#tab_1_find" role= "tab">Finding LOC</a></li>
                          <li><a href="#tab_2_detil" role= "tab" >Detil LOC</a></li>
                          <li><a href="#tab_3_manual"role= "tab" >Manual</a></li>
                        </ul>
                        <div class="tab-content">                                    
                          <div class="tab-pane active" id="tab_1_find">
                            <div class="row">
                             <div class="col-md-6">
                              <div class="col-xs-12">
                                 <label>LOC No.</label>
                                 <input type="text" id= "locSearch" name="locSearch" class="form-control input-sm" value="">
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
                             <div class="col-md-6 form-group-sm">
                                <div class="col-xs-12">
                                   <label>Store</label>
                                   <select id="branchSearch" class="form-control" style="width: 100%;"> </select> 
                                </div>
                             </div> 
                             <div class="col-md-6">
                              <div class="col-xs-12">
                                 <label>Trade Name</label>
                                 <input type="text" id="agreement_modifydate" name="agreement_modifydate" class="form-control input-sm" value="">
                              </div>
                             </div>
                             <div class="col-md-6 form-group-sm">
                                <div class="col-xs-12">
                                   <label>Business Unit</label>
                                   <?php echo form_dropdown('regionSearch',$region,'','id ="regionSearch" class="form-control" style="width: 100%;" disabled'); ?>
                                </div>
                             </div>
                             <div class="col-md-6" align="right">
                              <div class="col-xs-12">
                                <br>
                               <button id="btnSearch" type="button" class="btn btn-sm btn-primary">
                                  <i class="fa fa-history"></i> LOAD LOC
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
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">LOC No.</th>
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
             <!-- /.end renewal -->

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
                          <a href="<?php echo base_url('index.php/casual/casual/casuallist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>                          
                          <a href="<?php echo base_url('index.php/casual/casual/casualadd'); ?>" id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata" data-toggle="tab"  id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane" id="editdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('casual/casual/casual_edit');?>" method="post" onsubmit="return validateb4submit();"
                            id="agreement_save">
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
                                      <label class="post isclosed checkbox-inline pull-right"><input type="checkbox" <?php if ($row->agreement_isclosed == 1) echo 'checked= "checked"';?> disabled>Closed</label>
                                      <label class="post isrenewal checkbox-inline pull-right"><input type="checkbox" <?php if ($row->agreement_isrenewal == 1) echo 'checked= "checked"';?> disabled>Renewal&nbsp;
                                        <input type="hidden" id="hrenewal" name="hrenewal" value="<?php echo $row->agreement_isrenewal;?>"/>
                                      </label>
                                      <label class="post checkbox-inline pull-right"><input type="checkbox" <?php if ($row->agreement_isapproved == 1) echo 'checked= "checked"';?> disabled>Approved&nbsp;</label>
                                      <input  type="text" id="agreement_id" name="agreement_id" class="form-control input-sm" value="<?php echo $row->agreement_id;?>" readonly>
                                    </div>
                                  </div>                                 
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                        <label>Debtor No.</label>
                                        <div class="input-group input-group-sm">
                                          <input type="text" id = "idebtor" name="idebtor" class="form-control input-sm" value="<?php echo $row->agreement_contractno;?>" readonly required autocomplete="off">
                                          <span class="input-group-btn">
                                            <button id ="btRenewal" type="button" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
                                          </span>
                                        </div>
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
                                          <option value="<?php echo $row->branch_id;?>" selected="selected" ><?php echo $row->branch_name;?></option>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                    <label>Business Unit</label>
                                      <?php echo form_dropdown('iregion',$region,$row->region_id,'id ="iregion" class="form-control" style="width: 100%;" required disabled '); ?>
                                    </div>
                                    <input type="hidden" id = "cboregion" name="cboregion" value="<?php echo $row->region_id; ?>">
                                  </div>
                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                      <label>Strukturunit</label>                                        
                                        <?php echo form_dropdown('cbostruktur',$strukturunit,$row->strukturunit_id,'id ="istruk" class="form-control" style="width: 100%;" required '); ?>
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Tenant</label>
                                      <div class="input-group input-group-sm">
                                        <input type="text" id = "itenant" name="itenant" class="form-control input-sm" value="<?php echo $row->rekanan_name;?>" required autocomplete="off">
                                        <span class="input-group-btn">
                                          <button id ="bttenant" type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                        </span> 
                                      <input type="hidden" id = "htenant" name="htenant" value="<?php echo $row->rekanan_id;?>">
                                      </div>
                                    </div>
                                  </div>    
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                        <label>Brand Name</label>
                                        <input type="hidden" id = "hbrand" name="hbrand" value="<?php echo $row->rekananshipping_line;?>">
                                        <input type="text" id = "ibrand" name="ibrand" class="form-control input-sm" value="<?php echo $row->rekananshipping_name;?>" readonly required autocomplete="off">
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                        <label>Virtual Account</label>
                                        <input type="text" id = "ivirtual" name="ivirtual" class="form-control input-sm" value="<?php echo $row->agreement_virtualaccount;?>" readonly required autocomplete="off">
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
                                        <input type="text" id = "agreement_loonumber" name="agreement_loonumber" class="form-control input-sm" value="<?php echo $row->agreement_loonumber; ?>" readonly>
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>LOI No.</label>
                                        <input type="text" id = "agreement_contractlongnumber" name="agreement_contractlongnumber" class="form-control input-sm" value="<?php echo $row->agreement_contractlongnumber; ?>" >
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
                                          style="text-align: right;" value="<?php echo $row->agreement_term;?>">
                                        <span class="input-group-addon" style="font-style: italic;">(M)</span>
                                      </div>
                                    </div>
                                    <div class="col-xs-6">
                                      <label></label>  
                                      <div class="input-group input-group-sm">
                                        <input type="text" id = "agreement_dayterm" name="agreement_dayterm" class="bulet form-control input-sm"
                                          style="text-align: right;" value="<?php echo $row->agreement_dayterm;?>">
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
                                        <input type="text" class="form-control input-sm pull-right" id="agreement_endperiod" name="agreement_endperiod" value= "<?php echo $row->agreement_endperiod;?>" readonly>
                                      </div>
                                    </div>
                                  </div>                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Size Indoor</label>
                                        <input data-placeholder="Size Indoor (Angka)" type="text" id = "size_indoor" name="size_indoor" 
                                          class="bulet form-control input-sm" value="<?php echo $row->size_indoor;?>" style="text-align: right;">
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Size Outdoor</label>
                                        <input data-placeholder="Size Outdoor (Angka)" type="text" id = "size_outdoor" name="size_outdoor" 
                                          class="bulet form-control input-sm" value="<?php echo $row->size_outdoor;?>" style="text-align: right;">
                                    </div>
                                  </div>                                                            
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Fitting Out</label>
                                        <input data-placeholder="Fitting Out (Angka)" type="text" id = "fitting_out" name="fitting_out" 
                                          class="bulet form-control input-sm" value="<?php echo $row->fitting_out;?>" style="text-align: right;">
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Grace Period</label>
                                        <input data-placeholder="Grace Period (Angka)" type="text" id = "grace_periode" name="grace_periode" 
                                          class="bulet form-control input-sm" value="<?php echo $row->grace_periode;?>" style="text-align: right;">
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                        <label>Product Name:</label> 
                                        <input data-placeholder="Product Name" type="text" id = "product_name" name="product_name" class="form-control input-sm" value="<?php echo $row->dagangan;?>">
                                    </div>
                                  </div>                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>BAP Date</label>    
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>                                
                                        <input type="text" class="form-control input-sm" id="agreement_bapdate" name="agreement_bapdate" value="<?php echo $row->agreement_bapdate;?>">                                      
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-11 form-group row">                                    
                                    <div class="col-xs-12">
                                      <label>Description:</label>
                                      <textarea id = "agreement_descr" name="agreement_descr" class="form-control input-sm" required rows="2" ><?php echo $row->agreement_descr;?></textarea>
                                    </div>                                    
                                  </div>       
                                  <div class="col-md-12 form-group row"></div>
                                  <div class="col-md-4 form-group row">
                                    <label class="col-sm-4">Ref No.</label>        
                                    <div class = "col-sm-8">                                                          
                                      <input type="text" id = "agreement_ref" name="agreement_ref" class="form-control input-sm" value="<?php echo $row->agreement_ref;?>" readonly>
                                    </div>                                    
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <label class="col-sm-4">Renewal No.</label>        
                                    <div class = "col-sm-8">                                                          
                                      <input type="text" id = "agreement_renewalno" name="agreement_renewalno" class="form-control input-sm" 
                                        value="<?php echo $row->agreement_renewalno;?>" readonly>
                                    </div>                                    
                                  </div>
                                  <div class="col-md-4 form-group row form-group-sm">
                                    <label class="col-sm-4">Base Rent Rate</label>        
                                    <div class = "col-sm-8">                    
                                      <div class="input-group input-group-sm">
                                        <input type="text" id = "agreement_idr" name="agreement_idr" class="bulet form-control input-sm"
                                          style="text-align: right;font-weight: bold;" value="<?php echo $row->agreement_idr;?>" readonly>
                                        <span class="input-group-addon" style="font-style: italic;">Rp.</span>
                                      </div>
                                    </div>  
                                  </div> 
                                  <div class="col-md-12 form-group row"></div>
                                  <div class="col-md-4 form-group row">
                                    <label class="col-sm-4">Aden No.</label>        
                                    <div class = "col-sm-8">                                                          
                                      <input type="text" id = "ref_id" name="ref_id" class="form-control input-sm" value="<?php echo $row->ref_id;?>" readonly>
                                    </div>                                    
                                  </div>
                                  <div class="col-md-4 form-group row"></div>
                                  <div class="col-md-4 form-group row form-group-sm">
                                    <label class="col-sm-4">Total Lease Value</label>        
                                    <div class = "col-sm-8">
                                      <div class="input-group input-group-sm">
                                        <input type="text" id = "agreement_tlv" name="agreement_tlv" class="bulet form-control input-sm"
                                          style="text-align: right;font-weight: bold;" value="<?php echo $row->agreement_tlv;?>" readonly>
                                        <span class="input-group-addon" style="font-style: italic;">Rp.</span>
                                      </div>
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
                                          <li><a href="#tab_4" data-toggle="tab" role = "tab">Profit Sharing</a></li>
                                          <li><a href="#tab_5" data-toggle="tab" role = "tab">Record</a></li>
                                        </ul>
                                        <div class="tab-content">
                                          <div class="tab-pane active" id="tab_1">
                                            <div class ="table-responsive">
                                              <table class="table table-bordered table-striped" id='rentalTab' style="border:solid 1px #999; #999; border-radius:0px;">
                                                <thead>
                                                  <tr>
                                                      <th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Line</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Transaction Type</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">&nbsp;&nbsp;&nbsp;Invoice Date&nbsp;&nbsp;&nbsp;</th>
													  <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">&nbsp;&nbsp;&nbsp;Invoice Due Date&nbsp;&nbsp;&nbsp;</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">P. Inst</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Start Date Trans.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">R.Ins(M)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">R.Ins(D)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">End Date Trans.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Intval.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Time Unit.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Per(%)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Unit</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Space</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Lump.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Base Rent IDR</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Monthly Installment</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">VAT(%)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">n-Inst.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Descr</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Delete</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <?php if(isset($resultr)){                                                          
                                                      foreach($resultr as $rowr){
                                                  ?>
                                                    <tr>
                                                    <td><?php echo "$rowr->agreementdetil_line";?><input type="hidden" name="rline[]" value="<?php echo "$rowr->agreementdetil_line";?>"/></td>
                                                    <td><div class="form-group form-group-sm">
                                                        <?php echo form_dropdownext('rtype[]',$renttype, $rowr->agreementtype_id, 'r_type" class="droprental form-control input-sm" style="width: 100%;" required');?>
                                                        </div>
                                                    </td>
                                                    <td><input type="text" id="invdate" name="invdate[]" value="<?php 
													/*$dS = new DateTime($rowr->agreementdetil_startdatepayment);echo $dS->format('Y-m-d');*/if ($rowr->agreementdetil_startdatepayment==''){
					$dS = new DateTime($rowr->agreementdetil_startdate);echo $dS->format('Y-m-d');	
													}else{
				$dS = new DateTime($rowr->agreementdetil_startdatepayment);echo $dS->format('Y-m-d');	
													}
													
													?>" class="rstrans form-control input-sm" /></td>
													 <td><input type="text" id="tgldue" name="tgldue[]" value="<?php 
													$dS = new DateTime($rowr->agreementdetil_tgldue);echo $dS->format('Y-m-d');													
													?>" class="tanggal2 form-control input-sm" required /></td>
                                                    <td><input type="text" id="r_pinst" name="rpinst[]" value="<?php echo $rowr->agreementdetil_installmentpayment;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                    <td><input type="text" id="r_sdate" name="rsdate[]" value="<?php $dS = new DateTime($rowr->agreementdetil_startdate);echo $dS->format('Y-m-d');?>" class="rstrans form-control input-sm" /></td>
                                                    <td><input type="text" id="r_rinstm" name="rrinstm[]" value="<?php echo $rowr->agreementdetil_installment;?>" class="rinstm detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                    <td><input type="text" id="r_rinstd" name="rrinstd[]" value="<?php echo $rowr->agreementdetil_dayinstallment;?>" class="rinstd detil bulet form-control input-sm" style= "text-align: center;" required /></td>
                                                    <td><input type="text" id="r_edate" name="redate[]" value="<?php $dE = new DateTime($rowr->agreementdetil_enddate);echo $dE->format('Y-m-d');?>" class="end form-control input-sm" style= "text-align: center;"/></td>
                                                    <td><input type="text" id="r_int_'+ci+'" name="rint[]" value="<?php echo $rowr->agreementdetil_interval;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                    <td><?php echo form_dropdownext('rtitype[]',$titype, $rowr->timetype_id, 'id="r_time" class="detil form-control input-sm" required');?></td>
                                                    <td><input type="text" id="r_per_'+ci+'" name="rper[]" value="<?php echo $rowr->agreementdetil_percent;?>" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>
                                                    <td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "r_unit" name= "runit[]" required class="dropunit rental form-control input-sm" style="width: 100%;">
                                                        <option value="<?php echo $rowr->unit_id;?>" selected="selected" ><?php echo $rowr->unit_name;?></option>
                                                        </select></div><input type="hidden" id="r_una_" name="runa[]" value="<?php echo $rowr->agreementdetil_unit;?>" /></td>
                                                    <td><input type="text" id="r_space" name="rspace[]" onkeyup="this.value = minmaxsp(this.value, 0, 10000)" value="<?php echo $rowr->agreementdetil_space;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>
                                                    <td><input type="checkbox" id="lump" <?php if ($rowr->agreementdetil_islumpsum == 1) echo 'checked= "checked"';?> class="rLump" >
                                                        <input type="hidden" id="r_lumpsum" name="rlumpsum[]" value = "<?php echo "$rowr->agreementdetil_islumpsum"; ?>"/></td>
                                                    <td><input type="text" id="r_base" name="rbase[]" value="<?php echo $rowr->agreementdetil_baserent;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                    <td><input type="text" id="r_mia" name="rmia[]" value="<?php echo $rowr->agreementdetil_mia;?>" class="rmia detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                    <td><input type="text" id="r_vat" name="rvat[]" value="<?php echo $rowr->agreementdetil_tax;?>" class="form-control input-sm" style= "text-align: right;" /></td>
                                                    <td><input type="text" id="r_ninst" name="tninst[]" value="" class="form-control input-sm"/></td>
                                                    <td><input type="text" id="r_descr" name="rdescr[]" value="<?php echo $rowr->agreementdetil_descr;?>" class="pops form-control input-sm"/>
                                                        <input type="hidden" name="rstate[]" value="update"/></td>
                                                    <td><a id= "rDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
                                                    </tr>
                                                    <script>
                                                    //$('.bulet').number( true, 0 );                                                      
                                                    $('.rstrans').datepicker();
													 $('.tanggal2').datepicker();
                                                    $('.end').datepicker();
                                                    $('.rstrans').on('change keyup', function() {                                                        

                                                      var startDate = new Date($(this).val());
                                                      var mTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(4).val());   
                                                      var dTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(5).val());

                                                      $(this).closest('tr').find('input[type="text"]').eq(0).val(startDate.toISOString().substr(0,10));
                                                      startDate.setMonth(startDate.getMonth() + mTerm);
                                                      startDate.setDate(startDate.getDate() + -1);
                                                      startDate.setDate(startDate.getDate() + dTerm);

                                                      var dateFormated = startDate.toISOString().substr(0,10);   

                                                      $(this).closest('tr').find('input[type="text"]').eq(6).val(dateFormated);

                                                    }); 
                                                    $('.rinstm').on('change keyup', function() {                                                        

                                                      var startDate = new Date($(this).closest('tr').find('input[type="text"]').eq(3).val())
                                                      
													 
													  
													  var mTerm = parseInt($(this).val()); 
                                                      var dTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(5).val());

                                                     startDate.setMonth(startDate.getMonth() + mTerm);
                                                      startDate.setDate(startDate.getDate() + -1);
                                                      startDate.setDate(startDate.getDate() + dTerm);

                                                      var dateFormated = startDate.toISOString().substr(0,10);

                                                      $(this).closest('tr').find('input[type="text"]').eq(6).val(dateFormated);

                                                    }); 

                                                    $('.rinstd').on('change keyup', function() {                                                        

                                                      var startDate = new Date($(this).closest('tr').find('input[type="text"]').eq(3).val())
                                                      var mTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(4).val());
                                                      var dTerm = parseInt($(this).val());

                                                      startDate.setMonth(startDate.getMonth() + mTerm);
                                                      startDate.setDate(startDate.getDate() + -1);
                                                      startDate.setDate(startDate.getDate() + dTerm);

                                                      var dateFormated = startDate.toISOString().substr(0,10);

                                                      $(this).closest('tr').find('input[type="text"]').eq(6).val(dateFormated);

                                                    }); 
                                                    
                                                    $('.dropunit.rental').on("select2:select", function(e){
                                                      var uData = e.params.data;                                                      
   
                                                      $(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['text']);
                                                      $(this).closest('tr').find('input[type="text"]').eq(9).val(uData['sqm']);
                                                      
                                                    });
                                                    
                                                    </script>
                                                  <?php
                                                     }
                                                   }
                                                  ?>
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
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">P. Inst</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">&nbsp;&nbsp;&nbsp;Invoice Date.&nbsp;&nbsp;&nbsp;</th>
													  <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">&nbsp;&nbsp;&nbsp;Invoice Due Date.&nbsp;&nbsp;&nbsp;</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Start Date Trans.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">R.Ins(M)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">R.Ins(D)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">End Date Trans.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Intval.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Time Unit.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Per(%)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Unit</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Space</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Lump.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Base Rent IDR</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Monthly Installment</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">VAT(%)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">n-Inst.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Descr</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Delete</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <?php if(isset($resultc)){                                                        
                                                      foreach($resultc as $rowc){

                                                  ?>
                                                    <tr>
                                                    <td><?php echo "$rowc->agreementdetil_line";?><input type="hidden" name="cline[]" value="<?php echo "$rowc->agreementdetil_line";?>"/></td>
                                                    <td><div class="form-group form-group-sm">
                                                        <?php echo form_dropdownext('ctype[]',$chgtype, $rowc->agreementtype_id, 'c_type" class="droprental form-control input-sm" style="width: 100%;" required');?>
                                                        </div>
                                                    </td>
                                                    <td><input type="text" id="c_pinst" name="cpinst[]" value="<?php echo $rowc->agreementdetil_installmentpayment;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                    
                                                    <td><input type="text" id="invdatesc" name="invdatesc[]" value="<?php 
													/*$dS = new DateTime($rowr->agreementdetil_startdatepayment);echo $dS->format('Y-m-d');*/if ($rowc->agreementdetil_startdatepayment==''){
					$dS = new DateTime($rowc->agreementdetil_startdate);echo $dS->format('Y-m-d');	
													}else{
				$dS = new DateTime($rowc->agreementdetil_startdatepayment);echo $dS->format('Y-m-d');	
													}
?>" class="csdatecharge form-control input-sm" /></td>
<td><input type="text" id="tglduesc" name="tglduesc[]" value="<?php 
													$dS = new DateTime($rowc->agreementdetil_tgldue);echo $dS->format('Y-m-d');													
													?>" class="csdatecharge form-control input-sm" required />
                                                    <td><input type="text" id="c_sdate" name="csdate[]" value="<?php $dS = new DateTime($rowc->agreementdetil_startdate);echo $dS->format('Y-m-d');?>" class="cstrans form-control input-sm" /></td>
                                                    <td><input type="text" id="c_rinstm" name="crinstm[]" value="<?php echo $rowc->agreementdetil_installment;?>" class="cinstm detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                    <td><input type="text" id="c_rinstd" name="crinstd[]" value="<?php echo $rowc->agreementdetil_dayinstallment;?>" class="cinstd detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                    <td><input type="text" id="c_edate" name="cedate[]" value="<?php $dE = new DateTime($rowc->agreementdetil_enddate);echo $dE->format('Y-m-d');?>" class="end form-control input-sm" style= "text-align: center;"/></td>
                                                    <td><input type="text" id="c_int" name="cint[]" value="<?php echo $rowc->agreementdetil_interval;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                    <td><?php echo form_dropdownext('ctitype[]',$titype, $rowc->timetype_id, 'id="c_time" class="detil form-control input-sm" required');?></td>
                                                    <td><input type="text" id="c_per" name="cper[]" value="<?php echo $rowc->agreementdetil_percent;?>" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>
                                                    <td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "c_unit" name= "cunit[]" required class="dropunit charge form-control input-sm" style="width: 100%;">
                                                        <option value="<?php echo $rowc->unit_id;?>" selected="selected" ><?php echo $rowc->unit_name;?></option>
                                                        </select></div><input type="hidden" id="c_una_" name="cuna[]" value="<?php echo $rowc->agreementdetil_unit;?>" /></td>
                                                    <td><input type="text" id="c_space" name="cspace[]" onkeyup="this.value = minmaxsp(this.value, 0, 10000)" value="<?php echo $rowc->agreementdetil_space;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>
                                                    <td><input type="checkbox" id="c_lump" <?php if ($rowc->agreementdetil_islumpsum == 1) echo 'checked= "checked"';?> class="cLump">
                                                        <input type="hidden" id="c_lumpsum" name="clumpsum[]" value = "<?php echo "$rowc->agreementdetil_islumpsum"; ?>"/></td>
                                                    <td><input type="text" id="c_base" name="cbase[]" value="<?php echo $rowc->agreementdetil_baserent;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                    <td><input type="text" id="c_mia" name="cmia[]" value="<?php echo $rowc->agreementdetil_mia;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                    <td><input type="text" id="c_vat" name="cvat[]" value="<?php echo $rowc->agreementdetil_tax;?>" class="form-control input-sm" style= "text-align: right;" /></td>                                                    
                                                    <td><input type="text" id="c_ninst" name="cninst[]" value="" class="form-control input-sm"/></td>
                                                    <td><input type="text" id="c_descr" name="cdescr[]" value="<?php echo $rowc->agreementdetil_descr;?>" class="pops form-control input-sm"/>
                                                        <input type="hidden" name="cstate[]" value="update"/></td>
                                                    <td><a id= "cDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
                                                    </tr>
                                                    <script>
                                                      $('.cstrans').datepicker();
													   $('.csdatecharge').datepicker();
                                                      $('.end').datepicker();       
                                                      $('.cstrans').on('change keyup', function() {                                                        

                                                        var startDate = new Date($(this).val());
                                                        var mTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(4).val());                                                    
														$(this).closest('tr').find('input[type="text"]').eq(1).val(startDate.toISOString().substr(0,10));
                                                        startDate.setMonth(startDate.getMonth() + mTerm);
                                                        startDate.setDate(startDate.getDate() + -1);

                                                        var dateFormated = startDate.toISOString().substr(0,10);   

                                                        $(this).closest('tr').find('input[type="text"]').eq(6).val(dateFormated);
														
														

                                                      });  
													
													                                              
                                                      $('.cinstm').on('change keyup', function() {                                                        

                                                        var startDate = new Date($(this).closest('tr').find('input[type="text"]').eq(3).val())
                                                        var mTerm = parseInt($(this).val());

                                                        startDate.setMonth(startDate.getMonth() + mTerm);
                                                        startDate.setDate(startDate.getDate() + -1);

                                                        var dateFormated = startDate.toISOString().substr(0,10);

                                                        $(this).closest('tr').find('input[type="text"]').eq(6).val(dateFormated);

                                                      });  

													$('.cinstd').on('change keyup', function() {                                                        

                                                      var startDate = new Date($(this).closest('tr').find('input[type="text"]').eq(3).val())
                                                      var mTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(4).val());
                                                      var dTerm = parseInt($(this).val());

                                                      startDate.setMonth(startDate.getMonth() + mTerm);
                                                      startDate.setDate(startDate.getDate() + -1);
                                                      startDate.setDate(startDate.getDate() + dTerm);

                                                      var dateFormated = startDate.toISOString().substr(0,10);

                                                      $(this).closest('tr').find('input[type="text"]').eq(6).val(dateFormated);

                                                    }); 
                                                    													  




													  
                                                      $('.dropunit.charge').on("select2:select", function(e){
                                                          var uData = e.params.data;

                                                          $(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['text']);
                                                          $(this).closest('tr').find('input[type="text"]').eq(9).val(uData['sqm']);
                                                          
                                                      });                                                      
                                                    </script>
                                                  <?php
                                                     }
                                                   }
                                                  ?>
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
                                                   <?php if(isset($resultd)){
                                                        foreach($resultd as $rowd){
                                                    ?>
                                                      <tr>
                                                      <td><?php echo $rowd->agreementdeposit_line;?><input type="hidden" name="dline[]" value="<?php echo $rowd->agreementdeposit_line;?>"/></td>
                                                      <td><div class="form-group form-group-sm"><?php echo form_dropdownext('dtype[]',$deptype, $rowd->agreementtype_id, 'id="d_type" class="dropdepo form-control input-sm" style="width: 100%;" required');?></div></td>
                                                      <td><input type="text" id="d_sdate" name="dsdate[]" value="<?php $dS = new DateTime($rowd->agreementdeposit_startdate);echo $dS->format('Y-m-d');?>" class="dstart form-control input-sm" /></td>
                                                      <td><input type="text" id="d_due" name="ddue[]" value="<?php echo $rowd->agreementdeposit_duedate;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                      <td><?php echo form_dropdownext('dtitype[]', $titype, $rowd->timetype_id, 'id="d_time" class="detil form-control input-sm" required');?></td>
                                                      <td><div class="form-group form-group-sm">
                                                          <select data-placeholder = "Select unit" id= "d_unit" name= "dunit[]" required class="dropunit deposit form-control input-sm" style="width: 100%;">
                                                            <option value="<?php echo $rowd->unit_id;?>" selected="selected" ><?php echo $rowd->unit_name;?></option>
                                                          </select></div><input type="hidden" id="d_una" name="duna[]" value="<?php echo $rowd->unit_name;?>" /></td>
                                                      <td><input type="text" id="d_space" name="dspace[]" value="<?php echo $rowd->agreementdeposit_space;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>
                                                      <td><input type="checkbox" id="d_lump" class="chkLump" <?php if ($rowd->agreementdeposit_islumpsum == 1) echo 'checked= "checked"';?> >
                                                          <input type="hidden" id="d_lumpsum" name="dlumpsum[]" value="<?php echo $rowd->agreementdeposit_islumpsum;?>"/></td>
                                                      <td><input type="text" id="d_base" name="dbase[]" value="<?php echo $rowd->agreementdeposit_idr;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                      <td><input type="text" id="d_mia" name="dmia[]" value="<?php echo $rowd->agreementdeposit_idrsubtotal;?>" class="clsmia detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                      <td><input type="text" id="d_vat" name="dvat[]" readonly value="<?php echo $rowd->agreementdeposit_tax;?>" class="detil bulet form-control input-sm" style= "text-align: right;" />
                                                          <input type="hidden" name="dstate[]" value="update"/></td>
                                                      <td><a id= "dDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td> 
                                                      </tr>
                                                      <script>
                                                        $('.dstart').datepicker();

                                                        $('.dropunit.deposit').on("select2:select", function(e){
                                                            var uData = e.params.data;
         
                                                            $(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['text']);
                                                            $(this).closest('tr').find('input[type="text"]').eq(2).val(uData['sqm']);
                                                            
                                                        });

							

                                                      </script>
                                                    <?php
                                                       }
                                                     }
                                                   ?>
                                                </tbody>
                                              </table>
                                             </div>
                                            </div>
                                            <div class="tab-pane" id="tab_4">
                                             <div class ="table-responsive">
                                              <table class="table table-bordered table-striped" id='profitsTab' style="border:solid 1px #999; #999; border-radius:0px;">
                                                <thead>
                                                  <tr>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Up.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Post</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Type</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Start Date Trans.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Term(M)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Term(D)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">End Date Trans.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Time Types</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Unit</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Space (m2)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID Profit Sharing (Search)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Profit Sha Desc</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Upload</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Omset IDR</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Lump</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Monthly Instal.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">VAT</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Delete</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                   <?php if(isset($resultp)){
                                                        foreach($resultp as $rowp){
                                                    ?>
                                                      <tr>
                                                      <td><?php echo $rowp->agreementps_line;?><input type="hidden" name="pline[]" value="<?php echo $rowp->agreementps_line;?>"/></td>
                                                      <td><input type="checkbox" id="upload" class="chkUpload" <?php if ($rowp->agreementps_isupload == 1) echo 'checked= "checked"';?> disabled>
                                                          <input type="hidden" id="p_upload" name="pupload[]" value="<?php echo $rowp->agreementps_isupload;?>"/>
                                                      </td>
                                                      <td><input type="checkbox" id="post" class="chkPost" <?php if ($rowp->agreementps_isposting == 1) echo 'checked= "checked"';?> disabled>
                                                          <input type="hidden" id="p_post" name="ppost[]" value="<?php echo $rowp->agreementps_isposting;?>"/>
                                                      </td>
                                                      <td><div class="form-group form-group-sm"><?php echo form_dropdownext('ptype[]',$protype, $rowp->agreementtype_id, 'id="p_type" class="droppro form-control input-sm" style="width: 100%;" required');?></div></td>
                                                      <td><input type="text" id="p_sdate" name="psdate[]" value="<?php $dS = new DateTime($rowp->agreementps_startdate);echo $dS->format('Y-m-d');?>" class="pstart form-control input-sm" /></td>
                                                      <td><input type="text" id="p_term" name="pterm[]" value="<?php echo $rowp->agreementps_terms;?>" class="pterm detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                      <td><input type="text" id="p_dayterm" name="pdayterm[]" value="<?php echo $rowp->agreementps_dayterms;?>" class="pdayterm detil bulet form-control input-sm" style= "text-align: center;"/></td>                                                      
                                                      <td><input type="text" id="p_edate" name="pedate[]" value="<?php $dE = new DateTime($rowp->agreementps_enddate);echo $dE->format('Y-m-d');?>" class="form-control input-sm" style= "text-align: center;" readonly/></td>
                                                      <td><?php echo form_dropdownext('ptitype[]', $titype, $rowp->timetype_id, 'id="p_time" class="detil form-control input-sm" required');?></td>
                                                      <td><div class="form-group form-group-sm">
                                                          <select data-placeholder = "Select unit" id= "p_unit" name= "punit[]" required class="dropunit profit form-control input-sm" style="width: 100%;">
                                                            <option value="<?php echo $rowp->unit_id;?>" selected="selected" ><?php echo $rowp->unit_name;?></option>
                                                          </select></div><input type="hidden" id="p_una" name="puna[]" value="<?php echo $rowp->unit_name;?>" /></td>
                                                      <td><input type="text" id="p_space" name="pspace[]" value="<?php echo $rowp->agreementps_space;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>                                                      
                                                      <td><div class="input-group input-group-sm"><input type="text" id="p_idps" name="pidps[]" value="<?php echo $rowp->agreementps_idps;?>" class="detil form-control input-sm" />
                                                          <span class="input-group-btn">
                                                            <button id ="plook" type="button" class="btn blue btn-primary btn-sm"><i class="fa fa-search"></i></button>                                                            
                                                          </span></div>                                                          
                                                      </td>
                                                      <td><input type="text" id="p_psdesc" name="ppsdesc[]" value="<?php echo $rowp->agreementps_descr;?>" class="detil form-control input-sm" /></td>
                                                      <td><a id= "pload" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i></a></td> 
                                                      <td><input type="text" id="p_omset" name="pomset[]" value="<?php echo $rowp->agreementps_totalomset;?>" class="detil form-control input-sm" style= "text-align: right;" /></td>
                                                      <td><input type="checkbox" id="lump" class="pLump" <?php if ($rowp->agreementps_islumpsum == 1) echo 'checked= "checked"';?> >
                                                          <input type="hidden" id="p_lumpsum" name="plumpsum[]" value="<?php echo $rowp->agreementps_islumpsum;?>"/></td>
                                                      <td><input type="text" id="p_mia" name="pmia[]" value="<?php echo $rowp->agreementps_mia;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                      <td><input type="text" id="p_vat" name="pvat[]" value="<?php echo $rowp->agreementps_tax;?>" class="detil bulet form-control input-sm" style= "text-align: right;" />
                                                          <input type="hidden" name="pstate[]" value="update"/></td>
                                                      <td><a id= "pDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td> 
                                                      </tr>
                                                      <script>
                                                        $('.pstart').datepicker();
                                                        
                                                        $('.dropunit.profit').on("select2:select", function(e){
                                                            var uData = e.params.data;
         
                                                           // $(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['text']);
                                                            $(this).closest('tr').find('input[type="text"]').eq(4).val(uData['sqm']);
                                                            
                                                        });
                                                        
                                                        $('.pstart').on('change keyup', function() {

                                                          var startDate = new Date($(this).val());                             
                                                          var mTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(1).val());
                                                          var dTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(2).val());                                                          

                                                          startDate.setMonth(startDate.getMonth() + mTerm);
                                                          startDate.setDate(startDate.getDate() + -1);
                                                          startDate.setDate(startDate.getDate() + dTerm);

                                                          var dateFormated = startDate.toISOString().substr(0,10);

                                                          $(this).closest('tr').find('input[type="text"]').eq(3).val(dateFormated);

                                                        }); 

                                                        $('.pterm').on('change keyup', function() {
                                                                                       
                                                          var startDate = new Date($(this).closest('tr').find('input[type="text"]').eq(0).val());
                                                          var mTerm = parseInt($(this).val());
                                                          var dTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(2).val()); 

                                                          //$(this).closest('tr').find('input[type="text"]').eq(0).val(startDate.toISOString().substr(0,10)); 
                                                          startDate.setMonth(startDate.getMonth() + mTerm);
                                                          startDate.setDate(startDate.getDate() + -1);
                                                          startDate.setDate(startDate.getDate() + dTerm);

                                                          var dateFormated = startDate.toISOString().substr(0,10);
                                                          
                                                          $(this).closest('tr').find('input[type="text"]').eq(3).val(dateFormated);

                                                        }); 

                                                        $('.pdayterm').on('change keyup', function() {
                                                          
                                                          var startDate = new Date($(this).closest('tr').find('input[type="text"]').eq(0).val());                                                          
                                                          var mTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(1).val());
                                                          var dTerm = parseInt($(this).val());

                                                          //$(this).closest('tr').find('input[type="text"]').eq(0).val(startDate.toISOString().substr(0,10)); 
                                                          startDate.setMonth(startDate.getMonth() + mTerm);
                                                          startDate.setDate(startDate.getDate() + -1);
                                                          startDate.setDate(startDate.getDate() + dTerm);

                                                          var dateFormated = startDate.toISOString().substr(0,10);

                                                          $(this).closest('tr').find('input[type="text"]').eq(3).val(dateFormated);

                                                        }); 
                                                      </script>
                                                    <?php
                                                       }
                                                     }
                                                   ?>
                                                </tbody>
                                              </table>
                                             </div>
                                          </div>
                                          <div class="tab-pane" id="tab_5">
                                            <div class="row">
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Create By</label>
                                                 <input type="text" id= "agreement_createby" name="agreement_createby" class="form-control input-sm" value="<?php echo $row->agreement_createby;?>" readonly>
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Create Date</label>
                                                 <input type="text" id="agreement_createdate" name="agreement_createdate" class="form-control input-sm" value="<?php echo $row->agreement_createdate;?>" readonly>
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Modify By</label>
                                                 <input type="text" id= "agreement_modifyby"  name="agreement_modifyby" class="form-control input-sm" value="<?php echo $row->agreement_modifyby;?>" readonly>
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Modify Date</label>
                                                 <input type="text" id="agreement_modifydate" name="agreement_modifydate" class="form-control input-sm" value="<?php echo $row->agreement_modifydate;?>" readonly>
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
