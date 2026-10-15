 <?php
 $mode = $this->uri->segment(3);
 if( $mode == 'nik' ) {
	 ECHO "<center><b>List Empty NIK</b></center>";
 }
 elseif($mode == 'taxsign_id' )
 {
	ECHO "<center><b>List Empty NPWP</b></center>";
 }
 elseif($mode == 'email' )
 {
	ECHO "<center><b>List Empty EMAIL</b></center>";
 }
 elseif($mode == 'HP' )
 {
	ECHO "<center><b>List Empty Number HP</b></center>";
 }
 elseif($mode == 'alamat' )
 {
	ECHO "<center><b>List Empty Address</b></center>";
 }
 elseif($mode == 'pic' )
 {
	ECHO "<center><b>List Empty PIC</b></center>";
 }
 ?>
<!-- CONTENT --> 
              <div > 
                  <div class="portlet-body flip-scroll table-responsive table-scrollable">
                    <table class="table table-hover table-scroll table-bordered table-striped table-condensed flip-content " > 
					<thead class="flip-content">
                        <tr> 
						  <th >
                            No
                          </th>
						  <th >
                            ID
                          </th>
                          <th >
                            Name
                          </th>
                          <?php if( $mode == 'nik' ) { ?>
						  <th >
                            Nik
                          </th>
						  <?php } else { ?>
                          <th >
                            Email
                          </th>
                          <th class="numeric">
                            HP
                          </th>
                          <th class="numeric" >
                            Address
                          </th>
                          <th class="numeric" >
                            PIC
                          </th>
                           <?php }?> 
                           
                        </tr>
                      </thead>
                      <tbody>
					    <?php if ($valueObject) : ?>
						<?php $no= 1;foreach ($valueObject as $data) : ?>
					  <tr> 
					   
					   <td><?php echo $no; ?></td>
					   
					   <td><?php echo $data['id']; ?></td>
					   
					   <td><?php echo anchor('master_rekanan/edit/'.$data['id'], $data['name'], ''); ?></td>
					   
					   <?php if( $mode == 'nik' ) { ?>
					   
					   <td><?php echo $data['nik']; ?></td>
					    <?php } else { ?>
					   <td><?php echo $data['email']; ?></td>
					   
					   <td><?php echo $data['hp']; ?></td> 
					   
					   <td><?php echo $data['address']; ?></td> 
					   
					   <td><?php echo $data['pic']; ?></td> 
					    <?php }?> 
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
					     
                
                <!-- END SAMPLE TABLE PORTLET-->
                
              </div>
            </div>
			 