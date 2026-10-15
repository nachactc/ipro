<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faktur extends CI_Controller{

    function __construct(){

        parent::__construct();
        // Check login and make sure email has been verified
        check_user_login();

        $this->load->model('model_faktur');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
		$this->session->keep_flashdata('message');
    }

    function index(){
        redirect('faktur/faktur/fakturlist');
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
        $arcari=array('jurnal_id', 'jurnal_id', 'rekanan_id');
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
					$row[]=number_format($aRow['jurnaldetil_selisih'], 2, '.', ',');
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
		$arcari=array('B.region_id','B.branch_id','B.rekanan_id','BRAND.rekananshipping_line','CTE.agreementtype_id','schedulepaymentdetil_date','schedulepaymentdetil_duedate','schedulepaymentdetil_posteddate','agreementtype_printouttype','schedulepaymentdetil_proformadate','faktur_id', 'faktur_id','BRANCH.branch_name','REKAN.rekanan_name','BRAND.rekananshipping_name','invoice_id','CTE.schedulepayment_id','CTE.schedulepayment_id + convert(nvarchar,schedulepaymentdetil_line)');
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
              $sWhere .= " AND schedulepaymentdetil_posteddate >= "."'".$searchCol."'";
			  //$sWhere .= " AND CONVERT(VARCHAR, schedulepaymentdetil_date, 112) >= "."'".$searchCol."'";
            }
            elseif ($aColumns[$i] == 'schedulepaymentdetil_duedate'){
              $sWhere .= " AND schedulepaymentdetil_posteddate <= "."'".$searchCol."'";
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
              $sWhere .= " WHERE CONVERT(VARCHAR, schedulepaymentdetil_posteddate, 112) >= "."'".$searchCol."'";
            }
            elseif ($aColumns[$i] == 'schedulepaymentdetil_duedate'){
              $sWhere .= " WHERE CONVERT(VARCHAR, schedulepaymentdetil_posteddate, 112) <= "."'".$searchCol."'";
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

     



		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
		$limit=$limit+$top;

		$b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ;
		$sWhere = $sWhere.$b;

		// echo 'bug -> top : ' . $top . ' - : ' . $limit . ' - ' . $sWhere ;
		// exit;
		
		$rResult=$this->model_faktur->$qry_alldata($limit,$top,$sWhere);

		$rResultCnt =$this->model_faktur->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_faktur->$qry_totalall();
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
				$criteria = $criteria." schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_isposted = 1 and faktur_id is null and agreementtype_type not in ('DEPOSIT','LOAN') and schedulepaymentdetil_idr > 0";
			}
			else
			{
				$criteria =  " schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_isposted = 1 and faktur_id is null and agreementtype_type not in ('DEPOSIT','LOAN') and schedulepaymentdetil_idr > 0";
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

            $i_link = str_replace('/', '_', $aRow['faktur_id']);
            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';

                $_menu='
                    <a href="/index.php/fakturprint/fakturprint/fakturprintpdf/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
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
               $row[]=$aRow['faktur_id'];
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

    function fakturlist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_faktur->viewfaktur($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('Insert Faktur','faktur/fakturlist');

        $this->load->view('template/v_header');
        $this->load->view('faktur/faktur_list', $data);
        $this->load->view('template/v_footer');
    }
	
    function fakturcllist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_faktur->viewfaktur($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('GENERATE INV CASUAL LEASING','faktur/fakturlist');

        $this->load->view('template/v_header');
        $this->load->view('faktur/fakturcl_list', $data);
        $this->load->view('template/v_footer');
    }
    function fakturduedatelist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_faktur->viewfaktur($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('faktur DUE DATE LIST','faktur/fakturduedate_list');

        $this->load->view('template/v_header');
        $this->load->view('fakturduedate/fakturduedate_list', $data);
        $this->load->view('template/v_footer');
    }	
    function fakturcancellist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_faktur->viewfaktur($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('faktur CANCEL','faktur/fakturcancellist');

        $this->load->view('template/v_header');
        $this->load->view('faktur/fakturcancel_list', $data);
        $this->load->view('template/v_footer');
    }

    function fakturpostinglist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_faktur->viewfaktur($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('faktur POSTING JURNAL','faktur/fakturpostinglist');

        $this->load->view('template/v_header');
        $this->load->view('faktur/fakturposting_list', $data);
        $this->load->view('template/v_footer');
    }   
    function fakturpostingnewlist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_faktur->viewfaktur($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('faktur','faktur/fakturpostingnewlist');

        $this->load->view('template/v_header');
        $this->load->view('faktur/fakturpostingnew_list', $data);
        $this->load->view('template/v_footer');
    } 	
	function fakturpostingcnlist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_faktur->viewfaktur($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('faktur POSTING CREDIT NOTE','faktur/fakturpostingcnlist');

        $this->load->view('template/v_header');
        $this->load->view('faktur/fakturpostingcn_list', $data);
        $this->load->view('template/v_footer');
    }   
    function fakturunpostinglist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_faktur->viewfaktur($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('faktur UN POSTING JURNAL','faktur/fakturunpostinglist');

        $this->load->view('template/v_header');
        $this->load->view('faktur/fakturunposting_list', $data);
        $this->load->view('template/v_footer');
    } 

    function fakturprintinva4list(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_faktur->viewfaktur($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('faktur PRINT OUT (faktur A4)','faktur/fakturprintinva4list');

        $this->load->view('template/v_header');
        $this->load->view('faktur/fakturprintinva4_list', $data);
        $this->load->view('template/v_footer');
    }
	
    function fakturprintinvlist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_faktur->viewfaktur($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('faktur PRINT OUT (faktur)','faktur/fakturprintinvlist');

        $this->load->view('template/v_header');
        $this->load->view('faktur/fakturprintinv_list', $data);
        $this->load->view('template/v_footer');
    }
    function fakturprintprolist(){

        $loo_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_faktur->viewfaktur($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select()
            );

        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('faktur PRINT OUT (Proforma)','faktur/fakturprintprolist');

        $this->load->view('template/v_header');
        $this->load->view('faktur/fakturprintpro_list', $data);
        $this->load->view('template/v_footer');
    }	
	function fakturcnlist(){

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
                  'result'    => $this->model_faktur->viewfaktur($loo_id),
                  'loo_id'   => $loo_id,
                  'branch' => $this->branch_select(),
				  'aging'    => $this->model_faktur->getaging($where,$where2)
            );
			
		//print_r ($this->model_faktur->getaging($where));
		//exit;
		
		// if (isset($_POST['btnpost'])){
			// $data['cek']="1";
			
			
		// }else{
			// $data['cek']="0";	
		// }
		
        $data['region'] = $this->region_select();
        $data['agrtype'] = $this->agrtype_select();
        //$data['branch'] = $this->branch_select();

		$this->breadcrumbcomponent->add('faktur CREDIT NOTE','faktur/fakturcnlist');

        $this->load->view('template/v_header');
        $this->load->view('faktur/fakturpostingcn_list', $data);
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
 
 
 
	
    

    function fakturprintpropdf(){
        //echo ('bug -> ' .$loo_id)
        $i_link = $this->uri->segment(4);
        $loo_id = str_replace('_', '/', $i_link);
        $loo_id = str_replace('X', ',', $loo_id);


        //$print_name = 'Suhendra';//$this->session->userdata('user_fullname');

        //$unitspace  =$this->model_fakturprint->getunitspace();
        //$v_dp =$_dp['dp'];

        $data   = array(
                  'result'      => $this->model_faktur->get_printout_proforma($loo_id),
                  'resultdetil'      => $this->model_faktur->get_printout_proforma($loo_id),
                  'unitspace'  => $this->model_faktur->getunitspace()
               );

        //echo ('bug -> ' .$data);
        //$data['resultd'] = $this->model_fakturprint->sholdetilby_id($loo_id);

        //$this->load->view('looprint/rptinpro', $data);
        
		//$this->load->view('faktur/rptproforma', $data);
		
				$html=$this->load->view('faktur/rptproformaA', $data,TRUE);
				$this->load->library('m_pdf');
				$pdfFilePath = "rptproforma.pdf";	
/*
       $html=$this->load->view('fakturprint/rptfaktur', $data, TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptfaktur.pdf";


        //$this->m_pdf->pdf->SetHTMLHeader('<table width="100%"><tr><td align="right" style="font-size:10px">{PAGENO}/{nb}</td></tr></table>');
        //$this->m_pdf->pdf->AddPage('P', 'Legal');
      //  $this->m_pdf->pdf->AddPage('P','Legal','','','',1,1,1,1,15,8);


        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");
*/
    }
	 
	
     
	 
    function create_faktur(){

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
					$ref_id = $key[10];
					$username          = $this->session->userdata('user_fullname');
					$isposted ='1';
					
					//$region_id = '010';
					//echo $region_id;
					
					$schedulepayment=$this->model_faktur->get_schedulepayment($id);
					$rekanan_id = $schedulepayment['rekanan_id'];

					  $master_rekanan=$this->model_faktur->get_master_rekanan($rekanan_id);
					  $rekanan_taxprefix = $master_rekanan['rekanan_taxprefix'];
					  // if (substr($ref_id,0,2) == "UA") {
						  // $rekanan_taxprefix = "080.";
					  // }
					  $master_agreementtype=$this->model_faktur->get_master_agreementtype($agreementtype_id);
					  $agreementtype_type = $master_agreementtype['agreementtype_type'];
					  
					  $Criteria = ' isdisabled = 0 and branch_id = ' ."'"."'".$branch_id."'"."'";
					  $Criteria2 = '';
					  

					  
					  $taxbranch=$this->model_faktur->get_master_taxbranch($Criteria);
					  if (!empty($taxbranch)){
						  //$taxbranch_id ='1';
						  $Criteria2 = ' tax_status = 0 and tax_isdisable = 0 and region_id = ' ."'"."'".$region_id."'"."'". ' and branch_id = ' ."'"."'".$branch_id."'"."'";
					  }
					  else {
						  //$taxbranch_id ='0';
						  $Criteria2 = ' tax_status = 0 and tax_isdisable = 0 and region_id = ' ."'"."'".$region_id."'"."'" . ' and A.taxbranch_id = 0';
					  }
					  
					  //echo $Criteria;
					  //exit;
					  
					  $taxnumber=$this->model_faktur->get_master_taxnumber($Criteria2);  
					  $taxnomor = $taxnumber['tax_no'];		
					  //echo $Criteria2;
                        if (!empty($taxnumber)){
                          $tax_no = $taxnumber['tax_no'];
                          $faktur_id = $rekanan_taxprefix . $tax_no;
                          //posting jurnal
                          // echo $faktur_id;
                          // echo $invoice_id;
                          // echo 'line : ' . $line;
                          // exit;
                         if($this->model_faktur->get_faktur_update_new($faktur_id, $invoice_id, $line, $post_date, $username, $id))
                          {
                        		$result['success'] = TRUE;
                        		$result['data'] = $faktur_id;
                        		echo json_encode($result);							  
                          }
                          else {
                        			$result['success'] = FALSE;     
                        			$result['data'] = 'ERROR FAKTUR UPDATE';
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
	
}
