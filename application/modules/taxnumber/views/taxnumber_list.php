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

  	var oTable=listgrid("<?php echo site_url('taxnumber/taxnumber/controler_gridlist')?>","taxnumberTable","lfrtip",100);
	var regionTable=popgrid("<?php echo site_url('taxnumber/taxnumber/controler_gridregion')?>","regionLoader","trp", 10);
  var branchTable=popgrid("<?php echo site_url('taxnumber/taxnumber/controler_gridbranch')?>","branchLoader","trp", 10);

    new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } );

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
  
    $('#isRegion').on('change', function() {      
        if($(this).is(':checked')){
          $('#sRegion').prop('disabled', false);     
		  $('#btregion').prop('disabled',false);
		  
        }else{      
          $('#sRegion').prop('disabled',true);
		  $('#btregion').prop('disabled',true);
        }
    });

    $('#isStore').on('change', function() {      
        if($(this).is(':checked')){
          $('#sStore').prop('disabled', false);  
		  $('#btbranch').prop('disabled',false);
          $('#_hStore').val(1);
        }else{      
          $('#sStore').prop('disabled',true);
		  $('#btbranch').prop('disabled',true);
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

        var searchID = $("#sID").val();
        var searchRegion = $("#hregion").val();
        var searchBranch = $("#hbranch").val();        
        var searchStatus = $("#sStatus").val(); 
		var searchDisable = $("#sDisable").val(); 
		var searchIDfrom = $("#sIDfrom").val(); 
		var searchIDto = $("#sIDto").val(); 
		var searchInvoice = $("#sInvoice").val(); 

        oTable.search('');     


        if( $('#isRegion').is(':checked') ){       
            oTable.column(0).search(searchRegion);                
        }else{            
            oTable.column(0).search('');    
        }
        if( $('#isStore').is(':checked') ){       
            oTable.column(1).search(searchBranch);                
        }else{            
            oTable.column(1).search('');    
        }        
        if( $('#isStatus').is(':checked') ){       
            oTable.column(2).search(searchStatus);
        }else{               
            oTable.column(2).search('');    
        }    
        if( $('#isDisable').is(':checked') ){       
            oTable.column(3).search(searchDisable);
        }else{               
            oTable.column(3).search('');    
        }    		
        if( $('#isIDfrom').is(':checked') ){       
            oTable.column(4).search(searchIDfrom);
        }else{               
            oTable.column(4).search('');    
        } 
        if( $('#isIDto').is(':checked') ){       
            oTable.column(5).search(searchIDto);
        }else{               
            oTable.column(5).search('');    
        } 		
        if( $('#isInvoice').is(':checked') ){       
            oTable.column(6).search(searchInvoice);
        }else{               
            oTable.column(6).search('');    
        }		
        oTable.draw();

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
 
        <div class="modal" id="mdlinfo" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="mdltitle">Success!</h4>
              </div>
              <div class="modal-body" id="mdlbody">
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
                          <a href="<?php echo base_url('index.php/taxnumber/taxnumber/taxnumberadd'); ?>"  id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="<?php echo base_url('index.php/taxnumber/taxnumber/taxnumberedit'); ?>"  id='tabedit'> EDIT </a>
                        </li>
						<li>
                          <a href="<?php echo base_url('index.php/taxnumber/taxnumber/taxnumberdisable'); ?>"  id='tabdisable'> ENABLE/DISABLE </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_5_1">
                          <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-body">
							<div class="row">
							
                                <div class="col-md-4">
								<label class="checkbox-inline"><input type="checkbox" id="isRegion">Business Unit</label>
								  <div class="input-group input-group-sm">
									<input type="text" id = "iregion" name="iregion" class="form-control input-sm" value="" required autocomplete="off" readonly>
									<span class="input-group-btn">
									  <button id ="btregion" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
									</span>
								  <input type="hidden" id = "hregion" name="hregion" value="">
								  </div>
								  
                                </div>         
								
                                <div class="col-md-4">
								<label class="checkbox-inline"><input type="checkbox" id="isStore">Store</label>
								<div class="input-group input-group-sm">
								  <input type="text" id = "ibranch" name="ibranch" class="form-control input-sm" value="" required autocomplete="off" readonly>
								  <span class="input-group-btn">
									<button id ="btbranch" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
								  </span>
								<input type="hidden" id = "hbranch" name="hbranch" value="">
								</div>
                                </div>
								
								
                                <div class="col-md-4">
                                   
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                      <input id="isStatus" type="checkbox">Status                                      
                                    </label>                                     
									  <select class="form-control input-sm" name="sStatus" id="sStatus" data-placeholder="Pilih Data" disabled>
											 <option value="0">0</option>
											  <option value="1">1</option>
									  </select>
                                   
                                </div>
								
                                <div class="col-md-4">
                                   
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                      <input id="isDisable" type="checkbox">Disable                                      
                                    </label>                                     									 
									  <select class="form-control input-sm" name="sDisable" id="sDisable" data-placeholder="Pilih Data" disabled>
											 <option value="0">0</option>
											  <option value="1">1</option>
									  </select>
							  
                                </div>		


								
                                <div class="col-md-4">
                                   
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                      <input id="isIDfrom" type="checkbox">ID From
                                    </label>                                     
                                    <input type="text" id = "sIDfrom" name="sIDfrom" class="form-control input-sm" value="" readonly>
                                   
                                </div>

                                <div class="col-md-4">
                                   
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                      <input id="isIDto" type="checkbox">ID To
                                    </label>                                     
                                    <input type="text" id = "sIDto" name="sIDto" class="form-control input-sm" value="" readonly>
                                   
                                </div>
								
                                <div class="col-md-4">
                                   
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                      <input id="isInvoice" type="checkbox">No Invoice/Descr
                                    </label>                                     
                                    <input type="text" id = "sInvoice" name="sInvoice" class="form-control input-sm" value="" readonly>
                                   
                                </div>

								
                              </div>
							  <br>
                              <div class="table-container">
                                 <table class="table table-striped table-hover nowrap" id='taxnumberTable' style="border-color: #E0E0E0;">
                                 	  <thead>
                                  		<tr>
                                        <th>Region ID</th>
                                        <th>Region Name</th>
                                    	<th>Tax Number</th>
                                        <th>Status</th>
                                        <th>Branch ID</th>
                                        <th>Branch Name</th>
                                        <th>Descr</th>
                                        <th>Is Disable</th>
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
