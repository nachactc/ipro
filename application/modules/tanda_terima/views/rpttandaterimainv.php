<?php  
  if ($button == 'EXCEL')
  {

	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename= tanda_terima_invoice.xls");
  } 
 ?>
<title>TANDA TERIMA</title>
 <style>
@font-face {
    font-family: 'arial'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/arial.ttf');?>'); /*URL to font*/
	src: url('<?php echo base_url('assets/css/loo/arialbd.ttf');?>'); /*URL to font*/
}
body {font-family: 'arial';font-size: 12pt}
@page { margin-left:3.5cm; margin-right:3cm; margin-top:3cm;margin-bottom:1cm;size:8.27in 11.69in;}
table, tr, td {
  font-family: 'arial';font-size: 14pt;
}

</style>

</head>
<br />

<body>


<p>

</p>
<p>&nbsp;</p>
<?php
$kodedep ='';
$pic ='';
$kodeaccount ='';
$region_name ='';
$region_address ='';
if(isset($result)){
foreach($result as $tanda){
foreach($tanda as $row){		
$kodedep =$row->kodedept;
$pic =$row->pic;
$kodeaccount =$row->kodeaccount;
$region_name =$row->region_namereport;
$region_address =$row->region_address;
$region_telp =$row->region_telp;
$region_ext =$row->ext;
}}}
?>	

<?php
$ket ='';
$inv_type ='';
$no = 0;
$timestamp = time();
$now = date("Y-m-d H:i:s", $timestamp);
if(isset($result)){
foreach($result as $tanda){	
foreach($tanda as $row){
$no = $no + 1;  
$inv_type = $row->invoice_type;
if ($inv_type =='INV')
{
	$ket ='Lembar Invoice dan Faktur Pajak ' . date('d F Y', strtotime($row->invoice_date)) . ' ' . $row->invoice_id;
	}	
else
{
	$ket ='Lembar Proforma Invoice ' . date('d F Y', strtotime($row->invoice_date)) . ' ' . $row->invoice_id;
	} 
?>  
<table width="1295" >
<tr>
  <td><img border="0" src="<?php echo base_url('assets/img/transc4.jpg');?>" width="232" height="87"></td>
  <td  align="left">&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td  align="left">&nbsp;</td>
</tr>
<tr>
  <td width="737"><?php echo $row->region_namereport; ?></td>
  <td width="546"  align="left">KODE DEPT(<?php echo $row->kodedept; ?>)</td>
</tr>
<tr>
  <td><?php echo $row->region_address; ?></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>Telp <?php echo $row->region_telp; ?> Ext. <?php echo $row->ext; ?></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>


 </br>

<table  width="1295" border="0">
  <tr>
    <td colspan="4" style="border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><strong><em>&nbsp;&nbsp;TRANSMITEL ADVINCE</em></strong></td>
  </tr>
  <tr>
    <td style="border-left: 1px solid black;">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td  style="border-right: 1px solid black;"></td>
  </tr>
  <tr>
        <td width="9%" style="border-left: 1px solid black;">&nbsp;&nbsp;To</td>
        <td colspan="2" ><?php echo $row->rekanan_name; ?> (<?php echo $row->rekananshipping_name; ?>)</td>
        <td width="26%"  style="border-right: 1px solid black;"></td>
  </tr>  
  <tr>
        <td width="9%" style="border-left: 1px solid black;"></td>
        <td colspan="2" ><?php echo $row->rekananshipping_address; ?></td>
        <td width="26%"  style="border-right: 1px solid black;"></td>
  </tr>   
  <tr>
    <td style="border-left: 1px solid black;">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td  style="border-right: 1px solid black;"></td>
  </tr>
  <tr>
        <td width="9%" style="border-left: 1px solid black;">&nbsp;&nbsp;Attn.</td>
        <td colspan="2" ><?php echo $row->contact_name; ?></td>
        <td width="26%"  style="border-right: 1px solid black;"></td>
  </tr>   
  <tr>
        <td width="9%" style="border-left: 1px solid black;"></td>
        <td colspan="2" ><?php echo $row->contact_telp; ?></td>
        <td width="26%"  style="border-right: 1px solid black;"></td>
  </tr>   
  <tr>
    <td colspan="3" style="border-left: 1px solid black;">&nbsp;</td>
    <td  style="border-right: 1px solid black;"></td>
  </tr>
  <tr>
        <td colspan="3" style="border-left: 1px solid black;">&nbsp;&nbsp;Under cover of this transmittal we are forwarding you the followings:</td>
        <td width="26%"  style="border-right: 1px solid black;"></td>
  </tr>  
  <tr>
        <td width="9%" style="border-left: 1px solid black;"></td>
        <td colspan="2" ><?php echo $ket; ?></td>
        <td width="26%"  style="border-right: 1px solid black;"></td>
  </tr>  
  <tr>
    <td style="border-left: 1px solid black;">&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td  style="border-right: 1px solid black;"></td>
  </tr>
  <tr>
        <td width="9%" style="border-left: 1px solid black;">&nbsp;&nbsp;Send By</td>
        <td width="49%" >:  <?php echo $row->region_senderinv; ?></td>
        <td width="16%" >Received By :</td>
        <td width="26%"  style="border-right: 1px solid black;"></td>
  </tr>
  <tr>
    <td style="border-left: 1px solid black;"></td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td  style="border-right: 1px solid black;"></td>
  </tr>
  <tr>
    <td style="border-left: 1px solid black;">&nbsp;&nbsp;Date</td>
    <td >:  <?php echo date("d M Y", strtotime($row->sent_date)); ?></td>
    <td >Date :</td>
    <td  style="border-right: 1px solid black;"></td>
  </tr>
  <tr>
    <td style="border-left: 1px solid black;border-bottom: 1px solid black;"></td>
    <td colspan="2" style="border-bottom: 1px solid black;">&nbsp;</td>
    <td  style="border-right: 1px solid black;border-bottom: 1px solid black;"></td>
  </tr>
  <tr>
    <td colspan="4">If you received the document, please scan and email to <?php echo $row->region_senderinv; ?> (<?php echo $row->region_senderemail; ?>)</td>
  </tr>  

  

</table>


<table width="1295" >

<tr>
  <td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>
<?php
 }}}
?>
<br>
</body>

</html>
