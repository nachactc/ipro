<div class="row">
	<div class="col-lg-12 col-md-12">		
		<?php 
                 
              $msg = $this->session->flashdata('message');
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
 
    <header class="panel-heading">
        <div class="row">
            <div class="col-md-8 col-xs-3">                
                <?php	
                                  echo anchor(
                                           site_url('master_branch/add'),
                                            '<i class="glyphicon glyphicon-plus"></i>',
                                            'class="btn btn-success btn-sm" data-tooltip="tooltip" data-placement="top" title="Tambah Data"'
                                          );
                 ?>
                
            </div>
            <div class="col-md-4 col-xs-9">
                                           
                 <?php echo form_open(site_url('master_branch/search'), 'role="search" class="form"') ;?>       
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
    </header>
    
    
    <div class="table-container">
        <div class="table-scrollable">
         <?php if ($master_branchs) : ?>
         <table class="table   table-bordered table-hover "  >
              
            <thead>
              <tr>
                <th class="header">#</th>
                
                    <th>Branch</th>   
                
                    <th>Branch Name</th>   
					
                    <th>Branch Nameshort</th>    
					
                    <th>Branch Code</th>   
                
                    <th>Branch Idlok</th>     
                
                    <th>Branch Totalsqm</th>   
                
                <th class="red header" align="right" width="145">Aksi</th>
              </tr>
            </thead>
            
            
            <tbody>
             
               <?php foreach ($master_branchs as $master_branch) : ?>
              <tr>
              	<td><?php echo $master_branch['row']; ?> </td>
               
               <td><?php echo $master_branch['branch_id']; ?></td>
               
               <td><?php echo $master_branch['branch_name']; ?></td> 
                  
               <td><?php echo $master_branch['branch_nameshort']; ?></td>
                  
               <td><?php echo $master_branch['branch_code']; ?></td>
               
               <td><?php echo $master_branch['branch_idlok']; ?></td>
                
               <td><?php echo $master_branch['branch_totalsqm']; ?></td>
               
                <td>     	
                    
                    <?php
                                  echo anchor(
                                          site_url('master_branch/edit/' . $master_branch['branch_id']),
                                            '<i class="glyphicon glyphicon-edit"></i>',
                                            'class="btn btn-sm btn-success" data-tooltip="tooltip" data-placement="top" title="Edit"'
                                          );
                   if ($this->session->userdata('username') == 'administrator')
				   {
					   
				   }
                                  echo anchor(
                                          site_url('master_branch/destroy/' . $master_branch['branch_id']),
                                            '<i class="glyphicon glyphicon-trash"></i>',
                                            'class="btn btn-sm btn-warning" data-tooltip="tooltip" data-placement="top" title="Delete"'
                                          );
                   ?> 
                                 
                </td>
              </tr>     
               <?php endforeach; ?>
            </tbody>
          </table>
          <?php else: ?>
                <?php  echo 'Data master_branch belum tersedia';?>
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