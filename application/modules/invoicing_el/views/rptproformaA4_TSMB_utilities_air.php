<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Utilities</title>

<style>

      page[size="A4"] {
      background:white;
      width:21cm;
      height:28cm;
      display:block;
      margin-top:2cm;
	  margin-left:2cm;
	  margin-right:2cm;
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
		$tanggal_bayar = date('Y-m-d', strtotime($row->utilitiesairgas_date. ' + 1 month'));
//print_r($row); 
		
		
?> 


<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="73%">
  <tr>
  <td width="3%">&nbsp;</td>
    <td width="97%">
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="99%" >
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
        <img border="0" src="<?php echo base_url('assets/img/' . $row->branch_logo);?>" width="116" height="120"></td>
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
        <td colspan="4" align="center" valign="top" dir="ltr">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center" valign="top" dir="ltr"><font size="4"><b>REKENING PEMAKAIAN AIR</b></font></td>
        </tr>
      </table>
      
	<br>
     <table cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td>
        <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
          <tr>
            <td width="19%" >TENANT</td>
            <td width="4%" >:</td>
            <td width="24%" ><?php echo $row->rekananshipping_name; ?></td>
            <td width="22%">&nbsp;&nbsp;&nbsp;</td>
            <td width="31%">&nbsp;</td>
          </tr>
          <tr>
            <td >NO LOT</td>
            <td>:</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td >NO METER</td>
            <td>:</td>
            <td ><?php echo $row->utilitiesairgasdetil_reg; ?></td>
            <td > PEMAKAIAN</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("F", strtotime($row->utilitiesairgas_date)); ?> <?php echo date('Y', strtotime($row->utilitiesairgas_date)); ?></td>
          </tr>
          <tr>
            <td >LANTAI</td>
            <td>:</td>
            <td ><?php echo $row->utilitiesairgasdetil_unit; ?></td>
            <td >PEMBAYARAN</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("F", strtotime($tanggal_bayar)); ?> <?php echo date('Y', strtotime($tanggal_bayar)); ?></td>
          </tr>
          <tr>
            <td >UKURAN METER</td>
            <td>:</td>
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
            <td colspan="3" rowspan="2" align="center" style="border-top: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;"><p><strong>PENUNJUKAN METER</strong></p></td>
            <td colspan="3" align="center" style="border-top: 1px solid #000;border-left: 1px solid #000;border-right: 1px solid #000;">Perincian</td>
          </tr>
          <tr>
            <td align="center" style="border-top: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">Rp/M3 </td>
            <td align="center" style="border-top: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">Pemakaian</td>
            <td align="center" style="border-top: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">Total (Rp)</td>
          </tr>       
          <tr>
            <td width="19%" align="left" style="border-left: 1px solid #000;">Akhir</td>
            <td width="4%" align="center">:</td>
            <td width="19%" align="left"><?php echo $row->utilitiesairgasdetil_standakhir; ?></td>
            <td width="19%" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_spec1tarif,0); ?></td>
            <td width="18%" align="center" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_spec1meter,0); ?> </td>
            <td width="21%" align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_spec1amount,0); ?></td>            
          </tr>   
          <tr>
            <td width="19%" align="left" style="border-left: 1px solid #000;">Awal</td>
            <td width="4%" align="center" >:</td>
            <td width="19%" align="left"><?php echo $row->utilitiesairgasdetil_standawal; ?></td>
            <td width="19%" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_spec2tarif,0); ?></td>
            <td width="18%" align="center" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_spec2meter,0); ?></td>
            <td width="21%" align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_spec2amount,0); ?></td>            
          </tr> 
          <tr>
            <td align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;">Pemakaian</td>
            <td align="center" style="border-bottom: 1px solid #000;">:</td>
            <td align="left" style="border-bottom: 1px solid #000;"><?php echo $row->utilitiesairgasdetil_pemakaian; ?></td>
            <td align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_spec3tarif,0); ?></td>
            <td align="center" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_spec3meter,0); ?></td>
            <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_spec3amount,0); ?></td>
          </tr>
          <tr>
            <td width="19%" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>
            <td width="4%" align="center" style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td width="19%" align="left" style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_spec4tarif,0); ?></td>
            <td align="center" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_spec4meter,0); ?></td>
            <td width="21%" align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_spec4amount,0); ?></td>            
          </tr>           
          <tr>
            <td colspan="3" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>
            <td colspan="2" align="center" style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" style="border-left: 1px solid #000;border-bottom: 1px solid #000;">Biaya Administrasi</td>
            <td colspan="2" align="center" style="border-left: 1px solid #000;border-bottom: 1px solid #000;">B. Pelayanan Air Kotor</td>
            <td colspan="2" align="center" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">Pemeliharaan Meter</td>
            <td align="center" style="border-right: 1px solid #000;border-bottom: 1px solid #000;">Materai</td>
          </tr>
          <tr>
            <td align="center" style="border-left: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_adm,0); ?></td>
            <td colspan="2" align="center" style="border-left: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_phairkotor,0); ?></td>
            <td colspan="2" align="center" style="border-left: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_phmeter,0); ?></td>
            <td align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_materai,0); ?></td>
          </tr>
          <tr>
            <td colspan="5" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;">Denda Bulan :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("F", strtotime($tanggal_bayar)); ?> <?php echo date('Y', strtotime($tanggal_bayar)); ?></td>
            <td align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_denda,0); ?></td>
          </tr>
          <tr>
            <td colspan="5" align="center" style="border-left: 1px solid #000;border-bottom: 1px solid #000;">Jumlah Tagihan</td>
            <td align="right" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_total,0); ?></td>
          </tr>   
          <tr>
            <td colspan="6" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;"><strong><span><?php echo number_to_wordsnorp(round($row->utilitiesairgasdetil_total,0)); ?></span></strong><strong> Rupiah</strong></td>
          </tr>
          <tr>
            <td colspan="6" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;"><strong><em>No rekening Pembayaran Utilities : Bank Mega A/C 01.072.00.11000.660 Mega Buah Batu (660)</em></strong></td>
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
      </table>
	</td>
  </tr>
</table>


 <?php		
	}}
?> 

</body>
</html>