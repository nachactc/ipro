<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rptar extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        $this->load->library('table');
        $this->load->model('model_rptar');
		$this->load->library('breadcrumbcomponent');
		$this->load->helper(array('form', 'url'));
    }
    
	public function dialog_loo($search='')
	{
		$search = urldecode($search);
		
		$row = array(); 
		$output=array(); 
		$dataDlg =array(); 
		$dataDlgR = array(); 
		
		if ($search != '')
		{
			$dataDlg = $this->model_rptar->get_data_dialog_loo($search);
			$dataDlgR = $this->model_rptar->get_data_dialog_loo_rows($search);
		
		 
			foreach ($dataDlg as $aRow) 
			{ 
				$row[0]=$aRow['loo_id'];
				$row[1]=$aRow['region_nameshort'];
				$row[2]=$aRow['branch_name'];
				$row[3]=$aRow['rekanan_name']; 
				$row[4]=$aRow['rekananshipping_name']; 
				$row[5]=$aRow['agreement_id']; 
				if (!empty($row)) { $data[] = $row; }
			}
		} 
		else
		{
			foreach ($dataDlg as $aRow) 
			{ 
				$row[0]='';
				$row[1]='';
				$row[2]='';
				$row[3]='';
				$row[4]='';
				$row[5]='';
				if (!empty($row)) { $data[] = $row; }
			}
		}
	
		if ($dataDlg == NULL || $search=='')
		{ 
			$data = NULL;
			$dataDlgR = 0;
			$row[0]='';
			$row[1]='';
			$row[2]='';
			$row[3]=''; 
			$row[4]='';  
			$row[5]='';  
			$data[] = $row; 
		}
		
		 $output = array(
                 "draw" => $_POST['draw'],
                 "recordsTotal" => $dataDlgR,
                 "recordsFiltered" => $dataDlgR,
                 "data" => $data
            );  
		echo json_encode($output);
		
	}
	
	function index(){       
        redirect('rptar/rptar_list');
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
		$arcari=array('CTE.loo_id','C.region_nameshort', 'd.branch_name', 'e.rekanan_name','f.rekananshipping_name','CTE.file_name','CTE.createdate');
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
      $rResult=$this->model_rptar_cl->dataapp_list($region_id,$branch_id,$unit_id,$lantai_id); 
       
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
					 $sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;
					
				}
			}
		}
		 		
		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
		$limit =$limit+$top;
		$orderBy = $sOrder;
		//$b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ; 
		//$sWhere = $sWhere.$b;
        if ( $cariOptional <> '' ) {            
            $sWhere = $sWhere <> '' ? $sWhere." AND ".$cariOptional : " WHERE ".$cariOptional;
        }        
		
		$rResult=$this->model_rptar->$qry_alldata($limit,$top,$sWhere,$orderBy);
			
		$rResultCnt =$this->model_rptar->$qry_filtered($sWhere,$orderColumns);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_rptar->$qry_totalall();
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

    function rptar_list(){
        		
		$this->breadcrumbcomponent->add('Report Aging','rptar/rptar_list'); 
		$data['agrType'] = $this->Agr_select();
		$data['GroupTenantType'] = $this->GroupTenant_select();
		$data['GradeProperty'] = $this->PropertyGrade_select();
   
   
        $this->load->view('template/v_header');
        $this->load->view('rptar/rptar_list',$data);
        $this->load->view('template/v_footer');
    }
 
    function controler_gridlist(){

        $f_date =  isset($_POST['f_date']) ? $_POST['f_date']: '' ;
        $t_date =  isset($_POST['t_date']) ? $_POST['t_date']: '';

        $fromSearch = $f_date <> '' ? "createdate >= '$f_date' " : '';

        $optSearch = $fromSearch;

        if ($t_date <> ''){
            $searchCriteria = $t_date <> '' ? "createdate <= '$t_date' " : '';
            $optSearch =  $optSearch <> '' ?   $optSearch." AND ".$searchCriteria : $searchCriteria ;
        }        

        $arcari=$this->globalsearch_list();
        $vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari, $optSearch);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];
	 
        foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['loo_id']);
            $id_show =$aRow['loo_id']; 
                    $tenant = $id_show." - ".$aRow['rekananshipping_name'] ;

                    $ship_name = substr($aRow['rekanan_name'], 0, 20) . '...';

                    $brand_name = substr($aRow['rekananshipping_name'], 0, 20) . '...';
					$file_name = $aRow['file_name'];
                    $row[0]=$id_show;
                    $row[1]=$aRow['region_nameshort'];
                    $row[2]=$aRow['branch_name'];
                    $row[3]=$ship_name;
                    $row[4]=$brand_name;
					
					if($file_name != '')
					{
						$row[5]= '<a href="'.base_url().'index.php/legal_upload/file_load/'.$aRow['id_file'].'" data-toggle="tooltip" target="_blank" title="Download"><i class="fa fa-download fa-lg"></i></a>'.$file_name.'';
					}
					else
					{
						 $row[5]='';
					}
                    $row[6]=date('d-m-Y',strtotime($aRow['createdate']));
                    $row[7]='<a href="'.base_url().'index.php/legal_upload/legal_statusedit/'.$aRow['id_file'].'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit fa-lg"></i></a> 
                     <a href="'.base_url().'index.php/legal_upload/legal_statusdel/'.$aRow['id_file'].'" data-toggle="tooltip" title="Delete" onclick="return confirm(\'Anda yakin menghapus Data ini ?\');"><i class="fa fa-trash fa-lg"></i></a>';
        
            if (!empty($row)) { $output['data'][] = $row; }
        }   
        
        echo json_encode($output);
            
    }
   
    function Agr_select(){ 
        
        $hasil     = $this->model_rptar->get_AgrGroup();
        //$options    = array('' => 'Select an option');                
        
        if($hasil != 'kosong'){
            foreach($hasil as $key => $value){
				$options[''] = '';
                $options[$value->agrtypegroup_id]= $value->agrtypegroup_name;
            }
		}
		else
		{
			$options[''] = '';
		}
                    
        return $options;
    }
	
    function GroupTenant_select(){ 
        
        $hasil     = $this->model_rptar->get_GroupTenant();
        //$options    = array('' => 'Select an option');                
        
        if($hasil != 'kosong'){
            foreach($hasil as $key => $value){
				$options[''] = '';
                $options[$value->grouptenant_id]= $value->grouptenant_name;
            }
        }
		else
		{
			$options[''] = '';
		}
                    
        return $options;
    }
	
    function PropertyGrade_select(){ 
        
        $hasil     = $this->model_rptar->get_PropertGrade();
        //$options    = array('' => 'Select an option');                
        
        if($hasil != 'kosong'){
            foreach($hasil as $key => $value){
				$options[''] = '';
                $options[$value->branch_id]= $value->branch_name;
            }
        }
		else
		{
			$options[''] = '';
		}
                    
        return $options;
    }
   
    function report_load()
    {
		$array_items = array('rptardate', 'startdate','paymentdate','criteria','depositAcc','methodModel_name'); 
		$this->session->unset_userdata($array_items);
		$startdate = $this->input->post('startdate') != '' ? date('Y-m-d',strtotime($this->input->post('startdate'))) : '2000-01-01';
		$rptardate = $this->input->post('enddate') != '' ? date('Y-m-d',strtotime($this->input->post('enddate'))) :  date('Y-m-d')  ;
		$paymentdate = $this->input->post('payment_date') != '' ? date('Y-m-d',strtotime($this->input->post('payment_date'))) : date('Y-m-d') ;
		
		$t_type = $this->input->post('agrType');
		$wht = $this->input->post('wht');
		$unalloc_select = $this->input->post('unalloc_select');
		$tenant_HO = $this->model_rptar->get_MasterSettingValue('tenant_HO');
		//$acc_deposit = $this->model_rptar->get_MasterSettingValue('UNEARSD')->setting_value;
		$acc_deposit = $this->model_rptar->get_DepositType();
		
		$region_id = $this->input->post('region_ids'); 
		$branch_id = $this->input->post('branch_id');
		$rekanan_id = $this->input->post('rekanan_id');
		$rekananshipping_line = $this->input->post('rekananshipping_id');
		$acc_id = $this->input->post('acc_id');
		$incl_ppn = (int)$this->input->post('ppn_include');
		// echo $incl_ppn;exit;
		
		$report_type = $this->input->post('report_type');
		$txtSearchCriteria = '';
		
		if($t_type != '')
		{
			switch($t_type)
			{
				 case 'DEPOSIT':
					 $txtSearchCriteria = "doc_type in(select agreementtype_id from master_agreementtype where agreementtype_groupinv = ''DEPOSIT'')";
					break;
				case 'DP':
					$txtSearchCriteria = "doc_type in(select agreementtype_id from master_agreementtype where agreementtype_groupinv = ''DP'')";
					break;
				case "FOOD COURT LEVY":
					$txtSearchCriteria = "doc_type in(select agreementtype_id from master_agreementtype where agreementtype_groupinv = ''FOOD COURT LEVY')";
					break;
				case "PROMOTION LEVY":
					$txtSearchCriteria = "doc_type in(select agreementtype_id from master_agreementtype where agreementtype_groupinv = ''PROMOTION LEVY'')";
					break;
				case "PROVIT SHARING":
					$txtSearchCriteria = "doc_type in(select agreementtype_id from master_agreementtype where agreementtype_groupinv = ''PROVIT SHARING'')";
					break;
				case "RENTAL":
					$txtSearchCriteria = "doc_type in(select agreementtype_id from master_agreementtype where agreementtype_groupinv =''RENTAL'')";
					break;
				case "SERVICE CHARGE":
					$txtSearchCriteria = "doc_type in(select agreementtype_id from master_agreementtype where agreementtype_groupinv = ''SERVICE CHARGE'')";
					break;
				case "TELEPON":
					$txtSearchCriteria = "doc_type in(select agreementtype_id from master_agreementtype where agreementtype_groupinv = 'TELEPON'')";
					break;
				case "UTILITIES AIR":
					$txtSearchCriteria = "doc_type in(select agreementtype_id from master_agreementtype where agreementtype_groupinv = 'UTILITIES AIR'')";
					break;
				case "UTILITIES GAS":
					$txtSearchCriteria = "doc_type in(select agreementtype_id from master_agreementtype where agreementtype_groupinv = 'UTILITIES GAS'')";
					break;
				case "UTILITIES LISTRIK":
					$txtSearchCriteria = "doc_type in(select agreementtype_id from master_agreementtype where agreementtype_groupinv = 'UTILITIES LISTRIK'')";
					break;
				default:
					$txtSearchCriteria = "doc_type = '$t_type'";
			}
		}
		
		if($wht != '')
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "deduct_type = ''$wht''";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND deduct_type = ''$wht'' ";
			}
		}
		if($unalloc_select != '')
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "transaksi_trx = ''BC'' and rekanan_id <>''$tenant_HO''";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND transaksi_trx = ''BC'' and rekanan_id <>''$tenant_HO'' ";
			}
		}
		
		
		if($region_id <> 0)
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "region_id = ''$region_id''";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  region_id = ''$region_id'' ";
			}
		}
		
		
		if($branch_id <> 0)
		{
			
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "branch_id = ''$branch_id''";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND branch_id = ''$branch_id'' ";
			}
			
		}
		
		if($rekanan_id <> 0)
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "rekanan_id = ''$rekanan_id''";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  rekanan_id = ''$rekanan_id'' ";
			}
		}
		if($rekananshipping_line <> 0 )
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = " rekananshipping_line = '$rekananshipping_line'";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria."  AND rekananshipping_line = ''$rekananshipping_line'' ";
			}
		}
		if($acc_id <> 0 )
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = "acc_id = ''$acc_id'' ";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  acc_id = ''$acc_id'' ";
			}
		}
		 
		if((int)$incl_ppn != 0)
		{
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = " transaksi_type <> ''0000'' AND #TEMP_Summary.acc_id NOT IN (SELECT acc_id FROM master_accsource_ar WHERE type=''AGINGv3'' and descr=''tax_report_rptar'' ) ";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  transaksi_type <> ''0000'' AND #TEMP_Summary.acc_id NOT IN (SELECT acc_id FROM master_accsource_ar WHERE type=''AGINGv3'' and descr=''tax_report_rptar'' ) ";
			}
		}
		
		switch($report_type)
			{
				case 'rptarv2':
				$txtSearchCriteria = "";
				
				if((int)$incl_ppn == 1)
				{
					if($txtSearchCriteria == '')
					{
						$txtSearchCriteria = "  (  d.acc_id IN (SELECT acc_id 
										FROM   master_accsource_ar WHERE type = 'AGINGv2' and  descr <> 'pajak'
										) )   ";
					}
					else
					{
						$txtSearchCriteria = $txtSearchCriteria." AND  (  d.acc_id IN (SELECT acc_id 
										FROM   master_accsource_ar WHERE type = 'AGINGv2' and  descr <> 'pajak'
										) )   ";
					}
				}
				if((int)$incl_ppn == 0)
				{
					if($txtSearchCriteria == '')
					{
						$txtSearchCriteria = " ( d.acc_id IN (SELECT acc_id 
										FROM   master_accsource_ar WHERE type = 'AGINGv2'  
										) )";
					}
					else
					{
						$txtSearchCriteria = $txtSearchCriteria."  AND ( d.acc_id IN (SELECT acc_id 
										FROM   master_accsource_ar WHERE type = 'AGINGv2'  
										) )  ";
					}
				} 
				if($region_id <> 0)
				{
					if($txtSearchCriteria == '')
					{
						$txtSearchCriteria = "d.region_id= '$region_id'";
					}
					else
					{
						$txtSearchCriteria = $txtSearchCriteria." AND d.region_id= '$region_id'";
					}
					
				}
				
				if($branch_id <> 0)
				{
					
					if($txtSearchCriteria == '')
					{
						$txtSearchCriteria = "d.branch_id = '$branch_id'";
					}
					else
					{
						$txtSearchCriteria = $txtSearchCriteria." AND d.branch_id = '$branch_id' ";
					} 
				}	 
				if($rekananshipping_line <> 0 )
				{
					if($txtSearchCriteria == '')
					{
						$txtSearchCriteria = " d.rekananshipping_line = '$rekananshipping_line'";
					}
					else
					{
						$txtSearchCriteria = $txtSearchCriteria."  AND d.rekananshipping_line = '$rekananshipping_line' ";
					}
				} 
				if($rptardate <> '' AND $startdate <> '' )
				{
					$rptardate_split = explode("-", $rptardate);
					$startdate_split = explode("-", $startdate);
					if($txtSearchCriteria == '')
					{
						$txtSearchCriteria = " CONVERT(VARCHAR(7), j.jurnal_bookdate, 120) >= '$startdate_split[0]-$startdate_split[1]' AND CONVERT(VARCHAR(7), j.jurnal_bookdate, 120) <= '$rptardate_split[0]-$rptardate_split[1]' ";
					}
					else
					{
						$txtSearchCriteria = $txtSearchCriteria."  AND CONVERT(VARCHAR(7), j.jurnal_bookdate, 120) >= '$startdate_split[0]-$startdate_split[1]' AND CONVERT(VARCHAR(7), j.jurnal_bookdate, 120) <= '$rptardate_split[0]-$rptardate_split[1]' ";
					}
				}
				break; 
					
			}
		
		$criteria=$txtSearchCriteria;
		//echo var_dump($_POST);exit;
		
		
		
		$data['depositAcc'] = $acc_deposit;
		$data['enddate'] = $rptardate;
		
		$reportView = '';
		
		// echo $rptardate,$startdate,$paymentdate,$criteria;
		$methodModel_name = '';
		switch($report_type)
		{
			case 'ar_all':
				$data['result'] = $this->model_rptar->get_ReportAR($rptardate,$startdate,$paymentdate,$criteria);
				$reportView = 'rptar/report_rptar';
				$data['title'] = 'A/R All';
				$methodModel_name = 'get_ReportAR';
			break;
			case 'aging_all':
				$data['result'] = $this->model_rptar->get_ReportAgingV2($rptardate,$startdate,$paymentdate,$criteria);
				$reportView = 'rptar/report_rptaging';
				$data['title'] = 'Aging All';
				$methodModel_name = 'get_ReportAgingV2';
			break;
			 
			
		}
		$this->load->view($reportView,$data);
		$data['rptardate'] = $rptardate;
		$data['startdate'] = $startdate;
		$data['paymentdate'] = $paymentdate;
		$data['criteria'] = $criteria;
		$newdata = array(
					'rptardate'  => $rptardate,
					'startdate'     =>$startdate,
					'paymentdate' => $paymentdate,
					'criteria' => $criteria,
					'depositAcc' => $acc_deposit,
					'methodModel_name' => $methodModel_name
			); 
		$this->session->set_userdata($newdata);
    }
	 
	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_rptar->get_branch_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function acc_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_rptar->get_acc_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function region_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_rptar->get_region_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function rekanan_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_rptar->get_rekanan_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function rekananshipping_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_rptar->get_rekananshipping_dlg($rSearch['term']);
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
  

}  