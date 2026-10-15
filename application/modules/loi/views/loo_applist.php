<script> 
function deleteid(){
	var msj='Are you sure to delete this row?';
   if (!confirm(msj)) {       
      return false;
   }
}

  $(document).ready(function(){

  	var oTable = foogrid("","looTable","lfrtip", [7,8,9])

    $.get("<?php echo site_url('loo/looapp/controler_gridlist'); ?>",
          '', 
          function(d){          
               oTable.clear();               
               oTable.rows.add(d.data);                   
               oTable.draw();
    }, 'json' );

    $('#bSearch').click(function() {

    $('[data-toggle="dropdown"]').parent().removeClass('open');

       oTable.clear().draw()

       $.get("<?php echo site_url('loo/looapp/controler_gridlist'); ?>",
              'uid= '+$('select[name="cbounit"]').val(), 
              function(d){                   
                   oTable.clear();
                   oTable.rows.add(d.data);                   
                   oTable.draw();
        }, 'json' );

    })


  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  		$("#tablist").trigger('click');
  	});

    $('#btnApprove').click(function() {

        var postid = [];
        var pRow = new Array();
        var oData = oTable.rows('.selected').data();

        for (var i=0; i < oData.length ;i++){
          
            pRow[0]   = oData[i][0];
            pRow[1]   = oData[i][7];
            pRow[2]   = oData[i][8];
             
            postid.push(pRow);
            //arrid.push(vid);
        }        

        grab ={};
        grab['postid'] = postid;
         
        $.ajax({
           url      : "<?php echo site_url('loo/looapp/loo_app');?>",
           type     : "POST",             
           data     : grab,
           dataType : 'json',
           success: function(e) {

              display_modal('Success!', 'Data #'+e.data.id+'# has been approved.');

              $('#modal-default').on('hidden.bs.modal', function () {              
                location.href = "<?php echo site_url('loo/looapp');?>";  
              }) 
           },
           error: function(xhr) {
               //console.log(d.statusText);
                if (xhr.status == 500) {                      
                  alert('Internal error.');
                    //display_modal('Internal error:', xhr.responseText);
                } else {
                    //display_modal('You have an error', xhr.responseText);
                    alert('Unexpected error.');
                }                 
           }          
        }); 

    });

    function display_modal(title, message){
       $("#modal-default").modal("show");
       $('.modal-title').show().html(title);
       $('.modal-body').show().html(message);
    }

  });

  $(document).on('hide.bs.dropdown', function (e) {
      if ($(e.currentTarget.activeElement).hasClass('dropdown-toggle')) {
        $(e.relatedTarget).parent().removeClass('open');
        return true;
      }
      return false;
  });
  

</script>

<style>
table.dataTable td {
    padding:2px;
    font-size: 9pt;    
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
                  <div class="portlet-title">
                    <div class="caption" align="right">
                      <div class="actions">
                        <a href="javascript:;" class="btn green" id="btnApprove">
                        <i class="fa fa-file-o"></i> Approve </a>
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
                                  Select Unit
                                </label>
                                <?php echo form_dropdown('cbounit',$unit,'','class="form-control"'); ?>
                                <br>
                                <button type="search" class="btn blue" id="bSearch">
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
                          <a href="#tab_5_1" data-toggle="tab" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="javascript:;"  id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata"  id='tabedit'> VIEW </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_5_1">
                          <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-body">
                              <div class="table-container">
                                <div class="table-scrollable"> 
                                 <table class="table table-striped table-hover nowrap" id='looTable' style="border-color: #E0E0E0;">
                               		<thead>
                                  		<tr>
                                        <th>ID</th>
                                    		<th>Date</th>
                                        <th>Term</th>
                                        <th>Region</th>
                                    		<th>Store</th>
                                    		<th>Tenant</th>  
                                        <th>Brand</th>  
                                        <th>Reg.ID</th> 
                                        <th>Branch.ID</th> 
                                        <th>U.ID</th> 
                                        <th>Action</th>                      
                                  		</tr>              
              				            </thead>
                                		<tbody>
                                		</tbody>
                              	 </table>  
                                </div>                              
                              </div>
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