<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jvoucherapp extends CI_Controller{

	  function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_jvoucherapp');
		    $this->load->library('breadcrumbcomponent');
    }

    function index(){
        redirect('jvoucher/jvoucherapp/jvoucherapplist');
    }
    
    function globalsearch_list(){
        $arcari=array('jurnal_id','jurnaltype_id','jurnal_source','periode_id','jurnal_createby');
		return $arcari;
    }
    function globalsearchcancel_list(){
        $arcari=array('vv.jurnal_id','vv.jurnaltype_id','vv.jurnal_source','vv.periode_id','vv.jurnal_createby');
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
          }
        }
      }
       
      
      $top = (isset($_POST['start']))?((int)$_POST['start']):0 ;
      $limit = (isset($_POST['length']))?((int)$_POST['length'] ):10 ;
      $limit=$limit+$top;

      $b =  $cariOptional <> '' ?   " AND ".$cariOptional  : '' ;  
      $sWhere = $sWhere.$b;

      $rResult=$this->model_jvoucherapp->$qry_alldata($limit,$top,$sWhere);
        
      $rResultCnt =$this->model_jvoucherapp->$qry_filtered($sWhere);
      $iFilteredTotal = $rResultCnt['jml'];

      $rResultTotal =$this->model_jvoucherapp->$qry_totalall();
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

    function jvoucherapplist(){
        
        $jurnal_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_jvoucherapp->viewjurnal($jurnal_id),
                  'jurnal_id' => $jurnal_id
        );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['source'] = $this->source_select();
    
        $this->breadcrumbcomponent->add('List Journal','jvoucher/jvoucherapplist');

        $this->load->view('template/v_header');
        $this->load->view('jvoucher/jvoucher_applist', $data);
        $this->load->view('template/v_footer');
    }

    function jvoucherunapplist(){
        
        $jurnal_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_jvoucherapp->viewjurnal($jurnal_id),
                  'jurnal_id' => $jurnal_id
        );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['source'] = $this->source_select();
    
        $this->breadcrumbcomponent->add('List Journal','jvoucher/jvoucherunapplist');

        $this->load->view('template/v_header');
        $this->load->view('jvoucher/jvoucher_unapplist', $data);
        $this->load->view('template/v_footer');
    }
    function jvouchercancelapplist(){
        
        $jurnal_id = $this->uri->segment(4);
        $data   = array(
                  'result'    => $this->model_jvoucherapp->viewjurnal($jurnal_id),
                  'jurnal_id' => $jurnal_id
        );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['source'] = $this->source_select();
    
        $this->breadcrumbcomponent->add('List Journal','jvoucher/jvouchercancelapplist');

        $this->load->view('template/v_header');
        $this->load->view('jvoucher/jvoucher_cancelapplist', $data);
        $this->load->view('template/v_footer');
    }

    function controler_gridlist($val_search = ''){
        $arcari=$this->globalsearch_list(); 

        $val_search = 'jurnal_isposted = 0';
                 
        $vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$val_search);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {

              $i_link = $aRow['jurnal_id'];
              $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
              $is_post = ($aRow['jurnal_isposted']) ? 1 : 0;

              $_menu='
                  <a href="/index.php/jvoucher/jvoucher/jvoucheredit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                  <i class="fa fa-edit fa-lg"></i></a>
                  <a href="/index.php/laprint5/laprint5/laprint5pdf/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank">
                  <i class="fa fa-print fa-lg"></i></a>';

              $row = array();
              $row[]= '';
              $row[]= $aRow['jurnal_id'];            
              $row[]= date("d-m-Y", strtotime($aRow['jurnal_bookdate']));
              $row[]= number_format($aRow['jurnal_amountidr'], 2);
              $row[]= $aRow['branch_name'];
              $row[]= $ship_name;
              $row[]= $aRow['strukturunit_name'];              
              $row[]= '<input type="checkbox" id="posted"'. ($aRow['jurnal_isposted'] == 1 ? 'checked= "checked"' : '').' disabled>';
              $row[]= $_menu;
        
              if (!empty($row)) { $output['data'][] = $row; }
        }   
      echo json_encode($output);          
    }

    function controler_gridunpostlist($val_search = ''){
        $arcari=$this->globalsearch_list(); 

        $val_search = 'jurnal_isposted = 1';
                 
        $vResult=$this->initialize_grid("qry_alldatalist","qry_filteredlist","qry_totalalllist",$arcari,$val_search);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {

              $i_link = $aRow['jurnal_id'];
              $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
              $is_post = ($aRow['jurnal_isposted']) ? 1 : 0;

              $_menu='
                  <a href="/index.php/jvoucher/jvoucher/jvoucheredit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                  <i class="fa fa-edit fa-lg"></i></a>
                  <a href="/index.php/laprint5/laprint5/laprint5pdf/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank">
                  <i class="fa fa-print fa-lg"></i></a>';

              $row = array();
              $row[]= '';
              $row[]= $aRow['jurnal_id'];            
              $row[]= date("d-m-Y", strtotime($aRow['jurnal_bookdate']));
              $row[]= number_format($aRow['jurnal_amountidr'], 2);
              $row[]= $aRow['branch_name'];
              $row[]= $ship_name;
              $row[]= $aRow['strukturunit_name'];              
              $row[]= '<input type="checkbox" id="posted"'. ($aRow['jurnal_isposted'] == 1 ? 'checked= "checked"' : '').' disabled>';
              $row[]= $_menu;
        
              if (!empty($row)) { $output['data'][] = $row; }
        }   
      echo json_encode($output);          
    }
	
	
    function controler_gridcancellist($val_search = ''){
        $arcari=$this->globalsearchcancel_list(); 

        $val_search = 'vv.jurnal_isposted = 1';
                 
        $vResult=$this->initialize_grid("qry_allcanceldatalist","qry_filteredlist","qry_totalalllist",$arcari,$val_search);
        $rResult=$vResult['rResult'];
        $output=$vResult['output'];

        foreach ($rResult as $aRow) {

              $i_link = $aRow['jurnal_id'];
              $ship_name = substr($aRow['rekanan_name'], 0, 15) . '...';
              $is_post = ($aRow['jurnal_isposted']) ? 1 : 0;

              $_menu='
                  <a href="/index.php/jvoucher/jvoucher/jvoucheredit/'.$i_link.'" data-toggle="tooltip" title="Edit">
                  <i class="fa fa-edit fa-lg"></i></a>
                  <a href="/index.php/laprint5/laprint5/laprint5pdf/'.$i_link.'" data-toggle="tooltip" title="Edit" target="_blank">
                  <i class="fa fa-print fa-lg"></i></a>';

              $row = array();
              $row[]= '';
              $row[]= $aRow['jurnal_id'];            
              $row[]= date("d-m-Y", strtotime($aRow['jurnal_bookdate']));
              $row[]= number_format($aRow['jurnal_amountidr'], 2);
              $row[]= $aRow['branch_name'];
              $row[]= $ship_name;
              $row[]= $aRow['strukturunit_name'];              
              $row[]= '<input type="checkbox" id="posted"'. ($aRow['jurnal_isposted'] == 1 ? 'checked= "checked"' : '').' disabled>';
              $row[]= $_menu;
        
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

    function jvoucher_app(){

        if ($_POST){
           $_APP = empty($_POST['postid']) ? '' : $_POST['postid'];           
        }

        // Treat input as username
        $type = 'username';        

        $username   = $this->session->userdata('username');  
        $channel_id = $this->session->userdata('channel_id');             
            
        if ($this->model_jvoucherapp->postingjurnal($_APP, $username, $channel_id, 'POSTING'))
        {                    

            $result['success'] = TRUE;
            $result['data'] = array('id' => $_APP[0]['id']);
            echo json_encode($result);
        }else{
            $result['success'] = FALSE;     
            $result['data'] = array('id' => $_APP[0]['id']);
            echo json_encode($result);  
        }
        
    } 

    function jvoucher_unapp(){

        if ($_POST){
           $_APP = empty($_POST['postid']) ? '' : $_POST['postid'];           
        }

        // Treat input as username
        $type = 'username';        

        $username   = $this->session->userdata('username');  
        $channel_id = $this->session->userdata('channel_id');             
            
        if ($this->model_jvoucherapp->postingjurnal($_APP, $username, $channel_id, 'UNPOSTING'))
        {                    

            $result['success'] = TRUE;
            $result['data'] = array('id' => $_APP[0]['id']);
            echo json_encode($result);
        }else{
            $result['success'] = FALSE;     
            $result['data'] = array('id' => $_APP[0]['id']);
            echo json_encode($result);  
        }
        
    } 
	
    function jvoucher_cancelapp(){

        if ($_POST){
           $_APP = empty($_POST['postid']) ? '' : $_POST['postid'];           
           $tgl = empty($_POST['tgl']) ? '' : $_POST['tgl'];           
        }
		//echo $_POST['tgl'];exit;
        // Treat input as username
        $type = 'username';        

        $username   = $this->session->userdata('username');  
        $channel_id = $this->session->userdata('channel_id');             
            
        if ($this->model_jvoucherapp->canceljurnal($_APP, $username, $channel_id, 'CANCEL',$tgl))
        {                    

            $result['success'] = TRUE;
            $result['data'] = array('id' => $_APP[0]['id']);
            echo json_encode($result);
        }else{
            $result['success'] = FALSE;     
            $result['data'] = array('id' => $_APP[0]['id']);
            echo json_encode($result);  
        }
        
    }    

    function source_select() {
        $source = $this->model_jvoucherapp->get_journalsource();

        if(count($source)){
            foreach($source as $key => $value){
                $options[$value->jurnalsource_id]= $value->jurnalsource_name;
            }
        }
                    
        return $options;
    }

}