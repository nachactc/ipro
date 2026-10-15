<?php
  if ($button == 'EXCEL')
  {

	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header("Content-Disposition: attachment; filename=".$region_name." - ".$branch_name.".xls");
  }
 ?>
<title>TENANCY CONTRACT LISTING</title>

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

</head>
<br />

<body>



<p>TENANCY CONTRACT LISTING</p>


 </br>

<table class="tg" width="1095" border="0">
  <tr>
        <td width="4%" class="tg-li00">ID</td>
        <td width="3%" class="tg-li00">Name</td>
        <td width="4%" class="tg-li00">Tenant A/C</td>
        <td width="5%" class="tg-li00">ID Agreement</td>
        <td width="4%" class="tg-li00">Trade Name</td>
        <td width="5%" class="tg-li00">Booking Date</td>
        <td width="3%"class="tg-li00">BAP Date</td>
        <td width="3%"class="tg-li00">LOI</td>
        <td width="3%"class="tg-li00">LA</td>
        <td width="5%" class="tg-li00">Occupancy Commence</td>
        <td width="5%"class="tg-li00">Occupancy Expiry Date</td>
        <td width="3%"class="tg-li00">Lease (month)</td>
        <td width="4%"class="tg-li00">Staff In Charge</td>
        <td width="3%"class="tg-li00">Lot No</td>
        <td width="5%"class="tg-li00">Currency</td>
        <td width="5%"class="tg-li00">Contract Amount</td>
        <td width="3%"class="tg-li00">Area (sqm)</td>
        <td width="4%"class="tg-li00">Rental Rate</td>
        <td width="5%"class="tg-li00">Rental Amount</td>
        <td width="5%"class="tg-li00">Service Rate</td>
        <td width="6%"class="tg-li00">Service Amount</td>
        <td width="7%"class="tg-li00">YTD Amortization Rental</td>
        <td width="7%"class="tg-li00">YTD Amortization Services Charges</td>
        <td width="7%"class="tg-li00">Virtual Account Payment</td>
        <td width="7%"class="tg-li00">Rental Type</td>
        <td width="5%"class="tg-li00">Rekanan Type</td>
        <td width="4%"class="tg-li00">Active/ Closed</td>
  </tr>
<?php

$idr = 0;
$totalidr = 0;
$subtotalidr = 0;
$subtotalrental =0;
$rental=0;
$subtotalservice=0;
$service=0;
if(isset($result)){
foreach($result as $row){
  $idr = $row->RENTAL_TOTAL;
  $rental = $row->RENTAL_AMOUNT;
  $service = $row->SC_AMOUNT;    
  $subtotalidr = $subtotalidr + $idr;
  $subtotalrental = $subtotalrental + $rental;
  $subtotalservice = $subtotalservice + $service;    
  $totalidr = $totalidr + $idr;
  $enddate = $row->agreement_endperiod; 
	$dateend = new DateTime($enddate);
	$format = 'd-M-Y';
?>
  <tr>
        <td width="4%" class="tg-iuhm"><?php echo $row->rekanan_id; ?></td>
        <td width="3%" class="tg-iuhm"><?php echo $row->rekanan_name; ?></td>
        <td width="4%" class="tg-iuhm"><?php echo $row->agreement_contractno; ?></td>
        <td width="5%" class="tg-iuhm"><?php echo $row->agreement_id; ?></td>
        <td width="4%" class="tg-iuhm"><?php echo $row->rekananshipping_name; ?></td>
        <td width="5%" class="tg-iuhm"><?php echo date('d-M-Y',strtotime($row->agreement_createdate)); ?></td>
        <td width="3%" class="tg-iuhm"><?php 
                                $thn=date('Y',strtotime($row->agreement_bapdate));
                                if ($thn<2000){
                                                echo "";
                                }else{
                                echo date('d-M-Y',strtotime($row->agreement_bapdate)); 
                                }
                                ?></td>
        <td width="3%" class="tg-iuhm"><?php echo $row->agreement_contractlongnumber; ?></td>
        <td width="3%" class="tg-iuhm"><?php echo $row->agreement_lanumber; ?></td>
        <td width="5%" class="tg-iuhm"><?php echo date('d-M-Y',strtotime($row->agreement_startperiod)); ?></td>
        <td width="5%" class="tg-iuhm"><?php echo $dateend->format($format); ?></td>
        <td width="3%" class="tg-iuhm"><?php echo $row->lease; ?></td>
        <td width="4%" class="tg-iuhm"><?php echo $row->agreement_createby; ?></td>
        <td width="3%" class="tg-iuhm"><?php echo $row->agreementdetil_unit; ?></td>
        <td width="5%" class="tg-iuhm"><?php echo $row->currency_id; ?></td>
        <td width="5%" class="tg-iuhm" align="right"><?php echo number_format($row->RENTAL_TOTAL,0); ?></td>
        <td width="3%" class="tg-iuhm"><?php echo $row->agreementdetil_space; ?></td>
        <td width="4%" class="tg-iuhm" align="right"><?php echo number_format($row->BASERENT,0); ?></td>
        <td width="5%" class="tg-iuhm" align="right"><?php echo number_format($row->RENTAL_AMOUNT,0); ?></td>
        <td width="5%" class="tg-iuhm" align="right"><?php echo number_format($row->SC_BASERENT,0); ?></td>
        <td width="6%" class="tg-iuhm" align="right"><?php echo number_format($row->SC_AMOUNT,0); ?></td>
        <td width="7%" class="tg-iuhm" align="right"><?php echo number_format($row->RENTAL_AMOR,0); ?></td>
        <td width="7%" class="tg-iuhm" align="right"><?php echo number_format($row->SC_AMOR,0); ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->agreement_virtualaccount; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->rental_type; ?></td>
        <td width="5%" class="tg-iuhm"><?php echo $row->rekananshippingtype_name; ?></td>
        <td width="4%" class="tg-iuhm"><?php echo $row->ISCLOSED; ?></td>
  </tr>
<?php }}?>
  <tr>
        <td width="4%"></td>
        <td width="3%"></td>
        <td width="4%"></td>
        <td width="5%" class="tg-iuhm"></td>
        <td width="4%"></td>
        <td width="5%"></td>
        <td width="3%" class="tg-iuhm"></td>
        <td width="3%" class="tg-iuhm"></td>
        <td width="3%" class="tg-iuhm"></td>
        <td width="5%" class="tg-iuhm">&nbsp;</td>
        <td width="5%" class="tg-iuhm"></td>
        <td width="3%" class="tg-iuhm"></td>
        <td width="4%" class="tg-iuhm"></td>
        <td width="3%" class="tg-iuhm"></td>
        <td width="5%" class="tg-iuhm"></td>
        <td width="5%" class="tg-iuhm" align="right"><?php echo number_format($subtotalidr,0); ?></td>
        <td width="3%" class="tg-iuhm"></td>
        <td width="4%" class="tg-iuhm" align="right"></td>
        <td width="5%" class="tg-iuhm" align="right"><?php echo number_format($subtotalrental,0); ?></td>
        <td width="5%" class="tg-iuhm" align="right"></td>
        <td width="6%" class="tg-iuhm" align="right"><?php echo number_format($subtotalservice,0); ?></td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="5%" class="tg-iuhm"></td>
        <td width="4%" class="tg-iuhm"></td>
  </tr>
</table>

  <br />
  <br />




</body>

</html>
