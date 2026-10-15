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
									site_url('thdLt/add'),
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
					site_url('thdLt'),
					'<i class="glyphicon glyphicon-list"></i>',
					'class="btn btn-success btn-sm" data-tooltip="tooltip" data-placement="top" title="List Data"'
				);
		?> 
</div>		

<?php echo form_open(site_url('thdLt/' . $action),'role="form" class="form-horizontal" id="form_master_branch" parsley-validate'); ?>               
					
<!--content--> 
	<div class="row">
		<div class="col-md-12">
		  <div class="portlet-body form">
				
				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="thdlt_id" class="control-label">ID</label> 
						<?php
								$dataID = array(
									'name'         => 'thdlt_id',
									'id'           => 'thdlt_id',                       
									'class'        => 'form-control input-sm ',
									'placeholder'  => 'ID',									
									'maxlength'		 =>'7',
									'required' => 'required'
								);

								if($records['thdlt_id']!='') {
									$dataID['readonly'] = 'readonly';
								}

								echo form_input($dataID, set_value('thdlt_id', $records['thdlt_id']));
						?>
						<?php echo form_error('thdlt_id');?> 
					</div>						  
				</div><!--/ Branch --> <!--/ Branch Isdisabled --> <!--/ Branch Isgroup -->  
				
				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="thdlt_name" class="control-label">Lantai Name</label>                                   
						<?php					
								echo form_input(
									array(
										'name'         => 'thdlt_name',
										'id'           => 'thdlt_name', 
										'class'        => 'form-control input-sm ',
										'placeholder'  => 'Lantai',
										'maxlength'	=>'50',
										'required' => 'required',
										'value' => $records['thdlt_name']
									)
									//set_value('thdlt_name', $records['thdlt_name'], false)
								);             
						?>
						<?php echo form_error('thdlt_name');?> 
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
										<label for="thdlt_createby" class="control-label">Create By</label>                                  
										<?php                  
										echo form_input(
													array(
													'name'         => 'thdlt_createby',
													'id'           => 'thdlt_createby',                       
													'class'        => 'form-control input-sm ',
													'placeholder'  => 'Create By',
													'readonly'  	=> TRUE,
													'maxlength'=>'30'
													),
													set_value('thdlt_createby', $records['thdlt_createby'], false)
												);             
										?>
										<?php echo form_error('thdlt_createby');?>  
									</div>
								</div> <!--/ Create By -->
				
								<div class="col-md-4 form-group row">
									<div class="col-xs-12">
										<label for="thdlt_createdate" class="control-label">Create Date</label>                                  
										<?php                  
										echo form_input(
												array(
													'name'         => 'thdlt_createdate',
													'id'           => 'thdlt_createdate',                       
													'class'        => 'form-control input-sm ',
													'placeholder'  => 'Create Date',
													'readonly'  	=> TRUE,
													
													),
													set_value('thdlt_createdate',$records['thdlt_createdate'])
										);             
										?>
										<?php echo form_error('thdlt_createdate');?> 
									</div>
								</div><!--/ Create Date --> 
				
								<div class="col-md-4 form-group row">
									<div class="col-xs-12">
											<label for="thdlt_modifyby" class="control-label">Modify By</label>                                    
											<?php                  
											echo form_input(
														array(
														'name'         => 'thdlt_modifyby',
														'id'           => 'thdlt_modifyby',                       
														'class'        => 'form-control input-sm ',
														'placeholder'  => 'Modify By',
														'readonly'  	=> TRUE,
														'maxlength'=>'30'
														),
														set_value('thdlt_modifyby', $records['thdlt_modifyby'], false)
													);             
											?>
											<?php echo form_error('thdlt_modifyby');?> 
									</div>
								</div><!--/ Modify by -->
				
								<div class="col-md-4 form-group row">
									<div class="col-xs-12">
										<label for="thdlt_modifydate" class="control-label">Modify Date</label>                                  
										<?php                  
												echo form_input(
													array(
														'name'         => 'thdlt_modifydate',
														'id'           => 'thdlt_modifydate',                       
														'class'        => 'form-control input-sm ',
														'placeholder'  => 'Modify Date',
														'readonly'  	=> TRUE,
														
														),
														set_value('thdlt_modifydate', $records['thdlt_modifydate'])
												);             
										?>
										<?php echo form_error('thdlt_modifydate');?> 
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