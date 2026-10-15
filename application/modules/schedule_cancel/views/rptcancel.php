<?php  
  if ($button == 'EXCEL')
  {

	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename= SCHEDULE_OF_PAYMENT_".$schedule_id.".xls");
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


<p>

</p>
<p>SCHEDULE OF PAYMENT CANCEL</p>

 


 </br>

<table class="tg" width="1295" border="0">
  <tr>
        <td width="5%" class="tg-li00">ID</td>
        <td width="5%" class="tg-li00">Line</td>
        <td width="14%" class="tg-li00">Descr</td>
        <td width="6%" class="tg-li00">Date</td>
        <td width="8%" class="tg-li00">IDR</td>
        <td width="8%" class="tg-li00">Ref ID</td>        
        <td width="8%"class="tg-li00">Ref Line</td>
        <td width="10%" class="tg-li00">Tenant</td>
        <td width="9%"class="tg-li00">Brand</td>
        <td width="9%"class="tg-li00">Store</td>
        <td width="14%"class="tg-li00">B. Unit</td>
        <td width="4%"class="tg-li00">Is Hold</td>
  </tr>
<?php

$idr = 0;
$idrinv = 0;
$subtotalidr = 0;
$totalidr=0;
$subtotalidrinv = 0;
$balance =0;
$agreementtypename ='';
$agreementtypename2 ='XXX';
$agreementtypename3 ='';
if(isset($result)){
foreach($result as $row){
  $idr = $row->schedulepaymentdetil_idr;
  $totalidr = $totalidr + $idr;
  	  
?>  

 
 
  
  <tr>
        <td width="5%" class="tg-iuhm"><?php echo $row->schedulepayment_id; ?></td>
        <td width="5%" class="tg-iuhm"><?php echo $row->schedulepaymentdetil_line; ?></td>
        <td width="14%" class="tg-iuhm"><?php echo $row->schedulepaymentdetil_descr; ?></td>
        <td width="6%" class="tg-iuhm"><?php echo date('d-M-Y',strtotime($row->schedulepaymentdetil_date)); ?></td>
        <td width="8%" align="right" class="tg-iuhm"><?php echo number_format($row->schedulepaymentdetil_idr,0); ?></td>
        <td width="8%" class="tg-iuhm"><?php echo $row->ref_id; ?></td>
        <td width="8%" class="tg-iuhm"><?php echo $row->ref_line; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->rekanan_name; ?></td>
        <td width="9%" class="tg-iuhm"><?php echo $row->rekananshipping_name; ?> </td>
        <td width="9%" class="tg-iuhm"><?php echo $row->branch_name; ?></td>
        <td width="14%" class="tg-iuhm"><?php echo $row->region_name; ?></td>
        <td width="4%" class="tg-iuhm"><?php echo $row->schedulepaymentdetil_ishold; ?></td>
  </tr>  
  
<?php
$subtotalidr = $subtotalidr + $idr;
 }}
?>
  <tr>
        <td width="5%"></td>
        <td width="5%"></td>
        <td width="14%" align="right" class="tg-iuhm"> SUBTOTAL</td>
        <td width="6%"></td>
        <td width="8%" align="right" class="tg-iuhm"><?php echo number_format($subtotalidr,0); ?></td>
        <td width="8%" align="right" class="tg-iuhm"></td>
        <td width="8%" class="tg-iuhm"></td>
        <td width="10%" class="tg-iuhm">&nbsp;</td>
        <td width="9%" class="tg-iuhm"></td>
        <td width="9%" class="tg-iuhm"></td>
        <td width="14%" class="tg-iuhm"></td>
        <td width="4%" class="tg-iuhm"></td>
  </tr>   

 
 
 <tr>
        <td width="5%"></td>
        <td width="5%"></td>
        <td width="14%" align="right" class="tg-iuhm"> TOTAL</td>
        <td width="6%"></td>
        <td width="8%" align="right" class="tg-iuhm"><?php echo number_format($totalidr,0); ?></td>
        <td width="8%" align="right" class="tg-iuhm"></td>
        <td width="8%" class="tg-iuhm"></td>
        <td width="10%" class="tg-iuhm">&nbsp;</td>
        <td width="9%" class="tg-iuhm"></td>
        <td width="9%" class="tg-iuhm"></td>
        <td width="14%" class="tg-iuhm"></td>
        <td width="4%" class="tg-iuhm"></td>
  </tr> 
</table>
 

</body>

</html>
