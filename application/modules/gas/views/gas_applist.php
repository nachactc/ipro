<script> 

  $(document).ready(function(){

    var oTable= gasappgrid("<?php echo site_url('gas/gasapp/controler_gridapplist')?>","gasTable","rtip", 100, [], [8,9,10,11,12], [2]);    
    var rTable = $('#rekLoader').DataTable();

    new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 3 } );

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

    $('#isCreate').on('change', function() {      
        if($(this).is(':checked')){
          $('#sCreateby').prop('readonly', false);          
        }else{      
          $('#sCreateby').prop('readonly',true);          
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

    $('#isTenant').on('change', function() {      
        if($(this).is(':checked')){
          $('#sTenant').prop('readonly', false);
          $('#bTenant').prop('disabled', false);
        }else{      
          $('#sTenant').prop('readonly', true);
          $('#bTenant').prop('disabled', true);
        }
    });

    $('#isBrand').on('change', function() {      
        if($(this).is(':checked')){
          $('#sBrand').prop('readonly', false);
          $('#bBrand').prop('disabled', false);
        }else{      
          $('#sBrand').prop('readonly', true);
          $('#bBrand').prop('disabled', true);
        }
    });

    $('#bTenant').click(function() {

        rTable.destroy();
        rTable= checkgrid("<?php echo site_url('listrik/listrikapp/controler_gridrek')?>","rekLoader","trp", 10, [], $('#sStore'), $('#sStore'));    
        rTable.rows().deselect();

        $("#redialog").modal("show");          
    });

    $('#bBrand').click(function() {
        rTable.destroy();
        rTable= checkgrid("<?php echo site_url('listrik/listrikapp/controler_gridrek')?>","rekLoader","trp", 10, [], $('#sStore'), $('#sStore'));    
        rTable.rows().deselect();

        $("#redialog").modal("show");          
    });

    $('#btnrek').click(function() {
        var searchTenant  = $("#searchTenant").val();

      rTable.search(searchTenant).draw();
    });

    $('#addrek').click(function () {

        var linenum=0;
        var rData = rTable.rows('.selected').data();

        for (var i=0; i < rData.length ;i++){

            var tid       = rData[i][1];
            var tname     = rData[i][2];
            var tline     = rData[i][3];
            var tbrand    = rData[i][4];
            var tdebtor   = rData[i][5];          

            $('#hTenant').val(tid);
            $('#sTenant').val(tname);
            $('#hBrand').val(tline);
            $('#sBrand').val(tbrand);
            //$('#idebtor').val(tdebtor);
        }

        $('#isBrand').prop( "checked", true );
        $('#isTenant').prop( "checked", true );
    });


    $('#btnReload').click(function() {  

        var searchID = $("#sID").val();
        var searchRegion = $("#sRegion").val();
        var searchBranch = $("#sStore").val();        
        var searchRekanan = $("#hTenant").val(); 
        var searchShipping = $("#hBrand").val(); 
        var searchCreateby = $("#sCreateby").val(); 

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
            oTable.column(3).search(searchRekanan);                
        }else{            
            oTable.column(3).search('');    
        } 
        if( $('#isBrand').is(':checked') ){       
            oTable.column(4).search(searchShipping);              
        }else{             
            oTable.column(4).search('');    
        }      
        if( $('#isCreate').is(':checked') ){       
            oTable.column(5).search(searchCreateby);              
        }else{             
            oTable.column(5).search('');    
        }

        oTable.draw();

    });    

    $('.select-checkbox').on('click', 'input', function() {          
        if ($(this).is( ":checked" )) {
            oTable.rows().select();        
        } else {
            oTable.rows().deselect(); 
        }
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
            url      : "<?php echo site_url('gas/gasapp/gasapp_app');?>",
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
	
    $('#sRegion').val([]);
    $('#sRegion').select2({placeholder: 'Select an Option'});
    $('#sStore').select2({
        minimumInputLength: 2,
        minimumResultsForSearch: 10,
        tokenSeparators: [',', ' '],
        allowClear: true,
        ajax: {
            url: '<?php echo site_url('listrik/listrikapp/branch_select')?>',
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

    function display_modal(title, message){
       $("#modal-default").modal("show");
       $("#sucTitle").show().html(title);
       $("#sucBody").show().html(message);
    }

  });

  function gasappgrid (vlink,namatable,optsearch, pLength=10, aCenter=[], aRight=[], hiCol=[]){
      
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

<!-- /.popup-tenant -->
<div class="modal fade" id="redialog" tabindex="-1" role="basic" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Data Tenant</h4>
      </div>
      <div class="modal-body">
        <form action="#" id="form" class="form-horizontal">
          <div class="row">
            <div class="col-md-8">
              <label>Search Tenant || Brand</label>
              <input  type="text" id="searchTenant" class="form-control input-sm" placeholder="Search Tenant" >
            </div>                           
            <div class="col-md-4" align="right">
              <br>                              
              <button id="btnrek" type="button" class="btn btn-sm btn-primary" style="margin-right: 5px;" >
              <i class="fa fa-history"></i> LOAD
              </button>
            </div>
          </div>
          <div class="portlet-body">
            <div class="table-container">
              <div class="table-scrollable">
                <table class="table table-striped table-bordered table-hover compact nowrap" id='rekLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                  <thead>
                    <tr>
                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">&nbsp;#</th>
                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Brand</th>
                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Deb No.</th>
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
        <button type="button" class="btn green" data-dismiss="modal" id="addrek">
          Add Selected Data
        </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.popup-tenant -->

 <!-- CONTENT -->
<div class="row">
  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-title">
        <div class="caption" align="right">
				  <div class="actions">      
						<?php echo form_open(base_url('index.php/gasapp/listrikapp/controler_gridapplist')); ?>
            <div class="btn-group">
                <a id="btnPosting" class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"><i class="fa fa-bookmark"></i> Posting</a>
                </div>
						<div class="btn-group">
                <a id="btnReload" class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"><i class="fa fa-history"></i> Re-load</a>
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
              <a href="#newdata"  id='tabdata'> INPUT </a>
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
                         <textarea id = "sID" name="sID" class="form-control input-sm" rows="3" readonly ></textarea>
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
                          <input id="isTenant" type="checkbox"> Tenant                                     
                        </label> 
                        <div class="input-group input-group-sm">                                    
                          <input type="text" id = "sTenant" name="sTenant" class="form-control" value="" readonly>
                          <input type="hidden" id="hTenant" name="hTenant" value=""/>
                          <span class="input-group-btn">
                            <button id ="bTenant" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
                          </span> 
                        </div>
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
                          <input id="isBrand" type="checkbox"> Brand                                     
                        </label> 
                        <div class="input-group input-group-sm">                                    
                          <input type="text" id = "sBrand" name="sBrand" class="form-control" value="" readonly>
                          <input type="hidden" id="hBrand" name="hBrand" value=""/>
                          <span class="input-group-btn">
                            <button id ="bBrand" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
                          </span> 
                        </div>
                      </div>                      
                    </div>                    
                    <div class="col-md-4 form-group row">
                      <div class="col-xs-12">
                        <label class="checkbox-inline" style="font-weight: bold;">
                          <input id="isCreate" type="checkbox">Create By
                        </label>                                     
                        <input type="text" id = "sCreateby" name="sCreateby" class="form-control input-sm" value="" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="table-container">                                
                    <table class="table table-striped nowrap" id='gasTable' style="border-color: #E0E0E0;width: 100%">
                      <thead>
                    		<tr>
                          <th><input type="checkbox" id="flowcheckall" value="" /></th>
                          <th>ID</th>
                          <th>Line</th>
                          <th>Date</th>
                      		<th>B. Unit</th>
                      		<th>Store</th>  
                          <th>Tenant Name</th>
                          <th>Brand Name</th>
                          <th>Stand Akhir</th>
                          <th>Pemakaian</th>
                          <th>Pemakaian[lalu]</th>
                          <th>Pemakaian[avg]</th>
                          <th>Jumlah</th>
                          <th>Berita Acara</th>
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