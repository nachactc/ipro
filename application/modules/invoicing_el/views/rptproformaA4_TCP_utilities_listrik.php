<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Utilities</title>

<style>


      page[size="A4"] {
      background:white;
      width:21cm;
      height:29.7cm;
      display:block;
      margin:0 auto;
      margin-bottom:0.1cm;
      box-shadow:0 0 0.5cm rgba(0,0,0,0.5);
      }

      @media print {
      body,page[size="A4"] {
      margin:0;
      box-shadow:0;
      }
      }

      td {
      font-family:Arial,Helvetica,sans-serif;
      font-size:12px;
      }
      
      td1 {
      
      border-right:2px solid #fff;      
      }
      
      
</style>
</head>

<body>


<?php

//print_r($result); exit;
foreach($result as $invoice) {
	foreach($invoice as $row ) {
	$ppn =0;
	$jumlah =0;	
	$total =0;
	$tax = $row->utilitieslistrikdetil_tax;
	$jumlah = $row->utilitieslistrikdetil_jumlah;
	$ppn = $jumlah * $tax / 100;
	$total =$jumlah + $ppn;
//print_r($row); 
		
		
?> 


<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
  <tr>
  <td width="4%">&nbsp;</td>
    <td width="96%">
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%" >
      <tr>
        <td align="left" valign="top" dir="ltr">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td></td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top" dir="ltr">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td></td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top" dir="ltr">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td></td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top" dir="ltr">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td></td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td width="12%" align="left" valign="top" dir="ltr">
          <img border="0" src="<?php echo base_url('assets/img/tcp.jpg');?>" width="116" height="120"></td>
        <td width="25%" align="left" valign="top"><font size="4"><b><?php echo $region['region_namereport']; ?></b></font><br>     
          <?php echo $region['region_address'];?><br>
          Phone : <?php echo $region['region_telp'];?><br>    
          Fax : <?php echo $region['region_fax'];?><br>                    
          </td>      
        <td width="36%"></td>  
        <td width="27%" align="right">
          <img border="0" src="<?php echo base_url('assets/img/pln.jpg');?>" width="50" height="70">        
          </td>
      </tr>
      <tr>
        <td colspan="4" align="center" valign="top" dir="ltr"><font size="4"><b>REKENING LISTRIK</b></font></td>
      </tr>
      </table>
      
	<br>
     <table cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td>
        <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
          <tr>
            <td width="14%" style="border-top: 1px solid #000; border-left: 1px solid #000;">Nama Tenant</td>
            <td width="2%" style="border-top: 1px solid #000">:</td>
            <td width="24%" style="border-top: 1px solid #000; border-right: 1px solid #000"><?php echo $row->rekananshipping_name; ?></td>
            <td width="41%" style="border-top: 1px solid #000;"> Bulan : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("F", strtotime($row->utilitieslistrik_date)); ?></td>
            <td width="19%" style="border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000;">Tahun :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo date('Y', strtotime($row->utilitieslistrik_date)); ?></td>
          </tr>
          <tr>
            <td style="border-left: 1px solid #000; border-bottom: 1px solid #000;">Nomor Lokasi</td>
            <td style="border-bottom: 1px solid #000;">:</td>
            <td style="border-bottom: 1px solid #000;; border-right: 1px solid #000"><?php echo $row->utilitieslistrikdetil_unit; ?></td>
            <td style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td style="border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;">&nbsp;</td>
          </tr>
          <tr>
            <td style="border-left: 1px solid #000;">Faktor Meter</td>
            <td>:</td>
            <td align="left" style ="border-right: 1px solid #000"><?php echo $row->utilitieslistrikdetil_faktor; ?></td>
            <td align="left"><b>Tarif (Rp./kWh)</b></td>
            <td align="left"  style="border-right: 1px solid #000;">&nbsp;</td>
          </tr>
          <tr>
            <td style="border-left: 1px solid #000;">Daya Terpasang (kVa)</td>
            <td>:</td>
            <td align="left" style="border-right: 1px solid #000;"><?php echo $row->rekananutilitieslistrik_kva; ?></td>
            <td align="left">LWBP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($row->utilitieslistrikdetil_tariflwbp,0); ?></td>
            <td align="left" style="border-right: 1px solid #000;">&nbsp;</td>
          </tr>    
          <tr>
            <td style="border-left: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>
            <td style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;">&nbsp;</td>
            <td style="border-bottom: 1px solid #000;">WBP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($row->utilitieslistrikdetil_tarifwbp,0); ?></td>
            <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;">&nbsp;</td>
          </tr>                         
        </table>
        </td>
      </tr>
    </table>
    
     

    <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%"> 
          <tr>
            <td colspan="2" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><p><strong>Stand Meter</strong></p></td>
            <td width="30%" align="left" style="border-bottom: 1px solid #000;"><strong>Pemakaian kWh :</strong></td>
            <td width="24%" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;"><strong>Rincian Tagihan (Rp)</strong></td>
            <td width="3%" align="left" style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td width="18%" align="left" style="border-right: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>            
          </tr>       
          <tr>
            <td width="13%" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><strong>Awal</strong></td>
            <td width="12%" align="center" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><strong>Akhir</strong></td>
            <td width="30%" align="left">&nbsp;</td>
            <td width="24%" align="left" style="border-left: 1px solid #000;">Biaya Pemakaian LWBP</td>
            <td width="3%" align="left">:</td>
            <td width="18%" align="right" style="border-right: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_biayalwbp,0); ?></td>            
          </tr>   
          <tr>
            <td width="13%" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_standawal,0); ?></td>
            <td width="12%" align="center" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_akhir,0); ?></td>
            <td width="30%" align="left">LWBP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($row->utilitieslistrikdetil_pemakaianlwbp,2); ?></td>
            <td width="24%" align="left" style="border-left: 1px solid #000;">Biaya Pemakaian WBP</td>
            <td width="3%" align="left">:</td>
            <td width="18%" align="right" style="border-right: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_biayawbp,0); ?></td>            
          </tr>   
          <tr>
            <td colspan="2" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;">LWBP</td>
            <td width="30%" align="left">WBP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($row->utilitieslistrikdetil_pemakaianwbp,2); ?></td>
            <td width="24%" align="left" style="border-left: 1px solid #000;">Biaya BPJU</td>
            <td width="3%" align="left">:</td>
            <td width="18%" align="right" style="border-right: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_bpju,0); ?></td>            
          </tr> 
          <tr>
            <td width="13%" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_standawallwbp,0); ?></td>
            <td width="12%" align="center" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_standakhirlwbp,0); ?></td>
            <td width="30%" align="left">&nbsp;</td>
            <td width="24%" align="left" style="border-left: 1px solid #000;">Administrasi</td>
            <td width="3%" align="left">:</td>
            <td width="18%" align="right" style="border-right: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_administrasi,0); ?></td>            
          </tr> 
          <tr>
            <td colspan="2" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;">WBP</td>
            <td width="30%" align="left">&nbsp;</td>
            <td width="24%" align="left" style="border-left: 1px solid #000;">Pemeliharaan</td>
            <td width="3%" align="left">:</td>
            <td width="18%" align="right" style="border-right: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_pemeliharaan,0); ?></td>            
          </tr>           
          <tr>
            <td width="13%" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_standawalwbp,0); ?></td>
            <td width="12%" align="center" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_standakhirwbp,0); ?></td>
            <td width="30%" align="left">&nbsp;</td>
            <td width="24%" align="left" style="border-left: 1px solid #000;">Denda</td>
            <td width="3%" align="left">:</td>
            <td width="18%" align="right" style="border-right: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_denda,0); ?></td>            
          </tr>   
          <tr>
            <td align="left" style="border-left: 1px solid #000;">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left" style="border-bottom: 1px solid #000;border-left: 1px solid #000;">PPN</td>
            <td align="left" style="border-bottom: 1px solid #000;">:</td>
            <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><span style="border-right: 1px solid #000;"><?php echo number_format($ppn,0); ?></span></td>
          </tr>
          <tr>
            <td width="13%" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>
            <td width="12%" align="left" style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td width="30%" align="left" style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td width="24%" align="left" style="border-bottom: 1px solid #000;"><strong>Jumlah Yang Harus dibayar</strong></td>
            <td width="3%" align="left" style="border-bottom: 1px solid #000;"><strong>Rp.</strong></td>
            <td width="18%" align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><strong><p><?php echo number_format($total,0); ?></p></strong></td>            
          </tr>
          <tr>
            <td align="left" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><strong><em>Terbilang :</em></strong></td>
            <td colspan="5" align="left" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><strong><em><?php echo number_to_wordsnorp(round($row->utilitieslistrikdetil_jumlah,0));?> Rupiah</em></strong></td>
          </tr>                                     
    </table>
<table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
          <tr>
            <td width="14%" >&nbsp;</td>
            <td width="2%" >&nbsp;</td>
            <td width="24%" >&nbsp;</td>
            <td width="21%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="39%"></span></td>
        </tr>
          <tr>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
          </tr>            
          <tr>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
          </tr>                                           
      </table>
	</td>
  </tr>
</table>


 <?php		
	}}
?> 

</body>
</html>