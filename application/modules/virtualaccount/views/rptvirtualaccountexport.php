<?php  
  if ($button == 'EXCEL')
  {

	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: xls/plain');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename="."Virtual Account - ".$region_name." - ".$branch_name.".xls");
		
  } 
 ?>
<title>Virtual Account List</title>
 
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
<table class="tg" width="1295" border="0">
  <tr>
        <td width="9%" class="tg-li00">Virtual_Account_Number</td>
        <td width="8%" class="tg-li00">Virtual_Account_Name</td>
        <td width="9%" class="tg-li00">Escrow_Number</td>
        <td width="8%" class="tg-li00">Payment_Type</td>
        <td width="10%" class="tg-li00">rekanan_id</td>
        <td width="9%" class="tg-li00">rekananshipping_line</td>
  </tr>
<?php
$no =0;
$idr = 0;
$vat = 0;
$idrinv = 0;
$subtotalidr = 0;
$subtotalidrinv = 0;
$balance =0;
  $rental =0;
  $svc_chgs =0;
  $utilitas =0;
  $profit_sharing =0;
  $promotion_levy =0;
  $foodcourt_levy =0;
  $umbul_umbul =0;
  $others =0;
  $totalvat =0;
  $totalidr =0;
  
if(isset($result)){
foreach($result as $row){

  $no = $no + 1;
?>  
  <tr>
        <td width="9%" class="tg-iuhm"><?php echo $row->Virtual_Account_Number; ?></td>
        <td width="8%" class="tg-iuhm"><?php echo $row->Virtual_Account_Name; ?></td>
        <td width="9%" class="tg-iuhm"><?php echo $row->Escrow_Number; ?></td>
        <td width="8%"  class="tg-iuhm"><?php echo $row->Payment_Type; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->rekanan_id; ?></td>
        <td width="9%" class="tg-iuhm"><?php echo $row->rekananshipping_line; ?></td>
  </tr>  
<?php }}?>  
</table>
 
  <br />
  <br />
 

</body>

</html>
