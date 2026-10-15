<script>



$(document).ready(function(){

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
  var ShippingType=[];
  var ShippingTypeFilter=[];
  var rekanan_id = $('#itenant').val();


  function callback(data){

      var type = '';

      agrType = data.data;

      type = (lease_id === '0') ? "PERMANENT" : "CASUAL";

      agrTypeFilter = agrType.filter(function (data) { return data.type == type });
  }



  function getAgreementtype(){
      $.getJSON("<?php echo site_url('taxbranch/taxbranch/agrtype_selecttype'); ?>", function(data){

        callback(data);
          //console.log(data);
          //console.log('tes');
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

  shippingname = {
    ajax: {
      transport: function(params, success, failure) {

      items = ShippingType;

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


    type = (lease.id === '0') ? "PERMANENT" : "CASUAL";

    agrTypeFilter = agrType.filter(function (data) { return data.type == type });

    $('.dropadd').empty();

  });

  $('#ishipping').on("select2:select", function(e){

    var lease = e.params.data;
    var type = '';


    type = (lease.id === '0') ? "PERMANENT" : "CASUAL";

    agrTypeFilter = agrType.filter(function (data) { return data.type == type });

    $('.dropadd').empty();

  });

  $('.dropadd').select2(leasetype);
  $('.dropshope').select2(shippingname);

  $('#iregion').val([]);
  //$('#ilease').val([]);
  //$('#iutype').val([]);
  $('#ishipping').val([]);

  $('#iregion').select2({placeholder: 'Select a business unit'});
  $('#ilease').select2({placeholder: 'Choose lease agreement.. '});
  $('#iutype').select2({placeholder: 'Choose Unit ..'});
  $('#ishipping').select2({placeholder: 'Choose Operator ..'});

  $('#ibranch').on('select2:select', function (e) {
    var bra = e.params.data;

    $('#iregion').val(bra.region).trigger('change');

    $('#cboregion').val(bra.region);

  });

  $('#ibranch').select2({
      placeholder: 'Select an option',
      minimumInputLength: 2,
      //tags: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('taxbranch/taxbranch/branch_select')?>',
          dataType: 'json',
          type: "GET",
          data: function (term) {
              return {
                  term: term
                  //region: $("#iregion").val()
              };
          },
          processResults: function (data) {
              return {
                  results: $.map(data.items, function (item) {

                        //console.log(data.items);
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


  $("#itenant").on('keydown paste', function(e){
      e.preventDefault();
  });

  $("#ibrand").on('keydown paste', function(e){
    e.preventDefault();
  });

	var arrid= [];
	//lfrtip =default
  var oTable=popgrid("<?php echo site_url('taxbranch/taxbranch/controler_griddialog')?>","uLoader","trp", 10);

  var rTable=popgrid("<?php echo site_url('taxbranch/taxbranch/controler_gridpop')?>","popLoader","trp", 10);



  $('#btnload').click( function() {
      var searchName = $("#sUnitName").val();
      var searchID  = $("#sID").val();
      var searchBranch = $("#ibranch").val();
      var searchRegion  = $("#iregion").val();

      oTable.search(searchName).draw();
      oTable.search(searchID).draw();
      oTable.search(searchBranch).draw();
  });


	$("#tabdata").trigger('click');

  $('#btTemplate').click(function() {

    var searchID  = $("#iutype").val();
    //alert(searchID);
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
            var searchBranch = $("#ibranch").val();
            var searchRegion  = $("#iregion").val();

            //console.log(searchBranch);
            //var searchRegion  = $("#iregion").val();
            oTable.search(searchRegion).draw();
            oTable.search(searchBranch).draw();
            oTable.rows('.selected').deselect();
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

       for (var i=0; i < oData.length; i++){

          var rid=oData[i][0];
          var runit=oData[i][1];
          var rsize=oData[i][2];
          var nlantai=oData[i][3];
          var rlantai=oData[i][4];
          var nshopename = '';
          //var nsdate = '';
          //var nedate = '';
          var ndescr = '';

          var max=GetDgvLineMaxNum('unittab',0)
          linenum= Number(max) + 10;
          var t="tcharge"+linenum;

          $('#unittab tbody').append('<tr>'+
            '<td>' + linenum + '<input type="hidden" name="uline[]" value="'+ linenum +'"/></td>'+
            '<td>'+ rid +'<input type="hidden" name="uunit[]" value="'+ rid +'"/></td>'+
            '<td>'+ runit +'</td>'+
            '<td>'+ rsize +'<input type="hidden" name="usize[]" value="'+ rsize +'"/></td>'+
            '<td>'+ nlantai +'<input type="hidden" name="ulantai[]" value="'+ rlantai +'"/></td>'+
            '<td><select data-placeholder = "Select an option" id= "tatype" name= "ushipping[]" required class="dropshope form-control input-sm" style="width: 100%;">'+
                '</select></td>'+

            '<td><input type="text" id= "nsdate" name="usdate[]" value="" class="tgl form-control input-sm"/></td>'+
            '<td><input type="text" id= "nedate" name="uedate[]" value="" class="tgl form-control input-sm"/></td>'+
            '<td><input type="text" id= "nsize2" name="usize2[]" value="'+ rsize +'" class="deci form-control input-sm"/></td>'+
            '<td><input type="text" id= "ndescr" name="udescr[]" value="" class="pops form-control input-sm"/></td>'+
            '<td><a id= "uDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</a></td></tr>');

          listunit.push({id: rid, text: runit});

          //console.log(ci);

          $('.tgl').datepicker();
          //$('#nedate').datepicker();
          $('.deci').number( true, 2 );
          $('.dropshope').select2(shippingname);

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

      $('.dropshope').empty();

      function getshipping (){
                  var ajax = $.getJSON("<?php echo site_url('taxbranch/taxbranch/shipping_select'); ?>","id="+$('#htenant').val(), function(data){});
                   return ajax;
      }

      getshipping().done(function(results){


            //console.log('tes3');
            var rekanan_id = $('#itenant').val();

            ShippingType = results.data;


      });


  });

  $('#addschema').click(function () {

      var linenum=0;
      var scData = scTable.rows('.selected').data();

      for (var i=0; i < scData.length ;i++){

          var _id     = scData[i][0];
          var _dp     = scData[i][2];

          //console.log(scData);

          $('#skl_id').val(_id);

          $('#taxbranch_descr').val('DP'+_dp+'% dibayarkan dalam 2 kali angsuran setelah Surat Kesepakatan (Letter of Intent) telah ditandatangani\n' +
          'Installment 80% dibayarkan dalam 30 kali angsuran  bulanan di muka');

          addRow("dp");
          $('#dp').append(new Option('Down Payment', '2000', false, false)).trigger('change');
          $('#per_dp').val(_dp);
          $('#chk_dp').prop('checked', true);
          $('#chg_dp').prop('readonly', true);
          $('#per_dp').prop('readonly', false);
          $('#cper_dp').val('1');
          addRow("pl");
          $('#pl').append(new Option('Promo Levy', '6000', false, false)).trigger('change');
          $('#des_pl').val('/ m2 / Bulan tidak termasuk PPn');
          addRow("ins");
          $('#ins').append(new Option('Installment', '4000', false, false)).trigger('change');
          $('#des_ins').val('/ m2 / Bulan tidak termasuk PPn');
          addRow("sc");
          $('#sc').append(new Option('Service Charge', '5000', false, false)).trigger('change');
          $('#des_sc').val('/ m2 / Bulan tidak termasuk PPn \n' +
            '(Dibayarkan setiap 3 ( tiga ) bulan dimuka  dan pembayaran biaya pelayanan pertama kali harus dimulai sejak tanggal mulai sewa. '+
            'Biaya Pelayanan akan ditinjau ulang setiap periode.)');
          addRow("sdr");
          $('#sdr').append(new Option('Security Deposit R', '7000', false, false)).trigger('change');
          $('#des_sdr').val('bulan Harga Sewa dan Service Charge \n' +
            'Jaminan sewa  tersebut  dapat  dikembalikan  secara utuh,  tanpa '+
            'bunga  pada  masa   berakhirnya  masa  sewa  mengacu  kepada '+
            'dipatuhinya  segala ketentuan dan syarat-syarat PERJANJIAN dari '+
            'Penyewa,  tetapi  tidak  akan dikembalikan bila terjadi pemutusan '+
            'awal yang disebabkan oleh wanprestasi pembayaran PENYEWA.');
          addRow("sdc");
          $('#sdc').append(new Option('Security Deposit SC', '7500', false, false)).trigger('change');
          $('#des_sdc').val('bulan Harga Sewa dan Service Charge \n' +
            'Jaminan sewa  tersebut  dapat  dikembalikan  secara utuh,  tanpa '+
            'bunga  pada  masa   berakhirnya  masa  sewa  mengacu  kepada '+
            'dipatuhinya  segala ketentuan dan syarat-syarat PERJANJIAN dari '+
            'Penyewa,  tetapi  tidak  akan dikembalikan bila terjadi pemutusan '+
            'awal yang disebabkan oleh wanprestasi pembayaran PENYEWA.');
          addRow("el");
          $('#el').append(new Option('Electricity', '9100', false, false)).trigger('change');
          $('#des_el').val('Berdasarkan pemakaian bulanan ditambah administrasi 10% dan Ppn 10%');
          addRow("wa");
          $('#wa').append(new Option('Water', '9400', false, false)).trigger('change');
          $('#des_wa').val('Berdasarkan pemakaian bulanan ditambah administrasi 10% dan Ppn 10%');
          addRow("ga");
          $('#ga').append(new Option('Gas', '9300', false, false)).trigger('change');
          $('#des_ga').val('Berdasarkan pemakaian bulanan ditambah administrasi 10% dan Ppn 10%');
          addRow("tel");
          $('#tel').append(new Option('Telephone', '9200', false, false)).trigger('change');
          $('#des_tel').val('Pihak Pemilik akan menyediakan minimal 1 (satu) line telepon untuk setiap ruang usaha '+
            'dengan biaya deposit sebesar Rp. 3.500.000,- (Tiga Juta Lima Ratus Ribu Rupiah) (Refundable) per line '+
            'dengan biaya penyambungan sebesar Rp. 1.000.000,- (Satu Juta Rupiah)');
          addRow("tdep");
          $('#tdep').append(new Option('Telephone Deposit', '8000', false, false)).trigger('change');
          //addRow();

      }

      //console.log($('#dp'));

  });

  $("#taxbranchDetil").on('click','#btnDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }
      $(this).closest('tr').remove();
  });

  $("#taxbranchDetil").on('change', "input[type='checkbox']", function (e) {


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

      var max=GetDgvLineMaxNum('taxbranchDetil',0)
      linenum= Number(max) + 10;

      $('#taxbranchDetil tbody').append('<tr>'+
        '<td>' + linenum + '<input type="hidden" name="tline[]" value="'+ linenum +'" readonly class="nogaris"/></td>'+
        '<td><select data-placeholder = "Select unit" id= "unit_id" name= "tunit[]" required class="dropunit form-control input-sm" style="width: 100%;">'+
            '</select></td>'+
        '<td><select data-placeholder = "Select an option" id= "'+ci+'" name= "tshipping[]" required class="dropshope form-control input-sm" style="width: 100%;">'+
            '</select></td>'+
        '<td><select data-placeholder = "Select an option" id= "'+ci+'" name= "tatype[]" required class="dropadd form-control input-sm" style="width: 100%;">'+
            '</select></td>'+
        '<td><input type="text" id="chg_'+ci+'" name="tcharge[]" value="0" class="deci form-control input-sm" style= "text-align: right;"/></td>'+
        '<td><input type="checkbox" id="chk_'+ci+'"><input type="hidden" id="cper_'+ci+'" name="tper[]" value="0"/></td>'+
        '<td><input type="text" id= "per_'+ci+'" name="tval[]" value="0" class="deci form-control input-sm" style= "text-align: right;" readonly/></td>'+
        '<td><input type="text" name="tint[]" value="0" class="form-control input-sm" style= "text-align: right;" /></td>'+
        '<td><?php echo form_dropdownext('titype[]',$titype,$this->input->post('titype'),'id="titype" class="form-control input-sm" required');?></td>'+
        '<td><input type="text" id= "des_'+ci+'" name="tdescr[]" value="" class="pops form-control input-sm"/></td>'+
        '<td><a id= "btnDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td></tr>');

      $('.deci').number( true, 2 );

      $('.dropunit').select2(unitOptions);
      $('.dropadd').select2(leasetype);
      $('.dropshope').select2(shippingname);
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

  }

  $('.pops').popover({
        trigger: 'manual',
        placement: 'left',
        title: 'Popover Form',
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



  $('#btncreate').click( function() {
  //       alert('tes');
  var sregion = $("#iregion").val();
  var sbranch = $("#ibranch").val();
  //var sbranchname = $("#ibranch").select2("val");


  if (($('#iregion').val() =='')|| ($('#ibranch').val() =='')) {

   //alert("Please select Bussiness Unit and Store and Unit Type");
     alert('Alert! Please Cek Bussiness Unit and Store ');
   //display_modal('Alert!', 'Please select Bussiness Unit');
  }else{

    $('#taxbranchDetil tbody >tr').remove();
            
        $('#taxbranchDetil tbody').append('<tr>'+
          '<td>' + sregion + '<input type="hidden" name="tregionid[]" value="'+ sregion +'" readonly class="nogaris"/></td>'+
          '<td>' + sregion + '<input type="hidden" name="tregionname[]" value="'+ sregion +'" readonly class="nogaris"/></td>'+
          '<td>' + sbranch + '<input type="hidden" name="ttaxbranchid[]" value="'+ sbranch +'" readonly class="nogaris"/></td>'+
          '<td>' + sbranch + '<input type="hidden" name="tbranchname[]" value="'+ sbranch +'" readonly class="nogaris"/></td>'+
          '<td><input type="hidden" name="ttaxbranchdescr[]" value="0" readonly class="nogaris"/></td>'+
          '<td>0<input type="hidden" name="tdisabled[]" value="0" readonly class="nogaris"/></td></tr>');
   

  //    alert(sserial_awal);
  //    });


  //$link.click()
  //alert($link);
  }
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





                    <!-- /.popup-template -->


            <!-- CONTENT -->
            <div class="row">
              <div class="col-md-12">
                <div class="portlet">
                  <div class="portlet-title">
                    <div class="caption" align="right">
                      <div class="actions">
                         
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
                          <a href="<?php echo base_url('index.php/taxbranch/taxbranch/taxbranchlist'); ?>" id='tablist'> LIST </a>
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
                         <form action="<?php echo site_url('taxbranch/taxbranch/taxbranch_edit');?>" method="post" onsubmit="return validateb4submit();">
                            <?php
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>
                    <div class="row">
                      <div class="col-md-12">

                        <div class="col-md-4 form-group form-group-sm row">
                          <div class="col-xs-12">
                            <label>Business Unit</label>
							<input type="text" id = "iregionname" name="iregionname" class="form-control input-sm" value="<?php echo $row->region_name;?>" readonly required autocomplete="off">
                          </div>
                        </div>
						
                        <div class="col-md-4 form-group form-group-sm row">
                          <div class="col-xs-12">
                            <label>Store</label>
                            <select data-placeholder="Select a store" id= "ibranch" name= "ibranch" required disabled>
                              <option value="<?php echo $row->branch_id;?>" selected="selected" ><?php echo $row->branch_name;?></option>
                            </select>
							<input type="hidden" id = "ibranchid" name="ibranchid" value="<?php echo $row->branch_id;?>">
                          </div>
                        </div>

						
                                   <div class="col-md-4 form-group row">
                                   <div class="col-xs-12">
                                      <label class="checkbox-inline"><input type="checkbox" id="isdisabled" name="isdisabled" <?php if ($row->isdisabled == 1) echo 'checked= "checked"';?>>Disable</label>
                                   </div>
                                  </div>                                   


                                  <br>
                                  <br>                                  
                                    <!-- /.col -->
                                <div class="col-xs-12">
                                    <br /><input type="submit" value="SAVE" class="btn btn-sm btn-info" />
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
