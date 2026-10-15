<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_jurnalsummary extends CI_Model{
    
  function __construct(){
      parent::__construct();
  }

  function  get_region(){ 
        return $this->db->query("select * from master_region order by region_name asc")->result();
  }
  
  function get_acc(){
	  return $this->db->query("select acc_id,acc_id + '-' + acc_name as vacc_name from master_acc order by acc_name asc")->result();
  }
  
  
function getspsumarybulananregion($_date,$criteria){
	
	if (strlen($criteria) > 1){
		$criteria=$criteria;
	}else{
		$criteria="";	
	}
	 $v_param = "EXEC cp_RptJurnalsummary_SelectByRegionweb 'TCP','001','{$_date}','{$criteria}' ";
	
	 return $this->db->query("$v_param")->result();
		
	}
	
	function getspdetilbulananregion($_date,$criteria){
	
	if (strlen($criteria) > 1){
		$criteria=$criteria;
	}else{
		$criteria="";	
	}
	 $v_param = "EXEC cp_RptJurnalDetilSummary_SelectByRegionweb 'TCP','001','{$_date}' ";
	
	return $this->db->query($v_param)->result();
	 
		
	}

	function getspdetilbulananregionloop($_date,$criteria){
if (strlen($criteria) > 1){
		$criteria=$criteria;
	}else{
		$criteria="";	
	}
	 $v_param = "EXEC cp_RptJurnalDetilSummary_SelectByRegionwebloop  'TCP','001','{$_date}','{$criteria}' ";
	
	 return $this->db->query("$v_param")->result();
		
	}
  function  get_branchbyregion($region_id){ 
        return $this->db->query("
          select B.branch_name  
          from master_regionbranch A
              left join master_branch B ON A.branch_id = B.branch_id 
          where A.region_id = '$region_id' ")->result();
  }
 
 
         
}