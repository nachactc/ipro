<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_setting extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
  /**
     *  Get All data master_semesterbranch
     *
     *  @param limit  : Integer
     *  @param offset : Integer
     *
     *  @return array
     *
     */

	function get_branch_list()	{ 
		// echo var_dump($branch_name);
		// exit;
        $this->db->select('r.branch_id, branch_name,c.region_id,c.region_name');
        $this->db->from('master_regionbranch r');
        $this->db->join('master_branch b', 'r.branch_id = b.branch_id');
        $this->db->join('master_region c', 'c.region_id = r.region_id'); 
        $query = $this->db->get()->result();;

       
		
		$ret ['']= 'Pilih Store :';
        if($query)
        {
            foreach ($query as $key => $row)
            {
                $ret [$row->branch_id] = $row->branch_name;
            }
        }
        //echo var_dump($ret);
        return $ret; 
		
    }
	
	function get_region_bybranch($branch){


        $qry="select rb.region_id, region_name from master_regionbranch rb
		left join master_region r on rb.region_id =r.region_id 
		where branch_id='$branch'";
		
		return $this->db->query($qry)->result_array();
	}

	function get_strukturunit_list()	{ 

        $this->db->select('strukturunit_id, strukturunit_name');
        $this->db->from('master_strukturunit');
        $query = $this->db->get()->result();;

		$ret ['']= 'Pilih Struktur Unit :';
        if($query)
        {
            foreach ($query as $key => $row)
            {
                $ret [$row->strukturunit_id] = $row->strukturunit_name;
            }
        }
        //echo var_dump($ret);
        return $ret; 
		
    }


	
	function get_userregion($user)
	{ 

        $qry="select R.region_id, R.region_name , 
		checked=(case when UR.region_id is NULL then 0 else 1 end) 
	  	FROM master_region AS R
		  LEFT JOIN (select * from master_userregion where username='$user' ) 
		  UR ON R.region_id = UR.region_id";
		
		  return $this->db->query($qry)->result_array();
		
    }

	
	function get_userbranch($user)
	{ 

        $qry="select B.branch_id, B.branch_name , 
		checked=(case when UB.branch_id is NULL then 0 else 1 end) 
	  	FROM master_branch AS B
		  LEFT JOIN
		  (select * from master_userbranch where username='$user' )  
		  UB ON B.branch_id = UB.branch_id";
		
		  return $this->db->query($qry)->result_array();
		
	}
	
	
	function get_userstrukturunit($user)
	{ 

        $qry="
		select S.strukturunit_id, S.strukturunit_name , 
				checked=(case when US.strukturunit_id is NULL then 0 else 1 end) 
				  FROM master_strukturunit AS S
				  LEFT JOIN 
				  (select * from master_userstrukturunit where username='$user' )
				  US ON S.strukturunit_id = US.strukturunit_id";

		  return $this->db->query($qry)->result_array();
		
    }
	function get_channel()
	{ 

        $this->db->select('channel_id, channel_name');
        $this->db->from('master_channel');
        $query = $this->db->get()->result();;

		$ret ['']= 'Pilih Channel :';
        if($query)
        {
            foreach ($query as $key => $row)
            {
                $ret [$row->channel_id] = $row->channel_name;
            }
        }
        //echo var_dump($ret);
        return $ret; 
		
    }
    
	function qry_alldatalist($limit,$top,$sWhere){
		// echo var_dump($sWhere);
		$sWhere = empty($sWhere) ? " " : $sWhere." ";

		$qry=" 
			SELECT * FROM (
			select top $limit CTE.*,ROW_NUMBER() OVER (ORDER BY setting_id asc) as RowNumber
			  FROM master_setting AS CTE     
			  $sWhere 
			  ORDER BY CTE.setting_id ASC
			  ) AS V
    		WHERE   RowNumber > $top";
		//echo $qry;
		//exit;
	    return $this->db->query($qry)->result_array();
   }
   

    function qry_filteredlist($sWhere){
       $sWhere = empty($sWhere) ? "  " : $sWhere." ";
	   $qry="SELECT count(*) as jml FROM (
			  select CTE.*,ROW_NUMBER() OVER (ORDER BY setting_id asc) as RowNumber
			  FROM master_setting AS CTE 
			  $sWhere 
			  ) AS V";
		return $this->db->query($qry)->row_array();
	   
   }
   

   function qry_totalalllist(){
		
		$qry="select count(setting_id) as jml from master_setting "; //where unittype_id <> 7 AND unittype_id <> 6
		return $this->db->query($qry)->row_array();
	   
   }
   
	function viewsetting($setting_id){     

		if (isset($setting_id)){
			return $this->db->query("
			SELECT a.*
			  FROM  master_setting a
			  WHERE setting_id='$setting_id'
			")->result();        
		}else{         
			//$timestamp = time();
		  
			//$now = date("Y-m-d", $timestamp);  

			$result[] = (object) array(                        
							'setting_id'        => '',
							'setting_value'     => '',
			); 

			return $result;
		}

	}

	function updatesetting($setting_id, $setting_value){        

           $sql = "update master_setting
			set setting_value = '$setting_value'
			where setting_id = '$setting_id'";
			$check=$this->db->query($sql);	
			
	}

	function insertsetting($setting_id, $setting_value){        

        $check=$this->db->query("
            insert into master_setting
			(setting_id,setting_value)
			values
			('$setting_id','$setting_value')
        ");	    

	}

	function deletesetting($setting_id){        

        $check=$this->db->query("
            delete from master_setting
			where setting_id ='$setting_id'
        ");	    

	}

}
