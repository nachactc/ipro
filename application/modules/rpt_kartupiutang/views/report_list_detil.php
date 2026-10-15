<title> <?php echo $title; ?> </title> 
  
 
<table class="table table-responsive table-bordered table-hover table-striped w-100 table-responsive tg " id="reports_table" data-tableName="table-report"  style="width: 100%">
 
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
    <th  style="background-color:#c0c0c0;border-color:inherit; min-width:100px;width:100px;">Type</th>
    <th  style="background-color:#c0c0c0;border-color:inherit;min-width:250px;width:250px;">Descr</th>
    <th  style="background-color:#c0c0c0;border-color:inherit;min-width:90px;width:90px;">Date</th>
    <th  style="background-color:#c0c0c0;border-color:inherit;min-width:90px;width:90px;">Due Date</th>
    <th  style="background-color:#c0c0c0;border-color:inherit;min-width:50px;width:50px;">Invoice(IDR)</th>
    <th  style="background-color:#c0c0c0;border-color:inherit;min-width:50px;width:50px;">VAT(IDR)</th>
    <th  style="background-color:#c0c0c0;border-color:inherit;min-width:50px;width:50px;">Total(IDR)</th>
    <th  style="background-color:#c0c0c0;border-color:inherit;min-width:150px;width:150px;">No.Invoice</th>
    <th  style="background-color:#c0c0c0;border-color:inherit;min-width:150px;width:150px;">No. Faktur Pajak</th>
    <th  style="background-color:#c0c0c0;border-color:inherit;min-width:150px;width:150px;">No. Official Receipt</th>
    <th  style="background-color:#c0c0c0;border-color:inherit;min-width:150px;width:150px;">Tgl. Official Receipt</th>
    <th  style="background-color:#c0c0c0;border-color:inherit;min-width:150px;width:150px;">Official Receipt(IDR)</th> 
    <th  style="background-color:#c0c0c0;border-color:inherit;min-width:150px;width:150px;">Saldo Akhir</th>
  </tr>
</thead>
<tbody>
<?php  

if(($result != 'kosong') AND (count($result)>0) ) :
$agrid = ''; 
$idrt=0;
$idr_paymentdetilt=0; 
$idr_jurnalt=0; 
$idr_saldot=0;
?>
	
<?php
	foreach($result as $data => $row) : 
	// echo @$result[$data+1]->agreementtype_name.' - '. $row->agreementtype_name."<br/>";
	
?> 
	 <?php    
	 $agrid = $row->agreementtype_id;
	 $idr = (($row->schedulepaymentdetil_idr*$row->schedulepaymentdetil_tax) / 100 )+$row->schedulepaymentdetil_idr;
	 $idr_paymentdetil = $row->schedulepaymentdetil_idr;
	 $idr_jurnal = $row->jurnaldetil_idr;
	 $idr_saldo = $idr - ($idr_jurnal);
?> 
  <tr> 
    <td ><?php echo $row->agreementtype_name; ?></td>
    <td ><?php echo $row->schedulepaymentdetil_descr; ?></td>
    <td ><?php echo date('d-m-Y',strtotime($row->schedulepaymentdetil_date)); ?></td>
    <td ><?php echo date('d-m-Y',strtotime($row->schedulepaymentdetil_duedate)); ?></td>
    <td class="tg-jkyp"><?php echo  number_format($idr_paymentdetil); ?></td>
    <td class="tg-jkyp"><?php echo number_format((($row->schedulepaymentdetil_idr*$row->schedulepaymentdetil_tax) / 100 )); ?></td>
    <td class="tg-jkyp"><?php echo number_format($idr); ?></td>
    <td ><?php echo $row->invoice_id; ?></td>
    <td ><?php echo $row->faktur_id; ?></td>
    <td ><?php echo $row->jurnal_id; ?></td>
    <td ><?php echo date('d-m-Y',strtotime($row->jurnal_date)); ?></td>
    <td class="tg-jkyp"><?php echo number_format($idr_jurnal); ?></td> 
    <td class="tg-jkyp"><?php echo number_format( $idr_saldo ); ?></td>
  </tr>
  

<?php   
	 $idrt += $idr;
	 $idr_paymentdetilt += $idr_paymentdetil; 
	 $idr_jurnalt += $idr_jurnal; 
	 $idr_saldot += $idr_saldo;  
     endforeach; 
	 $agrid = '';
	endif;
?>
 
</tbody>
</table>
</table>
 
 
