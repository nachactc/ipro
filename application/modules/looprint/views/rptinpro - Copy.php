<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Language" content="id">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Proforma Invoice</title>
<style>
      body {
      background:rgb(204,204,204);
      }

      page[size="A4"] {
      background:white;
      width:21cm;
      height:29.7cm;
      display:block;
      margin:0 auto;
      margin-bottom:0.1cm;
      box-shadow:0 0 0.5cm rgba(0,0,0,0.5);
      }

      @media print {
      body,page[size="A4"] {
      margin:0;
      box-shadow:0;
      }
      }

      td {
      font-family:Arial,Helvetica,sans-serif;
      font-size:12px;
      }
      
      td1 {
      
      border-right:2px solid #fff;      
      }
      
      
</style>

</head>

<body>

<page size="A4">

<?php
if(isset($result)){
foreach($result as $row){
?>  
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
  <tr>
    <td width="100%">&nbsp;<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td width="31%" align="center" valign="top" dir="ltr">
        <img border="0" src="<?php echo base_url('assets/img/transc4.png');?>" width="202" height="67"></td>
        <td width="39%" align="center"><b><font size="2"><?php echo $row->region_name; ?></font></b><br>
        <?php echo $row->region_address;?>
        </td>
        <td width="30%" align="left" valign="bottom">No. Invoice
        <table border="1" cellpadding="4" cellspacing="4" style="border-collapse: collapse" bordercolor="#111111" width="200">
          <tr>
            <td width="100%">XXXX-XXXX/YYYY</td>
          </tr>
        </table>
        </td>
      </tr>
    </table><br>
    <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td width="100%" align="center" class=td1"><font size="5">PROFORMA INVOICE</font></td>
      </tr>
      <tr>
        <td width="100%">
        <table border="0" cellpadding="4" cellspacing="4" style="border-collapse: collapse" bordercolor="#111111" width="100%">
          <tr>
            <td>&nbsp;</td>
            <td>Pembeli</td>
            <td>:</td>
            <td><?php echo $row->rowid; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo $row->rekanan_name; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Alamat</td>
            <td>:</td>
            <td><?php echo $row->rekanan_address;?></td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
   
    <br>
    <table border="1" cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
      <tr>
        <td align="center" ><b>NO</b></td>
        <td align="center" ><b>DESKRIPSI</b></td>
        <td align="center"><b>NILAI</b></td>
      </tr>
      <tr>
        <td align="center">
        <p dir="rtl"><br>
        <br>
        1<br>
        2</td>
        <td> Due to Outlet Rental On <?php echo $row->branch_namerpt; ?><br>
        Outlet : <?php echo $row->rekananshipping_name.' Unit '.$row->unit_name.' Area '.$row->unit_sqm.' m2';?><br>
        Rent periode : <?php echo date("d M Y", strtotime($row->loo_sdate)).' - '.date("d M Y", strtotime($row->loo_edate));?><br>
        <br>
        1st Installment<br>
        Service Charge-Periodical from 01 Dec 2017 - 28 Feb 
        2018<br>
        <br>
        <br>
        </td>
        <td align="right"><br>
        9.600.000<br>
        4.875.000</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td ></td>
        <td align="right">14.475.000</td>
      </tr>
            
    </table>
    
    <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td width="7%" style="border-right: 1px solid #fff;">
         </td>
        <td width="62%" valign="top" style="border-right: 1px solid #fff; border-left: 1px solid #fff;">
          <br>
          <b>PAYMENT TERMS AND CONDITIONS :</b><br>&nbsp;<br>
          Payment should be transfered to our Bank as Follows :<br>
          PAULUS DJASADIPURA<br>
          1. The payment value date is only effective when the funds are received 
          in our bank account and should be net of any bank charges<br>
          2. Interest at 0.1% Per Day will be charged on overdue balance<br>
          3. Bank Mega Cab. Tendean A/C No : 7801008100000929<br>
          4.This invoice is payable on or before 21 days after the invoice date
          <br>&nbsp;
        </td>
        <td width="31%" valign="top">
        <table border="1" cellpadding="3" cellspacing="3" style="border-collapse: collapse" width="100%">
          <tr>
            <td width="47%">PPN</td>
            <td width="53%" align="right">1.447.500</td>
          </tr>
          <tr>
            <td width="47%">Total</td>
            <td width="53%" align="right">5.922.500</td>
          </tr>
        </table>
        <br>Jakarta, 26 January 2018</td>
      </tr>
    </table>
    
</td>
  </tr>
</table>
<?php }}?>

</body>

</html>