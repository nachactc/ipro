<script>

  $(document).ready(function(){      

      $('#isave').select2({
          placeholder: 'Select an option',
          minimumInputLength: 1,
          minimumResultsForSearch: 10,
          ajax: {
              url: '<?php echo site_url('simpay/simpay/tenant_select')?>',
              dataType: 'json',
              type: "GET",
              data: function (term) {                

                  return {
                      term: term
                  };                
              },
              processResults: function (data, page) {              

                  return {                     
                    results: data.items
                  };            
              },
              cache: true
          },                    
          escapeMarkup: function (markup) { return markup; },

          templateResult: function (response) {

            if (response.id =="" || response.loading) return response.id;

            var markup = 
                "<div class='select2-result-repository clearfix'>" +
                  "<div class='select2-result-repository__title'>" + response.rekananshipping_name + "</div>"+
                  "<div class='select2-result-repository__description'>" + response.rekanan_name + "</div>" +
                  //"<div class='select2-result-repository__forks'><i class='fa fa-file-text-o margin-r-5'></i> " + response.id + "</div>" +
                "</div>";

            return markup;
          },
          templateSelection: function (response) {

            return response.id;
          }
      });

      $('#iload').select2({
          placeholder: 'Select an option',
          minimumInputLength: 2,
          minimumResultsForSearch: 10,
          ajax: {
              url: '<?php echo site_url('simpay/simpay/sim_select')?>',
              dataType: 'json',
              type: "GET",
              data: function (term) {
                  return {
                      term: term
                  };                
              },
              processResults: function (data, page) {              

                  return {                     
                    results: data.items
                  };            
              },
              cache: true
          },                    
          escapeMarkup: function (markup) { return markup; },

          templateResult: function (response) {

            if (response.id =="" || response.loading) return response.id;

            var markup = 
                "<div class='select2-result-repository clearfix'>" +
                  "<div class='select2-result-repository__title'>" + response.id + ' || ' + response.text + "</div>"+
                  "<div class='select2-result-repository__description'>" + response.tenant + "</div>" +
                  "<div class='select2-result-repository__forks'><i class='fa fa-file-text-o margin-r-5'></i> " + response.store + "</div>" +
                "</div>";

            return markup;
          },
          templateSelection: function (response) {

            return response.id||response.text;
          }
      });


      $('#save').click( function (e) {

          e.preventDefault();

          $('[data-toggle="dropdown"]').parent().removeClass('open');

          var data = $('#form1').serialize();

          var selected = new Array();

          var loo_id ='';
          var rekanan_id ='';
          var rekananshipping_line='';

          //selected = $('#isave').select2('data');

          $.post('<?php echo site_url('simpay/simpay/sim_save');?>', 
            {
              data: data
            })
              .done(function (data) {

                  display_modal('Success!', 'Simulation has been saved.');

              })
              .fail(function (xhr) {
                  if (xhr.status == 500) {                      
                      display_modal('Internal error:', xhr.responseText);
                  } else {
                      display_modal('You have an error', xhr.responseText);                      
                  }    
              });

      });
    

      $('#load').click( function (e) {

          $('[data-toggle="dropdown"]').parent().removeClass('open');  

          var dv=[]; 
          var loo_id='';
          var selected = new Array();

          loo_id = $('#iload').val();     

          function loadSim (){
             var ajax = $.get('<?php echo site_url('simpay/simpay/sim_load')?>', 'id='+loo_id, function(data){
               //do something with data here               
             }, 'json');
             return ajax;
          }
             
          loadSim().done(function(results){

            var i = 0;    

            $('.table > tbody > tr > td').parent('tr').empty();

            dv    = results.data;   

            for (i=0; i<dv.length; i++){

                $('#sim_space').val(dv[i][2]);
                $('#sim_term').val(dv[i][3]);
                $('#sim_payterm').val(dv[i][4]);
                $('#sim_baserent').val(dv[i][5]);
                $('#sim_totalrent').val(dv[i][6]);
                $('#sim_fee_per').val(dv[i][7]);
                $('#sim_fee_val').val(dv[i][8]);
                $('#sim_arp_per').val(dv[i][9]);
                $('#sim_arp_val').val(dv[i][10]);
                $('#sim_sc').val(dv[i][11]);
                $('#sim_sc_val').val(dv[i][12]);
                $('#sim_pl').val(dv[i][13]);
                $('#sim_pl_val').val(dv[i][14]);
                $('#sim_angsuran').val(dv[i][15]);
                $('#sim_payment').val(dv[i][16]);
                $('#sim_depo_rent').val(dv[i][17]);
                $('#sim_depo_sc').val(dv[i][18]);
                $('#sim_depo_rent_val').val(dv[i][19]);
                $('#sim_depo_sc_val').val(dv[i][20]);   
                $('#sim_tenant').val(dv[i][21]);      

                //console.log(dv);             
                $('#ibranch').append(new Option(dv[i][23], dv[i][22], true, true)).trigger('change');
                $('#branch_name').val(dv[i][23]);
                $('#sim_id').val(dv[i][24]);
            }            

          });

          e.preventDefault();

      }); 

      $('#iprint').click (function (e) {

        $('[data-toggle="dropdown"]').parent().removeClass('open');        

      });


      $('.deci').number( true, 0);        
      $.fn.datepicker.defaults.format = "yyyy-mm-dd";
      $.fn.datepicker.defaults.autoclose = true;

      function display_modal(title, message){
        $("#mdlinfo").modal("show");
        $("#mdltitle").show().html(title);
        $("#mdlbody").show().html(message);
      }  

      $('#ibranch').select2({
          placeholder: 'Select an option',
          minimumInputLength: 2,
          //tags: true,
          minimumResultsForSearch: 10,
          tokenSeparators: [',', ' '],
          ajax: {
              url: '<?php echo site_url('simpay/simpay/branch_select')?>',
              dataType: 'json',
              type: "GET",
              data: function (term) {
                  return {
                      term: term
                  };
              },
              processResults: function (data) {
                  return {
                      results: $.map(data.items, function (item) {

                          return {

                              text: item.branch_name,
                              region: item.region_id,
                              id: item.branch_id
                          }
                      })
                  };
              }
          }
      });

      $('#ibranch').on('select2:select', function (e) {
        var bra = e.params.data;



        $('#branch_name').val(bra.text);      
            
      });

  });

  $(document).on('hide.bs.dropdown', function (e) {
      if ($(e.currentTarget.activeElement).hasClass('dropdown-toggle')) {
        $(e.relatedTarget).parent().removeClass('open');
        return true;
      }
      return false;
  });

</script>

<style>

.form-group 
{ 
  padding: 2px 0;
}

label {
  font-size: 9pt;
  font-weight: bold;
}

.clearfix:before, .clearfix:after { content: " "; display: table; }
.clearfix:after { clear: both; }

.select2-result-repository { padding-top: 4px; padding-bottom: 3px; }
.select2-result-repository__title { color: black; font-weight: bold; word-wrap: break-word; line-height: 1.1; margin-bottom: 4px; }
.select2-result-repository__description { font-size: 13px; color: #777; margin-top: 4px; }
.select2-result-repository__forks { margin-right: 1em; }
.select2-result-repository__forks { display: inline-block; color: #aaa; font-size: 11px; }
.select2-results__option--highlighted .select2-result-repository__title { color: white; }
.select2-results__option--highlighted .select2-result-repository__forks, 
.select2-results__option--highlighted .select2-result-repository__description { color: #c2d7e9; }

</style>

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

<form id="form1" name="form1" method="post" class="form-horizontal">
<div class = "row">
  <div class = "col-md-12">
    <div class = "portlet">
      <div class="portlet-title">
        <div class="caption" align="right">
          <div class="actions">
            <div class="btn-group">
              <a class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> <i class="fa fa-save"></i> Save
              <i class="fa fa-angle-down"></i>
              </a>
              <ul class="dropdown-menu left">
                <br>
                <div class="col-sm-12">                  
                  <div class="form-group form-group-sm">
                    <label for="contain">
                      File Name:
                    </label>
                    <div class="input-group input-group-sm">
                      <input type="text" class="form-control pull-right" id="sim_id" name="sim_id" value="<?php echo $sim_id; ?>" >                    
                    </div>                    
                  </div>
                  <div class="form-group">
                    <button id="save" type="submit" class="btn btn-primary btn-sm">
                      Submit
                    </button>                   
                  </div>
                </div>
              </ul>
            </div>            
            <div class="btn-group">
              <a class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> <i class="fa fa-print"></i> Print
              <i class="fa fa-angle-down"></i>
              </a>
              <ul class="dropdown-menu pull-right">
                <li>
                  <a id="iprint" href='javascript:;' data-toggle="tooltip" title="Edit" 
                    onclick="$(this).closest('form').attr({target: '_blank', action: '<?php echo site_url("simpay/simpay/sim_print"); ?>'}).submit();">
                  <i class="fa fa-file-pdf-o"></i> PDF </a>
                </li>                
              </ul>
            </div>
            <div class="btn-group">
              <a class="btn green dropdown-toggle" href="javascript:;" data-toggle="dropdown"> <i class="fa fa-bolt"></i> Load
              <i class="fa fa-angle-down"></i>
              </a>
              <ul class="dropdown-menu pull-right">
                <br>
                <div class="col-md-12">                  
                  <div class="form-group form-group-sm">
                    <label for="contain">
                      Select File Simulation
                    </label>
                    <select data-placeholder="Find Doc. LOO" id= "iload" name= "iload" class="form-control" style="width: 250px;">                      
                      <option></option>
                    </select>
                    <br>
                    <button id="load" type="submit" class="btn btn-primary btn-sm">
                      Open
                    </button>
                  </div>
                </div>
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
        <div class="row">  
          <div class="col-md-10">
            <div class="portlet-body form">              
                <div class="form-group">        
                  <label class="col-sm-2">Calculation</label>
                  <div class="col-sm-10">
                    <select id= "itype" name= "itype" class="form-control input-sm">
                      <option value="normal">Normal</option>
                      <option value="step">Step Rental</option>
                    </select>      
                  </div>
                </div>
                <div class="form-group form-group-sm">
                  <label class="col-sm-2">Tenant</label>        
                  <div class = "col-sm-4">                    
                    <input type="text" class="form-control" id="sim_tenant" name="sim_tenant" 
                      value = "<?php echo $tenant_val != '' ? $tenant_val : '' ?>">                        
                  </div>    
                  <label class="col-sm-2">Lokasi</label>        
                  <div class = "col-sm-4">                    
                    <select id= "ibranch" name= "ibranch" class="form-control input-sm">
                      <option value="<?php echo $branch_id;?>" selected="selected" ><?php echo $branch_val;?></option>
                    </select>
                    <input type="hidden" id = "branch_name" name="branch_name" value="<?php echo $branch_val; ?>">
                  </div> 
                </div>  
                <div class="form-group">
                  <label class="col-sm-2">Luas Area</label>        
                  <div class = "col-sm-4">
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_space" name="sim_space" 
                        value = "<?php echo $space_val != '' ? $space_val : 0 ?>" style= "text-align: right;">           
                      <span class="input-group-addon">/M2</span>          
                    </div>  
                  </div>    
                  <label class="col-sm-2">Leasing Period</label>        
                  <div class = "col-sm-4">
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_term" name="sim_term" 
                        value = "<?php echo $term_val!= '' ? $term_val : 0 ?>" style= "text-align: right;">           
                      <span class="input-group-addon">Bln</span>          
                    </div>  
                  </div> 
                </div>      
                <div class="form-group">
                  <label class="col-sm-2">Payment Term</label>        
                  <div class = "col-sm-4">
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_payterm" name="sim_payterm" 
                        value = "<?php echo $payterm_val!= '' ? $payterm_val : 0 ?>" style= "text-align: right;">           
                      <span class="input-group-addon">Bln</span>          
                    </div>  
                  </div>  
                  <label class="col-sm-2">Baserent</label>        
                  <div class = "col-sm-4">
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_baserent" name="sim_baserent" 
                        value = "<?php echo $baserent_val!= '' ? $baserent_val : 0 ?>" style= "text-align: right;">           
                      <span class="input-group-addon">Rp.</span>          
                    </div>  
                  </div>  
                </div> 
                <div class="form-group">
                  <label class="col-sm-2">Total Rent</label>        
                  <div class = "col-sm-10">
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_totalrent" name="sim_totalrent" 
                        value = "<?php echo $total_rent!= '' ? $total_rent : 0 ?>" style= "text-align: right;" readonly>           
                      <span class="input-group-addon">Rp.</span>          
                    </div>  
                  </div>    
                </div>
                <div class="form-group">
                  <label class="col-sm-2">Booking Fee</label>        
                  <div class = "col-sm-4">
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_fee_per" name="sim_fee_per" 
                        value = "<?php echo $dp_fee_per!= '' ? $dp_fee_per : 0 ?>" style= "text-align: right;">           
                      <span class="input-group-addon">(%)</span>          
                    </div>  
                  </div>
                  <label class="col-sm-0"></label>
                  <div class = "col-sm-6">          
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_fee_val" name="sim_fee_val" 
                        value = "<?php echo $dp_fee_val!= '' ? $dp_fee_val : 0 ?>" style= "text-align: right;" readonly>           
                      <span class="input-group-addon">Rp.</span>          
                    </div>  
                  </div>    
                </div>  
                <div class="form-group">
                  <label class="col-sm-2">ARP</label>        
                  <div class = "col-sm-4">
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_arp_per" name="sim_arp_per" 
                        value = "<?php echo $dp_arp_per!= '' ? $dp_arp_per : 0 ?>" style= "text-align: right;">           
                      <span class="input-group-addon">(%)</span>          
                    </div>  
                  </div>
                  <label class="col-sm-0"></label>
                  <div class = "col-sm-6">
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_arp_val" name="sim_arp_val" 
                        value = "<?php echo $dp_arp_val!= '' ? $dp_arp_val : 0 ?>" style= "text-align: right;" readonly>           
                      <span class="input-group-addon">Rp.</span>          
                    </div>  
                  </div>    
                </div>      
                <div class="form-group">
                  <label class="col-sm-2">Service Charge(1st)</label>        
                  <div class = "col-sm-4">
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_sc" name="sim_sc" 
                        value = "<?php echo $sc_baserent!= '' ? $sc_baserent : 0 ?>" style= "text-align: right;">           
                      <span class="input-group-addon">Rp.</span>          
                    </div>  
                  </div>
                  <label class="col-sm-0"></label>
                  <div class = "col-sm-6">          
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_sc_val" name="sim_sc_val" 
                        value = "<?php echo $sc_val!= '' ? $sc_val : 0 ?>" style= "text-align: right;" readonly>           
                      <span class="input-group-addon">Rp.</span>          
                    </div>  
                  </div>    
                </div>
                 <div class="form-group">
                  <label class="col-sm-2">Promotion Levy(1st)</label>        
                  <div class = "col-sm-4">
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_pl" name="sim_pl" 
                        value = "<?php echo $pl_baserent!= '' ? $pl_baserent : 0 ?>" style= "text-align: right;">           
                      <span class="input-group-addon">Rp.</span>          
                    </div>  
                  </div>
                  <label class="col-sm-0"></label>
                  <div class = "col-sm-6">          
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_pl_val" name="sim_pl_val" 
                        value = "<?php echo $pl_val!= '' ? $pl_val : 0 ?>" style= "text-align: right;" readonly>           
                      <span class="input-group-addon">Rp.</span>          
                    </div>  
                  </div>    
                </div>
                <div class="form-group">
                  <label class="col-sm-2">Angsuran per bulan</label>        
                  <div class = "col-sm-4">
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_angsuran" name="sim_angsuran" 
                        value = "<?php echo $angsuran_bln!= '' ? $angsuran_bln : 0 ?>" style= "text-align: right;" readonly>           
                      <span class="input-group-addon">Rp.</span>          
                    </div>  
                  </div>  
                  <label class="col-sm-2">Payment per bulan</label>        
                  <div class = "col-sm-4">
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_payment" name="sim_payment" 
                        value = "<?php echo $payment_bln!= '' ? $payment_bln : 0 ?>" style= "text-align: right;" readonly>           
                      <span class="input-group-addon">Rp.</span>          
                    </div>  
                  </div>         
                </div>  
                <div class="form-group">
                  <label class="col-sm-12">Security Deposit</label>
                  <div class = "col-sm-2">
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_depo_rent" name="sim_depo_rent" 
                        value = "<?php echo $depo_rent!= '' ? $depo_rent : 0 ?>" style= "text-align: right;">           
                      <span class="input-group-addon">Bln</span>          
                    </div> 
                    <div class="help small pull-right">Rental</div> 
                  </div>
                  <div class = "col-sm-4">
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_depo_rent_val" name="sim_depo_rent_val" 
                        value = "<?php echo $depo_rent_val!= '' ? $depo_rent_val : 0 ?>" style= "text-align: right;" readonly>           
                      <span class="input-group-addon">Rp</span>          
                    </div>                     
                  </div>                           
                  <div class = "col-sm-2">          
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_depo_sc" name="sim_depo_sc" 
                        value = "<?php echo $depo_sc!= '' ? $depo_sc : 0 ?>" style= "text-align: right;">           
                      <span class="input-group-addon">Bln</span>          
                    </div> 
                    <div class="help small pull-right">Service Charge</div>
                  </div>
                  <div class = "col-sm-4">
                    <div class="input-group input-group-sm">
                      <input type="text" class="deci form-control pull-right" id="sim_depo_sc_val" name="sim_depo_sc_val" 
                        value = "<?php echo $depo_sc_val!= '' ? $depo_sc_val : 0 ?>" style= "text-align: right;" readonly>           
                      <span class="input-group-addon">Rp</span>          
                    </div>                     
                  </div>  
                </div> 
                <div class="form-group">
                  <div class="col-sm-12">
                    <button type="submit" 
                      onclick="$(this).closest('form').attr('action', 
                        '<?php echo site_url("simpay/simpay/sim_generate"); ?>').submit().removeAttr('target');"
                      name="btprocess" id="button" class="btn btn-info"> Generate </button> 
                  </div>
                </div>
              </form> 
            </div> 
          </div>
        </div>              
        <!-- END OF CONTENT -->

        <!-- CONTENT -->
        <div class="row">
          <div class ="col-md-12"> 
            <div class="portlet-body table-responsive">
              <table class="table table-hover table-scroll table-bordered table-striped table-condensed" border ="1" style="border:solid 1px #999; #999; border-radius:0px;"'>
               <thead>
                <tr>
                  <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">#</th>
              <?php 
               $i =0;

               //print_r($collabel);
                foreach($collabel as $col_title){
                  //$exp_title = explode('|', $col_title);
                  //$_title = $exp_title[1];
              ?>    
                  <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">&nbsp;<?php echo $col_title;?></th> 
              <?php 
                }
              ?>
                  <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Arus Kas</th>
                </tr>
               </thead>
              <tbody>
              <?php
                foreach($rowlabel as $row_title){
              ?>    
                  <tr>
                    <td align='right'>&nbsp;<?php echo $row_title;?>&nbsp;</td>
              <?php
                  foreach($collabel as $col_title){
                    $i = $col_title.'_'.$row_title;     

                    if (isset($zcross_tab[$i])){        
              ?>
                      <td align="right">&nbsp;<?php echo number_format($zcross_tab[$i],0);?>&nbsp;</td>
              <?php     
                    }else{
              ?>      
                      <td align="right">&nbsp;</td>      
              <?php      
                    }
                  }
              ?>      <td align="right"><b>&nbsp;<?php echo number_format($xtotal[$row_title],0);?>&nbsp;</b></td>  
                  </tr>
              <?php  
                }
              ?>
                  <tr><td align="right"><b>&nbsp;Sub Total&nbsp;</b></td>
              <?php
                  $grand_total = 0;

                  foreach($collabel as $col_title){
                      $grand_total += $ytotal[$col_title];
              ?>
                      <td align="right"><b>&nbsp;<?php echo number_format($ytotal[$col_title],0);?></b>&nbsp;</td>
              <?php    
                  }
              ?>      
                      <td align="right"><b>&nbsp;<?php echo number_format($grand_total,0);?>&nbsp;</b></td>    
                  </tr>
                </tbody>
              </table>
            </div>        
            <!-- END SAMPLE TABLE PORTLET-->                
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
