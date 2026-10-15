<script>
$(document).ready(function(){  

    $("#tempdialog").modal("show");
	$("#tabdata").trigger('click');
	
	$('#tabedit').click(function() {
	    display_modal('Alert!', 'Please, select data from list.');
	});

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

var tbDgvDetil = $("#DgvDetil").DataTable({
    	"columns": [
			{ "data": "pilihj" },
			{ "data": "jurnal_faktur" },
			{ "data": "faktur_id" },
			{ "data": "jurnal_bookdate" },
			{ "data": "jurnaldetil_idr" },
			{ "data": "currency_id" },			
			{ "data": "jurnaldetil_descr" },
			{ "data": "jurnaldetil_receive" },
			{ "data": "acc_name" },
			{ "data": "jurnaldetil_foreign" },
			{ "data": "jurnaldetil_receive" },			
			{ "data": "region_name" },
			{ "data": "branch_name" },
			{ "data": "strukturunit_name" },
			{ "data": "rekanan_name" },
			{ "data": "channel_id" },
			{ "data": "rekananshipping_line" }
		],
		columnDefs: [
                        { "width": "10px", "targets": 0 },
						{ "width": "140px", "targets": 1 },
						{ "width": "140px", "targets": 3 },
						{ "width": "290px", "targets": 6 },
						{ "width": "140px", "targets": 8 },
						{ "width": "190px", "targets": 11 },
						{ "width": "190px", "targets": 12 },
						{ "width": "190px", "targets": 14 },
						{'targets': 0,
            			'checkboxes': {
               				'selectRow': true
           				 } }
					],
					
      'select': {
         'style': 'multi'
      },
    rowCallback: function (row, data) {},
    filter: false,
    info: false,
    ordering: false,
    processing: true,
    retrieve: true ,
	paging:false,
	scrollY: "100px",
    scrollX: true,
    scrollCollapse: true


	      
});




var tbDgvpilih = $("#Dgvpilih").DataTable();
			
//new $.fn.dataTable.FixedColumns(tbDgvDetil, { leftColumns:5 } );
//new $.fn.dataTable.FixedColumns(tbDgvpilih, { leftColumns:5 } );

 $('#btloadheader').click(function(){
  	$.ajax({
            url: "<?php echo site_url('ormall/ormall/isigridheader')?>",
            type: "post",
             data: "type=article",
      		dataType: "json",
        }).done(function (result) {
            tbDgvDetil.clear().draw();
            tbDgvDetil.rows.add(result).draw();
            }).fail(function (jqXHR, textStatus, errorThrown) { 
            });

});

var row='';

$('#DgvDetil tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
        var pos = tbDgvDetil.row(this).index();
        row = tbDgvDetil.row(pos).data();
       
    } );
	
	function fnGetSelected( oTableLocal )
{
    return oTableLocal.$('tr.row_selected');
}

 $('#btnverify').click(function(){

//tbDgvDetil.row.add(row).draw();
 var oData = tbDgvDetil.rows('.selected').data();
        
        for (var i=0; i < oData.length ;i++){
           alert("Name: " + oData[i][0] + " Position: " + oData[i][1] + " Office: " + oData[i][2]);
        }
	  

		 
		 
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

    <div id="popover-form" class="hide">
      <div class="form-group">
        <textarea rows="4" name="txtContent" id="txtContent" class="form-control input-sm"></textarea>        
        <br>
        <button id="btnOk" type="button" class="btn btn-primary">
          <span class="glyphicon glyphicon-ok"></span>&nbsp;
        </button>  
        <button id="btnCancel" type="button" class="btn btn-default">
          <span class="glyphicon glyphicon-remove"></span>&nbsp;
        </button>
      </div>
    </div>

        

                    <!-- /.popup-tenant -->
                   

                    <!-- /.popup-template -->
                    <div class="modal fade" id="tempdialog" tabindex="-1" role="basic" aria-hidden="true">
                      <div class="modal-dialog" style="width:70%;">
                        <div class="modal-content">
                          <div class="modal-header" >
                             <h4 class="modal-title">
                              SA-Receivable List
                            </h4>
                          </div>
                          <div class="modal-body">
                            <form action="#" id="form" class="form-inline">
                            <input type="hidden" name="hbisnisunit" id="hbisnisunit" value=""/>
							<input type="hidden" name="hstore" id="hstore" value=""/>
							<input type="hidden" name="htradename" id="htradename" value=""/>
							<input type="hidden" name="htenant" id="htenant" value=""/>
							<input type="hidden" name="haccount" id="haccount" value=""/>
                           <table style="width:100%" class="table" cellpadding="0" cellspacing="0">

    <tr>
   	 	<td valign="top">
        	<table style="width:100%" >
            <tr>
            	<td height="63" valign="top"><input type="checkbox" name="checkbox" id="checkbox"/></td>
                <td valign="top">ID(s)</td>
                <td valign="top"><textarea name="textarea" id="textarea" cols="50" rows="2" class="form-control input-sm"></textarea></td>
            </tr>

            <tr>
              <td valign="middle"><input type="checkbox" name="checkbox2" id="checkbox2" /></td>
              <td valign="middle">Start date</td>
              <td valign="middle">
              <div class="input-group date" data-provide="datepicker">
    				<input type="text" class="form-control input-sm" style="width:270px">
    				<div class="input-group-addon">
        				<span class="glyphicon glyphicon-th"></span>
    				</div>
			 </div>
              </td>
            </tr>
            <tr>
              <td valign="middle"><input type="checkbox" name="checkbox2" id="checkbox2" /></td>
              <td valign="middle">End date</td>
              <td valign="middle">
              <div class="input-group date" data-provide="datepicker">
    				<input type="text" class="form-control input-sm" style="width:270px">
    				<div class="input-group-addon">
        				<span class="glyphicon glyphicon-th"></span>
    				</div>
			 </div>
              </td>
            </tr>
            <tr>
              <td valign="middle"><input type="checkbox" name="checkbox2" id="checkbox2" /></td>
              <td valign="middle">Invoice Id</td>
              <td valign="middle"><input type="text" class="form-control input-sm" style="width:309px"></td>
            </tr>
            </table>
        </td>
        <td valign="top"><table style="width:100%">
            <tr>
            	<td valign="top"><input type="checkbox" name="chkbisnis" id="chkbisnis" /></td>
                <td valign="top">Business Unit</td>
                <td valign="top" align="right"><button type="button" class="btn btn-primary btn-sm" id="btbisnisunit"  disabled><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button><input type="text" name="tbisnisunit" id="tbisnisunit" class="form-control input-sm" style="width:290px" disabled /></td>
            </tr>
            <tr>
              <td valign="top"><input type="checkbox" name="chkstore" id="chkstore" /></td>
              <td valign="top">Store</td>
              <td valign="top" align="right"><button type="button" class="btn btn-primary btn-sm" id="btstore" disabled><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button><input type="text" name='tstore' id='tstore' class="form-control input-sm" style="width:290px" disabled/></td>
            </tr>
            <tr>
              <td valign="middle"><input type="checkbox" name="chktrade" id="chktrade" /></td>
              <td valign="middle">Trade Name</td>
              <td valign="middle" align="right"><button type="button" id='bttradename' class="btn btn-primary btn-sm" disabled><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button><input type="text" name="ttradename" id="ttradename" class="form-control input-sm" style="width:290px" disabled/></td>
            </tr>
            <tr>
              <td valign="middle"><input type="checkbox" name="chktenant" id="chktenant" checked disabled /></td>
              <td valign="middle">Tenant</td>
              <td valign="middle" align="right"><button type="button" id="bttenant" class="btn btn-primary btn-sm" disabled><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button><input type="text" name='ttenant' id='ttenant' class="form-control input-sm" style="width:290px" disabled/></td>
            </tr>
            <tr>
              <td valign="middle"><input type="checkbox" name="chkacc" id="chkacc" /></td>
              <td valign="middle">Account</td>
              <td valign="middle" align="right"><button type="button" id="btacc" class="btn btn-primary btn-sm" disabled><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button><input type="text" name="tacc" id="tacc" class="form-control input-sm" style="width:290px" disabled/></td>
            </tr>
            <tr>
              <td valign="top">&nbsp;</td>
              <td valign="top">&nbsp;</td>
              <td valign="top" align="right"><button class="btn btn-primary btn-sm" id="btloadheader" type="button"><i class="fa fa-magic mr-1"></i>Load</button></td>
            </tr>

         </table>
         </td>
    </tr>
</table>
<table id="DgvDetil"  class="table table-striped table-hover nowrap dataTable no-footer compact" >
                                                <thead>
                                                   <tr>
                                                     <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'></th>
                                                     <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Invoice</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Tax</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Book</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Amount</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Curr</th>                                                      
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Descr</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Receive</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Account</th>
                                                      <th>AmountForeign</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>ReceiveForeign</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Region</th>                                                      
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Branch</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Strukturunit</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Rekanan</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Channel</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Shopname</th>
                                                  </tr>
                                                                                                    
                                                   
                                                </thead>
                                                <tbody>
												 </tbody>
                              </table>
                                            
                                              <table style="width:100%" >
                                              <tr>
                                              <td align="right"><button type="button" class="btn btn-primary btn-sm" id="btnverify"><i class="fa fa-magic mr-1"></i>Verify</button></td>
                                              </tr>
                                              </table>

<table id="Dgvpilih"  class="table table-striped table-hover nowrap dataTable no-footer compact" >
                                                <thead>
                                                   <tr>
                                                     <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Pilih</th>
                                                     <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Invoice</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Tax</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Book</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Amount</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Curr</th>                                                      
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Descr</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Receive</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Account</th>
                                                      <th>AmountForeign</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>ReceiveForeign</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Region</th>                                                      
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Branch</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Strukturunit</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Rekanan</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Channel</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Shopname</th>
                                                  </tr>
                                                                                                    
                                                   
                                                </thead>
                                                <tbody>
												 </tbody>
                              </table>                        
                              <table style="width:100%" >
                                              <tr>
                                             <td align="right"><button type="button" class="btn dark btn-outline btn-sm" data-dismiss="modal">Cancel</button>&nbsp;&nbsp;<button class="btn btn-primary btn-sm" id="btterima"><i class="fa fa-magic mr-1"></i>Penerimaan</button></td>
                                              </tr>
                                              </table>
                            
                              
                            </form>
                          </div>
                         
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>


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
                            <form action="#" id="form" class="form-horizontal">                         
							
                             
                                        <div id='dlgbisnis'>
                                        </div>     

                        <br />
                        </form>
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
                          <a href="<?php echo base_url('index.php/loo/loo/loolist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="#newdata" data-toggle="tab" id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane" id="newdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('loo/loo/loo_add');?>" method="post" onsubmit="return validateb4submit();">
                            <?php
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>
                    <div class="row">
                      <div class="col-md-12">
                     <div style="color:red"> <?php echo validation_errors(); ?> </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>ID</label>
                                      <input  type="text" id="looid" name="loo_id" class="form-control input-sm" value="<?php echo $row->loo_id;?>" readonly>
                                    </div>
                                  </div>
                                  <!-- /.form group -->

                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Business Unit</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="<?php echo $row->loo_term;?>" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Channel</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="<?php echo $row->loo_term;?>" readonly>
                                    </div>
                                  </div>
                                    
                                 
                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                      <label>Periode</label>
                                        <select data-placeholder="Select a store" id= "ibranch" name= "cbobranch" required>
                                          <option value="<?php echo $row->branch_id;?>" selected="selected" ><?php echo $row->branch_id;?></option>
                                        </select>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Store</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="<?php echo $row->loo_term;?>" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Jurnal Type</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="<?php echo $row->loo_term;?>" readonly>
                                    </div>
                                  </div>
                                  
                                 <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Book Date</label>
                                      <div class="input-group date">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                          <input type="text" class="form-control input-sm pull-right" id="loo_date" name="loo_date" value = "<?php echo $row->loo_date;?>" readonly>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Struktur Unit</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="<?php echo $row->loo_term;?>" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Source</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="<?php echo $row->loo_term;?>" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Due Date</label>
                                      <div class="input-group date">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                          <input type="text" class="form-control input-sm pull-right" id="loo_date" name="loo_date" value = "<?php echo $row->loo_date;?>" readonly>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Tenant</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="<?php echo $row->loo_term;?>" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>No Faktur</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="<?php echo $row->loo_term;?>" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Account No</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="<?php echo $row->loo_term;?>" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Contract No</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="<?php echo $row->loo_term;?>" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Currency</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="<?php echo $row->loo_term;?>" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Description</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="<?php echo $row->loo_term;?>" readonly>
                                    </div>
                                  </div>
                                  
                                    <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Exchange Rate</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="<?php echo $row->loo_term;?>" readonly>
                                    </div>
                                  </div>
                                  
                                 
                                  <div class="col-md-12">
                                      <!-- Custom Tabs -->
                                      <div class="nav-tabs-custom">
                                        <ul class="detil nav nav-tabs">
                                          <li class="active"><a href="#tab_1" data-toggle="tab" role= "tab">Penerimaan(D)</a></li>
                                          <li><a href="#tab_2" data-toggle="tab" role = "tab">Pembayaran(K)</a></li>
                                          <li><a href="#tab_4" data-toggle="tab" role = "tab">Reference</a></li>
                                          <li><a href="#tab_3" data-toggle="tab" role = "tab">Response</a></li>
                                          <li><a href="#tab_3" data-toggle="tab" role = "tab">Record</a></li>
                                        </ul>
                                        <div class="tab-content">
                                          <div class="tab-pane active" id="tab_1">
                                              
                                               <div class="dwrapper">                                   
                                              <table id="fixed_hdr1">
                                                <thead>
                                                   <tr>
                                                      <th>Line</th>
                                                      <th>jurnal_id</th>
                                                      <th>D/K</th>
                                                      <th>Account</th>
                                                      <th>Account Name</th>
                                                      <th>StrukturUnit</th>
                                                      
                                                      <th>Descr</th>
                                                      <th>Curr</th>
                                                      <th>IDR</th>
                                                      <th>Foreign</th>
                                                      <th>Rate</th>
                                                      <th>Region</th>
                                                      
                                                      <th>Branch</th>
                                                      <th>Rekanan</th>
                                                      <th>Ref ID</th>
                                                      <th>Ref Line</th>
                                                      <th>Sub1</th>
                                                      <th>Sub2</th>
                                                      
                                                      <th>Channel</th>
                                                      <th>Payment Type</th>
                                                      <th>Bank</th>
                                                      <th>No Bilyet</th>
                                                      <th>Tgl Bilyet</th>
                                                      <th>Tgl Efektif</th>
                                                      
                                                      
                                                     
                                                  </tr>
                                                   
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                     <td>tes</td>
                                                     <td><input type="text" value="001"  style="height: 20px; border:1px solid white" /></td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                     <td>&nbsp;</td>
                                                   </tr>
                                                </tbody>
                                              </table>
                                          
                                             </div>
                                          </div>
                                            <div class="tab-pane" id="tab_2">
                                             <div class ="table-responsive">
                                              <table class="table table-bordered table-striped" id='unittab' style="border:solid 1px #999; #999; border-radius:0px;">
                                                <thead>
                                                  <tr>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">jurnal_id</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">D/K</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Account</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Account Name</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">StrukturUnit</th>
                                                      
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Descr</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Curr</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">IDR</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Foreign</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Rate</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Region</th>
                                                      
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Branch</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Rekanan</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Ref ID</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Ref Line</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Sub1</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Sub2</th>
                                                      
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Channel</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Payment Type</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Bank</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">No Bilyet</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tgl Bilyet</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tgl Efektif</th>
                                                      
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Penerima</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Penanggung Jawab</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Agreement Type</th>
                                                     
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                   <?php if(isset($resultu)){
                                                        foreach($resultu as $rowd){
                                                    ?>
                                                      <tr>
                                                      <td><?php echo $rowd->loounit_line;?><input type="hidden" name="uline[]" value="<?php echo "$rowd->loounit_line";?>"/></td>
                                                      <td><?php echo $rowd->unit_id;?><input type="hidden" name="uunit[]" value="<?php echo "$rowd->unit_id";?>" /></td>
                                                      <td><?php echo $rowd->unit_name;?></td>
                                                      <td><?php echo $rowd->loounit_space;?><input type="hidden" name="usize[]" value="<?php echo "$rowd->loounit_space";?>"/></td>
                                                      <td><?php echo $rowd->lantai_name;?><input type="hidden" name="ulantai[]" value="<?php echo "$rowd->lantai_id";?>"/></td>
                                                      <td><a id= "uDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
                                                      </tr>
                                                    <?php
                                                       }
                                                     }
                                                   ?>
                                                </tbody>
                                              </table>
                                             </div>
                                            </div>
                                          <div class="tab-pane" id="tab_3">
                                            <div class="row">
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Create By</label>
                                                 <input type="text" id= "_createby" name="_createby" class="form-control" value="<?php echo $row->_createby;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Create Date</label>
                                                 <input type="text" name="_createdate" class="form-control " value="<?php echo $row->_createdate;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Modify By</label>
                                                 <input type="text" id= "_modifyby"  name="_modifyby" class="form-control " value="<?php echo $row->_modifyby;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Modify Date</label>
                                                 <input type="text" name="_modifydate" class="form-control" value="<?php echo $row->_modifydate;?>">
                                              </div>
                                             </div>
                                             </div>
                                          </div>
                                          
                                          <div class="tab-pane" id="tab_4">
                                            <div class="row">
                                            
                                              <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>LOO Template</label>
                                                 <?php
					  $pilihan4=array(
					''=>'==Pilih LOO Template==',
					'1'=>'ATM',
					'2'=>'F&B',
					'3'=>'FOOD COURT',
					'4'=>'JEWELLERY',
					'5'=>'SPECIALTY',
					);
					$cs4='class="form-control input-sm"';
					echo form_dropdown('cbotmploo',$pilihan4,"",$cs4);
					?>
                                              </div>
                                             </div>
                                             
                                             
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Lease Period</label>
                                                 <input type="text" id= "txtleased" name="txtleased" class="form-control" value="<?php echo $row->_createby;?>">
                                              </div>
                                             </div>
                                             
                                              <div class="col-md-6">
                                              <div class="col-xs-8">

                                     <label>Commencement Date</label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="loo_comdate" name="loo_comdate">
                                      </div>

                                              </div>
                                             </div>
                                             
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Legal Costs and Stamp Duty</label>
                                                 <?php
					  $pilihan5=array(
					''=>'==Pilih==',
					'1'=>'Perusahaan',
					'2'=>'Personnal',
					);
					$cs4='class="form-control input-sm"';
					echo form_dropdown('cbostamp',$pilihan5,"",$cs4);
					?>
                                              </div>
                                             </div>
                                             
                                            <div class="col-md-6">
                                              <div class="col-xs-8">
                                              
                                              <label class="checkbox-inline"><input value="1" type="checkbox" name="ckguarantor">Guarantor</label>
                                              </div>
                                             </div>
                                               
                                             <div class="col-md-12">
                                              <div class="col-xs-12">
                                              <label>Other Conditions</label>
                                             <textarea name="txtdemised"  rows="3" class="form-control "></textarea>
                                              </div>
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
                                <div class="col-xs-12">
                                    <br /><input type="submit" value="SUBMIT" class="btn btn-sm btn-info" />
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
