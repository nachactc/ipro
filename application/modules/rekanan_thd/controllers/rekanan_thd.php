<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 


class Rekanan_thd extends MX_Controller
{

    public function __construct() 
    {
        parent::__construct(); 
		check_user_login();        
        $this->load->model('rekanan_thd_model');  
		$this->load->library('breadcrumbcomponent'); 
		$this->breadcrumbcomponent->add('Rekanan THD','rekanan_thd');
    }    

    /**
    * List all data rekanan_utilities
    *
    */
    public function index() 
    {
        $config = array(
            'base_url'          => site_url('rekanan_thd/index'),
            'total_rows'        => $this->rekanan_thd_model->count_all(),
            'per_page'          => $this->config->item('per_page'),
            'uri_segment'       => 3,
            'num_links'         => 9,
            'use_page_numbers'  => FALSE 
            
        );

            $config['first_link'] = "<";
            $config['last_link'] = ">";
            $config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = '</ul>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';  
			$config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>'; 
			$config['next_link'] = '<i class="fa fa-long-arrow-right"></i>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			
        $this->pagination->initialize($config);
        $data['total']          = $config['total_rows'];
        $data['pagination']     = $this->pagination->create_links();
		$offset = (int)$this->uri->segment(3);
        $data['number']         = $offset ;
		$data['region_nm'] = '';
		$data['branch_nm'] = '';
		$data['q'] = "" ;
		//echo '-->'.count($offset);		
        //exit;

        //var_dump($offset);exit;
		if (count($offset) <= 0) {
			redirect('rekanan_thd');
		}
		else
		{
			 $data['rekanan_thd_model'] = $this->rekanan_thd_model->get_all($config['per_page'], $this->uri->segment(3));
		}
        
		
        $this->load->view('template/v_header');
        $this->load->view('rekanan_thd/view', $data);
        $this->load->view('template/v_footer');
	      
    }

    

    /**
    * Call Form to Add  New rekanan_utilities
    *
    */
    public function add() 
    {       
        $data['rekanan_utilities'] = $this->master_rekanans->add();
        $data['action']  = 'rekanan_utilities/save'; 
		$data['grouptenant_combo'] = $this->master_rekanans->combo_grouptenant(); 
		$data['list_shipping'] = NULL;
		$data['tab'] = 'tab3';	 
		$data['form_viewShipping'] = '<p class="label label-info">Save Dahulu Data Rekanan!</p>';	 
		$this->load->view('template/v_header');
        $this->load->view('rekanan_utilities/form', $data);
        $this->load->view('template/v_footer');
    }

 

    /**
    * Call Form to Modify rekanan_utilities
    *
    */
    public function edit($id='',$tab='') 
    {
		$this->breadcrumbcomponent->add('Edit Rekanan THD','rekanan_thd');
        if ($id != '') 
        {

            $data['master_rekanan']      = $this->rekanan_thd_model->get_one($id);
            $data['action']       = 'rekanan_thd/save/' . $id;           
        
			$data['list_shipping'] = modules::run('rekanan_thd_brand/get_index', $id); 
			//echo var_dump($data['list_shipping']); 
            $data['grouptenant_combo'] = $this->rekanan_thd_model->combo_grouptenant(); 
			$data['form_viewShipping'] =modules::run('rekanan_thd_brand/add',$id);
			$data['tab'] = $tab=='' ? 'tab3' : 'tab4';			
			$this->load->view('template/v_header');
			$this->load->view('rekanan_thd/form', $data);
			$this->load->view('template/v_footer');
        }
        else 
        {
            $this->session->set_flashdata('message','Data tidak ditemukan'); 
            redirect(site_url('rekanan_thd'));
        }
    }


    
    /**
    * Save & Update data  rekanan_utilities
    *
    */
    public function save($id =NULL) 
    {
        // validation config
        // $config = array(
                    
                    // array(
                        // 'field' => 'rekanan_name',
                        // 'label' => 'Rekanan Name',
                        // 'rules' => 'trim|required|min_length[1]|max_length[50]'
                        // ),
                    
                    // array(
                        // 'field' => 'rekanan_namereport',
                        // 'label' => 'Rekanan Namereport',
                        // 'rules' => 'trim|required|min_length[1]|max_length[50]'
                        // ),
                    
                    // array(
                        // 'field' => 'rekanan_address',
                        // 'label' => 'Rekanan Address',
                        // 'rules' => 'trim|required|min_length[1]|max_length[255]'
                        // ), 
                  // );
            
        // if id NULL then add new data
        if(!$id)
        {    
                  //$this->form_validation->set_rules($config);

                  // if ($this->form_validation->run() == TRUE) 
                  // {
                      if ($this->input->post()) 
                      { 
                          $id_rekanansave = $this->master_rekanans->save();
                          $this->session->set_flashdata('message','Data berhasil di simpan');
						  redirect('rekanan_utilities/edit/'.$id_rekanansave); 
                          //redirect('rekanan_utilities');
                      }
					   else // If validation incorrect 
					  {
						  $this->add();
					  }
                  // } 
                  // else // If validation incorrect 
                  // {
                      // $this->add();
                  // }
         }
         else // Update data if Form Edit send Post and ID available
         {               
               
                // if ($this->form_validation->run() == TRUE) 
                // {
                    if ($this->input->post()) 
                    {
                        $this->master_rekanans->update($id);
                        $this->session->set_flashdata('message','Data Tenant berhasil di update'); 
                        redirect('rekanan_utilities/edit/'.$id);
                    }   
					else // If validation incorrect 
					{
						$this->edit($id);
					}
               
         }
    }

     
    
    /**
    * Search rekanan_utilities like ""
    *
    */   
    public function search()
    {
		// echo "<pre/>";
		// echo var_dump($_POST);
		// exit;
        if($this->input->post('q') || $this->input->post('region_ids') || $this->input->post('branch_id'))
        {
            $keyword = $this->input->post('q');
            $region = $this->input->post('region_ids');
            $branch = $this->input->post('branch_id');
            
            $this->session->set_userdata('keyword',$this->input->post('q'));
            $this->session->set_userdata('region',$this->input->post('region_ids'));
            $this->session->set_userdata('branch',$this->input->post('branch_id')); 
        }
		else
		{
			redirect('rekanan_thd');
		}
        
		// echo var_dump($_SESSION);exit;
           $config = array(
            'base_url'          => site_url('rekanan_thd/search/'),
            'total_rows'        => $this->rekanan_thd_model->count_all_search(),
            'per_page'          => 1000,
            'uri_segment'       => 3,
            'num_links'         => 9,
            'use_page_numbers'  => FALSE 
            
        );
            $config['first_link'] = "First";
            $config['last_link'] = "Last";
            $config['full_tag_open'] = "<ul class='pagination pagination-sm'>";
			$config['full_tag_close'] = '</ul>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';  
			$config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>Previous Page';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>'; 
			$config['next_link'] = 'Next Page<i class="fa fa-long-arrow-right"></i>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			
        $this->pagination->initialize($config);
        $data['total']          = $config['total_rows'];
        $data['pagination']     = $this->pagination->create_links();
        $data['number']         = (int)$this->uri->segment(3) +1;
        $data['rekanan_thd_model']       = $this->rekanan_thd_model->get_search($config['per_page'], $this->uri->segment(3)); 
		 
		if(!empty($region) || !empty($branch) )
		{
			$data['region_nm'] = $this->rekanan_thd_model->get_one_datas('master_region','region_id',$region)->region_name;
			$data['branch_nm'] = $this->rekanan_thd_model->get_one_datas('master_branch','branch_id',$branch)->branch_name;
			
		}
		else
		{
			$data['region_nm'] = '';
			$data['branch_nm'] = '';
			$data['q'] ='';
		}
		$data['q'] = $keyword ;
        $this->load->view('template/v_header');
        $this->load->view('rekanan_thd/view', $data);
        $this->load->view('template/v_footer');
		 
		$this->session->unset_userdata('keyword');
		$this->session->unset_userdata('region');
		$this->session->unset_userdata('branch');
    }  
	
    
    
    /**
    * Delete rekanan_utilities by ID
    *
    */
    public function destroy($id) 
    {        
        if ($id) 
        {
            $this->master_rekanans->destroy($id);           
             $this->session->set_flashdata('notif', notify('Data berhasil di hapus','success'));
             redirect('rekanan_utilities');
        } 
        else 
        {
            $this->session->set_flashdata('notif', notify('Data tidak ditemukan','warning'));
            redirect('rekanan_utilities');
        }       
    }

	/**
    * Shipping function
    *
    */
	public function rekanan_shipping_edit($rekanan_id,$rekananshipping_line)
	{
		$this->breadcrumbcomponent->add('Edit Brand','rekanan_thd');
		$data['tab'] = 'tab4';			
		$data['master_rekanan']      = $this->rekanan_thd_model->get_one($rekanan_id);
		$data['action']       = 'rekanan_thd/save/' . $rekanan_id;           
	
		$data['list_shipping'] = modules::run('rekanan_thd_brand/get_index', $rekanan_id );  
		$data['grouptenant_combo'] = $this->rekanan_thd_model->combo_grouptenant(); 
		$data['form_viewShipping'] =modules::run('rekanan_thd_brand/edit',$rekanan_id,$rekananshipping_line);
		$data['tab'] = 'tab4';			
		$this->load->view('template/v_header');
		$this->load->view('rekanan_thd/form', $data);
		$this->load->view('template/v_footer');
	}
	
	/**
    * Shipping function
    *
    */
	public function rekanan_shipping_delete($rekanan_id,$rekananshipping_line)
	{
		$data['tab'] = 'tab3';			
		$data['rekanan_utilities']      = $this->master_rekanans->get_one($rekanan_id);
		$data['action']       = 'rekanan_utilities/save/' . $rekanan_id;           
	
		$data['list_shipping'] = modules::run('rekanan_utilities_brand/get_index', $rekanan_id ); 
		$del =modules::run('rekanan_utilities_brand/destroy',$rekanan_id,$rekananshipping_line); 			
		$this->load->view('template/v_header');
		$this->load->view('rekanan_utilities/form', $data);
		$this->load->view('template/v_footer');
	}
	 
	//Get Data Template
	public function template_utilities_bybranch($type)
	{
		 
		$branch_id = $_POST['branch_id'];
		$data = $this->master_rekanans->get_templateData($type,$branch_id);
	 
		if($data)
		{
			echo json_encode($data);
		}
	}
}

?>
