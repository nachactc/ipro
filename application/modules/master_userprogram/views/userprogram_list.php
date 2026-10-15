<script> 
  function deleteid(val){  

     if (val != ''){

      var msj='Are you sure to drop this row?';
      if (!confirm(msj)) {

        return false;
      }   

     }else{

      return false;
     }    	
  }

  $(document).ready(function(){
	$('#username').select2(); 
	$('#group_id').select2(); 
	
	$("#checkAll").click(function(){
		$('input:checkbox').not(this).prop('checked', this.checked);
	});
	
	
	$('#group_id').on("select2:select", function(e) {
		$('#btn_search_').click();
	});
	
  });
  

</script>

<style>
table.dataTable td {
    padding:2px;
    font-size: 9pt;    
}

.DTFC_LeftBodyLiner {

overflow-x: hidden;

}

.DTFC_RightBodyLiner {

overflow-x: hidden;

}

</style>
 <!-- CONTENT -->
            <div class="row">
              <div class="col-md-12">
                <div class="portlet">
                  <div class="portlet-title">
                    <div class="caption" align="right">
					  
                      <div class="actions">      
						<?php echo form_open(base_url('index.php/loo/loo/controler_gridlist')); ?>
						<div class="btn-group">
                          <a class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> <i class="fa fa-print"></i> Export
                          <i class="fa fa-angle-down"></i>
                          </a>
                          <ul class="dropdown-menu pull-right">
                            <li>
                              <a href="javascript:;">
                              <i class="fa fa-file-pdf-o"></i> PDF </a>
                            </li>
                            <li>
                              <a href="javascript:;">
                              <i class="fa fa-file-excel-o"></i> EXCEL </a>
                            </li>
                          </ul>
                        </div>
						
								
						
						<div class="btn-group">					  
							<div class="col-md-13">
							  <select class="searching form-control input-sm" name="searchStatus" id="statusData" data-placeholder="Pilih Data" >
									<option value="K">
										Pilih Data
									</option>									 
									 <option value="all">
										ALL
									  </option> 
									  <option value="app">
										Disabled
									  </option>
									  <option value="ret">
										Enabled
									  </option>  
							  </select> 
								
							</div>   					  
							  
						</div>   
						</div>   
						
						<?php echo form_close(); ?>
						
                      </div>
                    </div>
                    <div class="tools">
                      <a href="javascript:;" class="collapse"> </a>
                      <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                    </div>
                  </div>
                  <div class="portlet-body">
                    <div class="tabbable-custom ">
                      <ul class="nav nav-tabs ">
                        <li class="active">
                          <a href="#tab_5_1" data-toggle="tab" id='tablist'> LIST </a>
                        </li> 
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_5_1">
                          <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-body">
							
							 <form action="<?php echo site_url('master_userprogram/programuserweb/userlist');?>" method="post" > 
                    <div class="row">
                      <div class="col-md-12">
                                
								<div class="col-md-5"> 
                                <label>User</label>
								   <div class="col-xs-11 input-group input-group-sm"> 
									  
									   <?php                   
									   echo form_dropdown(
											   'username',
												 $username_list,   
												$username,
											   'class="form-control" id="username" required'
											   );             
									  ?>
									</div>
								</div> 
								 
								<div class="col-md-5"> 
                                <label>Group</label>
								   <div class="col-xs-11 input-group input-group-sm"> 
									  
									   <?php                   
									   echo form_dropdown(
											   'group_id',
												 $group_id,   
												$groupid,
											   'class="form-control" id="group_id" required'
											   );             
									  ?>
									</div>
								</div>   
							   
                                    <!-- /.col --> 
									<div class="col-md-5"> 
									<div class="col-xs-10 input-group input-group-sm"> 
										<br/>
										<input type="submit" value="Search" id="btn_search_" class="btn btn-sm btn-info" style="display:none;" />
									</div>
									</div>
                                 
                              </div>
                             </div>
                            </form>
                            
							<div class="row">&nbsp;</div>
							
                              <div class="table-container">                                
                                <form action="<?php echo site_url('master_userprogram/programuserweb/savelist/'.$groupid.'/'.$username);?>" method="post" >  
								 <table class="table table-striped table-hover nowrap" id='' style="border-color: #E0E0E0;">
                                 	  <thead>
                                  		<tr>
                                        <th ><input type="checkbox" id="checkAll"/></th>
                                        <th>Program ID</th>
                                    	<th>Program Title</th>
                                        <th>Program Url</th>
                                        <th>Program Controller</th>                       
                                  		</tr>              
                				       </thead>
                              		<tbody>
										<?php if(!empty($result)) { 
										foreach($result as $row) {
										?>
											<tr>
												<td> <input type="checkbox" name="pilih[]" <?php echo ($row->flag == 1) ? 'checked' : ''; ?> value="<?php echo $row->program_id; ?>"> 
												<input type="hidden" name="program_ids" value="<?php echo $row->program_id; ?>" />  
												</td>
												<td> <?php echo $row->program_id; ?> </td>
												<td> <?php echo $row->program_title; ?> </td>
												<td> <?php echo $row->program_url; ?> </td>
												<td> <?php echo $row->program_controller; ?> </td>
											</tr>
										<?php }} ?>
                              		</tbody>
                            	   </table>
								<div class="row">
									 <div class="col-xs-12">
                                    <br /><input type="submit" value="Save" class="btn btn-sm btn-info" />
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
              </div>
              <!-- END OF CONTENT -->