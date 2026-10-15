<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agreement2 extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_agreement');
        $this->load->library('breadcrumbcomponent');
        $this->load->library('form_validation');
    }
    
    function index(){       
        redirect('agreement2/agreement2/agreementlist');
    }      
    function globalsearch_dialog(){
		$arcari=array('unit_name', 'region_id', 'branch_id');
		return $arcari;
	}   
    function globalsearch_rekanan(){
        $arcari=array('rekanan_name','rekananshipping_name', 'branch_id');
        return $arcari;
    }    
	
    function globalsearch_new(){
        $arcari=array('s.loo_id', 's.region_id', 's.branch_id');
        return $arcari;
    }  

    function globalsearch_detil(){
        $arcari=array('loo_id');
        return $arcari;
    }  

    function globalsearch_loc(){
        $arcari=array('s.loc_id', 's.region_id', 's.branch_id');
      return $arcari;
    }  
    function globalsearch_locdetil(){
        $arcari=array('loc_id');
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

        $arcari = $this->globalsearch_rekanan();
        $cariOptional = '';

        //var_dump($_POST);
        if (isset($_POST['params']['branch_id'])) {
            $branch_id = trim($_POST['params']['branch_id']);
            $cariOptional = " branch_id = '".$branch_id."' ";
        }

        $vResult=$this->initialize_grid_default("qry_alldatapop","qry_filteredpop","qry_totalallpop",$arcari, $cariOptional);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];        

        foreach ($rResult as $aRow) {
            $row = array();
            $row[]= $aRow['debtor_no'];
            $row[]= $aRow['rekanan_name'];
            $row[]= $aRow['rekananshipping_name'];
            $row[]= '<div class="text-center"><a class="select"><i class="fa fa-check-square fa-lg"></i></a></div>';
            $row[]= $aRow['rekanan_id'];
            $row[]= $aRow['rekananshipping_line'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);            
    }

    function controler_gridnew(){
        $arcari=$this->globalsearch_new();
        $vResult=$this->initialize_grid("qry_alldatanew","qry_filterednew","qry_totalallnew",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            
            $id=$aRow['loo_id'];
            $row[]=$aRow['loo_id'];
            $row[]=$aRow['loo_sdate'];
            $row[]=$aRow['loo_edate'];
            $row[]=$aRow['_createby'];
            $row[]=$aRow['_createdate'];
            $row[]=$aRow['region_name'];
            $row[]=$aRow['branch_name'];
            $row[]=$aRow['region_id'];
            $row[]=$aRow['branch_id'];
            $row[]=$aRow['size_indoor'];
            $row[]=$aRow['size_outdoor'];
            $row[]=$aRow['fitting_out'];
            $row[]=$aRow['grace_period'];
            $row[]=$aRow['product_name'];
            $row[]=$aRow['loounit_term'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }

    function controler_gridnewdetil(){
        $arcari=$this->globalsearch_detil();
        $vResult=$this->initialize_grid("qry_alldatadetil","qry_filtereddetil","qry_totalalldetil",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            
            $id=$aRow['loo_id'];
            $row[]=$aRow['loo_id'];
            $row[]=$aRow['rekanan_id'];
            $row[]=$aRow['rekanan_name'];
            $row[]=$aRow['rekananshipping_line'];
            $row[]=$aRow['rekananshipping_name'];
            $row[]=$aRow['debtor_no'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }

    function controler_gridpro(){                      

	    $arcari = array('provitsharing_id', 'provitsharing_desc');
        //$p_line =  isset($_POST['f_date']) ? $_POST['f_date']: '' ;        
        //$braSearch = $branch_id <> '' ? "SHIP.branch_id = '{$branch_id}' " : '';
        //$optSearch = $braSearch;
        $vResult=$this->initialize_grid_default("qry_alldatapro","qry_filteredpro","qry_totalallpro", $arcari, '');
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];        

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['provitsharing_id'];
            $row[] = $aRow['provitsharing_id'];
            $row[] = $aRow['provitsharing_desc'];
            //$row[]= $p_line;
            $row[] = '<div class="text-center"><a class="select"><i class="fa fa-check-square fa-lg"></i></a></div>';

            if (!empty($row)) { $output['data'][] = $row; }
        }

        echo json_encode($output);            
    }

    function controler_gridloc(){
        $arcari=$this->globalsearch_loc();
        $vResult=$this->initialize_grid("qry_locall","qry_locfiltered","qry_loctotal",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            
            $id=$aRow['loc_id'];
            $row[]=$aRow['loc_id'];
            $row[]=$aRow['loc_sdate'];
            $row[]=$aRow['loc_edate'];
            $row[]=$aRow['_createby'];
            $row[]=$aRow['_createdate'];
            $row[]=$aRow['region_name'];
            $row[]=$aRow['branch_name'];
            $row[]=$aRow['region_id'];
            $row[]=$aRow['branch_id'];
            $row[]=$aRow['size_indoor'];
            $row[]=$aRow['size_outdoor'];
            $row[]=$aRow['fitting_out'];
            $row[]=$aRow['grace_period'];
            $row[]=$aRow['product_name'];
            $row[]=$aRow['locunit_term'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }

    function controler_gridlocdetil(){
        $arcari=$this->globalsearch_locdetil();
        $vResult=$this->initialize_grid("qry_localldetil","qry_locfiltereddetil","qry_loctotaldetil",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            
            $id=$aRow['loc_id'];
            $row[]=$aRow['loc_id'];
            $row[]=$aRow['rekanan_id'];
            $row[]=$aRow['rekanan_name'];
            $row[]=$aRow['rekananshipping_line'];
            $row[]=$aRow['rekananshipping_name'];
            $row[]=$aRow['debtor_no'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }

    function controler_gridunit(){
        $arcari = array('unit_name', 'unit_sqm', 'lantai_name');
        $cariOptional = '';

        //var_dump($_POST);

        $region_id = isset($_POST['params']['region_id']) ? trim($_POST['params']['region_id']) : '';
        $branch_id = isset($_POST['params']['branch_id']) ? trim($_POST['params']['branch_id']) : '';
        $loo_id = isset($_POST['params']['loo_id']) ? trim($_POST['params']['loo_id']) : '';

        $cariOptional = " 
            (region_id = '{$region_id}' and branch_id = '{$branch_id}' and unit_state = 0) OR
            unit_id in ( select unit_id from transaksi_loounit where loo_id = '{$loo_id}') OR
            unit_id in ( select unit_id from transaksi_locunit where loc_id = '{$loo_id}')
        ";


        $vResult = $this->initialize_grid_default("qry_alldataunit", "qry_filteredunit", "qry_totalallunit", $arcari, $cariOptional);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];        

        foreach ($rResult as $aRow) {
            $row = array();
            //$id = $aRow['rekanan_id'];
            //$row[]= '';
            switch ($aRow['unit_state']) {
                case '0':
                    # code...
                    $unit_state = '<span class="label label-sm label-danger">Available</span>';
                    break;
                case '2':
                    # code...
                    $unit_state = '<span class="label label-sm label-success">Sold</span>';
                    break;
                case '4':
                    # code...
                    $unit_state = '<span class="label label-sm label-warning">Disabled</span>';
                    break;
                default:
                    # code...
                    $unit_state = '<span class="label label-sm label-info">LA Return</span>';
                    break;
            }
            $row[]= $aRow['unit_name'];
            $row[]= $aRow['unit_sqm'];
            $row[]= $aRow['lantai_name'];
            $row[]= $unit_state;
            $row[]= '<div class="text-center"><a class="select"><i class="fa fa-check-square fa-lg"></i></a></div>';
            $row[]= $aRow['unit_id'];
            $row[]= $aRow['lantai_id'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }
    
	function globalsearch_list(){
		$arcari=array('agreement_id', 'CTE.region_id', 'CTE.branch_id', 
            'CTE.rekanan_id', 'CTE.rekananshipping_line', 
            'REGION.region_name', 'BRANCH.branch_name', 'REKAN.rekanan_name', 'BRAND.rekananshipping_name'
        );
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

                if (isset($_POST['columns'][$i]['search']['regex']) && $_POST['columns'][$i]['search']['regex'] != "false") {                      

                    $fields = explode(" ", $searchCol);

                    foreach ($fields as $string) {

                        if ($sWhere != ''){   

                            if ($aColumns[$i] == 'agreement_id') {
                                $idSearch = $this->refParser($string);
                                $sWhere .= " AND (". $idSearch .")";
                            } else {          
                                $sWhere .= " OR (". $aColumns[$i] . " LIKE '%".$string."%')";
                            }
                        } else {
                
                            //var_dump($fields);

                            if ($aColumns[$i] == 'agreement_id') {
                                $idSearch = $this->refParser($string);
                                $sWhere = "WHERE (". $idSearch .")";
                            } else {

                                $sWhere = "WHERE (". $aColumns[$i] . " LIKE '%".$string."%')";
                            }
                        }
                    }            
                    //$sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;
                } elseif ($searchCol != '') {  
					if ($sWhere != ''){             
						$sWhere .= " AND ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
					} else {
						$sWhere = "WHERE ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
					}
					 //$sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;					
				}

			}
		}
		 			
		
		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
		$limit = $limit+$top;

		if ( $cariOptional <> '' ) {            
            $sWhere = $sWhere <> '' ? $sWhere." AND ".$cariOptional : " WHERE ".$cariOptional;
        }
		
		$rResult=$this->model_agreement->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_agreement->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_agreement->$qry_totalall();
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
    
	function initialize_grid_default($qry_alldata, $qry_filtered, $qry_totalall, $arcari, $cariOptional){
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

		$top = (isset($_POST['start']))? ((int)$_POST['start']) : 0;
		$limit = (isset($_POST['length']))? ((int)$_POST['length'] ) : 10;
		$limit = $limit;
        
		//$optional =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ;
		//$sWhere = $sWhere . $optional;        
        if ( $cariOptional <> '' ) {            
            $sWhere = $sWhere <> '' ? $sWhere." AND ".$cariOptional : " WHERE ".$cariOptional;
        }
		
		$rResult = $this->model_agreement->$qry_alldata($limit, $top, $sWhere);

		$rResultCnt = $this->model_agreement->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_agreement->$qry_totalall();
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

          $i_link = $aRow['agreement_id'];
          $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
          $is_post = ($aRow['agreement_isapproved']) ? 1 : 0;
          $is_post = ($aRow['agreement_isclosed']) ? 1 : 0;          

          if ($aRow['agreement_isapproved']) {
              /*$_menu='
                  <a href="/index.php/agreement/agreement/agreementedit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                  <i class="fa fa-edit fa-lg"></i></a>
                  <a href="/index.php/agreement/agreementprint/print_pdf/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank">
                  <i class="fa fa-print fa-lg"></i></a>
                  <a href="" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
                  <i class="fa fa-trash fa-lg"></i></a>';*/
				  $_menu='
                  <a href="/index.php/agreement2/agreement2/agreementedit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                  <i class="fa fa-edit fa-lg"></i></a>
                  <a href="/index.php/laprint5/laprint5/laprint_agrpermanent/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank">
                  <i class="fa fa-print fa-lg"></i></a>
                  <a href="" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
                  <i class="fa fa-trash fa-lg"></i></a>';
                 

          } else {
              $_menu='
                  <a href="/index.php/agreement2/agreement2/agreementedit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                  <i class="fa fa-edit fa-lg"></i></a>
                  <a href="/index.php/agreement2/agreement2/agreement_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
                  <i class="fa fa-trash fa-lg"></i></a>';
          }

          $row = array();
		  $row[]=$aRow['agreement_id'];            
          $row[]=date("d-m-Y", strtotime($aRow['agreement_startdate']));
          //$row[]=date("d-m-Y", strtotime($aRow['agreement_enddate']));
		   $row[]=Date_format(Date_create($aRow['agreement_enddate']), "d-m-Y");	
		  $row[]=number_format($aRow['agreement_tlv'], 2);
		  $row[]=$aRow['branch_name'];
          $row[]=$ship_name;
          $row[]=$aRow['rekananshipping_name'];
          $row[]=$aRow['agreement_isapproved'];
          $row[]=$aRow['agreement_isclosed'];            
		  $row[]=$_menu;
  	
          if (!empty($row)) { $output['data'][] = $row; }
      	}   
      	echo json_encode($output);
    		
    }

    function agreementlist(){
        
        $agreement_id = $this->uri->segment(4);
        $data   = array(
                  'result'       => $this->model_agreement->viewagreement($agreement_id),
                  'agreement_id' => $agreement_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
		
		    $this->breadcrumbcomponent->add('Agreement Transaction','agreement2/agreementlist');

        $this->load->view('template/v_header');
        $this->load->view('agreement2/agreement_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function agreementadd(){		
        
        $agreement_id = $this->uri->segment(4);        
        
        $data   = array(
                  'result'          => $this->model_agreement->viewagreement($agreement_id),
                  'agreement_id'    => $agreement_id
            );        
        
        $data['region']         = $this->region_select();
        $data['lotype']         = $this->lootype_select();
        //$data['agrtype']        = $this->agrtype_select();
        $data['titype']         = $this->titype_select();
        $data['renttype']       = $this->agrtype_rental();
        $data['strukturunit']   = $this->strukturnit_select();
        $data['calculation']    = $this->calc_select();
        $data['outdoor']        = $this->outdoor_select();
        $data['chgtype']        = $this->agrtype_charge();
        $data['deptype']        = $this->agrtype_deposit();
        $data['loatype']        = $this->agrtype_loan();
        $data['protype']        = $this->agrtype_profit();
        $data['thdtype']        = $this->model_agreement->combo_thd_type();
        $data['thdgroup']       = $this->model_agreement->combo_thd_group();
        $data['thdcat']         = $this->model_agreement->combo_thd_cat();
        $data['thdstatus']      = $this->model_agreement->combo_thd_status();

  		  $this->breadcrumbcomponent->add('Agreement Transaction','agreement2/agreement2/agreementlist')
            ->add('Agreement Transaction','agreement2/agreement2/agreementadd');


        $this->load->view('template/v_header');
        $this->load->view('agreement2/agreement_add', $data);
        $this->load->view('template/v_footer');
	}
    
	function agreementedit(){		
        
        $i_link = $this->uri->segment(4);       

        $_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'          => $this->model_agreement->viewagreement($_id),
                  'agreement_id'    => $_id
            );                
        
        $data['region']         = $this->region_select();
        $data['lotype']         = $this->lootype_select();
        $data['titype']         = $this->titype_select();
        $data['renttype']       = $this->agrtype_rental();
        $data['strukturunit']   = $this->strukturnit_select();
        $data['calculation']    = $this->calc_select();
        $data['outdoor']        = $this->outdoor_select();
        $data['chgtype']        = $this->agrtype_charge();
        $data['deptype']        = $this->agrtype_deposit();
        $data['loatype']        = $this->agrtype_loan();
        $data['protype']        = $this->agrtype_profit();
        $data['thdtype']        = $this->model_agreement->combo_thd_type();
        $data['thdgroup']       = $this->model_agreement->combo_thd_group();
        $data['thdcat']         = $this->model_agreement->combo_thd_cat();
        $data['thdstatus']      = $this->model_agreement->combo_thd_status();

        $data['resultr'] = $this->model_agreement->vdetilrental($_id);
        $data['resultc'] = $this->model_agreement->vdetilcharge($_id);
        $data['resultd'] = $this->model_agreement->vdetildeposit($_id);
        $data['resultl'] = $this->model_agreement->vdetilloan($_id);        
        //$data['resultp'] = $this->model_agreement->vdetilprofits($_id);

		$this->breadcrumbcomponent->add('Agreement Transaction','agreement2/agreement2/agreementlist')
            ->add('Edit Agreement Transaction','agreement2/agreement2/agreementedit');        

        $this->load->view('template/v_header');
        $this->load->view('agreement2/agreement_edit', $data);
        $this->load->view('template/v_footer');
	}

    function looview(){     
        
        $cont =  $this->uri->segment(4);
        $i_link = $this->uri->segment(5);       

        $loo_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_loo->viewloo($loo_id),
                  'loo_id'   => $loo_id
            );                
        
        $data['region'] = $this->region_select();
        $data['lotype'] = $this->lootype_select(); 
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();

        $data['resultd'] = $this->model_loo->sholdetilby_id($loo_id);
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
	
	function looprint(){		
        
        $i_link = $this->uri->segment(4);       

        $loo_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_loo->viewlooprint($loo_id),
                  'loo_id'   => $loo_id
            );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();	
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loo->sholdetilby_id($loo_id);
		
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

    function tenant_select(){        

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];
        $rBranch = empty($_GET['branch']) ? '' : $_GET['branch'];
        $is_Branch = empty($_GET['isBranch']) ? '' : $_GET['isBranch'];

        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            
            
            $tenant      = $this->model_agreement->get_tenant($rSearch['term'], $rBranch, $is_Branch);
            
            $result['items']= $tenant;
          
            echo json_encode($result);
            
        };
    }

    function trade_select(){

        $rSearch    = empty($_GET['term']) ? '' : $_GET['term'];
        $rBranch    = empty($_GET['branch']) ? '' : $_GET['branch'];
        $is_Branch  = empty($_GET['isBranch']) ? '' : $_GET['isBranch'];
        $rRekanan   = empty($_GET['rekanan']) ? '' : $_GET['rekanan'];
        $is_Rekanan = empty($_GET['isRekanan']) ? '' : $_GET['isRekanan'];

        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            
            
            $trade      = $this->model_agreement->get_trade($rSearch['term'], $rBranch, $is_Branch, $rRekanan, $is_Rekanan);
            
            $result['items']= $trade;
          
            echo json_encode($result);
            
        };
    }   

    function unit_select(){
      
        $rRegion = empty($_GET['region']) ? '' : $_GET['region'];
        $rBranch = empty($_GET['branch']) ? '' : $_GET['branch'];
        $rLooNumber = empty($_GET['loonum']) ? '' : $_GET['loonum'];        
        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];

        if (is_array($rSearch) && $rSearch['_type'] == 'query'){  
            
            $term = '';
            if (isset($rSearch['term'])) { $term = $rSearch['term']; };
            
            $unit      = $this->model_agreement->get_unit($term, $rRegion, $rBranch, $rLooNumber);        
            
            $result['items']= $unit;
          
            echo json_encode($result);
        }
    }   

    function strukturnit_select(){
        $this->load->model('template/Master_m');
        
        $strukturunit = $this->Master_m->get_strukturunit();              
        
        if(count($strukturunit)){
            foreach($strukturunit as $key => $value){
                $options[$value->strukturunit_id]= $value->strukturunit_name;
            }
        }
                    
        return $options;
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

    function agrtype_rental(){     
        
        $this->load->model('template/Master_m');

        $filter = array('RENTAL', 'RENTAL TEMP');
        
        $agrtype      = $this->Master_m->get_agrtypefilter($filter);
        
        if(count($agrtype)){
            foreach($agrtype as $key => $value){
                $options[$value->agreementtype_id]= $value->agreementtype_name;
            }
        }
                    
        return $options;
    }

    function agrtype_charge(){     
        
        $this->load->model('template/Master_m');

        $filter = array('SERVICE', 'OTHER');
        
        $agrtype      = $this->Master_m->get_agrtypefilter($filter);
        
        if(count($agrtype)){
            foreach($agrtype as $key => $value){
                $options[$value->agreementtype_id]= $value->agreementtype_name;
            }
        }
                    
        return $options;
    }

    function agrtype_deposit(){     
        
        $this->load->model('template/Master_m');

        $filter = array('DEPOSIT');
        
        $agrtype      = $this->Master_m->get_agrtypefilter($filter);
        
        if(count($agrtype)){
            foreach($agrtype as $key => $value){
                $options[$value->agreementtype_id]= $value->agreementtype_name;
            }
        }
                    
        return $options;
    }

    function agrtype_loan(){     
        
        $this->load->model('template/Master_m');

        $filter = array('LOAN');
        
        $agrtype      = $this->Master_m->get_agrtypefilter($filter);
        
        if(count($agrtype)){
            foreach($agrtype as $key => $value){
                $options[$value->agreementtype_id]= $value->agreementtype_name;
            }
        }
                    
        return $options;
    }

    function agrtype_profit(){     
        
        $this->load->model('template/Master_m');

        $filter = array('PS');
        
        $agrtype      = $this->Master_m->get_agrtypefilter($filter);
        
        if(count($agrtype)){
            foreach($agrtype as $key => $value){
                $options[$value->agreementtype_id]= $value->agreementtype_name;
            }
        }
                    
        return $options;
    }

    function titype_select(){                 

        $options    = array('' => '==Pilih=='); 
        
        $options['DAY']     = 'Day';
        $options['MONTH']   = 'Month';
        $options['YEAR']    = 'Year';
                    
        return $options;
    }

    function calc_select(){            
        
        $options['0'] = 'Normal';
        $options['1'] = 'Step Rental';
        $options['2'] = 'Normal-Prorate';
        $options['3'] = 'Step Rental-Prorate';        
        $options['5'] = 'Step Rental-Progressive';    
                    
        return $options;
    }

    function unit_selectbybranch(){    

        $options  = array();               

        $this->load->model('template/Master_m');
        
        $_unit  = $this->Master_m->get_unit();        

        $options['data'][] = array( 
            'id'      => '',
            'text'    => '',
            'branch'  => '',
            'region'  => '',
            ''
        );            
            
        if(count($_unit)){
            foreach($_unit as $key => $value){                

                $options['data'][] = array(
                    'id'       => $value->unit_id,
                    'text'     => $value->unit_name,
                    'branch'   => $value->branch_id
                );              
            }
        }
                    
        echo json_encode($options);
    }

    function lootype_select(){                 

        $options    = array('' => '==Pilih=='); 
        
        $options[0] = 'Permanent Trasaction';
        $options[1] = 'Casual Transaction';
                    
        return $options;
    }

    function outdoor_select(){                 

        $options    = array('' => '==Pilih=='); 
        
        $options['Outdoor'] = 'Outdoor';
        $options['Indoor'] = 'Indoor';
                    
        return $options;
    }
    
    function agreement_add(){
        
        if ($_POST){

            $userdata = $this->session->userdata();
            $agreement_id = '';

            /** Header */
            $agreement = $this->getPostDataHeader($agreement_id, $userdata, 'newdata');
            $loi = $this->getPostDataLOI($agreement_id);
            //$rental = $this->getPostDataRental($agreement, $agreement);
            //$charge = $this->getPostDataCharge($agreement, $agreement);
            //$deposit = $this->getPostDataDeposit($agreement, $agreement);
            //$loan = $this->getPostDataLoan($agreement, $agreement);            
            //$profit = $this->getPostDataProfit($agreement, $agreement);			
			$this->form_validation->set_rules('cboregion', 'Business Unit', 'required');
			$this->form_validation->set_rules('cbobranch', 'Store', 'required');
			$this->form_validation->set_rules('htenant', 'Tenant', 'required');            
		
			if ($this->form_validation->run() == TRUE) {

                $idx = $this->model_agreement->saveHeader($agreement, $loi, 'new');
                $this->saveDataRental($idx, $agreement);
                $this->saveDataCharge($idx, $agreement);
                $this->saveDataDeposit($idx, $agreement);
                $this->saveDataProfit($idx, $agreement);

                $this->model_agreement->saveTLV($idx);
                

                /*
                $idx = $this->model_agreement->insertagreement(
                    $agreement,
                    $loi,
                    $rental,
                    $charge,                
                    $deposit,
                    $loan,
                    $profit
                );
                */
        	    redirect("agreement2/agreement2/agreementedit/".$idx);
			} else {
			    $this->agreementadd();	
			}
        }
    }
  
    function agreement_edit(){
        
        if ($_POST){

            $agreement_id = $this->input->post('agreement_id');
            $userdata = $this->session->userdata;
            
            /** Header */
            $agreement = $this->getPostDataHeader($agreement_id, $userdata, 'editdata');
            $loi = $this->getPostDataLOI($agreement_id);
            $rental = $this->getPostDataRental($agreement_id, $agreement);
            $charge = $this->getPostDataCharge($agreement_id, $agreement);
            $deposit = $this->getPostDataDeposit($agreement_id, $agreement);
            $loan = $this->getPostDataLoan($agreement_id, $agreement);           
            $profit = $this->getPostDataProfit($agreement_id, $agreement);
            
            $deleted = json_decode($this->input->post('objdel'));
            
            $this->form_validation->set_rules('cboregion', 'Business Unit', 'required');
            $this->form_validation->set_rules('cbobranch', 'Store', 'required');
            $this->form_validation->set_rules('htenant', 'Tenant', 'required');

			$xinfo = $this->model_agreement->cekbap($agreement_id, $agreement['agreement_bapdate'], $userdata['username']);

			if ($xinfo == 'OK'){
            
                if ($this->form_validation->run() == TRUE) { 
                    if ($agreement_id === 'auto') {
                        
                        /** Insert Agreement **/
                        $idx = $this->model_agreement->insertagreement(
                            $agreement, 
                            $loi,
                            $rental,                             
                            $charge, 
                            $deposit, 
                            $loan,                             
                            $profit
                        );
                    }else{
                        /** Update Agreement **/                                        
                        $idx = $this->model_agreement->updateagreement(                            
                            $agreement, 
                            $loi,
                            $rental,                             
                            $charge, 
                            $deposit, 
                            $loan,                             
                            $profit,
                            $deleted 
                        );
                    }  
                    
                    redirect("agreement2/agreement2/agreementedit/".$idx);            
                }
			
			}else{
			
				echo "<script>alert('$xinfo');</script>";			
				 redirect("agreement2/agreement2/agreementedit/".$agreement_id); 
			}			
			
        }
    }
	
	function agreement_delete()
    {     
		
        $i_link = $this->uri->segment(4);       

        $_id = str_replace('_', '/', $i_link); 

        $_username = $this->session->userdata('user_fullname');

		$this->model_agreement->deleteagreement($_id, $_username);
        redirect("agreement2/agreement2/agreementlist");
        
	}

    function agreement_getdataloo()
    {
        
        $loo_id     = empty($_GET['id']) ? '' : trim($_GET['id']);
        $rekanan_id = empty($_GET['rekanan']) ? '' : trim($_GET['rekanan']);
        $branch_id  = empty($_GET['branch']) ? '' : trim($_GET['branch']);
  
        $rResult = $this->model_agreement->getdataloo($loo_id, $rekanan_id, $branch_id);

        foreach ($rResult as $aRow) {

            $row = array();            
            $row[]=$aRow['loo_id'];
            $row[]=$aRow['agreementtype_id'];
            $row[]=$aRow['agreementtype_type'];            
            $row[]=$aRow['skl_looterm'];
            $row[]=$aRow['skl_loiterm'];
            $row[]=$aRow['loodetil_int'];
            $row[]=$aRow['loounit_sdate'];
            $row[]=$aRow['loounit_edate'];
            $row[]=$aRow['loodetil_baserent'];
            $row[]=$aRow['unit_name'];
            $row[]=$aRow['unit_sqm'];
            $row[]=$aRow['unit'];
            $row[]=$aRow['loodetil_percent'];
            $row[]=$aRow['loounit_term'];
            $row[]=$aRow['agreementtype_group'];
           
        if (!empty($row)) { $output['data'][] = $row; }
        }   
        echo json_encode($output);
    }

    function looprintpdf()
    {     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_loo->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_loo->getpromolevy($loo_id);
                $vpromolevy=$vpl['promolevy'];
                
                $dps=$this->model_loo->getdepositr($loo_id);
                $vdps=$dps['depositr'];
                
                

        $data   = array(
                  'result'    => $this->model_loo->viewlooprint($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_loo->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_loo->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loo->sholdetilby_id($loo_id);    

        $html=$this->load->view('loo/rptloo', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }
    
    
    function printconpdf()
    {     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_loo->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_loo->getpromolevy($loo_id);
                $vpromolevy=$vpl['promolevy'];
                
                $dps=$this->model_loo->getdepositr($loo_id);
                $vdps=$dps['depositr'];
                $nildps=$dps['loodetil_baserent'];
                
                

        $data   = array(
                  'result'    => $this->model_loo->viewconfprint($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_loo->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_loo->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps,
                  'nildps' =>$nildps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loo->sholdetilby_id($loo_id);    

        $html=$this->load->view('loo/rptconf', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptlooconf.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  

        
    }    

    function agreement_getdataloc(){     
        
        $loo_id     = empty($_GET['id']) ? '' : trim($_GET['id']);
        $rekanan_id = empty($_GET['rekanan']) ? '' : trim($_GET['rekanan']);
        $branch_id  = empty($_GET['branch']) ? '' : trim($_GET['branch']);        
  
        $rResult = $this->model_agreement->getdataloc($loo_id, $rekanan_id, $branch_id);

        foreach ($rResult as $aRow) {

            $row = array();            
            $row[]=$aRow['loc_id'];
            $row[]=$aRow['agreementtype_id'];
            $row[]=$aRow['agreementtype_type'];            
            $row[]=$aRow['skl_looterm'];
            $row[]=$aRow['skl_loiterm'];
            $row[]=$aRow['locdetil_int'];
            $row[]=$aRow['locunit_sdate'];
            $row[]=$aRow['locunit_edate'];
            $row[]=$aRow['locdetil_baserent'];
            $row[]=$aRow['unit_name'];
            $row[]=$aRow['unit_sqm'];
            $row[]=$aRow['unit'];
            $row[]=$aRow['locdetil_percent'];
            $row[]=$aRow['locunit_term'];
            $row[]=$aRow['agreementtype_group'];
           
        if (!empty($row)) { $output['data'][] = $row; }
        }   
        echo json_encode($output);
    }
    
    function refParser($string)
    {
        $result = '';
        $pattern = "/[\s;]+/";
        $obj = preg_split($pattern, $string);

        foreach ($obj as $id) {
            # code...
            if ($result != '') {
                $result .= " OR " . "agreement_id = '" . $id . "' ";
            } else {
                $result = "agreement_id = '" . $id ."'";
            }
        }

       return $result;
    }

    function listProfit()
    {
        $agreement_id = $_POST['agreement_id'];
    	$result = $this->model_agreement->vdetilprofits($agreement_id);
        $total = count($result);

        foreach ($result as $row) {
            //$row->_state = 'update';
            $row->rowid = 'profit-row-'.$row->agreementps_line;
            $row->_state = '';
        }

        $output = array(
			//"draw"=> $_POST['draw'],
			"recordsTotal" => $total,
			"recordsFiltered" => $total,
			"data" => $result
		);

        echo json_encode($output); 
    }

    function getPostDataHeader($agreement_id, $userdata, $mode) 
    {
        
        $agreement_bapdate = $this->input->post('agreement_bapdate');
        $agreement_bapdate = (!empty($agreement_bapdate)) ? str_replace('-', '/', $agreement_bapdate) : '';
        $agreement_installmentflat = str_replace(',', '', $this->input->post('agreement_installmentflat'));

        if ($mode == 'newdata') {
            $agreement_virtualaccount = get_va(
                $this->input->post('idebtor'), 
                $this->input->post('cbobranch')
            );            
            $_createby = $userdata['username'];
            $_createdate = date("Y-m-d h:i:sa", time());
            $_modifyby = null;
            $_modifydate = null;
        } else {
            $_createby = $this->input->post('agreement_createby');
            $_createdate = $this->input->post('agreement_createdate');
            $_modifyby = $userdata['username'];
            $_modifydate = date("Y-m-d h:i:sa", time());
            $agreement_virtualaccount = $this->input->post('ivirtual');
        }
        
        $agreement = [
            'agreement_id' => $agreement_id,
            'agreement_ref' => '',
            'ref_id' => '',
            'ref_type' => 0,
            'agreement_startdate' => $this->input->post('agreement_startperiod'), 
            'agreement_enddate' => $this->input->post('agreement_endperiod'), 
            'agreement_idr' => 0, 
            'agreement_foreign' => 0, 
            'agreement_foreign_rate' => 0, 
            'currency_id' => 'IDR', 
            'agreement_term' => (int)$this->input->post('agreement_term'),
            'agreement_dayterm' => (int)$this->input->post('agreement_dayterm'), 
            'agreement_leasetype_id' => 0,
            'agreement_isrenewal' => (int)$this->input->post('hrenewal'), 
            'agreement_descr' => $this->input->post('agreement_descr'), 
            'agreement_islumpsum' => 0, 
            'agreement_tlv' => 0, 
            'agreement_isclosed' => (int)$this->input->post('hclosed'),
            'agreement_isapproved' => (int)$this->input->post('happroved'),
            'agreement_createby' => $_createby,
            'agreement_createdate' => $_createdate, 
            'agreement_modifyby' => $_modifyby,
            'agreement_modifydate' => $_modifydate,
            'channel_id' => $userdata['channel_id'],
            'region_id' => $this->input->post('cboregion'), 
            'branch_id' => $this->input->post('cbobranch'), 
            'rekanan_id' => $this->input->post('htenant'), 
            'rekananshipping_line' => $this->input->post('hbrand'), 
            'strukturunit_id' => $this->input->post('cbostruktur'), 
            'transaksi_id' => $this->input->post('htransaksi'), 
            'agreement_formula' => (int)$this->input->post('cbocalctype'), 
            'agreement_renttype' => 1, 
            'agreement_deduct' => 0,
            'agreement_provision' => 0,
            'agreement_startperiod' => $this->input->post('agreement_startperiod'), 
            'agreement_endperiod' => $this->input->post('agreement_endperiod'), 
            'agreement_contractno' => $this->input->post('idebtor'), 
            'agreement_renewalno' => $this->input->post('agreement_renewalno'), 
            'agreement_isflat' => (int)$this->input->post('_isflat'), 
            'agreement_installmentflat' => (float)$agreement_installmentflat, 
            //'agreement_virtualaccount' => $this->input->post('ivirtual'),                 
            'agreement_virtualaccount' => $agreement_virtualaccount,
            'agreement_contractlongnumber' => $this->input->post('agreement_contractlongnumber'), 
            'agreement_loonumber' => $this->input->post('agreement_loonumber'), 
            'agreement_lanumber' => '', 
            'agreement_bapdate' => $agreement_bapdate,
            'thdtype_id' => $this->input->post('cboThdType'),
            'thdgroup_id' => $this->input->post('cboThdGroup'),
            'thdcat_id' => $this->input->post('cboThdCat'),
            'thdstatus_id' => $this->input->post('cboThdStatus')
        ];

        return $agreement;
    }

    function getPostDataLOI($agreement_id)
    {

        $fitting_out = str_replace(',', '', $this->input->post('fitting_out'));
        $grace_period = str_replace(',', '', $this->input->post('grace_period'));
        $size_indoor = str_replace(',', '', $this->input->post('size_indoor'));
        $size_outdoor = str_replace(',', '', $this->input->post('size_outdoor'));
        $loi = [
            'agreement_id' => $agreement_id,
            'product_name' => $this->input->post('product_name'), 
            'fitting_out' => (float)$fitting_out, 
            'grace_period' => (float)$grace_period, 
            'size_indoor' => (float)$size_indoor, 
            'size_outdoor' => (float)$size_outdoor
        ];

        return $loi;
    }

    function saveDataRental($agreement_id, $header)
    {
        
        $r_line             = $this->input->post('rline');
        $r_type             = $this->input->post('rtype');
        $r_sdate            = $this->input->post('rsdate');
        $r_edate            = $this->input->post('redate');
        $r_rinstm           = $this->input->post('rrinstm');
        $r_rinstd           = $this->input->post('rrinstd');
        $r_pinst            = $this->input->post('rpinst');
        $r_int              = $this->input->post('rint');
        $r_titype           = $this->input->post('rtitype');
        $r_space            = $this->input->post('rspace');
        $r_per              = $this->input->post('rper');
        $r_base             = $this->input->post('rbase');
        $r_vat              = $this->input->post('rvat');
        $r_unit             = $this->input->post('runit');
        $r_una              = $this->input->post('runa');
        $r_mia              = $this->input->post('rmia');
        $r_adendum          = $this->input->post('radendum');
        $r_lumpsum          = $this->input->post('rlumpsum');
        $r_descr            = $this->input->post('rdescr');
        $r_spdate           = $this->input->post('hspdate');
        $r_unitspot         = $this->input->post('runitspot');            
        $r_ninst            = $this->input->post('rninst');
        $r_state            = $this->input->post('rstate');

        //$rental = [];
        if (is_array($r_line) || is_object($r_line))
        {
            foreach ($r_line as $key => $n) {
                $rental = [
                    'agreement_id' => $agreement_id,
                    'agreementdetil_line' => $r_line[$key],
                    'agreementtype_id' => $r_type[$key],
                    'agreementdetil_startdate' => $r_sdate[$key],
                    'agreementdetil_enddate' => $r_edate[$key],
                    'agreementdetil_duedate' => 0,
                    'agreementdetil_installment' => $r_rinstm[$key],
                    'agreementdetil_dayinstallment' => $r_rinstd[$key],
                    'agreementdetil_installmentpayment' => $r_pinst[$key],
                    'agreementdetil_interval' => $r_int[$key],
                    'timetype_id' => $r_titype[$key],
                    'agreementdetil_space' => str_replace(',', '', $r_space[$key]),
                    'agreementdetil_term' => $header['agreement_term'],
                    'agreementdetil_percent' => $r_per[$key],
                    'agreementdetil_baserent' => str_replace(',', '', $r_base[$key]),
                    'currency_id' => 'IDR',
                    'agreementdetil_tax' => $r_vat[$key],
                    'agreementrule_id' => 0,
                    'agreementdetil_unit' => $r_una[$key],
                    'agreementdetil_mia' => str_replace(',', '', $r_mia[$key]),
                    'agreementdetil_isadendum' => ($r_adendum[$key]) ? 1 : 0,
                    'agreementdetil_islumpsum' => ($r_lumpsum[$key]) ? 1 : 0,
                    'agreementdetil_isautodiscount' => 0,
                    'agreementdetil_descr' => $r_descr[$key],
                    'agreementdetil_startdatepayment' => $r_spdate[$key],
                    'agreementdetil_ndesc' => $r_ninst[$key],
                    'agreementdetil_unitspot' => $r_unitspot[$key],
                    'unit_id' => $r_unit[$key]
                ];
                $state = $r_state[$key];
                $this->model_agreement->saveRental($rental, $state);
            }
        }
    }

    function saveDataCharge($agreement_id, $header)
    {
        
        $c_line             = $this->input->post('cline');
        $c_type             = $this->input->post('ctype');
        $c_sdate            = $this->input->post('csdate');
        $c_edate            = $this->input->post('cedate');
        $c_rinstm           = $this->input->post('crinstm');
        $c_rinstd           = $this->input->post('crinstd');
        $c_pinst            = $this->input->post('cpinst');
        $c_int              = $this->input->post('cint');
        $c_titype           = $this->input->post('ctitype');
        $c_space            = $this->input->post('cspace');
        $c_per              = $this->input->post('cper');
        $c_base             = $this->input->post('cbase');
        $c_vat              = $this->input->post('cvat');
        $c_unit             = $this->input->post('cunit');
        $c_una              = $this->input->post('cuna');
        $c_mia              = $this->input->post('cmia');
        $c_adendum          = $this->input->post('cadendum');
        $c_lumpsum          = $this->input->post('clumpsum');
        $c_descr            = $this->input->post('cdescr');
        $c_spdate           = $this->input->post('cspdate');
        $c_unitspot         = $this->input->post('cunitspot');
        $c_ninst            = $this->input->post('cninst');
        $c_state            = $this->input->post('cstate');

        //$charge = [];
        if (is_array($c_line) || is_object($c_line))
        {
            foreach ($c_line as $key => $n) {
                $charge = [
                    'agreement_id' => $agreement_id,
                    'agreementdetil_line' => $c_line[$key],
                    'agreementtype_id' => $c_type[$key],
                    'agreementdetil_startdate' => $c_sdate[$key],
                    'agreementdetil_enddate' => $c_edate[$key],
                    'agreementdetil_duedate' => 0,
                    'agreementdetil_installment' => $c_rinstm[$key],
                    'agreementdetil_dayinstallment' => $c_rinstd[$key],
                    'agreementdetil_installmentpayment' => $c_pinst[$key],
                    'agreementdetil_interval' => $c_int[$key],
                    'timetype_id' => $c_titype[$key],
                    'agreementdetil_space' => str_replace(',', '', $c_space[$key]),
                    'agreementdetil_term' => $header['agreement_term'],
                    'agreementdetil_percent' => $c_per[$key],
                    'agreementdetil_baserent' => str_replace(',', '', $c_base[$key]),
                    'currency_id' => 'IDR',
                    'agreementdetil_tax' => $c_vat[$key],
                    'agreementrule_id' => 0,
                    'agreementdetil_unit' => $c_una[$key],
                    'agreementdetil_mia' => str_replace(',', '', $c_mia[$key]),
                    'agreementdetil_isadendum' => ($c_adendum[$key]) ? 1 : 0,
                    'agreementdetil_islumpsum' => ($c_lumpsum[$key]) ? 1 : 0,
                    'agreementdetil_isautodiscount' => 0,
                    'agreementdetil_descr' => $c_descr[$key],
                    'agreementdetil_startdatepayment' => $c_spdate[$key],
                    'agreementdetil_ndesc' => $c_ninst[$key],
                    'agreementdetil_unitspot' => $c_unitspot[$key],
                    'unit_id' => $c_unit[$key],
                ];
                $state = $c_state[$key];
                $this->model_agreement->saveRental($charge, $state);
            }
        }
    }

    function saveDataDeposit($agreement_id, $header)
    {

        $d_line            = $this->input->post('dline');
        $d_type            = $this->input->post('dtype');
        $d_sdate           = $this->input->post('dsdate');
        $d_due             = $this->input->post('ddue');
        $d_titype          = $this->input->post('dtitype');
        $d_unit            = $this->input->post('dunit');
        $d_space           = $this->input->post('dspace');
        $d_lumpsum         = $this->input->post('dlumpsum');
        $d_base            = $this->input->post('dbase');
        $d_mia             = $this->input->post('dmia');
        $d_vat             = $this->input->post('dvat');
        $d_una             = $this->input->post('duna');            
        $d_state           = $this->input->post('dstate');

        if (is_array($d_line) || is_object($d_line))
        {
            foreach ($d_line as $key => $n) {
                $deposit = [
                    'agreement_id' => $agreement_id,
                    'agreementdeposit_line' => $d_line[$key],
                    'agreementtype_id' => $d_type[$key],
                    'agreementdeposit_startdate' => $d_sdate[$key],
                    'agreementdeposit_duedate' => (int)$d_due[$key],
                    'agreementdeposit_installment' => 1,
                    'agreementdeposit_interval' => 1,
                    'timetype_id' => $d_titype[$key],
                    'agreementdeposit_percent' => 0,
                    'agreementdeposit_idr' => (float)str_replace(',', '', $d_base[$key]),
                    'agreementdeposit_idrsubtotal' => (float)str_replace(',', '', $d_mia[$key]),
                    'agreementdeposit_foreign' => 0,
                    'agreementdeposit_foreignrate' => 1,
                    'currency_id' => 'IDR',
                    'agreementdeposit_tax' => $d_vat[$key],
                    'agreementdeposit_unit' => $d_una[$key],
                    'agreementdeposit_space' => (float)str_replace(',', '', $d_space[$key]),
                    'agreementdeposit_islumpsum' => ($d_lumpsum[$key]) ? 1 : 0,
                    'unit_id' => $d_unit[$key]
                ];
                $state = $d_state[$key];
                $this->model_agreement->saveDeposit($deposit, $state);
            }
        }
    }

    function saveDataLoan($agreement_id, $header)
    {
        $l_line             = $this->input->post('lline');
        $l_type             = $this->input->post('ltype');
        $l_sdate            = $this->input->post('lsdate');
        $l_edate            = $this->input->post('ledate');
        $l_rinstm           = $this->input->post('lrinstm');
        $l_rinstd           = $this->input->post('lrinstd');
        $l_pinst            = $this->input->post('lpinst');
        $l_int              = $this->input->post('lint');
        $l_due              = $this->input->post('ldue');
        $l_titype           = $this->input->post('ltitype');
        $l_per              = $this->input->post('lper');
        $l_unit             = $this->input->post('lunit');
        $l_space            = $this->input->post('lspace');
        $l_lumpsum          = $this->input->post('llumpsum');
        $l_base             = $this->input->post('lbase');
        $l_mia              = $this->input->post('lmia');
        $l_vat              = $this->input->post('lvat');
        $l_una              = $this->input->post('luna');            
        $l_state            = $this->input->post('lstate');
        
        if (is_array($l_line) || is_object($l_line))
        {
            foreach ($l_line as $key => $n) {
                $loan = [
                    'agreement_id' => $agreement_id,
                    'agreementloan_line' => $l_line[$key],
                    'agreementtype_id' => $l_type[$key],
                    'agreementloan_startdate' => $l_sdate[$key],
                    'agreementloan_enddate' => $l_edate[$key],
                    'agreementloan_installmentpayment' => (int)$l_pinst[$key],
                    'agreementloan_installment' => (int)$l_rinstm[$key],
                    'agreementloan_dayinstallment' => 0,
                    'agreementloan_interval' => (int)$l_int[$key],
                    'timetype_id' => $l_titype[$key],
                    'agreementloan_percent' => $l_per[$key],
                    'agreementloan_mia' => (float)str_replace(',', '', $l_mia[$key]),
                    'agreementloan_idrsubtotal' => 0,
                    'agreementloan_foreign' => 0,
                    'agreementloan_foreignrate' => 1,
                    'agreementloan_baserent' => 0,
                    'currency_id' => 'IDR',
                    'agreementloan_tax' => $l_vat[$key],
                    'agreementloan_descr' => '',
                    'agreementloan_unit' => $l_una[$key],
                    'agreementloan_space' => (float)str_replace(',', '', $l_space[$key]),
                    'agreementloan_islumpsum' => ($l_lumpsum[$key]) ? 1 : 0,
                    'unit_id' => $l_unit[$key]
                ];
                $state = $l_state[$key];
                $this->model_agreement->saveLoan($loan, $state);
            }
        }
    }
 
    function saveDataProfit($agreement_id, $header)
    {
		$channel_id = get_setting("channel_id");
		$username = $this->session->userdata('user_fullname');

        $obj = json_decode($_POST['row_profit']);

        //$records = [];
        if (is_array($obj) || is_object($obj))
        {        
            foreach ($obj as $row) {
                    
                if ($row->_state=='') { continue; }
                if ($row->agreementps_isposting) { continue; }
                
                $profit = array (                 
                    'agreement_id' => $agreement_id,
                    'agreementps_line' => (int)$row->agreementps_line,
                    'agreementtype_id' => $row->agreementtype_id,
                    'agreementps_startdate' => $row->agreementps_startdate,
                    'agreementps_enddate' => $row->agreementps_enddate,
                    'agreementps_installment' => 0,
                    'agreementps_installmentpayment' => 0,
                    'agreementps_interval' => 0,
                    'timetype_id' => $row->timetype_id,
                    'agreementps_unit' => $row->agreementps_unit,
                    'agreementps_space' => (float)$row->agreementps_space,
                    'agreementps_terms' => (int)$row->agreementps_terms,
                    'agreementps_isupload' => 0,
                    'agreementps_isposting' => 0,
                    'agreementps_mia' => (float)$row->agreementps_mia,
                    'agreementps_totalomset' => (float)$row->agreementps_mia,
                    'currency_id' => 'IDR',
                    'agreementps_tax' => $row->agreementps_tax,
                    'agreementps_foreign' => 0,
                    'agreementps_foreignrate' => 1,
                    'agreementps_idrsubtotal' => 0,
                    'agreementps_descr' => $row->agreementps_descr,
                    'agreementps_idps' => $row->agreementps_idps,
                    'agreementps_islumpsum' => $row->agreementps_islumpsum,
                    'unit_id' => $row->unit_id,
                    'agreementps_dayterms' => (int)$row->agreementps_dayterms
                );
                $state = $row->_state;
                $this->model_agreement->saveProfit($profit, $state);
            }
        }
    }
}  