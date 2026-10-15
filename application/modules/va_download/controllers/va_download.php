<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 


class va_download extends MX_Controller
{
	 
    public function __construct() 
    {
        parent::__construct();      
		check_user_login();   
        $this->load->model('Model_va'); 
		$this->load->library('breadcrumbcomponent'); 		
    }
    
 
    public function index() 
    {  
        $data['va_download']       	    = ''; 
        $data['yearCmb']       	        = $this->Model_va->get_year();  
		$data['yearSelected']       	= date('Y');  
		$data['monthCmb']       	    = $this->Model_va->get_month();  
		$data['monthSelected']       	= date('Y').'-'.(int)date('m');
        $data['branchCmb']       		= 0; 
        $data['regionCmb']       		= $this->Model_va->get_region(); 
        $data['items']['branch_id']     = ''; 
        $data['regionCmb']['region_id'] = ''; 
		$data['action'] 				= 'va_download/list_va';
		$data['branch_name']     	    = ''; 
		$data['periode_id']				= '';
		// echo print_r($data['yearCmb']);
		// exit;
		
	    $this->load->view('template/v_header');
		$this->load->view('va_download/view',$data);
		$this->load->view('template/v_footer');    
    } 
	
	public function getBranchAjax()
	{
		$region_id 			= empty($_GET['region']) ? '' : $_GET['region'];
		$branch_name 		= empty($_GET['term']) ? '' : $_GET['term'];
		$data['items']      = $this->Model_va->get_branch($branch_name['term'],$region_id);
		echo json_encode($data);
	}
     
    /**
    * Call Report
    *
    */
    public function list_va() 
    {     
	    //$this->session->sess_destroy();
		// $branchName ='';
        // $region 			= $this->input->post('region_id');
		// $branch 			= $this->input->post('branch_id');
		// $branchName 		= $this->input->post('branch_name');
		// $year 	        	= $this->input->post('year');
		// $branchID_Hidden 	= $this->input->post('branch_id_hidden');
		
		$region 		= $this->input->post('cboregionDlg'); 
		$branch 		= $this->input->post('branch_id_s');
		$branchName 	= $this->input->post('branch_name'); 
		$branchID_Hidden 	= $this->input->post('branch_id_hidden'); 
		$regionID_Hidden 	= $this->input->post('region_id_hidden'); 
		$regionName_Hidden 	= $this->input->post('region_name_hidden');
		$periode_id = $this->input->post('monthPeriode'); 
 	
		if(empty($year))
		{
			$year = date('Y');
		}
		IF (!empty($branchID_Hidden))
		{
			$branch = $branchID_Hidden;
		}
		if (empty($branch))
		{
			$branchName= '';
		}
		
	     // echo var_dump($_POST);
	     // exit;
		$reg = (!empty($regionID_Hidden)) ? $regionID_Hidden : $region  ;
		$data['action'] 					= 'va_download/list_va';
		$data['branch_id'] 					= $branch;  
		$data['items']['branch_id']     	= $branchName; 
		$data['branch_name']     	        = $regionName_Hidden.' <br/> '.$branchName; 
		$data['regionCmb']       			= $this->Model_va->get_region(); 
		$data['branchCmb']['branch_id'] 	= $branch;
		$data['regionCmb']['region_id']		= $region;  
		$data['periode_id']					= $this->Model_va->get_month($periode_id);
      
		$data['monthCmb']       	    	= $this->Model_va->get_month();  
		$data['monthSelected']       		= $periode_id;
		$data['va_download']       			= $this->Model_va->get_data_va($branch,$periode_id);
		
		// echo "<pre>";
		// echo print_r($reg); 
		// exit;
		
		$this->session->set_flashdata('title', 'VirtualAccount_'.str_replace(' ','', $regionName_Hidden).'_'.str_replace(' ','', $branchName) ); 
		$this->session->set_flashdata('branch', $branch ); 
		$this->session->set_flashdata('periode_id', $periode_id ); 
		
		$setting_excel = array(
			'branch'  => $branch,
			'periode_id'     => $periode_id , 
		); 
		$this->session->set_userdata($setting_excel);


	    $this->load->view('template/v_header');
		$this->load->view('va_download/view_process',$data);
		$this->load->view('template/v_footer');     
	}  
	
	public function report_download()
	{
		$data['va_download']       	    = ''; 
        $data['yearCmb']       	        = $this->Model_va->get_year();  
		$data['yearSelected']       	= date('Y');  
		$data['monthCmb']       	    = $this->Model_va->get_month();  
		$data['monthSelected']       	= date('Y').'-'.(int)date('m');
        $data['branchCmb']       		= 0; 
        $data['regionCmb']       		= $this->Model_va->get_region(); 
        $data['items']['branch_id']     = ''; 
        $data['regionCmb']['region_id'] = ''; 
		$data['action'] 				= 'va_download/list_va_report';
		$data['branch_name']     	    = ''; 
		$data['periode_id']				= '';
		// echo print_r($data['yearCmb']);
		// exit;
		
	    $this->load->view('template/v_header');
		$this->load->view('va_download/view_download',$data);
		$this->load->view('template/v_footer');    
	}
	
	/**
    * Call Report EXCEL
    *
    */
    public function list_va_excel() 
    {       
		$title = $this->session->flashdata('title');  

		$branch = $this->session->userdata('branch');
		$periode_id = $this->session->userdata('periode_id');

		$tenant_datas = $this->Model_va->get_data_va_insert($branch,$periode_id); 
		$data['title']						= $title.'_'.date("Y-m-d"); 
		//echo $data['title']	;
		$data['va_download']       		= $tenant_datas;    

		$array_items = array('branch', 'periode_id'); 
		$this->session->unset_userdata($array_items);

		$this->load->view('va_download/view_excel',$data); 
    } 
	

	/**
    * Call Report Yang sudah di download
    *
    */
    public function list_va_report() 
    {      
		$region 		= $this->input->post('cboregionDlg'); 
		$branch 		= $this->input->post('branch_id_s');
		$branchName 	= $this->input->post('branch_name'); 
		$branchID_Hidden 	= $this->input->post('branch_id_hidden'); 
		$regionID_Hidden 	= $this->input->post('region_id_hidden'); 
		$regionName_Hidden 	= $this->input->post('region_name_hidden');
		$periode_id = $this->input->post('monthPeriode'); 
 	
		if(empty($year))
		{
			$year = date('Y');
		}
		IF (!empty($branchID_Hidden))
		{
			$branch = $branchID_Hidden;
		}
		if (empty($branch))
		{
			$branchName= '';
		}
		
	     // echo var_dump($_POST);
	     // exit;
		$reg = (!empty($regionID_Hidden)) ? $regionID_Hidden : $region  ;
		$data['action'] 					= 'va_download/list_va';
		$data['branch_id'] 					= $branch;  
		$data['items']['branch_id']     	= $branchName; 
		$data['branch_name']     	        = $regionName_Hidden.' <br/> '.$branchName; 
		$data['regionCmb']       			= $this->Model_va->get_region(); 
		$data['branchCmb']['branch_id'] 	= $branch;
		$data['regionCmb']['region_id']		= $region;  
		$data['periode_id']					= $this->Model_va->get_month($periode_id);
      
		$data['monthCmb']       	    	= $this->Model_va->get_month();  
		$data['monthSelected']       		= $periode_id;
		$data['va_download']       			= $this->Model_va->get_data_va_report($branch,$periode_id);
		
		// echo "<pre>";
		// echo print_r($reg); 
		// exit;
		
		$this->session->set_flashdata('title', 'VirtualAccount_'.str_replace(' ','', $regionName_Hidden).'_'.str_replace(' ','', $branchName) ); 
		$this->session->set_flashdata('branch', $branch ); 
		$this->session->set_flashdata('periode_id', $periode_id ); 
		
		$setting_excel = array(
			'branch'  => $branch,
			'periode_id'     => $periode_id , 
		); 
		$this->session->set_userdata($setting_excel);


	    $this->load->view('template/v_header');
		$this->load->view('va_download/view_process_report',$data);
		$this->load->view('template/v_footer');     
    }  
	
	/**
    * Call Report EXCEL
    *
    */
    public function list_va_excel_report() 
    {       
		$title = $this->session->flashdata('title');  

		$branch = $this->session->userdata('branch');
		$periode_id = $this->session->userdata('periode_id');

		$tenant_datas = $this->Model_va->get_data_va_report($branch,$periode_id); 
		$data['title']						= $title.'_'.date("Y-m-d"); 
		//echo $data['title']	;
		$data['va_download']       		= $tenant_datas;    

		$array_items = array('branch', 'periode_id'); 
		$this->session->unset_userdata($array_items);

		$this->load->view('va_download/view_excel',$data); 
    } 
	

	public function tes()
	{
		echo "<pre>";
		echo print_r($this->Model_va->get_year());
	}
	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->Model_va->get_branch_dlg($rSearch['term']);
	    $result['items']= $branch; 
        echo json_encode($result);
    } 
	public function getRegionAll()
	{
		$regionCmb['items'] = $this->Model_va->get_region_dlg(); 
		echo json_encode($regionCmb);
	}
}

?>
