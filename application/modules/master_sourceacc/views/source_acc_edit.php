<script>
$(document).ready(function() {
	$("#tabedit").trigger('click');
	$('#group_id').select2();
	$.fn.datepicker.defaults.format = "yyyy-mm-dd"; 
    $.fn.datepicker.defaults.autoclose = true; 
	 
}); 
</script> 
 
<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

.table td{
    padding:2px;
    font-size: 9pt;
    font-family:  Arial, Verdana, sans-serif;

}

label {
  font-size: 9pt;
}

</style> 
    <div id="popover-form" class="hide">
      <div class="form-group">
        <textarea rows="4" name="txtContent" id="txtContent" class="form-control input-sm"></textarea>        
        <br>
        <button id="btnOk" type="button" class="btn btn-primary">
          <span class="glyphicon glyphicon-ok"></span>&nbsp;
        </button>  
        <button id="btnCancel" type="button" class="btn btn-default">
          <span class="glyphicon glyphicon-remove"></span>&nbsp;
        </button>
      </div>
    </div>
   

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
                          <a href="<?php echo base_url('index.php/master_sourceacc/source_acc/source_acclist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="<?php echo base_url('index.php/master_sourceacc/source_acc/source_acc_add'); ?>"  id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata" data-toggle="tab" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane" id="editdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('master_sourceacc/source_acc/programedit');?>" method="post" > 
				    <?php
					if(!empty($result)) { 
					?>
                    <div class="row">
                      <div class="col-md-12">  
								   
                                   
                                    <input  type="hidden" id="id_" name="id_" class="form-control input-sm" value="<?php echo $result->id_;?>" >
                                     
								   
                                  <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>Source ID</label>
                                      <input  type="text" id="source_id" name="source_id" class="form-control input-sm" value="<?php echo $result->source_id;?>" >
                                    </div>
                                  </div>
								  
                                  <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>Acc ID</label>
                                      <input  type="text" id="acc_id" name="acc_id" class="form-control input-sm" value="<?php echo $result->acc_id;?>" >
                                    </div>
                                  </div> 
								  
								   <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>D/K</label> 
									  <?php
										$options = array(
												''         => 'PILIH',
												'D'        => 'D/Debet',
												'K'        => 'K/Kredit', 
										); 
										echo form_dropdown('dk', $options, $result->dk,'class="form-control input-sm"');
									  ?>
                                    </div>
                                  </div> 
								  
                                    <!-- /.col -->
                                <div class="col-xs-12">
                                    <br /><input type="submit" value="Save Change" class="btn btn-sm btn-info" />
                                </div>
                              </div>
                             </div>
					
					<?php
					}
					?>
						  </form>
                            

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT -->
