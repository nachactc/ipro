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
//$br_explode = explode(" ", $row->branch_name);
$branch =$row->branch_name;  
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
   <td colspan="2" align="center"><u><b>SURAT   <?php echo $row->isapproved == 1 ? "KONFIRMASI" : "PENAWARAN" ?> SEWA MENYEWA 
   <br/> <?php echo $row->rekananshipping_name;?> <br/>
   <?php echo $branch;?> </b></u></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
   <tr>
    <td colspan="2" align="justify">Bersama ini kami kirimkan Surat <?php echo $row->isapproved == 1 ? "konfirmasi" : "penawaran" ?>  Sewa menyewa antara Transmart <?php echo $row->region_name;?> dalam hal ini disebut sebagai "Pemilik" dengan  <?php echo $row->rekanan_name;?>. (yang selanjutnya disebut Penyewa) di Properti Transmart tersebut dibawah ini :<br /></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr> 
   <tr>
    <td>Dalam Kesepakatan Sewa Menyewa ini, para pihak sepakat dengan ketentuan sebagai berikut:</td> 
  </tr> 
</table>
 <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<table width="753" border="0">
  <tr>
    <td width="20"><strong>A.</strong></td>
    <td colspan="3"><strong>Ruang Sewa (sebagaimana terlampir):</strong></td>
  </tr>
  <tr>
	<td width="20"><strong>&nbsp;</strong></td>
	<td colspan="5" align="justify" valign="top">
		 <table width="758" border="1" style="border-collapse:collapse">
		  <tr>
		  <td align="center" width="22"><strong>No</strong></td>
		  <td width="279" align="center"><strong>Store</strong></td>
		  <td width="15" align="center"><strong>Rental(Rp)</strong></td>
		  <td width="15" align="center"><strong>Listrik(Rp)</strong></td>
		  <td width="15" align="center"><strong>Polesign(Rp)</strong></td>
		  <td width="48" align="center"><strong>Area (m2)</strong></td>
		  <td width="48" align="center"><strong>Periode Month</strong></td> 
		  <td width="68" align="center"><strong>RCD</strong></td>
		  <td width="68" align="center"><strong>LED</strong></td>
		  </tr>
		<?php $count = 0; echo showTabelatm($row->loo_id,$count);  ?> 
		  </table> 
		  <span style="font-family: 'arial';font-size: 9pt text-align:justify"> Note: - <i> Harga Rental/unit/bulan belum termasuk PPN 10% </i> </span>
		<br/>		  
		<br/>		  
		  <P  style="font-family: 'arial';font-size: 10pt text-align:justify" > 
		  Tanggal awal sewa disesuaikan dengan Berita Acara penempatan mesin ATM. Dan apabila 1 (satu) minggu setelah penempatan mesin ATM belum diterbitkan berita acara tersebut oleh pihak bank, maka tanggal mulai sewa disesuaikan dengan tanggal pembuatan surat konfirmasi sewa. 
		  </P> 
	</td> 
	</tr> 
  <?php
  $alphabetv = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N');
  $vno=1;
   
  // echo "<pre>";
  // echo var_dump($ritem);
  
  //exit;
?> 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>  
	<td align="justify" valign="top">&nbsp;</td>
  </tr>
  
    <tr>
    <td width="20"><strong>B.</strong></td>
    <td width="194"><strong>Periode Fitting Out</strong></td>
    <td width="16">:</td>
    <td width="505"><b><?php echo $row->fitting_out;?> (<?php echo trim(penyebut($row->fitting_out));?>) Minggu</b></td>
  </tr>
  <tr>
    <td><strong>C.</strong></td>
    <td colspan="3" ><strong>Syarat & Kondisi Sewa</strong></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td  valign="top">1.&nbsp;Total Uang sewa 
	<span> &nbsp;&nbsp;&nbsp; </span> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; (<?php echo $count ; ?>) Property
	</td>
    <td  valign="top">:</td>
    <td  valign="top" align="justify"><b>Rp. 
	<?php   
	echo number_format(($sumSewa + ($sumSewa*0.1)) ,0);?>&nbsp;</b>&nbsp;ditambah PPn</td>
  </tr>
  
   
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td  valign="top">2.&nbsp;Total Listrik</td>
    <td  valign="top">:</td>
    <td  valign="top" align="justify"><b>Rp. 
	<?php  
	  echo number_format($sumListrik + (( $sumListrik * 0.1) + ($sumListrik * 0.1)) ,0); 
	?>&nbsp; </b>&nbsp;ditambah Administrasi 10% dan PPn</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td  valign="top">4.&nbsp;Total PoleSign</td>
    <td  valign="top">:</td>
    <td  valign="top" align="justify"><b>Rp. 
	<?php  
	  echo number_format($sumPolesign + (( $sumPolesign * 0.1) + ($sumPolesign * 0.1)) ,0);  
	?>&nbsp; </b>&nbsp;ditambah Administrasi 10% dan PPn</td>
  </tr> 
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td  valign="top">5.&nbsp;&nbsp;Cara Pembayaran</td>
    <td  valign="top">:</td>
    <td  valign="top" align="justify">Cara pembayaran point 1 -6 tersebut diatas harus dibayarkan 100 % dimuka atau sebelum penempatan mesin ATM. </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td  valign="top">6.&nbsp;&nbsp;Biaya Pelayanan</td>
    <td  valign="top">&nbsp;</td>
    <td  valign="top" align="justify">&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td  valign="top">&nbsp;&nbsp;&nbsp;&nbsp;(Service Charge)</td>
    <td  valign="top">:</td>
    <td  valign="top" align="justify"><b>Rp.	 0</b> 	/ m2 / Bulan ditambah PPn </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;(Tidak Diberlakukan)</td>
    <td>&nbsp;</td>
    <td valign="top" align="justify">Dibayarkan setiap 1 ( satu ) bulan dimuka  dan pembayaran biaya pelayanan pertama kali harus dimulai sejak tanggal mulai sewa. Biaya Pelayanan akan ditinjau ulang setiap awal tahun.					
</td>
 
 <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
 <tr>
    <td>&nbsp;</td>
    <td  valign="top">7.&nbsp;&nbsp;Jaminan Sewa</td>
    <td  valign="top">:</td>
    <td  valign="top" align="justify"><b>Rp.	 0</b> 	bulan Uang Sewa dan Service Charge  </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;(Tidak Diberlakukan)</td>
    <td>&nbsp;</td>
    <td valign="top" align="justify">Jaminan sewa  tersebut  dapat  dikembalikan  secara utuh,  tanpa bunga  pada  masa   berakhirnya  masa  sewa. </td>
  </tr>
 
 <tr>
    <td>&nbsp;</td>
    <td  valign="top">8.&nbsp;&nbsp;Telepon</td>
    <td  valign="top">:</td>
    <td  valign="top" align="justify">Pihak Pemilik akan menyediakan minimal 1 (satu) line telepon untuk setiap ruang usaha dengan biaya deposit sebesar <b>Rp. 3.500.000,-</b> (Tiga Juta Lima Ratus Ribu Rupiah) (Refundable) per line dengan biaya penyambungan sebesar Rp. <b>1.000.000,-</b> (Satu Juta Rupiah). Penyewa wajib menginformasikan kepada Pemilik perihal tidak akan menggunakan saluran telepon di Ruang Sewa. </td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top" align="justify">Pihak Pemilik akan menyediakan Jaringan Nirkabel (wifi) dengan biaya pemakaian yang akan ditentukan dan diinformasikan kemudian.</td>
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
    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td  valign="top">9.&nbsp;&nbsp;Masa berlaku Surat Konfirmasi Sewa :</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td> 
    <td  valign="top" align="justify"><span>&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Surat Konfirmasi Sewa ini berlaku 1 minggu sejak diterbitkan dan akan ditingkatkan menjadi Kesepakatan </td>
  </tr>
  <tr>
    <td>&nbsp;</td> 
    <td  valign="top" align="justify"><span>&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sewa (Perjanjian Sewa) setelah ditandatangani oleh Penyewa.</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td  valign="top">10.&nbsp;&nbsp;Ketentuan Khusus :</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td> 
    <td  valign="top" align="justify"><span>&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Penyewa tidak berhak mengakhiri Surat Konfirmasi Sewa dan Perjanjian Sewa Menyewa sebelum 								
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td> 
    <td  valign="top" align="justify"><span>&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tanggal Pengakhiran Sewa, dengan atau tanpa alasan- alasan apapun.		
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td> 
    <td  valign="top" align="justify"><span>&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-Dalam hal terjadi Pengakhiran Sewa sebelum Tanggal Pengakhiran Sewa, maka Uang yang telah 						
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td> 
    <td  valign="top" align="justify"><span>&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;dibayarkan menjadi hangus dan tidak dapat diambil kembali oleh Penyewa dan Penyewa wajib melunasi 	
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td> 
    <td  valign="top" align="justify"><span>&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;pembayaran sewa sampai dengan akhir sewa.  Pemilik tidak wajib untuk menyerahkan kembali 
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td> 
    <td  valign="top" align="justify"><span>&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Penyewa dan Perjanjian ini dinyatakan batal demi hukum
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td> 
    <td  valign="top" align="justify"><span>&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Layout sewaktu-waktu dapat berubah sesuai dengan commercial plan sampai dengan Perjanjian Sewa 									
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td> 
    <td  valign="top" align="justify"><span>&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Menyewa di tandatangani.
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td> 
    <td  valign="top" align="justify"><span>&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-Penyewa wajib menyerahkan fotocopy NPWP, KTP dan Dokumen Legal Perusahaan (apabila PT &/CV)									
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td> 
    <td  valign="top" align="justify"><span>&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-Pembayaran dapat dilakukan ke Nomor Rekening yang tercantum pada  Invoice </td>
  </tr>
  
  </table>
  
  <table width="753" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="justify">Terima kasih atas perhatiannya, dan apabila Bapak setuju harap ditandatangani pada kolom yang disediakan dan di email ke kami dengan alamat: yeni_yeni@transretail.co.id atau telepon 08126319284 / 021 – 275585000 ext 55881 atau fax 021 – 27585738 /27585899.<br /></td>
  </tr> 

<br />
  </table>
  
<table width="753" border="0">
  <tr>
    <td width="355">&nbsp;</td>
    <td width="37">&nbsp;</td>
    <td width="140">&nbsp;</td>
    <td width="203">&nbsp;</td>
  </tr>
  <tr>
    <td width="355">Hormat kami,</td>
    <td width="37">&nbsp;</td>
    <td width="140">&nbsp;</td>
    <td width="203">Menyetujui,</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td>Sr. GM Mall Manajement</td>
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
        <td>&nbsp;</td>
      </tr>  
	  <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
      </tr>  
	  <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
      </tr>
	  
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