 
<style>
	table.dataTable td {
		padding:2px;
		font-size: 9pt;    
	}

	.table-ellipsis {
		white-space: nowrap;        /* Tidak membuat teks berbaris baru */
		overflow: hidden;           /* Sembunyikan teks yang melampaui lebar */
		text-overflow: ellipsis;    /* Tampilkan '...' jika teks terpotong */
		max-width: 100px;           /* Atur lebar maksimum */
	}

	.dt-buttons {
		display: none;
	}
</style>

<!-- CONTENT -->
<!-- 1 --> 
<div class="row"> 
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-equalizer font-red-sunglo"></i>
					<span class="caption-subject font-red-sunglo bold uppercase">Aging Report</span>
					<span class="caption-helper">aging receivable, unallocated & deposit</span>
				</div>
				<div class="tools">
					<a href="" class="collapse" data-original-title="" title=""> </a>
					<a href="#portlet-config" data-toggle="modal" class="config" data-original-title="" title=""> </a>
				</div>
			</div>
			<div class="portlet-body form">
				<?=form_open('',"id='frmAging' role='form' class='form'")?>
					<div class="form-body">
						<div class="row">
							<div class="col-md-4 form-group">
								<label for="contain">
									<b>Report</b>
								</label>
								<div class="input-group input-group-sm"> 
									<select name="report_type" id="report_type" style="width: 100%;"  class="form-control" required>
										<option value=""> Pilih </option>
										<option value="aging"> Aging </option>
										<option value="agingdetail"> Aging Detail </option>
									</select> 
								</div>
							</div> 
							<div class="col-md-4 form-group">
								<label for="contain">
									<b>Business Unit</b>
								</label>
								<div class="input-group input-group-sm">
									<?php echo form_dropdown('region_ids','','','id ="region_id" class="form-control" style="width: 100%;" required'); ?>
									<input type="hidden" name="region_id" id="region_hidden"/>
								</div>
							</div> 
							<div class="col-md-4 form-group">
								<label for="contain">
									<b>Store</b>
								</label>
								<div class="input-group input-group-sm">
									<?php echo form_dropdown('branch_id','','','id ="branch_id" class="form-control" style="width: 100%;" '); ?>
								</div>
							</div>
						</div>
						<div class="row">
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
									<b>Payment Date</b>
								</label>
								<div class="input-group input-group-sm">
									<input class="form-control tanggal" type="text" id="p_date" name="payment_date" autocomplete="off"/>
									<span class="input-group-btn">
									<button id ="btcleart_3" type="button" class="btn btn-primary"><i class="fa fa-eraser"></i></button>
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 form-group">
								<label for="contain">
								<b>Tenant</b>
								</label>
								<div class="input-group input-group-sm">                                   
									<?php echo form_dropdown('rekanan_id','','','id ="rekanan_id" class="form-control" style="width: 100%;" '); ?>   
								</div>
							</div>
							<div class="col-md-4 form-group">
								<label for="contain">
									<b>Trade Name</b>
								</label>
								<div class="input-group input-group-sm">
									<?php echo form_dropdown('rekananshipping_id','','','id ="rekananshipping_id" class="form-control" style="width: 100%;" '); ?>
								</div>
							</div>
							<div class="col-md-4 form-group">
								<label for="contain">
									<b>Tenant Group</b>
								</label>
								<div class="input-group input-group-sm">
									<?php echo form_dropdown('grouptenant',$GroupTenantType,'','id ="grouptenant" class="form-control" style="width: 100%;" '); ?>
								</div>
							</div>
						</div>																						
						<div class="row">
							<div class="col-md-4 form-group">
								<label for="contain">
									<b>T_TYPE</b>
								</label>
								<div class="input-group input-group-sm"> 
									<?php echo form_dropdown('agrType',$agrType,'','id ="agrType" class="form-control" style="width: 100%;" '); ?>
								</div>
							</div>
							<div class="col-md-4 form-group">
								<label for="contain">
									<b>WHT</b>
								</label>
								<div class="input-group input-group-sm">
									<select name="wht" id="wht">
										<option value="">pilih</option>
										<option value="deductbylandlord">Deduct By LandLord</option>
										<option value="deductbytenant">Deduct By Tenant</option>
									</select>									
								</div>
							</div>
							<div class="col-md-4 form-group">
								<label for="contain">
									<b>Property Grade</b>
								</label>
								<div class="input-group input-group-sm">
									<?php echo form_dropdown('property_grade',$GradeProperty,'','id ="property_grade" class="form-control" style="width: 100%;" '); ?>
								</div>
							</div>
						</div>																						
						<div class="row">
							<div class="col-md-4 form-group">
								<label for="contain">
									<b>UnAlloc</b>
								</label>
								<div class="input-group input-group-sm">
									<select name="unalloc_select" id="unalloc_select">
										<option value="">pilih</option>
										<option value="unalloc">UnAllocated</option>
										<option value="unknown">Uknown Payment</option>
									</select>
								</div>
							</div> 
							
							<div class="col-md-4 form-group">
								<label for="contain">
									<b>Acc ID</b>
								</label>
								<div class="input-group input-group-sm">
									<?php echo form_dropdown('acc_id','','','id="acc_ids" class="form-control" style="width: 100%;" '); ?>
								</div>
							</div>

							<div class="col-md-4 form-group">
								<label></label>
								<div class="mt-checkbox-list">
									<label class="mt-checkbox mt-checkbox-outline"> Exclude PPN
										<input type="checkbox" value="1" name="ppn_include" checked>
										<span></span>
									</label>
								</div>
							</div>
						</div>
					</div>		
					<div class="form-actions right">
						<button type="submit" class="btn btn-success" id="btnGenerate">Generate</button>
					</div>					  
				<?=form_close()?>   
			</div>
		</div>
	</div>

	<div id="response"></div>
	
	<div class="col-md-12">
		<div id="tblAging" class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption font-dark">
					<i class="icon-settings font-dark"></i>
					<span class="caption-subject bold uppercase">Tabel Aging</span>
				</div>
				<div class="actions">
					<div class="btn-group">
						<a class="btn red btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">
							<i class="fa fa-share"></i>
							<span class="hidden-xs"> Tools </span>
							<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-right" id="sample_3_tools">
							<li>
								<a href="javascript:;" data-action="0" class="tool-action">
								<i class="icon-paper-clip"></i> Excel</a>
							</li>
							<li>
								<a href="javascript:;" data-action="1" class="tool-action">
									<i class="icon-check"></i> Copy</a>
							</li>
							<li>
								<a href="javascript:;" data-action="2" class="tool-action">
									<i class="icon-cloud-upload"></i> CSV</a>
							</li>
							<li class="divider"> </li>
							<li>
								<a href="javascript:;" data-action="5" class="tool-action">
									<i class="icon-refresh"></i> Reload</a>
							</li>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="portlet-body">
				<table class="table stripe hover nowrap" id='agingTable' style="width:100%">
					<thead>
						<tr>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Store</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Store Code</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Debtor Acc</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Debtor Name</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Trade Name</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Document Date</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Document No</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tax No</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Trx Date</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Trx</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Invoice</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Due Date</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Description</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Due</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;"><=14 Days</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">15-30 Days</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">31-60 Days</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">61-90 Days</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">91-120 Days</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">121-150 Days</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">>150 Days</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Total Outstanding</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Unallocated</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Deposit</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant Type</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Status</th>
							<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Corporate</th>
						</tr>
						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
						<tr>                                          
							<th colspan="14" style="text-align:right">Total</th>
							<th style="text-align:right; padding-right:10px"></th>
							<th style="text-align:right; padding-right:10px"></th>
							<th style="text-align:right; padding-right:10px"></th>
							<th style="text-align:right; padding-right:10px"></th>
							<th style="text-align:right; padding-right:10px"></th>
							<th style="text-align:right; padding-right:10px"></th>
							<th style="text-align:right; padding-right:10px"></th>
							<th style="text-align:right; padding-right:10px"></th>
							<th style="text-align:right; padding-right:10px"></th>
							<th style="text-align:right; padding-right:10px"></th>
							<th style="text-align:right; padding-right:10px"></th>
							<th style="text-align:right; padding-right:10px"></th>
							<th style="text-align:right; padding-right:10px"></th>
						</tr>
					</tfoot>
				</table>	
			</div>
		</div>	
	</div>

</div>					
<!-- 1 -->
<!-- END OF CONTENT -->
<script src="<?=base_url('/assets/plugins/exportexcel/exceljs.min.js');?>"></script>
<script src="<?=base_url('/assets/plugins/exportexcel/FileSaver.min.js');?>"></script>
<script> 
	$.fn.datepicker.defaults.format = "yyyy-mm-dd";
	$.fn.datepicker.defaults.autoclose = true;

	$(document).ready(function(){
		
		$('#frmAging').on('submit', function(e) {

			e.preventDefault();
			var formData = $(this).serialize();
            var f = $(this);

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

			$.ajax({
				type: 'POST',
				url: "<?=site_url('aging2/aging2/generateAging')?>",
				data: formData,
				beforeSend : function () {
                    blockIt({
                        target: f,
                        boxed: true,
                        message: 'Generating...'
                    });
				},
				success: function(response) {
					unblockIt(f);
					$('#response').html(response); // Display response from server
					params.init = 1;
					$tblAging.draw();
				},
				error: function() {
					unblockIt(f);
					$('#response').html('An error occurred. Please try again.');
				}
			});
		});
		
		var params = {
			init: '0'
		}

		let $tblAging = handleAgingTable(params);
		
		function handleAgingTable(params) 
		{
			var dt = $('#agingTable').DataTable({
				autoWidth: false,
				pageLength: 10,
				lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
				orderable: false,
				order: [],
				serverSide: true, 
				processing: true,
                language: {          
                    processing: `
                    <div class="loading-message loading-message-boxed">
                        <img src="<?=base_url('assets/img/loading-spinner-grey.gif')?>" align="">
                        <span>&nbsp;&nbsp;Loading...</span>
                    </div>`,
                },
				ajax: {
					url: '<?=site_url('aging2/aging2/controler_gridlist')?>',
					type: 'POST',
					data: function (o) {
						o.params = {
							init: params.init
						}
					},
				},
				//rowId: 'rowid',
				//dom: 'frtip',
				columns: [
					{ data: 'branch_name' },
					{ data: 'branch_code' },         
					{ data: 'contract_no' },         
					{ data: 'rekanan_name' },
					{ data: 'rekananshipping_name' },
					{ data: 'duedate' },
					{ data: 'jurnal_id' },
					{ data: 'faktur_id' },
					{ data: 'duedate' },
					{ data: 'transaksi_trx'},
					{ data: 'invoice_id' },
					{ data: 'invoice_duedate' },
					{ data: 'jurnal_descr'},
					{ data: 'due'},
					{ data: 'amount0' },
					{ data: 'amount30' },
					{ data: 'amount60' },
					{ data: 'amount90' },
					{ data: 'amount120' },
					{ data: 'amount150' },
					{ data: 'amount151' },
					{ data: 'totalOutstanding'},
					{ data: 'amountAllocation'},
					{ data: 'amountDeposit'},
					{ data: 'tenant_type'},
					{ data: 'p_status'},
					{ data: 'c_status'}
				],

				columnDefs: [
					//{ targets: [10], render: $.fn.dataTable.render.ellipsis( 10 ) },
					{ targets: [14, 14, 16, 17, 18, 19, 20, 21, 22, 23], width: 'auto', className: "text-right", render: $.fn.dataTable.render.number(',', '.', 2, '') },
				],
				
				footerCallback: function (row, data, start, end, display) {

					let api = this.api();

					// Remove the formatting to get integer data for summation
					let intVal = function (i) {
					return typeof i === 'string'
						? i.replace(/[\$,]/g, '') * 1
						: typeof i === 'number'
						? i
						: 0;
					};

					// Total over all pages
					var totalDay0 = api
					.column(14)
					.data()
					.reduce((a, b) => intVal(a) + intVal(b), 0);
					totalDay0 = totalDay0.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

					var totalDay30 = api
					.column(15)
					.data()
					.reduce((a, b) => intVal(a) + intVal(b), 0);
					totalDay30 = totalDay30.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

					var totalDay60 = api
					.column(16)
					.data()
					.reduce((a, b) => intVal(a) + intVal(b), 0);
					totalDay60 = totalDay60.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

					var totalDay90 = api
					.column(17)
					.data()
					.reduce((a, b) => intVal(a) + intVal(b), 0);
					totalDay90 = totalDay90.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

					var totalDay120 = api
					.column(18)
					.data()
					.reduce((a, b) => intVal(a) + intVal(b), 0);
					totalDay120 = totalDay120.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

					var totalDay150 = api
					.column(19)
					.data()
					.reduce((a, b) => intVal(a) + intVal(b), 0);
					totalDay150 = totalDay150.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

					var totalDay151 = api
					.column(20)
					.data()
					.reduce((a, b) => intVal(a) + intVal(b), 0);
					totalDay151 = totalDay151.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

					var totalOT = api
					.column(21)
					.data()
					.reduce((a, b) => intVal(a) + intVal(b), 0);
					totalOT = totalOT.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

					var totalUnallocated = api
					.column(22)
					.data()
					.reduce((a, b) => intVal(a) + intVal(b), 0);
					totalUnallocated = totalUnallocated.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

					var totalDeposit = api
					.column(23)
					.data()
					.reduce((a, b) => intVal(a) + intVal(b), 0);
					totalDeposit = totalDeposit.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

					api.column(14).footer().innerHTML = totalDay0;
					api.column(15).footer().innerHTML = totalDay30;
					api.column(16).footer().innerHTML = totalDay60;
					api.column(17).footer().innerHTML = totalDay90;
					api.column(18).footer().innerHTML = totalDay120;
					api.column(19).footer().innerHTML = totalDay150;
					api.column(20).footer().innerHTML = totalDay151;
					api.column(21).footer().innerHTML = totalOT;
					api.column(22).footer().innerHTML = totalUnallocated;
					api.column(23).footer().innerHTML = totalDeposit;
					//$('tr:eq(1) th:eq(1)', api.table().footer()).html(balance.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
				}
			});

			return dt;
		}
	
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
				url: '<?php echo site_url('aging2/region_select_dialog')?>',
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
	
							return {

								text: item.region_name, 
								id: item.region_id
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
				url: '<?php echo site_url('aging2/branch_select_dialog')?>',
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
				url: '<?php echo site_url('aging2/acc_select_dialog')?>',
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
				url: '<?php echo site_url('aging2/rekanan_select_dialog')?>',
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
				url: '<?php echo site_url('aging2/rekananshipping_select_dialog')?>',
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


        $("#sample_3_tools > li > a.tool-action").on("click", function() {
            var e = $(this).attr("data-action");
            //$tblAging.button(e).trigger();
			var t = $('#tblAging');

			$.ajax({
				type: 'POST',
				url: "<?=site_url('aging2/aging2/getAgingRow')?>",
				dataType: 'json',
				//data: formData,
				beforeSend : function () {
                    blockIt({
                        target: t,
                        boxed: true,
                        message: 'Processing...'
                    });
				},
				success: function(response) {
					exportToExcel(response);
					unblockIt(t);
				},
				error: function() {
					$.unblockUI();
					$('#response').html('An error occurred. Please try again.');
				}
			});
			
        })
		
	});

	const colorHeader = 'FF808080';
	const colorGrey1 = 'FFA9A9A9';
	const colorGrey2 = 'FFD3D3D3';
	const colorGrey3 = 'FFDEDEDE';
	const fontName = 'Arial';
	const formatNumber = '#,##0.00';
	const borderStyle = {top: {style: 'thin'}, left: {style: 'thin'}, bottom: {style: 'thin'}, right: {style: 'thin'}};

	function styleFont(cell, values, isNumber, fontSize, boldState, alignments = 'Left', borders = false, borderStyle = 'thin') 
	{
		cell.value = values;
		if (isNumber) {
			cell.numFmt = formatNumber;
			cell.alignment = {vertical: 'middle', horizontal: 'right'};
		}
		if (alignments !== 'Left') {
			cell.alignment = {vertical: 'middle', horizontal: alignments};
		}
		cell.font = {name: fontName, size: fontSize, bold: boldState};
		if (borders) {
			cell.border = {top: {style: borderStyle}, left: {style: borderStyle}, bottom: {style: borderStyle}, right: {style: borderStyle}};
		}
    }

	function styleFontColor(cell, values, fgColors, isNumber, fontSize, boldState, alignments = 'Left', borders = false, borderStyle = 'thin') 
	{
		cell.value = values;
		if (isNumber) {
			cell.numFmt = formatNumber;
			cell.alignment = {vertical: 'middle', horizontal: 'right'};
		}
		if (alignments !== 'Left') {
			cell.alignment = {vertical: 'middle', horizontal: alignments};
		}
		cell.font = {name: fontName, size: fontSize, bold: boldState};
		cell.fill = {type: 'pattern', pattern: 'solid', fgColor: {argb: fgColors}};
		if (borders) {
			cell.border = {top: {style: borderStyle}, left: {style: borderStyle}, bottom: {style: borderStyle}, right: {style: borderStyle}};
		}
    }

	function exportToExcel(data) 
	{
		let startDate = $('#f_date').val();
		let endDate = $('#t_date').val();
		let paymentDate = $('#p_date').val();
		// let cboReportType = $('#report_type').val()
		// let cboRegionName = $('#region_id').val()
		// let cboBranchName = $('#branch_id').val()
		var title = $('#report_type option:selected').text();
		var region = $('#region_id option:selected').text();
		var branch = $('#branch_id option:selected').text();

		title = `${title.trim()} Report`;
		if (branch === '')  { branch = 'All' };
		endDate = (endDate != '') ? endDate : new Date().toISOString().substr(0,10);

		const workbook = new ExcelJS.Workbook();
		workbook.creator = 'Ipro';
		workbook.lastModifiedBy = 'Ipro';
		workbook.created = new Date();
		workbook.modified = new Date();
		const worksheet = workbook.addWorksheet('Sheet1', {
			pageSetup: {paperSize: 9, orientation: 'landscape'}
		});
		worksheet.columns = [
			{key: 'Store', width: 20},
			{key: 'StoreCode', width: 10},
			{key: 'DebtorAcc', width: 15},
			{key: 'DebtorName', width: 30},
			{key: 'TradeName', width: 30},
			{key: 'DocumentDate', width: 15},
			{key: 'DocumentNo', width: 15},
			{key: 'TaxNo', width: 15},
			{key: 'TrxDate', width: 15},
			{key: 'Trx', width: 5},
			{key: 'Invoice', width: 15},
			{key: 'DueDate', width: 15},
			{key: 'Description', width: 40},
			{key: 'Due', width: 5},
			{key: '14Days', width: 20},
			{key: '30Days', width: 20},
			{key: '60Days', width: 20},
			{key: '90Days', width: 20},
			{key: '120Days', width: 20},
			{key: '150Days', width: 20},
			{key: '151Days', width: 20},
			{key: 'Outstanding', width: 20},
			{key: 'Unallocated', width: 20},
			{key: 'Deposit', width: 20},
			{key: 'Tenant Type', width: 15},
			{key: 'Status', width: 15},
			{key: 'Corporate', width: 15}
		];

		cellTitle = worksheet.getCell('A1');
		styleFont(cellTitle, title, false, 13, true);

		cellTitle = worksheet.getCell('A2');
		styleFont(cellTitle, "Region : " + region, false, 10, true);

		cellTitle = worksheet.getCell('A3');
		styleFont(cellTitle, "Branch : " + branch, false, 10, true);

		cellTitle = worksheet.getCell('A4');
		styleFont(cellTitle, "End Date : " + endDate, false, 10, true);


		//worksheet.mergeCells('A4:E4');
		//cellHeader = worksheet.getCell('A4');
		//styleFontColor(cellHeader, 'Store Code', colorHeader, false, 10, true);
		styleFontColor(worksheet.getCell('A5'), 'Store', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('B5'), 'Store Code', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('C5'), 'Debtor Acc', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('D5'), 'Debtor Name', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('E5'), 'Trade Name', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('F5'), 'Document Date', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('G5'), 'Document No', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('H5'), 'Tax No', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('I5'), 'Trx Date', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('J5'), 'Trx', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('K5'), 'Invoice', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('L5'), 'Due Date', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('M5'), 'Description', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('N5'), 'Due', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('O5'), '<=15 Days', colorHeader, false, 10, true, 'right');
		styleFontColor(worksheet.getCell('P5'), '15-30 Days', colorHeader, false, 10, true, 'right');
		styleFontColor(worksheet.getCell('Q5'), '31-60 Days', colorHeader, false, 10, true, 'right');
		styleFontColor(worksheet.getCell('R5'), '61-90 Days', colorHeader, false, 10, true, 'right');
		styleFontColor(worksheet.getCell('S5'), '91-120 Days', colorHeader, false, 10, true, 'right');
		styleFontColor(worksheet.getCell('T5'), '121-150 Days', colorHeader, false, 10, true, 'right');
		styleFontColor(worksheet.getCell('U5'), '>150 Days', colorHeader, false, 10, true, 'right');
		styleFontColor(worksheet.getCell('V5'), 'Outstanding', colorHeader, false, 10, true, 'right');
		styleFontColor(worksheet.getCell('W5'), 'Unallocated', colorHeader, false, 10, true, 'right');
		styleFontColor(worksheet.getCell('X5'), 'Deposit', colorHeader, false, 10, true, 'right');
		styleFontColor(worksheet.getCell('Y5'), 'Tenant Type', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('Z5'), 'Account', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('AA5'), 'Corporate', colorHeader, false, 10, true, 'center');

		let rownum = 5;
		let account_current = "";

		let saldoawal_sumall = 0;
		let debet_sumall = 0;
		let kredit_sumall = 0;
		let mutasi_sumall = 0;
		let saldoakhir_sumall = 0;

		let saldoawal_sum = 0;
		let debet_sum = 0;
		let kredit_sum = 0;
		let mutasi_sum = 0;
		let saldoakhir_sum = 0;

		let saldoawal = 0;
		let debet = 0;
		let kredit = 0;
		let mutasi = 0;
		let saldoakhir = 0;

		$.each(data, function (index, row) {
			let duedate = isEmpty(row.duedate) ? '' : new Date(row.duedate.substring(0, 10));
			let invoice_duedate = isEmpty(row.invoice_duedate) ? '' : new Date(row.invoice_duedate.substring(0, 10));

			rownum += 1;
			styleFont(worksheet.getCell('A' + (rownum).toString()), row.branch_name, false, 9, false);
			styleFont(worksheet.getCell('B' + (rownum).toString()), row.branch_code, false, 9, false);
			styleFont(worksheet.getCell('C' + (rownum).toString()), row.contract_no, false, 9, false);
			styleFont(worksheet.getCell('D' + (rownum).toString()), row.rekanan_name, false, 9, false);
			styleFont(worksheet.getCell('E' + (rownum).toString()), row.rekananshipping_name, false, 9, false);
			styleFont(worksheet.getCell('F' + (rownum).toString()), duedate, false, 9, false);
			styleFont(worksheet.getCell('G' + (rownum).toString()), row.jurnal_id, false, 9, false);
			styleFont(worksheet.getCell('H' + (rownum).toString()), row.faktur_id, false, 9, false);
			styleFont(worksheet.getCell('I' + (rownum).toString()), duedate, false, 9, false);
			styleFont(worksheet.getCell('J' + (rownum).toString()), row.transaksi_trx, false, 9, false);
			styleFont(worksheet.getCell('K' + (rownum).toString()), row.invoice_id, false, 9, false);
			styleFont(worksheet.getCell('L' + (rownum).toString()), invoice_duedate, false, 9, false);
			styleFont(worksheet.getCell('M' + (rownum).toString()), row.jurnal_descr, false, 9, false);
			styleFont(worksheet.getCell('N' + (rownum).toString()), row.due, false, 9, false);
			styleFont(worksheet.getCell('O' + (rownum).toString()), row.amount0, true, 9, false);
			styleFont(worksheet.getCell('P' + (rownum).toString()), row.amount30, true, 9, false);
			styleFont(worksheet.getCell('Q' + (rownum).toString()), row.amount60, true, 9, false);
			styleFont(worksheet.getCell('R' + (rownum).toString()), row.amount90, true, 9, false);
			styleFont(worksheet.getCell('S' + (rownum).toString()), row.amount120, true, 9, false);
			styleFont(worksheet.getCell('T' + (rownum).toString()), row.amount150, true, 9, false);
			styleFont(worksheet.getCell('U' + (rownum).toString()), row.amount151, true, 9, false);
			styleFont(worksheet.getCell('V' + (rownum).toString()), row.totalOutstanding, true, 9, false);
			styleFont(worksheet.getCell('W' + (rownum).toString()), row.amountAllocation, true, 9, false);
			styleFont(worksheet.getCell('X' + (rownum).toString()), row.amountDeposit, true, 9, false);
			styleFont(worksheet.getCell('Y' + (rownum).toString()), row.tenant_type, false, 9, false);
			styleFont(worksheet.getCell('Z' + (rownum).toString()), row.p_status, false, 9, false);
			styleFont(worksheet.getCell('AA' + (rownum).toString()), row.c_status, false, 9, false);

		});

		workbook.xlsx.writeBuffer().then((data) => {
			const blob = new Blob([data], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'});
			saveAs(blob, `${title}.xlsx`);
		});
	}

	function isEmpty(str) {
    	return (!str || str.length === 0);
    }
    
    function blockIt(options = {}) {
        
        options = $.extend(true, {}, options);

        var html = `
            <div class="loading-message ${options.boxed ? 'loading-message-boxed' : ''}">
                <img src="<?=base_url('assets/img/loading-spinner-grey.gif')?>" align="">
                <span>&nbsp;&nbsp;${options.message || 'Loading...'}</span>
            </div>
        `;

        if (options.target) {
            let el = $(options.target);
            if (el.height() <= ($(window).height())) {
                options.cenrerY = true;
            }
            el.block({
                message: html,
                baseZ: options.zIndex ? options.zIndex : 1000,
                centerY: options.cenrerY !== undefined ? options.cenrerY : false,
                css: {
                    border: '0',
                    padding: '0',
                    backgroundColor: 'none'
                },
                overlayCSS: {
                    backgroundColor: options.overlayColor ? options.overlayColor : '#555',
                    opacity: options.boxed ? 0.05 : 0.1,
                    cursor: 'wait'
                }
            });
        } else {
            $.blockUI({ //page blocking
                message: html,
                baseZ: options.zIndex ? options.zIndex : 1000,
                css: {
                    border: '0',
                    padding: '0',
                    backgroundColor: 'none'
                },
                overlayCSS: {
                    backgroundColor: options.overlayColor ? options.overlayColor : '#555',
                    opacity: options.boxed ? 0.05 : 0.1,
                    cursor: 'wait'
                }
            });
        }
    }

    function unblockIt(target) {
        if (target) {        
            $(target).unblock({
                onUnblock: ()=> {
                    $(target).css('position', '');
                    $(target).css('zoom', '');
                }
            });
        } else {
            $.unblockUI()
        }
    }
</script>