


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


<p>Summary  Monthly Invoice List</p>
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
        <td width="3%" class="tg-li00">Code</td>
        <td width="4%" class="tg-li00">Category</td>
        <td width="5%" class="tg-li00">Property</td>        
        <td width="5%" class="tg-li00">Debtor Acct</td>
        <td width="7%" class="tg-li00">Debtor Name</td>
        <td width="7%" class="tg-li00">Brand</td>
        <td width="7%" class="tg-li00">Start Date</td>
        <td width="7%" class="tg-li00">End Date</td>
        <td width="7%" class="tg-li00">Shipping Type</td>       
        <td width="7%" class="tg-li00">Store Code</td>
        <td width="7%" class="tg-li00">TRX</td>
        <td width="7%" class="tg-li00">Jan</td>                                         
    	<td width="7%" align="right" class="tg-li00">Feb</td>
        <td width="6%" align="right" class="tg-li00">Mar</td>
        <td width="6%" align="right" class="tg-li00">Apr</td>  
        <td width="6%" class="tg-li00">Mei</td>
        <td width="6%" class="tg-li00">Jun</td>
        <td width="7%" class="tg-li00">Jul</td>
        <td width="7%" class="tg-li00">Aug</td>
        <td width="7%" class="tg-li00">Sep</td>
        <td width="7%" class="tg-li00">Okt</td>
        <td width="7%" class="tg-li00">Nov</td>        
        <td width="7%" class="tg-li00">Des</td>                                                       
  </tr>
<?php
$total_januari=0;
$total_febuari=0;
$total_maret=0;
$total_april=0;
$total_mei=0;
$total_juni=0;
$total_juli=0;
$total_agustus=0;
$total_september=0;
$total_oktober=0;
$total_november=0;
$total_desember=0; 


 
if(isset($result)){
foreach($result as $row){
	$total_januari= $total_januari + $row->Januari;
	$total_febuari= $total_febuari + $row->Febuari;
	$total_maret= $total_maret + $row->Maret;
	$total_april= $total_april + $row->April;
	$total_mei= $total_mei + $row->Mei;
	$total_juni= $total_juni + $row->Juni;
	$total_juli= $total_juli + $row->Juli;
	$total_agustus= $total_agustus + $row->Agustus;
	$total_september= $total_september + $row->September;
	$total_oktober= $total_oktober + $row->Oktober;
	$total_november= $total_november + $row->November;
	$total_desember= $total_desember + $row->Desember;
	 
	 
	$enddate = $row->enddate; 
	$dateend = new DateTime($enddate);
	$format = 'd-M-Y';
	
?>  
  <tr>
        <td width="3%" class="tg-iuhm"><?php echo $row->Code; ?></td>
        <td width="4%" class="tg-iuhm"><?php echo $row->category; ?></td>
        <td width="5%" class="tg-iuhm"><?php echo $row->branch_name; ?></td>
        <td width="5%" class="tg-iuhm"><?php echo $row->schedulepayment_contractno; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->rekanan_name; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->rekananshipping_name; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo date('d-M-Y',strtotime($row->startdate)); ?></td>        
        <td width="7%" class="tg-iuhm"> <?php echo $dateend->format($format); ?></td>        
        <td width="7%" class="tg-iuhm"><?php echo $row->rekananshipping_type; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->branch_code; ?></td>
        <td width="7%" class="tg-iuhm"><?php echo $row->agreementtype_nameshort; ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Januari,0); ?></td>                        
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($row->Febuari,0); ?></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($row->Maret,0); ?></td>
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($row->April,0); ?></td> 
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($row->Mei,0); ?></td> 
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($row->Juni,0); ?></td> 
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($row->Juli,0); ?></td> 
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($row->Agustus,0); ?></td> 
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($row->September,0); ?></td> 
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($row->Oktober,0); ?></td> 
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($row->November,0); ?></td>                  
        <td width="6%" align="right" class="tg-iuhm"><?php echo number_format($row->Desember,0); ?></td>                  
  </tr>  
<?php }}?>
  <tr>
        <td width="3%" class="tg-iuhm"></td>
        <td width="4%" class="tg-iuhm"></td>
        <td width="5%" class="tg-iuhm"></td>
        <td width="5%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td>                                        
        <td width="7%" class="tg-iuhm"></td>        
        <td width="7%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="7%" class="tg-iuhm"></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_januari,0); ?></td>
    	<td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_febuari,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_maret,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_april,0); ?></td>  
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_mei,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juni,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_juli,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_agustus,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_september,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_oktober,0); ?></td>
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_november,0); ?></td>        
        <td width="7%" align="right" class="tg-iuhm"><?php echo number_format($total_desember,0); ?></td>              
  </tr>   
</table>
  <br />
  <br />
  <br />

</body>

</html>
