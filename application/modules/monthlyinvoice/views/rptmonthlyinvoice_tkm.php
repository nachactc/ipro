<title>Monthly Invoice List</title>
 
<style type="text/css">

.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-0rzf{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-ldj7{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:#000000;text-align:center;vertical-align:top}
.tg .tg-iuhm{font-size:10px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top;}
.tg .tg-73lx{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:#000000;vertical-align:top}
.tg .tg-ur0i{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;text-align:center;vertical-align:top}
.tg .tg-vbnk{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;vertical-align:top}
.tg .tg-li00{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;background-color:#ffffff;border-color:#000000;text-align:center;vertical-align:top}
.head1{font-size:14px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
.head2{font-size:12px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
</style>


</head>
<br />

<body>
    
<button class="exportToExcel">Export to EXCEL</button>

<p>Monthly Invoice List</p>
<table width="942" border="0">
  <tr>
    <td width="155">Periode</td>
    <td width="381">:  <?php echo date('d-M-Y',strtotime($start_date)); ?>  s/d <?php echo date('d-M-Y',strtotime($end_date)); ?></td>
    <td width="130">Business Unit</td>
    <td width="258">:  <?php echo $region_name; ?></td>
  </tr>
  <tr>
    <td>Store</td>
    <td>:  <?php echo $branch_name; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>      
</table>


 </br>

<table class="tg" width="2120px" border="0">
  <tr>
    <td width="10px" class="tg-li00">Store Code</td>
    <td width="100px" class="tg-li00">NPWP</td>        
    <td width="10px" class="tg-li00">Debtor Acct</td>
    <td width="100px" class="tg-li00">Debtor Name</td>
    <td width="100px" class="tg-li00">Brand</td>
    <td width="100px" class="tg-li00">Invoice ID</td>
    <td width="15px" class="tg-li00">TRX</td>
    <td width="100px" class="tg-li00">Tax Invoice No</td>       
    <td width="65px" class="tg-li00">Invoice Date</td>
    <td width="65px" class="tg-li00">Due Date</td>
    <td width="100px" class="tg-li00">Description</td>                                         
    <td width="75px" align="right" class="tg-li00">Base Amount</td>
    <td width="75px" align="right" class="tg-li00">Disc</td>
    <td width="75px" align="right" class="tg-li00">Base Amount After Disc</td>
    <td width="75px" align="right" class="tg-li00">VAT Amount</td>
    <td width="75px" align="right" class="tg-li00">Total Amount</td>  
    <td width="30px" class="tg-li00">Deptor Type</td>
    <td width="30px" class="tg-li00">Shipping Type</td>        
    <td width="30px" class="tg-li00">Ref ID</td>
    <td width="30px" class="tg-li00">Jurnal ID</td>
    <td width="30px" class="tg-li00">Receipt</td>
    <td width="30px" class="tg-li00">OR ID</td>
    <td width="30px" class="tg-li00">Recklas</td>
    <td width="55px" class="tg-li00">Last OR</td>
  </tr>
<?php

$Base_Amount = 0;
$VAT = 0;
$VAT_Amount = 0;
$Total_Amount = 0;
$total_Base_Amount = 0;
$total_VAT_Amount = 0;
$total_Total_Amount = 0;  
$schedulepaymentdiscount_idr = 0;
$Base_Amount_after_disc = 0;
$total_schedulepaymentdiscount_idr = 0;
$total_Base_Amount_after_disc = 0;

if(isset($result)){

  foreach($result as $row){
    $Base_Amount = $row->Base_Amount;
    $schedulepaymentdiscount_idr = $row->schedulepaymentdiscount_idr;
    $Base_Amount_after_disc =$Base_Amount - $schedulepaymentdiscount_idr;
    $VAT = $row->VAT_Amount;
    $VAT_Amount = ($Base_Amount_after_disc * $VAT) / 100;
    $Total_Amount = $Base_Amount_after_disc + $VAT_Amount;

    
    $PPH_Amount = ($Base_Amount_after_disc * 10) / 100;
    $reduce = ($VAT_Amount - $PPH_Amount);

    $totalOR = abs($row->total_or);
    $totalRC = abs($row->total_rc);


    $total_Base_Amount += $Base_Amount;
    $total_VAT_Amount += $VAT_Amount;
    $total_Total_Amount += $Total_Amount;
    $total_schedulepaymentdiscount_idr += $schedulepaymentdiscount_idr;
    $total_Base_Amount_after_disc += $Base_Amount_after_disc;
?>  
  <tr>
      <td class="tg-iuhm"><?php echo $row->Store_Code; ?></td>
      <td class="tg-iuhm"><?php echo $row->NPWP; ?></td>
      <td class="tg-iuhm"><?php echo $row->Debtor_Acct; ?></td>
      <td class="tg-iuhm"><?php echo $row->Debtor_Name; ?></td>
      <td class="tg-iuhm"><?php echo $row->rekananshipping_name; ?></td>
      <td class="tg-iuhm"><?php echo $row->Invoice_No; ?></td>                                        
      <td class="tg-iuhm"><?php echo $row->trx; ?></td>        
      <td class="tg-iuhm"><?php echo $row->Tax_Invoice_no; ?></td>
      <td class="tg-iuhm"><?php echo date('d-M-Y',strtotime($row->mDate)); ?></td>
      <td class="tg-iuhm"><?php echo date('d-M-Y',strtotime($row->mDueDate)); ?></td>
      <td class="tg-iuhm"><?php echo $row->description; ?></td>                        
      <td style="text-align: right" class="tg-iuhm"><?php echo number_format($Base_Amount, 0); ?></td>
      <td style="text-align: right" class="tg-iuhm"><?php echo number_format($schedulepaymentdiscount_idr, 0); ?></td>
      <td style="text-align: right" class="tg-iuhm"><?php echo number_format($Base_Amount_after_disc, 0); ?></td>
      <td style="text-align: right" class="tg-iuhm"><?php echo number_format($VAT_Amount, 0); ?></td>
      <td style="text-align: right" class="tg-iuhm"><?php echo number_format($Total_Amount, 0); ?></td> 
      <td class="tg-iuhm"><?php echo $row->Debtor_type; ?></td>
      <td class="tg-iuhm"><?php echo $row->rekananshipping_type; ?></td>        
      <td class="tg-iuhm"><?php echo $row->ref_id; ?></td>
      <td class="tg-iuhm"><?php echo $row->jurnal_id; ?></td>
      <td style="text-align: right" class="tg-iuhm"><?=number_format($totalOR, 0)?></td>
      <td class="tg-iuhm"><?php echo $row->or_id; ?></td>
      <td style="text-align: right" class="tg-iuhm"><?=number_format($totalRC, 0)?></td>
      <td class="tg-iuhm"><?php echo date('Y-m-d',strtotime($row->last_or_date)); ?></td>  
  </tr>  
<?php }}?>
  <tr>
      <td class="tg-iuhm"></td>
      <td class="tg-iuhm"></td>
      <td class="tg-iuhm"></td>
      <td class="tg-iuhm"></td>
      <td class="tg-iuhm"></td>
      <td class="tg-iuhm"></td>                                        
      <td class="tg-iuhm"></td>        
      <td class="tg-iuhm"></td>
      <td class="tg-iuhm"></td>
      <td class="tg-iuhm"></td>
      <td class="tg-iuhm"></td> 
      <td style="text-align: right" class="tg-iuhm"><?=number_format($total_Base_Amount,0);?></td>
      <td style="text-align: right" class="tg-iuhm"><?=number_format($total_schedulepaymentdiscount_idr,0); ?></td>
      <td style="text-align: right" class="tg-iuhm"><?=number_format($total_Base_Amount_after_disc,0); ?></td>
      <td style="text-align: right" class="tg-iuhm"><?=number_format($total_VAT_Amount,0); ?></td>
      <td style="text-align: right" class="tg-iuhm"><?=number_format($total_Total_Amount,0); ?></td>  
      <td class="tg-iuhm"></td>
      <td class="tg-iuhm"></td>        
      <td class="tg-iuhm"></td>
      <td class="tg-iuhm"></td>  
      <td class="tg-iuhm"></td>
      <td class="tg-iuhm"></td>
      <td class="tg-iuhm"></td>
      <td class="tg-iuhm"></td>
  </tr>   
</table>
  <br />
  <br />
  <br />

</body>

</html>

<script src="<?=base_url('assets/plugins/jquery.min.js');?>" type="text/javascript"></script> 
<script src="<?=base_url('assets/plugins/jquery.blockui.min.js');?>" type="text/javascript"></script>
<script src="<?=base_url('/assets/plugins/exportexcel/exceljs.min.js');?>" type="text/javascript"></script>
<script src="<?=base_url('/assets/plugins/exportexcel/FileSaver.min.js');?>" type="text/javascript"></script>
<script> 
    $(document).ready(function(){ 
        
        $('.exportToExcel').on('click', function() {
          
            //exportToExcel(response);
            $.blockUI();
            setTimeout(function() {
                //console.log("Data ini dieksekusi setelah 3 detik");
                var res = <?php echo json_encode($result); ?>;
                exportToExcel(res);
                $.unblockUI();
            }, 1000);

            /*
			$.ajax({
				type: 'POST',
				url: "",
				dataType: 'json',
				//data: formData,
				beforeSend : function () {
                    blockIt({
                        target: t,
                        boxed: true,
                        message: 'Processing...'
                    });
				},
				success: function(response) {
					exportToExcel(response);
					unblockIt(t);
				},
				error: function() {
					$.unblockUI();
					$('#response').html('An error occurred. Please try again.');
				}
			});
            */
			
        })
    })

    function isEmpty(str) {
    	return (!str || str.length === 0);
    }

    const colorHeader = 'FF808080';
	const colorGrey1 = 'FFA9A9A9';
	const colorGrey2 = 'FFD3D3D3';
	const colorGrey3 = 'FFDEDEDE';
	const fontName = 'Arial';
	const formatNumber = '#,##0.00';
	const borderStyle = {top: {style: 'thin'}, left: {style: 'thin'}, bottom: {style: 'thin'}, right: {style: 'thin'}};

	function styleFont(cell, values, isNumber, fontSize, boldState, alignments = 'Left', borders = false, borderStyle = 'thin') 
	{
		cell.value = values;
		if (isNumber) {
			cell.numFmt = formatNumber;
			cell.alignment = {vertical: 'middle', horizontal: 'right'};
		}
		if (alignments !== 'Left') {
			cell.alignment = {vertical: 'middle', horizontal: alignments};
		}
		cell.font = {name: fontName, size: fontSize, bold: boldState};
		if (borders) {
			cell.border = {top: {style: borderStyle}, left: {style: borderStyle}, bottom: {style: borderStyle}, right: {style: borderStyle}};
		}
    }

	function styleFontColor(cell, values, fgColors, isNumber, fontSize, boldState, alignments = 'Left', borders = false, borderStyle = 'thin') 
	{
		cell.value = values;
		if (isNumber) {
			cell.numFmt = formatNumber;
			cell.alignment = {vertical: 'middle', horizontal: 'right'};
		}
		if (alignments !== 'Left') {
			cell.alignment = {vertical: 'middle', horizontal: alignments};
		}
		cell.font = {name: fontName, size: fontSize, bold: boldState};
		cell.fill = {type: 'pattern', pattern: 'solid', fgColor: {argb: fgColors}};
		if (borders) {
			cell.border = {top: {style: borderStyle}, left: {style: borderStyle}, bottom: {style: borderStyle}, right: {style: borderStyle}};
		}
    }

	function exportToExcel(data) 
	{
		let startDate = <?php echo json_encode(date('d-M-Y',strtotime($start_date)));?>;
		let endDate = <?php echo json_encode(date('d-M-Y',strtotime($end_date)));?>;
        let regionName = <?php echo json_encode($region_name);?>;
        let branchName = <?php echo json_encode($branch_name);?>;

		var title = 'Monthly Invoice List';

		const workbook = new ExcelJS.Workbook();
		workbook.creator = 'Ipro';
		workbook.lastModifiedBy = 'Ipro';
		workbook.created = new Date();
		workbook.modified = new Date();
		const worksheet = workbook.addWorksheet('Sheet1', {
			pageSetup: {paperSize: 9, orientation: 'landscape'}
		});
		worksheet.columns = [
			{key: 'Store_Code', width: 8},
			{key: 'NPWP', width: 15},
			{key: 'Debtor_Acct', width: 10},
			{key: 'Debtor_Name', width: 30},
			{key: 'rekananshipping_name', width: 20},
			{key: 'Invoice_No', width: 15},
			{key: 'trx', width: 15},
			{key: 'Tax_Invoice_no', width: 20},
			{key: 'mDate', width: 10},
			{key: 'mDueDate', width: 10},
			{key: 'description', width: 20},
			{key: 'Base_Amount', width: 15},
			{key: 'schedulepaymentdiscount_idr', width: 15},
			{key: 'Base_Amount', width: 15},
			{key: 'VAT_Amount', width: 15},
			{key: 'Total_Amount', width: 15},
			{key: 'Debtor_type', width: 10},
			{key: 'rekananshipping_type', width: 10},
			{key: 'ref_id', width: 15},
			{key: 'jurnal_id', width: 15},
			{key: 'total_or', width: 15},
			{key: 'or_id', width: 15},
			{key: 'total_rc', width: 15},
			{key: 'last_or_date', width: 10},
		];

        worksheet.mergeCells('A1:E1');
		cellTitle = worksheet.getCell('A1');
		styleFont(cellTitle, title, false, 13, true);

        worksheet.mergeCells('A3:D3');
		cellTitle = worksheet.getCell('A3');
		styleFont(cellTitle, `Periode : ${startDate} s/d ${endDate}`, false, 10, true);

		if (regionName === '')  { regionName = 'All' };
		if (branchName === '')  { branchName = 'All' };

        worksheet.mergeCells('E3:G3');
		cellTitle = worksheet.getCell('E3');
		styleFont(cellTitle, `Business Unit : ${regionName}`, false, 10, true);
        worksheet.mergeCells('A4:E4');
		cellTitle = worksheet.getCell('A4');
		styleFont(cellTitle, `Store : ${branchName}`, false, 10, true);

		//worksheet.mergeCells('A4:E4');
		//cellHeader = worksheet.getCell('A4');
		//styleFontColor(cellHeader, 'Store Code', colorHeader, false, 10, true);
		styleFontColor(worksheet.getCell('A5'), 'Store Code', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('B5'), 'NPWP', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('C5'), 'Debtor Acct', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('D5'), 'Debtor Name', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('E5'), 'Brand', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('F5'), 'Invoice ID', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('G5'), 'TRX', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('H5'), 'Tax Invoice No', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('I5'), 'Invoice Date', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('J5'), 'Due Date', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('K5'), 'Description', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('L5'), 'Base Amount', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('M5'), 'Disc', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('N5'), 'Base Amount After Disc', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('O5'), 'VAT Amount', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('P5'), 'Total Amount', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('Q5'), 'Deptor Type', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('R5'), 'Shipping Type', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('S5'), 'Ref ID', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('T5'), 'Jurnal ID', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('U5'), 'Receipt', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('V5'), 'OR ID', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('W5'), 'Recklas', colorHeader, false, 10, true, 'center');
		styleFontColor(worksheet.getCell('X5'), 'Last OR', colorHeader, false, 10, true, 'center');

		let rownum = 5;
		let account_current = "";

		$.each(data, function (index, row) {
			//let duedate = isEmpty(row.duedate) ? '' : new Date(row.duedate.substring(0, 10));
			//let invoice_duedate = isEmpty(row.invoice_duedate) ? '' : new Date(row.invoice_duedate.substring(0, 10));
            let invoiceDate = isEmpty(row.mDate) ? '' : new Date(row.mDate.substring(0, 10));
            let dueDate = isEmpty(row.mDueDate) ? '' : new Date(row.mDueDate.substring(0, 10));

            let baseAmount = Number(row.Base_Amount);
            let disc = Number(row.schedulepaymentdiscount_idr);
            let nettAmount = baseAmount - disc;
            let vat = Number(row.VAT_Amount);
            let vatAmount = (nettAmount * vat) / 100;
            let totalAmount = nettAmount + vatAmount;

			rownum += 1;
			styleFont(worksheet.getCell('A' + (rownum).toString()), row.Store_Code, false, 9, false);
			styleFont(worksheet.getCell('B' + (rownum).toString()), row.NPWP, false, 9, false);
			styleFont(worksheet.getCell('C' + (rownum).toString()), row.Debtor_Acct, false, 9, false);
			styleFont(worksheet.getCell('D' + (rownum).toString()), row.Debtor_Name, false, 9, false);
			styleFont(worksheet.getCell('E' + (rownum).toString()), row.rekananshipping_name, false, 9, false);
			styleFont(worksheet.getCell('F' + (rownum).toString()), row.Invoice_No, false, 9, false);
			styleFont(worksheet.getCell('G' + (rownum).toString()), row.trx, false, 9, false);
			styleFont(worksheet.getCell('H' + (rownum).toString()), row.Tax_Invoice_no, false, 9, false);
			styleFont(worksheet.getCell('I' + (rownum).toString()), invoiceDate, false, 9, false);
			styleFont(worksheet.getCell('J' + (rownum).toString()), dueDate, false, 9, false);
			styleFont(worksheet.getCell('K' + (rownum).toString()), row.description, false, 9, false);
			styleFont(worksheet.getCell('L' + (rownum).toString()), baseAmount, true, 9, false);
			styleFont(worksheet.getCell('M' + (rownum).toString()), disc, true, 9, false);
			styleFont(worksheet.getCell('N' + (rownum).toString()), nettAmount, true, 9, false);
			styleFont(worksheet.getCell('O' + (rownum).toString()), vatAmount, true, 9, false);
			styleFont(worksheet.getCell('P' + (rownum).toString()), totalAmount, true, 9, false);
			styleFont(worksheet.getCell('Q' + (rownum).toString()), row.Debtor_type, true, 9, false);
			styleFont(worksheet.getCell('R' + (rownum).toString()), row.rekananshipping_type, true, 9, false);
			styleFont(worksheet.getCell('S' + (rownum).toString()), row.ref_id, false, 9, false);
			styleFont(worksheet.getCell('T' + (rownum).toString()), row.jurnal_id, false, 9, false);
			styleFont(worksheet.getCell('U' + (rownum).toString()), Math.abs(Number(row.total_or)), true, 9, false);
			styleFont(worksheet.getCell('V' + (rownum).toString()), row.or_id, false, 9, false);
			styleFont(worksheet.getCell('W' + (rownum).toString()), Math.abs(Number(row.total_rc)), true, 9, false);
			styleFont(worksheet.getCell('X' + (rownum).toString()), row.last_or_date, false, 9, false);
		});

		workbook.xlsx.writeBuffer().then((data) => {
			const blob = new Blob([data], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'});
			saveAs(blob, `${title}.xlsx`);
		});
	}

</script> 