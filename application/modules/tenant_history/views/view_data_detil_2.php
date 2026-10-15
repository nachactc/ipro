  <?php 
 // header("Content-type: application/vnd-ms-excel");
 
 // header("Content-Disposition: attachment; filename=".$branch_info->branch_name.".xls");
 
 // header("Pragma: no-cache");
 
 // header("Expires: 0");
 
 ?>

<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-0rzf{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-ldj7{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:#000000;text-align:center;vertical-align:top}
.tg .tg-iuhm{font-size:10px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
.tg .tg-73lx{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:#000000;vertical-align:top}
.tg .tg-ur0i{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;text-align:center;vertical-align:top}
.tg .tg-vbnk{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;vertical-align:top}
.tg .tg-li00{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;background-color:#ffffff;border-color:#000000;text-align:center;vertical-align:top}
.head1{font-size:14px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
.head2{font-size:12px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
</style>


<span class="head1">
	<b><?php echo $branch_info->region_namereport; ?></b>
</span>
<br />
<br />
<span class="head2">
<b>DATA TENANT <?php echo $branch_info->branch_name; ?>
<br />
OPENING DATE <?php echo date('d-M-Y',strtotime($branch_info->branch_openingdate)); ?></b>
</span>
<br />
<br />
<table class="tg" style="undefined;table-layout: fixed; width: 1732px">
<colgroup>
<col style="width: 39px">
<col style="width: 44px">
<col style="width: 40px">
<col style="width: 53px">
<col style="width: 67px">
<col style="width: 88px">
<col style="width: 68px">
<col style="width: 50px">
<col style="width: 44px">
<col style="width: 49px">
<col style="width: 105px">
<col style="width: 121px">
<col style="width: 101px">
<col style="width: 101px">
<col style="width: 91px">
<col style="width: 96px">
<col style="width: 83px">
<col style="width: 125px">
<col style="width: 99px">
<col style="width: 89px">
<col style="width: 97px">
<col style="width: 82px">
</colgroup>
  <tr>
    <th class="tg-0rzf" colspan="4">#</th>
    <th class="tg-ur0i"><br>NO OF<br>TENANT</th>
    <th class="tg-ur0i"><br>TENANT</th>
    <th class="tg-vbnk"><br>UNIT NO</th>
    <th class="tg-ur0i"><br>AREA<br>(M2)</th>
    <th class="tg-73lx" colspan="2">AREA (M2)</th>
    <th class="tg-ur0i"><br>RENTAL (RP/M2)</th>
    <th class="tg-ur0i"><br>SERVICE CHARGE<br>(RP/M2)</th>
    <th class="tg-ur0i"><br>MASA SEWA<br><br>(BULAN)</th>
    <th class="tg-ur0i" colspan="2"><br>PERIODE SEWA</th>
    <th class="tg-ur0i"><br>LOI <br>PROSES</th>
    <th class="tg-ur0i"><br><br>LOI SENT</th>
    <th class="tg-ur0i">LOI RECEIVED<br><br>(Sign By Tenant)</th>
    <th class="tg-ur0i"><br>LOI <br>SIGN</th>
    <th class="tg-ur0i" colspan="3"><br>LEASE AGREEMENT</th>
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
    <td class="tg-vbnk"></td>
    <td class="tg-vbnk"></td>
    <td class="tg-vbnk"></td>
    <td class="tg-vbnk"></td>
    <td class="tg-ur0i">PROCESS</td>
    <td class="tg-ur0i">RECEIVED</td>
    <td class="tg-ur0i">SIGN</td>
  </tr>
  
	<?php if ($tenant_history) : ?>  
	<?php 
	$type 	='';
	$nla 	= 0;
	$occ 	= 0;
	$vac 	= 0;
	$noTenant	= 0;
	$area	= 0;
	$areaOcc = 0;
	$areaVcc = 0;
	
	foreach ($tenant_history as $datas) : ?>
		<?php 
		  if($type != $datas->unittype_name){   
			  echo "<tr><td class='tg-iuhm' colspan='22'>".$datas->unittype_name."</td></tr>"; 
		  } 
		  ?>
		<tr>
			<td class="tg-iuhm" align="center">
			<?php   
				if($datas->agreementdetil_space != '')
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
				if($datas->rekananshipping_name != 'VACANT')
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
				if($datas->rekananshipping_name == 'VACANT')
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
				if($datas->rekananshipping_name != 'VACANT')
				{
					echo 1;
					$noTenant += 1; 
				}
				else
				{
					echo 0;
				}
			?> </td>
			<td class="tg-iuhm"><?php echo $datas->rekananshipping_name;?></td>
			<td class="tg-iuhm"><?php echo $datas->unit_name;?></td>
			<td class="tg-iuhm"><?php echo $datas->agreementdetil_space;?></td>
			<td class="tg-iuhm"><?php echo $datas->rekananshipping_name != 'VACANT' ? $datas->agreementdetil_space : 0 ; ?></td>
			<td class="tg-iuhm"><?php echo $datas->rekananshipping_name == 'VACANT' ? $datas->agreementdetil_space : 0 ; ?></td>
			<td class="tg-iuhm"><?php echo number_format($datas->rental,2);?></td>
			<td class="tg-iuhm"><?php echo number_format($datas->service_charge,2);?></td>
			<td class="tg-iuhm" align="center"><?php echo $datas->agreement_term;?></td>
			<td class="tg-iuhm"><?php echo $datas->rekananshipping_name != 'VACANT' ? date('d-M-Y',strtotime($datas->RCD)) : '-';?></td>
			<td class="tg-iuhm"><?php echo $datas->rekananshipping_name != 'VACANT' ? date('d-M-Y',strtotime($datas->LCD)) : '-';?></td>
			<td class="tg-iuhm"><?php echo date('d-M-Y',strtotime($datas->loi_processdate)) != '01-Jan-1970' ? date('d-M-Y',strtotime($datas->loi_processdate)) : '-' ;?></td>
			<td class="tg-iuhm"><?php echo date('d-M-Y',strtotime($datas->loi_sentdate)) != '01-Jan-1970' ? date('d-M-Y',strtotime($datas->loi_sentdate)) : '-' ;?></td>
			<td class="tg-iuhm"><?php echo date('d-M-Y',strtotime($datas->loi_receivedate)) != '01-Jan-1970' ? date('d-M-Y',strtotime($datas->loi_receivedate)) : '-' ;?></td>
			<td class="tg-iuhm"><?php echo date('d-M-Y',strtotime($datas->loi_signeddate)) != '01-Jan-1970' ? date('d-M-Y',strtotime($datas->loi_signeddate)) : '-' ;?></td>
			<td class="tg-iuhm"><?php echo date('d-M-Y',strtotime($datas->la_proceeddate)) != '01-Jan-1970' ? date('d-M-Y',strtotime($datas->la_proceeddate)) : '-' ;?></td>
			<td class="tg-iuhm"><?php echo date('d-M-Y',strtotime($datas->la_receiveddate)) != '01-Jan-1970' ? date('d-M-Y',strtotime($datas->la_receiveddate)) : '-' ;?></td>
			<td class="tg-iuhm"><?php echo date('d-M-Y',strtotime($datas->la_signdate)) != '01-Jan-1970' ? date('d-M-Y',strtotime($datas->la_signdate)) : '-' ;?></td>
		</tr> 
		
		 
		
	<?php $type = $datas->unittype_name; endforeach; ?>
	<tr>
			<td class="tg-iuhm"><?php echo $nla; ?></td>
			<td class="tg-iuhm"><?php echo $occ; ?></td>
			<td class="tg-iuhm"><?php echo $vac; ?></td>
			<td class="tg-iuhm">0</td>
			<td class="tg-iuhm"><?php echo $noTenant; ?></td>
			<td class="tg-iuhm">TOTAL</td>
			<td class="tg-iuhm"></td>
			<td class="tg-iuhm">tot_area</td>
			<td class="tg-iuhm">occ</td>
			<td class="tg-iuhm">vac</td>
			<td class="tg-iuhm"></td>
			<td class="tg-iuhm"></td>
			<td class="tg-iuhm"></td>
			<td class="tg-iuhm"></td>
			<td class="tg-iuhm"></td>
			<td class="tg-iuhm">tot_loiP</td>
			<td class="tg-iuhm">tot_loiS</td>
			<td class="tg-iuhm">tot_loiR</td>
			<td class="tg-iuhm">tot_loiSI</td>
			<td class="tg-iuhm">tot_laP</td>
			<td class="tg-iuhm">tot_laR</td>
			<td class="tg-iuhm">tot_laS</td>
		</tr>
	<?php else: ?>
	<div class="alert alert-success fade in ">
	<a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
	<strong>Info!</strong> Belum Ada Data!
	</div>
	<?php endif; ?> 
  
</table>