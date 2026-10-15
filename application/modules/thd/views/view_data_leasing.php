<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
.tg .tg-0rzf{font-size:9px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:inherit;text-align:center;vertical-align:top}
.tg .tg-ldj7{font-size:8px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:#000000;text-align:center;vertical-align:top}
.tg .tg-iuhm{font-size:8px;font-family:Arial, Helvetica, sans-serif !important;;vertical-align:top;}
.tg .tg-73lx{font-size:8px;font-family:"Arial Black", Gadget, sans-serif !important;;border-color:#000000;vertical-align:top}
.tg .tg-ur0i{font-size:8px;font-family:"Arial Black", Gadget, sans-serif !important;;text-align:center;vertical-align:top}
.tg .tg-vbnk{font-size:8px;font-family:"Arial Black", Gadget, sans-serif !important;;vertical-align:top}
.tg .tg-li00{font-size:8px;font-family:"Arial Black", Gadget, sans-serif !important;;background-color:#ffffff;border-color:#000000;text-align:center;vertical-align:top}
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
   <b><?=$report_title?> (Baserent)
   <br />   
   <?php echo ($branch_info != 'kosong') ? $branch_info->branch_name : $region_name; ?>
   <br />
   </b>
   <i><?php echo 'Report Date '.date('d-M-Y',strtotime($report_date)); ?></i>
</span>
<br />
<br />
<table id="Table1" class="table2excel tg" style="undefined;table-layout: fixed; width: 2100px">
<colgroup>
	<col style="width: 7px">
	<col style="width: 15px">
	<col style="width: 10px">

	<col style="width: 15px">
	<col style="width: 10px">
	<col style="width: 30px">
	<col style="width: 30px">
	<col style="width: 25px">
	<col style="width: 10px">
	<col style="width: 10px">
	<col style="width: 10px">
	<col style="width: 10px"> <!-- RCD -->
	<col style="width: 10px"> 
	<col style="width: 10px">
	<col style="width: 10px">

	<col style="width: 12px">

	<col style="width: 10px">
	<col style="width: 10px">
	<col style="width: 10px">

	<!-- Rental -->
	<col style="width: 10px">
	<col style="width: 10px">
	<col style="width: 10px">

	<!-- Service Charge -->
	<col style="width: 10px">
	<col style="width: 10px">
	<col style="width: 10px">

	<!-- Promotion Levy -->
	<col style="width: 10px">
	<col style="width: 10px">
	<col style="width: 10px">

	<col style="width: 10px">
	<col style="width: 5px">
	<col style="width: 10px">

	<col style="width: 10px">
</colgroup>

  <tr>
    <th class="tg-0rzf">NO</th>
    <th class="tg-ur0i">ID</th>
    <th class="tg-ur0i">STATUS</th>

    <th class="tg-ur0i">TYPE</th>
    <th class="tg-ur0i">GROUP/ NON GROUP</th>

    <th class="tg-ur0i">TENANT'S NAME</th>
    <th class="tg-0rzf">TRADE NAME</th>
    <th class="tg-0rzf">KATEGORI</th>
    <th class="tg-0rzf">LANTAI</th>
    <th class="tg-0rzf">UNIT</th>
    <th class="tg-0rzf">NLA</th>
    <th class="tg-0rzf">RCD</th>
    <th class="tg-0rzf">EOT</th>
    <th class="tg-0rzf">DAY</th>
    <th class="tg-0rzf">TENURE</th>
    <th class="tg-0rzf">COMMERCIAL TERM</th>

    <th class="tg-0rzf">BASERENT</th>
    <th class="tg-0rzf">SC</th>
    <th class="tg-0rzf">PL</th>

    <th class="tg-0rzf">BASERENT RP</th>
    <th class="tg-0rzf">DISC RENT</th>
    <th class="tg-0rzf">TOTAL RENT</th>

    <th class="tg-0rzf">SC RP</th>
    <th class="tg-0rzf">DISC RP</th>
    <th class="tg-0rzf">TOTAL SC</th>

    <th class="tg-0rzf">PL RP</th>	
    <th class="tg-0rzf">DISC PL</th>	
    <th class="tg-0rzf">TOTAL PL</th>	

    <th class="tg-0rzf">SALES REV SHARE</th>
    <th class="tg-0rzf">(%)</th>
    <th class="tg-0rzf">REV SHARE</th>

    <th class="tg-0rzf">ARR</th>
  </tr>
	<?php if ($tenant_history){ ?>  
	<?php 
	//inisiasi variabel bel sedep
	$type 		='';
	$i = 0;

	foreach ($tenant_history as $datas => $row) { 
		$i++;

		//$agreement_startperiod = date("d/m/Y", strtotime($row->agreement_startperiod));
		$_startperiod = new DateTime($row->agreement_startperiod);
		$agreement_startperiod = $_startperiod->format('Y-m-d');
		$_endperiode = new DateTime($row->agreement_endperiod);
		$agreement_endperiod = $_endperiode->format('Y-m-d');

		$today = new DateTime();

		$intv = date_diff($_endperiode, $today);
		$exDate = $intv->format('%r%a');		

      	$amount_rent = ( $row->amount_ps > 0 ) ? $row->amount_ps : $row->amount_in;

      	$total_rent = ($amount_rent - $row->discount_in);
		$total_sc = ($row->amount_sc - $row->discount_sc);
		$total_pl = ($row->amount_pl - $row->discount_pl);

		$arrValue = $row->agreementdetil_space > 0 ? $total_rent/$row->agreementdetil_space : 0;

		if ($report_type == 'terminate') {         
			$status = 'Terminated';
		} else {
			$status = $row->thdstatus_name;
		}

		?>
				 
		<tr>
			<td class="tg-iuhm" style="text-align: center;"><?=$i?></td>
			<td class="tg-iuhm"><?=$row->agreement_id?></td>
			<td class="tg-iuhm" style="text-align: center;"><?=$status?></td>
			<td class="tg-iuhm"><?=$row->thdtype_name?></td>
			<td class="tg-iuhm"><?=$row->thdgroup_name?></td>
			<td class="tg-iuhm"><?=$row->rekanan_name;?></td>
			<td class="tg-iuhm"><?=strtoupper($row->rekananshipping_name)?></td>
			<td class="tg-iuhm"><?=$row->thdcat_name?></td>
			<td class="tg-iuhm"><?=$row->lantai_name?></td>
			<td class="tg-iuhm"><?=strtoupper($row->agreementdetil_unit)?></td>
			<td class="tg-iuhm" style="text-align: right;"><?=number_format($row->agreementdetil_space, 2)?></td>
			<td class="tg-iuhm" style="text-align: center;"><?=$agreement_startperiod?></td>
			<td class="tg-iuhm" style="text-align: center;"><?=$agreement_endperiod?></td>
			<td class="tg-iuhm" style="text-align: center;"><?=$exDate?></td>
			<td class="tg-iuhm" style="text-align: center;"><?=$row->agreement_term?></td>
			<td class="tg-iuhm" style="text-align: center;"><?=$row->Comm_Terms?></td>
			<td class="tg-iuhm" style="text-align: right;"><?=number_format($row->in_baserent,0)?></td>
			<td class="tg-iuhm" style="text-align: right;"><?=number_format($row->sc_baserent,0)?></td>
			<td class="tg-iuhm" style="text-align: right;"><?=number_format($row->pl_baserent,0)?></td>

			<td class="tg-iuhm" style="text-align: right;"><?=number_format($amount_rent, 0)?></td>
			<td class="tg-iuhm" style="text-align: right;"><?=number_format($row->discount_in, 0)?></td>
			<td class="tg-iuhm" style="text-align: right;"><?=number_format($total_rent, 0)?></td>

			<td class="tg-iuhm" style="text-align: right;"><?=number_format($row->amount_sc, 0)?></td>
			<td class="tg-iuhm" style="text-align: right;"><?=number_format($row->discount_sc, 0)?></td>
			<td class="tg-iuhm" style="text-align: right;"><?=number_format($total_sc, 0)?></td>

			<td class="tg-iuhm" style="text-align: right;"><?=number_format($row->amount_pl, 0)?></td>
			<td class="tg-iuhm" style="text-align: right;"><?=number_format($row->discount_pl, 0)?></td>
			<td class="tg-iuhm" style="text-align: right;"><?=number_format($total_pl, 0)?></td>

			<td class="tg-iuhm" style="text-align: right;"><?=number_format($row->ps_sales, 0)?></td>
			<td class="tg-iuhm" style="text-align: right;"><?=number_format($row->ps_percent, 0)?></td>
			<td class="tg-iuhm" style="text-align: right;"><?=number_format($row->amount_ps, 0)?></td>	

			<td class="tg-iuhm" style="text-align: right;"><?=number_format($arrValue, 0)?></td>			
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

		ExportToExcel('xlsx', "THD Summary Permanent_" + new Date().toISOString().split('T')[0]+'.xlsx');
	});

	function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('Table1');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "Sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('THD Summary Permanent.' + (type || 'xlsx')));
    }

});

</script> 