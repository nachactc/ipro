


<?php  
  if ($button == 'EXCEL')
  {

	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header("Content-Disposition: attachment; filename=".$region_name." - ".$branch_name.".xls");
  } 
 ?>
 
 <title>Statement of Account</title>
 
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


</head>
<br />

<body>
<p>STATEMENT OF ACCOUNT</p>
<p>SUMMARY BY TENANT</p>
        <table width="942" border="0">
          <tr>
            <td width="155">&nbsp;</td>
            <td width="381">&nbsp;</td>
            <td width="130">&nbsp;</td>
            <td width="258">&nbsp;</td>
          </tr>        
          <tr>
            <td width="155" font-size:10px>Periode</td>
            <td width="381" font-size:10px>:  s/d <?php echo $end_date; ?></td>
            <td width="130" font-size:10px>Business Unit</td>
            <td width="258" font-size:10px>:  <?php echo $region_name; ?></td>
          </tr>              
        </table>
<?php
$Gtotaldebit =0;
$Gtotalkredit=0;
?>        
<?php if ($result) : ?>   
 
        <table class="tg" width="944" border="0">
          <tr>
                <td width="13%" class="tg-li00">Store</td>
                <td width="17%" class="tg-li00">Tenant</td>        
                <td width="33%" class="tg-li00">Brand</td>
                <td width="13%" align="right" class="tg-li00">Debit (IDR)</td>
                <td width="12%" align="right" class="tg-li00">Credit (IDR)</td>
                <td width="12%" align="right" class="tg-li00">Balance (IDR)</td>        
          </tr>
  
<?php
$balance =0;
$totalbalance =0;
$subtotalbalance =0;
$debit = 0;
$subdebit = 0;
$totaldebit = 0;
$kredit = 0;
$subkredit = 0;
$totalkredit = 0;
$agreementtype='X';
$agreementtype2='';
$agreementprintouttype='';
$branchrekananline ='';
$Gtotaldebit =0;
$Gtotalkredit=0;	
$agreementtype='X';	

	foreach ($result as $datas => $row) : ?>                       
		<?php
        
		  $debit = $row->jurnaldetil_idr;
		  $kredit = $row->jurnaldetil_idrOR;
		  $balance = $debit - $kredit;
		  $totalbalance = $balance + $totalbalance;
		  $subdebit = $subdebit + $debit;
		  $subkredit = $subkredit + $kredit;
		  $subtotalbalance = $subdebit - $subkredit;
		  $totaldebit = $totaldebit + $debit;
		  $totalkredit = $totalkredit + $kredit;
		  $Gtotaldebit = $Gtotaldebit +   $debit;	
		  $Gtotalkredit = $Gtotalkredit + $kredit;		  	   				  
		?>    
		   
	<?php 
	//buat total
	if (@$result[$datas+1]->branchrekananline != $row->branchrekananline) {
		
	?>
              <tr>
                <td class="tg-iuhm"><?php echo $row->branch_name; ?></td>
                <td class="tg-iuhm"><?php echo $row->rekanan_name; ?></td>
                <td class="tg-iuhm"><?php echo $row->rekananshipping_name; ?></td>
                <td align="right" class="tg-iuhm"><?php echo number_format($totaldebit,0); ?></td>
                <td align="right" class="tg-iuhm"><?php echo number_format($totalkredit,0); ?></td>
                <td align="right" class="tg-iuhm"><?php echo number_format($totaldebit - $totalkredit,0); ?></td>
              </tr>      
    <?php
			$totaldebit =0;
			$totalkredit =0;	
	?>                                      	
<?php 

	}
$branchrekananline = $row->branchrekananline;
endforeach; ?>
              <tr>
                <td class="tg-iuhm"></td>
                <td class="tg-iuhm">TOTAL</td>
                <td class="tg-iuhm"></td>
                <td align="right" class="tg-iuhm"><?php echo number_format($Gtotaldebit,0); ?></td>
                <td align="right" class="tg-iuhm"><?php echo number_format($Gtotalkredit,0); ?></td>
                <td align="right" class="tg-iuhm"><?php echo number_format($Gtotaldebit - $Gtotalkredit,0); ?></td>
              </tr>
<?php else: 
echo "TIDAK ADA DATA";
echo " ";
?>

<?php endif; ?> 
 
</table>
</body>

</html>
