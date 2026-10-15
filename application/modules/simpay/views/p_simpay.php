<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
@font-face {
    font-family: 'arial'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/arial.ttf');?>'); /*URL to font*/
}
body {font-family: 'arial';font-size: 9pt}
@page { margin-left:3cm; margin-right:1cm; margin-top:2.5cm;margin-bottom:1.5cm;size:8.27in 11.69in;}
.style3 {font-size: 10pt; }
</style>
</head>
<body>

 <?php      
    
 if(isset($form)){
	foreach($form as $row){ 

?>    

<htmlpageheader name="firstpage" style="display:none">
  <div style="text-align:center">
  </div>
</htmlpageheader>

<htmlpageheader name="otherpages" style="display:none">
  <div style="border-top: 0px solid #000000; font-size: 9pt; text-align: right; padding-top: 3mm; ">
    {PAGENO}/{nb}
  </div>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<div style="border-top: 0px solid #000000; font-size: 6pt; text-align: center; padding-top: 3mm; ">
<?php  ?>
</div>
</htmlpagefooter>

<sethtmlpageheader name="firstpage" value="on" show-this-page="1"/>
<sethtmlpageheader name="otherpages" value="on"/>
<sethtmlpagefooter name="myfooter" value="on" />

<table width="800" border="0">
  <tr>
    <td width="626" align="center">
      <p class="style3"><b>Simulation Payment</b></p>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
  <table width="800" border="0">
  <tr>
    <td><b>Calculation</b></td>    
    <td colspan="9"><?php echo $row->itype;?></td>
  </tr>
  <tr>
    <td width="153"><b>Luas Area</b></td>    
    <td width="29">&nbsp;</td>
    <td width="79" align="right"><?php echo $row->sim_space;?></td>
    <td width="62">/m2</td>
    <td width="33">&nbsp;</td>
    <td width="169"><b>Security Deposit</b></td>
    <td width="83" align="right"><?php echo $row->sim_depo_rent;?></td>
    <td width="54">Bulan</td>
    <td width="100">Rental</td>
  </tr>
  <tr>
    <td><b>Leasing Period</b></td>    
    <td>&nbsp;</td>
    <td align="right"><?php echo $row->sim_term;?></td>
    <td>Bulan</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><?php echo $row->sim_depo_sc;?></td>
    <td>Bulan</td>
    <td>Service Charge</td>
  </tr>
  <tr>
    <td><b>Payment Term</b></td>    
    <td>&nbsp;</td>
    <td align="right"><?php echo $row->sim_payterm;?></td>
    <td>Bulan</td>
    <td>&nbsp;</td>
    <td><b>Service Charge (1st Year)</b></td>
    <td align="right"><?php echo number_format($row->sim_sc); ?></td>
    <td>Rp</td>
    <td align="right"><?php echo number_format($row->sim_sc_val); ?></td>
  </tr> 
  <tr>
    <td><b>Baserent</b></td>
    <td>Rp</td>
    <td align="right"><?php echo number_format($row->sim_baserent,0);?></td>
    <td>/m2</td>
    <td>&nbsp;</td>
    <td><b>Promotion Levy (1st Year)</b></td>
    <td align="right"><?php echo number_format($row->sim_pl,0); ?> </td>
    <td>Rp</td>
    <td align="right"><?php echo number_format($row->sim_pl_val, 0);?></td>
  </tr>
  <tr>
    <td><b>Total Rent</b></td>
    <td>Rp</td>
    <td align="right"><?php echo number_format($row->sim_totalrent,0);?></td>
    <td></td>
    <td>&nbsp;</td>
    <td></td>
  </tr>   
    <tr>
    <td><b>Booking Fee</b></td>
    <td>Rp</td>
    <td align="right"><?php echo number_format($row->sim_fee_per,0);?></td>
    <td align="right"><?php echo number_format($row->sim_fee_val,0);?></td>
    <td>&nbsp;</td>
    <td></td>
  </tr>   
  <tr>
    <td><b>ARP</b></td>
    <td>Rp</td>
    <td align ="right"><?php echo number_format($row->sim_arp_per,0);?></td>
    <td align ="right"><?php echo number_format($row->sim_arp_val,0);?></td>
    <td>&nbsp; </td>
    <td></td>
  </tr>
  <tr>
    <td><b>Angsuran per bulan</b></td>
    <td>Rp</td>
    <td align ="right"><?php echo number_format($row->sim_angsuran,0);?></td>
    <td align ="right"></td>
    <td>&nbsp; </td>
    <td></td>
  </tr>    
  <tr>
    <td><b>Total payment per bulan</b></td>
    <td>Rp</td>
    <td align ="right"><?php echo number_format($row->sim_payment,0);?></td>
    <td align ="right"></td>
    <td>&nbsp; </td>
    <td></td>
  </tr>  
</table>
<br>
<table width="800" border="0">
  <tr>
    <td colspan="2"><u><b>Tabel Arus Kas</b></u></td>
    <td width="468">&nbsp;</td>
    <td width="30">&nbsp;</td>
    <td width="36">&nbsp;</td>
  </tr> 
</table>
<table border ="1" style='font-size: 0.8em; border-collapse:1px solid'>
 <thead>
  <tr>
    <th>#</th>
<?php 
 $i =0;

 //print_r($collabel);
  foreach($collabel as $col_title){
    //$exp_title = explode('|', $col_title);
    //$_title = $exp_title[1];
?>    
    <th>&nbsp;<?php echo $col_title;?></th> 
<?php 
  }
?>
    <th>Arus Kas</th>
  </tr>
 </thead>
<tbody>
<?php
  foreach($rowlabel as $row_title){
?>    
    <tr>
      <td align='right'>&nbsp;<?php echo $row_title;?>&nbsp;</td>
<?php
    foreach($collabel as $col_title){
      $i = $col_title.'_'.$row_title;     

      if (isset($zcross_tab[$i])){        
?>
        <td align="right">&nbsp;<?php echo number_format($zcross_tab[$i],0);?>&nbsp;</td>
<?php     
      }else{
?>      
        <td align="right">&nbsp;</td>      
<?php      
      }
    }
?>      <td align="right"><b>&nbsp;<?php echo number_format($xtotal[$row_title],0);?>&nbsp;</b></td>  
    </tr>
<?php  
  }
?>
    <tr><td align="right"><b>&nbsp;Sub Total&nbsp;</b></td>
<?php
    $grand_total = 0;

    foreach($collabel as $col_title){
        $grand_total += $ytotal[$col_title];
?>
        <td align="right"><b>&nbsp;<?php echo number_format($ytotal[$col_title],0);?></b>&nbsp;</td>
<?php    
    }
?>      
        <td align="right"><b>&nbsp;<?php echo number_format($grand_total,0);?>&nbsp;</b></td>    
    </tr>
  </tbody>
</table> 
<?php }}?>
</body>
</html>