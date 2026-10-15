 
<script>
var optID = '';
var optName = '';

 function enableTxt(elem) {
    // var id = $(elem).attr("id"); 
	console.log('LOG');
	var s = $(elem).closest('td').find('input:text').val();
	if($(elem).is(":checked")) { 
		 $(elem).closest('td').find('input:text').val(1);
	} 
	else
	{
		 $(elem).closest('td').find('input:text').val(0);
	}
}
$(document).ready(function() {
	
   
    $('.store').select2({
		 placeholder: 'Pilih Data', 
		 tags: true,
		 allowClear: true,
		 width: 'resolve'
	}); 
	
	$('.dropkva').select2({    
		  minimumInputLength: 0,
		  placeholder: 'Select an option',
		  ajax: {
			  url: '<?php echo site_url('rekanan_utilities_brand/rekanan_utilities_brand/kva_select')?>',
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
  
$('#addair').click(function () { 

      var linenum=0;
	  var str ='0';
	  var cstr = 'CHECKED';
      // var oData = airTable.rows('.selected').data();        

     
	   
		var branch_id  = $("#branch_id").val();      
		//alert(branch_id);
		
		$.ajax({
            type:'POST',
            url:'<?php echo site_url('rekanan_utilities/rekanan_utilities/template_utilities_bybranch/air')?>',
            dataType: "json",
            data:{branch_id:branch_id},
            success:function(data){
                if(data.status == 'ok'){
                   console(data.result); 
                   
                }else{
                    $('.user-content').slideUp();
                    alert("User not found...");
                } 
            }
        });
		
          function getBranchAir (){
             var ajax = $.get('<?php echo site_url('rekanan_utilities_brand/rekanan_utilities_brand/branch_air')?>','id='+branch_id, function(data){
               //do something with data here               
             }, 'json');
             return ajax;
          }
           
          getBranchAir().done(function(results){
          bair = results.data; 
			for (var k=0; k < bair.length; k++){
				spipa   = bair[k][2];
				sabonemen   = bair[k][9];
				sadmpercent   = bair[k][8];
				sadm   = bair[k][3];
				sphairkotor   = bair[k][4];
				sphmeter   = bair[k][5];
				cphairkotor = bair[k][7];
				
				addRowAir(k);
				
				var cphairkotor_isdisabled = 'checked';
				if(cphairkotor != 1)
				{cphairkotor_isdisabled = '';}
	   
				$('#rekananutilitiesair_isadditional_'+k).val(1);
				$('#pipa_'+k).val(spipa);
				$('#abonemen_'+k).val(sabonemen);
				$('#admpercent_'+k).val(sadmpercent);
				$('#adm_'+k).val(sadm);
				$('#phairkotor_'+k).val(sphairkotor);
				$('#phmeter_'+k).val(sphmeter);
				$('#cphairkotor_'+k).prop(cphairkotor_isdisabled, true);
				$('#cphairkotor2_'+k).val(cphairkotor);
				$('#iscountself_'+k).prop('', true);
			}
			//console.log(bair);
			
		});
           
       // }

  });  
  function addRowAir(ci) {
	  
	var linenum=0;
	var str ='0';
	var cstr = '';
	var trade_name = $("#rekananshipping_name").val();  
	var deptor_code = $("#rowid").val();  
	   
	var max=GetDgvLineMaxNum('airTab',0)
	  linenum= Number(max) + 10;
	var t="tcharge"+linenum;          
	var srekananutilitiesair_reg = trade_name + '==>' + deptor_code + '==>' + linenum;
	
	
		
          $('#airTab tbody').append('<tr>'+
			'<td><input type="hidden" name="rekananutilitiesair_line[]" value="'+ linenum +'" class="form-control input-sm" readonly /> '+ linenum +' </td>'+
			'<td><input type="text" id ="reg_'+ci+'" name="rekananutilitiesair_reg[]" value="'+ srekananutilitiesair_reg +'" class="form-control input-sm"  /></td>'+
			'<td><input type="text" id ="unit_'+ci+'" name="rekananutilitiesair_unit[]" value="'+ str +'" class="form-control input-sm" readonly /></td>'+
			'<td><input type="text" id ="pipa_'+ci+'" name="rekananutilitiesair_diameterpipa[]" value="0" class="form-control input-sm"/></td>'+
			'<td><input type="text" id ="abonemen_'+ci+'" name="rekananutilitiesair_abonemen[]" value="'+ str +'" class="form-control input-sm"/></td>'+			
			'<td><input type="text" id ="admpercent_'+ci+'" name="rekananutilitiesair_admpercent[]" value="'+ str +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" id ="adm_'+ci+'" name="rekananutilitiesair_adm[]" value="'+ str +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" id ="phairkotor_'+ci+'" name="rekananutilitiesair_phairkotor[]" value="'+ str +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" id ="phmeter_'+ci+'" name="rekananutilitiesair_phmeter[]" value="'+ str +'" class="form-control input-sm"/></td>'+			
			'<td><input type="checkbox" id="cphairkotor_'+ci+'"><input type="hidden" id="cphairkotor2_'+ci+'" name="tper[]" value="0"/></td>'+
			'<td><input type="text" id ="addkode_'+ci+'" name="addkode[]" value="'+ linenum +'" class="form-control input-sm"/></td>'+			
			'<td><input type="checkbox" id="iscountself_'+ci+'" name="rekananutilitiesair_iscountself[]" value="'+ str +'" style="text-align:right;" '+cstr+'><input type="hidden" id="iscountself_'+ci+'" name="rekananutilitiesair_iscountself[]" value="'+ str +'"/></td>'+	
			'<td><select data-placeholder = "Pilih" id= "rekananutilitiesair_isadditional_'+ci+'" name= "rekananutilitiesair_isadditional[]" required class="form-control input-sm">'+ 
            '<option value="101" > ==Pilih== </option> <option value="0" > Tidak </option> <option value="1" > Ya </option> </select></td>'+
			'<td>-<input type="hidden" name="event_air[]" value="ADD" /></td></tr>');
			//<td><a id= "airDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
	}

	$('#addgas').click(function () { 

      var linenum=0;
	  var str ='0';
	  var cstr = 'CHECKED';
      // var oData = airTable.rows('.selected').data();        

     
	   
		var branch_id  = $("#branch_id").val(); 
		//alert(branch_id);
		
          function getBranchGas (){
             var ajax = $.get('<?php echo site_url('rekanan_utilities_brand/rekanan_utilities_brand/branch_gas')?>','id='+branch_id, function(data){
               //do something with data here               
             }, 'json');
             return ajax;
          }
           
          getBranchGas().done(function(results){
          bgas = results.data; 
			for (var k=0; k < bgas.length; k++){
				mfaktor   = bgas[k][9];
				pressure   = bgas[k][10];
				tarif   = bgas[k][8];
				sadmpercent   = bgas[k][4];
				sadm   = bgas[k][3];
				sphmeter   = bgas[k][6];
				
				addRowGas(k);
				
	   
				$('#mfaktor_'+k).val(mfaktor);
				$('#pressure_'+k).val(pressure);
				$('#pressure_'+k).val(pressure);
				$('#tarif_'+k).val(tarif);
				$('#admpercent_'+k).val(sadmpercent);
				$('#adm_'+k).val(sadm);
				$('#phmeter_'+k).val(sphmeter);
				$('#rekananutilitiesgas_isadditional_'+k).val(1);
				
				$('#iscountself_'+k).prop('', true);
			}
			//console.log(bair);
			
		});
           
       // }

  });  
  function addRowGas(ci) {
	  
	  var linenum=0;
	  var str ='0';
	  var cstr = '';
	  var trade_name = $("#rekananshipping_name").val();  
	  var deptor_code = $("#rowid").val();  
	  
	  
		var max=GetDgvLineMaxNum('gasTab',0)
          linenum= Number(max) + 10;
        var t="tcharge"+linenum;          
		var srekananutilitiesgas_reg = trade_name + '==>' + deptor_code + '==>' + linenum;
          $('#gasTab tbody').append('<tr>'+
			'<td><input type="hidden" name="rekananutilitiesgas_line[]" value="'+ linenum +'" class="form-control input-sm" readonly /> '+ linenum +' </td>'+
			'<td><input type="text" id ="reg_'+ci+'" name="rekananutilitiesgas_reg[]" value="'+ srekananutilitiesgas_reg +'" class="form-control input-sm" readonly /></td>'+
			'<td><input type="text" id ="unit_'+ci+'" name="rekananutilitiesgas_unit[]" value="'+ str +'" class="form-control input-sm" readonly /></td>'+
			'<td><input type="text" id ="mfaktor_'+ci+'" name="rekananutilitiesgas_mfaktor[]" value="0" class="form-control input-sm"/></td>'+
			'<td><input type="text" id ="pressure_'+ci+'" name="rekananutilitiesgas_pressure[]" value="'+ str +'" class="form-control input-sm"/></td>'+			
			'<td><input type="text" id ="tarif_'+ci+'" name="rekananutilitiesgas_tarif[]" value="'+ str +'" class="form-control input-sm"/></td>'+			
			'<td><input type="text" id ="phmeter_'+ci+'" name="rekananutilitiesgas_phmeter[]" value="'+ str +'" class="form-control input-sm"/></td>'+			
			'<td><input type="text" id ="adm_'+ci+'" name="rekananutilitiesgas_adm[]" value="'+ str +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" id ="admpercent_'+ci+'" name="rekananutilitiesgas_admpercent[]" value="'+ str +'" class="form-control input-sm"/></td>'+											
			'<td><input type="text" id ="addkode_'+ci+'" name="addkode[]" value="'+ linenum +'" class="form-control input-sm"/></td>'+			
			'<td><input type="checkbox" id="iscountself_'+ci+'" name="rekananutilitiesgas_iscountself[]" value="'+ str +'" style="text-align:right;" '+cstr+'></td>'+
			'<td><select data-placeholder = "Pilih" id= "rekananutilitiesgas_isadditional_'+ci+'" name= "rekananutilitiesgas_isadditional[]" required class="form-control input-sm">'+ 
            '<option value="" > ==Pilih== </option> <option value="0" > Tidak </option> <option value="1" > Ya </option> </select></td>'+								
			'<td>-<input type="hidden" name="event_gas[]" value="ADD" /> </td></tr>');
			//<td><a id= "airDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
	}

	$('#addlistrik').click(function () { 

      var linenum=0;
	  var str ='0';
	  var cstr = 'CHECKED';
      // var oData = airTable.rows('.selected').data();        

     
	   
		var branch_id  = $("#branch_id").val(); 
		//alert(branch_id);
		var s = $('#select_type_listrik').val();
          function getBranchlistrik (){
var ajax = $.get('<?php echo site_url('rekanan_utilities_brand/rekanan_utilities_brand/branch_listrik/')?>'+s,'id='+branch_id, function(data){
               //do something with data here               
             }, 'json');
             return ajax;
          }
           
          getBranchlistrik().done(function(results){
          blistrik = results.data; 
		  //console.log(results.data);
			for (var k=0; k < blistrik.length; k++){
				
				amp   = blistrik[k][2];
				phase   = blistrik[k][3];
				kva   = blistrik[k][4];
				faktor   = blistrik[k][5];				
				issinggle   = blistrik[k][6];
				isblocked   = blistrik[k][20];
				isgenset   = blistrik[k][19];
				utilitieskva   = blistrik[k][11];				
				tariflwbp_calcbyuser   = blistrik[k][12];
				tarifwbp_calcbyuser   = blistrik[k][13];
				selisih_calcbyuser   = blistrik[k][14];
				selisihlwbp_calcbyuser   = blistrik[k][15];
				selisihwbp_calcbyuser   = blistrik[k][16];
				pemakaianwbp_calcbyuser   = blistrik[k][17];
				pemakaianlwbp_calcbyuser   = blistrik[k][18];				
				admpercent   = blistrik[k][8];
				adm   = blistrik[k][9];
				bpju   = blistrik[k][10];
				tarifpln   = 0;
				tarifgenset   = 0;
				beabeban   = 0;
				beaenergi   = 0;
				utilitieskva_name   = blistrik[k][22];
				
				// if(utilitieskva == 'undefined')
				// {
					//alert(blistrik[k][11]);
				// }
				//alert(utilitieskva);
				if(typeof utilitieskva === 'undefined' )
				{
					optID = 0;
					optName = 'PILIH';
				}
				else
				{
					optID = utilitieskva;
					optName = utilitieskva_name;
				}
				
				
				addRowlistrik(k);
				var textSelected = $('#select_type_listrik option:selected').text(); 
				var typeSinggle = 0;
				typeSinggle = $('#select_type_listrik').val();
				//console.log();   
				//$(".typeUtil").get(k).selectedIndex = typeSinggle;
				// console.log('debug2');
				// console.log(optID);
				// console.log(optName);
				
				
				$('#rekananutilitieslistrik_isadditional_'+k).val(1);
				 
				$('#amp_'+k).val(amp);
				$('#phase_'+k).val(phase);
				$('#kva_'+k).val(kva);
				$('#faktor_'+k).val(faktor);
				$('#utilitieskva_'+k).val(utilitieskva);
				$('#utilitieskva2_'+k).val(utilitieskva);
				$('#utilitieskva_'+k).select(utilitieskva_name, true);
				$('#utilitieskva2_'+k).select(utilitieskva_name, true);
				$('#admpercent_'+k).val(admpercent);
				$('#adm_'+k).val(adm);
				$('#bpju_'+k).val(bpju);
				$('#tarifpln_'+k).val(tarifpln);
				$('#tarifgenset_'+k).val(tarifgenset);
				$('#beabeban_'+k).val(beabeban);
				$('#beaenergi_'+k).val(beaenergi);
				
				$('#issinggle_'+k).val(issinggle);
				$('#isblocked_'+k).val(isblocked);
				$('#isgenset_'+k).val(isgenset);
				 
				// console.log(selisih_calcbyuser);
				 
				$('#tariflwbp_calcbyuser_'+k).val(tariflwbp_calcbyuser);
				$('#tarifwbp_calcbyuser_'+k).val(tarifwbp_calcbyuser);
				$('#selisih_calcbyuser_'+k).val(selisih_calcbyuser);
				 
				$('#selisihlwbp_calcbyuser_'+k).val(selisihlwbp_calcbyuser);
				$('#selisihwbp_calcbyuser_'+k).val(selisihwbp_calcbyuser);
				$('#pemakaianwbp_calcbyuser_'+k).val(pemakaianwbp_calcbyuser);
				$('#pemakaianlwbp_calcbyuser_'+k).val(pemakaianlwbp_calcbyuser);
				  
				
				
				
				$('#iscountself_'+k).prop('', true);
				
				// $('#issinggle_'+k+' :checkbox' ).change(function() {
					// if($('#issinggle_'+k).is(":checked")) { 
						// $('#issinggletext_'+k).val(1);
					// }
					// else
					// {
						// $('#issinggletext_'+k).val(0);
					// }
				// });
				 
				
			}
			//console.log(bair);
			
		});
           
       // }

  });  
	function addRowlistrik(ci) {
	  
	  var linenum=0;
	  var str ='0';
	  var cstr = '';
	  
	  var trade_name = $("#rekananshipping_name").val();  
	  var deptor_code = $("#rowid").val();  
	  
		
		  var max=GetDgvLineMaxNum('listrikTab',0)
			linenum= Number(max) + 10;
          var t="tcharge"+linenum;  
		  var srekananutilitieslistrik_reg = trade_name + '==>' + deptor_code + '==>' + linenum;
		  
		// console.log('debug');
		// console.log(linenum); 	
		//alert(ci);
          $('#listrikTab tbody').append('<tr>'+
			'<td><input type="hidden" name="rekananutilitieslistrik_line[]" value="'+ linenum +'" class="form-control input-sm" readonly /> '+ linenum +' </td>'+
			'<td><input type="text" id ="reg_'+ci+'" name="rekananutilitieslistrik_reg[]" value="'+ srekananutilitieslistrik_reg +'" class="form-control input-sm"  /></td>'+
			'<td><input type="text" id ="limit_'+ci+'" name="rekananutilitieslistrik_reglimit[]" value="'+ str +'" class="form-control input-sm"  /></td>'+
			'<td><input type="text" id ="unit_'+ci+'" name="rekananutilitieslistrik_unit[]" value="'+ str +'" class="form-control input-sm" readonly /></td>'+
			'<td><input type="text" id ="amp_'+ci+'" name="rekananutilitieslistrik_amp[]" value="0" class="form-control input-sm"/></td>'+
			'<td><input type="text" id ="phase_'+ci+'" name="rekananutilitieslistrik_phase[]" value="'+ str +'" class="form-control input-sm"/></td>'+			
			'<td><input type="text" id ="kva_'+ci+'" name="rekananutilitieslistrik_kva[]" value="'+ str +'" class="form-control input-sm"/></td>'+			
			'<td><input type="text" id ="faktor_'+ci+'" name="rekananutilitieslistrik_faktor[]" value="'+ str +'" class="form-control input-sm"/></td>'+	 			
			'<td><select data-placeholder = "Pilih" id= "issinggle_'+ci+'" name= "rekananutilitieslistrik_issingglemeter[]" required class="form-control input-sm">'+			
            '<option value="101" > ==Pilih== </option> <option value="0" > Tidak </option> <option value="1" > Ya </option> </select></td>'+
			'<td><select data-placeholder = "Pilih" id= "isblocked_'+ci+'" name= "rekananutilitieslistrik_isblocked[]" required class="form-control input-sm">'+ 
            '<option value="101" > ==Pilih== </option> <option value="0" > Tidak </option> <option value="1" > Ya </option> </select></td>'+
			'<td><select data-placeholder = "Pilih" id= "isgenset_'+ci+'" name= "rekananutilitieslistrik_isgenset[]" required class="form-control input-sm">'+ 
            '<option value="101" > ==Pilih== </option> <option value="0" > Tidak </option> <option value="1" > Ya </option> </select></td>'+ 
			'<td><div class="form-group form-group-sm"><select data-placeholder = "Select KVA" id= "utilitieskva_'+ci+'" name= "utilitieskva_id[]" required class="dropkva form-control input-sm" style="width: 100%;">'+			
            '<option value="'+optID+'" selected> '+optName+' </option> </select></div><input type="hidden" id="utilitieskva2_'+ci+'" name="utilitieskva_id2[]" value="" /></td>'+ 
			'<td><select data-placeholder = "Pilih" id= "tariflwbp_calcbyuser_'+ci+'" name= "tariflwbp_calcbyuser[]" required class="form-control input-sm">'+ 
            '<option value="101" > ==Pilih== </option> <option value="0" > Tidak </option> <option value="1" > Ya </option> </select></td>'+
			'<td><select data-placeholder = "Pilih" id= "tarifwbp_calcbyuser_'+ci+'" name= "tarifwbp_calcbyuser[]" required class="form-control input-sm">'+ 
            '<option value="101" > ==Pilih== </option> <option value="0" > Tidak </option> <option value="1" > Ya </option> </select></td>'+
			'<td><select data-placeholder = "Pilih" id= "selisih_calcbyuser_'+ci+'" name= "selisih_calcbyuser[]" required class="form-control input-sm">'+ 
            '<option value="101" > ==Pilih== </option> <option value="0" > Tidak </option> <option value="1" > Ya </option> </select></td>'+
			'<td><select data-placeholder = "Pilih" id= "selisihlwbp_calcbyuser_'+ci+'" name= "selisihlwbp_calcbyuser[]" required class="form-control input-sm">'+ 
            '<option value="101" > ==Pilih== </option> <option value="0" > Tidak </option> <option value="1" > Ya </option> </select></td>'+
			'<td><select data-placeholder = "Pilih" id= "selisihwbp_calcbyuser_'+ci+'" name= "selisihwbp_calcbyuser[]" required class="form-control input-sm">'+ 
            '<option value="101" > ==Pilih== </option> <option value="0" > Tidak </option> <option value="1" > Ya </option> </select></td>'+
			'<td><select data-placeholder = "Pilih" id= "pemakaianwbp_calcbyuser_'+ci+'" name= "pemakaianwbp_calcbyuser[]" required class="form-control input-sm">'+ 
            '<option value="101" > ==Pilih== </option> <option value="0" > Tidak </option> <option value="1" > Ya </option> </select></td>'+
			'<td><select data-placeholder = "Pilih" id= "pemakaianlwbp_calcbyuser_'+ci+'" name= "pemakaianlwbp_calcbyuser[]" required class="form-control input-sm">'+ 
            '<option value="101" > ==Pilih== </option> <option value="0" > Tidak </option> <option value="1" > Ya </option> </select></td>'+
			'<td><input type="text" id ="admpercent_'+ci+'" name="rekananutilitieslistrik_admpercent[]" value="'+ str +'" class="form-control input-sm"/></td>'+											
			'<td><input type="text" id ="adm_'+ci+'" name="rekananutilitieslistrik_admamount[]" value="'+ str +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" id ="bpju_'+ci+'" name="rekananutilitieslistrik_bpju[]" value="'+ str +'" class="form-control input-sm"/></td>'+
			'<td><input type="text" id ="tarifpln_'+ci+'" name="tarif_pln[]" value="'+ str +'" class="form-control input-sm"/></td>'+											
			'<td><input type="text" id ="tarifgenset_'+ci+'" name="tarif_genset[]" value="'+ str +'" class="form-control input-sm"/></td>'+											
			'<td><input type="text" id ="beabeban_'+ci+'" name="bea_beban[]" value="'+ str +'" class="form-control input-sm"/></td>'+											
			'<td><input type="text" id ="beaenergi_'+ci+'" name="bea_energi[]" value="'+ str +'" class="form-control input-sm"/></td>'+														
			'<td><?php echo form_dropdownext('rekananutilitieslistrik_type[]',$listriktype,$this->input->post('utilities_type'),'id="rekananutilitieslistrik_type" class="form-control input-sm typeUtil listrik_type" required disabled');?></td>'+
			'<td><input type="text" id ="addkode_'+ci+'" name="addkode[]" value="'+ linenum +'" class="form-control input-sm" readonly/></td>'+			
			'<td><input type="checkbox" id="iscountself_'+ci+'" name="rekananutilitieslistrik_iscountself[]" value="'+ str +'" style="text-align:right;" '+cstr+' name="rekananutilitieslistrik_iscountself[]"> </td>'+
			'<td><select data-placeholder = "Pilih" id= "rekananutilitieslistrik_isadditional_'+ci+'" name= "rekananutilitieslistrik_isadditional[]" required class="form-control input-sm">'+ 
            '<option value="101" > ==Pilih== </option> <option value="0" > Tidak </option> <option value="1" > Ya </option> </select></td>'+			
			'<td>-<input type="hidden" name="event_listrik[]" value="ADD" /></td></tr>' 
			);
			//<td><a id= "airDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
			
			//$('.typeUtil').select2('data', {id: ''+typeSinggle+'' , text: ''+textSelected+''}); 
			
			$('.dropkva').select2({    
			  minimumInputLength: 0,
			  placeholder: 'Select an option',
			  ajax: {
				  url: '<?php echo site_url('rekanan_utilities_brand/rekanan_utilities_brand/kva_select')?>',
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
	
	 
	}
 
 $('#select_type_listrik').select2();
 $('#addlistrik').hide();
 
 $('#select_type_listrik').on("select2:select", function(e) {
	$('#addlistrik').show(); 
	var s = $('#select_type_listrik').val();
	if(s == 101)
	{
		$('#addlistrik').hide();
	}
	else
	{
		$('#addlistrik').show(); 
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
   width: auto;
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
 

<?php echo form_open(site_url('rekanan_utilities_brand/' . $action),'role="form" class="form-horizontal" id="form_master_rekananshipping" parsley-validate'); ?>               
 
<!--content--> 
	<div class="row">
		<div class="col-md-12">
		  <div class="portlet-body form">
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
					  <label for="rekananshipping_line" class="control-label">Line</label> 
					  <?php       
					   $lineid = $rekanan_utilities_brand['rekananshipping_line'] == '' ? $line : $rekanan_utilities_brand['rekananshipping_line'];
					   echo form_input(
									array(
									 'name'         => 'rekananshipping_line',
									 'id'           => 'rekananshipping_line', 
									 'class'        => 'form-control input-sm',
									 'placeholder'  => 'Line',
									 'readonly'		=> TRUE, 
									 ),
									 set_value('rekananshipping_line',$lineid)
							   );             
					  ?>
					 <?php echo form_error('rekananshipping_line');?> 
					</div>
				</div><!--/ Rekananshipping Line -->
				<div class="col-md-4 form-group row">
					<div class="col-xs-12"> 
					<label for="rekananshipping_isactive" class="mt-checkbox">Active</label> 
					   <input type="checkbox" name="rekananshipping_isactive"  value="1" <?php echo ($rekanan_utilities_brand['rekananshipping_isactive'] == '0' ? null : 'checked' ); ?> class="form-control input-checkbox" disabled>  
					 <?php echo form_error('rekananshipping_isactive');?>  
					</div>
				</div><!--/ Rekananshipping Isactive --> 
				
				<div class="row"> </div>
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="rekananshipping_name" class="control-label">Trade Name <span class="required-input">*</span></label> 
						  <input type="text" id="rekananshipping_name" name="rekananshipping_name" value="<?php   
								echo htmlspecialchars_decode ($rekanan_utilities_brand['rekananshipping_name'], ENT_QUOTES ); ?>" id="rekananshipping_name" class="form-control input-sm  required" placeholder="Name" maxlength="100" readonly>
							 
							 <?php echo form_error('rekananshipping_name');?> 
					</div>
				</div><!--/ Rekananshipping Name -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="rekananshipping_namereport" class="control-label">Name Report <span class="required-input">*</span></label> 
						  <input type="text" name="rekananshipping_namereport" value="<?php   
								echo htmlspecialchars_decode ($rekanan_utilities_brand['rekananshipping_namereport'], ENT_QUOTES ); ?>" id="rekananshipping_namereport" class="form-control input-sm  required" placeholder="Name Report" maxlength="250" readonly> 
							 <?php echo form_error('rekananshipping_namereport');?> 
					</div>
				</div> <!--/ Rekananshipping Namereport -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						 <label for="rekananshipping_address" class="control-label">Address <span class="required-input">*</span></label> 
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekananshipping_address',
										 'id'           => 'rekananshipping_address',                       
										 'class'        => 'form-control input-sm  required',
										 'placeholder'  => 'Address',
										 'maxlength'=>'500',
										 'readonly' => TRUE
										 ),
										 set_value('rekananshipping_address',$rekanan_utilities_brand['rekananshipping_address'])
								   );             
						  ?>
						 <?php echo form_error('rekananshipping_address');?> 
					</div>
				</div><!--/ Rekananshipping Address -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						 <label for="rekananshipping_contactname" class="control-label">Contactname</label>                                 
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekananshipping_contactname',
										 'id'           => 'rekananshipping_contactname',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Contact Name',
										 'maxlength'=>'50',
										 'readonly' => TRUE
										 ),
										 set_value('rekananshipping_contactname',$rekanan_utilities_brand['rekananshipping_contactname'])
								   );             
						  ?>
						 <?php echo form_error('rekananshipping_contactname');?>  
					</div>
				</div><!--/ Rekananshipping Contactname -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="rekananshipping_contacthp" class="control-label">Contact Hp</label>                                 
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekananshipping_contacthp',
										 'id'           => 'rekananshipping_contacthp',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Contact Hp',
										 'maxlength'=>'50',
										 'readonly' => TRUE
										 ),
										 set_value('rekananshipping_contacthp',$rekanan_utilities_brand['rekananshipping_contacthp'])
								   );             
						  ?>
						 <?php echo form_error('rekananshipping_contacthp');?> 
					</div>
				</div><!--/ Rekananshipping Contacthp -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="rekananshipping_contacttelp" class="control-label">Contact Telp</label>                               
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekananshipping_contacttelp',
										 'id'           => 'rekananshipping_contacttelp',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Contact Telp',
										 'maxlength'=>'50',
										 'readonly' => TRUE
										 ),
										 set_value('rekananshipping_contacttelp',$rekanan_utilities_brand['rekananshipping_contacttelp'])
								   );             
						  ?>
						 <?php echo form_error('rekananshipping_contacttelp');?> 
					</div>
				</div><!--/ Rekananshipping Contacttelp -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						<label for="rekananshipping_contactemail" class="control-label">Contact Email</label>                                 
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekananshipping_contactemail',
										 'id'           => 'rekananshipping_contactemail',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Contact Email',
										 'maxlength'=>'50',
										 'readonly' => TRUE
										 ),
										 set_value('rekananshipping_contactemail',$rekanan_utilities_brand['rekananshipping_contactemail'])
								   );             
						  ?>
						 <?php echo form_error('rekananshipping_contactemail');?> 
					</div>
				</div><!--/ Rekananshipping Contactemail -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						   <label for="rekananshipping_tax" class="control-label">Tax</label>                                  
							  <?php  
							 
								$tax =0;							  
								if($rekanan_utilities_brand['rekananshipping_tax'] == '')
								{
									$tax = 10;
								}
								else
								{
									$tax =$rekanan_utilities_brand['rekananshipping_tax']; 
								}
								
								 
							   echo form_input(
											array(
											 'name'         => 'rekananshipping_tax',
											 'id'           => 'rekananshipping_tax', 
											 'class'        => 'form-control input-sm ',
											 'placeholder'  =>$tax ,
										 'readonly' => TRUE,
											 set_value('rekananshipping_tax',$tax)
											 )
											
									   );  
							  ?>
							 <?php echo form_error('rekananshipping_tax');?> 
					</div>
				</div><!--/ Rekananshipping Tax -->
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12 ">
						  *<label for="branch_id" class="control-label">Store</label>                                   
							  <?php                  
							   echo form_dropdown(
									   'branch_id',
									   $combo_branch,  
									   set_value('branch_id',$rekanan_utilities_brand['branch_id']),
									   'class="form-control dropdown store" id="branch_id" style="width:100%;" disabled'
									   );   
							
							  ?>
							  
							 <?php echo form_error('branch_id');?> 
					</div>
				</div><!--/ Branch -->
				<div class="row">&nbsp;</div> 
			    
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						  <label for="rekananshipping_npwp" class="control-label">Npwp</label>                                 
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekananshipping_npwp',
										 'id'           => 'rekananshipping_npwp',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Npwp',
										 'maxlength'=>'100',
										 'readonly' => TRUE
										 ),
										 set_value('rekananshipping_npwp',$rekanan_utilities_brand['rekananshipping_npwp'])
								   );             
						  ?>
						 <?php echo form_error('rekananshipping_npwp');?> 
					</div>
				</div><!--/ Rekananshipping Npwp -->
				
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
						 <label for="rekananshipping_npwp_name" class="control-label">Npwp Name</label>                                    
						  <?php                  
						   echo form_input(
										array(
										 'name'         => 'rekananshipping_npwp_name',
										 'id'           => 'rekananshipping_npwp_name',                       
										 'class'        => 'form-control input-sm ',
										 'placeholder'  => 'Npwp Name',
										 'maxlength'=>'150',
										 'readonly' => TRUE
										 ),
										 set_value('rekananshipping_npwp_name',$rekanan_utilities_brand['rekananshipping_npwp_name'])
								   );             
						  ?>
						 <?php echo form_error('rekananshipping_npwp_name');?> 
					</div>
				</div>  <!--/ Rekananshipping Npwp Name --> 
				
			    <div class="col-md-4 form-group row">
					<div class="col-xs-12">
					<label for="rekananshipping_npwp_addr" class="control-label">Npwp Addr</label>                                    
					  <?php                  
					   echo form_input(
									array(
									 'name'         => 'rekananshipping_npwp_addr',
									 'id'           => 'rekananshipping_npwp_addr', 
									 'class'        => 'form-control input-sm ',
									 'placeholder'  => 'Npwp Addr',
									 'maxlength'=>'500',
										 'readonly' => TRUE
									 ),
									 set_value('rekananshipping_npwp_addr',$rekanan_utilities_brand['rekananshipping_npwp_addr'])
							   );             
					  ?>
					 <?php echo form_error('rekananshipping_npwp_addr');?> 
					</div>
				</div> <!--/ Rekananshipping Npwp Addr -->
				
				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
					<label for="rekananshipping_npwp_addr" class="control-label">Debtor Code</label>                                    
					  <?php                  
					   echo form_input(
									array(
									 'name'         => 'rowid',
									 'id'           => 'rowid',                       
									 'class'        => 'form-control input-sm ',
									 'placeholder'  => 'Debtor Code',
									 'maxlength'=>'500',
									 'readonly'=>TRUE,
									 ),
									 set_value('rowid',$rekanan_utilities_brand['rowid'])
							   );             
					  ?>
					 <?php echo form_error('rowid');?> 
					</div>
				</div> <!--/ Rekananshipping Debtor Code -->
				
				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
					<label for="rekananshipping_npwp_addr" class="control-label">Type
					</label>                                    
					  <?php                   
					   echo form_dropdown(
									   'rekananshipping_type',
									   $combo_shippingtype,  
									   set_value('rekananshipping_type',$rekanan_utilities_brand['rekananshipping_type']),
									   'class="form-control store" id="single_1" style="width:100%;" disabled'
									   );  
					  ?>
					 <?php echo form_error('rekananshipping_type');?> 
					</div>
				</div> <!--/ Rekananshipping Debtor Code -->
				
				 
				
				<div class="row">&nbsp;</div> 
				 <div class="col-md-12 form-group row">
					<div class="col-xs-12">
						  <label for="rekananshipping_desc" class="control-label">Description</label>                                   
						  <?php                  
						   echo form_textarea(
									array(
										'id'            =>'rekananshipping_desc',
										'name'          =>'rekananshipping_desc',
										'rows'          =>'3',
										'class'         =>'form-control input-sm ',
										'placeholder'   =>'Desc',
										'maxlength'=>'250',
										 'readonly' => TRUE
										),
									set_value('rekananshipping_desc',$rekanan_utilities_brand['rekananshipping_desc'])                           
									);             
						  ?>
						 <?php echo form_error('rekananshipping_desc');?> 
					</div>
				</div><!--/ Rekananshipping Desc -->
				
				<div class="col-md-4 form-group row">
					<div class="col-xs-12">
					                                    
					  <?php                  
					   echo form_input(
									array(
									 'name'         => 'hbranch',
									 'id'           => 'hbranch',                       
									 'class'        => 'form-control input-sm ',
									 'placeholder'  => 'Debtor Code',
									 'maxlength'=>'500',
									 'readonly'=>TRUE,
									 'type' =>'hidden',
									 ),
									 set_value('branch_id',$rekanan_utilities_brand['branch_id'])
							   );             
					  ?>
					 <?php echo form_error('branch_id');?> 
					</div>
				</div> <!--/ branch ID -->
				
				
<div class="row"> &nbsp; </div>
	<br/>
	<!-- tab -->
	<div class="col-md-12">
	
	<div class="nav-tabs-custom">
                      <ul class="nav nav-tabs">
                        <li class="active">
                          <a href="#tab5" data-toggle="tab">Listrik</a>
						</li>
						<li><a href="#tab6" data-toggle="tab" role = "tab">Air</a></li>
						<li><a href="#tab7" data-toggle="tab" role = "tab">Gas</a></li>
						
                       
                      </ul>
                      <div class="tab-content">
                        

						<!-- tab LISTRIK-->
                        <div class="tab-pane active" id="tab5"> 
						<select name="utilities_type" id="select_type_listrik">
							<option value="101"> PILIH </option>
							<option value="0"> Double </option>
							<option value="1"> Single </option>
							<option value="2"> Single To Double </option>
						</select>
						<div class="row"> &nbsp; </div>
						<span  type="" class="btn btn-success btn-sm" id="addlistrik" data-tooltip="tooltip" data-placement="top" title="Add Listrik" ><i class="glyphicon glyphicon-plus"></i>
						</span> 
						<div class="row"> &nbsp; </div>
						
						<div class ="table-responsive">
						  
								  <table class="table table-bordered table-striped" id='listrikTab' style="border:solid 1px #999; #999; border-radius:0px; ">								  
									<thead>
									  <tr>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Line</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Reg &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Limit</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Unit</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Ampere</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Phase</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Kapasitas Daya</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Faktor &nbsp;&nbsp;&nbsp;</th>
										<th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Is Single(M) &nbsp;&nbsp;&nbsp;&nbsp;</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Is Block &nbsp;&nbsp;&nbsp;&nbsp;</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Is Genset &nbsp;&nbsp;&nbsp;&nbsp;</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Daya &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>																			
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">T. LWBP By user &nbsp;&nbsp;&nbsp;&nbsp;</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">T. WBP By user &nbsp;&nbsp;&nbsp;&nbsp;</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">S. By user</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">S. LWBP By user &nbsp;&nbsp;&nbsp;&nbsp;</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">S. WBP By user &nbsp;&nbsp;&nbsp;&nbsp;</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">P. WBP By user &nbsp;&nbsp;&nbsp;&nbsp;</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">P. LWBP Byuser &nbsp;&nbsp;&nbsp;&nbsp;</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ADM % </th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ADM Amount</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">BPJU %</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Tarif PLN</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Tarif Genset</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Bea&nbsp;&nbsp; Beban</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Bea Energi</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Kode</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Is Count Self</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Is Additional</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Delete</th>
									  </tr>
									</thead>									 
									<tbody>									
									   <?php if(isset($utilities_listrik)){
										$CmbTyListrik = array(""=>"--Pilih--","1" => "Ya", "0" => "Tidak");
									   foreach ($utilities_listrik as $row=>$listrik) : 
									   
									   ?> 
									  <tr>
										<td width="15%" class="tg-iuhm"><input type="hidden" id="rekananutilitieslistrik_line" name="rekananutilitieslistrik_line[]" value="<?php echo $listrik['rekananutilitieslistrik_line'];?>" class="start form-control input-sm" readonly> <?php echo $listrik['rekananutilitieslistrik_line'];?> </td>
										<td  class="tg-iuhm" style="width:25%;">
										<input type="text" id="rekananutilitieslistrik_reg" name="rekananutilitieslistrik_reg[]" value="<?php echo $listrik['rekananutilitieslistrik_reg'];?>" class="start form-control input-sm " > </td>
										
										<td><input type="text" id="rekananutilitieslistrik_reglimit" name="rekananutilitieslistrik_reglimit[]" value="<?php echo $listrik['rekananutilitieslistrik_reglimit'];?>" class="start form-control input-sm" readonly> </td>
										<td><input type="text" id="rekananutilitieslistrik_unit" name="rekananutilitieslistrik_unit[]" value="<?php echo $listrik['rekananutilitieslistrik_unit'];?>" class="start form-control input-sm" readonly> </td>
										<td><input type="text" id="rekananutilitieslistrik_amp" name="rekananutilitieslistrik_amp[]" value="<?php echo $listrik['rekananutilitieslistrik_amp'];?>" class="start form-control input-sm"> </td>										
										<td><input type="text" id="rekananutilitieslistrik_phase" name="rekananutilitieslistrik_phase[]" value="<?php echo $listrik['rekananutilitieslistrik_phase'];?>" class="start form-control input-sm"> </td>										
										<td><input type="text" id="rekananutilitieslistrik_kva" name="rekananutilitieslistrik_kva[]" value="<?php echo $listrik['rekananutilitieslistrik_kva'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="rekananutilitieslistrik_faktor" name="rekananutilitieslistrik_faktor[]" value="<?php echo $listrik['rekananutilitieslistrik_faktor'];?>" class="start form-control input-sm"> </td>
										<td>
										<?php echo form_dropdown('rekananutilitieslistrik_issingglemeter[]',$CmbTyListrik,$listrik['rekananutilitieslistrik_issingglemeter'],'class="form-control input-sm " ');?> 
										</td>																				
										<td>
										<?php
										echo form_dropdown('rekananutilitieslistrik_isblocked[]',$CmbTyListrik,$listrik['rekananutilitieslistrik_isblocked'],'class="form-control input-sm " ');?>   
										</td>	
										<td>
										<?php echo form_dropdown('rekananutilitieslistrik_isgenset[]',$CmbTyListrik,$listrik['rekananutilitieslistrik_isgenset'],'class="form-control input-sm " ');?>   
										</td>
										<td><div class="form-group form-group-sm">
										  <select data-placeholder = "Select KVA" id= "utilitieskva_id" name= "utilitieskva_id[]" required class="dropkva form-control input-sm" style="width: 100%;">
											<option value="<?php echo $listrik['utilitieskva_id'];?>" selected="selected" ><?php echo $listrik['utilitieskva_name'];?></option>
										  </select></div><input type="hidden" id="d_unautilitieskva_i" name="utilitieskva_i[]" value="<?php echo $listrik['utilitieskva_name'];?>" /></td>																																																	
										<td>
										<?php echo form_dropdown('tariflwbp_calcbyuser[]',$CmbTyListrik,$listrik['tariflwbp_calcbyuser'],'class="form-control input-sm " ');?>
										</td>										
										<td>
										<?php echo form_dropdown('tarifwbp_calcbyuser[]',$CmbTyListrik,$listrik['tarifwbp_calcbyuser'],'class="form-control input-sm " ');?>
										</td>										
										<td>
										<?php echo form_dropdown('selisih_calcbyuser[]',$CmbTyListrik,$listrik['selisih_calcbyuser'],'class="form-control input-sm " ');?>
										</td>										
										<td>
										<?php echo form_dropdown('selisihlwbp_calcbyuser[]',$CmbTyListrik,$listrik['selisihlwbp_calcbyuser'],'class="form-control input-sm " ');?>
										</td>										
										<td>
										<?php echo form_dropdown('selisihwbp_calcbyuser[]',$CmbTyListrik,$listrik['selisihwbp_calcbyuser'],'class="form-control input-sm " ');?>
										</td>										
										<td>
										<?php echo form_dropdown('pemakaianwbp_calcbyuser[]',$CmbTyListrik,$listrik['pemakaianwbp_calcbyuser'],'class="form-control input-sm " ');?>
										</td>										
										<td>
										<?php echo form_dropdown('pemakaianlwbp_calcbyuser[]',$CmbTyListrik,$listrik['pemakaianlwbp_calcbyuser'],'class="form-control input-sm " ');?>
										</td>																			
										
										<td><input type="text" id="rekananutilitieslistrik_admpercent" name="rekananutilitieslistrik_admpercent[]" value="<?php echo $listrik['rekananutilitieslistrik_admpercent'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="rekananutilitieslistrik_admamount" name="rekananutilitieslistrik_admamount[]" value="<?php echo $listrik['rekananutilitieslistrik_admamount'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="rekananutilitieslistrik_bpju" name="rekananutilitieslistrik_bpju[]" value="<?php echo $listrik['rekananutilitieslistrik_bpju'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="tarif_pln" name="tarif_pln[]" value="<?php echo $listrik['tarif_pln'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="tarif_genset" name="tarif_genset[]" value="<?php echo $listrik['tarif_genset'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="bea_beban" name="bea_beban[]" value="<?php echo $listrik['bea_beban'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="bea_energi" name="bea_energi[]" value="<?php echo $listrik['bea_energi'];?>" class="start form-control input-sm"> </td>	 			
										<td><?php  echo form_dropdown('rekananutilitieslistrik_type[]',$listriktype,$listrik['rekananutilitieslistrik_type'],'id="rekananutilitieslistrik_type"  class="form-control input-sm typeUtil"');?></td>
										<td><input type="text" id="addkode" name="addkode[]" value="<?php echo $listrik['addkode'];?>" class="start form-control input-sm" readonly> </td>  
										<td><input type="checkbox" id="rekananutilitieslistrik_iscountself" name="rekananutilitieslistrik_iscountself[]" <?php  echo ($listrik['rekananutilitieslistrik_iscountself'] == 1) ? "checked" : "";?> value="1"</td>	
										<td>
										<?php 
										$CmbTyListrikisadditional = array(""=>"--Pilih--","1" => "Ya", "0" => "Tidak");
										echo form_dropdown('rekananutilitieslistrik_isadditional[]',$CmbTyListrikisadditional,$listrik['rekananutilitieslistrik_isadditional'],'class="form-control input-sm " ');?> 
										</td>									
										<td> - <input type="hidden" name="event_listrik[]" value="EDIT" /></td>
										<!--<td><a id= "listrikDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td> -->
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
						<div class="tab-pane" id="tab6"> 
						<span  type="" class="btn btn-success btn-sm" id="addair" data-tooltip="tooltip" data-placement="top" title="Add Air" ><i class="glyphicon glyphicon-plus"></i>
						</span> 
						<div class="row"> &nbsp; </div>
						<div class ="table-responsive">
                        
						  
								  <table class="table table-bordered table-striped" id='airTab' style="border:solid 1px #999; #999; border-radius:0px;">								  
									<thead>
									  <tr>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Line</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Reg</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Unit</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Diameter Pipa</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Abodemen</th>																			
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">ADM %</th>																			
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Bea Adm</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">PH Air Kotor</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">PH Meter</th>																			
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">PH Air Kotor</th>																			
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Kode</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Is Count Self</th>	
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Is Additional</th>		
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Delete</th>
											
									  </tr>
									</thead>									 
									<tbody>									
									   <?php if(isset($utilities_air)){
										   foreach ($utilities_air as $air) : ?> 
									  <tr>
										<td><input type="hidden" id="rekananutilitiesair_line" name="rekananutilitiesair_line[]" value="<?php echo $air['rekananutilitiesair_line'];?>" class="start form-control input-sm" readonly> <?php echo $air['rekananutilitiesair_line'];?> </td>
										<td><input type="text" id="rekananutilitiesair_reg" name="rekananutilitiesair_reg[]" value="<?php echo $air['rekananutilitiesair_reg'];?>" class="start form-control input-sm" > </td>										
										<td><input type="text" id="rekananutilitiesair_unit" name="rekananutilitiesair_unit[]" value="<?php echo $air['rekananutilitiesair_unit'];?>" class="start form-control input-sm" readonly> </td>
										<td><input type="text" id="rekananutilitiesair_diameterpipa" name="rekananutilitiesair_diameterpipa[]" value="<?php echo $air['rekananutilitiesair_diameterpipa'];?>" class="start form-control input-sm" readonly> </td>
										<td><input type="text" id="rekananutilitiesair_abonemen" name="rekananutilitiesair_abonemen[]" value="<?php echo $air['rekananutilitiesair_abonemen'];?>" class="start form-control input-sm"> </td>		
										<td><input type="text" id="rekananutilitiesair_admpercent" name="rekananutilitiesair_admpercent[]" value="<?php echo $air['rekananutilitiesair_admpercent'];?>" class="start form-control input-sm"> </td>										
										<td><input type="text" id="rekananutilitiesair_adm" name="rekananutilitiesair_adm[]" value="<?php echo $air['rekananutilitiesair_adm'];?>" class="start form-control input-sm"> </td>		
										<td><input type="text" id="rekananutilitiesair_phairkotor" name="rekananutilitiesair_phairkotor[]" value="<?php echo $air['rekananutilitiesair_phairkotor'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="rekananutilitiesair_phmeter" name="rekananutilitiesair_phmeter[]" value="<?php echo $air['rekananutilitiesair_phmeter'];?>" class="start form-control input-sm"> </td>																		
										<td><input type="checkbox" id="phairkotor_isdisabled" name="phairkotor_isdisabled[]"<?php if ($air['phairkotor_isdisabled'] == 1) echo 'checked= "checked"';?> value="1"> </td>
										<td><input type="text" id="addkode" name="addkode[]" value="<?php echo $air['addkode'];?>" class="start form-control input-sm"> </td>																																								
										<td><input type="checkbox" id="rekananutilitiesair_iscountself" name="rekananutilitiesair_iscountself[]" <?php if ($air['rekananutilitiesair_iscountself'] == 1) echo 'checked= "checked"';?> value="1"> </td>		 
										<td> 
										<?php 
										$CmbTyAir = array("1" => "Ya", "0" => "Tidak");
										echo form_dropdown('rekananutilitiesair_isadditional[]',$CmbTyAir,$air['rekananutilitiesair_isadditional'],'class="form-control input-sm " ');?> 
										</td>
										<td> - <input type="hidden" name="event_air[]" value="EDIT" /> </td>	 									
										<!-- <td><a id= "airDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td> -->
									  </tr>     
									   <?php endforeach; 
									   } ?>
									</tbody>
								  </table>
							  
						</div>
						</div>	

						<!-- tab GAS-->
						<div class="tab-pane" id="tab7">
						 
						<span  type="" class="btn btn-success btn-sm" id="addgas" data-tooltip="tooltip" data-placement="top" title="Add Gas" ><i class="glyphicon glyphicon-plus"></i>
						</span> 
						<div class="row"> &nbsp; </div>
						<div class ="table-responsive">
                         
						  
								  <table class="table table-bordered table-striped" id='gasTab' style="border:solid 1px #999; #999; border-radius:0px;">								  
									<thead>
									  <tr>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Line</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Reg</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Unit</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Multiple Faktor</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Pressure (mBar)</th>																			
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Tarif</th>																			
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">PH Meter</th>																			
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Bea Adm</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Adm %</th>																												
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Kode</th>
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Is Count Self</th>		
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Is Additional</th>		
										<th bgcolor="#3c8dbc"  style="background: #0096d5; color: white;">Delete</th>
									  </tr>
									</thead>									 
									<tbody>	
									<?php if(isset($utilities_gas)){
										   foreach ($utilities_gas as $gas) : ?> 
									  <tr>
										<td><input type="hidden" id="rekananutilitiesgas_line" name="rekananutilitiesgas_line[]" value="<?php echo $gas['rekananutilitiesgas_line'];?>" class="start form-control input-sm" readonly> <?php echo $gas['rekananutilitiesgas_line'];?> </td>
										<td><input type="text" id="rekananutilitiesgas_reg" name="rekananutilitiesgas_reg[]" value="<?php echo $gas['rekananutilitiesgas_reg'];?>" class="start form-control input-sm" > </td>
										<td><input type="text" id="rekananutilitiesgas_unit" name="rekananutilitiesgas_unit[]" value="<?php echo $gas['rekananutilitiesgas_unit'];?>" class="start form-control input-sm" readonly> </td>
										<td><input type="text" id="rekananutilitiesgas_mfaktor" name="rekananutilitiesgas_mfaktor[]" value="<?php echo $gas['rekananutilitiesgas_mfaktor'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="rekananutilitiesgas_pressure" name="rekananutilitiesgas_pressure[]" value="<?php echo $gas['rekananutilitiesgas_pressure'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="rekananutilitiesgas_tarif" name="rekananutilitiesgas_tarif[]" value="<?php echo $gas['rekananutilitiesgas_tarif'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="rekananutilitiesgas_phmeter" name="rekananutilitiesgas_phmeter[]" value="<?php echo $gas['rekananutilitiesgas_phmeter'];?>" class="start form-control input-sm"> </td>		
										<td><input type="text" id="rekananutilitiesgas_adm" name="rekananutilitiesgas_adm[]" value="<?php echo $gas['rekananutilitiesgas_adm'];?>" class="start form-control input-sm"> </td>		
										<td><input type="text" id="rekananutilitiesgas_admpercent" name="rekananutilitiesgas_admpercent[]" value="<?php echo $gas['rekananutilitiesgas_admpercent'];?>" class="start form-control input-sm"> </td>
										<td><input type="text" id="addkode" name="addkode[]" value="<?php echo $gas['addkode'];?>" class="start form-control input-sm"> </td>																																								
										<td><input type="checkbox" id="rekananutilitiesgas_iscountself" name="rekananutilitiesgas_iscountself[]" <?php if ($gas['rekananutilitiesgas_iscountself'] == 1) echo 'checked= "checked"';?> value="1"> </td>
										
										<td> 
										<?php 
										$CmbTyGas = array(""=>"--Pilih--","1" => "Ya", "0" => "Tidak");
										echo form_dropdown('rekananutilitiesgas_isadditional[]',$CmbTyGas,$gas['rekananutilitiesgas_isadditional'],'class="form-control input-sm " ');?> 
										</td>	
										
										<td> - <input type="hidden" name="event_gas[]" value="EDIT" /></td>
										<!--<td><a id= "gasDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td> -->
									  </tr>     
									   <?php endforeach; 
									   } ?>
									</tbody>
								  </table>
							  
						</div>
						</div>						
										  
                      </div> 
     </div>
     </div>
	 
				<div class="row">&nbsp;</div>
				<div class="form-actions top">   
				  <div class="row"> 
					 <div class="col-md-4"> 
						<div class="col-xs-12">
							<button type="submit" class="btn green" name="post">
								<i class="glyphicon glyphicon-floppy-save"></i> Submit Utilities
							</button>                  
					  </div>
					  </div>
				  </div>
				</div><!--/ Panel Footer --> 
				
			</div> 
		</div>  
	</div>  
	 
<?php echo form_close(); ?>  