<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Looconf extends CI_Controller{

	function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_loo');
		$this->load->library('breadcrumbcomponent');
    }

    function index(){       
        redirect('loo/looconf/looconflist');
    }
    
    function globalsearch_list(){
        $arcari=array('unit_id');   
        return $arcari;
    }
    function initialize_grid($uid){

      $rResult=$this->model_loo->dataconf($uid);

      $data['rResult']=$rResult;
      
      return $data;    

    }

    function looconflist(){
        
        $loo_id = $this->uri->segment(4);

        $data   = array(
                  'result'    => $this->model_loo->viewloo($loo_id),
                  'loo_id'   => $loo_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['unit'] = $this->unit_select();
		
		$this->breadcrumbcomponent->add('LOO Permanent/Casual Doc.Return','loo/looconflist');

        $this->load->view('template/v_header');
        $this->load->view('loo/loo_conflist', $data);
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
                    $row[]=$aRow['unit_name'];
                    $row[]=$aRow['region_id'];
                    $row[]=$aRow['branch_id'];
                    $row[]=$aRow['unit_id'];
                    $row[]='
        <a href="/index.php/loo/loo/looview/looconf/'.$i_link.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>';
        
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

    function loo_conf(){

        if ($_POST){

           $_CON = empty($_POST['arrCon']) ? '' : $_POST['arrCon'];
           
        }       

        if ($this->model_loo->confirmloo($_CON))
        {
            $result['success'] = '1';
            $result['data'] = array('id' => $_CON[0][0]);
        }else{
            $result['success'] = '0';
            //$result['errors'] = array('action' => $action, 'msg' => $msg);
        }

        echo json_encode($result);
        
    }

}