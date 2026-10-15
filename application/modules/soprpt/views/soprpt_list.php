<script>


  $(document).ready(function(){
	//var oTable=listgrid("<?php echo site_url('soprpt/soprpt/controler_gridlist')?>","looTable","lfrtip");
  var tenantTable=popgrid("<?php echo site_url('soprpt/soprpt/controler_gridtenant')?>","popLoader","trp", 10);
  //var regionTable=popgrid("<?php echo site_url('soprpt/soprpt/controler_gridregion')?>","regionLoader","trp", 10);
  var branchTable=popgrid("<?php echo site_url('soprpt/soprpt/controler_gridbranch')?>","branchLoader","trp", 10);
  var brandTable=popgrid("<?php echo site_url('soprpt/soprpt/controler_gridbrand')?>","brandLoader","trp", 10);
  var agrtypeTable=popgrid("<?php echo site_url('soprpt/soprpt/controler_gridagrtype')?>","agrtypeLoader","trp", 10);

    //new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } );
  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  		$("#tablist").trigger('click');
  		});

$('.searching').select2();

$('#branchdlg_select').select2();
$('#branchdlg_select').select2({
 allowClear: true,
 dropdownCssClass: 'custom-dropdown-1' ,
 placeholder: 'Select an option',
    minimumInputLength: 2,
    //tags: true,
    minimumResultsForSearch: 10,
    tokenSeparators: [',', ' '],
    ajax: {
        url: '<?php echo site_url('soprpt/branch_select_dialog')?>',
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
  console.log(valuenya);
  region_id_s =e.params.data.id;

  var data = {
    text: valuenya.region_name,
    id: valuenya.region
  };
  //console.log(e.params.data.id);
  var newOption = new Option(data.text, data.id, true, true);
  $('#regionDlg_select').select2({data: [{id: '', text: ''}]});
  $('#regionDlg_select').empty();
  $('#regionDlg_select').append(newOption).trigger('change');
  $('#region_hidden').val(e.params.data.region);
  $('#hregion').val(e.params.data.region);
  $('#iregion').val(e.params.data.region_name);
  $('#region_Namehidden').val(e.params.data.region_name);
  $('#branch_name').val(e.params.data.text);
  $('#branch_id_hidden').val(e.params.data.id);
  $('#hbranch').val(e.params.data.id);
  $('#ibranch').val(e.params.data.text);
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

  $('#btagrtype').click(function() {
    agrtypeTable.rows('.selected').deselect();
    $("#agrtypedialog").modal("show");
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

  $('#addagrtype').click(function () {
      var linenum=0;
       var rData = agrtypeTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid     = rData[i][0];
          var tname   = rData[i][1];

          $('#hagrtype').val(tid);
          $('#iagrtype').val(tname);
      }
  });

  $('#btnrek').click(function() {
      var searchTenant  = $("#searchTenant").val();
	  var searchBranch  = $("#hbranch").val();

	  tenantTable.search('');
      tenantTable.column(0).search(searchTenant);
      tenantTable.column(1).search(searchBranch);
      tenantTable.draw();
      
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

    $('#btnagrtype').click(function() {
        var search  = $("#searchagrtype").val();
      agrtypeTable.search(search).draw();
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
      $('#cagrtype').change(function(){
        if($(this).is(':checked')){
            $('#btagrtype').prop('disabled',false);
        } else {
            $('#btagrtype').prop('disabled',true);
            $('#hagrtype').val('');
            $('#iagrtype').val('');
        }
      })
      $('#cenddate').change(function(){
        if($(this).is(':checked')){

        } else {
            $('#ienddate').val('');
        }
      })
      $('#cperiodeend').change(function(){
        if($(this).is(':checked')){

        } else {
            $('#iperiodeend').val('');
        }
      })
      $('#cproforma').change(function(){
        if($(this).is(':checked')){

        } else {
            $('#iproforma').val('');
        }
      })

      $('#iregion2').select2({placeholder: 'Select a business unit'});

        $('#ibranch2').on('select2:select', function (e) {
          var bra = e.params.data;

          $('#iregion').val(bra.region).trigger('change');

          $('#cboregion').val(bra.region);

        });

        $('#ibranch2').select2({
            placeholder: 'Select an option',
            minimumInputLength: 2,
            //tags: true,
            minimumResultsForSearch: 10,
            tokenSeparators: [',', ' '],
            ajax: {
                url: '<?php echo site_url('soprpt/branch_select')?>',
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

      $('#btnprint3').click( function() {
        //alert("Please select Bussiness Unit and Store and Unit Type");
        if (($('#hregion').val() =='') || ($('#hregion').val() ==null)) {


         display_modal('Alert!', 'Please select Bussiness Unit');
        }
        });
      $('#btnprint2').click( function() {
//        alert('tes');
      if (($('#hregion').val() =='') || ($('#hregion').val() ==null)) {

       //alert("Please select Bussiness Unit and Store and Unit Type");
       display_modal('Alert!', 'Please select Bussiness Unit');
      }else{
        var url = "<?= site_url('soprpt/soprpt/soprptprintpdf');?>";
        var sregion_id = $("#hregion").val();
        var sregion_name = $("#hregion").val();
        var sbranch_id  = $("#hbranch").val();
        var sbranch_name  = $("#hbranch").val();
        var srekanan_id = $("#htenant").val();
        var srekanan_name = $("#htenant").val();
        var srekananshipping_line  = $("#hbrand").val();
        var sreport_type = $('#soprpttype').val();


        $.post( url, { region_id: sregion_id, region_name: sregion_name, branch_id: sbranch_id, branch_name: sbranch_name,
          rekanan_id: srekanan_id, rekanan_name: srekanan_name, rekananshipping_line: srekananshipping_line, report_type: sreport_type} )
        //.done(function(data){


        window.open(url,'_blank');

          //alert(data.result);
    //    });


			//$link.click()
			//alert($link);
    }
      });

      $.fn.datepicker.defaults.format = "yyyy-mm-dd";
      $.fn.datepicker.defaults.autoclose = true;


    $('#itenant2').select2({
        placeholder: 'Select an option',
        minimumInputLength: 2,
        //tags: true,
        minimumResultsForSearch: 10,
        tokenSeparators: [',', ' '],
        ajax: {
            url: '<?php echo site_url('soprpt/soprpt/tenant_select')?>',
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

                            text: item.rekanan_name,
                            id: item.rekanan_id
                        }
                    })
                };
            }
        }
    });

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

  $('.dropshope').select2(shippingname);

  });



</script>

<script src="calender.js"></script>

<style>
table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

.DTFC_LeftBodyLiner {

overflow-x: hidden;

}

.DTFC_RightBodyLiner {

overflow-x: hidden;

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
             <input  type="text" id="searchRegion" class="form-control input-sm" placeholder="Search Region" name ="" >
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
             <table class="table table-striped table-bordered table-hover compact nowrap" id='brandLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
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

 <!-- /.popup-Shipping -->
 <div class="modal fade" id="agrtypedialog" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         </button>
         <h4 class="modal-title">
           Data Agreement Type
         </h4>
       </div>
       <div class="modal-body">
         <form action="#" id="form" class="form-horizontal">
           <div class="row">
           <div class="col-md-8">
              <label>Search Agreement Type</label>
             <input  type="text" id="searchagrtype" class="form-control input-sm" placeholder="Search agrtype" >
           </div>
           <div class="col-md-4" align="right">
             <br>
             <input type="button" id="btnagrtype" value = "LOAD" class="btn btn-sm btn-info"/>
           </div>
         </div>

        <div class="portlet-body">
         <div class="table-container">
           <div class="table-scrollable">
             <table class="table table-striped table-bordered table-hover compact nowrap" id='agrtypeLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
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
         <button type="button" class="btn green" data-dismiss="modal" id="addagrtype">
           Add Selected Data
         </button>
       </div>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>

            <div class="row">
              <div class="col-md-13">
                <div class="portlet">
                  <div class="portlet-title">
                    <div class="caption" >

                      <div class="actions">
						<?php echo form_open(base_url('index.php/soprpt/soprpt/soprptprintpdf'),'role="form" class="form-horizontal" id="form_master_semesterbranch" parsley-validate target="_blank"'); ?>

            <div class="btn-group">

              			
                <div class="col-md-4">
                  <label>Start Date</label>
                  <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                      <input type="text" class="form-control input-sm pull-right" id="istartdate" name="istartdate" value = "<?php echo date("Y-m-d");?>" readonly>
                  </div>
                </div>
				
                <div class="col-md-4">
                  <label>End Date</label>
                  <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                      <input type="text" class="form-control input-sm pull-right" id="ienddate" name="ienddate" value = "<?php echo date("Y-m-d");?>" readonly>
                  </div>
                </div>
				
              <div class="col-md-4">

                <label>Store</label>
								 <select id="branchdlg_select" class="form-control" style="width: 100%;" name="branch_id_s"> </select>
                 <input type="hidden" id = "hbranch" name="hbranch">
                 <input type="hidden" id = "ibranch" name="ibranch">
              </div>
							 <div class="col-md-4">

                  <label>Business Unit</label>
                  <?php echo form_dropdown('cboregionDlg',$region,'',' id="regionDlg_select" style="width: 100%;" class="iregionsearch form-control " required disabled'); ?>
                          <input type="hidden" id = "hregion" name="hregion">
                          <input type="hidden" id = "iregion" name="iregion">
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

                <div class="col-md-4">
                    <label class="checkbox-inline"><input type="checkbox" id="cbrand">Brand</label>
                    <div class="input-group input-group-sm">
                      <input type="text" id = "ibrand" name="ibrand" class="form-control input-sm" value="" required autocomplete="off" readonly>
                      <span class="input-group-btn">
                        <button id ="btbrand" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
                      </span>
                    <input type="hidden" id = "hbrand" name="hbrand" value="">
                    </div>
                </div>


              <div class="col-md-4">
                <label>Report Name</label>
							  <select class="form-control input-sm" name="rpttype" id="rpttype" data-placeholder="Pilih Data" >
									 <option value="1">
										Detail
									  </option>
									  <option value="2">
										Summary SOP by Property by Tenant
									  </option>
							  </select>
			</div>
                <div class="col-md-12" align="right">
                  <br>

                   <button class="btn blue btn-sm " id="btnprint" name="button" type="submit" value="PRIVIEW" style="height:35px;">
              			PRIVIEW
              		  </button>
                    <button class="btn blue btn-sm " id="btnprint" name="button" type="submit" value="EXCEL" style="height:35px;">
               			EXCEL
               		  </button>
                </div>

						</div>

						<?php echo form_close(); ?>

                      </div>
                    </div>
                    <div class="tools">
                      <a href="javascript:;" class="collapse"> </a>
                      <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                    </div>
                  </div>

                </div>
              </div>
              <!-- END OF CONTENT -->
