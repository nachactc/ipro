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

<?php echo form_open(site_url('master_rekanan/' . $action),'role="form" class="form-horizontal" id="form_master_rekanan" parsley-validate'); ?>   
               
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
						<label for="rekanan_badanhukum" class="control-label">Badan Hukum</label>                                  
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekanan_badanhukum',
										 'id'           => 'rekanan_badanhukum',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Rekanan Badanhukum',
										 'maxlength'=>'15', 
										 'readOnly'		=> TRUE
										 ),
										 set_value('rekanan_badanhukum',$master_rekanan['rekanan_badanhukum'])
								   );             
						  ?>
						 <?php echo form_error('rekanan_badanhukum');?> 
					</div>
				   </div><!--/ Rekanan Badanhukum -->

				   
				   <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						 <label for="rekanan_isdisabled" class="control-label">Disabled</label>  
						  <?php  
							$data = array(
									'name'          => 'rekanan_isdisabled',
									'id'            => 'rekanan_isdisabled',
									'value'         => $master_rekanan['rekanan_isdisabled'],
									'checked'       => FALSE, 
									'disabled'		=> TRUE
								);    
							echo form_checkbox($data);					
						  ?>
						 <?php echo form_error('rekanan_isdisabled');?>   
					</div>
				   </div><!--/ Rekanan Isdisabled -->
				   
				   <div class="row">&nbsp;</div>
				   
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
						<label for="rekanan_city" class="control-label">City</label>                               
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekanan_city',
										 'id'           => 'rekanan_city',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Rekanan City',
										 'maxlength'=>'50', 
										 'readOnly'		=> TRUE
										 ),
										 set_value('rekanan_city',$master_rekanan['rekanan_city'])
								   );             
						  ?>
						 <?php echo form_error('rekanan_city');?> 
					</div>
				   </div><!--/ Rekanan City -->
				   
				   <div class="col-md-4 form-group row">
					<div class="col-xs-12">
							<label for="rekanan_telp" class="control-label">Telp</label> 
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'rekanan_telp',
											 'id'           => 'rekanan_telp', 
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Rekanan Telp',
											 'maxlength'=>'50', 
											'readOnly'		=> TRUE
											 ),
											 set_value('rekanan_telp',$master_rekanan['rekanan_telp'])
									   );             
							  ?>
							 <?php echo form_error('rekanan_telp');?> 
					</div>
					
				   </div><!--/ Rekanan Telp -->
				   
				   <div class="col-md-4 form-group row">
					<div class="col-xs-12">
							<label for="rekanan_telp" class="control-label">No.HP</label> 
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'rekanan_nohp',
											 'id'           => 'rekanan_nohp',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Rekanan HP',
											 'maxlength'=>'50', 
										 'readOnly'		=> TRUE
											 ),
											 set_value('rekanan_nohp',$master_rekanan['rekanan_nohp'])
									   );             
							  ?>
							 <?php echo form_error('rekanan_nohp');?> 
					</div>
				   </div><!--/ Rekanan HP -->
				   
				   <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="rekanan_fax" class="control-label">Fax</label> 
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekanan_fax',
										 'id'           => 'rekanan_fax',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Rekanan Fax',
										 'maxlength'=>'50', 
										 'readOnly'		=> TRUE
										 ),
										 set_value('rekanan_fax',$master_rekanan['rekanan_fax'])
								   );             
						  ?>
						 <?php echo form_error('rekanan_fax');?> 
					</div>
				   </div><!--/ Rekanan Fax -->
				   
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
				   
				   <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="deduct" class="control-label">Deduct</label>  
						  <?php  
									$options = array(
									'0'         => 'Deduct by Tenant',
									'1'         => 'Deduct by LandLord',
							);
		 
							echo form_dropdown('deduct', $options, $master_rekanan['deduct'],'class="form-control select2" id="single" disabled');				
						  ?>
						 <?php echo form_error('rekanan_isdisabled');?>  
					</div>
				   </div><!--/ Rekanan deduct -->
				   
				   <div class="row">&nbsp;</div>
				   
				   <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="deduct" class="control-label">NPWP</label>  
						   <?php                  
						   echo form_input(
										array(
										 'name'         => 'taxsign_id',
										 'id'           => 'taxsign_id',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'NPWP', 
										 'readOnly'		=> TRUE 
										 ),
										 set_value('taxsign_id',$master_rekanan['taxsign_id'])
								   );             
						  ?>
						 <?php echo form_error('rekanan_pkpname');?> 
					</div>
				   </div><!--/ Rekanan pkpname -->
				       
				   <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="deduct" class="control-label">PKP Name</label>  
						   <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekanan_pkpname',
										 'id'           => 'rekanan_pkpname', 
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'PKP Name', 
										 'readOnly'		=> TRUE 
										 ),
										 set_value('rekanan_pkpname',$master_rekanan['rekanan_pkpname'])
								   );             
						  ?>
						 <?php echo form_error('rekanan_pkpname');?> 
					</div>
				   </div><!--/ Rekanan pkpname -->
				       
				   <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="deduct" class="control-label">NIK</label>  
						   <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekanan_taxnik',
										 'id'           => 'rekanan_taxnik',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'NIK', 
										 'readOnly'		=> TRUE
										 ),
										 set_value('rekanan_taxnik',$master_rekanan['rekanan_taxnik'])
								   );             
						  ?>
						 <?php echo form_error('rekanan_taxnik');?> 
					</div>
				   </div><!--/ Rekanan NIK -->
				      
				   <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="deduct" class="control-label">Alamat NPWP</label>  
						    <?php                  
						   echo form_textarea(
									array(
										'id'            =>'rekanan_taxaddress',
										'name'          =>'rekanan_taxaddress',
										'rows'          =>'3',
										'class'         =>'form-control input-sm ',
										'placeholder'   =>'Desc',
										'maxlength'=>'250', 
										 'readOnly'		=> TRUE
										),
									set_value('rekanan_taxaddress',$master_rekanan['rekanan_taxaddress'])                           
									);             
						  ?>
						  
						 <?php echo form_error('rekanan_taxaddress');?> 
					</div>
				   </div><!--/ Rekanan pkpname -->
				       
				   <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="deduct" class="control-label">Tax Prefix</label>  
						   <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekanan_taxprefix',
										 'id'           => 'rekanan_taxprefix',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Tax Prefix', 
										 'readOnly'		=> TRUE
										 ),
										 set_value('rekanan_taxprefix',$master_rekanan['rekanan_taxprefix'])
								   );             
						  ?>
						 <?php echo form_error('rekanan_taxprefix');?> 
					</div>
				   </div><!--/ Rekanan Tax -->
				     			   
		  </div>
			</div>
	</div>
	 <!--end content-->
	 
	 </div> <!--/ Panel Body --> 
    </div> 

	<div class="form-actions top">   
          <div class="row"> 
             <div class="col-md-4 ">  
				&nbsp;
              </div>
          </div>
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
														
															<th>Contactname</th>   
														
															<th>Contacthp</th>   
														
															<th>Contacttelp</th>   
														
															<th>Contactemail</th>     
														
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
													   
													   <td><?php echo $master_rekananshipping['rekananshipping_contactname']; ?></td>
													   
													   <td><?php echo $master_rekananshipping['rekananshipping_contacthp']; ?></td>
													   
													   <td><?php echo $master_rekananshipping['rekananshipping_contacttelp']; ?></td>
													   
													   <td><?php echo $master_rekananshipping['rekananshipping_contactemail']; ?></td> 
													   
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
																				  site_url('rekanan_utilities/rekanan_shipping_edit/' . $master_rekananshipping['rekanan_id'].'/' .$master_rekananshipping['rekananshipping_line']),
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
