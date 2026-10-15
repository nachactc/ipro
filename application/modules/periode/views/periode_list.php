<script> 
function deleteid(){
	var msj='Are you sure to delete this row?';
   if (!confirm(msj)) {       
      return false;
   }
}

  $(document).ready(function(){

	var oTable=$('#colTable').DataTable({		     
		"pageLength": 25,
		"processing": true, 
		"serverSide": true,  
		"searching" : true,
		"ajax": {
			"url":  '<?php echo site_url('periode/periode/controler_gridlist')?>' ,
			"type": "POST"	
		}, 
		"columnDefs": [
		{
		"targets": [ -1 ], //last column
		"orderable": false, //set not orderable
		} 
		]
		}); 
		
	$('.searching').select2();
	$('#branch_select_list').select2();
	$('#tabedit').click(function() {
		alert('Please, select data from list');
		$("#tablist").trigger('click');
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
      <div class="portlet-body">
        <div class="tabbable-custom ">
          <ul class="nav nav-tabs ">
            <li class="active">
              <a href="#tab_5_1" data-toggle="tab" id='tablist'> LIST </a>
            </li>
            <li>
              <a href="<?php echo base_url('index.php/periode/periode/periodeadd'); ?>"  id='tabdata'> INPUT </a>
            </li>
            <li>
              <a href="#editdata"  id='tabedit'> EDIT </a>
            </li>
            <li>
              <a href="#closeyear" id='tabedit'> CLOSE YEAR </a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab_5_1">
              <div class="portlet light portlet-fit portlet-datatable bordered">
                <div class="portlet-body">
                  <div class="table-container">
                    <table class="table table-striped table-bordered table-hover " id='colTable' style="border-color: #E0E0E0;width:100%">                 
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Periode Name </th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Closed</th>  
                          <th>Create Date</th> 
                          <th>Create By</th> 
                          <th>Action Data</th>                       
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
</div>
<!-- END OF CONTENT -->