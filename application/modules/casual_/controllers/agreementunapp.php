<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agreementunapp extends CI_Controller{

	function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_agreement');
		$this->load->library('breadcrumbcomponent');
    }

    function index(){
        redirect('agreement/agreementunapp/agreementunapplist');
    }
    
    function globalsearch_list(){
       $arcari=array('agreement_id',  'CTE.region_id','CTE.rekanan_id','BRANCH.branch_name','REKAN.rekanan_name','BRAND.rekananshipping_name');
		return $arcari;
    }
    function initialize_grid(){
      
      $rResult=$this->model_agreement->dataunapplist();

      $data['rResult']=$rResult;
      
      return $data;   
    }

    function agreementunapplist(){
        
        $agreement_id = $this->uri->segment(4);

        $data   = array(
                  'result'          => $this->model_agreement->viewagreement($agreement_id),
                  'agreement_id'    => $agreement_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['unit'] = $this->unit_select();
		
		$this->breadcrumbcomponent->add('Agreement Transaction Unposting','agreement/agreementunapp/agreementunapplist');

        $this->load->view('template/v_header');
        $this->load->view('agreement/agreement_unapplist', $data);
        $this->load->view('template/v_footer');
    }

    function controler_gridlist(){   

        $vResult=$this->initialize_grid();
        $rResult=$vResult['rResult'];
        //$output=$vResult['output'];        

        foreach ($rResult as $aRow) {

            $i_link = str_replace('/', '_', $aRow['agreement_id']);
            $rek_name = substr($aRow['rekanan_name'], 0, 15) . '...';
           
            $row = array();
                    $row[]=$aRow['agreement_id'];
                    $row[]=$aRow['agreement_isrenewal'];
                    $row[]=$aRow['agreement_isapproved'];
                    $row[]=$aRow['agreement_isclosed'];                    
                    $row[]=$rek_name;
                    $row[]=$aRow['rekananshipping_name'];  
                    $row[]=$aRow['agreement_contractno'];  
                    $row[]=$aRow['region_nameshort'];
                    $row[]=$aRow['branch_name'];
                    $row[]=$aRow['agreement_contractlongnumber'];  
                    $row[]=date("d-m-Y", strtotime($aRow['agreement_startdate']));
                    $row[]=date("d-m-Y", strtotime($aRow['agreement_enddate']));
                    $row[]=$aRow['agreement_term'];  
                    $row[]=$aRow['agreement_idr'];  
                    $row[]=$aRow['agreement_tlv'];  
                    $row[]=$aRow['agreement_descr'];  
                    $row[]=$aRow['agreement_createby'];  
                    $row[]=$aRow['agreement_createdate'];  
                    $row[]=$aRow['agreement_modifyby'];  
                    $row[]=$aRow['agreement_modifydate']; 
                    $row[]='
                    <a href="/index.php/agreementprint/agreementprint/agreementprintpdf/'.$i_link.'" data-toggle="tooltip" title="Print" target="_blank">
                    <i class="fa fa-print fa-lg"></i></a>';
                    $row[]=$aRow['ref_id'];
                    $row[]=$aRow['agreement_renewalno'];
                   
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

    function agreement_unapp(){

        if ($_POST){

           $_APP = empty($_POST['postid']) ? '' : $_POST['postid'];
           //$password = empty($_POST['pwd']) ? '' : $_POST['pwd'];           
           
        }

        // Treat input as username
        $type = 'username';

        $username   = $this->session->userdata('username');  
        $channel_id = $this->session->userdata('channel_id');             
            
        if ($this->model_agreement->unapproveagreement($_APP, $username, $channel_id))
        {                    

            $result['success'] = TRUE;
            $result['data'] = array('id' => $_APP[0][0]);
            echo json_encode($result);
        }else{
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