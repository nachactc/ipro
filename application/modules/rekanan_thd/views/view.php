<script>
$(document).ready(function(){ 
$('#region_id').select2({
		  placeholder: 'Select an option',
		  minimumInputLength: 2,
		  allowClear: true,
		  //tags: true,
		  minimumResultsForSearch: 10,
		  tokenSeparators: [',', ' '],
		  ajax: {
			  url: '<?php echo site_url('aging/region_select_dialog')?>',
			  dataType: 'json',
			  type: "GET",
			  data: function (term) {
				  return {
					  term: term,
					  region: ''
				  };
			  },
			  processResults: function (data) {
				  return {
					  results: $.map(data.items, function (item) {
 
						  return {

							  text: item.region_name, 
							  id: item.region_id
						  }
					  })
				  };
			  }
		  }
	  });	
	$('#branch_id').select2({
		  placeholder: 'Select an option',
		  minimumInputLength: 2,
		  allowClear: true,
		  //tags: true,
		  minimumResultsForSearch: 10,
		  tokenSeparators: [',', ' '],
		  ajax: {
			  url: '<?php echo site_url('aging/branch_select_dialog')?>',
			  dataType: 'json',
			  type: "GET",
			  data: function (term) {
				  return {
					  term: term,
					  region: ''
				  };
			  },
			  processResults: function (data) {
				  return {
					  results: $.map(data.items, function (item) {

							//console.log(data.items);
						  return {

							  text: item.branch_name,
							  region: item.region_id,
							  region_name: item.region_name,
							  id: item.branch_id
						  }
					  })
				  };
			  }
		  }
	  });	
	$('#branch_id').on("select2:select", function(e) {
			var valuenya = e.params.data; 
			var data = {
				text: valuenya.region_name,
				id: valuenya.region
			}; 
			 
			console.log(data);
			var newOption = new Option(data.text, data.id, true, true);
			$('#region_id').select2({data: [{id: '', text: ''}]});
			$('#region_id').empty();
			$('#region_id').append(newOption).trigger('change');
			$('#region_hidden').val(data.id); 
		});  
 	
});	
	
</script>
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
            <div class="col-md-12 col-xs-8">                
             &nbsp;
            </div>
           <div class="col-md-6 col-xs-9">
                                           
                 <?php echo form_open(site_url('rekanan_thd/search'), 'role="search" class="form"') ;?>   
				 
                            <div class="col-md-12 form-group">
                                <label for="contain">
                                  <b>Business Unit</b>
                                </label>
                               <div class="col-xs-7 input-group input-group-sm"> 
                                  
								   <?php echo form_dropdown('region_ids',$region_nm,'','id ="region_id" class="form-control" style="width: 100%;" required'); ?>
								   <input type="hidden" name="region_id" id="region_hidden"/>
                                </div>
                              </div> 
							  
							 <div class="row">
							 &nbsp;
							 </div> 
							   <div class="col-md-12 form-group">
                                <label for="contain">
                                  <b>Store</b>
                                </label>
                               <div class="col-xs-7 input-group input-group-sm"> 
                                  
								   <?php echo form_dropdown('branch_id',$branch_nm,'','id ="branch_id" class="form-control" style="width: 100%;" '); ?>
								   
                                </div>
                              </div> 
							<div> &nbsp; </div>
                           <div class="col-md-6 form-group ">                      
                                 <input type="text" class="form-control input-sm" placeholder="Cari data" name="q" value="<?php echo ($q=='')? '' : $q ; ?>" autocomplete="off">  
                           </div>
                           <div class="col-md-6 form-group ">                      
                                  <span class="input-group-btn">
                                      <button class="btn btn-primary btn-sm" type="submit"><i class="glyphicon glyphicon-search"></i> Cari</button>
                                 </span> 
                           </div> 
                <?php echo form_close(); ?>
            </div>
        </div>
    </header>
     <?php 
		// echo (empty($region_nm)) ? '' : $region_nm ;
		// echo "<br/>";
		// echo (empty($branch_nm)) ? '' : $branch_nm ;;
	 ?>
                              <div class="table-container">
                                <div class="table-scrollable">
                                 <?php if ($rekanan_thd_model) : ?>
          <table class="table   table-bordered table-hover "  >
              
            <thead>
              <tr>
                <th class="header">#</th>
                
                    <th>ID</th>   
                
                    <th>Business Unit</th>  
					
                    <th>Badan Hukum</th>   
                
                    <th>Name</th>   
					
                    <th>Brand</th>   
					
                    <th>Store</th>   
                  
                    <th>Address</th>   
                
                <th class="red header" align="right" width="145">Aksi</th>
              </tr>
            </thead>	  
                                 </div>                                    
                              </div>
                             
    <div class="panel-body">
        
            
            
            <tbody>
             
               <?php foreach ($rekanan_thd_model as $rekanan) : ?>
              <tr>
              	<td><?php echo $rekanan['row']; ?> </td>
               
               <td><?php echo $rekanan['rekanan_id']; ?></td>
			   
               <td><?php echo $rekanan['region_name']; ?></td>
               
               <td><?php echo $rekanan['rekanan_badanhukum']; ?></td>
               
               <td><?php echo $rekanan['rekanan_name']; ?></td> 
			   
               <td><?php echo $rekanan['rekananshipping_name']; ?></td> 
			   
               <td><?php echo $rekanan['branch_name']; ?></td> 
               
               <td><?php echo substr($rekanan['rekanan_address'],0,35).'...' ; ?></td> 
               
                <td>     
                    
                    <?php
                                  echo anchor(
                                          site_url('rekanan_thd/edit/' . $rekanan['rekanan_id']),
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