<?php //echo var_dump($header); ?>

<!-- HEADER AREA -->
<style type="text/css">  
html,body{
        height:297mm;
        width:210mm;
    }
.tg  {border-collapse:collapse;border-spacing:0;height:10px}
.tg td{font-family:Arial, sans-serif;font-size:12px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-0uih{font-weight:bold;font-family:"Times New Roman", Times, serif !important;;border-color:#ffffff;text-align:left;vertical-align:top}
.tg .tg-5tqt{font-weight:bold;font-family:"Times New Roman", Times, serif !important;;border-color:#ffffff;text-align:center;vertical-align:middle}
.tg .tg-ex2i{font-family:"Times New Roman", Times, serif !important;;border-color:#ffffff;text-align:left;vertical-align:middle}
.tg .tg-xv21{font-weight:bold;font-family:"Times New Roman", Times, serif !important;;border-color:#ffffff;text-align:left;vertical-align:top}
.tg .tg-juxo{font-family:"Times New Roman", Times, serif !important;;border-color:#ffffff;text-align:center;vertical-align:middle}
.tg .tg-p4o4{text-decoration:underline;font-family:"Times New Roman", Times, serif !important;;border-color:#ffffff;text-align:left;vertical-align:middle}
.tg .tg-gnwc{text-decoration:underline;font-family:"Times New Roman", Times, serif !important;;border-color:#ffffff;text-align:left;vertical-align:top}
.tg .tg-d0ae{font-family:"Times New Roman", Times, serif !important;;border-color:#ffffff;text-align:left;vertical-align:top}
</style>
<table class="tg" style="undefined;table-layout: fixed; width: 780px;">
<colgroup>
<col style="width: 96px">
<col style="width: 244px">
<col style="width: 96px">
<col style="width: 184px">
<col style="width: 107px">
<col style="width: 115px">
</colgroup> 
  <tr >
    <th class="tg-ex2i" rowspan="2"><img src="<?php echo base_url('assets/img/logo_TSM.jpg'); ?>" alt="TSM" height="81" width="82" /></th>
    <th class="tg-xv21" colspan="3" style="font-size:20;"><?php echo $header->branch_name; ?></th>
    <th class="tg-ex2i" style="height:1px;"></th>
    <th class="tg-ex2i" style="height:1px;"></th>
  </tr>
  <tr>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
    <td class="tg-5tqt" colspan="3"><?php echo $title; ?></td>
  </tr>
  <tr>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
    <td class="tg-juxo" colspan="3"><?php echo $jurnal_id; ?></td>
  </tr>
  <tr>
    <td class="tg-xv21">Receipt</td>
    <td class="tg-p4o4"><?php echo $header->rekanan_name; ?></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i">Source</td>
    <td class="tg-p4o4"><?php echo $header->jurnal_source; ?></td>
  </tr>
  <tr>
    <td class="tg-xv21">Branch</td>
    <td class="tg-p4o4"><?php echo $detil[0]->rekananshipping_name; ?></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
  </tr>
  <tr>
    <td class="tg-xv21">Period</td>
    <td class="tg-p4o4"><?php echo $header->periode_name; ?></td>
    <td class="tg-xv21">Bookdate</td>
    <td class="tg-p4o4"><?php echo date('d-m-Y',strtotime($header->jurnal_bookdate)); ?></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
  </tr>
  <tr>
    <td class="tg-xv21">Descr</td>
    <td class="tg-p4o4"><?php echo $header->jurnal_descr; ?></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i"></td>
    <td class="tg-ex2i">Payment Type</td>
    <td class="tg-p4o4"><?php echo $payment; ?></td>
  </tr>
  <tr>
    <td class="tg-0uih">Amount</td>
    <td class="tg-gnwc"><?php echo number_format($header->jurnal_idr,0); ?></td>
    <td class="tg-0uih">Foreign/Rate</td>
    <td class="tg-gnwc"><?php echo $detil[0]->jurnaldetil_foreign.' / '.$detil[0]->jurnaldetil_foreignrate ; ?></td>
    <td class="tg-d0ae"></td>
    <td class="tg-d0ae"></td>
  </tr>
  <tr>
    <td class="tg-d0ae"></td>
    <td class="tg-d0ae"></td>
    <td class="tg-d0ae"></td>
    <td class="tg-d0ae"></td>
    <td class="tg-d0ae"></td>
    <td class="tg-d0ae"></td>
  </tr>
</table>
<!-- END HEADER AREA -->

<!-- BILYET AREA -->
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:12px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-cly1{text-align:left;vertical-align:middle}
.tg .tg-415f{text-decoration:underline;text-align:left;vertical-align:middle}
.tg .tg-y93n{background-color:#c0c0c0;text-align:center;vertical-align:middle}
.tg .tg-y6fn{background-color:#c0c0c0;text-align:left;vertical-align:top}
.tg .tg-0lax{text-align:left;vertical-align:top}
</style>

<table class="tg" style="undefined;table-layout: fixed; width: 821px;height:10px;">
<colgroup>
<col style="width: 106px">
<col style="width: 351px">
<col style="width: 63px">
<col style="width: 150px">
<col style="width: 150px">
</colgroup>
  <tr>
    <th class="tg-y93n" colspan="2"><strong>Description</strong></th>
    <th class="tg-y93n"><strong>Curr</strong></th>
    <th class="tg-y93n"><strong>IDR</strong></th>
    <th class="tg-y93n"><strong>Foreign</strong></th>
  </tr>
  <?php
   $bilyet_date = new DateTime($bilyet['jurnalbilyet_date']);
   $bilyet_date = $bilyet_date->format('d-m-Y');
  ?>
   <tr>
    <td class="tg-cly1" colspan="2" rowspan="2"><?=$header->jurnal_descr?>
    <td class="tg-cly1" rowspan="2" style="text-align: center;"><?=$bilyet['currency_id']?></td>
    <td class="tg-cly1" rowspan="2" style="text-align: right;"><?=number_format($bilyet['jurnalbilyet_idr'], 2)?></td>
    <td class="tg-cly1" rowspan="2" style="text-align: right;"><?=number_format($bilyet['jurnalbilyet_foreign'], 2)?></td>
  </tr>
  <tr>
  </tr>
  <tr>
    <td class="tg-cly1"><strong>Bank</strong></td>
    <td class="tg-415f"><?=$bilyet['jurnalbilyet_bank']?></td>
    <td class="tg-0lax"></td>
    <td class="tg-cly1"></td>
    <td class="tg-cly1"></td>
  </tr>
  <tr>
    <td class="tg-cly1"><strong>Bilyet No</strong></td>
    <td class="tg-415f"><?=$bilyet['jurnalbilyet_no']?></td>
    <td class="tg-0lax"></td>
    <td class="tg-cly1"></td>
    <td class="tg-cly1"></td>
  </tr>
  <tr>
    <td class="tg-cly1"><strong>Receipt By</strong></td>
    <td class="tg-415f"><?=$bilyet['jurnalbilyet_receiveperson']?></td>
    <td class="tg-0lax"></td>
    <td class="tg-cly1"></td>
    <td class="tg-cly1"></td>
  </tr>
  <tr>
    <td class="tg-cly1"><strong>Received Date</strong></td>
    <td class="tg-415f"><?=$bilyet_date?></td>
    <td class="tg-0lax"></td>
    <td class="tg-cly1"></td>
    <td class="tg-cly1"></td>
  </tr>
  <tr>
    <td class="tg-0lax" colspan="3"><strong>Total</strong></td>
    <td class="tg-0lax" style="text-align: right;"><?=number_format($bilyet['jurnalbilyet_idr'], 2)?></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
  </tr>
</table>
 

<!-- END BILYET AREA -->
 
<!-- REF AREA -->


<br/>
 
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:12px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-cly1{text-align:left;vertical-align:top}
.tg .tg-kftd{background-color:#efefef;text-align:left;vertical-align:top}
.tg .tg-gg7l{background-color:#efefef;text-align:left;vertical-align:middle}
.tg .tg-0lax{text-align:left;vertical-align:top}
</style>

<div class="tblref" style="padding-bottom: 5px;"> 
   <table style="undefined;table-layout: fixed; width: 822px">  
   <tbody>
         <tr>
            <td class='tg-cly1' colspan="6"> REF : <?=$ref?></td> 
         </tr>
      </tbody>
   </table>
</div>

<table class="tg" style="undefined;table-layout: fixed; width: 822px">
   <colgroup>
   <col style="width: 34px">
   <col style="width: 52px">
   <col style="width: 430px">
   <col style="width: 67px">
   <col style="width: 117px">
   <col style="width: 119px">
   </colgroup>
   <thead>
      <tr>
         <th class="tg-y93n"><strong>No</strong></th>
         <th class="tg-y93n"><strong>Line</strong></th>
         <th class="tg-y93n"><strong>Account / Description</strong></th>
         <th class="tg-y93n"><strong>Curr</strong></th>
         <th class="tg-y93n"><strong>IDR</strong></th>
         <th class="tg-y93n"><strong>Foreign</strong></th>
      </tr>
   </thead>
   <tbody>
<?php
   $i=0;
   foreach($detil as $rows => $row) {
   $i++;
   $description = "
      <div style='display: flex; flex-direction: row;'>
         <div>
            <span style='font-size: 12px; vertical-align: top'>$row->acc_id - $row->acc_name</div>
         </div>
         <div style='font-size: 12px;'>$row->region_name - $row->branch_name - $row->strukturunit_name</div>
         <div style='font-style: italic; padding-left: 10px;font-size: 12px;'>$row->jurnaldetil_descr</div>
      </div>
   ";
?>
      <tr>
         <td class='tg-cly1' style="text-align: center;"><?=$i?></td>
         <td class='tg-cly1' style="text-align: center;"><?=$row->jurnaldetil_line?></td>
         <td class='tg-cly1'><?=$description?></td>
         <td class='tg-cly1' style="text-align: center;"><?=$row->currency_id?></td>
         <td class='tg-0lax' style="text-align: right;"><?=number_format($row->jurnaldetil_idr, 2)?></td>
         <td class='tg-0lax' style="text-align: right;"><?=number_format($row->jurnaldetil_foreign, 2)?> </td>
      </tr> 
<?php 
   }
?>
   </tbody>
   <tfoot></tfoot>
</table>
<!-- END REF AREA -->

<label><i> Print Date <?php echo date('d-m-Y'); ?></i></label>
<br/>
<!-- TTD AREA -->
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-z4i2{border-color:#ffffff;text-align:left;vertical-align:middle}
.tg .tg-44qx{font-weight:bold;border-color:#ffffff;text-align:center;vertical-align:middle}
.tg .tg-v0mg{border-color:#ffffff;text-align:center;vertical-align:middle}
.tg .tg-3ge6{text-decoration:underline;border-color:#ffffff;text-align:center;vertical-align:top}
</style>

<table class="tg" style="table-layout: fixed; width: 822px; page-break-inside: avoid;">
   <tr>
   <?php 
      if ($approval) :
         foreach ($approval as $row) : 
   ?>
      <th class="tg-44qx"><?=$row->strukturunitapprovalauth_header?></th>
   <?php endforeach; ?>
   </tr>
   <tr>
   <?php foreach ($approval as $row) : ?>
      <td class="tg-v0mg"><?=$row->strukturunitapprovalauth_position?></td>
   <?php endforeach; ?>
   </tr>
   <tr><td class="tg-v0mg"></td></tr>
   <tr><td class="tg-v0mg"></td></tr>
   <tr><td class="tg-v0mg"></td></tr>
   <tr>
   <?php foreach ($approval as $row) : ?>
      <td class="tg-3ge6"><?=$row->strukturunitapprovalauth_name?></td>
   <?php 
         endforeach; 
      endif;
   ?>
   </tr>
</table>
<!-- END TTD AREA -->