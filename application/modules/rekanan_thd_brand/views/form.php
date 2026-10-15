 
<script>
var optID = '';
var optName = '';

 function enableTxt(elem) {
    // var id = $(elem).attr("id"); 
	console.log('LOG');
	var s = $(elem).closest('td').find('input:text').val();
	if($(elem).is(":checked")) { 
		 $(elem).closest('td').find('input:text').val(1);
	} 
	else
	{
		 $(elem).closest('td').find('input:text').val(0);
	}
}
$(document).ready(function() {
	
   
    $('.store').select2({
		 placeholder: 'Pilih Data', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
	}); 
	
	
	$('.deci').number( true, 2 );
    

 
});
</script>
<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

#listrikTab th, #listrikTab td, #listrikTab label {

    font-size: 9pt;
    white-space: nowrap;
}
 

#airTab th, #airTab td, #airTab label {

    font-size: 9pt;
    white-space: nowrap;    
}

#gasTab th, #gasTab td, #gasTab label {
    font-size: 9pt;
    white-space: nowrap;    
}

#listrikLoader th, #listrikLoader td, #listrikLoader label {
    font-size: 9pt;
    white-space: nowrap;    
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
 

<?php echo form_open(site_url('rekanan_thd_brand/' . $action),'role="form" class="form-horizontal" id="form_master_rekananshipping" parsley-validate'); ?>               
 
<!--content--> 
	<div class="row">
		<div class="col-md-12">
		  <div class="portlet-body form">
				
			  <div class="col-md-4 form-group row">
					<div class="col-xs-12">
					  <label for="rekananshipping_line" class="control-label">Line</label> 
					  <?php       
					   $lineid = $rekanan_thd_brand['rekananshipping_line'] == '' ? $line : $rekanan_thd_brand['rekananshipping_line'];
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
					   <input type="checkbox" name="rekananshipping_isactive"  value="1" <?php echo ($rekanan_thd_brand['rekananshipping_isactive'] == '0' ? null : 'checked' ); ?> class="form-control input-checkbox" disabled>  
					 <?php echo form_error('rekananshipping_isactive');?>  
					</div>
				</div><!--/ Rekananshipping Isactive --> 
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="rekananshipping_name" class="control-label">Trade Name <span class="required-input">*</span></label> 
						  <input type="text" id="rekananshipping_name" name="rekananshipping_name" value="<?php   
								echo htmlspecialchars_decode ($rekanan_thd_brand['rekananshipping_name'], ENT_QUOTES ); ?>" id="rekananshipping_name" class="form-control input-sm  required" placeholder="Name" maxlength="100" readonly>
							 
							 <?php echo form_error('rekananshipping_name');?> 
					</div>
				</div><!--/ Rekananshipping Name -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="rekananshipping_namereport" class="control-label">Name Report <span class="required-input">*</span></label> 
						  <input type="text" name="rekananshipping_namereport" value="<?php   
								echo htmlspecialchars_decode ($rekanan_thd_brand['rekananshipping_namereport'], ENT_QUOTES ); ?>" id="rekananshipping_namereport" class="form-control input-sm  required" placeholder="Name Report" maxlength="250" readonly> 
							 <?php echo form_error('rekananshipping_namereport');?> 
					</div>
				</div> <!--/ Rekananshipping Namereport -->
				
				<div class="col-md-4 form-group row">
						<div class="col-xs-12 ">
								*<label for="branch_id" class="control-label">Store</label>                                   
									<?php                  
									echo form_dropdown(
											'branch_id',
											$combo_branch,  
											set_value('branch_id',$rekanan_thd_brand['branch_id']),
											'class="form-control dropdown store" id="branch_id" style="width:100%;" disabled'
											);   
								
									?>
									
								<?php echo form_error('branch_id');?> 
						</div>
					</div><!--/ Branch -->
			

				<div class="col-md-4 form-group row">
					<div class="col-xs-12 ">
								<label for="thdtype_id" class="control-label">THD Type</label>                                   
								<?php                  
								echo form_dropdown(
										'thdtype_id',
										$thdtype,  
										set_value('thdtype_id',$rekanan_thd_brand['thdtype_id']),
										'class="form-control dropdown store" id="thdtype_id" style="width:100%;"'
										);   
							
								?>
								
							<?php echo form_error('thdtype_id');?> 
					</div>
				</div><!--/ Tipe THD -->	


				<div class="col-md-4 form-group row">
					<div class="col-xs-12 ">
								<label for="thdgroup_id" class="control-label">THD Group</label>                                   
								<?php                  
								echo form_dropdown(
										'thdgroup_id',
										$thdgroup,  
										set_value('thdgroup_id',$rekanan_thd_brand['thdgroup_id']),
										'class="form-control dropdown store" id="thdgroup_id" style="width:100%;"'
										);   
							
								?>
								
							<?php echo form_error('thdgroup_id');?> 
					</div>
				</div><!--/ Group THD -->	

				<div class="col-md-4 form-group row">
					<div class="col-xs-12 ">
								<label for="thdcat_id" class="control-label">THD Category</label>                                   
								<?php          
								echo form_dropdown(
										'thdcat_id',
										$thdcat,  
										set_value('thdcat_id',$rekanan_thd_brand['thdcat_id']),
										'class="form-control dropdown store" id="thdcat_id" style="width:100%;"'
										);   
							
								?>
								
							<?php echo form_error('thdcat_id');?> 
					</div>
				</div><!--/ Kategori THD -->	


				<div class="col-md-4 form-group row">
					<div class="col-xs-12 ">
								<label for="thdlt_id" class="control-label">THD Lantai</label>                                   
								<?php          
								echo form_dropdown(
										'thdlt_id',
										$thdlt,  
										set_value('thdlt_id',$rekanan_thd_brand['thdlt_id']),
										'class="form-control dropdown store" id="thdlt_id" style="width:100%;"'
										);   
							
								?>
								
							<?php echo form_error('thdlt_id');?> 
					</div>
				</div><!--/ Lantai THD -->	

																		
				
				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						   <label for="rekananthd_mg" class="control-label">Minimum Guarantee</label>                                  
							  <?php  							
							   echo form_input(
											array(
											 'name'         => 'rekananthd_mg',
											 'id'           => 'rekananthd_mg', 
											 'class'        => 'form-control input-sm deci',
											 'placeholder'  => 0,
											 'style'        => 'text-align: right',
											 'value' 				=> $rekanan_thd_brand['rekananthd_mg']
											 )											
									   );  
							  ?>
							 <?php echo form_error('rekananthd_mg');?> 
					</div>
				</div><!--/ Minimum Guarantee -->


				<div class="col-md-4 form-group row ">
					<div class="col-xs-12">
						   <label for="rekananthd_remarks" class="control-label">Remarks</label>                                  
							  <?php  							
							   echo form_input(
											array(
											 'name'         => 'rekananthd_remarks',
											 'id'           => 'rekananthd_remarks', 
											 'class'        => 'form-control input-sm',
											 'placeholder'  => 'Notes',
											 'value' 				=> $rekanan_thd_brand['rekananthd_remarks']
											 )											
									   );  
							  ?>
							 <?php echo form_error('rekananthd_remarks');?> 
					</div>
				</div><!--/ Remarks -->


				<div class="col-md-8 form-group row">
					<div class="col-xs-12">
						   <label for="rekananthd_comterms" class="control-label">Commercial Terms</label>                                  
							  <?php  							
							   echo form_textarea(
											array(
											 'name'         => 'rekananthd_comterms',
											 'id'           => 'rekananthd_comterms', 
											 'class'        => 'form-control input-sm',
											 'placeholder'  => 'Terms',
											 'value' 				=> $rekanan_thd_brand['rekananthd_comterms'],
											 'rows'         => 2
											 )											
									   );  
							  ?>
							 <?php echo form_error('rekananthd_comterms');?> 
					</div>
				</div><!--/ Commercial Terms -->
				
				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
					                                    
					  <?php                  
					   echo form_input(
									array(
									 'name'         => 'hbranch',
									 'id'           => 'hbranch',                       
									 'class'        => 'form-control input-sm ',
									 'placeholder'  => 'Debtor Code',
									 'maxlength'=>'500',
									 'readonly'=>TRUE,
									 'type' =>'hidden',
									 ),
									 set_value('branch_id',$rekanan_thd_brand['branch_id'])
							   );             
					  ?>
					 <?php echo form_error('branch_id');?> 
					</div>
				</div> <!--/ branch ID -->
				
				<div class="row">&nbsp;</div>
				<div class="form-actions top">   
				  <div class="row"> 
					 	<div class="col-md-4"> 
							<div class="col-xs-12">
								<button type="submit" class="btn green" name="post">
									<i class="glyphicon glyphicon-floppy-save"></i> Submit
								</button>                  
							</div>
					  </div>
				  </div>
				</div><!--/ Panel Footer --> 
				
			</div> 
		</div>  
	</div>  
	 
<?php echo form_close(); ?>  