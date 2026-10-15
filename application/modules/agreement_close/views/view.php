<script> 
  function CloseID(val){ 
     if (val != 0){

      var msj='Are you sure to Close This Agreement ?';
      if (!confirm(msj)) {

        return false;
      }   

     }else{

      return false;
     }    	
  }

  $(document).ready(function(){
	  
	var oTable=listgrid("<?php echo site_url('agreement_close/controler_gridlist')?>","looTable","lfrtip"); 
	 
  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  		$("#tablist").trigger('click');
  		});
		
	$('.searching').select2();
	$('#branch_select_list').select2();
	
    $('#statusData').on('change', function() {  
		val_search = $('#statusData').val();
		if ( $.fn.dataTable.isDataTable( '#looTable' ) ) {
			oTable.destroy();
			oTable=listgrid("<?php echo site_url('agreement_close/controler_gridlist/')?>"+val_search,"looTable","lfrtip");   
		}
		else {
			 oTable = $('#looTable').DataTable();
		}	
	});
	
	
	$('#btdialog').click(function(){
		$('#formAgrClose').submit();
	});
	
	$('#statusData').on('change', function() {  
		val_search = $('#statusData').val();
		val_search_branch = $('#branch_select_list').val();
		//alert(val_search);
		if ( $.fn.dataTable.isDataTable( '#looTable' ) ) {
			oTable.destroy();
			if(val_search != '' && val_search_branch != '')
			{
				oTable=listgrid("<?php echo site_url('agreement_close/controler_gridlist/')?>"+val_search+"/"+val_search_branch,"looTable","lfrtip"); 
				oTable.draw();				
				new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } ); 
			}
			if(val_search_branch == '')
			{
				oTable=listgrid("<?php echo site_url('agreement_close/controler_gridlist/')?>"+val_search,"looTable","lfrtip");  
				oTable.draw();
				new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } ); 
			}   
		}
		else {
			 oTable = $('#looTable').DataTable();
		}	
	});
	$('#branch_select_list').on('change', function() { 		
		val_search = $('#statusData').val();	
		val_search_branch = $('#branch_select_list').val();
		//alert(val_search);
		if ( $.fn.dataTable.isDataTable( '#looTable' ) ) {
			oTable.destroy();
			if(val_search != '' && val_search_branch != '')
			{
				oTable=listgrid("<?php echo site_url('agreement_close/controler_gridlist/')?>"+val_search+"/"+val_search_branch,"looTable","lfrtip");   
				oTable.draw();
				new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } ); 
			}
			if(val_search_branch == '')
			{
				oTable=listgrid("<?php echo site_url('agreement_close/controler_gridlist/')?>"+val_search,"looTable","lfrtip");  
				oTable.draw();
				new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } ); 
			}
			 
		}
		else {
			 oTable = $('#looTable').DataTable();
		}	
	});	
  
  $('#looTable tbody').on( 'click', 'td #CloseIDData', function() {
		 //
		 oTable = $('#looTable').DataTable();
		var ids = $.map(oTable.rows(this).data(), function (item) {
        return item[0]
    });
    //console.log( ids);
		  
		  var msj='Are you sure to Close This Agreement '+ ids +' ?';
      
	  if (!confirm(msj)) {

        return false;
      } else{ 
     $('#agreement_id_val').val(ids); 
		 $("#mdldialog").modal("show");
     }     
	});
	
	// $('#looTable').on('click','#CloseIDData', function() {
		 
		 // oTable = $('#looTable').DataTable();
		 // var data = oTable.row(this).data();
		 // var data=oTable.rows( { selected: true }).data();
         // console.log("data---"+data);   
		 
		 // var idAgr = data[0].trim(); 
		  // var msj='Are you sure to Close This Agreement '+ data[0] +' ?';
      
	  // if (!confirm(msj)) {

        // return false;
      // } else{ 
     // $('#agreement_id_val').val(idAgr); 
		 // $("#mdldialog").modal("show");
     // }     
	// });
  
  $.fn.datepicker.defaults.format = "yyyy-mm-dd"; 
  $.fn.datepicker.defaults.autoclose = true; 
  
    new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } ); 
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

<!-- dialog -->
<div class="modal fade" id="mdldialog" role="basic" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            </button>
                            <h4 class="modal-title">
                              Agreement Close
                            </h4>
                          </div>
                          <div class="modal-body">
                            <form action="<?php echo site_url('agreement_close/agrclose_data'); ?>" id="formAgrClose" class="form-horizontal" method="POST"> 
                           <div class="portlet-body">
							<div class="row">
								<div class="col-md-12">
								
									<div class="col-md-4 form-group row">
										<div class="col-xs-12">
										  <label>Agreement</label>
											<input type="text" id = "agreement_id_val" name="agreement_id" class="form-control input-sm"  readonly>
										</div>
									  </div>  
									<div class="col-md-4 form-group row">
										<div class="col-xs-12">
										  <label>Close Date</label>
										   <div class="input-group date" data-provide="datepicker">
											<div class="input-group-addon">
											  <i class="fa fa-calendar"></i>
											</div>
											  <input type="text" class="form-control input-sm pull-right" id="closing_date" name="closing_date" >
										  </div>
										</div>
									  </div> 
									<div class="col-md-4 form-group row">
										<div class="col-xs-12">
										  <label>Reason</label>
											<input type="text" id = "closing_reason_val" name="closing_reason" class="form-control input-sm"  >
										</div>
									  </div>  
									<div class="row"></div>
									<div class="col-md-4 form-group row">
										<div class="col-xs-12">
										  <label>Description</label>
										   <textarea id = "closing_desc_val" name="closing_desc" class="form-control input-sm" required rows="3" style="width:450px;"></textarea> 
										</div>
									  </div>  
								</div>  
							</div>  
                        </div>
                        <br />
                        </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">
                              Close
                            </button>
                            <button type="button" class="btn green" data-dismiss="modal" id="btdialog">
                              Submit
                            </button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
</div>
 
 
 <!-- CONTENT -->
            <div class="row">
              <div class="col-md-12">
                <div class="portlet">
                   <div class="portlet-title">
                    <div class="caption" align="right">
                     <div class="actions">      
						<?php echo form_open(site_url('agreement_close/controler_gridlist/')); ?> 
						
								
						
						<div class="btn-group">					  
							<div class="col-md-13">
							  <select class="searching form-control input-sm" name="searchStatus" id="statusData" data-placeholder="Pilih Data" >
									<option value="K">
										Pilih Data
									</option>									 
									 <option value="avail">
										Available
									  </option> 
									  <option value="close">
										Close
									  </option>  
							  </select>  
							</div>  
						</div>    
						<div class="btn-group" align="left">					  
							<div class="col-md-13">
							  <?php 
							  echo form_dropdown('branch_id', $branch,'','id="branch_select_list" class="form-control input-sm"');
							  ?>
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
                                        <th>Contract No</th>
                                        <th>VA</th>
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