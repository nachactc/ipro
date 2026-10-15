 
<style>
table.dataTable td {
    padding:2px;
    font-size: 9pt;    
}

</style>
            <!-- CONTENT -->            
            <?php echo form_open('tdr/report_load',"target='_blank' id='FormE'"); ?>
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
                <div class="row">
							  &nbsp;
							  </div>
                <div class="col-md-4 form-group">
                  <label for="contain">
                    <b>Group Account</b>
                  </label>
                  <div class="col-xs-12 input-group input-group-sm">                          
                    <select name="groupacc_select" id="groupacc_select" required>
                      <option value=""></option>
                      <option value="DEFERRED">Deferred Income Account</option>
                      <option value="DEPOSIT">Deposit Account</option>
                    </select>								   
                  </div>
                </div> 					
							  <div class="col-md-4 form-group">
                  <label for="contain">
                    <b>Business Unit</b>
                  </label>
                  <div class="col-xs-12 input-group input-group-sm">                     
                  <?php echo form_dropdown('region_ids',$region,'0','id ="region_id" class="form-control" style="width: 100%;"'); ?>
                  <input type="hidden" name="region_id" id="region_hidden"/>
                  </div>
                </div> 							  												  							 
							  <div class="row">
							  &nbsp;
							  </div>
							  <div class="row">
							  &nbsp;
							  </div>	 							   
                <div class="col-md-4 form-group "> 
                  <br>
                  <button type="search" class="btn blue" id="bSearch"  >
                    GENERATE 
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

  $('#region_id').select2({	
      placeholder: 'All Business Unit', 
			tags: true,
			allowClear: true,
      width: '100%' 
  });
  
  $('#groupacc_select').select2({	
      placeholder: 'Select an Option', 
			tags: true,
			allowClear: true,
      width: '100%' 
  });

	// $('#rekanan_id').change(function(){
		// $('#rekananshipping_id').empty();
	// }); 	
});

</script>