<?php //echo var_dump($header); ?>

<!-- HEADER AREA -->
<style type="text/css">  
html,body{
        height:297mm;
        width:210mm;
    }
.tg  {border-collapse:collapse;border-spacing:0;height:10px}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-0uih{font-weight:bold;font-family:"Times New Roman", Times, serif !important;;border-color:#ffffff;text-align:left;vertical-align:top}
.tg .tg-5tqt{font-weight:bold;font-family:"Times New Roman", Times, serif !important;;border-color:#ffffff;text-align:center;vertical-align:middle}
.tg .tg-ex2i{font-family:"Times New Roman", Times, serif !important;;border-color:#ffffff;text-align:left;vertical-align:middle}
.tg .tg-xv21{font-weight:bold;font-family:"Times New Roman", Times, serif !important;;border-color:#ffffff;text-align:left;vertical-align:middle}
.tg .tg-juxo{font-family:"Times New Roman", Times, serif !important;;border-color:#ffffff;text-align:center;vertical-align:middle}
.tg .tg-p4o4{text-decoration:underline;font-family:"Times New Roman", Times, serif !important;;border-color:#ffffff;text-align:left;vertical-align:middle}
.tg .tg-gnwc{text-decoration:underline;font-family:"Times New Roman", Times, serif !important;;border-color:#ffffff;text-align:left;vertical-align:top}
.tg .tg-d0ae{font-family:"Times New Roman", Times, serif !important;;border-color:#ffffff;text-align:left;vertical-align:top}
</style>
<table class="tg" style="undefined;table-layout: fixed; width: 780px;">
<colgroup>
<col style="width: 96px">
<col style="width: 244px">
<col style="width: 96px">
<col style="width: 184px">
<col style="width: 107px">
<col style="width: 115px">
</colgroup> 
  <tr >
    <th class="tg-ex2i" rowspan="2"><img src="<?php echo base_url('assets/img/logo_TSM.jpg'); ?>" alt="TSM" height="81" width="82" /></th>
    <th class="tg-xv21" colspan="3" style="font-size:20;"><?php echo $header->branch_name; ?></th>
    <th class="tg-ex2i" style="height:1px;"></th>
    <th class="tg-ex2i" style="height:1px;"></th>
  </tr>
  <tr>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
    <td class="tg-5tqt" colspan="3"><?php echo $title; ?></td>
  </tr>
  <tr>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
    <td class="tg-juxo" colspan="3"><?php echo $jurnal_id; ?></td>
  </tr>
  <tr>
    <td class="tg-xv21">Receipt</td>
    <td class="tg-p4o4"><?php echo $header->rekanan_name; ?></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i">Source</td>
    <td class="tg-p4o4"><?php echo $header->jurnal_source; ?></td>
  </tr>
  <tr>
    <td class="tg-xv21">Branch</td>
    <td class="tg-p4o4"><?php echo $detil[0]->rekananshipping_name; ?></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
  </tr>
  <tr>
    <td class="tg-xv21">Create</td>
    <td class="tg-p4o4"><?php echo date('d-m-Y',strtotime($header->jurnal_createdate)); ?></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
  </tr>
  <tr>
    <td class="tg-xv21">Period</td>
    <td class="tg-p4o4"><?php echo $header->periode_name; ?></td>
    <td class="tg-xv21">Bookdate</td>
    <td class="tg-p4o4"><?php echo date('d-m-Y',strtotime($header->jurnal_bookdate)); ?></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
  </tr>
  <tr>
    <td class="tg-xv21">Descr</td>
    <td class="tg-p4o4"><?php echo $header->jurnal_descr; ?></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i">Payment Type</td>
    <td class="tg-p4o4"><?php echo $payment; ?></td>
  </tr>
  <tr>
    <td class="tg-0uih">Amount</td>
    <td class="tg-gnwc"><?php echo number_format($header->jurnal_idr,0); ?></td>
    <td class="tg-0uih">Foreign/Rate</td>
    <td class="tg-gnwc"><?php echo $detil[0]->jurnaldetil_foreign.' / '.$detil[0]->jurnaldetil_foreignrate ; ?></td>
    <td class="tg-d0ae"></td>
    <td class="tg-d0ae"></td>
  </tr>
  <tr>
    <td class="tg-d0ae"></td>
    <td class="tg-d0ae"></td>
    <td class="tg-d0ae"></td>
    <td class="tg-d0ae"></td>
    <td class="tg-d0ae"></td>
    <td class="tg-d0ae"></td>
  </tr>
</table>
<!-- END HEADER AREA -->

<!-- DETIL AREA -->
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-cly1{text-align:left;vertical-align:middle}
.tg .tg-415f{text-decoration:underline;text-align:left;vertical-align:middle}
.tg .tg-y93n{background-color:#c0c0c0;text-align:left;vertical-align:middle}
.tg .tg-y6fn{background-color:#c0c0c0;text-align:left;vertical-align:top}
.tg .tg-0lax{text-align:left;vertical-align:top}
</style>

<table class="tg" style="undefined;table-layout: fixed; width: 821px;height:10px;">
<colgroup>
<col style="width: 106px">
<col style="width: 240px">
<col style="width: 63px">
<col style="width: 207px">
<col style="width: 205px">
</colgroup>
  <tr>
    <th class="tg-y93n" colspan="2"><strong>Description</strong></th>
    <th class="tg-y6fn"><strong>Curr</strong></th>
    <th class="tg-y93n"><strong>IDR</strong></th>
    <th class="tg-y93n"><strong>Foreign</strong></th>
  </tr>
  <?php 
  $idr_total = 0;  
  foreach($detil as $row): 
	$idr_total = ($row->jurnaldetil_idr <0 ) ? ($idr_total + ($row->jurnaldetil_idr*-1)) : 0;
	
	if($row->jurnaldetil_idr < 0) : 
  ?>
   <tr>
    <td class="tg-cly1" colspan="2" rowspan="2"><?php echo $row->jurnaldetil_descr;?></td>
    <td class="tg-cly1" rowspan="2"><?php echo $row->currency_id;?></td>
    <td class="tg-cly1" rowspan="2"><?php echo ($row->jurnaldetil_idr > 0) ? '' : number_format($row->jurnaldetil_idr*-1,0); ?></td>
    <td class="tg-cly1" rowspan="2"><?php echo number_format($row->jurnaldetil_foreignrate,0);?></td>
  </tr>
  <?php 
  endif;
  endforeach; ?>
  <!--<tr>
    <td class="tg-cly1" colspan="2" rowspan="2">x</td>
    <td class="tg-0lax" rowspan="2"></td>
    <td class="tg-cly1" rowspan="2">100000</td>
    <td class="tg-cly1" rowspan="2">0</td>
  </tr>-->
  <tr>
  </tr>
  <tr>
    <td class="tg-cly1"><strong>Bank</strong></td>
    <td class="tg-415f"><?php echo ($detil[0]->jurnalbilyet_bank != '') ? $detil[0]->jurnalbilyet_bank : '-'; ?></td>
    <td class="tg-0lax"></td>
    <td class="tg-cly1"></td>
    <td class="tg-cly1"></td>
  </tr>
  <tr>
    <td class="tg-cly1"><strong>Bilyet No</strong></td>
    <td class="tg-415f"><?php echo ($detil[0]->jurnalbilyet_no != '') ?$detil[0]->jurnalbilyet_no:'-'; ?></td>
    <td class="tg-0lax"></td>
    <td class="tg-cly1"></td>
    <td class="tg-cly1"></td>
  </tr>
  <tr>
    <td class="tg-cly1"><strong>Receipt By</strong></td>
    <td class="tg-415f"><?php echo ($detil[0]->jurnalbilyet_receiveperson != '') ? $detil[0]->jurnalbilyet_receiveperson : '-'; ?></td>
    <td class="tg-0lax"></td>
    <td class="tg-cly1"></td>
    <td class="tg-cly1"></td>
  </tr>
  <tr>
    <td class="tg-cly1"><strong>Received Date</strong></td>
    <td class="tg-415f"><?php echo date('d-m-Y',strtotime($detil[0]->jurnalbilyet_date)); ?></td>
    <td class="tg-0lax"></td>
    <td class="tg-cly1"></td>
    <td class="tg-cly1"></td>
  </tr>
  <tr>
    <td class="tg-0lax" colspan="3"><strong>Total</strong></td>
    <td class="tg-0lax"><?php echo ($idr_total > 0) ? number_format($idr_total,0) : number_format($header->jurnal_idr,0); ?></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
  </tr>
</table>
 

<!-- END DETIL AREA -->
 
<!-- REF AREA -->


<br/>
 
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-cly1{text-align:left;vertical-align:middle}
.tg .tg-kftd{background-color:#efefef;text-align:left;vertical-align:top}
.tg .tg-gg7l{background-color:#efefef;text-align:left;vertical-align:middle}
.tg .tg-0lax{text-align:left;vertical-align:top}
</style>

<?php  
  $idr_total = 0; 
  $id = '';
  //echo'<pre/>';echo var_dump($ref);exit;
  
  
  foreach($ref as $num=>$ref_row):
  if($ref[$num] != 'kosong'): 
?>
<table class="tg" style="undefined;table-layout: fixed; width: 822px">
<colgroup>
<col style="width: 34px">
<col style="width: 52px">
<col style="width: 430px">
<col style="width: 67px">
<col style="width: 117px">
<col style="width: 119px">
</colgroup>
   <tr>
    <th class="tg-gg7l"><strong>No</strong></th>
    <th class="tg-gg7l"><strong>Line</strong></th>
    <th class="tg-gg7l"><strong>Account / Description</strong></th>
    <th class="tg-gg7l"><strong>Curr</strong></th>
    <th class="tg-kftd"><strong>IDR</strong></th>
    <th class="tg-kftd"><strong>Foreign</strong></th>
  </tr>
  <tr>
<?php  
	foreach($ref_row as $rows=>$data_row):  
	
		$idr = number_format($data_row->jurnaldetil_idr,0);
		$idrF = number_format($data_row->jurnaldetil_foreign,0);  
	
  ?>

  <?php if(@$ref_row[$rows+0]->jurnal_id != $id): ?>
    <td class='tg-cly1' colspan="6"> <strong> Ref. <?php echo $data_row->jurnal_id; ?> </strong></td> 
	<?php 
    endif;  
	?> 
  </tr> 
  <tr>
    <td class='tg-cly1'> </td>
	<td class='tg-cly1'><?php echo $data_row->jurnaldetil_line;?></td>
	<td class='tg-cly1'><?php echo $data_row->acc_name;?></td>
	<td class='tg-cly1'><?php echo $data_row->currency_id;?></td>
	<td class='tg-0lax'><?php echo $idr;?></td>
	<td class='tg-0lax'><?php echo $idrF;?> </td>
  </tr> 
 
<?php 
		
		$id = $data_row->jurnal_id;	
		endforeach;   
		echo "</table>";
		echo "<br/>";
        endif; 
	endforeach; 
	
	?>
<!-- END REF AREA -->

<label><i> Print Date <?php echo date('d-m-Y'); ?></i></label>
<br/>
<!-- TTD AREA -->
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-z4i2{border-color:#ffffff;text-align:left;vertical-align:middle}
.tg .tg-44qx{font-weight:bold;border-color:#ffffff;text-align:center;vertical-align:middle}
.tg .tg-v0mg{border-color:#ffffff;text-align:center;vertical-align:middle}
.tg .tg-3ge6{text-decoration:underline;border-color:#ffffff;text-align:center;vertical-align:top}
</style>
<table class="tg" style="undefined;table-layout: fixed; width: 794px">
<colgroup>
<col style="width: 150px">
<col style="width: 151px">
<col style="width: 151px">
<col style="width: 171px">
</colgroup>
<?php if($payment == 'Receipt Voucher') : ?>
  <tr>
    <th class="tg-44qx">Prepared  By</th>
    <th class="tg-44qx">Approve by</th>
    <th class="tg-44qx">Checked By</th>
    <th class="tg-44qx">Posted By</th>
  </tr>
  <tr> 
    <td class="tg-v0mg">Collection</td>
    <td class="tg-v0mg">Collection Manager</td>
    <td class="tg-v0mg">Accounting</td>
    <td class="tg-v0mg">Accounting Manager</td>
  </tr>
  <tr>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
  </tr>
  <tr>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
  </tr>
  <tr>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
  </tr>
  <tr>
    <td class="tg-3ge6"><?php echo get_setting('printor_prepby'); ?></td>
    <td class="tg-3ge6"><?php echo get_setting('printor_name_col_mgr'); ?></td>
    <td class="tg-3ge6"><?php echo get_setting('printor_acc'); ?></td>
    <td class="tg-3ge6"><?php echo get_setting('printor_acc_mgr'); ?></td>
  </tr>
  <?php 
	endif; 
	if($payment == 'Refund') :
  ?>
  <tr>
    <th class="tg-44qx">Prepared  By</th>
    <th class="tg-44qx">Checked By</th>
    <th class="tg-44qx">Controlled By</th>
    <th class="tg-44qx">Director Approved</th>
  </tr>
  <tr> 
    <td class="tg-v0mg">Cashier / AP</td>
    <td class="tg-v0mg">Accounting</td>
    <td class="tg-v0mg">Finance Controller</td>
    <td class="tg-v0mg">CEO / CFO</td>
  </tr>
  <tr>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
  </tr>
  <tr>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
  </tr>
  <tr>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
    <td class="tg-z4i2"> </td>
  </tr>
  <tr>
    <td class="tg-3ge6"><?php echo get_setting('printor_prepby'); ?></td>
    <td class="tg-3ge6"><?php echo get_setting('printor_checkedby'); ?></td>
    <td class="tg-3ge6"><?php echo get_setting('printor_fincontrol'); ?></td>
    <td class="tg-3ge6"><?php echo get_setting('printor_ceo'); ?></td>
  </tr>
  <?php endif; ?> 
</table>
<!-- END TTD AREA -->