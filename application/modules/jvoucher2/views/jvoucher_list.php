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

    var obj = {
      jurnalID : $('#sID'),
      isJurnal : $('#isID'),
      jurnalType : $('#jType'), 
      isType: $('#isJtype'),
      jurnalSource : $('#tSource'),
      isSource : $('#isTSource'), 
      periodeID : $('#sPeriode'), 
      isPeriod : $('#isPeriod'),
      createBy : $('#sCreateby'),
      isCreate : $('#isCreate')
    }

    var oTable = jurnalgrid("<?php echo site_url('jvoucher2/jvoucher2/controler_gridlist')?>","JTable","rtip", 15, [1], [2], obj); 

    //new $.fn.dataTable.FixedColumns( oTable, { rightColumns: 1 } );
  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  		$("#tablist").trigger('click');
  	});
		
	  $('.searching').select2();
	
    /*
    oTable.on('processing.dt', function (e, settings, processing) {

      if (processing) {

        $.blockUI({message: $('<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>') });
      } else {         
        $.unblockUI();
      }
    });
    */
      

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

        oTable.search('');     

        /*
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
        */     

        oTable.draw();

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

  function jurnalgrid(vlink, namatable, optsearch, pLength=10, aCenter=[], aRight=[], objSearch){
    
    var selected = [];
      $('#'+namatable+' tbody').on( 'click', 'tr', function () {
          $(this).toggleClass('selected');
      } );
      
    var oTable=$('#'+namatable).DataTable({
      //"scrollY": "300px",
      //"scrollX": true,
      //"scrollCollapse": true,  
      autoWidth: false,      
      pageLength: pLength,
      processing: true, 
      serverSide: true, 
      order: [],
      searching: true,
      ajax: {
        url: vlink,
        type: "POST",
        data: (obj) => {

          let jurnal_id = '';
          let jurnaltype_id = '';
          let jurnal_source = '';
          let periode_id = '';
          let jurnal_createby = '';

          if (objSearch.isJurnal.is(':checked')) {
            jurnal_id = objSearch.jurnalID.val();
          }
          if (objSearch.isType.is(':checked')) {
            jurnaltype_id = objSearch.jurnalType.val();
          }
          if (objSearch.isSource.is(':checked')) {
            jurnal_source = objSearch.jurnalSource.val();
          }
          if (objSearch.isPeriod.is(':checked')) {
            periode_id = objSearch.periodeID.val();
          }
          if (objSearch.isCreate.is(':checked')) {
            jurnal_createby = objSearch.createBy.val();
          }

          obj.searchList = {
            jurnal_id : jurnal_id,
            jurnaltype_id : jurnaltype_id,
            jurnal_source : jurnal_source,
            periode_id : periode_id,
            jurnal_createby : jurnal_createby
          } 
        }
      },
      rowCallback: function( row, data ) {
                if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
                    $(row).addClass('selected');                    
                }
      },
      columnDefs: [
        { targets: [ -1 ], width: '15px', orderable: false },
        { targets: aCenter, className: 'text-center', orderable: false },
        { targets: aRight,  className: 'text-right', orderable: false },
        { targets: [2], width: 'auto', orderable: false },
        { targets: [3], width: '100px', orderable: false },
        { targets: [4], width: '100px', orderable: false },
        { targets: [5], width: '100px', orderable: false }
      ],
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

table#JTable.dataTable tbody tr:hover {
  background-color: #fddf66 !important;
}

table#JTable.dataTable tbody>tr.selected {
  /* background: #FF8C00 !important; */
  background-image: linear-gradient(to top, rgb(47, 72, 214, 0.5) 30%, rgba(47, 72, 214, 0.7) 100%);
}
</style>
 <!-- CONTENT -->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet">
          <div class="portlet-title">
            <div class="caption" align="right">
              <div class="actions">      
		            <?php echo form_open(base_url('index.php/jvoucher2/jvoucher2/controler_gridlist')); ?>
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
                          <a href="<?php echo base_url('index.php/jvoucher2/jvoucher2/jvoucheradd'); ?>"  id='tabdata'> INPUT </a>
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
                                <table class="table table-striped responsive hover compact nowrap" id='JTable' style="width:100%;border-color: #E0E0E0;">
                               	  <thead>
                                		<tr>
                                      <th>ID</th>
                                      <th>Book Date</th>
                                      <th>Amount IDR</th>
                                  		<th>Store</th>
                                  		<th>Tenant</th>
                                      <th>Dept.</th>
                                      <!--<th>Post.</th>-->
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