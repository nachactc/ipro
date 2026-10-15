<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
@font-face {
    font-family: 'arial'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/arial.ttf');?>'); /*URL to font*/
	src: url('<?php echo base_url('assets/css/loo/arialbd.ttf');?>'); /*URL to font*/
}
body {font-family: 'arial';font-size: 11pt}
@page { margin-left:3.5cm; margin-right:3cm; margin-top:3cm;margin-bottom:0.5cm;size:8.27in 11.69in;}
table, tr, td {
  font-family: 'arial';font-size: 11pt;
}

</style>
</head>
<body>
<?php 
 
  if(isset($result)){
	  $pasunitname = '';
	  $pasunitsqm = 0;
	  foreach($vunit as $rowunit){ 
	  		$pasunitname .= $rowunit->unit_name. '&'; 
			$pasunitsqm =$rowunit->unit_sqm+$pasunitsqm; 
			

	  }}
	  $vunitname = trim($pasunitname, "&");
	  $vunitsqm =$pasunitsqm;
   
 if(isset($result)){
foreach($result as $row){ ?>  
<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td width="74">&nbsp;</td>
    <td width="379" align="right">&nbsp;</td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td align="right"><b>PRIVATE & CONFIDENTIAL</b></td>
  </tr>
  <tr>
    <td align="right"><?php echo $row->rekananshipping_name;?>#<?php echo $vunitname;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b><?php echo $row->rekanancontact_name;?></b></td>
  </tr>

  <tr>
    <td ><b><?php 
	$rkn=substr($row->rekanan_name,0,2);
	$rkn=strtoupper($rkn);
	echo $row->rekanan_name;
	/*if ( (trim($rkn)=='PT') or (trim($rkn)=='CV') ){
			echo $row->rekanan_name;
	}else{
			echo $row->rekananshipping_name;
	}*/
	?></b></td>
  </tr>
  <tr>
    <td ><b><?php echo $row->rekanan_address;?></b></td>
  </tr>
  <tr>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td ><?php echo $new_date = date('d F Y', strtotime($row->loo_date));?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>Dear  <?php echo $row->rekanancontact_name;?></b></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>TRANS  STUDIO MALL CIBUBUR</strong></td>
  </tr>
  <tr>
    <td align="center"><strong>Shop Units #<?php echo $vunitname;?>, <?php echo $row->lantai_name;?></strong></td>
  </tr>
  <tr>
    <td align="center">Letter of Offer – Subject to Contract</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="33" align="justify" valign="top">Thank you for your interest in leasing a unit in Trans Studio Mall Cibubur (the "<strong>Center</strong>").</td>
  </tr>
  <tr>
    <td align="justify">PT. Trans Cibubur Property (the "<strong>Lessor</strong>") is pleased to offer to lease to you the shop unit as stated below (the "<strong>Demised Premises</strong>") under the following principal terms and conditions. These terms and conditions shall be incorporated into a standard Lease Agreement (the "<strong>Agreement</strong>"), which you will be required to sign in respect of the Demised Premises</td>
  </tr>
  <tr>
    <td align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td align="justify">If you agree with the principal terms and conditions contained herein, please do kindly indicate your acceptance by signing this Letter of Offer and initials on every page of this Letter of Offer, and if you are a company, affix your company stamp to this Letter of Offer and return the signed Letter of Offer to us within <strong>7 (seven) days</strong> as of the date of this Letter of Offer.</td>
  </tr>
   <tr>
     <td align="justify">&nbsp;</td>
   </tr>
   <tr>
    <td align="justify">Upon receiving the signed copy of this Letter of Offer, the Lessor shall prepare the Agreement. Until you sign the Agreement, the Lessor reserves the right to refuse you to enter into any of the Demised Premises. The Agreement shall be signed within <strong>14 (fourteen) days</strong> after the draft of the Agreement has been agreed by both parties.</td>
  </tr>
    <tr>
      <td align="justify">&nbsp;</td>
    </tr>
    <tr>
    <td align="justify">Subject to the foregoing, lessor hereby offers to lease the Demised Premises as detailed hereunder the following principal terms and conditions:</td>
	</tr>
	 <tr>
      <td align="justify">&nbsp;</td>
    </tr>
</table>
<table width="753" border="0">
  <tr>
  <td width="55"><strong>1.</strong></td>
  <td width="688"><strong>DEMISED PREMISES (as demarcated on floor plan attached)</strong></td>
 </tr>
</table>  
<table width="753" border="0">
  <tr>
  <td width="55">&nbsp;</td>
  <td width="98">Shop Unit No  </td>
  <td width="15">:</td>
  <td width="567">#<strong><?php echo $vunitname;?></strong></td>
 </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Level</td>
    <td>:</td>
    <td><strong><?php echo $row->lantai_name;?></strong></td>
  </tr>
</table> 
<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td width="55"><strong>2.</strong></td>
  <td width="688"><strong>AREA</strong></td>
 </tr>
</table>  
<table width="753" border="0">
  <tr>
    <td width="55">&nbsp;</td>
    <td><?php echo $vunitsqm;?> (<?php echo numberTowords($vunitsqm,0);?>) square meters, subject to the final measurement during the Hand-Over of Demised Premises.</td>
  </tr>
    <?php 
$ix=0;
$totbaserent=0;
foreach($vhargasewa as $rowsewa){ 

$ix++;
$baserent=$rowsewa->loodetil_baserent;
$grandbaserent=$baserent*$vunitsqm*$row->loo_term;
$totbaserent=$totbaserent+$grandbaserent;
} 
?> 
</table> 
<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td width="55"><strong>3.</strong></td>
  <td width="688"><strong>LEASE PERIOD</strong></td>
 </tr>
</table>  
<?php
$ls=$row->leasedyear;
if ($ls > 0){
	$lsyear=$ls;
}else{
	$lsyear=5;
}

?>
<table width="753" border="0">
  <tr>
    <td width="55">&nbsp;</td>
    <td><?php echo $lsyear;?> (<?php echo numberTowords($lsyear,0);?>) years from the Lease Commencement Date. </td>
  </tr>
</table> 

<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td width="55"><b>4.</b></td>
  <td width="688"><b>USE OF DEMISED PREMISES</b></td>
 </tr>
</table>  
<table width="753" border="0">
  <tr>
    <td width="55">&nbsp;</td>
    <td align="justify">The Demised Premises shall be used for the retail sale of <em>
      <?php 
	$rkn=substr($row->rekanan_name,0,2);
	$rkn=strtoupper($rkn);
	echo $row->rekanan_name;
	/*if ( (trim($rkn)=='PT') or (trim($rkn)=='CV') ){
			echo $row->rekanan_name;
	}else{
			echo $row->rekananshipping_name;
	}*/
	?>
    </em> under the trade name of <?php echo $row->rekananshipping_name;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="justify">Such merchandise shall be in line with the established standards maintained and monitored by the Lessee as a reputable retailer, and subject to the approval of the Lessor prior to the execution of the Agreement. The Lessee shall be responsible for obtaining all necessary approvals and licenses from the relevant authorities at the Lessee’s own costs and absolute responsibility. Any change to the mix and percentage of merchandise shall be subject to the Lessor’s written approval, which shall not be unreasonably withheld.</td>
  </tr>

</table> 
<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td width="55"><strong>5.</strong></td>
  <td width="688"><strong>BASE RENT</strong></td>
 </tr>
</table>  
<table width="753" border="0">
  <tr>
    <td width="55">&nbsp;</td>
  <td colspan="2">The base Rent is Rp <?php echo number_format($baserent,0);?>,- (Indonesian Rupiah <?php echo numberTowords($baserent,0);?>.) per square meter per month. The Total Base Rent for the 5 (five) years lease is Rp <?php echo number_format($totbaserent,0);?>,- (Indonesian Rupiah <?php echo numberTowords($totbaserent,0);?>.) payable as follows:</td>
  
  </tr>
  <tr>
	<td> &nbsp;</td>
  </tr>
   <?php
  $percentage = (int)$row->arp_percentage;
  $installment = (int)$row->arp_installment;
  $percentage_other = $installment * $percentage ;
  $percentage_other_value = 100 - $percentage_other;
  $nilpersen=$totbaserent*$percentage/100;
  $nil80=$totbaserent*$percentage_other_value/100;
  $nilinst=$nil80/$row->payment_installment;
   
  $abjad = array(
  1 => 'a',
  2 => 'b',
  3 => 'c',
  4 => 'd',
  );
  
  $i = 1;
  ?>
  <tr>
    <td>&nbsp;</td>
    <td width="33" valign="top">(<?php echo $abjad[$i]; ?>)</td>
    <td width="651" align="justify">A non-refundable Advance Rental Payment 1 (booking deposit)  of <?php echo (int)$row->arp_percentage; ?>% (<?php echo numberTowords((int)$row->arp_percentage);?> Percent ) in the sum of Rp<?php echo number_format($nilpersen,0);?>,- (Indonesian Rupiah <?php echo numberTowords($nilpersen);?>) upon signing Letter of Offer on Quarter  <?php echo $i. " ". date('Y'); ?>, which sum will be applied to Base Rent upon signing of the Lease Agreement at  which time Value Added Tax (VAT) with respect thereto shall be payable.</td>
  </tr>
  <?php
  if($installment > 1)
  {
	  for($i=2; $i <= $installment; $i++)
	  {   
  ?> 
  <tr>
    <td>&nbsp;</td>
    <td valign="top">(<?php echo $abjad[$i]; ?>)</td>
    <td align="justify">A non-refundable Advance Rental Payment <?php echo (int)$row->arp_percentage; ?>% (<?php echo numberTowords((int)$row->arp_percentage);?> Percent ) in the sum of Rp<?php echo number_format($nilpersen,0);?>,- (Indonesian Rupiah <?php echo numberTowords($nilpersen);?>) plus VAT payable on Quarter <?php echo $i. " ".date('Y'); ?>, whichever is earlier.</td>
  </tr> 
  <?php 
	  } //end for
  } //end if
  ?>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">(<?php echo $abjad[$i]; ?>)</td>
    <td align="justify"><?php echo $percentage_other_value;?>% ( <?php echo numberTowords($percentage_other_value); ?> percent) in the sum of Rp<?php echo number_format($nil80,0);?>,- (Indonesian Rupiah <?php echo numberTowords($nil80);?>) to be paid in <?php echo $row->payment_installment;?> (<?php echo numberTowords($row->payment_installment);?>) monthly installment {i.e. Rp<?php echo number_format($nilinst,0);?>,- (Indonesian Rupiah <?php echo numberTowords($nilinst);?>) plus VAT}, commencing from the Lease Commencement Date as defined in Clause 10.</td>
  </tr>
</table> 

<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td width="55"><strong>6.</strong></td>
  <td width="688"><strong>SERVICE CHARGE</strong></td>
 </tr>
</table>  
<?php
  if ($vhargasc==0){
	  $tnilsc='Indonesian Rupiah Nil';
  }else{
		$tnilsc="";  
  }
  ?>
<table width="753" border="0">
  <tr>
    <td width="55">&nbsp;</td>
    <td align="justify">The Service Charge is <strong>Rp.<?php echo $vhargasc;?> </strong>,-(<?php echo numberTowords($vhargasc);?><?php echo $tnilsc;?>) per square meter per month from the Lease Commencement Date, <strong>or as the same rate as the Service Charge that applied at the Center</strong>. Thereafter, for each subsequent calendar year, it will be reviewed and adjusted annually according to the provisions of the Lease Agreement.</td>

  </tr>
  <tr>
    <td>&nbsp;</td>
      <td align="justify">It is payable quarterly in advance and the first payment is payable within 14 days from Notice of Handover.</td>
      </tr>
</table> 

<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td width="55"><strong>7.</strong></td>
  <td width="688"><strong>VALUE ADDED TAX (V.A.T.)</strong></td>
 </tr>
</table>  
<table width="753" border="0">
  <tr>
    <td width="55">&nbsp;</td>
    <td align="justify">The Base Rent and Service Charge are subject to V.A.T. at prevailing rates at the time of payment and is to be borne by the Lessee.  The current rate is 10% for the Base Rent and 10% for Service Charge.</td>
  </tr>
</table> 

<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td width="55"><strong>8.</strong></td>
  <td width="688"><strong>SECURITY DEPOSIT</strong></td>
 </tr>
</table>  
<table width="753" border="0">
  <tr>
    <td width="55">&nbsp;</td>
    <td align="justify">The Security Deposit is to be equivalent to 3 (three) <strong>months’ Base Rent and Service Charge</strong>, payable upon signing the Lease Agreement.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="justify">Telephone lines are available for tenants upon request with a deposit of Rp.3,500,000,- (Indonesian Rupiah Three Million and Five Hundred Thousand) per line, payable on the signing of the Lease Agreement.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="justify">Such deposit shall be refunded to the Lessee by the Lessor free of interest, after the expiry of the Lease Period subject to deductions (if any), for any breach by the Lessee. Other costs, if any, must be agreed by both parties or subject to government regulation.</td>
  </tr>
</table> 


<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td width="55"><strong>9.</strong></td>
  <td width="688"><strong>FITTING OUT</strong></td>
 </tr>
</table>  
<table width="753" border="0">
  <tr>
    <td width="55">&nbsp;</td>
    <td align="justify">The Lessor will issue to the Lessee a notice 14 (fourteen) days in advance to fit-out the Demised Premises and grant a further  <?php echo $row->fitting_out;?> (<?php echo numberTowords($row->fitting_out);?>) weeks for fitting-out and stocking-up works, from the expiry of the notice to fit-out.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="justify">Such fitting out works shall be coordinated with the Lessor’s appointed Tenancy Work Co-ordination Team and shall be in accordance with the standard rules and regulations of the Tenants Fitting-Out Guide and Rules and the Tenants Construction Guide and Rules, and subject to the Lessor approval.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="justify">In the event that the Demised Premises are ready for commercial operation before the expiration of the fit-out period and stocking-up period and the Center is ready for commercial opening, then subject to written approval of the Lessor, the Lessee shall open the Demised Premises for trade and Base Rent and Service Charge shall be payable from such date of trading in accordance with Clause 10 below.</td>
  </tr>
</table> 

<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td width="55"><strong>10.</strong></td>
  <td width="688"><strong>LEASE COMMENCEMENT DATE</strong></td>
 </tr>
</table>  
<table width="753" border="0">
  <tr>
    <td width="55">&nbsp;</td>
    <td align="justify">The Lease Commencement Date is <strong>14th December 2018</strong></td>
  </tr>
</table> 

<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td width="55"><strong>11.</strong></td>
  <td width="688"><strong>CENTRE PROMOTIONS</strong></td>
 </tr>
</table>  
<table width="753" border="0">
  <tr>
    <td width="55">&nbsp;</td>
    <td align="justify">The Lessee shall pay to the Lessor a single/one-off contribution of Rp 0,- (Indonesian Rupiah Nil) per square meter of the Area leased, to cover the Lessee's share of the Center Grand Opening promotional and advertising expenses.  This payment shall be made within two (2) weeks from the date of notice for fitting-out the Demised Premises.</td>
  </tr>
  <?php
  if ($vpromolevy==0){
	  $tnil='Indonesian Rupiah Nil';
  }else{
		$tnil="";  
  }
  ?>
  <tr>
    <td>&nbsp;</td>
    <td align="justify">The Lessee shall pay to the Lessor an on-going Promotional Levy of <strong>Rp.<?php echo $vpromolevy;?> </strong>,-(<?php echo numberTowords($vpromolevy);?><?php echo $tnil;?>) per square meter per month payable monthly in advance commencing from the Lease Commencement Date. The Promotional Levy is subject to review & adjust periodically.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="justify">The Lessee shall participate in the Lessor’s Center Loyalty Card Program for the purpose and benefit of promoting higher retail spending in Trans Studio Mall Cibubur and to accept any payment made by Bank Mega Cash Card.</td>
  </tr>
</table> 

<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td width="55"><strong>12.</strong></td>
  <td width="688"><strong>LEGAL COSTS AND STAMP DUTY</strong></td>
 </tr>
</table>  
<table width="753" border="0">
  <tr>
    <td width="55">&nbsp;</td>
    <td align="justify">The Lessee shall be responsible for costs associated with the Agreement, including the Lessor's solicitor’s costs of preparation and completion of the Agreement, stamp duty and any attendant expenses (if any). </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="justify">If the Lessee is a Company/CV, the notarial costs for Agreement shall be amounting to Rp..1.650.000,- including VAT 10%.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="justify">If the Lessee is an Individual, the notarial costs for Lease Agreement is amounting to Rp..1.100.000,- including VAT 10%.</td>
  </tr>
</table>


<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td width="55"><strong>13.</strong></td>
  <td width="688"><strong>ACCEPTANCE OF OFFER</strong></td>
 </tr>
</table>  
<table width="753" border="0">
  <tr>
    <td width="55">&nbsp;</td>
    <td align="justify">Should you accept this Letter of Offer, you are required to execute the Agreement in duplicate within 14 (fourteen) days after the draft has been agreed by both parties.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="justify">Time shall be of the essence.  In the event the Agreement has not been signed within the said period, the non-refundable deposit tendered shall be forfeited and, thereafter, neither party shall have any claims whatsoever against the other.</td>
  </tr>
</table>

<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td width="55"><strong>14.</strong></td>
  <td width="688"><strong>GUARANTOR</strong></td>
 </tr>
</table>  
<table width="753" border="0">
<?php if ($row->guarantor > 0){?>
  <tr>
    <td width="55">&nbsp;</td>
    <td align="justify">If the Lessee is a Company, then the Shareholders and / or Directors thereof shall give joint and several guarantees to which their spouses shall consent to the Lessor to guarantee the performance by the Lessee of the terms and conditions of the Lease Agreement.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="justify">If the Lessee is an individual, his / her spouses shall consent to the Lease Agreement.</td>
  </tr>
  <?php }else{ ?>
   <tr>
    <td width="55">&nbsp;</td>
    <td align="justify">Not Applicable.</td>
  </tr>
  <?php } ?>
</table>

<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td width="55"><strong>15.</strong></td>
  <td width="688"><strong>GENERAL SHOP SPECIFICATION</strong></td>
 </tr>
</table>  
<table width="753" border="0">
  <tr>
    <td width="55">&nbsp;</td>
    <td colspan="3" align="justify">The Demised Premises shall be made available to the Lessee on the commencement date of the Lessee’s fitting-out works as stated in Clause 9 above with the conditions, as follows:</td>
  </tr>
  <tr>
    <td height="50">&nbsp;</td>
    <td width="166" height="50" align="justify" valign="top">Floors</td>
    <td width="24" height="50" align="justify" valign="top">:</td>
    <td width="490" height="50" align="justify" valign="top">Bare finish.</td>
  </tr>
  <tr>
    <td height="50" valign="top">&nbsp;</td>
    <td height="50" align="justify" valign="top">Walls</td>
    <td height="50" align="justify" valign="top">:</td>
    <td height="50" align="justify" valign="top">Bare finish.</td>
  </tr>
  <tr>
    <td height="50" valign="top">&nbsp;</td>
    <td height="50" align="justify" valign="top">Ceiling</td>
    <td height="50" align="justify" valign="top">:</td>
    <td height="50" align="justify" valign="top">Bare finish.</td>
  </tr>
  <tr>
    <td height="50" valign="top">&nbsp;</td>
    <td height="50" align="justify" valign="top">Air Conditioning</td>
    <td height="50" align="justify" valign="top">:</td>
    <td height="50" align="justify" valign="top">Chiller/AHU by Lessor as per base building design with temperature 24º C± 1º C. Main ducting installed to lease line by the Lessor, internal ducting and volume damper by the Lessee.</td>
  </tr>
  <tr>
    <td height="50" valign="top">&nbsp;</td>
    <td height="50" align="justify" valign="top">Fire Fighting System</td>
    <td height="50" align="justify" valign="top">:</td>
    <td height="50" align="justify" valign="top">Pipe work, hydrants, sprinklers, detectors and fire alarm by the Lessor as per base building.  </td>
  </tr>
  <tr>
    <td height="50" valign="top">&nbsp;</td>
    <td height="50" align="justify" valign="top">Power Supply</td>
    <td height="50" align="justify" valign="top">:</td>
    <td height="50" align="justify" valign="top">100 VA/m2. Excluding AC, An electrical line to a designated point within the premises including a KWH meter (include main breaker) as per base building. All circulation from the KWH meter and payment for monthly consumption are the Lessee’s responsibility. </td>
  </tr>
  <tr>
    <td height="50" valign="top">&nbsp;</td>
    <td height="50" align="justify" valign="top">Lighting </td>
    <td height="50" align="justify" valign="top">:</td>
    <td height="50" align="justify" valign="top">Bare. Fixtures and wiring by Lessee.</td>
  </tr>
  <tr>
    <td height="50" valign="top">&nbsp;</td>
    <td height="50" align="justify" valign="top">Sound System</td>
    <td height="50" align="justify" valign="top">:</td>
    <td height="50" align="justify" valign="top">System &  Installation by the Lessor, override emergency paging by Lessor. </td>
  </tr>
    <tr>
    <td height="50" valign="top">&nbsp;</td>
    <td height="50" align="justify" valign="top">Structural Specification</td>
    <td height="50" align="justify" valign="top">:</td>
    <td height="50" align="justify" valign="top">Loading capacity 350 - 400 kg/m2</td>
  </tr>
  <tr>
    <td height="50" valign="top">&nbsp;</td>
    <td height="50" align="justify" valign="top">Telephone</td>
    <td height="50" align="justify" valign="top">:</td>
    <td height="50" align="justify" valign="top">2 (two) lines installed by the Lessor as per base building.</td>
  </tr>
   <tr>
    <td height="50" valign="top">&nbsp;</td>
    <td height="50" align="justify" valign="top">Back Up Power</td>
    <td height="50" align="justify" valign="top">:</td>
    <td height="50" align="justify" valign="top">Back up power 100% for lighting & appliance 60% for AC system/ventilation system.</td>
  </tr>
  <tr>
    <td height="50" valign="top">&nbsp;</td>
    <td height="50" align="justify" valign="top">Escalators</td>
    <td height="50" align="justify" valign="top">:</td>
    <td height="50" align="justify" valign="top"><u>Common use</u><br />
Basement 1 : 4 nos.
  <br />
  Basement 2 : 6 nos.
  <br />
Lower Ground : 6 nos.
<br />
Ground Floor : 12 nos.
<br />
1st Floor : 10 nos.
<br />
2nd Floor : 8 nos.
<br />
3rd Floor  :10 nos.
<br />
4th Floor : 14 nos.
<br />
Total project escalator 70 nos. Nominal width 1,200mm.
<br />
Capacity 9,000 passenger per hour. Speed 30 m/min. </td>
  </tr>
  <tr>
    <td height="50" valign="top">&nbsp;</td>
    <td height="50" align="justify" valign="top">Elevator (Freight and Passenger)</td>
    <td height="50" align="justify" valign="top">:</td>
    <td height="50" align="justify" valign="top"><u>Common use</u><br />
Each floor has 4 (four) units Freight Elevator & 5 (Five) units Passenger Lift.<br />
<br />
4 (Four) units Freight Elevator.<br />
Load capacity 2,000 kg.<br /> 
Car inside 2,300 (width) x 2,650 (depth) mm.<br />
Opening size 1,500 (width) x 2,100 (height) mm.<br />
<br />
5 (five) units Passenger Lift.<br />
Load capacity 1,600 kg.<br />
Car inside 2,100 (width) x 1,600 (depth) mm.<br />
Opening size 1,100 (width) x 2,100 (height) mm
</td>
  </tr>
  <tr>
    <td height="50" valign="top">&nbsp;</td>
    <td height="50" align="justify" valign="top">Travellator</td>
    <td height="50" align="justify" valign="top">:</td>
    <td height="50" align="justify" valign="top">Lower Ground Mezzanine : 2 units<br />
					Lower Ground : 4 units<br />
					Basement 1 : 4 units<br />
					Basement 2 : 2 units<br /></td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td width="55"><strong>16.</strong></td>
  <td width="688"><strong>OTHER CONDITIONS</strong></td>
 </tr>
</table>  
<table width="753" border="0">
  <tr>
    <td width="55">&nbsp;</td>
    <td align="justify"><?php echo $row->demised;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="justify">&nbsp;</td>
  </tr>
  </table>
<table width="753" border="0">   
<tr>
   <td>Any variations to the foregoing will be at the Lessee's expense.</td>
</tr>
<tr>
   <td align="justify">PT. Trans Cibubur Property trusts you are in  agreement with the terms and conditions herein and accordingly looks forward to  receiving your signed copy of this Letter of Offer within <strong>7 (seven) days</strong> together with the  <?php echo $row->payment_installment;?> % <b>(<?php echo numberTowords($row->payment_installment);?> percent)</b> non-refundable advance rental payment shall be Rp<?php echo number_format($nilpersen,0);?>,- (Indonesian Rupiah <?php echo numberTowords($nilpersen);?>), by telegraphic transfer in such amount to  :</td>
</tr>
<tr>
   <td align="center">PT. Trans Cibubur Property<br />
A/C No. : 01.074.00.11.42901.3<br />
Bank Mega KCU Jakarta Tendean<br />
</td>
</tr>
<tr>
  <td align="justify">&nbsp;</td>
</tr>
<tr>
   <td align="justify"><b>If you are a company, please provide us with a copy of your <em>Akta Perusahaan</em> when you return this letter.</b></td>
</tr>
<tr>
   <td align="justify">You shall be regarded as having rejected this offer should the Lessor not receive the signed Letter of Offer and the deposit within 7 (seven) days from the date of this Letter of Offer and the Lessor shall be entitled to offer a lease of the above premises to any other party without further reference to you.</td>
</tr>
</table>

<table width="753" border="0">
  <tr>
    <td width="355">&nbsp;</td>
    <td width="37">&nbsp;</td>
    <td width="140">&nbsp;</td>
    <td width="203">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p>Yours faithfully,</p></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p>PT. Trans Cibubur Property</p></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p><strong><u>Chairal Tanjung</u></strong></p></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p>President Director </p></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="753" border="0">   
      <tr>
        <td >&nbsp;</td>

      </tr>
      </tr>

</table>

<div style="page-break-after: always; width:400" id="hal4"></div>
<table width="753" border="0">   
      <tr>
        <td>I/We agree to accept the above terms and conditions and hereby request PT. TRANS CIBUBUR PROPERTY to forward the Agreement to me/us for my/our execution. </td>

      </tr>

</table>
<table width="753" border="0">   
      <tr>
        <td width="194" height="80" valign="top">Company’s Name</td>
<td width="10" height="80" valign="top">:</td>
<td width="535" height="80">&nbsp;</td>
  </tr>
      <tr>
        <td height="80" valign="top">Name (in block letters)</td>
        <td height="80" valign="top">:</td>
        <td height="80">&nbsp;</td>
  </tr>
      <tr>
        <td height="80" valign="top">Signature/ Title</td>
        <td height="80" valign="top">:</td>
        <td height="80">&nbsp;</td>
  </tr>
      <tr>
        <td height="80" valign="top">ID. No. (No. KTP)</td>
        <td height="80" valign="top">:</td>
        <td height="80">&nbsp;</td>
  </tr>
      <tr>
        <td height="80" valign="top">Address  (KTP)</td>
        <td height="80" valign="top">:</td>
        <td height="80">&nbsp;</td>
  </tr>
      <tr>
        <td height="80" valign="top">Correspondence Address</td>
        <td height="80" valign="top">:</td>
        <td height="80">&nbsp;</td>
  </tr>
      <tr>
        <td height="80" valign="top">Telephone/ HP / Fax #</td>
        <td height="80" valign="top">:</td>
        <td height="80">&nbsp;</td>
  </tr>
      <tr>
        <td height="80" valign="top">Email</td>
        <td height="80" valign="top">:</td>
        <td height="80">&nbsp;</td>
  </tr>
      <tr>
        <td height="80" valign="top"><em>NPWP</em>* </td>
        <td height="80" valign="top">:</td>
        <td height="80">&nbsp;</td>
  </tr>
      <tr>
        <td height="80" valign="top"><em>SKT</em>*    </td>
        <td height="80" valign="top">:</td>
        <td height="80">&nbsp;</td>
  </tr>
      <tr>
        <td height="80" valign="top"><em>TDP</em>*</td>
        <td height="80" valign="top">:</td>
        <td height="80">&nbsp;</td>
  </tr>
      <tr>
        <td height="80" valign="top"><em>Akta  Perusahaan</em>  </td>
        <td height="80" valign="top">:</td>
        <td height="80">&nbsp;</td>
  </tr>
      <tr>
        <td height="80" valign="top"><em>SIUP</em>*   </td>
        <td height="80" valign="top">:</td>
        <td height="80">&nbsp;</td>
  </tr>
</table>
<table width="753" border="0">   
      <tr>
        <td>*softcopy and hardcopy shall be submitted</td>
     </tr>
<tr>
        <td>Date this .......... day of ............................ 2018   -   Jakarta, Indonesia.</td>
     </tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><hr /></td>
</tr>
</table>
<div style="page-break-after: always; width:400" id="hal4"></div>
<table width="753" border="0">   
      <tr>
        <td><strong>Guarantors</strong></td>

      </tr>

</table>
<table width="753" border="0">   
      <tr>
        <td width="35" valign="top">1</td>
        <td width="153" valign="top">Name</td>
        <td width="20" valign="top">:</td>
        <td width="527" valign="top">&nbsp;</td>

      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Signature/ Title</td>
        <td valign="top">:</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">ID-No. (No. KTP)</td>
        <td valign="top">:</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Company/ Address</td>
        <td valign="top">:</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Telephone/ HP / Fax #</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">2</td>
        <td valign="top">Name</td>
        <td valign="top">:</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Signature/ Title</td>
        <td valign="top">:</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">ID-No. (No. KTP)</td>
        <td valign="top">:</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Company/ Address</td>
        <td valign="top">:</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Telephone/ HP / Fax #</td>
        <td valign="top">:</td>
        <td valign="top">&nbsp;</td>
  </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td colspan="3" valign="top"><p>Date  this ............. day of ............................ 2018   -    Jakarta, Indonesia. </p></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td colspan="3" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" valign="top"><hr /></td>
      </tr>

</table>
<?php }}?> 
</body>
</html>