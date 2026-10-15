  <?php  
   if ($excel == 'summaryExcel')
  {
	 header("Cache-Control: no-store, no-cache, must-revalidate");
	 header("Cache-Control: post-check=0, pre-check=0", false);
	 header("Pragma: no-cache");
	 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	 header('Content-Type: application/vnd.ms-excel');  
	 header("Content-Disposition: attachment; filename=TB_".$branch_info->branch_name.".xls"); 
  }

 
 ?>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-rwj1{font-size:10px;font-family:Arial, Helvetica, sans-serif !important;;border-color:inherit;vertical-align:top}
.tg .tg-0ca7{font-size:10px;font-family:Arial, Helvetica, sans-serif !important;;border-color:inherit;text-align:center;vertical-align:top}
.head1{font-size:14px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
.head2{font-size:12px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
</style>
<table border=0 style="undefined;table-layout: fixed; width: 810px;">
<tr>
	<td class="head1"><b><?php echo ($branch_info != 'kosong') ? $branch_info->region_namereport : ''; ?></b></td>
	<td> &nbsp; </td> 
</tr>
<tr>
	<td> &nbsp; </td> 
	<td> &nbsp; </td> 
</tr>
<tr >
	<td class="head2"><b> LOI STATUS </b></td>
	<td class="head2" align="right"><b><?php echo ($branch_info != 'kosong') ? ' TENANT '.$branch_info->branch_name : $region_name; ?></b></td>
	 
</tr>  
<tr>
	<td class="head2"> UPDATE PER <?php echo date('d-M-Y'); ?></td> 
	<td class="head2" align="right">
		 <?php echo ($branch_info != 'kosong') ? 'OPENING DATE '.date('d-M-Y',strtotime($branch_info->branch_openingdate)) : 'DATE '.date('d-M-Y'); ?></b>
	</td>
	
</tr> 
</table>

<br />  
<table class="tg" style="undefined;table-layout: fixed; width: 808px">
<colgroup>
<col style="width: 135px">
<col style="width: 56px">
<col style="width: 42px">
<col style="width: 62px">
<col style="width: 38px">
<col style="width: 65px">
<col style="width: 78px">
<col style="width: 67px">
<col style="width: 62px">
<col style="width: 62px">
<col style="width: 62px">
<col style="width: 79px">
</colgroup>
  <tr>
    <th class="tg-rwj1"></th>
    <th class="tg-0ca7" colspan="4">NLA</th> 
  </tr>
  <tr>
    <td class="tg-0ca7">CATEGORY</td>
    <td class="tg-0ca7">TOTAL</td>
    <td class="tg-0ca7">OCC</td>
    <td class="tg-0ca7">UNDER <br>NEGO</td>
    <td class="tg-0ca7">VAC</td>
    <td class="tg-0ca7">TOTAL<br>TENANT</td> 
  </tr>
    
	<?php 
	if ($tenant_history) :
	//inisiasi variabel bel sedep
	$type 		='';
	$nla 		= 0;
	$occ 		= 0;
	$vac 		= 0;
	$noTenant	= 0;
	$area		= 0;
	$areaOcc 	= 0;
	$areaVcc 	= 0;
	$loiP 		= 0;
	$loiS 		= 0;
	$loiR 		= 0;
	$loiSi 		= 0;
	$laP 		= 0;
	$laR 		= 0;
	$laS 		= 0;
	$no			= 1;
	$tot_nla 	= 0;
	$tot_occ 	= 0;
	$tot_vac 	= 0;
	$tot_loiP 	= 0;
	$tot_loiNotSigned 	= 0;
	$tot_loiSi 	= 0;
	$tot_laS 	= 0;
	$tot_laNotSigned 	= 0;
	$tot_laNotProc 		= 0;
	
	foreach ($tenant_history as $datas => $row) : 
	
	  //value data isinyah
		if($row->agreementdetil_space != '')
		{ 
			$nla += 1; 
		} 
		if($row->rekananshipping_name != 'VACANT')
		{ 
			$occ += 1; 
		}
		if($row->rekananshipping_name == 'VACANT')
		{ 
			$vac += 1; 
		}
		 
	 
	//buat sub totalnyah
			
		
		 
		
				$tot_nla += $nla;
				$tot_occ += $occ;
				$tot_vac += $vac;
				$tot_loiP += $loiP;
				$tot_loiNotSigned += ($occ-$loiSi);
				$tot_loiSi += $loiSi;
				$tot_laS += $laS;
				$tot_laNotSigned += (($occ-$laS)-($occ-$laP));
				$tot_laNotProc += ($occ-$laP);
				
			
				echo '<tr>
				<td class="tg-rwj1">'.$no.'. '.$row->agreementdetil_unit.'</td>
				<td class="tg-rwj1" align="center">'.$nla.'</td>
				<td class="tg-rwj1" align="center">'.$occ.'</td>
				<td class="tg-rwj1" align="center">0</td>
				<td class="tg-rwj1" align="center">'.$vac.'</td>
				<td class="tg-rwj1" align="center">'.$occ.'</td> 
				</tr>'; 
				$no++;   	
				//inisiasi ulang, agar nilai menghitung sesuai kategori yang ditentukan ( per type unit )
			 
			 
			
		
	endforeach; 
	
	?>
	
	 <tr>
    <td class="tg-0ca7" rowspan="2"><br><br>TOTAL</td>
    <td class="tg-rwj1" align="center"><?php echo $tot_nla; ?></td>
    <td class="tg-rwj1" align="center"><?php echo $tot_occ; ?></td>
    <td class="tg-rwj1" align="center">0</td>
    <td class="tg-rwj1" align="center"><?php echo $tot_vac; ?></td>
    <td class="tg-rwj1" align="center"><?php echo $tot_occ; ?></td> 
  </tr>
  <tr>
    <td class="tg-rwj1" align="center">100%</td>
    <td class="tg-rwj1" align="center"><?php echo round(($tot_occ/$tot_nla)*100); ?>%</td>
    <td class="tg-rwj1" align="center"><?php echo round((0/$tot_nla)*100); ?>%</td>
    <td class="tg-rwj1" align="center"><?php echo round(($tot_vac/$tot_nla)*100); ?>%</td>
    <td class="tg-rwj1" align="center"><?php echo round(($tot_occ/$tot_nla)*100); ?>%</td> 
  </tr>
	<?php else: ?>
	<div class="alert alert-success fade in ">
	<a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
	<strong>Info!</strong> Belum Ada Data!
	</div>
	<?php endif; ?> 
  
</table>