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

  	var oTable=listgrid("<?php echo site_url('postdate/postdate/controler_gridlist')?>","postdateTable","lfrtip");

    new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } );



  });



</script>

<style>
table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

.DTFC_LeftBodyLiner {

overflow-x: hidden;

}

.DTFC_RightBodyLiner {

overflow-x: hidden;

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
 
                           



                        <?php echo form_close(); ?>

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
                          <a href="<?php echo base_url('index.php/postdate/postdate/postdateadd'); ?>"  id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="<?php echo base_url('index.php/postdate/postdate/postdateedit'); ?>"  id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_5_1">
                          <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-body">
                              <div class="table-container">
                                 <table class="table table-striped table-hover nowrap" id='postdateTable' style="border-color: #E0E0E0;">
                                 	  <thead>
                                  		<tr>
										<th>Periode</th>
                                        <th>Posting Date</th>
										<th>Due Date</th>
										<th>Type</th>
                                        <th>Descr</th>
                                        <th>Is Disable</th>										
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
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
