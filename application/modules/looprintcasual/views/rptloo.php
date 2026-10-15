<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
@font-face {
    font-family: 'arial'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/arial.ttf');?>'); /*URL to font*/
	src: url('<?php echo base_url('assets/css/loo/arialbd.ttf');?>'); /*URL to font*/
}
body {font-family: 'arial';font-size: 12pt}
@page { margin-left:3.5cm; margin-right:3cm; margin-top:3cm;margin-bottom:0.5cm;size:8.27in 11.69in;}
table, tr, td {
  font-family: 'arial';font-size: 12pt;
}

</style>
</head>
<body>
<table width="753" border="0">
  <tr>
    <td width="626" align="center"><img src="<?php echo base_url('assets/img/transmart.jpg');?>" width="268" height="41" ></td>
  </tr>
</table>
<p>&nbsp;</p>
 <?php 
 
  if(isset($result)){
	  $pasunitname = '';
	  $pasunitsqm = 0;
	  foreach($vunit as $rowunit){ 
	  		$pasunitname .= $rowunit->unit_name. '&'; 
			$pasunitsqm =$rowunit->unit_sqm+$pasunitsqm; 
			

	  }}
	  $vunitname = trim($pasunitname, "&");
	  $vunitsqm =$pasunitsqm;
   
 if(isset($result)){
foreach($result as $row){ ?>  
<table width="753" border="0">
  <tr>
    <td width="59">Ref No.</td>
    <td width="223"><?php echo $row->loo_id;?></td>
    <td width="73">&nbsp;</td>
    <td width="380" align="right"><?php echo $new_date = date('d F Y', strtotime($row->loo_date));?></td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td width="100">Kepada Yth.</td>
    <td width="16">&nbsp;</td>
    <td width="251" align="right">&nbsp;</td>
    <td align="right"><?php echo $row->branch_namerpt;?></td>
  </tr>\
  
  <tr>
    <td colspan="3"><b>Bapak/Ibu <?php echo $row->rekananshipping_contactname;?></b></td>
    <td width="368" align="right"><?php echo $row->rekananshipping_name;?></td>
  </tr>
  <tr>
    <td colspan="4"><b><?php 
	$rkn=substr($row->rekanan_name,0,2);
	$rkn=strtoupper($rkn);
	if ( (trim($rkn)=='PT') or (trim($rkn)=='CV') ){
			echo $row->rekanan_name;
	}else{
			echo $row->rekananshipping_name;
	}
	?></b></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">HP</td>
    <td valign="top">: </td>
    <td colspan="2" valign="top"><?php echo $row->rekanan_telp;?></td>
  </tr>
  <tr>
    <td valign="top">Email</td>
    <td valign="top">:</td>
    <td colspan="2" valign="top"><?php echo $row->rekanan_email;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><b>PERIHAL : SURAT KONFIRMASI SEWA "<?php echo $row->rekananshipping_name;?>" di <?php echo $row->branch_namerpt;?></b></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" height="60">Dengan Hormat,</td>
  </tr>
  <tr>
    <td colspan="4" align="justify">Sebelumnya kami ucapkan terima kasih atas kerjasama yang terjalin dengan baik dan semoga kerjasama ini dapat terus terjalin dengan baik.</td>
  </tr>
    <tr>
    <td height="68" colspan="4" align="justify">Melanjutkan pembicaraan dengan Bapak perihal penawaran sewa area exibhition, telah kami ajukan dan diskuksikan kembali dengan manajemen. Bersama surat ini kami sampaikan kondisi sewa terbaik yang dapat manajemen kami berikan:</td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td width="13">&nbsp;</td>
    <td width="27" align="center">1.</td>
    <td width="107">Level Unit</td>
    <td width="87">&nbsp;</td>
    <td width="11">:</td>
    <td width="482"><?php echo $row->lantai_name;?> /<?php echo $vunitname;?></td>
  </tr>
  <tr>
    <td width="13">&nbsp;</td>
    <td width="27" align="center">2.</td>
    <td width="107">Luas Area</td>
    <td width="87" align="right">&nbsp;</td>
    <td width="11">:</td>
    <td width="482"><?php echo $vunitsqm;?> M2</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">3.</td>
    <td colspan="2" align="left">Biaya Sewa</td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">4.</td>
    <td colspan="2" align="left">Total biaya sewa</td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">5.</td>
    <td colspan="2" align="left">Biaya Pelayanan</td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">6.</td>
    <td colspan="2" align="left">Biaya Utilitas</td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">7.</td>
    <td colspan="2" align="left">Periode sewa</td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">8.</td>
    <td colspan="2" align="left">Cara Pembayaran</td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">9.</td>
    <td colspan="2" align="left">Fit Out</td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">10.</td>
    <td colspan="2" align="left">Pembayaran</td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">11.</td>
    <td colspan="2" align="left">Nomor Rekening</td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">12.</td>
    <td colspan="2" align="left">Legalitas</td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">13.</td>
    <td colspan="2" align="left">Lainnya</td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <?php 
$ix=0;
foreach($vhargasewa as $rowsewa){ 
?>
  <?php 
$ix++;
} 

?>
  <?php 
$ino=3;
foreach($ritem as $rowitem){ 
if (trim($rowitem->agreementtype_name)!=='Electricity' and trim($rowitem->agreementtype_name)!=='Gas' and trim($rowitem->agreementtype_name)!=='Water'){ 
$vdes="";
}else{
$vdes=$rowitem->loodetil_descr;	
}
?>
  <?php if (trim($rowitem->agreementtype_name)!=='Electricity' and trim($rowitem->agreementtype_name)!=='Gas' and trim($rowitem->agreementtype_name)!=='Water'){ 
  ?>
  <?php } ?>
  
  
  
     <?php 
  $ino++;
}
?>
   <tr>
     <td>&nbsp;</td>
     <td align="center" valign="top">&nbsp;</td>
     <td colspan="4" valign="top" align="justify">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="6" align="justify">Apabila Bapak menyetujui penawaran kami di atas, mohon menandatangani surat ini untuk kami proses lebih `lanjut.</td>
   </tr>
      <tr>
     <td colspan="6" align="justify">Untuk informasi lebih lanjut silahkan menghubungi Sdri.Sandra di no HP 0813-17755270/0822-08256150 atau melalui email sandra_listiyanti@transretail.co.id</td>
   </tr>
   <tr>
     <td colspan="6" align="justify">Demikian yang dapat kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</td>
   </tr>
</table>

<table width="753" border="0">
  <tr>
    <td width="355">Hormat kami,</td>
    <td width="37">&nbsp;</td>
    <td width="140">&nbsp;</td>
    <td width="203">Menyetujui</td>
  </tr>
  <tr>
    <td><strong><?php echo $row->region_namereport ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><b><?php 
	$rkn=substr($row->rekanan_name,0,2);
	$rkn=strtoupper($rkn);
	if ( (trim($rkn)=='PT') or (trim($rkn)=='CV') ){
			echo $row->rekanan_name;
	}else{
			echo $row->rekananshipping_name;
	}
	?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong><u><?php echo $rgm['setting_name'];?></u></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
  </tr>
  <tr>
    <td><?php echo $rgm['setting_position'];?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="753" border="0">   
      <tr>
        <td ><strong><?php echo $row->region_namereport ?></strong></td>

      </tr>
      <tr>
        <td  align="justify">Head Office : Carrefour Lebak Bulus, 3rd Floor, Jl. Lebak Bulus Raya No. 8, Jakarta 12310</td>
      </tr>
      </tr>

</table>
<?php }}?> 
</body>
</html>