<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Semester extends MX_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        $this->load->model('model_semester');
		$this->load->library('breadcrumbcomponent'); 		
    }
     
	 
    public function index() 
    {
        $config = array(
            'base_url'          => site_url('semester/index/'),
            'total_rows'        => $this->model_semester->count_all(),
            'per_page'          => $this->config->item('per_page'),
            'uri_segment'       => 3,
            'num_links'         => 9,
            'use_page_numbers'  => FALSE
            
        );
         
        $this->pagination->initialize($config);
        $data['total']          = $config['total_rows'];
        $data['pagination']     = $this->pagination->create_links();
        $data['number']         = (int)$this->uri->segment(3) +1;
        $data['semester']       = $this->model_semester->get_all($config['per_page'], $this->uri->segment(3));
        	$this->load->view('template/v_header');
			$this->load->view('semester/view',$data);
			$this->load->view('template/v_footer');
	      
    }

     
    public function add() 
    {       
        $data['semester'] = $this->model_semester->add();
        $data['action']  = 'semester/save'; 
        $data['branch'] = $this->model_semester->get_branch(); 
        $data['get_semester'] = $this->model_semester->get_semester(); 
        $data['get_groupbranch'] = $this->model_semester->get_groupbranch(); 
		
		$data['tab'] = 'input';
		
		$this->load->view('template/v_header');
		$this->load->view('semester/form',$data);
		$this->load->view('template/v_footer');

    }

     
    public function edit($id='',$branch_id='') 
    {
        if ($id != '' && $branch_id != '') 
        {

            $data['semester']       = $this->model_semester->get_one($id,$branch_id); 
            $data['action']         = 'semester/save/' . $id . '/' . $branch_id;  
			$data['branch'] 		= $this->model_semester->get_branch();  
			$data['get_semester'] = $this->model_semester->get_semester(); 
			$data['get_groupbranch'] = $this->model_semester->get_groupbranch(); 
			$data['tab'] = 'edit';
			$this->load->view('template/v_header');
			$this->load->view('semester/form',$data);
			$this->load->view('template/v_footer');
			
            
        }
        else 
        {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
			echo "<script>alert('Pilih Data Dulu!')</script>";
			echo "<script>setTimeout(\"location.href = '".site_url('semester')."';\",10);</script>";
            
        }
    }


     
    public function save($id =NULL , $branch_id = NULL) 
    {
      
        // if id NULL then add new data
        if(!$id && !$branch_id)
        {    
                  
                      if ($this->input->post()) 
                      {  
                          $this->model_semester->save();
                          $this->session->set_flashdata('message', 'Data berhasil di simpan');
                          redirect('semester');
                      } 
					  else // If validation incorrect 
					  {
						  $this->add();
					  }
         }
         else // Update data if Form Edit send Post and ID available
         {               
                
                    if ($this->input->post()) 
                    {
                        $this->model_semester->update($id,$branch_id);
                        $this->session->set_flashdata('message', 'Data berhasil di update');
                        redirect('semester');
                    } 
					else // If validation incorrect 
					{
						$this->edit($id);
					}
         }
    }

    
    
       
    public function search()
    {
        if($this->input->post('q'))
        {
            $keyword = $this->input->post('q');
            
			
            $this->session->set_userdata(
                        array('keyword' => $this->input->post('q',TRUE))
                    );
        }
        
         $config = array(
            'base_url'          => site_url('semester/search/'),
            'total_rows'        => $this->model_semester->count_all_search(),
            'per_page'          => $this->config->item('per_page'),
            'uri_segment'       => 3,
            'num_links'         => 9,
            'use_page_numbers'  => FALSE
        );
        
        $this->pagination->initialize($config);
        $data['total']          = $config['total_rows'];
        $data['number']         = (int)$this->uri->segment(3) +1;
        $data['pagination']     = $this->pagination->create_links();
         $data['semester']       = $this->model_semester->get_search($config['per_page'], $this->uri->segment(3));
       
		$this->load->view('template/v_header');
	    $this->load->view('semester/view',$data);
        $this->load->view('template/v_footer');
		
		
		$this->session->unset_userdata('keyword');
		
    }
    
     
    public function destroy($id,$branch_id) 
    {        
        if ($id) 
        {
            $this->model_semester->destroy($id,$branch_id);           
             $this->session->set_flashdata('message', 'Data berhasil di hapus');
             redirect('semester');
        } 
        else 
        {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect('semester');
        }       
    }
}  