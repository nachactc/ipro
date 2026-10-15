<title> <?php echo $title; ?> </title>
   
 <style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  overflow:hidden;padding:10px 5px;word-break:normal;}
.tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
.tg .tg-za14{border-color:inherit;text-align:left;vertical-align:bottom}
.tg .tg-jkyp{border-color:inherit;text-align:right;vertical-align:bottom}
</style>

<div class="row">
<div class="col-md-5">
<div class="col-xs-1" >
<?php if (empty($post['excel'])) { ?>
<button class="btn btn-primary btn-sm exportToExcel" data-clipboard-target="#xreport">Copy</button>
<?php } ?>
</div>
<form method="POST" >
<div class="col-xs-1" >
<input type="<?php echo empty($post['excel']) ? 'submit' :'hidden' ?>" class="btn btn-success btn-sm" id="excel" value="Excel" > 
</div>
</div>
</div>

<input type="hidden" value="<?php echo !empty($post['region_id']) ? $post['region_id'] :'' ?>" name="region_id" /> 
<input type="hidden" value="<?php echo !empty($post['branch_id']) ? $post['branch_id'] :'' ?>" name="branch_id" /> 
<input type="hidden" value="<?php echo !empty($post['rekanan_id']) ? $post['rekanan_id'] :'' ?>" name="rekanan_id" /> 
<input type="hidden" value="<?php echo !empty($post['rekananshipping_line']) ? $post['rekananshipping_line'] :'' ?>" name="rekananshipping_line" /> 
<input type="hidden" value="<?php echo !empty($post['schedulepayment_id']) ? $post['schedulepayment_id'] :'' ?>" name="schedulepayment_id" /> 
<input type="hidden" value="<?php echo !empty($post['report_type']) ? $post['report_type'] :'' ?>" name="report_type" /> 
<input type="hidden" value="<?php echo !empty($post['excel']) ? $post['excel'] :'excel' ?>" name="excel" /> 
<span>&nbsp;</span>
<?php 
	if(!empty(!empty($post['excel']))){
		header("Content-type: application/vnd-ms-excel");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public");
		header("Content-Disposition: attachment; filename=Report_SOA_Group_".date('d-m-Y').".xls");
	} 
?>

<div class="table-responsive">
<table class="table table-responsive table-bordered table-hover table-striped w-100 table-responsive tg " id="xreport" data-tableName="table-report"  style="undefined;table-layout: fixed; width: 100%">
<colgroup> 
<col style="width: 320px">
<col style="width: 120px">
<col style="width: 120px">
<col style="width: 120px">
<col style="width: 83px">
<col style="width: 120px">
<col style="width: 220px">
<col style="width: 220px">
<col style="width: 150px">
<col style="width: 150px">
<col style="width: 180px"> 
<col style="width: 150px">
</colgroup>
<thead>
  <tr>
	<th  colspan='13' style="background-color:#efefef;border-color:inherit;width:100%;">
	<?php echo @$result[0]->rekanan_id.' - '.@$result[0]->rekanan_name.' - VA:'.@$result[0]->schedulepayment_virtualaccount; ?>
	</th>
  </tr>
  <tr>
	<th  colspan='13' style="background-color:#efefef;border-color:inherit;width:100%;">
	<?php echo @$result[0]->rekananshipping_name.' - Debtor:'.@$result[0]->debtor.' - Unit:'.@$result[0]->shopunit; ?>
	</th> 
  </tr>
  <tr>
	<th  colspan='13' style="background-color:#efefef;border-color:inherit;width:100%;">
	<?php echo @$result[0]->rekanan_address; ?>
	</th> 
  </tr>
  <tr> 
    <th class="tg-za14" style="background-color:#c0c0c0;border-color:inherit;">Descr</th>
    <th class="tg-za14" style="background-color:#c0c0c0;border-color:inherit;">Date</th>
    <th class="tg-za14" style="background-color:#c0c0c0;border-color:inherit;">Due Date</th>
    <th class="tg-za14" style="background-color:#c0c0c0;border-color:inherit;">Invoice(IDR)</th>
    <th class="tg-za14" style="background-color:#c0c0c0;border-color:inherit;">VAT(IDR)</th>
    <th class="tg-za14" style="background-color:#c0c0c0;border-color:inherit;">Total(IDR)</th>
    <th class="tg-za14" style="background-color:#c0c0c0;border-color:inherit;">No.Invoice</th>
    <th class="tg-za14" style="background-color:#c0c0c0;border-color:inherit;">No. Faktur Pajak</th>
    <th class="tg-za14" style="background-color:#c0c0c0;border-color:inherit;">No. Official Receipt</th>
    <th class="tg-za14" style="background-color:#c0c0c0;border-color:inherit;">Tgl. Official Receipt</th>
    <th class="tg-za14" style="background-color:#c0c0c0;border-color:inherit;">Official Receipt(IDR)</th> 
    <th class="tg-za14" style="background-color:#c0c0c0;border-color:inherit;">Saldo Akhir</th>
  </tr>
</thead>
<tbody>
<?php  

if(($result != 'kosong') AND (count($result)>0) ) :
$agrid = '';
$idrx=0;
$idr_paymentdetilx=0;
$idrt=0;
$idr_paymentdetilt=0;
$idr_jurnalx=0;
$idr_jurnalt=0;
$idr_saldox=0;
$idr_saldot=0;
?>
	
<?php
	foreach($result as $data => $row) : 
	// echo @$result[$data+1]->agreementtype_name.' - '. $row->agreementtype_name."<br/>";
	
?>
	
	<?php if( $agrid != $row->agreementtype_id ) { ?>
	<tr><td class="tg-za14" colspan='12' style="background-color:#efefef;border-color:inherit"><?php echo $row->agreementtype_name; ?></td></tr>
	 <?php 
	 }  
	 $agrid = $row->agreementtype_id;
	 $idr = (($row->schedulepaymentdetil_idr*$row->schedulepaymentdetil_tax) / 100 )+$row->schedulepaymentdetil_idr;
	 $idr_paymentdetil = $row->schedulepaymentdetil_idr;
	 $idr_jurnal = $row->jurnaldetil_idr;
	 $idr_saldo = $idr - ($idr_jurnal);
?> 
  <tr> 
    <td class="tg-za14"><?php echo $row->schedulepaymentdetil_descr; ?></td>
    <td class="tg-za14"><?php echo date('d-m-Y',strtotime($row->schedulepaymentdetil_date)); ?></td>
    <td class="tg-za14"><?php echo date('d-m-Y',strtotime($row->schedulepaymentdetil_duedate)); ?></td>
    <td class="tg-jkyp"><?php echo  number_format($idr_paymentdetil); ?></td>
    <td class="tg-jkyp"><?php echo number_format((($row->schedulepaymentdetil_idr*$row->schedulepaymentdetil_tax) / 100 )); ?></td>
    <td class="tg-jkyp"><?php echo number_format($idr); ?></td>
    <td class="tg-za14"><?php echo $row->invoice_id; ?></td>
    <td class="tg-za14"><?php echo $row->faktur_id; ?></td>
    <td class="tg-za14"><?php echo $row->jurnal_id; ?></td>
    <td class="tg-za14"><?php echo date('d-m-Y',strtotime($row->jurnal_date)); ?></td>
    <td class="tg-jkyp"><?php echo number_format($idr_jurnal); ?></td> 
    <td class="tg-jkyp"><?php echo number_format( $idr_saldo ); ?></td>
  </tr>
  

<?php  
	 $idrx += $idr;
	 $idr_paymentdetilx += $idr_paymentdetil; 
	 $idrt += $idr;
	 $idr_paymentdetilt += $idr_paymentdetil;
	 $idr_jurnalx += $idr_jurnal;
	 $idr_jurnalt += $idr_jurnal;
	 $idr_saldox += $idr_saldo;
	 $idr_saldot += $idr_saldo;
	 if(@$result[$data+1]->agreementtype_id != $row->agreementtype_id ) { 
	  // echo $idr_paymentdetil;
	 
?> 
 <tr>
    <td class="tg-jkyp" colspan="2">Total</td>
    <td class="tg-za14"></td>
    <td class="tg-jkyp"><?php echo  number_format($idr_paymentdetilx); ?></td>
    <td class="tg-za14"></td>
    <td class="tg-jkyp"><?php echo  number_format($idrx); ?></td>
    <td class="tg-za14"></td>
    <td class="tg-za14"></td>
    <td class="tg-za14"></td>
    <td class="tg-za14"></td>
    <td class="tg-jkyp"><?php echo  number_format($idr_jurnalx); ?></td> 
    <td class="tg-jkyp"><?php echo  number_format($idr_saldox); ?></td>
  </tr>
   
<?php
	$idrx=0;
	$idr_paymentdetilx=0;
	$idr_jurnalx=0;
	$idr_saldox=0;
	}
	
     endforeach;
	 
	 $agrid = '';
	endif;
?>
  <tr>
    <td class="tg-jkyp" colspan="2">Grand Total</td>
    <td class="tg-za14"></td>
    <td class="tg-jkyp"><?php echo  number_format($idr_paymentdetilt); ?></td>
    <td class="tg-za14"></td>
    <td class="tg-jkyp"><?php echo  number_format($idrt); ?></td>
    <td class="tg-za14"></td>
    <td class="tg-za14"></td>
    <td class="tg-za14"></td>
    <td class="tg-za14"></td>
    <td class="tg-jkyp"><?php echo  number_format($idr_jurnalt); ?></td> 
    <td class="tg-jkyp"><?php echo  number_format($idr_saldot); ?></td>
  </tr>
</tbody>
</table>
</table>
</div>

</form>
