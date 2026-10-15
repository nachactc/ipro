<?php  
  if ($excel == 'detailExcelTB')
  {
	  header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header('Content-Type: application/vnd.ms-excel');  
	header("Content-Disposition: attachment; filename=Detil_TB_.xls");  
  } 
 ?>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-0rzf{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-ldj7{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:#000000;text-align:center;vertical-align:top}
.tg .tg-iuhm{font-size:10px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top;}
.tg .tg-73lx{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:#000000;vertical-align:top}
.tg .tg-ur0i{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;text-align:center;vertical-align:top}
.tg .tg-vbnk{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;vertical-align:top}
.tg .tg-li00{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;background-color:#ffffff;border-color:#000000;text-align:center;vertical-align:top}
.head1{font-size:14px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
.head2{font-size:12px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
</style>

<span class="head1">
	<b><?php echo ($branch_info != 'kosong') ? $branch_info->region_namereport : ''; ?></b>
</span>
<br />
<br />
<span class="head2">
<b>DATA  <?php echo ($branch_info != 'kosong') ? ' TENANT '.$branch_info->branch_name : $region_name; ?>
<br />
 <?php echo ($branch_info != 'kosong') ? 'OPENING DATE '.date('d-M-Y',strtotime($branch_info->branch_openingdate)) : 'DATE '.date('d-M-Y'); ?></b>
</span>
<br />
<br />
<table class="tg" style="undefined;table-layout: fixed; width: 1732px">
<colgroup>
<col style="width: 40px">
<col style="width: 45px">
<col style="width: 41px">
<col style="width: 54px">
<col style="width: 68px">
<col style="width: 167px">
<col style="width: 69px">
<col style="width: 51px">
<col style="width: 44px">
<col style="width: 49px">
<col style="width: 106px">
<col style="width: 122px">
<col style="width: 102px">
<col style="width: 102px">
<col style="width: 92px">
<col style="width: 97px">
<col style="width: 83px">
<col style="width: 126px">
<col style="width: 100px">
<col style="width: 90px">
<col style="width: 98px">
<col style="width: 82px">
</colgroup>
  <tr>
    <th class="tg-0rzf" colspan="4">#</th>
    <th class="tg-ur0i"><br>NO OF<br>TENANT</th>
    <th class="tg-0rzf" ><br>TENANT</th>
    <th class="tg-vbnk"><br>UNIT NO</th>
    <th class="tg-ur0i"><br>AREA<br>(M2)</th>
    <th class="tg-73lx" colspan="2">AREA (M2)</th>
    <th class="tg-ur0i"><br>RENTAL (RP/M2)</th>
    <th class="tg-ur0i"><br>SERVICE CHARGE<br>(RP/M2)</th>
    <th class="tg-ur0i"><br>MASA SEWA<br><br>(BULAN)</th>
    <th class="tg-ur0i" colspan="2"><br>PERIODE SEWA</th>
   
  </tr>
  <tr>
    <td class="tg-li00">NLA</td>
    <td class="tg-0rzf">OCC</td>
    <td class="tg-0rzf">VAC</td>
    <td class="tg-0rzf">NEGO</td>
    <td class="tg-vbnk"></td>
    <td class="tg-vbnk"></td>
    <td class="tg-vbnk"></td>
    <td class="tg-vbnk"></td>
    <td class="tg-ldj7">OCC</td>
    <td class="tg-ur0i">VAC</td>
    <td class="tg-vbnk"></td>
    <td class="tg-vbnk"></td>
    <td class="tg-ur0i"></td>
    <td class="tg-ur0i">RCD</td>
    <td class="tg-ur0i">LED</td> 
  
  </tr>
  
	<?php if ($tenant_history) : ?>  
	<?php 
	//inisiasi variabel bel sedep
	$type 		='';
	$Branch 		='';
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
	
	foreach ($tenant_history as $datas => $row) : ?>
		 
		<?php 
		    
				 //buat header
				  if($branch_info == 'kosong')
				  {
					if($Branch != $row->branch_name ){  
						echo "<tr><td class='tg-iuhm' colspan='22'>".$row->branch_name."</td></tr>";
					}  
				  }
				  
		  //value data isinyah
		  ?>
		<tr>
			<td class="tg-iuhm" align="center">
			<?php   
				if($row->agreementdetil_space != '')
				{
					echo 1;
					$nla += 1; 
				}
				else
				{
					echo 0;
				}
			?>
			</td>
			<td class="tg-iuhm" align="center">
			<?php  
				if($row->rekananshipping_name != 'VACANT')
				{
					echo 1;
					$occ += 1; 
				}
				else
				{
					echo 0;
				}
			?></td>
			<td class="tg-iuhm" align="center">
			<?php  
				if($row->rekananshipping_name == 'VACANT')
				{
					echo 1;
					$vac += 1; 
				}
				else
				{
					echo 0;
				}
			?></td>
			<td class="tg-iuhm" align="center">0</td>
			<td class="tg-iuhm" align="center">
			<?php  
				if($row->rekananshipping_name != 'VACANT')
				{
					echo 1;
					$noTenant += 1; 
				}
				else
				{
					echo 0;
				}
			?> 
			</td>
			<td class="tg-iuhm"><?php echo $row->rekananshipping_name;?></td>
			<td class="tg-iuhm"><?php echo $row->agreementdetil_unit. ' ' .$row->agreementdetil_unitspot;?></td>
			<td class="tg-iuhm"><?php $area += $row->agreementdetil_space ; echo $row->agreementdetil_space;?></td>
			<td class="tg-iuhm">
			<?php 
			if($row->rekananshipping_name != 'VACANT')
			{
				echo $row->agreementdetil_space ;
				$areaOcc += $row->agreementdetil_space; 
			}
			else
			{
				echo 0;
			}
			?></td>
			<td class="tg-iuhm">
			<?php if($row->rekananshipping_name == 'VACANT')
			{
				echo $row->agreementdetil_space ;
				$areaVcc += $row->agreementdetil_space; 
			}
			else
			{
				echo 0;
			}
			?></td>
			<td class="tg-iuhm"><?php echo is_numeric($row->rental) ? number_format($row->rental,2) :$row->rental ;?></td>
			<td class="tg-iuhm"><?php echo is_numeric($row->service_charge) ? number_format($row->service_charge,2) : $row->service_charge;?></td>
			<td class="tg-iuhm" align="center"><?php echo $row->agreement_term;?></td>
			<td class="tg-iuhm"><?php  echo $row->rekananshipping_name != 'VACANT' ? date('d-M-Y',strtotime($row->RCD)) : '-'; ?>
			</td>
			<td class="tg-iuhm"><?php echo $row->rekananshipping_name != 'VACANT' ? date('d-M-Y',strtotime($row->LCD)) : '-';?></td>
			 
		</tr> 
		
		 
		 
	
	
	<?php	
		//inisiasi ulang, agar nilai menghitung sesuai kategori yang ditentukan ( per type unit )
		// $nla 		= 0;
		// $occ 		= 0;
		// $vac 		= 0;
		// $noTenant	= 0;
		// $area		= 0;
		// $areaOcc 	= 0;
		// $areaVcc 	= 0;
		// $loiP 		= 0;
		// $loiS 		= 0;
		// $loiR 		= 0;
		// $loiSi 		= 0;
		// $laP 		= 0;
		// $laR 		= 0;
		// $laS 		= 0;
	 
	 
	$Branch = $row->branch_name; 
	endforeach; ?>
	<tr>
			<td class="tg-iuhm" align="center"><?php echo $nla; ?></td>
			<td class="tg-iuhm" align="center"><?php echo $occ; ?></td>
			<td class="tg-iuhm" align="center"><?php echo $vac; ?></td>
			<td class="tg-iuhm" align="center">0</td>
			<td class="tg-iuhm" align="center"><?php echo $noTenant; ?></td>
			<td class="tg-iuhm">TOTAL</td>
			<td class="tg-iuhm"></td>
			<td class="tg-iuhm" align="center"><?php echo number_format((float)$area, 2, '.', '');  ; ?></td>
			<td class="tg-iuhm" align="center"><?php echo number_format((float)$areaOcc, 2, '.', '');  ; ?></td>
			<td class="tg-iuhm" align="center"><?php echo number_format((float)$areaVcc, 2, '.', '');  ; ?></td>
			<td class="tg-iuhm"></td>
			<td class="tg-iuhm"></td>
			<td class="tg-iuhm"></td>
			<td class="tg-iuhm"></td>
			<td class="tg-iuhm"></td> 
		</tr>
	<?php else: ?>
	<div class="alert alert-success fade in ">
	<a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
	<strong>Info!</strong> Belum Ada Data!
	</div>
	<?php endif; ?> 
  
</table>