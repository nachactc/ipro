<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Programweb extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_program');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
    }
    
    function index(){       
        redirect('master_program/programweb/programlist');
    }
    function globalsearch_dialog(){
		$arcari=array('unit_name', 'region_id', 'branch_id');
		return $arcari;
	}   
    function globalsearch_rekanan(){
        $arcari=array('rekanan_name','rekananshipping_name');
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
		$arcari=array('program_id',  'CTE.program_id','CTE.program_title','CTE.program_creator','CTE.program_url');
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
				if ($searchCol != '') {
					if ($sWhere != ''){             
						$sWhere .= " AND ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
					} else {
						$sWhere = "WHERE ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
					}
					 $sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;
					
				}
			}
		}
		 
		
		 
		
		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
		$limit=$limit+$top;

		$b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ;        

		if($sWhere == '' AND $cariOptional != '')
		{
			$sWhere = 'WHERE '.$cariOptional;
		}
		else
		{
			$sWhere = $sWhere.$b;
		}
		//echo $sWhere;exit;
		$rResult=$this->model_program->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_program->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_program->$qry_totalall();
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
				$criteria = $criteria." AND CTE.program_isdisabled = 1";
			}
			else
			{
				$criteria =  " CTE.program_isdisabled = 1";
			}
		}
		elseif($searchStatus == 'ret')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.program_isdisabled = 0";
			}
			else
			{
				$criteria =  " CTE.program_isdisabled = 0";
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
		elseif($searchStatus == 'all')
		{
			 $criteria = null ; 
		}
		 
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['program_id']); 
			$url = base_url();  
			$_menu='
				<a href="/index.php/master_program/programweb/program_edit/'.$i_link.'" data-toggle="tooltip" title="Edit">
				<img border="0" src="/assets/img/edit.png" width="21" height="21"></a> 
				<a href="/index.php/master_program/programweb/program_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$i_link.')">
				<img border="0" src="/assets/img/delete.png" width="21" height="21"></a>';
             

            $row = array();

			$row[]=$aRow['program_id']; 
			$row[]=$aRow['program_title'];
			$row[]=$aRow['program_icon'];
			$row[]=$aRow['program_url']; 
			$row[]=$aRow['program_controller']; 
			$row[]=$aRow['program_creator']; 
            $row[]=$aRow['program_isdisabled']; 
			$row[]=$_menu;
    	
            if (!empty($row)) { $output['data'][] = $row; }
        	}   
        	echo json_encode($output);
    		
    }

    function programlist(){
        
        $program_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_program->getoneprogram($program_id),
                  'program_id'   => $program_id
            );        
         
		
		$this->breadcrumbcomponent->add('Program Web','master_program/programweb/programlist');

        $this->load->view('template/v_header');
        $this->load->view('master_program/program_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function program_add()
	{		
        
        $program_id = $this->uri->segment(4);        
          
  		$this->breadcrumbcomponent->add('Add Program Web','master_program/programweb/program_add');
		$data = array(
		'groupid' => $this->model_program->getGroup()
		);


        $this->load->view('template/v_header');
        $this->load->view('master_program/program_add',$data);
        $this->load->view('template/v_footer');
	}
	
    function program_edit()
	{		
        
        $program_id = $this->uri->segment(4);        
          
  		$this->breadcrumbcomponent->add('Edit Program Web','master_program/programweb/program_edit');

		$data = array(
			'result' => $this->model_program->getoneprogram($program_id)
		);
        $this->load->view('template/v_header');
        $this->load->view('master_program/program_edit',$data);
        $this->load->view('template/v_footer');
	}
    
	 
    function programsave(){        

        if ($_POST){
            
            $program_id             = $this->input->post('program_id');
            $program_title           = $this->input->post('program_title');
            $program_icon          = $this->input->post('program_icon');
            $program_url          = $this->input->post('program_url');
            $program_controller           = $this->input->post('program_controller');            
            $program_isdisabled          = $this->input->post('program_isdisabled'); 
            $program_creator          = $this->input->post('program_creator'); 
            $group_id          = $this->input->post('group_id'); 
            $program_isdisabled = $program_isdisabled == '' ? 0 : 1; 
			
			$this->form_validation->set_rules('program_title', 'Title', 'required');
			$this->form_validation->set_rules('group_id', 'Group', 'required');
			$this->form_validation->set_rules('program_url', 'Menu Url', 'required'); 
			$this->form_validation->set_rules('program_controller', 'Controller', 'required'); 
			
			if ($this->form_validation->run() == TRUE) { 
				$this->model_program->insertprogram($program_id, $program_title, $program_icon, $program_url, $program_controller,$program_creator, $program_isdisabled,$group_id); 
				redirect("master_program/programweb/programlist");
			} else {
				$this->program_add();	
			}
        }
    }
  
    function programedit(){        

        if ($_POST){
            
            $program_id             = $this->input->post('program_id');
            $program_title           = $this->input->post('program_title');
            $program_icon          = $this->input->post('program_icon');
            $program_url          = $this->input->post('program_url');
            $program_controller           = $this->input->post('program_controller');            
            $program_isdisabled          = $this->input->post('program_isdisabled'); 
            $program_creator          = $this->input->post('program_creator'); 
            $program_isdisabled = $program_isdisabled == '' ? 0 : 1; 
			
			$this->form_validation->set_rules('program_title', 'Title', 'required');
			$this->form_validation->set_rules('program_url', 'Menu Url', 'required'); 
			$this->form_validation->set_rules('program_controller', 'Controller', 'required'); 
			
			if ($this->form_validation->run() == TRUE) { 
				$this->model_program->updateprogram($program_id, $program_title, $program_icon, $program_url, $program_controller,$program_creator, $program_isdisabled); 
				redirect("master_program/programweb/programlist");
			} else {
				$this->program_add();	
			}
        }
    }
	
	function program_delete(){
		
        $i_link = $this->uri->segment(4);       

        $_id = str_replace('_', '/', $i_link); 

		$this->model_program->deleteprogram($_id);
		redirect("master_program/programweb/programlist");
	}
 
}  