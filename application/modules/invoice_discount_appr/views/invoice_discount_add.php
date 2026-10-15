<script>
	
	function cancelSubmit(){
			var ttxtdiscidr= $('#txtdiscidr').val();
			
			if($('#txtspid').val() == '' )
			{
				alert('Invoice atau Schedule Payment belum di pilih');
				return false;
			}
			
			if($('#txtdate').val() == '' )
			{
				alert('Tanggal tidak boleh dikosongkan');
				return false;
			}
			
			if ((ttxtdiscidr=='') || (ttxtdiscidr=='0'))
			{
				alert('Nilai Diskon belum di Input');
				return false;
			}
			
			if($('#txtdesc').val() == '' )
			{
				alert('Deskripsi tidak boleh dikosongkan');
				return false;
			}
			
		}
	
	$(document).ready(function() {
		
		
		
		function popgridx(vlink,namatable,optsearch, pLength=10, aCenter=[]){
			
			
			
			var oTable=$('#'+namatable).DataTable({		     
				"pageLength": pLength,
				"processing": true, 
				"serverSide": true, 
				"order": [],
				"searching" : true,
				"ajax": {
					"url": vlink,
					"type": "POST"	
				},
				
				columnDefs: [
				{ "targets": [ -1 ], "orderable": false },
				{ orderable: false, className: 'select-checkbox', targets: 0},
				{ targets: aCenter, className: 'text-center'}
				],      
				select: {
					style:    'single',
					selector: 'td:first-child'
				},
				dom:optsearch 
			});
			
			return oTable;
		}	
		
		
		
		
		
		$('#txtdiscprosen').on("keyup change", function(e) {
			var vjmlidr=0;
			var txtdiscprosen= $("#txtdiscprosen").val();
			txtdiscprosen=txtdiscprosen.replace(/,/g, "");
			
			var txtamountinv= $("#txtamountinv").val();
			txtamountinv=txtamountinv.replace(/,/g, "");
			
			var vdiskon = parseFloat(txtdiscprosen)||0;
			vjmlidr=parseFloat(txtamountinv)*(vdiskon/100);
			
			vjmlidr=vjmlidr.toFixed(2);
			$("#txtdiscidr").val(vjmlidr);
		});
		
		$("#tabdata").trigger('click');
		
		$('#txtamountinv').number( true, 2); 
		$('#txtdiscprosen').number( true, 2); 
		$('#txtdiscidr').number( true, 2); 
		
		
		
		var rTable=popgridx("<?php echo site_url('invoice_discount/invoice_discount/dialog_invoice_discount')?>","popLoader","trp",10);
		
		$('#btloo').click(function() {
			rTable.rows('.selected').deselect();
			$("#tedialog").modal("show");
		});
		
		$('#searchloo').keyup(function() {
			var searchTenant  = $("#searchloo").val(); 
			if ( $.fn.dataTable.isDataTable( '#popLoader' ) ) {
				rTable.rows('.selected').deselect();
				rTable.destroy();
				searchTenant=searchTenant.replace("/", "_"); 
				rTable = popgridx("<?php echo site_url('invoice_discount/invoice_discount/dialog_invoice_discount/')?>"+searchTenant,"popLoader","trp",10);
				rTable=$('#popLoader').DataTable();
			}
			else {
				rTable= $('#popLoader').DataTable();
			}   
		});
		var table = $('#popLoader').DataTable();
		$('#popLoader tbody').on('click', 'tr', function () {
			var selected = [];
			var id = this.id;
			var index = $.inArray(id, selected);
			
			if ( index === -1 ) {
				selected.push( id );
				} else {
				selected.splice( index, 1 );
			}
			
			$(this).toggleClass('selected');
			//var selected= [];
			/*var index = $.inArray(id, selected);
				
				if ( index === -1 ) {
				selected.push( id );
				alert('1');
				} else {
				selected.splice( index, 1 );
				}
				
				$(this).toggleClass('selected');
				$(this).hasClass('selected');
			*/
			/*if ($(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				
				}
				else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				
			}*/
		} ); 
		
		// $('#popLoader tbody').on( 'click', 'tr', function () {
        // if ( $(this).hasClass('selected') ) {
		// $(this).removeClass('selected');
        // }
        // else {
		// table.$('tr.selected').removeClass('selected');
		// $(this).addClass('selected');
		// }
		// } );
		
		// $('#popLoader tbody').on('click', 'tr', function () {
		// var data = table.row( this ).data();
		// alert( 'You clicked on '+data[0]+'\'s row' );
		// } );
		
		
		
		
		
		$('#addData').click(function () {
			
			var linenum=0;
			var rData = rTable.rows('.selected').data();
			
			for (var i=0; i < rData.length ;i++){
				
				var txtspid= rData[i][5];
				var txtspline   = rData[i][6];
				var txtspposted   = rData[i][7];
				var txtagid  = rData[i][8];
				var txtinv= rData[i][4];
				var txtamountinv= rData[i][9];
				var txttradename= rData[i][2];
				var txttenant= rData[i][1];
				$('#txtspid').val(txtspid);
				$('#txtspline').val(txtspline);
				$('#txtspposted').val(txtspposted);
				$('#txtagid').val(txtagid);
				$('#txtagid').val(txtagid);
				$('#txtinv').val(txtinv);
				$('#txtamountinv').val(txtamountinv);
				
				$('#txtinv').val(txtinv);
				$('#txttenant').val(txttenant);
				$('#txttradename').val(txttradename);
				
				
				
				
			}
			
		}); 
		$.fn.datepicker.defaults.format = "yyyy-mm-dd"; 
		$.fn.datepicker.defaults.autoclose = true; 
	}); 
</script> 
<?php
	//echo  $dialog_invoice_discount;
?>

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

<div class="modal fade" id="modal-default">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Success!</h4>
			</div>
			<div class="modal-body">
                <p>Data has been saved&hellip;</p>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default center-block" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="mdldialog" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
				</button>
				<h4 class="modal-title">
					Data Unit
				</h4>
			</div>
			<div class="modal-body"> 
				<form action="#" id="form" class="form-horizontal">
					
					
					<div class="row">  
						<div class="col-md-4">
							<label>Business Unit</label>
							<?php echo form_dropdown('cboregionDlg',$region,'',' id="regionDlg_select" style="width: 100%;" class="iregionsearch form-control " '); ?>
						</div>
						<div class="col-md-4">
							<label>Store</label>
							<select id="branchdlg_select" class="form-control" style="width: 100%;"> </select> 
						</div>
						
					</div>
					
					<div class="row"> 
						<div class="col-md-4">
							<label>Unit</label>
							<input  type="text" id="sID" class="form-control input-sm" placeholder="Search Unit" >
						</div>							
						<div class="col-md-4">
							<label>Lantai</label>
							<input  type="text" id="sUnitName" class="form-control input-sm" placeholder="Search Lantai" >
						</div>
						<div class="col-md-4" align="right">
							<br>
							<input type="button" id="btnload" value = "LOAD" class="btn btn-sm btn-info"/>
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-container">
							<div class="table-scrollable">
                                <table class="table table-striped table-bordered table-hover nowrap compact" id='uLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
									<thead>
										<tr>
											<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
											<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Region</th>
											<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Branch</th>
											<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Name</th>
											<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Sqm</th>
											<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Lantai</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<br />
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">
					Close
				</button>
				<button type="button" class="btn green" data-dismiss="modal" id="btdialog">
					Add Selected Data
				</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>



<!-- /.popup-template -->
<div class="modal fade" id="tempdialog" tabindex="-1" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
				</button>
				<h4 class="modal-title">
					Schema Unit
				</h4>
			</div>
			<div class="modal-body">
				<form action="#" id="form" class="form-horizontal">
					<div class="row">
						<div class="col-md-4">
							<label>Unit</label>
							<input  type="text" id="sID" class="form-control input-sm" placeholder="Search Unit" >
						</div>
						<div class="col-md-4">
							<label>Lantai</label>
							<input  type="text" id="sUnitName" class="form-control input-sm" placeholder="Search Lantai" >
						</div>
						<div class="col-md-4" align="right">
							<br>
							<input type="button" id="btnload" value = "LOAD" class="btn btn-sm btn-info"/>
						</div>
					</div>
					
					<br />
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">
					Close
				</button>
				<button type="button" class="btn green" data-dismiss="modal" id="addschema">
					Accept
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
							<a href="<?php echo base_url('index.php/invoice_discount/invoice_discount/invoice_discount_status'); ?>" id='tablist'> LIST </a>
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
								<form action="<?php echo site_url('invoice_discount/invoice_discount/invoice_discount_actsave');?>" method="post" onsubmit="return cancelSubmit()">
									<?php
										if(isset($result)){
											//print_r($result);
											foreach($result as $row){ ?>
											<div class="row">
												<div class="col-md-12">
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Tenant.</label>
															<input readonly type="text" id="txttenant" name="txtinv" class="form-control input-sm" >
														</div>
													</div>
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Trade Name.</label>
															<input readonly type="text" id="txttradename" name="txtinv" class="form-control input-sm" >
														</div>
													</div>
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Schedule Payment ID</label>
															<input  type="text" id="txtspid" name="txtspid" class="form-control input-sm" readonly>
															<input  type="hidden" id="txtagid" name="txtagid" class="form-control input-sm">
															<input  type="hidden" id="txtspposted" name="txtspposted" class="form-control input-sm" >
															
															
														</div>
													</div>
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Invoice No.</label>
															<input readonly type="text" id="txtinv" name="txtinv" class="form-control input-sm" >
														</div>
													</div>
													<div class="col-md-2 form-group row">
														<div class="col-xs-12">
															<label>&nbsp;</label>
															<span class="input-group-btn">
																<button id ="btloo" type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
															</span>  
														</div>
													</div>
													
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Schedule Payment Line</label>
															<input  type="text" id="txtspline" name="txtspline" class="form-control input-sm" readonly>
														</div>
													</div>
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Date</label>
															<div class="input-group date" data-provide="datepicker">
																<div class="input-group-addon">
																	<i class="fa fa-calendar"></i>
																</div>
																<input type="text" class="form-control input-sm pull-right" id="txtdate" name="txtdate" value = "<?php echo $row->loo_sdate;?>">
															</div>
														</div>
													</div>
													
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Invoice Amount</label>
															<input readonly type="text" id="txtamountinv" name="txtamountinv" class="form-control input-sm" value="0">
														</div>
													</div>
													
													
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Discount (%)</label>
															<input  type="text" id="txtdiscprosen" name="txtdiscprosen" class="form-control input-sm" value="0">
														</div>
													</div>
													
													
													
													
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Discount (IDR)</label>
															<input  type="text" id="txtdiscidr" name="txtdiscidr" class="form-control input-sm" value="0">
														</div>
													</div>
													
													
													<div class="col-md-5 form-group row">
														<div class="col-xs-12">
															<label>Description</label>
															<textarea id="txtdesc" name="txtdesc" class="form-control input-sm" ></textarea>
														</div>
													</div>                                
													
													
													
													
													<!-- /.col -->
													<div class="col-xs-12">
														<br /><input type="submit" value="SUBMIT" class="btn btn-sm btn-info" id="btsub"  />
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
	</div></div></div>
	<!-- END OF CONTENT -->
		