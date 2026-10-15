<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loo_cl extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_loo_cl');
		$this->load->library('breadcrumbcomponent');
    }
    
    function index(){       
        redirect('loo_cl/loo_cl/penalist');
    }

    function globalsearch_rekanan(){
        $arcari=array('rekanan_name','rekananshipping_name');
        return $arcari;
    }
  
	function globalsearch_dialog(){
		$arcari=array('unit_id','unit_name', 'region_id', 'branch_id');
		return $arcari;
	}    
	
	function globalsearch_list(){
		$arcari=array('loo_id',  'CTE.region_id','CTE.rekanan_id','BRANCH.branch_name','REKAN.rekanan_name','BRAND.rekananshipping_name');
		return $arcari;
	}
   
    function globalsearch_schema(){
        $arcari=array('unittype_id');
        return $arcari;
    }
	
	 function initialize_grid_dialog(){
      
	  $region_id=trim($_GET['region_id']);
	  $branch_id=trim($_GET['branch_id']);
	  $unit_id=trim($_GET['unit_id']);
	  $lantai_id=trim($_GET['lantai_id']);
	  // echo var_dump($_GET);
	  // exit;
      $rResult=$this->model_loo_cl->dataapp_list($region_id,$branch_id,$unit_id,$lantai_id); 
       
	  echo json_encode($rResult);
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
	
    $rResult=$this->model_loo_cl->$qry_alldata($limit,$top,$sWhere);
   
	$rResultCnt =$this->model_loo_cl->$qry_filtered($sWhere);
	$iFilteredTotal = $rResultCnt['jml'];

	$rResultTotal =$this->model_loo_cl->$qry_totalall();
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
		$id=$aRow['unit_id'];
                $row[]=$aRow['unit_id'];
                $row[]=$aRow['region_id'];
                $row[]=$aRow['region_name'];
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

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }
    	
    function controler_penalist($val_search = ''){
    	$arcari=$this->globalsearch_list();
		
		$searchStatus = $val_search;
		
		
		$criteria = null; 
		if($searchStatus == 'app')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.isapproved = 1";
			}
			else
			{
				$criteria =  " CTE.isapproved = 1 " ;
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
				$criteria =  " CTE.isconfirm = 1" ;
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
		
		
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari, $criteria);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['loo_id']);
            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
            $is_confirm = ($aRow['isconfirm']) ? 1 : 0;
            $is_post = ($aRow['isapproved']) ? 1 : 0;            
			$id_show = $is_post == 0 ? $aRow['conf_id'] : $aRow['loo_id']; 

            $row = array();
    				$row[]=$id_show;
                    $row[]=date("d-m-Y", strtotime($aRow['loo_date']));
                    $row[]=date("d-m-Y", strtotime($aRow['loo_sdate']));
                    $row[]=date("d-m-Y", strtotime($aRow['loo_edate']));
    				$row[]=$aRow['loo_term'];
    				$row[]=$aRow['region_nameshort'];
    				$row[]=$aRow['branch_name'];
                    $row[]=$ship_name;
                    $row[]=$aRow['rekananshipping_name'];
                    $row[]=$aRow['isapproved'];
                    $row[]=$aRow['isconfirm'];
					if ($aRow['ismulti']=="1"){
						$vprint='printatm2pdf';
					}else{
						$vprint='printatmpdfloo';
					}
    				$row[]='
        <a href="/index.php/loo_cl/loo_cl/looedit/'.$i_link.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> 
    	<a href="/index.php/loo_cl/loo_cl/loo_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')"><i class ="fa fa-trash"></i></a>';
    	
    	// <a href="/index.php/looprint/looprint/'.$vprint.'/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank"><i class="fa fa-print"></i></a>
            if (!empty($row)) { $output['data'][] = $row; }
        	}   
        	echo json_encode($output);
    		
    }

    function penalist(){
        
        $loo_id = $this->uri->segment(4);
		 
        $data   = array(
                  'result'    => $this->model_loo_cl->viewloo($loo_id),
                  'loo_id'   => $loo_id
            );        
        //echo var_dump($data['result']);
		//exit;
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
		
		$this->breadcrumbcomponent->add('Proposed LOO ATM','loo_cl/penalist');

        $this->load->view('template/v_header');
        $this->load->view('loo_cl/pena_list', $data);
        $this->load->view('template/v_footer');
    }

    function controler_gridlist($val_search = ''){
       $arcari=$this->globalsearch_list();
		
		$searchStatus = $val_search;
		
		
		$criteria = null; 
		if($searchStatus == 'app')
		{
			if(!empty($criteria))
			{
				$criteria = $criteria." AND CTE.isapproved = 1";
			}
			else
			{
				$criteria =  " CTE.isapproved = 1 " ;
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
				$criteria =  " CTE.isconfirm = 1" ;
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
		
		
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari, $criteria);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];


        foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['loo_id']);
            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
            $is_post = ($aRow['isconfirm']) ? 1 : 0;
            $is_post = ($aRow['isapproved']) ? 1 : 0;            
            
            $id_show =$aRow['loo_id']; 
            
            $row = array();
                    $row[]=$id_show;
                    $row[]=date("d-m-Y", strtotime($aRow['loo_date']));
                    $row[]=date("d-m-Y", strtotime($aRow['loo_sdate']));
                    $row[]=date("d-m-Y", strtotime($aRow['loo_edate']));
                    $row[]=$aRow['loo_term'];
                    $row[]=$aRow['region_nameshort'];
                    $row[]=$aRow['branch_name'];
                    $row[]=$ship_name;
                    $row[]=$aRow['rekananshipping_name'];
                    $row[]=$aRow['isapproved'];
                    $row[]=$aRow['isconfirm'];
					if ($aRow['ismulti']=="1"){
						$vprint='printatm2pdfloo';
					}else{
						$vprint='printatmpdfloo';
					}
                    $row[]='<a href="/index.php/atmprint/atmprint/'.$vprint.'/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank"><i class="fa fa-print"></i></a>';
             // $row[]='<a href="'.site_url('/looprint/looprint/'.$vprint.'/'.$i_link).'" data-toggle="tooltip" title="Edit" target="_blank"><i class="fa fa-print"></i></a>';
        
            if (!empty($row)) { $output['data'][] = $row; }
        }   
        
        echo json_encode($output);
            
    }

    function loolist(){
        
        $loo_id = $this->uri->segment(4);
         
        $data   = array(
                  'result'    => $this->model_loo_cl->viewloo($loo_id),
                  'loo_id'   => $loo_id
            );        
        //echo var_dump($data['result']);
        //exit;
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        
        $this->breadcrumbcomponent->add('LOO ATM Print','loo_cl/loolist');

        $this->load->view('template/v_header');
        $this->load->view('loo_cl/loo_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function looadd()
	{		
        
        $loo_id = $this->uri->segment(4);        
        
        $data   = array(
                  'result'    => $this->model_loo_cl->viewloo($loo_id),
                  'loo_id'   => $loo_id
            );        
        
        $data['region']  = $this->region_select();
		//$data['branch_dlg'] = $this->branch_select_dialog();
        $data['lotype'] = $this->lootype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();
        $data['unittype']   = $this->unittype_select();

  		$this->breadcrumbcomponent->add('Proposed LOO ATM','loo_cl/loo_cl/penalist')
            ->add('Input Proposed LOO ATM','loo_cl/loo_cl/looadd');


        $this->load->view('template/v_header');
        $this->load->view('loo_cl/loo_add', $data);
        $this->load->view('template/v_footer');
	}
     
	function looedit(){		
        
        $i_link = $this->uri->segment(4);       

        $loo_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_loo_cl->viewloo($loo_id),
                  'loo_id'   => $loo_id
            );                
        
        $data['region']     = $this->region_select();
        $data['lotype']     = $this->lootype_select();	
        $data['agrtype']    = $this->agrtype_select();
        $data['titype']     = $this->titype_select();
        $data['unittype']   = $this->unittype_select(); 

        $data['resultd'] = $this->model_loo_cl->sholdetilby_id($loo_id);
        $data['resultu'] = $this->model_loo_cl->vdetilunitby_id($loo_id);
		
	 
		 
		
		$this->breadcrumbcomponent->add('Proposed LOO ATM','loo_cl/loo_cl/penalist')
            ->add('Edit Proposed LOO ATM','loo_cl/loo_cl/looedit');        

        $this->load->view('template/v_header');
        $this->load->view('loo_cl/loo_edit', $data);
        $this->load->view('template/v_footer');
	}

    function looview(){     
        
        $cont =  $this->uri->segment(4);
        $i_link = $this->uri->segment(5);       

        $loo_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_loo_cl->viewloo($loo_id),
                  'loo_id'   => $loo_id
            );                
        
        $data['region'] = $this->region_select();
        $data['lotype'] = $this->lootype_select(); 
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();

        $data['resultd'] = $this->model_loo_cl->sholdetilby_id($loo_id);
        $data['cont'] = $cont;

        switch ($cont){
            case "looconf":
                $crumb              = "Loo Return";
                $data['tabpost']    = " Return";
                break;

            case "looapp":
                $crumb              = "Loo Approval";
                $data['tabpost']    = " Approve";
                break;
            case "printcon":
                $crumb = "Print Confirmation";
                break;

        }
        
        $this->breadcrumbcomponent->add($crumb,'loo_cl/'.$cont)
            ->add('View Loo Unit ATM','loo_cl/loo_cl/looview');        

        $this->load->view('template/v_header');
        $this->load->view('loo_cl/loo_view', $data);
        $this->load->view('template/v_footer');
    }
	
	function looprint(){		
        
        $i_link = $this->uri->segment(4);       

        $loo_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_loo_cl->viewlooprint($loo_id),
                  'loo_id'   => $loo_id
            );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();	
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loo_cl->sholdetilby_id($loo_id);
		
		$this->breadcrumbcomponent->add('Loo Unit ATM','loo_cl/loo_cl/loolist')
            ->add('Edit Loo','loo_cl/loo_cl/looedit');        

        $this->load->view('loo_cl/rptloo', $data);
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
  
    function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_loo_cl->get_branch_dlg($rSearch['term']);
	    $result['items']= $branch; 
        echo json_encode($result);
    }

    function branch_select(){
 
        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];
        $rRegion = empty($_GET['region']) ? '' : $_GET['region'];


        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            

            $this->load->model('template/Master_m');
            
            $branch      = $this->Master_m->get_branchbyquery($rSearch['term'], $rRegion); 
			
            $result['items']= $branch;
          
            echo json_encode($result);
            
        };
    }

    function agrtype_select(){
        
        $this->load->model('template/Master_m');
        $type = array('9100', '9500', '9600','20000');
        $agrtype      = $this->Master_m->get_agrtype($type);
        $options    = array('' => '==Pilih==');                
        
        if(count($agrtype)){
            foreach($agrtype as $key => $value){
                $options[$value->agreementtype_id]= $value->agreementtype_name;
            }
        } 
        return $options;
		
    }

    function agrtype_selecttype(){

        $lType = empty($_GET['lootype']) ? '' : $_GET['lootype'];
        $lType = trim($lType);    
        $options  = array(); 

        $casual = array('RENTAL TEMP', 'SERVICE TEMP', 'UTILITIES', 'OTHER', 'PS', 'DEPOSIT');

        $permanent = array('RENTAL', 'RENTAL TEMP', 'SERVICE', 'OTHER', 'LOAN', 'DEPOSIT');
        
        $this->load->model('template/Master_m');
		$type = array('20000');
        $agrtype      = $this->model_loo_cl->get_agrTypeCasual();
		
        $options['data'][] = array( 
                                'id'      => '',
                                'text'    => '',
                                'type'    => ''
        );            

        if(count($agrtype)){
            foreach($agrtype as $key => $value){

                // if (in_array($value->agreementtype_type, $permanent, TRUE)){
                    // $options['data'][] = array(
                            // 'id'       => $value->agreementtype_id,
                            // 'text'     => $value->agreementtype_name,
                            // 'type'     => 'PERMANENT'
                    // );
                // }

               // if (in_array($value->agreementtype_type, $casual, TRUE)){
                    $options['data'][] = array(
                            'id'       => $value->agreementtype_id,
                            'text'     => $value->agreementtype_name,
                            'type'     => 'CASUAL'
                    );
               // }
            }
        }
                    
        echo json_encode($options);
    }

    function titype_select(){                 

        $options    = array('' => '==Pilih=='); 
        
        $options['0'] = 'Hari';
        $options['1'] = 'Bulan';
        $options['2'] = 'Tahun';
                    
        return $options;
    }

    function unittype_select(){                 

        $this->load->model('template/Master_m');
        
        $unittype     = $this->Master_m->get_unittype();
       
        if(count($unittype)){
            foreach($unittype as $key => $value){
                $options[$value->unittype_id]= $value->unittype_name;
            }
        }
                    
        return $options;
    }

    function lootype_select(){                 

        $options    = array('' => '==Pilih=='); 
        
        //$options['0'] = 'Permanent Leasing';
        $options['1'] = 'Unit ATM';
                    
        return $options;
    }
     
    function loo_add(){        

        if ($_POST){
            
            $loo_id             = $this->input->post('loo_id');
            $loo_date           = $this->input->post('loo_date');
            $loo_sdate          = $this->input->post('loo_sdate');
            $loo_edate          = $this->input->post('loo_edate');
            $loo_term           = $this->input->post('loo_term');            
            $loo_descr          = $this->input->post('loo_descr'); 
            //$region             = $this->input->post('cboregion');
            //$branch             = $this->input->post('cbobranch');
            $lease              = 1;
            $tenant             = $this->input->post('htenant');
            $brand              = $this->input->post('hbrand');
            $_createby          = $this->session->userdata('user_fullname');//$this->input->post('_createby');
			$_modifyby	        = $this->input->post('_modifyby');
			$loo_line           = $this->input->post('tline');
            $loo_baserent       = $this->input->post('tcharge');
            $loo_space          = $this->input->post('tsize');
            $unit_id            = $this->input->post('tunit');
            $agrtype_id         = $this->input->post('tatype');
			$lantai             = $this->input->post('tlantai');
            $int                = $this->input->post('tint');
            $timetype           = $this->input->post('titype');
            $descr              = $this->input->post('tdescr');
            $loo_percent        = $this->input->post('tval');
            $_ispercent         = $this->input->post('tper');
            $skl_id             = $this->input->post('skl_id');
            $u_line             = $this->input->post('uline');
            $u_unit             = $this->input->post('uunit');
            $u_size             = $this->input->post('usize');
            $u_lantai           = $this->input->post('ulantai');
            $ismulti            = $this->input->post('ismulti');
            $unittype_id        = 6;
			$ismulti 			= $ismulti != '' ? '1' : '0';
            $loo_rent_desc      = $this->input->post('loo_rent_desc');
            $Objregion_id       = $this->input->post('Objregion_id');
            $Objbranch_id       = $this->input->post('Objbranch_id');
			$region             = $Objregion_id[0];  
			$usdate             = $this->input->post('usdate');
			$uedate             = $this->input->post('uedate');
			$branch_inject		= $Objbranch_id[0];
            $d_Region           = $this->input->post('dRegion');
            $d_Branch           = $this->input->post('dBranch');
            $d_Tenant           = $this->input->post('dTenant');
            $d_Brand            = $this->input->post('dBrand');
            $d_Start            = $this->input->post('dStart');
            $d_End              = $this->input->post('dEnd');
			$product_name       = $this->input->post('product_name');
            $fitting_out        = $this->input->post('fitting_out');
            $grace_period       = $this->input->post('grace_period');
            $size_indoor        = $this->input->post('size_indoor');
            $size_outdoor       = $this->input->post('size_outdoor');
			
            $this->load->model('template/Master_m');    
            $dtregion = $this->Master_m->get_regionbyid( $region );      
            			 
            $r_id = $dtregion[0]->region_nameshort;  
        	  
		  
        	$idx=$this->model_loo_cl->insertloo($loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, 
                $lease, $loo_line,$unit_id,$agrtype_id,$loo_baserent, $tenant, $brand, $int, $timetype, $loo_descr, $r_id,$region , 
                $skl_id, $descr, $_ispercent, $loo_percent, $u_line, $u_unit, $u_size, $u_lantai,$ismulti,$loo_rent_desc,$Objregion_id,$Objbranch_id,$unittype_id,
                $usdate,$uedate,$branch_inject, $d_Region, $d_Branch, $d_Start, $d_End, $product_name,$fitting_out,$grace_period,$size_indoor,$size_outdoor);

        	redirect("loo_cl/loo_cl/penalist");
        }
    }
  
    function loo_edit(){

            $loo_id             = $this->input->post('loo_id_2'); 
            $loo_date           = $this->input->post('loo_date');
            $loo_sdate          = $this->input->post('loo_sdate');
            $loo_edate          = $this->input->post('loo_edate');
            $loo_term           = $this->input->post('loo_term');            
            $loo_descr          = $this->input->post('loo_descr'); 
            //$region             = $this->input->post('cboregion');
            //$branch             = $this->input->post('cbobranch');
            $lease              = 1;
            $tenant             = $this->input->post('htenant');
            $brand              = $this->input->post('hbrand');
            $_createby          = '';
			$_modifyby	        = $this->session->userdata('user_fullname');
			$loo_line           = $this->input->post('tline');
            $loo_baserent       = $this->input->post('tcharge');
            $loo_space          = $this->input->post('tsize');
            $unit_id            = $this->input->post('tunit');
            $agrtype_id         = $this->input->post('tatype');
			$lantai             = $this->input->post('tlantai');
            $int                = $this->input->post('tint');
            $timetype           = $this->input->post('titype');
            $descr              = $this->input->post('tdescr');
            $loo_percent        = $this->input->post('tval');
            $_ispercent         = $this->input->post('tper');
            $skl_id             = $this->input->post('skl_id');
            $u_line             = $this->input->post('uline');
            $u_unit             = $this->input->post('uunit');
            $u_size             = $this->input->post('usize');
            $u_lantai           = $this->input->post('ulantai');
            $ismulti            = $this->input->post('ismulti');
            $unittype_id        = 6;
			$ismulti 			= $ismulti != '' ? '1' : '0';
            $loo_rent_desc      = $this->input->post('loo_rent_desc');
			$vObjregion_id      = $this->input->post('Objregion_id');
			//print_r($vObjregion_id );exit();
            $vObjbranch_id      = $this->input->post('Objbranch_id');
			
            $Objregion_id      = $this->input->post('uregion');
            $Objbranch_id      = $this->input->post('ubranch');
			$region             = $Objregion_id[0];  
            $conf_id      		= $this->input->post('conf_id');
            $isapprove      	= $this->input->post('isapprove');
			$usdate             = $this->input->post('usdate');
			$uedate             = $this->input->post('uedate');
			$branch_inject		= $Objbranch_id[0];
            $d_Region           = $this->input->post('dRegion');
            $d_Branch           = $this->input->post('dBranch');
		
            $d_Tenant           = $this->input->post('dTenant');
            $d_Brand            = $this->input->post('dBrand');
            $d_Start            = $this->input->post('dStart');
            $d_End              = $this->input->post('dEnd');            
			$product_name       = $this->input->post('product_name');
            $fitting_out        = $this->input->post('fitting_out');
            $grace_period       = $this->input->post('grace_period');
            $size_indoor        = $this->input->post('size_indoor');
            $size_outdoor       = $this->input->post('size_outdoor');
			
		$this->model_loo_cl->updateloo( $loo_id ,$loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, 
                $lease, $loo_line,$unit_id,$agrtype_id,$loo_baserent, $tenant, $brand, $int, $timetype, $loo_descr,$region , 
                $skl_id, $descr, $_ispercent, $loo_percent, $u_line, $u_unit, $u_size, $u_lantai,$ismulti,$loo_rent_desc,$Objregion_id,$Objbranch_id,$unittype_id,$conf_id,$isapprove,$usdate,$uedate,$branch_inject, $d_Region, $d_Branch, $d_Start, $d_End,$vObjregion_id,$vObjbranch_id, $product_name,$fitting_out,$grace_period,$size_indoor,$size_outdoor);
   
		redirect("loo_cl/loo_cl/penalist");
    }
	
	function loo_delete(){
		
        $i_link = $this->uri->segment(4);       

        $_id = str_replace('_', '/', $i_link); 

		$this->model_loo_cl->deleteloo($_id);
		//redirect("loo_cl/loo_cl/loolist");
		echo "berhasil";
	}

    function looprintpdf(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_loo_cl->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_loo_cl->getpromolevy($loo_id);
                $vpromolevy=$vpl['promolevy'];
                
                $dps=$this->model_loo_cl->getdepositr($loo_id);
                $vdps=$dps['depositr'];
                
                

        $data   = array(
                  'result'    => $this->model_loo_cl->viewlooprint($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_loo_cl->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_loo_cl->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loo_cl->sholdetilby_id($loo_id);    

        $html=$this->load->view('loo_cl/rptloo', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloo.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }
    
    function printconpdf(){     
                $i_link = $this->uri->segment(4);       
                $loo_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_loo_cl->getservicecharge($loo_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_loo_cl->getpromolevy($loo_id);
                $vpromolevy=$vpl['promolevy'];
                
                $dps=$this->model_loo_cl->getdepositr($loo_id);
                $vdps=$dps['depositr'];
                $nildps=$dps['loodetil_baserent'];
                
                

        $data   = array(
                  'result'    => $this->model_loo_cl->viewconfprint($loo_id),
                  'loo_id'   => $loo_id,
                  'vunit'    => $this->model_loo_cl->getunitloo($loo_id),
                  'vhargasewa'    => $this->model_loo_cl->gethargasewa($loo_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps,
                  'nildps' =>$nildps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loo_cl->sholdetilby_id($loo_id);    

        $html=$this->load->view('loo_cl/rptconf', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptlooconf.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  

        
    }

    function uploadjpg(){
        if($_POST) {

            $loo_id = $this->input->post('loo_id');
            $loo_id = str_replace('/', '_', $loo_id); 


            if (is_image($_FILES['files']['tmp_name'])) {
            
                $allowed = array('jpg', 'jpeg', 'png');

                if(isset($_FILES['files']) && $_FILES['files']['error'] == 0){

                    $extension = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION);

                    if(!in_array(strtolower($extension), $allowed)){
                        echo '{"status":"error"}';  
                        exit;                
                    }

                    if(move_uploaded_file($_FILES['files']['tmp_name'], FCPATH.'/assets/uploads/'.$loo_id.'.'.$extension)){

                        //echo '{"status":"success"}';                    
                        $success = 1;
                    }               
                }
            } else{
                $success = 0;
            }

        if ($success) {
            $result['files'][0] = array(
                'name'      => $loo_id.'.'.$extension,
                'size'      => 0,
                'url'       => base_url('/assets/uploads/'.$loo_id.'.'.$extension)
                );        
        }else{
            $result['files'][0] = array(
                'error'     => 'Unknown format',
                'url'       => '',
                'size'      => 0                
                );     
        }
    
        echo json_encode($result);
        }       
    }   
    
}  