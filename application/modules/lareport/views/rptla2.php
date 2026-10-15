
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Letter Agreement</title>
 
<style type="text/css">
@font-face {
    font-family: 'arial'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/Courier_New.ttf');?>'); /*URL to font*/
}
@font-face {
    font-family: 'arial'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/arialbd.ttf');?>'); /*URL to font*/
    font-weight: bold;
}

.spacefill,
.spacefill-dots {
  line-height: 2;
  font-size: 10pt;
}

.spacefill {
   content: '';
}

.spacefill-dots {
  z-index: -1;
  /* Push dots behind text */
  height: 2;
  /* Same as line-height */
  border: 0;
  margin: 0;
  padding: 0;
  left: 0;
  right: 0;
  bottom: 0;
  position:absolute;
  overflow: hidden;
}

.spacefill-text {
  background: white;
  /* Very important. Choose backgroundcolor*/
  padding-right: 2px;
  /* Optional space before first point*/
}

.spacefill .spacefill-dots::after {
  content: "----------------------------------------------------------------------------------------------------------------------------------"
}

.spacefill1 {  line-height: 2;
  font-size: 10pt;
}
 
@page { size:8.5in 11in; }
.page{ width: 612px; height: 1020px; position: relative; margin-left:4cm; margin-right:2cm; margin-top:0.5cm; margin-bottom: -20px; } 
.header{ text-align: right;top:0px; }
.footer{ text-align: center; font-size: 8pt; margin-top: 900px;} 
#page_template{ display: none; }	
.page{font-size: 10pt; } 
#page_template #footer{
	margin-bottom:900px;
}
.no-spacing:after {
  content: '';
  line-height: 50%;
}
.content{
	
}
 
</style>

	 <script src="<?php echo base_url('assets/plugins/jquery-2.js');?>" type="text/javascript"></script> 
	 <script src="<?php echo base_url('assets/plugins/autocolumn.min.js');?>" type="text/javascript"></script> 
	<script> 
	$(document).ready(function() {
			
			$(function(){
			var totPage = 1;
			var content_height = 920;	// the height of the content, discluding the header/footer
			var page = 1;				// the beginning page number to show in the footer
			function buildNewsletter(){
				if($('#LAContent').contents().length > 0){
					// when we need to add a new page, use a jq object for a template
					// or use a long HTML string, whatever your preference
					$page = $("#page_template").clone().addClass("page").css("display", "block");
					
					// fun stuff, like adding page numbers 
					$page.find(".header span").append( page +' /');
					$page.find(".header span").append( " <td id='baz'> CPage </td>");
					$("body").append($page);
					page++; 
					totPage++;
						// here is the columnizer magic
					$('#LAContent').columnize({
						columns: 1,
						target: ".page:last .content",
						overflow: {
							height: content_height, 
							id: "#LAContent",
							doneFunc: function(){
								//console.log("done with page");  
								buildNewsletter();
							}
						}
					});
				} 
			} 
				setTimeout(buildNewsletter, 1000);   
			});
	    $(function() { 
			setTimeout(function() {
			$templateCount =  $(".content").children().length; 
			$('.header span td').text($('#baz').text().replace('CPage', $templateCount));  
            }, 1500); 
		}); 
	});	
	</script>

<body id="bdy"> 
<div id="page_template">  
	<div class='header'><span></span></div>  
	<div class='content'></div>  
	<br/><br/><br/><div class='footer'><center><hr><span> <?php echo $nola;?></span></center></div>  
</div> 
<div id="LAContent">
		
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
 
<table width="600" border="0" cellpadding="0" cellspacing="0" >

  <tr> 
    <td colspan="2" align="center" style="font-family: 'arial';font-size: 10pt"><strong>PERJANJIAN SEWA MENYEWA</strong></td>
  </tr>
  <tr> 
    <td height="24" colspan="2" align="center" style="font-family: 'arial';font-size: 10pt;line-height:2"><?php echo $nolah;?></td>
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
    <td colspan="2" align="justify" style="font-family: 'arial';font-size: 10pt;line-height:2" >- Pukul <?php if ($rkomisaris['tgl_notaris']<>"") { echo $time;}?></td>
  </tr>
  <tr>
    <td colspan="2" align="justify" style="font-family: 'arial';font-size: 10pt;line-height:2" >- Pada hari ini,<?php echo $dayList[$day]; ?> <br/> Tanggal 	 
	<?php  if ($rkomisaris['tgl_notaris']<>"") { echo getIndoHari($date);}?> </td>
  </tr>
   <tr>
    <td colspan="2" align="justify" style="font-family: 'arial';font-size: 10pt;line-height:2" >- Hadir di hadapan saya, <?php  if ($rkomisaris['nama_notaris']<>"") { echo $rkomisaris['nama_notaris'];}?>, Notaris di <?php  if ($rkomisaris['domisili_notaris']<>"") { echo $rkomisaris['domisili_notaris'];}?>, dengan dihadiri oleh 2 (dua) saksi yang nama-namanya akan disebut pada bagian akhir akta ini dan yang telah saya, Notaris, kenal. 
	</td>
  </tr> 
  <tr> <td align="left" valign="top" style="font-family: 'arial';font-size: 10pt;line-height:2;">I.</td>
    <td  align="justify" style="font-family: 'arial';font-size: 10pt;line-height:2;"> 
	<?php  if ($rkomisaris['saksi1']<>"") { echo  $rkomisaris['saksi1'] ;} ?> <?php  if ($rkomisaris['saksi2']<>"") { echo  $rkomisaris['saksi2'] ;} ?> </td>
  </tr> 
  <tr> 
  <tr>
    <td align="left" valign="top" style="font-family: 'arial';font-size: 10pt;line-height:2;">II.</td>
    <td  align="justify" style="font-family: 'arial';font-size: 10pt;line-height:2;width:auto;"> 
	</td>
  </tr>   
  
  <tr> 
    <td colspan="2" align="justify" style="font-family: 'arial';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-Para penghadap dalam kedudukannya masing masing sebagaimana tersebut di atas dengan ini menyatakan hal-hal sebagai berikut:</div></td>
  </tr>
  <tr> 
    <td colspan="2" align="justify" style="font-family: 'arial';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-BAHWA, Pemilik adalah pengembang suatu komplek bangunan multi guna yang, sebagaimana yang direncanakan, setelah selesainya akan terdiri dari berbagai bangunan dan suatu bangunan pusat perbelanjaan eceran dengan fasilitas parkirnya, pengembangan dan perlengkapan lainnya sebagaimana yang dari waktu ke waktu ditetapkan atau dikembangkan oleh Pemilik, terletak di <?php echo $row->branch_namerpt;?> <?php echo $row->branch_address;?> (seluruhnya disebut “<strong>Kompleks</strong>”);</span></div></td>
  </tr>
  <tr> 
    <td colspan="2" align="justify" style="font-family: 'arial';font-size: 10pt"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-BAHWA, Pemilik telah membangun sebagian dari Kompleks yaitu berupa bangunan pusat perbelanjaan yang dikenal sebagai “Trans Studio Mall” termasuk fasilitas parkir dan pengembangannya, baik yang berada di dalam maupun di luar bangunan yang khusus diperuntukan bagi bangunan pusat perbelanjaan tersebut sebagaimana yang dari waktu ke waktu ditetapkan oleh Pemilik (seluruhnya disebut “<strong>Mal</strong>”);</span></div></td>
  </tr> 
  <tr> 
    <td colspan="4" align="justify" style="font-family: 'arial';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">-BAHWA, Pemilik bermaksud untuk menyewakan kepada Penyewa dan Penyewa bermaksud untuk menyewa dari Pemilik sebagian dari Mal sebagaimana yang didefinisikan disini sebagai "Ruang Sewa" berdasarkan ketentuan-ketentuan "Perjanjian Sewa Menyewa" ini dan "Syarat Syarat Sewa" yang menjadi lampirannya (termasuk seluruh Apendik, Eksibit dan Skedulnya seluruhnya disebut "Sewa Menyewa").</span></div></td>
  </tr>
  <tr> 
    <td colspan="4" align="justify" style="font-family: 'arial';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">KARENANYA, berdasarkan apa yang tersebut diatas Pemilik dan Penyewa setuju sebagai berikut:</span></div></td>
  </tr>
  <tr> 
    <td colspan="4" align="justify" style="font-family: 'arial';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text"><strong>-----------------------------------------------Pasal 1 </strong></span></div></td>
  </tr>
  <tr> 
    <td colspan="4" align="justify" style="font-family: 'arial';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text"><strong>------------------------------KESEPAKATAN SEWA MENYEWA</strong></span></div></td>
  </tr>
  <tr> 
    <td colspan="4" align="justify" style="font-family: 'arial';font-size: 10pt;line-height:2"><div class="spacefill"><div class="spacefill-dots"></div><span class="spacefill-text">Pemilik dengan ini setuju untuk menyewakan dan Penyewa dengan ini setuju untuk menyewa sesuai dengan ketentuan Sewa Menyewa ini, ruang sewa sebagaimana dimaksud dalam Pasal 2.1. dan 2.2. Perjanjian Sewa Menyewa ini, berikut dengan peralatan tetap (“fixtures”), perlengkapan dan tambahannya yang dibangun, ditanam atau dipasang di dalamnya oleh Pemilik, baik atas biaya Pemilik atau Penyewa (selanjutnya disebut “<strong>Ruang Sewa</strong>”), yang akan digunakan oleh Penyewa, sebagai penyewa, untuk selama jangka waktu sebagaimana tersebut dalam Pasal 2.3 Perjanjian Sewa Menyewa ini, beserta hak Penyewa untuk menggunakan secara bersama sama dengan Pemilik dan para penyewa dan penghuni lainnya di Mal serta setiap pihak manapun juga yang diwenangkan atau diijinkan oleh Pemilik, seluruh area di Mal terhadap mana Pemilik mengijinkan mereka untuk mendapatkan akses, termasuk pintu masuk Mal, “lobby”, kamar kecil, koridor, lorong, tangga, tempat menurunkan barang dan lift (seluruh area Mal, diluar bagian yang telah disewakan atau yang akan disewakan oleh Pemilik atau yang digunakan oleh Pemilik atau pihak yang bertindak atas nama Pemilik, selanjutnya secara keseluruhan disebut “<strong>Area Umum</strong>”).</span></div></td>
  </tr>
   
</table>
 
   
 	 
 </table>	 
 
 
 
 <?php } } ?>
		
</div>
</body>
</html>
