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
body {font-family: 'arial';font-size: 8pt}
@page { margin-left:2cm; margin-right:1.5cm; margin-top:2.5cm;margin-bottom:0.5cm;size:8.27in 11.69in;}
</style>
</head>
<body>
<table width="800" border="0">
  <tr>
    <td width="626" align="center"><p>Apendik II</p>
    <p>Jadwal Pembayaran</p>
    <p>TRANSMART  ............. </p>
    <p>.............(nama brand) </p></td>
  </tr>
</table>
<p>&nbsp;</p>
 <?php      

    if(isset($result)){
      $pasunitname = '';
      $pasunitsqm = 0;
      foreach($vunit as $rowunit){ 
        $pasunitname .= $rowunit->unit_name. '&'; 
        $pasunitsqm   = $rowunit->unit_sqm+$pasunitsqm;        
      }
    }
    $vunitname = trim($pasunitname, "&");
    $vunitsqm =$pasunitsqm;

 if(isset($result)){
	foreach($result as $row){ ?>  
<table width="800" border="0">
  <!--DWLayoutTable-->
  <tr>
    <td width="162"><b>Nama Pemilik</b></td>    
    <td colspan="3"><?php echo $row->rekanan_name;?></td>    
  </tr>
  <tr>
    <td><b>Ruang Sewa</b></td>
    <td width="106"><?php echo $vunitname;?></td>  
    <td width="21">&nbsp;</td>  
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>Lantai</b></td> 
    <td>......</td>   
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>Area</b></td>    
    <td>&nbsp;</td>
    <td align="right"><?php echo $vunitsqm;?></td>
    <td width="493">/m2</td>    
  </tr> 
  </table>
  <table width="800" border="0">
<?php
    foreach($vhargasewa as $rowsewa){
?>
  <tr>
    <td colspan="2"><b>Uang Sewa per bulan</b></td>
    <td width="23">Rp</td>
    <td width="106" align="right"><?php echo number_format($rowsewa->loodetil_baserent,0);?></td>
    <td width="492">/m2</td>
  </tr>  
<?php
    }
?> 
  </table>  
  <table width="800" border="0">
  <tr>
    <td colspan="2"><b>Biaya Promosi per bulan</b></td>
    <td width="105">......</td>
    <td width="136">/m2</td>
    <td width="41">&nbsp;</td>
    <td width="256">+PPN 10%</td>
    <td width="47">&nbsp;</td>
  </tr>  
  <tr>
    <td width="171"><b>Total Uang Sewa</b></td>
    <td width="14">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
  <tr>
    <td colspan="2"><b>Dibayarkan sebagai berikut</b></td>
    <td align="right">20%</td>
    <td>Uang Muka</td>
  	<td>.....</td>
	  <td><!--DWLayoutEmptyCell-->&nbsp;</td>
      <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">80%</td>
    <td>dibayarkan dalam</td>
	  <td>.....</td>
	  <td colspan="2">(..) kali angsuran bulanan di muka yang sama</td>
  </tr>
  <tr>
    <td colspan="2"><b>Biaya Pelayanan perbulan</b></td>
    <td>.....</td>
    <td>/m2</td>
    <td>&nbsp;</td>
    <td>+PPN 10%</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>Simpanan Jaminan</b></td>
    <td>&nbsp;</td>
    <td>.....</td>
    <td colspan="3">..bulan uang sewa dan biaya pelayanan (wajib dibayarkan)</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
  <tr>
    <td colspan="2">Tabel Arus Kas</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="justify"><b>Rent Commencement Date</b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><b>Skedul ini akan ditinjau setiap tahun</b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width ="800" border ="1">
  <tr>
    <th>&nbsp;</th>
<?php 
 $i =0;

  foreach($collabel as $col_title){    
?>
    <th><?php echo $col_title;?></th> 
<?php 
  }
?>
    <th>Arus Kas (IDR)</th>
  </tr>
<?php
  foreach($rowlabel as $row_title){
?>    
    <tr>
      <th><?php echo $row_title;?></th>
<?php
    foreach($collabel as $col_title){
      $i = $col_title.'_'.$row_title;     

      if (isset($zcross_tab[$i])){        
?>
        <td align="right"><?php echo number_format($zcross_tab[$i],0);?></td>
<?php     
      }else{
?>      
        <td align="right">&nbsp;</td>      
<?php      
      }
    }
?>      <td style="font-weight:bold" align="right"><?php echo number_format($xtotal[$row_title],0);?></td>  
    </tr>
<?php  
  }
?>
    <tr style="font-weight: bold" align="right"><td>Sub Total</td>
<?php
    $grand_total = 0;

    foreach($collabel as $col_title){
        $grand_total += $ytotal[$col_title];
?>
        <td align="right"><?php echo number_format($ytotal[$col_title],0);?></td>
<?php    
    }
?>      
        <td align="right"><?php echo number_format($grand_total,0);?></td>    
    </tr>
</table>   
<?php }}?> 
<div style="page-break-after: always; width:400" id="hal1">&nbsp;</div>

</body>
</html>