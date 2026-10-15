<script> 

  $(document).ready(function(){

  	$("#tabdata").trigger('click');
  	 
  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  	});
	$('.input-group.date').datepicker({
		maxViewMode: 1,
		clearBtn: true,
		orientation: "bottom auto",
		todayHighlight: true,
		startView:0, 
		autoclose:true,
	});  
  });

</script>

<style>
table.dataTable td {
    padding:2px;
}
</style>
<div class="modal fade" id="modal-default">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Success!</h4>
              </div>
              <div class="modal-body">
                <p>Data has been saved&hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default center-block" data-dismiss="modal">Close</button>                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>       

 <!-- CONTENT -->
            <div class="row">
              <div class="col-md-12">
                <div class="portlet"> 
                  <div class="portlet-body">
                    <div class="tabbable-custom ">
                      <ul class="nav nav-tabs ">
                        <li class="active">
                          <a href="<?php echo base_url('index.php/periode/periode/periodelist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="#newdata" data-toggle="tab" id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata"  data-toggle="tab" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">                        
                        <div class="tab-pane" id="newdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('periode/saveperiode');?>" method="post">
<div class="row">
	<div class="col-lg-12 col-md-12">		
		<?php 
                
               // echo create_breadcrumb();		
               $msg = validation_errors();
                if (!empty($msg))
				{
		?> 
				<div class="alert alert-warning fade in ">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: red; background: #000;">x</a>
				  <strong>Warning!</strong> <?php echo $msg; ?>
				</div>
		<?php
				}
                ?>
	</div>
</div>
		                                  
                    <div class="row"> 
                        <div class="col-md-10">                             
                                <div class="col-md-6">
                                    <label>ID</label>                                       
                                    <input  type="text" id="periodeid" name="periode_id" class="form-control" >
                                </div>                                                                                                 
                                <div class="col-md-6">
                                    <label>Name</label>
                                    <input type="text" id = "periode_name" name="periode_name" class="form-control"  value="<?php echo set_value('periode_name'); ?>" placeholder="Wajib Isi">
                                </div>                                                                                             
                                <div class="col-md-6">
                                     <label>Start Date</label>
                                      <div class="input-group date"  data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                          <input type="text" class="form-control input-sm pull-right" id="periode_datestart" name="periode_datestart" value="<?php echo set_value('periode_datestart'); ?>" autocomplete="off" />
                                      </div>
                                </div>                                                                                            
                                 <div class="col-md-6">
                                     <label>End Date</label>
                                      <div class="input-group date"  data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                          <input type="text" class="form-control input-sm pull-right" id="periode_dateend" name="periode_dateend" value="<?php echo set_value('periode_dateend'); ?>" autocomplete="off" />
                                      </div>
                                </div>                                                                                     
                                <div class="col-md-6">
                                    <label>Is Closed</label>
									<input type="checkbox" class="form-control input-sm pull-left" id="periode_isclosed" name="periode_isclosed" value="1"> 
                                </div>                                                                                     
                                <div class="col-md-6">
                                    <label>Allow Saldo Awal Entry</label>
									<input type="checkbox" class="form-control input-sm pull-left" id="periode_allowsaldoawalentry" name="periode_allowsaldoawalentry" value="1">
                                </div>                                                                                 
                                <div class="col-md-6">
                                    <label>Is Locked</label>
									<input type="checkbox" class="form-control input-sm pull-left" id="periode_islocked" name="periode_islocked" value="1" >
                                </div> 
								
                                    <!-- /.col -->
                                <div class="col-xs-12">
                                    <br /><input type="submit" value="SUBMIT" class="btn btn-sm btn-info" />
                                </div>
                            </form>
                       
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT -->