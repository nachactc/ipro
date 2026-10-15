 <?php  
  if ($button == 'EXCEL')
  {

	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename=AMORTISASI_DETAIL_REPORT.xls");
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
<table class="tg" style="undefined;table-layout: fixed; width: 2074px" id="DetailPaymentTypeReport_<?php echo $year.'_'.date('d_m_Y_s') ?>"> 
<colgroup>
<col style="width: 169px">
<col style="width: 253px">
<col style="width: 258px">
<col style="width: 192px">
<col style="width: 137px">
<col style="width: 328px">
<col style="width: 176px">
<col style="width: 171px">
<col style="width: 157px">
<col style="width: 270px">
<col style="width: 163px">
</colgroup>
  <tr>
    <th class="tg-c3ow" colspan="11">Payment Type Report Detil <br/> <?php echo getIndoHari($sdate)." - ".getIndoHari($edate); ?></th>
  </tr>
  <tr>
    <td class="tg-0pky" colspan="11"><?php echo $region_nm; ?></td>
  </tr>
  <tr>
    <td class="tg-0pky" colspan="11"><?php echo $branch_nm; ?></td>
  </tr> 
  <tr>
    <td class="tg-0pky" colspan="11"><?php echo $rekanan_name; ?></td>
  </tr> 
  <tr>
    <td class="tg-0pky">Type</td>
    <td class="tg-uys7">Tenant</td>
    <td class="tg-uys7">Brand</td>
    <td class="tg-uys7">Virtual Account</td>
    <td class="tg-uys7">Debtor</td>
    <td class="tg-c3ow">Invoice Descr</td>
    <td class="tg-uys7">Invoice</td>
    <td class="tg-uys7">Jurnal</td>
    <td class="tg-c3ow">Jurnal Date</td>
    <td class="tg-uys7">Jurnal Descr</td>
    <td class="tg-uys7">IDR</td>
  </tr>
  <?php
   function rupiah($angka){ 
		$hasil_rupiah = number_format($angka,0);
		//$hasil_rupiah = $angka;
		return $hasil_rupiah; 
	} 
  $sub_idr = 0;
  $total_idr = 0;
	if($data_detil):
	foreach($data_detil as $row => $val):
  ?>
  <tr>
    <td class="tg-0pky"><?php echo $val->agreementtype_group; ?></td>
    <td class="tg-xldj"><?php echo $val->rekanan_name; ?></td>
    <td class="tg-xldj"><?php echo $val->rekananshipping_name; ?></td>
    <td class="tg-xldj"><?php echo $val->agreement_virtualaccount; ?></td>
    <td class="tg-xldj"><?php echo $val->debtor_no; ?></td>
    <td class="tg-0pky"><?php echo $val->descr; ?></td>
    <td class="tg-xldj"><?php echo $val->invoice_id; ?></td>
    <td class="tg-xldj"><?php echo $val->jurnal_id; ?></td>
    <td class="tg-0pky"><?php echo date('d-m-Y',strtotime($val->jurnal_bookdate)); ?></td>
    <td class="tg-xldj"><?php echo $val->jurnal_descr; ?></td>
    <td class="tg-quj4"><?php echo rupiah($val->jurnaldetil_idr); ?></td>
  </tr>
  <?php
  $sub_idr += $val->jurnaldetil_idr; 
  if(@$data_detil[$row+1]->agreementtype_group != $val->agreementtype_group )   
  {
	
?>
	
  <tr>
    <td class="tg-dvpl" colspan="10">Sub Total</td>
    <td class="tg-quj4"> <?php echo rupiah($sub_idr); ?></td>
  </tr>
  
<?php
	$total_idr += $sub_idr;
	$sub_idr = 0;
  }
  
  endforeach;
  endif;
  ?>
  <tr>
    <td class="tg-dvpl" colspan="10">Total</td>
    <td class="tg-dvpl"><?php echo rupiah($total_idr); ?></td>
  </tr>
</table>
 