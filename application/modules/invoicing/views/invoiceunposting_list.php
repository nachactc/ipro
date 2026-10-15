<script>
  function deleteid(val){

     if (val == 0){

      var msj='Are you sure to drop this row?';
      if (!confirm(msj)) {

        return false;
      }

     }else{

      return false;
     }
  }

  $(document).ready(function(){
	var val_id = '3';
	var oTable=listgrid("<?php echo site_url('invoicing/invoice/controler_gridlist/')?>"+val_id,"looTable","lfrtip",20);
  var tenantTable=popgrid("<?php echo site_url('invoicing/invoice/controler_gridtenant')?>","popLoader","trp", 10);
  var regionTable=popgrid("<?php echo site_url('invoicing/invoice/controler_gridregion')?>","regionLoader","trp", 10);
  var branchTable=popgrid("<?php echo site_url('invoicing/invoice/controler_gridbranch')?>","branchLoader","trp", 10);
  var brandTable=popgrid("<?php echo site_url('invoicing/invoice/controler_gridbrand')?>","brandLoader","trp", 10);
  var agrtypeTable=popgrid("<?php echo site_url('invoicing/invoice/controler_gridagrtype')?>","agrtypeLoader","trp", 10);

    //new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } );
  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  		$("#tablist").trigger('click');
  		});

	$('.searching').select2();

$('#invoicetype2').on('change', function() {
		val_search = $('#invoicetype').val();
		if ( $.fn.dataTable.isDataTable( '#looTable' ) ) {
			oTable.destroy();
			oTable=listgrid("<?php echo site_url('invoicing/invoice/controler_gridlist/')?>"+val_search,"looTable","lfrtip");
		}
		else {
			 oTable = $('#looTable').DataTable();
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
      $('#cperiodefrom').change(function(){
        if($(this).is(':checked')){

        } else {
            $('#iperiodefrom').val('');
        }
      })
      $('#cperiodeend').change(function(){
        if($(this).is(':checked')){

        } else {
            $('#iperiodeend').val('');
        }
      })
      $('#cpostdate').change(function(){
        if($(this).is(':checked')){

        } else {
            $('#ipostdate').val('');
        }
      })
      $('#cselect').change(function(){
        if($(this).is(':checked')){
			oTable.rows().select();			
        } else {
            oTable.rows('.selected').deselect();
        }
      })
	  
      $('#btnload2').click( function() {
        var val_region = $("#hregion").val();
		var val_branch = $("#hregion").val();
        var val_datefrom ='';
        var val_dateend ='';
        var val_postdate ='';
        var val_search = $('#invoicetype').val();
        var val_search2 = '';
        var val_search3 = '';
        var val_search4 = '';
        var valdatefrom = $('input[name=cperiodefrom]').is(':checked');
        var valdateend = $('input[name=cperiodeend]').is(':checked');
        var valpostdate = $('input[name=cpostdate]').is(':checked');
        
        if(valdatefrom==true){
          var val_date1 =$('#iperiodefrom').val();
          val_datefrom =val_date1.replace(/-/g, '');
        }
        else {
          val_datefrom ='0';
        }

        if(valdateend==true){
          var val_date2 =$('#iperiodeend').val();
          val_dateend =val_date2.replace(/-/g, '');
        }
        else {
          val_dateend='0';
        }

        if(valpostdate==true){
          var val_date3 =$('#ipostdate').val();
          val_posdate=val_date3.replace(/-/g, '');
        }
        else {
          val_posdate ='0';
        }

        //alert(val_search2);
        //val_dateend ='20190302';
		alert(val_region);
    		if ( $.fn.dataTable.isDataTable( '#looTable' ) ) {
    			oTable.destroy();
    			oTable=listgrid("<?php echo site_url('invoicing/invoice/controler_gridlist/')?>"+val_search+"/"+val_datefrom+"/"+val_dateend+"/"+val_posdate+"/"+val_region+"/"+val_branch,"looTable","lfrtip");
    		}
    		else {
    			 oTable = $('#looTable').DataTable();
    		}
			
			
        //var searchRegion = $("#hregion").val();
        //var searchBranch  = $("#hbranch").val();
        //var searchTenant = $("#htenant").val();
        //var searchBrand  = $("#hbrand").val();
        //var searchAgrtype  = $("#hagrtype").val();

        //oTable.search('');
        //oTable.column(0).search(searchRegion);
        //oTable.column(1).search(searchBranch);
        //oTable.column(2).search(searchTenant);
        //oTable.column(3).search(searchBrand);
        //oTable.column(4).search(searchAgrtype);
        //oTable.column(2).search(searchBranch);
        //oTable.draw();
        //oTable.draw();

      });

      $('#btnload').click( function() {
          var searchRegion = $("#hregion").val();
          var searchBranch  = $("#hbranch").val();
          var searchTenant = $("#htenant").val();
          var searchBrand  = $("#hbrand").val();
          var searchAgrtype  = $("#hagrtype").val();
		  var searchinvtype  = $("#invoicetype").val();
          var val_datefrom ='';
          var val_dateend ='';
		  var val_datepost ='';
          //var val_dateend =val_date2.replace(/-/g, '');
          var val_invtype = $('#invoicetype').val();
		  var cdatefrom = $('input[name=cperiodefrom]').is(':checked');
		  var cdateto = $('input[name=cperiodeend]').is(':checked');
		  
var date = new Date();
var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

var lastDayWithSlashes = lastDay.getFullYear() + '/' + (lastDay.getMonth() + 1) + '/' + (lastDay.getDate());

//alert(lastDayWithSlashes);		  
			if(cdatefrom==true){
			  val_datefrom =$('#iperiodefrom').val();			  
			}
			else {
				val_datefrom ='2011-01-01';			
			}
			
			if(cdateto==true){
			  val_dateend =$('#iperiodeend').val();			  
			}
			else {
				val_dateend =lastDayWithSlashes;				
			}
			
			//if(cdatefrom==false){
			//  val_datepost =$('#iproformadate').val();			  
			//}
			//else {
			//	val_datepost ='';
			//}
			val_datepost ='';
          //var searchID ='INV/0069/TRP/IN/05/2018';
          //alert(val_dateend);
          //alert var_dump(oTable);
          oTable.search('');
          //oTable.search(searchRegion).draw();
          //oTable.search(searchBranch);

          //oTable.search(searchID).draw();
          oTable.column(0).search(searchRegion);
          oTable.column(1).search(searchBranch);
          oTable.column(2).search(searchTenant);
          oTable.column(3).search(searchBrand);
          oTable.column(4).search(searchAgrtype);
          oTable.column(5).search(val_datefrom);
          oTable.column(6).search(val_dateend);
		  oTable.column(7).search(val_datepost);
		  oTable.column(8).search(searchinvtype);
          //oTable.column(7).search(val_postdate);
          //oTable.column(8).search(val_invtype);
          //oTable.column(2).search(searchBranch);
          oTable.draw();
      });

      $('#btnprint').click( function() {
        var linenum=0;
        var sid = '';
        var sinv = '';
         var rData = oTable.rows('.selected').data();



         for (var i=0; i < rData.length ;i++){

            var tid     = rData[i][0];
            var tname   = rData[i][1];
            if (sinv==''){
                sinv = rData[i][1];
            }
            else {
                sinv = sinv + '-'+ rData[i][1];
            }
        }
        //sid =sinv.replace('/', '_');
        sid = sinv.replace(new RegExp("/","g"), "_");

        //alert(sid);
        var url ='/index.php/invoiceprint/invoiceprint/invoiceprintpdf/' + sid
		 	window.open(url,'_blank');
			//$link.click()
			//alert($link);
      });
	
	$('#btnunposting').click( function() {
		$("#reasondialog").modal("show");
	});
	
   $('#btnreason').click( function() {
		var sreason = $("#reason").val();
		
      if (sreason==''){
          alert('please fill in the reason');
      }
      else {
        $("#reasondialog").modal("hide");
		
        var url = "<?= site_url('invoicing/invoice/unposting_invoicing');?>";


        var linenum=0;
        var tid = '';
        var sinv = '';
        var sregionid='';
        var sregionnameshort='';
        var sagrtype='';
        var schannelid='';
		var sbranchid='';
		var sproformadate= $("#iproformadate").val();
		
         var rData = oTable.rows('.selected').data();



         for (var i=0; i < rData.length ;i++){

            tid     = rData[i][0];
            linenum   = rData[i][1];
			invoiceid   = rData[i][2];
            sregionnameshort = rData[i][4];
            sagrtype = rData[i][16];
            sregionid = rData[i][17];
            schannelid = rData[i][18];
			sbranchid = rData[i][19];
			sagreementtype_id = rData[i][20];

            if (sinv==''){
                sinv = rData[i][1];
            }
            else {
                sinv = sinv + '-'+ rData[i][1];
            }
			
			var ajax = $.post( url, { id: tid, line: linenum, agrtype: sagrtype, region_id: sregionid, regionnameshort: sregionnameshort, channel_id: schannelid, branch_id: sbranchid, proforma_date: sproformadate, agreementtype_id : sagreementtype_id, reason : sreason, invoice_id : invoiceid} )
			.done(function(pesan){
				var obj = $.parseJSON(pesan);
				//console.log(obj.pesan);	
				
				if(obj.OR == 'OR MASIH ADA')
				{
					console.log(obj.pesan);	
					alert(obj.pesan);					
				}

				
			}, 'json');
				//return ajax;				
        }

		//alert('Done');
		//display_modal('Info', 'Invoicing Success');
		$('#btnload').trigger('click');

		}
		
      });

      $.fn.datepicker.defaults.format = "yyyy-mm-dd";
      $.fn.datepicker.defaults.autoclose = true;

  function display_modal(title, message){
     $("#mdlinfo").modal("show");
     $("#mdltitle").show().html(title);
     $("#mdlbody").show().html(message);
  }
  
    $('#itenant2').select2({
        placeholder: 'Select an option',
        minimumInputLength: 2,
        //tags: true,
        minimumResultsForSearch: 10,
        tokenSeparators: [',', ' '],
        ajax: {
            url: '<?php echo site_url('invoicing/invoice/tenant_select')?>',
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

  	var date = new Date();
	var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
	var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
	
	var firstDayWithSlashes = lastDay.getFullYear() + '-' + (lastDay.getMonth() + 1) + '-' + (firstDay.getDate());
	var lastDayWithSlashes = lastDay.getFullYear() + '-' + (lastDay.getMonth() + 1) + '-' + (lastDay.getDate());

	$('#iperiodefrom').val(firstDayWithSlashes);
	$('#iperiodeend').val(lastDayWithSlashes);
	
  });



</script>

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
 
<!-- /.popup-alasan -->
 <div class="modal fade" id="reasondialog" tabindex="-1" role="basic" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title">
           Unposting Reason
         </h4>
       </div>
       <div class="modal-body">
         <form action="#" id="form" class="form-horizontal">
           <div class="row">
           <div class="col-md-8">
              <label>Reason</label>
			 <textarea id = "reason" name="reason" class="form-control input-sm" required rows="4" ></textarea>
           </div>
         </div>             
     </form>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn dark btn-outline" data-dismiss="modal">
           Close
         </button>
         <button type="button" class="btn green" id="btnreason">
           ADD REASON
         </button>
       </div>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>
 
 <!-- /.popup-tenant -->
  <div class="row">
	<div class="col-lg-12 col-md-12">		
		<?php 
                 	
			$message = $this->session->flashdata('message');
			if (isset($message)) {
				echo '<div class="alert alert-info" role="alert">' . $message . ' <i class="fa fa-window-close" data-dismiss="alert" aria-label="Close">
  </i></div>';
				 
				$this->session->unset_userdata('message');
			} 
			?>
	</div>
</div><!-- /.row --> 

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
						<?php echo form_open(base_url('index.php/invoicing/invoice/controler_gridlist')); ?>

            <div class="btn-group">

              <div class="col-md-4">
                <label>Invoice Type</label>
							  <select class="form-control input-sm" name="invoicetype" id="invoicetype" data-placeholder="Pilih Data" >
									 <option value="1">
										General
									  </option>
									  <option value="2">
										Deposit
									  </option>
									  <option value="3">
										Utilities
									  </option>
							  </select>
							</div>

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
                  <label class="checkbox-inline"><input type="checkbox" id="cagrtype">Agr Type</label>
                    <div class="input-group input-group-sm">
                      <input type="text" id = "iagrtype" name="iagrtype" class="form-control input-sm" value="" required autocomplete="off" readonly>
                      <span class="input-group-btn">
                        <button id ="btagrtype" type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
                      </span>
                    <input type="hidden" id = "hagrtype" name="hagrtype" value="">
                    </div>
                </div>

                <div class="col-md-4">
                  <label class="checkbox-inline"><input type="checkbox" id="cperiodefrom" name="cperiodefrom">Periode From</label>
                  <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                      <input type="text" class="form-control input-sm pull-right" id="iperiodefrom" name="iperiodefrom" value = "<?php echo date("Y-m-d");?>" readonly>
                  </div>
                </div>

                <div class="col-md-4">
                  <label class="checkbox-inline"><input type="checkbox" id="cperiodeend" name="cperiodeend">Periode End</label>
                  <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                      <input type="text" class="form-control input-sm pull-right" id="iperiodeend" name="iperiodeend" value = "<?php echo date("Y-m-d");?>" readonly>
                  </div>
                </div>

                <div class="col-md-4">
                  <label>Post Date</label>
                  <div class="input-group date" data-provide="datepicker">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                      <input type="text" class="form-control input-sm pull-right" id="iproformadate" name="iproformadate" value = "<?php echo date("Y-m-d");?>" readonly>
                  </div>
                </div>
                <div class="col-md-12" align="left">
                  <br>
					<input type="button" id="btnload" value = "LOAD" class="btn btn-sm btn-info"/>
			    </div>
				<div class="col-md-12" align="right">
                  <input type="button" id="btnunposting" value = "UNPOSTING" class="btn btn-sm btn-info"/>
                </div>
                <div class="col-md-12" align="left">
					<label class="checkbox-inline"><input type="checkbox" id="cselect" name="cselect">Select All</label>
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
                  <div class="portlet-body">
                           <div class="table-container">
                             <div class="table-scrollable">
                                 <table class="table table-striped table-hover nowrap" id='looTable' style="border-color: #E0E0E0;">
                                 	  <thead>
                                  		<tr>
                                        <th>Schedule ID</th>
                                        <th>Line</th>
                                        <th>Invoice No</th>
                                        <th>Faktur No</th>
                                        <th>B. Unit</th>
                                        <th>Store</th>
                                        <th>Tenant</th>
                                        <th>Brand</th>
										<th>Unit</th>
                                        <th>Agrement</th>
                                        <th>Descr</th>
                                    		<th>Date</th>
                                        <th>Due Date</th>
                                        <th>Proforma Date</th>
                                        <th>Amount</th>
                                        <th>IDR</th>
                                        <th>AGR Type</th>
                                        <th>Region ID</th>
                                        <th>Channel ID</th>
										<th>Branch ID</th>
										<th>Agreement ID</th>
										<th>Rekanan ID</th>
										<th>Shipping Line</th>		
										<th>ref ID</th>
										<th>ref Line</th>										
                                  		</tr>
                				            </thead>
                              		<tbody>
                              		</tbody>
                            	   </table>
                        </div>						
                      </div>                  
				  </div>				  
                </div>				
              </div>
              <!-- END OF CONTENT -->
