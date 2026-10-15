<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_program extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
  
    function qry_alldatalist($limit,$top,$sWhere){
	//echo var_dump($sWhere);
    // $sWhere = empty($sWhere) ? " WHERE program_isdisabled = 0" : $sWhere." AND program_isdisabled = 0";

	   $qry=" 
			SELECT * FROM (
			select top $limit CTE.*,ROW_NUMBER() OVER (ORDER BY program_id desc) as RowNumber
			  FROM master_programweb AS CTE  
			  $sWhere 
			  ORDER BY CTE.program_id DESC
			  ) AS V
    	WHERE   RowNumber > $top";
      //echo $qry;
	   //exit;
	    return $this->db->query($qry)->result_array();
   }
   
    function qry_filteredlist($sWhere){
       //$sWhere = empty($sWhere) ? " WHERE program_isdisabled = 0" : $sWhere." AND program_isdisabled = 0";
	   $qry="SELECT count(*) as jml FROM (
			select CTE.*,ROW_NUMBER() OVER (ORDER BY program_id desc) as RowNumber 
			  FROM master_programweb AS CTE  
			  $sWhere 
			 
			  ) AS V";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalllist(){
	   $qry="select count(program_id) as jml from master_programweb";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function getoneprogram($program_id)
   {
		$this->db->where('program_id',$program_id);
		$query = $this->db->get('master_programweb');
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
   }
   
   function deleteprogram($program_id)
   {
		$this->db->where('program_id', $program_id);
		$this->db->delete('master_programweb');
		
		$this->db->where('program_id', $program_id);
		$this->db->delete('master_programgroupweb');
		
   }
   
   
   function insertprogram($program_id, $program_title, $program_icon, $program_url, $program_controller, $program_creator, $program_isdisabled,$group_id)
    {
		$last_id_program = 0;
		$id_prog = 0;
		//get last id program_id
		$query = "select top 1 program_id,CAST(ISNULL(RIGHT(program_id,3),0) as int) as last_id 
				  from master_programweb
				  where program_id like '$group_id%'
				  order by program_id desc";
		$hasil = $this->db->query($query);
		if($hasil->num_rows() > 0)
		{
			$datas = $hasil->row()->last_id;
			$last_id_program = $datas + 1;
			$last_id_program = sprintf("%'.03d",$last_id_program); 
			$id_prog = trim($group_id.$last_id_program);
		}
		else
		{
			$last_id_program = 1;
			$last_id_program = sprintf("%'.03d",$last_id_program); 
			$id_prog = trim($group_id.$last_id_program);
		}
			
		// echo $id_prog;
		// exit;	
			
		if($id_prog > 0)
		{
		
			$data = array(
				'program_id' => $id_prog,
				'program_title' => $program_title,
				'program_icon' => $program_icon,
				'program_url' => $program_url,
				'program_controller' => $program_controller,
				'program_isdisabled' => $program_isdisabled,
				'program_creator' => $program_creator,
			);
			 
			$this->db->insert('master_programweb', $data);
			
			$data_group = array(
				'group_id' => trim($group_id),
				'program_id' => trim($id_prog)
			);
			$this->db->insert('master_programgroupweb', $data_group);
		}
		else
		{
			echo "Program ID Kosong";
		}
			  
    }
    function updateprogram($program_id, $program_title, $program_icon, $program_url, $program_controller, $program_creator, $program_isdisabled)
    {


        $data = array(
			'program_title' => $program_title,
			'program_icon' => $program_icon,
			'program_url' => $program_url,
			'program_controller' => $program_controller,
			'program_isdisabled' => $program_isdisabled,
			'program_creator' => $program_creator,
		);
		$this->db->where('program_id',$program_id);
		$this->db->update('master_programweb', $data);
			  
    }
	
	function getGroup()
	{ 
       
        $result = $this->db->get('master_groupweb')
                           ->result();
		$ret ['']= 'Pilih Group Menu Web :';
        if($result)
			{
				foreach ($result as $key => $row)
				{
					$ret [$row->group_id] = $row->group_name;
				}
			}
		return $ret;  
	}
	  
}
