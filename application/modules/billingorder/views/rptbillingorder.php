<?php  
  if ($button == 'EXPORT')
  {

	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename= BILLING_ORDER.xls");
		
  } 
 ?>
<title>Billing Order</title>
 
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

<body>

<table width="942" border="0">
  <tr>
    <td>BILLING ORDER LIST</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>  
  <tr>
    <td>PERIODE : <span class="tg-iuhm"><?php echo date('d-M-Y',strtotime($startdate)); ?> s/d <?php echo date('d-M-Y',strtotime($enddate)); ?></span></td>
  </tr>        
    <td>&nbsp;</td>
  </tr>          
</table>


<table class="tg" width="1295" border="0">
  <tr>
        <td width="4%" class="tg-li00">NO</td>
        <td width="9%" class="tg-li00">BUSINESS UNIT</td>
        <td width="10%" class="tg-li00">STORE</td>
        <td width="10%" class="tg-li00">TENANT</td>
        <td width="10%" class="tg-li00">BRAND</td>
        <td width="9%" class="tg-li00">DATE</td>
        <td width="10%" class="tg-li00">TYPE</td>        
        <td width="8%"class="tg-li00">AMOUNT</td>
        <td width="14%"class="tg-li00">DESCR</td>
        <td width="8%" class="tg-li00">BOID</td>
        <td width="8%" class="tg-li00">REF ID</td>
  </tr>
<?php
$no =0;
$idr = 0;
$totalidr =0;
  
if(isset($result)){
foreach($result as $row){
	$idr = $row->schedulepaymentdetil_idr;
	$totalidr = $totalidr + $idr;
    $no = $no + 1;
?>  
  <tr>
        <td width="4%" class="tg-iuhm"><?php echo $no; ?></td>
        <td width="9%" class="tg-iuhm"><?php echo $row->region_name; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->branch_name; ?></td>
        <td width="10%"  class="tg-iuhm"><?php echo $row->rekanan_name; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->rekananshipping_name; ?></td>
        <td width="9%" class="tg-iuhm"><?php echo date('d-M-Y',strtotime($row->schedulepaymentdetil_date)); ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->agreementtype_name; ?></td>
        <td width="8%" class="tg-iuhm" align="right" ><?php echo number_format($row->schedulepaymentdetil_idr,0); ?></td>
        <td width="14%" class="tg-iuhm"><?php echo $row->schedulepaymentdetil_descr; ?></td>
        <td width="8%" class="tg-iuhm"><?php echo $row->schedulepayment_id . $row->schedulepaymentdetil_line; ?></td>
        <td width="8%" class="tg-iuhm"><?php echo $row->ref_id; ?></td>
  </tr>  
<?php }}?>  
  <tr>
        <td width="4%" class="tg-iuhm"></td>
        <td width="9%" class="tg-iuhm">TOTAL</td>
        <td width="10%" class="tg-iuhm"></td>
        <td width="10%"  class="tg-iuhm"></td>
        <td width="10%" class="tg-iuhm"></td>
        <td width="9%" class="tg-iuhm"></td>
        <td width="10%" class="tg-iuhm"></td>
        <td width="8%" class="tg-iuhm" align="right" ><?php echo number_format($totalidr,0); ?></td>
        <td width="14%" class="tg-iuhm"></td>
        <td width="8%" class="tg-iuhm"></td>
        <td width="8%" class="tg-iuhm"></td>
  </tr> 
</table>
 
  <br />
  <br />
 

</body>

</html>
