<script>
	$(document).ready(function() {

			$('.parent').select2({
				placeholder: 'Pilih Data', 
				tags: true,
				allowClear: true,
				width: 'resolve'
			});

			window.setTimeout(function() {
					$(".alert").fadeTo(500, 0).slideUp(500, function(){
							$(this).remove();
					});
			}, 2500);
		
	});
</script>
<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;
}


.detil {
    padding: 2px;
}

label {
  font-size: 9pt;
  font-weight: bold;
}

.select2-container {
  min-width:120px;
}

</style>

<div class="row">
	<div class="col-lg-12 col-md-12">		
		<?php                 
				$msg = $this->session->flashdata('message'); 
				if (!empty($msg))
				{
		?> 
				<div class="alert alert-success fade in ">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
				   <?php echo $msg; ?>
				</div>
				<div class="col-md-1">                
						<?php	
								echo anchor(
									site_url('thdGroup/add'),
									'<i class="glyphicon glyphicon-plus"></i>',
									'class="btn btn-success btn-sm" data-tooltip="tooltip" data-placement="top" title="Tambah Data"'
								);
							?> 
				</div> 
				
		<?php } ?>
		<?php                 
				$error = $this->session->flashdata('error'); 
				if (!empty($error))
				{
		?> 
				<div class="alert alert-danger fade in" role="alert">
					<a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #000;"><span aria-hidden="true">&times;</span></a>
  				<!--<span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>-->
					<?php echo $error; ?>
				</div>				
		<?php } ?>
	</div>
</div><!-- /.row -->	



<div class="col-md-1">                
		<?php	
				echo anchor(
					site_url('thdGroup'),
					'<i class="glyphicon glyphicon-list"></i>',
					'class="btn btn-success btn-sm" data-tooltip="tooltip" data-placement="top" title="List Data"'
				);
		?> 
</div>		
<?php echo form_open(site_url('thdGroup/' . $action),'role="form" class="form-horizontal" id="form_master_branch" parsley-validate'); ?>               
					
<!--content--> 
	<div class="row">
		<div class="col-md-12">
		  <div class="portlet-body form">
				
				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="thdgroup_id" class="control-label">ID</label> 
						<?php
								$dataID = array(
									'name'         => 'thdgroup_id',
									'id'           => 'thdgroup_id',                       
									'class'        => 'form-control input-sm ',
									'placeholder'  => 'ID',									
									'maxlength'		 =>'7',
									'required' => 'required'
								);

								if($records['thdgroup_id']!='') {
									$dataID['readonly'] = 'readonly';
								}

								echo form_input($dataID, set_value('thdgroup_id', $records['thdgroup_id']));
						?>
						<?php echo form_error('thdgroup_id');?> 
					</div>						  
				</div><!--/ Branch --> <!--/ Branch Isdisabled --> <!--/ Branch Isgroup -->  
				
				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="thdgroup_name" class="control-label">Group Name</label>                                   
						<?php                  
								echo form_input(
									array(
										'name'         => 'thdgroup_name',
										'id'           => 'thdgroup_name', 
										'class'        => 'form-control input-sm ',
										'placeholder'  => 'Group',
										'maxlength'	=>'50',
										'required' => 'required'
									),
									set_value('thdgroup_name', $records['thdgroup_name'], false)
								);             
						?>
						<?php echo form_error('thdgroup_name');?> 
					</div>
				</div><!--/ Category Name --> 								 								
				
				
	<div class="row"> &nbsp; </div>
	<br/>
	<br/>



	<!-- tab -->
		<div class="col-md-12">	
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#tab3" data-toggle="tab" role = "tab">Record</a>
					</li>					
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab3">
						<div class="row">
								<div class="col-md-4 form-group row">
									<div class="col-xs-12">
										<label for="thdgroup_createby" class="control-label">Create By</label>                                  
										<?php                  
										echo form_input(
													array(
													'name'         => 'thdgroup_createby',
													'id'           => 'thdgroup_createby',                       
													'class'        => 'form-control input-sm ',
													'placeholder'  => 'Create By',
													'readonly'  	=> TRUE,
													'maxlength'=>'30'
													),
													set_value('thdgroup_createby', $records['thdgroup_createby'], false)
												);             
										?>
										<?php echo form_error('thdgroup_createby');?>  
									</div>
								</div> <!--/ Create By -->
				
								<div class="col-md-4 form-group row">
									<div class="col-xs-12">
										<label for="thdgroup_createdate" class="control-label">Create Date</label>                                  
										<?php                  
										echo form_input(
												array(
													'name'         => 'thdgroup_createdate',
													'id'           => 'thdgroup_createdate',                       
													'class'        => 'form-control input-sm ',
													'placeholder'  => 'Create Date',
													'readonly'  	=> TRUE,
													
													),
													set_value('thdgroup_createdate',$records['thdgroup_createdate'])
										);             
										?>
										<?php echo form_error('thdgroup_createdate');?> 
									</div>
								</div><!--/ Create Date --> 
				
								<div class="col-md-4 form-group row">
									<div class="col-xs-12">
											<label for="thdgroup_modifyby" class="control-label">Modify By</label>                                    
											<?php                  
											echo form_input(
														array(
														'name'         => 'thdgroup_modifyby',
														'id'           => 'thdgroup_modifyby',                       
														'class'        => 'form-control input-sm ',
														'placeholder'  => 'Modify By',
														'readonly'  	=> TRUE,
														'maxlength'=>'30'
														),
														set_value('thdgroup_modifyby', $records['thdgroup_modifyby'], false)
													);             
											?>
											<?php echo form_error('thdgroup_modifyby');?> 
									</div>
								</div><!--/ Modify by -->
				
								<div class="col-md-4 form-group row">
									<div class="col-xs-12">
										<label for="thdgroup_modifydate" class="control-label">Modify Date</label>                                  
										<?php                  
												echo form_input(
													array(
														'name'         => 'thdgroup_modifydate',
														'id'           => 'thdgroup_modifydate',                       
														'class'        => 'form-control input-sm ',
														'placeholder'  => 'Modify Date',
														'readonly'  	=> TRUE,
														
														),
														set_value('thdgroup_modifydate', $records['thdgroup_modifydate'])
												);             
										?>
										<?php echo form_error('thdgroup_modifydate');?> 
									</div>
								</div><!--/ Modify Date -->  
						</div>
					</div>														  
				</div> 
			</div>
		</div>
    <!-- end tab -->
	<div class="row"> &nbsp; </div>
	<br/>
	

	<div class="form">   
	  <div class="row"> 
		 <div class="col-md-5"> 
			<div class="col-xs-12">
				<button type="submit" class="btn green" name="post">
					<i class="glyphicon glyphicon-floppy-save"></i> Submit
				</button>                  
		  </div>
		  </div>
	  </div>
	</div><!--/ Panel Footer --> 
	 
    
			</div> <!--/ portlet-body form -->
		</div> <!--/ col-md-12 --> 
	</div> <!--/ row --> 
<!--/ Content --> 
 
<?php echo form_close(); ?>  