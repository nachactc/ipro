<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 


class Paymenttype_report extends MX_Controller
{
	 
    public function __construct() 
    {
        parent::__construct();      
		check_user_login();   
        $this->load->model('Model_paymenttype_report'); 
		$this->load->library('breadcrumbcomponent'); 	
		//$this->load->library('excel');
    }
    
	public function index()
	{
		redirect('paymenttype_report/load_form');
	}
 
    public function load_form() 
    {  
        $data['tenant_history']       	= ''; 
        $data['branchCmb']       		= 0; 
        $data['regionCmb']       		= $this->Model_paymenttype_report->get_region(); 
        $data['items']['branch_id']     = ''; 
        $data['regionCmb']['region_id'] = ''; 
		$data['action'] 				= 'paymenttype_report/report_load';
		$this->breadcrumbcomponent->add('Payment By Tenant By Mall','paymenttype_report/load_form');
	    $this->load->view('template/v_header');
		$this->load->view('paymenttype_report/view_form',$data);
		$this->load->view('template/v_footer');    
    }
  
	
	public function getBranchAjax()
	{
		$region_id 			= empty($_GET['region']) ? '' : $_GET['region'];
		$branch_name 		= empty($_GET['term']) ? '' : $_GET['term'];
		$data['items']      = $this->Model_paymenttype_report->get_branch($branch_name['term'],$region_id);
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
		$startdate 		= $this->input->post('istartdate'); 
		$enddate 		= $this->input->post('ienddate');
		$reporttype     = $this->input->post('typereport');
		
		 
		 
		// }  
		
		//echo ($branch);exit;
		$data['action'] 					= 'paymenttype_report/report_load';
		$data['branch_id'] 					= $branch; 
		$data['sdate'] 					    = $startdate; 
		$data['edate'] 					    = $enddate; 
		$data['action'] 					= 'paymenttype_report/report_load';
		$data['items']['branch_id']     	= $branchName; 
		$data['regionCmb']       			= $this->Model_paymenttype_report->get_region(); 
		$data['branchCmb']['branch_id'] 	= $branch;
		$data['regionCmb']['region_id']		= $region;  
		$data['region_nm']	= $this->input->post('region_name_hidden');  
		$button			= $this->input->post('button');
		$data['year'] = $year;  
		$buttonexc = $this->input->post('button');
		$data['button'] = $buttonexc;
		$data['rekanan_line']	= $this->input->post('rekanan_line');  
		$rekananshipping_line = $data['rekanan_line'];
		if($reporttype == 1)
		{
			$data['data_sm_soa']       		= $this->Model_paymenttype_report->get_data_summary($year,$region,$branch,$startdate,$enddate); 
			$this->load->view('paymenttype_report/view_report',$data);
		}
		else
		{
			$rekananid     = $this->input->post('rekanan_id');
			$rekananname   = $this->input->post('rekanan_names');
			$data['data_detil']       		= $this->Model_paymenttype_report->get_data_detil($year,$region,$branch,$startdate,$enddate,$rekananid,$rekananshipping_line); 
			$data['branch_nm'] = $branchName;
			$data['rekanan_name'] = $rekananname;
			$this->load->view('paymenttype_report/view_report_detil',$data);
		}
		
		 
	    
		
		//$this->load->view('template/v_footer');     
    } 
	
	public function report_load_detil($month,$typeTrx,$year)
	{
		$data = array();
		$data['data_forecast_detil']= $this->Model_paymenttype_report->get_data_forecastdetil($month,$typeTrx,$year); 
		$data['month'] = $month;
		$data['year'] = $year;
		$this->load->view('paymenttype_report/view_forecast_detil',$data);
	}
	
    
	
	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->Model_paymenttype_report->get_branch_dlg($rSearch['term']);
	    $result['items']= $branch; 
        echo json_encode($result);
    }
	
	function rekanan_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$rekanan      = $this->Model_paymenttype_report->get_rekananshipping_dlg($rSearch['term']);
	    $result['items']= $rekanan; 
        echo json_encode($result);
    }

	public function getRegionAll()
	{
		$regionCmb['items'] = $this->Model_paymenttype_report->get_region_dlg(); 
		echo json_encode($regionCmb);
	}
 
}

?>
