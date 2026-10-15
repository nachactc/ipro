<script>

function validateb4submit(){
  var max=GetDgvLineMaxNum('looDetil',0);
  if (max < 1 ){
    alert('Please, Add Term & Condition !');
    return false;
  }
}

$(document).ready(function(){

  $('#ilease').on("select2:select", function(e){

    var lease = e.params.data;

    $.get("<?php echo site_url('loo/loo/agrtype_selecttype'); ?>",
          'lootype= '+lease.id, 
          function(d){
              var agrType = $.map(d, function (obj) {
                  obj.id = obj.id;
                  obj.text = obj.text
                  return obj;
              });

              
              $('.dropadd').empty();    

              $('.dropadd').select2({ 
                  placeholder: "Choose agreement leasing",                  
                  data: agrType,
                  sorter: function(data) {
                      return data.sort(function (a, b) {
                          if (a.text > b.text) {
                              return 1;
                          }
                          if (a.text < b.text) {
                              return -1;
                          }
                          return 0;
                      });
                  }
              });              
    }, 'json' );

  });

  $(".dropadd").select2();
 
  $('#iregion').val([]);
  $('#ilease').val([]);

  $('#iregion').select2({placeholder: 'Select a business unit'});
  $('#ilease').select2({placeholder: 'Choose lease agreement.. '});

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
              };
          },
          processResults: function (data) {
              return {
                  results: $.map(data.items, function (item) {

                        console.log(data.items);
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

	var arrid= [];
	//lfrtip =default
	var oTable=listgrid("<?php echo site_url('loo/loo/controler_griddialog')?>","uLoader","trp", 7);

  var rTable=listgrid("<?php echo site_url('loo/loo/controler_gridpop')?>","popLoader","trp", 6);

  $('#btnload').click( function() {    
      var searchName = $("#sUnitName").val();              
      var searchID  = $("#sID").val();

      oTable.search(searchName).draw();
     oTable.search(searchID).draw();
  });
	 
		
	$("#tabdata").trigger('click');

  $('#bttenant').click(function() {    
    rTable.rows('.selected').deselect();
    $("#tedialog").modal("show");
  });

  $('#btdetil').click(function() {
    oTable.rows('.selected').deselect();
    $("#mdldialog").modal("show");
  });  
	
	$('#tabedit').click(function() {
		alert('Please, select data from list');
	});			  

  $('#btdialog').click(function () { 

       var linenum=0;
       var oData = oTable.rows('.selected').data();
       var lease_id = $('#ilease').val();

       $('.dropadd').removeClass('dropnew'); 

       for (var i=0; i < oData.length ;i++){
        
          var rid=oData[i][0];
          var runit=oData[i][1];
          var rsize=oData[i][2];
          var rlantai=oData[i][3];          
           
          var max=GetDgvLineMaxNum('looDetil',0)
          linenum= Number(max) + 10;
          var t="tcharge"+linenum;          

          $('#looDetil tbody').append('<tr>'+
            '<td>' + linenum + '<input type="hidden" name="tline[]" value="'+ linenum +'" readonly class="nogaris"/></td>'+
            '<td>'+ runit +'<input type="hidden" name="tunit[]" value="'+ rid +'" readonly class="nogaris"/></td>'+
            '<td>'+ rsize +'<input type="hidden" name="tsize[]" value="'+ rsize +'" readonly class="nogaris"/></td>'+           
            '<td><select data-placeholder="Choose agreement leasing" id= "tatype" name= "tatype[]" required class="dropadd dropnew form-control input-sm" style="width: 100%;">'+
                '</select></td>'+
            '<td><input type="text" name="tcharge[]" id= "'+ t +'" value="0" class="form-control input-sm" style= "text-align: right;" /></td>'+ 
            '<td><input type="text" name="tint[]" value="0" class="form-control input-sm" style= "text-align: right;" /></td>'+
            '<td><?php echo form_dropdownext('titype[]',$titype,$this->input->post('titype'),'id="titype" class="form-control input-sm" required');?></td>'+
            '<td><input type="text" name="tdescr[]" value="" class="form-control input-sm"/></td>'+
            '<td><a id= "btnDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');

          $('#'+t).number( true, 2 );
              //arrid.push(vid);

          $.get("<?php echo site_url('loo/loo/agrtype_selecttype'); ?>",
              'lootype= '+lease_id, 
              function(d){
                  var agrType = $.map(d, function (obj) {
                      obj.id = obj.id;
                      obj.text = obj.text
                      return obj;
                  });

                  $('.dropnew').empty();

                  $('.dropnew').select2({
                      data: agrType,
                      sorter: function(data) {
                          return data.sort(function (a, b) {
                              if (a.text > b.text) {
                                  return 1;
                              }
                              if (a.text < b.text) {
                                  return -1;
                              }
                              return 0;
                          });
                      }
                  });              
          }, 'json' );
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

  $("#looDetil").on('click','#btnDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }
      $(this).closest('tr').remove();  
  });  
 
  
  $.fn.datepicker.defaults.format = "yyyy-mm-dd"; 
  $.fn.datepicker.defaults.autoclose = true;
    

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


</style>

 <div class="modal fade" id="modal-default">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Success!</h4>
              </div>
              <div class="modal-body">
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
                       <label>ID</label>
                      <input  type="text" id="sID" class="form-control" placeholder="Search Unit" >
                    </div>
                    <div class="col-md-4">
                      <label>Unit</label>
                      <input  type="text" id="sUnitName" class="form-control" placeholder="Search ID" >
                    </div>
                    <div class="col-md-4" align="right">
                      <br>
                      <input type="button" id="btnload" value = "LOAD" class="btn btn-sm btn-info"/>
                    </div>  
              </div>

                           <div class="portlet-body">
                            <div class="table-container">
                            <table class="table table-striped table-bordered table-hover" id='uLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
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
                            <div class="col-md-4">
                               <label>ID</label>
                              <input  type="text" id="sID" class="form-control input-sm" placeholder="Search ID" >
                            </div>
                            <div class="col-md-4">
                              <label>Name</label>
                              <input  type="text" id="sName" class="form-control input-sm" placeholder="Search Name" >
                            </div>
                            <div class="col-md-4" align="right">
                              <br>
                              <input type="button" id="btnpop" value = "LOAD" class="btn btn-sm btn-info"/>
                            </div>  
                          </div>
                           <div class="portlet-body">
                            <div class="table-container">
                              <div class="table-scrollable">
                                <table class="table table-striped table-bordered table-hover" id='popLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
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
                                      <div class="input-group date" data-provide="datepicker">                                                    
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div> 
                                          <input type="text" class="form-control input-sm pull-right" id="loo_date" name="loo_date" value = "<?php echo $row->loo_date;?>"> 
                                      </div>
                                    </div>
                                  </div>   
                                  <div class="col-md-4 form-group row">
                                   <div class="col-xs-12">                                   
                                      <label class="checkbox-inline"><input type="checkbox" disabled>Confirmed</label>
                                      <label class="checkbox-inline"><input type="checkbox" disabled>Approved</label>
                                   </div>
                                  </div>
                                  <div class="row"></div>                            
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
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Term Period</label>                                      
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="<?php echo $row->loo_term;?>">
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                    <label>Business Unit</label>                                    
                                      <?php echo form_dropdown('cboregion',$region,'','id ="iregion" class="form-control" style="width: 100%;" required'); ?>
                                    </div>
                                  </div>                                  
                                  <div class="col-md-4 form-group row"> 
                                    <div class="col-xs-12">
                                      <label>Store</label>
                                        <select data-placeholder="Select a store" id= "ibranch" name= "cbobranch" required>
                                          <option value="<?php echo $row->branch_id;?>" selected="selected" ><?php echo $row->branch_id;?></option>
                                        </select>
                                    </div>                                    
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Lease Agreement</label>
                                        <?php echo form_dropdown('cbolease',$lotype,'','id ="ilease" class="form-control" style="width: 100%;" required'); ?>
                                    </div>
                                  </div>                                                                       
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">                                      
                                      <a href="javascript:void(0)" id="bttenant"><strong>Tenant:</strong></a>                               
                                      <input type="text" id = "itenant" name="itenant" class="form-control input-sm"  required autocomplete="off">
                                      <input type="hidden" id = "htenant" name="htenant" value="" >
                                    </div> 
                                  </div>                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                        <label></label>                                                                         
                                        <input type="text" id = "ibrand" name="ibrand" class="form-control input-sm" value="" required autocomplete="off">
                                        <input type="hidden" id = "hbrand" name="hbrand" value="">                                      
                                    </div>                                   
                                  </div>                                  
                                  <div class="col-md-12">    
                                  <br>                               
                                    <a href="javascript:void(0)" id="btdetil"><strong>Add Detil</strong></a>   
                                      <!-- Custom Tabs -->
                                      <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                          <li class="active"><a href="#tab_1" data-toggle="tab" role= "tab">Detail</a></li>  
                                          <li><a href="#tab_2" data-toggle="tab" role = "tab">Record</a></li>                                        
                                        </ul>
                                        <div class="tab-content">  
                                          <div class="tab-pane active" id="tab_1"> 
                                           <div class ="table-responsive">
                                            <table class="table table-bordered table-striped" id='looDetil' style="border:solid 1px #999; #999; border-radius:0px;">
                                              <thead>
                                                <tr>
                                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Unit</th>
                                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Size</th>
                                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;" width="30%">Term & Condition</th>
                                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;" width="15%">Charge</th>
                                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Int.</th>
                                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;" width="12%">Time</th>
                                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;" width="15%">Descr</th>
                                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Delete</th>
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
              <!-- END OF CONTENT -->