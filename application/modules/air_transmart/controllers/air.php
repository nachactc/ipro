<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Air extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_air');
		    $this->load->library('breadcrumbcomponent');
		    $this->load->library('form_validation');
    }
    
    function index(){       
        redirect('air/air/airlist');
    }
    function globalsearch_formula(){
		    $arcari=array('utilitiesairgas_id');
		  return $arcari;
	  }   
    function globalsearch_rekanan(){
        $arcari= array('rekanan_name','rekananshipping_name', 'branch_id');
      return $arcari;
    }
    function globalsearch_reg(){
        $arcari=array('rekanan_name','rekananshipping_name', 'rekananutilitiesair_reg');        
        return $arcari;
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
            $row[]=$aRow['rekananutilitiesair_reg'];
            $row[]=$aRow['rekananutilitiesair_phmeter'];
            $row[]=$aRow['rekananutilitiesair_abonemen'];
            $row[]=$aRow['rekananutilitiesair_admpercent'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);            
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

    function controler_gridformula(){
        $arcari=$this->globalsearch_formula();       

        $vResult=$this->initialize_grid("qry_allformula","qry_filteredformula","qry_totalallformula",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];        

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['utilitiesairgas_id'];
            $row[]= '';
            $row[]= $aRow['utilitiesairgas_number'];
            $row[]= $aRow['utilitiesairgas_minvalue'];
            $row[]= $aRow['utilitiesairgas_maxvalue'];
            $row[]= $aRow['utilitiesairgas_tarif'];
            $row[]= $aRow['utilitiesairgas_id'];

            if (!empty($row)) { $output['data'][] = $row; }
        }   
      echo json_encode($output);
            
    }
    
  	function globalsearch_list(){
  		$arcari=array('CTE.utilitiesairgas_id', 'CTE.region_id','CTE.branch_id','BRANCH.branch_name');
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
  		
  		$rResult=$this->model_air->$qry_alldata($limit,$top,$sWhere);
  			
  		$rResultCnt =$this->model_air->$qry_filtered($sWhere);
  		$iFilteredTotal = $rResultCnt['jml'];

  		$rResultTotal =$this->model_air->$qry_totalall();
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

      //$optSearch = "CTE.utilitiesairgas_type = 'UG'";    
      $username = $this->session->userdata('username');

      $braSearch = "( CTE.branch_id in (select branch_id from master_userbranch where username = '{$username}' ) )";
      $optSearch = $braSearch; 

		  $arcari=$this->globalsearch_list();		
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist", $arcari, $optSearch);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {

            $is_post = ($aRow['utilitiesairgas_isposted']) ? 1 : 0;
      
            $_menu='
                <a href="/index.php/air/air/airedit/'.$aRow['utilitiesairgas_id'].'" data-toggle="tooltip" title="Edit">
                <i class="fa fa-edit fa-lg"></i></a>
                <a href="/index.php/air/air/laprint5pdf/'.$aRow['utilitiesairgas_id'].'" data-toggle="tooltip" title="Edit" target="_blank">
                <i class="fa fa-print fa-lg"></i></a>
                <a href="/index.php/air/air/airdelete/'.$aRow['utilitiesairgas_id'].'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
                <i class="fa fa-trash fa-lg"></i></a>';

            $row = array();
			      $row[]=$aRow['utilitiesairgas_id'];            
            $row[]=date("d/m/Y", strtotime($aRow['utilitiesairgas_date']));
            $row[]=$aRow['utilitiesairgas_descr'];
            $row[]=$is_post;
			      $row[]=$aRow['region_name'];            
            $row[]=$aRow['branch_name'];
            $row[]=$aRow['strukturunit_name'];
            $row[]=$aRow['utilitiesairgas_createby'];
            $row[]=$aRow['utilitiesairgas_createdate'];
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
        $calc = empty($_GET['calc']) ? '' : trim($_GET['calc']);

        $id = trim($id);

        $output = $this->getdatadetail($id, $date, $region, $branch, $calc);
       
        echo json_encode($output);
    }   

    function getTenantbyid(){        
        
        $date     = empty($_GET['date']) ? '' : trim($_GET['date']);
        $region   = empty($_GET['region']) ? '' : trim($_GET['region']);
        $branch   = empty($_GET['branch']) ? '' : trim($_GET['branch']);
        $tenant   = empty($_GET['tenant']) ? '' : trim($_GET['tenant']);
        $brand    = empty($_GET['brand']) ? '' : trim($_GET['brand']);       
        $calc_id  = empty($_GET['calcid']) ? '' : trim($_GET['calcid']);     

        //$output = $this->getdatadetail($date, $region, $branch);
        $output = $this->model_air->getTenantbyid($date, $region, $branch, $tenant, $brand, $calc_id);        

      echo json_encode($output);
    }   

    function getdatadetail($_id, $_date, $_region, $_branch, $_calc){

        if ($_id === 'auto'){ 
          $_id = ''; 
          $_state = 'insert';
        }else{
          $_state = 'update';
        }        
        
        $detil = $this->model_air->getairdetil($_id, $_date, $_region, $_branch, $_calc);        

        $i = 0;        

        foreach ($detil as $rowd) {

            $i = $rowd->utilitiesairgasdetil_line;

            $result['data'][] = array(   
			  'del'            => '<a id= "rDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a>',			
              'posted'            => '<input type="checkbox" id="posted"'. ($rowd->utilitiesairgasdetil_isposted == 1 ? 'checked= "checked"' : '').' disabled>',
              'line'              => $rowd->utilitiesairgasdetil_line,
              'tenant'            => substr($rowd->rekanan_name, 0, 20).'..',
              'brand'             => substr($rowd->rekananshipping_name, 0, 25).'..',
              'standakhir'        => '<input type="text" id="d_standakhir_'.$i.'" name="dstandakhir[]" value="'.$rowd->utilitiesairgasdetil_standakhir.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_standakhir_'.$i.'\').number( true, 5 );</script>',
              'standawal'         => '<input type="text" id="d_standawal_'.$i.'" name="dstandawal[]" value="'.$rowd->utilitiesairgasdetil_standawal.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_standawal_'.$i.'\').number( true, 5 );</script>',
              'pemakaian'         => '<input type="text" id="d_pemakaian_'.$i.'" name="dpemakaian[]" value="'.$rowd->utilitiesairgasdetil_pemakaian.'" class="detil form-control input-sm" style= "text-align: right;" readonly/>
                                      <script type="text/javascript">$(\'#d_pemakaian_'.$i.'\').number( true, 5 );</script>',
              'pemakaianlalu'     => '<input type="text" id="d_pemakaianlalu_'.$i.'" name="dpemakaianlalu[]" value="'.$rowd->utilitiesairgasdetil_pemakaianlalu.'" class="detil form-control input-sm" style= "text-align: right;" readonly/>
                                      <script type="text/javascript">$(\'#d_pemakaianlalu_'.$i.'\').number( true, 5 );</script>',
              'pemakaianavg'      => '<input type="text" id="d_pemakaianavg_'.$i.'" name="dpemakaianavg[]" value="'.$rowd->utilitiesairgasdetil_pemakaianavg.'" class="detil form-control input-sm" style= "text-align: right;" readonly/>
                                      <script type="text/javascript">$(\'#d_pemakaianavg_'.$i.'\').number( true, 5 );</script>',
              'descr'             => '<input type="text" name="ddescr[]" value="'.$rowd->utilitiesairgasdetil_descr.'" class="pops form-control input-sm"/>
                                      <input type="hidden" name="dposted[]" value = "'.$rowd->utilitiesairgasdetil_isposted.'"/>
                                      <input type="hidden" name="dline[]" value="'.$rowd->utilitiesairgasdetil_line.'"/>
                                      <input type="hidden" name="dbrand_line[]" value = "'.$rowd->rekananshipping_line.'"/>
                                      <input type="hidden" name="dtenant_id[]" value = "'.$rowd->rekanan_id.'"/>
                                      <input type="hidden" name="drek_name[]" value = "'.$rowd->rekanan_name.'"/>
                                      <input type="hidden" name="drek_shop[]" value = "'.$rowd->rekananshipping_name.'"/>',
              'reg'               => substr($rowd->utilitiesairgasdetil_reg, 0, 25).'..'.'<input type="hidden" name="dreg[]" value = "'.$rowd->utilitiesairgasdetil_reg.'"/>',
              'unit'              => $rowd->utilitiesairgasdetil_unit.'<input type="hidden" name="dunit[]" value = "'.$rowd->utilitiesairgasdetil_unit.'"/>',
              'agr'               => '<input type="text" id="d_agreement" name="dagreement[]" value="'.$rowd->agreement_id.'" class="detil form-control input-sm text-center"/>',
              'bagr'              => '<a id= "btnAgr" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></a>',
              'pipa'              => $rowd->utilitiesairgasdetil_diameterpipa.'<input type="hidden" name="dpipa[]" value = "'.$rowd->utilitiesairgasdetil_diameterpipa.'"/>',              
              'blok1'             => number_format($rowd->utilitiesairgasdetil_spec1meter,5).'<input type="hidden" id="d_blok1_'.$i.'" name="dblok1[]" value="'.$rowd->utilitiesairgasdetil_spec1meter.'"/>',
              'tarifb1'           => number_format($rowd->utilitiesairgasdetil_spec1tarif,5).'<input type="hidden" id="d_tarifb1_'.$i.'" name="dtarifb1[]" value="'.$rowd->utilitiesairgasdetil_spec1tarif.'"/>',
              'totalb1'           => number_format($rowd->utilitiesairgasdetil_spec1amount,5).'<input type="hidden" id="d_totalb1_'.$i.'" name="dtotalb1[]" value="'.$rowd->utilitiesairgasdetil_spec1amount.'"/>',
              'blok2'             => number_format($rowd->utilitiesairgasdetil_spec2meter,5).'<input type="hidden" id="d_blok2_'.$i.'" name="dblok2[]" value="'.$rowd->utilitiesairgasdetil_spec2meter.'"/>',
              'tarifb2'           => number_format($rowd->utilitiesairgasdetil_spec2tarif,5).'<input type="hidden" id="d_tarifb2_'.$i.'" name="dtarifb2[]" value="'.$rowd->utilitiesairgasdetil_spec2tarif.'"/>',
              'totalb2'           => number_format($rowd->utilitiesairgasdetil_spec2amount,5).'<input type="hidden" id="d_totalb2_'.$i.'" name="dtotalb2[]" value="'.$rowd->utilitiesairgasdetil_spec2amount.'"/>',
              'blok3'             => number_format($rowd->utilitiesairgasdetil_spec3meter,5).'<input type="hidden" id="d_blok3_'.$i.'" name="dblok3[]" value="'.$rowd->utilitiesairgasdetil_spec3meter.'"/>',
              'tarifb3'           => number_format($rowd->utilitiesairgasdetil_spec3tarif,5).'<input type="hidden" id="d_tarifb3_'.$i.'" name="dtarifb3[]" value="'.$rowd->utilitiesairgasdetil_spec3tarif.'"/>',
              'totalb3'           => number_format($rowd->utilitiesairgasdetil_spec3amount,5).'<input type="hidden" id="d_totalb3_'.$i.'" name="dtotalb3[]" value="'.$rowd->utilitiesairgasdetil_spec3amount.'"/>',
              'blok4'             => number_format($rowd->utilitiesairgasdetil_spec4meter,5).'<input type="hidden" id="d_blok4_'.$i.'" name="dblok4[]" value="'.$rowd->utilitiesairgasdetil_spec4meter.'"/>',
              'tarifb4'           => number_format($rowd->utilitiesairgasdetil_spec4tarif,5).'<input type="hidden" id="d_tarifb4_'.$i.'" name="dtarifb4[]" value="'.$rowd->utilitiesairgasdetil_spec4tarif.'"/>',
              'totalb4'           => number_format($rowd->utilitiesairgasdetil_spec4amount,5).'<input type="hidden" id="d_totalb4_'.$i.'" name="dtotalb4[]" value="'.$rowd->utilitiesairgasdetil_spec4amount.'"/>',
              'totalpakai'        => number_format($rowd->utilitiesairgasdetil_specamounttotal,5).'<input type="hidden" id="d_totalpakai_'.$i.'" name="dtotalpakai[]" value="'.$rowd->utilitiesairgasdetil_specamounttotal.'"/>',
              'pelihara'          => number_format($rowd->utilitiesairgasdetil_pemeliharaan,5).'<input type="hidden" id="d_pelihara_'.$i.'" name="dpelihara[]" value="'.$rowd->utilitiesairgasdetil_pemeliharaan.'"/>',
              'phairkotor'        => number_format($rowd->utilitiesairgasdetil_phairkotor,5).'<input type="hidden" id="d_phairkotor_'.$i.'" name="dphairkotor[]" value="'.$rowd->utilitiesairgasdetil_phairkotor.'"/>',
              'phmeter'           => number_format($rowd->utilitiesairgasdetil_phmeter,5).'<input type="hidden" id="d_phmeter_'.$i.'" name="dphmeter[]" value="'.$rowd->utilitiesairgasdetil_phmeter.'"/>',
              'materai'           => '<input type="text" id="d_materai_'.$i.'" name="dmaterai[]" value="'.$rowd->utilitiesairgasdetil_materai.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_materai_'.$i.'\').number( true, 5 );</script>',
              'denda'             => '<input type="text" id="d_denda_'.$i.'" name="ddenda[]" value="'.$rowd->utilitiesairgasdetil_denda.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_denda_'.$i.'\').number( true, 5 );</script>',
              'subtotal'          => number_format($rowd->utilitiesairgasdetil_subtotal,5).'<input type="hidden" id="d_subtotal" name="dsubtotal[]" value="'.$rowd->utilitiesairgasdetil_subtotal.'"/>',
              'administrasi'      => number_format($rowd->utilitiesairgasdetil_adm,5).'<input type="hidden" id="d_administrasi" name="dadministrasi[]" value="'.$rowd->utilitiesairgasdetil_adm.'"/>',
              'total'             => number_format($rowd->utilitiesairgasdetil_total,5).'<input type="hidden" id="d_total" name="dtotal[]" value="'.$rowd->utilitiesairgasdetil_total.'"/>',
              'tax'               => '<input type="text" id="d_tax_'.$i.'" name="dtax[]" value="'.$rowd->rekananshipping_tax.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <input type="hidden" id="d_state_'.$i.'" name="dstate[]" value = "'.$_state.'"/>
                                      <script type="text/javascript">$(\'#d_tax_'.$i.'\').number( true, 5 );</script>',                                      
              'berita'            => '<div class="input-group input-group-sm">
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary">
                                            <i class="fa fa-folder-open"></i><input type="file" style="display: none;" id="d_file_'.$i.'" name="dfile">
                                            </span>
                                        </label>
                                        <input id="d_link_'.$i.'" name="dlink[]" type="text" class="form-control" value = "'.$rowd->utilitiesairgasdetil_link.'" readonly>
                                        <span class="input-group-btn">
                                            <button id ="addBerita" type="button" class="btn blue btn-outline btn-sm"><i class="fa fa-cloud-upload"></i></button>                                                                                                                                    
                                            <button class="btn blue btn-outline" disabled></button>
                                        </span>
                                      </div>                                      
                                      <script type="text/javascript">
                                        $(\'#d_file_'.$i.'\').on(\'change\', function(){        
                                            var file = $(this).prop(\'files\')[0];                                            
                                            var label = $(this).val().replace(/\\\\/g, \'/\').replace(/.*\//, \'\');                                            
                                            $(\'#d_link_'.$i.'\').val(label);
                                        });
                                      </script>',
              'link'              =>  '<div class="link-url"><a href='.(empty($rowd->utilitiesairgasdetil_link) ? "javascript:;" : "/assets/uploads/".$rowd->utilitiesairgasdetil_link).' class="btn btn-sm green btn-primary" target="_blank"><i class="fa fa-file-text-o"></i> Download</a></div>'
            );
        }
        
        return $result;
    }

    function gridagreement(){        

        $rId    = empty($_GET['rid']) ? '' : trim($_GET['rid']);
        $rLine  = empty($_GET['rline']) ? '' : trim($_GET['rline']);
        $region = empty($_GET['region']) ? '' : trim($_GET['region']);
        $branch = empty($_GET['branch']) ? '' : trim($_GET['branch']);        
        
        $agree = $this->model_air->getdataagreement($rId, $rLine, $region, $branch);        

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
        $calc = empty($_GET['calc']) ? '' : trim($_GET['calc']);

        $id = trim($id);

        if ($id === 'auto'){ $id = ''; }  
        
        $this->model_air->RecalculateAir($id);

        $output = $this->getdatadetail($id, $date, $region, $branch, $calc);
       
        echo json_encode($output);  
    }     

    function airlist(){
        
        $utilitiesairgas_id = $this->uri->segment(4);

        $data   = array(
                  //'result'                  => $this->model_gas->viewgas($utilitiesairgas_id),
                  'utilitiesairgas_id'     => $utilitiesairgas_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
		
		    $this->breadcrumbcomponent->add('Utilities Air','air/airlist');

        $this->load->view('template/v_header');
        $this->load->view('air/air_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function airadd(){		
        
        $_id = $this->uri->segment(4);        
        
        $data   = array(
                  //'result'                  => $this->model_listrik->viewlistrik($_id),
                  'utilitiesairgas_id'     => $_id
            );        
        
        $data['region']         = $this->region_select();
        $data['strukturunit']   = $this->strukturnit_select();

  		  $this->breadcrumbcomponent->add('Utilities Air','air/airlist')
            ->add('Utilities Air New','air/air/airadd');


        $this->load->view('template/v_header');
        $this->load->view('air/air_add', $data);
        $this->load->view('template/v_footer');
	  }
    
	
	  function airedit(){		
        
        $_id = $this->uri->segment(4);       

        $branch = '';
        $region = '';      
        $date = '';
        $descr = '';
        $store = '';
        $calc = '';

        if ($_POST){

            $branch     = $this->input->post('storeSearch');
            $region     = $this->input->post('regionSearch_hidden');
            $period     = $this->input->post('periodSearch');
            $calc       = $this->input->post('calcSearch');
           
            $store = GetDataFromTable('master_branch', 'branch_id', 'branch_name', $branch);            

            $date = '20'.substr($period, 0, 2).'-'.substr($period, 2, 2).'-'.'01';    
            $descr = 'Pemakaian Air Periode '.getIndoBulan(substr($period, 2, 2)).' '.'20'.substr($period, 0, 2);

            $cekId = $this->model_air->CekTransaction($date, $region, $branch);

            if (!empty($cekId)){
                $_id = $cekId;
                redirect("air/air/airedit/".$_id);
            }
        }      

        $data   = array(
                  'result'                  => $this->model_air->viewair($_id, $date, $region, $branch, $calc),
                  'utilitiesairgas_id'      => $_id,
                  'descr'                   => $descr,
                  'store'                   => $store
            );                
        
        $data['region']         = $this->region_select();
        $data['strukturunit']   = $this->strukturnit_select();

        //$data['resultd'] = $this->model_gas->vdetil($_id);
		    $this->breadcrumbcomponent->add('Utilities Air','air/air/airlist')
            ->add('Edit Utilities Air','air/air/airedit');        

        $this->load->view('template/v_header');
        $this->load->view('air/air_edit', $data);
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
            
            $branch      = $this->model_air->get_branchbyall($rSearch['term']);
            
            $result['items']= $branch;
          
            echo json_encode($result);
            
        };
    }

    function periode_select(){       

        $period = $this->model_air->get_openperiode();

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

    function calc_select(){        

        $rBranch = empty($_GET['branch']) ? '' : $_GET['branch'];
        
        $calculation = $this->model_air->get_CalcMethode($rBranch);

        $result['items']= $calculation;

      echo json_encode($result);
    }    

    function air_edit(){         

        //print_r($_POST);exit;
        $_id                = $this->input->post('utilitiesairgas_id');
        $_channel           = $this->input->post('channel_id');
        $_date              = $this->input->post('utilitiesairgas_date');
        $branch_id          = $this->input->post('cbobranch');
        $region_id          = $this->input->post('cboregion');
        $strukturunit_id    = $this->input->post('cbostruktur');
        $_transaksi         = $this->input->post('htransaksi');
        $_descr             = $this->input->post('utilitiesairgas_descr');
        $_createby          = $this->session->userdata('user_fullname');
        $_createdate        = date("Y-m-d", time());
        $_modifyby          = $this->input->post('_modifyby');
        $_modifydate        = date("Y-m-d", time());
        $_calcmethod        = $this->input->post('utilitiesairgas_calcmethodid');
        $dposted            = $this->input->post('dposted');
        $dline              = $this->input->post('dline');
        $dtenant_id         = $this->input->post('dtenant_id');
        $dbrand_line        = $this->input->post('dbrand_line');
        $ddescr             = $this->input->post('ddescr');
        $dreg               = $this->input->post('dreg');
        $dagreement         = $this->input->post('dagreement');
        $dstandawal         = $this->input->post('dstandawal');
        $dstandakhir        = $this->input->post('dstandakhir');
        $dpipa              = $this->input->post('dpipa');
        $dpemakaian         = $this->input->post('dpemakaian');
        $dblok1             = $this->input->post('dblok1');
        $dtarifb1           = $this->input->post('dtarifb1');
        $dtotalb1           = $this->input->post('dtotalb1');
        $dblok2             = $this->input->post('dblok2');
        $dtarifb2           = $this->input->post('dtarifb2');
        $dtotalb2           = $this->input->post('dtotalb2');
        $dblok3             = $this->input->post('dblok3');
        $dtarifb3           = $this->input->post('dtarifb3');
        $dtotalb3           = $this->input->post('dtotalb3');
        $dblok4             = $this->input->post('dblok4');
        $dtarifb4           = $this->input->post('dtarifb4');
        $dtotalb4           = $this->input->post('dtotalb4');
        $dtotalpakai        = $this->input->post('dtotalpakai');
        $dpelihara          = $this->input->post('dpelihara');
        $dphairkotor        = $this->input->post('dphairkotor');
        $dphmeter           = $this->input->post('dphmeter');
        $dmaterai           = $this->input->post('dmaterai');
        $ddenda             = $this->input->post('ddenda');
        $dsubtotal          = $this->input->post('dsubtotal');
        $dadministrasi      = $this->input->post('dadministrasi');
        $dtotal             = $this->input->post('dtotal');
        $dtax               = $this->input->post('dtax');   
        $dpemakaianlalu     = $this->input->post('dpemakaianlalu');   
        $dpemakaianavg      = $this->input->post('dpemakaianavg');   

        $button             = $this->input->post('button');
        $dRekName           = $this->input->post('drek_name'); 
        $dRekShop           = $this->input->post('drek_shop');   
        $deleted            = $this->input->post('deleted');
        $dstate             = $this->input->post('dstate');        

        IF ($button == "EXCEL") {          
            //print_r($dline);exit;
            $data['line']                         = $dline;
            $data['rekanan_id']                   = $dtenant_id;
            $data['rekanan_name']                 = $dRekName;
            $data['rekananshipping_line']         = $dbrand_line;
            $data['rekananshipping_name']         = $dRekShop;
            $data['rekananutilitiesgas_reg']      = $dreg;
            $data['stand_akhir']                  = $dstandakhir;            

            //$this->load->view('air/exp_air', $data);
            $this->createSaldoFile($data);

        } else {
        
          $this->form_validation->set_rules('cboregion', 'Business Unit', 'required');
          $this->form_validation->set_rules('cbobranch', 'Store', 'required');            
          
          if ($this->form_validation->run() == TRUE) { 
            if ($_id === 'auto') {

              /** Insert Listrik **/
              $idx = $this->model_air->insertair(
                $_id, $_channel, $_date, $branch_id, $region_id, $strukturunit_id, $_transaksi,
                $_descr, $_createby, $_createdate, $_modifyby, $_modifydate, $_calcmethod, $dposted, $dline,
                $dtenant_id, $dbrand_line, $ddescr, $dreg, $dagreement, $dstandawal, $dstandakhir,
                $dpipa, $dpemakaian, $dblok1, $dtarifb1, $dtotalb1, $dblok2, $dtarifb2, $dtotalb2,
                $dblok3, $dtarifb3, $dtotalb3, $dblok4, $dtarifb4, $dtotalb4, $dtotalpakai, $dpelihara,
                $dphairkotor, $dphmeter, $dmaterai, $ddenda, $dsubtotal, $dadministrasi, $dtotal, $dtax, 
                $dpemakaianlalu, $dpemakaianavg
              );
            } else{
              /** Update Listrik **/
              $_createby = $this->input->post('utilitiesairgas_createby');
              $_createdate = $this->input->post('utilitiesairgas_createdate');;
              $_modifyby = $this->session->userdata('user_fullname');

              $idx = $this->model_air->updateair(
                $_id, $_channel, $_date, $branch_id, $region_id, $strukturunit_id, $_transaksi,
                $_descr, $_createby, $_createdate, $_modifyby, $_modifydate, $_calcmethod, $dposted, $dline,
                $dtenant_id, $dbrand_line, $ddescr, $dreg, $dagreement, $dstandawal, $dstandakhir,
                $dpipa, $dpemakaian, $dblok1, $dtarifb1, $dtotalb1, $dblok2, $dtarifb2, $dtotalb2,
                $dblok3, $dtarifb3, $dtotalb3, $dblok4, $dtarifb4, $dtotalb4, $dtotalpakai, $dpelihara,
                $dphairkotor, $dphmeter, $dmaterai, $ddenda, $dsubtotal, $dadministrasi, $dtotal, $dtax, $dstate, $deleted,
                $dpemakaianlalu, $dpemakaianavg
              );
            }

            redirect("air/air/airedit/".$idx);
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

     function createSaldoFile($data){

        $this->load->library("Excel/PHPExcel");        

        //membuat objek PHPExcel
        $objPHPExcel = new PHPExcel();

        // add style to the header
        $styleArray = array(
          'font' => array(
            'bold' => true,
          ),
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          ),
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
          ),
        );

        $styleBody = array(              
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN,
            ),
          ),
        );             

        // auto fit column to content
        foreach(range('A','F') as $columnID) {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
          ->setAutoSize(true);
        }       

        // set the names of header cells
        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue("A1",'TENANT_ID')
          ->setCellValue("B1",'TENANT_NAME')          
          ->setCellValue("C1",'TOKO_ID')
          ->setCellValue("D1",'TOKO_NAME')
          ->setCellValue("E1",'REG_ID')
          ->setCellValue("F1",'STAND_AKHIR');

        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray);

        $x= 2;        

        foreach($data['line'] as $val=>$n){ 

            $objPHPExcel->setActiveSheetIndex(0)          
            ->setCellValue("A$x", $data['rekanan_id'][$val])
            ->setCellValue("B$x", $data['rekanan_name'][$val])
            ->setCellValue("C$x", $data['rekananshipping_line'][$val])
            ->setCellValue("D$x", $data['rekananshipping_name'][$val])
            ->setCellValue("E$x", $data['rekananutilitiesgas_reg'][$val])
            ->setCellValue("F$x", str_replace(',', '', $data['stand_akhir'][$val]));
            $x++;       
        }        
        
        $x -= 1;
        $objPHPExcel->getActiveSheet(0)->getStyle("F2:F$x")->getNumberFormat()->setFormatCode('#,##0.00');

        $objPHPExcel->getActiveSheet(0)->getStyle("A2:F$x")->applyFromArray($styleBody);

        $objPHPExcel->getActiveSheet(0)->setTitle('Sheet1');

        //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        
        //sesuaikan headernya 
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="Air_'.date('Y_m_d_h_i_s').'.xlsx"');
        //unduh file
        $objWriter->save("php://output");
        exit;

    }

    function uploadBerita() {
        
        $_id = '';
        $_line = 0;
        $Name = '';        

        if($_POST) {            
            $_id = $_POST['id'];
            $_line = $_POST['line']; 
        }        

        if($_FILES['dfile']) { 
            //$Name = $_FILES["dfile"]["name"];
            $errors     = array();
            $maxsize    = 1097152;

            if($_FILES['dfile']['size']>=$maxsize){
                $errors[] = 'File Size too large';                
            }

            $size = $_FILES['dfile']['size'];
            $tmp_name = $_FILES['dfile']['tmp_name'];                    

            $allowed = array('xls', 'xlsx', 'jpg', 'pdf');

            if(isset($_FILES['dfile']) && $_FILES['dfile']['error'] == 0){

                $temp = explode(".", $_FILES["dfile"]["name"]);
                $extension = end($temp);
                $Name = $_id.'_'.$_line.'.'.$extension;                
                
                if(!in_array(strtolower($extension), $allowed)){                     
                    $errors[] = 'Unknown format';
                }                                  
            }            

            if (count($errors) === 0) {

                move_uploaded_file($tmp_name, FCPATH.'/assets/uploads/'.$Name);             
                $this->model_air->updateLink($_id, $_line, $Name);

                $result['files'] = array(
                    'name'      => $Name,                    
                    'error'     => '',
                    'size'      => $size,
                    'url'       => $Name
                    );        
            }else{
                $result['files'] = array(
                    'name'      => $Name,
                    'error'     => $errors,
                    'size'      => $size,
                    'url'       => ''
                    );     
            }
    
          echo json_encode($result);
        }       
    }   

}  