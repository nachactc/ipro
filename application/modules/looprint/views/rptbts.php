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
@page { margin-left:4cm; margin-right:3cm; margin-top:3cm;margin-bottom:0.5cm;size:8.27in 11.69in;}
ol.dd {list-style-type: lower-alpha;}

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
    <td width="371"><b>Kepada Yth,</b></td>
    <td width="372" align="right"><?php echo $row->branch_name;?></td>
  </tr>
  <tr>
    <td><b><?php echo $row->rekananshipping_name;?></b></td>
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
    <td>PIC.<?php echo $row->rekanancontact_name;?></td>
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
    <td colspan="2" align="center"><b>Perihal: Penawaran Perpanjangan Sewa "<?php echo $row->rekananshipping_name;?>" di <?php echo $row->branch_name;?></b></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Dengan Hormat,</td>
  </tr>
  <tr>
    <td colspan="2" align="justify">Bersama ini kami sampaikan Surat Penawaran Perpanjangan Sewa untuk <b><?php echo $row->rekananshipping_name;?></b> dengan ketentuan dan syarat-syarat sebagaimana tersebut dibawah ini.</td>
  </tr>
   <tr>
     <td colspan="2" align="justify">&nbsp;</td>
   </tr>
</table>
<table width="753" border="0">
  <?php echo showTabelbts($row->loo_id);?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="justify">Demikian yang dapat kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.<br /></td>
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
    <td><strong><u>Jozarki Terunajaya </u></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
  </tr>
  <tr>
    <td>Senior GM Mall Management</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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