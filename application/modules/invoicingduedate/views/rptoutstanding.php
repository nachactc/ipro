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
	  $invdate = $row->schedulepaymentdetil_posteddate;
	  $duedate = date("Y-m-", strtotime($invdate));
	  $reminderdate1 = date("Y-m-", strtotime($invdate));
				if ($row->agreementtype_type == 'UTILITIES'){
					$duedate .= '15';
					$reminderdate1 .= '22';
				}
				else
				{
					$duedate .= '20';
					$reminderdate1 .= '27';
					}	  
?>  

<table width="753" border="0">
  <tr>
    <td width="626" align="right"></td>
  </tr>
  <tr>
    <td width="626">Depok : <?php echo $new_date = date('d F Y', strtotime($duedate));?></td>
  </tr>
  <tr>
    <td width="626" align="right"><?php echo $row->rekanan_name;?></td>
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
    <td><?php echo $row->rekananshipping_address;?></td>
    <td width="368" align="right"></td>
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
    <td><?php echo $row->agreement_shopunit;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>   
  <tr>
    <td align="center"><div align="center"><strong><u>PEMBERITAHUAN KETERLAMBATAN  PEMBAYARAN</u></strong></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="60">Dengan Hormat,</td>
  </tr>
  <tr>
    <td  align="justify"><p>Merujuk  kepada (a) Pasal 3.5 &amp; (b) Appendix II (Jadwal Pembayaran) Perjanjian Sewa  Menyewa, dengan ini disampaikan bahwa berdasarkan Laporan Keuangan kami,  terdapat tunggakan pembayaran sebesar <strong>(Rp. </strong><strong><?php echo number_format($totalOR,2);?>)</strong><strong>,-</strong> Outstanding  sampai dengan Tanggal <?php echo $new_date = date('d F Y', strtotime($duedate));?>,  keseluruhan tunggakan pembayaran terperinci sebagai terlampir.</p>
    <p>&nbsp;</p></td>
  </tr>
    <tr>
      <td  align="justify"><p>Sehubungan dengan hal  tersebut di atas,  dengan ini Bapak / Ibu diminta agar dapat segera menyelesaikan tunggakan <strong><em>dalam  jangka waktu </em></strong><strong><em>kerja  </em></strong><strong><em>(14) hari  terhitung tanggal surat ini dibuat atau sebelum tanggal (<?php echo date('d F Y', strtotime($duedate));?>).</em></strong></p>
      <p>&nbsp;</p></td>
   <tr>
      <td align="justify"><p>Untuk informasi lebih lanjut dan atau  rekonsiliasi  tunggakan tersebut,  dapat  menghubungi kami telp/wa Ibu  Kartika (<a href="mailto:kartika@transstudiomall.com">kartika@transstudiomall.com</a>) 0877-8003-8100, <a name="_GoBack" id="_GoBack"></a>Ibu Regitha (<a href="mailto:regitha.zavira@transstudiomall.com">regitha.zavira@transstudiomall.com</a>) 0896 1137 9140 dan  Bapak Agung (<a href="mailto:agung.wicaksono@transstudiomall.com">agung.wicaksono@transstudiomall.com</a>) 0878 7815 6248, Mohon surat ini  diabaikan apabila pihak Bapak/Ibu telah menyelesaikan tunggakan tersebut  diatas. </p></td>
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
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p>CC: BOD/TR/Cpl/CLgl<u></u></p></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php }}}?> 
</body>
</html>