<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
@font-face {
    font-family: 'arial'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/arial.ttf');?>'); /*URL to font*/
}
body {font-family: 'arial';font-size: 10pt}
@page { margin-left:3cm; margin-right:3cm; margin-top:1cm;margin-bottom:0.5cm;size:8.27in 11.69in;}
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

<htmlpagefooter name="myfooter">
<table width="753" border="0">
<tr><td colspan="3" align="center" height="40">&nbsp;</td></tr>
  <tr><td colspan="3" align="center" style="font-size: 10pt">Halaman {PAGENO} dari {nb}</td></tr>
  <tr>
    <td width="82" style="font-size: 10pt">Ref. No</td>
    <td width="10">:</td>
    <td width="651" style="font-size: 10pt"><?php echo $nolah;?></td>
  </tr>
<tr><td colspan="3" style="font-size: 10pt"><?php echo $rloo['branch_area'];?></td></tr>
  </table>
</htmlpagefooter>
<sethtmlpagefooter name="myfooter" value="on" />
<table width="753" border="0">
  <tr>
    <td width="113">Ref.No</td>
    <td width="24" >:</td>
    <td width="602"><?php echo $nolah;?></td>
  </tr>
  <tr>
    <td colspan="3"><?php echo $new_date = date('d F Y', strtotime($rloo['tanggal']));?></td>
  </tr>
  <tr>
    <td colspan="3">Kepada Yth,</td>
  </tr>
  <tr>
    <td><strong>Bapak/Ibu</strong></td>
    <td>&nbsp;</td>
    <td><strong><?php echo $rloo['kepada'];?></strong></td>
  </tr>
  </table>
  <table width="753" border="0">
  <tr>
    <td width="440"><?php echo $rloo['alamat'];?></td>
    <td width="303">&nbsp;</td>
  </tr>
  </table>
  <table width="753" border="0">
  <tr>
    <td colspan="3">(selanjutnya disebut <b>“Penyewa”</b>)</td>
  </tr>
  <tr>
    <td width="111">&nbsp;</td>
    <td width="25"></td>
    <td width="603"></td>
  </tr>
  <tr>
    <td>Telp.</td>
    <td>:</td>
    <td><?php echo $rloo['mobile'];?></td>
  </tr>
  <tr>
    <td>Fax</td>
    <td>:</td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><strong>Perihal: Surat Kesepakatan Sewa Menyewa <?php echo $row->rekananshipping_name;?></strong></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><b><?php echo $rloo['branch_area'];?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="3">Dengan Hormat,</td>
  </tr>
  <tr>
    <td colspan="3" align="justify">Kami, <?php echo $row->region_namereport;?> (selanjutnya disebut “Pemilik”), dengan ini menyampaikan Surat Kesepakatan Sewa Menyewa di <?php echo $rloo['branch_area'];?> kepada Penyewa (selanjutnya disebut “Kesepakatan Sewa Menyewa”).</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="3">Berikut ini adalah syarat-syarat dan ketentuan Kesepakatan Sewa Menyewa:</td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td width="19">1</td>
    <td colspan="3"><strong>Ruang Sewa:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="64">Lantai</td>
    <td width="19">:</td>
    <td width="633"><?php echo $vlantai;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>No. Unit</td>
    <td>:</td>
    <td><?php echo $vunitname;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Luas</td>
    <td>:</td>
    <td><?php echo $vunitsqm;?> M2</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">(selanjutnya disebut <b>“Ruang Sewa”</b>) dengan denah terlampir.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>2</td>
    <td colspan="3"><strong>Periode Sewa:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify"><?php echo $row->agreement_term;?> bulan <?php if ($row->agreement_dayterm>0){ echo $row->agreement_dayterm." hari";}?> kalender terhitung mulai Tanggal Mulai Sewa dan dapat diperpanjang berdasarkan kesepakatan kedua pihak (selanjutnya disebut “Periode Sewa”).</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">Yang dimaksud dengan “Tanggal Mulai Sewa” di atas adalah salah satu dari:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">(a)&nbsp;&nbsp;berakhirnya periode Periode Fitting Out; atau</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">(b)&nbsp;&nbsp;tanggal mulai pembukaan Ruang Sewa untuk berdagang,
mana yang lebih dulu terjadi
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>3</td>
    <td colspan="3"><b>Penggunaan Ruang Sewa</b>:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Ruang Sewa akan digunakan untuk penjualan produk <?php echo $rloo['dagangan'];?> dengan nama dagang <?php echo $rloo['toko'];?>. Barang dagangan yang dijual harus sesuai standar yang harus dijaga dan diawasi oleh Penyewa</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Penyewa, dengan biayanya sendiri, bertanggung jawab untuk memperoleh perijinan yang diperlukan (jika ada) dari instansi yang berwenang untuk melakukan usaha tersebut di atas.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td>4</td>
    <td colspan="3"><b>Uang Sewa:</b></td>
  </tr>
  
  
 <?php
	if ($jumrentloi <1){
?>
   <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Uang Sewa adalah sebesar  Rp.  <?php echo number_format($rloirent['baserent'],0);?> (<?php echo number_to_words($rloirent['baserent']);?> Rupiah) per meter persegi per bulan, ditambah Pajak Pertambahan Nilai (PPN).</td>
  </tr>
<?php } ?>
  
<?php
	if ($jumrentloi >1){
		   $abj="a";
		   $no=1;
?> 
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Uang sewa adalah sebesar :</td>
  </tr>
 <?php  foreach($rloi as $rowloi){  ?>
    <tr>
    <td width="19">&nbsp;</td>
    <td width="64" valign="top"><?php echo $abj;?>.</td>
    <td colspan="3" align="justify" valign="top">Tahun <?php echo $no;?> :  Rp. <?php echo number_format($rowloi->baserent,0);?>  (<?php echo number_to_words($rowloi->baserent);?>) per meter persegi per bulan ditambah Pajak Pertambahan Nilai (PPN).</td>
  </tr>
    <?php $abj++;$no++; } ?>
   <?php
	}
	?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Total Uang Sewa yang harus dibayarkan selama <?php echo $rloo['jangka'];?> (<?php echo number_to_wordsnorp($rloo['jangka']);?>) bulan jangka waktu sewa menyewa adalah sebesar Rp. <?php echo number_format($rloo['total_sewa'],0);?>  (<?php echo number_to_wordsnorp($rloo['total_sewa']);?>) dibayarkan dengan detail sebagai berikut: </td>
  </tr>
  
   <tr>
   <td width="19">&nbsp;</td>
    <td width="64" valign="top">(a)</td>
    <td colspan="3" valign="top" align="justify"><?php echo number_format($rloo['DP_percent'],0); ?>% (<?php echo number_to_wordsnorp($rloo['DP_percent']);?> persen) berupa pembayaran di muka yang tidak dapat dikembalikan sejumlah Rp. <?php echo number_format($rloo['DP_value'],0); ?> (<?php echo number_to_words($rloo['DP_value']);?>) dibayarkan dalam 1 (Satu) kali angsuran yang sama sebesar Rp. <?php echo number_format($rloo['DP_value'],0); ?> (<?php echo number_to_words($rloo['DP_value']);?>) ditambah Pajak Pertambahan Nilai (PPN) dibayarkan pada saat penandatanganan Surat Kesepakatan Sewa Menyewa sesuai dengan Jadwal Pembayaran sebagaimana akan dicantumkan dalam Apendik II Surat Kesepakatan Sewa </td>
  </tr>
  
   <tr>
   <td width="19">&nbsp;</td>
    <td width="64" valign="top">(b)</td>
    <td colspan="3" valign="top" align="justify"><?php echo number_format($rloo['sisa_percent'],0); ?>% (<?php echo number_to_wordsnorp($rloo['sisa_percent']);?> persen) sisa Biaya Sewa keseluruhan sejumlah Rp. <?php echo number_format($rloo['sisa_total_sewa'],0); ?> (<?php echo number_to_words($rloo['sisa_total_sewa']);?>) dibayarkan dalam <?php echo number_format($rloo['sisa_jangka'],0); ?> (<?php echo number_to_wordsnorp($rloo['sisa_jangka']);?>) kali angsuran dengan detail sebagai berikut :</td>
  </tr>
  
  <tr>
   <td width="19">&nbsp;</td>
    <td width="64" valign="top">&nbsp;</td>
    <td colspan="3" valign="top" align="justify">
	 <table  border="0" cellpadding="0" cellspacing="0">
       <?php if( trim($rloo['angsuran1'])!==""){?>
        <tr>
        <td align="center" valign="top">1.&nbsp;&nbsp;</td>
        <td valign="top" align="justify"><?php echo $rloo['angsuran1'];?></td>
        </tr>
        <?php } ?>
        <?php if( trim($rloo['angsuran2'])!==""){?>
        <tr>
        <td align="center" valign="top">2.&nbsp;&nbsp;</td>
        <td valign="top" align="justify"><?php echo $rloo['angsuran2'];?></td>
        </tr>
        <?php } ?>
        <?php if( trim($rloo['angsuran3'])!==""){?>
        <tr>
        <td align="center" valign="top">3.&nbsp;&nbsp;</td>
        <td valign="top" align="justify"><?php echo $rloo['angsuran3'];?></td>
        </tr>
        <?php } ?>
        <?php if( trim($rloo['angsuran4'])!==""){?>
        <tr>
        <td align="center" valign="top">4.&nbsp;&nbsp;</td>
        <td valign="top" align="justify"><?php echo $rloo['angsuran4'];?></td>
        </tr>
        <?php } ?>
        </table>
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>5</td>
    <td colspan="3"><strong>Biaya Utilitas:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Penyewa wajib membayar biaya penggunaan utilitas setiap bulan, seperti biaya listrik, air dan gas yang terpasang dalam Ruang Sewa ditambah biaya administrasi sebesar 10% (sepuluh persen) dan PPN.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Biaya utilitas tersebut dibayarkan oleh Penyewa berdasarkan pada pemakaian oleh Penyewa yang tercatat pada meteran utilitas.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>6</td>
    <td colspan="3"><b>Telepon:</b></td>
  </tr>
  <tr>
  <td align="justify"></td>
    <td colspan="3" align="justify">
    <table>
      <tr><td width="10" valign="top"><ul><li>&nbsp;</ul></td><td>
      Pemilik akan menyediakan minimal 1 (satu) line telepon untuk setiap Ruang Sewa hanya atas permintaan Penyewa yang dicantumkan dalam Berita Acara Pemasangan sambungan telepon yang mana atas pemasangan sambungan telepon Penyewa dikenakan dengan Simpanan Jaminan Telepon sebesar Rp.3,500,000,- (Tiga Juta Lima Ratus Ribu Rupiah) per line (refundable), dan dengan biaya penyambungan sebesar Rp.Rp. 1,000,000,- (Satu Juta Rupiah) untuk setiap 1 (satu) sambungan saluran telepon.</li>
    </td></tr></table></td>
  </tr>
  <tr>
  <td align="justify">&nbsp;</td>
    <td colspan="3" align="justify">
    <table>
      <tr><td width="10" valign="top"><ul><li>&nbsp;</ul></td><td>
      Pemilik akan menyediakan Jaringan Nirkabel (Wifi) dengan biaya pemakaian sebesar Rp. 400.000,- (Empat Ratus Ribu Rupiah) per SSID per bulan.
    </td></tr></table></td>
  </tr>
  <tr>
  <td align="justify">&nbsp;</td>
    <td colspan="3" align="justify"><table>
      <tr><td width="10" valign="top"><ul><li>&nbsp;</ul></td><td>Simpanan Jaminan Telepon, Biaya Pemasangan Telepon dan Biaya Penyediaan Jaringan Nirkabel (wifi) ini dibayarkan setelah penandatanganan Surat Kesepakatan Sewa Menyewa.
    </td></tr></table></td>
  </tr>
  <tr>
  <td align="justify">&nbsp;</td>
    <td colspan="3" align="justify"><table>
      <tr><td width="10" valign="top"><ul><li>&nbsp;</ul></td><td>Simpanan Jaminan Telepon ini akan disimpan dan akan dikembalikan kepada Penyewa secara utuh tanpa bunga setelah berakhirnya Periode Sewa, setelah dikurangi biaya-biaya jika ada.
    </td></tr></table></td>
  </tr>
  <tr>
  <td align="justify">&nbsp;</td>
    <td colspan="3" align="justify"><table>
      <tr><td width="10" valign="top"><ul><li>&nbsp;</ul></td><td>Apabila Penyewa tidak akan menggunakan saluran telepon, Penyewa wajib menyampaikan kepada Pemilik.
    </td></tr></table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>7</td>
    <td colspan="3"><strong>Biaya Pelayanan:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Biaya Pelayanan sebesar Rp.<?php echo number_format($rnilaiservice['agreementdetil_baserent'],0);?>,-(<?php echo number_to_wordsnorp($rnilaiservice['agreementdetil_baserent']);?> Rupiah) untuk setiap meter persegi per bulan diberlakukan sejak Tanggal Mulai Sewa. Biaya pelayanan dibayarkan per <?php echo $rintservice['intvpelayanan'];?> (<?php echo number_to_wordsnorp($rintservice['intvpelayanan']);?>) bulan di muka. Biaya Pelayanan akan ditinjau ulang setiap tahun.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>8</td>
    <td colspan="3"><strong>Biaya Promo Levy:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Sebesar Rp. <?php
		if ($rnilaipromo['agreementdetil_baserent']==""){
			$nilpromo=0;
		}
			else{
				$nilpromo=$rnilaipromo['agreementdetil_baserent'];
		}
		 echo number_format($rnilaipromo['agreementdetil_baserent'],0);?>,- (<?php echo number_to_wordsnorp($nilpromo);?> Rupiah) / m2 / bulan ditambah PPN, yang mulai berlaku sejak Tanggal Mulai Sewa.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>9</td>
    <td colspan="3"><strong>Simpanan Jaminan:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Simpanan Jaminan senilai <?php echo $rloo['jml_deposit'];?> (<?php echo number_to_wordsnorp(number_format($rloo['jml_deposit'],0));?>) bulan Uang Sewa harus dibayarkan oleh Penyewa kepada Pemilik pada Tanggal Mulai Sewa.</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Simpanan Jaminan ini akan disimpan dan akan dikembalikan kepada Penyewa secara utuh tanpa bunga setelah berakhirnya Periode Sewa, setelah dikurangi biaya-biaya jika ada.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>10</td>
    <td colspan="3"><b>Periode Renovasi Ruang Sewa (Fitting-Out):</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Pemilik akan menyampaikan pemberitahuan <?php echo $rkomisaris['pemberitahuan_ftout'];?> (<?php echo number_to_wordsnorp(number_format($rkomisaris['pemberitahuan_ftout'],0));?>) hari di muka agar Penyewa dapat memulai pekerjaan renovasi (fitting out) dan memberikan waktu untuk periode renovasi (fitting out) Ruang Sewa selama <?php echo $rloo['fitting_out'];?> (<?php echo number_to_wordsnorp($rloo['fitting_out']);?>) hari sejak berakhirnya pemberitahuan tersebut (selanjutnya disebut “Periode Fitting Out”). </td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Pelaksanaan renovasi (fitting out) Ruang Sewa harus dikoordinasikan dengan Pemilik dengan standar dan peraturan untuk renovasi (fitting out) dan desain rencana renovasi (fitting out) harus mendapatkan persetujuan Pemilik.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Bilamana Ruang Sewa telah siap dibuka untuk berdagang sebelum berakhirnya Periode Fitting Out, berdasarkan persetujuan tertulis dariPemilik, Penyewa dapat membuka Ruang Sewa untuk berdagang dan Uang Sewa serta biaya-biaya lain harus dibayar sejak tanggal pembukaan tersebut.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>11</td>
    <td colspan="3"><b>Standar Spesifikasi Ruang Sewa:</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Pemilik akan menyerahkan Ruang Sewa kepada Penyewa pada Tanggal Siap Serah Terima sesuai dengan spesifikasi standar sebagaimana terlampir di dalamLampiran I Kesepakatan Sewa Menyewa ini.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>12</td>
    <td colspan="3"><b>Jam Operasional:</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Jam operasional adalah hari Senin sampai dengan hari Minggu, yaitu dari pukul 10.00 sampai pukul 22.00 (waktu setempat) sebagaimana dari waktu ke waktu dapat diubah oleh Pemilik dengan suatu pemberitahuan kepada Penyewa 1 (satu) hari sebelumnya. Penyewa tidak diijinkan untuk beroperasi dan/atau tidak beroperasi selain pada jam operasional yang telah ditentukan.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>13</td>
    <td colspan="3"><b>Ketentuan Khusus:</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">Penyewa menyetujui syarat-syarat dan ketentuan sewa sebagaimana diatur dalam Lampiran 2 Kesepakatan Sewa Menyewa ini.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>14</td>
    <td colspan="3"><strong>Lain-lain:</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">(a)</td>
    <td colspan="2" align="justify">Penyewa menjamin bahwa pihak yang menandatangani Kesepakatan Sewa Menyewa ini adalah pihak yang cakap secara hukum dan berwenang untuk membuat kesepakatan dengan pihak lain, termasuk Kesepakatan Sewa Menyewa ini, dan dengan ini mengesampingkan setiap hak yang dimiliki untuk mengklaim ketidaksahan penandatanganan Kesepakatan Sewa Menyewa ini.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">(b)</td>
    <td colspan="2">Kesepakatan Sewa Menyewa ini berikut Lampirannya merupakan satu kesatuan dan bagian tidak terpisahkan.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">(c)</td>
    <td colspan="2" align="justify">Setiap perubahan syarat dan ketentuan Kesepakatan Sewa Menyewa ini hanya dapat dilakukan dengan kesepakatan bersama secara tertulis.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="justify">Apabila Bapak/Ibu menyetujui Kesepakatan Sewa Menyewa ini, harap membubuhkan tanda tangan pada kolom yang kami sediakan sebagai tanda persetujuan dan mengirimkan copy-nya pada alamat surat elektronik berikut: vionita_tong@transretail.co.id dan/atau ihya_nasution@transretail.co.id atau fax ke (021) 2758 5738 – 2758 5899.  Apabila masih ada yang dipertanyakan, silahkan menghubungi Ihya Nasution (0812 2302 3016) atau Vionita Tong (0811 8885 512).</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="justify">Surat Kesepakatan Sewa Menyewa ini akan berlaku selama 5 (lima) hari kerja sejak tanggal Surat Kesepakatan Sewa Menyewa ini, kecuali ditandatangani lebih dahulu oleh Penyewa atau dibuat suatu perjanjian sewa yang terkait antara Pemilik dan Penyewa (jika diperlukan).</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Demikian kami sampaikan Surat Kesepakatan Sewa Menyewa ini.</td>
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
    <td width="355">Hormat kami,</td>
    <td width="37">&nbsp;</td>
    <td width="140">&nbsp;</td>
    <td width="203">Menyetujui,</td>
  </tr>
  <tr>
    <td>PT TRANS RETAIL INDONESIA</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Penyewa</td>
  </tr>
  <tr>
    <td height="80">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td><strong><u>Tanti Triandini </u></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><u><strong><?php echo $rloo['kepada'];?></strong></u></td>
  </tr>
  <tr>
    <td>Senior Leasing Manager</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php }}?> 
</body>
</html>