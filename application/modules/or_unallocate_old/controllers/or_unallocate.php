<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Or_unallocate extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_or');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
    }
	
	function edit_or(){
		$or_id=$this->input->post('jurnal_id');
		$cboperiode=$this->input->post('cboperiode');
		$book_date=$this->input->post('book_date');
		$due_date=$this->input->post('due_date');
		$cboaccno=$this->input->post('cboaccno');
		$tdesc=$this->input->post('tdesc');	
		
		$this->model_or->updateor($or_id,$cboperiode,$book_date,$due_date,$cboaccno,$tdesc);
		redirect('or_unallocate/or_unallocate/orlist');
			
	}
    
	function saveor(){
		
		//header jurnal or
		$tgl=date('Y-m-d');
		$jurnal_id='';
		$jurnal_bookdate=$this->input->post('book_date'); 
		$jurnal_descr=$this->input->post('tdesc'); 
		$jurnal_isposted=0;
		$jurnal_createby=$this->session->userdata('user_fullname');
		$jurnal_createdate=$tgl; 
		$jurnal_modifyby='';
		$jurnal_modifydate=$tgl;
		$jurnal_postby='';
		$jurnal_postdate=$tgl;
		$jurnal_duedate=$this->input->post('due_date'); 
		$jurnal_faktur = 'ALLOCATION';
		$jurnal_source = 'OR-UnAllocate';
		$jurnaltype_id = 'OR';
		$channel_id = 'TSMB'; 
		$region_id=$this->input->post('tbusnisid'); 
		$branch_id=$this->input->post('txtstoreid');
		$strukturunit_id=$this->input->post('tsrukturid'); 
		$rekanan_id=$this->input->post('ttenantid'); 
		$sub1_id=0; 
		$sub2_id=$this->input->post('tcontractno'); 
		$currency_id=$this->input->post('tcurrency'); 
		$currency_rate=$this->input->post('texchange');  
		$periode_id=$this->input->post('cboperiode');
		$acc_id=$this->input->post('cboaccno');
		$rekananshipping_line=$this->input->post('ttshipid');
		
	
		$rq=$this->model_or->saveh($jurnal_id, 
					$jurnal_bookdate, 
					$jurnal_descr, 
					$jurnal_isposted, 
					$jurnal_createby, 
					$jurnal_createdate, 
					$jurnal_modifyby, 
					$jurnal_modifydate, 
					$jurnal_postby, 
					$jurnal_postdate, 
					$jurnal_duedate, 
					$jurnal_faktur, 
					$jurnal_source, 
					$jurnaltype_id, 
					$channel_id, 
					$region_id, 
					$branch_id, 
					$strukturunit_id, 
					$rekanan_id, 
					$sub1_id, 
					$sub2_id, 
					$currency_id, 
					$currency_rate, 
					$periode_id,
					$acc_id,$rekananshipping_line)->row_array();
		$jurnal_id=$rq['jurnal_id'];
		//end header jurnal 
		
		//detil penerimaan  
		$jurnaldetil_line=$this->input->post('tline'); 
		$jurnaldetil_dk='D';
		$jurnaldetil_descr=$this->input->post('tdescr'); 
		$jurnaldetil_idr=$this->input->post('tidr'); 
		$jurnaldetil_foreign=$this->input->post('tidrforeign'); 
		$jurnaldetil_foreignrate=$this->input->post('trate'); 
		$ref_id='';
		$ref_line=0;   
		$jurnalbilyet_no=$this->input->post('tnobilyet'); 
		$jurnalbilyet_date=$this->input->post('ttglbillyet'); 
		$jurnalbilyet_dateeffective=$this->input->post('ttglefektif'); 
		$jurnalbilyet_receiveperson=$this->input->post('tpenerima'); 
		$jurnalbilyet_bank=$this->input->post('tbank');
		$jurnalbilyet_pic=$this->input->post('tpenerima');
		$paymenttype_id=$this->input->post('payment');
		$modifyby=$this->session->userdata('user_fullname');
		$detilcurrency_id=$this->input->post('currency_type');
		$detilsub2_id = '0101';

		$this->model_or->savep(	$jurnal_id, 
								$jurnaldetil_line, 
								$jurnaldetil_dk, 
								$jurnaldetil_descr, 
								$jurnaldetil_idr, 
								$jurnaldetil_foreign, 
								$jurnaldetil_foreignrate, 
								$ref_id,
								$ref_line,
								$detilcurrency_id, 
								$acc_id, 
								$channel_id, 
								$region_id, 
								$branch_id, 
								$strukturunit_id, 
								$rekanan_id, 
								$sub2_id, 
								$detilsub2_id, 
								$jurnalbilyet_no, 
								$jurnalbilyet_date, 
								$jurnalbilyet_dateeffective, 
								$jurnalbilyet_receiveperson, 
								$jurnalbilyet_bank,
								$jurnalbilyet_pic,
								$paymenttype_id,
								$modifyby,
								$rekananshipping_line );
		//end detil penerimaan  
		
		redirect('or_unallocate/or_unallocate/orlist');

	}
	
	function fillcbopayment(){
        
        $payment= $this->model_or->get_paymenttype();
        $options    = array('' => 'Pilih');                
        
        if(count($payment)){
            foreach($payment as $key => $value){
                $options[$value->paymenttype_id]= $value->paymenttype_name;
            }
        }
                    
        return $options;
    }
	
	function fillcbocurr()
	{
        
        $payment= $this->model_or->get_currency();
        $options    = array('' => 'Pilih');                
        
        if(count($payment)){
            foreach($payment as $key => $value){
                $options[$value->currency_id]= $value->currency_shortname;
            }
        }
                    
        return $options;
    }
	
	function fillaccpenerimaan(){
        
        $payment= $this->model_or->qry_getaloc('result');
        $options    = array('' => 'Pilih');                
        
        if(count($payment)){
            foreach($payment as $key => $value){
                $options[$value->acc_id]= $value->acc_name;
            }
        }
                    
        return $options;
    }
	
	function fillcboperiode(){
        
        $payment= $this->model_or->qry_mstperiod();
        $options    = array('' => 'Pilih');                
        
        if(count($payment)){
            foreach($payment as $key => $value){
                $options[$value->periode_id]= $value->periode_name;
            }
        }
                    
        return $options;
    }
	 
	function isidialogbisnis(){
		$result=$this->model_or->qry_isidialog();
		$txtName = $this->input->post('txtname');
		$txtId = $this->input->post('txtid');
		
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
		$('#$txtId').val(clsid);
		$('#$txtName').val(clsname);	
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
		
		
		$result=$this->model_or->qry_isigridheader($vbisnisunit,$vstore,$vtrdname,$hshipline,$hdebtor);
		 $noline=10;
		 if (isset($result)){
			foreach ($result as $aRow){
			
			$jurnal_bookdate=date("Y-m-d", strtotime($aRow['jurnal_bookdate']));
			echo "<tr><td><input type='checkbox' id='chk' name='pp[]' class='myCheckBoxClass' /></td>";
			echo "<td class='clsinv'>".$aRow['jurnal_faktur']."</td>";
            echo "<td>".$aRow['faktur_id']."</td>";
            echo "<td>".$jurnal_bookdate."<input name='trekanan_id[]' class='clsrekananid' type='hidden' value='".$aRow['rekanan_id']."' /></td>";
            echo "<td>".number_format($aRow['jurnaldetil_idr']-$aRow['jurnaldetil_receive'],0)."</td>";
            echo "<td>".$aRow['currency_id']."<input name='trefid[]' type='hidden' class='clsrefid' value='".$aRow['jurnal_id']."' /></td>";
            echo "<td>".$aRow['jurnaldetil_descr']."<input name='sub2_id[]' class='clssub2_id' type='hidden' value='".$aRow['sub2_id']."'/><input name='tdregion_id[]' class='clsregionid' type='hidden' value='".$aRow['region_id']."' /></td>";
            echo "<td>".$aRow['acc_name']."</td>";
            echo "<td>".$aRow['jurnaldetil_foreign']."<input name='trate[]' class='clsrate' type='hidden' value='".$aRow['jurnaldetil_rate']."' /></td>";
            echo "<td>".$aRow['jurnaldetil_receive']."<input name='tforein[]' class='clsforeign' type='hidden' value='".$aRow['jurnaldetil_foreign']."'/></td>";
            echo "<td>".$aRow['region_name']."<input name='accid' class='clsaccid' type='hidden' value='".$aRow['acc_id']."'/></td>";
            echo "<td>".$aRow['branch_name']."<input name='accname' class='clsaccname' type='hidden' value='".$aRow['acc_name']."'/></td>";
           echo " <td>".$aRow['strukturunit_name']."<input name='tsub1_id[]' class='clssub1_id' type='hidden' value='".$aRow['sub1_id']."' /></td>";
           echo " <td>".$aRow['rekanan_name']."<input name='tbranchid' type='hidden' class='clsbranchid' value='".$aRow['branch_id']."' /></td>";
           echo " <td>".$aRow['channel_id']."<input name='tstrukturnit' type='hidden' class='clsstrukturunit' value='".$aRow['strukturunit_id']."' /><input name='tclsref_line' type='hidden' class='clsref_line' value='".$aRow['jurnaldetil_line']."' /></td>";
			echo "<td>".$aRow['rekananshipping_line']."</td><input name='tnoline' type='hidden' class='clsnoline' value='".$noline."' />/tr>";
			$noline=$noline+10;
			}


		 }
		
	}
	
	function isidialogstore(){
		$vregionid=$this->input->post('vbisnisunit');
		$txtName = $this->input->post('txtname');
		$txtId = $this->input->post('txtid');
		
		$result=$this->model_or->qry_isidialogstore($vregionid);
		$i=0;
		echo "<table class='table table-striped table-bordered table-hover nowrap compact' style='border:solid 1px #999; #999; border-radius:0px;' width='100%' id='dgvdlg'>
                                                <thead>
                                                   <tr>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Check</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>ID</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Name</th>
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
			$('#$txtId').val(clsid);
			$('#$txtName').val(clsname);	
			$('#dlgbisnisunit').modal('toggle');
		});</script>";
	}
	
	function isidialogstruktur(){
		$vregionid=$this->input->post('vbisnisunit');
		$txtName = $this->input->post('txtname');
		$txtId = $this->input->post('txtid');
		
		$result=$this->model_or->qry_isidialogstruktur();
		$i=0;
		echo "<table class='table table-striped table-bordered table-hover nowrap compact' style='border:solid 1px #999; #999; border-radius:0px;' width='100%' id='dgvdlg'>
                                                <thead>
                                                   <tr>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Check</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>ID</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Name</th>
                                                    </tr>
                                                   
                                                </thead>
                                                <tbody >";
		 if (isset($result)){
				foreach ($result as $row){;
				echo "<tr><td><input type='radio' name='pp' id='rcek' value='$row->strukturunit_id' class='check_class'></td>";
                echo "<td class='clsid'>".$row->strukturunit_id."</td><td class='clsname'>".$row->strukturunit_name."</td></tr>";
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
			$('#$txtId').val(clsid);
			$('#$txtName').val(clsname);	
			$('#dlgbisnisunit').modal('toggle');
		});</script>";
	}
	
	function isidialogtradename(){
		$vregionid=$this->input->post('vbisnisunit');
		$vbranchid=$this->input->post('vstore');
		$txtName = $this->input->post('txtname');
		$txtId = $this->input->post('txtid');
		$txtshipId = $this->input->post('txtshipid');
		$txtContractNo = $this->input->post('txtcontractno');
		
		$txtbusnis = $this->input->post('txtbusnis');
		$tbusnisid = $this->input->post('tbusnisid');
		$txtstore = $this->input->post('txtstore');
		$txtstoreid = $this->input->post('txtstoreid');
		
		
		$result=$this->model_or->qry_isidialogtradename($vregionid,$vbranchid);
		// echo "<pre>";
		// echo var_dump($result);
		$i=0;
		echo "<table class='table table-striped table-bordered table-hover nowrap compact' style='border:solid 1px #999; #999; border-radius:0px;' width='100%' id='dgvdlg'>
                                                <thead>
                                                   <tr>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Check</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>ID</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Tenant</th> 
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Trade</th> 
													  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Contract No</th>
													  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Shipping Line</th>
													  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Tenant ID</th>
													  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Store ID</th>
													  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>BU.ID</th>
													  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Store</th>
													  <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>BU</th>
                                                    </tr>
                                                   
                                                </thead>
                                                <tbody >";
		 if (isset($result)){
				foreach ($result as $row){;
				echo "<tr><td><input type='radio' name='pp' id='rcek' value='$row->shipping_id' class='check_class'></td>";
                echo "<td >".$row->shipping_id."</td><td class='clsname'>".$row->rekanan_name."</td><td class='clssubname'>".$row->rekananshipping_name."</td><td class='clsdebtor'>".$row->agreement_contractno."</td><td class='clsshipline'>".$row->rekananshipping_line."</td>
				<td class='clsid'>".$row->rekanan_id."</td>
				<td class='clsregionid'>".$row->region_id."</td>
				<td class='clsregion'>".$row->region_name."</td>
				<td class='clsbranchid'>".$row->branch_id."</td>
				<td class='clsbranch'>".$row->branch_name."</td>  
				</tr>";
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
		var clsdebtor= row.find('.clsdebtor').text();
		var clsshipline= row.find('.clsshipline').text();
		
		var clsregionid= row.find('.clsregionid').text();
		var clsregion= row.find('.clsregion').text();
		var clsbranchid= row.find('.clsbranchid').text();
		var clsbranch= row.find('.clsbranch').text();
		
			$('#$txtId').val(clsid);
			$('#$txtName').val(clsname);	
			//$('#$txtId').val(clssubname);
			//$('#htenant').val(clssubname);
			$('#$txtContractNo').val(clsdebtor);
			$('#$txtshipId').val(clsshipline);
			
			$('#$txtstore').val(clsbranch);
			$('#$txtstoreid').val(clsbranchid);
			$('#$txtbusnis').val(clsregion);
			$('#$tbusnisid').val(clsregionid);
			
			$('#dlgbisnisunit').modal('toggle'); 
		});</script>"; 
	}
	
	function isidialogaccount(){

		$result=$this->model_or->qry_isiaccount();
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
        redirect('or_unallocate/or_unallocate/orlist');
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
		
		$rResult=$this->model_or->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_or->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_or->$qry_totalall($sWhere);
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
                    <a href="/index.php/or_unallocate/or_unallocate/or_unallocate_edit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                    <img border="0" src="/assets/img/edit.png" width="21" height="21"></a>';

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

    function orlist(){
        
        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => '',
                  'loo_id'   => $loo_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->model_or->get_branch_list();
		
		$this->breadcrumbcomponent->add('Official Receipt - UnAllocate/List OR','or_unallocate/or_unallocate/orlist');

        $this->load->view('template/v_header');
        $this->load->view('or_unallocate/orunallocate_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function orunallocateadd()
	{		
        
        $loo_id = $this->uri->segment(4);        
        
        $data   = array(
                  'result'    => '', 
            );        
        
        $data['region']  = $this->region_select();
        $data['lotype'] = $this->lootype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();
        $data['unittype']   = $this->unittype_select();
        $data['currency_type']   = $this->fillcbocurr();
        $data['currency_fill']   = ($this->input->post('currency_type') == '') ? 'IDR' : $this->input->post('currency_type');
		$data['payment']=$this->fillcbopayment();
		
		$data['periode']=$this->fillcboperiode();
		$raloc=$this->model_or->qry_getaloc();
		$data['penerimaan']=$this->fillaccpenerimaan();
		$data['aloc_id']=$raloc['acc_id'];
		$data['aloc_name']=$raloc['acc_name'];
		

  		$this->breadcrumbcomponent->add('Official Receipt - UnAllocate','or_unallocate/or_unallocate/orlist')
            ->add('Input Official Receipt - UnAllocate','or_unallocate/or_unallocate/oradd');


        $this->load->view('template/v_header');
        $this->load->view('or_unallocate/orunallocate_add', $data);
        $this->load->view('template/v_footer');
	}
	
	function or_unallocate_edit()
	{		
        
        $or_id = $this->uri->segment(4);        
        
        $data   = array(
                  'result'    => $this->model_or->qry_getmaster($or_id),
				  'resultd'    => $this->model_or->qry_getlistd($or_id),
				  'resultk'    => $this->model_or->qry_getlistk($or_id),
				  'resultres'    => $this->model_or->qry_getrefonse($or_id),
                  'or_id'   => $or_id,
				  
            );        
         $data['currency_type']   = $this->fillcbocurr();
        $data['currency_fill']   = ($this->input->post('currency_type') == '') ? 'IDR' : $this->input->post('currency_type');
        $data['region']  = $this->region_select();
        $data['lotype'] = $this->lootype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();
        $data['unittype']   = $this->unittype_select();
		$data['payment']=$this->fillcbopayment();
		$data['penerimaan']=$this->fillaccpenerimaan();
		$data['periode']=$this->fillcboperiode();
		

  		$this->breadcrumbcomponent->add('Official Receipt - UnAllocate','or_unallocate/or_unallocate/orlist')
            ->add('Edit Official Receipt - UnAllocate','or_unallocate/or_unallocate/or_unallocate_edit');


        $this->load->view('template/v_header');
        $this->load->view('or_unallocate/orunallocate_edit', $data);
        $this->load->view('template/v_footer');
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