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
			  <a href="<?php echo base_url('index.php/semester/add'); ?>"> INPUT </a>
			</li>
			<li>
			  <li>
			   <a href="<?php echo base_url('index.php/semester/edit'); ?>"> EDIT </a>
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
												   
						 <?php echo form_open(site_url('semester/search'), 'role="search" class="form"') ;?>       
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
			
			
			<div class="panel-body">
				 <?php if ($semester) : ?>
				  <table class="table table-hover table-condensed">
					  
					<thead>
					  <tr>
						<th class="header">#</th>
						
							<th>ID</th>   
							
							<th>Semester</th>   
							
							<th>Group</th>   
						
							<th>Branch</th>   
						
							<th>Semester Year</th>   
						
						<th class="red header" align="right" width="120">Aksi</th>
					  </tr>
					</thead>
					
					
					<tbody>
					 
					   <?php foreach ($semester as $master_semesterbranch) : ?>
					  <tr>
						<td><?php echo $number++;; ?> </td>
					   
					   <td><?php echo $master_semesterbranch['semester_id']; ?></td>
					   
					   <td><?php echo $master_semesterbranch['semester_name']; ?></td>
					   
					   <td><?php echo $master_semesterbranch['group_branchid']; ?></td>
					   
					   <td><?php echo $master_semesterbranch['branch_name']; ?></td>
					   
					   <td><?php echo $master_semesterbranch['semester_year']; ?></td>
					   
						<td>     
							
							<?php
										  echo anchor(
												  site_url('semester/edit/' . $master_semesterbranch['semester_id'].'/'.$master_semesterbranch['branch_id']),
													'<i class="glyphicon glyphicon-edit"></i>',
													'class="btn btn-sm btn-success" data-tooltip="tooltip" data-placement="top" title="Edit"'
												  );
						   ?>
						   
						   <?php
										  echo anchor(
												  site_url('semester/destroy/' . $master_semesterbranch['semester_id'].'/'.$master_semesterbranch['branch_id']),
													'<i class="glyphicon glyphicon-trash"></i>',
													'onclick="return confirm(\'Anda yakin menghapus data ini ?\');" class="btn btn-sm btn-danger" data-tooltip="tooltip" data-placement="top" title="Hapus"'
												  );
						   ?>   
										 
						</td>
					  </tr>     
					   <?php endforeach; ?>
					</tbody>
				  </table>
				  <?php else: ?>
						<?php  echo 'Data master_semesterbranch belum tersedia';?>
				  <?php endif; ?>
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
               
  