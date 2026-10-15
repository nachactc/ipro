


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

<p>STATEMENT OF ACCOUNT</p>
<table width="942" border="0">
  <tr>
    <td width="155">Periode</td>
    <td width="381">:  s/d <?php echo $end_date; ?></td>
    <td width="130">Business Unit</td>
    <td width="258">:  <?php echo $region_name; ?></td>
  </tr>      
</table>

<table class="tg" width="944" border="0">
  <tr>
        <td width="13%" class="tg-li00">Store</td>
        <td width="17%" class="tg-li00">Tenant</td>        

        <td width="13%" align="right" class="tg-li00">Debit (IDR)</td>
        <td width="12%" align="right" class="tg-li00">Credit (IDR)</td>
        <td width="12%" align="right" class="tg-li00">Balance (IDR)</td>        
  </tr>
  </table>
<?php
$balance =0;
$totalbalance =0;
$grandtotalbalance =0;
$debit = 0;
$grandtotaldebit = 0;
$totaldebit = 0;
$kredit = 0;
$grandtotalkredit = 0;
$totalkredit = 0;

if(isset($resultH)){
foreach($resultH as $rowH){

?>


<?php
$balance =0;
$totalbalance =0;
$subtotalbalance =0;
$debit = 0;
$subdebit = 0;
$totaldebit = 0;
$kredit = 0;
$subkredit = 0;
$totalkredit = 0;
$agreementtype='X';
$agreementtype2='X';
$agreementprintouttype='';

if(isset($result)){
foreach($result as $row){
  if ($rowH->branchrekananline == $row->branchrekananline){
  $debit = $row->jurnaldetil_idr;
  $kredit = $row->jurnaldetil_idrOR;
  $balance = $debit - $kredit;  
  $totalbalance = $balance + $totalbalance;
  $totaldebit = $totaldebit + $debit;
  $totalkredit = $totalkredit + $kredit;    
  $subdebit = $subdebit + $debit;
  $subkredit = $subkredit + $kredit;
  $subbalance = $subdebit - $subkredit;   
  $grandtotaldebit = $grandtotaldebit +  $totaldebit;
  $grandtotalkredit = $grandtotalkredit + $totalkredit;
  $grandtotalbalance = $grandtotaldebit - $grandtotalkredit;
?>     
<?php }}}
?>
<table class="tg" width="944" border="0">
  <tr>
        <td width="13%" class="tg-iuhm"><?php echo $rowH->branch_name; ?></td>
        <td width="17%" class="tg-iuhm"><?php echo $rowH->rekanan_name; ?></td>        
        <td width="13%" align="right" class="tg-iuhm"><?php echo number_format($totaldebit,0); ?></td>
        <td width="12%" align="right" class="tg-iuhm"><?php echo number_format($totalkredit,0); ?></td>
        <td width="12%" align="right" class="tg-iuhm"><?php echo number_format($totalbalance,0); ?></td>        
  </tr>    

<?php }}?>
  <tr>
        <td width="13%"></td>
        <td width="17%">GRAND TOTAL</td>        
        <td width="13%" align="right" class="tg-iuhm"><?php echo number_format($grandtotaldebit,0); ?></td>
        <td width="12%" align="right" class="tg-iuhm"><?php echo number_format($grandtotalkredit,0); ?></td>
        <td width="12%" align="right" class="tg-iuhm"><?php echo number_format($grandtotalbalance,0); ?></td>        
  </tr> 
</table>  
</body>

</html>
