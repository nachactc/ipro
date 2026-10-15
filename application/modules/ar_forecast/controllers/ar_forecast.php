<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 


class ar_forecast extends MX_Controller
{
	 
    public function __construct() 
    {
        parent::__construct();      
		check_user_login();   
        $this->load->model('Model_ar_forecast'); 
		$this->load->library('breadcrumbcomponent'); 	
		//$this->load->library('excel');
    }
    
	public function index()
	{
		redirect('ar_forecast/load_forecast');
	}
 
    public function load_forecast() 
    {  
        $data['tenant_history']       	= ''; 
        $data['branchCmb']       		= 0; 
        $data['regionCmb']       		= $this->Model_ar_forecast->get_region(); 
        $data['items']['branch_id']     = ''; 
        $data['regionCmb']['region_id'] = ''; 
		$data['action'] 				= 'ar_forecast/report_load';
		$this->breadcrumbcomponent->add('A/R Forecast','ar_forecast/load_forecast');
	    $this->load->view('template/v_header');
		$this->load->view('ar_forecast/view_form',$data);
		$this->load->view('template/v_footer');    
    }
  
	
	public function getBranchAjax()
	{
		$region_id 			= empty($_GET['region']) ? '' : $_GET['region'];
		$branch_name 		= empty($_GET['term']) ? '' : $_GET['term'];
		$data['items']      = $this->Model_ar_forecast->get_branch($branch_name['term'],$region_id);
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
		 
		$criteria = '';
		if($region != '' && $branch == '')
		{
			$criteria = "b.region_id = ''$region'' ";
			
		} 
		if($region == '' && $branch != '')
		{
			$criteria = "b.branch_id = ''$branch'' ";
			
		} 
		if($region != '' && $branch != '')
		{
			$criteria = " AND b.region_id = ''$region'' AND b.branch_id = ''$branch'' ";
			
		}  
		
		//echo ($branch);exit;
		$data['action'] 					= 'ar_forecast/report_load';
		$data['branch_id'] 					= $branch; 
		$data['action'] 					= 'ar_forecast/report_load';
		$data['items']['branch_id']     	= $branchName; 
		$data['regionCmb']       			= $this->Model_ar_forecast->get_region(); 
		$data['branchCmb']['branch_id'] 	= $branch;
		$data['regionCmb']['region_id']		= $region;  
		$data['data_forecast']       		= $this->Model_ar_forecast->get_data_forecast($year,$criteria); 
		$button			= $this->input->post('button');
		$data['excel'] = $button;  
		 
	    //$this->load->view('template/v_header');
		$this->load->view('ar_forecast/view_forecast',$data);
		//$this->load->view('template/v_footer');     
    } 
	
	public function report_load_detil($month,$typeTrx,$year)
	{
		$data = array();
		$data['data_forecast_detil']= $this->Model_ar_forecast->get_data_forecastdetil($month,$typeTrx,$year); 
		$data['month'] = $month;
		$data['year'] = $year;
		$this->load->view('ar_forecast/view_forecast_detil',$data);
	}
	
    
	
	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->Model_ar_forecast->get_branch_dlg($rSearch['term']);
	    $result['items']= $branch; 
        echo json_encode($result);
    }

	public function getRegionAll()
	{
		$regionCmb['items'] = $this->Model_ar_forecast->get_region_dlg(); 
		echo json_encode($regionCmb);
	}
 
}

?>
