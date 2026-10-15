<script> 
  function deleteid(val){  

     if (val == 0){

      var msj='Are you sure to drop this row?';
      if (!confirm(msj)) {

        return false;
      }   

     }else{

      return false;
     }    	
  }

  $(document).ready(function(){
	var oTable=listgrid("<?php echo site_url('loo/loo/controler_gridlist')?>","looTable","lfrtip"); 
    new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } ); 
  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  		$("#tablist").trigger('click');
  		});
		
	$('.searching').select2();
	
    $('#statusData').on('change', function() {  
		val_search = $('#statusData').val();
		if ( $.fn.dataTable.isDataTable( '#looTable' ) ) {
			oTable.destroy();
			oTable=listgrid("<?php echo site_url('loo/loo/controler_gridlist/')?>"+val_search,"looTable","lfrtip");   
		}
		else {
			 oTable = $('#looTable').DataTable();
		}	
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
										Approved
									  </option>
									  <option value="ret">
										Returned
									  </option> 
									   <option value="not_app">
										Not Approved
									  </option>
									  <option value="not_ret">
										Not Returned
									  </option> 
							  </select> 
								
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
                        <li>
                          <a href="<?php echo base_url('index.php/loo/loo/looadd'); ?>"  id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata"  id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_5_1">
                          <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-body">
                              <div class="table-container">                                
                                 <table class="table table-striped table-hover nowrap" id='looTable' style="border-color: #E0E0E0;">
                                 	  <thead>
                                  		<tr>
                                        <th>ID</th>
                                    		<th>Date</th>
                                        <th>Begin</th>
                                        <th>End</th>
                                        <th>Term</th>
                                        <th>B. Unit</th>
                                    		<th>Store</th>
                                    		<th>Tenant</th>  
                                        <th>Brand</th>  
                                        <th>App.</th>
                                        <th>Ret.</th>
                                        <th>Action</th>                      
                                  		</tr>              
                				            </thead>
                              		<tbody>
                              		</tbody>
                            	   </table>                                 
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