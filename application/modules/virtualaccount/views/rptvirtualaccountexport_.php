<?php 
$LineFK='';
$LineLT='';
$LineOF='';
$report ='';
$colA='';
$no = 0;
$sA='';
$str ='';
$data = '';
$csv='';
	//$data = "<table border='1'>";
	//$data .= "<tr>";
	//$data .= "<td>";
if(isset($result)){
	$LineFK='';
	$LineLT='';
	$LineOF='';
foreach($result as $row){		
	$colA = $row->A;
	$sA=$row->A;
	$no = $no + 1;
	if($colA == 'FK')
	{
		$LineFK = $row->A . $separator . $row->B . $separator . $row->C. $separator . $row->D. $separator . $row->E. $separator . $row->F. $separator . $row->G . $separator . $row->H . $separator . $row->I . $separator . $row->J. $separator . $row->K. $separator . $row->L. $separator . $row->M . $separator . $row->N . $separator . $row->O . $separator . $row->P. $separator . $row->Q. $separator . $row->R. $separator . $row->S;
		}
	elseif ($colA == 'LT')
	{
		$LineLT = $row->A . $separator . $row->B . $separator . $row->C. $separator . $row->D. $separator . $row->E. $separator . $row->F. $separator . $row->G . $separator . $row->H . $separator . $row->I . $separator . $row->J. $separator . $row->K. $separator . $row->L. $separator . $row->M . $separator . $row->N . $separator . $row->O . $separator . $row->P. $separator . $row->Q. $separator . $row->R. $separator . $row->S;
		}
	elseif($colA == 'OF')
	{
		$LineOF = $row->A . $separator . $row->B . $separator . $row->C. $separator . $row->D. $separator . $row->E. $separator . $row->F. $separator . $row->G . $separator . $row->H . $separator . $row->I . $separator . $row->J. $separator . $row->K. $separator . $row->L. $separator . $row->M . $separator . $row->N . $separator . $row->O . $separator . $row->P. $separator . $row->Q. $separator . $row->R. $separator . $row->S;
		}

	if($LineFK != '' and  $LineLT != '' and  $LineOF != '')
	{
		$str = $LineFK . $LineLT . $LineOF;
		//$str = str_replace(array('\n', '\r', '\r\n', '\n\r'), ',', $str);
		$str = str_replace(array('NULL'), '', $str);
		if($str != '')
		{
		
			$data .= $str . "\r\n";

			if($no > '3')
			{
			$csv .= $str. "\r\n";		
				}
			else
			{
			$csv .= $str;		
				}	
		}
	}
    

	//$str = trim(preg_replace('/\s\s+/', ' ', $str));

   }	
}
	//$data .= "</td>";
	//$data .= "</tr>";
	//$data .= "</table"; 


if ($button == 'EXPORT')
  {
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header('Content-Type: text/csv; charset=utf-8');
	 	//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename="."Pajak_Keluaran - ".$region_name." - ".$branch_name.".csv");
	echo trim($csv); 
     exit();	
  } 
  else
  {
	echo $data;  
  }
?>