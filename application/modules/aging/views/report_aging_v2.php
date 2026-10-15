<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-cly1{text-align:left;vertical-align:middle}
.tg .tg-mwxe{text-align:right;vertical-align:middle}
</style>

<script src="<?php echo base_url('assets/plugins/jquery.min.js');?>" type="text/javascript"></script> 
<script src="<?php echo base_url()."assets/plugins/exportexcel/table2excel/" ?>jquery.table2excel.js"></script> 
<button class="exportToExcel noExl">Export to EXCEL</button> 
<br><br>
 
<table class="table2excel tg" style="undefined;table-layout: fixed; width: 2491px">
<colgroup>
<col style="width: 180px">
<col style="width: 221px">
<col style="width: 112px">
<col style="width: 122px">
<col style="width: 137px">
<col style="width: 160px">
<col style="width: 121px">
<col style="width: 124px">
<col style="width: 191px">
<col style="width: 264px">
<col style="width: 135px">
<col style="width: 135px">
<col style="width: 135px">
<col style="width: 86px">
<col style="width: 180px">
<col style="width: 147px">
<col style="width: 66px">
<col style="width: 180px">
<col style="width: 180px">

</colgroup>
  <tr>
    <th class="tg-cly1">B.unit</th>
    <th class="tg-cly1">Store</th>
    <th class="tg-cly1">Store Lok.</th>
    <th class="tg-cly1">Tenant</th>
    <th class="tg-cly1">Brand</th>
    <th class="tg-cly1">Jurnal ID</th>
    <th class="tg-cly1">Date</th>
    <th class="tg-cly1">Periode</th>
    <th class="tg-cly1">Descr</th>
    <th class="tg-cly1">Detil Descr</th>
    <th class="tg-cly1">Amount</th>
    <th class="tg-cly1">Debet</th>
    <th class="tg-cly1">Kredit</th>
    <th class="tg-cly1">Acc</th>
    <th class="tg-cly1">Acc Name</th>
    <th class="tg-cly1">Ref ID</th>
    <th class="tg-cly1">Ref Ln.</th>
    <th class="tg-cly1">Invoice Number</th>
    <th class="tg-cly1">Invoice ID</th>
  </tr>
  <?php
    $amount = 0;
    $d = 0;
    $k = 0;
	if($result!='kosong'):
	foreach($result as $data):
  ?>
  <tr>
	<td class="tg-cly1"><?php echo $data->region_name ; ?></td>
    <td class="tg-cly1"><?php echo $data->branch_name ; ?></td>
    <td class="tg-cly1"><?php echo $data->branch_idlok ; ?></td>
    <td class="tg-cly1"><?php echo $data->rekanan_name ; ?></td>
    <td class="tg-cly1"><?php echo $data->rekananshipping_name ; ?></td>
    <td class="tg-cly1"><?php echo $data->jurnal_id ; ?></td>
    <td class="tg-cly1"><?php echo date('d-m-Y',strtotime($data->jurnal_date)); ?></td>
    <td class="tg-cly1"><?php echo $data->periode ; ?></td>
    <td class="tg-cly1"><?php echo $data->jurnal_descr ; ?></td>
    <td class="tg-cly1"><?php echo $data->detil_descr ; ?></td>
    <td class="tg-mwxe"><?php echo number_format($data->amount); ?></td>
    <td class="tg-mwxe"><?php echo number_format($data->Debet); ?></td>
    <td class="tg-mwxe"><?php echo number_format($data->Kredit); ?></td>
    <td class="tg-cly1"><?php echo $data->acc_id ; ?></td>
    <td class="tg-cly1"><?php echo $data->acc_name ; ?></td>
    <td class="tg-cly1"><?php echo $data->ref_id ; ?></td>
    <td class="tg-cly1"><?php echo $data->ref_line ; ?></td>
    <td class="tg-cly1"><?php echo $data->InvoiceNumber ; ?></td>
    <td class="tg-cly1"><?php echo $data->InvoiceID ; ?></td> 
  </tr>
  <?php
	$amount = $amount + ($data->amount);
	$d = $d + ($data->Debet);
	$k = $k + ($data->Kredit);
	endforeach;
	endif;
  ?>
   <!--<tr>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-mwxe">TOTAL</td>
    <td class="tg-mwxe"><?php //echo number_format($amount); ?></td>
    <td class="tg-mwxe"><?php //echo number_format($d); ?></td>
    <td class="tg-mwxe"><?php //echo number_format($k); ?></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
  </tr>-->
</table>


<script src="<?php echo base_url()."assets/plugins/exportexcel/" ?>FileSaver.js"></script> 
<script> 
 $(function() {
				$(".exportToExcel").click(function(e){ 
					$(".table2excel").table2excel({
						exclude: ".noExl", 
						name: "Rpt_AgingV2",
						filename: "Rpt_AgingV2_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
						preserveColors: false // set to true if you want background colors and font colors preserved
					}); 
				});
				
			});
</script> 