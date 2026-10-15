<title> <?php echo $title; ?> </title>

<script src="<?php echo base_url('assets/plugins/jquery.min.js');?>" type="text/javascript"></script> 
<script src="<?php echo base_url()."assets/plugins/exportexcel/table2excel/" ?>jquery.table2excel.js"></script>  

<button class="exportToExcel">Export to EXCEL</button>



 <style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  overflow:hidden;padding:10px 5px;word-break:normal;}
.tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
.tg .tg-lqy6{text-align:right;vertical-align:top;font-weight:bold;}
.tg .tg-0lax{text-align:left;vertical-align:top;font-weight:bold;}
.tg .tg-0lax1{text-align:left;vertical-align:top;}
</style>
<table class="tg table2excel" style="undefined;table-layout: fixed; width: 1906px">
<colgroup>
<col style="width: 29px">
<col style="width: 284px">
<col style="width: 210px">
<col style="width: 173px">
<col style="width: 207px">
<col style="width: 300px">
<col style="width: 264px">
<col style="width: 161px">
<col style="width: 158px">
<col style="width: 149px">
<col style="width: 148px">
<col style="width: 146px">
</colgroup>
<thead>
  <tr>
    <th class="tg-0lax">No</th>
    <th class="tg-0lax">NAMA PERUSAHAAN</th>
    <th class="tg-0lax">NPWP</th>
    <th class="tg-0lax">NOMOR SSP</th>
    <th class="tg-0lax">NOMOR FAKTUR PAJAK</th>
    <th class="tg-0lax">STORE</th>
    <th class="tg-0lax">JUMLAH BRUTO NILAI SEWA</th>
    <th class="tg-0lax">SSP Yang Di Bayar</th>
    <th class="tg-0lax">TGL FAKTUR PAJAK</th>
    <th class="tg-0lax">TGL SSP</th>
    <th class="tg-0lax">TGL KE A/R DEP</th>
    <th class="tg-0lax">IPRO DATE</th>
  </tr>
</thead>
<tbody>
   <?php 
	$angka = 0; 
	$no = 0;
	if(($result != 'kosong')) :
		foreach($result as $data => $row) :  
	$no++;
	$angka += $row->jumlah_bruto;	
  ?> 
  <tr>
    <td class="tg-0lax1"><?php echo $no; ?></td>
    <td class="tg-0lax1"><?php echo $row->rekanan_name; ?></td>
    <td class="tg-0lax1"><?php echo $row->NPWP; ?></td>
    <td class="tg-0lax1"><?php echo $row->Bukti_Potong; ?></td>
    <td class="tg-0lax1"><?php echo $row->faktur_id; ?></td>
    <td class="tg-0lax1"><?php echo $row->branch_name; ?></td>
    <td class="tg-0lax1"><?php echo  number_format($row->jumlah_bruto); ?></td>
    <td class="tg-0lax1"><?php echo  number_format($row->pph_dipotong); ?></td>
    <td class="tg-0lax1"><?php echo isset($row->tgl_faktur) == '' ? '#' : date('d-m-Y',strtotime($row->tgl_faktur)); ?></td>
    <td class="tg-0lax1"><?php echo isset($row->tgl_potong) == '' ? '#' : date('d-m-Y',strtotime($row->tgl_potong)); ?></td>
    <td class="tg-0lax1"><?php echo isset($row->tgl_AR) == '' ? '#' : date('d-m-Y',strtotime($row->tgl_AR)); ?></td>
    <td class="tg-0lax1"><?php echo isset($row->tgl_tb) == '' ? '#' : date('d-m-Y',strtotime($row->tgl_tb)); ?></td>
  </tr>
  <?php
		endforeach;
	endif; 
  ?>
  <tr>
    <td class="tg-lqy6" colspan="6">TOTAL</td>
    <td class="tg-0lax"><?php echo number_format($angka); ?></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
  </tr>
</tbody>
</table>
  


<script src="<?php echo base_url()."assets/plugins/exportexcel/" ?>FileSaver.js"></script>

<script> 
 $(function() {
				$(".exportToExcel").click(function(e){ 
					$(".table2excel").table2excel({
						exclude: ".noExl", 
						name: "WAPU",
						filename: "Rpt_WAPU_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
						preserveColors: false // set to true if you want background colors and font colors preserved
					}); 
				});
				
			});
</script> 