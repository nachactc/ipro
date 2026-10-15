<?php  
  if ($button == 'EXCEL')
  {

	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: text/plain');
	//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename="."Interface PS - ".$region_name." - ".$branch_name.".txt");
		
  } 
 ?>
<title>Interface PS</title>
 
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
    # FILE NAME : <?php echo $filename; ?> IDSM02EXCIML101.FT</td>
  </tr>
  <tr>
    <td># FILE REFERENCE : <?php echo $filenamedetil; ?> IDSM02EXCIML101</td>
  </tr>
  <tr>
    <td># VERSION NUMBER : 1.00</td>
  </tr>  
  <tr>
    <td># GENERATION DATE : <?php echo $filenamedetil; ?> E08</td>
  </tr>        
    <td># CHARACTER SET : ENG</td>
  </tr>          
</table>


<table class="tg" width="1295" border="0">
  <tr>
        <td width="9%" class="tg-li00">JURNAL_ID</td>
        <td width="8%" class="tg-li00">CODE_EVENT</td>
        <td width="9%" class="tg-li00">CODE_SUB_EVENT</td>
        <td width="8%" class="tg-li00">CODE_VERSION</td>
        <td width="10%" class="tg-li00">ID_SYSTEM</td>
        <td width="9%" class="tg-li00">DATE_EXTRACTION</td>
        <td width="10%" class="tg-li00">BUSINESS_UNIT</td>        
        <td width="9%"class="tg-li00">BUSINESS_UNIT_AFFILIATE</td>
        <td width="9%"class="tg-li00">C4_ACTIVITY_LOCATION</td>
        <td width="10%" class="tg-li00">ID_DEPARTMENT</td>
        <td width="10%" class="tg-li00">CODE_AMOUNT</td>
        <td width="10%" class="tg-li00">ACCOUNT_PS</td>
        <td width="10%" class="tg-li00">DATE_ACCOUNTING</td>
        <td width="10%" class="tg-li00">CURRENCY_BASE;</td>
        <td width="10%" class="tg-li00">AMOUNT_DEBIT;</td>
        <td width="10%" class="tg-li00">AMOUNT_CREDIT;</td>
        <td width="10%" class="tg-li00">LEDGER_GROUP;</td>
        <td width="10%" class="tg-li00">DESCRIPTION;</td>
        <td width="10%" class="tg-li00">&nbsp;</td>
        <td width="10%" class="tg-li00">&nbsp;</td>
        <td width="10%" class="tg-li00">&nbsp;</td>
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
        <td width="9%" class="tg-iuhm"><?php echo $row->jurnal_id; ?></td>
        <td width="8%" class="tg-iuhm"><?php echo $row->CODE_EVENT; ?></td>
        <td width="9%" class="tg-iuhm"><?php echo $row->CODE_SUB_EVENT; ?></td>
        <td width="8%"  class="tg-iuhm"><?php echo $row->CODE_VERSION; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->ID_SYSTEM; ?></td>
        <td width="9%" class="tg-iuhm"><?php echo $row->DATE_EXTRACTION; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->BUSINESS_UNIT; ?></td>
        <td width="9%" class="tg-iuhm"><?php echo $row->BUSINESS_UNIT_AFFILIATE; ?></td>
        <td width="9%" class="tg-iuhm"><?php echo $row->C4_ACTIVITY_LOCATION; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->ID_DEPARTMENT; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->CODE_AMOUNT; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->ACCOUNT_PS; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->DATE_ACCOUNTING; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->CURRENCY_BASE; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->AMOUNT_DEBIT; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->AMOUNT_CREDIT; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->LEDGER_GROUP; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->DESCRIPTION; ?></td>
        <td width="10%" class="tg-iuhm">&nbsp;</td>
        <td width="10%" class="tg-iuhm">&nbsp;</td>
        <td width="10%" class="tg-iuhm"><?php echo $row->KET1; ?></td>
  </tr>  
<?php }}?>  
</table>
 
  <br />
  <br />
 

</body>

</html>
