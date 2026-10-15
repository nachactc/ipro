<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Programuserweb extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_programuser');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
    }
    
    function index(){       
        redirect('master_programgroup/programgroupweb/grouplist');
    }
  
	function globalsearch_list(){
		$arcari=array( 'CTE.group_id','b.group_name','c.program_title');
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
		$rResult=$this->model_programuser->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_programuser->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_programuser->$qry_totalall();
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
			$url = base_url();  
			$_menu=' 
				<a href="'.$url.'index.php/master_programgroup/programgroupweb/programgroup_delete/'.$aRow['group_id'].'/'.$aRow['program_id'].' " data-toggle="tooltip" title="Trash" onclick="return deleteid('.$aRow['group_id'].')">
				<img border="0" src="'.$url.'/assets/img/delete.png" width="21" height="21"></a>';
             

            $row = array();

			$row[]=$aRow['group_id']; 
			$row[]=$aRow['group_name'];
			$row[]=$aRow['program_title'];  
			$row[]=$aRow['program_id'];
			$row[]=$_menu;
    	
            if (!empty($row)) { $output['data'][] = $row; }
        	}   
        	echo json_encode($output);
    		
    }

    function userlist($group_id = '',$username = ''){
        
        $program_id = $this->uri->segment(4);
      
		$this->breadcrumbcomponent->add('Program User Web','master_userprogramgroup/programuserweb/userlist');
		$model = null; 
		if(!empty($_POST)){
			$group_id = $this->input->post('group_id');
			$username = $this->input->post('username'); 
			$model = $this->model_programuser->getData_programUser($username,$group_id);
		}else
		{
			if($group_id != '' and $username != '')
			{
				$model = $this->model_programuser->getData_programUser($username,$group_id);
			}
		}
		
		$data = array(
			'group_id' => $this->model_programuser->getGroup(),
			'username_list' => $this->model_programuser->getUsername(),
			'result' => $model,
			'groupid' => $group_id,
			'username' => $username,
		);
        $this->load->view('template/v_header');
        $this->load->view('master_userprogram/userprogram_list',$data);
        $this->load->view('template/v_footer');
    }

    
	
	function savelist($group_id,$username)
	{
		
		$checklist = $this->input->post('pilih');
		if($_POST)
		{
			$this->model_programuser->delete($group_id,$username);
			foreach($checklist as $input)
			{
				if($input)
				{
					$data = explode("-", $input);
					// echo $data[0]."<br/>"; // piece1
					// echo $data[1]."<br/>"; // piece1
					// echo $data[2]."<br/>"; // piece1
					$this->model_programuser->saveData_programUser($username,$group_id,$data[0]);
					
				}
				
			}
		}
		redirect('master_userprogram/programuserweb/userlist/'.$group_id.'/'.$username);
	}
	
	
    
    function programgroup_add()
	{		
        
        $program_id = $this->uri->segment(4);        
          
  		$this->breadcrumbcomponent->add('Add Program Group Web','master_programgroup/programgroupweb/programgroup_add');

		$data = array(
			'groupid' => $this->model_programuser->getGroup(),
			'programid' => $this->model_programuser->getProgram()
		);
        $this->load->view('template/v_header');
        $this->load->view('master_programgroup/programgroup_add',$data);
        $this->load->view('template/v_footer');
	}
	
    function group_edit()
	{		
        
        $group_id = $this->uri->segment(4);        
          
  		$this->breadcrumbcomponent->add('Edit Group Web','master_group/groupweb/group_edit');

		$data = array(
			'result' => $this->model_programuser->getonegroup($group_id)
		);
        $this->load->view('template/v_header');
        $this->load->view('master_group/group_edit',$data);
        $this->load->view('template/v_footer');
	}
    
	 
    function groupsave(){        

        if ($_POST){
            
            $group_id             = $this->input->post('group_id');
            $program_id           = $this->input->post('program_id');      
			
			$this->form_validation->set_rules('group_id', 'Group Name', 'required');
			$this->form_validation->set_rules('program_id', 'Program', 'required');  
			
			if ($this->form_validation->run() == TRUE) { 
				$this->model_programuser->insertgroup($group_id, $program_id); 
				redirect("master_programgroup/programgroupweb/grouplist");
			} else {
				$this->programgroup_add();	
			}
        }
    }
   
	function programgroup_delete($group_id,$program_id){ 

		$this->model_programuser->delete($group_id,$program_id);
		redirect("master_programgroup/programgroupweb/grouplist");
	}
 
}  