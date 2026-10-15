
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
 
    <header class="panel-heading">
        <div class="row">
            <div class="col-md-8 col-xs-3">                
                <?php
                                  echo anchor(
                                           site_url('master_rekanan/add'),
                                            '<i class="glyphicon glyphicon-plus"></i>',
                                            'class="btn btn-success btn-sm" data-tooltip="tooltip" data-placement="top" title="Tambah Data"'
                                          );
                 ?>
                
            </div>
           <div class="col-md-4 col-xs-9">
                                           
                 <?php echo form_open(site_url('master_rekanan/search'), 'role="search" class="form"') ;?>       
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
                                 <?php if ($master_rekanans) : ?>
          <table class="table   table-bordered table-hover "  >
              
            <thead>
              <tr>
                <th class="header">#</th>
                
                    <th>ID</th>   
                
                    <th>Business Unit</th>  
					
                    <th>Badan Hukum</th>   
                
                    <th>Name</th>   
                  
                    <th>Address</th>   
                
                <th class="red header" align="right" width="145">Aksi</th>
              </tr>
            </thead>	  
                                 </div>                                    
                              </div>
                             
    <div class="panel-body">
        
            
            
            <tbody>
             
               <?php foreach ($master_rekanans as $master_rekanan) : ?>
              <tr>
              	<td><?php echo $master_rekanan['row']; ?> </td>
               
               <td><?php echo $master_rekanan['rekanan_id']; ?></td>
			   
               <td><?php echo $master_rekanan['region_name']; ?></td>
               
               <td><?php echo $master_rekanan['rekanan_badanhukum']; ?></td>
               
               <td><?php echo $master_rekanan['rekanan_name']; ?></td> 
               
               <td><?php echo substr($master_rekanan['rekanan_address'],0,35).'...' ; ?></td> 
               
                <td>     
                    
                    <?php
                                  echo anchor(
                                          site_url('master_rekanan/edit/' . $master_rekanan['rekanan_id']),
                                            '<i class="glyphicon glyphicon-edit"></i>',
                                            'class="btn btn-sm btn-success" data-tooltip="tooltip" data-placement="top" title="Edit"'
                                          );
                   ?> 
                                 
                </td>
              </tr>     
               <?php endforeach; ?>
            </tbody>
          </table>
          <?php else: ?>
                <?php  echo '<p class="label label-info">Data Rekanan belum tersedia Atau Pencarian Tidak Ditemukan</p>';?>
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