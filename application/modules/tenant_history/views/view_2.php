<script>
$(document).ready(function() { 
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
          url: '<?php echo site_url('tenant_history/getBranchAjax')?>',
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
  
	// $('#branch_cmb').on("select2:select", function(e){
		// var branch = e.params.data; 
		// console.log(branch);
		// $('#branch_name').val(branch.text); 
		// $('#branch_id_hidden').val(branch.id);
	// });
	
	
   // $("#summaryInfo").click(function(){
		// var vregion_id= $("#region_id").val();
		// var vbranch_id= $("#branch_cmb").val();
		// var vbranch_name= $("#branch_name").val();
		
		// $.post("<?php echo site_url($action); ?>", //Required URL of the page on server
		// { // Data Sending With Request To Server
		// region_id:vregion_id,
		// branch_id:vbranch_id,
		// branch_name:vbranch_name
		// },
		// function(){
			// window.open("<?php echo $action; ?>");
		// }
		// );		
	// });
	
	$('#branchdlg_select').select2({
   allowClear: true,
   dropdownCssClass: 'custom-dropdown-1' ,
   placeholder: 'Select an option',
      minimumInputLength: 2,
      //tags: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('tenant_history/branch_select_dialog')?>',
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
	 


	//$('#regionDlg_select').on("select2:select", function(e) {
		//alert('sd');
		// var valuenya = e.params.data;
		
		// region_id_s =e.params.data.id;	
		
		// var data = {
			// text: valuenya.region_name,
			// id: valuenya.region_id
		// }; 
		
		// console.log(e.params.data); 
		// $('#region_hidden').val(e.params.data.region); 
		// $('#region_Namehidden').val(e.params.data.region_name);  
	//});

	
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
	function LoadInfo() {

		$.getJSON("<?php echo site_url('tenant_history/getRegionAll') ?>", null,
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
			 
<span> &nbsp;</span>     
<span> &nbsp;</span>     
<span> &nbsp;</span>     
<span> &nbsp;</span>     
<span> &nbsp;</span>  
 
	<div class="col-md-4">   
	 
	    <div class="btn-group">
		 <button class="btn blue btn-sm " name="button" type="submit" value="summaryExcel" style="height:35px;">
			Summary (Ipro)
		  </button> 
		</div>
		
        
        <div class="btn-group">
		 <button class="btn blue btn-sm " name="button"  value="detailExcel" type="submit" style="height:35px;">
			Detail (Ipro)
		  </button>  
		</div> 
		<!-- -->
        
        <div class="btn-group">
		 <button class="btn blue btn-sm " name="button"  value="detailExcelTB" type="submit" style="height:35px;">
			Detail (TB)
		  </button>  
		</div>  
	</div> 
	
	<div class="col-md-4"> 
		<div class="btn-group">
		 <button class="btn blue btn-sm " name="button"  value="summary2Excel" type="submit" style="height:35px;">
			Summary 2 (Ipro)
		  </button>  
		</div>   
	</div> 
	
	<?php if($this->session->userdata('username') == 'administrator') { ?>

	
	<div class="col-xs-11" align="right">  
	 <div class="btn-group">
		 <button class="btn red btn-sm " name="button"  value="detail" type="submit" style="height:35px;">
			Detail (Ipro)
		  </button>  
		</div>
        <div class="btn-group">
		 <button class="btn red btn-sm " name="button"  value="summary" type="submit" style="height:35px;">
			Summary (Ipro)
		  </button>  
		</div>
        <div class="btn-group">
		 <button class="btn red btn-sm " name="button"  value="summary2" type="submit" style="height:35px;">
			Summary 2 (Ipro)  
		  </button>  
		</div>
	</div>
	<?php } ?>
</div>
<?php echo form_close(); ?>  

 
 
 <div class="row"> &nbsp; </div> 
  

<div class="row"> &nbsp; </div>
<span> &nbsp; </span>
 <!-- CONTENT --> 