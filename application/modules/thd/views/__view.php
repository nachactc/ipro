<script>
$(document).ready(function() {
 $('.combo_reegion_id').select2({
		 placeholder: 'Pilih Data', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
	});  
 $('.combo_branch_id').select2({
		 placeholder: 'Pilih Data', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
	});   
	 
	$('#branch_cmb').select2({
      placeholder: 'Select an option',
      minimumInputLength: 2,
      //tags: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('tenant_history/getBranchAjax')?>',
          dataType: 'json',
          type: "GET",
          data: function (term, region) {
              return {
                  term: term,
                  region: $("#region_id").val()
              };
          },
          processResults: function (data) {
              return {
                  results: $.map(data.items, function (item) {
					
						 
                        // 	console.log(item.branch_name);
                      return {

                           text: item.branch_name, 
                           id: item.branch_id
						   //results: data
                      } 
                  })
              };
          }
      }
  });
  
	$('#branch_cmb').on("select2:select", function(e){
		var branch = e.params.data; 
		//console.log(branch);
		$('#branch_name').val(branch.text); 
		$('#branch_id_hidden').val(branch.id);
	});
}); 
</script> 
<div class="row">
	<div class="col-lg-12 col-md-12">		
		<?php 
                
               // echo create_breadcrumb();		
                $msg = $this->session->flashdata('message');
                $err = $this->session->flashdata('error');
                if (!empty($msg))
				{
		?> 
				<div class="alert alert-success fade in ">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
				  <strong>Info!</strong> <?php echo $msg; ?>
				</div>
		<?php
				}
                ?>
	</div>
</div><!-- /.row -->



<?php echo form_open(site_url($action),'role="form" class="form-horizontal" id="form_master_semesterbranch" parsley-validate'); ?> 
<div class="row">
<div class="col-md-4 form-group row">
	<div class="col-xs-12">
		<label for="region_id" class="control-label">Business Unit </label>
		<?php                  
		   echo form_dropdown(
				   'region_id',
				   $regionCmb,  
				   set_value('region_id',$regionCmb['region_id']),
				   'class="form-control combo_reegion_id"  id="region_id"'
				   );             
		  ?>  
								 
		  	
	</div> 
</div>
<div class="col-md-4 form-group row">
	<div class="col-xs-12">
		<label for="branch_id" class="control-label">Store</label> 
		<?php                  
		   echo form_dropdown(
				   'branch_id',
				   $items,  
				   set_value('branch_id',$items['branch_id']),
				   'class="form-control combo_branch_id"  id="branch_cmb"'
				   );             
		  ?>  
							 
	</div> 
	<input type="hidden" name="branch_name"  id="branch_name" value="<?php echo $items['branch_id'] != '' ? $items['branch_id'] : '' ?>">
	<input type="hidden" name="branch_id_hidden"  id="branch_id_hidden" value="<?php echo $branchCmb['branch_id'] != '' ? $branchCmb['branch_id'] : '' ?>">
	
</div> 
<div class="col-md-4 form-group row">
	<div class="col-xs-12">
		<label for="branch_id" class="control-label">Store</label> 
		<?php
         echo form_radio('tipe', '1', set_radio('tipe', '1', TRUE));
         echo form_radio('tipe', '0', set_radio('tipe', '0', FALSE));
		?>
	</div> 
	<input type="hidden" name="branch_name"  id="branch_name" value="<?php echo $items['branch_id'] != '' ? $items['branch_id'] : '' ?>">
	<input type="hidden" name="branch_id_hidden"  id="branch_id_hidden" value="<?php echo $branchCmb['branch_id'] != '' ? $branchCmb['branch_id'] : '' ?>">
	
</div> 

<p> </p>
<span> &nbsp;</span>    
<span> &nbsp;</span>    
<span> &nbsp;</span>    
 <button type="submit" class="btn btn-md btn-info" name="post">
				<i class="glyphicon glyphicon-floppy-save"></i> Load 
			</button>   
	  <!--/ button --> 
</div>
<?php echo form_close(); ?> 
 
 <div class="row"> &nbsp; </div> 
 
<div class="portlet-body" >
	  <div class="tab-content" >
	 
		<div class="tab-pane active" id="dropdown_1" align="right"> 
		  <div class="btn-group btn-group" >
			<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:;"> Export
			<i class="fa fa-angle-down"></i>
			</a>
			<ul class="dropdown-menu">
			  <li>
				<a href="<?php echo site_url('tenant_history/report_load_excel'); ?>"> Excel 
				</a>
			  </li> 
			</ul>
		  </div>
</div>
</div>
</div>


<div class="row"> &nbsp; </div>
<span> &nbsp; </span>
 <!-- CONTENT -->
            <div class="row">
              <div > 
                  <div class="portlet-body flip-scroll table-responsive">
                    <table class="table table-hover table-scroll table-bordered table-striped table-condensed flip-content " >
                      <thead class="flip-content">
                        <tr> 
						  <th width="60%">
                            Tipe
                          </th>
                          <th width="60%">
                            Tenant
                          </th>
                          <th class="numeric">
                            Level
                          </th>
                          <th class="numeric" width="70%">
                            Area (M2) OCC   
                          </th>
                          <th class="numeric">
                             Area (M2) VAC  
                          </th>
                          <th class="numeric">
                            Rental	(Rp)
                          </th>
                          <th class="numeric">
                            Service Charge (Rp)
                          </th>
                          <th class="numeric">
                            Masa Sewa (Bulan)
                          </th>
                          <th class="numeric">
                            Periode Sewa RCD
                          </th>
                          <th class="numeric">
                            Periode Sewa LED
                          </th>
                          <th class="numeric">
                            LOI Process
                          </th>
                          <th class="numeric">
                            LOI Sent
                          </th>
                          <th class="numeric">
                            LOI Received
                          </th>
                          <th class="numeric">
                            LOI Signed
                          </th>
                          <th class="numeric">
                            Invoicing No DP
                          </th>
                          <th class="numeric">
                            Invoicing DP
                          </th>
                          <th class="numeric">
                            Invoicing No SECDEP
                          </th>
                          <th class="numeric">
                            Invoicing SECDEP
                          </th>
                          <th class="numeric">
                            Payment DP
                          </th>
                          <th class="numeric">
                            Payment SECDEP
                          </th>
                          <th class="numeric">
                            Nama Penyewa
                          </th>
                          <th class="numeric">
                            Alamat
                          </th>
                          <th class="numeric">
                            Telp.
                          </th>
                          <th class="numeric">
                            Email
                          </th>
                          <th class="numeric">
                            PIC
                          </th>
                        </tr>
                      </thead>
                      <tbody>
					    <?php if ($tenant_history) : ?>
						<?php foreach ($tenant_history as $data) : ?>
					  <tr> 
					   
					   <td><?php echo $data['rekananshipping_type']; ?></td>
					   
					   <td><?php echo $data['rekananshipping_name']; ?></td>
					   
					   <td><?php echo $data['unit_nameshort']; ?></td>
					   
					   <td><?php echo $data['loo_id'] != '' ? $data['loodetil_space'] : ''; ?></td>
					   
					   <td><?php echo $data['loo_id'] == '' ? $data['loodetil_space'] : ''; ?></td>
					   
					   <td><?php echo number_format($data['rental'], 2); ?></td>
					   
					   <td><?php echo number_format($data['SC'], 2); ?></td>
					   
					   <td><?php echo $data['loo_term']; ?></td>
					   
					   <td><?php echo $data['loo_sdate'] != '' ? date('d-m-Y',strtotime($data['loo_sdate'])) : ''; ?></td>
					   
					   <td><?php echo $data['loo_edate'] != '' ? date('d-m-Y',strtotime($data['loo_edate'])) : ''; ?></td>
					   
					   <td><?php echo $data['loi_processdate'] != '' ? date('d-m-Y',strtotime($data['loi_processdate'])) : ''; ?></td>
					   
					   <td><?php echo $data['loi_sentdate'] != '' ? date('d-m-Y',strtotime($data['loi_sentdate'])) : ''; ?></td> 
					   
					   <td><?php echo $data['loi_receivedate'] != '' ? date('d-m-Y',strtotime($data['loi_receivedate'])) : ''; ?></td>
					   
					   <td><?php echo $data['loi_signeddate'] != '' ? date('d-m-Y',strtotime($data['loi_signeddate'])) : ''; ?></td>
					   
					   <td><?php echo $data['DP_Date'] == '' ? 'No.DP' : ''; ?></td>
					   
					   <td><?php echo $data['DP_Date'] != '' ? $data['DP_Date'] : ''; ?></td>
					   
					   <td><?php echo $data['SECDEP_Date'] == '' ? 'No.SECDEP' : ''; ?></td>
					   
					   <td><?php echo $data['SECDEP_Date'] != '' ? $data['SECDEP_Date'] : ''; ?></td>
					   
					   <td><?php echo $data['DP_Payment_Date'] != '' ? date('d-m-Y',strtotime($data['DP_Payment_Date'])) : ''; ?></td>
					   
					   <td><?php echo $data['SD_Payment_Date'] != '' ? date('d-m-Y',strtotime($data['SD_Payment_Date'])) : ''; ?></td>
					   
					   <td><?php echo $data['rekanan_name']; ?></td>
					   
					   <td><?php echo $data['rekanan_address']; ?></td>
					   
					   <td><?php echo $data['rekanan_telp']; ?></td>
					   
					   <td><?php echo $data['rekanan_fax']; ?></td>
					   
					   <td><?php echo $data['rekanan_email']; ?></td>
					   
					   <td><?php echo $data['rekananshipping_contactname']; ?></td>
					   
					   </tr> 
                        <?php endforeach; ?> 
                         <?php else: ?>
						<div class="alert alert-success fade in ">
						  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
						  <strong>Info!</strong> Belum Ada Data!
						</div>
				        <?php endif; ?> 
                      </tbody>
                    </table>
                  </div>
                
                <!-- END SAMPLE TABLE PORTLET-->
                
              </div>
            </div>
			 