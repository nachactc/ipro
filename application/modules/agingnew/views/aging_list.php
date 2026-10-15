 
<style>
table.dataTable td {
    padding:2px;
    font-size: 9pt;    
}

</style>
 <!-- CONTENT -->
            
            <?php //echo form_open('',"' id='FormE'"); ?>
					  <!-- 1 --> 
					  <div class="row"> 
					  <div class="col-md-12">
					  
                              <div class="col-md-3 form-group">
                                <label for="contain">
                                  <b>Start Date</b>
                                </label>
                                <div class="input-group input-group-sm">
                                  <input class="form-control tanggal" type="text" id="f_date" name="startdate" autocomplete="off" />
                                  <span class="input-group-btn">
                                    <button id ="btcleart_1" type="button" class="btn btn-primary"><i class="fa fa-eraser"></i></button>
                                  </span>
                                </div>
                              </div>
							  
							    								<div class="col-md-5 form-group">
								<input type="checkbox" name="ppn_exclude" class="form-check-input" id="ppn_exclude" value="1" checked />
								 <label>Exclude Ppn</label>
								 <br/>
								<label for="contain">
								  <b>Report</b>
								</label>
								<div class="col-xs-7 input-group input-group-sm"> 
								  <select name="report_type" id="report_type" style="width: 100%;"  class="form-control" required>
									<option value=""> Pilih </option>
									<option value="aging"> Aging </option>
									<option value="agingdetail"> Aging Detail </option>
									<option value="agingbyname"> Aging By Name </option>
									<option value="agingv2"> Aging A/R All</option>
									<option value="agingv3"> Aging Raw Data</option>
									<option value="agingnopro"> Aging No Proforma </option>
									<option value="agingnoprodetil"> Aging No Proforma Detil </option>
								  </select> 
								</div>
							  </div> 

							 
							 <div class="row">
							 &nbsp;
							 </div>
							  
							  <div class="col-md-3 form-group">
                                <label for="contain">
                                  <b>End Date</b>
                                </label>
                                <div class="input-group input-group-sm">
                                  <input class="form-control tanggal" type="text" id="t_date" name="enddate" autocomplete="off" />
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
                                  <b>Payment Date</b>
                                </label>
                                <div class="input-group input-group-sm">
                                  <input class="form-control tanggal" type="text" id="p_date" name="payment_date" autocomplete="off"/>
                                  <span class="input-group-btn">
                                    <button id ="btcleart_3" type="button" class="btn btn-primary"><i class="fa fa-eraser"></i></button>
                                  </span>
                                </div>
                              </div> 
							  
							   <div class="col-md-5 form-group">
                                <label for="contain">
                                  <b>Store</b>
                                </label>
                               <div class="col-xs-7 input-group input-group-sm"> 
                                  
								   <?php echo form_dropdown('branch_id','','','id ="branch_id" class="form-control" style="width: 100%;" '); ?>
								   
                                </div>
                              </div> 
							
							 
							 <div class="row">
							 &nbsp;
							 </div>
							   
							 
							   <div class="col-md-3 form-group">
                                <label for="contain">
                                  <b>T_TYPE</b>
                                </label>
                               <div class="col-xs-12 input-group input-group-sm"> 
                                  
								   <?php echo form_dropdown('agrType',$agrType,'','id ="agrType" class="form-control" style="width: 100%;" '); ?>
								   
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
                                  <b>UnAlloc</b>
                                </label>
                               <div class="col-xs-12 input-group input-group-sm"> 
                                  
								 <select name="unalloc_select" id="unalloc_select">
									<option value="">pilih</option>
									<option value="unalloc">UnAllocated</option>
									<option value="unknown">Uknown Payment</option>
								 </select>
								   
                                </div>
                              </div> 
							  
							 <div class="col-md-5 form-group">
                                <label for="contain">
                                  <b>Trade Name</b>
                                </label>
                               <div class="col-xs-7 input-group input-group-sm"> 
                                  
								   <?php echo form_dropdown('rekananshipping_id','','','id ="rekananshipping_id" class="form-control" style="width: 100%;" '); ?>
								   
                                </div>
                              </div> 
							     
							 <div class="row">
							 &nbsp;
							 </div> 
							  
							  <div class="col-md-3 form-group">
                                <label for="contain">
                                  <b>WHT</b>
                                </label>
                               <div class="col-xs-12 input-group input-group-sm"> 
                                 
								 <select name="wht" id="wht">
									<option value="">pilih</option>
									<option value="deductbylandlord">Deduct By LandLord</option>
									<option value="deductbytenant">Deduct By Tenant</option>
								 </select>
								   
                                </div>
                              </div> 
							   
							  
							   <div class="col-md-5 form-group">
                                <label for="contain">
                                     <b>Property Grade</b>
                                </label>
                               <div class="col-xs-7 input-group input-group-sm"> 
                                  
								   <?php echo form_dropdown('property_grade',$GradeProperty,'','id ="property_grade" class="form-control" style="width: 100%;" '); ?>
								  
                                </div>
                              </div> 
							  
							<div class="row">
							 &nbsp;
							 </div> 
							  
							  
							   <div class="col-md-3 form-group">
                                <label for="contain">
                                   <b>Tenant Group</b>
                                </label>
                                <div class="col-xs-12 input-group input-group-sm"> 
                                  
								   <?php echo form_dropdown('grouptenant',$GroupTenantType,'','id ="grouptenant" class="form-control" style="width: 100%;" '); ?>
								   
                                </div>
                              </div> 
							  
							   <div class="col-md-5 form-group">
                                <label for="contain">
                                   <b>Acc ID</b>
                                </label>
                               <div class="col-xs-7 input-group input-group-sm"> 
                                  
								   <?php echo form_dropdown('acc_id','','','id="acc_ids" class="form-control" style="width: 100%;" '); ?>
								   
                                </div>
                              </div> 

               <div class="row">
							 &nbsp;
							 </div> 
							
							 		<div class="col-md-12 form-group">
		 									<label for="contain">
                         <b>Advance Search</b>
                      </label>
                      <div class="col-xs-6 input-group input-group-sm">
											<textarea id = "idescr" name="idescr" class="form-control input-sm"></textarea>								   
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
							  
                      <?php //echo form_close(); ?>      
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

	
	$('#bSearch').on('click', async function(){		

		if($('#region_id').val() === '0'){
			alert('Pilih Business Unit');
			return false;
		};

		if($('#report_type').val() === ''){
			alert('Pilih Type Report');
			return false;
		};

		let startdate = $('#f_date').val();
		let enddate = $('#t_date').val();
		let payment_date = $('#p_date').val();
		let region_id = $('#region_id').val();
		let branch_id = $('#branch_id').val();
		let rekanan_id = $('#rekanan_id').val();
		let rekananshipping_id = $('#rekananshipping_id').val();
		let ppn_exclude = $('#ppn_exclude').val();
    let param ={};

    param['startdate'] = startdate;
    param['enddate'] = enddate;
    param['payment_date'] = payment_date;
    param['region_id'] = region_id;
    param['branch_id'] = branch_id;
    param['rekanan_id'] = rekanan_id;
    param['rekananshipping_id'] = rekananshipping_id;
    param['ppn_exclude'] = ppn_exclude;
			
    $.blockUI({message: 'Generating Report, Please Wait...'});

		try {

			let result = await ajaxRequest('<?php echo site_url("agingnew/report_init");?>', param);

			if (!result.status){
				alert(result.message);
			} else {

				$.unblockUI();

				
				$.blockUI({message: 'Exporting to File...'});

				//let result = await ajaxRequest('<?php //echo site_url("ivp/export_result");?>', param);
				let result = await ajaxRequest('<?php echo site_url("agingnew/report_result");?>', param);

				//let fileName = `Invoice_vs_Payment-on-`+enddate+`.xlsx`;
				let fileName = `AgingAR_All-on-`+enddate+`.csv`;
				const mimeType = 'application/vnd.ms-excel';
				let bytesBase64 = result.file;

				let fileUrl = "data:" + mimeType + ";base64," + bytesBase64;

				let $a = $("<a>");
				$a.attr("href", fileUrl);
				$a.attr("download", fileName);          
				$("body").append($a);
				$a[0].click();
				$a.remove();
				

			}

			$.unblockUI();

		} catch (error) {			
      console.error(error);
		}
		
	});

	async function ajaxRequest(url, param) {
      let result;

      try {
           result = await $.ajax({
               url: url,
               type: 'POST',
               data: param,
               dataType: 'json'
           });
           return result;

      } catch (error) {
        console.error(error);
      }
  }
	

});

</script>