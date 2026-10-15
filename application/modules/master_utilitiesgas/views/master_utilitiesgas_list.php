<script> 
function deleteid(){
	var msj='Are you sure to delete this row?';
   if (!confirm(msj)) {       
      return false;
   }
}

  $(document).ready(function(){

	var oTable=listgrid("<?php echo site_url('master_utilitiesgas/master_utilitiesgas/controler_gridlist')?>","colTable","lfrtip");
	 
	$('.searching').select2();
	$('#branch_select_list').select2();
	$('#tabedit').click(function() {
		alert('Please, select data from list');
		$("#tablist").trigger('click');
		});
	
	$('#statusData').on('change', function() {  
		val_search = $('#statusData').val();
		val_search_branch = $('#branch_select_list').val();
		//alert(val_search);
		if ( $.fn.dataTable.isDataTable( '#colTable' ) ) {
			oTable.destroy();
			if(val_search != '' && val_search_branch != '')
			{
				oTable=listgrid("<?php echo site_url('master_utilitiesgas/master_utilitiesgas/controler_gridlist/')?>"+val_search+"/"+val_search_branch,"colTable","lfrtip");  
			}
			if(val_search_branch == '')
			{
				oTable=listgrid("<?php echo site_url('master_utilitiesgas/master_utilitiesgas/controler_gridlist/')?>"+val_search,"colTable","lfrtip");  
			}   
		}
		else {
			 oTable = $('#colTable').DataTable();
		}	
	});
	$('#branch_select_list').on('change', function() { 		
		val_search = $('#statusData').val();	
		val_search_branch = $('#branch_select_list').val();
		//alert(val_search);
		if ( $.fn.dataTable.isDataTable( '#colTable' ) ) {
			oTable.destroy();
			if(val_search != '' && val_search_branch != '')
			{
				oTable=listgrid("<?php echo site_url('master_utilitiesgas/master_utilitiesgas/controler_gridlist/')?>"+val_search+"/"+val_search_branch,"colTable","lfrtip");  
			}
			if(val_search_branch == '')
			{
				oTable=listgrid("<?php echo site_url('master_utilitiesgas/master_utilitiesgas/controler_gridlist/')?>"+val_search,"colTable","lfrtip");  
			}
			 
		}
		else {
			 oTable = $('#colTable').DataTable();
		}	
	});			
  });

</script>

<style>
table.dataTable td {
    padding:2px;
    font-size:9pt;
}
</style>
 <!-- CONTENT -->
            <div class="row">
              <div class="col-md-12">
                <div class="portlet">
                  <div class="portlet-title">
                    <div class="caption" align="right">
                     <div class="actions">      
						<?php echo form_open(site_url('master_utilitiesgas/master_utilitiesgas/controler_gridlist/')); ?>
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
									 <option value="avail">
										Disabled
									  </option> 
									  <option value="sold">
										Enabled
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
                          <a href="<?php echo base_url('index.php/master_utilitiesgas/master_utilitiesgas/master_utilitiesgasadd'); ?>"  id='tabdata'> INPUT </a>
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
                              
                       <table class="table table-striped table-bordered table-hover " 
                              id='colTable' style="border-color: #E0E0E0;">                 
                 		<thead>
                    		<tr>
								<th>ID</th>
                        		<th>Name</th>
                        		<th>D. Pipa</th>
                       			<th>Adm &</th>
                       			<th>Adm Rp.</th>
                       			<th>Tarif</th>
                       			<th>PH Air Kotor</th>
								<th>PH Meter</th>
								<th>Additional</th>
                        		<th>M Faktor</th>
								<th>Pressure</th>
                        		<th>Use Awal Akhir</th>
								<th>Disabled</th>								
								<th>Action</th>                       
                    		</tr>              
				          </thead>
                  		<tbody>
                  		</tbody>
                	</table>

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