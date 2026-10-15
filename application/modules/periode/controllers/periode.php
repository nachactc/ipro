<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Periode extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_periode');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('breadcrumbcomponent');
    }
    
    function index(){       
        redirect('periode/periode/periodelist');
    }
    function globalsearch_dialog(){
		$arcari=array('schedulebooking_id','invoice_id');
		return $arcari;
	}
	function globalsearch_list(){
		$arcari=array('periode_id', 'periode_name');
		// $arcari=array('a.periode_id', 'a.periode_name', 'a.region_id','BRANCH.branch_name','refid','rekanan','brand');
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
	 
    $top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
    $limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
	$limit=$limit+$top;

	$b =  $cariOptional <> '' ?  $sWhere == '' ? " WHERE ".$cariOptional : " AND ".$cariOptional  : '' ; 
	$sWhere = $sWhere.$b;
	//echo $sWhere;
    $rResult=$this->model_periode->$qry_alldata($limit,$top,$sWhere);
   
	$rResultCnt =$this->model_periode->$qry_filtered($sWhere);
	$iFilteredTotal = $rResultCnt['jml'];

	$rResultTotal =$this->model_periode->$qry_totalall();
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


	function controler_griddialog(){
	$arcari=$this->globalsearch_dialog();
	$vResult=$this->initialize_grid("qry_alldatadialog","qry_filtereddialog","qry_totalalldialog",$arcari);
	$rResult=$vResult['rResult'];
	$output=$vResult['output'];
	foreach ($rResult as $aRow) {
        $row = array();
		$id=$aRow['schedulebooking_id'];
                $row[]=$aRow['schedulebooking_id'];
				$row[]=$aRow['schedulebookingdetil_line'];
				$row[]=$aRow['schedulebookingdetil_amount'];
				$row[]=$aRow['invoice_id'];

        if (!empty($row)) { $output['data'][] = $row; }
    	}   
    	echo json_encode($output);
		
}
	
	function cek_status()
	{
		$a = $this->model_periode->cek_periode_status('03000004060601');
		echo $a;
	}
	
	function controler_gridlist($val_search = '',$val_serach_branch=''){
	$arcari=$this->globalsearch_list();
	
	$searchStatus = $val_search;
		// echo $searchStatus;
		// exit;
		
		$criteria = null;  
	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari, $criteria);
	$rResult=$vResult['rResult'];
	$output=$vResult['output'];	
	foreach ($rResult as $aRow) {
		
	 
        $row = array();
				$row[]=$aRow['periode_id'];
                $row[]=$aRow['periode_name'];
				$row[]=date('d-m-Y',strtotime($aRow['periode_datestart']));
				$row[]=date('d-m-Y',strtotime($aRow['periode_dateend'])); 
                $row[]=($aRow['periode_isclosed'] == 0) ? '<i class="glyphicon glyphicon glyphicon-unchecked"></i>':' <i class="glyphicon glyphicon glyphicon-ok"></i>';
				$row[]=date('d-m-Y',strtotime($aRow['periode_createdate'])); 		
				$row[]=$aRow['periode_createby']; 				
				$row[]=' <a class="btn btn-sm btn-primary" href="/index.php/periode/periode/periodeedit/'.$aRow['periode_id'].'" title="Edit" ><i class="glyphicon glyphicon-pencil"></i> </a> 
				<a class="btn btn-sm btn-danger"  href="/index.php/periode/periode/periode_delete/'.$aRow['periode_id'].'" title="Hapus" onclick="return deleteid()"><i class="glyphicon glyphicon-trash"></i> </a>';
				
        if (!empty($row)) { $output['data'][] = $row; }
    	}   
    	echo json_encode($output);
		
}

    function periodelist(){
        
        $periode_id = $this->uri->segment(5);
        $data   = array(
                  'result'    => $this->model_periode->viewperiode($periode_id),
                  'periode_id'   => $periode_id
            );        
         
		$this->breadcrumbcomponent->add('Periode','periode/periodelist');

        $this->load->view('template/v_header');
        $this->load->view('periode/periode_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function periodeadd()
	{		
        
        $periode_id = $this->uri->segment(4);
        
        $data   = array(
                  'result'    => $this->model_periode->viewperiode($periode_id),
                  'periode_id'   => $periode_id
            );         

  		$this->breadcrumbcomponent->add('Unit','periode/periode/periodelist')
            ->add('Input Unit','periode/periode/periodeadd');


        $this->load->view('template/v_header');
        $this->load->view('periode/periode_add', $data);
        $this->load->view('template/v_footer');
	}
     
	function periodeedit()
	{		
        
        $periode_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_periode->viewperiode($periode_id),
                  'periode_id'   => $periode_id
            );         
		
		$this->breadcrumbcomponent->add('Periode','periode/periode/periodelist')
            ->add('Edit Periode','periode/periode/periodeedit');

        $this->load->view('template/v_header');
        $this->load->view('periode/periode_edit', $data);
        $this->load->view('template/v_footer');
	}
    
    function region_select(){
        $this->load->model('template/Master_m');
        
        $region      = $this->Master_m->get_region();
        $options    = "";                
        
        if(count($region)){
            foreach($region as $key => $value){
                $options[$value->region_id]= $value->region_name;
            }
        }
                    
        return $options;
    }
    
    function branch_select(){
        $this->load->model('template/Master_m');    
        $branch     = $this->Master_m->get_branch();
        $options    = "";                
        
        if(count($branch)){
            foreach($branch as $key => $value){
                $options[$value->branch_id]= $value->branch_name;
            }
        }
                    
        return $options;
    }
	
	function floor_select(){
        $branch     = $this->model_periode->get_floor();
        $options    = "";                
        
        if(count($branch)){
            foreach($branch as $key => $value){
                $options[$value->lantai_id]= $value->lantai_name;
            }
        }
                    
        return $options;
    }
	
	function periodetype_select(){
        $branch     = $this->model_periode->get_periodetype();
        $options    = "";                
        
        if(count($branch)){
            foreach($branch as $key => $value){
                $options[$value->periodetype_id]= $value->periodetype_name;
            }
        }
                    
        return $options;
    }
    
    function collection_add(){        

        if ($_POST){
            
            $coll_id=$this->input->post('tline');
            $coll_date      =$this->input->post('coll_date');
            $descr     = $this->input->post('descr');
            $region         = $this->input->post('cboregion');
            $branch         = $this->input->post('cbobranch');
            $_createby       = $this->input->post('_createby');
			$_modifyby	  = $this->input->post('_modifyby');
			$coll_line	  =$this->input->post('tline');
			$coll_descr 	 =$this->input->post('tdescription');
			$coll_amount	=$this->input->post('tamount');
			$ref_id		 =$this->input->post('spid');
			$ref_line	   =$this->input->post('trline');
	
	$idx=$this->model_collection->insertcollection($coll_date, $descr, $_createby, $_modifyby, $region, $branch,
	$coll_line,$coll_descr,$coll_amount,$ref_id,$ref_line);

	redirect("accounting/modcollection/collection/collectionlist");
        }
    }
  
    function periode_edit(){
		 
		$this->model_periode->updateperiode();
        
		redirect("periode/periode/periodelist");
    }
	
	function saveperiode(){
		  
		$this->form_validation->set_rules('periode_name', 'Unit Name', 'required');
		$this->form_validation->set_rules('periode_id', 'Periode ID', 'required');
		
		// echo "<pre/>";
		// echo var_dump($this->input->post('periode_isclosed'));
		// exit;
		
		if ($this->form_validation->run() == TRUE)
		{
			 
			$this->model_periode->saveperiode();   
			//echo var_dump($_POST);
			//exit;			
			redirect("periode/periode/periodelist");
		}
		else
		{
			$this->periodeadd();
		}
		
            
    }
	 
	function periode_delete(){
		 
		$_id = $this->uri->segment(4);
		// echo $_id;
		// exit;
		$this->model_periode->deleteperiode($_id);
		redirect("periode/periode/periodelist");
	}

	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_loo_cl->get_branch_dlg($rSearch['term']);
	    $result['items']= $branch; 
        echo json_encode($result);
    }
}  