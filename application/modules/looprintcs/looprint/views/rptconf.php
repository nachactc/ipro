<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
@font-face {
    font-family: 'zaskiagothic'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/GOTHIC.ttf');?>'); /*URL to font*/
}
body {font-family: 'zaskiagothic';font-size: 9pt;}
</style>
</head>

<body>
<table width="753" border="0">
  <tr>
    <td width="626" align="center"><img src="<?php echo base_url('assets/img/transmart.jpg');?>" width="268" height="91" ></td>
  </tr>
</table>
<p>&nbsp;</p>
 <?php 
 
  if(isset($result)){
 	  $pasunitname = '';
	  $pasunitsqm = '';
	  foreach($vunit as $rowunit){ 
	  		$pasunitname .= $rowunit->unit_name. '/'; 
			$pasunitsqm .= $rowunit->unit_sqm. '/'; 
			

	  }}
	  $vunitname = trim($pasunitname, "/");
	  $vunitsqm = trim($pasunitsqm, "/");
   
 if(isset($result)){
foreach($result as $row){ ?>  
<table width="753" border="0">
  <tr>
    <td width="64">Ref  No</td>
    <td width="221">:&nbsp;<?php echo $row->conf_id;?></td>
    <td width="74">&nbsp;</td>
    <td width="187" align="right"><?php echo $new_date = date('d F Y', strtotime($row->loo_date));?>&nbsp;&nbsp;&nbsp;</td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td><strong>Kepada Yth</strong></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td width="371"><b><?php echo $row->rekanancontact_name;?></b></td>
    <td width="176" align="right">&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $row->rekananshipping_name;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $row->rekanan_address;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $row->rekanan_city;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Telp.  <?php echo $row->rekanan_telp;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Email :</td>
    <td><?php echo $row->rekanan_email;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><b>Perihal: Konfirmasi Sewa "<?php echo $row->rekananshipping_name;?>" di <?php echo $row->branch_name;?></b></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Dengan Hormat,</td>
  </tr>
  <tr>
    <td colspan="2"><div align="justify">Sebelumnya kami ucapkan terima kasih atas kerjasama yang terjalin dengan baik dan semoga kerjasama ini dapat terus terjalin dengan baik.</div></td>
  </tr>
  <tr>
    <td colspan="2"><div style="text-align:center">Melanjutkan pembicaraan dengan Ibu perihal penawaran unit ruang sewa, telah kami ajukan dan diskusikan kembali dengan manajemen. Bersama surat ini kami sampaikan kondisi sewa terbaik yang dapat manajemen kami berikan:</div></td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td width="44">1.</td>
    <td width="197">Level / Unit</td>
    <td width="21">:</td>
    <td width="473"><?php echo $vunitname;?></td>
  </tr>
  <tr>
    <td>2.</td>
    <td>Luas Area</td>
    <td>:</td>
    <td><?php echo $vunitsqm;?> m2</td>
  </tr>
  <?php 
$ix=0;
foreach($vhargasewa as $rowsewa){ 
?>
  <tr>
    <td><?php if ($ix==0){?>3.<?php } ?></td>
    <td><?php if ($ix==0){?>Biaya sewa<?php } ?></td>
    <td><?php if ($ix==0){?>:<?php } ?></td>
    <td><?php echo $rowsewa->titleharga;?> Rp. <?php echo number_format($rowsewa->loodetil_baserent,0);?>/ m2 / Bulan tidak termasuk PPn</td>
  </tr>
<?php 
$ix++;
} 
?>  
  <tr>
    <td valign="top">4.</td>
    <td valign="top">Biaya Pelayanan</td>
    <td valign="top">:</td>
    <td>
      <div align="justify"><?php echo number_format($vhargasc,0);?>,-/m2/bulan (diluar PPN 10%)<br />
        berlaku untuk tahun ke-1 dan akan ditinjau ulang setiap tahun 
        Biaya Pelayanan dibayarkan per 3 (tiga) bulan di muka.
    </div></td>
  </tr>
  <tr>
    <td valign="top">5.</td>
    <td valign="top">Biaya Utilitas	</td>
    <td valign="top">:</td>
    <td>Based on Kwh Meter <br />(di luar biaya administrasi 10% dan PPN 10%)</td>
  </tr>
  <tr>
    <td valign="top">6.</td>
    <td valign="top">Periode Sewa	</td>
    <td valign="top">:</td>
    <td><?php echo $new_date = date('d F Y', strtotime($row->loo_sdate));?> - <?php echo $new_date = date('d F Y', strtotime($row->loo_edate));?> (<?php echo $row->loo_term;?>) Bulan</td>
  </tr>
  <tr>
    <td valign="top">7.</td>
    <td valign="top">Cara Pembayaran</td>
    <td valign="top">:</td>
    <td><div align="justify">DP 20% dibayarkan setelah ditandatangani Surat Kesepakatan Sewa
      Sisa 80% dibayarkan dalam 48 (empat puluh delapan) kali angsuran dimulai sejak Tanggal  Mulai Sewa
    </div></td>
  </tr>
  <tr>
    <td valign="top">8.</td>
    <td valign="top">Jaminan Sewa</td>
    <td valign="top">:</td>
    <td><div align="justify">Rp. <?php echo number_format($nildps,0);?><br />
      3 (tiga) bulan Biaya Sewa dan 3 (tiga) bulan Biaya Pelayanan
    (dibayarkan setelah ditandatangani Surat Kesepakatan Sewa) </div></td>
  </tr>
  <tr>
    <td valign="top">9.</td>
    <td valign="top">Jaminan Telepon (jika menggunakan)</td>
    <td valign="top">:</td>
    <td valign="top">Rp. 3.500.000,-/line telepon dengan biaya instalasi telepon <br />Rp. 1.000.000,-/line telepon </td>
  </tr>
  <tr>
    <td valign="top">10.</td>
    <td valign="top">Fit Out</td>
    <td valign="top">:</td>
    <td valign="top">1 bulan sejak tanggal serah terima ruang sewa</td>
  </tr>
  <tr>
    <td valign="top">11.</td>
    <td valign="top">Grace Periode</td>
    <td valign="top">:</td>
    <td valign="top"><div align="justify">Pemilik akan memberikan 2 bulan grace periode jika Penyewa dapat  
    membuka outletnya bersamaan dengan opening Transmart Palembang</div></td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td width="565"><div align="justify">Apabila Bapak/Ibu menyetujui penawaran kami di atas, mohon menandatangani surat ini untuk kami proses lebih lanjut.</div></td>
    
  </tr>
  <tr>
    <td><div align="justify">Demikian yang dapat kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="753" border="0">
  <tr>
    <td width="265">Hormat kami,</td>
    <td width="27">&nbsp;</td>
    <td width="92">&nbsp;</td>
    <td width="162">Menyetujui,</td>
  </tr>
  <tr>
    <td><strong>PT TRANS RETAIL INDONESIA</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><b><?php echo $row->rekananshipping_name;?></b></td>
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
    <td><strong><u>Ihya Nasution</u></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
  </tr>
  <tr>
    <td>Sr GM Mall Management</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>
  <?php }}?> 
</p>
</body>
</html>