<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rpt_kartupiutang extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_kartupiutang'); 
		$this->load->library('breadcrumbcomponent');
		$this->load->helper(array('form', 'url'));
    }
    
	 
	function index(){       
        redirect('rpt_kartupiutang/report_list');
    }
  
    function report_list(){
        		
		$this->breadcrumbcomponent->add('Report Income Summary','rpt_kartupiutang/report_list'); 
		//$data['agrType'] = $this->Agr_select();
		//$data['GroupTenantType'] = $this->GroupTenant_select();
		//$data['GradeProperty'] = $this->PropertyGrade_select();
		$data = array();
   
        $this->load->view('template/v_header');
        $this->load->view('rpt_kartupiutang/kartupiutang_list',$data);
        $this->load->view('template/v_footer');
    }
	 
    function Agr_select(){ 
        
        $hasil     = $this->model_kartupiutang->get_AgrGroup();
        //$options    = array('' => 'Select an option');                
        
        if($hasil != 'kosong'){
            foreach($hasil as $key => $value){
				$options[''] = '';
                $options[$value->agrtypegroup_id]= $value->agrtypegroup_name;
            }
		}
		else
		{
			$options[''] = '';
		}
                    
        return $options;
    }
	
    function GroupTenant_select(){ 
        
        $hasil     = $this->model_kartupiutang->get_GroupTenant();
        //$options    = array('' => 'Select an option');                
        
        if($hasil != 'kosong'){
            foreach($hasil as $key => $value){
				$options[''] = '';
                $options[$value->grouptenant_id]= $value->grouptenant_name;
            }
        }
		else
		{
			$options[''] = '';
		}
                    
        return $options;
    }
	
    function PropertyGrade_select(){ 
        
        $hasil     = $this->model_kartupiutang->get_PropertGrade();
        //$options    = array('' => 'Select an option');                
        
        if($hasil != 'kosong'){
            foreach($hasil as $key => $value){
				$options[''] = '';
                $options[$value->branch_id]= $value->branch_name;
            }
        }
		else
		{
			$options[''] = '';
		}
                    
        return $options;
    }
   
    function report_load()
    {  
		$data['post'] = array(); 
		$data = array();
		$region_id = $this->input->post('region_ids'); 
		$branch_id = $this->input->post('branch_id');
		$rekanan_id = $this->input->post('rekanan_id');
		$rekananshipping_line = $this->input->post('rekananshipping_id');
		$schedulepayment_id =  $this->input->post('schedulepayment_id'); 
		$report_type = $this->input->post('report_type');
		$excel = $this->input->post('excel');
		
		$txtSearchCriteria = '';
		$data['post']['region_id'] = $region_id;
		$data['post']['branch_id'] = $branch_id;
		$data['post']['rekanan_id'] = $rekanan_id;
		$data['post']['rekananshipping_line'] = $rekananshipping_line;
		$data['post']['schedulepayment_id'] = $schedulepayment_id;
		$data['post']['report_type'] = $report_type;
		$data['post']['excel'] = $excel;
		
		 
		if($schedulepayment_id <> '')
		{
			
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "b.schedulepayment_id = '$schedulepayment_id'";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND b.schedulepayment_id = '$schedulepayment_id' ";
			}
			
		}
		
		if($rekanan_id <> 0)
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "d.rekanan_id = '$rekanan_id'";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND d.rekanan_id = '$rekanan_id' ";
			}
		}
		if($rekananshipping_line <> 0 )
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = " d.rekananshipping_line = '$rekananshipping_line'";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria."  AND d.rekananshipping_line = '$rekananshipping_line' ";
			}
		}
	  
		$criteria=$txtSearchCriteria;
		
		//echo ($criteria);exit; 
		  
		$channel_id = '';
		$reportView = '';
		switch($report_type)
		{
			case 'kartu_piutang':
				$data['result'] = $this->model_kartupiutang->get_Reportincome($criteria);
				$reportView = 'rpt_kartupiutang/report_list_detil';
				$data['title'] = 'S.O.A/Kartu Piutang';
			break;
			case 'kartu_piutangGroup':
				$data['result'] = $this->model_kartupiutang->get_Reportincome($criteria);
				$reportView = 'rpt_kartupiutang/report_list';
				$data['title'] = 'S.O.A/Kartu Piutang Group';
			break; 
			 
			
		}
		// echo var_dump($_POST);exit;
		$this->breadcrumbcomponent->add('Report Income Summary','rpt_kartupiutang/report_list');  
		
		if($excel == ''){
			$this->load->view('template/v_header');
			$this->load->view('rpt_kartupiutang/script');
			$this->load->view($reportView,$data);
			$this->load->view('template/v_footer');
		}else{ 
			$this->load->view('rpt_kartupiutang/script');
			$this->load->view($reportView,$data); 
		}
        
		
		// $this->load->view($reportView,$data);
		
    }
	 
	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_kartupiutang->get_branch_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function acc_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_kartupiutang->get_acc_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function region_select_dialog(){
	
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		// echo var_dump($rSearch['term']);exit;
		$branch      = $this->model_kartupiutang->get_region_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function rekanan_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_kartupiutang->get_rekanan_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function rekananshipping_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_kartupiutang->get_rekananshipping_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}

    function branch_select(){
 
        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];
        $rRegion = empty($_GET['region']) ? '' : $_GET['region'];


        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            

            $this->load->model('template/Master_m');
            
            $branch      = $this->Master_m->get_branchbyquery($rSearch['term'], $rRegion);
            
			
            $result['items']= $branch;
          
            echo json_encode($result);
            
        };
    }
	
	function schedulepayment_select_dialog(){ 
		$rTenant = empty($this->input->post('tenant')) ? '' : trim($this->input->post('tenant'));
	 
		$sp_id = $this->model_kartupiutang->get_schedulepaymentid_dlg($rTenant);
        echo json_encode(array_values($sp_id)); 
	}
	 
}  