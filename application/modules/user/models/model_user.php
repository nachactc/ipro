<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_user extends CI_Model{
    
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

	function get_branch_list()
	{ 
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

	function get_strukturunit_list()
	{ 

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
		$sWhere = empty($sWhere) ? " WHERE user_isdisabled = 0 " : $sWhere." AND user_isdisabled = 0 ";

		$qry=" 
			SELECT * FROM (
			select top $limit CTE.*,ROW_NUMBER() OVER (ORDER BY username asc) as RowNumber, 
						   REGION.region_name, BRANCH.branch_name
			  FROM master_user AS CTE     
			  LEFT JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
			  LEFT JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
			  $sWhere 
			  ORDER BY CTE.username ASC
			  ) AS V
    	WHERE   RowNumber > $top";
		// echo var_dump($qry);
		// echo "<br/>";
		// echo var_dump($this->db->query($qry)->result_array());
		// exit;
	    return $this->db->query($qry)->result_array();
   }
   
   function qry_alldatalistuserregion($limit,$top,$sWhere){
	// echo var_dump($sWhere);
	//$sWhere = empty($sWhere) ? " WHERE user_isdisabled = 0 " : $sWhere." AND user_isdisabled = 0 ";

	$qry=" 
		SELECT * FROM (
		select top $limit R.region_id, R.region_name ,ROW_NUMBER() OVER (ORDER BY region_name asc) as RowNumber, 
			checked=(case when UR.region_id is NULL then 0 else 1 end) 
		  FROM master_region AS R
		  LEFT JOIN master_userregion AS UR ON R.region_id = UR.region_id
		  $sWhere 
		  ORDER BY R.region_name ASC
		  ) AS V
	WHERE   RowNumber > $top";
	//echo $qry;
	//exit;
	return $this->db->query($qry)->result_array();
}

    function qry_filteredlist($sWhere){
       $sWhere = empty($sWhere) ? " WHERE user_isdisabled = 0 " : $sWhere." AND user_isdisabled = 0 ";
	   $qry="SELECT count(*) as jml FROM (
			  select CTE.*,ROW_NUMBER() OVER (ORDER BY username asc) as RowNumber, 
						   REGION.region_name, BRANCH.branch_name
			  FROM master_user AS CTE       
			  JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
			  JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
			  $sWhere 
			 
			  ) AS V";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_filteredlistuserregion($sWhere){
	//$sWhere = empty($sWhere) ? " WHERE user_isdisabled = 0 " : $sWhere." AND user_isdisabled = 0 ";
	$qry=" 
		SELECT * FROM (
		select top $limit R.region_id, R.region_name ,ROW_NUMBER() OVER (ORDER BY region_name asc) as RowNumber, 
			checked=(case when UR.region_id is NULL then 0 else 1 end) 
		  FROM master_region AS R
		  LEFT JOIN master_userregion AS UR ON R.region_id = UR.region_id
		  $sWhere 
		  ORDER BY R.region_name ASC
		  ) AS V
	WHERE   RowNumber > $top";
	//echo $qry;
	//exit;
	return $this->db->query($qry)->result_array();
	
}

   function qry_totalalllist(){
		
		$qry="select count(username) as jml from master_user "; //where unittype_id <> 7 AND unittype_id <> 6
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalllistuserregion(){
		
	$qry="select count(region_name) as jml from master_region "; //where unittype_id <> 7 AND unittype_id <> 6
	return $this->db->query($qry)->row_array();
   
}

	function viewuser($username){     

		if (isset($username)){
			return $this->db->query("
			SELECT 
			   a.*
			  ,r.[region_name]
			  ,b.[branch_name]
			  ,s.[strukturunit_name]
			  FROM  master_user a
			  LEFT JOIN master_branch b on a.branch_id = b.branch_id
			  LEFT JOIN master_region r on a.region_id = r.region_id
			  LEFT JOIN master_strukturunit s on a.strukturunit_id = s.strukturunit_id
			  WHERE username='$username'
			")->result();        
		}else{         
			$timestamp = time();
		  
			$now = date("Y-m-d", $timestamp);  

			$result[] = (object) array(                        
							'username'          => '',
							'user_fullname'     => '',
							'user_password'     => '',
							'user_isdisabled'   => 0,
							'region_id'       	=> '',
							'branch_id'       	=> '',
							'strukturunit_id'   	=> '',
							'user_default_channel_id'   	=> '',

			); 

			return $result;
		}

	}

	function updateuser($username, $user_fullname, $user_password, $user_isdisabled, $region_id, $branch_id, $strukturunit_id,$user_default_channel_id,$userregion,$userbranch,$userstrukturunit){        

           $sql = "update master_user
            set user_fullname = '$user_fullname', user_password = '$user_password', user_isdisabled = $user_isdisabled, 
			region_id = '$region_id', branch_id = '$branch_id',strukturunit_id='$strukturunit_id',user_default_channel_id='$user_default_channel_id'
			where username = '$username'";
			//echo $sql;exit;
			$check=$this->db->query($sql);	
			
			if($username){
				$sql="delete from master_userregion where username='$username'";
				$check=$this->db->query($sql);	

				$sql="delete from master_userbranch where username='$username'";
				$check=$this->db->query($sql);	
	
				$sql="delete from master_userstrukturunit where username='$username'";
				$check=$this->db->query($sql);	
	
			}

			if ($userregion){
				foreach($userregion as $userregion){
					//echo "<pre/>";
					//echo var_dump($userregion);
					$sql="insert into master_userregion
					(username, region_id,userregion_isdisabled, userregion_isdefault)
					values 
					('$username','$userregion',0, 0)";
					$check=$this->db->query($sql);	

				}
			}

			if ($userbranch){
				foreach($userbranch as $userbranch){
					//echo "<pre/>";
					//echo var_dump($userregion);
					$sql="insert into master_userbranch
					(username, branch_id,userbranch_isdisabled, userbranch_isdefault)
					values 
					('$username','$userbranch',0, 0)";
					$check=$this->db->query($sql);	

				}
			}

			if ($userstrukturunit){
				foreach($userstrukturunit as $userstrukturunit){
					//echo "<pre/>";
					//echo var_dump($userregion);
					$sql="insert into master_userstrukturunit
					(username, strukturunit_id,userstrukturunit_isdisabled, userstrukturunit_isdefault)
					values 
					('$username','$userstrukturunit',0, 0)";
					$check=$this->db->query($sql);	

				}
			}
/*
        if ($check){
			$this->db->query("delete from master_userregion where username='$username'");  

			foreach($user_r as $key => $reg){

            $r_region       = $user_r[$key];

            $this->db->query("
             insert into master_userregion
                 (username, region_id, region_isdefault)
             values
                 ('$username', $r_region, 0)");
				
				 
			}

			$this->db->query("delete from master_userbranch where username='$username'");  
			foreach($user_b as $key => $br){

            $b_branch       = $user_b[$key];

            $this->db->query("
             insert into master_userbranch
                 (username, branch_id, branch_isdefault)
             values
                 ('$username', $b_branch, 0)");

				 
			}

          
        }       
		*/
	}

	function insertuser($username, $user_fullname, $user_password, $user_isdisabled, $region_id, $branch_id, $strukturunit_id,$user_default_channel_id,$userregion,$userbranch,$userstrukturunit){        

        $check=$this->db->query("
            insert into master_user
			(username,user_fullname,user_password, user_isdisabled,region_id,branch_id,strukturunit_id,user_default_channel_id)
			values
			('$username','$user_fullname',  '$user_password',  $user_isdisabled, '$region_id',  '$branch_id','$strukturunit_id','$user_default_channel_id')
        ");	    


		if ($userregion){
			foreach($userregion as $userregion){
				//echo "<pre/>";
				//echo var_dump($userregion);
				$sql="insert into master_userregion
				(username, region_id,userregion_isdisabled, userregion_isdefault)
				values 
				('$username','$userregion',0, 0)";
				$check=$this->db->query($sql);	

			}
		}

		if ($userbranch){
			foreach($userbranch as $userbranch){
				//echo "<pre/>";
				//echo var_dump($userregion);
				$sql="insert into master_userbranch
				(username, branch_id,userbranch_isdisabled, userbranch_isdefault)
				values 
				('$username','$userbranch',0, 0)";
				$check=$this->db->query($sql);	

			}
		}

		if ($userstrukturunit){
			foreach($userstrukturunit as $userstrukturunit){
				//echo "<pre/>";
				//echo var_dump($userregion);
				$sql="insert into master_userstrukturunit
				(username, strukturunit_id,userstrukturunit_isdisabled, userstrukturunit_isdefault)
				values 
				('$username','$userstrukturunit',0, 0)";
				$check=$this->db->query($sql);	

			}
		}
/*
        if ($check){
			$this->db->query("delete from master_userregion where username='$username'");  

			foreach($user_r as $key => $reg){

            $r_region       = $user_r[$key];

            $this->db->query("
             insert into master_userregion
                 (username, region_id, region_isdefault)
             values
                 ('$username', $r_region, 0)");
				
				 
			}

			$this->db->query("delete from master_userbranch where username='$username'");  
			foreach($user_b as $key => $br){

            $b_branch       = $user_b[$key];

            $this->db->query("
             insert into master_userbranch
                 (username, branch_id, branch_isdefault)
             values
                 ('$username', $b_branch, 0)");

				 
			}

          
        }       
		*/
	}

}
