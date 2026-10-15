<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class QR extends CI_Controller{

    function __construct(){

        parent::__construct();
        // Check login and make sure email has been verified
       

        $this->load->model('model_QR');
		$this->load->library('breadcrumbcomponent');
		$this->load->library('form_validation');
		$this->session->keep_flashdata('message');
    }

    function index(){
		 check_user_login();
        redirect('QR/QR/QRGenerate');
    }
	
    function QRGenerate(){
 check_user_login();
        $QRID = $this->uri->segment(4);
		
		$data['qrid'] = $QRID;
		
		$rekanansipping			=	$this->model_QR->getrekananshippingname($QRID);
        $rekanansippingname		=	$rekanansipping['rekananshipping_name'];
		$periode		=	$this->model_QR->getperiode($QRID);
		$start_date		=	$periode['agreement_startdate'];
		$end_date		=	$periode['agreement_enddate'];
		// print_r($periode);
		// exit;
		//echo $start_date;
		//exit;
		// echo $start_date;
		// exit;
		$data['rekanansipping_name'] = $rekanansippingname;
		//$data['periode'] = $periode;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
		
		// $html=$this->load->view('QR/rptQR_new', $data, true);	
		$this->load->view('QR/rptQR_new', $data);
		// $this->load->library('m_pdf');
        // $pdfFilePath = "qrcode.pdf";	

		// $this->m_pdf->pdf->SetHTMLHeader('<table width="100%"><tr><td align="right" style="font-size:10px"></td></tr></table>');
		// $this->m_pdf->pdf->AddPage('P','A4','','','',3,3,3,3,15,8);
        // $this->m_pdf->pdf->WriteHTML($html);
        // $this->m_pdf->pdf->Output($pdfFilePath, "I");
    }	
	
function getJson($val_search = ''){
		$searchStatus = $val_search;
		//echo $searchStatus;
		//exit();
    	$vResult =	$this->model_QR->getdataagreement($searchStatus);
		
		//print_r($vResult);
	//exit;
    	foreach ($vResult as $aRow) {
             
            $row = array();

			$row['rekanan_id']	=$aRow['rekanan_id'];
			$row['rekananshipping_line']	=$aRow['rekananshipping_line'];
			$row['rekananshipping_name']	=$aRow['rekananshipping_name'];
			$row['IsPosted']	=$aRow['isposted'];
			$row['ResultCode']	=$aRow['Resultcode'];
			$row['ResultMsg']	=$aRow['ResultMsg'];
			$row['ResultJson']	=$aRow['ResultJson'];
    	            
        	}   
        	echo json_encode($row);
    		
    }	
	  
	
    function uploadjpg(){
		 check_user_login();
        if($_POST) {

            $loo_id = $this->input->post('loo_id');
            $loo_id = str_replace('/', '_', $loo_id);


            if ($_FILES['files']['tmp_name']) {

                $allowed = array('jpg', 'jpeg', 'png','pdf');

                if(isset($_FILES['files']) && $_FILES['files']['error'] == 0){

                   // $extension = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION);
				   $temp = explode(".", $_FILES["files"]["name"]);
					$extension = end($temp);


                    if(!in_array(strtolower($extension), $allowed)){
                        echo '{"status":"error"}';
                        exit;
                    }

                    if(move_uploaded_file($_FILES['files']['tmp_name'], FCPATH.'/assets/uploads/'.$loo_id.'.'.$extension)){

                        //echo '{"status":"success"}';
                        $success = 1;
                    }
                }
            } else{
                $success = 0;
            }

        if ($success) {
            $result['files'][0] = array(
                'name'      => $loo_id.'.'.$extension,
                'size'      => 0,
                'url'       => base_url('/assets/uploads/'.$loo_id.'.'.$extension)
                );
        }else{
            $result['files'][0] = array(
                'error'     => 'Unknown format',
                'url'       => '',
                'size'      => 0
                );
        }

        echo json_encode($result);
        }
    }
//------------Tambahan ES------------------------
	function ceklogin() {

$response = array("error" => FALSE);
if (isset($_POST['email']) && isset($_POST['password'])) {
$email=$this->input->post('email');
$password=$this->input->post('password');

$user = $this->getUserByLogin($email, $password);
 if ($user !== false) {
        $response["error"] = FALSE;
        $response["user"]["nama"] = $user["user_fullname"];
        $response["user"]["username"] = $user["username"];
		$response["user"]["branch_id"] = $user["branch_id"];
		$response["user"]["branch_name"] = $user["branch_name"];
		$response["user"]["branchshort"] = $user["branchshort"];	
		$response["user"]["branch_type"] =$user["branch_type"];
		$response["user"]["strukturunit_id"] =$user["strukturunit_id"];
        echo json_encode($response);
    } else {
        $response["error"] = TRUE;
        $response["error_msg"] = "Login Failed. wrong username or password";
        echo json_encode($response);
 }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Username or Password is incorrect";
    echo json_encode($response);
}
}


function getUserByLogin($username, $password) {

$password=md5($password);
$sq=$this->db->query("SELECT top 1 master_user.*,master_branch.branch_id, master_branch.branch_name,left(master_branch.branch_name,3) as branchshort,master_branch.branch_type FROM master_user master_user 
inner join master_userbranch on master_user.username = master_userbranch.username 
inner join master_branch on master_userbranch.branch_id = master_branch.branch_id 
WHERE master_user.username='$username' and master_user.user_password='$password' and master_user.user_isdisabled=0");
$jm=$sq->num_rows();
if ($jm>0){
	return $sq->row_array();
}else{
	return false;	
}

}


function getDataORINV() {
	$spid=$this->input->post('spid');
	$data= explode("_" , $spid);
	$criteria=" rekanan_id+cast(rekananshipping_line as varchar)= ''$data[0]'' ";
	$spq= "EXEC cp_TrnJurnalORTRP_SelectInvoiceSingleWeb 'TSCB','$criteria','' ";
		//echo $spq;exit();
		$sq=$this->db->query($spq)->result();
		print_r (json_encode($sq));
}

function getrekanan() {

$response = array("error" => FALSE);
if (isset($_POST['rekanan_id'])) {
$rekanan_id=$this->input->post('rekanan_id');

$spid=$this->input->post('rekanan_id');
$data= explode("_" , $spid);
	
$rekanan = $this->arrekanan($data[0]);

//$criteria=" rekanan_id+cast(rekananshipping_line as varchar)= ''$data[0]'' ";
$criteria=" rekanan_id+cast(rekananshipping_line as varchar)+ ''_'' +  branch_id + ''_'' +  region_id=''$spid'' ";
$spq= "EXEC cp_TrnJurnalORTRP_SelectInvoiceSingleWebTotal 'TSCB','$criteria','' ";
$sq=$this->db->query($spq)->row_array();
$niltotal=$sq['totidr'];
 if ($rekanan !== false) {
        $response["error"] = FALSE;
        $response["rekanan"]["nama"] = $rekanan["rekananshipping_name"];
		$response["rekanan"]["niltotal"] =number_format($niltotal,0);
        echo json_encode($response);
    } else {
        $response["error"] = TRUE;
        $response["error_msg"] = "Rekanan ID salah";
        echo json_encode($response);
 }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Rekanan ID salah";
    echo json_encode($response);
}
}


function arrekanan($rekanan_id) {
$sq=$this->db->query("SELECT rekananshipping_name from master_rekananshipping where rekanan_id+cast(rekananshipping_line as varchar)='$rekanan_id'");
$jm=$sq->num_rows();
if ($jm>0){
	return $sq->row_array();
}else{
	return false;	
}

}

function getJsonqr(){
		$searchStatus = $this->input->post('criteria');

    	$vResult =	$this->model_QR->getdataagreement($searchStatus);
    	foreach ($vResult as $aRow) {
             $row = array();
			$row['rekanan_id']	=$aRow['rekanan_id'];
			$row['rekananshipping_line']	=$aRow['rekananshipping_line'];
			$row['rekananshipping_name']	=$aRow['rekananshipping_name'];
			$row['IsPosted']	=$aRow['isposted'];
			$row['ResultCode']	=$aRow['Resultcode'];
			$row['ResultMsg']	=$aRow['ResultMsg'];
        	}   
        echo json_encode($row);
}	


function getQRstatus() {

$response = array("error" => FALSE);
if (isset($_POST['criteria'])) {
$criteria=$this->input->post('criteria');
	
$jqr= $this->jsonqr($criteria);
 if ($jqr !== false) {
        $response["error"] = FALSE;
        $response["jqr"]["rekananshipping_name"] = $jqr["rekananshipping_name"];
		$response["jqr"]["resultcode"] = $jqr["Resultcode"];
		$response["jqr"]["resultMsg"] = $jqr["ResultMsg"];
        echo json_encode($response);
    } else {
        $response["error"] = TRUE;
        $response["error_msg"] = "Criteria salah";
        echo json_encode($response);
 }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Criteria salah";
    echo json_encode($response);
}
}


function jsonqr($criteria) {
$sq=$this->model_QR->getdataagreement($criteria);
$jm=$sq->num_rows();
if ($jm>0){
	return $sq->row_array();
}else{
	return false;	
}

}

//------------END------------------------
}
