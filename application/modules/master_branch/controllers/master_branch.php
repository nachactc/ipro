<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 


class master_branch extends MX_Controller
{

    public function __construct() 
    {
        parent::__construct();  
		check_user_login();
        $this->load->model('master_branchs');       
		$this->load->library('breadcrumbcomponent'); 
		$this->breadcrumbcomponent->add('Store','master_branch');
    }
    

    /**
    * List all data master_branch
    *
    */
    public function index() 
    {
        $config = array(
            'base_url'          => site_url('master_branch/index'),
            'total_rows'        => $this->master_branchs->count_all(),
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
		 $data['master_branchs']       = $this->master_branchs->get_all($config['per_page'],0); 
		}
		else
		{
			 $data['master_branchs']       = $this->master_branchs->get_all($config['per_page'], $this->uri->segment(3)); 
		}
        
       
		$this->load->view('template/v_header');
		$this->load->view('master_branch/view',$data);
		$this->load->view('template/v_footer');
	      
    }

    

    /**
    * Call Form to Add  New master_branch
    *
    */
    public function add() 
    {       
        $data['master_branch'] = $this->master_branchs->add();
		
        $data['action']  = 'master_branch/save';
     
        $data['branch_parent_combo'] = $this->master_branchs->get_branch_parent_combo();
     
        $data['utilitiesgasir_combo'] = $this->master_branchs->get_utilitiesgasir_combo();
      
		$data['region_branch'] = $this->master_branchs->get_regionbranch_all('');
		
		$this->load->view('template/v_header');
		$this->load->view('master_branch/form',$data);
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
			$where ='';
            $data['master_branch']      = $this->master_branchs->get_one($id);
			
			// $utilites=$this->master_branchs->getutilities_id($id);
            // $utilitieslistrik_id = $utilites['utilitieslistrik_id'];
			// $utilitiesair_id = $utilites['utilitiesair_id'];
			// $utilitiesgas_id = $utilites['utilitiesgas_id'];
			// if ($utilitieslistrik_id != '')
			// {				
				
			// }
			
			$where = " branch_id = "."'"."'".$id."'"."'";
			
            $data['action']       = 'master_branch/save/' . $id; 
			$data['branch_parent_combo'] = $this->master_branchs->get_branch_parent_combo();
			$data['utilitiesgasir_combo'] = $this->master_branchs->get_utilitiesgasir_combo();
			$data['region_branch'] = $this->master_branchs->get_regionbranch_all($id);
			$data['utilities_listrik'] = $this->master_branchs->get_utilitieslistrik_all($where);
			$data['utilities_air'] = $this->master_branchs->get_utilitiesair_all($where);
			$data['utilities_gas'] = $this->master_branchs->get_utilitiesgas_all($where);
			$data['utilities_kva'] = $this->master_branchs->get_utilitieskva_all($where);
			echo 'bug = ' . $where;
			 // echo  var_dump($data['utilities_listrik']);exit;
			
            $this->load->view('template/v_header');
			$this->load->view('master_branch/form',$data);
			$this->load->view('template/v_footer'); 
        }
        else 
        {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('master_branch'));
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
                         $id_branch =  $this->master_branchs->save();
                          $this->session->set_flashdata('message', 'Data berhasil di simpan');
                          redirect('master_branch/edit/'.$id_branch);
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
                        $this->master_branchs->update($id);
                        $this->session->set_flashdata('message', 'Data berhasil di update');
                        redirect('master_branch/edit/'.$id);
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
			redirect('master_branch');
		}
        
         $config = array(
            'base_url'          => site_url('master_branch/search/'),
            'total_rows'        => $this->master_branchs->count_all_search(),
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
        $data['master_branchs']       = $this->master_branchs->get_search($config['per_page'], $this->uri->segment(3)); 
		$this->session->unset_userdata('keyword');
	 
		
        $this->load->view('template/v_header');
		$this->load->view('master_branch/view',$data);
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
            $this->master_branchs->destroy($id);           
             $this->session->set_flashdata('message', 'Data berhasil di hapus');
             redirect('master_branch');
        } 
        else 
        {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect('master_branch');
        }       
    }
    function kva_select(){
       
        //echo 'bug=';
        $kva      = $this->master_branchs->get_utilitieskva_all('');        
        
        $result['items']= $kva;
			 // echo 'bug = ' . $where;
		//echo  var_dump($result['items']);exit;      
        echo json_encode($result);
    }

	function controler_gridlistrik(){
        $arcari=$this->globalsearch_listrik();
        $vResult=$this->initialize_grid("qry_alldatalistrik","qry_filteredlistrik","qry_totalalllistrik",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            
            $id=$aRow['utilitieslistrik_id'];
            $row[]=$aRow['utilitieslistrik_id'];
            $row[]=$aRow['utilitieslistrik_name'];
			$row[]=$aRow['utilitieslistrik_amp'];
			$row[]=$aRow['utilitieslistrik_phase'];
			$row[]=$aRow['utilitieslistrik_kva'];
			$row[]=$aRow['utilitieslistrik_faktor'];
			$row[]=$aRow['utilitieslistrik_issingglemeter'];
			$row[]=$aRow['utilitieslistrik_isadditional'];
			$row[]=$aRow['utilitieslistrik_admpercent'];
			$row[]=$aRow['utilitieslistrik_admamount'];
			$row[]=$aRow['utilitieslistrik_bpju'];
			$row[]=$aRow['utilitieskva_name'];
			$row[]=$aRow['tariflwbp_calcbyuser'];
			$row[]=$aRow['tarifwbp_calcbyuser'];
			$row[]=$aRow['selisih_calcbyuser'];
			$row[]=$aRow['selisihlwbp_calcbyuser'];
			$row[]=$aRow['selisihwbp_calcbyuser'];
			$row[]=$aRow['pemakaianwbp_calcbyuser'];
			$row[]=$aRow['pemakaianlwbp_calcbyuser'];
			$row[]=$aRow['utilitieslistrik_isgenset'];
			$row[]=$aRow['utilitieslistrik_isblocked'];
			$row[]=$aRow['utilitieslistrik_isdisabled'];
			$row[]=$aRow['utilitieskva_id'];


            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }
	function controler_gridair(){
        $arcari=$this->globalsearch_air();
        $vResult=$this->initialize_grid("qry_alldataair","qry_filteredair","qry_totalallair",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            
            $id=$aRow['utilitiesair_id'];
            $row[]=$aRow['utilitiesair_id'];
            $row[]=$aRow['utilitiesair_name'];			
			$row[]=$aRow['utilitiesair_diameterpipa'];
			$row[]=$aRow['utilitiesair_adm'];
			$row[]=$aRow['utilitiesair_phairkotor'];
			$row[]=$aRow['utilitiesair_phmeter'];
			$row[]=$aRow['utilitiesair_isadditional'];
			$row[]=$aRow['phairkotor_isdisabled'];
			$row[]=$aRow['utilitiesair_admpercent'];
			$row[]=$aRow['utilitiesair_abonemen'];
			$row[]=$aRow['utilitiesair_isusedawalakhir'];
			$row[]=$aRow['utilitiesair_isdisabled'];
			


            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }
	function controler_gridgas(){
        $arcari=$this->globalsearch_gas();
        $vResult=$this->initialize_grid("qry_alldatagas","qry_filteredgas","qry_totalallgas",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            
            $id=$aRow['utilitiesgas_id'];
            $row[]=$aRow['utilitiesgas_id'];
            $row[]=$aRow['utilitiesgas_name'];			
			$row[]=$aRow['utilitiesgas_diameterpipa'];
			$row[]=$aRow['utilitiesgas_adm'];
			$row[]=$aRow['utilitiesgas_phairkotor'];
			$row[]=$aRow['utilitiesgas_phmeter'];
			$row[]=$aRow['utilitiesgas_isadditional'];
			$row[]=$aRow['utilitiesgas_tarif'];
			$row[]=$aRow['utilitiesgas_mfaktor'];
			$row[]=$aRow['utilitiesgas_pressure'];
			$row[]=$aRow['utilitiesgas_admpercent'];
			$row[]=$aRow['utilitiesgas_isusedawalakhir'];
			$row[]=$aRow['utilitiesgas_isdisabled'];
			


            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }
    function globalsearch_listrik(){
        $arcari=array('utilitieslistrik_id', 'utilitieslistrik_name');
        return $arcari;
    }
	function globalsearch_air(){
        $arcari=array('utilitiesair_id', 'utilitiesair_name');
        return $arcari;
    }
	function globalsearch_gas(){
        $arcari=array('utilitiesgas_id', 'utilitiesgas_name');
        return $arcari;
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
		
		$rResult=$this->master_branchs->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->master_branchs->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->master_branchs->$qry_totalall();
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
