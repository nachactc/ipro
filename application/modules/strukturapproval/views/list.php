 
<style>
table.dataTable td {
    padding:2px;
    font-size: 9pt;    
}

label {
  font-size: 9pt;
  font-weight: bold;
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
							  <a class="btn green dropdown-toggle" href="javascript:;" data-toggle="collapse" role="button" aria-expanded="false" data-target="#searching" ><i class="fa fa-search"></i> Filter             
							  </a>              
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
                          <a href="<?php echo base_url('index.php/').$this->uri->segment(1).'/'.$this->uri->segment(2).'/add'; ?>"  id='tabdata'> INPUT </a>
                        </li> 
						<li>
                          <a href="#editdata" id='tabedit'  data-toggle="tab"> EDIT </a>
                        </li>
					   </ul> 
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_5_1">
                          <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-body">
							  <form id="searchForm" name="searchForm" method="POST">
							  <!-- pencarian -->
                              <div class="row collapse" id="searching">
							  
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                      <input id="isID" type="checkbox">ID(s)                                      
                                    </label>                              
                                     <textarea id = "sID" name="sID" class="form-control input-sm" rows="3" readonly ></textarea>
                                  </div>
                                </div> 
								
                                 <div class="col-md-2" style="float:right;">
								 <div class="row"> &nbsp; </div>
                                  <div class="col-xs-12" > 
									<div class="btn-group">    
										<button type="submit" form="searchForm" id="searchSubmit" name="searchSubmit" class="btn btn-sm btn-info waves-effect waves-themed">
											<span class="fa fa-history"></span>
											Load
										</button>
									  </a>              
									</div> 
                                  </div>
                                </div> 
								</form>
                              </div>
							  <div class="row"> &nbsp; </div> 
							  <!-- pencarian -->
							  
							  <!-- grid -->
                              <div class="table-container">                
                                <table class="table table-striped table-hover compact nowrap" id='JTable' style="width:100%;border-color: #E0E0E0;">
									<thead>
										<tr>
											<th>Strukturunit</th>
											<th>Line</th>
											<th>Name</th>
											<th>Position</th> 
											<th>Value</th> 
											<th>Header</th> 
											<th>Type</th> 
											<th>Disabled</th> 
											<th>Date</th> 
											<th>Action</th>                      
										</tr>              
									</thead>
									<tbody>
									</tbody>
                          	    </table>                                 
                              </div> 
							  <!-- grid -->
							   
                            </div>
                          </div>
                        </div> 
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT -->