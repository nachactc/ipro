


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
 
 <title>Summary Monthly Invoice Utilities</title>
 
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


<p>Summary  Monthly Invoice Utilities</p>
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
    <td colspan="13" class="tg-li00">UA</td>
    <td colspan="13" class="tg-li00">UG</td>
    <td colspan="13" class="tg-li00">UL</td>
    <td colspan="13" class="tg-li00">ULP</td>
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
        <td width="7%" class="tg-li00">Total UA</td>
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
        <td width="7%" class="tg-li00">Total UG</td>
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
        <td width="7%" class="tg-li00">Total UL</td>
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
        <td width="7%" class="tg-li00">Total ULP</td>                                                       
  </tr>
<?php
$total_januari_UA=0;
$total_febuari_UA=0;
$total_maret_UA=0;
$total_april_UA=0;
$total_mei_UA=0;
$total_juni_UA=0;
$total_juli_UA=0;
$total_agustus_UA=0;
$total_september_UA=0;
$total_oktober_UA=0;
$total_november_UA=0;
$total_desember_UA=0;

$total_januari_UG=0;
$total_febuari_UG=0;
$total_maret_UG=0;
$total_april_UG=0;
$total_mei_UG=0;
$total_juni_UG=0;
$total_juli_UG=0;
$total_agustus_UG=0;
$total_september_UG=0;
$total_oktober_UG=0;
$total_november_UG=0;
$total_desember_UG=0;   

$total_januari_UL=0;
$total_febuari_UL=0;
$total_maret_UL=0;
$total_april_UL=0;
$total_mei_UL=0;
$total_juni_UL=0;
$total_juli_UL=0;
$total_agustus_UL=0;
$total_september_UL=0;
$total_oktober_UL=0;
$total_november_UL=0;
$total_desember_UL=0; 

$total_januari_ULP=0;
$total_febuari_ULP=0;
$total_maret_ULP=0;
$total_april_ULP=0;
$total_mei_ULP=0;
$total_juni_ULP=0;
$total_juli_ULP=0;
$total_agustus_ULP=0;
$total_september_ULP=0;
$total_oktober_ULP=0;
$total_november_ULP=0;
$total_desember_ULP=0; 

$subtotal_UA=0;
$subtotal_UG=0;
$subtotal_UL=0;
$subtotal_ULP=0;

$grandtotal_UA=0;
$grandtotal_UG=0;
$grandtotal_UL=0;
$grandtotal_ULP=0;

if(isset($result)){
foreach($result as $row){
	$total_januari_UA= $total_januari_UA + $row->Januari_UA;
	$total_febuari_UA= $total_febuari_UA + $row->Febuari_UA;
	$total_maret_UA= $total_maret_UA + $row->Maret_UA;
	$total_april_UA= $total_april_UA + $row->April_UA;
	$total_mei_UA= $total_mei_UA + $row->Mei_UA;
	$total_juni_UA= $total_juni_UA + $row->Juni_UA;
	$total_juli_UA= $total_juli_UA + $row->Juli_UA;
	$total_agustus_UA= $total_agustus_UA + $row->Agustus_UA;
	$total_september_UA= $total_september_UA + $row->September_UA;
	$total_oktober_UA= $total_oktober_UA + $row->Oktober_UA;
	$total_november_UA= $total_november_UA + $row->November_UA;
	$total_desember_UA= $total_desember_UA + $row->Desember_UA;
	
	$subtotal_UA= $row->Januari_UA + $row->Febuari_UA + $row->Maret_UA + $row->April_UA + $row->Mei_UA + $row->Juni_UA + $row->Juli_UA + $row->Agustus_UA + $row->September_UA + $row->Oktober_UA + $row->November_UA + $row->Desember_UA;

	$grandtotal_UA=$grandtotal_UA + $subtotal_UA;
	
	$total_januari_UG= $total_januari_UG + $row->Januari_UG;
	$total_febuari_UG= $total_febuari_UG + $row->Febuari_UG;
	$total_maret_UG= $total_maret_UG + $row->Maret_UG;
	$total_april_UG= $total_april_UG + $row->April_UG;
	$total_mei_UG= $total_mei_UG + $row->Mei_UG;
	$total_juni_UG= $total_juni_UG + $row->Juni_UG;
	$total_juli_UG= $total_juli_UG + $row->Juli_UG;
	$total_agustus_UG= $total_agustus_UG + $row->Agustus_UG;
	$total_september_UG= $total_september_UG + $row->September_UG;
	$total_oktober_UG= $total_oktober_UG + $row->Oktober_UG;
	$total_november_UG= $total_november_UG + $row->November_UG;
	$total_desember_UG= $total_desember_UG + $row->Desember_UG;

	$subtotal_UG= $row->Januari_UG + $row->Febuari_UG + $row->Maret_UG + $row->April_UG + $row->Mei_UG + $row->Juni_UG + $row->Juli_UG + $row->Agustus_UG + $row->September_UG + $row->Oktober_UG + $row->November_UG + $row->Desember_UG;

	$grandtotal_UG=$grandtotal_UG + $subtotal_UG;
			
	$total_januari_UL= $total_januari_UL + $row->Januari_UL;
	$total_febuari_UL= $total_febuari_UL + $row->Febuari_UL;
	$total_maret_UL= $total_maret_UL + $row->Maret_UL;
	$total_april_UL= $total_april_UL + $row->April_UL;
	$total_mei_UL= $total_mei_UL + $row->Mei_UL;
	$total_juni_UL= $total_juni_UL + $row->Juni_UL;
	$total_juli_UL= $total_juli_UL + $row->Juli_UL;
	$total_agustus_UL= $total_agustus_UL + $row->Agustus_UL;
	$total_september_UL= $total_september_UL + $row->September_UL;
	$total_oktober_UL= $total_oktober_UL + $row->Oktober_UL;
	$total_november_UL= $total_november_UL + $row->November_UL;
	$total_desember_UL= $total_desember_UL + $row->Desember_UL;

	$subtotal_UL= $row->Januari_UL + $row->Febuari_UL + $row->Maret_UL + $row->April_UL + $row->Mei_UL + $row->Juni_UL + $row->Juli_UL + $row->Agustus_UL + $row->September_UL + $row->Oktober_UL + $row->November_UL + $row->Desember_UL;

	$grandtotal_UL=$grandtotal_UL + $subtotal_UL;
			
	$total_januari_ULP= $total_januari_ULP + $row->Januari_ULP;
	$total_febuari_ULP= $total_febuari_ULP + $row->Febuari_ULP;
	$total_maret_ULP= $total_maret_ULP + $row->Maret_ULP;
	$total_april_ULP= $total_april_ULP + $row->April_ULP;
	$total_mei_ULP= $total_mei_ULP + $row->Mei_ULP;
	$total_juni_ULP= $total_juni_ULP + $row->Juni_ULP;
	$total_juli_ULP= $total_juli_ULP + $row->Juli_ULP;
	$total_agustus_ULP= $total_agustus_ULP + $row->Agustus_ULP;
	$total_september_ULP= $total_september_ULP + $row->September_ULP;
	$total_oktober_ULP= $total_oktober_ULP + $row->Oktober_ULP;
	$total_november_ULP= $total_november_ULP + $row->November_ULP;
	$total_desember_ULP= $total_desember_ULP + $row->Desember_ULP;	

	$subtotal_ULP= $row->Januari_ULP + $row->Febuari_ULP + $row->Maret_ULP + $row->April_ULP + $row->Mei_ULP + $row->Juni_ULP + $row->Juli_ULP + $row->Agustus_ULP + $row->September_ULP + $row->Oktober_ULP + $row->November_ULP + $row->Desember_ULP;

	$grandtotal_ULP=$grandtotal_ULP + $subtotal_ULP;
					
?>  
  <tr>
        <td width="4%" class="tg-iuhm"><?php echo $row->category; ?></td>
        <td width="5%" class="tg-iuhm"><?php echo $row->branch_name; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->branch_code; ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Januari_UA,0); ?></td>                        
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Febuari_UA,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Maret_UA,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->April_UA,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Mei_UA,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Juni_UA,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Juli_UA,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Agustus_UA,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->September_UA,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Oktober_UA,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->November_UA,0); ?></td>                  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Desember_UA,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($subtotal_UA,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Januari_UG,0); ?></td>                        
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Febuari_UG,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Maret_UG,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->April_UG,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Mei_UG,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Juni_UG,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Juli_UG,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Agustus_UG,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->September_UG,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Oktober_UG,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->November_UG,0); ?></td>                  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Desember_UG,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($subtotal_UG,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Januari_UL,0); ?></td>                        
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Febuari_UL,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Maret_UL,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->April_UL,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Mei_UL,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Juni_UL,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Juli_UL,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Agustus_UL,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->September_UL,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Oktober_UL,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->November_UL,0); ?></td>                  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Desember_UL,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($subtotal_UL,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Januari_ULP,0); ?></td>                        
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Febuari_ULP,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Maret_ULP,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->April_ULP,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Mei_ULP,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Juni_ULP,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Juli_ULP,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Agustus_ULP,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->September_ULP,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Oktober_ULP,0); ?></td> 
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->November_ULP,0); ?></td>                  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Desember_ULP,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($subtotal_ULP,0); ?></td>                  
  </tr>  
<?php }}?>
  <tr>
        <td width="4%" class="tg-iuhm"></td>
        <td width="5%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_januari_UA,0); ?></td>
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_febuari_UA,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_maret_UA,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_april_UA,0); ?></td>  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_mei_UA,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juni_UA,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juli_UA,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_agustus_UA,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_september_UA,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_oktober_UA,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_november_UA,0); ?></td>        
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_desember_UA,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($grandtotal_UA,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_januari_UG,0); ?></td>
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_febuari_UG,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_maret_UG,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_april_UG,0); ?></td>  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_mei_UG,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juni_UG,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juli_UG,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_agustus_UG,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_september_UG,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_oktober_UG,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_november_UG,0); ?></td>        
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_desember_UG,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($grandtotal_UG,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_januari_UL,0); ?></td>
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_febuari_UL,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_maret_UL,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_april_UL,0); ?></td>  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_mei_UL,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juni_UL,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juli_UL,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_agustus_UL,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_september_UL,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_oktober_UL,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_november_UL,0); ?></td>        
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_desember_UL,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($grandtotal_UL,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_januari_ULP,0); ?></td>
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_febuari_ULP,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_maret_ULP,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_april_ULP,0); ?></td>  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_mei_ULP,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juni_ULP,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juli_ULP,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_agustus_ULP,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_september_ULP,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_oktober_ULP,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_november_ULP,0); ?></td>        
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_desember_ULP,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($grandtotal_ULP,0); ?></td>              
  </tr>   
</table>
  <br />
  <br />
  <br />

</body>

</html>
