<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_unit');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('breadcrumbcomponent');
    }
    
    function index(){       
        redirect('unit/unit/unitlist');
    }
    function globalsearch_dialog(){
		$arcari=array('schedulebooking_id','invoice_id');
		return $arcari;
	}
	function globalsearch_list(){
		$arcari=array('unit_id', 'unit_name', 'region_id','branch_name','refid','rekanan','brand');
		// $arcari=array('a.unit_id', 'a.unit_name', 'a.region_id','BRANCH.branch_name','refid','rekanan','brand');
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
    $rResult=$this->model_unit->$qry_alldata($limit,$top,$sWhere);
   
	$rResultCnt =$this->model_unit->$qry_filtered($sWhere);
	$iFilteredTotal = $rResultCnt['jml'];

	$rResultTotal =$this->model_unit->$qry_totalall();
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
		$a = $this->model_unit->cek_unit_status('03000004060601');
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
				$criteria = $criteria." AND unit_state = 0";
			}
			else
			{
				$criteria =  " unit_state = 0" ;
			}
		} 
		elseif($searchStatus == 'sold')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND unit_state = 2";
			}
			else
			{
				$criteria =  " unit_state = 2" ;
			}
		} 
		elseif($searchStatus == 'la')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND unit_state = 3";
			}
			else
			{
				$criteria =  " unit_state = 3" ;
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
		
		if($aRow['status'] == 'Available')
		{
			$status = '  <span class="label label-sm label-danger">
                                Available
                              </span> ';
		}
		elseif($aRow['status'] == 'SOLD')
		{
			$status = '  <span class="label label-sm label-success">
                                SOLD
                              </span>';
		}
		elseif($aRow['status'] == 'DISABLED')
		{
			$status = '  <span class="label label-sm label-warning">
                                DISABLED
                              </span>';
		}
		else
		{
			$status = '<span class="label label-sm label-info">
                                LA Return
                              </span>';
		}
        $row = array();
				$row[]=$aRow['unit_id'];
                $row[]=$aRow['unit_name'];
				$row[]=$aRow['unit_sqm'].' m<sup>2</sup>';
                $row[]=$status ;
                $row[]=$aRow['refid']; 
                $row[]=$aRow['rekanan']; 
                $row[]=$aRow['brand']; 
                $row[]=$aRow['unittype_name'];
				$row[]=$aRow['region_nameshort'];
				$row[]=$aRow['branch_name'];
                $row[]=$aRow['lantai_name'];//
				// if($this->model_unit->cek_unit_status($aRow['unit_id']))
				// {
					// $disabled = '';
				// }
				// else
				// {
					// $disabled = 'disabled';
				// }
				$disabled = '';
				$row[]=' <a class="btn btn-sm btn-primary '.$disabled.'" href="/index.php/unit/unit/unitedit/'.$aRow['unit_id'].'" title="Edit" ><i class="glyphicon glyphicon-pencil"></i> </a> 
				<a class="btn btn-sm btn-danger '.$disabled.'" href="/index.php/unit/unit/unit_delete/'.$aRow['unit_id'].'" title="Hapus" onclick="return deleteid()"><i class="glyphicon glyphicon-trash"></i> </a>';
				
	
        if (!empty($row)) { $output['data'][] = $row; }
    	}   
    	echo json_encode($output);
		
}

    function unitlist(){
        
        $unit_id = $this->uri->segment(5);
        $data   = array(
                  'result'    => $this->model_unit->viewunit($unit_id),
                  'unit_id'   => $unit_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->model_unit->get_branch_list();
		
		$this->breadcrumbcomponent->add('Unit','unit/unitlist');

        $this->load->view('template/v_header');
        $this->load->view('unit/unit_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function unitadd()
	{		
        
        $unit_id = $this->uri->segment(4);
        
        $data   = array(
                  'result'    => $this->model_unit->viewunit($unit_id),
                  'unit_id'   => $unit_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
		$data['lantai'] = $this->floor_select();
		$data['unittype'] = $this->unittype_select();

  		$this->breadcrumbcomponent->add('Unit','unit/unit/unitlist')
            ->add('Input Unit','unit/unit/unitadd');


        $this->load->view('template/v_header');
        $this->load->view('unit/unit_add', $data);
        $this->load->view('template/v_footer');
	}
     
	function unitedit()
	{		
        
        $unit_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_unit->viewunit($unit_id),
                  'unit_id'   => $unit_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();	
		$data['lantai'] = $this->floor_select();
		$data['unittype'] = $this->unittype_select();
		
		$this->breadcrumbcomponent->add('Unit','unit/unit/unitlist')
            ->add('Edit Unit','unit/unit/unitedit');

        $this->load->view('template/v_header');
        $this->load->view('unit/unit_edit', $data);
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
        $branch     = $this->model_unit->get_floor();
        $options    = "";                
        
        if(count($branch)){
            foreach($branch as $key => $value){
                $options[$value->lantai_id]= $value->lantai_name;
            }
        }
                    
        return $options;
    }
	
	function unittype_select(){
        $branch     = $this->model_unit->get_unittype();
        $options    = "";                
        
        if(count($branch)){
            foreach($branch as $key => $value){
                $options[$value->unittype_id]= $value->unittype_name;
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
  
    function unit_edit(){
			// echo "<pre/>";
			// echo print_r($_POST);
			// exit;
	
        	$unit_id	      = $this->input->post('unit_id');
            $unit_name        = $this->input->post('unit_name');
            $unit_sqm         = $this->input->post('unit_sqm');
            $region           = $this->input->post('val_region');
            $branch           = $this->input->post('cbobranch');
            $_createby        = $this->input->post('_createby');
			$_modifyby	      = $this->session->userdata('user_fullname');
			$unit_coordinate  = $this->input->post('unit_coordinate');
			$unit_coordtype   = $this->input->post('unit_coordtype');
			$unittype_id   = $this->input->post('cbounittype');
			$username =  $this->session->userdata('user_fullname');
			$cbofloor   = $this->input->post('cbofloor');

		$this->model_unit->updateunit($unit_id,$unit_name,$unit_sqm,$_createby,$_modifyby,$region,$branch, $unit_coordinate,$unit_coordtype,$unittype_id,$cbofloor);
        
		redirect("unit/unit/unitlist");
    }
	
	function saveunit(){
		  
		$this->form_validation->set_rules('unit_name', 'Unit Name', 'required');
		$this->form_validation->set_rules('unit_sqm', 'Sqm', 'required');
		
		// echo "<pre/>";
		// echo print_r($_POST);
		// exit;
		
		if ($this->form_validation->run() == TRUE)
		{
			$unit_name        = $this->input->post('unit_name');
            $unit_sqm         = $this->input->post('unit_sqm');
            $region           = $this->input->post('val_region');
            $branch           = $this->input->post('cbobranch');
			$unit_coordinate  = $this->input->post('unit_coordinate');
			$unit_coordtype   = $this->input->post('unit_coordtype');
			$cbofloor   = $this->input->post('cbofloor');
			$cbounittype= $this->input->post('cbounittype');
			//echo $cbounittype;
			//exit;
			$this->model_unit->saveunit($unit_name,$unit_sqm,$region,$branch,$unit_coordinate,$unit_coordtype,$cbofloor,$cbounittype);   
			//echo var_dump($_POST);
			//exit;			
			redirect("unit/unit/unitlist");
		}
		else
		{
			$this->unitadd();
		}
		
            
    }
	 
	function unit_delete(){
		 
		$_id = $this->uri->segment(4);
		// echo $_id;
		// exit;
		$this->model_unit->deleteunit($_id);
		redirect("unit/unit/unitlist");
	}

	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_loo_cl->get_branch_dlg($rSearch['term']);
	    $result['items']= $branch; 
        echo json_encode($result);
    }
}  