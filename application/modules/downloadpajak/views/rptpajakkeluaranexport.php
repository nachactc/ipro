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
$linesatu='';
$linedua='';
$kode='';
$titik=".";
	//$data = "<table border='1'>";
	//$data .= "<tr>";
	//$data .= "<td>";
if(isset($result)){
	$LineFK='';
	$LineLT='';
	$LineOF='';
	$rows = 0;
	$rowsB = '';
	$rowsC = '';	
	$counts = 0;	

	foreach($result as $row){
		$rows = $rows + 1;
	}
	 
	
foreach($result as $row){
	$counts = $counts + 1;	
	$colA = $row->A;
	$rowsB = $row->B;
	$rowsC = $row->C;
	if ($colA =='OF'){
		$kode="\r\n";
		}
	else
	{
		$kode="\n";
		}
	if ($counts == $rows) {
		$kode="\n";
		}
	if ($colA =='FK'){
		if ($prefix =='0'){
			$rowsB = $row->B;
			$rowsC = $row->C;
		}
		else {
			if ($no != 0){
				$rowsB = substr($prefix,0,2);
				$rowsC = substr($prefix,-1);
				}			
			}
		
	}
	$linesatu = $row->A . $separator . $rowsB . $separator . $rowsC. $separator . $row->D. $separator . $row->E. $separator . $row->F. $separator . $row->G . $separator . $row->H . $separator . $row->I . $separator . $row->J. $separator . $row->K. $separator . $row->L. $separator . $row->M . $separator . $row->N . $separator . $row->O . $separator . $row->P. $separator . $row->Q. $separator . $row->R. $separator . $row->S . $separator . $row->T . $kode;
	if ($linedua =='')
	{
		$linedua= $linesatu;
		}
	else
	{
		$linedua= $linedua . $linesatu;
		}
	
	$linedua = str_replace(array(';NULL'), '', $linedua);
	$sA=$row->A;
	$no = $no + 1;	
	 }}
	 
	 $linedua = $linedua . $titik;
 
if ($button == 'EXPORT')
  {
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header('Content-Type: text/csv; charset=utf-8'); 
	header("Content-Disposition: attachment; filename=Pajak_Keluaran1.csv");
	echo trim($linedua); 
     exit();	
  } 
  else
  {
	echo $linedua;  
  }
?>