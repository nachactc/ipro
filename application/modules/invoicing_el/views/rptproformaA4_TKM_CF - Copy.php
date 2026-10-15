<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Invoice</title>

<style>


      page[size="Letter"] {
      background:white;
      width:21cm;
      height:28cm;
      display:block;
      margin:0 auto;
      margin-bottom:0.1cm;
      box-shadow:0 0 0.5cm rgba(0,0,0,0.5);
      }

      @media print {
      body,page[size="Letter"] {
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
$irow =0;
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
			
			
			foreach($invoice as $rowd){
				$jmlarr=count($result);
				$ppn=0;
				$adm = number_format($rowd->agreement_admpersen,0);
				$admidr = number_format($rowd->agreement_adm,0);	
				$idr = $rowd->schedulepaymentdetil_idr;								
						
				if ($rowd->agreementdetil_tax >0){
					$ppn= $rowd->schedulepaymentdetil_tax;
					//$ppn=$ppn+((($rowd->schedulepaymentdetil_idr + $rowd->agreement_adm)* $rowd->agreementdetil_tax) / 100);
				}else{
					$ppn=0;
				}	
				
				$subttotal = $idr + $ppn;	
				$t_total =  $t_total + $subttotal ;	
				
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
					$duedate = date('Y-m-d', strtotime('+20 days', strtotime($invdate)));
					}
				
			}}
			
?>	
		

<table width="786" border="0">
<?php
	if ($irow > 2){
		
?>
  <tr>
    <td width="55">&nbsp;</td>
    <td width="375">&nbsp;</td>
    <td width="157">&nbsp;</td>
    <td width="162">&nbsp;</td>
    <td width="15">&nbsp;</td>
  </tr>
<?php
	 $irow = 0;
		}
?>  
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
    <td><?php echo $row->rekananshipping_address;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Attn : <?php echo $row->rekanancontact_name;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><?php echo date('d F Y',(strtotime($duedate))); ?></td>
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
        <td width="45%">
        <table border="0" width="100%">
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>
          <tr>
            <td width="16%" align="left">&nbsp;</td>
            <td width="84%" align="left">Shope Name :</td> 
          </tr>
          <tr>
            <td width="16%" align="left">&nbsp;</td>
            <td width="84%" align="left"><?php echo $row->rekananshipping_name; ?></td> 
          </tr>   
          <tr>
            <td width="16%" align="left">&nbsp;</td>
            <td width="84%" align="left">&nbsp;</td> 
          </tr>      
          <tr>
            <td width="16%" align="left">&nbsp;</td>
            <td width="84%" align="left">Unit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Area</td> 
          </tr>     
          <tr>
            <td width="16%" align="left">&nbsp;</td>
            <td width="84%" align="left"><?php echo $row->agreement_shopunit; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $row->agreement_space; ?></td> 
          </tr>    
          <tr>
            <td width="16%" align="left">&nbsp;</td>
            <td width="84%" align="left">&nbsp;</td> 
          </tr>      
          <tr>
            <td width="16%" align="right" style="height:30px">&nbsp;</td>
            <td width="84%" align="left" style="height:30px">&nbsp;</td> 
          </tr>     
          <tr>
            <td width="16%" align="right">&nbsp;</td>
            <td width="84%" align="left">&nbsp;</td> 
          </tr>     
          <tr>
            <td width="16%" align="left">&nbsp;</td>
            <td width="84%" align="left">&nbsp;</td> 
          </tr>    
   
          <tr>
            <td width="16%" align="right">&nbsp;</td>
            <td width="84%" align="left"><?php echo $row->rekanan_pkpname; ?></td> 
          </tr>   
          <tr>
            <td width="16%" align="left">&nbsp;</td>
            <td width="84%" align="left">Bank Mega KPO (IDR) Sudirman Jakarta. </td> 
          </tr> 
          <tr>
            <td width="16%" align="right">&nbsp;</td>
            <td width="84%" align="left"><?php echo $row->bank_rekening1; ?></td> 
          </tr>
          <tr>
            <td width="16%" align="left" style="height:30px">&nbsp;</td>
            <td width="84%" align="center" style="height:30px">&nbsp;</td> 
          </tr>   
          <tr>
            <td width="16%" align="right">&nbsp;</td>
            <td width="84%" align="center"><?php echo $region['region_fax'];?></td> 
          </tr>          
          <tr>
            <td align="left">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td width="16%" align="left">&nbsp;</td>
            <td width="84%" align="center"><?php echo $region['region_telp'];?></td> 
          </tr>
            
				  <?php                  
                for ($norut2; $norut2 < 4; $norut2++) {
                ?>
                      <tr>
                        <td width="16%" align="left" >&nbsp;</td>
                        <td width="84%" align="left" >&nbsp;</td>             
                      </tr>  
                <?php
                }
                    ?>                                                                                                                                  
        <tr>
            <td width="16%" align="right">&nbsp;</td>
            <td width="84%" align="left">&nbsp;</td> 
          </tr>
        </table>        
        </td>
        <td width="55%">
        <table border="0" style="border-collapse: collapse" width="100%">
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td width="60%" align="center">&nbsp;</td>
            <td width="33%" align="center">&nbsp;</td>
            <td width="7%" align="center">&nbsp;</td>            
          </tr>
          <tr>
            <td width="60%" align="left">&nbsp;</td>
            <td width="33%">&nbsp;</td>
            <td width="7%">&nbsp;</td>            
          </tr>  
          <tr>
            <td width="60%" align="left" style="height:30px">The Payment Of :</td>
            <td width="33%" style="height:30px">&nbsp;</td>
            <td width="7%" style="height:30px">&nbsp;</td>            
          </tr>   
          
 <?php
 		$t_total = 0;
		if(isset($result)){
			$no=1;
			$norut=1;			
			$ppn=0;
			$descr ='';
			$adm =0;
			$idr =0;
			$disc =0;
			$disc_percent ='';
			$ref_id='';
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
				$ref_id = $rowd->ref_id;								
				if ($rowd->agreementdetil_tax >0){
					//$ppn= $rowd->schedulepaymentdetil_tax;
					$ppn=((($rowd->schedulepaymentdetil_idr - $rowd->schedulepaymentdiscount_idr)* $rowd->agreementdetil_tax) / 100);
				}else{
					$ppn=0;
				}	
				
				$subttotal = ($idr - $disc) + $ppn;	
				$t_total =  $t_total + $subttotal ;
				$no++;
		    	$norut++;	
			?> 
                      
          <tr>
            <td width="60%" align="left"><?php echo $rowd->schedulepaymentdetil_descr; ?></td>
            <td width="33%" align="right">Rp.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($rowd->schedulepaymentdetil_idr,0); ?>&nbsp;&nbsp;</td>
            <td width="7%" align="right">&nbsp;</td>            
          </tr>
          <?php
		  if ($rowd->schedulepaymentdiscount_idr >0){			  
			  ?>
			  <tr>
				<td width="60%" align="left">Discount <?php echo $disc_percent; ?></td>
				<td width="33%" align="right" >Rp.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($rowd->schedulepaymentdiscount_idr,0); ?>&nbsp;&nbsp;</td>            
			  </tr>
              <tr>
            <td width="60%" align="left">Subtotal</td>
            <td width="33%" align="right">Rp.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($rowd->schedulepaymentdetil_idr - $rowd->schedulepaymentdiscount_idr,0); ?>&nbsp;&nbsp;</td>            
          </tr> 			  
		  <?php
		  }
		  else {
				?>							  
          <tr>
            <td width="60%" align="left"></td>
            <td width="33%" align="right"></td>            
          </tr>
          <tr>
            <td width="60%" align="left"></td>
            <td width="33%" align="right"></td>            
          </tr>    
			<?php
		  }
			?>
		  <?php
		  if ($rowd->agreementdetil_tax >0){			  
			  ?>
			  <tr>
				<td width="60%" align="left">Value added Tax <?php echo number_format($rowd->agreementdetil_tax,0); ?> %</td>
				<td width="33%" align="right">Rp.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($ppn,0); ?>&nbsp;&nbsp;</td>
				<td width="7%" align="right">&nbsp;</td>            
			  </tr> 			  
		  <?php
		  }
		  else {
				?>							  
          <tr>
            <td width="60%" align="left"></td>
            <td width="33%" align="right"></td>
            <td width="7%" align="right"></td>            
          </tr>    
			<?php
		  }
			?>
			
    <?php
	}}
        ?>
                  
      <?php
	  
	for ($norut; $norut < 20; $norut++) {
		$non ='';
	?>
          <tr>
            <td width="60%" align="left">&nbsp;</td>
            <td width="33%" align="right">&nbsp;</td>
            <td width="7%" align="right">&nbsp;</td>            
          </tr>  
    <?php
	}
        ?>
                          
          <tr>
            <td width="60%" align="left">&nbsp;</td>
            <td width="33%" align="right">Rp.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($t_total,0); ?>&nbsp;&nbsp;</td>
            <td width="7%" align="right">&nbsp;</td>            
          </tr>                                      
        </table>         
        </td>
  </tr>                                            
    </table>
    <table width="786" border="0"> 
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td width="14%" align="left">&nbsp;</td>
            <td width="42%" align="center">&nbsp;</td>
            <td width="18%" align="center">&nbsp;</td>
            <td width="18%" align="center">&nbsp;</td>
            <td width="3%" align="center">&nbsp;</td>            
          </tr>       
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td colspan="4" align="left">&nbsp;</td>
            <td width="3%" align="center">&nbsp;</td>            
          </tr>   
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td colspan="4" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_to_wordsnorp($t_total);?> Rupiah</td>
            <td width="3%" align="center">&nbsp;</td>            
          </tr>           
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td width="14%" align="left">&nbsp;</td>
            <td width="42%" align="right">&nbsp;</td>
            <td width="18%" align="right">&nbsp;</td>
            <td width="18%" align="right">&nbsp;</td>
            <td width="3%" align="center">&nbsp;</td>            
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
            <td align="right">&nbsp;</td>
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
            <td width="42%" align="left">: <?php echo $row->rekanan_name; ?></td>
            <td width="18%" align="center"><?php echo date('d F Y',(strtotime($duedate))); ?></td>
            <td width="18%" align="center">Rp. <?php echo number_format($t_total,0); ?></td>
            <td width="3%" align="center">&nbsp;</td>            
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">Shope Name</td>
            <td align="left">: <?php echo $row->rekananshipping_name; ?></td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">Address</td>
            <td align="left">: <?php echo $row->rekananshipping_address;?></td>
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