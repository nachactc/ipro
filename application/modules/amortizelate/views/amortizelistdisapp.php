<script> 
function deleteid(){
	var msj='Are you sure to delete this row?';
   if (!confirm(msj)) {       
      return false;
   }
}



  $(document).ready(function(){

  	var oTable = appgrid("","agrTable","rtip", [], [])

    $.get("<?php echo site_url('amortizelate/amortizelate/controler_gridlistdisapp'); ?>",
          '', 
          function(d){          
               oTable.clear();               
               oTable.rows.add(d.data);                   
               oTable.draw();
    }, 'json' );



    $('#bSearch').click(function() {

       $('[data-toggle="dropdown"]').parent().removeClass('open');

		oTable.clear().draw()
		var tid=$('#sFreetext').val();
		var sreg=$('#sRegion').val();
		var sstore=$('#sStore').val();
		var ssid=$('#sID').val();
		var sstrade=$('#_hTrade').val();
		var ssline=$('#_hTradeLine').val();
		
		var ssdate=$('#sdate').val();
		var sedate=$('#edate').val();
		var stenant=$('#sTenant').val();
		
		
		

       $.get("<?php echo site_url('amortizelate/amortizelate/controler_gridlistdisapp'); ?>",
              'uid='+tid+'&sRegion='+sreg+'&sStore='+sstore+'&sID='+ssid+'&sTrade='+sstrade+'&ssline='+ssline+'&ssdate='+ssdate+'&sedate='+sedate+'&stenant='+stenant, 
              function(d){                   
                   oTable.clear();
                   oTable.rows.add(d.data);                   
                   oTable.draw();
        }, 'json' );

    })

 $.fn.datepicker.defaults.format = "yyyy-mm-dd";
  $.fn.datepicker.defaults.autoclose = true;

  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  		$("#tablist").trigger('click');
  	});

    $('#btnApprove').click(function() {

        var postid = [];
        var pRow = new Array();
        var oData = oTable.rows('.selected').data();     
		var jdate=	$('#jdate').val();	
           
        if(oData.length === 'undefined' || oData.length === 0)
        {
            display_modal('Alert!', 'Please select at least one item.');   
            return false;         
        }       
        
        for (var i=0; i < oData.length ;i++){           

            postid.push({id: oData[i][1], line_id:oData[i][3],agtype_id: oData[i][2],vjdate: jdate});
        }        

//alert(postid[0]['agtype_id']);
//return false;
        grab ={};
        grab['postid'] = postid;  
		
         
        $.ajax({
           url      : "<?php echo site_url('amortizelate/amortizelate/agreement_disapp');?>",
           type     : "POST",             
           data     : grab,
           dataType : 'json',
           success: function(e) {              

              if (e.success){                

                display_modal('Success!', 'Data #'+e.data.id+'# has been unposted.');

                $('#modal-default').on('hidden.bs.modal', function () {              
                    location.href = "<?php echo site_url('amortizelate/amortizelate/amortizelistdisapp');?>";  

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

  $(document).on('hide.bs.dropdown', function (e) {
      if ($(e.currentTarget.activeElement).hasClass('dropdown-toggle')) {
        $(e.relatedTarget).parent().removeClass('open');
        return true;
      }
      return false;
  });

  function appgrid(vlink,namatable,optsearch, hide=[], aCenter=[], pLength=10){    
      
    var oTable=$('#'+namatable).DataTable({     
      "pageLength": pLength, 
      "order": [],
      "processing": true,
      columnDefs: [
        { "targets": [ -1 ], "orderable": false },
        { "targets": hide, "visible": false },
        { orderable: false, className: 'select-checkbox', targets: 0},
        { targets: aCenter, className: 'text-center'}
      ],      
      select: {
          style:    'multi',
          selector: 'td:first-child'
      },
      dom:'Blfrtip',
	buttons: [
                    'selectAll',
                    'selectNone'
                ],	  
      });

    return oTable;
  }
  

</script>

<style>
table.dataTable td {
    padding:2px;
    font-size: 9pt;    
}

</style>

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

          <!-- CONTENT -->
            <div class="row">
              <div class="col-md-12">
                <div class="portlet">
                  <div class="portlet-title">
                    <div class="caption" align="right">
                      <div class="actions">                        
                        <a href="javascript:;" class="btn green" id="btnApprove">
                        <i class="fa fa-file-o"></i> Un Posting </a>
                        
                        <div class="btn-group">
                          <a id="bSearch" class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"><i class="fa fa-history"></i> Search             
                </a>
                          
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
                          <a href="javascript:;"  id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata"  id='tabedit'> VIEW </a>
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
                                      <input id="isID" type="checkbox">Agreement ID                                      
                                    </label>                              
                                     <textarea id = "sID" name="sID" class="form-control input-sm" rows="3"></textarea>
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
                                </div>
                                 <div class="row">
                               <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label><b>Jurnal Date</b></label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="jdate" name="jdate" >
                                      </div>
                                    </div>
                                  </div>  
                                <div class="col-md-4 form-group row">
                                  <div class="col-xs-12">
                                    <label style="font-weight: bold;">
                                      Amortisasi ID
                                    </label>                                     
                                    <input type="text" id = "sFreetext" name="sFreetext" class="form-control input-sm" >
                                  </div>
                                </div>
                                </div>
								  <div class="row">
                               <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label><b>Start Period</b></label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="sdate" name="sdate" >
                                      </div>
                                    </div>
                                  </div> 
								  
								  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label><b>End Period</b></label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="edate" name="edate" >
                                      </div>
                                    </div>
                                  </div> 
								  
								 </div>
                                
                              <div class="table-container">
                                <div class="table-scrollable"> 
                                 <table class="table table-striped table-hover nowrap" id='agrTable' style="border-color: #E0E0E0;">
                               		<thead>
                                  		<tr>
                                        <th>Checked</th>
                                        <th>Amortisasi ID</th>
                                        <th>Type</th>
                                        <th>Line</th>
                                        <th>Agreement ID</th>
                                        <th>Agreement Type</th>
                                        <th>Tenant Name</th>
                                        <th>Shop Name</th>
                                    	<th>Date</th>
                                        <th>IDR</th>
                                    	<th>Descr</th>
                                    	<th>INV ID</th>                     
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
            </div>
              <!-- END OF CONTENT -->