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

	  var oTable=casualpostgrid("<?php echo site_url('agreement_posting/casualpost/controler_gridpostlist')?>","casualTable","rtip"); 
    new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } ); 

  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  		$("#tablist").trigger('click');
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

    $('.select-checkbox').on('click', 'input', function() { 

      if ($(this).is( ":checked" )) {            
          oTable.rows().select();        
      } else {
          oTable.rows().deselect(); 
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
            url: '<?php echo site_url('agreement_posting/casualpost/branch_select')?>',
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
            url: '<?php echo site_url('agreement_posting/casualpost/tenant_select')?>',
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
            url: '<?php echo site_url('agreement_posting/casualpost/trade_select')?>',
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

    $('#btnPosting').click(function() {

        var postid = [];
        var pRow = new Array();
        var oData = oTable.rows('.selected').data();        
          
        if(oData.length === 'undefined' || oData.length === 0)
        {
            display_modal('Alert!', 'Please select at least one item.');   
            return false;         
        }       

        for (var i=0; i < oData.length ;i++){ 
            postid.push({ id: oData[i][1], line: oData[i][2]});
        }        

        grab ={};
        grab['postid'] = postid;        
        
        $.ajax({
            url      : "<?php echo site_url('agreement_posting/casualpost/casualpost_post');?>",
            type     : "POST",             
            data     : grab,
            dataType : 'json',
            success: function(e) {              

              if (e.success){                

                display_modal('Success!', 'Data #'+e.data.id+'# has been posted.');

                $('#modal-default').on('hidden.bs.modal', function () {              
                    oTable.draw();
                }) 
              }
			   else
			  {
					display_modal('Warning!',  e.data.id +' . Data Tidak Bisa Di Posting!.');

					$('#modal-default').on('hidden.bs.modal', function () {              
						location.href = "<?php echo site_url('agreement_posting/casualpost/casualpostlist');?>";   
					})   
			  }
            },
            error: function(xhr) {              
                if (xhr.status == 500) {                      
                  alert('Internal error.');
                } else {
                  alert('Unexpected error.');
                }                 
            }          
        }); 

    });

    function display_modal(title, message){
       $("#modal-default").modal("show");
       $("#sucTitle").show().html(title);
       $("#sucBody").show().html(message);
    }
	
  });

  function casualpostgrid(vlink,namatable,optsearch, pLength=10, aCenter=[], aRight=[], hiCol=[]){
    
    var oTable=$('#'+namatable).DataTable({
      "scrollY": "350px",
      "scrollX": true,
      "scrollCollapse": true,          
      "pageLength": pLength,
      "processing": true, 
      "serverSide": true, 
      "order": [],
      "searching" : true,
      "ajax": {
        "url": vlink,
        "type": "POST"  
      },      
      "columnDefs": [
        { "targets": [ -1 ], "orderable": false },
        { "targets": aCenter, "className": "text-center" },
        { "targets": aRight, "className": "text-right" },
        { orderable: false, className: 'select-checkbox', targets: 0},
        { "targets": hiCol, "visible": false }
      ],
      select: {
          style:    'multi',
          selector: 'td:first-child'
      },
      dom:optsearch
      });

    return oTable;
  }
  

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

<!-- MODAL -->
<div class="modal fade" id="modal-default">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sucTitle">Success!</h4>
      </div>
      <div class="modal-body" id="sucBody">
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
<!-- END MODAL -->


 <!-- CONTENT -->
  <div class="row">
    <div class="col-md-12">
      <div class="portlet">
        <div class="portlet-title">
          <div class="caption" align="right">					  
            <div class="actions">      
	          <?php echo form_open(base_url('index.php/agreement_posting/casualpost/controler_gridpostlist')); ?>
              <div class="btn-group">
                <a id="btnPosting" class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"><i class="fa fa-bookmark"></i> Posting</a>
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
                          <a href="<?php echo base_url('index.php/agreement_posting/agreement_posting/casualadd'); ?>"  id='tabdata'> INPUT </a>
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
                                 <table class="table table-striped table-hover nowrap" id='casualTable' style="width:100%;border-color: #E0E0E0;">
                                 	  <thead>
                                  		<tr>
                                        <th><input type="checkbox" id="flowcheckall" value=""/></th>
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