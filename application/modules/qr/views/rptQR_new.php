<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title>Cross-Browser QRCode generator for Javascript</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
<style type="text/css">
@media print {
    #printbtn {
        display :  none;
    }
}
</style>
<script src="<?php echo base_url('assets/scripts/jquery.min.js');?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/scripts/qrcode.js');?>" type="text/javascript"></script>
</head>
<body>
<input id="text" type="hidden" value="<?php echo $qrid; ?>" style="width:80%" /><br />


<table border="0" width="150">   
<tr>
<td width ="50" align="center"><table border="1">   
<tr>
<td  align="center">
   <div id="qrcode" style="width:100; height:100; margin-top:10px; margin-left:10px; margin-right:10px; margin-bottom:10px;"></div>
</td>
</tr> 
<tr>
<td   align="center">
    <?php echo $rekanansipping_name; ?>
</td>
</tr> 
<tr>
<td   align="center">
	<?php echo date('d F Y',strtotime($start_date)); ?>
</td>
</tr> 
<tr>
<td   align="center">
	<?php echo date('d F Y',strtotime($end_date)); ?>
</td>
</tr> 
</table>
</td>
</tr>
</table> 

<br />

<table border="0" width="150">   
<tr>
<td width ="50" align="center">
<input type="button" id ="printbtn" value = "PRINT" onclick="window.print();" class="btn btn-sm btn-info"/>
</td>
</tr>
</table> 

<script type="text/javascript">
var qrcode = new QRCode(document.getElementById("qrcode"), {
	width : 100,
	height : 100
});

function makeCode () {		
	var elText = document.getElementById("text");
	
	if (!elText.value) {
		alert("Input a text");
		elText.focus();
		return;
	}
	
	qrcode.makeCode(elText.value);
}

makeCode();

$("#text").
	on("blur", function () {
		makeCode();
	}).
	on("keydown", function (e) {
		if (e.keyCode == 13) {
			makeCode();
		}
	});
</script>
<script>
  $('#btnprint').click(function() {
	$('#btnprint').prop('display',hidden);
  });
</script>
</body>