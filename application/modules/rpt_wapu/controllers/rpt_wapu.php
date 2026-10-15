<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rpt_wapu extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_wapu'); 
		$this->load->library('breadcrumbcomponent');
		$this->load->helper(array('form', 'url'));
    }
    
	 
	function index(){       
        redirect('rpt_wapu/wapu_list');
    }
  
    function wapu_list(){
        		
		$this->breadcrumbcomponent->add('Report Wapu','rpt_wapu/wapu_list'); 
		//$data['agrType'] = $this->Agr_select();
		//$data['GroupTenantType'] = $this->GroupTenant_select();
		//$data['GradeProperty'] = $this->PropertyGrade_select();
		$data = array();
   
        $this->load->view('template/v_header');
        $this->load->view('rpt_wapu/wapu_list',$data);
        $this->load->view('template/v_footer');
    }
	 
   
    function Agr_select(){ 
        
        $hasil     = $this->model_wapu->get_AgrGroup();
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
        
        $hasil     = $this->model_wapu->get_GroupTenant();
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
        
        $hasil     = $this->model_wapu->get_PropertGrade();
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
		
		$bln = $this->input->post('bln');
		$thn = $this->input->post('tahun');
		$acc_id = $this->input->post('acc_id');
		$region_id = $this->input->post('region_ids'); 
		$branch_id = $this->input->post('branch_id');
		$rekanan_id = $this->input->post('rekanan_id');
		$rekananshipping_line = $this->input->post('rekananshipping_id');
		$advance =  $this->input->post('advance');
		//echo $incl_ppn;exit;
		
		$txtSearchCriteria = ''; 
		
		$periode = $thn.$bln;
		
	 
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
				$txtSearchCriteria = " b.region_id = '$region_id'";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  b.region_id = '$region_id' ";
			}
		}
		
		
		if($branch_id <> 0)
		{
			
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "b.branch_id = '$branch_id'";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND b.branch_id = '$branch_id' ";
			}
			
		}
		
		if($rekanan_id <> 0)
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "b.rekanan_id = '$rekanan_id'";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  b.rekanan_id = '$rekanan_id' ";
			}
		}
		if($rekananshipping_line <> 0 )
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = " b.rekananshipping_line = '$rekananshipping_line'";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria."  AND b.rekananshipping_line = '$rekananshipping_line' ";
			}
		}
		if($acc_id <> 0 )
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "b.acc_id = '$acc_id' ";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  b.acc_id = '$acc_id' ";
			}
		}
		if($periode <> '' )
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "b.periode_id, = '$periode' ";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  b.periode_id = '$periode' ";
			}
		}
		
		 
		$criteria=$txtSearchCriteria;
		//echo var_dump($_POST);exit;
		//echo ($criteria);exit;
		
		 
		
		$report_type = $this->input->post('report_type');
		$channel_id = '';
		$reportView = '';
		//echo $report_type;
		// switch($report_type)
		// {
			// case 'detil_bytype':
				$data['result'] = $this->model_wapu->get_Reportwapu($region_id,$criteria,$bln,$thn);
				$reportView = 'rpt_wapu/report_list';
				$data['title'] = 'Wapu Summary';
			// break;
			 
			
		// }
		$this->load->view($reportView,$data);
		
    }
	 
	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_wapu->get_branch_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function acc_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_wapu->get_acc_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function region_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_wapu->get_region_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function rekanan_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_wapu->get_rekanan_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function rekananshipping_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_wapu->get_rekananshipping_dlg($rSearch['term']);
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