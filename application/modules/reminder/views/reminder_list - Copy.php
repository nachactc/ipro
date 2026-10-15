 
<style>
table.dataTable td {
    padding:2px;
    font-size: 9pt;    
}

</style>
 <!-- CONTENT -->
            
			
                      <?php echo form_open('reminder/duedateprinfpdf'," target='_blank' id='FormE'"); ?>
					  <input type="hidden" id="jurnal_id" name="jurnal_id" value="">
					  <input type="hidden" id="jurnal_descr" name="jurnal_descr" value="">
								  
					  <!-- 1 --> 
					  <div class="row"> 
					  <div class="col-md-12">
					  
                              <div class="col-md-4 form-group">
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
							  

							  
							  <div class="col-md-4 form-group">
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
							
							  <div class="col-md-4 form-group">
                                <label for="contain">
                                  <b>Business Unit</b>
                                </label>
                               <div class="col-xs-7 input-group input-group-sm">  
								   <?php echo form_dropdown('region_ids',$region,$region,'id ="region_id" class="form-control" style="width: 100%;" required'); ?>
								   <input type="hidden" name="region_name" id="region_name_hidden"/>
                                </div>
                              </div> 
							  
							  
							  <div class="col-md-4 form-group">
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
							  
							   <div class="col-md-4 form-group">
                                <label for="contain">
                                  <b>Store</b>
                                </label>
                               <div class="col-xs-7 input-group input-group-sm"> 
                                  
								   <?php echo form_dropdown('branch_id','','','id ="branch_id" class="form-control" style="width: 100%;" '); ?>
								   
                                </div>
                              </div> 
							
							 
							   
							 
							    
							    <div class="col-md-4 form-group">
                                <label for="contain">
                                  <b>Tenant</b>
                                </label>
                               <div class="col-xs-7 input-group input-group-sm"> 
                                  
								   <?php echo form_dropdown('rekanan_id','','','id ="rekanan_id" class="form-control" style="width: 100%;" '); ?>
								   
                                </div>
                              </div> 
							  
							   

							  
							 <div class="col-md-4 form-group">
                                <label for="contain">
                                  <b>Trade Name</b>
                                </label>
                               <div class="col-xs-7 input-group input-group-sm"> 
                                  
								   <?php echo form_dropdown('rekananshipping_id','','','id ="rekananshipping_id" class="form-control" style="width: 100%;" '); ?>
								   
                                </div>
                              </div> 
							      
								<div class="col-md-4 form-group">
								<label for="contain">
                                  <b>SP</b>
								  <div class="col-xs-12 input-group input-group-sm"> 
								 <select name="reminder" id="reminder">
									<option value="1">SP 1</option>
									<option value="2">SP 2</option>
									<option value="3">SP 3</option>
								 </select>
								</div>	
								</div>
										

							  

							  

							 
							 <div class="row"> </div>
							   
                              <div class="col-md-4 form-group "> 
                                <br>
                                <input type="button" id="btnload" value = "LOAD" class="btn btn-sm btn-info"/>
                              </div>
							  <div class="col-md-4 form-group " align ="right"> 
                                <br>
                                <input type="submit" id="btnsubmit" value = "PRIVIEW" class="btn btn-sm btn-info"/>
                              </div>
                              </div>
							  
                              </div>

                  <div class="portlet-body">
                           <div class="table-container">
                             <div class="table-scrollable">
                                 <table class="table table-striped table-hover nowrap" id='looTable' style="border-color: #E0E0E0;">
                                 	  <thead>
                                  		<tr>
                                        <th>ID</th>
                                        <th>Descr</th>
                                        <th>B Unit</th>
                                        <th>Branch</th>
                                        <th>Tenant</th>
                                        <th>Brand</th>
                                        <th>DueDate</th>
                                        <th>IDR</th>
                                    	<th>Raf ID</th>
                                        <th>contract_no</th>										
                                        <th>region_id</th>
										<th>branch_id</th>
                                        <th>rekanan_id</th>
                                        <th>rekananshipping_line</th>
										<th>Ref</th>										
                                  		</tr>
                				            </thead>
                              		<tbody>
									<tr>
									<?php if(!empty($result)){
                                    foreach($result as $row){
                                    ?>
										<td><?php echo $row->jurnal_id;?></td>
										<td><?php echo $row->jurnal_descr;?></td>
									<?php
                                    }}?>
									</tr>
                              		</tbody>
                            	   </table>
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

	var oTable=listgrid("<?php echo site_url('reminder/reminder/controler_gridaging')?>","looTable","lfrtip",200);

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
			  url: '<?php echo site_url('reminder/region_select_dialog')?>',
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
						  $('#region_name_hidden').val(item.region_name);
						  return {

							  text: item.region_name, 
							  id: item.region_id,
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
			  url: '<?php echo site_url('reminder/branch_select_dialog')?>',
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
			  url: '<?php echo site_url('reminder/acc_select_dialog')?>',
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
			  url: '<?php echo site_url('reminder/rekanan_select_dialog')?>',
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
			  url: '<?php echo site_url('reminder/rekananshipping_select_dialog')?>',
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
	$('#rekanan_id').change(function(){
		$('#rekananshipping_id').empty();
	}); 

	
	$('#bSearch').click(function(){
		 
		// if($('#f_date').val() === '')
		// {
			// alert('Pilih Start Date');
			// return false;
		// };
		if($('#region_id').val() === '0')
		{
			alert('Pilih Business Unit');
			return false;
		};
		if($('#report_type').val() === '')
		{
			alert('Pilih Type Report');
			return false;
		};
		 
		
	});
	
      $('#btnload').click( function() {
          var searchRegion = $("#region_id").val();
          var searchBranch  = $("#branch_id").val();
          var searchTenant = $("#rekanan_id").val();
          var searchBrand  = $("#rekananshipping_id").val();
          var searchtglstart  = $("#f_date").val();
		  var searchtglend  = $("#t_date").val();
		  var searchtglpayment = $("#p_date").val();
		  var searchjurnalid ='';
		  
 
		 // alert(searchRegion);
		 // alert(searchBranch);
		 // alert(searchtglstart);
          oTable.search('');
          //oTable.search(searchRegion).draw();
          //oTable.search(searchBranch);

          //oTable.search(searchID).draw();
          oTable.column(0).search(searchRegion);
          oTable.column(1).search(searchBranch);
          oTable.column(2).search(searchTenant);
          oTable.column(3).search(searchBrand);
		  oTable.column(4).search(searchjurnalid);
          oTable.column(5).search(searchtglstart);
          oTable.column(6).search(searchtglend);
          oTable.column(7).search(searchtglpayment);
          //oTable.column(7).search(val_postdate);
          //oTable.column(8).search(val_invtype);
          //oTable.column(2).search(searchBranch);
          oTable.draw();
      });
	  
	  $('#btnsubmit').click( function() {
		var sjurnalid = '';
		var sjurnaldescr = '';
		var sfak = '';
		var sregion = '';

		var rData = oTable.rows('.selected').data();

         for (var i=0; i < rData.length ;i++){

            // var tid     = rData[i][0];
            // var tname   = rData[i][1];
            if (sjurnalid==''){
                sjurnalid = rData[i][0];
				sjurnaldescr = rData[i][1];
				sregion = rData[i][10];
            }
            else {
				sjurnalid = sjurnalid + '-' + rData[i][0];
				sjurnaldescr = sjurnaldescr + '-' + rData[i][2];
				sregion = rData[i][10];
            }
        }

		$('#jurnal_id').val(sjurnalid);	
		$('#jurnal_descr').val(sjurnaldescr);	
		$('#region_id').val(sregion);			
	  });
	  
	  
});

</script>