 <!-- CONTENT -->
<style>
div.scroll {
    background-color: #ffffff;
    overflow:auto;
}
#map {
    position:relative
}
.map_title {
position:absolute;  
text-align: left; 
font-size:7px; color:#000;
}
</style>
 <link rel="stylesheet" href="<?php echo base_url('assets/scripts/minimal/css/nutip.css');?>">
<script src="<?php echo base_url('assets/scripts/minimal/src/js/jquery.nutip-1.0.js');?>"></script>
<script src="<?php echo base_url('assets/scripts/map/jquery.maphilight.js');?>" type="text/javascript"></script>

<script type="text/javascript">
$(function() {
$('.map').maphilight();
});
//setTimeout(function() { window.location=window.location;},5000);
$(function() {
     		<?php if(isset($result)){
		   		foreach($result as $row){ 
				$vcoord=$row->unit_coordinate;
				if (strlen($vcoord)>1){
				$vstatus=$row->unit_state;
				$vunitid=$row->unit_id;
				$luas=getspecunit($vunitid);
				$vunittypeid=$row->unittype_id;
				$arrhsl= explode(',',$vcoord);
				$vx=$arrhsl[0];
				$vy=$arrhsl[1];
				$visi="";
				if ( ($vstatus=='2') and ($vunittypeid=='1')){
					if ($luas>0){
						$visi .=$row->unit_name."<br>".number_format($luas,1)."<br>";
					}else{
					$visi .=$row->unit_name."<br>".number_format($row->unit_sqm,1)."<br>";
					}
					
					//$visi .=getTenantLooscbr($branchid,$vunitid);
				}else if ( ($vstatus=='3') and ($vunittypeid=='1')){
					$visi .=$row->unit_name."<br>".number_format($row->unit_sqm,1)."<br>";
					//$visi .=getTenantLoibr($branchid,$vunitid);
				}else{
					$visi .=$row->unit_name."<br>".number_format($row->unit_sqm,1)."<br>";
					//$visi .=getTenantLoo1($branchid,$vunitid);
				}
				?>
				
				var txt='<?php echo $visi;?>';
				var left=<?php echo $vx;?>;
        		var top=<?php echo $vy;?>;
				
				var $span=$('<span class="map_title">'+txt+'</span>');        
       			$span.css({top: top+'px', left: left+'px', position:'absolute'});
       			$span.appendTo('#map');

			<?php }}}?>
})
</script>


            <div class="row">
              <div class="col-md-12">
                <div class="portlet">
                  <div class="portlet-body">
                  <table  cellpadding="4" cellspacing="4" style="border-collapse: collapse;border-spacing:0;" width="91%"  >
                  <tr>
                  <td height="30" width="93" bgcolor="#FF0000">&nbsp;</td><td width="100" align="center">Available</td>
                  <td width="93" bgcolor="#FF8000">&nbsp;</td><td width="93">&nbsp;&nbsp;&nbsp;&nbsp;LOO Booked</td>
                  <td width="93" bgcolor="#CCFF00">&nbsp;</td><td width="114" align="center">LOO Approved</td>
                  
                  </tr>
                  </table>
                  <div class="scroll">
                   <table border="0" cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
  <tr>
    <td width="100%">
     <br />
    <div id="map">
     <img border="1" src="<?php echo base_url('assets/img/'.$vfile);?>" usemap="#FPMap0" width="<?php echo $vwidth;?>" height="<?php echo $vheight;?>" class="map"></div>
    <map name="FPMap0">
     <?php if(isset($result)){
		   		foreach($result as $row){ 
				$status=$row->unit_state;
				$vcontent="";
				$ukuran=number_format($row->unit_sqm,0);
				if ($status=='0'){
					$vcolor="FF0000";
					$vcolorline="000000";
					$vborderline=1;
					$vcontent .="Floor	    :$lantainame<br>";
					$vcontent .="Unit Name	:$row->unit_name<br>";
					$vcontent .="Unit Size	:$ukuran  M2<br>";

				}else if ($status=='1'){
					$unitid=$row->unit_id;
					$vcolor="FF8000";
					$vcolorline="000000";
					$vborderline=1;
					$vcontent .="Floor	    :$lantainame<br>";
					$vcontent .="Unit Name	:$row->unit_name<br>";
					$vcontent .="Unit Size	:$ukuran<br>";
					
					$vcontent .="Booked by :<br>";
					$vcontent .="<table width='371' border='1'>";
  					$vcontent .="<tr>";
    				$vcontent .="<td width='192'>No. LOO</td>";
    				$vcontent .="<td width='153'>Tenant Name</td>";
					$vcontent .="<td width='10'>#</td>";
  					$vcontent .="</tr>";
					
					$vcontent .=getTenantLoo($branchid,$unitid);
					
  					/* $vcontent .="<tr>";
   					$vcontent .="<td>&nbsp;</td>";
   					$vcontent .="<td>&nbsp;</td>";
  					$vcontent .="</tr>"; */					
					$vcontent .="</table>";
				}else if ($status=='2'){
					
					$vcolor="CCFF00";
					$vcolorline="000000";
					$vborderline=1;
					$unitid=$row->unit_id;
					$luas=getspecunit($unitid);
					$vcontent .="Floor	    :$lantainame<br>";
					$vcontent .="Unit Name	:$row->unit_name<br>";
					if ($luas>0){
						$vcontent .="Unit Size	:$luas<br>";
					}else{
					$vcontent .="Unit Size	:$ukuran<br>";
					}
					
					$vcontent .="Booked by :<br>";
					$vcontent .="<table width='371' border='1'>";
  					$vcontent .="<tr>";
    				$vcontent .="<td width='192'>No. LOO/Agreement</td>";
    				$vcontent .="<td width='163'>Tenant Name</td>";
  					$vcontent .="</tr>";
					
					$vcontent .=getTenantLoosc($branchid,$unitid);
					
  					/* $vcontent .="<tr>";
   					$vcontent .="<td>&nbsp;</td>";
   					$vcontent .="<td>&nbsp;</td>";
  					$vcontent .="</tr>"; */					
					$vcontent .="</table>";
				}
				$vcontent=str_replace('"',"",$vcontent);
	?>
    <area href="#" class="swatch bluejay" data-nutip="e<?php echo "$row->unit_id";?>-bluejay" data-nutip-type="popup" data-nutip-style="bluejay" data-nutip-title="Detail" data-nutip-message="<?php echo $vcontent;?>" shape="<?php echo "$row->unit_coordtype";?>" coords="<?php echo "$row->unit_coordinate";?>"
    data-maphilight='{"stroke":true,"fillColor":"<?php echo $vcolor;?>","strokeColor":"<?php echo $vcolorline;?>","fillOpacity":1,"strokeWidth": <?php echo $vborderline;?>,"alwaysOn":true}' >
    <?php }} ?>
    </map>
   </td>
  </tr>
</table>
</div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT -->