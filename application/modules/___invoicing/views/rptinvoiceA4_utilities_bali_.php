<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Invoice</title>
     <style>
        @font-face {
            font-family: 'arial'; /*a name to be used later*/
            src: url('<?php echo base_url('assets/css/loo/arial.ttf');?>'); /*URL to font*/
        }
        body {font-family: 'arial';font-size: 12pt}
        @page { margin-left:3cm; margin-right:4cm; margin-top:5cm;margin-bottom:3cm;size:8.27in 11.69in;}

        tab1 { padding-right: 222em; }        
     </style>
    
</head>

<body>


<?php
/*
$grandtotal =0;
$grandppn =0;
if(isset($result)){
$i=1;
foreach($result as $invoice) {
	foreach($invoice as $row ) {
	$grandppn = $row->schedulepaymentdetil_tax; 
	$grandtotal = $grandtotal + $row->schedulepaymentdetil_idr + $row->schedulepaymentdetil_tax; 	
}}}

*/
//print_r($result); exit;
$grandtotal =0;
$grandppn =0;
$utilities_standawal_listrik = 0;
	$utilities_standakhir_listrik = 0;
	$utilities_standawal_listrik = 0;
	$utilities_standakhir_listrik = 0;
	$utilities_sisa_listrik = 0;
	$utilities_faktor_listrik = 0;
	$utilities_pressure_listrik = 0;
	$utilities_mfaktor_listrik = 0;
	$utilities_tarif_listrik = 0;
	$utilities_biayapemakaian_listrik = 0;
	$utilities_biayapemakaian_listrik = 0;
	$utilities_PJU_listrik = 0;
	$utilities_abodemen_listrik = 0;
	$utilities_phmeter_listrik = 0;
	$utilities_admin_listrik = 0;
	$utilities_total_listrik = 0;
	$utilitieslistrikdetil_pemakaianlwbp = 0;
	$utilitieslistrikdetil_pemakaianwbp = 0;
	$utilitieslistrikdetil_tariflwbp = 0;
	$utilitieslistrikdetil_tarifwbp = 0;
	$utilitieslistrikdetil_reg = '';
	

	$utilities_standawal_air = 0;
	$utilities_standakhir_air = 0;
	$utilities_sisa_air = 0;
	$utilities_faktor_air = 0;
	$utilities_pressure_air = 0;
	$utilities_mfaktor_air = 0;
	$utilities_tarif_air = 0;
	$utilities_biayapemakaian_air = 0;
	$utilities_PJU_air = 0;
	$utilities_abodemen_air = 0;
	$utilities_phmeter_air = 0;
	$utilities_admin_air = 0;
	$utilities_total_air = 0;

	$utilities_standawal_gas = 0;
	$utilities_standakhir_gas = 0;
	$utilities_sisa_gas = 0;
	$utilities_faktor_gas = 0;
	$utilities_pressure_gas = 0;
	$utilities_mfaktor_gas = 0;
	$utilities_tarif_gas = 0;
	$utilities_biayapemakaian_gas = 0;
	$utilities_PJU_gas = 0;
	$utilities_abodemen_gas = 0;
	$utilities_phmeter_gas = 0;
	$utilities_admin_gas = 0;
	$utilities_total_gas = 0;	
	$agreementdetil_tax =0;
foreach($result as $invoice) {
//print_r($row); exit;
	$vnomorinv ='';
	$vnomorinv2 ='';	
	$isposted =0;
	$invoice_date='';
	
	$duedate ='';	
	
	$ref_id ='';
	$grandtotal =0;
	foreach($invoice as $rowTotal ) {
		if ($vnomorinv  == '') {
				$vnomorinv  = $rowTotal->invoice_id;
			}
		if ($vnomorinv  == $rowTotal->invoice_id) {
				$grandtotal = $grandtotal + $rowTotal->schedulepaymentdetil_idr + $rowTotal->schedulepaymentdetil_tax;
			}
	}
	foreach($invoice as $row ) {
		//print_r($invoice); 
		$vregion=$row->region_name;
		$vregadres=$row->region_address;
		$vjudul='I N V O I C E';
		$vnomorx=$row->faktur_id;
		$vnomorinv=$row->invoice_id;
		$isposted = $row->schedulepaymentdetil_isposted;
		if ($vnomorinv != $vnomorinv2) {
			$vnomorinv2=$row->invoice_id;
//		echo $vregion;
		//exit;
		$regionsignature = $row->region_signature;
		if ($isposted == '1') {
			$vjudul ='I N V O I C E';
			$invoice_date=$row->schedulepaymentdetil_posteddate;
			$vnomorx =$row->faktur_id;			
		}		
		else {
			$vjudul ='PROFORMA INVOICE';
			$invoice_date=$row->schedulepaymentdetil_proformadate;		
			$vnomorx =$row->invoice_id;				
			}
		if ($row->agreementtype_type == 'DEPOSIT') {
			$vnomorx =$row->invoice_id;
		}
		
?> 


<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
  <tr>
    <td width="500">&nbsp;
      
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td width="28%" align="center" valign="top" dir="ltr">
        <img border="0" src="<?php echo base_url('assets/img/transc4.jpg');?>" width="202" height="67"></td>
        <td width="31%" align="center" valign="top"><br></td>      
        <td width="3%"></td>  
        <td width="38%" align="left" valign="bottom"><table border="1" cellpadding="4" cellspacing="4" style="border-collapse: collapse" bordercolor="#111111" >
          <tr>
            <td width="100%" align="left">Nomor Invoice</td>
            <td width="100%" align="left"><?php echo $vnomorx;?></td>
          </tr>
          <tr>
            <td width="100%" align="left">Tanggal Invoice</td>
            <td width="100%" align="left"><?php echo date('d F Y',strtotime($invoice_date));?></td>
          </tr>     
          <tr>
            <td width="100%" align="left">Total Invoice</td>
            <td width="100%" align="left">Rp. <?php echo number_format($grandtotal,0);?></td>
          </tr>               
          <tr>
            <td width="100%" align="left">Jatuh Tempo</td>
            <td width="100%" align="left"><?php echo date('d F Y',(strtotime("+21 day", strtotime($invoice_date)))); ?></td>
          </tr>          
        </table>
        </td>
      </tr>
      <tr>
        <td align="center" valign="top" dir="ltr"><font size="4"><b><?php echo $vregion; ?></b></font></td>
        <td align="center" valign="top">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="left" valign="bottom">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top" dir="ltr"><?php echo $vregadres;?></td>
        <td align="center" valign="top">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="left" valign="bottom">&nbsp;</td>
      </tr>
      </table>

     <table cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td align="center" style="border-top: 1px solid #000; border-left: 1px solid #fff;border-right: 1px solid #fff; border-bottom: 1px solid #000;"><font size="6"><b><?php echo $vjudul;?></b></font></td>
      </tr>
      <tr>
        <td>
         
        </td>
      </tr>
    </table>
	
     
    
	</td>
    </tr>&nbsp;
 </table>

 
 
       

<?php		
	}}
}
?> 

</body>
</html>