<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listrikdo extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_listrik');
		    $this->load->library('breadcrumbcomponent');
		    $this->load->library('form_validation');
    }
    
    function index(){       
        redirect('listrik/listrikdo/listriklist');
    }
    function globalsearch_dialog(){
		$arcari=array('unit_name', 'region_id', 'branch_id');
		return $arcari;
	}   
    function globalsearch_reg(){
        $arcari=array('rekanan_name','rekananshipping_name', 'rekananutilitieslistrik_reg');
        return $arcari;
    }    
	
    function globalsearch_new(){
        $arcari=array('unittype_id');
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

    function controler_gridreg(){

        $branch_id =  isset($_POST['f_date']) ? $_POST['f_date']: '' ;        

        $braSearch = $branch_id <> '' ? "s_rek.branch_id = '$branch_id' " : '';

        $optSearch = $braSearch;      

        $arcari=$this->globalsearch_reg();
        $vResult=$this->initialize_grid("qry_allreg","qry_filterreg","qry_totalreg", $arcari, $optSearch);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];        

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['rekanan_id'];
            $row[]='';
            $row[]=$aRow['rekanan_id'];
            $row[]=$aRow['rekanan_name'];
            $row[]=$aRow['rekananshipping_line'];
            $row[]=$aRow['rekananshipping_name'];
            $row[]=$aRow['rekananutilitieslistrik_reg'];
            $row[]=$aRow['rekananutilitieslistrik_kva'];
            $row[]=$aRow['rekananutilitieslistrik_admpercent'];
            $row[]=$aRow['rekananutilitieslistrik_bpju'];
            $row[]=$aRow['branch_id'];

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
    
	function globalsearch_list(){
		$arcari=array('CTE.utilitieslistrik_id', 'CTE.region_id','CTE.branch_id','BRANCH.branch_name');
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
		
		$rResult=$this->model_listrik->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_listrik->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_listrik->$qry_totalall();
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

      $typeID = "CTE.utilitieslistriktype_id = 'DOUBLE' ";
      $optSearch = $typeID;

		  $arcari=$this->globalsearch_list();		
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist", $arcari, $optSearch);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {

            $is_post = ($aRow['isposted']) ? 1 : 0;
      
            $_menu='
                <a href="/index.php/listrik/listrikdo/listrikedit/'.$aRow['utilitieslistrik_id'].'" data-toggle="tooltip" title="Edit">
                <i class="fa fa-edit fa-lg"></i></a>
                <a href="/index.php/listrik/listrikdo/laprint5pdf/'.$aRow['utilitieslistrik_id'].'" data-toggle="tooltip" title="Edit" target="_blank">
                <i class="fa fa-print fa-lg"></i></a>
                <a href="/index.php/listrik/listrikdo/listrik_delete/'.$aRow['utilitieslistrik_id'].'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
                <i class="fa fa-trash fa-lg"></i></a>';

            $row = array();

			      $row[]=$aRow['utilitieslistrik_id'];            
            $row[]=date("d/m/Y", strtotime($aRow['utilitieslistrik_date']));
            $row[]=$aRow['utilitieslistrik_descr'];
            $row[]=$is_post;
			      $row[]=$aRow['region_name'];            
            $row[]=$aRow['branch_name'];
            $row[]=$aRow['strukturunit_name'];
			      $row[]=$_menu;
    	            
            if (!empty($row)) { $output['data'][] = $row; }
        }   
      echo json_encode($output);    		
    }

    function griddetil(){        

        $id = empty($_GET['id']) ? '' : $_GET['id'];

        $date = empty($_GET['date']) ? '' : trim($_GET['date']);
        $region = empty($_GET['region']) ? '' : trim($_GET['region']);
        $branch = empty($_GET['branch']) ? '' : trim($_GET['branch']);

        $id = trim($id);

        $output = $this->getdatadetail($id, $date, $region, $branch);
       
        echo json_encode($output);
    }   

    function getTenantbyid(){        
        
        $date = empty($_GET['date']) ? '' : trim($_GET['date']);
        $region = empty($_GET['region']) ? '' : trim($_GET['region']);
        $branch = empty($_GET['branch']) ? '' : trim($_GET['branch']);
        $tenant = empty($_GET['tenant']) ? '' : trim($_GET['tenant']);
        $brand = empty($_GET['brand']) ? '' : trim($_GET['brand']);       

        //$output = $this->getdatadetail($date, $region, $branch);
        $output = $this->model_listrik->getTenantbyid($date, $region, $branch, $tenant, $brand);        

      echo json_encode($output);
    }   

    function getdatadetail($_id, $_date, $_region, $_branch){

        if ($_id === 'auto'){ 
          $_id = ''; 
          $_state = 'insert';
        }else{
          $_state = 'update';
        }        
        
        $detil = $this->model_listrik->getdatadetil($_id, $_date, $_region, $_branch);

        $i = 0;        

        foreach ($detil as $rowd) {

            $i = $rowd->utilitieslistrikdetil_line;

            $result['data'][] = array(              
              'posted'            => '<input type="checkbox" id="posted"'. ($rowd->utilitieslistrikdetil_isposted == 1 ? 'checked= "checked"' : '').' disabled>',
              'line'              => $rowd->utilitieslistrikdetil_line,
              'tenant'            => substr($rowd->rekanan_name, 0, 20).'..',
              'brand'             => substr($rowd->shop_name, 0, 25).'..',
              'descr'             => '<input type="text" name="ddescr[]" value="'.$rowd->utilitieslistrikdetil_descr.'" class="pops form-control input-sm"/>
                                      <input type="hidden" name="dposted[]" value = "'.$rowd->utilitieslistrikdetil_isposted.'"/>
                                      <input type="hidden" name="dline[]" value="'.$rowd->utilitieslistrikdetil_line.'"/>
                                      <input type="hidden" name="dbrand_line[]" value = "'.$rowd->rekananshipping_line.'"/>
                                      <input type="hidden" name="dtenant_id[]" value = "'.$rowd->rekanan_id.'"/>
                                      <input type="hidden" name="drek_name[]" value = "'.$rowd->rekanan_name.'"/>
                                      <input type="hidden" name="drek_shop[]" value = "'.$rowd->shop_name.'"/>',
              'reg'               => substr($rowd->rekananutilitieslistrik_reg, 0, 25).'..'.'<input type="hidden" name="dreg[]" value = "'.$rowd->rekananutilitieslistrik_reg.'"/>',
              'agr'               => '<input type="text" id="d_agreement" name="dagreement[]" value="'.$rowd->agreement_id.'" class="detil form-control input-sm text-center"/>',
              'bagr'              => '<a id= "btnAgr" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></a>',
              'amp'               => '<input type="text" id="d_amp_'.$i.'" name="damp[]" value="'.$rowd->rekananutilitieslistrik_amp.'" class="detil form-control input-sm"  style= "text-align: right;"/>                                      
                                      <script type="text/javascript">$(\'#d_amp_'.$i.'\').number( true, 2 );</script>',
              'phase'             => number_format($rowd->rekananutilitieslistrik_phase,2).'<input type="hidden" id="d_phase" name="dphase[]" value="'.$rowd->rekananutilitieslistrik_phase.'"/>',
              'faktor'            => number_format($rowd->rekananutilitieslistrik_faktor,2).'<input type="hidden" id="d_faktor" name="dfaktor[]" value="'.$rowd->rekananutilitieslistrik_faktor.'"/>',
              'standawalwbp'      => '<input type="text" id="d_standawalwbp_'.$i.'" name="dstandawalwbp[]" value="'.$rowd->utilitieslistrikdetil_standawalwbp.'" class="detil form-control input-sm" style="text-align:right;"/>
                                      <script type="text/javascript">$(\'#d_standawalwbp_'.$i.'\').number( true, 2 );</script>',
              'standakhirwbp'     => '<input type="text" id="d_standakhirwbp_'.$i.'" name="dstandakhirwbp[]" value="'.$rowd->utilitieslistrikdetil_standakhirwbp.'" class="detil form-control input-sm" style="text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_standakhirwbp_'.$i.'\').number( true, 2 );</script>',
              'standawallwbp'     => '<input type="text" id="d_standawallwbp_'.$i.'" name="dstandawallwbp[]" value="'.$rowd->utilitieslistrikdetil_standawallwbp.'" class="detil form-control input-sm" style="text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_standawallwbp_'.$i.'\').number( true, 2 );</script>',
              'standakhirlwbp'    => '<input type="text" id="d_standakhirlwbp_'.$i.'" name="dstandakhirlwbp[]" value="'.$rowd->utilitieslistrikdetil_standakhirlwbp.'" class="detil form-control input-sm" style="text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_standakhirlwbp_'.$i.'\').number( true, 2 );</script>',
              'selisihwbp'        => '<input type="text" id="d_selisihwbp_'.$i.'" name="dselisihwbp[]" value="'.$rowd->utilitieslistrikdetil_selisihwbp.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_selisihwbp_'.$i.'\').number( true, 2 );</script>',
              'selisihlwbp'       => '<input type="text" id="d_selisihlwbp_'.$i.'" name="dselisihlwbp[]" value="'.$rowd->utilitieslistrikdetil_selisihlwbp.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_selisihlwbp_'.$i.'\').number( true, 2 );</script>',
              'selisih'           => '<input type="text" id="d_selisih_'.$i.'" name="dselisih[]" value="'.$rowd->utilitieslistrikdetil_selisih.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_selisih_'.$i.'\').number( true, 2 );</script>',
              'wbptotal'          => number_format($rowd->utilitieslistrikdetil_wbptotal,2).'<input type="hidden" id="d_wbptotal" name="dwbptotal[]" value="'.$rowd->utilitieslistrikdetil_wbptotal.'"/>',
              'lwbptotal'         => number_format($rowd->utilitieslistrikdetil_lwbptotal,2).'<input type="hidden" id="d_lwbptotal" name="dlwbptotal[]" value="'.$rowd->utilitieslistrikdetil_lwbptotal.'"/>',
              'pemakaianwbp'      => '<input type="text" id="d_pemakaianwbp_'.$i.'" name="dpemakaianwbp[]" value="'.$rowd->utilitieslistrikdetil_pemakaianwbp.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_pemakaianwbp_'.$i.'\').number( true, 2 );</script>',
              'pemakaianlwbp'     => '<input type="text" id="d_pemakaianlwbp_'.$i.'" name="dpemakaianlwbp[]" value="'.$rowd->utilitieslistrikdetil_pemakaianlwbp.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_pemakaianlwbp_'.$i.'\').number( true, 2 );</script>',
              'tarifwbp'          => '<input type="text" id="d_tarifwbp_'.$i.'" name="dtarifwbp[]" value="'.$rowd->utilitieslistrikdetil_tarifwbp.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_tarifwbp_'.$i.'\').number( true, 2 );</script>',
              'tariflwbp'         => '<input type="text" id="d_tariflwbp_'.$i.'" name="dtariflwbp[]" value="'.$rowd->utilitieslistrikdetil_tariflwbp.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_tariflwbp_'.$i.'\').number( true, 2 );</script>',
              'biayawbp'          => number_format($rowd->utilitieslistrikdetil_biayawbp,2).'<input type="hidden" id="d_biayawbp" name="dbiayawbp[]" value="'.$rowd->utilitieslistrikdetil_biayawbp.'"/>',
              'biayalwbp'         => number_format($rowd->utilitieslistrikdetil_biayalwbp,2).'<input type="hidden" id="d_biayalwbp" name="dbiayalwbp[]" value="'.$rowd->utilitieslistrikdetil_biayalwbp.'"/>',
              'biaya'             => number_format($rowd->utilitieslistrikdetil_biaya,2).'<input type="hidden" id="d_biaya" name="dbiaya[]" value="'.$rowd->utilitieslistrikdetil_biaya.'"/>',
              'bpju'              => number_format($rowd->utilitieslistrikdetil_bpju,2).'<input type="hidden" id="d_bpju" name="dbpju[]" value="'.$rowd->utilitieslistrikdetil_bpju.'"/>',
              'tagihan'           => number_format($rowd->utilitieslistrikdetil_tagihan,2).'<input type="hidden" id="d_tagihan" name="dtagihan[]" value="'.$rowd->utilitieslistrikdetil_tagihan.'"/>',
              'denda'             => '<input type="text" id="d_denda_'.$i.'" name="ddenda[]" value="'.$rowd->utilitieslistrikdetil_denda.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_denda_'.$i.'\').number( true, 2 );</script>',
              'administrasi'      => number_format($rowd->utilitieslistrikdetil_administrasi,2).'<input type="hidden" id="d_administrasi" name="dadministrasi[]" value="'.$rowd->utilitieslistrikdetil_administrasi.'"/>',
              'pemeliharaan'      => '<input type="text" id="d_pemeliharaan_'.$i.'" name="dpemeliharaan[]" value="'.$rowd->utilitieslistrikdetil_pemeliharaan.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_pemeliharaan_'.$i.'\').number( true, 2 );</script>',
              'jumlah'            => number_format($rowd->utilitieslistrikdetil_jumlah,2).'<input type="hidden" id="d_jumlah" name="djumlah[]" value="'.$rowd->utilitieslistrikdetil_jumlah.'"/>',
              'tax'               => '<input type="text" id="d_tax_'.$i.'" name="dtax[]" value="'.$rowd->rekananshipping_tax.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <input type="hidden" id="d_state_'.$i.'" name="dstate[]" value = "'.$_state.'"/>
                                      <script type="text/javascript">$(\'#d_tax_'.$i.'\').number( true, 2 );</script>',
              'delete'            => '<a id= "btnDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>'

            );
        }
        
        return $result;
    }

    function gridagreement(){        

        $rId    = empty($_GET['rid']) ? '' : trim($_GET['rid']);
        $rLine  = empty($_GET['rline']) ? '' : trim($_GET['rline']);
        $region = empty($_GET['region']) ? '' : trim($_GET['region']);
        $branch = empty($_GET['branch']) ? '' : trim($_GET['branch']);        
        
        $agree = $this->model_listrik->getdataagreement($rId, $rLine, $region, $branch);        

        foreach ($agree as $rowg) {

            $result['data'][] = array(    
              'checked'     => '',
              'id'          => $rowg->agreement_id,
              'debtor'      => $rowg->agreement_contractno,
              'virtualacc'  => '',
              'brand'       => $rowg->rekananshipping_name,
              'tenant'      => $rowg->rekanan_name,
              'region'      => $rowg->region_name,
              'store'       => $rowg->branch_name,
              'start'       => $rowg->agreement_startperiod,
              'end'         => $rowg->agreement_endperiod,
              'deduct'      => $rowg->agreement_deduct,
              'line'        => ''              
            );
        }        
        //print_r($result);
        echo json_encode($result);
    }      

    function recalculate(){       

        $id = empty($_GET['id']) ? '' : $_GET['id'];
        $date = empty($_GET['date']) ? '' : trim($_GET['date']);
        $region = empty($_GET['region']) ? '' : trim($_GET['region']);
        $branch = empty($_GET['branch']) ? '' : trim($_GET['branch']);

        $id = trim($id);

        if ($id === 'auto'){ $id = ''; }  
        
        $this->model_listrik->RecalculateWattTotal($id);

        $output = $this->getdatadetail($id, $date, $region, $branch);
       
        echo json_encode($output);  
    }     

    function listriklist(){
        
        $utilitieslistrik_id = $this->uri->segment(4);
        $data   = array(
                  'result'                  => $this->model_listrik->viewlistrik($utilitieslistrik_id),
                  'utilitieslistrik_id'     => $utilitieslistrik_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
		
		    $this->breadcrumbcomponent->add('Utilities Listrik','listrik/listrikdo/listriklist');

        $this->load->view('template/v_header');
        $this->load->view('listrik/listrikdo_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function listrikadd()
	{		
        
        $_id = $this->uri->segment(4);        
        
        $data   = array(
                  'result'                  => $this->model_listrik->viewlistrik($_id),
                  'utilitieslistrik_id'     => $_id
            );        
        
        $data['region']         = $this->region_select();
        $data['strukturunit']   = $this->strukturnit_select();

  		$this->breadcrumbcomponent->add('Utilities Listrik Double','listrik/listrikdo/listriklist')
            ->add('Utilities Listrik Double New','listrik/listrikdo/listrikadd');


        $this->load->view('template/v_header');
        $this->load->view('listrik/listrikdo_add', $data);
        $this->load->view('template/v_footer');
	}
    
	
	function listrikedit(){		
        
        $_url = $this->uri->segment(4);

        $_url = explode("_", $_url);  

        $branch = '';
        $region = '';      
        $date = '';
        $descr = '';
        $store = '';

        if ( $_url[0] == 'new' ) {
            $_id = '';
            $branch = $_url[1];
            $store = GetDataFromTable('master_branch', 'branch_id', 'branch_name', $branch);            

            $region = $_url[2];
            $date = '20'.substr($_url[3], 0, 2).'-'.substr($_url[3], 2, 2).'-'.'01';    
            $descr = 'Pemakaian Listrik Periode '.getIndoBulan(substr($_url[3], 2, 2)).' '.'20'.substr($_url[3], 0, 2);        

            $cekId = $this->model_listrik->CekTransaction($date, 'DOUBLE', $region, $branch);

            if (!empty($cekId)){
                $_id = $cekId;
                redirect("listrik/listrikdo/listrikedit/".$_id);
            }

        } else {
            $_id = $_url[0];
        }        

        $data   = array(
                  'result'                  => $this->model_listrik->viewlistrik($_id, $date, $region, $branch),
                  'utilitieslistrik_id'     => $_id,
                  'descr'                   => $descr,
                  'store'                   => $store
            );                
        
        $data['region']         = $this->region_select();
        $data['strukturunit']   = $this->strukturnit_select();

        $data['resultd'] = $this->model_listrik->vdetil($_id);
		
		    $this->breadcrumbcomponent->add('Utilities Listrik Double','listrik/listrikdo/listriklist')
            ->add('Edit Utilities Listrik Double','listrik/listrikdo/listrikedit');        

        $this->load->view('template/v_header');
        $this->load->view('listrik/listrikdo_edit', $data);
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
            
            $branch      = $this->model_listrik->get_branchbyall($rSearch['term']);
            
            $result['items']= $branch;
          
            echo json_encode($result);
            
        };
    }

    function periode_select(){       

        $period = $this->model_listrik->get_openperiode();

        $result['items']= $period;
                    
        echo json_encode($result);
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

        $filter = array('RENTAL', 'RENTAL TEMP');
        
        $agrtype      = $this->Master_m->get_agrtypefilter($filter);
        
        if(count($agrtype)){
            foreach($agrtype as $key => $value){
                $options[$value->agreementtype_id]= $value->agreementtype_name;
            }
        }
                    
        return $options;
    }    

    function listrik_edit(){         

        //print_r($_POST);exit;
        $_id                = $this->input->post('utilitieslistrik_id');
        $_channel           = $this->input->post('channel_id');
        $_date              = $this->input->post('utilitieslistrik_date');
        $branch_id          = $this->input->post('cbobranch');
        $region_id          = $this->input->post('cboregion');
        $strukturunit_id    = $this->input->post('cbostruktur');
        $_transaksi         = $this->input->post('htransaksi');
        $_descr             = $this->input->post('utilitieslistrik_descr');
        $_createby          = $this->session->userdata('user_fullname');
        $_createdate        = date("Y-m-d", time());
        $_modifyby          = $this->input->post('_modifyby');
        $_modifydate        = date("Y-m-d", time());
        $dposted            = $this->input->post('dposted');
        $dline              = $this->input->post('dline');
        $dtenant_id         = $this->input->post('dtenant_id');
        $dbrand_line        = $this->input->post('dbrand_line');
        $ddescr             = $this->input->post('ddescr');
        $dreg               = $this->input->post('dreg');
        $dagreement         = $this->input->post('dagreement');
        $damp               = $this->input->post('damp');
        $dblocked           = $this->input->post('dblocked');
        $dgenset            = $this->input->post('dgenset');
        $dbebankva          = $this->input->post('dbebankva');
        $dphase             = $this->input->post('dphase');
        $dfaktor            = $this->input->post('dfaktor');
        $dbpjumaster        = $this->input->post('dbpjumaster');
        $dadmamountmaster   = $this->input->post('dadmamountmaster');
        $dadmpercentmaster  = $this->input->post('dadmpercentmaster');
        $dreglimitmaster    = $this->input->post('dreglimitmaster');
        $dstandawalwbp      = $this->input->post('dstandawalwbp');
        $dstandakhirwbp     = $this->input->post('dstandakhirwbp');
        $dstandawallwbp     = $this->input->post('dstandawallwbp');
        $dstandakhirlwbp    = $this->input->post('dstandakhirlwbp');
        $dstandawal         = $this->input->post('dstandawal');
        $dakhir             = $this->input->post('dakhir');
        $dselisihwbp        = $this->input->post('dselisihwbp');
        $dselisihlwbp       = $this->input->post('dselisihlwbp');
        $dselisih           = $this->input->post('dselisih');
        $dwbptotal          = $this->input->post('dwbptotal');
        $dlwbptotal         = $this->input->post('dlwbptotal');
        $dpemakaianwbp      = $this->input->post('dpemakaianwbp');
        $dpemakaianlwbp     = $this->input->post('dpemakaianlwbp');
        $dtarifwbp          = $this->input->post('dtarifwbp');
        $dtariflwbp         = $this->input->post('dtariflwbp');
        $dbiayawbp          = $this->input->post('dbiayawbp');
        $dbiayalwbp         = $this->input->post('dbiayalwbp');
        $dbiaya             = $this->input->post('dbiaya');
        $dbpju              = $this->input->post('dbpju');
        $dtagihan           = $this->input->post('dtagihan');
        $ddenda             = $this->input->post('ddenda');
        $dadministrasi      = $this->input->post('dadministrasi');
        $djumlah            = $this->input->post('djumlah');
        $dtax               = $this->input->post('dtax');   

        $button             = $this->input->post('button');
        $dRekName           = $this->input->post('drek_name'); 
        $dRekShop           = $this->input->post('drek_shop');   
        $deleted            = $this->input->post('deleted');
        $dstate             = $this->input->post('dstate');       

        $type               = 'DOUBLE'; 

        IF ($button == "EXCEL") {
            //print_r($dline);exit;

            $data['line'] = $dline;
            $data['rekanan_id'] = $dtenant_id;
            $data['rekanan_name'] = $dRekName;
            $data['rekananshipping_line'] = $dbrand_line;
            $data['rekananshipping_name'] = $dRekShop;
            $data['rekananutilitieslistrik_reg'] = $dreg;
            $data['standakhir_wbp'] = $dstandakhirwbp;     
            $data['standakhir_lwbp'] = $dstandakhirlwbp;   

            $this->load->view('listrik/exp_dou_listrik', $data);

        } else {
        
          $this->form_validation->set_rules('cboregion', 'Business Unit', 'required');
          $this->form_validation->set_rules('cbobranch', 'Store', 'required');            
          
          if ($this->form_validation->run() == TRUE) { 
            if ($_id === 'auto') {

              /** Insert Listrik **/
              $idx = $this->model_listrik->insertlistrik(
                $_id, $_channel, $_date, $branch_id, $region_id, $strukturunit_id, $_transaksi, $_descr, 
                $_createby, $_createdate, $_modifyby, $_modifydate, $type, $dposted, $dline, $dtenant_id, $dbrand_line,
                $ddescr, $dreg, $dagreement, $damp, $dblocked, $dgenset, $dbebankva, $dphase, $dfaktor, $dbpjumaster,
                $dadmamountmaster, $dadmpercentmaster, $dreglimitmaster, $dstandawalwbp, $dstandawallwbp, $dstandawal,
                $dakhir, $dselisihwbp, $dselisihlwbp, $dselisih, $dwbptotal, $dlwbptotal, $dpemakaianwbp, $dpemakaianlwbp, 
                $dtarifwbp, $dtariflwbp, $dbiayawbp, $dbiayalwbp, $dbiaya, $dbpju, $dtagihan, $ddenda, $dadministrasi, $djumlah, $dtax
              );
            } else{
              /** Update Listrik **/
              $_createby = $this->input->post('utilitieslistrik_createby');
              $_createdate = $this->input->post('utilitieslistrik_createdate');;
              $_modifyby = $this->session->userdata('user_fullname');

              $idx = $this->model_listrik->updatelistrik(
                $_id, $_channel, $_date, $branch_id, $region_id, $strukturunit_id, $_transaksi, $_descr, 
                $_createby, $_createdate, $_modifyby, $_modifydate, $type, $dposted, $dline, $dtenant_id, $dbrand_line,
                $ddescr, $dreg, $dagreement, $damp, $dblocked, $dgenset, $dbebankva, $dphase, $dfaktor, $dbpjumaster,
                $dadmamountmaster, $dadmpercentmaster, $dreglimitmaster, $dstandawalwbp, $dstandawallwbp, $dstandawal,
                $dakhir, $dselisihwbp, $dselisihlwbp, $dselisih, $dwbptotal, $dlwbptotal, $dpemakaianwbp, $dpemakaianlwbp, 
                $dtarifwbp, $dtariflwbp, $dbiayawbp, $dbiayalwbp, $dbiaya, $dbpju, $dtagihan, $ddenda, $dadministrasi, 
                $djumlah, $dtax, $dstate, $deleted
              );
            }

            redirect("listrik/listrikdo/listrikedit/".$idx);
          }

        }
    }	

    function uploadExcel() {            

        if($_FILES['kampretFile']) { 

            $Name = $_FILES["kampretFile"]["name"];
            ///$sourceName = 'ULTRP1918070003'.'.xls';
            $tmp_name = $_FILES['kampretFile']['tmp_name'];

            if ($tmp_name) {
            
                $allowed = array('xls', 'xlsx', 'jpg');

                if(isset($_FILES['kampretFile']) && $_FILES['kampretFile']['error'] == 0){

                    $temp = explode(".", $_FILES["kampretFile"]["name"]);
                    $extension = end($temp);
                    
                    if(!in_array(strtolower($extension), $allowed)){
                        $success = 0; 
                        exit;                
                    }

                    if(move_uploaded_file($tmp_name, FCPATH.'/assets/uploads/'.$Name)){

                        $success = 1;
                    }               
                }
            } else{
                $success = 0;
            }

        if ($success) {
            $result['files'] = array(
                'name'      => $Name,
                'size'      => 0,
                'url'       => $Name
                );        
        }else{
            $result['files'] = array(
                'error'     => 'Unknown format',
                'url'       => '',
                'size'      => 0                
                );     
        }
    
        echo json_encode($result);
        }       
    }   

    function deleteExcel() {

        $response = array('status'=>false);
        
        $filename =  $_POST['path'];      

        $path = FCPATH.'/assets/uploads/'.$filename;        

        if ( file_exists($path) ) {
                  
          unlink($path);
          $response['status'] = true;
        }
      echo json_encode($response);
    }

}  