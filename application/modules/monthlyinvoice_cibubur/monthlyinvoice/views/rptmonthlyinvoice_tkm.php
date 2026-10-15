


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
 
 <title>Monthly Invoice List</title>
 
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


<p>Monthly Invoice List</p>
<table width="942" border="0">
  <tr>
    <td width="155">Periode</td>
    <td width="381">:  <?php echo date('d-M-Y',strtotime($start_date)); ?>  s/d <?php echo date('d-M-Y',strtotime($end_date)); ?></td>
    <td width="130">Business Unit</td>
    <td width="258">:  <?php echo $region_name; ?></td>
  </tr>
  <tr>
    <td>Store</td>
    <td>:  <?php echo $branch_name; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>      
</table>


 </br>

<table class="tg" width="1025" border="0">
  <tr>
        <td width="3%" class="tg-li00">Store Code</td>
        <td width="4%" class="tg-li00">NPWP</td>        
        <td width="5%" class="tg-li00">Debtor Acct</td>
        <td width="7%" class="tg-li00">Debtor Name</td>
        <td width="7%" class="tg-li00">Brand</td>
        <td width="7%" class="tg-li00">Invoice ID</td>
        <td width="7%" class="tg-li00">TRX</td>
        <td width="7%" class="tg-li00">Tax Invoice No</td>       
        <td width="7%" class="tg-li00">Invoice Date</td>
        <td width="7%" class="tg-li00">Due Date</td>
        <td width="7%" class="tg-li00">Description</td>                                         
    	<td width="7%" align="right" class="tg-li00">Base Amount</td>
    	<td width="6%" align="right" class="tg-li00">Disc</td>
    	<td width="6%" align="right" class="tg-li00">Base Amount After Disc</td>
        <td width="6%" align="right" class="tg-li00">VAT Amount</td>
        <td width="6%" align="right" class="tg-li00">Total Amount</td>  
        <td width="6%" class="tg-li00">Deptor Type</td>
        <td width="6%" class="tg-li00">Shipping Type</td>        
        <td width="7%" class="tg-li00">Ref ID</td>
        <td width="7%" class="tg-li00">Jurnal ID</td>                                                       
  </tr>
<?php
$Base_Amount =0;
$VAT =0;
$VAT_Amount =0;
$Total_Amount = 0;
$total_Base_Amount =0;
$total_VAT_Amount = 0;
$total_Total_Amount = 0;  
$schedulepaymentdiscount_idr =0;
$Base_Amount_after_disc =0;
$total_schedulepaymentdiscount_idr =0;
$total_Base_Amount_after_disc =0;
if(isset($result)){
foreach($result as $row){
  $Base_Amount = $row->Base_Amount;
  $schedulepaymentdiscount_idr = $row->schedulepaymentdiscount_idr;
  $Base_Amount_after_disc =$Base_Amount - $schedulepaymentdiscount_idr;
  $VAT = $row->VAT_Amount;
  $VAT_Amount = ($Base_Amount_after_disc * $VAT) / 100;
  $Total_Amount = $Base_Amount_after_disc + $VAT_Amount;  
  $total_Base_Amount = $Base_Amount + $total_Base_Amount;
  $total_VAT_Amount = $VAT_Amount + $total_VAT_Amount;
  $total_Total_Amount = $Total_Amount + $total_Total_Amount;
  $total_schedulepaymentdiscount_idr =$total_schedulepaymentdiscount_idr + $schedulepaymentdiscount_idr;
  $total_Base_Amount_after_disc = $total_Base_Amount_after_disc + $Base_Amount_after_disc;
?>  
  <tr>
        <td width="3%" class="tg-iuhm"><?php echo $row->Store_Code; ?></td>
        <td width="4%" class="tg-iuhm"><?php echo $row->NPWP; ?></td>
        <td width="5%" class="tg-iuhm"><?php echo $row->Debtor_Acct; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->Debtor_Name; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->rekananshipping_name; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->Invoice_No; ?></td>                                        
    <td width="7%" class="tg-iuhm"><?php echo $row->trx; ?></td>        
        <td width="7%" class="tg-iuhm"><?php echo $row->Tax_Invoice_no; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo date('d-M-Y',strtotime($row->mDate)); ?></td>
        <td width="7%" class="tg-iuhm"><?php echo date('d-M-Y',strtotime($row->mDueDate)); ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->description; ?></td>                        
    <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($Base_Amount,0); ?></td>
    <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($schedulepaymentdiscount_idr,0); ?></td>
    <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($Base_Amount_after_disc,0); ?></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($VAT_Amount,0); ?></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($Total_Amount,0); ?></td> 
        <td width="6%" class="tg-iuhm"><?php echo $row->Debtor_type; ?></td>
        <td width="6%" class="tg-iuhm"><?php echo $row->rekananshipping_type; ?></td>        
        <td width="7%" class="tg-iuhm"><?php echo $row->ref_id; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->jurnal_id; ?></td>                 
  </tr>  
<?php }}?>
  <tr>
        <td width="3%" class="tg-iuhm"></td>
        <td width="4%" class="tg-iuhm"></td>
        <td width="5%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td>                                        
        <td width="7%" class="tg-iuhm"></td>        
        <td width="7%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td> 
    <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_Base_Amount,0); ?></td>
    <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($total_schedulepaymentdiscount_idr,0); ?></td>
    <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($total_Base_Amount_after_disc,0); ?></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($total_VAT_Amount,0); ?></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($total_Total_Amount,0); ?></td>  
        <td width="6%" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"></td>        
        <td width="7%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td>              
  </tr>   
</table>
  <br />
  <br />
  <br />

</body>

</html>
