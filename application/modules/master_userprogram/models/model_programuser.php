<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_programuser extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
  
    function qry_alldatalist($limit,$top,$sWhere){
	//echo var_dump($sWhere);
    // $sWhere = empty($sWhere) ? " WHERE program_isdisabled = 0" : $sWhere." AND program_isdisabled = 0";

	   $qry=" 
			SELECT * FROM (
			select top $limit CTE.*,ROW_NUMBER() OVER (ORDER BY CTE.program_id desc) as RowNumber,
			  b.group_name,c.program_title
			  from master_programgroupweb CTE
			  left join master_groupweb b on CTE.group_id = b.group_id
			  left join master_programweb c on CTE.program_id = c.program_id
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
			select CTE.*,ROW_NUMBER() OVER (ORDER BY CTE.program_id desc) as RowNumber,
			  b.group_name,c.program_title
			  from master_programgroupweb CTE
			  left join master_groupweb b on CTE.group_id = b.group_id
			  left join master_programweb c on CTE.program_id = c.program_id
				$sWhere  
			  ) AS V";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalllist(){
	   $qry="select count(group_id) as jml from master_programgroupweb";
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
   
	function delete($group_id,$username)
	{
		$this->db->where('group_id', $group_id); 
		$this->db->where('username', $username); 
		$this->db->delete('master_userprogramweb');
	}
		
   function insertgroup($group_id, $program_id)
    {
 
        $data = array(
			'group_id' => $group_id,
			'program_id' => $program_id
		);
		 
		$this->db->insert('master_programgroupweb', $data);
		 	
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
	
	function getProgram()
	{ 
       
        $result = $this->db->get('master_programweb')
                           ->result();
		$ret ['']= 'Pilih Program Web :';
       if($result)
			{
				foreach ($result as $key => $row)
				{
					$ret [$row->program_id] = $row->program_title;
				}
			}
		return $ret; 
	}
	
	function getUsername()
	{ 
       
        $result = $this->db->get('master_user')
                           ->result();
		$ret ['']= 'Pilih User :';
       if($result)
			{
				foreach ($result as $key => $row)
				{
					$ret [$row->username] = $row->username.' - '.$row->user_fullname;
				}
			}
		return $ret; 
	}	

	function getData_programUser($username,$group_id)
	{
		$query = "
				select a.*,c.group_id,c.group_name,d.username,(case when ISNULL(d.program_id,'') <> '' then 1 else 0 end ) as flag
				from master_programweb a
				left join master_programgroupweb b on a.program_id = b.program_id 
				left join master_groupweb c on b.group_id = c.group_id
				left join master_userprogramweb d on d.program_id = a.program_id and d.username = '$username'
				where a.program_isdisabled = 0 
				and b.group_id = '$group_id'
			";
		$hasil = $this->db->query($query);
		if($hasil->num_rows() > 0)
		{
			return $hasil->result();
		}	
		
	}
	
	function saveData_programUser($username,$group_id,$program_id)
	{ 
		 $data = array(
			'group_id' => $group_id,
			'program_id' => $program_id,
			'username' => $username
		);
		 
		$this->db->insert('master_userprogramweb', $data);
		
	}
}
