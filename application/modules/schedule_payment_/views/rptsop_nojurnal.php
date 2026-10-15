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

<p>SCHEDULE OF PAYMENT</p>
<p>
  <?php
$totalidr = 0;
$totalidrinv = 0;
if(isset($resultH)){
foreach($resultH as $rowHeader){
	foreach($rowHeader as $rowH){

?>
</p>

<table width="1010" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="155">ID</td>
    <td width="333">:  <?php echo $rowH->schedulepayment_id; ?></td>
    <td width="57">Transaksi</td>
    <td width="447">:  <?php echo $rowH->transaksi_id; ?></td>
  </tr>
  <tr>
    <td width="155">Descr</td>
    <td width="333">:  <?php echo $rowH->schedulepayment_descr; ?></td>
    <td width="57">Ref</td>
    <td width="447">:  <?php echo $rowH->ref_id; ?></td>
  </tr>  
  <tr>
    <td width="155">Business Unit</td>
    <td width="333">:  <?php echo $rowH->region_name; ?></td>
    <td width="57">Store</td>
    <td width="447">:  <?php echo $rowH->branch_name; ?></td>
  </tr>  
  <tr>
    <td>Tenant</td>
    <td>:  <?php echo $rowH->rekanan_name; ?></td>
    <td>Brand</td>
    <td>: <?php echo $rowH->rekananshipping_name; ?></td>
  </tr>
  <tr>
    <td>Struktur unit</td>
    <td>: <?php echo $rowH->strukturunit_name; ?></td>
    <td>Ref ln</td>
    <td>: 0</td>
  </tr>      
</table>


 </br>

<table class="tg" width="1295" border="0">
  <tr>
        <td width="3%" class="tg-li00">Is Invoice</td>
        <td width="3%" class="tg-li00">Is posted</td>
        <td width="3%" class="tg-li00">Is Hold</td>
        <td width="12%" class="tg-li00">Descr</td>
        <td width="4%" class="tg-li00">Date</td>
        <td width="6%" class="tg-li00">Due Date</td>
        <td width="6%" class="tg-li00">IDR</td>
        <td width="6%" class="tg-li00">VAT</td>        
        <td width="6%"class="tg-li00">Ref LN</td>
        <td width="5%"class="tg-li00">BO ID</td>
        <td width="8%" class="tg-li00">Invoice</td>
        <td width="7%"class="tg-li00">Faktur Pajak</td>
        <td width="6%"class="tg-li00">Proforma By</td>
        <td width="6%"class="tg-li00">Proforma Date</td>
        <td width="6%"class="tg-li00">Post By</td>
        <td width="6%"class="tg-li00">Post Date</td>        
  </tr>
<?php

$idr = 0;
$idrinv = 0;
$subtotalidr = 0;
$subtotalidrinv = 0;
$balance =0;
$agreementtypename ='';
$agreementtypename2 ='XXX';
$agreementtypename3 ='';
$jurnal_id = '';
if(isset($result)){
foreach($result as $resultD){
	foreach($resultD as $row){
		if ($row->schedulepayment_id == $rowH->schedulepayment_id) {
  $idr = $row->schedulepaymentdetil_idr;
  $jurnal_id = $row->jurnal_id1;
  if ($row->jurnal_id2 !=''){
	$jurnal_id = $row->jurnal_id2;
  }
  if ($row->jurnal_id3 !=''){
	$jurnal_id = $row->jurnal_id3;
  }
  if ($row->jurnal_id4 !=''){
	$jurnal_id = $row->jurnal_id4;
  }  
  // else if ($row->jurnal_id2 ==''){
	// $jurnal_id = $row->jurnal_id3;
  // }
  $totalidr = $totalidr + $idr;
  $agreementtypename = $row->agreementtype_name;
	if ($agreementtypename3 == '') {
		$agreementtypename3 = $agreementtypename;
		}  	  
?>  


<?php 
if($agreementtypename != $agreementtypename3){	 
?>
  <tr>
        <td width="3%" class="tg-iuhm"></td>
        <td width="3%" class="tg-iuhm"></td>
        <td width="3%" class="tg-iuhm"></td>
        <td width="12%" align="right" class="tg-iuhm">SUBTOTAL</td>
        <td width="4%" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($subtotalidr,0); ?></td>
        <td width="6%" align="right" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"> </td>
        <td width="5%" class="tg-iuhm"> </td>
        <td width="8%" class="tg-iuhm"> </td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"></td>        
  </tr> 
<?php 
$subtotalidr =0;
}?>

<?php
if($agreementtypename != $agreementtypename2){
?>
  <tr>
        <td colspan="3" class="tg-iuhm"><?php echo $row->agreementtype_name; ?></td>
  </tr> 
<?php }?>
  
  <tr>
        <td width="3%" class="tg-iuhm"><?php echo $row->schedulepaymentdetil_ischecked; ?></td>
        <td width="3%" class="tg-iuhm"><?php echo $row->schedulepaymentdetil_isposted; ?></td>
        <td width="3%" class="tg-iuhm"><?php echo $row->schedulepaymentdetil_ishold; ?></td>
        <td width="12%" class="tg-iuhm"><?php echo $row->schedulepaymentdetil_descr; ?></td>
        <td width="4%" class="tg-iuhm"><?php echo $row->schedulepaymentdetil_date; ?></td>
        <td width="6%" class="tg-iuhm"><?php echo $row->schedulepaymentdetil_duedate; ?></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($row->schedulepaymentdetil_idr,0); ?></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($row->tax,0); ?></td>
        <td width="6%" class="tg-iuhm"><?php echo $row->ref_line; ?></td>
        <td width="5%" class="tg-iuhm"><?php echo $row->schedulepaymentdetil_boid; ?></td>
        <td width="8%" class="tg-iuhm"><?php echo $row->invoice_id; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->faktur_id; ?> </td>
        <td width="6%" class="tg-iuhm"><?php echo $row->schedulepaymentdetil_proformaby; ?></td>
        <td width="6%" class="tg-iuhm"><?php echo $row->schedulepaymentdetil_proformadate; ?></td>
        <td width="6%" class="tg-iuhm"><?php echo $row->schedulepaymentdetil_postedby; ?></td>
        <td width="6%" class="tg-iuhm"><?php echo $row->schedulepaymentdetil_posteddate; ?>
</td>        
  </tr>  
<?php
$subtotalidr = $subtotalidr + $idr;
$agreementtypename2 = $row->agreementtype_name;
$agreementtypename3 = $row->agreementtype_name;
 }}}
?>
  <tr>
        <td width="3%"></td>
        <td width="3%"></td>
        <td width="3%"></td>
        <td width="12%" align="right" class="tg-iuhm"> SUBTOTAL</td>
        <td width="4%"></td>
        <td width="6%"></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($subtotalidr,0); ?></td>
        <td width="6%" align="right" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"></td>
        <td width="5%" class="tg-iuhm"></td>
        <td width="8%" class="tg-iuhm">&nbsp;</td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"></td>        
  </tr>   

 
<?php }}}}?>
 <tr>
        <td width="3%"></td>
        <td width="3%"></td>
        <td width="3%"></td>
        <td width="12%" align="right" class="tg-iuhm"> TOTAL</td>
        <td width="4%"></td>
        <td width="6%"></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($totalidr,0); ?></td>
        <td width="6%" align="right" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"></td>
        <td width="5%" class="tg-iuhm"></td>
        <td width="8%" class="tg-iuhm">&nbsp;</td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"></td>
        <td width="6%" class="tg-iuhm"></td>        
  </tr> 
</table>
 

</body>

</html>
