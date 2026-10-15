<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
    <title>Letter Agreement</title>
 
<style type="text/css">
@font-face {
    font-family: 'Courier New'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/Courier_New.ttf');?>'); /*URL to font*/
}
@font-face {
    font-family: 'Courier New'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/Courier_New.ttf');?>'); /*URL to font*/
    font-weight: bold;
} 
dottab.text {
	outdent: 0.6em;
}
dottab.textJudul {
	outdent: 0.12em;
}
.spacefill1 {  line-height: 2;
  font-size: 10pt;
}
 @page {
 	font-size: 10pt !important;
	size: 8.6in 11in; /* <length>{1,2} | auto | portrait | landscape */ 
	      /* 'em' 'ex' and % are not allowed; length values are width height */
	margin: 4mm;  /* <any of the usual CSS values for margins> */
	             /*(% of page-box width for LR, of height for TB) */
	margin-header: 1mm; /* <any of the usual CSS values for margins> */
	margin-footer: 0.2mm; /* <any of the usual CSS values for margins> */
	marks: none  
	footer: myfooter;
	header: otherpages;
	odd-header-name: otherpages;
	odd-footer-name: myfooter;
	margin-left:5.35cm;
	margin-right:1.96cm; 
	/*margin-footer:-4mm; */
	margin-top:1.5cm;
	margin-bottom:5mm;
} 

#tblLAContent{
	font-family: Courier New;
	border-collapse: collapse;
	width: 100%;
}
#tblLAContent tr{
	page-break-before: always;
}
#tblLAContent td{
	
	/*padding: 8px;*/
	padding: 7px;
	margin: 0;
	font-size: 10pt !important;
	font-family: Courier New;
   
}
#tblLAContent table.inner{
	width: 100%;
	margin: 0;
}
#tblLAContent table.inner td{
	padding: 0;
	width: 50%;
	margin: 0;
	padding: 0;
	border: 0;
} 
#tblLAContent table.inner tr:last-child td{
	border-bottom: none;
} 
body{
        border: none;
       font-size: 10pt !important;
    }
	 
</style>

</head>

<body> 
<htmlpageheader name="otherpages"style="display:none">
 <div style="text-align: right; font-size: 6pt; font-weight: bold;  ">
           {PAGENO}/{nb}
        </div>  
</htmlpageheader>

<htmlpagefooter name="myfooter">
<div align="center" style="position: bottom; font-size: 5pt; text-align: center; ">
<?php echo $nola; ?>  
</div>
</htmlpagefooter>

<!-- content -->
	
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
 
<table id ="tblLAContent" width="500" border="0" cellpadding="0" cellspacing="0">
 
  <tr>
    <td align="center" style="font-family: 'Courier New';">&nbsp;</td>
    <td colspan="2" align="center" style="font-family: 'Courier New';font-size: 22pt;line-height:2"><strong>PERJANJIAN SEWA MENYEWA</strong></td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'Courier New';">&nbsp;</td>
    <td height="24" colspan="2" align="center" style="font-family: 'Courier New';font-size: 20pt;line-height:2"><?php echo $nolah;?></td>
  </tr>
  <?php 
    $datetime = $rkomisaris['tgl_notaris'];
	$date = date('Y-m-d', strtotime($datetime));
	$time = date('H:i', strtotime($datetime));  
	$timestamp = strtotime($datetime); 
	$day = date('D', $timestamp);
	$dayList = array(
					'Sun' => 'Minggu',
					'Mon' => 'Senin',
					'Tue' => 'Selasa',
					'Wed' => 'Rabu',
					'Thu' => 'Kamis',
					'Fri' => 'Jumat',
					'Sat' => 'Sabtu'
				);
  ?>
  <tr>	
    <td style="font-family: 'Courier New';font-size: 11pt" align="center">&nbsp;</td>
    <td colspan="2" align="justify" style="font-family: 'Courier New';font-size: 20pt;line-height:2" >- Pukul <?php if ($rkomisaris['tgl_notaris']<>"") { echo $time;}?></td>
  </tr>
  <tr>
     <td style="font-family: 'Courier New';" align="center">&nbsp;</td>
    <td colspan="2" align="justify" style="font-family: 'Courier New';font-size: 20pt;line-height:2" >- Pada hari ini,<?php echo $dayList[$day]; ?> <br/> Tanggal 	 
	<?php  if ($rkomisaris['tgl_notaris']<>"") { echo getIndoHari($date);}?> </td>
  </tr>
  <tr>
     <td style="font-family: 'Courier New';" align="center">&nbsp;</td>
    <td colspan="2" align="justify" >
	<div class="spacefill"  style="font-family: 'Courier New';font-size: 20pt;line-height:2"><div class="spacefill-dots"></div><span class="spacefill-text">  
	- Hadir di hadapan saya, <?php  if ($rkomisaris['nama_notaris']<>"") { echo $rkomisaris['nama_notaris'];}?>, Notaris di <?php  if ($rkomisaris['domisili_notaris']<>"") { echo $rkomisaris['domisili_notaris'];}?>, dengan dihadiri oleh 2 (dua) saksi yang nama-namanya akan disebut pada bagian akhir akta ini dan yang telah saya, Notaris, kenal. 
	<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
	</span></div>
	</td>
  </tr> 
  <tr>
    <td  style="font-family: 'Courier New';font-size: 11pt">&nbsp;</td>
    <td width="5" align="left" valign="top" style="font-family: 'Courier New';font-size: 20pt;line-height:2;">I.</td>
    <td   align="justify" style="font-family: 'Courier New';font-size: 20pt;line-height:2;"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text"> <?php echo htmlspecialchars_decode($rkomisaris['saksi1']);?></span><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></div>
	
	</td>
  </tr> 
  <tr>
    <td   valign="top" style="font-family: 'Courier New';font-size: 11pt">&nbsp;</td>
    <td  width="70" align="left" valign="top"  style="font-family: 'Courier New';font-size: 20pt;line-height:2;">II.</td>
    <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 20pt;line-height:2;">    
    <?php echo  htmlspecialchars_decode($rkomisaris['saksi2']); ?><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span> 
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" style="font-family: 'Courier New';font-size: 11pt">&nbsp;</td>
    <td align="left" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2;">&nbsp;</td>
    <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 20pt;line-height:2;">     
	</b>(selanjutnya, berikut dengan pengganti atau penerima haknya,disebut "<strong>Penyewa</strong>").<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span> 
    </td>
  </tr>
  <tr>
    <td height="70" align="center" style="font-family: 'Courier New';font-size: 11pt">&nbsp;</td>
    <td colspan="2" align="justify" style="font-family: 'Courier New';font-size: 20pt;line-height:2">
		 
			-Para penghadap dalam kedudukannya masing masing sebagaimana tersebut di atas dengan ini menyatakan hal-hal sebagai berikut:<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
		 
	</td>
  </tr>
  <tr>
    <td height="80" align="center" style="font-family: 'Courier New';font-size: 11pt">&nbsp;</td>
    <td colspan="2" align="justify" style="font-family: 'Courier New';font-size: 20pt;line-height:2">
		 
			-BAHWA, Pemilik adalah pengembang suatu komplek bangunan multi guna yang, sebagaimana yang direncanakan, setelah selesainya akan terdiri dari berbagai bangunan dan suatu bangunan pusat perbelanjaan eceran dengan fasilitas parkirnya, pengembangan dan perlengkapan lainnya sebagaimana yang dari waktu ke waktu ditetapkan atau dikembangkan oleh Pemilik, terletak di <?php echo $row->branch_namerpt;?> <?php echo $row->branch_address;?> (seluruhnya disebut “<strong>Kompleks</strong>”);<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
		 
	</td>
  </tr>
  <tr>
    <td height="80" align="center" style="font-family: 'Courier New';font-size: 11pt">&nbsp;</td>
     <td colspan="2" align="justify" style="font-family: 'Courier New';font-size: 20pt;line-height:2">
	 -BAHWA, Pemilik telah membangun sebagian dari Kompleks yaitu berupa bangunan pusat perbelanjaan yang dikenal sebagai “Trans Studio Mall” termasuk fasilitas parkir dan pengembangannya, baik yang berada di dalam maupun di luar bangunan yang khusus diperuntukan bagi bangunan pusat perbelanjaan tersebut sebagaimana yang dari waktu ke waktu ditetapkan oleh Pemilik (seluruhnya disebut “<strong>Mal</strong>”);<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td> 
  </tr> 
  <tr>
    <td height="80" align="center" style="font-family: 'Courier New';font-size: 11pt">&nbsp;</td>
    <td colspan="2" align="justify" style="font-family: 'Courier New';font-size: 20pt;line-height:2">
		
			-BAHWA, Pemilik bermaksud untuk menyewakan kepada Penyewa dan Penyewa bermaksud untuk menyewa dari Pemilik sebagian dari Mal sebagaimana yang didefinisikan disini sebagai “Ruang Sewa”; berdasarkan  Surat Penawaran (Letter of Offer) Ref:<?php echo $row->loo_id; ?> tertanggal <?php echo  date('d-m-Y', strtotime($row->loo_date ));?>   - ( <?php echo getIndoHari(date('Y-m-d', strtotime($row->loo_date))); ?>) yang merupakan bagian yang tidak terpisahkan dari Perjanjian ini. <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span> 
		
	</td>
  </tr>
  <tr>
    <td height="80" align="center" style="font-family: 'Courier New';font-size: 11pt">&nbsp;</td>
    <td colspan="2" align="justify" style="font-family: 'Courier New';font-size: 20pt;line-height:2">
		
				-BAHWA, para pihak bermaksud untuk menyusun suatu Perjanjian Sewa Menyewa dalam Bahasa Indonesia sebagai dasar sewa menyewa Ruang Sewa oleh Penyewa, berikut dengan “Syarat Syarat Sewa” yang menjadi lampirannya (termasuk seluruh Apendik, Eksibit dan Skedul-nya seluruhnya disebut “Sewa Menyewa”). <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span> 
		
	</div>	
	</td>
  </tr>
  <tr>
    <td height="60" align="center" style="font-family: 'Courier New';font-size: 11pt">&nbsp;</td>
    <td colspan="2" align="justify" style="font-family: 'Courier New';font-size: 20pt;line-height:2">
		
			-KARENANYA, berdasarkan apa yang tersebut diatas  Pemilik dan Penyewa setuju sebagai berikut:<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span> 

	</td>
  </tr> 
  <tr>
    <td align="center" >&nbsp;</td>
    <td  colspan="2" align="left"style="font-family: 'Courier New';font-size: 10pt" >
		<strong>
			<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab outdent="-50%" /></span>Pasal 1 <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab outdent="-40%" /></span>
		</strong>
	</div>
	</td>
  </tr>
  <tr> 
    <td align="center" >&nbsp;</td>
    <td colspan="2" align="left" style="font-family: 'Courier New';font-size: 20pt;line-height:2"><strong><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab outdent="-40%" /></span>KESEPAKATAN SEWA MENYEWA<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab outdent="-35%" /></span></td>
  </tr>
  <tr> 
    <td align="center" >&nbsp;</td>
    <td colspan="2" align="justify" style="font-family: 'Courier New';font-size: 20pt;line-height:2">Pemilik dengan ini setuju untuk menyewakan dan Penyewa dengan ini setuju untuk menyewa sesuai dengan ketentuan Sewa Menyewa ini, ruang sewa sebagaimana dimaksud dalam Pasal 2.1. dan 2.2. Perjanjian Sewa Menyewa ini, berikut dengan peralatan tetap (“fixtures”), perlengkapan dan tambahannya yang dibangun, ditanam atau dipasang di dalamnya oleh Pemilik, baik atas biaya Pemilik atau Penyewa (selanjutnya disebut “<strong>Ruang Sewa</strong>”), yang akan digunakan oleh Penyewa, sebagai penyewa, untuk selama jangka waktu sebagaimana tersebut dalam Pasal 2.3 Perjanjian Sewa Menyewa ini, beserta hak Penyewa untuk menggunakan secara bersama sama dengan Pemilik dan para penyewa dan penghuni lainnya di Mal serta setiap pihak manapun juga yang diwenangkan atau diijinkan oleh Pemilik, seluruh area di Mal terhadap mana Pemilik mengijinkan mereka untuk mendapatkan akses, termasuk pintu masuk Mal, “lobby”, kamar kecil, koridor, lorong, tangga, tempat menurunkan barang dan lift (seluruh area Mal, diluar bagian yang telah disewakan atau yang akan disewakan oleh Pemilik atau yang digunakan oleh Pemilik atau pihak yang bertindak atas nama Pemilik, selanjutnya secara keseluruhan disebut “<strong>Area Umum</strong>”).<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
  </tr>
  <tr>
    <td align="center" >&nbsp;</td>
    <td  colspan="2" align="left" style="font-family: 'Courier New';" >
		<strong> 
				<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab outdent="-50%" /></span>Pasal 2 <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab outdent="-40%" /></span>
		</strong>
	</div>
	</td>
  </tr>
  <tr> 
    <td align="center" >&nbsp;</td>
    <td colspan="2" align="left" style="font-family: 'Courier New';">	
		<strong>
		<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab outdent="-35%" /></span>TATA LAKSANA DOKUMENTASI SEWA MENYEWA<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab outdent="-31%" /></span></strong>
	</td>
  </tr>
  
</table>
  
<table  border="0" cellpadding="0" cellspacing="0">
      <tr>  
       <td width="20" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">2.1.</td>
       <td colspan="4" align="justify"  style="font-family: 'Courier New';font-size:10pt;line-height:2">Dokumentasi Sewa Menyewa ini terdiri dari tiga bagian dasar sebagai berikut :<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
     </tr>
	 <tr> 
       <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
       <td width="30" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
       <td align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2" valign="top" >(a)</td>
       <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="2">	-<b>Perjanjian Sewa Menyewa</b> ini yang berisikan syarat syarat dan ketentuan ketentuan pokok berdasarkan mana Penyewa telah setuju menyewa Ruang Sewa dari Pemilik, dan lampirannya yang disebut sebagai <b>Apendik I</b> adalah <b>Denah Lantai</b> dari Ruang Sewa;<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
     </tr>
	 <tr> 
       <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
       <td width="30" align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2" valign="top" >(b)</td>
       <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"  colspan="2">-<b>Syarat Syarat Sewa</b> yang merupakan lampiran dari Perjanjian Sewa Menyewa ini disebut sebagai <b>Eksibit A</b> yang berisikan hak dan kewajiban dari masing masing Pemilik dan Penyewa, syarat syarat mana menjadi satu kesatuan dengan dan merupakan bagian yang tidak terpisahkan dari Perjanjian Sewa Menyewa ini;  dan<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
     </tr>
	 <tr> 
       <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
       <td width="30" align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2" valign="top" >(c)</td>
       <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"  colspan="2">-<b>“Peraturan”</b> yang merupakan lampiran dari Syarat Syarat Sewa disebut sebagai <b>Skedul Ketiga</b> yang berisikan tata tertib dengan mana Pemilik akan mengelola dan  mengoperasikan Mal, Peraturan mana menjadi  satu kesatuan dengan dan merupakan bagian yang tidak terpisahkan dari Perjanjian Sewa Menyewa ini.<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
     </tr>
	 <tr>  
       <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">2.2.</td>
       <td colspan="4" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" >Syarat Syarat Sewa terdiri dari tiga Skedulsebagai berikut:<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
     </tr> 
	 <tr> 
       <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
       <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
       <td width="20" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2" valign="top" >(a)</td>
       <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"  colspan="2">	-<b>Skedul Pertama</b>  berisikan tata cara berdasarkan mana <b>Uang Sewa</b> (sebagaimana dimaksud dalam Pasal 3.5. Perjanjian Sewa - Menyewa ini), Biaya Pelayanan (sebagaimana  dimaksud dalam Pasal 3.6. Perjanjian Sewa  Menyewa ini) dan jumlah lain yang wajib dibayar, harus dibayarkan;<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
     </tr>
	 <tr> 
       <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
       <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
       <td width="20" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2" valign="top" >(b)</td>
       <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"  colspan="2">	-<b>Skedul Kedua</b> yang menjelaskan <b>Utilitas dan Pelayanan</b> (yang masing masing akan didefinisikan kemudian) yang disediakan oleh Pemilik; dan<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
     </tr>
	 <tr> 
       <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
       <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
       <td align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2" valign="top" >(c)</td>
       <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"  colspan="2">	-<b>Skedul Ketiga</b>yang berisikan <b>Peraturan</b> sebagaimana tersebut di atas<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
     </tr> 
	 <tr>  
		<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">2.3.</td>  
		<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2">-Selain apa yang tersebut di atas, Penyewa dengan ini setuju untuk mengikatkan diri kepada dan mematuhi syarat syarat dan ketentuan ketentuan yang terdapat dalam <b>Ketentuan dan Panduan Fitting-Out Ruang Sewa (“Tenancy Fitting-Out  Guide and Rules”)</b>, apabila ada, <b>Ketentuan dan Panduan Pembangunan Ruang Sewa (“TenancyConstruction Guide and Rules”)</b>, apabila ada, dan  Panduan Penyewa (“Tenant’s Handbook”)</b>, apabila ada, termasuk kewajiban pembayaran yang dikenakan kepada Penyewa berdasarkan ketentuan tersebut,  sebagaimana yang dapat diubah dari waktu ke waktu oleh Pemilik (seluruhnya disebut <b>“Petunjuk”</b>).<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
	 </tr>
	 <tr>  
		<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">2.4.</td>  
		<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2">-Setiap terminologi yang didefinisikan dalam Perjanjian Sewa Menyewa ini dan Syarat Syarat Sewa mempunyai arti sebagaimana yang diberikan kepadanya dalam memahami seluruh Sewa Menyewa ini, demikian kecuali konteks kalimat memberikan  arti lain.<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
	 </tr>
  </table>
  
<table width="500" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" >&nbsp;</td>
    <td  colspan="2" align="left"style="font-family: 'Courier New';font-size: 10pt" >
		<strong>
			<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab outdent="-50%" /></span>Pasal 3 <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab outdent="-40%" /></span>
		</strong>
	</div>
	</td>
  </tr>
  <tr> 
    <td align="center" >&nbsp;</td>
    <td colspan="2" align="left" style="font-family: 'Courier New';font-size: 10pt;line-height:2">	
		<strong>
		<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab outdent="-22%" /></span>IKHTISAR SYARAT SYARAT DAN KETENTUAN KETENTUAN POKOK <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab outdent="-35%" /></span></strong>
	</td>  
  </tr>
  <tr> 
    <td align="center" >&nbsp;</td>
    <td colspan="2" align="left" style="font-family: 'Courier New';font-size: 10pt;line-height:2">	
		<strong>
		<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab outdent="-45%" /></span>SEWA MENYEWA<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab outdent="-37%" /></span></strong>
	</td>  
  </tr>
  <tr>

    <td height="60" align="center" style="font-family: 'Courier New';font-size: 11pt">&nbsp;</td>
    <td colspan="2" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2">
		-Pemilik dan Penyewa dengan ini setuju bahwa penyewaan Ruang Sewa dilakukan berdasarkan syarat syarat danketentuan ketentuan pokok berikut ini, dan ketentuan - ketentuan dalam Pasal 3 ini akan berlaku dalam hal terdapat pertentangan atau perbedaan antara ketentuan- ketentuan yang terdapat dalam Pasal 3 ini dengan ketentuan lain dalam Sewa Menyewa ini:<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span> 

	</td>
  </tr> 
 </table>
 
<table width="500" border="0" cellpadding="0" cellspacing="0">
		<tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.1.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2">-<B>RUANG SEWA</B> (sebagaimana yang ditandai dalam Denah Lantai terlampir pada Perjanjian Sewa Menyewa ini sebagai Apendik I): <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
				<br/>
				<p>
				<span style="font-family: 'Courier New';font-size: 10pt;line-height:2">-No. Unit</span>
				<span>&nbsp;:</span>
				<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><?php echo $vunitname;?> - <?php echo $vunitsqm;?>;</span>
				</p>
				<p>
				<span style="font-family: 'Courier New';font-size: 10pt;line-height:2">-Lantai</span>
				<span>&nbsp;&nbsp;&nbsp;:</span>
				<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><?php echo $vlantai;?>;</span>
				</p>
			</td>
		 </tr>
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.2.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>LUAS</B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr>
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2">-Kurang lebih <?php echo $vunitsqm;?> M2 <b>(<?php echo terbilang($vunitsqm);?>)</b>; dan tunduk kepada hasil pengukuran sebagaimana dimaksud dalam Pasal 1.1.3. dan Pasal 1.1.4. Syarat Syarat  Sewa. <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr>
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.3.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>JANGKA WAKTU SEWA</B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr>
	 	 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.4.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>PENGGUNAAN RUANG SEWA </B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td align="justify" valign="top"style="font-family: 'Courier New';font-size: 20pt;line-height:2;width:100%;" >(a)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 20pt;" colspan="3">-Ruang Sewa akan digunakan untuk kegiatan <?php echo $rkomisaris['jenisusaha'];?> dengan nama dagang <?php echo $rkomisaris['merkdagang'];?>;<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr> 
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td width="10" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(b)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">-Barang-barang atau jasa yang dijual oleh Penyewa tersebut harus sesuai dengan standar yang harus dijaga dan diawasi oleh Penyewa sebagai penjual / penyedia jasa yang bereputasi, dengan persetujuan dari Pemilik; <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr> 
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td width="10" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(c)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">-Penyewa bertanggung jawab untuk memperoleh seluruh persetujuan dan lisensi yang diperlukan (jika ada) dari pihak yang berwenang untuk menjual dan menyediakan barang-barang atau jasa tersebut atas biaya dan tanggungan Penyewa sepenuhnya; dan <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr> 
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td width="10" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(d)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">(d)	Setiap perubahan barang barang jualan atau jasa yang disediakan, termasuk perinciannya, tunduk pada persetujuan tertulis Pemilik.<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr> 
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.5.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>UANG SEWA </B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr>
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td width="10" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(a)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">-<?php echo $rkomisaris['uangsewa'];?><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr>
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td width="10" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(b)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">-<?php echo $rkomisaris['uangsewab'];?><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr>
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.6.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>BIAYA PELAYANAN</B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr>
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td width="10" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(a)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">-<?php echo $rkomisaris['uangservice'];?> <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr>
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td width="10" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(b)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">-Setelah itu, Biaya Pelayanan akan ditinjau  setiap tahun sesuai dengan Skedul Pertama dari Syarat Syarat Sewa dan dibayarkan --- berdasarkan ketentuan-ketentuan diatur disana; dan <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr>
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td width="10" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(c)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">-Biaya Pelayanan dibayarkan setiap 3 (tiga) bulan dimuka dan pembayaran Biaya Pelayanan yang pertama kali harus dilakukan selambatnya 14 (empat belas) hari setelah tanggal pemberitahuan pelaksanaan fitting out ruang sewa.<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr>
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.7.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>PAJAK PERTAMBAHAN NILAI (“PPN”)</B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2">-Uang Sewa dan Biaya Pelayanan tunduk kepada Pajak Pertambahan Nilai (“PPN”) sesuai dengan - ketentuan yang berlaku dan dibayar oleh Penyewa. <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr>
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.8.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>SIMPANAN JAMINAN </B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2">-Simpanan Jaminan yang harus dibayarkan pada saat penandatangan Perjanjian Sewa Menyewa ini senilai 3 (Tiga) bulan Uang Sewa dan Biaya ---- Pelayanan; Untuk disimpan serta digunakan ----- sesuai dengan Skedul Pertama dari Syarat Syarat Sewa.  <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr>
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.9.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>UANG JAMINAN TELEPON</B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td width="10" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(a)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">-Uang jaminan sejumlah Rp.3.500.000,- (Tiga Juta Lima Ratus Ribu Rupiah) untuk  1 (satu) sambungan telepon yang disediakan oleh Pemilik kepada Penyewa dan dibayarkan pada saat penandatanganan Perjanjian Sewa Menyewa ini, dan uang jaminan sebesar jumlah tersebut juga dibayar dalam hal  Pemilik menyediakan setiap sambungan telepon tambahan kepada Penyewa<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr>
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td width="10" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(b)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">-Uang jaminan telepon ini akan disimpan serta digunakan sesuai dengan SkedulPertama dari Syarat Syarat Sewa. <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr>
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.10.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>TANGGAL MULAI DAN BERAKHIRNYA SEWA </B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td width="10" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(a)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">–Tanggal Mulai Sewa adalah salah satu dari, (i) tanggal berakhirnya jangka waktu fitting out sebagaimana dimaksud dalam Pasal 3.11 Perjanjian Sewa Menyewa atau,  (ii)  tanggal <strong><?php echo getIndoHari($row->loo_sdate);?></strong> mana yang lebih dahulu terjadi, maka tanggal mulai Perjanjian Sewa Menyewa adalah tanggal <strong><?php echo getIndoHari($row->loo_sdate);?>;</strong><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr> 
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td width="10" align="justify" valign="top" style="font-family: 'Courier New';font-size:20pt;line-height:2">(b)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">–<strong>Tanggal Berakhirnya Sewa Menyewa</strong> ini adalah tanggal setelah lewatnya waktu tertentu dari <strong>Tanggal Mulai Sewa</strong> / tanggal pembukaan yang disetujui pemilik yaitu tanggal <strong><?php echo getIndoHari($row->loo_edate);?>;</strong><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr> 
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td width="10" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(c)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">Berbagai peristilahan yang menyebutkan Tanggal Pembukaan, secara keseluruhan dalam perjanjian ini harus diartikan sebagai tanggal mulai sewa, dan <b>tanggal mulai sewa</b> meskipun pemilik dapat mengkonsultasikan dengan sebagian besar penyewa namun Tanggal Mulai Sewa sepenuhnya ditentukan oleh Pemilik.<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr>
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td width="10" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(d)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">-Tanggal Mulai Sewa tidak dapat diperpanjang, demikian juga kewajiban Penyewa untuk membayar Uang Sewa, Biaya Pelayanan dan jumlah lain yang harus dibayar berdasarkan Sewa Menyewa ini tidak dapat ditunda sebagai akibat dari ketidakmampuan Penyewa untuk melakukan fitting-out dan/atau stocking-up Ruang Sewa sesuai dengan jangka waktu yang ditetapkan dalam Sewa Menyewa ini maupun Petunjuk.<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr>
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.11.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>JANGKA WAKTU FITTING-OUT DAN STOCKING-UP</B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
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
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
		   <td   align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(a)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">–Pemilik akan menyampaikan pemberitahuan tertulis selambat lambatnya 2 (dua) minggu sebelum tanggal Penyewa dapat memulai fitting-out Ruang Sewa mengenai: (i) tanggal kapan serah terima akan dilakukan dan Penyewa dapat mulai melakukan fitting-out Ruang Sewa (tanggal itu disebut sebagai <b>“Tanggal Siap Serah”)</b>; dan (ii) memberikan Penyewa jangka waktu  <?php echo $nilgrace;?> ( <?php echo number_to_wordsnorp($nilgrace);?> ) bulan terhitung mulai Tanggal Siap Serah yang bebas sewa <b>(“Jangka Waktu Fitting-Out”)</b> untuk melakukan pekerjaan fitting-out dan stocking-up, termasuk untuk menyerahkan desain toko untuk persetujuan Pemilik; <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr>
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td   align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(b)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">–Dalam hal Penyewa belum memulai fitting-out dalam waktu 30 (tiga puluh) hari kalender sejak Tanggal Mulai Jangka Waktu Fitting-Out, Pemilik berhak menyimpulkan - bahwa Penyewa tidak lagi berminat atas Ruang Sewa dan karenanya Pemilik mempunyai hak untuk mengakhiri Sewa Menyewa ini secara sepihak dengan memberikan kepada Penyewa suatu pemberitahuan tertulis mengenai hal itu dan dalam hal ini: (i) semua uang yang telah diterima Pemilik akan menjadi milik Pemilik; dan (ii) Pemilik berhak untuk menyewakan Ruang Sewa kepada pihak lain yang dipilihnya sendiri dengan syarat syarat dan ketentuan ketentuan yang ditentukan oleh Pemilik --- tanpa mewajibkan Pemilik memberikan kompensasi kepada Penyewa; <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr> 
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td   align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(d)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">–Pekerjaan fitting-out harus -------------- dikoordinasikan kepada Koordinator Penyewa yang ditetapkan oleh Pemilik dan harus --- sesuai dengan standar ketentuan dari ----- Petunjuk Kriteria Desain Pembangunan Fit- Out Sewa;<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr> 
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td   align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(e)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">–Dalam hal Ruang Sewa sudah siap dibuka untuk berdagang sebelum sebelum berakhirnya Jangka Waktu Fitting-Out, maka Penyewa wajib membuka Ruang Sewa untuk berdagang dan Uang Sewa serta Biaya Pelayanan harus dibayar sejak tanggal pembukaan tersebut;<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr> 	
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td   align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(f)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">–Selama Jangka Waktu Fitting-Out, Penyewa - wajib melaksanakan dan menyelesaikan, atas biayanya sendiri, fitting-out dan stocking-up Ruang Sewa dan mempersiapkan - Ruang Sewa untuk pembukaan usaha dengan cara yang berstandar professional sesuai - dengan Perjanjian Sewa Menyewa ini dan Petunjuk; dan <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr> 	
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 11pt;line-height:2">&nbsp;</td>
		   <td   align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(g)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">-Penyewa mengakui bahwa Penyewa tidak berhak untuk memulai fitting-out dan stocking-up dan persiapan pekerjaan sampai dengan Penyewa memenuhi semua ketentuan ketentuan, syarat-syarat dan kewajiban kewajiban dalam Perjanjian Sewa Menyewa ini dan Petunjuk dan bahwa terhitung sejak tanggal hari ini kunjungan Penyewa ke Ruang Sewa serta pelaksanaan pekerjaan fitting-out, stocking-up dan persiapan Ruang Sewa sepenuhnya menjadi resiko dan biaya Penyewa sendiri. <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr> 	
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.12.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>KETENTUAN KHUSUS </B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2">-Lihat Apendik IV terlampir, apabila ada. <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr>   
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.13.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>MATA UANG PEMBAYARAN</B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><b>Uang Sewa, Biaya Pelayanan dan Jumlah Lain</b><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2">-Kecuali dinyatakan lain secara tegas dalam Perjanjian Sewa Menyewa ini, Uang Sewa, Biaya - Pelayanan dan jumlah lain yang harus dibayar -- oleh Penyewa dalam mata uang Rupiah Indonesia - (IDR).<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2">-Setelahnya, mata uang pembayaran ditentukan oleh Pemilik.<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.15.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>ALAMAT PENYEWA</B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><b><?php echo $row->rekanan_name;?></b><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><?php echo $row->rekananshipping_address;?><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.16.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>NAMA DAN ALAMAT PEMEGANG SAHAM,PEMILIK DAN DIREKSI PENYEWA </B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><b>-PEMEGANG SAHAM</b><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr>
		 <?php if($rkomisaris['pemegang_saham1'] != '') {  ?>
		 <tr>  
				<td align="justify" valign="top" style="font-family: "Courier New";font-size: 20pt;line-height:2">&nbsp;</td>  
				<td colspan="4" align="justify" style="font-family: "Courier New";font-size: 20pt;line-height:2"> 
				<?php 
					echo ($rkomisaris['pemegang_saham1'] != '') ? '1. '.$rkomisaris['pemegang_saham1'] : '';	
				?>
				<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>	
				</td>
		 </tr>
		 <?php }   
		 if($rkomisaris['pemegang_saham2'] != '') {  
		 ?>
		 <tr>  
				<td align="justify" valign="top" style="font-family: "Courier New";font-size: 20pt;line-height:2">&nbsp;</td>  
				<td colspan="4" align="justify" style="font-family: "Courier New";font-size: 20pt;line-height:2"> 
				<?php 
					echo ($rkomisaris['pemegang_saham2'] != '') ? '2. '.$rkomisaris['pemegang_saham2'] : '';	
				?>
				<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>	
				</td>
		 </tr>
		 <?php }     
		 ?>
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><b>-DIREKSI</b><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr>
		 <?php   
		 if($rkomisaris['direktur'] != '') {  
		 ?>
		 <tr>  
				<td align="justify" valign="top" style="font-family: "Courier New";font-size: 20pt;line-height:2">&nbsp;</td>  
				<td colspan="4" align="justify" style="font-family: "Courier New";font-size: 20pt;line-height:2"> 
				<?php 
					echo ($rkomisaris['direktur'] != '') ? '- '.$rkomisaris['direktur'] : '';	
				?>
				<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>	
				</td>
		 </tr>
		 <?php } ?>
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><b>-KOMISARIS</b><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr>
		 <?php   
		 if($rkomisaris['komisaris'] != '') {  
		 ?>
		 <tr>  
				<td align="justify" valign="top" style="font-family: "Courier New";font-size: 20pt;line-height:2">&nbsp;</td>  
				<td colspan="4" align="justify" style="font-family: "Courier New";font-size: 20pt;line-height:2"> 
				<?php 
					echo ($rkomisaris['komisaris'] != '') ? '- '.$rkomisaris['komisaris'] : '';	
				?>
				<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>	
				</td>
		 </tr>
		 <?php } ?>
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.17.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>BIAYA PROMOSI</B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
		   <td   align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(a)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">-Penyewa dengan ini setuju untuk membayar suatu biaya promosi sebagai kontribusi Penyewa terhadap biaya untuk mempromosikan dan mengiklankan Mal dalam jumlah <strong>Rp <?php
			if ($rnilaipromo['agreementdetil_baserent']==""){
				$nilpromo=0;
			}
				else{
					$nilpromo=$rnilaipromo['agreementdetil_baserent'];
			}
			 echo number_format($rnilaipromo['agreementdetil_baserent'],0);?>,- (<?php echo number_to_wordsnorp($nilpromo);?> Rupiah)</strong> untuk setiap meter persegi per bulan yang dibayarkan secara bulanan dimuka terhitung sejak Tanggal Mulai Sewa. <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr>
		  <?php
			if ($rgplv['agreementdetil_mia']==""){
				$nilgpl=0;
			}
				else{
					$nilgpl=$rgplv['agreementdetil_mia'];
			}
			?>
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
		   <td   align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(b)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">-Penyewa dengan ini setuju untuk memberikan berupa kontribusi sekali pembayaran sejumlah <strong>Rp. <?php echo number_format($rgplv['agreementdetil_mia'],0);?>,- (<?php echo number_to_wordsnorp($nilgpl);?> Rupiah)</strong> untuk setiap meter persegi ruang sewa, dalam hal mana pembayaran tersebut dilakukan oleh seluruh penyewa secara bersama-sama untuk kepentingan pembayaran biaya promosi dan periklanan Grand Opening (pembukaan/tanggal mulai sewa seluruh ruang sewa penyewa secara bersama-sama). Pembayaran tersebut dilakukan selambat-lambatnya 2 (dua) minggu setelah tanggal pemberitahuan pelaksanaan fitting out ruang sewa. <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr>
		  <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.18.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>PUNGUTAN TEMPAT MAKANAN </B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
		  <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(Hanya untuk penyewa tempat makanan).
				Tidak dikenakan. <span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr>
		 <tr>  
			<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">3.19.</td>  
			<td colspan="4" align="justify" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><B>-PENYELESAIAN SENGKETA</B><span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span>
			</td>
		 </tr> 
	 
		 <tr> 
		   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
		   <td   align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(a)</td> 
		   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2" colspan="3">-Pemilik dan Penyewa setuju, kecuali sebagaimana ditentukan lain dalam Pasal 3.19.(j) di bawah ini, setiap sengketa yang  timbul dari atau sehubungan dengan Perjanjian Sewa Menyewa ini, termasuk namun tidak terbatas kepada suatu masalah mengenai keberadaannya, keabsahan, pengakhiran, atau hak maupun kewajiban mereka masing masing, yang menurut pendapat masing masing pihak tidak dapat diselesaikan secara musyawarah, setelah pertama kali diungkapkan secara tertulis, akan diselesaikan pada tingkat akhir di arbitrase berdasarkan Aturan Arbitrase ("Aturan") Badan Arbitrase Nasional Indonesia ("BANI") dan ketentuan Pasal 3.19 ini.<span style="font-family: 'Courier New';font-size: 10pt;line-height:2"><dottab class="text" /></span></td>
		 </tr> 	
</table>
	  
<table width="500" border="0" cellpadding="0" cellspacing="0">
		<tr>
        <td align="center" style="font-family: 'Courier New';font-size: 20pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(b)</td>
        <td width="42" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(i)</td>
        <td colspan="4" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-Arbitrase akan dilaksanakan di Jakarta di fasilitas BANI oleh tiga arbiter yang ditunjuk sebagai berikut:</span></div></td>
      </tr>
		<tr>
        <td align="center" style="font-family: 'Courier New';font-size: 20pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
        <td width="22" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(x)</td>
        <td width="376" colspan="3" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-masing masing pihak menunjuk 1(satu) arbiter-nya dalam jangka waktu 30 (tiga puluh) hari sejak pemberian pemberitahuan tertulis oleh satu pihak kepada pihak lainnya mengenai maksudnya untuk menyerahkan sengketa kepada arbitrase ("Pemberitahuan Arbitrase");</span></div></td>
      </tr>
		<tr>
        <td align="center" style="font-family: 'Courier New';font-size: 20pt">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
        <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(y)</td>
        <td colspan="3" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-2(dua) arbiter yang telah ditunjuk akan menunjuk arbiter ketiga yang akan mengetuai dewan arbitrase dalam jangka waktu 30 (tiga puluh) hari terhitung dari tanggal Pemberitahuan Arbitrase, dan apabila mereka tidak dapat mencapai kesepakatan mengenai arbiter ketiga tersebut, arbiter ketiga akan ditunjuk oleh Ketua BANI sesuai dengan Aturan, dan ketiga arbiter yang telah ditunjuk tersebut akan merupakan suatu dewan arbitrase;</span></div></td>
      </tr>
		<tr>
		<td align="center" style="font-family: 'Courier New';font-size: 20pt">&nbsp;</td>
		<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
		<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
		<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
		<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
		<td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(z)</td>
		<td colspan="3" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-Apabila salah satu pihak tidak dapat menunjuk arbiter-nya dalam jangka waktu yang ditetapkan, maka arbiter yang telah ditunjuk oleh suatu pihak akan duduk sebagai suatu dewan arbitrase.</span></div></td>
	 </tr>
		<tr>
	   <td align="center" style="font-family: 'Courier New';font-size: 20pt">&nbsp;</td>
	   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
	   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
	   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
	   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(ii)</td>
	   <td colspan="4" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-Para arbiter boleh berkebangsaan apapun.</span></div></td>
	 </tr>
		<tr>
	   <td align="center" style="font-family: 'Courier New';font-size: 20pt">&nbsp;</td>
	   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
	   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
	   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
	   <td  align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(iii)</td>
	   <td colspan="4" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-Arbitrase dilaksanakan dalam bahasa Indonesia.</span></div></td>
    </tr>
		<tr>
	   <td align="center" style="font-family: 'Courier New';font-size: 20pt">&nbsp;</td>
	   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
	   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
	   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
	   <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(iv)</td>
	   <td colspan="4" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-Setiap pemberitahuan mengenai arbitrase, tanggapan atau komunikasi lain yang diberikan kepada atau oleh satu pihak dalam arbitrase harus dalam bahasa Indonesia dan harus disampaikan dan dianggap telah diterima sebagaimana ditentukan dalam Aturan.</span></div></td>
	 </tr> 
</table>
     
<table width="500" border="0" cellpadding="0" cellspacing="0">
	<tr>
               <td align="center" style="font-family: 'Courier New';font-size: 20pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(c)</td>
               <td width="42" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(i)</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-Para pihak setuju bahwa masing masing pihak tidak akan mengajukan suatu perkara hukum yang timbul dari atau sehubungan dengan Perjanjian Sewa Menyewa ini, kecuali:  (y) dalam hal menegakkan keputusan BANI disuatu pengadilan negeri yang berwenang;  dan (z) sebagaimana diatur dalam Pasal 3.19.(j) di bawah ini.</span></div></td>
             </tr>
	<tr>
               <td align="center" style="font-family: 'Courier New';font-size: 20pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(ii)</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-Dalam hal suatu perkara hukum diajukan di suatu pengadilan guna menegakkan suatu keputusan arbitrase, pihak terhadap siapa keputusan arbitrase hendak ditegakkan harus membayar seluruh biaya, termasuk tetapi tidak terbatas kepada biaya penasihat hukum dari pihak yang hendak menegakkan keputusan arbitrase.</span></div></td>
             </tr>
	<tr>
               <td align="center" style="font-family: 'Courier New';font-size: 20pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(d)</td>
               <td colspan="5" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-Sambil menunggu pengajuan perkara ke arbitrase, selama proses arbitrase dan selanjutnya sampai BANI mengeluarkan keputusannya, Penyewa harus, terlepas dari sifat sengketa yang diajukan, membayar seluruh Uang Sewa, Biaya Pelayanan dan biaya serta jumlah lain yang harus dibayar berdasarkan Perjanjian Sewa Menyewa ini.</span></div></td>
             </tr>
	<tr>
               <td align="center" style="font-family: 'Courier New';font-size: 20pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(e)</td>               
               <td colspan="5" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-Masing masing pihak harus menanggung setengah dari biaya dan imbalan BANI dan biaya arbitrase.</span></div></td>
             </tr>
	<tr>
               <td align="center" style="font-family: 'Courier New';font-size: 20pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(f)</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(i)</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-Semua keputusan BANI bersifat mengikat dan final terhadap masing masing pihak.</span></div></td>
             </tr>
	<tr>
               <td align="center" style="font-family: 'Courier New';font-size: 20pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(ii)</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-Masing masing pihak dengan ini secara tegas setuju untuk mengesampingkan keberlakuan Pasal 631 R.V. (Reglement op de Rechtsvordering), dan karenanya dalam memutus perbedaan pendapat atau sengketa BANI terikat semata mata oleh peraturan perundang undangan yang berlaku, dan tidak boleh memutuskan perkara secara “ex aequo et bono” (berdasarkan rasa keadilan).</span></div></td>
             </tr>
	<tr>
               <td align="center" style="font-family: 'Courier New';font-size: 20pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(iii)</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-Kedua belah pihak selanjutnya setuju untuk mengesampingkan keberlakuan Pasal 641 R.V. dan, sepanjang dapat diterapkan, Pasal 15 dan Pasal 108 Undang Undang No.1 tahun 1950 (Peraturan Mahkamah Agung), demikian sehingga tidak boleh ada banding dan/atau kasasi pada suatu pengadilan hukum terhadap keputusan BANI, dan kedua belah pihak tidak boleh menggugat atau menolak tindakan pelaksanaan keputusan yang diambil oleh pihak yang dimenangkan oleh keputusan BANI.</span></div></td>
             </tr>
	<tr>
               <td align="center" style="font-family: 'Courier New';font-size: 20pt">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">&nbsp;</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(g)</td>
               <td align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2">(i)</td>
               <td colspan="4" align="justify" valign="top" style="font-family: 'Courier New';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-Masing masing pihak dengan tegas setuju untuk mengesampingkan keberlakuan Pasal 650 ayat 2 R.V. demikian sehingga penunjukan arbiter tidak berakhir setelah enam (6) bulan terhitung dari tanggal penunjukannya.</span></div></td>
             </tr>
</table>
	 
 
  
	 
 
 
 <?php } } ?>
 
<!-- content -->

</body>
</table>

</html>