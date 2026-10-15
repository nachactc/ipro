<?php  
  if ($button == 'EXPORT')
  {
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: text/plain');
	//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename=".$filename."IDSM02EXCIML101.FT");		
  } 
 ?>
# FILE NAME : <?php echo $filename; ?> IDSM02EXCIML101.FT
# FILE REFERENCE : <?php echo $filenamedetil; ?> IDSM02EXCIML101
# VERSION NUMBER : 1.00
# GENERATION DATE : <?php echo $filenamedetil; ?> E08
# CHARACTER SET : ENG
<?php
$irow = 0;
if(isset($result)){
foreach($result as $row){
	$irow = $irow + 1;
	if ($row->AMOUNT_DEBIT==0){
		$debit = "0.0000";
	}
	else{
		$debit = $row->AMOUNT_DEBIT;
	}
	if ($row->AMOUNT_CREDIT==0){
		$credit = "0.0000";
	}
	else{
		$credit = $row->AMOUNT_CREDIT;
	}
	
?>
<?php echo $row->CODE_EVENT; ?>;<?php echo $row->CODE_SUB_EVENT; ?>;<?php echo $row->CODE_VERSION; ?>;<?php echo $row->ID_SYSTEM; ?>;<?php echo $row->DATE_EXTRACTION; ?>;<?php echo $row->BUSINESS_UNIT; ?>;<?php echo $row->BUSINESS_UNIT_AFFILIATE; ?>;<?php echo $row->C4_ACTIVITY_LOCATION; ?>;<?php echo $row->ID_DEPARTMENT; ?>;<?php echo $row->CODE_AMOUNT; ?>;<?php echo $row->ACCOUNT_PS; ?>;<?php echo $row->DATE_ACCOUNTING; ?>;<?php echo $row->CURRENCY_BASE; ?>;<?php echo $debit; ?>;<?php echo $credit; ?>;<?php echo $row->LEDGER_GROUP; ?>;<?php echo $row->DESCRIPTION; ?>;;;<?php echo $row->KET1; ?>;;;;;;;;;;;;;;;;;;;;
<?php }}?>  
# ROWS COUNT : <?php echo $irow; ?>
