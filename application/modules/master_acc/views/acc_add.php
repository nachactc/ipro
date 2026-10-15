<script> 	
  
  $(document).ready(function(){
	<?php if($mode == 'add') { ?>
		$("#tabinput").trigger('click'); 
		$('#tabedit').click(function() {
			alert('Please, select data from list');
		}); 
	<?php } else { ?>
		$("#tabedit").trigger('click'); 
	<?php } ?>
	$('#acc_id').on('change',function(e){ 
		var value = $('#acc_id').val();
		$('#acc_path').val(value);
	});
	$('#acc_id').on('keypress',function(e){ 
		var value = $('#acc_id').val();
		$('#acc_path').val(value);
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
                          <a href="<?php echo base_url('index.php/master_acc/master_acc/master_acclist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="<?php if($mode == 'add') { echo '#inputdata'; } else { echo base_url('index.php/master_acc/master_acc/master_accadd'); } ?>" <?php if($mode == 'add') { echo 'data-toggle="tab"'; }   ?> id='tabinput'> INPUT </a>
                        </li>
                        <li>
                          <a href="<?php if($mode == 'edit') { echo '#editdata'; }   ?>"  <?php if($mode == 'edit') { echo 'data-toggle="tab"'; }   ?> id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">                        
                        <div class="tab-pane" id="<?php if($mode == 'add') { echo 'inputdata'; } else { echo 'editdata'; } ?>">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url($action);?>" method="post">

											 <div class="row">
                        <div class="col-md-10">
                           <form id="form_input"> 

                                <div class="col-md-4">
                                    <label>Account ID&nbsp;<i>* Manual *</i></label>                                       
                                    <input  type="text" id="acc_id" name="acc_id" class="form-control" value="<?php echo !empty($result['acc_id'])?$result['acc_id']:''; ?>"  <?php if($mode == 'edit') { echo 'readonly'; } else { echo 'required'; }  ?> >
                                </div> 
								
                                <div class="col-md-4">
                                    <label>Account Name</label>
                                    <input type="text" id ="acc_name" name="acc_name" class="form-control" value="<?php echo !empty($result['acc_name'])?$result['acc_name']:''; ?>" required>
                                </div>
								
                                <div class="col-md-4">
                                    <label>Account Name Short</label>
                                    <input type="text" id ="acc_nameshort" name="acc_nameshort" class="form-control" value="<?php echo !empty($result['acc_nameshort'])?$result['acc_nameshort']:''; ?>" required>
                                </div>
								
                                <div class="col-md-4">
                                    <label>Account Descr</label>
                                    <input type="text" id ="acc_descr" name="acc_descr" class="form-control" value="<?php echo !empty($result['acc_descr'])?$result['acc_descr']:''; ?>" required>
                                </div>
								
                                <div class="col-md-4">
                                    <label>Is Group</label>
                                    <input type="checkbox" <?php echo !empty($result['acc_isgroup'])?'Checked':''; ?> name="acc_isgroup" class="form-control"> 
                                </div>
                                 
                                <div class="col-md-4">
                                    <label>Account Parent</label>
                                    <input type="text" id ="acc_parent" name="acc_parent" class="form-control" value="<?php echo !empty($result['acc_parent'])?$result['acc_parent']:0; ?>" required>
                                </div>
								
								<div class="row"> &nbsp; </div>
								
                                <div class="col-md-4">
                                    <label>Account Path</label>
                                    <input type="text" id ="acc_path" name="acc_path" class="form-control" value="<?php echo !empty($result['acc_path'])?$result['acc_path']:0; ?>" required>
                                </div>
								 
                                <div class="col-md-4">
                                    <label>Is Disabled</label>
                                    <input type="checkbox" <?php echo !empty($result['acc_isdisabled'])?'Checked':''; ?> name="acc_isdisabled" class="form-control">
                                </div>
								
                                <div class="col-md-4">
                                    <label>Is Monetary</label>
                                    <input type="checkbox" <?php echo !empty($result['acc_ismonetary'])?'Checked':''; ?> name="acc_ismonetary" class="form-control">
                                </div>
								 
                                <div class="col-md-4">
                                    <label>Account Sub Group ID</label>
                                    <input type="text" id ="acc_subgroupid" name="acc_subgroupid" class="form-control" value="<?php echo !empty($result['acc_subgroupid'])?$result['acc_subgroupid']:0; ?>" required>
                                </div>
								 
                                <div class="col-xs-12">
                                    <input type="submit" value="SUBMIT" class="btn btn-sm btn-info" />
                                </div>
															
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT --> 