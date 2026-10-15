<script>




$(document).ready(function(){

  var uRows = $('#unittab tbody >tr');
  var uColumns;
  var listunit=[];
  var Region, Branch;

  for (var i = 0; i < uRows.length; i++) {

      uColumns = $(uRows[i]).find('td');

      Region  = $(uRows[i]).find('input[type="hidden"]').eq(4).val();
      Branch  = $(uRows[i]).find('input[type="hidden"]').eq(5).val();   
      Tenant  = $(uRows[i]).find('input[type="hidden"]').eq(6).val();
      Brand   = $(uRows[i]).find('input[type="hidden"]').eq(7).val();

      listunit.push({id: $(uColumns[1]).text(), text: $(uColumns[2]).text(), region: Region, branch: Branch, tenant: Tenant, brand: Brand});
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

  $('.dropunit').select2(unitOptions);

  $('.dropunit').on("select2:select", function(e){
      var uData = e.params.data;
      
      $(this).closest('tr').find('input[type="hidden"]').eq(2).val(uData['region']);
      $(this).closest('tr').find('input[type="hidden"]').eq(3).val(uData['branch']);
      $(this).closest('tr').find('input[type="hidden"]').eq(4).val(uData['tenant']);
      $(this).closest('tr').find('input[type="hidden"]').eq(5).val(uData['brand']);
      
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
  
  $('#iutype').on("select2:select", function(e){

    var utype = e.params.data;  
    var type = '';
    var lease = 0;
    
      
    type = (utype.id === '5') ? "CASUAL" : "PERMANENT";
    lease = (utype.id === '5') ?  1 : 0;

    $('#hlease').val(lease);

    agrTypeFilter = agrType.filter(function (data) { return data.type == type });

    $('.dropadd').empty();

  });

  $('.dropadd').select2(leasetype);           

  $('#iregion').select2({placeholder: 'Select a business unit'});    
  $('#ilease').select2({placeholder: 'Choose lease agreement.. '});
  $('#iutype').select2({placeholder: 'Choose Schema ..'});    

  $('#ibranch').select2({
      placeholder: 'Select an option',
      minimumInputLength: 2,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('loo/loo/branch_select')?>',
          dataType: 'json',
          type: "GET",
          data: function (term, region) {
              return {
                  term: term,
                  region: $("#iregion").val()
              };
          },
          processResults: function (data) {
              return {
                  results: $.map(data.items, function (item) {

                        //console.log(data.items);
                      return {                        

                          text: item.branch_name,
                          //slug: item.slug,
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

  $("#tabedit").trigger('click');

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

  $('#btTemplate').click(function() {
 if (($('#iregion option:selected').length == 0) || ($('#ibranch').val() =='') || ($('#iutype').val() ==null)) { 

	alert("Please select Bussiness Unit and Store and Unit Type");
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
	alert("Please select Bussiness Unit or Store");
}else{
    var activetab = $('.detil .active').text();

    switch(activetab) {

        case 'Terms':        

            addRow();
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
    alert('Please, select data from list');
  });       

  $('#btdialog').click(function () { 

      var linenum=0;
      var oData = oTable.rows('.selected').data();        

       for (var i=0; i < oData.length; i++){
        
          var rid=oData[i][0];
          var runit=oData[i][1];
          var rsize=oData[i][2];
          var nlantai=oData[i][3];    
          var rlantai=oData[i][4];           
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

  });  

  $('#addtenant').click(function () { 

      var linenum=0;
      var rData = rTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){
        
          var tid     = rData[i][0];
          var tname   = rData[i][1];
          var tline   = rData[i][2];
          var tbrand   = rData[i][3];  

          $('#htenant').val(tid);
          $('#itenant').val(tname);
          $('#hbrand').val(tline);
          $('#ibrand').val(tbrand);           
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
        '<td><select data-placeholder = "Select unit" id= "unit_id" name= "tunit[]" required class="dropunit form-control input-sm" style="width: 100%;">'+        
            '</select></td>'+
        '<td><select data-placeholder = "Select an option" id= "'+ci+'" name= "tatype[]" required class="dropadd form-control input-sm" style="width: 100%;">'+
            '</select></td>'+
        '<td><input type="text" id="chg_'+ci+'" name="tcharge[]" value="0" class="deci form-control input-sm" style= "text-align: right;"/></td>'+ 
        '<td><input type="checkbox" id="chk_'+ci+'"><input type="hidden" id="cper_'+ci+'" name="tper[]" value="0"/></td>'+
        '<td><input type="text" id= "per_'+ci+'" name="tval[]" value="0" class="deci form-control input-sm" style= "text-align: right;" readonly/></td>'+
        '<td><input type="text" name="tint[]" value="0" class="form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><?php echo form_dropdownext('titype[]',$titype,$this->input->post('titype'),'id="titype" class="form-control input-sm" required');?></td>'+
        '<td><input type="text" id= "des_'+ci+'" name="tdescr[]" value="" class="pops form-control input-sm"/>'+
        '<input type="hidden" id= "dRegion" name="dRegion[]" value="" class="form-control input-sm"/>'+
        '<input type="hidden" id= "dBranch" name="dBranch[]" value="" class="form-control input-sm"/>'+
        '<input type="hidden" id= "dTenant" name="dTenant[]" value="" class="form-control input-sm"/>'+
        '<input type="hidden" id= "dBrand" name="dBrand[]" value="" class="form-control input-sm"/>'+
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
     $("#modal-default").modal("show");
     $('.modal-title').show().html(title);
     $('.modal-body').show().html(message);
  }  
  //$('#tdescr').popover();
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

 
});


$(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );

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
}

.nowrap {
        white-space:nowrap;
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

      <div class="modal fade" id="modal-default">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Attention!</h4>
              </div>
              <div class="modal-body">
                <p>Data has been saved.&hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default center-block" data-dismiss="modal">Close</button>                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>  

        <div class="modal fade" id="mdldialog" tabindex="-1" role="basic" aria-hidden="true">
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
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">IDL</th>
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
                              <input type="button" id="btnrek" value = "LOAD" class="btn btn-sm btn-info"/>
                            </div>
                          </div>
                            <div class="portlet-body">
                              <div class="table-container">
                                <div class="table-scrollable">
                                  <table class="table table-striped table-bordered table-hover nowrap compact" id='popLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                                    <thead>
                                     <tr>
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Brand</th>
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
                          <a href="<?php echo base_url('index.php/loo/loo/looadd'); ?>" id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata" data-toggle="tab" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        
                        <div class="tab-pane" id="editdata">
                          <div class="portlet-body form">
                         <form id="myForm" action="<?php echo site_url('loi/loi/loi_edit');?>" method="post" onsubmit="return validateb4submit();">
                            <?php 
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>                                   
                    <div class="row">
                        <div class="col-md-12">   
                                <div class="col-md-4 form-group row">                               
                                  <div class="col-xs-12">
                                      <label>Agreement ID</label>
                                    <input  type="text" id="agreement_id" name="agreement_id" class="form-control input-sm" value="<?php echo $row->agreement_id;?>" readonly />
                                  </div> 
                                </div>                                    
                                 
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Start Date</label>                                       
                                      <input type="text" class="form-control input-sm pull-right" id="startdate" name="startdate" value = "<?php echo $row->startdate;?>" readonly>    
                                      </div>                                                                       
                                </div>
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>End Date</label>                                        
                                      <input type="text" class="form-control input-sm pull-right" id="enddate" name="enddate" value = "<?php echo $row->enddate;?>" readonly>    
                                  </div>                                                                     
                                </div>   
                                
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>LOI Number</label>   
                                      <input type="text" class="form-control input-sm pull-right" id="number" name="number" value = "<?php echo $row->number;?>" readonly>    
                                  </div>                                                                       
                                </div>
                                                                                                                               
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Store</label>   
                                      <input type="text" class="form-control input-sm pull-right" id="branch_area" name="branch_area" value = "<?php echo $row->branch_area;?>" readonly>    
                                  </div>                                                                       
                                </div>                                 
                               
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Shope Name</label>
                                    <input type="text" id = "toko" name="toko" class="form-control input-sm" value="<?php echo $row->toko;?>"readonly>
                                  </div>
                                </div>  
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Tenant</label>
                                    <input type="text" id = "rekanan_pt" name="rekanan_pt" class="form-control input-sm" value="<?php echo $row->rekanan_pt;?>"readonly>
                                  </div>
                                </div>    
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>To</label>
                                      <input type="text" class="form-control input-sm pull-right" id="kepada" name="kepada" value = "<?php echo $row->kepada;?>">    
                                  </div>
                                </div>                                  
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Email</label>
                                    <input type="text" id = "email" name="email" class="form-control input-sm" value="<?php echo $row->email;?>">
                                  </div>
                                </div>                                                                                                
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Phone</label>
                                    <input type="text" id = "mobile" name="mobile" class="form-control input-sm" value="<?php echo $row->mobile;?>">
                                  </div>
                                </div> 
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Location/Floor</label>
                                    <input type="text" id = "lantai" name="lantai" class="form-control input-sm" value="<?php echo $row->lantai;?>">
                                  </div>
                                </div>
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Unit</label>
                                    <input type="text" id = "unit" name="unit" class="form-control input-sm" value="<?php echo $row->unit;?>"readonly>
                                  </div>
                                </div>    
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Space</label>
                                    <input type="text" id = "luas" name="luas" class="form-control input-sm" value="<?php echo $row->luas;?>"readonly>
                                  </div>
                                </div>    
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Fitting Out</label>
                                    <input type="text" id = "fitting_out" name="fitting_out" class="form-control input-sm" value="<?php echo $row->fitting_out;?>"readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Grace Periode</label>
                                    <input type="text" id = "grace_periode" name="grace_periode" class="form-control input-sm" value="<?php echo $row->grace_periode;?>"readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Product Name</label>
                                    <input type="text" id = "dagangan" name="dagangan" class="form-control input-sm" value="<?php echo $row->dagangan;?>">
                                  </div>
                                </div>                                
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Size Indoor</label>
                                    <input type="text" id = "size_indoor" name="size_indoor" class="form-control input-sm" value="<?php echo $row->size_indoor;?>"readonly>
                                  </div>
                                </div>                                                                                                                                                                                              <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Size Outdoor</label>
                                    <input type="text" id = "size_outdoor" name="size_outdoor" class="form-control input-sm" value="<?php echo $row->size_outdoor;?>"readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Utilities (Listrik,Air,Gas)</label>
                                    <input type="text" id = "Utilities" name="Utilities" class="form-control input-sm" value="<?php echo $row->Utilities;?>">
                                  </div>
                                </div>       
                                                                                      
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Electricity Cost</label>
                                    <input type="text" id = "biaya_listrik" name="biaya_listrik" class="form-control input-sm" value="<?php echo $row->biaya_listrik;?>">
                                  </div>
                                </div>                                  

                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Service Charge</label>
                                    <input type="text" id = "biaya_service" name="biaya_service" class="form-control input-sm" value="<?php echo $row->biaya_service;?>">
                                  </div>
                                </div> 
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Deposit QTY</label>
                                    <input type="text" id = "jml_deposit" name="jml_deposit" class="form-control input-sm" value="<?php echo $row->jml_deposit;?>">
                                  </div>
                                </div> 
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Deposit Amount</label>
                                    <input type="text" id = "deposit_value" name="deposit_value" class="form-control input-sm" value="<?php echo $row->deposit_value;?>">
                                  </div>
                                </div>                                
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Deposit Installment</label>
                                    <input type="text" id = "angsuran_deposit" name="angsuran_deposit" class="form-control input-sm" value="<?php echo $row->angsuran_deposit;?>">
                                  </div>
                                </div>                                
                                
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Deposit Installment Amount</label>
                                    <input type="text" id = "angsuran_deposit1" name="angsuran_deposit1" class="form-control input-sm" value="<?php echo $row->angsuran_deposit1;?>">
                                  </div>
                                </div>
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Telp Deposit</label>
                                    <input type="text" id = "telp_deposit" name="telp_deposit" class="form-control input-sm" value="<?php echo $row->telp_deposit;?>">
                                  </div>
                                </div>                                
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Telp Service</label>
                                    <input type="text" id = "telp_service" name="telp_service" class="form-control input-sm" value="<?php echo $row->telp_service;?>">
                                  </div>
                                </div>                                                                                                 
                                <div class="col-md-12 form-group row">
                                  <div class="col-xs-12">
                                      <label>Address</label>
                                      <textarea id = "alamat" name="alamat" class="form-control input-sm" required rows="2" ><?php echo $row->alamat;?></textarea> 
                                  </div>
                                </div>
                                    <!-- /.col -->
                                <div class="col-xs-12">
                                    <br /><input type="submit" value="SUBMIT" class="submit btn btn-sm btn-info" />
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