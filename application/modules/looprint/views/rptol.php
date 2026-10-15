<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
@font-face {
    font-family: 'garamond'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/GARA.ttf');?>'); /*URL to font*/
	src: url('<?php echo base_url('assets/css/loo/GARABD.ttf');?>'); /*URL to font*/
	src: url('<?php echo base_url('assets/css/loo/GARAIT.ttf');?>');
}
body {font-family: 'gramond';font-size: 11pt}
@page { margin-left:3.5cm; margin-right:3cm; margin-top:3cm;margin-bottom:0.5cm;size:8.27in 11.69in;}
table, tr, td {
  font-family: 'gramond';font-size: 11pt;
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
foreach($result as $row){ 
?>  
<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td width="74">&nbsp;</td>
    <td width="379" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td align="right"><b>PRIVATE & CONFIDENTIAL</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="735" ><b><?php echo $row->rekanancontact_name;?></b></td>
  </tr>
  <tr>
    <td ><b>
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
    </b></td>
  </tr>
  <tr>
    <td ><b><?php echo $row->rekanan_address;?></b></td>
  </tr>
  <tr>
    <td><?php echo $new_date = date('d F Y', strtotime($row->loo_date));?></td>
  </tr>
  <tr>
    <td><b>Dear  <?php echo $row->rekananshipping_contactname;?></b></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">TRANS  STUDIO MALL CIBUBUR</td>
  </tr>
  <tr>
    <td align="center"><p align="center"><b>
      <?php 
	$rkn=substr($row->rekanan_name,0,2);
	$rkn=strtoupper($rkn);
	if ( (trim($rkn)=='PT') or (trim($rkn)=='CV') ){
			echo $row->rekanan_name;
	}else{
			echo $row->rekananshipping_name;
	}
	?>
    </b></p></td>
  </tr>
  <tr>
    <td align="center"><strong>Shop Units #<?php echo $vunitname;?>, <?php echo $row->lantai_name;?></strong></td>
  </tr>
  <tr>
    <td align="center">Terms & Conditions</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="justify">&nbsp;</td>
   </tr>
</table>
   
<table width="753" border="0">
  <tr>
    <td width="26" valign="top">1.</td>
    <td align="justify">Premises No. <strong><?php echo $vunitname;?>, <?php echo $row->lantai_name;?></strong> : <?php echo $vunitsqm;?> m2 <em>subject to final measurement during the Hand-Over of Premises.</em></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="justify"><em>The Lessor reserves the right to relocate an alternative lot with similar size situated at other floors and/or locations of the Center, subject to any changes for plan and whatsoever, which the Lessor deems fit of the Centre. In the event the Lessor plans to relocate the Lessee, the Lessor shall notify the Lessee six (6) months prior to the Hand-Over of the Premises.</em></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php 
$ix=0;
$totbaserent=0;
foreach($vhargasewa as $rowsewa){ 
?>
  <tr>
  <td valign="top">2.</td>
  <td valign="top">Base Rent: <b>Rp <?php echo number_format($rowsewa->loodetil_baserent,0);?>,-</b> (Indonesian Rupiah  <?php echo numberTowords($rowsewa->loodetil_baserent,0);?>) /m² / month plus VAT.</td>
 </tr>
  <?php 
$ix++;
$baserent=$rowsewa->loodetil_baserent;
$grandbaserent=$baserent*$vunitsqm*$row->loo_term;
$totbaserent=$totbaserent+$grandbaserent;
} 



?> 
  <tr>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr>
  <td  valign="top">3.</td>
  <td align="justify">Lease Period: <?php echo $row->loo_term;?> (<?php echo numberTowords($row->loo_term);?>) Month , from <?php echo $new_date = date('F Y', strtotime($row->loo_sdate));?> (estimated as the Center’s opening date) to <?php echo $new_date = date('F Y', strtotime($row->loo_edate));?>. The Lease Period is subject to the following changes:</td>
 </tr>

  <tr>
    <td >&nbsp;</td>
    <td align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="justify"><em>a. Any changes caused by changes in construction timeline that cannot be determined today. </em></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="justify"><em>b. Any changes, including but not limited to lay-out changes, relocations, tenancy mix, and other external
    factors including brand relevance that cannot be determined today. However, re-lay-out will be agreed
   by both parties.
    </em></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">4.</td>
    <td align="justify">The Hand-Over of the Premises is estimated in September 2018 (subject to availability of Premises) or at least three (3) months before the opening of Trans Studio Mall Cibubur (date to be confirmed by the Lessor).*</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="justify"><em>*Delay of Hand-Over of Premises by the Lessee, if any, shall not affect the Rent Commencement Date, which will be maintained upon the expiry of the Fitting-Out Period, which will be three (3) months after the Hand-Over date, or upon opening of business, whichever is earlier.</em></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="justify">&nbsp;</td>
  </tr>
  <?php
  $nilpersen=$totbaserent*5/100;
  $nil80=$totbaserent*80/100;
  if ($nil80>0){
  $nilinst=$nil80/$row->payment_installment;
  }else{
	$nilinst=0;  
  }
  
  ?>
  <tr>
    <td valign="top">5.</td>
    <td align="justify">(a) A non-refundable Advance Rental Payment 1 (booking deposit) of 5% (five percent) in the sum of Rp <?php echo number_format($nilpersen,0);?>. (Indonesian Rupiah <?php echo numberTowords($nilpersen);?>.) upon signing Letter of Offer on Quarter 1 2018, which sum will be applied to Base Rent upon signing of the Lease Agreement at  which time Value Added Tax (VAT) eith respect thereto shall be payable.</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="justify">(b)	A non-refundable Advance Rental Payment 2 of 5% (five percent) in the sum of Rp <?php echo number_format($nilpersen,0);?>. (Indonesian Rupiah  <?php echo numberTowords($nilpersen);?>.) plus VAT payable on Quarter 2 2018, whichever is earlier.</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="justify">(c)	A non-refundable Advance Rental Payment 3 of 5% (five percent) in the sum of Rp <?php echo number_format($nilpersen,0);?> (Indonesian Rupiah  <?php echo numberTowords($nilpersen);?>) plus VAT payable on Quarter 3 2018.</td>
  </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
   <tr>
    <td valign="top">&nbsp;</td>
    <td align="justify">(d)	A non-refundable Advance Rental Payment 4 of 5% (five percent) in the sum of Rp <?php echo number_format($nilpersen,0);?>. (Indonesian Rupiah <?php echo numberTowords($nilpersen);?>) plus VAT payable on October 2018.</td>
  </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
   <tr>
    <td valign="top">&nbsp;</td>
    <td align="justify">(e)	80% (eighty percent) in the sum of Rp <?php echo number_format($nil80,0);?>. (Indonesian Rupiah<?php echo numberTowords($nil80);?>.) to be paid in <?php echo $row->payment_installment;?> (<?php echo numberTowords($row->payment_installment);?>) monthly installment {i.e. Rp <?php echo number_format($nilinst,0);?> (Indonesian Rupiah <?php echo numberTowords($nilinst);?>) plus VAT}, commencing from the Lease Commencement Date as defined in Clause 10.</td>
  </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
   <tr>
     <td valign="top">6.</td>
     <td align="justify">For the Calendar Year 2018, the Service Charge is estimated at Rp.170.000,- per m2 per month plus VAT, and shall be subject to review made by the sole discretion of the Lessor. The 1st payment shall be due and payable thirty (30) calendar days prior to the Rent Commencement Date. Service Charge shall be due and payable quarterly in advance, and will be subject to Annual Review and assessed by the Lessor against the Lessee based on the Lessor’s determination of the Lessee’s Proportion of such Rates and Taxes, Energy Costs, and Other Operating Expenses. The Lessor will inform the Lessee in writing the adjustment of Service Charge for the Calendar Year 2019 at least three (3) months prior to such increase to be effective. The Lessor shall have no obligation to provide the Lessee with any evidence regarding the increase.</td>
   </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
   <tr>
     <td valign="top">7.</td>
     <td align="justify">Promotion Fee of Rp.20,000,- ( Indonesian Rupiah Twenty Thousand) per m2. Plus VAT. Promotion Fee that applied at the center per m² per month payable monthly in advance commencing from the Lease Commencement Date.</td>
   </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
   <tr>
     <td valign="top">8</td>
     <td align="justify">The Security Deposit is to be equivalent to 3 (three) month’s Base Rent and Service Charge, payable upon signing the Lease Agreement.</td>
   </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify"><p>Telephone  Lines are available for tenants upon request with a deposit of <strong>Rp.3,500,000,-(</strong>Indonesian  Rupiah Three Million and Five Hundred Thousand) per line, payable on the  signing of the Lease Agreement.</p></td>
   </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify"><p>Such deposit  shall be refunded to the Lessee by the Lessor free of interest, after the  expiry of the Lease Period subject to such deductions if any, for any breach by  the Lessee.</p></td>
   </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
   <tr>
     <td valign="top">9.</td>
     <td align="justify">Fitting-Out  (rent-free) Period is <strong>three (3) months </strong>and  shall commence 1 (one) day after the date of Hand-Over of Premises,<strong> </strong>or upon opening of business, whichever  is earlier.</td>
   </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
   <tr>
     <td valign="top">10.</td>
     <td align="justify">Fitting-Out  works shall be carried out in accordance with specifications of Tenant Fit-Out  Guidelines at the Lessee&rsquo;s expense, subject to prior approval and terms and  conditions of Trans Studio Mall Cibubur.</td>
   </tr><tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr><tr>
     <td valign="top">11.</td>
     <td align="justify">Fitting-Out  works must be completed before or upon the expiry of the fitting-out period,  which is three (3) months after the Hand-Over date or from the date of  Hand-Over of Premises. The Lessee must comply with the design concept approved  by the Lessor, with fitting-out quality and execution in accordance with the  specifications in the <em>
       <?php 
	$rkn=substr($row->rekanan_name,0,2);
	$rkn=strtoupper($rkn);
	if ( (trim($rkn)=='PT') or (trim($rkn)=='CV') ){
			echo $row->rekanan_name;
	}else{
			echo $row->rekananshipping_name;
	}
	?> 
     Concept</em> which will be specified by the Lessee and subject to the Lessor&rsquo;s approval<em>.</em></td>
   </tr><tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
   <tr>
     <td valign="top">12.</td>
     <td align="justify">The Hoarding  Installation and Demolition Cost per m2 plus VAT is to be advised at  the latest by three (3) months prior to the Hand-Over date (and is subject to  annual review), and shall be due and payable <strong>one (1) month</strong> before the Hand-Over of the Premises, calculated  based on computed Hoarding Measurement as per the detailed hoarding lay-out area  issued by Trans Studio Mall Cibubur<strong> </strong>Retail  Fit-Out Dept.. Design, printing, and installation fee of the hoarding&rsquo;s visual  image shall be at Lessee&rsquo;s cost. Fitting-Out  Deposit and all cost caused by the use of water and electricity during the  Fitting-Out Period shall be borne by the Lessee. </td>
   </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
   <tr>
     <td valign="top">13.</td>
     <td align="justify">The Lessee  shall observe and comply with the Shopping Center&rsquo;s Operational Hours from 10  AM to 10 PM daily, seven (7) days a week, except for the first day of Idul  Fitri during which the retail portion of the Complex is closed.</td>
   </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify"><p><em>For any additional operation hours of
       <?php 
	$rkn=substr($row->rekanan_name,0,2);
	$rkn=strtoupper($rkn);
	if ( (trim($rkn)=='PT') or (trim($rkn)=='CV') ){
			echo $row->rekanan_name;
	}else{
			echo $row->rekananshipping_name;
	}
	?>
     additional Service Charge will be imposed.</em></p></td>
   </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
   <tr>
     <td valign="top">14.</td>
     <td align="justify">The Premises shall be exclusively used for <strong><em><b>
       <?php 
	$rkn=substr($row->rekanan_name,0,2);
	$rkn=strtoupper($rkn);
	if ( (trim($rkn)=='PT') or (trim($rkn)=='CV') ){
			echo $row->rekanan_name;
	}else{
			echo $row->rekananshipping_name;
	}
	?>
     ,  with the <?php echo $row->product_name;?> Concept to be specified by the Lessee and subject to the  Lessor&rsquo;s approval</b>.</em></strong><em> A copy of the  Appointment Letter for the brand issued on the Brand Principal&rsquo;s Stationary  letter head together with the Principal&rsquo;s contact details is required for the  execution of Lease Agreement.</em></td>
   </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
   <tr>
     <td valign="top">15.</td>
     <td align="justify">During the  Lease Period, the Lessee is not allowed to open a similar business with the  same trademark and operationalize its kind within a radius of <strong>five kilometers (5 km)</strong> from Trans  Studio Mall Cibubur. If the Lessee is proven to open a similar business within  the radius of five kilometers (5 km), it shall constitutes a breach to the  Lease Agreement and therefore, the Lessor is entitled to impose penalties to  the Lessee equivalent to 100% of the total value of the Lease, and the Lessor  reserves the right to terminate the Lease Agreement without any demands.</td>
   </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
   <tr>
     <td valign="top">16.</td>
     <td align="justify">Other terms  and conditions shall be in accordance with our standard Lease Agreement and  Lease Conditions.  </td>
   </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
   <tr>
     <td valign="top">17.</td>
     <td align="justify">This Offer  is subject to availability of existing Premises, execution of Letter of Intent,  and full payment of the Commitment Deposit and 1st installment of the  Holding Deposit in advance.</td>
   </tr>
   <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
    <tr>
     <td colspan="2" valign="top" align="justify">This document does not constitute a valid offer and this  has no binding effect on either party. Prospect must respond to this  negotiation within seven (7) days from the calendar date thereof and must have  a store design concept.</td>
   </tr>
    <tr>
     <td colspan="2" valign="top">&nbsp;</td>
   </tr>
    <tr>
     <td colspan="2" valign="top" align="justify">For further information, please do not hesitate to contacts  Mrs. Kusuma Dewi (Leasing General Manager - Corporate) mobile 08111871977, or  Mr. Christoffel Simamora (Leasing Manager) mobile 08118118204.</td>
   </tr>
    <tr>
     <td height="47" valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
    <tr>
     <td colspan="2" valign="top"><p>Thank you.</p></td>
   </tr> <tr>
     <td height="30" valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr> <tr>
     <td colspan="2" valign="top"><p>Yours faithfully,</p></td>
     </tr> <tr>
     <td height="60" valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
   
    <tr>
     <td colspan="2" valign="top"><p><strong><u>Linda Tampi</u></strong></p></td>
   </tr>
    <tr>
     <td colspan="2" valign="top"><p>General Manager</p></td>
   </tr>
    <tr>
     <td valign="top">&nbsp;</td>
     <td align="justify">&nbsp;</td>
   </tr>
   

</table>  

<?php }}?> 
</body>
</html>