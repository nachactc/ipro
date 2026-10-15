<script>
$(document).ready(function() { 
// 

$('#regionDlg_select').select2({
		 placeholder: 'Pilih Data', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
	});  
 $('.combo_branch_id').select2({
		 placeholder: 'Pilih Data', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
	});   
	 
	$('#branch_cmb').select2({
      placeholder: 'Select an option',
      minimumInputLength: 2,
      //tags: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('paymenttype_report/getBranchAjax')?>',
          dataType: 'json',
          type: "GET",
          data: function (term, region) {
              return {
                  term: term,
                  region: $("#region_id").val()
              };
          },
          processResults: function (data) {
              return {
                  results: $.map(data.items, function (item) {
					
						 
                        // 	console.log(item.branch_name);
                      return {

                           text: item.branch_name, 
                           id: item.branch_id
						   //results: data
                      } 
                  })
              };
          }
      }
  });
  
	 
	
	$('#branchdlg_select').select2({
   allowClear: true,
   dropdownCssClass: 'custom-dropdown-1' ,
   placeholder: 'Select an option',
      minimumInputLength: 2,
      //tags: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('paymenttype_report/branch_select_dialog')?>',
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
	
	$('#branchdlg_select').on("select2:select", function(e) {
		var valuenya = e.params.data;
		
		region_id_s =e.params.data.id;	
		
		var data = {
			text: valuenya.region_name,
			id: valuenya.region
		}; 
		
		//console.log(e.params.data.id);
		var newOption = new Option(data.text, data.id, true, true);
		$('#regionDlg_select').select2({data: [{id: '', text: ''}]});
		$('#regionDlg_select').empty();
		$('#regionDlg_select').append(newOption).trigger('change');
		$('#region_hidden').val(e.params.data.region); 
		$('#region_Namehidden').val(e.params.data.region_name); 
		$('#branch_name').val(e.params.data.text); 
		$('#branch_id_hidden').val(e.params.data.id);
	});
	 
	
  $('#branchdlg_select').on('select2:open', function(e){
      $('.custom-dropdown-1').parent().css('z-index', 99999);
  });
  
   $('#BusinessChk').click(function() {
		var valId = $('input[name=BusinessChecked]').is(':checked');
		if(valId == true)
		{ 
			$('#storeChk').attr("checked", false); 
			$('#branchdlg_select').attr("disabled", true);  
			$('#regionDlg_select').attr("disabled", false);
			LoadInfo();
			$('#branchdlg_select').empty();
		}
		else
		{ 
			$('input[name=StoreChecked]').attr('checked', true);
			$('#regionDlg_select').attr("disabled", true);  
			$('#branchdlg_select').attr("disabled", false);   
			$('#storeChk').prop('checked',true);    
		}
		 
	});
	
    $('#storeChk').click(function() {
		var valId = $('input[name=StoreChecked]').is(':checked');
		if(valId == true)
		{
			$('#BusinessChk').removeAttr('checked');
			$('#regionDlg_select').attr("disabled", true);  
			$('#branchdlg_select').attr("disabled", false);
			$("#regionDlg_select").empty();
		}
		else
		{
			$('#storeChk').attr("checked", false); 
			$('#BusinessChk').prop('checked',true)
			$('#branchdlg_select').attr("disabled", true);  
			$('#regionDlg_select').attr("disabled", false)
		}
		
	});
	
    $('#cstartdate').click(function() {
		var valId = $('input[name=cstartdate]').is(':checked');
		if(valId == true)
		{ 
			$('#istartdate').attr("readonly", false); 
		}
		else
		{
			$('#istartdate').attr("readonly", true); 
		}
		
	});
	
    $('#cenddate').click(function() {
		var valId = $('input[name=cenddate]').is(':checked');
		if(valId == true)
		{ 
			$('#ienddate').attr("readonly", false); 
		}
		else
		{
			$('#ienddate').attr("readonly", true); 
		}
		
	});
	
    $('#submitBtn').click(function() {
		if($('#istartdate').val() == '')
		{
			alert('Pilih Start Date!');
		return false;
		}
		if($('#ienddate').val() == '')
		{
			alert('Pilih End Date!');
		return false;
		} 
	});
	
	
	function LoadInfo() {

		$.getJSON("<?php echo site_url('paymenttype_report/getRegionAll') ?>", null,
			function (data) {
				console.log(data.items.region_id);
				 $("#regionDlg_select").empty();
				 $("#regionDlg_select").append($("<option />").val('').text('Pilih Data'));
				 $.each(data.items, function () {
					 $("#regionDlg_select").append($("<option />").val(this.region_id).text(this.region_name));
				 });

		});
	}
	
  $('#regionDlg_select').attr("disabled", true); 
  $('#branchdlg_select').attr("disabled", false); 
  $('#storeChk').attr("checked", true); 
  $('#BusinessChk').attr("checked", false); 
  //$('#form_store').hide(); 
  $('#formTahun').hide(); 
  
	$('#regionDlg_select').on("select2:select", function(e) {  
		$('#region_hidden').val(e.params.data.id); 
		$('#region_Namehidden').val(e.params.data.text);
    }); 
	var d = new Date();
	var month = d.getMonth()+1;
	var day = d.getDate(); 
	var TodayDateOutput = d.getFullYear() + '-' +
		(month<10 ? '0' : '') + month + '-' +
		(day<10 ? '0' : '') + day;
	var StartDateForm = '2017-01-01';
	$('#cstartdate').trigger('click');
	$('#cenddate').trigger('click');
	$('#amorpost').trigger('click');
	
	$('#ienddate').val(TodayDateOutput);
	$('#istartdate').val(StartDateForm);
	 
	$('#rekanan_id').select2({
		  placeholder: 'Select an option',
		  minimumInputLength: 2,
		  allowClear: true,
		  //tags: true,
		  minimumResultsForSearch: 10,
		  tokenSeparators: [',', ' '],
		  ajax: {
			  url: '<?php echo site_url('paymenttype_report/rekanan_select_dialog')?>',
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
							  id: item.rekanan_id,
							  branch_ids: item.branch_id,
							  branch_names: item.branch_name,
							  region_ids: item.region_id,
							  region_names: item.region_name,
							  rekanan_lines: item.rekananshipping_line
						  }
					  })
				  };
			  }
		  }
	  }); 
	
	
	$('#tenant_combo').hide();
	$('#id_typereport').select2();
	
	$('#id_typereport').click();
	//console.log(typereport);
	$('#rekanan_id').on("select2:select", function(e) {
		var valuenya = e.params.data; 
		//
			var data = {
				text: valuenya.text,
				id: valuenya.id,
				branchid: valuenya.branch_ids,
				branchname: valuenya.branch_names,
				regionid: valuenya.region_ids,
				regionname: valuenya.region_names,
				rekananline:valuenya.rekanan_lines
			}; 
		    
			//new
			
			var newOptionRegion = new Option(data.regionname, data.regionid, true, true);
			$('#regionDlg_select').select2({data: [{id: '', text: ''}]});
			$('#regionDlg_select').empty();
			$('#regionDlg_select').append(newOptionRegion).trigger('change');
			
			// console.log(data.regionid);
			// console.log(data.regionname);
			
			var newOptionBranch = new Option(data.branchname, data.branchid, true, true);
			$('#branchdlg_select').select2({data: [{id: '', text: ''}]});
			$('#branchdlg_select').empty();
			$('#branchdlg_select').append(newOptionBranch).trigger('change');
			
			$('#region_hidden').val(e.params.data.regionid);  
			
			$('#branch_name').val(e.params.data.branchname); 
			$('#branch_id_hidden').val(e.params.data.branchid);
			
			//new
			
			//console.log(data.branchname);
			
			$('#rekanan_name').val(data.text); 
			$('#region_hidden').val(data.regionid);
			$('#branch_name').val(data.branchname);
			$('#region_Namehidden').val(data.regionname); 
			$('#rekanan_line').val(data.rekananline); 
				
	
	});
	
	$('#tenant_combo').hide();
	$('#report').show();
	
	$('#id_typereport').on("select2:select", function(e) {
		var typereport = $('#id_typereport').val(); 
		if(typereport == 0)
		{
			$('#tenant_combo').show();
			//$('#btnExc').show();
		}
		else
		{
			$('#tenant_combo').hide();
			//$('#btnExc').hide();
		}

	});
	
	$('#btnExc').show();
		
	
	$.fn.datepicker.defaults.format = "yyyy-mm-dd"; 
	$.fn.datepicker.defaults.autoclose = true;  
	$.fn.datepicker.defaults.orientation= 'bottom';
	$.fn.datepicker.defaults.todayHighlight= true;
}); 
</script> 
<div class="row">
	<div class="col-lg-12 col-md-12">		
		<?php 
                
               // echo create_breadcrumb();		
                $msg = $this->session->flashdata('message');
                $err = $this->session->flashdata('error');
                if (!empty($msg))
				{
		?> 
				<div class="alert alert-success fade in ">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
				  <strong>Info!</strong> <?php echo $msg; ?>
				</div>
		<?php
				}
                ?>
	</div>
</div><!-- /.row -->


 
<?php echo form_open(site_url($action),'role="form" class="form-horizontal" id="form_master_semesterbranch" parsley-validate target="_blank"'); ?> 
<div class="row">
						 
							<div class="col-md-2" id="formTahun"> 
							<input type="checkbox" name="StoreChecked" class="form-check-input" id="" checked disabled />
                                 <label>Tahun</label>
								 <input type="text" name="year" class="form-control" value="<?php echo date("Y") ; ?>" />
                            </div> 
							 
							
								<div class="col-md-4" id="report">
                                <label class="checkbox-inline" for="contain">
								<input type="checkbox"  checked disabled>
                                  Report
                                </label>
                               <div class="col-xs-0 input-group input-group-sm"> 
                                  <div class="input-group-addon">
								  <i class="fa fa-caret-down"></i>
								</div>
								 <select name="typereport" id="id_typereport" class="form-control" style="width: 100%;" >
										<option value ="1" selected > Summary </option>
										<option value ="0" > Detail </option>
								  </select>
                                </div>
                              </div> 
							
							<div class="col-md-6" id="tenant_combo">
                                <label class="checkbox-inline" for="contain">
								<input type="checkbox"  checked>
                                  Tenant
                                </label>
                               <div class="col-xs-0 input-group input-group-sm"> 
                                  <div class="input-group-addon">
								  <i class="fa fa-caret-down"></i>
								</div>
								   <?php echo form_dropdown('rekanan_id','','','id ="rekanan_id" class="form-control" style="width: 100%;" '); ?>
								   <input type="hidden" id="rekanan_name" name="rekanan_names" />
                                </div>
                              </div> 
							
							
							<div class="row">
							</div>
							
							
							 <div class="col-md-2">
							  <label class="checkbox-inline"><input type="checkbox" id="cstartdate" name="cstartdate">Start Date</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-addon">
								  <i class="fa fa-calendar"></i>
								</div>
								  <input type="text" class="form-control input-sm pull-right" id="istartdate" name="istartdate" value = "" autocomplete="off" readonly>
							  </div>
							</div>

							<div class="col-md-2">
							  <label class="checkbox-inline"><input type="checkbox" id="cenddate" name="cenddate">End Date</label>
							  <div class="input-group date" data-provide="datepicker">
								<div class="input-group-addon">
								  <i class="fa fa-calendar"></i>
								</div>
								  <input type="text" class="form-control input-sm pull-right" id="ienddate" name="ienddate" value = "" autocomplete="off" readonly>
							  </div>
							</div>
							
							
							<div class="row">
							</div>
							
							
							
							<div class="col-md-4" id="form_store">
								 <input type="checkbox" name="StoreChecked" class="form-check-input" id="storeChk" >
                                 <label>Store</label>
								 <select id="branchdlg_select" class="form-control" style="width: 100%;" name="branch_id_s" disabled> </select>  
                              </div> 
							 <div class="col-md-4" id="form_business">
							    <input type="checkbox" name="BusinessChecked" class="form-check-input" id="BusinessChk" disabled>
                                <label>Business Unit</label>
                                <?php echo form_dropdown('cboregionDlg',$regionCmb,'',' id="regionDlg_select" style="width: 100%;" class="iregionsearch form-control " '); ?>
								<input type="hidden" id="region_hidden" name="region_id_hidden" />
								<input type="hidden" id="region_Namehidden" name="region_name_hidden" />
								<input type="hidden" id="branch_name" name="branch_name" />
								<input type="hidden" id="rekanan_line" name="rekanan_line" />
                            </div>
							   
							<div class="row">
							&nbsp;
							</div>
<span> &nbsp;</span>     
<span> &nbsp;</span>     
<span> &nbsp;</span>     
<span> &nbsp;</span>     
<span> &nbsp;</span>  
							<div class="row">
							&nbsp;
							</div>
	<div class="col-md-8">   
	  
        <div class="btn-group">
		 <button class="btn blue btn-sm " name="button"  value="detailExcel" type="submit" style="height:35px;" id="submitBtn">
			View
		  </button>  
		</div> 
        <div class="btn-group" id="btnExc">
		 <button class="btn blue btn-sm " name="button"  value="EXCEL" type="submit" style="height:35px;" id="submitBtn">
			Excel
		  </button>  
		</div> 
		<!-- -->
         
	</div> 
	<div class="col-md-8">   
	  
       &nbsp;
         
	</div> 
	<?php if($this->session->userdata('username') == 'administrator') { ?>
 
	<!--<div class="col-md-11" align="left">  
	    <div class="btn-group">
		 <button class="btn red btn-sm " name="button"  value="detail" type="submit" style="height:35px;">
			Detail (Ipro) Non-Download
		  </button>  
		</div> 
	</div>-->
	<?php } ?>
</div>
<?php echo form_close(); ?>  

 
 
 <div class="row"> &nbsp; </div> 
  

<div class="row"> &nbsp; </div>
<span> &nbsp; </span>
 <!-- CONTENT --> 