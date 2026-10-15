<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_sourceacc extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
  
    function qry_alldatalist($limit,$top,$sWhere){
 
	   $qry=" 
			SELECT * FROM (
			select top $limit CTE.*,D.acc_name,ROW_NUMBER() OVER (ORDER BY source_id desc) as RowNumber
			  FROM master_source_acc AS CTE  
			  LEFT JOIN master_acc D ON CTE.acc_id = D.acc_id
			  $sWhere 
			  ORDER BY CTE.source_id DESC
			  ) AS V
    	WHERE   RowNumber > $top";
       // echo $qry;
	   // exit;
	    return $this->db->query($qry)->result_array();
   }
   
    function qry_filteredlist($sWhere){
       //$sWhere = empty($sWhere) ? " WHERE program_isdisabled = 0" : $sWhere." AND program_isdisabled = 0";
	   $qry="SELECT count(*) as jml FROM (
			select CTE.*,D.acc_name,ROW_NUMBER() OVER (ORDER BY source_id desc) as RowNumber 
			  FROM master_source_acc AS CTE  
			  LEFT JOIN master_acc D ON CTE.acc_id = D.acc_id
			  $sWhere 
			 
			  ) AS V";
			  
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalllist(){
	   $qry="select count(source_id) as jml from master_source_acc";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function getoneprogram($id)
   {
		$this->db->where('id_',$id);  
		$query = $this->db->get('master_source_acc');
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
   }
   
   function deleteprogram($id_)
   {
		$this->db->where('id_', $id_); 
		$this->db->delete('master_source_acc');  
   }
   
   
   function insertprogram($source_id, $acc_id, $dk)
    {  
		$username = $this->session->userdata('username');
		$tgl = date('Y-m-d');
		$data = array(
			'source_id' => $source_id,
			'acc_id' => $acc_id,
			'dk' => $dk 
		);
		 
		$this->db->insert('master_source_acc', $data); 
    }
    function updateprogram($source_id, $acc_id, $dk,$id_)
    {
		$username = $this->session->userdata('username');
		$tgl = date('Y-m-d');

        $data = array(
			'source_id' => $source_id,
			'acc_id' => $acc_id,
			'dk' => $dk 
		);
		$this->db->where('id_',$id_); 
		$this->db->update('master_source_acc', $data);
		// echo $this->db->last_query();
		// exit;
    }
	 
	  
}
