<title> <?php echo $title; ?> </title>

<script src="<?php echo base_url('assets/plugins/jquery.min.js');?>" type="text/javascript"></script> 
<script src="<?php echo base_url()."assets/plugins/exportexcel/table2excel/" ?>jquery.table2excel.js"></script>  

<div align="left" id="buttonExport"></div><br/>


 <style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color: transparent;}
.tg td{font-family:Arial, sans-serif;font-size:12px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:13px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-lboi{border-color:inherit;text-align:left;vertical-align:middle}
.tg .tg-efol{font-weight:bold;background-color:#c0c0c0;border-color:inherit;text-align:center;vertical-align:middle;border-color: transparent;}
.tg .tg-lqy6{background-color:#ecf4ff;text-align:right;vertical-align:top;border-color: transparent;}
.tg .tg-pwmh{font-weight:bold;background-color:#c0c0c0;border-color:inherit;text-align:left;vertical-align:middle;border-color: transparent;}
.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top;border-color: transparent;}
.tg .tg-0pkyIDR{border-color:inherit;text-align:right;vertical-align:top;border-color: transparent;}
.tg .tg-0lax{background-color:#ecf4ff;text-align:left;vertical-align:top;border-color: transparent;}
</style>

<button class="exportToExcel">Export to EXCEL</button>

<table class="tg table2excel" style="undefined;table-layout: fixed; width: auto;" >
<colgroup>
<col style="width: 120px">
<col style="width: 120px">
<col style="width: 120px">
<col style="width: 200px">
<col style="width: 170px">
<col style="width: 200px">
<col style="width: 130px">
<col style="width: 92px">
<col style="width: 127px">
<col style="width: 116px">
<col style="width: 117px">
</colgroup>
  <tr>
    <th class="tg-efol" colspan="8">Income</th>
    <th class="tg-pwmh">Last Month</th>
    <th class="tg-pwmh">This Month</th>
    <th class="tg-pwmh">Diff</th>
  </tr>
   <?php 
  $debit = 0;
  $credit = 0;
  $balance = 0; 
  $h1_cek = '';
  $h1 = '';
  $h2 = '';
  $h2_cek = '';
  $h3 = ''; 
  $h3_cek = ''; 
  
  $idr_last_h3 = 0;
  $idr_this_h3 = 0;
  $idr_diff_h3 = 0;
  
  $idr_last_h2 = 0;
  $idr_this_h2 = 0;
  $idr_diff_h2 = 0;
  
  $idr_last_h1 = 0;
  $idr_this_h1 = 0;
  $idr_diff_h1 = 0;
  
	if(($result != 'kosong')) :
		foreach($result as $data => $row) : 
		 
		$h1 = $row->h1; 
		 
			if($h1_cek != $h1) : 
				$h1 = $row->h1; 
			else :
				$h1 = '';
			endif;
		 
		$h2 = $row->h2; 
		
			if($h2_cek != $h2) : 
				$h2 = $row->h2; 
			else :
				$h2 = '';
			endif;
		 
		$h3 = $row->h3; 
		
			if($h3_cek != $h3) : 
				$h3 = $row->h3; 
			else :
				$h3 = '';
			endif;
		 
		$idr_last_h3 = $idr_last_h3 + $row->IDR_LALU;  
		$idr_this_h3 = $idr_this_h3 + $row->IDR;  
		$idr_diff_h3 = $idr_diff_h3 + $row->DIFF_IDR;  
		 
		 
  ?> 
   <tr> 
	<td class="tg-lboi"></td> 
    <td class="tg-lboi"></td>
    <td class="tg-lboi"></td>
    <td class="tg-lboi"></td>
    <td class="tg-lboi"></td>
    <td class="tg-lboi"></td>
    <td class="tg-lboi"></td>
    <td class="tg-lboi"></td>
    <td class="tg-lboi"></td>
    <td class="tg-lboi"></td>
    <td class="tg-lboi"></td>
  </tr>
  <?php
	if($h1 != '') :
  ?> 
  <tr> 
	<td class="tg-lboi" colspan="11" style="background-color:#9b9b9b;"><strong> <?php echo $h1; ?> </strong></td> 
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
  </tr> 
  <?php
  endif;
	if($h2 != '') :
  ?>
  <tr>
    <td class="tg-lboi" style="background-color:#c0c0c0;"></td>
    <td class="tg-lboi" colspan="10" style="background-color:#c0c0c0;"> <strong > <?php echo $h2; ?> </strong> </td> 
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
    <td class="tg-lboi" style="display: none;"></td>
  </tr> 
   <?php
  endif;
	if($h3 != '') :
  ?>
  <tr>
    <td class="tg-0pky" style="background-color:#9b9b9b;"></td>
    <td class="tg-0pky" style="background-color:#9b9b9b;"></td>
    <td class="tg-0pky" colspan="9" style="background-color:#9b9b9b;"> <strong> <?php echo $h3; ?> </strong> </td>
    <td class="tg-0pky" style="display: none;"></td>
    <td class="tg-0pky" style="display: none;"></td>
    <td class="tg-0pky" style="display: none;"></td>
    <td class="tg-0pky" style="display: none;"></td>
    <td class="tg-0pky" style="display: none;"></td>
    <td class="tg-0pky" style="display: none;"></td>
    <td class="tg-0pky" style="display: none;"></td>
    <td class="tg-0pky" style="display: none;"></td>
  </tr>
   <?php
  endif; 
  ?>
  <tr> 
    <td class="tg-0pky"></td> 
    <td class="tg-0pky"></td> 
    <td class="tg-0pky"></td> 
    <td class="tg-0pky" ><?php echo $row->acc_id.' '.$row->acc_name; ?></td>
    <td class="tg-0pky" ><?php echo $row->rekanan_name; ?></td> 
    <td class="tg-0pky"><?php echo $row->rekananshipping_name; ?></td>
    <td class="tg-0pky"><?php echo $row->debtor; ?></td>
    <td class="tg-0pky"><?php echo $row->branch_idlok; ?></td>
    <td class="tg-0pkyIDR"><?php echo number_format($row->IDR_LALU); ?></td>
    <td class="tg-0pkyIDR"><?php echo number_format($row->IDR); ?></td>
    <td class="tg-0pkyIDR"><?php echo number_format($row->DIFF_IDR); ?></td>
  </tr>
  <?php
		if(@$result[$data+1]->h3 != $row->h3 ): 
	?> 
  <tr>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-lqy6" colspan="6"><strong> Jumlah <?php echo $row->h3; ?> </strong> </td>
    <td class="tg-0pkyIDR" style="background-color:#ecf4ff;"> <strong> <?php echo number_format($idr_last_h3); ?> </strong> </td>
    <td class="tg-0pkyIDR" style="background-color:#ecf4ff;"> <strong> <?php echo number_format($idr_this_h3); ?> </strong> </td>
    <td class="tg-0pkyIDR" style="background-color:#ecf4ff;"> <strong> <?php echo number_format($idr_diff_h3); ?> </strong> </td>
  </tr>
	<?php  
		$idr_last_h3 = 0; 
		$idr_this_h3 = 0;
		$idr_diff_h3 = 0;
		endif;   
		
		 
	?>  
	  
	<?php 	
	    
	 $h1_cek =  $row->h1;
	 $h2_cek =  $row->h2;
	 $h3_cek =  $row->h3;
		
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
						name: "Rpt_Income",
						filename: "Rpt_Income_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
						preserveColors: false // set to true if you want background colors and font colors preserved
					}); 
				});
				
			});
</script> 