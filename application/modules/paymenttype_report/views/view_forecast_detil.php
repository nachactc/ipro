<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-e7aw{font-weight:bold;font-family:Arial, Helvetica, sans-serif !important;;border-color:inherit;text-align:left;vertical-align:top}
.tg .tg-ixc9{font-weight:bold;font-size:12px;font-family:Arial, Helvetica, sans-serif !important;;border-color:inherit;text-align:center}
.tg .tg-kiyi{font-weight:bold;border-color:inherit;text-align:left}
.tg .tg-587j{font-weight:bold;font-family:Arial, Helvetica, sans-serif !important;;border-color:inherit;text-align:left}
.tg .tg-0lax{text-align:left;vertical-align:top}
.tg .tg-l2oz{font-weight:bold;text-align:right;vertical-align:top}
</style>
<link href="<?php echo base_url()."assets/plugins/exportexcel/dist/css/tableexport.css" ?>" rel="stylesheet" type="text/css">

<div align="left" id="buttonExport"></div>

<table class="tg" style="undefined;table-layout: fixed; width: 1009px" id="AR_ForecastDetil_<?php echo date('d_m_Y_s') ?>">
<colgroup>
<col style="width: 38px">
<col style="width: 208px">
<col style="width: 186px">
<col style="width: 141px">
<col style="width: 250px">
<col style="width: 250px">
<col style="width: 170px">
</colgroup>
  <thead>
  <tr>
    <td class="tg-ixc9" colspan="7">A/R Forecast Detil <?php echo "'".getIndoBulan($month).$year."'"; ?></td>
  </tr>
   </thead>
  <tr>
    <td class="tg-587j">No</td>
    <td class="tg-587j">Business Unit</td>
    <td class="tg-587j">Store</td>
    <td class="tg-e7aw">Date</td>
    <td class="tg-587j">Tenant</td>
    <td class="tg-587j">Brand</td>
    <td class="tg-587j"><span style="font-weight:700">Amount</span></td>
  </tr>
   <tr>
    <td class="tg-kiyi" colspan="7"><?php if($data_forecast_detil) {echo $data_forecast_detil[0]->agreementtype_name; } ?></td>
  </tr>
  <?php 
   function rupiah($angka){ 
		$hasil_rupiah = number_format($angka,0);
		//$hasil_rupiah = $angka;
		return $hasil_rupiah; 
	}
  if($data_forecast_detil) :
  $no = 1; 
  $total = 0;
  foreach ($data_forecast_detil as $datas) : 
  
  ?>
 
  <tr>
    <td class="tg-0lax"><?php echo $no++; ?></td>
    <td class="tg-0lax"><?php echo $datas->region_name; ?></td>
    <td class="tg-0lax"><?php echo $datas->branch_name; ?></td>
    <td class="tg-0lax"><?php echo $datas->schedulepaymentdetil_date; ?></td>
    <td class="tg-0lax"><?php echo $datas->rekanan_name; ?></td>
    <td class="tg-0lax"><?php echo $datas->rekananshipping_name; ?></td>
    <td class="tg-0lax" style="text-align: right;"><?php echo rupiah($datas->schedulepaymentdetil_amount); ?></td>
  </tr>
  
  <?php 
    $total = $total + $datas->schedulepaymentdetil_amount;
	endforeach; 
	else: ?>  
	<div class="alert alert-success fade in ">
						  <center>
						  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
						  <strong>Info!</strong> Belum Ada Data!
						   </center>
						</div>  
	<?php endif; ?>
	<tr>
    <td class="tg-l2oz" colspan="6">Total</td>
    <td class="tg-0lax" style="text-align: right;"><?php echo rupiah($total); ?></td>
  </tr>
</table>


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