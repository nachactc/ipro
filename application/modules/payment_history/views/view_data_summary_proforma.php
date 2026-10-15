  <?php  
   if ($excel == 'summary2Excel')
  {
	 $vbrnch=str_replace(" ","",$branch_info->branch_name);
	 header("Content-type: application/vnd-ms-excel");
 
	 header("Content-Disposition: attachment; filename=PROFORMA_".$vbrnch.".xls");
	 
	 header("Pragma: no-cache");
	 
	 header("Expires: 0"); 
  } 
 ?>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-pfl3{font-weight:bold;font-size:12px;font-family:serif !important;;text-align:center;vertical-align:top}
.tg .tg-pyio{font-weight:bold;font-size:12px;font-family:serif !important;;text-align:center}
.tg .tg-9pvj{font-weight:bold;font-size:11px;text-align:right}
.tg .tg-lnuw{font-weight:bold;font-size:11px;text-align:right;vertical-align:top}
.tg .tg-lqy6{text-align:right;vertical-align:top}
.tg .tg-yw4l{vertical-align:top}
.tg .tg-nl5m{font-weight:bold;font-size:11px}
</style>
<?php echo ($branch_info != 'kosong') ? $branch_info->branch_name : $region_name; ?>
<br/>
 <?php echo ($branch_info != 'kosong') ? 'OPENING DATE '.date('d-M-Y',strtotime($branch_info->branch_openingdate)) : 'DATE '.date('d-M-Y'); ?>
<br/>
&nbsp;
<table border=1 class="tg" style="undefined;table-layout: fixed; width: 558px">
<colgroup>
<col style="width: 148px">
<col style="width: 66px">
<col style="width: 81px">
<col style="width: 60px">
<col style="width: 94px">
<col style="width: 109px">
</colgroup>
  <tr>
    <th class="tg-pyio" rowspan="2">CAT</th>
    <th class="tg-pyio">NLA</th>
    <th class="tg-pyio" colspan="2">OCC</th>
    <th class="tg-pfl3" colspan="2">PROFORMA</th>
  </tr>
  <tr>
    <td class="tg-pyio">(M2)</td>
    <td class="tg-pyio">(M2)</td>
    <td class="tg-pfl3">(%)</td>
    <td class="tg-pfl3">(RP/M2)</td>
    <td class="tg-pfl3">TOTAL(RP)</td>
  </tr>
  <!-- value -->
  <?php 
    $no = 1;
	$nla = 0;$tot_nla=0;$rental=0;$percent=0;$proforma=0;
	$occ = 0;$tot_occ=0;$tot_rental=0;$tot_percent=0;$tot_proforma=0;
	if ($tenant_history) :
	foreach ($tenant_history as $datas => $row) : 
	$nla =  $row->NLA; 
	$occ = $row->OCC; 
	$rental = $row->rental; 
	$percent =  round(($occ/$nla)*100);
	$proforma = $rental * $nla; 
  ?>
  <tr>
    <td class="tg-yw4l"><?php echo $no++.". ".$row->unittype_name ; ?></td>
    <td class="tg-lqy6"><?php echo number_format($nla);?></td>
    <td class="tg-lqy6"><?php echo number_format($occ);?></td>
    <td class="tg-lqy6"><?php echo $percent."%"; ?></td>
    <td class="tg-lqy6"><?php echo number_format($rental,2) ; ?></td>
    <td class="tg-lqy6"><?php echo number_format($proforma,2) ; ?></td>
  </tr>
  <?php 
	$tot_nla += $nla;$tot_occ += $occ;$tot_rental +=$rental;$tot_proforma +=$proforma;
	endforeach;  
	$tot_percent= round(($tot_occ/$tot_nla)*100);
 ?>
  <tr>
    <td class="tg-nl5m">TOTAL</td>
    <td class="tg-9pvj"><?php echo  number_format($tot_nla); ?></td>
    <td class="tg-9pvj"><?php echo  number_format($tot_occ); ?></td>
    <td class="tg-lnuw"><?php echo $tot_percent."%";?></td>
    <td class="tg-lnuw"><?php echo number_format($tot_rental,2);?></td>
    <td class="tg-lnuw"><?php echo number_format($tot_proforma,2)?></td>
  </tr>
  <?php 
	endif;
  ?>
  
  
  <!-- value -->
</table>