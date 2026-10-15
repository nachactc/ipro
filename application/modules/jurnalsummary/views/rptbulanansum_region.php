<?php  
 /* if ($button == 'EXCEL')
  {

	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename=".$region_name." - ".$branch_name.".xls");
  } */
 ?>
 <html>
<head>
 <title>&nbsp;</title>
 <script src="<?php echo base_url('assets/plugins/jquery.min.js');?>" type="text/javascript"></script>
<style type="text/css">

.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-0rzf{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-ldj7{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:#000000;text-align:center;vertical-align:top}
.tg .tg-iuhmleft{font-size:10px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top; text-align:left}
.tg .tg-iuhm{font-size:10px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top; text-align:right}
.tg .tg-iuhmx{font-size:10px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top; text-align:right;background-color:#999999;}
.tg .tg-73lx{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;border-color:#000000;vertical-align:top}
.tg .tg-ur0i{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;text-align:center;vertical-align:top}
.tg .tg-vbnk{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;vertical-align:top}
.tg .tg-li00{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;background-color:#999999;border-color:#000000;text-align:center;vertical-align:top}
.head1{font-size:14px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
.head2{font-size:12px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
</style>


</head>
<br />

<body>
<table width="743" border="0">
  <tr>
    <td width="737">Laporan Summary Jurnal Bulanan By Region</td>
  </tr>
  <tr>
    <td>Per <?php echo date("d-M-Y",strtotime($tgl));?></td>
  </tr>      
</table>


 </br>

<table class="tg" width="752" border="0">
  <tr>
        <td width="59" height="24"  class="tg-li00">Account</td>
        <td width="182"  class="tg-li00">Description</td>        
        <td width="87"  class="tg-li00" style="text-align:right">Saldo Awal</td>  
        <td width="89"  class="tg-li00" style="text-align:right">Debet</td>
        <td width="102"  class="tg-li00" style="text-align:right">Kredit</td>
        <td width="87"  class="tg-li00" style="text-align:right">Mutasi</td>
        <td width="116"  class="tg-li00" style="text-align:right">Saldo Akhir</td>
                                                     
  </tr>

  <?php
if(isset($jsumbul_reg)){

$saldoawal=0;
$saldodebet=0;
$saldokredit=0;
$saldomutasi=0;
$saldoakhir=0;
foreach($jsumbul_reg as $row){
	?>
  <tr>
        <td height="27"  class="tg-iuhmleft"><?php echo $row->acc_id; ?></td>
        <td  class="tg-iuhmleft"><?php echo $row->acc_name; ?></td>
        <td class="tg-iuhm"><?php echo number_format($row->jurnalsaldoawal_idr,0); ?></td>
        <td  class="tg-iuhm"><?php echo number_format($row->jurnalsaldodebet_idr,0); ?></td>
        <td  class="tg-iuhm"><?php echo number_format($row->jurnalsaldokredit_idr*-1,0); ?></td>
        <td  class="tg-iuhm"><?php echo number_format($row->jurnalsaldomutasi_idr,0); ?></td>
        <td  class="tg-iuhm"><?php echo number_format($row->jurnalsaldoakhir_idr,0); ?></td>                                        
  </tr>
    
    <?php
$saldoawal=$saldoawal+$row->jurnalsaldoawal_idr;
$saldodebet=$saldodebet+$row->jurnalsaldodebet_idr;
$saldokredit=$saldokredit+$row->jurnalsaldokredit_idr*-1;
$saldomutasi=$saldomutasi+$row->jurnalsaldomutasi_idr;
$saldoakhir=$saldoakhir+$row->jurnalsaldoakhir_idr;
}
}?>

  <tr>
    <td height="31" colspan="2" class="tg-iuhm">&nbsp;</td>
    <td class="tg-iuhmx"><?php echo number_format($saldoawal,0);?></td>
    <td class="tg-iuhmx"><?php echo number_format($saldodebet,0);?></td>
    <td class="tg-iuhmx"><?php echo number_format($saldokredit,0);?></td>
    <td class="tg-iuhmx"><?php echo number_format($saldomutasi,0);?></td>
    <td class="tg-iuhmx"><?php echo number_format($saldoakhir,0);?></td>
  </tr>

</table>
<script>


</body>

</html>
