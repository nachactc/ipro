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

echo "tesss";
print_r($data);
exit;

foreach($data['A'] as $val=>$n){
	echo $data['A'][$val];
	
}
 
// if ($button == 'EXPORT')
  // {
	// header("Cache-Control: no-store, no-cache, must-revalidate");
	// header("Cache-Control: post-check=0, pre-check=0", false);
	// header('Content-Type: text/csv; charset=utf-8'); 
	// header("Content-Disposition: attachment; filename=Pajak_Keluaran1.csv");
	// echo trim($linedua); 
     // exit();	
  // } 
  // else
  // {
	// echo $linedua;  
  // }
?>