<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Standard Speciality</title>
<style>
@font-face {
    font-family: 'arial'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/arial.ttf');?>'); /*URL to font*/
}
body {font-family: 'arial';font-size: 9pt;margin-left:4cm; margin-right:2cm; margin-top:0.5cm;margin-bottom:0.5cm;size:8.5in 11in;text-align:justify;
line-height:2;}
 

</style> 
</head>

<body>

<htmlpageheader name="firstpage" style="display:none"> 
   <table width="100%" style="border-top: 0px solid #000000; font-size: 8pt; padding-top: 3mm; "> 
	<tr>
		<td>
			Ref..:<?php echo $nola; ?>
		</td>  
		<td align="right"> 
		   {PAGENO}/{nb}
		</td>
	</tr>
  </table>	
</htmlpageheader>

<htmlpageheader name="otherpages" >
  <table width="100%" style="border-top: 0px solid #000000; font-size: 8pt; padding-top: 3mm; "> 
	<tr>
		<td>
			Ref..:<?php echo $nola; ?>
		</td>  
		<td align="right"> 
		   {PAGENO}/{nb}
		</td>
	</tr>
  </table>
</htmlpageheader>	

<htmlpagefooter name="footer-firstpage" style="display:none"> 
  <div align="right"> 
    {PAGENO}/{nb}
  </div>
</htmlpagefooter>
 

<sethtmlpageheader name="firstpage" value="on" show-this-page="1"/>
<sethtmlpagefooter name="footer-firstpage" value="off" page="first" show-this-page="1"/>
<sethtmlpageheader name="otherpages" value="on"/>
 
 <!-- set value from php -->
 <?php
	 $jangkawatusewa = 0;
	 if(!empty($result)){
		foreach($result as $row){ 
			$jangkawatusewa = $row->agreement_term;
		}
	
 ?>
 <!-- set value from php -->
 
<table border="0" cellspacing="0" cellpadding="0" width="90%" > 
<tbody>
<tr>
<td valign="top" ><p><b><i>PRIVATE &amp; CONFIDENTIAL</i></b></p></td>
</tr>

<tr>
<td valign="top" align="right" ><p><b> xxx # L xx</b></p></td>
</tr>

<tr>
<td valign="top" ><p><b><?php echo $vconname; ?></b></p>

<p><b><?php echo $result[0]->rekanan_name; ?></b></p>

<p><b><?php echo $result[0]->rekanan_address; ?></b></p>

<p>Jakarta, <?php echo date('d-m-Y') ?></p></td>
</tr>

<tr>
<td valign="top" > </td>
</tr>

<tr>
<td valign="top" ><p><b>Attn: <?php echo $result[0]->rekananshipping_contactname; ?></b></p>

</td>
</tr>

</tbody>
</table>

<h2 align="center" >SURAT PENAWARANAREA SEWA</h2>

<p align="center"><b><?php echo $vunit['name_unit']; ?></b></p>

<p align="center"><b><?php echo $vunit['branch_name']; ?></b></p>

<p>Terima kasih atas ketertarikan Bapak/Ibu dalam melakukan bisnis di <?php echo $vunit['branch_name']; ?> (“<b>Mall</b>”).</p>

<p><b><?php echo $vunit['branch_name']; ?></b>(“<b>Pemilik</b>”),menawarkan area sewa untuk disewakan sebagaimana tersebut di bawah ("<b>Ruang Sewa</b>"), berikut dengan syarat dan ketentuan pada pokoknya. Syarat dan ketentuan akan diatur dalam standard Perjanjian Sewa Menyewa (“<b>Perjanjian</b>”), yang disyaratkan untuk ditandatangani oleh penyewa sehubungan dengan Ruang Sewa.</p>

<p>Oleh karena itu, dengan ini memberikan penawaran area sewa dengan ketentuan-ketentuan sebagai berikut: : </p>

<table width="100%" border="0" style="font-size: 9pt;text-align:justify;line-height:2;">
	
	<tr>
		
		<td> <b>1.</b> </td>
		<td colspan="4"><b>RUANG SEWA</b>: (<i>sebagaimana ditandai pada denah terlampir</i>)</td>  
		
	</tr>
	
	<tr>
		 
		<td ></td> 
		<td colspan="4">Lantai / Unit : <b><?php echo $vunit['lantai_name'].' / '.$vunit['unit_name']; ?></b></td> 
		
	</tr>
	
	<tr>
		
		<td> <b>2.</b> </td>
		<td colspan="4"><b>LUAS AREA SEWA</b></td>  
		
	</tr>
	
	<tr>
		 
		<td ></td> 
		<td colspan="4"><b><?php echo $vunit['unit_sqm']; ?></b>&nbsp;(m2) meter persegi, dengan merujuk pada pengukuran ulang yang ditandatangani oleh Penyewa atau perwakilannya. </td> 
		
	</tr>
	
	<tr>
		
		<td> <b>3.</b> </td>
		<td colspan="4"><b>JANGKA WAKTU SEWA</b></td>  
		
	</tr>
	
	<tr>
		 
		<td></td> 
		<td colspan="4"><b><?php echo $jangkawatusewa; ?></b> (<?php echo number_to_wordsnorp($row->agreement_term);?>) <b>bulan</b> terhitung dari Tanggal Mulai Sewa sebagaimana disebutkan di bawah.</td> 
		
	</tr>
	 
	<tr>
		
		<td> <b>4.</b> </td>
		<td colspan="4"><b>PENGGUNAAN RUANG SEWA</b></td>  
		
	</tr>
	
	<tr>
		 
		<td ></td> 
		<td colspan="4">
		Ruang Sewa digunakan untuk kegiatan usaha <?php echo ($rkomisaris['jenisusaha']=='') ? '-' : $rkomisaris['jenisusaha'];?> dengan nama dagang <b><?php echo  ($rkomisaris['merkdagang'] == '' ) ? '-' : $rkomisaris['merkdagang']; ?>.</b>
		<p>Pelayanan, operasional dan kegiatan usahanya harus sesuai dengan standar yang ditetapkan, dipertahankan dan dipantau oleh penyewa,serta tunduk pada persetujuan dari Pemilik sebelum pelaksanaan sewa menyewa ini.Penyewa harus bertanggung jawab untuk mendapatkan semua persetujuan dan perijinan yang diperlukan dari instansi terkait dengan biaya tanggung jawab pihak Penyewa sendiri sepenuhnya. Setiap perubahan penggunaan dari Ruang Sewa berikut barang dan atau jasayang diusahakan harus dengan persetujuan tertulis Pemilik dan tidak akan ditolak tanpa ada alasan yang jelas.</p>
		</td> 
		
	</tr>
	
	<!-- baris manual -->
	<tr> 
		<td> &nbsp; </td>
		<td colspan="4">&nbsp;</td>  
	</tr>
	<!-- baris manual -->
	
	<!-- baris manual -->
	<tr> 
		<td> &nbsp; </td>
		<td colspan="4">&nbsp;</td>  
	</tr>
	<!-- baris manual -->
	
	<!-- baris manual -->
	<tr> 
		<td> &nbsp; </td>
		<td colspan="4">&nbsp;</td>  
	</tr>
	<!-- baris manual -->
	
	<!-- baris manual -->
	<tr> 
		<td> &nbsp; </td>
		<td colspan="4">&nbsp;</td>  
	</tr>
	<!-- baris manual -->
	
	<!-- baris manual -->
	<tr> 
		<td> &nbsp; </td>
		<td colspan="4">&nbsp;</td>  
	</tr>
	<!-- baris manual -->
	
	<tr>
		
		<td> <b>5.</b> </td>
		<td colspan="4"><b>BIAYA SEWA</b></td>  
		
	</tr>
	<!-- POINT 5 ADA TABLE DETIL -->
	<tr>
		 
		<td> &nbsp;</td> 
		<td colspan="5">
				<p>Biaya Sewa sebesar <b>Rp.<?php echo number_format($rloirent['baserent'],0);?>,-</b> (<?php echo ($rloirent['baserent'] == '') ?'' : number_to_wordsnorp($rloirent['baserent']);?> Rupiah) per meter persegi per bulan belum termasuk PPN, dibayarkan setiap bulan dimuka.Total Biaya Sewa selama <b>Jangka Waktu Sewa</b> adalah <b>Rp.<?php echo number_format($rloirent['subtotal'],0);?>,-</b> (<?php echo ($rloirent['baserent'] == '') ?'' : number_to_wordsnorp($rloirent['baserent']);?> Rupiah) dibayarkan sebagai berikut:</p>
				
				<table border="0" width="100%" style="text-align:justify;line-height:2;font-size: 9pt;">
					<tr>
						<td valign="top">
							a. 
						</td>
						<td valign="top">
							<b>20% </b>(Dua Puluh persen)dari Total Biaya Sewa berupa pembayaran uang muka yang tidak dapat dikembalikanatau sejumlah <b>Rp.<?php echo number_format($ruangmukasewa[0]->_percent,0) ?>,- </b>(<?php echo number_to_wordsnorp($ruangmukasewa[0]->_percent);?> Rupiah), ditambah dengan Pajak Pertambahan Nilai (PPN) harus dibayarkan pada saat penandatanganan Surat PenawaranArea Sewa.</p>

							<p>Note: Pembayaran DP dapat dibayar 2 kali dengan rincian sbb:</p>
						</td> 
					</tr>
					<tr>
						<td>
							&nbsp;
						</td>
						<td  colspan="2">
							<!-- section sub no 5 -->
							<table width="100%" style="text-align:justify;line-height:2;font-size: 9pt;" border="0">
								<tr>
									<td valign="top">
										a.
									</td>
									<td valign="top">
										<b>10% </b>(Sepuluh persen) dari Total Biaya Sewa berupa pembayaran uang muka yang tidak dapat dikembalikan atau sejumlah <b>Rp.<?php echo number_format($ruangmukasewa[0]->_percent_,0) ?>,- </b>(<?php echo number_to_wordsnorp($ruangmukasewa[0]->_percent_);?> Rupiah), ditambah dengan Pajak Pertambahan Nilai (PPN) harus dibayarkan pada saat penandatanganan Surat Penawaran Area Sewa.
									</td>
								</tr>
								<tr>
									<td valign="top">
										b.
									</td>
									<td valign="top">
										<b>10% </b>(Sepuluh persen) dari Total Biaya Sewa berupa pembayaran uang muka yang tidak dapat dikembalikan atau sejumlah <b>Rp.<?php echo number_format($ruangmukasewa[0]->_percent_,0) ?>,- </b>(<?php echo number_to_wordsnorp($ruangmukasewa[0]->_percent_);?> Rupiah), ditambah dengan Pajak Pertambahan Nilai (PPN) harus dibayarkan pada tanggal <?php echo date("d-m-Y",strtotime($ruangmukasewa[0]->agreementdetil_startdatepayment)); ?>.
									</td>
								</tr>
								
							</table>  
							<!-- section sub no 5 -->
						</td> 
					</tr>
					<tr>
						<td valign="top">
							b.
						</td> 
						<td valign="top">
							<b>80% </b>(Delapan puluh persen)dari Total Biaya Sewa atau sejumlah <b>Rp.<?php echo number_format(($rloirent['subtotal']*0.8),0) ?>,- </b>(<?php echo number_to_wordsnorp(($rloirent['subtotal']*0.8)) ?> Rupiah), dibayarkan dalam <b><?php echo ($rloirent['term']); ?></b>(<?php echo number_to_wordsnorp($rloirent['term']); ?>) kali angsuran atau sejumlah <b>Rp.<?php echo number_format($rloirent['baserent'],0);?>,-</b> (<?php echo ($rloirent['baserent'] == '') ?'' : number_to_wordsnorp($rloirent['baserent']);?> Rupiah) per bulan ditambah dengan Pajak Pertambahan Nilai (PPN), dimulai sejak Tanggal Mulai Sewa.
							<p>Pembayaran pertama kali dilakukan 14 (empat belas) hari kalender sebelum Tanggal Mulai Sewa (Pembukaan Outlet)</p>
						</td>
					</tr>
							
				</table> 
		</td>  
	</tr> <!-- point 5 --> 
	
	<tr>
		
		<td> <b>6.</b> </td>
		<td colspan="4"><b>BIAYA PELAYANAN</b></td>  
		
	</tr>
	
	<tr>
		 
		<td></td> 
		<td colspan="4">
			<p>Biaya Pelayanan dibebankan kepada Penyewa sebesar <b>Rp.<?php echo number_format($rintservice['baserent'],0) ?>,-</b> (<?php echo number_to_wordsnorp($rintservice['baserent']) ?> Rupiah) per meter persegi per bulan, ditambah dengan Pajak Pertambahan Nilai (PPN) berlaku sejak Tanggal Mulai Sewa. Biaya Pelayanan dapat ditinjau kembali oleh Pemilik.</p>

			<p>Biaya Pelayanan dibayarkan per 3 (tiga) bulan di muka dan pembayaran pertama kali dilakukan 14 (empat belas) hari kalender sebelum Tanggal Mulai Sewa (Pembukaan Outlet).</p>
		</td> 
		
	</tr> 
	
	<tr>
		
		<td> <b>7.</b> </td>
		<td colspan="4"><b>BIAYA PROMOSI</b></td>  
		
	</tr>
	
	<tr>
		 
		<td></td> 
		<td colspan="4"> 
			<p>Penyewa dengan ini setuju membayar suatu biaya promosi sebagai kontribusi Penyewa terhadap biaya untuk mempromosikan dan mengiklankan mal, sebesar <b>Rp.<?php echo number_format($rnilaipromo['agreementdetil_baserent'],0);?></b>,- (<?php echo number_to_wordsnorp($rnilaipromo['agreementdetil_baserent']);?> Rupiah) untuk setiap meter persegi per bulan. </p>

			<p>Berlaku sejak Tanggal Mulai Sewa sampai dengan waktu yang telah ditentukan oleh Pemilik, setelah itu Biaya Promosi akan ditinjau ulang setiap periode. Pembayaran pertama dilakukan 14 (empat belas) hari kalender sebelum Tanggal Mulai Sewa (Pembukaan Outlet).</p>
		</td> 
		
	</tr>
	
	<tr>
		
		<td> <b>8.</b> </td>
		<td colspan="4"><b>TANGGAL MULAI SEWA</b></td>  
		
	</tr>
	
	<tr>
		 
		<td></td> 
		<td colspan="4"> 
					
			<p>Tanggal Mulai Sewa adalah <b><?php echo $new_date = date('d F Y', strtotime($result[0]->loo_sdate));?></b></p>  
			
		</td> 
		
	</tr> 
	
	<!-- baris manual -->
	<tr> 
		<td> &nbsp; </td>
		<td colspan="4">&nbsp;</td>  
	</tr>
	<!-- baris manual -->
	
	<!-- baris manual -->
	<tr> 
		<td> &nbsp; </td>
		<td colspan="4">&nbsp;</td>  
	</tr>
	<!-- baris manual --> 
	
	<tr>
		
		<td> <b>9.</b> </td>
		<td colspan="4"><b>PERIODE PENATAANRUANG SEWA (FITTING-OUT)</b></td>  
		
	</tr>
	
	<tr>
		 
		<td></td> 
		<td colspan="4"> 
					
			<p>Pemilik memberikan waktu untuk periode penataanRuang Sewa (fit out) selama <b>8 (delapan) minggu</b> sejak Tanggal Serah Terima Ruang Sewa. </p> 
			<p>Pelaksanaan penataan Ruang Sewa (<i>Fitting out</i>) harus dikoordinasikan dengan Bagian <i>Tenant Fit OutCoordinator</i> terkait dengan standar dan peraturan mengenai <i>Fitting out</i> dan desain rencana <i>Fitting out</i> harus mendapatkan persetujuan dari Pemilik terlebih dahulu. </p> 
			<p>Bilamana Ruang Sewa telah siap dibuka untuk berdagang sebelum berakhirnya Jangka Waktu <i>fitting-out</i>, maka Penyewa wajib membuka Ruang Sewa untuk berdagang dan Biaya Sewa serta biaya biaya lain harus dibayar sejak tanggal pembukaan tersebut.</p> 
			<p>Apabila Penyewa belum memulai fit out dalam waktu 30 hari sejak Tanggal Serah Terima Ruang Sewa, maka Pemilik berhak melakukan pengakhiran/pembatalan sewa sepihak.</p> 
			<p>Setelah berakhirnya periode fitting out /waktu yang ditentukan, Penyewa wajib membuka usaha/mengoperasikan usahanya. Apabila Penyewa tidak melaksanakan ketentuan tersebut, maka Penyewa akan dikenakandenda <a name="_GoBack"></a>sebesar1 %o (satu per mil) per hari dari keseluruhan uang sewa dengan maksimum 30 hari kalender, dan setelah denda mencapai maksimum tersebut maka dengan lewatnya waktu tersebut membuktikan kelalaian Penyewa dan Pemilik berhak melakukan pengakhiran/pembatalan sewa sepihak.</p> 
			<p>Pengakhiran dan pembatalan sewa sesuai ketentuan di atas, para pihak sepakat mengesampingkan pasal 1266 KUH Perdata dan Penyewa menerima sanksi tersebut berikut setiap resiko yang timbul.</p> 
			
		</td> 
		
	</tr>
	
		
	<tr>
		
		<td> <b>10.</b> </td>
		<td colspan="4"><b>SIMPANAN JAMINAN</b></td>  
		
	</tr>
	
	<tr>
		 
		<td></td> 
		<td colspan="4"> 
			<p>Simpanan Jaminan harus dibayarkan oleh Penyewa adalah senilai <b>3 (tiga) bulan Biaya Sewa dan Biaya Pelayanan. </b>Simpanan Jaminan ini akan disimpan dan akan dikembalikan kepada Penyewa setelah berakhirnya jangka waktu periode Sewa Menyewa.</p>

			<p>Simpanan Jaminan atas penggunaan jaringan Telepon oleh Penyewa dikenakan sebesar Rp. 3.500.000,- (tiga juta lima ratus ribu rupiah) per line. (apabila diperlukan dan mengajukan permintaan)</p>

			<p>Pembayaran Simpanan Jaminan dilakukan paling lambat 30 hari kalender sebelum Tanggal Mulai Sewa (Pembukaan Outlet).</p>

			<p>Simpanan Jaminan akan dikembalikan kepada Penyewa dengan ketentuan bebas dari bunga dan biaya apapun, setelah Jangka Waktu Sewa berakhir dan kewajiban-kewajiban dari Penyewa telah diselesaikan termasuk penyerahan kembali Ruang Sewa berdasarkan ketentuan Sewa Menyewa.</p>
		</td> 
		
	</tr> 
	
	<tr>
		
		<td> <b>11.</b> </td>
		<td colspan="4"><b>BIAYA UTILITIES</b></td>  
		
	</tr>
	
	<tr>
		 
		<td></td> 
		<td colspan="4">  
			<p>Biaya utilities (listrik, air, gas) dibayar oleh Penyewa sesuai dengan pemakaian dan akan ditagihkan setiap bulan sesuai dengan tarif yang berlaku pada gedung.</p>
		</td> 
		
	</tr> 
	
	<tr>
		
		<td> <b>12.</b> </td>
		<td colspan="4"><b>PAJAK PERTAMBAHAN NILAI (PPN)</b></td>  
		
	</tr>
	
	<tr>
		 
		<td></td> 
		<td colspan="4">  
			<p>Biaya Sewa dan Biaya Pelayanan dikenakan PPNsesuai dengan tarif yang berlaku, yang ditanggung oleh Penyewa.</p>
		</td> 
		
	</tr> 
	 
	<!-- baris manual -->
	<tr> 
		<td> &nbsp; </td>
		<td colspan="4">&nbsp;</td>  
	</tr>
	<!-- baris manual --> 
	<!-- baris manual -->
	<tr> 
		<td> &nbsp; </td>
		<td colspan="4">&nbsp;</td>  
	</tr>
	<!-- baris manual --> 
	<!-- baris manual -->
	<tr> 
		<td> &nbsp; </td>
		<td colspan="4">&nbsp;</td>  
	</tr>
	<!-- baris manual --> 
	<tr>
		
		<td> <b>13.</b> </td>
		<td colspan="4"><b>BIAYA PEMBUATAN PERJANJIAN</b></td>  
		
	</tr>
	
	<tr>
		 
		<td></td> 
		<td colspan="4">   
			<p>Penyewa dibebankan untuk membayar biaya terkait Perjanjian Sewa Menyewa seperti biaya Notaris, biaya materai dan/atau biaya lainnya.</p> 
			<p> 
			Jika Penyewa adalah Perusahaan (PT/CV), maka biaya Notaris untuk Perjanjian Sewa adalah sebesar <b>Rp.1.650.000</b>,- (Satu Juta Enam Ratus Lima Puluh Ribu Rupiah) sudah termasuk PPN 10% (sepuluh persen) dan apabila perorangan dikenakan biaya sebesar <b>Rp. 1.100.000,-</b> (Satu Juta Seratus Ribu Rupiah), sudah termasuk PPN 10% (sepuluh persen).</p>
		</td> 
		
	</tr>  
	
	<tr>
		
		<td> <b>14.</b> </td>
		<td colspan="4"><b>STANDAR SPESIFIKASI UNIT</b></td>  
		
	</tr>
	
	<tr>
		 
		<td></td> 
		<td colspan="5"> 
			<!-- table no 14 -->
				<table width="100%" border="1" style="font-size:12px;text-align:justify;">
					<tbody>
						<tr>
							<td width="182">
								<p>Lantai/<em>Floor</em></p>
							</td>
							<td width="24">
								<p>:</p>
							</td>
							<td width="366">
								<p>Sesuai kondisi eksisting (<em>Bare Finish</em>), beton bertulang.</p>
								<p>Perubahan interior lantai dikerjakan oleh dan atas biaya Penyewa sesuai standard gedung.</p>
							</td>
						</tr>
						<tr>
							<td width="182">
								<p>Dinding/Walls</p>
								<p>&nbsp;</p>
							</td>
							<td width="24">
								<p>:</p>
							</td>
							<td width="366">
								<p>Sesuai kondisi eksisting (<em>Bare Finish</em>)</p>
								<p>Finishing interior dinding dikerjakan oleh dan atas biaya Penyewa sesuai standard gedung.</p>
							</td>
						</tr>
						<tr>
							<td width="182">
								<p>Plafon/<em>Ceiling</em></p>
								<p>&nbsp;</p>
							</td>
							<td width="24">
								<p>:</p>
							</td>
							<td width="366">
								<p>Sesuai kondisi eksisting (<em>Bare Finish</em>)</p>
								<p>Finishing interior plafon dikerjakan oleh dan atas biaya Penyewa sesuai standard gedung.</p>
							</td>
						</tr>
						<tr>
							<td width="182">
								<p>Pengkondisian Udara</p>
								<p>(<em>Air Conditioning</em>)</p>
								<p>&nbsp;</p>
							</td>
							<td width="24">
								<p>:</p>
							</td>
							<td width="366">
								<p><em>Chiller/AHU</em>, <em>main ducting</em> dipasang hingga batas Ruang Sewa oleh Pemilik.</p>
								<p>Pemilik menyediakan suhu ruangan 24 &deg;C, &plusmn; 1&deg; C.</p>
								<p>Penambahan kapasitas ditanggung oleh Penyewa.</p>
								<p><em>Ducting, diffuser dan return grille</em> di dalam Ruang Sewa dipasang oleh Penyewa sesuai standard gedung.</p>
							</td>
						</tr>
						<tr>
							<td width="182">
								<p>Sistem Pemadam Kebakaran</p>
								<p>(<em>Fire Fighting System</em>)</p>
							</td>
							<td width="24">
								<p>:</p>
							</td>
							<td width="366">
								<p>Pipework, hydrant, sprinkler, detector, fire alarm disediakan oleh Pemilik sesuai standard gedung.</p>
							</td>
						</tr>
						<tr>
							<td width="182">
								<p>Alat Pemadam Api Ringan (APAR)/ (<em>Portable Fire Extinguisher</em>)</p>
							</td>
							<td width="24">
								<p>:</p>
							</td>
							<td width="366">
								<p>Disediakan oleh Penyewa sesuai standard gedung.</p>
							</td>
						</tr>
						<tr>
							<td width="182">
								<p>Daya Listrik</p>
								<p>(<em>Power Supply</em>)</p>
							</td>
							<td width="24">
								<p>:</p>
							</td>
							<td width="366">
								<p>Daya listrik yang disediakan oleh Pemilik sebesar 100 VA/M2.</p>
								<p>Penambahan daya oleh Pemilik atas biaya Penyewa.</p>
							</td>
						</tr>
						<tr>
							<td width="182">
								<p>Listrik Cadangan</p>
								<p>(<em>Back Up Power</em>)</p>
							</td>
							<td width="24">
								<p>:</p>
							</td>
							<td width="366">
								<p>100% untuk pencahayaan/lighting dan peralatan.</p>
								<p>60% untuk sistem AC/Ventilasi.</p>
							</td>
						</tr>
						<tr>
							<td width="182">
								<p>Instalasi Listrik</p>
								<p>(<em>Electrical Power</em>)</p>
								<p>&nbsp;</p>
							</td>
							<td width="24">
								<p>:</p>
							</td>
							<td width="366">
								<p>Pemilik memasang kabel listrik beserta kWh meter di tempat yang telah ditentukan oleh Pemilik di dalam Ruang Sewa.</p>
								<p>Seluruh instalasi dari panel dalam unit, biaya pemakaian listrik bulanan ditanggung oleh Penyewa.</p>
							</td>
						</tr>
						<tr>
							<td width="182">
								<p>Penerangan</p>
								<p>(<em>Lighting</em>)</p>
							</td>
							<td width="24">
								<p>:</p>
							</td>
							<td width="366">
								<p>Sesuai kondisi eksisting (<em>Bare Condition</em>). Instalasi dan fixture oleh Penyewa sesuai standard gedung.</p>
							</td>
						</tr>
						<tr>
							<td width="182">
								<p>Penerangan Darurat</p>
								<p>(<em>Emergency Lamp</em>)</p>
							</td>
							<td width="24">
								<p>:</p>
							</td>
							<td width="366">
								<p>Disediakan oleh Penyewa sesuai standard gedung.</p>
							</td>
						</tr>
						<tr>
						<td width="182">
							<p>Lampu Malam</p>
							<p>(<em>Night Lamp</em>)</p>
						</td>
						<td width="24">
							<p>:</p>
						</td>
						<td width="366">
							<p>Menyala selama 24 jam.</p>
							<p>Lampu (<em>fixtures</em>) dan kabel oleh Penyewa sesuai standard gedung.</p>
						</td>
					</tr>
					</tbody>
				</table>
			<!-- table no 14 -->
		</td>  
	</tr> 
	
	<!-- lanjutan no 14 --> 
	<tr>
		 
		<td></td> 
		<td colspan="5"> 
			<table width="100%" border="1" style="font-size:12px;text-align:justify;">
				<tbody>
					
					<tr>
						<td width="182">
							<p>Tata Suara Darurat</p>
							<p>(<em>Emergency Sound System</em>)</p>
						</td>
						<td width="24">
							<p>:</p>
						</td>
						<td width="366">
							<p>Instalasi untuk panggilan darurat disediakan oleh Pemilik.</p>
						</td>
					</tr>
					<tr>
						<td width="182">
							<p>Telepon</p>
						</td>
						<td width="24">
							<p>:</p>
						</td>
						<td width="366">
							<p>1 (satu) saluran dipasang dan disambung oleh Pemilik.</p>
						</td>
					</tr>
					<tr>
						<td width="182">
							<p>Kapasitas Beban Lantai</p>
							<p>(<em>Floor Loading Capacity</em>)</p>
						</td>
						<td width="24">
							<p>:</p>
						</td>
						<td width="366">
							<p>Kapasitas beban lantai 350 Kg/m2</p>
						</td>
					</tr>  
					<tr>
						<td width="182">
							<p>Tampak Depan</p>
							<p>(<em>Shop Front</em>)</p>
							<p>&nbsp;</p>
						</td>
						<td width="24">
							<p>:</p>
						</td>
						<td width="366">
							<p>Sesuai kondisi eksisting (<em>Bare Finish</em>)</p>
							<p><em>Shop Front</em> menghadap ke area umum dikerjakan oleh dan atas biaya Penyewa sesuai Ketentuan dan Panduan Fitting Out Ruang Sewa.</p>
						</td>
					</tr>
					<tr>
						<td width="182">
							<p>Fixture Tambahan, Fitting &amp; Perlengkapan</p>
						</td>
						<td width="24">
							<p>:</p>
						</td>
						<td width="366">
							<p>Jika ada, diterima sebagaimana adanya, untuk dapat dikembalikan sesuai dengan standard semula dan dengan kondisi yang masih berfungsi pada akhir masa sewa, kerusakan berupa keausan karena pemakaian yang wajar dikecualikan.</p>
							<p>Rincian peralatan tersebut disetujui bersama pada saat serah terima ruang sewa.</p>
						</td>
					</tr>
				</tbody>
			</table>
		</td>  
	</tr>
	<!-- lanjutan no 14 -->
	
	  
	<tr>
		
		<td> <b>15.</b> </td>
		<td colspan="4"><b>PERSETUJUAN KESEPAKATAN</b></td>  
		
	</tr>
	
	<tr>
		 
		<td></td> 
		<td colspan="4">   
			<p>Apabila Bapak/Ibu setuju dengan syarat dan ketentuan pokok pada Surat Penawaran ini, agar memberikan tanda persetujuan dengan menandatangani pada kolom tanda tangan dan memberikan paraf pada setiap halaman Surat Penawaran ini, apabila suatu perusahaan agar membubuhkan stempel perusahaan pada kolom tanda tangan Surat Penawaran dan mengembalikan Surat Penawaran ini kepada kami dalam waktu 7 (tujuh) hari sejak tanggal Surat Penawaran ini.</p>

			<p><br />
			Bapak/Ibu dianggap menolak Surat Penawaran ini, apabila kami tidak menerima Surat Penawaran yang telah ditandantangani dan pembayaran uang muka setelah lewatnya jangka waktu tujuh (7) hari dari tanggal Surat Penawaran tertulis diatas, dan kami berhak untuk menawarkan area sewa kepada pihak lain tanpa pemberitahuan kepada Bapak/Ibu.</p>
			
			<p><br />
			Setelah menerima kembali Surat penawaran yang telah ditandatangani oleh Bapak/Ibu, maka akandipersiapkan Perjanjian Sewa Menyewa dan dalam waktu 14 (empat belas) hari setelah pemberitahuan jadwal penandatanganan harus ditandatangani oleh Penyewa.	</p>
		</td>  
	</tr>   
	
	<tr>
		
		<td> <b>16.</b> </td>
		<td colspan="4"><b>PEMBAYARAN </b></td>  
		
	</tr>
	
	<tr> 
		<td>&nbsp;</td> 
		<td colspan="5">   
			<p>Seluruh pembayaran kepada Pemilik harus dibayarkan ke rekening bank Pemilik, melalui transfer rekening ke:</p>
			<table border="0" width="100%" style="text-align:justify;line-height:2;font-size: 9pt;">
			<tr>
				<td> &nbsp; </td>
			</tr>
			<tr>
			<td align="center">
				<span><b>PT. xxxxx</b></span> <br/>
				<span><b>A/C No. : xxxx</b></span><br/>
				<span><b>Bank Mega KCU Jakarta Tendean</b></span><br/>
			</td>
			</tr>
			</table>
			
		</td>  
	</tr>  
	 
	
	<!-- baris manual -->
	<tr> 
		<td> &nbsp; </td>
		<td colspan="4">&nbsp;</td>  
	</tr>
	<!-- baris manual -->
	
	<!-- baris manual -->
	<tr> 
		<td> &nbsp; </td>
		<td colspan="4">&nbsp;</td>  
	</tr>
	<!-- baris manual -->
	
	<!-- baris manual -->
	<tr> 
		<td> &nbsp; </td>
		<td colspan="4">&nbsp;</td>  
	</tr>
	<!-- baris manual -->
	
	<!-- baris manual -->
	<tr> 
		<td> &nbsp; </td>
		<td colspan="4">&nbsp;</td>  
	</tr>
	<!-- baris manual -->
	
	<!-- baris manual -->
	<tr> 
		<td> &nbsp; </td>
		<td colspan="4">&nbsp;</td>  
	</tr>
	<!-- baris manual -->
	
	<!-- baris manual -->
	<tr> 
		<td> &nbsp; </td>
		<td colspan="4">&nbsp;</td>  
	</tr>
	<!-- baris manual -->
	
	<tr>
		
		<td> <b>17.</b> </td>
		<td colspan="4"><b>KETENTUAN LAIN</b></td>  
		
	</tr>
	
	<tr> 
		<td>&nbsp;</td> 
		<td colspan="4">   
			<p>Penyewa tidak berhak mengakhiri Surat Penawaran Area Sewa dan Perjanjian Sewa Menyewa sebelum tanggal berakhirnya sewa dengan atau tanpa alasan apapun. Dalam terjadi pengakhiran sewa sebelum tanggal berakhiranya sewa, maka Uang Muka dan Jaminan Sewa menjadi hangus dan tidak dapat diambil kembali oleh Penyewa dan Penyewa wajib melunasi pembayaran sewa sampai dengan akhir sewa.Perjanjian menjadi batal demi hukum.</p>

			<p>
			<i>Lay out</i> sewaktu waktu dapat berubah sesuai dengan commercial plan sampai dengan Perjanjian Sewa Menyewa ditandatangani.</p>
			  
		</td>  
	</tr>   
	
	<tr>
		
		<td> <b>18.</b> </td>
		<td colspan="4"><b>DOKUMEN PENYEWA</b></td>  
		
	</tr>
	
	<tr> 
		<td>&nbsp;</td> 
		<td colspan="4">   
			<p>Jika Penyewa adalah Perusahaan (PT/CV), agar untuk menyerahkan fotokopi Akta Perusahaan (Akta Pendirian, Akta Perubahan Direksi & Komisaris terakhir, Akta Perubahan Anggaran Dasar) dan SK Menkumham / Pemberitahuan (PT/CV), fotokopi KTP Direktur atau perwakilan yang berwenang menandatangani(Surat Kuasa jika dikuasakan) dan setiap dokumen perijinan yang diperlukan untuk memenuhi persyaratan legal (TDP,SIUP,HO,NPWP) pada saat penyerahan kembali Surat Penawaran Sewa yang telah ditandantangani.</p>
			  
		</td>  
	</tr>   
</table>   

<p>Atas perhatian dan kerjasamanya disampaikan terima kasih.</p>

<p style="line-height:0;">Untuk dan atas nama 
<br/>
 PT. <?php echo $vunit['branch_name']; ?></p>

<br />
<br />
<br />
<p style="line-height:0;">
<u><b><?php echo $rkomisaris['penanggung_jawab'];?></b></u>
<br/>
<?php echo $rkomisaris['jabatan_pemilik'];?></p>


<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />

<p>Saya yang bertandatangan di bawah ini menyetujui melakukan kerjasama dengan persyaratan dan ketentuan tersebut diatas dan meminta PT. <?php echo $vunit['branch_name']; ?> untuk membuatkan Perjanjian Sewa:</p>

<br />

<table width="100%" border="0" style="line-height:3;">

	<tr>
		<td width="30%">
			Nama Perusahaan
		</td>
		<td width="2%">
			:
		</td>
		<td>
			<?php echo $result[0]->rekanan_name; ?>
		</td>
	</tr>
	<tr>
		<td width="30%">
			Nama (dalam huruf besar)
		</td>
		<td width="2%">
			:
		</td>
		<td>
			<?php echo strtoupper($result[0]->rekananshipping_name); ?>
		</td>
	</tr>
	<tr>
		<td width="30%">
			Tanda Tangan
		</td>
		<td width="2%">
			:
		</td>
		<td>
			……………………………………………………………………………
		</td>
	</tr>
	<tr>
		<td width="30%">
			No. KTP
		</td>
		<td width="2%">
			:
		</td>
		<td>
			……………………………………………………………………………
		</td>
	</tr>
	<tr>
		<td width="30%">
			Alamat Perusahaan
		</td>
		<td width="2%">
			:
		</td>
		<td>
			<?php echo $result[0]->rekanan_address; ?>
		</td>
	</tr>
	<tr>
		<td width="30%">
			&nbsp;
		</td>
		<td width="2%">
			&nbsp;
		</td>
		<td>
			……………………………………………………………………………
		</td>
	</tr>
	<tr>
		<td width="30%">
			&nbsp;
		</td>
		<td width="2%">
			&nbsp;
		</td>
		<td>
			……………………………………………………………………………
		</td>
	</tr>
	
	<tr>
		<td width="30%">
			Telp./HP/Fax
		</td>
		<td width="2%">
			:
		</td>
		<td>
			……………………………………………………………………………
		</td>
	</tr>
	<tr>
		<td width="30%">
			Email
		</td>
		<td width="2%">
			:
		</td>
		<td>
			……………………………………………………………………………
		</td>
	</tr>
	<tr>
		<td width="30%">
			NPWP
		</td>
		<td width="2%">
			:
		</td>
		<td>
			……………………………………………………………………………
		</td>
	</tr>
	<tr>
		<td width="30%">
			SKT
		</td>
		<td width="2%">
			:
		</td>
		<td>
			……………………………………………………………………………
		</td>
	</tr>
	<tr>
		<td width="30%">
			TDP
		</td>
		<td width="2%">
			:
		</td>
		<td>
			……………………………………………………………………………
		</td>
	</tr>
	<tr>
		<td width="30%">
			Akta Perusahaan
		</td>
		<td width="2%">
			:
		</td>
		<td>
			……………………………………………………………………………
		</td>
	</tr>
	
	<tr>
		<td width="30%">
			SIUP
		</td>
		<td width="2%">
			:
		</td>
		<td>
			……………………………………………………………………………
		</td>
	</tr>
	
</table>     

<p>*<i>softcopy</i> dan <i>hardcopy</i> wajib diserahkan</p>

<p>Tanggal <?php echo date('d'); ?>. Bulan <?php echo getIndoBulan(date('m')); ?> <?php echo date('Y'); ?></p>

</p>
<?php  } ?>
</body>
</html>