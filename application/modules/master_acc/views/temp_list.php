 
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
            
                      <?php echo form_open('master_acc/master_acc/acc_list',"id='FormE'"); ?>
					  <!-- 1 --> 
					  <div class="row"> 
					  <div class="col-md-12">
                              <div class="col-xs-12 form-group"> 
								<label style="font-size:12px;"><b><i>** Hanya bisa <u>SELECT</u> query saja, tidak bisa DELETE dan UPDATE. **</b></i></label>
								<br/>
								<label style="font-size:12px;"><b><i>** Gunakan SemiColon(;) Untuk Multi Query **</b></i></label>
								<br/>
                                <label for="contain">
                                  <b>Query</b>
                                </label> 
                                <textarea name="qbased" id="txtBased" class="form-control input-sm" rows="5"><?php echo ($q_text != '') ? $q_text : '';  ?></textarea> 
                              </div>
							    
							 
							 <div class="row"> </div>
							   
                              <div class="col-md-4 form-group "> 
                                <br>
                                <button type="search" class="btn blue" id="bSearch"  >
                                  Load 
                                </button>
                              </div>
							  
					  </div> 
					  </div>
							  
                      <?php echo form_close(); ?>      
					  <!-- 1 -->
					<div class="row"> &nbsp; </div>
					
					<div class="row"> 
					  <div class="col-md-12 form-group">  
							<div class="table-container">  
							  <?php 
									if($result <> 'multiple'){ 
										echo $result; 
									}
									else
									{ 
										if(!empty($_POST))
										{
											$query = $this->input->post('qbased');
											$q_explode = explode(';',$query); 
											for($i=0;$i<=(count($q_explode)-2);$i += 1 )
											{  
												$this->table->clear(); 
												$hasil = $this->model_acc->get_data($q_explode[$i]); 
												echo $this->table->generate($hasil);
												$this->table->clear();  
											} 
										}
									}
							  ?>
							</div>  
					</div> 
					</div>
					
              <!-- END OF CONTENT -->
			  
<script>  

$(document).ready(function(){  
	
	$(".tbl_me").dataTable({
		"pageLength": 100, 
	});
	
	$('#bSearch').on('click',function(e){
		var str = $('#txtBased').val();
		if (str.toLowerCase().indexOf("delete") >= 0)
		{
			alert('Tidak di perkenankan Delete, Hanya SELECT saja');
			$('#txtBased').val('').trim;
			return;
		}
		if (str.toLowerCase().indexOf("update") >= 0)
		{
			alert('Tidak di perkenankan Update, Hanya SELECT saja');
			$('#txtBased').val('').trim;
			return;
		}	
	});
	
	$('#txtBased').on('keypress',function(e){
		var str = $('#txtBased').val();
		if (str.toLowerCase().indexOf("delete") >= 0)
		{
			alert('Tidak di perkenankan Delete, Hanya SELECT saja');
			$('#txtBased').val('').trim;
			return;
		}
		if (str.toLowerCase().indexOf("update") >= 0)
		{
			alert('Tidak di perkenankan Update, Hanya SELECT saja');
			$('#txtBased').val('').trim;
			return;
		}	 
	});
	$('#txtBased').on('keydown',function(e){
		var str = $('#txtBased').val();
		if (str.toLowerCase().indexOf("delete") >= 0)
		{
			alert('Tidak di perkenankan Delete, Hanya SELECT saja');
			$('#txtBased').val('').trim;
			return;
		}
		if (str.toLowerCase().indexOf("update") >= 0)
		{
			alert('Tidak di perkenankan Update, Hanya SELECT saja');
			$('#txtBased').val('').trim;
			return;
		}	 
	});
	
});

</script>