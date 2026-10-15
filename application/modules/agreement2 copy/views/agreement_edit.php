
<script>

  $(document).ready(function(){

    $.fn.modal.Constructor.prototype.enforceFocus = $.noop; 

    $('#frmAgreement').on('submit', function(e) {
      //var ttotamount=$("#jumlah_idr").val();		
      //let submitButton = e.originalEvent.submitter;
      //let btnName = $(submitButton).attr('name');
      var agreement_id = $('#agreement_id').val();
      var profitRows = tblProfit.data().toArray();

      $('#row_profit').val(JSON.stringify( profitRows ));     

    });

    $(document).on("focusin", "#itenant", function() {
      $(this).prop('readonly', true);  
    });

    $(document).on("focusout", "#itenant", function() {
      $(this).prop('readonly', false); 
    });
  
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
    $('.droploa').select2({placeholder: 'Choose agreement type..'});

    $('#iStatus').select2({placeholder: 'Choose status ..'});  
    $('#thdType').select2({placeholder: 'Choose THD Type ..'});
    $('#thdGroup').select2({placeholder: 'Choose THD Group ..'});
    $('#thdCat').select2({placeholder: 'Choose THD Category ..'});

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
            url: '<?php echo site_url('agreement2/agreement2/unit_select')?>',
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
            url: '<?php echo site_url('agreement2/agreement2/branch_select')?>',
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
    var oTable = popgrid("<?php echo site_url('agreement2/agreement2/controler_griddialog')?>","uLoader","trp", 10);
    var tblProfit = handleProfitTable();
    var pTable = $('#proLoader').DataTable();
    var locTable = popgrid("<?php echo site_url('agreement2/agreement2/controler_gridloc')?>","newLoader","trp", 5);
    var locDetil = popgrid("<?php echo site_url('agreement2/agreement2/controler_gridlocdetil')?>","newDetil","trp", 5);
    let $lastPopOver = null;

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

    $('.popup-unit').select2({
        dropdownCssClass: 'dropdown-store',
        placeholder: 'Select an Option',
        //allowClear: true,
        minimumInputLength: 0,
        //minimumResultsForSearch: 10,
        //tokenSeparators: [',', ' '],
        ajax: {
            url: '<?=site_url('agreement2/agreement2/unit_select')?>',
            dataType: 'json',
            type: "GET",
            data: function (term) {
              return {
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

    $('.popup-unit').on('select2:open', function(e){
        $('.dropdown-store').parent().css('z-index', 99999);
    });


    $('.droppro').select2({
      dropdownCssClass: 'dropdown-store',
      allowClear: true,
      placeholder: 'Choose agreement type..'
    });

    $('.droppro').on('select2:open', function(e){
        $('.dropdown-store').parent().css('z-index', 99999);
    });


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
      //$("#profitsTab > tbody").empty();
      $("#loanTab > tbody").empty();

      $('.post input:checkbox').prop('checked', false);
      $('.isrenewal input:checkbox').prop('checked', true);
      $('#hrenewal').val(1);

      $('#agreement_id').val('auto');    
      $('#agreement_loonumber').val('');  
      $('#agreement_tlv').val(0);  
      $('#agreement_idr').val(0);  
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
        speriodDate = new Date(locData[0][1]);                       
        speriodDate.setMonth(speriodDate.getMonth() + locData[0][14]);
        speriodDate.setDate(speriodDate.getDate() + -1);
        ePeriode = speriodDate.toISOString().substr(0,10); 
        $('#agreement_endperiod').val(ePeriode);
        $('#agreement_loonumber').val(locData[0][0]);
        $('#idebtor').val(rekData[0][5]);
        $('#transaksi_id').val('Pencatatan Leasing');
        $('#htransaksi').val('100920');
        $('#size_indoor').val(locData[0][9]);
        $('#size_outdoor').val(locData[0][10]);
        $('#fitting_out').val(locData[0][11]);
        $('#grace_periode').val(locData[0][12]);
        $('#product_name').val(locData[0][13]);
        $('#agreement_descr').val('RENEWAL');   
        $('#agreement_contractlongnumber').val('');

        $('.post input:checkbox').prop('checked', false);
        $('.isrenewal input:checkbox').prop('checked', true);
        $('#hrenewal').val(1);
        $('#agreement_renewalno').val(ref_no);

        $("#rentalTab > tbody").empty();
        $("#chargeTab > tbody").empty();
        $("#depositTab > tbody").empty();
        //$("#profitsTab > tbody").empty(); 
        $("#loanTab > tbody").empty();      
        
        $('#agreement_id').val('auto');
        $('#agreement_tlv').val(0);
        //listunit = branchData.filter(function (data) { return data.branch == _bra });          

        function getDataLoc (){
          var ajax = $.get('<?php echo site_url('agreement2/agreement2/agreement_getdataloc')?>','id='+_id+'&rekanan='+_rek+'&branch='+_bra, function(data){
            //do something with data here               
          }, 'json');
          return ajax;
        }
        
        getDataLoc().done(function(results){

          console.log(results.data);
          dLoc = results.data;    
                            
          for (var i=0; i<dLoc.length; i++){            

              if (dLoc[i][2] === 'RENTAL' || dLoc[i][2] === 'RENTAL TEMP'){              

                  if (dLoc[i][1] === '1000' || dLoc[i][1] === '2000') {                      

                      if (dLoc[i][3] > 0 && dLoc[i][4] > 0) {    

                          /* Row Pertama ambil persentase LOO */
                          addRow(row);
                          $('#r_type_'+row).val(dLoc[i][1]).trigger('change');
                          $('#r_per_'+row).val(dLoc[i][3]);
                          $('#r_int_'+row).val(dLoc[i][5]);                        
                          $('#r_spdate_'+row).datepicker('setDate', dLoc[i][6]);
                          $('#h_spdate_'+row).val(dLoc[i][6]);
                          $('#r_sdate_'+row).datepicker('setDate', dLoc[i][6]);
                          $('#r_pinst_'+row).val(1);
                          $('#r_rinstm_'+row).val(1);
                          sLooDate = new Date(dLoc[i][6]);                       
                          sLooDate.setMonth(sLooDate.getMonth() + 1);
                          sLooDate.setDate(sLooDate.getDate() + -1);
                          eFormated = sLooDate.toISOString().substr(0,10);   
                          $('#r_edate_'+row).val(eFormated);
                          $('#r_base_'+row).val(dLoc[i][8]);
                          $('#r_unit_'+row).append(new Option(dLoc[i][9], dLoc[i][11])).trigger('change');
                          $('#r_space_'+row).val(dLoc[i][10]);
                          $('#r_una_'+row).val(dLoc[i][9]);
                          row++;

                          /* Row Kedua ambil persentase LOI */
                          addRow(row);
                          $('#r_type_'+row).val(dLoc[i][1]).trigger('change');
                          $('#r_per_'+row).val(dLoc[i][4]);
                          $('#r_int_'+row).val(dLoc[i][5]);                        
                          $('#r_spdate_'+row).datepicker('setDate', dLoc[i][6]);
                          $('#h_spdate_'+row).val(dLoc[i][6]);
                          $('#r_sdate_'+row).datepicker('setDate', dLoc[i][6]);
                          sLooDate = new Date(dLoc[i][6]);                       
                          sLooDate.setMonth(sLooDate.getMonth() + 1);
                          sLooDate.setDate(sLooDate.getDate() + -1);
                          eFormated = sLooDate.toISOString().substr(0,10);  
                          $('#r_edate_'+row).val(eFormated);
                          $('#r_base_'+row).val(dLoc[i][8]);
                          $('#r_unit_'+row).append(new Option(dLoc[i][9], dLoc[i][11])).trigger('change');
                          $('#r_space_'+row).val(dLoc[i][10]);
                          $('#r_una_'+row).val(dLoc[i][9]);
                          row++;

                      } else {
                          /* Row berikut ambil persentase LOO dari field */                            
                          addRow(row);
                          $('#r_type_'+row).val(dLoc[i][1]).trigger('change');
                          $('#r_per_'+row).val(dLoc[i][12]);
                          $('#r_int_'+row).val(dLoc[i][5]);
                          $('#r_spdate_'+row).datepicker('setDate', dLoc[i][6]); 
                          $('#h_spdate_'+row).val(dLoc[i][6]);
                          $('#r_sdate_'+row).datepicker('setDate', dLoc[i][6]);
                          sLooDate = new Date(dLoc[i][6]);                       
                          sLooDate.setMonth(sLooDate.getMonth() + 1);
                          sLooDate.setDate(sLooDate.getDate() + -1);
                          eFormated = sLooDate.toISOString().substr(0,10);  
                          $('#r_edate_'+row).val(eFormated);
                          $('#r_pinst_'+row).val(1);
                          $('#r_rinstm_'+row).val(1);
                          $('#r_base_'+row).val(dLoc[i][8]);
                          $('#r_unit_'+row).append(new Option(dLoc[i][9], dLoc[i][11])).trigger('change');
                          $('#r_space_'+row).val(dLoc[i][10]);
                          $('#r_una_'+row).val(dLoc[i][9]);                            
                          row++;
                      }                        
                  } else {                  

                      addRow(row);
                      $('#r_type_'+row).val(dLoc[i][1]).trigger('change');
                      $('#r_per_'+row).val(dLoc[i][12]);
                      $('#r_int_'+row).val(dLoc[i][5]);
                      //$('#r_spdate_'+row).val(dLoc[i][6]);
                      $('#r_spdate_'+row).datepicker('setDate', dLoc[i][6]); 
                      $('#h_spdate_'+row).val(dLoc[i][6]);
                      if ( dLoc[i][1] === '4000' ) { 
                        $('#r_spdate_'+row).prop('disabled', false);
                      } else {;          
                        $('#r_spdate_'+row).prop('disabled', true);
                      }    
                      $('#r_sdate_'+row).datepicker('setDate', dLoc[i][6]);
                      sLooDate = new Date(dLoc[i][6]);                       
                      sLooDate.setMonth(sLooDate.getMonth() + dLoc[i][13]);
                      sLooDate.setDate(sLooDate.getDate() + -1);
                      eFormated = sLooDate.toISOString().substr(0,10); 
                      $('#r_edate_'+row).val(eFormated);
                      $('#r_base_'+row).val(dLoc[i][8]);
                      $('#r_unit_'+row).append(new Option(dLoc[i][9], dLoc[i][11])).trigger('change');
                      $('#r_space_'+row).val(dLoc[i][10]);
                      $('#r_una_'+row).val(dLoc[i][9]);
                      $('#r_pinst_'+row).val(dLoc[i][13]);
                      $('#r_rinstm_'+row).val(dLoc[i][13]);
                      row++;
                  }
              }

              if (dLoc[i][2] === 'SERVICE' || dLoc[i][2] === 'OTHER'){

                  if (dLoc[i][8] > 0) {
                      if (dLoc[i][14] === 'SERVICE CHARGE' || dLoc[i][14] === 'PROMOTION LEVY' || dLoc[i][14] === 'FOOD COURT LEVY') {

                        addRowCharge(row);
                        $('#c_type_'+row).val(dLoc[i][1]).trigger('change');
                        $('#c_per_'+row).val(dLoc[i][12]);
                        $('#c_int_'+row).val(dLoc[i][5]);
                        $('#c_spdate_'+row).val(dLoc[i][6]);
                        $('#c_sdate_'+row).datepicker('setDate', dLoc[i][6]);
                        sLooDate = new Date(dLoc[i][6]);                       
                        sLooDate.setMonth(sLooDate.getMonth() + dLoc[i][13]);
                        sLooDate.setDate(sLooDate.getDate() + -1);
                        eFormated = sLooDate.toISOString().substr(0,10); 
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
                          $('#c_per_'+row).val(dLoc[i][12]);
                          $('#c_int_'+row).val(dLoc[i][5]);
                          $('#c_spdate_'+row).val(dLoc[i][6]);
                          $('#c_sdate_'+row).datepicker('setDate', dLoc[i][6]);
                          sLooDate = new Date(dLoc[i][6]);                       
                          sLooDate.setMonth(sLooDate.getMonth() + dLoc[i][13]);
                          sLooDate.setDate(sLooDate.getDate() + -1);
                          eFormated = sLooDate.toISOString().substr(0,10);
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
      /*
              if (dLoc[i][2] === 'LOAN'){

                  if (dLoc[i][8] > 0) {

                        addRow(row);
                        $('#c_type_'+row).val(dLoc[i][1]).trigger('change');
                        $('#c_per_'+row).val(dLoc[i][12]);
                        $('#c_int_'+row).val(dLoc[i][5]);
                        $('#c_spdate_'+row).val(dLoc[i][6]);
                        $('#c_sdate_'+row).val(dLoc[i][6]);
                        $('#c_edate_'+row).val(dLoc[i][7]);
                        $('#c_base_'+row).val(dLoc[i][8]);
                        $('#c_unit_'+row).append(new Option(dLoc[i][9], dLoc[i][11])).trigger('change');
                        $('#c_space_'+row).val(dLoc[i][10]);
                        $('#c_una_'+row).val(dLoc[i][9]);           
                        $('#c_pinst_'+row).val(dLoc[i][13] / dLoc[i][5]);      
                        $('#c_rinstm_'+row).val(dLoc[i][13]);              
                        row++;                   
                  }
              }
      */
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

    $('#bttenant').click(() => {});

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
                
              case 'Profit Sharing':
                  addRowProfit(tblProfit);
                  break;
          }
      }

    });

    $('#tabedit').click(function() {

      display_modal('Alert!', 'Please, select data from list.');
    }); 

    var objDel = {};
    var rDel = [];
    var cDel = [];
    var dDel = [];
    var lDel = [];
    var pDel = [];

    $("#rentalTab").on('click','#rDelete',function(){
      if (confirm("Are you sure to delete this row ?") == false) {
                return false;
            }

        var line = $(this).closest('tr').find('td:eq(0)').text();

        rDel.push({line: line});
        objDel.rental = rDel;
        
        $('#objdel').val(JSON.stringify(objDel));     
        $(this).closest('tr').remove();
    });

    $("#chargeTab").on('click','#cDelete',function(){  

      if (confirm("Are you sure to delete this row ?") == false) {
                return false;
            }

        var line = $(this).closest('tr').find('td:eq(0)').text();

        cDel.push({line: line});
        objDel.charge = cDel;

        $('#objdel').val(JSON.stringify(objDel));       
        $(this).closest('tr').remove();
    });

    $("#depositTab").on('click','#dDelete',function(){
      if (confirm("Are you sure to delete this row ?") == false) {
                return false;
            }

        var line = $(this).closest('tr').find('td:eq(0)').text();

        dDel.push({line: line});
        objDel.deposit = dDel;
        
        $('#objdel').val(JSON.stringify(objDel));      
        $(this).closest('tr').remove();
    });  

    $("#loanTab").on('click','#lDelete',function(){
      if (confirm("Are you sure to delete this row ?") == false) {
                return false;
            }

        var line = $(this).closest('tr').find('td:eq(0)').text();

        lDel.push({line: line});
        objDel.loan = lDel;

        $('#objdel').val(JSON.stringify(objDel));
        $(this).closest('tr').remove();
    });


    $('#frmProfit').on('submit', function(e) {

      e.preventDefault();

      var isValid = true;
      var form = document.getElementById("frmProfit");
      var formId = form.getAttribute("formid");
      var formDataArray = $(this).serializeArray();
      var formDataObject = {};
      let agreementtype_name = $("#pnl_profit-cbo_agreementtype_id option:selected").text();
      //let acc_name = $("#pnl_profit-cbo_acc_id option:selected").text();
      //let strukturunit_name = $("#pnl_edit-cbo_strukturunit_id option:selected").text();

      $.blockUI({message: 'Saving Data, Please Wait...'});

      setTimeout( ()=> {      

        $.each(formDataArray, function(i, field) {
          formDataObject[field.name] = field.value;
        });  

        formDataObject.agreementtype_name = agreementtype_name;
        //formDataObject.acc_name = acc_name;
        //formDataObject.strukturunit_name = strukturunit_name;

        let lastRowData = insertRowProfit(formId, tblProfit, formDataObject);
        let lastLine = Number(lastRowData.agreementps_line) + 10;

        $('#pnl_edit-txt_agreementps_line').val(lastLine);

        $("#dlgProfit").modal("hide"); 

        $.unblockUI();
      }, 120);

    })

    tblProfit.on('draw.dt', function () {

      $('a.edit', this).on('click', function() {

        var data = tblProfit.row($(this).closest('tr')).data();
        var trId = data.rowid;
        var form = document.getElementById("frmProfit");

        form.setAttribute("formid", trId);

        tblProfit.row(`#${trId}`).select();

        openRowProfit('Edit', data);
      });       

    });

    $('#pnl_profit-chk_agreementps_islumpsum').on('change', function() {
      if($(this).is(':checked')){
        $('#pnl_profit-txt_agreementps_mia').prop("readonly", false);
        $('#pnl_profit-txt_agreementps_islumpsum').val(1);
      }else{      
        $('#pnl_profit-txt_agreementps_mia').prop('readonly',true);
        $('#pnl_profit-txt_agreementps_islumpsum').val(0);
      }
    });  


    $('#pnl_profit-dt_agreementps_startdate').on('change keyup', function() {

      var startDate = new Date($(this).val());
      var mTerm = parseInt($('#pnl_profit-txt_agreementps_terms').val());
      var dTerm = parseInt($('#pnl_profit-txt_agreementps_dayterms').val());

      let endDate = setEndDate(startDate, mTerm, dTerm);
      
      $('#pnl_profit-dt_agreementps_enddate').val(endDate);
    }); 

    $('#pnl_profit-txt_agreementps_terms').on('change keyup', function() {

      var startDate = new Date($('#pnl_profit-dt_agreementps_startdate').val());
      var mTerm = parseInt($(this).val());
      var dTerm = parseInt($('#pnl_profit-txt_agreementps_dayterms').val());

      let endDate = setEndDate(startDate, mTerm, dTerm);
      
      $('#pnl_profit-dt_agreementps_enddate').val(endDate);
    }); 

    $('#pnl_profit-txt_agreementps_dayterms').on('change keyup', function() {

      var startDate = new Date($('#pnl_profit-dt_agreementps_startdate').val());
      var mTerm = parseInt($('#pnl_profit-txt_agreementps_terms').val());
      var dTerm = parseInt($(this).val());

      let endDate = setEndDate(startDate, mTerm, dTerm);

      $('#pnl_profit-dt_agreementps_enddate').val(endDate);
    }); 

    $('.droprental').on("select2:select", function(e) {
      var eData = e.params.data;       
      var eType = {
        text: eData.text,
        id: eData.id
      };

      if ( eType.id === '4000' ) { 
        $(this).closest('tr').find('.spdate').prop('disabled', false);
      } else {;          
        $(this).closest('tr').find('.spdate').prop('disabled', true);     
      }    
    });

    $("#rentalTab").on('change', ".spdate", function (e) {

        var spDate = e.target.value;
        
        $(this).closest('tr').find('input[type="hidden"]').eq(1).val(spDate);
    });

    $("#rentalTab").on('change', ".rLump", function (e) {
        
        $(this).closest('tr').find('input[type="hidden"]').eq(3).val(e.target.checked ? 1: 0);
        $(this).closest('tr').find('input[type="text"]').eq(10).attr("readonly", e.target.checked ? false: true);
    });

    $("#chargeTab").on('change', ".cLump", function (e) {
        
        $(this).closest('tr').find('input[type="hidden"]').eq(2).val(e.target.checked ? 1: 0);
        $(this).closest('tr').find('input[type="text"]').eq(10).attr("readonly", e.target.checked ? false: true);
    });


    $("#depositTab").on('change', ".chkLump", function (e) {     

        $(this).closest('tr').find('input[type="hidden"]').eq(2).val(e.target.checked ? 1: 0);      
        $(this).closest('tr').find('input[type="text"]').eq(4).attr("readonly", e.target.checked ? false: true);
    });

    $("#profitsTab").on('change', ".pLump", function (e) {     

        $(this).closest('tr').find('input[type="hidden"]').eq(4).val(e.target.checked ? 1: 0);      
        $(this).closest('tr').find('input[type="text"]').eq(8).attr("readonly", e.target.checked ? false: true);
    });

    $("#rentalTab").on('change', ".rAden", function (e) {     

        $(this).closest('tr').find('input[type="hidden"]').eq(4).val(e.target.checked ? 1: 0);
    });

    $("#chargeTab").on('change', ".cAden", function (e) {     

        $(this).closest('tr').find('input[type="hidden"]').eq(3).val(e.target.checked ? 1: 0);
    });

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

    $('#dlgProfit').on('hidden.bs.modal', function () {
      // do something…
      tblProfit.rows().deselect()
    })

    function handleProfitTable() 
    {

      var dt = $('#profitsTab').DataTable({

        autoWidth: false,
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
        orderable: false,
        order: [
          [2, 'desc']
        ],
        processing: true,
        ajax: {
          url: '<?php echo site_url('agreement2/agreement2/listProfit')?>',
          type: 'POST',
          data: function () {  
            return {
              agreement_id: $('#agreement_id').val()
            }
          },
        },
        rowId: 'rowid',

        columns: [
          {            
            data: null,
            className: 'text-center',
            width: '0px',
            defaultContent: '<a href="javascript:;" class="edit" ><i class="fa fa-pencil fa-lg"/></a>',
            orderable: false
          },
          {            
            data: null,
            className: 'text-center',
            width: '0px',
            defaultContent: '<a href="javascript:;" class="delete" data-toggle="popover"><i class="fa fa-trash fa-lg"/></a>',
            orderable: false
          },
          { data: 'agreementps_line' },
          { data: 'agreementps_isposting',
            render: function (data, type) {
              if (data){
                return `<i class="fa fa-check"></i>`
              } else {
                return '<div></div>';
              }
            }
          },
          { data: 'agreementtype_name' },
          { data: function(row) {
              var date = new Date(row.agreementps_startdate);
              return date.toLocaleDateString("en-GB");
            }
          },
          { data: 'agreementps_terms' },          
          { data: 'agreementps_dayterms' },
          { data: function(row) {
              var date = new Date(row.agreementps_enddate);
              return date.toLocaleDateString("en-GB");
            }
          },
          { data: 'timetype_id' },
          { data: 'agreementps_unit' },
          { data: 'agreementps_space' },
          { data: 'agreementps_mia' }
        ],

        columnDefs: [
          { targets: [0, 1], width: '15px', className: "text-center" },
          { targets: [2, 3, 5, 6, 7, 8, 9], width: '50px', className: "text-center" },
          { targets: [11], width: 'auto', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 2, '') },
          { targets: [12], width: 'auto', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 0, '') }
          //{ targets: [12], className: "text-center" },
          //{ targets: [2], width: '15px', className: "text-center" },
          //{ targets: [3], width: 'auto' },
          //{ targets: [4], width: '100px', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 2, '') },
          //{ targets: [5], width: '100px', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 2, '') }
        ],
        /*
        createdRow: function( row, data, dataIndex ) {
          //console.log(data);
          if (data.agreementps_isposting===1) {
            $(row).addClass('bg-grey-silver');
          }
        }
        */
      });


      dt.on('click', 'tr td', function (e) {
        let tr = e.target.closest('tr');
        let column = dt.column( this );
        let row = dt.row(tr);
        let data = row.data();

        if (column.index() < 2) return;

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
        } else {
          // Open this row
          row.child( format(data) ).show();
        }
      });

      function format (d) {
        let lumpsum = ( d.agreementps_islumpsum == 1 ) ? 'Yes' : 'No';
        return (`
          <dl style="margin-left:10px; margin-bottom:5px;">
            <dt style="padding:0.5em;">
              <span>Profit Sharing ID</span>
              <span style="padding-left:15px;font-weight:normal">${d.agreementps_idps}</span>
            </dt>
            <dt style="padding:0.5em;">
              <span>Profit Sharing Descr</span>
              <span style="padding-left:15px;font-weight:normal">${d.agreementps_descr}</span>
            </dt>
            <dt style="padding:0.5em;">
              <span>Lumpsum</span>
              <span style="padding-left:15px;font-weight:normal">${lumpsum}</span>
            </dt>
            <dt style="padding:0.5em;">
              <span>Monthly Installment</span>
              <span style="padding-left:15px;font-weight:normal">${new Intl.NumberFormat().format(d.agreementps_mia)}</span>
            </dt>
            <dt style="padding:0.5em;">
              <span>Tax</span>
              <span style="padding-left:15px;font-weight:normal">${new Intl.NumberFormat().format(d.agreementps_tax)}</span>
            </dt>
          </dl>`
        )
      }

      return dt;
    }

    function handleUnitTable(params)
    {
      var popoverUnit = $('#popover_unit');
      var dt = $('#table_unit').DataTable({ 

        autoWidth: false,
        "pageLength": 10,
        'lengthMenu': [[5, 10, 25, 50], [5, 10, 25, 50]],
        "processing": true, 
        "serverSide": true, 
        "order": [],
        "searching": true,
        "ajax": {
          "url": `<?=site_url('agreement2/agreement2/controler_gridunit')?>`,
          "type": "POST",
          data: function (o) {
            o.params = {
              region_id: params.region_id.val(),
              branch_id: params.branch_id.val(),
              loo_id: params.loo_id.val()
            }
          }
        },
        columnDefs: [
          { targets: [1], className: "text-right", render: $.fn.dataTable.render.number(',', '.', 2, '')  },
          { targets: [4], width: "15px" }
        ]

      });

      dt.on('draw.dt', function () {
        $('a.select', this).on('click', function() {
          var data = dt.row($(this).closest('tr')).data();
          // Menampilkan data di console (atau lakukan sesuatu dengan data tersebut)
          $lastPopOver.closest('.form').find('.agreementps_unit').val(data[0]);
          $lastPopOver.closest('.form').find('.agreementps_space').val(data[1]);
          $lastPopOver.closest('.form').find('.unit_id').val(data[5]);
          //$lastPopOver.closest('.input-group').find('.rekananshipping_line').val(data[5]);
          //$lastPopOver.closest('.form').find('.rekananshipping_name').val(data[2]);
          $lastPopOver.trigger('click');
          $('.popover').hide();
        });
      })

      popoverUnit.hide();
      return dt;
    }

    function handleProfitIDTable()
    {
      var popOverProfit = $('#popover_profit');
      var dt = $('#table_profit').DataTable({ 

        autoWidth: false,
        "pageLength": 10,
        'lengthMenu': [[5, 10, 25, 50], [5, 10, 25, 50]],
        "processing": true, 
        "serverSide": true, 
        "order": [],
        "searching": true,
        "ajax": {
          "url": `<?=site_url('agreement2/agreement2/controler_gridpro')?>`,
          "type": "POST"
        },
        columnDefs: [
          //{ targets: [1], className: "text-right", render: $.fn.dataTable.render.number(',', '.', 2, '')  },
          //{ targets: [4], width: "15px" }
        ]

      });

      dt.on('draw.dt', function () {
        $('a.select', this).on('click', function() {
          var data = dt.row($(this).closest('tr')).data();
          // Menampilkan data di console (atau lakukan sesuatu dengan data tersebut)
          $lastPopOver.closest('.form').find('.agreementps_idps').val(data[0]);
          $lastPopOver.closest('.form').find('.agreementps_descr').val(data[1]);
          //$lastPopOver.closest('.input-group').find('.rekanan_id').val(data[4]);
          //$lastPopOver.closest('.input-group').find('.rekananshipping_line').val(data[5]);
          //$lastPopOver.closest('.form').find('.rekananshipping_name').val(data[2]);
          $lastPopOver.trigger('click');
          $('.popover').hide();
        });
      })

      popOverProfit.hide();
      return dt;
    }

    function handlePopupSearch($dt, $popOver, $obj)
    {

      $obj.each(function() {
        var $searchObj = $(this);

        // Dapatkan container dari atribut data
        var unitContainer = $searchObj.closest('.form');

        $searchObj.popover({
            html        : true,
            container   : unitContainer,
            placement   : 'bottom',
            content     : '<input hidden name="rowItemId">'
        }).on("show.bs.popover", function(){
            var $popContainerMember = $(this).data('bs.popover').tip();
            $popContainerMember.css({minWidth: '720px', maxWidth: '720px'});
            if ($lastPopOver != null) $lastPopOver.popover('hide');
            $lastPopOver = $searchObj;
            //console.log($lastPopOver)
            $popOver.show();

        }).on('shown.bs.popover', function(){
            var 
                $popContainerMember = $(this).data('bs.popover').tip(),
                $popcontent   = $popContainerMember.find('.popover-content');
            $popContainerMember.find('.popover-content').append($popOver);

        }).on('hide.bs.popover', function(){
            $popOver.hide();
            $popOver.appendTo($('.form'));
            $lastPopOver = null;

        }).on('hidden.bs.popover', function(){
          //console.log('hidden.bs.popover')
          //$(this).popover('dispose');
        }).on('click', function(e){
            $dt.draw();
            e.preventDefault();
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

    let $tblUnit = handleUnitTable({
      region_id : $('#iregion'), 
      branch_id : $('#ibranch'), 
      loo_id : $('#agreement_loonumber')
    });
    let $tblProfit = handleProfitIDTable();

    /** Loading Function */
    handlePopupSearch($tblUnit, $('#popover_unit'), $('.search-unit'));
    handlePopupSearch($tblProfit, $('#popover_profit'), $('.search-profit'));
  });

  function addRow(ci) {      

    var linenum=0;

    var max=GetDgvLineMaxNum('rentalTab', 0);
    linenum= Number(max) + 10;      

    if (typeof ci === 'undefined') { ci = linenum}

    $('#rentalTab tbody').append('<tr>'+
      '<td>' + linenum + '<input type="hidden" name="rline[]" value="'+ linenum +'" readonly class="nogaris"/></td>'+
      '<td><div class="form-group form-group-sm"><?php echo form_dropdownext('rtype[]',$renttype, '', 'id="r_type_\'+ci+\'" class="droprental form-control input-sm" style="width: 100%;" required');?></div></td>'+
      '<td><input type="text" id="r_spdate_'+ci+'" name="rspdate[]" value="<?php echo date('Y-m-d');?>" class="spdate form-control input-sm" style= "text-align: center;" disabled/>'+
          '<input type="hidden" id="h_spdate_'+ci+'" name="hspdate[]" value="" /></td>'+
      '<td><input type="text" id="r_pinst_'+ci+'" name="rpinst[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
      '<td><input type="text" id="r_sdate_'+ci+'" name="rsdate[]" value="<?php echo date('Y-m-d');?>" class="tanggal form-control input-sm" /></td>'+
      '<td><input type="text" id="r_rinstm_'+ci+'" name="rrinstm[]" value="0" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
      '<td><input type="text" id="r_rinstd_'+ci+'" name="rrinstd[]" value="0" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
      '<td><input type="text" id="r_edate_'+ci+'" name="redate[]" value="<?php echo date('Y-m-d');?>" class="form-control input-sm" style= "text-align: center;" readonly/></td>'+
      '<td><input type="text" id="r_int_'+ci+'" name="rint[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
      '<td><?php echo form_dropdownext('rtitype[]',$titype, 'MONTH', 'id="r_time_\'+ci+\'" class="detil form-control input-sm" required');?></td>'+
      '<td><input type="text" id="r_per_'+ci+'" name="rper[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>'+
      '<td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "r_unit_'+ci+'" name= "runit[]" required class="dropunit form-control input-sm" style="width: 100%;">'+
          '</select></div><input type="hidden" id="r_una_'+ci+'" name="runa[]" value="" /></td>'+
      '<td><?php echo form_dropdownext('runitspot[]', $outdoor, 'Indoor', 'id="r_unitspot_\'+ci+\'" class="detil form-control input-sm" required');?></td>'+
      '<td><input type="text" id="r_space_'+ci+'" name="rspace[]" value="0" class="detil deci form-control input-sm" style= "text-align: right;"/></td>'+
      '<td><input type="checkbox" id="lump_'+ci+'" class="rLump">'+
          '<input type="hidden" id="r_lumpsum_'+ci+'" name="rlumpsum[]" value="0"/></td>'+
      '<td><input type="text" id="r_base_'+ci+'" name="rbase[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
      '<td><input type="text" id="r_mia_'+ci+'" name="rmia[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
      '<td><input type="text" id="r_vat_'+ci+'" name="rvat[]" value="11" class="form-control input-sm" style= "text-align: right;" /></td>'+        
      '<td><input type="checkbox" id="aden_'+ci+' style="text-align:right;" class="rAden"><input type="hidden" id="r_adendum_'+ci+'" name="radendum[]" value="0"/></td>'+
      '<td><input type="text" id="r_ninst_'+ci+'" name="rninst[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>'+
      '<td><input type="text" id="r_descr'+ci+'" name="rdescr[]" value="" class="pops form-control input-sm"/>'+
      '<input type="hidden" name="rstate[]" value="insert"/></td>'+
      '<td><a id= "rDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');          

    $('.deci').number( true, 2 );
    $('.bulet').number( true, 0 );     

    $('.tanggal').datepicker();
    $('.spdate').datepicker();

    $('.dropunit').select2({    
        minimumInputLength: 0,
        placeholder: 'Select an option',
        ajax: {
            url: '<?php echo site_url('agreement2/agreement2/unit_select')?>',
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

    $('.droprental').on("select2:select", function(e) {
      var eData = e.params.data;       
      var eType = {
        text: eData.text,
        id: eData.id
      };

      if ( eType.id === '4000' ) { 
        $(this).closest('tr').find('.spdate').prop('disabled', false);
      } else {;          
        $(this).closest('tr').find('.spdate').prop('disabled', true);            
      }    
    });

    $('#r_sdate_'+ci).on('change keyup', function() {

      var startDate = new Date($(this).val());
      var mTerm = parseInt($('#r_rinstm_'+ci).val());
      var dTerm = parseInt($('#r_rinstd_'+ci).val());

      $(this).closest('tr').find('input[type="text"]').eq(0).val(startDate.toISOString().substr(0,10)); 
      $(this).closest('tr').find('input[type="hidden"]').eq(1).val(startDate.toISOString().substr(0,10)); 

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
      $(this).closest('tr').find('input[type="hidden"]').eq(2).val(uData['text']);
      $(this).closest('tr').find('input[type="text"]').eq(8).val(uData['sqm']);
      
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
      '<td><input type="text" id="c_spdate" name="cspdate[]" value="<?php echo date('Y-m-d');?>" class="tanggal form-control input-sm" style= "text-align: center;" readonly/></td>'+
      '<td><input type="text" id="c_pinst_'+ci+'" name="cpinst[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
      '<td><input type="text" id="c_sdate_'+ci+'" name="csdate[]" value="<?php echo date('Y-m-d');?>" class="tanggal form-control input-sm" /></td>'+
      '<td><input type="text" id="c_rinstm_'+ci+'" name="crinstm[]" value="0" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
      '<td><input type="text" id="c_rinstd_'+ci+'" name="crinstd[]" value="0" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
      '<td><input type="text" id="c_edate_'+ci+'" name="cedate[]" value="<?php echo date('Y-m-d');?>" class="end form-control input-sm" style= "text-align: center;" readonly/></td>'+
      '<td><input type="text" id="c_int_'+ci+'" name="cint[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
      '<td><?php echo form_dropdownext('ctitype[]',$titype, 'MONTH', 'id="c_time_\'+ci+\'" class="detil form-control input-sm" required');?></td>'+
      '<td><input type="text" id="c_per_'+ci+'" name="cper[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>'+
      '<td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "c_unit_'+ci+'" name= "cunit[]" required class="dropunit form-control input-sm" style="width: 100%;">'+
          '</select></div><input type="hidden" id="c_una_'+ci+'" name="cuna[]" value="" /></td>'+
      '<td><?php echo form_dropdownext('cunitspot[]', $outdoor, 'Indoor', 'id="c_unitspot_\'+ci+\'" class="detil form-control input-sm" required');?></td>'+
      '<td><input type="text" id="c_space_'+ci+'" name="cspace[]" value="0" class="detil deci form-control input-sm" style= "text-align: right;"/></td>'+
      '<td><input type="checkbox" id="c_lump_'+ci+'" class="cLump" >'+
          '<input type="hidden" id="c_lumpsum_'+ci+'" name="clumpsum[]" value="0"/></td>'+
      '<td><input type="text" id="c_base_'+ci+'" name="cbase[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
      '<td><input type="text" id="c_mia_'+ci+'" name="cmia[]" value="0" class="detil deci form-control input-sm" style= "text-align: right;" readonly /></td>'+
      '<td><input type="text" id="c_vat_'+ci+'" name="cvat[]" value="11" class="form-control input-sm" style= "text-align: right;" /></td>'+        
      '<td><input type="checkbox" id="c_aden_'+ci+' style="text-align:right;" class="cAden"><input type="hidden" id="c_adendum_'+ci+'" name="cadendum[]" value="0"/></td>'+
      '<td><input type="text" id="c_ninst_'+ci+'" name="cninst[]" value="0" class="form-control input-sm" style= "text-align: right;"/></td>'+
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
            url: '<?php echo site_url('agreement2/agreement2/unit_select')?>',
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
      var mTerm = parseInt($('#c_rinstm_'+ci).val());
      var dTerm = parseInt($('#c_rinstd_'+ci).val());

      $(this).closest('tr').find('input[type="text"]').eq(0).val(startDate.toISOString().substr(0,10)); 

      startDate.setMonth(startDate.getMonth() + mTerm);
      startDate.setDate(startDate.getDate() + -1);
      startDate.setDate(startDate.getDate() + dTerm);

      var dateFormated = startDate.toISOString().substr(0,10);

      $('#c_edate_'+ci).val(dateFormated);

    });      

    $('#c_rinstm_'+ci).on('change keyup', function() {

      var startDate = new Date($('#c_sdate_'+ci).val());
      var mTerm = parseInt($(this).val());
      var dTerm = parseInt($('#c_rinstd_'+ci).val());

      startDate.setMonth(startDate.getMonth() + mTerm);
      startDate.setDate(startDate.getDate() + -1);
      startDate.setDate(startDate.getDate() + dTerm);

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
      $(this).closest('tr').find('input[type="text"]').eq(8).val(uData['sqm']);
      
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
      '<td><input type="text" id="d_space_'+ci+'" name="dspace[]" value="0" class="detil deci form-control input-sm" style= "text-align: right;"/></td>'+
      '<td><input type="checkbox" id="d_lump_'+ci+'" class="chkLump" >'+
          '<input type="hidden" id="d_lumpsum_'+ci+'" name="dlumpsum[]" value="0"/></td>'+
      '<td><input type="text" id="d_base_'+ci+'" name="dbase[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
      '<td><input type="text" id="d_mia_'+ci+'" name="dmia[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>'+
      '<td><input type="text" id="d_vat_'+ci+'" name="dvat[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" />'+
      '<input type="hidden" name="dstate[]" value="insert"/></td>'+
      '<td><a id= "dDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');          

    $('.deci').number( true, 2 );
    $('.bulet').number( true, 0 );      

    $('.tanggal').datepicker();

    $('.dropunit').select2({    
        minimumInputLength: 0,
        placeholder: 'Select an option',
        ajax: {
            url: '<?php echo site_url('agreement2/agreement2/unit_select')?>',
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

    $('.dropunit').on("select2:select", function(e){
      var uData = e.params.data;

      /* console.log(uData); */        
      $(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['text']);
      $(this).closest('tr').find('input[type="text"]').eq(2).val(uData['sqm']);
      
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
      '<td><input type="text" id="l_pinst_'+ci+'" name="lpinst[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
      '<td><input type="text" id="l_sdate_'+ci+'" name="lsdate[]" value="<?php echo date('Y-m-d');?>" class="tanggal form-control input-sm" /></td>'+
      '<td><input type="text" id="l_rinstm_'+ci+'" name="lrinstm[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
      '<td><input type="text" id="l_edate_'+ci+'" name="ledate[]" value="<?php echo date('Y-m-d');?>" class="end form-control input-sm" style= "text-align: center;" readonly/></td>'+
      '<td><input type="text" id="l_int_'+ci+'" name="lint[]" value="1" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>'+
      '<td><?php echo form_dropdownext('ltitype[]', $titype, 'MONTH', 'id="l_time_\'+ci+\'" class="detil form-control input-sm" required');?></td>'+
      '<td><input type="text" id="l_per_'+ci+'" name="lper[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>'+
      '<td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "l_unit_'+ci+'" name= "lunit[]" required class="dropunit form-control input-sm" style="width: 100%;">'+
          '</select></div><input type="hidden" id="l_una_'+ci+'" name="luna[]" value="" /></td>'+
      '<td><input type="text" id="l_space_'+ci+'" name="lspace[]" value="0" class="detil deci form-control input-sm" style= "text-align: right;"/></td>'+
      '<td><input type="text" id="l_mia_'+ci+'" name="lmia[]" value="0" class="detil deci form-control input-sm" style= "text-align: right;" /></td>'+
      '<td><input type="text" id="l_vat_'+ci+'" name="lvat[]" value="0" class="detil bulet form-control input-sm" style= "text-align: right;" />'+
      '<input type="hidden" name="lstate[]" value="insert"/></td>'+
      '<td><a id= "lDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');          

    $('.deci').number( true, 2 );
    $('.bulet').number( true, 0 );      

    $('.tanggal').datepicker();

    $('.dropunit').select2({    
        minimumInputLength: 0,
        placeholder: 'Select an option',
        ajax: {
            url: '<?php echo site_url('agreement2/agreement2/unit_select')?>',
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
    $('.droploa').select2({placeholder: 'Choose agreement type..'});

    $('#l_sdate_'+ci).on('change keyup', function() {

      var startDate = new Date($(this).val());
      var mTerm = parseInt($('#l_rinstm_'+ci).val());        

      startDate.setMonth(startDate.getMonth() + mTerm);
      startDate.setDate(startDate.getDate() + -1);

      var dateFormated = startDate.toISOString().substr(0,10);

      $('#l_edate_'+ci).val(dateFormated);

    });
    $('#l_rinstm_'+ci).on('change keyup', function() {

      var startDate = new Date($('#l_sdate_'+ci).val());
      var mTerm = parseInt($(this).val());

      startDate.setMonth(startDate.getMonth() + mTerm);
      startDate.setDate(startDate.getDate() + -1);

      var dateFormated = startDate.toISOString().substr(0,10);

      $('#l_edate_'+ci).val(dateFormated);

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
      $(this).closest('tr').find('input[type="text"]').eq(6).val(uData['sqm']);
      
    });

  }

  function addRowProfit(dt) {

    let trId;
    var form = document.getElementById("frmProfit");
    var agreement_startperiod = $('#agreement_startperiod').val();
    var agreement_endperiod = $('#agreement_endperiod').val();
    var agreement_term = $('#agreement_term').val();
    var agreement_dayterm = $('#agreement_dayterm').val();
    let lastSeq = 0;
    
    if (dt.rows().count()!=0) {
      lastSeq = dt
        .column(2)
        .data()
        .reduce( function (a,b) {
            return Math.max(a,b);
        });
    }

    let nextLine = Number(lastSeq) + 10;  
    trId = `profit-row-${nextLine}`;

    form.setAttribute("formid", trId);

    openRowProfit('Add', {

      'agreementps_line': nextLine,
      'agreementtype_id': '',
      'agreementps_startdate': agreement_startperiod,
      'agreementps_enddate': agreement_endperiod,
      'timetype_id': '',
      'agreementps_unit': '',
      'agreementps_space': 0,
      'agreementps_terms': agreement_term,
      'agreementps_dayterms': agreement_dayterm,
      'agreementps_mia': 0,
      'agreementps_totalomset': 0,
      'agreementps_tax': 11,
      'agreementps_islumpsum': 0,
      'agreementps_isposting': 0,
      'agreementps_idps': '',
      'agreementps_descr': '',
      'unit_id': '',
      'currency_id': 'IDR'
    });

  }

  function insertRowProfit(rowid, dt, obj) {
    
    // Cari baris yang cocok dengan ID
    var matchRow = dt.row( function ( idx, rowdata, node ) {
      return rowdata.rowid === rowid ? true : false;
    });
    var matchData = matchRow.data();
    var dataRow;
    var _state;

    // Jika baris ditemukan, perbarui datanya
    if (matchData===undefined) {
      dt.row.add({
        'rowid': rowid,
        'agreementps_line': obj.agreementps_line,
        'agreementtype_id': obj.agreementtype_id,
        'agreementtype_name': obj.agreementtype_name,
        'agreementps_startdate': obj.agreementps_startdate,
        'agreementps_enddate': obj.agreementps_enddate,
        'timetype_id': obj.timetype_id,
        'agreementps_unit': obj.agreementps_unit,
        'agreementps_space': obj.agreementps_space,
        'agreementps_terms': obj.agreementps_terms,
        'agreementps_dayterms': obj.agreementps_dayterms,
        'agreementps_mia': obj.agreementps_mia,
        'agreementps_totalomset': obj.agreementps_totalomset,
        'agreementps_tax': obj.agreementps_tax,
        'agreementps_islumpsum': obj.agreementps_islumpsum,
        'agreementps_isposting': obj.agreementps_isposting,
        'agreementps_idps': obj.agreementps_idps,
        'agreementps_descr': obj.agreementps_descr,
        'unit_id': obj.unit_id,
        'currency_id': 'IDR',
        '_state': 'new'
      })
      .draw();
    } else {
      if (matchData.hasOwnProperty('agreement_id')) {
        _state = 'update'
      } else {
        _state = 'new'
      }
      //matchData.agreementps_line = obj.agreementps_line
      matchData.agreementtype_id = obj.agreementtype_id
      matchData.agreementtype_name = obj.agreementtype_name
      matchData.agreementps_startdate = obj.agreementps_startdate
      matchData.agreementps_enddate = obj.agreementps_enddate
      matchData.timetype_id = obj.timetype_id
      matchData.agreementps_unit = obj.agreementps_unit
      matchData.agreementps_space = obj.agreementps_space
      matchData.agreementps_terms = obj.agreementps_terms
      matchData.agreementps_dayterms = obj.agreementps_dayterms
      matchData.agreementps_mia = obj.agreementps_mia
      matchData.agreementps_totalomset = obj.agreementps_totalomset
      matchData.agreementps_tax = obj.agreementps_tax
      matchData.agreementps_islumpsum = obj.agreementps_islumpsum
      matchData.agreementps_idps = obj.agreementps_idps
      matchData.agreementps_descr = obj.agreementps_descr
      matchData.unit_id = obj.unit_id
      matchData.currency_id = 'IDR'
      matchData._state = _state
      matchRow.data(matchData).draw();
    }

    dataRow = dt.row(`#${rowid}`).data();
    console.log(dataRow);
    return dataRow;
  }

  function openRowProfit(state, data)
  {

    $("#dlgProfit .modal-title").show().html(`${state} Row Profit Sharing`);
    $("#dlgProfit").modal("show");

    $('#pnl_profit-txt_agreementps_line').val(data.agreementps_line);
    $('#pnl_profit-lbl_agreementps_line').html(data.agreementps_line);
    $('#pnl_profit-dt_agreementps_startdate').val(data.agreementps_startdate.substring(0, 10));
    $('#pnl_profit-txt_agreementps_terms').val(data.agreementps_terms);
    $('#pnl_profit-txt_agreementps_dayterms').val(data.agreementps_dayterms);
    $('#pnl_profit-dt_agreementps_enddate').val(data.agreementps_enddate.substring(0, 10));
    $('#pnl_profit-cbo_timetype_id').val(data.timetype_id);
    $('#pnl_profit-txt_agreementps_unit').val(data.agreementps_unit);
    $('#pnl_profit-txt_unit_id').val(data.unit_id);
    $('#pnl_profit-txt_agreementps_space').val(data.agreementps_space);
    $('#pnl_profit-txt_agreementps_totalomset').val(data.agreementps_totalomset);

    if (data.agreementps_islumpsum==1) {
      $('#pnl_profit-chk_agreementps_islumpsum').prop('checked', true);
      $('#pnl_profit-txt_agreementps_mia').prop('readonly', false);
    } else {
      $('#pnl_profit-chk_agreementps_islumpsum').prop('checked', false);
      $('#pnl_profit-txt_agreementps_mia').prop('readonly', true);
    }
    $('#pnl_profit-txt_agreementps_islumpsum').val(data.agreementps_islumpsum);

    //$('#c_lump_'+row).prop('checked', true);
    $('#pnl_profit-txt_agreementps_mia').val(data.agreementps_mia);
    $('#pnl_profit-txt_agreementps_tax').val(data.agreementps_tax);
    $('#pnl_profit-txt_agreementps_idps').val(data.agreementps_idps);
    $('#pnl_profit-txt_agreementps_descr').val(data.agreementps_descr);
    $('#pnl_profit-cbo_agreementtype_id').val(data.agreementtype_id).trigger('change');
  }

  function setEndDate(startDate, mTerm, dTerm) 
  {
      var endDate = new Date();
      startDate.setMonth(startDate.getMonth() + mTerm);
      startDate.setDate(startDate.getDate() + -1);
      startDate.setDate(startDate.getDate() + dTerm);
      endDate = startDate.toISOString().substr(0,10);
      return endDate;
  }

  function display_modal(title, message){
    $("#mdlinfo").modal("show");
    $("#mdltitle").show().html(title);
    $("#mdlbody").show().html(message);
  }  

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

  #loanTab th, #loanTab td, #loanTab label {
      font-size: 9pt;
      white-space: nowrap;    
  }

  #profitsTab th, #profitsTab td, #profitsTab label {
      font-size: 9pt;
      white-space: nowrap;    
  }

  label {
    font-size: 9pt;
    font-weight: bold;
  }

  .select2-container {
    min-width:120px;
  }

  .form-dialog {
    margin-bottom: 15px !important;
  }

</style>


    <!-- Popover Unit -->
    <div id="popover_unit" class="row" style="display:none;">
      <div class="col-md-12">
        <div class="head">
          <button type="button" class="close popover-close" aria-hidden="true"></button>
        </div>        
          <br>
          <table class="table table-condensed table-striped table-bordered table-hover compact" id="table_unit">
            <thead>
              <tr role="row" class="heading">
                <th><div class="text-center">Unit</div></th>
                <th><div class="text-center">Space</div></th>
                <th><div class="text-center">Lantai</div></th>
                <th><div class="text-center">Status</div></th>
                <th><div class="text-center">Action</div></th>
              </tr>
            </thead>
            <tbody>                
            </tbody>
          </table>        
      </div>
    </div>

    <!-- Popover Unit -->
    <div id="popover_profit" class="row" style="display:none;">
      <div class="col-md-12">
        <div class="head">
          <button type="button" class="close popover-close" aria-hidden="true"></button>
        </div>        
          <br>
          <table class="table table-condensed table-striped table-bordered table-hover compact" id="table_profit">
            <thead>
              <tr role="row" class="heading">
                <th><div class="text-center">ID</div></th>
                <th><div class="text-center">Description</div></th>
                <th><div class="text-center">Action</div></th>
              </tr>
            </thead>
            <tbody>                
            </tbody>
          </table>        
      </div>
    </div>

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

    <!-- /.popup-profit sharing ID -->
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
            <button type="button" class="btn dark btn-outline" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
            <button type="button" class="btn green" data-dismiss="modal" id="addProfitID"> Add Selected Data </button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>       
    <!-- /.End Popup Profit Sharing -->

    <!-- /.popup-loc-renewal -->
    <div class="modal fade" id="tempdialog" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            </button>
            <h4 class="modal-title">
              Renewal Agreement
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
                          <label>LOO No.</label>
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
                            <button type="button" class="btn btn-primary" id="nextnew">Next <i class="fa fa-angle-double-right"></i></button>                                        
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
    <!-- End Popup LOC -->         

    <!-- /.row-add/ edit-profit -->
    <div class="modal fade" id="dlgProfit" tabindex="-1" role="basic" aria-hidden="true" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            </button>
            <h4 class="modal-title"></h4>
          </div>

          <div class="modal-body" style="padding-top: 0px;padding-top: 0px;">
            <div class="row">
              <div class="col-md-12">
                <div class="portlet light">
                  <div class="portlet-body form">
                    <form action="#" id="frmProfit" role="form" class="form form-horizontal">
                      <div class="form-body">

                        <div class="form-group form-group-sm form-dialog ">
                          <label for="pnl_profit-txt_agreementps_line" class="col-md-3 control-label">Line</label>    
                          <div class="col-md-9">                      
                            <!--<input type="text"  id="pnl_profit-txt_agreementps_line" name="agreementps_line" class="form-control input-sm" readonly>-->
                            <p id="pnl_profit-lbl_agreementps_line" class="form-control-static"></p>
                            <input type="hidden" id="pnl_profit-txt_agreementps_line" name="agreementps_line"> 
                          </div>
                        </div>                  

                        <div class="form-group form-group-sm form-dialog">
                          <label for="pnl_profit-cbo_agreementtype_id" class="col-md-3 control-label">Type</label>
                          <div class="col-md-9">  
                            <?php echo form_dropdownext('agreementtype_id', $protype, '', 'id ="pnl_profit-cbo_agreementtype_id" class="form-control input-sm droppro" style="width: 100%;" required');?>
                          </div>
                        </div>

                        <div class="form-group form-group-sm form-dialog">
                          <label for="pnl_profit-dt_agreementps_startdate" class="col-md-3 control-label">Start Date</label>
                          <div class="col-md-9">
                            <div class="input-group input-group-sm date" data-provide="datepicker">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="pnl_profit-dt_agreementps_startdate" name="agreementps_startdate">
                            </div>
                          </div>
                        </div>

                        <div class="form-group form-group-sm form-dialog">
                          <label for="pnl_profit-cc" class="col-md-3 control-label">Term</label>
                          <div class="col-md-5">
                            <div class="input-group input-group-sm">
                              <input type="text" class="form-control bulet" id="pnl_profit-txt_agreementps_terms" name="agreementps_terms" style="text-align:center;" value=0>
                              <span class="input-group-addon">Month</span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="input-group input-group-sm">
                              <input type="text" class="form-control bulet" id="pnl_profit-txt_agreementps_dayterms" name="agreementps_dayterms" style="text-align:center;" value=0>
                              <span class="input-group-addon">Day</span>
                            </div>
                          </div>
                        </div>

                        <div class="form-group form-group-sm form-dialog">
                          <label for="pnl_profit-dt_agreementps_enddate" class="col-md-3 control-label">End Date</label>
                          <div class="col-md-9">
                            <div class="input-group input-group-sm date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="pnl_profit-dt_agreementps_enddate" name="agreementps_enddate" readonly>
                            </div>
                          </div>
                        </div>

                        <div class="form-group form-group-sm form-dialog">
                          <label for="pnl_profit-cbo_timetype_id" class="col-md-3 control-label">Time Type</label>
                          <div class="col-md-9">
                            <?php echo form_dropdownext('timetype_id', $titype, '', 'id ="pnl_profit-cbo_timetype_id" class="form-control input-sm" style="width: 100%;" required');?>
                          </div>
                        </div>

                        <div class="form-group form-group-sm form-dialog">
                          <label for="pnl_profit-txt_agreementps_unit" class="col-md-3 control-label">Unit</label>
                          <div class="col-md-9">
                            <div class="input-group input-group-sm">
                              <input type="text" id = "pnl_profit-txt_agreementps_unit" name="agreementps_unit" class="form-control agreementps_unit" readonly value="" required>
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-primary search-unit" data-bs-toggle="popover"><i class="fa fa-search"></i></button>
                              </span> 
                              <input type="hidden" id="pnl_profit-txt_unit_id" name="unit_id" class="unit_id"> 
                            </div>
                          </div>
                        </div>

                        <div class="form-group form-group-sm form-dialog">
                          <label for="pnl_profit-txt_agreementps_space" class="col-md-3 control-label">Space</label>
                          <div class="col-md-9">
                            <div class="input-group input-group-sm">
                              <input type="text" class="form-control deci agreementps_space" id="pnl_profit-txt_agreementps_space" name="agreementps_space" style="text-align:right;" value=0 readonly>
                              <span class="input-group-addon">m<sup>2</sup></span>
                            </div>
                          </div>
                        </div>

                        <div class="form-group form-group-sm form-dialog">
                          <label for="pnl_profit-txt_agreementps_totalomset" class="col-md-3 control-label">Omset</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control bulet" id="pnl_profit-txt_agreementps_totalomset" name="agreementps_totalomset" style="text-align:right;" value=0>
                          </div>
                        </div>

                        <div class="form-group form-group-sm form-dialog">
                          <label for="pnl_profit-chk_agreementps_islumpsum" class="col-md-3 control-label"></label>
                          <div class="col-md-9">
                            <div class="md-checkbox-list">
                              <div class="md-checkbox">
                                <input type="checkbox" id="pnl_profit-chk_agreementps_islumpsum" class="md-check"/>
                                <label for="pnl_profit-chk_agreementps_islumpsum" style="font-weight: normal;">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span> Lumpsum</label>
                              </div>
                              <input type="hidden" id="pnl_profit-txt_agreementps_islumpsum" name="agreementps_islumpsum">
                            </div>
                          </div>
                        </div>

                        <div class="form-group form-group-sm form-dialog">
                          <label for="pnl_profit-txt_agreementps_mia" class="col-md-3 control-label">Monthly Installment</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control bulet" id="pnl_profit-txt_agreementps_mia" name="agreementps_mia" style="text-align:right;" value=0>
                          </div>
                        </div>

                        <div class="form-group form-group-sm form-dialog">
                          <label for="pnl_profit-txt_agreementps_tax" class="col-md-3 control-label">Tax</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control bulet" id="pnl_profit-txt_agreementps_tax" name="agreementps_tax" style="text-align:right;" value=0>
                          </div>
                        </div>

                        
                        <div class="form-group form-group-sm form-dialog">
                          <label for="pnl_profit-txt_agreementps_idps" class="col-md-3 control-label">Profit Sharing ID</label>
                          <div class="col-md-9">
                            <div class="input-group input-group-sm">
                              <div class="input-group-control">
                                <input type="text" id = "pnl_profit-txt_agreementps_idps" name="agreementps_idps" class="form-control agreementps_idps" readonly>
                                <div class="form-control-focus"></div>
                              </div>
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-primary search-profit" data-bs-toggle="popover"><i class="fa fa-search"></i></button>
                              </span>
                            </div>
                          </div>
                        </div>

                        <div class="form-group form-group-sm form-dialog">
                          <label for="pnl_profit-txt_agreementps_descr" class="col-md-3 control-label">Descr</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control agreementps_descr" id="pnl_profit-txt_agreementps_descr" name="agreementps_descr">
                          </div>
                        </div>

                      </div>
                      <div class="form-actions right">
                        <button id="clsFrmProfit" type="button" class="btn btn-circle dark btn-outline" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
                        <button id="submitFormDetail" type="submit" class="btn btn-circle green-haze"><i class="fa fa-save"></i> Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
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
                  <a href="<?php echo base_url('index.php/agreement2/agreement2/agreementlist'); ?>" id='tablist'> LIST </a>
                </li>
                <li>                          
                  <a href="<?php echo base_url('index.php/agreement2/agreement2/agreementadd'); ?>" id='tabdata'> INPUT </a>
                </li>
                <li>
                  <a href="#editdata" data-toggle="tab"  id='tabedit'> EDIT </a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane" id="editdata">
                  <div class="portlet-body form">
                  <form id="frmAgreement" action="<?php echo site_url('agreement2/agreement2/agreement_edit');?>" method="post">
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
                              <label class="post checkbox-inline pull-right"><input type="checkbox" <?php if ($row->agreement_isclosed == 1) echo 'checked= "checked"';?> disabled>Closed
                                <input type="hidden" id="hclosed" name="hclosed" value="<?=$row->agreement_isclosed;?>"/>
                              </label>
                              <label class="post checkbox-inline pull-right"><input type="checkbox" <?php if ($row->agreement_isrenewal == 1) echo 'checked= "checked"';?> disabled>Renewal&nbsp;
                                <input type="hidden" id="hrenewal" name="hrenewal" value="<?=$row->agreement_isrenewal;?>"/>
                              </label>
                              <label class="post checkbox-inline pull-right"><input type="checkbox" <?php if ($row->agreement_isapproved == 1) echo 'checked= "checked"';?> disabled>Approved&nbsp;
                                <input type="hidden" id="happroved" name="happroved" value="<?=$row->agreement_isapproved;?>"/>
                              </label>
                              <input  type="text" id="agreement_id" name="agreement_id" class="form-control input-sm" value="<?php echo $row->agreement_id;?>" readonly>
                              <input type="hidden" id="objdel" name="objdel"/>
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
                                <select data-placeholder="Select a store" id= "ibranch" name= "cbobranch" style="width:100%;" required>
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
                              <label class="checkbox-inline" style="font-weight: bold;">
                                  <input id="isflat" type="checkbox" <?php if ($row->agreement_isflat == 1) echo 'checked= "checked"';?> >Installment Flat                                          
                                  <input type="hidden" id="_isflat" name="_isflat" value="0"/>
                              </label>
                              <div class="input-group input-group-sm">
                                <input type="text" id = "agreement_installmentflat" name="agreement_installmentflat" value="<?php echo $row->agreement_installmentflat;?>"
                                  class="deci form-control input-sm" style="text-align: right;" readonly>
                                <span class="input-group-addon" style="font-style: italic;">(Month)</span>
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
                          
                            

                          <div class="col-md-4 form-group form-group-sm row">
                            <div class="col-xs-12">
                              <label>THD Status</label>                                        
                                <?php echo form_dropdown('cboThdStatus', $thdstatus, $row->thdstatus_id, 'id ="iStatus" class="form-control" style="width: 100%;" required '); ?>
                            </div>
                          </div>    

                            <div class="col-md-4 form-group form-group-sm row">
                                <div class="col-xs-12">
                                    <label>THD Type</label>                                        
                                    <?php echo form_dropdown('cboThdType', $thdtype, $row->thdtype_id, 'id ="thdType" class="form-control" style="width: 100%;" required '); ?>
                                </div>
                            </div>

                            <div class="col-md-4 form-group form-group-sm row">
                                <div class="col-xs-12">
                                    <label>THD Group</label>
                                    <?php echo form_dropdown('cboThdGroup', $thdgroup, $row->thdgroup_id, 'id ="thdGroup" class="form-control" style="width: 100%;" required '); ?>
                                </div>
                            </div>

                            <div class="col-md-4 form-group form-group-sm row">
                                <div class="col-xs-12">
                                    <label>THD Category</label>
                                    <?php echo form_dropdown('cboThdCat', $thdcat, $row->thdcat_id, 'id ="thdCat" class="form-control" style="width: 100%;" required '); ?>
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
                                  <li><a href="#tab_4" data-toggle="tab" role = "tab">Loan</a></li>
                                  <li><a href="#tab_5" data-toggle="tab" role = "tab">Profit Sharing</a></li>
                                  <li><a href="#tab_6" data-toggle="tab" role = "tab">Record</a></li>
                                </ul>
                                <div class="tab-content">
                                  <div class="tab-pane active" id="tab_1">
                                    <div class ="table-responsive">
                                      <table class="table table-bordered table-striped" id='rentalTab' style="border:solid 1px #999; #999; border-radius:0px;">
                                        <thead>
                                          <tr>
                                              <th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Line</th>
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
                                          <?php if(isset($resultr)){                                                          
                                              foreach($resultr as $rowr){
                                          ?>
                                            <tr>
                                            <td><?php echo "$rowr->agreementdetil_line";?><input type="hidden" name="rline[]" value="<?php echo "$rowr->agreementdetil_line";?>"/></td>
                                            <td><div class="form-group form-group-sm">
                                                <?php echo form_dropdownext('rtype[]',$renttype, $rowr->agreementtype_id, 'r_type" class="droprental form-control input-sm" style="width: 100%;" required');?>
                                                </div>
                                            </td>
                                            <td><input type="text" id="r_spdate" name="rspdate[]" value="<?php $dP = new DateTime($rowr->agreementdetil_startdatepayment);echo $dP->format('Y-m-d');?>" class="spdate form-control input-sm" style= "text-align: center;" <?php if ($rowr->agreementtype_id !== '4000') echo 'disabled'; ?> />
                                                <input type="hidden" id = "h_spdate" name="hspdate[]" value="<?php echo $rowr->agreementdetil_startdatepayment;?>">
                                            </td>
                                            <td><input type="text" id="r_pinst" name="rpinst[]" value="<?php echo $rowr->agreementdetil_installmentpayment;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                            <td><input type="text" id="r_sdate" name="rsdate[]" value="<?php $dS = new DateTime($rowr->agreementdetil_startdate);echo $dS->format('Y-m-d');?>" class="rstrans form-control input-sm" /></td>
                                            <td><input type="text" id="r_rinstm" name="rrinstm[]" value="<?php echo $rowr->agreementdetil_installment;?>" class="rinstm detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                            <td><input type="text" id="r_rinstd" name="rrinstd[]" value="<?php echo $rowr->agreementdetil_dayinstallment;?>" class="rinstd detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                            <td><input type="text" id="r_edate" name="redate[]" value="<?php $dE = new DateTime($rowr->agreementdetil_enddate);echo $dE->format('Y-m-d');?>" class="end form-control input-sm" style= "text-align: center;" readonly/></td>
                                            <td><input type="text" id="r_int_'+ci+'" name="rint[]" value="<?php echo $rowr->agreementdetil_interval;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                            <td><?php echo form_dropdownext('rtitype[]',$titype, $rowr->timetype_id, 'id="r_time" class="detil form-control input-sm" required');?></td>
                                            <td><input type="text" id="r_per_'+ci+'" name="rper[]" value="<?php echo $rowr->agreementdetil_percent;?>" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>
                                            <td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "r_unit" name= "runit[]" required class="unitr dropunit form-control input-sm" style="width: 100%;">
                                                <option value="<?php echo $rowr->unit_id;?>" selected="selected" ><?php echo $rowr->unit_name;?></option>
                                                </select></div><input type="hidden" id="r_una_" name="runa[]" value="<?php echo $rowr->agreementdetil_unit;?>" /></td>
                                            <td><?php echo form_dropdownext('runitspot[]', $outdoor, $rowr->agreementdetil_unitspot, 'id="r_unitspot" class="detil form-control input-sm" required');?></td>
                                            <td><input type="text" id="r_space" name="rspace[]" value="<?php echo $rowr->agreementdetil_space;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>
                                            <td><input type="checkbox" id="lump" <?php if ($rowr->agreementdetil_islumpsum == 1) echo 'checked= "checked"';?> class="rLump" >
                                                <input type="hidden" id="r_lumpsum" name="rlumpsum[]" value = "<?php echo "$rowr->agreementdetil_islumpsum"; ?>"/></td>
                                            <td><input type="text" id="r_base" name="rbase[]" value="<?php echo $rowr->agreementdetil_baserent;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                            <td><input type="text" id="r_mia" name="rmia[]" value="<?php echo $rowr->agreementdetil_mia;?>" class="detil bulet form-control input-sm" style= "text-align: right;" <?php if ($rowr->agreementdetil_islumpsum != 1) echo 'readonly'; ?> /></td>
                                            <td><input type="text" id="r_vat" name="rvat[]" value="<?php echo $rowr->agreementdetil_tax;?>" class="form-control input-sm" style= "text-align: right;" /></td>
                                            <td><input type="checkbox" id="aden" <?php if ($rowr->agreementdetil_isadendum == 1) echo 'checked= "checked"';?> class="rAden">
                                                <input type="hidden" id="r_adendum" name="radendum[]" value="<?php echo "$rowr->agreementdetil_isadendum"; ?>"/></td>
                                            <td><input type="text" id="r_ninst" name="rninst[]" value="<?php echo (isset($rowr->agreementdetil_ndesc)) ?  $rowr->agreementdetil_ndesc : '0'; ?>" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>
                                            <td><input type="text" id="r_descr" name="rdescr[]" value="<?php echo $rowr->agreementdetil_descr;?>" class="pops form-control input-sm"/>
                                                <input type="hidden" name="rstate[]" value="update"/></td>
                                            <td><a id= "rDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
                                            </tr>
                                            <script>
                                            //$('.bulet').number( true, 0 );                                                      
                                            $('.rstrans').datepicker();
                                            $('.spdate').datepicker();
                                            $('.rstrans').on('change keyup', function() {                                                        

                                              var startDate = new Date($(this).val());
                                              var mTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(3).val());   
                                              var dTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(4).val());

                                              $(this).closest('tr').find('input[type="text"]').eq(0).val(startDate.toISOString().substr(0,10));/* SET StartDate Payment = StartDate Transaction */                                                      
                                              $(this).closest('tr').find('input[type="hidden"]').eq(1).val(startDate.toISOString().substr(0,10)); 

                                              startDate.setMonth(startDate.getMonth() + mTerm);
                                              startDate.setDate(startDate.getDate() + -1);
                                              startDate.setDate(startDate.getDate() + dTerm);

                                              var dateFormated = startDate.toISOString().substr(0,10);   

                                              $(this).closest('tr').find('input[type="text"]').eq(5).val(dateFormated);

                                            }); 
                                            $('.rinstm').on('change keyup', function() {                                                        

                                              var startDate = new Date($(this).closest('tr').find('input[type="text"]').eq(2).val())
                                              var mTerm = parseInt($(this).val());
                                              var dTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(4).val());

                                              startDate.setMonth(startDate.getMonth() + mTerm);
                                              startDate.setDate(startDate.getDate() + -1);
                                              startDate.setDate(startDate.getDate() + dTerm);

                                              var dateFormated = startDate.toISOString().substr(0,10);

                                              $(this).closest('tr').find('input[type="text"]').eq(5).val(dateFormated);

                                            }); 
                                            $('.rinstd').on('change keyup', function() {

                                              var startDate = new Date($(this).closest('tr').find('input[type="text"]').eq(2).val())
                                              var mTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(3).val());
                                              var dTerm = parseInt($(this).val());

                                              startDate.setMonth(startDate.getMonth() + mTerm);
                                              startDate.setDate(startDate.getDate() + -1);
                                              startDate.setDate(startDate.getDate() + dTerm);

                                              var dateFormated = startDate.toISOString().substr(0,10);

                                              $(this).closest('tr').find('input[type="text"]').eq(5).val(dateFormated);

                                            }); 
                                            $('.unitr').on("select2:select", function(e){
                                              var uData = e.params.data;   

                                              //alert ('tst');

                                              $(this).closest('tr').find('input[type="hidden"]').eq(2).val(uData['text']);
                                              $(this).closest('tr').find('input[type="text"]').eq(8).val(uData['sqm']);
                                              
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
                                          <?php if(isset($resultc)){                                                        
                                              foreach($resultc as $rowc){

                                          ?>
                                            <tr>
                                            <td><?php echo "$rowc->agreementdetil_line";?><input type="hidden" name="cline[]" value="<?php echo "$rowc->agreementdetil_line";?>"/></td>
                                            <td><div class="form-group form-group-sm">
                                                <?php echo form_dropdownext('ctype[]',$chgtype, $rowc->agreementtype_id, 'c_type" class="droprental form-control input-sm" style="width: 100%;" required');?>
                                                </div>
                                            </td>
                                            <td><input type="text" id="c_spdate" name="cspdate[]" value="<?php $dP = new DateTime($rowc->agreementdetil_startdatepayment);echo $dP->format('Y-m-d');?>" class="start form-control input-sm" style= "text-align: center;" readonly/></td>
                                            <td><input type="text" id="c_pinst" name="cpinst[]" value="<?php echo $rowc->agreementdetil_installmentpayment;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                            <td><input type="text" id="c_sdate" name="csdate[]" value="<?php $dS = new DateTime($rowc->agreementdetil_startdate);echo $dS->format('Y-m-d');?>" class="cstrans form-control input-sm" /></td>
                                            <td><input type="text" id="c_rinstm" name="crinstm[]" value="<?php echo $rowc->agreementdetil_installment;?>" class="cinstm detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                            <td><input type="text" id="c_rinstd" name="crinstd[]" value="<?php echo $rowc->agreementdetil_dayinstallment;?>" class="cinstd detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                            <td><input type="text" id="c_edate" name="cedate[]" value="<?php $dE = new DateTime($rowc->agreementdetil_enddate);echo $dE->format('Y-m-d');?>" class="end form-control input-sm" style= "text-align: center;" readonly/></td>
                                            <td><input type="text" id="c_int" name="cint[]" value="<?php echo $rowc->agreementdetil_interval;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                            <td><?php echo form_dropdownext('ctitype[]',$titype, $rowc->timetype_id, 'id="c_time" class="detil form-control input-sm" required');?></td>
                                            <td><input type="text" id="c_per" name="cper[]" value="<?php echo $rowc->agreementdetil_percent;?>" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>
                                            <td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "c_unit" name= "cunit[]" required class="unitc dropunit form-control input-sm" style="width: 100%;">
                                                <option value="<?php echo $rowc->unit_id;?>" selected="selected" ><?php echo $rowc->unit_name;?></option>
                                                </select></div><input type="hidden" id="c_una_" name="cuna[]" value="<?php echo $rowc->agreementdetil_unit;?>" /></td>
                                            <td><?php echo form_dropdownext('cunitspot[]', $outdoor, $rowc->agreementdetil_unitspot, 'id="c_unitspot" class="detil form-control input-sm" required');?></td>
                                            <td><input type="text" id="c_space" name="cspace[]" value="<?php echo $rowc->agreementdetil_space;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>
                                            <td><input type="checkbox" id="c_lump" <?php if ($rowc->agreementdetil_islumpsum == 1) echo 'checked= "checked"';?> class="cLump">
                                                <input type="hidden" id="c_lumpsum" name="clumpsum[]" value = "<?php echo "$rowc->agreementdetil_islumpsum"; ?>"/></td>
                                            <td><input type="text" id="c_base" name="cbase[]" value="<?php echo $rowc->agreementdetil_baserent;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                            <td><input type="text" id="c_mia" name="cmia[]" value="<?php echo $rowc->agreementdetil_mia;?>" class="detil bulet form-control input-sm" style= "text-align: right;" <?php if ($rowc->agreementdetil_islumpsum != 1) echo 'readonly'; ?> /></td>
                                            <td><input type="text" id="c_vat" name="cvat[]" value="<?php echo $rowc->agreementdetil_tax;?>" class="form-control input-sm" style= "text-align: right;" /></td>
                                            <td><input type="checkbox" id="c_aden" <?php if ($rowc->agreementdetil_isadendum == 1) echo 'checked= "checked"';?> class="cAden">
                                                <input type="hidden" id="c_adendum" name="cadendum[]" value="<?php echo $rowc->agreementdetil_isadendum; ?>"/></td>
                                            <td><input type="text" id="c_ninst" name="cninst[]" value="<?php echo (isset($rowc->agreementdetil_ndesc)) ?  $rowc->agreementdetil_ndesc : '0'; ?>" class="form-control input-sm" style= "text-align: right;"/></td>
                                            <td><input type="text" id="c_descr" name="cdescr[]" value="<?php echo $rowc->agreementdetil_descr;?>" class="pops form-control input-sm"/>
                                                <input type="hidden" name="cstate[]" value="update"/></td>
                                            <td><a id= "cDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
                                            </tr>
                                            <script>
                                              $('.cstrans').datepicker();                                                        
                                              $('.cstrans').on('change keyup', function() {                                                        

                                                var startDate = new Date($(this).val());
                                                var mTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(3).val()); 
                                                var dTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(4).val());  

                                                $(this).closest('tr').find('input[type="text"]').eq(0).val(startDate.toISOString().substr(0,10)); /* SET StartDate Payment = StartDate Transaction */

                                                startDate.setMonth(startDate.getMonth() + mTerm);
                                                startDate.setDate(startDate.getDate() + -1);
                                                startDate.setDate(startDate.getDate() + dTerm);

                                                var dateFormated = startDate.toISOString().substr(0,10);   

                                                $(this).closest('tr').find('input[type="text"]').eq(5).val(dateFormated);

                                              });                                                
                                              $('.cinstm').on('change keyup', function() {                                                        

                                                var startDate = new Date($(this).closest('tr').find('input[type="text"]').eq(2).val())
                                                var mTerm = parseInt($(this).val());
                                                var dTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(4).val());

                                                startDate.setMonth(startDate.getMonth() + mTerm);
                                                startDate.setDate(startDate.getDate() + -1);
                                                startDate.setDate(startDate.getDate() + dTerm);

                                                var dateFormated = startDate.toISOString().substr(0,10);

                                                $(this).closest('tr').find('input[type="text"]').eq(5).val(dateFormated);

                                              }); 
                                              $('.cinstd').on('change keyup', function() {

                                              var startDate = new Date($(this).closest('tr').find('input[type="text"]').eq(2).val())
                                              var mTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(3).val());
                                              var dTerm = parseInt($(this).val());

                                              startDate.setMonth(startDate.getMonth() + mTerm);
                                              startDate.setDate(startDate.getDate() + -1);
                                              startDate.setDate(startDate.getDate() + dTerm);

                                              var dateFormated = startDate.toISOString().substr(0,10);

                                              $(this).closest('tr').find('input[type="text"]').eq(5).val(dateFormated);

                                            });
                                              $('.unitc').on("select2:select", function(e){
                                                  var uData = e.params.data;

                                                  $(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['text']);
                                                  $(this).closest('tr').find('input[type="text"]').eq(8).val(uData['sqm']);
                                                  
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
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Length</th>
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
                                                  <select data-placeholder = "Select unit" id= "d_unit" name= "dunit[]" required class="unitd dropunit form-control input-sm" style="width: 100%;">
                                                    <option value="<?php echo $rowd->unit_id;?>" selected="selected" ><?php echo $rowd->unit_name;?></option>
                                                  </select></div><input type="hidden" id="d_una" name="duna[]" value="<?php echo $rowd->unit_name;?>" /></td>
                                              <td><input type="text" id="d_space" name="dspace[]" value="<?php echo $rowd->agreementdeposit_space;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>
                                              <td><input type="checkbox" id="d_lump" class="chkLump" <?php if ($rowd->agreementdeposit_islumpsum == 1) echo 'checked= "checked"';?> >
                                                  <input type="hidden" id="d_lumpsum" name="dlumpsum[]" value="<?php echo $rowd->agreementdeposit_islumpsum;?>"/></td>
                                              <td><input type="text" id="d_base" name="dbase[]" value="<?php echo $rowd->agreementdeposit_idr;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                              <td><input type="text" id="d_mia" name="dmia[]" value="<?php echo $rowd->agreementdeposit_idrsubtotal;?>" class="detil bulet form-control input-sm" style= "text-align: right;" <?php if ($rowd->agreementdeposit_islumpsum != 1) echo 'readonly'; ?>/></td>
                                              <td><input type="text" id="d_vat" name="dvat[]" value="<?php echo $rowd->agreementdeposit_tax;?>" class="detil bulet form-control input-sm" style= "text-align: right;" />
                                                  <input type="hidden" name="dstate[]" value="update"/></td>
                                              <td><a id= "dDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td> 
                                              </tr>
                                              <script>
                                                $('.dstart').datepicker();
                                                $('.unitd').on("select2:select", function(e){
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
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Space (M2)</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Total Loan IDR.</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">VAT</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Delete</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($resultl)){
                                                foreach($resultl as $rowl){
                                            ?>
                                              <tr>
                                              <td><?php echo $rowl->agreementloan_line;?><input type="hidden" name="lline[]" value="<?php echo $rowl->agreementloan_line;?>"/></td>
                                              <td><div class="form-group form-group-sm"><?php echo form_dropdownext('ltype[]',$loatype, $rowl->agreementtype_id, 'id="l_type" class="droploa form-control input-sm" style="width: 100%;" required');?></div></td>
                                              <td><input type="text" id="l_pinst" name="lpinst[]" value="<?php echo $rowl->agreementloan_installmentpayment;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                              <td><input type="text" id="l_sdate" name="lsdate[]" value="<?php  $dS = new DateTime($rowl->agreementloan_startdate);echo $dS->format('Y-m-d');?>" class="lstrans form-control input-sm" /></td>                                                      
                                              <td><input type="text" id="l_rinstm" name="lrinstm[]" value="<?php echo $rowl->agreementloan_installment;?>" class="linstm detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                              <td><input type="text" id="l_edate" name="ledate[]" value="<?php $dE = new DateTime($rowl->agreementloan_enddate);echo $dE->format('Y-m-d');?>" class="end form-control input-sm" style= "text-align: center;" readonly/></td>
                                              <td><input type="text" id="l_int" name="lint[]" value="<?php echo $rowl->agreementloan_interval;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                              <td><?php echo form_dropdownext('ltitype[]', $titype, $rowl->timetype_id, 'id="l_time" class="detil form-control input-sm" required');?></td>
                                              <td><input type="text" id="l_per" name="lper[]" value="<?php echo $rowl->agreementloan_percent;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>
                                              <td><div class="form-group form-group-sm">
                                                  <select data-placeholder = "Select unit" id= "l_unit" name= "lunit[]" required class="unitl dropunit form-control input-sm" style="width: 100%;">
                                                    <option value="<?php echo $rowl->unit_id;?>" selected="selected" ><?php echo $rowl->unit_name;?></option>
                                                  </select></div><input type="hidden" id="l_una" name="luna[]" value="<?php echo $rowl->unit_name;?>" /></td>
                                              <td><input type="text" id="l_space" name="lspace[]" value="<?php echo $rowl->agreementloan_space;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>                                                      
                                              <td><input type="text" id="l_mia" name="lmia[]" value="<?php echo $rowl->agreementloan_mia;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                              <td><input type="text" id="l_vat" name="lvat[]" value="<?php echo $rowl->agreementloan_tax;?>" class="detil bulet form-control input-sm" style= "text-align: right;" />
                                                  <input type="hidden" name="lstate[]" value="update"/></td>
                                              <td><a id= "lDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td> 
                                              </tr>
                                              <script>
                                                $('.lstrans').datepicker();
                                                $('.lstrans').on('change keyup', function() {                                                        

                                                  var startDate = new Date($(this).val());
                                                  var mTerm = parseInt($(this).closest('tr').find('input[type="text"]').eq(2).val());   

                                                  startDate.setMonth(startDate.getMonth() + mTerm);
                                                  startDate.setDate(startDate.getDate() + -1);

                                                  var dateFormated = startDate.toISOString().substr(0,10);   

                                                  $(this).closest('tr').find('input[type="text"]').eq(3).val(dateFormated);
                                                });                                                
                                                $('.linstm').on('change keyup', function() {                                                        

                                                  var startDate = new Date($(this).closest('tr').find('input[type="text"]').eq(1).val())
                                                  var mTerm = parseInt($(this).val());

                                                  startDate.setMonth(startDate.getMonth() + mTerm);
                                                  startDate.setDate(startDate.getDate() + -1);

                                                  var dateFormated = startDate.toISOString().substr(0,10);

                                                  $(this).closest('tr').find('input[type="text"]').eq(3).val(dateFormated);
                                                });
                                                $('.unitl').on("select2:select", function(e){                                                          
                                                  var uData = e.params.data;        
                                                  $(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['text']);
                                                  $(this).closest('tr').find('input[type="text"]').eq(6).val(uData['sqm']);                                                            
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
                                      <div class ="table-container">
                                      <input type="hidden" id="row_profit" name="row_profit"/>
                                      <table class="table stripe hover" id='profitsTab' style="width:100%;">
                                        <thead>
                                          <tr>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;"></th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;"></th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Post</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Type</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Start Date</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">T (m)</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">T (d)</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">End Date</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Time Type</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Unit</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Space (m<sup>2</sup>)</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Monthly Installment</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                      </table>
                                      </div>
                                  </div>
                                  <div class="tab-pane" id="tab_6">
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

                                      <div class="col-md-6">
                                      <div class="col-xs-8">
                                          <label>Terminate By</label>
                                          <input type="text" id="agreement_closeby" name="agreement_closeby" class="form-control input-sm" value="<?php echo $row->agreement_closeby;?>" readonly>
                                      </div>
                                      </div>

                                      <div class="col-md-6">
                                      <div class="col-xs-8">
                                          <label>Terminate Date</label>
                                          <input type="text" id="agreement_closedate" name="agreement_closedate" class="form-control input-sm" value="<?php echo $row->agreement_closedate;?>" readonly>
                                      </div>
                                      </div>

                                      <div class="col-md-6">
                                      <div class="col-xs-8">
                                          <label>Terminate Reason</label>
                                          <input type="text" id="agreement_closereason" name="agreement_closereason" class="form-control input-sm" value="<?php echo $row->agreement_closereason;?>" readonly>
                                      </div>
                                      </div>

                                      <div class="col-md-6">
                                      <div class="col-xs-8">
                                          <label>Terminate Desc</label>
                                          <input type="text" id="agreement_closedesc" name="agreement_closedesc" class="form-control input-sm" value="<?php echo $row->agreement_closedesc;?>" readonly>
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
                            <br /><button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Submit</button>
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
