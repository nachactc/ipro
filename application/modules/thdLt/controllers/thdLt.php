<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 


class thdLt extends MX_Controller
{

    public function __construct() 
    {
        parent::__construct();  
				check_user_login();
        $this->load->model('thdLtModel');       
				$this->load->library('breadcrumbcomponent'); 
				$this->breadcrumbcomponent->add('THD Lantai','thdLt');
    }
    

    /**
    * List all data THD Lantai
    *
    */
    public function index() 
    {
        $config = array(
            'base_url'          => site_url('thdLt/index'),
            'total_rows'        => $this->thdLtModel->count_all(),
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

				$offset = (int)$this->uri->segment(3) +1;
				$data['number']         = $offset ;

				if (count($offset) <= 0) { 
					$data['records']       = $this->thdLtModel->get_all($config['per_page'],0); 
				}
				else
				{
					$data['records']       = $this->thdLtModel->get_all($config['per_page'], $this->uri->segment(3)); 
				}
        
       
			$this->load->view('template/v_header');
			$this->load->view('thdLt/view',$data);
			$this->load->view('template/v_footer');	      
    }

    

    /**
    * Call Form to Add  New thdLt
    *
    */
    public function add() 
    {       
        $data['records'] = $this->thdLtModel->add();	
        $data['action']  = 'thdLt/save';

				$this->load->view('template/v_header');
				$this->load->view('thdLt/form',$data);
				$this->load->view('template/v_footer');
    }

    

    /**
    * Call Form to Modify thdLt
    *
    */
    public function edit($id='') 
    {
        if ($id != '') 
        {
						$where ='';
            $data['records']      = $this->thdLtModel->get_one($id);			

						$where = " thdlt_id = "."'"."'".$id."'"."'";
			
            $data['action']       = 'thdLt/save/' . $id; 			
			 			// echo  var_dump($data['utilities_listrik']);exit;

            $this->load->view('template/v_header');
						$this->load->view('thdLt/form',$data);
						$this->load->view('template/v_footer'); 
        }
        else 
        {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('thdLt'));
        }
    }


    
    /**
    * Save & Update data  thdLt
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
								$id = $this->thdLtModel->save();							
								$this->session->set_flashdata('message', 'Data berhasil disimpan');		
								redirect('thdLt/edit/'.$id);							
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
								$this->thdLtModel->update($id);
								$this->session->set_flashdata('message', 'Data berhasil diubah');
								redirect('thdLt/edit/'.$id);
						} 
						else // If validation incorrect 
						{
							$this->edit($id);
						}
         }
    }

    
    
   
    
    /**
    * Search thdLt like ""
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
					redirect('thdLt');
				}
        
				$config = array(
					'base_url'          => site_url('thdLt/search/'),
					'total_rows'        => $this->thdLtModel->count_all_search(),
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
        $data['number']         = (int)$this->uri->segment(3) +1;
        $data['pagination']     = $this->pagination->create_links();
        $data['records']       = $this->thdLtModel->get_search($config['per_page'], $this->uri->segment(3)); 
				
				$this->session->unset_userdata('keyword');	 
        $this->load->view('template/v_header');
				$this->load->view('thdLt/view',$data);
				$this->load->view('template/v_footer');			
    }
    
    
    /**
    * Delete thdLt by ID
    *
    */
    public function destroy($id) 
    {        

        if ($id) 
        {
             $this->thdLtModel->destroy($id);           
             $this->session->set_flashdata('message', 'Data berhasil di hapus');
             redirect('thdLt');
        } 
        else 
        {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect('thdLt');
        }       
    }	

	function initialize_grid($qry_alldata,$qry_filtered,$qry_totalall,$arcari,$cariOptional = ''){
		$aColumns = $arcari;
     
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) ) {
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
					$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
						".addslashes( $_GET['sSortDir_'.$i] ) .", ";
				}
			}
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" ) {
				$sOrder = "";
			}
		}
		   
		$sWhere = ""; 
		if ( isset($_POST['search']['value']) && $_POST['search']['value'] != "" ) {
		   $sWhere = "WHERE ("; 
			for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
				$sWhere .= $aColumns[$i]." LIKE '%".addslashes( $_POST['search']['value'] )."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		for ($i=0; $i < count($aColumns); $i++) {
			if ( isset($_POST['columns'][$i]['search']['value']) && $_POST['columns'][$i]['search']['value'] != "" ) { 
				$searchCol = trim($_POST['columns'][$i]['search']['value']);
				if ($searchCol != '') {
					if ($sWhere != ''){             
						$sWhere .= " AND ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
					} else {
						$sWhere = "WHERE ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
					}
					 $sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;
					
				}
			}
		}
		 
				 		
		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
		$limit=$limit+$top;

		$b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ;        

		$sWhere = $sWhere.$b;
		
		$rResult=$this->thdLtModel->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->thdLtModel->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->thdLtModel->$qry_totalall();
		$iTotal = $rResultTotal['jml'];
		   
		$output = array(
			"draw"=> $_POST['draw'],
			"recordsTotal" => $iTotal,
			"recordsFiltered" => $iFilteredTotal,
			"data" => array()
		);
		  $data['output']=$output;
		  $data['rResult']=$rResult;
	
		return $data;
	} 
	
}

?>
