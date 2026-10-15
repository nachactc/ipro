<script>
 var region_id_s = ''; 
function validateb4submit(){
  var max=GetDgvLineMaxNum('looDetil',0);
  if (max < 1 ){
    alert('Please, Add Term & Condition !');
    return false;
  }
}
 
$(document).ready(function(){
	
	 
$.fn.modal.Constructor.prototype.enforceFocus = $.noop;
  var uRows = $('#unittab tbody >tr');
  var uColumns;
  var listunit=[];

  for (var i = 0; i < uRows.length; i++) {

      uColumns = $(uRows[i]).find('td');
      listunit.push({id: $(uColumns[1]).text(), text: $(uColumns[2]).text()});
  }

  unitOptions = {
    ajax: {
      transport: function(params, success, failure) {
      items = listunit;

        if (params.data && params.data.q) {
          items = items.filter(function(item) {
            return new RegExp(params.data.q, "i").test(item.text);
          });
        }

        promise = new Promise(function(resolve, reject) {
          resolve({
            results: items
          });
        });

        promise.then(success);
        promise.catch(failure);
      }
    }
  };

  $('.dropunit').select2(unitOptions);

  if ($('input[type=checkbox]').attr('checked')){

    $('.submit').prop('disabled',true);

  }else{

    $('.submit').prop("disabled", false);

  }

  var lease_id = $('#ilease').val();
  var agrType=[];
  var agrTypeFilter=[]; 


  function callback(data){

      var type = '';

      agrType = data.data;

      type = "CASUAL";

      agrTypeFilter = agrType.filter(function (data) { return data.type == type });
  }

  function getAgreementtype(){
      $.getJSON("<?php echo site_url('loo_cl/loo_cl/agrtype_selecttype'); ?>", function(data){

        callback(data);

      });
  }

  getAgreementtype();


  leasetype = {
    ajax: {
      transport: function(params, success, failure) {

      items = agrTypeFilter;

        if (params.data && params.data.q) {
          items = items.filter(function(item) {
            return new RegExp(params.data.q, "i").test(item.text);
          });
        }

        promise = new Promise(function(resolve, reject) {
          resolve({
            results: items
          });
        });

        promise.then(success);
        promise.catch(failure);
      }
    }
  };
  $('#ilease').on("select2:select", function(e){

    var lease = e.params.data;
    var type = '';
    
    type =  "CASUAL";    

    agrTypeFilter = agrType.filter(function (data) { return data.type == type });

    $('.dropadd').empty();

  });

  $('.dropadd').select2(leasetype);  

  $('#iregion').val([]);
  //$('#iregionsearch').val([]);
  //$('#iutype').val([]);

  $('#iregion').select2({placeholder: 'Select a business unit'});
 
  
  
  $('#ilease').select2({placeholder: 'Choose lease agreement.. '});
  $('#iutype').select2({placeholder: 'Choose Schema ..'});
  $(".js-example-responsive").select2({
    width: 'resolve' // need to override the changed default
});
  $('#ibranch').select2({
      placeholder: 'Select an option',
      minimumInputLength: 2,
      //tags: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('loo_cl/loo_cl/get_branch_dlg')?>',
          dataType: 'json',
          type: "GET",
          data: function (term ) {
              return {
                  term: term 
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
 
  
  $("#itenant").on('keydown paste', function(e){
      e.preventDefault();
  });

  $("#ibrand").on('keydown paste', function(e){
    e.preventDefault();
  });

	var arrid= [];
	//lfrtip =default
  var oTable= foogrid("<?php echo site_url('loo_cl/loo_cl/controler_griddialog')?>","uLoader","trp" );
   
  var rTable=popgrid("<?php echo site_url('loo_cl/loo_cl/controler_gridpop')?>","popLoader","trp", 10);

  var scTable=popgrid("<?php echo site_url('loo_cl/loo_cl/controler_gridschema')?>","scLoader","trp", 10); 
  
  $('#btnload').click( function() {
      var searchName = $("#sUnitName").val();
      var searchID  = $("#sID").val(); 
	  var searchRegionDlg =  $('#region_hidden').val(); 
	  var searchBranchDlg = $("#branchdlg_select").val(); 
	  //console.log(searchRegionDlg); 

	  if(!searchName)
	  {
		searchName = '0'; 
	  }
	  if(!searchID)
	  {
		searchID = '0';
	  }
	  
       $.get("<?php echo site_url('loo_cl/loo_cl/initialize_grid_dialog'); ?>",
              'region_id='+decodeURI(searchRegionDlg)+'&branch_id='+decodeURI(searchBranchDlg)+'&unit_id='+decodeURI(searchName)+'&lantai_id='+decodeURI(searchID),  
              function(d){   
                   oTable.clear();
                   oTable.rows.add(d);                   
                   oTable.draw();
        }, 'json' );
  });


  $("#tabdata").trigger('click');

  $('#btTemplate').click(function() {

    var searchID  = $("#iutype").val();

    scTable.search(searchID).draw();

    scTable.rows('.selected').deselect();
    $("#tempdialog").modal("show");
  });

  $('#bttenant').click(function() {
    rTable.rows('.selected').deselect();
    $("#tedialog").modal("show");
  });

  $('#btnrek').click(function() {
    var searchTenant  = $("#searchTenant").val();

    rTable.search(searchTenant).draw();
  });

  $('#btdetil').click(function() { 
    var activetab = $('.detil .active').text();


    switch(activetab) {

        case 'Terms':
            addRow();
            break;

        case 'Unit':
			
            oTable.rows('.selected').deselect();
			oTable.clear().draw(); 
            $("#mdldialog").modal("show"); 
			
            break;

    }
  });

	$('#tabedit').click(function() {
		alert('Please, select data from list');
	});
 
  $('#btdialog').click(function () {

      var linenum=0;
      var oData = oTable.rows('.selected').data();
      var startDate;

       for (var i=0; i < oData.length; i++){

          var rid=oData[i][0];
          var rregion=oData[i][1];
          var rbranch=oData[i][2];
          var runit=oData[i][3];
          var rsize=oData[i][4];
          var rlantai=oData[i][5]; 
          var rregion_id=oData[i][6];
          var rbranch_id=oData[i][7];
		      var nsdate = '';
          var nedate = '';
          var max=GetDgvLineMaxNum('unittab',0)
          linenum= Number(max) + 10;
          var t="tcharge"+linenum;
          var Tenant  = $("#htenant").val();
          var Brand  = $("#hbrand").val();

          $('#unittab tbody').append('<tr>'+
            '<td>' + linenum + '<input type="hidden" name="uline[]" value="'+ linenum +'"/></td>'+
            '<td>'+ rid +'<input type="hidden" name="uunit[]" value="'+ rid +'"/></td>'+
            '<td>'+ rregion +'<input type="hidden" name="Objregion_id[]" value="'+ rregion_id +'"/></td>'+
            '<td>'+ rbranch	 +'<input type="hidden" name="Objbranch_id[]" value="'+ rbranch_id +'"/></td>'+
            '<td>'+ runit	 +'</td>'+
            '<td>'+ rsize +'<input type="hidden" name="usize[]" value="'+ rsize +'"/></td>'+
            '<td>'+ rlantai +'<input type="hidden" name="ulantai[]" value="'+ rlantai +'"/></td>'+ 
			'<td><input type="text" id= "nva" name="va[]" value="" class="form-control input-sm" readonly/>'+
            '<td><input type="text" id= "nsdate" name="usdate[]" value="" class="date1 form-control input-sm"/></td>'+   
            '<td><input type="text" id= "nedate" name="uedate[]" value="" class="date2 form-control input-sm"/>'+ 
            '<input type="hidden" id= "dTenant" name="uTenant[]" value="'+ Tenant +'" class="form-control input-sm"/>'+
            '<input type="hidden" id= "dBrand" name="uBrand[]" value="'+ Brand +'" class="form-control input-sm"/></td>'+
            '<td><a id= "uDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a></td></tr>');
		         
          
          $('.date1').datepicker().on('changeDate', function(e) {

              listunit.map((obj) => {
                 if(obj.line == linenum){
                   obj.start = $(this).val();
                   //obj.baz[1] = 22;
                 }
              });

              $('.dropunit').empty();

          });

          $('.date2').datepicker().on('changeDate', function(e) {

              listunit.map((obj) => {
                 if(obj.line == linenum){
                   obj.end = $(this).val();
                   //obj.baz[1] = 22;
                 }
              });

              $('.dropunit').empty();

          });

          listunit.push({id: rid, text: runit, line: linenum, region: rregion_id, branch: rbranch_id, tenant: Tenant, brand: Brand, start: '', end: ''});

       }	   
		
  });
  

  $('#addtenant').click(function () {

      var linenum=0;
       var rData = rTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid     = rData[i][0];
          var tname   = rData[i][1];
          var tline   = rData[i][2];
          var tbrand   = rData[i][3];

          $('#htenant').val(tid);
          $('#itenant').val(tname);
          $('#hbrand').val(tline);
          $('#ibrand').val(tbrand);
      }

  });

  $('#addschema').click(function () {

      var linenum=0;
      var scData = scTable.rows('.selected').data();

      for (var i=0; i < scData.length ;i++){

          var _id     = scData[i][0];
          var _dp     = scData[i][2];

          //console.log(scData);

          $('#skl_id').val(_id);

          $('#loo_descr').val('Harga Sewa dan Biaya Listrik tersebut diatas harus dibayarkan  sebesar 100% dimuka per penempatan atau selambat-lambatnya 1 minggu sebelum penempatan mesin ATM.');
		  addRow("pls");
		  $('#pls').append(new Option('Pole Sign', '9600', false, false)).trigger('change');
		  addRow("el");
		  $('#el').append(new Option('Electricity', '25000', false, false)).trigger('change');
		  addRow("elp");
		  $('#elp').append(new Option('Electricity-Periodical', '9500', false, false)).trigger('change');
		  addRow("or");
		   $('#or').append(new Option('Outlet Rental', '20000', false, false)).trigger('change');
          // addRow("dp");
          // $('#dp').append(new Option('Down Payment', '2000', false, false)).trigger('change');
          // $('#per_dp').val(_dp);
          // $('#chk_dp').prop('checked', true);
          // $('#chg_dp').prop('readonly', true);
          // $('#per_dp').prop('readonly', false);
          // $('#cper_dp').val('1');
          // addRow("pl");
          // $('#pl').append(new Option('Promo Levy', '6000', false, false)).trigger('change');
          // $('#des_pl').val('/ m2 / Bulan tidak termasuk PPn');
          // addRow("ins");
          // $('#ins').append(new Option('Installment', '4000', false, false)).trigger('change');
          // $('#des_ins').val('/ m2 / Bulan tidak termasuk PPn');
          // addRow("sc");
          // $('#sc').append(new Option('Service Charge', '5000', false, false)).trigger('change');
          // $('#des_sc').val('/ m2 / Bulan tidak termasuk PPn \n' +
            // '(Dibayarkan setiap 3 ( tiga ) bulan dimuka  dan pembayaran biaya pelayanan pertama kali harus dimulai sejak tanggal mulai sewa. '+
            // 'Biaya Pelayanan akan ditinjau ulang setiap periode.)');
          // addRow("sdr");
          // $('#sdr').append(new Option('Security Deposit R', '7000', false, false)).trigger('change');
          // $('#des_sdr').val('bulan Harga Sewa dan Service Charge \n' +
            // 'Jaminan sewa  tersebut  dapat  dikembalikan  secara utuh,  tanpa '+
            // 'bunga  pada  masa   berakhirnya  masa  sewa  mengacu  kepada '+
            // 'dipatuhinya  segala ketentuan dan syarat-syarat PERJANJIAN dari '+
            // 'Penyewa,  tetapi  tidak  akan dikembalikan bila terjadi pemutusan '+
            // 'awal yang disebabkan oleh wanprestasi pembayaran PENYEWA.');
          // addRow("sdc");
          // $('#sdc').append(new Option('Security Deposit SC', '7500', false, false)).trigger('change');
          // $('#des_sdc').val('bulan Harga Sewa dan Service Charge \n' +
            // 'Jaminan sewa  tersebut  dapat  dikembalikan  secara utuh,  tanpa '+
            // 'bunga  pada  masa   berakhirnya  masa  sewa  mengacu  kepada '+
            // 'dipatuhinya  segala ketentuan dan syarat-syarat PERJANJIAN dari '+
            // 'Penyewa,  tetapi  tidak  akan dikembalikan bila terjadi pemutusan '+
            // 'awal yang disebabkan oleh wanprestasi pembayaran PENYEWA.');
          // addRow("el");
          // $('#el').append(new Option('Electricity', '9100', false, false)).trigger('change');
          // $('#des_el').val('Berdasarkan pemakaian bulanan ditambah administrasi 10% dan Ppn 10%');
          // addRow("wa");
          // $('#wa').append(new Option('Water', '9400', false, false)).trigger('change');
          // $('#des_wa').val('Berdasarkan pemakaian bulanan ditambah administrasi 10% dan Ppn 10%');
          // addRow("ga");
          // $('#ga').append(new Option('Gas', '9300', false, false)).trigger('change');
          // $('#des_ga').val('Berdasarkan pemakaian bulanan ditambah administrasi 10% dan Ppn 10%');
          // addRow("tel");
          // $('#tel').append(new Option('Telephone', '9200', false, false)).trigger('change');
          // $('#des_tel').val('Pihak Pemilik akan menyediakan minimal 1 (satu) line telepon untuk setiap ruang usaha '+
            // 'dengan biaya deposit sebesar Rp. 3.500.000,- (Tiga Juta Lima Ratus Ribu Rupiah) (Refundable) per line '+
            // 'dengan biaya penyambungan sebesar Rp. 1.000.000,- (Satu Juta Rupiah)');
          // addRow("tdep");
          // $('#tdep').append(new Option('Telephone Deposit', '8000', false, false)).trigger('change');
          //addRow();

      }

      //console.log($('#dp'));

  });

  $("#looDetil").on('click','#btnDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }
      $(this).closest('tr').remove();
  });

  $("#looDetil").on('change', "input[type='checkbox']", function (e) {


      $(this).closest('tr').find('input[type="text"]').eq(0).prop('readonly', e.target.checked ? true: false);
      $(this).closest('tr').find('input[type="text"]').eq(1).prop('readonly', e.target.checked ? false: true);
      $(this).closest('tr').find('input[type="hidden"]').eq(1).val(e.target.checked ? 1: 0);

  });


  $("#unittab").on('click','#uDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }

      var cari =0;
      var deleted = $(this).closest('tr').find('td:eq(1)').text();

      $('.dropunit').each(function(){
            if (deleted == $(this).val()){

                display_modal('Alert!', 'Unit #'+deleted+'# Is Already Chosen.');
                cari = 1;
                return false;
            }

      });

      if (cari == 0)  {

        for (var i = 0; i < listunit.length; i++){

          if (listunit[i].id && listunit[i].id === deleted) {

              listunit.splice(i, 1);
          }
        }

        $(this).closest('tr').remove();

      }

  });


  $.fn.datepicker.defaults.format = "yyyy-mm-dd";
  $.fn.datepicker.defaults.autoclose = true; 
  function addRow(ci) {

      var linenum=0;
      var lease_id = $('#ilease').val();

      var max=GetDgvLineMaxNum('looDetil',0)
      linenum= Number(max) + 10; 
	
      $('#looDetil tbody').append('<tr>'+
        '<td>' + linenum + '<input type="hidden" name="tline[]" value="'+ linenum +'" readonly class="nogaris"/></td>'+
        '<td><select data-placeholder = "Select unit" id= "unit_id" name= "tunit[]" required class="dropunit form-control input-sm" style="width: 100%;">'+
            '</select></td>'+
        '<td><select data-placeholder = "Select an option" id= "'+ci+'" name= "tatype[]" required class="dropadd form-control input-sm" style="width: 100%;">'+
            '</select></td>'+
        '<td><input type="text" id="chg_'+ci+'" name="tcharge[]" value="0" class="deci form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><input type="checkbox" id="chk_'+ci+'"><input type="hidden" id="cper_'+ci+'" name="tper[]" value="0"/></td>'+
        '<td><input type="text" id= "per_'+ci+'" name="tval[]" value="0" class="deci form-control input-sm" style= "text-align: right;" readonly/></td>'+
        '<td><input type="text" name="tint[]" value="0" class="form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><?php echo form_dropdownext('titype[]',$titype,$this->input->post('titype'),'id="titype" class="form-control input-sm" required');?></td>'+
        '<td><input type="text" id= "des_'+ci+'" name="tdescr[]" value="" class="pops form-control input-sm"/>'+
        '<input type="hidden" id= "dRegion" name="dRegion[]" value="" class="form-control input-sm"/>'+
        '<input type="hidden" id= "dBranch" name="dBranch[]" value="" class="form-control input-sm"/>'+
        '<input type="hidden" id= "dTenant" name="dTenant[]" value="" class="form-control input-sm"/>'+
        '<input type="hidden" id= "dBrand" name="dBrand[]" value="" class="form-control input-sm"/>'+
        '<input type="hidden" id= "dStart" name="dStart[]" value="" class="form-control input-sm"/>'+
        '<input type="hidden" id= "dEnd" name="dEnd[]" value="" class="form-control input-sm"/>'+
        '</td>'+
        '<td><a id= "btnDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>'+ 
        ' </tr>');

      $('.deci').number( true, 2 );

      $('.dropunit').select2(unitOptions);
      $('.dropadd').select2(leasetype);

      $('.pops').popover({   
            trigger: 'manual',    
            placement: 'left',
            title: function(){
              var line = $(this).closest('tr').find('td:eq(0)').text();
              var frm = 'Descr Line: '+line;

              return frm;
            },
            html:true,
            content: function() {          
              var olddesc = $(this).val();

              $('#popover-form').find('textarea[name="txtContent"]').text(olddesc);

              return $('#popover-form').html();
            } 
        }).on('click', function(){
          // had to put it within the on click action so it grabs the correct info on submit
          var $popup = $(this);

          $(this).popover('show');

          $('.btn-primary').click(function(){

            var newdesc = $('.popover #txtContent').val();

            $($popup[0]).val(newdesc);

            $popup.popover('hide');

          });

          $('.btn-default').click(function(){

            $popup.popover('hide');
            
          });
      });

      $('body').on('click', function (e) {
        $('.pops').each(function () {
            // hide any open popovers when the anywhere else in the body is clicked
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });   
      });

      $('.dropunit').on("select2:select", function(e){
        var uData = e.params.data;        

        $(this).closest('tr').find('input[type="hidden"]').eq(2).val(uData['region']);
        $(this).closest('tr').find('input[type="hidden"]').eq(3).val(uData['branch']);
        $(this).closest('tr').find('input[type="hidden"]').eq(4).val(uData['tenant']);
        $(this).closest('tr').find('input[type="hidden"]').eq(5).val(uData['brand']);
        $(this).closest('tr').find('input[type="hidden"]').eq(6).val(uData['start']);
        $(this).closest('tr').find('input[type="hidden"]').eq(7).val(uData['end']);

      });

  }

  $('.pops').popover({   
        trigger: 'manual',    
        placement: 'left',
        title: function(){
          var line = $(this).closest('tr').find('td:eq(0)').text();
          var frm = 'Descr Line: '+line;

          return frm;
        },
        html:true,
        content: function() {          
          var olddesc = $(this).val();

          $('#popover-form').find('textarea[name="txtContent"]').text(olddesc);

          return $('#popover-form').html();
        } 
    }).on('click', function(){
      // had to put it within the on click action so it grabs the correct info on submit
      var $popup = $(this);

      $(this).popover('show');

      $('.btn-primary').click(function(){

        var newdesc = $('.popover #txtContent').val();

        $($popup[0]).val(newdesc);

        $popup.popover('hide');

      });

      $('.btn-default').click(function(){

        $popup.popover('hide');
        
      });
  });

  $('body').on('click', function (e) {
    $('.pops').each(function () {
        // hide any open popovers when the anywhere else in the body is clicked
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });   
  });
 
  $('#regionDlg_select').select2({
   dropdownCssClass: 'custom-dropdown'  
    });

  $('#regionDlg_select').on('select2:open', function(e){
      $('.custom-dropdown').parent().css('z-index', 99999);
  });
	  
  
	 
  $('#branchdlg_select').select2({
   allowClear: true,
   dropdownCssClass: 'custom-dropdown-1' ,
   placeholder: 'Select an option',
      minimumInputLength: 2,
      //tags: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('loo_cl/loo_cl/branch_select_dialog')?>',
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
	$('#branchdlg_select').on("select2:select", function(e) {
		var valuenya = e.params.data;
		
		region_id_s =e.params.data.id;	
		
		var data = {
			text: valuenya.region_name,
			id: valuenya.region
		}; 
		
		console.log(e.params.data.id);
		var newOption = new Option(data.text, data.id, true, true);
		$('#regionDlg_select').select2({data: [{id: '', text: ''}]});		
		$('#regionDlg_select').append(newOption).trigger('change');
		$('#region_hidden').val(e.params.data.region); 
	});

	
  $('#branchdlg_select').on('select2:open', function(e){
      $('.custom-dropdown-1').parent().css('z-index', 99999);
  });
  
});

$(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );
 
  
</script>

<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

.table td{
    padding:2px;
    font-size: 9pt;
    font-family:  Arial, Verdana, sans-serif;

}

label {
  font-size: 9pt;
}


</style> 
    <div id="popover-form" class="hide">
      <div class="form-group">
        <textarea rows="4" name="txtContent" id="txtContent" class="form-control input-sm"></textarea>        
        <br>
        <button id="btnOk" type="button" class="btn btn-primary">
          <span class="glyphicon glyphicon-ok"></span>&nbsp;
        </button>  
        <button id="btnCancel" type="button" class="btn btn-default">
          <span class="glyphicon glyphicon-remove"></span>&nbsp;
        </button>
      </div>
    </div>
  
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

        <div class="modal fade" id="mdldialog" tabindex="-1" role="basic" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            </button>
                            <h4 class="modal-title">
                              Data Unit
                            </h4>
                          </div>
                          <div class="modal-body"> 
                            <form action="#" id="form" class="form-horizontal">
							
							  
                            <div class="row"> 
							<div class="col-md-4">
                                 <label>Store</label>
								 <select id="branchdlg_select" class="form-control" style="width: 100%;"> </select> 
                              </div> 
							 <div class="col-md-4">
                                 <label>Business Unit</label>
                                <?php echo form_dropdown('cboregionDlg','','',' id="regionDlg_select" style="width: 100%;" class="iregionsearch form-control " disabled'); ?>
								<input type="hidden" id="region_hidden" name="region_id_hidden" />
                              </div> 
							</div>
							
                            <div class="row"> 
							  <div class="col-md-4">
                                 <label>Unit</label>
                                <input  type="text" id="sID" class="form-control input-sm" placeholder="Search Unit" >
                              </div>							
                              <div class="col-md-4">
                                <label>Lantai</label>
                                <input  type="text" id="sUnitName" class="form-control input-sm" placeholder="Search Lantai" >
                              </div>
                              <div class="col-md-4" align="right">
                                <br>
                                <input type="button" id="btnload" value = "LOAD" class="btn btn-sm btn-info"/>
                              </div>
                            </div>
                           <div class="portlet-body">
                            <div class="table-container">
                              <div class="table-scrollable">
                                <table class="table table-striped table-bordered table-hover nowrap compact" id='uLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                                  <thead>
                                   <tr>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Region</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Branch</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Name</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Sqm</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Lantai</th>
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
                            <button type="button" class="btn green" data-dismiss="modal" id="btdialog">
                              Add Selected Data
                            </button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>

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
                               <label>Search Tenant || Brand</label>
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
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                    <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Brand</th>
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

                    <!-- /.popup-template -->
                    <div class="modal fade" id="tempdialog" tabindex="-1" role="basic" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            </button>
                            <h4 class="modal-title">
                              Schema Unit
                            </h4>
                          </div>
                          <div class="modal-body">
                            <form action="#" id="form" class="form-horizontal">
                              <div class="row">
                                <div class="col-md-4">
                                   <label>Unit</label>
                                  <input  type="text" id="sID" class="form-control input-sm" placeholder="Search Unit" >
                                </div>
                                <div class="col-md-4">
                                  <label>Lantai</label>
                                  <input  type="text" id="sUnitName" class="form-control input-sm" placeholder="Search Lantai" >
                                </div>
                                <div class="col-md-4" align="right">
                                  <br>
                                  <input type="button" id="btnload" value = "LOAD" class="btn btn-sm btn-info"/>
                                </div>
                              </div>
                              <div class="portlet-body">
                                <div class="table-container">
                                  <div class="table-scrollable">
                                    <table class="table table-striped table-bordered table-hover nowrap" id='scLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                                      <thead>
                                       <tr>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Schema</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">DP(%)/bln</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Inst.(X)</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">LOO(%)</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">LOI(%)</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">SD.R(%)</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">SD.SC(%)</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Ltrk.</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Air</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Gas</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Telp.</th>
                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Type</th>
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
                            <button type="button" class="btn green" data-dismiss="modal" id="addschema">
                              Accept
                            </button>
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
                        </div>
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
                          <a href="<?php echo base_url('index.php/loo_cl/loo_cl/penalist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>
                          <a href="#newdata" data-toggle="tab" id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata" id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane" id="newdata">
                          <div class="portlet-body form">
                         <form action="<?php echo site_url('loo_cl/loo_cl/loo_add');?>" method="post" onsubmit="return validateb4submit();">
                            <?php
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>
                    <div class="row">
                      <div class="col-md-12">
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>ID</label>
                                      <input  type="text" id="looid" name="loo_id" class="form-control input-sm" value="<?php echo $row->loo_id;?>" readonly>
                                    </div>
                                  </div>
                                  <!-- /.form group -->
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Date</label>
                                      <div class="input-group date">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                          <input type="text" class="form-control input-sm pull-right" id="loo_date" name="loo_date" value = "<?php echo $row->loo_date;?>" readonly>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                   <div class="col-xs-12">
                                      <label class="checkbox-inline"><input type="checkbox" disabled>Returned</label>
                                      <label class="checkbox-inline"><input type="checkbox" disabled>Approved</label>
									  <label class="checkbox-inline"><input type="checkbox" name="ismulti">Multi</label>
                                   </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Start Date</label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="loo_sdate" name="loo_sdate" value = "<?php echo $row->loo_sdate;?>">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>End Date</label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="loo_edate" name="loo_edate" value = "<?php echo $row->loo_edate;?>">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Term Period</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="<?php echo $row->loo_term;?>" readonly>
                                    </div>
                                  </div>
                                  <!--<div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                    <label>Business Unit</label>
                                      <?php //echo form_dropdown('cboregion',$region,'','id ="iregion" class="form-control" style="width: 100%;" required'); ?>
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Store</label>
                                        <select data-placeholder="Select a store" id= "ibranch" name= "cbobranch" required>
                                          <option value="<?php //echo $row->branch_id;?>" selected="selected" ><?php //echo $row->branch_id;?></option>
                                        </select>
                                    </div>
                                  </div>--> 
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Lease Agreement</label>
									     <select data-placeholder="Select a Lease Agreement" id= "ilease" name= "cbolease" disabled>
                                          <option value="1" selected="selected" >Casual Leasing</option>
                                        </select>
                                        
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <a href="javascript:void(0)" id="bttenant"><strong>Tenant:</strong></a>
                                      <input type="text" id = "itenant" name="itenant" class="form-control input-sm"  required autocomplete="off">
                                      <input type="hidden" id = "htenant" name="htenant" value="" >
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                        <label></label>
                                        <input type="text" id = "ibrand" name="ibrand" class="form-control input-sm" value="" required autocomplete="off">
                                        <input type="hidden" id = "hbrand" name="hbrand" value="">
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Unit Type</label>
                                          <?php echo form_dropdown('cbounittype',$unittype,'6','id ="iutype" class="form-control" style="width: 100%;" required disabled'); ?>
                                    </div>
                                  </div>
								  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Fitting Out</label>
                                        <input data-placeholder="Fitting Out (Angka)" type="text" id = "fitting_out" name="fitting_out" class="form-control input-sm" value="<?php echo $row->fitting_out;?>">
                                    </div>
                                  </div>
								   <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Grace Period</label>
                                        <input data-placeholder="Grace Period (Angka)" type="text" id = "grace_period" name="grace_period" class="form-control input-sm" value="<?php echo $row->grace_period;?>">
                                    </div>
                                  </div>
								   <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Size Indoor</label>
                                        <input data-placeholder="Size Indoor (Angka)" type="text" id = "size_indoor" name="size_indoor" class="form-control input-sm" value="<?php echo $row->size_indoor;?>">
                                    </div>
                                  </div>
								   <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Size Outdoor</label>
                                        <input data-placeholder="Size Outdoor (Angka)" type="text" id = "size_outdoor" name="size_outdoor" class="form-control input-sm" value="<?php echo $row->size_outdoor;?>">
                                    </div>
                                  </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                        <label>Product Name:</label> 
                                        <input data-placeholder="Product Name" type="text" id = "product_name" name="product_name" class="form-control input-sm" value="<?php echo $row->product_name;?>">
                                    </div>
                                  </div>
                                  <div class="col-md-12 form-group row">
                                    <div class="col-xs-12">
                                        <label>Payment Description :</label>
                                        <input type="hidden" id = "skl_id" name="skl_id" value="">
                                        <textarea id = "loo_descr" name="loo_descr" class="form-control input-sm" required rows="2" ></textarea>
                                    </div>
                                  </div>
                                  <div class="col-md-12 form-group row">
                                    <div class="col-xs-12">
                                        <label> Rent Periode Description:</label> 
                                        <textarea id = "loo_rent_desc" name="loo_rent_desc" class="form-control input-sm" required rows="2" ></textarea>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <a href="javascript:void(0)" id="btTemplate"><strong>Add Template</strong></a>
                                  <br>
                                  <br>
                                    <a href="javascript:void(0)" id="btdetil"><strong>Add Row</strong></a>
                                      <!-- Custom Tabs -->
                                      <div class="nav-tabs-custom">
                                        <ul class="detil nav nav-tabs">
                                          <li class="active"><a href="#tab_1" data-toggle="tab" role= "tab">Terms</a></li>
                                          <li><a href="#tab_2" data-toggle="tab" role = "tab">Unit</a></li>
                                          <li><a href="#tab_3" data-toggle="tab" role = "tab">Record</a></li>
                                        </ul>
                                        <div class="tab-content">
                                          <div class="tab-pane active" id="tab_1">
                                            <div class ="table-responsive">
                                              <table class="table table-bordered table-striped" id='looDetil' style="border:solid 1px #999; #999; border-radius:0px;">
                                                <thead>
                                                  <tr>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Unit</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Term & Condition</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Charge</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">(%)</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Val</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Int.</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Time</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Descr</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Delete</th> 
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <?php if(isset($resultd)){
                                                      foreach($resultd as $rowd){
                                                  ?>
                                                    <tr>
                                                    <td><?php echo "$rowd->loodetil_line";?><input type="hidden" name="tline[]" value="<?php echo "$rowd->loodetil_line";?>"/></td>
                                                    <td>
                                                      <select data-placeholder="Choose Unit" id= "unit_id" name= "tunit[]" required class="dropunit form-control input-sm" style="width: 100%;">
                                                        <option value="<?php echo $rowd->unit_id;?>" selected="selected" ><?php echo $rowd->unit_name;?></option>
                                                      </select>
                                                    </td>
                                                    <td>
                                                      <select data-placeholder="Select an option .." id= "tatype" name= "tatype[]" required class="dropadd form-control input-sm" style="width: 100%;">
                                                        <option value="<?php echo $rowd->agreementtype_id;?>" selected="selected" ><?php echo $rowd->agreementtype_name;?></option>
                                                      </select>
                                                    </td>
                                                    <td><input type="text" name="tcharge[]" value="<?php echo "$rowd->loodetil_baserent";?>" class="deci form-control input-sm" style= "text-align: right;" <?php if ($rowd->loodetil_ispercent) echo 'readonly'; ?> /></td>
                                                    <td><input type="checkbox" id="" <?php if ($rowd->loodetil_ispercent == 1) echo 'checked= "checked"';?> >
                                                      <input type="hidden" name="tper[]" value = "<?php echo "$rowd->loodetil_ispercent"; ?>" /></td>
                                                    <td><input type="text" name="tval[]" value="<?php echo "$rowd->loodetil_percent";?>" class="deci form-control input-sm" style= "text-align: right;" <?php if (!($rowd->loodetil_ispercent)) echo 'readonly'; ?> /></td>
                                                    <td><input type="text" name="tint[]" value="<?php echo "$rowd->loodetil_int";?>" class="form-control input-sm" style= "text-align: right;" /></td>
                                                    <td><?php echo form_dropdownext('titype[]',$titype,"$rowd->timetype_id",'id="titype" class="form-control input-sm" required');?></td>
                                                    <td><input type="text" name="tdescr[]" value="<?php echo "$rowd->loodetil_descr";?>" class="form-control input-sm"/></td>
                                                    <td><a id= "btnDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
                                                    </tr>
                                                    <script>
                                                    $('.deci').number( true, 2 );
                                                    </script>
                                                  <?php
                                                     }
                                                   }
                                                  ?>
                                                </tbody>
                                              </table>
                                             </div>
                                            </div>
                                            <div class="tab-pane" id="tab_2">
                                             <div class ="table-responsive">
                                              <table class="table table-bordered table-striped" id='unittab' style="border:solid 1px #999; #999; border-radius:0px;">
                                                <thead>
                                                  <tr>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Region</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Branch</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Unit</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">SQM ( M2 )</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Floor</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Virtual Account</th>
													  <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Start Date</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">End Date</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Delete</th>
                                                  </tr>
                                                </thead>
                                                <tbody>                                                   
                                                </tbody>
                                              </table>
                                             </div>
                                            </div>
                                          <div class="tab-pane" id="tab_3">
                                            <div class="row">
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Create By</label>
                                                 <input type="text" id= "_createby" name="_createby" class="form-control" value="<?php echo $row->_createby;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Create Date</label>
                                                 <input type="text" name="_createdate" class="form-control " value="<?php echo $row->_createdate;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Modify By</label>
                                                 <input type="text" id= "_modifyby"  name="_modifyby" class="form-control " value="<?php echo $row->_modifyby;?>">
                                              </div>
                                             </div>
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Modify Date</label>
                                                 <input type="text" name="_modifydate" class="form-control" value="<?php echo $row->_modifydate;?>">
                                              </div>
                                             </div>
                                             </div>
                                          </div>
                                          <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                      </div>
                                      <!-- nav-tabs-custom -->
                                    </div>
                                    <!-- /.col -->
                                <div class="col-xs-12">
                                    <br /><input type="submit" value="SUBMIT" class="btn btn-sm btn-info" />
                                </div>
                              </div>
                             </div>
                            </form>
                            <?php }}?>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END OF CONTENT -->
