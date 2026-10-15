<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Casual extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_casual');
		    $this->load->library('breadcrumbcomponent');
		    $this->load->library('form_validation');
    }
    
    function index(){       
        redirect('casual/casual/casuallist');
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
    
    function globalsearch_loc(){
        $arcari=array('s.loc_id', 's.region_id', 's.branch_id');
      return $arcari;
    }  
    function globalsearch_locdetil(){
        $arcari=array('loc_id');
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

        $branch_id =  isset($_POST['f_date']) ? $_POST['f_date']: '' ;        

        $braSearch = $branch_id <> '' ? "SHIP.branch_id = '{$branch_id}' " : '';
        $optSearch = $braSearch;

        $arcari=$this->globalsearch_rekanan();

        $vResult=$this->initialize_grid("qry_alldatapop","qry_filteredpop","qry_totalallpop", $arcari, $optSearch);
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

    function controler_gridpro(){

        $p_line =  isset($_POST['f_date']) ? $_POST['f_date']: '' ;        
        //$braSearch = $branch_id <> '' ? "SHIP.branch_id = '{$branch_id}' " : '';
        //$optSearch = $braSearch;        

        $arcari=$this->globalsearch_profit();
        $vResult=$this->initialize_grid("qry_alldatapro","qry_filteredpro","qry_totalallpro", $arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];        

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['provitsharing_id'];
            $row[]= '';
            $row[]= $aRow['provitsharing_id'];
            $row[]= $aRow['provitsharing_desc'];
            $row[]= $p_line;

            if (!empty($row)) { $output['data'][] = $row; }
            }   
      echo json_encode($output);            
    }

    function controler_gridnew(){
        $arcari=$this->globalsearch_new();
        $vResult=$this->initialize_grid("qry_alldatanew","qry_filterednew","qry_totalallnew",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            
            $id=$aRow['loo_id'];
            $row[]=$aRow['loo_id'];
            $row[]=$aRow['loo_sdate'];
            $row[]=$aRow['loo_edate'];
            $row[]=$aRow['_createby'];
            $row[]=$aRow['_createdate'];
            $row[]=$aRow['region_name'];
            $row[]=$aRow['branch_name'];
            $row[]=$aRow['region_id'];
            $row[]=$aRow['branch_id'];
            $row[]=$aRow['size_indoor'];
            $row[]=$aRow['size_outdoor'];
            $row[]=$aRow['fitting_out'];
            $row[]=$aRow['grace_period'];
            $row[]=$aRow['product_name'];
            $row[]=$aRow['loounit_term'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }

    function controler_gridnewdetil(){
        $arcari=$this->globalsearch_detil();
        $vResult=$this->initialize_grid("qry_alldatadetil","qry_filtereddetil","qry_totalalldetil",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            
            $id=$aRow['loo_id'];
            $row[]=$aRow['loo_id'];
            $row[]=$aRow['rekanan_id'];
            $row[]=$aRow['rekanan_name'];
            $row[]=$aRow['rekananshipping_line'];
            $row[]=$aRow['rekananshipping_name'];
            $row[]=$aRow['debtor_no'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }

    function controler_gridloc(){
        $arcari=$this->globalsearch_loc();
        $vResult=$this->initialize_grid("qry_locall","qry_locfiltered","qry_loctotal",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            
            $id=$aRow['loc_id'];
            $row[]=$aRow['loc_id'];
            $row[]=$aRow['loc_sdate'];
            $row[]=$aRow['loc_edate'];
            $row[]=$aRow['_createby'];
            $row[]=$aRow['_createdate'];
            $row[]=$aRow['region_name'];
            $row[]=$aRow['branch_name'];
            $row[]=$aRow['region_id'];
            $row[]=$aRow['branch_id'];
            $row[]=$aRow['size_indoor'];
            $row[]=$aRow['size_outdoor'];
            $row[]=$aRow['fitting_out'];
            $row[]=$aRow['grace_period'];
            $row[]=$aRow['product_name'];
            $row[]=$aRow['locunit_term'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }

    function controler_gridlocdetil(){
        $arcari=$this->globalsearch_locdetil();
        $vResult=$this->initialize_grid("qry_localldetil","qry_locfiltereddetil","qry_loctotaldetil",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            
            $id=$aRow['loc_id'];
            $row[]=$aRow['loc_id'];
            $row[]=$aRow['rekanan_id'];
            $row[]=$aRow['rekanan_name'];
            $row[]=$aRow['rekananshipping_line'];
            $row[]=$aRow['rekananshipping_name'];
            $row[]=$aRow['debtor_no'];

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
		
		$rResult=$this->model_casual->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_casual->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_casual->$qry_totalall();
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
		
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari, '');
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {

          $i_link = $aRow['agreement_id'];
          $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
          $is_post = ($aRow['agreement_isapproved']) ? 1 : 0;
          $is_post = ($aRow['agreement_isclosed']) ? 1 : 0;          

          if ($aRow['agreement_isapproved']) {
             /* $_menu='
                  <a href="/index.php/casual/casual/casualedit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                  <i class="fa fa-edit fa-lg"></i></a>
                  <a href="/index.php/casual/casualprint/print_pdf/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank">
                  <i class="fa fa-print fa-lg"></i></a>
                  <a href="/index.php/casual/casual/casual_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
                  <i class="fa fa-trash fa-lg"></i></a>';*/
				  $_menu='
                  <a href="/index.php/casual/casual/casualedit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                  <i class="fa fa-edit fa-lg"></i></a>
                  <a href="/index.php/laprint5/laprint5/apendix2_casual_agr/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank">
                  <i class="fa fa-print fa-lg"></i></a>
                  <a href="/index.php/casual/casual/casual_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
                  <i class="fa fa-trash fa-lg"></i></a>';

          } else {
              $_menu='
                  <a href="/index.php/casual/casual/casualedit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                  <i class="fa fa-edit fa-lg"></i></a>
                  <a href="/index.php/casual/casual/casual_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
                  <i class="fa fa-trash fa-lg"></i></a>';
          }

          $row = array();
		      $row[]=$aRow['agreement_id'];            
          $row[]=date("d-m-Y", strtotime($aRow['agreement_startdate']));
          //$row[]=date("d-m-Y", strtotime($aRow['agreement_enddate']));
		   $row[]=Date_format(Date_create($aRow['agreement_enddate']), "d-m-Y");	
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

    function casuallist(){
        
        $agreement_id = $this->uri->segment(4);
        $data   = array(
                  'result'       => $this->model_casual->viewagreement($agreement_id),
                  'agreement_id' => $agreement_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
		
		    $this->breadcrumbcomponent->add('Agreement Transaction Casual','casual/casuallist');

        $this->load->view('template/v_header');
        $this->load->view('casual/casual_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function casualadd()
	  {		
        
        $agreement_id = $this->uri->segment(4);        
        
        $data   = array(
                  'result'          => $this->model_casual->viewagreement($agreement_id),
                  'agreement_id'    => $agreement_id
            );        
        
        $data['region']         = $this->region_select();
        $data['lotype']         = $this->lootype_select();
        $data['titype']         = $this->titype_select();
        $data['renttype']       = $this->agrtype_rental();
        $data['strukturunit']   = $this->strukturnit_select();
        $data['calculation']    = $this->calc_select();
        $data['outdoor']        = $this->outdoor_select();
        $data['chgtype']        = $this->agrtype_charge();
        $data['deptype']        = $this->agrtype_deposit();
        $data['protype']        = $this->agrtype_profit();

  		  $this->breadcrumbcomponent->add('Agreement Transaction Casual','casual/casual/casuallist')
            ->add('Add Agreement Transaction Casual','casual/casual/casualadd');

        $this->load->view('template/v_header');
        $this->load->view('casual/casual_add', $data);
        $this->load->view('template/v_footer');
	  }
    
	
	  function casualedit(){		
        
        $i_link = $this->uri->segment(4);       
        $_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'          => $this->model_casual->viewagreement($_id),
                  'agreement_id'    => $_id
            );                
        
        $data['region']         = $this->region_select();
        $data['lotype']         = $this->lootype_select();
        $data['titype']         = $this->titype_select();
        $data['renttype']       = $this->agrtype_rental();
        $data['strukturunit']   = $this->strukturnit_select();
        $data['calculation']    = $this->calc_select();
        $data['outdoor']        = $this->outdoor_select();
        $data['chgtype']        = $this->agrtype_charge();
        $data['deptype']        = $this->agrtype_deposit();
        $data['protype']        = $this->agrtype_profit();

        $data['resultr'] = $this->model_casual->vdetilrental($_id);
        $data['resultc'] = $this->model_casual->vdetilchargetemp($_id);
        $data['resultd'] = $this->model_casual->vdetildeposit($_id);
        $data['resultp'] = $this->model_casual->vdetilprofits($_id);
		
        $this->breadcrumbcomponent->add('Agreement Transaction Casual','casual/casual/casuallist')
        ->add('Edit Agreement Transaction Casual','casual/casual/casualedit');        

        $this->load->view('template/v_header');
        $this->load->view('casual/casual_edit', $data);
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

        $filter = array('UTILITIES TEMP', 'OTHER');
        
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
    
    function casual_add(){      

        if ($_POST){

            $_contractno        = $this->input->post('idebtor');
            $_formula           = $this->input->post('cbocalctype');
            $branch_id          = $this->input->post('cbobranch');
            $region_id          = $this->input->post('cboregion');
            $strukturunit_id    = $this->input->post('cbostruktur');
            $rekanan_id         = $this->input->post('htenant');
            $rekananshipping_line = $this->input->post('hbrand');
            $_virtualaccount    = $this->input->post('ivirtual');
            $transaksi_id       = $this->input->post('htransaksi');
            $_loonumber         = $this->input->post('agreement_loonumber');
            $_isflat            = $this->input->post('_isflat');; //$this->input->post('isflat');
            $_installmentflat   = $this->input->post('agreement_installmentflat');
            $_startperiod       = $this->input->post('agreement_startperiod');
            $_term              = $this->input->post('agreement_term');
            $_dayterm           = $this->input->post('agreement_dayterm');
            $_endperiod         = $this->input->post('agreement_endperiod');
            $_createby          = $this->session->userdata('user_fullname');
            $_createdate        = date("Y-m-d h:i:sa", time());
			$_modifyby	        = $this->input->post('_modifyby');
            $_modifydate        = date("Y-m-d", time());
            $product_name       = $this->input->post('product_name');
            $_descr             = $this->input->post('agreement_descr');
            $fitting_out        = $this->input->post('fitting_out');
            $grace_period       = $this->input->post('grace_periode');
            $size_indoor        = $this->input->post('size_indoor');
            $size_outdoor       = $this->input->post('size_outdoor');
            $channel_id         = $this->session->userdata('channel_id');
            $_space             = 0;
            $_idr               = 0;
            $_foreign           = 0;
            $_foreign_rate      = 0;
            $currency_id        = '';            
            $_ref               = 0;
            $ref_id             = '';
            $ref_type           = '';
            $_startdate         = $this->input->post('agreement_startperiod');
            $_enddate           = $this->input->post('agreement_endperiod');
            $leasetype_id       = '0';
            $_renttype          = 1;
            $_deduct            = 0;
            $_provision         = 0;
            $_renewalno         = '';
            $_contractlongnumber = $this->input->post('agreement_contractlongnumber');
            $_lanumber          = '';
            $_tlv               = 0;
            $_bapdate           = $this->input->post('agreement_bapdate');
            $r_line             = $this->input->post('rline');
            $r_type             = $this->input->post('rtype');
            $r_sdate            = $this->input->post('rsdate');
            $r_edate            = $this->input->post('redate');
            $r_rinstm           = $this->input->post('rrinstm');
            $r_rinstd           = $this->input->post('rrinstd');
            $r_pinst            = $this->input->post('rpinst');
            $r_int              = $this->input->post('rint');
            $r_titype           = $this->input->post('rtitype');
            $r_space            = $this->input->post('rspace');
            $r_per              = $this->input->post('rper');
            $r_base             = $this->input->post('rbase');
            $r_vat              = $this->input->post('rvat');
            $r_unit             = $this->input->post('runit');
            $r_una              = $this->input->post('runa');
            $r_mia              = $this->input->post('rmia');
            $r_adendum          = $this->input->post('radendum');
            $r_lumpsum          = $this->input->post('rlumpsum');
            $r_descr            = $this->input->post('rdescr');
            $r_spdate           = $this->input->post('rspdate');
            $r_unitspot         = $this->input->post('runitspot');
            $c_line             = $this->input->post('cline');
            $c_type             = $this->input->post('ctype');
            $c_sdate            = $this->input->post('csdate');
            $c_edate            = $this->input->post('cedate');
            $c_rinstm           = $this->input->post('crinstm');
            $c_rinstd           = $this->input->post('crinstd');
            $c_pinst            = $this->input->post('cpinst');
            $c_int              = $this->input->post('cint');
            $c_titype           = $this->input->post('ctitype');
            $c_space            = $this->input->post('cspace');
            $c_per              = $this->input->post('cper');
            $c_base             = $this->input->post('cbase');
            $c_vat              = $this->input->post('cvat');
            $c_unit             = $this->input->post('cunit');
            $c_una              = $this->input->post('cuna');
            $c_mia              = $this->input->post('cmia');
            $c_adendum          = $this->input->post('cadendum');
            $c_lumpsum          = $this->input->post('clumpsum');
            $c_descr            = $this->input->post('cdescr');
            $c_spdate           = $this->input->post('cspdate');
            $c_unitspot         = $this->input->post('cunitspot');
            $de_line            = $this->input->post('dline');
            $de_type            = $this->input->post('dtype');
            $de_sdate           = $this->input->post('dsdate');
            $de_due             = $this->input->post('ddue');
            $de_titype          = $this->input->post('dtitype');
            $de_unit            = $this->input->post('dunit');
            $de_space           = $this->input->post('dspace');
            $de_lumpsum         = $this->input->post('dlumpsum');
            $de_base            = $this->input->post('dbase');
            $de_mia             = $this->input->post('dmia');
            $de_vat             = $this->input->post('dvat');
            $de_una             = $this->input->post('duna');
            $p_line             = $this->input->post('pline');
            $p_upload           = $this->input->post('pupload');
            $p_post             = $this->input->post('ppost');
            $p_type             = $this->input->post('ptype');
            $p_sdate            = $this->input->post('psdate');
            $p_term             = $this->input->post('pterm');
            $p_dayterm          = $this->input->post('pdayterm');
            $p_edate            = $this->input->post('pedate');
            $p_titype           = $this->input->post('ptitype');
            $p_unit             = $this->input->post('punit');
            $p_space            = $this->input->post('pspace');
            $p_idps             = $this->input->post('pidps');
            $p_psdesc           = $this->input->post('ppsdesc');
            $p_omset            = $this->input->post('pomset');
            $p_lumpsum          = $this->input->post('plumpsum');
            $p_mia              = $this->input->post('pmia');
            $p_vat              = $this->input->post('pvat');
            $p_una              = $this->input->post('puna');
			$invdate =$this->input->post('invdate');
			$invdatesc =$this->input->post('cspdate');
			
			$tgldue=$this->input->post('tgldue');
			$tglduesc=$this->input->post('tglduesc');

            $this->load->model('template/Master_m');    
            $dtregion   = $this->Master_m->get_regionbyid($region_id);
            $dtchannel  = $this->Master_m->get_channelbyid($channel_id);
                       
            $r_code     = $dtregion[0]->region_nameshort;  
            $channel_no = $dtchannel[0]->channel_number; 
			
      			$this->form_validation->set_rules('cboregion', 'Business Unit', 'required');
      			$this->form_validation->set_rules('cbobranch', 'Store', 'required');
      			$this->form_validation->set_rules('htenant', 'Tenant', 'required');

            $fitting_out        = empty($fitting_out) ? 0 : $fitting_out;
            $grace_period       = empty($grace_period) ? 0 : $grace_period;
            $size_indoor        = empty($size_indoor) ? 0 : $size_indoor;
            $size_outdoor       = empty($size_outdoor) ? 0 : $size_outdoor;
			
      			if ($this->form_validation->run() == TRUE) { 
              	$idx=$this->model_casual->insertagreement(
                      $_ref, $ref_id, $ref_type, $_startdate, $_enddate, $_space, $_idr, $_foreign, $_foreign_rate,
                      $currency_id, $_term, $_dayterm, $leasetype_id, $_descr, $_tlv, $_createby, $_createdate, $_modifyby, $_modifydate, 
                      $channel_id, $region_id, $branch_id, $rekanan_id, $rekananshipping_line, $strukturunit_id, $transaksi_id, 
                      $_formula, $_renttype, $_deduct, $_provision, $_contractno, $_startperiod, $_endperiod, $_renewalno, 
                      $_isflat, $_installmentflat, $_virtualaccount, $fitting_out, $product_name, $grace_period, $size_indoor, $size_outdoor,
                      $_contractlongnumber, $_loonumber, $_lanumber, $_bapdate,
                      $r_code, $_channel_id, $channel_no, $r_line, $r_type, $r_sdate, $r_edate, $r_rinstm, $r_rinstd, 
                      $r_pinst, $r_int, $r_titype, $r_space, $r_per, $r_base, $r_vat, $r_unit, $r_mia, $r_adendum, $r_lumpsum,
                      $r_descr, $r_spdate, $r_unitspot, $r_una, $c_line, $c_type, $c_sdate, $c_edate, $c_rinstm, $c_rinstd, 
                      $c_pinst, $c_int, $c_titype, $c_space, $c_per, $c_base, $c_vat, $c_unit, $c_mia, $c_adendum, $c_lumpsum,
                      $c_descr, $c_spdate, $c_unitspot, $c_una, $de_line, $de_type, $de_sdate, $de_due, $de_titype, $de_unit, $de_space,
                      $de_lumpsum, $de_base, $de_mia, $de_vat, $de_una, $p_line, $p_upload, $p_post, $p_type, $p_sdate, $p_term,
                      $p_dayterm, $p_edate, $p_titype, $p_unit, $p_space, $p_idps, $p_psdesc, $p_omset, $p_lumpsum, $p_mia, $p_vat, $p_una,$invdate,$invdatesc,$tgldue,$tglduesc
                );

              	redirect("casual/casual/casualedit/".$idx);
      			} else {
      			   $this->casualadd();	
      			}
        }
		
    }
  
    function casual_edit(){      
        
        //print_r($_POST);

        if ($_POST){

            $agreement_id       = $this->input->post('agreement_id');
            $_contractno        = $this->input->post('idebtor');
            $_formula           = $this->input->post('cbocalctype');
            $branch_id          = $this->input->post('cbobranch');
            $region_id          = $this->input->post('cboregion');
            $strukturunit_id    = $this->input->post('cbostruktur');
            $rekanan_id         = $this->input->post('htenant');
            $rekananshipping_line = $this->input->post('hbrand');
            $_virtualaccount    = $this->input->post('ivirtual');
            $transaksi_id       = $this->input->post('htransaksi');
            $_loonumber         = $this->input->post('agreement_loonumber');
            $_isflat            = $this->input->post('_isflat'); //$this->input->post('isflat');
            $_installmentflat   = $this->input->post('agreement_installmentflat');
            $_startperiod       = $this->input->post('agreement_startperiod');
            $_term              = $this->input->post('agreement_term');
            $_dayterm           = $this->input->post('agreement_dayterm');
            $_endperiod         = $this->input->post('agreement_endperiod');
            $_createby          = $this->session->userdata('user_fullname');
            $_createdate        = date("Y-m-d h:i:sa", time());
            $_modifyby          = $this->session->userdata('user_fullname');
            $_modifydate        = date("Y-m-d", time());
            $product_name       = $this->input->post('product_name');
            $_descr             = $this->input->post('agreement_descr');
            $fitting_out        = $this->input->post('fitting_out');
            $grace_period       = $this->input->post('grace_periode');
            $size_indoor        = $this->input->post('size_indoor');
            $size_outdoor       = $this->input->post('size_outdoor');
            $channel_id         = $this->session->userdata('channel_id');
            $_space             = 0;
            $_idr               = 0;
            $_foreign           = 0;
            $_foreign_rate      = 0;
            $currency_id        = '';
            $_ref               = $this->input->post('hrenewal');
            $ref_id             = '';
            $ref_type           = '';
            $_startdate         = $this->input->post('agreement_startperiod');
            $_enddate           = $this->input->post('agreement_endperiod');
            $leasetype_id       = '0';
            $_renttype          = 1;
            $_deduct            = 0;
            $_provision         = 0;
            $_renewalno         = $this->input->post('agreement_renewalno');
            $_contractlongnumber = $this->input->post('agreement_contractlongnumber');
            $_lanumber          = '';
            $_tlv               = 0;
            $_bapdate           = $this->input->post('agreement_bapdate');
            $r_line             = $this->input->post('rline');
            $r_type             = $this->input->post('rtype');
            $r_sdate            = $this->input->post('rsdate');
            $r_edate            = $this->input->post('redate');
            $r_rinstm           = $this->input->post('rrinstm');
            $r_rinstd           = $this->input->post('rrinstd');
            $r_pinst            = $this->input->post('rpinst');
            $r_int              = $this->input->post('rint');
            $r_titype           = $this->input->post('rtitype');
            $r_space            = $this->input->post('rspace');
            $r_per              = $this->input->post('rper');
            $r_base             = $this->input->post('rbase');
            $r_vat              = $this->input->post('rvat');
            $r_unit             = $this->input->post('runit');
            $r_una              = $this->input->post('runa');
            $r_mia              = $this->input->post('rmia');
            $r_adendum          = $this->input->post('radendum');
            $r_lumpsum          = $this->input->post('rlumpsum');
            $r_descr            = $this->input->post('rdescr');
            $r_spdate           = $this->input->post('rspdate');
            $r_unitspot         = $this->input->post('runitspot');
            $r_state            = $this->input->post('rstate');
            $c_line             = $this->input->post('cline');
            $c_type             = $this->input->post('ctype');
            $c_sdate            = $this->input->post('csdate');
            $c_edate            = $this->input->post('cedate');
            $c_rinstm           = $this->input->post('crinstm');
            $c_rinstd           = $this->input->post('crinstd');
            $c_pinst            = $this->input->post('cpinst');
            $c_int              = $this->input->post('cint');
            $c_titype           = $this->input->post('ctitype');
            $c_space            = $this->input->post('cspace');
            $c_per              = $this->input->post('cper');
            $c_base             = $this->input->post('cbase');
            $c_vat              = $this->input->post('cvat');
            $c_unit             = $this->input->post('cunit');
            $c_una              = $this->input->post('cuna');
            $c_mia              = $this->input->post('cmia');
            $c_adendum          = $this->input->post('cadendum');
            $c_lumpsum          = $this->input->post('clumpsum');
            $c_descr            = $this->input->post('cdescr');
            $c_spdate           = $this->input->post('cspdate');
            $c_unitspot         = $this->input->post('cunitspot');
            $c_state            = $this->input->post('cstate');
            $de_line            = $this->input->post('dline');
            $de_type            = $this->input->post('dtype');
            $de_sdate           = $this->input->post('dsdate');
            $de_due             = $this->input->post('ddue');
            $de_titype          = $this->input->post('dtitype');
            $de_unit            = $this->input->post('dunit');
            $de_space           = $this->input->post('dspace');
            $de_lumpsum         = $this->input->post('dlumpsum');
            $de_base            = $this->input->post('dbase');
            $de_mia             = $this->input->post('dmia');
            $de_vat             = $this->input->post('dvat');
            $de_una             = $this->input->post('duna');
            $de_state           = $this->input->post('dstate');
            $p_line             = $this->input->post('pline');
            $p_upload           = $this->input->post('pupload');
            $p_post             = $this->input->post('ppost');
            $p_type             = $this->input->post('ptype');
            $p_sdate            = $this->input->post('psdate');
            $p_term             = $this->input->post('pterm');
            $p_dayterm          = $this->input->post('pdayterm');
            $p_edate            = $this->input->post('pedate');
            $p_titype           = $this->input->post('ptitype');
            $p_unit             = $this->input->post('punit');
            $p_space            = $this->input->post('pspace');
            $p_idps             = $this->input->post('pidps');
            $p_psdesc           = $this->input->post('ppsdesc');
            $p_omset            = $this->input->post('pomset');
            $p_lumpsum          = $this->input->post('plumpsum');
            $p_mia              = $this->input->post('pmia');
            $p_vat              = $this->input->post('pvat');
            $p_una              = $this->input->post('puna');
            $p_state           = $this->input->post('pstate');
            $deleted            = $this->input->post('deleted');                                   
			$invdate=$this->input->post('invdate');
			$invdatesc=$this->input->post('invdatesc');
			$tgldue=$this->input->post('tgldue');
			$tglduesc=$this->input->post('tglduesc');
			
            $this->load->model('template/Master_m');    
            $dtregion   = $this->Master_m->get_regionbyid($region_id);
            $dtchannel  = $this->Master_m->get_channelbyid($channel_id);
                       
            $r_code     = $dtregion[0]->region_nameshort;  
            $channel_no = $dtchannel[0]->channel_number; 
      
            $this->form_validation->set_rules('cboregion', 'Business Unit', 'required');
            $this->form_validation->set_rules('cbobranch', 'Store', 'required');
            $this->form_validation->set_rules('htenant', 'Tenant', 'required');

            $fitting_out        = empty($fitting_out) ? 0 : $fitting_out;
            $grace_period       = empty($grace_period) ? 0 : $grace_period;
            $size_indoor        = empty($size_indoor) ? 0 : $size_indoor;
            $size_outdoor       = empty($size_outdoor) ? 0 : $size_outdoor;
      
            if ($this->form_validation->run() == TRUE) {
                
                if ($agreement_id === 'auto') {
                    /** Insert Casual **/
                    $idx=$this->model_casual->insertagreement(
                        $_ref, $ref_id, $ref_type, $_startdate, $_enddate, $_space, $_idr, $_foreign, $_foreign_rate,
                        $currency_id, $_term, $_dayterm, $leasetype_id, $_descr, $_tlv, $_createby, $_createdate, $_modifyby, $_modifydate, 
                        $channel_id, $region_id, $branch_id, $rekanan_id, $rekananshipping_line, $strukturunit_id, $transaksi_id, 
                        $_formula, $_renttype, $_deduct, $_provision, $_contractno, $_startperiod, $_endperiod, $_renewalno, 
                        $_isflat, $_installmentflat, $_virtualaccount, $fitting_out, $product_name, $grace_period, $size_indoor, $size_outdoor,
                        $_contractlongnumber, $_loonumber, $_lanumber, $_bapdate,
                        $r_code, $_channel_id, $channel_no, $r_line, $r_type, $r_sdate, $r_edate, $r_rinstm, $r_rinstd, 
                        $r_pinst, $r_int, $r_titype, $r_space, $r_per, $r_base, $r_vat, $r_unit, $r_mia, $r_adendum, $r_lumpsum,
                        $r_descr, $r_spdate, $r_unitspot, $r_una, $c_line, $c_type, $c_sdate, $c_edate, $c_rinstm, $c_rinstd, 
                        $c_pinst, $c_int, $c_titype, $c_space, $c_per, $c_base, $c_vat, $c_unit, $c_mia, $c_adendum, $c_lumpsum,
                        $c_descr, $c_spdate, $c_unitspot, $c_una, $de_line, $de_type, $de_sdate, $de_due, $de_titype, $de_unit, $de_space,
                        $de_lumpsum, $de_base, $de_mia, $de_vat, $de_una, $p_line, $p_upload, $p_post, $p_type, $p_sdate, $p_term,
                        $p_dayterm, $p_edate, $p_titype, $p_unit, $p_space, $p_idps, $p_psdesc, $p_omset, $p_lumpsum, $p_mia, $p_vat, $p_una,$invdate,$invdatesc,$tgldue,$tglduesc
                    );
                }else{
                    /** Update Casual **/
                    $idx = $this->model_casual->updateagreement(
                        $agreement_id, $_ref, $ref_id, $ref_type, $_startdate, $_enddate, $_space, $_idr, $_foreign, $_foreign_rate,
                        $currency_id, $_term, $_dayterm, $leasetype_id, $_descr, $_tlv, $_createby, $_createdate, $_modifyby, $_modifydate, 
                        $channel_id, $region_id, $branch_id, $rekanan_id, $rekananshipping_line, $strukturunit_id, $transaksi_id, 
                        $_formula, $_renttype, $_deduct, $_provision, $_contractno, $_startperiod, $_endperiod, $_renewalno, 
                        $_isflat, $_installmentflat, $_virtualaccount, $fitting_out, $product_name, $grace_period, $size_indoor, $size_outdoor,
                        $_contractlongnumber, $_loonumber, $_lanumber, $_bapdate,
                        $r_code, $_channel_id, $channel_no, $r_line, $r_type, $r_sdate, $r_edate, $r_rinstm, $r_rinstd, 
                        $r_pinst, $r_int, $r_titype, $r_space, $r_per, $r_base, $r_vat, $r_unit, $r_mia, $r_adendum, $r_lumpsum,
                        $r_descr, $r_spdate, $r_unitspot, $r_una, $c_line, $c_type, $c_sdate, $c_edate, $c_rinstm, $c_rinstd, 
                        $c_pinst, $c_int, $c_titype, $c_space, $c_per, $c_base, $c_vat, $c_unit, $c_mia, $c_adendum, $c_lumpsum,
                        $c_descr, $c_spdate, $c_unitspot, $c_una, $de_line, $de_type, $de_sdate, $de_due, $de_titype, $de_unit, $de_space,
                        $de_lumpsum, $de_base, $de_mia, $de_vat, $de_una, $p_line, $p_upload, $p_post, $p_type, $p_sdate, $p_term,
                        $p_dayterm, $p_edate, $p_titype, $p_unit, $p_space, $p_idps, $p_psdesc, $p_omset, $p_lumpsum, $p_mia, $p_vat, $p_una,
                        $p_state, $deleted, $r_state, $de_state, $c_state,$invdate,$invdatesc,$tgldue,$tglduesc
                    );
                }                
                redirect("casual/casual/casualedit/".$idx);            
            }
        }
    }
	
  	function casual_delete(){
  		
        $i_link = $this->uri->segment(4);       

        $_id = str_replace('_', '/', $i_link); 

  		  $this->model_casual->deleteagreement($_id);
  		redirect("casual/casual/casuallist");
  	}

    function casual_getdataloo(){     
        
        $loo_id     = empty($_GET['id']) ? '' : trim($_GET['id']);
        $rekanan_id = empty($_GET['rekanan']) ? '' : trim($_GET['rekanan']);
        $branch_id  = empty($_GET['branch']) ? '' : trim($_GET['branch']);
  
        $rResult = $this->model_casual->getdataloo($loo_id, $rekanan_id, $branch_id);

        foreach ($rResult as $aRow) {

            $row = array();            
            $row[]=$aRow['loo_id'];
            $row[]=$aRow['agreementtype_id'];
            $row[]=$aRow['agreementtype_type'];            
            $row[]=$aRow['skl_looterm'];
            $row[]=$aRow['skl_loiterm'];
            $row[]=$aRow['loodetil_int'];
            $row[]=$aRow['loounit_sdate'];
            $row[]=$aRow['loounit_edate'];
            $row[]=$aRow['loodetil_baserent'];
            $row[]=$aRow['unit_name'];
            $row[]=$aRow['unit_sqm'];
            $row[]=$aRow['unit'];
            $row[]=$aRow['loodetil_percent'];
            $row[]=$aRow['loounit_term'];
            $row[]=$aRow['agreementtype_group'];
           
        if (!empty($row)) { $output['data'][] = $row; }
        }   
        echo json_encode($output);
    }

    function casual_getdataloc(){     
        
        $loo_id     = empty($_GET['id']) ? '' : trim($_GET['id']);
        $rekanan_id = empty($_GET['rekanan']) ? '' : trim($_GET['rekanan']);
        $branch_id  = empty($_GET['branch']) ? '' : trim($_GET['branch']);
  
        $rResult = $this->model_casual->getdataloc($loo_id, $rekanan_id, $branch_id);

        foreach ($rResult as $aRow) {

            $row = array();            
            $row[]=$aRow['loc_id'];
            $row[]=$aRow['agreementtype_id'];
            $row[]=$aRow['agreementtype_type'];            
            $row[]=$aRow['skl_looterm'];
            $row[]=$aRow['skl_loiterm'];
            $row[]=$aRow['locdetil_int'];
            $row[]=$aRow['locunit_sdate'];
            $row[]=$aRow['locunit_edate'];
            $row[]=$aRow['locdetil_baserent'];
            $row[]=$aRow['unit_name'];
            $row[]=$aRow['unit_sqm'];
            $row[]=$aRow['unit'];
            $row[]=$aRow['locdetil_percent'];
            $row[]=$aRow['locunit_term'];
            $row[]=$aRow['agreementtype_group'];
           
        if (!empty($row)) { $output['data'][] = $row; }
        }   
        echo json_encode($output);
    }

    
}  