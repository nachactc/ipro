<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_utilitiesgas extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_master_utilitiesgas');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('breadcrumbcomponent');
    }
    
    function index(){       
        redirect('master_utilitiesgas/master_utilitiesgas/master_utilitiesgaslist');
    }
    function globalsearch_dialog(){
		$arcari=array('schedulebooking_id','invoice_id');
		return $arcari;
	}
	function globalsearch_list(){
		$arcari=array('utilitiesgas_id', 'utilitiesgas_name');
		// $arcari=array('a.master_utilitiesgas_id', 'a.master_utilitiesgas_name', 'a.region_id','BRANCH.branch_name','refid','rekanan','brand');
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
    $rResult=$this->model_master_utilitiesgas->$qry_alldata($limit,$top,$sWhere);
   
	$rResultCnt =$this->model_master_utilitiesgas->$qry_filtered($sWhere);
	$iFilteredTotal = $rResultCnt['jml'];

	$rResultTotal =$this->model_master_utilitiesgas->$qry_totalall();
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
		$a = $this->model_master_utilitiesgas->cek_master_utilitiesgas_status('03000004060601');
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
				$criteria = $criteria." AND master_utilitiesgas_state = 0";
			}
			else
			{
				$criteria =  " master_utilitiesgas_state = 0" ;
			}
		} 
		elseif($searchStatus == 'sold')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND master_utilitiesgas_state = 2";
			}
			else
			{
				$criteria =  " master_utilitiesgas_state = 2" ;
			}
		} 
		elseif($searchStatus == 'la')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND master_utilitiesgas_state = 3";
			}
			else
			{
				$criteria =  " master_utilitiesgas_state = 3" ;
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
		$i_link = str_replace('/', '_', $aRow['utilitiesgas_id']);
        $row = array();
				$row[]=$aRow['utilitiesgas_id'];
                $row[]=$aRow['utilitiesgas_name'];
				$row[]=$aRow['utilitiesgas_diameterpipa'];
                $row[]=$aRow['utilitiesgas_admpercent'];
				$row[]=$aRow['utilitiesgas_adm'];                
				$row[]=$aRow['utilitiesgas_tarif'];
				$row[]=$aRow['utilitiesgas_phairkotor']; 
                $row[]=$aRow['utilitiesgas_phmeter'];                                  
				$row[]=$aRow['utilitiesgas_isadditional'];
				$row[]=$aRow['utilitiesgas_mfaktor'];
				$row[]=$aRow['utilitiesgas_pressure'];
                $row[]=$aRow['utilitiesgas_isusedawalakhir'];//
				$row[]=$aRow['utilitiesgas_isdisabled'];//
				// if($this->model_master_utilitiesgas->cek_master_utilitiesgas_status($aRow['master_utilitiesgas_id']))
				// {
					// $disabled = '';
				// }
				// else
				// {
					// $disabled = 'disabled';
				// }				
			         $row[]='
					<a href="/index.php/master_utilitiesgas/master_utilitiesgas/master_utilitiesgasedit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                    <img border="0" src="'.base_url().'/assets/img/edit.png" width="21" height="21"></a>
					<a href="/index.php/master_utilitiesgas/master_utilitiesgas/master_utilitiesgas_delete/'.$i_link.'" data-toggle="tooltip" title="Delete">
                    <img border="0" src="'.base_url().'/assets/img/delete.png" width="21" height="21"></a>'
					;
				
	
        if (!empty($row)) { $output['data'][] = $row; }
    	}   
    	echo json_encode($output);
		
}

    function master_utilitiesgaslist(){
        
        $master_utilitiesgas_id = $this->uri->segment(5);
        $data   = array(
                  'result'    => $this->model_master_utilitiesgas->viewmaster_utilitiesgas($master_utilitiesgas_id),
                  'master_utilitiesgas_id'   => $master_utilitiesgas_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->model_master_utilitiesgas->get_branch_list();
		
		$this->breadcrumbcomponent->add('Master Utilities Gas','master_utilitiesgas/master_utilitiesgaslist');

        $this->load->view('template/v_header');
        $this->load->view('master_utilitiesgas/master_utilitiesgas_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function master_utilitiesgasadd()
	{		
        
        $master_utilitiesgas_id = $this->uri->segment(4);
        
        $data   = array(
                  'result'    => $this->model_master_utilitiesgas->viewmaster_utilitiesgas($master_utilitiesgas_id),
                  'master_utilitiesgas_id'   => $master_utilitiesgas_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
		$data['lantai'] = $this->floor_select();
		$data['kva'] = $this->kva_select();
		//$data['master_utilitiesgastype'] = $this->master_utilitiesgastype_select();

  		$this->breadcrumbcomponent->add('Master Utilities Gas','master_utilitiesgas/master_utilitiesgas/master_utilitiesgaslist')
            ->add('Input Master Utilities Gas','master_utilitiesgas/master_utilitiesgas/master_utilitiesgasadd');


        $this->load->view('template/v_header');
        $this->load->view('master_utilitiesgas/master_utilitiesgas_add', $data);
        $this->load->view('template/v_footer');
	}
     
	function master_utilitiesgasedit()
	{		
        
        $utilitiesgas_id = $this->uri->segment(4);
		echo $utilitiesgas_id;
        $data   = array(
                  'result'    => $this->model_master_utilitiesgas->viewmaster_utilitiesgas($utilitiesgas_id),
                  'utilitiesgas_id'   => $utilitiesgas_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();	
		$data['lantai'] = $this->floor_select();
		$data['kva'] = $this->kva_select();
		//$data['master_utilitiesgastype'] = $this->master_utilitiesgastype_select();
		
		$this->breadcrumbcomponent->add('Master Utilities Gas','master_utilitiesgas/master_utilitiesgas/master_utilitiesgaslist')
            ->add('Edit Master Utilities Gas','master_utilitiesgas/master_utilitiesgas/master_utilitiesgasedit');

        $this->load->view('template/v_header');
        $this->load->view('master_utilitiesgas/master_utilitiesgas_edit', $data);
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
        $branch     = $this->model_master_utilitiesgas->get_floor();
        $options    = "";                
        
        if(count($branch)){
            foreach($branch as $key => $value){
                $options[$value->lantai_id]= $value->lantai_name;
            }
        }
                    
        return $options;
    }

	function kva_select(){
        $branch     = $this->model_master_utilitiesgas->get_kva();
        $options    = "";                
        
        if(count($branch)){
            foreach($branch as $key => $value){
                $options[$value->utilitieskva_id]= $value->utilitieskva_name;
            }
        }
                    
        return $options;
    }
	
	function master_utilitiesgastype_select(){
        $branch     = $this->model_master_utilitiesgas->get_master_utilitiesgastype();
        $options    = "";                
        
        if(count($branch)){
            foreach($branch as $key => $value){
                $options[$value->master_utilitiesgastype_id]= $value->master_utilitiesgastype_name;
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
  
    function master_utilitiesgas_edit(){
			// echo "<pre/>";
			// echo print_r($_POST);
			// exit;
		$utilitiesgas_id				= $this->input->post('utilitiesgas_id');
		$utilitiesgas_name				= $this->input->post('utilitiesgas_name');
		$utilitiesgas_diameterpipa		= $this->input->post('utilitiesgas_diameterpipa');
		$utilitiesgas_adm				= $this->input->post('utilitiesgas_adm');
		$utilitiesgas_phairkotor		= $this->input->post('utilitiesgas_phairkotor');
		$utilitiesgas_phmeter			= $this->input->post('utilitiesgas_phmeter');
		$utilitiesgas_isadditional		= (int)$this->input->post('utilitiesgas_isadditional');
		$utilitiesgas_tarif				=  $this->input->post('utilitiesgas_tarif');
		$utilitiesgas_admpercent		= $this->input->post('utilitiesgas_admpercent');
		$utilitiesgas_mfaktor			= $this->input->post('utilitiesgas_mfaktor');
		$utilitiesgas_pressure			= $this->input->post('utilitiesgas_pressure');
		$utilitiesgas_isusedawalakhir	= (int)$this->input->post('utilitiesgas_isusedawalakhir');
		$utilitiesgas_isdisabled		= (int)$this->input->post('utilitiesgas_isdisabled');
		$utilitiesgas_createby			= $this->input->post('utilitiesgas_createby');
		$utilitiesgas_createdate		= $this->input->post('utilitiesgas_createdate');
		$utilitiesgas_modifyby			= $this->session->userdata('user_fullname');
		$utilitiesgas_modifydate		= $this->input->post('utilitiesgas_modifydate');
		$username 						=  $this->session->userdata('user_fullname');
		$utilitiesgas_modifyby 			= $username;

//$utilitiesgas_isgenset= (int)$this->input->post('utilitiesgas_isgenset');

//echo 'bug : ' . var_dump($_POST);
//echo 'bug : ' . $utilitiesgas_isgenset;
//exit;

//if ($utilitiesgas_isgenset == 0)
//{
//		echo 'bug : 0';
//}
//else
//{
//	echo 'bug : 1';
//}
//$issingglemeter =	($utilitiesgas_isgenset? 1 : 0);


//exit;
        	
		$this->model_master_utilitiesgas->updatemaster_utilitiesgas($utilitiesgas_id, $utilitiesgas_name, $utilitiesgas_diameterpipa, $utilitiesgas_adm, $utilitiesgas_phairkotor, $utilitiesgas_phmeter, $utilitiesgas_isadditional, $utilitiesgas_tarif, $utilitiesgas_admpercent, $utilitiesgas_mfaktor, $utilitiesgas_pressure, $utilitiesgas_isusedawalakhir, $utilitiesgas_isdisabled, $utilitiesgas_createby, $utilitiesgas_createdate, $utilitiesgas_modifyby, $utilitiesgas_modifydate);
        
		redirect("master_utilitiesgas/master_utilitiesgas/master_utilitiesgaslist");
    }
	
	function savemaster_utilitiesgas(){
		  
		
		// echo "<pre/>";
		// echo print_r($_POST);
		// exit;
		
		
			$utilitiesgas_id				= $this->input->post('utilitiesgas_id');
			$utilitiesgas_name				= $this->input->post('utilitiesgas_name');
			$utilitiesgas_diameterpipa		= $this->input->post('utilitiesgas_diameterpipa');
			$utilitiesgas_adm				= $this->input->post('utilitiesgas_adm');
			$utilitiesgas_phairkotor		= $this->input->post('utilitiesgas_phairkotor');
			$utilitiesgas_phmeter			= $this->input->post('utilitiesgas_phmeter');
			$utilitiesgas_isadditional		= (int)$this->input->post('utilitiesgas_isadditional');
			$utilitiesgas_tarif				=  $this->input->post('utilitiesgas_tarif');
			$utilitiesgas_admpercent		= $this->input->post('utilitiesgas_admpercent');
			$utilitiesgas_mfaktor			= $this->input->post('utilitiesgas_mfaktor');
			$utilitiesgas_pressure			= $this->input->post('utilitiesgas_pressure');
			$utilitiesgas_isusedawalakhir	= (int)$this->input->post('utilitiesgas_isusedawalakhir');
			$utilitiesgas_isdisabled		= (int)$this->input->post('utilitiesgas_isdisabled');
			$utilitiesgas_createby			= $this->input->post('utilitiesgas_createby');
			$utilitiesgas_createdate		= $this->input->post('utilitiesgas_createdate');
			$utilitiesgas_modifyby			= $this->session->userdata('user_fullname');
			$utilitiesgas_modifydate		= $this->input->post('utilitiesgas_modifydate');
			$username 						=  $this->session->userdata('user_fullname');
			$utilitiesgas_createby 		= $username;
			//echo $utilitieskva_id;
			//exit;
			$this->model_master_utilitiesgas->savemaster_utilitiesgas($utilitiesgas_id, $utilitiesgas_name, $utilitiesgas_diameterpipa, $utilitiesgas_adm, $utilitiesgas_phairkotor, $utilitiesgas_phmeter, $utilitiesgas_isadditional, $utilitiesgas_tarif, $utilitiesgas_admpercent, $utilitiesgas_mfaktor, $utilitiesgas_pressure, $utilitiesgas_isusedawalakhir, $utilitiesgas_isdisabled, $utilitiesgas_createby, $utilitiesgas_createdate, $utilitiesgas_modifyby, $utilitiesgas_modifydate);   
			//echo var_dump($_POST);
			//exit;			
			redirect("master_utilitiesgas/master_utilitiesgas/master_utilitiesgaslist");
		
		
		
            
    }
	 
	function master_utilitiesgas_delete(){
		 
		$_id = $this->uri->segment(4);
		// echo $_id;
		// exit;
		$this->model_master_utilitiesgas->deletemaster_utilitiesgas($_id);
		redirect("master_utilitiesgas/master_utilitiesgas/master_utilitiesgaslist");
	}

	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_loo_cl->get_branch_dlg($rSearch['term']);
	    $result['items']= $branch; 
        echo json_encode($result);
    }
}  