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
        <td width="12%" align="left" valign="top" dir="ltr">
        <img border="0" src="<?php echo base_url('assets/img/tcp.jpg');?>" width="116" height="120"></td>
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
        <td colspan="4" align="center" valign="top" dir="ltr"><font size="4"><b>REKENING PEMAKAIAN AIR</b></font></td>
        </tr>
      </table>
      
	<br>
     <table cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td>
        <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
          <tr>
            <td width="14%" >Nama Tenant</td>
            <td width="2%" >:</td>
            <td width="24%" ><?php echo $row->rekananshipping_name; ?></td>
            <td width="21%"> Pemakaian : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="39%">:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("F", strtotime($row->utilitiesairgas_date)); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('Y', strtotime($row->utilitiesairgas_date)); ?></span></td>
          </tr>
          <tr>
            <td >Nomor Lokasi</td>
            <td>:</td>
            <td ><?php echo $row->utilitiesairgasdetil_unit; ?></td>
            <td >Store</td>
            <td>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row->branch_name; ?></td>
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
            <td colspan="3" align="center" style="border-top: 1px solid #000;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;"><strong>Perincian</strong></td>
            <td width="18%" align="center" style="border-top: 1px solid #000;border-top: 1px solid #000;border-right: 1px solid #000;"><strong>Total (Rp.)</strong></td>            
          </tr>       
          <tr>
            <td width="16%" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;">Akhir</td>
            <td width="3%" align="center" style="border-bottom: 1px solid #000;">:</td>
            <td width="14%" align="left" style="border-bottom: 1px solid #000;"><?php echo $row->utilitiesairgasdetil_standakhir; ?></td>
            <td colspan="2" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><strong>Pemakaian</strong></td>
            <td width="24%" align="center" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><strong>Tarif</strong></td>
            <td width="18%" align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>            
          </tr>   
          <tr>
            <td width="16%" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;">Awal</td>
            <td width="3%" align="center" style="border-bottom: 1px solid #000;">:</td>
            <td width="14%" align="left" style="border-bottom: 1px solid #000;"><?php echo $row->utilitiesairgasdetil_standawal; ?></td>
            <td colspan="2" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_pemakaian,0); ?></td>
            <td width="24%" align="center" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_spec1tarif,0); ?></td>
            <td width="18%" align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_specamounttotal,0); ?></td>            
          </tr> 
          <tr>
            <td width="16%" align="left" style="border-left: 1px solid #000;">Pemakaian</td>
            <td width="3%" align="center">:</td>
            <td width="14%" align="left"><?php echo $row->utilitiesairgasdetil_pemakaian; ?></td>
            <td colspan="3" align="center" style="border-left: 1px solid #000;border-right: 1px solid #000;border-bottom: 1px solid #000;">Abodemen</td>
            <td width="18%" align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_pemeliharaan,0); ?></td>            
          </tr>           
          <tr>
            <td width="16%" align="center" style="border-left: 1px solid #000;">&nbsp;</td>
            <td width="3%" align="center" >&nbsp;</td>
            <td width="14%" align="left">&nbsp;</td>
            <td colspan="3" align="center" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">PH Meter</td>
            <td width="18%" align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_phmeter,0); ?></td>            
          </tr>
          <tr>
            <td align="center" style="border-left: 1px solid #000;">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td colspan="3" align="center" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">PH Air Kotor</td>
            <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_phairkotor,0); ?></td>
          </tr>
          <tr>
            <td align="center" style="border-left: 1px solid #000;">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td colspan="3" align="center" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">Adjustment</td>
            <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_denda,0); ?></td>
          </tr>
          <tr>
            <td align="center" style="border-left: 1px solid #000;">&nbsp;</td>
            <td align="center" >&nbsp;</td>
            <td align="left" >&nbsp;</td>
            <td width="13%" align="center" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">Adm</td>
            <td width="12%" align="center" style="border-bottom: 1px solid #000;"><span><?php echo number_format($row->utilitiesairgasdetil_admpercent,0); ?></span>%</td>
            <td align="left" style="border-bottom: 1px solid #000;border-right: 1px solid #000;">&nbsp;</td>
            <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_adm,0); ?></td>
          </tr>
          <tr>
            <td align="center" style="border-left: 1px solid #000;">&nbsp;</td>
            <td align="center" >&nbsp;</td>
            <td align="left" >&nbsp;</td>
            <td colspan="3" align="center" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">Total</td>
            <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_total,0); ?></td>
          </tr>
          <tr>
            <td align="center" style="border-left: 1px solid #000;">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="center" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">PPN</td>
            <td align="center" style="border-bottom: 1px solid #000;"><span><?php echo number_format($row->utilitiesairgasdetil_tax,0); ?></span>%</td>
            <td align="left" style="border-bottom: 1px solid #000;border-right: 1px solid #000;">&nbsp;</td>
            <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_taxamount,0); ?></td>
          </tr>
          <tr>
            <td align="center" style="border-left: 1px solid #000;border-bottom: 1px solid #000;">&nbsp;</td>
            <td align="center" style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td align="left" style="border-bottom: 1px solid #000;">&nbsp;</td>
            <td colspan="3" align="center" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">Jumlah</td>
            <td align="right" style="border-right: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($row->utilitiesairgasdetil_total + $row->utilitiesairgasdetil_taxamount,0); ?></td>
          </tr>   
          <tr>
            <td colspan="7" align="left" style="border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;"><strong>Terbilang : <span><?php echo number_to_wordsnorp(round($t_total,0)); ?></span></strong><strong> Rupiah</strong></td>
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