<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Virtual Account</title>
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
if(isset($result)){
foreach($result as $row){ 
      $timestamp = time();
      $now = date("Y-m-d H:i:s", $timestamp);
	  
?>  

<table width="753" border="0">
  <tr>
    <td width="626">Makassar : <?php echo $new_date = date('d F Y', strtotime($now));?></td>
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
    <td><b>Perihal : Konfirmasi Nomor Virtual Account</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="60">Dengan Hormat,</td>
  </tr>
  <tr>
    <td  align="justify">Sebelumnya kami ucapkan terimakasih atas kepercayaannya  untuk  bergabung dan bekerjasama  dengan kami,semoga kerjasama ini akan selalu berjalan lancar dan baik.</td>
  </tr>
    <tr>
    <td height="68" align="justify">Dalam rangka tertib administrasi keuangan di perusahaan kami, terhitung tanggal diterbitkannya surat ini maka kami beritahukan kembali rekening yang dipergunakan untuk pembayaran tenant "<?php echo $row->rekananshipping_name;?>" atas invoice atau tagihan sebagai berikut:</td>        
</table>
<table width="753" border="0">
  <tr>
    <td width="13">&nbsp;</td>
    <td width="27" align="center">&nbsp;</td>
    <td width="322" align="justify">Nama Tenant</td>
    <td width="19">:</td>
    <td width="350"><?php echo $row->rekanan_name;?> / <?php echo $row->rekananshipping_name;?></td>
  </tr>
  <tr>
    <td width="13">&nbsp;</td>
    <td width="27" align="center">&nbsp;</td>
    <td>Nama Bank</td>
    <td width="19">:</td>
    <td width="350">Bank Mega KCU Metro Tanjung Bunga</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left"><strong>Nomor Vitual Account (VA)</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left">Rental (Instalment)  dan Promotion Levy</td>
    <td>:</td>
    <td><?php echo $va_rental;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left">Service Charge</td>
    <td>:</td>
    <td><?php echo $va_sc;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left">Utilities (Listrik, Air dan Gas)</td>
    <td>:</td>
    <td><?php echo $va_utilities;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left">Advance Rental Payment (Down Payment)</td>
    <td>:</td>
    <td><?php echo $va_dp;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left">Security Deposit/Phone Deposit</td>
    <td>:</td>
    <td><?php echo $va_deposit;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left">Rental Casual Leasing</td>
    <td>:</td>
    <td><?php echo $va_outlet;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left">Rental (Sharing)</td>
    <td>:</td>
    <td><?php echo $va_sharing;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="753" border="0">
   <tr>
     <td align="justify"><p>Bersamaan dengan surat ini mohon untuk semua transsaksi pembayaran agar di informasikan melalui telp/wa Ibu Rifkha (rifkha.fadhila@transstudiomall.com) 085265158965.</p></td>
   </tr>
      <tr>
     <td colspan="5" align="justify">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="5" align="justify">Demikian yang dapat kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</td>
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
    <td><strong></strong></td>
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
    <td><?php echo $name;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $position;?></td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php }}?> 
</body>
</html>