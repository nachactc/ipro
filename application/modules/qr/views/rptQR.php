<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>QRCode</title>

<style>


      page[size="A4"] {
      background:white;
      width:21cm;
      height:29.7cm;
      display:block;
      margin:3 auto;
      margin-bottom:3cm;
      box-shadow:0 0 0.5cm rgba(0,0,0,0.5);
      }

      @media print {
      body,page[size="A4"] {
      margin:0;
      box-shadow:0;
      }
      }

      td {
      font-family:Arial,Helvetica,sans-serif;
      font-size:12px;
      }
      
      td1 {
      
      border-right:2px solid #fff;      
      }
      
      
</style>
</head>

<body>
<?php
include "phpqrcode/qrlib.php"; //<-- LOKASI FILE UTAMA PLUGINNYA
//echo getcwd();
//$folder = basename(dirname(__FILE__));
$dir = dirname(__FILE__);
//echo $dir;
//exit;

//echo $tempdir;
//exit;
$tempdir = $dir . "/temp/"; //<-- Nama Folder file QR Code kita nantinya akan disimpan
//if (!file_exists($tempdir))#kalau folder belum ada, maka buat.
 //   mkdir($tempdir);
 
 #parameter inputan
$isi_teks = $qrid;//"segerr";
$namafile = $qrid . ".png";
$quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
$ukuran = 10; //batasan 1 paling kecil, 10 paling besar
$padding = 5;

//echo $namafile;

QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
 
?>
<br>
<table border="0" width="150">   
<tr>
<td width ="50" align="center"><table border="1">   
<tr>
<td  align="center">
   <img border="1" src="<?php echo base_url('application/modules/QR/views/temp/'.$namafile);?>" width="100" height="100">
</td>
</tr> 
<tr>
<td   align="center">
    <?php echo $rekanansipping_name; ?>
</td>
</tr> 
<tr>
<td   align="center">
	<?php echo date('d F Y',strtotime($start_date)); ?>
</td>
</tr> 
<tr>
<td   align="center">
	<?php echo date('d F Y',strtotime($end_date)); ?>
</td>
</tr> 
</table>
</td>
</tr>
</table>  
         
</body>
</html>