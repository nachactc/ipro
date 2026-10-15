<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groupweb extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_group');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
    }
    
    function index(){       
        redirect('master_group/groupweb/grouplist');
    }
  
	function globalsearch_list(){
		$arcari=array('group_id',  'CTE.group_id','CTE.group_name','CTE.group_code');
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
		$rResult=$this->model_group->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_group->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_group->$qry_totalall();
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
				$criteria = $criteria." AND CTE.group_isdisabled = 1";
			}
			else
			{
				$criteria =  " CTE.group_isdisabled = 1";
			}
		}
		elseif($searchStatus == 'ret')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.group_isdisabled = 0";
			}
			else
			{
				$criteria =  " CTE.group_isdisabled = 0";
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

            $i_link = str_replace('/', '_', $aRow['group_id']); 
			$url = site_url();  
			$_menu='
				<a href="/index.php/master_group/groupweb/group_edit/'.$i_link.'" data-toggle="tooltip" title="Edit">
				<img border="0" src="/assets/img/edit.png" width="21" height="21"></a> 
				<a href="/index.php/master_group/groupweb/group_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$i_link.')">
				<img border="0" src="/assets/img/delete.png" width="21" height="21"></a>';
             

            $row = array();

			$row[]=$aRow['group_id']; 
			$row[]=$aRow['group_name'];
			$row[]=$aRow['group_icon'];
			$row[]=$aRow['group_code']; 
			$row[]=$aRow['group_isdisabled'];  
			$row[]=$_menu;
    	
            if (!empty($row)) { $output['data'][] = $row; }
        	}   
        	echo json_encode($output);
    		
    }

    function grouplist(){
        
        $program_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_group->getonegroup($program_id),
                  'program_id'   => $program_id
            );        
         
		
		$this->breadcrumbcomponent->add('Program Web','master_group/groupweb/grouplist');

        $this->load->view('template/v_header');
        $this->load->view('master_group/group_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function group_add()
	{		
        
        $program_id = $this->uri->segment(4);        
          
  		$this->breadcrumbcomponent->add('Add Group Web','master_group/groupweb/group_add');


        $this->load->view('template/v_header');
        $this->load->view('master_group/group_add');
        $this->load->view('template/v_footer');
	}
	
    function group_edit()
	{		
        
        $group_id = $this->uri->segment(4);        
          
  		$this->breadcrumbcomponent->add('Edit Group Web','master_group/groupweb/group_edit');

		$data = array(
			'result' => $this->model_group->getonegroup($group_id)
		);
        $this->load->view('template/v_header');
        $this->load->view('master_group/group_edit',$data);
        $this->load->view('template/v_footer');
	}
    
	 
    function groupsave(){        

        if ($_POST){
            
            $group_id             = $this->input->post('group_id');
            $group_name           = $this->input->post('group_name');
            $group_icon          = $this->input->post('group_icon');
            $group_code          = $this->input->post('group_code');
            $group_isdisabled           = $this->input->post('group_isdisabled');      
			
			$this->form_validation->set_rules('group_name', 'Group Name', 'required');
			$this->form_validation->set_rules('group_code', 'Group Code', 'required');  
			
			if ($this->form_validation->run() == TRUE) { 
				$this->model_group->insertgroup($group_id, $group_name, $group_icon, $group_code, $group_isdisabled); 
				redirect("master_group/groupweb/grouplist");
			} else {
				$this->group_add();	
			}
        }
    }
  
    function groupedit(){        

        if ($_POST){
            
            $group_id             = $this->input->post('group_id');
            $group_name           = $this->input->post('group_name');
            $group_icon          = $this->input->post('group_icon');
            $group_code          = $this->input->post('group_code');
            $group_isdisabled           = $this->input->post('group_isdisabled');      
			
			$this->form_validation->set_rules('group_name', 'Group Name', 'required');
			$this->form_validation->set_rules('group_code', 'Group Code', 'required');  
			
			if ($this->form_validation->run() == TRUE) { 
				$this->model_group->updategroup($group_id, $group_name, $group_icon, $group_code, $group_isdisabled); 
				redirect("master_group/groupweb/grouplist");
			} else {
				$this->group_add();	
			}
        }
    }
	
	function group_delete(){
		
        $i_link = $this->uri->segment(4);       

        $_id = str_replace('_', '/', $i_link); 

		$this->model_group->deletegroup($_id);
		redirect("master_group/groupweb/grouplist");
	}
 
}  