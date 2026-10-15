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
		$duedate = $row->schedulepaymentdetil_posteddate;
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
			$norut2 =1;
			
			foreach($invoice as $rowd){
				$jmlarr=count($result);
				$ppn=0;
				$adm = number_format($rowd->agreement_admpersen,0);
				$admidr = number_format($rowd->agreement_adm,0);	
				$idr = $rowd->schedulepaymentdetil_idr;								
						
				if ($rowd->agreementdetil_tax >0){
					$ppn= $rowd->schedulepaymentdetil_tax;
					//$ppn=$ppn+((($rowd->schedulepaymentdetil_idr)* $rowd->agreementdetil_tax) / 100);
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
 
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
  <tr>
    <td width="100%">&nbsp;
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td width="12%" align="left" valign="top" dir="ltr">
        <img border="0" src="<?php echo base_url('assets/img/' . $branch_logo);?>" width="116" height="124"></td>
        <td width="25%" align="left" valign="top"><font size="4"><b><?php echo $region['region_namereport']; ?></b></font><br>
        <font size="4"><b><?php echo $vregion; ?></b></font><br>      
        <?php echo $vregadres;?><br>
        N.P.W.P :<?php echo $region['region_npwp'];?><br>
        Phone : <?php echo $region['region_telp'];?><br>    
        Fax : <?php echo $region['region_fax'];?><br>                    
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
            <td>&nbsp;</td>
            <td colspan="2"><font size="6"><b><u><?php echo $vjudul; ?></u></b></font></td>
            </tr>
          <tr>
            <td width="66%" style="border-left: 1px solid #fff;">To :</td>
            <td width="4%">&nbsp;</td>
            <td width="13%">INVOICE NO</td>
            <td width="17%">: <?php echo $row->invoice_id; ?></td>
          </tr>
          <tr>
            <td><?php echo $row->rekanan_name; ?></td>
            <td>&nbsp;</td>
            <td>INVOICE DATE</td>
            <td>: <?php echo date('d F Y',(strtotime($invdate))); ?></td>
          </tr>
          <tr>
            <td><?php echo $row->rekananshipping_address;?></td>
            <td>&nbsp;</td>
            <td align="center" style="border-top: 1px solid #000; border-left: 1px solid #000;border-right: 1px solid #000; border-bottom: 1px solid #000;">Due Date</td>
            <td align="center" style="border-top: 1px solid #000; border-left: 1px solid #000;border-right: 1px solid #000; border-bottom: 1px solid #000;">Total Invoice</td>
          </tr>
          <tr>
            <td>Attn : <?php echo $row->rekanancontact_name;?></td>
            <td>&nbsp;</td>
            <td align="center" style="border-top: 1px solid #000; border-left: 1px solid #000;border-right: 1px solid #000; border-bottom: 1px solid #000;"><?php echo date('d F Y',(strtotime($duedate))); ?></td>
            <td align="center" style="border-top: 1px solid #000; border-left: 1px solid #000;border-right: 1px solid #000; border-bottom: 1px solid #000;">Rp. <?php echo number_format($t_total,0); ?></td>
          </tr>    
          <tr>
            <td></td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
          </tr>   
          <tr>
            <td></td>
            <td>&nbsp;</td>
            <td></td>
            <td></td>
          </tr>                         
        </table>
        </td>
      </tr>
    </table>
    <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
      <tr>
        <td width="38%">
        <table border="0" width="100%" style="border-top: 1px solid #000; border-left: 1px solid #000;border-right: 1px solid #000; border-bottom: 1px solid #000;">
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td width="95%" align="left">Shope Name :</td> 
            </tr>
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td width="95%" align="left"><?php echo $row->rekananshipping_name; ?></td> 
            </tr>   
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td width="95%" align="left">&nbsp;</td> 
            </tr>      
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td width="95%" align="left">Unit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Area</td> 
            </tr>     
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td width="95%" align="left"><?php echo $row->agreement_shopunit; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $row->agreement_space; ?></td> 
            </tr>    
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td width="95%" align="left">&nbsp;</td> 
            </tr>      
          <tr>
            <td width="5%" align="right">1.</td>
            <td width="95%" align="left">Payment Terms and Conditions  :</td> 
            </tr>     
          <tr>
            <td width="5%" align="right">&nbsp;</td>
            <td width="95%" align="left">This Invoice is Payable on or before 15 days after the invoice date</td> 
            </tr>     
          <tr>          
            <td width="5%" align="left">&nbsp;</td>
            <td width="95%" align="left">Payment should be transferred to out bank as follows :</td> 
            </tr>     
          <tr>          
            <td width="5%" align="left">&nbsp;</td>
            <td width="95%" align="left"><?php echo $row->rekanan_pkpname; ?></td> 
            </tr>     

          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td width="95%" align="left">Bank Mega KCU Makassar A/C No. <?php echo $row->bank_rekening1; ?></td> 
            </tr>    
   
          <tr>
            <td width="5%" align="right">2.</td>
            <td width="95%" align="left">Please fax copy of bank transfer slip to <?php echo $region['region_fax'];?></td> 
            </tr>   
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td width="95%" align="left">for our record</td> 
            </tr> 
          <tr>
            <td width="5%" align="right">3.</td>
            <td width="95%" align="left">For verification of this invoice,</td> 
            </tr>
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td width="95%" align="left">please call <?php echo $region['region_telp'];?></td> 
            </tr>   
          <tr>
            <td width="5%" align="right">4.</td>
            <td width="95%" align="left">Official receipt will only be issued upon </td> 
            </tr>          
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td width="95%" align="left">payment having been credited into our account</td> 
            </tr>   
          <tr>
            <td width="5%" align="left">&nbsp;</td>
            <td width="95%" align="left">&nbsp;</td> 
            </tr>
            
				  <?php                  
                for ($norut2; $norut2 < 10; $norut2++) {
                ?>
                      <tr>
                        <td width="5%" align="left">&nbsp;</td>
                        <td width="95%" align="left">&nbsp;</td>             
                      </tr>  
                <?php
                }
                    ?>                                                                                                                                  
        </table>        
        </td>
        <td width="62%">
        <table border="0" style="border-collapse: collapse" width="100%">
          <tr>
            <td width="54%" align="center" style="border-top: 1px solid #000; border-left: 1px solid #000;border-right: 1px solid #000; border-bottom: 1px solid #000;">DESCRIPTION</td>
            <td width="46%" align="center" style="border-top: 1px solid #000; border-left: 1px solid #000;border-right: 1px solid #000; border-bottom: 1px solid #000;">AMOUNT</td>            
          </tr>
          <tr>
            <td width="54%" align="left" style="border-left: 1px solid #000;border-right: 1px solid #000; ">The Payment Of :</td>
            <td width="46%" style="border-left: 1px solid #000;border-right: 1px solid #000; ">&nbsp;</td>            
          </tr>  
          <tr>
            <td width="54%" align="left" style="border-left: 1px solid #000;border-right: 1px solid #000; ">&nbsp;</td>
            <td width="46%" style="border-left: 1px solid #000;border-right: 1px solid #000; ">&nbsp;</td>            
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
			foreach($invoice as $rowd){
				$jmlarr=count($result);
				$ppn=0;
				$adm = number_format($rowd->agreement_admpersen,0);
				$admidr = number_format($rowd->agreement_adm,0);	
				$idr = $rowd->schedulepaymentdetil_idr;	
				$disc = $rowd->schedulepaymentdiscount_idr;							
				$ref_id = $rowd->ref_id;								
				if ($rowd->agreementdetil_tax >0){
					$ppn= ((($rowd->schedulepaymentdetil_idr - $rowd->schedulepaymentdiscount_idr) * $rowd->agreementdetil_tax)/100);
					//$ppn=$ppn+((($rowd->schedulepaymentdetil_idr - $rowd->schedulepaymentdiscount_idr)* $rowd->agreementdetil_tax) / 100);
				}else{
					$ppn=0;
				}	
				
				$subttotal = ($idr - $disc) + $ppn;	
				$t_total =  $t_total + $subttotal ;
				$no++;
		    	$norut++;	
			?> 
                      
          <tr>
            <td width="54%" align="left" style="border-left: 1px solid #000;border-right: 1px solid #000; "><?php echo $rowd->schedulepaymentdetil_descr; ?></td>
            <td width="46%" align="right" style="border-left: 1px solid #000;border-right: 1px solid #000; ">Rp.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($rowd->schedulepaymentdetil_idr,0); ?>&nbsp;&nbsp;</td>            
          </tr>
          <?php
		  if ($rowd->schedulepaymentdiscount_percent >0){			  
			  ?>
			  <tr>
				<td width="54%" align="left" style="border-left: 1px solid #000;border-right: 1px solid #000; ">Discount <?php echo number_format($rowd->schedulepaymentdiscount_percent,0); ?> %</td>
				<td width="46%" align="right" style="border-left: 1px solid #000;border-right: 1px solid #000; ">Rp.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($rowd->schedulepaymentdiscount_idr,0); ?>&nbsp;&nbsp;</td>            
			  </tr>
              <tr>
                <td width="54%" align="left" style="border-left: 1px solid #000;border-right: 1px solid #000; ">Subtotal</td>
                <td width="46%" align="right" style="border-left: 1px solid #000;border-right: 1px solid #000; ">Rp.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($rowd->schedulepaymentdetil_idr - $rowd->schedulepaymentdiscount_idr,0); ?>&nbsp;&nbsp;</td>            
              </tr> 			  
		  <?php
		  }
		  else {
				?>							  
          <tr>
            <td width="54%" align="left" style="border-left: 1px solid #000;border-right: 1px solid #000; "></td>
            <td width="46%" align="right" style="border-left: 1px solid #000;border-right: 1px solid #000; "></td>            
          </tr> 
          <tr>
            <td width="54%" align="left" style="border-left: 1px solid #000;border-right: 1px solid #000; "></td>
            <td width="46%" align="right" style="border-left: 1px solid #000;border-right: 1px solid #000; "></td>            
          </tr>   
			<?php
		  }
			?>
		  <?php
		  if ($rowd->agreementdetil_tax >0){			  
			  ?>
			  <tr>
				<td width="54%" align="left" style="border-left: 1px solid #000;border-right: 1px solid #000; ">Value added Tax <?php echo number_format($rowd->agreementdetil_tax,0); ?> %</td>
				<td width="46%" align="right" style="border-left: 1px solid #000;border-right: 1px solid #000; ">Rp.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($rowd->schedulepaymentdetil_tax,0); ?>&nbsp;&nbsp;</td>            
			  </tr> 			  
		  <?php
		  }
		  else {
				?>							  
          <tr>
            <td width="54%" align="left" style="border-left: 1px solid #000;border-right: 1px solid #000; "></td>
            <td width="46%" align="right" style="border-left: 1px solid #000;border-right: 1px solid #000; "></td>            
          </tr>    
			<?php
		  }
			?>
			
    <?php
	}}
        ?>
                  
      <?php
	  
	for ($norut; $norut < 25; $norut++) {
		$non ='';
	?>
          <tr>
            <td width="54%" align="left" style="border-left: 1px solid #000;border-right: 1px solid #000;">&nbsp;</td>
            <td width="46%" align="right" style="border-left: 1px solid #000;border-right: 1px solid #000; ">&nbsp;</td>            
          </tr>  
    <?php
	}
        ?>
                          
          <tr>
            <td width="54%" align="left" style="border-top: 1px solid #000; border-left: 1px solid #000;border-right: 1px solid #000; border-bottom: 1px solid #000;">TOTAL BILLING</td>
            <td width="46%" align="right" style="border-top: 1px solid #000; border-left: 1px solid #000;border-right: 1px solid #000; border-bottom: 1px solid #000;">Rp.&nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($t_total,0); ?>&nbsp;&nbsp;</td>            
          </tr>                                      
        </table>         
        </td>
        </tr>                                            
    </table>

    <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%"> 
          <tr>
            <td width="72%" align="left">&nbsp;</td>
            <td width="28%" align="center">&nbsp;</td>            
          </tr>       
          <tr>
            <td width="72%" align="left">Say/Terbilang</td>
            <td width="28%" align="center"><?php echo $region['region_namereport']; ?></td>            
          </tr>   
          <tr>
            <td width="72%" align="left">&nbsp;&nbsp; <?php echo number_to_wordsnorp($t_total);?> Rupiah</td>
            <td width="28%" align="center">&nbsp;</td>            
          </tr>   
          <tr>
            <td width="72%" align="left">&nbsp;</td>
            <td width="28%" align="center">&nbsp;</td>            
          </tr> 
          <tr>
            <td width="72%" align="left">&nbsp;</td>
            <td width="28%" align="center">&nbsp;</td>            
          </tr> 
          <tr>
            <td width="72%" align="left">&nbsp;</td>
            <td width="28%" align="center">&nbsp;</td>            
          </tr>           
          <tr>
            <td width="72%" align="left">&nbsp;</td>
            <td width="28%" align="center">&nbsp;</td>            
          </tr>           
          <tr>
            <td width="72%" align="left">&nbsp;</td>
            <td width="28%" align="center"><?php echo $row->region_signature; ?></td>            
          </tr>   
          <tr>
            <td width="72%" align="left">&nbsp;</td>
            <td width="28%" align="center">&nbsp;</td>            
          </tr>                                     
    </table>

<table cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td>&nbsp;</td>        
      </tr>
      <tr>
        <td style="border-top: 1px solid #000;">&nbsp;</td>        
      </tr>
      <tr>
        <td>
        <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
          <tr>
            <td width="14%" style="border-left: 1px solid #fff;">Tenant Name</td>
            <td width="56%">: <?php echo $row->rekanan_name; ?></td>
            <td width="13%">INVOICE NO</td>
            <td width="17%">: <?php echo $row->invoice_id; ?></td>
          </tr>
          <tr>
            <td>Shope Name</td>
            <td>: <?php echo $row->rekananshipping_name; ?></td>
            <td>INVOICE DATE</td>
            <td>: <?php echo date('d F Y',strtotime($invdate)); ?></td>
          </tr>
          <tr>
            <td>Address</td>
            <td>: <?php echo $row->rekananshipping_address;?></td>
            <td align="center" style="border-top: 1px solid #000; border-left: 1px solid #000;border-right: 1px solid #000; border-bottom: 1px solid #000;">Due Date</td>
            <td align="center" style="border-top: 1px solid #000; border-left: 1px solid #000;border-right: 1px solid #000; border-bottom: 1px solid #000;">Total Invoice</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="center" style="border-top: 1px solid #000; border-left: 1px solid #000;border-right: 1px solid #000; border-bottom: 1px solid #000;"><?php echo date('d F Y',(strtotime($duedate))); ?></td>
            <td align="center" style="border-top: 1px solid #000; border-left: 1px solid #000;border-right: 1px solid #000; border-bottom: 1px solid #000;">Rp. <?php echo number_format($t_total,0); ?></td>
          </tr>    
          <tr>
            <td></td>
            <td>&nbsp;</td>
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