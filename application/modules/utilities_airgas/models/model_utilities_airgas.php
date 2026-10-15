<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_utilities_airgas extends CI_Model{
    
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

	function get_utilities_type()
	{ 
		$ret ['']= 'Pilih Type Utilities :';
		$ret ['UA']= 'Utilities Air';		
		$ret ['UG']= 'Utilities Gas';		
		$ret ['US']= 'Utilities Solar';		
        return $ret; 
		
    }

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
		  LEFT JOIN (select * from master_userregion where utilitiesairgas_id='$user' ) 
		  UR ON R.region_id = UR.region_id";
		
		  return $this->db->query($qry)->result_array();
		
    }

	
	function get_userbranch($user)
	{ 

        $qry="select B.branch_id, B.branch_name , 
		checked=(case when UB.branch_id is NULL then 0 else 1 end) 
	  	FROM master_branch AS B
		  LEFT JOIN
		  (select * from master_userbranch where utilitiesairgas_id='$user' )  
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
				  (select * from master_userstrukturunit where utilitiesairgas_id='$user' )
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
			select top $limit CTE.*,ROW_NUMBER() OVER (ORDER BY utilitiesairgas_id asc) as RowNumber
			  FROM master_utilitiesairgas AS CTE     
			  $sWhere 
			  ORDER BY CTE.utilitiesairgas_number, CTE.utilitiesairgas_name ASC
			  ) AS V
    	WHERE   RowNumber > $top";
		//echo $qry;
		//exit;
	    return $this->db->query($qry)->result_array();
   }
   
    function qry_filteredlist($sWhere){
       $sWhere = empty($sWhere) ? "" : $sWhere."";
	   $qry="SELECT count(*) as jml FROM (
			  select CTE.*,ROW_NUMBER() OVER (ORDER BY utilitiesairgas_id asc) as RowNumber
			  FROM master_utilitiesairgas AS CTE       
			  $sWhere 
			 	
			  ) AS V";
			//  echo var_dump($this->db->query($qry)->row_array() );exit;
		return $this->db->query($qry)->row_array();
	   //echo var_dump($ret);
   }
   
   function qry_totalalllist(){
		
		$qry="select count(utilitiesairgas_id) as jml from master_utilitiesairgas "; //where unittype_id <> 7 AND unittype_id <> 6
		return $this->db->query($qry)->row_array();
	   
   }
   

	function viewutilitiesairgas($utilitiesairgas_id){     

		if (isset($utilitiesairgas_id)){
			return $this->db->query("
			SELECT 
			   a.*
			  FROM  master_utilitiesairgas a
			  WHERE utilitiesairgas_id='$utilitiesairgas_id'
			")->result();        
		}else{         
			$timestamp = time();
		  
			$now = date("Y-m-d", $timestamp);  

			$result[] = (object) array(                        
							'utilitiesairgas_id'          => '',
							'utilitiesairgas_number'     => '',
							'utilitiesairgas_name'     => '',
							'utilitiesairgas_type'   => '',
							'utilitiesairgas_spec'       	=>'',
							'utilitiesairgas_tarif'       	=> 0,
							'utilitiesairgas_minvalue'   	=> 0,
							'utilitiesairgas_maxvalue'   	=> 0,

			); 

			return $result;
		}

	}

	function updateutilitiesairgas($utilitiesairgas_id, $utilitiesairgas_number, $utilitiesairgas_name, $utilitiesairgas_type, $utilitiesairgas_spec, $utilitiesairgas_tarif, $utilitiesairgas_minvalue,$utilitiesairgas_maxvalue){        

			$username = $this->session->userdata('username');
			$timestamp = time();
			$_date = date("Y-m-d H:i:s", $timestamp);     
			

           	$sql = "update master_utilitiesairgas
            set utilitiesairgas_number = '$utilitiesairgas_number', utilitiesairgas_name = '$utilitiesairgas_name', utilitiesairgas_type = '$utilitiesairgas_type', 
			utilitiesairgas_spec = '$utilitiesairgas_spec', utilitiesairgas_tarif = $utilitiesairgas_tarif,utilitiesairgas_minvalue=$utilitiesairgas_minvalue,utilitiesairgas_maxvalue=$utilitiesairgas_maxvalue,
			utilitiesairgas_modifyby='$username', utilitiesairgas_modifydate ='$_date'
			where utilitiesairgas_id = '$utilitiesairgas_id'";
			//echo $sql;exit;
			$check=$this->db->query($sql);	
			
			
	}

	function insertutilitiesairgas($utilitiesairgas_id, $utilitiesairgas_number, $utilitiesairgas_name, $utilitiesairgas_type, $utilitiesairgas_spec, $utilitiesairgas_tarif, $utilitiesairgas_minvalue,$utilitiesairgas_maxvalue){        

			$username = $this->session->userdata('username');
			$timestamp = time();
			$_date = date("Y-m-d H:i:s", $timestamp);     

			$sql ="SELECT  id= (CAST(MAX(ISNULL(utilitiesairgas_id,0)) AS INT) + 1) from master_utilitiesairgas ";
			$utilitiesairgas_id=$this->db->query($sql)->row()->id;
	
			if($utilitiesairgas_type='UA') {
				for ($i=0; $i<=3; $i++){
					$utilitiesairgas_id= $utilitiesairgas_id + $i;
					$utilitiesairgas_name = 'Blok ' . ($i+1);

					if ($i > 0){
						$utilitiesairgas_minvalue = $utilitiesairgas_maxvalue;
					}

					$check=$this->db->query("
					insert into master_utilitiesairgas
					(utilitiesairgas_id,utilitiesairgas_number,utilitiesairgas_name, utilitiesairgas_type,utilitiesairgas_spec,utilitiesairgas_tarif,utilitiesairgas_minvalue,utilitiesairgas_maxvalue, utilitiesairgas_createby,utilitiesairgas_createdate )
					values
					('$utilitiesairgas_id','$utilitiesairgas_number',  '$utilitiesairgas_name',  '$utilitiesairgas_type', '$utilitiesairgas_spec',  $utilitiesairgas_tarif,$utilitiesairgas_minvalue,$utilitiesairgas_maxvalue, '$username', '$_date')
					");	   
					
				} 

			}else{

				$check=$this->db->query("
				insert into master_utilitiesairgas
				(utilitiesairgas_id,utilitiesairgas_number,utilitiesairgas_name, utilitiesairgas_type,utilitiesairgas_spec,utilitiesairgas_tarif,utilitiesairgas_minvalue,utilitiesairgas_maxvalue, utilitiesairgas_createby,utilitiesairgas_createdate )
				values
				('$utilitiesairgas_id','$utilitiesairgas_number',  '$utilitiesairgas_name',  '$utilitiesairgas_type', '$utilitiesairgas_spec',  $utilitiesairgas_tarif,$utilitiesairgas_minvalue,$utilitiesairgas_maxvalue, '$username', '$_date')
				");	    
	
			}


	}

	function deleteutilitiesairgas($utilitiesairgas_id){        

        $check=$this->db->query("
            delete from master_utilitiesairgas
			where utilitiesairgas_id='$utilitiesairgas_id'
        ");	    

	}

}
