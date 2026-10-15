<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Refunddeposit extends CI_Controller{
    
    function __construct(){ 
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_refund');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
    }
	function edit_refund(){
 
		//header
		 
		//update header
		
		$this->model_refund->update_refund();
		redirect('refunddeposit/refunddeposit/refundlist');
			
	}
    function saverefund(){

	$book_date=$this->input->post('book_date');
	$tdesc=$this->input->post('tdesc');
	$due_date=$this->input->post('due_date');
	$hbisnisunit=$this->input->post('hbisnisunit');
	$hstore=$this->input->post('hstore');
	$tsruktur_id=$this->input->post('tsruktur_id');
	$htradename=$this->input->post('htradename');
	$hsub1=$this->input->post('hsub1');
	$hsub2=$this->input->post('hsub2');
	$cboperiode=$this->input->post('cboperiode');
	$cboaccno=$this->input->post('cboaccno');
	$cbpayment=$this->input->post('hpayment');
	$hdebtor=$this->input->post('hdebtor');

	// echo "<pre>";
	// echo var_dump($_POST);	 	
	// exit; 

	$rq=$this->model_refund->saveh($book_date,$tdesc,$due_date,$hbisnisunit,$hstore,$tsruktur_id,$htradename,$hsub1,$hdebtor,$cboperiode,$cboaccno)->row_array();
	$jurnal_id=$rq['jurnal_id'];

	//$jurnal_id='301';

	$xtline=$this->input->post('xtline');
	$xcbaccpenerimaan=$this->input->post('xcbaccpenerimaan');
	$xtreceive=($this->input->post('xtreceive'));
	$xtreceive=str_replace(',','',$xtreceive);
	$xforeign=$this->input->post('xforeign');
	$xrate=$this->input->post('xrate');
	$xrefid=$this->input->post('xrefid');
	$xref_line=$this->input->post('xref_line');
	$tsruktur_id=$this->input->post('tsruktur_id');
	$vtsub1_id=$this->input->post('vtsub1_id');
	$vtsub2_id=$this->input->post('vtsub2_id');
	$xaccid=$this->input->post('xaccid');
	$xrekananid=$this->input->post('xrekananid');
	$xrekananship=$this->input->post('xrekananship');
	$xtsub2_id=$this->input->post('xtsub2_id');
	$xtsub1_id=$this->input->post('xtsub1_id');
	$xtacc_id=$this->input->post('xtacc_id');

	$vtline=$this->input->post('vtline');
	$vtdes=$this->input->post('vtdes');
	$vtreceiveidr= ($this->input->post('vtreceiveidr'));
	$vtreceiveidr=str_replace(',','',$vtreceiveidr);
	$vtforeign=$this->input->post('vtforeign');
	$vtrate=$this->input->post('vtrate');
	$vtrafeid=$this->input->post('vtrafeidxtline');
	$vtrflin=$this->input->post('vtrflin');
	$vtacid=$this->input->post('vtacid');
	$vrekananship=$this->input->post('vrekananshipping_line');
	$vrekanan=$this->input->post('vrekanan');
	$vbank=$this->input->post('jurnaldetil_bank');
	$vbillyet=$this->input->post('jurnaldetil_billyet');
	$vjurnalbilyet_receiveperson=$this->input->post('jurnalbilyet_receiveperson');


	//debet
	$this->model_refund->savep($jurnal_id,$vtline,$vtdes,$vtreceiveidr,$vtforeign,$vtrate,$vtrafeid,$vtrflin,$vtacid,$hbisnisunit,$hstore,$tsruktur_id,$vrekanan,$hsub1,$hsub2,$book_date,$book_date,$vtacid,$cbpayment,$vrekananship,$vbank,$vbillyet,$vjurnalbilyet_receiveperson);

	//kredit
	$this->model_refund->saved($jurnal_id,$xtline,$xcbaccpenerimaan,$xtreceive,$xforeign,$xrate,$xrefid,$xref_line,$hbisnisunit,$hstore,$tsruktur_id,$xrekananid,$xtsub1_id,$xtsub2_id,$xtacc_id,$vrekananship);

	redirect('refunddeposit/refunddeposit/refundlist');

	}
	 function fillcbopayment(){
        
        $payment= $this->model_refund->get_paymenttype();
        $options    = array('' => 'Pilih');                
        
        if(count($payment)){
            foreach($payment as $key => $value){
                $options[$value->paymenttype_id]= $value->paymenttype_name;
            }
        }
                    
        return $options;
    } 
	function fillcbopaymentGrid($selectname,$selectid){
      
        $payment= $this->model_refund->get_paymenttype();
		
        $select = "<select name='$selectname' id='$selectid' style='width: 100%;' >"; 
		$select .= "<option value=''>PILIH</option>";                      
        if(count($payment)){
            foreach($payment as $key => $value){ 
				$select .= "<option value='".$value->paymenttype_id."'>".$value->paymenttype_name."</option>"; 
            }
        } 
		$select .= "</select>";
		$select .= "<script>";
		$select .= "$('#cbpaymentTypeD').select2({
				   dropdownCssClass: 'custom-dropdown'  
					});
					$('#cbpaymentTypeD').on('change', function (e) { 
						 var payid=$('#cbpaymentTypeD').val();
						 console.log('Event Change');
						 console.log(payid);
						 $('#hpayment').val(payid); 
					});
					";
		$select .= "</script>";
		
        return  ($select);
    }
	 function fillaccpenerimaan(){
        
        $payment= $this->model_refund->get_accpenerimaan();
        $options    = array('' => 'Pilih');                
        
        if(count($payment)){
            foreach($payment as $key => $value){
                $options[$value->acc_id]= $value->acc_name;
            }
        }
                    
        return $options;
    }
	
	function fillcboperiode(){
        
        $payment= $this->model_refund->qry_mstperiod();
        $options    = array('' => 'Pilih');                
        
        if(count($payment)){
            foreach($payment as $key => $value){
                $options[$value->periode_id]= $value->periode_name;
            }
        }
                    
        return $options;
    }
	
	
	function isidialogbisnis(){
		$result=$this->model_refund->qry_isidialog();
		$i=0;
		 if (isset($result)){
			 echo "<table class='table table-striped table-bordered table-hover nowrap compact' style='border:solid 1px #999; #999; border-radius:0px;' width='100%' id='dgvdlg'>
                                                <thead>
                                                   <tr>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Check</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Region</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Name</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Description</th>
                                                    </tr>
                                                   
                                                </thead>
                                                <tbody >";
				foreach ($result as $row){;
				echo "<tr><td align='center'><input type='radio' name='pp' id='rcek' value='$row->region_id' class='check_class'></td>";
                echo "<td class='clsid'>".$row->region_id."</td><td class='clsname'>".$row->region_name."</td><td></td></tr>";
				$i++;
				}
		 }
		 echo "</tbody></table>";
		echo "<script>$('#dgvdlg').DataTable();$('.check_class').click(function() {
		var row = $(this).closest('tr');   
		var clsid= row.find('.clsid').text();	
		var clsname= row.find('.clsname').text();
		$('#hbisnisunit').val(clsid);
		$('#tbisnisunit').val(clsname);	
		$('#dlgbisnisunit').modal('toggle');
		});</script>";
	}
	
											  
	function isigridheader(){
		$i=0;
		$vbisnisunit=$this->input->post('vbisnisunit');
		$vstore=$this->input->post('vstore');
		$vtrdname=$this->input->post('vtrdname');
		$hdebtor=$this->input->post('hdebtor');
		$hshipline=$this->input->post('hshipline');
		
		//debet
		$result=$this->model_refund->qry_isigridheader($vbisnisunit,$vstore,$vtrdname,$hshipline,$hdebtor);
		
		 $noline=10;
		 if (!empty($result)){
			foreach ($result as $aRow){
			
			$jurnal_bookdate=date("Y-m-d", strtotime($aRow['jurnal_bookdate']));
			$jurnal_duedate=date("Y-m-d", strtotime($aRow['jurnal_duedate'])); 
			echo "<tr>";
			
			echo "<td><input type='checkbox' id='chkDebet' name='pp[]' class='myCheckBoxClass' /></td>";
			echo "<td class='clsjurnalid'>".$aRow['jurnal_id']."<input name='vtrafeidxtline[]' type='hidden' class='clsrefid' value='".$aRow['jurnal_id']."'/> </td>"; 
            echo "<td >".$aRow['jurnaldetil_line']."</td>";
            echo "<td>".$jurnal_bookdate."<input name='trekanan_id[]' class='clsrekananid' type='hidden' value='".$aRow['rekanan_id']."' /></td>";
            echo "<td>".$jurnal_duedate."</td>"; 
			 echo "<td>".$aRow['jurnaldetil_descr']."</td>";
            echo "<td>".number_format($aRow['jurnaldetil_idr']*-1,0)."<input name='' class='' id='idr_awal' type='hidden' value='".number_format($aRow['jurnaldetil_idr']*-1,0)."' /></td>";
            echo "<td>".number_format($aRow['jurnaldetil_foreign'],0)."</td>";
            echo "<td>".$aRow['currency_id']."<input name='vtforeign[]' type='hidden' class='clsforeign' value='".$aRow['jurnaldetil_foreign']."' /><input name='trefid[]' type='hidden' class='clscurrency_id' value='".$aRow['currency_id']."' /></td>";
            echo "<td><input name='vtreceiveidr[]' class='clssisaidr' id='jurnaldetil_idr' type='text' value='".number_format($aRow['sisa_idr'],0)."' /><input name='' class='' id='jurnaldetil_idrawal' type='hidden' value='".number_format($aRow['sisa_idr'],0)."' /></td>";
            echo "<td>".number_format($aRow['sisa_foreign'],0)."<input name='vtrate[]' class='clsrate' type='hidden' value='".$aRow['jurnaldetil_foreignrate']."' /></td>";   
            echo "<td>".$aRow['branch_name']."<input name='vtacid[]' class='clsaccid' type='hidden' value='".$aRow['acc_id']."'/>"."<input name='accname' class='clsaccname' type='hidden' value='".$aRow['acc_name']."'/></td>";
           echo " <td>".$aRow['strukturunit_name']."</td>";
           echo " <td>".$aRow['rekanan_name']."<input name='tbranchid' type='hidden' class='clsbranchid' value='".$aRow['branch_id']."' /></td>";
           echo " <td>".$aRow['rekananshipping_line']."<input name='tstrukturnit' type='hidden' class='clsstrukturunit' value='".$aRow['strukturunit_id']."' /><input name='vtrflin[]' type='hidden' class='clsref_line' value='".$aRow['jurnaldetil_line']."' /><input name='tnoline' type='hidden' class='clsnoline' value='".$noline."' /></td>"; 
           echo "
		   <input name='vrekananshipping_line' type='hidden' class='clsrekananshipping_line' value='".$aRow['rekananshipping_line']."' />
		   <input name='vrekananshipping_name' type='hidden' class='clsrekananshipping_name' value='".$aRow['rekananshipping_name']."' />
		   <input name='rekanan_name' type='hidden' class='clsrekanan_name' value='".$aRow['rekanan_name']."' />
		   <input name='rekanan_id' type='hidden' class='clsrekanan_id' value='".$aRow['rekanan_id']."' />
		   <input name='strukturunit_name' type='hidden' class='clsstrukturunit_name' value='".$aRow['strukturunit_name']."' />
		   <input name='contract_no' type='hidden' class='clscontract_no' value='".$aRow['contract_no']."' />
		   <input name='strukturunit_id' type='hidden' class='clsstrukturunit_id' value='".$aRow['strukturunit_id']."' />
		   <input name='region_name' type='hidden' class='clsregion_name' value='".$aRow['region_name']."' />
		   <input name='branch_name' type='hidden' class='clsbranch_name' value='".$aRow['branch_name']."' /> 
		   <input name='branch_id' type='hidden' class='clsbranch_id' value='".$aRow['branch_id']."' />
		   <input name='region_id' type='hidden' class='clsregion_id' value='".$aRow['region_id']."' />
		   
		   <input name='vtsub2_id' type='hidden' class='' value='' />
		   <input name='vtsub1_id' type='hidden' class='' value='' /> 
		   <input name='vtline[]' type='hidden' class='' value='".$noline."' />
		   <input name='vtdes[]' type='hidden' class='' value='".$aRow['region_id']."' />
		   <input name='region_id[]' type='hidden' class='' value='".$aRow['region_id']."' />
		   <input name='region_id[]' type='hidden' class='clsjurnaldetil_line' value='".$aRow['jurnaldetil_line']."' />
		   <input name='clsjurnaldetil_descr[]' type='hidden' class='clsjurnaldetil_descr' value='".$aRow['jurnaldetil_descr']."' />
		   ";  
		    echo "</tr>"; 
			$noline=$noline+10;
			} 
		 }
		 else
		 {
			
			echo "<tr>";
			
			echo "<td colspan='5'>Data Not Found !</td>"; 
			
			echo "</tr>"; 
		 }
		 //echo var_dump($result);
	}
	
											  
	function isigriddetilaging(){
		$i=0;
		
		//echo var_dump($_POST);
		$vbisnisunit=$this->input->post('vbisnisunit');
		$vstore=$this->input->post('vstore');
		$vtrdname=$this->input->post('vtenanid');
		$hdebtor=$this->input->post('hdebtor');
		$hshipline=$this->input->post('hshipline');
		
		//kredit
		$result=$this->model_refund->qry_isigriddetil($vbisnisunit,$vstore,$vtrdname,$hshipline,$hdebtor);
		 $noline=5;
		 if (!empty($result)){
			foreach ($result as $aRow){
			
			$jurnal_bookdate=date("Y-m-d", strtotime($aRow['jurnal_bookdate']));
			$jurnal_duedate=date("Y-m-d", strtotime($aRow['jurnal_duedate']));
			echo "<tr><td><input type='checkbox' id='chk' name='pp[]' class='myCheckBoxClassDetil' /></td>";
			echo "<td class='clsinv'>".$aRow['jurnal_id']."</td>";
            echo "<td>".$aRow['jurnaldetil_line']."</td>";
            echo "<td>".$jurnal_bookdate."<input name='trekanan_id[]' class='clsrekananid' type='hidden' value='".$aRow['rekanan_id']."' /></td>";
            echo "<td>".$aRow['acc_name']."</td>"; 
			echo "<td>".$aRow['jurnaldetil_descr']."<input name='xcbaccpenerimaan[]' type='hidden' class='clsjurnaldetil_descr' value='".$aRow['jurnaldetil_descr']."' /></td>";
			echo "<td>".$aRow['currency_id']."</td>";
            echo "<td><input type='text' class='idr_receive_kredit' id='jurnaldetil_idr' name='xtreceive[]' value='".number_format($aRow['jurnaldetil_idr'] - $aRow['jurnaldetil_receive'],0)."'   /></td>";
            echo "<td>0</td>";
            echo "<td>0<input name='xrefid[]' type='hidden' class='clsrefid' value='".$aRow['jurnal_id']."' /></td>"; 
            echo "<td>0<input name='xrate[]' class='clsrate' type='hidden' value='".$aRow['currency_id']."' /></td>";   
            echo "<td>".$aRow['region_name']."</td>";
            echo "<td>".$aRow['branch_name']."<input name='accid[]' class='clsaccid' type='hidden' value='".$aRow['acc_id']."'/>"."<input name='accname' class='clsaccname' type='hidden' value='".$aRow['acc_name']."'/></td>";
           echo " <td>".$aRow['strukturunit_name']."<input name='tsub1_id[]' class='clssub1_id' type='hidden' value='".$aRow['sub1_id']."' /></td>";
           echo " <td>".$aRow['rekanan_name']."<input name='tbranchid' type='hidden' class='clsbranchid' value='".$aRow['branch_id']."' /></td>";
           echo " <td>".$aRow['channel_id']."<input name='tsruktur_id []' type='hidden' class='clsstrukturunit' value='".$aRow['strukturunit_id']."' /><input name='xref_line[]' type='hidden' class='clsref_line' value='".$aRow['jurnaldetil_line']."' /><input name='clschannel_id[]' type='hidden' class='clschannel_ids' value='".$aRow['channel_id']."' /></td>";
			echo "<td>".$aRow['rekananshipping_line']."</td><input name='tnoline' type='hidden' class='clsnoline' value='".$noline."' /> ";
			echo " 
			<input name='clsrekananshipping_line[]' type='hidden' class='clsrekananshipping_line' value='".$aRow['rekananshipping_line']."' />   
			<input name='clsbranch_name[]' type='hidden' class='clsbranch_name' value='".$aRow['branch_name']."' />   
			<input name='clsregion_name[]' type='hidden' class='clsregion_name' value='".$aRow['region_name']."' /> 
			<input name='clsregion_id[]' type='hidden' class='clsregion_ids' value='".$aRow['region_id']."' /> 
			 <input name='strukturunit_name' type='hidden' class='clsstrukturunit_name' value='".$aRow['strukturunit_name']."' />  
			  <input name='rekanan_name' type='hidden' class='clsrekanan_name' value='".$aRow['rekanan_name']."' />
			</tr>";
			
			
			$noline=$noline+15;
			}
			


		 }
		 else
		 {
			
			echo "<tr>";
			
			echo "<td colspan='5'>Data Not Found !</td>"; 
			
			echo "</tr>"; 
		 }
		 echo "<script> 
				var idr = document.getElementById('jurnaldetil_idr'); 
				idr.addEventListener('keyup', function(e)
				{
					idr.value = formatRupiah(this.value);
				});
				function formatRupiah(angka, prefix)
				{
					var number_string = angka.replace(/[^\d]/g, '').toString(),
						split	= number_string.split(','),
						sisa 	= split[0].length % 3,
						rupiah 	= split[0].substr(0, sisa),
						ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);
						
					if (ribuan) {
						separator = sisa ? ',' : '';
						rupiah += separator + ribuan.join(',');
					}
					
					rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
					//rupiah = rupiah.replace('.', ',');
					return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
				}
				$('#jurnaldetil_idr').number( true, 0); 
				</script>";
		
	}
	
	function isidialogstore(){
		$vregionid=$this->input->post('vbisnisunit');
		$result=$this->model_refund->qry_isidialogstore($vregionid);
		$i=0;
		echo "<table class='table table-striped table-bordered table-hover nowrap compact' style='border:solid 1px #999; #999; border-radius:0px;' width='100%' id='dgvdlg'>
                                                <thead>
                                                   <tr>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Check</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>ID</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Branch Name</th>
                                                    </tr>
                                                   
                                                </thead>
                                                <tbody >";
		 if (isset($result)){
				foreach ($result as $row){;
				echo "<tr><td><input type='radio' name='pp' id='rcek' value='$row->branch_id' class='check_class'></td>";
                echo "<td class='clsid'>".$row->branch_id."</td><td class='clsname'>".$row->branch_name."</td></tr>";
				$i++;
				}
		 }
		 echo "</tbody></table>";
		echo "<script>$('#dgvdlg').DataTable({
        scrollY: 200,
		paging: false,
		scrollCollapse: true
    });$('.check_class').click(function() {
		var row = $(this).closest('tr');   
		var clsid= row.find('.clsid').text();	
		var clsname= row.find('.clsname').text();
		$('#hstore').val(clsid);
		$('#tstore').val(clsname);	
		$('#dlgbisnisunit').modal('toggle');
		});</script>";
	}
	
	function isidialogtradename($detil=''){
		$vregionid=$this->input->post('vbisnisunit');
		$vbranchid=$this->input->post('vstore');
		$vType=$this->input->post('type');
		$result=$this->model_refund->qry_isidialogtradename($vregionid,$vbranchid);
		$i=0;
		echo "<table class='table table-striped table-bordered table-hover nowrap compact' style='border:solid 1px #999; #999; border-radius:0px;' width='100%' id='dgvdlg'>
                                                <thead>
                                                   <tr>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Check</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>ID</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Store</th><th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Tenant</th>
													  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Debtor</th>
													  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Contract No</th>
													  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Shipping Line</th>
													  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Store</th>
													  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>BU. Unit</th>
													  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Store ID</th>
													  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>BU. ID</th>
                                                    </tr>
                                                   
                                                </thead>
                                                <tbody >";
		 if (isset($result)){
				foreach ($result as $row){;
				echo "<tr><td><input type='radio' name='pp' id='rcek' value='$row->shipping_id' class='check_class'></td>";
                echo "<td >".$row->shipping_id."</td><td class='clsname'>".$row->rekanan_name."</td><td class='clssubname'>".$row->rekananshipping_name."</td><td class='clsdebtor'>".$row->agreement_contractno."</td><td class='clsshipline'>".$row->rekananshipping_line."</td><td class='clsid'>".$row->rekanan_id."</td><td class='clsregionname'>".$row->region_name."</td><td class='clsbranchname'>".$row->branch_name."</td>
				<td class='clsregionid'>".$row->region_id."</td>
				<td class='clsbranchid'>".$row->branch_id."</td>  
				</tr>";
				$i++;
				}
		 }
		 echo "</tbody></table>";
		echo "<script>
				$('#dgvdlg').DataTable({
				scrollY: 200,
				paging: false,
				scrollCollapse: true
				});		
		$('.check_class').click(function() {
			var row = $(this).closest('tr');   
			var clsid= row.find('.clsid').text();	
			var clsname= row.find('.clsname').text();
			var clssubname= row.find('.clssubname').text();
			var clsdebtor= row.find('.clsdebtor').text();
			var clsshipline= row.find('.clsshipline').text(); 
			var clsregionid= row.find('.clsregionid').text(); 
			var clsbranchid= row.find('.clsbranchid').text(); 
			var clsregionname= row.find('.clsregionname').text(); 
			var clsbranchname= row.find('.clsbranchname').text(); 
			";
		if($vType == '')
		{			
		echo "	$('#htradename').val(clsid);
			$('#ttradename').val(clsname);	 
			$('#ttenant').val(clssubname);
			$('#htenant').val(clssubname);
			$('#hdebtor').val(clsdebtor);
			$('#hshipline').val(clsshipline);
			
			$('#ttradenamedetil').val(clssubname);	
			$('#ttenantdetil').val(clsname); 
			$('#ttenantdetilship_id').val(clsshipline);
			$('#ttenantdetil_id').val(clsid); 
			
			$('#tbisnisunit').val(clsregionname); 
			$('#hbisnisunit').val(clsregionid); 
			
			$('#tstore').val(clsbranchname); 
			$('#hstore').val(clsbranchid);  
			 ";
		}
		else
		{
		 echo "	
			$('#ttradenamedetil').val(clssubname);	
			$('#ttenantdetil').val(clsname); 
			$('#ttenantdetilship_id').val(clsshipline);
			$('#ttenantdetil_id').val(clsid); 
		";
		}
		echo "$('#dlgbisnisunit').modal('toggle'); }); </script>";
	}
	
	
	function isidialogaccount(){

		$result=$this->model_refund->qry_isiaccount();
		$i=0;
		echo "<table class='table table-striped table-bordered table-hover nowrap compact' style='border:solid 1px #999; #999; border-radius:0px;' id='dgvdlg'>
                                                <thead>
                                                   <tr>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Check</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>ID</th>
                                                      <th class='lbOn' bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Account Name</th>
                                                    </tr>
                                                   
                                                </thead>
                                                <tbody >";
		 if (isset($result)){
				foreach ($result as $row){;
				echo "<tr><td><input type='radio' name='pp' id='rcek' value='$row->acc_id' class='check_class'></td>";
                echo "<td class='clsid'>".$row->acc_id."</td><td class='clsname'>".$row->acc_name."</td></tr>";
				$i++;
				}
		 }
		 echo "</tbody></table>";
		echo "<script>$('#dgvdlg').DataTable({
        scrollY: 200,
		paging: false,
		scrollCollapse: true
    });$('.check_class').click(function() {
			var row = $(this).closest('tr');   
			var clsid= row.find('.clsid').text();	
			var clsname= row.find('.clsname').text();
			var clssubname= row.find('.clssubname').text();
			$('#haccount').val(clsid);
			$('#tacc').val(clsname);	

		})      
		</script>";
	}
	
    function index(){       
        redirect('refunddeposit/refunddeposit/refundlist');
    }
    function globalsearch_dialog(){
		$arcari=array('unit_name', 'region_id', 'branch_id');
		return $arcari;
	}   
    function globalsearch_rekanan(){
        $arcari=array('rekanan_name','rekananshipping_name');
        return $arcari;
    }    
	
    function globalsearch_schema(){
        $arcari=array('unittype_id');
        return $arcari;
    }  
	
	function controler_griddialog(){
	$arcari=$this->globalsearch_dialog();
	$vResult=$this->initialize_grid("qry_alldatadialog","qry_filtereddialog","qry_totalalldialog",$arcari);
	$rResult=$vResult['rResult'];
	$output=$vResult['output'];

	foreach ($rResult as $aRow) {
        $row = array();
		$id=$aRow['unit_id'];
                $row[]=$aRow['unit_id'];
				$row[]=$aRow['unit_name'];
				$row[]=$aRow['unit_sqm'];
				$row[]=$aRow['lantai_name'];
                $row[]=$aRow['lantai_id'];

        if (!empty($row)) { $output['data'][] = $row; }
    	}   
    	echo json_encode($output);
		
}

    function controler_gridpop(){
        $arcari=$this->globalsearch_rekanan();
        $vResult=$this->initialize_grid("qry_alldatapop","qry_filteredpop","qry_totalallpop",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['rekanan_id'];
                    $row[]=$aRow['rekanan_id'];
                    $row[]=$aRow['rekanan_name'];
                    $row[]=$aRow['rekananshipping_line'];
                    $row[]=$aRow['rekananshipping_name'];
                    $row[]=$aRow['debtor_no'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }

    function controler_gridschema(){
        $arcari=$this->globalsearch_schema();
        $vResult=$this->initialize_grid("qry_alldataschema","qry_filteredschema","qry_totalallschema",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            
            $id=$aRow['skl_id'];
            $row[]=$aRow['skl_id'];
            $row[]=$aRow['skl_title'];
            $row[]=$aRow['skl_dp'];
            $row[]=$aRow['skl_inst'];
            $row[]=$aRow['skl_looterm'];
            $row[]=$aRow['skl_loiterm'];
            $row[]=$aRow['skl_rdep'];
            $row[]=$aRow['skl_scdep'];
            $row[]=$aRow['skl_islistrik'];
            $row[]=$aRow['skl_isair'];
            $row[]=$aRow['skl_isgas'];
            $row[]=$aRow['skl_istelp'];
            $row[]=$aRow['unittype_name'];
            $row[]=$aRow['skl_cp'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }
    
	function globalsearch_list(){
		$arcari=array('jurnal_id','rekanan_id','rekananshipping_line','rekanan_name','jurnal_isposted');
		return $arcari;
	}
	
	function initialize_grid($qry_alldata,$qry_filtered,$qry_totalall,$arcari,$cariOptional = ''){
		$aColumns = $arcari;
     
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) ) {
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
					$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
						".addslashes( $_GET['sSortDir_'.$i] ) .", ";
				}
			}
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" ) {
				$sOrder = "";
			}
		}
		   
		$sWhere = ""; 
		
		if ( isset($_POST['search']['value']) && $_POST['search']['value'] != "" ) {
			
		   $sWhere = "WHERE ("; 
			for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
				$sWhere .= $aColumns[$i]." LIKE '%".addslashes( $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		for ($i=0; $i < count($aColumns); $i++) {
			if ( isset($_POST['columns'][$i]['search']['value']) && $_POST['columns'][$i]['search']['value'] != "" ) { 
				$searchCol = trim($_POST['columns'][$i]['search']['value']);
				if ($searchCol != '') {
					if ($sWhere != ''){             
						$sWhere .= " AND ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
					} else {
						$sWhere = "WHERE ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
					}
					 $sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;
					
				}
			}
		}
		 
		
		 
		
		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
		$limit=$limit+$top;

		$b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ;        

		$sWhere = $sWhere.$b;
		
		$rResult=$this->model_refund->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_refund->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_refund->$qry_totalall($sWhere);
		$iTotal = $rResultTotal['jml'];
		   
		$output = array(
			"draw"=> $_POST['draw'],
			"recordsTotal" => $iTotal,
			"recordsFiltered" => $iFilteredTotal,
			"data" => array()
		);
		  $data['output']=$output;
		  $data['rResult']=$rResult;
	
		return $data;
	}    


    function controler_gridlist($val_search = ''){
		$arcari=$this->globalsearch_list(); 
		$searchStatus = $val_search;
		
		
		$criteria = null; 
		if($searchStatus == 'app')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.isapproved = 1";
			}
			else
			{
				$criteria =  " CTE.isapproved = 1";
			}
		}
		elseif($searchStatus == 'ret')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.isconfirm = 1";
			}
			else
			{
				$criteria =  " CTE.isconfirm = 1";
			}	
		} 
		elseif($searchStatus == 'not_app')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.isapproved = 0";
			}
			else
			{
				$criteria =  " CTE.isapproved = 0";
			}	
		}
		elseif($searchStatus == 'not_ret')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.isconfirm = 0";
			}
			else
			{
				$criteria =  " CTE.isconfirm = 0";
			}	
		} 
		elseif($searchStatus == 'all')
		{
			 $criteria = null ; 
		}
		elseif($searchStatus == 'k')
		{
			 $criteria = null ; 
		}
		
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {
            $row = array();
			$i_link=$aRow['jurnal_id'];
			// $is_post = ($aRow['isapproved']) ? 1 : 0;
			 $_menu='
					<a href="/index.php/print_or/print_or/report_deposit/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
                    <img border="0" src="/assets/img/print.png" width="21" height="21"> </a>
                    <a href="/index.php/refunddeposit/refunddeposit/refundalokasi_edit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                    <img border="0" src="/assets/img/edit.png" width="21" height="21"></a>';
					//<a href="'.base_url().'index.php/refunddeposit/refunddeposit/refundalokasi_delete/'.$i_link.'" data-toggle="tooltip" title="Delete" onclick="return deleteid(0)" >
                   // <img border="0" src="'.base_url().'/assets/img/delete.png" width="21" height="21"></a>
		
			$row[]=$aRow['jurnal_id'];
			$row[]=$aRow['jurnal_bookdate'];
			$row[]=$aRow['jurnal_descr'];
			$row[]=number_format($aRow['jurnal_amountidr'],2);
			$row[]=$aRow['jurnal_amountforeign'];
			$row[]=$aRow['jurnal_isposted'];
			$row[]=$aRow['jurnal_createby'];
			$row[]=$aRow['jurnal_createdate'];
			$row[]=$aRow['jurnal_modifyby'];
			$row[]=$aRow['jurnal_modifydate'];
			$row[]=$aRow['jurnal_postby'];
			$row[]=$aRow['jurnal_postdate'];
			$row[]=$aRow['jurnal_duedate'];
			$row[]=$aRow['jurnal_faktur'];
			$row[]=$aRow['jurnal_source'];
			$row[]=$aRow['jurnaltype_id'];
			$row[]=$aRow['channel_id'];
			$row[]=$aRow['region_id'];
			$row[]=$aRow['branch_name'];
			$row[]=$aRow['strukturunit_name'];
			$row[]=$aRow['rekanan_name'];
			$row[]=$aRow['sub1_id'];
			$row[]=$aRow['sub2_id'];
			$row[]=$aRow['currency_id'];
			$row[]=$aRow['currency_rate'];
			$row[]=$aRow['periode_id'];
			$row[]=$aRow['acc_id'];
			$row[]=$aRow['branch_id'];
			$row[]=$aRow['strukturunit_id'];
			$row[]=$aRow['rekanan_id'];
			$row[]=$aRow['rekananshipping_line'];
			$row[]=$_menu;
    	
            if (!empty($row)) { $output['data'][] = $row; }
        	}   
        	echo json_encode($output);
    		
    }

    function refundlist(){
        
        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_refund->viewloo($loo_id),
                  'loo_id'   => $loo_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->model_refund->get_branch_list();
		
		$this->breadcrumbcomponent->add('Refund','refunddeposit/refunddeposit/refundlist');

        $this->load->view('template/v_header');
        $this->load->view('refunddeposit/refund_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function refundaadd()
	{		
        
        $loo_id = $this->uri->segment(4);        
        
        $data   = array(
                  'result'    => $this->model_refund->viewloo($loo_id),
                  'loo_id'   => $loo_id
            );        
        
        $data['region']  = $this->region_select();
        $data['lotype'] = $this->lootype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();
        $data['unittype']   = $this->unittype_select();
		$Pymnt = $this->fillcbopaymentGrid('cbpaymentTypeD[]','cbpaymentTypeD');
		$thn_periode =  date('y');
		$bln_periode =  date('m');
		//$bln_periode = (count($bln_periode) == 1) ? '0'.$bln_periode : $bln_periode ;
		$data['periode_'] = $thn_periode.$bln_periode;
		//echo var_dump($data['periode_']);
		//$json = str_replace("!\r?\n!\\//", "",json_encode($Pymnt));
		$data['paymentJson'] =$Pymnt;
		 
		$data['penerimaan']=$this->fillaccpenerimaan();
		$data['periode']=$this->fillcboperiode();
		$raloc=$this->model_refund->qry_getaloc();
		$data['aloc_id']=$raloc['acc_id'];
		$data['aloc_name']=$raloc['acc_name'];
		

  		$this->breadcrumbcomponent->add('Refund Deposit','loo/loo/loolist')
            ->add('Input Refund Deposit','loo/loo/looadd');


        $this->load->view('template/v_header');
        $this->load->view('refunddeposit/refund_add', $data);
        $this->load->view('template/v_footer');
	}
	
	function refundalokasi_edit()
	{		
        
        $or_id = $this->uri->segment(4);        
        
        $data   = array(
                  'result'    => $this->model_refund->qry_getmaster($or_id),
				  'resultd'    => $this->model_refund->qry_getlistd($or_id),
				  'resultk'    => $this->model_refund->qry_getlistk($or_id),
				  'resultres'    => $this->model_refund->qry_getrefonse($or_id),
                  'or_id'   => $or_id
            );        
         
        $data['region']  = $this->region_select();
        $data['lotype'] = $this->lootype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();
        $data['unittype']   = $this->unittype_select();
		$data['payment']=$this->fillcbopayment();
		$data['penerimaan']=$this->fillaccpenerimaan();
		$data['periode']=$this->fillcboperiode();
		

  		$this->breadcrumbcomponent->add('Refund Deposit','refundalokasi')
            ->add('Edit Refund Deposit','refunddeposit/refunddeposit/refundalokasi_edit');


        $this->load->view('template/v_header');
        $this->load->view('refunddeposit/refund_edit', $data);
        $this->load->view('template/v_footer');
	}
    
	function refundalokasi_delete()
	{
		$or_id = $this->uri->segment(4);      
		 
	}
	
	function looedit(){		
        
        $i_link = $this->uri->segment(4);       
        $loo_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_refund->viewloo($loo_id),
                  'loo_id'   => $loo_id
            );                
        
        $data['region']     = $this->region_select();
        $data['lotype']     = $this->lootype_select();	
        $data['agrtype']    = $this->agrtype_select();
        $data['titype']     = $this->titype_select();
        $data['unittype']   = $this->unittype_select(); 

        $data['resultd'] = $this->model_refund->sholdetilby_id($loo_id);
        $data['resultu'] = $this->model_refund->vdetilunitby_id($loo_id);
		
		$this->breadcrumbcomponent->add('LOO Permanent/Casual','loo/loo/loolist')
            ->add('Edit LOO Permanent/Casual','loo/loo/looedit');        

        $this->load->view('template/v_header');
        $this->load->view('loo/loo_edit', $data);
        $this->load->view('template/v_footer');
	}

    function looview(){     
        
        $cont =  $this->uri->segment(4);
        $i_link = $this->uri->segment(5);       

        $loo_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_refund->viewloo($loo_id),
                  'loo_id'   => $loo_id
            );                
        
        $data['region'] = $this->region_select();
        $data['lotype'] = $this->lootype_select(); 
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();

        $data['resultd'] = $this->model_refund->sholdetilby_id($loo_id);
        $data['cont'] = $cont;

        switch ($cont){
            case "looconf":
                $crumb              = "LOO Permanent/Casual Doc.Return";
                $data['tabpost']    = " Return";
                break;

            case "looapp":
                $crumb              = "Loo Approval";
                $data['tabpost']    = " Approve";
                break;
            case "printcon":
                $crumb = "Print Confirmation";
                break;

        }
        
        $this->breadcrumbcomponent->add($crumb,'loo/'.$cont)
            ->add('View LOO Permanent/Casual Doc.Return','loo/loo/looview');        

        $this->load->view('template/v_header');
        $this->load->view('loo/loo_view', $data);
        $this->load->view('template/v_footer');
    }
	
	function looviewupload(){     
        $i_link = $this->uri->segment(4);       

        $loo_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_refund->viewloo($loo_id),
                  'loo_id'   => $loo_id
            );                
        
        $data['region'] = $this->region_select();
        $data['lotype'] = $this->lootype_select(); 
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();

        $data['resultd'] = $this->model_refund->sholdetilby_id($loo_id);
        $data['cont'] ="";

        
                $crumb              = "LOO Permanent/Casual Doc.Return";
                $data['tabpost']    = " Return";
				$cont="";


        
        $this->breadcrumbcomponent->add($crumb,'loo/'.$cont)
            ->add('Document Upload','loo/loo/looview');        

        $this->load->view('template/v_header');
        $this->load->view('loo/loo_viewupload', $data);
        $this->load->view('template/v_footer');
    }
	
	
	function looprint(){		
        
        $i_link = $this->uri->segment(4);       

        $loo_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_refund->viewlooprint($loo_id),
                  'loo_id'   => $loo_id
            );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();	
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_refund->sholdetilby_id($loo_id);
		
		$this->breadcrumbcomponent->add('Loo','loo/loo/loolist')
            ->add('Edit Loo','loo/loo/looedit');        

        $this->load->view('loo/rptloo', $data);
	}
    
    function region_select(){
        $this->load->model('template/Master_m');
        
        $region     = $this->Master_m->get_region();
        //$options    = array('' => 'Select an option');                
        
        if(count($region)){
            foreach($region as $key => $value){
                $options[$value->region_id]= $value->region_name;
            }
        }
                    
        return $options;
    }
    
    function branch_select(){

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];
        //$rRegion = empty($_GET['region']) ? '' : $_GET['region'];


        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            

            $this->load->model('template/Master_m');
            
            $branch      = $this->Master_m->get_branchbyall($rSearch['term']);
            
            $result['items']= $branch;
          
            echo json_encode($result);
            
        };
    }

    function agrtype_select(){
        
        $this->load->model('template/Master_m');
        
        $agrtype      = $this->Master_m->get_agrtype();
        $options    = array('' => '==Pilih==');                
        
        if(count($agrtype)){
            foreach($agrtype as $key => $value){
                $options[$value->agreementtype_id]= $value->agreementtype_name;
            }
        }
                    
        return $options;
    }

    function agrtype_selecttype(){        

        $lType = empty($_GET['lootype']) ? '' : $_GET['lootype'];
        $lType = trim($lType);        

        $options  = array(); 

        $casual = array('RENTAL TEMP', 'SERVICE TEMP', 'UTILITIES', 'OTHER', 'PS', 'DEPOSIT');

        $permanent = array('RENTAL', 'RENTAL TEMP', 'SERVICE', 'OTHER', 'LOAN', 'DEPOSIT');
        
        $this->load->model('template/Master_m');
    
        $agrtype      = $this->Master_m->get_agrtypebytype($lType);
        $options['data'][] = array( 
                                'id'      => '',
                                'text'    => '',
                                'type'    => ''
        );            

        if(count($agrtype)){
            foreach($agrtype as $key => $value){

                if (in_array($value->agreementtype_type, $permanent, TRUE)){
                    $options['data'][] = array(
                            'id'       => $value->agreementtype_id,
                            'text'     => $value->agreementtype_name,
                            'type'     => 'PERMANENT'
                    );
                }

                if (in_array($value->agreementtype_type, $casual, TRUE)){
                    $options['data'][] = array(
                            'id'       => $value->agreementtype_id,
                            'text'     => $value->agreementtype_name,
                            'type'     => 'CASUAL'
                    );
                }
            }
        }
                    
        echo json_encode($options);
    }


    function titype_select(){                 

        $options    = array('' => '==Pilih=='); 
        
        $options['0'] = 'Hari';
        $options['1'] = 'Bulan';
        $options['2'] = 'Tahun';
                    
        return $options;
    }

    function unittype_select(){                 

        $this->load->model('template/Master_m');
        
        $unittype     = $this->Master_m->get_unittype();
       
        if(count($unittype)){
            foreach($unittype as $key => $value){
                if ( $value->unittype_id != 6 && $value->unittype_id != 7){

                    $options[$value->unittype_id]= $value->unittype_name;
                }
            }
        }
                    
        return $options;
    }

    function lootype_select(){                 

        $options    = array('' => '==Pilih=='); 
        
        $options[0] = 'Permanent Trasaction';
        $options[1] = 'Casual Transaction';
                    
        return $options;
    }
    
    function loo_add(){        

        if ($_POST){
            
            $loo_id             = $this->input->post('loo_id');
            $loo_date           = $this->input->post('loo_date');
            $loo_sdate          = $this->input->post('loo_sdate');
            $loo_edate          = $this->input->post('loo_edate');
            $loo_term           = $this->input->post('loo_term');            
            $loo_descr          = $this->input->post('loo_descr'); 
            $region             = $this->input->post('cboregion');
            $branch             = $this->input->post('cbobranch');
            $lease              = $this->input->post('cbolootype');
            $unittype           = $this->input->post('cbounittype');
            $tenant             = $this->input->post('htenant');
            $brand              = $this->input->post('hbrand');
            $_createby          = $this->session->userdata('user_fullname');
			$_modifyby	        = $this->input->post('_modifyby');
			$loo_line           = $this->input->post('tline');
            $loo_baserent       = $this->input->post('tcharge');
            $loo_space          = $this->input->post('tsize');
            $unit_id            = $this->input->post('tunit');
            $agrtype_id         = $this->input->post('tatype');
			$lantai             = $this->input->post('tlantai');
            $int                = $this->input->post('tint');
            $timetype           = $this->input->post('titype');
            $descr              = $this->input->post('tdescr');
            $loo_percent        = $this->input->post('tval');
            $_ispercent         = $this->input->post('tper');
            $d_region           = $this->input->post('dRegion');
            $d_branch           = $this->input->post('dBranch');
            $d_tenant           = $this->input->post('dTenant');
            $d_brand            = $this->input->post('dBrand');
            $skl_id             = $this->input->post('skl_id');
            $u_line             = $this->input->post('uline');
            $u_unit             = $this->input->post('uunit');
            $u_size             = $this->input->post('usize');
            $u_lantai           = $this->input->post('ulantai');
            $u_region           = $this->input->post('rregion');
            $u_branch           = $this->input->post('rbranch');
            $u_tenant           = $this->input->post('rtenant');
            $u_brand            = $this->input->post('rbrand');
            $product_name       = $this->input->post('product_name');
            $fitting_out        = $this->input->post('fitting_out');
            $grace_period       = $this->input->post('grace_period');
            $size_indoor        = $this->input->post('size_indoor');
            $size_outdoor       = $this->input->post('size_outdoor');
            $debtor             = $this->input->post('idebtor');
            $virtual            = $this->input->post('ivirtual');
			$txtpaymentint      = $this->input->post('txtpaymentint');
			
			$txtleased      = $this->input->post('txtleased');
			$ckguarantor      = $this->input->post('ckguarantor');
			$txtdemised      = $this->input->post('txtdemised');
			$cbotmploo= $this->input->post('cbotmploo');
			
			$loo_comdate= $this->input->post('loo_comdate');
			$cbostamp= $this->input->post('cbostamp');
			$txtarpint= $this->input->post('txtarpint');
			$txtarpprosen= $this->input->post('txtarpprosen');

            $this->load->model('template/Master_m');    
            $dtregion = $this->Master_m->get_regionbyid($region);
                       
            $r_id = $dtregion[0]->region_nameshort;  
			
			$this->form_validation->set_rules('cboregion', 'Business Unit', 'required');
			$this->form_validation->set_rules('cbobranch', 'Store', 'required'); 
			$this->form_validation->set_rules('cbounittype', 'Unit Type', 'required');
			$this->form_validation->set_rules('htenant', 'Tenant', 'required');
			
			if ($this->form_validation->run() == TRUE) { 
        	$idx=$this->model_refund->insertloo($loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, 
                $lease, $loo_line,$unit_id,$agrtype_id,$loo_baserent, $r_id, $tenant, $brand, $int, $timetype, $loo_descr, $unittype,
                $skl_id, $descr, $_ispercent, $loo_percent, $u_line, $u_unit, $u_size, $u_lantai, $d_region, $d_branch, $d_tenant, $d_brand,
                $u_region, $u_branch, $u_tenant, $u_brand, $product_name,$fitting_out,$grace_period,$size_indoor,$size_outdoor, $debtor,$txtpaymentint,$txtleased,$ckguarantor,$txtdemised,$cbotmploo,$loo_comdate,$cbostamp,$txtarpint,$txtarpprosen);

        	redirect("loo/loo/loolist");
			} else {
			$this->looadd();	
			}
        }
    }
  
    function loo_edit(){

            $loo_id             = $this->input->post('loo_id');
            $loo_date           = $this->input->post('loo_date');
            $loo_descr          = $this->input->post('loo_descr');
            $loo_sdate          = $this->input->post('loo_sdate');
            $loo_edate          = $this->input->post('loo_edate');
            $loo_term           = $this->input->post('loo_term');            
            $region             = $this->input->post('cboregion');
            $branch             = $this->input->post('cbobranch');
            $lease              = $this->input->post('cbolootype');
            $unittype           = $this->input->post('cbounittype');
            $tenant             = $this->input->post('htenant');
            $brand              = $this->input->post('hbrand');
            $_createby          = $this->input->post('_createby');
            $_modifyby          = $this->session->userdata('user_fullname');;
            $loo_line           = $this->input->post('tline');
            $loo_baserent       = $this->input->post('tcharge');
            $unit_id            = $this->input->post('tunit');
            $agrtype_id         = $this->input->post('tatype');;
            $int                = $this->input->post('tint');
            $timetype           = $this->input->post('titype');
            $descr              = $this->input->post('tdescr');            
            $loo_percent        = $this->input->post('tval');
            $_ispercent         = $this->input->post('tper');        
            $d_region           = $this->input->post('dRegion');
            $d_branch           = $this->input->post('dBranch');
            $d_tenant           = $this->input->post('dTenant');
            $d_brand            = $this->input->post('dBrand');
            $skl_id             = $this->input->post('skl_id');
            $u_line             = $this->input->post('uline');
            $u_unit             = $this->input->post('uunit');
            $u_size             = $this->input->post('usize');
            $u_lantai           = $this->input->post('ulantai');
            $u_region           = $this->input->post('rregion');
            $u_branch           = $this->input->post('rbranch');
            $u_tenant           = $this->input->post('rtenant');
            $u_brand            = $this->input->post('rbrand');
			$product_name       = $this->input->post('product_name');
            $fitting_out        = $this->input->post('fitting_out');
            $grace_period       = $this->input->post('grace_period');
            $size_indoor        = $this->input->post('size_indoor');
            $size_outdoor       = $this->input->post('size_outdoor');
            $debtor             = $this->input->post('idebtor');
            $virtual            = $this->input->post('ivirtual');
			$txtpaymentint      = $this->input->post('txtpaymentint');
			
			$txtleased      = $this->input->post('txtleased');
			$ckguarantor    = $this->input->post('ckguarantor');
			$txtdemised     = $this->input->post('txtdemised');
          	$cbotmploo= $this->input->post('cbotmploo');   
		  	$loo_comdate= $this->input->post('loo_comdate');
			$cbostamp= $this->input->post('cbostamp');
			$txtarpint= $this->input->post('txtarpint');
			$txtarpprosen= $this->input->post('txtarpprosen');           

		$this->model_refund->updateloo($loo_id, $loo_date, $loo_descr, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, 
            $lease, $loo_line,$unit_id,$agrtype_id,$loo_baserent, $tenant, $brand, $int, $timetype, $descr, $_ispercent, $loo_percent,
            $u_line, $u_unit, $u_size, $u_lantai, $unittype, $skl_id, $d_region, $d_branch, $d_tenant, $d_brand, 
            $u_region, $u_branch, $u_tenant, $u_brand, $product_name,$fitting_out,$grace_period,$size_indoor,$size_outdoor,$debtor,$txtpaymentint,$txtleased,$ckguarantor,$txtdemised,$cbotmploo,$loo_comdate,$cbostamp,$txtarpint,$txtarpprosen);
        
		redirect("loo/loo/loolist");
    }
	
	function loo_delete(){
		
        $i_link = $this->uri->segment(4);       

        $_id = str_replace('_', '/', $i_link); 

		$this->model_refund->deleteloo($_id);
		redirect("loo/loo/loolist");
	}

    function loo_getskema(){
        
        $id = empty($_GET['id']) ? '' : $_GET['id'];

        $id = trim($id);

        if ($id == 'auto'){ $id = ''; }            

        //$datatables = $_POST;        
        $rResult = $this->model_refund->getskema($id);        

        foreach ($rResult as $aRow) {

            $row = array();            
            $row[]=$aRow['skl_id'];
            $row[]=$aRow['skl_line'];
            $row[]=$aRow['skl_descr'];
            $row[]=$aRow['skl_baserent'];
            $row[]=$aRow['skl_ispercent'];
            $row[]=$aRow['skl_percent'];
            $row[]=$aRow['skl_atype'];
            $row[]=$aRow['skl_int'];
            $row[]=$aRow['timetype_id'];
            $row[]=$aRow['agreementtype_name'];

        if (!empty($row)) { $output['data'][] = $row; }
        }   
        echo json_encode($output);
    }

    function looprintpdf(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_refund->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_refund->getpromolevy($loo_id);
                $vpromolevy=$vpl['promolevy'];
                
                $dps=$this->model_refund->getdepositr($loo_id);
                $vdps=$dps['depositr'];
                
                

        $data   = array(
                  'result'    => $this->model_refund->viewlooprint($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_refund->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_refund->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_refund->sholdetilby_id($loo_id);    

        $html=$this->load->view('loo/rptloo', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }
    
    
    function printconpdf(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_refund->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_refund->getpromolevy($loo_id);
                $vpromolevy=$vpl['promolevy'];
                
                $dps=$this->model_refund->getdepositr($loo_id);
                $vdps=$dps['depositr'];
                $nildps=$dps['loodetil_baserent'];
                
                

        $data   = array(
                  'result'    => $this->model_refund->viewconfprint($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_refund->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_refund->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps,
                  'nildps' =>$nildps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_refund->sholdetilby_id($loo_id);    

        $html=$this->load->view('loo/rptconf', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptlooconf.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  

        
    }

    function uploadjpg(){
        if($_POST) {

            $loo_id = $this->input->post('loo_id');
            $loo_id = str_replace('/', '_', $loo_id); 


            if ($_FILES['files']['tmp_name']) {
            
                $allowed = array('jpg', 'jpeg', 'png','pdf');

                if(isset($_FILES['files']) && $_FILES['files']['error'] == 0){

                   // $extension = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION);
				   $temp = explode(".", $_FILES["files"]["name"]);
					$extension = end($temp);
					
					
                    if(!in_array(strtolower($extension), $allowed)){
                        echo '{"status":"error"}';  
                        exit;                
                    }

                    if(move_uploaded_file($_FILES['files']['tmp_name'], FCPATH.'/assets/uploads/'.$loo_id.'.'.$extension)){

                        //echo '{"status":"success"}';                    
                        $success = 1;
                    }               
                }
            } else{
                $success = 0;
            }

        if ($success) {
            $result['files'][0] = array(
                'name'      => $loo_id.'.'.$extension,
                'size'      => 0,
                'url'       => base_url('/assets/uploads/'.$loo_id.'.'.$extension)
                );        
        }else{
            $result['files'][0] = array(
                'error'     => 'Unknown format',
                'url'       => '',
                'size'      => 0                
                );     
        }
    
        echo json_encode($result);
        }       
    }   
    
}  