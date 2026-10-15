<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 


class Master_rekanan extends MX_Controller
{

    public function __construct() 
    {
        parent::__construct(); 
		check_user_login();        
        $this->load->model('master_rekanans');  
		$this->load->library('breadcrumbcomponent'); 
		$this->breadcrumbcomponent->add('Rekanan','master_rekanan');
		$this->load->helper(array('form', 'url')); 
        $this->load->library('form_validation');
    }
    
	public function tes_rekanan()
	{
		$res =  generate_id_int('','105','sequencer_rekanan');
		echo $res;
	}

    /**
    * List all data master_rekanan
    *
    */
    public function index() 
    {
        $config = array(
            'base_url'          => site_url('master_rekanan/index'),
            'total_rows'        => $this->master_rekanans->count_all(),
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
		//echo '-->'.count($offset);
		//exit;
		if (count($offset) <= 0) { 
			redirect('Master_rekanan');
		}
		else
		{
			 $data['master_rekanans']= $this->master_rekanans->get_all($config['per_page'], $this->uri->segment(3));
		}
        
		
        $this->load->view('template/v_header');
        $this->load->view('master_rekanan/view', $data);
        $this->load->view('template/v_footer');
	      
    }

    

    /**
    * Call Form to Add  New master_rekanan
    *
    */
    public function add() 
    {      
		$this->breadcrumbcomponent->add('Add Rekanan','master_rekanan');
        $data['master_rekanan'] = $this->master_rekanans->add();
        $data['action']  = 'master_rekanan/save'; 
		$data['grouptenant_combo'] = $this->master_rekanans->combo_grouptenant(); 
		$data['list_shipping'] = NULL;
		$data['tab'] = 'tab3';	 
		$data['form_viewShipping'] = '<p class="label label-info">Save Dahulu Data Rekanan!</p>';	 
		$this->load->view('template/v_header');
        $this->load->view('master_rekanan/form', $data);
        $this->load->view('template/v_footer');
    }

 

    /**
    * Call Form to Modify master_rekanan
    *
    */
    public function edit($id='',$tab='') 
    {
		$this->breadcrumbcomponent->add('Edit Rekanan','master_rekanan');
        if ($id != '') 
        {

            $data['master_rekanan']      = $this->master_rekanans->get_one($id);
            $data['action']       = 'master_rekanan/save/' . $id;           
        
			$data['list_shipping'] = modules::run('master_rekananshipping/get_index', $id); 
			//echo var_dump($data['list_shipping']); 
            $data['grouptenant_combo'] = $this->master_rekanans->combo_grouptenant(); 
			$data['form_viewShipping'] =modules::run('master_rekananshipping/add',$id);
			$data['tab'] = $tab=='' ? 'tab3' : 'tab4';			
			$this->load->view('template/v_header');
			$this->load->view('master_rekanan/form', $data);
			$this->load->view('template/v_footer');
        }
        else 
        {
            $this->session->set_flashdata('message','Data tidak ditemukan'); 
            redirect(site_url('master_rekanan'));
        }
    }


    
    /**
    * Save & Update data  master_rekanan
    *
    */
    public function save($id =NULL) 
    {
		
        // validation config
        $config = array(
                    
                    array(
                        'field' => 'taxsign_id',
                        'label' => 'NPWP',
                        'rules' => 'trim|required|min_length[1]|max_length[50]' ,
						'errors' => array(
							'required' => 'NPWP Harus Di Isi.',
							),
                        ),
                    array(
                        'field' => 'rekanan_address',
                        'label' => 'Alamat',
                        'rules' => 'trim|required|min_length[1]|max_length[550]' ,
						'errors' => array(
							'required' => 'Alamat Harus Di Isi.',
							),
                        ), 
                  );
        $this->form_validation->set_rules($config);  
        // if id NULL then add new data
        if(!$id)
        {     
 
                  if ($this->form_validation->run() == TRUE) 
                  {
                      if ($this->input->post()) 
                      { 
                          $id_rekanansave = $this->master_rekanans->save();
                          $this->session->set_flashdata('message','Data berhasil di simpan');
						  redirect('master_rekanan/edit/'.$id_rekanansave); 
                          //redirect('master_rekanan');
                      }
					   else // If validation incorrect 
					  {
						  $this->add();
					  }
                  } 
                  else // If validation incorrect 
                  {
                       $this->add();
                  }
         }
         else // Update data if Form Edit send Post and ID available
         {               
               
                if ($this->form_validation->run() == TRUE) 
                {
                    if ($this->input->post()) 
                    {
                        $this->master_rekanans->update($id);
                        $this->session->set_flashdata('message','Data Tenant berhasil di update'); 
                        redirect('master_rekanan/edit/'.$id);
                    }   
					else // If validation incorrect 
					{
						$this->edit($id,'tab3');
					}
				}
				else
				{
					$this->edit($id,'tab3');
				}
					
               
         }
    }

     
    
    /**
    * Search master_rekanan like ""
    *
    */   
    public function search()
    {
        if($this->input->post('q'))
        {
            $keyword = $this->input->post('q');
            
            $this->session->set_userdata(
                        array('keyword' => $this->input->post('q',TRUE))
                    );
        }
		else
		{
			redirect('master_rekanan');
		}
        
           $config = array(
            'base_url'          => site_url('master_rekanan/search/'),
            'total_rows'        => $this->master_rekanans->count_all_search(),
            'per_page'          => $this->config->item('per_page'),
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
        $data['master_rekanans']       = $this->master_rekanans->get_search($config['per_page'], $this->uri->segment(3));
		
        $this->load->view('template/v_header');
        $this->load->view('master_rekanan/view', $data);
        $this->load->view('template/v_footer');
		
		$this->session->unset_userdata('keyword');
    }  
	
    
    
    /**
    * Delete master_rekanan by ID
    *
    */
    public function destroy($id) 
    {        
        if ($id) 
        {
            $this->master_rekanans->destroy($id);           
             $this->session->set_flashdata('notif', notify('Data berhasil di hapus','success'));
             redirect('master_rekanan');
        } 
        else 
        {
            $this->session->set_flashdata('notif', notify('Data tidak ditemukan','warning'));
            redirect('master_rekanan');
        }       
    }

	/**
    * Shipping function
    *
    */
	public function rekanan_shipping_edit($rekanan_id,$rekananshipping_line)
	{
		$data['tab'] = 'tab4';			
		$data['master_rekanan']      = $this->master_rekanans->get_one($rekanan_id);
		$data['action']       = 'master_rekanan/save/' . $rekanan_id;           
	
		$data['list_shipping'] = modules::run('master_rekananshipping/get_index', $rekanan_id );  
		$data['grouptenant_combo'] = $this->master_rekanans->combo_grouptenant(); 
		$data['form_viewShipping'] =modules::run('master_rekananshipping/edit',$rekanan_id,$rekananshipping_line);
		$data['tab'] = 'tab4';			
		$this->load->view('template/v_header');
		$this->load->view('master_rekanan/form', $data);
		$this->load->view('template/v_footer');
	}
	
	/**
    * Shipping function
    *
    */
	public function rekanan_shipping_delete($rekanan_id,$rekananshipping_line)
	{
		$data['tab'] = 'tab3';			
		$data['master_rekanan']      = $this->master_rekanans->get_one($rekanan_id);
		$data['action']       = 'master_rekanan/save/' . $rekanan_id;           
	
		$data['list_shipping'] = modules::run('master_rekananshipping/get_index', $rekanan_id ); 
		$del =modules::run('master_rekananshipping/destroy',$rekanan_id,$rekananshipping_line); 			
		$this->load->view('template/v_header');
		$this->load->view('master_rekanan/form', $data);
		$this->load->view('template/v_footer');
	}
	 
}

?>
