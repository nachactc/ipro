


<?php  
  if ($button == 'EXCEL')
  {

	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename=".$region_name." - ".$branch_name.".xls");
  } 
 ?>
 
 <title>Summary Monthly Invoice List</title>
 
<style type="text/css">

.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-0rzf{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-ldj7{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:#000000;text-align:center;vertical-align:top}
.tg .tg-iuhm{font-size:10px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top;}
.tg .tg-73lx{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:#000000;vertical-align:top}
.tg .tg-ur0i{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;text-align:center;vertical-align:top}
.tg .tg-vbnk{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;vertical-align:top}
.tg .tg-li00{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;background-color:#ffffff;border-color:#000000;text-align:center;vertical-align:top}
.head1{font-size:14px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
.head2{font-size:12px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
</style>


</head>
<br />

<body>


<p>Summary  Monthly Invoice Rental</p>
<table width="942" border="0">
  <tr>
    <td width="155">Periode</td>
    <td width="381">:  <?php echo date('d-M-Y',strtotime($start_date)); ?>  s/d <?php echo date('d-M-Y',strtotime($end_date)); ?></td>
    <td width="130">Business Unit</td>
    <td width="258">:  <?php echo $region_name; ?></td>
  </tr>
  <tr>
    <td>Store</td>
    <td>:  <?php echo $branch_name; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>      
</table>


 </br>

<table class="tg" width="1068" border="0">
  <tr>
    <td class="tg-li00">&nbsp;</td>
    <td class="tg-li00">&nbsp;</td>
    <td class="tg-li00">&nbsp;</td>
    <td colspan="13" class="tg-li00">IN</td>
    <td colspan="13" class="tg-li00">SC</td>
    <td colspan="13" class="tg-li00">OR</td>
    <td colspan="13" class="tg-li00">PS</td>
  </tr>
  <tr>
        <td width="4%" class="tg-li00">Category</td>
        <td width="5%" class="tg-li00">Property</td>        
        <td width="7%" class="tg-li00">Store Code</td>
        <td width="7%" class="tg-li00">Jan</td>                                         
    	<td width="7%" class="tg-li00">Feb</td>
        <td width="7%" class="tg-li00">Mar</td>
        <td width="7%" class="tg-li00">Apr</td>  
        <td width="7%" class="tg-li00">Mei</td>
        <td width="7%" class="tg-li00">Jun</td>
        <td width="7%" class="tg-li00">Jul</td>
        <td width="7%" class="tg-li00">Aug</td>
        <td width="7%" class="tg-li00">Sep</td>
        <td width="7%" class="tg-li00">Okt</td>
        <td width="7%" class="tg-li00">Nov</td>        
        <td width="7%" class="tg-li00">Des</td>
        <td width="7%" class="tg-li00">Total IN</td>
        <td width="7%" class="tg-li00">Jan</td>                                         
    	<td width="7%" class="tg-li00">Feb</td>
        <td width="7%" class="tg-li00">Mar</td>
        <td width="7%" class="tg-li00">Apr</td>  
        <td width="7%" class="tg-li00">Mei</td>
        <td width="7%" class="tg-li00">Jun</td>
        <td width="7%" class="tg-li00">Jul</td>
        <td width="7%" class="tg-li00">Aug</td>
        <td width="7%" class="tg-li00">Sep</td>
        <td width="7%" class="tg-li00">Okt</td>
        <td width="7%" class="tg-li00">Nov</td>        
        <td width="7%" class="tg-li00">Des</td>
        <td width="7%" class="tg-li00">Total SC</td>
        <td width="7%" class="tg-li00">Jan</td>                                         
    	<td width="7%" class="tg-li00">Feb</td>
        <td width="7%" class="tg-li00">Mar</td>
        <td width="7%" class="tg-li00">Apr</td>  
        <td width="7%" class="tg-li00">Mei</td>
        <td width="7%" class="tg-li00">Jun</td>
        <td width="7%" class="tg-li00">Jul</td>
        <td width="7%" class="tg-li00">Aug</td>
        <td width="7%" class="tg-li00">Sep</td>
        <td width="7%" class="tg-li00">Okt</td>
        <td width="7%" class="tg-li00">Nov</td>        
        <td width="7%" class="tg-li00">Des</td>
        <td width="7%" class="tg-li00">Total OR</td>
        <td width="7%" class="tg-li00">Jan</td>                                         
    	<td width="7%" class="tg-li00">Feb</td>
        <td width="7%" class="tg-li00">Mar</td>
        <td width="7%" class="tg-li00">Apr</td>  
        <td width="7%" class="tg-li00">Mei</td>
        <td width="7%" class="tg-li00">Jun</td>
        <td width="7%" class="tg-li00">Jul</td>
        <td width="7%" class="tg-li00">Aug</td>
        <td width="7%" class="tg-li00">Sep</td>
        <td width="7%" class="tg-li00">Okt</td>
        <td width="7%" class="tg-li00">Nov</td>        
        <td width="7%" class="tg-li00">Des</td>
        <td width="7%" class="tg-li00">Total PS</td>                                                       
  </tr>
<?php
$total_januari_IN=0;
$total_febuari_IN=0;
$total_maret_IN=0;
$total_april_IN=0;
$total_mei_IN=0;
$total_juni_IN=0;
$total_juli_IN=0;
$total_agustus_IN=0;
$total_september_IN=0;
$total_oktober_IN=0;
$total_november_IN=0;
$total_desember_IN=0;

$total_januari_SC=0;
$total_febuari_SC=0;
$total_maret_SC=0;
$total_april_SC=0;
$total_mei_SC=0;
$total_juni_SC=0;
$total_juli_SC=0;
$total_agustus_SC=0;
$total_september_SC=0;
$total_oktober_SC=0;
$total_november_SC=0;
$total_desember_SC=0;   

$total_januari_OR=0;
$total_febuari_OR=0;
$total_maret_OR=0;
$total_april_OR=0;
$total_mei_OR=0;
$total_juni_OR=0;
$total_juli_OR=0;
$total_agustus_OR=0;
$total_september_OR=0;
$total_oktober_OR=0;
$total_november_OR=0;
$total_desember_OR=0; 

$total_januari_PS=0;
$total_febuari_PS=0;
$total_maret_PS=0;
$total_april_PS=0;
$total_mei_PS=0;
$total_juni_PS=0;
$total_juli_PS=0;
$total_agustus_PS=0;
$total_september_PS=0;
$total_oktober_PS=0;
$total_november_PS=0;
$total_desember_PS=0; 

$subtotal_IN=0;
$subtotal_SC=0;
$subtotal_OR=0;
$subtotal_PS=0;

$grandtotal_IN=0;
$grandtotal_SC=0;
$grandtotal_OR=0;
$grandtotal_PS=0;

if(isset($result)){
foreach($result as $row){
	$total_januari_IN= $total_januari_IN + $row->Januari_IN;
	$total_febuari_IN= $total_febuari_IN + $row->Febuari_IN;
	$total_maret_IN= $total_maret_IN + $row->Maret_IN;
	$total_april_IN= $total_april_IN + $row->April_IN;
	$total_mei_IN= $total_mei_IN + $row->Mei_IN;
	$total_juni_IN= $total_juni_IN + $row->Juni_IN;
	$total_juli_IN= $total_juli_IN + $row->Juli_IN;
	$total_agustus_IN= $total_agustus_IN + $row->Agustus_IN;
	$total_september_IN= $total_september_IN + $row->September_IN;
	$total_oktober_IN= $total_oktober_IN + $row->Oktober_IN;
	$total_november_IN= $total_november_IN + $row->November_IN;
	$total_desember_IN= $total_desember_IN + $row->Desember_IN;
	
	$subtotal_IN= $row->Januari_IN + $row->Febuari_IN + $row->Maret_IN + $row->April_IN + $row->Mei_IN + $row->Juni_IN + $row->Juli_IN + $row->Agustus_IN + $row->September_IN + $row->Oktober_IN + $row->November_IN + $row->Desember_IN;

	$grandtotal_IN=$grandtotal_IN + $subtotal_IN;
	
	$total_januari_SC= $total_januari_SC + $row->Januari_SC;
	$total_febuari_SC= $total_febuari_SC + $row->Febuari_SC;
	$total_maret_SC= $total_maret_SC + $row->Maret_SC;
	$total_april_SC= $total_april_SC + $row->April_SC;
	$total_mei_SC= $total_mei_SC + $row->Mei_SC;
	$total_juni_SC= $total_juni_SC + $row->Juni_SC;
	$total_juli_SC= $total_juli_SC + $row->Juli_SC;
	$total_agustus_SC= $total_agustus_SC + $row->Agustus_SC;
	$total_september_SC= $total_september_SC + $row->September_SC;
	$total_oktober_SC= $total_oktober_SC + $row->Oktober_SC;
	$total_november_SC= $total_november_SC + $row->November_SC;
	$total_desember_SC= $total_desember_SC + $row->Desember_SC;

	$subtotal_SC= $row->Januari_SC + $row->Febuari_SC + $row->Maret_SC + $row->April_SC + $row->Mei_SC + $row->Juni_SC + $row->Juli_SC + $row->Agustus_SC + $row->September_SC + $row->Oktober_SC + $row->November_SC + $row->Desember_SC;

	$grandtotal_SC=$grandtotal_SC + $subtotal_SC;
			
	$total_januari_OR= $total_januari_OR + $row->Januari_OR;
	$total_febuari_OR= $total_febuari_OR + $row->Febuari_OR;
	$total_maret_OR= $total_maret_OR + $row->Maret_OR;
	$total_april_OR= $total_april_OR + $row->April_OR;
	$total_mei_OR= $total_mei_OR + $row->Mei_OR;
	$total_juni_OR= $total_juni_OR + $row->Juni_OR;
	$total_juli_OR= $total_juli_OR + $row->Juli_OR;
	$total_agustus_OR= $total_agustus_OR + $row->Agustus_OR;
	$total_september_OR= $total_september_OR + $row->September_OR;
	$total_oktober_OR= $total_oktober_OR + $row->Oktober_OR;
	$total_november_OR= $total_november_OR + $row->November_OR;
	$total_desember_OR= $total_desember_OR + $row->Desember_OR;

	$subtotal_OR= $row->Januari_OR + $row->Febuari_OR + $row->Maret_OR + $row->April_OR + $row->Mei_OR + $row->Juni_OR + $row->Juli_OR + $row->Agustus_OR + $row->September_OR + $row->Oktober_OR + $row->November_OR + $row->Desember_OR;

	$grandtotal_OR=$grandtotal_OR + $subtotal_OR;
			
	$total_januari_PS= $total_januari_PS + $row->Januari_PS;
	$total_febuari_PS= $total_febuari_PS + $row->Febuari_PS;
	$total_maret_PS= $total_maret_PS + $row->Maret_PS;
	$total_april_PS= $total_april_PS + $row->April_PS;
	$total_mei_PS= $total_mei_PS + $row->Mei_PS;
	$total_juni_PS= $total_juni_PS + $row->Juni_PS;
	$total_juli_PS= $total_juli_PS + $row->Juli_PS;
	$total_agustus_PS= $total_agustus_PS + $row->Agustus_PS;
	$total_september_PS= $total_september_PS + $row->September_PS;
	$total_oktober_PS= $total_oktober_PS + $row->Oktober_PS;
	$total_november_PS= $total_november_PS + $row->November_PS;
	$total_desember_PS= $total_desember_PS + $row->Desember_PS;	

	$subtotal_PS= $row->Januari_PS + $row->Febuari_PS + $row->Maret_PS + $row->April_PS + $row->Mei_PS + $row->Juni_PS + $row->Juli_PS + $row->Agustus_PS + $row->September_PS + $row->Oktober_PS + $row->November_PS + $row->Desember_PS;

	$grandtotal_PS=$grandtotal_PS + $subtotal_PS;
					
?>  
  <tr>
        <td width="4%" class="tg-iuhm"><?php echo $row->category; ?></td>
        <td width="5%" class="tg-iuhm"><?php echo $row->branch_name; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->branch_code; ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Januari_IN,0); ?></td>                        
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Febuari_IN,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Maret_IN,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->April_IN,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Mei_IN,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Juni_IN,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Juli_IN,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Agustus_IN,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->September_IN,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Oktober_IN,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->November_IN,0); ?></td>                  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Desember_IN,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($subtotal_IN,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Januari_SC,0); ?></td>                        
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Febuari_SC,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Maret_SC,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->April_SC,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Mei_SC,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Juni_SC,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Juli_SC,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Agustus_SC,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->September_SC,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Oktober_SC,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->November_SC,0); ?></td>                  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Desember_SC,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($subtotal_SC,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Januari_OR,0); ?></td>                        
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Febuari_OR,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Maret_OR,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->April_OR,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Mei_OR,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Juni_OR,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Juli_OR,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Agustus_OR,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->September_OR,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Oktober_OR,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->November_OR,0); ?></td>                  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Desember_OR,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($subtotal_OR,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Januari_PS,0); ?></td>                        
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Febuari_PS,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Maret_PS,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->April_PS,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Mei_PS,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Juni_PS,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Juli_PS,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Agustus_PS,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->September_PS,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Oktober_PS,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->November_PS,0); ?></td>                  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Desember_PS,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($subtotal_PS,0); ?></td>                  
  </tr>  
<?php }}?>
  <tr>
        <td width="4%" class="tg-iuhm"></td>
        <td width="5%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_januari_IN,0); ?></td>
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_febuari_IN,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_maret_IN,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_april_IN,0); ?></td>  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_mei_IN,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juni_IN,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juli_IN,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_agustus_IN,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_september_IN,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_oktober_IN,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_november_IN,0); ?></td>        
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_desember_IN,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($grandtotal_IN,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_januari_SC,0); ?></td>
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_febuari_SC,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_maret_SC,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_april_SC,0); ?></td>  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_mei_SC,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juni_SC,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juli_SC,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_agustus_SC,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_september_SC,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_oktober_SC,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_november_SC,0); ?></td>        
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_desember_SC,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($grandtotal_SC,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_januari_OR,0); ?></td>
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_febuari_OR,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_maret_OR,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_april_OR,0); ?></td>  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_mei_OR,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juni_OR,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juli_OR,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_agustus_OR,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_september_OR,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_oktober_OR,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_november_OR,0); ?></td>        
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_desember_OR,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($grandtotal_OR,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_januari_PS,0); ?></td>
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_febuari_PS,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_maret_PS,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_april_PS,0); ?></td>  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_mei_PS,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juni_PS,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juli_PS,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_agustus_PS,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_september_PS,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_oktober_PS,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_november_PS,0); ?></td>        
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_desember_PS,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($grandtotal_PS,0); ?></td>              
  </tr>   
</table>
  <br />
  <br />
  <br />

</body>

</html>
