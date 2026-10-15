 <!-- CONTENT -->
<script src="<?php echo base_url('assets/scripts/map/jquery.maphilight.js');?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
$('.map').maphilight();
});

$(document).ready(function(){
    $('[data-toggle="popover"]').popover({html: true});
});			 

		
</script>

            <div class="row">
              <div class="col-md-12">
                <div class="portlet">
                  <div class="portlet-body">
                   <table border="0" cellpadding="4" cellspacing="4" style="border-collapse: collapse" width="100%">
  <tr>
    <td width="100%"><br /><br /><br />
     <img border="0" src="<?php echo base_url('assets/img/mappalembangkdc.jpg');?>" usemap="#FPMap0" width="1024" height="716" class="map">
    <map name="FPMap0">
     <?php if(isset($result)){
		   		foreach($result as $row){ 
				$status=$row->unit_state;
				if ($status=='0'){
					$vcolor="FF0000";
				}else if ($status=='1'){
					$vcolor="FFFF00";
				}else if ($status=='2'){
					$vcolor="00CC00";
				}
	?>
    <area href="#" data-trigger="hover" title="Detail :" data-placement="top" data-content="Floor : GF<br />Unit No. :<?php echo "$row->unit_name";?><br />Size :<?php echo "$row->unit_sqm";?> M2 <br />" 
    data-toggle="popover" shape="<?php echo "$row->unit_coordtype";?>" coords="<?php echo "$row->unit_coordinate";?>"
    data-maphilight='{"stroke":true,"fillColor":"<?php echo $vcolor;?>","strokeColor":"000000","fillOpacity":1,"alwaysOn":true}' >
    <?php }} ?>
    </map>
   </td>
  </tr>
</table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT -->