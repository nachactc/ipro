<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MX_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
		//print 'tes';
		//$this->brea        
		check_user_login();
        $this->load->model('model_user');
		$this->load->library('breadcrumbcomponent'); 
		//$this->load->library('form_validation'); 
		//print 'tes';
		//$this->breadcrumbcomponent->add('User','user');		
    }
     
	 
    public function index() 
    {
		redirect('user/user/userlist');   
    }


	function globalsearch_list(){
		$arcari=array('username',  'CTE.username','CTE.user_fullname');
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

		$sWhere = $sWhere.$b;
		
		$rResult=$this->model_user->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_user->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_user->$qry_totalall();
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


    function controler_gridlist($val_search = '',$val_serach_branch=''){
		$arcari=$this->globalsearch_list(); 
		$searchStatus = $val_search;
		
		
		$criteria = null; 
/*		
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
		if($val_serach_branch != '')
		{
			if($criteria != '')
			{
				$criteria = $criteria . " and CTE.branch_id = '$val_serach_branch'";
			}
			else
			{
				$criteria =	" CTE.branch_id = '$val_serach_branch'";
			}
		}
	*/	
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output']; 
    	foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['username']);
            //$ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
            //$is_post = ($aRow['isconfirm']) ? 1 : 0;
            //$is_post = ($aRow['isapproved']) ? 1 : 0;
			$_menu='
				<a href="/index.php/user/user/useredit/'.$i_link.'" data-toggle="tooltip" title="Edit">
				<img border="0" src="/assets/img/edit.png" width="21" height="21"></a>';

			/*
            if ($aRow['isapproved']) {
                $_menu='
                    <a href="/ipro/index.php/user/user/useredit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                    <img border="0" src="/ipro/assets/img/edit.png" width="21" height="21"></a>
                    <a href="/ipro/index.php/looprint/looprint/looprintpdf/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
                    <img border="0" src="/ipro/assets/img/print.png" width="21" height="21"> </a>        
                    <a href="/ipro/index.php/looprint/looprint/invprintpdf/'.$i_link.'" data-toggle="tooltip" title="Invoice" target="_blank">
                    <img border="0" src="/ipro/assets/img/invoice.png" width="21" height="21"></a>
                    <a href="/ipro/index.php/loo/loo/loo_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
                    <img border="0" src="/ipro/assets/img/delete.png" width="21" height="21"></a>'; 

            } else {
                $_menu='
                    <a href="/ipro/index.php/loo/loo/looedit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                    <img border="0" src="/ipro/assets/img/edit.png" width="21" height="21"></a>
                    <a href="/ipro/index.php/looprint/looprint/looprintpdf/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
                    <img border="0" src="/ipro/assets/img/print.png" width="21" height="21"> </a>                    
                    <a href="/ipro/index.php/loo/loo/loo_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
                    <img border="0" src="/ipro/assets/img/delete.png" width="21" height="21"></a>';
            }*/

            $row = array();

			$row[]=$aRow['username'];
			$row[]=$aRow['user_fullname'];
			$row[]=$aRow['user_password'];
			$row[]=$aRow['user_isdisabled'];
			$row[]=$aRow['region_name'];
			$row[]=$aRow['branch_name'];
			$row[]=$_menu;
    	
            if (!empty($row)) { $output['data'][] = $row; }
        	}   
        	echo json_encode($output);
    		
    }

	
    function userlist(){
        
        $username = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_user->viewuser($username),
                  'username'   => $username
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->model_user->get_branch_list();
        $data['strukturunit'] = $this->model_user->get_strukturunit_list();
		
		$this->breadcrumbcomponent->add('User','user/user/userlist');

        $this->load->view('template/v_header');
        $this->load->view('user/v_userlist', $data);
        $this->load->view('template/v_footer');
    }
	
	   
    function region_select(){
        $this->load->model('template/Master_m');
        
        $region     = $this->Master_m->get_region();
        //$options    = array('' => 'Select an option');                
		
		$options ['']= 'Pilih Bussiniess Unit :';
        
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
	
	

	function useredit(){		
        
        $i_link = $this->uri->segment(4);       

        $username = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_user->viewuser($username),
                  'username'   => $username
            );                
        
			$data['region'] = $this->region_select();
			$data['branch'] = $this->model_user->get_branch_list();
			$data['strukturunit'] = $this->model_user->get_strukturunit_list();
			$data['channel'] = $this->model_user->get_channel();
			$data['userregion'] = $this->model_user->get_userregion($username);
			$data['userbranch'] = $this->model_user->get_userbranch($username);
			$data['userstrukturunit'] = $this->model_user->get_userstrukturunit($username);
			
		$this->breadcrumbcomponent->add('User','user/user/userlist')
            ->add('Edit User','user/user/useredit');        

        $this->load->view('template/v_header');
        $this->load->view('user/user_edit', $data);
        $this->load->view('template/v_footer');
	}



    function user_edit(){

            $username           = $this->input->post('username');
            $user_fullname      = $this->input->post('user_fullname');
            $user_password      = $this->input->post('user_password');
            $region_id          = $this->input->post('region_id');
            $branch_id          = $this->input->post('branch_id');
            $strukturunit_id    = $this->input->post('strukturunit_id');            
			$user_isdisabled    = ($this->input->post('user_isdisabled') == '') ? 0 : $this->input->post('user_isdisabled');
			$user_default_channel_id    = $this->input->post('user_default_channel_id');
			$userregion			= $this->input->post('checked_region[]');
			$userbranch			= $this->input->post('checked_branch[]');
			$userstrukturunit	= $this->input->post('checked_strukturunit[]');
			
			$this->model_user->updateuser($username, $user_fullname, $user_password, $user_isdisabled, $region_id, $branch_id, $strukturunit_id,$user_default_channel_id,$userregion,$userbranch,$userstrukturunit);

		redirect("user/user/useredit/".$username);
    }
	
	
    function useradd()
	{		
        
        $username = '';        
        
        $data   = array(
                  'result'    => $this->model_user->viewuser($username),
                  'username'   => $username
            );        
        
			$data['region'] = $this->region_select();
			$data['branch'] = $this->model_user->get_branch_list();
			$data['strukturunit'] = $this->model_user->get_strukturunit_list();
			$data['channel'] = $this->model_user->get_channel();
			$data['userregion'] = $this->model_user->get_userregion($username);
			$data['userbranch'] = $this->model_user->get_userbranch($username);
			$data['userstrukturunit'] = $this->model_user->get_userstrukturunit($username);

  		$this->breadcrumbcomponent->add('User','user/user/userlist')
            ->add('Input User','user/user/useradd');


        $this->load->view('template/v_header');
        $this->load->view('user/user_add', $data);
        $this->load->view('template/v_footer');
	}
    
	function user_add(){        

        if ($_POST){
            
            $username           = $this->input->post('username');
            $user_fullname      = $this->input->post('user_fullname');
            $user_password      = $this->input->post('user_password');
            $region_id          = $this->input->post('region_id');
            $branch_id          = $this->input->post('branch_id');
            $strukturunit_id    = $this->input->post('strukturunit_id');            
			$user_isdisabled    = ($this->input->post('user_isdisabled') == '') ? 0 : $this->input->post('user_isdisabled');
			$user_default_channel_id    = $this->input->post('user_default_channel_id');
			$userregion			= $this->input->post('checked_region[]');
			$userbranch			= $this->input->post('checked_branch[]');
			$userstrukturunit	= $this->input->post('checked_strukturunit[]');
			
			//$this->form_validation->set_rules('region_id', 'Business Unit', 'required');
			//$this->form_validation->set_rules('branch_id', 'Store', 'required'); 
			//$this->form_validation->set_rules('strukturunit_id', 'Struktur Unit', 'required'); 
			
			//if ($this->form_validation->run() == TRUE) { 
			$this->model_user->insertuser($username, $user_fullname, $user_password, $user_isdisabled, $region_id, $branch_id, $strukturunit_id,$user_default_channel_id,$userregion,$userbranch,$userstrukturunit);

			redirect("user/user/useredit/".$username);
			//} else {
			//$this->useradd();	
			//}
        }
	}
	

	function region_bybranch ($branch){
		$i_link = $this->uri->segment(3);       

		$branch = str_replace('_', '/', $i_link); 
		
		if($branch){
			$region      = $this->model_user->get_region_bybranch($branch);
            
			$result['region']= $region ;
		  
			echo json_encode($result);
	
		}else{
			echo json_encode('');
		}
		
	}
 
}  
