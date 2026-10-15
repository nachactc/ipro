<script>
$(document).ready(function() {
	
	$("#tabdata").trigger('click');
	
	// var rTable=$('#popLoader').DataTable();
	
	var rTable=popgrid("<?php echo site_url('legal_upload/dialog_loo')?>","popLoader","trp", 20);
	 
	$('#btloo').click(function() {
		rTable.rows('.selected').deselect();
		$("#tedialog").modal("show");
	});
	// $('#btnrek').click(function() { 
		// var searchTenant  = $("#searchloo").val(); 
		// rTable.search(searchTenant).draw();
	// });
	$('#searchloo').keyup(function() {
		var searchTenant  = $("#searchloo").val(); 
		// console.log(searchTenant);
		// table.search(searchTenant).draw();
		if ( $.fn.dataTable.isDataTable( '#popLoader' ) ) {
			rTable.rows('.selected').deselect();
			rTable.destroy();
			// oTable=listgrid("<?php echo site_url('la_received/dialog_loo/')?>"+val_search,"looTable","lfrtip");   
			rTable = popgrid("<?php echo site_url('legal_upload/dialog_loo/')?>"+searchTenant,"popLoader","trp", 20);
			rTable=$('#popLoader').DataTable();
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
	
	 // $('#popLoader tbody').on( 'click', 'tr', function () {
        // if ( $(this).hasClass('selected') ) {
            // $(this).removeClass('selected');
        // }
        // else {
            // table.$('tr.selected').removeClass('selected');
            // $(this).addClass('selected');
        // }
    // } );
	
	// $('#popLoader tbody').on('click', 'tr', function () {
        // var data = table.row( this ).data();
        // alert( 'You clicked on '+data[0]+'\'s row' );
    // } );
	
	var table = $('#popLoader').DataTable();
	 
	$('#popLoader tbody').on( 'click', 'tr', function () {
		// data =  table.row( this ).data();
		// console.log(data[0]);
		// alert(data[0]);
		//table.$('tr.selected').removeClass('selected');
		 $(this).addClass('selected');
	} );
	
	$('#addData').click(function () {

      var linenum=0;
       var rData = rTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){
 
          var tloo_id   = rData[i][0];
          var tagr_id   = rData[i][5];

          $('#loo_id').val(tloo_id);
          $('#agreement_id').val(tagr_id);
      }

	}); 
	$.fn.datepicker.defaults.format = "yyyy-mm-dd"; 
    $.fn.datepicker.defaults.autoclose = true; 
}); 
</script> 
<?php
echo  $dialog_loo;
?>

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

        <div class="modal fade" id="mdldialog" tabindex="-1" role="basic" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            </button>
                            <h4 class="modal-title">
                              Data Unit
                            </h4>
                          </div>
                          <div class="modal-body"> 
                            <form action="#" id="form" class="form-horizontal">
							
							  
                            <div class="row">  
							  <div class="col-md-4">
                                 <label>Business Unit</label>
                                <?php echo form_dropdown('cboregionDlg',$region,'',' id="regionDlg_select" style="width: 100%;" class="iregionsearch form-control " '); ?>
                              </div>
							<div class="col-md-4">
                                 <label>Store</label>
								 <select id="branchdlg_select" class="form-control" style="width: 100%;"> </select> 
                              </div>
                              
							</div>
							
                            <div class="row"> 
							  <div class="col-md-4">
                                 <label>Unit</label>
                                <input  type="text" id="sID" class="form-control input-sm" placeholder="Search Unit" >
                              </div>							
                              <div class="col-md-4">
                                <label>Lantai</label>
                                <input  type="text" id="sUnitName" class="form-control input-sm" placeholder="Search Lantai" >
                              </div>
                              <div class="col-md-4" align="right">
                                <br>
                                <input type="button" id="btnload" value = "LOAD" class="btn btn-sm btn-info"/>
                              </div>
                            </div>
                           <div class="portlet-body">
                            <div class="table-container">
                              <div class="table-scrollable">
                                <table class="table table-striped table-bordered table-hover nowrap compact" id='uLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                                  <thead>
                                   <tr>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Region</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Branch</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Name</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Sqm</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Lantai</th>
                                   </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                        </div>
                        <br />
                        </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">
                              Close
                            </button>
                            <button type="button" class="btn green" data-dismiss="modal" id="btdialog">
                              Add Selected Data
                            </button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>

                  

                    <!-- /.popup-template -->
                    <div class="modal fade" id="tempdialog" tabindex="-1" role="basic" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            </button>
                            <h4 class="modal-title">
                              Schema Unit
                            </h4>
                          </div>
                          <div class="modal-body">
                            <form action="#" id="form" class="form-horizontal">
                              <div class="row">
                                <div class="col-md-4">
                                   <label>Unit</label>
                                  <input  type="text" id="sID" class="form-control input-sm" placeholder="Search Unit" >
                                </div>
                                <div class="col-md-4">
                                  <label>Lantai</label>
                                  <input  type="text" id="sUnitName" class="form-control input-sm" placeholder="Search Lantai" >
                                </div>
                                <div class="col-md-4" align="right">
                                  <br>
                                  <input type="button" id="btnload" value = "LOAD" class="btn btn-sm btn-info"/>
                                </div>
                              </div>

                            <br />
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">
                              Close
                            </button>
                            <button type="button" class="btn green" data-dismiss="modal" id="addschema">
                              Accept
                            </button>
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
                          <a href="<?php echo base_url('index.php/legal_upload/legal_list'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="#newdata" data-toggle="tab" id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane" id="newdata">
                          <div class="portlet-body form"> 
                            <?php
					
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ 
					 echo form_open_multipart('legal_upload/legal_actsave','id="FormES"');?>
                    <div class="row">
                      <div class="col-md-12">
                                  <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>LOO ID</label>
                                      <input  type="text" id="loo_id" name="loo_id" class="form-control input-sm" value="<?php echo $row->loo_id;?>" readonly>
                                      <input  type="hidden" id="id_file" name="id_file" class="form-control input-sm" value="" readonly>
                                    </div>
                                  </div>
                                  
                                   <div class="col-md-2 form-group row">
                                    <div class="col-xs-12">
                                      <label>&nbsp;</label>
									   <span class="input-group-btn">
                                          <button id ="btloo" type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                        </span>  
                                    </div>
                                  </div>
								  
								  <div class="row"> &nbsp; </div>
								  
								  <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>Agreement ID</label>
                                      <input  type="text" id="agreement_id" name="agreement_id" class="form-control input-sm" readonly>
                                    </div>
                                  </div>
								  
								  <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>No. LA</label>
                                      <input  type="text" id="no_la" name="no_la" class="form-control input-sm" >
                                    </div>
                                  </div>
								  
								  <div class="col-md-5 form-group row">
                                    <div class="col-xs-12">
                                      <label>File</label>
                                      <input type='file' name='userfile' id="usrFileS" size='20' />
                                    </div>
                                  </div>
									
								  <div class="row"> &nbsp; </div>
								  
								  <div class="col-md-12 form-group row">
                                    <div class="col-xs-12">
                                        <label>Description:</label> 
                                        <textarea id = "file_desc" name="file_desc" class="form-control input-sm" required rows="3" ></textarea>
                                    </div>
                                  </div>
								  
                                  <!-- /.form group -->
                                   
                                    <!-- /.col -->
                                <div class="col-xs-12">
                                    <br /><input type="submit" id="submitF" value="SUBMIT" class="btn btn-sm btn-info" />
                                </div>
                              </div>
                             </div>
                            </form>
                            <?php }}?>

                          </div>
                        </div>
						
							<br/>
							<div id="loader-icon" style="display:none" align="right" style="float:right;">
									<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw margin-bottom"></i>
									<span>Loading...</span>
									 
								</div>
								<br/>
							<div class="col-sm-12">
								
								<div class="progress" style="display:none">
								<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
								<span class="sr-only">0% Complete</span>
								</div>
								</div> 
							</div>   
							<br/>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT -->
<script>

	$('#submitF').click(function(event){
		 
		//console.log($('#FormES input[type=file]').get(0).files.length);
		if($('#FormES input[type=file]').get(0).files.length == 0 ){ 
			alert('No Document'); 
		}
		else
		{
				 $('#loader-icon').show();
				 $('.progress').show();
				 var progressbar = $('.progress-bar');
				 var formData = new FormData($("#FormES")[0]); 
				 $.ajax({
						 url:$('#FormE').attr('action'),
						 type:"post",
						 data: formData,
						 async : true,
						 cache : true,
						 contentType : false,
						 processData : false, 
						beforeSend: function() {
									$(".progress").css("display","block");
										progressbar.width('0%');
										progressbar.text('0%');
									}, 
								success : function(data,ts,xhr) { 
									progressbar.text('100%');
									progressbar.css('width','100%'); 
									$('.progress').delay(2000).fadeOut(300);
									$('#loader-icon').delay(2000).fadeOut(300);
									progressbar.text('0%');
									progressbar.css('width','0%');  
								}, 
								 xhr: function(){
									//Get XmlHttpRequest object
									 var xhr = $.ajaxSettings.xhr() ;
									//Set onprogress event handler
									 xhr.upload.onprogress = function(data){
										var perc = Math.round((data.loaded || data.position) * 100 / data.total);
										console.log(perc);
										perc = (perc - 10);
										progressbar.text(perc + '%');
										progressbar.css('width',perc + '%');
									 };
									 return xhr ;
								 },  
				 });
			
			$('#loader-icon').hide();
		}
	});
		 
</script>