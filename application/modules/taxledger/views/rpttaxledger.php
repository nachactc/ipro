<?php  
  if ($button == 'EXCEL')
  {

	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename="."Tax Ledger - ".$region_name." - ".$branch_name.".xls");
  } 
 ?>
<title>TAX LEDGER</title>
 
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
<p>TAX LEDGER</p>
<table width="942" border="0">
  <tr>
    <td width="155">Business Unit</td>
    <td width="236">:  <?php echo $region_name; ?></td>
    <td width="154">Store</td>
    <td width="379">:  <?php echo $branch_name; ?></td>
  </tr>
  <tr>
    <td>Tenant</td>
    <td>:  <?php echo $rekanan_name; ?></td>
    <td>Brand</td>
    <td>: <?php echo $rekananshipping_name; ?></td>
  </tr>
  <tr>
    <td>Start Date</td>
    <td>: <?php echo date('d-M-Y',strtotime($startdate)); ?></td>
    <td>End Date</td>
    <td>: <?php echo date('d-M-Y',strtotime($enddate)); ?></td>
  </tr>      
</table>


 </br>

<table class="tg" width="1295" border="0">
  <tr>
        <td width="7%" class="tg-li00">Customer  ID</td>
        <td width="4%" class="tg-li00">Tenant</td>
        <td width="3%" class="tg-li00">No NPWP</td>
        <td width="3%" class="tg-li00">Alamat</td>
        <td width="3%" class="tg-li00">ID-Loc</td>
        <td width="4%" class="tg-li00">Outlet Name</td>
        <td width="5%" class="tg-li00">Description</td>
        <td width="6%" class="tg-li00">VAT No</td>        
        <td width="5%"class="tg-li00">Tax Invoice</td>  
        <td width="5%"class="tg-li00">Faktur Date</td>
        <td width="5%"class="tg-li00">WHT</td>
        <td width="6%" class="tg-li00">Rental</td>
        <td width="5%"class="tg-li00">SVC Chgs</td>
        <td width="6%"class="tg-li00">Utilitas</td>
        <td width="4%"class="tg-li00">Profit Sharing</td>
        <td width="5%"class="tg-li00">Promotion Levy</td>
        <td width="5%"class="tg-li00">Foodcourt Levy</td>
        <td width="6%"class="tg-li00">Umbul-umbul</td>
        <td width="5%"class="tg-li00">Others</td>
        <td width="6%"class="tg-li00">VAT</td>
        <td width="7%"class="tg-li00">Total Amount</td>
  </tr>
<?php

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

  $idr = $row->base_amount;
  //$vat = $idr * 11 / 100;
  $vat = $idr * $row->VAT_Amount / 100;
  $subtotalidr = $vat + $idr; 	
  $rental = $rental +  $row->rental;
  $svc_chgs = $svc_chgs +  $row->svc_chgs;
  $utilitas = $utilitas +  $row->utilitas;
  $profit_sharing = $profit_sharing +  $row->profit_sharing;
  $promotion_levy = $promotion_levy +  $row->promotion_levy;
  $foodcourt_levy = $foodcourt_levy +  $row->foodcourt_levy;
  $umbul_umbul = $umbul_umbul +  $row->umbul_umbul;
  $others = $others +  $row->others;
  $totalvat = $totalvat +  $vat;
  $totalidr = $totalidr +  $subtotalidr;
  
?>  
  <tr>
        <td width="7%" class="tg-iuhm"><?php echo $row->customer_id; ?></td>
        <td width="4%" class="tg-iuhm"><?php echo $row->tenant; ?></td>
        <td width="3%" class="tg-iuhm"><?php echo $row->NPWP; ?></td>
        <td width="3%" class="tg-iuhm"><?php echo $row->rekanan_taxaddress; ?></td>
        <td width="3%"  class="tg-iuhm"><?php echo $row->ID_loc; ?></td>
        <td width="4%" class="tg-iuhm"><?php echo $row->shop_name; ?></td>
        <td width="5%" class="tg-iuhm"><?php echo $row->descr; ?></td>
        <td width="6%" class="tg-iuhm"><?php echo $row->tax_invoice_no; ?></td>
        <td width="6%" class="tg-iuhm"><?php echo $row->invoice_id; ?></td>
        <td width="5%" class="tg-iuhm"><?php echo date('d-M-Y',strtotime($row->mDate)); ?></td>
        <td width="5%" class="tg-iuhm"><?php echo $row->wht; ?></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo  number_format($row->rental,0); ?></td>
        <td width="5%" align="right" class="tg-iuhm"><?php echo  number_format($row->svc_chgs,0); ?></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo  number_format($row->utilitas,0); ?></td>
        <td width="4%" align="right" class="tg-iuhm"><?php echo  number_format($row->profit_sharing,0); ?></td>
        <td width="5%" align="right" class="tg-iuhm"><?php echo  number_format($row->promotion_levy,0); ?></td>
        <td width="5%" align="right" class="tg-iuhm"><?php echo  number_format($row->foodcourt_levy,0); ?></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo  number_format($row->umbul_umbul,0); ?></td>
        <td width="5%" align="right" class="tg-iuhm"><?php echo  number_format($row->others,0); ?></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo  number_format($vat,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($subtotalidr,0); ?></td>
  </tr>  
<?php }}?>
  <tr>
        <td width="7%"></td>
        <td width="4%"></td>
        <td width="3%"></td>
        <td width="3%" align="right" class="tg-iuhm">&nbsp;</td>
        <td width="3%"></td>
        <td width="4%"></td>
        <td width="5%" align="right" class="tg-iuhm">&nbsp;</td>
        <td width="6%" align="right" class="tg-iuhm"></td>
        <td width="5%" class="tg-iuhm"></td>
        <td width="5%" class="tg-iuhm"></td>
        <td width="5%" class="tg-iuhm"></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo  number_format($rental,0); ?></td>
        <td width="5%" align="right" class="tg-iuhm"><?php echo  number_format($svc_chgs,0); ?></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo  number_format($utilitas,0); ?></td>
        <td width="4%" align="right" class="tg-iuhm"><?php echo  number_format($profit_sharing,0); ?></td>
        <td width="5%" align="right" class="tg-iuhm"><?php echo  number_format($promotion_levy,0); ?></td>
        <td width="5%" align="right" class="tg-iuhm"><?php echo  number_format($foodcourt_levy,0); ?></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo  number_format($umbul_umbul,0); ?></td>
        <td width="5%" align="right" class="tg-iuhm"><?php echo  number_format($others,0); ?></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo  number_format($totalvat,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($totalidr,0); ?></td>
  </tr>   
</table>
 
  <br />
  <br />
 

</body>

</html>
