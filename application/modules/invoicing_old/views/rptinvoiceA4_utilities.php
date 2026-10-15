<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Invoice</title>

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
	$utilities_PJU_listrik = 0;
	$utilities_abodemen_listrik = 0;
	$utilities_phmeter_listrik = 0;
	$utilities_admin_listrik = 0;
	$utilities_total_listrik = 0;

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
			$vjudul =' PROFORMA INVOICE';
			$invoice_date=$row->schedulepaymentdetil_proformadate;		
			$vnomorx =$row->invoice_id;				
			}
		if ($row->agreementtype_type == 'DEPOSIT') {
			$vnomorx =$row->invoice_id;
		}
		
?> 

 
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
  <tr>
    <td width="100%">&nbsp;
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td width="28%" align="center" valign="top" dir="ltr">
        <img border="0" src="<?php echo base_url('assets/img/transc4.jpg');?>" width="202" height="67"></td>
        <td width="31%" align="center" valign="top"><br></td>      
        <td width="3%"></td>  
        <td width="38%" align="left" valign="bottom"><table border="1" cellpadding="4" cellspacing="4" style="border-collapse: collapse" bordercolor="#111111" width="309">
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
    <br>
     <table cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td align="center" style="border-top: 1px solid #000; border-left: 1px solid #fff;border-right: 1px solid #fff; border-bottom: 1px solid #000;"><font size="6"><b><?php echo $vjudul;?></b></font></td>
      </tr>
      <tr>
        <td>
        <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
          <tr>
            <td width="5%" style="border-left: 1px solid #fff;">&nbsp;</td>
            <td width="7%">Pembeli</td>
            <td width="2%">:</td>
            <td width="86%"><?php echo $row->agreement_contractno; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo $row->rekanan_pkpname; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Alamat</td>
            <td>:</td>
            <td><?php echo $row->npwpaddress;?></td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
    <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
      <tr>
        <td width="7%" align="center" style="border-top: 1px solid ; border-right: 1px solid; border-bottom: 1px solid;" >No</td>
        <td colspan="2" align="center" style="border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid;">Deskripsi</td>        
        <td width="21%" align="center" style="border-top: 1px solid #000; border-bottom: 1px solid #000;">Nilai</td>
      </tr>
       <tr>
        <td align="center" style=" border-right: 1px solid; border-bottom: 0px ;"></td>
        <td colspan="2" style="border-right: 1px solid; border-bottom: 0px;"> 
        Due to Outlet Rental On <?php echo $row->branch_name; ?><br>
        Outlet : <?php echo $row->rekananshipping_name.' Unit '.$row->agreement_shopunit.' Area '.$row->agreement_space.' m2';?><br>
        Rent periode : <?php echo date("d M Y", strtotime($row->agreement_startdate)).' - '.date("d M Y", strtotime($row->agreement_enddate));?><br>
		</td>
        <td align="right" style="border-bottom: 0px;">&nbsp;</td>
      </tr>
         <?php
		if(isset($result)){
			$no=1;
			$norut=1;			
			$ppn=0;
			$t_total=0;
			$t_grandtotal=0;
			$descr ='';
			$adm =0;
			$idr =0;
			$subttotal =0;
			
			foreach($invoice as $rowd){
				$jmlarr=count($result);
				$adm = number_format($rowd->agreement_admpersen,0);
				$admidr = number_format($rowd->agreement_adm,0);	
				$idr = number_format($rowd->schedulepaymentdetil_idr,0);
				$subttotal = $idr + $admidr;
				$ref_id = substr($rowd->ref_id, 0, 2);
				$agreementdetil_tax = $rowd->agreementdetil_tax;
				
//								

				if ($ref_id == "UL"){
						$utilities_standawal_listrik = $rowd->utilities_standawal;
                        $utilities_standakhir_listrik = $rowd->utilities_standakhir;
                        $utilities_sisa_listrik = $rowd->utilities_sisa;
                        $utilities_faktor_listrik = $rowd->utilities_faktor;
                        $utilities_pressure_listrik = $rowd->utilities_pressure;
                        $utilities_mfaktor_listrik = $rowd->utilities_mfaktor;
                        $utilities_tarif_listrik = $rowd->utilities_tarif;
                        $utilities_biayapemakaian_listrik = $rowd->utilities_biayapemakaian;
                        $utilities_PJU_listrik = $rowd->utilities_PJU;
                        $utilities_PJU_percent_listrik = $rowd->utilities_pjupercent;
                        $utilities_abodemen_listrik = $rowd->utilities_abodemen;
                        $utilities_phmeter_listrik = $rowd->utilities_phmeter;
                        $utilities_admin_listrik = $rowd->utilities_admin;
                        $utilities_total_listrik = $rowd->utilities_total;						
				}
				elseif ($ref_id == "UA"){
						$utilities_standawal_air = $rowd->utilities_standawal;
                        $utilities_standakhir_air = $rowd->utilities_standakhir;
                        $utilities_sisa_air = $rowd->utilities_sisa;
                        $utilities_faktor_air = $rowd->utilities_faktor;
                        $utilities_pressure_air = $rowd->utilities_pressure;
                        $utilities_mfaktor_air = $rowd->utilities_mfaktor;
                        $utilities_tarif_air = $rowd->utilities_tarif;
                        $utilities_biayapemakaian_air = $rowd->utilities_biayapemakaian;
                        $utilities_PJU_air = $rowd->utilities_PJU;
                        $utilities_PJU_percent_air = $rowd->utilities_pjupercent;
                        $utilities_abodemen_air = $rowd->utilities_abodemen;
                        $utilities_phmeter_air = $rowd->utilities_phmeter;
                        $utilities_admin_air = $rowd->utilities_admin;
                        $utilities_total_air = $rowd->utilities_total;						
				}
				elseif ($ref_id == "UG"){
						$utilities_standawal_gas = $rowd->utilities_standawal;
                        $utilities_standakhir_gas = $rowd->utilities_standakhir;
                        $utilities_sisa_gas = $rowd->utilities_sisa;
                        $utilities_faktor_gas = $rowd->utilities_faktor;
                        $utilities_pressure_gas = $rowd->utilities_pressure;
                        $utilities_mfaktor_gas = $rowd->utilities_mfaktor;
                        $utilities_tarif_gas = $rowd->utilities_tarif;
                        $utilities_biayapemakaian_gas = $rowd->utilities_biayapemakaian;
                        $utilities_PJU_gas = $rowd->utilities_PJU;
                        $utilities_PJU_percent_gas = $rowd->utilities_pjupercent;
                        $utilities_abodemen_gas = $rowd->utilities_abodemen;
                        $utilities_phmeter_gas = $rowd->utilities_phmeter;
                        $utilities_admin_gas = $rowd->utilities_admin;
                        $utilities_total_gas = $rowd->utilities_total;						
				}
				
								
				if ($rowd->agreement_admpersen > 0){
					$descr = ' + Biaya administrasi ' . $adm . '%';
					}
				else {
					$descr = '';
					}
					
				if ($no==$jmlarr){
					$garis="1px solid";
				}else{
					$garis="0px";
				}
			?> 		
      <tr>
        <td align="center" style=" border-right: 1px solid;"><?php echo $no;?></td>
        <td colspan="2" style="border-right: 1px solid;"><?php echo $ref_id;?> <?php echo $rowd->schedulepaymentdetil_descr;?></td>
        <td align="right"><?php echo number_format($rowd->schedulepaymentdetil_idr,0);?></td>
      </tr>
                  
		 
                            
       <?php
	  $t_total=$t_total+$rowd->schedulepaymentdetil_idr;
	   	if ($rowd->agreementdetil_tax >0){
			$ppn=$ppn+((($rowd->schedulepaymentdetil_idr)* $rowd->agreementdetil_tax) / 100);
		}else{
			$ppn=0;
		}
	   $no++;
	   $norut++;
		}
		}
		$t_grandtotal=$t_total+$ppn;
	  ?>
      
      <?php
	  
	for ($norut; $norut < 10; $norut++) {
		$non ='';
	?>
      <tr>
        <td align="center" style=" border-right: 1px solid;">&nbsp;</td>
        <td colspan="2" style="border-right: 1px solid;">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
    <?php
	}
        ?>
                
              
      <tr>
        <td colspan="3" align="center" style=" border-right: 1px solid; border-top: 1px solid;border-bottom: 1px solid;">&nbsp;</td>
        <td align="right" style="border-bottom: 1px solid; border-top: 1px solid;"><?php echo number_format(round($t_total),0);?></td>
      </tr>

      <tr>
        <td>        
        </td>
        <td width="66%">&nbsp;</td>
        <td width="6%" style="border-left: 1px solid;border-right: 1px solid; border-bottom: 1px solid;"> 
        PPN</td>
        <td align="right" style="border-bottom: 1px solid;"><?php echo number_format($ppn,0);?></td>
      </tr>
        <tr>
        <td height="27">        
        </td>
        <td width="66%">Terbilang : <?php echo number_to_wordsnorp($grandtotal);?> Rupiah</td>
        <td width="6%" style="border-left: 1px solid;border-right: 1px solid; border-bottom: 1px solid;"> 
        Total</td>
        <td align="right" style="border-bottom: 1px solid;"><?php echo number_format($t_grandtotal,0);?></td>
      </tr>
        <tr>
          <td></td>
          <td><p>&nbsp;</p></td>
          <td>&nbsp;</td>
          <td align="right"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p><font size="2"><?php echo $regionsignature; ?>&nbsp; </font></p></td>
        </tr>
    </table>
    
	<table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
          <tr>
            <td align="center" colspan="5" style="border-left: 1px solid #fff;"><font size="4"><b>Laporan Pencatatan Meteran dan Perhitungan Pemakaian</b></font></td>
          </tr>
          <tr>
            <td colspan="5" style="border-left: 1px solid #fff;">&nbsp;</td>
          </tr>
          <tr>
            <td width="3%" style="border-left: 1px solid;border-right: 1px solid; border-top: 1px solid; border-bottom: 1px solid;">No</td>
            <td width="49%" style="border-left: 1px solid;border-right: 1px solid; border-top: 1px solid; border-bottom: 1px solid;">Keterangan</td>
            <td align="center" width="16%" style="border-left: 1px solid;border-right: 1px solid; border-top: 1px solid; border-bottom: 1px solid;">Listrik</td>
            <td align="center" width="16%" style="border-left: 1px solid;border-right: 1px solid; border-top: 1px solid; border-bottom: 1px solid;">Air</td>
            <td align="center" width="16%" style="border-left: 1px solid;border-right: 1px solid; border-top: 1px solid; border-bottom: 1px solid;">Gas</td>
          </tr>
          <tr>
            <td style="border-left: 1px solid;">1</td>
            <td style="border-left: 1px solid;">Pencatatan Meter Awal</td>
            <td align="right" style="border-left: 1px solid;"><?php echo number_format($utilities_standawal_listrik,0);?>&nbsp; KWH</td>
            <td align="right" style="border-left: 1px solid;"><?php echo number_format($utilities_standawal_air,4);?>&nbsp; M3</td>
            <td align="right" style="border-left: 1px solid;border-right: 1px solid;"><?php echo number_format($utilities_standawal_gas,4);?>&nbsp; M3</td>
          </tr>
          <tr>
            <td style="border-left: 1px solid;">2</td>
            <td style="border-left: 1px solid;">Pencatatan Meter Akhir</td>
            <td align="right" style="border-left: 1px solid;"><?php echo number_format($utilities_standakhir_listrik,0);?>&nbsp; KWH</td>
            <td align="right" style="border-left: 1px solid;"><?php echo number_format($utilities_standakhir_air,4);?>&nbsp; M3</td>
            <td align="right" style="border-left: 1px solid;border-right: 1px solid;"><?php echo number_format($utilities_standakhir_gas,4);?>&nbsp; M3</td>
          </tr>
          <tr>
            <td style="border-left: 1px solid;">3</td>
            <td style="border-left: 1px solid;">Total Pemakaian</td>
            <td align="right" style="border-left: 1px solid;"><?php echo number_format($utilities_sisa_listrik,0);?>&nbsp; KWH</td>
            <td align="right" style="border-left: 1px solid;"><?php echo number_format($utilities_sisa_air,4);?>&nbsp; M3</td>
            <td align="right" style="border-left: 1px solid;border-right: 1px solid;"><?php echo number_format($utilities_sisa_gas,4);?> &nbsp;M3</td>
          </tr>
          <tr>
            <td style="border-left: 1px solid;">4</td>
            <td style="border-left: 1px solid;">Faktor Kali</td>
            <td align="right" style="border-left: 1px solid;"><?php echo number_format($utilities_faktor_listrik,0);?></td>
            <td align="right" style="border-left: 1px solid;"><?php echo number_format($utilities_faktor_air,0);?></td>
            <td align="right" style="border-left: 1px solid;border-right: 1px solid;"><?php echo number_format($utilities_faktor_gas,0);?></td>
          </tr>
          <tr>
            <td style="border-left: 1px solid;">5</td>
            <td style="border-left: 1px solid;">Pressure mBar</td>
            <td align="right" style="border-left: 1px solid;"><?php echo number_format($utilities_pressure_listrik,0);?></td>
            <td align="right" style="border-left: 1px solid;"><?php echo number_format($utilities_pressure_air,0);?></td>
            <td align="right" style="border-left: 1px solid;border-right: 1px solid;"><?php echo number_format($utilities_pressure_gas,3);?></td>
          </tr>
          <tr>
            <td style="border-left: 1px solid;">6</td>
            <td style="border-left: 1px solid;">Convertion Faktor (faktor kali X (faktor kali X (1+(pressure mbar/1000))</td>
            <td align="right" style="border-left: 1px solid;"><?php echo number_format($utilities_mfaktor_listrik,0);?></td>
            <td align="right" style="border-left: 1px solid;"><?php echo number_format($utilities_mfaktor_air,0);?></td>
            <td align="right" style="border-left: 1px solid;border-right: 1px solid;"><?php echo number_format($utilities_mfaktor_gas,8);?></td>
          </tr>
          <tr>
            <td style="border-left: 1px solid;">7</td>
            <td style="border-left: 1px solid;">Tarif</td>
            <td align="right" style="border-left: 1px solid;">Rp. &nbsp;<?php echo number_format($utilities_tarif_listrik,0);?>&nbsp;/KWH</td>
            <td align="right" style="border-left: 1px solid;">Rp. &nbsp;<?php echo number_format($utilities_tarif_air,0);?>&nbsp;/M3</td>
            <td align="right" style="border-left: 1px solid;border-right: 1px solid;">Rp. &nbsp;<?php echo number_format($utilities_tarif_gas,0);?>&nbsp;/KG</td>
          </tr>
          <tr>
            <td style="border-left: 1px solid;">8</td>
            <td style="border-left: 1px solid;">Biaya Pemakaian</td>
            <td align="right" style="border-left: 1px solid;">Rp. &nbsp;<?php echo number_format($utilities_biayapemakaian_listrik,0);?></td>
            <td align="right" style="border-left: 1px solid;">Rp. &nbsp;<?php echo number_format($utilities_biayapemakaian_air,0);?></td>
            <td align="right" style="border-left: 1px solid;border-right: 1px solid;">Rp. &nbsp;<?php echo number_format($utilities_biayapemakaian_gas,0);?></td>
          </tr>
          <tr>
            <td style="border-left: 1px solid;">9</td>
            <td style="border-left: 1px solid;">PJU <?php echo number_format($utilities_PJU_percent_listrik,0);?>%</td>
            <td align="right" style="border-left: 1px solid;">Rp. &nbsp; <?php echo number_format($utilities_PJU_listrik,0);?></td>
            <td align="right" style="border-left: 1px solid;">Rp. &nbsp; <?php echo number_format($utilities_PJU_air,0);?></td>
            <td align="right" style="border-left: 1px solid;border-right: 1px solid;">Rp. &nbsp; <?php echo number_format($utilities_PJU_gas,0);?></td>
          </tr>
          <tr>
            <td style="border-left: 1px solid;">10</td>
            <td style="border-left: 1px solid;">Abodemen</td>
            <td align="right" style="border-left: 1px solid;">Rp. &nbsp; <?php echo number_format($utilities_abodemen_listrik,0);?></td>
            <td align="right" style="border-left: 1px solid;">Rp. &nbsp; <?php echo number_format($utilities_abodemen_air,0);?></td>
            <td align="right" style="border-left: 1px solid;border-right: 1px solid;">Rp. &nbsp; <?php echo number_format($utilities_abodemen_gas,0);?></td>
          </tr>
          <tr>
            <td style="border-left: 1px solid;">11</td>
            <td style="border-left: 1px solid;">PH Meter</td>
            <td align="right" style="border-left: 1px solid;">Rp. &nbsp; <?php echo number_format($utilities_phmeter_listrik,0);?></td>
            <td align="right" style="border-left: 1px solid;">Rp. &nbsp; <?php echo number_format($utilities_phmeter_air,0);?></td>
            <td align="right" style="border-left: 1px solid;border-right: 1px solid;">Rp. &nbsp; <?php echo number_format($utilities_phmeter_gas,0);?></td>
          </tr>
          <tr>
            <td style="border-left: 1px solid;">12</td>
            <td style="border-left: 1px solid;">Biaya Admin <?php echo number_format($agreementdetil_tax,0);?>%</td>
            <td align="right" style="border-left: 1px solid;">Rp. &nbsp; <?php echo number_format($utilities_admin_listrik,0);?></td>
            <td align="right" style="border-left: 1px solid;">Rp. &nbsp; <?php echo number_format($utilities_admin_air,0);?></td>
            <td align="right" style="border-left: 1px solid;border-right: 1px solid;">Rp. &nbsp; <?php echo number_format($utilities_admin_gas,0);?></td>
          </tr>
          <tr>
            <td style="border-left: 1px solid;border-top: 1px solid;border-bottom: 1px solid;">&nbsp;</td>
            <td style="border-left: 1px solid;border-top: 1px solid;border-bottom: 1px solid;">Total Biaya Pemakaian</td>
            <td align="right" style="border-left: 1px solid;border-top: 1px solid;border-bottom: 1px solid;">Rp. &nbsp; <?php echo number_format($utilities_total_listrik,0);?></td>
            <td align="right" style="border-left: 1px solid;border-top: 1px solid;border-bottom: 1px solid;">Rp. &nbsp; <?php echo number_format($utilities_total_air,0);?></td>
            <td align="right" style="border-left: 1px solid;border-top: 1px solid;border-bottom: 1px solid;border-right:1px solid;"><?php echo number_format($utilities_total_gas,0);?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><b>PAYMENT TERMS AND CONDITIONS :</b></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>1. Payment should be transfered to our Bank as Follows :<br />
&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row->rekanan_pkpname; ?> <br />
3. Bank Mega Cab. Tendean A/C No : <?php echo $row->bank_rekening1; ?><br />
&nbsp;&nbsp;&nbsp;&nbsp;The payment value date is only effective when the funds are received in our<br />
&nbsp;&nbsp;&nbsp;&nbsp;bank account and should be net of any bank charges<br />
4. Interest at 0.1% Per Day will be charged on overdue balance</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center" colspan="5" style="border-left: 1px solid;border-top: 1px solid;border-bottom: 1px solid;border-right:1px solid;"><font size="4"><b>TAGIHAN DICETAK MELALUI KOMPUTERISASI, TANDA TANGAN TIDAK DIPERLUKAN</b></font></td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
        
</td>
  </tr>
</table>

<?php		
	}}
}
?> 

</body>
</html>