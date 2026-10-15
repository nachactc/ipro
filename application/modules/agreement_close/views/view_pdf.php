<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
@font-face {
    font-family: 'arial'; /*a name to be used later*/
    src: url('<?php echo base_url('assets/css/loo/arial.ttf');?>'); /*URL to font*/
}
body {font-family: 'arial';font-size: 9pt}
@page { margin-left:3cm; margin-right:1cm; margin-top:2.5cm;margin-bottom:1.5cm;size:8.27in 11.69in;}
.style3 {font-size: 10pt; }
</style>
</head>
<body>
  <?php      

    if(isset($result)){
      $pasunitname = '';
      $pasunitsqm = 0;
      $lantai=''; 
      foreach($vunit as $rowunit){ 
        $pasunitname .= $rowunit->unit_name. '&'; 
        $pasunitsqm   = $rowunit->unit_sqm+$pasunitsqm;    
        $lantai      .= $rowunit->lantai_name.'&';
      }
    }
    //$vunitname = trim($pasunitname, "&");
    $vunitsqm =$pasunitsqm;
    $lantainame= trim($lantai, "&");

    if(isset($result)){
      foreach($result as $row){ 
      //print_r($result);
  ?>  

<htmlpageheader name="firstpage" style="display:none">
  <div style="text-align:center">
  </div>
</htmlpageheader>

<htmlpageheader name="otherpages" style="display:none">
  <div style="border-top: 0px solid #000000; font-size: 9pt; text-align: right; padding-top: 3mm; ">
    {PAGENO}/{nb}
  </div>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<div style="border-top: 0px solid #000000; font-size: 6pt; text-align: center; padding-top: 3mm; ">
<?php echo $row->rekananshipping_name.' - '.$row->agreement_loonumber; ?>
</div>
</htmlpagefooter>

<sethtmlpageheader name="firstpage" value="on" show-this-page="1"/>
<sethtmlpageheader name="otherpages" value="on"/>
<sethtmlpagefooter name="myfooter" value="on" />

<table width="800" border="0">
  <tr>
    <td width="626" align="center"><p class="style3"><b>Apendik II</b></p>
    <p class="style3"><b>Jadwal Pembayaran</b></p>
    <p class="style3"><b><?php echo $row->branch_name;?></b></p>
    <p class="style3"><b><?php echo $row->rekananshipping_name;?></b></p></td>
  </tr>
</table>
<p>&nbsp;</p>
  <table width="800" border="0">
  <tr>
    <td width="166"><b>Nama Pemilik</b></td>    
    <td colspan="3"><?php echo $row->rekanan_name;?></td>
  </tr>
  <?php 
    $i =1;
    foreach ($vruangsewa as $ruang) {    
  ?>
  <tr>
    <td><b><?php if ($i==1) echo 'Ruang Sewa'; ?></b></td>
    <td colspan="3"><?php echo $ruang->agreementdetil_unit;?></td>    
  </tr>
  <?php $i++; } ?>  
  <tr>
    <td width="166"><b>Area</b></td>    
    <td width="26">&nbsp;</td>
    <td width="101" align="right"><?php echo $vunitsqm;?></td>
    <td width="65">/m2</td>
    <td width="102">&nbsp;</td>
    <td width="309">&nbsp;</td>
  </tr>
<?php
    $i =1;
    foreach($vhargasewa as $rowsewa){
?>
  <tr>
    <td><b><?php if ($i==1) echo 'Uang Sewa per bulan'; ?></b></td>
    <td>Rp</td>
    <td align="right"><?php echo number_format($rowsewa->agreementdetil_baserent,0);?></td>
    <td>/m2</td>
    <td>&nbsp;</td>
    <td>Subject to VAT 10%</td>
  </tr>  
<?php
    $i++; }
    $i =1;
    foreach($vhargasc as $rowsc){
?>
  <tr>
    <td><b><?php if ($i==1){ echo 'Biaya Pelayanan per bulan';} ?></b></td>
    <td>Rp</td>
    <td align="right"><?php echo number_format($rowsc->agreementdetil_baserent,0);?></td>
    <td colspan="2">/m2</td>
    <td>Subject to VAT 10%</td>    
  </tr> 
<?php
    $i++; }
    foreach($vhargapromo as $rowpromo){
?>
  <tr>
    <td><b>Biaya Promosi per bulan</b></td>
    <td>Rp</td>
    <td align="right"><?php echo number_format($rowpromo->agreementdetil_baserent,0);?></td>
    <td colspan="2">/m2</td>
    <td>Subject to VAT 10%</td>
  </tr> 
<?php    
    }    
    foreach($vhargafood as $rowfood){
?>      
    <tr>
      <td><b>Biaya Food Court per bulan</b></td>
      <td>Rp</td>
      <td align="right"><?php echo number_format($rowfood->agreementdetil_baserent,0);?></td>
      <td>/m2</td>
      <td><?php echo number_format($rowfood->agreementdetil_mia,0).' (lumpsum)';?></td>
      <td>Subject to VAT 10%</td>    
    </tr> 
<?php
    }
?>      
  <tr>
    <td><b>Biaya Utilitas</b></td>
    <td colspan="2">Based on KWH</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>    
  </tr> 
  <tr>
    <td><b>Periode Sewa</b></td>    
    <td colspan="3"><?php echo date('j F Y', strtotime($row->agreement_startdate)).' - '.date('j F Y', strtotime($row->agreement_enddate));?></td>    
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
  <tr>
    <td><b>Jangka Waktu Sewa</b></td>    
    <td></td>
    <td align="right"><?php echo $row->agreement_term;?></td>
    <td>bulan</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php    
  foreach($vtotallease as $rowtotal){
?>
  <tr>
    <td><b>Total Uang Sewa</b></td>
    <td>Rp</td>
    <td align="right"><?php echo number_format($rowtotal->total_lease,0);?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr> 
<?php
    }
    $dpsum=0;
    foreach($vdepe as $rowdp){    
?>
    <tr>
      <td><b><?php if ($dpsum==0){ echo 'Dibayarkan sebagai berikut';} ?></b></td>
      <td>&nbsp;</td>
      <td align="right"><?php echo number_format($rowdp->agreementdetil_percent,0).'%';?></td>
      <td><?php echo $rowdp->agreementtype_ina;?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr> 
<?php
    $dpsum += $rowdp->agreementdetil_percent;
    }
?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><?php echo (100 - $dpsum).'%';?></td>
      <td colspan="3">dibayarkan dalam <?php echo $vang.' ('.Terbilang($vang).' ) ';?> kali angsuran</td>      
    </tr>
<?php
    $depo=0;
    foreach($vdeposit as $rowdepo){    
?>
    <tr>
      <td><b><?php if ($depo==0){ echo 'Simpanan Jaminan';} ?></b></td>
      <td>Rp</td>
      <td align="right"><?php echo number_format($rowdepo->agreementdeposit_idrsubtotal,0);?></td>
      <td colspan="3"><?php echo $rowdepo->agreementdeposit_duedate; ?> bulan uang sewa dan biaya pelayanan (wajib dibayarkan)</td>      
    </tr> 
<?php   
    $depo++;
    }
?>    
<?php
    $td=0;
    foreach($vtdep as $rowtd){    
?>
    <tr>
      <td><b><?php if ($td==0){ echo 'Jaminan Telepon';} ?></b></td>
      <td>Rp</td>
      <td align="right"><?php echo number_format($rowtd->agreementdeposit_idrsubtotal,0);?></td>
      <td colspan="2">Per satu (1) sambungan</td>      
      <td>&nbsp;</td>
    </tr> 
<?php   
    $td++;
    }
?>  
</table>
<br>
<table width="800" border="0">
  <tr>
    <td colspan="2"><u><b>Tabel Arus Kas</b></u></td>
    <td width="468">&nbsp;</td>
    <td width="30">&nbsp;</td>
    <td width="36">&nbsp;</td>
  </tr>
  <tr>
    <td width="130">Tanggal Mulai Sewa :</td>
    <td colspan="2"><?php echo date('j F Y', strtotime($row->agreement_startdate));?></td>    
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Jadwal ini akan ditinjau setiap tahun</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table border ="1" style='font-size: 0.8em; border-collapse:1px solid'>
  <tr>
    <th>&nbsp;Tanggal Bayar&nbsp;</th>
    <th>&nbsp;</th> 
<?php 
 $i =0;

 //print_r($collabel);  
  foreach($collabel as $col_title){
    $exp_title = explode('|', $col_title);
    $_title = $exp_title[1];
?>    
    <th>&nbsp;<?php echo $_title;?>&nbsp;</th> 
<?php 
  }
?>
    <th> &nbsp;Arus Kas&nbsp; <br>&nbsp;</th>
  </tr>
<?php
  $num = 0;
  foreach($rowlabel as $row_title){
?>    
    <tr>
      <th align='center'>&nbsp;<?php echo date('j M Y', strtotime($row_title));?>&nbsp;</th>
      <td align='center'>&nbsp;<?php if ($num != 0) echo $num; ?>&nbsp;</td>
<?php
    foreach($collabel as $col_title){
      $i = $col_title.'_'.$row_title;   

      $ex_title = explode('|', $col_title);
      $_title = $ex_title[1];  

      if (isset($zcross_tab[$i])){        
?>
        <td align="right">
          &nbsp;
          <?php 
            if ($zcross_tab[$i] == 0 && $_title == 'Biaya Pelayanan'){
              echo 'To Be Review';
            }else{
              echo number_format($zcross_tab[$i],0);
            }
          ?>
          &nbsp;          
        </td>
<?php     
      }else{
?>      
        <td align="right">
          &nbsp;
          <?php 
            if ($_title == 'Biaya Pelayanan' && $num > 12){
              echo 'To Be Review';
            }else{
              echo '-';
            }
          ?>&nbsp;
        </td>      
<?php      
      }
    }
?>      <td align="right"><b>&nbsp;<?php echo number_format($xtotal[$row_title],0);?>&nbsp;</b></td>  
    </tr>
<?php  
  $num++; }
?>
    <tr><td align="right" colspan="2"><b>&nbsp;Sub Total&nbsp;</b></td>
<?php
    $grand_total = 0;

    foreach($collabel as $col_title){
        $grand_total += $ytotal[$col_title];
?>
        <td align="right"><b>&nbsp;<?php echo number_format($ytotal[$col_title],0);?></b>&nbsp;</td>
<?php    
    }
?>      
        <td align="right"><b>&nbsp;<?php echo number_format($grand_total,0);?>&nbsp;</b></td>    
    </tr>
</table>
<br>
<table width="800" border="0">  
  <tr>
    <td width="64"><b>Remarks:</b></td>
    <td width="15">&nbsp;</td>    
    <td width="153">&nbsp;</td>
    <td width="550">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>1.</td>
    <td colspan ="2">Pembayaran harus di lakukan melalui Bilyet Giro/Cek atau melalui transfer.</td>    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>2.</td>
    <td>Pembayaran di transfer ke :</td>   
    <td><b>PEMBAYARAN DILAKUKAN KE NO VIRTUAL ACCOUNT <?php echo $row->agreement_virtualaccount.' a/n '.$row->rekanan_name;?></b></td>    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>   
    <td><b>Mohon kirimkan bukti pembayaran melalui fax ke Divisi "Collection Shopping Mall"</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><b>Carefour Lebak Bulus 3rd Floor, Jl. Lebak Bulus Raya No.8 Jakarta 12310</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><b>Fax No.(021) 27585899/27585738 - Tel. 27585800 ext 55532</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>3.</td>
    <td colspan="2"><b>Untuk Penyewa yang melakukan pembayaran dengan melakukan pemotongan pajak pasal 4(2):</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">a. Mohon dikirimkan bukti potong pajak 4 (2) asli ke  divisi "Collection Shopping Mall".</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">b. Jika Pemilik tidak menerima bukti potong seperti diatas maka Penyewa di anggap masih memiliki hutang atas pajak tersebut.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>4.</td>
    <td colspan="2">Keterlambatan pembayaran akan dikenakan denda <b>0.1%  (nol koma satu persen) per hari.</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">Dalam hal pembayaran hutang melewati 15 hari maka Pemilik memiliki hak penuh untuk memutus perjanjian sewa ini</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">dan Penyewa tidak memiliki hak untuk melakukan tuntutan apapun kepada Pemilik.</td>
  </tr>
</table>   
<?php }}?>
</body>
</html>