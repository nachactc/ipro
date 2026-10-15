<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 


class La_received extends MX_Controller
{

    public function __construct() 
    {
        parent::__construct();      
		check_user_login();   
        $this->load->model('Model_lareceived'); 
		$this->load->library('breadcrumbcomponent'); 		
    }
    

    /**
    * List all data La_received
    *
    */
    public function index() 
    { 
        $config = array(
            'base_url'          => site_url('La_received/index'),
            'total_rows'        => $this->Model_lareceived->count_all(),
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
		//echo count($offset);exit;
        $data['number']         = $offset+1 ;
		if (count($offset) <= 0) { 
			redirect('la_received'); 
		}
		else
		{
			  $data['La_receiveds']       = $this->Model_lareceived->get_search($config['per_page'], $this->uri->segment(3));
		}
	    $this->load->view('template/v_header');
		$this->load->view('la_received/view',$data);
		$this->load->view('template/v_footer');    
    }

    

    /**
    * Call Form to Add  New La_received
    *
    */
    public function add() 
    {       
        $data['la_received'] = $this->Model_lareceived->add();
        $data['action']  = 'La_received/save';
		$data['tab'] = 'input';
		$data['dialog_loo'] = $this->load->view('la_received/dialog_loo');
		$this->load->view('template/v_header');
		$this->load->view('la_received/form',$data);
		$this->load->view('template/v_footer');  
    }

    /**
    * Call Form Dialog LOO
    *
    */
    public function dialog_loo($search='')
	{
		// echo $search;
		// exit;
		$dataDlg = $this->Model_lareceived->get_data_dialog_loo($search);
		$dataDlgR = $this->Model_lareceived->get_data_dialog_loo_rows($search);
		$row = array();  
		$data = array();   
	    foreach ($dataDlg as $aRow) 
		{ 
			$row[0]=$aRow['region_nameshort'];
			$row[1]=$aRow['branch_name'];
			$row[2]=$aRow['rekanan_name'];
			$row[3]=$aRow['rekananshipping_name']; 
			$row[4]=$aRow['loo_id']; 
			$row[5]=$aRow['loi_no']; 
			
			if (!empty($row)) { 
				$output['data'][] = $row; 
			} 
		}
		
		if ($dataDlg == NULL)
		{ 
				$row[0]='';
				$row[1]='';
				$row[2]='';
				$row[3]=''; 
				$row[4]='';
				$row[5]=''; 
				$output['data'][] = $row;  
		}
		
		  // echo '<pre>';
		  // echo var_dump($dataDlgR);
		 $output = array(
                 "draw" => $_POST['draw'],
                 "recordsTotal" => $dataDlgR,
                 "recordsFiltered" => $dataDlgR,
                 "data" =>$output['data'] 
            );
		echo json_encode($output);
	}

    /**
    * Call Form to Modify La_received
    *
    */
    public function edit($id='') 
    {
		$id = str_replace('/', '_',$id);
		$ids = str_replace('_', '/',$id);
        if ($id != '') 
        {

            $data['la_received']      = $this->Model_lareceived->get_one($ids);
            $data['action']       = 'La_received/save/' . $id;           
			$data['tab'] = 'edit';
			$data['dialog_loo'] = $this->load->view('la_received/dialog_loo');
            $this->load->view('template/v_header');
			$this->load->view('la_received/form',$data);
			$this->load->view('template/v_footer');  
            
        }
        else 
        {
            echo "<script>alert('Pilih Data Dulu!')</script>";
			echo "<script>setTimeout(\"location.href = '".site_url('La_received')."';\",10);</script>";
        }
    }


    
    /**
    * Save & Update data  La_received
    *
    */
    public function save($id =NULL) 
    {
		
       // echo var_dump($this->input->post());
        // if id NULL then add new data
        if(!$id)
        {     
			if ( $this->input->post('loo_id') != '' ) 
			  {
				  
				  $this->Model_lareceived->save();
				  $this->session->set_flashdata('message', 'Data berhasil di simpan');
				  redirect('La_received');
			  } 
			else // If validation incorrect 
			  {
				  $this->add();
			  }
         }
         else // Update data if Form Edit send Post and ID available
         {               
                 
				if ( $this->input->post('loo_id') != '' ) 
				{
					$this->Model_lareceived->update($id);
					$this->session->set_flashdata('message', 'Data berhasil di update');
					redirect('La_received');
				} 
                else // If validation incorrect 
                {
                    $this->edit($id);
                }
         }
    }

    
     
    
    
    /**
    * Search La_received like ""
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
            'base_url'          => site_url('La_received/search'),
            'total_rows'        => $this->Model_lareceived->count_all_search(),
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
        $data['number']         = $offset+1 ;
		if (count($offset) <= 0) { 
			redirect('la_received');
		}
		else
		{
			  $data['La_receiveds']       = $this->Model_lareceived->get_search($config['per_page'], $this->uri->segment(3));
		}
		
       
        $this->session->unset_userdata('keyword');
        $this->load->view('template/v_header');
		$this->load->view('la_received/view',$data);
		$this->load->view('template/v_footer');  
    }
    
    
    /**
    * Delete La_received by ID
    *
    */
    public function destroy($id) 
    {        
        if ($id) 
        {
            $this->Model_lareceived->destroy($id);           
             $this->session->set_flashdata('message', 'Data berhasil di hapus');
             redirect('La_received');
        } 
        else 
        {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect('La_received');
        }       
    }

}

?>
