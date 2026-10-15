<?php  
  if ($button == 'EXCEL')
  {

	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: text/plain');
	//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename="."Pajak_Keluaran - ".$region_name." - ".$branch_name.".txt");
		
  } 
 ?>
<title>Download Faktu Pajak</title>
 
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

<body>
<table class="tg" width="1295" border="0">
  <tr>
        <td width="9%" class="tg-li00">A</td>
        <td width="8%" class="tg-li00">B</td>
        <td width="9%" class="tg-li00">C</td>
        <td width="8%" class="tg-li00">D</td>
        <td width="10%" class="tg-li00">E</td>
        <td width="9%" class="tg-li00">F</td>
        <td width="10%" class="tg-li00">G</td>        
        <td width="9%"class="tg-li00">H</td>
        <td width="9%"class="tg-li00">I</td>
        <td width="10%" class="tg-li00">J</td>
        <td width="10%" class="tg-li00">K</td>
        <td width="10%" class="tg-li00">L</td>
        <td width="10%" class="tg-li00">M</td>
        <td width="10%" class="tg-li00">N</td>
        <td width="10%" class="tg-li00">O</td>
        <td width="10%" class="tg-li00">P</td>
        <td width="10%" class="tg-li00">Q</td>
        <td width="10%" class="tg-li00">T</td>
        <td width="10%" class="tg-li00">S</td>
        <td width="10%" class="tg-li00">T</td>
        <td width="10%" class="tg-li00">No</td>
  </tr>
<?php
$no =0;
$idr = 0;
$vat = 0;
$idrinv = 0;
$subtotalidr = 0;
$subtotalidrinv = 0;
$balance =0;
  $rental =0;
  $svc_chgs =0;
  $utilitas =0;
  $profit_sharing =0;
  $promotion_levy =0;
  $foodcourt_levy =0;
  $umbul_umbul =0;
  $others =0;
  $totalvat =0;
  $totalidr =0;
  
if(isset($result)){
foreach($result as $row){

  $no = $no + 1;
?>  
  <tr>
        <td width="9%" class="tg-iuhm"><?php echo $row->A; ?></td>
        <td width="8%" class="tg-iuhm"><?php echo $row->B; ?></td>
        <td width="9%" class="tg-iuhm"><?php echo $row->C; ?></td>
        <td width="8%"  class="tg-iuhm"><?php echo $row->D; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->E; ?></td>
        <td width="9%" class="tg-iuhm"><?php echo $row->F; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->G; ?></td>
        <td width="9%" class="tg-iuhm"><?php echo $row->H; ?></td>
        <td width="9%" class="tg-iuhm"><?php echo $row->I; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->J; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->K; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->L; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->M; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->N; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->O; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->P; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->Q; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->R; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->S; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->T; ?></td>
        <td width="10%" class="tg-iuhm"><?php echo $row->Nom; ?></td>
  </tr>  
<?php }}?>  
</table>
 
  <br />
  <br />
 

</body>

</html>
