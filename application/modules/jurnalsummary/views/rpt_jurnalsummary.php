<script>
  $(document).ready(function(){

 $('#cboacc').select2();
      $('#ibranch').select2({
        placeholder: 'Select an option',
        minimumInputLength: 2,
        //tags: true,
        minimumResultsForSearch: 10,
        tokenSeparators: [',', ' '],
        ajax: {
            url: '<?php echo site_url('proforma/proforma/branch_select')?>',
            dataType: 'json',
            type: "GET",
            data: function (term, region) {
                return {
                    term: term,
                    region: $("#iregion").val()
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.items, function (item) {

                        return {

                            text: item.branch_name,                            
                            id: item.branch_id
                        }
                    })
                };
            }
        }
      });

  $.fn.datepicker.defaults.format = "yyyy-mm-dd";
  $.fn.datepicker.defaults.autoclose = true;

  });
</script>
<div class="row">
  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-body">
        <form id="form1" name="form1" method="post" action="<?php echo site_url('jurnalsummary/printsummary');?>" target="_blank">
          <table width="645" border="0">
            <tr>
              <td width="111" height="10" align="left">Report Type</td>
              <td width="32" height="10" align="left">:</td>
              <td width="488" height="10" align="left">
                <select id= "itype" name= "itype" class="form-control">
                  <option value="sumaryregionbln">Jurnal Summary Bulanan By Region</option>
                  <option value="detilregionbln">Jurnal Detil Summary Bulanan By Region</option>
                </select>               
              </td>
            </tr>
            <tr>
              <td height="10" align="left">&nbsp;</td>
              <td height="10" align="left">&nbsp;</td>
              <td height="10" align="left">&nbsp;</td>
            </tr>
            <tr>
              <td width="111" height="10" align="left">Business Unit</td>
              <td width="32" height="10" align="left">:</td>
              <td width="488" height="10" align="left"><?php 
                echo form_dropdown('cboregion',$region,'','id ="iregion" class="form-control" style="width: 100%;" required'); 
                ?>              </td>
            </tr>
            <tr>
              <td height="10" align="left">&nbsp;</td>
              <td height="10" align="left">&nbsp;</td>
              <td height="10" align="left">&nbsp;</td>
            </tr>
            <tr>
              <td width="111" height="10" align="left">Tanggal</td>
              <td width="32" height="10" align="left">:</td>
              <td width="488" height="10" align="left"><div class="input-group date" data-provide="datepicker">
                      <div class="input-group-addon">
                      <i class="fa fa-calendar"></i></div>
                      <input type="text"  class="form-control input-sm" id="sumary_date" name="sumary_date" placeholder="Start Date" required>
                      <div class="help-block with-errors"></div>
                    </div></td>
            </tr>
            <tr>
              <td height="10" align="left">&nbsp;</td>
              <td height="10" align="left">&nbsp;</td>
              <td height="10" align="left">&nbsp;</td>
            </tr>
            <tr>
              <td height="10" align="left">Account</td>
              <td height="10" align="left">:</td>
              <td height="10" align="left"> <?php echo form_dropdown('cboacc',$acc,'',' id="cboacc" style="width: 100%;" class="form-control " '); ?></td>
            </tr>
            <tr>
              <td height="10" align="left">&nbsp;</td>
              <td height="10" align="left">&nbsp;</td>
              <td height="10" align="left">&nbsp;</td>
            </tr>
            <tr>
              <td height="10" align="left">&nbsp;</td>
              <td height="10" align="left">&nbsp;</td>
              <td height="10" align="left"><input type="submit" name="btload" id="button" value="Generate" class="btn btn-primary" /></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>              
<!-- END OF CONTENT -->