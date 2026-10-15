  <?php 
/*  */
 header("Content-type: application/vnd-ms-excel");
 
 header("Content-Disposition: attachment; filename=$title.xls");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");
 
 ?> 
 
                   <!-- CONTENT -->
                   <table >
                      <thead>
                        <tr> 
						  <th width="15%">
                            BillingAmount
                          </th> 
                          <th width="15%">
                             BillingDate
						              </th>  
                          <th width="15%">
                             BillingDueDate
						              </th>  
                          <th width="20%">
                              VirtualAccountNumber
                          </th> 
                           
                        </tr>
                      </thead>
                      <tbody>
					    <?php if ($va_download) : ?>
						<?php foreach ($va_download as $data) : ?>
					  <tr> 
					   <td><?php echo  $data['billing_amount']; ?></td>   
					   
					   <td><?php echo date("m-d-Y",strtotime($data['billing_date']) ); ?></td>  

					   <td><?php echo date("m-d-Y",strtotime( $data['billing_duedate'])); ?></td>  

					   <td><?php echo "'".$data['virtualaccount_number']; ?></td>
					   
					   </tr> 
                        <?php endforeach; ?> 
                         
				        <?php endif; ?> 
                      </tbody>
                    </table>
                 
            
			<?php //echo count($va_download)." Row(s)"; ?>