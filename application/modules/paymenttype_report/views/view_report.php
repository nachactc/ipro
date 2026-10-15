 <?php  
  if ($button == 'EXCEL')
  {

	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename=PAYMENT_SUMMARY_REPORT.xls");
  } 
 ?> 
 
 <style>
 .tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-7fle{font-weight:bold;background-color:#efefef;text-align:center;vertical-align:top}
.tg .tg-v0hj{font-weight:bold;background-color:#efefef;border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-9i0n{font-weight:bold;background-color:#efefef;border-color:inherit;text-align:right}
.tg .tg-l04w{font-weight:bold;background-color:#efefef;border-color:inherit;text-align:center}
.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
.tg .tg-dvpl{border-color:inherit;text-align:right;vertical-align:top}
.tg .tg-0lax{text-align:left;vertical-align:top}
.tg .tg-xldj{border-color:inherit;text-align:left}
.tg .tg-quj4{border-color:inherit;text-align:right}
</style>
<table  style="undefined;table-layout: fixed; width: 2800px;" class="tg" id="SummarySOA_<?php echo $year.'_'.date('d_m_Y_s') ?>">
<?php  
function rupiah($angka){ 
	$hasil_rupiah = number_format($angka,0); 
	return $hasil_rupiah; 
} 
echo "<tr>";
echo "<td colspan='".count($data_sm_soa['column'])."' style='text-align: center;' > Payment Detail by Tenant by Property Report <br/>".getIndoHari($sdate)." - ".getIndoHari($edate)."  </td>";
echo "<tr>";
echo "</tr>";
foreach($data_sm_soa['column'] as $column => $val_column)
{	
	 
    if($column >= 6)
	{
		echo "<td style='text-align:center;'>";
		echo $val_column;
		echo "</td>";
	} 
	else
	{
		echo "<td style='text-align:left;'>";
		echo $val_column;
		echo "</td>";
	}
	
}
echo "</tr>";




foreach($data_sm_soa['result'] as $data)
{	
	echo "<tr>";
	$tds = get_object_vars($data);
	foreach($tds as $property => $detil)
	{	 
	 
		if ( is_numeric($data->{$property}) && $property != 'Year' && $property != 'Virtual Account' ) { 
			echo "<td style='text-align: right;'>"; 
			echo rupiah($data->{$property}); 
			echo "</td>"; 
			 
		}
		else
		{
			echo "<td>"; 
			echo $data->{$property}; 
			echo "</td>"; 
		}
		
	} 
	echo "</tr>";
	 
}
	$i = array();
	$a = array();
	$prop = '';
	$count = 0;
	$tot_dep = 0;
	$tot_dp = 0;
	$tot_oth = 0;
	$tot_pl = 0;
	$tot_ren = 0;
	$tot_sch = 0;
	$tot_tax = 0;
	$tot_uti = 0;
	$tot_total = 0;
	$tot_prh = 0;
	$tot_fol = 0;
	$tot_oth = 0;
	$tot_unalloc = 0;
	echo "<tr>";
	echo "<td colspan='6' style='text-align: right;'>";
	echo "Grand Total";
	echo "</td>";
		foreach ($data_sm_soa['result'] as $data) {
			$tds2 = get_object_vars($data); 
			foreach($tds2 as $property => $detil){
				// if ( is_numeric($data->{$property}) && $property != 'Year' && $property != 'Virtual Account' ) { 
				// $i[$property] = $data->{$property};  
				// $i[$property] += $i[$property]; 
				// } 
				if($property == 'DEPOSIT')
				{
					 $tot_dep += $data->{$property}; 
				} if($property == 'DOWN PAYMENT')
				{
					 $tot_dp += $data->{$property}; 
				}if($property == 'FOOD COURT LEVY')
				{
					 $tot_fol += $data->{$property}; 
				}if($property == 'OTHER')
				{
					 $tot_oth += $data->{$property}; 
				} if($property == 'PROFIT SHARING')
				{
					 $tot_prh += $data->{$property}; 
				} if($property == 'PROMOTION LEVY')
				{
					 $tot_pl += $data->{$property}; 
				} if($property == 'RENTAL')
				{
					 $tot_ren += $data->{$property}; 
				} if($property == 'SERVICE CHARGE')
				{
					 $tot_sch += $data->{$property}; 
				} if($property == 'TAX')
				{
					 $tot_tax += $data->{$property}; 
				} if($property == 'UTILITIES')
				{
					 $tot_uti += $data->{$property}; 
				} if($property == 'TOTAL')
				{
					 $tot_total += $data->{$property}; 
				} if($property == 'UNALLOCATION')
				{
					 $tot_unalloc += $data->{$property}; 
				}
			 
			}  
			
		} 
		
		
	foreach($data_sm_soa['column'] as $column => $val_column)
	{	
		 
		if($column >= 6)
		{
			if($val_column == 'DEPOSIT')
				{
					echo "<td style='text-align: right;'>";
					echo rupiah($tot_dep);
					echo "</td>"; 
				} if($val_column == 'DOWN PAYMENT')
				{
					echo "<td style='text-align: right;'>";
					echo rupiah($tot_dp);
					echo "</td>"; 
				}if($val_column == 'FOOD COURT LEVY')
				{
					echo "<td style='text-align: right;'>";
					echo rupiah($tot_fol);
					echo "</td>";
				}if($val_column == 'OTHER')
				{
					echo "<td style='text-align: right;'>";
					echo rupiah($tot_oth);
					echo "</td>";
				} if($val_column == 'PROFIT SHARING')
				{
					echo "<td style='text-align: right;'>";
					echo rupiah($tot_prh);
					echo "</td>"; 
					
				} if($val_column == 'PROMOTION LEVY')
				{
					echo "<td style='text-align: right;'>";
					echo rupiah($tot_pl);
					echo "</td>"; 
				} if($val_column == 'RENTAL')
				{
					echo "<td style='text-align: right;'>";
					echo rupiah($tot_ren);
					echo "</td>";
					
				} if($val_column == 'SERVICE CHARGE')
				{ 
					echo "<td style='text-align: right;'>";
					echo rupiah($tot_sch);
					echo "</td>"; 					

				} if($val_column == 'TAX')
				{
					echo "<td style='text-align: right;'>";
					echo rupiah($tot_tax);
					echo "</td>"; 
				}if($val_column == 'UNALLOCATION')
				{
					echo "<td style='text-align: right;'>";
					echo rupiah($tot_unalloc);
					echo "</td>"; 
				} if($val_column == 'UTILITIES')
				{
					echo "<td style='text-align: right;'>";
					echo rupiah($tot_uti);
					echo "</td>"; 
				} if($val_column == 'TOTAL')
				{
					echo "<td style='text-align: right;'>";
					echo rupiah($tot_total);
					echo "</td>"; 
				}
		}
	} 
	
	echo "</tr>";
?>

</table>
 