<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>     
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>   
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>

<script>

$(document).ready(function(){
   $("#tabedit").trigger('click');
   var table = $('#SP_DETIL').DataTable({
		"scrollY": "10240vh",
        "scrollX": true,
        "scrollCollapse": true,        
		"pageLength": 50,
		"processing": true, 
		"serverSide": true, 
		"order": [],
		"searching" : true,
		"ajax": {
			"url":'<?php echo site_url('schedule_payment/controler_gridlistdetil/'.$this->uri->segment(3).'')?>',
			"type": "POST"	
		}, 
		"columnDefs": [
		{
		"targets": [ -1 ], //last column
		"orderable": false, //set not orderable
		},
		 {
	      "targets": "schedulepayment_isclosed",
	      "className": "text-center",
		 }
		],
		dom: 'Blfrtip',
		buttons: [
						{
						  text: 'Excel',
						  extend: 'excel',
						  title:'Laporan Schedule Payment Detil',
						  filename: 'Laporan_SchedulePayment_Detil',
						  className: 'btn btn-primary',
		}],
		"lengthMenu": [[50, 100, 200,-1], [50, 100, 200, "All"]],
		});  
		table.buttons().container().appendTo('#but');
});
 
  
</script>

<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;        
}

.table td{
    padding:2px;
    font-size: 9pt;    
    font-family:  Arial, Verdana, sans-serif;

}

label {
  font-size: 9pt;
}

.nowrap {
        white-space:nowrap;
    }

</style>
 
 <div id="popover-form" class="hide">
      <div class="form-group">
        <textarea rows="4" name="txtContent" id="txtContent" class="form-control input-sm"></textarea>        
        <br>
        <button id="btnOk" type="button" class="btn btn-primary">
          <span class="glyphicon glyphicon-ok"></span>&nbsp;
        </button>  
        <button id="btnCancel" type="button" class="btn btn-default">
          <span class="glyphicon glyphicon-remove"></span>&nbsp;
        </button>
      </div>
    </div>
  
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
                  <div class="portlet-title">
                    <div class="caption" align="right">
                      <div class="actions">
                        <div class="btn-group">
                          <a class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> <i class="fa fa-search"></i> Advanced Search
                          <i class="fa fa-angle-down"></i>
                          </a>
                          <ul class="dropdown-menu pull-right">
                            <br>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="contain">
                                  Author
                                </label>
                                <input class="form-control" type="text" />
                              </div>
                              <div class="form-group">
                                <label for="contain">
                                  Contains the words
                                </label>
                                <input class="form-control" type="text" />
                              </div>
                              <div class="form-group">
                                <label for="contain">
                                  Select Option
                                </label>
                                <select class="form-control">
                                  <option>
                                    Option 1
                                  </option>
                                  <option>
                                    Option 2
                                  </option>
                                  <option>
                                    Option 3
                                  </option>
                                  <option>
                                    Option 4
                                  </option>
                                  <option>
                                    Option 5
                                  </option>
                                </select>
                                <br>
                                <button type="search" class="btn blue">
                                  Search
                                </button>
                              </div>
                            </div>
                          </ul>
                        </div>
                        <div class="btn-group">
                          <a class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> <i class="fa fa-print"></i> Export
                          <i class="fa fa-angle-down"></i>
                          </a>
                          <ul class="dropdown-menu pull-right">
                            <li>
                              <a href="javascript:;">
                              <i class="fa fa-file-pdf-o"></i> PDF </a>
                            </li>
                            <li>
                              <a href="javascript:;">
                              <i class="fa fa-file-excel-o"></i> EXCEL </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="tools">
                      <a href="javascript:;" class="collapse"> </a>
                      <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                    </div>
                  </div>
                  <div class="portlet-body">
                    <div class="tabbable-custom ">
                      <ul class="nav nav-tabs ">
                        <li class="active">
                          <a href="<?php echo base_url('index.php/schedule_payment/sp_list'); ?>" id='tablist'> LIST </a>
                        </li> 
                        <li>
                          <a href="#editdata" data-toggle="tab"  id='tabedit'> DETAIL </a>
                        </li>
                      </ul>
					  
                      <div class="tab-content">
                        <div class="tab-pane" id="editdata">
                          <div class="portlet-body form">
                        
                          <!--content table -->
							<div id="but" > </div>
							<div class="table-container table-scrollable">								 
                                 <table class="table table-striped table-hover  nowrap" id='SP_DETIL' style="border-color: #E0E0E0;width:100%;height:120px;">
                                 	  <thead>
                                  		<tr>
                                        <th>Line</th> 
                                        <th>ID</th>
                                        <th>Tenant</th> 
                                        <th>Brand</th>  
                                        <th>Ref.ID</th>
                                        <th>Ref.Ln</th>
                                    	<th>Type</th>
                                        <th>IsInvoice</th>
                                        <th>Posted</th>
                                        <th>BO.Posted</th>
                                        <th>Descr</th>
                                        <th>Date</th>
                                        <th>Due.Date</th>
                                        <th>IDR</th>
                                        <th>VAT</th>
                                        <th>BO.ID</th>
                                        <th>Invoice</th>
                                        <th>Faktur Pajak</th>
                                        <th>Official.Receipt</th>
                                        <th>Post Date</th>
                                        <th>Post By</th>                  
                                  		</tr>              
                				       </thead>
                              		<tbody>
                              		</tbody>
                            	   </table>                                 
                              </div>
							
                          <!--content table -->
                        
						 </div>
						</div> 
                       </div>
					   
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT -->
