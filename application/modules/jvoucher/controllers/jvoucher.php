<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jvoucher extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_jvoucher');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
    }
    
    function index(){       
        redirect('jvoucher/jvoucher/jvoucherlist');
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

        if (isset($_POST['params']['branch_id'])) {
            $branch_id = trim($_POST['params']['branch_id']);
            $cariOptional = " branch_id = '".$branch_id."' ";
        }

        $vResult = $this->initialize_grid("qry_alldatapop", "qry_filteredpop", "qry_totalallpop", $arcari, $cariOptional);
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
                } else {

                    $criteria = " ".$key. " = '".$value."' AND";
                }

                $sWhere .= ($sWhere !== '') ? $criteria : "WHERE ".$criteria;
            }

            $sWhere = substr_replace( $sWhere, "", -3 );
        }

        //var_dump ($sWhere);exit;
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

            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
            $is_post = ($aRow['jurnal_isposted']) ? 1 : 0;

            $_menu='
                <a href="/index.php/jvoucher/jvoucher/jvoucheredit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                <i class="fa fa-edit fa-lg"></i></a>
                <a href="/index.php/laprint5/laprint5/laprint5pdf/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank">
                <i class="fa fa-print fa-lg"></i></a>
                <a href="/index.php/jvoucher/jvoucher/jvoucher_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
                <i class="fa fa-trash fa-lg"></i></a>';

            $row = array();

			$row[] = $aRow['jurnal_id'];            
            $row[] = date("d-m-Y", strtotime($aRow['jurnal_bookdate']));
			$row[] = number_format($aRow['jurnal_amountidr'], 2);
			$row[] = $aRow['branch_name'];
            $row[] = $ship_name;
            $row[] = $aRow['strukturunit_name'];
            $row[] = '<input type="checkbox" id="posted"'. ($aRow['jurnal_isposted'] == 1 ? 'checked= "checked"' : '').' disabled>';
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
		
		$this->breadcrumbcomponent->add('Entry Journal','jvoucher/jvoucherlist');

        $this->load->view('template/v_header');
        $this->load->view('jvoucher/jvoucher_list', $data);
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

  		$this->breadcrumbcomponent->add('List Journal','jvoucher/jvoucher/jvoucherlist')
             ->add('Add Journal','jvoucher/jvoucher/jvoucheradd');


        $this->load->view('template/v_header');
        $this->load->view('jvoucher/jvoucher_add', $data);
        $this->load->view('template/v_footer');
	}
    
    function savejv(){

        $book_date=$this->input->post('jurnal_bookdate');
        $tdesc=$this->input->post('jurnal_descr');
        $due_date=$this->input->post('jurnal_duedate');
        $hbisnisunit=$this->input->post('iregion');
        $hstore=$this->input->post('cbobranch');
        $tsruktur_id=$this->input->post('istruk');
        $htradename=$this->input->post('htenant');
        $hbrand=$this->input->post('hbrand');
        $hsub1=0;
        $hsub2=0;
        $cboperiode=$this->input->post('iperiod');
        $cboaccno=0;

        $rq=$this->model_jvoucher->saveh($book_date,$tdesc,$due_date,$hbisnisunit,$hstore,$tsruktur_id,$htradename,$hsub1,$hsub2,$cboperiode,$cboaccno,$hbrand)->row_array();
        $jurnal_id=$rq['jurnal_id'];

        $jurnaldetil_line=$this->input->post('rline');
        $jurnaldetil_dk="D"; 
        $jurnaldetil_descr=$this->input->post('ddescr');
        $jurnaldetil_idr=$this->input->post('didr');
        $jurnaldetil_foreign=0; 
        $jurnaldetil_foreignrate=1; 
        $ref_id="";
        $ref_line=0;
        $currency_id="IDR"; 
        $acc_id=$this->input->post('dacc');
        $channel_id=$this->input->post('channel_id'); 
        $region_id=$this->input->post('dregion');
        $branch_id=$this->input->post('dbranch');
        $strukturunit_id=$this->input->post('dstruktur');
        $rekanan_id=$this->input->post('trek_id');
        $shipping_line=$this->input->post('tshipping_line');
        $sub1_id=""; 
        $sub2_id="";

        $this->model_jvoucher->saved($jurnal_id,$jurnaldetil_line,$jurnaldetil_dk,$jurnaldetil_descr,$jurnaldetil_idr,$jurnaldetil_foreign,$jurnaldetil_foreignrate,$ref_id,$ref_line,$currency_id,$acc_id,$channel_id,$region_id,$branch_id,$strukturunit_id,$rekanan_id,$shipping_line,$sub1_id,$sub2_id);
        //redirect('jvoucher/jvoucher/jvoucherlist');
        redirect('jvoucher/jvoucher/jvoucheredit/'.$jurnal_id);
    }

    function updatejv(){
        

        $jurnal_id = $this->input->post('jurnal_id');
        $book_date = $this->input->post('jurnal_bookdate');
        $tdesc = $this->input->post('jurnal_descr');
        $due_date = $this->input->post('jurnal_duedate');
        $hbisnisunit = $this->input->post('iregion');
        $hstore = $this->input->post('cbobranch');
        $tsruktur_id = $this->input->post('istruk');
        $htradename = $this->input->post('htenant');
        $hbrand = $this->input->post('hbrand');
        $hsub1 = 0;
        $hsub2 = 0;
        $cboperiode = $this->input->post('iperiod');
        $cboaccno = 0;


        if (isset($_POST['delete'])){

            $this->model_jvoucher->deleteJurnal($jurnal_id);

            redirect('jvoucher/jvoucher/jvoucherlist');
        } else {
    
            $this->model_jvoucher->update_h(
                $jurnal_id, $book_date, $tdesc, $due_date, 
                $hbisnisunit, $hstore, $tsruktur_id, $htradename, 
                $hsub1, $hsub2, $cboperiode, $cboaccno, $hbrand
            )->row_array();

            redirect('jvoucher/jvoucher/jvoucheredit/'.$jurnal_id);
        }       
    }

    
    
    function saveJournalDetil(){

        if($_POST){

            
            $result = new \stdClass;

            
            $__state = $_POST['__state'];
            $jurnal_id = $_POST['jurnal_id'];
            $jurnaldetil_line = $_POST['jurnaldetil_line'];
            $jurnaldetil_descr = $_POST['jurnaldetil_descr'];
            $jurnaldetil_idr = $_POST['jurnaldetil_idr'];
            $acc_id = $_POST['acc_id'];
            $region_id = $_POST['region_id'];
            $branch_id = $_POST['branch_id'];
            $strukturunit_id = $_POST['strukturunit_id'];
            $rekanan_id = $_POST['rekanan_id'];
            $rekananshipping_line = $_POST['rekananshipping_line'];
    
            $detil = array (
                'jurnal_id' => $jurnal_id,
                'jurnaldetil_line' => $jurnaldetil_line,
                'jurnaldetil_dk' => 'D',
                'jurnaldetil_descr' => $jurnaldetil_descr,
                'jurnaldetil_idr' => $jurnaldetil_idr,
                'jurnaldetil_foreign' => 0,
                'jurnaldetil_foreignrate' => 1,
                'ref_id' => '',
                'ref_line' => 0,
                'currency_id' => 'IDR',
                'acc_id' => $acc_id,
                'channel_id' => $this->session->userdata('channel_id'),
                'region_id' => $region_id,
                'branch_id' => $branch_id,
                'strukturunit_id' => $strukturunit_id,
                'rekanan_id' => $rekanan_id,
                'sub1_id' => '',
                'sub2_id' => '',
                'modifyby' => $this->session->userdata('user_fullname'),
                'rekananshipping_line' => $rekananshipping_line,
            );

            try {
                //code...
                $res = $this->model_jvoucher->saveDetil($detil, $__state); 
                $result->status = true;
                $result->message = 'Success';
                $result->data = $res;
            } catch (\Exception $ex) {
                $result->status = false;
                $result->message = $ex->getMessage();
            } finally {
                echo json_encode($result);
            }
        }
    }



    function openJournalDetil(){

        if($_POST){

            
            $result = new \stdClass;

            $jurnal_id = $_POST['jurnal_id'];
            $jurnaldetil_line = (int)$_POST['jurnaldetil_line'];

            try {
                //code...
                $res = $this->model_jvoucher->openDetil($jurnal_id, $jurnaldetil_line);

                $result->status = true;
                $result->message = 'Success';
                $result->data = $res;
            } catch (\Exception $ex) {
                $result->status = false;
                $result->message = $ex->getMessage();
            } finally {
                echo json_encode($result);
            }
        }
    }

    function jurnalDetil()
    {
        $jurnal_id = $_POST['jurnal_id'];

    	$result = $this->model_jvoucher->listDetil($jurnal_id);

        foreach ($result as $rows) {
            
            $rows->chk = '';
            //$rows->jurnaldetil_idr = number_format($rows->jurnaldetil_idr, 2);
            $rows->jurnaldetil_descr = '
                <div style="font-weight: bold">'.$rows->acc_name.'</div>
                <div style="padding: 0px 0px 0px 10px;font-weight:lighter;font-style:italic">'.$rows->jurnaldetil_descr.'</div>
            ';
            $rows->debet = $rows->jurnaldetil_idr > 0 ? number_format($rows->jurnaldetil_idr,2) : '';
            $rows->kredit = $rows->jurnaldetil_idr < 0 ? number_format(abs($rows->jurnaldetil_idr),2) : '';
        }

        $output = array(
			//"draw"=> $_POST['draw'],
			"recordsTotal" => 10,
			"recordsFiltered" => 10,
			"data" => $result
		);

        echo json_encode($output); 
    }


	
	function jvoucheredit(){		

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

        $data['resultd']        = $this->model_jvoucher->vdetiljurnal($_id);
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
		
	    $this->breadcrumbcomponent->add('List Journal','jvoucher/jvoucher/jvoucherlist')
             ->add('Edit Journal','jvoucher/jvoucher/jvoucheredit');        

        $this->load->view('template/v_header');
        $this->load->view('jvoucher/jvoucher_edit', $data);
        $this->load->view('template/v_footer');
	}    
    
    function region_select(){
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
	
	

    function acc_select(){
         
        $account = $this->model_jvoucher->get_acc();              
        
        if(count($account)){
            $options[0] = '--PILIH--';
            foreach($account as $key => $value){
                $options[$value->acc_id] = $value->acc_id."-".$value->acc_name;
            }
        }
                    
        return $options;
    }

    function branch_selectform(){
         
        $account = $this->model_jvoucher->get_branch();
        $options    = array(0 => '--PILIH--');
        if(count($account)){
            foreach($account as $key => $value){
                $options[$value->branch_id]= $value->branch_name;
            }
        }
                    
        return $options;
    }	

    function periode_select(){
         
        $periode = $this->model_jvoucher->get_periode();              
        
        if(count($periode)){
            foreach($periode as $key => $value){
                $options[$value->periode_id]= $value->periode_name;
            }
        }
                    
        return $options;
    }   
	
	function periode_selectall(){
         
        $periode = $this->model_jvoucher->get_periodeall();              
        
        if(count($periode)){
            foreach($periode as $key => $value){
                $options[$value->periode_id]= $value->periode_name;
            }
        }
                    
        return $options;
    } 

    function strukturnit_select(){
        $this->load->model('template/Master_m');
        
        $strukturunit = $this->Master_m->get_strukturunit();
        $options = array(0 => '--PILIH--');
        if(count($strukturunit)){
            foreach($strukturunit as $key => $value){
                $options[$value->strukturunit_id]= $value->strukturunit_name;
            }
        }
                    
        return $options;
    }

    function source_select() {
        $source = $this->model_jvoucher->get_journalsource();

        if(count($source)){
            foreach($source as $key => $value){
                $options[$value->jurnalsource_id]= $value->jurnalsource_name;
            }
        }
                    
        return $options;
    }
  
    
}  