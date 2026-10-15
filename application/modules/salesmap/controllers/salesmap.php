<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salesmap extends CI_Controller{
    
    function __construct(){ 
		parent::__construct(); 
		// Check login and make sure email has been verified
		check_user_login();
		
		$this->load->model('model_map');       
		$this->load->library('breadcrumbcomponent');
    }
    
	function index(){
		redirect('salesmap/showmap/0/0000100');
	}
    function showmap(){    
	$lantai=$this->uri->segment(3);
	$branchid=$this->uri->segment(4);
	$rowmap=$this->model_map->get_mapimage($lantai,$branchid);
	$rlantai=$this->model_map->get_floorname($lantai);
	$rowbranchname=$this->model_map->get_branchname($branchid);
	$rowbranchname=$rowbranchname['branch_name'];
	$this->breadcrumbcomponent->add($rowbranchname.' '.$rlantai['lantai_name'],'loo_cl/penalist');
	
			$data=array(
                  'result'=>$this->model_map->qry_showunit($lantai,$branchid),
				  'vfile'=>$rowmap['map_filename'],
				  'vwidth'=>$rowmap['map_filew'],
				  'vheight'=>$rowmap['map_fileh'],
				  'branchid'=>$branchid,
				  'lantainame'=>$rlantai['lantai_name'],			  
            );   
        $this->load->view('template/v_header');
        $this->load->view('salesmap/v_salesmap',$data);
        $this->load->view('template/v_footer');
    }
   
}  