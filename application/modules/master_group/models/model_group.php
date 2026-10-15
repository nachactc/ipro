<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_group extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
  
    function qry_alldatalist($limit,$top,$sWhere){
	//echo var_dump($sWhere);
    // $sWhere = empty($sWhere) ? " WHERE program_isdisabled = 0" : $sWhere." AND program_isdisabled = 0";

	   $qry=" 
			SELECT * FROM (
			select top $limit CTE.*,ROW_NUMBER() OVER (ORDER BY group_id desc) as RowNumber
			  FROM master_groupweb AS CTE  
			  $sWhere 
			  ORDER BY CTE.group_id DESC
			  ) AS V
    	WHERE   RowNumber > $top";
      //echo $qry;
	   //exit;
	    return $this->db->query($qry)->result_array();
   }
   
    function qry_filteredlist($sWhere){
       //$sWhere = empty($sWhere) ? " WHERE program_isdisabled = 0" : $sWhere." AND program_isdisabled = 0";
	   $qry="SELECT count(*) as jml FROM (
			select CTE.*,ROW_NUMBER() OVER (ORDER BY group_id desc) as RowNumber 
			  FROM master_groupweb AS CTE  
			  $sWhere 
			 
			  ) AS V";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalllist(){
	   $qry="select count(group_id) as jml from master_groupweb";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function getonegroup($group_id)
   {
		$this->db->where('group_id',$group_id);
		$query = $this->db->get('master_groupweb');
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
   }
   
   function deletegroup($group_id)
   {
		$this->db->where('group_id', $group_id);
		$this->db->delete('master_groupweb');
   }
   
   
   function insertgroup($group_id, $group_name, $group_icon, $group_code, $group_isdisabled)
    {

		$group_isdisabled = $group_isdisabled != '' ? 1 :0;
        $data = array(
			'group_id' => $group_id,
			'group_name' => $group_name,
			'group_icon' => $group_icon,
			'group_code' => $group_code, 
			'group_isdisabled' => $group_isdisabled
		);
		 
		$this->db->insert('master_groupweb', $data);
			  
    }
    function updategroup($group_id, $group_name, $group_icon, $group_code, $group_isdisabled)
    {

		$group_isdisabled = $group_isdisabled != '' ? 1 :0;
        $data = array( 
			'group_name' => $group_name,
			'group_icon' => $group_icon,
			'group_code' => $group_code, 
			'group_isdisabled' => $group_isdisabled
		);
		
		
		$this->db->where('group_id',$group_id); 
		$this->db->update('master_groupweb', $data);
			  
    }
	
	  
}
