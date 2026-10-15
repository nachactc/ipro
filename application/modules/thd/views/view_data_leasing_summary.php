<?php  
  if ($excel == 'detailExcel')
  {
	  $vbrnch=str_replace(" ","",$branch_info->branch_name);
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename=".$vbrnch.".xls");
  } 
 ?>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:5px 5px;border-top:1px solid;overflow:hidden;word-break:normal;border-color:inherit;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:5px 5px;border-top:1px solid;border-bottom:1px solid;overflow:hidden;word-break:normal;}
.tg .tg-0rzf{font-size:11px;font-family:"Arial Black", Gadget, sans-serif !important;text-align:center;vertical-align:top;background-color:#ccc}
.tg .tg-ldj7{font-size:11px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:#000000;text-align:center;vertical-align:top}
.tg .tg-iuhm{font-size:11px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top;}
.tg .tg-73lx{font-size:11px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:#000000;vertical-align:top}
.tg .tg-ur0i{font-size:11px;font-family:"Arial Black", Gadget, sans-serif !important;;text-align:center;vertical-align:top}
.tg .tg-vbnk{font-size:11px;font-family:Arial, Helvetica, sans-serif !important;vertical-align:top;padding:5px;background-color:#ccc}
.tg .tg-li00{font-size:12px;font-family:Arial, Helvetica, sans-serif !important;font-weight:bold;vertical-align:top;padding-top:10px;padding-bottom:10px;background-color:#ccc;border-top:1px solid;border-bottom:1px solid;}
.head1{font-size:14px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
.head2{font-size:12px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
.colmain {display: flex; justify-content: space-between; flex-wrap: wrap;}
.coltable {width:550px; flex-grow: 1; margin: 10px;}
</style>


<span class="head1">
	<b><?php echo ($branch_info != 'kosong') ? $branch_info->region_namereport : ''; ?></b>
</span>
<br />
<br />
<span class="head2">
   <b><?=$report_title?>
   <br />   
   <?php echo ($branch_info != 'kosong') ? $branch_info->branch_name : $region_name; ?>
   <br />
   </b>
   <i><?php echo 'Report Date '.date('d-M-Y',strtotime($report_date)); ?></i>
</span>
<br />
<br />

<div class="colmain">

   <div class="coltable">

      <table class="tg" cellpadding="0" cellspacing="0" style="width: 100%">
         <thead>            
            <?php printTableHeader()?>
         </thead>
         <tbody>
            <?php 
            if ($result){

               $rownumber = 0;
               $last_type_name ='';
               $i = 0;

               $subtotal = [
                  'total_nla' => 0,
                  'percent_all' => 0,
                  'percent_cat' => 100.00,
                  'total_amount' => 0
               ];

               $total = [
                  'total_nla' => 0,
                  'percent_all' => 0,
                  'percent_cat' => 100.00,
                  'total_amount' => 0
               ];

               foreach ($result->dataRowTypes as $row) { 

                  $arr = $row['total_nla'] !== 0 ? $row['total_amount']/$row['total_nla'] : 0;
                  $row['arr'] = $arr;
                  //$thousands = floor(($row->total_amount % 1000000) / 1000);
                  //$row->total_amount = $thousands;

                  $curpos = array_search($row['thdtype_name'], array_column($result->totalTypes, 'thdtype_name'));
                  $totalTypesNLA = $result->totalTypes[$curpos]['total_nla'];
                  $totalTypesAmount = $result->totalTypes[$curpos]['total_amount'];
                  $totalNLA = $result->total['total_nla'];
                  $totalAmount = $result->total['total_amount'];

                  //var_dump($result->totalTypes[$curpos]['total_nla']);
                  //var_dump(array_search($row['thdtype_name'], $result->totalTypes));
                  $row['percent_cat'] =  round(((float)($row['total_nla']/$totalTypesNLA) * 100), 2) . '%';
                  $row['percent_all'] =  round(((float)($row['total_nla']/$totalNLA) * 100), 2) . '%';
                  //round((float)$str * 100 ) . '%';

                  if ($row['thdtype_name'] !== $last_type_name) {
                     if ($i > 0) { printGroupFooter($subtotal); }
                     arrayValueReset($subtotal);
                     printGroupHeader($row);
                     $rownumber = 0;
                  }

                  $i++;	
                  $rownumber++;            
                  printRow($row, $rownumber);
                  arrayValueAdd($subtotal, $row);
                  arrayValueAdd($total, $row);
                  $last_type_name = $row['thdtype_name'];
               }        
               if ($i > 0) { printGroupFooter($subtotal); }
            } else { ?>
                     <div class="alert alert-success fade in ">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
                        <strong>Info!</strong> Belum Ada Data!
                     </div>
            <?php } ?> 
         </tbody>
         <tfoot>
            <?php printTableFooter($total)?>
         </tfoot>
      </table>
   </div>

   <div class="coltable">
      <table class="tg" cellpadding="0" cellspacing="0" style="width: 100%;">
         <thead>
            <?php printTableHeader()?>
         </thead>
         <tbody>
            <tr>
               <td class="tg-iuhm" style="font-weight: bold; padding-top:10px;" colspan="7">ALL</td>
            </tr>
         <?php 
            if ($result){

               $rownumber = 0;
               $last_type_name ='';
               $i = 0;

               $total = [
                  'total_nla' => 0,
                  'percent_all' => 0,
                  'percent_cat' => 100.00,
                  'total_amount' => 0
               ];

               foreach ($result->dataRowCategories as $row) { 

                  $arr = $row['total_nla'] !== 0 ? $row['total_amount']/$row['total_nla'] : 0;
                  $row['arr'] = $arr;

                  $totalNLA = $result->total['total_nla'];
                  $totalAmount = $result->total['total_amount'];

                  $row['percent_all'] =  round(((float)($row['total_nla']/$totalNLA) * 100), 2) . '%';
                  $row['percent_cat'] =  round(((float)($row['total_nla']/$totalNLA) * 100), 2) . '%';

                  $i++;	
                  $rownumber++;            
                  printRow($row, $rownumber);
                  arrayValueAdd($total, $row);
               }
            } else { ?>
                  <div class="alert alert-success fade in ">
                     <a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
                     <strong>Info!</strong> Belum Ada Data!
                  </div>
         <?php } ?> 
         </tbody>
         <tfoot>
            <?php printTableFooter($total)?>
         </tfoot>
      </table>
   </div>
</div>

<?php function printTableHeader() { ?>
   <tr>
      <th class="tg-0rzf" style="width: 4px">NO</th>
      <th class="tg-0rzf" style="width: 20px">KATEGORI</th>
      <th class="tg-0rzf" style="width: 8px">NLA</th>
      <th class="tg-0rzf" style="width: 10px">%(ALL)</th>
      <th class="tg-0rzf" style="width: 14px">%(KATEGORI)</th>
      <th class="tg-0rzf" style="width: 10px">Rp.</th>
      <th class="tg-0rzf" style="width: 10px">ARR</th>
   </tr>
<?php } ?>

<?php function printRow($row, $rownumber=0) { ?>
   <tr>
      <td class="tg-iuhm" style="text-align: center;"><?=$rownumber?></td>
      <td class="tg-iuhm" ><?=$row['thdcat_name']?></td>
      <td class="tg-iuhm" style="text-align: right;"><?=number_format($row['total_nla'])?></td>
      <td class="tg-iuhm" style="text-align: right;"><?=$row['percent_all']?></td>
      <td class="tg-iuhm" style="text-align: right;"><?=$row['percent_cat']?></td>
      <td class="tg-iuhm" style="text-align: right;"><?=number_format($row['total_amount'])?></td>
      <td class="tg-iuhm" style="text-align: right;"><?=number_format($row['arr'])?></td>
   </tr> 
<?php } ?>

<?php function printGroupHeader($row) { ?>
   <tr>
      <td class="tg-iuhm" style="font-weight: bold; padding-top:10px;" colspan="7"><?=$row['thdtype_name']?></td>
   </tr>

<?php } ?>

<?php function printGroupFooter($subtotal) { 

   $arrSubtotal = $subtotal['total_amount']/$subtotal['total_nla'];

?>
   <tr>
      <td class="tg-vbnk" style="padding-left: 20px;" colspan="2">Subtotal</td>      
      <td class="tg-vbnk" style="text-align: right;"><?=number_format($subtotal['total_nla'])?></td>
      <td class="tg-vbnk" style="text-align: right;"><?=number_format($subtotal['percent_all'], 2)?>%</td>
      <td class="tg-vbnk" style="text-align: right;"><?=number_format($subtotal['percent_cat'])?>%</td>
      <td class="tg-vbnk" style="text-align: right;"><?=number_format($subtotal['total_amount'])?></td>
      <td class="tg-vbnk" style="text-align: right;"><?=number_format($arrSubtotal)?></td>
   </tr> 
<?php } ?>

<?php function printTableFooter($total) { 

   $arrTotal = $total['total_amount']/$total['total_nla'];
   $percentAll = 100;
   $percentCat = 100;
?>
   <tr>
      <td class="tg-li00" style="padding-left: 20px;" colspan="2">Total</td>      
      <td class="tg-li00" style="text-align: right;"><?=number_format($total['total_nla'])?></td>
      <td class="tg-li00" style="text-align: right;"><?=number_format($percentAll)?>%</td>
      <td class="tg-li00" style="text-align: right;"><?=number_format($percentCat)?>%</td>
      <td class="tg-li00" style="text-align: right;"><?=number_format($total['total_amount'])?></td>
      <td class="tg-li00" style="text-align: right;"><?=number_format($arrTotal)?></td>
   </tr> 
<?php } ?>

<?php 
   function arrayValueAdd(&$arrdata, $aradd) {
      foreach ($arrdata as $name => $value) {
         if (array_key_exists($name, $aradd)) {
            $adder = (float)$aradd[$name];
            $arrdata[$name] += $adder;
         }
      }
   } 

   function arrayValueReset(&$arrdata) {
      foreach ($arrdata as $name => $value) {
         $arrdata[$name] = 0;
      }
   } 
?>