<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utilities_airgas extends MX_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
		//print 'tes';
		//$this->brea        
		check_user_login();
        $this->load->model('model_utilities_airgas');
		$this->load->library('breadcrumbcomponent'); 
		//$this->load->library('form_validation'); 
		//print 'tes';
		//$this->breadcrumbcomponent->add('User','user');		
    }
     
	 
    public function index() 
    {
		redirect('utilities_airgas/utilities_airgas/utilitiesairgaslist');   
    }


	function globalsearch_list(){
		$arcari=array('utilitiesairgas_name',  'utilitiesairgas_number','utilitiesairgas_id');
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
		
		$rResult=$this->model_utilities_airgas->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_utilities_airgas->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_utilities_airgas->$qry_totalall();
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
/*		
		if($searchStatus == 'app')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.isapproved = 1";
			}
			else
			{
				$criteria =  " CTE.isapproved = 1";
			}
		}
		elseif($searchStatus == 'ret')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.isconfirm = 1";
			}
			else
			{
				$criteria =  " CTE.isconfirm = 1";
			}	
		} 
		elseif($searchStatus == 'not_app')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.isapproved = 0";
			}
			else
			{
				$criteria =  " CTE.isapproved = 0";
			}	
		}
		elseif($searchStatus == 'not_ret')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.isconfirm = 0";
			}
			else
			{
				$criteria =  " CTE.isconfirm = 0";
			}	
		} 
		elseif($searchStatus == 'all')
		{
			 $criteria = null ; 
		}
		elseif($searchStatus == 'k')
		{
			 $criteria = null ; 
		}
		if($val_serach_branch != '')
		{
			if($criteria != '')
			{
				$criteria = $criteria . " and CTE.branch_id = '$val_serach_branch'";
			}
			else
			{
				$criteria =	" CTE.branch_id = '$val_serach_branch'";
			}
		}
	*/	
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['utilitiesairgas_id']);
            //$ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
            //$is_post = ($aRow['isconfirm']) ? 1 : 0;
            //$is_post = ($aRow['isapproved']) ? 1 : 0;
			$_menu='
				<a href="/index.php/utilities_airgas/utilities_airgas/utilitiesairgasedit/'.$i_link.'" data-toggle="tooltip" title="Edit">
				<img border="0" src="/assets/img/edit.png" width="21" height="21"></a>
				<a href="/index.php/utilities_airgas/utilities_airgas/utilitiesairgasdelete/'.$i_link.'" data-toggle="tooltip" title="Delete">
				<img border="0" src="/assets/img/trash.png" width="21" height="21"></a>';


			/*
            if ($aRow['isapproved']) {
                $_menu='
                    <a href="/ipro/index.php/utilities_airgas/utilities_airgas/utilitiesairgasedit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                    <img border="0" src="/ipro/assets/img/edit.png" width="21" height="21"></a>
                    <a href="/ipro/index.php/looprint/looprint/looprintpdf/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
                    <img border="0" src="/ipro/assets/img/print.png" width="21" height="21"> </a>        
                    <a href="/ipro/index.php/looprint/looprint/invprintpdf/'.$i_link.'" data-toggle="tooltip" title="Invoice" target="_blank">
                    <img border="0" src="/ipro/assets/img/invoice.png" width="21" height="21"></a>
                    <a href="/ipro/index.php/loo/loo/loo_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
                    <img border="0" src="/ipro/assets/img/delete.png" width="21" height="21"></a>'; 

            } else {
                $_menu='
                    <a href="/ipro/index.php/loo/loo/looedit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                    <img border="0" src="/ipro/assets/img/edit.png" width="21" height="21"></a>
                    <a href="/ipro/index.php/looprint/looprint/looprintpdf/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
                    <img border="0" src="/ipro/assets/img/print.png" width="21" height="21"> </a>                    
                    <a href="/ipro/index.php/loo/loo/loo_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
                    <img border="0" src="/ipro/assets/img/delete.png" width="21" height="21"></a>';
            }*/

            $row = array();

			$row[]=$aRow['utilitiesairgas_id'];
			$row[]=$aRow['utilitiesairgas_number'];
			$row[]=$aRow['utilitiesairgas_name'];
			$row[]=$aRow['utilitiesairgas_type'];
			$row[]=$aRow['utilitiesairgas_spec'];
			$row[]=$aRow['utilitiesairgas_tarif'];
			$row[]=$aRow['utilitiesairgas_minvalue'];
			$row[]=$aRow['utilitiesairgas_maxvalue'];
			$row[]=$_menu;
    	
            if (!empty($row)) { $output['data'][] = $row; }
        	}   
        	echo json_encode($output);
    		
    }

	
    function utilitiesairgaslist(){
        
        $utilitiesairgas_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_utilities_airgas->viewutilitiesairgas($utilitiesairgas_id),
                  'utilitiesairgas_id'   => $utilitiesairgas_id
            );        
        
        //$data['region'] = $this->region_select();
        //$data['branch'] = $this->model_utilities_airgas->get_branch_list();
        //$data['strukturunit'] = $this->model_utilities_airgas->get_strukturunit_list();
		
		$this->breadcrumbcomponent->add('Utilities Air Gas','utilities_airgas/utilities_airgas/utilitiesairgaslist');

        $this->load->view('template/v_header');
        $this->load->view('utilities_airgas/utilities_airgas_list', $data);
        $this->load->view('template/v_footer');
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
	
	

	function utilitiesairgasedit(){		
        
        $i_link = $this->uri->segment(4);       

        $utilitiesairgas_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_utilities_airgas->viewutilitiesairgas($utilitiesairgas_id),
                  'utilitiesairgas_id'   => $utilitiesairgas_id
            );                
        
			$data['type'] = $this->model_utilities_airgas->get_utilities_type();

			$this->breadcrumbcomponent->add('Utilities Air Gas','utilities_airgas/utilities_airgas/utilitiesairgaslist')
            ->add('Edit Utilities Air Gas','utilities_airgas/utilities_airgas/utilitiesairgasedit');        

        $this->load->view('template/v_header');
        $this->load->view('utilities_airgas/utilities_airgas_edit', $data);
        $this->load->view('template/v_footer');
	}



    function utilitiesairgas_edit(){

            $utilitiesairgas_id           	= $this->input->post('utilitiesairgas_id');
            $utilitiesairgas_number      	= $this->input->post('utilitiesairgas_number');
            $utilitiesairgas_name      		= $this->input->post('utilitiesairgas_name');
			$utilitiesairgas_type    		= $this->input->post('utilitiesairgas_type') ;
			$utilitiesairgas_spec    		= $this->input->post('utilitiesairgas_spec');
			$utilitiesairgas_tarif    		= $this->input->post('utilitiesairgas_tarif');
			$utilitiesairgas_minvalue    	= $this->input->post('utilitiesairgas_minvalue');
			$utilitiesairgas_maxvalue    	= $this->input->post('utilitiesairgas_maxvalue');

			$this->model_utilities_airgas->updateutilitiesairgas($utilitiesairgas_id, $utilitiesairgas_number, $utilitiesairgas_name, $utilitiesairgas_type, $utilitiesairgas_spec, $utilitiesairgas_tarif, $utilitiesairgas_minvalue,$utilitiesairgas_maxvalue);

			redirect("utilities_airgas/utilities_airgas/utilitiesairgasedit/".$utilitiesairgas_id);
    }
	
	
    function utilitiesairgasadd()
	{		
        
        $utilitiesairgas_id = '';        
        
        $data   = array(
                  'result'    => $this->model_utilities_airgas->viewutilitiesairgas($utilitiesairgas_id),
                  'utilitiesairgas_id'   => $utilitiesairgas_id
        );        
        
		$data['type'] = $this->model_utilities_airgas->get_utilities_type();

  		$this->breadcrumbcomponent->add('Utilities Air Gas','utilities_airgas/utilities_airgas/utilitiesairgaslist')
            ->add('Input utilities Air Gas','utilities_airgas/utilities_airgas/utilitiesairgasadd');


        $this->load->view('template/v_header');
        $this->load->view('utilities_airgas/utilities_airgas_add', $data);
        $this->load->view('template/v_footer');
	}
    
	function utilitiesairgas_add(){        

        if ($_POST){
            
            $utilitiesairgas_id           	= $this->input->post('utilitiesairgas_id');
            $utilitiesairgas_number      	= $this->input->post('utilitiesairgas_number');
            $utilitiesairgas_name      		= $this->input->post('utilitiesairgas_name');
			$utilitiesairgas_type    		= $this->input->post('utilitiesairgas_type') ;
			$utilitiesairgas_spec    		= $this->input->post('utilitiesairgas_spec');
			$utilitiesairgas_tarif    		= $this->input->post('utilitiesairgas_tarif');
			$utilitiesairgas_minvalue    	= $this->input->post('utilitiesairgas_minvalue');
			$utilitiesairgas_maxvalue    	= $this->input->post('utilitiesairgas_maxvalue');
			
			//if ($this->form_validation->run() == TRUE) { 
			$this->model_utilities_airgas->insertutilitiesairgas($utilitiesairgas_id, $utilitiesairgas_number, $utilitiesairgas_name, $utilitiesairgas_type, $utilitiesairgas_spec, $utilitiesairgas_tarif, $utilitiesairgas_minvalue,$utilitiesairgas_maxvalue);

			redirect("utilities_airgas/utilities_airgas/utilitiesairgaslist");
			//} else {
			//$this->utilitiesairgasadd();	
			//}
        }
	}
	
	function utilitiesairgasdelete(){		
        
        $i_link = $this->uri->segment(4);       

        $utilitiesairgas_id = str_replace('_', '/', $i_link); 

		$this->model_utilities_airgas->deleteutilitiesairgas($utilitiesairgas_id);

		redirect("utilities_airgas/utilities_airgas/utilitiesairgaslist");
	}

	function region_bybranch ($branch){
		$i_link = $this->uri->segment(3);       

		$branch = str_replace('_', '/', $i_link); 
		
		if($branch){
			$region      = $this->model_utilities_airgas->get_region_bybranch($branch);
            
			$result['region']= $region ;
		  
			echo json_encode($result);
	
		}else{
			echo json_encode('');
		}
		
	}
 
}  
