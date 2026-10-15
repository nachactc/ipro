<div class="row">
	<div class="col-lg-12 col-md-12">		
		<?php 
                
               // echo create_breadcrumb();		
                $msg = $this->session->flashdata('message');
                $err = $this->session->flashdata('error');
                if (!empty($msg))
				{
		?> 
				<div class="alert alert-success fade in ">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
				  <strong>Info!</strong> <?php echo $msg; ?>
				</div>
		<?php
				}
                ?>
	</div>
</div><!-- /.row -->

	<div class="portlet-body">
		<div class="tabbable-custom ">
		  <ul class="nav nav-tabs ">
			<li class="active">
			  <a href="#tab_list" data-toggle="tab"> LIST </a>
			</li>
			<li>
			  <a href="<?php echo base_url('index.php/La_received/La_received/add'); ?>"> INPUT </a>
			</li>
			<li>
			  <li>
			   <a href="<?php echo base_url('index.php/La_received/edit'); ?>"> EDIT </a>
			</li>
			</li>
		  </ul>
		  <div class="tab-content">
			<div class="tab-pane active" id="tab_list">
			
				<div class="row">
					<div class="col-md-8 col-xs-3">                
					 &nbsp; 
					</div>
					<div class="col-md-4 col-xs-9">
												   
						<?php echo form_open(site_url('La_received/search'), 'role="search" class="form"') ;?>  
								   <div class="input-group pull-right">                      
										 <input type="text" class="form-control input-sm" placeholder="Cari data" name="q" autocomplete="off"> 
										 <span class="input-group-btn">
											  <button class="btn btn-primary btn-sm" type="submit"><i class="glyphicon glyphicon-search"></i> Cari</button>
										 </span>
								   </div>
								   
					   </form> 
						<?php echo form_close(); ?>
					</div>
				</div> 
			
			
			<div class="table-container">
				<div class="table-scrollable"> 
				 <?php if ($La_receiveds) : ?>
          <table class="table table-hover table-condensed">
              
            <thead>
              <tr>
                <th class="header">#</th>
                
                    <th>B.Unit</th> 
					
                    <th>Property</th> 
					
                    <th>Tenant</th> 
					
                    <th>Brand</th> 
					
                    <th>Loo</th>   
                
                    <th>Loi</th>   
                
                    <th title="Received By">Rec.By</th>   
                
                    <th title="Received Date">Rec.Dt</th>   
                
                    <th title="Received">Rec.</th>   
                
                    <th title="Sign Date">Si.Dt</th>   
                
                    <th title="Sign By">Si.By</th>   
                
                    <th title="Signed">Signed</th>   
                
                    <th title="Proceed Date">Proc.Dt</th>   
                
                    <th title="Proceed By">Proc.By</th>   
                
                    <th title="Proceed">Proc.</th>   
                
                <th class="red header" align="right" width="145">Aksi</th>
              </tr>
            </thead>
            
            
            <tbody>
             
               <?php foreach ($La_receiveds as $La_received) : ?>
              <tr>
              	<td><?php echo $number++; ?> </td> 
               <td><?php echo $La_received['region_nameshort']; ?></td>
			   
               <td><?php echo $La_received['branch_name']; ?></td>
			   
               <td><?php echo $La_received['rekanan_name']; ?></td>
			   
               <td><?php echo $La_received['rekananshipping_name']; ?></td>
			   
               <td><?php echo $La_received['loo_id']; ?></td>
               
               <td><?php echo $La_received['la_noloi']; ?></td>
               
               <td><?php echo $La_received['la_receivedby']; ?></td>
               
               <td><?php echo  $La_received['la_receiveddate'] == NULL ? '' : date('d-m-Y',strtotime($La_received['la_receiveddate'])); ?></td>
               
               <td> 
			    <?php if ( $La_received['la_isreceived'] == 1 ) { ?>
			     <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
				<?php } else { ?>
			     <span class="cr"><i class="glyphicon glyphicon-unchecked"></i></span>
				<?php } ?>
				</td>
               
               <td><?php echo $La_received['la_signdate'] == NULL ? '' :date('d-m-Y',strtotime($La_received['la_signdate'])); ?></td>
               
               <td><?php echo $La_received['la_signby']; ?></td>
               
               <td>
			    <?php if ( $La_received['la_issigned'] == 1 ) { ?>
			     <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
				<?php } else { ?>
			     <span class="cr"><i class="glyphicon glyphicon-unchecked"></i></span>
				<?php } ?>
				</td>
               
               <td><?php echo $La_received['la_proceeddate'] == NULL ? '' : date('d-m-Y',strtotime($La_received['la_proceeddate'])); ?></td>
               
               <td><?php echo $La_received['la_proceedby']; ?></td>
               
               <td>
			   <?php if ( $La_received['la_isproceed'] == 1 ) { ?>
			     <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
				<?php } else { ?>
			     <span class="cr"><i class="glyphicon glyphicon-unchecked"></i></span>
				<?php } ?>
			    </td>
               
                <td width="145">    
                     
                    
                    <?php
                                  echo anchor(
                                          site_url('La_received/edit/' . str_replace('/', '_',$La_received['loo_id'])),
                                            '<i class="glyphicon glyphicon-edit"></i>',
                                            'class="btn btn-sm btn-success" data-tooltip="tooltip" data-placement="top" title="Edit"'
                                          ); 
                                  echo anchor(
                                          site_url('La_received/destroy/' . str_replace('/', '_',$La_received['loo_id'])),
                                            '<i class="glyphicon glyphicon-trash"></i>',
                                            'onclick="return confirm(\'Anda yakin menghapus data ini?\');" class="btn btn-sm btn-danger" data-tooltip="tooltip" data-placement="top" title="Hapus"'
                                          );
                   ?>   
                                 
                </td>
              </tr>     
               <?php endforeach; ?>
            </tbody>
          </table>
          <?php else: ?>
				<div class="alert alert-success fade in ">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
				  <strong>Info!</strong> <?php  echo 'Data La_received belum tersedia';?>
				</div> 
          <?php endif; ?>
			</div>
			</div>
			
			  <div class="form-actions top">  
				<div class="row">
				   <div class="col-md-2"> 
				   </div>  
					<div class="col-md-9" align="right">
						 <?php echo $pagination; ?>
				   </div>
				</div>
			</div>     
			</div>
			<div class="tab-pane" id="tab_input">
			   
			</div>
			<div class="tab-pane" id="tab_edit">
			   
			</div>
		  </div>
		</div>
	</div>
	 