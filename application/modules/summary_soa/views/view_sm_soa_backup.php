 
<link href="<?php echo base_url()."assets/plugins/exportexcel/dist/css/tableexport.css" ?>" rel="stylesheet" type="text/css">

<div align="left" id="buttonExport"></div>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-e7aw{font-weight:bold;font-family:Arial, Helvetica, sans-serif !important;;border-color:inherit;text-align:left;vertical-align:top}
.tg .tg-ixc9{font-weight:bold;font-size:12px;font-family:Arial, Helvetica, sans-serif !important;;border-color:inherit;text-align:center}
.tg .tg-kiyi{font-weight:bold;border-color:inherit;text-align:left}
.tg .tg-587j{font-weight:bold;font-family:Arial, Helvetica, sans-serif !important;;border-color:inherit;text-align:left}
.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
.tg .tg-6ic8{font-weight:bold;border-color:inherit;text-align:right;vertical-align:top}
.red {
  background: red;
}
</style>
<?php  
echo $data_sm_soa['result'];
?>
 
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

	// function isNumber(n) {
	  // return !isNaN(parseFloat(n)) && isFinite(n);
	// }
	// jQuery.each($('td'), function () {
		// if (!isNaN(this.textContent)) {
			// $(this).parent().addClass("red");
		// }
	// });
	
	$(document).ready(function(){
		$('table td').each(function(){
			if(!isNaN($(this).find('td').text())){
				$(this).parents('td').css('background','red');
			}

		 
		});
	});

</script>