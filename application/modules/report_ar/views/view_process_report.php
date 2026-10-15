 
<button type="button" class="btn btn-secondary"> 
<a href="<?php echo site_url('report_ar/list_ar_excel_report'); ?>" > Excel </a></button> 
<div class="row"> &nbsp; </div> 
 
 
 
<?php echo '<b> PERIODE: '.$periode_id.'</b>'; ?> 
<div class="row"> &nbsp; </div>
<?php echo '<b>'.$branch_name.'</b>'; ?> 
<span> &nbsp; </span>
 <!-- CONTENT -->
 <div class="row"> &nbsp; </div> 
 <?php echo count($report_ar_list)." Row(s)"; ?>
            <div class="row">
              <div class="overflow"> 
                  <div class="portlet-body flip-scroll table-responsive table-scrollable" width="100%">
                    <table class="table table-hover table-scroll table-bordered table-striped table-condensed flip-content " width="10px" >
                      <thead class="flip-content">
                      <tr> 
						  <th width="20%">
                            B.U
                          </th>
						  <th width="30%">
                            Property
                          </th>
						  <th width="5%">
                            ID
                          </th> 
                          <th width="15%">
                             Tenant
                          </th>
                          <th width="10%">
                             Brand
                          </th> 
                          <th width="10%">
                            Date
                          </th>
                          <th width="10%">
                            Descr
                          </th>
                          <th width="10%">
                            Detil Descr
                          </th>
                          <th width="10%">
                             Account
						  </th>  
                          <th width="15%">
                             Amount
						  </th>  
                           
                        </tr>
                      </thead>
                      <tbody>
					    <?php if ($report_ar_list) : ?>
						<?php foreach ($report_ar_list as $data) : ?>
					  <tr> 
					   
					   <td><?php echo $data['region_name']; ?></td>
					   
					   <td><?php echo $data['branch_name']; ?></td>
					   
					   <td><?php echo $data['jurnal_id']; ?></td>
					   
					   <td><?php echo $data['rekanan_name']; ?></td>
					   
					   <td><?php echo $data['rekananshipping_name']; ?></td>
						 
					   <td><?php echo date('d-m-Y',strtotime($data['jurnal_date'])); ?></td>
					   
					   <td><?php echo $data['jurnal_descr']; ?></td>
						
					   <td><?php echo $data['detil_descr']; ?></td>
						 
					   <td><?php echo $data['acc_id'].' - '.$data['acc_name']; ?></td>

					   <td><?php echo number_format($data['amount'],0); ?></td>  
					   
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
			<?php echo count($report_ar_list)." Row(s)"; ?>