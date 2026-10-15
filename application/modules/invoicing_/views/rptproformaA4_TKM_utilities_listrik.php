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
	$tagihan =0;
	$jumlah =0;	
	$total =0;
	$materai =0;
	$denda =0;
	$bpju =0;
	$bpju_amount =0;
	$subtotal1 =0;
	$tax = $row->utilitieslistrikdetil_tax;
	$jumlah = $row->utilitieslistrikdetil_jumlah;
	$materai = $row->utilitieslistrikdetil_materai;
	$denda = $row->utilitieslistrikdetil_denda;
	$bpju = $row->utilitieslistrikdetil_bpju;
	$subtotal1 = $row->Utilitieslistrikdetil_subtotal1;
	$tagihan = $row->utilitieslistrikdetil_tagihan;
	if ($bpju > 0) {
		$bpju_amount = $subtotal1 * $bpju /100;
	}
	$ppn = $tagihan * $tax / 100;

   $subtotal2 = $subtotal1 + $bpju_amount;
   $biaya = ($row->utilitieslistrikdetil_biaya/100) * $subtotal2;

	$total = $subtotal1 + $bpju_amount + $biaya + $ppn + $materai + $denda;
	//$total =$jumlah + $ppn + $materai + $denda;
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
          <img border="0" src="<?php echo base_url('assets/img/tkm.jpg');?>" width="116" height="120"></td>
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
            <td width="41%" style="border-top: 1px solid #000;">Periode Pemakaian :</td>
            <td width="19%" style="border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000;">Jatuh Tempo :</td>
          </tr>
          <tr>
            <td style="border-left: 1px solid #000; border-bottom: 1px solid #000;">Nomor Lokasi</td>
            <td style="border-bottom: 1px solid #000;">:</td>
            <td style="border-bottom: 1px solid #000;; border-right: 1px solid #000"><?php echo $row->utilitieslistrikdetil_unit; ?></td>
            <td style="border-bottom: 1px solid #000;"><?php echo $row->utilitieslistrik_descr; ?></td>
            <td style="border-bottom: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;"> <?php echo date('d F Y', strtotime($row->Utilitieslistrik_duedate)); ?></td>
          </tr>
          <tr>
            <td style="border-left: 1px solid #000;">Faktor Meter</td>
            <td>:</td>
            <td align="left" style ="border-right: 1px solid #000"><?php echo $row->utilitieslistrikdetil_faktor; ?></td>
            <td align="left">Tarif Listrik PLN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo number_format($row->utilitieslistrikdetil_tarifwbp,0); ?> </td>
            <td align="left"  style="border-right: 1px solid #000;">&nbsp;</td>
          </tr>
          <tr>
            <td style="border-left: 1px solid #000;">Daya Terpasang (kVa)</td>
            <td>:</td>
            <td align="left" style="border-right: 1px solid #000;"><?php echo $row->rekananutilitieslistrik_kva; ?></td>
            <td align="left">Tarif Listrik Genset &nbsp;&nbsp;&nbsp;: <?php echo number_format($row->utilitieslistrikdetil_tariflwbp,0); ?></td>
            <td align="left" style="border-right: 1px solid #000;">&nbsp;</td>
          </tr>    
          <tr>
            <td style="border-left: 1px solid #000;border-bottom: 1px solid #000;">Jam Nyala Minimal</td>
            <td style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;">40</td>
            <td style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;">&nbsp;</td>
          </tr>                         
        </table>
        </td>
      </tr>
    </table>
    
     

    <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%"> 
          <tr>
            <td colspan="2" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><p><strong>Stand Meter</strong></p></td>
            <td width="30%" align="left" style="border-bottom: 1px solid #000;"><strong>Jumlah Pemakaian</strong></td>
            <td width="24%" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;"><strong>Rincian Tagihan (Rp)</strong></td>
            <td width="3%" align="left" style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td width="18%" align="left" style="border-right: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>            
          </tr>       
          <tr>
            <td width="13%" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><strong>Awal</strong></td>
            <td width="12%" align="center" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><strong>Akhir</strong></td>
            <td width="30%" align="left">&nbsp;</td>
            <td width="24%" align="left" style="border-left: 1px solid #000;">Biaya Pemakaian PLN</td>
            <td width="3%" align="left">:</td>
            <td width="18%" align="right" style="border-right: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_biayapln,0); ?></td>            
          </tr>   
          <tr>
            <td width="13%" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_standawal,2); ?></td>
            <td width="12%" align="center" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_akhir,2); ?></td>
            <td width="30%" align="left">PLN &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo number_format($row->utilitieslistrikdetil_pemakaiankwhpln,2); ?></td>
            <td width="24%" align="left" style="border-left: 1px solid #000;">Biaya Pemakaian Genset</td>
            <td width="3%" align="left">:</td>
            <td width="18%" align="right" style="border-right: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_biayagenset,0); ?></td>            
          </tr>   
          <tr>
            <td align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;">Selisih</td>
            <td align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;">Jumlah Jam Nyala</td>
            <td width="30%" align="left">Genset &nbsp;&nbsp;&nbsp;: <?php echo number_format($row->utilitieslistrikdetil_pemakaiankwhgenset,2); ?></td>
            <td width="24%" align="left" style="border-left: 1px solid #000;">Biaya BPJU <?php echo number_format($row->utilitieslistrikdetil_bpju,0); ?>%</td>
            <td width="3%" align="left">:</td>
            <td width="18%" align="right" style="border-right: 1px solid #000;"><?php echo number_format($bpju_amount,0); ?></td>            
          </tr> 
          <tr>
            <td width="13%" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_selisih,0); ?></td>
            <td width="12%" align="center" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_jamnyala,0); ?></td>
            <td width="30%" align="left">&nbsp;</td>
            <td width="24%" align="left" style="border-left: 1px solid #000;">PPN</td>
            <td width="3%" align="left">:</td>
            <td width="18%" align="right" style="border-right: 1px solid #000;"><?php echo number_format($ppn,0); ?></td>            
          </tr> 
          <tr>
            <td colspan="2" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>
            <td width="30%" align="left">&nbsp;</td>
            <td width="24%" align="left" style="border-left: 1px solid #000;">Administrasi</td>
            <td width="3%" align="left">:</td>
            <td width="18%" align="right" style="border-right: 1px solid #000;"><?=number_format($biaya,0)?></td>
          </tr> 
          <tr>
            <td colspan="2" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>
            <td width="30%" align="left">&nbsp;</td>
            <td width="24%" align="left" style="border-left: 1px solid #000;">Materai</td>
            <td width="3%" align="left">:</td>
            <td width="18%" align="right" style="border-right: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_materai,0); ?></td>            
          </tr>           
          <tr>
            <td align="left" style="border-left: 1px solid #000;">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left" style="border-bottom: 1px solid #000;border-left: 1px solid #000;">Denda</td>
            <td align="left" style="border-bottom: 1px solid #000;">:</td>
            <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><span style="border-right: 1px solid #000;"><?php echo number_format($row->utilitieslistrikdetil_denda,0); ?></span></td>
          </tr>
          <tr>
            <td width="13%" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>
            <td width="12%" align="left" style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td width="30%" align="left" style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td width="24%" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;"><strong>Jumlah Yang Harus dibayar</strong></td>
            <td width="3%" align="left" style="border-bottom: 1px solid #000;"><strong>Rp.</strong></td>
            <td width="18%" align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><strong><p><?php echo number_format($total,0); ?></p></strong></td>            
          </tr>
          <tr>
            <td align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;"><strong><em>Terbilang :</em></strong></td>
            <td colspan="5" align="left" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><strong><em><?php echo number_to_wordsnorp(round($total,0));?> Rupiah</em></strong></td>
          </tr>
          <tr>
            <td colspan="6" align="left" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><em><strong>Rekening Pembayaran Utilities : <?php echo $row->schedulepaymentdetil_va; ?> Bank Mega KCP Makassar Tanjung Bunga a/n PT Trans Kalla Makassar</strong></em></td>
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