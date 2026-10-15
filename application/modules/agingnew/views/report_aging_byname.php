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
<div align="left" id="buttonExport" style="width:10%;"></div>
 <title> Report <?php echo $title; ?> </title>
<?php  if($result != 'kosong'){ ?>

<table class="tg" id="tblAgingByName" style="undefined;table-layout: fixed; width: 1421px">
<colgroup>
<col style="width: 133px">
<col style="width: 195px">
<col style="width: 116px">
<col style="width: 100px">
<col style="width: 98px">
<col style="width: 94px">
<col style="width: 102px">
<col style="width: 113px">
<col style="width: 88px">
<col style="width: 96px">
<col style="width: 152px">
<col style="width: 134px">
<col style="width: 134px">
<col style="width: 134px">
<col style="width: 134px">
</colgroup>
  <tr>
    <th class="tg-9248" colspan="12"> <?php echo strtoupper($result[0]->region_name); ?></th>
  </tr>
  <tr>
    <td class="tg-9248" colspan="12">DEBTOR <?php echo strtoupper($title); ?> REPORT TANGGAL <?php echo strtoupper(getIndoHari(date('Y-m-d',strtotime($enddate)))); ?> </td>
  </tr>
  <tr>
    <td class="tg-oe15" colspan="12">Total Data : <?php echo number_format(count($result),0,',','.'); ?> Row(s)</td>
  </tr>
  <tr>
    <td class="tg-hkrl">Debtor A/C</td>
    <td class="tg-hkrl">Name</td>
    <td class="tg-hkrl">&lt;= 14 Days</td>
    <td class="tg-hkrl">15-30 Days</td>
    <td class="tg-hkrl">31-60 Days</td>
    <td class="tg-hkrl">61-90 Days</td>
    <td class="tg-hkrl">91-120 Days</td>
    <td class="tg-hkrl">121-150 Days</td>
    <td class="tg-hkrl">&gt;150 Days</td>
    <td class="tg-hkrl">Total Outstanding</td>
    <td class="tg-hkrl">Unallocated Amount<br>Dr/Cr</td>
    <td class="tg-hkrl">Deposite To Date</td>
    <td class="tg-hkrl">Type Tenant</td>
    <td class="tg-hkrl">Status</td>
    <td class="tg-hkrl">Corporate</td>
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
	//variabel subtotal 2
	$amount0_subtotal2 = 0;
	$amount30_subtotal2 = 0;
	$amount60_subtotal2 = 0;
	$amount90_subtotal2 = 0;
	$amount120_subtotal2 = 0;
	$amount150_subtotal2 = 0;
	$amount151_subtotal2 = 0;
	$amountAllocation_subtotal2 = 0;
	$amountDeposit_subtotal2 = 0;  
	$tot_outstanding_subtotal2 = 0;
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
	$tot_outstanding = 0;
	switch(true)
	{
		
		 case ($val->due < 0 && $val->jurnal_type = '0101'  ): 
			$amountAllocation = abs($amountVal);  
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
		 case ($val->due >= 151):
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
	
	$amount0_subtotal2 += $amount0;
	$amount30_subtotal2 += $amount30;
	$amount60_subtotal2+= $amount60;
	$amount90_subtotal2 += $amount90;
	$amount120_subtotal2 += $amount120;
	$amount150_subtotal2 += $amount150;
	$amount151_subtotal2 += $amount151;
	$amountAllocation_subtotal2 += $amountAllocation;
	$amountDeposit_subtotal2 += $amountDeposit;  
	$tot_outstanding_subtotal2 += $tot_outstanding;
	
 
  ?>   
  
   <?php 
	if(@$result[$row+1]->rekanan_id != $val->rekanan_id )  //if contract_no
	{
		$amount0_total += $amount0_subtotal2;
		$amount30_total += $amount30_subtotal2;
		$amount60_total += $amount60_subtotal2;
		$amount90_total += $amount90_subtotal2;
		$amount120_total += $amount120_subtotal2;
		$amount150_total += $amount150_subtotal2;
		$amount151_total +=$amount151_subtotal2;
		$amountAllocation_total += $amountAllocation_subtotal2;
		$amountDeposit_total += $amountDeposit_subtotal2;  
		$tot_outstanding_total += $tot_outstanding_subtotal2;
  ?>
 
 <tr>
    <td class="tg-cy0b"><?php echo $val->contract_no.' - '.$val->branch_code.' - '.$val->branch_name;?></td>
    <td class="tg-cy0b"><?php echo $val->rekanan_name.' - '.$val->rekananshipping_name ; ?></td> 
    <td class="tg-cy0b" style="text-align: right;"><?php echo rupiah($amount0_subtotal2); ?></td>
    <td class="tg-cy0b" style="text-align: right;"><?php echo rupiah($amount30_subtotal2); ?></td>
    <td class="tg-cy0b" style="text-align: right;"><?php echo rupiah($amount60_subtotal2); ?></td>
    <td class="tg-cy0b" style="text-align: right;"><?php echo rupiah($amount90_subtotal2); ?></td>
    <td class="tg-cy0b" style="text-align: right;"><?php echo rupiah($amount120_subtotal2); ?></td>
    <td class="tg-cy0b" style="text-align: right;"><?php echo rupiah($amount150_subtotal2); ?></td>
    <td class="tg-cy0b" style="text-align: right;"><?php echo rupiah($amount151_subtotal2); ?></td>
    <td class="tg-cy0b" style="text-align: right;"><?php echo rupiah($tot_outstanding_subtotal2); ?></td>
    <td class="tg-cy0b" style="text-align: right;"><?php echo rupiah($amountAllocation_subtotal2); ?></td>
    <td class="tg-cy0b" style="text-align: right;"><?php echo rupiah($amountDeposit_subtotal2); ?></td>
	<td class="tg-cy0b" nowrap><?php echo $val->tenant_type; ?></td>
	<td class="tg-cy0b" nowrap><?php echo $val->p_status; ?></td>
	<td class="tg-cy0b" nowrap><?php echo $val->c_status; ?></td>
  </tr> 
  
   <?php  
	 
	
	//variabel subtotal 2 reset
	$amount0_subtotal2 = 0;
	$amount30_subtotal2 = 0;
	$amount60_subtotal2 = 0;
	$amount90_subtotal2 = 0;
	$amount120_subtotal2 = 0;
	$amount150_subtotal2 = 0;
	$amount151_subtotal2 = 0;
	$amountAllocation_subtotal2 = 0;
	$amountDeposit_subtotal2 = 0;  
	$tot_outstanding_subtotal2 = 0;
	//variabel total reset
	 
	} //end if contract_no  
	$Branch = $val->branch_id;
	$DeductTyp = $val->deduct_type; 
	$rekanan = $val->rekanan_id; 
	} //end foreach 1 result 
	
  ?> 
  
  
  <tr>
    <td class="tg-aa48" colspan="2" style="background-color:#BDC3C7;border-color:#BDC3C7;">Grand Total</td>
    <td class="tg-8ur7" style="text-align: right;background-color:#BDC3C7;border-color:#BDC3C7;"><?php echo rupiah($amount0_total);?></td>
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
<script src="<?php echo base_url()."assets/plugins/exportexcel/" ?>shim.min.js"></script> 
<script src="<?php echo base_url()."assets/plugins/exportexcel/" ?>Blob.js"></script> 
<script src="<?php echo base_url()."assets/plugins/exportexcel/" ?>xlsx.full.min.js"></script>  
<script src="<?php echo base_url()."assets/plugins/exportexcel/" ?>FileSaver.js"></script>

<script src="<?php echo base_url()."assets/plugins/exportexcel/dist/js/tableexport.js" ?>"></script>
 <script>
 /* Defaults */
TableExport(document.getElementsByTagName("table"), {
  headers: true,                      // (Boolean), display table headers (th or td elements) in the <thead>, (default: true)
  footers: true,                      // (Boolean), display table footers (th or td elements) in the <tfoot>, (default: false)
  formats: ["xlsx"],    // (String[]), filetype(s) for the export, (default: ['xlsx', 'csv', 'txt'])
  filename: "id",                     // (id, String), filename for the downloaded file, (default: 'id')
  bootstrap: false,                   // (Boolean), style buttons using bootstrap, (default: true)
  exportButtons: true,                // (Boolean), automatically generate the built-in export buttons for each of the specified formats (default: true)
  position: "bottom",                 // (top, bottom), position of the caption element relative to table, (default: 'bottom')
  ignoreRows: null,                   // (Number, Number[]), row indices to exclude from the exported file(s) (default: null)
  ignoreCols: null,                   // (Number, Number[]), column indices to exclude from the exported file(s) (default: null)
  trimWhitespace: true,               // (Boolean), remove all leading/trailing newlines, spaces, and tabs from cell text in the exported file(s) (default: false)
  RTL: false,                         // (Boolean), set direction of the worksheet to right-to-left (default: false)
  sheetname: "id"                     // (id, String), sheet name for the exported spreadsheet, (default: 'id')
});
 

	 var $buttons =  $("table").find('caption').children().detach();
	// Append the buttons to an element of your choosing
	$buttons.appendTo('#buttonExport');


</script> 