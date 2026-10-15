<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-7q3x{font-weight:bold;font-family:Arial, Helvetica, sans-serif !important;;text-align:left;vertical-align:top}
.tg .tg-ypuk{font-weight:bold;font-size:12px;font-family:Arial, Helvetica, sans-serif !important;;text-align:center}
.tg .tg-4ikm{font-weight:bold;font-family:Arial, Helvetica, sans-serif !important;;text-align:left}
.tg .tg-s268{text-align:left}
.tg .tg-0lax{text-align:left;vertical-align:top}
</style>

<link href="<?php echo base_url()."assets/plugins/exportexcel/dist/css/tableexport.css" ?>" rel="stylesheet" type="text/css">

<div align="left" id="buttonExport"></div>


<table class="tg" style="undefined;table-layout: fixed; width: 1746px" id="AR_Forecast_<?php echo date('d_m_Y_s') ?>">
<colgroup>
<col style="width: 27px">
<col style="width: 201px">
<col style="width: 180px">
<col style="width: 67px">
<col style="width: 196px">
<col style="width: 120px">
<col style="width: 120px">
<col style="width: 120px">
<col style="width: 120px">
<col style="width: 120px">
<col style="width: 120px">
<col style="width: 120px">
<col style="width: 120px">
<col style="width: 120px">
<col style="width: 120px">
<col style="width: 120px">
<col style="width: 120px">
<col style="width: 120px">
</colgroup>
  <tr>
    <th class="tg-ypuk" colspan="18">A/R Forecast</th>
  </tr>
  <tr>
    <td class="tg-4ikm">No</td>
    <td class="tg-4ikm">Business Unit</td>
    <td class="tg-4ikm">Store</td>
    <td class="tg-4ikm">Year</td>
    <td class="tg-4ikm">Type</td>
    <td class="tg-4ikm">January</td>
    <td class="tg-4ikm">February</td>
    <td class="tg-4ikm">March</td>
    <td class="tg-4ikm">April</td>
    <td class="tg-4ikm">May</td>
    <td class="tg-4ikm">June</td>
    <td class="tg-4ikm">July</td>
    <td class="tg-4ikm">August</td>
    <td class="tg-7q3x">September</td>
    <td class="tg-7q3x">October</td>
    <td class="tg-7q3x">November</td>
    <td class="tg-7q3x">December</td>
    <td class="tg-7q3x">Total</td>
  </tr>
  <?php 
   function rupiah($angka){ 
		$hasil_rupiah = number_format($angka,0);
		//$hasil_rupiah = $angka;
		return $hasil_rupiah; 
	}
  if($data_forecast) :
  $no = 1; 
	$atts = array(
	'width'       => 800,
	'height'      => 650,
	'scrollbars'  => 'yes',
	'status'      => 'no',
	'resizable'   => 'no',
	'screenx'     => 0,
	'screeny'     => 0,
	'window_name' => '_blank'
	);
   
   $total_jan = 0;
   $total_feb = 0;
   $total_mar = 0;
   $total_apr = 0;
   $total_mei = 0;
   $total_jun = 0;
   $total_jul = 0;
   $total_ags = 0;
   $total_sep = 0;
   $total_okt = 0;
   $total_nov = 0;
   $total_des = 0;
   $total_all = 0;
   
  foreach ($data_forecast as $datas) : 
  //echo var_dump($datas);
  //exit;
   $total_jan += $datas->January;
   $total_feb += $datas->February;
   $total_mar += $datas->March;
   $total_apr += $datas->April;
   $total_mei += $datas->May;
   $total_jun += $datas->June;
   $total_jul += $datas->July;
   $total_ags += $datas->August;
   $total_sep += $datas->September;
   $total_okt += $datas->October;
   $total_nov += $datas->November;
   $total_des += $datas->December;
   $total_all += $datas->total;
  ?>
  <tr>
    <td class="tg-s268"><?php echo $no++; ?></td>
    <td class="tg-s268"><?php echo $datas->region_name; ?></td>
    <td class="tg-s268"><?php echo $datas->branch_name; ?></td>
    <td class="tg-s268"><?php echo $datas->year; ?></td>
    <td class="tg-s268"><?php echo $datas->type; ?></td>
    <td class="tg-s268" style="text-align: right;"><?php echo anchor_popup('ar_forecast/report_load_detil/1/'.$datas->agreementtype_id.'/'.$datas->year, rupiah($datas->January),$atts); ?></td>
    <td class="tg-s268" style="text-align: right;"><?php echo anchor_popup('ar_forecast/report_load_detil/2/'.$datas->agreementtype_id.'/'.$datas->year, rupiah($datas->February),$atts); ?></td>
    <td class="tg-s268" style="text-align: right;"><?php echo anchor_popup('ar_forecast/report_load_detil/3/'.$datas->agreementtype_id.'/'.$datas->year, rupiah($datas->March),$atts); ?></td>
    <td class="tg-s268" style="text-align: right;"><?php echo anchor_popup('ar_forecast/report_load_detil/4/'.$datas->agreementtype_id.'/'.$datas->year, rupiah($datas->April),$atts); ?></td>
    <td class="tg-s268" style="text-align: right;"><?php echo  anchor_popup('ar_forecast/report_load_detil/5/'.$datas->agreementtype_id.'/'.$datas->year, rupiah($datas->May),$atts); ?></td>
    <td class="tg-s268" style="text-align: right;"><?php echo anchor_popup('ar_forecast/report_load_detil/6/'.$datas->agreementtype_id.'/'.$datas->year, rupiah($datas->June),$atts); ?></td>
    <td class="tg-s268" style="text-align: right;"><?php echo anchor_popup('ar_forecast/report_load_detil/7/'.$datas->agreementtype_id.'/'.$datas->year, rupiah($datas->July),$atts); ?></td>
    <td class="tg-s268" style="text-align: right;"><?php echo anchor_popup('ar_forecast/report_load_detil/8/'.$datas->agreementtype_id.'/'.$datas->year, rupiah($datas->August),$atts);?></td>
    <td class="tg-0lax" style="text-align: right;"><?php echo anchor_popup('ar_forecast/report_load_detil/9/'.$datas->agreementtype_id.'/'.$datas->year, rupiah($datas->September),$atts); ?></td>
    <td class="tg-0lax" style="text-align: right;"><?php echo anchor_popup('ar_forecast/report_load_detil/10/'.$datas->agreementtype_id.'/'.$datas->year, rupiah($datas->October),$atts);?></td>
    <td class="tg-0lax" style="text-align: right;"><?php echo anchor_popup('ar_forecast/report_load_detil/11/'.$datas->agreementtype_id.'/'.$datas->year, rupiah($datas->November),$atts);?></td>
    <td class="tg-0lax" style="text-align: right;"><?php echo anchor_popup('ar_forecast/report_load_detil/12/'.$datas->agreementtype_id.'/'.$datas->year, rupiah($datas->December),$atts); ?></td>
    <td class="tg-0lax" style="text-align: right;"><?php echo rupiah($datas->total); ?></td>
  </tr> 
	<?php endforeach;?>  
	<tr>
	<td class="tg-s268" colspan="5" style="text-align: right;">Total</td>
	<td class="tg-s268" style="text-align: right;"><?php echo rupiah($total_jan); ?></td>
	<td class="tg-s268" style="text-align: right;"><?php echo rupiah($total_feb); ?></td>
	<td class="tg-s268" style="text-align: right;"><?php echo rupiah($total_mar); ?></td>
	<td class="tg-s268" style="text-align: right;"><?php echo rupiah($total_apr); ?></td>
	<td class="tg-s268" style="text-align: right;"><?php echo rupiah($total_mei); ?></td>
	<td class="tg-s268" style="text-align: right;"><?php echo rupiah($total_jun); ?></td>
	<td class="tg-s268" style="text-align: right;"><?php echo rupiah($total_jul); ?></td>
	<td class="tg-s268" style="text-align: right;"><?php echo rupiah($total_ags); ?></td>
	<td class="tg-s268" style="text-align: right;"><?php echo rupiah($total_sep); ?></td>
	<td class="tg-s268" style="text-align: right;"><?php echo rupiah($total_okt); ?></td>
	<td class="tg-s268" style="text-align: right;"><?php echo rupiah($total_nov); ?></td>
	<td class="tg-s268" style="text-align: right;"><?php echo rupiah($total_des); ?></td>
	<td class="tg-s268" style="text-align: right;"><?php echo rupiah($total_all); ?></td>
	
	</tr>
	<?php else: ?>  
	<div class="alert alert-success fade in ">
						  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
						  <strong>Info!</strong> Belum Ada Data!
						</div>  
	<?php endif; ?>
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