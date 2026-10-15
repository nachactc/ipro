<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_QR extends CI_Model{

    function __construct(){
        parent::__construct();
    }

function getrekananshippingname($id){
  $sql="select rekananshipping_name from master_rekananshipping as A left join master_regionbranch as B on A.branch_id = B.branch_id where rekanan_id +convert(varchar(5), rekananshipping_line) + '_' +  A.branch_id + '_' +  region_id  = '$id'"; 
  return $this->db->query($sql)->row_array();  
 }
 
function getrekananshipping($id){
  $sql="select top 100 rekanan_id, rekananshipping_name, rekananshipping_address from master_rekananshipping"; 
  return $this->db->query($sql)->result_array();
 }
 
function getdataagreement($id) {
	    $stored_pocedure = "EXEC lm03_RptQRcode_SelectData '$id'";
    $result = $this->db->query($stored_pocedure);
    return $result; 
}
	function getperiode($id) {
	    $stored_pocedure = "EXEC lm03_QRCode_GetPeriode '$id'";
    $result = $this->db->query($stored_pocedure);
    return $result->row_array();
	}	
}
