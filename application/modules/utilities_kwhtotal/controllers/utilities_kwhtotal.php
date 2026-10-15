<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 


class Utilities_kwhtotal extends MX_Controller
{
	public $pages;


    public function __construct() 
    {
        parent::__construct();  
		check_user_login();
        $this->load->model('Model_utilities_kwhtotal');       
		$this->load->library('breadcrumbcomponent'); 
		$this->load->library('pagination'); 
		$this->breadcrumbcomponent->add('Utilities KWH Total','utilities_kwhtotal');
		$this->breadcrumbcomponent->add('List Utilities KWH Total','utilities_kwhtotal');
    }
    

    /**
    * List all data master_branch
    *
    */
    public function index($pages=10,$offset=0) 
    {
		$pages = (int)$this->uri->segment(3);
		if ( $pages==0 ) {
			$pages=10;
		}
		if (!$offset){
			$offset=0;
		}
        $config = array(
            'base_url'          => site_url('utilities_kwhtotal/index/'.$pages),
            'total_rows'        => $this->Model_utilities_kwhtotal->count_all(),
            'per_page'          => $pages, //$this->config->item('per_page'),
            'uri_segment'       => 4,
            'num_links'         => 9,
            'use_page_numbers'  => false, 
            
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
		//$offset = (int)$this->uri->segment(4) +1;
		$data['pages']			= $pages;
        $data['number']         = $offset ;
		if (count($offset) <= 0) { 
		 	$data['master_utilities_kwhtotal']       = $this->Model_utilities_kwhtotal->get_all($pages,0); //$config['per_page'],0); 
		}
		else
		{
			$data['master_utilities_kwhtotal']       = $this->Model_utilities_kwhtotal->get_all($pages,$offset );//$this->uri->segment(2)); //$config['per_page'], $this->uri->segment(2)); 
		}
		
		
		$options = array(
			'10'         => '10',
			'20'           => '20',
			'50'         => '50',
			'100'        => '100',
		);
		$data['options'] =$options;

		$this->load->view('template/v_header');
		$this->load->view('utilities_kwhtotal/view',$data);
		$this->load->view('template/v_footer');
	      
    }

    /**
    * Call Form to Add  New master_branch
    *
    */
    public function add() 
    {       
        $data['master_utilities_kwhtotal'] = $this->Model_utilities_kwhtotal->add();
		
        $data['action']  = 'utilities_kwhtotal/save';
     
        $data['periode'] = $this->Model_utilities_kwhtotal->get_periode();

		$data['regionbranch'] = $this->Model_utilities_kwhtotal->get_regionbranch();
		 
		$data['branch'] = $this->Model_utilities_kwhtotal->get_branch();

        $data['region'] = $this->Model_utilities_kwhtotal->get_region();
     
        $data['region_branch']  = array();
		
		$this->load->view('template/v_header');
		$this->load->view('utilities_kwhtotal/form',$data);
		$this->load->view('template/v_footer');

    }

    

    /**
    * Call Form to Modify master_branch
    *
    */
    public function edit($id='') 
    {
        if ($id != '') 
        {

            $data['master_utilities_kwhtotal']      = $this->Model_utilities_kwhtotal->get_one($id);
            $data['action']       = 'utilities_kwhtotal/save/' . $id; 
			$data['periode'] = $this->Model_utilities_kwhtotal->get_periode();

			$data['branch'] = $this->Model_utilities_kwhtotal->get_branch();
			$data['regionbranch'] = $this->Model_utilities_kwhtotal->get_regionbranch();
		 
			$data['region'] = $this->Model_utilities_kwhtotal->get_region();

			$data['region_branch'] = $this->Model_utilities_kwhtotal->get_regionbranch_all($id);
            $this->load->view('template/v_header');
			$this->load->view('utilities_kwhtotal/form',$data);
			$this->load->view('template/v_footer'); 
        }
        else 
        {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('utilities_kwhtotal'));
        }
    }


    
    /**
    * Save & Update data  master_branch
    *
    */
    public function save($id =NULL) 
    {
        // validation config
       
            
        // if id NULL then add new data
        if(!$id)
        {    
                  
                      if ($this->input->post()) 
                      {  
                         $id_utilitieskwhtotal =  $this->Model_utilities_kwhtotal->save();
                          $this->session->set_flashdata('message', 'Data berhasil di simpan');
                          redirect('utilities_kwhtotal/edit/'.$id_utilitieskwhtotal);
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
                        $this->Model_utilities_kwhtotal->update($id);
                        $this->session->set_flashdata('message', 'Data berhasil di update');
                        redirect('utilities_kwhtotal/edit/'.$id);
                    } 
					else // If validation incorrect 
					{
						$this->edit($id);
					}
         }
    }

    
    
   
    
    /**
    * Search master_branch like ""
    *
    */   
    public function search($pages=20 ,$offset=0)
    {
		$pages = (int)$this->uri->segment(3);
		$offset = (int)$this->uri->segment(4);
		if ( $pages==0 ) {
			$pages=20;
		}
		if (!$offset){
			$offset=0;
		}

        if($this->input->post('q'))
        {
            $keyword = $this->input->post('q');
            
            $this->session->set_userdata(
                        array('keyword' => $this->input->post('q',TRUE))
                    );
        }
		else
		{
			redirect('utilities_kwhtotal');
		}
        
         $config = array(
            'base_url'          => site_url('utilities_kwhtotal/search/'.$pages),
            'total_rows'        => $this->Model_utilities_kwhtotal->count_all_search(),
            'per_page'          => $pages, //$this->config->item('per_page'),
            'uri_segment'       => 4,
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
        $data['number']         = $offset; //(int)$this->uri->segment(3) +1;
        $data['pagination']     = $this->pagination->create_links();
        $data['master_utilities_kwhtotal']       = $this->Model_utilities_kwhtotal->get_search($pages,$offset);//$config['per_page'], $this->uri->segment(3)); 
		$options = array(
			'10'         => '10',
			'20'         => '20',
			'50'         => '50',
			'100'         => '100',
		);
		$data['options'] =$options;
		$data['pages'] =$pages;
		$this->session->unset_userdata('keyword');
	 
		
        $this->load->view('template/v_header');
		$this->load->view('utilities_kwhtotal/view',$data);
		$this->load->view('template/v_footer');
		
		
    }
    
    
    /**
    * Delete master_branch by ID
    *
    */
    public function destroy($id) 
    {        
        if ($id) 
        {
            $this->Model_utilities_kwhtotal->destroy($id);           
             $this->session->set_flashdata('message', 'Data berhasil di hapus');
             redirect('utilities_kwhtotal');
        } 
        else 
        {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect('utilities_kwhtotal');
        }       
    }

	public function getBranchAjax()
	{
		$region_id 			= empty($_GET['region']) ? '' : $_GET['region'];
		$branch_name 		= empty($_GET['term']) ? '' : $_GET['term'];
		$data['items']      = $this->Model_utilities_kwhtotal->get_branch2($branch_name['term'],$region_id);
		echo json_encode($data);
	}

	public function getRegionBranch()
	{
		$region_id 			= empty($_GET['region']) ? '' : $_GET['region'];
		$branch_name 		= empty($_GET['term']) ? '' : $_GET['term'];
		$data['items']      = $this->Model_utilities_kwhtotal->get_branch2($branch_name['term'],$region_id);
		echo json_encode($data);
	}



}

?>
