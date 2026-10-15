<script>
$(document).ready(function() {
    $('.idutilitiesair').select2({
		 placeholder: 'Pilih Data', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
	});
    $('.parent').select2({
		 placeholder: 'Pilih Data', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
	});
  var listlistrik=[];
  var listair=[];
  var listgas=[];
  var listrikTable=popgrid("<?php echo site_url('master_branch/master_branch/controler_gridlistrik')?>","listrikLoader","trp", 10);
  var airTable=popgrid("<?php echo site_url('master_branch/master_branch/controler_gridair')?>","airLoader","trp", 10);
  var gasTable=popgrid("<?php echo site_url('master_branch/master_branch/controler_gridgas')?>","gasLoader","trp", 10);
	
  $('.dropkva').select2({    
      minimumInputLength: 0,
      placeholder: 'Select an option',
      ajax: {
          url: '<?php echo site_url('master_branch/master_branch/kva_select')?>',
          dataType: 'json',
          type: "GET",
          data: function () {
              return {
                  //branch: $('#ibranch').val(),
                  //region: $('#iregion').val(),
                  //loonum: $('#agreement_loonumber').val()
              };
          },
          processResults: function (data) {
              return {
                  results: $.map(data.items, function (item) {                        
                      return {
                          id: item.utilitieskva_id,
                          text: item.utilitieskva_name
                      }
                  })
              };
          }
      }

  });	
  
  $('#addlistrik').click(function() {
  
  //alert('Please, select data from list');
	$("#listrikdialog").modal("show");				
	//break;
  

  });
  $('#addair').click(function() {
  
  //alert('Please, select data from list');
	$("#airdialog").modal("show");				
	//break;
  

  });
  $('#addgas').click(function() {
  
  //alert('Please, select data from list');
	$("#gasdialog").modal("show");				
	//break;
  

  });
  $('#btnloadlistrik').click( function() {    
      var searchName = $("#slistrikName").val();
      var searchID  = $("#slistrikID").val();

      listrikTable.search('');      

      listrikTable.column(0).search(searchID);
      listrikTable.column(1).search(searchName);
      listrikTable.draw();
  });
  $('#btnloadair').click( function() {    
      var searchName = $("#sairName").val();
      var searchID  = $("#sairID").val();

      airTable.search('');      

      airTable.column(0).search(searchID);
      airTable.column(1).search(searchName);
      airTable.draw();
  });
  $('#btnloadgas').click( function() {    
      var searchName = $("#sgasName").val();
      var searchID  = $("#sgasID").val();

      gasTable.search('');      

      gasTable.column(0).search(searchID);
      gasTable.column(1).search(searchName);
      gasTable.draw();
  });
  
  $("#listrikTab").on('click','#listrikDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }
      $(this).closest('tr').remove();  
  });
  $("#airTab").on('click','#airDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }
      $(this).closest('tr').remove();  
  });
  $("#gasTab").on('click','#gasDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }
      $(this).closest('tr').remove();  
  });  
$('#addbtnlistrik').click(function () { 

      var linenum=0;
      var oData = listrikTable.rows('.selected').data();        

       for (var i=0; i < oData.length; i++){
        
         
			var sutilitieslistrik_id=oData[i][0];
			var sutilitieslistrik_name=oData[i][1];
			var sutilitieslistrik_amp=oData[i][2];
			var sutilitieslistrik_phase=oData[i][3];
			var sutilitieslistrik_kva=oData[i][4];
			var sutilitieslistrik_faktor=oData[i][5];
			var sutilitieslistrik_issingglemeter=oData[i][6];
			var sutilitieslistrik_isadditional=oData[i][7];
			var sutilitieslistrik_admpercent=oData[i][8];
			var sutilitieslistrik_admamount=oData[i][9];
			var sutilitieslistrik_bpju=oData[i][10];
			var sutilitieskva_name=oData[i][11];
			var stariflwbp_calcbyuser=oData[i][12];
			var starifwbp_calcbyuser=oData[i][13];
			var sselisih_calcbyuser=oData[i][14];
			var sselisihlwbp_calcbyuser=oData[i][15];
			var sselisihwbp_calcbyuser=oData[i][16];
			var spemakaianwbp_calcbyuser=oData[i][17];
			var spemakaianlwbp_calcbyuser=oData[i][18];
			var sutilitieslistrik_isgenset=oData[i][19];
			var sutilitieslistrik_isblocked=oData[i][20];
			var sutilitieslistrik_isdisabled=oData[i][21];
			var sutilitieskva_id=oData[i][22];
		  
          var Branch  = $("#branch_id").val();       
          //console.log(sutilitieslistrik_issingglemeter);
		   var csinglemeter = 'CHECKED';
		   if(sutilitieslistrik_issingglemeter != 1)
		   {csinglemeter = '';}
   		  var cadditional = 'CHECKED';
		   if(sutilitieslistrik_isadditional != 1)
		   {cadditional = '';}
		var cgenset = 'CHECKED';
		   if(sutilitieslistrik_isgenset != 1)
		   {cgenset = '';}
	   var cblocked = 'CHECKED';
		   if(sutilitieslistrik_isblocked != 1)
		   {cblocked = '';}
	   var cdisabled = 'CHECKED';
		   if(sutilitieslistrik_isdisabled != 1)
		   {cdisabled = '';}
	   var ctariflwbp_calcbyuser = 'CHECKED';
		   if(stariflwbp_calcbyuser != 1)
		   {ctariflwbp_calcbyuser = '';}
	   var ctarifwbp_calcbyuser = 'CHECKED';
		   if(starifwbp_calcbyuser != 1)
		   {ctarifwbp_calcbyuser = '';}
	   var cselisih_calcbyuser = 'CHECKED';
		   if(sselisih_calcbyuser != 1)
		   {cselisih_calcbyuser = '';}
	   var cselisihlwbp_calcbyuser = 'CHECKED';
		   if(sselisihlwbp_calcbyuser != 1)
		   {cselisihlwbp_calcbyuser = '';}
	   var cselisihwbp_calcbyuser = 'CHECKED';
		   if(sselisihwbp_calcbyuser != 1)
		   {cselisihwbp_calcbyuser = '';}
	   var cpemakaianwbp_calcbyuser = 'CHECKED';
		   if(spemakaianwbp_calcbyuser != 1)
		   {cpemakaianwbp_calcbyuser = '';}
	   var cpemakaianlwbp_calcbyuser = 'CHECKED';
		   if(spemakaianlwbp_calcbyuser != 1)
		   {cpemakaianlwbp_calcbyuser = '';}
	   
	   
          var max=GetDgvLineMaxNum('listrikTab',0)
          linenum= Number(max) + 10;
          var t="tcharge"+linenum;          

          $('#listrikTab tbody').append('<tr>'+
			'<td><input type="text" name="utilitieslistrik_id[]" value="'+ sutilitieslistrik_id +'" class="form-control input-sm" readonly /></td>'+
			'<td><input type="text" name="utilitieslistrik_name[]" value="'+ sutilitieslistrik_name +'" class="form-control input-sm" readonly /></td>'+
			'<td><input type="text" name="utilitieslistrik_amp[]" value="'+ sutilitieslistrik_amp +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" name="utilitieslistrik_phase[]" value="'+ sutilitieslistrik_phase +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" name="utilitieslistrik_kva[]" value="'+ sutilitieslistrik_kva +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" name="utilitieslistrik_faktor[]" value="'+ sutilitieslistrik_faktor +'" class="form-control input-sm"/></td>'+
			'<td><input type="checkbox" id="utilitieslistrik_issingglemeter" name="utilitieslistrik_issingglemeter[]" value="'+ sutilitieslistrik_issingglemeter +'" style="text-align:right;" '+csinglemeter+'><input type="hidden" id="sutilitieslistrik_issingglemeter" name="utilitieslistrik_issingglemeter[]" value="'+ sutilitieslistrik_issingglemeter +'"/></td>'+
			'<td><input type="checkbox" id="utilitieslistrik_isadditional" name="utilitieslistrik_isadditional[]" value="'+ sutilitieslistrik_isadditional +'" style="text-align:right;" '+cadditional+'><input type="hidden" id="utilitieslistrik_isadditional" name="utilitieslistrik_isadditional[]" value="'+ sutilitieslistrik_isadditional +'"/></td>'+
			'<td><input type="text" name="utilitieslistrik_admpercent[]" value="'+ sutilitieslistrik_admpercent +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" name="utilitieslistrik_admamount[]" value="'+ sutilitieslistrik_admamount +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" name="utilitieslistrik_bpju[]" value="'+ sutilitieslistrik_bpju +'" class="form-control input-sm"/></td>'+
			'<td><div class="form-group form-group-sm"><select data-placeholder = "Select KVA" id= "utilitieskva_id" name= "utilitieskva_id[]" required class="dropkva form-control input-sm" style="width: 100%;">'+
			'<option value="'+sutilitieskva_id+'" selected="selected" >'+sutilitieskva_name+'</option>'+
            '</select></div><input type="hidden" id="c_una" name="cuna[]" value="" /></td>'+
			'<td><input type="checkbox" id="tariflwbp_calcbyuser" name="tariflwbp_calcbyuser[]" value="'+ stariflwbp_calcbyuser +'" style="text-align:right;" '+ctariflwbp_calcbyuser+'><input type="hidden" id="tariflwbp_calcbyuser" name="tariflwbp_calcbyuser[]" value="'+ stariflwbp_calcbyuser +'"/></td>'+
			'<td><input type="checkbox" id="tarifwbp_calcbyuser" name="tarifwbp_calcbyuser[]" value="'+ starifwbp_calcbyuser +'" style="text-align:right;" '+ctarifwbp_calcbyuser+'><input type="hidden" id="tarifwbp_calcbyuser" name="tarifwbp_calcbyuser[]" value="'+ starifwbp_calcbyuser +'"/></td>'+
			'<td><input type="checkbox" id="selisih_calcbyuser" name="selisih_calcbyuser[]" value="'+ sselisih_calcbyuser +'" style="text-align:right;" '+cselisih_calcbyuser+'><input type="hidden" id="selisih_calcbyuser" name="selisih_calcbyuser[]" value="'+ sselisih_calcbyuser +'"/></td>'+
			'<td><input type="checkbox" id="selisihlwbp_calcbyuser" name="selisihlwbp_calcbyuser[]" value="'+ sselisihlwbp_calcbyuser +'" style="text-align:right;" '+cselisihlwbp_calcbyuser+'><input type="hidden" id="selisihlwbp_calcbyuser" name="selisihlwbp_calcbyuser[]" value="'+ sselisihlwbp_calcbyuser +'"/></td>'+
			'<td><input type="checkbox" id="selisihwbp_calcbyuser" name="selisihwbp_calcbyuser[]" value="'+ sselisihwbp_calcbyuser +'" style="text-align:right;" '+cselisihwbp_calcbyuser+'><input type="hidden" id="selisihwbp_calcbyuser" name="selisihwbp_calcbyuser[]" value="'+ sselisihwbp_calcbyuser +'"/></td>'+
			'<td><input type="checkbox" id="pemakaianwbp_calcbyuser" name="pemakaianwbp_calcbyuser[]" value="'+ spemakaianwbp_calcbyuser +'" style="text-align:right;" '+cpemakaianwbp_calcbyuser+'><input type="hidden" id="pemakaianwbp_calcbyuser" name="pemakaianwbp_calcbyuser[]" value="'+ spemakaianwbp_calcbyuser +'"/></td>'+
			'<td><input type="checkbox" id="pemakaianlwbp_calcbyuser" name="pemakaianlwbp_calcbyuser[]" value="'+ spemakaianlwbp_calcbyuser +'" style="text-align:right;" '+cpemakaianlwbp_calcbyuser+'><input type="hidden" id="pemakaianlwbp_calcbyuser" name="pemakaianlwbp_calcbyuser[]" value="'+ spemakaianlwbp_calcbyuser +'"/></td>'+
			'<td><input type="checkbox" id="utilitieslistrik_isgenset" name="utilitieslistrik_isgenset[]" value="'+ sutilitieslistrik_isgenset +'" style="text-align:right;" '+cgenset+'><input type="hidden" id="utilitieslistrik_isgenset" name="utilitieslistrik_isgenset[]" value="'+ sutilitieslistrik_isgenset +'"/></td>'+
			'<td><input type="checkbox" id="utilitieslistrik_isblocked" name="utilitieslistrik_isblocked[]" value="'+ sutilitieslistrik_isblocked +'" style="text-align:right;" '+cblocked+'><input type="hidden" id="utilitieslistrik_isblocked" name="utilitieslistrik_isblocked[]" value="'+ sutilitieslistrik_isblocked +'"/></td>'+
			'<td><input type="checkbox" id="utilitieslistrik_isdisabled" name="utilitieslistrik_isdisabled[]" value="'+ sutilitieslistrik_isdisabled +'" style="text-align:right;" '+cdisabled+'><input type="hidden" id="utilitieslistrik_isdisabled" name="utilitieslistrik_isdisabled[]" value="'+ sutilitieslistrik_isdisabled +'"/></td>'+
			'<td><a id= "listrikDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');
			
			  $('.dropkva').select2({    
			  minimumInputLength: 0,
			  placeholder: 'Select an option',
			  ajax: {
				  url: '<?php echo site_url('master_branch/master_branch/kva_select')?>',
				  dataType: 'json',
				  type: "GET",
				  data: function () {
					  return {
						  //branch: $('#ibranch').val(),
						  //region: $('#iregion').val(),
						  //loonum: $('#agreement_loonumber').val()
					  };
				  },
				  processResults: function (data) {
					  return {
						  results: $.map(data.items, function (item) {                        
							  return {
								  id: item.utilitieskva_id,
								  text: item.utilitieskva_name
							  }
						  })
					  };
				  }
			  }

		  });
          //listlistrik.push({id: rid, text: runit, region: Region, branch: Branch, tenant: Tenant, brand: Brand});
       }

  }); 

$('#addbtnair').click(function () { 

      var linenum=0;
      var oData = airTable.rows('.selected').data();        

       for (var i=0; i < oData.length; i++){
        
         			
		var sutilitiesair_id=oData[i][0];
		var sutilitiesair_name=oData[i][1];
		var sutilitiesair_diameterpipa=oData[i][2];
		var sutilitiesair_adm=oData[i][3];
		var sutilitiesair_phairkotor=oData[i][4];
		var sutilitiesair_phmeter=oData[i][5];
		var sutilitiesair_isadditional=oData[i][6];
		var sphairkotor_isdisabled=oData[i][7];
		var sutilitiesair_admpercent=oData[i][8];
		var sutilitiesair_abonemen=oData[i][9];
		var sutilitiesair_isusedawalakhir=oData[i][10];
		var sutilitiesair_isdisabled=oData[i][11];

			
		  
          var Branch  = $("#branch_id").val();       
          //console.log(sutilitiesair_issingglemeter);
		var cphairkotor_isdisabled = 'CHECKED';
		   if(sphairkotor_isdisabled != 1)
		   {cphairkotor_isdisabled = '';}
   		  var cutilitiesair_isadditional = 'CHECKED';
		   if(sutilitiesair_isadditional != 1)
		   {cutilitiesair_isadditional = '';}
		var cutilitiesair_isusedawalakhir = 'CHECKED';
		   if(sutilitiesair_isusedawalakhir != 1)
		   {cutilitiesair_isusedawalakhir = '';}
	   var cutilitiesair_isdisabled = 'CHECKED';
		   if(sutilitiesair_isdisabled != 1)
		   {cutilitiesair_isdisabled = '';}
	   
	   
	   
          var max=GetDgvLineMaxNum('airTab',0)
          linenum= Number(max) + 10;
          var t="tcharge"+linenum;          

          $('#airTab tbody').append('<tr>'+
			'<td><input type="text" name="utilitiesair_id[]" value="'+ sutilitiesair_id +'" class="form-control input-sm" readonly /></td>'+
			'<td><input type="text" name="utilitiesair_name[]" value="'+ sutilitiesair_name +'" class="form-control input-sm" readonly /></td>'+
			'<td><input type="text" name="utilitiesair_diameterpipa[]" value="'+ sutilitiesair_diameterpipa +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" name="utilitiesair_adm[]" value="'+ sutilitiesair_adm +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" name="utilitiesair_phairkotor[]" value="'+ sutilitiesair_phairkotor +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" name="utilitiesair_phmeter[]" value="'+ sutilitiesair_phmeter +'" class="form-control input-sm"/></td>'+			
			'<td><input type="checkbox" id="utilitiesair_isadditional" name="utilitiesair_isadditional[]" value="'+ sutilitiesair_isadditional +'" style="text-align:right;" '+cutilitiesair_isadditional+'><input type="hidden" id="utilitiesair_isadditional" name="utilitiesair_isadditional[]" value="'+ sutilitiesair_isadditional +'"/></td>'+
			'<td><input type="checkbox" id="phairkotor_isdisabled" name="phairkotor_isdisabled[]" value="'+ sphairkotor_isdisabled +'" style="text-align:right;" '+cphairkotor_isdisabled+'><input type="hidden" id="phairkotor_isdisabled" name="phairkotor_isdisabled[]" value="'+ sutilitiesair_isdisabled +'"/></td>'+
			'<td><input type="text" name="utilitiesair_admpercent[]" value="'+ sutilitiesair_admpercent +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" name="utilitiesair_abonemen[]" value="'+ sutilitiesair_abonemen +'" class="form-control input-sm"/></td>'+			
			'<td><input type="checkbox" id="utilitiesair_isusedawalakhir" name="utilitiesair_isusedawalakhir[]" value="'+ sutilitiesair_isusedawalakhir +'" style="text-align:right;" '+cutilitiesair_isusedawalakhir+'><input type="hidden" id="utilitiesair_isusedawalakhir" name="utilitiesair_isusedawalakhir[]" value="'+ sutilitiesair_isusedawalakhir +'"/></td>'+
			'<td><input type="checkbox" id="utilitiesair_isdisabled" name="utilitiesair_isdisabled[]" value="'+ sutilitiesair_isdisabled +'" style="text-align:right;" '+cutilitiesair_isdisabled+'><input type="hidden" id="utilitiesair_isdisabled" name="utilitiesair_isdisabled[]" value="'+ sutilitiesair_isdisabled +'"/></td>'+
			'<td><a id= "airDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');
			
			  
          //listair.push({id: rid, text: runit, region: Region, branch: Branch, tenant: Tenant, brand: Brand});
       }

  });   
  
  $('#addbtngas').click(function () { 

      var linenum=0;
      var oData = gasTable.rows('.selected').data();        

       for (var i=0; i < oData.length; i++){
        
         			
		var sutilitiesgas_id=oData[i][0];
		var sutilitiesgas_name=oData[i][1];
		var sutilitiesgas_diameterpipa=oData[i][2];
		var sutilitiesgas_adm=oData[i][3];
		var sutilitiesgas_phairkotor=oData[i][4];
		var sutilitiesgas_phmeter=oData[i][5];
		var sutilitiesgas_isadditional=oData[i][6];
		var sutilitiesgas_tarif=oData[i][7];
		var sutilitiesgas_mfaktor=oData[i][8];
		var sutilitiesgas_pressure=oData[i][9];
		var sutilitiesgas_admpercent=oData[i][10];
		var sutilitiesgas_isusedawalakhir=oData[i][11];
		var sutilitiesgas_isdisabled=oData[i][12];

			
		  
          var Branch  = $("#branch_id").val();       
          //console.log(sutilitiesgas_issingglemeter);
   		  var cutilitiesgas_isadditional = 'CHECKED';
		   if(sutilitiesgas_isadditional != 1)
		   {cutilitiesgas_isadditional = '';}
		var cutilitiesgas_isusedawalakhir = 'CHECKED';
		   if(sutilitiesgas_isusedawalakhir != 1)
		   {cutilitiesgas_isusedawalakhir = '';}
	   var cutilitiesgas_isdisabled = 'CHECKED';
		   if(sutilitiesgas_isdisabled != 1)
		   {cutilitiesgas_isdisabled = '';}
	   
	   
	   
          var max=GetDgvLineMaxNum('gasTab',0)
          linenum= Number(max) + 10;
          var t="tcharge"+linenum;          

          $('#gasTab tbody').append('<tr>'+
			'<td><input type="text" name="utilitiesgas_id[]" value="'+ sutilitiesgas_id +'" class="form-control input-sm" readonly /></td>'+
			'<td><input type="text" name="utilitiesgas_name[]" value="'+ sutilitiesgas_name +'" class="form-control input-sm" readonly /></td>'+
			'<td><input type="text" name="utilitiesgas_diameterpipa[]" value="'+ sutilitiesgas_diameterpipa +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" name="utilitiesgas_adm[]" value="'+ sutilitiesgas_adm +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" name="utilitiesgas_phairkotor[]" value="'+ sutilitiesgas_phairkotor +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" name="utilitiesgas_phmeter[]" value="'+ sutilitiesgas_phmeter +'" class="form-control input-sm"/></td>'+			
			'<td><input type="checkbox" id="utilitiesgas_isadditional" name="utilitiesgas_isadditional[]" value="'+ sutilitiesgas_isadditional +'" style="text-align:right;" '+cutilitiesgas_isadditional+'><input type="hidden" id="utilitiesgas_isadditional" name="utilitiesgas_isadditional[]" value="'+ sutilitiesgas_isadditional +'"/></td>'+
			'<td><input type="text" name="utilitiesgas_tarif[]" value="'+ sutilitiesgas_tarif +'" class="form-control input-sm"/></td>'+			
			'<td><input type="text" name="utilitiesgas_mfaktor[]" value="'+ sutilitiesgas_mfaktor +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" name="utilitiesgas_pressure[]" value="'+ sutilitiesgas_pressure +'" class="form-control input-sm"/></td>'+			
			'<td><input type="text" name="utilitiesgas_admpercent[]" value="'+ sutilitiesgas_admpercent +'" class="form-control input-sm"/></td>'+
			'<td><input type="checkbox" id="utilitiesgas_isusedawalakhir" name="utilitiesgas_isusedawalakhir[]" value="'+ sutilitiesgas_isusedawalakhir +'" style="text-align:right;" '+cutilitiesgas_isusedawalakhir+'><input type="hidden" id="utilitiesgas_isusedawalakhir" name="utilitiesgas_isusedawalakhir[]" value="'+ sutilitiesgas_isusedawalakhir +'"/></td>'+
			'<td><input type="checkbox" id="utilitiesgas_isdisabled" name="utilitiesgas_isdisabled[]" value="'+ sutilitiesgas_isdisabled +'" style="text-align:right;" '+cutilitiesgas_isdisabled+'><input type="hidden" id="utilitiesgas_isdisabled" name="utilitiesgas_isdisabled[]" value="'+ sutilitiesgas_isdisabled +'"/></td>'+
			'<td><a id= "gasDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');
			
			  
          //listgas.push({id: rid, text: runit, region: Region, branch: Branch, tenant: Tenant, brand: Brand});
       }

  });   
  
});
</script>
<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

#listrikTab th, #listrikTab td, #listrikTab label {

    font-size: 9pt;
    white-space: nowrap;    
}

#airTab th, #airTab td, #airTab label {

    font-size: 9pt;
    white-space: nowrap;    
}

#gasTab th, #gasTab td, #gasTab label {
    font-size: 9pt;
    white-space: nowrap;    
}

#listrikLoader th, #listrikLoader td, #listrikLoader label {
    font-size: 9pt;
    white-space: nowrap;    
}

.detil {
    padding: 2px;
}

label {
  font-size: 9pt;
  font-weight: bold;
}

.select2-container {
  min-width:120px;
}

</style>
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
				<div class="col-md-1">                
                <?php	
                                  echo anchor(
                                           site_url('master_branch/add'),
                                            '<i class="glyphicon glyphicon-plus"></i>',
                                            'class="btn btn-success btn-sm" data-tooltip="tooltip" data-placement="top" title="Tambah Data"'
                                          );
                 ?> 
				</div> 
				
		<?php
				}
                ?>
	</div>
</div><!-- /.row -->
			
<!-- /.modal-dialog Listrik-->
				<div class="modal fade" id="listrikdialog" tabindex="-1" role="basic" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            </button>
                            <h4 class="modal-title">
                              Master Utilities Listrik
                            </h4>
                          </div>
                          <div class="modal-body">
                            <form action="#" id="form" class="form-horizontal">
                              <div class="row">
                                <div class="col-md-4">
                                   <label>ID</label>
                                  <input  type="text" id="slistrikID" class="form-control input-sm" placeholder="Search ID" >
                                </div>
                                <div class="col-md-4">
                                  <label>Name</label>
                                  <input  type="text" id="slistrikName" class="form-control input-sm" placeholder="Search Name" >
                                </div>
                                <div class="col-md-4" align="right">
                                  <br>
                                  <input type="button" id="btnloadlistrik" value = "LOAD" class="btn btn-sm btn-info"/>
                                </div>
                              </div>
                              <div class="portlet-body">
                                <div class="table-container">
                                  <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-hover nowrap" id='listrikLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                                      <thead>
                                       <tr>
                                        <th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ID</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Name</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">AMP</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Phase</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">KVA</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Faktor</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">S. Meter</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Add</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ADM %</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ADM Rp</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">BPJU</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">KVA Name</th>																			
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">T. LWBP By user</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">T. WBP By user</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Selisih By user</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">S. LWBP By user</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">S. WBP By user</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">P. WBP By user</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">P. LWBP Byuser</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Genset</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Blocked</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Disabled</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">KVA ID</th>
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
                            <button type="button" class="btn green" data-dismiss="modal" id="addbtnlistrik">
                              Accept
                            </button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
					
<!-- /.modal-dialog AIR-->
				<div class="modal fade" id="airdialog" tabindex="-1" role="basic" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            </button>
                            <h4 class="modal-title">
                              Master Utilities AIR
                            </h4>
                          </div>
                          <div class="modal-body">
                            <form action="#" id="form" class="form-horizontal">
                              <div class="row">
                                <div class="col-md-4">
                                   <label>ID</label>
                                  <input  type="text" id="sairID" class="form-control input-sm" placeholder="Search ID" >
                                </div>
                                <div class="col-md-4">
                                  <label>Name</label>
                                  <input  type="text" id="sairName" class="form-control input-sm" placeholder="Search Name" >
                                </div>
                                <div class="col-md-4" align="right">
                                  <br>
                                  <input type="button" id="btnloadair" value = "LOAD" class="btn btn-sm btn-info"/>
                                </div>
                              </div>
                              <div class="portlet-body">
                                <div class="table-container">
                                  <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-hover nowrap" id='airLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                                      <thead>
                                       <tr>
                                        <th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ID</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Name</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Diameter Pipa</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ADM</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">PH Air Kotor</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">PH Meter</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ADM %</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Abodemen</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Additional</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">PH Air Kotor</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Awal Akhir</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Disable</th>
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
                            <button type="button" class="btn green" data-dismiss="modal" id="addbtnair">
                              Accept
                            </button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>

<!-- /.modal-dialog GAS-->
				<div class="modal fade" id="gasdialog" tabindex="-1" role="basic" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            </button>
                            <h4 class="modal-title">
                              Master Utilities gas
                            </h4>
                          </div>
                          <div class="modal-body">
                            <form action="#" id="form" class="form-horizontal">
                              <div class="row">
                                <div class="col-md-4">
                                   <label>ID</label>
                                  <input  type="text" id="sgasID" class="form-control input-sm" placeholder="Search ID" >
                                </div>
                                <div class="col-md-4">
                                  <label>Name</label>
                                  <input  type="text" id="sgasName" class="form-control input-sm" placeholder="Search Name" >
                                </div>
                                <div class="col-md-4" align="right">
                                  <br>
                                  <input type="button" id="btnloadgas" value = "LOAD" class="btn btn-sm btn-info"/>
                                </div>
                              </div>
                              <div class="portlet-body">
                                <div class="table-container">
                                  <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-hover nowrap" id='gasLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                                      <thead>
                                       <tr>
                                        <th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ID</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Name</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Diameter Pipa</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ADM</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">PH Air Kotor</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">PH Meter</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ADM %</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Tarif</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">M Faktor</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Pressure</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Additional</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Awal Akhir</th>																						
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Disabled</th>
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
                            <button type="button" class="btn green" data-dismiss="modal" id="addbtngas">
                              Accept
                            </button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>					


	<div class="col-md-1">                
					<?php	
									  echo anchor(
											   site_url('master_branch'),
												'<i class="glyphicon glyphicon-list"></i>',
												'class="btn btn-success btn-sm" data-tooltip="tooltip" data-placement="top" title="List Data"'
											  );
					 ?> 
				 </div>		
<?php echo form_open(site_url('master_branch/' . $action),'role="form" class="form-horizontal" id="form_master_branch" parsley-validate'); ?>               
					
<!--content--> 
	<div class="row">
		<div class="col-md-12">
		  <div class="portlet-body form">
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-5">
					   <label for="branch_id" class="control-label">ID</label> 
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'branch_id',
										 'id'           => 'branch_id',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Auto',
										 'readonly'  	=> true,
										 'maxlength'	=>'7'
										 ),
										 set_value('branch_id',$master_branch['branch_id'])
								   );             
						  ?>
						 <?php echo form_error('branch_id');?> 
					</div>
					 <label for="branch_isdisabled" class="checkbox-inline">Disabled                                    
						  <?php                  
						   echo form_checkbox(
									array(
										 'name'  => 'branch_isdisabled',
										 'id'    => 'branch_isdisabled',                       
										 'class' => 'form-control input-sm ',                                 
										 )
									)             
						  ?></label>
						 <?php echo form_error('branch_isdisabled');?> 
						 <label for="branch_isgroup" class="checkbox-inline">Is Group                                   
						  <?php                  
						   echo form_checkbox(
									array(
										 'name'  => 'branch_isgroup',
										 'id'    => 'branch_isgroup',                       
										 'class' => 'form-control input-sm ',                                 
										 )
									)             
						  ?></label>
						 <?php echo form_error('branch_isgroup');?> 
				</div><!--/ Branch --> <!--/ Branch Isdisabled --> <!--/ Branch Isgroup -->  
				
				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="branch_name" class="control-label">Name</label>                                   
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'branch_name',
											 'id'           => 'branch_name', 
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Branch Name',
											 'maxlength'=>'50'
											 ),
											  set_value('branch_name',$master_branch['branch_name'])
									   );             
							  ?>
							 <?php echo form_error('branch_name');?> 
					</div>
				</div><!--/ Branch Name --> 
				
				  <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="branch_nameshort" class="control-label">Name Short</label>                                   
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'branch_nameshort',
											 'id'           => 'branch_nameshort',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Branch Nameshort',
											 'maxlength'=>'50'
											 ),
											 set_value('branch_nameshort',$master_branch['branch_nameshort'])
									   );             
							  ?>
							 <?php echo form_error('branch_nameshort');?> 
					</div>
				</div><!--/ Branch Nameshort --> 
				
				  <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="branch_namerpt" class="control-label">Long Name Report</label>                                   
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'branch_namerpt',
											 'id'           => 'branch_namerpt',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Branch Report Name',
											 'maxlength'=>'50'
											 ),
											 set_value('branch_namerpt',$master_branch['branch_namerpt'])
									   );             
							  ?>
							 <?php echo form_error('branch_namerpt');?> 
					</div>
				</div><!--/ Branch Nameshort -->
				
				  <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="branch_namerpt" class="control-label">Short Name Report</label>                                   
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'branch_namereport',
											 'id'           => 'branch_namereport',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Branch Report Name',
											 'maxlength'=>'50'
											 ),
											 set_value('branch_namereport',$master_branch['branch_namereport'])
									   );             
							  ?>
							 <?php echo form_error('branch_namereport');?> 
					</div>
				</div><!--/ Branch Nameshort --> 
				 
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						 <label for="branch_city" class="control-label">City</label>                          
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'branch_city',
										 'id'           => 'branch_city',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Branch City',
										 'maxlength'=>'30'
										 ),
										 set_value('branch_city',$master_branch['branch_city'])
								   );             
						  ?>
						 <?php echo form_error('branch_city');?> 
					</div>
				</div><!--/ Branch City --> 
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
					 <label for="branch_telp" class="control-label">Telp</label> 
					  <?php                  
					   echo form_input(
									array(
									 'name'         => 'branch_telp',
									 'id'           => 'branch_telp',                       
									 'class'        => 'form-control input-sm ',
									 'placeholder'  => 'Branch Telp',
									 'maxlength'=>'30'
									 ),
									 set_value('branch_telp',$master_branch['branch_telp'])
							   );             
					  ?>
					 <?php echo form_error('branch_telp');?>  
					</div>
				</div><!--/ Branch Telp --> 
				 
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="branch_parent" class="control-label">Parent</label>                                  
							  <?php                  
							   echo form_dropdown(
									   'branch_parent',
									   $branch_parent_combo,  
									   set_value('branch_parent',$master_branch['branch_parent']),
									   'class="form-control parent" id="single"'
									   );             
							  ?>
							 <?php echo form_error('branch_parent');?>  
					</div>
				</div><!--/ Branch Parent --> 
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						 <label for="branch_path" class="control-label">Path</label>                                   
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'branch_path',
										 'id'           => 'branch_path',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Branch Path',
										 'readonly'  	=> TRUE,
										 'maxlength'=>'255'
										 ),
										 set_value('branch_path',$master_branch['branch_path'])
								   );             
						  ?>
						 <?php echo form_error('branch_path');?> 
					</div>
				</div><!--/ Branch Path --> 
				
			    <div class="col-md-4 form-group row" align="left">
					<div class="col-xs-12">
						<label for="branch_closingdate" class="control-label">Closing Date</label>    
						<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" >
						  <?php       
						   $close_date = date_format( date_create($master_branch['branch_closingdate']), 'Y-m-d ' );  
						   echo form_input(
										array(
										 'name'         => 'branch_closingdate',
										 'id'           => 'branch_closingdate', 
										 'class'        => 'form-control input-sm tanggal ',
										 'placeholder'  => 'Branch Closingdate',
										 'readonly'		=> TRUE, 
										 ),
										 set_value('branch_closingdate',$close_date)
								   );             
						  ?>
						 <?php echo form_error('branch_closingdate');?>
						  <span class="input-group-btn">
							  <button class="btn default" type="button">
								<i class="fa fa-calendar">
								</i>
							  </button>
							</span>
						</div>  
					</div>
				</div> <!--/ Branch Closingdate -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="branch_openingdate" class="control-label">Opening Date</label> 
							<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" > 
							  <?php     
							   $open_date = date_format( date_create($master_branch['branch_openingdate']), 'Y-m-d ' );  				   
							   echo form_input(
											array(
											 'name'         => 'branch_openingdate',
											 'id'           => 'branch_openingdate', 
											 'class'        => 'form-control input-sm tanggal ',
											 'placeholder'  => 'Branch Openingdate',
											 'readonly'		=> TRUE, 
											 ),
											 set_value('branch_openingdate',$open_date)
									   );             
							  ?>
							 <?php echo form_error('branch_openingdate');?>
							  <span class="input-group-btn">
								  <button class="btn default" type="button">
									<i class="fa fa-calendar">
									</i>
								  </button>
								</span>
							</div> 
					</div>
				</div> <!--/ Branch Openingdate -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						     <label for="branch_extid" class="control-label">Extid</label>                                  
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'branch_extid',
											 'id'           => 'branch_extid',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Branch Extid',
											 'maxlength'=>'30'
											 ),
											 set_value('branch_extid',$master_branch['branch_extid'])
									   );             
							  ?>
							 <?php echo form_error('branch_extid');?>  
					</div>
				</div><!--/ Branch Extid --> 
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="branch_isdirectcost" class="control-label">Is Directcost</label>                                   
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'branch_isdirectcost',
										 'id'           => 'branch_isdirectcost',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Branch Isdirectcost',
										 
										 ),
										 set_value('branch_isdirectcost',$master_branch['branch_isdirectcost'])
								   );             
						  ?>
						 <?php echo form_error('branch_isdirectcost');?> 
					</div>
				</div> <!--/ Branch Isdirectcost -->
				<div class="row"> &nbsp; </div> 
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="branch_code" class="control-label">Branch Code</label>                                   
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'branch_code',
											 'id'           => 'branch_code',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Branch Code',
											 'maxlength'=>'20'
											 ),
											 set_value('branch_code',$master_branch['branch_code'])
									   );             
							  ?>
							 <?php echo form_error('branch_code');?> 
					</div>
				</div><!--/ Branch Code --> 
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						 <label for="branch_idlok" class="control-label">IdLok</label>                                  
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'branch_idlok',
										 'id'           => 'branch_idlok',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Branch Idlok',
										 'maxlength'=>'20'
										 ),
										 set_value('branch_idlok',$master_branch['branch_idlok'])
								   );             
						  ?>
						 <?php echo form_error('branch_idlok');?>  
					</div>
				</div><!--/ Branch Idlok --> 
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						 <label for="branch_idutilitiesair" class="control-label">Utilities</label>                                   
						  <?php                  
						   echo form_dropdown(
								   'branch_idutilitiesair',
								   $utilitiesgasir_combo,  
								   set_value('branch_idutilitiesair',$master_branch['branch_idutilitiesair']),
								   ' class="form-control idutilitiesair" id="single"  '
								   );             
						  ?>
						 <?php echo form_error('branch_idutilitiesair');?>  
					</div>
				</div><!--/ Branch Idutilitiesair --> 
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						 <label for="branch_totalsqm" class="control-label">Total Sqm(m2)</label>                                   
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'branch_totalsqm',
										 'id'           => 'branch_totalsqm',  
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Branch Totalsqm',
										 
										 ),
										 set_value('branch_totalsqm',$master_branch['branch_totalsqm'])
								   );             
						  ?>
						 <?php echo form_error('branch_totalsqm');?>  
					</div>
				</div><!--/ Branch Totalsqm --> 
				
				
				
			             
          
			    <div class="col-md-12 form-group row">
					<div class="col-xs-12">
					<label for="branch_address" class="control-label">Address</label>                                   
					  <?php                  
					   echo form_textarea(
								array(
									'id'            =>'branch_address',
									'name'          =>'branch_address',
									'rows'          =>'3',
									'class'         =>'form-control input-sm ',
									'placeholder'   =>'Branch Address',
									'maxlength'=>'255'
									),
								set_value('branch_address',$master_branch['branch_address'])                           
								);             
					  ?>
					 <?php echo form_error('branch_address');?>  
					</div>
				</div><!--/ Branch Address -->
				
				
	<div class="row"> &nbsp; </div>
	<br/>
	<!-- tab -->
	<div class="col-md-12">
	
	<div class="nav-tabs-custom">
                      <ul class="nav nav-tabs">
                        <li class="active">
                          <a href="#tab1" data-toggle="tab">Region</a>
						</li>
						<li><a href="#tab2" data-toggle="tab" role = "tab">Properties</a></li>
                        <li><a href="#tab3" data-toggle="tab" role = "tab">Record</a></li>
						<li><a href="#tab4" data-toggle="tab" role = "tab">Listrik</a></li>
						<li><a href="#tab5" data-toggle="tab" role = "tab">Air</a></li>
						<li><a href="#tab6" data-toggle="tab" role = "tab">Gas</a></li>
                       
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                         <!-- tab region -->
						  <?php if ($region_branch) : ?>
								  <table class="table table-hover table-condensed">									  
									<thead>
									  <tr>
										<th class="header">Select</th>										
										<th>Region</th>   
									  </tr>
									</thead>									 
									<tbody>									
									   <?php foreach ($region_branch as $region) : ?> 
									  <tr>
										<td><input type="checkbox" name="region[]" value="<?php echo $region['region_id'] ?>" 
										<?php echo $region['selected'] == 1 ? 'CHECKED' : ''; ?> ></td>									   
									   <td><?php echo $region['region_name'] ?></td>									   									
									  </tr>     
									   <?php endforeach; ?>
									</tbody>
								  </table>
							  <?php else: ?>
									 <?php  echo '<p class="label label-info">Data Region Branch belum tersedia</p>';?>
							  <?php endif; ?>
						</div>
						
										<div class="tab-pane" id="tab3">
                                            <div class="row">
                                             <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						   <label for="branch_createby" class="control-label">Createby</label>                                  
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'branch_createby',
											 'id'           => 'branch_createby',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Branch Createby',
											 'readonly'  	=> TRUE,
											 'maxlength'=>'30'
											 ),
											 set_value('branch_createby',$master_branch['branch_createby'])
									   );             
							  ?>
							 <?php echo form_error('branch_createby');?>  
					</div>
				</div> <!--/ Branch Createby -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
					  <label for="branch_createdate" class="control-label">Createdate</label>                                  
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'branch_createdate',
										 'id'           => 'branch_createdate',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Branch Createdate',
										 'readonly'  	=> TRUE,
										 
										 ),
										 set_value('branch_createdate',$master_branch['branch_createdate'])
								   );             
						  ?>
						 <?php echo form_error('branch_createdate');?> 
					</div>
				</div><!--/ Branch Createdate --> 
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="branch_modifyby" class="control-label">Modifyby</label>                                    
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'branch_modifyby',
											 'id'           => 'branch_modifyby',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Branch Modifyby',
											 'readonly'  	=> TRUE,
											 'maxlength'=>'30'
											 ),
											 set_value('branch_modifyby',$master_branch['branch_modifyby'])
									   );             
							  ?>
							 <?php echo form_error('branch_modifyby');?> 
					</div>
				</div> <!--/ Branch Modifyby -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="branch_modifydate" class="control-label">Modifydate</label>                                  
							  <?php                  
							   echo form_input(
											array(
											 'name'         => 'branch_modifydate',
											 'id'           => 'branch_modifydate',                       
											 'class'        => 'form-control input-sm ',
											 'placeholder'  => 'Branch Modifydate',
											 'readonly'  	=> TRUE,
											 
											 ),
											 set_value('branch_modifydate',$master_branch['branch_modifydate'])
									   );             
							  ?>
							 <?php echo form_error('branch_modifydate');?> 
					</div>
				</div><!--/ Branch Modifydate -->  
                                             </div>
                                          </div>

						<!-- tab LISTRIK-->
                        <div class="tab-pane" id="tab4">
						<a href="javascript:void(0)" id="addlistrik"><strong>Add Listrik</strong></a>
						<br>
						<br>
						<div class ="table-responsive">
						  
								  <table class="table table-bordered table-striped" id='listrikTab' style="border:solid 1px #999; #999; border-radius:0px;">								  
									<thead>
									  <tr>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ID</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Name</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">AMP</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Phase</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">KVA</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Faktor</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">S. Meter</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Add</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ADM %</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ADM Rp</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">BPJU</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">KVA Name</th>																			
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">T. LWBP By user</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">T. WBP By user</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Selisih By user</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">S. LWBP By user</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">S. WBP By user</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">P. WBP By user</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">P. LWBP Byuser</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Genset</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Blocked</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Disabled</th>																						
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Delete</th>
									  </tr>
									</thead>									 
									<tbody>									
									   <?php if(isset($utilities_listrik)){
									   foreach ($utilities_listrik as $listrik) : ?> 
									  <tr>
										<td><input type="text" id="utilitieslistrik_id" name="utilitieslistrik_id[]" value="<?php echo $listrik['utilitieslistrik_id'];?>" class="start form-control input-sm" readonly> </td>
										<td><input type="text" id="utilitieslistrik_name" name="utilitieslistrik_name[]" value="<?php echo $listrik['utilitieslistrik_name'];?>" class="start form-control input-sm" readonly> </td>
										<td><input type="text" id="utilitieslistrik_amp" name="utilitieslistrik_amp[]" value="<?php echo $listrik['utilitieslistrik_amp'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="utilitieslistrik_phase" name="utilitieslistrik_phase[]" value="<?php echo $listrik['utilitieslistrik_phase'];?>" class="start form-control input-sm"> </td>										
										<td><input type="text" id="utilitieslistrik_kva" name="utilitieslistrik_kva[]" value="<?php echo $listrik['utilitieslistrik_kva'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="utilitieslistrik_faktor" name="utilitieslistrik_faktor[]" value="<?php echo $listrik['utilitieslistrik_faktor'];?>" class="start form-control input-sm"> </td>
										<td><input type="checkbox" id="utilitieslistrik_issingglemeter" name="utilitieslistrik_issingglemeter[]" <?php if ($listrik['utilitieslistrik_issingglemeter'] == 1) echo 'checked= "checked"';?> value ="1"></td>										
										<td><input type="checkbox" id="utilitieslistrik_isadditional" name="utilitieslistrik_isadditional[]" <?php if ($listrik['utilitieslistrik_isadditional'] == 1) echo 'checked= "checked"';?> value ="1"></td>										
										<td><input type="text" id="utilitieslistrik_admpercent" name="utilitieslistrik_admpercent[]" value="<?php echo $listrik['utilitieslistrik_admpercent'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="utilitieslistrik_admamount" name="utilitieslistrik_admamount[]" value="<?php echo $listrik['utilitieslistrik_admamount'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="utilitieslistrik_bpju" name="utilitieslistrik_bpju[]" value="<?php echo $listrik['utilitieslistrik_bpju'];?>" class="start form-control input-sm"> </td>
										<td><div class="form-group form-group-sm">
										  <select data-placeholder = "Select KVA" id= "utilitieskva_id" name= "utilitieskva_id[]" required class="dropkva form-control input-sm" style="width: 100%;">
											<option value="<?php echo $listrik['utilitieskva_id'];?>" selected="selected" ><?php echo $listrik['utilitieskva_name'];?></option>
										  </select></div><input type="hidden" id="d_unautilitieskva_i" name="utilitieskva_i[]" value="<?php echo $listrik['utilitieskva_name'];?>" /></td>																			
										<td><input type="checkbox" id="tariflwbp_calcbyuser" name="tariflwbp_calcbyuser[]" <?php if ($listrik['tariflwbp_calcbyuser'] == 1) echo 'checked= "checked"';?> value ="1"></td>										
										<td><input type="checkbox" id="tarifwbp_calcbyuser" name="tarifwbp_calcbyuser[]" <?php if ($listrik['tarifwbp_calcbyuser'] == 1) echo 'checked= "checked"';?> value ="1"></td>										
										<td><input type="checkbox" id="selisih_calcbyuser" name="selisih_calcbyuser[]" <?php if ($listrik['selisih_calcbyuser'] == 1) echo 'checked= "checked"';?> value ="1"></td>										
										<td><input type="checkbox" id="selisihlwbp_calcbyuser" name="selisihlwbp_calcbyuser[]" <?php if ($listrik['selisihlwbp_calcbyuser'] == 1) echo 'checked= "checked"';?> value ="1"></td>										
										<td><input type="checkbox" id="selisihwbp_calcbyuser" name="selisihwbp_calcbyuser[]" <?php if ($listrik['selisihwbp_calcbyuser'] == 1) echo 'checked= "checked"';?> value ="1"></td>										
										<td><input type="checkbox" id="pemakaianwbp_calcbyuser" name="pemakaianwbp_calcbyuser[]" <?php if ($listrik['pemakaianwbp_calcbyuser'] == 1) echo 'checked= "checked"';?> value ="1"></td>										
										<td><input type="checkbox" id="pemakaianlwbp_calcbyuser" name="pemakaianlwbp_calcbyuser[]" <?php if ($listrik['pemakaianlwbp_calcbyuser'] == 1) echo 'checked= "checked"';?> value ="1"></td>																			
										<td><input type="checkbox" id="utilitieslistrik_isgenset" name="utilitieslistrik_isgenset[]" <?php if ($listrik['utilitieslistrik_isgenset'] == 1) echo 'checked= "checked"';?> value ="1"></td>										
										<td><input type="checkbox" id="utilitieslistrik_isblocked" name="utilitieslistrik_isblocked[]" <?php if ($listrik['utilitieslistrik_isblocked'] == 1) echo 'checked= "checked"';?> value ="1"></td>										
										<td><input type="checkbox" id="utilitieslistrik_isdisabled" name="utilitieslistrik_isdisabled[]" <?php if ($listrik['utilitieslistrik_isdisabled'] == 1) echo 'checked= "checked"';?> value ="1"></td>										
										<td><a id= "listrikDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
									  </tr>
									<script>
										$('.dropkva').on("select2:select", function(e){
											var uData = e.params.data;

											$(this).closest('tr').find('input[type="hidden"]').eq(1).val(uData['id']);
											$(this).closest('tr').find('input[type="text"]').eq(2).val(uData['text']);
											
										});
									  </script>									  
									   <?php endforeach; 
									   } ?>
									</tbody>
								  </table>
							   
						</div>
						</div>

						<!-- tab AIR-->
						<div class="tab-pane" id="tab5">
						<a href="javascript:void(0)" id="addair"><strong>Add Air</strong></a>
						<br>
						<br>
						<div class ="table-responsive">
                        
						  
								  <table class="table table-bordered table-striped" id='airTab' style="border:solid 1px #999; #999; border-radius:0px;">								  
									<thead>
									  <tr>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ID</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Name</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Diameter Pipa</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ADM</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">PH Air Kotor</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">PH Meter</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Additional</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">PH Air Kotor</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ADM %</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Abodemen</th>																			
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Awal Akhir</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Disable</th>		
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Delete</th>
											
									  </tr>
									</thead>									 
									<tbody>									
									   <?php if(isset($utilities_air)){
										   foreach ($utilities_air as $air) : ?> 
									  <tr>
										<td><input type="text" id="utilitiesair_id" name="utilitiesair_id[]" value="<?php echo $air['utilitiesair_id'];?>" class="start form-control input-sm" readonly> </td>
										<td><input type="text" id="utilitiesair_name" name="utilitiesair_name[]" value="<?php echo $air['utilitiesair_name'];?>" class="start form-control input-sm" readonly> </td>
										<td><input type="text" id="utilitiesair_diameterpipa" name="utilitiesair_diameterpipa[]" value="<?php echo $air['utilitiesair_diameterpipa'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="utilitiesair_adm" name="utilitiesair_adm[]" value="<?php echo $air['utilitiesair_adm'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="utilitiesair_phairkotor" name="utilitiesair_phairkotor[]" value="<?php echo $air['utilitiesair_phairkotor'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="utilitiesair_phmeter" name="utilitiesair_phmeter[]" value="<?php echo $air['utilitiesair_phmeter'];?>" class="start form-control input-sm"> </td>
										<td><input type="checkbox" id="utilitiesair_isadditional" name="utilitiesair_isadditional[]" <?php if ($air['utilitiesair_isadditional'] == 1) echo 'checked= "checked"';?> value="1"> </td>										
										<td><input type="checkbox" id="phairkotor_isdisabled" name="phairkotor_isdisabled[]"<?php if ($air['phairkotor_isdisabled'] == 1) echo 'checked= "checked"';?> value="1"> </td>
										<td><input type="text" id="utilitiesair_admpercent" name="utilitiesair_admpercent[]" value="<?php echo $air['utilitiesair_admpercent'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="utilitiesair_abonemen" name="utilitiesair_abonemen[]" value="<?php echo $air['utilitiesair_abonemen'];?>" class="start form-control input-sm"> </td>																				
										<td><input type="checkbox" id="utilitiesair_isusedawalakhir" name="utilitiesair_isusedawalakhir[]" <?php if ($air['utilitiesair_isusedawalakhir'] == 1) echo 'checked= "checked"';?> value="1"> </td>																		
										<td><input type="checkbox" id="utilitiesair_isdisabled" name="utilitiesair_isdisabled[]" <?php if ($air['utilitiesair_isdisabled'] == 1) echo 'checked= "checked"';?> value="1"> </td>										
										<td><a id= "airDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
									  </tr>     
									   <?php endforeach; 
									   } ?>
									</tbody>
								  </table>
							  
						</div>
						</div>	

						<!-- tab GAS-->
						<div class="tab-pane" id="tab6">
						<a href="javascript:void(0)" id="addgas"><strong>Add Gas</strong></a>
						<br>
						<br>
						<div class ="table-responsive">
                         
						  
								  <table class="table table-bordered table-striped" id='gasTab' style="border:solid 1px #999; #999; border-radius:0px;">								  
									<thead>
									  <tr>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ID</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Name</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Diameter Pipa</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ADM</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">PH Air Kotor</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">PH Meter</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Additional</th>										
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Tarif</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">M Faktor</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Pressure</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ADM %</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Awal Akhir</th>																						
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Disabled</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Delete</th>
										
									  </tr>
									</thead>									 
									<tbody>	
									<?php if(isset($utilities_gas)){									
									    foreach ($utilities_gas as $gas) : ?> 
									  <tr>
										<td><input type="text" id="utilitiesgas_id" name="utilitiesgas_id[]" value="<?php echo $gas['utilitiesgas_id'];?>" class="start form-control input-sm" readonly> </td>
										<td><input type="text" id="utilitiesgas_name" name="utilitiesgas_name[]" value="<?php echo $gas['utilitiesgas_name'];?>" class="start form-control input-sm"/ readonly></td>
										<td><input type="text" id="utilitiesgas_diameterpipa" name="utilitiesgas_diameterpipa[]" value="<?php echo $gas['utilitiesgas_diameterpipa'];?>" class="start form-control input-sm"/></td>
										<td><input type="text" id="utilitiesgas_adm" name="utilitiesgas_adm[]" value="<?php echo $gas['utilitiesgas_adm'];?>" class="start form-control input-sm"/></td>
										<td><input type="text" id="utilitiesgas_phairkotor" name="utilitiesgas_phairkotor[]" value="<?php echo $gas['utilitiesgas_phairkotor'];?>" class="start form-control input-sm"/></td>
										<td><input type="text" id="utilitiesgas_phmeter" name="utilitiesgas_phmeter[]" value="<?php echo $gas['utilitiesgas_phmeter'];?>" class="start form-control input-sm"/></td>
										<td><input type="checkbox" id="utilitiesgas_isadditional" <?php if ($gas['utilitiesgas_isadditional'] == 1) echo 'checked= "checked"';?> value="1">																				
										<td><input type="text" id="utilitiesgas_tarif" name="utilitiesgas_tarif[]" value="<?php echo $gas['utilitiesgas_tarif'];?>" class="start form-control input-sm"/></td>
										<td><input type="text" id="utilitiesgas_mfaktor" name="utilitiesgas_mfaktor[]" value="<?php echo $gas['utilitiesgas_mfaktor'];?>" class="start form-control input-sm"/></td>
										<td><input type="text" id="utilitiesgas_pressure" name="utilitiesgas_pressure[]" value="<?php echo $gas['utilitiesgas_pressure'];?>" class="start form-control input-sm"/></td>
										<td><input type="text" id="utilitiesgas_admpercent" name="utilitiesgas_admpercent[]" value="<?php echo $gas['utilitiesgas_admpercent'];?>" class="start form-control input-sm"/></td>
										<td><input type="checkbox" id="utilitiesgas_isusedawalakhir" <?php if ($gas['utilitiesgas_isusedawalakhir'] == 1) echo 'checked= "checked"';?> value="1">
										<td><input type="checkbox" id="utilitiesgas_isdisabled" <?php if ($gas['utilitiesgas_isdisabled'] == 1) echo 'checked= "checked"';?> value="1">
										<td><a id= "gasDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
									  </tr>     
									   <?php endforeach; 
									}?>
									</tbody>
								  </table>
							  
						</div>
						</div>						
										  
                      </div> 
     </div>
     </div>
    <!-- end tab -->
	<div class="row"> &nbsp; </div>
	<br/>
	
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