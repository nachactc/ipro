<script src="<?php echo base_url('/assets/js/bootbox/bootbox.min.js');?>"></script>
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

   
	$('#looTable').DataTable({
      "scrollY": "350px",
      "scrollX": true,       
      "pageLength": 20,
      "processing": true, 
      "serverSide": true, 
      "order": [],
      "searching" : true,
	  "ordering": false, 
	  "bLengthChange": false,
		<?php 
		if ($_POST){
		?>
		"ajax": {
			"url": "<?php echo base_url('index.php/').$this->uri->segment(1).'/'.$this->uri->segment(2).'/controler_gridlist_unappr'; ?>",
			"type": "POST",
			"data": { 
				jurnal_id :  "<?php echo $this->input->post("sID");?>",
				jurnal_source :  "<?php echo $this->input->post("jSource");?>",
				jurnaltype_id :  "<?php echo $this->input->post("jType");?>",
				periode_id :  "<?php echo $this->input->post("sPeriode");?>",
				jurnal_createby :  "<?php echo $this->input->post("sCreateby");?>",
			},
			"dataType": 'json'
		},	
		<?php
		}else{
		?>
		"ajax": {
			"url": "<?php echo base_url('index.php/').$this->uri->segment(1).'/'.$this->uri->segment(2).'/controler_gridlist_unappr'; ?>",
			"type": "POST"  
		},
		<?php	
		}
		?>	
	
      "columnDefs": [
        {
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
        // {
          // "targets": aCenter,
          // "className": "text-center"
        // },
        // {
          // "targets": aRight,
          // "className": "text-right"
        // }        
      ], 
	  // dom:'rtip'
      });
	  
	
  	$('#tabedit').click(function() {
  		//alert('Please, select data from list');
  		$("#tablist").trigger('click');
  		});


    $('#bSearch').on('click', function() {

        $('[data-toggle="dropdown"]').parent().removeClass('open');

        oTable.ajax.reload();

    })

    $('.tanggal').datepicker();

    $('#btcleart_1').click(function() {    

      $('#f_date').val('');     
    
    });

    $('#btcleart_2').click(function() {    

      $('#t_date').val('');     
    
    });

  });

  

  $(document).on('hide.bs.dropdown', function (e) {
      if ($(e.currentTarget.activeElement).hasClass('dropdown-toggle')) {
        $(e.relatedTarget).parent().removeClass('open');
        return true;
      }
      return false;
  });

  $.fn.datepicker.defaults.format = "yyyy-mm-dd";
  $.fn.datepicker.defaults.autoclose = true;

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
                  <div class="portlet-title"> 
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
                          <a href="#"  id='tabdata'> INPUT </a>
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
								  <table class="table table-striped table-hover responsive nowrap" id='looTable' style="width:100%;border-color: #E0E0E0;">
                                 	  <thead>
                                  		<tr>
										<th>Status</th>
                                        <th>Tenant</th>
                                        <th>Brand</th>
										<th>Schedule Payment</th>
										<th>Invoice No.</th>
                                        <th>Amount</th>
                                        <th>Disc(Percent)</th>
										<th>Disc IDR</th>
										<th>Posted</th>
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
              <!-- END OF CONTENT -->