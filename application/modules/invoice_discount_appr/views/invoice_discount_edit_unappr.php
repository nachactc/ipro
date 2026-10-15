<script src="<?php echo base_url('/assets/js/bootbox/bootbox.min.js');?>"></script>
<script>
	
	$(document).ready(function(){
		$("#tabedit").trigger('click'); 
		$.fn.datepicker.defaults.format = "yyyy-mm-dd"; 
		$.fn.datepicker.defaults.autoclose = true; 
		
		$("#btsub").click(function(){
			confirmSubmit();
		}); 
		
	});
	
	$(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );
	
	function confirmSubmit() {
		// Confirm box
		bootbox.confirm(
		{
			message: "Anda Yakin Untuk UnApprove Discount ini ?",
			buttons:
			{
				confirm:
				{
					label: 'Yes',
					className: 'btn btn-sm btn-primary waves-effect waves-themed'
				},
				cancel:
				{
					label: 'No',
					className: 'btn btn-sm btn-danger waves-effect waves-themed'
				}
			},
			callback: function(result)
			{
				//yes result / bool true 
				if(result){     
					$('#formF').submit();
				}
			}
		});
	
	};
	
</script>

<style>
	
	table.dataTable td {
    padding:2px;
    font-size: 9pt;        
	}
	
	.table td{
    padding:2px;
    font-size: 9pt;    
    font-family:  Arial, Verdana, sans-serif;
	
	}
	
	label {
	font-size: 9pt;
	}
	
	.nowrap {
	white-space:nowrap;
    }
	
</style>
   
<!-- CONTENT -->
<div class="row">
	<div class="col-md-12">
		<div class="portlet">
			<div class="portlet-title">
				 
				<div class="tools">
					<a href="javascript:;" class="collapse"> </a>
					<a href="#portlet-config" data-toggle="modal" class="config"> </a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="tabbable-custom ">
					<ul class="nav nav-tabs ">
                        <li class="active">
							<a href="<?php echo base_url('index.php/invoice_discount_appr/invoice_discount_appr/invoice_discount_unappr_status'); ?>" id='tablist'> LIST </a>
						</li>
                        <li>
                            <a href="#" id='tabdata'> INPUT </a>
						</li>
                        <li>
							<a href="#editdata" data-toggle="tab"  id='tabedit'> VIEW </a>
						</li>
					</ul>
					<div class="tab-content">
                        <div class="tab-pane" id="editdata">
							<div class="portlet-body form">
								<form action="<?php echo site_url('invoice_discount_appr/invoice_discount_appr/unapproval_discount');?>" method="post" id="formF">
									<?php
										if(isset($result)){
											//print_r($result);
											foreach($result as $row){ ?>
											<div class="row">
												<div class="col-md-12">
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Tenant.</label>
															<input readonly type="text" id="txttenant" name="txtinv" class="form-control input-sm" value = "<?php echo $row->rekanan_name;?>" >
														</div>
													</div>
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Trade Name.</label>
															<input readonly type="text" id="txttradename" name="txtinv" class="form-control input-sm" value = "<?php echo $row->rekananshipping_name;?>">
														</div>
													</div>
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Schedule Payment ID</label>
															<input  type="text" id="txtspid" name="txtspid" class="form-control input-sm" value = "<?php echo $row->schedulepayment_id;?>" readonly>
															<input  type="hidden" id="txtspln" name="txtspln" class="form-control input-sm" value = "<?php echo $row->schedulepaymentdiscount_line;?>" readonly>
															<input  type="hidden" id="txtagid" name="txtagid" class="form-control input-sm" value = "<?php echo $row->agreementtype_id;?>">
															<input  type="hidden" id="txtspposted" name="txtspposted" class="form-control input-sm" value = "<?php echo $row->schedulepaymentdiscount_type;?>">
															
															
														</div>
													</div>
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Invoice No.</label>
															<input readonly type="text" id="txtinv" name="txtinv" class="form-control input-sm" value = "<?php echo $row->invoice_id;?>" readonly>
														</div>
													</div>
													
													
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Schedule Payment Line</label>
															<input  type="text" id="txtspline" name="txtspline" class="form-control input-sm" readonly value = "<?php echo $row->schedulepaymentdiscount_line;?>" readonly>
														</div>
													</div>
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Date</label>
															<div class="input-group date" data-provide="datepicker">
																<div class="input-group-addon">
																	<i class="fa fa-calendar"></i>
																</div>
																<input type="text" class="form-control input-sm pull-right" id="txtdate" name="txtdate" value = "<?php echo date('d-m-Y',strtotime($row->tgl));?>" readonly>
															</div>
														</div>
													</div>
													
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Invoice Amount</label>
															<input readonly type="text" id="txtamountinv" name="txtamountinv" class="form-control input-sm" value = "<?php echo number_format($row->schedulepaymentdetil_idr);?>" readonly>
														</div>
													</div>
													
													
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Discount (%)</label>
															<input  type="text" id="txtdiscprosen" name="txtdiscprosen" class="form-control input-sm" value = "<?php echo intval($row->schedulepaymentdiscount_percent);?>" readonly>
														</div>
													</div>
													 
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Discount (IDR)</label>
															<input  type="text" id="txtdiscidr" name="txtdiscidr" class="form-control input-sm" value = "<?php echo number_format($row->schedulepaymentdiscount_idr);?>" readonly>
														</div>
													</div>
													
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<div class="form-check">
																<label class="form-check-label" for="defaultCheck2">
																	Posted
																</label>
																<input class="form-control input-sm" type="checkbox" id="defaultCheck2" disabled>
															</div>
														</div>
													</div>
													
													<div class="col-md-10 form-group row">
														<div class="col-xs-12">
															<label>Description</label>
															<textarea id="txtdesc" name="txtdesc" class="form-control input-sm" rows="5" readonly>
															<?php echo $row->schedulepaymentdiscount_descr;?></textarea>
														</div>
													</div> 

													<div class="row"> &nbsp; </div>	                              
													
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Created By</label>
															<input  type="text" id="txtdiscprosen" name="txtdiscprosen" class="form-control input-sm" value = "<?php echo ($row->createdby);?>" readonly>
														</div>
													</div>
													
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Created Date</label>
															<input  type="text" id="txtdiscprosen" name="txtdiscprosen" class="form-control input-sm" value = "<?php echo ($row->createddate != '') ? date('d-m-Y',strtotime($row->createddate)) : '';?>" readonly>
														</div>
													</div>
													
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Modified By</label>
															<input  type="text" id="txtdiscprosen" name="txtdiscprosen" class="form-control input-sm" value = "<?php echo ($row->modifiedby);?>" readonly>
														</div>
													</div>
													
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Modified Date</label>
															<input  type="text" id="txtdiscprosen" name="txtdiscprosen" class="form-control input-sm" value = "<?php echo ($row->modifieddate != '') ? date('d-m-Y',strtotime($row->modifieddate)) : ''; 
															?>" readonly>
														</div>
													</div>
													
													<!-- /.col -->
													<div class="col-xs-12">
														<br />
														<?php 
														if($userauth_approve){ 
															if($userauth_done_unapprove){
														?>
														<input type="BUTTON" value="UNAPPROVE" class="btn btn-sm btn-info" id="btsub"  />
														<?php 
															} else {
														?>
														<a href="<?php echo base_url('index.php/invoice_discount_appr/invoice_discount_appr/invoice_discount_unappr_status');?>" class="btn btn-sm btn-info">
														Anda sudah UNAPPROVE Data Ini.
														</a>
														<?php
															}
														} 
														else
														{
														?> 
														<a href="<?php echo base_url('index.php/invoice_discount_appr/invoice_discount_appr/invoice_discount_unappr_status');?>" class="btn btn-sm btn-info">
														BACK
														</a>
														<?php } ?>
													</div>
													
												</div>
											</div>
										</form>
									<?php }}?>
									
							</div>
						</div>
						
						<!-- /.col -->
						
						
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<!-- END OF CONTENT -->
