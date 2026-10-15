
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

    var bra_id = $('#ibranch').val(); 

    branchData = results.data;   

    listunit = branchData.filter(function (data) { return data.branch == bra_id });; 

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

  
  $('#iregion').select2({placeholder: 'Select a business unit'});
  $('#iutype').select2({placeholder: 'Choose unit ..'});
  $('#istruk').select2({placeholder: 'Choose strukturunit ..'});
  $('#icalc').select2({placeholder: 'Choose calculation type ..'}); 
  $('.dropunit').select2(unitOptions);
  $('.droprental').select2({placeholder: 'Choose agreement type..'});
  $('.dropdepo').select2({placeholder: 'Choose agreement type..'});

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
  var oTable=popgrid("<?php echo site_url('agreement/agreement/controler_griddialog')?>","uLoader","trp", 10);

  var rTable=popgrid("<?php echo site_url('agreement/agreement/controler_gridpop')?>","popLoader","trp", 10);  

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

  $('#addschema').click(function () {

      var linenum=0;
      var scData = scTable.rows('.selected').data();

      for (var i=0; i < scData.length ;i++){

          var _id     = scData[i][0];
          var _dp     = scData[i][2];
          var _cp     = scData[i][13];
          var skema;


          $('#skl_id').val(_id);

          $('#loo_descr').val(_cp);          

          function getDataSchema (){
             var ajax = $.get('<?php echo site_url('loo/loo/loo_getskema')?>','id='+_id, function(data){
               //do something with data here               
             }, 'json');
             return ajax;
          }
           
          getDataSchema().done(function(results){
            skema = results.data;       

            for (var k=0; k < skema.length; k++){
                //console.log(skema);
                agdescr   = skema[k][2];
                agcent    = skema[k][5];
                agid      = skema[k][6];
                agint     = skema[k][7];
                agtim     = skema[k][8];
                agname    = skema[k][9];

                addRow(k);
                $('#ag_'+k).append(new Option(agname, agid, false, false)).trigger('change');

                if (agid === '2000') {                 
                  $('#per_'+k).val(agcent);
                  $('#chk_'+k).prop('checked', true);
                  $('#chg_'+k).prop('readonly', true);
                  $('#per_'+k).prop('readonly', false);
                  $('#cper_'+k).val('1');
                }

                $('#des_'+k).val(agdescr);
                $('#int_'+k).val(agint);
                $('#tit_'+k).val(agtim);

                if (typeof listunit !== 'undefined' && listunit.length > 0) {

                  $('.dropunit').append(new Option(listunit[0]['text'], listunit[0]['id'], false, false)).trigger('change');
                  $('.dReg').val($("#iregion").val());
                  $('.dBra').val($("#ibranch").val());
                  $('.dTen').val($("#htenant").val());
                  $('.dBran').val($("#hbrand").val());
                  // the array is defined and has at least one element
                }

            }

          });
                   
      }

  });

  $("#rentalTab").on('click','#btnDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }
      $(this).closest('tr').remove();
  });

  $("#looDetil").on('change', "input[type='checkbox']", function (e) {

      $(this).closest('tr').find('input[type="text"]').eq(0).prop('readonly', e.target.checked ? true: false);
      $(this).closest('tr').find('input[type="text"]').eq(1).prop('readonly', e.target.checked ? false: true);
      $(this).closest('tr').find('input[type="hidden"]').eq(1).val(e.target.checked ? 1: 0);

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

                    <!-- /.popup-template -->
                    <div class="modal fade" id="tempdialog" tabindex="-1" role="basic" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            </button>
                            <h4 class="modal-title">
                              Schema Unit
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
                                    <table class="table table-striped table-bordered table-hover nowrap" id='scLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                                      <thead>
                                       <tr>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Schema</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">DP(%)/bln</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Inst.(X)</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">LOO(%)</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">LOI(%)</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">SD.R(%)</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">SD.SC(%)</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Ltrk.</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Air</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Gas</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Telp.</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Type</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Term</th>
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
                            <button type="button" class="btn green" data-dismiss="modal" id="addschema">
                              Accept
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
                          <a href="<?php echo base_url('index.php/agreement/agreement/agreementlist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>                          
                          <a href="<?php echo base_url('index.php/agreement/agreement/agreementadd'); ?>" id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata" data-toggle="tab"  id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane" id="editdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('agreement/agreement/agreement_edit');?>" method="post" onsubmit="return validateb4submit();">
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
                                        <input type="text" id = "idebtor" name="idebtor" class="form-control input-sm" value="<?php echo $row->agreement_contractno;?>" readonly required autocomplete="off">
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
                                      <label class="post checkbox-inline"><input type="checkbox" disabled>Closed</label>
                                      <label class="post checkbox-inline"><input type="checkbox" disabled>Approved</label>
                                   </div>
                                  </div>
                                  <div class="col-md-11 form-group row">                                    
                                    <div class="col-xs-12">
                                      <label>Description:</label>
                                      <textarea id = "agreement_descr" name="agreement_descr" class="form-control input-sm" required rows="2" ><?php echo $row->agreement_descr;?></textarea>
                                    </div>                                    
                                  </div>       
                                  <div class="col-md-12 form-group row"></div>
                                  <div class="col-md-4 form-group row"></div>
                                  <div class="col-md-4 form-group row"></div>
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
                                  <div class="col-md-4 form-group row"></div>
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
                                          <li><a href="#tab_5" data-toggle="tab" role = "tab">Record</a></li>
                                        </ul>
                                        <div class="tab-content">
                                          <div class="tab-pane active" id="tab_1">
                                            <div class ="table-responsive">       
                                              <div style="overflow-y: scroll; height: 200px">                                              
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
                                                      <td><input type="text" id="r_spdate" name="rspdate[]" value="<?php echo date('Y-m-d',strtotime($rowr->agreementdetil_startdatepayment));?>" class="start form-control input-sm" style= "text-align: center;"/></td>
                                                      <td><input type="text" id="r_pinst" name="rpinst[]" value="<?php echo $rowr->agreementdetil_installmentpayment;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                      <td><input type="text" id="r_sdate" name="rsdate[]" value="<?php echo date('Y-m-d',strtotime($rowr->agreementdetil_startdate));?>" class="start form-control input-sm" /></td>
                                                      <td><input type="text" id="r_rinstm" name="rrinstm[]" value="<?php echo $rowr->agreementdetil_installment;?>" class="instm detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                      <td><input type="text" id="r_rinstd" name="rrinstd[]" value="<?php echo $rowr->agreementdetil_dayinstallment;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                      <td><input type="text" id="r_edate" name="redate[]" value="<?php echo date('Y-m-d',strtotime($rowr->agreementdetil_enddate));?>" class="end form-control input-sm" style= "text-align: center;"/></td>
                                                      <td><input type="text" id="r_int_'+ci+'" name="rint[]" value="<?php echo $rowr->agreementdetil_interval;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                      <td><?php echo form_dropdownext('rtitype[]',$titype, $rowr->timetype_id, 'id="r_time" class="detil form-control input-sm" required');?></td>
                                                      <td><input type="text" id="r_per_'+ci+'" name="rper[]" value="<?php echo $rowr->agreementdetil_percent;?>" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>
                                                      <td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "r_unit" name= "runit[]" required class="dropunit form-control input-sm" style="width: 100%;">
                                                          <option value="<?php echo $rowr->unit_id;?>" selected="selected" ><?php echo $rowr->unit_name;?></option>
                                                          </select></div><input type="hidden" id="r_una_" name="runa[]" value="<?php echo $rowr->agreementdetil_unit;?>" /></td>
                                                      <td><?php echo form_dropdownext('runitspot[]', $outdoor, $rowr->agreementdetil_unitspot, 'id="r_unitspot" class="detil form-control input-sm" required');?></td>
                                                      <td><input type="text" id="r_space" name="rspace[]" value="<?php echo $rowr->agreementdetil_space;?>" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>
                                                      <td><input type="checkbox" id="lump" <?php if ($rowr->agreementdetil_islumpsum == 1) echo 'checked= "checked"';?> >
                                                          <input type="hidden" id="r_lumpsum" name="rlumpsum[]" value = "<?php echo "$rowr->agreementdetil_islumpsum"; ?>"/></td>
                                                      <td><input type="text" id="r_base" name="rbase[]" value="<?php echo $rowr->agreementdetil_baserent;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                      <td><input type="text" id="r_mia" name="rmia[]" value="<?php echo $rowr->agreementdetil_mia;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                      <td><input type="text" id="r_vat" name="rvat[]" value="<?php echo $rowr->agreementdetil_tax;?>" class="form-control input-sm" style= "text-align: right;" /></td>
                                                      <td><input type="checkbox" id="aden" <?php if ($rowr->agreementdetil_isadendum == 1) echo 'checked= "checked"';?>>
                                                          <input type="hidden" id="r_adendum" name="radendum[]" value="<?php echo "$rowr->agreementdetil_isadendum"; ?>"/></td>
                                                      <td><input type="text" id="r_ninst" name="tninst[]" value="" class="form-control input-sm"/>
                                                      </td>
                                                      <td><input type="text" id="r_descr" name="rdescr[]" value="<?php echo $rowr->agreementdetil_descr;?>" class="pops form-control input-sm"/>
                                                      </td>
                                                      <td><a id= "btnDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
                                                      </tr>
                                                      <script>
                                                      //$('.bulet').number( true, 0 );                                                      
                                                      $('.start').datepicker();
                                                      $('.end').datepicker();
                                                      $('.instm').on('change keyup', function() {                                                        

                                                        var startDate = new Date($(this).closest('tr').find('input[type="text"]').eq(2).val())
                                                        var mTerm = parseInt($(this).val());

                                                        startDate.setMonth(startDate.getMonth() + mTerm);
                                                        startDate.setDate(startDate.getDate() + -1);

                                                        var dateFormated = startDate.toISOString().substr(0,10);

                                                        $(this).closest('tr').find('input[type="text"]').eq(5).val(dateFormated);

                                                      }); 
                                                      $('.dropunit').on("select2:select", function(e){
                                                        var uData = e.params.data;
     
                                                        $(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['text']);
                                                        
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
                                                    <td><input type="text" id="c_spdate" name="cspdate[]" value="<?php echo date('Y-m-d',strtotime($rowc->agreementdetil_startdatepayment));?>" class="start form-control input-sm" style= "text-align: center;"/></td>
                                                    <td><input type="text" id="c_pinst" name="cpinst[]" value="<?php echo $rowc->agreementdetil_installmentpayment;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                    <td><input type="text" id="c_sdate" name="csdate[]" value="<?php echo date('Y-m-d', strtotime($rowc->agreementdetil_startdate));?>" class="start form-control input-sm" /></td>
                                                    <td><input type="text" id="c_rinstm" name="crinstm[]" value="<?php echo $rowc->agreementdetil_installment;?>" class="instm detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                    <td><input type="text" id="c_rinstd" name="crinstd[]" value="<?php echo $rowc->agreementdetil_dayinstallment;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                    <td><input type="text" id="c_edate" name="cedate[]" value="<?php echo date('Y-m-d', strtotime($rowc->agreementdetil_enddate));?>" class="end form-control input-sm" style= "text-align: center;"/></td>
                                                    <td><input type="text" id="c_int" name="cint[]" value="<?php echo $rowc->agreementdetil_interval;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                    <td><?php echo form_dropdownext('ctitype[]',$titype, $rowc->timetype_id, 'id="c_time" class="detil form-control input-sm" required');?></td>
                                                    <td><input type="text" id="c_per" name="cper[]" value="<?php echo $rowc->agreementdetil_percent;?>" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>
                                                    <td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "c_unit" name= "cunit[]" required class="dropunit form-control input-sm" style="width: 100%;">
                                                        <option value="<?php echo $rowc->unit_id;?>" selected="selected" ><?php echo $rowc->unit_name;?></option>
                                                        </select></div><input type="hidden" id="c_una_" name="cuna[]" value="<?php echo $rowc->agreementdetil_unit;?>" /></td>
                                                    <td><?php echo form_dropdownext('cunitspot[]', $outdoor, $rowc->agreementdetil_unitspot, 'id="c_unitspot" class="detil form-control input-sm" required');?></td>
                                                    <td><input type="text" id="c_space" name="cspace[]" value="<?php echo $rowc->agreementdetil_space;?>" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>
                                                    <td><input type="checkbox" id="c_lump" <?php if ($rowc->agreementdetil_islumpsum == 1) echo 'checked= "checked"';?> >
                                                        <input type="hidden" id="c_lumpsum" name="clumpsum[]" value = "<?php echo "$rowc->agreementdetil_islumpsum"; ?>"/></td>
                                                    <td><input type="text" id="c_base" name="cbase[]" value="<?php echo $rowc->agreementdetil_baserent;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                    <td><input type="text" id="c_mia" name="cmia[]" value="<?php echo $rowc->agreementdetil_mia;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                    <td><input type="text" id="c_vat" name="cvat[]" value="<?php echo $rowc->agreementdetil_tax;?>" class="form-control input-sm" style= "text-align: right;" /></td>
                                                    <td><input type="checkbox" id="c_aden" <?php if ($rowc->agreementdetil_isadendum == 1) echo 'checked= "checked"';?>>
                                                        <input type="hidden" id="c_adendum" name="cadendum[]" value="<?php echo $rowc->agreementdetil_isadendum; ?>"/></td>
                                                    <td><input type="text" id="c_ninst" name="cninst[]" value="" class="form-control input-sm"/></td>
                                                    <td><input type="text" id="c_descr" name="cdescr[]" value="<?php echo $rowc->agreementdetil_descr;?>" class="pops form-control input-sm"/></td>
                                                    <td><a id= "btnDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
                                                    </tr>
                                                    <script>
                                                      $('.start').datepicker();
                                                      $('.end').datepicker();
                                                      $('.instm').on('change keyup', function() {                                                        

                                                        var startDate = new Date($(this).closest('tr').find('input[type="text"]').eq(2).val())
                                                        var mTerm = parseInt($(this).val());

                                                        startDate.setMonth(startDate.getMonth() + mTerm);
                                                        startDate.setDate(startDate.getDate() + -1);

                                                        var dateFormated = startDate.toISOString().substr(0,10);

                                                        $(this).closest('tr').find('input[type="text"]').eq(5).val(dateFormated);

                                                      }); 
                                                      $('.dropunit').on("select2:select", function(e){
                                                          var uData = e.params.data;
       
                                                          $(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['text']);
                                                          
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
                                                      <td><input type="text" id="d_sdate" name="dsdate[]" value="<?php echo date('Y-m-d', strtotime($rowd->agreementdeposit_startdate));?>" class="start form-control input-sm" /></td>
                                                      <td><input type="text" id="d_due" name="ddue[]" value="<?php echo $rowd->agreementdeposit_duedate;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                      <td><?php echo form_dropdownext('dtitype[]', $titype, $rowd->timetype_id, 'id="d_time" class="detil form-control input-sm" required');?></td>
                                                      <td><div class="form-group form-group-sm">
                                                          <select data-placeholder = "Select unit" id= "d_unit" name= "dunit[]" required class="dropunit form-control input-sm" style="width: 100%;">
                                                            <option value="<?php echo $rowd->unit_id;?>" selected="selected" ><?php echo $rowd->unit_name;?></option>
                                                          </select></div><input type="hidden" id="d_una" name="duna[]" value="<?php echo $rowd->unit_name;?>" /></td>
                                                      <td><input type="text" id="d_space" name="dspace[]" value="<?php echo $rowd->agreementdeposit_space;?>" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>
                                                      <td><input type="checkbox" id="d_lump" class="chkLump" <?php if ($rowd->agreementdeposit_islumpsum == 1) echo 'checked= "checked"';?> >
                                                          <input type="hidden" id="d_lumpsum" name="dlumpsum[]" value="<?php echo $rowd->agreementdeposit_islumpsum;?>"/></td>
                                                      <td><input type="text" id="d_base" name="dbase[]" value="<?php echo $rowd->agreementdeposit_idr;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                      <td><input type="text" id="d_mia" name="dmia[]" value="<?php echo $rowd->agreementdeposit_idrsubtotal;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                      <td><input type="text" id="d_vat" name="dvat[]" value="<?php echo $rowd->agreementdeposit_tax;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                      <td><a id= "dDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td> 
                                                      </tr>
                                                      <script>
                                                        $('.start').datepicker();
                                                        $('.dropunit').on("select2:select", function(e){
                                                            var uData = e.params.data;
         
                                                            $(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['text']);
                                                            
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
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Space</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Total IDR.</th>
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
                                                      <td><input type="text" id="l_sdate" name="lsdate" value="<?php echo $rowl->agreementdeposit_startdate;?>" class="tanggal form-control input-sm" /></td>
                                                      <td><input type="text" id="l_due" name="ldue[]" value="<?php echo $rowl->agreementdeposit_duedate;?>" class="detil bulet form-control input-sm" style= "text-align: center;"/></td>
                                                      <td><?php echo form_dropdownext('ltitype[]', $titype, $rowl->timetype_id, 'id="l_time" class="detil form-control input-sm" required');?></td>
                                                      <td><div class="form-group form-group-sm">
                                                          <select data-placeholder = "Select unit" id= "l_unit" name= "lunit[]" required class="dropunit form-control input-sm" style="width: 100%;">
                                                            <option value="<?php echo $rowd->unit_id;?>" selected="selected" ><?php echo $rowl->unit_name;?></option>
                                                          </select></div><input type="hidden" id="l_una" name="duna[]" value="<?php echo $rowl->unit_name;?>" /></td>
                                                      <td><input type="text" id="d_space" name="lspace[]" value="<?php echo $rowl->agreementdeposit_space;?>" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>
                                                      <td><input type="checkbox" id="lump" class="chkLump" <?php if ($rowl->agreementdeposit_islumpsum == 1) echo 'checked= "checked"';?> >
                                                          <input type="hidden" id="l_lumpsum" name="llumpsum[]" value="<?php echo $rowl->agreementdeposit_islumpsum;?>"/></td>
                                                      <td><input type="text" id="l_base" name="lbase[]" value="<?php echo $rowl->agreementdeposit_idr;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                      <td><input type="text" id="l_mia" name="lmia[]" value="<?php echo $rowl->agreementdeposit_idrsubtotal;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                      <td><input type="text" id="l_vat" name="lvat[]" value="<?php echo $rowl->agreementdeposit_tax;?>" class="detil bulet form-control input-sm" style= "text-align: right;" /></td>
                                                      <td><a id= "dDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td> 
                                                      </tr>
                                                      <script>
                                                        $('.dropunit').on("select2:select", function(e){
                                                            var uData = e.params.data;
         
                                                            $(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['text']);
                                                            
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
                                                 <input type="text" id= "agreement_createby" name="agreement_createby" class="form-control input-sm" value="<?php echo $row->agreement_createby;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Create Date</label>
                                                 <input type="text" id="agreement_createdate" name="agreement_createdate" class="form-control input-sm" value="<?php echo $row->agreement_createdate;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Modify By</label>
                                                 <input type="text" id= "agreement_modifyby"  name="agreement_modifyby" class="form-control input-sm" value="<?php echo $row->agreement_modifyby;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Modify Date</label>
                                                 <input type="text" id="agreement_modifydate" name="agreement_modifydate" class="form-control input-sm" value="<?php echo $row->agreement_modifydate;?>">
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
