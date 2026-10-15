<script>

$(document).ready(function(){  

  $("#tabedit").trigger('click');

  
  $('#tabedit').click(function() {
    alert('Please, select data from list');
  });       


      uploadButton = $('<button/>')
          .addClass('btn btn-primary')
          .prop('disabled', true)
          .text('Processing...')
          .on('click', function () {
              var $this = $(this),
                  data = $this.data();
              $this
                  .off('click')
                  .text('Abort')
                  .on('click', function () {
                      $this.remove();
                      data.abort();
                  });
              data.submit().always(function () {
                  $this.remove();
              });
          });
      $('#fileupload').fileupload({
          url: '<?php echo site_url('loo/loo/uploadjpg')?>',
          dataType: 'json',
          autoUpload: false,
          acceptFileTypes: /(\.|\/)(gif|jpe?g|png|pdf)$/i,
          maxFileSize: 5097152,
          // Enable image resizing, except for Android and Opera,
          // which actually support image resizing, but fail to
          // send Blob objects via XHR requests:
          disableImageResize: /Android(?!.*Chrome)|Opera/
              .test(window.navigator.userAgent),
          previewMaxWidth: 100,
          previewMaxHeight: 100,
          previewCrop: true
      }).on('fileuploadadd', function (e, data) {
          data.context = $('<div/>').appendTo('#files');
          $.each(data.files, function (index, file) {
              var node = $('<p/>')
                      .append($('<span/>').text(file.name));
              if (!index) {
                  node
                      .append('<br>')
                      .append(uploadButton.clone(true).data(data));
              }
              node.appendTo(data.context);
          });
      }).on('fileuploadprocessalways', function (e, data) {
          var index = data.index,
              file = data.files[index],
              node = $(data.context.children()[index]);
          if (file.preview) {
              node
                  .prepend('<br>')
                  .prepend(file.preview);
          }
          if (file.error) {
              node
                  .append('<br>')
                  .append($('<span class="text-danger"/>').text(file.error));
          }
          if (index + 1 === data.files.length) {
              data.context.find('button')
                  .text('Upload')
                  .prop('disabled', !!data.files.error);
          }
      }).on('fileuploadprogressall', function (e, data) {
          var progress = parseInt(data.loaded / data.total * 100, 10);
          $('#progress .progress-bar').css(
              'width',
              progress + '%'
          );
      }).on('fileuploaddone', function (e, data) {
          $.each(data.result.files, function (index, file) {           
              if (file.url) {
                  var link = $('<a>')
                      .attr('target', '_blank')
                      .prop('href', file.url);
                  $(data.context.children()[index])
                    .wrap(link);
                  //$('<p/>').text(file.name).appendTo('#files').wrap(link);
                  $('#ipict').val(file.name);

              } else if (file.error) {
                  var error = $('<span class="text-danger"/>').text(file.error);
                  $(data.context.children()[index])
                      .append('<br>')
                      .append(error);
              }
          });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
          .parent().addClass($.support.fileInput ? undefined : 'disabled');

  
  $.fn.datepicker.defaults.format = "yyyy-mm-dd"; 
  $.fn.datepicker.defaults.autoclose = true;

  function display_modal(title, message){
     $("#modal-default").modal("show");
     $('.modal-title').show().html(title);
     $('.modal-body').show().html(message);
  }

});
$(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );
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
                       <label>ID</label>
                      <input  type="text" id="sID" class="form-control" placeholder="Search Unit" >
                    </div>
                    <div class="col-md-4">
                      <label>Unit</label>
                      <input  type="text" id="sUnitName" class="form-control" placeholder="Search ID" >
                    </div>
                    <div class="col-md-4" align="right">
                      <br>
                      <input type="button" id="btnload" value = "LOAD" class="btn btn-sm btn-info"/>
                    </div>  
              </div>

                           <div class="portlet-body">
                            <div class="table-container">
                            <table class="table table-striped table-bordered table-hover" id='uLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                              <thead>
                               <tr>
                                <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
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

                    <!-- /.popup-tenant -->
                    <div class="modal fade" id="tedialog" tabindex="-1" role="basic" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            </button>
                            <h4 class="modal-title">
                              Data Tenant
                            </h4>
                          </div>
                          <div class="modal-body">
                            <form action="#" id="form" class="form-horizontal">
                            <div class="row">
                            <div class="col-md-4">
                               <label>ID</label>
                              <input  type="text" id="sID" class="form-control" placeholder="Search ID" >
                            </div>
                            <div class="col-md-4">
                              <label>Name</label>
                              <input  type="text" id="sName" class="form-control" placeholder="Search Name" >
                            </div>
                            <div class="col-md-4" align="right">
                              <br>
                              <input type="button" id="btnpop" value = "LOAD" class="btn btn-sm btn-info"/>
                            </div>  
                          </div>
                           <div class="portlet-body">
                            <div class="table-container">
                            <table class="table table-striped table-bordered table-hover" id='popLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                              <thead>
                               <tr>
                                <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                                <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
                                <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Brand</th>
                               </tr>
                              </thead>
                              <tbody>      
                              </tbody>
                            </table>
                            </div>
                        </div>
                        <br />
                        </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">
                              Close
                            </button>
                            <button type="button" class="btn green" data-dismiss="modal" id="addtenant">
                              Add Selected Data
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
                        <a href="javascript:;" class="btn green" id="btnApprove">
                        <i class="fa fa-file-o"></i></a>
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
                          <a href="<?php echo base_url('index.php/loo/'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="#" id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata" data-toggle="tab" id='tabedit'> VIEW </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        
                        <div class="tab-pane" id="editdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('loo/loo/loo_edit');?>" class= "form-horizontal" method="post" onsubmit="">
                            <?php 
                              if(isset($result)){
                               //print_r($result);
                               foreach($result as $row){ ?>                                   
                          <div class="row">
                              <div class="col-md-12">   
                                <div class="form-group">
                                  <label class="control-label col-sm-2">ID:</label>
                                  <div class="col-sm-10">
                                    <input  type="text" id="looid" name="loo_id" class="form-control input-sm" value="<?php echo $row->loo_id;?>" readonly />
                                  </div> 
                                </div>
                                <div class="form-group">
                                  <div class="col-sm-12">
                                    <div class="input-group">                                      
                                      <span class="input-group-btn">
                                        <span class="btn fileinput-button btn-sm">                                          
                                          <i class="glyphicon glyphicon-plus"></i>
                                          <span>LOO Signed...</span>
                                          <!-- The file input field used as target for the file upload widget -->
                                          <input id="fileupload" type="file" name="files" multiple>          
                                          <input type="text" id = "ipict" name="ipict" class="form-control input-sm" value="" readonly>                          
                                        </span>
                                      </span>
                                    </div>                           
                                  </div>
                                  <br>                          
                                  <br> 
                                  <!-- The global progress bar -->                                  
                                  <div class="col-sm-12">
                                    <div id="progress" class="progress">                                      
                                      <div class="progress-bar progress-bar-success"></div>
                                    </div>
                                  </div>
                                  <!-- The container for the uploaded files -->                                
                                  <div class="col-sm-2"></div>
                                  <div class="col-sm-10">
                                    <div id="files" class="files"></div>
                                    <br>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-sm-12">
                                    <div class="input-group">                                      
                                      <span class="input-group-btn">
                                        <span class="btn fileinput-button btn-sm">                                          
                                          <i class="glyphicon glyphicon-plus"></i>
                                          <span>LOI Signed...</span>
                                          <!-- The file input field used as target for the file upload widget -->
                                          <input id="fileupload" type="file" name="files" multiple>                                    
                                        </span>
                                      </span>
                                      <input type="text" id = "ipict" name="ipict" class="form-control input-sm" value="" readonly>
                                    </div>                           
                                  </div>
                                  <br>                          
                                  <br> 
                                  <!-- The global progress bar -->                                  
                                  <div class="col-sm-12">
                                    <div id="progress" class="progress">                                      
                                      <div class="progress-bar progress-bar-success"></div>
                                    </div>
                                  </div>
                                  <!-- The container for the uploaded files -->                                
                                  <div class="col-sm-2"></div>
                                  <div class="col-sm-10">
                                    <div id="files" class="files"></div>
                                    <br>
                                  </div>
                                </div>
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
            </div>
            <!-- END OF CONTENT -->