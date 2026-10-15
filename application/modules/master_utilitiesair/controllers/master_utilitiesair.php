<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_utilitiesair extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_master_utilitiesair');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('breadcrumbcomponent');
    }
    
    function index(){       
        redirect('master_utilitiesair/master_utilitiesair/master_utilitiesairlist');
    }
    function globalsearch_dialog(){
		$arcari=array('schedulebooking_id','invoice_id');
		return $arcari;
	}
	function globalsearch_list(){
		$arcari=array('utilitiesair_id', 'utilitiesair_name');
		// $arcari=array('a.master_utilitiesair_id', 'a.master_utilitiesair_name', 'a.region_id','BRANCH.branch_name','refid','rekanan','brand');
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
	 
    $top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
    $limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
	$limit=$limit+$top;

	$b =  $cariOptional <> '' ?  $sWhere == '' ? " WHERE ".$cariOptional : " AND ".$cariOptional  : '' ; 
	$sWhere = $sWhere.$b;
	//echo $sWhere;
    $rResult=$this->model_master_utilitiesair->$qry_alldata($limit,$top,$sWhere);
   
	$rResultCnt =$this->model_master_utilitiesair->$qry_filtered($sWhere);
	$iFilteredTotal = $rResultCnt['jml'];

	$rResultTotal =$this->model_master_utilitiesair->$qry_totalall();
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


	function controler_griddialog(){
	$arcari=$this->globalsearch_dialog();
	$vResult=$this->initialize_grid("qry_alldatadialog","qry_filtereddialog","qry_totalalldialog",$arcari);
	$rResult=$vResult['rResult'];
	$output=$vResult['output'];
	foreach ($rResult as $aRow) {
        $row = array();
		$id=$aRow['schedulebooking_id'];
                $row[]=$aRow['schedulebooking_id'];
				$row[]=$aRow['schedulebookingdetil_line'];
				$row[]=$aRow['schedulebookingdetil_amount'];
				$row[]=$aRow['invoice_id'];

        if (!empty($row)) { $output['data'][] = $row; }
    	}   
    	echo json_encode($output);
		
}
	
	function cek_status()
	{
		$a = $this->model_master_utilitiesair->cek_master_utilitiesair_status('03000004060601');
		echo $a;
	}
	
	function controler_gridlist($val_search = '',$val_serach_branch=''){
	$arcari=$this->globalsearch_list();
	
	$searchStatus = $val_search;
		// echo $searchStatus;
		// exit;
		
		$criteria = null; 
		if($searchStatus == 'avail')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND master_utilitiesair_state = 0";
			}
			else
			{
				$criteria =  " master_utilitiesair_state = 0" ;
			}
		} 
		elseif($searchStatus == 'sold')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND master_utilitiesair_state = 2";
			}
			else
			{
				$criteria =  " master_utilitiesair_state = 2" ;
			}
		} 
		elseif($searchStatus == 'la')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND master_utilitiesair_state = 3";
			}
			else
			{
				$criteria =  " master_utilitiesair_state = 3" ;
			}
		}
		else 
		{
			 
				$criteria = NULL; 
		}
	if($val_serach_branch != '')
	{
		if($criteria != '')
		{
			$criteria = $criteria . " and branch_id = '$val_serach_branch'";
		}
		else
		{
			$criteria =	" branch_id = '$val_serach_branch'";
		}
	} 
	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari, $criteria);
	$rResult=$vResult['rResult'];
	$output=$vResult['output'];	
	foreach ($rResult as $aRow) {
		$i_link = str_replace('/', '_', $aRow['utilitiesair_id']);
        $row = array();
				$row[]=$aRow['utilitiesair_id'];
                $row[]=$aRow['utilitiesair_name'];
				$row[]=$aRow['utilitiesair_diameterpipa'];
                $row[]=$aRow['utilitiesair_admpercent'];
				$row[]=$aRow['utilitiesair_adm'];                
				$row[]=$aRow['utilitiesair_abonemen'];
				$row[]=$aRow['utilitiesair_phairkotor']; 
                $row[]=$aRow['utilitiesair_phmeter'];                                  
				$row[]=$aRow['utilitiesair_isadditional'];
				$row[]=$aRow['phairkotor_isdisabled'];
                $row[]=$aRow['utilitiesair_isusedawalakhir'];//
				$row[]=$aRow['utilitiesair_isdisabled'];//
				// if($this->model_master_utilitiesair->cek_master_utilitiesair_status($aRow['master_utilitiesair_id']))
				// {
					// $disabled = '';
				// }
				// else
				// {
					// $disabled = 'disabled';
				// }				
			         $row[]='
					<a href="/index.php/master_utilitiesair/master_utilitiesair/master_utilitiesairedit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                    <img border="0" src="'.base_url().'/assets/img/edit.png" width="21" height="21"></a>
					<a href="/index.php/master_utilitiesair/master_utilitiesair/master_utilitiesair_delete/'.$i_link.'" data-toggle="tooltip" title="Delete">
                    <img border="0" src="'.base_url().'/assets/img/delete.png" width="21" height="21"></a>'
					;
				
	
        if (!empty($row)) { $output['data'][] = $row; }
    	}   
    	echo json_encode($output);
		
}

    function master_utilitiesairlist(){
        
        $master_utilitiesair_id = $this->uri->segment(5);
        $data   = array(
                  'result'    => $this->model_master_utilitiesair->viewmaster_utilitiesair($master_utilitiesair_id),
                  'master_utilitiesair_id'   => $master_utilitiesair_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->model_master_utilitiesair->get_branch_list();
		
		$this->breadcrumbcomponent->add('Master Utilities Air','master_utilitiesair/master_utilitiesairlist');

        $this->load->view('template/v_header');
        $this->load->view('master_utilitiesair/master_utilitiesair_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function master_utilitiesairadd()
	{		
        
        $master_utilitiesair_id = $this->uri->segment(4);
        
        $data   = array(
                  'result'    => $this->model_master_utilitiesair->viewmaster_utilitiesair($master_utilitiesair_id),
                  'master_utilitiesair_id'   => $master_utilitiesair_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
		$data['lantai'] = $this->floor_select();
		$data['kva'] = $this->kva_select();
		//$data['master_utilitiesairtype'] = $this->master_utilitiesairtype_select();

  		$this->breadcrumbcomponent->add('Master Utilities Air','master_utilitiesair/master_utilitiesair/master_utilitiesairlist')
            ->add('Input Master Utilities Air','master_utilitiesair/master_utilitiesair/master_utilitiesairadd');


        $this->load->view('template/v_header');
        $this->load->view('master_utilitiesair/master_utilitiesair_add', $data);
        $this->load->view('template/v_footer');
	}
     
	function master_utilitiesairedit()
	{		
        
        $utilitiesair_id = $this->uri->segment(4);
		echo $utilitiesair_id;
        $data   = array(
                  'result'    => $this->model_master_utilitiesair->viewmaster_utilitiesair($utilitiesair_id),
                  'utilitiesair_id'   => $utilitiesair_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();	
		$data['lantai'] = $this->floor_select();
		$data['kva'] = $this->kva_select();
		//$data['master_utilitiesairtype'] = $this->master_utilitiesairtype_select();
		
		$this->breadcrumbcomponent->add('Master Utilities Air','master_utilitiesair/master_utilitiesair/master_utilitiesairlist')
            ->add('Edit Master Utilities Air','master_utilitiesair/master_utilitiesair/master_utilitiesairedit');

        $this->load->view('template/v_header');
        $this->load->view('master_utilitiesair/master_utilitiesair_edit', $data);
        $this->load->view('template/v_footer');
	}
    
    function region_select(){
        $this->load->model('template/Master_m');
        
        $region      = $this->Master_m->get_region();
        $options    = "";                
        
        if(count($region)){
            foreach($region as $key => $value){
                $options[$value->region_id]= $value->region_name;
            }
        }
                    
        return $options;
    }
    
    function branch_select(){
        $this->load->model('template/Master_m');    
        $branch     = $this->Master_m->get_branch();
        $options    = "";                
        
        if(count($branch)){
            foreach($branch as $key => $value){
                $options[$value->branch_id]= $value->branch_name;
            }
        }
                    
        return $options;
    }
	
	function floor_select(){
        $branch     = $this->model_master_utilitiesair->get_floor();
        $options    = "";                
        
        if(count($branch)){
            foreach($branch as $key => $value){
                $options[$value->lantai_id]= $value->lantai_name;
            }
        }
                    
        return $options;
    }

	function kva_select(){
        $branch     = $this->model_master_utilitiesair->get_kva();
        $options    = "";                
        
        if(count($branch)){
            foreach($branch as $key => $value){
                $options[$value->utilitieskva_id]= $value->utilitieskva_name;
            }
        }
                    
        return $options;
    }
	
	function master_utilitiesairtype_select(){
        $branch     = $this->model_master_utilitiesair->get_master_utilitiesairtype();
        $options    = "";                
        
        if(count($branch)){
            foreach($branch as $key => $value){
                $options[$value->master_utilitiesairtype_id]= $value->master_utilitiesairtype_name;
            }
        }
                    
        return $options;
    }
    
    function collection_add(){        

        if ($_POST){
            
            $coll_id=$this->input->post('tline');
            $coll_date      =$this->input->post('coll_date');
            $descr     = $this->input->post('descr');
            $region         = $this->input->post('cboregion');
            $branch         = $this->input->post('cbobranch');
            $_createby       = $this->input->post('_createby');
			$_modifyby	  = $this->input->post('_modifyby');
			$coll_line	  =$this->input->post('tline');
			$coll_descr 	 =$this->input->post('tdescription');
			$coll_amount	=$this->input->post('tamount');
			$ref_id		 =$this->input->post('spid');
			$ref_line	   =$this->input->post('trline');
	
	$idx=$this->model_collection->insertcollection($coll_date, $descr, $_createby, $_modifyby, $region, $branch,
	$coll_line,$coll_descr,$coll_amount,$ref_id,$ref_line);

	redirect("accounting/modcollection/collection/collectionlist");
        }
    }
  
    function master_utilitiesair_edit(){
			// echo "<pre/>";
			// echo print_r($_POST);
			// exit;
$utilitiesair_id				= $this->input->post('utilitiesair_id');
$utilitiesair_name				= $this->input->post('utilitiesair_name');
$utilitiesair_diameterpipa		= $this->input->post('utilitiesair_diameterpipa');
$utilitiesair_adm				= $this->input->post('utilitiesair_adm');
$utilitiesair_phairkotor		= $this->input->post('utilitiesair_phairkotor');
$utilitiesair_phmeter			= $this->input->post('utilitiesair_phmeter');
$utilitiesair_isadditional		= (int)$this->input->post('utilitiesair_isadditional');
$phairkotor_isdisabled			= (int)$this->input->post('phairkotor_isdisabled');
$utilitiesair_admpercent		= $this->input->post('utilitiesair_admpercent');
$utilitiesair_abonemen			= $this->input->post('utilitiesair_abonemen');
$utilitiesair_isusedawalakhir	= (int)$this->input->post('utilitiesair_isusedawalakhir');
$utilitiesair_isdisabled		= (int)$this->input->post('utilitiesair_isdisabled');
$utilitiesair_createby			= $this->input->post('utilitiesair_createby');
$utilitiesair_createdate		= $this->input->post('utilitiesair_createdate');
$utilitiesair_modifyby			= $this->session->userdata('user_fullname');
$utilitiesair_modifydate		= $this->input->post('utilitiesair_modifydate');
$username 						=  $this->session->userdata('user_fullname');
$utilitiesair_modifyby 			= $username;

//$utilitiesair_isgenset= (int)$this->input->post('utilitiesair_isgenset');

//echo 'bug : ' . var_dump($_POST);
//echo 'bug : ' . $utilitiesair_isgenset;
//exit;

//if ($utilitiesair_isgenset == 0)
//{
//		echo 'bug : 0';
//}
//else
//{
//	echo 'bug : 1';
//}
//$issingglemeter =	($utilitiesair_isgenset? 1 : 0);


//exit;
        	
		$this->model_master_utilitiesair->updatemaster_utilitiesair($utilitiesair_id, $utilitiesair_name, $utilitiesair_diameterpipa, $utilitiesair_adm, $utilitiesair_phairkotor, $utilitiesair_phmeter, $utilitiesair_isadditional, $phairkotor_isdisabled, $utilitiesair_admpercent, $utilitiesair_abonemen, $utilitiesair_isusedawalakhir, $utilitiesair_isdisabled, $utilitiesair_createby, $utilitiesair_createdate, $utilitiesair_modifyby, $utilitiesair_modifydate);
        
		redirect("master_utilitiesair/master_utilitiesair/master_utilitiesairlist");
    }
	
	function savemaster_utilitiesair(){
		  
		
		// echo "<pre/>";
		// echo print_r($_POST);
		// exit;
		
		
			$utilitiesair_id				= $this->input->post('utilitiesair_id');
			$utilitiesair_name				= $this->input->post('utilitiesair_name');
			$utilitiesair_diameterpipa		= $this->input->post('utilitiesair_diameterpipa');
			$utilitiesair_adm				= $this->input->post('utilitiesair_adm');
			$utilitiesair_phairkotor		= $this->input->post('utilitiesair_phairkotor');
			$utilitiesair_phmeter			= $this->input->post('utilitiesair_phmeter');
			$utilitiesair_isadditional		= (int)$this->input->post('utilitiesair_isadditional');
			$phairkotor_isdisabled			= (int)$this->input->post('phairkotor_isdisabled');
			$utilitiesair_admpercent		= $this->input->post('utilitiesair_admpercent');
			$utilitiesair_abonemen			= $this->input->post('utilitiesair_abonemen');
			$utilitiesair_isusedawalakhir	= (int)$this->input->post('utilitiesair_isusedawalakhir');
			$utilitiesair_isdisabled		= (int)$this->input->post('utilitiesair_isdisabled');
			$utilitiesair_createby			= $this->input->post('utilitiesair_createby');
			$utilitiesair_createdate		= $this->input->post('utilitiesair_createdate');
			$utilitiesair_modifyby			= $this->session->userdata('user_fullname');
			$utilitiesair_modifydate		= $this->input->post('utilitiesair_modifydate');
			$username 						=  $this->session->userdata('user_fullname');
			$utilitiesair_createby 		= $username;
			//echo $utilitieskva_id;
			//exit;
			$this->model_master_utilitiesair->savemaster_utilitiesair($utilitiesair_id, $utilitiesair_name, $utilitiesair_diameterpipa, $utilitiesair_adm, $utilitiesair_phairkotor, $utilitiesair_phmeter, $utilitiesair_isadditional, $phairkotor_isdisabled, $utilitiesair_admpercent, $utilitiesair_abonemen, $utilitiesair_isusedawalakhir, $utilitiesair_isdisabled, $utilitiesair_createby, $utilitiesair_createdate, $utilitiesair_modifyby, $utilitiesair_modifydate);   
			//echo var_dump($_POST);
			//exit;			
			redirect("master_utilitiesair/master_utilitiesair/master_utilitiesairlist");
		
		
		
            
    }
	 
	function master_utilitiesair_delete(){
		 
		$_id = $this->uri->segment(4);
		// echo $_id;
		// exit;
		$this->model_master_utilitiesair->deletemaster_utilitiesair($_id);
		redirect("master_utilitiesair/master_utilitiesair/master_utilitiesairlist");
	}

	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_loo_cl->get_branch_dlg($rSearch['term']);
	    $result['items']= $branch; 
        echo json_encode($result);
    }
}  