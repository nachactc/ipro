<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class invoice_discount extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
       $this->load->model('model_invoice_discount');
		$this->load->library('breadcrumbcomponent');
    }
     public function invoice_discount_actsave()
	{
		$this->model_invoice_discount->m_actsave();	
		redirect('invoice_discount/invoice_discount/invoice_discount_list');
	}
	
	 public function invoice_discount_actedit()
	{
		$this->model_invoice_discount->m_actedit();	
		redirect('invoice_discount/invoice_discount/invoice_discount_list');
	}
	
	
	public function dialog_invoice_discount($search='')
	{

		$search = $this->input->post('params');
		$search = str_replace("'", "''", $search);

		$row = array(); 
		$output=array(); 
		$dataDlg =array(); 
		$dataDlgR = array(); 
		
		if ($search != '')
		{
			$dataDlg = $this->model_invoice_discount->get_data_dialog_invoice_discount($search);
			$dataDlgR = $this->model_invoice_discount->get_data_dialog_invoice_discount_rows($search);
			 
			foreach ($dataDlg as $aRow) 
			{ 
				$row[0] ="";
				$row[1] = $aRow['invoice_id']; 
				$row[2] = $aRow['rekananshipping_name']; 
				$row[3] = $aRow['schedulepaymentdetil_descr']; 
				$row[4] = number_format($aRow['schedulepaymentdetil_idr'],2);
				$row[5] = $aRow['rekanan_name']; 
				$row[6] = $aRow['branch_name'];
				$row[7] = $aRow['schedulepayment_id'];
				$row[8] = $aRow['schedulepaymentdetil_line'];
				$row[9] = $aRow['agreementtype_id'];
				$row[10] = $aRow['agreement_id'];
				$row[11] = $aRow['schedulepaymentdetil_date'];
				$row[12] = $aRow['faktur_id'];
					
				
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
				$row[10]='';
				$row[11]='';
				$row[12]='';
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
			$row[10]='';
			$row[11]='';
			$row[12]='';
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
	
	 function invoice_discount_add()
	{		
        
        $loo_id = $this->uri->segment(4);        
        
        $data   = array(
                  
                  'loo_id'   => $loo_id
            );        
        $vusername=$this->session->userdata('user_fullname');	
        $data['region']  = $this->region_select();
		$data['branch_dlg'] = $this->branch_select_dialog();
		$data['namauser']=$vusername;
		//$data['dialog_invoice_discount'] = $this->load->view('invoice_discount/dialog_invoice_discount');

  		$this->breadcrumbcomponent->add('Invoice Discount','invoice_discount/invoice_discount')
            ->add('Input Invoice Discount','loo_cl/loo_cl/looadd');


        $this->load->view('template/v_header');
		$this->load->view('invoice_discount/dialog_invoice_discount');
        $this->load->view('invoice_discount/invoice_discount_add', $data);
        $this->load->view('template/v_footer');
	}
	
	
    function index(){       
        redirect('invoice_discount/invoice_discount/invoice_discount_list');
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
		$arcari=array('sd.invoice_id', 'sd.schedulepayment_id+cast(sd.schedulepaymentdetil_line as varchar)', 'b.branch_name', 'r.rekanan_name','rs.rekananshipping_name');
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
		if ( isset( $_POST['order'] ) ) {
			$sOrder = "ORDER BY";

			switch ($_POST['order'][0]['column']) {
				
				case 0:
					# code...
					$sOrder .= ' rekanan_name ' . $_POST['order'][0]['dir'];
					break;

				case 1:
					# code...
					$sOrder .= ' rekananshipping_name ' . $_POST['order'][0]['dir'];
					break;
				
				case 3:
					# code...
					$sOrder .= ' invoice_id ' . $_POST['order'][0]['dir'];
					break;

				case 4:
					# code...
					$sOrder .= ' schedulepaymentdiscount_idr ' . $_POST['order'][0]['dir'];
					break;
			}

			//$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" ) {
				$sOrder = "";
			}
		}
		   
		$sWhere = ""; 
		if ( isset($_POST['search']['value']) && $_POST['search']['value'] != "" ) {
		   $sWhere = "WHERE ("; 
			for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
				$sWhere .= $aColumns[$i]." LIKE '%".str_replace("'", "''", $_POST['search']['value'] )."%' OR ";
				//$sWhere .= $aColumns[$i]." LIKE '%".($_POST['search']['value'] )."%' OR ";
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
		//$limit=$limit+$top;


		//$b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ; 
		//$sWhere = $sWhere.$b;
        if ( $cariOptional <> '' ) {            
            $sWhere = $sWhere <> '' ? $sWhere." AND ".$cariOptional : " WHERE ".$cariOptional;
        }        
		
		$rResult=$this->model_invoice_discount->$qry_alldata($limit, $top, $sWhere, $sOrder);
			
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

    function invoice_discount_list(){
        		
		$this->breadcrumbcomponent->add('Invoice Discount','invoice_discount/invoice_discount/invoice_discount_list');

        $this->load->view('template/v_header');
        $this->load->view('invoice_discount/invoice_discountlist');
        $this->load->view('template/v_footer');
    }

	function get_data_loi($where='')
	{
		$result = $this->model_invoice_discount->qry_alldatalist_2($where);
		
		foreach ($result as $aRow) {

            $i_link = str_replace('/', '_', $aRow['loo_id']);
            $id_show =$aRow['loo_id']; 
                    $tenant = $id_show." - ".$aRow['rekananshipping_name'] ;
            
                    $row[0]=$id_show;
                    $row[1]=$aRow['region_nameshort'];
                    $row[2]=$aRow['branch_name'];
                    $row[3]=$aRow['rekanan_name'];
                    $row[4]=$aRow['rekananshipping_name'];
                    $row[5]='<a href="/index.php/invoice_discount/invoice_discount/loi_statusedit/'.$i_link.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a> 
                     <a href="/index.php/invoice_discount/invoice_discount/loi_statusdel/'.$i_link.'" data-toggle="tooltip" title="Delete" onclick="return confirm(\'Anda yakin menghapus Data '.$tenant.' ?\');"><i class="fa fa-trash"></i></a>';
        
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

        $fromSearch = $f_date <> '' ? "loi_processdate >= '$f_date' " : '';
        $optSearch = $fromSearch;

        if ($t_date <> ''){
            $searchCriteria = $t_date <> '' ? "loi_processdate <= '$t_date' " : '';
            $optSearch =  $optSearch <> '' ?   $optSearch." AND ".$searchCriteria : $searchCriteria ;
        }        

        $arcari=$this->globalsearch_list();
        $vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari, $optSearch);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {

						$i_link = $aRow['schedulepayment_id'].$aRow['schedulepaymentdiscount_line'];
				
						$ship_name = substr($aRow['rekanan_name'], 0, 20) . '...';

						$brand_name = substr($aRow['rekananshipping_name'], 0, 20) . '...';

						$row[0]=$ship_name;
						$row[1]=$brand_name;
						$row[2]=$i_link;
						$row[3]=$aRow['invoice_id'];
						$row[4]=number_format($aRow['schedulepaymentdiscount_idr'],2);
						$row[5]=$aRow['schedulepaymentdiscount_percent'];
						$row[6]=number_format($aRow['schedulepaymentdiscount_idr'],2);
						$row[7]=$aRow['schedulepaymentdiscount_isposted'];

						if ($aRow['schedulepaymentdiscount_isposted']=='1'){
							$row[8]='<a href="/index.php/invoice_discount/invoice_discount/invoice_discount_listedit/'.$i_link.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit fa-lg"></i></a>';
						} else {
							$row[8]='<a href="/index.php/invoice_discount/invoice_discount/invoice_discount_listedit/'.$i_link.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit fa-lg"></i></a> 
							<a href="/index.php/invoice_discount/invoice_discount/invoice_discount_statusdel/'.$i_link.'" data-toggle="tooltip" title="Delete" onclick="return confirm(\'Anda yakin menghapus Data  ?\');"><i class="fa fa-trash fa-lg"></i></a>';
						}

            if (!empty($row)) { $output['data'][] = $row; }
        }   
        
        echo json_encode($output);
            
    }

  
   
    
	
	function invoice_discount_listedit(){		
        
        $i_link = $this->uri->segment(4);       

        $spid = str_replace('_', '/', $i_link); 

        $data   = array(
                  'result'    => $this->model_invoice_discount->viewdiscount($spid),
                  'spid'   => $spid
            );                
	 
		 
		
		$this->breadcrumbcomponent->add('Invoice Discount','invoice_discount/invoice_discount/invoice_discount_listedit')
            ->add('Edit Invoice Discount','invoice_discount_listedit');        

        $this->load->view('template/v_header');
        $this->load->view('invoice_discount/invoice_discount_edit', $data);
        $this->load->view('template/v_footer');
	}
    
	function invoice_discount_statusdel($_id)
	{
		 
		$this->model_invoice_discount->deleteLOI($_id);
		
		redirect("invoice_discount/invoice_discount/invoice_discount_list");
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
		
		$branch      = $this->model_invoice_discount->get_branch_dlg($name);
		      
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



   

     
    
}  