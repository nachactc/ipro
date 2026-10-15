<script>
$(document).ready(function() {
 $('.combo_reegion_id').select2({
		 placeholder: 'Pilih Data', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
	});  

	
	$('#BusinessChk').click(function() {
		$('#regionDlg_select').select2();
		 
		//alert(rep);
		var valId = $('input[name=BusinessChecked]').is(':checked');
		if(valId == true)
		{ 
			$('#storeChk').attr("checked", false); 
			$('#branchdlg_select').attr("disabled", true);  
			$('#regionDlg_select').attr("disabled", false);
			LoadInfo();
			$('#branchdlg_select').empty(); 
			$('#branch_name').val('');
			$('input[id=branch_id_hidden]').val(''); 
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
		var cd = $('#branch_name').val();
		 
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

		$.getJSON("<?php echo site_url('va_download/getRegionAll') ?>", null,
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
	 $('#branchdlg_select').select2({
   allowClear: true,
   dropdownCssClass: 'custom-dropdown-1' ,
   placeholder: 'Select an option',
      minimumInputLength: 2,
      //tags: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('va_download/branch_select_dialog')?>',
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
	$('.combo_branch_id').select2({
		 placeholder: 'Pilih Data', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
	}); 
	$('#monthDates').select2({
		 placeholder: 'Pilih Data', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
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
 
<?php echo form_open(site_url($action),'target="_blank" role="form" class="form-horizontal" id="form_master_semesterbranch" parsley-validate'); ?> 
	<div class="row">
		<div class="col-md-16"> 
		   

		  <div class="col-md-4 form-group row">
			<div class="col-xs-12">
			  <label for="region_id" class="control-label">Month</label>
			<?php                  
			   echo form_dropdown(
					   'monthPeriode',
					   $monthCmb,  
					   set_value('month', $monthSelected), 
					   'class="form-control" id="monthDates"'
					   );             
			  ?>  
			</div>
			 
		  </div> <!--/ 1 -->
		  
		  <div class="col-md-4">
				 <input type="checkbox" name="StoreChecked" class="form-check-input" id="storeChk" >
				 <label>Store</label>
				 <select id="branchdlg_select" class="form-control" style="width: 100%;" name="branch_id_s"> </select>  
			  </div> 
			 <div class="col-md-4">
				<input type="checkbox" name="BusinessChecked" class="form-check-input" id="BusinessChk">
				<label>Business Unit</label>
				<?php echo form_dropdown('cboregionDlg',$regionCmb,'',' id="regionDlg_select" style="width: 100%;" class="iregionsearch form-control " '); ?>
				<input type="hidden" id="region_hidden" name="region_id_hidden" />
				<input type="hidden" id="region_Namehidden" name="region_name_hidden" />
			  </div>
			  
			<div class="row">
			&nbsp;
			</div>
			<div class="col-md-12">
		    <div align="right">
				<button type="submit" class="btn btn-md btn-info" name="post">
					<i class="glyphicon glyphicon-floppy-save"></i> Load 
					</button>   
					<!--/ button -->  
				 
				</div>
				</div>
	 
	<input type="hidden" name="branch_name"  id="branch_name" value="<?php echo $items['branch_id'] != '' ? $items['branch_id'] : '' ?>">
	<input type="hidden" name="branch_id_hidden"  id="branch_id_hidden" value="<?php echo $branchCmb['branch_id'] != '' ? $branchCmb['branch_id'] : '' ?>">
	 
</div> 
 
</div>  
				   
<?php echo form_close(); ?> 
 
 