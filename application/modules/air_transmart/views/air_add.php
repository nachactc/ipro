
<script>

function validateb4submit(){
  var max=GetDgvLineMaxNum('agreeDetil',0);
  if (max < 1 ){    
    display_modal('Alert!', 'Please, Add Term & Condition !');
    return false;
  }
}

$(document).ready(function(){

  $.fn.modal.Constructor.prototype.enforceFocus = $.noop;  

  $('#iregion').val([]);  
  $('#istruk').val([]);  

  $('#iregion').select2({placeholder: 'Select a Business Unit'});  
  $('#istruk').select2({placeholder: 'Choose Strukturunit ..'});
  $('#ibranch').select2({placeholder: 'Select a Store'});

  $('#regionSearch').select2({placeholder: 'Select a Business Unit'});

  $('#storeSearch').select2({        
      dropdownCssClass: 'dropdown-store',
      placeholder: 'Select an option',
      minimumInputLength: 2,
      allowClear: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('air/air/branch_select')?>',
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
          url: '<?php echo site_url('air/air/periode_select')?>',
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

  $('#calcSearch').select2({        
      dropdownCssClass: 'dropdown-calc',
      placeholder: 'Select an option',
      ajax: {
          url: '<?php echo site_url('air/air/calc_select')?>',
          dataType: 'json',
          type: "GET",
          data: function (term) {
              return {
                  branch: $('#storeSearch').val()
              };
          },
          processResults: function (data) {
              return {
                  results: $.map(data.items, function (item) {

                      return {

                          text: item.description,                          
                          id: item.utilitiesairgas_number
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

  $('#calcSearch').on('select2:open', function(e){
      $('.dropdown-calc').parent().css('z-index', 99999);
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

	$("#tabdata").trigger('click');  

  $('#btdetil').click(function() {

      var activetab = $('.detil .active').text();
      switch(activetab) {

          case 'Rental':
              //$("#newdialog").modal("show");           
              break;
      }

  });

	$('#tabedit').click(function() {

    display_modal('Alert!', 'Please, select data from list.');
	});

  $('#addnew').click(function () {    

/*

    bra = $('#storeSearch').val();
    reg = $('#regionSearch').val();
    per = $('#periodSearch').val();  

    window.open("<?php //echo site_url('air/air/airedit');?>/new_"+bra+"_"+reg+"_"+per, "_self");
    */

  });

  $.fn.datepicker.defaults.format = "yyyy-mm-dd";
  $.fn.datepicker.defaults.autoclose = true;

  $('.deci').number( true, 2 );
  $('.bulet').number( true, 0 );  

});

$(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation({preventSubmit: false})} );


$(window).load(function() {    

    $("#newdialog").modal("show");
});

</script>

<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

#detailTab th, td, label {

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

  <!-- /.popup-tenant -->
  <div class="modal fade" id="tedialog" tabindex="-1" role="basic" aria-hidden="true">
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

  <!-- /.popup-new-data-Utilities -->
  <div class="modal fade" id="newdialog" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">New Utilities</h4>
        </div>
        <div class="modal-body">
          <form action="<?php echo site_url('air/air/airedit');?>" id="form" class="form-horizontal" method="post" >
            <div class="row">
              <div class="col-md-12">
                <div style="color:red"> <?php echo validation_errors(); ?> </div>
                <div class = "portlet">
                  <div class="portlet-body">
                    <div class="row">  
                      <div class="col-md-10">                                  
                        <div class="form-group form-group-sm">        
                          <label class="col-sm-4">Periode Utilities</label>
                          <div class="col-sm-8">
                            <select id= "periodSearch" name= "periodSearch" class="form-control" style="width: 100%;" required></select>
                          </div>
                        </div>                                    
                        <div class="form-group form-group-sm">        
                          <label class="col-sm-4">Store</label>
                          <div class="col-sm-8">
                            <select id= "storeSearch" name="storeSearch" class="form-control" style="width: 100%;" required></select>  
                          </div>
                        </div>
                        <div class="form-group form-group-sm">        
                          <label class="col-sm-4">Business Unit</label>
                          <div class="col-sm-8">
                            <?php echo form_dropdown('regionDlg','','',' id="regionSearch" style="width: 100%;" class="form-control" disabled'); ?>
                            <input type="hidden" id="regionSearch_hidden" name="regionSearch_hidden" />     
                          </div>
                        </div>
                        <div class="form-group form-group-sm">        
                          <label class="col-sm-4">Calculation Method</label>
                          <div class="col-sm-8">
                            <select id= "calcSearch" name= "calcSearch" class="form-control" style="width: 100%;" required></select>
                          </div>
                        </div>
                        <br>
                        <div class="form-group">
                          <div class="col-sm-12">
                            <div class="pull-right">
                              <div class="btn-group" role="group" aria-label="First group">                                 
                                <a class="btn dark btn-outline" href="<?php echo base_url('index.php/air/air/airlist'); ?>" role="button">Cancel</a>
                              </div>
                              <div class="btn-group" role="group" aria-label="Second group">
                                <!--<button type="submit" class="btn btn-primary" id="addnew">
                                  OK
                                </button>  -->
                                <input type="submit" id="addnew" value="OK" class="btn btn-primary" />                                  
                              </div>
                            </div>
                          </div>                                    
                        </div>
                      </div>
                    </div>
                  </div>                     
                </div>
              </div>
            </div>
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
                <a href="<?php echo base_url('index.php/listrik/listrik/listriklist'); ?>" id='tablist'> LIST </a>
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
                  <form action="<?php echo site_url('gas/gas/gas_add');?>" method="post" onsubmit="return validateb4submit();">
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
                              <label class="post checkbox-inline pull-right"><input type="checkbox" disabled>Posted</label>
                              <input  type="text" id="utilitieslistrik_id" name="utilitieslistrik_id" class="form-control input-sm" value="<?php echo $row->utilitiesairgas_id;?>" readonly>
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
                                <input type="text" class="form-control input-sm pull-right" id="utilitieslistrik_date" name="utilitieslistrik_date" value = "<?php echo $row->utilitiesairgas_date;?>" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4 form-group form-group-sm row">
                            <div class="col-xs-12">
                              <label>Store</label>
                                <?php echo form_dropdown('ibranch','','','id ="ibranch" class="form-control" style="width: 100%;" required disabled '); ?>
                                <input type="hidden" id = "cbobranch" name="cbobranch" value="">
                            </div>
                          </div>
                          <div class="col-md-4 form-group form-group-sm row">
                            <div class="col-xs-12">
                            <label>Business Unit</label>
                              <?php echo form_dropdown('iregion','','','id ="iregion" class="form-control" style="width: 100%;" required disabled '); ?>
                            </div>
                            <input type="hidden" id = "cboregion" name="cboregion" value="">
                          </div>
                          <div class="col-md-4 form-group form-group-sm row">
                            <div class="col-xs-12">
                              <label>Strukturunit</label>                                        
                                <?php echo form_dropdown('cbostruktur','','','id ="istruk" class="form-control" style="width: 100%;" required '); ?>
                            </div>
                          </div>
                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label>Transaksi</label>
                                <input type="text" id = "transaksi_id" name="transaksi_id" value="" class="form-control input-sm" readonly>
                                <input type="hidden" id = "htransaksi" name="htransaksi" value="">
                            </div>                                    
                          </div>                                    
                          <div class="col-md-11 form-group row">                                    
                            <div class="col-xs-12">
                              <label>Description:</label>
                              <textarea id = "agreement_descr" name="agreement_descr" class="form-control input-sm" required rows="2" ></textarea>
                            </div>                                    
                          </div>
                          <div class="col-md-12">                                  
                          <br>
                          <a href="javascript:void(0)" id="btdetil"><strong>Add Row</strong></a>
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                              <ul class="detil nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab" role= "tab">Detail</a></li>
                                <li><a href="#tab_2" data-toggle="tab" role = "tab">Record</a></li>
                              </ul>
                              <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                  <div class ="table-responsive">                                             
                                    <div style="overflow-y: scroll; height: 300px">
                                      <table class="table table-bordered table-striped" id='detailTab' style="border:solid 1px #999; #999; border-radius:0px;">
                                        <thead>
                                          <tr>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Post.</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Trade</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Descr.</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Reg</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Agreement</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Ampere</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Type Block</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Type Genset</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Beban KVA</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Phase</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Faktor Meter</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">BPJU</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Adm. Amount</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Adm (%)</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Reg Limit</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Awal WBP</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Awal LWBP</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Stand Awal</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Stand Akhir</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Selisih WBP</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Selisih LWBP</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Selisih</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">WBP Total Gedung</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">LWBP Total Gedung</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Pemakaian WBP</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Pemakaian LWBP</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tarif WBP</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tarif LWBP</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Biaya WBP</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Biaya LWBP</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Biaya</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">BPJU</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tagihan</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Denda</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Administrasi</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Jumlah</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tax</th>
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
                                  <div class="row">
                                   <div class="col-md-6">
                                    <div class="col-xs-8">
                                       <label>Create By</label>
                                       <input type="text" id= "utilitieslistrik_createby" name="utilitieslistrik_createby" class="form-control input-sm" value="">
                                    </div>
                                   </div>
                                   <div class="col-md-6">
                                    <div class="col-xs-8">
                                       <label>Create Date</label>
                                       <input type="text" id="utilitieslistrik_createdate" name="utilitieslistrik_createdate" class="form-control input-sm" value="">
                                    </div>
                                   </div>
                                   <div class="col-md-6">
                                    <div class="col-xs-8">
                                       <label>Modify By</label>
                                       <input type="text" id= "utilitieslistrik_modifyby"  name="utilitieslistrik_modifyby" class="form-control input-sm" value="">
                                    </div>
                                   </div>
                                   <div class="col-md-6">
                                    <div class="col-xs-8">
                                       <label>Modify Date</label>
                                       <input type="text" id="utilitieslistrik_modifydate" name="utilitieslistrik_modifydate" class="form-control input-sm" value="">
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
