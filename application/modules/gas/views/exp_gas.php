<?php  

  $curr_date = date('Y_m_d_h_i_s');

  header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	//header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename=Gas-".$curr_date.".xls");  
 ?>
<title>TEMPLATE LISTRIK</title>
 
<style type="text/css">

.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-iuhm{font-size:10px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top;}
.tg .tg-li00{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;background-color:#ffffff;border-color:#000000;text-align:center;vertical-align:top}
.head1{font-size:14px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
.head2{font-size:12px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
</style>

</head>

<body>
<table border="0">
  <tr>
    <td>TENANT_ID</td>
    <td>TENANT_NAME</td>
    <td>TOKO_ID</td>
    <td>TOKO_NAME</td>
    <td>REG_ID</td>
    <td>STAND_AKHIR</td>
  </tr>
<?php

  if(isset($line)){
    foreach($line as $row => $n){       

      
?>
  <tr>
    <td><?php echo $rekanan_id[$row]; ?></td>
    <td><?php echo $rekanan_name[$row]; ?></td>
    <td><?php echo $rekananshipping_line[$row]; ?></td>
    <td><?php echo $rekananshipping_name[$row]; ?></td>
    <td><?php echo $rekananutilitiesgas_reg[$row]; ?></td>
    <td align="right"><?php echo $stand_akhir[$row]; ?></td>        
  </tr>    
  <?php }}?>  
</table>

</body>

</html>
