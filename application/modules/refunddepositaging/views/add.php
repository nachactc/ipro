<?php $chid=get_setting("channel_id");?>
 

 
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
							<input type="hidden" id="hacc_id" name="hacc_id">
							<input type="hidden" id="currency_id" name="currency_id" value="IDR">
							<input type="hidden" id="currency_rate" name="currency_rate" value="1.00">
							<input type="hidden" id="sub1_id" name="sub1_id" value="<?php echo !empty($result['sub1_id'])?$result['sub1_id']:''; ?>">
							<input type="hidden" id="sub2_id" name="sub2_id" value="">
							<!-- hidden value -->
							 
                            <div class="row">
                              <div class="col-md-12">
                                <div style="color:red"> <?php echo validation_errors(); ?> </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>ID</label>
                                      <label class="post checkbox-inline pull-right"><input type="checkbox" <?php echo !empty($result['jurnal_isposted'])?'Checked':''; ?> disabled><b>Posted</b></label> 
                                      <input  type="text" id="jurnal_id" name="jurnal_id" class="form-control input-sm" value="<?php echo !empty($result['jurnal_id'])?$result['jurnal_id']:''; ?>" readonly>
                                    </div>
                                  </div>    
								  <?php $regionsel =  (count($region) <= 2) ?  array_keys($region)[1] : '' ; ?>
                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                    <label>Business Unit</label>
                                      <?php echo form_dropdown('cboregion', $region, !empty($result['region_id'])?$result['region_id']:$regionsel, 'id ="iregion" class="form-control" style="width: 100%;" disabled'); ?>
                                    </div>
                                    <input type="hidden" id = "region_id" name="region_id" value="<?php echo !empty($result['region_id'])?$result['region_id']:''; ?>">
                                  </div>                                            
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Channel</label>
                                        <input type="text" id = "channel_id" name="channel_id" class="form-control input-sm" value="<?php echo !empty($result['channel_id'])?$result['channel_id']:$channel; ?>" readonly>
                                    </div>
                                  </div>                     
                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                    <label>Periode</label>
                                      <?php echo form_dropdown('periode_id', $period, !empty($result['periode_id'])?$result['periode_id']:'', 'id ="iperiod" class="form-control" style="width: 100%;" required'); ?>
                                    </div>
                                  </div>    
                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                      <label>Store</label> 
									  <?php echo form_dropdown('cbobranch', $branch,!empty($result['branch_id'])?$result['branch_id']:'', 'id ="ibranch" class="form-control" style="width: 100%;" required data-placeholder="Select a Store" disabled'); ?>
                                       <input type="hidden" id = "branch_id" name="branch_id" value="<?php echo !empty($result['branch_id'])?$result['branch_id']:''; ?>"> 
                                    </div>
                                  </div> 
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Jurnal Type</label>
                                        <input type="text" id = "jurnaltype_id" name="jurnaltype_id" class="form-control input-sm" value="<?php echo !empty($result['jurnaltype_id'])?$result['jurnaltype_id']:$jurnaltype; ?>" readonly>
                                    </div>
                                  </div>  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Book Date</label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="jurnal_bookdate" name="jurnal_bookdate" value = "<?php echo !empty($result['jurnal_bookdate'])?date('Y-m-d',strtotime($result['jurnal_bookdate'])):''; ?>">
                                      </div>
                                    </div>
                                  </div>                                     
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Rekanan</label>
                                      <div class="input-group input-group-sm"> 
										<select data-placeholder="Select tenant ..." class="js-data-tenant-ajax form-control" id="cboTenantName" name="rekanan_id">
										<?php if(!empty($result['rekanan_id'])) { ?>
											<option value="<?php echo $result['rekanan_id']; ?>">
												<?php echo $result['rekanan_name']; ?>
											</option>
										<?php } ?>
										</select>
                                      </div>
                                    </div>
                                  </div> 
								  
								<div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Brand</label>
                                      <div class="input-group input-group-sm"> 
										<select data-placeholder="Select trade name ..." class="js-data-trade-ajax form-control" id="cboTradeName" name="rekananshipping_line">
										<?php if(!empty($result['rekananshipping_line'])) { ?>
											<option value="<?php echo $result['rekananshipping_line']; ?>">
												<?php echo $result['rekanan_name'].'-'.$result['rekananshipping_name']; ?>
											</option>
										<?php }elseif(!empty($resultD[0]['rekananshipping_line'])){ ?>
											<option value="<?php echo $resultD[0]['rekananshipping_line']; ?>">
												<?php echo $resultD[0]['rekanan_name'].'-'.$resultD[0]['rekananshipping_name']; ?>
											</option>
										<?php } ?>
										</select>
										<input type="hidden" name="rekananshipping_line" id="rekananshipping_line" /> 
                                      </div>
                                    </div>
                                </div>  
								
								<div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Due Date</label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="jurnal_duedate" name="jurnal_duedate" value = "<?php echo !empty($result['jurnal_duedate'])?date('Y-m-d',strtotime($result['jurnal_duedate'])):''; ?>">
                                      </div>
                                    </div>
                                </div>
								  
								<div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Jurnal Source</label>
                                        <input type="text" id = "jurnal_source" name="jurnal_source" class="form-control input-sm" value="<?php echo !empty($result['jurnal_source'])?$result['jurnal_source']:$source; ?>" readonly>
                                    </div>
                                  </div>   								  
                                                          
                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                      <label>Strukturunit</label>                                        
                                        <?php echo form_dropdown('strukturunit_id', $struktur, !empty($result['strukturunit_id'])?$result['strukturunit_id']:'', 'id ="istruk"  class="form-control" style="width: 100%;" required data-placeholder="Select Strukturunit"'); ?>
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                        <label>Faktur/Invoice/Info</label>                                        
                                        <input type="text" id = "jurnal_faktur" name="jurnal_faktur" class="form-control input-sm" value="<?php echo !empty($result['jurnal_faktur'])?$result['jurnal_faktur']:'REFUND'; ?>" readonly>
                                    </div>
                                  </div>     
                                  <div class="col-md-12 form-group row">                                    
                                    <div class="col-md-11">
                                      <label>Description:</label>
                                      <textarea id = "jurnal_descr" name="jurnal_descr" class="form-control input-sm" required rows="4" ><?php echo !empty($result['jurnal_descr'])?$result['jurnal_descr']:''; ?> </textarea>
                                    </div>                                    
                                  </div> 
								  
								  <?php if ($this->uri->segment(3)=="add"){ ?> 
								  <div class="row"> &nbsp; </div>
								  <div class="row"> &nbsp; </div>
                                  <div class="col-md-12">   
								  <!-- dlg invoice -->
									<a href="javascript:void(0)" id="btDlg" class="btn btn-sm btn-info waves-effect waves-themed m-1 p-1">
										<span class="fal fa-folder-plus mr-1"></span>
									<strong><?php echo $tombolDlgName; ?></strong>
									</a>
								  <!-- end dlg invoice --> 
								  </div>
								  <?php } ?>
								  
                                  <div class="col-md-12">                                  
                                  <br> 
                                      <!-- Custom Tabs -->
                                      <div class="nav-tabs-custom">
                                        <ul class="detil nav nav-tabs">
                                          <li class="active"><a href="#tab_1" data-toggle="tab" role= "tab">Detail(D)</a></li>
                                          <li><a href="#tab_5" data-toggle="tab" role= "tab">Detail(K)</a></li>
                                          <li><a href="#tab_2" data-toggle="tab" role = "tab">Reference</a></li>
                                          <li><a href="#tab_3" data-toggle="tab" role = "tab">Response</a></li>
                                          <li><a href="#tab_4" data-toggle="tab" role = "tab">Record</a></li>
                                        </ul>
										
                                        <div class="tab-content"> 
											<!-- debet --> 
											<div class="tab-pane active" id="tab_1">
										  
											<!--<a href="javascript:void(0)" id="btdetilD" class="btn btn-sm btn-info waves-effect waves-themed m-1 p-1">
												<span class="fal fa-folder-plus mr-1"></span>
											<strong>Add Row</strong>
											</a> 
											<div class="row"> &nbsp; </div>-->	
                                            <div class ="table-responsive">  
                                              <table class="table table-bordered table-striped compact table-sm" id='dgvdetilD' style="border:solid 1px #999; #999; border-radius:0px;" >
                                                <thead>
                                                  <tr>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Line</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:220px;width:220px;">Account </th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white; min-width:280px;width:280px;">Description</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:150px;width:150px;">IDR</th>  
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:150px;width:150px;">Ref. ID</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">RfLn</th> 
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Delete</th>
                                                  </tr>
                                                </thead>
                                                <tbody id="tbodyD"> 
												<?php if(count($resultD) > 0) { 
													  foreach($resultD as $rows) {
												?>
												<tr>
													<td><?php echo $rows['jurnaldetil_line']; ?><input type="hidden" name="d_jurnaldetil_line[]" value="<?php echo $rows['jurnaldetil_line']; ?>" /></td>
													<td><?php echo $rows['acc_id'].'-'.$rows['acc_name']; ?></td>
													<td><?php echo $rows['jurnaldetil_descr']; ?></td>
													<td><?php echo number_format($rows['jurnaldetil_idr'],2); ?></td> 
													<td><?php echo $rows['ref_id']; ?></td>
													<td><?php echo $rows['ref_line']; ?></td>
													<td>
													<?php if ( $rows['ref_id'] == '') {?> 
														<button id="btnDelete" title="delete" class="btn btn-outline-secondary btn-sm btn-icon waves-effect waves-themed"><i class="fa fa-trash"></i></button> 
													<?php } else { echo '-'; } ?>    
													<input type="hidden" name="d_acc_id[]" value="<?php echo $rows['acc_id']; ?>" />
													<input type="hidden" name="d_jurnaldetil_descr[]" value="<?php echo $rows['jurnaldetil_descr']; ?>" />
													<input type="hidden" name="d_rekanan_id[]" value="<?php echo $rows['rekanan_id']; ?>" />
													<input type="hidden" name="d_rekananshipping_line[]" value="<?php echo $rows['rekananshipping_line']; ?>" />
													<input type="hidden" name="d_ref_id[]" value="<?php echo $rows['ref_id']; ?>" />
													<input type="hidden" name="d_ref_line[]" value="<?php echo $rows['ref_line']; ?>" />
													<input type="hidden" name="d_channel_id[]" value="<?php echo $rows['channel_id']; ?>" />
													<input type="hidden" name="d_region_id[]" value="<?php echo $rows['region_id']; ?>" />
													<input type="hidden" name="d_branch_id[]" value="<?php echo $rows['branch_id']; ?>" />
													<input type="hidden" name="d_strukturunit_id[]" value="<?php echo $rows['strukturunit_id']; ?>" />
													<input type="hidden" name="d_currency_id[]" value="<?php echo $rows['currency_id']; ?>" />
													<input type="hidden" name="d_jurnaldetil_foreign[]" value="<?php echo $rows['jurnaldetil_foreign']; ?>" />
													<input type="hidden" name="d_jurnaldetil_foreignrate[]" value="<?php echo $rows['jurnaldetil_foreignrate']; ?>" />
													<input type="hidden" name="d_jurnaldetil_idr[]" value="<?php echo $rows['jurnaldetil_idr']; ?>" class="d_idr" />   
													<input type="hidden" name="d_sub1_id[]" value="<?php echo $rows['sub1_id']; ?>" />
													<input type="hidden" name="d_sub2_id[]" value="<?php echo $rows['sub2_id']; ?>" />
													</td>
												</tr>
												<?php }} ?>
                                                </tbody>
                                              </table>
                                             </div>
                                            </div>
											<!-- debet -->

											<!-- kredit -->
											<div class="tab-pane" id="tab_5"> 
											<a href="javascript:void(0)" id="btdetilK" class="btn btn-sm btn-info waves-effect waves-themed m-1 p-1">
											<span class="fal fa-folder-plus mr-1"></span>
											<strong>Add Row</strong>
											</a> 
											<div class="row"> &nbsp; </div>
											<div class ="table-responsive">  
                                              <table class="table table-bordered table-striped compact table-sm" id='dgvdetilK' style="border:solid 1px #999; #999; border-radius:0px;">
												 <thead>
                                                  <tr>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Line</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:280px;width:280px;">Account </th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white; min-width:280px;width:280px;">Description</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:150px;width:150px;">IDR</th>   
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:150px;width:150px;">Ref. ID</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">RfLn</th> 
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Delete</th>
                                                  </tr>
                                                </thead>
                                                <tbody id="tbodyK">   
												<?php if(count($resultK) > 0) { 
													  foreach($resultK as $rows) {
												?>
												<tr>
													<td><?php echo $rows['jurnaldetil_line']; ?><input type="hidden" name="k_jurnaldetil_line[]" value="<?php echo $rows['jurnaldetil_line']; ?>" /></td>
													<td><?php echo $rows['acc_id'].'-'.$rows['acc_name']; ?></td>
													<td> 
													<input type="text"  class="form-control input-sm" name="k_jurnaldetil_descr[]" value="<?php echo $rows['jurnaldetil_descr']; ?>" />
													</td>  
													<td><?php echo number_format($rows['jurnaldetil_idr']*-1,2); ?></td>
													<td><?php echo $rows['ref_id']; ?></td>
													<td><?php echo $rows['ref_line']; ?></td>
													<td>
													<?php if ( $rows['ref_id'] == '') {?> 
														<button id="btnDelete" title="delete" class="btn btn-outline-secondary btn-sm btn-icon waves-effect waves-themed"><i class="fa fa-trash"></i></button> 
													<?php } else { echo '-'; } ?>    
													
													<input type="hidden" name="k_acc_id[]" value="<?php echo $rows['acc_id']; ?>" /> 
													<input type="hidden" name="k_rekanan_id[]" value="<?php echo $rows['rekanan_id']; ?>" />
													<input type="hidden" name="k_rekananshipping_line[]" value="<?php echo $rows['rekananshipping_line']; ?>" />
													<input type="hidden" name="k_ref_id[]" value="<?php echo $rows['ref_id']; ?>" />
													<input type="hidden" name="k_ref_line[]" value="<?php echo $rows['ref_line']; ?>" />
													<input type="hidden" name="k_channel_id[]" value="<?php echo $rows['channel_id']; ?>" />
													<input type="hidden" name="k_region_id[]" value="<?php echo $rows['region_id']; ?>" />
													<input type="hidden" name="k_branch_id[]" value="<?php echo $rows['branch_id']; ?>" />
													<input type="hidden" name="k_strukturunit_id[]" value="<?php echo $rows['strukturunit_id']; ?>" />
													<input type="hidden" name="k_currency_id[]" value="<?php echo $rows['currency_id']; ?>" /> 
													<input type="hidden" name="k_jurnaldetil_foreign[]" value="<?php echo $rows['jurnaldetil_foreign']; ?>" />
													<input type="hidden" name="k_jurnaldetil_foreignrate[]" value="<?php echo $rows['jurnaldetil_foreignrate']; ?>" />
													<input type="hidden" name="k_sub1_id[]" value="<?php echo $rows['sub1_id']; ?>" />
													<input type="hidden" name="k_sub2_id[]" value="<?php echo $rows['sub2_id']; ?>" />
													<input type="hidden" name="k_jurnaldetil_idr[]" value="<?php echo $rows['jurnaldetil_idr']*-1; ?>" class="k_idr"/> 
													</td>
												</tr>
												<?php }} ?>
                                                </tbody> 
                                              </table>
                                             </div> 
                                            </div>
											<!-- kredit -->
											
											<!-- reference -->
                                            <div class="tab-pane" id="tab_2">
                                            <div class ="table-responsive">                                             
                                              <table class="table table-bordered table-striped" id='DgvRef' style="border:solid 1px #999; #999; border-radius:0px;">
                                                <thead>
                                                   <tr>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">ID</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Line</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:320px;width:320px;">Account </th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white; min-width:280px;width:280px;">Description</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:150px;width:150px;">IDR</th> 
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:310px;width:310px;">Tenant </th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:220px;width:220px;">Brand </th> 
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:150px;width:150px;">Ref. ID</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">RfLn</th>  
                                                  </tr>
                                                </thead>
                                                <tbody> 
													<?php if(count($resultRef) > 0) { 
													  foreach($resultRef as $rows) {
													?>
													<tr>
														<td><?php echo $rows['jurnal_id']; ?></td>
														<td><?php echo $rows['jurnaldetil_line']; ?></td>
														<td><?php echo $rows['acc_id'].'-'.$rows['acc_name']; ?></td>
														<td><?php echo $rows['jurnaldetil_descr']; ?></td>
														<td><?php echo number_format($rows['jurnaldetil_idr'],2); ?></td>
														<td><?php echo $rows['rekanan_id'].'-'.$rows['rekanan_name']; ?></td>
														<td><?php echo $rows['rekananshipping_line'].'-'.$rows['rekananshipping_name']; ?></td>
														<td><?php echo $rows['ref_id']; ?></td>
														<td><?php echo $rows['ref_line']; ?></td> 
													</tr>
													<?php }} ?>
                                                </tbody>
                                              </table>
                                             </div>
                                            </div>
											<!-- reference -->
											
											<!-- response -->
                                            <div class="tab-pane" id="tab_3">
                                             <div class ="table-responsive">
                                              <table class="table table-bordered table-striped compact" id='dgvRes' style="border:solid 1px #999; #999; border-radius:0px;">
												 <thead>
                                                  <tr>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">ID</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Line</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:320px;width:320px;">Account </th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white; min-width:280px;width:280px;">Description</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:150px;width:150px;">IDR</th> 
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:310px;width:310px;">Tenant </th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:220px;width:220px;">Brand </th> 
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:150px;width:150px;">Ref. ID</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">RfLn</th>  
                                                  </tr>
                                                </thead>
                                                <tbody>  
														<?php if(count($resultRes) > 0) { 
														  foreach($resultRes as $rows) {
														?>
														<tr>
															<td><?php echo $rows['jurnal_id']; ?></td>
															<td><?php echo $rows['jurnaldetil_line']; ?></td>
															<td><?php echo $rows['acc_id'].'-'.$rows['acc_name']; ?></td>
															<td><?php echo $rows['jurnaldetil_descr']; ?></td>
															<td><?php echo number_format($rows['jurnaldetil_idr'],2); ?></td>
															<td><?php echo $rows['rekanan_id'].'-'.$rows['rekanan_name']; ?></td>
															<td><?php echo $rows['rekananshipping_line'].'-'.$rows['rekananshipping_name']; ?></td>
															<td><?php echo $rows['ref_id']; ?></td>
															<td><?php echo $rows['ref_line']; ?></td> 
														</tr>
														<?php }} ?>
                                                </tbody> 
                                              </table>
                                             </div>
                                            </div>      
											<!-- response -->
											
                                            <div class="tab-pane" id="tab_4">
                                              <div class="row">
                                               <div class="col-md-6">
                                                <div class="col-xs-8">
                                                  <label>Create By</label>
                                                  <input type="text" id= "jurnal_createby" name="jurnal_createby" class="form-control input-sm" value="<?php echo !empty($result['jurnal_createby'])?$result['jurnal_createby']:''; ?>" readonly />
                                                </div>
                                               </div>
                                               <div class="col-md-6">
                                                <div class="col-xs-8">
                                                  <label>Create Date</label>
                                                  <input type="text" id="jurnal_createdate" name="jurnal_createdate" class="form-control input-sm" value="<?php echo !empty($result['jurnal_createdate'])?$result['jurnal_createdate']:''; ?>" readonly />
                                                </div>
                                               </div>
                                               <div class="col-md-6">
                                                <div class="col-xs-8">
                                                  <label>Modify By</label>
                                                  <input type="text" id= "jurnal_modifyby"  name="jurnal_modifyby" class="form-control input-sm" value="<?php echo !empty($result['jurnal_modifyby'])?$result['jurnal_modifyby']:''; ?>" readonly />
                                                </div>
                                               </div>
                                               <div class="col-md-6">
                                                <div class="col-xs-8">
                                                  <label>Modify Date</label>
                                                  <input type="text" id="jurnal_modifydate" name="jurnal_modifydate" class="form-control input-sm" value="<?php echo !empty($result['jurnal_modifydate'])?$result['jurnal_modifydate']:''; ?>" readonly />
                                                </div>
                                               </div>
                                               </div>
                                            </div>
                                          <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                      </div>
                                      <!-- nav-tabs-custom -->
                                    </div>
                                    <!-- /.col -->
									
									<!-- info angka debet kredit -->
									<div class="row"> &nbsp; </div>
									<div class="row"> &nbsp; </div>
									
									<div class="col-xs-9">
										<span class="pull-right">Jumlah D : </span>
									</div>
                                    <div class="col-xs-3">
										<input type="text" style="text-align:right" name="ttotamountD" id="ttotamountD" class="form-control input-sm" readonly />
									</div>
									
									<div class="col-xs-9">
										<span class="pull-right">Jumlah K : </span>
									</div>
                                    <div class="col-xs-3">
										<input type="text" style="text-align:right" name="ttotamountK" id="ttotamountK" class="form-control input-sm" readonly />
									</div> 
									<div class="col-xs-9">
										<span class="pull-right">Balance : </span>
									</div>
                                    <div class="col-xs-3">
										<input type="text" style="text-align:right" name="ttotamount" id="ttotamount" class="form-control input-sm" readonly />
									</div>
									<!-- /info angka debet kredit -->
									
                                <div class="col-xs-13" style="float:right;">
                                  <br />
								  <input type="submit" value="SUBMIT" class="btn btn-sm btn-info" id='btnSubmitForm' <?php if($this->uri->segment(3) == 'edit' ) { echo ($result['jurnal_isposted'] == 1)? 'DISABLED' : ''; }?> />
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
										<a class="nav-link" data-toggle="tab" href="#tab_dgv-1" role="tab" id="vtab_dlg1">Debet (D) </a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#tab_dgv-2" role="tab" id="vtab_dlg2"> Credit (K)</a>
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
											<th style="background-color:#6c757d;color:white;min-width:30px;width:30px">[-]</th>  
											<th style="background-color:#6c757d;color:white;min-width:100px;width:100px">ID</th>  
											<th style="background-color:#6c757d;color:white;min-width:80px;width:80px">Line</th>  
											<th style="background-color:#6c757d;color:white;min-width:190px;width:190px">Description</th>
											<th style="background-color:#6c757d;color:white;min-width:210px;width:210px">Account</th>
											<th style="background-color:#6c757d;color:white;min-width:180px;width:180px">Receive/Sisa IDR </th>
											<th style="background-color:#6c757d;color:white;min-width:120px;width:120px">IDR</th>
											<th style="background-color:#6c757d;color:white;min-width:100px;width:100px">Book Date</th>
											<th style="background-color:#6c757d;color:white;min-width:100px;width:100px">Due Date</th>
											<th style="background-color:#6c757d;color:white;min-width:220px;width:220px">Tenant</th> 
											<th style="background-color:#6c757d;color:white;min-width:200px;width:200px">Brand</th> 
										</tr>
										</thead>
										<tbody>
										</tbody>
										</table> 
									<!-- dgv header -->
									</div>
									
								<div class="tab-pane fade " id="tab_dgv-2" role="tabdlg">
								<!-- kredit --> 	
								<div class="row">
									<div class="col-md-6 form-group row">
										<div class="col-xs-12">
										  <label>Brand</label>
										  <div class="input-group input-group-sm"> 
										   
											<select data-placeholder="Select trade name ..." class="js-data-trade-ajax-dlg form-control" id="cboTradeNameDlg" name="rekananshipping_lineDlg" style="width:100%"> 
											</select>
											
											<input type="hidden" name="rekananshipping_line_dlg" id="rekananshipping_line_dlg" /> 
											<input type="hidden" name="rekananid_dlg" id="rekananid_dlg" /> 
										  </div>
										</div>
									</div> 
									<div class="col-md-4 form-group row">
										<div class="col-xs-12">
										<label> &nbsp; </label>
										<div class="input-group input-group-sm"> 
											<button type="button"  name="btnVerifyCredit" id="btnVerifyCredit" class="btn btn-sm btn-info waves-effect waves-themed">
												<span class="fal fa-folder-plus mr-1"></span> Find Aging
											</button>  
										</div>
										</div>
									</div> 
								</div>
								<table id="dt-basic-credit" class="table table-sm table-responsive table-bordered table-hover table-striped w-100" >
										<thead> 
											<th style="background-color:#6c757d;color:white;min-width:30px;width:30px">[-]</th>   
											<th style="background-color:#6c757d;color:white;min-width:180px;width:180px">Invoice</th>  
											<th style="background-color:#6c757d;color:white;min-width:200px;width:200px">Description</th>
											<th style="background-color:#6c757d;color:white;min-width:280px;width:280px">Account</th>
											<th style="background-color:#6c757d;color:white;min-width:180px;width:180px">Receive</th>
											<th style="background-color:#6c757d;color:white;min-width:180px;width:180px">IDR</th>
											<th style="background-color:#6c757d;color:white;min-width:100px;width:100px">Book Date</th>
											<th style="background-color:#6c757d;color:white;min-width:100px;width:100px">Due Date</th>
											<th style="background-color:#6c757d;color:white;min-width:220px;width:220px">Tenant</th> 
											<th style="background-color:#6c757d;color:white;min-width:220px;width:220px">Faktur</th> 
											<th style="background-color:#6c757d;color:white;min-width:100px;width:100px">ID</th>  
											<th style="background-color:#6c757d;color:white;min-width:80px;width:80px">Line</th> 
										</thead > 
										<tbody>
										</tbody>	
								</table>    
									<!-- dgv detil -->
								</div>
								</div> 
									<!-- datagrid -->
								</div> <!-- end tab-dlg -->
								
								</div>
								<div class="col-md-4 info">
									<div  class="m-1 p-2 font-weight-bold">
									<label class="form-label"> Refund </label>
									<input type="text" name="txtRefund" value='0' id="txtRefund" readonly />
									</div>
								</div>
								<div class="col-md-4 info">
									<div  class="m-1 p-2  font-weight-bold">
									<label class="form-label"> Invoice </label>
									<input type="text" name="txtRefund" value='0' id="txtInvoice" readonly />
									</div>
								</div>
								<div class="col-md-4 info">
									<div  class="m-1 p-2 font-weight-bold">
									<label class="form-label"> Sisa </label>
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