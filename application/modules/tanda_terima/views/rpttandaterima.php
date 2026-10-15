<?php  
  if ($button == 'EXCEL')
  {
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename= tanda_terima_invoice.xls");
  } 
 ?>
<title>TANDA TERIMA</title>
  <style>
@font-face {
    font-family: 'arial'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/arial.ttf');?>'); /*URL to font*/
	src: url('<?php echo base_url('assets/css/loo/arialbd.ttf');?>'); /*URL to font*/
}
body {font-family: 'arial';font-size: 12pt}
@page { margin-left:3.5cm; margin-right:3cm; margin-top:3cm;margin-bottom:1cm;size:8.27in 11.69in;}
table, tr, td {
  font-family: 'arial';font-size: 14pt;
}

</style>

</head>
<br />

<body>


<p>

</p>
<p>&nbsp;</p>
<?php
$kodedep ='';
$pic ='';
$kodeaccount ='';
$region_name ='';
$region_senderinv ='';
if(isset($result)){
foreach($result as $tanda){
foreach($tanda as $row){		
$kodedep =$row->kodedept;
$pic =$row->pic;
$kodeaccount =$row->kodeaccount;
$region_name =$row->region_namereport;
$region_senderinv =$row->region_senderinv;
}}}
?>	
<table width="1295" >
<tr>
  <td>TANDA TERIMA NCS</td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>Kode Dept. Shopping Mall <?php echo $kodedep; ?>, PIC : <?php echo $pic; ?></td>
</tr>
<tr>
  <td>Kode Account : <?php echo $kodeaccount; ?></td>
</tr>
<tr>
  <td><?php echo $region_name; ?></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
</table>


 </br>

<table class="tg" width="1295" border="1">
  <tr>
        <td width="3%" class="tg-li00">No</td>
        <td width="18%" class="tg-li00">Nama Tenant</td>
        <td width="14%" class="tg-li00">Brand</td>
        <td width="22%" class="tg-li00">Alamat 1</td>
        <td width="11%" class="tg-li00">Contact Person</td>
        <td width="10%" class="tg-li00">Telepon</td>        
        <td width="14%"class="tg-li00">Contain 1</td>
        <td width="8%" class="tg-li00">Tgl Kirim</td>
  </tr>
<?php
$ket ='';
$inv_type ='';
$no = 0;
$timestamp = time();
$now = date("Y-m-d H:i:s", $timestamp);
if(isset($result)){
foreach($result as $tanda){	
foreach($tanda as $row){
$no = $no + 1;  
$inv_type = $row->invoice_type;
if ($inv_type =='INV')
{
	$ket ='Lembar Invoice dan Faktur Pajak ' . date('d F Y', strtotime($row->invoice_date)) . ' ' . $row->invoice_id;
	}	
else
{
	$ket ='Lembar Proforma Invoice ' . date('d F Y', strtotime($row->invoice_date)) . ' ' . $row->invoice_id;
	}  
?>  

  <tr>
        <td width="3%" class="tg-iuhm"><?php echo $no; ?></td>
        <td width="18%" class="tg-iuhm"><?php echo $row->rekanan_name; ?></td>
        <td width="14%" class="tg-iuhm"><?php echo $row->rekananshipping_name; ?></td>
        <td width="22%" class="tg-iuhm"><?php echo $row->rekananshipping_address; ?></td>
        <td width="11%" class="tg-iuhm"><?php echo  $row->contact_name; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->contact_telp; ?></td>
        <td width="14%" class="tg-iuhm"><?php echo $ket; ?></td>
        <td width="8%" class="tg-iuhm"><?php echo date('d F Y', strtotime($row->sent_date)); ?></td>
  </tr>  
  
<?php
 }}}
?>
  

 
 
</table>
<br>
<table width="1295" >
<tr>
  <td>Jakarta, <?php echo date('d F Y', strtotime($now)); ?></td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
<td><?php echo $region_senderinv; ?></td>
</tr>
</table>
</body>

</html>
