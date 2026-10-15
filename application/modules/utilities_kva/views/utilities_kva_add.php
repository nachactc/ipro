<script>

$(document).ready(function(){
	var arrid= [];
	//lfrtip =default
	//var oTable=listgrid("<?php //echo site_url('accounting/modcollection/collection/controler_griddialog')?>","spLoader","trp");
	 
		
	$("#tabdata").trigger('click');
	
	$('#tabedit').click(function() {
		alert('Please, select data from list');
	});			
	
});

</script>

 <div class="modal fade" id="modal-default">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Success!</h4>
              </div>
              <div class="modal-body">
                <p>Data has been saved&hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default center-block" data-dismiss="modal">Close</button>                
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
                          <a href="<?php echo base_url('index.php/utilities_kva/utilities_kva_list'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="#newdata" data-toggle="tab" id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        
                        <div class="tab-pane" id="newdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('utilities_kva/utilities_kva_insert');?>" method="post" onsubmit="">
                            <?php 
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>                                   
                    <div class="row">
                        <div class="col-md-10">                                  
                                  <div class="col-md-6">
                                      <label>ID</label>                                       
                                      <input  type="text" id="utilitieskva_id" name="utilitieskva_id" class="form-control" value="<?php echo $row->utilitieskva_id;?>" readonly>
                                  </div>                                     
                                  <!-- /.form group -->                                  
                                  <div class="col-md-6">
                                      <label>Name</label>
                                      <input type="text" id = "utilitieskva_name" name="utilitieskva_name" class="form-control" value="<?php echo $row->utilitieskva_name;?>" placeholder="Wajib Isi">
                                  </div>                                
																	<div class="col-md-6">
                                    <label>Tarif LWBP </label>
                                    <input type="text" id = "utilitieskva_tariflwbp" name="utilitieskva_tariflwbp" class="form-control" value="<?php echo $row->utilitieskva_tariflwbp;?>" placeholder="Wajib Isi">
                                	</div>
                                	<div class="col-md-6">
                                    <label>Tarif WBP </label>
                                    <input type="text" id = "utilitieskva_tarifwbp" name="utilitieskva_tarifwbp" class="form-control" value="<?php echo $row->utilitieskva_tarifwbp;?>" placeholder="Wajib Isi">
                                	</div>

																		 <div class="col-md-12">                                   
                                   <br><br>
                                   <!--
                                   <a href="javascript:void(0)" id="btdetil">Add Detil</a>   
                                   <br> 	--->
                                      <!-- Custom Tabs -->
                                      <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                          <li class="active"><a href="#tab_1" data-toggle="tab" role= "tab">Record</a></li>                                          
                                        </ul>
                                        <div class="tab-content">                                         
                                          <div class="tab-pane active" id="tab_1">
                                            <div class="row">
																						<div class="col-md-6">
																										<label>Create By </label>
																										<input type="text" id = "utilitieskva_createby" name="utilitieskva_createby" class="form-control" value="<?php echo $row->utilitieskva_createby;?>" readonly>
																								</div>
																								<div class="col-md-6">
																										<label>Create Date </label>
																										<input type="text" id = "utilitieskva_createdate" name="utilitieskva_createdate" class="form-control" value="<?php echo $row->utilitieskva_createdate;?>" readonly>
																								</div>  
																								<div class="row"></div>
																								<div class="col-md-6">
																										<label>Modify By </label>
																										<input type="text" id = "utilitieskva_modifyby" name="utilitieskva_modifyby" class="form-control" value="<?php echo $row->utilitieskva_modifyby;?>" readonly>
																								</div>
																								<div class="col-md-6">
																										<label>Modify Date </label>
																										<input type="text" id = "utilitieskva_modifydate" name="utilitieskva_modifydate" class="form-control" value="<?php echo $row->utilitieskva_modifydate;?>" readonly>
																								</div>  
                                             </div>                               
                                          </div>                                                    
                                          <!-- /.tab-pane -->                                          
                                        </div>
                                        <!-- /.tab-content -->
                                      </div>
                                      <!-- nav-tabs-custom -->
                                    </div>
                                    <!-- /.col -->
                                <div class="col-xs-12">
                                    <br /><input type="submit" value="SUBMIT" class="btn btn-sm btn-info" />
                                </div>
                            </form>
                            <?php }}?>	
                            
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT -->
