<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loc extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_loc');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
    }
    
    function index(){       
        redirect('loc/loc/loclist');
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
        $arcari=array('rekanan_id', 'rekananshipping_line', 'loo_id');
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

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }

    function controler_gridlookloo(){
        $arcari=$this->globalsearch_schema();
        $vResult=$this->initialize_grid("qry_alldatalook","qry_filteredlook","qry_totalalllook",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            
            $id=$aRow['loo_id'];
            $row[]=$aRow['loo_id'];
            $row[]=date("Y-m-d", strtotime($aRow['loo_date']));
            $row[]=$aRow['region_nameshort'];
            $row[]=$aRow['branch_name'];
            $row[]=$aRow['rekanan_name'];
            $row[]=$aRow['rekananshipping_name'];
            $row[]=$aRow['region_id'];
            $row[]=$aRow['branch_id'];
            $row[]=$aRow['rekanan_id'];
            $row[]=$aRow['rekananshipping_line'];
            $row[]=$aRow['unittype_id'];
            $row[]=date("Y-m-d", strtotime($aRow['loo_sdate']));
            $row[]=date("Y-m-d", strtotime($aRow['loo_edate']));
            $row[]=$aRow['loo_term'];
            $row[]=$aRow['loo_descr'];
            $row[]=$aRow['product_name'];
            $row[]=$aRow['fitting_out'];
            $row[]=$aRow['grace_period'];
            $row[]=$aRow['size_indoor'];
            $row[]=$aRow['size_outdoor'];
            $row[]=$aRow['debtor_no'];
            $row[]=$aRow['virtual_acc'];
            $row[]=$aRow['loo_type'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }
    
	function globalsearch_list(){
		$arcari=array('loc_id',  'CTE.region_id','CTE.rekanan_id','BRANCH.branch_name','REKAN.rekanan_name','BRAND.rekananshipping_name');
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
				$searchCol = $_POST['columns'][$i]['search']['value'];
				if ($searchCol != '') {
					if ($sWhere != ''){             
						$sWhere .= " AND ". $aColumns[$i] . " LIKE '%" . $searchCol . "%' ";
					} else {
						$sWhere = "WHERE ". $aColumns[$i] . " LIKE '%" . $searchCol . "%' ";
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
		
		$rResult=$this->model_loc->$qry_alldata($limit,$top,$sWhere);
		
		$rResultCnt =$this->model_loc->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_loc->$qry_totalall();
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
		
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['loc_id']);
            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
            $is_post = ($aRow['isconfirm']) ? 1 : 0;
            $is_post = ($aRow['isapproved']) ? 1 : 0;            

            $row = array();

			$row[]=$aRow['loc_id'];
            $row[]=date("d-m-Y", strtotime($aRow['loc_date']));
            $row[]=date("d-m-Y", strtotime($aRow['loc_sdate']));
            $row[]=date("d-m-Y", strtotime($aRow['loc_edate']));
			$row[]=$aRow['loc_term'];
			$row[]=$aRow['region_nameshort'];
			$row[]=$aRow['branch_name'];
            $row[]=$ship_name;
            $row[]=$aRow['rekananshipping_name'];
            $row[]=$aRow['isapproved'];
            $row[]=$aRow['isconfirm'];
			$row[]='
        <a href="/index.php/loc/loc/locedit/'.$i_link.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit fa-lg"></i></a> 
    	<a href="/index.php/locprint/locprint/locprintpdf/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank"><i class="fa fa-print fa-lg"></i></a>
        <a href="/index.php/locprint/locprint/invprintpdf/'.$i_link.'" data-toggle="tooltip" title="Invoice" target="_blank">
        <i class="fa fa-file fa-lg"></i></a>
    	<a href="/index.php/loc/loc/loc_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')"><i class ="fa fa-trash fa-lg"></i></a>';
    	
            if (!empty($row)) { $output['data'][] = $row; }
        	}   
        	echo json_encode($output);
    		
    }

    function loclist(){
        
        $loc_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_loc->viewloc($loc_id),
                  'loc_id'   => $loc_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
		
		$this->breadcrumbcomponent->add('LOC Permanent/Casual','loc/loclist');

        $this->load->view('template/v_header');
        $this->load->view('loc/loc_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function locadd()
	{		
        
        $loc_id = $this->uri->segment(4);        
        
        $data   = array(
                  'result'    => $this->model_loc->viewloc($loc_id),
                  'loc_id'   => $loc_id
            );        
        
        $data['region']  = $this->region_select();
        $data['lotype'] = $this->loctype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();
        $data['unittype']   = $this->unittype_select();

  		$this->breadcrumbcomponent->add('LOC Permanent/Casual','loc/loc/loclist')
            ->add('Input LOC Permanent/Casual','loc/loc/locadd');


        $this->load->view('template/v_header');
        $this->load->view('loc/loc_add', $data);
        $this->load->view('template/v_footer');
	}
    
	
	function locedit(){		
        
        $i_link = $this->uri->segment(4);       

        $loc_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_loc->viewloc($loc_id),
                  'loc_id'   => $loc_id
            );                
        
        $data['region']     = $this->region_select();
        $data['lotype']     = $this->loctype_select();	
        $data['agrtype']    = $this->agrtype_select();
        $data['titype']     = $this->titype_select();
        $data['unittype']   = $this->unittype_select(); 

        $data['resultd'] = $this->model_loc->sholdetilby_id($loc_id);
        $data['resultu'] = $this->model_loc->vdetilunitby_id($loc_id);
		
		$this->breadcrumbcomponent->add('LOC Permanent/Casual','loc/loc/loclist')
            ->add('Edit LOC Permanent/Casual','loc/loc/locedit');        

        $this->load->view('template/v_header');
        $this->load->view('loc/loc_edit', $data);
        $this->load->view('template/v_footer');
	}

    function locview(){     
        
        $cont =  $this->uri->segment(4);
        $i_link = $this->uri->segment(5);       

        $loc_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_loc->viewloc($loc_id),
                  'loc_id'   => $loc_id
            );                
        
        $data['region'] = $this->region_select();
        $data['lotype'] = $this->loctype_select(); 
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();

        $data['resultd'] = $this->model_loc->sholdetilby_id($loc_id);
        $data['cont'] = $cont;

        switch ($cont){
            case "locconf":
                $crumb              = "LOC Permanent/Casual Doc.Return";
                $data['tabpost']    = " Return";
                break;

            case "locapp":
                $crumb              = "LOC Approval";
                $data['tabpost']    = " Approve";
                break;
            case "printcon":
                $crumb = "Print Confirmation";
                break;

        }
        
        $this->breadcrumbcomponent->add($crumb,'loc/'.$cont)
            ->add('View LOC Permanent/Casual Doc.Return','loc/loc/locview');        

        $this->load->view('template/v_header');
        $this->load->view('loc/loc_view', $data);
        $this->load->view('template/v_footer');
    }
	
	function locprint(){		
        
        $i_link = $this->uri->segment(4);       

        $loc_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_loc->viewlocprint($loc_id),
                  'loc_id'   => $loc_id
            );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();	
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loc->sholdetilby_id($loc_id);
		
		$this->breadcrumbcomponent->add('Loc','loc/loc/loclist')
            ->add('Edit LoC','loc/loc/locedit');        

        $this->load->view('loc/rptloc', $data);
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
        
        $agrtype      = $this->Master_m->get_agrtype();
        $options    = array('' => '==Pilih==');                
        
        if(count($agrtype)){
            foreach($agrtype as $key => $value){
                $options[$value->agreementtype_id]= $value->agreementtype_name;
            }
        }
                    
        return $options;
    }

    function agrtype_selecttype(){

        $lType = empty($_GET['loctype']) ? '' : $_GET['loctype'];
        $lType = trim($lType);        

        $options  = array(); 

        $casual = array('RENTAL TEMP', 'SERVICE TEMP', 'UTILITIES', 'OTHER', 'PS', 'DEPOSIT');

        $permanent = array('RENTAL', 'RENTAL TEMP', 'SERVICE', 'OTHER', 'LOAN', 'DEPOSIT');
        
        $this->load->model('template/Master_m');
    
        $agrtype      = $this->Master_m->get_agrtypebytype($lType);
        $options['data'][] = array( 
                                'id'      => '',
                                'text'    => '',
                                'type'    => ''
        );            

        if(count($agrtype)){
            foreach($agrtype as $key => $value){

                if (in_array($value->agreementtype_type, $permanent, TRUE)){
                    $options['data'][] = array(
                            'id'       => $value->agreementtype_id,
                            'text'     => $value->agreementtype_name,
                            'type'     => 'PERMANENT'
                    );
                }

                if (in_array($value->agreementtype_type, $casual, TRUE)){
                    $options['data'][] = array(
                            'id'       => $value->agreementtype_id,
                            'text'     => $value->agreementtype_name,
                            'type'     => 'CASUAL'
                    );
                }
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
                if ( $value->unittype_id != 6 && $value->unittype_id != 7){

                    $options[$value->unittype_id]= $value->unittype_name;
                }
            }
        }
                    
        return $options;
    }

    function loctype_select(){                 

        $options    = array('' => '==Pilih=='); 
        
        $options['0'] = 'Permanent Leasing';
        $options['1'] = 'Casual Leasing';
                    
        return $options;
    }
    
    function loc_add(){        

        if ($_POST){
            
            $loc_id             = $this->input->post('loc_id');
            $loc_date           = $this->input->post('loc_date');
            $loc_sdate          = $this->input->post('loc_sdate');
            $loc_edate          = $this->input->post('loc_edate');
            $loc_term           = $this->input->post('loc_term');            
            $loc_descr          = $this->input->post('loc_descr'); 
            $region             = $this->input->post('cboregion');
            $branch             = $this->input->post('cbobranch');
            $lease              = $this->input->post('hlease');
            $unittype           = $this->input->post('cbounittype');
            $tenant             = $this->input->post('htenant');
            $brand              = $this->input->post('hbrand');
            $_createby          = $this->session->userdata('user_fullname');
			$_modifyby	        = $this->input->post('_modifyby');
            $_product           = $this->input->post('product_name');
            $_fitout            = $this->input->post('fitting_out');
            $_gperiod           = $this->input->post('grace_period');
            $_indoorz           = $this->input->post('size_indoor');            
            $_outdoorz          = $this->input->post('size_outdoor'); 
            $_ref               = $this->input->post('ref_id'); 
			$loc_line           = $this->input->post('tline');
            $loc_baserent       = $this->input->post('tcharge');
            $loc_space          = $this->input->post('tsize');
            $unit_id            = $this->input->post('tunit');
            $agrtype_id         = $this->input->post('tatype');
			$lantai             = $this->input->post('tlantai');
            $int                = $this->input->post('tint');
            $timetype           = $this->input->post('titype');
            $descr              = $this->input->post('tdescr');
            $loc_percent        = $this->input->post('tval');
            $_ispercent         = $this->input->post('tper');
            $d_region           = $this->input->post('dRegion');
            $d_branch           = $this->input->post('dBranch');
            $d_tenant           = $this->input->post('dTenant');
            $d_brand            = $this->input->post('dBrand');
            $skl_id             = $this->input->post('skl_id');
            $u_line             = $this->input->post('uline');
            $u_unit             = $this->input->post('uunit');
            $u_size             = $this->input->post('usize');
            $u_lantai           = $this->input->post('ulantai');
            $u_region           = $this->input->post('rregion');
            $u_branch           = $this->input->post('rbranch');
            $u_tenant           = $this->input->post('rtenant');
            $u_brand            = $this->input->post('rbrand');
            $debtor             = $this->input->post('idebtor');
            $virtual            = $this->input->post('ivirtual');

            $this->load->model('template/Master_m');    
            $dtregion = $this->Master_m->get_regionbyid($region);      
                       
            $r_id = $dtregion[0]->region_nameshort;  
			
			$this->form_validation->set_rules('cboregion', 'Business Unit', 'required');
			$this->form_validation->set_rules('cbobranch', 'Store', 'required'); 
			$this->form_validation->set_rules('cbounittype', 'Unit Type', 'required');
			$this->form_validation->set_rules('htenant', 'Tenant', 'required');
			
			if ($this->form_validation->run() == TRUE) { 
        	$idx=$this->model_loc->insertloc($loc_date, $loc_sdate, $loc_edate, $loc_term, $_createby, $_modifyby, $region, $branch, 
                $lease, $loc_line,$unit_id,$agrtype_id,$loc_baserent, $r_id, $tenant, $brand, $int, $timetype, $loc_descr, $unittype,
                $skl_id, $descr, $_ispercent, $loc_percent, $u_line, $u_unit, $u_size, $u_lantai, $d_region, $d_branch, $d_tenant, $d_brand,
                $u_region, $u_branch, $u_tenant, $u_brand, $_product, $_fitout, $_gperiod, $_indoorz, $_outdoorz, $_ref, $debtor, $virtual);

        	redirect("loc/loc/loclist");
			} else {
			$this->locadd();	
			}
        }
    }
  
    function loc_edit(){

            $loc_id             = $this->input->post('loc_id');
            $loc_date           = $this->input->post('loc_date');
            $loc_descr          = $this->input->post('loc_descr');
            $loc_sdate          = $this->input->post('loc_sdate');
            $loc_edate          = $this->input->post('loc_edate');
            $loc_term           = $this->input->post('loc_term');            
            $region             = $this->input->post('cboregion');
            $branch             = $this->input->post('cbobranch');
            $lease              = $this->input->post('hlease');
            $unittype           = $this->input->post('cbounittype');
            $tenant             = $this->input->post('htenant');
            $brand              = $this->input->post('hbrand');
            $_createby          = $this->input->post('_createby');
            $_modifyby          = $this->session->userdata('user_fullname');;
            $_product           = $this->input->post('product_name');
            $_fitout            = $this->input->post('fitting_out');
            $_gperiod           = $this->input->post('grace_period');
            $_indoorz           = $this->input->post('size_indoor');            
            $_outdoorz          = $this->input->post('size_outdoor');
            $_ref               = $this->input->post('ref_id');
            $loc_line           = $this->input->post('tline');
            $loc_baserent       = $this->input->post('tcharge');
            $unit_id            = $this->input->post('tunit');
            $agrtype_id         = $this->input->post('tatype');;
            $int                = $this->input->post('tint');
            $timetype           = $this->input->post('titype');
            $descr              = $this->input->post('tdescr');            
            $loc_percent        = $this->input->post('tval');
            $_ispercent         = $this->input->post('tper');        
            $d_region           = $this->input->post('dRegion');
            $d_branch           = $this->input->post('dBranch');
            $d_tenant           = $this->input->post('dTenant');
            $d_brand            = $this->input->post('dBrand');
            $skl_id             = $this->input->post('skl_id');
            $u_line             = $this->input->post('uline');
            $u_unit             = $this->input->post('uunit');
            $u_size             = $this->input->post('usize');
            $u_lantai           = $this->input->post('ulantai');
            $u_region           = $this->input->post('rregion');
            $u_branch           = $this->input->post('rbranch');
            $u_tenant           = $this->input->post('rtenant');
            $u_brand            = $this->input->post('rbrand');
            $debtor             = $this->input->post('idebtor');
            $virtual            = $this->input->post('ivirtual');

		$this->model_loc->updateloc($loc_id, $loc_date, $loc_descr, $loc_sdate, $loc_edate, $loc_term, $_createby, $_modifyby, $region, $branch, 
            $lease, $loc_line,$unit_id,$agrtype_id,$loc_baserent, $tenant, $brand, $int, $timetype, $descr, $_ispercent, $loc_percent,
            $u_line, $u_unit, $u_size, $u_lantai, $unittype, $skl_id, $d_region, $d_branch, $d_tenant, $d_brand, 
            $u_region, $u_branch, $u_tenant, $u_brand, $_product, $_fitout, $_gperiod, $_indoorz, $_outdoorz, $_ref, $debtor, $virtual);
        
		redirect("loc/loc/loclist");
    }
	
	function loc_delete(){
		
        $i_link = $this->uri->segment(4);       

        $_id = str_replace('_', '/', $i_link); 

		$this->model_loc->deleteloc($_id);
		redirect("loc/loc/loclist");
	}

    function loc_getdetil(){
        
        $id = empty($_GET['id']) ? '' : $_GET['id'];

        $id = trim($id);

        if ($id == 'auto'){ $id = ''; }            
       
        $rResult = $this->model_loc->get_detil($id);        

        foreach ($rResult as $aRow) {

            $row = array();            
            $row[]=$aRow['loo_id']; //0
            $row[]=$aRow['loodetil_line']; //1
            $row[]=$aRow['loodetil_int']; //2
            $row[]=$aRow['loodetil_descr']; //3
            $row[]=$aRow['loodetil_baserent']; //4
            $row[]=$aRow['loodetil_ispercent']; //5
            $row[]=$aRow['loodetil_percent']; //6
            $row[]=$aRow['loodetil_sdate']; //7
            $row[]=$aRow['loodetil_edate']; //8
            $row[]=$aRow['loodetil_term']; //9
            $row[]=$aRow['agreementtype_id']; //10
            $row[]=$aRow['unit_id']; //11
            $row[]=$aRow['timetype_id']; //12
            $row[]=$aRow['region_id']; //13
            $row[]=$aRow['branch_id']; //14
            $row[]=$aRow['rekanan_id']; //15
            $row[]=$aRow['rekananshipping_line']; //16
            $row[]=$aRow['agreementtype_name']; //17
            $row[]=$aRow['unit_name'];

        if (!empty($row)) { $output['data'][] = $row; }
        }   
        echo json_encode($output);
    }

    function loc_getunit(){
        
        $id = empty($_GET['id']) ? '' : $_GET['id'];

        $id = trim($id);

        if ($id == 'auto'){ $id = ''; }            
       
        $rResult = $this->model_loc->get_unit($id);        

        foreach ($rResult as $aRow) {

            $row = array();            
            $row[]=$aRow['loo_id']; //0
            $row[]=$aRow['loounit_line']; //1
            $row[]=$aRow['loounit_space']; //2
            $row[]=$aRow['unit_id']; //3
            $row[]=$aRow['lantai_id']; //4
            $row[]=$aRow['region_id']; //5
            $row[]=$aRow['branch_id']; //6
            $row[]=$aRow['rekanan_id']; //7
            $row[]=$aRow['rekananshipping_line']; //8
            $row[]=$aRow['unit_name']; //9
            $row[]=$aRow['unit_sqm']; //10
            
        if (!empty($row)) { $output['data'][] = $row; }
        }   
        echo json_encode($output);
    }

    function locprintpdf(){     
                $i_link = $this->uri->segment(4);       
                $loc_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_loc->getservicecharge($loc_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_loc->getpromolevy($loc_id);
                $vpromolevy=$vpl['promolevy'];
                
                $dps=$this->model_loc->getdepositr($loc_id);
                $vdps=$dps['depositr'];
                
                

        $data   = array(
                  'result'    => $this->model_loc->viewlocprint($loc_id),
                  'loc_id'   => $loc_id,
                  'vunit'    => $this->model_loc->getunitloc($loc_id),
                  'vhargasewa'    => $this->model_loc->gethargasewa($loc_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loc->sholdetilby_id($loc_id);    

        $html=$this->load->view('loc/rptloc', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptloc.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  
        
        
    }
    
    
    function printconpdf(){     
                $i_link = $this->uri->segment(4);       
                $loc_id = str_replace('_', '/', $i_link); 
                
                $vsc=$this->model_loc->getservicecharge($loc_id);
                $vhargasc=$vsc['servicecharge'];
                
                $vpl=$this->model_loc->getpromolevy($loc_id);
                $vpromolevy=$vpl['promolevy'];
                
                $dps=$this->model_loc->getdepositr($loc_id);
                $vdps=$dps['depositr'];
                $nildps=$dps['locdetil_baserent'];
                
                

        $data   = array(
                  'result'    => $this->model_loc->viewconfprint($loc_id),
                  'loc_id'   => $loc_id,
                  'vunit'    => $this->model_loc->getunitloc($loc_id),
                  'vhargasewa'    => $this->model_loc->gethargasewa($loc_id),
                  'vhargasc' =>$vhargasc,
                  'vpromolevy' =>$vpromolevy,
                  'vdps' =>$vdps,
                  'nildps' =>$nildps
                  
               );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();   
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_loc->sholdetilby_id($loc_id);    

        $html=$this->load->view('loc/rptconf', $data,TRUE);
        $this->load->library('m_pdf');
        $pdfFilePath = "rptlocconf.pdf";
        //$this->m_pdf->pdf->SetFont('zaskiagothic');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");  

        
    }

    function uploadjpg(){
        if($_POST) {

            $loc_id = $this->input->post('loc_id');
            $loc_id = str_replace('/', '_', $loc_id); 


            if ($_FILES['files']['tmp_name']) {
            
                $allowed = array('jpg', 'jpeg', 'png','pdf');

                if(isset($_FILES['files']) && $_FILES['files']['error'] == 0){

                   // $extension = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION);
				   $temp = explode(".", $_FILES["files"]["name"]);
					$extension = end($temp);
					
					
                    if(!in_array(strtolower($extension), $allowed)){
                        echo '{"status":"error"}';  
                        exit;                
                    }

                    if(move_uploaded_file($_FILES['files']['tmp_name'], FCPATH.'/assets/uploads/'.$loc_id.'.'.$extension)){

                        //echo '{"status":"success"}';                    
                        $success = 1;
                    }               
                }
            } else{
                $success = 0;
            }

        if ($success) {
            $result['files'][0] = array(
                'name'      => $loc_id.'.'.$extension,
                'size'      => 0,
                'url'       => base_url('/assets/uploads/'.$loc_id.'.'.$extension)
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