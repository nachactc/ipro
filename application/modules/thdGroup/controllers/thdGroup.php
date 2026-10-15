<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 


class thdGroup extends MX_Controller
{

    public function __construct() 
    {
        parent::__construct();  
				check_user_login();
        $this->load->model('thdGroupModel');       
				$this->load->library('breadcrumbcomponent'); 
				$this->breadcrumbcomponent->add('THD Group','thdGroup');
    }
    

    /**
    * List all data THD Category
    *
    */
    public function index() 
    {
        $config = array(
            'base_url'          => site_url('thdGroup/index'),
            'total_rows'        => $this->thdGroupModel->count_all(),
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
					$data['records']       = $this->thdGroupModel->get_all($config['per_page'],0); 
				}
				else
				{
					$data['records']       = $this->thdGroupModel->get_all($config['per_page'], $this->uri->segment(3)); 
				}
        
       
			$this->load->view('template/v_header');
			$this->load->view('thdGroup/view',$data);
			$this->load->view('template/v_footer');	      
    }

    

    /**
    * Call Form to Add  New thdGroup
    *
    */
    public function add() 
    {       
        $data['records'] = $this->thdGroupModel->add();	
        $data['action']  = 'thdGroup/save';

				$this->load->view('template/v_header');
				$this->load->view('thdGroup/form',$data);
				$this->load->view('template/v_footer');
    }

    

    /**
    * Call Form to Modify thdGroup
    *
    */
    public function edit($id='') 
    {
        if ($id != '') 
        {
						$where ='';
            $data['records']      = $this->thdGroupModel->get_one($id);			

						$where = " thdGroup_id = "."'"."'".$id."'"."'";
			
            $data['action']       = 'thdGroup/save/' . $id; 			
			 			// echo  var_dump($data['utilities_listrik']);exit;

            $this->load->view('template/v_header');
						$this->load->view('thdGroup/form',$data);
						$this->load->view('template/v_footer'); 
        }
        else 
        {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('thdGroup'));
        }
    }


    
    /**
    * Save & Update data  thdGroup
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
								$id = $this->thdGroupModel->save();							
								$this->session->set_flashdata('message', 'Data berhasil disimpan');		
								redirect('thdGroup/edit/'.$id);							
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
								$this->thdGroupModel->update($id);
								$this->session->set_flashdata('message', 'Data berhasil diubah');
								redirect('thdGroup/edit/'.$id);
						} 
						else // If validation incorrect 
						{
							$this->edit($id);
						}
         }
    }

    
    
   
    
    /**
    * Search thdGroup like ""
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
					redirect('thdGroup');
				}
        
				$config = array(
					'base_url'          => site_url('thdGroup/search/'),
					'total_rows'        => $this->thdGroupModel->count_all_search(),
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
        $data['records']       = $this->thdGroupModel->get_search($config['per_page'], $this->uri->segment(3)); 
				
				$this->session->unset_userdata('keyword');	 
        $this->load->view('template/v_header');
				$this->load->view('thdGroup/view',$data);
				$this->load->view('template/v_footer');			
    }
    
    
    /**
    * Delete thdGroup by ID
    *
    */
    public function destroy($id) 
    {        

        if ($id) 
        {
             $this->thdGroupModel->destroy($id);           
             $this->session->set_flashdata('message', 'Data berhasil di hapus');
             redirect('thdGroup');
        } 
        else 
        {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect('thdGroup');
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
		
		$rResult=$this->thdGroupModel->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->thdGroupModel->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->thdGroupModel->$qry_totalall();
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
