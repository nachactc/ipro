<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Amortize extends CI_Controller{

	function __construct(){
        
        parent::__construct();        
        // Check login and make sure email has been verified
        check_user_login();
        
        $this->load->model('model_amortize');
		$this->load->library('breadcrumbcomponent');
    }

    function index(){
        redirect('amortize/amortize/amortizelist');
    }
    
    function globalsearch_list(){
       $arcari=array('agreement_id',  'CTE.region_id','CTE.rekanan_id','BRANCH.branch_name','REKAN.rekanan_name','BRAND.rekananshipping_name');
		return $arcari;
    }
    function initialize_grid($id){
      
      $rResult=$this->model_amortize->dataapplist($id);

      $data['rResult']=$rResult;
      
      return $data;   
    }
	
	   function initialize_gridenable($id){
      
      $rResult=$this->model_amortize->dataapplistenable($id);

      $data['rResult']=$rResult;
      
      return $data;   
    }

    function amortizelist(){
        
        $agreement_id = $this->uri->segment(4);

        $data   = array(
                  'result'          => $this->model_amortize->viewagreement($agreement_id),
                  'agreement_id'    => $agreement_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['unit'] = $this->unit_select();
		
		$this->breadcrumbcomponent->add('Amortize','amortize/amortize/amortizelist');

        $this->load->view('template/v_header');
        $this->load->view('amortize/amortizelist', $data);
        $this->load->view('template/v_footer');
    }
	
	function amortizelistdisapp(){
        
        $agreement_id = $this->uri->segment(4);

        $data   = array(
                  'result'          => $this->model_amortize->viewagreement($agreement_id),
                  'agreement_id'    => $agreement_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['unit'] = $this->unit_select();
		
		$this->breadcrumbcomponent->add('Amortize UnPosting','amortize/amortize/amortizelistdisapp');

        $this->load->view('template/v_header');
        $this->load->view('amortize/amortizelistdisapp', $data);
        $this->load->view('template/v_footer');
    }


function amortizelistdisable(){
        
        $agreement_id = $this->uri->segment(4);

        $data   = array(
                  'result'          => $this->model_amortize->viewagreement($agreement_id),
                  'agreement_id'    => $agreement_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['unit'] = $this->unit_select();
		
		$this->breadcrumbcomponent->add('Amortize Disable','amortize/amortize/amortizelistdisapp');

        $this->load->view('template/v_header');
        $this->load->view('amortize/amortizelistdisable', $data);
        $this->load->view('template/v_footer');
    }
	
	function amortizelistenable(){
        
        $agreement_id = $this->uri->segment(4);

        $data   = array(
                  'result'          => $this->model_amortize->viewagreement($agreement_id),
                  'agreement_id'    => $agreement_id
            );        
        
        $data['region'] = $this->region_select();
        $data['branch'] = $this->branch_select();
        $data['unit'] = $this->unit_select();
		
		$this->breadcrumbcomponent->add('Amortize Enable','amortize/amortize/amortizelistdisapp');

        $this->load->view('template/v_header');
        $this->load->view('amortize/amortizelistenable', $data);
        $this->load->view('template/v_footer');
    }
function cekstatus_ag($agreement_id){ 
	$tsq="";
	$rsult=$this->model_amortize->qrycekstatus_ag($agreement_id);
	foreach ($rsult as $aRow) {
		$nm="<b>".$aRow->strukturunitapprovalauth_name."</b>";
		if ($aRow->verification=='VERIFIED'){
			$veri="<b><font color='#00CC00'>".$aRow->verification."</font></b>";
		}else{
		$veri="<b><font color='red'>".$aRow->verification."</font></b>";
		}
		$tsq=$tsq."".$nm." :".$veri."&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	return $tsq;
	
}


    function controler_gridlist(){  
		//$regionid='050';
		$id=empty($_GET['uid']) ? "":trim($_GET['uid']);	
		$regionid=empty($_GET['sRegion']) ? "":trim($_GET['sRegion']);	
		$vstore=empty($_GET['sStore']) ? "":trim($_GET['sStore']);	
		$vagid=empty($_GET['sID']) ? "":trim($_GET['sID']);	
		//echo $_GET['sRegion'];exit();
		$vstrade=empty($_GET['sTrade']) ? "":trim($_GET['sTrade']);	
		$vssline=empty($_GET['ssline']) ? "":trim($_GET['ssline']);	
		
		$vssdate=empty($_GET['ssdate']) ? "":trim($_GET['ssdate']);
		$vsedate=empty($_GET['sedate']) ? "":trim($_GET['sedate']);
		$stenant=empty($_GET['stenant']) ? "":trim($_GET['stenant']);
		
		//scheduleamortisasidetil_ischecked
		//$criteria="scheduleamortisasidetil_isposted=0 and scheduleamortisasidetil_isproforma=1";
		$criteria="scheduleamortisasidetil_isposted=0 and scheduleamortisasidetil_ischecked=1";
		$ceknil=0;
		if ($id!==""){
			$criteria =$criteria." and b.scheduleamortisasi_id=''$id''";
			$ceknil=1;
		}

		if (($regionid!=="") and ($regionid!=="null")){
			$criteria =$criteria." AND  ( a.region_id=''$regionid'')";
			$ceknil=1;
		}
		
		if (($vstore!=="")and ($vstore!=="null")){
			$criteria =$criteria." AND  ( a.branch_id=''$vstore'')";
			$ceknil=1;
		}
		if (($vstrade!=="")and ($vstrade!=="null") and ($vssline!=="")and ($vssline!=="null")){
			$criteria =$criteria." AND  ( a.rekanan_id=''$vstrade'') AND  ( a.rekananshipping_line=''$vssline'')";
			$ceknil=1;
		}
		
		if (($stenant!=="")and ($stenant!=="null") and (($vssline=="")or ($vssline=="null"))){
			$criteria =$criteria." AND  ( a.rekanan_id=''$stenant'')";
			$ceknil=1;
		}
		
		if (($vssdate!=="")and ($vssdate!=="null") and ($vsedate!=="")and ($vsedate!=="null")){
			$criteria =$criteria." AND convert(nvarchar(10),scheduleamortisasidetil_date,120) between  ''$vssdate'' and ''$vsedate'' ";
			$ceknil=1;
		}
		if ($vagid!==""){
			$criteria =$criteria." and a.ref_id=''$vagid''";
			$ceknil=1;
		}
		//echo $criteria;exit();
		if ($ceknil==0){
			$criteria =$criteria." and b.scheduleamortisasi_id=''8890''";
			
		}
		
        $vResult=$this->initialize_grid($criteria);
        $rResult=$vResult['rResult'];
        //$output=$vResult['output'];        
//$tes="Mulyadi :Done \\nAbu Harris : Not Yet";
//$tes="Mulyadi :Done , Abu Harris : Not Yet";
        foreach ($rResult as $aRow) {

            $i_link = $aRow['scheduleamortisasi_id'];
            $rek_name ='';
           $hsl=$aRow['scheduleamortisasi_id'];
            $row = array();
                    $row[]='';
                    $row[]=$aRow['scheduleamortisasi_id'];
                    $row[]=$aRow['agreementtype_id'];
                    $row[]=$aRow['scheduleamortisasidetil_line'];
					$row[]=$aRow['ref_id'];  
                    $row[]=$aRow['agreementtype_name'];                   
                    $row[]=$aRow['rekanan_name'];
                    $row[]=$aRow['rekananshipping_name'];  
                    $row[]=date("d-m-Y", strtotime($aRow['scheduleamortisasidetil_date']));
                    $row[]=number_format($aRow['scheduleamortisasidetil_idr'],2);
                    $row[]=$aRow['scheduleamortisasidetil_descr'];
                    $row[]=$aRow['scheduleamortisasidetil_proforma'];  

                    //$row[]=date("d-m-Y", strtotime($aRow['agreement_startdate']));
                    //$row[]=date("d-m-Y", strtotime($aRow['agreement_enddate']));
                    
                   
            if (!empty($row)) { $output['data'][] = $row; }
        }        
        
        echo json_encode($output);

}


function controler_gridlistdisapp(){  
		//$regionid='050';
		$id=empty($_GET['uid']) ? "":trim($_GET['uid']);	
		$regionid=empty($_GET['sRegion']) ? "":trim($_GET['sRegion']);	
		$vstore=empty($_GET['sStore']) ? "":trim($_GET['sStore']);	
		$vagid=empty($_GET['sID']) ? "":trim($_GET['sID']);	
		//echo $_GET['sRegion'];exit();
		$vstrade=empty($_GET['sTrade']) ? "":trim($_GET['sTrade']);	
		$vssline=empty($_GET['ssline']) ? "":trim($_GET['ssline']);	
		
		$vssdate=empty($_GET['ssdate']) ? "":trim($_GET['ssdate']);
		$vsedate=empty($_GET['sedate']) ? "":trim($_GET['sedate']);
		$stenant=empty($_GET['stenant']) ? "":trim($_GET['stenant']);
		
		
		
		$criteria="scheduleamortisasidetil_isposted=1";
		if ($id!==""){
			$criteria =$criteria." and b.scheduleamortisasi_id=''$id''";
		}

		if (($regionid!=="") and ($regionid!=="null")){
			$criteria =$criteria." AND  ( a.region_id=''$regionid'')";
		}
		
		if (($vstore!=="")and ($vstore!=="null")){
			$criteria =$criteria." AND  ( a.branch_id=''$vstore'')";
		}
		if (($vstrade!=="")and ($vstrade!=="null") and ($vssline!=="")and ($vssline!=="null")){
			$criteria =$criteria." AND  ( a.rekanan_id=''$vstrade'') AND  ( a.rekananshipping_line=''$vssline'')";
		}
		
		if (($stenant!=="")and ($stenant!=="null") and (($vssline=="")or ($vssline=="null"))){
			$criteria =$criteria." AND  ( a.rekanan_id=''$stenant'')";
		}
		
		if (($vssdate!=="")and ($vssdate!=="null") and ($vsedate!=="")and ($vsedate!=="null")){
			$criteria =$criteria." AND convert(nvarchar(10),scheduleamortisasidetil_date,120) between  ''$vssdate'' and ''$vsedate'' ";
		}
		if ($vagid!==""){
			$criteria =$criteria." and a.ref_id=''$vagid''";
		}
		//echo $criteria;exit();
		
        $vResult=$this->initialize_grid($criteria);
        $rResult=$vResult['rResult'];
        //$output=$vResult['output'];        
//$tes="Mulyadi :Done \\nAbu Harris : Not Yet";
//$tes="Mulyadi :Done , Abu Harris : Not Yet";
        foreach ($rResult as $aRow) {

            $i_link = $aRow['scheduleamortisasi_id'];
            $rek_name ='';
           $hsl=$aRow['scheduleamortisasi_id'];
            $row = array();
                    $row[]='';
                    $row[]=$aRow['scheduleamortisasi_id'];
                    $row[]=$aRow['agreementtype_id'];
                    $row[]=$aRow['scheduleamortisasidetil_line'];
					$row[]=$aRow['ref_id'];  
                    $row[]=$aRow['agreementtype_name'];                   
                    $row[]=$aRow['rekanan_name'];
                    $row[]=$aRow['rekananshipping_name'];  
                    $row[]=date("d-m-Y", strtotime($aRow['scheduleamortisasidetil_date']));
                    $row[]=number_format($aRow['scheduleamortisasidetil_idr'],2);
                    $row[]=$aRow['scheduleamortisasidetil_descr'];
                    $row[]=$aRow['scheduleamortisasidetil_proforma'];  

                    //$row[]=date("d-m-Y", strtotime($aRow['agreement_startdate']));
                    //$row[]=date("d-m-Y", strtotime($aRow['agreement_enddate']));
                    
                   
            if (!empty($row)) { $output['data'][] = $row; }
        }        
        
        echo json_encode($output);

}

function controler_gridlistdisable(){  
		//$regionid='050';
		$id=empty($_GET['uid']) ? "":trim($_GET['uid']);	
		$regionid=empty($_GET['sRegion']) ? "":trim($_GET['sRegion']);	
		$vstore=empty($_GET['sStore']) ? "":trim($_GET['sStore']);	
		$vagid=empty($_GET['sID']) ? "":trim($_GET['sID']);	
		//echo $_GET['sRegion'];exit();
		$vstrade=empty($_GET['sTrade']) ? "":trim($_GET['sTrade']);	
		$vssline=empty($_GET['ssline']) ? "":trim($_GET['ssline']);	
		
		$vssdate=empty($_GET['ssdate']) ? "":trim($_GET['ssdate']);
		$vsedate=empty($_GET['sedate']) ? "":trim($_GET['sedate']);
		$stenant=empty($_GET['stenant']) ? "":trim($_GET['stenant']);
		
		
		
		$criteria="ISNULL(scheduleamortisasidetil_isdisabled,0)=0";
		if ($id!==""){
			$criteria =$criteria." and b.scheduleamortisasi_id=''$id''";
		}

		if (($regionid!=="") and ($regionid!=="null")){
			$criteria =$criteria." AND  ( a.region_id=''$regionid'')";
		}
		
		if (($vstore!=="")and ($vstore!=="null")){
			$criteria =$criteria." AND  ( a.branch_id=''$vstore'')";
		}
		if (($vstrade!=="")and ($vstrade!=="null") and ($vssline!=="")and ($vssline!=="null")){
			$criteria =$criteria." AND  ( a.rekanan_id=''$vstrade'') AND  ( a.rekananshipping_line=''$vssline'')";
		}
		
		if (($stenant!=="")and ($stenant!=="null") and (($vssline=="")or ($vssline=="null"))){
			$criteria =$criteria." AND  ( a.rekanan_id=''$stenant'')";
		}
		
		if (($vssdate!=="")and ($vssdate!=="null") and ($vsedate!=="")and ($vsedate!=="null")){
			$criteria =$criteria." AND convert(nvarchar(10),scheduleamortisasidetil_date,120) between  ''$vssdate'' and ''$vsedate'' ";
		}
		if ($vagid!==""){
			$criteria =$criteria." and a.ref_id=''$vagid''";
		}
		//echo $criteria;exit();
		
        $vResult=$this->initialize_grid($criteria);
        $rResult=$vResult['rResult'];
        //$output=$vResult['output'];        
//$tes="Mulyadi :Done \\nAbu Harris : Not Yet";
//$tes="Mulyadi :Done , Abu Harris : Not Yet";
        foreach ($rResult as $aRow) {

            $i_link = $aRow['scheduleamortisasi_id'];
            $rek_name ='';
           $hsl=$aRow['scheduleamortisasi_id'];
            $row = array();
                    $row[]='';
                    $row[]=$aRow['scheduleamortisasi_id'];
                    $row[]=$aRow['agreementtype_id'];
                    $row[]=$aRow['scheduleamortisasidetil_line'];
					$row[]=$aRow['ref_id'];  
                    $row[]=$aRow['agreementtype_name'];                   
                    $row[]=$aRow['rekanan_name'];
                    $row[]=$aRow['rekananshipping_name'];  
                    $row[]=date("d-m-Y", strtotime($aRow['scheduleamortisasidetil_date']));
                    $row[]=number_format($aRow['scheduleamortisasidetil_idr'],2);
                    $row[]=$aRow['scheduleamortisasidetil_descr'];
                    $row[]=$aRow['scheduleamortisasidetil_proforma'];  

                    //$row[]=date("d-m-Y", strtotime($aRow['agreement_startdate']));
                    //$row[]=date("d-m-Y", strtotime($aRow['agreement_enddate']));
                    
                   
            if (!empty($row)) { $output['data'][] = $row; }
        }        
        
        echo json_encode($output);

}

function controler_gridlistenable(){  
		//$regionid='050';
		$id=empty($_GET['uid']) ? "":trim($_GET['uid']);	
		$regionid=empty($_GET['sRegion']) ? "":trim($_GET['sRegion']);	
		$vstore=empty($_GET['sStore']) ? "":trim($_GET['sStore']);	
		$vagid=empty($_GET['sID']) ? "":trim($_GET['sID']);	
		//echo $_GET['sRegion'];exit();
		$vstrade=empty($_GET['sTrade']) ? "":trim($_GET['sTrade']);	
		$vssline=empty($_GET['ssline']) ? "":trim($_GET['ssline']);	
		
		$vssdate=empty($_GET['ssdate']) ? "":trim($_GET['ssdate']);
		$vsedate=empty($_GET['sedate']) ? "":trim($_GET['sedate']);
		$stenant=empty($_GET['stenant']) ? "":trim($_GET['stenant']);
		
		
		
		$criteria="ISNULL(scheduleamortisasidetil_isdisabled,0)=1";
		if ($id!==""){
			$criteria =$criteria." and b.scheduleamortisasi_id=''$id''";
		}

		if (($regionid!=="") and ($regionid!=="null")){
			$criteria =$criteria." AND  ( a.region_id=''$regionid'')";
		}
		
		if (($vstore!=="")and ($vstore!=="null")){
			$criteria =$criteria." AND  ( a.branch_id=''$vstore'')";
		}
		if (($vstrade!=="")and ($vstrade!=="null") and ($vssline!=="")and ($vssline!=="null")){
			$criteria =$criteria." AND  ( a.rekanan_id=''$vstrade'') AND  ( a.rekananshipping_line=''$vssline'')";
		}
		
		if (($stenant!=="")and ($stenant!=="null") and (($vssline=="")or ($vssline=="null"))){
			$criteria =$criteria." AND  ( a.rekanan_id=''$stenant'')";
		}
		
		if (($vssdate!=="")and ($vssdate!=="null") and ($vsedate!=="")and ($vsedate!=="null")){
			$criteria =$criteria." AND convert(nvarchar(10),scheduleamortisasidetil_date,120) between  ''$vssdate'' and ''$vsedate'' ";
		}
		if ($vagid!==""){
			$criteria =$criteria." and a.ref_id=''$vagid''";
		}
		//echo $criteria;exit();
		
        $vResult=$this->initialize_gridenable($criteria);
        $rResult=$vResult['rResult'];
        //$output=$vResult['output'];        
//$tes="Mulyadi :Done \\nAbu Harris : Not Yet";
//$tes="Mulyadi :Done , Abu Harris : Not Yet";
        foreach ($rResult as $aRow) {

            $i_link = $aRow['scheduleamortisasi_id'];
            $rek_name ='';
           $hsl=$aRow['scheduleamortisasi_id'];
            $row = array();
                    $row[]='';
                    $row[]=$aRow['scheduleamortisasi_id'];
                    $row[]=$aRow['agreementtype_id'];
                    $row[]=$aRow['scheduleamortisasidetil_line'];
					$row[]=$aRow['ref_id'];  
                    $row[]=$aRow['agreementtype_name'];                   
                    $row[]=$aRow['rekanan_name'];
                    $row[]=$aRow['rekananshipping_name'];  
                    $row[]=date("d-m-Y", strtotime($aRow['scheduleamortisasidetil_date']));
                    $row[]=number_format($aRow['scheduleamortisasidetil_idr'],2);
                    $row[]=$aRow['scheduleamortisasidetil_descr'];
                    $row[]=$aRow['scheduleamortisasidetil_proforma'];  

                    //$row[]=date("d-m-Y", strtotime($aRow['agreement_startdate']));
                    //$row[]=date("d-m-Y", strtotime($aRow['agreement_enddate']));
                    
                   
            if (!empty($row)) { $output['data'][] = $row; }
        }        
        
        echo json_encode($output);

}


function gotosop(){
$data['schedule_id']=$this->uri->segment(4);
$data['button']='PREVIEW';
$this->load->view('agreementverify/agreement_gotosop', $data);
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

    function agreement_app(){        

        if ($_POST){

           $_APP = empty($_POST['postid']) ? '' : $_POST['postid'];           
        }

        // Treat input as username
        $type = 'username';

        $username   = $this->session->userdata('username');  
        $channel_id = $this->session->userdata('channel_id');             
            
        if ($this->model_amortize->approveagreement($_APP, $username, $channel_id))
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
	
	function agreement_disapp(){        

        if ($_POST){

           $_APP = empty($_POST['postid']) ? '' : $_POST['postid'];           
        }

        // Treat input as username
        $type = 'username';

        $username   = $this->session->userdata('username');  
        $channel_id = $this->session->userdata('channel_id');             
            
        if ($this->model_amortize->disapproveagreement($_APP, $username, $channel_id))
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
	
	function agreement_disable(){        

        if ($_POST){

           $_APP = empty($_POST['postid']) ? '' : $_POST['postid'];           
        }

        // Treat input as username
        $type = 'username';

        $username   = $this->session->userdata('username');  
        $channel_id = $this->session->userdata('channel_id');             
            
        if ($this->model_amortize->disableeagreement($_APP, $username, $channel_id))
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
	
	function agreement_enable(){        

        if ($_POST){

           $_APP = empty($_POST['postid']) ? '' : $_POST['postid'];           
        }

        // Treat input as username
        $type = 'username';

        $username   = $this->session->userdata('username');  
        $channel_id = $this->session->userdata('channel_id');             
            
        if ($this->model_amortize->enableagreement($_APP, $username, $channel_id))
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