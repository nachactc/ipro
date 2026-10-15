<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_cancel extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_schedule_cancel');
		$this->load->library('breadcrumbcomponent');
		$this->load->helper(array('form', 'url'));
    }
   
   
    function index(){       
        redirect('schedule_cancel/sp_list');
    }

    function globalsearch_rekanan(){
        $arcari=array('a.rekanan_id','rekanan_name','B.branch_id');
        return $arcari;
    }
  
	function globalsearch_dialog(){
		$arcari=array('unit_id','unit_name', 'region_id', 'branch_id');
		return $arcari;
	}    
	
	function globalsearch_list(){
		// $arcari=array('a.schedulepayment_id',  'b.branch_name', 'e.rekanan_id','c.region_name',' f.rekananshipping_name ');
		// return $arcari;
		$arcari=array('a.region_id','a.branch_id','a.rekanan_id','a.rekananshipping_line','a.schedulepayment_id','ref_id','ref_id');
		return $arcari;		
	}
	function globalsearch_listdetil(){
		$arcari=array('b.schedulepaymentdetil_line','b.schedulepayment_id', 'g.rekanan_name','h.rekananshipping_name','b.ref_id','b.ref_line','c.agreementtype_name' ,'b.schedulepaymentdetil_descr', );
		return $arcari;
	}
   
    function globalsearch_schema(){
        $arcari=array('unittype_id');
        return $arcari;
    }
	function globalsearch_region(){
        $arcari=array('region_id','region_name');
        return $arcari;
    }

    function globalsearch_branch(){
        $arcari=array('A.branch_id','branch_name', 'region_id');
        return $arcari;
    }

    function globalsearch_brand(){
        $arcari=array('rekananshipping_line','rekananshipping_name','rekanan_id');
        return $arcari;
    }	
    function globalsearch_agrtype(){
        $arcari=array('agreementtype_id','agreementtype_name');
        return $arcari;
    }
	
	 function initialize_grid_dialog(){
      
	  $region_id=trim($_GET['region_id']);
	  $branch_id=trim($_GET['branch_id']);
	  $unit_id=trim($_GET['unit_id']);
	  $lantai_id=trim($_GET['lantai_id']);
      $rResult=$this->model_schedule_cancel_cl->dataapp_list($region_id,$branch_id,$unit_id,$lantai_id); 
       
	  echo json_encode($rResult);
    }
	
	function initialize_grid($qry_alldata,$qry_filtered,$qry_totalall,$arcari,$cariOptional = ''){
		$aColumns = $arcari;
		
     
		$sOrder = "";
		$orderColumns = "";
		 
		if ( isset( $_POST['order'] ) ) {
			$sOrder = "ORDER BY  ";
			$colOrder = $_POST['order'];
		 
			 foreach($colOrder as $dataOrder)
			 {
				$orderColumns = $aColumns[$dataOrder['column']];
				$orderQuery = $aColumns[$dataOrder['column']];
				$orderQuery .=" ".$dataOrder['dir'];
			 }
			  
			if ( $sOrder == "ORDER BY" ) {
				$sOrder = $orderQuery;
			}
			else
			{
				$sOrder = "ORDER BY ".$orderQuery;  
			}		
			
		}
		   
		$sWhere = ""; 
		$sWhereUser = "";
		
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
						if ($aColumns[$i] == 'ref_id2'){
							$sWhere .= " AND left(ref_id,2) = "."'".$searchCol."'";
							}
						else{
							$sWhere .= " AND ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
						}
						
					} else {
						if ($aColumns[$i] == 'ref_id2'){
							$sWhere .= " where left(ref_id,2) = "."'".$searchCol."'";
							}	
						else {
							$sWhere = "WHERE ". $aColumns[$i] . " LIKE '%".$searchCol."%'";
						}
						
					}
					 $sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;
					
				}
			}
		}
		// echo '--> ' . $sWhere;
		// exit;
		
		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
		$limit =$limit+$top;
		$orderBy = $sOrder;
		//$b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ; 
		//$sWhere = $sWhere.$b;
        if ( $cariOptional <> '' ) {            
            $sWhere = $sWhere <> '' ? $sWhere." AND ".$cariOptional : " WHERE ".$cariOptional;
        }        
		$username=$this->session->userdata('username');
		
		if ($sWhere =='') {
			$sWhereUser = " where username = "."'".$username."'";
		}
        else
		{
			$sWhereUser = " and username = "."'".$username."'";
		}
		
		// echo $qry_alldata;
		// exit;
		$rResult=$this->model_schedule_cancel->$qry_alldata($limit,$top,$sWhere,$orderBy,$sWhereUser);
			
		$rResultCnt =$this->model_schedule_cancel->$qry_filtered($sWhere,$orderColumns,$sWhereUser);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_schedule_cancel->$qry_totalall($sWhere,$sWhereUser);
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
    	
    function controler_penalist(){
    	$arcari=$this->globalsearch_list();
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];

    	foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['loo_id']);
            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
            $is_post = ($aRow['isconfirm']) ? 1 : 0;
            $is_post = ($aRow['isapproved']) ? 1 : 0;            
			$id_show =$aRow['conf_id']; 

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
						$vprint='printatmpdf';
					}
    				$row[]='
        <a href="/index.php/loo_cl/loo_cl/looedit/'.$i_link.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> 
    	<a href="/index.php/looprint/looprint/'.$vprint.'/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank"><i class="fa fa-print"></i></a>
    	<a href="/index.php/loo_cl/loo_cl/loo_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')"><i class ="fa fa-trash"></i></a>';
    	
            if (!empty($row)) { $output['data'][] = $row; }
        	}   
        	echo json_encode($output);
    		
    }

    function sp_list(){
        		
		$this->breadcrumbcomponent->add('Schedule Cancel List','schedule_cancel/sp_list');

        $this->load->view('template/v_header');
        $this->load->view('schedule_cancel/sp_list');
        $this->load->view('template/v_footer');
    }

	function get_data_loi($where='')
	{
		$result = $this->model_schedule_cancel->qry_alldatalist_2($where);
		
		foreach ($result as $aRow) {

            $i_link = str_replace('/', '_', $aRow['loo_id']);
            $id_show =$aRow['loo_id']; 
                    $tenant = $id_show." - ".$aRow['rekananshipping_name'] ;
            
                    $row[0]=$id_show;
                    $row[1]=$aRow['region_nameshort'];
                    $row[2]=$aRow['branch_name'];
                    $row[3]=$aRow['rekanan_name'];
                    $row[4]=$aRow['rekananshipping_name'];
                    $row[5]='<a href="/index.php/legal_upload/legal_upload/legal_statusedit/'.$i_link.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> 
                     <a href="/index.php/legal_upload/legal_upload/legal_statusdel/'.$i_link.'" data-toggle="tooltip" title="Delete" onclick="return confirm(\'Anda yakin menghapus Data '.$tenant.' ?\');"><i class="fa fa-trash"></i></a>';
        
            if (!empty($row)) { $output['data'][] = $row; }
        }   
        
		if(count($result) <= 0)
		{
			$row[0]='';
			$row[1]='';
			$row[2]='';
			$row[3]='';
			$row[4]='';
			$row[5]='';
			$output['data'][] = $row;
		}
        echo json_encode($output);
	}
	
    function controler_gridlist(){

        $f_date =  isset($_POST['f_date']) ? $_POST['f_date']: '' ;
        $t_date =  isset($_POST['t_date']) ? $_POST['t_date']: '';
		// $region =  isset($_POST['iregion']) ? $_POST['iregion']: '';
		// $branch =  isset($_POST['hbranch']) ? $_POST['hbranch']: '';
		// $tenant =  isset($_POST['htenant']) ? $_POST['htenant']: '';
		// $brand =  isset($_POST['hbrand']) ? $_POST['hbrand']: '';
		// $agrtype =  isset($_POST['hagrtype']) ? $_POST['hagrtype']: '';
		// $idschedule =  isset($_POST['iidschedule']) ? $_POST['iidschedule']: '';
		// $idagreement =  isset($_POST['iidagreement']) ? $_POST['iidagreement']: '';
		$region_id = $this->input->post('iregion');
		$idschedule = $this->input->post('iidschedule');
		
		// echo '-->' . $region_id;
		// exit;
		
        // $fromSearch = $f_date <> '' ? "schedulepayment_createdate >= '$f_date' " : '';

        // $optSearch = $fromSearch;
		$optSearch ='';
        // if ($t_date <> ''){
            // $searchCriteria = $t_date <> '' ? "schedulepayment_createdate <= '$t_date' " : '';
            // $optSearch =  $optSearch <> '' ?   $optSearch." AND ".$searchCriteria : $searchCriteria ;
        // }        
        // if ($region <> ''){
            // $searchCriteria = $region <> '' ? "region_id = '$region' " : '';
            // $optSearch =  $optSearch <> '' ?   $optSearch." AND ".$searchCriteria : $searchCriteria ;
        // } 
        // if ($branch <> ''){
            // $searchCriteria = $branch <> '' ? "branch_id = '$branch' " : '';
            // $optSearch =  $optSearch <> '' ?   $optSearch." AND ".$searchCriteria : $searchCriteria ;
        // } 		
        // if ($tenant <> ''){
            // $searchCriteria = $tenant <> '' ? "rekanan_id = '$tenant' " : '';
            // $optSearch =  $optSearch <> '' ?   $optSearch." AND ".$searchCriteria : $searchCriteria ;
        // } 	
        // if ($brand <> ''){
            // $searchCriteria = $brand <> '' ? "rekananshipping_line_id = '$brand' " : '';
            // $optSearch =  $optSearch <> '' ?   $optSearch." AND ".$searchCriteria : $searchCriteria ;
        // } 		
        // if ($agrtype <> ''){
            // $searchCriteria = $agrtype <> '' ? "agreementtype_id = '$agrtype' " : '';
            // $optSearch =  $optSearch <> '' ?   $optSearch." AND ".$searchCriteria : $searchCriteria ;
        // } 		
        // if ($idschedule <> ''){
            // $searchCriteria = $idschedule <> '' ? "d.schedulepayment_id = '$idschedule' " : '';
            // $optSearch =  $optSearch <> '' ?   $optSearch." AND ".$searchCriteria : $searchCriteria ;
        // } 	
        // if ($idagreement <> ''){
            // $searchCriteria = $idagreement <> '' ? "ref_id_id = '$idagreement' " : '';
            // $optSearch =  $optSearch <> '' ?   $optSearch." AND ".$searchCriteria : $searchCriteria ;
        // } 		

		
        $arcari=$this->globalsearch_list();
        $vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari, $optSearch);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];
	 
        foreach ($rResult as $aRow) {  
                    $row[0]=$aRow['schedulepayment_id'];
                    $row[1]=$aRow['schedulepayment_descr'];
                    $row[2]=$aRow['schedulepayment_isclosed'];
                    $row[3]=$aRow['schedulepayment_isapproved'];
                    $row[4]=$aRow['ref_id'];
                    $row[5]=$aRow['ref_line'];
                    $row[6]=$aRow['transaksi_id'];
                    $row[7]=$aRow['channel_id'];
                    $row[8]=$aRow['region_id'];
                    $row[9]=$aRow['branch_id'];
                    $row[10]=$aRow['strukturunit_id'];
                    $row[11]=$aRow['rekanan_id'];
                    $row[12]=$aRow['rekananshipping_name'];
					$row[13]=date('d-m-Y',strtotime($aRow['schedulepayment_createdate']));
					$row[14]=$aRow['schedulepayment_createby'];
					$row[15]=date('d-m-Y',strtotime($aRow['schedulepayment_modifydate'])) ;
					$row[16]=$aRow['schedulepayment_modifyby']; 
                    //$row[17]='<a href="'.site_url().'index.php/schedule_cancel/schedule_cancel_detil/'.$aRow['schedulepayment_id'].'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit fa-lg"></i></a> 
                    
            if (!empty($row)) { $output['data'][] = $row; }
        }    
        echo json_encode($output);  
    }
    
	function controler_gridlistdetil(){

        $f_date =  isset($_POST['f_date']) ? $_POST['f_date']: '' ;
        $t_date =  isset($_POST['t_date']) ? $_POST['t_date']: '';

        $fromSearch = $f_date <> '' ? "schedulepaymentdetil_enddate >= '$f_date' " : '';

        $optSearch = $fromSearch;

        if ($t_date <> ''){
            $searchCriteria = $t_date <> '' ? "schedulepaymentdetil_enddate <= '$t_date' " : '';
            $optSearch =  $optSearch <> '' ?   $optSearch." AND ".$searchCriteria : $searchCriteria ;
        } 

		if($optSearch != '')
		{
			$optSearch = $optSearch." AND b.schedulepayment_id = '".$this->uri->segment(3)."'";
		}
		else
		{
			$optSearch =" b.schedulepayment_id = '".$this->uri->segment(3)."'";
		}
		
		
		
        $arcari=$this->globalsearch_listdetil();
        $vResult=$this->initialize_grid("qry_alldatalistdetil","qry_filteredlistdetil","qry_totalalllistdetil",$arcari, $optSearch);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];
	 
        foreach ($rResult as $aRow) {  
                    $row[0]=$aRow['schedulepaymentdetil_line'];
                    $row[1]=$aRow['schedulepayment_id'];
                    $row[2]=$aRow['rekanan_name'];
                    $row[3]=$aRow['rekananshipping_name'];
                    $row[4]=$aRow['ref_id'];
                    $row[5]=$aRow['ref_line'];
                    $row[6]=$aRow['agreementtype_name'];
                    $row[7]=$aRow['schedulepaymentdetil_ischecked'];
                    $row[8]=$aRow['schedulepaymentdetil_isposted']; 
                    $row[9]=$aRow['schedulepaymentdetil_boisposted'];
                    $row[10]=$aRow['schedulepaymentdetil_descr'];
                    $row[11]=date('d-m-Y',strtotime($aRow['schedulepaymentdetil_date'])) == '1970-01-01' ? '-' : date('d-m-Y',strtotime($aRow['schedulepaymentdetil_date']));
                    $row[12]=date('d-m-Y',strtotime($aRow['schedulepaymentdetil_duedate']));
                    $row[13]=number_format($aRow['schedulepaymentdetil_idr'], 2, '.', ',');
                    $row[14]=$aRow['schedulepaymentdetil_tax'].'% - '.number_format($aRow['tax'], 2, '.', ',');
					$row[15]=$aRow['schedulepaymentdetil_boid'];
					$row[16]=$aRow['faktur_id'];
					$row[17]=$aRow['invoice_id'];
					$row[18]=$aRow['jurnal_id'];
					$row[19]=date('d-m-Y',strtotime($aRow['schedulepaymentdetil_posteddate'])) == '01-01-1970' ? '-' : date('d-m-Y',strtotime($aRow['schedulepaymentdetil_posteddate']));
					$row[20]=$aRow['schedulepaymentdetil_postedby'];
					  
            if (!empty($row)) { $output['data'][] = $row; }
        }    
        echo json_encode($output);  
    }
 
	function schedule_cancel_detil($uid){		
        
        $i_link = $this->uri->segment(3);       

        $loo_id = str_replace('_', '/', $i_link); 
		 
		$data = array();
		
		$this->breadcrumbcomponent->add('Schedule Payment','schedule_cancel/sp_list')
            ->add('Schedule Payment Detail','schedule_cancel/schedule_cancel_detil');        

        $this->load->view('template/v_header');
        $this->load->view('schedule_cancel/sp_detail', $data);
        $this->load->view('template/v_footer');
	}
    
	function legal_statusdel($_id)
	{
		 
		$this->model_schedule_cancel->deleteLOI($_id);
	
		redirect("legal_upload/legal_list");
	}
	 
    function looview(){     
        
        $cont =  $this->uri->segment(4);
        $i_link = $this->uri->segment(5);       

        $loo_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_schedule_cancel_cl->viewloo($loo_id),
                  'loo_id'   => $loo_id
            );                
        
        $data['region'] = $this->region_select();
        $data['lotype'] = $this->lootype_select(); 
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();

        $data['resultd'] = $this->model_schedule_cancel_cl->sholdetilby_id($loo_id);
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
        
        $i_link = $this->uri->segment(3);       

        $loo_id = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_schedule_cancel_cl->viewlooprint($loo_id),
                  'loo_id'   => $loo_id
            );                
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();	
        $data['agrtype'] = $this->agrtype_select();

        $data['resultd'] = $this->model_schedule_cancel_cl->sholdetilby_id($loo_id);
		
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
  
    function branch_select_dialog($name = ''){
		
		$branch      = $this->model_schedule_cancel->get_branch_dlg($name);
		      
		return $branch ; 
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
		$type = array('9100', '9500', '9600','20000');
        $agrtype      = $this->Master_m->get_agrtypebytype($type);
		
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
public function previewsoppdf(){

	  
	  
	  $schedule_id = $this->input->post('iidschedule');
	  $agreement_id = $this->input->post('iidagreement');
	  $region_id = $this->input->post('hregion');
	  $branch_id = $this->input->post('hbranch');
	  $rekanan_id = $this->input->post('htenant');
	  $rekananshipping_line = $this->input->post('hbrand');
	  $button			= $this->input->post('button');
	  
	  $where =' where schedulepaymentdetil_isdisabled = 1';
	  if ($region_id <>''){
		  $where = $where. " and SP.region_id = " . "'". "'" . $region_id . "'" . "'";
	  } 
	  if ($branch_id <>''){
		  $where =$where. " and SP.branch_id = " . "'". "'" . $branch_id . "'" . "'";
	  } 
	  if ($rekanan_id <>''){
		  $where =$where. " and SP.rekanan_id = " . "'". "'" . $rekanan_id . "'" . "'";
	  } 
	  if ($rekananshipping_line <>''){
		  $where = $where. " and SP.rekananshipping_line = " . "'". "'" . $rekananshipping_line . "'" . "'";
	  } 
	  if ($schedule_id <>''){
		  $where = $where. " and SP.schedulepayment_id = " . "'". "'" . $schedule_id . "'" . "'";
	  } 
	  if ($agreement_id <>''){
		  $where = $where. " and b.ref_id = " . "'". "'" . $agreement_id . "'" . "'";
	  } 
      

		//echo '-->bug ' . $schedule_id;
		//exit;
				$data   = array(
                  //'resultH'      => $this->model_schedule_cancel->get_detil_SOP_Header($schedule_id),
				  'result'      => $this->model_schedule_cancel->get_detil_SOP_cancel($where),
                  'button'   => $button
               );
			   
		// print_r($this->model_schedule_cancel->get_detil_SOP($schedule_id));
		// exit;

        $this->load->view('schedule_cancel/rptcancel', $data);





    }	
	
    function controler_gridtenant(){
        $arcari=$this->globalsearch_rekanan();
        $vResult=$this->initialize_grid("qry_alldatatenant","qry_filteredtenant","qry_totalalltenant",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['rekanan_id'];
                    $row[]=$aRow['rekanan_id'];
                    $row[]=$aRow['rekanan_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }

    function controler_gridregion(){
        $arcari=$this->globalsearch_region();
        $vResult=$this->initialize_grid("qry_alldataregion","qry_filteredregion","qry_totalallregion",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['region_id'];
                    $row[]=$aRow['region_id'];
                    $row[]=$aRow['region_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }

    function controler_gridbranch(){
        $arcari=$this->globalsearch_branch();
        $vResult=$this->initialize_grid("qry_alldatabranch","qry_filteredbranch","qry_totalallbranch",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['branch_id'];
                    $row[]=$aRow['branch_id'];
                    $row[]=$aRow['branch_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }

    function controler_gridbrand(){
        $arcari=$this->globalsearch_brand();
        $vResult=$this->initialize_grid("qry_alldatabrand","qry_filteredbrand","qry_totalallbrand",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['rekananshipping_line'];
                    $row[]=$aRow['rekananshipping_line'];
                    $row[]=$aRow['rekananshipping_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }

    function controler_gridagrtype(){
        $arcari=$this->globalsearch_agrtype();
        $vResult=$this->initialize_grid("qry_alldataagrtype","qry_filteredagrtype","qry_totalallagrtype",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
            $id=$aRow['agreementtype_id'];
                    $row[]=$aRow['agreementtype_id'];
                    $row[]=$aRow['agreementtype_name'];

            if (!empty($row)) { $output['data'][] = $row; }
            }
            echo json_encode($output);

    }	
    
}  