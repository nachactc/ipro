  <?php 
  $link_id = $this->uri->segment(3);
  $date = date("d-m-Y");
  if($excel == TRUE)
  {
 header("Content-type: application/vnd-ms-excel");
 
 header("Content-Disposition: attachment; filename=WARNING_$link_id"."_Month_".$date.".xls");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");
  }
 ?>
<!-- CONTENT -->
<?php  
  if($excel == FALSE)
  {
	
?>
            <div class="row">
				<div class="btn-group btn-group" style="align:right;float: right;" align="right"> 
					<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:;"> Export
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
					  <li>
						<a href="<?php  echo site_url("dashboard/ReminderDetil/$link_id/TRUE"); ?>"> Excel 
						</a>
					  </li> 
					</ul> 
				</div> 
				<p> &nbsp;</P>
<?php  
	}
 ?>
              <div > 
                  <div class="portlet-body flip-scroll table-responsive table-scrollable">
                    <table class="table table-hover table-scroll table-bordered table-striped table-condensed flip-content " >
                      <thead class="flip-content">
                        <tr> 
						  <th >
                            No
                          </th>
						  <th >
                            Business Unit
                          </th>
                          <th width="10%">
                            Property
                          </th>
                          <th width="25%">
                            Tenant
                          </th>
                          <th width="25%">
                            Brand
                          </th>
                          <th class="numeric">
                            Agreement
                          </th>
                          <th class="numeric" width="15%">
                            Start Date
                          </th>
                          <th class="numeric" width="15%">
                            End Date
                          </th>
                           
                           
                        </tr>
                      </thead>
                      <tbody>
					    <?php if ($detil_bln) : ?>
						<?php $no= 1;foreach ($detil_bln as $data) : ?>
					  <tr> 
					   
					   <td><?php echo $no; ?></td>
					   
					   <td><?php echo $data['region_name']; ?></td>
					   
					   <td><?php echo $data['branch_name']; ?></td>
					   
					   <td><?php echo $data['rekanan_name']; ?></td>
					   
					   <td><?php echo $data['rekananshipping_name']; ?></td>
					   
					   <td><?php echo $data['agreement_id']; ?></td> 
					   
					   <td><?php echo date("d-M-Y",strtotime($data['agreement_startperiod'])); ?></td> 
					   
					   <td><?php echo date("d-M-Y",strtotime($data['agreement_endperiod'])); ?></td> 
					   
					   </tr> 
                        <?php $no++;endforeach; ?> 
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
			 