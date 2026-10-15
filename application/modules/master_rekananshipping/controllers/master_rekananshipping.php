<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 

class master_rekananshipping extends MX_Controller
{

    public function __construct() 
    {
       parent::__construct(); 
		check_user_login(); 
        $this->load->model('master_rekananshippings');
		$this->load->library('breadcrumbcomponent');  
    }
    
	public function test()
	{
		$branch_id = '0000603';
		$region_id = '1050097'; 
		$this->master_rekananshippings->getDebtorCode($branch_id,$region_id);
	}
    // /**
    // * List all data master_rekananshipping
    // *
    // */
    // public function  index($id) 
    // { 
        // $data['number']         = (int)$this->uri->segment(3) +1;
        // $data['master_rekananshippings']       = $this->master_rekananshippings->get_one($id);
        // $this->template->render('master_rekananshipping/view',$data);
		 
		// echo print_r($data);
		// return $data;
	      
    // }
	/**
    * List all data master_rekananshipping
    *
    */
    public function  get_index($id) 
    { 
         
       $data =  $this->master_rekananshippings->get_one($id);
        
		 
		//echo print_r($data);
		return $data;
	      
    }

    

    /**
    * Call Form to Add  New master_rekananshipping
    *
    */
    public function add($rekanan_id) 
    {       
        $data['master_rekananshipping'] = $this->master_rekananshippings->add();
        $data['action']  = 'master_rekananshipping/save/'.$rekanan_id.'/0'; 
        $data['combo_branch'] = $this->master_rekananshippings->combo_branch(); 
        $data['combo_shippingtype'] = $this->master_rekananshippings->combo_shipping_type(); 
		$line_ = $this->master_rekananshippings->get_line($rekanan_id);
		//$line_ = $line_ == '' ? 10 : $line_ + 10; 
		$data['line'] =$line_;
		$data['id_rekanan'] =$rekanan_id;
        $this->load->view('master_rekananshipping/form',$data);

    }

    

    /**
    * Call Form to Modify master_rekananshipping
    *
    */
    public function edit($rekanan_id,$rekananshipping_line) 
    {
		
        if ($rekanan_id != '' || $rekananshipping_line != 0 ) 
        {

            $data['master_rekananshipping']      = $this->master_rekananshippings->get_one_edit($rekanan_id,$rekananshipping_line);
            $data['action']       = 'save/' . $rekanan_id.'/'.$rekananshipping_line; 
            $data['combo_branch'] = $this->master_rekananshippings->combo_branch();  
			$data['combo_shippingtype'] = $this->master_rekananshippings->combo_shipping_type(); 
			$data['line'] = $rekananshipping_line;
			$data['id_rekanan'] =$rekanan_id;
            $this->load->view('master_rekananshipping/form',$data);
        }
        else 
        {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('master_rekanan/edit/'.$id));
        }
    }


    
    /**
    * Save & Update data  master_rekananshipping
    *
    */
    public function save($rekanan_id,$rekananshipping_line) 
    {
		 // echo "<pre>";
         // echo print_r($_POST);
         // echo "</pre>";
		 // exit;
		$cek_line = $this->input->post('rekananshipping_line');
		
		$rekananshipping_line = $cek_line == 0 ? 0 : $rekananshipping_line;
       
            
        // if id NULL then add new data
		 
		
        if(!$rekanan_id || $rekananshipping_line == 0   )
        {   
                  
				  $branch_id = strip_tags($this->input->post('branch_id', TRUE));
				 
				  if($branch_id == '')
				  {
					  
					$this->session->set_flashdata('message', 'Data Gagal di simpan,Branch Harus Dipilih!');
					redirect('master_rekanan/edit/'.$rekanan_id);
				  }
				  else
				  {
					 if ($this->input->post()) 
                      {
                          
                          $this->master_rekananshippings->save($rekanan_id);
                          $this->session->set_flashdata('message', 'Data Brand berhasil di simpan');
                          redirect('master_rekanan/edit/'.$rekanan_id);
                      } 
					  else // If validation incorrect 
					  {
					  
						  $this->add($rekanan_id);
						  
					  }  
				  }
                   
                      
         }
		 
         if(!$rekanan_id || $rekananshipping_line != 0) // Update data if Form Edit send Post and ID available
         {               
                 
                    if ($this->input->post()) 
                    {
                        $this->master_rekananshippings->update($rekanan_id,$rekananshipping_line);
                        $this->session->set_flashdata('message', 'Data Trade berhasil di update');
                        redirect('master_rekanan/edit/'.$rekanan_id);
                    } 
					else // If validation incorrect 
					{
						$this->edit($rekanan_id,$rekananshipping_line);
					}
         }
    }

    
    
    /**
    * Detail master_rekananshipping
    *
    */
    public function show($id='') 
    {
        if ($id != '') 
        {

            $data['master_rekananshipping'] = $this->master_rekananshippings->get_one($id);            
            $this->template->render('master_rekananshipping/_show',$data);
            
        }
        else 
        {
            $this->session->set_flashdata('notif', notify('Data tidak ditemukan','info'));
            redirect(site_url('master_rekananshipping'));
        }
    }
    
    
    /**
    * Search master_rekananshipping like ""
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
        
         $config = array(
            'base_url'          => site_url('master_rekananshipping/search/'),
            'total_rows'        => $this->master_rekananshippings->count_all_search(),
            'per_page'          => $this->config->item('per_page'),
            'uri_segment'       => 3,
            'num_links'         => 9,
            'use_page_numbers'  => FALSE
        );
        
        $this->pagination->initialize($config);
        $data['total']          = $config['total_rows'];
        $data['number']         = (int)$this->uri->segment(3) +1;
        $data['pagination']     = $this->pagination->create_links();
        $data['master_rekananshippings']       = $this->master_rekananshippings->get_search($config['per_page'], $this->uri->segment(3));
       
        $this->template->render('master_rekananshipping/view',$data);
    }
    
    
    /**
    * Delete master_rekananshipping by ID
    *
    */
    public function destroy($rekanan_id,$rekananshipping_line) 
    {        
        if ($rekanan_id||$rekananshipping_line) 
        {
            $this->master_rekananshippings->destroy($rekanan_id,$rekananshipping_line);           
             $this->session->set_flashdata('message', 'Data berhasil di hapus');
             redirect('master_rekanan/edit/'.$rekanan_id);
        } 
        else 
        {
            $this->session->set_flashdata('message', 'Data tidak ditemukan'); 
             redirect('master_rekanan/edit/'.$rekanan_id);
        }       
    }

}

?>
