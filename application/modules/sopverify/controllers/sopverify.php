<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sopverify extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_sop_verify');
		$this->load->library('breadcrumbcomponent');
		$this->load->helper(array('form', 'url'));
    }
   
   
    function index(){       
        redirect('schedule_payment/sp_list');
    }

    function approveagreement(){   
			$agreement_id=$this->input->post('agreement_id');
			$username   = $this->session->userdata('username');  
            $this->db->trans_begin();            

            $ag_posting = "EXEC lm03_TrnAgreement_verify '{$agreement_id}', '{$username}' ";
            $this->db->query($ag_posting);    
            //echo $this->db->last_query(); exit;

            if ($this->db->trans_status() === FALSE)
            {               
                $this->db->trans_rollback();
				echo "<script>alert('Fail Verify');</script>";
            }else{
                $this->db->trans_commit();                
            }
			echo "<script>alert('Success Verify');</script>";
          redirect("agreementverify/agreementverify/agreementapplist"); 
     }
public function previewsoppdf(){
	ini_set('max_execution_time',0);
	  $schedule_id =$this->uri->segment(4);
	  $button			= "PREVIEW";

				$data   = array(
                  'resultH'      => $this->model_sop_verify->get_detil_SOP_Header($schedule_id),
				  'result'      => $this->model_sop_verify->get_detil_SOP($schedule_id),
				  'schedule_id'   => $schedule_id,
                  'button'   => $button
               );
	
 //$this->load->view('sopverify/rptsop', $data);
		$this->load->view('template/v_header');
       $this->load->view('sopverify/soplist', $data);
        $this->load->view('template/v_footer');
   





    }	
	
    
    
}  