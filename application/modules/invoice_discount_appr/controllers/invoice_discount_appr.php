<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice_discount_appr extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_invoice_discount');
	    $this->load->library('breadcrumbcomponent');
    } 
	 
	public function dialog_invoice_discount_appr($search=''){
		$search = urldecode($search);
		
		$row = array(); 
		$output=array(); 
		$dataDlg =array(); 
		$dataDlgR = array(); 
		
		if ($search != '')
		{
			$dataDlg = $this->model_invoice_discount->get_data_dialog_invoice_discount_appr($search);
			$dataDlgR = $this->model_invoice_discount->get_data_dialog_invoice_discount_appr_rows($search);
			
		 
			foreach ($dataDlg as $aRow) 
			{ 
				$row[0]="";
				$row[1]=$aRow['branch_name'];
				$row[2]=$aRow['rekanan_name']; 
				$row[3]=$aRow['rekananshipping_name']; 
				$row[4]=$aRow['invoice_id']; 
				$row[5]=$aRow['schedulepayment_id'];
				$row[6]=$aRow['schedulepaymentdetil_line'];
				$row[7]=$aRow['schedulepaymentdetil_isposted'];
				$row[8]=$aRow['agreementtype_id'];
				$row[9]=$aRow['schedulepaymentdetil_idr'];
				
				
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
				$row[6]='';
				$row[7]='';
				$row[8]='';
				$row[9]='';
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
				$row[6]='';
				$row[7]='';
				$row[8]='';
				$row[9]='';
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
	
	function invoice_discount_appr_add(){		
        
        $loo_id = $this->uri->segment(4);        
        
        $data   = array(
                  'result'    => $this->model_invoice_discount->viewloo($loo_id),
                  'loo_id'   => $loo_id
            );        
        
        $data['region']  = $this->region_select();
		$data['branch_dlg'] = $this->branch_select_dialog();
        $data['lotype'] = $this->lootype_select();
        $data['agrtype'] = $this->agrtype_select();
        $data['titype'] = $this->titype_select();
        $data['unittype']   = $this->unittype_select();
		//$data['dialog_invoice_discount_appr'] = $this->load->view('invoice_discount_appr/dialog_invoice_discount_appr');

  		$this->breadcrumbcomponent->add('Invoice Discount','invoice_discount_appr/invoice_discount_appr')
            ->add('Input Invoice Discount','loo_cl/loo_cl/looadd');


        $this->load->view('template/v_header');
		$this->load->view('invoice_discount_appr/dialog_invoice_discount_appr');
        $this->load->view('invoice_discount_appr/invoice_discount_appr_add', $data);
        $this->load->view('template/v_footer');
	}
	
    function index(){       
        redirect('invoice_discount_appr/invoice_discount_appr/invoice_discount_appr_status');
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
		$arcari=array('rekanan_name','rekananshipping_name', 'branch_name','a.schedulepayment_id','a.invoice_id');
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
      $rResult=$this->model_invoice_discount_cl->dataapp_list($region_id,$branch_id,$unit_id,$lantai_id); 
       
	  echo json_encode($rResult);
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
					 $sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;
					
				}
			}
		}
		 		
		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
		$limit=$limit+$top;

		//$b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ; 
		//$sWhere = $sWhere.$b;
        if ( $cariOptional <> '' ) {            
            $sWhere = $sWhere <> '' ? $sWhere." AND ".$cariOptional : " WHERE ".$cariOptional;
        }        
		
		$rResult=$this->model_invoice_discount->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_invoice_discount->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_invoice_discount->$qry_totalall();
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
 
    /**
	* untuk approval
	**/
	function invoice_discount_appr_statusedit(){		
        
        $i_link = $this->uri->segment(4);    
		
		$username = $this->session->userdata('username');
		// $username = 'ritha.batupare'; 
		// $username = 'linda.tampi'; 
		
        $spid = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_invoice_discount->viewdiscount($spid),
                  'spid'   => $spid,
				  'userauth_approve' => $this->model_invoice_discount->userauth_approve($username),
				  'userauth_done_approve' => $this->model_invoice_discount->userauth_done_approve($username,$spid),
            );                
	 
		 
		
		$this->breadcrumbcomponent->add('Invoice Discount','invoice_discount_appr/invoice_discount_appr/invoice_discount_appr_statusedit')
            ->add('View Invoice Discount','invoice_discount_appr_statusedit');        

        $this->load->view('template/v_header');
        $this->load->view('invoice_discount_appr/invoice_discount_edit', $data);
        $this->load->view('template/v_footer');
	}
	function approval_discount(){
		$schedulepayment_id = $this->input->post('txtspid');
		$schedulepaymentdetil_line = $this->input->post('txtspln');
		
		$username = $this->session->userdata('username');
		// $username = 'ritha.batupare'; 
		// $username = 'linda.tampi';
		
		$approval = $this->model_invoice_discount->discount_approve($schedulepayment_id,$schedulepaymentdetil_line,$username);

		var_dump($approval);

		$msg = "";  
		if(substr($approval,0,1) != '2'){
			$msg .= "
				<script>
				alert('Data Sudah Di Approve'); 
				window.location.href = '".base_url('index.php/invoice_discount_appr/invoice_discount_appr/invoice_discount_appr_status')."';
				</script>
				";
		}
		else
		{ 
			$approval = str_replace('2 [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]','',$approval);
			$approval = str_replace("'",'',$approval);   
			$msg .= "
				<script>
				alert('Data Gagal Di Approve,".$approval."'); 
				window.location.href = '".base_url('index.php/invoice_discount_appr/invoice_discount_appr/invoice_discount_appr_status')."';
				</script>
				";
		}
		  
		echo $msg;exit;  
		
	}
    function controler_gridlist(){

        $f_date =  isset($_POST['f_date']) ? $_POST['f_date']: '' ;
        $t_date =  isset($_POST['t_date']) ? $_POST['t_date']: '';

        $fromSearch = $f_date <> '' ? "loi_processdate >= '$f_date' " : '';

        $optSearch = $fromSearch;

        if ($t_date <> ''){
            $searchCriteria = $t_date <> '' ? "loi_processdate <= '$t_date' " : '';
            $optSearch =  $optSearch <> '' ?   $optSearch." AND ".$searchCriteria : $searchCriteria ;
        }        

        $arcari=$this->globalsearch_list();
        $vResult=$this->initialize_grid("get_listdatadiscount_approval","get_listdatadiscount_approval_filteredlist","get_listdatadiscount_approval_totalalllist",$arcari, $optSearch);
        $rResult=$vResult['rResult'];
        $output=$vResult['output']; 
		
		if($rResult) {
			foreach ($rResult as $aRow) {

				$i_link = $aRow['schedulepayment_id'].$aRow['schedulepaymentdiscount_line']; 
				$ship_name = substr($aRow['rekanan_name'], 0, 35) . '...'; 
				$brand_name = substr($aRow['rekananshipping_name'], 0, 55) . '...';
				$status = $this->status_discount($aRow['schedulepayment_id'],$aRow['schedulepaymentdiscount_line']);
				
				$row[0]=$status;
				$row[1]=$ship_name;
				$row[2]=$brand_name;
				$row[3]=$i_link;
				$row[4]=$aRow['invoice_id'];
				$row[5]=number_format($aRow['schedulepaymentdetil_amount']);
				$row[6]=intval($aRow['schedulepaymentdiscount_percent']).'%';
				$row[7]=number_format($aRow['schedulepaymentdiscount_idr']);
				$row[8]='<input type="checkbox" id="posted"'. ($aRow['schedulepaymentdiscount_isposted'] == 1 ? 'checked= "checked"' : '').' disabled>'; 
				$row[9]='<a href="/index.php/invoice_discount_appr/invoice_discount_appr/invoice_discount_appr_statusedit/'.$i_link.'" data-toggle="tooltip" title="View"><i class="fa fa-edit fa-lg"></i></a> ';
			
				if (!empty($row)) { $output['data'][] = $row; }
			}   
        }
        echo json_encode($output); 
    }
	function invoice_discount_appr_status(){
        		
		$this->breadcrumbcomponent->add('Invoice Discount','invoice_discount_appr/invoice_discount_appr/invoice_discount_appr_status');

        $this->load->view('template/v_header');
        $this->load->view('invoice_discount_appr/invoice_discountlist');
        $this->load->view('template/v_footer');
    }

	/**
	* untuk unapproval
	**/
	function invoice_discount_unappr_statusedit(){		
        
        $i_link = $this->uri->segment(4);    
		
		$username = $this->session->userdata('username');
		// $username = 'ritha.batupare'; 
		// $username = 'linda.tampi';
		
        $spid = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_invoice_discount->viewdiscount($spid),
                  'spid'   => $spid,
				  'userauth_approve' => $this->model_invoice_discount->userauth_approve($username),
				  'userauth_done_unapprove' => $this->model_invoice_discount->userauth_done_unapprove($username,$spid),
            );                
	 
		 
		
		$this->breadcrumbcomponent->add('Invoice Discount','invoice_discount_appr/invoice_discount_appr/invoice_discount_appr_statusedit')
            ->add('View Invoice Discount','invoice_discount_appr_statusedit');        

        $this->load->view('template/v_header');
        $this->load->view('invoice_discount_appr/invoice_discount_edit_unappr', $data);
        $this->load->view('template/v_footer');
	}
	function unapproval_discount(){
		$schedulepayment_id = $this->input->post('txtspid');
		$schedulepaymentdetil_line = $this->input->post('txtspln');
		
		$username = $this->session->userdata('username');
		// $username = 'ritha.batupare'; 
		// $username = 'linda.tampi'; 
		
		$approval = $this->model_invoice_discount->discount_unapprove($schedulepayment_id,$schedulepaymentdetil_line,$username);
		
		$msg = ""; 
		
		if(substr($approval,0,1) != '2'){
			$msg .= "
				<script>
				alert('Data Sudah Di UnApprove'); 
				window.location.href = '".base_url('index.php/invoice_discount_appr/invoice_discount_appr/invoice_discount_unappr_status')."';
				</script>
				";
		}
		else 
		{ 
			$approval = str_replace('2 [Microsoft][ODBC Driver 17 for SQL Server][SQL Server]','',$approval); 
			$approval = str_replace("'",'',$approval);  
			$msg .= "<script>
				alert('Data Gagal Di UnApprove,".$approval."'); 
				window.location.href = '".base_url('index.php/invoice_discount_appr/invoice_discount_appr/invoice_discount_unappr_status')."';
				</script>
				";
					
		}
		  
		echo ($msg); exit;
		
	}
    function controler_gridlist_unappr(){

        $f_date =  isset($_POST['f_date']) ? $_POST['f_date']: '' ;
        $t_date =  isset($_POST['t_date']) ? $_POST['t_date']: '';

        $fromSearch = $f_date <> '' ? "loi_processdate >= '$f_date' " : '';

        $optSearch = $fromSearch;

        if ($t_date <> ''){
            $searchCriteria = $t_date <> '' ? "loi_processdate <= '$t_date' " : '';
            $optSearch =  $optSearch <> '' ?   $optSearch." AND ".$searchCriteria : $searchCriteria ;
        }        

        $arcari=$this->globalsearch_list();
        $vResult=$this->initialize_grid("get_listdatadiscount_unapproval","get_listdatadiscount_unapproval_filteredlist","get_listdatadiscount_unapproval_totalalllist",$arcari, $optSearch);
        $rResult=$vResult['rResult'];
        $output=$vResult['output']; 
		
		if($rResult) {
			foreach ($rResult as $aRow) {

				$i_link = $aRow['schedulepayment_id'].$aRow['schedulepaymentdiscount_line']; 
				$ship_name = substr($aRow['rekanan_name'], 0, 35) . '...'; 
				$brand_name = substr($aRow['rekananshipping_name'], 0, 55) . '...';
				$status = $this->status_discount($aRow['schedulepayment_id'],$aRow['schedulepaymentdiscount_line']);
				
				$row[0]=$status;
				$row[1]=$ship_name;
				$row[2]=$brand_name;
				$row[3]=$i_link;
				$row[4]=$aRow['invoice_id'];
				$row[5]= number_format($aRow['schedulepaymentdetil_amount']);
				$row[6]=intval($aRow['schedulepaymentdiscount_percent']).'%';
				$row[7]=number_format($aRow['schedulepaymentdiscount_idr']);
				$row[8]='<input type="checkbox" id="posted"'. ($aRow['schedulepaymentdiscount_isposted'] == 1 ? 'checked= "checked"' : '').' disabled>'; 
				$row[9]='<a href="/index.php/invoice_discount_appr/invoice_discount_appr/invoice_discount_unappr_statusedit/'.$i_link.'" data-toggle="tooltip" title="View"><i class="fa fa-edit fa-lg"></i></a> ';
			
				if (!empty($row)) { $output['data'][] = $row; }
			}   
        }
        echo json_encode($output); 
    }
	function invoice_discount_unappr_status(){
        		
		$this->breadcrumbcomponent->add('Invoice Discount','invoice_discount_appr/invoice_discount_appr/invoice_discount_unappr_status');

        $this->load->view('template/v_header');
        $this->load->view('invoice_discount_appr/invoice_discountlist_unappr');
        $this->load->view('template/v_footer');
    } 

    /**
	* untuk status discount
	**/
	function status_discount($schedulepayment_id,$schedulepaymentdiscount_line){
        $tsq = "";
        $rsult = $this->model_invoice_discount->status_approval($schedulepayment_id,$schedulepaymentdiscount_line);
		
		if(COUNT($rsult) <= 0)
		{
			$tsq = "<b><font color='red'> NOT VERIFIED  </b>";
		}
		else
		{
			foreach ($rsult as $aRow)
			{
				$nm = "<b>" . $aRow->strukturunitapprovalauth_name . "</b>";
				if (strpos($aRow->verification,'VERIFIED ')  !== false )
				{
					$veri = "<b><i class='fa fa-check fa-lg'></i><font color='#00CC00'>" . $aRow->verification . "</font></b>";
				}
				else
				{
					$veri = "<b><i class='fa fa-square-o fa-lg'></i><font color='red'>" . $aRow->verification . "</font></b>";
				}
				$tsq = $tsq . "" . $nm . " :" . $veri . "&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		}
        
        return $tsq; 
    }
	
}  