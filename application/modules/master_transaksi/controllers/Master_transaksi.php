<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_transaksi extends CI_Controller{
	
	//--------------settingan awal---------------//
    CONST module = 'Master Transaksi';
    CONST tomboldialog = 'Pilih Invoice';//nama tombol untuk memunculkan dialognya
    CONST defLink = 'master_transaksi';
    CONST defLinkAction = 'master_transaksi/master_transaksi';
    CONST defMethodAdd = 'savetrx';
    CONST defMethodEdit = 'updatetrx';
    CONST defJournalSource = '';
    CONST defJournalType = '';
	//------------------------------------------//
	
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_transaksi');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
    }
    
    function index(){   
		$redirectAction = self::defLinkAction; 
        redirect("$redirectAction/load");
    }
    
	function globalsearch_list(){
		$arcari=array('transaksi_id','transaksi_name','transaksi_descr','iteminventorytype_id');
		return $arcari;
	}
	
	function initialize_grid($qry_alldata,$qry_filtered,$qry_totalall,$arcari,$cariOptional = '',$jurnalsource_id,$jurnaltype_id){
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
		
		$rResult=$this->model_transaksi->$qry_alldata($limit,$top,$sWhere,$jurnalsource_id,$jurnaltype_id);
			
		$rResultCnt =$this->model_transaksi->$qry_filtered($sWhere,$jurnalsource_id,$jurnaltype_id);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_transaksi->$qry_totalall($jurnalsource_id,$jurnaltype_id);
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
			$transaksi_id = $this->input->post('sID'); 
			
			if($transaksi_id != '')
			{
				if($criteria == '')
				{
					$criteria = "  transaksi_id ='$transaksi_id' ";
				}
				else
				{
					$criteria = $criteria." AND transaksi_id ='$transaksi_id' ";
				}
			} 
		}
		// echo $criteria;exit;
		$jurnalsource = self::defJournalSource;
		$jurnaltype = self::defJournalType;
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria,$jurnalsource,$jurnaltype);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];
 
    	foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['transaksi_id']);

             
			$linkModule = self::defLinkAction;
			  
            $_menu='
                <a href="/index.php/'.$linkModule.'/edit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                <i class="fa fa-edit fa-lg"></i></a> '; 
			 
			  
            $row = array(); 
			$row[]=$aRow['transaksi_id'];            
			$row[]=$aRow['transaksi_name'];            
			$row[]=$aRow['transaksi_descr'];            
			$row[]=$aRow['iteminventorytype_id'];            
			$row[]=$aRow['transaksi_createby'];
			$row[]=date("d-m-Y", strtotime($aRow['transaksi_createdate']));
			$row[]=$aRow['transaksi_modifyby'];
			$row[]=date("d-m-Y", strtotime($aRow['transaksi_modifydate'])); 
			$row[] = '<input type="checkbox" id="posted"'. ($aRow['transaksi_isdisabled'] == 1 ? 'checked= "checked"' : '').' disabled>';
			$row[]=$_menu; 
            if (!empty($row)) { $output['data'][] = $row; }
        }   
        	echo json_encode($output);    		
    }

    function load(){ 
		
 
		
		$module = self::module;
		
		$this->breadcrumbcomponent->add("$module");
		$template = self::defLink;
        $this->load->view('template/v_header');
        $this->load->view("$template/script");
        $this->load->view("$template/list");
        $this->load->view('template/v_footer');
    }
    
    function add(){     
		$header = array();
		$detilD = $this->model_transaksi->get_jurnaldetilD('');
		$detilK = $this->model_transaksi->get_jurnaldetilK('');
		$detilRes= array();
		$detilRef= array();
		
		
		$chid=get_setting("channel_id");   
        $data['acc']     = $this->acc_select(); 
        $data['itemid_select']     = $this->itemid_select(); 
		
		$mSave = self::defMethodAdd;
		$mLinkAct = self::defLinkAction;
		$data['method']     = "$mLinkAct/$mSave";
		$data['tombolDlgName'] = self::tomboldialog;
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
		 
		
		$template = self::defLink;
		
        $this->load->view("template/v_header");
        $this->load->view("$template/script");
        $this->load->view("$template/css");
        $this->load->view("$template/add", $data);
        $this->load->view("template/v_footer");
	}
     
	function edit(){		
        
        $transaksi_id =  $this->uri->segment(4);  
		$header = array();
		$detilD = array();
		$detilK = array();
		$detilRes= array();
		$detilRef= array();
		
		$data['acc']     = $this->acc_select(); 
		$data['itemid_select']     = $this->itemid_select(); 
		
		$mUpdate = self::defMethodEdit; 
		$mLinkAct = self::defLinkAction;  
		$data['method']     = "$mLinkAct/$mUpdate/$transaksi_id";
		$data['tombolDlgName'] = self::tomboldialog;
		$module = self::module;
		$linkdefinisi = self::defLink;
		
  		$this->breadcrumbcomponent->add("List $module","$linkdefinisi/$linkdefinisi/load")
		->add("Form Edit $module");
		 
		//header jurnal load 
		$header = $this->model_transaksi->get_trx($transaksi_id);
		//detil D
		$dataD = $this->model_transaksi->get_jurnaldetilD($transaksi_id);
		$dataK = $this->model_transaksi->get_jurnaldetilK($transaksi_id);
		 
		
		//header
        $data['result']     = $header;
		//detil D
		$data['resultD']     = $dataD;
		//detil K 
		$data['resultK']     = $dataK; 
		
		$template = self::defLink;
        $this->load->view("template/v_header");
        $this->load->view("$template/script");
        $this->load->view("$template/css");
        $this->load->view("$template/add", $data);
        $this->load->view("template/v_footer");
	}    
     
	function savetrx(){
		$RedirectAction = self::defLinkAction;
		$saveData = $this->model_transaksi->save_trx();
		if($saveData)
		{
			redirect("$RedirectAction/load");
		} 
	}

	function updatetrx(){ 
		$transaksi_id = $this->uri->segment(4);
		$RedirectAction = self::defLinkAction;
		if(!empty($transaksi_id)){ 
			if(!empty($_POST)){ 
				$updateData = $this->model_transaksi->update_trx();
				// echo var_dump($updateData);exit;
				if($updateData)
				{
					redirect("$RedirectAction/edit/".$transaksi_id);
				} 
			}
		}
		else
		{
			redirect("$RedirectAction/edit/".$transaksi_id);
		} 
	}
	
	/** start function delete jurnal **/
	
	function trx_delete(){
		$transaksi_id = $this->input->post('transaksi_id');
		 
		if (!empty(transaksi_id)){
		
			$header = "DELETE FROM master_transaksi WHERE transaksi_id = '$transaksi_id' ";
			$receive = "DELETE FROM master_transaksipospayment WHERE transaksi_id = '$transaksi_id' ";
			$agr = "DELETE FROM master_transaksiagreementtype WHERE transaksi_id = '$transaksi_id' ";
			$this->db->query($header); 		
			$this->db->query($receive); 		
			$this->db->query($agr); 		
			echo "1";  
		}
	}
	 
	private function exec_delete_headerdetil($jurnal_id){
		$q_del_detil = "DELETE FROM transaksi_jurnaldetil WHERE jurnal_id = '$jurnal_id' ";
		$hsl_cek1 = $this->db->query($q_del_detil);
		if($hsl_cek1)
		{
			$q_del_header = "DELETE FROM transaksi_jurnal WHERE jurnal_id = '$jurnal_id' ";
			$hsl_cek2 = $this->db->query($q_del_header);
			return $hsl_cek2;
		} 
		return false;
	}
	
	private function exec_delete_bilyet($jurnal_id){
		$q_del_detil = "DELETE FROM transaksi_jurnalbilyet WHERE jurnal_id = '$jurnal_id' ";
		$hsl_cek1 = $this->db->query($q_del_detil);
		if($hsl_cek1)
		{
			return  $hsl_cek1;
		}
		else
		{
			return false;
		}
		
	}
	  
	/** end function delete jurnal **/
	
	public function dk_grid()
	{
		$options    = array(' ' => 'Select an option');                
        
        $options['0']= "D";
        $options['1']= "K";
                    
        return $options;
	}
	
    function acc_select(){ 
        
        $region     = $this->model_transaksi->get_acc();
        $options    = array('' => 'Select an option');                
        
        if(count($region)){
            foreach($region as $key => $value){
                $options[$value->acc_id]= $value->acc_id.' - ('.$value->acc_name.')';
            }
        }
                    
        return $options;
    }
	
    function itemid_select(){ 
        
        $region     = $this->model_transaksi->get_iteminventorytype();
        $options    = array('' => 'Select an option');                
        
        if(count($region)){
            foreach($region as $key => $value){
                $options[$value->iteminventorytype_id]= $value->iteminventorytype_id.' - ('.$value->iteminventorytype_name.')';
            }
        }
                    
        return $options;
    }
	  
}  