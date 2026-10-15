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
body {font-family: 'zaskiagothic';font-size: 12pt}
@page { margin-left:4cm; margin-right:1.5cm; margin-top:2.5cm;margin-bottom:0.5cm;size:8.27in 11.69in;}


</style>
</head>
<body>
<table width="753" border="0">
  <tr>
    <td width="626" align="center"><img src="<?php echo base_url('assets/img/transmart.jpg');?>" width="268" height="41" ></td>
  </tr>
</table>
<p>&nbsp;</p>
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
    <td width="33">No</td>
    <td width="252">:&nbsp;<?php echo $row->loo_id;?></td>
    <td width="74">&nbsp;</td>
    <td width="379" align="right"><?php echo $new_date = date('d F Y', strtotime($row->loo_date));?></td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td width="371"><b><?php echo $row->rekanancontact_name;?></b></td>
    <td width="372" align="right"><?php echo $row->branch_name;?></td>
  </tr>
  <tr>
    <td><?php echo $row->rekananshipping_name;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $row->rekananshipping_address;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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
    <td colspan="2"><b>PERIHAL: Surat Penawaran Untuk "<?php echo $row->rekananshipping_name;?>" di <?php echo $row->branch_name;?></b></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Dengan Hormat,</td>
  </tr>
  <tr>
    <td colspan="2" align="justify">Bersama ini kami sampaikan Surat Penawaran untuk <?php echo $row->rekananshipping_name;?> dengan ketentuan dan syarat-syarat sebagaimana tersebut dibawah ini. </td>
  </tr>
  <tr>
    <td colspan="2"><strong>- Ruang Sewa (sebagaimana terlampir):</strong></td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td width="20">a.</td>
    <td width="194">Lantai</td>
    <td width="16">:</td>
    <td width="505"><?php echo $row->lantai_name;?></td>
  </tr>
  <tr>
    <td width="20">b.</td>
    <td width="194">Nomor Unit</td>
    <td width="16">:</td>
    <td width="505"><?php echo $vunitname;?></td>
  </tr>
  <tr>
    <td width="20">c.</td>
    <td width="194">Luas </td>
    <td width="16">:</td>
    <td width="505"><?php echo $vunitsqm;?> M2</td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td width="213"><strong>- Periode Masa Sewa</strong></td>
    <td width="19">:</td>
    <td width="507"><?php echo $row->loo_term;?> Bulan</td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td width="26">a.</td>
    <td width="186">Mulai pada tanggal</td>
    <td width="17">:</td>
    <td width="506"><?php echo $new_date = date('d F Y', strtotime($row->loo_sdate));?></td>
  </tr>
  <tr>
    <td>b.</td>
    <td>Berakhir pada tanggal</td>
    <td>:</td>
    <td><?php echo $new_date = date('d F Y', strtotime($row->loo_edate));?></td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td width="573"><strong>TERM &amp; CONDITION</strong></td>
  </tr>
</table>
<table width="753" border="0">

<?php 
$ix=0;
foreach($vhargasewa as $rowsewa){ 
?>
  <tr>
    <td width="20"><?php if ($ix==0){?><strong>1</strong><?php } ?></td>
    <td width="199"><?php if ($ix==0){?><strong>Harga Sewa</strong><?php } ?></td>
    <td width="15">:</td>
    <td width="501"> Rp. <?php echo number_format($rowsewa->loodetil_baserent,0);?><?php echo $rowsewa->titleharga;?></td>
  </tr>
<?php 
$ix++;
} 

?>  
  
  <tr>
    <td valign="top"><strong>2</strong></td>
    <td valign="top"><strong>Cara Pembayaran</strong></td>
    <td valign="top">:</td>
    <td align="justify"><?php echo $vloodes;;?></td>
  </tr>
  
<?php 
$ino=3;
foreach($ritem as $rowitem){ 
?>  
    <tr>
    <td valign="top"  width="20"><strong><?php echo $ino;?></strong></td>
    <td valign="top" width="199"><strong><?php echo $rowitem->agreementtype_name;?></strong></td>
    <td valign="top" width="15">:</td>
    <td align="justify" valign="top" width="501"><?php if (($rowitem->loodetil_percent!=='1') and ($rowitem->loodetil_baserent > 0))
	 { echo "Rp.";}?> <?php if ($rowitem->loodetil_baserent > 0) { echo number_format($rowitem->loodetil_baserent,0); } if (($rowitem->loodetil_percent=='1') and ($rowitem->loodetil_baserent > 0)){ echo "%";} ?><?php echo $rowitem->loodetil_descr;?> </td>
  </tr>
  <?php 
  $ino++;
}
?>


  <tr>
    <td><strong><?php echo $ino;?></strong></td>
    <td colspan="3"><strong>Masa berlaku Surat Penawaran :</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Penawaran ini berlaku 1 minggu sejak surat diterbitkan dan semua penawaran berdasarkan dari first come first serve basis.</td>
  </tr>
  <tr>
    <td><strong><?php echo $ino+1;?></strong></td>
    <td colspan="3"><strong>Ketentuan Khusus :</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Layout sewaktu-waktu dapat berubah sesuai dengan commercial plan.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Terima kasih  atas  perhatiannya  dan  bila Bapak setuju,  harap ditanda tangani  pada kolom yang disediakan  dan  di  email kembali ke kami dengan alamat sbb:   setyawati_setyawati@transretail.co.id  atau tanti_triandini@transretail.co.id atau Ihya_Nasution@transretail.co.id. Jika ada pertanyaan lebih lanjut dapat menghubungi Tanti Triandini 081808093931 /Ihya Nasution 081223023016</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="justify">Setelah surat penawaran ini disepakati oleh para pihak, akan ditingkatkan menjadi surat kesepakatan paling lambat 7 hari untuk ditandatangani kembali oleh para pihak</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="753" border="0">
  <tr>
    <td width="355">Hormat kami,</td>
    <td width="37">&nbsp;</td>
    <td width="140">&nbsp;</td>
    <td width="203">Menyetujui penawaran tsb</td>
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
    <td><strong><u>Tanti Triandini </u></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
  </tr>
  <tr>
    <td>Senior Leasing Manager</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
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
      <tr>
        <td align="justify">PIC. Tanti Triandini (081808093931) atau Ihya Nasution (081223023016)</td>
      </tr>
      <tr>
        <td align="justify">Email : tanti_triandini@transretail.co.id atau Ihya_Nasution@transretail.co.id</td>
      </tr>

  </tr>

</table>
<?php }}?> 
</body>
</html>