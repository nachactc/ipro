<script> 
	function deleteid(){
		var msj='Are you sure to delete this row?';
		if (!confirm(msj)) {       
				return false;
		}
	}

  $(document).ready(function(){

		var oTable=popgrid("<?php echo site_url('utilities_kva/controler_gridlist')?>","colTable","lfrtip");

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
                  <div class="portlet-title">
                    <div class="caption" align="right">
                      <div class="actions">
                        <!-- <a href="javascript:;" class="btn green">
                        <i class="fa fa-file-o"></i> Posting </a> -->
                        <!-- <div class="btn-group">
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
                        </div> -->
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
                          <a href="<?php echo base_url('index.php/utilities_kva/utilities_kva_add'); ?>"  id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_5_1">
                          <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-body">
                              <div class="table-container">
                              
                       <table class="table table-striped table-bordered table-hover" 
                              id='colTable' style="border-color: #E0E0E0;">                 
                 		<thead>
                    		<tr>
                            <th>ID</th>
                        		<th>Name</th>
                        		<th>Tarif LWBP</th>
                       			<th>Tarif WBP</th>
                            <th>Create By</th>
                            <th>Create Date</th>
                        		<th>Modify By</th>
                        		<th>Modify Date</th>  
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
