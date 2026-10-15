<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-oe15{background-color:#ffffff;border-color:#ffffff;text-align:left;vertical-align:top}
.tg .tg-9248{font-weight:bold;font-family:"Times New Roman", Times, serif !important;;background-color:#ffffff;border-color:#ffffff;text-align:center;vertical-align:top}
.tg .tg-cy0b{font-size:12px;font-family:"Times New Roman", Times, serif !important;;background-color:#ffffff;border-color:#ffffff;text-align:left;vertical-align:top}
.tg .tg-hkrl{font-size:13px;font-family:"Times New Roman", Times, serif !important;;background-color:#efefef;border-color:#ffffff;text-align:center;vertical-align:top}
.tg .tg-aa48{font-size:12px;font-family:"Times New Roman", Times, serif !important;;background-color:#ffffff;color:#fd6864;border-color:#ffffff;text-align:right;vertical-align:top}
.tg .tg-8ur7{font-size:12px;font-family:"Times New Roman", Times, serif !important;;background-color:#ffffff;color:#fd6864;border-color:#ffffff;text-align:left;vertical-align:top}
</style>
<link href="<?php echo base_url()."assets/plugins/exportexcel/dist/css/tableexport.css" ?>" rel="stylesheet" type="text/css">

<div align="left" id="buttonExport"></div>

 <title> Report <?php echo $title; ?> </title>
<?php  if($result != 'kosong'){ ?>

<table class="tg"  id="AgingDetail_<?php echo date('d_m_Y_s') ?>" style="undefined;table-layout: fixed; width: 1785px; line-height:5px">
<colgroup>
<col style="width: 134px">
<col style="width: 190px">
<col style="width: 150px">
<col style="width: 102px">
<col style="width: 60px">
<col style="width: 264px">
<col style="width: 117px">
<col style="width: 101px">
<col style="width: 99px">
<col style="width: 96px">
<col style="width: 105px">
<col style="width: 114px">
<col style="width: 89px">
<col style="width: 160px">
<col style="width: 180px">
<col style="width: 135px">
</colgroup>
  <tr>
    <th class="tg-9248" colspan="16"> <?php echo strtoupper($result[0]->region_name); ?></th>
  </tr>
  <tr>
    <td class="tg-9248" colspan="16">DEBTOR <?php echo strtoupper($title); ?> REPORT TANGGAL <?php echo strtoupper(getIndoHari(date('Y-m-d',strtotime($enddate)))); ?> </td>
  </tr>
  <tr>
    <td class="tg-oe15" colspan="16">Total Data : <?php echo number_format(count($result),0,',','.'); ?> Row(s)</td>
  </tr>
  <tr>
    <td class="tg-hkrl" colspan="2">Document No</td>
    <td class="tg-hkrl">Tax No</td>
    <td class="tg-hkrl">Trx Date</td>
    <td class="tg-hkrl">Trx</td>
    <td class="tg-hkrl">Description</td>
    <td class="tg-hkrl">&lt;= 14 Days</td>
    <td class="tg-hkrl">15-30 Days</td>
    <td class="tg-hkrl">31-60 Days</td>
    <td class="tg-hkrl">61-90 Days</td>
    <td class="tg-hkrl">91-120 Days</td>
    <td class="tg-hkrl">121-150 Days</td>
    <td class="tg-hkrl">&gt;150 Days</td>
    <td class="tg-hkrl">Total Outstanding</td>
    <td class="tg-hkrl">Unallocated Amount Dr/Cr</td>
    <td class="tg-hkrl">Deposite To Date</td>
  </tr>
  <?php 
	 function rupiah($angka){ 
		$hasil_rupiah = number_format($angka,0);
		//$hasil_rupiah = $angka;
		return $hasil_rupiah; 
	}
	$Branch 		='';
	$rekanan 		='';
	$DeductTyp 		=2;
	
	$tot_outstanding = 0;
	//variabel subtotal
	$amount0_subtotal = 0;
	$amount30_subtotal = 0;
	$amount60_subtotal = 0;
	$amount90_subtotal = 0;
	$amount120_subtotal = 0;
	$amount150_subtotal = 0;
	$amount151_subtotal = 0;
	$amountAllocation_subtotal = 0;
	$amountDeposit_subtotal = 0;  
	$tot_outstanding_subtotal = 0;
	//variabel total
	$amount0_total = 0;
	$amount30_total = 0;
	$amount60_total = 0;
	$amount90_total = 0;
	$amount120_total = 0;
	$amount150_total = 0;
	$amount151_total = 0;
	$amountAllocation_total = 0;
	$amountDeposit_total = 0;  
	$tot_outstanding_total = 0;
	
	
	$amountVal= 0;
	foreach($result as $row=>$val) { //foreach 1 result 
	//variabel
	$amount0 = 0;
	$amount30 = 0;
	$amount60 = 0;
	$amount90 = 0;
	$amount120 = 0;
	$amount150 = 0;
	$amount151 = 0;
	$amountAllocation = 0;
	$amountDeposit = 0; 
	//echo var_dump($val);
	switch(true)
	{
		
		 case ($val->amount < 0 && $val->transaksi_type = '0101'  ): 
			$amountAllocation = abs($val->amount);  
			
			//$val->amount = 0;
			break;
		 case ($val->acc_id == $depositAcc):
			$amountDeposit =abs($val->amount);
			//$val->amount = 0;			
			break;
		 case ($val->due < 15):
			$amount0 =abs($val->amount); 
			break;
		 case ($val->due < 31):
			$amount30 =abs($val->amount); 
			break;
		 case ($val->due < 61):
			$amount60 =abs($val->amount); 
			break;
		 case ($val->due < 91):
			$amount90 =abs($val->amount); 
			break;
		 case ($val->due < 121):
			$amount120 =abs($val->amount); 
			break;
		 case ($val->due < 151):
			$amount150 =abs($val->amount); 
			break;
		 case ($val->due > 151):
			$amount151 = abs($val->amount); 
			break; 
	}
	$tot_outstanding = abs($amount0+$amount30+$amount60+$amount90+$amount120+$amount150+$amount151);
	$tot_outstanding = ($tot_outstanding);
	
	$amount0_subtotal += $amount0;
	$amount30_subtotal += $amount30;
	$amount60_subtotal += $amount60;
	$amount90_subtotal += $amount90;
	$amount120_subtotal += $amount120;
	$amount150_subtotal += $amount150;
	$amount151_subtotal += $amount151;
	$amountAllocation_subtotal += $amountAllocation;
	$amountDeposit_subtotal += $amountDeposit;  
	$tot_outstanding_subtotal += $tot_outstanding;
	
	
	
	if($Branch != $val->branch_id)
	{
  ?>
  <tr>
    <td class="tg-cy0b">Project No</td>
    <td class="tg-cy0b" colspan="15"><?php echo $val->branch_code.' - '.$val->branch_name; ?></td>
  </tr>  
  <?php 
	}//end $Branch 
	if($DeductTyp != $val->deduct_type )
	{
  ?>
  <tr>
	<td class="tg-cy0b">Debtor Type</td>
	<td class="tg-cy0b" colspan="15"><?php echo $val->deduct_type == false ? 'AT    AR PT / Personal Wht Deduct By Tenant' : 'AP    AR Personal Wht Deduct By LandLord' ?></td>
  </tr> 
   <?php
	}//end $DeductTyp
   ?>
  <?php 
	if($rekanan != $val->rekanan_id )  //if contract_no
	{
  ?>
  <tr>
    <td class="tg-cy0b" style="background-color:#F4F6F7;border-color:#F4F6F7;">Debtor A/C</td>
    <td class="tg-cy0b" colspan="15" style="background-color:#F4F6F7;border-color:#F4F6F7;"><?php echo $val->contract_no.' - '.$val->rekanan_name.' - '.$val->rekananshipping_name ; ?></td>
  </tr> 
 
  <?php 
	$contract = '';
	} //end if contract_no
  ?>  
 
   <tr nowrap>
    <td class="tg-cy0b" nowrap><?php echo date('d-m-Y',strtotime($val->duedate)) ;?></td>
    <td class="tg-cy0b" nowrap><?php echo $val->jurnal_id; ?></td>
    <td class="tg-cy0b" nowrap><?php echo $val->faktur_id; ?></td>
    <td class="tg-cy0b" nowrap><?php echo date('d-m-Y',strtotime($val->duedate)) ;?></td>
    <td class="tg-cy0b" nowrap><?php echo $val->transaksi_trx; ?></td>
    <td class="tg-cy0b" nowrap><?php echo str_replace('Receipt Mega 00809','Receipt Mega_00809',$val->jurnal_descr); ?></td>
    <td class="tg-cy0b" nowrap style="text-align: right;"><?php echo rupiah($amount0); ?></td>
    <td class="tg-cy0b" nowrap style="text-align: right;"><?php echo rupiah($amount30); ?></td>
    <td class="tg-cy0b" nowrap style="text-align: right;"><?php echo rupiah($amount60); ?></td>
    <td class="tg-cy0b" nowrap style="text-align: right;"><?php echo rupiah($amount90); ?></td>
    <td class="tg-cy0b" nowrap style="text-align: right;"><?php echo rupiah($amount120); ?></td>
    <td class="tg-cy0b" nowrap style="text-align: right;"><?php echo rupiah($amount150); ?></td>
    <td class="tg-cy0b" nowrap style="text-align: right;"><?php echo rupiah($amount151); ?></td>
    <td class="tg-cy0b" nowrap style="text-align: right;"><?php echo rupiah($tot_outstanding); ?></td>
    <td class="tg-cy0b" nowrap style="text-align: right;"><?php echo rupiah($amountAllocation); ?></td>
    <td class="tg-cy0b" nowrap style="text-align: right;"><?php echo rupiah($amountDeposit); ?></td>
  </tr>
 
   <?php 
	if(@$result[$row+1]->rekanan_id != $val->rekanan_id )  //if contract_no
	{
		$amount0_total += $amount0_subtotal;
		$amount30_total += $amount30_subtotal;
		$amount60_total += $amount60_subtotal;
		$amount90_total += $amount90_subtotal;
		$amount120_total += $amount120_subtotal;
		$amount150_total += $amount150_subtotal;
		$amount151_total +=$amount151_subtotal;
		$amountAllocation_total += $amountAllocation_subtotal;
		$amountDeposit_total += $amountDeposit_subtotal;  
		$tot_outstanding_total += $tot_outstanding_subtotal;
  ?>
 
	<tr>
    <td class="tg-aa48" colspan="6" >Debtor Total</td>
    <td class="tg-8ur7" style="text-align: right;"><?php echo rupiah($amount0_subtotal);?></td>
    <td class="tg-8ur7" style="text-align: right;"><?php echo rupiah($amount30_subtotal);?></td>
    <td class="tg-8ur7" style="text-align: right;"><?php echo rupiah($amount60_subtotal);?></td>
    <td class="tg-8ur7" style="text-align: right;" ><?php echo rupiah($amount90_subtotal);?></td>
    <td class="tg-8ur7" style="text-align: right;"><?php echo rupiah($amount120_subtotal);?></td>
    <td class="tg-8ur7" style="text-align: right;"><?php echo rupiah($amount150_subtotal);?></td>
    <td class="tg-8ur7" style="text-align: right;"><?php echo rupiah($amount151_subtotal);?></td>
    <td class="tg-8ur7" style="text-align: right;"><?php echo rupiah($tot_outstanding_subtotal);?></td>
    <td class="tg-8ur7" style="text-align: right;"><?php echo rupiah($amountAllocation_subtotal);?></td>
    <td class="tg-8ur7" style="text-align: right;"><?php echo rupiah($amountDeposit_subtotal);?></td>
  </tr>
   <?php  
   
	//variabel subtotal reset
	$amount0_subtotal = 0;
	$amount30_subtotal = 0;
	$amount60_subtotal = 0;
	$amount90_subtotal = 0;
	$amount120_subtotal = 0;
	$amount150_subtotal = 0;
	$amount151_subtotal = 0;
	$amountAllocation_subtotal = 0;
	$amountDeposit_subtotal = 0;  
	$tot_outstanding_subtotal = 0;
	//variabel total reset
	
	
	} //end if contract_no  
	$Branch = $val->branch_id;
	$DeductTyp = $val->deduct_type; 
	$rekanan = $val->rekanan_id; 
	} //end foreach 1 result 
	
  ?> 
  
  
  <tr>
    <td class="tg-aa48" colspan="6" style="background-color:#BDC3C7;border-color:#BDC3C7;">Grand Total</td>
    <td class="tg-8ur7"  style="text-align: right;background-color:#BDC3C7;border-color:#BDC3C7;"><?php echo rupiah($amount0_total);?></td>
    <td class="tg-8ur7" style="text-align: right;background-color:#BDC3C7;border-color:#BDC3C7;"><?php echo rupiah($amount30_total);?></td>
    <td class="tg-8ur7" style="text-align: right;background-color:#BDC3C7;border-color:#BDC3C7;"><?php echo rupiah($amount60_total);?></td>
    <td class="tg-8ur7" style="text-align: right;background-color:#BDC3C7;border-color:#BDC3C7;"><?php echo rupiah($amount90_total);?></td>
    <td class="tg-8ur7" style="text-align: right;background-color:#BDC3C7;border-color:#BDC3C7;"><?php echo rupiah($amount120_total);?></td>
    <td class="tg-8ur7" style="text-align: right;background-color:#BDC3C7;border-color:#BDC3C7;"><?php echo rupiah($amount150_total);?></td>
    <td class="tg-8ur7" style="text-align: right;background-color:#BDC3C7;border-color:#BDC3C7;"><?php echo rupiah($amount151_total);?></td>
    <td class="tg-8ur7" style="text-align: right;background-color:#BDC3C7;border-color:#BDC3C7;"><?php echo rupiah($tot_outstanding_total);?></td>
    <td class="tg-8ur7" style="text-align: right;background-color:#BDC3C7;border-color:#BDC3C7;"><?php echo rupiah($amountAllocation_total);?></td>
    <td class="tg-8ur7" style="text-align: right;background-color:#BDC3C7;border-color:#BDC3C7;"><?php echo rupiah($amountDeposit_total);?></td>
  </tr>
</table>

<?php } else { echo "Data Aging Kosong"; }  ?>
<script src="<?php echo base_url('assets/plugins/jquery.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/plugins/exportexcel/" ?>xls.core.js"></script>
<script src="<?php echo base_url()."assets/plugins/exportexcel/" ?>Blob.js"></script>
<script src="<?php echo base_url()."assets/plugins/exportexcel/" ?>FileSaver.js"></script>

<script src="<?php echo base_url()."assets/plugins/exportexcel/dist/js/tableexport.js" ?>"></script>
<script>
 
 $("table").tableExport({
	 headings: true,                    // (Boolean), display table headings (th/td elements) in the <thead>
    footers: true,                     // (Boolean), display table footers (th/td elements) in the <tfoot>
	 bootstrap: true,
	 position: "top", 
	 formats: ["xlsx"], 
	 fileName: "id", 
	 ignoreRows: null,                  // (Number, Number[]), row indices to exclude from the exported file(s)
    ignoreCols: null,                  // (Number, Number[]), column indices to exclude from the exported file(s)
    ignoreCSS: ".tableexport-ignore",  // (selector, selector[]), selector(s) to exclude from the exported file(s)
    emptyCSS: ".tableexport-empty",    // (selector, selector[]), selector(s) to replace cells with an empty string in the exported file(s)
    trimWhitespace: false              // (Boolean), remove all leading/trailing newlines, spaces, and tabs from cell text in the exported file(s)
	 });
	 
	
/**

	/* Excel Binary spreadsheet (.xls) */
	$.fn.tableExport.xls = {
		defaultClass: "xls",
		buttonContent: "Export to xls",
		separator: "\t",
		mimeType: "application/vnd.ms-excel",
		fileExtension: ".xls"
	};
	/* Excel Open XML spreadsheet (.xlsx) */
	$.fn.tableExport.xlsx = {
		defaultClass: "xlsx",
		buttonContent: "Export to xlsx",
		mimeType: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
		fileExtension: ".xlsx"
	}; 

	 var $buttons =  $("table").find('caption').children().detach();
	// Append the buttons to an element of your choosing
	$buttons.appendTo('#buttonExport');


</script>