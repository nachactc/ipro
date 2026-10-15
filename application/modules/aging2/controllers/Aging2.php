<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aging2 extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        $this->load->library('table');
        $this->load->model('model_aging');
		$this->load->library('breadcrumbcomponent');
		$this->load->helper(array('form', 'url'));
    }
	
	function index(){       
        redirect('aging2/aging_list');
    }  
	
	function globalsearch_list(){
		$arcari = array('rekanan_name', 'rekananshipping_name', 'jurnal_descr', 'transaksi_trx');
		return $arcari;
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
		//$limit = $limit+$top;
		$orderBy = $sOrder;
		//$b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ; 
		//$sWhere = $sWhere.$b;
        if ( $cariOptional <> '' ) {            
            $sWhere = $sWhere <> '' ? $sWhere." AND ".$cariOptional : " WHERE ".$cariOptional;
        }        
		
		$rResult=$this->model_aging->$qry_alldata($limit, $top, $sWhere, $orderBy);
			
		$rResultCnt =$this->model_aging->$qry_filtered($sWhere, $orderColumns);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_aging->$qry_totalall();
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

    function aging_list(){
        		
		$this->breadcrumbcomponent->add('Report Aging','aging2/aging_list'); 
		$data['agrType'] = $this->Agr_select();
		$data['GroupTenantType'] = $this->GroupTenant_select();
		$data['GradeProperty'] = $this->PropertyGrade_select();
   
   
        $this->load->view('template/v_header');
        $this->load->view('aging2/aging_list',$data);
        $this->load->view('template/v_footer');
    }
 
    function controler_gridlist(){

		set_time_limit(0);
        ini_set('memory_limit', '1024M');

		$optSearch = '';
        if (isset($_POST['params']['init'])) {
            $init = trim($_POST['params']['init']);
        }

		if($init==1) {

			$arcari = $this->globalsearch_list();
			$vResult = $this->initialize_grid("qry_alldatalist", "qry_filteredlist", "qry_totalalllist", $arcari, $optSearch);
			$rResult = $vResult['rResult'];
			$output = $vResult['output'];

			foreach ($rResult as &$aRow) {
				 
				//variabel
				$aRow['amount0'] = 0;
				$aRow['amount30'] = 0;
				$aRow['amount60'] = 0;
				$aRow['amount90'] = 0;
				$aRow['amount120'] = 0;
				$aRow['amount150'] = 0;
				$aRow['amount151'] = 0;
				$aRow['amountAllocation'] = 0;
				$aRow['amountDeposit'] = 0;
				
				if ($aRow['amount'] < 0 && $aRow['transaksi_type'] == '0101') {
					$aRow['amountAllocation'] = abs($aRow['amount']); 
				} elseif ($aRow['trx_based'] == 'DEPOSIT'){
					$aRow['amountDeposit'] = abs($aRow['amount']); 
				} elseif ($aRow['due'] < 15) {
					$aRow['amount0'] = abs($aRow['amount']); 
				} elseif ($aRow['due'] < 31) {
					$aRow['amount30'] = abs($aRow['amount']); 
				} elseif ($aRow['due'] < 61) {
					$aRow['amount60'] = abs($aRow['amount']); 
				} elseif ($aRow['due'] < 91) {
					$aRow['amount90'] = abs($aRow['amount']); 
				} elseif ($aRow['due'] < 121) {
					$aRow['amount120'] = abs($aRow['amount']); 
				} elseif ($aRow['due'] < 151) {
					$aRow['amount150'] = abs($aRow['amount']); 
				} elseif ($aRow['due'] >= 151) {
					$aRow['amount151'] = abs($aRow['amount']); 
				}
				$totalOutstanding = abs(
					$aRow['amount0'] + 
					$aRow['amount30'] +
					$aRow['amount60'] +
					$aRow['amount90']+ 
					$aRow['amount120'] +
					$aRow['amount150'] +
					$aRow['amount151']
				);
				$aRow['totalOutstanding'] = $totalOutstanding; 

				$duedate = new DateTime($aRow['duedate']);
				$aRow['duedate'] = $duedate->format('Y-m-d');
			}
			$output['data'] = $rResult;
		} else {
			
			$output = array(
				"draw"=> $_POST['draw'],
				"recordsTotal" => 0,
				"recordsFiltered" => 0,
				"data" => array()
			);
		}

        echo json_encode($output);
    }
   
    function Agr_select()
	{ 
        
        $hasil     = $this->model_aging->get_AgrGroup();
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
        
        $hasil     = $this->model_aging->get_GroupTenant();
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
        
        $hasil     = $this->model_aging->get_PropertGrade();
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
   
    function generateAging()
    {
		//$array_items = array('agingdate', 'startdate','paymentdate','criteria','depositAcc','methodModel_name'); 
		//$this->session->unset_userdata($array_items);
		$startdate = $_POST['startdate'] != '' ? date('Y-m-d',strtotime($_POST['startdate'])) : '2000-01-01';
		$agingdate =  $_POST['enddate'] != '' ? date('Y-m-d',strtotime($_POST['enddate'])) :  date('Y-m-d')  ;
		$paymentdate = $_POST['payment_date'] != '' ? date('Y-m-d',strtotime($_POST['payment_date'])) : date('Y-m-d') ;
		
		$t_type = $_POST['agrType'];
		$wht = $_POST['wht'];
		$unalloc_select = $_POST['unalloc_select'];
		$tenant_HO = $this->model_aging->get_MasterSettingValue('tenant_HO');
		//$acc_deposit = $this->model_aging->get_MasterSettingValue('UNEARSD')->setting_value;
		$acc_deposit = $this->model_aging->get_DepositType();
		
		$region_id = $_POST['region_ids']; 
		$branch_id = $_POST['branch_id'];
		$rekanan_id = $_POST['rekanan_id'];
		$rekananshipping_line = $_POST['rekananshipping_id'];
		$acc_id = $_POST['acc_id'];
		$incl_ppn = isset($_POST['ppn_include']) ? (int)$_POST['ppn_include'] : 0;
		
		$report_type = $_POST['report_type'];
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
				$txtSearchCriteria = " transaksi_type <> ''0000'' AND #TEMP_Summary.acc_id NOT IN (SELECT acc_id FROM master_accsource_ar WHERE type=''AGINGv3'' and descr=''tax_report_aging'' ) ";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  transaksi_type <> ''0000'' AND #TEMP_Summary.acc_id NOT IN (SELECT acc_id FROM master_accsource_ar WHERE type=''AGINGv3'' and descr=''tax_report_aging'' ) ";
			}
		}
		
		switch($report_type)
			{
				case 'agingv2':
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
				if($agingdate <> '' AND $startdate <> '' )
				{
					$agingdate_split = explode("-", $agingdate);
					$startdate_split = explode("-", $startdate);
					if($txtSearchCriteria == '')
					{
						$txtSearchCriteria = " CONVERT(VARCHAR(7), j.jurnal_bookdate, 120) >= '$startdate_split[0]-$startdate_split[1]' AND CONVERT(VARCHAR(7), j.jurnal_bookdate, 120) <= '$agingdate_split[0]-$agingdate_split[1]' ";
					}
					else
					{
						$txtSearchCriteria = $txtSearchCriteria."  AND CONVERT(VARCHAR(7), j.jurnal_bookdate, 120) >= '$startdate_split[0]-$startdate_split[1]' AND CONVERT(VARCHAR(7), j.jurnal_bookdate, 120) <= '$agingdate_split[0]-$agingdate_split[1]' ";
					}
				}
				break; 
					
			}
		
		$criteria = $txtSearchCriteria;
		//echo var_dump($_POST);exit;				
		$data['depositAcc'] = $acc_deposit;
		$data['enddate'] = $agingdate;
		
		$reportView = '';
		$this->model_aging->setReportAgingRaw($agingdate, $startdate, $paymentdate, $criteria);
    }
	 
	function branch_select_dialog()
	{
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_aging->get_branch_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function acc_select_dialog()
	{
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_aging->get_acc_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function region_select_dialog()
	{
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_aging->get_region_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function rekanan_select_dialog()
	{
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_aging->get_rekanan_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function rekananshipping_select_dialog()
	{
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_aging->get_rekananshipping_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}

    function branch_select()
	{
 
        $rSearch = empty($_GET['term']) ? '' : $_GET['term'];
        $rRegion = empty($_GET['region']) ? '' : $_GET['region'];


        if (is_array($rSearch) && $rSearch['_type'] == 'query'){            

            $this->load->model('template/Master_m');
            
            $branch      = $this->Master_m->get_branchbyquery($rSearch['term'], $rRegion);
            
			
            $result['items']= $branch;
          
            echo json_encode($result);
            
        };
    }

	function getAgingRow () 
	{
		set_time_limit(0);
        ini_set('memory_limit', '1024M');

        //$this->db->where('jurnal_id', 'SPCRP122010019910');
		$sql = $this->db->get('report_aging');
		$rows = $sql->result();
		foreach ($rows as $row) {

			//variabel
			$row->amount0 = 0;
			$row->amount30 = 0;
			$row->amount60 = 0;
			$row->amount90 = 0;
			$row->amount120 = 0;
			$row->amount150 = 0;
			$row->amount151 = 0;
			$row->amountAllocation = 0;
			$row->amountDeposit = 0;
			
			if ($row->amount < 0 && $row->transaksi_type == '0101') {
				$row->amountAllocation = abs($row->amount); 
			} elseif ($row->trx_based == 'DEPOSIT'){
				$row->amountDeposit = abs($row->amount); 
			} elseif ($row->due < 15) {
				$row->amount0 = abs($row->amount); 
			} elseif ($row->due < 31) {
				$row->amount30 = abs($row->amount); 
			} elseif ($row->due < 61) {
				$row->amount60 = abs($row->amount); 
			} elseif ($row->due < 91) {
				$row->amount90 = abs($row->amount); 
			} elseif ($row->due < 121) {
				$row->amount120 = abs($row->amount); 
			} elseif ($row->due < 151) {
				$row->amount150 = abs($row->amount); 
			} elseif ($row->due >= 151) {
				$row->amount151 = abs($row->amount); 
			}
			$totalOutstanding = abs(
				$row->amount0 + 
				$row->amount30 +
				$row->amount60 +
				$row->amount90+ 
				$row->amount120 +
				$row->amount150 +
				$row->amount151
			);
			$row->totalOutstanding = $totalOutstanding; 

			//$duedate = new DateTime($row->duedate);
			// /$row->duedate = $duedate->format('Y-m-d');
		}

		echo json_encode($rows);
	}
}  