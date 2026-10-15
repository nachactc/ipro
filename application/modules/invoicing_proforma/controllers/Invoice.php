<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller{
	

    function __construct(){

        parent::__construct();
        // Check login and make sure email has been verified
        check_user_login();

        $this->load->model('model_invoice');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
		$this->session->keep_flashdata('message');
    }

    function index(){
        redirect('invoicing_proforma/invoice/invoicelist');
    }
	function globalsearch_list(){
		$arcari=array('B.region_id','B.branch_id','B.rekanan_id','BRAND.rekananshipping_line','CTE.agreementtype_id','schedulepaymentdetil_proformadate','schedulepaymentdetil_proformadate','schedulepaymentdetil_posteddate','agreementtype_printouttype','CTE.ref_id','invoice_id', 'faktur_id','BRANCH.branch_name','REKAN.rekanan_name','BRAND.rekananshipping_name','CTE.schedulepayment_id','CTE.schedulepayment_id + convert(nvarchar,schedulepaymentdetil_line)','CONVERT(VARCHAR, schedulepayment_createdate, 112)');
		return $arcari;
	}	
    function globalsearch_dialog(){
		$arcari=array('unit_name', 'region_id', 'branch_id');
		return $arcari;
	}
    function globalsearch_rekanan(){
        $arcari=array('rekanan_name','A.rekanan_id', 'B.branch_id');
        return $arcari;
    }

    function globalsearch_region(){
        $arcari=array('region_id','region_name');
        return $arcari;
    }

    function globalsearch_branch(){
        $arcari=array('A.branch_id','branch_name', 'region_id');
        return $arcari;
    }

    function globalsearch_brand(){
        $arcari=array('rekananshipping_line','rekananshipping_name','rekanan_id');
        return $arcari;
    }

    function globalsearch_agrtype(){
        $arcari=array('agreementtype_id','agreementtype_name');
        return $arcari;
    }
    function globalsearch_aging(){
        $arcari=array('jurnal_id', 'jurnal_id', 'rekanan_id');
        return $arcari;
    }
    function globalsearch_schema(){
        $arcari=array('unittype_id');
        return $arcari;
    }

	function controler_griddialog(){
	ini_set('max_execution_time', 0);
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
	ini_set('max_execution_time', 0);
        $arcari=$this->globalsearch_rekanan();
$vResult=$this->initialize_grid("qry_alldatapop","qry_filteredpop","qry_totalallpop",$arcari,"");
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

    function controler_gridtenant(){
	ini_set('max_execution_time', 0);
        $arcari=$this->globalsearch_rekanan();
        $vResult=$this->initialize_grid("qry_alldatatenant","qry_filteredtenant","qry_totalalltenant",$arcari,"");
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['rekanan_id'];
                    $row[]=$aRow['rekanan_id'];
                    $row[]=$aRow['rekanan_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }

    function controler_gridregion(){
	ini_set('max_execution_time', 0);
        $arcari=$this->globalsearch_region();
        $vResult=$this->initialize_grid("qry_alldataregion","qry_filteredregion","qry_totalallregion",$arcari,"");
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['region_id'];
                    $row[]=$aRow['region_id'];
                    $row[]=$aRow['region_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }

    function controler_gridbranch(){
	ini_set('max_execution_time', 0);
        $arcari=$this->globalsearch_branch();
        $vResult=$this->initialize_grid("qry_alldatabranch","qry_filteredbranch","qry_totalallbranch",$arcari,"");
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['branch_id'];
                    $row[]=$aRow['branch_id'];
                    $row[]=$aRow['branch_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }

    function controler_gridbrand(){
	ini_set('max_execution_time', 0);
        $arcari=$this->globalsearch_brand();
        $vResult=$this->initialize_grid("qry_alldatabrand","qry_filteredbrand","qry_totalallbrand",$arcari,"");
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['rekananshipping_line'];
                    $row[]=$aRow['rekananshipping_line'];
                    $row[]=$aRow['rekananshipping_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }

    function controler_gridagrtype(){
	ini_set('max_execution_time', 0);
        $arcari=$this->globalsearch_agrtype();
        $vResult=$this->initialize_grid("qry_alldataagrtype","qry_filteredagrtype","qry_totalallagrtype",$arcari,"");
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['agreementtype_id'];
                    $row[]=$aRow['agreementtype_id'];
                    $row[]=$aRow['agreementtype_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }
	
	function controler_gridaging(){
	ini_set('max_execution_time', 0);
        $arcari=$this->globalsearch_aging();
        $vResult=$this->initialize_grid("qry_alldataaging","qry_filteredaging","qry_totalallaging",$arcari,"");
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['jurnal_id'];
					$row[]=$aRow['jurnal_id'];
					$row[]=$aRow['jurnaldetil_line'];
                    $row[]=$aRow['jurnal_descr'];
					$row[]=number_format($aRow['jurnaldetil_selisih'], 2, '.', ',');
					$row[]='<input type="text" id="tamt[]" name="tamt[]" value="0" class="clsamt detil bulet form-control input-sm" style= "text-align: right;"/>';

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }

    function controler_gridschema(){
        $arcari=$this->globalsearch_schema();
        $vResult=$this->initialize_grid("qry_alldataschema","qry_filteredschema","qry_totalallschema",$arcari,"");
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



	function initialize_grid($qry_alldata,$qry_filtered,$qry_totalall,$arcari,$cariOptional = '',$searchStatus=''){
		$aColumns = $arcari;
        //  if ($cariOptional != ''){
        //    $cariOptional = " AND " .$cariOptional;
        //  }


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
		$sWhereUser = "";
		if ( isset($_POST['search']['value']) && $_POST['search']['value'] != "" ) {
		   $sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
				// if ($aColumns[$i]=='rekanan_id')
				// {
					// $sWhere .= $aColumns[$i]." LIKE '" . "'%" .addslashes( $_POST['search']['value'] ). "%'" . "' OR ";
				// }
				// else
				// {
					$sWhere .= $aColumns[$i]." LIKE '%".addslashes( $_POST['search']['value'] )."%' OR ";
				// }
				
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		
		//$sWhere = str_replace('WHERE', 'and', $sWhere);
		//$sWhere =$sWhere . ' and acc_id = 1020101';
		//echo "bug init -> " .$sWhere;		
		for ($i=0; $i < count($aColumns); $i++) {
			if ( isset($_POST['columns'][$i]['search']['value']) && $_POST['columns'][$i]['search']['value'] != "" ) {
				$searchCol = trim($_POST['columns'][$i]['search']['value']);
				if ($searchCol != '') {
					if ($sWhere != ''){
                        if ($aColumns[$i] == 'schedulepaymentdetil_proformadate'){
                            $sWhere .= " AND schedulepaymentdetil_proformadate <= "."'".$searchCol."'";
                            //$sWhere .= " AND CONVERT(VARCHAR, schedulepaymentdetil_date, 112) >= "."'".$searchCol."'";
                        } else if ($aColumns[$i] == 'schedulepaymentdetil_proformadate'){
                            $sWhere .= " AND schedulepaymentdetil_proformadate >= "."'".$searchCol."'";
                            //$sWhere .= " AND CONVERT(VARCHAR, schedulepaymentdetil_date, 112) <= "."'".$searchCol."'";
                        } else if ($aColumns[$i] == 'schedulepaymentdetil_posteddate'){
                            $sWhere .= " AND schedulepaymentdetil_posteddate = "."'".$searchCol."'";
                            //$sWhere .= " AND CONVERT(VARCHAR, schedulepaymentdetil_date, 112) <= "."'".$searchCol."'";
                        } else if ($aColumns[$i] == 'agreementtype_printouttype'){
                            $sWhere .= " AND agreementtype_printouttype = ".$searchCol;
                        } else {
                            $sWhere .= " AND ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
                        }
					} else {
                        if ($aColumns[$i] == 'schedulepaymentdetil_date'){
                        $sWhere .= " WHERE schedulepaymentdetil_proformadate <= "."'".$searchCol."'";
                        } elseif ($aColumns[$i] == 'schedulepaymentdetil_proformadate'){
                        $sWhere .= " WHERE schedulepaymentdetil_proformadate >= "."'".$searchCol."'";
                        } elseif ($aColumns[$i] == 'schedulepaymentdetil_posteddate'){
                        $sWhere .= " AND schedulepaymentdetil_posteddate = "."'".$searchCol."'";		  
                        } elseif ($aColumns[$i] == 'agreementtype_printouttype'){
                        $sWhere .= " WHERE agreementtype_printouttype = ".$searchCol;
                        } elseif ($aColumns[$i] == 'rekanan_id'){
                        $sWhere .= " and rekanan_id = ".$searchCol;
                        } else {
                            $sWhere = "WHERE ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
                        }
                    }
					// $sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;
				}
			}
		}
        //$sWhere .=  $cariOptional <> '' ? " AND ".  $cariOptional : '' ;

		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
		$limit=$limit+$top;
		
		if ( $cariOptional <> '' ) {            
            $sWhere = $sWhere <> '' ? $sWhere." AND ".$cariOptional : " WHERE ".$cariOptional;
		}
	
		//$b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ;
		//$sWhere = $sWhere.$b;
		//echo $sWhere; exit;
		// echo 'bug -> top : ' . $top . ' - : ' . $limit . ' - ' . $sWhere ;
		// exit;
        $username=$this->session->userdata('username');
		//echo $username;
        //exit;
		if ($sWhere =='') {
			$sWhereUser = " where username = "."'".$username."'";
		}
        else
		{
			$sWhereUser = " and username = "."'".$username."'";
			//$sWhereUser = " and B.branch_id in (select branch_id from  master_userbranch where username = "."'".$username."')";
		}
        //$sWhere = $sWhere.$sWhereUser;
        if ($searchStatus =='5'){
			$sWhere = str_replace('schedulepaymentdetil_date', 'schedulepaymentdetil_posteddate', $sWhere); 
		}		
		//echo $sWhere; exit;
		
		$rResult = $this->model_invoice->$qry_alldata($limit,$top,$sWhere,$sWhereUser);

		$rResultCnt = $this->model_invoice->$qry_filtered($sWhere,$sWhereUser);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal = $this->model_invoice->$qry_totalall($sWhereUser);
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
		
		ini_set('max_execution_time', 0);
		$arcari=$this->globalsearch_list();
		$searchStatus = $val_search;

        //alert($searchStatus);
		$timestamp = time();
		$now = date("Y-m-d", $timestamp);
		$updatedate = 0;
		$qry_alldatalist = "qry_alldatalist";
		$qry_filteredlist = "qry_filteredlist";
		$qry_totalalllist = "qry_totalalllist";
		$criteria = null;
		//unchecked		
		if($searchStatus == '1')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_isposted = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_isposted = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
		}
		
		//checked
		elseif($searchStatus == '0')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_ischecked = 0 and schedulepaymentdetil_isposted = 0 and schedulepaymentdetil_idr > 0 and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_ischecked = 0 and schedulepaymentdetil_isposted = 0 and schedulepaymentdetil_idr > 0 and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
		}
		
		//posting
		elseif($searchStatus == '2')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 and schedulepaymentdetil_isposted = 0  and schedulepaymentdetil_idr > 0AND  jurnal_id is null  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 and schedulepaymentdetil_isposted = 0  and schedulepaymentdetil_idr > 0AND  jurnal_id is null  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
		}
		
		//Unposting
		elseif($searchStatus == '3')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 and schedulepaymentdetil_isposted = 1 and schedulepaymentdetil_idr > 0 and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 and schedulepaymentdetil_isposted = 1 and schedulepaymentdetil_idr > 0 and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
		}	
		//printout proforma
		elseif($searchStatus == '4')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_isproforma = 1 and schedulepaymentdetil_idr > 0 and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_isproforma = 1 and schedulepaymentdetil_idr > 0 and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
		}		
		//printout invoice
		elseif($searchStatus == '5')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
		}	
		//credite note
		elseif($searchStatus == '6')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_isposted = 0 and CTE.agreementtype_id in ('2200','7200') and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_isposted = 0 and CTE.agreementtype_id in ('2200','7200') and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
		}		
		//Invoicing New
		elseif($searchStatus == '7')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 and schedulepaymentdetil_isposted = 0  and schedulepaymentdetil_idr > 0 AND  jurnal_id is null  and schedulepaymentdetil_ishold = 0 and schedulepaymentdetil_date <= agreement_bapdate and  CTE.agreementtype_id ='4000' AND schedulepaymentdetil_isdisabled = 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 and schedulepaymentdetil_isposted = 0  and schedulepaymentdetil_idr > 0 AND  jurnal_id is null and schedulepaymentdetil_ishold = 0 and schedulepaymentdetil_date <= agreement_bapdate and  CTE.agreementtype_id ='4000' AND schedulepaymentdetil_isdisabled = 0";
			}
		}		
		//Invoice Casual Leasing
		elseif($searchStatus == '8')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_ischecked = 0 and schedulepaymentdetil_boisposted = 0 and schedulepaymentdetil_isposted = 0  and schedulepaymentdetil_idr > 0 AND  jurnal_id is null and rekananshipping_type = 'cl' and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_ischecked = 0 and schedulepaymentdetil_boisposted = 0 and schedulepaymentdetil_isposted = 0  and schedulepaymentdetil_idr > 0 AND  jurnal_id is null and rekananshipping_type = 'cl' and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
		}	
		//duedate list
		elseif($searchStatus == '9')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 and schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_idr > 0  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 and schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_idr > 0  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
		}		
		//print utilites list
		elseif($searchStatus == '10')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 and schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_idr > 0 AND left(CTE.ref_id,1) ='U'  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 and schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_idr > 0  AND left(CTE.ref_id,1) = 'U'  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
		}
		//update posting date
		elseif($searchStatus == '11')
		{
			$updatedate = 0;
			// $qry_alldatalist = "qry_alldatalist2";
			// $qry_filteredlist = "qry_filteredlist2";
			// $qry_totalalllist = "qry_totalalllist2";			
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 and schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_idr > 0   and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 and schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_idr > 0   and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
		}	
		//status list
		elseif($searchStatus == '12')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_line is not null";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_line is not null";
			}
		}
		//Invoicing New
		elseif($searchStatus == '13')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_isdisabled = 1";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_isdisabled = 1";
			}
		}
		//Posting ALL
		elseif($searchStatus == '14')
		{
			$criteria =  null;
		}
		//Print Invoice TCP faktur_id not null
		elseif($searchStatus == '15')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0 and (faktur_id is not null and CTE.agreementtype_id not in ('7000','7500'))";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0 and (faktur_id is not null and CTE.agreementtype_id not in ('7000','7500'))";
				//$criteria =  " schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0 and (faktur_id is not null and CTE.agreementtype_id not in ('7000','7500')) or (schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0 and faktur_id is null and CTE.agreementtype_id in ('7000','7500')) ";
			}
		}
		//Print Invoice TCP Deposit
		elseif($searchStatus == '16')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0 and (CTE.agreementtype_id in ('7000','7500'))";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0 and (CTE.agreementtype_id in ('7000','7500'))";
				//$criteria =  " schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0 and (faktur_id is not null and CTE.agreementtype_id not in ('7000','7500')) or (schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0 and faktur_id is null and CTE.agreementtype_id in ('7000','7500')) ";
			}
		}
		//Print Invoice TSMB faktur_id not null
		elseif($searchStatus == '17')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0 and (faktur_id is not null and CTE.agreementtype_id not in ('7000','7500'))";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0 and (faktur_id is not null and CTE.agreementtype_id not in ('7000','7500'))";
				//$criteria =  " schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0 and (faktur_id is not null and CTE.agreementtype_id not in ('7000','7500')) or (schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0 and faktur_id is null and CTE.agreementtype_id in ('7000','7500')) ";
			}
		}
    else
		{
			 $criteria =  null;
		}


	if($updatedate == 1)
	{
		// $criteria = ' agreementtype_printouttype = 1 and  schedulepaymentdetil_date  <= ' . "'". $now . "'";
	}
          		
	//mudules::run('m');
	//$del =modules::run('master_rekananshipping/destroy',$rekanan_id,$rekananshipping_line);
    // echo "bug -->".$criteria; exit;

    	$vResult=$this->initialize_grid($qry_alldatalist, $qry_filteredlist, $qry_totalalllist, $arcari, $criteria, $searchStatus);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['invoice_id']);
            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';

                $_menu='
                    <a href="/index.php/invoiceprint/invoiceprint/invoiceprintpdf/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
                    <img border="0" src="/assets/img/print.png" width="21" height="21"> </a>';


            $row = array();

			   $row[]=$aRow['schedulepayment_id'];
               $row[]=$aRow['schedulepaymentdetil_line'];
               $row[]=$aRow['invoice_id'];
               $row[]=$aRow['faktur_id'];
               $row[]=$aRow['region_nameshort'];
               $row[]=$aRow['branch_name'];
               $row[]=$ship_name;
               $row[]=$aRow['rekananshipping_name'];
			   $row[]=$aRow['schedulepaymentdetil_unit'];
               $row[]=$aRow['agreementtype_name'];
               $row[]=$aRow['schedulepaymentdetil_descr'];
               $row[]=$aRow['schedulepaymentdetil_date'];
               $row[]=$aRow['duedate'];
               $row[]=$aRow['schedulepaymentdetil_proformadate'];
			   $row[]=number_format($aRow['schedulepaymentdetil_amount'], 2, '.', ',');
               $row[]=number_format($aRow['schedulepaymentdetil_idr'], 2, '.', ',');
               $row[]=$aRow['agreementtype_nameshort'];
               $row[]=$aRow['region_id'];
               $row[]=$aRow['channel_id'];
			   $row[]=$aRow['branch_id'];
			   $row[]=$aRow['agreementtype_id'];
			   $row[]=$aRow['rekanan_id'];
			   $row[]=$aRow['rekananshipping_line'];
			   $row[]=$aRow['ref_id'];
			   $row[]=$aRow['ref_line'];
			   $row[]=$aRow['schedulepaymentdetil_ischecked'];
			   $row[]=$aRow['schedulepaymentdetil_isposted'];
			   $row[]=$aRow['schedulepaymentdetil_ishold'];
			   $row[]=$aRow['schedulepaymentdetil_isdisabled'];

            if (!empty($row)) { $output['data'][] = $row; }
        	}
        	echo json_encode($output);

    }
	function controler_gridlist_tcp($val_search = ''){
		$arcari=$this->globalsearch_list();
		$searchStatus = $val_search;

    //alert($searchStatus);
		$timestamp = time();
		$now = date("Y-m-d", $timestamp);
		$updatedate = 0;
		$qry_alldatalist = "qry_alldatalist_tcp";
		$qry_filteredlist = "qry_filteredlist_tcp";
		$qry_totalalllist = "qry_totalalllist_tcp";
		$criteria = null;
		//unchecked		
		if($searchStatus == '15')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
				//$criteria =  " schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0 and (faktur_id is not null and CTE.agreementtype_id not in ('7000','7500')) or (schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0 and faktur_id is null and CTE.agreementtype_id in ('7000','7500')) ";
			}
		}
		//Print Invoice TCP Deposit
		elseif($searchStatus == '16')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0";
				//$criteria =  " schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0 and (faktur_id is not null and CTE.agreementtype_id not in ('7000','7500')) or (schedulepaymentdetil_isposted = 1  and schedulepaymentdetil_ishold = 0 AND schedulepaymentdetil_isdisabled = 0 and faktur_id is null and CTE.agreementtype_id in ('7000','7500')) ";
			}
		}
    else
		{
			 $criteria =  null;
		}


	if($updatedate == 1)
	{
		// $criteria = ' agreementtype_printouttype = 1 and  schedulepaymentdetil_date  <= ' . "'". $now . "'";
	}
          		
	//mudules::run('m');
	//$del =modules::run('master_rekananshipping/destroy',$rekanan_id,$rekananshipping_line);
    // echo "bug -->".$criteria; exit;

    	$vResult=$this->initialize_grid($qry_alldatalist,$qry_filteredlist,$qry_totalalllist,$arcari,$criteria,$searchStatus);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['invoice_id']);
            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';

                $_menu='
                    <a href="/index.php/invoiceprint/invoiceprint/invoiceprintpdf/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
                    <img border="0" src="/assets/img/print.png" width="21" height="21"> </a>';


            $row = array();

			   $row[]=$aRow['schedulepayment_id'];
               $row[]=$aRow['schedulepaymentdetil_line'];
               $row[]=$aRow['invoice_id'];
               $row[]=$aRow['faktur_id'];
               $row[]=$aRow['region_nameshort'];
               $row[]=$aRow['branch_name'];
               $row[]=$ship_name;
               $row[]=$aRow['rekananshipping_name'];
			   $row[]=$aRow['schedulepaymentdetil_unit'];
               $row[]=$aRow['agreementtype_name'];
               $row[]=$aRow['schedulepaymentdetil_descr'];
               $row[]=$aRow['schedulepaymentdetil_date'];
               $row[]=$aRow['duedate'];
               $row[]=$aRow['schedulepaymentdetil_posteddate'];
			   $row[]=number_format($aRow['schedulepaymentdetil_amount'], 2, '.', ',');
               $row[]=number_format($aRow['schedulepaymentdetil_idr'], 2, '.', ',');
               $row[]=$aRow['agreementtype_nameshort'];
               $row[]=$aRow['region_id'];
               $row[]=$aRow['channel_id'];
			   $row[]=$aRow['branch_id'];
			   $row[]=$aRow['agreementtype_id'];
			   $row[]=$aRow['rekanan_id'];
			   $row[]=$aRow['rekananshipping_line'];
			   $row[]=$aRow['ref_id'];
			   $row[]=$aRow['ref_line'];
			   $row[]=$aRow['schedulepaymentdetil_ischecked'];
			   $row[]=$aRow['schedulepaymentdetil_isposted'];
			   $row[]=$aRow['schedulepaymentdetil_ishold'];
			   $row[]=$aRow['schedulepaymentdetil_isdisabled'];

            if (!empty($row)) { $output['data'][] = $row; }
        	}
        	echo json_encode($output);

    }
	
	 
	
    function controler_gridlistnew($val_search = ''){
		$arcari=$this->globalsearch_list();
		$searchStatus = str_replace('_', '/', $val_search);
		$idUid = explode("-",$searchStatus);
		$jml=count($idUid)-1;
		$SOP_ID = "";
		$IDType = substr($searchStatus, 0, 2);
		
		for($i = 0, $size = count($idUid); $i < $size; ++$i) {
			$inv_id = $idUid[$i];
			if ($SOP_ID =='') {
				$SOP_ID = "'".$inv_id."'";
			}
			else{
				$SOP_ID = $SOP_ID . ",'".$inv_id."'";
				}
		}		
		//echo $searchStatus;
    //alert($searchStatus);
		$timestamp = time();
		$now = date("Y-m-d", $timestamp);
		$updatedate = 0;
		$qry_alldatalist = "qry_alldatalist";
		$qry_filteredlist = "qry_filteredlist";
		$qry_totalalllist = "qry_totalalllist";
		if ($IDType=="IN"){
			$criteria = " invoice_id in (" . $SOP_ID . ") and schedulepaymentdetil_idr > 0";
			}
		else {
			$criteria = " CTE.schedulepayment_id + convert(nvarchar,schedulepaymentdetil_line) in (" . $SOP_ID . ") and schedulepaymentdetil_idr > 0";
			}
		
 
		//echo $criteria;
    	$vResult=$this->initialize_grid($qry_alldatalist,$qry_filteredlist,$qry_totalalllist,$arcari,$criteria,$searchStatus);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['invoice_id']);
            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';

                $_menu='
                    <a href="/index.php/invoiceprint/invoiceprint/invoiceprintpdf/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
                    <img border="0" src="/assets/img/print.png" width="21" height="21"> </a>';


            $row = array();

			   $row[]=$aRow['schedulepayment_id'];
               $row[]=$aRow['schedulepaymentdetil_line'];
               $row[]=$aRow['invoice_id'];
               $row[]=$aRow['faktur_id'];
               $row[]=$aRow['region_nameshort'];
               $row[]=$aRow['branch_name'];
               $row[]=$ship_name;
               $row[]=$aRow['rekananshipping_name'];
			   $row[]=$aRow['schedulepaymentdetil_unit'];
               $row[]=$aRow['agreementtype_name'];
               $row[]=$aRow['schedulepaymentdetil_descr'];
               $row[]=$aRow['schedulepaymentdetil_date'];
               $row[]=$aRow['duedate'];
               $row[]=$aRow['schedulepaymentdetil_posteddate'];
			   $row[]=number_format($aRow['schedulepaymentdetil_amount'], 2, '.', ',');
               $row[]=number_format($aRow['schedulepaymentdetil_idr'], 2, '.', ',');
               $row[]=$aRow['agreementtype_nameshort'];
               $row[]=$aRow['region_id'];
               $row[]=$aRow['channel_id'];
			   $row[]=$aRow['branch_id'];
			   $row[]=$aRow['agreementtype_id'];
			   $row[]=$aRow['rekanan_id'];
			   $row[]=$aRow['rekananshipping_line'];
			   $row[]=$aRow['ref_id'];
			   $row[]=$aRow['ref_line'];
			   $row[]=$aRow['schedulepaymentdetil_ischecked'];
			   $row[]=$aRow['schedulepaymentdetil_isposted'];
			   $row[]=$aRow['schedulepaymentdetil_ishold'];
			   $row[]=$aRow['schedulepaymentdetil_isdisabled'];

            if (!empty($row)) { $output['data'][] = $row; }
        	}
        	echo json_encode($output);

    }

    function controler_gridlistSearch($val_search = '',$nil_search = ''){
    $arcari=$this->globalsearch_list();
    $searchStatus = $val_search;
    $searchNilai = $nil_search;


    $criteria = null;
    if($searchStatus == '1')
    {
      if(!empty($criteria))
      {
        $criteria = $criteria." AND region_id = $searchNilai";
      }
      else
      {
        $criteria =  " agreementtype_printouttype = 1";
      }
    }
    elseif($searchStatus == '2')
    {
      if(!empty($criteria))
      {
        $criteria = $criteria." AND agreementtype_printouttype = 2";
      }
      else
      {
        $criteria =  " agreementtype_printouttype = 2";
      }
    }
    elseif($searchStatus == '3')
    {
      if(!empty($criteria))
      {
        $criteria = $criteria." AND agreementtype_printouttype = 3";
      }
      else
      {
        $criteria =  " agreementtype_printouttype = 3";
      }
    }
    elseif($searchStatus == '4')
    {
      if(!empty($criteria))
      {
        $criteria = $criteria." AND B.region_id = 0";
      }
      else
      {
        $criteria =  " B.region_id = 0";
      }
    }
    else
    {
       $criteria =  null;
    }


      $vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
      $rResult=$vResult['rResult'];
      $output=$vResult['output'];

      foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['schedulepayment_id']);
            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';

                $_menu='
                    <a href="/index.php/looprint/looprint/looprintpdf/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
                    <img border="0" src="/assets/img/print.png" width="21" height="21"> </a>';


            $row = array();

               $row[]=$aRow['schedulepayment_id'];
               $row[]=$aRow['invoice_id'];
               $row[]=$aRow['faktur_id'];
               $row[]=$aRow['region_nameshort'];
               $row[]=$aRow['branch_name'];
               $row[]=$ship_name;
               $row[]=$aRow['rekananshipping_name'];
               $row[]=$aRow['agreementtype_name'];
               $row[]=$aRow['schedulepaymentdetil_descr'];
               $row[]=date("d-m-Y", strtotime($aRow['schedulepaymentdetil_date']));
               $row[]=date("d-m-Y", strtotime($aRow['schedulepaymentdetil_duedate']));
               $row[]=date("d-m-Y", strtotime($aRow['schedulepaymentdetil_proformadate']));
               $row[]=$aRow['schedulepaymentdetil_amount'];
               $row[]=$aRow['schedulepaymentdetil_idr'];
               $row[]=$_menu;

            if (!empty($row)) { $output['data'][] = $row; }
          }
          echo json_encode($output);

    }
    	
    function invoiceprintprolist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_invoice->viewinvoice($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('INVOICING PRINT OUT (Proforma)','invoicing_proforma/invoiceprintprolist');

        $this->load->view('template/v_header');
        $this->load->view('invoicing_proforma/invoiceprintpro_list', $data);
        $this->load->view('template/v_footer');
    }	

    function region_select(){
        $this->load->model('template/Master_m');
        $username=$this->session->userdata('username');

        $region     = $this->model_invoice->getregion($username);
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

    function tenant_select(){

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];
        //$rRegion = empty($_GET['region']) ? '' : $_GET['region'];


        if (is_array($rSearch) && $rSearch['_type'] == 'query'){

            $this->load->model('template/Master_m');

            $tenant      = $this->Master_m->get_tenant($rSearch['term']);

            $result['items']= $tenant;

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

        $options[0] = 'Permanent Leasing';
        $options[1] = 'Casual Leasing';

        return $options;
    }
   
	
    public function proformaprintpdf(){

        ini_set('memory_limit','512M'); 
        ini_set('sqlsrv.ClientBufferMaxKBSize','524288');
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288');
		
        $invo_id = $this->uri->segment(4);
        $i_link = $this->uri->segment(4);
        $fakt_id = $this->uri->segment(5);
        $username = $this->session->userdata('user_fullname');
        $invoice_id = $this->input->post('invoice_id');
        $faktur_id = $this->input->post('faktur_id');
        $region_id = $this->input->post('region_id');
        $report_type = $this->input->post('report_type');
        $invoicedate = $this->input->post('iinvoicedate');
        $cduedate = $this->input->post('cduedate'); 
        $invoiceduedate = $this->input->post('iinvoiceduedate');
        $ipapersize = $this->input->post('ipapersize'); 
        $cppndtp = $this->input->post('cppndtp'); 
        $strPPNDTP ="";  
	  
		if ($invo_id ==! '') {
			$invoice_id =  str_replace('_', '/', $invo_id);
			$faktur_id = str_replace('_', '/', $fakt_id);
		}	  	

		$idUid = explode("-",$invoice_id);
		$jml=count($idUid)-1;
		
		$idUid2 = explode("_",$faktur_id);
		$jml2=count($idUid2)-1;

		$str = $invoice_id;

	    for($i = 0, $size = count($idUid); $i < $size; ++$i) {

            $inv_id = $idUid[$i];
            $fak_id = $idUid2[$i];         

            if ($report_type == 'Proforma'){
                $fak_id ='-';
            }
            if ($fak_id == 'null'){
                $fak_id ='-';
            }
            //echo '--' . $inv_id . '--' . $fak_id; exit;
            $data['result'][] = $this->model_invoice->get_printout_invoice($inv_id,$fak_id);
            $data['resultTotal'][] = $this->model_invoice->get_printout_Total($inv_id,$fak_id);
            $print=$this->model_invoice->get_insert_logprint($inv_id,$fak_id,$username);
            
            $schedulepayment = $this->model_invoice->getschedulepayment($inv_id);
            $branch_id = $schedulepayment['branch_id'];
            
            $branch = $this->model_invoice->getmaster_branch($branch_id);
            $branch_logo = $branch['branch_logo'];
            $data['branch_logo'] = $branch_logo;	
        }
	
        $header = $this->model_invoice->get_printout_header($inv_id,$fak_id);
        $agreementtype_type = $header['agreementtype_type'];
        
        
        $data['region'] = $this->model_invoice->getmasterregion($region_id);

        $setting = $this->model_invoice->getmaster_setting('region_location');
        $region_location = $setting['setting_value'];
        
        $setting = $this->model_invoice->getmaster_setting('region_location');
        $region_location = $setting['setting_value'];
		
        $arrtgl=$this->model_invoice->gettglinv($inv_id);
        $data['iinvoicedate'] = $arrtgl['tglinv'];
        $data['iinvoiceduedate'] = $arrtgl['tgldue'];
        
        $data['ppndtp'] = $strPPNDTP;
        
        $data['manualdue'] = $cduedate;
        if ($cduedate == "on") {
            $data['iinvoiceduedate'] = $invoiceduedate;
        }	
		
        
		if ($region_location == 'Bandung'){
            if ($ipapersize == '0'){
                $html=$this->load->view('invoicing/rptproformaA4_TSMB', $data, true);
            } else {
                $html=$this->load->view('invoicing/_rptproformaA4_TSMB_CF', $data, true);
            }
		} else if ($region_location == 'Makassar'){
            if ($ipapersize == '0'){
                $html=$this->load->view('invoicing/rptproformaA4_TKM', $data, true);	
            } else {
                $html=$this->load->view('invoicing/rptproformaA4_TKM_CF', $data, true);
            }
		} else if ($region_location =='Bali') {
            if ($ipapersize == '0') {

                $html=$this->load->view('invoicing/rptproformaA4_TSMS', $data, true);
            } else {

                $html=$this->load->view('invoicing/rptproformaA4_TSMS_CF', $data, true);
            }
		} else if ($region_location =='Surabaya') {
			if ($ipapersize == '0'){
                $html=$this->load->view('invoicing/rptproformaA4_TSMS', $data, true);	
            } else {
                $html=$this->load->view('invoicing/rptproformaA4_TSMS_CF', $data, true);	
            }
		} else if ($region_location =='Cibubur') {
			if ($agreementtype_type == 'UTILITIES'){
                $html=$this->load->view('invoicing/rptinvoiceA4_utilities_bali', $data, true);
            } else {
                if ($ipapersize == '0'){
                    $html=$this->load->view('invoicing/rptproformaA4_TCP', $data, true);	
                } else {
                    $html=$this->load->view('invoicing/rptproformaA4_TCP_CF', $data, true);	
                }
			}
        } else {
			if ($agreementtype_type == 'UTILITIES'){
			    if ($region_id == '050'){
				    $html=$this->load->view('invoicing/rptinvoiceA4_utilities_ARI', $data, true);
				} else {
                    $html=$this->load->view('invoicing/rptinvoiceA4_utilities', $data, true);      					
				}
			}
			 else {
				$html=$this->load->view('invoicing/rptinvoiceA4', $data, true);	
			 }
		} 
		// print_r($data); exit;
		//$this->load->view('invoicing_proforma/rptproformaA4_TCP.php', $data);
		//$this->load->view('invoicing_proforma/_rptproformaA4_TSMB_CF', $data);
        /*
		$html = $this->load->view('invoicing/rptproformaA4_TCP', $data, true);
        $html = $this->load->view('invoicing/rptproformaA4_TSMB', $data, true);
        $html = $this->load->view('invoicing/rptproformaA4_TKM', $data, true);
        $html = $this->load->view('invoicing/rptproformaA4_TSMS', $data, true);
        */

       	$this->load->library('m_pdf_inv');
       	$pdfFilePath = "rptproformainvoice.pdf";	
 
		$this->m_pdf_inv->pdf->AddPage('P','LETTER','','','',4,4,4,4,0,0);
        $this->m_pdf_inv->pdf->WriteHTML($html);
        $this->m_pdf_inv->pdf->Output($pdfFilePath, "I");

    }
			
}
