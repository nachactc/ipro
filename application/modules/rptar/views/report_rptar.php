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
<table class="tg datadetil" id="report_ar" >
<thead>
  <tr>
    <th class="tg-0lax">jurnal_id</th>
    <th class="tg-0lax">jurnal_date</th>
    <th class="tg-0lax">periode</th>
    <th class="tg-0lax">jurnal_descr</th>
    <th class="tg-0lax">detil_descr</th>
    <th class="tg-0lax">amount</th>
    <th class="tg-0lax">Debet</th>
    <th class="tg-0lax">Kredit</th>
    <th class="tg-0lax">acc_id</th>
    <th class="tg-0lax">acc_name</th>
    <th class="tg-0lax">ref_id</th>
    <th class="tg-0lax">ref_line</th>
    <th class="tg-0lax">InvoiceNumber</th>
    <th class="tg-0lax">InvoiceID</th>
    <th class="tg-0lax">TenantGroup</th>
    <th class="tg-0lax">region_name</th>
    <th class="tg-0lax">branch_name</th>
    <th class="tg-0lax">branch_idlok</th>
    <th class="tg-0lax">rekanan_name</th>
    <th class="tg-0lax">rekananshipping_name</th>
    <th class="tg-0lax">jurnal_source</th>
    <th class="tg-0lax">debtor_no</th>
    <th class="tg-0lax">trx_name</th>
    <th class="tg-0lax">trx_ref</th>
  </tr>
</thead>
<tbody>
	<?php 
		//echo var_dump($result);exit;
		if (!empty($result)) {
		foreach($result as $row){	
	?>
  <tr>
    <td class="tg-0lax"><?php echo $row->jurnal_id; ?></td>
    <td class="tg-0lax"><?php echo $row->jurnal_date; ?></td>
    <td class="tg-0lax"><?php echo $row->periode; ?></td>
    <td class="tg-0lax"><?php echo $row->jurnal_descr; ?></td>
    <td class="tg-0lax"><?php echo $row->detil_descr; ?></td>
    <td class="tg-0lax"><?php echo $row->amount; ?></td>
    <td class="tg-0lax"><?php echo $row->Debet; ?></td>
    <td class="tg-0lax"><?php echo $row->Kredit; ?></td>
    <td class="tg-0lax"><?php echo $row->acc_id; ?></td>
    <td class="tg-0lax"><?php echo $row->acc_name; ?></td>
    <td class="tg-0lax"><?php echo $row->ref_id; ?></td>
    <td class="tg-0lax"><?php echo $row->ref_line; ?></td>
    <td class="tg-0lax"><?php echo $row->InvoiceNumber; ?></td>
    <td class="tg-0lax"><?php echo $row->InvoiceID; ?></td>
    <td class="tg-0lax"><?php echo $row->TenantGroup; ?></td>
    <td class="tg-0lax"><?php echo $row->region_name; ?></td>
    <td class="tg-0lax"><?php echo $row->branch_name; ?></td>
    <td class="tg-0lax"><?php echo $row->branch_idlok; ?></td>
    <td class="tg-0lax"><?php echo $row->rekanan_name; ?></td>
    <td class="tg-0lax"><?php echo $row->rekananshipping_name; ?></td>
    <td class="tg-0lax"><?php echo $row->jurnal_source; ?></td>
    <td class="tg-0lax"><?php echo $row->debtor_no; ?></td>
    <td class="tg-0lax"><?php echo $row->transaksi_trx; ?></td>
    <td class="tg-0lax"><?php echo $row->trx2; ?></td>
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