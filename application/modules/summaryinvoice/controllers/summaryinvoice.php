<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Summaryinvoice extends CI_Controller{

    function __construct(){

        parent::__construct();
        // Check login and make sure email has been verified
        check_user_login();

        $this->load->model('model_summaryinvoice');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
    }

    function index(){
        redirect('summaryinvoice/summaryinvoice/summaryinvoicelist');
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
		$arcari=array('B.region_id','B.branch_id','B.rekanan_id','BRAND.rekananshipping_line','CTE.agreementtype_id','schedulepaymentdetil_date','schedulepaymentdetil_duedate','schedulepaymentdetil_proformadate','agreementtype_printouttype','summaryinvoice_id', 'faktur_id','CTE.schedulepayment_id','BRANCH.branch_name','REKAN.rekanan_name','BRAND.rekananshipping_name');
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
            if ($aColumns[$i] == 'schedulepaymentdetil_date'){
              $sWhere .= " AND CONVERT(VARCHAR, schedulepaymentdetil_date, 112) >= ".$searchCol;
            }
            elseif ($aColumns[$i] == 'schedulepaymentdetil_duedate'){
              $sWhere .= " AND CONVERT(VARCHAR, schedulepaymentdetil_date, 112) <= ".$searchCol;
            }
            elseif ($aColumns[$i] == 'schedulepaymentdetil_proformadate'){
              $sWhere .= " AND CONVERT(VARCHAR, schedulepaymentdetil_proformadate, 112) = ".$searchCol;
            }
            elseif ($aColumns[$i] == 'agreementtype_printouttype'){
              $sWhere .= " AND agreementtype_printouttype = ".$searchCol;
            }
            else {
              $sWhere .= " AND ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
            }
					} else {
            if ($aColumns[$i] == 'schedulepaymentdetil_date'){
              $sWhere .= " WHERE CONVERT(VARCHAR, schedulepaymentdetil_date, 112) >= ".$searchCol;
            }
            elseif ($aColumns[$i] == 'schedulepaymentdetil_duedate'){
              $sWhere .= " WHERE CONVERT(VARCHAR, schedulepaymentdetil_date, 112) <= ".$searchCol;
            }
            elseif ($aColumns[$i] == 'schedulepaymentdetil_proformadate'){
              $sWhere .= " WHERE CONVERT(VARCHAR, schedulepaymentdetil_proformadate, 112) = ".$searchCol;
            }
            elseif ($aColumns[$i] == 'agreementtype_printouttype'){
              $sWhere .= " WHERE agreementtype_printouttype = ".$searchCol;
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

    // echo "bug init -> " .$sWhere;



		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
		$limit=$limit+$top;

		$b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ;
		$sWhere = $sWhere.$b;
		
		$sWhereUser = "";
		$username=$this->session->userdata('username');
		if ($sWhere =='') {
			$sWhereUser = " where username = "."'".$username."'";
		}
        else
		{
			$sWhereUser = " and username = "."'".$username."'";
		}
		

		$rResult=$this->model_summaryinvoice->$qry_alldata($limit,$top,$sWhere);

		$rResultCnt =$this->model_summaryinvoice->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_summaryinvoice->$qry_totalall();
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


    function controler_gridlist($val_search = '',$val_datefrom='0',$val_dateend='0',$val_postdate='0'){
		$arcari=$this->globalsearch_list();
		$searchStatus = $val_search;

    //alert($searchStatus);
		$criteria = null;
		if($searchStatus == 'general')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." agreementtype_printouttype = 1";
			}
			else
			{
				$criteria =  " agreementtype_printouttype = 1";
			}
		}
		elseif($searchStatus == 'deposit')
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
		elseif($searchStatus == 'utilities')
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
    else
		{
			 $criteria =  null;
		}

    if($val_datefrom != '0')
        {
          if(!empty($criteria))
          {
            $criteria = $criteria." AND CONVERT(VARCHAR, schedulepaymentdetil_date, 112) >= $val_datefrom ";
          }
          else
          {
            $criteria =  " CONVERT(VARCHAR, schedulepaymentdetil_date, 112) >= $val_datefrom ";
          }
        }


    if($val_dateend != '0')
        {
          if(!empty($criteria))
          {
            $criteria = $criteria." AND CONVERT(VARCHAR, schedulepaymentdetil_date, 112) <= $val_dateend ";
          }
          else
          {
            $criteria =  " CONVERT(VARCHAR, schedulepaymentdetil_date, 112) <= $val_dateend ";
          }
        }



        if($val_postdate != '0')
            {
              if(!empty($criteria))
              {
                $criteria = $criteria." AND CONVERT(VARCHAR, schedulepaymentdetil_proformadate, 112) = $val_postdate ";
              }
              else
              {
                $criteria =  " CONVERT(VARCHAR, schedulepaymentdetil_proformadate, 112) = $val_postdate ";
              }
            }


    //echo "bug -->".$criteria;

    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['summaryinvoice_id']);
            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';

                $_menu='
                    <a href="/index.php/summaryinvoiceprint/summaryinvoiceprint/summaryinvoiceprintpdf/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
                    <img border="0" src="/assets/img/print.png" width="21" height="21"> </a>';


            $row = array();

			         $row[]=$aRow['schedulepayment_id'];
               $row[]=$aRow['summaryinvoice_id'];
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
               $row[]=$aRow['summaryinvoice_id'];
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

    function summaryinvoicelist(){

        $data   = array(
                  'branch' => $this->branch_select()
            );

        //$data['region'] = $this->region_select();
        $data['region']['region_id'] = '';
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('Summary Monthly Invoice','summaryinvoice/summaryinvoicelist');

        $this->load->view('template/v_header');
        $this->load->view('summaryinvoice/summaryinvoice_list', $data);
        $this->load->view('template/v_footer');
    }

    function summaryinvoiceprintpdf(){
		ini_set('memory_limit','256M'); 
		ini_set('sqlsrv.ClientBufferMaxKBSize','524288');
		ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288');
        //echo ('bug -> ' .$loo_id)
        $region_id = $this->input->post('hregion');
        $region_name = $this->input->post('iregion');
        $branch_id = $this->input->post('hbranch');
        $branch_name = $this->input->post('ibranch');
        $rekanan_id = $this->input->post('htenant');
        $rekanan_name = $this->input->post('itenant');
        $rekananshipping_line = $this->input->post('hbrand');
        $rekananshipping_name = $this->input->post('ibrand');
        $cwht = $this->input->post('cwht');
		$iwht = $this->input->post('iwht');
        $cdate =  $this->input->post('cfromdate');
		$start_date = $this->input->post('ifromdate');
		$end_date = $this->input->post('ienddate');
        $itype = $this->input->post('itype');
		$igroup = $this->input->post('igroup');
		
        $button			= $this->input->post('button');

        //$print_name = 'Suhendra';//$this->session->userdata('user_fullname');

        //$unitspace  =$this->model_summaryinvoiceprint->getunitspace();
        //$v_dp =$_dp['dp'];
        //$data['branch_id'] 					= $branch_id;
        //$data['branch_name'] 					= $branch_name;
$where ='';
$where_trx ='';
$timestamp = time();
$now = date("Y-m-d H:i:s", $timestamp);
$Year = date("Y", strtotime($start_date));

if ($region_id ==! ''){
  $where =$where . ' B.region_id = ' ."'"."'".$region_id."'"."'";
 
}
if ($branch_id ==! ''){
	if ($where ==''){
		$where =$where. ' B.branch_id = ' ."'"."'".$branch_id."'"."'";
	}
	else{
		$where =$where. ' and B.branch_id = ' ."'"."'".$branch_id."'"."'";
	}
  
}
if ($rekanan_id ==! ''){
	if ($where ==''){
		$where =$where. ' B.rekanan_id = ' ."'"."'".$rekanan_id."'"."'";
	}
	else {
		$where =$where. ' and B.rekanan_id = ' ."'"."'".$rekanan_id."'"."'";
	}
  
}
if ($rekananshipping_line ==! ''){
	if ($where ==''){
		$where =$where. ' B.rekananshipping_line = ' ."'"."'".$rekananshipping_line."'"."'";
	}
	else {
		$where =$where. ' and B.rekananshipping_line = ' ."'"."'".$rekananshipping_line."'"."'";
	}
  
}
if ($start_date ==! ''){
	if ($itype =="1") {
		if ($where ==''){
			$where =$where. ' schedulepaymentdetil_posteddate between ' ."'"."'".$start_date."'"."'" .' and '."'"."'".$end_date."'"."'";
		}
		else {
			$where =$where. ' and schedulepaymentdetil_posteddate between ' ."'"."'".$start_date."'"."'" .' and '."'"."'".$end_date."'"."'";
		}
	}
	else{
		if ($where ==''){
			$where =$where. ' YEAR(A.schedulepaymentdetil_posteddate) = ' ."'"."'".$Year."'"."'";
		}
		else {
			$where =$where. ' and YEAR(A.schedulepaymentdetil_posteddate) = ' ."'"."'".$Year."'"."'";
		}		
	}
}



// echo ('bug -> ' .$where);
// exit;
        //$data['result']       		= $this->model_summaryinvoice->get_data_summaryinvoice($end_date,$end_date,$rekanan_id,$rekananshipping_line,$report_type,$branch_id,$region_id,$isproforma);
        //$data['resultH']       		= $this->model_summaryinvoice->get_data_summaryinvoice($end_date,$end_date,$rekanan_id,$rekananshipping_line,$report_type,$branch_id,$region_id,$isproforma);

        $data   = array(
                  'result'      => $this->model_summaryinvoice->get_data_summaryinvoice('TRP',$where, $itype),
                  //'resultH'      => $this->model_summaryinvoice->get_data_summaryinvoice_Header('TRP',$where),
                  //'result'      => $this->model_summaryinvoice->viewsummaryinvoiceprint($where,$where_trx,$where3,$isproforma, $where_pro1,$where_pro2,$where_pro3,$where_pro4),
                  //'resultH'      => $this->model_summaryinvoice->viewsummaryinvoiceprint_header($where,$where_trx,$where3,$isproforma, $where_pro1,$where_pro2,$where_pro3,$where_pro4),
                  //'resultdetil'      => $this->model_summaryinvoiceprint->viewinvprintdetil($loo_id),
                  //'unitspace'  => $this->model_summaryinvoiceprint->getunitspace()
                  'region_id'   => $region_id,
                  'region_name'   => $region_name,
                  'branch_id'   => $branch_id,
                  'branch_name'   => $branch_name,
                  'rekanan_id'   => $rekanan_id,
                  'rekanan_name'   => $rekanan_name,
                  'rekananshipping_line'   => $rekananshipping_line,
					'start_date'   => $start_date,
					'end_date'   => $end_date,
                  'button'   => $button
               );

        // echo print_r($data);
		// exit;
        //$data['resultd'] = $this->model_summaryinvoiceprint->sholdetilby_id($loo_id);

        //$this->load->view('looprint/rptinpro', $data);
	if ($itype =="1") {
		$this->load->view('summaryinvoice/rptsummaryinvoice', $data);
	}
	else if ($itype =="2") {
		$this->load->view('summaryinvoice/rptsummaryinvoiceUL', $data);
	}
	else if ($itype =="3") {
		$this->load->view('summaryinvoice/rptsummaryinvoiceRC', $data);
	}
	else  {
		$this->load->view('summaryinvoice/rptsummaryinvoice', $data);
	}		
        

        //$html=$this->load->view('summaryinvoice/rptsummaryinvoice', $data,TRUE);
        //$this->load->library('m_pdf');
        //$pdfFilePath = "rptsummaryinvoice.pdf";
        //$this->m_pdf->pdf->WriteHTML($html);
        //$this->m_pdf->pdf->Output($pdfFilePath, "I");

        //$html=$this->load->view('summaryinvoice/rptsummaryinvoice', $data, TRUE);
/*
        $html=$this->load->view('summaryinvoice/rptsummaryinvoice', $data, TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptsummaryinvoice.pdf";


        //$this->m_pdf->pdf->SetHTMLHeader('<table width="100%"><tr><td align="right" style="font-size:10px">{PAGENO}/{nb}</td></tr></table>');
        //$this->m_pdf->pdf->AddPage('P', 'Legal');
      //  $this->m_pdf->pdf->AddPage('P','Legal','','','',1,1,1,1,15,8);


        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");

        */

    }

    function looview(){

        $cont =  $this->uri->segment(4);
        $i_link = $this->uri->segment(5);

        $loo_id = str_replace('_', '/', $i_link);

        $data   = array(
                  'result'    => $this->model_summaryinvoice->viewsummaryinvoice($loo_id),
                  'loo_id'   => $loo_id
            );

        $data['region'] = $this->region_select();
        $data['lotype'] = $this->lootype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();

        $data['resultd'] = $this->model_summaryinvoice->sholdetilby_id($loo_id);
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
            ->add('View LOO Permanent/Casual Doc.Return','summaryinvoice/summaryinvoice/looview');

        $this->load->view('template/v_header');
        $this->load->view('loo/loo_view', $data);
        $this->load->view('template/v_footer');
    }

	function looviewupload(){
        $i_link = $this->uri->segment(4);

        $loo_id = str_replace('_', '/', $i_link);

        $data   = array(
                  'result'    => $this->model_summaryinvoice->viewsummaryinvoice($loo_id),
                  'loo_id'   => $loo_id
            );

        $data['region'] = $this->region_select();
        $data['lotype'] = $this->lootype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();

        $data['resultd'] = $this->model_summaryinvoice->sholdetilby_id($loo_id);
        $data['cont'] ="";


                $crumb              = "LOO Permanent/Casual Doc.Return";
                $data['tabpost']    = " Return";
				$cont="";



        $this->breadcrumbcomponent->add($crumb,'loo/'.$cont)
            ->add('Document Upload','summaryinvoice/summaryinvoice/looview');

        $this->load->view('template/v_header');
        $this->load->view('loo/loo_viewupload', $data);
        $this->load->view('template/v_footer');
    }


	function looprint(){

        $i_link = $this->uri->segment(4);

        $loo_id = str_replace('_', '/', $i_link);

        $data   = array(
                  'result'    => $this->model_summaryinvoice->viewsummaryinvoiceprint($loo_id),
                  'loo_id'   => $loo_id
            );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_summaryinvoice->sholdetilby_id($loo_id);

		$this->breadcrumbcomponent->add('Loo','summaryinvoice/summaryinvoice/summaryinvoicelist')
            ->add('Edit Loo','summaryinvoice/summaryinvoice/looedit');

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

    function branch_select_dialog(){
  		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$username=$this->session->userdata('username');
  		$branch      = $this->model_summaryinvoice->get_branch_dlg($rSearch['term'],$username);
  	    $result['items']= $branch;
          echo json_encode($result);
      }

    function branch_select(){

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];
        //$rRegion = empty($_GET['region']) ? '' : $_GET['region'];
		//$username=$this->session->userdata('username');

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





    function lootype_select(){

        $options    = array('' => '==Pilih==');

        $options[0] = 'Permanent Leasing';
        $options[1] = 'Casual Leasing';

        return $options;
    }



    function looprintpdf(){
                $i_link = $this->uri->segment(4);
                $loo_id = str_replace('_', '/', $i_link);

                $vsc=$this->model_summaryinvoice->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];

                $vpl=$this->model_summaryinvoice->getpromolevy($loo_id);
                $vpromolevy=$vpl['promolevy'];

                $dps=$this->model_summaryinvoice->getdepositr($loo_id);
                $vdps=$dps['depositr'];



        $data   = array(
                  'result'    => $this->model_summaryinvoice->viewsummaryinvoiceprint($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_summaryinvoice->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_summaryinvoice->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps

               );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_summaryinvoice->sholdetilby_id($loo_id);

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

                $vsc=$this->model_summaryinvoice->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];

                $vpl=$this->model_summaryinvoice->getpromolevy($loo_id);
                $vpromolevy=$vpl['promolevy'];

                $dps=$this->model_summaryinvoice->getdepositr($loo_id);
                $vdps=$dps['depositr'];
                $nildps=$dps['loodetil_baserent'];



        $data   = array(
                  'result'    => $this->model_summaryinvoice->viewconfprint($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_summaryinvoice->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_summaryinvoice->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps,
                  'nildps' =>$nildps

               );

        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_summaryinvoice->sholdetilby_id($loo_id);

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
