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
@page { margin-left:3cm; margin-right:3cm; margin-top:3cm;margin-bottom:2cm;size:8.27in 11.69in;}
.spacefill-text {  background: white;
  /* Very important. Choose backgroundcolor*/
  padding-right: 4px;
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
<table width="753" border="0">
  <tr>
    <td align="center"><b>KESEPAKATAN SEWA MENYEWA</b></td>
  </tr>
  <tr>
    <td align="center"><b><?php echo $row->rekananshipping_name;?></b></td>
  </tr>
   <tr>
    <td align="center"><b><?php echo $rloo['branch_area'];?></b></td>
  </tr>
  </table>
  <br />
     <table width="753" border="0">
  <tr>
    <td width="258"><b>Nama Perusahan</b></td><td width="14">:</td><td width="457"><b><?php echo $row->region_namereport;?></b></td>
  </tr>
  <tr>
    <td><b>Penanggung Jawab</b></td>
    <td>:</td>
    <td><b><?php echo $rkomisaris['penanggung_jawab'];?></b></td>
    </tr>
  <tr>
    <td><b>Jabatan</b></td>
    <td>:</td>
    <td><b><?php echo $rkomisaris['jabatan_pemilik'];?></b></td>
    </tr>
    
   <?php if (trim($row->region_id)=='120'){?> 
  <tr>
    <td valign="top"><strong>Alamat</strong></td>
    <td>:</td>
    <td valign="top" align="justify"><b><?php echo $row->region_address;?></b></td>
  </tr>
  <tr>
    <td valign="top"><strong>Alamat Korepondensi</strong></td>
    <td>:</td>
    <td valign="top" align="justify"><b><?php echo $row->region_address_2;?></b></td>
    </tr>
     <?php } else{ ?>
      <tr>
    <td valign="top"><strong>Alamat</strong></td>
    <td>:</td>
    <td valign="top" align="justify"><b><?php echo $row->region_address_2;?></b></td>
    </tr>
     <?php } ?>
    
  <tr>
    <td><strong>Nomor Telepon </strong></td>
    <td>:</td>
    <td><b><?php echo $row->region_telp;?></b></td>
    </tr>
  <tr>
    <td><b>Nomor Fax</b></td>
    <td>:</td>
    <td><b><?php echo $row->region_fax;?></b></td>
    </tr>
  <tr>
    <td colspan="3" height="40">-Untuk selanjutnya disebut “<b>Pemilik</b>”</td>
    </tr>
  <tr>
    <td><strong>Nama</strong></td>
    <td>:</td>
    <td><strong><?php echo $row->rekanan_name;?></strong></td>
    </tr>
  <tr>
    <td><strong>NIK</strong></td>
    <td>:</td>
    <td><b><?php echo $row->rekanan_taxnik;?></b></td>
    </tr>
  <tr>
    <td><strong>NPWP</strong></td>
    <td>:</td>
    <td><b><?php echo $row->taxsign_id;?></b></td>
    </tr>
</td>
    </tr>
  <tr>
    <td valign="top"><strong>Alamat</strong></td>
    <td>:</td>
    <td valign="top" align="justify"><span class="spacefill-text"><b><?php echo $row->rekananshipping_address;?></b></span></td>
    </tr>
  <tr>
    <td><strong>Nomor Telepon</strong></td>
    <td>:</td>
    <td><b><?php echo $row->rekananshipping_contacttelp;?></b></td>
    </tr>
  <tr>
    <td><strong>Nomor Hp</strong></td>
    <td>:</td>
    <td><span class="spacefill-text"><b><?php echo $row->rekananshipping_contacthp;?></b></span></td>
    </tr>
  <tr>
    <td><strong>Email</strong></td>
    <td>:</td>
    <td><span class="spacefill-text"><b><?php echo $row->rekananshipping_contactemail;?></b></span></td>
    </tr>
    <tr>
    <td><strong>PIC</strong></td>
    <td>:</td>
    <td><b><?php echo $row->rekananshipping_contactname;?></b></td>
    </tr>
    <tr>
      <td height="40" colspan="3">-Untuk Selanjutnya disebut “<b>Penyewa</b>”</td>
      </tr>
    <tr>
      <td colspan="3" align="justify">Pemilik, dengan ini menyampaikan Kesepakatan Sewa Menyewa di <?php echo $rloo['branch_area'];?> kepada Penyewa (selanjutnya disebut “<strong>Kesepakatan Sewa Menyewa</strong>”).</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td colspan="3">Berikut ini adalah syarat-syarat dan ketentuan Kesepakatan Sewa Menyewa:</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
  </table>
      <table width="753" border="0">
  <tr>
    <td width="33">1.</td><td colspan="3"><b>Ruang Sewa:</b></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="109">Lantai</td>
    <td width="7">:</td>
    <td width="586"><?php echo $vlantai;?></td>
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
    <td><?php echo $vunitsqm;?> m2</td>
  </tr>
  <tr>
    <td height="29">&nbsp;</td>
    <td colspan="3">(selanjutnya disebut “<b>Ruang Sewa</b>”) dengan denah terlampir.</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>2.</td>
    <td colspan="3"><b>Periode Sewa:</b></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify"><?php echo $row->agreement_term;?> (<?php echo number_to_wordsnorp($row->agreement_term);?>) bulan <?php if ($row->agreement_dayterm>0){ echo $row->agreement_dayterm." hari";}?> kalender terhitung mulai Tanggal Mulai Sewa dan dapat diperpanjang berdasarkan kesepakatan kedua pihak (selanjutnya disebut “Periode Sewa”).</td>
    </tr>
  </table>
<table width="753" border="0">
  <tr>
    <td width="32">&nbsp;</td>
    <td colspan="2">Yang dimaksud dengan “<b>Tanggal Mulai Sewa</b>” di atas adalah salah satu dari:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="46">(a)</td>
    <td width="661">berakhirnya periode Periode Fitting Out; atau</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(b)</td>
    <td align="justify">tanggal mulai pembukaan Ruang Sewa untuk berdagang, mana yang lebih dulu terjadi.
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(c)</td>
    <td align="justify">Periode sewa dimulai dari tanggal <b><?php echo $new_date = date('d F Y', strtotime($row->loo_sdate));?></b> dan berakhir pada tanggal <b><?php echo $new_date = date('d F Y', strtotime($row->loo_edate));?></b>.</td>
  </tr>
  <?php
		if ($row->grace_period==""){
			$nilgrace=0;
		}
			else{
				$nilgrace=$row->grace_period;
		}
		?>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">(d)</td>
    <td valign="top">Apabila Penyewa <b>membuka toko tepat waktu</b> bersamaan dengan pembukaan Transmart sesuai dengan tanggal yang ditetapkan Pemilik, Penyewa diberikan masa bebas angsuran sewa (grace periode) selama <?php echo $nilgrace;?> (<?php echo number_to_wordsnorp($nilgrace);?>) bulan.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>3.</td>
    <td colspan="2"><b>Penggunaan Ruang Sewa:</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="justify">Ruang Sewa akan digunakan untuk penjualan produk <?php echo $rkomisaris['jenisusaha'];?> dengan nama dagang <?php echo $rkomisaris['merkdagang'];?>. Barang dagangan yang dijual harus sesuai standar yang harus dijaga dan diawasi oleh Penyewa.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="justify">Penyewa, dengan biayanya sendiri, bertanggung jawab untuk memperoleh perijinan yang diperlukan (jika ada) dari instansi yang berwenang untuk melakukan usaha tersebut di atas.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>

  <tr>
    <td width="32">4.</td>
    <td colspan="2"><b>Uang Sewa :</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><?php echo $rkomisaris['uangsewa'];?></td>
  </tr>
</table>
  
  <div style="page-break-after: always; width:400" id="hal3"></div>



  <table width="753" border="0">
  <tr>
    <td width="33">5.</td>
    <td colspan="2"><b>Simpanan Jaminan:</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="justify">Simpanan Jaminan yang harus dibayarkan oleh Penyewa adalah sebesar <b>Rp.<?php echo number_format($rtotdeposit,0);?> (<?php echo number_to_wordsnorp($rtotdeposit);?>) Rupiah</b>. Simpanan Jaminan ini dibayarkan setelah penandatanganan Kesepakatan Sewa Menyewa.</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="justify">Simpanan Jaminan ini akan disimpan dan akan dikembalikan kepada Penyewa secara utuh tanpa bunga setelah berakhirnya Periode Sewa, setelah dikurangi biaya-biaya jika ada.</td>
  </tr>
  <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>6.</td>
    <td colspan="2"><b>Biaya Pelayanan:</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="justify"><?php echo $rkomisaris['uangservice'];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>7.</td>
    <td colspan="2"><b>Biaya Utilitas:</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="justify">
Penyewa wajib membayar biaya penggunaan utilitas setiap bulan, seperti biaya listrik, air dan gas yang terpasang dalam Ruang Sewa ditambah biaya administrasi sebesar 10% (sepuluh persen) dan PPN. 
</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="justify">
Biaya utilitas tersebut dibayarkan oleh Penyewa berdasarkan pada pemakaian oleh Penyewa yang tercatat pada meteran utilitas.
</td>
  </tr>
  <tr>
     <td>&nbsp;</td>
     <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>8.</td>
    <td colspan="2"><b>Biaya Promo Levy/Foodcourt Levy: </b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="justify">Sebesar <b>Rp. <?php
		if ($rnilaipromo['agreementdetil_baserent']==""){
			$nilpromo=0;
		}
			else{
				$nilpromo=$rnilaipromo['agreementdetil_baserent'];
		}
		 echo number_format($rnilaipromo['agreementdetil_baserent'],0);?>,- (<?php echo number_to_wordsnorp($nilpromo);?> Rupiah) / m2 / bulan </b>ditambah PPN, yang mulai berlaku sejak Tanggal Mulai Sewa.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>9.</td>
    <td colspan="2"><b>Telepon:</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top" align="center"><ul><li>&nbsp;</li></ul></td>
    <td align="justify">Pemilik akan menyediakan minimal 1 (satu) sambungan telepon untuk setiap Ruang Sewa hanya atas permintaan Penyewa yang dicantumkan dalam Berita Acara Pemasangan sambungan telepon. Setiap pemasangan sambungan telepon dikenakan Simpanan Jaminan Telepon sebesar Rp. 3.500.000,- (Tiga Juta Lima Ratus Ribu Rupiah) (refundable), dan biaya penyambungan sebesar Rp.1.000.000,- (Satu Juta Rupiah).</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td valign="top" align="center"><ul><li>&nbsp;</li></ul></td>
    <td align="justify">Simpanan Jaminan Telepon dan Biaya Pemasangan Telepon dibayarkan setelah penandatanganan Kesepakatan Sewa Menyewa.</td>
  </tr>

    <tr>
    <td>&nbsp;</td>
    <td valign="top" align="center"><ul><li>&nbsp;</li></ul></td>
    <td align="justify">Simpanan Jaminan Telepon ini akan disimpan dan akan dikembalikan kepada Penyewa secara utuh tanpa bunga setelah berakhirnya Periode Sewa, setelah dikurangi biaya-biaya jika ada.</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td valign="top" align="center"><ul><li>&nbsp;</li></ul></td>
    <td align="justify">Pemilik akan menyediakan Jaringan Nirkabel (Wifi) untuk Penyewa. </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top" align="center"><ul><li>&nbsp;</li></ul></td>
    <td align="justify">Apabila Penyewa tidak akan menggunakan saluran telepon dan jaringan Nirkabel (Wifi), Penyewa wajib menyampaikan kepada Pemilik.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>10.</td>
    <td colspan="2"><b>Periode Renovasi Ruang Sewa (Fitting-Out):</b></td>
  </tr>
  <?php
  $fitot=strlen($rkomisaris['pemberitahuan_ftout']);
  if ($fitot>0){
	$fitot=$rkomisaris['pemberitahuan_ftout'];
  }else{
	  $fitot=0;
  }

  $graceperiod=$fitot=strlen($row->fitting_out);
  if ($graceperiod>0){
	$graceperiod=$row->fitting_out;
  }else{
	  $graceperiod=0;
  }
  ?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="justify">Pemilik akan menyampaikan pemberitahuan  14 (Empat Belas) hari di muka agar Penyewa dapat memulai pekerjaan renovasi (fitting out) dan memberikan waktu untuk periode renovasi (fitting out) Ruang Sewa selama <?php echo number_format($graceperiod,0);?> (<?php echo number_to_wordsnorp(number_format($graceperiod,0));?>) minggu sejak berakhirnya pemberitahuan tersebut (selanjutnya disebut “Periode Fitting Out”). </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="justify">Pelaksanaan renovasi (fitting out) Ruang Sewa harus dikoordinasikan dengan Pemilik dengan standar dan peraturan untuk renovasi (fitting out) dan desain rencana renovasi (fitting out) harus mendapatkan persetujuan Pemilik.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="justify">Bilamana Ruang Sewa telah siap dibuka untuk berdagang sebelum berakhirnya Periode Fitting Out, berdasarkan persetujuan tertulis dariPemilik, Penyewa dapat membuka Ruang Sewa untuk berdagang dan Uang Sewa serta biaya-biaya lain harus dibayar sejak tanggal pembukaan tersebut.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>11.</td>
    <td colspan="2"><b>Standar Spesifikasi Ruang Sewa:</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="justify">Pemilik akan menyerahkan Ruang Sewa kepada Penyewa pada Tanggal Siap Serah Terima sesuai dengan spesifikasi standar sebagaimana terlampir di dalam <b>Apendik III</b> Kesepakatan Sewa Menyewa ini.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>12</td>
    <td colspan="2"><b>Jam Operasional:</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="justify">Jam operasional adalah hari Senin sampai dengan hari Minggu, yaitu dari pukul 10.00 sampai pukul 22.00 (waktu setempat) sebagaimana dari waktu ke waktu dapat diubah oleh Pemilik dengan suatu pemberitahuan kepada Penyewa 1 (satu) hari sebelumnya. Penyewa tidak diijinkan untuk beroperasi dan/atau tidak beroperasi selain pada jam operasional yang telah ditentukan.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>13.</td>
    <td colspan="2"><b>Ketentuan Khusus:</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Penyewa menyetujui syarat-syarat dan ketentuan sewa sebagaimana diatur dalam <b>Apendik IV</b> Kesepakatan Sewa Menyewa ini.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  </table>
  <div style="page-break-after: always; width:400" id="hal11"></div>
  <table width="753" border="0">
  <tr>
    <td>14.</td>
    <td colspan="2"><b>Lain-lain:</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">(a)</td>
    <td align="justify">Penyewa menjamin bahwa pihak yang menandatangani Kesepakatan Sewa Menyewa ini adalah pihak yang cakap secara hukum dan berwenang untuk membuat kesepakatan dengan pihak lain, termasuk Kesepakatan Sewa Menyewa ini, dan dengan ini mengesampingkan setiap hak yang dimiliki untuk mengklaim ketidaksahan penandatanganan Kesepakatan Sewa Menyewa ini.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">(b)</td>
    <td align="justify">Kesepakatan Sewa Menyewa ini berikut Lampirannya merupakan satu kesatuan dan bagian tidak terpisahkan.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(c)</td>
    <td align="justify">Setiap perubahan syarat dan ketentuan Kesepakatan Sewa Menyewa ini hanya dapat dilakukan dengan kesepakatan bersama secara tertulis.</td>
  </tr>
  <tr>
    <td height="50" colspan="3" align="justify" valign="top">Kesepakatan Sewa Menyewa ini dibuat dalam rangkap 2 (dua) dibubuhi dengan meterai cukup serta mempunyai kekuatan hukum yang pasti dan sama, untuk masing-masing pihak dan ditandatangani oleh pihak yang berwenang dari Para Pihak.</td>
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
    <td><?php echo $row->region_namereport;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Penyewa</td>
  </tr>
  <tr>
    <td height="137" nowrap="nowrap">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td><u><b><?php echo $rkomisaris['penanggung_jawab'];?></b></u></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><u><strong><?php echo $rkomisaris['penyewa'];?></strong></u></td>
  </tr>
  <tr>
    <td><?php echo $rkomisaris['jabatan_pemilik'];?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo $rkomisaris['jabatan_penyewa'];?></td>
  </tr>
  <?php if (trim($rkomisaris['penyewa2'])<>""){?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Penyewa</td>
  </tr>
  <tr>
    <td height="137">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><u><strong><?php echo $rkomisaris['penyewa2'];?></strong></u></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo $rkomisaris['jabatan_penyewa2'];?></td>
  </tr>
  <?php }?>
</table>
<?php }}?> 
</body>
</html>