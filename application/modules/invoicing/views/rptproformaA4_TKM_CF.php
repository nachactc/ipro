<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Invoice</title>

<style>
@font-face {
    font-family: 'arial'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/arial.ttf');?>'); /*URL to font*/
	src: url('<?php echo base_url('assets/css/loo/arialbd.ttf');?>'); /*URL to font*/
}
body {font-family: 'arial';font-size: 12px}
@page { margin-left:4cm; margin-right:4cm; margin-top:4cm;margin-bottom:4cm;size:8.27in 11in;}
table, tr, td {
  font-family: 'arial';font-size: 12px;
}

</style>
</head>

<body>
<?php

//print_r($result); exit;
$irow =0;
$irow2 =0;
foreach($result as $invoice) {
//print_r($row); exit;
	$vnomorinv ='';
	$vnomorinv2 ='';
		
	foreach($invoice as $row ) {
		//print_r($invoice); 
		$vregion=$row->region_name;
		$vregadres=$row->region_address;
		$vjudul='I N V O I C E';
		$vnomorx=$row->faktur_id;
		$vnomorinv=$row->invoice_id;
		$agreementtype_type = $row->agreementtype_type;
		$t_total =0;
		$duedate = $row->schedulepaymentdetil_posteddate;
		$invdate = $row->schedulepaymentdetil_posteddate;
		if (substr($vnomorinv,0,1) == 'CN') {
			$vjudul='CREDIT NOTE';
			}
				
		$irow = $irow +1;
		$irow2 = $irow2 +1;			
		if ($vnomorinv != $vnomorinv2) {
			$vnomorinv2=$row->invoice_id;
			
			if(isset($result)){
			$no=1;
			$norut=1;			
			$ppn=0;
			$descr ='';
			$adm =0;
			$idr =0;
			$norut2 =1;
			$disc =0;
			$disc_percent ='';
			$disc_str ='';
			$disc_idr ='';
			$subtotal_str='';
			$subtotal_idr='';
			$tax_str ='';
			$tax_idr ='';
			
			
			foreach($invoice as $rowd){
				$jmlarr=count($result);
				$ppn=0;
				$adm = number_format($rowd->agreement_admpersen,0);
				$admidr = number_format($rowd->agreement_adm,0);	
				$idr = $rowd->schedulepaymentdetil_idr;
				$disc = $rowd->schedulepaymentdiscount_idr;
				if ($rowd->schedulepaymentdiscount_percent > 0 ){
					$disc_percent = $rowd->schedulepaymentdiscount_percent . '%';
				}else {
					$disc_percent ='';
				}
												
						
				if ($rowd->agreementdetil_tax >0){
					
					//$ppn= $rowd->schedulepaymentdetil_tax;
					$ppn=((($rowd->schedulepaymentdetil_idr - $rowd->schedulepaymentdiscount_idr)* $rowd->agreementdetil_tax) / 100);
					$tax_str ='Value Add Tax ' . $rowd->agreementdetil_tax . '%';
					$tax_idr = 'Rp.    ' . number_format($ppn,0);
				}else{
					$ppn=0;
					$tax_str ='';
					$tax_idr ='';
				}	
				
				$subttotal = ($idr - $disc);	
				$t_total =  $t_total + $subttotal + $ppn;	
				
				if ($rowd->schedulepaymentdiscount_idr > 0 ){
					$disc_str = 'Discount ' . $disc_percent;
					$disc_idr = 'Rp.    ' . number_format($disc,0);
					$subtotal_str='Subtotal ';
					$subtotal_idr= 'Rp.    ' . number_format($subttotal,0);
				}else {
					$disc_str ='';
					$disc_idr ='';
					$subtotal_str='';
					$subtotal_idr='';
				}
				
				if ($rowd->schedulepaymentdetil_isposted == '1')
				{
					//$vjudul='I N V O I C E';
					$invdate = $rowd->schedulepaymentdetil_posteddate;
					}
				else
					{
						//$vjudul='I N V O I C E';
						$invdate = $rowd->schedulepaymentdetil_proformadate;
						}
				
				
				if ($agreementtype_type == 'UTILITIES'){					 
					$duedate = date('Y-m-d', strtotime('+15 days', strtotime($invdate)));
				}
				elseif ($agreementtype_type == 'PS'){					 
					$duedate = date('Y-m-d', strtotime('+15 days', strtotime($invdate)));
				}
				else
				{
					$duedate = date('Y-m-d', strtotime('+15 days', strtotime($invdate)));
					}
				
			}}
			
?>	
		

<table width="786" border="0">
  
  <tr>
    <td width="55">&nbsp;</td>
    <td width="375">&nbsp;</td>
    <td width="157">&nbsp;</td>
    <td width="162">&nbsp;</td>
    <td width="15">&nbsp;</td>
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
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>To:</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row->invoice_id; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $row->rekanan_name; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('d F Y',(strtotime($invdate))); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td rowspan="2"><?php echo $row->rekananshipping_address;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Attn : <?php echo $row->rekanancontact_name;?></td>
    <td align="center"><?php echo date('d F Y',(strtotime($duedate))); ?></td>
    <td align="center">Rp. <?php echo number_format($t_total,0); ?></td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="786" border="0">
      <tr>
        <td width="39%">
        <table border="0" width="100%">
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td width="3%" align="left">&nbsp;</td>
            <td width="33%" align="left">Shope Name :</td>
            <td width="41%" align="left">The Payment Of :</td>
            <td width="19%" align="left">&nbsp;</td>
            <td width="4%" align="left">&nbsp;</td> 
          </tr>
          <tr>
            <td width="3%" align="left">&nbsp;</td>
            <td width="33%" align="left"><?php echo $row->rekananshipping_name; ?></td>
            <td width="41%" align="left">&nbsp;</td>
            <td width="19%" align="left">&nbsp;</td>
            <td width="4%" align="left">&nbsp;</td> 
          </tr>   
          <tr>
            <td width="3%" align="left">&nbsp;</td>
            <td width="33%" align="left">&nbsp;</td>
            <td width="41%" align="left"><?php echo $rowd->schedulepaymentdetil_descr; ?></td>
            <td width="19%" align="right">Rp.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($rowd->schedulepaymentdetil_idr,0); ?>&nbsp;&nbsp;</td>
            <td width="4%" align="left">&nbsp;</td> 
          </tr>      
          <tr>
            <td width="3%" align="left">&nbsp;</td>
            <td width="33%" align="left">Unit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Area</td>

            <td width="41%" align="left"><?php echo $disc_str; ?></td>
            <td width="19%" align="right"><?php echo $disc_idr; ?>&nbsp;&nbsp;</td>
 
               
              

            <td width="4%" align="left">&nbsp;</td> 
          </tr>     
          <tr>
            <td width="3%" align="left">&nbsp;</td>
            <td width="33%" align="left"><?php echo $row->agreement_shopunit; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $row->agreement_space; ?></td>
            
 
            <td width="41%" align="left"><?php echo $subtotal_str; ?></td>
            <td width="19%" align="right"><?php echo $subtotal_idr; ?>&nbsp;&nbsp;</td>

            
            
            <td width="4%" align="left">&nbsp;</td> 
          </tr>    
          <tr>
            <td width="3%" align="left">&nbsp;</td>
            <td width="33%" align="left">&nbsp;</td>
 
            <td width="41%" align="left"><?php echo $tax_str; ?></td>
            <td width="19%" align="right"><?php echo $tax_idr; ?>&nbsp;&nbsp;</td>
             
          
            <td width="4%" align="left">&nbsp;</td> 
          </tr>      
          <tr>
            <td width="3%" align="right" >&nbsp;</td>
            <td width="33%" align="left" >&nbsp;</td>
            <td width="41%" align="left" >&nbsp;</td>
            <td width="19%" align="left" >&nbsp;</td>
            <td width="4%" align="left" >&nbsp;</td> 
          </tr>     
          <tr>
            <td width="3%" align="right">&nbsp;</td>
            <td width="33%" align="left">&nbsp;</td>
            <td width="41%" align="left">&nbsp;</td>
            <td width="19%" align="left">&nbsp;</td>
            <td width="4%" align="left">&nbsp;</td> 
          </tr>     
          <tr>
            <td width="3%" align="left">&nbsp;</td>
            <td width="33%" align="left">&nbsp;</td>
            <td width="41%" align="left">&nbsp;</td>
            <td width="19%" align="left">&nbsp;</td>
            <td width="4%" align="left">&nbsp;</td> 
          </tr>    
   
          <tr>
            <td width="3%" align="right">&nbsp;</td>
            <td width="33%" align="left"><?php echo $row->rekanan_pkpname; ?></td>
            <td width="41%" align="left">&nbsp;</td>
            <td width="19%" align="left">&nbsp;</td>
            <td width="4%" align="left">&nbsp;</td> 
          </tr>   
          <tr>
            <td width="3%" align="left">&nbsp;</td>
            <td width="33%" align="left">Bank Mega KCU Metro Tanjung Bungasss</td>
            <td width="41%" align="left">&nbsp;</td>
            <td width="19%" align="left">&nbsp;</td>
            <td width="4%" align="left">&nbsp;</td> 
          </tr> 
          <tr>
            <td width="3%" align="right">&nbsp;</td>
            <td width="33%" align="left"><?php echo $row->bank_rekening1; ?></td>
            <td width="41%" align="left">&nbsp;</td>
            <td width="19%" align="left">&nbsp;</td>
            <td width="4%" align="left">&nbsp;</td> 
          </tr>
          <tr>
            <td width="3%" align="left">&nbsp;</td>
            <td width="33%" align="center">&nbsp;</td>
            <td width="41%" align="center">&nbsp;</td>
            <td width="19%" align="center">&nbsp;</td>
            <td width="4%" align="center">&nbsp;</td> 
          </tr>   
          <tr>
            <td width="3%" align="right">&nbsp;</td>
            <td width="33%" align="center"><?php echo $region['region_fax'];?></td>
            <td width="41%" align="center">&nbsp;</td>
            <td width="19%" align="center">&nbsp;</td>
            <td width="4%" align="center">&nbsp;</td> 
          </tr>          
          <tr>
            <td align="left">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td width="3%" align="left">&nbsp;</td>
            <td width="33%" align="center"><?php echo $region['region_telp'];?></td>
            <td width="41%" align="center">&nbsp;</td>
            <td width="19%" align="center">&nbsp;</td>
            <td width="4%" align="center">&nbsp;</td> 
          </tr>
            
                                                                                                                                  
          <tr>
            <td align="right">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="right"style="height:30px">&nbsp;</td>
            <td align="left"style="height:30px">&nbsp;</td>
            <td align="left"style="height:30px">&nbsp;</td>
            <td align="left"style="height:30px">&nbsp;</td>
            <td align="left"style="height:30px">&nbsp;</td>
          </tr>
          <tr>
            <td width="3%" align="right">&nbsp;</td>
            <td width="33%" align="left">&nbsp;</td>
            <td width="41%" align="left">&nbsp;</td>
            <td width="19%" align="left">&nbsp;</td>
            <td width="4%" align="left">&nbsp;</td> 
          </tr>
        </table>        
        </td>
         
  </tr>                                            
    </table>
    <table width="786" border="0"> 
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td width="14%" align="left">&nbsp;</td>
            <td width="41%" align="center">&nbsp;</td>
            <td width="16%" align="center">&nbsp;</td>
            <td width="21%" align="right">&nbsp;</td>
            <td width="3%" align="center">&nbsp;</td>            
          </tr>       
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td colspan="4" align="right">Rp.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($t_total,0); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="3%" align="center">&nbsp;</td>            
          </tr>   
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td colspan="4" align="left">&nbsp;</td>
            <td width="3%" align="center">&nbsp;</td>            
          </tr>           
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td colspan="3" rowspan="2" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_to_wordsnorp($t_total);?> Rupiah</td>
            <td align="left">&nbsp;</td>
            <td width="3%" align="center">&nbsp;</td>            
          </tr>   
          <tr>
            <td align="left">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="center"><?php echo $row->region_signature; ?></td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="left"><?php echo $row->invoice_id; ?></td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="left"><?php echo date('d F Y',strtotime($invdate)); ?></td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td width="14%" align="left"><span style="border-left: 1px solid #fff;">Tenant Name</span></td>
            <td width="41%" align="left">: <?php echo $row->rekanan_name; ?></td>
            <td width="16%" rowspan="2" align="center"><?php echo date('d F Y',(strtotime($duedate))); ?></td>
            <td width="21%" rowspan="2" align="center">Rp. <?php echo number_format($t_total,0); ?></td>
            <td width="3%" align="center">&nbsp;</td>            
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">Shope Name</td>
            <td align="left">: <?php echo $row->rekananshipping_name; ?></td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td rowspan="2" align="left">Address</td>
            <td colspan="2" rowspan="2" align="left">: <?php echo $row->rekananshipping_address;?></td>
            <td align="right">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
    </table>

<?php			
		}
	}
}
		//echo $vnomorinv;
		//exit;
		
		
?>
</body>
</html>