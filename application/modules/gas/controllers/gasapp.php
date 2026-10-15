<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gasapp extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_gasapp');
		    $this->load->library('breadcrumbcomponent');
		    $this->load->library('form_validation');
    }
    
    function index(){       
        redirect('gas/gasapp/gasapplist');
    }

    function globalsearch_dialog(){
		    $arcari=array('unit_name', 'region_id', 'branch_id');
		  return $arcari;
	  }    

	  function globalsearch_rekanan(){
      	$arcari= array('rekanan_name','rekananshipping_name', 'branch_id');
      return $arcari;
    }

	function globalsearch_list(){
		$arcari=array('CTE.utilitiesairgas_id', 'CTE.region_id','CTE.branch_id', 'LDT.rekanan_id', 
        'LDT.rekananshipping_line', 'CTE.utilitiesairgas_createby');
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
					 //$sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;					
				}
			}
		}		
		 
		
		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
		$limit=$limit+$top;

		if ( $cariOptional <> '' ) {            
        	$sWhere = $sWhere <> '' ? $sWhere." AND ".$cariOptional : " WHERE ".$cariOptional;
    	}  

    	//print_r($sWhere);		
		$rResult=$this->model_gasapp->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_gasapp->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_gasapp->$qry_totalall();
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

		function controler_gridrek(){
        $arcari=$this->globalsearch_rekanan();

        $branch_id =  isset($_POST['f_date']) ? $_POST['f_date']: '' ;        

        $braSearch = $branch_id <> '' ? "SHIP.branch_id = '$branch_id' " : '';

        $optSearch = $braSearch;

        $vResult=$this->initialize_grid("qry_alldatapop","qry_filteredpop","qry_totalallpop",$arcari, $optSearch);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];        

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['rekanan_id'];
            $row[]= '';
            $row[]= $aRow['rekanan_id'];
            $row[]= $aRow['rekanan_name'];
            $row[]= $aRow['rekananshipping_line'];
            $row[]= $aRow['rekananshipping_name'];
            $row[]= $aRow['debtor_no'];

            if (!empty($row)) { $output['data'][] = $row; }
        }   
    	echo json_encode($output);
            
    }

    function controler_gridapplist($val_search = ''){

  			$arcari=$this->globalsearch_list();						
      	$val_search = 'utilitiesairgasdetil_isposted = 0';

      	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari, $val_search);
      	$rResult=$vResult['rResult'];
      	$output=$vResult['output'];

    	  foreach ($rResult as $aRow) {            
      
            $_menu='
                <a href="/index.php/listrik/listrik/listrikedit/'.$aRow['utilitiesairgas_id'].'" data-toggle="tooltip" title="Edit">
                <i class="fa fa-edit fa-lg"></i></a>
                <a href="/index.php/listrik/listrik/laprint5pdf/'.$aRow['utilitiesairgas_id'].'" data-toggle="tooltip" title="Edit" target="_blank">
                <i class="fa fa-print fa-lg"></i></a>';

            if (!empty($aRow['utilitiesairgasdetil_link'])){
                $_link = '<a href='.("/assets/uploads/".$aRow['utilitiesairgasdetil_link']).' target="_blank"><i class="fa fa-file-text-o"></i> Download</a>';
            }else{
                $_link = '';
            }

            $row = array();
            $row[]= '';
			      $row[]= $aRow['utilitiesairgas_id'];
            $row[]= $aRow['utilitiesairgasdetil_line'];
            $row[]= date("d/m/Y", strtotime($aRow['utilitiesairgas_date']));            
            $row[]= $aRow['region_name'];
            $row[]= $aRow['branch_name'];
            $row[]= $aRow['rekanan_name'];
            $row[]= $aRow['rekananshipping_name'];
            $row[]= number_format($aRow['utilitiesairgasdetil_standakhir'],2);
            $row[]= number_format($aRow['utilitiesairgasdetil_pemakaian'],2);
            $row[]= number_format($aRow['utilitiesairgasdetil_pemakaianlalu'],2);
            $row[]= number_format($aRow['utilitiesairgasdetil_pemakaianavg'],2);
            $row[]= number_format($aRow['utilitiesairgasdetil_total'],2);
            $row[]= $_link;
						$row[]= $_menu;
    	
            if (!empty($row)) { $output['data'][] = $row; }
        }   
      echo json_encode($output);
    		
    }

         
    function gasapplist(){
        
        $utilitiesairgas_id = $this->uri->segment(4);
        $data   = array(
                  'utilitiesairgas_id'     => $utilitiesairgas_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
		
		    $this->breadcrumbcomponent->add('Utilities Gas Posting','gas/gasapplist');

        $this->load->view('template/v_header');
        $this->load->view('gas/gas_applist', $data);
        $this->load->view('template/v_footer');
    }    
    
    function region_select(){
        $this->load->model('template/Master_m');
        
        $region     = $this->Master_m->get_region();
        //$options    = array('' => 'Select an option');                
        
        if(count($region)){
            foreach($region as $key => $value){
                $options[$value->region_id]= $value->region_name;
            }
        }
                    
        return $options;
    }
    
    function branch_select(){

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];

        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            
            
            $branch      = $this->model_listrikapp->get_branchbyall($rSearch['term']);
            
            $result['items']= $branch;
          
            echo json_encode($result);
            
        };
    }

    function periode_select(){       

        $period = $this->model_listrik->get_openperiode();

        $result['items']= $period;
                    
        echo json_encode($result);
    }    

    function gasapp_app(){

        if ($_POST){
           $_APP = empty($_POST['postid']) ? '' : $_POST['postid'];         
        }        

        $type = 'username';        

        $username   = $this->session->userdata('username');  
        $channel_id = $this->session->userdata('channel_id');             
            
        if ($this->model_gasapp->postinggas($_APP, $username, $channel_id, 1))
        {                    

            $result['success'] = TRUE;
            $result['data'] = array('id' => $_APP[0]['id']);
            echo json_encode($result);
        }else{
            $result['success'] = FALSE;     
            $result['data'] = array('id' => $_APP[0]['id']);
            echo json_encode($result);  
        }
        
    } 
    
}  