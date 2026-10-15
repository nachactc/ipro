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
body {font-family: 'arial';font-size: 11pt}
@page { margin-left:4cm; margin-right:1.5cm; margin-top:2.5cm;margin-bottom:0.5cm;size:8.27in 11.69in;}
ol.dd {list-style-type: lower-alpha;}

</style>
</head>
<body>
<table width="753" border="0">
  <tr>
    <td width="626" align="center"><img src="<?php echo base_url('assets/img/transmart.jpg');?>" width="268" height="41" ></td>
  </tr>
</table> 
<SPAN> &nbsp; </SPAN>
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
foreach($result as $row){ 
$br_explode = explode(" ", $row->branch_name);
$branch = $br_explode[0]." ".$br_explode[1]." ".$br_explode[2] 
?>  
<table width="753" border="0">
  <tr>
    <td width="33">No</td>
    <td width="252">:&nbsp;<?php echo $row->loo_id;?></td>
    <td width="74">&nbsp;</td>
    <td width="379" align="right"><?php echo $new_date = date('d F Y', strtotime($row->loo_date));?></td>
  </tr>
</table>
<table width="753" border="0">

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="371"><b>Kepada Yth,</b></td>
    <td width="372" align="right"><u><?php echo $row->rekananshipping_name;?></u></td> 
  </tr>
  <tr>
    <td><b><?php echo $row->rekanancontact_name;?></b></td>
    <td width="372" align="right"><?php echo $branch;?></td>
  </tr>
  <tr>
    <td><?php echo $row->rekanan_name;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $row->rekanan_address;?></td>
    <td>&nbsp;</td>
  </tr> 
    <tr>
    <td>Telp.  <?php echo $row->rekanan_telp;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Email :<?php echo $row->rekanan_email;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
   <td colspan="2" align="center"><u><b>PERIHAL: SURAT   <?php echo $row->isapproved == 1 ? "KONFIRMASI" : "PENAWARAN" ?> SEWA di <?php echo $branch;?> </b></u></td>
  </tr>
  <tr>
    <td colspan="2">Dengan Hormat,</td>
  </tr> 
   <tr>
    <td colspan="2" align="justify">Bersama ini kami kirimkan Surat Konfirmasi Sewa untuk Ruang Sewa yaitu :<br /></td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td width="20"><strong>A.</strong></td>
    <td colspan="3"><strong>Ruang Sewa (sebagaimana terlampir):</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>1. Lantai	</td>
    <td>:</td>
    <td><?php echo $row->lantai_name;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>2. Nomor Unit</td>
    <td>:</td>
    <td><?php echo $vunitname;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>3. Luas</td>
    <td>:</td>
    <td>@ 1 (satu) unit ± M2/Unit ATM<br /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>4. Penggunaan Ruang Sewa</td>
    <td>:</td>
    <td>penjualan produk ATM<br /></td>
  </tr>
  <?php
  $alphabetv = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N');
  $vno=1;
 foreach($ritem as $rowitem){ 
  if ($rowitem->agreementtype_id=='9600'){
	  $vno=1;
	  ?>
  
  <tr>
    <td width="20"><strong><?php echo $alphabetv[$vno];?>.</strong></td>
    <td colspan="3"><strong>Lokasi Ruang Sewa Polesign (sebagaimana terlampir):</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>1. Property</td>
    <td>:</td>
    <td><?php echo $row->branch_name;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>2. Nomor Unit</td>
    <td>:</td>
    <td>Polesign</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>3. Jumlah/Luas (M2)</td>
    <td>:</td>
    <td>1 (Satu) Titik<br /></td>
  </tr>
  <?php $vno++; } } ?>
  
  
  
  <tr>
    <td width="20"><strong><?php echo $alphabetv[($vno)];?>.</strong></td>
    <td width="194"><strong>Periode Masa Sewa </strong></td>
    <td width="16">:</td>
    <td width="505"><b><?php echo $row->loo_term;?> (<?php echo trim(penyebut($row->loo_term));?>) Bulan</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>1.Mulai pada tanggal </td>
    <td>:</td>
    <td><?php echo DATE('d-m-Y',strtotime($row->loo_sdate));?> </td> 
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>2.Berakhir pada tanggal</td>
    <td>:</td>
    <td><?php echo DATE('d-m-Y',strtotime($row->loo_edate));?></td>
    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>  
	<td align="justify" valign="top">Tanggal awal sewa disesuaikan dengan Berita Acara penempatan mesin ATM. Dan apabila 1 (satu) minggu setelah penempatan mesin ATM belum diterbitkan berita acara </td>
  </tr>
  
  
  <tr>
    <td><strong><?php echo $alphabetv[($vno+1)];?>.</strong></td>
    <td colspan="3" ><strong>Jumlah dan Cara Pembayaran</strong></td>
  </tr>
  <?php $alphabet = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n');?>
  <?php 
$ino=0;
foreach($ritem as $rowitem){ 
?>
  <tr>
    <td>&nbsp;</td>
    <td valign="top"><?php echo $alphabet[$ino].".";?>&nbsp;
	<?php echo str_replace("Outlet Rental","Harga Sewa", $rowitem->agreementtype_name);?></td>
    <td valign="top">:</td>
    <td  valign="top" align="justify"><b>Rp. <?php echo number_format($rowitem->loodetil_baserent,0);?>&nbsp;<?php echo $rowitem->loodetil_descr;?></b> (Belum termasuk PPN).</td>
  </tr> 
  <?php if ($rowitem->agreementtype_id=='20000'){ 
  $ino++;
  ?>
  <tr>
    <td>&nbsp;</td>
    <td  valign="top"><?php echo $alphabet[$ino].".";?>&nbsp;Total Biaya sewa</td>
    <td  valign="top">:</td>
    <td  valign="top" align="justify"><b>Rp. <?php echo number_format($rowitem->loodetil_baserent*$row->loo_term,0);?>&nbsp;(<?php echo trim(penyebut($rowitem->loodetil_baserent*$row->loo_term));?> rupiah) Per unit ATM</b>&nbsp; (Belum termasuk PPN).</td>
  </tr>
  <?php } ?>
  
  <?php if ($rowitem->agreementtype_id=='9997'){ 
  $ino++;
  ?>
  <tr>
    <td>&nbsp;</td>
    <td  valign="top"><?php echo $alphabet[$ino].".";?>&nbsp;Total Biaya Listrik</td>
    <td  valign="top">:</td>
    <td  valign="top" align="justify">Rp. <?php echo number_format($rowitem->loodetil_baserent*$row->loo_term,0);?>&nbsp;Per unit ATM (Belum termasuk PPN & administrasi 10%).</td>
  </tr>
  <?php } ?>
  
   <?php if ($rowitem->agreementtype_id=='9600'){ 
  $ino++;
  ?>
  <tr>
    <td>&nbsp;</td>
    <td  valign="top"><?php echo $alphabet[$ino].".";?>&nbsp;Biaya total Polesign</td>
    <td  valign="top">:</td>
    <td  valign="top" align="justify">Rp. <?php echo number_format($rowitem->loodetil_baserent*$row->loo_term,0);?>&nbsp;Per unit ATM (Belum termasuk PPN & administrasi 10%).</td>
  </tr>
  <?php } ?>
  
<?php 
$ino++;
}
?>
  <tr>
    <td>&nbsp;</td>
    <td  valign="top"><?php echo $alphabet[$ino].".";?>&nbsp;&nbsp;Cara Pembayaran</td>
    <td  valign="top">:</td>
    <td  valign="top" align="justify"><?php echo $vloodes;?></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="justify">Terima kasih atas perhatiannya, dan apabila Bapak setuju harap ditandatangani pada kolom yang disediakan dan di email ke kami dengan alamat: yeni_yeni@transretail.co.id atau telepon 08126319284 / 021 – 275585000 ext 55881 atau fax 021 – 27585738 /27585899.<br /></td>
  </tr>
  <tr>
    <td colspan="4" align="justify">Setelah surat penawaran ini disepakati oleh para pihak, akan ditingkatkan menjadi surat kesepakatan paling lambat 7 (tujuh) hari untuk ditandatangani oleh para pihak.	</td>
  </tr>
</table>
<br />
<table width="753" border="0">
  <tr>
    <td width="355">Hormat kami,</td>
    <td width="37">&nbsp;</td>
    <td width="140">&nbsp;</td>
    <td width="203">Menyetujui,</td>
  </tr>
  <tr>
    <td><strong>PT TRANS RETAIL INDONESIA</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><b><?php echo $row->rekanan_name;?></b></td>
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
    <td><strong><u>Jozarki Terunajaya </u></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
  </tr>
  <tr>
    <td>Sr. GM Property</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>	
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><b><?php echo $row->rekanan_name;?></b></td>
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
    <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
  </tr>
</table>
<br />
<table width="753" border="0">   
      <tr>
        <td ><strong>PT Trans Retail Indonesia - SHOPPING MALL </strong></td>

      </tr>
      <tr>
        <td  align="justify">Head Office : Carrefour Lebak Bulus, 3rd Floor, Jl. Lebak Bulus Raya No. 8, Jakarta 12310</td>
      </tr>
      <tr>
        <td align="justify">Telp : 021 (2758.5800 ext. 55614)  Fax. : 021 (2758.5899)</td>
      </tr>
      </tr>

</table>
<?php }}?> 
</body>
</html>