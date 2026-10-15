
<script> 
$(document).ready(function(){  
 $("#tap1").hide();
	// $.fn.modal.Constructor.prototype.enforceFocus = $.noop;
    // $("#tempdialog").modal("show");
	  $("#tabedit").trigger('click');
	 
 
 $('#addbisnisunit').click(function(){
	var sele=$("input[name='pp']:checked").val();
	$("#tbisnisunit").val(sele);

});


 $('#btbisnisunit').click(function(){
	$('#dlgbisnisunit').modal({show:true});
      $.ajax({
      url: "<?php echo site_url('or_unallocate/or_unallocate/isidialogbisnis')?>",
      async: false,
      type: "POST",
      data: "type=article",
      dataType: "html",
      success: function(data) {
        $('#dlgbisnis').html(data);
      }
    })

});
	 
$('#btacc').click(function(){
	$('#dlgbisnisunit').modal({show:true});
	var postForm = { //Fetch form data
            'vbisnisunit'     : $('#hbisnisunit').val()
        };
      $.ajax({
      url: '<?php echo site_url('or_unallocate/or_unallocate/isidialogaccount')?>',
      async: false,
      type: "POST",
      data: postForm,
      dataType: "html",
      success: function(data) {
        $('#dlgbisnis').html(data);
      }
    })
});

$('#dlgbisnisunit').on('shown.bs.modal', function(e){
   $($.fn.dataTable.tables(true)).DataTable()
      .columns.adjust();
});
 

$("#chkacc").click(function() {
  	var checked_status = this.checked;
    if (checked_status == true) {
       $("#btacc").removeAttr("disabled");	    
    } else {
       $("#btacc").attr("disabled", "disabled");
	   $("#tacc").val("");
	   $("#haccount").val("");
    } 
});


$('#cbpayment').select2({
   dropdownCssClass: 'custom-dropdown'  
    });

  $('#cbpayment').on('select2:open', function(e){
      $('.custom-dropdown').parent().css('z-index', 99999);
  });
  
  $('#cbaccpenerimaan').select2({
   dropdownCssClass: 'custom-dropdown'  
    });

  $('#cbaccpenerimaan').on('select2:open', function(e){
      $('.custom-dropdown').parent().css('z-index', 99999);
  });

$('#cboperiode').select2({
   dropdownCssClass: 'custom-dropdown'  
    });

  $('#cboperiode').on('select2:open', function(e){
      $('.custom-dropdown').parent().css('z-index', 99999);
  });
  
  
  $('#cboaccno').select2();

	$('#btdetil').click(function() {
		addRow();  
	});	  
	
	function addRow(ci) {
		var linenum=0;
		var lease_id = $('#ilease').val();

		var max=GetDgvLineMaxNum('table_d',0);
		var descH = $('#tdesc').val();
		linenum= Number(max) + 10;
		$('#table_d tbody').append('<tr>'+
        '<td>' + linenum + '<input type="hidden" name="tline[]" value="'+ linenum +'" readonly class="nogaris"/></td>'+
        '<td><textarea id="descr_'+ci+'" name="tdescr[]" class="form-control input-sm" required rows="2" >'+descH+'</textarea> '+
        '<td><div class="form-group form-group-sm"><?php echo form_dropdownext('currency_type[]',$currency_type,$currency_fill, 'id="tit_\'+ci+\'" class="form-control input-sm" required');?></div></td>'+
        '<td><input type="text" id="IDR_'+linenum+'" name="tidr[]" value="" class="idr_val form-control input-sm" /></td>'+
        '<td><input type="text" id="chg_'+ci+'" name="tidrforeign[]" value="0" class="deci form-control input-sm" style= "text-align: right;" readonly/></td>'+
        '<td><input type="text" id="chg_'+ci+'" name="trate[]" value="1" class="deci form-control input-sm" style= "text-align: right;" readonly/></td>'+
        '<td><input type="text" id="chg_'+ci+'" name="trefid[]" value="" class="deci form-control input-sm" style= "text-align: right;" readonly/></td>'+ 
		  '<td><?php echo form_dropdownext('payment[]',$payment,$this->input->post('payment'), 'id="tit_\'+ci+\'" class="form-control input-sm" required');?></td>'+	
        '<td><input type="text" id= "per_'+ci+'" name="tbank[]" value="" class="deci form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><input type="text" id="int_'+ci+'" name="tnobilyet[]" value="" class="form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><div class="input-group date"  data-provide="datepicker" data-date-format="yyyy-mm-dd">'+
        '<div class="input-group-addon">'+
        '<i class="fa fa-calendar"></i>'+
        '</div>'+
        '<input type="text" class="form-control input-sm pull-right" id="due_date" name="ttglbillyet[]">'+
        '</div></td>'+ 
		'<td><div class="input-group date"  data-provide="datepicker" data-date-format="yyyy-mm-dd">'+
        '<div class="input-group-addon">'+
        '<i class="fa fa-calendar"></i>'+
        '</div>'+
        '<input type="text" class="form-control input-sm pull-right" id="due_date" name="ttglefektif[]">'+
        '</div></td>'+  
        '<td><input type="text" id="int_'+ci+'" name="tpenerima[]" value="" class="form-control input-sm" style= "text-align: right;" /></td>'+
      
        '<td><input type="text" id= "des_'+ci+'" name="tagrtype[]" value="" class="pops form-control input-sm" readonly/>'+
        '</td>'+
        '<td><a id= "btnDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');
	};

	$('#inputDatabaseName').keyup(function () { alert('test'); });
	
	var _jumlah = 0;
	  
	$(document).on("keyup", ".idr_val", function() { 
		var id_detil = $(this).attr("id");
		var parent = $("#"+id_detil);
		parent.number( true, 0); 	
		 
		
		//console.log(_jumlah);
		
	}); 
	$(document).on("change", ".idr_val", function() { 
		var id_detil = $(this).attr("id");
		var parent = $("#"+id_detil);
		var value = $("#"+id_detil).val();
		_jumlah = parseInt(value) + parseInt(_jumlah);
		if(_jumlah > 0)
		{
			$("#ttotamount").val(_jumlah);
		} 
		$("#ttotamount").number( true, 0); 
	}); 	
	
	$("#table_d").on('click','#btnDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }
      $(this).closest('tr').remove();
  });
    
	//button dialog header event 

	$('#btn_hbusnis').click(function(){
		$('#dlgbisnisunit').modal({show:true});
		$('#titleDialog').text('Business Unit');
			var postForm = { //Fetch form data
				'txtname'   : 'tbusnis',
				'txtid'     : 'tbusnisid' 
			};
			$.ajax({
			url: '<?php echo site_url('or_unallocate/or_unallocate/isidialogbisnis')?>',
			async: false,
			type: "POST",
			data: postForm,
			dataType: "html",
			success: function(data) {
			$('#dlgbisnis').html(data);
			}
		}) 
	});
	
	$('#btn_hstore').click(function(){
		$('#dlgbisnisunit').modal({show:true});
		$('#titleDialog').text('Store');
		 var postForm = { //Fetch form data
				'vbisnisunit'     : $('#hbisnisunit').val() ,
				'txtname'   : 'txtstore',
				'txtid'     : 'txtstoreid' 
			};
		  $.ajax({
		  url: '<?php echo site_url('or_unallocate/or_unallocate/isidialogstore')?>',
		  async: false,
		  type: "POST",
		  data: postForm,
		  dataType: "html",
		  success: function(data) {
			$('#dlgbisnis').html(data);
		  }
		}) 
	});
	
	$('#btn_hstruktur').click(function(){
		$('#dlgbisnisunit').modal({show:true});
		$('#titleDialog').text('Struktur Unit');
		 var postForm = { //Fetch form data
				'vbisnisunit'     : $('#hbisnisunit').val() ,
				'txtname'   : 'tsrukturname',
				'txtid'     : 'tsrukturid' 
			};
		  $.ajax({
		  url: '<?php echo site_url('or_unallocate/or_unallocate/isidialogstruktur')?>',
		  async: false,
		  type: "POST",
		  data: postForm,
		  dataType: "html",
		  success: function(data) {
			$('#dlgbisnis').html(data);
		  }
		}) 
	});
   							  
	$('#btn_htenant').click(function(){
		$('#dlgbisnisunit').modal({show:true});
		$('#titleDialog').text('Tenant/Trade');
		var postForm = { //Fetch form data
				'vbisnisunit'     : $('#hbisnisunit').val(),
				'vstore'     : $('#hstore').val() ,
				'type'     : '',
				'txtname'   : 'ttenanname',
				'txtid'     : 'ttenantid' ,
				'txtshipid'     : 'ttshipid',
				'txtcontractno' : 'tcontractno'
				
			};
		  $.ajax({
		  url: '<?php echo site_url('or_unallocate/or_unallocate/isidialogtradename')?>',
		  async: false,
		  type: "POST",
		  data: postForm,
		  dataType: "html",
		  success: function(data) {
			$('#dlgbisnis').html(data);
		  }
		})
	}); 
	//date set_ form 
	$("#book_date").change(function(){
	  var date = new Date($("#book_date").val()),
	  days = 19; 
		if(!isNaN(date.getTime())){
		   date.setDate(date.getDate() + days);   
		   var yyyy = date.getFullYear().toString();
		   var mm = (date.getMonth()+1).toString(); // getMonth() is zero-based
		   var dd  = date.getDate().toString();
		   var hasil = yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
		   $("#due_date").val(hasil) ;
		} else {
			alert("Invalid Date");  
		}
	});
	 
	$('.input-group.date').datepicker({
		maxViewMode: 1,
		clearBtn: true,
		orientation: "bottom auto",
		todayHighlight: true,
		startView:0, 
		autoclose:true,
	});
	
});


$(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );
</script>

<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

.table td{
    padding:2px;
    font-size: 9pt;
    font-family:  Arial, Verdana, sans-serif;

}

label {
  font-size: 9pt;
  font-weight: bold;
}


</style>
                 <!--dialog -->
					<div class="modal fade" id="dlgbisnisunit" data-backdrop="static">
                      <div class="modal-dialog" style="width:35%;">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            </button>
                            <h4 class="modal-title" >
                               <label id="titleDialog"> Dialog </label> 
                            </h4>
                          </div>
                          <div class="modal-body"> 
							<div id='dlgbisnis'>
							</div>      
							<br /> 
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline btn-sm" data-dismiss="modal">
                              Close
                            </button>
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
                          <a href="<?php echo base_url('index.php/or_unallocate/or_unallocate/orlist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="<?php echo base_url('index.php/or_unallocate/or_unallocate/orunallocateadd'); ?>" id='tabdata'> INPUT </a>
                        </li>
                         <li >
                          <a href="#editdata" data-toggle="tab" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                       <div class="tab-pane" id="editdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('or_unallocate/or_unallocate/edit_or');?>" method="post" id='myform'> 
                    <div class="row">
                      <div class="col-md-12">
                     <div style="color:red"> <?php echo validation_errors(); ?> </div>
					  <?php
                     if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>ID</label>
                                      <input  type="text" id="looid" name="jurnal_id" class="form-control input-sm" value="<?php echo $row->jurnal_id;?>" readonly>
                                    </div>
                                  </div>
                                  <!-- /.form group -->

                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12"> 
                                      <label>Business Unit</label>
									   <div class="input-group">
										<div class="input-group-addon"> 
											 <a href="#" id=""> <!-- btn_hbusnis -->
												<i class="glyphicon glyphicon-search" aria-hidden="true"></i>
											 </a> 
                                        </div>
                                        <input type="text" id = "tbusnis" name="tbusnis" class="form-control input-sm" value="<?php echo $row->region_name;?>" readonly>
										<input type="hidden" id ="tbusnisid" name="tbusnisid" value="<?php echo $row->region_id;?>" class="form-control input-sm">
									   </div>  
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Channel</label>
                                        <input value="TSMC" type="text" id = "tchanel" name="tchanel" class="form-control input-sm" value="<?php echo $row->channel_id;?>" readonly>
                                    </div>
                                  </div>
                                    
                                 
                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                      <label>Periode</label>
                                                          <?php echo form_dropdown('cboperiode',$periode,$row->periode_id,'id="cboperiode" class="form-control" style="width: 100%;" required'); ?>  
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row"> 
                                    <div class="col-xs-12">
                                      <label>Store</label> 
									   <div class="input-group">
										<div class="input-group-addon"> 
											 <a href="#" id=""> <!-- btn_hstore -->
												<i class="glyphicon glyphicon-search" aria-hidden="true"></i>
											 </a> 
                                        </div>
                                        <input type="text" id = "txtstore" name="txtstore" class="form-control input-sm" value="<?php echo $row->branch_name;?>"  readonly>  
										<input type="hidden" id ="txtstoreid" name="txtstoreid" value="<?php echo $row->branch_id;?>" class="form-control input-sm">
									   </div> 
                                    </div>  
                                  </div>
                                  
							 
								  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Jurnal Type</label>
                                        <input type="text" id = "jurnaltype_id" name="jurnaltype_id" value="<?php echo $row->jurnaltype_id;?>" class="form-control input-sm" value="OR" readonly>
                                    </div>
                                  </div>
                                  
                                 <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Book Date</label>
                                      <div class="input-group date"  data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                          <input type="text" class="form-control input-sm pull-right" value="<?php echo $row->jurnal_bookdate;?>" id="book_date" name="book_date" autocomplete="off" >
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Struktur Unit</label>
									     <div class="input-group">
											<div class="input-group-addon"> 
												 <a href="#" id=""> 
													<i class="glyphicon glyphicon-search" aria-hidden="true"></i>
												 </a> 
											</div>
											<input type="text" id = "tsrukturname" name="tsrukturname" value="<?php echo $row->strukturunit_name;?>" class="form-control input-sm"  readonly>
											<input type="hidden" id ="tsrukturid" name="tsrukturid" value="<?php echo $row->strukturunit_id;?>"class="form-control input-sm"> 
										 </div> 
                                        
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Source</label>
                                        <input type="text" id = "loo_term" name="loo_term" value="<?php echo $row->jurnal_source;?>" class="form-control input-sm" value="OR-UnAllocate" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Due Date</label>
                                      <div class="input-group date"  data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                          <input type="text" class="form-control input-sm pull-right" value="<?php echo $row->jurnal_duedate;?>" id="due_date" name="due_date" readonly>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Tenant</label>
									     <div class="input-group">
											<div class="input-group-addon"> 
												 <a href="#" id=""> <!-- btn_htenant -->
													<i class="glyphicon glyphicon-search" aria-hidden="true"></i>
												 </a> 
											</div>
											<input type="text" id ="ttenanname" name="ttenanname"  value="<?php echo $row->rekanan_name;?>" class="form-control input-sm"  readonly>
											<input type="hidden" id ="ttenantid" name="ttenantid" value="<?php echo $row->rekanan_id;?>" class="form-control input-sm">
											<input type="hidden" id ="ttshipid" name="ttshipid" value="<?php echo $row->rekananshipping_line;?>" class="form-control input-sm">
										 </div>   
                                    </div>
                                  </div>
                                 
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>No Faktur</label>
                                        <input type="text" id = "tnofaktur" name="tnofaktur" class="form-control input-sm" value="<?php echo $row->jurnal_faktur;?>" value="SINGLE" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group form-group-sm row" >
                                    <div class="col-xs-12">
                                      <label>Account No</label>
                                          <?php echo form_dropdown('cboaccno',$penerimaan,$row->acc_id,'id="cboaccno" class="form-control input-sm" style="width: 100%;" required'); ?> 
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Contract No</label>
                                        <input type="text" id ="tcontractno" value="<?php echo $row->sub2_id;?>" name="tcontractno" class="form-control input-sm" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Currency</label>
                                        <input type="text" id = "tcurrency" name="tcurrency" value="<?php echo $row->currency_id;?>" class="form-control input-sm" value="IDR" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Description</label>
                                        <textarea class="form-control input-sm" name="tdesc" id="tdesc" ><?php echo $row->jurnal_descr; ?></textarea>
                                    </div>
                                  </div>
                                  
                                    <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Exchange Rate</label>
                                        <input type="text" id = "texchange" name="texchange" value="<?php echo $row->currency_rate;?>" class="form-control input-sm" readonly>
                                    </div>
                                  </div>
								  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Jurnal Posted</label>
                                        <input type="checkbox" id = "texchange" name="texchange"  class="form-control" <?php echo ($row->jurnal_isposted==1)? 'checked' : '' ?> disabled>
                                    </div>
                                  </div>
								  
								  
                                <?php }}?>
								
                                 <div class="row"> &nbsp; </div>
                                 <div class="row"> &nbsp; </div>
                                 <div class="row"> &nbsp; </div>
								 <div class="col-md-12"> 
									 <a href="javascript:void(0)" id="" class="btn btn-info " disabled > <i class="fa fa-plus-square"></i> Row</a> 
								 </div>
                                 <div class="row"> &nbsp; </div>
                                 <div class="row"> &nbsp; </div>
								 
								 
                                  <div class="col-md-12">
                                      <!-- Custom Tabs -->
                                      <div class="nav-tabs-custom">
                                        <ul class="detil nav nav-tabs">
                                          <li class="active"><a href="#xtab_1" data-toggle="tab" role= "tab">Penerimaan(D)</a></li> 
                                          <li><a href="#vtab_3" data-toggle="tab" role = "tab">Reference</a></li>
                                          <li><a href="#vtab_5" data-toggle="tab" role = "tab">Record</a></li>
                                        </ul>
                                        <div class="tab-content">
                                          <div class="tab-pane active" id="xtab_1">
                                              
                                             <div class="table-container">
												<div class="table-scrollable">                            
												  <table id="table_d" class="table" >
													<thead>
													   <tr class="m-0">
														  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;' class="col-xs-1">Line</th>
														  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;width:25%'>Description</th>
														  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Currency&nbsp;</th>
														  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>IDR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
														  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Foreign</th>
														  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Rate</th>
														  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;width:8%'>Ref ID</th>
														  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;width:15%'>Payment Type</th>
														  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Bank&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
														  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;width:12%'>No Bilyet</th>
														  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;width:12%'>Tgl Bilyet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
														  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;width:12%'>Tgl Efektif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
														  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Penerima&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
														  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;width:15%'>Agr Type</th>
													  </tr>
													   
													</thead>
													<tbody>
													 <?php 
												if(isset($resultd)){
                     									foreach($resultd as $rowd){ 
														$jumidr=$rowd->jurnaldetil_idr;
												?>
                                                  <tr>
                                                      <td><?php echo $rowd->jurnaldetil_line;?></td>
                                                      <td><?php echo $rowd->jurnaldetil_descr;?></td>
                                                      <td><?php echo $rowd->currency_id;?></td>
                                                      <td><?php echo number_format($rowd->jurnaldetil_idr,2);?></td>
                                                      <td><?php echo $rowd->jurnaldetil_foreign;?></td>
                                                      <td><?php echo $rowd->jurnaldetil_foreignrate;?></td>
                                                      <td><?php echo $rowd->ref_id;?></td>
                                                      <td><?php echo $rowd->paymenttype_name;?></td>
                                                      <td><?php echo $rowd->jurnalbilyet_bank;?></td> 
                                                      <td><?php echo $rowd->jurnalbilyet_no;?></td>  
                                                      <td><?php echo date('d-m-Y',strtotime($rowd->jurnalbilyet_date));?></td>  
                                                      <td><?php echo date('d-m-Y',strtotime($rowd->jurnalbilyet_dateeffective));?></td>
                                                      <td><?php echo $rowd->jurnalbilyet_receiveperson;?></td>
                                                      <td></td>
                                                  </tr>
                                                  <?php 
														}
												}
												  ?>
													</tbody>
												  </table> 
                                               </div>
                                             </div>
											 
                                          </div>
                                            <div class="tab-pane" id="vtab_2">
                                             <div class ="table-responsive">
                                             <table id="Dgvk"  class="table table-striped table-hover nowrap dataTable no-footer compact" >
                                                <thead>
                                                   <tr>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Line</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Account Name</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Descr</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Curr</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>IDR</th>                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Foreign</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Rate</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Region</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Branch</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Struktur Unit</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Rekanan</th>                                                      
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Ref ID</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Ref Line</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Channel</th>
                                                   </tr>
                                                                                                    
                                                   
                                                </thead>
                                                <tbody>
												 </tbody>
											 </table>  
                              
                                             </div>
                                            </div>
                                          <div class="tab-pane" id="vtab_5">
                                            <div class="row">
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Create By</label>
                                                 <input type="text" id= "_createby" name="_createby" value="<?php echo $row->jurnal_createby; ?>" class="form-control" value="">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Create Date</label>
                                                 <input type="text" name="_createdate" class="form-control " value="<?php echo date('d-m-Y',strtotime($row->jurnal_createdate)); ?>" value="">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Modify By</label>
                                                 <input type="text" id= "_modifyby"  name="_modifyby" value="<?php echo $row->jurnal_modifyby; ?>" class="form-control" value="">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Modify Date</label>
                                                 <input type="text" name="_modifydate" value="<?php echo ($row->jurnal_modifyby == '') ? '' :  date('d-m-Y',strtotime($row->jurnal_modifydate)); ?>" class="form-control" value="">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Posted By</label>
                                                 <input type="text" id= "_modifyby"  name="_modifyby" value="<?php echo $row->jurnal_postby; ?>" class="form-control" value="">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Posted Date</label>
                                                 <input type="text" name="_modifydate" value="<?php echo ($row->jurnal_postby == '') ? '' :  date('d-m-Y',strtotime($row->jurnal_postdate)); ?>" class="form-control" value="">
                                              </div>
                                             </div>
											 
											 
                                             </div>
                                          </div>
                                          
                                          <div class="tab-pane" id="vtab_3">
                                            <div class="row">
                                             
                                             </div>
                                          </div>
                                          <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                      </div>
                                      <!-- nav-tabs-custom -->
                                    </div>
                                    <!-- /.col -->
									<div class="row">
										&nbsp;
									</div>
									<div class="row">
										&nbsp;
									</div>
                                    <div class="col-xs-9">
										<span class="pull-right">Jumlah : </span>
                                	</div>
                                    <div class="col-xs-3">
                                     <input type="text" style="text-align:right" name="ttotamount" id="ttotamount" class="form-control input-sm" value="<?php echo number_format($jumidr,2);?>" readonly />
									</div>
									
                                <div class="col-xs-12"> 
                                    <br /><span class="pull-right"><input type="submit" value="SUBMIT" name="btsubmit" class="btn btn-sm btn-info" <?php echo ($row->jurnal_isposted==1)? 'disabled' : '' ?> /></span>
                                </div>
                              </div>
                             </div>
                            </form> 

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <!-- END OF CONTENT -->
