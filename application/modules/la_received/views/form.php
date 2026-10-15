<script>
$(document).ready(function() {
	
	var rTable=listgrid("<?php echo site_url('la_received/dialog_loo')?>","popLoader","trp", 100);
	   
	$('#btloo').click(function() {
		rTable.rows('.selected').deselect();
		$("#tedialog").modal("show");
	});
	
	//var table = $('#popLoader').DataTable();
	
	 
	$('#searchloo').keyup(function() {
		var searchTenant  = $("#searchloo").val(); 
		 console.log(searchTenant);
		// table.search(searchTenant).draw();
		if ( $.fn.dataTable.isDataTable( '#popLoader' ) ) {
			rTable.destroy();
			// oTable=listgrid("<?php echo site_url('la_received/dialog_loo/')?>"+val_search,"looTable","lfrtip");   
			rTable = popgrid("<?php echo site_url('la_received/dialog_loo/')?>"+searchTenant,"popLoader","trp", 100);
		}
		else {
			 rTable= $('#popLoader').DataTable();
		}   
	});
	 
	$('#popLoader tbody').on('click', 'tr', function () {
        var id = this.id;
        var index = $.inArray(id, selected);
 
        if ( index === -1 ) {
            selected.push( id );
        } else {
            selected.splice( index, 1 );
        }
 
        $(this).toggleClass('selected');
		$(this).hasClass('selected');
    } );  
     
	
	$('#addData').click(function () {

      var linenum=0;
       var rData = rTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){
 
          var tloo_id   = rData[i][4];
          var tla_noloi   = rData[i][5];

          $('#loo_id').val(tloo_id);
          $('#la_noloi').val(tla_noloi); 
      }

	}); 
	$.fn.datepicker.defaults.format = "yyyy-mm-dd"; 
    $.fn.datepicker.defaults.autoclose = true; 
	$.fn.datepicker.defaults.orientation= 'bottom';
    $.fn.datepicker.defaults.todayHighlight= true;
}); 

</script> 

<?php
echo  $dialog_loo;
?>

<div class="portlet-body">
	<div class="tabbable-custom ">
		  <ul class="nav nav-tabs ">
			<li>
			   <a href="<?php echo base_url('index.php/la_received'); ?>">LIST </a>
			</li>
			<li <?php echo ($tab == 'input') ?   "class='active'" :  ""; ?> >
			  <a href="<?php echo ($tab == 'input') ?   "#tab_input" :  base_url('index.php/la_received/add'); ?>" 
			  <?php echo ($tab == 'input') ?   "data-toggle='tab'" :  ''; ?>> INPUT </a>
			   
			</li>
			<li <?php echo ($tab == 'edit') ?   "class='active'" :  ""; ?>>
			   <a href="<?php echo ($tab == 'edit') ?   "#tab_edit " :  base_url('index.php/la_received/edit'); ?>" <?php echo ($tab == 'edit') ?   "data-toggle='tab'" :  ''; ?> > EDIT </a>
			</li>
		  </ul>
		  <div class="tab-content">  
			 <div class="tab-pane active" id=" <?php echo ($tab == 'input') ?   "tab_input" :  "tab_edit"; ?> ">
			 <!-- input area -->
				<div class="row">
				<div class="col-lg-12 col-md-12">		
					<?php 
							
						   // echo create_breadcrumb();		
							$msg = $this->session->flashdata('message'); 
							if (!empty($msg))
							{
					?> 
							<div class="alert alert-success fade in ">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
							   <?php echo $msg; ?>
							</div>
					<?php
							}
							?>
				</div>
			    </div><!-- /.row -->
			 
			   
				<?php echo form_open(site_url($action),'role="form" class="form-horizontal" id="form_transaksi_lareceived" parsley-validate'); ?> 
							  <div class="portlet-body form">
				<div class="row">
					<div class="col-md-12">
							  
							  <!--content-->
							   
								<div class="col-md-4 form-group row">
									<div class="col-xs-12">
									<label > Loo   </label>
									<div class="input-group input-group-sm">
									 <?php                  
									   echo form_input(
													array(
													 'name'         => 'loo_id',
													 'id'           => 'loo_id', 
													 'class'        => 'form-control input-sm',
													 'placeholder'  => 'Loo', 
													 'Readonly'	=> 'TRUE'
													 ),
													 set_value('loo_id',$la_received['loo_id'])
											   );             
									  ?>
									   <span class="input-group-btn">
									  <button id ="btloo" type="button" class="btn btn-primary"><i class="fa fa-search"></i>
									  </button>
									  </span>
									 <?php echo form_error('loo_id');?>
									</div>
									</div>
								</div> <!--/ LOO -->  
								<div class="col-md-4 form-group row">
									<div class="col-xs-12">
									<label for="la_noloi" class="control-label">Loi</label>
									 <?php                  
									   echo form_input(
													array(
													 'name'         => 'la_noloi',
													 'id'           => 'la_noloi', 
													 'class'        => 'form-control input-sm ',
													 'placeholder'  => 'La Noloi',
													 'Readonly'	=> 'TRUE'
													 ),
													 set_value('la_noloi',$la_received['la_noloi'])
											   );             
									  ?>
									 <?php echo form_error('la_noloi');?>
									</div>
								</div> <!--/ La Noloi -->  
								<div class="col-md-4 form-group row">
									<div class="col-xs-12">
									<label for="la_receivedby" class="control-label">La Received By</label>
									  <?php  
									  
									   echo form_input(
													array(
													 'name'         => 'la_receivedby',
													 'id'           => 'la_receivedby', 
													 'class'        => 'form-control',
													 'placeholder'  => 'La Receivedby',
													 'Readonly'	=> 'TRUE'
													 ),
													 set_value('la_receivedby',$la_received['la_receivedby'])
											   );             
									  ?>
									 <?php echo form_error('la_receivedby');?>
									</div>
								</div> <!--/ La Receivedby -->   
								<div class="col-md-4 form-group row">
									<div class="col-xs-12 ">
									<label for="la_receiveddate" class="control-label">La Received Date</label>
									 <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="la_receiveddate" name="la_receiveddate" value = "<?php echo $la_received['la_receiveddate'];?>">
                                      </div> 
									</div>
								</div> <!--/ La Receiveddate -->   
								
								<div class="col-md-4 form-group row">
									<div class="col-xs-12">
									<label for="la_signdate" class="control-label">La Sign Date</label>
									 <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="la_signdate" name="la_signdate" value = "<?php echo $la_received['la_signdate'];?>">
                                     </div> 
									</div>
								</div> <!--/ La Signdate -->  
								
								<div class="col-md-4 form-group row">
									<div class="col-xs-12">
									<label for="la_signby" class="control-label">La Sign By</label>
									       <?php                  
										   echo form_input(
														array(
														 'name'         => 'la_signby',
														 'id'           => 'la_signby',                       
														 'class'        => 'form-control input-sm ',
														 'placeholder'  => 'La Signby',
														 'Disabled'	=> 'TRUE'
														 ),
														 set_value('la_signby',$la_received['la_signby'])
												   );             
										  ?>
										 <?php echo form_error('la_signby');?>
									</div>
								</div> <!--/ La Signby -->  
								
								<div class="col-md-4 form-group row">
									<div class="col-xs-12">
									<label for="la_proceeddate" class="control-label">La Proceed Date</label>
										<div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="la_proceeddate" name="la_proceeddate" value = "<?php echo $la_received['la_proceeddate'];?>">
                                        </div>  
									</div>
								</div> <!--/ La Proceeddate -->    
								<div class="col-md-4 form-group row">
									<div class="col-xs-12">
									<label for="la_proceedby" class="control-label">La Proceed By</label>
									       <?php                  
											   echo form_input(
															array(
															 'name'         => 'la_proceedby',
															 'id'           => 'la_proceedby',                       
															 'class'        => 'form-control input-sm ',
															 'placeholder'  => 'La Proceedby',
															 'Readonly'	=> 'TRUE'
															 ),
															 set_value('la_proceedby',$la_received['la_proceedby'])
													   );             
											  ?>
											 <?php echo form_error('la_proceedby');?>
									</div>
								</div> <!--/ La Proceedby -->     
								   
							   <div class="col-md-4 form-group row">
									<div class="col-xs-12">
									<label for="la_receiveddate" class="checkbox-inline">Received
									     <input id= "la_isreceived" name="la_isreceived" class= "checkbox" type="checkbox" value=1  <?php if ($la_received['la_isreceived'] == 1) echo 'checked= "checked"';?>>
									</label>
									<label for="la_issigned" class="checkbox-inline">Signed
										 <input id= "la_issigned" name="la_issigned" class= "checkbox" type="checkbox" value=1 <?php if ($la_received['la_issigned'] == 1) echo 'checked= "checked"';?>> 
									</label>
									<label for="la_isproceed" class="checkbox-inline">Proceed
										 <input id= "la_isproceed" name="la_isproceed"  class= "checkbox" type="checkbox" value=1 <?php if ($la_received['la_isproceed'] == 1) echo 'checked= "checked"';?>>
									</label>	 
									</div>
								</div> <!--/ La Isreceived --> 
								 
							  <!--content-->
							  
							
				<div class="row"> &nbsp; </div> <br/> 
					<div class="col-xs-12">  
						 <button type="submit" class="btn btn-md btn-info" name="post">
								<i class="glyphicon glyphicon-floppy-save"></i> Submit 
							</button>   
					</div> <!--/ button -->  
				</div>
				<?php echo form_close(); ?> 
			      </div>
					</div>
			   
			 <div>
		  </div>
	</div>
</div>

      