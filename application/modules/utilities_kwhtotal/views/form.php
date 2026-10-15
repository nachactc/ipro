<script>
$(document).ready(function() {

	var json_regionbranch = <?php echo json_encode($regionbranch,JSON_FORCE_OBJECT); ?> ;

	var count_branch = <?php echo count($regionbranch); ?>;
	$('#utilitieskwhtotal_kva').number( true, 0);
	$('#utilitieskwhtotal_lwbp').number( true, 0);
	$('#utilitieskwhtotal_wbp').number( true, 0);
	$('#utilitieskwhtotal_jumlah').number( true, 0);
	$('#utilitieskwhtotal_lwbp').on('keyup', function(){
      var input = $('#utilitieskwhtotal_wbp').val();
      var input2 = $('#utilitieskwhtotal_lwbp').val();
	  var input3 = parseInt(input) + parseInt(input2)
	  $('#utilitieskwhtotal_jumlah').val(input3);
   });

   $('#utilitieskwhtotal_wbp').on('keyup', function(){
      var input = $('#utilitieskwhtotal_wbp').val();
      var input2 = $('#utilitieskwhtotal_lwbp').val();
	  var input3 = parseInt(input) + parseInt(input2)
	  $('#utilitieskwhtotal_jumlah').val(input3);
   });


	$( "#branch_id" ).change(function() {
		//var json_branch = <?php //echo json_encode($branch,JSON_FORCE_OBJECT); ?> ;
		//alert( "Handler for .change() called." );
		var branch_id = '';
		var region_id = '';
		branch_id = $("#branch_id").val();
		console.log(branch_id);
		//$( "#branch_id" ).each(function() {
		//	branch_id = $(this).val();
		//});
		
		for (var i =0 ; i < count_branch ; i++){
			//console.log(json_array2[i]["branch_name"]);
			if (json_regionbranch[i]["branch_id"] ==  branch_id){
				region = json_regionbranch[i]["region_id"];
			}

		}
		console.log(region);
		$( "#region_id").val(region) ;
		
	});


var iArray= ['1','2'];
console.log(iArray[0]);

var xArray= '{"0": "Pilih Store :", "0000150" :"CARREFOUR LEBAK BULUS A008" }';
var json =JSON.parse(xArray);
console.log(json["0000150"]);
console.log(<?php echo count($branch); ?>);
//console.log(<?php //echo $branch[0][0]; ?>);

var json_array = <?php echo json_encode($branch,JSON_FORCE_OBJECT); ?> ;
console.log(json_array);
console.log(json_array["0000150"]);

//var json_array2 = <?php //echo json_encode($regionbranch,JSON_FORCE_OBJECT); ?> ;
//var count_branch = <?php //echo count($branch); ?>;
var region ='';
var branch_id ='0000606';

/*
for (var i =0 ; i < count_branch ; i++){
	//console.log(json_array2[i]["branch_name"]);
	if (json_array2[i]["branch_id"] ==  branch_id){
		region = json_array2[i]["region_id"];
	}

}
console.log(region);

console.log(json_array2);
console.log(json_array2[1]["branch_name"]);

/*
for (var i =0 ; i < json_array2.length ; i++){
	console.log(json_array2[i]["branch_name"]);
}
*/
//var arrayjson = JSON.stringify(json_array);
//console.log(arrayjson);
//console.log(arrayjson["0000150"]);
//var jsonx= JSON.parse(arrayjson);
//console.log(jsonx);

<?php 

/*
$tes = "[";

for ($x = 0; $x < count($branch) -100; $x++) {	
	$tes .= "'" . $branch[$x][0] . "':'" .  $branch[$x][1] ."'," ;
}

$tes .= "]";

*/
?>

//var passedArray=replace()
//var json2=JSON.parse(replace(passedArray);
//console.log(passedArray);

//var passedArray2 =  <?php //echo $branch ?>; 
//console.log(passedArray2);


// Display the array elements 
/*
for(var i = 0; i < passedArray.length; i++){ 
    console.log(passedArray[i][i]); 
	//document.write(passedArray[i][i]);
} 
*/

/*
   $('#branch_id').select2({
      placeholder: 'Select an option',
      minimumInputLength: 2,
      //tags: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php //echo site_url('utilities_kwhtotal/getBranchAjax')?>',
          dataType: 'json',
          type: "GET",
          data: function (term, region) {
              return {
                  term: term,
                  region: $("#region_id").val()
              };
          },
          processResults: function (data) {
              return {
                  results: $.map(data.items, function (item) {
					
						 
                console.log(item.branch_name);
                      return {

                           text: item.branch_name, 
                           id: item.branch_id
						   //results: data
                      } 
                  })
              };
          }
      }
  });
   */

});
</script>

<div class="row">
	<div class="col-lg-12 col-md-12">		
		<?php 
                
               // echo create_breadcrumb();		
                $msg = $this->session->flashdata('message'); 
                if (!empty($msg))
				{
		?> 
				<div class="alert alert-success fade in ">
				  <a href="#" class="close" data-dismiss="alert" aria-label="close" style="width:20px;height:20px; background-color: #F00; background: #000;">x</a>
				   <?php echo $msg; ?>
				</div>
		<?php
				}
                ?>
	</div>
</div><!-- /.row --> 
<?php echo form_open(site_url('utilities_kwhtotal/' . $action),'role="form" class="form-horizontal" id="form_master_utilities_kwhtotal" parsley-validate'); ?>               

<!--content--> 
	<div class="row">
		<div class="col-md-12">
		  <div class="portlet-body form">
				
		  <div class="col-md-4 form-group row">
					<div class="col-xs-5">
					   <label for="utilitieskwhtotal_id" class="control-label">ID</label> 
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'utilitieskwhtotal_id',
										 'id'           => 'utilitieskwhtotal_id',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Auto',
										 'readonly'  	=> true,
										 'maxlength'	=>'7'
										 ),
										 set_value('utilitieskwhtotal_id',$master_utilities_kwhtotal['utilitieskwhtotal_id'])
								   );             
						  ?>
						 <?php echo form_error('utilitieskwhtotal_id');?> 
					</div>   
				</div>


				<div class="row">&nbsp;</div>
				
				<div class="row">&nbsp;</div>

				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="utilitieskwhtotal_descr" class="control-label">Description</label>                                   
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'utilitieskwhtotal_descr',
											 'id'           => 'utilitieskwhtotal_descr', 
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Description KWH',
											 'maxlength'=>'100'
											 ),
											  set_value('utilitieskwhtotal_descr',$master_utilities_kwhtotal['utilitieskwhtotal_descr'])
									   );             
							  ?>
							 <?php echo form_error('utilitieskwhtotal_descr');?> 
					</div>
				</div><!--/ utilitieskwhtotal description --> 				
			
				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="periode_id" class="control-label">Periode</label>                                  
							  <?php                  
							   echo form_dropdown(
									   'periode_id',
									   $periode,  
									   set_value('periode_id',$master_utilities_kwhtotal['periode_id']),
									   'class="form-control parent" id="periode_id"'
									   );             
							  ?>
							 <?php echo form_error('periode_id');?>  
					</div>
				</div><!--/ utilities--> 


				<div class="row">&nbsp;</div>

				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="branch_id" class="control-label">Store</label>                                  
							  <?php                  
							   echo form_dropdown(
									   'branch_id',
									   $branch,  
									   set_value('branch_id',$master_utilities_kwhtotal['branch_id']),
									   'class="form-control parent" id="branch_id"'
									   );             
							  ?>
							 <?php echo form_error('branch_id');?>  
					</div>
				</div><!--/ Store--> 

				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="region_id" class="control-label">Bisnis Unit</label>                                  
							  <?php                  
							   echo form_dropdown(
									   'region_id',
									   $region,  
									   set_value('region_id',$master_utilities_kwhtotal['region_id']),
									   'class="form-control parent" id="region_id"'
									   );             
							  ?>
							 <?php echo form_error('region_id');?>  
					</div>
				</div><!--/ Bisnis Unit--> 


				<div class="row">&nbsp;</div>


				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="utilitieskwhtotal_lwbp" class="control-label">LWBP Gedung</label>                                   
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'utilitieskwhtotal_lwbp',
											 'id'           => 'utilitieskwhtotal_lwbp',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Utilitieskwhtotal lwbp',
											 'maxlength'=>'50'
											 ),
											 set_value('utilitieskwhtotal_lwbp',$master_utilities_kwhtotal['utilitieskwhtotal_lwbp'])
									   );             
							  ?>
							 <?php echo form_error('utilitieskwhtotal_lwbp');?> 
					</div>
				</div><!--/ utilitieskwhtotal lwbp--> 

				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="utilitieskwhtotal_wbp" class="control-label">WBP Gedung</label>                                   
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'utilitieskwhtotal_wbp',
											 'id'           => 'utilitieskwhtotal_wbp',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Utilitieskwhtotal wbp',
											 'maxlength'=>'50'
											 ),
											 set_value('utilitieskwhtotal_wbp',$master_utilities_kwhtotal['utilitieskwhtotal_wbp'])
									   );             
							  ?>
							 <?php echo form_error('utilitieskwhtotal_wbp');?> 
					</div>
				</div><!--/ utilitieskwhtotal wbp--> 

				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="utilitieskwhtotal_jumlah" class="control-label">Total WBP dan LWBP</label>                                   
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'utilitieskwhtotal_jumlah',
											 'id'           => 'utilitieskwhtotal_jumlah',                       
											 'class'        => 'form-control input-sm ',
											 'readonly'  	=> TRUE,
											 'placeholder'  => 'jumlah Utilitieskwhtotal',
											 'maxlength'=>'50'
											 ),
											 set_value('utilitieskwhtotal_jumlah',$master_utilities_kwhtotal['utilitieskwhtotal_jumlah'])
									   );             
							  ?>
							 <?php echo form_error('utilitieskwhtotal_jumlah');?> 
					</div>
				</div><!--/ utilitieskwhtotal wbp--> 

				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="jam_nyala_pln" class="control-label">Jam Nyala PLN</label>                                   
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'jam_nyala_pln',
											 'id'           => 'jam_nyala_pln',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Jam Nyala PLN',
											 'maxlength'=>'50'
											 ),
											 set_value('jam_nyala_pln',$master_utilities_kwhtotal['jam_nyala_pln'])
									   );             
							  ?>
							 <?php echo form_error('jam_nyala_pln');?> 
					</div>
				</div><!--/ utilitieskwhtotal lwbp--> 

				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="jam_nyala_genset" class="control-label">Jam Nyala Genset</label>                                   
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'jam_nyala_genset',
											 'id'           => 'jam_nyala_genset',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Jam Nyala Genset',
											 'maxlength'=>'50'
											 ),
											 set_value('jam_nyala_genset',$master_utilities_kwhtotal['jam_nyala_genset'])
									   );             
							  ?>
							 <?php echo form_error('jam_nyala_genset');?> 
					</div>
				</div><!--/ utilitieskwhtotal wbp--> 

				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="cosq" class="control-label">Cos q</label>                                   
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'cosq',
											 'id'           => 'cosq',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'cos q',
											 'maxlength'=>'50'
											 ),
											 set_value('cosq',$master_utilities_kwhtotal['cosq'])
									   );             
							  ?>
							 <?php echo form_error('cosq');?> 
					</div>
				</div><!--/ utilitieskwhtotal wbp--> 

				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="utilitieskwhtotal_kva" class="control-label">KVA</label>                                   
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'utilitieskwhtotal_kva',
											 'id'           => 'utilitieskwhtotal_kva',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'KVA',
											 'maxlength'=>'50'
											 ),
											 set_value('utilitieskwhtotal_kva',$master_utilities_kwhtotal['utilitieskwhtotal_kva'])
									   );             
							  ?>
							 <?php echo form_error('utilitieskwhtotal_kva');?> 
					</div>
				</div><!--/ utilitieskwhtotal kva--> 
				
				<div class="row">&nbsp;</div>
				<div class="row">&nbsp;</div>
				
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						   <label for="utilitieskwhtotal_createby" class="control-label">Create by</label>                                  
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'utilitieskwhtotal_createby',
											 'id'           => 'utilitieskwhtotal_createby',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => '',
											 'readonly'  	=> TRUE,
											 'maxlength'=>'30'
											 ),
											 set_value('utilitieskwhtotal_createby',$master_utilities_kwhtotal['utilitieskwhtotal_createby'])
									   );             
							  ?>
							 <?php echo form_error('utilitieskwhtotal_createby');?>  
					</div>
				</div> <!--/ Branch Createby -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
					  <label for="utilitieskwhtotal_createdate" class="control-label">Create Date</label>                                  
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'utilitieskwhtotal_createdate',
										 'id'           => 'utilitieskwhtotal_createdate',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => '',
										 'readonly'  	=> TRUE,
										 
										 ),
										 set_value('utilitieskwhtotal_createdate',$master_utilities_kwhtotal['utilitieskwhtotal_createdate'])
								   );             
						  ?>
						 <?php echo form_error('utilitieskwhtotal_createdate');?> 
					</div>
				</div><!--/ Branch Createdate --> 
				
				<div class="row">&nbsp;</div>

			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="utilitieskwhtotal_modifyby" class="control-label">Modify by</label>                                    
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'utilitieskwhtotal_modifyby',
											 'id'           => 'utilitieskwhtotal_modifyby',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => '',
											 'readonly'  	=> TRUE,
											 'maxlength'=>'30'
											 ),
											 set_value('utilitieskwhtotal_modifyby',$master_utilities_kwhtotal['utilitieskwhtotal_modifyby'])
									   );             
							  ?>
							 <?php echo form_error('utilitieskwhtotal_modifyby');?> 
					</div>
				</div> <!--/ Branch Modifyby -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="utilitieskwhtotal_modifydate" class="control-label">Modify Date</label>                                  
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'utilitieskwhtotal_modifydate',
											 'id'           => 'utilitieskwhtotal_modifydate',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => '',
											 'readonly'  	=> TRUE,
											 
											 ),
											 set_value('utilitieskwhtotal_modifydate',$master_utilities_kwhtotal['utilitieskwhtotal_modifydate'])
									   );             
							  ?>
							 <?php echo form_error('utilitieskwhtotal_modifydate');?> 
					</div>
				</div><!--/ Branch Modifydate -->   				



				<div class="row">&nbsp;</div>
				<div class="row">&nbsp;</div>
				<div class="row">&nbsp;</div>

		
				<div class="form">   
					<div class="row"> 
						<div class="col-md-5"> 
							<div class="col-xs-12">
								<button type="submit" class="btn green" name="post">
									<i class="glyphicon glyphicon-floppy-save"></i> Submit
								</button>                  
						</div>
						</div>
					</div>
				</div><!--/ Panel Footer --> 
			
    
			</div> <!--/ portlet-body form -->
		</div> <!--/ col-md-12 --> 
	</div> <!--/ row --> 
<!--/ Content --> 
 
<?php echo form_close(); ?>  
