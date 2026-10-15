<script> 

  $(document).ready(function(){

  	$("#tabedit").trigger('click');
  	 
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
                          <a href="<?php echo base_url('index.php/periode/periode/periodeadd'); ?>"  id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata"  data-toggle="tab" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">                        
                        <div class="tab-pane" id="editdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('periode/periode_edit');?>" method="post">
                            <?php 
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>                                   
                    <div class="row">
                        <div class="col-md-10">
                           <form id="form_input">                               
                                <div class="col-md-6">
                                    <label>ID</label>                                       
                                    <input  type="text" id="periodeid" name="periode_id" class="form-control" value="<?php echo $row->periode_id;?>" readonly>
                                </div>                                                                                                    
                                <div class="col-md-6">
                                    <label>Name</label>
                                    <input type="text" id = "periode_name" name="periode_name" class="form-control"  value="<?php echo $row->periode_name;?>" placeholder="Wajib Isi">
                                </div>                                                                                             
                                <div class="col-md-6">
                                     <label>Start Date</label>
                                      <div class="input-group date"  data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                          <input type="text" class="form-control input-sm pull-right" id="periode_datestart" name="periode_datestart" value="<?php echo date('Y-m-d',strtotime($row->periode_datestart)); ?>" autocomplete="off" />
                                      </div>
                                </div>                                                                                            
                                 <div class="col-md-6">
                                     <label>End Date</label>
                                      <div class="input-group date"  data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                          <input type="text" class="form-control input-sm pull-right" id="periode_dateend" name="periode_dateend" value="<?php echo date('Y-m-d',strtotime($row->periode_dateend)); ?>" autocomplete="off" />
                                      </div>
                                </div>                                                                                     
                                <div class="col-md-6">
                                    <label>Is Closed</label>
									<input type="checkbox" class="form-control input-sm pull-left" id="periode_isclosed" name="periode_isclosed" value="1" <?php echo ($row->periode_isclosed == 1) ? 'Checked' : ''; ?>> 
                                </div>                                                                                     
                                <div class="col-md-6">
                                    <label>Allow Saldo Awal Entry</label>
									<input type="checkbox" class="form-control input-sm pull-left" id="periode_allowsaldoawalentry" name="periode_allowsaldoawalentry" value="1" <?php echo ($row->periode_allowsaldoawalentry == 1) ? 'Checked' : ''; ?> >
                                </div>                                                                                 
                                <div class="col-md-6">
                                    <label>Is Locked</label>
									<input type="checkbox" class="form-control input-sm pull-left" id="periode_islocked" name="periode_islocked" value="1" <?php echo ($row->periode_islocked == 1) ? 'Checked' : ''; ?>>
                                </div> 
                                    <!-- /.col -->
                                <div class="col-xs-12">
                                    <br /><input type="submit" value="SUBMIT" class="btn btn-sm btn-info" />
                                </div>
                            </form>
                            <?php }}?>	
                            
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT -->