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
		$duedate = $row->schedulepaymentdetil_duedate;
		$invdate = $row->schedulepaymentdetil_posteddate;
		if (substr($vnomorinv,0,1) == 'CN') {
			$vjudul='CREDIT NOTE';
			}
				
				
		if ($vnomorinv != $vnomorinv2) {
			$vnomorinv2=$row->invoice_id;
//		echo $vregion;
		//exit;
		
		
?> 

<?php
		if(isset($result)){
			$no=1;
			$norut=1;			
			$ppn=0;
			$descr ='';
			$adm =0;
			$idr =0;
			$disc =0;
			$norut2 =1;
			
			foreach($invoice as $rowd){
				$jmlarr=count($result);
				$ppn=0;
				$adm = number_format($rowd->agreement_admpersen,0);
				$admidr = number_format($rowd->agreement_adm,0);	
				$idr = $rowd->schedulepaymentdetil_idr;
				$disc = $rowd->schedulepaymentdiscount_idr;								
						
				if ($rowd->agreementdetil_tax >0){
					//$ppn= $rowd->schedulepaymentdetil_tax;
				$ppn=((($rowd->schedulepaymentdetil_idr - $rowd->schedulepaymentdiscount_idr)* $rowd->agreementdetil_tax) / 100);
				}else{
					$ppn=0;
				}	
				
				$subttotal = ($idr - $disc);	
				$t_total =  $t_total + $subttotal + $ppn;	
				
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
					//$duedate = date('Y-m-d', strtotime('+15 days', strtotime($invdate)));
				}
				elseif ($agreementtype_type == 'PS'){					 
					//$duedate = date('Y-m-d', strtotime('+15 days', strtotime($invdate)));
				}
				else
				{
					//$duedate = date('Y-m-d', strtotime('+20 days', strtotime($invdate)));
					}
				
			}}
?> 
 
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
  <tr>
    <td width="100%">&nbsp;
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td width="12%" align="left" valign="top" dir="ltr">&nbsp;</td>
        <td width="25%" align="left" valign="top"><br>                    
        </td>      
        <td width="36%"></td>  
        <td width="27%" align="left" valign="bottom">        
        </td>
      </tr>
    </table>
    <br>
     <table cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td>&nbsp;</td>        
      </tr>
      <tr>
        <td>
        <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
          <tr>
            <td style="border-left: 1px solid #fff;">&nbsp;</td>
            <td style="border-left: 1px solid #fff;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="border-left: 1px solid #fff;">&nbsp;</td>
            <td style="border-left: 1px solid #fff;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="border-left: 1px solid #fff;">&nbsp;</td>
            <td style="border-left: 1px solid #fff;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>                              
          <tr>
            <td style="border-left: 1px solid #fff;">&nbsp;</td>
            <td style="border-left: 1px solid #fff;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="border-left: 1px solid #fff;">&nbsp;</td>
            <td style="border-left: 1px solid #fff;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="border-left: 1px solid #fff;">&nbsp;</td>
            <td style="border-left: 1px solid #fff;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>                              
          <tr>
            <td width="5%" style="border-left: 1px solid #fff;">&nbsp;</td>
            <td width="49%" style="border-left: 1px solid #fff;">To :</td>
            <td width="6%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="16%"><?php echo $row->invoice_id; ?></td>
            <td width="4%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><?php echo $row->rekanan_name; ?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo date('d F Y',(strtotime($invdate))); ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><?php echo $row->rekananshipping_address;?></td>
            <td>&nbsp;</td>
            <td align="center" >&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center" >&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Attn : <?php echo $row->rekanancontact_name;?></td>
            <td>&nbsp;</td>
            <td align="center" >&nbsp;</td>
            <td align="center" >&nbsp;</td>
            <td align="center" >&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center" ><?php echo date('d F Y',(strtotime($duedate))); ?></td>
            <td align="center" >Rp. <?php echo number_format($t_total,0); ?></td>
            <td align="center" >&nbsp;</td>
          </tr>    
          <tr>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>      
          <tr>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
          </tr> 
          <tr>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
          </tr> 
          <tr>
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>                                                  
        </table>
        </td>
      </tr>
    </table>
    <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
      <tr>
        <td width="35%">
        <table border="0" width="100%">
          <tr>
            <td width="18%" align="left">&nbsp;</td>
            <td width="82%" align="left">Shope Name :</td> 
            </tr>
          <tr>
            <td width="18%" align="left">&nbsp;</td>
            <td width="82%" align="left"><?php echo $row->rekananshipping_name; ?></td> 
            </tr>   
          <tr>
            <td width="18%" align="left">&nbsp;</td>
            <td width="82%" align="left">&nbsp;</td> 
            </tr>      
          <tr>
            <td width="18%" align="left">&nbsp;</td>
            <td width="82%" align="left">Unit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Area</td> 
            </tr>     
          <tr>
            <td width="18%" align="left">&nbsp;</td>
            <td width="82%" align="left"><?php echo $row->agreement_shopunit; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $row->agreement_space; ?></td> 
            </tr>    
          <tr>
            <td width="18%" align="left">&nbsp;</td>
            <td width="82%" align="left">&nbsp;</td> 
            </tr>      
          <tr>
            <td width="18%" align="right">&nbsp;</td>
            <td width="82%" align="left">&nbsp;</td> 
            </tr>     
          <tr>
            <td width="18%" align="right">&nbsp;</td>
            <td width="82%" align="left">&nbsp;</td> 
            </tr>     
          <tr>          
            <td width="18%" align="left">&nbsp;</td>
            <td width="82%" align="left">&nbsp;</td> 
            </tr>     
          <tr>          
            <td width="18%" align="left">&nbsp;</td>
            <td width="82%" align="left">&nbsp;</td> 
            </tr>     

          <tr>
            <td width="18%" align="left">&nbsp;</td>
            <td width="82%" align="left">&nbsp;</td> 
          </tr>
          <?php if ($row->isVirtualAccount) { ?>            
            <tr>
              <td width="18%" align="right">&nbsp;</td>
              <td width="82%" align="left"><?=$row->rekanan_pkpname?></td> 
            </tr>   
            <tr>
              <td width="18%" align="left">&nbsp;</td>
              <td width="82%" align="left"><?=$row->bank_name2?> A/C No. </td> 
            </tr> 
            <tr>
              <td width="18%" align="right">&nbsp;</td>
              <td width="82%" align="left"><?php echo $row->bank_rekening2; ?></td> 
            </tr>
          <?php 
          } else {
          ?>
            <tr>
              <td width="18%" align="right">&nbsp;</td>
              <td width="82%" align="left"><?=$region['region_namereport']?></td> 
            </tr>   
            <tr>
              <td width="18%" align="left">&nbsp;</td>
              <td width="82%" align="left"><?=$row->bank_name1?> A/C No. </td> 
            </tr> 
            <tr>
              <td width="18%" align="right">&nbsp;</td>
              <td width="82%" align="left"><?php echo $row->bank_rekening1; ?></td> 
            </tr> 
          <?php } 
          ?>
          <tr>
            <td width="18%" align="left">&nbsp;</td>
            <td width="82%" align="left">(021) 79182430</td> 
            </tr>   
          <tr>
            <td width="18%" align="right">&nbsp;</td>
            <td width="82%" align="left">&nbsp;</td> 
            </tr>          
          <tr>
            <td width="18%" align="left">&nbsp;</td>
            <td width="82%" align="left">&nbsp;</td> 
            </tr>   
          <tr>
            <td width="18%" align="left">&nbsp;</td>
            <td width="82%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(021) 79175522</td> 
            </tr>
            
				  <?php                  
                for ($norut2; $norut2 < 10; $norut2++) {
                ?>
                      <tr>
                        <td width="18%" align="left">&nbsp;</td>
                        <td width="82%" align="left">&nbsp;</td>             
                      </tr>  
                <?php
                }
                    ?>                                                                                                                                  
        </table>        
        </td>
        <td width="65%">
        <table border="0" style="border-collapse: collapse" width="100%">
          <tr>
            <td width="61%" align="center">&nbsp;</td>
            <td width="33%" align="center">&nbsp;</td>
            <td width="6%" align="center">&nbsp;</td>            
          </tr>
          <tr>
            <td width="61%" align="left">The Payment Of :</td>
            <td width="33%">&nbsp;</td>
            <td width="6%">&nbsp;</td>            
          </tr>  
          <tr>
            <td width="61%" align="left">&nbsp;</td>
            <td width="33%">&nbsp;</td>
            <td width="6%">&nbsp;</td>            
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
			$ref_id='';
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
				$ref_id = $rowd->ref_id;								
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
				
				$no++;
		    	$norut++;	
			?> 
                      
          <tr>
            <td width="61%" align="left"><?php echo $rowd->schedulepaymentdetil_descr; ?></td>
            <td width="33%" align="right">Rp.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($rowd->schedulepaymentdetil_idr,0); ?>&nbsp;&nbsp;</td>
            <td width="6%" align="right">&nbsp;</td>            
          </tr>
          
           
			  <tr>
				<td width="54%" align="left"><?php echo $disc_str; ?></td>
				<td width="46%" align="right" ><?php echo $disc_idr; ?>&nbsp;&nbsp;</td>            
			  </tr>
              <tr>
            <td width="54%" align="left"><?php echo $subtotal_str; ?></td>
            <td width="46%" align="right"><?php echo $subtotal_idr; ?>&nbsp;&nbsp;</td>            
          </tr> 			  
		  							  
               
		 
                      
		   
			  <tr>
				<td width="61%" align="left"><?php echo $tax_str; ?></td>
				<td width="33%" align="right"><?php echo $tax_idr; ?>&nbsp;&nbsp;</td>
				<td width="6%" align="right">&nbsp;</td>            
			  </tr> 			  
		   
			
    <?php
	}}
        ?>
                  
      <?php
	  
	for ($norut; $norut < 22; $norut++) {
		$non ='';
	?>
          <tr>
            <td width="61%" align="left">&nbsp;</td>
            <td width="33%" align="right">&nbsp;</td>
            <td width="6%" align="right">&nbsp;</td>            
          </tr>  
    <?php
	}
        ?>
                          
          <tr>
            <td width="61%" align="left">&nbsp;</td>
            <td width="33%" align="right">Rp.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($t_total,0); ?>&nbsp;&nbsp;</td>
            <td width="6%" align="right">&nbsp;</td>            
          </tr>                                      
        </table>         
        </td>
        </tr>                                            
    </table>

    <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%"> 
          <tr>
            <td width="7%" align="left">&nbsp;</td>
            <td width="37%" align="left">&nbsp;</td>
            <td width="53%" align="center">&nbsp;</td>
            <td width="3%" align="center">&nbsp;</td>            
          </tr>       
          <tr>
            <td width="7%" align="left">&nbsp;</td>
            <td colspan="2" align="left"><?php echo number_to_wordsnorp(round($t_total,0));?> Rupiah</td>
            <td width="3%" align="center">&nbsp;</td>            
          </tr>   
          <tr>
            <td width="7%" align="left">&nbsp;</td>
            <td width="37%" align="left">&nbsp;</td>
            <td width="53%" align="center">&nbsp;</td>
            <td width="3%" align="center">&nbsp;</td>            
          </tr>           
          <tr>
            <td width="7%" align="left">&nbsp;</td>
            <td width="37%" align="left">&nbsp;</td>
            <td width="53%" align="right"><?php echo $row->region_signature; ?></td>
            <td width="3%" align="center">&nbsp;</td>            
          </tr>   
          <tr>
            <td width="7%" align="left">&nbsp;</td>
            <td width="37%" align="left">&nbsp;</td>
            <td width="53%" align="right"><p>CP Collection staf : Anita 081311462003, Nindy 081120056604, Winona 082210573215</p></td>
            <td width="3%" align="center">&nbsp;</td>            
          </tr>                                     
    </table>

<table cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td>&nbsp;</td>        
      </tr>
      <tr>
        <td>&nbsp;</td>        
      </tr>
      <tr>
        <td>
        <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
          <tr>
            <td style="border-left: 1px solid #fff;">&nbsp;</td>
            <td style="border-left: 1px solid #fff;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="7%" style="border-left: 1px solid #fff;">&nbsp;</td>
            <td width="12%" style="border-left: 1px solid #fff;">&nbsp;</td>
            <td width="42%">&nbsp;</td>
            <td width="19%">&nbsp;</td>
            <td width="17%"><?php echo $row->invoice_id; ?></td>
            <td width="3%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo date('d F Y',strtotime($invdate)); ?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><span style="border-left: 1px solid #fff;">Tenant Name</span></td>
            <td>: <?php echo $row->rekanan_name; ?></td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Shope Name</td>
            <td>: <?php echo $row->rekananshipping_name; ?></td>
            <td align="center"><?php echo date('d F Y',(strtotime($duedate))); ?></td>
            <td align="center">Rp. <?php echo number_format($t_total,0); ?></td>
            <td align="center">&nbsp;</td>
          </tr>    
          <tr>
            <td></td>
            <td>Address</td>
            <td>: <?php echo $row->rekananshipping_address;?></td>
            <td></td>
            <td></td>
            <td></td>
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