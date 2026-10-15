<script>   

  $(document).ready(function(){

    var oTable=jurnalgrid("<?php echo site_url('jvoucher/jvoucherapp/controler_gridunpostlist')?>","JTable","rtip", 33, [2,7,8], [3]); 

    //new $.fn.dataTable.FixedColumns( oTable, { rightColumns: 1 } );
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

    $('#isPeriod').on('change', function() {      
        if($(this).is(':checked')){
          $('#sPeriode').prop('readonly', false);          
        }else{      
          $('#sPeriode').prop('readonly',true);          
        }
    });

    $('#isJtype').on('change', function() {      
        if($(this).is(':checked')){
          $('#jSource').prop('disabled', false);          
        }else{      
          $('#jSource').prop('disabled',true);          
        }
    });
    
    $('#jSource').val([]);
    $('#jSource').select2({placeholder: 'Select an Option'});
    $('#jSource').on('select2:select', function (e) {
        var source  = e.params.data;
        var jtype   = source.id.substring(0,2);
        //console.log(jtype);

        $('#isTSource').prop( "checked", true );
        $('#tSource').val( source.id );
        $('#jType').val(jtype);
        //$('#_hTradeLine').val(bra.rekananshipping_line);
    });

    $('#btnReload').click(function() {  

        var searchID = $("#sID").val();
        var searchJurnaltype = $("#jType").val();
        var searchJurnalsource = $("#tSource").val();        
        var searchPeriode = $("#sPeriode").val(); 
        var searchCreateby = $("#sCreateby").val(); 

        oTable.search('');     

        if( $('#isID').is(':checked') ){       
            oTable.column(0).search(searchID, true);                
        }else{            
            oTable.column(0).search('', false);    
        }
        if( $('#isJtype').is(':checked') ){       
            oTable.column(1).search(searchJurnaltype);                
        }else{            
            oTable.column(1).search('');    
        }
        if( $('#isTSource').is(':checked') ){       
            oTable.column(2).search(searchJurnalsource);                
        }else{            
            oTable.column(2).search('');    
        }
        if( $('#isPeriod').is(':checked') ){       
            oTable.column(3).search(searchPeriode);                
        }else{            
            oTable.column(3).search('');    
        } 
        if( $('#isCreate').is(':checked') ){       
            oTable.column(4).search(searchCreateby);              
        }else{             
            oTable.column(4).search('');    
        }      

        oTable.draw();

    });   

    $("#flowcheckall").click(function () {         
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
            postid.push({ id: oData[i][1] });
        }        

        grab ={};
        grab['postid'] = postid;        
         
        $.ajax({
           url      : "<?php echo site_url('jvoucher/jvoucherapp/jvoucher_unapp');?>",
           type     : "POST",             
           data     : grab,
           dataType : 'json',
           success: function(e) {              

              if (e.success){                

                display_modal('Success!', 'Data #'+e.data.id+'# has been unposted.');

                $('#modal-default').on('hidden.bs.modal', function () {              
                    location.href = "<?php echo site_url('jvoucher/jvoucherapp/jvoucherunapplist');?>";  
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

  function jurnalgrid(vlink,namatable,optsearch, pLength=10, aCenter=[], aRight=[]){
      
    var oTable=$('#'+namatable).DataTable({
      "scrollY": "300px",
      "scrollX": true,
      //"scrollCollapse": true,        
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
        { orderable: false, className: 'select-checkbox', targets: 0}        
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

 <!-- CONTENT -->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet">
          <div class="portlet-title">
            <div class="caption" align="right">
              <div class="actions">      
		            <?php echo form_open(base_url('index.php/jvoucher/jvoucherapp/controler_gridunpostlist')); ?>
		            <div class="btn-group">
                  <a id="btnPosting" class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"><i class="fa fa-bookmark"></i> UnPosting</a>
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
                          <a href="#inputdata"  id='tabdata'> INPUT </a>
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
                                  <div class="col-xs-7">
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                      <input id="isJtype" type="checkbox">Jurnal Type                                      
                                    </label>                                     
                                     <?php echo form_dropdown('jSource',$source,'','id ="jSource" class="form-control" style="width: 100%;" disabled'); ?>
                                  </div>
                                  <div class="col-xs-5">
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                    </label>                                     
                                     <input type="text" id = "jType" name="jType" class="form-control input-sm" value="" readonly>
                                  </div>
                                </div>
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-6">
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                      <input id="isPeriod" type="checkbox">Periode
                                    </label>                                     
                                    <input type="text" id = "sPeriode" name="sPeriode" class="form-control input-sm" value="" readonly>
                                  </div>
                                </div>                            
                                <div class="col-md-4 form-group form-group-sm row">
                                  <div class="col-xs-12">
                                    <label class="checkbox-inline" style="font-weight: bold;">
                                      <input id="isTSource" type="checkbox">Source
                                    </label>                                     
                                    <input type="text" id = "tSource" name="tSource" class="form-control input-sm" value="" readonly>
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
                                <table class="table table-striped table-hover nowrap" id='JTable' style="width:100%;border-color: #E0E0E0;">
                               	  <thead>
                                		<tr>
                                      <th><input type="checkbox" id="flowcheckall" value=""/></th>
                                      <th>ID</th>
                                      <th>Book Date</th>
                                      <th>Amount IDR</th>
                                  		<th>Store</th>
                                  		<th>Tenant</th>
                                      <th>Dept.</th>
                                      <th>Post.</th>
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