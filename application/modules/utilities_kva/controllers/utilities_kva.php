<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utilities_kva extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_utilities_kva');
		$this->load->library('breadcrumbcomponent');
    }
    
	function index(){       
        redirect('utilities_kva/utilities_kva_list');
    }
    function globalsearch_dialog(){
		$arcari=array('schedulebooking_id','invoice_id');
		return $arcari;
	}
	function globalsearch_list(){
		$arcari=array('utilitieskva_id', 'utilitieskva_name', 'utilitieskva_tariflwbp','utilitieskva_tarifwbp');
		return $arcari;
	}
	function initialize_grid($qry_alldata,$qry_filtered,$qry_totalall,$arcari){
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

    $rResult=$this->model_utilities_kva->$qry_alldata($limit,$top,$sWhere);
   
	$rResultCnt =$this->model_utilities_kva->$qry_filtered($sWhere);
	$iFilteredTotal = $rResultCnt['jml'];

	$rResultTotal =$this->model_utilities_kva->$qry_totalall();
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
	
function controler_gridlist(){
	$arcari=$this->globalsearch_list();
	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari);
	$rResult=$vResult['rResult'];
	$output=$vResult['output'];

	foreach ($rResult as $aRow) {
		$action='
		<a href="/index.php/utilities_kva/utilities_kva_edit/'.$aRow['utilitieskva_id'].'" data-toggle="tooltip" title="Edit">
		<img border="0" src="/assets/img/edit.png" width="21" height="21"></a>
		<a href="/index.php/utilities_kva/utilities_kva_delete/'.$aRow['utilitieskva_id'].'" data-toggle="tooltip" title="Trash" onclick="return deleteid()">
		<img border="0" src="/assets/img/delete.png" width="21" height="21"></a>'; 
		
        $row = array();
				$row[]=$aRow['utilitieskva_id'];
                $row[]=$aRow['utilitieskva_name'];
				$row[]=$aRow['utilitieskva_tariflwbp'];
                $row[]=$aRow['utilitieskva_tarifwbp'];
                $row[]=$aRow['utilitieskva_createby'];
				$row[]=$aRow['utilitieskva_createdate'];
				$row[]=$aRow['utilitieskva_modifyby'];
                $row[]=$aRow['utilitieskva_modifydate'];
				$row[]=$action;
				
				/*'<a class="btn btn-sm btn-primary" href="/index.php/utilities_kva/utilities_kva_edit/'.$aRow['utilitieskva_id'].'" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a> 
				<a class="btn btn-sm btn-danger" href="/index.php/utilities_kva/utilities_kva_delete/'.$aRow['utilitieskva_id'].'" title="Hapus" onclick="return deleteid()"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
				*/
        if (!empty($row)) { $output['data'][] = $row; }
    	}   
    	echo json_encode($output);
		
}

    function utilities_kva_list(){
        
        $utilitieskva_id = $this->uri->segment(5);
        $data   = array(
                  'result'    => $this->model_utilities_kva->view_utilities_kva($utilitieskva_id),
                  'utilitieskva_id'   => $utilitieskva_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
		
		$this->breadcrumbcomponent->add('utilities_kva','utilities_kva/utilities_kva_list');

        $this->load->view('template/v_header');
        $this->load->view('utilities_kva/utilities_kva_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function utilities_kva_add()
	{		
        
        $utilitieskva_id = $this->uri->segment(3);
        
        $data   = array(
                  'result'    => $this->model_utilities_kva->view_utilities_kva($utilitieskva_id),
                  'utilitieskva_id'   => $utilitieskva_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();

  		$this->breadcrumbcomponent->add('Utilities kVA','utilities_kva/utilities_kva_list')
            ->add('Input Utilities kVA','utilities_kva/utilities_kva_add');


        $this->load->view('template/v_header');
        $this->load->view('utilities_kva/utilities_kva_add', $data);
        $this->load->view('template/v_footer');
	}
    
	
	  function utilities_kva_edit()
		{		
        
		$utilitieskva_id = $this->uri->segment(3);
		//print_r ($utilitieskva_id);
        $data   = array(
                  'result'    => $this->model_utilities_kva->view_utilities_kva($utilitieskva_id),
                  'utilitieskva_id'   => $utilitieskva_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();			
		
		$this->breadcrumbcomponent->add('Utilities kVA','utilities_kva/utilities_kva_list')
            ->add('Edit Utilities kVA','utilities_kva/utilities_kva_edit');

        $this->load->view('template/v_header');
        $this->load->view('utilities_kva/utilities_kva_edit', $data);
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
    
    function utilities_kva_insert(){        

        if ($_POST){
            
            $utilitieskva_id			= $this->input->post('utilitieskva_id');
            $utilitieskva_name      	= $this->input->post('utilitieskva_name');
            $utilitieskva_tariflwbp 	= $this->input->post('utilitieskva_tariflwbp');
            $utilitieskva_tarifwbp  	= $this->input->post('utilitieskva_tarifwbp');
            $utilitieskva_createby  	= $this->input->post('utilitieskva_createby');
            $utilitieskva_createdate	= $this->input->post('utilitieskva_createdate');
			$utilitieskva_modifyby		= $this->input->post('utilitieskva_modifyby');
			$utilitieskva_modifydate	= $this->input->post('utilitieskva_modifydate');
			//$rowid 	 					= $this->input->post('rowid');
	
			$idx=$this->model_utilities_kva->insert_utilities_kva($utilitieskva_id, $utilitieskva_name, $utilitieskva_tariflwbp, $utilitieskva_tarifwbp, $utilitieskva_createby, $utilitieskva_createdate,
				$utilitieskva_modifyby,$utilitieskva_modifydate);

			redirect("utilities_kva/utilities_kva_edit/".$idx);
        }
    }
  
    function utilities_kva_update(){

        if ($_POST){

			$utilitieskva_id			= $this->input->post('utilitieskva_id');
			$utilitieskva_name      	= $this->input->post('utilitieskva_name');
			$utilitieskva_tariflwbp 	= $this->input->post('utilitieskva_tariflwbp');
			$utilitieskva_tarifwbp  	= $this->input->post('utilitieskva_tarifwbp');
			$utilitieskva_createby  	= $this->input->post('utilitieskva_createby');
			$utilitieskva_createdate	= $this->input->post('utilitieskva_createdate');
			$utilitieskva_modifyby		= $this->input->post('utilitieskva_modifyby');
			$utilitieskva_modifydate	= $this->input->post('utilitieskva_modifydate');
			//$rowid 	 					= $this->input->post('rowid');
			

			$this->model_utilities_kva->update_utilities_kva($utilitieskva_id, $utilitieskva_name, $utilitieskva_tariflwbp, $utilitieskva_tarifwbp, $utilitieskva_createby, $utilitieskva_createdate,
				$utilitieskva_modifyby,$utilitieskva_modifydate);//,$rowid);
			
			redirect("utilities_kva/utilities_kva_edit/".$utilitieskva_id);
    	}
	}

	function utilities_kva_delete(){

		$_id = $this->uri->segment(3);
		$this->model_utilities_kva->delete_utilities_kva($_id);
		redirect("utilities_kva/utilities_kva_list");
	}
}  
