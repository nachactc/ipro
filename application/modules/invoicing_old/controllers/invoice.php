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
        redirect('invoicing/invoice/invoicelist');
    }
    function globalsearch_dialog(){
		$arcari=array('unit_name', 'region_id', 'branch_id');
		return $arcari;
	}
    function globalsearch_rekanan(){
        $arcari=array('rekanan_name','A.rekanan_id', 'branch_id');
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
        $arcari=array('rekanan_id');
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

    function controler_gridtenant(){
        $arcari=$this->globalsearch_rekanan();
        $vResult=$this->initialize_grid("qry_alldatatenant","qry_filteredtenant","qry_totalalltenant",$arcari);
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
        $arcari=$this->globalsearch_region();
        $vResult=$this->initialize_grid("qry_alldataregion","qry_filteredregion","qry_totalallregion",$arcari);
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
        $arcari=$this->globalsearch_branch();
        $vResult=$this->initialize_grid("qry_alldatabranch","qry_filteredbranch","qry_totalallbranch",$arcari);
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
        $arcari=$this->globalsearch_brand();
        $vResult=$this->initialize_grid("qry_alldatabrand","qry_filteredbrand","qry_totalallbrand",$arcari);
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
        $arcari=$this->globalsearch_agrtype();
        $vResult=$this->initialize_grid("qry_alldataagrtype","qry_filteredagrtype","qry_totalallagrtype",$arcari);
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
        $arcari=$this->globalsearch_aging();
        $vResult=$this->initialize_grid("qry_alldataaging","qry_filteredaging","qry_totalallaging",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['jurnal_id'];
					$row[]=$aRow['jurnal_id'];
					$row[]=$aRow['jurnaldetil_line'];
                    $row[]=$aRow['jurnal_descr'];
					$row[]=$aRow['jurnaldetil_selisih'];
					$row[]='<input type="text" id="tamt[]" name="tamt[]" value="0" class="clsamt detil bulet form-control input-sm" style= "text-align: right;"/>';

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
		$arcari=array('B.region_id','B.branch_id','B.rekanan_id','BRAND.rekananshipping_line','CTE.agreementtype_id','schedulepaymentdetil_date','schedulepaymentdetil_duedate','schedulepaymentdetil_posteddate','agreementtype_printouttype','schedulepaymentdetil_proformadate','invoice_id', 'faktur_id','BRANCH.branch_name','REKAN.rekanan_name','BRAND.rekananshipping_name');
		return $arcari;
	}

	function initialize_grid($qry_alldata,$qry_filtered,$qry_totalall,$arcari,$cariOptional = ''){
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
		if ( isset($_POST['search']['value']) && $_POST['search']['value'] != "" ) {
		   $sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
				if ($aColumns[$i]=='rekanan_id')
				{
					$sWhere .= $aColumns[$i]." LIKE '" . "'%" .addslashes( $_POST['search']['value'] ). "%'" . "' OR ";
				}
				else
				{
					$sWhere .= $aColumns[$i]." LIKE '%".addslashes( $_POST['search']['value'] )."%' OR ";
				}
				
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
            if ($aColumns[$i] == 'schedulepaymentdetil_date'){
              $sWhere .= " AND schedulepaymentdetil_date >= "."'".$searchCol."'";
			  //$sWhere .= " AND CONVERT(VARCHAR, schedulepaymentdetil_date, 112) >= "."'".$searchCol."'";
            }
            elseif ($aColumns[$i] == 'schedulepaymentdetil_duedate'){
              $sWhere .= " AND schedulepaymentdetil_date <= "."'".$searchCol."'";
			  //$sWhere .= " AND CONVERT(VARCHAR, schedulepaymentdetil_date, 112) <= "."'".$searchCol."'";
            }
            elseif ($aColumns[$i] == 'schedulepaymentdetil_posteddate'){
              $sWhere .= " AND schedulepaymentdetil_posteddate = "."'".$searchCol."'";
			  //$sWhere .= " AND CONVERT(VARCHAR, schedulepaymentdetil_date, 112) <= "."'".$searchCol."'";
            }			
            elseif ($aColumns[$i] == 'schedulepaymentdetil_proformadate'){
              $sWhere .= " AND schedulepaymentdetil_proformadate = "."'".$searchCol."'";			  
            }									
            elseif ($aColumns[$i] == 'agreementtype_printouttype'){
              $sWhere .= " AND agreementtype_printouttype = ".$searchCol;
            }
            else {
              $sWhere .= " AND ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
            }
					} else {
            if ($aColumns[$i] == 'schedulepaymentdetil_date'){
              $sWhere .= " WHERE CONVERT(VARCHAR, schedulepaymentdetil_date, 112) >= "."'".$searchCol."'";
            }
            elseif ($aColumns[$i] == 'schedulepaymentdetil_duedate'){
              $sWhere .= " WHERE CONVERT(VARCHAR, schedulepaymentdetil_date, 112) <= "."'".$searchCol."'";
            }
            elseif ($aColumns[$i] == 'schedulepaymentdetil_posteddate'){
              $sWhere .= " AND schedulepaymentdetil_posteddate = "."'".$searchCol."'";			  
            }			
            elseif ($aColumns[$i] == 'schedulepaymentdetil_proformadate'){
              $sWhere .= " AND schedulepaymentdetil_proformadate = "."'".$searchCol."'";			  
            }						
            elseif ($aColumns[$i] == 'agreementtype_printouttype'){
              $sWhere .= " WHERE agreementtype_printouttype = ".$searchCol;
            }
            elseif ($aColumns[$i] == 'rekanan_id'){
              $sWhere .= " and rekanan_id = ".$searchCol;
            }			
            else {
                $sWhere = "WHERE ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
            }

					}
					// $sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;

				}
			}
		}

     $sWhere .=  $cariOptional <> '' ? " AND ".  $cariOptional : '' ;

     //echo "bug init -> " .$sWhere;



		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
		$limit=$limit+$top;

		$b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ;
		$sWhere = $sWhere.$b;

		$rResult=$this->model_invoice->$qry_alldata($limit,$top,$sWhere);

		$rResultCnt =$this->model_invoice->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_invoice->$qry_totalall();
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

    //alert($searchStatus);
		$timestamp = time();
		$now = date("Y-m-d", $timestamp);
		
		$criteria = null;
		//unchecked		
		if($searchStatus == '1')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_isposted = 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_isposted = 0";
			}
		}
		
		//checked
		elseif($searchStatus == '0')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_ischecked = 0 and schedulepaymentdetil_isposted = 0 and schedulepaymentdetil_idr > 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_ischecked = 0 and schedulepaymentdetil_isposted = 0 and schedulepaymentdetil_idr > 0";
			}
		}
		
		//posting
		elseif($searchStatus == '2')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 and schedulepaymentdetil_isposted = 0  and schedulepaymentdetil_idr > 0AND  jurnal_id is null ";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 and schedulepaymentdetil_isposted = 0  and schedulepaymentdetil_idr > 0AND  jurnal_id is null ";
			}
		}
		
		//Unposting
		elseif($searchStatus == '3')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 and schedulepaymentdetil_isposted = 1 and schedulepaymentdetil_idr > 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 and schedulepaymentdetil_isposted = 1 and schedulepaymentdetil_idr > 0";
			}
		}	
		//printout proforma
		elseif($searchStatus == '4')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_isposted = 0  AND schedulepaymentdetil_isproforma = 1 and schedulepaymentdetil_idr > 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_isposted = 0  AND schedulepaymentdetil_isproforma = 1 and schedulepaymentdetil_idr > 0";
			}
		}		
		//printout invoice
		elseif($searchStatus == '5')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_isposted = 1 ";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_isposted = 1 ";
			}
		}	
		//credite note
		elseif($searchStatus == '6')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND schedulepaymentdetil_isposted = 0 and CTE.agreementtype_id in ('2200','7200')";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_isposted = 0 and CTE.agreementtype_id in ('2200','7200')";
			}
		}		
    else
		{
			 $criteria =  null;
		}


	//if($criteria == null)
	//{
	//	$criteria = ' agreementtype_printouttype = 1 and CONVERT(VARCHAR, schedulepaymentdetil_date, 112) <= ' . "'". $now . "'";
	//}
          		
	//mudules::run('m');
	//$del =modules::run('master_rekananshipping/destroy',$rekanan_id,$rekananshipping_line);
    //echo "bug -->".$criteria;

    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
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
               $row[]=$aRow['schedulepaymentdetil_duedate'];
               $row[]=$aRow['schedulepaymentdetil_posteddate'];
			   $row[]=$aRow['schedulepaymentdetil_amount'];
               $row[]=$aRow['schedulepaymentdetil_idr'];
               $row[]=$aRow['agreementtype_nameshort'];
               $row[]=$aRow['region_id'];
               $row[]=$aRow['channel_id'];
			   $row[]=$aRow['branch_id'];
			   $row[]=$aRow['agreementtype_id'];
			   $row[]=$aRow['rekanan_id'];
			   $row[]=$aRow['rekananshipping_line'];

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

    function invoicelist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_invoice->viewinvoice($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('INVOICING','invoicing/invoicelist');

        $this->load->view('template/v_header');
        $this->load->view('invoicing/invoice_list', $data);
        $this->load->view('template/v_footer');
    }

    function invoicecancellist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_invoice->viewinvoice($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('INVOICING CANCEL','invoicing/invoicecancellist');

        $this->load->view('template/v_header');
        $this->load->view('invoicing/invoicecancel_list', $data);
        $this->load->view('template/v_footer');
    }

    function invoicepostinglist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_invoice->viewinvoice($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('INVOICING POSTING JURNAL','invoicing/invoicepostinglist');

        $this->load->view('template/v_header');
        $this->load->view('invoicing/invoiceposting_list', $data);
        $this->load->view('template/v_footer');
    }   
	function invoicepostingcnlist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_invoice->viewinvoice($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('INVOICING POSTING CREDIT NOTE','invoicing/invoicepostingcnlist');

        $this->load->view('template/v_header');
        $this->load->view('invoicing/invoicepostingcn_list', $data);
        $this->load->view('template/v_footer');
    }   
    function invoiceunpostinglist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_invoice->viewinvoice($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('INVOICING UN POSTING JURNAL','invoicing/invoiceunpostinglist');

        $this->load->view('template/v_header');
        $this->load->view('invoicing/invoiceunposting_list', $data);
        $this->load->view('template/v_footer');
    } 

    function invoiceprintinva4list(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_invoice->viewinvoice($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('INVOICING PRINT OUT (INVOICE A4)','invoicing/invoiceprintinva4list');

        $this->load->view('template/v_header');
        $this->load->view('invoicing/invoiceprintinva4_list', $data);
        $this->load->view('template/v_footer');
    }
    function invoiceprintinvlist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_invoice->viewinvoice($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('INVOICING PRINT OUT (INVOICE)','invoicing/invoiceprintinvlist');

        $this->load->view('template/v_header');
        $this->load->view('invoicing/invoiceprintinv_list', $data);
        $this->load->view('template/v_footer');
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

		$this->breadcrumbcomponent->add('INVOICING PRINT OUT (Proforma)','invoicing/invoiceprintprolist');

        $this->load->view('template/v_header');
        $this->load->view('invoicing/invoiceprintpro_list', $data);
        $this->load->view('template/v_footer');
    }	
	function invoicecnlist(){

        $loo_id = $this->uri->segment(4);
		$rekanan_id = $this->input->post('rekanan_id');
		$rekananshipping_line = $this->input->post('rekananshipping_line');
		
		$acc_id ='1020101';
		$where =' rekanan_id = ' ."'"."'".$rekanan_id."'"."'";
		
		$where = $where . ' and rekananshipping_line = ' ."'"."'".$rekananshipping_line."'"."'";
		$where2 = ' and acc_id = ' ."'"."'".$acc_id."'"."'";
        //echo $where;
		//exit;
		
		
        $data   = array(
                  'result'    => $this->model_invoice->viewinvoice($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select(),
				  'aging'    => $this->model_invoice->getaging($where,$where2)
            );
			
		//print_r ($this->model_invoice->getaging($where));
		//exit;
		
		// if (isset($_POST['btnpost'])){
			// $data['cek']="1";
			
			
		// }else{
			// $data['cek']="0";	
		// }
		
        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('INVOICING CREDIT NOTE','invoicing/invoicecnlist');

        $this->load->view('template/v_header');
        $this->load->view('invoicing/invoicepostingcn_list', $data);
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
 


  public function create_invoicing()
  {

      $id = $this->input->post('id');
      $line = $this->input->post('line');
      $region_nameshort = $this->input->post('regionnameshort');
      $agrtype = $this->input->post('agrtype');
      $region_id = $this->input->post('region_id');
      $channel_id = $this->input->post('channel_id');
	  $branch_id = $this->input->post('branch_id');
	  $proforma_date = $this->input->post('proforma_date');
	  $agreementtype_id = $this->input->post('agreementtype_id');
	  $proforma_by          = $this->session->userdata('user_fullname');	  
      $button             = $this->input->post('button');

	   
	   //$periode = date('yy', $now);
	    //echo ($now);
		
		$criteria = ' schedulepayment_id = ' ."'"."'".$id."'"."'".' and schedulepaymentdetil_line = ' ."'"."'".$line."'"."'";
		
      //$bo_id=$this->model_invoice->get_BOID($id, $line, $agrtype, $region_id, $region_nameshort, $channel_id);
	  $bo_id= '';
	  $invidx=$this->model_invoice->get_INVID($criteria,$channel_id, $branch_id, $agreementtype_id, $bo_id, $proforma_date,$proforma_by);
	  if (!empty($invidx)){
		  $data['pesan'] = 'successful invoicing';
	  }
	  else {
		  $data['pesan'] = 'unsuccessful invoicing';
	  }
	  
	  
	  //echo ($invoice_id);
      echo json_encode($data);
  }


  
  public function cancel_invoicing()
  {

      $id = $this->input->post('id');
      $line = $this->input->post('line');
      $region_nameshort = $this->input->post('regionnameshort');
      $agrtype = $this->input->post('agrtype');
      $region_id = $this->input->post('region_id');
      $channel_id = $this->input->post('channel_id');
	  $branch_id = $this->input->post('branch_id');
	  $proforma_date = $this->input->post('proforma_date');
	  $agreementtype_id = $this->input->post('agreementtype_id');
	  $username          = $this->session->userdata('user_fullname');
	  $invoice_id = $this->input->post('invoice_id');
	  
	  
		$bo_id ='';
		$isposted ='1';		
		$reason = $this->input->post('reason');
	  //echo $region_id;
	  //exit;
		$cek_or = $this->model_invoice->get_cek_or($id, $line);
		$or_id = $cek_or['jurnal_id'];
		if ($or_id != '')
		{
			$data['pesan'] = $invoice_id . ', OR Masih Ada';
			$data['OR'] = 'OR MASIH ADA';
		}
		else
		{
			$data['OR'] = 'OR BELUM ADA';
			
			  $invidx=$this->model_invoice->get_cancel_invoice($bo_id,$id, $line, $username, $isposted, $reason);
			  $data['pesan'] = 'successful cancel invoicing';
		
		}
		

	  
      echo json_encode($data);
  }
  
  public function posting_cn()
  {
      $schedulepayment_id = $this->input->post('schedulepayment_id');
      $schedulepaymentdetil_line = $this->input->post('schedulepaymentdetil_line');
	  $rekanan_id = $this->input->post('rekanan_id');
	  $rekananshipping_line = $this->input->post('rekananshipping_line');
	  $jurnal_id = $this->input->post('jurnal_id');
	  $jurnaldetil_line = $this->input->post('jurnaldetil_line');
	  $cntype = $this->input->post('cntype');
	  $taxtype = $this->input->post('taxtype');
	  $post_date = $this->input->post('postdate');
	  $username          = $this->session->userdata('user_fullname');
	  $isposted = 1;
	  $reason = '';
	  //echo 'bug-> post_date : ' . $post_date;
	   // echo 'bug-> schedulepayment_id : ' . $schedulepayment_id . ' - schedulepaymentdetil_line : ' . $schedulepaymentdetil_line . ' - rekanan_id : ' . $rekanan_id . ' - rekananshipping_line : ' . $rekananshipping_line . ' - jurnal_id : ' . $jurnal_id . ' - jurnaldetil_line : ' . $jurnaldetil_line;
	    //exit;
	  $inv_app=$this->model_invoice->get_cn_posting($schedulepayment_id, $schedulepaymentdetil_line, $username, $isposted, $post_date, $jurnal_id, $jurnaldetil_line, $reason, $cntype, $taxtype);

		//echo json_encode($data);
		
  }
  public function posting_invoicing()
  {

      $id = $this->input->post('id');
      $line = $this->input->post('line');
      $region_nameshort = $this->input->post('regionnameshort');
      $agrtype = $this->input->post('agrtype');
      $region_id = $this->input->post('region_id');
      $channel_id = $this->input->post('channel_id');
	  $branch_id = $this->input->post('branch_id');
	  $post_date = $this->input->post('proforma_date');
	  $agreementtype_id = $this->input->post('agreementtype_id');
	  $username          = $this->session->userdata('user_fullname');
	  $invoice_id = $this->input->post('invoice_id');
	  $isposted ='1';
	  

	  
	  $schedulepayment=$this->model_invoice->get_schedulepayment($id);
	  $rekanan_id = $schedulepayment['rekanan_id'];

	
	  
	  $master_rekanan=$this->model_invoice->get_master_rekanan($rekanan_id);
	  $rekanan_taxprefix = $master_rekanan['rekanan_taxprefix'];


	  
	  $master_agreementtype=$this->model_invoice->get_master_agreementtype($agreementtype_id);
	  $agreementtype_type = $master_agreementtype['agreementtype_type'];


	  
	  $Criteria = ' isdisabled = 0 and branch_id = ' ."'"."'".$branch_id."'"."'";
	  $Criteria2 = '';
	  


	  
	  $taxbranch=$this->model_invoice->get_master_taxbranch($Criteria);
	  if (!empty($taxbranch)){
		  //$taxbranch_id ='1';
		  $Criteria2 = ' tax_status = 0 and tax_isdisable = 0 and region_id = ' ."'"."'".$region_id."'"."'". ' and branch_id = ' ."'"."'".$branch_id."'"."'";
	  }
	  else {
		  //$taxbranch_id ='0';
		  $Criteria2 = ' tax_status = 0 and tax_isdisable = 0 and region_id = ' ."'"."'".$region_id."'"."'" . ' and A.taxbranch_id = 0';
	  }
  

	  
	  $taxnumber=$this->model_invoice->get_master_taxnumber($Criteria2);  
	  $taxnomor = $taxnumber['tax_no'];

  	  //echo $taxnomor;
	  //exit;
	  
	//echo "<script>setTimeout(\"location.href = '".site_url('semester')."';\",10);";
			
	  if (!empty($taxnumber)){
		  $tax_no = $taxnumber['tax_no'];
		  $faktur_id = $rekanan_taxprefix . $tax_no;
		  //posting jurnal
		  $inv_app=$this->model_invoice->get_invoice_approved($id, $line, $username, $isposted, $post_date);
		  if($agreementtype_type != 'DEPOSIT' and $agreementtype_type != 'LOAN'){
			$faktur=$this->model_invoice->get_faktur_update($faktur_id, $invoice_id, $line, $post_date);  
		  }
		  $data['pesan'] = 'successful posting';
	  } else {
			$data['pesan'] = 'unsuccessful, empty tax number';
	  }
	  
	  //echo ($agreementtype_type . ' - ' . $Criteria2);
	  //$invidx=$this->model_invoice->get_cancel_invoice($bo_id,$id, $line, $username, $isposted);

      echo json_encode($data);
  }


    function invoicing_posting(){

        if ($_POST){

           $_APP = empty($_POST['postid']) ? '' : $_POST['postid'];
           //$password = empty($_POST['pwd']) ? '' : $_POST['pwd'];           
           
        }

        // Treat input as username
        //$type = 'username';

        //$username   = $this->session->userdata('username');  
        //$channel_id = $this->session->userdata('channel_id');             
		//print_r($_POST);
		//exit;
		
		$reason ='';
		
		if (is_array($_APP)){
			   if (count($_APP) >0){
				  foreach ($_APP as $key){       

					$id   = $key[0];
					$line         = $key[1];
					$invoice_id = $key[2];
					$region_nameshort = $key[3];
					$agr_type = $key[4];
					$region_id = $key[5];
					$channel_id = $key[6];
					$branch_id = $key[7];
					$agreementtype_id = $key[8];
					$post_date = $key[9];
					$username          = $this->session->userdata('user_fullname');
					$isposted ='1';
					
					$schedulepayment=$this->model_invoice->get_schedulepayment($id);
					$rekanan_id = $schedulepayment['rekanan_id'];

					  $master_rekanan=$this->model_invoice->get_master_rekanan($rekanan_id);
					  $rekanan_taxprefix = $master_rekanan['rekanan_taxprefix'];
					  
					  $master_agreementtype=$this->model_invoice->get_master_agreementtype($agreementtype_id);
					  $agreementtype_type = $master_agreementtype['agreementtype_type'];
					  
					  $Criteria = ' isdisabled = 0 and branch_id = ' ."'"."'".$branch_id."'"."'";
					  $Criteria2 = '';
					  
					  //echo $id;
					  //echo $line;
					  
					  $taxbranch=$this->model_invoice->get_master_taxbranch($Criteria);
					  if (!empty($taxbranch)){
						  //$taxbranch_id ='1';
						  $Criteria2 = ' tax_status = 0 and tax_isdisable = 0 and region_id = ' ."'"."'".$region_id."'"."'". ' and branch_id = ' ."'"."'".$branch_id."'"."'";
					  }
					  else {
						  //$taxbranch_id ='0';
						  $Criteria2 = ' tax_status = 0 and tax_isdisable = 0 and region_id = ' ."'"."'".$region_id."'"."'" . ' and A.taxbranch_id = 0';
					  }
					  
					  // echo $Criteria2;
					  // exit;
					  
					  $taxnumber=$this->model_invoice->get_master_taxnumber($Criteria2);  
					  $taxnomor = $taxnumber['tax_no'];		
					  //echo $Criteria2;
					  if (!empty($taxnumber)){
						  $tax_no = $taxnumber['tax_no'];
						  $faktur_id = $rekanan_taxprefix . $tax_no;
						  //posting jurnal
						  
						  if($this->model_invoice->get_invoice_approved_new($id, $line, $username, $isposted, $post_date, $reason))
						  {							  
							  if($agreementtype_type != 'DEPOSIT' and $agreementtype_type != 'LOAN'){							  
								if($this->model_invoice->get_faktur_update_new($faktur_id, $invoice_id, $line, $post_date))
								  {
										$result['success'] = TRUE;
										$result['data'] = $invoice_id;
										echo json_encode($result);							  
								  }
							  }							  							  
						  }else{							  
								$result['success'] = FALSE;     
								$result['data'] = $invoice_id;
								echo json_encode($result);  
							}
													  						  
					  } else {
									$result['success'] = FALSE;     
									$result['data'] = 'empty tax number';
									echo json_encode($result);
					  }
	  
				  }  
			   }
			 }
	 
        
    }
  
  public function unposting_invoicing()
  {

      $id = $this->input->post('id');
      $line = $this->input->post('line');
      $region_nameshort = $this->input->post('regionnameshort');
      $agrtype = $this->input->post('agrtype');
      $region_id = $this->input->post('region_id');
      $channel_id = $this->input->post('channel_id');
	  $branch_id = $this->input->post('branch_id');
	  $post_date = $this->input->post('proforma_date');
	  $agreementtype_id = $this->input->post('agreementtype_id');
	  $username          = $this->session->userdata('user_fullname');
	  $invoice_id = $this->input->post('invoice_id');
	  $isposted ='0';
	  $reason = $this->input->post('reason');
	  	   
		$cek_or = $this->model_invoice->get_cek_or($id, $line);
		$or_id = $cek_or['jurnal_id'];
		if ($or_id != '')
		{
			$data['pesan'] = $invoice_id . ', OR Masih Ada';
			$data['OR'] = 'OR MASIH ADA';
		}
		else
		{
			$data['OR'] = 'OR BELUM ADA';
			
			$inv_app=$this->model_invoice->get_invoice_approved($id, $line, $username, $isposted, $post_date, $reason);
			$data['pesan'] = 'successful unposting';
		
		}
		//echo 'No OR : ' . $or_id;
		//exit;
		

		
		
		//$data['result'] = $schedulepayment;
		
		
		
		
		//$this->session->set_flashdata('message', 'Data  berhasil di simpan');

		  //unposting jurnal
		  //$invapp=$this->model_invoice->get_invoice_approved($id, $line, $username, $isposted, $post_date);


 	 
	  
	  //echo ($faktur_id);
	  //$invidx=$this->model_invoice->get_cancel_invoice($bo_id,$id, $line, $username, $isposted);

      echo json_encode($data);
  }
   
	
  public function proformaprintpdfA4(){

		ini_set('memory_limit','256M'); 
		ini_set('sqlsrv.ClientBufferMaxKBSize','524288');
		ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288');
		
	  $invo_id = $this->uri->segment(4);
	  $i_link = $this->uri->segment(4);
	  $fakt_id = $this->uri->segment(5);
	  // echo '-inv : ' . $invo_id . ' -> faktur : ' . $fakt_id;
	  // exit;
	  
	  $invoice_id = $this->input->post('invoice_id');
	  $faktur_id = $this->input->post('faktur_id');
	  $region_id = $this->input->post('region_id');
	  $report_type = $this->input->post('report_type');
	  $invoicedate = $this->input->post('iinvoicedate');
	  $invoiceduedate = $this->input->post('iinvoiceduedate');
	  
	
	  //$region=$this->model_invoice->getmasterregion($region_id);
	  //$region_npwp=$region['region_npwp'];
	  
	  //$i_size = $this->input->post('papersize');
	  //$printdate = $this->input->post('print_date');	  
	  
		if ($invo_id ==! '') {
			$invoice_id =  str_replace('_', '/', $invo_id);
			$faktur_id = str_replace('_', '/', $fakt_id);
		}
	  	// echo '-' . $invoice_id . '-' . $faktur_id;
		// exit;
	   /*
		$i_size = substr($i_link, -2);
		$i_link = substr_replace($i_link, "", -2);
		//echo $i_link;
		//$i_link2 = $this->uri->segment(5);
		$invoice_id = str_replace('_', '/', $i_link);
        //$invoice_id = str_replace('X', '_', $invoice_id);
		$invoice_id = str_replace('-', '.', $invoice_id);
		//$faktur_id = $i_link2;
*/

		$idUid = explode("-",$invoice_id);
		$jml=count($idUid)-1;
		
		$idUid2 = explode("_",$faktur_id);
		$jml2=count($idUid2)-1;

		$str = $invoice_id;
		//echo strtok($str, '_');
		
		//exit;
		//print_r($idUid);
		//echo $idUid; exit;
		//echo $invoice_id;
for($i = 0, $size = count($idUid); $i < $size; ++$i) {

        //$invfak_id = $idUid[$i];
		$inv_id = $idUid[$i];
		$fak_id = $idUid2[$i];
		//$inv_id = strtok($invfak_id,'F');		
		//$fak_id = strstr($invfak_id, 'F');
		//$fak_id = str_replace('F', '', $fak_id);
		//$fak_id = str_replace('/', '-', $fak_id);
		

		if ($report_type == 'Proforma'){
			$fak_id ='-';
		}
		//echo '--' . $inv_id . '--' . $fak_id; exit;
        $data['result'][] = $this->model_invoice->get_printout_invoice($inv_id,$fak_id);
		$data['resultTotal'][] = $this->model_invoice->get_printout_Total($inv_id,$fak_id);
      }
	
	$header 			= $this->model_invoice->get_printout_header($inv_id,$fak_id);
	//$region_id 			= $header['region_id'];
	$agreementtype_type = $header['agreementtype_type'];
	
	
	$data['region'] = $this->model_invoice->getmasterregion($region_id);
	//$data['iinvoicedate'] = $invoicedate;
	//$data['iinvoiceduedate'] = $invoiceduedate;
	
	$arrtgl=$this->model_invoice->gettglinv($inv_id);
	$data['iinvoicedate'] = $arrtgl['tglinv'];
	$data['iinvoiceduedate'] = $arrtgl['tgldue'];
/*	  
    for($i=0;$i<=$jml;$i++)
    {
        $inv_id = $idUid[$i];
        $data   = array(
                  'result'      => $this->model_invoiceprint->get_printout_proforma($inv_id)
               );		
    }		
	*/
		// echo $fak_id;
		// exit;
	// print_r($header);
	// exit;
	
		
		//$this->load->view('schedule_payment/rptsop', $data);
		
		 if ($region_id == '001'){
		$html=$this->load->view('invoicing/rptproformaA4_TCP', $data, true);		
		//$this->load->view('invoicing/rptproformaA4_TCP', $data);		
		
		 }
		 else {
			 if ($agreementtype_type == 'UTILITIES'){
				 $html=$this->load->view('invoicing/rptinvoiceA4_utilities', $data, true);		
				 }
			 else {
				 $html=$this->load->view('invoicing/rptinvoiceA4', $data, true);		
			 }
			
		 }
     
       $this->load->library('m_pdf');
       $pdfFilePath = "rptproformainvoice.pdf";	

		$this->m_pdf->pdf->SetHTMLHeader('<table width="100%"><tr><td align="right" style="font-size:10px"></td></tr></table>');
		$this->m_pdf->pdf->AddPage('P','A4','','','',3,3,3,3,15,8);
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");
		

    }

public function proformaprintpdf(){

	  
	  
	  $invoice_id = $this->input->post('invoice_id');
	  $faktur_id = $this->input->post('faktur_id');
	  $region_id = $this->input->post('region_id');
	  //$i_size = $this->input->post('papersize');
	  //$printdate = $this->input->post('print_date');	  
	  
	  //echo $invoice_id;
	  //exit;
	  
	   /*
		$i_size = substr($i_link, -2);
		$i_link = substr_replace($i_link, "", -2);
		//echo $i_link;
		//$i_link2 = $this->uri->segment(5);
		$invoice_id = str_replace('_', '/', $i_link);
        //$invoice_id = str_replace('X', '_', $invoice_id);
		$invoice_id = str_replace('-', '.', $invoice_id);
		//$faktur_id = $i_link2;
*/
		
		$idUid = explode("-",$invoice_id);
		$jml=count($idUid)-1;
		
		$idUid2 = explode("_",$faktur_id);
		$jml2=count($idUid2)-1;

		$str = $invoice_id;
		//echo strtok($str, '_');
		
		//exit;
		//print_r($idUid);
		//echo $idUid; exit;
		//echo $invoice_id;
		for($i = 0, $size = count($idUid); $i < $size; ++$i) {

        //$invfak_id = $idUid[$i];
		$inv_id = $idUid[$i];
		//$fak_id = $idUid2[$i];
		//$inv_id = strtok($invfak_id,'F');		
		//$fak_id = strstr($invfak_id, 'F');
		//$fak_id = str_replace('F', '', $fak_id);
		//$fak_id = str_replace('/', '-', $fak_id);
		
		//echo $fak_id;
		//exit;
        $data['result'][] = $this->model_invoice->get_printout_proforma($inv_id);
		
      }
	$data['region'] = $this->model_invoice->getmasterregion($region_id);


       

		if ($region_id == '001'){
		$html=$this->load->view('invoicing/rptproformaA4_TCP', $data, true);		
		}
		else {
		$html=$this->load->view('invoicing/rptproformaA4', $data, true);	
		}
		
       $this->load->library('m_pdf');
       $pdfFilePath = "rptproformaA4.pdf";	

		$this->m_pdf->pdf->SetHTMLHeader('<table width="100%"><tr><td align="right" style="font-size:10px"></td></tr></table>');
		$this->m_pdf->pdf->AddPage('P','A4','','','',3,3,3,3,15,8);
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");

    }
	
  function create_inv($val_search = ''){

      echo '$val_search';

      $id = empty($_GET['id']) ? '' : $_GET['id'];

      $id = trim($id);

      if ($id == 'auto'){ $id = ''; }


      //$datatables = $_POST;
      //$rResult = $this->model_loo->getskema($id);


  }
    function loo_getskema(){

        $id = empty($_GET['id']) ? '' : $_GET['id'];

        $id = trim($id);

        if ($id == 'auto'){ $id = ''; }

        //$datatables = $_POST;
        $rResult = $this->model_invoice->getskema($id);

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

                $vsc=$this->model_invoice->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];

                $vpl=$this->model_invoice->getpromolevy($loo_id);
                $vpromolevy=$vpl['promolevy'];

                $dps=$this->model_invoice->getdepositr($loo_id);
                $vdps=$dps['depositr'];



        $data   = array(
                  'result'    => $this->model_invoice->viewinvoiceprint($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_invoice->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_invoice->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps

               );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_invoice->sholdetilby_id($loo_id);

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

                $vsc=$this->model_invoice->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];

                $vpl=$this->model_invoice->getpromolevy($loo_id);
                $vpromolevy=$vpl['promolevy'];

                $dps=$this->model_invoice->getdepositr($loo_id);
                $vdps=$dps['depositr'];
                $nildps=$dps['loodetil_baserent'];



        $data   = array(
                  'result'    => $this->model_invoice->viewconfprint($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_invoice->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_invoice->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps,
                  'nildps' =>$nildps

               );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_invoice->sholdetilby_id($loo_id);

        $html=$this->load->view('loo/rptconf', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptlooconf.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");


    }

    function invoiceprintpropdf(){
        //echo ('bug -> ' .$loo_id)
        $i_link = $this->uri->segment(4);
        $loo_id = str_replace('_', '/', $i_link);
        $loo_id = str_replace('X', ',', $loo_id);


        //$print_name = 'Suhendra';//$this->session->userdata('user_fullname');

        //$unitspace  =$this->model_invoiceprint->getunitspace();
        //$v_dp =$_dp['dp'];

        $data   = array(
                  'result'      => $this->model_invoice->get_printout_proforma($loo_id),
                  'resultdetil'      => $this->model_invoice->get_printout_proforma($loo_id),
                  'unitspace'  => $this->model_invoice->getunitspace()
               );

        //echo ('bug -> ' .$data);
        //$data['resultd'] = $this->model_invoiceprint->sholdetilby_id($loo_id);

        //$this->load->view('looprint/rptinpro', $data);
        
		//$this->load->view('invoice/rptproforma', $data);
		
				$html=$this->load->view('invoice/rptproformaA', $data,TRUE);
				$this->load->library('m_pdf');
				$pdfFilePath = "rptproforma.pdf";	
/*
       $html=$this->load->view('invoiceprint/rptinvoice', $data, TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptinvoice.pdf";


        //$this->m_pdf->pdf->SetHTMLHeader('<table width="100%"><tr><td align="right" style="font-size:10px">{PAGENO}/{nb}</td></tr></table>');
        //$this->m_pdf->pdf->AddPage('P', 'Legal');
      //  $this->m_pdf->pdf->AddPage('P','Legal','','','',1,1,1,1,15,8);


        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");
*/
    }
function invoicing_Export(){

		$region_id = $this->input->post('hregion');
        $region_name = $this->input->post('iregion');
        $branch_id = $this->input->post('hbranch');
        $branch_name = $this->input->post('ibranch');
        $rekanan_id = $this->input->post('htenant');
        $rekanan_name = $this->input->post('itenant');
        $rekananshipping_line = $this->input->post('hbrand');
        $rekananshipping_name = $this->input->post('ibrand');
        $startdate = $this->input->post('iperiodefrom');
        $enddate = $this->input->post('iperiodeend');
        $button			= $this->input->post('button');
		$invoicetype			= $this->input->post('invoicetype');
		$cdatefrom = $this->input->post('cperiodefrom');
		$cdateend = $this->input->post('cperiodeend');
		$where = $this->input->post('hcriteria');
		
		//echo $cdatefrom;
		//exit;
		/*
        if ($_POST){

           $_APP = empty($_POST['postid']) ? '' : $_POST['postid'];
           //$password = empty($_POST['pwd']) ? '' : $_POST['pwd'];           
           
        }

        // Treat input as username
        //$type = 'username';

        //$username   = $this->session->userdata('username');  
        //$channel_id = $this->session->userdata('channel_id');      
		$region_id   = $_APP[0][0];
		$branch_id   = $_APP[0][1];
		$rekanan_id   = $_APP[0][2];
		$rekananshipping_line   = $_APP[0][3];
		$agreementype_id   = $_APP[0][4];
		$invoicetype   = $_APP[0][5];
		$startdate   = $_APP[0][6];
		$enddate   = $_APP[0][7];
		$postdate   = $_APP[0][8];
		$region_name   = $_APP[0][10];
		$branch_name   = $_APP[0][11];
		$rekanan_name   = $_APP[0][12];
		$rekananshipping_name   = $_APP[0][13];
*/
		
		$where =' where schedulepaymentdetil_isposted = 0 and schedulepaymentdetil_ischecked = 0 ';
		$button ='EXCEL';
		
		if (isset($region_id)){
		  $where =$where . ' and B.region_id = ' ."'".$region_id."'";
		}
		if ($branch_id ==! ''){
		  $where =$where. ' and B.branch_id = ' ."'".$branch_id."'";
		}
		if ($rekanan_id ==! ''){
		  $where =$where. ' and B.rekanan_id = ' ."'".$rekanan_id."'";
		}
		if ($rekananshipping_line ==! ''){
		  $where =$where. ' and B.rekananshipping_line = ' ."'".$rekananshipping_line."'";
		}
		if ($startdate ==! ''){
		  $where =$where. ' and schedulepaymentdetil_date >= ' ."'".$startdate."'" .' and schedulepaymentdetil_date <= '."'".$enddate."'";
		}
		if ($invoicetype ==! ''){
		  $where =$where. ' and agreementtype_printouttype = ' ."'".$invoicetype."'";
		}

        $data   = array(
                  'result'      => $this->model_invoice->qry_invoicelist($where),
                  //'resultdetil'      => $this->model_soprptprint->viewinvprintdetil($loo_id),
                  //'unitspace'  => $this->model_soprptprint->getunitspace()
                  'region_id'   => $region_id,
                  'branch_id'   => $branch_id,
                  'rekanan_id'   => $rekanan_id,
                  'rekananshipping_line'   => $rekananshipping_line,
				  'region_name'   => $region_name,
                  'branch_name'   => $branch_name,
                  'rekanan_name'   => $rekanan_name,
                  'rekananshipping_name'   => $rekananshipping_name,
                  'startdate'   => $startdate,
                  'enddate'   => $enddate,
				  'button'     => $button
               );
		//echo $where;
		//print_r($data);
		//exit;
		
		$this->load->view('invoicing/rptexcel', $data);
	 
        
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
	function cn_getaging(){
        
		//echo '-' . $id . ' -' . $line;
		//exit;
		
        $id = empty($_GET['id']) ? '' : $_GET['id'];
		$line = empty($_GET['line']) ? '' : $_GET['line'];

        $id = trim($id);

        if ($id == 'auto'){ $id = ''; }            

        //$datatables = $_POST;        

		$where =' rekanan_id = ' ."'"."'".$id."'"."'";
		
        $rResult = $this->model_invoice->getaging($where);        

        foreach ($rResult as $aRow) {

            $row = array();            
            $row[]=$aRow['jurnal_id'];
            $row[]=$aRow['jurnaldetil_line'];
            $row[]=$aRow['jurnal_descr'];
            $row[]=$aRow['jurnaldetil_idr'];

        if (!empty($row)) { $output['data'][] = $row; }
        }   
        echo json_encode($output);
    }
}
