<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-0rzf{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-ldj7{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:#000000;text-align:center;vertical-align:top}
.tg .tg-iuhm{font-size:10px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top;}
.tg .tg-73lx{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:#000000;vertical-align:top}
.tg .tg-ur0i{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;text-align:center;vertical-align:top}
.tg .tg-vbnk{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;vertical-align:top}
.tg .tg-li00{font-size:10px;font-family:"Arial Black", Gadget, sans-serif !important;;background-color:#ffffff;border-color:#000000;text-align:center;vertical-align:top}
.head1{font-size:14px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
.head2{font-size:12px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top}
</style>

<script src="<?php echo base_url('assets/plugins/jquery.min.js');?>" type="text/javascript"></script> 
<script src="<?php echo base_url('assets/plugins/exportexcel/xlsx.full.min.js');?>"></script> 

<button class="exportToExcel noExl">Export to EXCEL</button>
<br>
<br>

<span class="head1">
	<b><?php echo ($branch_info != 'kosong') ? $branch_info->region_namereport : ''; ?></b>
</span>
<br />
<br />
<span class="head2">
   <b><?=$report_title?> (Invoice)
   <br />   
   <?php echo ($branch_info != 'kosong') ? $branch_info->branch_name : $region_name; ?>
   <br />
   </b>
   <i><?php echo 'Report Date '.date('d-M-Y',strtotime($report_date)); ?></i>
</span>
<br />
<br />
<table id="Table1" class="tg" style="undefined;table-layout: fixed; width: 2100px">
<colgroup>
<col style="width: 5px">
<col style="width: 14px">
<col style="width: 12px">
<col style="width: 10px">
<col style="width: 30px">
<col style="width: 30px">
<col style="width: 15px">
<col style="width: 10px">
<col style="width: 10px">
<col style="width: 6px"> <!-- unit -->
<col style="width: 10px">
<col style="width: 10px">
<col style="width: 10px">
<col style="width: 10px">
<col style="width: 30px">
<col style="width: 10px">
<col style="width: 10px">
<col style="width: 10px">
</colgroup>
  <tr>
    <th class="tg-0rzf">NO</th>
    <th class="tg-ur0i">ID</th>
    <th class="tg-ur0i">AGREEMENT</th>
    <th class="tg-ur0i">GROUP/ NON GROUP</th>
    <th class="tg-ur0i">TENANTS NAME</th>
    <th class="tg-0rzf">TRADE NAME</th>
    <th class="tg-0rzf">KATEGORI</th>
    <th class="tg-0rzf">LANTAI</th>
    <th class="tg-0rzf">UNIT</th>
    <th class="tg-0rzf">NLA</th>
    <th class="tg-0rzf">RCD</th>
    <th class="tg-0rzf">EOT</th>
    <th class="tg-0rzf">PERIOD</th>
    <th class="tg-0rzf">POST</th>
    <th class="tg-0rzf">DESCR</th>
    <th class="tg-0rzf">TYPE</th>
    <th class="tg-0rzf">ACCOUNT</th>
    <th class="tg-0rzf">AMOUNT</th>
  </tr>
	<?php if ($tenant_history){ ?>  
	<?php 

   $type 		='';
	$Branch 		='';
	$i = 0;

	foreach ($tenant_history as $datas => $row) { 
		$i++;

		$_startperiod = new DateTime($row->agreement_startperiod);
		$startPeriod = $_startperiod->format('Y-m-d');
		$_endperiode = new DateTime($row->agreement_endperiod);
		$endPeriod = $_endperiode->format('Y-m-d');
		$postedDate = new DateTime($row->schedulepaymentdetil_posteddate);
		$postedDate = $postedDate->format('Y-m-d');

		?>
				 
		<tr>
			<td class="tg-iuhm" style="text-align: center;"><?=$i?></td>
			<td class="tg-iuhm"><?=$row->sp_id?></td>
			<td class="tg-iuhm"><?=$row->agreement_id?></td>
			<td class="tg-iuhm"><?=$row->thdgroup_name?></td>
			<td class="tg-iuhm"><?=$row->rekanan_name;?></td>
			<td class="tg-iuhm"><?=strtoupper($row->rekananshipping_name)?></td>
			<td class="tg-iuhm"><?=$row->thdcat_name?></td>
			<td class="tg-iuhm"><?=$row->lantai_name?></td>
			<td class="tg-iuhm"><?=strtoupper($row->agreementdetil_unit)?></td>
			<td class="tg-iuhm" style="text-align: right;"><?=number_format($row->agreementdetil_space, 2)?></td>
			<td class="tg-iuhm" style="text-align: center;"><?=$startPeriod?></td>
			<td class="tg-iuhm" style="text-align: center;"><?=$endPeriod?></td>
			<td class="tg-iuhm" style="text-align: center;"><?=$row->periode_id?></td>
			<td class="tg-iuhm" style="text-align: center;"><?=$postedDate?></td>
			<td class="tg-iuhm"><?=$row->schedulepaymentdetil_descr?></td>
			<td class="tg-iuhm"><?=$row->agreementtype_name?></td>
			<td class="tg-iuhm"><?=$row->acc_name?></td>
			<td class="tg-iuhm" style="text-align: right;"><?=number_format($row->schedulepaymentdetil_idr, 0)?></td>
		</tr> 
						
	<?php 	
	// $type = $row->unittype_name; //memasukkan variabel type dengan isi unit type name,diulang disini
	}?>
	<?php } else { ?>
	<div class="alert alert-success fade in ">
		<a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
		<strong>Info!</strong> Belum Ada Data!
	</div>
	<?php } ?> 
  
</table>

<script> 

 $(function() {

	$(".exportToExcel").click(function(e){ 

		ExportToExcel('xlsx', "THD Summary Permanent (invoice)_" + new Date().toISOString().split('T')[0]+'.xlsx');
	});

	function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('Table1');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "Sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('THD Summary Permanent (invoice).' + (type || 'xlsx')));
    }
					
});

</script> 