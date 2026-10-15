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
                          <a href="<?php echo base_url('index.php/unit/unit/unitlist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="<?php echo base_url('index.php/unit/unit/unitadd'); ?>"  id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata"  data-toggle="tab" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">                        
                        <div class="tab-pane" id="editdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('unit/unit_edit');?>" method="post">
                            <?php 
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>                                   
                    <div class="row">
                        <div class="col-md-10">
                           <form id="form_input">                               
                                <div class="col-md-6">
                                    <label>ID</label>                                       
                                    <input  type="text" id="unitid" name="unit_id" class="form-control" value="<?php echo $row->unit_id;?>" readonly>
                                </div>                                                                                                 
                                <div class="col-md-6">
                                    <label>Name</label>
                                    <input type="text" id = "unit_name" name="unit_name" class="form-control" value="<?php echo $row->unit_name;?>" placeholder="Wajib Isi">
                                </div> 
                                <div class="col-md-6">
                                    <label>Size (m<sup>2</sup>) </label>
                                    <input type="text" id = "unit_sqm" name="unit_sqm" class="form-control" value="<?php echo $row->unit_sqm;?>" placeholder="Wajib Isi">
                                </div>
                                <div class="col-md-6">
                                    <label>Business Unit</label>
                                    <?php echo form_dropdown('cboregion',$region,$row->region_id,'class="form-control" id="cboregion" disabled'); ?>
									<input type="hidden" name="val_region" value="<?php echo $row->region_id;?>" id="id_region"/>
                                </div>
                                <div class="col-md-6">
                                    <label>Store</label>
                                    <?php echo form_dropdown('cbobranch',$branch,$row->branch_id,'class="form-control" id="cbobranch"'); ?>
									
                                </div>  
								  <div class="col-md-6">
                                    <label>Floor</label>
                                    <?php echo form_dropdown('cbofloor',$lantai,$row->lantai_id,'class="form-control" id="cbofloor"'); ?>
									
                                </div>  
                                
                                <div class="col-md-6">
                                    <label>Unit</label>
                                    <?php echo form_dropdown('cbounittype',$unittype,$row->unittype_id,'class="form-control" id="cbounittype"'); ?>
                                </div> 
                                
                                 <div class="col-md-6">
                                    <label>Coordinate </label>
                                    <input type="text" id = "unit_coordinate" name="unit_coordinate" class="form-control" value="<?php echo $row->unit_coordinate;?>" placeholder="Wajib Isi">
                                </div>
                                 <div class="col-md-6">
                                    <label>Coord Type </label>
                                    <input type="text" id = "unit_coordtype" name="unit_coordtype" class="form-control" value="<?php echo $row->unit_coordtype;?>" placeholder="Wajib Isi">
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
                                                 <input type="text" id= "_createby" name="_createby" class="form-control" value="<?php echo $row->_createby;?>">
                                             </div>  
                                             <div class="col-md-6">                                          
                                                 <label>Create Date</label>
                                                 <input type="text" name="_createdate" class="form-control " value="<?php echo $row->_createdate;?>">
                                              </div>                             
                                             <div class="col-md-6">
                                                 <label>Modify By</label>
                                                 <input type="text" id= "_modifyby"  name="_modifyby" class="form-control " value="<?php echo $row->_modifyby;?>">
                                             </div> 
                                             <div class="col-md-6">
                                                 <label>Modify Date</label>
                                                 <input type="text" name="_modifydate" class="form-control" value="<?php echo $row->_modifydate;?>">
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