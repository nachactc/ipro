<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jvoucher2 extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_jvoucher');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
    }
    
    function index(){       
        redirect('jvoucher2/jvoucher2/jvoucherlist');
    }
    function globalsearch_dialog(){
		$arcari=array('unit_name', 'region_id', 'branch_id');
		return $arcari;
	}   

    function globalsearch_rekanan(){
        
        $arcari = array('R.rekanan_name', 'S.rekananshipping_name', 'S.rowid');
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

    function controler_gridpop(){
        $arcari = $this->globalsearch_rekanan();
        $cariOptional = '';

        //var_dump($_POST);
        if (isset($_POST['params']['branch_id'])) {
            $branch_id = trim($_POST['params']['branch_id']);
            $cariOptional = " (branch_id = '".$branch_id."' OR branch_id is null) ";
        }

        $vResult = $this->initialize_grid_default("qry_alldatapop", "qry_filteredpop", "qry_totalallpop", $arcari, $cariOptional);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];        

        foreach ($rResult as $aRow) {
            $row = array();
            //$id = $aRow['rekanan_id'];
            //$row[]= '';
            $row[]= $aRow['debtor_no'];
            $row[]= $aRow['rekanan_name'];
            $row[]= $aRow['rekananshipping_name'];
            $row[]= '<div class="text-center"><a class="select"><i class="fa fa-check-square fa-lg"></i></a></div>';
            $row[]= $aRow['rekanan_id'];
            $row[]= $aRow['rekananshipping_line'];

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }

    function controler_gridtenant(){
        //print_r($_POST);
        $line_no =  isset($_POST['line_no']) ? $_POST['line_no']: 0 ;  

        $arcari=$this->globalsearch_rekanan();

        $vResult=$this->initialize_grid("qry_alldatapop","qry_filteredpop","qry_totalallpop",$arcari);
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
                    $row[]= $line_no;

            if (!empty($row)) { $output['data'][] = $row; }
            }   
            echo json_encode($output);
            
    }
    
	function globalsearch_list(){
		$arcari = array('jurnal_id',  'jurnaltype_id','jurnal_source','periode_id','jurnal_createby');
		return $arcari;
	}
	
	function initialize_grid($qry_alldata, $qry_filtered, $qry_totalall, $arcari, $cariOptional = ''){
		$aColumns = $arcari;
		$oColumn = array('jurnal_id', 'jurnal_bookdate', 'branch_name','rekanan_name', 'strukturnit_name');



		$sOrder = "";		 
		if ( isset( $_POST['order'] ) ) {
			
            $colOrder = $_POST['order'];
            $dataOrder = $colOrder[0];

            $order_column = array (0, 1, 3, 4, 5);
            if (in_array($dataOrder['column'], $order_column)) {

                $key = array_search($dataOrder['column'], $order_column); 

                $orderQuery = $oColumn[$key];
                $orderQuery .=" ".$dataOrder['dir'];

                
                $sOrder = "ORDER BY ".$orderQuery;  
            }
		}

		$sWhere = "";

        
        if (isset($_POST['params']['search'])) {


            for ($i=0; $i < count($aColumns); $i++) {
               
                $searchCol = trim($_POST['params']['search']);
                if ($searchCol != '') {
                    if ($sWhere != ''){             
                        $sWhere .= " OR ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
                    } else {
                        $sWhere = "WHERE ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
                    }                    
                }            
            }
        }


		if ( isset($_POST['searchList']) && $_POST['searchList'] != "" ) {
            foreach ($_POST['searchList'] as $key => $value) {
                # code...
                if ($value === '') { continue; }
                //if ($key === 'jurnal_createby') { continue; }
                
                if ($key === 'jurnal_createby') {

                    $criteria = " ".$key. " LIKE '%".$value."%' AND";
                } elseif ($key === 'jurnal_id') {          

                    $idSearch = $this->refParser($value);
                    $criteria = "( ". $idSearch .") AND";
                } else {

                    $criteria = " ".$key. " = '".$value."' AND";
                }

                $sWhere .= ($sWhere !== '') ? $criteria : "WHERE ".$criteria;
            }

            $sWhere = substr_replace( $sWhere, "", -3 );
        }

        /*
		for ($i=0; $i < count($aColumns); $i++) {
			if ( isset($_POST['columns'][$i]['search']['value']) && $_POST['columns'][$i]['search']['value'] != "" ) { 
				$searchCol = trim($_POST['columns'][$i]['search']['value']);
				if ($searchCol != '') {
					if ($sWhere != ''){             
						$sWhere .= " AND ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
					} else {
						$sWhere = "WHERE ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
					}
					 $sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;
					
				}
			}
		}
		*/
		
		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
		$limit = $limit;

		$optional =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ;        

		$sWhere = $sWhere . $optional;
        //var_dump($sWhere);exit;
		
		$rResult = $this->model_jvoucher->$qry_alldata($limit, $top, $sWhere);
			
		$rResultCnt = $this->model_jvoucher->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal = $this->model_jvoucher->$qry_totalall();
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

	function initialize_grid_default($qry_alldata, $qry_filtered, $qry_totalall, $arcari, $cariOptional){
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

		$top = (isset($_POST['start']))? ((int)$_POST['start']) : 0;
		$limit = (isset($_POST['length']))? ((int)$_POST['length'] ) : 10;
		$limit = $limit;

		$optional =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ;
		// $sWhere = $sWhere . $optional;
		
		$rResult = $this->model_jvoucher->$qry_alldata($limit, $top, $sWhere, $optional);

		$rResultCnt = $this->model_jvoucher->$qry_filtered($sWhere, $optional);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_jvoucher->$qry_totalall();
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


    function controler_gridlist($val_search = '')
    {
		$arcari = $this->globalsearch_list(); 
		$searchStatus = $val_search;
		
		
		$criteria = null;
		
    	$vResult = $this->initialize_grid("qry_alldatalist", "qry_filteredlist", "qry_totalalllist", $arcari, $criteria);
    	$rResult = $vResult['rResult'];
    	$output = $vResult['output'];

    	foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['jurnal_id']);

            //$ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
            $is_post = ($aRow['jurnal_isposted']) ? 1 : 0;
            $lock = $is_post ? '<sup style="margin-left:2px;"><i class="fa fa-lock"></i></sup>' : '';
            //$jurnal_amountidr = ($aRow['jurnal_kredit'] > $aRow['jurnal_debet']) ? $aRow['jurnal_kredit'] : $aRow['jurnal_debet'];

            $_menu='
                <a href="/index.php/jvoucher2/jvoucher2/jvoucheredit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                <i class="fa fa-edit fa-lg"></i></a>
                <a href="/index.php/laprint5/laprint5/laprint5pdf/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank">
                <i class="fa fa-print fa-lg"></i></a>
                <a href="/index.php/jvoucher2/jvoucher2/jvoucher_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
                <i class="fa fa-trash fa-lg"></i></a>';

            $row = array();

			$row[] = '<div><span style="margin-left: 2px;">'.$aRow["jurnal_id"].'</span>'.$lock.'</div>';
            $row[] = date("d-m-Y", strtotime($aRow['jurnal_bookdate']));
			//$row[] = number_format($jurnal_amountidr, 2);
			$row[] = number_format($aRow['jurnal_amount'], 2);
			$row[] = $this->model_jvoucher->Lookup($aRow['branch_id'], 'master_branch', 'branch_id', 'branch_name');
            $row[] = $this->model_jvoucher->Lookup($aRow['rekanan_id'], 'master_rekanan', 'rekanan_id', 'rekanan_name');
            $row[] = $this->model_jvoucher->Lookup($aRow['strukturunit_id'], 'master_strukturunit', 'strukturunit_id', 'strukturunit_name');
            //$row[] = '<input type="checkbox" id="posted"'. ($aRow['jurnal_isposted'] == 1 ? 'checked= "checked"' : '').' disabled>';
		    $row[] =$_menu;
    	
            if (!empty($row)) { $output['data'][] = $row; }
        }

        echo json_encode($output);    		
    }

    function jvoucherlist(){
        
        $jurnal_id = $this->uri->segment(4);
        $data   = array(
                  'result'      => $this->model_jvoucher->viewjurnal($jurnal_id),
                  'jurnal_id'   => $jurnal_id
            );        

        $data['source'] = $this->source_select();
		
		$this->breadcrumbcomponent->add('Entry Journal','jvoucher2/jvoucherlist');

        $this->load->view('template/v_header');
        $this->load->view('jvoucher2/jvoucher_list', $data);
        $this->load->view('template/v_footer');
    }
    
    function jvoucheradd()
	{    
        $jurnal_id = $this->uri->segment(4);  
        
        $data   = array(
                  'result'      => $this->model_jvoucher->viewjurnal($jurnal_id),
                  'jurnal_id'   => $jurnal_id
            );        
        
        $data['region']     = $this->region_select();
        $data['source']     = $this->source_select();
        $data['struktur']   = $this->strukturnit_select();
        $data['account']    = $this->acc_select();
        $data['period']     = $this->periode_select();
        $data['channel']    = $this->session->userdata('channel_id');
		$data['branch']    = $this->branch_selectform();

  		$this->breadcrumbcomponent->add('List Journal','jvoucher2/jvoucher2/jvoucherlist')
             ->add('Add Journal','jvoucher2/jvoucher2/jvoucheradd');


        $this->load->view('template/v_header');
        $this->load->view('jvoucher2/jvoucher_add', $data);
        $this->load->view('template/v_footer');
	}
    
    function insertJournal(){

        $userdata = $this->session->userdata();

        $header = $this->getPostDataHeader('', $userdata, 'newdata'); 
        $jurnalDetil = json_decode($_POST['row_jurnaldetil']);
        $deleted;

        /** Header */
        $journal = $this->model_jvoucher->insertHeader($header)->row_array();
        $jurnal_id = $journal['jurnal_id'];

        /** Detail */
        $detail = $this->getPostDataDetail($jurnal_id, $header, $jurnalDetil);
        $this->model_jvoucher->saveDetil($detail, (object)[]); 

        redirect('jvoucher2/jvoucher2/jvoucheredit/'.$jurnal_id);
    }

    function updateJournal(){

        $jurnal_id = $this->input->post('jurnal_id');
        $userdata = $this->session->userdata();

        $header = $this->getPostDataHeader($jurnal_id, $userdata, 'editdata');
        $jurnalDetil = json_decode($_POST['row_jurnaldetil']);
        $detail = $this->getPostDataDetail($jurnal_id, $header, $jurnalDetil);
        $objDeleted = json_decode($_POST['row_jurnaldeleted']);
        $deleted = $objDeleted->jurnalDetilDeleted;

        if (isset($_POST['delete'])){
            $this->model_jvoucher->deleteJurnal($jurnal_id);
            redirect('jvoucher2/jvoucher2/jvoucherlist');
        } else {
            
            /** Header */
            $this->model_jvoucher->updateHeader($header);

            /** Detail */
            $this->model_jvoucher->saveDetil($detail, $deleted);

            redirect('jvoucher2/jvoucher2/jvoucheredit/'.$jurnal_id);
        }
    }    

    function listJurnalDetail()
    {
        $jurnal_id = $_POST['jurnal_id'];
    	$result = $this->model_jvoucher->getDataDetail($jurnal_id);
        $total = count($result);

        foreach ($result as $row) {
            $row->_state = 'update';
            $row->rowid = 'jDetil-row-'.$row->jurnaldetil_line;
            //$rows->jurnaldetil_idr = number_format($rows->jurnaldetil_idr, 2);
            $row->descr = '
                <div>
                    <div style="font-weight: bold"><span style="font-size:0.8em; margin-right:3px; vertical-align:top;">'.$row->acc_id.'</span>'.strtoupper($row->acc_name).'</div>
                </div>
                <div style="padding: 0px 0px 0px 10px; font-style:italic;">'.$row->jurnaldetil_descr.'</div>
                <div style="font-size:0.85em;">'.$row->branch_name.' - '.strtoupper($row->rekanan_name).' - '.$row->strukturunit_name.'</div>
            ';
            $row->debit = $row->jurnaldetil_idr > 0 ? $row->jurnaldetil_idr : '';
            $row->credit = $row->jurnaldetil_idr < 0 ? $row->jurnaldetil_idr : '';
        }

        $output = array(
			//"draw"=> $_POST['draw'],
			"recordsTotal" => $total,
			"recordsFiltered" => $total,
			"data" => $result
		);

        echo json_encode($output); 
    }
	
	function jvoucheredit()
    {		

		$detilRef= array();
		$detilRes= array();
        
        $i_link = $this->uri->segment(4);          

        $_id = str_replace('_', '/', $i_link);     

        $data   = array(
                  'result'       => $this->model_jvoucher->viewjurnal($_id),
                  'jurnal_id'    => $_id
            );                
        
        $data['region']         = $this->region_select();
        $data['branch']         = $this->branch_select();
        $data['struktur']       = $this->strukturnit_select();
        $data['account']        = $this->acc_select();
        $data['period']         = $this->periode_select();
		$data['periodall']         = $this->periode_selectall();
        
		$data['branch']    		= $this->branch_selectform();
		
		//detil reference
		$dataRef = $this->model_jvoucher->get_jurnaldetilRef($_id);
		if($dataRef)
		{
			foreach($dataRef as $rows)
			{
				$row = array();
				$row['jurnal_id'] =  $rows->jurnal_id; 
				$row['jurnal_bookdate'] = date('d-m-Y',strtotime($rows->jurnal_bookdate)); 
				$row['jurnaldetil_line'] =  $rows->jurnaldetil_line; 
				$row['jurnaldetil_descr'] =  $rows->jurnaldetil_descr; 
				$row['jurnaldetil_idr'] =  $rows->jurnaldetil_idr; 
				$row['jurnaldetil_foreign'] =  $rows->jurnaldetil_foreign; 
				$row['jurnaldetil_foreignrate'] =  $rows->jurnaldetil_foreignrate; 				
				$row['acc_id'] =  $rows->acc_id; 
				$row['acc_name'] =  $rows->acc_name; 
				$row['channel_id'] =  $rows->channel_id; 
				$row['region_id'] =  $rows->region_id; 
				$row['branch_id'] =  $rows->branch_id; 
				$row['strukturunit_id'] =  $rows->strukturunit_id; 
				$row['rekanan_id'] =  $rows->rekanan_id; 
				$row['rekanan_name'] =  $rows->rekanan_name; 
				$row['rekananshipping_line'] =  $rows->rekananshipping_line; 
				$row['rekananshipping_name'] =  $rows->rekananshipping_name; 
				$detilRef[] = $row; 
			}
		}
		$data['resultRef']     = $detilRef;

		//detil response
		$dataRes = $this->model_jvoucher->get_jurnaldetilRes($_id);
		if($dataRes)
		{
			foreach($dataRes as $rows)
			{
				$row = array();
				$row['jurnal_id'] =  $rows->jurnal_id; 
				$row['jurnal_bookdate'] = date('d-m-Y',strtotime($rows->jurnal_bookdate)); 
				$row['jurnaldetil_line'] =  $rows->jurnaldetil_line; 
				$row['jurnaldetil_descr'] =  $rows->jurnaldetil_descr; 
				$row['jurnaldetil_idr'] =  $rows->jurnaldetil_idr; 
				$row['jurnaldetil_foreign'] =  $rows->jurnaldetil_foreign; 
				$row['jurnaldetil_foreignrate'] =  $rows->jurnaldetil_foreignrate; 				
				$row['acc_id'] =  $rows->acc_id; 
				$row['acc_name'] =  $rows->acc_name; 
				$row['channel_id'] =  $rows->channel_id; 
				$row['region_id'] =  $rows->region_id; 
				$row['branch_id'] =  $rows->branch_id; 
				$row['strukturunit_id'] =  $rows->strukturunit_id; 
				$row['rekanan_id'] =  $rows->rekanan_id; 
				$row['rekanan_name'] =  $rows->rekanan_name; 
				$row['rekananshipping_line'] =  $rows->rekananshipping_line; 
				$row['rekananshipping_name'] =  $rows->rekananshipping_name; 
				$detilRes[] = $row; 
			}
		}
		$data['resultRes']     = $detilRes;
		
	    $this->breadcrumbcomponent->add('List Journal','jvoucher2/jvoucher2/jvoucherlist')
             ->add('Edit Journal','jvoucher2/jvoucher2/jvoucheredit');        

        $this->load->view('template/v_header');
        $this->load->view('jvoucher2/jvoucher_edit', $data);
        $this->load->view('template/v_footer');
	}    
    
    function region_select()
    {
        $this->load->model('template/Master_m');
        
        $region     = $this->Master_m->get_region();
        $options    = array('' => 'Select an option');
        
        if(count($region)){
            foreach($region as $key => $value){
                $options[$value->region_id]= $value->region_name;
            }
        }
                    
        return $options;
    }
    
    function branch_select()
    {
        $rSearch = empty($_POST['term']) ? '' : $_POST['term'];
        $rRegion = empty($_POST['region']) ? '' : $_POST['region'];

        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            

            $this->load->model('template/Master_m');

            if ($rRegion != '') {            
                $branch = $this->model_jvoucher->get_branchbyquery($rSearch['term'], $rRegion);
            } else {
                $branch = $this->Master_m->get_branchbyall($rSearch['term']);
            }
            
            $result['items']= $branch;
          
            echo json_encode($result);            
        };
    }	

    function acc_select()
    {
         
        $account = $this->model_jvoucher->get_acc();              
        
        if(count($account)){
            $options = array('' => 'Select an option');
            foreach($account as $key => $value){
                $options[$value->acc_id] = $value->acc_id."-".$value->acc_name;
            }
        }
                    
        return $options;
    }

    function branch_selectform()
    {
         
        $account = $this->model_jvoucher->get_branch();
        $options    = array(0 => '--PILIH--');
        if(count($account)){
            foreach($account as $key => $value){
                $options[$value->branch_id]= $value->branch_name;
            }
        }
                    
        return $options;
    }	

    function periode_select()
    {
         
        $periode = $this->model_jvoucher->get_periode();              
        
        if(count($periode)){
            foreach($periode as $key => $value){
                $options[$value->periode_id]= $value->periode_name;
            }
        }
                    
        return $options;
    }   
	
	function periode_selectall()
    {
   
        $periode = $this->model_jvoucher->get_periodeall();              
        
        if(count($periode)){
            foreach($periode as $key => $value){
                $options[$value->periode_id]= $value->periode_name;
            }
        }
                    
        return $options;
    } 

    function strukturnit_select()
    {
        $this->load->model('template/Master_m');
        
        $strukturunit = $this->Master_m->get_strukturunit();
        $options    = array('' => 'Select an option');
        if(count($strukturunit)){
            foreach($strukturunit as $key => $value){
                $options[$value->strukturunit_id]= $value->strukturunit_name;
            }
        }
                    
        return $options;
    }

    function source_select()
    {
        $source = $this->model_jvoucher->get_journalsource();

        if(count($source)){
            foreach($source as $key => $value){
                $options[$value->jurnalsource_id]= $value->jurnalsource_name;
            }
        }
                    
        return $options;
    }

    function getPostDataHeader($jurnal_id, $userdata, $mode) 
    {
        $tgl = date("Y-m-d h:i:sa", time());
		$chid = get_setting("channel_id");

        if ($mode == 'newdata') {
            $_createby = $userdata['username'];
            $_createdate = date("Y-m-d h:i:sa", time());
            $_modifyby = null;
            $_modifydate = null;
        } else {
            $_createby = $this->input->post('jurnal_createby');
            $_createdate = $this->input->post('jurnal_createdate');
            $_modifyby = $userdata['username'];
            $_modifydate = date("Y-m-d h:i:sa", time());
        }

        $data = array (
            'jurnal_id' => $jurnal_id,
            'jurnal_bookdate' => $this->input->post('jurnal_bookdate'),
            'jurnal_descr' => $this->input->post('jurnal_descr'),
            'jurnal_isposted' => '0',
            'jurnal_createby' => $_createby,
            'jurnal_createdate' => $_createdate,
            'jurnal_modifyby' => $_modifyby,
            'jurnal_modifydate' => $_modifydate,
            'jurnal_postby' => null,
            'jurnal_postdate' => null,
            'jurnal_duedate' => $this->input->post('jurnal_duedate'),
            'jurnal_faktur' => '',
            'jurnal_source' => 'JV-Manual',
            'jurnaltype_id' => 'JV',
            'channel_id' => $chid,
            'region_id' => $this->input->post('iregion'),
            'branch_id' => $this->input->post('cbobranch'),
            'strukturunit_id' => $this->input->post('istruk'),
            'rekanan_id' => $this->input->post('htenant'),
            'sub1_id' => 0,
            'sub2_id' => 0,
            'currency_id' => 'IDR',
            'currency_rate' => 1,
            'periode_id' => $this->input->post('iperiod'),
            'acc_id' => '0',
            'shipline' => $this->input->post('hbrand')
        );

        return $data;
    }
    
    function getPostDataDetail($jurnal_id, $header, $obj)
    {
		$channel_id = get_setting("channel_id");
		$username = $this->session->userdata('user_fullname');

        $records = [];
        foreach ($obj as $rows) {
            foreach ($rows as $row) {
                $records[] = array (                
                    'jurnal_id' => $jurnal_id,
                    'jurnaldetil_line' => (int)$row->jurnaldetil_line,
                    'jurnaldetil_dk' => 'D',
                    'jurnaldetil_descr' => $row->jurnaldetil_descr,
                    'jurnaldetil_idr' => (float)$row->jurnaldetil_idr,
                    'jurnaldetil_foreign' => 0,
                    'jurnaldetil_foreignrate' => 1,
                    'ref_id' => '',
                    'ref_line' => 0,
                    'currency_id' => 'IDR',
                    'acc_id' => $row->acc_id,
                    'channel_id' => $channel_id,
                    'region_id' => $header['region_id'], //$row->region_id,
                    'branch_id' => $row->branch_id,
                    'strukturunit_id' => $row->strukturunit_id,
                    'rekanan_id' => $row->rekanan_id,
                    'sub1_id' => '',
                    'sub2_id' => '',
                    'modifyby' => $username,
                    'rekananshipping_line' => $row->rekananshipping_line,
                    '_state' => $row->_state
                );
            }
        }

        return $records;
    }

    function refParser($string)
    {
        $result = '';
        $pattern = "/[\s;]+/";
        $obj = preg_split($pattern, $string);

        foreach ($obj as $id) {
            # code...
            if ($result != '') {
                $result .= " OR " . "jurnal_id = '" . $id . "' ";
            } else {
                $result = "jurnal_id = '" . $id ."'";
            }
        }

       return $result;
    }
}  