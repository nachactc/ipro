<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reminder extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_reminder');
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
			$dataDlg = $this->model_reminder->get_data_dialog_loo($search);
			$dataDlgR = $this->model_reminder->get_data_dialog_loo_rows($search);
		
		 
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
        redirect('reminder/reminder_list');
    }
    function globalsearch_aging(){
        $arcari=array('#TEMP_Summary.region_id','#TEMP_Summary.branch_id','#TEMP_Summary.rekanan_id','#TEMP_Summary.rekananshipping_line','jurnal_id','startdate','enddate','paymentdate');
        return $arcari;
    }
    function globalsearch_rekanan(){
        $arcari=array('rekanan_name','A.rekanan_id', 'B.branch_id');
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
      $rResult=$this->model_reminder_cl->dataapp_list($region_id,$branch_id,$unit_id,$lantai_id); 
       
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
		$startdate="";
		$enddate="";
		$paymentdate="";
		$sWhere = "";
		$sWherexx = "";		
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
						if ($aColumns[$i] == 'rekananshipping_line'){
							  if ($searchCol == 'null'){
									$sWherexx .= $searchCol;
								}
						}					
						elseif ($aColumns[$i] == 'startdate'){
						  $startdate .= $searchCol;
						}
						elseif ($aColumns[$i] == 'enddate'){
						  $enddate .= $searchCol;
						}
						elseif ($aColumns[$i] == 'paymentdate'){
						  $paymentdate .= $searchCol;
						}
						else{
							$sWhere .= " AND ". $aColumns[$i] . " LIKE '%".$searchCol."%'";	
						}
						
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
		
		//echo '->' . $startdate;
		//echo $sWhere;
		//exit;
		
        if ( $cariOptional <> '' ) {            
            $sWhere = $sWhere <> '' ? $sWhere." AND ".$cariOptional : " WHERE ".$cariOptional;
        }        
		
		$sWhereUser = "";
		$username=$this->session->userdata('username');
		if ($sWhere =='') {
			$sWhereUser = " where username = "."'".$username."'";
		}
        else
		{
			$sWhereUser = " and username = "."'".$username."'";
		}
		
		$rResult=$this->model_reminder->$qry_alldata($limit,$top,$sWhere,$sWhereUser,$startdate,$enddate,$paymentdate);
			
		$rResultCnt =$this->model_reminder->$qry_filtered($sWhere,$sWhereUser);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_reminder->$qry_totalall($sWhereUser);
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
	
    function controler_gridaging(){
        $arcari=$this->globalsearch_aging();
        $vResult=$this->initialize_grid("qry_alldataaging","qry_filteredaging","qry_totalallaging",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {
            $row = array();
			$amount=$aRow['amount'];
            //$id=$aRow['jurnal_id'];
			   $row[]=$aRow['jurnal_id'];
               $row[]=$aRow['jurnal_descr'];
               $row[]=$aRow['region_name'];
               $row[]=$aRow['branch_name'];
               $row[]=$aRow['rekanan_name'];
               $row[]=$aRow['rekananshipping_name'];
			   $row[]=number_format($aRow['jurnaldetil_idr'], 2, '.', ',');
			   $row[]='<input type="text" id="tamt[]" name="tamt[]" value="'.number_format($amount,0).'" class="clsamt detil bulet form-control input-sm" style= "text-align: right;"/>';
               $row[]=$aRow['duedate'];               
               $row[]=$aRow['faktur_id'];
			   $row[]=$aRow['contract_no'];
               $row[]=$aRow['region_id'];
               $row[]=$aRow['branch_id'];
			   $row[]=$aRow['rekanan_id'];			   
               $row[]=$aRow['rekananshipping_line'];
			   $row[]=$aRow['ref_id'];			   			   
			   $row[]=$aRow['due'];
			   $row[]=$aRow['faktur_id'];
			   $row[]=$aRow['SP1'];
			   $row[]=$aRow['SP2'];
			   $row[]=$aRow['SP3'];

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

    function reminder_list(){
        		
		$this->breadcrumbcomponent->add('Report OT','reminder/reminder_list'); 
		$data['agrType'] = $this->Agr_select();
		$data['GroupTenantType'] = $this->GroupTenant_select();
		$data['GradeProperty'] = $this->PropertyGrade_select();
		$data['region'] =  '';
		$data['result'] =  '';
   
        $this->load->view('template/v_header');
        $this->load->view('reminder/reminder_list',$data);
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
        
        $hasil     = $this->model_reminder->get_AgrGroup();
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
        
        $hasil     = $this->model_reminder->get_GroupTenant();
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
        
        $hasil     = $this->model_reminder->get_PropertGrade();
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
		$startdate = $this->input->post('startdate') != '' ? date('Y-m-d',strtotime($this->input->post('startdate'))) : '2000-01-01';
		$agingdate = $this->input->post('enddate') != '' ? date('Y-m-d',strtotime($this->input->post('enddate'))) :  date('Y-m-d')  ;
		$paymentdate = $this->input->post('payment_date') != '' ? date('Y-m-d',strtotime($this->input->post('payment_date'))) : date('Y-m-d') ;
		
		$t_type = $this->input->post('agrType');
		$wht = $this->input->post('wht');
		$unalloc_select = $this->input->post('unalloc_select');
		$tenant_HO = $this->model_reminder->get_MasterSettingValue('tenant_HO');
		$acc_deposit = $this->model_reminder->get_MasterSettingValue('UNEARSD');
		$region_id = $this->input->post('region_ids'); 
		$branch_id = $this->input->post('branch_id');
		$rekanan_id = $this->input->post('rekanan_id');
		$rekananshipping_line = $this->input->post('rekananshipping_id');
		$acc_id = $this->input->post('acc_id');
		$incl_ppn = (int)$this->input->post('ppn_include');
		//echo $incl_ppn;exit;
		
		$txtSearchCriteria = '';
		
		 
		
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
				$txtSearchCriteria = "rekanan_id = ''$rekanan_id'' AND rekananshipping_line = '$rekananshipping_line'";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  rekanan_id = ''$rekanan_id'' AND rekananshipping_line = ''$rekananshipping_line'' ";
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
		
		// if((int)$incl_ppn != 0)
		// {
			if($txtSearchCriteria == '')
			{
				$txtSearchCriteria = " transaksi_type <> ''0000'' ";
			}
			else
			{
				$txtSearchCriteria = $txtSearchCriteria." AND  transaksi_type <> ''0000'' ";
			}
		// }
		
		$criteria=$txtSearchCriteria;
		//echo var_dump($_POST);exit;
		
		
		
		$data['depositAcc'] = $acc_deposit;
		$data['enddate'] = $agingdate;
		
		$report_type = $this->input->post('report_type'); 
		$data['agrType'] = $this->Agr_select();
		$data['GroupTenantType'] = $this->GroupTenant_select();
		$data['GradeProperty'] = $this->PropertyGrade_select(); 
		$data['region'] = $this->input->post('region_name'); 
		$data['result'] = $this->model_reminder->get_ReportAging($startdate,$agingdate,$paymentdate,$criteria); 
		
		
		
        $this->load->view('template/v_header');
        $this->load->view('reminder/reminder_list',$data);
        $this->load->view('template/v_footer'); 
		
    }
	
	
	function branch_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_reminder->get_branch_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function acc_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_reminder->get_acc_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function region_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_reminder->get_region_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function rekanan_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_reminder->get_rekanan_dlg($rSearch['term']);
		$result['items']= $branch; 
		echo json_encode($result);
	}
	
	function rekananshipping_select_dialog(){
		$rSearch = empty($_GET['term']) ? '' : $_GET['term'];
		$branch      = $this->model_reminder->get_rekananshipping_dlg($rSearch['term']);
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
 public function explodeID(){
	 
 }
   public function duedateprinfpdf(){

		ini_set('memory_limit','256M'); 
		ini_set('sqlsrv.ClientBufferMaxKBSize','524288');
		ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288');
		
 
	  $username=$this->session->userdata('username');
	  $jurnal_id = $this->input->post('jurnal_id');
	  $jurnal_descr = $this->input->post('jurnal_descr');
	  $startdate = $this->input->post('startdate');
	  $enddate = $this->input->post('enddate');
	  $paymentdate = $this->input->post('payment_date');
	  $reminder = $this->input->post('reminder');
	  $contract_no = $this->input->post('contract_no');
	  $amount = $this->input->post('amount');
	  $faktur_id = $this->input->post('faktur_id');
	  
	  $region_idx = $this->input->post('region_id2');
	  $branch_idx = $this->input->post('branch_id2');
	  $rekanan_idx = $this->input->post('rekanan_id2');
	  $rekananshipping_linex = $this->input->post('rekananshipping_line2');
	  
	  $jurnal_id2 = $this->input->post('jurnal_id2');
	  $jurnal_descr2 = $this->input->post('jurnal_descr2');
	  $NoSP1 = $this->input->post('SP1');
	  $NoSP2 = $this->input->post('SP2');
	  $NoSP3 = $this->input->post('SP3');
	  $idrx = $this->input->post('idr');
	  
	  $hregion = $this->input->post('hregion');
	  $hbranch = $this->input->post('hbranch');
	  $htenant = $this->input->post('htenant');
	  $hbrand = $this->input->post('hbrand');
	// echo 'cb ' . $hregion;
	

		
		
		
	  // echo $amount;
	  // exit;
		
	  $idUidX = explode("_",$jurnal_id2);
	  $jmlX=count($idUidX)-1;
		
	  $idUidX2 = explode("_",$jurnal_descr2);
	  $jmlX2=count($idUidX2)-1;
	  
	  $idUidX3 = explode("_",$faktur_id);
	  $jmlX3=count($idUidX3)-1;
	  
	  $idUidX4 = explode("_",$amount);
	  $jmlX4=count($idUidX4)-1;
	  
	  $idUidX5 = explode("_",$region_idx);
	  $idUidX6 = explode("_",$branch_idx);
	  $idUidX7 = explode("_",$rekanan_idx);
	  $idUidX8 = explode("_",$rekananshipping_linex);
	  $idUidX9 = explode("_",$idrx);
	  $idUidX10 = explode("_",$NoSP1);
	  $idUidX11 = explode("_",$NoSP2);
	  $idUidX12 = explode("_",$NoSP3);
	  
	  
	  $jur_descr2 ='';
	  $sp1old = 'null';
	  $sp2old = 'null';
	  $sp3old = 'null';
	  for($i = 0, $size = count($idUidX); $i < $size; ++$i) {
		$jur_id2 = $idUidX[$i];
		$jur_descr2 = $idUidX2[$i];
		$fak_id = $idUidX3[$i];
		$amn = $idUidX4[$i];
		$reg = $idUidX5[$i];
		$bra = $idUidX6[$i];
		$rek = $idUidX7[$i];
		$lin = $idUidX8[$i];
		$idr = $idUidX9[$i];
		//$sp1x = $idUidX10[$i];
		// echo '_' . $jur_id2;
		// echo '_' . $jur_descr2;
		//echo $jur_id2 . '-' .$jur_descr2;
		$data['jurnal'][] = array(
				'jurnal_id'       => $jur_id2,
				'jurnal_descr'     => $jur_descr2,
				'faktur_id'     => $fak_id,
				'amount'     => $amn
		);		
	//insert to log_no_SP
	
		// if ($sp1x=='null'){
				$insert=$this->model_reminder->insert_log_no_sp($jur_id2,$jur_descr2,$reg,$bra,$rek,$lin,$idr,$amn,$enddate,$username);
				
				$selectsp=$this->model_reminder->select_log_no_sp($jur_id2,$jur_descr2,$reg,$bra,$rek,$lin);
				$sp1x =$selectsp['SP1'];
				$sp1_tgl =$selectsp['tanggal_SP1'];
				if ($sp1_tgl!=''){
					$tanggal_SP1_old =$selectsp['tanggal_SP1'];
				}
				//echo 'TGL SP1 : ' . $selectsp['tanggal_SP1'];			
				  if ($sp1x  != '') {
					  $sp1old = $sp1x;					  
				  }		
				$sp2x =$selectsp['SP2'];
				$sp2_tgl =$selectsp['tanggal_SP2'];
				if ($sp1_tgl!=''){
					$tanggal_SP_old =$selectsp['tanggal_SP2'];
				}
				
				//echo $sp2x . '-';
				  if ($sp2x  != '') {
					  $sp2old = $sp2x;
				  }	
				$sp3x =$selectsp['SP3'];
				$sp3_tgl =$selectsp['tanggal_SP3'];
				  if ($sp3x  != '') {
					  $sp3old = $sp3x;
				  }				  
		// }
	  }
	  // echo 'SP1 : ' . $tanggal_SP1_old . ' SP2 : ' . $sp2old . ' SP3 : ' . $sp3old;
	//exit;  

  if ($reminder=='1'){		  	  
	  //echo '_' . $sp1old;
		$no_SP =$sp1old;
		$no_SP_old =$sp1old;
		$tanggal_SP_old =$sp1_tgl;
		$no_SP1_old =$sp1old;
	    //$tanggal_SP1_old=$sp1_tgl;
	  if ($sp1old == 'null') {
		  
		  $sequen = $this->model_reminder->get_nospNew();
		  $spnew = $sequen['ID'];
		  $no_SP =$spnew;
		  $tanggal_SP =$enddate;
		  for($i = 0, $size = count($idUidX); $i < $size; ++$i) {
			$jur_id2 = $idUidX[$i];
			$jur_descr2 = $idUidX2[$i];
			$fak_id = $idUidX3[$i];
			$amn = $idUidX4[$i];
			$reg = $idUidX5[$i];
			$bra = $idUidX6[$i];
			$rek = $idUidX7[$i];
			$lin = $idUidX8[$i];
			$update=$this->model_reminder->update_log_no_sp($jur_id2,$jur_descr2,$reg,$bra,$rek,$lin,$spnew,$enddate,$reminder,$username);			
		  }
	  }
   }
  if ($reminder=='2'){
	  $no_SP =$sp2old;
	  $no_SP_old =$sp1old;
	  //$tanggal_SP_old =$sp1_tgl;
	  $no_SP1_old =$sp1old;
	  //$tanggal_SP1_old=$sp1_tgl;
	  if ($sp1old == 'null') {
		  echo 'SP 1 belum dibuat!';
		  exit;
	  }
	  if ($sp2old == 'null') {
		  $sequen = $this->model_reminder->get_nospNew();
		  $spnew = $sequen['ID'];
		  $no_SP =$spnew;
		  $tanggal_SP =$enddate;
		  for($i = 0, $size = count($idUidX); $i < $size; ++$i) {
			$jur_id2 = $idUidX[$i];
			$jur_descr2 = $idUidX2[$i];
			$fak_id = $idUidX3[$i];
			$amn = $idUidX4[$i];
			$reg = $idUidX5[$i];
			$bra = $idUidX6[$i];
			$rek = $idUidX7[$i];
			$lin = $idUidX8[$i];
			$update=$this->model_reminder->update_log_no_sp($jur_id2,$jur_descr2,$reg,$bra,$rek,$lin,$spnew,$enddate,$reminder,$username);			
		  }
	  }	  
  }   
  if ($reminder=='3'){
	  $no_SP =$sp3old;
	  $no_SP1_old =$sp1old;
	  $no_SP_old =$sp2old;
	  //$tanggal_SP1_old=$sp1_tgl;
	  //$tanggal_SP_old =$sp2_tgl;
	  if ($sp2old == 'null') {
		  echo 'SP 2 belum dibuat!';
		  exit;
	  }
	  if ($sp3old == 'null') {
		  $sequen = $this->model_reminder->get_nospNew();
		  $spnew = $sequen['ID'];
		  $no_SP =$spnew;
		  $tanggal_SP =$enddate;		  
		  for($i = 0, $size = count($idUidX); $i < $size; ++$i) {
			$jur_id2 = $idUidX[$i];
			$jur_descr2 = $idUidX2[$i];
			$fak_id = $idUidX3[$i];
			$amn = $idUidX4[$i];
			$reg = $idUidX5[$i];
			$bra = $idUidX6[$i];
			$rek = $idUidX7[$i];
			$lin = $idUidX8[$i];
			$update=$this->model_reminder->update_log_no_sp($jur_id2,$jur_descr2,$reg,$bra,$rek,$lin,$spnew,$enddate,$reminder,$username);			
		  }
	  }	  
  }  
	  // exit;
	  // $faktur_id = $this->input->post('faktur_id');
	  // $region_id = $this->input->post('region_id');
	  // $report_type = $this->input->post('report_type');
	  // $invoicedate = $this->input->post('iinvoicedate');
	  // $invoiceduedate = $this->input->post('iinvoiceduedate');
	  // $reminder = $this->input->post('reminder');
	  // $agreement_id = $this->input->post('agreement_id');

		// echo '--> ' . $startdate;
		// print_r($data['jurnal']);
		// exit;
		
       $timestamp = time();
       $now = date("Y-m-d H:i:s", $timestamp);	  
	  
        $namesetting  =$this->model_reminder->getmastersetting('rptVA_name');
        $name =$namesetting['setting_value']; 	
        $positionsetting  =$this->model_reminder->getmastersetting('rptVA_position');
        $position =$positionsetting['setting_value'];			  

        $namesetting  =$this->model_reminder->getmastersetting('rptOS_name');
        $nameOS =$namesetting['setting_value']; 	
        $positionsetting  =$this->model_reminder->getmastersetting('rptOS_position');
        $positionOS =$positionsetting['setting_value'];
		
		  
	  
	  $usersp  =$this->model_reminder->getusersp($username);
	  $usersp_name =$usersp['name'];
	  $usersp_email =$usersp['email'];
	  $usersp_telp =$usersp['telp'];

	  	// echo '-' . $invoice_id . '-' . $faktur_id;
		// exit;
	   /*
		$i_size = substr($i_link, -2);
		$i_link = substr_replace($i_link, "", -2);
		//echo $i_link;
		//$i_link2 = $this->uri->segment(5);
		$invoice_id = str_replace('_', '/', $i_link);
        //$invoice_id = str_replace('X', '_', $invoice_id);
		$invoice_id = str_replace('-', '.', $invoice_id);
		//$faktur_id = $i_link2;
*/

		$idUid = explode("_",$jurnal_id);
		$jml=count($idUid)-1;
		
		$idUid2 = explode("_",$jurnal_descr);
		$jml2=count($idUid2)-1;
		
		// $idUid3 = explode("_",$agreement_id);
		// $jml3=count($idUid3)-1;

		$str = $jurnal_id;
		//echo strtok($str, '_');
		
		//exit;
		//print_r($idUid);
		//echo $idUid; exit;
		//echo $invoice_id;
for($i = 0, $size = count($idUid); $i < $size; ++$i) {

        //$invfak_id = $idUid[$i];
		$jur_id = $idUid[$i];
		$jur_descr = $idUid2[$i];
		// $agr_id = $idUid3[$i];
		
		// $scheduledetil  =$this->model_reminder->getscheduledetil($jur_id);
		// $agr_id = $scheduledetil['ref_id'];
		
		//cari transaksi jurnal
		//echo $jur_id; exit;
		$jurnal  =$this->model_reminder->get_transaksi_jurnal($jur_id);
		$branch_id = $jurnal['branch_id'];
		$region_id = $jurnal['region_id'];
		$rekanan_id = $jurnal['rekanan_id'];
		$rekananshipping_line = $jurnal['rekananshipping_line'];
		//$contract_no = $jurnal['sub2_id'];
		
		//Cek SP1 dan SP2 sudah ada belum
		// if ($reminder == '2') {
			// $getsp1sp2=$this->model_reminder->getsp1sp2($jurnal_id2,$jurnal_descr2,$region_id,$branch_id,$rekanan_id,$rekananshipping_line,'1');
			// if(!isset($getsp1sp2)){
				// echo 'SP 1 belum dibuat !!!';
				// exit;
			// }		
		// }
		// if ($reminder == '3') {
			// $getsp1sp2=$this->model_reminder->getsp1sp2($jurnal_id2,$jurnal_descr2,$region_id,$branch_id,$rekanan_id,$rekananshipping_line,'2');
			// if(!isset($getsp1sp2)){
				// echo 'SP 2 belum dibuat !!!';
				// exit;
			// }			
		// }
		
		//cari master region
		$mregion = $this->model_reminder->getmasterregion($region_id);
		$region_namereport = $mregion['region_namereport'];
		
		//cari master branch
		$mbranch = $this->model_reminder->getmasterbranch($branch_id);
		$branch_name = $mbranch['branch_namerpt'];

		//cari master rekanan
		$mrekanan = $this->model_reminder->getmasterrekanan($rekanan_id);
		$rekanan_namereport = $mrekanan['rekanan_namereport'];
		$rekanan_name = $mrekanan['rekanan_name'];
		$grouptenant_id = $mrekanan['grouptenant_id'];
		
		//cari master rekananshipping
		$mrekananshipping = $this->model_reminder->getmasterrekananshipping($rekanan_id,$rekananshipping_line);
		$rekananshipping_name = $mrekananshipping['rekananshipping_name'];
		$rekananshipping_address = $mrekananshipping['rekananshipping_address'];
		$rekananshipping_contactname = $mrekananshipping['rekananshipping_contactname'];
		//echo $contract_no; exit;
		//cari transaksi_agreement
		$agreement  =$this->model_reminder->getagreement_bycontract($contract_no);
		$agr_id = $agreement['agreement_id'];
		$agreementid = $agreement['agreement_id'];
		$agreement_loonumber = $agreement['agreement_loonumber'];
		//echo $agreement_loonumber; exit;
		if ($agreement_loonumber =='')
		{
			$agreement_loonumber = 'XXX/0000/XXX/XXX/VII-00';
		}
		$pieces = explode("/",$agreement_loonumber); 
        $pieces2 = explode("-",$agreement_loonumber); 
																
		//cari shop unit di transaksi_agreement
		$agreementdetil  =$this->model_reminder->getagreementdetil_shopunit($agreementid);
		$shopunit = $agreementdetil['agreementdetil_unit'];
		
		$rshortbranch=$this->model_reminder->qry_getbranchshort($agreement_loonumber);
		$branchsht=$rshortbranch['branch_nameshort'];
		
		$rowgettahun=$this->model_reminder->get_laedit($agreement_loonumber);
		$vgettahun=$rowgettahun['tgl_sign'];
		$tglla=$rowgettahun['tgl_sign'];

		// echo '--> ' . $agreement_loonumber;
		// exit;
		
		if ($vgettahun <>""){
			$tdate = explode('-', $vgettahun);
			$tbln= $tdate[1]+0;						
			$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
			$aromawi = $array_bulan[$tbln];}
		else
		{						
			$exppieces=substr($pieces[4],0,strlen($pieces[4]));
			$exppieces=explode("-",$exppieces);
			$aromawi=substr($exppieces[0],0,strlen($pieces[4]));
		}
		
		$atahun="20".$pieces2[1];
		

		
		$nolah=$pieces[1]."/LA-".$branchsht."/A&D/".$pieces[3]."/".$aromawi."/".$atahun;
		
		//echo '--' . $inv_id . '--' . $fak_id; 
		// echo '--> ' . $nolah;
		// exit;
		
		// $where = ' #TEMP_Summary.region_id = ' ."'"."'".$region_id."'"."'";
		// $where = $where . ' and #TEMP_Summary.branch_id = ' ."'"."'".$branch_id."'"."'";
		// $where = $where . ' and #TEMP_Summary.rekanan_id = ' ."'"."'".$rekanan_id."'"."'";
		// $where = $where . ' and #TEMP_Summary.rekananshipping_line = ' ."'"."'".$rekananshipping_line."'"."'";
		
		// echo $jurnal_id2 .'=' . $jurnal_descr2 . '=' . $where;
		// exit;
		// $totalOT=$this->model_reminder->get_totalOT($where);
		// $TotalAmount=$totalOT['total'];
		$where ='';
		if ($hregion != '') {
			$where = ' #TEMP_Summary.region_id = ' ."'"."'".$hregion."'"."'";
		}
		if ($hbranch != '') {
			$where = $where . ' and #TEMP_Summary.branch_id = ' ."'"."'".$hbranch."'"."'";
		}
		if ($htenant != '') {
			$where = $where . ' and #TEMP_Summary.rekanan_id = ' ."'"."'".$htenant."'"."'";
		}
		if ($hbrand != '') {
			$where = $where . ' and #TEMP_Summary.rekananshipping_line = ' ."'"."'".$hbrand."'"."'";
		}
		
		$data['result'][] = $this->model_reminder->get_reportOutStanding($where,$startdate,$enddate,$paymentdate);
		
		// $where = $where . ' and jurnal_id = ' ."'"."'".$jur_id."'"."'";
		// $where = $where . ' and jurnal_descr = ' ."'"."'".$jur_descr."'"."'";
		
		// $getsp=$this->model_reminder->get_nosp($jurnal_id2,$jurnal_descr2,$region_id,$branch_id,$rekanan_id,$rekananshipping_line,$reminder,$enddate,$username);
		// $no_SP=$getsp['no_SP'];
		// $tanggal_SP=$getsp['tanggal'];
		// $no_SP_old =$getsp['no_SP'];
		// $tanggal_SP_old =$getsp['tanggal'];
		// $no_SP1_old =$getsp['no_SP'];
		// $tanggal_SP1_old =$getsp['tanggal'];
		// $tanggal_SP_new = date('Y-m-d', strtotime($tanggal_SP. ' + 7 days'));
		//echo $tanggal_SP_new;
		//exit;
		
		// if ($tanggal_SP == ''){
			// $tanggal_SP = $enddate;
			// $tanggal_SP_new = date('Y-m-d', strtotime($tanggal_SP. ' + 7 days'));
		// }
		
		// if ($no_SP ==''){
			// $getsp=$this->model_reminder->get_nosp($jurnal_id2,$jurnal_descr2,$region_id,$branch_id,$rekanan_id,$rekananshipping_line,$reminder,$enddate,$username);
			// $no_SP=$getsp['no_SP'];
			// $tanggal_SP=$getsp['tanggal'];
			// $tanggal_SP_new = date('Y-m-d', strtotime($tanggal_SP. ' + 7 days'));
		// }
		
		//echo 'tes';
		// if ($reminder == '2') {
			// $getsp=$this->model_reminder->get_nosp($jurnal_id2,$jurnal_descr2,$region_id,$branch_id,$rekanan_id,$rekananshipping_line,'1',$enddate,$username);
			// $no_SP_old=$getsp['no_SP'];
			// $tanggal_SP_old=$getsp['tanggal'];
			// $tanggal_SP_new = date('Y-m-d', strtotime($tanggal_SP. ' + 7 days'));
			
		// }
		// elseif ($reminder == '3') {
			// $getsp=$this->model_reminder->get_nosp($jurnal_id2,$jurnal_descr2,$region_id,$branch_id,$rekanan_id,$rekananshipping_line,'2',$enddate,$username);
			// $no_SP_old=$getsp['no_SP'];
			// $tanggal_SP_old=$getsp['tanggal'];
			// $tanggal_SP_new = date('Y-m-d', strtotime($tanggal_SP. ' + 3 days'));
			
			// SP 1
			// $getsp1=$this->model_reminder->get_nosp($jurnal_id2,$jurnal_descr2,$region_id,$branch_id,$rekanan_id,$rekananshipping_line,'1',$enddate,$username);
			// $no_SP1_old=$getsp1['no_SP'];
			// $tanggal_SP1_old=$getsp1['tanggal'];
			
		// }
		
        
      }
	
	
	$hari =0;
	$data['region'] = $this->model_reminder->getmasterregion($region_id);

	// echo 'bug: ' .$tanggal_SP;
	// exit;
	// echo $region_id;
	// exit;
	//$reminder = 'REMINDER 1';
	$tanggal_SP = $enddate;
	if ($reminder == '1'){
		$hari ='7';
		$reminder = 'REMINDER 1';
		$tanggal_SP_new = date('Y-m-d', strtotime($tanggal_SP. ' + 7 days'));
	}
	if ($reminder == '2'){
		$hari ='7';
		$reminder = 'REMINDER 2';
		$tanggal_SP_new = date('Y-m-d', strtotime($tanggal_SP. ' + 7 days'));
	}
	if ($reminder == '3'){
		$hari ='3';
		$reminder = 'REMINDER 3';
		$tanggal_SP_new = date('Y-m-d', strtotime($tanggal_SP. ' + 3 days'));
	}
	
	// $arrtgl=$this->model_reminder->gettglinv($inv_id);
	// $data['iinvoicedate'] = $arrtgl['tglinv'];
	// $data['iinvoiceduedate'] = $arrtgl['tgldue'];
	$data['nameOS']  = $name;
	$data['positionOS']  = $position;
	$data['nameOS']  = $nameOS;
	$data['positionOS']  = $positionOS;	
	$data['reminder']  = $reminder;
	$data['hari']  = $hari;
	$data['region_namereport'] = $region_namereport;
	$data['nola'] = $nolah;
	$data['tglla'] = $tglla;
	// $data['TotalAmount'] = $TotalAmount;
	$data['shopunit'] = $shopunit;
	$data['no_SP'] = $no_SP;
	$data['tanggal_SP'] = $tanggal_SP;
	$data['no_SP_old'] = $no_SP_old;
	$data['tanggal_SP_old'] = $tanggal_SP_old;
	$data['no_SP1_old'] = $no_SP1_old;
	$data['tanggal_SP1_old'] = $tanggal_SP1_old;
	$data['tanggal_SP_new'] = $tanggal_SP_new;
	$data['amount'] = $amount;
	$data['usersp_name'] = $usersp_name;
	$data['usersp_email'] = $usersp_email;
	$data['usersp_telp'] = $usersp_telp;
	
	$data['rekanan_namereport'] = $rekanan_namereport;
	$data['rekananshipping_name'] = $rekananshipping_name;
	$data['rekananshipping_address'] = $rekananshipping_address;
	$data['rekananshipping_contactname'] = $rekananshipping_contactname;
	$data['rekanan_name'] = $rekanan_name;
	$data['grouptenant_id'] = $grouptenant_id;
	$data['jurnal_id2'] = $jurnal_id2;
	$data['jurnal_descr2'] = $jurnal_descr2;
	$data['branch_name'] = $branch_name;
	$data['region_id'] = $region_id;

	// print_r($data);
	// exit;
	
		
		// $this->load->view('reminder/rptreminderTRP', $data);
		
		if ($reminder =='REMINDER 1') 
		{
			$html=$this->load->view('reminder/rptreminderTRP', $data, true);	
		}
		elseif ($reminder =='REMINDER 2') 
		{
			$html=$this->load->view('reminder/rptreminderTRP2', $data, true);	
		}
		elseif ($reminder =='REMINDER 3') 
		{
			$html=$this->load->view('reminder/rptreminderTRP3', $data, true);	
		}

     
       $this->load->library('m_pdf');
       $pdfFilePath = "rptoutstanding.pdf";	

		$this->m_pdf->pdf->SetHTMLHeader('<table width="100%"><tr><td align="right" style="font-size:10px"></td></tr></table>');
		$this->m_pdf->pdf->AddPage('P','A4','','','',20,20,5,20,15,10);
		 
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output($pdfFilePath, "I");
		

    }
	
}  