<?php
	
	// If access is requested from anywhere other than index.php then exit
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
?>
<!-- BEGIN Page Wrapper -->
<div class="page-wrapper">
	<div class="page-inner">
		<!-- BEGIN Left Aside -->
		<?php
			echo $this->custom_templates->page_navigation($username,$user_fullname,$user_email,$user_avatar,$user_company);
		?>			
		<!-- END Left Aside -->
		
		<div class="page-content-wrapper">			
			<!-- BEGIN Page Header -->
			<?php					
				echo $this->custom_templates->page_header($user_fullname,$user_email,$username,$user_avatar);
			?>
			<!-- END Page Header -->	
			
			<!-- BEGIN Page Content -->
			<!-- the #js-page-content id is needed for some plugins to initialize -->
			<main id="js-page-content" role="main" class="page-content">
				<ol class="breadcrumb page-breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url(custom_constants::running_modules) ?>">Home</a></li>
					<li class="breadcrumb-item"><?php echo ucwords(decodeString($parent)); ?></li>
					<li class="breadcrumb-item active"><?php echo ucwords(decodeString($child)); ?></li>
					<li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
				</ol>
				<div class="subheader">
					<h1 class="subheader-title">
						<i class='subheader-icon fal fa-table'></i> 
						<?php
							$key = count($page_title);
							if ($key > 0){
								$i = 0;
								foreach ($page_title as $name){
									if ($i==0){
										echo ucwords($page_title[$i]);
										}else{
										echo " <span class='fw-300'>". ucwords($page_title[$i])."</span> \n";
									}
									$i++;
								}
							}
						?>
						<small>
							list of records
						</small>
					</h1>
					<div class="subheader-block">
						<!-- Right Text -->                                                          
					</div>
				</div>
				
				<div class="row">
					<div class="col-xl-12">
						<div id="panel-1" class="panel">
							<div class="panel-hdr">
								<h2>
									<!-- Empty space --> 
								</h2>
								<div class="panel-toolbar">
									<button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
									<button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
									<button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
								</div>
							</div>
							<div class="panel-container show">
								<div class="panel-content">
									<form id="defaultForm" name="defaultForm" method="POST" target="_blank">
										<input type="hidden" name="trigerbt" value="submit" />
										<div class="card card-body">
											
											<!--<div class="row">												
												<div class="col-md-6 form-group">
													<label class="form-label" for="txtUnitID">Periode</label>
													<div class="input-group flex-nowrap">
														<?php
																//echo form_dropdown('cboperiode', $fillperiode, !empty($post['acc_grouping'])?$post['acc_grouping']:'' ,'id="cboperiode" class="form-control"'); 
															?>
														
													</div>
												</div>   
											</div>-->
												<div class="form-row mt-2 mb-2">
                                                    <div class="col-md-12 form-group">    
														<label class="form-label" for="cboReportType">Type Report</label>
														<div class="input-group flex-nowrap">
															<div class="input-group-prepend">
																	<span class="input-group-text"><i class="fal fa-building fs-xl"></i></span>
															</div>
															<?php echo form_dropdown('cboReportType', $fillreporttype, $report, 'id ="cboReportType" class="form-control" style="width: 100%;"  required '); ?>
														</div>
													</div>
												</div>
												<div class="form-row mt-2 mb-2">
													<div class="col-md-6 form-group">    
															<label class="form-label" for="cboRegionName">Region Name</label>
															<div class="input-group flex-nowrap">
																<div class="input-group-prepend">
																	<span class="input-group-text"><i class="fal fa-building fs-xl"></i></span>
																</div>
																<?php echo form_dropdown('cboRegionName', $fillcboregion, !empty($post['region_id']) ? $post['region_id'] : '', 'id ="cboRegionName" class="form-control" style="width: 100%;" disabled  '); ?>
															</div>
														</div>
													<div class="col-md-6 form-group">    
															<label class="form-label" for="cboBranchName">Branch Name</label>
															<div class="input-group flex-nowrap">
																<div class="input-group-prepend">
																	<span class="input-group-text"><i class="fal fa-building fs-xl"></i></span>
																</div>
																<?php echo form_dropdown('cboBranchName', $fillcbobranch, !empty($post['branch_id']) ? $post['branch_id'] : '', 'id ="cboBranchName" class="form-control" style="width: 100%;" disabled '); ?>
															</div>
														</div>
                                                                                                        
                                                                                                        
												</div>
												<div class="form-row mb-2">
													<div class="col-md-6 form-group">    
																<label class="form-label" for="cboAccountName">Account Name</label>
																<div class="input-group flex-nowrap">
																	<div class="input-group-prepend">
																		<span class="input-group-text"><i class="fal fa-list fs-xl"></i></span>
																	</div>
																	<?php echo form_dropdown('cboAccountName', $fillcoa, '', 'id ="cboAccountName" class="form-control" style="width: 100%;"  '); ?>
																	<!--<select data-placeholder="Select Account ..." class="js-data-account-ajax form-control" id="cboAccountName" name="cboAccountName"  ></select>-->
																</div>
															</div>
													<div class="col-md-6 form-group">    
																<label class="form-label" for="cboGroupAccount">Group Account</label>
																<div class="input-group flex-nowrap">
																	<div class="input-group-prepend">
																		<span class="input-group-text"><i class="fal fa-list fs-xl"></i></span>
																	</div>
																	<?php echo form_dropdown('cboGroupAccount', $groupcoa, '', 'id ="cboGroupAccount" class="form-control" style="width: 100%;"  '); ?>
																	<!--<select data-placeholder="Select Account ..." class="js-data-account-ajax form-control" id="cboAccountName" name="cboAccountName"  ></select>-->
																</div>
															</div>
													

												</div>
												<div class="form-row mb-2">
													<div class="col-md-6 form-group">
														<label class="form-label" id="labelEndDate" for="txtPeriodeEnd">End Date</label>
														<div class="input-group flex-nowrap">
															<div class="input-group-prepend">
																<span class="input-group-text"><i class="fal fa-calendar fs-xl"></i></span>
															</div>
															<input type="text" id="txtPeriodeEnd" name="txtPeriodeEnd" class="form-control " value="<?php echo $endDate_select; ?>" placeholder="Select date" autocomplete="off" required>
														</div>
													</div>												
												</div>

												


											
											<div class="row mt-2">
												
												<div class="col-md-6 form-group">

													<div class="input-group flex-nowrap">
														<!--<button type="submit"  id="btload" name="btload" class="btn btn-sm btn-info waves-effect waves-themed mr-2 " >
															<span class="fal fa-search-plus mr-1"></span>
															
															Load Report
														</button>-->
														
														<button type="button"  id="btload2" name="btload2" class="btn btn-sm btn-info waves-effect waves-themed mr-2" >
															<span class="fal fa-search-plus mr-1"></span>
															
															Load Report to Excel
														</button>
														<!--
														<button type="button"  id="btload3" name="btload3" class="btn btn-sm btn-info waves-effect waves-themed mr-2" >
															<span class="fal fa-search-plus mr-1"></span>
															
															Load Report to Excel 2
														</button>-->
														
													</div>
												</div>   
												
											</div>
											
											
										</form>                                   
									</div>
								</div>
							</div>
						</div>
					</div>
				</main>
	
				<!-- this overlay is activated only when mobile menu is triggered -->
				<div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div> 
				<!-- END Page Content -->
            <!---Spinner --->                                                    
                <div class="panel" style="display: none;
                                        width:200px;
                                        height: 200px;
                                        position: fixed;
                                        top: 50%;
                                        left: 50%;
                                        text-align:center;
                                        margin-left: -50px;
                                        margin-top: -100px;
                                        z-index:9999;
                                        overflow: auto;
                                        opacity: 0.7;" 
                                        id="loading" aria-hidden="true"> 

                    <div class="panel-container">
                        <div class="panel-content">
                            <div class="d-flex justify-content-center mt-6">
                                <div class="spinner-border" style="width:4em; height:4em;"; role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <h5 class="title" style="text-align:center;">Load Data....</h5>
                        </div>
                    </div>

                </div>					
				
				<!-- BEGIN Page Footer -->
				<?php					
					echo $this->custom_templates->page_footer();
				?>					
				<!-- END Page Footer -->
				<!-- BEGIN Shortcuts -->
				<?php
					echo $this->custom_templates->page_shortcut();
				?>
				<!-- END Shortcuts -->					
		</div>			
	</div>
</div>
<!-- END Page Wrapper -->			



<div class="modal" id ="loadModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Loading ... </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="d-flex justify-content-center">
		  <div class="spinner-border" role="status">
			<span class="sr-only">Loading...</span>
		  </div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>	
