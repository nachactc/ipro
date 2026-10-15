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
@page { margin-left:3.5cm; margin-right:3cm; margin-top:3cm;margin-bottom:0.5cm;size:8.27in 11.69in;}
table, tr, td {
  font-family: 'arial';font-size: 12pt;
}

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
    <td width="100">Kepada Yth.</td>
    <td width="16">&nbsp;</td>
    <td width="251" align="right">&nbsp;</td>
    <td align="right"><?php echo $row->branch_namerpt;?></td>
  </tr>\
  
  <tr>
    <td colspan="3"><b>Bapak/Ibu <?php echo $row->rekananshipping_contactname;?></b></td>
    <td width="368" align="right"><?php echo $row->rekananshipping_name;?></td>
  </tr>
  <tr>
    <td colspan="4"><b><?php 
	$rkn=substr($row->rekanan_name,0,2);
	$rkn=strtoupper($rkn);
	if ( (trim($rkn)=='PT') or (trim($rkn)=='CV') ){
			echo $row->rekanan_name;
	}else{
			echo $row->rekananshipping_name;
	}
	?></b></td>
  </tr>
  <tr>
    <td valign="top">Alamat</td>
    <td valign="top">:</td>
    <td colspan="2" valign="middle"><?php echo $row->rekananshipping_address;?></td>
  </tr>
  <tr>
    <td valign="top">Telp.  </td>
    <td valign="top">: </td>
    <td colspan="2" valign="top"><?php echo $row->rekanan_telp;?></td>
  </tr>
  <tr>
    <td valign="top">Email</td>
    <td valign="top">:</td>
    <td colspan="2" valign="top"><?php echo $row->rekanan_email;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><b>PERIHAL : SURAT KONFIRMASI SEWA "<?php echo $row->rekananshipping_name;?>" di <?php echo $row->branch_namerpt;?></b></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Dengan Hormat,</td>
  </tr>
  <tr>
    <td colspan="4" align="justify">Bersama ini kami kirimkan Surat Konfirmasi Sewa untuk Ruang Sewa yaitu :</td>
  </tr>
  <tr>
    <td colspan="4"><strong>A. Ruang Sewa (sebagaimana terlampir):</strong></td>
  </tr>
</table>
<table width="753" border="0">
  <tr>
    <td width="13">&nbsp;</td>
    <td width="27" align="center">1</td>
    <td width="89">Lantai</td>
    <td width="105">&nbsp;</td>
    <td width="11">:</td>
    <td width="482"><?php echo $row->lantai_name;?></td>
  </tr>
  <tr>
    <td width="13">&nbsp;</td>
    <td width="27" align="center">2</td>
    <td width="89">Nomor Unit</td>
    <td width="105">&nbsp;</td>
    <td width="11">:</td>
    <td width="482"><?php echo $vunitname;?></td>
  </tr>
  <tr>
    <td width="13">&nbsp;</td>
    <td width="27" align="center">3</td>
    <td width="89">Luas </td>
    <td width="105" align="right">&nbsp;</td>
    <td width="11">:</td>
    <td width="482"><?php echo $vunitsqm;?> M2</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">4</td>
    <td colspan="2" align="left">Operator</td>
    <td>:</td>
    <td><?php echo $row->rekananshipping_name;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">5</td>
    <td colspan="2" align="left">Penggunaan Ruang Sewa</td>
    <td>:</td>
    <td><?php echo $row->product_name;?></td>
  </tr>
  <tr>
    <td colspan="4"><strong>B. Periode Masa Sewa</strong></td>
    <td>:</td>
    <td><?php echo $row->loo_term;?> Bulan</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">1</td>
    <td colspan="2" align="left">Mulai pada tanggal</td>
    <td>:</td>
    <td><?php echo $new_date = date('d F Y', strtotime($row->loo_sdate));?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">2</td>
    <td colspan="2" align="left">Berakhir pada tanggal</td>
    <td>:</td>
    <td><?php echo $new_date = date('d F Y', strtotime($row->loo_edate));?></td>
  </tr>
  <tr>
    <td colspan="4"><strong>C. Periode Fitting Out</strong></td>
    <td>:</td>
    <td><?php echo $row->fitting_out;?> Minggu</td>
  </tr>
  <tr>
    <td colspan="4"><strong>D. Syarat &amp; Kondisi Sewa</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php 
$ix=0;
foreach($vhargasewa as $rowsewa){ 
?>
  <?php 
$ix++;
} 

?> 
  <tr>
    <td>&nbsp;</td>
    <td align="center">1</td>
    <td colspan="2" valign="top">Uang Sewa</td>
    <td valign="top">:</td>
    <td valign="top" align="justify">Rp. <?php echo number_format($row->loodetil_baserent,0);?> <?php echo $row->loodetil_descr;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="2" valign="top">Cara Pembayaran</td>
    <td valign="top">:</td>
    <td valign="top" align="justify">Total Sewa 100% dibayarkan dimuka setelah Perjanjian Sewa Menyewa ditandatangani kedua belah pihak dilengkapi invoice & faktur pajak.</td>
  </tr>
   <tr>
     <td>&nbsp;</td>
     <td align="center">2</td>
     <td colspan="2" valign="top">Biaya Pelayanan</td>
     <td valign="top">&nbsp;</td>
     <td valign="top" align="justify">Rp. <?php echo number_format($vhargasc,0);?> / Operator / Tahun ditambah PPn</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td align="center">&nbsp;</td>
     <td colspan="2" valign="top">(Tidak diberlakukan)</td>
     <td valign="top">&nbsp;</td>
     <td valign="top" align="justify">Dibayarkan setiap 1 ( satu ) bulan dimuka  dan pembayaran biaya pelayanan pertama kali harus dimulai sejak tanggal mulai sewa. Biaya Pelayanan akan ditinjau ulang setiap awal tahun.</td>
   </tr>
   <tr>
    <td>&nbsp;</td>
    <td align="center">3</td>
    <td colspan="2" valign="top">Grace Period</td>
    <td valign="top">:</td>
    <td valign="top" align="justify"><?php echo $row->grace_period;?>&nbsp;Bulan</td>
  </tr>
   <tr>
     <td>&nbsp;</td>
     <td align="center" valign="top">&nbsp;</td>
     <td colspan="2" valign="top">(Tidak diberlakukan)</td>
     <td valign="top">&nbsp;</td>
     <td valign="top" align="justify">Apabila Penyewa membuka toko tepat waktu bersamaan dengan pembukaan Transmart sesuai dengan tanggal yang ditetapkan Pemilik, Penyewa diberikan masa bebas angsuran sewa (grace period).</td>
   </tr>  
<tr>
     <td>&nbsp;</td>
     <td align="center" valign="top">4</td>
     <td colspan="2" valign="top">Jaminan Sewa</td>
     <td valign="top">:</td>
     <td valign="top" align="justify">Rp. <?php echo number_format($vdepositrsc,0);?> bulan Uang Sewa dan Service Charge</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td align="center" valign="top">&nbsp;</td>
     <td colspan="2" valign="top">(Tidak diberlakukan)</td>
     <td valign="top">&nbsp;</td>
     <td valign="top" align="justify">Jaminan sewa  tersebut  dapat  dikembalikan  secara utuh,  tanpa bunga  pada  masa   berakhirnya  masa  sewa.</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td align="center" valign="top">5</td>
     <td colspan="2" valign="top">Listrik</td>
     <td valign="top">:</td>
     <td valign="top" align="justify">Berdasarkan pemakaian bulanan ditambah administrasi 10% dan Ppn.</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td align="center" valign="top">6</td>
     <td colspan="2" valign="top">Telepon</td>
     <td valign="top">:</td>
     <td valign="top" align="justify">Pihak Pemilik akan menyediakan minimal 0 (nol) line telepon untuk setiap ruang usaha dengan biaya deposit sebesar Rp. <?php echo number_format($vtelpondeposit,0);?> (Refundable) per line dengan biaya penyambungan sebesar Rp. <?php echo number_format($vtelponinstal,0);?>. Penyewa wajib menginformasikan kepada Pemilik perihal tidak akan menggunakan saluran telepon di Ruang Sewa.</td>
   </tr>   
   <tr>
     <td>&nbsp;</td>
     <td align="center" valign="top">7</td>
     <td colspan="4" valign="top">Masa berlaku Surat Konfirmasi Sewa</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td align="center" valign="top">&nbsp;</td>
     <td colspan="4" valign="top" align="justify">Surat Konfirmasi Sewa ini berlaku 1 minggu sejak diterbitkan dan akan ditingkatkan menjadi Kesepakatan Sewa (Perjanjian Sewa) setelah ditandatangani oleh Penyewa.</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td align="center" valign="top">8</td>
     <td colspan="4" valign="top" align="justify">Ketentuan Khusus</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td align="center" valign="top">&nbsp;</td>
     <td colspan="4" valign="top" align="justify">- Penyewa tidak berhak mengakhiri Surat Konfirmasi Sewa dan Perjanjian Sewa Menyewa sebelum Tanggal Pengakhiran Sewa, dengan atau tanpa alasan- alasan apapun.</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td align="center" valign="top">&nbsp;</td>
     <td colspan="4" valign="top" align="justify">-Dalam hal terjadi Pengakhiran Sewa sebelum Tanggal Pengakhiran Sewa, maka Uang Muka dan Jaminan Sewa menjadi hangus dan tidak dapat diambil kembali oleh Penyewa dan Penyewa wajib melunasi pembayaran sewa sampai dengan akhir sewa.  Pemilik tidak wajib untuk menyerahkan kembali kepada Penyewa dan Perjanjian ini dinyatakan batal demi hukum</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td align="center" valign="top">&nbsp;</td>
     <td colspan="4" valign="top" align="justify">- Layout sewaktu-waktu dapat berubah sesuai dengan commercial plan sampai dengan Perjanjian Sewa Menyewa di tandatangani.</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td align="center" valign="top">&nbsp;</td>
     <td colspan="4" valign="top" align="justify">-Penyewa wajib menyerahkan fotocopy NPWP, KTP dan Dokumen Legal Perusahaan (apabila PT &amp;/CV)</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td align="center" valign="top">&nbsp;</td>
     <td colspan="4" valign="top" align="justify">-Pembayaran dapat dilakukan ke Nomor Rekening yang tercantum pada  Invoice</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td align="center" valign="top">&nbsp;</td>
     <td colspan="4" valign="top" align="justify">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="6" align="justify">Terima kasih  atas  perhatiannya  dan  bila Bapak/Ibu setuju,  harap ditanda tangani  pada kolom yang disediakan  dan  di  email kembali ke kami dengan alamat sbb: <?php echo $rgm['setting_email'];?> atau di fax ke (021) 27585738/27585899. Jika ada pertanyaan lebih lanjut dapat menghubungi <?php echo $rgm['setting_name'];?> di Nomor Telepon <?php echo $rgm['setting_hp'];?>.</td>
   </tr>
</table>

<table width="753" border="0">
  <tr>
    <td width="355">Hormat kami,</td>
    <td width="37">&nbsp;</td>
    <td width="140">&nbsp;</td>
    <td width="203">Penyewa</td>
  </tr>
  <tr>
    <td><strong>PT TRANS RETAIL INDONESIA</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><b><?php 
	$rkn=substr($row->rekanan_name,0,2);
	$rkn=strtoupper($rkn);
	if ( (trim($rkn)=='PT') or (trim($rkn)=='CV') ){
			echo $row->rekanan_name;
	}else{
			echo $row->rekananshipping_name;
	}
	?></b></td>
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
    <td><strong><u><?php echo $rgm['setting_name'];?></u></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
  </tr>
  <tr>
    <td><?php echo $rgm['setting_position'];?></td>
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
</table>

<table width="753" border="0">   
      <tr>
        <td ><strong>PT TRANS RETAIL INDONESIA- SHOPPING MALL </strong></td>

      </tr>
      <tr>
        <td  align="justify">Head Office : Carrefour Lebak Bulus, 3rd Floor, Jl. Lebak Bulus Raya No. 8, Jakarta 12310</td>
      </tr>
      <tr>
        <td align="justify">Telp : 021 (2758.5800 ext. 55614)  Fax. : 021 (2758.5899)</td>
      </tr>
      <tr>
        <td align="justify">PIC. <?php echo $rgm['setting_name'];?>(<?php echo $rgm['setting_hp'];?>) atau <?php echo $rstaff['setting_name'];?> (<?php echo $rstaff['setting_hp'];?>)</td>
      </tr>
      <tr>
        <td align="justify">Email : <?php echo $rgm['setting_email'];?> atau <?php echo $rstaff['setting_email'];?></td>
      </tr>

  </tr>

</table>
<?php }}?> 
</body>
</html>