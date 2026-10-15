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
                                      <label>ID</label> <i style="font-size:12px;"> Manual </i>
                                      <input  type="text" id="transaksi_id" name="transaksi_id" class="form-control input-sm" value="<?php echo !empty($result['transaksi_id'])?$result['transaksi_id']:''; ?>" <?php if($this->uri->segment(3) == 'add' ) { echo "required"; } else { echo "readonly"; } ?>  />
                                    </div>
                                  </div>  
								  
								  <div class="col-md-4 form-group row">
								  <div class="col-xs-12">
                                      <label>Transaksi Name</label> 
                                      <input  type="text" id="transaksi_name" name="transaksi_name" class="form-control input-sm" value="<?php echo !empty($result['transaksi_name'])?$result['transaksi_name']:''; ?>" required /> 
                                  </div>  
                                  </div>  
								  
								  <div class="col-md-4 form-group row">
								  <div class="col-xs-12">
                                      <label>Transaksi Descr</label> 
                                      <input  type="text" id="transaksi_descr" name="transaksi_descr" class="form-control input-sm" value="<?php echo !empty($result['transaksi_descr'])?$result['transaksi_descr']:''; ?>" required /> 
                                  </div>  
                                  </div>  
								                      
                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                      <label>Item ID</label>                                        
                                        <?php echo form_dropdown('iteminventorytype_id', $itemid_select, !empty($result['iteminventorytype_id'])?$result['iteminventorytype_id']:'', 'id ="istruk"  class="form-control" style="width: 100%;" required data-placeholder="Select Item"'); ?>
                                    </div>
                                  </div>
                                   
								  <div class="col-md-4 form-group row">
								  <div class="col-xs-2">
                                      <label>Disabled</label> 
                                     <input type="checkbox" class="form-control input-sm checkbox" name="transaksi_isdisabled" value="1" <?php echo  !empty($result['transaksi_isdisabled'])?'CHECKED':'';?> />
                                  </div>  
                                  </div> 
								  
								</div>
                                   
                                  <div class="col-md-12">                                  
                                  <br> 
                                      <!-- Custom Tabs -->
                                      <div class="nav-tabs-custom">
                                        <ul class="detil nav nav-tabs">
                                          <li class="active"><a href="#tab_1" data-toggle="tab" role= "tab">Receivables</a></li>
                                          <li><a href="#tab_5" data-toggle="tab" role= "tab">Agreement Type</a></li> 
                                        </ul>
										
                                        <div class="tab-content"> 
											<!-- Receive type --> 
											<div class="tab-pane active" id="tab_1">
											
											<div class="row"> &nbsp; </div>	 
                                            <div class="table-responsive" style="height:400px;">
											<table class="table-receive table-responsive table table-bordered table-striped compact table-sm" id='dgvdetilD' style="border:solid 1px #999; #999; border-radius:0px;" >
                                                <thead>
                                                  <tr>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Sel</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:100px;width:100px;">Name </th> 
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:30px;width:30px;">Dis</th>   
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Account</th> 
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Account Disc</th> 
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Account PPN</th>  
                                                  </tr>
                                                </thead>
                                                <tbody id="tbodyD"> 
												<?php   
													$i= 0;
													$acc_idC = array();
													$acc_discC = array();
													$acc_ppnC = array();
													  if(count($resultD) > 0) { 
													  foreach($resultD as $n=>$rows){ 
														if(@$resultD[$n+1]['pospayment_id'] != $rows['pospayment_id']){
														if($this->uri->segment(3)=="add")
														{
															$acc_idC['']='';
															$acc_discC['']='';
															$acc_ppnC['']='';
														}
														else
														{
															$acc_idC = $rows['acc_id'];
															$acc_discC = $rows['acc_id_disc'];
															$acc_ppnC = $rows['acc_id_ppn'];
														}
												?>
												<tr>
													<td><input type="checkbox" name="pos_<?php echo $i; ?>" value="1" <?php echo  !empty($rows['pos_sel'])?'CHECKED':'';?> class="form-control input-sm" /></td>
													<td><?php echo $rows['pospayment_id'].'-'.$rows['pospayment_name']; ?></td>
													<td><input type="checkbox" class="form-control input-sm" name="pos_isdisabled[]" value="1" <?php echo  !empty($rows['transaksipospayment_isdisabled'])?'CHECKED':'';?> /></td> 
													<td><?php echo form_dropdown('acc_id_r[]',$acc,$acc_idC,'class="acc_id form-control" style="width: 100%;"'); ?></td>  
													<td><?php echo form_dropdown('acc_id_disc_r[]',$acc,$acc_discC,'class="acc_id form-control" style="width: 100%;"'); 
														?></td>  
													<td><?php echo form_dropdown('acc_id_ppn_r[]',$acc,$acc_ppnC,'class="acc_id form-control" style="width: 100%;"'); ?>
													<input type="hidden" name="pospayment_id[]" value="<?php echo  !empty($rows['pospayment_id'])?$rows['pospayment_id']:'';?>"  class="form-control input-sm" />	
													</td>  
												</tr>
												<?php $i++;}}} ?>
                                                </tbody>
                                              </table> 
                                            </div>
											</div>
											<!-- receive type -->

											<!-- agreement type -->
											<div class="tab-pane" id="tab_5"> 
											<!--<a href="javascript:void(0)" id="btdetilK" class="btn btn-sm btn-info waves-effect waves-themed m-1 p-1">
											<span class="fal fa-folder-plus mr-1"></span>
											<strong>Add Row</strong>
											</a> -->
											<div class="row"> &nbsp; </div>  
											<div class="table-responsive" style="height:400px;">
                                              <table class="table-agr table-responsive table table-bordered table-striped compact table-sm" id='dgvdetilK' style="border:solid 1px #999; #999; border-radius:0px;width:100%;">
												 <thead>
                                                   <tr>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Sel</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:100px;width:100px;">Name </th> 
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:30px;width:30px;">Dis</th>   
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Account</th> 
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Account Disc</th> 
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Account PPN</th>  
                                                  </tr>
                                                </thead>
                                                <tbody id="tbodyK">   
												<?php 
													$ii= 0;
													$acc_idC = array();
													$acc_discC = array();
													$acc_ppnC = array();
													  if(count($resultK) > 0) { 
													  foreach($resultK as $rows) {
														if(@$resultK[$n+1]['agreementtype_id'] != $rows['agreementtype_id']){
														if($this->uri->segment(3)=="add")
														{
															$acc_idC['']='';
															$acc_discC['']='';
															$acc_ppnC['']='';
														}
														else
														{
															$acc_idC = $rows['acc_id'];
															$acc_discC = $rows['acc_id_disc'];
															$acc_ppnC = $rows['acc_id_ppn'];
														}
												?>
												<tr>
													<td><input type="checkbox" name="agr_<?php echo $ii; ?>" value="1" <?php echo  !empty($rows['agr_sel'])?'CHECKED':'';?> class="form-control input-sm" /></td>
													<td><?php echo $rows['agreementtype_id'].'-'.$rows['agreementtype_name']; ?></td>
													<td><input type="checkbox" class="form-control input-sm" name="agr_isdisabled[]" value="1" <?php echo  !empty($rows['agr_isdisabled'])?'CHECKED':'';?> /></td> 
													<td><?php echo form_dropdown('acc_id_ag[]',$acc,$acc_idC,'class="acc_id form-control" style="width: 100%;"'); ?></td>  
													<td><?php echo form_dropdown('acc_id_disc_ag[]',$acc,$acc_discC,'class="acc_id form-control" style="width: 100%;"'); 
														?></td>  
													<td><?php echo form_dropdown('acc_id_ppn_ag[]',$acc,$acc_ppnC,'class="acc_id form-control" style="width: 100%;"'); ?>
													<input type="hidden" name="agreementtype_id[]" value="<?php echo  !empty($rows['agreementtype_id'])?$rows['agreementtype_id']:'';?>"  class="form-control input-sm" />		
													</td>   
												</tr>
													<?php $ii++;}}} ?>
                                                </tbody> 
                                              </table> 
                                            </div>
                                            </div>
											<!-- kredit -->
											  
                                          <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                      </div>
                                      <!-- nav-tabs-custom -->
                                    </div>
                                    <!-- /.col -->
									
								 
									
                                <div class="col-xs-13" style="float:right;">
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