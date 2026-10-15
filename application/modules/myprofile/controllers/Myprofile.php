<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myprofile extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login(); 
        $this->load->model('model_query'); 
		$this->load->library('breadcrumbcomponent');
    } 
	
	function index(){       
        redirect('myprofile/profile');
    }
 
	function profile(){ 
		 
		$data = array();
		$data['user'] = $this->model_query->get_data();
		$data['pesan'] = '';
		$data['logout'] = '';
		$this->load->view('template/v_header');
		$this->load->view('myprofile/profile',$data);
		$this->load->view('template/v_footer');
	}
	
	function saveprofile(){
		$data = array();
		$data['user'] = $this->model_query->get_data();
		$data['pesan'] = '';
		$data['logout'] = '';
		if(!empty($this->input->post('chgPwd')) || !empty($this->input->post('user_fullname')))
		{
			$save = $this->model_query->save_data(); 
			if($save){
				$data['pesan'] = 'password has been changed';
				$data['logout'] = 'logout';
			}else{
				$data['pesan'] = 'change password error';
			}	
		}
		
		$data['user'] = $this->model_query->get_data();
		$this->load->view('template/v_header');
		$this->load->view('myprofile/profile',$data);
		$this->load->view('template/v_footer');
	}
}  