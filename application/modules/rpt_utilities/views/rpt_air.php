<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
</style>

<script src="<?php echo base_url('assets/plugins/jquery.min.js');?>" type="text/javascript"></script> 
<script src="<?php echo base_url()."assets/plugins/exportexcel/table2excel/" ?>jquery.table2excel.js"></script> 
<button class="exportToExcel noExl">Export to EXCEL</button> 
<br><br>

<table class="table2excel tg" style="undefined;table-layout: fixed; width: 2224px">
<colgroup>
<col style="width: 202px">
<col style="width: 202px">
<col style="width: 202px">
<col style="width: 202px">
<col style="width: 202px">
<col style="width: 202px">
<col style="width: 140px">
<col style="width: 92px">
<col style="width: 72px">
<col style="width: 83px">
<col style="width: 51px">
<col style="width: 83px">
<col style="width: 86px">
<col style="width: 51px">
<col style="width: 83px">
<col style="width: 86px">
<col style="width: 51px">
<col style="width: 83px">
<col style="width: 86px">
<col style="width: 51px">
<col style="width: 83px">
<col style="width: 84px">
<col style="width: 80px">
<col style="width: 104px">
<col style="width: 89px">
<col style="width: 71px">
<col style="width: 58px">
<col style="width: 53px">
<col style="width: 120px">
<col style="width: 88px">
<col style="width: 118px">
<col style="width: 83px">
<col style="width: 84px">
</colgroup>
  <tr>
	<th class="tg-0pky">Periode</th>
    <th class="tg-0pky">Biss.Unit</th>
    <th class="tg-0pky">Store</th>
    <th class="tg-0pky">Tenant</th>
    <th class="tg-0pky">Brand</th>
    <th class="tg-0pky">Descripsi</th>
    <th class="tg-0pky">Utilities ID</th>
    <th class="tg-0pky">N. Awal</th>
    <th class="tg-0pky">N. Akhir</th>
    <th class="tg-0pky">Pemakaian</th>
    <th class="tg-0pky">Blok 1</th>
    <th class="tg-0pky">Blok 1-Tarif</th>
    <th class="tg-0pky">Blok 1-Total</th>
    <th class="tg-0pky">Blok 2</th>
    <th class="tg-0pky">Blok 2-Tarif</th>
    <th class="tg-0pky">Blok 2-Total</th>
    <th class="tg-0pky">Blok 3</th>
    <th class="tg-0pky">Blok 3-Tarif</th>
    <th class="tg-0pky">Blok 3-Total</th>
    <th class="tg-0pky">Blok 4</th>
    <th class="tg-0pky">Blok 4-Tarif</th>
    <th class="tg-0pky">Blok 4 Total</th>
    <th class="tg-0pky">Total Pakai</th>
    <th class="tg-0pky">Abonem./Adm.</th>
    <th class="tg-0pky">PH Air Kotor</th>
    <th class="tg-0pky">PH Meter</th>
    <th class="tg-0pky">Materai</th>
    <th class="tg-0pky">Denda</th>
    <th class="tg-0pky">Subtotal</th>
    <th class="tg-0pky">Administrasi</th>
    <th class="tg-0pky">Total</th>
    <th class="tg-0pky">Tax (%)</th>
    <th class="tg-0pky">Status</th>
  </tr>
  <?php if($result <> 'kosong'): 
	foreach($result as $row) :
  ?>
  <tr>
    <td class="tg-0pky"><?php echo substr($row->utilitiesairgas_date,0,7); ?></td>
    <td class="tg-0pky"><?php echo $row->region_name; ?></td>
    <td class="tg-0pky"><?php echo $row->BRANCH_NAME; ?></td>
    <td class="tg-0pky"><?php echo $row->rekanan_name; ?></td>
    <td class="tg-0pky"><?php echo $row->rekananshipping_name; ?></td>
    <td class="tg-0pky"><?php echo $row->utilitiesairgas_descr; ?></td>
    <td class="tg-0pky"><?php echo $row->utilitiesairgas_id; ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_standawal,4); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_standakhir,4); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_pemakaian,4); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_spec1meter); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_spec1tarif); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_spec1amount); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_spec2meter); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_spec2tarif); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_spec2amount); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_spec3meter); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_spec3tarif); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_spec3amount); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_spec4meter); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_spec4tarif); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_spec4amount); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_specamounttotal); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_pemeliharaan); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_phairkotor); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_phmeter); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_materai); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_denda); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_subtotal); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_adm); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_total); ?></td>
    <td class="tg-0pky"><?php echo number_format($row->utilitiesairgasdetil_tax); ?></td>
    <td class="tg-0pky"><?php echo ($row->utilitiesairgasdetil_isposted == 1)?'POSTED':'-' ;?></td>
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
						name: "Rpt_Air",
						filename: "Rpt_Air_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
						preserveColors: false // set to true if you want background colors and font colors preserved
					}); 
				});
				
			});
</script> 