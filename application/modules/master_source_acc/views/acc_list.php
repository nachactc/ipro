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
	var oTable=listgrid2("<?php echo site_url('master_source_acc/master_source_acc/controler_gridlist')?>","master_source_accTable","lfrtip"); 
    //new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } ); 
  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  		$("#tablist").trigger('click');
  		});
		
	$('.searching').select2(); 
	$('#branch_select_list').select2();
	
	  
	
  });
  
function listgrid2(vlink,namatable,optsearch, pLength=10, aCenter=[]){
	
	var selected = [];
		$('#'+namatable+' tbody').on( 'click', 'tr', function () {
	    	$(this).toggleClass('selected');
		} );
		
	var oTable=$('#'+namatable).DataTable({
		//"scrollY": "300px",
        //"scrollX": true,
        //"scrollCollapse": true,        
		"pageLength": pLength,
		"processing": true, 
		"serverSide": true, 
		"order": [],
		"searching" : true,
		"ajax": {
			"url": vlink,
			"type": "POST"	
		},
		"rowCallback": function( row, data ) {
	            if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
	                $(row).addClass('selected');
	            }
		},
		"columnDefs": [
			{
		"targets": [ 2 ], //last column
		"width": "20%", //set not orderable
		},
		{
		"targets": [ -1 ], //last column
		"orderable": false, //set not orderable
		},
		 {
	      "targets": aCenter,
	      "className": "text-center",
		 }
		],
		dom:optsearch
		});

	return oTable;
}

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
						<?php echo form_open(base_url('index.php/master_source_acc/master_source_acc/controler_gridlist')); ?>
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
<!--						<div class="btn-group">	
						<div class="col-md-13">
							  <?php 
							  //echo form_dropdown('branch_id', $branch,'','id="branch_select_list" class="form-control input-sm"');
							  ?>
							</div>
						</div>   -->
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
                          <a href="<?php echo base_url('index.php/master_source_acc/master_source_acc/master_source_accadd'); ?>"  id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata"  id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_5_1">
                          <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-body">
                              <div class="table-responsive">                                
                                 <table class="table table-striped table-hover nowrap" id='master_source_accTable' style="border-color: #E0E0E0;">
                                 	  <thead>
                                  		<tr>
                                        <th>Source ID</th>
                                    	<th>Acc ID</th>
                                    	<th>Acc Name</th>
                                    	<th>D/K</th>
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
