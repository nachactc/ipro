<script>
$(document).ready(function() {
    $('.store').select2({
		 placeholder: 'Pilih Data', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
	}); 
});
</script>
<?php echo form_open(site_url('master_rekananshipping/' . $action),'role="form" class="form-horizontal" id="form_master_rekananshipping" parsley-validate'); ?>               
 
<!--content--> 
	<div class="row">
		<div class="col-md-12">
		  <div class="portlet-body form">
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
					  <label for="rekananshipping_line" class="control-label">Line</label> 
					  <?php       
					   $lineid = $master_rekananshipping['rekananshipping_line'] == '' ? $line : $master_rekananshipping['rekananshipping_line'];
					   echo form_input(
									array(
									 'name'         => 'rekananshipping_line',
									 'id'           => 'rekananshipping_line', 
									 'class'        => 'form-control input-sm',
									 'placeholder'  => 'Line',
									 'readonly'		=> TRUE, 
									 ),
									 set_value('rekananshipping_line',$lineid)
							   );             
					  ?>
					 <?php echo form_error('rekananshipping_line');?> 
					</div>
				</div><!--/ Rekananshipping Line -->
				<div class="col-md-4 form-group row">
					<div class="col-xs-12"> 
					<label for="rekananshipping_isactive" class="mt-checkbox">Active</label> 
					   <input type="checkbox" name="rekananshipping_isactive"  value="1" <?php echo ($master_rekananshipping['rekananshipping_isactive'] == '0' ? null : 'checked' ); ?> class="form-control input-checkbox">  
					 <?php echo form_error('rekananshipping_isactive');?>  
					</div>
				</div><!--/ Rekananshipping Isactive --> 
				
				<div class="row"> </div>
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="rekananshipping_name" class="control-label">Trade Name <span class="required-input">*</span></label> 
						  <input type="text" name="rekananshipping_name" value="<?php   
								echo htmlspecialchars_decode ($master_rekananshipping['rekananshipping_name'], ENT_QUOTES ); ?>" id="rekananshipping_name" class="form-control input-sm  required" placeholder="Name" maxlength="100">
							 
							 <?php echo form_error('rekananshipping_name');?> 
					</div>
				</div><!--/ Rekananshipping Name -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="rekananshipping_namereport" class="control-label">Name Report <span class="required-input">*</span></label> 
						  <input type="text" name="rekananshipping_namereport" value="<?php   
								echo htmlspecialchars_decode ($master_rekananshipping['rekananshipping_namereport'], ENT_QUOTES ); ?>" id="rekananshipping_namereport" class="form-control input-sm  required" placeholder="Name Report" maxlength="250"> 
							 <?php echo form_error('rekananshipping_namereport');?> 
					</div>
				</div> <!--/ Rekananshipping Namereport -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						 <label for="rekananshipping_address" class="control-label">Address <span class="required-input">*</span></label> 
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekananshipping_address',
										 'id'           => 'rekananshipping_address',                       
										 'class'        => 'form-control input-sm  required',
										 'placeholder'  => 'Address',
										 'maxlength'=>'500'
										 ),
										 set_value('rekananshipping_address',$master_rekananshipping['rekananshipping_address'])
								   );             
						  ?>
						 <?php echo form_error('rekananshipping_address');?> 
					</div>
				</div><!--/ Rekananshipping Address -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						 <label for="rekananshipping_contactname" class="control-label">Contactname</label>                                 
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekananshipping_contactname',
										 'id'           => 'rekananshipping_contactname',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Contact Name',
										 'maxlength'=>'50'
										 ),
										 set_value('rekananshipping_contactname',$master_rekananshipping['rekananshipping_contactname'])
								   );             
						  ?>
						 <?php echo form_error('rekananshipping_contactname');?>  
					</div>
				</div><!--/ Rekananshipping Contactname -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="rekananshipping_contacthp" class="control-label">Contact Hp</label>                                 
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekananshipping_contacthp',
										 'id'           => 'rekananshipping_contacthp',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Contact Hp',
										 'maxlength'=>'50'
										 ),
										 set_value('rekananshipping_contacthp',$master_rekananshipping['rekananshipping_contacthp'])
								   );             
						  ?>
						 <?php echo form_error('rekananshipping_contacthp');?> 
					</div>
				</div><!--/ Rekananshipping Contacthp -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="rekananshipping_contacttelp" class="control-label">Contact Telp</label>                               
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekananshipping_contacttelp',
										 'id'           => 'rekananshipping_contacttelp',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Contact Telp',
										 'maxlength'=>'50'
										 ),
										 set_value('rekananshipping_contacttelp',$master_rekananshipping['rekananshipping_contacttelp'])
								   );             
						  ?>
						 <?php echo form_error('rekananshipping_contacttelp');?> 
					</div>
				</div><!--/ Rekananshipping Contacttelp -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="rekananshipping_contactemail" class="control-label">Contact Email</label>                                 
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekananshipping_contactemail',
										 'id'           => 'rekananshipping_contactemail',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Contact Email',
										 'maxlength'=>'50'
										 ),
										 set_value('rekananshipping_contactemail',$master_rekananshipping['rekananshipping_contactemail'])
								   );             
						  ?>
						 <?php echo form_error('rekananshipping_contactemail');?> 
					</div>
				</div><!--/ Rekananshipping Contactemail -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						   <label for="rekananshipping_tax" class="control-label">Tax</label>                                  
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'rekananshipping_tax',
											 'id'           => 'rekananshipping_tax',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Tax',
											 
											 ),
											 set_value('rekananshipping_tax',$master_rekananshipping['rekananshipping_tax'])
									   );             
							  ?>
							 <?php echo form_error('rekananshipping_tax');?> 
					</div>
				</div><!--/ Rekananshipping Tax -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12 ">
						  *<label for="branch_id" class="control-label">Store</label>                                   
							  <?php                  
							   echo form_dropdown(
									   'branch_id',
									   $combo_branch,  
									   set_value('branch_id',$master_rekananshipping['branch_id']),
									   'class="form-control dropdown store" id="single_2" style="width:100%;"'
									   );             
							  ?>
							 <?php echo form_error('branch_id');?> 
					</div>
				</div><!--/ Branch -->
				<div class="row">&nbsp;</div> 
			    
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="rekananshipping_npwp" class="control-label">Npwp</label>                                 
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekananshipping_npwp',
										 'id'           => 'rekananshipping_npwp',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Npwp',
										 'maxlength'=>'100'
										 ),
										 set_value('rekananshipping_npwp',$master_rekananshipping['rekananshipping_npwp'])
								   );             
						  ?>
						 <?php echo form_error('rekananshipping_npwp');?> 
					</div>
				</div><!--/ Rekananshipping Npwp -->
				
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						 <label for="rekananshipping_npwp_name" class="control-label">Npwp Name</label>                                    
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekananshipping_npwp_name',
										 'id'           => 'rekananshipping_npwp_name',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Npwp Name',
										 'maxlength'=>'150'
										 ),
										 set_value('rekananshipping_npwp_name',$master_rekananshipping['rekananshipping_npwp_name'])
								   );             
						  ?>
						 <?php echo form_error('rekananshipping_npwp_name');?> 
					</div>
				</div>  <!--/ Rekananshipping Npwp Name --> 
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
					<label for="rekananshipping_npwp_addr" class="control-label">Npwp Addr</label>                                    
					  <?php                  
					   echo form_input(
									array(
									 'name'         => 'rekananshipping_npwp_addr',
									 'id'           => 'rekananshipping_npwp_addr', 
									 'class'        => 'form-control input-sm ',
									 'placeholder'  => 'Npwp Addr',
									 'maxlength'=>'500'
									 ),
									 set_value('rekananshipping_npwp_addr',$master_rekananshipping['rekananshipping_npwp_addr'])
							   );             
					  ?>
					 <?php echo form_error('rekananshipping_npwp_addr');?> 
					</div>
				</div> <!--/ Rekananshipping Npwp Addr -->
				
				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
					<label for="rekananshipping_npwp_addr" class="control-label">Debtor Code</label>                                    
					  <?php                  
					   echo form_input(
									array(
									 'name'         => 'rowid',
									 'id'           => 'rowid',                       
									 'class'        => 'form-control input-sm ',
									 'placeholder'  => 'Debtor Code',
									 'maxlength'=>'500',
									 'readonly'=>TRUE,
									 ),
									 set_value('rowid',$master_rekananshipping['rowid'])
							   );             
					  ?>
					 <?php echo form_error('rowid');?> 
					</div>
				</div> <!--/ Rekananshipping Debtor Code -->
				
				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
					<label for="rekananshipping_npwp_addr" class="control-label">Type
					</label>                                    
					  <?php                   
					   echo form_dropdown(
									   'rekananshipping_type',
									   $combo_shippingtype,  
									   set_value('rekananshipping_type',$master_rekananshipping['rekananshipping_type']),
									   'class="form-control store" id="single_1" style="width:100%;"'
									   );  
					  ?>
					 <?php echo form_error('rekananshipping_type');?> 
					</div>
				</div> <!--/ Rekananshipping Debtor Code -->
				
				 <div class="col-md-4 form-group row">
					<div class="col-xs-12">
					<label for="rekananshipping_npwp_addr" class="control-label">TAX</label>                                    
					  <?php                  
					   echo form_input(
									array(
									 'name'         => 'rekananshipping_tax',
									 'id'           => 'rekananshipping_tax', 
									 'class'        => 'form-control input-sm ',
									 'placeholder'  => 'TAX',
									 'maxlength'=>'500'
									 ),
									 set_value('rekananshipping_tax',$master_rekananshipping['rekananshipping_tax'])
							   );             
					  ?>
					 <?php echo form_error('rekananshipping_npwp_addr');?> 
					</div>
				</div> <!--/ Rekananshipping Npwp Addr -->
				
				<div class="row">&nbsp;</div> 
				 <div class="col-md-12 form-group row">
					<div class="col-xs-12">
						  <label for="rekananshipping_desc" class="control-label">Description</label>                                   
						  <?php                  
						   echo form_textarea(
									array(
										'id'            =>'rekananshipping_desc',
										'name'          =>'rekananshipping_desc',
										'rows'          =>'3',
										'class'         =>'form-control input-sm ',
										'placeholder'   =>'Desc',
										'maxlength'=>'250'
										),
									set_value('rekananshipping_desc',$master_rekananshipping['rekananshipping_desc'])                           
									);             
						  ?>
						 <?php echo form_error('rekananshipping_desc');?> 
					</div>
				</div><!--/ Rekananshipping Desc -->
				
				
				<div class="row">&nbsp;</div>
				<div class="form-actions top">   
				  <div class="row"> 
					 <div class="col-md-4"> 
						<div class="col-xs-12">
							<button type="submit" class="btn green" name="post">
								<i class="glyphicon glyphicon-floppy-save"></i> Submit Trade
							</button>                  
					  </div>
					  </div>
				  </div>
				</div><!--/ Panel Footer --> 
				
			</div> 
		</div>  
	</div>  
	 
<?php echo form_close(); ?>  