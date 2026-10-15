<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UploadMemo extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        $this->load->model('upload_md/UploadMemoModel');
		$this->load->library('breadcrumbcomponent');

    }

	function actupload(){
         if ($_POST['btupload']) {
            //file upload destination
            $dir_path = 'assets/uploads';
            $config['allowed_types'] = 'pdf|jpg|png';
            $config['max_size'] = '5120';
            $config['max_filename'] = '100';
           // $config['encrypt_name'] = TRUE;
		    
 			$agid=$this->input->post('agid');
			$loo_id=$this->input->post('loo_id');
			$tipe=$this->input->post('tipe');
			$rnum =$this->model_upload->getnumfile($loo_id);
			$nonum=$rnum['jml'];
            
			$path = APPPATH. '../assets/uploads/'.$agid;
			$config['upload_path'] =$path;

    		if(!is_dir($path)) //create the folder if it's not already exists
    		{
      			mkdir($path,0755,TRUE);
    		} 
	
            $i = 0;
            $files = array();
            $is_file_error = FALSE;
			$pattern = '/([^0-9]+)/';

            if ($_FILES['upload_file1']['size'] <= 0) {
               echo 'Select at least one file.';
            } else {
                foreach ($_FILES as $key => $value) {
                    if (!empty($value['name'])) {
						$nonum=$nonum+1;
						$new_name = $agid."-".$nonum;
						$config['file_name'] = $new_name;
                        $this->load->library('upload', $config);
						$this->upload->initialize($config);
                        if (!$this->upload->do_upload($key)) {

                            $is_file_error = TRUE;
                        } else {
                            //$files[$i] = $this->upload->data();
							
							$angka1 = preg_replace($pattern,'',$key);
							$tek=$this->input->post('tdes'.$angka1);
							//echo $new_name;

							$ext=pathinfo($value['name'],PATHINFO_EXTENSION);
							$new_name=$new_name.".".$ext;
							$this->model_upload->savedataimg($loo_id,$agid,$new_name,$tipe,$tek);
                            ++$i;
                        }
                    }
                }
            }

           // There were errors, we have to delete the uploaded files
		 }
		 $i_link = str_replace('/', '_', $loo_id);
		
		redirect ('upload/uploaddoc/uploadloo/'.$i_link.'/'.$agid.'/'.$tipe);
       // $data['errors'] = $this->error;
       // $data['success'] = $this->success;
       // $this->load->view('uploadfiles', $data);
    }
	
	function uploadlist(){
        
 
        $this->breadcrumbcomponent->add('Upload Documents','upload/uploaddoc/uploadlist');
        $this->load->view('template/v_header');
        $this->load->view('upload/list_upload');
        $this->load->view('template/v_footer');
    }
	
	function uploadloo(){
        
        $loo_id = $this->uri->segment(4);
		$loo_id = str_replace('_', '/', $loo_id);
		$agid = $this->uri->segment(5);  
		$tipe = $this->uri->segment(6);  
        $data   = array(
                   'result'=>$this->model_upload->viewloorn($loo_id),
				   'rupload'=>$this->model_upload->showupload($loo_id,$agid,$tipe),
				   'agid'=>$agid,
				   'loo_id'=>$loo_id,
				   'tipe'=>$tipe
				   
            );    
		 		
		$data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['unit'] = $this->unit_select();
        $this->breadcrumbcomponent->add('Upload Documents','upload/uploaddoc/uploadlist');
        $this->load->view('template/v_header');
        $this->load->view('upload/frmupload',$data);
        $this->load->view('template/v_footer');
    }
	
		
	function globalsearch_list(){
		$arcari=array('a.loo_id',  'x.agreement_id');
		return $arcari;
	}
	
	function initialize_grid($qry_alldata,$qry_filtered,$qry_totalall,$arcari){
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
	 
    $top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
    $limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
	$limit=$limit+$top;

    $rResult=$this->model_upload->$qry_alldata($limit,$top,$sWhere);
	
	
   
	$rResultCnt =$this->model_upload->$qry_filtered($sWhere);
	//$iFilteredTotal = $rResultCnt['jml'];
	$iFilteredTotal =$rResultCnt;

	$rResultTotal =$this->model_upload->$qry_totalall();
	//$iTotal = $rResultTotal['jml'];
	$iTotal =$rResultTotal;
       
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

	
	
function controler_gridlistrn(){
        $arcari=$this->globalsearch_list();
        $vResult=$this->initialize_grid("qry_alldatalistrn","qry_filteredlist","qry_totalalllist",$arcari);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['loo_id']);
            $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
            $is_post = ($aRow['isconfirm']) ? 1 : 0;
            $is_post = ($aRow['isapproved']) ? 1 : 0;            
            
            $id_show =$aRow['loo_id']; 
			$ag=$aRow['agreement_id'];
            
            $row = array();
                    $row[]=$id_show;
                   // $row[]=date("d-m-Y", strtotime($aRow['loo_date']));
				   $row[]=$aRow['agreement_id'];
                    $row[]=date("d-m-Y", strtotime($aRow['loo_sdate']));
                    $row[]=date("d-m-Y", strtotime($aRow['loo_edate']));
                    $row[]=$aRow['loo_term'];
                    $row[]=$aRow['region_nameshort'];
                    $row[]=$aRow['branch_name'];
                    $row[]=$ship_name;
                    $row[]=$aRow['rekananshipping_name'];
                    $row[]=$aRow['isapproved'];
                    $row[]=$aRow['isconfirm'];	
					
					$rkn=substr($aRow['rekanan_name'],0,2);
					$rkn=strtoupper($rkn);
						$row[]='<a href="/index.php/upload/uploaddoc/uploadloo/'.$i_link.'/'.$ag.'/loo" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Doc. LOO</a>
						<a href="/index.php/upload/uploaddoc/uploadloo/'.$i_link.'/'.$ag.'/ag" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Doc. LOI</a>
					<a href="/index.php/upload/uploaddoc/uploadloo/'.$i_link.'/'.$ag.'/la" data-toggle="tooltip" title="Edit" target="_blank" class="btn btn-primary btn-xs">Doc. LA</a>
					';

            if (!empty($row)) { $output['data'][] = $row; }
        }   
        
        echo json_encode($output);
            
    }
	
	 function region_select(){
        $this->load->model('template/Master_m');
        
        $region      = $this->Master_m->get_region();
        $options    = array('' => '==Pilih==');                
        
        if(count($region)){
            foreach($region as $key => $value){
                $options[$value->region_id]= $value->region_name;
            }
        }
                    
        return $options;
    }

    function unit_select(){
        $this->load->model('template/Master_m');
        
        $unit     = $this->Master_m->get_unit();
        
        $options    = array('' => '==Pilih==');                
        
        if(count($unit)){
            foreach($unit as $key => $value){
                $options[$value->unit_id]= $value->unit_name;
            }
        }
        
                    
        return $options;
    }
    
    function branch_select(){
        $this->load->model('template/Master_m');    
        $branch     = $this->Master_m->get_branch();
        $options    = array('' => '==Pilih==');                
        
        if(count($branch)){
            foreach($branch as $key => $value){
                $options[$value->branch_id]= $value->branch_name;
            }
        }
                    
        return $options;
    }
	
	function delupload(){
		
		$loo_id = $this->uri->segment(4);
		$loo_id = str_replace('_', '/', $loo_id);
		$agid = $this->uri->segment(5);  
		$tipe = $this->uri->segment(7);  
		$nama = $this->uri->segment(6);
		$this->model_upload->deleteupload($loo_id,$agid,$nama,$tipe);
		$i_link = str_replace('/', '_', $loo_id);
		redirect ('upload/uploaddoc/uploadloo/'.$i_link.'/'.$agid.'/'.$tipe);
		
		
	}
	
}  