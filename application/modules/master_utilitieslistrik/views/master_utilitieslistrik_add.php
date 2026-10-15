<script> 

  $(document).ready(function(){

  	$("#tabdata").trigger('click');
  	 
  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  	});
	 $('#cboregion').select2({placeholder: 'Select a business unit'});
	 $('#cbobranch').select2({placeholder: 'Select a Store'});
	 $('#cbofloor').select2({placeholder: 'Select a Floor'});
	 $('#cbounittype').select2({placeholder: 'Select Unit Type'});
 
   $('#cbobranch').select2({
   allowClear: true,
   dropdownCssClass: 'custom-dropdown-1' ,
   placeholder: 'Select an option',
      minimumInputLength: 2,
      //tags: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('loo_cl/loo_cl/branch_select_dialog')?>',
          dataType: 'json',
          type: "GET",
          data: function (term, region) { 
              return {
                  term: term,
                  region: ''
              };
          },
          processResults: function (data) {
              return {
                  results: $.map(data.items, function (item) { 
                      return { 
                          text: item.branch_name, 
                          id: item.branch_id,
						  region:item.region_id, 
						  region_name:item.region_name,
											  
                      }
					 
                  })
              };
			 
			 
          }
      }  
    });
	$('#cbobranch').on("select2:select", function(e) {
		var valuenya = e.params.data;
		
		region_id_s =e.params.data.id;	
		
		var data = {
			text: valuenya.region_name,
			id: valuenya.region
		}; 
		
		console.log(e.params.data.id);
		var newOption = new Option(data.text, data.id, true, true);
		$('#cboregion').select2({data: [{id: '', text: ''}]});		
		$('#cboregion').append(newOption).trigger('change');
		$('#id_region').val(e.params.data.region); 
	});
	$('#cbobranch').on('select2:open', function(e){
		$('.custom-dropdown-1').parent().css('z-index', 99999);
	});
  });

</script>

<style>
table.dataTable td {
    padding:2px;
}
</style>
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
                        <a href="javascript:;" class="btn green">
                        <i class="fa fa-file-o"></i> Posting </a>
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
                          <a href="<?php echo base_url('index.php/master_utilitieslistrik/master_utilitieslistrik/master_utilitieslistriklist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="#newdata" data-toggle="tab" id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata"  data-toggle="tab" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">                        
                        <div class="tab-pane" id="newdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('master_utilitieslistrik/savemaster_utilitieslistrik');?>" method="post">
					<?php 
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?> 
		                                  
                    <div class="row"> 
                        <div class="col-md-10">
                           <form id="form_input">                               
                                <div class="col-md-4">
                                    <label>ID</label>                                       
                                    <input  type="text" id="utilitieslistrik_id" name="utilitieslistrik_id" class="form-control" value="<?php echo $row->utilitieslistrik_id;?>" readonly>
                                </div>                                                                                                 
                                <div class="col-md-4">
                                    <label>Name</label>
                                    <input type="text" id = "utilitieslistrik_name" name="utilitieslistrik_name" class="form-control" value="<?php echo $row->utilitieslistrik_name;?>" placeholder="Wajib Isi">
                                </div> 
                                <div class="col-md-4">
                                    <label>AMP</label>
                                    <input type="text" id = "utilitieslistrik_amp" name="utilitieslistrik_amp" class="form-control" value="<?php echo $row->utilitieslistrik_amp;?>">
                                </div>
								<div class="col-md-4">
                                    <label>Phase</label>
                                    <input type="text" id = "utilitieslistrik_phase" name="utilitieslistrik_phase" class="form-control" value="<?php echo $row->utilitieslistrik_phase;?>">
                                </div>
								<div class="col-md-4">
                                    <label>KVA</label>
                                    <input type="text" id = "utilitieslistrik_kva" name="utilitieslistrik_kva" class="form-control" value="<?php echo $row->utilitieslistrik_kva;?>">
                                </div>
								<div class="col-md-4">
                                    <label>Faktor</label>
                                    <input type="text" id = "utilitieslistrik_faktor" name="utilitieslistrik_faktor" class="form-control" value="<?php echo $row->utilitieslistrik_faktor;?>">
                                </div>
								<div class="col-md-4">
                                    <label>ADM %</label>
                                    <input type="text" id = "utilitieslistrik_admpercent" name="utilitieslistrik_admpercent" class="form-control" value="<?php echo $row->utilitieslistrik_admpercent;?>" >
                                </div>
								<div class="col-md-4">
                                    <label>ADM Rp</label>
                                    <input type="text" id = "utilitieslistrik_admamount" name="utilitieslistrik_admamount" class="form-control" value="<?php echo $row->utilitieslistrik_admamount;?>" >
                                </div>
								<div class="col-md-4">
                                    <label>BPJU</label>
                                    <input type="text" id = "utilitieslistrik_bpju" name="utilitieslistrik_bpju" class="form-control" value="<?php echo $row->utilitieslistrik_bpju;?>">
                                </div>
                                
								<div class="col-md-4">
                                    <label>Master KVA</label>
                                    <?php echo form_dropdown('cbokva',$kva,$row->utilitieskva_id,'class="form-control" id="cbokva" name="cbokva"'); ?>
									
                                </div>
								<div class="col-md-4">                                   									
									<label class="checkbox-inline"><input id= "utilitieslistrik_issingglemeter" name = "utilitieslistrik_issingglemeter" class= "appr checkbox" type="checkbox" <?php if ($row->utilitieslistrik_issingglemeter == 1 ) echo 'checked= "checked"';?> value="1">Single Meter</label>
									</div>
								<div class="col-md-4">                                   									
									<label class="checkbox-inline"><input id= "utilitieslistrik_isgenset" name = "utilitieslistrik_isgenset" class= "appr checkbox" type="checkbox" <?php if ($row->utilitieslistrik_isgenset == 1 ) echo 'checked= "checked"';?> value="1">Genset</label>
									</div> 
								<div class="col-md-4">                                   
									<label class="checkbox-inline"><input id= "utilitieslistrik_isblocked" name = "utilitieslistrik_isblocked" class= "appr checkbox" type="checkbox" <?php if ($row->utilitieslistrik_isblocked == 1 ) echo 'checked= "checked"';?> value="1">Blocked</label>									
								</div>									
								<div class="col-md-4"> 
								<label class="checkbox-inline"><input id= "utilitieslistrik_isadditional" name = "utilitieslistrik_isadditional" class= "appr checkbox" type="checkbox" <?php if ($row->utilitieslistrik_isadditional == 1 ) echo 'checked= "checked"';?> value="1">Additional</label>																	
                                </div>
								<div class="col-md-4">                                   
									<label class="checkbox-inline"><input id= "tariflwbp_calcbyuser" name = "tariflwbp_calcbyuser" class= "appr checkbox" type="checkbox" <?php if ($row->tariflwbp_calcbyuser == 1 ) echo 'checked= "checked"';?> value="1">LWBP Calc By User</label>																										
								</div>
								<div class="col-md-4"> 
									<label class="checkbox-inline"><input id= "tarifwbp_calcbyuser" name = "tarifwbp_calcbyuser" class= "appr checkbox" type="checkbox" <?php if ($row->tarifwbp_calcbyuser == 1 ) echo 'checked= "checked"';?> value="1">WBP Calc By User</label>
                                </div>
								<div class="col-md-4">                                   
									<label class="checkbox-inline"><input id= "selisih_calcbyuser" name = "selisih_calcbyuser" class= "appr checkbox" type="checkbox" <?php if ($row->selisih_calcbyuser == 1 ) echo 'checked= "checked"';?> value="1">Selisih Calc By User</label>
								</div>
								<div class="col-md-4"> 
								<label class="checkbox-inline"><input id= "selisihlwbp_calcbyuser" name = "selisihlwbp_calcbyuser" class= "appr checkbox" type="checkbox" <?php if ($row->selisihlwbp_calcbyuser == 1 ) echo 'checked= "checked"';?> value="1">Selisih LWBP Calc By User</label>									
                                </div>
								<div class="col-md-4">
									<label class="checkbox-inline"><input id= "selisihwbp_calcbyuser" name = "selisihwbp_calcbyuser" class= "appr checkbox" type="checkbox" <?php if ($row->selisihwbp_calcbyuser == 1 ) echo 'checked= "checked"';?> value="1">Selisih WBP Calc By User</label>									
								</div>
								<div class="col-md-4"> 
									<label class="checkbox-inline"><input id= "pemakaianwbp_calcbyuser" name = "pemakaianwbp_calcbyuser" class= "appr checkbox" type="checkbox" <?php if ($row->pemakaianwbp_calcbyuser == 1 ) echo 'checked= "checked"';?> value="1">Pemakaian WBP Calc By User</label>
									
                                </div>
								<div class="col-md-4">                                   
									<label class="checkbox-inline"><input id= "pemakaianlwbp_calcbyuser" name = "pemakaianlwbp_calcbyuser" class= "appr checkbox" type="checkbox" <?php if ($row->pemakaianlwbp_calcbyuser == 1 ) echo 'checked= "checked"';?> value="1">Pemakaian LWBP Calc By User</label>									
								</div>								
								<div class="col-md-4"> 
									<label class="checkbox-inline"><input id= "utilitieslistrik_isdisabled" name = "utilitieslistrik_isdisabled" class= "appr checkbox" type="checkbox" <?php if ($row->utilitieslistrik_isdisabled == 1 ) echo 'checked= "checked"';?> value="1">Disabled</label>
                                </div>  
                                <div class="col-md-12">                                   
                                   <br>
                                   <br>
                                      <!-- Custom Tabs -->
                                      <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                          <li class="active"><a href="#tab_1" data-toggle="tab" role= "tab">Record</a></li>
                                        </ul>
                                        <div class="tab-content">                                          
                                           <div class="tab-pane active" id="tab_1">
                                            <div class="row">
                                             <div class="col-md-6">
                                                 <label>Create By</label>
                                                 <input type="text" id= "utilitieslistrik_createby" name="utilitieslistrik_createby" class="form-control" value="<?php echo $row->utilitieslistrik_createby;?>" readonly>
                                             </div>  
                                             <div class="col-md-6">                                          
                                                 <label>Create Date</label>
                                                 <input type="text" id = "utilitieslistrik_createdate" name="utilitieslistrik_createdate" class="form-control " value="<?php echo $row->utilitieslistrik_createdate;?>" readonly>
                                              </div>                             
                                             <div class="col-md-6">
                                                 <label>Modify By</label>
                                                 <input type="text" id= "utilitieslistrik_modifyby"  name="utilitieslistrik_modifyby" class="form-control " value="<?php echo $row->utilitieslistrik_modifyby;?>" readonly>
                                             </div> 
                                             <div class="col-md-6">
                                                 <label>Modify Date</label>
                                                 <input type="text" id ="utilitieslistrik_modifydate" name="utilitieslistrik_modifydate" class="form-control" value="<?php echo $row->utilitieslistrik_modifydate;?>" readonly>
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