<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

		if ($this->uri->segment(3)=="" || $this->uri->segment(3)=="load"){
?>
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

 
	$('#JTable').DataTable({
      "scrollY": "400px",
      "scrollX": true,       
      "pageLength": 20,
      "processing": true, 
      "serverSide": true, 
      "order": [],
      "searching" : true,
	  "ordering": false, 
	  "bLengthChange": false,
		<?php 
		if ($_POST){
		?>
		"ajax": {
			"url": "<?php echo base_url('index.php/').$this->uri->segment(1).'/'.$this->uri->segment(2).'/controler_gridlist'; ?>",
			"type": "POST",
			"data": { 
				jurnal_id :  "<?php echo $this->input->post("sID");?>",
				jurnal_source :  "<?php echo $this->input->post("jSource");?>",
				jurnaltype_id :  "<?php echo $this->input->post("jType");?>",
				periode_id :  "<?php echo $this->input->post("sPeriode");?>",
				jurnal_createby :  "<?php echo $this->input->post("sCreateby");?>",
			},
			"dataType": 'json'
		},	
		<?php
		}else{
		?>
		"ajax": {
			"url": "<?php echo base_url('index.php/').$this->uri->segment(1).'/'.$this->uri->segment(2).'/controler_gridlist'; ?>",
			"type": "POST"  
		},
		<?php	
		}
		?>	
	
      "columnDefs": [
        {
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
        // {
          // "targets": aCenter,
          // "className": "text-center"
        // },
        // {
          // "targets": aRight,
          // "className": "text-right"
        // }        
      ], 
	  // dom:'rtip'
      });
	  
    //new $.fn.dataTable.FixedColumns( oTable, { rightColumns: 1 } );
  	$('#tabedit').click(function() {
  		alert('Please, select data from list');
  		$("#tablist").trigger('click');
  	});
		
	$('.searching').select2();
	
	/* reload */
    $('#btnReload').click(function() {  
	console.log('searching');
        
	
	});
	
	$('#isID').on('change', function() {      
        if($(this).is(':checked')){
          $('#sID').prop('readonly', false);          
        }else{      
          $('#sID').prop('readonly',true);          
        }
    }); 

    $('#isCreate').on('change', function() {      
        if($(this).is(':checked')){
          $('#sCreateby').prop('readonly', false);          
        }else{      
          $('#sCreateby').prop('readonly',true);          
        }
    });  

    $('#isPeriod').on('change', function() {      
        if($(this).is(':checked')){
          $('#sPeriode').prop('readonly', false);          
        }else{      
          $('#sPeriode').prop('readonly',true);          
        }
    });

    $('#isJtype').on('change', function() {      
        if($(this).is(':checked')){
          $('#jSource').prop('disabled', false);          
        }else{      
          $('#jSource').prop('disabled',true);          
        }
    });

    $('#jSource').val([]);
    $('#jSource').select2({placeholder: 'Select an Option'});
    $('#jSource').on('select2:select', function (e) {
        var source  = e.params.data;
        var jtype   = source.id.substring(0,2);
        //console.log(jtype);

        $('#isTSource').prop( "checked", true );
        $('#tSource').val( source.id );
        $('#jType').val(jtype);
        //$('#_hTradeLine').val(bra.rekananshipping_line);
    });
}); 
</script>
<?php
		} 
		if ($this->uri->segment(3)=="add" || $this->uri->segment(3)=="edit"){
?>
<script src="<?php echo base_url('/assets/js/inputmask/inputmask.bundle.js');?>"></script>
<script src="<?php echo base_url('/assets/js/jquery.number.min.js');?>"></script>
<script src="<?php echo base_url('/assets/js/jquery.maskedinput.min.js');?>"></script>
<script> 
 
	$(document).ready(function(){
		$.fn.modal.Constructor.prototype.enforceFocus = function () {}; 
		$.fn.select2.defaults.set( "theme", "bootstrap" );
		// $("#dt-basic-debet").hide();
		
		<?php if($this->uri->segment(3) == 'edit' ) { ?> 
			calc_form();
			$("#tabedit").trigger('click'); 
		<?php }
		elseif($this->uri->segment(3)=="add")
		{
		?> 
		$("#tabdata").trigger('click');
		$("#btnLoadDlg").click(function(){
			$("#dt-basic-debet > tbody").empty();	
			$("#dt-basic-credit > tbody").empty();
			$("#txtRefund").val('0');
			$("#txtInvoice").val('0');
			$("#txtSelisih").val('0');
			$("#dlg_amount").val('0');
			dlgDebet();   
		});	
		$('#tabedit').click(function() {
			alert('Please, select data from list');
			$("#tablist").trigger('click');
			return;
		});
		var date = new Date();
	   	var yyyy = date.getFullYear().toString();
		var mm = (date.getMonth()+1).toString(); // getMonth() is zero-based
		var dd  = date.getDate().toString();
		var hasil = (mm[1]?mm:"0"+mm[0]) + "/" + (dd[1]?dd:"0"+dd[0])+ "/"+  yyyy   ; // padding
		$("#jurnal_duedate").val(hasil) ;
		$("#jurnal_bookdate").val(hasil);
		<?php } ?>
		
		/** variabel akses global **/
		var g_rekanan_name = '';
		var g_rekanan_id = '';
		var g_rekananshipping_line = 0;
		var g_rekananshipping_name = 0;
		var g_strukturunit_id = '';
		var g_region_id = '';
		var g_branch_id = '';
		/** variabel akses global **/
			
		$(":input").inputmask();
		$('#pleasewait').hide();  
		
		
		
		$("#btDlg").click(function(){
			$(":input").inputmask();
			$("#dt-basic-debet tbody").empty();	
			$("#dt-basic-credit tbody").empty();
			var store = $("#ibranch").val();
			var rekanan = $("#cboTenantName").text().trim();
			var trade = $("#cboTradeName").text().trim();
			var bookdate = $("#jurnal_bookdate").val();
			var duedate = $("#jurnal_duedate").val();
			var struktur = $("#istruk").val();
			var descr = $("#jurnal_descr").val();
			var region = $("#iregion").val();
			
			if(struktur == '')
			{
				alert('Struktur Unit Belum Di Pilih!');
				return;
			}
			// if(descr == ' ')
			// {
				// alert('Description Belum Di isi!');
				// return;
			// }
			if(store == '')
			{
				alert('Store Belum Di Pilih!');
				return;
			}
			if(rekanan == '')
			{
				alert('Rekanan Belum Di Pilih!');
				return;
			}
			if(trade == '')
			{
				alert('Trade/Brand Belum Di Pilih!');
				return;
			}
			if(region == '')
			{
				alert('Business Unit Belum Di Pilih!');
				return;
			}
			if(bookdate == '')
			{
				alert('Book Date Belum Di Isi!');
				return;
			}
			if(duedate == '')
			{
				alert('Due Date Belum Di Isi!');
				return;
			}
			 
			// calc_dlg();
			$('#dlgModal').modal('show');
			$('#tab_dgv-1').trigger('click');
			$('#btnSaveDlg').focus();
			
			$("#cboTradeDlg").text($("#cboTradeName").val());
			$("#cboRekananDlg").text($("#cboTenantName").val());
			
			$("#cboTradeNameDlg").text($("#cboTradeName").text());
			$("#cboRekananNameDlg").text($("#cboTenantName").text());
			
			$('#btnVerifyRows').css({display:'none'});
			
			var rowDebet = $('#dt-basic-debet tbody tr').length;
			  
			if ( $.fn.dataTable.isDataTable('#dt-basic-debet') ) { 
				if(rowDebet > 0)
				{ 
					$('#btnVerifyRows').css('display','block');
					$('#btnVerifyRows').show();
					$("#dt-basic-debet > tbody").empty();
					$("#dt-basic-debet").dataTable().fnDestroy(); 
				}   
			} 
			$("#dt-basic-debet").dataTable().fnDestroy(); 	
			$("#dt-basic-debet").dataTable({
			  "scrollY": "200px",
			  "scrollX": true,       
			  "pageLength": 100,
			  "processing": false, 
			  "serverSide": false,  
			  "searching" : true,
			  "ordering": false, 
			  "bLengthChange": false
			});
			$('.sisa_idr').inputmask({'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2,'digitsOptional': false, 'placeholder': '0.00', rightAlign : true,clearMaskOnLostFocus: !1});  
			$("#dt-basic-debet > tbody").empty();	
			$("#dt-basic-credit > tbody").empty();
			$("#txtRefund").val('0');
			$("#txtInvoice").val('0');
			$("#txtSelisih").val('0');
			$("#dlg_amount").val('0');
		});
		 
		$("#btnVerifyRows").click(function(){ 
			$(":input").inputmask();
			$('#pleasewait').show();
			
			$("#dlg_amount").val('0');
			$("#txtInvoice").val('0');
			$("#txtSelisih").val('0');
			
			var jmlChkDlgDebet = $('.chkDebet:checked').length;
			if( jmlChkDlgDebet <= 0 )
			{
				alert('Deposit Belum DiPilih!');
				$('#pleasewait').hide();
				return;
			}
			else
			{ 	
				$('#vtab_dlg2').trigger('click'); 
				var idrDebet = parseFloat($('#txtRefund').val().replace(/,/g, "")); 
				console.log('idrDebet');
				console.log(idrDebet);
				$('#dlg_amount').val(idrDebet);
				$('#dlg_amount').inputmask({'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2,'digitsOptional': false, 'placeholder': '0.00', rightAlign : true,clearMaskOnLostFocus: !1});
				
				$('#txtInvoice').val(idrDebet);
				
				$('#pleasewait').hide();
				
				var today = new Date();
				var dd = String(today.getDate()).padStart(2, '0');
				var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
				var yyyy = today.getFullYear();

				today = yyyy + '-' + mm + '-' + dd;
				$('#dlg_tgl_bilyet').val(today);
				$('#dlg_tgl_effectif').val(today);
			} 
			
		});	
		
		/** btn save change click pindah ke form utama **/
		/** proses validasi dan masukan ke grid form utama **/
		$("#btnSaveDlg").click(function(){
			$("#dgvdetilD > tbody").empty();	
			$("#dgvdetilK > tbody").empty();
			//grid form utama
			var tableDForm = $('#dgvdetilD');
			var tableKForm = $('#dgvdetilK');
			//grid dialog
			// var tableDlgD = $('#dt-basic-debet');
			var tableDlgD = $('#dt-basic-debet');
			//validasi grid dialog
			var chkD = $('.chkDebet:checked').length;
			if( chkD <= 0 )
			{
				alert('Data Belum DiPilih!');
				$('#pleasewait').hide();
				return;
			}
			
			var acc_penerimaan = $('#cbaccpenerimaan').val()
			if(acc_penerimaan == "")
			{
				alert('Penerimaan Belum DiPilih!');
				$('#pleasewait').hide();
				return;
			}
			  
			var selisihText =  parseFloat(($('#txtSelisih').val()).replace(/,/g, ""));
			var refundText = parseFloat(($('#txtRefund').val()).replace(/,/g, "")); 
			var invText = parseFloat(($('#txtInvoice').val()).replace(/,/g, "")); 
			var idrKreditForm = 0;
			
			if(refundText >= invText)
			{
				idrKreditForm = invText;
			} 
			
			//proses dari dialog  
			//set variabel g_
			g_rekanan_name = $("#cboTenantName option:selected").text();
			g_rekanan_id = $("#cboTenantName").val();
			g_rekananshipping_line = $('#rekananshipping_line').val();
			g_rekananshipping_name = $("#cboTradeName option:selected").text();
			g_strukturunit_id = $("#istruk").val(); 
			g_region_id = $("#iregion").val();
			g_branch_id = $("#ibranch").val(); 
			g_channel_id = $("#channel_id").val(); 
			g_descr = $("#jurnal_descr").val(); 
			 
			//-- DEBIT START--//		
			
			//debit dialog ke debit form
			var idrinv = 0; 
			var linenumD=0;
			
			tableDlgD.find('tr').each(function (i) { 
				var chkbox = $(this).find('input[type="checkbox"]');
				if(chkbox.length) {
					var status = chkbox.prop('checked');
					if (status==true){ 
					//debet dialog ke debet form 
					var row = $(this).closest("tr");  
					var maxD=GetMaxNum("#dgvdetilD", 0); 
					maxD = ( (maxD == 0) ? 0 : maxD );
					linenumD= Number(maxD) + 10;
					
					//variabel yang dibutuhkan ke grid debet form 
					var acc_id = row.find('.dlgD_acc_id').val(); 
					var acc_name = row.find('.dlgD_acc_name').val(); 
					g_descr = row.find('.dlgD_jurnal_descr').val();
					$('#jurnal_descr').val(g_descr);
					var descr = acc_name;   
					var ref_id= row.find('.dlgD_jurnal_id').val(); 
					var ref_line= row.find('.dlgD_jurnaldetil_line').val();
					var sisa_idr = row.find('.sisa_idr').val(); 
					// console.log('sisa_idr');
					// console.log(sisa_idr);
					sisa_idr = parseFloat((sisa_idr).replace(/,/g, ""));
					var sub1_id= row.find('.dlgD_sub1_id').val(); 
					var sub2_id= row.find('.dlgD_sub2_id').val(); 
					g_strukturunit_id = row.find('.dlgD_strukturunit_id').val(); 
					
					var html  = "";  
					html  += "<tr>"; 
						html  += "<td>";
							html  += linenumD; 
							html  += "<input type='hidden' name='d_jurnaldetil_line[]' value='"+linenumD+"' /> ";
						html  += "</td>"; 
						html  += "<td>"; 
							html  += acc_id+'-'+acc_name; 
						html  += "</td>"; 
						html  += "<td>";
							html  += "<input type='text' class='form-control input-sm d_jurnaldetil_descr' name='d_jurnaldetil_descr[]' value='"+g_descr+"' /> ";
						html  += "</td>";
						html  += "<td>";
							html  += parseFloat(sisa_idr).toLocaleString(undefined,{'minimumFractionDigits':2,'maximumFractionDigits':2})
						html  += "</td>"; 
						html  += "<td>";
							html  += ref_id;
						html  += "</td>";
						html  += "<td>";
							html  += ref_line; 
						//input text hidden u/ simpan informasi
						html  += "<input type='hidden' name='d_acc_id[]' value='"+acc_id+"' /> "; 
						html  += "<input type='hidden' name='d_jurnaldetil_idr[]' value='"+sisa_idr+"' class='d_idr'  /> ";
						html  += "<input type='hidden' name='d_rekanan_id[]' value='"+g_rekanan_id+"' /> ";
						html  += "<input type='hidden' name='d_rekananshipping_line[]' value='"+g_rekananshipping_line+"' /> ";
						html  += "<input type='hidden' name='d_ref_id[]' value='"+ref_id+"' /> ";
						html  += "<input type='hidden' name='d_ref_line[]' value='"+ref_line+"' /> "; 
						html  += "<input type='hidden' name='d_currency_id[]' value='IDR' /> ";
						html  += "<input type='hidden' name='d_jurnaldetil_foreign[]' value='0' /> ";
						html  += "<input type='hidden' name='d_jurnaldetil_foreignrate[]' value='1' /> ";
						html  += "<input type='hidden' name='d_channel_id[]' value='"+g_channel_id+"' /> ";
						html  += "<input type='hidden' name='d_region_id[]' value='"+g_region_id+"' /> ";
						html  += "<input type='hidden' name='d_branch_id[]' value='"+g_branch_id+"' /> ";
						html  += "<input type='hidden' name='d_strukturunit_id[]' value='"+g_strukturunit_id+"' /> "; 
						html  += "<input type='hidden' name='d_sub1_id[]' value='"+sub1_id+"' /> "; 
						html  += "<input type='hidden' name='d_sub2_id[]' value='"+sub2_id+"' /> "; 
						html  += "</td>";
						html  += '<td width="100">--</td>';
					html  += "</tr>"; 
					tableDForm.append(html); 
					} 
				};
			});	 
			//-- END DEBIT --//		
			
			//-- KREDIT --//  
			
			//variabel yang dibutuhkan ke grid kredit form
			var acc_id = $('#cbaccpenerimaan').val(); 
			var acc_name = $('#cbaccpenerimaan option:selected').text(); 
			var ref_id = '';
			var ref_line = 0; 
			
					var max=GetMaxNum("#dgvdetilK", 0); 
					max = ( (max == 0) ? 5 : max );
					linenum= Number(max) + 10; 
					
					var html  = "";  
					html  += "<tr>"; 
						html  += "<td>";
							html  += linenum;
							html  += "<input type='hidden' name='k_jurnaldetil_line[]' value='"+linenum+"' /> ";
						html  += "</td>"; 
						html  += "<td>"; 
							html  += acc_id+'-'+acc_name; 
						html  += "</td>"; 
						html  += "<td>";
							html  += acc_name;
						html  += "</td>";
						html  += "<td>"; 
							html  += parseFloat(idrKreditForm).toLocaleString(undefined,{'minimumFractionDigits':2,'maximumFractionDigits':2});
						html  += "</td>"; 
						html  += "<td>";
							html  += ref_id;
						html  += "</td>";
						html  += "<td>";
							html  += ref_line; 
						//input text hidden u/ simpan informasi
						html  += "<input type='hidden' name='k_acc_id[]' value='"+acc_id+"' /> ";
						html  += "<input type='hidden' name='k_jurnaldetil_descr[]' value='"+acc_name+"' /> ";
						html  += "<input type='hidden' name='k_jurnaldetil_idr[]' value='"+idrKreditForm+"' class='k_idr' /> ";
						html  += "<input type='hidden' name='k_rekanan_id[]' value='"+g_rekanan_id+"' /> ";
						html  += "<input type='hidden' name='k_rekananshipping_line[]' value='"+g_rekananshipping_line+"' /> ";
						html  += "<input type='hidden' name='k_ref_id[]' value='"+ref_id+"' /> ";
						html  += "<input type='hidden' name='k_ref_line[]' value='"+ref_line+"' /> ";
						html  += "<input type='hidden' name='k_channel_id[]' value='"+g_channel_id+"' /> "; 
						html  += "<input type='hidden' name='k_currency_id[]' value='IDR' /> "; 
						html  += "<input type='hidden' name='k_jurnaldetil_foreign[]' value='0' /> ";
						html  += "<input type='hidden' name='k_jurnaldetil_foreignrate[]' value='1' /> ";
						html  += "<input type='hidden' name='k_region_id[]' value='"+g_region_id+"' /> ";
						html  += "<input type='hidden' name='k_branch_id[]' value='"+g_branch_id+"' /> ";
						html  += "<input type='hidden' name='k_strukturunit_id[]' value='"+g_strukturunit_id+"' /> "; 
						html  += "<input type='hidden' name='k_sub1_id[]' value='' /> "; 
						html  += "<input type='hidden' name='k_sub2_id[]' value='' /> "; 
						//input text hidden u/ simpan informasi 
						html  += "</td>";
						html  += '<td width="100">--</td>';
						//<button id="btnDelete" title="delete" class="btn btn-outline-secondary btn-sm btn-icon waves-effect waves-themed"><i class="fa fa-trash"></i></button>
					html  += "</tr>"; 
					tableKForm.append(html);
					
			//-- END KREDIT --//
			
			$('#dlgModal').modal('hide');
			calc_form(); 
			
			});
		
		/** dialog add row account ( tambahan account di add row) **/
		$('#DlgIDR').inputmask({'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2,'digitsOptional': false, 'placeholder': '0.00', rightAlign : true,clearMaskOnLostFocus: !1}); 
		  
	   //fix modal force focus
	   $.fn.modal.Constructor.prototype.enforceFocus = function () {
		  var that = this;
		  $(document).on('focusin.modal', function (e) {
			 if ($(e.target).hasClass('select2-input')) {
				return true;
			 }

			 if (that.$element[0] !== e.target && !that.$element.has(e.target).length) {
				that.$element.focus();
			 }
		  });
	   };
		  
		$("#btdetilD").click(function(){ 
			$('#dlgAddRows').modal('show');
			$("#btDlgAddRows").attr("object","AddRowDebet");   
		});	
		$("#btdetilK").click(function(){ 
			$('#dlgAddRows').modal('show'); 
			$("#btDlgAddRows").attr("object","AddRowKredit"); 
		});	
		
		//key press jurnal descr header value masukan juga ke detil Debit descr
		$("#jurnal_descr").on('keyup',function(e){
			var tableDForm =  $('#dgvdetilD');
			var myDescr = $(this).val();
			console.log('EVENT KEY PRESS');
			var countRw = $('#dgvdetilD >tbody >tr').length;
			console.log('JML ROW');
			console.log(countRw);
			
			if( countRw > 0 )
			{
				tableDForm.find('tr').each(function (i) { 
					var detildescr = $(this).find('.d_jurnaldetil_descr');
					detildescr.val(myDescr);			
				});
			} 
		});
		
		$("#btDlgAddRows").click(function(){ 
			var classAttr = $("#btDlgAddRows").attr("object");
			//grid form utama
			var tableDForm = $('#dgvdetilD');
			var tableKForm = $('#dgvdetilK');
			var dlgRows_acc_id = $('#cboaccnoRows').val();
			var dlgRows_acc_name = $("#cboaccnoRows option:selected").text();;
			var dlgRows_idr = $('#DlgIDR').val();
			dlgRows_idr = parseFloat((dlgRows_idr).replace(/,/g, ""));
			//set variabel g_
			g_rekanan_name = $("#cboTenantName option:selected").text();
			g_rekanan_id = $("#cboTenantName").val();
			g_rekananshipping_line = $('#rekananshipping_line').val();
			g_rekananshipping_line = ((g_rekananshipping_line == '' ) ? $('#cboTradeName').val() : g_rekananshipping_line );
			g_rekananshipping_name = $("#cboTradeName option:selected").text();
			g_strukturunit_id = $("#istruk").val(); 
			g_region_id = $("#iregion").val();
			g_branch_id = $("#ibranch").val(); 
			g_channel_id = $("#channel_id").val();
			
			var dlg_sub2_id = ' '; 
			if(dlgRows_acc_id == '')
			{
				alert('Account Belum DiPilih!');
				return;
			}
			if((dlgRows_idr) == 0)
			{
				alert('Amount IDR Belum Di Isi!');
				return;
			}
			if(dlgRows_acc_name.toLowerCase().indexOf("unalloc") >= 0)
			{ 
				dlg_sub2_id = '0101';
			}
			  
			if(classAttr == 'AddRowDebet')
			{	
				var max=GetMaxNum('#dgvdetilD', 0);   
				var linenum = Number(max)+10;
				
				var html  = "";  
				html  += "<tr>"; 
					html  += "<td>";
						html  += linenum; 
						html  += "<input type='hidden' name='d_jurnaldetil_line[]' value='"+linenum+"' /> ";
					html  += "</td>"; 
					html  += "<td>"; 
						html  += dlgRows_acc_id+'-'+dlgRows_acc_name; 
					html  += "</td>"; 
					html  += "<td>";
						html  += dlgRows_acc_name;
					html  += "</td>";
					html  += "<td>";
						html  += parseFloat(dlgRows_idr).toLocaleString(undefined,{'minimumFractionDigits':2,'maximumFractionDigits':2});
					html  += "</td>";  
					html  += "<td>";
						html  += '';
					html  += "</td>";
					html  += "<td>";
						html  += 0;
					//input text hidden u/ simpan informasi
					html  += "<input type='hidden' name='d_acc_id[]' value='"+dlgRows_acc_id+"' /> ";
					html  += "<input type='hidden' name='d_jurnaldetil_descr[]' value='"+dlgRows_acc_name+"' /> ";
					html  += "<input type='hidden' name='d_jurnaldetil_idr[]' value='"+dlgRows_idr+"' class='d_idr' /> ";
					html  += "<input type='hidden' name='d_rekanan_id[]' value='"+g_rekanan_id+"' /> ";
					html  += "<input type='hidden' name='d_rekananshipping_line[]' value='"+g_rekananshipping_line+"' /> ";
					html  += "<input type='hidden' name='d_ref_id[]' value='' /> ";
					html  += "<input type='hidden' name='d_ref_line[]' value='0' /> ";
					html  += "<input type='hidden' name='d_channel_id[]' value='"+g_channel_id+"' /> "; 
					html  += "<input type='hidden' name='d_currency_id[]' value='IDR' /> ";
					html  += "<input type='hidden' name='d_currency_id[]' value='IDR' /> ";
					html  += "<input type='hidden' name='d_jurnaldetil_foreign[]' value='0' /> ";
					html  += "<input type='hidden' name='d_jurnaldetil_foreignrate[]' value='1' /> ";
					html  += "<input type='hidden' name='d_region_id[]' value='"+g_region_id+"' /> ";
					html  += "<input type='hidden' name='d_branch_id[]' value='"+g_branch_id+"' /> ";
					html  += "<input type='hidden' name='d_strukturunit_id[]' value='"+g_strukturunit_id+"' /> "; 
					//input text hidden u/ simpan informasi 
					html  += "</td>";
					html  += '<td width="100"><button id="btnDelete" title="delete" class="btn btn-outline-secondary btn-sm btn-icon waves-effect waves-themed"><i class="fa fa-trash"></i></button></td>';
				html  += "</tr>"; 
				tableDForm.append(html);
			}
			else if(classAttr == 'AddRowKredit'){ 
				var max=GetMaxNum('#dgvdetilK', 0);   
				var linenumK = Number(max)+10;	
				
				var html  = "";  
				html  += "<tr>"; 
				html  += "<td>";
					html  += linenumK;
					html  += "<input type='hidden' name='k_jurnaldetil_line[]' value='"+linenumK+"' /> ";
				html  += "</td>"; 
				html  += "<td>"; 
					html  += dlgRows_acc_id+'-'+dlgRows_acc_name; 
				html  += "</td>"; 
				html  += "<td>";
					html  += dlgRows_acc_name;
				html  += "</td>";
				html  += "<td>";
					html  += parseFloat(dlgRows_idr).toLocaleString(undefined,{'minimumFractionDigits':2,'maximumFractionDigits':2});
				html  += "</td>"; 
				html  += "<td>";
					html  += '';
				html  += "</td>";
				html  += "<td>";
					html  += 0;
				//input text hidden u/ simpan informasi 
				html  += "<input type='hidden' name='k_acc_id[]' value='"+dlgRows_acc_id+"' /> ";
				html  += "<input type='hidden' name='k_jurnaldetil_descr[]' value='"+dlgRows_acc_name+"' /> ";
				html  += "<input type='hidden' name='k_jurnaldetil_idr[]' value='"+dlgRows_idr+"' class='k_idr'  /> ";
				html  += "<input type='hidden' name='k_rekanan_id[]' value='"+g_rekanan_id+"' /> ";
				html  += "<input type='hidden' name='k_rekananshipping_line[]' value='"+g_rekananshipping_line+"' /> ";
				html  += "<input type='hidden' name='k_ref_id[]' value='' /> ";
				html  += "<input type='hidden' name='k_ref_line[]' value='0' /> "; 
				html  += "<input type='hidden' name='k_currency_id[]' value='IDR' /> ";
				html  += "<input type='hidden' name='k_jurnaldetil_foreign[]' value='0' /> ";
				html  += "<input type='hidden' name='k_jurnaldetil_foreignrate[]' value='1' /> ";
				html  += "<input type='hidden' name='k_channel_id[]' value='"+g_channel_id+"' /> ";
				html  += "<input type='hidden' name='k_region_id[]' value='"+g_region_id+"' /> ";
				html  += "<input type='hidden' name='k_branch_id[]' value='"+g_branch_id+"' /> ";
				html  += "<input type='hidden' name='k_strukturunit_id[]' value='"+g_strukturunit_id+"' /> ";
				html  += "<input type='hidden' name='k_sub1_id[]' value=' ' /> ";
				html  += "<input type='hidden' name='k_sub2_id[]' value='"+dlg_sub2_id+"' /> ";
				//input text hidden u/ simpan informasi 
				html  += "</td>";
				html  += '<td width="100"><button id="btnDelete" title="delete" class="btn btn-outline-secondary btn-sm btn-icon waves-effect waves-themed"><i class="fa fa-trash"></i></button></td>';
				html  += "</tr>"; 
				tableKForm.append(html); 
			}
			$('#dlgAddRows').modal('hide');
			calc_form();
		});		
		
		/** funct delete grid utama **/
		/** delete row **/ 
		$("#dgvdetilD").on('click','#btnDelete',function(){
			if (confirm("Are you sure to delete this row ?") == false) {
				  return false;
			  }
			$(this).closest('tr').remove();
			calc_form();
		});
		
		$("#dgvdetilK").on('click','#btnDelete',function(){
			if (confirm("Are you sure to delete this row ?") == false) {
				  return false;
			  }
			$(this).closest('tr').remove();
			calc_form();
		});
		
		/** multi row yang di checkbox **/
		<?php if ($this->uri->segment(3)=="add") { ?>
		$("#dt-basic-debet").on('click', "input[type='checkbox']", function (e) {  
			var idr = 0; 
			var row = $(this).closest("tr");  
			// $("input:checkbox[id^='chk']").not(this).prop('checked', false); 
			calc_dlg();
		});
		$("#dt-basic-credit").on('click', "input[type='checkbox']", function (e) { 
			var idr = 0;
			var row = $(this).closest("tr");  
			calc_dlg();
		});
		<?php } ?>
			
		/** fungsi hitung angka grid form utama **/
		function calc_form(){ 
			var idrRefund = 0; 
			var idrInvoice = 0; 
			var tabledebet = $('#dgvdetilD tbody');
			var tablecredit = $('#dgvdetilK tbody'); 
			
			tabledebet.find('tr').each(function (i) {	 
				var row = $(this).closest("tr"); 
				var deposit= row.find('.d_idr').val(); 
				idrRefund =  parseFloat((deposit).replace(/,/g, "")) + idrRefund; 
			});
			tablecredit.find('tr').each(function (i) {	 
				var row = $(this).closest("tr"); 
				var invoiceK= row.find('.k_idr').val(); 
				idrInvoice = parseFloat((invoiceK).replace(/,/g, "")) + idrInvoice;  
			}); 
			idrRefund = idrRefund.toLocaleString(undefined,{'minimumFractionDigits':2,'maximumFractionDigits':2});
			idrInvoice = idrInvoice.toLocaleString(undefined,{'minimumFractionDigits':2,'maximumFractionDigits':2});
			
			console.log('angka debet');
			console.log(idrRefund);
			// console.log(idrRefund.toLocaleString(undefined,{'minimumFractionDigits':2,'maximumFractionDigits':2}));
			
			console.log('angka kredit');
			console.log(idrInvoice);
			// console.log(idrInvoice.toLocaleString(undefined,{'minimumFractionDigits':2,'maximumFractionDigits':2}));
			/** untuk info angka di grid utama **/
			
			var selisih =0;
			selisih = (parseFloat((idrRefund).replace(/,/g, "")) - parseFloat((idrInvoice).replace(/,/g, "")));
			$('#ttotamountD').val(idrRefund);
			$('#ttotamountK').val(idrInvoice);
			$('#ttotamount').val(selisih);
			 
			$('#ttotamountD').inputmask({'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2,'digitsOptional': false, 'placeholder': '0.00', rightAlign : true,clearMaskOnLostFocus: !1}); 
			$('#ttotamountK').inputmask({'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2,'digitsOptional': false, 'placeholder': '0.00', rightAlign : true,clearMaskOnLostFocus: !1});
			$('#ttotamount').inputmask({'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2,'digitsOptional': false, 'placeholder': '0.00', rightAlign : true,clearMaskOnLostFocus: !1});
			
			console.log('selisih');
			console.log(Number(selisih));
			if(Number(selisih) != 0)
			{ 
				$('#btnSubmitForm').hide();	
				alert('Jurnal Tidak Balance!'); 
			}
			else
			{
				$('#btnSubmitForm').show();
			}
		}
		
		function calc_dlg(){ 
			var idrRefund = 0; 
			var idrInvoice = 0; 
			var tabledebet = $("#dt-basic-debet"); 
			tabledebet.find('tr').each(function (i) {	
				var chkbox = $(this).find('input[type="checkbox"]');
				if(chkbox.length) {
					var status = chkbox.prop('checked');
					if (status==true){ 
						var row = $(this).closest("tr"); 
						var deposit= row.find('.sisa_idr').val(); 
						idrRefund =  parseFloat((deposit).replace(/,/g, "")) + idrRefund; 
					} 
				};
			});
		
			idrInvoice = parseFloat(($('#dlg_amount').val()).replace(/,/g, "")) + idrInvoice; 
			
			$('#txtRefund').val(idrRefund);
			$('#txtRefund').inputmask({'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2,'digitsOptional': false, 'placeholder': '0.00', rightAlign : true,clearMaskOnLostFocus: !1});
			$('#txtInvoice').val(idrInvoice);
			$('#txtInvoice').inputmask({'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2,'digitsOptional': false, 'placeholder': '0.00', rightAlign : true,clearMaskOnLostFocus: !1});
			var selisih =0;
			selisih = ((idrRefund)-(idrInvoice)); 
			$('#txtSelisih').val(selisih);
			$('#txtSelisih').inputmask({'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2,'digitsOptional': false, 'placeholder': '0.00', rightAlign : true,clearMaskOnLostFocus: !1});
			if(selisih < -1)
			{
				$('#btnSaveDlg').hide();	
			}
			else
			{
				$('#btnSaveDlg').show();
			}
		}
		
		/** dialog load data debet dan kredit **/
		function dlgDebet(){  
			$.ajax({
					url: "<?php echo site_url($this->uri->segment(1)."/" .$this->uri->segment(2)."/isigriddetildebet")?>",
					async: false,
					type: "POST",
					data: {
								rekanan_id: $("#cboTenantName").val(),
								rekananshipping_line: $('#rekananshipping_line').val()
						},
					beforeSend: function() {  
						$('#btnVerifyRows').css('display','block');
						$('#btnVerifyRows').show();
						$('#pleasewait').show(); 
					},
					success: function(data) {   
						$('#pleasewait').hide();  
						$("#dt-basic-debet").dataTable().fnDestroy(); 
						$("#dt-basic-debet > tbody").empty();
						$("#dt-basic-debet > tbody").append(data);
						var tbl = $("#dt-basic-debet").dataTable({
						  "scrollY": "400px",
						  "scrollX": true,       
						  "pageLength": 100,
						  "processing": false, 
						  "serverSide": false,  
						  "searching" : true,
						  "ordering": false, 
						  "bLengthChange": false
						}); 
						$('.sisa_idr').inputmask({'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2,'digitsOptional': false, 'placeholder': '0.00', rightAlign : true,clearMaskOnLostFocus: !1}); 
					},
					error: function(xhr) { // if error occured
						alert("INETERR - Internet Anda Bermasalah, Silahkan coba beberapa saat lagi.");
						// $('#loadingGif').append(xhr.statusText +' '+ xhr.responseText); 
					}
				});    
		}
		 
		
		$(function()
		{	
			// handler masking 
			$(":input").inputmask(); 
		});
		
		
		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		  var target = $(e.target).attr("id") // activated tab
		  if(target == 'vtab_dlg2')
		  {
			$('#btnVerifyRows').hide();  
		  }
		  else
		  {
			$('#btnVerifyRows').show();   
		  }
		});
		 
		
		/** init select2 di dialog **/
		$('.js-data-rekanan-ajax-dlg').on('select2:open', function(e){
			$('.custom-dropdown').parent().css('z-index', 99999);
		});
		
		$('.js-data-rekanan-ajax-dlg').select2({
			dropdownCssClass: 'custom-dropdown'  
		});
		
		$('.js-data-rekananship-ajax-dlg').on('select2:open', function(e){
			$('.custom-dropdown').parent().css('z-index', 99999);
		});
		
		$('.js-data-rekananship-ajax-dlg').select2({
			dropdownCssClass: 'custom-dropdown'  
		});
		
		$('#cbpayment').on('select2:open', function(e){
			$('.custom-dropdown').parent().css('z-index', 99999);
		});
		
		$('#cbpayment').select2({
			dropdownCssClass: 'custom-dropdown'  
		}); 
		
		$('#cbaccpenerimaan').on('select2:open', function(e){
			$('.custom-dropdown').parent().css('z-index', 99999);
		});
		
		$('#cbaccpenerimaan').select2({
			dropdownCssClass: 'custom-dropdown'  
		}); 
		
		$('#cboaccnoRows').select2({
		   dropdownCssClass: 'custom-dropdown'
		}); 
		$('.js-data-dlgAcc-ajax').select2({
		   dropdownCssClass: 'custom-dropdown'
		}); 

		$('.js-data-dlgAcc-ajax').on('select2:open', function(e){
			$('.custom-dropdown').parent().css('z-index', 99999);
		});
		
		$('#cboaccnoRows').on('select2:open', function(e){
			$('.custom-dropdown').parent().css('z-index', 99999);
		});
		
		$('#cboaccnoRows').on('select2:open', function(e){
			$('.custom-dropdown').parent().css('z-index', 99999);
		});
		/** end init select2 di dialog **/
		 
		$('#iperiod').select2();  
		$('#iregion').select2(); 
		$('#ibranch').select2(); 
		$('#istruk').select2();
		$('#cboTenantName').select2();
		$('#cboTradeName').select2();
		
		$(".js-data-tenant-ajax").select2({ 
			allowClear: true,
			ajax:
			{
				allowClear: true,
				placeholder: 'Type Tenant Name',
				url: "<?php echo site_url($this->uri->segment(1)."/".$this->uri->segment(2)). "/gettenant";?>",
				dataType: 'json',
				type: "GET",
				delay: 250,
				data: function(params){
					return {
						q: params.term, // search term
					};
				},
				processResults: function(data, params){
					// parse the results into the format expected by Select2
					// since we are using custom formatting functions we do not need to
					// alter the remote JSON data, except to indicate that infinite
					// scrolling can be used
					params.page = params.page || 1;
					
					return {
						results: data,
						pagination:{
							more: (params.page * 30) < data.total_count
						}
					};
				},
				cache: true
			},
			placeholder: 'Search for a repository',
			escapeMarkup: function(markup){
				return markup;
			}, // let our custom formatter work
			minimumInputLength: 3
		});	
		
		// handler select2 trade dropdown
		$(".js-data-trade-ajax").select2({
			allowClear: true,
			ajax:
			{
				
				placeholder: 'Type Brand Name',
				url: "<?php echo site_url($this->uri->segment(1)."/".$this->uri->segment(2)).  "/gettrade";?>",
				dataType: 'json',
				type: "POST",
				delay: 250,
				data: function(params){
					return {
						q: params.term, // search term
						tenant: $(".js-data-tenant-ajax").val(),
					};
				},
				processResults: function(data, params){
					// parse the results into the format expected by Select2
					// since we are using custom formatting functions we do not need to
					// alter the remote JSON data, except to indicate that infinite
					// scrolling can be used
					params.page = params.page || 1;
					// $('#rekananshipping_line').val(emp[0].line);
					// console.log(data);
					return {
						results: data, 
						pagination:{
							more: (params.page * 30) < data.total_count
						}
					};
				},
				cache: true
			},
			placeholder: 'Search for a repository',
			escapeMarkup: function(markup){
			return markup;
			}, // let our custom formatter work
			//minimumInputLength: 2
		});	
		
		$(".js-data-trade-ajax").change(function(e){
			var rekanan = $(".js-data-trade-ajax").val();
			var rekananship_line = $(this).select2('data')[0].id_rekananship_line; 
			$('#rekananshipping_line').val(rekananship_line);
			 
			var selected_branch_id = $(this).select2('data')[0].branch_id;
			var selected_branch_name = $(this).select2('data')[0].branch_name;
			var selected_region_id = $(this).select2('data')[0].region_id;
			var selected_region_name = $(this).select2('data')[0].region_name;
			var debtor = $(this).select2('data')[0].sub1_id;
				
			// Unbind the event
			$('.js-data-tenant-ajax').off('select2:select'); 					
			$.getJSON("<?php echo site_url($this->uri->segment(1)."/".$this->uri->segment(2)). "/gettenant";?>",{
			id:rekanan,
			}, function(emp) {  
				var $selectTenant = $('.js-data-tenant-ajax'); 
				var $option = $('<option selected>'+emp[0].text+'</option>').val(emp[0].id); 
				$selectTenant.append($option).trigger('change');  
				
				var $selectBranch = $('#ibranch'); 
				var $optionBranch = $('<option selected>'+selected_branch_name+'</option>').val(selected_branch_id); 
				$selectBranch.append($optionBranch).trigger('change'); 
				$("#branch_id").val(selected_branch_id);
				
				var $selectRegion = $('#iregion'); 
				var $optionRegion = $('<option selected>'+selected_region_name+'</option>').val(selected_region_id); 
				$selectRegion.append($optionRegion).trigger('change');  
				$("#region_id").val(selected_region_id);
				
				
				$("#sub1_id").val(debtor);
				
				
			});  
		}); 
		
		$(".js-data-dlgAcc-ajax").select2({ dropdownParent: "#dlgAddRows" });
		//add account di dialog tambahan rows 
		$(".js-data-dlgAcc-ajax").select2({
			allowClear: true,
			width: '100%',
			ajax:
			{
				
				placeholder: 'Type Brand Name',
				url: "<?php echo site_url($this->uri->segment(1)."/".$this->uri->segment(2)).  "/getaccselect2";?>",
				dataType: 'json',
				type: "POST",
				delay: 250,
				data: function(params){
					return {
						q: params.term, // search term
						tenant: $(".js-data-tenant-ajax").val(),
					};
				},
				processResults: function(data, params){
					// parse the results into the format expected by Select2
					// since we are using custom formatting functions we do not need to
					// alter the remote JSON data, except to indicate that infinite
					// scrolling can be used
					params.page = params.page || 1;
					// $('#rekananshipping_line').val(emp[0].line);
					// console.log(data);
					return {
						results: data, 
						pagination:{
							more: (params.page * 30) < data.total_count
						}
					};
				},
				cache: true
			},
			placeholder: 'Search for a repository',
			escapeMarkup: function(markup){
			return markup;
			},  
			dropdownParent: $('#dlgAddRows')
		});	 
		 
	 
		$('.date').datepicker({
			maxViewMode: 1, 
			dateFormat: 'yyyy-mm-dd' ,
			clearBtn: true,
			orientation: "bottom auto",
			todayHighlight: true, 
			autoclose:true
		});  
	});
	//function kustom
	function GetMaxNum(objDgv, colnum) {
		var table = $(objDgv+" tbody");
		var max = 0;
		var value = 0;         
		table.find('tr').each(function (i) {
			   var $tds = $(this).find('input[type="hidden"]'),               
			   value = $tds.eq(colnum).val();

			   if (max < value) {
				max = parseInt(value);
			  } 
		} );  
		return max;
	}
	function addCommas(nStr)
	{
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}
</script>
<?php
		}
?>