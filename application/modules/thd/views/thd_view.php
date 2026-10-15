<script>


$.fn.datepicker.defaults.format = "yyyy-mm-dd";
$.fn.datepicker.defaults.autoclose = true;

$(document).ready(function() { 

	
	$('.tanggal').datepicker();

	
	$('#btClearDt').click(function() {    

		$('#rpt_date').val('');
	});

	$('#regionDlg_select').select2({
		 placeholder: 'Select an option', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
	});  	

 	$('#cbo_reportType').select2({
		 placeholder: 'Select an option', 
		 tags: true,
		 width: 'resolve'
	});   
	 
	$('#branch_cmb').select2({
      placeholder: 'Select an option',
      minimumInputLength: 2,
      //tags: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('thd/getBranchAjax')?>',
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
          url: '<?php echo site_url('thd/branch_select_dialog')?>',
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

  $('#cbo_reportType').on("select2:select", function(e) {

  	if (e.params.data.id=='casual' || e.params.data.id=='terminate') {     
         $(".method").hide();
         $("#summary").hide();
  		} else {
         $(".method").show();
         $("#summary").show();        
         $("#baserent").attr('checked', true).trigger('click');
      }
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


	function LoadInfo() {

		$.getJSON("<?php echo site_url('thd/getRegionAll') ?>", null,
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
  $('#storeChk').attr("checked", true); 
  
	$('#regionDlg_select').on("select2:select", function(e) {  

		$('#region_hidden').val(e.params.data.id); 
		$('#region_Namehidden').val(e.params.data.text);
    }); 
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
	<div class="col-md-4">
      <label for="contain">
         Report Type
      </label>
		<select id="cbo_reportType" class="form-control" style="width: 100%;" name="report_type">       
         <option value="leasing">Permanent Leasing</option>
         <option value="casual">Casual Leasing</option>
         <option value="terminate">Termination</option>
      </select>
	</div>    
</div>

<div class="row method">	
	<div class="col-md-4">
      <?php echo form_label('On the basis of : ', 'f_method'); ?> <br />
		<?php echo form_radio('f_method', 'baserent', true, 'id=baserent').form_label('Baserent', 'baserent'); ?>
      <?php echo form_radio('f_method', 'invoice', false, 'id=invoice').form_label('Invoice', 'invoice'); ?>
	</div>        
</div>
<br>

<div class="row">
	<div class="col-md-4">
		<input type="checkbox" name="StoreChecked" class="form-check-input" id="storeChk" >
		<label>Store</label>
		<select id="branchdlg_select" class="form-control" style="width: 100%;" name="branch_id_s"> </select> 		
	</div>    
</div>

<div class="row">	
	<div class="col-md-4">
		<input type="checkbox" name="BusinessChecked" class="form-check-input" id="BusinessChk">
		<label>Business Unit</label>
		<?php echo form_dropdown('cboregionDlg',$regionCmb,'',' id="regionDlg_select" style="width: 100%;" class="iregionsearch form-control " '); ?>
		<input type="hidden" id="region_hidden" name="region_id_hidden" />
		<input type="hidden" id="region_Namehidden" name="region_name_hidden" />
	</div>        
</div>

<div class="row">

	<div class="col-md-4">
		<label for="contain">
			Report Date
		</label>
		<div class="input-group input-group-sm">
			<input class="form-control tanggal" type="text" id="rpt_date" name="rptDate" autocomplete="off" />
			<span class="input-group-btn">
				<button id ="btClearDt" type="button" class="btn btn-primary"><i class="fa fa-eraser"></i></button>
			</span>
		</div>
	</div>     
</div>

<br>
<br>
<div class="row">

	<div class="col-md-4">
		<div class="btn-group" style="padding-right: 10px;">
         <button id="rawdata" class="btn btn-primary btn-sm " name="button" type="submit" value="rawData" style="height:35px;">
            View Data
         </button> 
      </div>
		<div class="btn-group">
         <button id="summary" class="btn btn-danger btn-sm " name="button" type="submit" value="summary" style="height:35px;">
            Summary
         </button> 
      </div>
	</div>

</div>

<?php echo form_close(); ?>  

 <!-- CONTENT --> 