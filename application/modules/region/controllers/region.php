<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Region extends MX_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
		//print 'tes';
		//$this->brea        
		check_user_login();
        $this->load->model('model_region');
		$this->load->library('breadcrumbcomponent'); 
		//$this->load->library('form_validation'); 
		//print 'tes';
		//$this->breadcrumbcomponent->add('region','region');		
    }
     
	 
    public function index() 
    {
		redirect('region/region/regionlist');   
    }


	function globalsearch_list(){
		$arcari=array('region_id',  'CTE.region_name');
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
		
		$rResult=$this->model_region->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_region->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_region->$qry_totalall();
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


    function controler_gridlist($val_search = '',$val_serach_branch=''){
		$arcari=$this->globalsearch_list(); 
		$searchStatus = $val_search;
		
		
		$criteria = null; 

    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];
		//echo var_dump($rResult);exit;
    	foreach ($rResult as $aRow) {

            $i_link = $aRow['region_id'];
			$_menu='
				<a href="/index.php/region/region/regionedit/'.$i_link.'" data-toggle="tooltip" title="Edit">
				<img border="0" src="/assets/img/edit.png" width="21" height="21"></a>
				
				<a href="/index.php/region/region/regiondelete/'.$i_link.'" data-toggle="tooltip" title="Delete">
				<img border="0" src="/assets/img/delete.png" width="21" height="21"></a>
				
				';
            $row = array();

			$row[]=$aRow['region_id'];
			$row[]=$aRow['region_name'];
			$row[]=$aRow['region_nameshort'];
			$row[]=$aRow['region_address'];
			$row[]=$aRow['region_telp'];
			$row[]=$aRow['region_fax'];
			$row[]=$aRow['region_npwp'];
			$row[]=$aRow['region_bisnisunit'];
			$row[]=$aRow['region_extid'];
			$row[]=$aRow['region_signature'];
			$row[]=$_menu;
    	
            if (!empty($row)) { $output['data'][] = $row; }
		}   
		//echo var_dump($output);exit;
       echo json_encode($output);
    		
    }


    function region_select(){
        $this->load->model('template/Master_m');
        
        $region     = $this->Master_m->get_region();
        //$options    = array('' => 'Select an option');                
		
		$options ['']= 'Pilih Bussiniess Unit :';
        
        if(count($region)){
            foreach($region as $key => $value){
                $options[$value->region_id]= $value->region_name;
            }
        }
                    
        return $options;
	}    
	
    function branch_select(){

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];
        //$rRegion = empty($_GET['region']) ? '' : $_GET['region'];


        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            

            $this->load->model('template/Master_m');
            
            $branch      = $this->Master_m->get_branchbyall($rSearch['term']);
            
            $result['items']= $branch;
          
            echo json_encode($result);
            
        };
    }
	
	
    function Regionlist(){
        
		$region_id = $this->uri->segment(4);
		
        $data   = array(
                  'result'    => $this->model_region->viewregion($region_id),
                  'region_id'   => $region_id
            );        
        		
		$this->breadcrumbcomponent->add('Master Region','region/region/regionlist');

        $this->load->view('template/v_header');
        $this->load->view('region/region_list', $data);
        $this->load->view('template/v_footer');
    }
	


	function regionedit(){		
        
        $region_id = $this->uri->segment(4);       

        $data   = array(
                  'result'    => $this->model_region->viewregion($region_id),
                  'region_id'   => $region_id
            );                
        
			//echo var_dump($data); exit;
		$this->breadcrumbcomponent->add('Master Region','region/region/regionlist')
            ->add('Edit Master Region','region/region/regionedit');        

        $this->load->view('template/v_header');
        $this->load->view('region/region_edit', $data);
        $this->load->view('template/v_footer');
	}

	function regiondelete(){		
        
        $region_id = $this->uri->segment(4);       

        if ($region_id) {

			$this->model_region->deleteregion($region_id);

			redirect("region/region/regionlist");
		}
	}

    function region_edit(){
		if ($_POST) {

            $region_id          = $this->input->post('region_id');
            $region_name      	= $this->input->post('region_name');
			$region_nameshort	= $this->input->post('region_nameshort');
			$region_namereport	= $this->input->post('region_namereport');
			$region_telp		= $this->input->post('region_telp');
			$region_fax			= $this->input->post('region_fax');
			$region_address		= $this->input->post('region_address');
			$region_address_2	= $this->input->post('region_address_2'); 
			$region_bisnisunit	= $this->input->post('region_bisnisunit');
			$region_extid		= $this->input->post('region_extid');
			$region_npwp		= $this->input->post('region_npwp');
			$region_account		= $this->input->post('region_account');
			$region_pic			= $this->input->post('region_pic');
			$region_signature	= $this->input->post('region_signature');
			$region_senderinv	= $this->input->post('region_senderinv');
			$region_senderemail	= $this->input->post('region_senderemail');
			$region_isdisabled	= ($this->input->post('region_isdisabled') == '') ? 0 : $this->input->post('region_isdisabled');
			$region_isgroup		= ($this->input->post('region_isgroup') == '') ? 0 : $this->input->post('region_isgroup');
			
			$this->model_region->updateregion($region_id, $region_name, $region_nameshort,$region_namereport,$region_telp,$region_fax,$region_address,$region_address_2, $region_bisnisunit,$region_extid,$region_npwp,$region_account,$region_pic,$region_signature,$region_senderinv,$region_senderemail,$region_isdisabled,$region_isgroup);

			redirect("region/region/regionedit/".$region_id);
		}
    }
	
	
    function regionadd()
	{		
        
        $region_id = '';        
        
        $data   = array(
                  'result'    => $this->model_region->viewregion($region_id),
                  'region_id'   => $region_id
            );        
        
  		$this->breadcrumbcomponent->add('Master Region','region/region/regionlist')
            ->add('Input Master Region','region/region/regionadd');


        $this->load->view('template/v_header');
        $this->load->view('region/region_add', $data);
        $this->load->view('template/v_footer');
	}
    
	function region_add(){        

        if ($_POST){
            
            $region_id          = $this->input->post('region_id');
            $region_name      	= $this->input->post('region_name');
			$region_nameshort	= $this->input->post('region_nameshort');
			$region_namereport	= $this->input->post('region_namereport');
			$region_telp		= $this->input->post('region_telp');
			$region_fax			= $this->input->post('region_fax');
			$region_address		= $this->input->post('region_address');
			$region_address_2	= $this->input->post('region_address_2'); 
			$region_bisnisunit	= $this->input->post('region_bisnisunit');
			$region_extid		= $this->input->post('region_extid');
			$region_npwp		= $this->input->post('region_npwp');
			$region_account		= $this->input->post('region_account');
			$region_pic			= $this->input->post('region_pic');
			$region_signature	= $this->input->post('region_signature');
			$region_senderinv	= $this->input->post('region_senderinv');
			$region_senderemail	= $this->input->post('region_senderemail');
			$region_isdisabled	= ($this->input->post('region_isdisabled') == '') ? 0 : $this->input->post('region_isdisabled');
			$region_isgroup		= ($this->input->post('region_isgroup') == '') ? 0 : $this->input->post('region_isgroup');
						
			//$this->form_validation->set_rules('region_id', 'Business Unit', 'required');
			//$this->form_validation->set_rules('branch_id', 'Store', 'required'); 
			//$this->form_validation->set_rules('strukturunit_id', 'Struktur Unit', 'required'); 
			
			//if ($this->form_validation->run() == TRUE) { 
			$this->model_region->insertregion($region_id, $region_name, $region_nameshort,$region_namereport,$region_telp,$region_fax,$region_address,$region_address_2, $region_bisnisunit,$region_extid,$region_npwp,$region_account,$region_pic,$region_signature,$region_senderinv,$region_senderemail,$region_isdisabled,$region_isgroup);

			redirect("region/region/regionedit/".$region_id);
			//} else {
			//$this->regionadd();	
			//}
        }
	}
	

	function region_bybranch ($branch){

		$i_link = $this->uri->segment(3);       

		$branch = str_replace('_', '/', $i_link); 
		
		if($branch){
			$region      = $this->model_region->get_region_bybranch($branch);
            
			$result['region']= $region ;
		  
			echo json_encode($result);
	
		}else{
			echo json_encode('');
		}
		
	}
 
}  
