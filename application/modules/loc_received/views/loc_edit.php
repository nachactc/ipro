<script>

$(document).ready(function(){
   $("#tabedit").trigger('click');
   var rTable=popgrid("<?php echo site_url('loc_received/loc_received/dialog_loc')?>","popLoader","trp", 10);
	 
	$('#btloo').click(function() {
		rTable.rows('.selected').deselect();
		$("#tedialog").modal("show");
	});
	$('#btnrek').click(function() { 
		var searchTenant  = $("#searchloo").val(); 
		rTable.search(searchTenant).draw();
	});
	$('#addData').click(function () {

      var linenum=0;
       var rData = rTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){
 
          var tloc_id   = rData[i][4];

          $('#loc_id').val(tloc_id);
      }

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
                                 <label>Business Unit</label>
                                <?php echo form_dropdown('cboregionDlg',$region,'',' id="regionDlg_select" style="width: 100%;" class="iregionsearch form-control " '); ?>
                              </div>
							<div class="col-md-4">
                                 <label>Store</label>
								 <select id="branchdlg_select" class="form-control" style="width: 100%;"> </select> 
                              </div>
                              
							</div>
							
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
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Region</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Branch</th>
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
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Business Unit</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Store</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
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
                          <a href="<?php echo base_url('index.php/loc_received/loc_received/loc_status'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('index.php/loc_received/loc_received/loireceived_add'); ?>" id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata" data-toggle="tab"  id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane" id="editdata">
                          <div class="portlet-body form">
                        
                         <form action="<?php echo site_url('loc_received/loc_received/loc_actedit');?>" method="post" onsubmit="return validateb4submit();">
                            <?php
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>
                    <div class="row">
                      <div class="col-md-12">
                                  <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>LOC ID</label>
                                      <input  type="text" id="loc_id" name="loc_id" class="form-control input-sm" value="<?php echo $row->loc_id;?>" readonly>
                                    </div>
                                  </div>
                                  <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>LOC No.</label>
                                      <input  type="text" id="loc_id" name="loc_id" class="form-control input-sm"value="<?php echo $row->loc_no;?>" >
                                    </div>
                                  </div>
                                   <div class="col-md-2 form-group row">
                                    <div class="col-xs-12">
                                      <label>&nbsp;</label>
									   <span class="input-group-btn">
                                      <button id ="btloo" type="button" class="btn btn-primary" disabled>
									  <i class="fa fa-search" ></i></button>
									  </span>
                                    </div>
                                  </div>
                                  <!-- /.form group -->
                                  <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>Process By</label>
                                      <input  type="text" readonly id="loc_process" name="loc_process" class="form-control input-sm" value="<?php echo $row->loc_processby;?>">
                                      </div>
                                  </div>
                                 
                                  <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>LOC Process Date</label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="loc_procesdate" name="loc_procesdate" value = "<?php echo $row->loc_processdate;?>">
                                      </div>
                                    </div>
                                  </div>
                                 <?php
								 $ckproses="";
								  if ($row->loc_isprocess=='1'){
									$ckproses="checked";		  
								  }
  
								  ?>
                                   <div class="col-md-2 form-group row">
                                    <div class="col-xs-12">
                                      <label>Processed</label><br />
                                      <input name="ckproses" value="1" type="checkbox" <?php echo $ckproses;?> />
                                    </div>
                                  </div>
                                  
                                 
                           <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>LOC Sent By</label>
                                      <input value="<?php echo $row->loc_sentby;?>"  type="text" readonly  id="loc_sentby" name="loc_sentby" class="form-control input-sm" >
                                    </div>
                                  </div>                                
                                   <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>LOC Sent Date</label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="loc_sentdate" name="loc_sentdate" value = "<?php echo $row->loc_sentdate;?>">
                                      </div>
                                    </div>
                                  </div>
                                  <?php
								 $cksent="";
								  if ($row->loc_issent=='1'){
									$cksent="checked";		  
								  }
  
								  ?>
                                  
                                    <div class="col-md-2 form-group row">
                                    <div class="col-xs-12">
                                      <label>Sent</label><br />
                                      <input name="cksent" value="1" type="checkbox" <?php echo $cksent;?>/>
                                    </div>
                                  </div>
                                  
                                   <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>LOC Received By</label>
                                      <input value="<?php echo $row->loc_receivedby;?>" type="text" readonly id="loc_receiveby" name="loc_receiveby" class="form-control input-sm">
                                    </div>
                                  </div>
                                  
                                  
                                   <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>LOC Receive Date</label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="loc_recivedate" name="loc_recivedate" value = "<?php echo $row->loc_receivedate;?>">
                                      </div>
                                    </div>
                                  </div>
                                  <?php
								   $ckreceive="";
								  if ($row->loc_isreceived=='1'){
									$ckreceive="checked";		  
								  }
  
								  ?>
                                   <div class="col-md-2 form-group row">
                                    <div class="col-xs-12">
                                      <label>Received</label><br />
                                      <input name="ckreceive" value="1" type="checkbox" id="ckreceive" <?php echo $ckreceive;?>/>
                                    </div>
                                  </div>
                                  
                                  
                                   <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>LOC Signed By</label>
                                      <input value="<?php echo $row->loc_signedby;?>" type="text" id="loc_signedby" name="loc_signedby" readonly class="form-control input-sm" />
                                    </div>
                                  </div>
                                  
                                   <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>LOC Signed Date</label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="loc_signeddate" name="loc_signeddate" value = "<?php echo $row->loc_signeddate;?>">
                                      </div>
                                    </div>
                                  </div>
                                  <?php
								   $cksigned="";
								  if ($row->loc_issigned=='1'){
									$cksigned="checked";		  
								  }
  
								  ?>
                                  <div class="col-md-2 form-group row">
                                    <div class="col-xs-12">
                                      <label>Signed</label><br />
                                      <input name="cksigned" value="1" type="checkbox" id="cksigned" <?php echo $cksigned;?>/>
                                    </div>
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
                                            
                                    <!-- /.col -->
                               
                            

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT -->
