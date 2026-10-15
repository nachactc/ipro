
<script>

function validateb4submit(){
  var max=GetDgvLineMaxNum('looDetil',0);
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

  var uRows = $('#unittab tbody >tr');
  var uColumns;
  var listunit=[];
  var Region;

  for (var i = 0; i < uRows.length; i++) {

      uColumns = $(uRows[i]).find('td');

      Region = $(uRows[i]).find('input[type="hidden"]').eq(4).val();
      
      listunit.push({id: $(uColumns[1]).text(), text: $(uColumns[2]).text(), region: 0, branch: 0 });
  }

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

  $('.dropunit').select2();

  $('.dropunit').on("select2:select", function(e){
      var uData = e.params.data;

      //$('#dRegion').val(uData['region']);
      $(this).closest('tr').find('input[type="hidden"]').eq(2).val(uData['region']);
      $(this).closest('tr').find('input[type="hidden"]').eq(3).val(uData['branch']);
      
  });

  if ($('input[type=checkbox]').attr('checked')){

    $('.submit').prop('disabled',true);

  }else{

    $('.submit').prop("disabled", false);

  }


  var agrTypeFilter=[]; 
  var agrType=[]; 

  function getAgreementtype (){
     var ajax = $.get('<?php echo site_url('loo/loo/agrtype_selecttype')?>', function(data){
       //do something with data here               
     }, 'json');
     return ajax;
  }
     
  getAgreementtype().done(function(results){

    var lease_id = 0;    
    var type = '';

      agrType = results.data;

      type = (lease_id === '0') ? "PERMANENT" : "CASUAL";

      agrTypeFilter = agrType.filter(function (data) { return data.type == type });           

  });


  leasetype = {
    ajax: {
      transport: function(params, success, failure) {

      items = agrTypeFilter;

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

  $('.dropadd').select2(leasetype);  

  $('#iregion').val([]);  
  $('#iutype').val([]);
  $('#lootype').val([]);

  $('#iregion').select2({placeholder: 'Select a business unit'});  
  $('#iutype').select2({placeholder: 'Choose unit ..'});
  $('#lootype').select2({placeholder: 'Choose transaction ..'});

  $('#lootype').on("select2:select", function(e){

    var utype = e.params.data;  
    var type = '';
    var lease = 0;
    
      
    type = (utype.id === '5') ? "CASUAL" : "PERMANENT";
    lease = (utype.id === '5') ?  1 : 0;

    $('#hlease').val(lease);

    agrTypeFilter = agrType.filter(function (data) { return data.type == type });

    $('.dropadd').empty();

  });

  $('#ibranch').on('select2:select', function (e) {
    var bra = e.params.data;    

    $('#iregion').val(bra.region).trigger('change');      

    $('#cboregion').val(bra.region);
        
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
	var oTable=popgrid("<?php echo site_url('loo/loo/controler_griddialog')?>","uLoader","trp", 10);

  var rTable=popgrid("<?php echo site_url('loo/loo/controler_gridpop')?>","popLoader","trp", 10);

  var scTable=popgrid("<?php echo site_url('loo/loo/controler_gridschema')?>","scLoader","trp", 10);

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
    rTable.rows('.selected').deselect();
    $("#tedialog").modal("show");
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

        case 'Terms':
            addRow();

            if (typeof listunit !== 'undefined' && listunit.length > 0) {

              $('.dropunit').append(new Option(listunit[0]['text'], listunit[0]['id'], false, false)).trigger('change');
              $('.dReg').val($("#iregion").val());
              $('.dBra').val($("#ibranch").val());
              $('.dTen').val($("#htenant").val());
              $('.dBran').val($("#hbrand").val());

            }
            break;

        case 'Unit':
            var searchBranch = $("#ibranch").val();
            var searchRegion  = $("#iregion").val();

            oTable.search('');      
            oTable.column(1).search(searchRegion);
            oTable.column(2).search(searchBranch);
            oTable.draw();
            oTable.rows('.selected').deselect();
            $("#mdldialog").modal("show");
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

  $("#looDetil").on('click','#btnDelete',function(){
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


  $.fn.datepicker.defaults.format = "yyyy-mm-dd";
  $.fn.datepicker.defaults.autoclose = true;

  function addRow(ci) {

      var linenum=0;
      var lease_id = $('#ilease').val();

      var max=GetDgvLineMaxNum('looDetil',0)
      linenum= Number(max) + 10;

      $('#looDetil tbody').append('<tr>'+
        '<td>' + linenum + '<input type="hidden" name="tline[]" value="'+ linenum +'" readonly class="nogaris"/></td>'+
        '<td><div class="form-group form-group-sm"><select data-placeholder = "Select unit" id= "unit_id" name= "tunit[]" required class="dropunit form-control input-sm" style="width: 100%;">'+
            '</select></div></td>'+
        '<td><div class="form-group form-group-sm"><select data-placeholder = "Select an option" id= "ag_'+ci+'" name= "tatype[]" required class="dropadd form-control input-sm" style="width: 100%;">'+
            '</select></div></td>'+
        '<td><input type="text" id="chg_'+ci+'" name="tcharge[]" value="0" class="deci form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><input type="checkbox" id="chk_'+ci+'"><input type="hidden" id="cper_'+ci+'" name="tper[]" value="0"/></td>'+
        '<td><input type="text" id= "per_'+ci+'" name="tval[]" value="0" class="deci form-control input-sm" style= "text-align: right;" readonly/></td>'+
        '<td><input type="text" id="int_'+ci+'" name="tint[]" value="0" class="form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><?php echo form_dropdownext('titype[]',$titype,$this->input->post('titype'), 'id="tit_\'+ci+\'" class="form-control input-sm" required');?></td>'+
        '<td><input type="text" id= "des_'+ci+'" name="tdescr[]" value="" class="pops form-control input-sm"/>'+
        '<input type="hidden" id= "dRegion" name="dRegion[]" value="" class="dReg form-control input-sm"/>'+
        '<input type="hidden" id= "dBranch" name="dBranch[]" value="" class="dBra form-control input-sm"/>'+
        '<input type="hidden" id= "dTenant" name="dTenant[]" value="" class="dTen form-control input-sm"/>'+
        '<input type="hidden" id= "dBrand" name="dBrand[]" value="" class="dBran form-control input-sm"/>'+
        '</td>'+
        '<td><a id= "btnDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');

      $('.deci').number( true, 2 );

      $('.dropunit').select2(unitOptions);
      $('.dropadd').select2(leasetype);

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
        
        $(this).closest('tr').find('input[type="hidden"]').eq(2).val(uData['region']);
        $(this).closest('tr').find('input[type="hidden"]').eq(3).val(uData['branch']);
        $(this).closest('tr').find('input[type="hidden"]').eq(4).val(uData['tenant']);
        $(this).closest('tr').find('input[type="hidden"]').eq(5).val(uData['brand']);
        
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

});

$(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );

/*
function get_va(debt_no){

  var va = "";
  var codeReg = "";
  var codeVA = "";
  var codeVA2 = "";
  var lendebtor = 0;
  var codeStore = "";

  if (debt_no != '') {

    codeReg = debt_no.substr(0, 1);    

    switch(codeReg){

      case "C": codeVA = "7801"; codeVA2 = "1"; break;
      case "A": codeVA = "7802"; codeVA2 = "2"; break;
      case "P": codeVA = "7821"; codeVA2 = "4"; break;
      case "G": codeVA = "7801"; codeVA2 = "1"; break;
      case "T": codeVA = "7831"; codeVA2 = "1"; break;
    }    

    if (debt_no.length >= 12) {
      lendebtor = 3;

    } else {
      lendebtor = 2;
    }    

    codeStore = debt_no.substr(strpos(debt_no, "-" ) +1, lendebtor);    

    if (codeStore.length == 2) {

      codeStore = "0" + codeStore;
    }

    codeDebtor = "0" + debt_no.substr(1, 7);

    va = codeVA+codeStore+codeVA2+codeDebtor;    
  }

  return va;
}

function strpos (haystack, needle, offset) {
  var i = (haystack+'').indexOf(needle, (offset || 0));
  return i === -1 ? false : i;
}

*/


</script>

<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

.table td{
    padding:2px;
    font-size: 9pt;
    font-family:  Arial, Verdana, sans-serif;

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
                          <a href="<?php echo base_url('index.php/loo/loo/loolist'); ?>" id='tablist'> LIST </a>
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
                         <form action="<?php echo site_url('loo/loo/loo_add');?>" method="post" onsubmit="return validateb4submit();">
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
                                      <input  type="text" id="looid" name="loo_id" class="form-control input-sm" value="<?php echo $row->loo_id;?>" readonly>
                                    </div>
                                  </div>
                                  <!-- /.form group -->
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Date</label>
                                      <div class="input-group date">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                          <input type="text" class="form-control input-sm pull-right" id="loo_date" name="loo_date" value = "<?php echo $row->loo_date;?>" readonly>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Term Period</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="<?php echo $row->loo_term;?>" readonly>
                                    </div>
                                  </div>  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Start Date</label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="loo_sdate" name="loo_sdate" value = "<?php echo $row->loo_sdate;?>">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>End Date</label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="loo_edate" name="loo_edate" value = "<?php echo $row->loo_edate;?>">
                                      </div>
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
                                      <label>Transaction</label>
                                          <?php echo form_dropdown('cbolootype',$lotype,'','id ="lootype" class="form-control" style="width: 100%;" required'); ?>
                                    </div>
                                  </div>  						                 
                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                      <label>Unit Type</label>
                                          <?php echo form_dropdown('cbounittype',$unittype,'','id ="iutype" class="form-control" style="width: 100%;" required'); ?>
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
                                        <label>Debtor No.</label>
                                        <input type="text" id = "idebtor" name="idebtor" class="form-control input-sm" value="" readonly required autocomplete="off">
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
                                      <label>Fitting Out</label>
                                        <input data-placeholder="Fitting Out (Angka)" type="text" id = "fitting_out" name="fitting_out" class="form-control input-sm" value="0">
                                    </div>
                                  </div>
								                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Grace Period</label>
                                        <input data-placeholder="Grace Period (Angka)" type="text" id = "grace_period" name="grace_period" class="form-control input-sm" value="0">
                                    </div>
                                  </div>
								                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Size Indoor</label>
                                        <input data-placeholder="Size Indoor (Angka)" type="text" id = "size_indoor" name="size_indoor" class="form-control input-sm" value="0">
                                    </div>
                                  </div>
								                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Size Outdoor</label>
                                        <input data-placeholder="Size Outdoor (Angka)" type="text" id = "size_outdoor" name="size_outdoor" class="form-control input-sm" value="0">
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
                                      <label class="checkbox-inline"><input type="checkbox" disabled>Returned</label>
                                      <label class="checkbox-inline"><input type="checkbox" disabled>Approved</label>
                                   </div>
                                  </div>
                                  <div class="col-md-12 form-group row">
                                    <div class="col-xs-12">
                                        <label>Description:</label>
                                        <input type="hidden" id = "skl_id" name="skl_id" value="">
                                        <textarea id = "loo_descr" name="loo_descr" class="form-control input-sm" required rows="2" ></textarea>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <a href="javascript:void(0)" id="btTemplate"><strong>Add Template </strong></a> ||
                                    <a href="/index.php/simpay/simpay/sim_view" id="btSim" target="_blank"><strong>Simulation</strong></a>
                                  <br>
                                  <br>
                                    <a href="javascript:void(0)" id="btdetil"><strong>Add Row</strong></a>
                                      <!-- Custom Tabs -->
                                      <div class="nav-tabs-custom">
                                        <ul class="detil nav nav-tabs">
                                          <li class="active"><a href="#tab_1" data-toggle="tab" role= "tab">Terms</a></li>
                                          <li><a href="#tab_2" data-toggle="tab" role = "tab">Unit</a></li>
                                          <li><a href="#tab_3" data-toggle="tab" role = "tab">Record</a></li>
                                        </ul>
                                        <div class="tab-content">
                                          <div class="tab-pane active" id="tab_1">
                                            <div class ="table-responsive">                                             
                                              <table class="table table-bordered table-striped" id='looDetil' style="border:solid 1px #999; #999; border-radius:0px;">
                                                <thead>
                                                  <tr>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Unit</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Term & Condition</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Charge</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">(%)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Val</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Int.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Time</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Descr</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Delete</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <?php if(isset($resultd)){
                                                      foreach($resultd as $rowd){
                                                  ?>
                                                    <tr>
                                                    <td><?php echo "$rowd->loodetil_line";?><input type="hidden" name="tline[]" value="<?php echo "$rowd->loodetil_line";?>"/></td>
                                                    <td>
                                                      <select data-placeholder="Choose Unit" id= "unit_id" name= "tunit[]" required class="dropunit form-control input-sm" style="width: 100%;">
                                                        <option value="<?php echo $rowd->unit_id;?>" selected="selected" ><?php echo $rowd->unit_name;?></option>
                                                      </select>
                                                    </td>
                                                    <td>
                                                      <select data-placeholder="Select an option .." id= "tatype" name= "tatype[]" required class="dropadd form-control input-sm" style="width: 100%;">
                                                        <option value="<?php echo $rowd->agreementtype_id;?>" selected="selected" ><?php echo $rowd->agreementtype_name;?></option>
                                                      </select>
                                                    </td>
                                                    <td><input type="text" name="tcharge[]" value="<?php echo "$rowd->loodetil_baserent";?>" class="deci form-control input-sm" style= "text-align: right;" <?php if ($rowd->loodetil_ispercent) echo 'readonly'; ?> /></td>
                                                    <td><input type="checkbox" id="" <?php if ($rowd->loodetil_ispercent == 1) echo 'checked= "checked"';?> >
                                                      <input type="hidden" name="tper[]" value = "<?php echo "$rowd->loodetil_ispercent"; ?>" /></td>
                                                    <td><input type="text" name="tval[]" value="<?php echo "$rowd->loodetil_percent";?>" class="deci form-control input-sm" style= "text-align: right;" <?php if (!($rowd->loodetil_ispercent)) echo 'readonly'; ?> /></td>
                                                    <td><input type="text" name="tint[]" value="<?php echo "$rowd->loodetil_int";?>" class="form-control input-sm" style= "text-align: right;" /></td>
                                                    <td><?php echo form_dropdownext('titype[]',$titype,"$rowd->timetype_id",'id="titype" class="form-control input-sm" required');?></td>
                                                    <td><input type="text" name="tdescr[]" value="<?php echo "$rowd->loodetil_descr";?>" class="form-control input-sm"/></td>
                                                    <td><a id= "btnDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
                                                    </tr>
                                                    <script>
                                                    $('.deci').number( true, 2 );
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
                                              <table class="table table-bordered table-striped" id='unittab' style="border:solid 1px #999; #999; border-radius:0px;">
                                                <thead>
                                                  <tr>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Unit</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">SQM ( M2 )</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Floor</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Delete</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                   <?php if(isset($resultu)){
                                                        foreach($resultu as $rowd){
                                                    ?>
                                                      <tr>
                                                      <td><?php echo $rowd->loounit_line;?><input type="hidden" name="uline[]" value="<?php echo "$rowd->loounit_line";?>"/></td>
                                                      <td><?php echo $rowd->unit_id;?><input type="hidden" name="uunit[]" value="<?php echo "$rowd->unit_id";?>" /></td>
                                                      <td><?php echo $rowd->unit_name;?></td>
                                                      <td><?php echo $rowd->loounit_space;?><input type="hidden" name="usize[]" value="<?php echo "$rowd->loounit_space";?>"/></td>
                                                      <td><?php echo $rowd->lantai_name;?><input type="hidden" name="ulantai[]" value="<?php echo "$rowd->lantai_id";?>"/></td>
                                                      <td><a id= "uDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
                                                      </tr>
                                                    <?php
                                                       }
                                                     }
                                                   ?>
                                                </tbody>
                                              </table>
                                             </div>
                                            </div>
                                          <div class="tab-pane" id="tab_3">
                                            <div class="row">
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Create By</label>
                                                 <input type="text" id= "_createby" name="_createby" class="form-control" value="<?php echo $row->_createby;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Create Date</label>
                                                 <input type="text" name="_createdate" class="form-control " value="<?php echo $row->_createdate;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Modify By</label>
                                                 <input type="text" id= "_modifyby"  name="_modifyby" class="form-control " value="<?php echo $row->_modifyby;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Modify Date</label>
                                                 <input type="text" name="_modifydate" class="form-control" value="<?php echo $row->_modifydate;?>">
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
