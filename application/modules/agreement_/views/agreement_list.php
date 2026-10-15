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

	  var oTable=listgrid("<?php echo site_url('agreement/agreement/controler_gridlist')?>","agreeTable","rtip"); 
    new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } ); 

  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  		$("#tablist").trigger('click');
  		});
		
	  $('.searching').select2();
	
    $('#statusData').on('change', function() {  
		  val_search = $('#statusData').val();
  		if ( $.fn.dataTable.isDataTable( '#agreeTable' ) ) {
  			oTable.destroy();
  			oTable=listgrid("<?php echo site_url('agreement/agreement/controler_gridlist/')?>"+val_search,"agreeTable","lfrtip");   
  		}
		  else {
			 oTable = $('#agreeTable').DataTable();
		  }	
	  });

    $('#isID').on('change', function() {      
        if($(this).is(':checked')){
          $('#sID').prop('readonly', false);          
        }else{      
          $('#sID').prop('readonly',true);          
        }
    }); 

    $('#isFree').on('change', function() {      
        if($(this).is(':checked')){
          $('#sFreetext').prop('readonly', false);          
        }else{      
          $('#sFreetext').prop('readonly',true);          
        }
    });

    $('#isTenant').on('change', function() {      
        if($(this).is(':checked')){
          $('#sTenant').prop('disabled', false);
          $('#_hTenant').val(1);
        }else{      
          $('#sTenant').prop('disabled',true);
          $('#_hTenant').val(0);
        }
    });

    $('#isTrade').on('change', function() {      
        if($(this).is(':checked')){
          $('#sTrade').prop('disabled', false);          
        }else{      
          $('#sTrade').prop('disabled',true);          
        }
    });

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

    $('#isActive').on('change', function() {      
        if($(this).is(':checked')){
          $('#sActive').prop('disabled', false);          
        }else{      
          $('#sActive').prop('disabled',true);          
        }
    });

    $('#btnReload').click(function() {  

        var searchID = $("#sID").val();
        var searchRegion = $("#sRegion").val();
        var searchBranch = $("#sStore").val();        
        var searchTenant = $("#sTenant").val(); 
        var searchBrand = $("#_hTrade").val(); 
        var searchBrandLine = $("#_hTradeLine").val(); 
        var searchFree = $("#sFreetext").val(); 

        oTable.search('');     

        if( $('#isID').is(':checked') ){       
            oTable.column(0).search(searchID, true);                
        }else{            
            oTable.column(0).search('', false);    
        }
        if( $('#isRegion').is(':checked') ){       
            oTable.column(1).search(searchRegion);                
        }else{            
            oTable.column(1).search('');    
        }
        if( $('#isStore').is(':checked') ){       
            oTable.column(2).search(searchBranch);                
        }else{            
            oTable.column(2).search('');    
        }
        if( $('#isTenant').is(':checked') ){       
            oTable.column(3).search(searchTenant);                
        }else{            
            oTable.column(3).search('');    
        } 
        if( $('#isTrade').is(':checked') ){       
            oTable.column(3).search(searchBrand);   
            oTable.column(4).search(searchBrandLine);                
        }else{            
            //oTable.column(3).search('');    
            oTable.column(4).search('');    
        }        
        if( $('#isFree').is(':checked') ){       
            oTable.search(searchFree);
        }else{               
            oTable.search('');    
        }    

        oTable.draw();

    });

    $('#sStore').select2({
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        tokenSeparators: [',', ' '],
        ajax: {
            url: '<?php echo site_url('agreement/agreement/branch_select')?>',
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
                        return {

                            text: item.branch_name,
                            region: item.region_id,
                            id: item.branch_id
                        }
                    })
                };
            }
        }
    });

    $('#sRegion').val([]);
    $('#sRegion').select2({placeholder: 'Select an Option'});
    $('#sActive').select2();

    $('#sTenant').select2({
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        tokenSeparators: [',', ' '],
        ajax: {
            url: '<?php echo site_url('agreement/agreement/tenant_select')?>',
            dataType: 'json',
            type: "GET",
            data: function (term) {
                return {
                    term: term,
                    branch: $('#sStore').val(),
                    isBranch: $('#_hStore').val(),
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.items, function (item) {
                        return {
                            text: item.rekanan_name,                            
                            id: item.rekanan_id
                        }
                    })
                };
            }
        }
    });

    $('#sTrade').select2({
        placeholder: 'Select an option',
        minimumInputLength: 2,
        minimumResultsForSearch: 10,        
        ajax: {
            url: '<?php echo site_url('agreement/agreement/trade_select')?>',
            dataType: 'json',
            type: "GET",
            data: function (term) {
                return {
                    term: term,
                    branch: $('#sStore').val(),
                    isBranch: $('#_hStore').val(),
                    rekanan: $('#sTenant').val(),
                    isRekanan: $('#_hTenant').val(),
                };
            },
            processResults: function (data, page) {
                return {
                    results: data.items                    
                };
            }            
        },
        escapeMarkup: function (markup) { return markup; },
        templateResult: function (response) {            

            if (response.id =="") return response.id;

            var markup = 
                "<div class='select2-result-repository clearfix'>" +
                  "<div class='select2-result-repository__title'>" + response.text + "</div>"+
                  "<div class='select2-result-repository__description'>" + response.rowid + "</div>" +
                  //"<div class='select2-result-repository__forks'><i class='fa fa-file-text-o margin-r-5'></i> " + response.rowid + "</div>" +
                "</div>";

            return markup;
        },
        templateSelection: function (response) {

            return response.text+ ' / '+response.rowid;
        }
    });

    $('#sTrade').on('select2:select', function (e) {
        var bra = e.params.data;    
        //console.log(bra);
        $('#_hTrade').val(bra.rekanan_id);
        $('#_hTradeLine').val(bra.rekananshipping_line);
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
  <div class="row">
    <div class="col-md-12">
      <div class="portlet">
        <div class="portlet-title">
          <div class="caption" align="right">					  
            <div class="actions">      
	          <?php echo form_open(base_url('index.php/agreement/agreement/controler_gridlist')); ?>
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
  							<div class="col-md-13">
  							  <select class="searching form-control input-sm" name="searchStatus" id="statusData" data-placeholder="Pilih Data" >
  									<option value="K">
  										Pilih Data
  									</option>									 
  									 <option value="all">
  										ALL
  									  </option> 
  									  <option value="app">
  										Approved
  									  </option>
  									  <option value="ret">
  										Returned
  									  </option> 
  									   <option value="not_app">
  										Not Approved
  									  </option>
  									  <option value="not_ret">
  										Not Returned
  									  </option> 
  							  </select> 
  							</div>  
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
                          <a href="<?php echo base_url('index.php/agreement/agreement/agreementadd'); ?>"  id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata"  id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_5_1">
                          <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-body">
                              <div class="row">
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                      <input id="isID" type="checkbox">ID(s)                                      
                                    </label>                              
                                     <textarea id = "sID" name="sID" class="form-control input-sm" rows="3" readonly></textarea>
                                  </div>
                                </div>
                                <div class="col-md-4 form-group form-group-sm row">
                                  <div class="col-xs-12">
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                      <input id="isRegion" type="checkbox">Business Unit                                      
                                    </label>                                     
                                     <?php echo form_dropdown('sRegion',$region,'','id ="sRegion" class="form-control" style="width: 100%;" disabled'); ?>
                                  </div>
                                </div>
                                <div class="col-md-4 form-group form-group-sm row">
                                  <div class="col-xs-12">
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                      <input id="isTrade" type="checkbox">Trade Name
                                      <input type="hidden" id="_hTrade" value="0" />
                                      <input type="hidden" id="_hTradeLine" value="0" />
                                    </label>                                      
                                    <select data-placeholder="Select a brand" id= "sTrade" style="width: 100%;" disabled></select>
                                  </div>
                                </div>                         
                                <div class="col-md-4 form-group form-group-sm row">
                                  <div class="col-xs-12">
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                      <input id="isStore" type="checkbox">Store
                                      <input type="hidden" id="_hStore" name="_hStore" value="0"/>
                                    </label>                                     
                                    <select data-placeholder="Select a Store" id= "sStore" style="width: 100%;" disabled></select>
                                  </div>
                                </div>
                                <div class="col-md-4 form-group form-group-sm row">
                                  <div class="col-xs-12">
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                      <input id="isTenant" type="checkbox">Tenant
                                      <input type="hidden" id="_hTenant" name="_hTenant" value="0"/>
                                    </label>                                     
                                    <select data-placeholder="Select a tenant" id= "sTenant" style="width: 100%;" disabled></select>
                                  </div>
                                </div>
                                <div class="col-md-4 form-group form-group-sm row">
                                  <div class="col-xs-12">
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                      <input id="isActive" type="checkbox">Is Active                                      
                                    </label>                                     
                                     <select data-placeholder="Select status" id= "sActive" style="width: 100%;" disabled>
                                        <option value="0">Active</option>
                                        <option value="1">Terminated</option>
                                     </select>
                                  </div>
                                </div>
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                      <input id="isFree" type="checkbox">Free Text
                                    </label>                                     
                                    <input type="text" id = "sFreetext" name="sFreetext" class="form-control input-sm" value="" readonly>
                                  </div>
                                </div>
                              </div>
                              <div class="table-container">                                
                                 <table class="table table-striped table-hover nowrap" id='agreeTable' style="width:100%;border-color: #E0E0E0;">
                                 	  <thead>
                                  		<tr>
                                        <th>ID</th>
                                        <th>Begin</th>
                                        <th>End</th>
                                        <th>TLV</th>
                                    		<th>Store</th>
                                    		<th>Tenant</th>  
                                        <th>Brand</th>  
                                        <th>App.</th>
                                        <th>Cls</th>
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
            <!-- END OF CONTENT -->