<script>

 $(document).ready(function() {
	$('#shipping_back a').click(function(e) { 
	  $('#tab3').tab('show');
	}); 
    $('.grouptenant').select2({
		 placeholder: 'Pilih Data', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
	}); 
	$('#link').click(function() {
		//window.location.href= "<?php echo site_url('master_rekanan/edit/'.$master_rekanan['rekanan_id'].'/tab4'); ?>";
		$('#rekananshipping_line').val(0);
		$('#rekananshipping_name').val('');
		$('#rekananshipping_namereport').val('');
		$('#rekananshipping_address').val('');
		$('#rekananshipping_contactname').val('');
		$('#rekananshipping_contacthp').val('');
		$('#rekananshipping_contacttelp').val('');
		$('#rekananshipping_contactemail').val('');
		$('#rekananshipping_tax').val('');
		$('#single_1').val('');
		$("#single_1").val(null).trigger("change"); 
		$('#rekananshipping_npwp').val('');
		$('#rekananshipping_npwp_name').val('');
		$('#rekananshipping_npwp_addr').val('');
		$('#rowid').val('');
		$('#single_2').val('');
		$("#single_2").val(null).trigger("change"); 
		$('#rekananshipping_desc').val('');
  });
});

</script>


<div class="row">
	<div class="col-md-1">                
			<?php	
					echo anchor(
						site_url('rekanan_thd'),
						'<i class="glyphicon glyphicon-list"></i>',
						'class="btn btn-success btn-sm" data-tooltip="tooltip" data-placement="top" title="List Data"'
					);
			?> 
	</div>	
</div>
<br>

<div class="row">
	<div class="col-lg-12 col-md-12">		
		<?php 
                
               // echo create_breadcrumb();		
                $msg = $this->session->flashdata('message'); 
                if (!empty($msg))
				{
		?> 
				<div class="alert alert-success fade in ">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
				   <?php echo $msg; ?>
				</div>
		<?php
				}
                ?>
	</div>
</div><!-- /.row -->

<?php echo form_open(site_url('rekanan_thd/' . $action),'role="form" class="form-horizontal" id="form_master_rekanan" parsley-validate'); ?>   
               
 <div class="portlet light bordered"> 
 <div class="portlet-body form">
   
	<!--content--> 
	<div class="row">
		<div class="col-md-12">
		  <div class="portlet-body form">
		  
				   <div class="col-md-4 form-group row">
					<div class="col-xs-12">
					  <label>Rekanan</label>
					  <?php                  
					   echo form_input(
									array(
									 'name'         => 'rekanan_id',
									 'id'           => 'rekanan_id',                       
									 'class'        => 'form-control input-sm ',
									 'placeholder'  => 'Auto',
									 'maxlength'	=>	'7',
									 'readOnly'	=>	TRUE, 
										 'readOnly'		=> TRUE
									 ),
									 set_value('rekanan_id',$master_rekanan['rekanan_id'])
							   );             
					  ?>
					 <?php echo form_error('rekanan_id');?>
					</div>
				  </div> <!--/ Rekanan -->				  				 

					<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="rekanan_name" class="control-label">Name <span class="required-input">*</span></label>                               
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekanan_name',
										 'id'           => 'rekanan_name',                       
										 'class'        => 'form-control input-sm  required',
										 'placeholder'  => 'Rekanan Name',
										 'maxlength'=>'50', 
										 'readOnly'		=> TRUE
										 ),
										 set_value('rekanan_name',$master_rekanan['rekanan_name'])
								   );             
						  ?>
						 <?php echo form_error('rekanan_name');?> 
					</div>
				   </div><!--/ Rekanan Name -->
				   
				   <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="rekanan_namereport" class="control-label">Name Report <span class="required-input">*</span></label> 
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekanan_namereport',
										 'id'           => 'rekanan_namereport',                       
										 'class'        => 'form-control input-sm  required',
										 'placeholder'  => 'Rekanan Namereport',
										 'maxlength'=>'50', 
										 'readOnly'		=> TRUE
										 ),
										 set_value('rekanan_namereport',$master_rekanan['rekanan_namereport'])
								   );             
						  ?>
						 <?php echo form_error('rekanan_namereport');?> 
					</div>
				   </div><!--/ Rekanan Namereport -->
				   
				   <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="rekanan_address" class="control-label">Address <span class="required-input">*</span></label>                                   
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekanan_address',
										 'id'           => 'rekanan_address',                       
										 'class'        => 'form-control input-sm  required',
										 'placeholder'  => 'Rekanan Address',
										 'maxlength'=>'255', 
										 'readOnly'		=> TRUE
										 ),
										 set_value('rekanan_address',$master_rekanan['rekanan_address'])
								   );             
						  ?>
						 <?php echo form_error('rekanan_address');?> 
					</div>
				   </div><!--/ Rekanan Address -->
				   				   				  
				   
				   <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="rekanan_email" class="control-label">Email</label> 
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekanan_email',
										 'id'           => 'rekanan_email',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Rekanan Email',
										 'maxlength'=>'50', 
										 'readOnly'		=> TRUE
										 ),
										 set_value('rekanan_email',$master_rekanan['rekanan_email'])
								   );             
						  ?>
						 <?php echo form_error('rekanan_email');?> 
					</div>
				   </div><!--/ Rekanan Email -->
				   
				   <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="grouptenant_id" class="control-label">Group Tenant</label>   
						  <?php  
									 
							echo form_dropdown('grouptenant_id', $grouptenant_combo, $master_rekanan['grouptenant_id'],'class="form-control grouptenant" disabled ');				
						  ?>
						 <?php echo form_error('grouptenant_id');?>  
					</div>
				   </div> <!--/ Rekanan grouptenant_id --> 							 
				     			   
		  </div>
			</div>
	</div>
	 <!--end content-->
	 
	 </div> <!--/ Panel Body --> 
    </div> 

	<div class="form-actions top">   

    </div><!--/ Panel Footer --> 
	
	<?php echo form_close(); ?>  

<div class="row"> &nbsp; </div>	
 
	<div class="portlet-title"> 
			   <div class="portlet-body"> 
                    <div class="tabbable tabbable-tabdrop">
                      <ul class="nav nav-tabs">
                        <li class="active">
                          <a href="#tab1" data-toggle="tab">Brand Name</a>
                        </li>
                       
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                         <!-- tab trade name -->
						 <div class="portlet light">
						 
										<div class="tabbable tabbable-tabdrop">
										  <ul class="nav nav-tabs"> 
											 <li class="<?php echo ($tab == 'tab3') ? 'active' : ''; ?>" > 
											  <a href="#tab3" data-toggle="tab">List</a>
											</li> 
											 <li  class="<?php echo ($tab == 'tab4') ? 'active' : ''; ?>" > 
											  <a href="#tab4" data-toggle="tab" id="link">Form</a>
											</li>
											 <?php 
												if ($tab == 'tab4')
												{
											?>
                                           <script> 
										   		$(document).ready(function() {$("#sdk").focus();  })
                                           </script>
                                            <?php
												}
											?>
										  </ul>
										  <div class="tab-content">
											<div class="tab-pane <?php echo ($tab == 'tab3') ? 'active' : ''; ?>"  id="tab3"> 
												<div class="table-scrollable">
												 <div class="panel-body"> 
												 <?php if ($list_shipping) : ?>

												  <table class="table table-hover table-condensed">
													  
													<thead>
													  <tr>
														<th class="header">#</th>
														
															<th>Rekanan</th>   
														
															<th>Line</th>   
														
															<th>Name</th>
															
															<th>Namereport</th>   
														
															<th>Branch</th> 
															
															<th>Debtor Code</th>   
															
															<th>Tax</th>   
															
															<th>Type</th>   
														
															<th>Active</th>   
														  
														 <th class="red header" align="right" width="145">Aksi</th>
													  </tr>
													</thead>
													
													
													<tbody>
													 
													   <?php foreach ($list_shipping as $master_rekananshipping) : ?>
													  <tr>
														<td><?php echo $master_rekananshipping['row'];?> </td>
													   
													   <td><?php echo $master_rekananshipping['rekanan_id']; ?></td>
													   
													   <td><?php echo $master_rekananshipping['rekananshipping_line']; ?></td>
													   
													   <td><?php echo html_entity_decode($master_rekananshipping['rekananshipping_name']); ?></td>
													   
													   <td><?php echo html_entity_decode($master_rekananshipping['rekananshipping_namereport']); ?></td>  													  								
													   
													   <td><?php echo $master_rekananshipping['branch_name']; ?></td>  
													   
													   <td><?php echo $master_rekananshipping['rowid']; ?></td> 
													   
													   <td><?php echo $master_rekananshipping['rekananshipping_tax']; ?></td> 
													   
													   <td><?php echo $master_rekananshipping['type_name']; ?></td> 
													   
													   <td><?php if ( $master_rekananshipping['rekananshipping_isactive'] == 1 ) { ?>
														 <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
														<?php } else { ?>
														 <span class="cr"><i class="glyphicon glyphicon-unchecked"></i></span>
														<?php } ?> 
													      
															<td>
															<?php
																		  echo anchor(
																				  site_url('rekanan_thd/rekanan_shipping_edit/' . $master_rekananshipping['rekanan_id'].'/' .$master_rekananshipping['rekananshipping_line']),
																					'<i class="glyphicon glyphicon-edit"></i>',
																					'class="btn btn-sm btn-success" data-tooltip="tooltip" data-placement="top" title="Edit" id="editShipping"'
																				  );
														   ?>
														   		 
														</td>
													  </tr>     
													   <?php endforeach; ?>
													</tbody>
												  </table>
												  <?php else: ?>
														 <?php  echo '<p class="label label-info">Data Trade Name belum tersedia</p>';?>
												  <?php endif; ?>
												</div> 
												</div> 
												
											</div>
											
											<div class="tab-pane <?php echo ($tab == 'tab4') ? 'active' : ''; ?>"  id="tab4" >
                                          
											  <p> 
												<?php echo  $form_viewShipping; ?>
											  </p>
											</div>
											 
										  </div>
										</div> 
						</div>
                        </div> 
                      </div>
                    </div> 
				</div> 
	</div>  
