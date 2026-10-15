         <div class="row">
              <div class="col-md-12">
                <div class="portlet">
                  <div class="portlet-body">
                  <form id="form1" name="form1" method="post" action="">
                  <table width="283" border="0">
  <tr>
  <td width="100" height="10" align="left">Semester</td>
    <td width="13" height="10" align="left">:</td>
    <td width="170" height="10" align="left"><?php
	$options=array('' => '==Pilih==');
	foreach($rsemester as $rowsemester){
		$options[$rowsemester->semester_id] =$rowsemester->semester_name;
	}
		echo form_dropdown('cbsemester',$options, set_value('cbsemester'),'id="cbsemester" class="form-control input-sm" required');
	?></td>
  </tr>
  <tr>
    <td height="10" align="left">&nbsp;</td>
    <td height="10" align="left">&nbsp;</td>
    <td height="10" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td height="10" align="left">Year</td>
    <td height="10" align="left">:</td>
    <td height="10" align="left"> 
	
	
					<?php
					$options=array('' => '==Pilih==');
					$sekarang=2017;
					for ($i=$sekarang; $i<=$sekarang+30 ; $i++){
						$options[$i]=$i;
					}

					$cs4=' class="form-control input-sm" required';
					echo form_dropdown('cboyear',$options,set_value('cboyear'),$cs4);
					?></td>
  </tr>
  <tr>
    <td height="10" align="left">&nbsp;</td>
    <td height="10" align="left">&nbsp;</td>
    <td height="10" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td height="10" align="left">&nbsp;</td>
    <td height="10" align="left">&nbsp;</td>
    <td height="10" align="left"><input type="submit" name="btload" id="button" value="Load" class="btn btn-primary" /></td>
  </tr>
                  </table>
 </form>
					<table width="852" border="0">
  <tr>
    <td width="846" align="center" style="color:#039; font-size:16px" valign="bottom"><strong>MALL  MANAGEMENT</strong></td>
  </tr>
  <tr>
    <td align="center" height="10"><hr /></td>
  </tr>
  <tr>
    <td align="center" style="color:#039; font-size:16px" valign="top">STATUS INVOICING & PAYMENT DP + SECURITY DEPOSIT<br />
      TRANSMART MALL<br /><?php echo strtoupper($vsemester)." ".$cboyear;?></td>
  </tr>
                    </table>

<table width="854" border="1" cellpadding="4" cellspacing="4" style="border-collapse:1px solid">
  <tr>
    <td width="26" rowspan="3" align='center'>No.</td>
    <td width="92" rowspan="3" align='center'>Property</td>
    <td width="41" rowspan="3" align="center" valign="middle">Total Tenant</td>
    <td width="43" rowspan="3" align="center">LOI<br />
      Signed</td>
    <td colspan="4" align="center">DOWN PAYMENT</td>
     <td colspan="4"  align="center" valign="middle">SECURITY DEPOSIT</td>
     </tr>
  <tr>
    <td width="42" rowspan="2" align="center">NO DP*</td>
    <td colspan="2" align="center">INVOICING</td>
    <td width="11" rowspan="2" align="center">PAYMENT DONE**</td>
    <td width="41" rowspan="2"  align="center" valign="middle">NO SEC DP*</td>
    <td colspan="2"  align="center" valign="middle">INVOICING</td>
    <td width="9" rowspan="2"  align="center" valign="middle">PAYMENT DONE*</td>
    </tr>
  <tr>
    <td width="46" align="center">DONE</td>
    <td width="52" align="center">IN PROG</td>
    <td width="9"  align="center" valign="middle">DONE</td>
    <td width="9"  align="center" valign="middle">IN PROG</td>
    </tr>
  
 
  
<?php  echo showloidp($cbsemester,$cboyear);?> 
 
</table>
<table width="854" border="0" cellpadding="4" cellspacing="4" style="border-collapse:1px solid">
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
  <td width="158">&nbsp;</td>
  <td width="91">*)NO DP :</td>
  <td width="407">1. GROUP</td><td width="136"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td>2.PUSH CART</td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td>3.BTS</td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td> NO SD  :</td>
    <td>1. GROUP</td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">**) % PAYMENT DONE FROM TOTAL INVOICING DONE</td>
    <td></td>
  </tr>
  </table>
                    
                  </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT -->