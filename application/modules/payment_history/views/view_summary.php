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
<p> </p>
<span> &nbsp;</span>    
 <button type="submit" class="btn btn-md btn-info" name="post">
				<i class="glyphicon glyphicon-floppy-save"></i> Load 
			</button>   
	  <!--/ button --> 
</div>
<?php echo form_close(); ?> 
 
 
<div class="portlet-body" >
	  <div class="tab-content" >
	 
		<div class="tab-pane active" id="dropdown_1" align="right"> 
		  <div class="btn-group btn-group" >
			<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:;"> Export
			<i class="fa fa-angle-down"></i>
			</a>
			<ul class="dropdown-menu">
			  <li>
				<a href="<?php echo site_url('tenant_history/report_load_excel_summary'); ?>"> Excel 
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
                            Category
                          </th>
                          <th class="numeric">
                            TOTAL NLA
                          </th>
                          <th class="numeric" width="70%">
                            OCC   
                          </th>
                          <th class="numeric">
                            VAC  
                          </th>
                          <th class="numeric">
                            TOTAL TENANT
                          </th>
                          <th class="numeric">
                            TRI PROCESS
                          </th> 
                          <th class="numeric">
                            NOT YET SIGNED
                          </th>
                          <th class="numeric">
                            SIGNED
                          </th>
                          <th class="numeric">
                            NO DP
                          </th>
                          <th class="numeric">
                            DP
                          </th>
                          <th class="numeric">
                            NO SECDEP
                          </th>
                          <th class="numeric">
                            SECDEP
                          </th>
                          <th class="numeric">
                            PAYMENT DP
                          </th>
                          <th class="numeric">
                            PAYMENT SECDEP
                          </th>
                          
                           
                        </tr>
                      </thead>
                      <tbody>
					    <?php if ($tenant_history) : ?>
						<?php foreach ($tenant_history as $data) : ?>
					  <tr> 
					   
					   <td><?php echo  $data['rekananshipping_type']; ?></td>
					   
					   <td><?php echo $data['TOTAL']; ?></td>
					   
					   <td><?php echo  $data['OCC'];?></td>
					   
					   <td><?php echo  $data['VACCANT']; ?></td>
					   
					   <td><?php echo  $data['TOTAL_TENANT']; ?></td>
					   
					   <td><?php echo  $data['TRI_PROCESS']; ?></td>
					   
					   <td><?php echo $data['NOT_YET_SIGNED']; ?></td>
					   
					   <td><?php echo  $data['SIGNED']; ?></td>
					   
					   <td><?php echo  $data['NO_DP']; ?></td>
					   
					   <td><?php echo  $data['DP']; ?></td>
					   
					   <td><?php echo  $data['NO_SECDEP']; ?></td> 
					   
					   <td><?php echo $data['SECDEP_Date']; ?></td>
					   
					   <td><?php echo  $data['DP_Payment_Date']; ?></td>
					   
					   <td><?php echo  $data['SD_Payment_Date']; ?></td>
					   
					    
					   
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
			 