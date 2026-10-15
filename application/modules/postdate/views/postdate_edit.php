<script>
  $(document).ready(function(){

  	$("#tabedit").trigger('click');
  	 
  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  	});
	
	$.fn.datepicker.defaults.format = "yyyy-mm-dd";
    $.fn.datepicker.defaults.autoclose = true;
	  
  });

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
    

                     

                       

            <!-- CONTENT -->
            <div class="row">
              <div class="col-md-12">
                <div class="portlet">
                  <div class="portlet-title">
                    <div class="caption" align="right">
                      <div class="actions">
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
                          <a href="<?php echo base_url('index.php/postdate/postdate/postdatelist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="<?php echo base_url('index.php/postdate/postdate/postdateadd'); ?>" id='tabdata'> INPUT </a>
                        </li>
                        <li >
                         <a href="#editdata"  data-toggle="tab" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        
                        <div class="tab-pane" id="editdata">
                          <div class="portlet-body form">
                         <form id="myForm" action="<?php echo site_url('postdate/postdate/postdate_edit');?>" method="post" onsubmit="return validateb4submit();">
                            <?php 
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>                                   
                    <div class="row">
                        <div class="col-md-12">   
                                    
                                  <!-- /.form group -->                                              
 <br>
 <br>
 <br>
							 <div class="col-md-4">
							  <label>Periode</label>							  
							   
								  <input type="text" id="iperiode" name="iperiode" class="form-control input-sm" value = "<?php echo $row->periode;?>" readonly>
								  
							   
							</div>
							
							 <div class="col-md-4">
							  <label>Posting Date</label>
							  <input type="hidden" id="date_old" name="date_old" value="<?php echo date('Y-m-d', strtotime($row->posting_date));?>">
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-addon">
								  <i class="fa fa-calendar"></i>
								</div>
								  <input type="text" class="form-control input-sm pull-right" id="posting_date" name="posting_date" value = "<?php echo date('Y-m-d', strtotime($row->posting_date));?>">
								  
							  </div>
							</div>
							 <div class="col-md-4">
							  <label>Due Date</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-addon">
								  <i class="fa fa-calendar"></i>
								</div>
								  <input type="text" class="form-control input-sm pull-right" id="due_date" name="due_date" value = "<?php echo date('Y-m-d', strtotime($row->due_date));?>">
								  
							  </div>
							</div>							
							 <div class="col-md-4">
							  <label>Agreement Type</label>
								<input type="text" id="agreement_type" name="agreement_type" class="form-control input-sm" value = "<?php echo $row->agreement_type;?>" readonly>
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