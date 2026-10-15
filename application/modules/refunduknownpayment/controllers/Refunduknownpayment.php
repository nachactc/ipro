<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Refunduknownpayment extends CI_Controller{
	
	//--------------settingan awal---------------//
    CONST module = 'Refund Uknown Payment';
    CONST tomboldialog = 'Pilih Refund';//nama tombol untuk memunculkan dialognya
    CONST defLink = 'refunduknownpayment';
    CONST defLinkAction = 'refunduknownpayment/refunduknownpayment';
    CONST defMethodAdd = 'savejurnal';
    CONST defMethodEdit = 'updatejurnal';
    CONST defJournalSource = 'RF-ListUkn';
    CONST defJournalType = 'RF';
    CONST defJournalFaktur = 'REFUND';
	//------------------------------------------//
	
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_jurnal');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
    }
    
    function index(){   
		$redirectAction = self::defLinkAction;
        redirect("$redirectAction/load");
    }
    
	function globalsearch_list(){
		$arcari=array('jurnal_id','jurnaltype_id','jurnal_source','periode_id','jurnal_createby');
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
					 $sWhere .=  $cariOptional <> '' ?  $cariOptional . " AND " : '' ;
					
				}
			}
		}
		 
		
		$top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
		$limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
		$limit=$limit+$top;

		$b =  $cariOptional <> '' ?   " WHERE ".$cariOptional  : '' ;        

		$sWhere = $sWhere.$b;
		
		$rResult=$this->model_jurnal->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_jurnal->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_jurnal->$qry_totalall();
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
	
	/** LIST JSON **/
    function controler_gridlist($val_search = ''){
		$arcari=$this->globalsearch_list(); 
		$searchStatus = $val_search;
		 
		$criteria = null; 
		
		if(!empty($_POST))
		{
			$jurnal_id = $this->input->post('jurnal_id');
			$jurnal_source = $this->input->post('jurnal_source');
			$jurnaltype_id = $this->input->post('jurnaltype_id');
			$periode_id = $this->input->post('periode_id');
			$jurnal_createby = $this->input->post('jurnal_createby');
			
			if($jurnal_id != '')
			{
				if($criteria == '')
				{
					$criteria = "  jurnal_id ='$jurnal_id' ";
				}
				else
				{
					$criteria = $criteria." AND jurnal_id ='$jurnal_id' ";
				}
			}
			if($jurnal_source != '')
			{
				if($criteria == '')
				{
					$criteria = " jurnal_source ='$jurnal_source' ";
				}
				else
				{
					$criteria = $criteria." AND jurnal_source ='$jurnal_source' ";
				}
			}
			if($jurnaltype_id != '')
			{
				if($criteria == '')
				{
					$criteria = " jurnaltype_id ='$jurnaltype_id' ";
				}
				else
				{
					$criteria = $criteria." AND jurnaltype_id ='$jurnaltype_id' ";
				}
			}  
			if($periode_id != '')
			{
				if($criteria == '')
				{
					$criteria = " periode_id ='$periode_id' ";
				}
				else
				{
					$criteria = $criteria." AND periode_id ='$periode_id' ";
				}
			}  
			if($jurnal_createby != '')
			{
				if($criteria == '')
				{
					$criteria = " jurnal_createby ='$jurnal_createby' ";
				}
				else
				{
					$criteria = $criteria." AND jurnal_createby ='$jurnal_createby' ";
				}
			}  
		}
		// echo $criteria;exit;
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
		// echo var_dump($vResult);
		// exit;
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];
 
    	foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['jurnal_id']);

            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
            $is_post = ($aRow['jurnal_isposted']) ? 1 : 0;
			$linkModule = self::defLinkAction;
			
            // $_menu='
                // <a href="'.site_url().'/'.$linkModule.'/edit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                // <i class="fa fa-edit fa-lg"></i></a>
				// &nbsp;
				// <a href="'.site_url().'/print_or/print_or/report_mall/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
                // <img border="0" src="'.base_url().'/assets/img/print.png" width="21" height="21"> </a>'; 
			 $_menu='
                <a href="/index.php/'.$linkModule.'/edit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                <i class="fa fa-edit fa-lg"></i></a>
				&nbsp;
				<a href="/index.php/print_or/print_or/report_mall/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
                <img border="0" src="/assets/img/print.png" width="21" height="21"> </a>';
			/** 
                <a href="/index.php/laprint5/laprint5/laprint5pdf/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank">
                <i class="fa fa-print fa-lg"></i></a>
                <a href="/index.php/jurnal/jurnal/jurnal_delete/'.$i_link.'" data-toggle="tooltip" title="Trash" onclick="return deleteid('.$is_post.')">
                <i class="fa fa-trash fa-lg"></i></a>
			**/

            $row = array(); 
			$row[]=$aRow['jurnal_id'];            
			$row[]=date("d-m-Y", strtotime($aRow['jurnal_bookdate']));
			$row[]=number_format($aRow['jurnal_amountidr'], 2);
			$row[]=$aRow['branch_name'];
			$row[]=$ship_name;
			$row[]=$aRow['jurnal_descr']; 
			$row[] = '<input type="checkbox" id="posted"'. ($aRow['jurnal_isposted'] == 1 ? 'checked= "checked"' : '').' disabled>';
			$row[]=$_menu; 
            if (!empty($row)) { $output['data'][] = $row; }
        	}   
        	echo json_encode($output);    		
    }

    function load(){
                 

        $data['source'] = $this->source_select();
		
		$module = self::module;
		
		$this->breadcrumbcomponent->add("$module");
		$template = self::defLink;
        $this->load->view('template/v_header');
        $this->load->view("$template/script");
        $this->load->view("$template/list", $data);
        $this->load->view('template/v_footer');
    }
    
    function add(){     
		$header = array();
		$detilD = array();
		$detilK = array();
		$detilRes= array();
		$detilRef= array();
		
		
		$chid=get_setting("channel_id"); 
        $data['region']     = $this->region_select();
        $data['source']     = self::defJournalSource;
        $data['jurnaltype']     = self::defJournalType;
        $data['struktur']   = $this->strukturnit_select();
        $data['account']    = $this->acc_select();
        $data['period']     = $this->periode_select();
        $data['channel']    = $chid;
		$data['branch']     = $this->branch_selectform();
		$data['acc_rows']   = $this->fillacc();
		$data['acc_penerimaan']   = $this->fillaccpenerimaan();
		$data['paymenttype']   = $this->fillpaymenttype(); 
		
		$mSave = self::defMethodAdd;
		$mLinkAct = self::defLinkAction;
		$data['method']     = "$mLinkAct/$mSave";
		$data['tombolDlgName'] = self::tomboldialog;
		$data['faktur'] = self::defJournalFaktur;
		$module = self::module;
		$linkdefinisi = self::defLink;
		 
  		$this->breadcrumbcomponent->add("List $module","$linkdefinisi/$linkdefinisi/load")
		->add("Form Add $module");
		   
		//header
        $data['result']     = $header;
		//detil D
		$data['resultD']     = $detilD;
		//detil K 
		$data['resultK']     = $detilK;
		//detil Respons
		$data['resultRes']     = $detilRes;
		//detil Reference
		$data['resultRef']     = $detilRef;
		
		$template = self::defLink;
		
        $this->load->view("template/v_header");
        $this->load->view("$template/script");
        $this->load->view("$template/css");
        $this->load->view("$template/add", $data);
        $this->load->view("template/v_footer");
	}
     
	function edit(){		
        
        $jurnal_id = $this->uri->segment(4);  
		$header = array();
		$detilD = array();
		$detilK = array();
		$detilRes= array();
		$detilRef= array();
		
		$data['resultK']     = array('');
        $data['region']     = $this->region_select();
        $data['source']     = $this->source_select();
        $data['struktur']   = $this->strukturnit_select();
        $data['account']    = $this->acc_select();
        $data['period']     = $this->periode_select();
        $data['channel']    = $this->session->userdata('channel_id');
		$data['branch']     = $this->branch_selectform();
		$data['acc_rows']   = $this->fillacc(); 
		
		$mUpdate = self::defMethodEdit; 
		$mLinkAct = self::defLinkAction;  
		$data['method']     = "$mLinkAct/$mUpdate/$jurnal_id";
		$data['tombolDlgName'] = self::tomboldialog;
		$module = self::module;
		$linkdefinisi = self::defLink;
		
  		$this->breadcrumbcomponent->add("List $module","$linkdefinisi/$linkdefinisi/load")
		->add("Form Edit $module");
		 
		//header jurnal load 
		$header = $this->model_jurnal->get_jurnal($jurnal_id);
		//detil D
		$dataD = $this->model_jurnal->get_jurnaldetilD($jurnal_id);
		if($dataD)
		{
			foreach($dataD as $rows)
			{
				$row = array();
				$row['jurnal_id'] =  $rows->jurnal_id; 
				$row['jurnaldetil_line'] =  $rows->jurnaldetil_line; 
				$row['jurnaldetil_descr'] =  $rows->jurnaldetil_descr; 
				$row['jurnaldetil_idr'] =  $rows->jurnaldetil_idr; 
				$row['jurnaldetil_dk'] =  $rows->jurnaldetil_dk; 
				$row['jurnaldetil_foreign'] =  $rows->jurnaldetil_foreign; 
				$row['jurnaldetil_foreignrate'] =  $rows->jurnaldetil_foreignrate; 
				$row['ref_id'] =  $rows->ref_id; 
				$row['ref_line'] =  $rows->ref_line; 
				$row['currency_id'] =  $rows->currency_id; 
				$row['acc_id'] =  $rows->acc_id; 
				$row['acc_name'] =  $rows->acc_name; 
				$row['channel_id'] =  $rows->channel_id; 
				$row['region_id'] =  $rows->region_id; 
				$row['branch_id'] =  $rows->branch_id; 
				$row['strukturunit_id'] =  $rows->strukturunit_id; 
				$row['rekanan_id'] =  $rows->rekanan_id; 
				$row['rekanan_name'] =  $rows->rekanan_name; 
				$row['sub1_id'] =  $rows->sub1_id; 
				$row['sub2_id'] =  $rows->sub2_id; 
				$row['rekananshipping_line'] =  $rows->rekananshipping_line; 
				$row['rekananshipping_name'] =  $rows->rekananshipping_name; 
				$row['rekananshipping_name'] =  $rows->rekananshipping_name; 
				$row['paymenttype_id'] =  $rows->paymenttype_id; 
				$row['paymenttype_name'] =  $rows->paymenttype_name; 
				$row['jurnalbilyet_bank'] =  $rows->jurnalbilyet_bank; 
				$row['jurnalbilyet_receiveperson'] =  $rows->jurnalbilyet_receiveperson; 
				$row['jurnalbilyet_date'] =  $rows->jurnalbilyet_date; 
				$row['jurnalbilyet_dateeffective'] =  $rows->jurnalbilyet_dateeffective; 
				$detilD[] = $row; 
			}
		}
		
		//detil K
		$dataK = $this->model_jurnal->get_jurnaldetilK($jurnal_id);
		if($dataK)
		{
			foreach($dataK as $rows)
			{
				$row = array();
				$row['jurnal_id'] =  $rows->jurnal_id; 
				$row['jurnaldetil_line'] =  $rows->jurnaldetil_line; 
				$row['jurnaldetil_descr'] =  $rows->jurnaldetil_descr; 
				$row['jurnaldetil_idr'] =  $rows->jurnaldetil_idr; 
				$row['jurnaldetil_dk'] =  $rows->jurnaldetil_dk; 
				$row['jurnaldetil_foreign'] =  $rows->jurnaldetil_foreign; 
				$row['jurnaldetil_foreignrate'] =  $rows->jurnaldetil_foreignrate; 
				$row['ref_id'] =  $rows->ref_id; 
				$row['ref_line'] =  $rows->ref_line; 
				$row['currency_id'] =  $rows->currency_id; 
				$row['acc_id'] =  $rows->acc_id; 
				$row['acc_name'] =  $rows->acc_name; 
				$row['channel_id'] =  $rows->channel_id; 
				$row['region_id'] =  $rows->region_id; 
				$row['branch_id'] =  $rows->branch_id; 
				$row['strukturunit_id'] =  $rows->strukturunit_id; 
				$row['rekanan_id'] =  $rows->rekanan_id; 
				$row['rekanan_name'] =  $rows->rekanan_name; 
				$row['sub1_id'] =  $rows->sub1_id; 
				$row['sub2_id'] =  $rows->sub2_id; 
				$row['rekananshipping_line'] =  $rows->rekananshipping_line; 
				$row['rekananshipping_name'] =  $rows->rekananshipping_name; 
				$detilK[] = $row; 
			}
		}
		// echo "<pre>";
		// echo var_dump($detilD);exit;
		
		//detil response
		$dataRes = $this->model_jurnal->get_jurnaldetilRes($jurnal_id);
		if($dataRes)
		{
			foreach($dataRes as $rows)
			{
				$row = array();
				$row['jurnal_id'] =  $rows->jurnal_id; 
				$row['jurnaldetil_line'] =  $rows->jurnaldetil_line; 
				$row['jurnaldetil_descr'] =  $rows->jurnaldetil_descr; 
				$row['jurnaldetil_idr'] =  $rows->jurnaldetil_idr; 
				$row['jurnaldetil_dk'] =  $rows->jurnaldetil_dk; 
				$row['jurnaldetil_foreign'] =  $rows->jurnaldetil_foreign; 
				$row['jurnaldetil_foreignrate'] =  $rows->jurnaldetil_foreignrate; 
				$row['ref_id'] =  $rows->ref_id; 
				$row['ref_line'] =  $rows->ref_line; 
				$row['currency_id'] =  $rows->currency_id; 
				$row['acc_id'] =  $rows->acc_id; 
				$row['acc_name'] =  $rows->acc_name; 
				$row['channel_id'] =  $rows->channel_id; 
				$row['region_id'] =  $rows->region_id; 
				$row['branch_id'] =  $rows->branch_id; 
				$row['strukturunit_id'] =  $rows->strukturunit_id; 
				$row['rekanan_id'] =  $rows->rekanan_id; 
				$row['rekanan_name'] =  $rows->rekanan_name; 
				$row['sub1_id'] =  $rows->sub1_id; 
				$row['sub2_id'] =  $rows->sub2_id; 
				$row['rekananshipping_line'] =  $rows->rekananshipping_line; 
				$row['rekananshipping_name'] =  $rows->rekananshipping_name; 
				$detilRes[] = $row; 
			}
		}
		
		//detil refrence
		$dataRef = $this->model_jurnal->get_jurnaldetilRef($jurnal_id);
		if($dataRef)
		{
			foreach($dataRef as $rows)
			{
				$row = array();
				$row['jurnal_id'] =  $rows->jurnal_id; 
				$row['jurnaldetil_line'] =  $rows->jurnaldetil_line; 
				$row['jurnaldetil_descr'] =  $rows->jurnaldetil_descr; 
				$row['jurnaldetil_idr'] =  $rows->jurnaldetil_idr; 
				$row['jurnaldetil_dk'] =  $rows->jurnaldetil_dk; 
				$row['jurnaldetil_foreign'] =  $rows->jurnaldetil_foreign; 
				$row['jurnaldetil_foreignrate'] =  $rows->jurnaldetil_foreignrate; 
				$row['ref_id'] =  $rows->ref_id; 
				$row['ref_line'] =  $rows->ref_line; 
				$row['currency_id'] =  $rows->currency_id; 
				$row['acc_id'] =  $rows->acc_id; 
				$row['acc_name'] =  $rows->acc_name; 
				$row['channel_id'] =  $rows->channel_id; 
				$row['region_id'] =  $rows->region_id; 
				$row['branch_id'] =  $rows->branch_id; 
				$row['strukturunit_id'] =  $rows->strukturunit_id; 
				$row['rekanan_id'] =  $rows->rekanan_id; 
				$row['rekanan_name'] =  $rows->rekanan_name; 
				$row['sub1_id'] =  $rows->sub1_id; 
				$row['sub2_id'] =  $rows->sub2_id; 
				$row['rekananshipping_line'] =  $rows->rekananshipping_line; 
				$row['rekananshipping_name'] =  $rows->rekananshipping_name; 
				$detilRef[] = $row; 
			}
		}
		
		//header
        $data['result']     = $header;
		//detil D
		$data['resultD']     = $detilD;
		//detil K 
		$data['resultK']     = $detilK;
		//detil Respons
		$data['resultRes']     = $detilRes;
		//detil Reference
		$data['resultRef']     = $detilRef;
		 
		// $num = '00000000834167a4ASC'; 
		// $num = intval($num);  
		// if(is_int($num) and $num > 0)
		// {
			// echo str_pad($num, 16, "0", STR_PAD_LEFT); ;
		// }
		// else
		// {
			// echo "fail";
		// } 
		// exit;
		$template = self::defLink;
        $this->load->view("template/v_header");
        $this->load->view("$template/script");
        $this->load->view("$template/css");
        $this->load->view("$template/add", $data);
        $this->load->view("template/v_footer");
	}    
     
	function savejurnal(){
		$RedirectAction = self::defLinkAction;
		$saveData = $this->model_jurnal->save_jurnal();
		if($saveData)
		{
			redirect("$RedirectAction/load");
		} 
	}

	function updatejurnal(){ 
		$jurnal_id = $this->uri->segment(4);
		$RedirectAction = self::defLinkAction;
		if(!empty($jurnal_id)){ 
			if(!empty($_POST)){ 
				$updateData = $this->model_jurnal->update_jurnal(); 
				if($updateData)
				{
					redirect("$RedirectAction/edit/".$updateData);
				} 
			}
		}
		else
		{
			redirect("$RedirectAction/edit/".$jurnal_id);
		} 
	}
 
	
	/*dialog*/
	
	function isigriddetildebet()
	{
		$i=0;  
		
		//debet
		 $result=$this->model_jurnal->qry_isigriddetildebet();
		 $noline=10;
		 $jml=0;
		 $html='';
		 if (!empty($result)){
			$jml=(count($result));
			 // echo var_dump($result);exit;
			foreach ($result as $rows){ 
				if($rows->jurnaldetil_idr > 0)
				{
					$html .= "<tr>";	
					$html .= "<td><input type='checkbox' id='chk' name='pp[]' class='chkDebet' /></td>";	
					$html .= "<td>".$rows->jurnal_id."</td>";	
					$html .= "<td style='text-align:center;'>".$rows->jurnaldetil_line."</td>";	 	
					$html .= "<td>".$rows->jurnaldetil_descr."</td>";	
					$html .= "<td>".$rows->acc_id.'-'.$rows->acc_name."</td>";
					$html .= "<td><input type='text' value='".$rows->jurnaldetil_idr."' name='dlgD_sisa_idr[]' class='sisa_idr form-control'  /> </td>";	
					$html .= "<td>".number_format(($rows->sisa_idr),2)."</td>";	 
					$html .= "<td>".date('Y-m-d',strtotime($rows->jurnal_bookdate))."</td>";	
					$html .= "<td>".date('Y-m-d',strtotime($rows->jurnal_duedate))."</td>";	
					$html .= "<td>".$rows->rekanan_name."</td>";	
					$html .= "<td>".$rows->rekananshipping_name.
							"<input type='hidden' value='".$rows->jurnal_id."' id='".$rows->jurnal_id."' name='dlgD_jurnal_id[]' class='dlgD_jurnal_id'/>
							<input type='hidden' value='".$rows->jurnaldetil_line."' id='dlgD_jurnaldetil_line_".$noline."' name='dlgD_jurnaldetil_line[]' class='dlgD_jurnaldetil_line'/>
							<input type='hidden' value='".$rows->jurnaldetil_descr."' name='dlgD_jurnal_descr[]' class='dlgD_jurnal_descr' /> 
							<input type='hidden' value='".$rows->acc_id."' name='dlgD_acc_id[]' class='dlgD_acc_id' />  
							<input type='hidden' value='".$rows->acc_name."' name='dlgD_acc_name[]' class='dlgD_acc_name' />  
							<input type='hidden' value='".$rows->jurnaldetil_idr."' name='dlgD_jurnaldetil_idr[]' class='dlgD_jurnaldetil_idr' /> 
							<input type='hidden' value='".$rows->rekanan_id."' name='dlgD_rekanan_id[]' class='dlgD_rekanan_id' /> 
							<input type='hidden' value='".$rows->rekanan_name."' name='dlgD_rekanan_name[]' class='dlgD_rekanan_name' /> 
							<input type='hidden' value='".$rows->rekananshipping_name."' name='dlgD_rekananshipping_name[]' class='dlgD_rekananshipping_name' />  
							<input type='hidden' value='".$rows->rekananshipping_line."' name='dlgD_rekananshipping_line[]' class='dlgD_rekananshipping_line' />  
							<input type='hidden' value='".$rows->doc_type."' name='dlgD_sub1_id[]' class='dlgD_sub1_id' />  
							<input type='hidden' value='".$rows->contract_no."' name='dlgD_sub2_id[]' class='dlgD_sub2_id' />  
							<input type='hidden' value='".$rows->region_id."' name='dlgD_region_id[]' class='dlgD_region_id' />  
							<input type='hidden' value='".$rows->branch_id."' name='dlgD_region_id[]' class='dlgD_branch_id' />  
							<input type='hidden' value='".$rows->strukturunit_id."' name='dlgD_region_id[]' class='dlgD_strukturunit_id' />  
							</td>";	  
					$html .= "</tr>"; 
					$noline=$noline+10;
				} 
			}  
			echo $html; 
		 }
		 else{ 
			echo "<tr> 
						<td> &nbsp; </td> 
						<td> Data Not Found !  </td> <td> &nbsp; </td>
						<td> &nbsp; </td> <td> &nbsp; </td><td> &nbsp; </td> <td> &nbsp; </td>
						<td> &nbsp; </td> <td> &nbsp; </td><td> &nbsp; </td> <td> &nbsp; </td>  
				</tr>";
		 }
	}
	
	function isigriddetilkredit()
	{
		$i=0; 
		$html = "";
		
		//debet
		 $result=$this->model_jurnal->qry_isigriddetilkredit();
		  
		 $noline=5;
		 $jml=0;
		 if (!empty($result)){
			$jml=(count($result));
			$html .= "<tbody id='datgridDlgK' >";
			foreach ($result as $rows){  
			$html .= "<tr>";
			$html .= "<td><input type='checkbox' id='chkKredit_".$noline."' name='pp[]' class='chkKredit' /> </td>";		
			$html .= "<td>".$rows->jurnal_faktur."</td>";	
			$html .= "<td>".$rows->jurnaldetil_descr."</td>";	
			$html .= "<td>".$rows->acc_id.'-'.$rows->acc_name."</td>";	
			$html .= "<td><input type='text' value='".($rows->jurnaldetil_idr-$rows->jurnaldetil_receive)."' name='dlgK_sisa_idr' class='dlgK_sisa_idr form-control' /> </td>"; 
			$html .= "<td>".number_format($rows->jurnaldetil_idr,2)."</td>";	
			$html .= "<td>".date('Y-m-d',strtotime($rows->jurnal_bookdate))."</td>";	
			$html .= "<td>".date('Y-m-d',strtotime($rows->jurnal_duedate))."</td>";	
			$html .= "<td>".$rows->rekanan_name."</td>";	
			$html .= "<td>".$rows->faktur_id.
					"<input type='hidden' value='".$rows->jurnal_id."' id='".$rows->jurnal_id."' name='dlgK_jurnal_id[]' class='dlgK_jurnal_id'/>
					<input type='hidden' value='".$rows->jurnaldetil_line."' id='dlgK_jurnaldetil_line_".$noline."' name='dlgK_jurnaldetil_line[]' class='dlgK_jurnaldetil_line'/>
					<input type='hidden' value='".$rows->jurnaldetil_descr."' name='dlgK_jurnal_descr[]' class='dlgK_jurnal_descr' /> 
					<input type='hidden' value='".$rows->acc_id."' name='dlgK_acc_id[]' class='dlgK_acc_id' />  
					<input type='hidden' value='".$rows->acc_name."' name='dlgK_acc_name[]' class='dlgK_acc_name' />  
					<input type='hidden' value='".$rows->jurnaldetil_idr."' name='dlgK_jurnaldetil_idr[]' class='dlgK_jurnaldetil_idr' /> 
					<input type='hidden' value='".$rows->rekanan_id."' name='dlgK_rekanan_id[]' class='dlgK_rekanan_id' /> 
					<input type='hidden' value='".$rows->rekanan_name."' name='dlgK_rekanan_name[]' class='dlgK_rekanan_name' />  
					<input type='hidden' value='".$rows->rekananshipping_line."' name='dlgK_rekananshipping_line[]' class='dlgK_rekananshipping_line' />  
					<input type='hidden' value='".$rows->sub1_id."' name='dlgK_sub1_id[]' class='dlgK_sub1_id' />  
					<input type='hidden' value='".$rows->sub2_id."' name='dlgK_sub2_id[]' class='dlgK_sub2_id' />  
					<input type='hidden' value='".$rows->region_id."' name='dlgK_region_id[]' class='dlgK_region_id' />  
					<input type='hidden' value='".$rows->branch_id."' name='dlgK_region_id[]' class='dlgK_branch_id' />  
					<input type='hidden' value='".$rows->strukturunit_id."' name='dlgK_region_id[]' class='dlgK_strukturunit_id' />  
					</td>";	 
			$html .= "<td>".$rows->jurnal_id."</td>";	
			$html .= "<td>".$rows->jurnaldetil_line."</td>";
			
			$html .= "</tr>"; 
			$noline=$noline+10;
			} 
			$html .= "</tbody>"; 
			echo $html;
		 }
		 else{  
			$html .= 'Data Not Found !';   
			echo $html; 
		 }
	}
	
	/*end dialog*/
	
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
         
        $account = $this->model_jurnal->get_acc();              
        
        if(count($account)){
            foreach($account as $key => $value){
                $options[$value->acc_id]= $value->acc_id."-".$value->acc_name;
            }
        }
                    
        return $options;
    }

	function branch_selectform(){
         
        $account = $this->model_jurnal->get_branch();              
        $options    = array('' => 'Select an option');  
        if(count($account)){
            foreach($account as $key => $value){
                $options[$value->branch_id]= $value->branch_name;
            }
        }
                    
        return $options;
    }	

    function periode_select(){
         
        $periode = $this->model_jurnal->get_periode();              
        
        if(count($periode)){
            foreach($periode as $key => $value){
                $options[$value->periode_id]= $value->periode_name;
            }
        }
                    
        return $options;
    }   
	
	function periode_selectall(){
         
        $periode = $this->model_jurnal->get_periodeall();              
        
        if(count($periode)){
            foreach($periode as $key => $value){
                $options[$value->periode_id]= $value->periode_name;
            }
        }
                    
        return $options;
    } 

	function strukturnit_select(){ 
        $username = $this->session->userdata('username');
		
        $strukturunit = $this->model_jurnal->get_strukturunit($username);  
		if(count($strukturunit) > 1)
		{
			$options    = array('' => 'Pilih');
		} 
        if(count($strukturunit)){
            foreach($strukturunit as $key => $value){
                $options[$value->strukturunit_id]= $value->strukturunit_name;
            }
        }
                    
        return $options;
    }
    
    function source_select() {
        $source = $this->model_jurnal->get_journalsource();
		$options    = array('' => 'Pilih');   
        if(count($source)){
            foreach($source as $key => $value){
                $options[$value->jurnalsource_id]= $value->jurnalsource_name;
            }
        }
                    
        return $options;
    }   

    function fillacc(){

		$payment= $this->model_jurnal->get_acc();
		$options    = array('' => 'Pilih');                

		if(count($payment)){
			foreach($payment as $key => $value){
				$options[$value->acc_id]= $value->acc_name;
			}
		}
					
		return $options;
	}
	
    function fillaccpenerimaan(){

		$payment= $this->model_jurnal->get_accpenerimaan();
		$options    = array('' => 'Pilih');                

		if(count($payment)){
			foreach($payment as $key => $value){
				$options[$value->acc_id]= $value->acc_name;
			}
		}
					
		return $options;
	}
	
    function fillpaymenttype(){

		$payment= $this->model_jurnal->get_paymenttype();
		$options    = array('' => 'Pilih');                

		if(count($payment)){
			foreach($payment as $key => $value){
				$options[$value->paymenttype_id]= $value->paymenttype_name;
			}
		}
					
		return $options;
	}
	
	function gettenant(){     
			 
		$criteria = empty($_GET['q']) ? ' ' : $_GET['q'];
		$id = empty($_GET['id']) ? ' ' : $_GET['id']; 
		$response = $this->model_jurnal->get_tenantdata($criteria,$id);
		$json = array();
			foreach($response as $rows){
				$json[] = array('id' => trim(strtoupper($rows->rekanan_id)), 'text'=> strtoupper($rows->rekanan_name).",".strtoupper($rows->rekanan_badanhukum));
			}
			echo json_encode($json);	
	}
	
	function gettrade(){
		$criteria = empty($_POST['q']) ? ' ' : $_POST['q'];
		$rekanan_id = empty($_POST['tenant']) ? '' : $_POST['tenant'];
		 
		$response = $this->model_jurnal->get_tradedata($criteria,$rekanan_id );
		$json = array();
			foreach($response as $rows){
				$kode=$rows->rekanan_id.$rows->rekananshipping_line;
				$json[] = array(
						'id' => $kode, 
						'text'=> trim(strtoupper($rows->rekananshipping_name)).' '.$rows->rowid.' '.$rows->branch_name,
						'id_rekananship_line' => $rows->rekananshipping_line,
						'branch_id' => $rows->branch_id,
						'region_id' => $rows->region_id,
						'branch_name' => $rows->branch_name,
						'region_name' => $rows->region_name,
						'sub1_id' => $rows->rowid
						);
			}
			echo json_encode($json);
	}
	
	function getaccselect2(){
		$criteria = empty($_POST['q']) ? ' ' : $_POST['q']; 
		 
		$response = $this->model_jurnal->get_acc_select2($criteria );
		$json = array();
			foreach($response as $rows){ 
				$json[] = array('id' => $rows->acc_id, 'text'=> trim(strtoupper($rows->acc_nameuid)));
			}
			echo json_encode($json);
	}
    
}  