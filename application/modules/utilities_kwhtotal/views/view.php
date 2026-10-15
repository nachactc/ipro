<script>
$(document).ready(function() {


		var base = <?php echo json_encode(base_url());  ?>;
		var pages
		console.log(base);

		$("#pages").change(function(){
				var page = $(this).val();
				console.log(page);
				window.location= base + "index.php/utilities_kwhtotal/index/" + page
				console.log(base + "index.php/utilities_kwhtotal/index/" + page );
				$("#pages").val(page);
		});
});
</script>

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
                                           site_url('utilities_kwhtotal/add'),
                                            '<i class="glyphicon glyphicon-plus"></i>',
                                            'class="btn btn-success btn-sm" data-tooltip="tooltip" data-placement="top" title="Tambah Data"'
                                          );
                 ?>
                
            </div>
            <div class="col-md-4 col-xs-9">
                                           
                 <?php echo form_open(site_url('utilities_kwhtotal/search'), 'role="search" class="form"') ;?>       
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
         <?php if ($master_utilities_kwhtotal) : ?>
         <table class="table   table-bordered table-hover "  >
              
            <thead>
              <tr class="primary">
                    <th >ID</th>   
                
                    <th>Descr</th>   
					
                    <th>Periode</th>    
					
                    <th>KVA</th>   
                
                    <th>LWBP Gedung</th>     
                
                    <th>WBP Gedung</th>   
                
                    <th>Total</th>   

                <th class="red header" align="right" width="145">Aksi</th>
              </tr>
            </thead>
            
            
            <tbody>
             
               <?php foreach ($master_utilities_kwhtotal as $master_utilities_kwhtotal) : ?>
							<tr>
               <td><?php echo $master_utilities_kwhtotal['utilitieskwhtotal_id']; ?></td>
               
               <td><?php echo $master_utilities_kwhtotal['utilitieskwhtotal_descr']; ?></td> 
                  
               <td><?php echo $master_utilities_kwhtotal['periode_id']; ?></td>
                  
               <td><?php echo $master_utilities_kwhtotal['utilitieskwhtotal_kva']; ?></td>
               
               <td><?php echo $master_utilities_kwhtotal['utilitieskwhtotal_lwbp']; ?></td>
                
               <td><?php echo $master_utilities_kwhtotal['utilitieskwhtotal_wbp']; ?></td>
               <td><?php echo $master_utilities_kwhtotal['utilitieskwhtotal_jumlah']; ?></td>
               
                <td>     	
                    
                    <?php
                                  echo anchor(
                                          site_url('utilities_kwhtotal/edit/' . $master_utilities_kwhtotal['utilitieskwhtotal_id']),
                                            '<i class="glyphicon glyphicon-edit"></i>',
                                            'class="btn btn-sm btn-success" data-tooltip="tooltip" data-placement="top" title="Edit"'
                                          );
                   ?> 
                    <?php
                                  echo anchor(
                                          site_url('utilities_kwhtotal/delete/' . $master_utilities_kwhtotal['utilitieskwhtotal_id']),
                                            '<i class="glyphicon glyphicon-trash"></i>',
                                            'class="btn btn-sm btn-success" data-tooltip="tooltip" data-placement="top" title="Edit"'
                                          );
                   ?> 
                                 
                </td>
              </tr>     
               <?php endforeach; ?>
            </tbody>
          </table>
          <?php else: ?>
                <?php  echo 'Data master_utilitieskwhtotal belum tersedia';?>
          <?php endif; ?>
    </div>
    </div>
    
    
   
   <div class="form-actions top">  

        <div class="row">
           <div class="col-md-1"> 
																					
							<?php echo form_dropdown('pages', $options, $pages, 'id="pages" class=form-control'); ?>

           </div>  
            <div class="col-md-9" align="right">
                 <?php echo $pagination; ?>
           </div>
        </div>
    </div> 
