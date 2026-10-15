<script>
$(document).ready(function() {
 $('.combo_branch_id').select2({
		 placeholder: 'Pilih Data', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
	}); 
 $('.combo_semester_id').select2({
		 placeholder: 'Pilih Data', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
	}); 
 $('.combo_group_branchid').select2({
		 placeholder: 'Pilih Data', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
	}); 
}); 
</script> 
  <div class="portlet-body">
                    <div class="tabbable-custom ">
                      <ul class="nav nav-tabs ">
                        <li>
                           <a href="<?php echo base_url('index.php/semester'); ?>">LIST </a>
                        </li>
                        <li <?php echo ($tab == 'input') ?   "class='active'" :  ""; ?> >
                          <a href="<?php echo ($tab == 'input') ?   "#tab_input" :  base_url('index.php/semester/add'); ?>" 
						  <?php echo ($tab == 'input') ?   "data-toggle='tab'" :  ''; ?>> INPUT </a>
						   
                        </li>
                        <li <?php echo ($tab == 'edit') ?   "class='active'" :  ""; ?>>
						   <a href="<?php echo ($tab == 'edit') ?   "#tab_edit " :  base_url('index.php/semester/edit'); ?>" <?php echo ($tab == 'edit') ?   "data-toggle='tab'" :  ''; ?> > EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">  
						
                        <div class="tab-pane active" id=" <?php echo ($tab == 'input') ?   "tab_input" :  "tab_edit"; ?> ">
							<!-- input area -->
							
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
						
						<?php echo form_open(site_url($action),'role="form" class="form-horizontal" id="form_master_semesterbranch" parsley-validate'); ?>               
						<!--content--> 
						<div class="row">
							<div class="col-md-12">
							  <div class="portlet-body form">
								
									<div class="col-md-3 form-group row">
										<div class="col-xs-12">
										<label for="semester_id" class="control-label">Semester</label>
										<?php                  
										   echo form_dropdown(
													   'semester_id',
													   $get_semester,  
													   set_value('semester_id',$semester['semester_id']),
													   'class="form-control combo_semester_id"  id="semester_id"'
													   );               
										  ?>
										 <?php echo form_error('semester_id');?>
										</div>
									</div> <!--/ semester -->  
									
									<div class="col-md-3 form-group row">
										<div class="col-xs-12">
											<label for="branch_id" class="control-label">Branch </label>
											<?php                  
											   echo form_dropdown(
													   'branch_id',
													   $branch,  
													   set_value('branch_id',$semester['branch_id']),
													   'class="form-control combo_branch_id"  id="branch_id"'
													   );             
											  ?>
											 <?php echo form_error('branch_id');?>
											
										</div>
										
										</div> <!--/ branch_id -->
										
											<div class="col-md-3 form-group row">
											<div class="col-xs-12">
											<label for="group_branchid" class="control-label">Group Property</label>
											<?php                  
											   echo form_dropdown(
														   'group_branchid',
														   $get_groupbranch,  
														   set_value('group_branchid',$semester['group_branchid']),
														   'class="form-control combo_group_branchid"  id="group_branchid"'
														   );               
											  ?>
											 <?php echo form_error('group_branchid');?>
											</div>
										</div> <!--/ group branch -->
									
										<div class="col-md-3 form-group row">
											<div class="col-xs-12">
											 <label for="semester_year" class="control-label">Semester Year <span class="required-input">*</span></label>
											 <?php                  
											   echo form_input(
															array(
															 'name'         => 'semester_year',
															 'id'           => 'semester_year',                       
															 'class'        => 'form-control input-sm  required',
															 'placeholder'  => 'Semester Year',
															 'maxlength'=>'5'
															 ),
															 set_value('semester_year',$semester['semester_year'])
													   );             
											  ?>
											 <?php echo form_error('semester_year');?>
											</div>
										</div> <!--/ semester_year --> 
							  </div>
							   
							</div>
							
							<span> &nbsp;</span>  
								<div class="col-md-12"> 
									<span> &nbsp; </span>
									<span> &nbsp; </span>
									 <button type="submit" class="btn btn-md btn-info" name="post">
											<i class="glyphicon glyphicon-floppy-save"></i> Submit 
										</button>   
								</div> <!--/ button --> 
							<span> &nbsp;</span>  
							
						</div>
						
						<div class="row"> &nbsp; </div>
						<!--content--> 
						<?php echo form_close(); ?>  						
						<!-- input area -->
							
                        </div> 
						  
					 </div>
                    </div>
  </div>
               