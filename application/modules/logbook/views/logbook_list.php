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

  	var oTable=listgrid("<?php echo site_url('logbook/logbook/controler_gridlist')?>","logbookTable","lfrtip");
  var tenantTable=popgrid("<?php echo site_url('logbook/logbook/controler_gridtenant')?>","popLoader","trp", 10);
  var regionTable=popgrid("<?php echo site_url('logbook/logbook/controler_gridregion')?>","regionLoader","trp", 10);
  var branchTable=popgrid("<?php echo site_url('logbook/logbook/controler_gridbranch')?>","branchLoader","trp", 10);
  var brandTable=popgrid("<?php echo site_url('logbook/logbook/controler_gridbrand')?>","brandLoader","trp", 10);	

    new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } );

    $('#isRegion').on('change', function() {      
        if($(this).is(':checked')){
          $('#sRegion').prop('disabled', false);          
        }else{      
          $('#sRegion').prop('disabled',true);          
        }
    });

    $('#isStore').on('change', function() {      
        if($(this).is(':checked')){
          $('#sStore').prop('disabled', false);  
          $('#_hStore').val(1);
        }else{      
          $('#sStore').prop('disabled',true);
          $('#_hStore').val(0);
        }
    });
	
    $('#isStatus').on('change', function() {      
        if($(this).is(':checked')){
          $('#sStatus').prop('disabled', false);          
        }else{      
          $('#sStatus').prop('disabled',true);          
        }
    });
    $('#isDisable').on('change', function() {      
        if($(this).is(':checked')){
          $('#sDisable').prop('disabled', false);          
        }else{      
          $('#sDisable').prop('disabled',true);          
        }
    });
    $('#isIDfrom').on('change', function() {      
        if($(this).is(':checked')){
          $('#sIDfrom').prop('readonly', false);          
        }else{      
          $('#sIDfrom').prop('readonly',true);          
        }
    });

    $('#isIDto').on('change', function() {      
        if($(this).is(':checked')){
          $('#sIDto').prop('readonly', false);          
        }else{      
          $('#sIDto').prop('readonly',true);          
        }
    });

    $('#isInvoice').on('change', function() {      
        if($(this).is(':checked')){
          $('#sInvoice').prop('readonly', false);          
        }else{      
          $('#sInvoice').prop('readonly',true);          
        }
    });
	
    $('#btnReload').click(function() {  

        var searchRegion = $("#hregion").val();
        var searchBranch = $("#hbranch").val();        
        var searchTenant = $("#htenant").val(); 
		var searchBrand = $("#hbrand").val(); ; 

        oTable.search('');     

      
            oTable.column(0).search(searchRegion);                      
            oTable.column(1).search(searchBranch);                              
            oTable.column(2).search(searchTenant);        
            oTable.column(3).search(searchBrand);   		
		 	
        oTable.draw();

    });

      $('#cbunit').change(function(){
        if($(this).is(':checked')){
            $('#btregion').prop('disabled',false);
        } else {
            //alert('not checked');
            //$('#iregion').prop('readonly',false);
            $('#btregion').prop('disabled',true);
            $('#hregion').val('');
            $('#iregion').val('');
        }
      })
	  
      $('#cbranch').change(function(){
        if($(this).is(':checked')){
            $('#btbranch').prop('disabled',false);
        } else {
            $('#btbranch').prop('disabled',true);
            $('#hbranch').val('');
            $('#ibranch').val('');
        }
      })
      $('#ctenant').change(function(){
        if($(this).is(':checked')){
            $('#bttenant').prop('disabled',false);
        } else {
            $('#bttenant').prop('disabled',true);
            $('#htenant').val('');
            $('#itenant').val('');
        }
      })
      $('#cbrand').change(function(){
        if($(this).is(':checked')){
            $('#btbrand').prop('disabled',false);
        } else {
            $('#btbrand').prop('disabled',true);
            $('#hbrand').val('');
            $('#ibrand').val('');
        }
      })

	  $('#bttenant').click(function() {
		var search  = $("#hbranch").val();
		tenantTable.search(search).draw();
		//tenantTable.rows('.selected').deselect();
		$("#tedialog").modal("show");
	  });

	  $('#btregion').click(function() {
		regionTable.rows('.selected').deselect();
		$("#regiondialog").modal("show");
	  });

	  $('#btbranch').click(function() {

		var search  = $("#hregion").val();
		branchTable.search(search).draw();
		//branchTable.rows('.selected').deselect();
		$("#storedialog").modal("show");
	  });

	  $('#btbrand').click(function() {
		var search  = $("#htenant").val();
		brandTable.search(search).draw();
		//brandTable.rows('.selected').deselect();
		$("#branddialog").modal("show");
	  });


  $('#addtenant').click(function () {
      var linenum=0;
       var rData = tenantTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid     = rData[i][0];
          var tname   = rData[i][1];

          $('#htenant').val(tid);
          $('#itenant').val(tname);

          $('#hbrand').val('');
          $('#ibrand').val('');
          $('#hagrtype').val('');
          $('#iagrtype').val('');
      }
  });

  $('#addregion').click(function () {
      var linenum=0;
       var rData = regionTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid     = rData[i][0];
          var tname   = rData[i][1];

          $('#hregion').val(tid);
          $('#iregion').val(tname);

          $('#hbranch').val('');
          $('#ibranch').val('');
          $('#htenant').val('');
          $('#itenant').val('');
          $('#hbrand').val('');
          $('#ibrand').val('');
          $('#hagrtype').val('');
          $('#iagrtype').val('');
      }
  });

  $('#addstore').click(function () {
      var linenum=0;
       var rData = branchTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid     = rData[i][0];
          var tname   = rData[i][1];

          $('#hbranch').val(tid);
          $('#ibranch').val(tname);

          $('#htenant').val('');
          $('#itenant').val('');
          $('#hbrand').val('');
          $('#ibrand').val('');
          $('#hagrtype').val('');
          $('#iagrtype').val('');
      }
  });

  $('#addbrand').click(function () {
      var linenum=0;
       var rData = brandTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid     = rData[i][0];
          var tname   = rData[i][1];
		  var tdebtor   = rData[i][2];

          $('#hbrand').val(tid);
          $('#ibrand').val(tname);
		  $('#idebtor').val(tdebtor);
      }
  });
  
	  
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

.clearfix:before, .clearfix:after { content: " "; display: table; }
.clearfix:after { clear: both; }

.select2-result-repository { padding-top: 4px; padding-bottom: 3px; }
.select2-result-repository__title { color: black; font-weight: bold; word-wrap: break-word; line-height: 1.1; margin-bottom: 4px; }
.select2-result-repository__description { font-size: 13px; color: #777; margin-top: 4px; }
.select2-result-repository__forks { margin-right: 1em; }
.select2-result-repository__forks { display: inline-block; color: #aaa; font-size: 11px; }
.select2-results__option--highlighted .select2-result-repository__title { color: white; }
.select2-results__option--highlighted .select2-result-repository__forks, 
.select2-results__option--highlighted .select2-result-repository__description { color: #c2d7e9; }

label {
  font-size: 9pt;
  font-weight: bold;
}

</style>
 <!-- CONTENT -->
 
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
           <div class="col-md-8">
              <label>Search Tenant</label>
             <input  type="text" id="searchTenant" class="form-control input-sm" placeholder="Search Tenant" >
           </div>
           <div class="col-md-4" align="right">
             <br>
             <input type="button" id="btnrek" value = "LOAD" class="btn btn-sm btn-info"/>

           </div>
         </div>

        <div class="portlet-body">
         <div class="table-container">
           <div class="table-scrollable">
             <table class="table table-striped table-bordered table-hover compact nowrap" id='popLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
               <thead>
                <tr>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
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
         <button type="button" class="btn green" data-dismiss="modal" id="addtenant">
           Add Selected Data
         </button>
       </div>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>

 <!-- /.popup-region -->
 <div class="modal fade" id="regiondialog" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         </button>
         <h4 class="modal-title">
           Data Business Unit
         </h4>
       </div>
       <div class="modal-body">
         <form action="#" id="form" class="form-horizontal">
           <div class="row">
           <div class="col-md-8">
              <label>Search Business Unit</label>
             <input  type="text" id="searchRegion" class="form-control input-sm" placeholder="Search Region" >
           </div>
           <div class="col-md-4" align="right">
             <br>
             <input type="button" id="btnregion" value = "LOAD" class="btn btn-sm btn-info"/>
           </div>
         </div>

        <div class="portlet-body">
         <div class="table-container">
           <div class="table-scrollable">
             <table class="table table-striped table-bordered table-hover compact nowrap" id='regionLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
               <thead>
                <tr>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Name</th>
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
         <button type="button" class="btn green" data-dismiss="modal" id="addregion">
           Add Selected Data
         </button>
       </div>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>
 
 		
 <!-- /.popup-branch -->
 <div class="modal fade" id="storedialog" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         </button>
         <h4 class="modal-title">
           Data Store
         </h4>
       </div>
       <div class="modal-body">
         <form action="#" id="form" class="form-horizontal">
           <div class="row">
           <div class="col-md-8">
              <label>Search Store</label>
             <input  type="text" id="searchStore" class="form-control input-sm" placeholder="Search Store" >
           </div>
           <div class="col-md-4" align="right">
             <br>
             <input type="button" id="btnstore" value = "LOAD" class="btn btn-sm btn-info"/>
           </div>
         </div>

        <div class="portlet-body">
         <div class="table-container">
           <div class="table-scrollable">
             <table class="table table-striped table-bordered table-hover compact nowrap" id='branchLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
               <thead>
                <tr>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Name</th>
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
         <button type="button" class="btn green" data-dismiss="modal" id="addstore">
           Add Selected Data
         </button>
       </div>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>

 <!-- /.popup-Shipping -->
 <div class="modal fade" id="branddialog" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         </button>
         <h4 class="modal-title">
           Data Brand
         </h4>
       </div>
       <div class="modal-body">
         <form action="#" id="form" class="form-horizontal">
           <div class="row">
           <div class="col-md-8">
              <label>Search Brand</label>
             <input  type="text" id="searchbrand" class="form-control input-sm" placeholder="Search Brand" >
           </div>
           <div class="col-md-4" align="right">
             <br>
             <input type="button" id="btnbrand" value = "LOAD" class="btn btn-sm btn-info"/>
           </div>
         </div>

        <div class="portlet-body">
         <div class="table-container">
           <div class="table-scrollable">
             <table class="table table-striped table-bordered table-hover compact nowrap" id='brandLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
               <thead>
                <tr>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Name</th>
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
         <button type="button" class="btn green" data-dismiss="modal" id="addbrand">
           Add Selected Data
         </button>
       </div>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>
 
            <div class="row">
              <div class="col-md-12">
                <div class="portlet">
                  <div class="portlet-title">
                    <div class="caption" align="right">
                      <div class="actions">
                        
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
						<div class="btn-group">
							<a id="btnReload" class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"><i class="fa fa-history"></i> Re-load              
							</a>              
						  </div>

                         

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
                          <a href="<?php echo base_url('index.php/logbook/logbook/logbookadd'); ?>"  id='tabdata'> INPUT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_5_1">
                          <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-body">
							<div class="row">
							

							  <div class="col-md-4">

								  <label class="checkbox-inline"><input type="checkbox" id="cbunit">Business Unit</label>
								  <div class="input-group input-group-sm">
									<input type="text" id = "iregion" name="iregion" class="form-control input-sm" value="" required autocomplete="off" readonly>
									<span class="input-group-btn">
									  <button id ="btregion" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
									</span>
								  <input type="hidden" id = "hregion" name="hregion" value="">
								  </div>
							  </div>    
								
							<div class="col-md-4">
								<label class="checkbox-inline"><input type="checkbox" id="cbranch">Store</label>
								<div class="input-group input-group-sm">
								  <input type="text" id = "ibranch" name="ibranch" class="form-control input-sm" value="" required autocomplete="off" readonly>
								  <span class="input-group-btn">
									<button id ="btbranch" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
								  </span>
								<input type="hidden" id = "hbranch" name="hbranch" value="">
								</div>
							</div>

							<div class="col-md-4">
								<label class="checkbox-inline"><input type="checkbox" id="ctenant">Tenant</label>
								<div class="input-group input-group-sm">
								  <input type="text" id = "itenant" name="itenant" class="form-control input-sm" value="" required autocomplete="off" readonly>
								  <span class="input-group-btn">
									<button id ="bttenant" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
								  </span>
								<input type="hidden" id = "htenant" name="htenant" value="">
								</div>
							</div>

							<div class="col-md-4">
								<label class="checkbox-inline"><input type="checkbox" id="cbrand">Brand</label>
								<div class="input-group input-group-sm">
								  <input type="text" id = "ibrand" name="ibrand" class="form-control input-sm" value="" required autocomplete="off" readonly>
								  <span class="input-group-btn">
									<button id ="btbrand" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
								  </span>
								<input type="hidden" id = "hbrand" name="hbrand" value="">
								</div>
							</div>
				
                              </div>
							  <br>
                              <div class="table-container">
                                 <table class="table table-striped table-hover nowrap" id='logbookTable' style="border-color: #E0E0E0;">
                                 	  <thead>
                                  		<tr>
                                        <th>Log ID</th>
                                        <th>Region Name</th>
                                        <th>Branch Name</th>
                                        <th>Rekanan Name</th>
                                        <th>Shipping Name</th>
                                        <th>Deptor No</th>

                                        <th>Telp Date</th>
                                        <th>Telp  No</th>
                                    	<th>Result</th>
                                        <th>Create By</th>										
                                        <th>Create Date</th>
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
