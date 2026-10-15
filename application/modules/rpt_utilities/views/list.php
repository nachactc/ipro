 
<style>
table.dataTable td {
    padding:2px;
    font-size: 9pt;    
}

</style>
 <!-- CONTENT -->
            
                      <?php echo form_open('rpt_utilities/report_load',"target='_blank' id='FormE'"); ?>
					  <!-- 1 --> 
					  <div class="row"> 
					  	<div class="col-md-12"> 
							  <div class="col-md-3 form-group"> 	
									<label for="contain">
										<b>Periode</b>
									</label>																	
									<div class="input-group input-group-sm">
										<input class="form-control tanggal" type="text" id="f_date" name="startdate" autocomplete="off" value="<?=date("d/m/Y");?>"/>
										<span class="input-group-btn">
											<button id ="btcleart_1" type="button" class="btn btn-primary"><i class="fa fa-eraser"></i></button>
										</span>
									</div>
								</div> 
							  
							 <div class="col-md-5 form-group"> 	
								<label for="contain">
								  <b>Report</b>
								</label>
								<div class="col-xs-7 input-group input-group-sm"> 
								  <select name="report_type" id="report_type" style="width: 100%;"  class="form-control" required>
									<option value="" selected> Pilih </option>
									<option value="u_listrik" > Utilities Listrik</option> 
									<option value="u_air" > Utilities Air</option> 
									<option value="u_gas" > Utilities Gas</option> 
								  </select> 
								</div>
							  </div> 

							 
							 <div class="row">
							 &nbsp;
							 </div>
							  
							  <div class="col-md-3 form-group"> 	
									<label for="contain">
										<b>S/d</b>
									</label>
									<div class="input-group input-group-sm">
										<input class="form-control tanggal" type="text" id="t_date" name="enddate" autocomplete="off" value="<?=date("d/m/Y");?>"/>
										<span class="input-group-btn">
											<button id ="btcleart_2" type="button" class="btn btn-primary"><i class="fa fa-eraser"></i></button>
										</span>
									</div>
							  </div> 
							
							  <div class="col-md-5 form-group">
                                <label for="contain">
                                  <b>Business Unit</b>
                                </label>
                               <div class="col-xs-7 input-group input-group-sm"> 
                                  
								   <?php echo form_dropdown('region_ids','','','id ="region_id" class="form-control" style="width: 100%;" required'); ?>
								   <input type="hidden" name="region_id" id="region_hidden"/>
                                </div>
                              </div> 
							  
							 <div class="row">
							 &nbsp;
							 </div> 
							   <div class="col-md-3 form-group">
                                <label for="contain">
                                  <b>Store</b>
                                </label>
                               <div class="col-xs-12 input-group input-group-sm"> 
                                  
								   <?php echo form_dropdown('branch_id','','','id ="branch_id" class="form-control" style="width: 100%;" '); ?>
								   
                                </div>
                              </div> 
							
							 
							    <div class="col-md-5 form-group">
                                <label for="contain">
                                  <b>Tenant</b>
                                </label>
                               <div class="col-xs-7 input-group input-group-sm"> 
                                  
								   <?php echo form_dropdown('rekanan_id','','','id ="rekanan_id" class="form-control" style="width: 100%;" '); ?>
								   
                                </div>
                              </div> 
							  
							 <div class="row">
							 &nbsp;
							 </div> 
							        
							 <div class="col-md-3 form-group">
                                <label for="contain">
                                  <b>Trade Name</b>
                                </label>
                               <div class="col-xs-12 input-group input-group-sm">  
								   <?php echo form_dropdown('rekananshipping_id','','','id ="rekananshipping_id" class="form-control" style="width: 100%;" '); ?> 
                                </div>
                              </div> 
							     
							    <div class="row">
							 &nbsp;
							 </div> 
							     
							   <div class="col-md-7 form-group">
                                <label for="contain">
                                   <b>Advance</b>
                                </label>
                               <div class="col-xs-14 input-group input-group-sm">  
								   <input type="text" name="advance" size="200"  class="form-control" style="width: 86%;height:50px; "  /> 
                                </div>
                              </div> 
							  
							
							 <div class="row">
							 &nbsp;
							 </div> 
							 
							 <div class="row"> </div>
							   
                              <div class="col-md-4 form-group "> 
                                <br>
                                <button type="search" class="btn blue" id="bSearch"  >
                                  Load 
                                </button>
                              </div>
                              </div>
							  
                              </div>
							  
                      <?php echo form_close(); ?>      
					  <!-- 1 -->
				 
              <!-- END OF CONTENT -->
			  
<script> 
$.fn.datepicker.defaults.format = "yyyy-mm-dd";
$.fn.datepicker.defaults.autoclose = true;

$(document).ready(function(){ 
 
	$('.tanggal').datepicker({
		format: 'dd/mm/yyyy'
	});

	$('#btcleart_1').click(function() {    

	$('#f_date').val('');     

	});

	$('#btcleart_2').click(function() {    

	$('#t_date').val('');     

	});
	$('#btcleart_3').click(function() {    

	$('#p_date').val('');     

	});

	$('#report_type').select2({
				placeholder: 'Pilih Tipe Report', 
				tags: true,
				allowClear: true,
				width: '100%' 			
			});  
	$('#region_id').select2({
		  placeholder: 'Select an option',
		  minimumInputLength: 2,
		  allowClear: true,
		  //tags: true,
		  minimumResultsForSearch: 10,
		  tokenSeparators: [',', ' '],
		  ajax: {
			  url: '<?php echo site_url('aging/region_select_dialog')?>',
			  dataType: 'json',
			  type: "GET",
			  data: function (term) {
				  return {
					  term: term,
					  region: ''
				  };
			  },
			  processResults: function (data) {
				  return {
					  results: $.map(data.items, function (item) {
 
						  return {

							  text: item.region_name, 
							  id: item.region_id
						  }
					  })
				  };
			  }
		  }
	  });	
	$('#bln').select2({
				placeholder: 'Pilih', 
				tags: true,
				allowClear: true,
				width: '100%' 			
			}); 
	$('#thn').select2({
				placeholder: 'Pilih', 
				tags: true,
				allowClear: true,
				width: '100%' 			
			});   
	$('#agrType').select2({
				placeholder: 'Pilih', 
				tags: true,
				allowClear: true,
				width: '100%' 			
			});   
	$('#property_grade').select2({
				placeholder: 'Pilih', 
				tags: true,
				allowClear: true,
				width: '100%' 			
			});   
	$('#grouptenant').select2({
				placeholder: 'Pilih', 
				tags: true,
				allowClear: true,
				width: '100%' 			
			});   
	$('#unalloc_select').select2({
				placeholder: 'Pilih', 
				tags: true,
				allowClear: true,
				width: '100%' 			
			});   
	$('#wht').select2({
				placeholder: 'Pilih', 
				tags: true,
				allowClear: true,
				width: '100%' 			
			});   
	$('#branch_id').select2({
		  placeholder: 'Select an option',
		  minimumInputLength: 2,
		  allowClear: true,
		  //tags: true,
		  minimumResultsForSearch: 10,
		  tokenSeparators: [',', ' '],
		  ajax: {
			  url: '<?php echo site_url('aging/branch_select_dialog')?>',
			  dataType: 'json',
			  type: "GET",
			  data: function (term) {
				  return {
					  term: term,
					  region: ''
				  };
			  },
			  processResults: function (data) {
				  return {
					  results: $.map(data.items, function (item) {

							//console.log(data.items);
						  return {

							  text: item.branch_name,
							  region: item.region_id,
							  region_name: item.region_name,
							  id: item.branch_id
						  }
					  })
				  };
			  }
		  }
	  });	
	$('#branch_id').on("select2:select", function(e) {
			var valuenya = e.params.data; 
			var data = {
				text: valuenya.region_name,
				id: valuenya.region
			}; 
			 
			console.log(data);
			var newOption = new Option(data.text, data.id, true, true);
			$('#region_id').select2({data: [{id: '', text: ''}]});
			$('#region_id').empty();
			$('#region_id').append(newOption).trigger('change');
			$('#region_hidden').val(data.id); 
		});  
 	$('#acc_ids').select2({
		  placeholder: 'Select an option',
		  minimumInputLength: 2,
		  allowClear: true,
		  //tags: true,
		  minimumResultsForSearch: 10,
		  tokenSeparators: [',', ' '],
		  ajax: {
			  url: '<?php echo site_url('aging/acc_select_dialog')?>',
			  dataType: 'json',
			  type: "GET",
			  data: function (term) {
				  return {
					  term: term,
					  region: ''
				  };
			  },
			  processResults: function (data) {
				  return {
					  results: $.map(data.items, function (item) {

							//console.log(data.items);
						  return {

							  text: item.acc_id+' | '+item.acc_name, 
							  id: item.acc_id
						  }
					  })
				  };
			  }
		  }
	  });
 	$('#rekanan_id').select2({
		  placeholder: 'Select an option',
		  minimumInputLength: 2,
		  allowClear: true,
		  //tags: true,
		  minimumResultsForSearch: 10,
		  tokenSeparators: [',', ' '],
		  ajax: {
			  url: '<?php echo site_url('aging/rekanan_select_dialog')?>',
			  dataType: 'json',
			  type: "GET",
			  data: function (term) {
				  return {
					  term: term,
					  region: ''
				  };
			  },
			  processResults: function (data) {
				  return {
					  results: $.map(data.items, function (item) {

							//console.log(data.items);
						  return {

							  text: item.rekanan_name, 
							  id: item.rekanan_id
						  }
					  })
				  };
			  }
		  }
	  });
	$('#rekananshipping_id').select2({
		  placeholder: 'Select an option',
		  minimumInputLength: 2,
		  allowClear: true,
		  //tags: true,
		  minimumResultsForSearch: 10,
		  tokenSeparators: [',', ' '],
		  ajax: {
			  url: '<?php echo site_url('aging/rekananshipping_select_dialog')?>',
			  dataType: 'json',
			  type: "GET",
			  data: function (term) {
				  return {
					  term: term,
					  region: ''
				  };
			  },
			  processResults: function (data) {
				  return {
					  results: $.map(data.items, function (item) {

							//console.log(data.items);
						  return {

							  text: item.rekananshipping_name, 
							  id: item.rekananshipping_line,
							  rekanan: item.rekanan_id,
							  rekanan_name: item.rekanan_name,
						  }
					  })
				  };
			  }
		  }
	  });	
	$('#rekananshipping_id').on("select2:select", function(e) {
		var valuenya = e.params.data; 
		var data = {
			text: valuenya.rekanan_name,
			id: valuenya.rekanan
		}; 
		 
		console.log(data);
		var newOption = new Option(data.text, data.id, true, true);
		$('#rekanan_id').select2({data: [{id: '', text: ''}]});
		$('#rekanan_id').empty();
		$('#rekanan_id').append(newOption).trigger('change');
		 
	});
	// $('#rekanan_id').change(function(){
		// $('#rekananshipping_id').empty();
	// }); 

	
	$('#bSearch').click(function(){
		 
		// if($('#f_date').val() === '')
		// {
			// alert('Pilih Start Date');
			// return false;
		// };		
		if($('#report_type').val() === '')
		{
			alert('Pilih Type Report');
			return false;
		};
		
	});
	

});

</script>