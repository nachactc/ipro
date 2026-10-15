<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_region extends CI_Model{
    
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
			select top $limit CTE.*,ROW_NUMBER() OVER (ORDER BY region_id asc) as RowNumber
			  FROM master_region AS CTE     
			  $sWhere 
			  ORDER BY CTE.region_id ASC
			  ) AS V
    		WHERE   RowNumber > $top";
		//echo $qry;
		//exit;
	    return $this->db->query($qry)->result_array();
   }
   

    function qry_filteredlist($sWhere){
       $sWhere = empty($sWhere) ? "  " : $sWhere." ";
	   $qry="SELECT count(*) as jml FROM (
			  select CTE.*,ROW_NUMBER() OVER (ORDER BY region_id asc) as RowNumber
			  FROM master_region AS CTE 
			  $sWhere 
			  ) AS V";
		return $this->db->query($qry)->row_array();
	   
   }
   

   function qry_totalalllist(){
		
		$qry="select count(region_id) as jml from master_region "; //where unittype_id <> 7 AND unittype_id <> 6
		return $this->db->query($qry)->row_array();
	   
   }
   
	function viewregion($region_id){     

		if (isset($region_id)){
			return $this->db->query("
			SELECT a.*
			  FROM  master_region a
			  WHERE region_id='$region_id'
			")->result();        
		}else{         
			//$timestamp = time();
		  
			//$now = date("Y-m-d", $timestamp);  

			$result[] = (object) array(                        
							'region_id'        => '',
							'region_name'     => '',
							'region_nameshort'=>'',
							'region_namereport'=>'',
							'region_telp'=>'',
							'region_fax'=>'',
							'region_address'=>'',
							'region_address_2'=>'', 
							'region_bisnisunit'=>'',
							'region_extid'=>'',
							'region_npwp'=>'',
							'region_account'=>'',
							'region_pic'=>'',
							'region_signature'=>'',
							'region_senderinv'=>'',
							'region_senderemail'=>'',
							'region_isdisabled'=>'0',
							'region_isgroup'=>'0',
							'region_createby'=>'',
							'region_createdate'=>'',
							'region_modifyby'=>'',
							'region_modifydate'=>''
			); 

			return $result;
		}

	}

	function updateregion($region_id, $region_name, $region_nameshort,$region_namereport,$region_telp,$region_fax,$region_address,$region_address_2, $region_bisnisunit,$region_extid,$region_npwp,$region_account,$region_pic,$region_signature,$region_senderinv,$region_senderemail,$region_isdisabled,$region_isgroup){        

		$username = $this->session->userdata('username');
		$timestamp = time();
		$date = date("Y-m-d H:i:s", $timestamp);     

           $sql = "update master_region
			set region_name = '$region_name',
			region_nameshort='$region_nameshort',
			region_namereport='$region_namereport',
			region_telp='$region_telp',
			region_fax='$region_fax',
			region_address='$region_address',
			region_address_2='$region_address_2', 
			region_bisnisunit='$region_bisnisunit',
			region_extid='$region_extid',
			region_npwp='$region_npwp',
			region_account='$region_account',
			region_pic='$region_pic',
			region_signature='$region_signature',
			region_senderinv='$region_senderinv',
			region_senderemail='$region_senderemail',
			region_isdisabled=$region_isdisabled,
			region_isgroup=$region_isgroup,
			region_modifyby='$username',
			region_modifydate='$date'
			where region_id = '$region_id'
			";
			$check=$this->db->query($sql);	
			
	}

	function insertregion($region_id, $region_name, $region_nameshort,$region_namereport,$region_telp,$region_fax,$region_address,$region_address_2, $region_bisnisunit,$region_extid,$region_npwp,$region_account,$region_pic,$region_signature,$region_senderinv,$region_senderemail,$region_isdisabled,$region_isgroup){        
				
		$username = $this->session->userdata('username');
		$timestamp = time();
		$date = date("Y-m-d H:i:s", $timestamp);     

        $check=$this->db->query("
            insert into master_region
			(region_id, region_name, region_nameshort,region_namereport,region_telp,region_fax,region_address,region_address_2, region_bisnisunit,region_extid,region_npwp,region_account,region_pic,region_signature,region_senderinv,region_senderemail,region_isdisabled,region_isgroup,region_createby,region_createdate,region_path)			
			values
			('$region_id', '$region_name', '$region_nameshort','$region_namereport','$region_telp','$region_fax','$region_address','$region_address_2', '$region_bisnisunit','$region_extid','$region_npwp','$region_account','$region_pic','$region_signature','$region_senderinv','$region_senderemail',$region_isdisabled,$region_isgroup,'$username','$date' ,'$region_id'  )
        ");	    

	}

	function deleteregion($region_id){        

        $check=$this->db->query("
            delete from master_region
			where region_id ='$region_id'
        ");	    

	}

}
