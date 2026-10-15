
<script>
 function maths() {
 var vjml = 0;
 var table = $("#DgvDetil tbody");
 table.find('tr').each(function(i) {
  var $row = $(this).closest("tr");
  var clstreceive = $row.find(".clssisaidr").val();
  clstreceive = clstreceive.replace(/,/g, "");
  var qty = parseFloat(clstreceive) || 0;
  vjml = parseFloat(vjml) + qty;
 });
 vjml = vjml.toFixed(2);
 $("#txtnilamount").val(vjml);
}

function numberWithCommas(x) {
 return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
$(document).ready(function() {

 var idr_header = 0;
 var idr_detilaging = 0;
 var countCheckHeader = 0;
 var countCheckDetil = 0;

 $("#tap1").hide();
 $.fn.modal.Constructor.prototype.enforceFocus = $.noop;
 $("#tempdialog").modal("show");
 $("#tabdata").trigger('click');

 $('#tabedit').click(function() {
  display_modal('Alert!', 'Please, select data from list.');
 });

 $('#addbisnisunit').click(function() {
  var sele = $("input[name='pp']:checked").val();
  $("#tbisnisunit").val(sele);

 });


 $('#btbisnisunit').click(function() {
  $('#dlgbisnisunit').modal({
   show: true
  });
  $.ajax({
   url: '<?php echo site_url('refunduknown/refunduknown/isidialogbisnis')?>',
   async: false,
   type: "POST",
   data: "type=article",
   dataType: "html",
   success: function(data) {
    $('#dlgbisnis').html(data);
   }
  })

 });

 //new $.fn.dataTable.FixedColumns(tbDgvDetil, { leftColumns:5 } );
 //new $.fn.dataTable.FixedColumns(tbDgvpilih, { leftColumns:5 } );
 $('#tblDlgFooter').hide();
 $('#btloadheader').click(function() {
  $("#tap1").show();

  // $("#deposittotal").val(0);
  // $("#agingtotal").show(0);
  // $("#reavailtotal").show(0);

  var niltrade = $("#ttradename").val();
  if (niltrade == '') {
   alert('Trade Name Harus dipilih!');
  } else {
   $("#tap1").show();
   var postForm = {
    'vbisnisunit': $('#hbisnisunit').val(),
    'vstore': $('#hstore').val(),
    'vtrdname': $('#htradename').val(),
    'vtenan': $('#htenant').val(),
    'hdebtor': $('#hdebtor').val(),
    'hshipline': $('#hshipline').val()
   };

   $.ajax({
    url: '<?php echo site_url('refunduknown/refunduknown/isigridheader')?>',
    async: false,
    type: "POST",
    data: postForm,
    dataType: "html",
    success: function(data) {
     $("#tap1").hide();
     $('#datgridH').html(data);
     // $("#Dgvpilih  tbody").find('tr').each(function (i) {
     // $(this).closest('tr').remove();
     // });
     arr = [];
     $('#tpenerima').val('');
     $('#cbpayment').val('');
     $('#cbaccpenerimaan').val('');
     $('#txtamount').val('');
     $("#vtab_0").trigger('click');
     $('#tblDlgFooter').show();
    }
   })
  }
 });

 $('#btloaddetil').click(function() {
  $("#tap1").show();
  // $("#deposittotal").val(0);
  // $("#agingtotal").show(0);
  // $("#reavailtotal").show(0);
  var niltrade = $("#ttradename").val();
  if (niltrade == '') {
   alert('Trade Name Harus dipilih!');
  } else {
   $("#tap1").show();
   var postForm = {
    'vbisnisunit': $('#hbisnisunit').val(),
    'vstore': $('#hstore').val(),
    'vtrdname': $('#ttradenamedetil').val(),
    'vtenan': $('#ttenantdetil').val(),
    'vtenanid': $('#ttenantdetil_id').val(),
    'hdebtor': $('#hdebtor').val(),
    'hshipline': $('#ttenantdetilship_id').val()
   };

   $.ajax({
    url: '<?php echo site_url('refunduknown/refunduknown/isigriddetilaging')?>',
    async: false,
    type: "POST",
    data: postForm,
    dataType: "html",
    success: function(data) {

     $('#datgridD').html(data);
     // $("#DgvpilihDetil tbody").find('tr').each(function (i) {
     // $(this).closest('tr').remove();
     // });
     arr = [];
     // $('#tpenerima').val('');
     // $('#cbpayment').val('');
     // $('#cbaccpenerimaan').val('');
     // $('#txtamount').val('');
     // $("#vtab_0").trigger('click');

     $("#tap1").hide();
    }
   })
  }
 });

 var row = '';


 function fnGetSelected(oTableLocal) {
  return oTableLocal.$('tr.row_selected');
 }
 var cek = 0;
 var cari = 'N';
 var xstatus = 'N';
 var arr = [];
 $('#btnverify').click(function() {
  var table = $("#DgvDetil tbody");
  var tablepilih = $("#Dgvpilih  tbody");
  var $target = $("#Dgvpilih");
  var jmlamount = 0;
  var jmlnilamount = 0;



  $("#txtisi").val("0");
  table.find('tr').each(function(i) {
   var $chkbox = $(this).find('input[type="checkbox"]');
   if ($chkbox.length) {
    var status = $chkbox.prop('checked');
    if (status == true) {
     $("#txtisi").val("1");

     var $row = $(this).closest("tr");
     var $clsrate = $row.find(".clsrate").val();
     var $clsforeign = $row.find(".clsforeign").val();
     var $clsrefid = $row.find(".clsrefid").val();
     var $clsaccid = $row.find(".clsaccid").val();
     var $clsaccname = $row.find(".clsaccname").val();

     var $clsregionid = $row.find(".clsregionid").val();
     var $clsbranchid = $row.find(".clsbranchid").val();
     var $clsstrukturunit = $row.find(".clsstrukturunit").val();
     var $clsref_line = $row.find(".clsref_line").val();
     var $clsrekananid = $row.find(".clsrekananid").val();
     var $clssub1_id = $row.find(".clssub1_id").val();
     var $clssub2_id = $row.find(".clssub2_id").val();
     var vclsnoline = $row.find(".clsnoline").val();

     var $tds = $(this).find('td'),
      Invoice = $tds.eq(1).text(),
      Tax = $tds.eq(2).text(),
      Book = $tds.eq(3).text(),
      Amount = $row.find(".jurnaldetil_idr").val(),
      Curr = $tds.eq(5).text(),
      Descr = $tds.eq(6).text(),
      accun = $tds.eq(7).text(),
     amtf = $tds.eq(8).text(),
      rcvf = $tds.eq(9).text(),
      regi = $tds.eq(10).text(),
      bran = $tds.eq(11).text(),
      Strukturunit = $tds.eq(12).text(),
      Rekanan = $tds.eq(13).text(),
      Channel = $tds.eq(14).text(),
      Shopname = $tds.eq(15).text();
	


     if (arr.length == 0) {
      arr.push(vclsnoline);
      $('#Dgvpilih tbody').append('<tr>' +
       '<td><input type="checkbox" name="chkdel" class="clsdele" /></td>' +
       '<td>' + Invoice + '<input type="hidden" name="uline[]" class="clsinv" value="' + Invoice + '"/></td>' +
       '<td>' + Tax + '<input type="hidden" name="uunit[]" value="' + Tax + '"/></td>' +
       '<td>' + Book + '</td>' +
       '<td>' + Amount + '<input type="hidden" name="usize[]" value="' + Amount + '"/></td>' +
       '<td>' + Curr + '<input type="hidden" name="ulantai[]" value="' + Curr + '"/>' +
       '<input type="hidden" class="clsregionid" name="clsregionid[]" value="' + $clsregionid + '"/>' +
       '<input type="hidden" class="clsbranchid" name="clsbranchid" value="' + $clsbranchid + '"/>' +
       '<input type="hidden" class="clsstrukturunit" name="tstrukturunit" value="' + $clsstrukturunit + '"/>' +
       '<input type="hidden" class="clsref_line" name="clsref_line" value="' + $clsref_line + '"/>' +
       '<input type="hidden" class="clsrekananid" name="clsrekananid" value="' + $clsrekananid + '"/>' +
       '<input type="hidden" class="clssub1_id" name="clssub1_id[]" value="' + $clssub1_id + '"/>' +
       '<input type="hidden" class="clssub2_id" name="clssub2_id" value="' + $clssub2_id + '"/>' +
       '<input type="hidden" class="clsnoline" name="clsnoline" value="' + vclsnoline + '"/>' +
       '<input type="hidden" class="clsamountb4" name="clsamountb4" value="' + Amount + '"/>' +
       '</td>' +
       '<td>' + Descr + '</td>' +
       '<td><input type="text" name="treceive" value="' + Amount + '" class="clstreceive" onkeyup="maths();" /></td>' +
       '<td>' + accun + '</td>' +
       '<td>' + amtf + '</td>' +
       '<td>' + rcvf + '</td>' +
       '<td>' + regi + '<input type="hidden" class="clsaccid" name="rfid[]" value="' + $clsaccid + '"/></td>' +
       '<td>' + bran + '<input type="hidden" class="clsaccname" name="rfid[]" value="' + $clsaccname + '"/></td>' +
       '<td>' + Strukturunit + '</td>' +
       '<td>' + Rekanan + '<input type="hidden" class="clsrefid" name="rfid[]" value="' + $clsrefid + '"/></td>' +
       '<td>' + Channel + '<input type="hidden" class="clsforeign" name="rforein[]" value="' + $clsforeign + '"/></td>' +
       '<td>' + Shopname + '<input type="hidden" class="clsrate" name="rrate[]" value="' + $clsrate + '"/></td>' +
       '</tr>');
     } else {
      var g = 'N';
      $.each(arr, function(index, value) {
       var t = value;
       if (t == vclsnoline) {
        g = 'Y';
       }

      });
      if (g == 'N') {
       $('#Dgvpilih tbody').append('<tr>' +
        '<td><input type="checkbox" name="chkdel" class="clsdele" /></td>' +
        '<td>' + Invoice + '<input type="hidden" name="uline[]" class="clsinv" value="' + Invoice + '"/></td>' +
        '<td>' + Tax + '<input type="hidden" name="uunit[]" value="' + Tax + '"/></td>' +
        '<td>' + Book + '</td>' +
        '<td>' + Amount + '<input type="hidden" name="usize[]" value="' + Amount + '"/></td>' +
        '<td>' + Curr + '<input type="hidden" name="ulantai[]" value="' + Curr + '"/>' +
        '<input type="hidden" class="clsregionid" name="clsregionid[]" value="' + $clsregionid + '"/>' +
        '<input type="hidden" class="clsbranchid" name="clsbranchid" value="' + $clsbranchid + '"/>' +
        '<input type="hidden" class="clsstrukturunit" name="tstrukturunit" value="' + $clsstrukturunit + '"/>' +
        '<input type="hidden" class="clsref_line" name="clsref_line" value="' + $clsref_line + '"/>' +
        '<input type="hidden" class="clsrekananid" name="clsrekananid" value="' + $clsrekananid + '"/>' +
        '<input type="hidden" class="clssub1_id" name="clssub1_id[]" value="' + $clssub1_id + '"/>' +
        '<input type="hidden" class="clssub2_id" name="clssub2_id" value="' + $clssub2_id + '"/>' +
        '<input type="hidden" class="clsnoline" name="clsnoline" value="' + vclsnoline + '"/>' +
        '<input type="hidden" class="clsamountb4" name="clsamountb4" value="' + Amount + '"/>' +
        '</td>' +
        '<td>' + Descr + '</td>' +
        '<td><input type="text" name="treceive" value="' + Amount + '" class="clstreceive" onkeyup="maths();" /></td>' +
        '<td>' + accun + '</td>' +
        '<td>' + amtf + '</td>' +
        '<td>' + rcvf + '</td>' +
        '<td>' + regi + '<input type="hidden" class="clsaccid" name="rfid[]" value="' + $clsaccid + '"/></td>' +
        '<td>' + bran + '<input type="hidden" class="clsaccname" name="rfid[]" value="' + $clsaccname + '"/></td>' +
        '<td>' + Strukturunit + '</td>' +
        '<td>' + Rekanan + '<input type="hidden" class="clsrefid" name="rfid[]" value="' + $clsrefid + '"/></td>' +
        '<td>' + Channel + '<input type="hidden" class="clsforeign" name="rforein[]" value="' + $clsforeign + '"/></td>' +
        '<td>' + Shopname + '<input type="hidden" class="clsrate" name="rrate[]" value="' + $clsrate + '"/></td>' +
        '</tr>');
       arr.push(vclsnoline);
      }

     }
     jmlamount = jmlamount + parseFloat(Amount.replace(/\,/g, '') || 0);
    }

   }


   $("#vtab_1").trigger('click');

  });
  $("#txtamount").val(jmlamount);
  $("#txtnilamount").val(jmlamount);



 });

 $('#btnremove').click(function() {

  var tablex = $("#Dgvpilih tbody");
  tablex.find('tr').each(function(i) {
   var $chkbox = $(this).find('input[type="checkbox"]');
   var $row = $(this).closest("tr");
   var vclsnoline = $row.find(".clsnoline").val();
   if ($chkbox.length) {
    var status = $chkbox.prop('checked');
    if (status == true) {
     var bx = $("#txtamount").val();
     var $tds = $(this).find('td'),
      Amount = $tds.eq(4).text()
     bx = bx - parseFloat(Amount.replace(/\,/g, '') || 0);
     $("#txtamount").val(bx);

     $(this).closest('tr').remove();
     arr.splice($.inArray(vclsnoline, arr), 1);

    }
   }
  });

 });


 $('#btterima').click(function() {

  if (countCheckHeader == 0) {
   alert('Pilih Data OR/CA Dahulu!');
   $("#tempdialog").modal("show");
   return;
  }
  if ($("#dlgBank option:selected").val() == '') {
   alert('Pilih Account Bank Dahulu');
   return;
  }
  var table = $("#DgvDetil tbody");

  var $target = $("#table_d");
  var vline = 0;
  var vlineK = 0;
  var i = 0;
  var receiveidr = $("#txtamount").val();
  var txtnilamount = $("#txtnilamount").val();
  var vpaymenttype = $("#cbpaymentTypeD option:selected").text();
  var $tpenerima = $('#tpenerima').val();
  var cbaccpenerimaan = $("#cbaccpenerimaan option:selected").text();
  var xacid = $("#cbaccpenerimaan").val();
  var payid = $("#cbpaymentTypeD").val();

  //receiveidr=receiveidr.replace(/,/g, "");
  //txtnilamount=txtnilamount.replace(/,/g, "");

  //receiveidr=receiveidr.replace(/,/g, "");
  //txtnilamount=txtnilamount.replace(/,/g, "");
  $("#tap1").show();
  $("#hpayment").val(payid);


  //console.log('hi');
  var nilAmount = 0;
  var AmountD = 0;
  var AmountK = 0;
  var AmountK_cek = 0;

  //var globe set val from debet
  var acc_d_ = '';
  var acc_d_name_ = '';
  var accK = $("#dlgBank option:selected");
  //debet
  table.find('input[type="checkbox"]:checked').each(function() {
   var $row = $(this).closest("tr");
   var $clsjurnalid = $row.find(".clsrefid").val();
   var $clsjurnaldetil_line = $row.find(".clsref_line").val();
   var $clsrekananid = $row.find(".clsrekananid").val();
   var $clsrekananshipping_line = $row.find(".clsrekananshipping_line").val();
   var $clsjurnaldetil_descr = $row.find(".clsjurnaldetil_descr").val();
   var $clscurrency_id = $row.find(".clscurrency_id").val();
   var $clsaccid = $row.find(".clsaccid").val();
   var $clsaccname = $row.find(".clsaccname").val();

   acc_d_ = $clsaccid;
   acc_d_name_ = $clsaccname;

   var $clsregionid = $row.find(".clsregionid").val();
   var $clsregionid = $row.find(".clsregionid").val();
   var $clsbranchid = $row.find(".clsbranchid").val();
   var $clsstrukturunit = $row.find(".clsstrukturunit").val();
   var vclsnoline = $row.find(".clsnoline").val();
   var $clsDescr = $row.find(".clsjurnaldetil_descr").val();
   var $clssisaidr = $row.find(".jurnaldetil_idr").val();
   var $clsrate = $row.find(".clsrate").val();
   var $clsforeign = $row.find(".clsforeign").val();
   var chk = $row.find(".myCheckBoxClass").val();

   var branch_id = $row.find(".clsbranch_id").val();
   var branch_name = $row.find(".clsbranch_name").val();
   var region_id = $row.find(".clsregion_id").val();
   var region_name = $row.find(".clsregion_name").val();
   var strukturunit_id = $row.find(".clsstrukturunit_id").val();
   var contract_no = $row.find(".clscontract_no").val();
   var strukturunit_name = $row.find(".clsstrukturunit_name").val();
   var rekanan_name = $row.find(".clsrekanan_name").val();
   var rekanan_id = $row.find(".clsrekanan_id").val();

   //set form add header
   $('#tbusnis_id').val(branch_id);
   $('#tbusnis').val(branch_name);
   $('#txtstore_id').val(region_id);
   $('#txtstore').val(region_name);
   $('#tsrukturname_id').val(strukturunit_id);
   $('#tsrukturname').val(strukturunit_name);
   $('#htradename').val(rekanan_id);
   $('#ttenanname').val(rekanan_name);
   $('#tcontractno').val(contract_no);

   $('#hshipline').val(parseInt($clsrekananshipping_line));
   $('#tsruktur_id').val(strukturunit_id);
   $('#hdebtor').val(contract_no);
   $('#hdebtor').val(contract_no);
   $('#htenant').val(rekanan_id);
   $('#ttenanname_id').val();
   var channel = $('#tchanel').val();

   // console.log('account debet');
   // console.log($clsaccid);
   var complex = <?php echo json_encode($paymentJson); ?>;

   // console.log('Payment');
   // console.log(complex);

   //AmountD = $clssisaidr.replace(/,/g, ""); 
   AmountD = parseInt(AmountD) + parseInt(parseFloat($clssisaidr.replace(/\,/g, '') || 0));

   //debet
   vline = vline + 10;
   $('#table_d tbody').append('<tr>' +
    '<td>' + vline + '<input type="hidden" name="vtline" value="' + vline + '"/></td>' +
    '<td><input type="text" class="form-control input-sm" style="width:250px"  name="vtdes" value="' + $clsDescr + '"/></td>' +
    '<td>' + $clscurrency_id + '<input type="hidden" name="vtcur" value="' + $clscurrency_id + '"/></td>' +
    '<td>' + $clssisaidr + '<input type="hidden" name="vtreceiveidr" value="' + $clssisaidr + '" onkeyup="maths();"/></td>' +
    '<td>' + $clsforeign + '<input type="hidden" name="vtforeign" value="' + $clsforeign + '"/>' +
    '<td>' + $clsrate + '<input type="hidden" name="vtrate" value="' + $clsrate + '"/>' + '</td>' +
    '<td>' + $clsjurnalid + '<input type="hidden" name="vtrafeid" value="' + $clsjurnalid + '" />' + '</td>' +
    '<td>' + $clsjurnaldetil_line + '<input type="hidden" name="vtrafeid" value="' + $clsjurnaldetil_line + '" />' + '</td>' +
    '<td>' + complex + '</td>' +
    '<td><input type="text" class="form-control input-sm" style="width:120px"  name="jurnaldetil_bank" id="jurnaldetil_bank" /> <input type="hidden" name="vtrflin" value="' + $clsjurnaldetil_line + '"/></td>' +
    '<td><input type="text" class="form-control input-sm" style="width:120px"  name="jurnaldetil_billyet" id="jurnaldetil_billyet" /><input type="hidden" name="vtacid" value="' + $clsaccid + '"/></td>' +
    '<td><?php echo date("Y-m-d");?></td>' +
    '<td><?php echo date("Y-m-d");?></td>' +
    '<input type="hidden" name="vrekananshipping_line" value="' + $clsrekananshipping_line + '" />' +
    '<input type="hidden" name="vrekanan" value="' + rekanan_id + '" />' +
    '<input type="hidden" name="vtrafeidxtline" value="' + $clsjurnalid + '" />' +
    '<td><input type="text" name="jurnalbilyet_receiveperson" id="jurnalbilyet_receiveperson" /></td>' +
    '<td></td>' +
    '</tr>');

   //kredit
   vlineK = vlineK + 5;

   $('#table_k tbody').append('<tr>' +
    '<td>' + vlineK + '<input type="hidden" name="xtline[]" value="' + vlineK + '"/></td>' +
    '<td>' + accK.text() + '<input type="hidden" name="xclsaccname[]" value="' + accK.val() + '"/></td>' +
    '<td><input type="text" class="form-control input-sm" style="width: 180px;" name="xcbaccpenerimaan[]" value="' + accK.text() + '"/></td></td>' +
    '<td>' + $clsrate + '<input type="hidden" name="xtreceive[]" value="' + $clssisaidr + '"/></td>' +
    '<td class="crcv">' + numberWithCommas($clssisaidr) + '</td>' +
    '<td>0<input type="hidden" name="xforeign[]" value="0"/></td>' +
    '<td>1<input type="hidden" class="clsregionid" name="vtregionid[]" value="' + $clsregionid + '"/>' +
    '<input type="hidden" class="clsbranchid" name="vtbranchid[]" value="' + $clsbranchid + '"/>' +
    '<input type="hidden" class="clsstrukturunit" name="vtstrukturunit[]" value="' + $clsstrukturunit + '"/>' +
    '<input type="hidden" class="clsrekananid" name="xrekananid[]" value="' + $clsrekananid + '"/>' +
    '<input type="hidden" class="clssub1_id" name="xtsub1_id[]" value=""/>' +
    '<input type="hidden" class="clssub2_id" name="xtsub2_id[]" value=""/>' +
    '</td>' +
    '<td>' + region_name + '<input type="hidden" name="xrate[]" value="' + $clsrate + '"/></td>' +
    '<td>' + branch_name + '<input type="hidden" name="xaccid[]" value="<?php echo $aloc_id;?>"/></td>' +
    '<td>' + strukturunit_name + '</td>' +
    '<td>' + rekanan_name + '</td>' +
    '<td>' + $clsjurnalid + '<input type="hidden" name="xrefid[]" value="' + $clsjurnalid + '"/></td>' +
    '<td>' + $clsjurnaldetil_line + '<input type="hidden" name="xref_line[]" value="' + $clsjurnaldetil_line + '"/></td>' +
    '<td>' + channel + '<input type="hidden" name="xchannel_id[]" value="' + channel + '"/></td>' +
    '<input type="hidden" name="xrekananship[]" value="' + $clsrekananshipping_line + '"/>' +
    '<input type="hidden" name="xtacc_id[]" value="' + accK.val() + '"/>' +
    '</tr>');

   console.log('selesai grid kredit');
   vline = vline + 10;
   $('#cboaccnok').val(accK.val()).trigger('change');

   $('.crcv').number(true, 0);

  });




  $("#tap1").hide();
  $("#tempdialog").modal('toggle');


  $("#ttotamount").val(parseFloat(AmountD));
  $('#ttotamount').number(true, 0);


 });

 $('#myform').on('submit', function() {
  var ttotamount = $("#ttotamount").val();

  var period = $('#cboperiode').val();
  var bookdateInput = $('#book_date').val().split('-');
  var periodeInputCheck = bookdateInput[0].substring(4, 2) + bookdateInput[1];

  // console.log('BookdateInput');
  // console.log(bookdateInput);
  // console.log('periode');
  // console.log("'"+period+"'");
  // console.log('periode split');
  // console.log("'"+periodeInputCheck+"'");

  if ("'" + period + "'" !== "'" + periodeInputCheck + "'") {
   alert('Periode Berbeda Dengan Bookdate!');
   return false;
  }


  if ((ttotamount == '') || (ttotamount == '0')) {
   alert('Data Belum Di masukkan');
   return false;
  }
  if ($('#tdesc').val() == '') {
   alert('Deskripsi Belum Di masukkan');
   return false;
  }
  if ($('#book_date').val() == '') {
   alert('Book Date Belum Di masukkan');
   return false;
  }
  if ($('#due_date').val() == '') {
   alert('Book Date Belum Di masukkan');
   return false;
  }

  if ($('#cboaccno option:selected').val() == '') {
   alert('Account Belum Di masukkan');
   return false;
  }



 });

 $('#btstore').click(function() {
  $('#dlgbisnisunit').modal({
   show: true
  });
  var postForm = { //Fetch form data
   'vbisnisunit': $('#hbisnisunit').val()
  };
  $.ajax({
   url: '<?php echo site_url('refunduknown/refunduknown/isidialogstore')?>',
   async: false,
   type: "POST",
   data: postForm,
   dataType: "html",
   success: function(data) {
    $('#dlgbisnis').html(data);
   }
  })

 });

 $('#bttradename').click(function() {
  $('#dlgbisnisunit').modal({
   show: true
  });
  var postForm = { //Fetch form data
   'vbisnisunit': $('#hbisnisunit').val(),
   'vstore': $('#hstore').val(),
   'type': ''
  };
  $.ajax({
   url: '<?php echo site_url('refunduknown/refunduknown/isidialogtradename')?>',
   async: false,
   type: "POST",
   data: postForm,
   dataType: "html",
   success: function(data) {
    $('#dlgbisnis').html(data);
   }
  })
 });

 $('#bttradenamedetil').click(function() {
  $('#dlgbisnisunit').modal({
   show: true
  });
  var postForm = { //Fetch form data
   'vbisnisunit': $('#hbisnisunit').val(),
   'vstore': $('#hstore').val(),
   'type': 'detil'
  };
  $.ajax({
   url: '<?php echo site_url('refunduknown/refunduknown/isidialogtradename')?>',
   async: false,
   type: "POST",
   data: postForm,
   dataType: "html",
   success: function(data) {
    $('#dlgbisnis').html(data);
   }
  })
 });

 $('#btacc').click(function() {
  $('#dlgbisnisunit').modal({
   show: true
  });
  var postForm = { //Fetch form data
   'vbisnisunit': $('#hbisnisunit').val()
  };
  $.ajax({
   url: '<?php echo site_url('refunduknown/refunduknown/isidialogaccount')?>',
   async: false,
   type: "POST",
   data: postForm,
   dataType: "html",
   success: function(data) {
    $('#dlgbisnis').html(data);
   }
  })
 });

 $('#dlgbisnisunit').on('shown.bs.modal', function(e) {
  $($.fn.dataTable.tables(true)).DataTable()
   .columns.adjust();
 });

 $("#chkbisnis").click(function() {
  var checked_status = this.checked;
  if (checked_status == true) {
   $("#btbisnisunit").removeAttr("disabled");
  } else {
   $("#btbisnisunit").attr("disabled", "disabled");
   $("#tbisnisunit").val("");
   $("#hbisnisunit").val("");
  }
 });

 $("#chkstore").click(function() {
  var checked_status = this.checked;
  if (checked_status == true) {
   $("#btstore").removeAttr("disabled");
  } else {
   $("#btstore").attr("disabled", "disabled");
   $("#tstore").val("");
   $("#hstore").val("");
  }
 });

 $("#chktrade").click(function() {
  var checked_status = this.checked;
  if (checked_status == true) {
   $("#bttradename").removeAttr("disabled");
   $("#chktradedetil").prop("checked", true);
   $("#bttradenamedetil").removeAttr("disabled");
  } else {
   $("#bttradename").attr("disabled", "disabled");
   $("#ttradename").val("");
   $("#htradename").val("");
   $("#ttenant").val("");
   $("#htenant").val("");
   $("#chktradedetil").prop("checked", false);
   $("#bttradenamedetil").attr("disabled", "disabled");
  }

 });

 $("#chktradedetil").click(function() {
  var checked_status = this.checked;
  if (checked_status == true) {
   $("#bttradenamedetil").removeAttr("disabled");
  } else {
   $("#bttradenamedetil").attr("disabled", "disabled");
   $("#ttradenamedetil").val("");
   $("#htradenamedetil").val("");
   //$("#ttenantdetil").val("");
   //$("#htenantdetil").val("");
  }
 });

 $("#chkacc").click(function() {
  var checked_status = this.checked;
  if (checked_status == true) {
   $("#btacc").removeAttr("disabled");
  } else {
   $("#btacc").attr("disabled", "disabled");
   $("#tacc").val("");
   $("#haccount").val("");
  }
 });

 //baru

 $('#cbpayment').select2({
  dropdownCssClass: 'custom-dropdown'
 });
 $('#dlgBank').select2({
  dropdownCssClass: 'custom-dropdown'
 });

 $('#cbpayment').on('select2:open', function(e) {
  $('.custom-dropdown').parent().css('z-index', 99999);
 });
 $('#dlgBank').on('select2:open', function(e) {
  $('.custom-dropdown').parent().css('z-index', 99999);
 });


 $('#cbaccpenerimaan').select2({
  dropdownCssClass: 'custom-dropdown'
 });

 $('#cbaccpenerimaan').on('select2:open', function(e) {
  $('.custom-dropdown').parent().css('z-index', 99999);
 });

 $('#cboperiode').select2({
  dropdownCssClass: 'custom-dropdown'
 });

 $('#cboperiode').on('select2:open', function(e) {
  $('.custom-dropdown').parent().css('z-index', 99999);
 });

 $('#cboperiode').on('select2:open', function(e) {
  $('.custom-dropdown').parent().css('z-index', 99999);
 });


 $('#cboaccno').select2({
  dropdownCssClass: 'custom-dropdown'
 });


 $("#book_date").change(function() {
  var date = new Date($("#book_date").val()),
   days = 19;

  if (!isNaN(date.getTime())) {
   date.setDate(date.getDate() + days);

   var yyyy = date.getFullYear().toString();
   var mm = (date.getMonth() + 1).toString(); // getMonth() is zero-based
   var dd = date.getDate().toString();
   var hasil = yyyy + "-" + (mm[1] ? mm : "0" + mm[0]) + "-" + (dd[1] ? dd : "0" + dd[0]); // padding
   $("#due_date").val(hasil);
  } else {
   alert("Invalid Date");
  }
 });

 $("#DgvDetil tbody").on('change', "input[type='checkbox']", function(e) {
  var idr = 0;
  var $row = $(this).closest("tr");

  $("input:checkbox[id^='chkDebet']").not(this).prop('checked', false); 
  var idr_c = $row.find(".clssisaidr").val();
  idr_c = idr_c.replace(/\,/g, '');
  idr_c = parseInt(idr_c);
  if ($(this).prop("checked") == true) {
   idr = idr_c;
   countCheckHeader = parseInt(countCheckHeader) + 1;
   idr_header = parseInt(idr_header) + parseInt(idr);
  }
  if ($(this).prop("checked") == false) {
   idr_header = parseInt(idr_header) - parseInt(idr_c);
   countCheckHeader = parseInt(countCheckHeader) - 1;
  };

  // console.log('dari event checkbox click [debet]');
  // console.log(idr); 

  $('#deposittotal').val(idr_header);
  $('#deposittotal').number(true, 0);
 });
 

 $("#DgvDetil tbody").on('change', "input[id='jurnaldetil_idr']", function(e) {
 
  var idr = 0; 
  var $row = $(this).closest("tr");
  idr = $row.find("#jurnaldetil_idr").val();
  idr = idr.replace(/\,/g, '');

  idr_detilaging = parseInt(idr_detilaging) + parseInt(idr);
  console.log('dari event texchange');
  console.log(idr_detilaging);
  $('#jurnaldetil_idr').number(true, 0); 
  $row.find("#jurnaldetil_idr").number(true, 0); 
 });

 var date = new Date();
 date.setDate(date.getDate() - 32);
 $('.input-group.date').datepicker({
  maxViewMode: 1,
  clearBtn: true,
  orientation: "bottom auto",
  todayHighlight: true,
  startView: 0,
  startDate: date,
  autoclose: true,
 });

});



$(function() {
 $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
});		
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
  font-weight: bold;
}


.tableFixHead          { overflow-y: auto; height: 450px; }
.tableFixHead thead th { position: sticky; top: 0; }



</style>        

                    <!-- /.popup-template -->
                    <div class="modal fade" id="tempdialog" tabindex="-1" role="basic" aria-hidden="true">
                      <div class="modal-dialog" style="width:70%;">
                        <div class="modal-content">
                          <div class="modal-header" >
                             <h4 class="modal-title">
                              Refund Process
                            </h4>
                          </div>
                          <div class="modal-body">
                           
                           
                            
                            
                              <table style="width:100%" class="table" cellpadding="0" cellspacing="0">

    <tr>
   	 	<td valign="top">
        	<table style="width:100%" >
            <tr>
            	<td height="63" valign="top"><input type="checkbox" name="checkbox" id="checkbox"/></td>
                <td valign="top">ID(s)</td>
                <td valign="top"><textarea name="textarea" id="textarea" cols="50" rows="2" class="form-control input-sm"></textarea></td>
            </tr>
			<!--
            <tr>
              <td valign="middle"><input type="checkbox" name="checkbox2" id="checkbox2" /></td>
              <td valign="middle">Start date</td>
              <td valign="middle">
              <div class="input-group date" data-provide="datepicker">
    				<input type="text" class="form-control input-sm" style="width:270px">
    				<div class="input-group-addon">
        				<span class="glyphicon glyphicon-th"></span>
    				</div>
			 </div>
              </td>
            </tr>
            <tr>
              <td valign="middle"><input type="checkbox" name="checkbox2" id="checkbox2" /></td>
              <td valign="middle">End date</td>
              <td valign="middle">
              <div class="input-group date" data-provide="datepicker">
    				<input type="text" class="form-control input-sm" style="width:270px">
    				<div class="input-group-addon">
        				<span class="glyphicon glyphicon-th"></span>
    				</div>
			 </div>
              </td>
            </tr>
			-->
            <tr>
              <td valign="middle"><input type="checkbox" name="checkbox2" id="checkbox2" /></td>
              <td valign="middle">Invoice Id</td>
              <td valign="middle"><input type="text" class="form-control input-sm" style="width:309px"></td>
            </tr>
            </table>
        </td>
        <td valign="top"><table style="width:100%">
            <tr>
            	<td valign="top"><input type="checkbox" name="chkbisnis" id="chkbisnis" /></td>
                <td valign="top">Business Unit</td>
                <td valign="top"><button type="button" class="btn btn-primary btn-sm" id="btbisnisunit"  disabled><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></td>
                <td valign="top" align="right"><input value="" type="text" name="tbisnisunit" id="tbisnisunit" class="form-control input-sm" style="width:290px" readonly  /></td>
            </tr>
            <tr>
              <td valign="top"><input type="checkbox" name="chkstore" id="chkstore" /></td>
              <td valign="top">Store</td>
              <td valign="top"><button type="button" class="btn btn-primary btn-sm" id="btstore" disabled><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></td>
              <td valign="top" align="right"><input value="" type="text" name='tstore' id='tstore' class="form-control input-sm" style="width:290px" readonly /></td>
            </tr>
            <tr>
              <td valign="middle"><input type="checkbox" name="chktrade" id="chktrade" /></td>
              <td valign="middle">Trade Name</td>
              <td valign="middle"><button type="button" id='bttradename' class="btn btn-primary btn-sm" disabled><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></td>
              <td valign="middle" align="right"><input type="text" name="ttradename" id="ttradename" class="form-control input-sm" style="width:290px" disabled/></td>
            </tr>
            <tr>
              <td valign="middle"><input type="checkbox" name="chktenant" id="chktenant" checked disabled /></td>
              <td valign="middle">Tenant</td>
              <td valign="middle"><button type="button" id="bttenant" class="btn btn-primary btn-sm" disabled><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></td>
              <td valign="middle" align="right"><input type="text" name='ttenant' id='ttenant' class="form-control input-sm" style="width:290px" disabled/></td>
            </tr>
			<!--
            <tr>
              <td valign="middle"><input type="checkbox" name="chkacc" id="chkacc" /></td>
              <td valign="middle">Account</td>
              <td valign="middle"><button type="button" id="btacc" class="btn btn-primary btn-sm" disabled><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button></td>
              <td valign="middle" align="right"><input type="text" name="tacc" id="tacc" class="form-control input-sm" style="width:290px" disabled/></td>
            </tr>
			-->
            <tr>
              <td valign="top">&nbsp;</td>
              <td valign="top">&nbsp;</td>
              <td valign="top">&nbsp;</td>
              <td valign="top" align="right"><button class="btn btn-primary btn-sm" id="btloadheader" type="button"><i class="fa fa-magic mr-1"></i>Load</button></td>
            </tr>

         </table>
         </td>
    </tr>
</table>  
                                       <div class="nav-tabs-custom">
											<ul class="detil nav nav-tabs">
											  <li class="active"><a href="#tab_0" id="vtab_0" data-toggle="tab" role= "tab">List</a></li> 
											</ul>
											<div class="tab-content"> 
											<div class="tab-pane active" id="tab_0">
												<div class ="table-responsive">  
													<div id="tap1" style="text-align:center"><img src="<?php echo base_url('assets/img/ajax-loader.gif');?>" width="147" height="70">
													</div>
												  <table style="width:100%" >
													  <tr>
													  <td align="right">
													  <!--<button type="button" class="btn btn-primary btn-sm" id="btnverify"><i class="fa fa-magic mr-1"></i>Verify</button>-->
													  </td>
													  </tr>
												  </table>
													<table id="DgvDetil" class="table table-fixed nowrap dataTable no-footer compact"  >
														<thead>
														   <tr>
															 <th bgcolor='#3c8dbc'  style='background: #0096d5; color: white;'>Pilih</th>
															 <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Jurnal ID</th>
															  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Line</th>
															  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>BookDate</th>
															  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>DueDate</th>
															  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Descr</th> 
															  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Amount</th>
															  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>AmountForeign</th>
															  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Rate</th>
															  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Sisa</th>
															  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>SisaForeign</th> 
															  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Branch</th>
															  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Strukturunit</th>
															  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Rekanan</th> 
															  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Shopname</th>
														  </tr> 
														</thead>
														<tbody id="datgridH">
														 </tbody>
													</table>
												</div> 
											 </div>
												<div class="tab-pane" id="tab_1">
													  <div class ="table-responsive">                                             
														  <table style="width:100%" >
															  <tr>
															  <td align="right"><button type="button" class="btn btn-danger btn-sm" id="btnremove"><i class="fa fa-remove mr-1"></i>&nbsp;Remove</button></td>
															  </tr>
														  </table> 
													 </div>
												</div>
												<div class="tab-pane" id="tab_2"> 
													<div class="portlet-body"> 
													</div>    
												</div> 
											</div>
                                       </div> 
                              <table style="width:100%" id="tblDlgFooter" >
								  <tr>
									<td> &nbsp; </td>
									<td> &nbsp; </td>
								  </tr>
								  <tr>
									<td style="width:12px;"> Account: </td>
									<td><?php echo form_dropdown('penerimaanbank', $penerimaanbank, '', 'id="dlgBank" class="form-control input-sm" style="width:43%;"'); ?> </td>
								  </tr> 
								  <tr>
									<td> &nbsp; </td>
									<td align="right">   
										<input type="hidden" name="txtnilamount" class="form-control input-sm" style="width:200px" readonly  />
									</td>
								  </tr> 
								   <tr>
									<td> &nbsp; </td>
									<td> &nbsp; </td>
								  </tr> 
								  <tr>
									 <td align="right"> &nbsp; </td>
									 <td align="right">
										 <button type="button" class="btn dark btn-outline btn-sm" data-dismiss="modal">Cancel</button>&nbsp;&nbsp;
										 <button class="btn btn-primary btn-sm" type="button" id="btterima" ><i class="fa fa-magic mr-1"></i>Refund</button>
									 </td>
								  </tr>  
							  </table> 
                            
                          </div>
                         
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>


				  <div class="modal fade" id="dlgbisnisunit" data-backdrop="static">
                      <div class="modal-dialog" style="width:35%;">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            </button>
                            <h4 class="modal-title">
                              Business Unit
                            </h4>
                          </div>
                          <div class="modal-body"> 
								<div id='dlgbisnis'>
								</div>      
								<br /> 
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline btn-sm" data-dismiss="modal">
                              Close
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
                          <a href="<?php echo base_url('index.php/refunduknown/refunduknown/refundlist'); ?>" id='tablist'> LIST </a>
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
                         <form action="<?php echo site_url('refunduknown/refunduknown/saverefund');?>" method="post" id='myform'>
                          <input type="hidden" name="hbisnisunit" id="hbisnisunit" value=""/>
							<input type="hidden" name="hstore" id="hstore" value=""/>
							<input type="hidden" name="htradename" id="htradename" value=""/>
							<input type="hidden" name="htenant" id="htenant" value=""/>
							<input type="hidden" name="haccount" id="haccount" value=""/>
                            <input type="hidden" name="hdebtor" id="hdebtor" value=""/>
                            <input type="hidden" name="hshipline" id="hshipline" value=""/>
                            <input type="hidden" name="tsruktur_id" id="tsruktur_id" value=""/>
                            <input type="hidden" name="hsub1" id="hsub1" value=""/>
                            <input type="hidden" name="hsub2" id="hsub2" value=""/>
                            <input type="hidden" name="hpayment" id="hpayment" value=""/>
                            <input type="hidden" name="txtisi" id="txtisi"/>
                            <input type="hidden" name="txtnilamount" id="txtnilamount"/>
                            <?php
                    if(isset($result)){
                     //print_r($result);
                     foreach($result as $row){ ?>
                    <div class="row">
                      <div class="col-md-12">
                     <div style="color:red"> <?php echo validation_errors(); ?> </div>
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>ID</label>
                                      <input  type="text" id="looid" name="loo_id" class="form-control input-sm" value="<?php echo $row->loo_id;?>" readonly>
                                    </div>
                                  </div>
                                  <!-- /.form group -->

                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Business Unit</label>
                                        <input type="hidden" id = "tbusnis_id" name="tbusnis_id" class="form-control input-sm" style="width:50px" >
                                        <input type="text" id = "tbusnis" name="tbusnis" class="form-control input-sm" readonly>
                                    </div>
                                  </div>
                                
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Channel</label>
                                        <input value="TSMB" type="text" id = "tchanel" name="tchanel" class="form-control input-sm" readonly>
                                    </div>
                                  </div>
                                    
                                 
                                  <div class="col-md-4 form-group form-group-sm row">
                                    <div class="col-xs-12">
                                      <label>Periode</label>
                                                          <?php echo form_dropdown('cboperiode',$periode,$periode_,'id="cboperiode" class="form-control" style="width: 100%;" required'); ?>  
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Store</label>
                                        <input type="hidden" id = "txtstore_id" name="txtstore_id" class="form-control input-sm"  readonly>
                                        <input type="text" id = "txtstore" name="txtstore" class="form-control input-sm"  readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Jurnal Type</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="RF" readonly>
                                    </div>
                                  </div>
                                  
                                 <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Book Date</label>
                                      <div class="input-group date"  data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                          <input type="text" class="form-control input-sm pull-right" id="book_date" name="book_date" autocomplete="off" >
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Struktur Unit</label>
                                        <input type="hidden" id = "tsrukturname_id" name="tsrukturname_id" class="form-control input-sm"  readonly>
                                        <input type="text" id = "tsrukturname" name="tsrukturname" class="form-control input-sm"  readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Source</label>
                                        <input type="text" id = "loo_term" name="loo_term" class="form-control input-sm" value="RF-ListUkn" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Due Date</label>
                                      <div class="input-group date">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                          <input type="text" class="form-control input-sm pull-right" id="due_date" name="due_date" readonly>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Tenant</label>
                                        <input type="hidden" id = "ttenanname_id" name="ttenanname_id" class="form-control input-sm"  readonly>
                                        <input type="text" id = "ttenanname" name="ttenanname" class="form-control input-sm"  readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>No Faktur</label>
                                        <input type="text" id = "tnofaktur" name="tnofaktur" class="form-control input-sm" value="REFUND" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group form-group-sm row" >
                                    <div class="col-xs-12">
                                      <label>Account No</label>
                                          <?php echo form_dropdown('cboaccno',$penerimaan,'','id="cboaccno" class="form-control input-sm" style="width: 100%;" required'); ?> 
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Contract No</label>
                                        <input type="text" id ="tcontractno" name="tcontractno" class="form-control input-sm" readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Currency</label>
                                        <input type="text" value="1.00" id = "tcurrency" name="tcurrency" class="form-control input-sm"  readonly>
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Description</label>
                                        <textarea class="form-control input-sm" name="tdesc" id="tdesc" ></textarea>
                                    </div>
                                  </div>
                                  
                                    <div class="col-md-4 form-group row">
                                    <div class="col-xs-12">
                                      <label>Exchange Rate</label>
                                        <input type="text" value="1.00" id = "texchange" name="texchange" class="form-control input-sm" readonly>
                                    </div>
                                  </div>
                                  
                                 <div class="row"> &nbsp; </div>
                                 <div class="row"> &nbsp; </div>
                                  <div class="col-md-12">
                                      <!-- Custom Tabs -->
                                      <div class="nav-tabs-custom">
                                        <ul class="detil nav nav-tabs">
                                          <li class="active"><a href="#xtab_1" data-toggle="tab" role= "tab">Penerimaan(D)</a></li>
                                          <li><a href="#vtab_2" data-toggle="tab" role = "tab">Pembayaran(K)</a></li>
                                          <li><a href="#vtab_3" data-toggle="tab" role = "tab">Reference</a></li>
                                          <li><a href="#vtab_5" data-toggle="tab" role = "tab">Record</a></li>
                                        </ul>
                                        <div class="tab-content">
                                          <div class="tab-pane active" id="xtab_1">
                                              
                                               <div class ="table-responsive">                                   
                                              <table id="table_d" class="table table-striped table-hover nowrap dataTable no-footer compact">
                                                <thead>
                                                   <tr>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Line</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Description</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Curr</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>IDR</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Foreign</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Rate</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Ref ID</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Ref Line</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Payment Type</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Bank</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>No Bilyet</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Tgl Bilyet</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Tgl Efektif</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Penerima</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Agreement Type</th>
                                                  </tr>
                                                   
                                                </thead>
                                                <tbody>
                                                  
                                                </tbody>
                                              </table>
                                          
                                             </div>
                                          </div>
                                            <div class="tab-pane" id="vtab_2">
                                             <div class ="table-responsive">
                                             <table id="table_k"  class="table table-striped table-hover nowrap dataTable no-footer compact" >
                                                <thead>
                                                   <tr>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Line</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Account Name&nbsp;&nbsp;&nbsp;</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Description</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Curr</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>IDR</th> 
													  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Foreign</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Rate</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Region</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Branch</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Struktur Unit</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Rekanan</th>                                                      
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Ref ID</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Ref Line</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Channel</th>
                                                   </tr>
                                                                                                    
                                                   
                                                </thead>
                                                <tbody>
												 </tbody>
                              </table>  
                              
                                             </div>
                                            </div>
                                          <div class="tab-pane" id="vtab_5">
                                            <div class="row">
                                             <div class="col-md-6">
                                              <div class="col-xs-8">
                                                 <label>Create By</label>
                                                 <input type="text" id= "_createby" name="_createby" class="form-control" value="<?php echo $this->session->userdata('username');?>">
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
                                          
                                          <div class="tab-pane" id="vtab_3">
                                            <div class="row">
                                            
                                            
                                             
                                             </div>
                                          </div>
                                          <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                      </div>
                                      <!-- nav-tabs-custom -->
                                    </div>
                                    <!-- /.col -->
									<div class="row"> &nbsp; </div>
									<div class="row"> &nbsp; </div>
                                      <div class="col-xs-9">
                                    <span class="pull-right">Jumlah : </span>
                                		</div>
                                    <div class="col-xs-3">
                                    <input type="text" style="text-align:right" name="ttotamount" id="ttotamount" class="form-control input-sm" readonly />
                                </div>
                                <div class="col-xs-12">
                                    <br /><span class="pull-right"><input type="submit" value="SUBMIT" name="btsubmit" class="btn btn-sm btn-info" /></span>
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
            </div>
              <!-- END OF CONTENT -->
