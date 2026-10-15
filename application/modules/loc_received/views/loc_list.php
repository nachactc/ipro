<script> 
  function deleteid(val,val2){  

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

  	// var oTable=listgrid("<?php echo site_url('loc_received/loc_received/controler_gridlist')?>","looTable","lfrtip");
	//new $.fn.dataTable.FixedColumns( oTable, { leftColumns:0  } ); 
   // new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } );
	
	// var table =  $('#looTable').DataTable( {
        // "processing": true,
        // "serverSide": false,
		// "searching": false,
		// "paging": false,
		 // "info": false,
        // "ajax": "<?php echo site_url('loi_received/loi_received/get_data_loi')?>"
    // } );
	function replaceAll(str, find, replace) {
    return str.replace(new RegExp(find, 'g'), replace);
}
   var oTable = $("#looTable").DataTable({
            "processing": true,
            "serverSide": false,
            "ajax": "<?php echo site_url('loc_received/loc_received/controler_gridlist')?>",
            "columns": [ 
                { "data": "LOC", "title":"ID.LOC" },
                { "data": "REGIONAME", "title":"B.Unit" },
                { "data": "BRANCHNAME", "title":"Store" },
                { "data": "REKANANNAME", "title":"Tenant" }, 
                { "data": "BRANDNAME", "title":"Brand" }, 
                { "data": null, "title":"Action" ,
					 render: function ( data, type, row ) {
						 
						 var i_link = replaceAll(data.LOC,'/','_'); 
						 
                        return ' <a href="<?php echo site_url(); ?>/loc_received/loc_received/loc_statusedit/'+i_link+'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> '+
                     '<a href="<?php echo site_url(); ?>/loc_received/loc_received/loc_statusdel/'+i_link+'" data-toggle="tooltip" title="Delete" onclick="return confirm(\'Anda yakin menghapus Data '+data.REKANANNAME+' ?\');"><i class="fa fa-trash"></i></a>';
                    },  
                  "orderable": false
				},  
            ],
            "order": [[1, 'asc']] 
        } ); 
	 
	$('#searching_t').on( 'keyup', function () {
	   var searchTenant  = $("#searching_t").val(); 
		 //console.log(searchTenant);
		
		// table.search(searchTenant).draw();
		if ( $.fn.dataTable.isDataTable( '#looTable' ) ) {
			
			table.destroy();
			// oTable=listgrid("<?php echo site_url('la_received/dialog_loo/')?>"+val_search,"looTable","lfrtip");  
			table =  $('#looTable').DataTable( {
					"processing": true,
					"serverSide": false,
					"searching": false,
					"paging": false,
					 "info": false,
					"ajax": "<?php echo site_url('loc_received/loc_received/get_data_loi/')?>"+searchTenant
				} );		 
			
		}
		else {
			table.DataTable({
				"processing": true,
				"serverSide": false,
				"searching": false,
				"paging": false,
				"info": false 
			}); 
		}  
	} );
	
  	$('#tabedit').click(function() {
  		//alert('Please, select data from list');
  		$("#tablist").trigger('click');
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
                        <div class="btn-group">
                          <a class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> <i class="fa fa-search"></i> Advanced Search
                          <i class="fa fa-angle-down"></i>
                          </a>
                          <ul class="dropdown-menu pull-right">
                            <br>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="contain">
                                  Author
                                </label>
                                <input class="form-control" type="text" />
                              </div>
                              <div class="form-group">
                                <label for="contain">
                                  Contains the words
                                </label>
                                <input class="form-control" type="text" />
                              </div>
                              <div class="form-group">
                                <label for="contain">
                                  Select Option
                                </label>
                                <select class="form-control">
                                  <option>
                                    Option 1
                                  </option>
                                  <option>
                                    Option 2
                                  </option>
                                  <option>
                                    Option 3
                                  </option>
                                  <option>
                                    Option 4
                                  </option>
                                  <option>
                                    Option 5
                                  </option>
                                </select>
                                <br>
                                <button type="search" class="btn blue">
                                  Search
                                </button>
                              </div>
                            </div>
                          </ul>
                        </div>
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
                          <a href="<?php echo base_url('index.php/loc_received/loc_received/locreceived_add'); ?>"  id='tabdata'> INPUT </a>
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
								 					  
								<input type="hidden" id="searching_t" class="input-sm" size="25">							  
								 
                                 <table class="table table-striped table-hover nowrap" id='looTable' style="border-color: #E0E0E0;">
                                 	  
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