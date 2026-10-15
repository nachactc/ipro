<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 


class Thd extends MX_Controller
{
	 
    public function __construct() 
    {
        parent::__construct();      
				check_user_login();   
				$this->load->model('Thd_model'); 
				$this->load->library('breadcrumbcomponent'); 	
				//$this->load->library('excel');
    }
    
	
	public function tenant_history_data() 
	{  
		$data['tenant_history']       	= ''; 
		$data['branchCmb']       		= 0; 
		$data['regionCmb']       		= $this->Thd_model->get_region(); 
		$data['items']['branch_id']     = ''; 
		$data['regionCmb']['region_id'] = ''; 
		$data['action'] 				= 'thd/report_load2';
		$this->load->view('template/v_header');
		$this->load->view('thd/thd_view',$data);
		$this->load->view('template/v_footer');    
	}
	
	public function getBranchAjax()
	{
		$region_id 			= empty($_GET['region']) ? '' : $_GET['region'];
		$branch_name 		= empty($_GET['term']) ? '' : $_GET['term'];
		$data['items']      = $this->Thd_model->get_branch($branch_name['term'],$region_id);
		echo json_encode($data);
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
         $rptDate	= $this->input->post('rptDate');

         $rptType	= $this->input->post('report_type');
         
         $f_method	= $this->input->post('f_method');

         $criteria = new \stdClass;
      
         IF (!empty($branchID_Hidden))
         {
            $branch = $branchID_Hidden;
         }
         
         $data['branch_id'] 					= $branch; 
         $data['action'] 					= 'thd/report_load2';
         $data['items']['branch_id']     	= $branchName; 
         $data['regionCmb']       			= $this->Thd_model->get_region(); 
         $data['branchCmb']['branch_id'] 	= $branch;
         $data['regionCmb']['region_id']		= $region;  

         //$branch, $regionID_Hidden, $stardate, $enddate
         $criteria->region_id = $regionID_Hidden;
         $criteria->branch_id = $branch;
         $criteria->rptDate = $rptDate;


         if($criteria->rptDate == '' || $criteria->region_id == ''){		
            
            return;
         }	
         
         $data['report_type'] = $rptType;
         $data['report_date'] = $rptDate;
         $data['region_name'] = $regionName_Hidden;
         $data['branch_info']	= $branch != 'kosong' ? $this->Thd_model->get_branch_info($branch) : $regionName_Hidden;
         $data['excel'] = $button;

         if ($button == 'rawData'){

            if ($rptType == 'leasing') {

               $data['report_title'] = 'Permanent Leasing';
               if ($f_method=='baserent') {
                  $data['tenant_history'] = $this->Thd_model->getDataThdLeasing($criteria);   
                  $this->load->view('thd/view_data_leasing',$data);
               }else{
                  $data['tenant_history'] = $this->Thd_model->getDataThdInvoice($criteria);            
                  $this->load->view('thd/view_data_leasing_invoice',$data);
               }
            } elseif($rptType == 'casual') {
   
               $data['report_title'] = 'Casual Leasing';
               $data['tenant_history'] = $this->Thd_model->getDataThdCasual($criteria);
               $this->load->view('thd/view_data_casual',$data);		
            } else {

               $data['report_title'] = 'Tenant Termination';
               $data['tenant_history'] = $this->Thd_model->getDataThdTermination($criteria);
               $this->load->view('thd/view_data_leasing',$data);
            }

         } else {

            if ($f_method === 'baserent') {

                $data['report_title'] = 'THD Summary';
                $data['result'] = $this->Thd_model->getDataThdSummary($criteria);
                $this->load->view('thd/view_data_leasing_summary', $data);
            } else {

                $data['report_title'] = 'THD Invoice Summary';
                $data['result'] = $this->Thd_model->getDataThdInvoiceSummary($criteria);
                $this->load->view('thd/view_data_leasing_summary', $data);
            }
         }
         
         //$this->session->set_flashdata('branch_names', $branchName); 
         //$this->session->set_flashdata('tenant_data', $data['tenant_history'] ); 
         //$data['excel'] = $button;
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
		$branch      = $this->Thd_model->get_branch_dlg($rSearch['term']);
	    $result['items']= $branch; 
        echo json_encode($result);
    }

	public function getRegionAll()
	{
		$regionCmb['items'] = $this->Thd_model->get_region_dlg(); 
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
		$branch_info = $branch != 'kosong' ? $this->Thd_model->get_branch_info($branch) : $regionName_Hidden;
		$data_thd       		= $this->Thd_model->get_data_thd2($branch,$regionID_Hidden); 
		
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