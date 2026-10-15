<title> <?php echo  ($result != 'kosong') ? $title : 'External'; ?> </title>

<?php echo form_open(site_url('rpt_external/report_excel'),"target='_blank'"); ?>
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
<table class="tg table2excel" style="table-layout: fixed; width: 2194px">
<colgroup>
<col style="width: 91px">
<col style="width: 106px">
<col style="width: 116px">
<col style="width: 320px">
<col style="width: 143px">
<col style="width: 91px">
<col style="width: 320px">
<col style="width: 228px">
<col style="width: 128px">
<col style="width: 118px">
<col style="width: 228px">
<col style="width: 220px">
<col style="width: 80px">
<col style="width: 300px">
<col style="width: 180px">
<col style="width: 183px">
<col style="width: 168px">
<col style="width: 133px">
<col style="width: 133px">
</colgroup>
  <tr>
    <th class="tg-k3cl">Entitiy Cd</th>
    <th class="tg-k3cl">Entity Name</th>
    <th class="tg-k3cl">A/c Code</th>
    <th class="tg-k3cl">Description</th>
    <th class="tg-k3cl">Debtor</th>
    <th class="tg-k3cl">NLA</th>
    <th class="tg-k3cl">Name</th>
    <th class="tg-k3cl">Brand</th>
    <th class="tg-k3cl">Financial Period</th>
    <th class="tg-k3cl">Journal Date</th>
    <th class="tg-k3cl">Journal No</th>
    <th class="tg-k3cl">Reference</th>
    <th class="tg-k3cl">Reference Ln.</th>
    <th class="tg-k3cl">Trx Description</th>
    <th class="tg-k3cl">Tax Invoice No</th>
    <th class="tg-k3cl">Invoice No</th>
    <th class="tg-6bfr">Debit</th>
    <th class="tg-6bfr">Credit</th>
    <th class="tg-6bfr">Balance</th>
  </tr>
  <?php 
  $debit = 0;
  $credit = 0;
  $balance = 0;
 
	if(($result != 'kosong')) :
	foreach($result as $row) :
  ?>
  <tr>
    <td class="tg-0lax"><?php echo $row->branch_code; ?></td>
    <td class="tg-0lax"><?php echo $row->branch_name; ?></td>
    <td class="tg-0lax"><?php echo $row->acc_id; ?></td>
    <td class="tg-0lax"><?php echo $row->jurnal_descr; ?></td>
    <td class="tg-0lax"><?php echo $row->debtorname; ?></td>
    <td class="tg-0lax"><?php echo $row->nla ? $row->nla : '-'; ?></td>
    <td class="tg-0lax"><?php echo $row->rekanan_name; ?></td>
    <td class="tg-0lax"><?php echo $row->rekananshipping_name; ?></td>
    <td class="tg-0lax"><?php echo $row->periode_id; ?></td>
    <td class="tg-0lax"><?php echo date('Y-m-d',strtotime($row->jurnal_bookdate)); ?></td>
    <td class="tg-0lax"><?php echo $row->jurnal_id; ?></td>
    <td class="tg-0lax"><?php echo $row->ref_id; ?></td>
    <td class="tg-0lax"><?php echo $row->ref_line; ?></td>
    <td class="tg-0lax"><?php echo $row->jurnaldetil_descr; ?></td>
    <td class="tg-0lax"><?php echo $row->faktur_id; ?></td>
    <td class="tg-0lax"><?php echo $row->invoice_id; ?></td>
    <td class="tg-lqy6"><?php echo ($row->jurnaldetil_idr > 0) ? number_format($row->jurnaldetil_idr) : 0;?></td>
    <td class="tg-lqy6"><?php echo ($row->jurnaldetil_idr < 0) ? number_format($row->jurnaldetil_idr) : 0;?></td>
    <td class="tg-lqy6"><?php echo number_format($row->jurnaldetil_idr); ?></td>
  </tr>
  <?php 
  
	$debit = (($row->jurnaldetil_idr > 0) ? $row->jurnaldetil_idr : 0) +  $debit ;
	$credit = (($row->jurnaldetil_idr < 0) ? $row->jurnaldetil_idr : 0) + $credit;
	$balance = $debit + $credit;
	
    endforeach;
	endif;
  ?>
  <tr>
    <td class="tg-lqy6" colspan="16">Total</td>
    <td class="tg-lqy6"><?php echo number_format($debit); ?></td>
    <td class="tg-lqy6"><?php echo number_format($credit); ?></td>
    <td class="tg-lqy6"><?php echo number_format($balance); ?></td>
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