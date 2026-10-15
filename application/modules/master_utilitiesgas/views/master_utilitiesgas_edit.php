<script> 

  $(document).ready(function(){

  	$("#tabedit").trigger('click');
  	 
  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  	});
	
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
                          <a href="<?php echo base_url('index.php/master_utilitiesgas/master_utilitiesgas/master_utilitiesgaslist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="<?php echo base_url('index.php/master_utilitiesgas/master_utilitiesgas/master_utilitiesgasadd'); ?>"  id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata"  data-toggle="tab" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">                        
                        <div class="tab-pane" id="editdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('master_utilitiesgas/master_utilitiesgas_edit');?>" method="post">
                            <?php 
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>                                   
                    <div class="row">
                        <div class="col-md-10">
                           <form id="form_input">                               
                                <div class="col-md-4">
                                    <label>ID</label>                                       
                                    <input  type="text" id="utilitiesgas_id" name="utilitiesgas_id" class="form-control" value="<?php echo $row->utilitiesgas_id;?>" readonly>
                                </div>                                                                                                 
                                <div class="col-md-4">
                                    <label>Name</label>
                                    <input type="text" id = "utilitiesgas_name" name="utilitiesgas_name" class="form-control" value="<?php echo $row->utilitiesgas_name;?>" placeholder="Wajib Isi">
                                </div> 
                                <div class="col-md-4">
                                    <label>Diameter Pipa</label>
                                    <input type="text" id = "utilitiesgas_diameterpipa" name="utilitiesgas_diameterpipa" class="form-control" value="<?php echo $row->utilitiesgas_diameterpipa;?>">
                                </div>
								<div class="col-md-4">
                                    <label>ADM Rp.</label>
                                    <input type="text" id = "utilitiesgas_adm" name="utilitiesgas_adm" class="form-control" value="<?php echo $row->utilitiesgas_adm;?>">
                                </div>
								<div class="col-md-4">
                                    <label>ADM %</label>
                                    <input type="text" id = "utilitiesgas_kva" name="utilitiesgas_admpercent" class="form-control" value="<?php echo $row->utilitiesgas_admpercent;?>">
                                </div>
								<div class="col-md-4">
                                    <label>PH Air Kotor</label>
                                    <input type="text" id = "utilitiesgas_phairkotor" name="utilitiesgas_phairkotor" class="form-control" value="<?php echo $row->utilitiesgas_phairkotor;?>">
                                </div>
								<div class="col-md-4">
                                    <label>PH Meter</label>
                                    <input type="text" id = "utilitiesgas_phmeter" name="utilitiesgas_phmeter" class="form-control" value="<?php echo $row->utilitiesgas_phmeter;?>" >
                                </div>
								<div class="col-md-4">
                                    <label>Tarif</label>
                                    <input type="text" id = "utilitiesgas_tarif" name="utilitiesgas_tarif" class="form-control" value="<?php echo $row->utilitiesgas_tarif;?>" >
                                </div>
								<div class="col-md-4">
                                    <label>Faktor</label>
                                    <input type="text" id = "utilitiesgas_mfaktor" name="utilitiesgas_mfaktor" class="form-control" value="<?php echo $row->utilitiesgas_mfaktor;?>" >
                                </div>
								<div class="col-md-4">
                                    <label>Pressure</label>
                                    <input type="text" id = "utilitiesgas_pressure" name="utilitiesgas_pressure" class="form-control" value="<?php echo $row->utilitiesgas_pressure;?>" >
                                </div>
								
								<div class="col-md-4">                                   									
									<label class="checkbox-inline"><input id= "utilitiesgas_isadditional" name = "utilitiesgas_isadditional" class= "appr checkbox" type="checkbox" <?php if ($row->utilitiesgas_isadditional == 1 ) echo 'checked= "checked"';?> value="1">Additional</label>
									</div>								
								<div class="col-md-4">                                   
									<label class="checkbox-inline"><input id= "utilitiesgas_isusedawalakhir" name = "utilitiesgas_isusedawalakhir" class= "appr checkbox" type="checkbox" <?php if ($row->utilitiesgas_isusedawalakhir == 1 ) echo 'checked= "checked"';?> value="1">Use Awal Akhir</label>									
								</div>									
								<div class="col-md-4"> 
									<label class="checkbox-inline"><input id= "utilitiesgas_isdisabled" name = "utilitiesgas_isdisabled" class= "appr checkbox" type="checkbox" <?php if ($row->utilitiesgas_isdisabled == 1 ) echo 'checked= "checked"';?> value="1">Disabled</label>																	
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
                                                 <input type="text" id= "utilitiesgas_createby" name="utilitiesgas_createby" class="form-control" value="<?php echo $row->utilitiesgas_createby;?>" readonly>
                                             </div>  
                                             <div class="col-md-6">                                          
                                                 <label>Create Date</label>
                                                 <input type="text" id = "utilitiesgas_createdate" name="utilitiesgas_createdate" class="form-control " value="<?php echo $row->utilitiesgas_createdate;?>" readonly>
                                              </div>                             
                                             <div class="col-md-6">
                                                 <label>Modify By</label>
                                                 <input type="text" id= "utilitiesgas_modifyby"  name="utilitiesgas_modifyby" class="form-control " value="<?php echo $row->utilitiesgas_modifyby;?>" readonly>
                                             </div> 
                                             <div class="col-md-6">
                                                 <label>Modify Date</label>
                                                 <input type="text" id ="utilitiesgas_modifydate" name="utilitiesgas_modifydate" class="form-control" value="<?php echo $row->utilitiesgas_modifydate;?>" readonly>
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