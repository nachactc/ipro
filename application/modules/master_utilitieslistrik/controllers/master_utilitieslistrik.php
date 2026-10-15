<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_utilitieslistrik extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_master_utilitieslistrik');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('breadcrumbcomponent');
    }
    
    function index(){       
        redirect('master_utilitieslistrik/master_utilitieslistrik/master_utilitieslistriklist');
    }
    function globalsearch_dialog(){
		$arcari=array('schedulebooking_id','invoice_id');
		return $arcari;
	}
	function globalsearch_list(){
		$arcari=array('utilitieslistrik_id', 'utilitieslistrik_name','utilitieskva_name');
		// $arcari=array('a.master_utilitieslistrik_id', 'a.master_utilitieslistrik_name', 'a.region_id','BRANCH.branch_name','refid','rekanan','brand');
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
    $rResult=$this->model_master_utilitieslistrik->$qry_alldata($limit,$top,$sWhere);
   
	$rResultCnt =$this->model_master_utilitieslistrik->$qry_filtered($sWhere);
	$iFilteredTotal = $rResultCnt['jml'];

	$rResultTotal =$this->model_master_utilitieslistrik->$qry_totalall();
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
		$a = $this->model_master_utilitieslistrik->cek_master_utilitieslistrik_status('03000004060601');
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
				$criteria = $criteria." AND master_utilitieslistrik_state = 0";
			}
			else
			{
				$criteria =  " master_utilitieslistrik_state = 0" ;
			}
		} 
		elseif($searchStatus == 'sold')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND master_utilitieslistrik_state = 2";
			}
			else
			{
				$criteria =  " master_utilitieslistrik_state = 2" ;
			}
		} 
		elseif($searchStatus == 'la')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND master_utilitieslistrik_state = 3";
			}
			else
			{
				$criteria =  " master_utilitieslistrik_state = 3" ;
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
		$i_link = str_replace('/', '_', $aRow['utilitieslistrik_id']);
        $row = array();
				$row[]=$aRow['utilitieslistrik_id'];
                $row[]=$aRow['utilitieslistrik_name'];
				$row[]=$aRow['utilitieslistrik_amp'];
                $row[]=$aRow['utilitieslistrik_phase'];
                $row[]=$aRow['utilitieslistrik_kva']; 
                $row[]=$aRow['utilitieslistrik_faktor']; 
                $row[]=$aRow['utilitieslistrik_admpercent']; 
                $row[]=$aRow['utilitieslistrik_admamount'];
				$row[]=$aRow['utilitieskva_name'];
				$row[]=$aRow['utilitieslistrik_bpju'];
                $row[]=$aRow['utilitieslistrik_issingglemeter'];//
				$row[]=$aRow['utilitieslistrik_isadditional'];//
				// if($this->model_master_utilitieslistrik->cek_master_utilitieslistrik_status($aRow['master_utilitieslistrik_id']))
				// {
					// $disabled = '';
				// }
				// else
				// {
					// $disabled = 'disabled';
				// }				
			         $row[]='
					<a href="/index.php/master_utilitieslistrik/master_utilitieslistrik/master_utilitieslistrikedit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                    <img border="0" src="'.base_url().'/assets/img/edit.png" width="21" height="21"></a>
					<a href="/index.php/master_utilitieslistrik/master_utilitieslistrik/master_utilitieslistrik_delete/'.$i_link.'" data-toggle="tooltip" title="Delete">
                    <img border="0" src="'.base_url().'/assets/img/delete.png" width="21" height="21"></a>'
					;
				
	
        if (!empty($row)) { $output['data'][] = $row; }
    	}   
    	echo json_encode($output);
		
}

    function master_utilitieslistriklist(){
        
        $master_utilitieslistrik_id = $this->uri->segment(5);
        $data   = array(
                  'result'    => $this->model_master_utilitieslistrik->viewmaster_utilitieslistrik($master_utilitieslistrik_id),
                  'master_utilitieslistrik_id'   => $master_utilitieslistrik_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->model_master_utilitieslistrik->get_branch_list();
		
		$this->breadcrumbcomponent->add('Master Utilities Listrik','master_utilitieslistrik/master_utilitieslistriklist');

        $this->load->view('template/v_header');
        $this->load->view('master_utilitieslistrik/master_utilitieslistrik_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function master_utilitieslistrikadd()
	{		
        
        $master_utilitieslistrik_id = $this->uri->segment(4);
        
        $data   = array(
                  'result'    => $this->model_master_utilitieslistrik->viewmaster_utilitieslistrik($master_utilitieslistrik_id),
                  'master_utilitieslistrik_id'   => $master_utilitieslistrik_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
		$data['lantai'] = $this->floor_select();
		$data['kva'] = $this->kva_select();
		//$data['master_utilitieslistriktype'] = $this->master_utilitieslistriktype_select();

  		$this->breadcrumbcomponent->add('Master Utilities Listrik','master_utilitieslistrik/master_utilitieslistrik/master_utilitieslistriklist')
            ->add('Input Master Utilities Listrik','master_utilitieslistrik/master_utilitieslistrik/master_utilitieslistrikadd');


        $this->load->view('template/v_header');
        $this->load->view('master_utilitieslistrik/master_utilitieslistrik_add', $data);
        $this->load->view('template/v_footer');
	}
     
	function master_utilitieslistrikedit()
	{		
        
        $utilitieslistrik_id = $this->uri->segment(4);
		echo $utilitieslistrik_id;
        $data   = array(
                  'result'    => $this->model_master_utilitieslistrik->viewmaster_utilitieslistrik($utilitieslistrik_id),
                  'utilitieslistrik_id'   => $utilitieslistrik_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();	
		$data['lantai'] = $this->floor_select();
		$data['kva'] = $this->kva_select();
		//$data['master_utilitieslistriktype'] = $this->master_utilitieslistriktype_select();
		
		$this->breadcrumbcomponent->add('Master Utilities Listrik Edit','master_utilitieslistrik/master_utilitieslistrik/master_utilitieslistriklist')
            ->add('Edit Master Utilities Listrik','master_utilitieslistrik/master_utilitieslistrik/master_utilitieslistrikedit');

        $this->load->view('template/v_header');
        $this->load->view('master_utilitieslistrik/master_utilitieslistrik_edit', $data);
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
        $branch     = $this->model_master_utilitieslistrik->get_floor();
        $options    = "";                
        
        if(count($branch)){
            foreach($branch as $key => $value){
                $options[$value->lantai_id]= $value->lantai_name;
            }
        }
                    
        return $options;
    }

	function kva_select(){
        $branch     = $this->model_master_utilitieslistrik->get_kva();
        $options    = "";                
        
        if(count($branch)){
            foreach($branch as $key => $value){
                $options[$value->utilitieskva_id]= $value->utilitieskva_name;
            }
        }
                    
        return $options;
    }
	
	function master_utilitieslistriktype_select(){
        $branch     = $this->model_master_utilitieslistrik->get_master_utilitieslistriktype();
        $options    = "";                
        
        if(count($branch)){
            foreach($branch as $key => $value){
                $options[$value->master_utilitieslistriktype_id]= $value->master_utilitieslistriktype_name;
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
  
    function master_utilitieslistrik_edit(){
			// echo "<pre/>";
			// echo print_r($_POST);
			// exit;
$utilitieslistrik_id			= $this->input->post('utilitieslistrik_id');
$utilitieslistrik_name			= $this->input->post('utilitieslistrik_name');
$utilitieslistrik_amp			= $this->input->post('utilitieslistrik_amp');
$utilitieslistrik_phase			= $this->input->post('utilitieslistrik_phase');
$utilitieslistrik_kva			= $this->input->post('utilitieslistrik_kva');
$utilitieslistrik_faktor		= $this->input->post('utilitieslistrik_faktor');
$utilitieslistrik_issingglemeter= (int)$this->input->post('utilitieslistrik_issingglemeter');
$utilitieslistrik_isadditional	= (int)$this->input->post('utilitieslistrik_isadditional');
$utilitieslistrik_admpercent	= $this->input->post('utilitieslistrik_admpercent');
$utilitieslistrik_admamount		= $this->input->post('utilitieslistrik_admamount');
$utilitieslistrik_bpju			= $this->input->post('utilitieslistrik_bpju');
$utilitieskva_id				= $this->input->post('cbokva');
$tariflwbp_calcbyuser			= (int)$this->input->post('tariflwbp_calcbyuser');
$tarifwbp_calcbyuser			= (int)$this->input->post('tarifwbp_calcbyuser');
$selisih_calcbyuser				= (int)$this->input->post('selisih_calcbyuser');
$selisihlwbp_calcbyuser			= (int)$this->input->post('selisihlwbp_calcbyuser');
$selisihwbp_calcbyuser			= (int)$this->input->post('selisihwbp_calcbyuser');
$pemakaianwbp_calcbyuser		= (int)$this->input->post('pemakaianwbp_calcbyuser');
$pemakaianlwbp_calcbyuser		= (int)$this->input->post('pemakaianlwbp_calcbyuser');
$utilitieslistrik_isgenset		= (int)$this->input->post('utilitieslistrik_isgenset');
$utilitieslistrik_isblocked		= (int)$this->input->post('utilitieslistrik_isblocked');
$utilitieslistrik_isdisabled	= (int)$this->input->post('utilitieslistrik_isdisabled');
$utilitieslistrik_createby		= $this->input->post('utilitieslistrik_createby');
$utilitieslistrik_createdate	= $this->input->post('utilitieslistrik_createdate');
$utilitieslistrik_modifyby		= $this->session->userdata('user_fullname');
$utilitieslistrik_modifydate	= $this->input->post('utilitieslistrik_modifydate');
$username 						=  $this->session->userdata('user_fullname');
$utilitieslistrik_modifyby 		= $username;

//$utilitieslistrik_isgenset= (int)$this->input->post('utilitieslistrik_isgenset');

//echo 'bug : ' . var_dump($_POST);
//echo 'bug : ' . $utilitieslistrik_isgenset;
//exit;

//if ($utilitieslistrik_isgenset == 0)
//{
//		echo 'bug : 0';
//}
//else
//{
//	echo 'bug : 1';
//}
//$issingglemeter =	($utilitieslistrik_isgenset? 1 : 0);


//exit;
        	
		$this->model_master_utilitieslistrik->updatemaster_utilitieslistrik($utilitieslistrik_id, $utilitieslistrik_name, $utilitieslistrik_amp, $utilitieslistrik_phase, $utilitieslistrik_kva, $utilitieslistrik_faktor, $utilitieslistrik_issingglemeter, $utilitieslistrik_isadditional, $utilitieslistrik_admpercent, $utilitieslistrik_admamount, $utilitieslistrik_bpju, $utilitieskva_id, $tariflwbp_calcbyuser, $tarifwbp_calcbyuser, $selisih_calcbyuser, $selisihlwbp_calcbyuser, $selisihwbp_calcbyuser, $pemakaianwbp_calcbyuser, $pemakaianlwbp_calcbyuser, $utilitieslistrik_isgenset, $utilitieslistrik_isblocked, $utilitieslistrik_isdisabled, $utilitieslistrik_createby, $utilitieslistrik_createdate, $utilitieslistrik_modifyby, $utilitieslistrik_modifydate);
        
		redirect("master_utilitieslistrik/master_utilitieslistrik/master_utilitieslistriklist");
    }
	
	function savemaster_utilitieslistrik(){
		  
		
		// echo "<pre/>";
		// echo print_r($_POST);
		// exit;
		
		
			$utilitieslistrik_id			= $this->input->post('utilitieslistrik_id');
			$utilitieslistrik_name			= $this->input->post('utilitieslistrik_name');
			$utilitieslistrik_amp			= $this->input->post('utilitieslistrik_amp');
			$utilitieslistrik_phase			= $this->input->post('utilitieslistrik_phase');
			$utilitieslistrik_kva			= $this->input->post('utilitieslistrik_kva');
			$utilitieslistrik_faktor		= $this->input->post('utilitieslistrik_faktor');
			$utilitieslistrik_issingglemeter= (int)$this->input->post('utilitieslistrik_issingglemeter');
			$utilitieslistrik_isadditional	= (int)$this->input->post('utilitieslistrik_isadditional');
			$utilitieslistrik_admpercent	= $this->input->post('utilitieslistrik_admpercent');
			$utilitieslistrik_admamount		= $this->input->post('utilitieslistrik_admamount');
			$utilitieslistrik_bpju			= $this->input->post('utilitieslistrik_bpju');
			$utilitieskva_id				= $this->input->post('cbokva');
			$tariflwbp_calcbyuser			= (int)$this->input->post('tariflwbp_calcbyuser');
			$tarifwbp_calcbyuser			= (int)$this->input->post('tarifwbp_calcbyuser');
			$selisih_calcbyuser				= (int)$this->input->post('selisih_calcbyuser');
			$selisihlwbp_calcbyuser			= (int)$this->input->post('selisihlwbp_calcbyuser');
			$selisihwbp_calcbyuser			= (int)$this->input->post('selisihwbp_calcbyuser');
			$pemakaianwbp_calcbyuser		= (int)$this->input->post('pemakaianwbp_calcbyuser');
			$pemakaianlwbp_calcbyuser		= (int)$this->input->post('pemakaianlwbp_calcbyuser');
			$utilitieslistrik_isgenset		= (int)$this->input->post('utilitieslistrik_isgenset');
			$utilitieslistrik_isblocked		= (int)$this->input->post('utilitieslistrik_isblocked');
			$utilitieslistrik_isdisabled	= (int)$this->input->post('utilitieslistrik_isdisabled');
			$utilitieslistrik_createby		= $this->input->post('utilitieslistrik_createby');
			$utilitieslistrik_createdate	= $this->input->post('utilitieslistrik_createdate');
			$utilitieslistrik_modifyby		= $this->session->userdata('user_fullname');
			$utilitieslistrik_modifydate	= $this->input->post('utilitieslistrik_modifydate');
			$username 						=  $this->session->userdata('user_fullname');
			$utilitieslistrik_createby 		= $username;
			//echo $utilitieskva_id;
			//exit;
			$this->model_master_utilitieslistrik->savemaster_utilitieslistrik($utilitieslistrik_id, $utilitieslistrik_name, $utilitieslistrik_amp, $utilitieslistrik_phase, $utilitieslistrik_kva, $utilitieslistrik_faktor, $utilitieslistrik_issingglemeter, $utilitieslistrik_isadditional, $utilitieslistrik_admpercent, $utilitieslistrik_admamount, $utilitieslistrik_bpju, $utilitieskva_id, $tariflwbp_calcbyuser, $tarifwbp_calcbyuser, $selisih_calcbyuser, $selisihlwbp_calcbyuser, $selisihwbp_calcbyuser, $pemakaianwbp_calcbyuser, $pemakaianlwbp_calcbyuser, $utilitieslistrik_isgenset, $utilitieslistrik_isblocked, $utilitieslistrik_isdisabled, $utilitieslistrik_createby, $utilitieslistrik_createdate, $utilitieslistrik_modifyby, $utilitieslistrik_modifydate);   
			//echo var_dump($_POST);
			//exit;			
			redirect("master_utilitieslistrik/master_utilitieslistrik/master_utilitieslistriklist");
		
		
		
            
    }
	 
	function master_utilitieslistrik_delete(){
		 
		$_id = $this->uri->segment(4);
		// echo $_id;
		// exit;
		$this->model_master_utilitieslistrik->deletemaster_utilitieslistrik($_id);
		redirect("master_utilitieslistrik/master_utilitieslistrik/master_utilitieslistriklist");
	}

	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_loo_cl->get_branch_dlg($rSearch['term']);
	    $result['items']= $branch; 
        echo json_encode($result);
    }
}  