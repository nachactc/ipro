<?php  
  if ($button == 'EXCEL')
  {

	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename="."Bukti potong - ".$region_name." - ".$branch_name.".xls");
  } 
 ?>
<title>Penerimaan Bukti Potong</title>
 
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
<p>Penerimaan Bukti Potong</p>
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
        <td width="4%" class="tg-li00">No.</td>
        <td width="17%" class="tg-li00">NAMA PERUSAHAAN</td>
        <td width="7%" class="tg-li00"> NPWP</td>
        <td width="7%" class="tg-li00">NOMOR BUKTI POTONG</td>
        <td width="8%" class="tg-li00">NOMOR FAKTUR PAJAK</td>
        <td width="7%" class="tg-li00">STORE</td>
        <td width="8%" class="tg-li00">JUMLAH BRUTO NILAI SEWA</td>
        <td width="9%" class="tg-li00">PPh YANG DIPOTONG</td>        
        <td width="8%"class="tg-li00">TGL FAKTU PAJAK</td>
        <td width="8%"class="tg-li00">TGL POTONG PPh</td>
        <td width="9%" class="tg-li00">TGL KE A/R DEP</td>
        <td width="8%"class="tg-li00">TB DATE</td>
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

  $idr = $row->jumlah_bruto;
  $vat = $row->pph_dipotong;
  $totalvat = $totalvat +  $vat;
  $totalidr = $totalidr +  $idr;
  $no = $no + 1;
?>  
  <tr>
        <td width="4%" class="tg-iuhm"><?php echo $no; ?></td>
        <td width="17%" class="tg-iuhm"><?php echo $row->rekanan_name; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->NPWP; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->Bukti_Potong; ?></td>
        <td width="8%"  class="tg-iuhm"><?php echo $row->faktur_id; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->branch_name; ?></td>
        <td width="8%" align="right" class="tg-iuhm"><?php echo number_format($row->jumlah_bruto,0); ?></td>
        <td width="9%" align="right" class="tg-iuhm"><?php echo number_format($row->pph_dipotong,0); ?></td>
        <td width="8%" class="tg-iuhm"><?php echo date('d-M-Y',strtotime($row->tgl_faktur)); ?></td>
        <td width="8%" class="tg-iuhm"><?php echo date('d-M-Y',strtotime($row->tgl_potong)); ?></td>
        <td width="9%" class="tg-iuhm"><?php echo  date('d-M-Y',strtotime($row->tgl_AR)); ?></td>
        <td width="8%" class="tg-iuhm"><?php echo  date('d-M-Y',strtotime($row->tgl_tb)); ?></td>
  </tr>  
<?php }}?>
  <tr>
        <td width="4%"></td>
        <td width="17%"></td>
        <td width="7%"></td>
        <td width="7%" align="right" class="tg-iuhm">&nbsp;</td>
        <td width="8%"></td>
        <td width="7%"></td>
        <td width="8%" align="right" class="tg-iuhm"><?php echo  number_format($totalidr,0); ?></td>
        <td width="9%" align="right" class="tg-iuhm"><?php echo  number_format($totalvat,0); ?></td>
        <td width="8%" class="tg-iuhm"></td>
        <td width="8%" class="tg-iuhm"></td>
        <td width="9%" align="right" class="tg-iuhm"></td>
        <td width="8%" align="right" class="tg-iuhm"></td>
  </tr>   
</table>
 
  <br />
  <br />
 

</body>

</html>
