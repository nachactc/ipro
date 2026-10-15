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
  <tr>
    <th class="tg-9248" colspan="16"> <?php echo 'ALL BUSINESS UNIT'; ?></th>
  </tr>
  <tr>
    <td class="tg-9248" colspan="16"><?php echo strtoupper($title); ?></td>
  </tr>
  <tr>
    <td class="tg-9248" colspan="16">PERIODE : <?php echo ' s/d '. date('d-m-Y',strtotime($enddate)); ?> </td>
  </tr>
  <tr>
    <td class="tg-oe15" colspan="16">Total Data : <?php echo number_format(count($result),0,',','.'); ?> Row(s)</td>
  </tr>  
  <tr>
    <td class="tg-cy0b" nowrap>doc_id</td>
    <td class="tg-cy0b" nowrap>doc_type</td>
    <td class="tg-cy0b" nowrap>doc_descr</td>
    <td class="tg-cy0b" nowrap>doc_period</td>
    <td class="tg-cy0b" nowrap>doc_date</td>
    <td class="tg-cy0b" nowrap>doc_line</td>
    <td class="tg-cy0b" nowrap>faktur_no</td>
    <td class="tg-cy0b" nowrap>pro_id</td>
    <td class="tg-cy0b" nowrap>pro_period</td>
    <td class="tg-cy0b" nowrap>pro_date</td>
    <td class="tg-cy0b" nowrap>region_id</td>
    <td class="tg-cy0b" nowrap>region_name</td>
    <td class="tg-cy0b" nowrap>branch_id</td>
    <td class="tg-cy0b" nowrap>branch_name</td>
    <td class="tg-cy0b" nowrap>rekanan_id</td>
    <td class="tg-cy0b" nowrap>rekanan_name</td>
    <td class="tg-cy0b" nowrap>rekananshipping_line</td>
    <td class="tg-cy0b" nowrap>rekananshipping_name</td>
    <td class="tg-cy0b" nowrap>contract_no</td>
    <td class="tg-cy0b" nowrap>grouptenant_id</td>
    <td class="tg-cy0b" nowrap>rekananshipping_isactive</td>
    <td class="tg-cy0b" nowrap>agreementtype_groupcollection</td>
    <td class="tg-cy0b" nowrap>due</td>    
    <td class="tg-aa48" nowrap>AMOUNT</td>
    <td class="tg-cy0b" nowrap>transaksi_type</td>
    <td class="tg-cy0b" nowrap>Aging_type</td>
    <td class="tg-cy0b" nowrap>salesarea_id</td>
    <td class="tg-cy0b" nowrap>COLL_IDR</td>
    <td class="tg-cy0b" nowrap>All_id</td>
    <td class="tg-cy0b" nowrap>All_date</td>
    <td class="tg-cy0b" nowrap>OR_id</td>
    <td class="tg-cy0b" nowrap>OR_type</td>
    <td class="tg-cy0b" nowrap>OR_period</td>
    <td class="tg-cy0b" nowrap>OR_date</td>
    <td class="tg-cy0b" nowrap>tenant_type</td>
    <td class="tg-cy0b" nowrap>p_status</td>
    <td class="tg-cy0b" nowrap>c_status</td>
    <td class="tg-cy0b" nowrap>Aging</td>
  </tr>       
  <?php
    foreach($result as $row=>$val) {
  ?>
   <tr nowrap>
    <td class="tg-cy0b" nowrap><?php echo $val->doc_id; ?></td>    
    <td class="tg-cy0b" nowrap><?php echo $val->doc_type; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->doc_descr; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->doc_period; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->doc_date; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->doc_line; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->faktur_no; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->pro_id; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->pro_date; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->region_id; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->region_name; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->branch_id; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->branch_name; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->rekanan_id; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->rekanan_name; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->rekananshipping_line; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->rekananshipping_name; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->contract_no; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->grouptenant_id; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->rekananshipping_isactive; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->agreementtype_groupcollection; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->due; ?></td>  
    <td class="tg-aa48" nowrap><?php echo $val->AMOUNT; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->transaksi_type; ?></td>  
    <td class="tg-cy0b" nowrap><?php echo $val->Aging_type; ?></td>    
    <td class="tg-cy0b" nowrap ><?php echo $val->salesarea_id; ?></td>
    <td class="tg-cy0b" nowrap ><?php echo $val->COLL_IDR; ?></td>
    <td class="tg-cy0b" nowrap ><?php echo $val->All_id; ?></td>
    <td class="tg-cy0b" nowrap ><?php echo $val->All_date; ?></td>
    <td class="tg-cy0b" nowrap ><?php echo $val->OR_id; ?></td>
    <td class="tg-cy0b" nowrap ><?php echo $val->OR_type; ?></td>
    <td class="tg-cy0b" nowrap ><?php echo $val->OR_period; ?></td>
    <td class="tg-cy0b" nowrap ><?php echo $val->OR_date; ?></td>
    <td class="tg-cy0b" nowrap ><?php echo $val->tenant_type; ?></td>
    <td class="tg-cy0b" nowrap ><?php echo $val->p_status; ?></td>
    <td class="tg-cy0b" nowrap ><?php echo $val->c_status; ?></td>
    <td class="tg-cy0b" nowrap ><?php echo $val->Aging; ?></td>
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