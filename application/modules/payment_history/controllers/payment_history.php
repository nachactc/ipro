<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 


class payment_history extends MX_Controller
{
	 
    public function __construct() 
    {
        parent::__construct();      
		check_user_login();   
        $this->load->model('Model_payment_history'); 
		$this->load->library('breadcrumbcomponent'); 	
		//$this->load->library('excel');
    }
    
 
    public function payment() 
    {  
        $data['tenant_history']       	= ''; 
        $data['branchCmb']       		= 0; 
        $data['regionCmb']       		= $this->Model_payment_history->get_region(); 
        $data['items']['branch_id']     = ''; 
        $data['regionCmb']['region_id'] = ''; 
		$data['action'] 				= 'payment_history/report_load2';
	    $this->load->view('template/v_header');
		$this->load->view('payment_history/view_2',$data);
		$this->load->view('template/v_footer');    
    }
 
    public function tenant_thd_summary() 
    {  
        $data['tenant_history']       	= ''; 
        $data['branchCmb']       		= 0; 
        $data['regionCmb']       		= $this->Model_tenant_history->get_region(); 
        $data['items']['branch_id']     = ''; 
        $data['regionCmb']['region_id'] = ''; 
		$data['action'] 				= 'tenant_history/report_load_summary';
	    $this->load->view('template/v_header');
		$this->load->view('tenant_history/view_summary',$data);
		$this->load->view('template/v_footer');    
    }
	
	public function tenant_history_data() 
	{  
		$data['tenant_history']       	= ''; 
		$data['branchCmb']       		= 0; 
		$data['regionCmb']       		= $this->Model_payment_history->get_region(); 
		$data['items']['branch_id']     = ''; 
		$data['regionCmb']['region_id'] = ''; 
		$data['action'] 				= 'tenant_history/report_load2';
		$this->load->view('template/v_header');
		$this->load->view('tenant_history/view_2',$data);
		$this->load->view('template/v_footer');    
	}
	
	public function getBranchAjax()
	{
		$region_id 			= empty($_GET['region']) ? '' : $_GET['region'];
		$branch_name 		= empty($_GET['term']) ? '' : $_GET['term'];
		$data['items']      = $this->Model_payment_history->get_branch($branch_name['term'],$region_id);
		echo json_encode($data);
	}
    

    /**
    * Call Report
    *
    */
    public function report_load() 
    {    
		 
        $region 		= $this->input->post('region_id');
		$branch 		= $this->input->post('branch_id');
		$branchName 	= $this->input->post('branch_name');
		$branchID_Hidden 	= $this->input->post('branch_id_hidden'); 
		IF (!empty($branchID_Hidden))
		{
			$branch = $branchID_Hidden;
		}
		
		$data['action'] 					= 'tenant_history/report_load';
		$data['branch_id'] 					= $branch; 
		$data['action'] 					= 'tenant_history/report_load';
		$data['items']['branch_id']     	= $branchName; 
		$data['regionCmb']       			= $this->Model_payment_history->get_region(); 
		$data['branchCmb']['branch_id'] 	= $branch;
		$data['regionCmb']['region_id']		= $region;  
		$data['tenant_history']       		= $this->Model_payment_history->get_data_payment($region,$branch);
		$datas_tenant_thd		 			= $data['tenant_history'] ;
		$button			= $this->input->post('button');
		$data['excel'] = $button;  
		
		$this->session->set_flashdata('branch_names', $branchName); 
		$this->session->set_flashdata('tenant_data', $data['tenant_history'] ); 
		
	    $this->load->view('template/v_header');
		$this->load->view('payment_history/view',$data);
		$this->load->view('template/v_footer');     
    } 
	
    /**
    * Call Report
    *
    */
    public function report_load2() 
    {       
        $region 		= $this->input->post('cboregionDlg'); 
		$branch 		= $this->input->post('branch_id_s');
		$branchName 	= $this->input->post('branch_name');
		$button			= $this->input->post('button');
		$branchID_Hidden 	= $this->input->post('branch_id_hidden'); 
		$regionID_Hidden 	= $this->input->post('region_id_hidden'); 
		$regionName_Hidden 	= $this->input->post('region_name_hidden'); 
		 
		IF (!empty($branchID_Hidden))
		{
			$branch = $branchID_Hidden;
		}
		 
		$data['branch_id'] 					= $branch; 
		$data['action'] 					= 'tenant_history/report_load2';
		$data['items']['branch_id']     	= $branchName; 
		$data['regionCmb']       			= $this->Model_payment_history->get_region(); 
		$data['branchCmb']['branch_id'] 	= $branch;
		$data['regionCmb']['region_id']		= $region;  
		
		 
		$data['tenant_history']       		= $this->Model_payment_history->get_data_payment($branch,$regionID_Hidden); 
		 
		
		$data['branch_info']				= $branch != 'kosong' ?$this->Model_payment_history->get_branch_info($branch) : $regionName_Hidden;
		$datas_tenant_thd		 			= $data['tenant_history'] ;
		$data['region_name']				= $regionName_Hidden;
		$this->session->set_flashdata('branch_names', $branchName); 
		$this->session->set_flashdata('tenant_data', $data['tenant_history'] ); 
		$data['excel'] = $button;
		 
		 
		$this->load->view('payment_history/view_data_detil_2',$data); 
		   
    } 
	
    /**
    * Call Report Summary
    *
    */
    public function report_load_summary() 
    {       
        $region 		= $this->input->post('cboregionDlg'); 
		$branch 		= $this->input->post('branch_id_s');
		$branchName 	= $this->input->post('branch_name'); 
		$branchID_Hidden 	= $this->input->post('branch_id_hidden'); 
		$regionID_Hidden 	= $this->input->post('region_id_hidden'); 
		$regionName_Hidden 	= $this->input->post('region_name_hidden');
		
		 
		IF (!empty($branchID_Hidden))
		{
			$branch = $branchID_Hidden;
		}
		
		 
		$data['action'] 					= 'tenant_history/report_load_summary';
		$data['branch_id'] 					= $branch; 
		$data['items']['branch_id']     	= $branchName; 
		$data['regionCmb']       			= $this->Model_tenant_history->get_region(); 
		$data['branchCmb']['branch_id'] 	= $branch;
		$data['regionCmb']['region_id']		= $region;  
		$data['tenant_history']       		= $this->Model_tenant_history->get_data_thd_summary($region,$branch);   
		$data['region_name']				= $regionName_Hidden;
		
		$this->session->set_flashdata('branch_names_s', $branchName); 
		$this->session->set_flashdata('tenant_data_s', $data['tenant_history'] ); 
		
	    $this->load->view('template/v_header');
		$this->load->view('tenant_history/view_summary',$data);
		$this->load->view('template/v_footer');     
    } 
	
	/**
    * Call Report EXCEL
    *
    */
    public function report_load_excel() 
    {       
        $branch_names = $this->session->flashdata('branch_names'); 
        $tenant_datas = $this->session->flashdata('tenant_data'); 
		$data['title']						= $branch_names.'_'.date("Y-m-d"); 
		//echo $data['title']	;
		$data['tenant_history']       		= $tenant_datas;    
		$this->load->view('tenant_history/view_excel',$data); 
    } 
	
	/**
    * Call Report EXCEL
    *
    */
    public function report_load_excel2() 
    {       
        $branch_names = $this->session->flashdata('branch_names'); 
        $tenant_datas = $this->session->flashdata('tenant_data'); 
		$data['title']						= $branch_names.'_'.date("Y-m-d"); 
		//echo $data['title']	;
		$data['tenant_history']       		= $tenant_datas;    
		$this->load->view('tenant_history/view_excel_2',$data); 
    } 
	
	/**
    * Call Report Summary EXCEL
    *
    */
    public function report_load_excel_summary() 
    {       
        $branch_names = $this->session->flashdata('branch_names_s'); 
        $tenant_datas = $this->session->flashdata('tenant_data_s'); 
		$data['title']						= $branch_names.'_Summary_'.date("Y-m-d"); 
		//echo $data['title']	;
		$data['tenant_history']       		= $tenant_datas;    
		$this->load->view('tenant_history/view_excel_summary',$data); 
    } 
	
	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->Model_payment_history->get_branch_dlg($rSearch['term']);
	    $result['items']= $branch; 
        echo json_encode($result);
    }

	public function getRegionAll()
	{
		$regionCmb['items'] = $this->Model_payment_history->get_region_dlg(); 
		echo json_encode($regionCmb);
	}

	public function export_to_excel_detail()
	{
		$fileName = 'DetailIpro-'.time().'.xlsx';

		$region 		= $this->input->post('cboregionDlg'); 
		$branch 		= $this->input->post('branch_id_s');
		$branchName 	= $this->input->post('branch_name');
		$button			= $this->input->post('button');
		$branchID_Hidden 	= $this->input->post('branch_id_hidden'); 
		$regionID_Hidden 	= $this->input->post('region_id_hidden'); 
		$regionName_Hidden 	= $this->input->post('region_name_hidden'); 
		 
		IF (!empty($branchID_Hidden))
		{
			$branch = $branchID_Hidden;
		}
		$branch_info = $branch != 'kosong' ? $this->Model_tenant_history->get_branch_info($branch) : $regionName_Hidden;
		$data_thd       		= $this->Model_tenant_history->get_data_thd2($branch,$regionID_Hidden); 
		
		//excel
		$objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
		
		// set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', ($branch_info != 'kosong') ? $branch_info->region_namereport : '');
        $objPHPExcel->getActiveSheet()->SetCellValue('A3', 'DATA '.($branch_info != 'kosong') ? ' TENANT '.$branch_info->branch_name : $region_name);
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'DOB');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Contact_No');    
		
		
	}
}

?>
