<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>REMINDER</title>
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

<p>&nbsp;</p>
 <?php 
$totalOR =0;
if(isset($resultOR)){
foreach($resultOR as $OR) {
	foreach($OR as $rowOR ) {
		$totalOR = $rowOR->OR_amount;
	}
}}

if(isset($result)){
foreach($result as $invoice) {
//print_r($row); exit;
	$vnomorinv ='';
	$vnomorinv2 ='';	
	
	
	foreach($invoice as $row ) {
      $timestamp = time();
      $now = date("Y-m-d H:i:s", $timestamp);
	  $invdate = $row->duedate;
	  $duedate = date("Y-m-", strtotime($invdate));
	  $reminderdate1 = date("Y-m-", strtotime($invdate));
	   
	
				
?>  

<table width="753" border="0">
  <tr>
    <td width="312" align="left">No Reff. <?php echo $no_SP;?></td>
    <td width="312" align="right">(<?php echo $reminder;?>)</td>
  </tr>
  <tr>
    <td width="626" colspan="2"><?php echo $new_date = date('d F Y', strtotime($tanggal_SP));?></td>
  </tr>
  <tr>
    <td width="626" colspan="2" align="right"><?php echo $row->rekanan_name;?></td>
  </tr>  
</table>
<br />
<table width="753" border="0">
  <tr>
    <td width="100">Kepada Yth.</td>
    <td width="100">&nbsp;</td>
    <td width="100">&nbsp;</td>
    <td width="16">&nbsp;</td>
    <td width="251" align="right">&nbsp;</td>
    <td align="right"></td>
  </tr>
 </table>
 <table width="753" border="0">
  <tr>
    <td><b><?php echo $row->rekanan_namereport;?></b></td>
    <td width="368" align="right"><?php echo $row->rekananshipping_name;?></td>
  </tr>  
  <tr>
    <td colspan="2"><?php echo $row->rekananshipping_address;?></td>
   </tr>
 </table>
 <table width="753" border="0">  
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">attn : <?php echo $row->rekananshipping_contactname;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>   
  <tr>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>   
  <tr>
    <td align="center"><div align="center"><strong><u>PEMBERITAHUAN KETERLAMBATAN  PEMBAYARAN</u></strong></div></td>
  </tr>
  <tr>
    <td height="60">Dengan Hormat,</td>
  </tr>
  <tr>
    <td  align="justify"><p>Merujuk  kepada (a) Perjanjian Sewa  Menyewa No <?php echo $nola;?> tanggal <?php echo date('d F Y', strtotime($tglla));?> antara <?php echo $region_namereport;?> dan <?php echo $row->rekanan_namereport;?>, (b) Surat Peringatan II No <?php echo $no_SP_old;?> tanggal <?php echo date('d F Y', strtotime($tanggal_SP_old));?>, dengan ini disampaikan bahwa berdasarkan Laporan Keuangan kami,  terdapat tunggakan pembayaran sebesar <strong>Rp. </strong><strong><?php echo number_format($TotalAmount,2);?></strong><strong>,-</strong>   sampai dengan Tanggal <?php echo $new_date = date('d F Y', strtotime($tanggal_SP));?>,  keseluruhan tunggakan pembayaran terperinci sebagai terlampir.</p>
      <p>&nbsp;</p>
    <p>Ada pun total Outstanding yang sudah jatuh tempo adalah sebesar <strong>Rp <?php echo number_format($amount,2);?> </strong></p>
    <p>&nbsp;</p></td>
  </tr>
    <tr>
      <td  align="justify"><p>Sehubungan dengan hal  tersebut di atas,  dengan ini Bapak / Ibu diminta agar dapat segera menyelesaikan tunggakan <strong><em>dalam  jangka waktu </em></strong><strong><em>kerja  </em></strong><strong><em>(3) hari  terhitung tanggal surat ini dibuat atau sebelum tanggal (<?php echo date('d F Y', strtotime($tanggal_SP_new));?>).</em></strong></p>
      <p>&nbsp;</p></td>
    <tr>
    <td  align="justify"><p>Oleh karena telah terbit Surat Peringatan III  ini, maka Management PT. Trans Retail Indonesia berhak melakukan pemutusan  fasilitas utilitas (listrik, air dan gas) sampai dengan dilunasinya pembayaran  tertunggak dan Management PT. Trans Retail Indonesia tidak bertanggung jawab  atas segala kerusakan yang timbul akibat dari pemutusan fasilitas utilitas  tersebut.</p>
<p>&nbsp;</p></td>        
   <tr>
      <td align="justify"><p>Untuk informasi lebih lanjut dan atau  rekonsiliasi tunggakan tersebut, dapat menghubungi kami telp/wa <?php echo $usersp_name;?> (<?php echo $usersp_email;?>) <?php echo $usersp_telp;?>.</p>
      <p>Mohon  surat ini diabaikan apabila pihak Bapak/Ibu telah menyelesaikan tunggakan  tersebut diatas. </p></td>
   <tr>
     <td align="justify">&nbsp;</td>
</table>
 
<table width="753" border="0">
   <tr>
     <td align="justify"><p>Demikian yang dapat kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p></td>
   </tr>
      <tr>
     <td colspan="5" align="justify">&nbsp;</td>
   </tr>
</table>

<table width="753" border="0">
  <tr>
    <td width="355">Hormat kami,</td>
    <td width="37">&nbsp;</td>
    <td width="140">&nbsp;</td>
    <td width="203">&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $region_namereport;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><b></b></td>
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
    <td><?php echo $nameOS;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $positionOS;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p><em>CC:Finance&amp;Acc/TR/Leasing/Legal</em><u></u></p></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php }}}?> 
</body>
</html>