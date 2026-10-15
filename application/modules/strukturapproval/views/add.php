<?php $chid=get_setting("channel_id");?>
<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

#jDetil th, #jDetil td, #jDetil label {
    font-size: 9pt;
    white-space: nowrap;    
}

#chargeTab th, #chargeTab td, #chargeTab label {

    font-size: 9pt;
    white-space: nowrap;    
}

#depositTab th, #depositTab td, #depositTab label {
    font-size: 9pt;
    white-space: nowrap;    
}

#loanTab th, #loanTab td, #loanTab label {
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

 
            <!-- CONTENT -->
            <div class="row">
              <div class="col-md-12">
                <div class="portlet">
                  <div class="portlet-body">
                    <div class="tabbable-custom ">
                      <ul class="nav nav-tabs ">
                        <li class="active">
                          <a href="<?php echo base_url('index.php/').$this->uri->segment(1).'/'.$this->uri->segment(2).'/load'; ?>" id='tablist'> LIST </a>
                        </li>
                        <li>                          
                          <a href="<?php echo $this->uri->segment(3) == 'add' ? "#newdata" : base_url('index.php/').$this->uri->segment(1).'/'.$this->uri->segment(2).'/add' ; ?>" <?php echo $this->uri->segment(3) == 'add' ? "data-toggle='tab' " : '' ; ?> id='tabdata'> INPUT </a>
                        </li> 
						<li>
                          <a href="#editdata" id='tabedit'  data-toggle="tab"> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane" id="<?php echo $this->uri->segment(3) == 'add' ? 'newdata' : 'editdata' ; ?>" >
                          <div class="portlet-body form">
                         <form action="<?php echo site_url($method);?>" method="post" id="myform">
							  
							<!-- hidden value -->
							 
							<!-- hidden value -->
							 
                            <div class="row">
                              <div class="col-md-12">
                                <div style="color:red"> <?php echo validation_errors(); ?> </div>
                                 
								 <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Strukturunit</label> 
									   <?php echo form_dropdown('strukturunit_id', $strukturunit_select, !empty($result['strukturunit_id'])?$result['strukturunit_id']:'', 'id ="istruk"  class="form-control" style="width: 100%;" required data-placeholder="Select"'); ?>
                                    </div>
                                  </div>  
								  
								  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Line</label> <i style="font-size:12px;"> Otomatis </i>
                                      <input  type="text" id="strukturunitapprovalauth_line" name="strukturunitapprovalauth_line" class="form-control input-sm" value="<?php echo !empty($result['strukturunitapprovalauth_line'])?$result['strukturunitapprovalauth_line']:''; ?>"  readonly />
                                    </div>
                                  </div>  
								  
								  <div class="col-md-4 form-group row">
								  <div class="col-xs-12">
                                      <label>Sequencer</label> <i style="font-size:12px;"> Manual </i>
                                      <input  type="text" id="strukturunitapprovalauth_seq" name="strukturunitapprovalauth_seq" class="form-control input-sm" value="<?php echo !empty($result['strukturunitapprovalauth_seq'])?$result['strukturunitapprovalauth_seq']:''; ?>" required /> 
                                  </div>  
                                  </div>  
								  <div class="row"> &nbsp; </div>
								  <div class="col-md-4 form-group row">
								  <div class="col-xs-12">
                                      <label>User</label> 
									   <?php echo form_dropdown('username', $username_select, !empty($result['username'])?$result['username']:'', 'id ="iuser"  class="form-control" style="width: 100%;" required data-placeholder="Select"'); ?>  
                                  </div>  
                                  </div>  
								                      
                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                      <label>Position</label>   
										<input  type="text" id="strukturunitapprovalauth_position" name="strukturunitapprovalauth_position" class="form-control input-sm" value="<?php echo !empty($result['strukturunitapprovalauth_position'])?$result['strukturunitapprovalauth_position']:''; ?>" required /> 
                                    </div>
                                  </div>
                                   
								  <div class="col-md-4 form-group row">
								  <div class="col-xs-12">
										<label>Descr</label> 
										<input  type="text" id="strukturunitapprovalauth_descr" name="strukturunitapprovalauth_descr" class="form-control input-sm" value="<?php echo !empty($result['strukturunitapprovalauth_descr'])?$result['strukturunitapprovalauth_descr']:''; ?>" required /> 
                                  </div>  
                                  </div> 
								  
								  <div class="col-md-4 form-group row">
								  <div class="col-xs-12">
										<label>Value</label> 
										<input  type="text" id="strukturunitapprovalauth_value" name="strukturunitapprovalauth_value" class="form-control input-sm" value="<?php echo !empty($result['strukturunitapprovalauth_value'])?$result['strukturunitapprovalauth_value']:''; ?>" required /> 
                                  </div>  
                                  </div> 
								  
								  <div class="col-md-4 form-group row">
								  <div class="col-xs-12">
										<label>Date</label> 
										<input  type="text" id="strukturunitapprovalauth_date" name="strukturunitapprovalauth_date" class="form-control input-sm" value="<?php echo !empty($result['strukturunitapprovalauth_date'])?$result['strukturunitapprovalauth_date']:''; ?>" readonly /> 
                                  </div>  
                                  </div> 
								
                                 <div class="row"> &nbsp; </div>   
								 
								<div class="col-md-4 form-group row">
								<div class="col-xs-12">
									<label>Disabled</label> 
									<input type="checkbox" class="form-control input-sm checkbox" name="strukturunitapprovalauth_isdisabled" value="1" <?php echo  !empty($result['strukturunitapprovalauth_isdisabled'])?'CHECKED':'';?> />
								</div>  
								</div> 
								  
								  
								  <div class="col-md-4 form-group row">
								  <div class="col-xs-12">
										<label>Header</label> 
										<input  type="text" id="strukturunitapprovalauth_header" name="strukturunitapprovalauth_header" class="form-control input-sm" value="<?php echo !empty($result['strukturunitapprovalauth_header'])?$result['strukturunitapprovalauth_header']:'Approval'; ?>"  /> 
                                  </div>  
                                  </div> 
								  
								  <div class="col-md-4 form-group row">
								  <div class="col-xs-5">
										<label>Min Val</label> 
										<input  type="text" id="strukturunitapprovalauth_minvalues" name="strukturunitapprovalauth_minvalues" class="form-control input-sm" value="<?php echo !empty($result['strukturunitapprovalauth_minvalues'])?$result['strukturunitapprovalauth_minvalues']:'0'; ?>"  /> 
                                  </div>  
                                  </div>
								  
								  <div class="col-md-4 form-group row">
								  <div class="col-xs-5">
										<label>Max Val</label> 
										<input  type="text" id="strukturunitapprovalauth_maxvalues" name="strukturunitapprovalauth_maxvalues" class="form-control input-sm" value="<?php echo !empty($result['strukturunitapprovalauth_maxvalues'])?$result['strukturunitapprovalauth_maxvalues']:'9999'; ?>"  /> 
                                  </div>  
                                  </div> 
								  
								  <div class="col-md-4 form-group row">
								  <div class="col-xs-12">
										<label>Auth Type</label> 
										<input  type="text" id="strukturunitapprovalauth_type" name="strukturunitapprovalauth_type" class="form-control input-sm" value="<?php echo !empty($result['strukturunitapprovalauth_type'])?$result['strukturunitapprovalauth_type']:''; ?>" required /> 
                                  </div>  
                                  </div> 
								  
								</div>
                                 	
                                <div class="col-xs-13" style="float:left;">
                                  <br />
								  <input type="submit" value="SUBMIT" class="btn btn-sm btn-info" id='btnSubmitForm' />
                                </div>
                              </div>
                             </div>
                            </form> 
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- END OF CONTENT -->
			
<!-- DIALOG --> 
				<div class="modal fade" id="dlgModal" tabindex="-1" role="basic" aria-hidden="true">
					<div class="modal-dialog modal-lg" role="document">
						<form id="" method="post" >
							<div class="modal-content">
								<div class="modal-header" style="background-color:ocean-blue;color:white;">
									<h4 class="modal-title" >
										List
									</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true"><i class="fal fa-times" style="color:white;"></i></span>
									</button>
								</div>
								<div class="modal-body"> 
								
								<div class="btn-group">
									<button type="button" class="btn green dropdown-toggle" id="btnLoadDlg" > Load           
								  </button>              
								</div>
								
								<!-- pencarian dialog -->
								<div class="row"> 						 
									<!--
									<div class="col-md-6"> 											
										<div class="form-group">
											<label class="form-label" for="Req">ID</label> 
												<span class="input-group-text"><i class="fal fa-sort-numeric-down fs-xl"></i></span>
												<input id="txtRequestID" name="txtRequestID" type="text" class="form-control form-control"  maxlength="20" placeholder="ID" />
											</div> 
									</div>  
									--> 
									<!--<div class="col-md-6">	
										<div class="form-group">    
											<label class="form-label" for="cboTransaksi">Rekanan</label>
											<div class="input-group flex-nowrap input-group-sm mb-3">  
												<label class="form-label" id="cboRekananDlg">&nbsp;</label> - 
												<label class="form-label" id="cboRekananNameDlg">&nbsp;</label>
											</div> 
										</div>  
									</div> 
									<div class="col-md-6">	
										<div class="form-group">    
											<label class="form-label" for="cboTransaksi">Trade/Brand</label>
											<div class="input-group flex-nowrap input-group-sm mb-3"> 
												
												<label class="form-label" id="cboTradeDlg">&nbsp;</label> -  
												<label class="form-label" id="cboTradeNameDlg">&nbsp;</label> 
											</div> 
										</div>  
									</div>-->
									<!--
									<span class="row"> &nbsp; </span>
									<div class="col-md-6 m-0">
										<div class="form-group">
											<button type="button"  name="btnLoadRows" id="btnLoadRows" class="btn btn-sm btn-info waves-effect waves-themed">
												<span class="fal fa-folder-plus mr-1"></span> Load
											</button> 
										</div>
									</div>
									-->
								</div>
								<!-- pencarian dialog -->
								
								<br/> 
								<label id="pleasewait"> Please Wait.. </label>
								<div id="tab-dlg" class="nav-tabs-custom">
								<ul class="detil nav nav-tabs" role="tabdlg"> 
									<li class="active">
										<a class="nav-link" data-toggle="tab" href="#tab_dgv-1" role="tab" id="vtab_dlg1"> Credit (K)</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#tab_dgv-2" role="tab" id="vtab_dlg2"> Debet (D)</a>
									</li> 
								</ul>
								
								<div class="tab-content border-top-0 p-1">
									<div class="tab-pane active" id="tab_dgv-1" role="tabdlg">
									<!-- debet -->
									
									<div>
										<button type="button"  name="btnVerifyRows" id="btnVerifyRows" class="btn btn-sm btn-info waves-effect waves-themed">
											<span class="fal fa-folder-plus mr-1"></span> Verify
										</button>  
									</div> 
									 
									<table id="dt-basic-debet" class="table table-responsive table-bordered table-hover table-striped w-100 table-responsive" >
									<thead> 
									<tr>
										<th style="background-color:#6c757d;color:white;min-width:10px;width:10px">[-]</th>  
										<th style="background-color:#6c757d;color:white;min-width:100px;width:100px">ID</th>  
										<th style="background-color:#6c757d;color:white;min-width:40px;width:40px">Line</th>  
										<th style="background-color:#6c757d;color:white;min-width:150px;width:150px">Invoice</th>  
										<th style="background-color:#6c757d;color:white;min-width:190px;width:190px">Description</th>
										<th style="background-color:#6c757d;color:white;min-width:210px;width:210px">Account</th>
										<th style="background-color:#6c757d;color:white;min-width:120px;width:120px">Receive/Sisa IDR</th>
										<th style="background-color:#6c757d;color:white;min-width:180px;width:180px">IDR </th>
										<th style="background-color:#6c757d;color:white;min-width:100px;width:100px">Book Date</th>
										<th style="background-color:#6c757d;color:white;min-width:100px;width:100px">Due Date</th>
										<th style="background-color:#6c757d;color:white;min-width:220px;width:220px">Tenant</th> 
										<th style="background-color:#6c757d;color:white;min-width:200px;width:200px">Brand</th> 
									</tr>
									</thead > 
									<tbody>
									</tbody>
									</table> 
									 
									<!-- dgv header -->
									</div>
									
								<div class="tab-pane fade " id="tab_dgv-2" role="tabdlg">
								<!-- kredit --> 	  	 
								    <!-- FORM Style --> 
									<div class="row">  
									  <div class="col-md-12">
										<div class="portlet-body form">              
							   
											<div class="form-group form-group-sm">
											  <label class="col-sm-3">Payment Type</label>        
											  <div class = "col-sm-3"> 
											  <?php echo form_dropdown('dlg_payment',$paymenttype,'','id="cbpayment" class="form-control" style="width: 100%;" required'); ?>      
											  </div>    
											  <label class="col-sm-3">Penerima</label>        
											  <div class = "col-sm-3">                    
												 <input type="text" class="form-control input-sm" id="dlg_penerima" name="dlg_penerima">   
											  </div> 
											</div>   
											<div class="form-group form-group-sm">
											  <label class="col-sm-3">Bank</label>        
											  <div class = "col-sm-3">
												 <input type="text" class="form-control input-sm" id="dlg_bank" name="dlg_bank">           
											  </div>  
											</div>   
											   
											<div class="form-group form-group-sm">
											  <label class="col-sm-3">Account Penerimaan</label>        
											  <div class = "col-sm-3">
												  <?php echo form_dropdown('dlg_acc_penerimaan',$acc_penerimaan,'','id="cbaccpenerimaan" class="form-control input-sm" style="width: 100%;" required'); ?>           
											  </div>  
											</div>
											
											<div class="form-group form-group-sm">
											  <label class="col-sm-3">Tanggal Bilyet</label>        
											  <div class = "col-sm-3">
												<div class="input-group date"  data-provide="datepicker" data-date-format="yyyy-mm-dd">
												<div class="input-group-addon">
												  <i class="fa fa-calendar"></i>
												</div>
												 <input type="text" class="form-control input-sm" id="dlg_tgl_bilyet" name="dlg_tgl_bilyet">           
												</div>  
											  </div>  
											</div> 
											
											<div class="form-group">
												<label class="col-sm-3">Amount (IDR)</label>        
												<div class = "col-sm-3">
												   <input type="text" class="deci form-control input-sm pull-right" id="dlg_amount" name="dlg_amount" />          
												</div>    
											</div> 
											
											<div class="form-group form-group-sm">
											  <label class="col-sm-3">Tanggal Efektif</label>        
											  <div class = "col-sm-3">
												<div class="input-group date"  data-provide="datepicker" data-date-format="yyyy-mm-dd">
													<div class="input-group-addon">
													  <i class="fa fa-calendar"></i>
													</div>
													 <input type="text" class="form-control input-sm" id="dlg_tgl_effectif" name="dlg_tgl_effectif">           
												</div>  
											  </div>  
											</div> 
											
										</div><!-- /portlet-body form -->  
									  </div><!-- /col-md-12 --> 
									</div> <!-- /row --> 
								    <!-- FORM Style --> 
								<!-- end kredit -->
								</div>
								</div> 
									<!-- datagrid -->
								</div> <!-- end tab-dlg -->
								
								</div>
								<div class="col-md-4 info">
									<div  class="m-1 p-2 font-weight-bold">
									<label class="form-label"> Jumlah (D) </label>
									<input type="text" name="txtRefund" value='0' id="txtInvoice" readonly />
									</div>
								</div>
								<div class="col-md-4 info">
									<div  class="m-1 p-2  font-weight-bold">
									<label class="form-label"> Jumlah (K) </label> 
									<input type="text" name="txtRefund" value='0' id="txtRefund" readonly />
									</div>
								</div>
								<div class="col-md-4 info">
									<div  class="m-1 p-2 font-weight-bold">
									<label class="form-label"> Selisih </label>
									<input type="text" name="txtRefund" value='0' id="txtSelisih" readonly />
									</div>
								</div>
								<div class="row"> &nbsp; </div>
								<div class="modal-footer">
									<button type="button" class="btn btn-sm waves-effect waves-themed btn-secondary" data-dismiss="modal" >Close</button>
									<button type="button" class="btn btn-sm btn-info waves-effect waves-themed" id="btnSaveDlg" >Save Change</button> 
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="panel-toolbar">
					<button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
					<button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
					<button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
				</div> 
<!-- DIALOG -->

<!-- BEGIN dlg account tambahan -->  
<div id="dlgAddRows" class="modal fade" aria-hidden="true"  role="dialog" aria-labelledby="myModalLabel" style="overflow:hidden;"  >
                      <div class="modal-dialog" style="width:35%;">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            </button>
                            <h4 class="modal-title">
                             Add Rows 
                            </h4>
                          </div>
                          <div class="modal-body">  
							<div class="rows">
								<div class="col-md-12 form-group form-group-sm row" >
									<div class="col-xs-12">
									  <label>Account No</label>
									
										<?php echo form_dropdown('cboaccnoRows',$acc_rows,'','id ="cboaccnoRows" class="form-control" style="width: 100%;" data-placeholder="Select account ..." '); ?>
									</div> 
									<div class="col-md-12 form-group row">
										<div class="col-xs-12">
										  <label>IDR</label>
											<input value="0" type="text" id = "DlgIDR" name="DlgIDR" class="form-control input-sm" />
										</div>
									</div>
								  
								</div>
							</div>      
							<br /> 
							<br /> 
							<br /> 
							<br /> 
							<div class="rows"> &nbsp; </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline btn-sm" data-dismiss="modal">
                              Close
                            </button>
                            <button type="button" class="btn dark btn-sm btn-info"  id="btDlgAddRows">
                              Save Change
                            </button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
<!-- END dlg account tambahan -->