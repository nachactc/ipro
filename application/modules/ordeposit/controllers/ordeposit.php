<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ordeposit extends CI_Controller
{

    function __construct()
    {

        parent::__construct();
        // Check login and make sure email has been verified
        check_user_login();

        $this
            ->load
            ->model('model_or');
        $this
            ->load
            ->library('breadcrumbcomponent');
        $this
            ->load
            ->library('form_validation');
    }
   
    function edit_or()
    {
        $or_id = $this
            ->input
            ->post('jurnal_id');
        $cboperiode = $this
            ->input
            ->post('cboperiode');
        $book_date = $this
            ->input
            ->post('book_date');
        $due_date = $this
            ->input
            ->post('due_date');
        $cboaccno = $this
            ->input
            ->post('cboaccno');
        $tdesc = $this
            ->input
            ->post('tdesc');
			// echo var_dump($_POST);exit;
        $this
            ->model_or
            ->updateor($or_id, $cboperiode, $book_date, $due_date, $cboaccno, $tdesc);
        redirect('ordeposit/ordeposit/orlist');

    }
    
	function saveor()
    {
		$this->db->trans_begin();   
        $tgl = date('Y-m-d');
        $userfullname = $this
            ->session
            ->userdata('user_fullname');

		// echo $this->input->post('vtline');exit;
		
        //header
        $jurnal_id = '';
        $jurnal_bookdate = $this
            ->input
            ->post('book_date');
        $jurnal_descr = $this
            ->input
            ->post('tdesc');
        $jurnal_isposted = 0;
        $jurnal_createby = $userfullname;
        $jurnal_createdate = $tgl;
        $jurnal_modifyby = '';
        $jurnal_modifydate = $tgl;
        $jurnal_postby = '';
        $jurnal_postdate = $tgl;
        $jurnal_duedate = $this
            ->input
            ->post('due_date');
        $jurnal_faktur = $this
            ->input
            ->post('tnofaktur');
        $jurnal_source = $this
            ->input
            ->post('jurnal_source');
        $jurnaltype_id = $this
            ->input
            ->post('jurnaltype_id');
        $channel_id = get_setting('channel_id');
        $region_id = $this
            ->input
            ->post('hbisnisunit');
        $branch_id = $this
            ->input
            ->post('hstore');
        $strukturunit_id = $this
            ->input
            ->post('tsruktur_id');
        $rekanan_id = $this
            ->input
            ->post('htenant');
        $sub1_id = $this
            ->input
            ->post('hsub1');
        $sub2_id = $this
            ->input
            ->post('hsub2');
        $currency_id = $this
            ->input
            ->post('tcurrency');
        $currency_rate = $this
            ->input
            ->post('texchange');
        $periode_id = $this
            ->input
            ->post('cboperiode');
        $acc_id = $this
            ->input
            ->post('cboaccno');
        $jurnal_tglbuktipotong = $this
            ->input
            ->post('tgl_buktiPotong');
        //header
		//echo  $channel_id;exit;
        $rq = $this
            ->model_or
            ->saveh($jurnal_id, $jurnal_bookdate, $jurnal_descr, $jurnal_isposted, $jurnal_createby, $jurnal_createdate, $jurnal_modifyby, $jurnal_modifydate, $jurnal_postby, $jurnal_postdate, $jurnal_duedate, $jurnal_faktur, $jurnal_source, $jurnaltype_id, $channel_id, $region_id, $branch_id, $strukturunit_id, $rekanan_id, $sub1_id, $sub2_id, $currency_id, $currency_rate, $periode_id, $acc_id, $jurnal_tglbuktipotong)->row_array();

        $jurnal_id = $rq['jurnal_id'];
      
        //detil penerimaan
        $jurnaldetil_line = $this
            ->input
            ->post('vtline');
        $jurnaldetil_dk = 'D';
        $jurnaldetil_descr = $this
            ->input
            ->post('Dtdes');
        $jurnaldetil_idr = $this
            ->input
            ->post('vtreceiveidr');
        $jurnaldetil_foreign = $this
            ->input
            ->post('vtforeign');
        $jurnaldetil_foreignrate = $this
            ->input
            ->post('vtrate');
        $ref_id = $this
            ->input
            ->post('ref_id');
        $ref_line = $this
            ->input
            ->post('ref_line'); 
			// echo var_dump($ref_line);exit;
        $jurnalbilyet_no = $this
            ->input
            ->post('tnobilyet');
        $jurnalbilyet_date = $this
            ->input
            ->post('ttglbillyet');
        $jurnalbilyet_dateeffective = $this
            ->input
            ->post('ttglefektif');
        $jurnalbilyet_receiveperson = $this
            ->input
            ->post('tpenerima');
        $jurnalbilyet_bank = $this
            ->input
            ->post('tbank');
        $jurnalbilyet_pic = $this
            ->input
            ->post('tpenerima');
        $paymenttype_id = $this
            ->input
            ->post('payment');
        $modifyby = $this
            ->session
            ->userdata('user_fullname');
        $detilcurrency_id = $this
            ->input
            ->post('currency_type');
        $vsub1_id = $rekananshipping_line = $this
            ->input
            ->post('vsub1_id');  
		$vsub2_id = $rekananshipping_line = $this
            ->input
            ->post('vsub2_id');   
        $rekananshipping_line = $this
            ->input
            ->post('dtrekananid_line');
        $vtacid = $this
            ->input
            ->post('vtacid');

        $this
            ->model_or
            ->savep($jurnal_id, $jurnaldetil_line, $jurnaldetil_dk, $jurnaldetil_descr, $jurnaldetil_idr, $jurnaldetil_foreign, $jurnaldetil_foreignrate, $ref_id, $ref_line, $detilcurrency_id, $vtacid, $channel_id, $region_id, $branch_id, $strukturunit_id, $rekanan_id, $vsub1_id, $vsub2_id, $jurnalbilyet_no, $jurnalbilyet_date, $jurnalbilyet_dateeffective, $jurnalbilyet_receiveperson, $jurnalbilyet_bank, $jurnalbilyet_pic, $paymenttype_id, $modifyby, $rekananshipping_line);
        
		// esyahh
		//end detil penerimaan
       
	   $xtline = $this
            ->input
            ->post('xtline');
        $xcbaccpenerimaan = $this
            ->input
            ->post('xcbaccpenerimaan');
        $xtreceive = $this
            ->input
            ->post('xtreceive');
        $xforeign = $this
            ->input
            ->post('xforeign');
        $xrate = $this
            ->input
            ->post('xrate');
        $xrefid = $this
            ->input
            ->post('xrefid');
        $xref_line = $this
            ->input
            ->post('xref_line');
        $tsruktur_id = $this
            ->input
            ->post('tsruktur_id');
        $vtsub1_id = $this
            ->input
            ->post('vtsub1_id');
        $vtsub2_id = $this
            ->input
            ->post('vtsub2_id');
        $xaccid = $this
            ->input
            ->post('xaccid');
        $vtline = $this
            ->input
            ->post('vtline');
        $vtdes = $this
            ->input
            ->post('vtdes');
        $vtreceiveidr = $this
            ->input
            ->post('vtreceiveidr');
        $vtforeign = $this
            ->input
            ->post('vtforeign');
        $vtrate = $this
            ->input
            ->post('vtrate');
        $vtrafeid = $this
            ->input
            ->post('vtrafeidxtline');
        $vtrflin = $this
            ->input
            ->post('vtrflin');
        $vtacid = $this
            ->input
            ->post('vtacid');
        $vrekananship = $this
            ->input
            ->post('vrekananshipping_line');

        $xtreceive = str_replace(',', '', $xtreceive);

        //kredit
        $this
            ->model_or
            ->saved($jurnal_id, $xtline, $xcbaccpenerimaan, $xtreceive, $xforeign, $xrate, $xrefid, $xref_line, $region_id, $branch_id, $strukturunit_id, $rekanan_id, $vtsub1_id, $vtsub2_id, $xaccid, $vrekananship,$channel_id);
		// echo "<pre/>";
		// echo var_dump($_POST);
		// exit;
		
		if ($this->db->trans_status() === FALSE)
		{                
			$this->db->trans_rollback();
			echo "ERROR";
			return false;
		}else{
			$this->db->trans_commit();                
		}
         redirect('ordeposit/ordeposit/orlist');

    }
    
	function fillcbopayment()
    {

        $payment = $this
            ->model_or
            ->get_paymenttype();
        $options = array(
            '' => 'Pilih'
        );

        if (count($payment))
        {
            foreach ($payment as $key => $value)
            {
                $options[$value
                    ->paymenttype_id] = $value->paymenttype_name;
            }
        }

        return $options;
    }
    
	function fillaccpenerimaan()
    {

        $payment = $this
            ->model_or
            ->get_accpenerimaan();
        $options = array(
            '' => 'Pilih'
        );

        if (count($payment))
        {
            foreach ($payment as $key => $value)
            {
                $options[$value
                    ->acc_id] = $value->acc_name;
            }
        }

        return $options;
    }

    function fillcboperiode()
    {

        $payment = $this
            ->model_or
            ->qry_mstperiod();
        $options = array(
            '' => 'Pilih'
        );

        if (count($payment))
        {
            foreach ($payment as $key => $value)
            {
                $options[$value->periode_id] = $value->periode_name;
            }
        }

        return $options;
    }

    function isidialogbisnis()
    {
        $result = $this
            ->model_or
            ->qry_isidialog();
        $i = 0;
        if (isset($result))
        {
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
            foreach ($result as $row)
            {;
                echo "<tr><td align='center'><input type='radio' name='pp' id='rcek' value='$row->region_id' class='check_class'></td>";
                echo "<td class='clsid'>" . $row->region_id . "</td><td class='clsname'>" . $row->region_name . "</td><td></td></tr>";
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

    function isidialogstruktur()
    {
        $vregionid = $this
            ->input
            ->post('vbisnisunit');
        $txtName = $this
            ->input
            ->post('txtname');
        $txtId = $this
            ->input
            ->post('txtid');

        $result = $this
            ->model_or
            ->qry_isidialogstruktur();
        $i = 0;
        echo "<table class='table table-striped table-bordered table-hover nowrap compact' style='border:solid 1px #999; #999; border-radius:0px;' width='100%' id='dgvdlg'>
                                                <thead>
                                                   <tr>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Check</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>ID</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Name</th>
                                                    </tr>
                                                   
                                                </thead>
                                                <tbody >";
        if (isset($result))
        {
            foreach ($result as $row)
            {;
                echo "<tr><td><input type='radio' name='pp' id='rcek' value='$row->strukturunit_id' class='check_class'></td>";
                echo "<td class='clsid'>" . $row->strukturunit_id . "</td><td class='clsname'>" . $row->strukturunit_name . "</td></tr>";
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

    function isigridheader()
    {
        $i = 0;
        $vbisnisunit = $this
            ->input
            ->post('vbisnisunit');
        $vstore = $this
            ->input
            ->post('vstore');
        $vtrdname = $this
            ->input
            ->post('vtrdname');
        $hdebtor = $this
            ->input
            ->post('hdebtor');
        $hshipline = $this
            ->input
            ->post('hshipline');

        $result = $this
            ->model_or
            ->qry_isigridheader($vbisnisunit, $vstore, $vtrdname, $hshipline, $hdebtor);
        $noline = 10;
        if (isset($result))
        {
            foreach ($result as $aRow)
            {

                $jurnal_bookdate = date("Y-m-d", strtotime($aRow['jurnal_bookdate']));
                echo "<tr><td><input type='checkbox' id='chk' name='pp[]' class='myCheckBoxClass' /></td>";
                echo "<td class='clsinv'>" . $aRow['jurnal_faktur'] . "</td>";
                echo "<td>" . $aRow['faktur_id'] . "</td>";
                echo "<td>" . $jurnal_bookdate . "<input name='trekanan_id[]' class='clsrekananid' type='hidden' value='" . $aRow['rekanan_id'] . "' /></td>";
                echo "<td>" . number_format($aRow['jurnaldetil_idr'] - $aRow['jurnaldetil_receive'], 0) . "</td>";
                echo "<td>" . $aRow['currency_id'] . "<input name='trefid[]' type='hidden' class='clsrefid' value='" . $aRow['jurnal_id'] . "' /></td>";
                echo "<td>" . $aRow['jurnaldetil_descr'] . "<input name='sub2_id[]' class='clssub2_id' type='hidden' value='" . $aRow['sub2_id'] . "'/><input name='tdregion_id[]' class='clsregionid' type='hidden' value='" . $aRow['region_id'] . "' /></td>";
                echo "<td>" . $aRow['acc_name'] . "</td>";
                echo "<td>" . $aRow['jurnaldetil_foreign'] . "<input name='trate[]' class='clsrate' type='hidden' value='" . $aRow['jurnaldetil_rate'] . "' /></td>";
                echo "<td>" . $aRow['jurnaldetil_receive'] . "<input name='tforein[]' class='clsforeign' type='hidden' value='" . $aRow['jurnaldetil_foreign'] . "'/></td>";
                echo "<td>" . $aRow['region_name'] . "<input name='accid' class='clsaccid' type='hidden' value='" . $aRow['acc_id'] . "'/></td>";
                echo "<td>" . $aRow['branch_name'] . "<input name='accname' class='clsaccname' type='hidden' value='" . $aRow['acc_name'] . "'/></td>";
                echo " <td>" . $aRow['strukturunit_name'] . "<input name='tsub1_id[]' class='clssub1_id' type='hidden' value='" . $aRow['sub1_id'] . "' /></td>";
                echo " <td>" . $aRow['rekanan_name'] . "<input name='tbranchid' type='hidden' class='clsbranchid' value='" . $aRow['branch_id'] . "' /></td>";
                echo " <td>" . $aRow['channel_id'] . "<input name='tstrukturnit' type='hidden' class='clsstrukturunit' value='" . $aRow['strukturunit_id'] . "' /><input name='tclsref_line' type='hidden' class='clsref_line' value='" . $aRow['jurnaldetil_line'] . "' /></td>";
                echo "<td>" . $aRow['rekananshipping_line'] . "</td><input name='rekananshipping_line' type='hidden' class='rekananshipping_line' value='" . $aRow['rekananshipping_line'] . "' /><input name='tnoline' type='hidden' class='clsnoline' value='" . $noline . "' />/tr>";
                $noline = $noline + 10;
            }

        }

    }

    function isidialogstore()
    {
        $vregionid = $this
            ->input
            ->post('vbisnisunit');
        $result = $this
            ->model_or
            ->qry_isidialogstore($vregionid);
        $i = 0;
        echo "<table class='table table-striped table-bordered table-hover nowrap compact' style='border:solid 1px #999; #999; border-radius:0px;' width='100%' id='dgvdlg'>
                                                <thead>
                                                   <tr>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Check</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>ID</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Branch Name</th>
                                                    </tr>
                                                   
                                                </thead>
                                                <tbody >";
        if (isset($result))
        {
            foreach ($result as $row)
            {;
                echo "<tr><td><input type='radio' name='pp' id='rcek' value='$row->branch_id' class='check_class'></td>";
                echo "<td class='clsid'>" . $row->branch_id . "</td><td class='clsname'>" . $row->branch_name . "</td></tr>";
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
		$('#dlgbisnisunit').modal('toggle');
		});</script>";
    }

    function isidialogtradename($detil = '')
    {
        $vregionid = $this
            ->input
            ->post('vbisnisunit');
        $vbranchid = $this
            ->input
            ->post('vstore');

        $result = $this
            ->model_or
            ->qry_isidialogtradename($vregionid, $vbranchid);
        $i = 0;
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
        if (isset($result))
        {
            foreach ($result as $row)
            {;
                echo "<tr><td><input type='radio' name='pp' id='rcek' value='$row->shipping_id' class='check_class'></td>";
                echo "<td >" . $row->shipping_id . "</td><td class='clsname'>" . $row->rekanan_name . "</td><td class='clssubname'>" . $row->rekananshipping_name . "</td><td class='clsdebtor'>" . $row->agreement_contractno . "</td><td class='clsshipline'>" . $row->rekananshipping_line . "</td><td class='clsid'>" . $row->rekanan_id . "</td><td class='clsregionname'>" . $row->region_name . "</td><td class='clsbranchname'>" . $row->branch_name . "</td>
				<td class='clsregionid'>" . $row->region_id . "</td>
				<td class='clsbranchid'>" . $row->branch_id . "</td>  
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

        echo "$('#dlgbisnisunit').modal('toggle'); }); </script>";
    }

    function isidialogaccount()
    {

        $result = $this
            ->model_or
            ->qry_isiaccount();
        $i = 0;
        echo "<table class='table table-striped table-bordered table-hover nowrap compact' style='border:solid 1px #999; #999; border-radius:0px;' id='dgvdlg'>
                                                <thead>
                                                   <tr>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Check</th>
                                                      <th bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>ID</th>
                                                      <th class='lbOn' bgcolor='#3c8dbc' style='background: #0096d5; color: white;'>Account Name</th>
                                                    </tr>
                                                   
                                                </thead>
                                                <tbody >";
        if (isset($result))
        {
            foreach ($result as $row)
            {;
                echo "<tr><td><input type='radio' name='pp' id='rcek' value='$row->acc_id' class='check_class'></td>";
                echo "<td class='clsid'>" . $row->acc_id . "</td><td class='clsname'>" . $row->acc_name . "</td></tr>";
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
			$('#dlgbisnisunit').modal('toggle');
		})      
		</script>";
    }

    function index()
    {
        redirect('ordeposit/ordeposit/orlist');
    }
    
	function globalsearch_dialog()
    {
        $arcari = array(
            'unit_name',
            'region_id',
            'branch_id'
        );
        return $arcari;
    }
    
	function globalsearch_rekanan()
    {
        $arcari = array(
            'rekanan_name',
            'rekananshipping_name'
        );
        return $arcari;
    }

    function globalsearch_schema()
    {
        $arcari = array(
            'unittype_id'
        );
        return $arcari;
    }

    function controler_griddialog()
    {
        $arcari = $this->globalsearch_dialog();
        $vResult = $this->initialize_grid("qry_alldatadialog", "qry_filtereddialog", "qry_totalalldialog", $arcari);
        $rResult = $vResult['rResult'];
        $output = $vResult['output'];

        foreach ($rResult as $aRow)
        {
            $row = array();
            $id = $aRow['unit_id'];
            $row[] = $aRow['unit_id'];
            $row[] = $aRow['unit_name'];
            $row[] = $aRow['unit_sqm'];
            $row[] = $aRow['lantai_name'];
            $row[] = $aRow['lantai_id'];

            if (!empty($row))
            {
                $output['data'][] = $row;
            }
        }
        echo json_encode($output);

    }

    function controler_gridpop()
    {
        $arcari = $this->globalsearch_rekanan();
        $vResult = $this->initialize_grid("qry_alldatapop", "qry_filteredpop", "qry_totalallpop", $arcari);
        $rResult = $vResult['rResult'];
        $output = $vResult['output'];

        foreach ($rResult as $aRow)
        {
            $row = array();
            $id = $aRow['rekanan_id'];
            $row[] = $aRow['rekanan_id'];
            $row[] = $aRow['rekanan_name'];
            $row[] = $aRow['rekananshipping_line'];
            $row[] = $aRow['rekananshipping_name'];
            $row[] = $aRow['debtor_no'];

            if (!empty($row))
            {
                $output['data'][] = $row;
            }
        }
        echo json_encode($output);

    }

    function controler_gridschema()
    {
        $arcari = $this->globalsearch_schema();
        $vResult = $this->initialize_grid("qry_alldataschema", "qry_filteredschema", "qry_totalallschema", $arcari);
        $rResult = $vResult['rResult'];
        $output = $vResult['output'];

        foreach ($rResult as $aRow)
        {
            $row = array();

            $id = $aRow['skl_id'];
            $row[] = $aRow['skl_id'];
            $row[] = $aRow['skl_title'];
            $row[] = $aRow['skl_dp'];
            $row[] = $aRow['skl_inst'];
            $row[] = $aRow['skl_looterm'];
            $row[] = $aRow['skl_loiterm'];
            $row[] = $aRow['skl_rdep'];
            $row[] = $aRow['skl_scdep'];
            $row[] = $aRow['skl_islistrik'];
            $row[] = $aRow['skl_isair'];
            $row[] = $aRow['skl_isgas'];
            $row[] = $aRow['skl_istelp'];
            $row[] = $aRow['unittype_name'];
            $row[] = $aRow['skl_cp'];

            if (!empty($row))
            {
                $output['data'][] = $row;
            }
        }
        echo json_encode($output);

    }

    function globalsearch_list()
    {
        $arcari = array(
            'jurnal_id',
            'rekanan_id',
            'rekananshipping_line',
            'rekanan_name',
            'jurnal_isposted'
        );
        return $arcari;
    }

    function initialize_grid($qry_alldata, $qry_filtered, $qry_totalall, $arcari, $cariOptional = '')
    {
        $aColumns = $arcari;

        $sOrder = "";
        if (isset($_GET['iSortCol_0']))
        {
            $sOrder = "ORDER BY  ";
            for ($i = 0;$i < intval($_GET['iSortingCols']);$i++)
            {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i]) ] == "true")
                {
                    $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i]) ] . "
						" . addslashes($_GET['sSortDir_' . $i]) . ", ";
                }
            }
            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY")
            {
                $sOrder = "";
            }
        }

        $sWhere = "";

        if (isset($_POST['search']['value']) && $_POST['search']['value'] != "")
        {

            $sWhere = "WHERE (";
            for ($i = 0;$i < count($aColumns);$i++)
            {
                $sWhere .= $aColumns[$i] . " LIKE '%" . addslashes($_POST['search']['value']) . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }

        for ($i = 0;$i < count($aColumns);$i++)
        {
            if (isset($_POST['columns'][$i]['search']['value']) && $_POST['columns'][$i]['search']['value'] != "")
            {
                $searchCol = trim($_POST['columns'][$i]['search']['value']);
                if ($searchCol != '')
                {
                    if ($sWhere != '')
                    {
                        $sWhere .= " AND " . $aColumns[$i] . " LIKE '%" . $searchCol . "%'";
                    }
                    else
                    {
                        $sWhere = "WHERE " . $aColumns[$i] . " LIKE '%" . $searchCol . "%'";
                    }
                    $sWhere .= $cariOptional <> '' ? $cariOptional . " AND " : '';

                }
            }
        }

        $top = (isset($_POST['start'])) ? ((int)$_POST['start']) : 0;
        $limit = (isset($_POST['length'])) ? ((int)$_POST['length']) : 10;
        $limit = $limit + $top;

        $b = $cariOptional <> '' ? " AND " . $cariOptional : '';

        $sWhere = $sWhere . $b;

        $rResult = $this
            ->model_or
            ->$qry_alldata($limit, $top, $sWhere);

        $rResultCnt = $this
            ->model_or
            ->$qry_filtered($sWhere);
        $iFilteredTotal = $rResultCnt['jml'];

        $rResultTotal = $this
            ->model_or
            ->$qry_totalall($sWhere);
        $iTotal = $rResultTotal['jml'];

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $iTotal,
            "recordsFiltered" => $iFilteredTotal,
            "data" => array()
        );
        $data['output'] = $output;
        $data['rResult'] = $rResult;

        return $data;
    }

    function controler_gridlist($val_search = '')
    {
        $arcari = $this->globalsearch_list();
        $searchStatus = $val_search;

        $criteria = null;
        if ($searchStatus == 'app')
        {
            if (!empty($criteria))
            {
                $criteria = $criteria . " AND CTE.isapproved = 1";
            }
            else
            {
                $criteria = " CTE.isapproved = 1";
            }
        }
        elseif ($searchStatus == 'ret')
        {
            if (!empty($criteria))
            {
                $criteria = $criteria . " AND CTE.isconfirm = 1";
            }
            else
            {
                $criteria = " CTE.isconfirm = 1";
            }
        }
        elseif ($searchStatus == 'not_app')
        {
            if (!empty($criteria))
            {
                $criteria = $criteria . " AND CTE.isapproved = 0";
            }
            else
            {
                $criteria = " CTE.isapproved = 0";
            }
        }
        elseif ($searchStatus == 'not_ret')
        {
            if (!empty($criteria))
            {
                $criteria = $criteria . " AND CTE.isconfirm = 0";
            }
            else
            {
                $criteria = " CTE.isconfirm = 0";
            }
        }
        elseif ($searchStatus == 'all')
        {
            $criteria = null;
        }
        elseif ($searchStatus == 'k')
        {
            $criteria = null;
        }

        $vResult = $this->initialize_grid("qry_alldatalist", "qry_filteredlist", "qry_totalalllist", $arcari, $criteria);
        $rResult = $vResult['rResult'];
        $output = $vResult['output'];

        foreach ($rResult as $aRow)
        {
            $row = array();
            $i_link = $aRow['jurnal_id'];
            // $is_post = ($aRow['isapproved']) ? 1 : 0;
            $_menu = '
					<a href="/index.php/print_or/print_or/report_mall/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
                    <img border="0" src="/assets/img/print.png" width="21" height="21"> </a>
                    <a href="/index.php/ordeposit/ordeposit/ordeposit_edit/' . $i_link . '" data-toggle="tooltip" title="Edit">
                    <img border="0" src="/assets/img/edit.png" width="21" height="21"></a>';

            $row[] = $aRow['jurnal_id'];
            $row[] = $aRow['jurnal_bookdate'];
            $row[] = $aRow['jurnal_descr'];
            $row[] = number_format($aRow['jurnal_amountidr'], 2);
            $row[] = $aRow['jurnal_amountforeign'];
            $row[] = $aRow['jurnal_isposted'];
            $row[] = $aRow['jurnal_createby'];
            $row[] = $aRow['jurnal_createdate'];
            $row[] = $aRow['jurnal_modifyby'];
            $row[] = $aRow['jurnal_modifydate'];
            $row[] = $aRow['jurnal_postby'];
            $row[] = $aRow['jurnal_postdate'];
            $row[] = $aRow['jurnal_duedate'];
            $row[] = $aRow['jurnal_faktur'];
            $row[] = $aRow['jurnal_source'];
            $row[] = $aRow['jurnaltype_id'];
            $row[] = $aRow['channel_id'];
            $row[] = $aRow['region_id'];
            $row[] = $aRow['branch_name'];
            $row[] = $aRow['strukturunit_name'];
            $row[] = $aRow['rekanan_name'];
            $row[] = $aRow['sub1_id'];
            $row[] = $aRow['sub2_id'];
            $row[] = $aRow['currency_id'];
            $row[] = $aRow['currency_rate'];
            $row[] = $aRow['periode_id'];
            $row[] = $aRow['acc_id'];
            $row[] = $aRow['branch_id'];
            $row[] = $aRow['strukturunit_id'];
            $row[] = $aRow['rekanan_id'];
            $row[] = 0;
            $row[] = $_menu;

            if (!empty($row))
            {
                $output['data'][] = $row;
            }
        }
        echo json_encode($output);

    }

    function orlist()
    {

        $loo_id = $this
            ->uri
            ->segment(4);
        $data = array(
            'result' => $this
                ->model_or
                ->viewloo($loo_id) ,
            'loo_id' => $loo_id
        );

        $data['region'] = $this->region_select();
        $data['branch'] = $this
            ->model_or
            ->get_branch_list();

        $this
            ->breadcrumbcomponent
            ->add('Official Receipt - Deposit', 'ordeposit/ordeposit/orlist');

        $this
            ->load
            ->view('template/v_header');
        $this
            ->load
            ->view('ordeposit/or_list', $data);
        $this
            ->load
            ->view('template/v_footer');
    }

    function ordepositadd()
    {

        $loo_id = $this
            ->uri
            ->segment(4);

        $data = array(
            'result' => $this
                ->model_or
                ->viewloo($loo_id) ,
            'loo_id' => $loo_id
        );

        $data['region'] = $this->region_select(); 
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();
        $data['unittype'] = $this->unittype_select();
        $data['payment'] = $this->fillcbopayment();
        $data['penerimaan'] = $this->fillaccpenerimaan();
        $data['periode'] = $this->fillcboperiode();
        $raloc = $this
            ->model_or
            ->qry_getaloc();
        $data['aloc_id'] = $raloc['acc_id'];
        $data['aloc_name'] = $raloc['acc_name']; 

        $this
            ->breadcrumbcomponent
            ->add('Official Receipt - WHT', 'loo/loo/loolist')
            ->add('Input Official Receipt - WHT', 'loo/loo/looadd');

        $this
            ->load
            ->view('template/v_header');
        $this
            ->load
            ->view('ordeposit/ordeposit_add', $data);
        $this
            ->load
            ->view('template/v_footer');
    }

    function ordeposit_edit()
    {

        $or_id = $this
            ->uri
            ->segment(4);

        $data = array(
            'result' => $this
                ->model_or
                ->qry_getmaster($or_id) ,
            'resultd' => $this
                ->model_or
                ->qry_getlistd($or_id) ,
            'resultk' => $this
                ->model_or
                ->qry_getlistk($or_id) ,
            'resultres' => $this
                ->model_or
                ->qry_getrefonse($or_id) ,
            'or_id' => $or_id
        );

        $data['region'] = $this->region_select(); 
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();
        $data['unittype'] = $this->unittype_select();
        $data['payment'] = $this->fillcbopayment();
        $data['penerimaan'] = $this->fillaccpenerimaan();
        $data['periode'] = $this->fillcboperiode();

        $this
            ->breadcrumbcomponent
            ->add('Official Receipt - WHT', 'loo/loo/loolist')
            ->add('Edit Official Receipt - WHT', 'ordeposit/ordeposit/ordeposit_edit');

        $this
            ->load
            ->view('template/v_header');
        $this
            ->load
            ->view('ordeposit/ordeposit_edit', $data);
        $this
            ->load
            ->view('template/v_footer');
    }

    function looedit()
    {

        $i_link = $this
            ->uri
            ->segment(4);
        $loo_id = str_replace('_', '/', $i_link);

        $data = array(
            'result' => $this
                ->model_or
                ->viewloo($loo_id) ,
            'loo_id' => $loo_id
        );

        $data['region'] = $this->region_select();
        $data['lotype'] = $this->lootype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();
        $data['unittype'] = $this->unittype_select();

        $data['resultd'] = $this
            ->model_or
            ->sholdetilby_id($loo_id);
        $data['resultu'] = $this
            ->model_or
            ->vdetilunitby_id($loo_id);

        $this
            ->breadcrumbcomponent
            ->add('LOO Permanent/Casual', 'loo/loo/loolist')
            ->add('Edit LOO Permanent/Casual', 'loo/loo/looedit');

        $this
            ->load
            ->view('template/v_header');
        $this
            ->load
            ->view('loo/loo_edit', $data);
        $this
            ->load
            ->view('template/v_footer');
    }

    function looview()
    {

        $cont = $this
            ->uri
            ->segment(4);
        $i_link = $this
            ->uri
            ->segment(5);

        $loo_id = str_replace('_', '/', $i_link);

        $data = array(
            'result' => $this
                ->model_or
                ->viewloo($loo_id) ,
            'loo_id' => $loo_id
        );

        $data['region'] = $this->region_select();
        $data['lotype'] = $this->lootype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();

        $data['resultd'] = $this
            ->model_or
            ->sholdetilby_id($loo_id);
        $data['cont'] = $cont;

        switch ($cont)
        {
            case "looconf":
                $crumb = "LOO Permanent/Casual Doc.Return";
                $data['tabpost'] = " Return";
            break;

            case "looapp":
                $crumb = "Loo Approval";
                $data['tabpost'] = " Approve";
            break;
            case "printcon":
                $crumb = "Print Confirmation";
            break;

        }

        $this
            ->breadcrumbcomponent
            ->add($crumb, 'loo/' . $cont)->add('View LOO Permanent/Casual Doc.Return', 'loo/loo/looview');

        $this
            ->load
            ->view('template/v_header');
        $this
            ->load
            ->view('loo/loo_view', $data);
        $this
            ->load
            ->view('template/v_footer');
    }

    function looviewupload()
    {
        $i_link = $this
            ->uri
            ->segment(4);

        $loo_id = str_replace('_', '/', $i_link);

        $data = array(
            'result' => $this
                ->model_or
                ->viewloo($loo_id) ,
            'loo_id' => $loo_id
        );

        $data['region'] = $this->region_select();
        $data['lotype'] = $this->lootype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();

        $data['resultd'] = $this
            ->model_or
            ->sholdetilby_id($loo_id);
        $data['cont'] = "";

        $crumb = "LOO Permanent/Casual Doc.Return";
        $data['tabpost'] = " Return";
        $cont = "";

        $this
            ->breadcrumbcomponent
            ->add($crumb, 'loo/' . $cont)->add('Document Upload', 'loo/loo/looview');

        $this
            ->load
            ->view('template/v_header');
        $this
            ->load
            ->view('loo/loo_viewupload', $data);
        $this
            ->load
            ->view('template/v_footer');
    }

    function looprint()
    {

        $i_link = $this
            ->uri
            ->segment(4);

        $loo_id = str_replace('_', '/', $i_link);

        $data = array(
            'result' => $this
                ->model_or
                ->viewlooprint($loo_id) ,
            'loo_id' => $loo_id
        );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this
            ->model_or
            ->sholdetilby_id($loo_id);

        $this
            ->breadcrumbcomponent
            ->add('Loo', 'loo/loo/loolist')
            ->add('Edit Loo', 'loo/loo/looedit');

        $this
            ->load
            ->view('loo/rptloo', $data);
    }

    function region_select()
    {
        $this
            ->load
            ->model('template/Master_m');

        $region = $this
            ->Master_m
            ->get_region();
        //$options    = array('' => 'Select an option');
        if (count($region))
        {
            foreach ($region as $key => $value)
            {
                $options[$value
                    ->region_id] = $value->region_name;
            }
        }

        return $options;
    }

    function branch_select()
    {

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];
        //$rRegion = empty($_GET['region']) ? '' : $_GET['region'];
        

        if (is_array($rSearch) && $rSearch['_type'] == 'query')
        {

            $this
                ->load
                ->model('template/Master_m');

            $branch = $this
                ->Master_m
                ->get_branchbyall($rSearch['term']);

            $result['items'] = $branch;

            echo json_encode($result);

        };
    }

    function agrtype_select()
    {

        $this
            ->load
            ->model('template/Master_m');

        $agrtype = $this
            ->Master_m
            ->get_agrtype();
        $options = array(
            '' => '==Pilih=='
        );

        if (count($agrtype))
        {
            foreach ($agrtype as $key => $value)
            {
                $options[$value
                    ->agreementtype_id] = $value->agreementtype_name;
            }
        }

        return $options;
    }

    function agrtype_selecttype()
    {

        $lType = empty($_GET['lootype']) ? '' : $_GET['lootype'];
        $lType = trim($lType);

        $options = array();

        $casual = array(
            'RENTAL TEMP',
            'SERVICE TEMP',
            'UTILITIES',
            'OTHER',
            'PS',
            'DEPOSIT'
        );

        $permanent = array(
            'RENTAL',
            'RENTAL TEMP',
            'SERVICE',
            'OTHER',
            'LOAN',
            'DEPOSIT'
        );

        $this
            ->load
            ->model('template/Master_m');

        $agrtype = $this
            ->Master_m
            ->get_agrtypebytype($lType);
        $options['data'][] = array(
            'id' => '',
            'text' => '',
            'type' => ''
        );

        if (count($agrtype))
        {
            foreach ($agrtype as $key => $value)
            {

                if (in_array($value->agreementtype_type, $permanent, true))
                {
                    $options['data'][] = array(
                        'id' => $value->agreementtype_id,
                        'text' => $value->agreementtype_name,
                        'type' => 'PERMANENT'
                    );
                }

                if (in_array($value->agreementtype_type, $casual, true))
                {
                    $options['data'][] = array(
                        'id' => $value->agreementtype_id,
                        'text' => $value->agreementtype_name,
                        'type' => 'CASUAL'
                    );
                }
            }
        }

        echo json_encode($options);
    }

    function titype_select()
    {

        $options = array(
            '' => '==Pilih=='
        );

        $options['0'] = 'Hari';
        $options['1'] = 'Bulan';
        $options['2'] = 'Tahun';

        return $options;
    }

    function unittype_select()
    {

        $this
            ->load
            ->model('template/Master_m');

        $unittype = $this
            ->Master_m
            ->get_unittype();

        if (count($unittype))
        {
            foreach ($unittype as $key => $value)
            {
                if ($value->unittype_id != 6 && $value->unittype_id != 7)
                {

                    $options[$value
                        ->unittype_id] = $value->unittype_name;
                }
            }
        }

        return $options;
    }
 
	/* new */
	function getSetting_Unearn()
	{
		$acc_id = $this->input->post('acc_id');
		$type = $this->input->post('type');
		 
		$a = $this->model_or->qry_isiaccount_row($acc_id);
		if($a != 'kosong')
		{
			if($type == 'name')
			{
				$result['acc'] = $a->acc_name; 
			}
			else
			{
				$result['acc'] = $a->acc_id; 
			}
		}
		else
		{
			$result['acc'] = 'kosong';
		}
		
		echo json_encode($result);
		
	}
	
	function getDataInvoiceDeposit()
	{
		$acc_id = $this->input->post('acc_id');
		$jurnal_id = $this->input->post('jurnal_id');
		$type = $this->input->post('type');
		
		//echo var_dump($_POST);
		 
		$a = $this->model_or->qry_getRefInvoice($acc_id,$jurnal_id);
		if($a != 'kosong')
		{
			if($type == 'name')
			{
				$result['invoice'] = $a->jurnal_id; 
			}
			else
			{
				$result['invoice'] = $a->jurnaldetil_line; 
			}
		}
		else
		{
			$result['invoice'] = 'kosong';
		}
		
		echo json_encode($result);
	}
	
}

