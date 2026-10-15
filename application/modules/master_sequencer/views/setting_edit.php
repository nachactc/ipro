<script> 
 

  $(document).ready(function(){

  	$("#tabedit").trigger('click');
  	 
  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  	});
	 
  }); 
</script>

<style>
table.dataTable td {
    padding:2px;
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

 <!-- CONTENT -->
            <div class="row">
              <div class="col-md-12">
                <div class="portlet">
                  <div class="portlet-title">
                    <div class="caption" align="right">
                      <div class="actions">
                        
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
                          <a href="<?php echo base_url('index.php/master_sequencer/sequencerlist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="<?php echo base_url('index.php/master_sequencer/settingadd'); ?>"  id='tabinput'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata"  data-toggle="tab" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">                        
                        <div class="tab-pane" id="editdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('master_sequencer/setting_edit');?>" method="post">
                            <?php  
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>                                   
                    <div class="row">
                        <div class="col-md-10">
                           <form id="form_input">  
								
								 <div class="col-md-12">
                                    <label>Channel</label>                                       
                                    <input  type="text" id="channel_id" name="channel_id" class="form-control" value="<?php echo $row->channel_id;?>" placeholder="Wajib Isi" required>
                                </div> 
								
                                <div class="col-md-12">
                                    <label>Type</label>
                                    <input type="text" id ="type" name="type" class="form-control" value="<?php echo $row->type;?>" placeholder="Type" required>
                                </div>
								
                                <div class="col-md-12">
                                    <label>Last ID</label>
                                    <input type="text" id ="lastid" name="lastid" class="form-control" value="<?php echo $row->lastid;?>" placeholder="Wajib Isi" required >
                                </div>
                                
								<div class="clearfix margin-bottom-40"></div>

								<div class="clearfix margin-bottom-40"></div>
 
                                <div class="col-xs-12">
                                    <input type="submit" value="SUBMIT" class="btn btn-sm btn-info" />
                                </div>
																<?php }}?>	
                            </form>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT -->

