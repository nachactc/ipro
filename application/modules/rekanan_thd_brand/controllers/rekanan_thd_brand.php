<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
 

class Rekanan_thd_brand extends MX_Controller
{

    public function __construct() 
    {
       parent::__construct(); 
		check_user_login(); 
        $this->load->model('rekananshipping_model');
		$this->load->library('breadcrumbcomponent');  
		$this->load->helper('form');
    }
    
	public function test()
	{
		$branch_id = '0000603';
		$region_id = '1050097'; 
		$this->master_rekananshippings->getDebtorCode($branch_id,$region_id);
	}
    // /**
    // * List all data rekanan_utilities_brand
    // *
    // */
    // public function  index($id) 
    // { 
        // $data['number']         = (int)$this->uri->segment(3) +1;
        // $data['master_rekananshippings']       = $this->master_rekananshippings->get_one($id);
        // $this->template->render('rekanan_utilities_brand/view',$data);
		 
		// echo print_r($data);
		// return $data;
	      
    // }
	/**
    * List all data rekanan_utilities_brand
    *
    */
    public function  get_index($id) 
    { 
         
       $data =  $this->rekananshipping_model->get_one($id);
        
		 
		//echo print_r($data);
		return $data;
	      
    }

    

    /**
    * Call Form to Add  New rekanan_utilities_brand
    *
    */
    public function add($rekanan_id) 
    {       
        $data['rekanan_thd_brand'] = $this->rekananshipping_model->add();
        $data['action']  = 'rekanan_thd_brand/save/'.$rekanan_id.'/0'; 
        $data['combo_branch'] = $this->rekananshipping_model->combo_branch(); 
        $data['combo_shippingtype'] = $this->rekananshipping_model->combo_shipping_type(); 
		$line_ = $this->rekananshipping_model->get_line($rekanan_id);
		//$line_ = $line_ == '' ? 10 : $line_ + 10; 
		$data['line'] =$line_;
		$data['id_rekanan'] =$rekanan_id;
		$data['listriktype'] = $this->listriktype_select();
        $this->load->view('rekanan_thd_brand/form',$data);

    }

    

    /**
    * Call Form to Modify rekanan_utilities_brand
    *
    */
    public function edit($rekanan_id,$rekananshipping_line) 
    {
		
        if ($rekanan_id != '' || $rekananshipping_line != 0 ) 
        {

            $data['rekanan_thd_brand']      = $this->rekananshipping_model->get_one_edit($rekanan_id,$rekananshipping_line);
		
            $data['action']       = 'save/' . $rekanan_id.'/'.$rekananshipping_line; 
            $data['combo_branch'] = $this->rekananshipping_model->combo_branch();  
			$data['combo_shippingtype'] = $this->rekananshipping_model->combo_shipping_type(); 
			$data['line'] = $rekananshipping_line;
			$data['id_rekanan'] =$rekanan_id;
			$branchid = $data['rekanan_thd_brand']['branch_id'];
			 
			//$data['branch_air']      = $this->master_rekananshippings->get_branch_air($branchid);
			
            $data['thdcat'] = $this->rekananshipping_model->combo_thd_cat(); 
			$data['thdtype'] = $this->rekananshipping_model->combo_thd_type();
			$data['thdgroup'] = $this->rekananshipping_model->combo_thd_group();
			$data['thdlt'] = $this->rekananshipping_model->combo_thd_lt();
			//echo $branchid; exit;
			//echo  var_dump($data['utilities_listrik']);exit;  
			
            $this->load->view('rekanan_thd_brand/form',$data);
        }
        else 
        {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('rekanan_thd/edit/'.$id));
        }
    }


    
    /**
    * Save & Update data  rekanan_utilities_brand
    *
    */
    public function save($rekanan_id,$rekananshipping_line) 
    {
		 // echo "<pre>";
         // echo print_r($_POST);
         // echo "</pre>";
		 // exit;
		 //echo 'bug - '.var_dump($this->input->post('rekananutilitiesgas_isadditional'));exit;
				
		$cek_line = $this->input->post('rekananshipping_line');
		
		$rekananshipping_line = $cek_line == 0 ? 0 : $rekananshipping_line;

        $this->rekananshipping_model->save($rekanan_id, $rekananshipping_line);
        $this->session->set_flashdata('message', 'Data Brand berhasil di simpan');
        redirect('rekanan_thd/rekanan_shipping_edit/'.$rekanan_id.'/'.$rekananshipping_line);
                   
        // if id NULL then add new data
		 
		
        if(!$rekanan_id || $rekananshipping_line == 0   )
        {   
                  
				  $branch_id = strip_tags($this->input->post('branch_id', TRUE));
				 
				  if($branch_id == '')
				  {
					  
					$this->session->set_flashdata('message', 'Data Gagal di simpan,Branch Harus Dipilih!');
					redirect('rekanan_utilities/edit/'.$rekanan_id);
				  }
				  else
				  {
					 if ($this->input->post()) 
                      {
                          
                          $this->master_rekananshippings->save($rekanan_id);
                          $this->session->set_flashdata('message', 'Data Brand berhasil di simpan');
                         // redirect('rekanan_utilities/edit/'.$rekanan_id); 
                          redirect('rekanan_utilities/rekanan_shipping_edit/'.$rekanan_id.'/'.$rekananshipping_line);
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
                        $this->rekananshipping_model->update($rekanan_id,$rekananshipping_line);
                        $this->session->set_flashdata('message', 'Data Rekanan THD berhasil di update');                        
						 redirect('rekanan_thd/rekanan_shipping_edit/'.$rekanan_id.'/'.$rekananshipping_line);
                    } 
					else // If validation incorrect 
					{
						$this->edit($rekanan_id,$rekananshipping_line);
					}
         }
    }

    
    
    /**
    * Detail rekanan_utilities_brand
    *
    */
    public function show($id='') 
    {
        if ($id != '') 
        {

            $data['rekanan_utilities_brand'] = $this->master_rekananshippings->get_one($id);            
            $this->template->render('rekanan_utilities_brand/_show',$data);
            
        }
        else 
        {
            $this->session->set_flashdata('notif', notify('Data tidak ditemukan','info'));
            redirect(site_url('rekanan_utilities_brand'));
        }
    }
    
    
    /**
    * Search rekanan_utilities_brand like ""
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
            'base_url'          => site_url('rekanan_utilities_brand/search/'),
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
       
        $this->template->render('rekanan_utilities_brand/view',$data);
    }
    
    
    /**
    * Delete rekanan_utilities_brand by ID
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
	function kva_select(){
       
        //echo 'bug=';
        $kva      = $this->master_rekananshippings->get_utilitieskva_all('');        
        
        $result['items']= $kva;
			 // echo 'bug = ' . $where;
		//echo  var_dump($result['items']);exit;      
        echo json_encode($result);
    }
	
	function branch_air(){
        
        $id = empty($_GET['id']) ? '' : $_GET['id'];

        $id = trim($id);

        if ($id == 'auto'){ $id = ''; }            

        //$datatables = $_POST;        
        $rResult = $this->master_rekananshippings->get_branch_air($id);        
		$row = array();  
		$output =array();
        foreach ($rResult as $aRow) {

            $row = array();            
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

        
        } 
		if (!empty($row)) {$output['data'][] = $row; } else { $output['data'][] = $row; }
        echo json_encode($output);
    }
	
	function branch_gas(){
        
        $id = empty($_GET['id']) ? '' : $_GET['id'];

        $id = trim($id);

        if ($id == 'auto'){ $id = ''; }            

        //$datatables = $_POST;        
        $rResult = $this->master_rekananshippings->get_branch_gas($id);        
		$row = array();  
		$output =array();
        foreach ($rResult as $aRow) {

            $row = array();            
            $row[]=$aRow['utilitiesgas_id'];
            $row[]=$aRow['utilitiesgas_name'];
            $row[]=$aRow['utilitiesgas_diameterpipa'];
            $row[]=$aRow['utilitiesgas_adm'];
            $row[]=$aRow['utilitiesgas_admpercent'];
			$row[]=$aRow['utilitiesgas_phairkotor'];
            $row[]=$aRow['utilitiesgas_phmeter'];
            $row[]=$aRow['utilitiesgas_isadditional'];
            $row[]=$aRow['utilitiesgas_tarif'];
            $row[]=$aRow['utilitiesgas_mfaktor'];
			$row[]=$aRow['utilitiesgas_pressure'];			            
			$row[]=$aRow['utilitiesgas_isusedawalakhir'];
			$row[]=$aRow['utilitiesgas_isdisabled'];

         
        }   
		if (!empty($row)) {$output['data'][] = $row; } else { $output['data'][] = $row; }
        echo json_encode($output);
    }
	
	
	function branch_listrik($type){
        
        $id = empty($_GET['id']) ? '' : $_GET['id'];
        //$type = empty($_GET['type']) ? '' : $_GET['type'];

        $id = trim($id);

        if ($id == 'auto'){ $id = ''; }   
        //$datatables = $_POST;        
        $rResult = $this->master_rekananshippings->get_branch_listrik($id,$type);        
		// echo var_dump($rResult);
		$row = array();  
		$output =array();
        foreach ($rResult as $aRow) {  
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
			$row[]=$aRow['utilitieskva_id'];
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
			$row[]=$aRow['utilitieskva_name']; 
        }    
		if (!empty($row)) {$output['data'][] = $row; } else { $output['data'][] = $row; }
        echo json_encode($output);
    }
	
	 
	function listriktype_select(){                 

        $options    = array('' => '==Pilih=='); 
        
        $options[0] = '0';
        $options[1] = '1';
		$options[2] = '2';
                    
        return $options;
    }
	 
	function ComboList_select(){                 

        $options    = array('' => '==Pilih=='); 
        
        $options[0] = 'Tidak';
        $options[1] = 'Ya'; 
                    
        return $options;
    }

	function ComboListJson()
	{
		$data = array(
			'id' => '0',
			'name' => 'Ya',
		);
		$data2 = array( 
			'id' => '1',
			'name' => 'Tidak',
		);
		array_push($data,$data2);
		echo json_encode($data);
	}
}

?>
