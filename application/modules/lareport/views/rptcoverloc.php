<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
@font-face {
    font-family: 'tahoma'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/tahoma.ttf');?>'); 
 src: url('<?php echo base_url('assets/css/loo/tahomabd.ttf');?>'); 	
}
body {font-family: 'tahoma';font-size: 18pt}
@page { margin-left:4cm; margin-right:2.5cm; margin-top:1.5cm;margin-bottom:0.5cm;size:8.27in 11.69in;}

@font-face {
    font-family: 'arial'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/arial.ttf');?>'); /*URL to font*/
}
</style>
</head>
<body>
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
<div style="width:653px;height:100px;border:1px solid #000;">
<table width="653" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="41">&nbsp;</td>
    <td width="562" height="5px">&nbsp;</td>
    <td width="50">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt"><p><strong>AMENDMENT #1 TO THE LEASE AGREEMENT /</strong></p></td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt"><p>AMANDEMEN  #1 PERJANJIAN SEWA<strong></strong></p></td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt"><p align="center"><strong>BETWEEN</strong>/ANTARA<strong></strong></p></td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
  </tr>
   <tr>
     <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt"><b><?php echo $row->region_namereport;?> </b></td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
   </tr>
   <tr>
     <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt"><p align="center">AND/DAN<strong> </strong></p></td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
   </tr>
   <tr>
     <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt"><b><?php echo $row->rekanan_name;?></b></td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
   </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt"><b><?php echo $row->rekananshipping_name;?></b></td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt" height="5">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt; border-top:1px solid">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt"><b>NO. <?php echo $vnolah;?></b></td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt; border-bottom:1px solid" >&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 18pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt"><p align="center">AMENDMENT LEASE AGREEMENT <strong>– </strong>PERUBAHAN PERJANJIAN SEWA<strong></strong></p></td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
  </tr>
    <tr>
      <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
      <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
      <td align="center" style="font-family: 'tahoma';font-size: 12pt">&nbsp;</td>
    </tr>
</table>
</div>

<?php }}?> 
</body>
</html>