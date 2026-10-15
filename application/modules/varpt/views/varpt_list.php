 
<style>
table.dataTable td {
    padding:2px;
    font-size: 9pt;    
}

</style>
 <!-- CONTENT -->

 <!-- /.popup-tenant -->
 <div class="modal fade" id="tedialog" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         </button>
         <h4 class="modal-title">
           Data Tenant
         </h4>
       </div>
       <div class="modal-body">
         <form action="#" id="form" class="form-horizontal">
           <div class="row">
           <div class="col-md-8">
              <label>Search Tenant</label>
             <input  type="text" id="searchTenant" class="form-control input-sm" placeholder="Search Tenant" >
           </div>
           <div class="col-md-4" align="right">
             <br>
             <input type="button" id="btnrek" value = "LOAD" class="btn btn-sm btn-info"/>

           </div>
         </div>

        <div class="portlet-body">
         <div class="table-container">
           <div class="table-scrollable">
             <table class="table table-striped table-bordered table-hover compact nowrap" id='popLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
               <thead>
                <tr>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
                </tr>
               </thead>
               <tbody>
               </tbody>
             </table>
           </div>
         </div>
     </div>
     <br />
     </form>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn dark btn-outline" data-dismiss="modal">
           Close
         </button>
         <button type="button" class="btn green" data-dismiss="modal" id="addtenant">
           Add Selected Data
         </button>
       </div>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>

 <!-- /.popup-region -->
 <div class="modal fade" id="regiondialog" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         </button>
         <h4 class="modal-title">
           Data Business Unit
         </h4>
       </div>
       <div class="modal-body">
         <form action="#" id="form" class="form-horizontal">
           <div class="row">
           <div class="col-md-8">
              <label>Search Business Unit</label>
             <input  type="text" id="searchRegion" class="form-control input-sm" placeholder="Search Region" >
           </div>
           <div class="col-md-4" align="right">
             <br>
             <input type="button" id="btnregion" value = "LOAD" class="btn btn-sm btn-info"/>
           </div>
         </div>

        <div class="portlet-body">
         <div class="table-container">
           <div class="table-scrollable">
             <table class="table table-striped table-bordered table-hover compact nowrap" id='regionLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
               <thead>
                <tr>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Name</th>
                </tr>
               </thead>
               <tbody>
               </tbody>
             </table>
           </div>
         </div>
     </div>
     <br />
     </form>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn dark btn-outline" data-dismiss="modal">
           Close
         </button>
         <button type="button" class="btn green" data-dismiss="modal" id="addregion">
           Add Selected Data
         </button>
       </div>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>
 
        <div class="modal" id="mdlinfo" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="mdltitle">Success!</h4>
              </div>
              <div class="modal-body" id="mdlbody">
                <p>Data has been saved&hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default center-block" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		
 <!-- /.popup-branch -->
 <div class="modal fade" id="storedialog" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         </button>
         <h4 class="modal-title">
           Data Store
         </h4>
       </div>
       <div class="modal-body">
         <form action="#" id="form" class="form-horizontal">
           <div class="row">
           <div class="col-md-8">
              <label>Search Store</label>
             <input  type="text" id="searchStore" class="form-control input-sm" placeholder="Search Store" >
           </div>
           <div class="col-md-4" align="right">
             <br>
             <input type="button" id="btnstore" value = "LOAD" class="btn btn-sm btn-info"/>
           </div>
         </div>

        <div class="portlet-body">
         <div class="table-container">
           <div class="table-scrollable">
             <table class="table table-striped table-bordered table-hover compact nowrap" id='branchLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
               <thead>
                <tr>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Name</th>
                </tr>
               </thead>
               <tbody>
               </tbody>
             </table>
           </div>
         </div>
     </div>
     <br />
     </form>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn dark btn-outline" data-dismiss="modal">
           Close
         </button>
         <button type="button" class="btn green" data-dismiss="modal" id="addstore">
           Add Selected Data
         </button>
       </div>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>

 <!-- /.popup-Shipping -->
 <div class="modal fade" id="branddialog" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         </button>
         <h4 class="modal-title">
           Data Brand
         </h4>
       </div>
       <div class="modal-body">
         <form action="#" id="form" class="form-horizontal">
           <div class="row">
           <div class="col-md-8">
              <label>Search Brand</label>
             <input  type="text" id="searchbrand" class="form-control input-sm" placeholder="Search Brand" >
           </div>
           <div class="col-md-4" align="right">
             <br>
             <input type="button" id="btnbrand" value = "LOAD" class="btn btn-sm btn-info"/>
           </div>
         </div>

        <div class="portlet-body">
         <div class="table-container">
           <div class="table-scrollable">
             <table class="table table-striped table-bordered table-hover compact nowrap" id='brandLoader2' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
               <thead>
                <tr>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                 <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Name</th>
                </tr>
               </thead>
               <tbody>
               </tbody>
             </table>
           </div>
         </div>
     </div>
     <br />
     </form>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn dark btn-outline" data-dismiss="modal">
           Close
         </button>
         <button type="button" class="btn green" data-dismiss="modal" id="addbrand">
           Add Selected Data
         </button>
       </div>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>
 
			
                      <?php echo form_open('varpt/vaprinfpdf'," target='_blank' id='FormE'"); ?>
					  <input type="hidden" id="jurnal_id" name="jurnal_id" value="">
					  <input type="hidden" id="jurnal_descr" name="jurnal_descr" value="">
					  <input type="hidden" id="amount" name="amount" value="">
					  <input type="hidden" id="contract_no" name="contract_no" value="">
					  <input type="hidden" id="jurnal_id2" name="jurnal_id2" value="">
					  <input type="hidden" id="jurnal_descr2" name="jurnal_descr2" value="">
					  <input type="hidden" id="faktur_id" name="faktur_id" value="">
					  <input type="hidden" id="jurnal_no" name="jurnal_no" value="">
					  <!-- 1 --> 
					  <div class="row"> 
					  <div class="col-md-12">
					  
							  

							
							

							  
							  
							  
              <div class="col-md-4">

                  <label class="checkbox-inline"><input type="checkbox" id="cbunit">Business Unit</label>
                  <div class="input-group input-group-sm">
                    <input type="text" id = "iregion" name="iregion" class="form-control input-sm" value="" required autocomplete="off" readonly>
                    <span class="input-group-btn">
                      <button id ="btregion" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
                    </span>
                  <input type="hidden" id = "hregion" name="hregion" value="">
                  </div>
              </div>

                <div class="col-md-4">
                    <label class="checkbox-inline"><input type="checkbox" id="cbranch">Store</label>
                    <div class="input-group input-group-sm">
                      <input type="text" id = "ibranch" name="ibranch" class="form-control input-sm" value="" required autocomplete="off" readonly>
                      <span class="input-group-btn">
                        <button id ="btbranch" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
                      </span>
                    <input type="hidden" id = "hbranch" name="hbranch" value="">
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="checkbox-inline"><input type="checkbox" id="ctenant">Tenant</label>
                    <div class="input-group input-group-sm">
                      <input type="text" id = "itenant" name="itenant" class="form-control input-sm" value="" required autocomplete="off" readonly>
                      <span class="input-group-btn">
                        <button id ="bttenant" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
                      </span>
                    <input type="hidden" id = "htenant" name="htenant" value="">
                    </div>
                </div>
							      

										

							  

							  

							 
							 <div class="row">  
							   
                              <div class="col-md-4 form-group "> 
                                <br>
                                <input type="button" id="btnload" value = "LOAD" class="btn btn-sm btn-info"/>
                              </div>
							  <div class="col-md-4 form-group " align ="right"> 
                                
                              </div>							  
							  <div class="col-md-4 form-group " align ="right"> 
                                <br>
                                <input type="button" id="btnprint" value = "PRIVIEW" class="btn btn-sm btn-info"/>
                              </div>							  
                              </div>
							  <br>
							  <br>
                              </div>
							  

                  <div class="portlet-body">
                           <div class="table-container">
                             <div class="table-scrollable">
                                 <table class="table table-striped table-hover nowrap" id='brandLoader' style="border-color: #E0E0E0;">
                                 	  <thead>
                                  		<tr>
                                        <th>ID</th>
										<th>Line</th>
                                        <th>Name</th>
                                        <th>Name Report</th>
										<th>Address</th>
                                        <th>Contact Name</th>
                                        <th>Contact HP</th>
                                        <th>Contact Telp</th>
										<th>Contact Email</th>
										<th>Debtor Code</th>
                                        <th>Type</th>
										<th>BrnachID</th>
                                  		</tr>
                				            </thead>
                              		<tbody>
                              		</tbody>
                            	   </table>
                        </div>						
                      </div>                  
				  </div>	
				  
                      <?php echo form_close(); ?>      
					  <!-- 1 -->
				 
              <!-- END OF CONTENT -->
			  
<script> 
$.fn.datepicker.defaults.format = "yyyy-mm-dd";
$.fn.datepicker.defaults.autoclose = true;

$(document).ready(function(){ 

  var oTable=listgrid("<?php echo site_url('varpt/varpt/controler_gridbrand')?>","brandLoader","lfrtip",200);
  var tenantTable=popgrid("<?php echo site_url('varpt/varpt/controler_gridtenant')?>","popLoader","trp", 10);
  var regionTable=popgrid("<?php echo site_url('varpt/varpt/controler_gridregion')?>","regionLoader","trp", 10);
  var branchTable=popgrid("<?php echo site_url('varpt/varpt/controler_gridbranch')?>","branchLoader","trp", 10);
  //var brandTable=popgrid("<?php echo site_url('varpt/varpt/controler_gridbrand')?>","brandLoader","trp", 10);
  

	$('.tanggal').datepicker();

	$('#btcleart_1').click(function() {    

	$('#f_date').val('');     

	});

	$('#btcleart_2').click(function() {    

	$('#t_date').val('');     

	});
	$('#btcleart_3').click(function() {    

	$('#p_date').val('');     

	});

	$('#report_type').select2({
				placeholder: 'Pilih Tipe Report', 
				tags: true,
				allowClear: true,
				width: '100%' 			
			});  
	$('#region_id').select2({
		  placeholder: 'Select an option',
		  minimumInputLength: 2,
		  allowClear: true,
		  //tags: true,
		  minimumResultsForSearch: 10,
		  tokenSeparators: [',', ' '],
		  ajax: {
			  url: '<?php echo site_url('varpt/region_select_dialog')?>',
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
						  $('#region_name_hidden').val(item.region_name);
						  return {

							  text: item.region_name, 
							  id: item.region_id,
						  } 
						
					  })
				  };
			  }
		  }
	  });	
	$('#agrType').select2({
				placeholder: 'Pilih', 
				tags: true,
				allowClear: true,
				width: '100%' 			
			});   
	$('#property_grade').select2({
				placeholder: 'Pilih', 
				tags: true,
				allowClear: true,
				width: '100%' 			
			});   
	$('#grouptenant').select2({
				placeholder: 'Pilih', 
				tags: true,
				allowClear: true,
				width: '100%' 			
			});   
	$('#unalloc_select').select2({
				placeholder: 'Pilih', 
				tags: true,
				allowClear: true,
				width: '100%' 			
			});   
	$('#wht').select2({
				placeholder: 'Pilih', 
				tags: true,
				allowClear: true,
				width: '100%' 			
			});   
	$('#branch_id').select2({
		  placeholder: 'Select an option',
		  minimumInputLength: 2,
		  allowClear: true,
		  //tags: true,
		  minimumResultsForSearch: 10,
		  tokenSeparators: [',', ' '],
		  ajax: {
			  url: '<?php echo site_url('varpt/branch_select_dialog')?>',
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
 	$('#acc_ids').select2({
		  placeholder: 'Select an option',
		  minimumInputLength: 2,
		  allowClear: true,
		  //tags: true,
		  minimumResultsForSearch: 10,
		  tokenSeparators: [',', ' '],
		  ajax: {
			  url: '<?php echo site_url('varpt/acc_select_dialog')?>',
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

							  text: item.acc_id+' | '+item.acc_name, 
							  id: item.acc_id
						  }
					  })
				  };
			  }
		  }
	  });
 	$('#rekanan_id').select2({
		  placeholder: 'Select an option',
		  minimumInputLength: 2,
		  allowClear: true,
		  //tags: true,
		  minimumResultsForSearch: 10,
		  tokenSeparators: [',', ' '],
		  ajax: {
			  url: '<?php echo site_url('varpt/rekanan_select_dialog')?>',
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

							  text: item.rekanan_name, 
							  id: item.rekanan_id
						  }
					  })
				  };
			  }
		  }
	  });
	$('#rekananshipping_id').select2({
		  placeholder: 'Select an option',
		  minimumInputLength: 2,
		  allowClear: true,
		  //tags: true,
		  minimumResultsForSearch: 10,
		  tokenSeparators: [',', ' '],
		  ajax: {
			  url: '<?php echo site_url('varpt/rekananshipping_select_dialog')?>',
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

							  text: item.rekananshipping_name, 
							  id: item.rekananshipping_line,
							  rekanan: item.rekanan_id,
							  rekanan_name: item.rekanan_name,
						  }
					  })
				  };
			  }
		  }
	  });	
	$('#rekananshipping_id').on("select2:select", function(e) {
		var valuenya = e.params.data; 
		var data = {
			text: valuenya.rekanan_name,
			id: valuenya.rekanan
		}; 
		 
		console.log(data);
		var newOption = new Option(data.text, data.id, true, true);
		$('#rekanan_id').select2({data: [{id: '', text: ''}]});
		$('#rekanan_id').empty();
		$('#rekanan_id').append(newOption).trigger('change');
		 
	});
	$('#rekanan_id').change(function(){
		$('#rekananshipping_id').empty();
	}); 

	
	$('#bSearch').click(function(){
		 
		// if($('#f_date').val() === '')
		// {
			// alert('Pilih Start Date');
			// return false;
		// };
		if($('#region_id').val() === '0')
		{
			alert('Pilih Business Unit');
			return false;
		};
		if($('#report_type').val() === '')
		{
			alert('Pilih Type Report');
			return false;
		};
		 
		
	});
	
      $('#btnload').click( function() {
          var searchRegion = $("#hregion").val();
          var searchBranch  = $("#hbranch").val();
          var searchTenant = $("#htenant").val();
		  
		  //alert('Pilih Business Unit');
 
		 // alert(searchRegion);
		 // alert(searchBranch);
		 // alert(searchtglstart);
          oTable.search('');
          //oTable.search(searchRegion).draw();
          //oTable.search(searchBranch);

          //oTable.search(searchID).draw();
          oTable.column(0).search(searchBranch);
          oTable.column(1).search(searchTenant);
          oTable.draw();
      });
	  
	  var _jumlah = 0;
	  var samount = 0;
	  var stamount = 0;
	  
	  $('#btnprint').click( function() {

		var rData = oTable.rows('.selected').data();

         for (var i=0; i < rData.length ;i++){

            // var tid     = rData[i][0];
            // var tname   = rData[i][1];
			
			 		//alert('tes');
			var rekananid = rData[i][0];
			var rekananshipping_line = rData[i][1];
			//var deptor_code = $("#rowid").val(); 
			var branchid = rData[i][11];
			var regionid = $("#hregion_id").val(); 
			if(branchid == '')
			{
				alert('branch belum dipilih');
				exit;
			}
			//var search = deptor_code . '_' . rekananid;// . rekananshipping_line;
			var url = "<?= site_url('vaprint/vaprint/vaprintpdf/');?>"+rekananid+rekananshipping_line;
			window.open(url,'_blank');
			
        }

		

		
	  });
	  

  $('#bttenant').click(function() {
    var search  = $("#hbranch").val();
    tenantTable.search(search).draw();
    //tenantTable.rows('.selected').deselect();
    $("#tedialog").modal("show");
  });

  $('#btregion').click(function() {
    regionTable.rows('.selected').deselect();
    $("#regiondialog").modal("show");
  });

  $('#btbranch').click(function() {

    var search  = $("#hregion").val();
    branchTable.search(search).draw();
    //branchTable.rows('.selected').deselect();
    $("#storedialog").modal("show");
  });

  $('#btbrand').click(function() {
    var search  = $("#htenant").val();
    brandTable.search(search).draw();
    //brandTable.rows('.selected').deselect();
    $("#branddialog").modal("show");
  });


  $('#addtenant').click(function () {
      var linenum=0;
       var rData = tenantTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid     = rData[i][0];
          var tname   = rData[i][1];

          $('#htenant').val(tid);
          $('#itenant').val(tname);

          $('#hbrand').val('');
          $('#ibrand').val('');
          $('#hagrtype').val('');
          $('#iagrtype').val('');
      }
  });

  $('#addregion').click(function () {
      var linenum=0;
       var rData = regionTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid     = rData[i][0];
          var tname   = rData[i][1];

          $('#hregion').val(tid);
          $('#iregion').val(tname);

          $('#hbranch').val('');
          $('#ibranch').val('');
          $('#htenant').val('');
          $('#itenant').val('');
          $('#hbrand').val('');
          $('#ibrand').val('');
          $('#hagrtype').val('');
          $('#iagrtype').val('');
      }
  });

  $('#addstore').click(function () {
      var linenum=0;
       var rData = branchTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid     = rData[i][0];
          var tname   = rData[i][1];

          $('#hbranch').val(tid);
          $('#ibranch').val(tname);

          $('#htenant').val('');
          $('#itenant').val('');
          $('#hbrand').val('');
          $('#ibrand').val('');
          $('#hagrtype').val('');
          $('#iagrtype').val('');
      }
  });

  $('#addbrand').click(function () {
      var linenum=0;
       var rData = brandTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid     = rData[i][0];
          var tname   = rData[i][1];

          $('#hbrand').val(tid);
          $('#ibrand').val(tname);
      }
  });


  $('#btnrek').click(function() {
      var searchTenant  = $("#searchTenant").val();
      tenantTable.search(searchTenant).draw();
    });

    $('#btnregion').click(function() {
        var search  = $("#searchRegion").val();

        regionTable.search(search).draw();
      });

    $('#btnstore').click(function() {
        var search  = $("#searchStore").val();
        branchTable.search(search).draw();
      });

    $('#btnbrand').click(function() {
        var search  = $("#searchbrand").val();
      brandTable.search(search).draw();
      });


      $('#cbunit').change(function(){
        if($(this).is(':checked')){
            $('#btregion').prop('disabled',false);
        } else {
            //alert('not checked');
            //$('#iregion').prop('readonly',false);
            $('#btregion').prop('disabled',true);
            $('#hregion').val('');
            $('#iregion').val('');
        }
      })

      $('#cbranch').change(function(){
        if($(this).is(':checked')){
            $('#btbranch').prop('disabled',false);
        } else {
            $('#btbranch').prop('disabled',true);
            $('#hbranch').val('');
            $('#ibranch').val('');
        }
      })
      $('#ctenant').change(function(){
        if($(this).is(':checked')){
            $('#bttenant').prop('disabled',false);
        } else {
            $('#bttenant').prop('disabled',true);
            $('#htenant').val('');
            $('#itenant').val('');
        }
      })
      $('#cbrand').change(function(){
        if($(this).is(':checked')){
            $('#btbrand').prop('disabled',false);
        } else {
            $('#btbrand').prop('disabled',true);
            $('#hbrand').val('');
            $('#ibrand').val('');
        }
      })
      $('#cselect').change(function(){
        if($(this).is(':checked')){
			oTable.rows().select();			
        } else {
            oTable.rows('.selected').deselect();
        }
      })	  
	  
});

</script>