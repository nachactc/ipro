<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Locunapp extends CI_Controller{

	function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_loc');
		$this->load->library('breadcrumbcomponent');
    }

    function index(){
        redirect('loc/locunapp/locunapplist');
    }
    
    function globalsearch_list(){
       $arcari=array('loc_id',  'CTE.region_id','CTE.rekanan_id','BRANCH.branch_name','REKAN.rekanan_name','BRAND.rekananshipping_name');
		return $arcari;
    }
    function initialize_grid($uid){
      
      $rResult=$this->model_loc->dataunapplist($uid);

      $data['rResult']=$rResult;
      
      return $data;   
    }

    function locunapplist(){
        
        $loc_id = $this->uri->segment(4);

        $data   = array(
                  'result'    => $this->model_loc->viewloc($loc_id),
                  'loc_id'   => $loc_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['unit'] = $this->unit_select();
		
		$this->breadcrumbcomponent->add('LOC Permanent/Casual Approval','loc/locapplist');

        $this->load->view('template/v_header');
        $this->load->view('loc/loc_unapplist', $data);
        $this->load->view('template/v_footer');
    }

    function controler_gridlist(){

        $u_id = empty($_GET['uid']) ? '' : $_GET['uid'];
        $u_id = trim($u_id);

        $vResult=$this->initialize_grid($u_id);
        $rResult=$vResult['rResult'];
        //$output=$vResult['output'];        

        foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['loc_id']);
            $rek_name = substr($aRow['rekanan_name'], 0, 15) . '...';

            $row = array();
                    $row[]=$aRow['loc_id'];
                    $row[]=date("d-m-Y", strtotime($aRow['loc_date']));
                    //$row[]=date("d-m-Y", strtotime($aRow['loo_sdate']));
                    //$row[]=date("d-m-Y", strtotime($aRow['loo_edate']));
                    $row[]=$aRow['loc_term'];
                    $row[]=$aRow['region_nameshort'];
                    $row[]=$aRow['branch_name'];
                    $row[]=$rek_name;
                    $row[]=$aRow['rekananshipping_name'];                    
                   // $row[]=$aRow['unit_name'];
                    $row[]=$aRow['region_id'];
                    $row[]=$aRow['branch_id'];
                    $row[]=$aRow['unit_id'];
                    $row[]='
        <a href="/index.php/locprint/locprint/locprintpdf/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
        <i class="fa fa-print fa-lg"></i></a>';
        
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

    function loc_unapp(){

        if ($_POST){

           $_APP = empty($_POST['postid']) ? '' : $_POST['postid'];

           
        }

        if ($this->model_loc->unapproveloc($_APP))
        {
            $result['success'] = '1';
            $result['data'] = array('id' => $_APP[0][0]);
        }else{
            $result['success'] = '0';
            //$result['errors'] = array('action' => $action, 'msg' => $msg);
        }

        echo json_encode($result);
        
    }

}