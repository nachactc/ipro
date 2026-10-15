
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
          url: '<?php echo site_url('listrik/listrik/branch_select')?>',
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
          url: '<?php echo site_url('listrik/listrik/periode_select')?>',
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

          case 'Rental':
              //$("#newdialog").modal("show");           
              break;
      }

  });

  $('#tabedit').click(function() {

    display_modal('Alert!', 'Please, select data from list.');
  });

  $.fn.datepicker.defaults.format = "yyyy-mm-dd";
  $.fn.datepicker.defaults.autoclose = true;

  $('.deci').number( true, 2 );
  $('.bulet').number( true, 0 );  

});

$(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );

</script>

<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

#detailTab td, #detailTab th, #detailTab label {

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
    padding: 1px;
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

  <!-- /.popup-new-data-Utilities -->
  <div class="modal fade" id="newdialog" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title">New Utilities</h4>
        </div>
        <div class="modal-body">
          <form action="#" id="form" class="form-horizontal">
            <div class="row">
              <div class="col-md-12">
                <div class = "portlet">
                  <div class="portlet-body">
                    <div class="row">  
                      <div class="col-md-10">                                  
                        <div class="form-group form-group-sm">        
                          <label class="col-sm-4">Periode Utilities</label>
                          <div class="col-sm-8">
                            <select id= "periodSearch" name= "periodSearch" class="form-control" style="width: 100%;"></select>      
                          </div>
                        </div>                                    
                        <div class="form-group form-group-sm">        
                          <label class="col-sm-4">Store</label>
                          <div class="col-sm-8">
                            <select id= "storeSearch" class="form-control" style="width: 100%;"></select>  
                          </div>
                        </div>
                        <div class="form-group form-group-sm">        
                          <label class="col-sm-4">Business Unit</label>
                          <div class="col-sm-8">
                            <?php echo form_dropdown('regionDlg','','',' id="regionSearch" style="width: 100%;" class="form-control" disabled'); ?>
                            <input type="hidden" id="regionSearch_hidden" name="regionSearch_hidden" />     
                          </div>
                        </div>
                        <br>
                        <div class="form-group">
                          <div class="col-sm-12">
                            <div class="pull-right">
                              <div class="btn-group" role="group" aria-label="First group">                                 
                                <button type="button" class="btn dark btn-outline" data-dismiss="modal">
                                  Cancel
                                </button>
                              </div>
                              <div class="btn-group" role="group" aria-label="Second group">
                                <button type="button" class="btn btn-primary" id="nextnew">
                                  OK
                                </button>                                        
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
                <a href="<?php echo base_url('index.php/listrik/listrik/listrikadd'); ?>" id='tabdata'> INPUT </a>
              </li>
              <li>
                <a href="#editdata" data-toggle="tab" id='tabedit'> EDIT </a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane" id="editdata">
                <div class="portlet-body form">
                  <form action="<?php echo site_url('listrik/listrik/listrik_edit');?>" method="post" onsubmit="return validateb4submit();">
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
                              <input  type="text" id="utilitieslistrik_id" name="utilitieslistrik_id" class="form-control input-sm" value="<?php echo $row->utilitieslistrik_id;?>" readonly>
                            </div>
                          </div> 
                          <div class="col-md-4 form-group row">
                            <div class="col-xs-12">
                              <label class="post checkbox-inline"><input type="checkbox" disabled><b>Posted</b></label>
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
                                <select id= "ibranch" class="form-control" name= "cbobranch" disabled style="width: 100%" >
                                  <option value="<?php echo $row->branch_id;?>" selected="selected" ><?php echo $row->branch_name;?></option>
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
                              <label>Transaksi</label>
                                <input type="text" id = "transaksi_id" name="transaksi_id" value="<?php echo $row->transaksi_name;?>" class="form-control input-sm" readonly>
                                <input type="hidden" id = "htransaksi" name="htransaksi" value="<?php echo $row->transaksi_id; ?>">
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
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant Name</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Trade</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Descr.</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Register ID</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Agreement Number</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;"></th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Ampere</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">T Block</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">T Genset</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Beban KVA</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Phase</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">F.Meter</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">BPJU</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Adm.</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Adm (%)</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Reg Limit</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Awal WBP</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Awal LWBP</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Stand [Awal]</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Stand [Akhir]</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Selisih WBP</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Selisih LWBP</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Selisih Beban</th>
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
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Jumlah</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">PPN (%)</th>
                                              <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Delete</th>
                                          </tr>
                                        </thead>
                                        <tbody> 
                                          <?php if(isset($resultd)){
                                              foreach($resultd as $rowd){
                                          ?>
                                            <tr>
                                            <td><input type="checkbox" id="posted" <?php if ($rowd->utilitieslistrikdetil_isposted == 1) echo 'checked= "checked"';?> disabled>
                                                <input type="hidden" id="d_posted" name="dposted[]" value = "<?php echo "$rowd->utilitieslistrikdetil_isposted"; ?>"/></td>
                                            <td><?php echo "$rowd->utilitieslistrikdetil_line";?><input type="hidden" name="dline[]" value="<?php echo "$rowd->utilitieslistrikdetil_line";?>"/></td>                                            
                                            <td><?php echo substr($rowd->rekanan_name, 0, 20).'..';?><input type="hidden" id="d_tenant_id" name="dtenant_id[]" value = "<?php echo $rowd->rekanan_id; ?>"/></td>
                                            <td><?php echo substr($rowd->rekananshipping_name, 0, 25).'..';?><input type="hidden" id="d_tenant_line" name="dbrand_line[]" value = "<?php echo $rowd->rekananshipping_line; ?>"/></td>
                                            <td><input type="text" id="d_descr" name="ddescr[]" value="<?php echo $rowd->utilitieslistrikdetil_descr;?>" class="pops form-control input-sm"/></td>
                                            <td><?php echo substr($rowd->utilitieslistrikdetil_reg, 0, 25).'..';?><input type="hidden" id="d_reg" name="dreg[]" value="<?php echo $rowd->utilitieslistrikdetil_reg;?>" /></td>
                                            <td><input type="text" id="d_agreement" name="dagreement[]" value="<?php echo $rowd->agreement_id;?>" class="detil form-control input-sm text-center"/></td>
                                            <td><a id= "btnAgr" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></a></td>
                                            <td><input type="text" id="d_amp" name="damp[]" value="<?php echo $rowd->utilitieslistrikdetil_amp;?>" class="detil bulet form-control input-sm"  style= "text-align: right;"/></td>
                                            <td><input type="checkbox" id="blocked" <?php if ($rowd->utilitieslistrikdetil_isblocked == 1) echo 'checked= "checked"';?> >
                                                <input type="hidden" id="d_blocked" name="dblocked[]" value = "<?php echo "$rowd->utilitieslistrikdetil_isblocked"; ?>"/></td>
                                            <td><input type="checkbox" id="genset" <?php if ($rowd->utilitieslistrikdetil_isgenset == 1) echo 'checked= "checked"';?> >
                                                <input type="hidden" id="d_genset" name="dgenset[]" value = "<?php echo "$rowd->utilitieslistrikdetil_isgenset"; ?>"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_bebankva,3);?><input type="hidden" id="d_bebankva" name="dbebankva[]" value="<?php echo $rowd->utilitieslistrikdetil_bebankva;?>"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_phase,2);?><input type="hidden" id="d_phase" name="dphase[]" value="<?php echo $rowd->utilitieslistrikdetil_phase;?>"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_faktor,2);?><input type="hidden" id="d_faktor" name="dfaktor[]" value="<?php echo $rowd->utilitieslistrikdetil_faktor;?>"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_bpjumaster,2);?><input type="hidden" id="d_bpjumaster" name="dbpjumaster[]" value="<?php echo $rowd->utilitieslistrikdetil_bpjumaster;?>"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_admamountmaster,2);?><input type="hidden" id="d_admamountmaster" name="dadmamountmaster[]" value="<?php echo $rowd->utilitieslistrikdetil_admamountmaster;?>"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_admpercentmaster,2);?><input type="hidden" id="d_admpercentmaster" name="dadmpercentmaster[]" value="<?php echo $rowd->utilitieslistrikdetil_admpercentmaster;?>"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_reglimitmaster,2);?><input type="hidden" id="d_reglimitmaster" name="dreglimitmaster[]" value="<?php echo $rowd->utilitieslistrikdetil_reglimitmaster;?>"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_standawalwbp,2);?><input type="hidden" id="d_standawalwbp" name="dstandawalwbp[]" value="<?php echo $rowd->utilitieslistrikdetil_standawalwbp;?>"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_standakhirwbp,2);?><input type="hidden" id="d_standakhirwbp" name="dstandakhirwbp[]" value="<?php echo $rowd->utilitieslistrikdetil_standakhirwbp;?>"/></td>
                                            <td><input type="text" id="d_standawal" name="dstandawal[]" value="<?php echo $rowd->utilitieslistrikdetil_standawal;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>
                                            <td><input type="text" id="d_akhir" name="dakhir[]" value="<?php echo $rowd->utilitieslistrikdetil_akhir;?>" class="detil deci form-control input-sm input-xs" style= "text-align: right;"/></td>
                                            <td><input type="text" id="d_selisihwbp" name="dselisihwbp[]" value="<?php echo $rowd->utilitieslistrikdetil_selisihwbp;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>
                                            <td><input type="text" id="d_selisihlwbp" name="dselisihlwbp[]" value="<?php echo $rowd->utilitieslistrikdetil_selisihlwbp;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>
                                            <td><input type="text" id="d_selisih" name="dselisih[]" value="<?php echo $rowd->utilitieslistrikdetil_selisih;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_wbptotal,2);?><input type="hidden" id="d_wbptotal" name="dwbptotal[]" value="<?php echo $rowd->utilitieslistrikdetil_wbptotal;?>"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_lwbptotal,2);?><input type="hidden" id="d_lwbptotal" name="dlwbptotal[]" value="<?php echo $rowd->utilitieslistrikdetil_lwbptotal;?>"/></td>
                                            <td><input type="text" id="d_pemakaianwbp" name="dpemakaianwbp[]" value="<?php echo $rowd->utilitieslistrikdetil_pemakaianwbp;?>" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>
                                            <td><input type="text" id="d_pemakaianlwbp" name="dpemakaianlwbp[]" value="<?php echo $rowd->utilitieslistrikdetil_pemakaianlwbp;?>" class="detil bulet form-control input-sm" style= "text-align: right;"/></td>
                                            <td><input type="text" id="d_tarifwbp" name="dtarifwbp[]" value="<?php echo $rowd->utilitieslistrikdetil_tarifwbp;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>
                                            <td><input type="text" id="d_tariflwbp" name="dtariflwbp[]" value="<?php echo $rowd->utilitieslistrikdetil_tariflwbp;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_biayawbp,2);?><input type="hidden" id="d_biayawbp" name="dbiayawbp[]" value="<?php echo $rowd->utilitieslistrikdetil_biayawbp;?>"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_biayalwbp,2);?><input type="hidden" id="d_biayalwbp" name="dbiayalwbp[]" value="<?php echo $rowd->utilitieslistrikdetil_biayalwbp;?>"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_biaya,2);?><input type="hidden" id="d_biaya" name="dbiaya[]" value="<?php echo $rowd->utilitieslistrikdetil_biaya;?>"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_bpju,2);?><input type="hidden" id="d_bpju" name="dbpju[]" value="<?php echo $rowd->utilitieslistrikdetil_bpju;?>"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_tagihan,2);?><input type="hidden" id="d_tagihan" name="dtagihan[]" value="<?php echo $rowd->utilitieslistrikdetil_tagihan;?>"/></td>
                                            <td><input type="text" id="d_denda" name="ddenda[]" value="<?php echo $rowd->utilitieslistrikdetil_denda;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_administrasi,2);?><input type="hidden" id="d_administrasi" name="dadministrasi[]" value="<?php echo $rowd->utilitieslistrikdetil_administrasi;?>"/></td>
                                            <td><?php echo number_format($rowd->utilitieslistrikdetil_jumlah,2);?><input type="hidden" id="d_jumlah" name="djumlah[]" value="<?php echo $rowd->utilitieslistrikdetil_jumlah;?>"/></td>
                                            <td><input type="text" id="d_tax" name="dtax[]" value="<?php echo $rowd->utilitieslistrikdetil_tax;?>" class="detil deci form-control input-sm" style= "text-align: right;"/></td>                                           
                                            <td><a id= "btnDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
                                            </tr>
                                            <script>
                                            $('.start').datepicker();
                                            $('.end').datepicker();
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