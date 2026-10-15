<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_acc extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
	function qry_alldatalist($limit,$top,$sWhere){
		// echo var_dump($sWhere);
		$sWhere = empty($sWhere) ? " " : $sWhere." ";

		$qry=" 
			SELECT * FROM (
			select top $limit CTE.*,ROW_NUMBER() OVER (ORDER BY acc_id asc) as RowNumber
			  FROM master_acc AS CTE     
			  $sWhere 
			  ORDER BY CTE.acc_id ASC
			  ) AS V
    		WHERE   RowNumber > $top";
		//echo $qry;
		//exit;
	    return $this->db->query($qry)->result_array();
   }
   

    function qry_filteredlist($sWhere){
       $sWhere = empty($sWhere) ? "  " : $sWhere." ";
	   $qry="SELECT count(*) as jml FROM (
			  select CTE.*,ROW_NUMBER() OVER (ORDER BY acc_id asc) as RowNumber
			  FROM master_acc AS CTE 
			  $sWhere 
			  ) AS V";
		return $this->db->query($qry)->row_array();
	   
   }
   

   function qry_totalalllist(){
		
		$qry="select count(acc_id) as jml from master_acc "; //where unittype_id <> 7 AND unittype_id <> 6
		return $this->db->query($qry)->row_array();
	   
   }
   
	function viewmaster_acc($acc_id){     

		if (isset($acc_id)){
			return $this->db->query("
				SELECT a.*
				  FROM  master_acc a
				  WHERE acc_id='$acc_id'
			")->row_array();        
		}else{       
			return false;
		}

	}

	function updateacc(){        
		if(!empty($_POST))
		{
			$acc_id = $this->input->post('acc_id');
			$acc_name = $this->input->post('acc_name');
			$acc_nameshort = $this->input->post('acc_nameshort');
			$acc_descr = $this->input->post('acc_descr');
			$acc_isgroup = ($this->input->post('acc_isgroup')) ? 1 : 0;
			$acc_parent = $this->input->post('acc_parent');
			$acc_path = $this->input->post('acc_path');
			$acc_isdisabled = ($this->input->post('acc_isdisabled')) ? 1 : 0;
			$acc_ismonetary = ($this->input->post('acc_ismonetary')) ? 1 : 0;
			$acc_subgroupid = $this->input->post('acc_subgroupid');
			$sql = "update master_acc
			set 
				acc_name = '$acc_name',
				acc_nameshort = '$acc_nameshort',
				acc_descr = '$acc_descr',
				acc_isgroup = '$acc_isgroup',
				acc_parent = '$acc_parent',
				acc_path = '$acc_path',
				acc_isdisabled = '$acc_isdisabled',
				acc_ismonetary = '$acc_ismonetary',
				accsubgroup_id = '$acc_subgroupid'
			where acc_id = '$acc_id'";
			$check=$this->db->query($sql);
			return $check;
		}
	    	
			
	}

	function insertacc(){ 

		if(!empty($_POST))
		{ 
			$acc_id = $this->input->post('acc_id');
			$acc_name = $this->input->post('acc_name');
			$acc_nameshort = $this->input->post('acc_nameshort');
			$acc_descr = $this->input->post('acc_descr');
			$acc_isgroup = ($this->input->post('acc_isgroup')) ? 1 : 0;
			$acc_parent = $this->input->post('acc_parent');
			$acc_path = $this->input->post('acc_path');
			$acc_isdisabled = ($this->input->post('acc_isdisabled')) ? 1 : 0;
			$acc_ismonetary = ($this->input->post('acc_ismonetary')) ? 1 : 0;
			$acc_subgroupid = $this->input->post('acc_subgroupid');
			$username = $this->session->userdata('username');
			$dates = date('Y-m-d');
			$sql = "
            insert into master_acc (acc_id,acc_name,acc_nameshort,acc_descr,acc_isgroup,acc_parent,acc_path,acc_isdisabled,acc_ismonetary,accsubgroup_id,acc_createby,acc_createdate)
			values
			('$acc_id','$acc_name','$acc_nameshort','$acc_descr','$acc_isgroup','$acc_parent','$acc_path',$acc_isdisabled,$acc_ismonetary,'$acc_subgroupid','$username','$dates')
			";
			// echo $sql;exit;
			$check=$this->db->query($sql);	
			return $check;
		}
	    	
            

	}

	function deleteacc($acc_id){        

        $check=$this->db->query("
            delete from master_acc
			where acc_id ='$acc_id'
        ");	    

	}
	
	public function get_data($query)
	{ 
		$hasil = $this->db->query(trim($query)); 
        if ($hasil ) 
        {
            return $hasil ;
        } 
        else 
        {
            return array();
        }
	}   

}
