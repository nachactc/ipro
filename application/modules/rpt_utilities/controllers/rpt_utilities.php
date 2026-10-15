<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rpt_utilities extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_utilities'); 
		$this->load->library('breadcrumbcomponent');
		$this->load->helper(array('form', 'url'));
    }
     
	function index(){       
        redirect('rpt_utilities/utilities_list');
    }
  
    function utilities_list(){
        		
		$this->breadcrumbcomponent->add('Report Utilities','rpt_utilities/income_list'); 
		//$data['agrType'] = $this->Agr_select();
		//$data['GroupTenantType'] = $this->GroupTenant_select();
		//$data['GradeProperty'] = $this->PropertyGrade_select();
		$data = array();
   
        $this->load->view('template/v_header');
        $this->load->view('rpt_utilities/list',$data);
        $this->load->view('template/v_footer');
    }
	  
    function Agr_select(){ 
        
        $hasil     = $this->model_utilities->get_AgrGroup();
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
        
        $hasil     = $this->model_utilities->get_GroupTenant();
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
        
        $hasil     = $this->model_utilities->get_PropertGrade();
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
		
		$startdate = $this->input->post('startdate');
		$enddate = $this->input->post('enddate');

		$acc_id = $this->input->post('acc_id');
		$region_id = $this->input->post('region_ids'); 
		$branch_id = $this->input->post('branch_id');
		$rekanan_id = $this->input->post('rekanan_id');
		$rekananshipping_line = $this->input->post('rekananshipping_id');
		$advance =  $this->input->post('advance');
		//echo $incl_ppn;exit;
		
		$txtSearchCriteria = '';	 
		//$startdate = date_format(date_create_from_format("d/m/Y", $startdate), 'Y-m-d');
		$startdate = \DateTime::createFromFormat('d/m/Y', $startdate)->format('Y-m-d');
		$enddate = \DateTime::createFromFormat('d/m/Y', $enddate)->format('Y-m-d');

		
		if($advance != '')
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = $advance;
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND $advance ";
			}
		}
		
		
		if($region_id <> 0)
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = " AD.region_id = ''$region_id''";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  AD.region_id = ''$region_id'' ";
			}
		}
		
		
		if($branch_id <> 0)
		{
			
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "AD.branch_id = ''$branch_id''";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND AD.branch_id = ''$branch_id'' ";
			}
			
		}
		
		if($rekanan_id <> 0)
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "A.rekanan_id = ''$rekanan_id''";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  A.rekanan_id = ''$rekanan_id'' ";
			}
		}
		if($rekananshipping_line <> 0 )
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = " A.rekananshipping_line = ''$rekananshipping_line'' ";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria."  AND A.rekananshipping_line = ''$rekananshipping_line'' ";
			}
		}
		if($acc_id <> 0 )
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "a.acc_id = ''$acc_id'' ";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  a.acc_id = ''$acc_id'' ";
			}
		}
		
			
		
		 
		$criteria=$txtSearchCriteria;
		//echo var_dump($_POST);exit;
		//var_dump ($criteria);exit;
		
		 
		
		$report_type = $this->input->post('report_type');
		$channel_id = '';
		$reportView = '';
		$criteriaAwal = '';
		//echo $report_type;
		switch($report_type)
		{
			case 'u_listrik':
				if($criteria == '')
				{
					$criteria = " AD.utilitieslistrik_date >= ''${startdate}'' AND AD.utilitieslistrik_date <= ''${enddate}'' ";
				}
				else
				{
					$criteria = $criteria." AND AD.utilitieslistrik_date >= ''${startdate}'' AND AD.utilitieslistrik_date <= ''${enddate}'' ";
				}
				$criteriaAwal = 'UL#AND '.$criteria;
				$data['result'] = $this->model_utilities->get_Report($criteriaAwal);
				$reportView = 'rpt_utilities/rpt_listrik';
				$data['title'] = 'Utilities';
			break;
			case 'u_air':
				if($criteria == '')
				{
					$criteria = " AD.utilitiesairgas_date >= ''${startdate}'' AND AD.utilitiesairgas_date <= ''${enddate}'' ";
				}
				else
				{
					$criteria = $criteria." AND AD.utilitiesairgas_date >= ''${startdate}'' AND AD.utilitiesairgas_date <= ''${enddate}'' ";
				}
				$criteriaAwal = 'UA#AND '.$criteria;
				$data['result'] = $this->model_utilities->get_Report($criteriaAwal);
				$reportView = 'rpt_utilities/rpt_air';
				$data['title'] = 'Utilities';
			break;
			case 'u_gas':
				if($criteria == '')
				{
					$criteria = " AD.utilitiesairgas_date >= ''${startdate}'' AND AD.utilitiesairgas_date <= ''${enddate}'' ";
				}
				else
				{
					$criteria = $criteria." AND AD.utilitiesairgas_date >= ''${startdate}'' AND AD.utilitiesairgas_date <= ''${enddate}'' ";
				}
				$criteriaAwal = 'UG#AND '.$criteria;
				$data['result'] = $this->model_utilities->get_Report($criteriaAwal);
				$reportView = 'rpt_utilities/rpt_gas';
				$data['title'] = 'Utilities';
			break;
			 
			
		}
		// echo "<pre/>";
		// echo var_dump($data['result']);
		// exit;
		$this->load->view($reportView,$data);
		
    }
	 
	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_utilities->get_branch_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function acc_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_utilities->get_acc_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function region_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_utilities->get_region_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function rekanan_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_utilities->get_rekanan_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function rekananshipping_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_utilities->get_rekananshipping_dlg($rSearch['term']);
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
  
}  