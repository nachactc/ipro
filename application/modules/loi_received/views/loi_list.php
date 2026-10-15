<script> 
  function deleteid(val){  

     if (val == 0){

      var msj='Are you sure to drop this row?';
      if (!confirm(msj)) {

        return false;
      }   

     }else{

      return false;
     }    	
  }

  $(document).ready(function(){

  	var oTable = searchgrid("<?php echo site_url('loi_received/loi_received/controler_gridlist')?>","looTable","lfrtip", 10, [], $('#f_date'), $('#t_date'));
    
    oTable.on('processing.dt', function (e, settings, processing) {
        if (processing) {

          $.blockUI({message: $('<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>') });
        } else {         
          $.unblockUI();
        }
    });
	
  	$('#tabedit').click(function() {
  		//alert('Please, select data from list');
  		$("#tablist").trigger('click');
  	});


    $('#bSearch').on('click', function() {

        $('[data-toggle="dropdown"]').parent().removeClass('open');
        oTable.ajax.reload();
    })

    $('.tanggal').datepicker();

    $('#btcleart_1').click(function() {    

      $('#f_date').val('');     
    
    });

    $('#btcleart_2').click(function() {    

      $('#t_date').val('');     
    
    });


    $.blockUI.defaults.css = { 
        padding: 0,
        margin: 0,
        width: '30%',
        top: '40%',
        left: '35%',
        textAlign: 'center',
        cursor: 'wait'
    };

  });

  

  $(document).on('hide.bs.dropdown', function (e) {
      if ($(e.currentTarget.activeElement).hasClass('dropdown-toggle')) {
        $(e.relatedTarget).parent().removeClass('open');
        return true;
      }
      return false;
  });

  $.fn.datepicker.defaults.format = "yyyy-mm-dd";
  $.fn.datepicker.defaults.autoclose = true;

</script>

<style>
table.dataTable td {
    padding:2px;
    font-size: 9pt;    
}

</style>
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
                                  <b>Date From</b>
                                </label>
                                <div class="input-group input-group-sm">
                                  <input class="form-control tanggal" type="text" id="f_date"/>
                                  <span class="input-group-btn">
                                    <button id ="btcleart_1" type="button" class="btn btn-primary"><i class="fa fa-eraser"></i></button>
                                  </span>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="contain">
                                  <b>Date To</b>
                                </label>
                                <div class="input-group input-group-sm">
                                  <input class="form-control tanggal" type="text" id="t_date" />
                                  <span class="input-group-btn">
                                    <button id ="btcleart_2" type="button" class="btn btn-primary"><i class="fa fa-eraser"></i></button>
                                  </span>
                                </div>
                              </div>
                              <div class="form-group">
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
                          <a href="<?php echo base_url('index.php/loi_received/loi_received/loireceived_add'); ?>"  id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata"  id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_5_1">
                           <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-body">
                              <div class="table-container">								 
                                 <table class="table table-striped table-hover nowrap" id='looTable' style="border-color: #E0E0E0;">
                                 	  <thead>
                                  		<tr>
                                        <th>ID.LOO</th>
                                    	  <th>B. Unit</th>
                                        <th>Store</th>
                                        <th>Tenant</th>
                                        <th>Brand</th>
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
              <!-- END OF CONTENT -->