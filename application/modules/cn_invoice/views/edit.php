
<script>
function maths()
{
	var vjml=0;
	var table = $("#Dgvpilih tbody");
    table.find('tr').each(function (i) {
	var $row = $(this).closest("tr"); 
	var clstreceive= $row.find(".clstreceive").val();
	var qty = parseInt(clstreceive)||0;
	vjml=vjml+qty;
	});
	$("#txtamount").val(vjml);
}

$(document).ready(function(){  
 $("#tap1").hide();
$.fn.modal.Constructor.prototype.enforceFocus = $.noop;
    $("#tempdialog").modal("show");
	$("#tabedit").trigger('click'); 
 
 $('#addbisnisunit').click(function(){
	var sele=$("input[name='pp']:checked").val();
	$("#tbisnisunit").val(sele);

});


 $('#btbisnisunit').click(function(){
	$('#dlgbisnisunit').modal({show:true});
      $.ajax({
      url: '<?php echo site_url('ormall/ormall/isidialogbisnis')?>',
      async: false,
      type: "POST",
      data: "type=article",
      dataType: "html",
      success: function(data) {
        $('#dlgbisnis').html(data);
      }
    })

}); 

			
//new $.fn.dataTable.FixedColumns(tbDgvDetil, { leftColumns:5 } );
//new $.fn.dataTable.FixedColumns(tbDgvpilih, { leftColumns:5 } );

 $('#btloadheader').click(function(){
	 $("#tap1").show();
	 var postForm = { 
            'vbisnisunit' : $('#hbisnisunit').val(),
			'vstore'    : $('#hstore').val(),
			'vtrdname'  : $('#htradename').val(),
			'vtenan'    : $('#htenant').val(),
			'hdebtor'   : $('#hdebtor').val(),
			'hshipline' : $('#hshipline').val() 
        };
		


     $.ajax({
	  url: '<?php echo site_url('ormall/ormall/isigridheader')?>',
      async: false,
      type: "POST",
      data: postForm,
      dataType: "html",
      success: function(data) {
		  $("#tap1").hide();
        $('#datgridH').html(data);
      }
    })

});

var row='';

	
	function fnGetSelected( oTableLocal )
{
    return oTableLocal.$('tr.row_selected');
}

 $('#btnverify').click(function(){
	 var table = $("#DgvDetil tbody");
	 var $target = $("#Dgvpilih");
	 var jmlamount=0
     table.find('tr').each(function (i) {
	 var $chkbox = $(this).find('input[type="checkbox"]');
	 if($chkbox.length) {
		var status = $chkbox.prop('checked');
		if (status==true){
			//alert(productId);
			var $row = $(this).closest("tr"); 
			var $clsrate= $row.find(".clsrate").val();
			var $clsforeign= $row.find(".clsforeign").val();
			var $clsrefid= $row.find(".clsrefid").val();
			var $clsaccid= $row.find(".clsaccid").val();
			var $clsaccname= $row.find(".clsaccname").val();
			
			var $clsregionid= $row.find(".clsregionid").val();
			var $clsbranchid= $row.find(".clsbranchid").val();
			var $clsstrukturunit= $row.find(".clsstrukturunit").val();
			var $clsref_line= $row.find(".clsref_line").val();
			var $clsrekananid= $row.find(".clsrekananid").val();
			var $clssub1_id= $row.find(".clssub1_id").val();
			var $clssub2_id= $row.find(".clssub2_id").val();
			
			var $tds = $(this).find('td'),
        	Invoice= $tds.eq(1).text(),
        	Tax= $tds.eq(2).text(),
        	Book = $tds.eq(3).text(),
			Amount = $tds.eq(4).text(),
			Curr= $tds.eq(5).text(),
			Descr= $tds.eq(6).text(),
			accun= $tds.eq(7).text()
			amtf= $tds.eq(8).text(),
			rcvf= $tds.eq(9).text(),
			regi= $tds.eq(10).text(),
			bran= $tds.eq(11).text(),
			Strukturunit=$tds.eq(12).text(),
			Rekanan= $tds.eq(13).text(),
			Channel= $tds.eq(14).text(),
			Shopname= $tds.eq(15).text()
		
			jmlamount=jmlamount+parseFloat(Amount.replace(/\,/g,'') || 0);
			 $('#Dgvpilih tbody').append('<tr>'+
            '<td>' + Invoice + '<input type="hidden" name="uline[]" class="clsinv" value="'+ Invoice +'"/></td>'+
            '<td>'+ Tax +'<input type="hidden" name="uunit[]" value="'+ Tax +'"/></td>'+
            '<td>'+ Book +'</td>'+
            '<td>'+ Amount +'<input type="hidden" name="usize[]" value="'+ Amount +'"/></td>'+
            '<td>'+ Curr +'<input type="hidden" name="ulantai[]" value="'+ Curr +'"/>'+
            '<input type="hidden" class="clsregionid" name="clsregionid[]" value="'+ $clsregionid +'"/>'+
            '<input type="hidden" class="clsbranchid" name="clsbranchid" value="'+ $clsbranchid +'"/>'+
			'<input type="hidden" class="clsstrukturunit" name="tstrukturunit" value="'+ $clsstrukturunit +'"/>'+
            '<input type="hidden" class="clsref_line" name="clsref_line" value="'+ $clsref_line +'"/>'+
			'<input type="hidden" class="clsrekananid" name="clsrekananid" value="'+ $clsrekananid +'"/>'+
			'<input type="hidden" class="clssub1_id" name="clssub1_id[]" value="'+ $clssub1_id +'"/>'+
            '<input type="hidden" class="clssub2_id" name="clssub2_id" value="'+ $clssub2_id +'"/>'+
            '</td>'+
			'<td>'+ Descr +'</td>'+
			'<td><input type="text" name="treceive" value="0" class="clstreceive" onkeyup="maths();" /></td>'+
			'<td>'+ accun +'</td>'+
			'<td>'+ amtf +'</td>'+
			'<td>'+ rcvf +'</td>'+
			'<td>'+ regi +'<input type="hidden" class="clsaccid" name="rfid[]" value="'+ $clsaccid +'"/></td>'+
			'<td>'+ bran +'<input type="hidden" class="clsaccname" name="rfid[]" value="'+ $clsaccname +'"/></td>'+
			'<td>'+ Strukturunit +'</td>'+
			'<td>'+ Rekanan +'<input type="hidden" class="clsrefid" name="rfid[]" value="'+ $clsrefid +'"/></td>'+
			'<td>'+ Channel +'<input type="hidden" class="clsforeign" name="rforein[]" value="'+ $clsforeign +'"/></td>'+
			'<td>'+ Shopname +'<input type="hidden" class="clsrate" name="rrate[]" value="'+ $clsrate +'"/></td>'+
            '</tr>');

		}
	}

$("#vtab_1").trigger('click');
  });	
$("#txtamount").val(jmlamount);


			
});

 
			
 $('#btstore').click(function(){
	$('#dlgbisnisunit').modal({show:true});
	var postForm = { //Fetch form data
            'vbisnisunit'     : $('#hbisnisunit').val() 
        };
      $.ajax({
      url: '<?php echo site_url('ormall/ormall/isidialogstore')?>',
      async: false,
      type: "POST",
      data: postForm,
      dataType: "html",
      success: function(data) {
        $('#dlgbisnis').html(data);
      }
    })

});



$('#bttradename').click(function(){
	$('#dlgbisnisunit').modal({show:true});
	var postForm = { //Fetch form data
            'vbisnisunit'     : $('#hbisnisunit').val(),
			'vstore'     : $('#hstore').val() 
        };
      $.ajax({
      url: '<?php echo site_url('ormall/ormall/isidialogtradename')?>',
      async: false,
      type: "POST",
      data: postForm,
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
      url: '<?php echo site_url('ormall/ormall/isidialogaccount')?>',
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
$("#chkbisnis").click(function() {
  	var checked_status = this.checked;
    if (checked_status == true) {
       $("#btbisnisunit").removeAttr("disabled");	    
    } else {
       $("#btbisnisunit").attr("disabled", "disabled");
	   $("#tbisnisunit").val("");
	   $("#hbisnisunit").val("");
    } 
});

$("#chkstore").click(function() {
  	var checked_status = this.checked;
    if (checked_status == true) {
       $("#btstore").removeAttr("disabled");	    
    } else {
       $("#btstore").attr("disabled", "disabled");
	   $("#tstore").val("");
	   $("#hstore").val("");
    } 
});

$("#chktrade").click(function() {
  	var checked_status = this.checked;
    if (checked_status == true) {
       $("#bttradename").removeAttr("disabled");	    
    } else {
       $("#bttradename").attr("disabled", "disabled");
	   $("#ttradename").val("");
	   $("#htradename").val("");
	   $("#ttenant").val("");
	   $("#htenant").val("");
    } 
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
 
  var date = new Date();
   date.setDate(date.getDate());
   $('.input-group.date').datepicker({
		maxViewMode: 1,
		clearBtn: true,
		orientation: "bottom auto",
		todayHighlight: true,
		startView:0,
		startDate: date,
	});
	
	
 $('#tabD').click(function() {
	var AmountTbl = 0;
	var AmountTbl_D = 0;
	var AmountTbl_K = 0; 
	var table = $("#table_d tbody");
	table.find('tr').each(function() { 
	
	var row = $(this).closest("tr");
	 
		var rowIdrD = row.find("#IDR_D").val();  
		console.log('IDR D');
		console.log(rowIdrD);
		rowIdrD = rowIdrD.replace(/\,/g, '');
		AmountTbl_D = AmountTbl_D + parseInt(rowIdrD);
	 
	});	  
   $("#ttotamount").val(parseFloat(AmountTbl_D));
   $('#ttotamount').number(true, 0);  
 });
 $('#tabk').click(function() {
	var AmountTbl = 0;
	var AmountTbl_D = 0;
	var AmountTbl_K = 0;
	var table = $("#table_k tbody");
	table.find('tr').each(function() {
	var row = $(this).closest("tr"); 
		var rowIdrK = row.find("#IDR_K").val(); 
		rowIdrK = rowIdrK.replace(/\,/g, '');
		AmountTbl_K = AmountTbl_K + parseInt(rowIdrK);
	 
	});	  
   $("#ttotamount").val(parseFloat(AmountTbl_K));
   $('#ttotamount').number(true, 0);  
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

 <div class="modal fade" id="dlgbisnisunit" data-backdrop="static">
                      <div class="modal-dialog" style="width:35%;">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            </button>
                            <h4 class="modal-title">
                              Business Unit
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
                        <li >
                          <a href="<?php echo base_url('index.php/cn_invoice/cn_invoice/data_list'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a  href="<?php echo base_url('index.php/cn_invoice/cn_invoice/data_add'); ?>"  id='tabdata'> INPUT </a>
                        </li>
                        <li class="active">
                          <a href="#editdata" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                         <form action="<?php echo site_url('cn_invoice/cn_invoice/edit_refund');?>" method="post" >
                        <div class="tab-pane" id="editdata">
                          <div class="portlet-body form">
                          <input type="hidden" name="hbisnisunit" id="hbisnisunit" value=""/>
							<input type="hidden" name="hstore" id="hstore" value=""/>
							<input type="hidden" name="htradename" id="htradename" value=""/>
							<input type="hidden" name="htenant" id="htenant" value=""/>
							<input type="hidden" name="haccount" id="haccount" value=""/>
                            <input type="hidden" name="hdebtor" id="hdebtor" value=""/>
                            <input type="hidden" name="hshipline" id="hshipline" value=""/>
                            <input type="hidden" name="tsruktur_id" id="tsruktur_id" value=""/>
                            <input type="hidden" name="hsub1" id="hsub1" value=""/>
                            <input type="hidden" name="hsub2" id="hsub2" value=""/>
                            <?php
							 
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>
                    <div class="row">
                      <div  class="col-md-12">
                     <div style="color:red"> <?php echo validation_errors(); ?> </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>ID</label>
                                      <input  type="text" id="ca_id" name="ca_id" class="form-control input-sm" value="<?php echo $row->jurnal_id;?>" readonly>
                                    </div>
                                  </div>
                                  <!-- /.form group -->

                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Business Unit</label>
                                        <input type="text" value="<?php echo $row->region_name;?>" id = "tbusnis" name="tbusnis" class="form-control input-sm" readonly>
                                        <input type="hidden" value="<?php echo $row->region_id;?>" id = "tbusnis_id" name="tbusnis_id" class="form-control input-sm" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Channel</label>
                                        <input type="text" value="<?php echo $row->channel_id;?>" id = "tchanel" name="tchanel" class="form-control input-sm" readonly>
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
                                        <input type="text" value="<?php echo $row->branch_name;?>"  id = "txtstore" name="txtstore" class="form-control input-sm"  readonly>
                                        <input type="hidden" value="<?php echo $row->branch_id;?>"  id = "txtbranch_id" name="txtbranch_id" class="form-control input-sm"  readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Jurnal Type</label>
                                        <input type="text" id = "loo_term" name="jurnal_type" class="form-control input-sm" value="<?php echo $row->jurnaltype_id;?>" readonly>
                                    </div>
                                  </div>
                                  
                                 <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Book Date</label>
                                      <div class="input-group date"  data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php
										$jurnal_bookdate=date("Y-m-d", strtotime($row->jurnal_bookdate));
										?>
                                          <input type="text" class="form-control input-sm pull-right" id="book_date" name="book_date" value="<?php echo $jurnal_bookdate;?>">
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Struktur Unit</label>
                                        <input type="text" value="<?php echo $row->strukturunit_name;?>" id = "tsrukturname" name="tsrukturname" class="form-control input-sm"  readonly>
                                        <input type="hidden" value="<?php echo $row->strukturunit_id;?>" id = "tsrukturid" name="tsrukturid" class="form-control input-sm"  readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Source</label>
                                        <input type="text" id = "loo_term" name="jurnal_source" class="form-control input-sm" value="<?php echo $row->jurnal_source;?>" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Due Date</label>
                                      <div class="input-group date" >
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <?php
										$jurnal_duedate=date("Y-m-d", strtotime($row->jurnal_duedate));
										?>
                                          <input value="<?php echo $jurnal_duedate;?>" type="text" class="form-control input-sm pull-right" id="due_date" name="due_date" readonly>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Tenant</label>
                                        <input type="text" value="<?php echo $row->rekanan_name;?>" id = "ttenanname" name="ttenanname" class="form-control input-sm"  readonly>
                                        <input type="hidden" value="<?php echo $row->rekanan_id;?>" id = "ttenanid" name="ttenanid" class="form-control input-sm"  readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>No Faktur</label>
                                        <input type="text" id = "tnofaktur" name="tnofaktur" class="form-control input-sm" value="SINGLE" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group form-group-sm row" >
                                    <div class="col-xs-12">
                                      <label>Account No</label>
                                          <?php echo form_dropdown('cboaccno',$penerimaan, $row->acc_id,'id="cboaccno" class="form-control input-sm" style="width: 100%;" required'); ?> 
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Contract No</label>
                                        <input type="text" value="<?php echo $row->sub2_id;?>" id="tcontractno" name="tcontractno" class="form-control input-sm" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Currency</label>
                                        <input type="text" value="<?php echo $row->currency_id;?>" id = "tcurrency" name="tcurrency" class="form-control input-sm"  readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Description</label>
                                        <textarea class="form-control input-sm" name="tdesc" id="tdesc" ><?php echo $row->jurnal_descr;?></textarea>
                                    </div>
                                  </div>
                                  
                                    <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Exchange Rate</label>
                                        <input type="text"  value="<?php echo $row->currency_rate;?>" id = "texchange" name="texchange" class="form-control input-sm" readonly>
                                    </div>
                                  </div>
                                  
                                 <div class="row" > &nbsp; </div>
                                 <div class="row" > &nbsp; </div>
                                  <div class="col-md-12">
                                      <!-- Custom Tabs -->
                                      <div class="nav-tabs-custom">
                                        <ul class="detil nav nav-tabs">
                                          <li class="active"><a href="#xtab_1" data-toggle="tab" id="tabD" role= "tab">Penerimaan(D)</a></li>
                                          <li><a href="#vtab_2" data-toggle="tab" id="tabk" role = "tab">Pembayaran(K)</a></li>
                                          <li><a href="#vtab_3" data-toggle="tab" role = "tab">Reference</a></li>
                                          <li><a href="#vtab_5" data-toggle="tab" role = "tab">Record</a></li>
                                        </ul>
                                        <div class="tab-content">
                                          <div class="tab-pane active" id="xtab_1">
                                              
                                               <div class ="table-responsive">                                   
                                              <table id="table_d" class="table table-striped table-hover nowrap dataTable no-footer compact" style="width:100%">
                                                <thead>
                                                   <tr>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Line</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;width:500px;'>Description</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Curr</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>IDR</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Foreign</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Rate</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Ref ID</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Ref Ln.</th> 
                                                  </tr>
                                                   
                                                </thead>
                                                <tbody>
                                                <?php 
												$jumidr = 0;
												if(isset($resultd)){
                     									foreach($resultd as $rowd){ 
														$jumidr +=$rowd->jurnaldetil_idr;
												?>
                                                  <tr>
                                                      <td><?php echo $rowd->jurnaldetil_line;?></td>
                                                      <td><input type="text" name="jurnaldetil_descr_d"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->jurnaldetil_descr;?>" /></td>
                                                      <td><?php echo $rowd->currency_id;?></td>
                                                      <td><input type="text" value="<?php echo number_format( $rowd->jurnaldetil_idr,2);?>" id="IDR_D" readonly style='background-color:#e9e7e7;' /> </td>
                                                      <td><?php echo $rowd->jurnaldetil_foreign;?> </td>
                                                      <td><?php echo $rowd->jurnaldetil_foreignrate;?> </td>
                                                      <td><?php echo $rowd->ref_id;?></td>
                                                      <td><?php echo $rowd->ref_line;?></td>
                                                      <td><?php echo $rowd->paymenttype_name;?><input type="hidden" name="paymenttype_id"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->paymenttype_id;?>" /></td>
                                                       
													  <input type="hidden" name="jurnaldetil_line"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->jurnaldetil_line;?>" />
													  <input type="hidden" name="currency_id"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->currency_id;?>" />
													  <input type="hidden" name="jurnaldetil_idr"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->jurnaldetil_idr;?>" />
													  <input type="hidden" name="jurnaldetil_foreign"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->jurnaldetil_foreign;?>" />
													  <input type="hidden" name="jurnaldetil_foreignrate"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->jurnaldetil_foreignrate;?>" />
													  <input type="hidden" name="jurnalbilyet_dateeffective"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->jurnalbilyet_date;?>" />
													  <input type="hidden" name="jurnalbilyet_date"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->jurnalbilyet_date;?>" />
													  <input type="hidden" name="ref_id"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->ref_id;?>" />
													  <input type="hidden" name="ref_line"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->ref_line;?>" />
													  <input type="hidden" name="sub1_id"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->sub1_id;?>" />
													  <input type="hidden" name="sub2_id"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->sub2_id;?>" />
													  <input type="hidden" name="rekananshipping_line"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->rekananshipping_line;?>" />
													  <input type="hidden" name="rekanan_id"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->rekanan_id;?>" />
													  <input type="hidden" name="strukturunit_id"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->strukturunit_id;?>" />
													  <input type="hidden" name="region_id"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->region_id;?>" />
													  <input type="hidden" name="branch_id"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->branch_id;?>" />
													  <input type="hidden" name="branch_id"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->branch_id;?>" />
													  <input type="hidden" name="channel_id"  style="width:250px" class="form-control input-sm" value="<?php echo $rowd->channel_id;?>" />
                                                  </tr>
                                                  <?php 
														}
												}
												  ?>
                                                </tbody>
                                              </table>
                                          
                                             </div>
                                          </div>
                                            <div class="tab-pane" id="vtab_2">
                                             <div class ="table-responsive">
                                             <table id="table_k"  class="table table-striped table-hover nowrap dataTable no-footer compact" width="100%">
                                                <thead>
                                                   <tr>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Line</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Account Name</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;width:500px;'>Description</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Curr</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>IDR</th> 
													  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Foreign</th>
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
                                                <?php 
												if(isset($resultk)){
                     								foreach($resultk as $rowk){ 
													$nil=$rowk->jurnaldetil_idr*-1;
												?>
                                                <tr>
                                                      <td><?php echo $rowk->jurnaldetil_line;?></td>
                                                      <td><?php echo $rowk->acc_id.'-'.$rowk->acc_name;?>
													  <input type="hidden" name="cboaccnok[]" class="form-control input-sm" value="<?php echo $rowk->acc_id;?>" /></td>
                                                      <td><input type="text" name="jurnaldetil_descr_k[]" class="form-control input-sm" value="<?php echo $rowk->jurnaldetil_descr;?>" style="width:300px"/> 
													  
													  </td>
                                                      <td><?php echo $rowk->currency_id;?></td>
                                                      <td><input type="text" value="<?php echo number_format($nil,2);?>" id="IDR_K" readonly style='background-color:#e9e7e7;' /></td> 
													  <td><?php echo $rowk->jurnaldetil_foreign;?></td>
                                                      <td><?php echo $rowk->jurnaldetil_foreignrate;?></td>
                                                      <td><?php echo $rowk->region_name;?></td>
                                                      <td><?php echo $rowk->branch_name;?></td>
                                                      <td><?php echo $rowk->strukturunit_name;?></td>
                                                      <td><?php echo $rowk->rekanan_name;?></td>
                                                      <td><?php echo $rowk->ref_id;?></td>
                                                      <td><?php echo $rowk->ref_line;?></td>
                                                      <td><?php echo $rowk->channel_id;?></td>
													  <input type="hidden" name="xjurnaldetil_line[]"  style="width:250px" class="form-control input-sm" value="<?php echo $rowk->jurnaldetil_line;?>" />
													  <input type="hidden" name="xcurrency_id[]"  style="width:250px" class="form-control input-sm" value="<?php echo $rowk->currency_id;?>" />
													  <input type="hidden" name="xjurnaldetil_idr[]"  style="width:250px" class="form-control input-sm" value="<?php echo $rowk->jurnaldetil_idr;?>" />
													  <input type="hidden" name="xjurnaldetil_foreign[]"  style="width:250px" class="form-control input-sm" value="<?php echo $rowk->jurnaldetil_foreign;?>" />
													  <input type="hidden" name="xjurnaldetil_foreignrate[]"  style="width:250px" class="form-control input-sm" value="<?php echo $rowk->jurnaldetil_foreignrate;?>" /> 
													  <input type="hidden" name="xref_id[]"  style="width:250px" class="form-control input-sm" value="<?php echo $rowk->ref_id;?>" />
													  <input type="hidden" name="xref_line[]"  style="width:250px" class="form-control input-sm" value="<?php echo $rowk->ref_line;?>" />
													  <input type="hidden" name="xsub1_id[]"  style="width:250px" class="form-control input-sm" value="<?php echo $rowk->sub1_id;?>" />
													  <input type="hidden" name="xsub2_id[]"  style="width:250px" class="form-control input-sm" value="<?php echo $rowk->sub2_id;?>" />
													  <input type="hidden" name="xrekananshipping_line[]"  style="width:250px" class="form-control input-sm" value="<?php echo $rowk->rekananshipping_line;?>" />
													  <input type="hidden" name="xrekanan_id[]"  style="width:250px" class="form-control input-sm" value="<?php echo $rowk->rekanan_id;?>" />
													  <input type="hidden" name="xstrukturunit_id[]"  style="width:250px" class="form-control input-sm" value="<?php echo $rowk->strukturunit_id;?>" />
													  <input type="hidden" name="xregion_id[]"  style="width:250px" class="form-control input-sm" value="<?php echo $rowk->region_id;?>" />
													  <input type="hidden" name="xbranch_id[]"  style="width:250px" class="form-control input-sm" value="<?php echo $rowk->branch_id;?>" />
													  <input type="hidden" name="xbranch_id[]"  style="width:250px" class="form-control input-sm" value="<?php echo $rowk->branch_id;?>" />
													  <input type="hidden" name="xchannel_id[]"  style="width:250px" class="form-control input-sm" value="<?php echo $rowk->channel_id;?>" />
                                                 </tr>
                                                  <?php 
														}
													}
												  ?>
												 </tbody>
                              </table>  
                              
                                             </div>
                                            </div>
                                          <div class="tab-pane" id="vtab_5">
                                            <div class="row">
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Create By</label>
                                                 <input type="text" id= "_createby" name="_createby" class="form-control" value="<?php echo $row->jurnal_createby;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Create Date</label>
                                                 <input type="text" name="_createdate" class="form-control " value="<?php echo $row->jurnal_createdate;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Modify By</label>
                                                 <input type="text" id= "_modifyby"  name="_modifyby" class="form-control " value="<?php echo $row->jurnal_modifyby;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Modify Date</label>
                                                 <input type="text" name="_modifydate" class="form-control" value="<?php echo $row->jurnal_modifydate;?>">
                                              </div>
                                             </div>
                                             </div>
                                          </div>
                                          
                                          <div class="tab-pane" id="vtab_3">
                                            <div class="row">
                                            
                                             <div class ="table-responsive">                                   
                                              <table id="table_d" class="table table-striped table-hover nowrap dataTable no-footer compact">
                                                <thead>
                                                   <tr>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Ref</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Line</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Bookdate</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Descr</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>IDR</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Foreign</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Region</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Branch</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Channel</th>
                                                      
                                                  </tr>
                                                   
                                                </thead>
                                                <tbody>
                                                <?php 
												if(isset($resultres)){
                     									foreach($resultres as $rowres){ 
												?>
                                                  <tr>
                                                      <td><?php echo $rowres->ref;?></td>
                                                      <td><?php echo $rowres->line;?></td>
                                                      <td><?php echo $rowres->bookdate;?></td>
                                                      <td><?php echo $rowres->descr;?></td>
                                                      <td><?php echo number_format($rowres->idr,2);?></td>
                                                      <td><?php echo $rowres->foreigns;?></td>
                                                      <td><?php echo $rowres->region_id;?></td>
                                                      <td><?php echo $rowres->branch_id;?></td>
                                                      <td>TCP</td>

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
                                          <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                      </div>
                                      <!-- nav-tabs-custom -->
                                    </div>
                                    <!-- /.col -->
									<div class="row"> &nbsp; </div>
									<div class="row"> &nbsp; </div>
                                         <div class="col-xs-9">
                                    <span class="pull-right">Jumlah : </span>
                                		</div>
                                    <div class="col-xs-3">
                                    <input type="text" style="text-align:right" name="ttotamount" id="ttotamount" class="form-control input-sm" value="<?php echo number_format($jumidr,2);?>" readonly />
                                </div>
                                <div class="col-xs-12" align="right">
                                    <br /><input type="submit" value="SUBMIT" name="btsubmit" class="btn btn-sm btn-info" />
                                </div>
                              </div>
                             </div>
                            </form>
                            <?php }}?>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <!-- END OF CONTENT -->
