<div class="row">
	<div class="col-lg-12 col-md-12">		
		<?php 
                 	
                echo $this->session->flashdata('message');
                
                ?>
	</div>
</div><!-- /.row -->
<section class="panel panel-default">
    <header class="panel-heading">
        <div class="row">
            <div class="col-md-8 col-xs-3">                
                <?php
                                  echo anchor(
                                           site_url('master_rekananshipping/add'),
                                            '<i class="glyphicon glyphicon-plus"></i>',
                                            'class="btn btn-success btn-sm" data-tooltip="tooltip" data-placement="top" title="Tambah Data"'
                                          );
                 ?>
                
            </div>
            <div class="col-md-4 col-xs-9">
                                           
                 <?php echo form_open(site_url('master_rekananshipping/search'), 'role="search" class="form"') ;?>       
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
    
    
    <div class="panel-body">
         <?php if ($master_rekananshippings) : ?>
          <table class="table table-hover table-condensed">
              
            <thead>
              <tr>
                <th class="header">#</th>
                
                    <th>Rekanan</th>   
                
                    <th>Rekananshipping Line</th>   
                
                    <th>Rekananshipping Name</th>    
                
                    <th>Rekananshipping Contactname</th>   
                
                    <th>Rekananshipping Contacthp</th>   
                
                    <th>Rekananshipping Contacttelp</th>   
                
                    <th>Rekananshipping Contactemail</th>   
                
                    <th>Rekananshipping Profitsharringvalue</th>   
                
                    <th>Rekananshipping Reglistrik</th>   
                
                    <th>Rekananshipping Regair</th>   
                
                    <th>Rekananshipping Reggas</th>   
                
                    <th>Noreg Air</th>   
                
                    <th>Noreg Gas</th>   
                
                    <th>Noreg Listrik</th>   
                
                    <th>Salesarea</th>   
                
                    <th>Rowid</th>   
                
                    <th>Noreg Solar</th>   
                
                    <th>Rekananshipping Regsolar</th>   
                
                    <th>Rekananshipping Tax</th>   
                
                    <th>Branch</th>   
                
                    <th>Rekananshipping Isactive</th>   
                
                    <th>Rekananshipping Type</th>   
                
                    <th>Rekananshipping Desc</th>   
                
                    <th>Rekananshipping Namereport</th>   
                
                    <th>Rekananshipping Npwp</th>   
                
                    <th>Rekananshipping Npwp Addr</th>   
                
                    <th>Rekananshipping Npwp Name</th>   
                
                <th class="red header" align="right" width="120">Aksi</th>
              </tr>
            </thead>
            
            
            <tbody>
             
               <?php foreach ($master_rekananshippings as $master_rekananshipping) : ?>
              <tr>
              	<td><?php echo $number++;; ?> </td>
               
               <td><?php echo $master_rekananshipping['rekanan_id']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_line']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_name']; ?></td> 
               
               <td><?php echo $master_rekananshipping['rekananshipping_contactname']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_contacthp']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_contacttelp']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_contactemail']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_profitsharringvalue']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_reglistrik']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_regair']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_reggas']; ?></td>
               
               <td><?php echo $master_rekananshipping['noreg_air']; ?></td>
               
               <td><?php echo $master_rekananshipping['noreg_gas']; ?></td>
               
               <td><?php echo $master_rekananshipping['noreg_listrik']; ?></td>
               
               <td><?php echo $master_rekananshipping['salesarea_id']; ?></td>
               
               <td><?php echo $master_rekananshipping['rowid']; ?></td>
               
               <td><?php echo $master_rekananshipping['noreg_solar']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_regsolar']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_tax']; ?></td>
               
               <td><?php echo $master_rekananshipping['branch_id']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_isactive']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_type']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_desc']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_namereport']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_npwp']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_npwp_addr']; ?></td>
               
               <td><?php echo $master_rekananshipping['rekananshipping_npwp_name']; ?></td>
               
                <td>    
                    
                    <?php
                                  echo anchor(
                                          site_url('master_rekananshipping/show/' . $master_rekananshipping['']),
                                            '<i class="glyphicon glyphicon-eye-open"></i>',
                                            'class="btn btn-sm btn-info" data-tooltip="tooltip" data-placement="top" title="Detail"'
                                          );
                   ?>
                    
                    <?php
                                  echo anchor(
                                          site_url('master_rekananshipping/edit/' . $master_rekananshipping['']),
                                            '<i class="glyphicon glyphicon-edit"></i>',
                                            'class="btn btn-sm btn-success" data-tooltip="tooltip" data-placement="top" title="Edit"'
                                          );
                   ?>
                   
                   <?php
                                  echo anchor(
                                          site_url('master_rekananshipping/destroy/' . $master_rekananshipping['']),
                                            '<i class="glyphicon glyphicon-trash"></i>',
                                            'onclick="return confirm(\'Anda yakin..???\');" class="btn btn-sm btn-danger" data-tooltip="tooltip" data-placement="top" title="Hapus"'
                                          );
                   ?>   
                                 
                </td>
              </tr>     
               <?php endforeach; ?>
            </tbody>
          </table>
          <?php else: ?>
                <?php  echo notify('Data master_rekananshipping belum tersedia','info');?>
          <?php endif; ?>
    </div>
    
    
    <div class="panel-footer">
        <div class="row">
           <div class="col-md-3">
               Master Rekananshipping
               <span class="label label-info">
                    <?php echo $total; ?>
               </span>
           </div>  
           <div class="col-md-9">
                 <?php echo $pagination; ?>
           </div>
        </div>
    </div>
</section>