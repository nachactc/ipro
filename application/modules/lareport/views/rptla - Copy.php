<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
@font-face {
    font-family: 'tahoma'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/tahoma.ttf');?>'); /*URL to font*/
}
body {font-family: 'tahoma';font-size: 18pt}
@page { margin-left:4cm; margin-right:2.5cm; margin-top:1.5cm;margin-bottom:0.5cm;size:8.27in 11.69in;}

@font-face {
    font-family: 'arial'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/arial.ttf');?>'); /*URL to font*/
}
</style>
</head>
<body>
<?php
 if(isset($result)){
foreach($result as $row){ 
$pasunitname = '';
	  $pasunitsqm = 0;
	  foreach($vunit as $rowunit){ 
	  		$pasunitname .= $rowunit->unit_name. '&'; 
			$pasunitsqm =$rowunit->unit_sqm+$pasunitsqm; 
			

	  }
	  $vunitname = trim($pasunitname, "&");
	  $vunitsqm =$pasunitsqm;
	  ?> 
<div style="width:653px;height:100px;border:1px solid #000;">
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="103">&nbsp;</td>
    <td width="441" height="5px">&nbsp;</td>
    <td width="109">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt"><b>PERJANJIAN SEWA</b></td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">ANTARA</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
  </tr>
   <tr>
     <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt"><b><?php echo $row->region_namereport;?> </b></td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
   </tr>
   <tr>
     <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">DAN</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
   </tr>
   <tr>
     <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt"><b><?php echo $row->rekanan_name;?></b></td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
   </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt"><b><?php echo $row->rekananshipping_name;?></b></td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt" height="5">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt; border-top:1px solid">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt"><b>NO. <?php echo $nola;?></b></td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt; border-bottom:1px solid" >&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt"><b>PERJANJIAN SEWA</b></td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt"><b>APENDIK I</b></td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">DENAH LOKASI</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt"><b>APENDIK II</b></td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">SKEDUL PEMBAYARAN</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
  
   <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt"><b>APENDIK III</b></td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">STANDAR SPESIFIKASI</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
  
   <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt"><b>APENDIK IV</b></td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">KETENTUAN KHUSUS</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
  
    <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt"><b>EKSIBIT A</b></td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">SYARAT SYARAT SEWA PERJANJIAN SEWA MENYEWA</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
    <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
</table>
</div>
<div style="page-break-after: always; width:400" id="hal1">&nbsp;</div>
<table width="653" border="0" cellpadding="0" cellspacing="0" style="overflow: hidden">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="right">1/16</td>
  </tr>
</table>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt"><b><i><?php echo $row->rekananshipping_name;?></i></b></td>
  </tr>
</table>
<table width="653px" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="158" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td width="30" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td width="465" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
  </tr>
    <tr>
      <td style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td colspan="2" align="center" style="font-family: 'arial';font-size: 11pt;line-height:2"><b>PERJANJIAN SEWA MENYEWA</b></td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td height="24" colspan="2" align="center" style="font-family: 'arial';font-size: 11pt;line-height:2">Nomor: <?php echo $nola;?></td>
  </tr>
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="center">&nbsp;</td>
    <td style="font-family: 'arial';font-size: 11pt" align="center">&nbsp;</td>
    <td style="font-family: 'arial';font-size: 11pt" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="center">&nbsp;</td>
    <td style="font-family: 'arial';font-size: 11pt" align="center">&nbsp;</td>
    <td style="font-family: 'arial';font-size: 11pt" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="center">&nbsp;</td>
    <td colspan="2" align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2" >- PERJANJIAN SEWA ini (selanjutnya disebut sebagai “PERJANJIAN”) dibuat dan dilangsungkan pada tanggal ..(tanggal) ..(bulan) ..(tahun), oleh dan antara;-------------------------------------------------------------------------------------</td>
  </tr>
  <?php
  $tek="<b>$row->region_namereport</b>, suatu perseroan terbatas yang didirikan berdasarkan hukum Negara Republik Indonesia, yang berkantor pusat di <b>$row->region_address</b>;-----------------------------------------";

  ?>
  <tr>
    <td height="64" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td align="left" valign="top" style="font-family: 'arial';font-size: 11pt">I.</td>
    <td id="id1" valign="top"  align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2;"><?php echo $tek;?></td>
  </tr>
  <tr>
    <td height="64" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td align="left" valign="top" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2;" >(selanjutnya, berikut dengan pengganti atau penerima haknya, disebut &quot;<strong>Pemilik</strong>&quot;).--------------------------------------------------------------------------------</td>
  </tr>
  <tr>
    <td height="87" align="center" valign="top" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt">II.</td>
    <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2;"><p>
    <b><?php echo $row->rekanan_name;?></b>, suatu perseroan terbatas yang didirikan berdasarkan hukum Negara Republik Indonesia, yang berkantor pusat <?php echo $row->rekanan_address;?>, selaku pemilik <b><?php echo $row->rekananshipping_name;?></b> (selanjutnya, berikut dengan pengganti atau penerima haknya,disebut "<strong>Penyewa</strong>").<span style="column-width:auto">--------------------------------------------------------------------------------</span></p>
    </td>
  </tr>
  <tr>
    <td height="38" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Para penghadap dalam kedudukannya masing masing sebagaimana tersebut di atas dengan ini menyatakan hal-hal sebagai berikut:-----------------</td>
  </tr>
  <tr>
    <td height="132" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td colspan="2" align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2">-BAHWA, Pemilik adalah pengembang suatu komplek bangunan multi guna yang, sebagaimana yang direncanakan, setelah selesainya akan terdiri dari berbagai bangunan dan suatu bangunan pusat perbelanjaan eceran dengan fasilitas parkirnya, pengembangan dan perlengkapan lainnya sebagaimana yang dari waktu ke waktu ditetapkan atau dikembangkan oleh Pemilik, terletak di <?php echo $row->branch_name;?> (seluruhnya disebut “<strong>Kompleks</strong>”);-------------------------</td>
  </tr>
  <tr>
    <td height="113" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td colspan="2" align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2">-BAHWA, Pemilik telah membangun sebagian dari Kompleks yaitu berupa bangunan pusat perbelanjaan yang dikenal sebagai “Transmart” termasuk fasilitas parkir dan pengembangannya, baik yang berada di dalam maupun di luar bangunan yang khusus diperuntukan bagi bangunan pusat perbelanjaan tersebut sebagaimana yang dari waktu ke waktu ditetapkan oleh Pemilik (seluruhnya disebut “<strong>Mal</strong>”);---------------------</td>
  </tr>
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="center">&nbsp;</td>
    <td colspan="2" align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2">-BAHWA, Pemilik bermaksud untuk menyewakan kepada Penyewa dan Penyewa bermaksud untuk menyewa dari Pemilik sebagian dari Mal </td>
  </tr>
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="center">&nbsp;</td>
    <td style="font-family: 'arial';font-size: 11pt" align="left">&nbsp;</td>
    <td style="font-family: 'arial';font-size: 11pt" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="center">&nbsp;</td>
    <td style="font-family: 'arial';font-size: 11pt" align="left">&nbsp;</td>
    <td style="font-family: 'arial';font-size: 11pt" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="center">&nbsp;</td>
    <td colspan="2" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="center">&nbsp;</td>
    <td colspan="2" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="center">&nbsp;</td>
    <td colspan="2" align="center" style="font-family: 'arial';font-size: 11pt"><span style="font-family: 'arial';font-size: 9pt;line-height:2"><?php echo $nola;?></span></td>
  </tr>
</table>
<div style="page-break-after: always; width:400" id="hal2"></div>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="right" height="50" valign="top">2/16</td>
  </tr>
</table>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="169" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td colspan="4" align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2">sebagaimana yang didefinisikan disini sebagai "Ruang Sewa" berdasarkan ketentuan-ketentuan "Perjanjian Sewa Menyewa" ini dan "Syarat Syarat Sewa" yang menjadi lampirannya (termasuk seluruh Apendik, Eksibit dan Skedulnya seluruhnya disebut "Sewa Menyewa").--
    -KARENANYA, berdasarkan apa yang tersebut diatas Pemilik dan Penyewa setuju sebagai berikut:-------------------------------------------------------</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td colspan="4" align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-----------------------------------------Pasal 1-----------------------------------------------</strong></td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td colspan="4" align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-----------------------KESEPAKATAN SEWA MENYEWA--------------------------</strong></td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td colspan="4" align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2">-Pemilik dengan ini setuju untuk menyewakan dan Penyewa dengan ini setuju untuk menyewa sesuai dengan ketentuan Sewa Menyewa ini, ruang sewa sebagaimana dimaksud dalam Pasal 3.1. dan 3.2. Perjanjian Sewa Menyewa ini, berikut dengan peralatan tetap, perlengkapan dan tambahannya yang dibangun, ditanam atau dipasang di dalamnya oleh Pemilik, baik atas biaya Pemilik atau Penyewa (selanjutnya disebut “<strong>Ruang Sewa</strong>”), yang akan digunakan oleh Penyewa, sebagai penyewa, untuk selama jangka waktu sebagaimana tersebut dalam Pasal 3.3 Perjanjian Sewa Menyewa ini, beserta hak Penyewa untuk menggunakan secara bersama sama dengan Pemilik dan para penyewa dan penghuni lainnya di Mal serta setiap pihak manapun juga yang diwenangkan atau diijinkan oleh Pemilik, seluruh area di Mal terhadap mana Pemilik mengijinkan mereka untuk mendapatkan akses, termasuk pintu masuk Mal, “lobby”, kamar kecil, koridor, lorong, tangga, tempat menurunkan barang dan lift (seluruh area Mal, diluar bagian yang telah disewakan atau yang akan disewakan oleh Pemilik atau yang digunakan oleh Pemilik atau pihak yang bertindak atas nama Pemilik, selanjutnya secara keseluruhan disebut “<strong>Area Umum</strong>”).--------------------------------------------------------------------</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td colspan="4" align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-----------------------------------------------Pasal 2-----------------------------------------</strong></td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td colspan="4" align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-------------------TATA LAKSANA DOKUMENTASI SEWA MENYEWA-------</strong></td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td width="44" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">2.1.</td>
    <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Dokumentasi Sewa Menyewa ini terdiri dari tiga bagian dasar sebagai berikut:----------------------------------------------------------------</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
    <td width="29" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(a)</td>
    <td width="411" colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-<strong>Perjanjian Sewa Menyewa</strong> ini yang berisikan syarat syarat dan ketentuan ketentuan pokok berdasarkan mana Penyewa telah setuju menyewa Ruang Sewa dari Pemilik, dan lampirannya yang disebut sebagai <strong>Apendik I</strong> adalah <strong>Denah Lantai</strong> dari Ruang Sewa;--------------------------------------------------</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
    <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(b)</td>
    <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-<strong>Syarat Syarat Sewa</strong> yang merupakan lampiran dari Perjanjian Sewa Menyewa ini disebut sebagai <strong>Eksibit A </strong></td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
    <td align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
    <td colspan="2" align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td colspan="4" align="center" style="font-family: 'arial';font-size: 11pt;line-height:2"><span style="font-family: 'arial';font-size: 9pt;line-height:2"><?php echo $nola;?></span></td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td colspan="4" align="center" style="font-family: 'arial';font-size: 9pt;line-height:2">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
    <td align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
    <td colspan="2" align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
  </tr>
  
</table>
  <div style="page-break-after: always; width:400" id="hal3"></div>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="right" height="50" valign="top">3/16</td>
  </tr>
</table>
  <table width="653" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td width="171" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
    <td width="40" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
    <td width="34" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
    <td width="408" colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">yang berisikan hak dan kewajiban dari masing masing  Pemilik dan Penyewa, syarat syarat mana menjadi satu kesatuan dengan dan  merupakan bagian yang tidak terpisahkan dari Perjanjian Sewa Menyewa ini;  dan---------</td>
  </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(c)</td>
      <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-“<strong>Peraturan</strong>” yang merupakan lampiran dari Syarat Syarat Sewa disebut sebagai <strong>Skedul Ketiga</strong> yang berisikan tata tertib dengan mana Pemilik akan mengelola dan mengoperasikan Mal, Peraturan mana menjadi satu kesatuan dengan dan merupakan bagian yang tidak terpisahkan dari Perjanjian Sewa Menyewa ini.---------------------------------------------------------</td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2">2.2.</td>
      <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Syarat Syarat Sewa terdiri dari tiga Skedul sebagai berikut:------</td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(a)</td>
      <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-<strong>Skedul Pertama</strong> berisikan tata cara berdasarkan mana <strong>Uang Sewa</strong> (sebagaimana dimaksud dalam Pasal 3.5. Perjanjian Sewa Menyewa ini), <strong>Biaya Pelayanan</strong> (sebagaimana dimaksud dalam Pasal 3.6. Perjanjian Sewa Menyewa ini) dan jumlah lain yang wajib dibayar, harus dibayarkan;------------------</td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td align="justify" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(b)</td>
      <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-<strong>Skedul Kedua</strong> yang menjelaskan Utilitas dan <strong>Pelayanan</strong> (yang masing masing akan didefinisikan kemudian) yang disediakan oleh Pemilik;  dan---------------------------------------------</td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(c)</td>
      <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-<strong>Skedul Ketiga</strong> yang berisikan <strong>Peraturan</strong> sebagaimana tersebut di atas.--------------------------------------------------------------</td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">2.3. </td>
      <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Selain apa yang tersebut di atas, Penyewa dengan ini setuju untuk mengikatkan diri kepada dan mematuhi syarat syarat dan ketentuan <strong>ketentuan yang terdapat dalam Ketentuan dan Panduan Fitting-Out Ruang Sewa (“Tenancy Fitting-Out Guide and Rules</strong>”), apabila ada, <strong>Ketentuan dan Panduan Pembangunan Ruang Sewa (“Tenancy Construction Guide and Rules</strong>”), apabila ada, dan <strong>Panduan Penyewa</strong> (“<strong>Tenant’s Handbook</strong>”), apabila ada, termasuk kewajiban pembayaran yang dikenakan kepada Penyewa berdasarkan ketentuan tersebut, sebagaimana yang dapat diubah dari waktu ke waktu oleh Pemilik (seluruhnya disebut “<strong>Petunjuk</strong>”).--</td>
    </tr>

    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td colspan="4" align="center" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><span style="font-family: 'arial';font-size: 9pt;line-height:2"><?php echo $nola;?></span></td>
    </tr>
  </table>
  <div style="page-break-after: always; width:400" id="hal4"></div>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="right" height="50" valign="top">4/16</td>
  </tr>
</table>

  <table width="653" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="126" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td width="36" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">2.4.</td>
      <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Setiap terminologi yang didefinisikan dalam Perjanjian Sewa Menyewa ini dan Syarat Syarat Sewa mempunyai arti sebagaimana yang diberikan kepadanya dalam memahami seluruh Sewa Menyewa ini, demikian kecuali konteks kalimat memberikan arti lain.--------------------------------------------------------</td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td colspan="4" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-----------------------------------------Pasal 3-----------------------------------------</strong></td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td colspan="4" align="center" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><b>IKHTISAR SYARAT SYARAT DAN KETENTUAN KETENTUAN POKOK </b></td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td colspan="4" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>---------------------------------------SEWA MENYEWA-----------------------------</strong></td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td colspan="4" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Pemilik dan Penyewa dengan ini setuju bahwa penyewaan Ruang Sewa dilakukan berdasarkan syarat syarat dan ketentuan ketentuan pokok berikut ini, dan ketentuan ketentuan dalam Pasal 3 ini akan berlaku dalam hal terdapat pertentangan atau perbedaan antara ketentuan ketentuan yang terdapat dalam Pasal 3 ini dengan ketentuan lain dalam Sewa Menyewa ini.------------------------------------------------------------------------</td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.1.</td>
      <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-<strong>RUANG SEWA</strong> (sebagaimana yang ditandai dalam Denah Lantai terlampir pada Perjanjian Sewa Menyewa ini sebagai <strong>Apendik I</strong>):-----</td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">No. Unit:<?php echo $vunitname;?>;-------------------------------------------------------------</td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Lantai   : ..............;--------------------------------------------------------------</td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.2.</td>
      <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-LUAS------------------------------------------------------------------------------</strong>Kurang lebih <b><?php echo $vunitsqm;?></b> <strong>M2 ( <?php echo number_to_wordsnorp($vunitsqm);?> </strong><strong>Meter Persegi</strong>), dan tunduk kepada hasil pengukuran sebagaimana dimaksud dalam Pasal 1.1.3. dan Pasal 1.1.4. Syarat Syarat Sewa.---------------------------</td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.3.</td>
      <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>JANGKA WAKTU SEWA--------------------------------------------------
		<b><?php echo $row->loo_term;?></b></strong> tahun terhitung sejak Tanggal Mulai Sewa sebagaimana tersebut dalam Pasal 3.10. Perjanjian Sewa Menyewa ini.---------
	  -Jangka Waktu Sewa dapat diakhiri lebih awal oleh Pemilik dengan pemberitahuan secara tertulis sebelumnya kepada Penyewa, untuk menyesuaikan dengan Jangka Waktu Sewa atas <strong>Tanah Sewa</strong>, untuk menghilangkan keragu-raguan, yang dimaksud “<strong>Tanah Sewa</strong>” adalah tanah yang disewa oleh Pemilik dari pemilik tanah (“landlord”) untuk jangka waktu tertentu yang di atasnya berdiri Kompleks yang di dalam dan/atau sekitarnya terdapat RUANG SEWA.---------------- </td>
    </tr>

    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td width="81" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td width="410" colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
    </tr>
    <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td colspan="4" align="center" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><span style="font-family: 'arial';font-size: 9pt;line-height:2"><?php echo $nola;?></span></td>
    </tr>
</table>
     <div style="page-break-after: always; width:400" id="hal5"></div>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="right" height="50" valign="top">5/16</td>
  </tr>
</table>
  <table width="653" border="0" cellpadding="0" cellspacing="0">
     <tr>
      <td width="166" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
      <td width="43" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Para pihak sepakat bahwa Pemilik dapat mengakhiri perjanjian ini sebelum berakhirnya jangka waktu sewa tanpa kewajiban memberikan kompensasi dalam bentuk apapun kepada penyewa dalam hal Pemilik atau pihak yang ditunjuknya melakukan perombakan bentuk (remodeling) atas gedung, baik pada bagian luar (eksterior) maupun bagian dalam (interior), yang mengakibatkan reposisi tempat sewa.----------------------------</td>
    </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.4.</td>
       <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-PENGGUNAAN RUANG SEWA-----------------------------------------</strong></td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td width="35" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(a)</td>
       <td width="409" colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Ruang Sewa akan digunakan untuk kegiatan ........ dengan nama dagang ........;-----------------------------------------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(b)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Barang barang yang dijual oleh Penyewa adalah sebagaimana  daftar menu;------------------------------------------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(c)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Barang barang yang dijual tersebut harus sesuai dengan standar yang harus dijaga dan diawasi oleh Penyewa sebagai penjual yang bereputasi, dengan persetujuan dari Pemilik;--------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">	-Bagi Penyewa yang berada di lokasi Island, Foodcourt dan Pushcart dan/atau Foodcart, dilarang untuk menjual dan/atau mendisplay minuman kemasan dan/atau air mineral dengan merk dagang tertentu atau yang termasuk dalam produk Fast Moving Consumer Goods (FMCG) yang beredar di pasaran:---</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(d)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Penyewa bertanggung jawab untuk memperoleh seluruh persetujuan dan lisensi yang diperlukan (jika ada) dari pihak yang berwenang untuk menjual dan menyediakan barang barang tersebut atas biaya dan tanggungan Penyewa sepenuhnya;------------------------------------------------ </td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(e) </td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Setiap perubahan barang barang jualan, termasuk perinciannya, tunduk pada persetujuan tertulis Pemilik; dan-----</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(f)  </td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Penyewa diijinkan untuk mempergunakan seluruh Luas Sewa guna Penggunaan Ruang Sewa.---------------------------</td>
     </tr>
         <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(g)   </td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Pihak Penyewa menjamin kepada Pemilik bahwa bentuk dan rancang bangun stan (booth design) yang akan dibuat oleh Pihak Penyewa dalam rangka menjalankan usahanya di ruang sewa akan sesuai dengan estetika yang berlaku</td>
     </tr>
         <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
     </tr>
         <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
     </tr>
         <tr>
           <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
           <td colspan="4" align="center" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><span style="font-family: 'arial';font-size: 9pt;line-height:2"><?php echo $nola;?></span></td>
         </tr>
</table>
    <div style="page-break-after: always; width:400" id="hal6"></div>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="right" height="50" valign="top">6/16</td>
  </tr>
</table>
  <table width="653" border="0" cellpadding="0" cellspacing="0">
     <tr>
     <td width="163" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td width="46" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td width="35" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td width="409" colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">umum, dan produk-produk yang dipromosikan dan/atau diperjualbelikan oleh Pihak Penyewa telah memenuhi standard dan syarat-syarat sebagaimana diatur dalam  peraturan perundang-undangan yang berlaku dan bukanlah produk-produk yang melanggar kepatutan.---------</td>
    </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.5.</td>
       <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-UANG SEWA------------------------------------------------------------------</strong></td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(a)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">	 -Uang sewa sebesar Rp. <?php echo number_format($nilsewa,0);?>,- (<?php echo number_to_words($nilsewa);?>) ditambah dengan pajak pertambahan Nilai (“PPN”) untuk setiap meter persegi per bulan selama sejak Jangka Waktu Sewa;-------------------------------------------------------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(b)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Total uang sewa yang harus dibayarkan untuk selama <strong><b><?php echo $row->loo_term;?></b></strong> (<?php echo number_to_wordsnorp($row->loo_term);?>) tahun jangka waktu sewa menyewa adalah sebesar Rp. <?php echo number_format($nilsewatotal,0);?>,- (<?php echo number_to_words($nilsewatotal);?>) ditambah dengan Pajak Pertambahan Nilai (“PPN”) dibayarkan sebagai berikut:-----------------------------------------------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><?php echo $vpercentdp;?> persen ( .. %) uang muka dari total uang sewa berupa setoran tidak dapat dikembalikan sejumlah    Rp. 0,- ( .... Rupiah)  dibayarkan dalam .. (....) kali angsuran di muka yang sama sejumlah Rp. 0,- (..... Rupiah) ditambah dengan Pajak Pertambahan Nilai (“PPN”) dibayarkan pada saat penandatanganan Surat Kesepakatan Sewa Menyewa;------------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-	.... persen ( .. %) dari total uang sewa sejumlah Rp. 0,- (.... Rupiah)  ditambah dengan Pajak Pertambahan Nilai (“PPN”), dibayarkan dalam ... ( ... ) kali angsuran bulanan di muka yang sama sejumlah Rp. 0,- (..... Rupiah) sesuai dengan ketentuan yang berlaku, dimulai sejak Tanggal Mulai Sewa sesuai dengan tahapan pembayaran terlampir sebagai Apendik II.-----</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(c)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-LISTRIK----------------------------------------------------------------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Uang listrik dibayarkan berdasarkan pemakaian yang tercatat dalam meteran listik setiap bulannya yang ditambah biaya administrasi 10% dan ditambah dengan Pajak Pertambahan Nilai (“PPN”) setiap bulan, yang berlaku selama jangka waktu perjanjian. Pembayaran ini dilakukan sejak diberlakukannya perjanjian sewa.-----------------------------------------------------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td colspan="4" align="center" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><?php echo $nola;?></td>
     </tr>
</table>
     <div style="page-break-after: always; width:400" id="hal7"></div>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="right" height="50" valign="top">7/16</td>
  </tr>
</table>
  <table width="653" border="0" cellpadding="0" cellspacing="0">
     <tr>
         <td width="159" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td width="47" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.6.</td>
       <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-BIAYA PELAYANAN--------------------------------------------------------</strong></td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td width="35" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(a)</td>
       <td width="412" colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Biaya untuk mengoperasikan Mal (termasuk bagian pro-rata, sebagaimana yang ditetapkan oleh Pemilik, atas biaya untuk mengoperasikan fasilitas Kompleks yang peruntukkan bagi Mal), dibebankan kepada Penyewa (seluruhnya disebut “Biaya Pelayanan”) sebesar             <strong>Rp. 0,- ( .... Rupiah)</strong> untuk setiap meter persegi per 0 (...) bulan yang berlaku selama sejak Tanggal Mulai Sewa.------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(b)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Setelah itu, Biaya Pelayanan akan ditinjau setiap tahun sesuai dengan Skedul Pertama dari Syarat Syarat Sewa dan dibayarkan berdasarkan ketentuan-ketentuan diatur disana.---------------------------------------------------------------------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(c)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Biaya Pelayanan dibayarkan setiap 0 ( ... ) bulan dimuka dan pembayaran Biaya Pelayanan yang pertama kali harus dimulai sejak tanggal mulai sewa sesuai dengan tahapan terlampir sebagai Apendik II.----------------------------------------</td>
     </tr>
       <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.7.      </td>
       <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-PAJAK PERTAMBAHAN NILAI (“PPN”)------------------------------
		</strong></td>
     </tr>
       <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Uang Sewa dan Biaya Pelayanan tunduk kepada Pajak Pertambahan Nilai (“PPN”) sesuai dengan ketentuan yang berlaku dan dibayar oleh Penyewa.--------------------------------------</td>
     </tr>
       <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.8.</td>
       <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-SIMPANAN JAMINAN------------------------------------------------------</strong></td>
     </tr>
       <tr>
         <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
         <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
         <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Simpanan Jaminan yang wajib dibayarkan senilai 0 ( ... ) bulan Uang Sewa dan Biaya Pelayanan sebesar <strong>Rp. 0,- ( .... Rupiah)</strong> Simpanan Jaminan untuk disimpan serta digunakan sesuai dengan Skedul Pertama dari Syarat Syarat Sewa.-------------------</td>
       </tr>
       <tr>
         <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
         <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.9.</td>
         <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-UANG JAMINAN TELEPON----------------------------------------------</strong></td>
       </tr>
       <tr>
         <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
         <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
         <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(a)</td>
         <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">–Uang jaminan sejumlah <strong>Rp. 0,- ( ... Rupiah)</strong> untuk 0 ( ….) sambungan telepon ditambah biaya instalasi telepon sejumlah <strong>Rp. 0,- ( … Rupiah) </strong>untuk sambungan telepon yang disediakan oleh Pemilik kepada Penyewa hanya atas permintaan Penyewa yang dicantumkan dalam Berita Acara pemasangan sambungan telepon dan dibayarkan pada saat penandatanganan Perjanjian Sewa Menyewa ini, dan uang jaminan sebesar jumlah </td>
       </tr>
       <tr>
         <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
         <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
         <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
         <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       </tr>
       <tr>
         <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
         <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
         <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
         <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       </tr>
       <tr>
         <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
         <td colspan="4" align="center" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><?php echo $nola;?></td>
       </tr>
</table>
<div style="page-break-after: always; width:400" id="hal8"></div>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="right" height="50" valign="top">8/16</td>
  </tr>
</table>
  <table width="653" border="0" cellpadding="0" cellspacing="0">
     <tr>
     <td width="163" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
         <td width="35" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
         <td width="42" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
         <td width="413" colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">tersebut juga dibayar dalam hal Pemilik menyediakan setiap sambungan telepon tambahan kepada Penyewa;-</td>
    </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(b)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">–Uang jaminan telepon ini akan disimpan serta digunakan sesuai dengan Skedul Pertama dari Syarat Syarat Sewa.-------------------------------------------------------------------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.10.</td>
       <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-TANGGAL MULAI DAN BERAKHIRNYA SEWA------------------------</strong></td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(a)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">–Tanggal Mulai Sewa adalah salah satu dari, (i) tanggal berakhirnya jangka waktu fitting out sebagaimana dimaksud dalam Pasal 3.11 Perjanjian Sewa Menyewa atau,  (ii)  tanggal .<strong>.(tanggal) .. (bulan) .. (tahun)</strong> mana yang lebih dahulu terjadi, maka tanggal mulai Perjanjian Sewa Menyewa adalah tanggal <strong>..(tanggal) .. (bulan) .. (tahun);-------------------------------------</strong></td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(b)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">–<strong>Tanggal Berakhirnya Sewa Menyewa</strong> ini adalah tanggal setelah lewatnya waktu tertentu dari <strong>Tanggal Mulai Sewa</strong> / tanggal pembukaan yang disetujui pemilik yaitu tanggal ..<strong>(tanggal) .. (bulan) .. (tahun);----------------------- </strong></td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(c)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Pemilik memberikan 0 ( ... ) bulan masa bebas angsuran sewa atau grace period sebagai kompensasi atas pembukaan toko tepat waktu yang dilakukan oleh Penyewa, tetapi tidak termasuk Biaya Pelayanan (service charge);-----------------------------------------------------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(d)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"> Berbagai peristilahan yang menyebutkan Tanggal Pembukaan, Tanggal Resmi Pembukaan Mal dan/atau peresmian pembukaan Mal secara keseluruhan dalam perjanjian ini harus diartikan sebagai tanggal mulai sewa, dan meskipun pemilik dapat mengkonsultasikan dengan sebagian besar penyewa namun <strong>Tanggal Mulai Sewa</strong> sepenuhnya ditentukan oleh Pemilik;---------------------------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(e)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Pemilik akan mempromosikan melalui 2 (dua) kali pengiklanan yang dibuat secara menarik pada koran lokal terkenal di .... sebelum tanggal resmi pembukaan Mal dan penyampaian tanggal resmi pembukaan Mal untuk mengumumkan tanggal resmi pembukaan Mal secara keseluruhan atau dengan istilah lain dalam </td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
     </tr>
        <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
     </tr>
        <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td colspan="4" align="center" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><?php echo $nola;?></td>
     </tr>
</table>
<div style="page-break-after: always; width:400" id="hal9"></div>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="right" height="50" valign="top">9/16</td>
  </tr>
</table>
  <table width="653" border="0" cellpadding="0" cellspacing="0">
   <tr>
       <td width="163" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td width="35" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td width="46" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td width="409" colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">perjanjian Sewa Menyewa ini sebagai Tanggal Mulai Sewa sebagaimana dimaksud diatas; (Tidak Diberlakukan);------------------------------------------------------</td>
    </tr>
      <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(f)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Pemilik akan menyampaikan pemberitahuan secara tertulis dalam tenggang waktu 6 (enam) minggu sebelum jadwal tanggal resmi pembukaan Mal. Penyewa dengan ini setuju untuk bekerjasama dengan Pemilik dan penyewa Mal lainnya untuk mendukung rencana Tanggal resmi pembukaan Mal tersebut; dan---------------------------</td>
     </tr>
      <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(g)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Tanggal Mulai Sewa tidak dapat diperpanjang, demikian juga kewajiban Penyewa untuk membayar Uang Sewa, Biaya Pelayanan dan jumlah lain yang harus dibayar berdasarkan Sewa Menyewa ini tidak dapat ditunda sebagai akibat dari ketidakmampuan Penyewa untuk melakukan fitting-out dan/atau stocking-up Ruang Sewa sesuai dengan jangka waktu yang ditetapkan dalam Sewa Menyewa ini maupun Petunjuk.--------------------------</td>
     </tr>
     
      <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(h)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Jika Penyewa mengakhiri perjanjian sebelum masa sewa berakhir, wajib memberitahukan secara tertulis kepada Pemilik 2 (dua) bulan sebelumnya untuk mendapatkan persetujuan tertulis Pemilik.---------------------------------------</td>
     </tr>
      <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Penyewa mengetahui dan setuju bahwa Uang Sewa Pokok, Uang Muka, Simpanan Jaminan, dan Biaya Pelayanan yang sudah dibayarkan tidak dapat dikembalikan kepada Penyewa dan Penyewa menjamin tidak akan menuntut apapun kepada Pemilik. ---------------</td>
     </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Dalam hal terjadi pengakhiran perjanjian sebelum masa sewa berakhir, Penyewa tetap harus memenuhi seluruh kewajibannya di dalam perjanjian ini.---------------------------</td>
      </tr>
       <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.11.</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-JANGKA WAKTU FITTING-OUT DAN STOCKING-UP----------------</td>
      </tr>
       <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(a)</td>
        <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">–Pemilik akan menyampaikan pemberitahuan tertulis selambat lambatnya 2 (dua) minggu sebelum tanggal Penyewa dapat memulai fitting out Ruang Sewa mengenai: (i) tanggal kapan serah terima akan dilakukan dan Penyewa dapat mulai melakukan fitting-out Ruang </td>
      </tr>
       <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      </tr>
       <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      </tr>
       <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td colspan="4" align="center" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><?php echo $nola;?></td>
      </tr>
</table>
      <div style="page-break-after: always; width:400" id="hal10"></div>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="right" height="50" valign="top">10/16</td>
  </tr>
</table>
  <table width="653" border="0" cellpadding="0" cellspacing="0">
     <tr>
        <td width="163" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td width="35" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td width="46" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td width="409" colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Sewa (tanggal itu disebut sebagai “<strong>Tanggal Siap Serah</strong>”); dan (ii) memberikan Penyewa jangka waktu .. <strong>(...) minggu</strong> terhitung mulai Tanggal Siap Serah yang bebas sewa (“<strong>Jangka Waktu Fitting-Out</strong>”) untuk melakukan pekerjaan fitting-out dan stocking-up, termasuk untuk menyerahkan desain toko untuk persetujuan Pemilik;-------------------------------------------------</td>
    </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(b)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">–Pekerjaan fitting-out harus dikoordinasikan kepada Koordinator Penyewa yang ditetapkan oleh Pemilik dan harus sesuai dengan standar ketentuan dari Petunjuk Kriteria Desain Pembangunan Fit-Out Sewa;----------------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(c)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">–Dalam hal Ruang Sewa sudah siap dibuka untuk berdagang sebelum berakhirnya Jangka Waktu Fitting-Out, maka Penyewa wajib membuka Ruang Sewa untuk berdagang dan Uang Sewa serta Biaya Pelayanan harus dibayar sejak tanggal pembukaan tersebut;------------------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(d)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">–Selama Jangka Waktu Fitting-Out, Penyewa wajib melaksanakan dan menyelesaikan, atas biayanya sendiri, fitting-out dan stocking-up Ruang Sewa dan mempersiapkan Ruang Sewa untuk pembukaan usaha dengan cara yang berstandar professional sesuai dengan Perjanjian Sewa Menyewa ini dan Petunjuk;------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(e)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Penyewa mengakui bahwa Penyewa tidak berhak untuk memulai fitting-out dan stocking-up dan persiapan pekerjaan sampai dengan Penyewa memenuhi semua ketentuan ketentuan, syarat syarat dan kewajiban kewajiban dalam Perjanjian Sewa Menyewa ini dan Petunjuk dan bahwa terhitung sejak tanggal hari ini kunjungan Penyewa ke Ruang Sewa serta pelaksanaan pekerjaan fitting-out, stocking-up dan persiapan Ruang Sewa sepenuhnya menjadi resiko dan biaya Penyewa sendiri; dan------------------------------------------------------------</td>
     </tr>
     <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(f)</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">–Dalam hal Penyewa belum membuka Ruang Sewa untuk usahanya dan/atau belum mulai kegiatan usahanya dalam Ruang Sewa dalam waktu 30 (tiga puluh) hari kalender sejak berakhirnya Jangka Waktu fitting-Out, </td>
     </tr>
          <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
     </tr>
          <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
     </tr>
          <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
     </tr>
          <tr>
       <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td colspan="4" align="center" valign="top" style="font-family: 'arial';font-size: 9pt;line-height:2"><?php echo $nola;?></td>
     </tr>
</table>
      <div style="page-break-after: always; width:400" id="hal11"></div>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="right" height="50" valign="top">11/16</td>
  </tr>
</table>
  <table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
   <td width="163" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td width="35" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td width="46" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td width="409" colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Pemilik mempunyai hak untuk mengakhiri Sewa Menyewa ini secara sepihak dengan memberikan kepada Penyewa suatu pemberitahuan tertulis mengenai hal itu dan dalam hal ini: (i) semua uang yang telah diterima Pemilik akan menjadi milik Pemilik; dan (ii) Pemilik berhak untuk menyewakan Ruang Sewa kepada pihak lain yang dipilihnya sendiri dengan syarat syarat dan ketentuan ketentuan yang ditentukan oleh Pemilik tanpa mewajibkan Pemilik memberikan kompensasi kepada Penyewa.----------------------------------------------------</td>
    </tr>
     <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.12.</td>
       <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-SPESIFIKASI YANG DISEDIAKAN OLEH PEMILIK-------------------</strong></td>
    </tr>
      <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Pemilik akan menyerahkan Ruang Sewa kepada Penyewa pada Tanggal Siap Serah sesuai dengan spesifikasi standar tersebut dalam Apendik III terlampir, demikian dengan tunduk kepada Ketentuan Khusus, jika ada, sebagaimana ternyata dalam Pasal 3.13. Perjanjian Sewa Menyewa ini.--------------------</td>
    </tr>
      <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.13.</td>
       <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-KETENTUAN KHUSUS---------------------------------------------------------</strong></td>
    </tr>
      <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
       <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Lihat <strong>Apendik IV</strong> terlampir.-----------------------------------------------------</td>
    </tr>
      <tr>
      <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
       <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.14.</td>
       <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-MATA UANG PEMBAYARAN-------------------------------------------------</strong></td>
     </tr> <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-Uang Sewa, Biaya Pelayanan dan Jumlah Lain-----------------------</strong></td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Kecuali dinyatakan lain secara tegas dalam Perjanjian Sewa Menyewa ini, Uang Sewa, Biaya Pelayanan dan jumlah lain yang harus dibayar oleh Penyewa dalam mata uang Rupiah Indonesia (IDR).----------------------------------------------------------------------------------</td>
      </tr>
       <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Setelahnya, mata uang pembayaran ditentukan oleh Pemilik.---------</td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.15.</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">	-ALAMAT PENYEWA-------------------------------------------------------------</td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">UP 	    	: </td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">HP  	: </td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Email	:</td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.16.</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-NAMA DAN ALAMAT PEMEGANG SAHAM, KOMISARIS DAN DIREKSI  dalam hal ini Penyewa adalah Perusahaan)---------- </strong></td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-pemegang saham :---------------------------------------------------------</strong></td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">1.-----------------------------------------------------------------------------------</td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">2.-----------------------------------------------------------------------------------</td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td colspan="4" align="center" valign="top" style="font-family: 'arial';font-size: 9pt;line-height:2"><?php echo $nola;?></td>
      </tr>
      
</table>
     <div style="page-break-after: always; width:400" id="hal12"></div>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="right" height="50" valign="top">12/16</td>
  </tr>
</table>
  <table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
        <td width="163" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td width="35" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>- Dewan Komisaris :-------------------------------------------------------</strong></td>
    </tr>
       <tr>
        <td width="163" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td width="35" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>  - Komisaris Utama :---------------------------------------------------------</strong></td>
      </tr>
       <tr>
        <td width="163" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td width="35" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>  - Komisaris       :--------------------------------------------------------------</strong></td>
      </tr>
       <tr>
        <td width="163" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td width="35" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>  - Anggota Direksi :---------------------------------------------------------</strong></td>
      </tr>
       <tr>
        <td width="163" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td width="35" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>  - Direktur Utama  :-----------------------------------------------------------</strong></td>
      </tr>
        <tr>
        <td width="163" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td width="35" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong> - Direktur	     :---------------------------------------------------------------</strong></td>
      </tr>
        <tr>
        <td width="163" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td width="35" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>(TIDAK DIAPLIKASIKAN MENGINGAT PENYEWA ADALAH INDIVIDUAL)-----------------------------------------------------------------
</strong></td>
      </tr>
      
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.17</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-BIAYA PROMOSI-----------------------------------------------------------------</strong></td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td width="46" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(a)</td>
        <td width="409" colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(a)	-Penyewa dengan ini setuju untuk membayar suatu biaya promosi sebagai kontribusi Penyewa terhadap biaya untuk mempromosikan dan mengiklankan Mal dalam jumlah <strong>Rp 0,- ( ..... Rupiah)</strong> untuk setiap meter persegi per bulan yang dibayarkan secara bulanan dimuka terhitung sejak Tanggal Mulai Sewa.---------------------------</td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(b)</td>
        <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(b)	-Penyewa dengan ini setuju untuk memberikan berupa kontribusi sekali pembayaran sejumlah <strong>Rp. 0,- (.. Rupiah)</strong> untuk setiap meter persegi ruang sewa, dalam hal mana pembayaran tersebut dilakukan oleh seluruh penyewa secara bersama-sama untuk kepentingan pembayaran biaya promosi dan periklanan Grand Opening (pembukaan/tanggal mulai sewa seluruh ruang sewa penyewa secara bersama-sama). Pembayaran tersebut dilakukan selambat-lambatnya 2 (dua) minggu setelah tanggal pemberitahuan pelaksanaan fitting out ruang sewa.-----------------------------------------------------------</td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.18.</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>-PUNGUTAN TEMPAT MAKANAN-------------------------------------------</strong></td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Pihak kedua dikenakan Biaya Foodcourt Levy sebesar           <strong> Rp. 0,-/bulan (.... Rupiah)</strong> selama Jangka Waktu Kerjasama dan perpanjangannya, apabila ada ditambah dengan pajak Pertambahan Nilai ("<strong>PPN</strong>").------------------------------------------------</td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.19.</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong> -PENYELESAIAN SENGKETA------------------------------------------------</strong></td>
      </tr>
      <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(a)</td>
        <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Pemilik dan Penyewa setuju, kecuali sebagaimana ditentukan lain dalam Pasal 3.19.(j) di bawah ini, setiap sengketa yang timbul dari atau sehubungan dengan </td>
      </tr>
        <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      </tr>
        <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="2" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
      </tr>
        <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td colspan="4" align="center" valign="top" style="font-family: 'arial';font-size: 9pt;line-height:2"> <?php echo $nola;?></td>
      </tr> 
      
</table>
       <div style="page-break-after: always; width:400" id="hal13"></div>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="right" height="50" valign="top">13/16</td>
  </tr>
</table>
  <table width="653" border="0" cellpadding="0" cellspacing="0">
   <tr>
        <td width="162" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td width="37" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td width="49" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td colspan="5" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Perjanjian Sewa Menyewa ini, termasuk namun tidak terbatas kepada suatu masalah mengenai keberadaannya, keabsahan, pengakhiran, atau hak maupun kewajiban mereka masing masing, yang menurut pendapat masing masing pihak tidak dapat diselesaikan secara musyawarah, setelah pertama kali diungkapkan secara tertulis, akan diselesaikan pada tingkat akhir di arbitrase berdasarkan Aturan Arbitrase ("Aturan") Badan Arbitrase Nasional Indonesia ("BANI") dan ketentuan Pasal 3.19 ini.-</td>
      </tr>
       <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(b)</td>
        <td width="54" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(i)</td>
        <td colspan="4" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Arbitrase akan dilaksanakan di Jakarta di fasilitas BANI oleh tiga arbiter yang ditunjuk sebagai berikut:------------</td>
      </tr>
       <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td width="32" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(x)</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-masing masing pihak menunjuk 1(satu) arbiter-nya dalam jangka waktu 30 (tiga puluh) hari sejak pemberian pemberitahuan tertulis oleh satu pihak kepada pihak lainnya mengenai maksudnya untuk menyerahkan sengketa kepada arbitrase ("Pemberitahuan Arbitrase");--------------------</td>
      </tr>
       <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(y)</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-2(dua) arbiter yang telah ditunjuk akan menunjuk arbiter ketiga yang akan mengetuai dewan arbitrase dalam jangka waktu 30 (tiga puluh) hari terhitung dari tanggal Pemberitahuan Arbitrase, dan apabila mereka tidak dapat mencapai kesepakatan mengenai arbiter ketiga tersebut, arbiter ketiga akan ditunjuk oleh Ketua BANI sesuai dengan Aturan, dan ketiga arbiter yang telah ditunjuk tersebut akan merupakan suatu dewan arbitrase;-----</td>
      </tr>
             <tr>
        <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(z)</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Apabila salah satu pihak tidak dapat menunjuk arbiter-nya dalam jangka waktu yang ditetapkan, maka arbiter yang telah ditunjuk oleh suatu pihak akan duduk sebagai suatu dewan arbitrase.—--------------</td>
      </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(ii)</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Para arbiter boleh berkebangsaan apapun.--------</td>
             </tr>
    <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
             </tr>
              <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
             </tr>
              <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
                             <td colspan="7" align="center" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><?php echo $nola;?></td>
             </tr>
      </table>
      <div style="page-break-after: always; width:400" id="hal14"></div>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="right" height="50" valign="top">14/16</td>
  </tr>
</table>
  <table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
               <td width="162" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td width="38" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td width="50" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td width="42" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(iii)</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Arbitrase dilaksanakan dalam bahasa Indonesia.--------</td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(iv)</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Setiap pemberitahuan mengenai arbitrase, tanggapan atau komunikasi lain yang diberikan kepada atau oleh satu pihak dalam arbitrase harus dalam bahasa Indonesia dan harus disampaikan dan dianggap telah diterima sebagaimana ditentukan dalam Aturan.-------------</td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(c)</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(i)</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Para pihak setuju bahwa masing masing pihak tidak akan mengajukan suatu perkara hukum yang timbul dari atau sehubungan dengan Perjanjian Sewa Menyewa ini, kecuali:  (y) dalam hal menegakkan keputusan BANI disuatu pengadilan negeri yang berwenang;  dan (z) sebagaimana diatur dalam Pasal 3.19.(j) di bawah ini.----------------------------------------------------</td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(ii)</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Dalam hal suatu perkara hukum diajukan di suatu pengadilan guna menegakkan suatu keputusan arbitrase, pihak terhadap siapa keputusan arbitrase hendak ditegakkan harus membayar seluruh biaya, termasuk tetapi tidak terbatas kepada biaya penasihat hukum dari pihak yang hendak menegakkan keputusan arbitrase.-----------------------------------------------------</td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(d)</td>
               <td colspan="5" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Sambil menunggu pengajuan perkara ke arbitrase, selama proses arbitrase dan selanjutnya sampai BANI mengeluarkan keputusannya, Penyewa harus, terlepas dari sifat sengketa yang diajukan, membayar seluruh Uang Sewa, Biaya Pelayanan dan biaya serta jumlah lain yang harus dibayar berdasarkan Perjanjian Sewa Menyewa ini.-</td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(e)</td>               
               <td colspan="5" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Masing masing pihak harus menanggung setengah dari biaya dan imbalan BANI dan biaya arbitrase.-------------------</td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(f)</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(i)</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Semua keputusan BANI bersifat mengikat dan final terhadap masing masing pihak.------------------</td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(ii)</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Masing masing pihak dengan ini secara tegas setuju untuk mengesampingkan keberlakuan </td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td width="112" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td width="249" colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td colspan="7" align="center" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><?php echo $nola;?></td>
             </tr>
             </table>
             <div style="page-break-after: always; width:400" id="hal15"></div>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="right" height="50" valign="top">15/16</td>
  </tr>
</table>
  <table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
               <td width="162" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td width="38" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td width="49" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td width="44" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Pasal 631 R.V. (Reglement op de Rechtsvordering), dan karenanya dalam memutus perbedaan pendapat atau sengketa BANI terikat semata mata oleh peraturan perundang undangan yang berlaku, dan tidak boleh memutuskan perkara secara “ex aequo et bono” (berdasarkan rasa keadilan).-------------------</td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(iii)</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Kedua belah pihak selanjutnya setuju untuk mengesampingkan keberlakuan Pasal 641 R.V. dan, sepanjang dapat diterapkan, Pasal 15 dan Pasal 108 Undang Undang No.1 tahun 1950 (Peraturan Mahkamah Agung), demikian sehingga tidak boleh ada banding dan/atau kasasi pada suatu pengadilan hukum terhadap keputusan BANI, dan kedua belah pihak tidak boleh menggugat atau menolak tindakan pelaksanaan keputusan yang diambil oleh pihak yang dimenangkan oleh keputusan BANI.----------</td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(g)</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(i)</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Masing masing pihak dengan tegas setuju untuk mengesampingkan keberlakuan Pasal 650 ayat 2 R.V. demikian sehingga penunjukan arbiter tidak berakhir setelah enam (6) bulan terhitung dari tanggal penunjukannya.----------------------------------</td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(ii)</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Kewenangan dewan arbitrase yang dengan sah terbentuk sesuai dengan ketentuan Perjanjian Sewa Menyewa ini tetap berlaku sampai keputusan arbitrase final telah dikeluarkan oleh dewan arbitrase.-------------------------------------------</td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(h)</td>
               <td colspan="5" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Semua ketentuan Pasal 3.19 ini tetap berlaku sekalipun sewa menyewa berdasarkan Perjanjian Sewa Menyewa ini berakhir atau diakhiri sebelum waktunya oleh siapapun juga dan karena alasan apapun juga.-----------------------------</td>
             </tr>
                <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(i)</td>
               <td colspan="5" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">-Pemilik dan Penyewa dengan ini setuju dan menyatakan bahwa tidak dibayarnya oleh Penyewa Uang Sewa, Biaya Pelayanan dan biaya serta jumlah lain yang harus dibayar, atau pelanggaran janji lain oleh Penyewa, tidak dianggap </td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td width="36" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
             </tr><tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td colspan="3" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td colspan="7" align="center" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><?php echo $nola;?></td>
             </tr>

             </table>
              <div style="page-break-after: always; width:400" id="hal16"></div>
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="font-family: 'arial';font-size: 11pt" align="right" height="50" valign="top">16/16</td>
  </tr>
</table>
  <table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
               <td width="161" align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td width="38" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td width="50" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td colspan="5" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">sebagai sengketa mengenai penafsiran atau interpretasi Perjanjian Sewa Menyewa ini, dan pelaksanaan oleh Pemilik atas suatu hak, hak istimewa atau tindakan pemulihan hak dalam hal ketiadaan pembayaran atau pelanggaran janji tidak merupakan subyek dari arbitrase sebagaimana yang diatur pada Pasal 3.19 ini.-----------------</td>
                           </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(j)</td>
               <td colspan="5" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">(j)	-Tanpa membatasi sifat umum dari Pasal 3.19 ini mengenai penyelesaian sengketa melalui BANI, Penyewa setuju bahwa Pemilik memiliki hak, atas keputusan Pemilik sendiri, untuk memilih penyelesaian sengketa melalui badan peradilan yang berwenang.---------------------------------</td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">3.20.</td>
               <td colspan="6" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Akibatnya mengenai perjanjian ini dengan segala akibatnya, para pihak telah memilih tempat kediaman hukum yang umum dan tidak berubah di Kantor Kepaniteraan Pengadilan Negeri Jakarta Selatan  di Jakarta.------</td>
             </tr>
             <tr>
               <td align="center" valign="middle" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td colspan="7" align="justify" valign="middle" style="font-family: 'arial';font-size: 11pt;line-height:2"><hr /></td>
             </tr>
              <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td colspan="7" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2"><strong>DEMIKIANLAH</strong>, Para PIHAK telah menyebabkan PERJANJIAN untuk berlaku dan ditandatangani oleh para wakilnya yang berwenang, pada hari dan tahun sebagaimana di atas. PERJANJIAN ini ditandatangani dalam 2 (dua) naskah asli dan masing-masing PIHAK akan menyimpan satu salinan asli.</td>
             </tr>
               
              <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt" height="100">&nbsp;</td>
               <td colspan="7" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">PEMILIK</td>
             </tr>
              <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td colspan="7" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Nama    :</td>
             </tr>
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt"  height="40">&nbsp;</td>
               <td colspan="7" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Jabatan    :</td>
             </tr>
             
             <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt" height="100">&nbsp;</td>
               <td colspan="7" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">PENYEWA</td>
             </tr>
              <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt" height="80">&nbsp;</td>
               <td colspan="7" align="justify" valign="top" style="font-family: 'arial';font-size: 11pt;line-height:2">Nama    :</td>
             </tr>
              <tr>
               <td align="center" style="font-family: 'arial';font-size: 11pt">&nbsp;</td>
               <td colspan="7" align="center" valign="top" style="font-family: 'arial';font-size: 9pt;line-height:2"><?php echo $nola;?></td>
             </tr>
             
                        
             </table>
             <?php }}?> 
</body>
</html>