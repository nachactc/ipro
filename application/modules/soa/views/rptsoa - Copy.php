


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
 
 <title>Statement of Account</title>
 
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


<?php
$balance =0;
$totalbalance =0;
$debit = 0;
$totaldebit = 0;
$kredit = 0;
$totalkredit = 0;

if(isset($resultH)){
foreach($resultH as $rowH){

?>
<p>STATEMENT OF ACCOUNT</p>
<table width="942" border="0">
  <tr>
    <td width="155">Periode</td>
    <td width="381">:  s/d <?php echo $end_date; ?></td>
    <td width="130">Business Unit</td>
    <td width="258">:  <?php echo $region_name; ?></td>
  </tr>
  <tr>
    <td>Tenant</td>
    <td>:  <?php echo $rowH->rekanan_name; ?> (<?php echo $rowH->rekananshipping_name; ?>)</td>
    <td>Virtual Account</td>
    <td>: <?php echo $rowH->virtual_account; ?></td>
  </tr>
  <tr>
    <td>Address</td>
    <td>: <?php echo $rowH->rekanan_address; ?></td>
    <td>Cust No</td>
    <td>:  <?php echo $rowH->tenant_code; ?></td>
  </tr>
  <tr>
    <td>Telp</td>
    <td>: <?php echo $rowH->rekanan_telp; ?></td>
    <td>Print Date</td>
    <td>:  </td>
  </tr>
  <tr>
    <td>Fax</td>
    <td>: <?php echo $rowH->rekanan_fax; ?></td>
    <td>&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td>Attn</td>
    <td>: </td>
    <td>&nbsp;</td>
    <td></td>
  </tr>      
</table>


 </br>

<table class="tg" width="944" border="0">
  <tr>
        <td width="13%" class="tg-li00">Document Date</td>
        <td width="17%" class="tg-li00">Tax No</td>        
        <td width="33%" class="tg-li00">Document Description</td>
        <td width="13%" align="right" class="tg-li00">Debit (IDR)</td>
        <td width="12%" align="right" class="tg-li00">Credit (IDR)</td>
        <td width="12%" align="right" class="tg-li00">Balance (IDR)</td>        
  </tr>
<?php
$balance =0;
$totalbalance =0;
$debit = 0;
$totaldebit = 0;
$kredit = 0;
$totalkredit = 0;

if(isset($result)){
foreach($result as $row){
  if ($rowH->branchrekananline == $row->branchrekananline){
  $debit = $row->jurnaldetil_idr;
  $kredit = $row->jurnaldetil_idrOR;
  $balance = $debit - $kredit;  
  $totalbalance = $balance + $totalbalance;
  $totaldebit = $totaldebit + $debit;
  $totalkredit = $totalkredit + $kredit;
?>  
  <tr>
        <td width="13%" class="tg-iuhm"><?php echo date('d-M-Y',strtotime($row->schedulepaymentdetil_date)); ?></td>
        <td width="17%" class="tg-iuhm"><?php echo $row->invoice_id; ?></td>        
        <td width="33%" class="tg-iuhm"><?php echo $row->jurnal_descr; ?></td>
        <td width="13%" align="right" class="tg-iuhm"><?php echo number_format($debit,0); ?></td>
        <td width="12%" align="right" class="tg-iuhm"><?php echo number_format($kredit,0); ?></td>
        <td width="12%" align="right" class="tg-iuhm"><?php echo number_format($totalbalance,0); ?></td>        
  </tr>  
<?php }}}?>
  <tr>
        <td width="13%"></td>
        <td width="17%"></td>        
        <td width="33%"></td>
        <td width="13%" align="right" class="tg-iuhm"><?php echo number_format($totaldebit,0); ?></td>
        <td width="12%" align="right" class="tg-iuhm"><?php echo number_format($totalkredit,0); ?></td>
        <td width="12%" align="right" class="tg-iuhm"><?php echo number_format($totalbalance,0); ?></td>        
  </tr>   
</table>
  <br />
  <br />
  <br />
<?php }}?>

</body>

</html>
