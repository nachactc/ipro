<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Smreport extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        $this->load->library('breadcrumbcomponent');
        $this->load->model('model_smprint');

    }
    

	function rptlapaydp(){ 
	$btload=$this->input->post('btload');
	if (isset($btload)){
		$cbsemester=$this->input->post('cbsemester'); 
		$cboyear=$this->input->post('cboyear'); 
		$rowsemester=$this->model_smprint->get_semeterbyid($cbsemester);
		$vsemester=$rowsemester['semester_name'];
	}else{
		$cbsemester=""; 
		$cboyear="";
		$vsemester="";
	}
	$data=array(
			'rsemester'=>$this->model_smprint->get_semeter(),
			'cbsemester'=>$cbsemester,
			'cboyear'=>$cboyear,
			'vsemester'=>$vsemester
		 ); 
	$this->breadcrumbcomponent->add('STATUS INVOICING & PAYMENT DP + SECURITY DEPOSIT','Smreport/Smreport/rptlapaydp');
		$this->load->view('template/v_header');                         
       $this->load->view('smreport/rptlapaydp',$data);
	   $this->load->view('template/v_footer');
       
    }    
	
	function rptloila_new(){ 
	$btload=$this->input->post('btload');
	if (isset($btload)){
		$cbsemester=$this->input->post('cbsemester'); 
		$cboyear=$this->input->post('cboyear'); 
		$rowsemester=$this->model_smprint->get_semeterbyid($cbsemester);
		$vsemester=$rowsemester['semester_name'];
	}else{
		$cbsemester=""; 
		$cboyear="";
		$vsemester="";
	}
	$data=array(
			'rsemester'=>$this->model_smprint->get_semeter(),
			'cbsemester'=>$cbsemester,
			'cboyear'=>$cboyear,
			'vsemester'=>$vsemester
		 ); 
	$this->breadcrumbcomponent->add('STATUS LOI & LEASE AGREEMENT NEW PROPERTY','Smreport/Smreport/rptloila_new');
		$this->load->view('template/v_header');                         
       $this->load->view('smreport/rptloola_new',$data);
	   $this->load->view('template/v_footer');
       
    } 
	
	function rptlatenantnew(){ 
	$btload=$this->input->post('btload');
	if (isset($btload)){
		$cbsemester=$this->input->post('cbsemester'); 
		$cboyear=$this->input->post('cboyear'); 
		$rowsemester=$this->model_smprint->get_semeterbyid($cbsemester);
		$vsemester=$rowsemester['semester_name'];
	}else{
		$cbsemester=""; 
		$cboyear="";
		$vsemester="";
	}
	$data=array(
			'rsemester'=>$this->model_smprint->get_semeter(),
			'cbsemester'=>$cbsemester,
			'cboyear'=>$cboyear,
			'vsemester'=>$vsemester
		 ); 
	$this->breadcrumbcomponent->add('STATUS LOI, LOC & LEASE AGREEMENT   EXISTING PROPERTIES ','rptlatenantnew');
		$this->load->view('template/v_header');                         
       $this->load->view('smreport/rptlastatus',$data);
	   $this->load->view('template/v_footer');
       
    }    
	
	/* function rptloila_new(){ 
	$btload=$this->input->post('btload');
	if (isset($btload)){
		$cbsemester=$this->input->post('cbsemester'); 
		$cboyear=$this->input->post('cboyear'); 
		$rowsemester=$this->model_smprint->get_semeterbyid($cbsemester);
		$vsemester=$rowsemester['semester_name'];
	}else{
		$cbsemester=""; 
		$cboyear="";
		$vsemester="";
	}
	$data=array(
			'rsemester'=>$this->model_smprint->get_semeter(),
			'cbsemester'=>$cbsemester,
			'cboyear'=>$cboyear,
			'vsemester'=>$vsemester
		 ); 
	$this->breadcrumbcomponent->add('STATUS LOI & LEASE AGREEMENT NEW PROPERTY','Smreport/Smreport/rptloila_new');
		$this->load->view('template/v_header');                         
       $this->load->view('smreport/rptloola_new',$data);
	   $this->load->view('template/v_footer');
       
    }  */
	
	
}  