<title> <?php echo  ($result != 'kosong') ? $title : 'External'; ?> </title>

<?php echo form_open(site_url('rpt_receipt/report_excel'),"target='_blank'"); ?>
	<button class="exportToExcel">Export to EXCEL</button>
<?php echo form_close(); ?>

 
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-6bfr{background-color:#9b9b9b;color:#000000;text-align:center;vertical-align:top}
.tg .tg-k3cl{background-color:#9b9b9b;color:#000000;text-align:left;vertical-align:top}
.tg .tg-lqy6{text-align:right;vertical-align:top}
.tg .tg-0lax{text-align:left;vertical-align:top}
</style>
<table class="tg" style="table-layout: fixed; width: 2194px">
<colgroup>
<col style="width: 115px">
<col style="width: 106px">
<col style="width: 116px">
<col style="width: 320px">
<col style="width: 143px">
<col style="width: 320px">
<col style="width: 228px">
<col style="width: 68px">
<col style="width: 80px">
<col style="width: 118px">
<col style="width: 300px">
<col style="width: 300px">
<col style="width: 180px">
<col style="width: 183px"> 
<col style="width: 63px"> 
<col style="width: 110px"> 
</colgroup>
  <tr>
    <th class="tg-k3cl">ID</th>
    <th class="tg-k3cl">Book Date</th>
    <th class="tg-k3cl">B.U</th>
    <th class="tg-k3cl">Store</th>
    <th class="tg-k3cl">Debtor</th>
    <th class="tg-k3cl">Tenant</th>
    <th class="tg-k3cl">Brand</th>
    <th class="tg-k3cl">Trx</th>
    <th class="tg-6bfr">IDR</th>
    <th class="tg-6bfr">IDR INVOICE</th>
    <th class="tg-k3cl">Journal Invoice</th>
    <th class="tg-k3cl">Invoice.ID</th>
    <th class="tg-k3cl">Invoice Date</th>
    <th class="tg-k3cl">Faktur</th>  
    <th class="tg-k3cl">TYPE</th>  
    <th class="tg-k3cl">Corporate</th>  
  </tr>
  <?php 
  $idr = 0; 
  $idrInv = 0; 
 
	if(($result != 'kosong')) :
	foreach($result as $row) :
  ?>
  <tr>
    <td class="tg-0lax"><?php echo $row->jurnal_id; ?></td>
    <td class="tg-0lax"><?php echo date('Y-m-d',strtotime($row->jurnal_bookdate)); ?></td>
    <td class="tg-0lax"><?php echo $row->region_name; ?></td>
    <td class="tg-0lax"><?php echo $row->branch_name; ?></td>
    <td class="tg-0lax"><?php echo $row->debtor_no; ?></td>
    <td class="tg-0lax"><?php echo $row->rekanan_name; ?></td>
    <td class="tg-0lax"><?php echo $row->rekananshipping_name; ?></td>
    <td class="tg-0lax"><?php echo $row->agreementtype_nameshort; ?></td>
    <td class="tg-0lax"><?php echo number_format($row->jurnaldetil_idr); ?></td>
    <td class="tg-0lax"><?php echo number_format($row->INV_IDR); ?></td>
    <td class="tg-0lax"><?php echo $row->invoice_jurnal; ?></td>
    <td class="tg-0lax"><?php echo $row->invoice_id; ?></td>
    <td class="tg-0lax"><?php echo date('Y-m-d',strtotime($row->invoice_date)); ?></td>
    <td class="tg-lqy6"><?php echo $row->faktur_id;?></td> 
    <td class="tg-lqy6"><?php echo $row->OR_TYPE;?></td> 
    <td class="tg-lqy6"><?php echo $row->c_status;?></td> 
  </tr>
  <?php 
  
	$idr = $row->jurnaldetil_idr  +  $idr ; 
	$idrInv = $row->INV_IDR  +  $idrInv ; 
	
    endforeach;
	endif;
  ?>
  <tr>
    <td class="tg-lqy6" colspan="8">Total</td>
    <td class="tg-lqy6" style="text-align:left;" ><?php echo number_format($idr); ?></td> 
    <td class="tg-lqy6" style="text-align:left;" ><?php echo number_format($idrInv); ?></td> 
    <td class="tg-lqy6" style="text-align:left;" colspan="5">&nbsp;</td> 
  </tr>
</table>

<?php if(($result != 'kosong')) : ?>
   
<?php endif;?>

   
 
<script>

 // $(function() {
				// $(".exportToExcel").click(function(e){ 
					// $(".table2excel").table2excel({
						// exclude: ".noExl", 
						// name: "EXTERNAL",
						// filename: "ExternalReport_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
						// preserveColors: false // set to true if you want background colors and font colors preserved
					// }); 
				// });
				
			// });
</script> 