 <?php  
  if ($excel == 'detailExcel')
  {
	 $vbrnch=str_replace(" ","",$branch_info->branch_name);
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename=INV_".$vbrnch.".xls");
  } 
 ?>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-cpu2{border-color:#000000;vertical-align:top}
.tg .tg-obcv{border-color:#000000;text-align:center}
.tg .tg-wp8o{border-color:#000000;text-align:center;vertical-align:top}
.tg .tg-gcw3{border-color:#000000}
</style>
<table class="tg" style="undefined;table-layout: fixed; width: 1341px">
<colgroup>
<col style="width: 64px">
<col style="width: 201px">
<col style="width: 140px">
<col style="width: 46px">
<col style="width: 89px">
<col style="width: 88px">
<col style="width: 93px">
<col style="width: 87px">
<col style="width: 44px">
<col style="width: 83px">
<col style="width: 87px">
<col style="width: 87px">
<col style="width: 87px">
<col style="width: 87px">
<col style="width: 117px">
</colgroup>
  <tr>
    <th class="tg-cpu2" rowspan="3"><br><br><br>BRAND</th>
    <th class="tg-wp8o" rowspan="3"><br><br><br>INVOICE ID</th>
    <th class="tg-wp8o" rowspan="3"><br><br><br>JURNAL ID</th>
    <th class="tg-wp8o" colspan="7">INVOICE STATUS</th>
    <th class="tg-obcv" colspan="5">PAYMENT STATUS</th>
  </tr>
  <tr>
    <td class="tg-wp8o" colspan="5">DP</td>
    <td class="tg-wp8o" colspan="2" rowspan="2"><br><br>SECDEP</td>
    <td class="tg-obcv" colspan="4">DP</td>
    <td class="tg-wp8o" rowspan="2"><br><br>SECDEP</td>
  </tr>
  <tr>
    <td class="tg-cpu2">NO</td>
    <td class="tg-obcv">5%</td>
    <td class="tg-obcv">10%</td>
    <td class="tg-obcv">15%</td>
    <td class="tg-obcv">20%</td>
    <td class="tg-obcv">5%</td>
    <td class="tg-wp8o">10%</td>
    <td class="tg-wp8o">15%</td>
    <td class="tg-wp8o">20%</td>
  </tr>
  <?php if ($tenant_history) :  
	 
	
	foreach ($tenant_history as $datas) :
	?> 
	<tr>
		<td class="tg-cpu2"><?php echo $datas->rekananshipping_name;?></td>
		<td class="tg-wp8o"><?php echo $datas->invoice_id;?></td>
		<td class="tg-wp8o"><?php echo $datas->jurnal_id;?></td>
		<td class="tg-cpu2"><?php echo ($datas->schedulepaymentdetil_percentdp == '') ? 'No.DP' : '-' ;?></td>
		<td class="tg-gcw3"><?php echo ($datas->P_5) ?></td>
		<td class="tg-gcw3"><?php echo ($datas->P_10) ?></td>
		<td class="tg-gcw3"><?php echo ($datas->P_15) ?></td>
		<td class="tg-gcw3"><?php echo ($datas->P_20) ?></td>
		<td class="tg-cpu2" colspan="2"><?php echo ($datas->SD) ?></td>
		<td class="tg-gcw3"><?php echo ($datas->P1_5) ?></td>
		<td class="tg-cpu2"><?php echo ($datas->P1_10) ?></td>
		<td class="tg-cpu2"><?php echo ($datas->P1_15) ?></td>
		<td class="tg-cpu2"><?php echo ($datas->P1_20) ?></td>
		<td class="tg-cpu2"><?php echo ($datas->SD_PY) ?></td>
    </tr>
	 
    
  <?php  endforeach; else: ?>
	<div class="alert alert-success fade in ">
	<a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
	<strong>Info!</strong> Belum Ada Data!
	</div>
	<?php endif; ?> 
	
</table>