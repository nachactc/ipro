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
	$('#acc_id').select2();
	 
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
                          <a href="<?php echo base_url('index.php/master_source_acc/master_source_acc/master_source_acclist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="<?php if($mode == 'add') { echo '#inputdata'; } else { echo base_url('index.php/master_source_acc/master_source_acc/master_source_accadd'); } ?>" <?php if($mode == 'add') { echo 'data-toggle="tab"'; }   ?> id='tabinput'> INPUT </a>
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
                                    <label>Source Name</label>
                                    <input type="text" id ="source_id" name="source_id" class="form-control" value="<?php echo !empty($result['source_id'])?$result['source_id']:''; ?>" required>
                                </div>
								
                                <div class="col-md-4">
                                    <label>Account </label>             
									<?php                   
									    echo form_dropdown(
													   'acc_id',
													   $acc,  
													   set_value('acc_id',!empty($result['acc_id'])?$result['acc_id']:''),
													   'class="form-control input-sm" id="acc_id" style="width:100%;"'
													   );  
								  ?>
                                </div> 
								
								
                                <div class="col-md-4">
                                    <label>D/K</label>
                                    <input type="text" id ="dk" name="dk" class="form-control" value="<?php echo !empty($result['dk'])?$result['dk']:''; ?>" required>
                                </div>
								
								
                                <div class="col-xs-12">
								<div class="row"> &nbsp;<br/> </div>
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