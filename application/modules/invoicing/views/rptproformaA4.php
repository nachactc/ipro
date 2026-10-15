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

//print_r($result); exit;
foreach($result as $invoice) {
//print_r($row); exit;
	$vnomorinv ='';
	$vnomorinv2 ='';	
	foreach($invoice as $row ) {
		//print_r($invoice); 
		$vregion=$row->region_name;
		$vregadres=$row->region_address;
		$vjudul='PROFORMA INVOICE';
		$vnomorx=$row->faktur_id;
		$vnomorinv=$row->invoice_id;
		
		if ($vnomorinv != $vnomorinv2) {
			$vnomorinv2=$row->invoice_id;
//		echo $vregion;
		//exit;
		$regionsignature = $row->region_signature;
		
?> 

 
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
  <tr>
    <td width="100%">&nbsp;
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
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
            <td width="100%" align="right"><?php echo $vnomorinv;?></td>
          </tr>
        </table>
        </td>
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
        <td align="right"><?php echo number_format($rowd->schedulepaymentdetil_idr,0);?></td>
      </tr>
                  
		<?php
		if ($rowd->agreementtype_printouttype=='3'){
			$norut++;
			?>
            
      <tr>
        <td align="center" style=" border-right: 1px solid;"></td>
        <td colspan="2" style="border-right: 1px solid;">Awal : <?php echo number_format($rowd->agreement_standawal,2);?>  &nbsp;&nbsp; Akhir : <?php echo number_format($rowd->agreement_standakhir,2);?><br></td>
        <td align="right"><?php echo number_format($rowd->agreement_adm,0);?></td>
      </tr>
      
      <?php			
			}
		?>
      

        
              
       <?php
	  $t_total=$t_total+$rowd->schedulepaymentdetil_idr + $rowd->agreement_adm;
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
	  
	for ($norut; $norut < 24; $norut++) {
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
        <td width="66%"><b>PAYMENT TERMS AND CONDITIONS :</b></td>
        <td width="6%" style="border-left: 1px solid;border-right: 1px solid; border-bottom: 1px solid;"> 
        Total</td>
        <td align="right" style="border-bottom: 1px solid;"><?php echo number_format($t_grandtotal,0);?></td>
      </tr>
        <tr>
          <td></td>
          <td><p>1. This invoice is payable on or before 21 days after the invoice date<br />
2. Payment should be transfered to our Bank as Follows :<br />
  &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row->region_name; ?> <br />
3. Bank Mega Cab. Tendean A/C No : <?php echo $row->bank_rekening1; ?><br />
&nbsp;&nbsp;&nbsp;&nbsp;The payment value date is only effective when the funds are received in our<br />
&nbsp;&nbsp;&nbsp;&nbsp;bank account and should be net of any bank charges<br />
4. Interest at 0.1% Per Day will be charged on overdue balance</p></td>
          <td>&nbsp;</td>
          <td align="right"><p> Jakarta, <?php echo date('d F Y',strtotime($row->schedulepaymentdetil_proformadate)); ?></p>
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