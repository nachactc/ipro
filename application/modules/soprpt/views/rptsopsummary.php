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
<title>SCHEDULE OF PAYMENT</title>
 
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

<p>SCHEDULE OF PAYMENT SUMMARY BY TENANT</p>
<table width="942" border="0">
  <tr>
    <td width="155">Business Unit</td>
    <td width="236">:  <?php echo $region_name; ?></td>
    <td width="154">Store</td>
    <td width="379">:  <?php echo $branch_name; ?></td>
  </tr>
  <tr>
    <td>Start Date</td>
    <td>: <?php echo date('d-M-Y',strtotime($startdate)); ?></td>
    <td>End Date</td>
    <td>: <?php echo date('d-M-Y',strtotime($enddate)); ?></td>
  </tr>      
</table>
<table class="tg" width="1295" border="0">
  <tr>
        <td width="15%" class="tg-li00">Tenant</td>
        <td width="8%" class="tg-li00">IDR</td>
        <td width="8%" class="tg-li00">VAT</td>
        <td width="11%" class="tg-li00">Invoice Value</td>
        <td width="11%" class="tg-li00">Balance</td>        
  </tr>

  <?php
$totalidr = 0;
$totalidrinv = 0;
$totaltax = 0;
if(isset($resultH)){
foreach($resultH as $rowH){

?>



<?php

$idr = 0;
$tax = 0;
$subtax = 0;
$idrinv = 0;
$subtotalidr = 0;
$subtotalidrinv = 0;
$balance =0;
if(isset($result)){
foreach($result as $row){
  if ($rowH->branchrekananline == $row->branchrekananline){
  $idr = $row->schedulepaymentdetil_idr;
  $tax = $row->tax;  
  $subtax = $subtax + $tax; 
  $subtotalidr = $subtotalidr + $idr; 
  $totalidr = $totalidr + $idr;
  $totaltax = $totaltax + $tax;  
  $totalidrinv = $totalidrinv + $idrinv;      
  if($row->invoice_id !=''){
	  $idrinv =$row->schedulepaymentdetil_idr;
	  }
  else {
	  $idrinv = 0;
	  }
  $subtotalidrinv = $subtotalidrinv + $idrinv;  
  $balance =$idr - $idrinv;	  
}}}?>  
  <tr>
        <td width="15%" class="tg-iuhm"><?php echo $rowH->rekanan_name; ?></td>
        <td width="8%" align="right" class="tg-iuhm"><?php echo number_format($subtotalidr,0); ?></td>
        <td width="8%" align="right" class="tg-iuhm"><?php echo number_format($subtax,0); ?></td>
        <td width="8%" align="right" class="tg-iuhm"><?php echo number_format($subtotalidrinv); ?></td>
        <td width="8%" align="right" class="tg-iuhm"><?php echo number_format($subtotalidr - $subtotalidrinv); ?></td>
  </tr> 
<?php }}?>
   
  <tr>
        <td width="15%">TOTAL</td>
        <td width="8%" align="right" class="tg-iuhm"><?php echo number_format($totalidr,0); ?></td>
        <td width="8%" align="right" class="tg-iuhm"><?php echo number_format($totaltax,0); ?></td>
        <td width="8%" align="right" class="tg-iuhm"><?php echo number_format($totalidrinv,0); ?></td>
        <td width="8%" align="right" class="tg-iuhm"><?php echo number_format($totalidr - $totalidrinv,0); ?></td>
  </tr>   
</table>
 
  <br />
  <br />

 

</body>

</html>
