<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Proforma Invoice</title>

<style>


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


<?php
if(isset($result)){
foreach($result as $row){
?>  
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
  <tr>
    <td width="100%">&nbsp;
      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td width="28%" align="center" valign="top" dir="ltr">
        <img border="0" src="<?php echo base_url('assets/img/transc4.png');?>" width="202" height="67"></td>
        <td width="39%" align="center" valign="top"><font size="4"><b><?php echo $row->region_name; ?></b></font><br>
        <?php echo $row->region_address;?>
        </td>      
        <td width="6%"></td>  
        <td width="27%" align="left" valign="bottom">        
          Nomor Invoice:
        <table border="1" cellpadding="4" cellspacing="4" style="border-collapse: collapse" bordercolor="#111111" width="200">
          <tr>
            <td width="100%" align="right"><?php echo $row->loo_id;?></td>
          </tr>
        </table>
        </td>
      </tr>
    </table>
    <br>
     <table cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td align="center" style="border-top: 1px solid #000; border-left: 1px solid #fff;border-right: 1px solid #fff; border-bottom: 1px solid #000;"><font size="6"><b>PROFORMA INVOICE</b></font></td>
      </tr>
      <tr>
        <td>
        <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
          <tr>
            <td style="border-left: 1px solid #fff;">&nbsp;</td>
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
    <table cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
      <tr>
        <td width="7%" align="center" style="border-top: 1px solid ; border-right: 1px solid; border-bottom: 1px solid;" >No</td>
        <td colspan="2" align="center" style="border-top: 1px solid; border-right: 1px solid; border-bottom: 1px solid;">Deskripsi</td>        
        <td width="16%" align="center" style="border-top: 1px solid #000; border-bottom: 1px solid #000;">Nilai</td>
      </tr>
      <tr>
        <td align="center" style=" border-right: 1px solid; border-bottom: 1px solid;">
        <br>
        <br>
        <br>
        <br>
        1
        <br>
        </td>
        <td colspan="2" style="border-right: 1px solid; border-bottom: 1px solid;"> 
        Due to Outlet Rental On <?php echo $row->branch_namerpt; ?><br>
        Outlet : <?php echo $row->rekananshipping_name.' Unit '.$row->unit_name.' Area '.$row->unit_sqm.' m2';?><br>
        Rent periode : <?php echo date("d M Y", strtotime($row->loo_sdate)).' - '.date("d M Y", strtotime($row->loo_edate));?><br>
        <br>
        Rental Payment <?php echo $row->total_payment; ?>% <br>        
        </td>
        <td align="right" style="border-bottom: 1px solid;">
		    <br>
		    <br>
        <br>
        <br>
        <?php 

          

          $dp = $row->total_payment;
          $_dp   = ($row->loodetil_mia* ($dp/100));
          echo number_format($_dp);
        ?>
        <br>
        </td>
      </tr>
      <tr>
        <td>        
        </td>
        <td width="69%"><b>PAYMENT TERMS AND CONDITIONS :</b></td>
        <td width="8%" style="border-left: 1px solid;border-right: 1px solid; border-bottom: 1px solid;"> 
        Total        </td>
        <td align="right" style="border-bottom: 1px solid;">        
        <?php 
          echo number_format($_dp);
        ?>        
        </td>
      </tr>
    </table>
    <table cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
      <tr>
        <td width="10%" style=""></td>
        <td width="62%" valign="top" style="border-right: 1px solid #fff; border-left: 1px solid #fff;">  
        <font size="2">        
          1. This invoice is payable on or before 21 days after the invoice date<br>
          2. Payment should be transfered to our Bank as Follows :<br>
          &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row->rekanan_name; ?><br>
          3. Bank Mega Cab. Tendean A/C No : <?php echo $row->virtual_acc; ?><br>
          &nbsp;&nbsp;&nbsp;&nbsp;The payment value date is only effective when the funds are received in our<br>
          &nbsp;&nbsp;&nbsp;&nbsp;bank account and should be net of any bank charges<br>
          4. Interest at 0.1% Per Day will be charged on overdue balance
          <br>&nbsp;
        </font>
        </td>
        <td width="28%" align ="right" valign="top">
          <font size="2">       
            Jakarta, <?php echo date("d F Y"); ?>&nbsp;
          </font>
          <br>
          <br>
          <br>
          <br>
          <br>
          <?php echo $print_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
      </tr>
    </table>


</td>
  </tr>
</table>
<?php }}?>

</body>

</html>