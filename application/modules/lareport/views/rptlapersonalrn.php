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
    <td align="center"><b>AMENDMENT # 1 PERPANJANGAN PERJANJIAN SEWA</b></td>
  </tr>
  <tr>
    <td align="center"><strong>Antara</strong></td>
  </tr>
   <tr>
    <td align="center"><b><?php echo $row->region_namereport;?></b></td>
  </tr>
   <tr>
     <td align="center"><strong>Dan</strong></td>
   </tr>
   <tr>
     <td align="center"><strong><?php echo $row->rekanan_name;?></strong></td>
   </tr>
   <tr>
     <td align="center"><b>No. <?php echo $nolah;?></b></td>
   </tr>
   <tr>
     <td align="center">&nbsp;</td>
   </tr>
   <?php
   if (($rkomisaris['tgl_sign']<>"NULL") and ($rkomisaris['tgl_sign']<>"")){
   $orderdate = explode('-', $rkomisaris['tgl_sign']);
	$vtahun = $orderdate[0]+0;
	$vbulan= $orderdate[1]+0;
	$vtgl= $orderdate[2]+0;
	$v1=number_to_wordsnorp($vtgl);
	$v2=number_to_wordsnorp($vtahun); 
	
$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
 $hbulan=$BulanIndo[(int)$vbulan-1];
 $textgl=$v1." ".$hbulan." ".$v2;
 }else{
	$textgl=""; 
 }
   ?>
  <tr>
     <td align="justify">Pada hari ini Rabu, tanggal <?php echo $new_date = date('d F Y', strtotime($rkomisaris['tgl_sign']));?> (<?php echo $textgl;?>) telah diadakan Amendment Perjanjian Sewa antara :</td>
  </tr>
  </table>
  <br />
     <table width="753" border="0">
  <tr>
    <td width="21" align="center"><strong>I</strong></td>
    <td width="193"><b>Nama Perusahan</b></td><td width="19">:</td><td width="502"><b><?php echo $row->region_namereport;?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><b>Nama Penanggung Jawab</b></td>
    <td>:</td>
    <td><b><?php echo $rkomisaris['penanggung_jawab'];?></b></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><b>Jabatan</b></td>
    <td>:</td>
    <td><b><?php echo $rkomisaris['jabatan_pemilik'];?></b></td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top"><strong>Alamat</strong></td>
    <td>:</td>
    <td valign="top" align="justify"><b><?php echo $row->region_address;?></b></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Telepon </strong></td>
    <td>:</td>
    <td><b><?php echo $row->region_telp;?></b></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><b>Faksimili</b></td>
    <td>:</td>
    <td><b><?php echo $row->region_fax;?></b></td>
    </tr>
  <tr>
    <td colspan="4" height="40">Untuk selanjutnya disebut<strong> “PIHAK YANG MENYEWAKAN”</strong>.</td>
    </tr>
  <tr>
    <td align="center"><strong>II</strong></td>
    <td><b>Nama Perusahan</b></td>
    <td>:</td>
    <td><strong><?php echo $row->rekanan_name;?></strong></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><b>Nama Penanggung Jawab</b></td>
    <td>:</td>
    <td><strong><?php echo $rkomisaris['penyewa'];?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><b>Jabatan</b></td>
    <td>:</td>
    <td><b><?php echo $rkomisaris['jabatan_penyewa'];?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Nama Perorangan</strong></td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Nomor Indentitas</strong><br /></td>
    <td>:</td>
    <td><b><?php echo $row->rekanan_taxnik;?></b></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Nama Usaha</strong></td>
    <td>:</td>
    <td>&nbsp;</td>
    </tr>
<tr>
    <td valign="top">&nbsp;</td>
    <td valign="top"><strong>Alamat</strong></td>
    <td>:</td>
    <td valign="top" align="justify"><b><?php echo $row->rekanan_address;?></b></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Telepon</strong></td>
    <td>:</td>
    <td><b><?php echo $row->rekanan_telp;?></b></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Faksimili</strong></td>
    <td>:</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong> PIC</strong></td>
    <td>:</td>
    <td><b><?php echo $row->rekananshipping_contactname;?></b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    <td><strong>Email</strong></td>
    <td>:</td>
    <td><b><?php echo $row->rekanan_email;?></b></td>
    </tr>
    <tr>
      <td height="40" colspan="4">Untuk Selanjutnya disebut “<b>Penyewa</b>”</td>
      </tr>
    <tr>
      <td colspan="4" align="justify"><p>Oleh karena itu terlebih dahulu <strong>PIHAK YANG MENYEWAKAN</strong> dan <strong>PENYEWA</strong> menerangkan hal-hal sebagai  berikut :</p></td>
      </tr>
    <tr>
      <td valign="top">1.</td>
      <td colspan="3" align="justify"><p><?php echo $rkomisaris['noladulu'];?></p></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top">2.</td>
      <td colspan="3" align="justify">Bahwa Sewa Menyewa atas objek sewa berakhir sesuai dengan jangka  waktu dalam Perjanjian Sewa adalah sebagai berikut : </td>
      </tr>
      </table>
<table width="753" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td width="22" style="border-left:0px;">&nbsp;</td>
      <td width="190" style="border-left:1px solid;border-right:0;border-top:1px solid">Lokasi</td>
      <td width="17" align="center" style="border-left:1px solid;border-right:0;border-top:1px solid">:</td>
      <td width="531" style="border-left:1px solid;border-right:1px solid;border-top:1px solid"><?php echo $row->branch_namerpt;?></td>

  </tr>
    <tr>
      <td style="border-left:0px;">&nbsp;</td>
      <td style="border-left:1px solid;border-right:0;border-top:1px solid">Lantai</td>
      <td align="center" style="border-left:1px solid;border-right:0;border-top:1px solid">:</td>
      <td style="border-left:1px solid;border-right:1px solid;border-top:1px solid"><?php echo $vlantai;?></td>
    </tr>
    <tr>
      <td style="border-left:0px;">&nbsp;</td>
      <td style="border-left:1px solid;border-right:0;border-top:1px solid">Nomor Unit</td>
      <td align="center" style="border-left:1px solid;border-right:0;border-top:1px solid">:</td>
      <td style="border-left:1px solid;border-right:1px solid;border-top:1px solid"><?php echo $vunitname;?></td>
    </tr>
    <tr>
      <td style="border-left:0px;">&nbsp;</td>
      <td style="border-left:1px solid;border-right:0;border-top:1px solid">Luas</td>
      <td align="center" style="border-left:1px solid;border-right:0;border-top:1px solid">:</td>
      <td style="border-left:1px solid;border-right:1px solid;border-top:1px solid"><?php echo $vunitsqm;?> m2</td>
    </tr>
    <tr>
      <td style="border-left:0px;">&nbsp;</td>
      <td style="border-left:1px solid;border-right:0;border-top:1px solid">Tanggal Mulai Sewa</td>
      <td align="center" style="border-left:1px solid;border-right:0;border-top:1px solid">:</td>
      <td style="border-left:1px solid;border-right:1px solid;border-top:1px solid"><?php echo $new_date = date('d F Y', strtotime($row->loo_sdate));?></td>
    </tr>
    <tr>
      <td style="border-left:0px;">&nbsp;</td>
      <td style="border-left:1px solid;border-right:0;border-top:1px solid;border-bottom:1px solid">Tanggal Akhir Sewa</td>
      <td  align="center" style="border-left:1px solid;border-right:0;border-top:1px solid;border-bottom:1px solid">:</td>
      <td style="border-left:1px solid;border-right:1px solid;border-top:1px solid;border-bottom:1px solid"><?php echo $new_date = date('d F Y', strtotime($row->loo_edate));?></td>
    </tr>
  </table>
<table width="753" border="0">
  <tr>
    <td width="21" valign="top">3.</td>
    <td colspan="3" align="justify" valign="middle">Bahwa dengan berakhirnya jangka waktu sewa menyewa tersebut pada butir  2, <strong>PIHAK YANG MENYEWAKAN</strong> dan <strong>PENYEWA</strong> setuju dan sepakat untuk  memperpanjang kembali masa berlakunya Sewa Menyewa tersebut.
</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="3" align="justify" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">4.</td>
    <td colspan="3" align="justify">Bahwa terkait dengan butir 3 maka, <strong>PIHAK  YANG MENYEWAKAN</strong> dan <strong>PENYEWA </strong>telah  menandatangani Surat Kesepakatan Perpanjangan Sewa Menyewa Nomor <?php echo $loo_id;?>  tanggal <?php echo $new_date = date('d F Y', strtotime($rkomisaris['tgl_signloc']));?>.</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td colspan="3" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="justify">Selanjutnya <strong>PIHAK YANG MENYEWAKAN</strong> dan <strong>PENYEWA</strong>,  secara bersama-sama untuk selanjutnya disebut <strong>PARA PIHAK</strong> setuju untuk mengadakan perubahan, penambahan pada  Perjanjian Awal dengan syarat-syarat dan ketentuan-ketentuan yang  diatur dibawah ini sebagai berikut <strong>:</strong></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center"><strong>PASAL 1</strong></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><strong>SYARAT-SYARAT  &amp; KETENTUAN</strong></td>
  </tr>
  <tr>
    <td colspan="4" align="justify">Merubah ketentuan yang tercantum dalam perjanjian awal  yang mengatur syarat dan ketentuan, sehingga untuk selanjutnya tertulis dan  berbunyi sebagai berikut :</td>
  </tr>
</table>
  
  <table width="753" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="239"><strong>Perjanjian Awal</strong></td>
    <td width="309"><strong>Amendment #1</strong></td>
    </tr>
  <tr>
    <td width="32">3.3</td>
    <td width="145">Jangka Waktu Sewa</td>
    <td><?php echo $rtemplast;?> bulan <?php if ($rdaylast>0){ echo $rdaylast." hari";}?></td>
    <td><?php echo $row->agreement_term;?> bulan <?php if ($row->agreement_dayterm>0){ echo $row->agreement_dayterm." hari";}?></td>
    </tr>
  <tr>
    <td>3.5</td>
    <td>Uang Sewa</td>
    <td>Rp.<?php echo number_format($rsewalastnilai,0);?>,-/m2/bulan</td>
    <td>Rp.<?php echo number_format($rsewacurrent,0);?>,-/m2/bulan</td>
  </tr>
  <tr>
    <td>3.6</td>
    <td>Listrik</td>
    <td>Rp.<?php echo number_format($rlistriklast,0);?></td>
    <td>Rp.<?php echo number_format($rlistrikcurrent,0);?></td>
  </tr>
  <tr>
    <td>3.7</td>
    <td>Biaya Pelayanan</td>
    <td>Rp.<?php echo number_format($rsclast,0);?>,-/m2/bulan</td>
    <td>Rp.<?php echo number_format($rsccurrent,0);?>,-/m2/bulan</td>
  </tr>
  <tr>
    <td>3.8</td>
    <td>Simpanan Jaminan</td>
    <td>Rp.<?php echo number_format($rtotdepositdulu,0);?></td>
    <td>Rp.<?php echo number_format($rtotdeposit,0);?></td>
  </tr>
  <tr>
    <td>3.9</td>
    <td>Jaminan Telepon</td>
    <td>Rp.<?php echo number_format($rtotdeposittelpdulu,0);?></td>
    <td>Rp.<?php echo number_format($rtotdeposittelp,0);?></td>
  </tr>
  <tr>
    <td>3.10a</td>
    <td>Tanggal Mulai Sewa</td>
    <td><?php echo $new_date = date('d F Y', strtotime($rtmpstdate));?></td>
    <td><?php echo $new_date = date('d F Y', strtotime($row->loo_sdate));?></td>
  </tr>
  <tr>
    <td>3.10b</td>
    <td>Tanggal Akhir Sewa</td>
    <td><?php echo $new_date = date('d F Y', strtotime($rtmpedate));?></td>
    <td><?php echo $new_date = date('d F Y', strtotime($row->loo_edate));?></td>
  </tr>
  <tr>
    <td>3.19</td>
    <td>Foodcourt Levy</td>
    <td>Rp.<?php echo number_format($rfooddulu,0);?></td>
    <td>Rp.<?php echo number_format($rfood,0);?></td>
  </tr>
</table>
<table width="753" border="0">
 
  <tr>
    <td colspan="4" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center"><strong>PASAL 2</strong></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><strong>JADWAL  PEMBAYARAN</strong></td>
  </tr>
  <tr>
    <td colspan="4" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="justify">Merubah ketentuan yang mengatur  tentang Jadwal Pembayaran sebagaimana tercantum dalam Apendik II Perjanjian  Awal,  sehingga untuk selanjutnya tertulis dan berbunyi sebagaimana pada Apendik II  Jadwal Pembayaran yang sudah direvisi di dalam Amendment ini dengan rincian  sebagaimana terlampir.</td>
  </tr>
  <tr>
    <td colspan="4" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center"><strong>PASAL 3</strong></td>
  </tr>
  <tr>
    <td colspan="4" align="center"><b>LAIN - LAIN</b></td>
  </tr>
  <tr>
    <td colspan="4" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="justify"><p>Perubahan ini berlaku terhitung  sejak tanggal ditandatanganinya Amendment ini, sebagaimana disebutkan pada  bagian awal Amendment ini. </p></td>
  </tr>
  <tr>
    <td colspan="4" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="justify"><p>Syarat-syarat dan  ketentuan-ketentuan lain yang telah diatur pada Perjanjian Awal, yang tidak  dilakukan perubahan dalam Amendment ini, akan tetap berlaku dan mengikat PARA  PIHAK, termasuk pula bagi para pengganti haknya sepanjang tidak diatur lain  dalam Amendment ini. Amendment ini merupakan bagian yang tidak  terpisahkan dari Perjanjian Awal.</p></td>
  </tr>
  <tr>
    <td colspan="4" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="justify"><p>Amendment ini dibuat dalam rangkap 2  (dua) dibubuhi dengan meterai cukup serta mempunyai kekuatan hukum yang pasti  dan sama, untuk masing - masing pihak dan ditandatangani oleh pihak yang  berwenang dari PARA PIHAK.</p></td>
  </tr>
  <tr>
    <td colspan="4" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="justify">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="justify">&nbsp;</td>
  </tr>
  </table>
<table width="753" border="0">
  <tr>
    <td width="355"><p><strong>PIHAK YANG  MENYEWAKAN</strong></p></td>
    <td width="37">&nbsp;</td>
    <td width="140">&nbsp;</td>
    <td width="203"><strong>PENYEWA</strong></td>
  </tr>
  <tr>
    <td><strong>PT TRANS RETAIL INDONESIA</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="95" nowrap="nowrap">&nbsp;</td>
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
</table>
<?php }}?> 
</body>
</html>