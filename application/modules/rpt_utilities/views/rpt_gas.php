<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-cly1{text-align:left;vertical-align:middle}
</style>
<script src="<?php echo base_url('assets/plugins/jquery.min.js');?>" type="text/javascript"></script> 
<script src="<?php echo base_url()."assets/plugins/exportexcel/table2excel/" ?>jquery.table2excel.js"></script> 
<button class="exportToExcel noExl">Export to EXCEL</button> 
<br><br>
<table class="table2excel tg" style="undefined;table-layout: fixed; width: 2051px">
<colgroup>
<col style="width: 80px">
<col style="width: 220px">
<col style="width: 220px">
<col style="width: 280px">
<col style="width: 220px">
<col style="width: 220px">
<col style="width: 141px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 83px">
</colgroup>
  <tr>
    <th class="tg-cly1">Periode</th>
    <th class="tg-cly1">Biss. Unit</th>
    <th class="tg-cly1">Store</th>
    <th class="tg-cly1">Tenant</th>
    <th class="tg-cly1">Brand</th>
    <th class="tg-cly1">Descr.</th>
    <th class="tg-cly1">Utilities ID</th>
    <th class="tg-cly1">M. Faktor</th>
    <th class="tg-cly1">Pressure</th>
    <th class="tg-cly1">Conv. Faktor</th>
    <th class="tg-cly1">N. Awal</th>
    <th class="tg-cly1">N. Akhir</th>
    <th class="tg-cly1">Pemakaian</th>
    <th class="tg-cly1">Massa LPG</th>
    <th class="tg-cly1">Tarif</th>
    <th class="tg-cly1">Jumlah</th>
    <th class="tg-cly1">Subtotal</th>
    <th class="tg-cly1">Administrasi</th>
    <th class="tg-cly1">PH Meter</th>
    <th class="tg-cly1">Materai</th>
    <th class="tg-cly1">Denda</th>
    <th class="tg-cly1">Total</th>
    <th class="tg-cly1">Tax (%)</th>
    <th class="tg-cly1">Status</th>
  </tr>
   <?php if($result <> 'kosong'): 
	foreach($result as $row) :
   ?>
  <tr>
    <td class="tg-cly1"><?php echo substr($row->utilitiesairgas_date,0,7); ?></td>
    <td class="tg-cly1"><?php echo $row->region_name; ?></td>
    <td class="tg-cly1"><?php echo $row->BRANCH_NAME; ?></td>
    <td class="tg-cly1"><?php echo $row->rekanan_name; ?></td>
    <td class="tg-cly1"><?php echo $row->rekananshipping_name; ?></td>
    <td class="tg-cly1"><?php echo $row->utilitiesairgas_descr; ?></td>
    <td class="tg-cly1"><?php echo $row->utilitiesairgas_id; ?></td>
    <td class="tg-cly1"><?php echo number_format($row->utilitiesairgasdetil_multiplefactor); ?></td>
    <td class="tg-cly1"><?php echo number_format($row->utilitiesairgasdetil_pressure); ?></td>
    <td class="tg-cly1"><?php echo number_format($row->utilitiesairgasdetil_conversionfactor); ?></td>
    <td class="tg-cly1"><?php echo number_format($row->utilitiesairgasdetil_standawal,4); ?></td>
    <td class="tg-cly1"><?php echo number_format($row->utilitiesairgasdetil_standakhir,4); ?></td>
    <td class="tg-cly1"><?php echo number_format($row->utilitiesairgasdetil_pemakaian,4); ?></td>
    <td class="tg-cly1"><?php echo number_format($row->utilitiesairgasdetil_spec1meter,4); ?></td>
    <td class="tg-cly1"><?php echo number_format($row->utilitiesairgasdetil_spec1tarif); ?></td>
    <td class="tg-cly1"><?php echo number_format($row->utilitiesairgasdetil_spec1amount); ?></td>
    <td class="tg-cly1"><?php echo number_format($row->utilitiesairgasdetil_specamounttotal); ?></td>
    <td class="tg-cly1"><?php echo number_format($row->utilitiesairgasdetil_adm); ?></td>
    <td class="tg-cly1"><?php echo number_format($row->utilitiesairgasdetil_phmeter); ?></td>
    <td class="tg-cly1"><?php echo number_format($row->utilitiesairgasdetil_materai); ?></td>
    <td class="tg-cly1"><?php echo number_format($row->utilitiesairgasdetil_denda); ?></td>
    <td class="tg-cly1"><?php echo number_format($row->utilitiesairgasdetil_total); ?></td>
    <td class="tg-cly1"><?php echo number_format($row->utilitiesairgasdetil_tax); ?></td>
    <td class="tg-cly1"><?php echo ($row->utilitiesairgasdetil_isposted == 1)?'POSTED':'-' ;?></td>
  </tr>
   <?php
	endforeach;
	endif;
  ?>
</table>



<script src="<?php echo base_url()."assets/plugins/exportexcel/" ?>FileSaver.js"></script> 
<script> 
 $(function() {
				$(".exportToExcel").click(function(e){ 
					$(".table2excel").table2excel({
						exclude: ".noExl", 
						name: "Rpt_Gas",
						filename: "Rpt_Gas_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
						preserveColors: false // set to true if you want background colors and font colors preserved
					}); 
				});
				
			});
</script> 