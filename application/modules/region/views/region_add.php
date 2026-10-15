<script> 
/*
var MD5 = function(d){result = M(V(Y(X(d),8*d.length)));return result.toLowerCase()};

function M(d){for(var _,m="0123456789ABCDEF",f="",r=0;r<d.length;r++)_=d.charCodeAt(r),f+=m.charAt(_>>>4&15)+m.charAt(15&_);return f}

function X(d){for(var _=Array(d.length>>2),m=0;m<_.length;m++)_[m]=0;for(m=0;m<8*d.length;m+=8)_[m>>5]|=(255&d.charCodeAt(m/8))<<m%32;return _}

function V(d){for(var _="",m=0;m<32*d.length;m+=8)_+=String.fromCharCode(d[m>>5]>>>m%32&255);return _}

function Y(d,_){d[_>>5]|=128<<_%32,d[14+(_+64>>>9<<4)]=_;for(var m=1732584193,f=-271733879,r=-1732584194,i=271733878,n=0;n<d.length;n+=16){var h=m,t=f,g=r,e=i;f=md5_ii(f=md5_ii(f=md5_ii(f=md5_ii(f=md5_hh(f=md5_hh(f=md5_hh(f=md5_hh(f=md5_gg(f=md5_gg(f=md5_gg(f=md5_gg(f=md5_ff(f=md5_ff(f=md5_ff(f=md5_ff(f,r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+0],7,-680876936),f,r,d[n+1],12,-389564586),m,f,d[n+2],17,606105819),i,m,d[n+3],22,-1044525330),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+4],7,-176418897),f,r,d[n+5],12,1200080426),m,f,d[n+6],17,-1473231341),i,m,d[n+7],22,-45705983),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+8],7,1770035416),f,r,d[n+9],12,-1958414417),m,f,d[n+10],17,-42063),i,m,d[n+11],22,-1990404162),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+12],7,1804603682),f,r,d[n+13],12,-40341101),m,f,d[n+14],17,-1502002290),i,m,d[n+15],22,1236535329),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+1],5,-165796510),f,r,d[n+6],9,-1069501632),m,f,d[n+11],14,643717713),i,m,d[n+0],20,-373897302),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+5],5,-701558691),f,r,d[n+10],9,38016083),m,f,d[n+15],14,-660478335),i,m,d[n+4],20,-405537848),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+9],5,568446438),f,r,d[n+14],9,-1019803690),m,f,d[n+3],14,-187363961),i,m,d[n+8],20,1163531501),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+13],5,-1444681467),f,r,d[n+2],9,-51403784),m,f,d[n+7],14,1735328473),i,m,d[n+12],20,-1926607734),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+5],4,-378558),f,r,d[n+8],11,-2022574463),m,f,d[n+11],16,1839030562),i,m,d[n+14],23,-35309556),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+1],4,-1530992060),f,r,d[n+4],11,1272893353),m,f,d[n+7],16,-155497632),i,m,d[n+10],23,-1094730640),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+13],4,681279174),f,r,d[n+0],11,-358537222),m,f,d[n+3],16,-722521979),i,m,d[n+6],23,76029189),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+9],4,-640364487),f,r,d[n+12],11,-421815835),m,f,d[n+15],16,530742520),i,m,d[n+2],23,-995338651),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+0],6,-198630844),f,r,d[n+7],10,1126891415),m,f,d[n+14],15,-1416354905),i,m,d[n+5],21,-57434055),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+12],6,1700485571),f,r,d[n+3],10,-1894986606),m,f,d[n+10],15,-1051523),i,m,d[n+1],21,-2054922799),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+8],6,1873313359),f,r,d[n+15],10,-30611744),m,f,d[n+6],15,-1560198380),i,m,d[n+13],21,1309151649),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+4],6,-145523070),f,r,d[n+11],10,-1120210379),m,f,d[n+2],15,718787259),i,m,d[n+9],21,-343485551),m=safe_add(m,h),f=safe_add(f,t),r=safe_add(r,g),i=safe_add(i,e)}return Array(m,f,r,i)}

function md5_cmn(d,_,m,f,r,i){return safe_add(bit_rol(safe_add(safe_add(_,d),safe_add(f,i)),r),m)}

function md5_ff(d,_,m,f,r,i,n){return md5_cmn(_&m|~_&f,d,_,r,i,n)}

function md5_gg(d,_,m,f,r,i,n){return md5_cmn(_&f|m&~f,d,_,r,i,n)}

function md5_hh(d,_,m,f,r,i,n){return md5_cmn(_^m^f,d,_,r,i,n)}

function md5_ii(d,_,m,f,r,i,n){return md5_cmn(m^(_|~f),d,_,r,i,n)}

function safe_add(d,_){var m=(65535&d)+(65535&_);return(d>>16)+(_>>16)+(m>>16)<<16|65535&m}

function bit_rol(d,_){return d<<_|d>>>32-_}

*/

  $(document).ready(function(){

  	$("#tabinput").trigger('click');
  	 
  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  	});
	/*
		$('#encrypt').click(function() {
			
			if ($('#password').val() != '' ){
				//alert(MD5($('#password').val()));
				$('#user_password').val(MD5($('#password').val()));
			}
  	});*/
/*
	 $('#cbobranch').select2({
   allowClear: true,
   dropdownCssClass: 'custom-dropdown-1' ,
   placeholder: 'Select an option',
      minimumInputLength: 2,
      //tags: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php //echo site_url('loo_cl/loo_cl/branch_select_dialog')?>',
          dataType: 'json',
          type: "GET",
          data: function (term, region) { 
              return {
                  term: term,
                  region: ''
              };
          },
          processResults: function (data) {
              return {
                  results: $.map(data.items, function (item) { 
                      return { 
                          text: item.branch_name, 
                          id: item.branch_id,
						  region:item.region_id, 
						  region_name:item.region_name,
											  
                      }
					 
                  })
              };
			 
			 
          }
      }  
    });
	$('#cbobranch').on("select2:select", function(e) {
		var valuenya = e.params.data;
		
		region_id_s =e.params.data.id;	
		
		var data = {
			text: valuenya.region_name,
			id: valuenya.region
		}; 
		
		console.log(e.params.data.id);
		var newOption = new Option(data.text, data.id, true, true);
		$('#cboregion').select2({data: [{id: '', text: ''}]});		
		$('#cboregion').append(newOption).trigger('change');
		$('#id_region').val(e.params.data.region); 
	});
	$('#cbobranch').on('select2:open', function(e){
		$('.custom-dropdown-1').parent().css('z-index', 99999);
	});
*/
	/*
	$('#branch_id').change(function(){
			var selectedVal = this.value;
			var selectedText = this.options[this.selectedIndex].text;
			var urls='<?php //echo site_url('user/region_bybranch/')?>' + selectedVal;
			var data='branch=' + selectedVal;
			console.log(selectedVal);
			console.log(selectedText);
			console.log(urls);

			$.ajax({
          url: urls,
          dataType: "json",
					data: data,
          type: "GET",
          success:function(data){	
						console.log(data);
						console.log(data.region[0]);
						console.log(data.region[0].region_id);
						console.log(data.region[0].region_name);
						var id = data.region[0].region_id
						if(id == null ){
								$("#region_id").val('').change();
						}else{
								$("#region_id").val(id).change();
						}
          }
			});

			return false;
	});
*/
	$("#region_isdisabled").on('change',function(e) {
		 
		 
		 	if ($(this).prop("checked") == true) {
				$('#region_isdisabled').val(1);
				console.log('checkbox true'); 
			}
			if ($(this).prop("checked") == false) {
				$('#region_isdisabled').val(0);
				console.log('checkbox false'); 
			}
			 
		
		});
		$("#region_isgroup").on('change',function(e) {
		 
		 
		 if ($(this).prop("checked") == true) {
			$('#region_isgroup').val(1);
			console.log('checkbox true'); 
		}
		if ($(this).prop("checked") == false) {
			$('#region_isgroup').val(0);
			console.log('checkbox false'); 
		}
		 
	
	});

  });




</script>

<style>
table.dataTable td {
    padding:2px;
}
</style>
<div class="modal fade" id="modal-default">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Success!</h4>
              </div>
              <div class="modal-body">
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

 <!-- CONTENT -->
            <div class="row">
              <div class="col-md-12">
                <div class="portlet">
                  <div class="portlet-title">
                    <div class="caption" align="right">
                      <div class="actions">
                        <!--<a href="javascript:;" class="btn green">
                        <i class="fa fa-file-o"></i> Posting </a>
                        <div class="btn-group">
                          <a class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> <i class="fa fa-search"></i> Advanced Search
                          <i class="fa fa-angle-down"></i>
                          </a>
                          <ul class="dropdown-menu pull-right">
                            <br>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="contain">
                                  Author
                                </label>
                                <input class="form-control" type="text" />
                              </div>
                              <div class="form-group">
                                <label for="contain">
                                  Contains the words
                                </label>
                                <input class="form-control" type="text" />
                              </div>
                              <div class="form-group">
                                <label for="contain">
                                  Select Option
                                </label>
                                <select class="form-control">
                                  <option>
                                    Option 1
                                  </option>
                                  <option>
                                    Option 2
                                  </option>
                                  <option>
                                    Option 3
                                  </option>
                                  <option>
                                    Option 4
                                  </option>
                                  <option>
                                    Option 5
                                  </option>
                                </select>
                                <br>
                                <button type="search" class="btn blue">
                                  Search
                                </button>
                              </div>
                            </div>
                          </ul>
                        </div> -->
                        <div class="btn-group">
                          <a class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> <i class="fa fa-print"></i> Export
                          <i class="fa fa-angle-down"></i>
                          </a>
                          <ul class="dropdown-menu pull-right">
                            <li>
                              <a href="javascript:;">
                              <i class="fa fa-file-pdf-o"></i> PDF </a>
                            </li>
                            <li>
                              <a href="javascript:;">
                              <i class="fa fa-file-excel-o"></i> EXCEL </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="tools">
                      <a href="javascript:;" class="collapse"> </a>
                      <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                    </div>
                  </div>
                  <div class="portlet-body">
                    <div class="tabbable-custom ">
                      <ul class="nav nav-tabs ">
                        <li class="active">
                          <a href="<?php echo base_url('index.php/region/region/regionlist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="#inputdata"  data-toggle="tab" id='tabinput'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata"  data-toggle="tab" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">                        
                        <div class="tab-pane" id="inputdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('region/region_add');?>" method="post">

											 <div class="row">
                        <div class="col-md-10">
                           <form id="form_input"> 

                                <div class="col-md-6">
                                    <label>Region ID</label>                                       
                                    <input  type="text" id="region_id" name="region_id" class="form-control" value="" placeholder="Wajib Isi -- Sample: 030" required>
                                </div>                                                                                                 
                                <div class="col-md-6">
                                    <label>Region Name</label>
                                    <input type="text" id ="region_name" name="region_name" class="form-control" value="" placeholder="Wajib Isi" required>
                                </div>
																<div class="col-md-6">
                                    <label>Region Name Short</label>
                                    <input type="text" id ="region_nameshort" name="region_nameshort" class="form-control" value="" placeholder="Wajib Isi" required>
                                </div>
																<div class="col-md-6">
                                    <label>Region Name Report</label>
                                    <input type="text" id ="region_namereport" name="region_namereport" class="form-control" value="" placeholder="Wajib Isi" required>
                                </div>
																<div class="col-md-6">
                                    <label>Region Telp.</label>
                                    <input type="text" id ="region_telp" name="region_telp" class="form-control" value="" placeholder="No. Telpon Bisnis Unit" >
                                </div>
																<div class="col-md-6">
                                    <label>Region Fax</label>
                                    <input type="text" id ="region_fax" name="region_fax" class="form-control" value="" placeholder="No. Fax Bisnis Unit" >
                                </div>
																<div class="col-md-6">
                                    <label>Region Address</label>
                                    <textarea id="region_address" name="region_address" class="form-control" value="" rows="2" placeholder="Alamat Bisnis Unit" ></textarea>
                                </div>
																<div class="col-md-6">
                                    <label>Region Address 2</label>
                                    <textarea id="region_address_2" name="region_address_2" class="form-control" value="" rows="2" placeholder="Alamat Bisnis Unit 2" ></textarea>
                                </div>
																<div class="col-md-6">
                                    <label>Region Bisnis Unit</label>
                                    <input type="text" id ="region_bisnisunit" name="region_bisnisunit" class="form-control" value="" placeholder="Sample: ID030" >
                                </div>
																<div class="col-md-6">
                                    <label>Region Ext ID</label>
                                    <input type="text" id ="region_extid" name="region_extid" class="form-control" value="" placeholder="Sample: C" >
                                </div>
																<div class="col-md-6">
                                    <label>Region NPWP</label>
                                    <input type="text" id ="region_npwp" name="region_npwp" class="form-control" value="" placeholder="Nomor NPWP Bisnis Unit" >
                                </div>
																<div class="col-md-6">
                                    <label>Region Account</label>
                                    <input type="text" id ="region_account" name="region_account" class="form-control" value="" placeholder="Nomor NPWP Bisnis Unit" >
                                </div>
																<div class="col-md-6">
                                    <label>Region PIC</label>
                                    <input type="text" id ="region_pic" name="region_pic" class="form-control" value="" placeholder="PIC" >
                                </div>
																<div class="col-md-6">
                                    <label>Region Signature</label>
                                    <input type="text" id ="region_signature" name="region_signature" class="form-control" value="" placeholder="Signature" >
                                </div>
																<div class="col-md-6">
                                    <label>Region Sender Invoice</label>
                                    <input type="text" id ="region_senderinv" name="region_senderinv" class="form-control" value="" placeholder="Pengirim Invoice" >
                                </div>
																<div class="col-md-6">
                                    <label>Region Sender Email</label>
                                    <input type="text" id ="region_senderemail" name="region_senderemail" class="form-control" value="" placeholder="Email Pengirim" >
                                </div>
																<div class="clearfix margin-bottom-10"></div>
																<div class="col-md-6">
																	<label class="mt-checkbox mt-checkbox-outline">
                              			Is Disabled
																		<?php $data = array(
																							'name'          => 'region_isdisabled',
																							'id'            => 'region_isdisabled', 
																							'checked'       => false,
																							'class'         => 'form-control'
																					);
																			echo form_checkbox($data,false); ?>
                              			<span></span>														
                            			</label>
														    </div>
																<div class="clearfix margin-bottom-10"></div>
																<div class="col-md-6">
																	<label class="mt-checkbox mt-checkbox-outline">
                              			Is Group
																		<?php $data = array(
																							'name'          => 'region_isgroup',
																							'id'            => 'region_isgroup', 
																							'checked'       => false,
																							'class'         => 'form-control'
																					);
																			echo form_checkbox($data,false); ?>
                              			<span></span>														
                            			</label>
														    </div>                                                                
														<div class="clearfix margin-bottom-40"></div>
												

                                      <!-- Custom Tabs -->
                                      <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                          <li class="active"><a href="#tab_1" data-toggle="tab" role= "tab">Record</a></li>
                                        </ul>
                                        <div class="tab-content">                                          
                                           <div class="tab-pane active" id="tab_1">
                                            <div class="row">
                                             <div class="col-md-6">
                                                 <label>Create By</label>
                                                 <input type="text" id= "region_createby" name="region_createby" class="form-control" readonly>
                                             </div>  
                                             <div class="col-md-6">                                          
                                                 <label>Create Date</label>
                                                 <input type="text" id="region_createdate" name="region_createdate" class="form-control" readonly >
                                              </div>                             
                                             <div class="col-md-6">
                                                 <label>Modify By</label>
                                                 <input type="text" id= "region_modifyby"  name="region_modifyby" class="form-control" readonly >
                                             </div> 
                                             <div class="col-md-6">
                                                 <label>Modify Date</label>
                                                 <input type="text" id="region_modifydate" name="region_modifydate" class="form-control" readonly>
                                             </div> 
                                             </div>                               
                                          </div> 
                                          <!-- /.tab-pane -->                                          
                                        </div>
                                        <!-- /.tab-content -->
                                      </div>
                                      <!-- nav-tabs-custom -->


																	<div class="clearfix margin-bottom-40"></div>
                                 
                                <div class="col-xs-12">
                                    <input type="submit" value="SUBMIT" class="btn btn-sm btn-info" />
                                </div>
															
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT -->



