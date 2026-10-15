<?php  
  if ($button == 'EXCEL')
  {

	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename=POS_vs_GL_".$startperiode."_".$endperiode.".xls");
  } 
 ?>
<title>SOP VS GL</title>
 
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
<p>SOP VS GL</p>
<table width="942" border="0">
  <tr>
    <td width="76">Periode</td>
    <td width="111">:  <?php echo $periode1; ?></td>
    <td width="32">s/d</td>
    <td width="705">:  <?php echo $periode2; ?></td>
  </tr>     
</table>


 </br>

<table class="tg" width="1295" border="0">
  <tr>
        <td width="9%" class="tg-li00">Schedule ID</td>
        <td width="6%" class="tg-li00">Posted Date</td>
        <td width="5%" class="tg-li00">Rekanan Name</td>
        <td width="5%" class="tg-li00">Shipping Name</td>
        <td width="5%" class="tg-li00">Agr Type</td>
        <td width="5%" class="tg-li00">IDR</td>
        <td width="5%" class="tg-li00">VAT</td>
        <td width="10%" class="tg-li00">Invoice ID</td>
        <td width="6%" class="tg-li00">Faktur ID</td>
        <td width="6%" class="tg-li00">Jurnal ID</td>
        <td width="6%" class="tg-li00">Book Date</td>
        <td width="12%" class="tg-li00">Desc</td>
        <td width="7%" class="tg-li00">Invoice Value</td>
        <td width="7%" class="tg-li00">Payment</td>
        <td width="6%" class="tg-li00">Ref ID</td>        
  </tr>
<?php

$idr = 0;
$vat = 0;
$payment=0;
$idrinv = 0;
$subtotalidr = 0;
$subtotalvat = 0;
$subtotalpayment = 0;
$subtotalidrinv = 0;
$balance =0;
if(isset($result)){
foreach($result as $row){
  	  $idr = $row->idr;
	  $vat = $row->vat;
	  $idrinv = $row->invoice;
	  $payment = $row->payment;
	  
	  $subtotalidr = $subtotalidr + $idr;
	  $subtotalvat = $subtotalvat + $vat;
	  $subtotalidrinv = $subtotalidrinv + $idrinv;
	  $subtotalpayment = $subtotalpayment + $payment;
?>  
  <tr>
        <td width="9%" class="tg-iuhm"><?php echo $row->sch; ?></td>
        <td width="6%" class="tg-iuhm"><?php 
                                $thn=date('Y',strtotime($row->schedulepaymentdetil_posteddate));
                                if ($thn<2000){
                                                echo "";
                                }else{
                                echo date('d-M-Y',strtotime($row->schedulepaymentdetil_posteddate)); 
                                }
                                ?>
</td>
        <td width="5%" class="tg-iuhm"><?php echo $row->rekanan_name; ?></td>
        <td width="5%" class="tg-iuhm"><?php echo $row->rekananshipping_name; ?></td>
        <td width="5%" class="tg-iuhm"><?php echo $row->_type; ?></td>
        <td width="5%" align="right" class="tg-iuhm"><?php echo number_format($row->idr,0); ?></td>
        <td width="5%" align="right" class="tg-iuhm"><?php echo number_format($row->vat,0); ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->invoice_id; ?></td>
        <td width="6%" class="tg-iuhm"><?php echo $row->faktur_id; ?></td>
        <td width="6%" class="tg-iuhm"><?php echo $row->jurnal_id; ?></td>
        <td width="6%" class="tg-iuhm"><?php 
                                $thn=date('Y',strtotime($row->jurnal_bookdate));
                                if ($thn<2000){
                                                echo "";
                                }else{
                                echo date('d-M-Y',strtotime($row->jurnal_bookdate)); 
                                }
                                ?>
</td>
        <td width="12%" class="tg-iuhm"><?php echo $row->jurnal_descr; ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->invoice); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->payment); ?></td>
        <td width="6%" class="tg-iuhm"><?php echo $row->ref_id; ?></td>
  </tr>  
<?php }}?>
  <tr>
        <td width="9%"></td>
        <td width="6%"></td>
        <td width="5%"></td>
        <td width="5%"></td>
        <td width="5%"></td>
        <td width="5%" align="right" class="tg-iuhm"><?php echo number_format($subtotalidr); ?></td>
        <td width="5%" align="right" class="tg-iuhm"><?php echo number_format($subtotalvat); ?></td>
        <td width="10%"></td>
        <td width="6%"></td>
        <td width="6%"></td>
        <td width="6%"></td>
        <td width="12%"></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($subtotalidrinv); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($subtotalpayment); ?></td>
        <td width="6%" align="right" class="tg-iuhm">&nbsp;</td>
  </tr>   
</table>
 
  <br />
  <br />
 
 

</body>

</html>
