 
<style>
table.dataTable td {
    padding:2px;
    font-size: 9pt;    
}

</style>
 <!-- CONTENT -->
            
                      <?php echo form_open('rpt_kartupiutang/report_load',"target='_blank' id='FormE'"); ?>
					  <!-- 1 --> 
					  <div class="row"> 
					  <div class="col-md-12">  
							
							<div class="col-md-3 form-group"> 	
								<label for="contain">
								  <b>Report</b>
								</label>
								<div class="col-xs-12 input-group input-group-sm"> 
								  <select name="report_type" id="report_type" style="width: 100%;"  class="form-control" required>
									<option value=""> Pilih </option>
									<option value="kartu_piutang" selected>  Kartu Piutang</option> 
									<option value="kartu_piutangGroup" >Kartu Piutang Per-Group</option> 
								  </select> 
								</div>
							</div> 
 
							
							<div class="col-md-3 form-group">
                                <label for="contain">
                                  <b>Business Unit</b>
                                </label>
                               <div class="col-xs-12 input-group input-group-sm"> 
                                  
								   <?php echo form_dropdown('region_ids','','','id ="region_id" class="form-control" style="width: 100%;" required'); ?>
								   <input type="hidden" name="region_id" id="region_hidden"/>
                                </div>
							</div> 
							
							<div class="col-md-3 form-group">
                                <label for="contain">
                                  <b>Store</b>
                                </label>
                               <div class="col-xs-12 input-group input-group-sm">  
								   <?php echo form_dropdown('branch_id','','','id ="branch_id" class="form-control" style="width: 100%;" '); ?> 
                                </div>
							</div>  
							
							<div class="row">
							 &nbsp;
							</div>
							 
							<div class="col-md-3 form-group">
                                <label for="contain">
                                  <b>Tenant</b>
                                </label>
                               <div class="col-xs-12 input-group input-group-sm"> 
                                  
								   <?php echo form_dropdown('rekanan_id','','','id ="rekanan_id" class="form-control" style="width: 100%;" '); ?>
								   
                                </div>
							</div> 
							   
							<div class="col-md-3 form-group">
                                <label for="contain">
                                  <b>Trade Name</b>
                                </label>
                               <div class="col-xs-12 input-group input-group-sm">  
								   <?php echo form_dropdown('rekananshipping_id','','','id ="rekananshipping_id" class="form-control" style="width: 100%;" '); ?> 
                                </div>
                            </div> 
							     
							<div class="col-md-5 form-group">
                                <label for="contain">
                                   <b>ID SP</b>
                                </label>
                               <div class="col-xs-7 input-group input-group-sm">  
								   <?php echo form_dropdown('schedulepayment_id','','','id="sp_id" class="form-control" style="width: 100%;" '); ?> 
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
 
	$('.tanggal').datepicker();

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
			  url: '<?php echo site_url('rpt_kartupiutang/region_select_dialog')?>',
			  dataType: 'json',
			  type: "GET",
			  data: function (term) {
				  return {
					  term: term, 
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
		
 	$('#sp_id').select2();
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
		
		var rekananshipping_line = $("#rekanan_id").val()+''+$(this).val();
		var rekanan_id = $("#rekanan_id option:selected").val();
		
		 
		var baseUrl = '<?php echo site_url('rpt_kartupiutang/schedulepayment_select_dialog')?>';
		var spid2 = []; 
		$.ajax({
			type: "POST",
			url: baseUrl, 
			data: {
               tenant:rekananshipping_line,
            },
			dataType: 'json', 
			success: function(datas){
				var spid2 = $.map(datas, function (obj) {
					// console.log('datas');
					// console.log(datas);
					obj.id = obj.id || obj.schedulepayment_id;
					obj.text = obj.text || obj.schedulepayment_id+ ' - '+obj.rekananshipping_name; 
					return obj;
					 
				    // var newOption2 = new Option(obj.schedulepayment_id+ ' - '+obj.rekananshipping_name, obj.schedulepayment_id, true, true);
					
					// $('#sp_id').empty();
					// $('#sp_id').append(datas).trigger('change'); 
				}); 
				  
				$('#sp_id').select2({data: [{id: '-', text: '--Pilih--'}]});
				$('#sp_id').select2({
					   data: spid2
				 });
				$('#sp_id').val('-'); // Select the option with a value of '1'
				$('#sp_id').trigger('change'); // Notify any JS components that the value changed
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("error");
			}
		});
		
	});
	 
	 
});

</script>