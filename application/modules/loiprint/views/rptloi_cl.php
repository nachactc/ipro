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

<htmlpageheader name="firstpage" style="display:none">
  <div style="text-align:center">
  </div>
</htmlpageheader>

<htmlpageheader name="otherpages" style="display:none">
  <div style="border-top: 0px solid #000000; font-size: 9pt; text-align: right; padding-top: 3mm; ">
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

<sethtmlpageheader name="firstpage" value="on" show-this-page="1"/>
<sethtmlpageheader name="otherpages" value="on"/> 
<sethtmlpagefooter name="myfooter" value="on" />


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
    <td width="241"><strong>RUANG SEWA</strong></td>
    <td width="16" colspan="-1">:</td>
    <td width="434" colspan="-1"><em>sebagaimana ditandai pada denah terlampir</em></td>
  </tr>
  <tr>
    <td width="31">&nbsp;</td>
    <td width="9" align="center">&nbsp;</td>
    <td>Lantai/Unit</td>
    <td width="16" colspan="-1">:</td>
    <td width="434" colspan="-1"><?php echo $row->lantai;?> : <?php echo $row->unit;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td> Total Luas</td>
    <td colspan="-1">:</td>
    <td width="434" colspan="-1"><?php echo $row->luas;?> m2</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>Harga Sewa</td>
    <td colspan="-1">: </td>
    <td colspan="-1">Rp. <?php echo number_format($uang_sewa,0);?>/m2/bulan</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1">Total Rp. <?php echo number_format($total_sewa,0);?> (ditambah PPN 10%)</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>Biaya Pelayanan</td>
    <td colspan="-1">:</td>
    <td colspan="-1">INCLUDED</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>Periode Sewa</td>
    <td colspan="-1">:</td>
    <td colspan="-1"><?php echo $new_date = date('d F Y', strtotime($row->startdate));?> - <?php echo  $new_date = date('d F Y', strtotime($row->enddate));?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><strong>2.</strong></td>
    <td align="center">&nbsp;</td>
    <td valign="top"><strong>PENGGUNAAN RUANG SEWA</strong></td>
    <td colspan="-1" valign="top">:</td>
    <td colspan="-1" align="justify">Ruang Sewa akan digunakan untuk <?php echo $row->dagangan;?> dengan nama dagang <?php echo $row->toko;?>. Penyewa kecuali mendapatkan persetujuan tertulis dari Pemilik, dilarang untuk mengadakan Pemeran yang menjual produk serupa dengan barang-barang yang dijual oleh Transmart/Carrefour, antara lain pakaian, sepatu, tas dan jam tangan. Barang yang dijual harus sesuai dengan standar yang ditetapkan oleh Pemilik dan harus dijaga serta diawasi oleh Penyewa sebagai penjual yang telah memiliki reputasi baik.<br /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1" align="justify">Penyewa bertanggung jawab untuk memperoleh seluruh perizinan dan lisensi yang diperlukan (jika ada) dari pihak berwenang untuk menjual dan menyediakan barang-barang asli (original) tersebut atas biaya dan tanggung jawab Penyewa sepenuhnya. Setiap perubahan barang barang jualan, termasuk perinciannya, tunduk pada persetujuan tertulis Pemilik. </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>      
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1" align="justify">Penyewa wajib mendapatkan persetujuan tertulis dari Pemilik jika mengadakan kegiatan (acara/event) pada ruang sewa dan untuk pengadaan kegiatan tersebut, Penyewa setuju untuk dikenakan penyesuaian tarif sewa.<br /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>      
  <tr>
    <td valign="top"><strong>3.</strong></td>
    <td align="center">&nbsp;</td>
    <td valign="top"><strong>BIAYA UTILITAS</strong></td>
    <td colspan="-1" valign="top">:</td>
    <td colspan="-1" align="justify">Penyewa berkewajiban untuk membayar biaya penggunaan utilitas (<?php echo $row->Utilities;?>) yang terpasang di dalam sewa, setiap bulan ditambah dengan biaya administrasi 10% (sepuluh pesen) dan ditambah Pajak Pertambahan Nilai (PPN). <br /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1" align="justify">Biaya utilitas (<?php echo $row->Utilities;?>) dibayarkan oleh Pihak Penyewa berdasarkan pada pemakaian tercatat dalam meteran utility.<br />
Biaya ini akan dimasukkan dalam biaya sewa.</td>
  </tr>      
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><strong>4.</strong></td>
    <td align="center">&nbsp;</td>
    <td valign="top"><strong>FITTING OUT</strong></td>
    <td colspan="-1" valign="top">:</td>
    <td colspan="-1" align="justify">Fitting out dapat dilakukan setelah penyewa melakukan pembayaran uang muka dan simpanan jaminan paling lambat   3 (tiga) hari sebelum pelaksanaan Fitting out.<br /></td>
  </tr>      
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>5.</strong></td>
    <td align="center">&nbsp;</td>
    <td><strong>SIMPANAN JAMINAN</strong></td>
    <td colspan="-1">:</td>
    <td colspan="-1" align="justify">Rp. <?php echo number_format($row->deposit_value,0);?>/m2/periode</td>
  </tr>      
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="-1">&nbsp;</td>
    <td colspan="-1" align="justify">Simpanan Jaminan ini harus dibayarkan paling lambat 7 (Tujuh) hari sebelum periode sewa berjalan dan akan dikembalikan setelah masa sewa berakhir dan tidak diperpanjang dengan ketentuan tidak ada kerusakan atau kehilangan properti milik Trans Retail Indonesia dengan disertai Berita Acara Pelaksanaan Kegiatan dan Surat Permohonan Pengembalian Security Deposit.<br /></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>      
  <tr>
    <td valign="top"><strong>6.</strong></td>
    <td align="center">&nbsp;</td>
    <td valign="top"><strong>PENUTUP</strong></td>
    <td colspan="-1" valign="top">:</td>
    <td colspan="-1" align="justify">Demikian penawaran ini kami sampaikan, jika Bapak/Ibu menyetujui penawaran ini mohon agar dapat menandatangani surat ini sebagai tanda persetujuan serta mengembalikannya dalam jangka waktu 7 (tujuh) hari dari tanggal tertulis di atas. Apabila dalam waktu tersebut tidak dikembalikan, Pemilik berhak untuk menawarkan ruang sewa kepada pihak lain tanpa pemberitahuan terlebih dahulu. Sampai diterimanya pembayaran di muka dan ditandatanganinya Surat Kesepakatan Sewa Menyewa ini, Penyewa tidak diijinkan untuk melakukan Fitting Out. Perjanjian Sewa Menyewa harus ditandatangani dalam waktu 7 hari, sejak notifikasi pengiriman draft Perjanjian oleh Pemilik.<br /></td>
  </tr>          
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">Pemilik mempunyai hak untuk menolak menyewakan ruang sewa jika Perjanjian Sewa Menyewa belum ditandatangani dan uang yang sudah dibayarkan tidak bisa dikembalikan, dengan demikian tidak ada pihak yang bisa menuntut satu sama lain pada kondisi apapun.<br /></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>   
    <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>
    <tr>
    <td valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td colspan="-1" valign="top">&nbsp;</td>
    <td colspan="-1" align="justify">&nbsp;</td>
  </tr>                  
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
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
    <td><?php echo $Position1_name['setting_value'];?></td>
    <td colspan="3">&nbsp;</td>
    <td><?php echo $row->kepada;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $Position1['setting_value'];?></td>
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
    <td><?php echo $Position2_name['setting_value'];?></td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $Position2['setting_value'];?></td>
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
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
      <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
      <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
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