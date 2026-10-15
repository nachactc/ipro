<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Looapp extends CI_Controller{

	function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_loo');
		$this->load->library('breadcrumbcomponent');
    }

    function index(){
        redirect('loo_bts/looapp/looapplist');
    }
    
    function globalsearch_list(){
       $arcari=array('loo_id',  'CTE.region_id','CTE.rekanan_id','BRANCH.branch_name','REKAN.rekanan_name','BRAND.rekananshipping_name');
		return $arcari;
    }
    function initialize_grid($uid){
      
      $rResult=$this->model_loo->dataapplist($uid);

      $data['rResult']=$rResult;
      
      return $data;   
    }

    function looapplist(){
        
        $loo_id = $this->uri->segment(4);

        $data   = array(
                  'result'    => $this->model_loo->viewloo($loo_id),
                  'loo_id'   => $loo_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['unit'] = $this->unit_select();
		
		$this->breadcrumbcomponent->add('LOO BTS Approval','loo_bts/looapplist');

        $this->load->view('template/v_header');
        $this->load->view('loo_bts/loo_applist', $data);
        $this->load->view('template/v_footer');
    }

    function controler_gridlist(){

        $u_id = empty($_GET['uid']) ? '' : $_GET['uid'];
        $u_id = trim($u_id);

        $vResult=$this->initialize_grid($u_id);
        $rResult=$vResult['rResult'];
        //$output=$vResult['output'];        

        foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['loo_id']);
            $rek_name = substr($aRow['rekanan_name'], 0, 15) . '...';

            $row = array();
                    $row[]=$aRow['loo_id'];
                    $row[]=date("d-m-Y", strtotime($aRow['loo_date']));
                    //$row[]=date("d-m-Y", strtotime($aRow['loo_sdate']));
                    //$row[]=date("d-m-Y", strtotime($aRow['loo_edate']));
                    $row[]=$aRow['loo_term'];
                    $row[]=$aRow['region_nameshort'];
                    $row[]=$aRow['branch_name'];
                    $row[]=$rek_name;
                    $row[]=$aRow['rekananshipping_name'];                    
                   // $row[]=$aRow['unit_name'];
                    $row[]=$aRow['region_id'];
                    $row[]=$aRow['branch_id'];
                    $row[]=$aRow['unit_id'];
                    $row[]='<a href="/index.php/loo_bts/loo/looview/looapp/'.$i_link.'" data-toggle="tooltip" title="Edit">
                    <i class="fa fa-edit fa-lg"></i></a>';
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

    function loo_app(){

        if ($_POST){

           $_APP = empty($_POST['postid']) ? '' : $_POST['postid'];
           $password = empty($_POST['pwd']) ? '' : $_POST['pwd'];
           
        }

        // Treat input as username
        $type = 'username';

        $username = $this->session->userdata('username');        

        if($this->_validate_login($username, $password, $type))
        {    
            
            if ($this->model_loo->approveloo($_APP))
            {
                $result['success'] = TRUE;
            }else{
                $result['success'] = FALSE;
            }

            $result['data'] = array('id' => $_APP[0][0]);
            echo json_encode($result);
        }
        else
        {                        
            // Set data auth_failed to let view know authentication failed
            $result['success'] = FALSE;     
            $result['data'] = array('id' => $_APP[0][0]);
            echo json_encode($result);       
        }        
        
    }

    private function _validate_login($username, $password, $type) {        

        // type is username or email
        $this->load->model("login/mdl_login");
        $this->mdl_login->set_table("master_user");           
       
        $queryUsers = $this->mdl_login->get_where_custom($type, $username);

        foreach($queryUsers->result() as $row)
        {
            $username = $row->username;
            $user_fullname = $row->user_fullname;
            $user_password = $row->user_password;
            $user_isnew = $row->user_isnew;
            $user_level = $row->user_level;
            $branch_id = $row->branch_id;
        }        
        
        if(md5($password) == $user_password)
        {              
            // Successful login
            return TRUE;
        }
        else
        {
            // Invalid password
            return FALSE;
        }
    }

}