<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta content="en-us" http-equiv="Content-Language" />

<title>Summary Jurnal Detil</title>

<style>


      page[size=A4] {
	      background:white;
	      width:29.7cm;
	      height:21cm;
	      display:block;
	      padding: 0 auto;	
	      margin: 1cm 1cm 0.5cm 0.3cm;
	      box-shadow:0 0 0.5cm rgba(0,0,0,0.5);
		  letter-spacing: 3px;
      }

      @media print {
	      body, page[size=A4] {
	      padding: 0 auto;	
	      margin: 1cm 1cm 0.5cm 0.3cm;
	      box-shadow:0;
		  letter-spacing: 3px;
		  
	      }
      }

	@media screen {
	/*
		body{
		  letter-spacing: 3px;
		}
*/
	}
	table{
		border-collapse : collapse;
		border-width: 2px;
	}
	
/*	
  	td {
		font-family:Lucida Console;
	  	font-size:12.5px;
  	}
*/
      
.header{
	
	background-color: #c0c0c0;
	height:35px;

	}  
.header1{
	
	background-color: #e5e7e9;
	height:20px;
	} 
.currency{
	
	text-align : right;
	}      
.amount{
	width:90px;
}

.coldate{
	width:60px;
}
.coljid{
	width:60px;
}
.colsource{
	width:60px;
}
.colcoa{
	width:50px;
}
.auto-style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: x-small;
}
      
      
.auto-style2 {
	border-style: solid;
	border-width: 1px;
}
      
      
</style>
</head>

<body>

<h4 style="height: 20px"><?php echo $report; ?></h4>
<?php if($region =='') { ?>
<h5 style="height: 16px">Branch : <?php echo $branch; ?></h5>
<?php }else{ ?>
<h5 style="height: 16px">Region : <?php echo $region; ?></h5>
<?php }?>
<h5 style="height: 16px">Date : <?php echo date_format(date_create($endDate),'d-m-Y'); ?></h5>

<table style="width: 100%" class="auto-style1">
	<tr>
		<td colspan="5" style="height: 32px" class="auto-style2 header"><strong>Account</strong></td>
		<td style="height: 32px" class="auto-style2 header amount"><strong>Saldo Awal</strong></td>
		<td style="height: 32px" class="auto-style2 header amount"><strong>Debet</strong></td>
		<td style="height: 32px" class="auto-style2 header amount"><strong>Kredit</strong></td>
		<td style="height: 32px" class="auto-style2 header amount"><strong>Mutasi</strong></td>
		<td style="height: 32px" class="auto-style2 header amount"><strong>Saldo Akhir</strong></td>
		<td style="height: 32px" class="auto-style2 header"><strong>Account</strong></td>
		<td style="height: 32px" class="auto-style2 header"><strong>Region</strong></td>
		<td style="height: 32px" class="auto-style2 header"><strong>Branch</strong></td>
		<td style="height: 32px" class="auto-style2 header"><strong>Struktur Unit</strong></td>
		<td style="height: 32px" class="auto-style2 header"><strong>Rekanan</strong></td>
	</tr>
    
    <?php
    $rownumber = 4;
    //$rownum = 4;
    $i = 0;
    $account_current= "";

    $saldoawal_sumall= 0;
    $debet_sumall= 0;
    $kredit_sumall= 0;
    $mutasi_sumall= 0;
    $saldoakhir_sumall= 0;

    $saldoawal_sum= 0;
    $debet_sum= 0;
    $kredit_sum= 0;
    $mutasi_sum= 0;
    $saldoakhir_sum= 0;

    $saldoawal= 0;
    $debet= 0;
    $kredit= 0;
    $mutasi= 0;
    $saldoakhir= 0;
    
    foreach($summary as $row){
        $acc_id = $row->acc_id;
        $acc_name = $row->acc_name;
        $jurnal_id = $row->jurnal_id;
        $jurnal_source = $row->jurnal_source;
        $jurnal_bookdate = empty($row->jurnal_bookdate)?'':date_format(date_create($row->jurnal_bookdate),'d-m-Y');
        $jurnal_descr = $row->jurnal_descr;
        $region = $row->region_name;
        $branch = $row->branch_name;
        $strukturunit = $row->strukturunit_name;
        $rekanan = $row->rekanan_name;
        $saldoawal = $row->jurnalsaldoawal_idr;
        $debet = $row->jurnalsaldodebet_idr;
        $kredit = -1 * ($row->jurnalsaldokredit_idr);
        $mutasi = $row->jurnalsaldomutasi_idr;
        $saldoakhir= $row->jurnalsaldoakhir_idr;
        
        if ($account_current != $acc_id && $acc_id != '' ){ 
            
            if ($account_current != ''){
            ?>
        <tr>
		<td colspan="5" class="auto-style2 header1"><strong>Total</strong></td>
		<td class="auto-style2 header1 currency amount"><strong><?php echo number_format($saldoawal_sum,2); ?></strong></td>
		<td class="auto-style2 header1 currency amount"><strong><?php echo number_format($debet_sum,2); ?></strong></td>
		<td class="auto-style2 header1 currency amount"><strong><?php echo number_format($kredit_sum,2); ?></strong></td>
		<td class="auto-style2 header1 currency amount"><strong><?php echo number_format($mutasi_sum,2); ?></strong></td>
		<td class="auto-style2 header1 currency amount"><strong><?php echo number_format($saldoakhir_sum,2); ?></strong></td>
		<td class="auto-style2 header1"><strong></strong></td>
		<td class="auto-style2 header1"><strong></strong></td>
		<td class="auto-style2 header1"><strong></strong></td>
		<td class="auto-style2 header1"><strong></strong></td>
		<td class="auto-style2 header1"><strong></strong></td>
	</tr>        
            
            <?php
            }
            
            
            $saldoawal_sum= 0;
            $debet_sum= 0;
            $kredit_sum= 0;
            $mutasi_sum= 0;
            $saldoakhir_sum= 0;
            
            
    ?>
	<tr>
		<td class="auto-style2 header1 colcoa"><strong><?php echo $acc_id; ?></strong></td>
		<td colspan="4" class="auto-style2 header1"><strong><?php echo $acc_name; ?></strong></td>
		<td class="auto-style2 header1 saldoawal<?php echo $acc_id; ?>"><strong></strong></td>
		<td class="auto-style2 header1 debet<?php echo $acc_id; ?>"><strong></strong></td>
		<td class="auto-style2 header1 kredit<?php echo $acc_id; ?>"><strong></strong></td>
		<td class="auto-style2 header1 mutasi<?php echo $acc_id; ?>"><strong></strong></td>
		<td class="auto-style2 header1 saldoakhir<?php echo $acc_id; ?>"><strong></strong></td>
		<td class="auto-style2 header1"><strong></strong></td>
		<td class="auto-style2 header1"><strong></strong></td>
		<td class="auto-style2 header1"><strong></strong></td>
		<td class="auto-style2 header1"><strong></strong></td>
		<td class="auto-style2 header1"><strong></strong></td>
	</tr>
        <?php } ?>
    
	<tr>
		<td class="auto-style2 colcoa" style="height: 20px"></td>
		<td class="auto-style2 coljid" style="height: 20px"><?php echo $jurnal_id; ?></td>
		<td class="auto-style2 coldate" style="height: 20px"><?php echo $jurnal_bookdate; ?></td>
		<td class="auto-style2 colsource" style="height: 20px"><?php echo $jurnal_source; ?></td>
		<td class="auto-style2" style="height: 20px"><?php echo $jurnal_descr; ?></td>
		<td class="auto-style2 currency amount" style="height: 20px"><?php echo number_format($saldoawal,2); ?></td>
		<td class="auto-style2 currency amount" style="height: 20px"><?php echo number_format($debet,2); ?></td>
		<td class="auto-style2 currency amount" style="height: 20px"><?php echo number_format($kredit,2); ?></td>
		<td class="auto-style2 currency amount" style="height: 20px"><?php echo number_format($mutasi,2); ?></td>
		<td class="auto-style2 currency amount" style="height: 20px"><?php echo number_format($saldoakhir,2); ?></td>
		<td class="auto-style2 colcoa" style="height: 20px"><?php echo $acc_id; ?></td>
		<td class="auto-style2" style="height: 20px"><?php echo $region; ?></td>
		<td class="auto-style2" style="height: 20px"><?php echo $branch; ?></td>
		<td class="auto-style2" style="height: 20px"><?php echo $strukturunit; ?></td>
		<td class="auto-style2" style="height: 20px"><?php echo $rekanan; ?></td>
	</tr>
    <?php
        
        $account_current=$acc_id;
                                
        $saldoawal_sum += $saldoawal;
        $debet_sum += $debet;
        $kredit_sum += $kredit;
        $mutasi_sum += $mutasi;
        $saldoakhir_sum += $saldoakhir;

        $saldoawal_sumall += $saldoawal;
        $debet_sumall += $debet;
        $kredit_sumall += $kredit;
        $mutasi_sumall += $mutasi;
        $saldoakhir_sumall += $saldoakhir;
    }
    ?>
    <tr>
		<td colspan="5" class="auto-style2 header1" ><strong>Total</strong></td>
		<td class="auto-style2 header1 currency amount" ><strong><?php echo number_format($saldoawal_sum,2); ?></strong></td>
		<td class="auto-style2 header1 currency amount" ><strong><?php echo number_format($debet_sum,2); ?></strong></td>
		<td class="auto-style2 header1 currency amount" ><strong><?php echo number_format($kredit_sum,2); ?></strong></td>
		<td class="auto-style2 header1 currency amount" ><strong><?php echo number_format($mutasi_sum,2); ?></strong></td>
		<td class="auto-style2 header1 currency amount" ><strong><?php echo number_format($saldoakhir_sum,2); ?></strong></td>
		<td class="auto-style2 header1" ><strong></strong></td>
		<td class="auto-style2 header1" ><strong></strong></td>
		<td class="auto-style2 header1" ><strong></strong></td>
		<td class="auto-style2 header1" ><strong></strong></td>
		<td class="auto-style2 header1" ><strong></strong></td>
	</tr>        
            
    <tr>
		<td colspan="5" class="auto-style2 header"><strong>Jumlah Total</strong></td>
		<td class="auto-style2 header currency amount"><strong><?php echo number_format($saldoawal_sumall,2); ?></strong></td>
		<td class="auto-style2 header currency amount"><strong><?php echo number_format($debet_sumall,2); ?></strong></td>
		<td class="auto-style2 header currency amount"><strong><?php echo number_format($kredit_sumall,2); ?></strong></td>
		<td class="auto-style2 header currency amount"><strong><?php echo number_format($mutasi_sumall,2); ?></strong></td>
		<td class="auto-style2 header currency amount"><strong><?php echo number_format($saldoakhir_sumall,2); ?></strong></td>
		<td class="auto-style2 header"><strong></strong></td>
		<td class="auto-style2 header"><strong></strong></td>
		<td class="auto-style2 header"><strong></strong></td>
		<td class="auto-style2 header"><strong></strong></td>
		<td class="auto-style2 header"><strong></strong></td>
	</tr>        
            
</table>


</body>
</html>