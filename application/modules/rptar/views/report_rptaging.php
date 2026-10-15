 <style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  overflow:hidden;padding:10px 5px;word-break:normal;}
.tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
.tg .tg-0lax{text-align:left;vertical-align:top}
</style>
<!-- Load export excel plugins ----->
<script src="<?php echo base_url('/assets/plugins/exportexcel/shim.min.js');?>"></script>
<script src="<?php echo base_url('/assets/plugins/exportexcel/xlsx.full.min.js');?>"></script>
<script src="<?php echo base_url('/assets/plugins/exportexcel/Blob.js');?>"></script>
<script src="<?php echo base_url('/assets/plugins/exportexcel/FileSaver.js');?>"></script>

<button class="exportToExcel" id="buttonExport">EXCEL</button>

<table class="tg datadetil" id="report_aging" >
<thead>
  <tr>
    <th class="tg-0lax">jurnal_id</th>
    <th class="tg-0lax">jurnaldetil_descr</th>
    <th class="tg-0lax">region_id</th>
    <th class="tg-0lax">region_name</th>
    <th class="tg-0lax">branch_id</th>
    <th class="tg-0lax">branch_name</th>
    <th class="tg-0lax">rekanan_id</th>
    <th class="tg-0lax">rekanan_name</th>
    <th class="tg-0lax">rekananshippping_line</th>
    <th class="tg-0lax">rekananshipping_name</th>
    <th class="tg-0lax">acc_id</th>
    <th class="tg-0lax">acc_name</th>
    <th class="tg-0lax">jurnal_bookdate</th>
    <th class="tg-0lax">periode</th>
    <th class="tg-0lax">duedate</th>
    <th class="tg-0lax">due</th>
    <th class="tg-0lax">Invoice_Amount</th>
    <th class="tg-0lax">settlement_idr</th>
    <th class="tg-0lax">receive_idr</th>
    <th class="tg-0lax">Aging_Amount</th>
    <th class="tg-0lax">ref_id</th>
    <th class="tg-0lax">faktur_id</th>
    <th class="tg-0lax">faktur_date</th>
    <th class="tg-0lax">deduct_type</th>
    <th class="tg-0lax">contract_no</th>
    <th class="tg-0lax">transaksi_type</th>
    <th class="tg-0lax">transaksi_trx</th>
    <th class="tg-0lax">doc_type</th>
    <th class="tg-0lax">grouptenant_id</th>
    <th class="tg-0lax">InvoiceNumber</th>
  </tr>
</thead>
<tbody>
	<?php 
		// echo var_dump($result);
		if (!empty($result)) {
		foreach($result as $row){	
	?>
  <tr>
    <td class="tg-0lax"><?php echo $row->jurnal_id; ?></td>
    <td class="tg-0lax"><?php echo $row->jurnaldetil_descr; ?></td>
    <td class="tg-0lax"><?php echo $row->region_id; ?></td>
    <td class="tg-0lax"><?php echo $row->region_name; ?></td>
    <td class="tg-0lax"><?php echo $row->branch_id; ?></td>
    <td class="tg-0lax"><?php echo $row->branch_name; ?></td>
    <td class="tg-0lax"><?php echo $row->rekanan_id; ?></td>
    <td class="tg-0lax"><?php echo $row->rekanan_name; ?></td>
    <td class="tg-0lax"><?php echo $row->rekananshippping_line; ?></td>
    <td class="tg-0lax"><?php echo $row->rekananshipping_name; ?></td>
    <td class="tg-0lax"><?php echo $row->acc_id; ?></td>
    <td class="tg-0lax"><?php echo $row->acc_name; ?></td>
    <td class="tg-0lax"><?php echo $row->jurnal_bookdate; ?></td>
    <td class="tg-0lax"><?php echo $row->periode; ?></td>
    <td class="tg-0lax"><?php echo $row->duedate; ?></td>
    <td class="tg-0lax"><?php echo $row->due; ?></td>
    <td class="tg-0lax"><?php echo $row->Invoice_Amount; ?></td>
    <td class="tg-0lax"><?php echo $row->settlement_idr; ?></td>
    <td class="tg-0lax"><?php echo $row->receive_idr; ?></td>
    <td class="tg-0lax"><?php echo $row->Aging_Amount; ?></td>
    <td class="tg-0lax"><?php echo $row->ref_id; ?></td>
    <td class="tg-0lax"><?php echo $row->faktur_id; ?></td>
    <td class="tg-0lax"><?php echo $row->faktur_date; ?></td>
    <td class="tg-0lax"><?php echo $row->deduct_type; ?></td>
    <td class="tg-0lax"><?php echo $row->contract_no; ?></td>
    <td class="tg-0lax"><?php echo $row->transaksi_type; ?></td>
    <td class="tg-0lax"><?php echo $row->transaksi_trx; ?></td>
    <td class="tg-0lax"><?php echo $row->doc_type; ?></td>
    <td class="tg-0lax"><?php echo $row->grouptenant_id; ?></td>
    <td class="tg-0lax"><?php echo $row->InvoiceNumber; ?></td>
  </tr>
   <?php } } ?>
</tbody>
</table>


<script src="<?php echo base_url('assets/plugins/jquery.min.js');?>" type="text/javascript"></script> 
<script>		

		function doit(tableID, type, fn, sheetName, dl) {
				var elt = document.getElementById(tableID);
				var wb = XLSX.utils.table_to_book(elt, {sheet:sheetName});
				return dl ?
					XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
					XLSX.writeFile(wb, fn || ('DataExcel.' + (type || 'xlsx')));
			}
			
			$('#buttonExport').on('click', function(e){
					var table = $('.datadetil');
					var idtable = table.attr('id');
					doit(idtable, 'xlsx', idtable +'.xlsx', 'Report', 0);
				
			});
</script>