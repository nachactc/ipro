<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 


class Summary_soa extends MX_Controller
{
	 
    public function __construct() 
    {
        parent::__construct();      
		check_user_login();   
        $this->load->model('Model_summary_soa'); 
		$this->load->library('breadcrumbcomponent'); 	
		//$this->load->library('excel');
    }
    
	public function index()
	{
		redirect('summary_soa/load_form');
	}
 
    public function load_form() 
    {  
        $data['tenant_history']       	= ''; 
        $data['branchCmb']       		= 0; 
        $data['regionCmb']       		= $this->Model_summary_soa->get_region(); 
        $data['items']['branch_id']     = ''; 
        $data['regionCmb']['region_id'] = ''; 
		$data['action'] 				= 'summary_soa/report_load';
		$this->breadcrumbcomponent->add('Summary SOA Level','summary_soa/load_form');
	    $this->load->view('template/v_header');
		$this->load->view('summary_soa/view_form',$data);
		$this->load->view('template/v_footer');    
    }
  
	
	public function getBranchAjax()
	{
		$region_id 			= empty($_GET['region']) ? '' : $_GET['region'];
		$branch_name 		= empty($_GET['term']) ? '' : $_GET['term'];
		$data['items']      = $this->Model_summary_soa->get_branch($branch_name['term'],$region_id);
		echo json_encode($data);
	}
    

    /**
    * Call Report
    *
    */
    public function report_load() 
    {    
		 
        $year 			= $this->input->post('year');
        $region 		= $this->input->post('region_id_hidden');
		$branch 		= $this->input->post('branch_id_s');
		$branchName 	= $this->input->post('branch_name');
		$startdate = $this->input->post('istartdate');; 
		$enddate = $this->input->post('ienddate');;
		 
		 
		// }  
		
		//echo ($branch);exit;
		$data['action'] 					= 'summary_soa/report_load';
		$data['branch_id'] 					= $branch; 
		$data['sdate'] 					= $startdate; 
		$data['edate'] 					= $enddate; 
		$data['action'] 					= 'summary_soa/report_load';
		$data['items']['branch_id']     	= $branchName; 
		$data['regionCmb']       			= $this->Model_summary_soa->get_region(); 
		$data['branchCmb']['branch_id'] 	= $branch;
		$data['regionCmb']['region_id']		= $region;  
		$data['data_sm_soa']       		= $this->Model_summary_soa->get_data_summary($year,$region,$branch,$startdate,$enddate); 
		$button			= $this->input->post('button');
		$data['year'] = $year;  
		 
	    
		$this->load->view('summary_soa/view_sm_soa',$data);
		//$this->load->view('template/v_footer');     
    } 
	
	public function report_load_detil($month,$typeTrx,$year)
	{
		$data = array();
		$data['data_forecast_detil']= $this->Model_summary_soa->get_data_forecastdetil($month,$typeTrx,$year); 
		$data['month'] = $month;
		$data['year'] = $year;
		$this->load->view('summary_soa/view_forecast_detil',$data);
	}
	
    
	
	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->Model_summary_soa->get_branch_dlg($rSearch['term']);
	    $result['items']= $branch; 
        echo json_encode($result);
    }

	public function getRegionAll()
	{
		$regionCmb['items'] = $this->Model_summary_soa->get_region_dlg(); 
		echo json_encode($regionCmb);
	}
 
}

?>
