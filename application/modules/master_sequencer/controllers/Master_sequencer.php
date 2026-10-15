<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_sequencer extends MX_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
		//print 'tes';
		//$this->brea        
		check_user_login();
        $this->load->model('model_seq');
		$this->load->library('breadcrumbcomponent'); 
		//$this->load->library('form_validation'); 
		//print 'tes';
		//$this->breadcrumbcomponent->add('Setting','Setting');		
    }
     
	 
    public function index() 
    {
		redirect('sequencer/sequencer/sequencerlist');   
    }


	function globalsearch_list(){
		$arcari=array('channel_id',  'type');
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
		
		$rResult=$this->model_seq->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_seq->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_seq->$qry_totalall();
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

            $i_link = $aRow['channel_id'];
            $i_link2 = $aRow['type'];
			$_menu='
				<a href="/index.php/master_sequencer/settingedit/'.$i_link.'/'.$i_link2.'" data-toggle="tooltip" title="Edit">
				<img border="0" src="/assets/img/edit.png" width="21" height="21"></a>
				
				<a href="/index.php/master_sequencer/settingdelete/'.$i_link.'/'.$i_link2.'" data-toggle="tooltip" title="Delete">
				<img border="0" src="/assets/img/delete.png" width="21" height="21"></a>
				
				';
            $row = array();

			$row[]=$aRow['channel_id'];
			$row[]=$aRow['type'];
			$row[]=$aRow['lastid'];
			$row[]=$aRow['lastdate'];
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
	
	
    function sequencerlist(){
        
		$setting_id = $this->uri->segment(4);
		
        $data   = array(
                  'result'    => $this->model_seq->viewsetting($setting_id),
                  'setting_id'   => $setting_id
            );        
        		
		$this->breadcrumbcomponent->add('Master Sequencer','master_sequencer/sequencerlist');

        $this->load->view('template/v_header');
        $this->load->view('master_sequencer/setting_list', $data);
        $this->load->view('template/v_footer');
    }
	


	function settingedit(){		
        
        $setting_id = $this->uri->segment(3);       
        $setting_type = $this->uri->segment(4);       

        $data   = array(
                  'result'    => $this->model_seq->viewsetting($setting_id,$setting_type),
                  'setting_id'   => $setting_id,
                  'setting_type'   => $setting_type,
            );                
        
			//echo var_dump($data); exit;
		$this->breadcrumbcomponent->add('Master Sequencer','sequencer/sequencer/sequencerlist')
            ->add('Edit Master Sequencer','sequencer/sequencer/settingedit');        

        $this->load->view('template/v_header');
        $this->load->view('master_sequencer/setting_edit', $data);
        $this->load->view('template/v_footer');
	}

	function settingdelete(){		
        
        $setting_id = $this->uri->segment(3);       
        $type = $this->uri->segment(4);       

        if ($setting_id) {

			$this->model_seq->deletesetting($setting_id,$type);

			redirect("master_sequencer/sequencerlist");
		}
	}

    function setting_edit(){

		if ($_POST) {

		   $setting_id           = $this->input->post('channel_id');
            $type      = $this->input->post('type'); 
            $lastid      = $this->input->post('lastid'); 
			
			$this->model_seq->updatesetting($setting_id, $type,$lastid); 

			redirect("master_sequencer/settingedit/".$setting_id."/".$type);
		}
    }
	
	
    function settingadd()
	{		
        
        $setting_id = '';        
        
        $data   = array(
                  'result'    => $this->model_seq->viewsetting($setting_id),
                  'setting_id'   => $setting_id
            );        
        
  		$this->breadcrumbcomponent->add('Master Sequencer','sequencer/sequencer/sequencerlist')
            ->add('Input Master Sequencer','sequencer/sequencer/settingadd');


        $this->load->view('template/v_header');
        $this->load->view('master_sequencer/setting_add', $data);
        $this->load->view('template/v_footer');
	}
    
	function setting_add(){        

        if ($_POST){
            
            $setting_id           = $this->input->post('channel_id');
            $type      = $this->input->post('type'); 
            $lastid      = $this->input->post('lastid'); 
          
			//if ($this->form_validation->run() == TRUE) { 
			$this->model_seq->insertsetting($setting_id, $type,$lastid);

			redirect("master_sequencer/settingedit/".$setting_id."/".$type);
			//} else {
			//$this->settingadd();	
			//}
        }
	}
	

	function region_bybranch ($branch){

		$i_link = $this->uri->segment(3);       

		$branch = str_replace('_', '/', $i_link); 
		
		if($branch){
			$region      = $this->model_seq->get_region_bybranch($branch);
            
			$result['region']= $region ;
		  
			echo json_encode($result);
	
		}else{
			echo json_encode('');
		}
		
	}
 
}  
