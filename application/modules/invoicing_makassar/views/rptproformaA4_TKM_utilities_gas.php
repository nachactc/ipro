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
$t_total =0;
//print_r($result); exit;
foreach($result as $invoice) {
	foreach($invoice as $row ) {
		$t_total = $row->utilitiesairgasdetil_total + $row->utilitiesairgasdetil_taxamount;
//print_r($row); 
		
		
?> 


<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="97%">
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
        <td width="12%" align="left" valign="top" dir="ltr">
        <img border="0" src="<?php echo base_url('assets/img/tkm.jpg');?>" width="116" height="120"></td>
        <td width="25%" align="left" valign="top"><font size="4"><b><?php echo $region['region_namereport']; ?></b></font><br>     
        <?php echo $region['region_address'];?><br>
        Phone : <?php echo $region['region_telp'];?><br>    
        Fax : <?php echo $region['region_fax'];?><br>                    
        </td>      
        <td width="36%"></td>  
        <td width="27%" align="right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center" valign="top" dir="ltr">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center" valign="top" dir="ltr">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center" valign="top" dir="ltr"><font size="4"><b>REKENING PEMAKAIAN GAS</b></font></td>
        </tr>
      </table>
      
	<br>
     <table cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td>
        <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
          <tr>
            <td width="14%" style="border-top: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;">Nama Tenant</td>
            <td width="2%" style="border-top: 1px solid #000;border-bottom: 1px solid #000;">:</td>
            <td width="24%"  style="border-top: 1px solid #000;border-bottom: 1px solid #000;"><?php echo $row->rekananshipping_name; ?></td>
            <td width="37%" align="center" style="border-top: 1px solid #000;border-left: 1px solid #000;">Periode Pemakaian</td>
            <td width="23%" align="center" style="border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;">Jatuh Tempo</td>
          </tr>
          <tr>
            <td style="border-left: 1px solid #000;border-bottom: 1px solid #000;">Unit</td>
            <td style="border-bottom: 1px solid #000;">:</td>
            <td  style="border-bottom: 1px solid #000;"><?php echo $row->utilitiesairgasdetil_unit; ?></td>
            <td  align="center" style="border-left: 1px solid #000;"><?php echo $row->utilitiesairgas_descr; ?></td>
            <td align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;"><?php echo date('d F Y', strtotime($row->schedulepaymentdetil_duedate)); ?></td>
          </tr>
          <tr>
            <td style="border-left: 1px solid #000;border-bottom: 1px solid #000;">Luas (m2)</td>
            <td style="border-bottom: 1px solid #000;">:</td>
            <td  style="border-bottom: 1px solid #000;"><?php echo $row->utilitiesairgasdetil_space; ?></td>
            <td  style="border-left: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>
            <td style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">&nbsp;</td>
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
    
     

    <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%"> 
          <tr>
            <td colspan="3" align="center" style="border-top: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;"><p><strong>Penunjukan Meter</strong></p></td>
            <td colspan="4" align="center" style="border-top: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;"><strong>Perincian</strong></td>
          </tr>       
          <tr>
            <td width="16%" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;">Awal</td>
            <td width="3%" align="center" style="border-bottom: 1px solid #000;">:</td>
            <td width="14%" align="left" style="border-bottom: 1px solid #000;"><?php echo $row->utilitiesairgasdetil_standawal; ?></td>
            <td width="13%" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><strong>Harga / m3</strong></td>
            <td colspan="2" align="center" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><strong>Pemakaian</strong></td>
            <td width="18%" align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><strong>Harga Gas</strong></td>            
          </tr>   
          <tr>
            <td width="16%" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;">Akhir</td>
            <td width="3%" align="center" style="border-bottom: 1px solid #000;">:</td>
            <td width="14%" align="left" style="border-bottom: 1px solid #000;"><?php echo $row->utilitiesairgasdetil_standakhir; ?></td>
            <td align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_spec1tarif,0); ?></td>
            <td width="32%" align="center" style="border-right: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_spec1meter,0); ?></td>
            <td width="4%" align="right" style="border-right: 1px solid #000;">Rp.</td>
            <td width="18%" align="right" style="border-right: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_specamounttotal,0); ?></td>            
          </tr> 
          <tr>
            <td width="16%" align="left" style="border-left: 1px solid #000;">Pemakaian</td>
            <td width="3%" align="center">:</td>
            <td width="14%" align="left"><?php echo $row->utilitiesairgasdetil_pemakaian; ?></td>
            <td rowspan="2" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>
            <td rowspan="2" align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>
            <td rowspan="2" align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>
            <td width="18%" rowspan="2" align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>            
          </tr>           
          <tr>
            <td align="center" style="border-left: 1px solid #000;">&nbsp;</td>
            <td align="center" >&nbsp;</td>
            <td align="left" >&nbsp;</td>
          </tr>
          <tr>
            <td align="center" style="border-left: 1px solid #000;">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td colspan="3" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">Pemeliharaan Meteran</td>
            <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_phmeter,0); ?></td>
          </tr>
          <tr>
            <td align="center" style="border-left: 1px solid #000;">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td colspan="3" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">PPN <?php echo number_format($row->utilitiesairgasdetil_tax,0); ?>%</td>
            <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_taxamount,0); ?></td>
          </tr>
          <tr>
            <td align="center" style="border-left: 1px solid #000;">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td colspan="3" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">Denda</td>
            <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_denda,0); ?></td>
          </tr>
          <tr>
            <td align="center" style="border-left: 1px solid #000;">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td colspan="3" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">Administrasi</td>
            <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_adm,0); ?></td>
          </tr>
          <tr>
            <td align="center" style="border-left: 1px solid #000;">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td colspan="3" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">Materai</td>
            <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_materai,0); ?></td>
          </tr>
          <tr>
            <td align="center" style="border-left: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>
            <td align="center" style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td align="left" style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td colspan="3" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">Jumlah</td>
            <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_total,0); ?></td>
          </tr>   
          <tr>
            <td colspan="7" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;"><strong>Terbilang : <span><?php echo number_to_wordsnorp(round($row->utilitiesairgasdetil_total,0)); ?></span></strong><strong> Rupiah</strong></td>
          </tr>
          <tr>
            <td colspan="7" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;"><em><strong>Rekening Pembayaran Utilities : <?php echo $row->schedulepaymentdetil_va; ?> Bank Mega KCP Makassar Tanjung Bunga a/n PT Trans Kalla Makassar</strong></em></td>
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