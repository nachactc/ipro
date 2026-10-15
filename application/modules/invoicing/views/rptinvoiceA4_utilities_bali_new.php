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
/*
if(isset($result)){
$i=1;
foreach($result as $row){
	if ($i==1){
		$vregion=$row->region_name;
		$vregadres=$row->region_address;
	}
$i++;	
}}
*/
	$vnomorinv ='';
	$vnomorinv2 ='';
// print_r($result); exit;
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

 
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="753">
  <tr>
    <td width="100%">&nbsp;
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="680">
      <tr>
        <td width="28%" align="center" valign="top" dir="ltr">
        <img border="0" src="<?php echo base_url('assets/img/transc4.jpg');?>" width="202" height="67"></td>
        <td width="39%" align="center" valign="top"><font size="4"><b><?php echo $vregion; ?></b></font><br>
        <?php echo $vregadres;?>
        </td>      
        <td width="6%"></td>  
        <td width="27%" align="left" valign="bottom">        
          Nomor Invoice:
            <table border="1" cellpadding="4" cellspacing="4" style="border-collapse: collapse" bordercolor="#111111" width="200">
          <tr>
            <td width="100%" align="right"><?php echo $vnomorx;?></td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
    <br>
     <table cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="680">
      <tr>
        <td align="center" style="border-top: 1px solid #000; border-left: 1px solid #fff;border-right: 1px solid #fff; border-bottom: 1px solid #000;"><font size="6"><b><?php echo $vjudul;?></b></font></td>
      </tr>
      <tr>
        <td>
        <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="680">
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
    <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="680">
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
				$utilities_PJU_percent_listrik = $rowd->utilities_pjupercent;
				$utilitieslistrikdetil_pemakaianlwbp = $rowd->utilitieslistrikdetil_pemakaianlwbp;
				$utilitieslistrikdetil_pemakaianwbp = $rowd->utilitieslistrikdetil_pemakaianwbp;
				$utilitieslistrikdetil_tariflwbp = $rowd->utilitieslistrikdetil_tariflwbp;
				$utilitieslistrikdetil_tarifwbp = $rowd->utilitieslistrikdetil_tarifwbp;
				$utilitieslistrikdetil_reg = $rowd->utilitieslistrikdetil_reg;				
				
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
        <td colspan="2" style="border-right: 1px solid;"><?php echo $rowd->schedulepaymentdetil_descr;?> <?php echo $descr;?> <br></td>
        <td align="right"><?php echo $idr;?></td>
      </tr>
                  
		<?php
		if ($rowd->agreementtype_printouttype=='3'){
			$norut++;
			?>
            

      
      <?php			
			}
		?>
      

        
              
       <?php
	  $t_total=$t_total+($rowd->schedulepaymentdetil_idr) + ($rowd->agreement_adm);
	   	if ($rowd->agreementdetil_tax >0){
			$ppn=$ppn+((($rowd->schedulepaymentdetil_idr + $rowd->agreement_adm)* $rowd->agreementdetil_tax) / 100);
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
	  
	for ($norut; $norut < 2; $norut++) {
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
        <td width="66%"></td>
        <td width="6%" style="border-left: 1px solid;border-right: 1px solid; border-bottom: 1px solid;"> 
        Total</td>
        <td align="right" style="border-bottom: 1px solid;"><?php echo number_format($t_grandtotal,0);?></td>
      </tr>
        <tr>
          <td></td>
          <td></td>
          <td>&nbsp;</td>
          <td align="right"></p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>                    
          <p>&nbsp;</p>
          <p><font size="2"><?php echo $regionsignature; ?>&nbsp; </font></p></td>
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