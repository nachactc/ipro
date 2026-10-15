<script> 
function deleteid(){
	var msj='Are you sure to delete this row?';
   if (!confirm(msj)) {       
      return false;
   }
}



  $(document).ready(function(){

  	var oTable = appgrid("","agrTable","lfrtip", [6,7,8], [2,3,4])

    $.get("<?php echo site_url('agreementverify/agreementverify/controler_gridlist'); ?>",
          '', 
          function(d){          
               oTable.clear();               
               oTable.rows.add(d.data);                   
               oTable.draw();
    }, 'json' );



    $('#bSearch').click(function() {

       $('[data-toggle="dropdown"]').parent().removeClass('open');

       oTable.clear().draw()

       $.get("<?php echo site_url('agreementverify/agreementverify/controler_gridlist'); ?>",
              'uid= '+$('select[name="cbounit"]').val(), 
              function(d){                   
                   oTable.clear();
                   oTable.rows.add(d.data);                   
                   oTable.draw();
        }, 'json' );

    })


  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  		$("#tablist").trigger('click');
  	});

    $('#btnApprove').click(function() {

        var postid = [];
        var pRow = new Array();
        var oData = oTable.rows('.selected').data();        
           
        if(oData.length === 'undefined' || oData.length === 0)
        {
            display_modal('Alert!', 'Please select at least one item.');   
            return false;         
        }       
        
        for (var i=0; i < oData.length ;i++){           

            postid.push({id: oData[i][1], ref_id: '', ren_no: ''});
        }        

        grab ={};
        grab['postid'] = postid;        
         
        $.ajax({
           url      : "<?php echo site_url('agreementverify/agreementverify/agreement_app');?>",
           type     : "POST",             
           data     : grab,
           dataType : 'json',
           success: function(e) {              

              if (e.success){                

                display_modal('Success!', 'Data #'+e.data.id+'# has been posted.');

                $('#modal-default').on('hidden.bs.modal', function () {              
                    location.href = "<?php echo site_url('agreementverify/agreementverify/agreementapplist');?>";  

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
        { orderable: false, className: '', targets: 0},
        { targets: aCenter, className: 'text-center'}
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

</style>

      

          <!-- CONTENT -->
            <div class="row">
              <div class="col-md-12">
                <div class="portlet">
                 
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
                              <div class="table-container">
                                <div class="table-scrollable"> 
                                 <table class="table table-striped table-hover nowrap" id='agrTable' style="border-color: #E0E0E0;">
                               		<thead>
                                  		<tr>
                                        <th>ID</th>
                                        <th>Status Verification</th>
                                        <th>Post</th>
                                        <th>Close</th>
                                        <th>Tenant Name</th>
                                        <th>Shop Name</th>
                                    		<th>Debtor No.</th>
                                        <th>Region</th>
                                    		<th>Store Location</th>
                                    		<th>Contract Number.</th>  
                                        <th>Start Date.</th>  
                                        <th>End Date.</th> 
                                        <th>[Term]</th> 
                                        <th>Base Rent.</th> 
                                        <th>Total Lease Value</th> 
                                        <th>Descr</th> 
                                        <th>Create By</th> 
                                        <th>Create Date</th> 
                                        <th>Modify By</th> 
                                        <th>Modify Date</th> 
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
            </div>
              <!-- END OF CONTENT -->