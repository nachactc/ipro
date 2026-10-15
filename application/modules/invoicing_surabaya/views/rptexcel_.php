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
<title>INVOICE LIST</title>
 
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


<p>
</p>
<p>INVOICE LIST</p>
<table width="942" border="0">
  <tr>
    <td width="155">Business Unit</td>
    <td width="236">:  <?php echo $region_name; ?></td>
    <td width="154">Store</td>
    <td width="379">:  <?php echo $branch_name; ?></td>
  </tr>
  <tr>
    <td>Tenant</td>
    <td>:  <?php echo $rekanan_name; ?></td>
    <td>Brand</td>
    <td>: <?php echo $rekananshipping_name; ?></td>
  </tr>
  <tr>
    <td>Start Date</td>
    <td>: <?php echo date('d-M-Y',strtotime($startdate)); ?></td>
    <td>End Date</td>
    <td>: <?php echo date('d-M-Y',strtotime($enddate)); ?></td>
  </tr>      
</table>


 </br>
<?php

$id = '';
$idr = 0;
$idrinv = 0;
$subtotalidr = 0;
$subtotalidrinv = 0;
$balance =0;
if(isset($result)){
foreach($result as $row){
  $id = $row->schedulepayment_id;
  $subtotalidr = $subtotalidr + $idr; 	  
?> 

<?php }}?>

 
  <br />
  <br />
 

</body>

</html>
