
<button type="button" class="btn btn-secondary"> 
<a href="<?php echo site_url('va_download/list_va_excel'); ?>" > Excel </a></button>
<div class="row"> &nbsp; </div> 
<?php echo '<b> PERIODE: '.$periode_id.'</b>'; ?> 
<div class="row"> &nbsp; </div>
<?php echo '<b>'.$branch_name.'</b>'; ?> 
<span> &nbsp; </span>
 <!-- CONTENT -->
 <div class="row"> &nbsp; </div> 
 <?php echo count($va_download)." Row(s)"; ?>
            <div class="row overflow-auto">
              <div class="overflow-auto"> 
                  <div class="portlet-body flip-scroll table-responsive table-scrollable">
                    <table class="table table-hover table-scroll table-bordered table-striped table-condensed flip-content " >
                      <thead class="flip-content">
                      <tr> 
						  <th width="15%">
                            Virtual Account Number
                          </th>
                          <th width="20%">
                            Tenant
                          </th>
                          <th width="20%">
                            Brand
                          </th>
                          <th width="10%">
                            Trx
                          </th>
                          <th width="15%">
                             Date
						  </th>  
                          <th width="15%">
                             Due Date
						  </th>  
                          <th width="20%">
                             Amount
                          </th> 
                           
                        </tr>
                      </thead>
                      <tbody>
					    <?php if ($va_download) : ?>
						<?php foreach ($va_download as $data) : ?>
					  <tr> 
					   
					   <td><?php echo $data['virtualaccount_number']; ?></td>
					   
					   <td><?php echo $data['tenant']; ?></td>
					   
             <td><?php echo $data['brand']; ?></td>
             
             <td><?php echo $data['agreementtype_name']; ?></td>
					   
					   <td><?php echo date("m-d-Y",strtotime($data['billing_date']) ); ?></td>  

					   <td><?php echo date("m-d-Y",strtotime( $data['billing_duedate'])); ?></td>  

					   <td><?php echo number_format($data['billing_amount'],0); ?></td>  
					   
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
                  </div>
                
                <!-- END SAMPLE TABLE PORTLET-->
                
              </div>
            </div>
			<?php echo count($va_download)." Row(s)"; ?>