<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-g7sd{font-weight:bold;border-color:inherit;text-align:left;vertical-align:middle}
.tg .tg-fymr{font-weight:bold;border-color:inherit;text-align:left;vertical-align:top}
.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
.tg .tg-dvpl{border-color:inherit;text-align:right;vertical-align:top}
</style> 

<script src="<?php echo base_url('assets/plugins/jquery.min.js');?>" type="text/javascript"></script> 
<script src="<?php echo base_url()."assets/plugins/exportexcel/table2excel/" ?>jquery.table2excel.js"></script> 
<button class="exportToExcel noExl">Export to EXCEL</button> 
<br><br>

<table class="table2excel tg" style="undefined;table-layout: fixed; width: 2569px">
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
<col style="width: 105px">
<col style="width: 99px">
<col style="width: 95px">
<col style="width: 93px">
<col style="width: 69px">
<col style="width: 105px">
<col style="width: 109px">
<col style="width: 93px">
<col style="width: 99px">
<col style="width: 81px">
<col style="width: 76px">
<col style="width: 114px">
<col style="width: 109px">
<col style="width: 57px">
<col style="width: 57px">
<col style="width: 119px">
<col style="width: 101px">
<col style="width: 101px">
<col style="width: 101px">
<col style="width: 101px">
<col style="width: 101px">
<col style="width: 101px">
<col style="width: 101px">
<col style="width: 101px">
<col style="width: 101px">
<col style="width: 101px">
<col style="width: 70px">
</colgroup>
  <tr>
    <th class="tg-g7sd">Periode</th>
    <th class="tg-g7sd">Biss.Unit</th>
    <th class="tg-g7sd">Store</th>
    <th class="tg-g7sd">Tenant</th>
    <th class="tg-g7sd">Brand</th>
    <th class="tg-g7sd">Descr.</th>
    <th class="tg-fymr">Utilities ID</th>
    <th class="tg-fymr">Ampere</th>
    <th class="tg-fymr">Phase</th>
    <th class="tg-fymr">Faktor Kali</th>
    <th class="tg-fymr">Beban KVA</th>
    <th class="tg-fymr">BPJU (%)</th>
    <th class="tg-fymr">ADM (Rp)</th>
    <th class="tg-fymr">ADM (%)</th>
    <th class="tg-fymr">Awal LWBP</th>
    <th class="tg-fymr">Akhir LWBP</th>
    <th class="tg-fymr">Awal WBP</th>
    <th class="tg-fymr">Akhir WBP</th>
    <th class="tg-fymr">N. Awal</th>
    <th class="tg-fymr">N. Akhir</th>
    <th class="tg-fymr">Selisih LWBP</th>
    <th class="tg-fymr">Selisih WBP</th>
    <th class="tg-fymr">Selisih</th>
    <th class="tg-fymr">Min.KWH</th>
    <th class="tg-fymr">Pem. LWBP</th>
    <th class="tg-fymr">Pem. WBP</th>
    <th class="tg-fymr">Tarif LWBP</th>
    <th class="tg-fymr">Tarif WBP</th>
    <th class="tg-fymr">Biaya</th>
    <th class="tg-fymr">BPJU</th>
    <th class="tg-fymr">Tagihan</th>
    <th class="tg-fymr">Adm.</th>
    <th class="tg-fymr">Denda</th>
    <th class="tg-fymr">Total</th>
    <th class="tg-fymr">Tax (%)</th>
    <th class="tg-fymr">Status</th>
  </tr>
  <?php if($result <> 'kosong'): 
	foreach($result as $row) :
  ?>
  <tr>
	<td class="tg-0pky"><?php echo substr($row->utilitiesLISTRIK_date,0,7); ?></td>
    <td class="tg-0pky"><?php echo $row->region_name; ?></td>
    <td class="tg-0pky"><?php echo $row->BRANCH_NAME; ?></td>
    <td class="tg-0pky"><?php echo $row->rekanan_name; ?></td>
    <td class="tg-0pky"><?php echo $row->rekananshipping_name; ?></td>
    <td class="tg-0pky"><?php echo $row->utilitiesLISTRIK_descr; ?></td>
    <td class="tg-0pky"><?php echo $row->utilitieslistrik_id; ?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_amp); ?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_phase); ?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_faktor);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_bebankva);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_bpjumaster);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_admamountmaster);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_admpercentmaster);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_standawallwbp,4);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_standakhirlwbp,4);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_standawalwbp,4);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_standakhirwbp,4);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_standawal,4);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_akhir,4);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_selisihlwbp,4);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_selisihwbp,4);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_selisih,4);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_minkwh,4);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_pemakaianlwbp);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_pemakaianwbp);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_tariflwbp);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_tarifwbp);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_biaya);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_bpju);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_tagihan);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_administrasi);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_denda);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_jumlah);?></td>
    <td class="tg-dvpl"><?php echo number_format($row->utilitieslistrikdetil_tax);?></td>
    <td class="tg-0pky"><?php echo ($row->utilitieslistrikdetil_isposted == 1)?'POSTED':'-' ;?></td>
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
						name: "Rpt_listrik",
						filename: "Rpt_Listrik_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
						preserveColors: false // set to true if you want background colors and font colors preserved
					}); 
				});
				
			});
</script> 