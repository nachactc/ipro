<script>

function validateb4submit(){
  var max=GetDgvLineMaxNum('locDetil',0);
  if (max < 1 ){
    alert('Please, Add Term & Condition !');
    return false;
  }
}

$(document).ready(function(){

  $('#ilease').select2({placeholder: 'Choose lease agreement.. '});

  $('#iregion').select2({
    placeholder: 'Select a business unit',
    containerCssClass: ':all:'
  });

  $('#ibranch').select2({
      placeholder: 'Select an option',
      minimumInputLength: 2,
      //tags: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('loc_atm/loc_atm/branch_select')?>',
          dataType: 'json',
          type: "GET",
          data: function (term) {
              return {
                  term: term
              };
          },
          processResults: function (data) {
              return {
                  results: $.map(data.items, function (item) {

                        console.log(data.items);
                      return {                        

                          text: item.branch_name,
                          //slug: item.slug,
                          id: item.branch_id
                      }
                  })
              };
          }
      }
  });

  $("#itenant").on('keydown paste', function(e){
      e.preventDefault();
  });  

  $("#ibrand").on('keydown paste', function(e){
    e.preventDefault();
  });

  $("#tabedit").trigger('click');

  var arrid= [];
  //lfrtip =default
  var oTable=listgrid("<?php echo site_url('loc_atm/loc_atm/controler_griddialog')?>","uLoader","trp", 7);

  var rTable=listgrid("<?php echo site_url('loc_atm/loc_atm/controler_gridpop')?>","popLoader","trp", 6);

  $('#btnload').click( function() {    
      var searchName = $("#sUnitName").val();              
      var searchID  = $("#sID").val();

      oTable.search(searchName).draw();
      oTable.search(searchID).draw();
  });

  $('#bttenant').click(function() {    
    rTable.rows('.selected').deselect();
    $("#tedialog").modal("show");
  });

  $('#btdetil').click(function() {
    oTable.rows('.selected').deselect();
    $("#mdldialog").modal("show");
  });  
  
  $('#tabedit').click(function() {
    alert('Please, select data from list');
  });       

  $('#btdialog').click(function () { 

      var linenum=0;
      var oData = oTable.rows('.selected').data();

       for (var i=0; i < oData.length ;i++){
        
          var rid=oData[i][0];
          var runit=oData[i][1];
          var rsize=oData[i][2];
          var rlantai=oData[i][3];          
           
          var max=GetDgvLineMaxNum('locDetil',0)
          linenum= Number(max) + 10;
          var t="tcharge"+linenum;          

          $('#locDetil tbody').append('<tr>'+
            '<td>' + linenum + '<input type="hidden" name="tline[]" value="'+ linenum +'" readonly class="nogaris"/></td>'+
            '<td>'+ rlantai +'<input type="hidden" name="tlantai[]" value="" readonly class="nogaris"/></td>'+
            '<td>'+ runit +'<input type="hidden" name="tunit[]" value="'+ rid +'" readonly class="nogaris"/></td>'+
            '<td>'+ rsize +'<input type="hidden" name="tsize[]" value="'+ rsize +'" readonly class="nogaris"/></td>'+           
            '<td><?php echo form_dropdownext('tatype[]', $agrtype, $this->input->post('tatype'),'id="tatype" class="form-control" required');?>'+
            '<td><input type="text" name="tcharge[]" id= "'+ t +'" value="0" class="form-control" style= "text-align: right;" /></td>'+ 
            '<td><a id= "btnDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');

          $('#'+t).number( true, 2 );
              //arrid.push(vid);
      }

  });  

  $('#addtenant').click(function () { 

      var linenum=0;
      var rData = rTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){
        
          var tid     = rData[i][0];
          var tname   = rData[i][1];
          var tline   = rData[i][2];
          var tbrand   = rData[i][3];  

          $('#htenant').val(tid);
          $('#itenant').val(tname);
          $('#hbrand').val(tline);
          $('#ibrand').val(tbrand);           
      }

  });  

  $("#locDetil").on('click','#btnDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }
      $(this).closest('tr').remove();  
  });

  $('#btnApprove').click(function() {

      if ($('#ipict').val() === '') {        
          display_modal('Alert!', 'Please upload a file to sign this document!');
          return false;
      }

      var pRow = new Array();
      var arrCon  = [];

      pRow[0]     = $('#locid').val();
      pRow[1]     = $('#iregion').val();
      pRow[2]     = $('#ibranch').val();
      pRow[3]     = $('#ipict').val();

      arrCon.push(pRow);

      grab ={};
      grab['arrCon'] = arrCon;

      $.ajax({
         url      : "<?php echo site_url('loc_atm/locconf/loc_conf');?>",
         type     : "POST",             
         data     : grab,
         dataType : 'json',
         success: function(e) {
           //console.log(e);
            display_modal('Success!', 'Data #'+e.data.id+'# has been signed.');

            $('#modal-default').on('hidden.bs.modal', function () {              
              location.href = "<?php echo site_url('loc_atm/locconf');?>";  
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
          url: '<?php echo site_url('loc_atm/loc_atm/uploadjpg')?>',
          dataType: 'json',
          autoUpload: false,
          acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
          maxFileSize: 999000,
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
                        <i class="fa fa-file-o"></i><?php echo $tabpost ?></a>
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
                          <a href="<?php echo base_url('index.php/loc_atm/'.$cont); ?>" id='tablist'> LIST </a>
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
                         <form action="<?php echo site_url('loc_atm/loc_atm/loc_edit');?>" method="post" onsubmit="">
                            <?php 
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>                                   
                    <div class="row">
                        <div class="col-md-12">   
                                <div class="col-md-4 form-group row">                               
                                  <div class="col-xs-12">
                                      <label>ID</label>
                                    <input  type="text" id="locid" name="loc_id" class="form-control input-sm" value="<?php echo $row->loc_id;?>" readonly />
                                  </div> 
                                </div>                                    
                                  <!-- /.form group -->   
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Date</label>   
                                    <div class="input-group date" data-provide="datepicker">                                                    
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                      <input type="text" class="form-control input-sm pull-right" id="loc_date" name="loc_date" value = "<?php echo $row->loc_date;?>">    
                                     </div>  
                                  </div>                                                                      
                                </div>
                                <div class="col-md-4 form-group row">
                                   <div class="col-xs-12">                                   
                                      <label class="checkbox-inline"><input type="checkbox" <?php if ($row->isconfirm == 1) echo 'checked= "checked"';?> disabled>Returned</label>
                                      <label class="checkbox-inline"><input type="checkbox" <?php if ($row->isapproved == 1 ) echo 'checked= "checked"';?> disabled>Approved</label>
                                   </div>
                                  </div>
                                <div class="row"></div> 
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Start Date</label>   
                                    <div class="input-group date" data-provide="datepicker">                                                    
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                      <input type="text" class="form-control input-sm pull-right" id="loc_sdate" name="loc_sdate" value = "<?php echo $row->loc_sdate;?>">    
                                     </div> 
                                  </div>                                                                       
                                </div>  
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>End Date</label>
                                    <div class="input-group date" data-provide="datepicker">                                                    
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                      <input type="text" class="form-control input-sm pull-right" id="loc_edate" name="loc_edate" value = "<?php echo $row->loc_edate;?>">    
                                     </div>
                                  </div>
                                </div>                                
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Term Period</label>
                                    <input type="text" id = "loc_term" name="loc_term" class="form-control input-sm" value="<?php echo $row->loc_term;?>">
                                  </div>
                                </div>      
                                <div class="row"></div>                          
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Business Unit</label>
                                    <?php echo form_dropdown('cboregion',$region,$row->region_id,'id ="iregion" class="form-control" style="width: 100%;" required'); ?>
                                  </div>
                                </div>
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Store</label>
                                      <select data-placeholder="Select a store" id= "ibranch" name= "cbobranch" required>
                                        <option value="<?php echo $row->branch_id;?>" selected="selected" ><?php echo $row->branch_name;?></option>
                                      </select>
                                    </div> 
                                  </div>
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label>Lease Agreement</label>
                                      <?php echo form_dropdown('cbolease',$lotype,'','id ="ilease" class="form-control" style="width: 100%;" required'); ?>
                                  </div>
                                </div>
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <a href="javascript:void(0)" id="bttenant"><strong>Tenant:</strong></a>                                  
                                    <input type="text" id = "itenant" required name="itenant" class="form-control input-sm" value="<?php echo $row->rekanan_name;?>" required autocomplete="off">
                                    <input type="hidden" id = "htenant" name="htenant" value="<?php echo $row->rekanan_id;?>">
                                  </div>
                                </div>
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                      <label></label>
                                      <input type="text" id = "ibrand" name="ibrand" class="form-control input-sm" value="<?php echo $row->rekananshipping_name;?>" required autocomplete="off">
                                      <input type="hidden" id = "hbrand" name="hbrand" value="<?php echo $row->rekananshipping_line;?>">
                                  </div>
                                </div>
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                      <label>Picture Name:</label>
                                      <input type="text" id = "ipict" name="ipict" class="form-control input-sm" value="" readonly required autocomplete="off">
                                  </div>
                                </div>
                                <br>
                                <div class="col-md-12 form-group row">
                                  <div class="col-xs-12">
                                    <span class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Add files...</span>
                                    <!-- The file input field used as target for the file upload widget -->
                                    <input id="fileupload" type="file" name="files" multiple>                                    
                                    </span>
                                  </div>
                                </div>
                                <!-- The global progress bar -->
                                <div class="col-md-12 form-group row">
                                  <div class="col-xs-12">
                                    <div id="progress" class="progress">
                                      <div class="progress-bar progress-bar-success"></div>
                                    </div>
                                  </div>
                                </div>
                                <br>
                                <!-- The container for the uploaded files -->
                                <div class="col-md-12 form-group row">
                                  <div class="col-xs-12">
                                    <div id="files" class="files"></div>
                                  </div>
                                </div>
                                 <div class="col-md-12">                                   
                                 <br>
                                 <a></a>
                                 <a href="javascript:void(0)" id="btdetil"><strong>Add Detil</strong></a>   
                                 <br>
                                    <!-- Custom Tabs -->
                                    <div class="nav-tabs-custom">
                                      <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab_1" data-toggle="tab" role= "tab">Detail</a></li>  
                                        <li><a href="#tab_2" data-toggle="tab" role = "tab">Record</a></li>                                        
                                      </ul>
                                      <div class="tab-content">  
                                        <div class="tab-pane active" id="tab_1">                                        
                                          <div class ="table-responsive">
                                              <table class="table table-bordered table-striped" id='locDetil' style="border:solid 1px #999; #999; border-radius:0px; ">
                                                <thead>
                                                  <tr>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Unit</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Size</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Term & Condition</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Charge</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Int.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Time</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Descr</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Delete</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <?php if(isset($resultd)){
                                                      foreach($resultd as $rowd){
                                                  ?>
                                                    <tr>
                                                    <td><?php echo "$rowd->locdetil_line";?><input type="hidden" name="tline[]" value="<?php echo "$rowd->locdetil_line";?>"/></td>
                                                    <td><?php echo "$rowd->unit_name";?><input type="hidden" name="tunit[]" value="<?php echo "$rowd->unit_id";?>" /></td>
                                                    <td><?php echo "$rowd->locdetil_space";?><input type="hidden" name="tsize[]" value="<?php echo "$rowd->locdetil_space";?>"/></td>
                                                    <td><?php echo form_dropdownext('tatype[]',$agrtype,"$rowd->agreementtype_id",'id="tatype" class="form-control input-sm" required');?></td>
                                                    <td><input type="text" name="tcharge[]" id= "tcharge<?php echo "$rowd->locdetil_line";?>" value="<?php echo "$rowd->locdetil_baserent";?>" class="form-control input-sm" style= "text-align: right;" /></td>
                                                    <td><input type="text" name="tint[]" value="<?php echo "$rowd->locdetil_int";?>" class="form-control input-sm" style= "text-align: right;" /></td>
                                                    <td><?php echo form_dropdownext('titype[]',$titype,"$rowd->timetype_id",'id="titype" class="form-control input-sm" required');?></td>
                                                    <td><input type="text" name="tdescr[]" value="<?php echo "$rowd->locdetil_descr";?>" class="form-control input-sm"/></td>
                                                    <td><a id= "btnDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
                                                    </tr>
                                                    <script>
                                                    $('#tcharge<?php echo "$rowd->locdetil_line";?>').number( true, 2 );
                                                    </script>
                                                  <?php
                                                     }                                                  
                                                   } 
                                                  ?>
                                                </tbody>
                                              </table>
                                          </div>
                                        </div>                                        
                                        <div class="tab-pane" id="tab_2">
                                          <div class="row">
                                           <div class="col-md-6">
                                            <div class="col-xs-8">
                                               <label>Create By</label>
                                               <input type="text" id= "_createby" name="_createby" class="form-control input-sm" value="<?php echo $row->_createby;?>">
                                            </div>
                                           </div>  
                                           <div class="col-md-6">
                                            <div class="col-xs-8">
                                               <label>Create Date</label>
                                               <input type="text" name="_createdate" class="form-control input-sm" value="<?php echo $row->_createdate;?>">
                                            </div>
                                            </div>                             
                                           <div class="col-md-6">
                                            <div class="col-xs-8">
                                               <label>Modify By</label>
                                               <input type="text" id= "_modifyby"  name="_modifyby" class="form-control input-sm" value="<?php echo $row->_modifyby;?>">
                                            </div>
                                           </div> 
                                           <div class="col-md-6">
                                            <div class="col-xs-8">
                                               <label>Modify Date</label>
                                               <input type="text" name="_modifydate" class="form-control input-sm" value="<?php echo $row->_modifydate;?>">
                                            </div>
                                           </div> 
                                           </div>                               
                                        </div>                                                    
                                        <!-- /.tab-pane -->                                          
                                      </div>
                                      <!-- /.tab-content -->
                                    </div>
                                    <!-- nav-tabs-custom -->
                                  </div>
                                    <!-- /.col -->
                                <div class="col-xs-12">
                                    <br /><input type="submit" value="SUBMIT" class="btn btn-sm btn-info" disabled/>
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
              <!-- END OF CONTENT -->