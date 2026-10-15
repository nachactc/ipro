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
@page { margin-left:3cm; margin-right:1cm; margin-top:2.5cm;margin-bottom:1.5cm;size:8.27in 11.69in;}
table, tr, td {
  font-family: 'arial';font-size: 12pt;
}

</style>
</head>
<body>




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
    <td colspan="2" align="center"><img src="<?php echo base_url('assets/img/transmart.jpg');?>" width="268" height="41" ></td>
  </tr>
  <tr>
    <td width="581" align="right">&nbsp;</td>
    <td width="162" align="right" border='1'><?php echo $row->branch_namereport;?></td>
  </tr>
</table>
<p>&nbsp;</p>


<htmlpageheader name="myheader">
<div style="border-top: 0px solid #000000; font-size: 9pt; text-align: right; padding-top: 1mm; ">
<table width="753" border="0">
  <tr>
    <td width="581"><?php echo $row->number;?></td>
    <td width="162" align="right">{PAGENO}/{nb}</td>
  </tr>
</table>
</div>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<div style="border-top: 0px solid #000000; font-size: 7pt; text-align: center; padding-top: 3mm; ">
<?php echo $row->region_namereport.' - '.$row->region_address; ?>
</div>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" value="on" />


<?php
$rkn=PageNo();
?>

<table width="753" border="0">
  <tr>
    <td><?php echo $row->number;?></td>
    <td width="74">&nbsp;</td>
    <td width="379" align="right"></td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td width="100">Kepada Yth.</td>
    <td width="16">&nbsp;</td>
    <td width="343" align="right">&nbsp;</td>
    <td align="right"><?php echo $new_date = date('d F Y', strtotime($row->tanggal));?></td>
  </tr>
  
  <tr>
    <td colspan="3"><b><?php 
	$rkn=substr($row->rekanan_pt,0,2);
	$rkn=strtoupper($rkn);
	if ( (trim($rkn)=='PT') or (trim($rkn)=='CV') ){
			echo $row->kepada;
	}else{
			echo $row->rekanan_pt;
	}
	?></b></td>
    <td width="276" align="right"><?php echo $row->toko;?></td>
  </tr>
  <tr>
    <td colspan="4"><b><?php 
	$rkn=substr($row->rekanan_pt,0,2);
	$rkn=strtoupper($rkn);
	if ( (trim($rkn)=='PT') or (trim($rkn)=='CV') ){
			echo $row->rekanan_pt;
	}else{
			echo $row->alamat;
	}
	?></b></td>
  </tr>
  <tr>
    <td colspan="3" valign="top"><?php 
	$rkn=substr($row->rekanan_pt,0,2);
	$rkn=strtoupper($rkn);
	if ( (trim($rkn)=='PT') or (trim($rkn)=='CV') ){
			echo $row->alamat;
	}else{
			
	}
	?></td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">Telp.  </td>
    <td valign="top">: </td>
    <td colspan="2" valign="top"><?php echo $row->mobile;?></td>
  </tr>
  <tr>
    <td valign="top">Email</td>
    <td valign="top">:</td>
    <td colspan="2" valign="top"><?php echo $row->email;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center"><div align="center"><b><u>SURAT KESEPAKATAN SEWA MENYEWA</u></b></div></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><div align="center"><?php echo $row->toko;?>
    </div></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><div align="center">Unit <?php echo $row->unit;?>
    </div></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><div align="center"><?php echo $row->branch_area;?></div></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="justify">Bersama ini kami kirimkan Surat Kesepakatan Sewa Menyewa antara Transmart (PT Trans Retail Indonesia) dalam hal ini disebut sebagai pemilik dengan <?php echo $row->toko;?> (yang selanjutnya disebet Penyewa) di <?php echo $row->branch_area;?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Dalam Kesepakatan Sewa Menyewa ini, para pihak sepakat dengan ketentuan sebagai berikut :</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td width="31"><strong>1.</strong></td>
    <td width="9" align="center">&nbsp;</td>
    <td colspan="3"><strong><u>RUANG SEWA</u></strong></td>
    <td width="12" colspan="-1">:</td>
    <td width="482" colspan="-1"><em>sebagaimana ditandai pada denah terlampir</em></td>
  </tr>
  <tr>
    <td width="31">&nbsp;</td>
    <td width="9" align="center">&nbsp;</td>
    <td colspan="3">Lantai/Lokasi</td>
    <td width="12" colspan="-1">:</td>
    <td width="482" colspan="-1"><?php echo $row->lantai;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="3">Unit</td>
    <td colspan="-1">:</td>
    <td width="482" colspan="-1"><?php echo $row->unit;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>2.</strong></td>
    <td align="center">&nbsp;</td>
    <td colspan="3"><strong><u>LUAS</u></strong></td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5">Kurang lebih <?php echo $row->luas;?> m2</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5">Tunduk pada hasil pengukuran di lapangan dan akan menggunakan sistem pembulatan ke atas.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>3.</strong></td>
    <td align="center">&nbsp;</td>
    <td colspan="3"><strong><u>PERIODE SEWA</u></strong></td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5">Jangka Waktu Sewa adalah <?php echo $row->jangka;?> bulan, tanggal dimulainya periode sewa untuk unit di atas adalah salah satu dari : </td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td width="1">&nbsp;</td>
    <td width="37" align="center">&nbsp;</td>
    <td width="40" valign="top">a.</td>
    <td colspan="2">Berakhirnya <?php echo $row->fitting_out;?> hari periode fitting out atau;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">b. </td>
    <td width="657" colspan="2">Tanggal pembukaan unit adalah official pembukaan mall yang ditetapkan Pemilik yaitu tanggal <?php echo $new_date = date('d F Y', strtotime($row->startdate));?>, mana yang lebih dahulu terjadi</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">c.</td>
    <td colspan="2">Periode sewa dimulai dari tanggal <?php echo $new_date = date('d F Y', strtotime($row->startdate));?> dan berakhir pada tanggal <?php echo  $new_date = date('d F Y', strtotime($row->enddate));?></td>
  </tr>
  <tr>
    <td rowspan="2">&nbsp;</td>
    <td rowspan="2" align="center">&nbsp;</td>
    <td valign="top">d.</td>
    <td colspan="2" rowspan="2">Apabila Penyewa membuka toko tepat waktu sesuai dengan tanggal yang ditetapkan Pemilik, Penyewa diberikan masa bebas angsuran sewa (grace periode) selama <?php echo $row->grace_periode;?> (<?php echo number_to_wordsnorp(number_format($row->grace_periode,0));?>) bulan<br /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
<table width="753" border="0">  
  <tr>
    <td width="27"><strong>4.</strong></td>
    <td width="16" align="center">&nbsp;</td>
    <td colspan="5"><strong><u>PENGGUNAAN RUANG SEWA</u></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify"><div align="justify">Ruang Sewa akan digunakan untuk <?php echo $row->dagangan;?> dengan nama dagang <?php echo $row->toko;?>. Barang-barang yang dijual tersebut harus sesuai dengan standard yang harus dijaga dan diawasi oleh Penyewa sebagai penjual yang telah memiliki reputasi baik dan dengan persetujuan Pemilik. Penyewa dilarang untuk menjual dan/atau mendisplay minuman dalam kemasan dan/atau air mineral dengan brand atau merek dagang tertentu seperti produk Fast Moving Consumer Goods (FMCG) yang beredar di pasaran.</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">Penyewa bertanggung jawab untuk memperoleh seluruh perizinan dan lisensi yang diperlukan (jika ada) dari pihak berwenang untuk menjual dan menyediakan barang-barang asli (original) tersebut atas biaya dan tanggung jawab Penyewa sepenuhnya. Setiap perubahan barang barang jualan, termasuk perinciannya, tunduk pada persetujuan tertulis Pemilik.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="424" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>5.</strong></td>
    <td align="center">&nbsp;</td>
    <td colspan="5"><strong><u>UANG SEWA</u></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify"><div align="justify">Uang Sewa adalah sebesar Rp. <?php echo number_format($row->uang_sewa,0);?> (<?php echo number_to_wordsnorp($row->uang_sewa);?> Rupiah) per meter persegi per bulan, ditambah Pajak Pertambahan Nilai (PPN). Total Uang Sewa yang harus dibayarkan selama <?php echo $row->jangka;?> (<?php echo number_to_wordsnorp($row->jangka);?>) bulan jangka waktu sewa menyewa adalah sebesar Rp. <?php echo number_format($row->total_sewa,0);?> (<?php echo number_to_wordsnorp($row->total_sewa);?> Rupiah) dibayarkan dengan detail sebagai berikut: </div></td>
  </tr>
</table>
<table width="753" border="0">  
  <tr>
    <td width="47">&nbsp;</td>
    <td width="34" valign="top">a.</td>
    <td colspan="2">&nbsp;</td>
    <td width="644" colspan="3" align="justify"><div align="justify"><?php echo number_format($row->DP_percent,0);?>% (<?php echo number_to_wordsnorp(number_format($row->DP_percent,0));?> persen) berupa pembayaran di muka yang tidak dapat dikembalikan sejumlah Rp. <?php echo number_format($row->DP_value,0);?> (<?php echo number_to_wordsnorp($row->DP_value);?> Rupiah ) dibayarkan dalam <?php echo number_format($row->jml_DP,0);?> (<?php echo number_to_wordsnorp($row->jml_DP);?>) kali angsuran yang sama sebesar Rp. <?php echo number_format($row->angsuran_DP,0);?> (<?php echo number_to_wordsnorp($row->angsuran_DP,0);?> Rupiah) ditambah Pajak Pertambahan Nilai (PPN) dibayarkan pada saat penandatanganan Surat Kesepakatan Sewa Menyewa sesuai dengan Jadwal Pembayaran sebagaimana akan dicantumkan dalam Apendik II Surat Kesepakatan Sewa Menyewa dan Perjanjian Sewa Menyewa.</div></td>
  </tr>
  <tr>
    <td rowspan="2">&nbsp;</td>
    <td rowspan="2" valign="top">b.</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3" rowspan="2" align="justify"><?php echo number_format($row->sisa_percent,0);?> % (<?php echo number_to_wordsnorp($row->sisa_percent);?> persen) sisa Biaya Sewa keseluruhan sejumlah Rp. <?php echo number_format($row->sisa_total_sewa,0);?> (<?php echo number_to_wordsnorp($row->sisa_total_sewa);?> Rupiah) dibayarkan dalam <?php echo number_format($row->sisa_jangka,0);?> (<?php echo number_to_wordsnorp($row->sisa_jangka);?>) kali angsuran dengan detail sebagai berikut :</td>
  </tr>
</table>
<table width="753" border="0">  
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="22">&nbsp;</td>
    <td width="22" align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">Ditambah Pajak Pertambahan Nilai (PPN), dimulai sejak Tanggal Mulai Sewa sesuai dengan Jadwal Pembayaran sebagaimana akan dicantumkan dalam Apendik II Surat Kesepakatan Sewa Menyewa dan Perjanjian Sewa Menyewa.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>6.</strong></td>
    <td align="center">&nbsp;</td>
    <td colspan="5"><strong><u>BIAYA FOODCOURT LEVY DAN BIAYA PELAYANAN</u></strong></td>
  </tr>
</table>
<table width="753" border="0">  
  <tr>
    <td width="49">&nbsp;</td>
    <td width="15" valign="top">*</td>
    <td colspan="2">&nbsp;</td>
    <td width="651" colspan="3" align="justify">Biaya foodcourt levy dikenakan sebesar Rp. <?php echo number_format($row->biaya_food_levy,0);?>/bulan ditambah dengan Pajak Pertambahan Nilai (PPN) diberlakukan sejak tanggal Mulai Sewa.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">*</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3" align="justify">Biaya Pelayanan sebesar Rp. <?php echo number_format($row->biaya_service,0);?> (<?php echo number_to_wordsnorp(number_format($row->biaya_service,0));?> Rupiah) untuk setiap meter persegi per bulan diberlakukan sejak tanggal Mulai Sewa. Biaya pelayanan dibayarkan per 1 (satu) bulan dimuka. Biaya Pelayanan akan ditinjau ulang setiap tahun.</td>
  </tr>
</table>
<table width="753" border="0">  
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="22"><strong>7.</strong></td>
    <td width="25" align="center">&nbsp;</td>
    <td colspan="5"><strong><u>BIAYA UTILITAS</u></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">Penyewa berkewajiban untuk membayar biaya penggunaan utilitas (<?php echo $row->Utilities;?>) yang terpasang di dalam sewa, setiap bulan ditambah dengan biaya administrasi 10% (sepuluh pesen) dan ditambah Pajak Pertambahan Nilai (PPN). <br />
    Biaya utilitas (<?php echo $row->Utilities;?>) dibayarkan oleh Pihak Penyewa berdasarkan pada pemakaian tercatat dalam meteran utility.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>8.</strong></td>
    <td align="center">&nbsp;</td>
    <td colspan="5"><strong><u>SIMPANAN JAMINAN</u></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">Simpanan Jaminan yang harus dibayarkan oleh Penyewa adalah senilai <?php echo number_format($row->jml_deposit,0);?> bulan Uang Sewa dan Biaya Pelayanan yaitu sebesar Rp. <?php echo number_format($row->deposit_value,0);?> (<?php echo number_to_wordsnorp($row->deposit_value);?> Rupiah) dibayarkan dalam <?php echo number_format($row->angsuran_deposit,0);?>  (<?php echo number_to_wordsnorp($row->angsuran_deposit);?>) kali angsuran sebesar <?php echo number_format($row->angsuran_deposit,0);?>. Simpanan Jaminan ini akan disimpan dan akan dikembalikan kepada Penyewa setelah berakhirnya jangka waktu periode Sewa Menyewa.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">Pemilik akan menyiapkan saluran telepon untuk Penyewa hanya atas permintaan Penyewa yang akan dicantumkan dalam Berita Acara pemasangan sambungan telepon yang mana atas pemasangan sambungan telepon tersebut Penyewa dikenakan Simpanan Jaminan Telepon sejumlah  Rp. <?php echo number_format($row->telp_deposit,0);?> (<?php echo number_to_wordsnorp(number_format($row->telp_deposit,0));?> Rupiah) untuk setiap 1 (satu) sambungan saluran telepon. Biaya penyambungan telepon sebesar Rp. <?php echo number_format($row->telp_service,0);?> (<?php echo number_to_wordsnorp(number_format($row->telp_service,0));?> Rupiah) untuk setiap 1 (satu) sambungan saluran telepon.<br /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">Simpanan Jaminan, Simpanan Jaminan Telepon dan Biaya Pemasangan Telp ini dibayarkan pada saat penandatanganan Kesepakatan Sewa Menyewa dan dikembalikan kepada Penyewa oleh Pemilik setelah berakhirnya jangka waktu periode Sewa Menyewa setelah dikurangi biaya-biaya jika ada.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>9.</strong></td>
    <td align="center">&nbsp;</td>
    <td colspan="5"><strong><u>PERIODE RENOVASI RUANG SEWA (FITTING-OUT)</u></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">Pemilik akan mengeluarkan pemberitahuan 14 (empat belas) hari dimuka untuk Penyewa memulai pekerjaan renovasi dan memberikan waktu untuk periode renovasi ruang sewa selama <?php echo number_format($row->fitting_out,0);?> (<?php echo number_to_wordsnorp(number_format($row->fitting_out,0));?>) hari sejak berakhirnya pemberitahuan tersebut. <br /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">Pelaksanaan renovasi ruang sewa (Fitting out) harus dikoordinasikan dengan Pemilik terkait dengan standar dan peraturan untuk Fitting Out dan desain rencana Fitting out harus mendapatkan persetujuan Pemilik.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">Bilamana Ruang Sewa telah siap dibuka untuk berdagang sebelum berakhirnya Jangka Waktu fitting-out, berdasarkan persetujuan tertulis dari Pemilik, Penyewa dapat membuka Ruang Sewa untuk berdagang dan Uang Sewa serta biaya-biaya lain harus dibayar sejak tanggal pembukaan tersebut.<br /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>10.</strong></td>
    <td align="center">&nbsp;</td>
    <td colspan="5"><strong><u>STANDARD SPESIFIKASI</u></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">Pemilik akan menyerahkan Ruang Sewa kepada Penyewa pada Tanggal Siap Serah Terima sesuai dengan spesifikasi standard sebagaimana terlampir di dalam Apendik III Surat Kesepakatan Sewa Menyewa.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>11.</strong></td>
    <td align="center">&nbsp;</td>
    <td colspan="5"><strong><u>JAM OPERASIONAL</u></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">Jam Operasional adalah hari Senin sampai hari Minggu (kecuali hari hari di mana Penyewa  diwajibkan oleh peraturan yang berlaku) yaitu dari pukul 10.00 sampai pukul 22.00 (waktu setempat) sebagaimana dari waktu ke waktu dapat dirubah oleh Pemilik dengan suatu pemberitahuan kepada Penyewa. Penyewa tidak diijinkan untuk beroperasi dan/atau tidak beroperasi selain pada jam operasional yang telah ditentukan dan wajib  mendapatkan persetujuan tertulis dari Pemilik.<br /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>12.</strong></td>
    <td align="center">&nbsp;</td>
    <td colspan="5"><strong><u>KETENTUAN KHUSUS</u></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">Pemilik dan Penyewa menyetujui untuk menambahkan ketentuan-ketentuan terkait Operasioanal sebagaimana terlampir di dalam Apendik IV Surat Kesepakatan Sewa Menyewa.<br /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>13.</strong></td>
    <td align="center">&nbsp;</td>
    <td colspan="5"><strong><u>PENUTUP</u></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">Apabila Penyewa adalah sebuah perusahaan, maka harus melengkapi dengan copy Akte Perusahaan ketika Surat Kesepakatan Sewa Menyewa ini dikembalikan.<br />
    Ketentuan dan syarat-syarat ini akan dicantumkan dalam Surat Perjanjian Sewa Menyewa antara Pemilik dan Penyewa.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">Apabila Penyewa menyetujui ketentuan dan syarat-syarat tersebut, mohon agar Penyewa dapat memberikan paraf pada setiap halaman dan menandatangani Surat Kesepakatan Sewa Menyewa ini sebagai tanda persetujuan dan stempel perusahaan serta mengembalikannya dalam jangka waktu 7 (tujuh) hari dari tanggal tertulis di atas. Apabila dalam waktu tersebut tidak dikembalikan, Pemilik berhak untuk menawarkan ruang sewa kepada pihak lain tanpa pemberitahuan terlebih dahulu.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="5" align="justify">Sampai diterimanya pembayaran di muka dan ditandatanganinya Surat Kesepakatan Sewa Menyewa ini, Penyewa tidak diijinkan untuk melakukan Fitting Out. Perjanjian Sewa Menyewa harus ditandatangani dalam waktu 7 hari, sejak notifikasi pengiriman draft Perjanjian oleh Pemilik. Pemilik mempunyai hak untuk menolak menyewakan ruang sewa jika Perjanjian Sewa Menyewa belum ditandatangani dan uang muka yang sudah dibayarkan tidak bisa dikembalikan, dengan demikian tidak ada pihak yang bisa menuntut satu sama lain pada kondisi apapun. <br /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td width="233" colspan="-1">&nbsp;</td>
    <td width="234" colspan="-1">&nbsp;</td>
  </tr>
   
</table>
<table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td >Hormat kami,</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Untuk dan Atas nama</td>
    <td colspan="3">&nbsp;</td>
    <td>Menyetujui</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $row->region_namereport;?></td>
    <td colspan="3">&nbsp;</td>
    <td><?php echo $row->rekanan_pt;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $row->Print_LOI_Position1_name;?></td>
    <td colspan="3">&nbsp;</td>
    <td><?php echo $row->kepada;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $row->Print_LOI_Position1;?></td>
    <td colspan="3">&nbsp;</td>
    <td>Owner</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $row->region_namereport;?></td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $row->Print_LOI_Position2_name;?></td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $row->Print_LOI_Position2;?></td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="46">&nbsp;</td>
    <td width="234"><div align="left"></div></td>
    <td colspan="3">&nbsp;</td>
    <td width="248">&nbsp;</td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td width="46">&nbsp;</td>
    <td colspan="5">Penyewa setuju dan menerima ketentuan serta syarat-syarat diatas, meminta kepada pemilik untuk membuatkan surat Perjanjian Sewa Menyewa.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="302">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td width="359">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
  <tr>
    <td>&nbsp;</td>
    <td>Nama Perusahaan</td>
    <td colspan="3">:</td>
    <td>...................................................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Nama</td>
    <td colspan="3">:</td>
    <td>...................................................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>Tanda Tangan dan Jabatan</td>
    <td colspan="3">:</td>
    <td>...................................................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>No. KTP</td>
    <td colspan="3">:</td>
    <td>...................................................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Alamat (KTP)</td>
    <td colspan="3">:</td>
    <td>...................................................................................</td>
  </tr>  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>...................................................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Alamat (Correspodence)</td>
    <td colspan="3">:</td>
    <td>...................................................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>...................................................................................</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>Telp / HP / Fax</td>
    <td colspan="3">:</td>
    <td>...................................................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Email </td>
    <td colspan="3">:</td>
    <td>...................................................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>NPWP*</td>
    <td colspan="3">:</td>
    <td>...................................................................................</td>
  </tr>  
  <tr>
    <td>&nbsp;</td>
    <td>SKT*</td>
    <td colspan="3">:</td>
    <td>...................................................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>TDP*</td>
    <td colspan="3">:</td>
    <td>...................................................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Akta Perusahaan*</td>
    <td colspan="3">:</td>
    <td>...................................................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>SIUP*</td>
    <td colspan="3">:</td>
    <td>...................................................................................</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>* disertakan softcopy/hardcopy</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">Tanggal hari ini ........ bulan ..................... Tahun {1Print Date}, Jakarta, Indonesia<br /></td>
  </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Tembusan : BoD/Collection/Legal</td>
      <td colspan="3">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
</table>
<table width="753" border="0">    
    <tr>
      <td width="45">&nbsp;</td>
      <td width="82">Lampiran </td>
      <td colspan="3">:</td>
      <td width="585">Denah</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td>Skedul Pembayaran</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>Standar Spesifikasi</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
</table>
 

<table width="753" border="0">

  </tr>

</table>
<?php }}?> 
</body>
</html>