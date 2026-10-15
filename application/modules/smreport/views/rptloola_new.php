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
					<table width="753" border="0">
  <tr>
    <td width="626" align="center" style="color:#039; font-size:16px" valign="bottom"><strong>MALL  MANAGEMENT<br />
      </strong>
      <hr />
      <strong>      </strong></td>
  </tr>
  <tr>
    <td align="center" style="color:#039; font-size:16px" valign="top">STATUS LOI & LEASE AGREEMENT NEW PROPERTY
      <br />
      TRANSMART MALL<br /><?php echo strtoupper($vsemester)." ".$cboyear;?></td>
  </tr>
                    </table>

<table width="722" border="1" cellpadding="4" cellspacing="4" style="border-collapse:1px solid">
  <tr>
    <td width="40" rowspan="2" align='center'>No.</td>
    <td width="296" rowspan="2" align='center'>Property</td>
    <td width="52" rowspan="2" align="center" valign="middle">Total Tenant</td>
    <td colspan="2" align="center">LOI</td>
    <td colspan="3" align="center">LEASE AGREEMENT</td>
  </tr>
  <tr>
    <td width="41" align="center">Signed</td>
    <td width="59" align="center">Not Yet Signed</td>
    <td width="49" align="center">Signed</td>
    <td width="73" align="center">Not Yet Signed</td>
    <td width="60" align="center">Not Yet Proceed</td>
  </tr>
<?php  echo showloola_new($cbsemester,$cboyear);?> 
 
</table>
                    
                  </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT -->