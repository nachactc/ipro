<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Casualpost extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_casualpost');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
    }
    
    function index(){       
        redirect('agreement_posting/casualpost/casualpostlist');
    }
    function globalsearch_profit(){
		    $arcari=array('provitsharing_id', 'provitsharing_desc');
		  return $arcari;
	  }   
    function globalsearch_rekanan(){
        $arcari=array('rekanan_name','rekananshipping_name', 'branch_id');
      return $arcari;
    }    
    function globalsearch_new(){
        $arcari=array('s.loo_id', 's.region_id', 's.branch_id');
      return $arcari;
    }  
    function globalsearch_detil(){
        $arcari=array('loo_id');
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
    
	function globalsearch_list(){
		$arcari=array('agreement_id', 'CTE.region_id', 'CTE.branch_id', 'CTE.rekanan_id', 'CTE.rekananshipping_line', 
      'REGION.region_name', 'BRANCH.branch_name', 'REKAN.rekanan_name', 'BRAND.rekananshipping_name');
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

                if (isset($_POST['columns'][$i]['search']['regex']) && $_POST['columns'][$i]['search']['regex'] != "false") {            

                    $fields = explode(" ", $searchCol);

                    foreach ($fields as $string) {              
                    if ($sWhere != ''){             
                        $sWhere .= " OR (". $aColumns[$i] . " LIKE '%".$string."%')";
                    } else {
                        $sWhere = "WHERE (". $aColumns[$i] . " LIKE '%".$string."%')";
                    }              
                    }                      
                } elseif ($searchCol != '') {          

                    if ($sWhere != ''){             
                        $sWhere .= " AND ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
                    } else {
                        $sWhere = "WHERE ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
                    }					 					
                }
            }
		}
		 			
		
		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
		$limit=$limit+$top;

		if ( $cariOptional <> '' ) {            
        $sWhere = $sWhere <> '' ? $sWhere." AND ".$cariOptional : " WHERE ".$cariOptional;
        }
		
		$rResult=$this->model_casualpost->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_casualpost->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_casualpost->$qry_totalall();
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


    function controler_gridpostlist($val_search = ''){

		$arcari=$this->globalsearch_list(); 		  
		
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari, '');
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {

          $i_link = $aRow['agreement_id'];
          $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
          $is_post = ($aRow['agreement_isapproved']) ? 1 : 0;
          $is_post = ($aRow['agreement_isclosed']) ? 1 : 0;          
 
              $_menu='  <a href="/index.php/agreement_posting/casualprint/print_pdf/'.$i_link.'" data-toggle="tooltip" title="print" target="_blank">
                  <i class="fa fa-print fa-lg"></i></a> '; 

          $row = array();
          $row[]='';
		  $row[]=$aRow['agreement_id'];            
          $row[]=date("d-m-Y", strtotime($aRow['agreement_startdate']));
          $row[]=date("d-m-Y", strtotime($aRow['agreement_enddate']));
		  $row[]=number_format($aRow['agreement_tlv'], 2);
		  $row[]=$aRow['branch_name'];
          $row[]=$ship_name;
          $row[]=$aRow['rekananshipping_name'];
          $row[]=$aRow['agreement_isapproved'];
          $row[]=$aRow['agreement_isclosed'];            
		  $row[]=$_menu;
  	
          if (!empty($row)) { $output['data'][] = $row; }
      	}   
      	echo json_encode($output);
    		
    }

    function casualpostlist(){
        
        $agreement_id = $this->uri->segment(4);
        $data   = array(
                  'result'       => $this->model_casualpost->viewagreement($agreement_id),
                  'agreement_id' => $agreement_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
		
		$this->breadcrumbcomponent->add('Agreement Transaction Casual Posting','casualpost/casualpostlist');

        $this->load->view('template/v_header');
        $this->load->view('agreement_posting/casual_postlist', $data);
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
        //$rRegion = empty($_GET['region']) ? '' : $_GET['region'];

        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            

            $this->load->model('template/Master_m');
            
            $branch      = $this->Master_m->get_branchbyall($rSearch['term']);
            
            $result['items']= $branch;
          
            echo json_encode($result);
            
        };
    }   

    function tenant_select(){        

        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];
        $rBranch = empty($_GET['branch']) ? '' : $_GET['branch'];
        $is_Branch = empty($_GET['isBranch']) ? '' : $_GET['isBranch'];

        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            
            
            $tenant      = $this->model_casual->get_tenant($rSearch['term'], $rBranch, $is_Branch);
            
            $result['items']= $tenant;
          
            echo json_encode($result);
            
        };
    }

    function trade_select(){

        $rSearch    = empty($_GET['term']) ? '' : $_GET['term'];
        $rBranch    = empty($_GET['branch']) ? '' : $_GET['branch'];
        $is_Branch  = empty($_GET['isBranch']) ? '' : $_GET['isBranch'];
        $rRekanan   = empty($_GET['rekanan']) ? '' : $_GET['rekanan'];
        $is_Rekanan = empty($_GET['isRekanan']) ? '' : $_GET['isRekanan'];

        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            
            
            $trade      = $this->model_casual->get_trade($rSearch['term'], $rBranch, $is_Branch, $rRekanan, $is_Rekanan);
            
            $result['items']= $trade;
          
            echo json_encode($result);
            
        };
    }   

    function unit_select(){
      
        $rRegion = empty($_GET['region']) ? '' : $_GET['region'];
        $rBranch = empty($_GET['branch']) ? '' : $_GET['branch'];
        $rLooNumber = empty($_GET['loonum']) ? '' : $_GET['loonum'];        
        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];

        if (is_array($rSearch) && $rSearch['_type'] == 'query'){  
            
            $term = '';
            if (isset($rSearch['term'])) { $term = $rSearch['term']; };
            
            $unit      = $this->model_casual->get_unit($term, $rRegion, $rBranch, $rLooNumber);        
            
            $result['items']= $unit;
          
            echo json_encode($result);
        }
    }   

    function strukturnit_select(){
        $this->load->model('template/Master_m');
        
        $strukturunit = $this->Master_m->get_strukturunit();              
        
        if(count($strukturunit)){
            foreach($strukturunit as $key => $value){
                $options[$value->strukturunit_id]= $value->strukturunit_name;
            }
        }
                    
        return $options;
    }

    function agrtype_select(){
        
        $this->load->model('template/Master_m');
        
        $agrtype      = $this->Master_m->get_agrtype();
        $options    = array('' => '==Pilih==');                
        
        if(count($agrtype)){
            foreach($agrtype as $key => $value){
                $options[$value->agreementtype_id]= $value->agreementtype_name;
            }
        }
                    
        return $options;
    }

    function agrtype_rental(){     
        
        $this->load->model('template/Master_m');

        $filter = array('SERVICE TEMP', 'RENTAL TEMP');
        
        $agrtype      = $this->Master_m->get_agrtypefilter($filter);
        
        if(count($agrtype)){
            foreach($agrtype as $key => $value){
                $options[$value->agreementtype_id]= $value->agreementtype_name;
            }
        }
                    
        return $options;
    }

    function agrtype_charge(){     
        
        $this->load->model('template/Master_m');

        $filter = array('SERVICE', 'OTHER');
        
        $agrtype      = $this->Master_m->get_agrtypefilter($filter);
        
        if(count($agrtype)){
            foreach($agrtype as $key => $value){
                $options[$value->agreementtype_id]= $value->agreementtype_name;
            }
        }
                    
        return $options;
    }

    function agrtype_deposit(){     
        
        $this->load->model('template/Master_m');

        $filter = array('DEPOSIT');
        
        $agrtype      = $this->Master_m->get_agrtypefilter($filter);
        
        if(count($agrtype)){
            foreach($agrtype as $key => $value){
                $options[$value->agreementtype_id]= $value->agreementtype_name;
            }
        }
                    
        return $options;
    }

    function agrtype_profit(){     
        
        $this->load->model('template/Master_m');

        $filter = array('PS');
        
        $agrtype      = $this->Master_m->get_agrtypefilter($filter);
        
        if(count($agrtype)){
            foreach($agrtype as $key => $value){
                $options[$value->agreementtype_id]= $value->agreementtype_name;
            }
        }
                    
        return $options;
    }

    function titype_select(){                 

        $options    = array('' => '==Pilih=='); 
        
        $options['DAY']     = 'Day';
        $options['MONTH']   = 'Month';
        $options['YEAR']    = 'Year';
                    
        return $options;
    }

    function calc_select(){            
        
        $options['0'] = 'Normal';
        $options['1'] = 'Step Rental';
        $options['2'] = 'Normal-Prorate';
        $options['3'] = 'Step Rental-Prorate';        
        $options['5'] = 'Step Rental-Progressive';    
                    
        return $options;
    }

    function unit_selectbybranch(){    

        $options  = array();               

        $this->load->model('template/Master_m');
        
        $_unit  = $this->Master_m->get_unit();        

        $options['data'][] = array( 
            'id'      => '',
            'text'    => '',
            'branch'  => '',
            'region'  => '',
            ''
        );            
            
        if(count($_unit)){
            foreach($_unit as $key => $value){                

                $options['data'][] = array(
                    'id'       => $value->unit_id,
                    'text'     => $value->unit_name,
                    'branch'   => $value->branch_id
                );              
            }
        }
                    
        echo json_encode($options);
    }

    function lootype_select(){                 

        $options    = array('' => '==Pilih=='); 
        
        $options[0] = 'Permanent Trasaction';
        $options[1] = 'Casual Transaction';
                    
        return $options;
    }

    function outdoor_select(){                 

        $options    = array('' => '==Pilih=='); 
        
        $options['Outdoor'] = 'Outdoor';
        $options['Indoor'] = 'Indoor';
                    
        return $options;
    }    	
    
    function casualpost_post(){

        if ($_POST){
           $_APP = empty($_POST['postid']) ? '' : $_POST['postid'];         
        }        

        $type = 'username';        

        $username   = $this->session->userdata('username');  
        $channel_id = $this->session->userdata('channel_id');             
        
		$app_agr = $this->model_casualpost->postingcasual($_APP, $username, $channel_id, 1);
		
		// echo var_dump($app_agr);
		// exit;
		
		//EDIT DI SINI TENANT VERIFY
        if ($app_agr != 'NOT_VERIFY')
        {    
            $result['success'] = TRUE;
            $result['data'] = array('id' => $_APP[0]['id']);            
            echo json_encode($result);
        }
		if($app_agr === 'NOT_VERIFY')
		{
			 $result['success'] = FALSE;
			 $result['data'] = array('id' => 'Tenant Belum Di Verify!');            
             echo json_encode($result);
		}
		if($app_agr === FALSE){
            $result['success'] = FALSE;     
            $result['data'] = array('id' => $_APP[0]['id']);
            echo json_encode($result);  
        } 
        
    } 
    
}  