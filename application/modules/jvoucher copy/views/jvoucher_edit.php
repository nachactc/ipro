<?php $chid=get_setting("channel_id");?>
<script>

  function caluptotal()
  {
    var jumlahIdr = 0;
    var nilaiMin = 0;
    var nilaiPlus = 0
    var nilaiSelisih = 0;
    var table = $("#jDetil tbody");
    
    table.find('tr').each(function () {

      var colIdr = $(this).find("td.clsidr").text();
	    colIdr = colIdr.replace(/,/g, "");
      var jurnalIdr = parseFloat(colIdr)||0;
      
      
      if (jurnalIdr < 0){
        nilaiMin += jurnalIdr;
      } else {
        nilaiPlus += jurnalIdr;
      }
      jumlahIdr += jurnalIdr;

    });

    jumlahIdr = jumlahIdr.toFixed(2);
    
    $("#tselisih").val(jumlahIdr);
    $("#jumlah_idr").val(nilaiPlus);
  }

function app(text)
    {
         var TheTextBox = document.getElementById("nilcounter");
		 TheTextBox.value='';
         TheTextBox.value = TheTextBox.value + text;
		
    }
	function getrekid(nil)
    {
         var Txtrekid = document.getElementById("trek_id"+nil).value; 
		 //alert(Txtrekid);
		 document.getElementById("temprekid").value=Txtrekid;
		 
    }
function validateb4submit(){
  var max = GetDgvLineMaxNum('jDetil',0);
  if (max < 1 ){    
    display_modal('Alert!', 'Please, Add Term & Condition !');
    return false;
  }
}

$(document).on("focusin", "#itenant", function() {
   $(this).prop('readonly', true);  
});

$(document).on("focusout", "#itenant", function() {
   $(this).prop('readonly', false); 
});

$(document).ready(function(){  
  
  $.fn.modal.Constructor.prototype.enforceFocus = $.noop;

  caluptotal();

  $('#myform').on('submit', function() {

		//var ttotamount=$("#jumlah_idr").val();		
		var period = $('#iperiod').val();
		var bookdateInput = $('#jurnal_bookdate').val().split('-');
		var periodeInputCheck = bookdateInput[0].substring(4,2)+bookdateInput[1];
				 
		if("'"+period+"'" !== "'"+periodeInputCheck+"'")
		{
			alert('Periode Berbeda Dengan Bookdate!');
			return false; 
		} 
		
		if($('#tselisih').val() !== '0'){
			alert('Nilai Jurnal belum balance');
			return false;
		}
		

		if($('#book_date').val() == ''){
			alert('Book Date Belum Di masukkan');
			return false;
		}


	});


  $('#iregion').select2({placeholder: 'Select a business unit'});
  $('#iutype').select2({placeholder: 'Choose unit ..'});
  $('#istruk').select2({placeholder: 'Choose strukturunit ..'});
  $('#iperiod').select2();
  //$('#iperiod').prop('disabled', true);
  $('.account').select2();
  $('.region-sel').select2();
  $('.branch-sel').select2();
  $('.struktur-sel').select2();

  $('#pAccount').select2({
    dropdownCssClass: 'dropdown-store'
  });

  $('#pBranch').select2({
    dropdownCssClass: 'dropdown-store'
  });

  $('#pTenant').select2({
    dropdownCssClass: 'dropdown-store'
  });

  $('#pStruktur').select2({
    dropdownCssClass: 'dropdown-store'
  });
  

  $('#pAccount').on('select2:open', function(e){
    $('.dropdown-store').parent().css('z-index', 99999);
  });

  $('#pBranch').on('select2:open', function(e){
    $('.dropdown-store').parent().css('z-index', 99999);
  });

  $('#pTenant').on('select2:open', function(e){
    $('.dropdown-store').parent().css('z-index', 99999);
  });

  $('#pStruktur').on('select2:open', function(e){
    $('.dropdown-store').parent().css('z-index', 99999);
  });

  $('#ibranch').on('select2:select', function (e) {
    var bra = e.params.data;    

    $('#iregion').val(bra.region).trigger('change');      

    $('#cboregion').val(bra.region);  

    listunit = branchData.filter(function (data) { return data.branch == bra.id });   
        
  });  




  $('#ibranch').select2({
      placeholder: 'Select an option',
      minimumInputLength: 2,
      //tags: true,
      minimumResultsForSearch: 10,
      tokenSeparators: [',', ' '],
      ajax: {
          url: '<?php echo site_url('jvoucher/jvoucher/branch_select')?>',
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
  
      $('.clsbttenant_detil').click(function() {
		if (($('#ibranch option:selected').length == 0) || ($('#ibranch').val() =='')) {     
			display_modal('Alert!', 'Please select Bussiness Unit or Store.');
		}else{

			var searchBranch = $('#ibranch').val();    
			det_rTable.search(searchBranch).draw();
			det_rTable.rows('.selected').deselect();
			$("#tedialog_detil").modal("show");
		}
	});
	
	$('.clsbtbrand_detil').click(function() {
		if (($('#ibranch option:selected').length == 0) || ($('#ibranch').val() =='')) {     
			display_modal('Alert!', 'Please select Bussiness Unit or Store.');
		}else{
			var searchBranch = $('#ibranch').val();   
			var vrekanan_id	= $('#temprekid').val(); 	
			brand_rTable.search(searchBranch).draw();			
			brand_rTable.search(vrekanan_id).draw();
			brand_rTable.rows('.selected').deselect();
			$("#tedialog_shippingdetil").modal("show");
			
		}
	});	

  $("#ibrand").on('keydown paste', function(e){
    e.preventDefault();
  });

  $("#idebtor").on('keydown paste', function(e){
    e.preventDefault();
  });

  var arrid= [];
  //lfrtip =default  
  var tenantParams = { 
    line: 0,
    branch_id: $('#ibranch'),
    criteria: $('#searchTenant')
  }
  var rTable = selectionGrid("<?php echo site_url('jvoucher/jvoucher/controler_gridpop')?>","popLoader","trp", 10, [], tenantParams);  
  var tTable = $('#detailLoader').DataTable();
  
  var det_rTable = selectionGrid("<?php echo site_url('jvoucher/jvoucher/controler_gridpop')?>","poptenantdetil","trp", 10, [], { line: 0 });  
  var brand_rTable = selectionGrid("<?php echo site_url('jvoucher/jvoucher/controler_gridpop')?>","popshippingdetil","trp", 10, [], { line: 0 });  

  $("#tabedit").trigger('click');

  $('#btTemplate').click(function() {
    if (($('#iregion option:selected').length == 0) || ($('#ibranch').val() =='') || ($('#iutype').val() ==null)) { 

     //alert("Please select Bussiness Unit and Store and Unit Type");
     display_modal('Alert!', 'Please select Bussiness Unit and Store and Unit Type.');
    }else{

    var searchID  = $("#iutype").val();    

    scTable.search(searchID).draw();
    
    scTable.rows('.selected').deselect();
    $("#tempdialog").modal("show");
    }

  });


  $('#bttenant').click(function() {

    if (($('#ibranch option:selected').length == 0) || ($('#ibranch').val() =='')) { 
      
      display_modal('Alert!', 'Please select Bussiness Unit or Store.');
    }else{

      var searchBranch = $('#ibranch').val();    

      rTable.search(searchBranch).draw();

      rTable.rows('.selected').deselect();
      $("#tedialog").modal("show");
      rTable.draw();
    }
  });


  $("#jDetil").on('click','#bTenant',function(){          
     
      jLine = $(this).closest('tr').find('td').eq(0).text();      

      //$('#detailLoader').DataTable().destroy();
      tTable.destroy();

      tTable=selectionGrid("<?php echo site_url('jvoucher/jvoucher/controler_gridtenant')?>","detailLoader","trp", 10, [], jLine);  
      
      $("#dedialog").modal("show");    

  });

  $('#btnrek').click(function() {

    rTable.draw();
  });


    $('#btdetil').click(function() {

      let jurnal_id = $('#jurnal_id').val();
      let jurnaldetil_line = 0;
      let max = GetDgvLineMaxNum('jDetil', 1);      
      let trid;

      jurnaldetil_line = Number(max) + 10;    
      trid = `jDetil-row-${jurnaldetil_line}`;

      var form = document.getElementById("frmJurnalDetil");
      // Menggunakan iterasi untuk menonaktifkan semua elemen dalam formulir
      /*
      for (var i = 0; i < form.elements.length; i++) {
        form.elements[i].disabled = true;
      }
      */


      if (($('#iregion option:selected').length == 0) || ($('#ibranch').val() =='')) { 
        
        display_modal('Alert!', 'Please select Bussiness Unit or Store.');
      } else {

        //let form = document.getElementById("frmJurnalDetil");
        let formId = form.setAttribute("formid", trid);

        $("#dlgDetail").modal("show"); 
        
        //$('#frmJurnalDetil')[0].reset();
        $('#pState').val('NEW');
        $('#pID').val(jurnal_id);
        $('#pLine').val(jurnaldetil_line);
        $('#pAccount').val(['0']).trigger('change'); 
        //addRow();
      }

    });

    $('#addRow').on('click', async function() {
      
      var form = document.getElementById("frmJurnalDetil");
      var formId = form.getAttribute("formid");


      let jurnal_id = $('#pID').val();
      let jurnaldetil_line = $('#pLine').val();
      let acc_id = $('#pAccount').val();
      let jurnaldetil_descr = $('#pDescr').val();
      let jurnaldetil_idr = $('#pJournalIDR').val();
      let region_id = $('#iregion').val();
      let branch_id = $('#pBranch').val();
      let rekanan_id = $('#pTenant').val();
      let strukturunit_id = $('#pStruktur').val();
      let __state = $('#pState').val();

      let param = {
        __state: __state,
        jurnal_id: jurnal_id,
        jurnaldetil_line: jurnaldetil_line,
        acc_id: acc_id,
        jurnaldetil_descr: jurnaldetil_descr,
        jurnaldetil_idr: jurnaldetil_idr,
        region_id: region_id,
        branch_id: branch_id,
        rekanan_id: rekanan_id,
        strukturunit_id: strukturunit_id,
        rekananshipping_line: 0,
      }

      $.blockUI({message: 'Saving Data, Please Wait...'});
      
      try {

        let result = await ajaxRequest('<?php echo site_url("jvoucher/saveJournalDetil");?>', param);

        if (!result.status){

          alert(result.message);
        } else {

          data = result.data;
          if (__state === 'NEW') {
            addRow2(data, formId);
          } else {
            updateRow(data, formId);
          }
        }
        
      } catch (error) {
        console.error(error);
      } finally {
        $.unblockUI();
      }

    });


  $('#tabedit').click(function() {

    display_modal('Alert!', 'Please, select data from list.');
  });  

 $('#addtenant_detil').click(function () {

      var linenum=0;
       var rData = det_rTable.rows('.selected').data();
	   var vnilcounter=$('#nilcounter').val();
	   
       for (var i=0; i < rData.length ;i++){

          var tid       = rData[i][1];
          var tname     = rData[i][2];
          var tline     = rData[i][3];
          var tbrand    = rData[i][4];
          var tdebtor   = rData[i][5];          

         // $('#htenant').val(tid);
          $('#trek_id'+vnilcounter).val(tid);
		  $('#trek_name'+vnilcounter).val(tname);
          //$('#hbrand').val(tline);
          //$('#ibrand').val(tbrand);
          //$('#idebtor').val(tdebtor);          
      }

  }); 
  
  $('#addbrand_detil').click(function () {

      var linenum=0;
       var rData = brand_rTable.rows('.selected').data();
	   var vnilcounter=$('#nilcounter').val();
	   
       for (var i=0; i < rData.length ;i++){

          var tid       = rData[i][1];
          var tname     = rData[i][2];
          var tline     = rData[i][3];
          var tbrand    = rData[i][4];
          var tdebtor   = rData[i][5];          

         // $('#htenant').val(tid);
          $('#tshipping_line'+vnilcounter).val(tline);
		    $('#tshipping_name'+vnilcounter).val(tbrand );
          //$('#hbrand').val(tline);
          //$('#ibrand').val(tbrand);
          //$('#idebtor').val(tdebtor);          
      }

  }); 
  
  $('#addtenant').click(function () {

      var linenum=0;
       var rData = rTable.rows('.selected').data();

       for (var i=0; i < rData.length ;i++){

          var tid       = rData[i][1];
          var tname     = rData[i][2];
          var tline     = rData[i][3];
          var tbrand    = rData[i][4];
          var tdebtor   = rData[i][5];          

          $('#htenant').val(tid);
          $('#itenant').val(tname);
          $('#hbrand').val(tline);
          $('#ibrand').val(tbrand);
          $('#idebtor').val(tdebtor);          
      }

  }); 

  $('#chooseTenant').click( function() {

      tData = tTable.rows('.selected').data();          

      tenantId    = tData[0][1];
      tenantName  = tData[0][2];      
      brandId     = tData[0][3];
      brandName   = tData[0][4];      
      tLine       = tData[0][6];
      
      var uRows = $('#jDetil tbody >tr');
      var uColumns;

      for (var i = 0; i < uRows.length; i++) {  

          uLine = $(uRows[i]).find('td').eq(0).text();

          if (uLine === tLine) {

            $(uRows[i]).find('input[type="text"]').eq(2).val(tenantName);
          }
                        
      }
  });  

 $("#jDetil").on('click','#rDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }
      $(this).closest('tr').remove();
	   caluptotal();
  });

  

  $("#jDetil").on('click','#rowDelete',function(){
    if (confirm("Are you sure to delete this row ?") == false) {
              return false;
          }
      $(this).closest('tr').remove();
	   caluptotal();
  });

  $("#jDetil").on('click','#rowEdit', async function(){
    
    var jurnalId = $('#jurnal_id').val();
    var jurnalLine = $(this).closest('tr').find("td.clsLine").text();
    //var lineJurnal = $(this).closest('tr').find('input[type="hidden"]').val() 
    let trid = $(this).closest('tr').attr('id');

    var param = {
      jurnal_id: jurnalId,
      jurnaldetil_line: jurnalLine
    }

    $.blockUI({message: 'Opening Data, Please Wait...'});
      
    try {


      let result = await ajaxRequest('<?php echo site_url("jvoucher/openJournalDetil");?>', param);

      if (!result.status){
        alert(result.message);

        $.unblockUI();
      } else {

        data = result.data;
        
        $('#pState').val('MODIFY');
        $('#pID').val(data.jurnal_id);
        $('#pLine').val(data.jurnaldetil_line);
        $('#pAccount').val(data.acc_id).trigger('change');
        $('#pDescr').val(data.jurnaldetil_descr);
        $('#pJournalIDR').val(data.jurnaldetil_idr);
        $('#pBranch').val(data.branch_id).trigger('change');
        //$('#pTenant').val(data.rekanan_id).trigger('change');
        $('#pStruktur').val(data.strukturunit_id).trigger('change');

        var form = document.getElementById('frmJurnalDetil');
        form.setAttribute("formid", trid);

        $("#dlgDetail").modal("show");
        $.unblockUI();
      }
      
    } catch (error) {        
      $.unblockUI();
      console.error(error);
    } 

	  //caluptotal();
  });



  function addRow2(data, trid) {

    $('#jDetil tbody').append(`
      <tr id="${trid}">      
        <td>      
          <div style="display:flex;">
            <a id= "rowEdit" class="btn btn-sm btn-primary"><i class="fa fa-edit fa-lg"></i></a>
            <a id= "rowDelete" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-lg"></i></a>
          </div>
        </td>
        <td class="clsLine">${data.jurnaldetil_line}</td>
        <td>${data.acc_name}</td>
        <td>${data.jurnaldetil_descr}</td>
        <td style="text-align: right;">${data.jurnaldetil_idr}</td>
        <td>${data.branch_id}</td>
        <td>${data.rekanan_id}</td>
        <td>${data.strukturunit_id}</td>
        <td>${data.ref_id}</td>
        <td>${data.ref_line}</td>
      </tr>
    `);
  };


  function updateRow(data, trid) {
    var table = document.getElementById('jDetil'); 
		var tr = document.getElementById(trid)
    var cells = tr.querySelectorAll('td');

    cells[2].innerHTML = data.acc_name;
    cells[3].innerHTML = data.jurnaldetil_descr;
    cells[4].innerHTML = data.jurnaldetil_idr;
  }

    
  function display_modal(title, message){
     $("#mdlinfo").modal("show");
     $("#mdltitle").show().html(title);
     $("#mdlbody").show().html(message);
  }  

  $('.pops').popover({   
        trigger: 'manual',    
        placement: 'left',
        title: 'Descr',
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

  $('.deci').number( true, 2 );
  $('.bulet').number( true, 0 );

  $('.deci').on('input', function (e) {
    $(this).css("color", ""); 
    $(this).toggleClass('redForeground', $(this).val() < 0);    
  });

});


  $.fn.datepicker.defaults.format = "yyyy-mm-dd";
  $.fn.datepicker.defaults.autoclose = true;

  function selectionGrid(vlink, namatable, optsearch, pLength=10, aCenter=[], params){
      
    var dt = $('#'+namatable).DataTable({ 

      "pageLength": pLength,
      "processing": true, 
      "serverSide": true, 
      "order": [],
      "searching" : true,
      "ajax": {
        "url": vlink,
        "type": "POST",
        "data": function(o){
          
          let criteria = '';
          let branch_id = '';

          if (typeof params.criteria == 'object') {
            criteria = params.criteria.val();
          }

          if (typeof params.branch_id == 'object') {
            branch_id = params.branch_id.val();
          }

          o.params = {
            line_no: params.line,
            search: criteria,
            branch_id: branch_id
          }
        }  
      },   

      "columnDefs": [
        { "targets": [ -1 ], "orderable": false },
        { "targets": aCenter, "className": "text-center" },
        { "orderable": false, "className": 'select-checkbox', "targets": 0 }
      ],

      select: {
          style:    'os',
          selector: 'td:first-child'
      },  

      dom:optsearch

    });
    
    return dt;
  }

  

async function ajaxRequest(url, param) {
    let result;

    try {
          result = await $.ajax({
              url: url,
              type: 'POST',
              data: param,
              dataType: 'json'
          });
          return result;

    } catch (error) {
      console.error(error);
    }
}  


$(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );

</script>

<style>

table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

#jDetil th, #jDetil td, #jDetil label {
    font-size: 9pt;
    /*vertical-align: top;*/
    padding-top: 1.1rem;
    padding-bottom: 1rem;
}

#jDetil th {
  top: 0;
  position: sticky;
}

#DgvRef th, #DgvRef td, #DgvRef label {

    font-size: 9pt;
    white-space: nowrap;    
}

#DgvRes th, #DgvRes td, #DgvRes label {
    font-size: 9pt;
    white-space: nowrap;    
}

#loanTab th, #loanTab td, #loanTab label {
    font-size: 9pt;
    white-space: nowrap;    
}

.redForeground {
    color: red;
}

label {
  font-size: 9pt;
  font-weight: bold;
}

.select2-container {
  min-width:120px;
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
                  <button id="btnrek" type="button" class="btn btn-sm btn-primary" style="margin-right: 5px;" >
                    <i class="fa fa-history"></i> LOAD
                  </button>
                </div>
              </div>
               <div class="portlet-body">
                <div class="table-container">
                  <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover compact nowrap" id='popLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                      <thead>
                       <tr>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Brand</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Debt No.</th>
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

        <!-- /.popup-tenant di grid detil -->
        <div class="modal fade" id="tedialog_detil" tabindex="-1" role="basic" aria-hidden="true">
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
				        <input type="hidden" id="nilcounter" name="nilcounter" />
                <div class="row">
                <div class="col-md-8">
                   <label>Search Tenant || Brand</label>
                  <input  type="text" id="searchTenant_detil" class="form-control input-sm" placeholder="Search Tenant" >
                </div>                           
                <div class="col-md-4" align="right">
                  <br>                              
                  <button id="det_btnrek" type="button" class="btn btn-sm btn-primary" style="margin-right: 5px;" >
                    <i class="fa fa-history"></i> LOAD
                  </button>
                </div>
              </div>
               <div class="portlet-body">
                <div class="table-container">
                  <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover compact nowrap" id='poptenantdetil' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                      <thead>
                       <tr>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Brand</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Debt No.</th>
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
                <button type="button" class="btn green" data-dismiss="modal" id="addtenant_detil">
                  Add Selected Data
                </button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
		
		    <!-- /.popup-tenant shipping di grid detil -->
        <div class="modal fade" id="tedialog_shippingdetil" tabindex="-1" role="basic" aria-hidden="true">
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
                  <input type="hidden" id="nilcounter" name="nilcounter" />
                  <div class="portlet-body">
                    <div class="table-container">
                      <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover compact nowrap" id='popshippingdetil' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                          <thead>
                          <tr>
                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Brand</th>
                            <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Debt No.</th>
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
                <button type="button" class="btn green" data-dismiss="modal" id="addbrand_detil">
                  Add Selected Data
                </button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        <!-- /.popup-tenant-detail -->
        <div class="modal fade" id="dedialog" tabindex="-1" role="basic" aria-hidden="true">
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
                  <button id="btnrek" type="button" class="btn btn-sm btn-primary" style="margin-right: 5px;" >
                    <i class="fa fa-history"></i> LOAD
                  </button>
                </div>
              </div>
               <div class="portlet-body">
                <div class="table-container">
                  <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover compact nowrap" id='detailLoader' style="border:solid 1px #999; #999; border-radius:0px;" width="100%">
                      <thead>
                       <tr>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">ID</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Tenant</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Brand</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Debt No.</th>
                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Line No.</th>
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
                <button type="button" class="btn green" data-dismiss="modal" id="chooseTenant">
                  Add Selected Data
                </button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        

        <!-- /.row-add/ edit-detail -->
        <div class="modal fade" id="dlgDetail" tabindex="-1" role="basic" aria-hidden="true" data-keyboard="false" data-backdrop="static">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                </button>
                <h4 class="modal-title">
                  Detail
                </h4>
              </div>
              
              <div class="portlet-body">

                <form action="#" id="frmJurnalDetil" role="form" class="form-horizontal" style="padding: 0 10px 0 10px;">

                  <div class="form-group form-md-line-input">
                    <label for="pLine" class="col-md-3 control-label">Line</label>
                    <div class = "col-md-6">
                      <input type="text"  id="pLine" name="pLine" class="form-control" readonly>
                      <input type="hidden" id = "pID" name="pID">
                      <input type="hidden" id = "pState" name="pState">
                      <div class="form-control-focus"></div>
                    </div>
                  </div>

                  <div class="form-group form-md-line-input">
                    <label for="pLine" class="col-md-3 control-label">Account</label>
                    <div class = "col-md-9">
                      <?php echo form_dropdownext('pAccount', $account, '', 'id ="pAccount" class="form-control" style="width: 100%;" required');?>                         
                      <div class="form-control-focus"></div>
                    </div> 
                  </div>
                
                  <div class="form-group form-md-line-input">
                    <label for="pDescr" class="col-md-3 control-label">Descr</label> 
                    <div class="col-md-9">                
                      <input  type="text" id="pDescr" name="pDescr" class="form-control" required>
                      <div class="form-control-focus"></div>
                    </div>
                  </div>


                  <div class="form-group form-md-line-input">
                    <label for="pJournalIDR" class="col-md-3 control-label">IDR</label>
                    <div class="col-md-9">
                      <input type="text" id="pJournalIDR" name="pJournalIDR" class="deci form-control" value="0" style="text-align: right;" required>
                      <div class="form-control-focus"></div>
                    </div>
                  </div>
                

                  <div class="form-group form-md-line-input">
                    <label for="pLine" class="col-md-3 control-label">Branch</label>
                    <div class = "col-md-9">
                      <?php echo form_dropdownext('pBranch', $branch, '', 'id ="pBranch" class="form-control" style="width: 100%;" required');?>                       
                      <div class="form-control-focus"></div>
                    </div> 
                  </div>
                

                  <div class="form-group form-md-line-input">
                    <label for="pLine" class="col-md-3 control-label">Tenant</label>
                    <div class = "col-md-9">
                      <?php echo form_dropdownext('pTenant', $branch, '', 'id ="pTenant" class="form-control" style="width: 100%;" ');?>                       
                      <div class="form-control-focus"></div>
                    </div> 
                  </div>


                  <div class="form-group form-md-line-input">
                    <label for="pLine" class="col-md-3 control-label">Strukturunit</label>
                    <div class = "col-md-9">
                      <?php echo form_dropdownext('pStruktur', $struktur, '', 'id ="pStruktur" class="form-control" style="width: 100%;" required');?>                     
                      <div class="form-control-focus"></div>
                    </div> 
                  </div>

                </form>

              </div>


              <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">
                  Cancel
                </button>
                <button type="button" class="btn green" data-dismiss="modal" id="addRow">
                  Simpan
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
                          <a href="<?php echo base_url('index.php/jvoucher/jvoucher/jvoucherlist'); ?>" id='tablist'> LIST </a>
                        </li>
                        <li>                          
                          <a href="<?php echo base_url('index.php/jvoucher/jvoucher/jvoucheradd'); ?>" id='tabdata'> INPUT </a>
                        </li>
                        <li>
                          <a href="#editdata" data-toggle="tab"  id='tabedit'> EDIT </a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane" id="editdata">
                          <div class="portlet-body form">
                          <form action="<?php echo site_url('jvoucher/jvoucher/updatejv');?>" method="post" id="myform">
							
                            <?php
                              if(isset($result)){
                               //print_r($result);
                               foreach($result as $row){ ?>
							                  <input type="hidden" id="hbrand" name="hbrand" value="<?php echo $row->rekananshipping_line;?>">
                                <div class="row">
                                  <div class="col-md-12">
                                    <div style="color:red"> <?php echo validation_errors(); ?> </div>

                                    <div class="col-md-4 form-group row">
                                      <div class="col-xs-12">
                                        <label>ID</label>
                                        <label class="post checkbox-inline pull-right"><input type="checkbox" <?php if ($row->jurnal_isposted == 1) echo 'checked= "checked"';?> disabled><b>Posted</b></label>
                                        <label class="post checkbox-inline pull-right"><input type="checkbox" <?php if ($row->jurnal_isdisabled == 1) echo 'checked= "checked"';?> disabled><b>Disabled</b>&nbsp;</label>
                                        <label class="post checkbox-inline pull-right"><input type="checkbox" <?php if ($row->jurnal_isreversed == 1) echo 'checked= "checked"';?> disabled><b>Reversed</b>&nbsp;</label>
                                        <input  type="text" id="jurnal_id" name="jurnal_id" class="form-control input-sm" value="<?php echo $row->jurnal_id;?>" readonly>
                                      </div>
                                    </div>   

                                    <div class="col-md-4 form-group form-group-sm row">
                                      <div class="col-xs-12">
                                      <label>Business Unit</label>
                                        <?php echo form_dropdown('iregion', $region, $row->region_id, 'id ="iregion" class="form-control" style="width: 100%;" required '); ?>
                                      </div>
                                      <input type="hidden" id = "cboregion" name="cboregion" value="<?php echo $row->region_id; ?>">
                                    </div>          

                                    <div class="col-md-4 form-group row">
                                      <div class="col-xs-12">
                                        <label>Channel</label>
                                          <input type="text" id = "channel_id" name="channel_id" class="form-control input-sm" value="<?php echo $row->channel_id;?>" readonly>
                                      </div>
                                    </div>     


                                    <div class="col-md-4 form-group form-group-sm row">
                                      <div class="col-xs-12">
                                      <label>Periode</label>
                                      <?php 
                                        if ($row->jurnal_isposted == 1)
                                        {
                                          echo form_dropdown('iperiod', $periodall, $row->periode_id, 'id ="iperiod" class="form-control" style="width: 100%;" required'); 
                                        }else{
                                          echo form_dropdown('iperiod', $period, $row->periode_id, 'id ="iperiod" class="form-control" style="width: 100%;" required'); 
                                        }
                                      ?>                                   
                                      </div>
                                    </div>


                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                      <label>Store</label>
                                        <select data-placeholder="Select a Store" id= "ibranch" name= "cbobranch" style="width: 100%;" required>
                                          <option value="<?php echo $row->branch_id;?>" selected="selected" ><?php echo $row->branch_name;?></option>
                                        </select>
                                    </div>
                                  </div>  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Jurnal Type</label>
                                        <input type="text" id = "jurnaltype_id" name="jurnaltype_id" class="form-control input-sm" value="<?php echo $row->jurnaltype_id;?>" readonly>
                                    </div>
                                  </div>  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Book Date</label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="jurnal_bookdate" name="jurnal_bookdate" value = "<?php echo $row->jurnal_bookdate;?>">
                                      </div>
                                    </div>
                                  </div>                                     
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Rekanan/ Tenant</label>
                                      <div class="input-group input-group-sm">
                                        <input type="text" id = "itenant" name="itenant" class="form-control input-sm" value="<?php echo $row->rekanan_name;?>" required autocomplete="off">
                                        <span class="input-group-btn">
                                          <button id ="bttenant" type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                        </span> 
                                      <input type="hidden" id = "htenant" name="htenant" value="<?php echo $row->rekanan_id;?>">
                                      </div>
                                    </div>
                                  </div>  

								                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Brand</label>
                                        <input type="text" id = "ibrand" name="ibrand" class="form-control input-sm" readonly value="<?php echo $row->rekananshipping_name;?>">
                                    </div>
                                  </div>  	                                  
								                  <input type="hidden" id = "ibrand" name="ibrand" class="form-control input-sm" readonly >

                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Jurnal Source</label>
                                        <input type="text" id = "jurnal_source" name="jurnal_source" class="form-control input-sm" value="<?php echo $row->jurnal_source;?>" readonly>
                                    </div>
                                  </div> 

                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Due Date</label>
                                      <div class="input-group date" data-provide="datepicker">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control input-sm pull-right" id="jurnal_duedate" name="jurnal_duedate" value = "<?php echo $row->jurnal_duedate;?>">
                                      </div>
                                    </div>
                                  </div>              

                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                      <label>Strukturunit</label>                                        
                                        <?php echo form_dropdown('istruk', $struktur, $row->strukturunit_id, 'id ="istruk" class="form-control" style="width: 100%;" required '); ?>
                                    </div>
                                  </div>

                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                        <label>Faktur/Invoice</label>                                        
                                        <input type="text" id = "jurnal_faktur" name="jurnal_faktur" class="form-control input-sm" value="<?php echo $row->jurnal_faktur;?>" readonly>
                                    </div>
                                  </div>          

                                  <div class="col-md-11 form-group row">                                    
                                    <div class="col-xs-12">
                                      <label>Description:</label>
                                      <textarea id = "jurnal_descr" name="jurnal_descr" class="form-control input-sm" required rows="2" ><?php echo $row->jurnal_descr;?></textarea>
                                    </div>                                    
                                  </div>

                                  <div class="col-md-12 form-group row"></div>
                                  <div class="col-md-4 form-group row"></div>
                                  <div class="col-md-4 form-group row">
                                    <label class="col-sm-4">Jumlah Foreign</label>        
                                    <div class = "col-sm-8">                                                        
                                        <input type="text" id = "agreement_idr" name="agreement_idr" class="bulet form-control input-sm" style="text-align: right;font-weight: bold;" value="0" readonly>
                                    </div>  
                                  </div>                                
                                  <div class="col-md-4 form-group row form-group-sm">
                                    <label class="col-sm-4">Jumlah</label>        
                                    <div class = "col-sm-8">                    
                                      <div class="input-group input-group-sm">
                                         <input type="text" id = "jumlah_idr" name="jumlah_idr" class="deci form-control input-sm"
                                          style="text-align: right;font-weight: bold;" value="0" readonly>
                                        <span class="input-group-addon" style="font-style: italic;">Rp.</span>
                                      </div>
                                    </div>  
                                  </div> 
                                  <div class="col-md-12 form-group row"></div>
                                  <div class="col-md-4 form-group row"></div>
                                  <div class="col-md-4 form-group row">
                                    <label class="col-sm-4">Selisih Foreign</label>        
                                    <div class = "col-sm-8">                                                        
                                        <input type="text" id = "agreement_idr" name="agreement_idr" class="bulet form-control input-sm" style="text-align: right;font-weight: bold;" value="0" readonly>
                                    </div>  
                                  </div> 
                                  <div class="col-md-4 form-group row form-group-sm">
                                    <label class="col-sm-4">Selisih</label>        
                                    <div class = "col-sm-8">
                                      <div class="input-group input-group-sm">
                                       <input type="text" id = "tselisih" name="tselisih" class="deci form-control input-sm"
                                          style="text-align: right;font-weight: bold;"  readonly>
                                        <span class="input-group-addon" style="font-style: italic;">Rp.</span>
                                      </div>
                                    </div> 
                                  </div> 
                                  <div class="col-md-12">                                  
                                  <br>
                                   <a href="javascript:void(0)" id="btdetil"><strong>Add Row</strong></a>
                                      <!-- Custom Tabs -->
                                      <div class="nav-tabs-custom">
                                        <ul class="detil nav nav-tabs">
                                          <li class="active"><a href="#tab_1" data-toggle="tab" role= "tab">Detail</a></li>
                                          <li><a href="#tab_2" data-toggle="tab" role = "tab">Reference</a></li>
                                          <li><a href="#tab_3" data-toggle="tab" role = "tab">Response</a></li>
                                          <li><a href="#tab_4" data-toggle="tab" role = "tab">Record</a></li>
                                        </ul>
                                        <div class="tab-content">
                                          <div class="tab-pane active" id="tab_1">
                                            <div class ="table-responsive;" style="height: 400px; overflow:auto;">
											                        <input type="hidden" id="temprekid" name="temprekid" />
                                              <table class="table table-bordered table-striped" id='jDetil' style="border:solid 1px #999; #999; border-radius:0px;">
                                                <thead>
                                                  <tr>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white; width:45px; text-align: center;">Del</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white; width:55px;">Line</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white; width:200px;">Account</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;">Description Detail</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white; width:130px;">IDR</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white; width:100px;">Branch</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white; width:100px;">Rekanan</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white; width:100px;">Brand</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white; width:100px;">Ref. ID</th>
                                                      <th bgcolor="#3c8dbc" style="background: #0096d5; color: white; width:65px;">Ref Line</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <?php if(isset($resultd)){                                                          
                                                      $rowcount = 0;
                                                      foreach($resultd as $rowd){
                                                        $colorIdr = $rowd->jurnaldetil_idr < 0 ? 'color: red;' : '';
                                                  ?>
                                                    <tr id=<?="jDetil-row-".$rowd->jurnaldetil_line?>>
                                                      <td><a id= "rowDelete" style="text-align: center;"><i class="fa fa-trash fa-lg"></i></a></td>
                                                      <td data-id="<?=$rowd->jurnaldetil_line?>" class="clsLine">
                                                        <a id= "rowEdit"><i class="fa fa-edit fa-lg"></i>&nbsp;<?=$rowd->jurnaldetil_line?></a>
                                                      </td>
                                                      <td><?=$rowd->acc_name?></td>
                                                      <td><?=$rowd->jurnaldetil_descr?></td>
                                                      <td class="clsidr" style="<?=$colorIdr?> text-align: right;">
                                                        <?=number_format($rowd->jurnaldetil_idr, 2)?>
                                                      </td>
                                                      <td><?=$rowd->branch_id?></td>
                                                      <td><?=$rowd->rekanan_id?></td>
                                                      <td><?=$rowd->rekananshipping_line?></td>
                                                      <td><?=$rowd->ref_id?></td>
                                                      <td><?=$rowd->ref_line?></td>
                                                    </tr>
                                                  <?php
                                                     }
                                                   }
                                                  ?>
                                                </tbody>
                                              </table>
                                             </div>
                                            </div>
                                            <!-- reference -->
                                            <div class="tab-pane" id="tab_2">
                                              <div class ="table-responsive">     
                                                <table class="table table-bordered table-striped" id='DgvRef' style="border:solid 1px #999; #999; border-radius:0px;">
                                                  <thead>
                                                     <tr>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">ID</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Line</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Bookdate</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Account</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:150px;width:150px;">IDR</th> 
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:320px;width:320px;">Descr</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:310px;width:310px;">Rekanan</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:220px;width:220px;">Brand</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody> 
                                                    <?php if(count($resultRef) > 0) { 
                                                      foreach($resultRef as $rows) {
                                                    ?>
                                                    <tr>
                                                      <td><?php echo $rows['jurnal_id']; ?></td>
                                                      <td><?php echo $rows['jurnaldetil_line']; ?></td>
                                                      <td><?php echo $rows['jurnal_bookdate']; ?></td>
                                                      <td><?php echo $rows['acc_id'].'||'.$rows['acc_name']; ?></td>
                                                      <td><?php echo number_format($rows['jurnaldetil_idr'],2); ?></td>
                                                      <td><?php echo $rows['jurnaldetil_descr']; ?></td>
                                                      <td><?php echo $rows['rekanan_id'].'||'.$rows['rekanan_name']; ?></td>
                                                      <td><?php echo $rows['rekananshipping_line'].'||'.$rows['rekananshipping_name']; ?></td>
                                                    </tr>
                                                    <?php }} ?>
                                                  </tbody>
                                                </table>
                                              </div>
                                            </div>
                                            <!-- reference end -->
                                            <!-- response -->
                                            <div class="tab-pane" id="tab_3">
                                              <div class ="table-responsive">
                                                <table class="table table-bordered table-striped" id='DgvRes' style="border:solid 1px #999; #999; border-radius:0px;">
                                                  <thead>
                                                     <tr>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">ID</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Line</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Bookdate</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:40px;width:40px;">Account</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:150px;width:150px;">IDR</th> 
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:320px;width:320px;">Descr</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:310px;width:310px;">Rekanan</th>
                                                        <th bgcolor="#3c8dbc" style="background: #0096d5; color: white;min-width:220px;width:220px;">Brand</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody> 
                                                    <?php if(count($resultRes) > 0) { 
                                                      foreach($resultRes as $rows) {
                                                    ?>
                                                    <tr>
                                                      <td><?php echo $rows['jurnal_id']; ?></td>
                                                      <td><?php echo $rows['jurnaldetil_line']; ?></td>
                                                      <td><?php echo $rows['jurnal_bookdate']; ?></td>
                                                      <td><?php echo $rows['acc_id'].'||'.$rows['acc_name']; ?></td>
                                                      <td><?php echo number_format($rows['jurnaldetil_idr'],2); ?></td>
                                                      <td><?php echo $rows['jurnaldetil_descr']; ?></td>
                                                      <td><?php echo $rows['rekanan_id'].'||'.$rows['rekanan_name']; ?></td>
                                                      <td><?php echo $rows['rekananshipping_line'].'||'.$rows['rekananshipping_name']; ?></td>
                                                    </tr>
                                                    <?php }} ?>
                                                  </tbody>
                                                </table>
                                              </div>
                                            </div>         
                                            <!-- response end -->         
                                            <!-- Record -->                          
                                            <div class="tab-pane" id="tab_4">
                                              <div class="row">
                                               <div class="col-md-6">
                                                <div class="col-xs-8">
                                                  <label>Create By</label>
                                                  <input type="text" id= "jurnal_createby" name="jurnal_createby" class="form-control input-sm" value="<?php echo $row->jurnal_createby;?>">
                                                </div>
                                               </div>
                                               <div class="col-md-6">
                                                <div class="col-xs-8">
                                                  <label>Create Date</label>
                                                  <input type="text" id="jurnal_createdate" name="jurnal_createdate" class="form-control input-sm" value="<?php echo $row->jurnal_createdate;?>">
                                                </div>
                                               </div>
                                               <div class="col-md-6">
                                                <div class="col-xs-8">
                                                  <label>Modify By</label>
                                                  <input type="text" id= "jurnal_modifyby"  name="jurnal_modifyby" class="form-control input-sm" value="<?php echo $row->jurnal_modifyby;?>">
                                                </div>
                                               </div>
                                               <div class="col-md-6">
                                                <div class="col-xs-8">
                                                  <label>Modify Date</label>
                                                  <input type="text" id="jurnal_modifydate" name="jurnal_modifydate" class="form-control input-sm" value="<?php echo $row->jurnal_modifydate;?>">
                                                </div>
                                               </div>
                                               </div>
                                            </div>
                                            <!-- Record End -->
                                          <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                      </div>
                                      <!-- nav-tabs-custom -->
                                    </div>
                                    <!-- /.col -->
                                <div class="col-xs-12" style="display: flex; gap: 20px; padding-top: 10px;">
                                  <input type="submit" value="SUBMIT" name="submit" class="btn btn-sm btn-info"  <?php echo ($row->jurnaltype_id) === 'JV' && (!($row->jurnal_isposted)) ? '' : 'disabled';?> />
                                  <input type="submit" value="DELETE" name="delete" class="btn btn-sm btn-danger" <?php echo ($row->jurnaltype_id) === 'JV' && (!($row->jurnal_isposted)) ? '' : 'disabled';?> />
                                </div>
                              </div>
                             </div>
                            </form>
                              <?php if ($row->jurnal_isposted == 1){?>
                              <script>
                                $('#iperiod').prop('disabled', true);
                              </script>
                              <?php }?>
                            <?php }}?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              <!-- END OF CONTENT -->


