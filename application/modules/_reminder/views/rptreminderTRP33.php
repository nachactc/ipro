<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>REMINDER</title>
<style>
@font-face {
    font-family: 'arial'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/arial.ttf');?>'); /*URL to font*/
	src: url('<?php echo base_url('assets/css/loo/arialbd.ttf');?>'); /*URL to font*/
}
body {font-family: 'arial';font-size: 12pt}
@page { margin-left:3.5cm; margin-right:3cm; margin-top:3cm;margin-bottom:1cm;size:8.27in 11.69in;}
table, tr, td {
  font-family: 'arial';font-size: 12pt;
}

</style>
</head>
<body>

<p>&nbsp;</p>
<htmlpagefooter name="myfooter">
<div style="border-top: 0px solid #000000; font-size: 8pt; text-align: left; padding-top: 3mm; ">
  <em>issued by system</em> </div>
</htmlpagefooter>
<sethtmlpagefooter name="myfooter" value="on" />
 <?php 
$totalOR =0;
//if(isset($resultOR)){
//foreach($resultOR as $OR) {
//	foreach($OR as $rowOR ) {
//		$totalOR = $rowOR->OR_amount;
//	}
//}}

if(isset($result)){
      $timestamp = time();
      $now = date("Y-m-d H:i:s", $timestamp);	  						
$tanggal ='';
$invoice='';
$faktur='';
$whtamount=0;
$totalamount=0;
$totalidr=0;
$jurnal_id='';
$jurnaldetil_id='';
foreach($result as $invoice) {
	foreach($invoice as $row ) {  
	$jurnal_id = $row->jurnal_id . $row->jurnal_descr;
	$invoice=substr($row->faktur_id,0,3);
	$totalamount = $totalamount + $row->amount;



	if ($invoice =='INV'){
		$whtamount = $row->amount * 10 /100;
		$totalamount = $totalamount +  $whtamount;	
		}
		
	}}
		
	foreach($jurnal as $jurnaldetil) {
		$faktur=substr($jurnaldetil['faktur_id'],0,3);
		//$jurnaldetil_id=$jurnaldetil['jurnal_id'].$jurnaldetil['jurnal_descr'];
			//if ($jurnal_id == $jurnaldetil_id){
				$totalidr = $totalidr + $jurnaldetil['amount'];
				if ($faktur =='INV'){
					$whtamount = $jurnaldetil['amount'] * 10 /100;
					$totalidr = $totalidr +  $whtamount;	
					}				
			//}	
		}
	
	
	if ($grouptenant_id =='personal'){
		$tanggal ='';
	}
	else {
		$tanggal ='tanggal ' . date('d F Y', strtotime($tglla));
		
		}
?>
<table width="753" border="0">
  <tr>
    <td width="312" align="left">No Reff. <?php echo $no_SP;?></td>
    <td width="312" align="right"><b>(<?php echo $reminder;?>)</b></td>
  </tr>
  <tr>
    <td width="626" colspan="2">Depok, <?php echo $new_date = date('d F Y', strtotime($tanggal_SP));?></td>
  </tr>
  <tr>
    <td width="626" colspan="2" align="right"><strong><?php echo $rekananshipping_name;?></strong></td>
  </tr>  
  <tr>
    <td width="626" colspan="2" align="right"><strong><?php echo $shopunit;?></strong></td>
  </tr>  
</table>
<br />
<table width="753" border="0">
  <tr>
    <td width="100">Kepada Yth.</td>
    <td width="100">&nbsp;</td>
    <td width="100">&nbsp;</td>
    <td width="16">&nbsp;</td>
    <td width="251" align="right">&nbsp;</td>
    <td align="right"></td>
  </tr>
 </table>
 <table width="753" border="0">
  <tr>
    <td><b><?php echo $rekanan_namereport;?></b></td>
    <td width="368" align="right">&nbsp;</td>
  </tr>  
  <tr>
    <td colspan="2"><?php echo $rekananshipping_address;?></td>
   </tr>
 </table>
 <table width="753" border="0">  
  <tr>
    <td valign="top" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>   
  <tr>
    <td align="center"><div align="center"><strong><u>PEMBERITAHUAN KETERLAMBATAN  PEMBAYARAN</u></strong></div></td>
  </tr>
  <tr>
    <td height="60">Dengan Hormat,</td>
  </tr>
  <tr>
    <td  align="justify"><p>Merujuk  kepada (a) Perjanjian Sewa  Menyewa No <?php echo $nola;?>  antara <?php echo $region_namereport;?> dan <?php echo $rekanan_namereport;?>, (b) Surat Peringatan I No <?php echo $no_SP_old;?> tanggal <?php echo date('d F Y', strtotime($tanggal_SP_old));?>, dengan ini disampaikan bahwa berdasarkan Laporan Keuangan kami,  terdapat tunggakan pembayaran sebesar <strong>Rp. </strong><strong><?php echo number_format($totalamount,0);?></strong><strong>,-</strong>   sampai dengan Tanggal <?php echo $new_date = date('d F Y', strtotime($tanggal_SP));?>,  keseluruhan tunggakan pembayaran terperinci sebagai terlampir.</p>
      <p>&nbsp;</p>
    <p>Ada pun total Outstanding yang sudah jatuh tempo adalah sebesar <strong>Rp <?php echo number_format($totalidr,0);?>**</strong></p>
    <p>&nbsp;</p></td>
  </tr>
  </table>
  
  <table width="753" border="0">
    <tr>
      <td  align="justify"><p>Sehubungan dengan hal  tersebut di atas,  dengan ini Bapak / Ibu diminta agar dapat segera menyelesaikan tunggakan <strong><em>dalam  jangka waktu </em></strong><strong><em>kerja  </em></strong><strong><em>(3) hari  terhitung tanggal surat ini dibuat atau sebelum tanggal (<?php echo date('d F Y', strtotime($tanggal_SP_new));?>).</em></strong></p>
      <p>&nbsp;</p></td>
    <tr>
    <td  align="justify"><p>Oleh karena telah terbit Surat Peringatan III  ini, maka Management PT. Trans Retail Indonesia berhak melakukan pemutusan  fasilitas utilitas (listrik, air dan gas) sampai dengan dilunasinya pembayaran  tertunggak dan Management PT. Trans Retail Indonesia tidak bertanggung jawab  atas segala kerusakan yang timbul akibat dari pemutusan fasilitas utilitas  tersebut.</p>
<p>&nbsp;</p></td>        
   <tr>
      <td align="justify"><p>Untuk informasi lebih lanjut dan atau  rekonsiliasi tunggakan tersebut, dapat menghubungi kami telp/wa <?php echo $usersp_name;?> (<?php echo $usersp_email;?>) <?php echo $usersp_telp;?>.</p>
      <p>Mohon  surat ini diabaikan apabila pihak Bapak/Ibu telah menyelesaikan tunggakan  tersebut diatas. </p></td>
   <tr>
     <td align="justify">&nbsp;</td>
</table>
 
<table width="753" border="0">
   <tr>
     <td align="justify"><p>Demikian yang dapat kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p></td>
   </tr>
      <tr>
     <td colspan="5" align="justify">&nbsp;</td>
   </tr>
</table>

<table width="753" border="0">
  <tr>
    <td width="355">Hormat kami,</td>
    <td width="37">&nbsp;</td>
    <td width="140">&nbsp;</td>
    <td width="203">&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $region_namereport;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><b></b></td>
  </tr>
  <tr>
    <td><img border="0" src="<?php echo base_url('assets/img/ttdsp.png');?>" width="116" height="124"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <tr>
    <td><?php echo $nameOS;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $positionOS;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p><em>CC:Finance&amp;Acc/TR/Leasing/Legal</em><u></u></p></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<br>
<br>
<br>
<br>
  <table width="747" border="1">
  <tr>
    <td width="45" align="center"><strong>No</strong></td>  	
     <td width="191" align="center"><strong>Book Date</strong></td>
     <td width="353" align="center"><strong>Descr</strong></td>
     <td width="130" align="center"><strong>Amount</strong></td>     
  </tr>
  
<?php
$inv='';
$wht=0;
$total=0;
$no=0;
$jurnal_id='';
$jurnaldetil_id='';
$jurnal_descr='';
$jurnaldetil_descr='';
$bintang='';
$idUidX = explode("-",$jurnal_id2);
$jmlX=count($idUidX)-1;

$idUidX2 = explode("-",$jurnal_descr2);
$jmlX2=count($idUidX2)-1;

// print_r($result);
// print_r($idUidX2);
// echo $jmlX2;
foreach($result as $invoice) {
	foreach($invoice as $row ) {  
	$jurnal_id=$row->jurnal_id . $row->jurnal_descr;
	$jurnal_descr=$row->jurnal_descr;
	$inv=substr($row->faktur_id,0,3);
	$total = $total + $row->amount;
	$no = $no + 1;
	$bintang='';
	$jurnaldetil_id='';
	
	  // for($i = 0, $size = count($idUidX); $i < $size; ++$i) {
		// $jurnaldetil_id = $idUidX[$i];
		// $jurnaldetil_descr = $idUidX2[$i];
		// echo $jurnaldetil_descr;
		// if ($jurnal_descr == $jurnaldetil_descr){
			// $bintang='**';
			// $jurnal_descr=$row->jurnal_descr;
		// }		
		// else
		// {
			// $jurnal_descr=$row->jurnal_descr;	
			// $bintang='';
		// }
		
	  // }	
	 //echo print_r($jurnal[0]['jurnal_descr']);
	 //echo print_r($jurnal);
	if(isset($jurnal)){		
	foreach($jurnal as $jurnaldetil) {
		$jurnaldetil_descr=$jurnaldetil['jurnal_descr'];
		$jurnaldetil_id=$jurnaldetil['jurnal_id'].$jurnaldetil['jurnal_descr'];
			if ($jurnal_id == $jurnaldetil_id){
				$bintang='**';
				$jurnal_descr=$row->jurnal_descr;
			}	
		}
	}
?>
  
  <tr>
    <td align="center"><?php echo $no;?></td>  	
    <td align="left"><?php echo date('d F Y', strtotime($row->jurnal_bookdate));?><?php echo $bintang;?></td>
    <td><?php echo $jurnal_descr;?></td>
     <td align="right"><?php echo number_format($row->amount,0);?></td>     
  </tr>
    <?php
	if ($inv=='INV'){
		$wht = $row->amount * 10 /100;
		$total = $total +  $wht;	
		$no = $no + 1;
	?>
  <tr>
    <td align="center"><?php echo $no;?></td>  	
    <td align="left"><?php echo date('d F Y', strtotime($row->jurnal_bookdate));?><?php echo $bintang;?></td>
    <td>Witholding Tax</td>
     <td align="right"><?php echo number_format($wht,0);?></td>     
  </tr>    
    <?php }?> 
<?php }}?> 
  <tr>
    <td align="center">&nbsp;</td>
  	<td align="center">&nbsp;</td>
     <td align="center">Total</td>
     <td align="right"><?php echo number_format($total,2);?></td>     
  </tr>
</table>
<div style="border-top: 0px solid #000000; font-size: 8pt; text-align: left; padding-top: 3mm; ">
Note : ** outstanding yang sudah jatuh tempo
</div>
<?php 
}?> 
</body>
</html>