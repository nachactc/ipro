<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Source_acc extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_sourceacc');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
    }
    
    function index(){       
        redirect('master_sourceacc/source_acc/source_acclist');
    }
    function globalsearch_dialog(){
		$arcari=array('unit_name', 'region_id', 'branch_id');
		return $arcari;
	}   
    function globalsearch_rekanan(){
        $arcari=array('rekanan_name','rekananshipping_name');
        return $arcari;
    }    
	
    function globalsearch_schema(){
        $arcari=array('unittype_id');
        return $arcari;
    }  
	
	function controler_griddialog(){
	$arcari=$this->globalsearch_dialog();
	$vResult=$this->initialize_grid("qry_alldatadialog","qry_filtereddialog","qry_totalalldialog",$arcari);
	$rResult=$vResult['rResult'];
	$output=$vResult['output'];

	foreach ($rResult as $aRow) {
        $row = array();
		$id=$aRow['unit_id'];
                $row[]=$aRow['unit_id'];
				$row[]=$aRow['unit_name'];
				$row[]=$aRow['unit_sqm'];
				$row[]=$aRow['lantai_name'];
                $row[]=$aRow['lantai_id'];

        if (!empty($row)) { $output['data'][] = $row; }
    	}   
    	echo json_encode($output);
		
}

    function controler_gridpop(){
        $arcari=$this->globalsearch_rekanan();
        $vResult=$this->initialize_grid("qry_alldatapop","qry_filteredpop","qry_totalallpop",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['rekanan_id'];
                    $row[]=$aRow['rekanan_id'];
                    $row[]=$aRow['rekanan_name'];
                    $row[]=$aRow['rekananshipping_line'];
                    $row[]=$aRow['rekananshipping_name'];
                    $row[]=$aRow['debtor_no'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }

    function controler_gridschema(){
        $arcari=$this->globalsearch_schema();
        $vResult=$this->initialize_grid("qry_alldataschema","qry_filteredschema","qry_totalallschema",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            
            $id=$aRow['skl_id'];
            $row[]=$aRow['skl_id'];
            $row[]=$aRow['skl_title'];
            $row[]=$aRow['skl_dp'];
            $row[]=$aRow['skl_inst'];
            $row[]=$aRow['skl_looterm'];
            $row[]=$aRow['skl_loiterm'];
            $row[]=$aRow['skl_rdep'];
            $row[]=$aRow['skl_scdep'];
            $row[]=$aRow['skl_islistrik'];
            $row[]=$aRow['skl_isair'];
            $row[]=$aRow['skl_isgas'];
            $row[]=$aRow['skl_istelp'];
            $row[]=$aRow['unittype_name'];
            $row[]=$aRow['skl_cp'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }
    
	function globalsearch_list(){
		$arcari=array('source_id',  'CTE.acc_id','D.acc_name');
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

		if($sWhere == '' AND $cariOptional != '')
		{
			$sWhere = 'WHERE '.$cariOptional;
		}
		else
		{
			$sWhere = $sWhere.$b;
		}
		//echo $sWhere;exit;
		$rResult=$this->model_sourceacc->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_sourceacc->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_sourceacc->$qry_totalall();
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

    function controler_gridlist($val_search = ''){
		$arcari=$this->globalsearch_list(); 
		$searchStatus = $val_search;
		
		
		$criteria = null; 
		if($searchStatus == 'app')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.source_acc_isdisabled = 1";
			}
			else
			{
				$criteria =  " CTE.source_acc_isdisabled = 1";
			}
		}
		elseif($searchStatus == 'ret')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.source_acc_isdisabled = 0";
			}
			else
			{
				$criteria =  " CTE.source_acc_isdisabled = 0";
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
		elseif($searchStatus == 'all')
		{
			 $criteria = null ; 
		}
		 
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['id_']); 
            $i_acc =  $aRow['acc_id']; 
			$url = base_url();  
			$_menu='
				<a href="/index.php/master_sourceacc/source_acc/source_acc_edit/'.$i_link.'" data-toggle="tooltip" title="Edit">
				<img border="0" src="/assets/img/edit.png" width="21" height="21"></a> 
				<a href="/index.php/master_sourceacc/source_acc/source_acc_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid(0)">
				<img border="0" src="/assets/img/delete.png" width="21" height="21"></a>';
             

            $row = array();

			$row[]=$aRow['source_id']; 
			$row[]=$aRow['acc_id'];
			$row[]=$aRow['acc_name'];
			$row[]=$aRow['dk'];    
			$row[]=$_menu;
    	
            if (!empty($row)) { $output['data'][] = $row; }
        	}   
        	echo json_encode($output);
    		
    }

    function source_acclist(){
        
        $source_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => '',
                  'source_id'   => $source_id
            );        
         
		
		$this->breadcrumbcomponent->add('Source Account','master_sourceacc/source_acc/source_acclist');

        $this->load->view('template/v_header');
        $this->load->view('master_sourceacc/source_acc_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function source_acc_add()
	{		
        
        $source_id = $this->uri->segment(4);        
          
  		$this->breadcrumbcomponent->add('Add Struktur Unit','master_sourceacc/source_acc/source_acc_add');
		$data = array( 
		);


        $this->load->view('template/v_header');
        $this->load->view('master_sourceacc/source_acc_add',$data);
        $this->load->view('template/v_footer');
	}
	
    function source_acc_edit()
	{		
        
        $id_ = $this->uri->segment(4);         
          
  		$this->breadcrumbcomponent->add('Edit Struktur Unit','master_sourceacc/source_acc/source_acc_edit');

		$data = array(
			'result' => $this->model_sourceacc->getoneprogram($id_) 
		);
        $this->load->view('template/v_header');
        $this->load->view('master_sourceacc/source_acc_edit',$data);
        $this->load->view('template/v_footer');
	}
    
	 
    function save(){        

        if ($_POST){
            
            $source_id        = $this->input->post('source_id');
            $acc_id           = $this->input->post('acc_id');
            $dk      		  = $this->input->post('dk');
            
			
			$this->form_validation->set_rules('source_id', 'Source Name', 'required');  
			
			if ($this->form_validation->run() == TRUE) { 
				$this->model_sourceacc->insertprogram($source_id, $acc_id, $dk); 
				redirect("master_sourceacc/source_acc/source_acclist");
			} else {
				$this->source_acc_add();	
			}
        }
    }
  
    function programedit(){        

        if ($_POST){
            
            $source_id        = $this->input->post('source_id');
            $acc_id           = $this->input->post('acc_id');
            $dk      		  = $this->input->post('dk');
            $id_      		  = $this->input->post('id_');
			
			$this->form_validation->set_rules('source_id', 'Source Name', 'required'); 
			
			if ($this->form_validation->run() == TRUE) { 
				$this->model_sourceacc->updateprogram($source_id, $acc_id, $dk, $id_); 
				redirect("master_sourceacc/source_acc/source_acclist");
			} else {
				$this->source_acc_add();	
			}
        }
    }
	
	function source_acc_delete(){
		
        $i_link = $this->uri->segment(4);       
        $i_acc = $this->uri->segment(5);       

        $_id = str_replace('_', '/', $i_link); 

		$this->model_sourceacc->deleteprogram($_id,$i_acc);
		redirect("master_sourceacc/source_acc/source_acclist");
	}
 
}  