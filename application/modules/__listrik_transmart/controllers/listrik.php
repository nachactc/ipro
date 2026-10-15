<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listrik extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_listrik');
		    $this->load->library('breadcrumbcomponent');
		    $this->load->library('form_validation');
    }
    
    function index(){       
        redirect('listrik/listrik/listriklist');
    }
    function globalsearch_dialog(){
		    $arcari=array('unit_name', 'region_id', 'branch_id');
		  return $arcari;
	  }   
    function globalsearch_rekanan(){
        $arcari= array('rekanan_name','rekananshipping_name', 'branch_id');
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

      $username = $this->session->userdata('username');

      $typeID = "CTE.utilitieslistriktype_id = 'SINGLE' ";
      $optSearch = $typeID;

      $braSearch = "( CTE.branch_id in (select branch_id from master_userbranch where username = '{$username}' ) )";
      $optSearch .= " AND ".$braSearch;

		  $arcari=$this->globalsearch_list();		
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari, $optSearch);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {

            $is_post = ($aRow['isposted']) ? 1 : 0;
      
            $_menu='
                <a href="/index.php/listrik/listrik/listrikedit/'.$aRow['utilitieslistrik_id'].'" data-toggle="tooltip" title="Edit">
                <i class="fa fa-edit fa-lg"></i></a>
                <a href="/index.php/listrik/listrik/laprint5pdf/'.$aRow['utilitieslistrik_id'].'" data-toggle="tooltip" title="Edit" target="_blank">
                <i class="fa fa-print fa-lg"></i></a>
                <a href="/index.php/u_listrik/listrik/listrik_delete/'.$aRow['utilitieslistrik_id'].'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
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
        $output = $this->model_listrik->getTenantbyid($date, 1, $region, $branch, $tenant, $brand);        

      echo json_encode($output);
    }   

    function getdatadetail($_id, $_date, $_region, $_branch){

        if ($_id === 'auto'){ 
          $_id = ''; 
          $_state = 'insert';
        }else{
          $_state = 'update';
        }        
        
        $detil = $this->model_listrik->getdatadetil($_id, $_date, $_region, $_branch, 1);

        //print_r($detil);exit;

        $i = 0;        

        foreach ($detil as $rowd) {

            $i = $rowd->utilitieslistrikdetil_line;

            $result['data'][] = array(  
			  'del'            => '<a id= "rDelete" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a>',
              'posted'            => '<input type="checkbox" id="posted"'. ($rowd->utilitieslistrikdetil_isposted == 1 ? 'checked= "checked"' : '').' disabled>',
              'line'              => $rowd->utilitieslistrikdetil_line,
              'tenant'            => substr($rowd->rekanan_name, 0, 20).'..',
              'brand'             => substr($rowd->shop_name, 0, 25).'..',
              'akhir'             => '<input type="text" id="d_akhir_'.$i.'" name="dakhir[]" value="'.$rowd->utilitieslistrikdetil_akhir.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_akhir_'.$i.'\').number( true, 4 );</script>',
              'standawal'         => '<input type="text" id="d_standawal_'.$i.'" name="dstandawal[]" value="'.$rowd->utilitieslistrikdetil_standawal.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_standawal_'.$i.'\').number( true, 4 );</script>',
              'selisih'           => '<input type="text" id="d_selisih_'.$i.'" name="dselisih[]" value="'.$rowd->utilitieslistrikdetil_selisih.'" class="detil form-control input-sm" style= "text-align: right;" readonly/>
                                      <script type="text/javascript">$(\'#d_selisih_'.$i.'\').number( true, 4 );</script>',
              'selisihlalu'       => '<input type="text" id="d_selisihlalu_'.$i.'" name="dselisihlalu[]" value="'.$rowd->utilitieslistrikdetil_selisihlalu.'" class="detil form-control input-sm" style= "text-align: right;" readonly/>
                                      <script type="text/javascript">$(\'#d_selisihlalu_'.$i.'\').number( true, 2 );</script>',                                    
              'selisihavg'        => '<input type="text" id="d_selisihavg_'.$i.'" name="dselisihavg[]" value="'.$rowd->utilitieslistrikdetil_selisihavg.'" class="detil form-control input-sm" style= "text-align: right;" readonly/>
                                      <script type="text/javascript">$(\'#d_selisihavg_'.$i.'\').number( true, 2 );</script>',
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
              'amp'               => '<input type="text" id="d_amp_'.$i.'" name="damp[]" value="'.$rowd->rekananutilitieslistrik_amp.'" class="detil form-control input-sm"  style= "text-align: right;" readonly/>
                                      <script type="text/javascript">$(\'#d_amp_'.$i.'\').number( true, 2 );</script>',
              'blocked'           => '<input type="checkbox" id="blocked"'. ($rowd->rekananutilitieslistrik_isblocked == 1 ? 'checked= "checked"' : '').' disabled>
                                      <input type="hidden" id="d_blocked" name="dblocked[]" value = "'.$rowd->rekananutilitieslistrik_isblocked.'"/>',
              'genset'            => '<input type="checkbox" id="genset"'. ($rowd->rekananutilitieslistrik_isgenset == 1 ? 'checked= "checked"' : '').' disabled>
                                      <input type="hidden" id="d_genset" name="dgenset[]" value = "'.$rowd->rekananutilitieslistrik_isgenset.'"/>',
              'bkva'              => number_format($rowd->rekananutilitieslistrik_kva,2).'<input type="hidden" id="d_bebankva" name="dbebankva[]" value="'.$rowd->rekananutilitieslistrik_kva.'"/>',
              'phase'             => number_format($rowd->rekananutilitieslistrik_phase,2).'<input type="hidden" id="d_phase" name="dphase[]" value="'.$rowd->rekananutilitieslistrik_phase.'"/>',
              'faktor'            => number_format($rowd->rekananutilitieslistrik_faktor,2).'<input type="hidden" id="d_faktor" name="dfaktor[]" value="'.$rowd->rekananutilitieslistrik_faktor.'"/>',
              'bpjumaster'        => number_format($rowd->rekananutilitieslistrik_bpju,2).'<input type="hidden" id="d_bpjumaster" name="dbpjumaster[]" value="'.$rowd->rekananutilitieslistrik_bpju.'"/>',
              'admamountmaster'   => number_format($rowd->rekananutilitieslistrik_admamount,2).'<input type="hidden" id="d_admamountmaster" name="dadmamountmaster[]" value="'.$rowd->rekananutilitieslistrik_admamount.'"/>',
              'admpercentmaster'  => number_format($rowd->rekananutilitieslistrik_admpercent,2).'<input type="hidden" id="d_admpercentmaster" name="dadmpercentmaster[]" value="'.$rowd->rekananutilitieslistrik_admpercent.'"/>',
              'reglimitmaster'    => number_format($rowd->rekananutilitieslistrik_reglimit,2).'<input type="hidden" id="d_reglimitmaster" name="dreglimitmaster[]" value="'.$rowd->rekananutilitieslistrik_reglimit.'"/>',
              'standawalwbp'      => number_format($rowd->utilitieslistrikdetil_standawalwbp,2).'<input type="hidden" id="d_standawalwbp" name="dstandawalwbp[]" value="'.$rowd->utilitieslistrikdetil_standawalwbp.'"/>',
              'standawallwbp'     => number_format($rowd->utilitieslistrikdetil_standawallwbp,2).'<input type="hidden" id="d_standawallwbp" name="dstandawallwbp[]" value="'.$rowd->utilitieslistrikdetil_standawallwbp.'"/>',
              'selisihwbp'        => '<input type="text" id="d_selisihwbp_'.$i.'" name="dselisihwbp[]" value="'.$rowd->utilitieslistrikdetil_selisihwbp.'" class="detil form-control input-sm" style= "text-align: right;" readonly/>
                                      <script type="text/javascript">$(\'#d_selisihwbp_'.$i.'\').number( true, 2 );</script>',
              'selisihlwbp'       => '<input type="text" id="d_selisihlwbp_'.$i.'" name="dselisihlwbp[]" value="'.$rowd->utilitieslistrikdetil_selisihlwbp.'" class="detil form-control input-sm" style= "text-align: right;" readonly/>
                                      <script type="text/javascript">$(\'#d_selisihlwbp_'.$i.'\').number( true, 2 );</script>',
              'wbptotal'          => number_format($rowd->utilitieslistrikdetil_wbptotal,2).'<input type="hidden" id="d_wbptotal" name="dwbptotal[]" value="'.$rowd->utilitieslistrikdetil_wbptotal.'"/>',
              'lwbptotal'         => number_format($rowd->utilitieslistrikdetil_lwbptotal,2).'<input type="hidden" id="d_lwbptotal" name="dlwbptotal[]" value="'.$rowd->utilitieslistrikdetil_lwbptotal.'"/>',
              'pemakaianwbp'      => '<input type="text" id="d_pemakaianwbp_'.$i.'" name="dpemakaianwbp[]" value="'.$rowd->utilitieslistrikdetil_pemakaianwbp.'" class="detil form-control input-sm" style= "text-align: right;" readonly/>
                                      <script type="text/javascript">$(\'#d_pemakaianwbp_'.$i.'\').number( true, 2 );</script>',
              'pemakaianlwbp'     => '<input type="text" id="d_pemakaianlwbp_'.$i.'" name="dpemakaianlwbp[]" value="'.$rowd->utilitieslistrikdetil_pemakaianlwbp.'" class="detil form-control input-sm" style= "text-align: right;" readonly/>
                                      <script type="text/javascript">$(\'#d_pemakaianlwbp_'.$i.'\').number( true, 2 );</script>',
              'tarifwbp'          => '<input type="text" id="d_tarifwbp_'.$i.'" name="dtarifwbp[]" value="'.$rowd->utilitieslistrikdetil_tarifwbp.'" class="detil form-control input-sm" style= "text-align: right;" readonly/>
                                      <script type="text/javascript">$(\'#d_tarifwbp_'.$i.'\').number( true, 2 );</script>',
              'tariflwbp'         => '<input type="text" id="d_tariflwbp_'.$i.'" name="dtariflwbp[]" value="'.$rowd->utilitieslistrikdetil_tariflwbp.'" class="detil form-control input-sm" style= "text-align: right;" readonly/>
                                      <script type="text/javascript">$(\'#d_tariflwbp_'.$i.'\').number( true, 2 );</script>',
              'biayawbp'          => number_format($rowd->utilitieslistrikdetil_biayawbp,2).'<input type="hidden" id="d_biayawbp" name="dbiayawbp[]" value="'.$rowd->utilitieslistrikdetil_biayawbp.'"/>',
              'biayalwbp'         => number_format($rowd->utilitieslistrikdetil_biayalwbp,2).'<input type="hidden" id="d_biayalwbp" name="dbiayalwbp[]" value="'.$rowd->utilitieslistrikdetil_biayalwbp.'"/>',
              'biaya'             => number_format($rowd->utilitieslistrikdetil_biaya,2).'<input type="hidden" id="d_biaya" name="dbiaya[]" value="'.$rowd->utilitieslistrikdetil_biaya.'"/>',
              'bpju'              => number_format($rowd->utilitieslistrikdetil_bpju,2).'<input type="hidden" id="d_bpju" name="dbpju[]" value="'.$rowd->utilitieslistrikdetil_bpju.'"/>',
              'tagihan'           => number_format($rowd->utilitieslistrikdetil_tagihan,2).'<input type="hidden" id="d_tagihan" name="dtagihan[]" value="'.$rowd->utilitieslistrikdetil_tagihan.'"/>',
              'beabeban'             => '<input type="text" id="d_beabeban_'.$i.'" name="dbeabeban[]" value="'.$rowd->utilitieslistrikdetil_beabeban.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_beabeban__'.$i.'\').number( true, 2 );</script>',
			  'abonemen'             => '<input type="text" id="d_abonemen_'.$i.'" name="dabonemen[]" value="'.$rowd->utilitieslistrikdetil_abonemen.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_abonemen__'.$i.'\').number( true, 2 );</script>',
			  'denda'             => '<input type="text" id="d_denda_'.$i.'" name="ddenda[]" value="'.$rowd->utilitieslistrikdetil_denda.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <script type="text/javascript">$(\'#d_denda_'.$i.'\').number( true, 2 );</script>',
              'administrasi'      => number_format($rowd->utilitieslistrikdetil_administrasi,2).'<input type="hidden" id="d_administrasi" name="dadministrasi[]" value="'.$rowd->utilitieslistrikdetil_administrasi.'"/>',
              'jumlah'            => number_format($rowd->utilitieslistrikdetil_jumlah,2).'<input type="hidden" id="d_jumlah" name="djumlah[]" value="'.$rowd->utilitieslistrikdetil_jumlah.'"/>',
              'tax'               => '<input type="text" id="d_tax_'.$i.'" name="dtax[]" value="'.$rowd->rekananshipping_tax.'" class="detil form-control input-sm" style= "text-align: right;"/>
                                      <input type="hidden" id="d_state_'.$i.'" name="dstate[]" value = "'.$_state.'"/>
                                      <script type="text/javascript">$(\'#d_tax_'.$i.'\').number( true, 2 );</script>',
              'berita'            => '<div class="input-group input-group-sm">
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary">
                                            <i class="fa fa-folder-open"></i><input type="file" style="display: none;" id="d_file_'.$i.'" name="dfile">
                                            </span>
                                        </label>
                                        <input id="d_link_'.$i.'" name="dlink[]" type="text" class="form-control" value = "'.$rowd->utilitieslistrikdetil_link.'" readonly>
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
              'link'              =>  '<div class="link-url"><a href='.(empty($rowd->utilitieslistrikdetil_link) ? "javascript:;" : "/assets/uploads/".$rowd->utilitieslistrikdetil_link).' class="btn btn-sm green btn-primary" target="_blank"><i class="fa fa-file-text-o"></i> Download</a></div>'
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
		
		    $this->breadcrumbcomponent->add('Utilities Listrik','listrik/listriklist');

        $this->load->view('template/v_header');
        $this->load->view('listrik/listrik_list', $data);
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

  		$this->breadcrumbcomponent->add('Utilities Listrik','listrik/listriklist')
            ->add('Utilities Listrik New','listrik/listrik/listrikadd');


        $this->load->view('template/v_header');
        $this->load->view('listrik/listrik_add', $data);
        $this->load->view('template/v_footer');
	}
    
	
	function listrikedit(){		
        
        $_id = $this->uri->segment(4);        

        $branch = '';
        $region = '';      
        $date = '';
        $descr = '';
        $store = '';

        if ($_POST){

            $branch     = $this->input->post('storeSearch');
            $region     = $this->input->post('regionSearch_hidden');
            $period     = $this->input->post('periodSearch');
           
            $store = GetDataFromTable('master_branch', 'branch_id', 'branch_name', $branch);            

            $date = '20'.substr($period, 0, 2).'-'.substr($period, 2, 2).'-'.'01';    
            $descr = 'Pemakaian Listrik Periode '.getIndoBulan(substr($period, 2, 2)).' '.'20'.substr($period, 0, 2);        

            $cekId = $this->model_listrik->CekTransaction($date, 'SINGLE', $region, $branch);

            if (!empty($cekId)){
                $_id = $cekId;
                redirect("listrik/listrik/listrikedit/".$_id);
            }
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
		
		    $this->breadcrumbcomponent->add('Utilities Listrik','listrik/listrik/listriklist')
            ->add('Edit Utilities Listrik','listrik/listrik/listrikedit');        

        $this->load->view('template/v_header');
        $this->load->view('listrik/listrik_edit', $data);
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
        $dstandawallwbp     = $this->input->post('dstandawallwbp');
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
        $dselisihlalu       = $this->input->post('dselisihlalu');   
        $dselisihavg        = $this->input->post('dselisihavg');   
        $dselisihwbplalu    = $this->input->post('dselisihwbplalu');   
        $dselisihlwbplalu   = $this->input->post('dselisihlwbplalu');   
        $dselisihwbpavg     = $this->input->post('dselisihwbpavg');   
        $dselisihlwbpavg    = $this->input->post('dselisihlwbpavg'); 
        $dstandakhirwbp     = $this->input->post('dstandakhirwbp');
        $dstandakhirlwbp    = $this->input->post('dstandakhirlwbp'); 
        $wbpgedung          = $this->input->post('utilitieslistrik_wbpgedung');
        $lwbpgedung         = $this->input->post('utilitieslistrik_lwbpgedung');
        $wbptarif           = $this->input->post('utilitieslistrik_wbptarif');
        $lwbptarif          = $this->input->post('utilitieslistrik_lwbptarif');

        $button             = $this->input->post('button');
        $dRekName           = $this->input->post('drek_name'); 
        $dRekShop           = $this->input->post('drek_shop');   
        $deleted            = $this->input->post('deleted');
        $dstate             = $this->input->post('dstate');   
		
		$dbeabeban      = $this->input->post('dbeabeban');   
        $dabonemen       = $this->input->post('dabonemen'); 
 
        $type               = 'SINGLE';        

        IF ($button == "EXCEL") {
            //print_r($dline);exit;

            $data['line'] = $dline;
            $data['rekanan_id'] = $dtenant_id;
            $data['rekanan_name'] = $dRekName;
            $data['rekananshipping_line'] = $dbrand_line;
            $data['rekananshipping_name'] = $dRekShop;
            $data['rekananutilitieslistrik_reg'] = $dreg;
            $data['stand_akhir'] = $dakhir;            

            //$this->load->view('listrik/exp_listrik', $data);
            $this->createSaldoFile($data);

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
                $dtarifwbp, $dtariflwbp, $dbiayawbp, $dbiayalwbp, $dbiaya, $dbpju, $dtagihan, $ddenda, $dadministrasi, $djumlah, $dtax,
                $dselisihlalu, $dselisihavg, $dselisihwbplalu, $dselisihlwbplalu, $dselisihwbpavg, $dselisihlwbpavg, 
                $dstandakhirwbp, $dstandakhirlwbp, $wbpgedung, $lwbpgedung, $wbptarif, $lwbptarif,$dbeabeban,$dabonemen
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
                $djumlah, $dtax, $dstate, $deleted, $dselisihlalu, $dselisihavg, $dselisihwbplalu, $dselisihlwbplalu, 
                $dselisihwbpavg, $dselisihlwbpavg, $dstandakhirwbp, $dstandakhirlwbp, $wbpgedung, $lwbpgedung, $wbptarif, $lwbptarif,$dbeabeban,$dabonemen
              );
            }

            redirect("listrik/listrik/listrikedit/".$idx);
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
            ->setCellValue("E$x", $data['rekananutilitieslistrik_reg'][$val])
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
        header('Content-Disposition: attachment;filename="Single_'.date('Y_m_d_h_i_s').'.xlsx"');
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
                $this->model_listrik->updateLink($_id, $_line, $Name);

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