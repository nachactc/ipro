<script>
	$(document).ready(function() {		

			window.setTimeout(function() {
					$(".alert").fadeTo(500, 0).slideUp(500, function(){
							$(this).remove();
					});
			}, 2500);		

      $('#confirm-delete').on('show.bs.modal', function(e) {
          $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
          
          var url = $(this).find('.btn-ok').attr('href');
          var id = url.split("/");
          $('.debug-url').html(id[2]);
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


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!--
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>
            -->
            <div class="modal-body">
                <p>Apakah anda yakin akan <b>menghapus</b> data '<span class="debug-url"></span>' ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>
 
    <header class="panel-heading">
        <div class="row">
            <div class="col-md-8 col-xs-3">                
                <?php	
                    echo anchor(
                        site_url('thdGroup/add'),
                        '<i class="glyphicon glyphicon-plus"></i>',
                        'class="btn btn-success btn-sm" data-tooltip="tooltip" data-placement="top" title="Tambah Data"'
                    );
                 ?>
                
            </div>
            <div class="col-md-4 col-xs-9">
                                           
                 <?php echo form_open(site_url('thdGroup/search'), 'role="search" class="form"') ;?>       
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
         <?php if ($records) : ?>
         <table class="table   table-bordered table-hover "  >
              
            <thead>
              <tr>
                  <th class="header">#</th>                
                  <th>ID</th>                   
                  <th>Name</th>                  
                  <th class="red header" align="right" width="145">Aksi</th>
              </tr>
            </thead>
            
            
            <tbody>             
                <?php foreach ($records as $record) : ?>
                <tr>
              	<td><?php echo $record['row']; ?> </td>               
                <td><?php echo $record['thdgroup_id']; ?></td>                
                <td><?php echo $record['thdgroup_name']; ?></td>               
                <td>     	                    
                    <?php
                        echo anchor(
                          site_url('thdGroup/edit/' . $record['thdgroup_id']),
                          '<i class="glyphicon glyphicon-edit"></i>',
                          'class="btn btn-sm btn-success" data-tooltip="tooltip" data-placement="top" title="Edit"'
                        );
                    ?>                                  
                    <a href="#" data-href="<?='thdGroup/destroy/'.$record['thdgroup_id'];?>" class="btn btn-sm btn-danger" data-tooltip="tooltip" title="Delete" data-toggle="modal" data-target="#confirm-delete">
                      <i class="glyphicon glyphicon-trash"></i>
                    </a>
                </td>
              </tr>     
               <?php endforeach; ?>
            </tbody>
          </table>
          <?php else: ?>
                <?php  echo 'Data THD Group belum tersedia';?>
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