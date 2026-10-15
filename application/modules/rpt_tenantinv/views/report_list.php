  <title> Report_Tenant </title>
  <link href="<?php echo base_url()."assets/css/" ?>jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url()."assets/css/" ?>buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
 <script>  
  $(document).ready(function(){ 
  	  $('#looTable').DataTable( {
		"scrollY": 480,
        "scrollX": true,
		"pageLength": 50,
		 dom: 'Bfrtip',
        buttons: [
             'excel',  'print'
        ],
		
    } );
  });
  

</script> 
          <!-- CONTENT -->
            <div class="row">
              <div class="col-md-12">
                <div class="portlet">
                  <div class="portlet-body"> 
                      <div class="tab-content">   
                              <div class="table-container">
                                <div class="table-scrollable"> 
                                 <table class="display nowrap" id='looTable' style="width:100%">
                               		<thead>
                                  		<tr>
                                        <th>ID</th>
                                        <th>Tenant</th>
                                        <th>Brand</th>
                                        <th>Email</th>
                                        <th>Inv.Send.Addr</th>
                                    	  <th>Inv.Name</th>
                                        <th>Inv.NPWP</th>
                                        <th>Inv.NPWP.Addr</th>
                                        <th>Faktur Name</th>
                                    	<th>Faktur NPWP</th>
                                    	<th>Faktur NPWP.Addr</th>                       
                                  		</tr>              
              				        </thead>
									<tbody>
										<?php  
										if($result != 'kosong'): 
												foreach($result as $row): ?>
										<tr>
											<td> <?php echo $row->rekanan_id; ?> </td>
											<td> <?php echo $row->rekanan_name; ?> </td>
											<td> <?php echo $row->rekananshipping_name; ?> </td>
											<td> <?php echo $row->email; ?> </td>
											<td> <?php echo $row->inv_send; ?> </td>
											<td> <?php echo $row->inv_npwp_name; ?> </td>
											<td> <?php echo $row->inv_npwp; ?> </td>
											<td> <?php echo $row->inv_npwp_addr; ?> </td>
											<td> <?php echo $row->fak_npwp_name; ?> </td>
											<td> <?php echo $row->fak_npwp; ?> </td>
											<td> <?php echo $row->fak_npwp_addr; ?> </td> 
										</tr>
										<?php endforeach; endif;?>
									</tbody>
                              	 </table>  
                                </div>                              
                              </div>   
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <!-- END OF CONTENT -->