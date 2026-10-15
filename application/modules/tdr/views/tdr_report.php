<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-oe15{background-color:#ffffff;border-color:#ffffff;text-align:left;vertical-align:top}
.tg .tg-9248{font-weight:bold;font-family:"Times New Roman", Times, serif !important;;background-color:#ffffff;border-color:#ffffff;text-align:center;vertical-align:top}
.tg .tg-cy0b{font-size:12px;font-family:"Times New Roman", Times, serif !important;;background-color:#ffffff;border-color:#ffffff;text-align:left;vertical-align:top}
.tg .tg-hkrl{font-size:13px;font-family:"Times New Roman", Times, serif !important;;background-color:#efefef;border-color:#ffffff;text-align:center;vertical-align:top}
.tg .tg-aa48{font-size:12px;font-family:"Times New Roman", Times, serif !important;;background-color:#ffffff;color:#fd6864;border-color:#ffffff;text-align:right;vertical-align:top}
.tg .tg-8ur7{font-size:12px;font-family:"Times New Roman", Times, serif !important;;background-color:#ffffff;color:#fd6864;border-color:#ffffff;text-align:left;vertical-align:top}
</style>
 
 
<?php //echo form_open(site_url('aging/aging_excel'),"target='_blank'"); ?>
	<!-- <button class="exportToExcel">Export to EXCEL</button> -->
<?php //echo form_close(); ?>

 <title><?php echo $title;?></title>
<?php  if($result != 'kosong'){ ?>

<table class="tg table2excel"  id="AgingDetail_<?php echo date('d_m_Y_s') ?>" style="undefined;table-layout: fixed; width: 1600px; line-height:5px" width="100%">
<colgroup>
<col style="width: 150px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 130px">
<col style="width: 117px">
<col style="width: 101px">
<col style="width: 99px">
<col style="width: 96px">
<col style="width: 105px">
<col style="width: 114px">
<col style="width: 89px">
<col style="width: 160px">
<col style="width: 180px">
<col style="width: 135px">
<col style="width: 50px">
<col style="width: 135px">
<col style="width: 135px">
</colgroup>
  <tr>
    <th class="tg-9248" colspan="16"> <?php echo ($region_id != 0) ? strtoupper($result[0]->UNIT) : 'ALL BUSINESS UNIT'; ?></th>
  </tr>
  <tr>
    <td class="tg-9248" colspan="16"><?php echo strtoupper($title); ?></td>
  </tr>
  <tr>
    <td class="tg-9248" colspan="16">PERIODE : <?php echo date('d-m-Y',strtotime($startdate)) .' s/d '. date('d-m-Y',strtotime($enddate)); ?> </td>
  </tr>
  <tr>
    <td class="tg-oe15" colspan="16">Total Data : <?php echo number_format(count($result),0,',','.'); ?> Row(s)</td>
  </tr>  
  <tr>
    <td class="tg-hkrl" nowrap style="text-align: left;">Journal ID</td>
    <td class="tg-hkrl">Bookdate</td>
    <td class="tg-hkrl" nowrap style="text-align: left;">REKAN_ID</td>
    <td class="tg-hkrl" nowrap style="text-align: left;">REGION_ID</td>
    <td class="tg-hkrl" nowrap style="text-align: left;">BRANCH_ID</td>
    <td class="tg-hkrl" nowrap style="text-align: left;">UNIT</td>
    <td class="tg-hkrl" nowrap style="text-align: left;">STORE</td>
    <td class="tg-hkrl">CONTRACT_NO</td>
    <td class="tg-hkrl" nowrap style="text-align: left;">TENANT</td>
    <td class="tg-hkrl" nowrap style="text-align: left;">BRAND</td>
    <td class="tg-hkrl" nowrap style="text-align: left;">ACC_ID</td>
    <td class="tg-hkrl" nowrap style="text-align: left;">ACC_NAME</td>
    <td class="tg-hkrl" nowrap style="text-align: right;">AMOUNT</td>
  </tr>       
  <?php
    foreach($result as $row=>$val) {
  ?>
   <tr nowrap>
    <td class="tg-cy0b" nowrap><?php echo $val->jurnal_id; ?></td>    
    <td class="tg-cy0b" nowrap style="text-align: center;"><?php echo date('Y-m-d',strtotime($val->jurnal_bookdate)) ;?></td>
    <td class="tg-cy0b" nowrap ><?php echo $val->REKAN_ID; ?></td>
    <td class="tg-cy0b" nowrap ><?php echo $val->REGION_ID; ?></td>
    <td class="tg-cy0b" nowrap ><?php echo $val->BRANCH_ID; ?></td>
    <td class="tg-cy0b" nowrap><?php echo $val->UNIT; ?></td>
    <td class="tg-cy0b" nowrap><?php echo $val->STORE; ?></td>
    <td class="tg-cy0b" nowrap style="text-align: center;"><?php echo $val->CONTRACT_NO; ?></td>
    <td class="tg-cy0b" nowrap><?php echo $val->TENANT; ?></td>
    <td class="tg-cy0b" nowrap><?php echo $val->BRAND; ?></td>
    <td class="tg-cy0b" nowrap><?php echo $val->ACC_ID; ?></td>
    <td class="tg-cy0b" nowrap><?php echo $val->ACC_NAME; ?></td>
    <td id="angka_report" class="tg-cy0b" nowrap style="text-align: right;"><?php echo number_format($val->AMOUNT,2); ?></td>
  </tr>
<?php } ?>  
</table>
<?php  } else { echo 'Data Tidak Ditemukan'; }  ?>

<!-- UPLOAD EXCEL
<script src="<?php //echo base_url('assets/plugins/jquery.min.js');?>" type="text/javascript"></script> 
<script src="<?php //echo base_url()."assets/plugins/exportexcel/table2excel/" ?>jquery.table2excel.js"></script>    
 
<script> 
 // $(function() {
				// $(".exportToExcel").click(function(e){ 
					// $(".table2excel").table2excel({
						// exclude: ".noExl", 
						// name: "Aging Detil",
						// filename: "Aging_Detil_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
						// preserveColors: false // set to true if you want background colors and font colors preserved
					// }); 
				// });
				
			// });
</script> 
END !-->