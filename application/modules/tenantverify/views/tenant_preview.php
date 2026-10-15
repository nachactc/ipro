<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-z4i2{border-color:#ffffff;text-align:left;vertical-align:middle;text-align:justify;}
.tg .tg-9ibx{font-weight:bold;background-color:#c0c0c0;border-color:#ffffff;text-align:center;vertical-align:middle}
.tg .tg-10ibx{font-weight:bold;background-color:#7977f7;border-color:#ffffff;text-align:center;vertical-align:middle}
.tg .tg-km2t{font-weight:bold;border-color:#ffffff;text-align:left;vertical-align:top}
.tg .tg-w1ir{font-weight:bold;background-color:#c0c0c0;border-color:#ffffff;text-align:center;vertical-align:top}
.tg .tg-zv4m{border-color:#ffffff;text-align:left;vertical-align:top;text-align:justify;}
.tg .tg-2eyt{font-weight:bold;border-color:#ffffff;text-align:left;vertical-align:middle}
.blinking{
    animation:blinkingText 0.5s infinite;
}
@keyframes blinkingText{
    0%{     color: #000;    }
    49%{    color: transparent; }
    50%{    color: transparent; }
    99%{    color:transparent;  }
    100%{   color: #000;    }
}
</style>

</head>

<body> 
<?php 
function kosong_con($value)
{ 
	if(empty($value) )
	{
		return '<span class="blinking"><strong> KOSONG <strong></span>';		
	}
	if(!empty($value))
	{
		return $value;
	}
}
if(!empty($rResult)) : 
?>
<table class="tg" style="undefined;table-layout: fixed; width: 1251px">
<colgroup>
<col style="width: 155px">
<col style="width: 300px">
<col style="width: 141px">
<col style="width: 290px">
<col style="width: 88px">
<col style="width: 284px">
</colgroup>
  <tr>
    <th class="tg-w1ir" colspan="6">TENANT </th>
  </tr>
  <tr>
    <td class="tg-2eyt">ID</td>
    <td class="tg-z4i2"><?php echo $rResult->rekanan_id; ?></td>
    <td class="tg-2eyt">NPWP</td>
    <td class="tg-z4i2"><?php echo kosong_con($rResult->taxsign_id); ?></td>
    <td class="tg-2eyt">TYPE</td>
    <td class="tg-z4i2"><?php echo kosong_con($rResult->grouptenant_name); ?></td>
  </tr>
  <tr>
    <td class="tg-2eyt">TENANT</td>
    <td class="tg-z4i2"><?php echo $rResult->rekanan_name; ?></td>
    <td class="tg-2eyt">PKP NAME</td>
    <td class="tg-z4i2"><?php echo kosong_con($rResult->rekanan_pkpname); ?></td>
    <td class="tg-2eyt">NIK</td>
    <td class="tg-z4i2"><?php echo kosong_con($rResult->rekanan_taxnik); ?></td>
  </tr>
  <tr>
    <td class="tg-km2t">ADDRESS</td>
    <td class="tg-zv4m"><?php echo kosong_con($rResult->rekanan_address); ?></td>
    <td class="tg-km2t">NPWP ADDRESS</td>
    <td class="tg-zv4m"><?php echo kosong_con($rResult->rekanan_taxaddress); ?></td>
    <td class="tg-km2t">DEDUCT</td>
    <td class="tg-zv4m"><?php echo kosong_con( ($rResult->deduct == 0) ? $rResult->deduct.' - Land Lord' : $rResult->deduct.' - Tenant'  ); ?></td>
  </tr>
  <tr>
    <td class="tg-9ibx" colspan="6">BRAND</td>
  </tr>
  <tr>
    <td class="tg-2eyt">ID BRAND</td>
    <td class="tg-z4i2"><?php echo $rResult->rekananshipping_line; ?></td>
    <td class="tg-2eyt">NPWP</td>
    <td class="tg-z4i2"><?php echo kosong_con($rResult->rekananshipping_npwp); ?></td>
    <td class="tg-2eyt">TYPE</td>
    <td class="tg-z4i2"><?php echo kosong_con($rResult->rekananshippingtype_name); ?></td>
  </tr>
  <tr>
    <td class="tg-2eyt">BRAND</td>
    <td class="tg-z4i2"><?php echo $rResult->rekananshipping_name; ?></td>
    <td class="tg-2eyt">PKP NAME</td>
    <td class="tg-z4i2"><?php echo kosong_con($rResult->rekananshipping_npwp_name); ?></td>
    <td class="tg-2eyt">STORE</td>
    <td class="tg-z4i2"><?php echo kosong_con($rResult->branch_name); ?></td>
  </tr>
  <tr>
    <td class="tg-2eyt">DEBTOR</td>
    <td class="tg-z4i2"><?php echo kosong_con($rResult->debtor); ?></td>
    <td class="tg-2eyt">NPWP ADDRESS</td>
    <td class="tg-z4i2"><?php echo kosong_con($rResult->rekananshipping_npwp_addr); ?></td>
    <td class="tg-z4i2"></td>
    <td class="tg-z4i2"></td>
  </tr>
  <tr>
    <td class="tg-2eyt">CONTACT NAME</td>
    <td class="tg-z4i2"><?php echo kosong_con($rResult->rekananshipping_contactname); ?></td>
    <td class="tg-2eyt">CONTACT HP</td>
    <td class="tg-z4i2"><?php echo kosong_con($rResult->rekananshipping_contacthp); ?></td>
    <td class="tg-z4i2"></td>
    <td class="tg-z4i2"></td>
  </tr>
  <tr>
    <td class="tg-km2t">CONTACT EMAIL</td>
    <td class="tg-zv4m"><?php echo kosong_con($rResult->rekananshipping_contactemail); ?></td>
    <td class="tg-zv4m"></td>
    <td class="tg-zv4m"></td>
    <td class="tg-zv4m"></td>
    <td class="tg-zv4m"></td>
  </tr>
  <tr>
    <td class="tg-10ibx" colspan="6">BELUM DI VERIFIKASI</td>
  </tr>
</table>
<?php endif; ?>
<form id="myForm" method="POST" action="<?php echo site_url("tenantverify/verify_data/$rResult->rekanan_id/$rResult->rekananshipping_line"); ?>" >
	<table border="0" width="93%">
	<tr>
		<td> &nbsp; </td>
		<td> &nbsp; </td>
		<td align="right"><input type="submit" value="Verify" class="btn btn-sm btn-info" /></td>
	</tr>
	</table>
	
    
</form>

</body>
</html>