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
			select top $limit CTE.*,B.acc_name,ROW_NUMBER() OVER (ORDER BY CTE.acc_id asc) as RowNumber
			  FROM master_source_acc AS CTE   
			  LEFT JOIN master_acc B on CTE.acc_id = B.acc_id
			  $sWhere 
			  ORDER BY CTE.acc_id ASC
			  ) AS V
    		WHERE   RowNumber > $top";
		// echo $qry;
		//exit;
	    return $this->db->query($qry)->result_array();
   }
   

    function qry_filteredlist($sWhere){
       $sWhere = empty($sWhere) ? "  " : $sWhere." ";
	   $qry="SELECT count(*) as jml FROM (
			  select CTE.*,ROW_NUMBER() OVER (ORDER BY acc_id asc) as RowNumber
			  FROM master_source_acc AS CTE 
			  $sWhere 
			  ) AS V";
		return $this->db->query($qry)->row_array();
	   
   }
   

   function qry_totalalllist(){
		
		$qry="select count(acc_id) as jml from master_source_acc "; //where unittype_id <> 7 AND unittype_id <> 6
		return $this->db->query($qry)->row_array();
	   
   }
   
	function viewmaster_source_acc($acc_id,$source_id,$dk){     

		if (isset($acc_id)){
			return $this->db->query("
				SELECT a.*
				  FROM  master_source_acc a
				  WHERE acc_id='$acc_id' AND source_id='$source_id' AND dk = '$dk'
			")->row_array();        
		}else{       
			return false;
		}

	}

	function updateacc($acc_id1,$source_id1,$dk1){        
		if(!empty($_POST))
		{
			$acc_id = $this->input->post('acc_id');
			$source_id = $this->input->post('source_id');
			$dk = strtoupper($this->input->post('dk')); 
			$sql = "update master_source_acc
			set 
				acc_id = '$acc_id',
				source_id = '$source_id',
				dk = '$dk' 
			where acc_id = '$acc_id1' AND source_id='$source_id1' AND dk='$dk1' ";
			// ECHO $sql;exit;
			$check=$this->db->query($sql);
			return $check;
		}
	    	
			
	}

	function insertacc(){ 

		if(!empty($_POST))
		{ 
			$acc_id = $this->input->post('acc_id');
			$source_id = $this->input->post('source_id');
			$dk = strtoupper($this->input->post('dk')); 
			$sql = "
            insert into master_source_acc (acc_id,source_id,dk)
			values
			('$acc_id','$source_id','$dk')
			";
			// echo $sql;exit;
			$check=$this->db->query($sql);	
			return $check;
		}
	    	
            

	}

	function deleteacc($acc_id,$source_id,$dk){        

        $check=$this->db->query("
            delete from master_source_acc
			where acc_id ='$acc_id' AND source_id='$source_id' AND dk='$dk'
        ");	    

	}
	
	public function get_data($query)
	{ 
		$hasil = $this->db->query(trim($query));
		// echo var_dump($query);
		// echo var_dump($hasil);
		// exit;
        if ($hasil ) 
        {
            return $hasil ;
        } 
        else 
        {
            return array();
        }
	}   
	
	function get_acc()
    { 
        $sq = "SELECT acc_id,acc_name,acc_nameshort FROM master_acc ";
        return $this
            ->db
            ->query($sq)->result();
    } 
}
