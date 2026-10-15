 
<style>
table.dataTable td {
    padding:2px;
    font-size: 9pt;    
}

</style>
<noscript>
 For full functionality of this site it is necessary to enable JavaScript.
 Here are the <a href="https://www.enable-javascript.com/">
 instructions how to enable JavaScript in your web browser</a>.
 <style> .row { display: none } </style>
</noscript>
 <!-- CONTENT -->
            
                      <?php echo form_open('myprofile/saveprofile',"id='FormE'"); ?>
					  <!-- 1 --> 
					  <div class="row"> 
					  <div class="col-md-12">
							
							
						<div class="col-xs-4 form-group"> 
							<label style="font-size:12px;">User Name</label> 
							<input type="text" class="form-control" name="username" value="<?php echo $user['username']; ?>" readonly />  
						</div>
						
						<div class="col-xs-4 form-group"> 
							<label style="font-size:12px;">Name</label> 
							<input type="text" value="<?php echo trim($user['user_fullname']); ?>" class="form-control" name="userfullname"  required />  
						</div>
						 
						<div class="col-xs-4 form-group"> 
							<label style="font-size:12px;">Change Password</label> 
							<input type="password" class="form-control" name="chgPwd" required /> 
						</div>
							
						<div class="row"> </div>
							   
						<div class="col-md-4 form-group "> <br/> 
						<button type="search" style="font-size:12px;" class="btn blue" id="bSearch"  >
						  Save Change 
						</button> 
						</div>
							  
					  </div> 
					  </div>
							  
                      <?php echo form_close(); ?>      
					  <?php //echo var_dump($pesan); ?>
					  
					  <!-- Button trigger modal -->
 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dlgShow" id="btnX" style="display:none;">
 x
</button>
<!-- BEGIN dlg account tambahan -->   
  <div class="modal fade" id="dlgShow" tabindex="-1" role="dialog" aria-labelledby="dlgShow" aria-hidden="true">
  <div class="modal-dialog" style="width:35%;">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		</button>
		<h4 class="modal-title">
		 Ipro
		</h4>
	  </div>
	  <div class="modal-body">  
		<div class="rows">
			<div class="col-md-12 form-group form-group-sm row" >
				<div class="col-xs-12">
				  <label><?php echo $pesan; ?></label> 
				  <?php if($logout != '') { ?>
				  <label>Silahkan Login Ulang</label>
				  <?php } ?>
				</div>  
			</div>
		</div>      
		<br />  
		<div class="rows"> &nbsp; </div>
	  </div>
	  <div class="modal-footer">
		<?php if($logout == '') { ?>
		<button type="button" class="btn dark btn-outline btn-sm" data-dismiss="modal">
		  Close
		</button> 
		<?php } ?>
		<?php if($logout != '') { ?>
		<button type="button" style="font-size:12px;" id="btnLogout" class="btn btn-primary">
		  Close
		</button>
		<?php } ?>
	  </div>
	</div>
	<!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
					
              <!-- END OF CONTENT -->
			  
<script>  

$(document).ready(function(){  
	$("#btnX").hide();
	<?php if($pesan != ''){ ?>
	$('#btnX').trigger('click'); 
	<?php } ?>
	
	$("#btnLogout").on('click', function(e) {
		<?php echo site_url('login/user_logout') ?>
		//http://localhost/bali/index.php/login/user_logout
		window.location.href = "<?php echo site_url('login/user_logout');?>";
	});
});

</script>