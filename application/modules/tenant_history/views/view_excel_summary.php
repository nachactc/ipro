<?php  
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
	header('Content-Type: application/vnd.ms-excel');  
	header("Content-Disposition: attachment; filename=$title.xls"); 
?>
                    <table class="table table-hover table-scroll table-bordered table-striped table-condensed flip-content " >
                      <thead class="flip-content">
                        <tr>
                          <th width="60%">
                            Category
                          </th>
                          <th class="numeric">
                            TOTAL NLA
                          </th>
                          <th class="numeric" width="70%">
                            OCC   
                          </th>
                          <th class="numeric">
                            VAC  
                          </th>
                          <th class="numeric">
                            TOTAL TENANT
                          </th>
                          <th class="numeric">
                            TRI PROCESS
                          </th> 
                          <th class="numeric">
                            NOT YET SIGNED
                          </th>
                          <th class="numeric">
                            SIGNED
                          </th>
                          <th class="numeric">
                            NO DP
                          </th>
                          <th class="numeric">
                            DP
                          </th>
                          <th class="numeric">
                            NO SECDEP
                          </th>
                          <th class="numeric">
                            SECDEP
                          </th>
                          <th class="numeric">
                            PAYMENT DP
                          </th>
                          <th class="numeric">
                            PAYMENT SECDEP
                          </th>
                          
                           
                        </tr>
                      </thead>
                      <tbody>
					    <?php if ($tenant_history) : ?>
						<?php foreach ($tenant_history as $data) : ?>
					  <tr> 
					   
					   <td><?php echo  $data['rekananshipping_type']; ?></td>
					   
					   <td><?php echo $data['TOTAL']; ?></td>
					   
					   <td><?php echo  $data['OCC'];?></td>
					   
					   <td><?php echo  $data['VACCANT']; ?></td>
					   
					   <td><?php echo  $data['TOTAL_TENANT']; ?></td>
					   
					   <td><?php echo  $data['TRI_PROCESS']; ?></td>
					   
					   <td><?php echo $data['NOT_YET_SIGNED']; ?></td>
					   
					   <td><?php echo  $data['SIGNED']; ?></td>
					   
					   <td><?php echo  $data['NO_DP']; ?></td>
					   
					   <td><?php echo  $data['DP']; ?></td>
					   
					   <td><?php echo  $data['NO_SECDEP']; ?></td> 
					   
					   <td><?php echo $data['SECDEP_Date']; ?></td>
					   
					   <td><?php echo  $data['DP_Payment_Date']; ?></td>
					   
					   <td><?php echo  $data['SD_Payment_Date']; ?></td>
					   
					    
					   
					   </tr> 
                        <?php endforeach; ?> 
                         <?php else: ?>
						<div class="alert alert-success fade in ">
						  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
						  <strong>Info!</strong> Belum Ada Data!
						</div>
				        <?php endif; ?> 
                      </tbody>
                    </table> 
			 