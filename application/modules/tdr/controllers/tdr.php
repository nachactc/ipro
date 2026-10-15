<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tdr extends CI_Controller{
    
  function __construct(){
      
      parent::__construct();        
      // Check login and make sure email has been verified
      check_user_login();
      $this->load->library('table');
      $this->load->model('model_tdr');
      $this->load->library('breadcrumbcomponent');
      $this->load->helper(array('form', 'url'));
  }    	
	
	function index(){       
      redirect('tdr/tdr_list');
  }   		       	    

  function tdr_list(){
          
      $this->breadcrumbcomponent->add('Transaction Detail Report By Account DI/SD','tdr/tdr_list'); 
      //$data['agrType'] = $this->Agr_select();    
      $data['region'] = $this->region_select();

      $this->load->view('template/v_header');
      $this->load->view('tdr/tdr_list',$data);
      $this->load->view('template/v_footer');
  }
  
  function region_select(){     

      $hasil     = $this->model_tdr->get_region();
      //$options    = array('0' => 'Select an Option');                
      
      if($hasil != 'kosong'){
          foreach($hasil as $key => $value){
          $options[''] = '';
              $options[$value->region_id]= $value->region_name;
          }
      }
      else
      {
        $options[''] = '';
      }
                  
      //print_r($options); exit;
      return $options;
	}
   
  function Agr_select(){ 
      
      $hasil     = $this->model_deffered->get_AgrGroup();
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
   
    function report_load()
    {
        $BEG_BAL_DATE = '2019-12-01'; /** Beginning Balance IPRO **/

        $array_items = array('enddate', 'startdate', 'criteria'); 
        $this->session->unset_userdata($array_items);
        $startdate = $this->input->post('startdate') != '' ? date('Y-m-d',strtotime($this->input->post('startdate'))) : $BEG_BAL_DATE;        
        $enddate = $this->input->post('enddate') != '' ? date('Y-m-d',strtotime($this->input->post('enddate'))) :  date('Y-m-d')  ;        
        $region_id = $this->input->post('region_ids'); 
        $groupacc_select = $this->input->post('groupacc_select'); 

        // echo $incl_ppn;exit;
        $txtSearchCriteria = ' 1 = 1 ';									
		
        if($region_id <> 0)
        {
            if($txtSearchCriteria == '')
            {
              $txtSearchCriteria = "A.region_id = '{$region_id}'";
            }
            else
            {
              $txtSearchCriteria = $txtSearchCriteria." AND  A.region_id = '{$region_id}' ";
            }
        }

        if($groupacc_select != '')
        {
          switch($groupacc_select)
          {
            case 'DEPOSIT':
              $txtSearchGroupAcc = " LEFT(A.acc_id,3) = '204' ";
              $title = 'Deposit';
              break;
            case 'DEFERRED':
              $txtSearchGroupAcc = " LEFT(A.acc_id,3) = '203' ";
              $title = 'Deferred';
              break;            
            default:
              $txtSearchGroupAcc = " ";
          }              

          if($txtSearchCriteria == '')
          {
              $txtSearchCriteria = $txtSearchGroupAcc;
          }else{
              $txtSearchCriteria = $txtSearchCriteria." AND ".$txtSearchGroupAcc;
          }
        }
        	
        $criteria = $txtSearchCriteria;        
        //echo var_dump($_POST);exit;				
        
        //$data['depositAcc'] = $acc_deposit;
        $data['startdate'] = $startdate;
        $data['enddate'] = $enddate;
				$data['region_id'] = $region_id;
        // echo $agingdate,$startdate,$paymentdate,$criteria;
        $data['result'] = $this->model_tdr->get_Data($BEG_BAL_DATE, $startdate, $enddate, $criteria);        
        $reportView = 'tdr/tdr_report';
        $data['title'] = 'Transaction Detail '.$title.' Report';
        //$methodModel_name = 'get_ReportAging';

        $this->load->view($reportView,$data);
      /*
      $data['agingdate'] = $agingdate;
      $data['startdate'] = $startdate;
      $data['paymentdate'] = $paymentdate;
      $data['criteria'] = $criteria;
      $newdata = array(
            'agingdate'  => $agingdate,
            'startdate'     =>$startdate,
            'paymentdate' => $paymentdate,
            'criteria' => $criteria,
            'depositAcc' => $acc_deposit,
            'methodModel_name' => $methodModel_name
        ); 
        
      $this->session->set_userdata($newdata);
      */
  }			

}  