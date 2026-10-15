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

      var obj = {
        fDate : $('#f_date'), 
        tDate : $('#t_date'), 
        iRegion : $('#hregion'), 
        iBranch : $('#hbranch'), 
        iTenant : $('#htenant'), 
        iBrand : $('#hbrand'), 
        idSchedule : $('#iidschedule'), 
        idAgreement : $('#iidagreement'), 
        agrType : $('#hagrtype')
      }

      var oTable = sp_grid("<?php echo site_url('schedule_payment/controler_gridlist')?>","looTable","lfrtip", 10, [], obj);
      var tenantTable = popgrid("<?php echo site_url('schedule_payment/controler_gridtenant')?>","popLoader","trp", 10);
      var regionTable = popgrid("<?php echo site_url('schedule_payment/schedule_payment/controler_gridregion')?>","regionLoader","trp", 10);
      var branchTable = popgrid("<?php echo site_url('schedule_payment/schedule_payment/controler_gridbranch')?>","branchLoader","trp", 10);
      var brandTable = popgrid("<?php echo site_url('schedule_payment/schedule_payment/controler_gridbrand')?>","brandLoader","trp", 10);
      var agrtypeTable = popgrid("<?php echo site_url('schedule_payment/schedule_payment/controler_gridagrtype')?>","agrtypeLoader","trp", 10);	
      //new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } ); 
      // new $.fn.dataTable.FixedColumns( oTable, { leftColumns: 1, rightColumns: 1 } );
      
      

      oTable.on('processing.dt', function (e, settings, processing) {
        if (processing) {

          $.blockUI({message: $('<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>') });
        } else {         
          $.unblockUI();
        }
      });
      
              
      $('#tabedit').click(function() {
        //alert('Please, select data from list');
        $("#tablist").trigger('click');
      });

      $('#btnload2').on('click', function() {

          $('[data-toggle="dropdown"]').parent().removeClass('open');

          oTable.ajax.reload();

      })

      $('.tanggal').datepicker();

      $('#btcleart_1').click(function() {    

        $('#f_date').val('');     
      
      });

      $('#btcleart_2').click(function() {    

        $('#t_date').val('');     
      
      });
      
      $('#btnsubmit').click( function() {
        var sid = '';
        
        var rData = oTable.rows('.selected').data();

            for (var i=0; i < rData.length ;i++){
          if (sid==''){
            sid     = rData[i][0];
          }
          else {
            sid = sid + '_' + rData[i][0];
          }

                
            }		 
        
        $('#schedule_id').val(sid);	

          
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
      //$("#invdatedialog").modal("show");
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
      
      $('#cselect').change(function(){

        if($(this).is(':checked')){
          oTable.rows().select();			
        } else {
            oTable.rows('.selected').deselect();
        }
      })
        
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
            $('#f_date').val('');
        }
      })

      $('#cperiodeend').change(function(){
        if($(this).is(':checked')){
      
        } else {
            $('#iperiodeend').val('');
        }
      })	 

      $('#cidschedule').change(function(){

        if($(this).is(':checked')){
          $('#iidschedule').prop('readonly',false);
        } else {
          $('#iidschedule').prop('readonly',true);
          $('#iidschedule').val('');			
        }
      })	

      $('#cidagreement').change(function(){
        
        if($(this).is(':checked')){
          $('#iidagreement').prop('readonly',false);
        } else {
          $('#iidagreement').prop('readonly',true);
          $('#iidagreement').val('');
        }
      })	 

      $('#btnload').click( function() {

          var searchRegion = $("#hregion").val();
          var searchBranch  = $("#hbranch").val();
          var searchTenant = $("#htenant").val();
          var searchBrand  = $("#hbrand").val();
          var searchAgrtype  = $("#hagrtype").val();
          var searchIdSchedule  = $("#iidschedule").val();
          var searchIdAgreement  = $("#iidagreement").val();
          var searchType  = '';
          var val_datefrom = '';
          var val_dateend = '';
          var val_datepost = '';
          //var val_dateend =val_date2.replace(/-/g, '');
          var val_invtype = $('#invoicetype').val();
          var cdatefrom = $('input[name=cperiodefrom]').is(':checked');
          var cdateto = $('input[name=cperiodeend]').is(':checked');
          var val_dateproforma = '';
          var cAgrType = $('input[name=cType]').is(':checked');
      
          if(cAgrType==false){
            searchType ='';			  
          }
          else {
            searchType  = $("#invoicetype").val();	
          }			

          oTable.search('');
          oTable.draw();
      });


      $('#btnrek').click(function() {
          // var searchTenant  = $("#searchTenant").val();
        // var searchbranch  = $("#hbranch").val();
        // tenantTable.column(0).search(searchTenant);
          // tenantTable.column(1).search(searchbranch);
        // tenantTable.draw();
        var searchTenant  = $("#searchTenant").val();
        tenantTable.search(searchTenant).draw()
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

      $.blockUI.defaults.css = { 
          padding: 0,
          margin: 0,
          width: '30%',
          top: '40%',
          left: '35%',
          textAlign: 'center',
          cursor: 'wait'
      };
	 
  });


  
  function sp_grid(vlink, namatable, optsearch, pLength=10, aCenter=[], arrSearch){
    
    var selected = [];

    $('#'+namatable+' tbody').on( 'click', 'tr', function () {

      $(this).toggleClass('selected');
    });
      
    var oTable=$('#'+namatable).DataTable({		
      "pageLength": pLength,
      "processing": true, 
      "serverSide": true, 
      "order": [],
      "searching" : true,
      "ajax": {
        "url": vlink,
        "type": "POST",
        "data": (obj) => {
          obj.searchList = {
            region_id : arrSearch.iRegion.val(),
            branch_id : arrSearch.iBranch.val(),
            rekanan_id : arrSearch.iTenant.val(),
            rekananshipping_line : arrSearch.iBrand.val(),
            schedulepayment_id : arrSearch.idSchedule.val(),
            ref_id : arrSearch.idAgreement.val()
          } 
        }
      },

      "rowCallback": function( row, data ) {
        if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
            $(row).addClass('selected');	                	
        }
      },
      "columnDefs": [
        {
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
        {
          "targets": aCenter,
          "className": "text-center",
        }
      ],

      dom:optsearch
    });

    return oTable;
  }
  

  $(document).on('hide.bs.dropdown', function (e) {
      if ($(e.currentTarget.activeElement).hasClass('dropdown-toggle')) {
        $(e.relatedTarget).parent().removeClass('open');
        return true;
      }
      return false;
  });
  

  $.fn.datepicker.defaults.format = "yyyy-mm-dd";
  $.fn.datepicker.defaults.autoclose = true;

</script>

<style>
table.dataTable td {
    padding:2px;
    font-size: 9pt;    
}
td.highlight {
        font-weight: bold;
        color: blue;
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
              <div class="col-md-12">
                <div class="portlet">
                  <div class="portlet-title">
                    <div class="caption"">
                      <div class="actions">
						<?php echo form_open(base_url('index.php/schedule_payment/schedule_payment/previewsoppdf'),'role="form" class="form-horizontal" id="form_master_semesterbranch" parsley-validate target="_blank"'); ?>
						<input type="hidden" id="schedule_id" name="schedule_id" value="">
                        <div class="btn-group">

              

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
                  <label class="checkbox-inline"><input type="checkbox" id="cidschedule" name="cidschedule">ID Schedule</label>
                      <input type="text" class="form-control input-sm pull-right" id="iidschedule" name="iidschedule" value = "" readonly>
                </div>
                <div class="col-md-4">
                  <label class="checkbox-inline"><input type="checkbox" id="cidagreement" name="cidagreement">ID Agreement</label>
                      <input type="text" class="form-control input-sm pull-right" id="iidagreement" name="iidagreement" value = "" readonly>
                </div>	
                
              <div class="col-md-4">
                 <label class="checkbox-inline"><input type="checkbox" id="cType" name="cType">Tran Type</label>
							  <select class="form-control input-sm" name="invoicetype" id="invoicetype" data-placeholder="Pilih Data" >
									 <option value="">
										
									  </option>
									  <option value="AG">
										Agreement (Leasing)
									  </option>
									  <option value="AT">
										Agreement (Casual Leasing)
									  </option>
									  <option value="UL">
										Utilities Listrik
									  </option>
									  <option value="UA">
										Utilities Air
									  </option>
									  <option value="UG">
										Utilities Gas
									  </option>
									  <option value="AR">
										AR
									  </option>
							  </select>
				</div>
				<div class="col-md-4">
                <label>Include OR</label>
							  <select class="form-control input-sm" name="ijurnal" id="ijurnal" data-placeholder="Pilih Data" >
									 <option value="0">
										NO
									  </option>
									  <option value="1">
										YES
									  </option>
							  </select>
				</div>


				
                <div class="col-md-12" align="left">
                  <br>
					<input type="button" id="btnload" value = "LOAD" class="btn btn-sm btn-info"/>
			    </div>				
                <div class="col-md-12" align="left">
                  <br>
					<label class="checkbox-inline"><input type="checkbox" id="cselect" name="cselect">Select All</label>
			    </div>
						
                      </div>
                    </div>
                    <div class="tools">
                      <a href="javascript:;" class="collapse"> </a>
                      <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                    </div>
                  </div>
                   
					  
				<div class="col-md-12" align="right">
                  <br>

					<input type="submit" id="btnsubmit" name="button" value = "PRIVIEW" class="btn btn-sm btn-info"/>
					<input type="submit" id="btnsubmit" name="button" value = "EXCEL" class="btn btn-sm btn-info"/>
					<input type="submit" id="btnsubmit" name="button" value = "LOG DATA" class="btn btn-sm btn-info"/>
					<br>
					<br>
                </div>
				
 
                            <div class="portlet-body">
                              <div class="table-container table-scrollable">								 
                                 <table class="table table-striped table-hover  nowrap" id='looTable' style="border-color: #E0E0E0;">
                                 	  <thead>
                                  		<tr>
                                        <th>ID</th>
                                    	<th>Descr</th>
                                        <th>Closed</th>
                                        <th>Approved</th>
                                        <th>Ref</th>
                                        <th>Ref.Ln</th>
                                        <th>Transaksi.ID</th>
                                        <th>Channel</th>
                                        <th>Region</th>
                                        <th>Branch</th>
                                        <th>Unit</th>
                                        <th>Rekanan</th>
                                        <th>Brand</th>
                                        <th>Create Date</th>
                                        <th>Create By</th>
                                        <th>Modify Date</th>
                                        <th>Modify By</th>                                                          
                                  		</tr>              
                				            </thead>
                              		<tbody>
                              		</tbody>
                            	   </table>                                 
                              </div>
                            </div>
                          </div>
                        </div> 
 

              <!-- END OF CONTENT -->
			   