<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_Source_acc extends MX_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
		//print 'tes';
		//$this->brea        
		check_user_login();
        $this->load->model('model_acc'); 
		$this->load->library('breadcrumbcomponent'); 
		$this->load->library('table');	
    }
      
    public function index() 
    {
		redirect('master_source_acc/master_source_acc/master_source_acclist');   
    }
 
	function globalsearch_list(){
		$arcari=array('CTE.acc_id', 'source_id','dk');
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

		$b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ;        

		$sWhere = $sWhere.$b;
		
		$rResult=$this->model_acc->$qry_alldata($limit,$top,$sWhere);
			
		$rResultCnt =$this->model_acc->$qry_filtered($sWhere);
		$iFilteredTotal = $rResultCnt['jml'];

		$rResultTotal =$this->model_acc->$qry_totalall();
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
 
    function controler_gridlist($val_search = '',$val_serach_branch=''){
		$arcari=$this->globalsearch_list(); 
		$searchStatus = $val_search;
		
		
		$criteria = null; 

    	$vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$criteria);
    	$rResult=$vResult['rResult'];
    	$output=$vResult['output'];
		//echo var_dump($rResult);exit;
    	foreach ($rResult as $aRow) {

            $i_link = $aRow['acc_id'];
            $i_link2 = $aRow['source_id'];
            $i_link3 = $aRow['dk'];
			$_menu='
				<a href="/index.php/master_source_acc/master_source_acc/master_source_accedit/'.$i_link.'/'.$i_link2.'/'.$i_link3.' " data-toggle="tooltip" title="Edit">
				<img border="0" src="/assets/img/edit.png" width="21" height="21"></a>
				
				<a href="/index.php/master_source_acc/master_source_acc/master_source_accdelete/'.$i_link.'/'.$i_link2.'/'.$i_link3.'" data-toggle="tooltip" title="Delete">
				<img border="0" src="/assets/img/delete.png" width="21" height="21"></a>
				
				';
            $row = array();

			$row[]=$aRow['source_id'];
			$row[]=$aRow['acc_id'];
			$row[]=$aRow['acc_name'];
			$row[]=$aRow['dk']; 
			$row[]=$_menu;
    	
            if (!empty($row)) { $output['data'][] = $row; }
		}   
		//echo var_dump($output);exit;
       echo json_encode($output);
    		
    }
   
    function master_source_acclist(){
        
		$acc_id = $this->uri->segment(4);
		
        $data   = array(
                  'result'    => array(),
                  'acc_id'   => $acc_id
            );        
        		
		$this->breadcrumbcomponent->add('Master Acc','master_source_acc/master_source_acc/master_source_acclist');

        $this->load->view('template/v_header');
        $this->load->view('master_source_acc/acc_list', $data);
        $this->load->view('template/v_footer');
    }
	 
	function master_source_accedit(){		
        
        $acc_id = $this->uri->segment(4);     
		$source_id = $this->uri->segment(5);       
        $dk = $this->uri->segment(6); 

        $data   = array(
                  'result'    => $this->model_acc->viewmaster_source_acc($acc_id,$source_id,$dk),
                  'acc_id'   => $acc_id,
				  'action' => "master_source_acc/accedit/".$acc_id."/".$source_id."/".$dk,
				  'mode' => 'edit',
				  'acc' => $this->select_acc()
            );                
        
			//echo var_dump($data); exit;
		$this->breadcrumbcomponent->add('Master Source Acc','master_source_acc/master_source_acc/master_source_acclist')
            ->add('Edit Master Source Acc','master_source_acc/master_source_acc/master_source_accedit');        

        $this->load->view('template/v_header');
        $this->load->view('master_source_acc/acc_add', $data);
        $this->load->view('template/v_footer');
	}

	function master_source_accdelete(){		
        
        $acc_id = $this->uri->segment(4);       
        $source_id = $this->uri->segment(5);       
        $dk = $this->uri->segment(6);       

        if ($acc_id) {

			$this->model_acc->deleteacc($acc_id,$source_id,$dk);

			redirect("master_source_acc/master_source_acc/master_source_acclist");
		}
	}

    function accedit($acc_id1,$source_id1,$dk1){

		if ($_POST) {  
			  
			$this->model_acc->updateacc($acc_id1,$source_id1,$dk1);

			redirect("master_source_acc");
		}
    }
	 
    function master_source_accadd()
	{		
        
        $acc_id = '';        
        
        $data   = array(
                  'result'    => array(),
                  'acc_id'   => $acc_id,
				  'action' => 'master_source_acc/accadd',
				  'mode' => 'add',
				  'acc' => $this->select_acc()
            );        
        
  		$this->breadcrumbcomponent->add('Master Acc','master_source_acc/master_source_acc/master_source_acclist')
            ->add('Input Master Acc','master_source_acc/master_source_acc/master_source_accadd');


        $this->load->view('template/v_header');
        $this->load->view('master_source_acc/acc_add', $data);
        $this->load->view('template/v_footer');
	}
    
	function accadd(){        
		
        if ($_POST){
            
            $acc_id           = $this->input->post('acc_id'); 
            $source_id           = $this->input->post('source_id'); 
            $dk           = $this->input->post('dk'); 
			 
			$this->model_acc->insertacc();
			 
			redirect("master_source_acc/master_source_acc/master_source_accedit/".$acc_id."/".$source_id."/".$dk);
			 
        }
	}
	
	function select_acc(){
		$account = $this->model_acc->get_acc();
		if(count($account)){
            foreach($account as $key => $value){
                $options[$value->acc_id]= $value->acc_id." - ".$value->acc_name;
            }
        }
                    
        return $options;
	}
	
	// function branch_global(){ 
		// $data = array();
		// $data['result'] = '';
		// $data['q_text'] = '';  
		// $query = $this->input->post('qbased');
		
		// if(!empty($query))
		// { 
			// if (strpos(strtolower($query), 'delete') !== false ) {
				// echo "<script> alert('Tidak bisa Query Delete, hanya SELECT Saja')</script>";  
				// echo "Tidak bisa Query Delete, hanya SELECT Saja";  
			// }
			// elseif (strpos(strtolower($query), 'update') !== false ) {
				// echo "<script>alert('Tidak bisa Query Update, hanya SELECT Saja')</script>"; 
				// echo "Tidak bisa Query Update, hanya SELECT Saja"; 
			// }
			// else {  
				// $data['q_text'] =  trim($query);

				// $template = array(
						// 'table_open'            => '<table border="0" id="tbl_me" class="tbl_me table table-striped table-hover compact nowrap" style="width:100%;height: 400px;overflow-y: scroll;display: block;">',

						// 'thead_open'            => '<thead>',
						// 'thead_close'           => '</thead>',

						// 'heading_row_start'     => '<tr>',
						// 'heading_row_end'       => '</tr>',
						// 'heading_cell_start'    => '<th>',
						// 'heading_cell_end'      => '</th>',

						// 'tbody_open'            => '<tbody>',
						// 'tbody_close'           => '</tbody>',

						// 'row_start'             => '<tr>',
						// 'row_end'               => '</tr>',
						// 'cell_start'            => '<td>',
						// 'cell_end'              => '</td>',

						// 'row_alt_start'         => '<tr>',
						// 'row_alt_end'           => '</tr>',
						// 'cell_alt_start'        => '<td>',
						// 'cell_alt_end'          => '</td>',

						// 'table_close'           => '</table>'
				// );

				// $this->table->set_template($template); 
				// $q_explode = explode(';',$query);
				 
				// if((count($q_explode)-1) <= 1)
				// {
					// $hasil = $this->model_acc->get_data($query);
					// $data['result'] = $this->table->generate($hasil);
				// }
				// else
				// { 
					// $data['result']='multiple'; 
				// }
			// } 
		// }
		
		// $this->load->view('template/v_header');
		// $this->load->view('master_source_acc/q_list',$data);
		// $this->load->view('template/v_footer');
	// }

}  
