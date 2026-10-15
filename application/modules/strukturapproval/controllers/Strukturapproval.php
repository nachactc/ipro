<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Strukturapproval extends CI_Controller{
	
	//--------------settingan awal---------------//
    CONST module = 'Strukturunit Approval';
    CONST tomboldialog = '';//nama tombol untuk memunculkan dialognya
    CONST defLink = 'strukturapproval';
    CONST defLinkAction = 'strukturapproval/strukturapproval';
    CONST defMethodAdd = 'savetrx';
    CONST defMethodEdit = 'updatetrx';
    CONST defJournalSource = '';
    CONST defJournalType = '';
	//------------------------------------------//
	
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_struktur');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
    }
    
    function index(){   
		$redirectAction = self::defLinkAction; 
        redirect("$redirectAction/load");
    }
    
	function globalsearch_list(){
		$arcari=array('strukturunitapprovalauth_type','username','strukturunitapprovalauth_value','strukturunitapprovalauth_position','b.strukturunit_name');
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
		
		$rResult=$this->model_struktur->$qry_alldata($limit,$top,$sWhere,$jurnalsource_id,$jurnaltype_id);
			
		$rResultCnt =$this->model_struktur->$qry_filtered($sWhere,$jurnalsource_id,$jurnaltype_id);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_struktur->$qry_totalall($jurnalsource_id,$jurnaltype_id);
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
		
		 
		// echo $criteria;exit;
		$jurnalsource = self::defJournalSource;
		$jurnaltype = self::defJournalType;
    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria,$jurnalsource,$jurnaltype);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];
 
    	foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['strukturunit_id']);
            $i_link2 = str_replace('/', '_', $aRow['strukturunitapprovalauth_line']);

             
			$linkModule = self::defLinkAction;
			  
            $_menu='
                <a href="/index.php/'.$linkModule.'/edit/'.$i_link.'/'.$i_link2.'" data-toggle="tooltip" title="Edit">
                <i class="fa fa-edit fa-lg"></i></a> &nbsp;
				<button type="button" class="btn btn-sm" id="btnDelete" data-id="'.$i_link.'" data-ln="'.$i_link2.'" > <i class="fa fa-trash fa-lg"></i></button> '; 
			 
			  
            $row = array(); 
			$row[]=$aRow['strukturunit_name'];            
			$row[]=$aRow['strukturunitapprovalauth_line'];            
			$row[]=$aRow['strukturunitapprovalauth_name'];            
			$row[]=$aRow['strukturunitapprovalauth_position'];            
			$row[]=$aRow['strukturunitapprovalauth_value'];
			$row[]=$aRow['strukturunitapprovalauth_header'];
			$row[]=$aRow['strukturunitapprovalauth_type']; 
			$row[] = '<input type="checkbox" id="posted"'. ($aRow['strukturunitapprovalauth_isdisabled'] == 1 ? 'checked= "checked"' : '').' disabled>';
			$row[]=date("d-m-Y", strtotime($aRow['strukturunitapprovalauth_date']));
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
		 
		
		$chid=get_setting("channel_id");   
        $data['username_select']     = $this->user_select(); 
        $data['strukturunit_select']     = $this->struktur_select(); 
		
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
		  
		
		$template = self::defLink;
		
        $this->load->view("template/v_header");
        $this->load->view("$template/script");
        $this->load->view("$template/css");
        $this->load->view("$template/add", $data);
        $this->load->view("template/v_footer");
	}
     
	function edit(){		
        
        $strukturunit_id =  $this->uri->segment(4);  
        $strukturunitapprovalauth_line =  $this->uri->segment(5); 
		
		$header = array();
	    
		$data['username_select']     = $this->user_select(); 
        $data['strukturunit_select']     = $this->struktur_select(); 
		
		$mUpdate = self::defMethodEdit; 
		$mLinkAct = self::defLinkAction;  
		$data['method']     = "$mLinkAct/$mUpdate/$strukturunit_id/$strukturunitapprovalauth_line";
		$data['tombolDlgName'] = self::tomboldialog;
		$module = self::module;
		$linkdefinisi = self::defLink;
		
  		$this->breadcrumbcomponent->add("List $module","$linkdefinisi/$linkdefinisi/load")
		->add("Form Edit $module");
		 
		//header jurnal load 
		$header = $this->model_struktur->get_trx($strukturunit_id,$strukturunitapprovalauth_line);
		  
		//header
        $data['result']     = $header;
		 
		
		$template = self::defLink;
        $this->load->view("template/v_header");
        $this->load->view("$template/script");
        $this->load->view("$template/css");
        $this->load->view("$template/add", $data);
        $this->load->view("template/v_footer");
	}    
     
	function savetrx(){
		$RedirectAction = self::defLinkAction;
		$saveData = $this->model_struktur->save_trx();
		if($saveData)
		{
			redirect("$RedirectAction/load");
		} 
	}

	function updatetrx(){ 
		$strukturunit_id =  $this->uri->segment(4);  
        $strukturunitapprovalauth_line =  $this->uri->segment(5); 
		
		$RedirectAction = self::defLinkAction;
		if(!empty($strukturunit_id)){ 
			if(!empty($_POST)){ 
				$updateData = $this->model_struktur->update_trx();
				// echo var_dump($updateData);exit;
				if($updateData)
				{
					redirect("$RedirectAction/edit/".$strukturunit_id."/".$strukturunitapprovalauth_line);
				} 
			}
		}
		else
		{
			redirect("$RedirectAction/edit/".$strukturunit_id."/".$strukturunitapprovalauth_line);
		} 
	}
	
	/** start function delete jurnal **/
	
	function trx_delete(){
		$strukturunit_id = $this->input->post('strukturunit_id');
		$strukturunitapprovalauth_line = $this->input->post('strukturunitapprovalauth_line');
		 
		if (!empty($strukturunit_id)){
		
			$header = "DELETE FROM master_strukturunitapprovalauth WHERE strukturunit_id = '$strukturunit_id' AND strukturunitapprovalauth_line = $strukturunitapprovalauth_line "; 
			$this->db->query($header); 	 	
			echo "1";  
		}
	}
	  
	/** end function delete jurnal **/
	  
    function user_select(){ 
        
        $region     = $this->model_struktur->get_username();
        $options    = array('' => 'Select an option');                
        
        if(count($region)){
            foreach($region as $key => $value){
                $options[$value->username]= $value->username.' - '.$value->user_fullname;
            }
        }
                    
        return $options;
    }
	
    function struktur_select(){ 
        
        $region     = $this->model_struktur->get_strukturunit();
        $options    = array('' => 'Select an option');                
        
        if(count($region)){
            foreach($region as $key => $value){
                $options[$value->strukturunit_id]= $value->strukturunit_id.' - ('.$value->strukturunit_name.')';
            }
        }
                    
        return $options;
    }
	  
}  