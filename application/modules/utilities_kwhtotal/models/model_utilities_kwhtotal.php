<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
class Model_utilities_kwhtotal extends CI_Model 
{

    public function __construct() 
    {
        parent::__construct();
    }


    /**
     *  Get All data master_branch
     *
     *  @param limit  : Integer
     *  @param offset : Integer
     *
     *  @return array
     *
     */
    public function get_all($limit, $offset) 
    {
 
		$page = 0;
		$startrow =  $offset + 1;//(((int)$this->uri->segment(2)) + 1 ) ;
		$startrow = $startrow <= -1 ? 1 : $startrow;
		$endrow =  ($startrow - 1)  +  $limit;
		$query = $this->db->query('SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY utilitieskwhtotal_id desc) AS row,(Count(*) OVER()) AS rows,  * FROM master_utilitieskwhtotal) AS VW
		where row>='.$startrow.' and row<='.$endrow.'  
		order by utilitieskwhtotal_id desc');  
        $result =$query->result_array();
		
		//echo $startrow;
		//echo $endrow;
		//echo $this->db->last_query();
		//exit;
        if ($result ) 
        {
            return $result ;
        } 
        else 
        {
            return array();
        }
    }

    

    /**
     *  Count All master_branch
     *    
     *  @return Integer
     *
     */
    public function count_all()
    {
        $this->db->from('master_utilitieskwhtotal');
        //$this->db->where('branch_isdisabled',0);
        return $this->db->count_all_results();
    }
    

    /**
    * Search All master_branch
    *
    *  @param limit   : Integer
    *  @param offset  : Integer
    *  @param keyword : mixed
    *
    *  @return array
    *
    */
    public function get_search($limit, $offset) 
    {
        $keyword = $this->session->userdata('keyword');
        
        
		//$page = 0;
		$startrow =   $offset + 1;//(((int)$this->uri->segment(2)) + 1 ) ;
		$startrow = $startrow <= -1 ? 1 : $startrow;
		$endrow =  ($startrow - 1)  +  $limit;
		 
		$query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY utilitieskwhtotal_id desc) AS row,(Count(*) OVER()) AS rows,* FROM master_utilitieskwhtotal where utilitieskwhtotal_id like '%$keyword%' or utilitieskwhtotal_descr like '%$keyword%' or periode_id like '%$keyword%'  ) AS VW
		where row>=".$startrow." and row<=".$endrow." 
		order by row desc");  
	 
        $result =$query->result_array();
		// echo $startrow ;
		// echo $endrow ;
		// exit;
        if ($result ) 
        {
            return $result ;
        } 
        else 
        {
            return array();
        }
    }

     
    
    /**
    * Search All master_branch
    * @param keyword : mixed
    *
    * @return Integer
    *
    */
    public function count_all_search()
    {
        $keyword = $this->session->userdata('keyword');
        //$limit = $this->config->item('per_page');
        //$page = 0;
		//$startrow =  (((int)$this->uri->segment(2)) - 1 ) ;
		//$startrow = $startrow <= -1 ? 1 : $startrow;
		//$endrow =  ($startrow - 1)  +  $limit;
		$query = $this->db->query("SELECT count(*) as total FROM 
		(SELECT  ROW_NUMBER() OVER(ORDER BY utilitieskwhtotal_id desc) AS row,
		(Count(*) OVER()) AS rows,* FROM master_utilitieskwhtotal 
		where utilitieskwhtotal_id like '%$keyword%' or utilitieskwhtotal_descr like '%$keyword%' or periode_id like '%$keyword%' ) 
		AS VW	");  
		// /where row>=$startrow and row<=$endrow  
		$result =$query->row();   
        return $result->total;
    }
 
     
    /**
    *  Get One master_branch
    *
    *  @param id : Integer
    *
    *  @return array
    *
    */
    public function get_one($id) 
    {
        $this->db->where('utilitieskwhtotal_id', $id);
        $result = $this->db->get('master_utilitieskwhtotal');

        if ($result->num_rows() == 1) 
        {
            return $result->row_array();
        } 
        else 
        {
            return array();
        }
    }
 
    
    /**
    *  Default form data master_branch
    *  @return array
    *
    */
    public function add()
    {
        $data = array(
            
                'utilitieskwhtotal_id' => '',
            
                'utilitieskwhtotal_descr' => '',
            
                'utilitieskwhtotal_kva' => 0,
            
                'utilitieskwhtotal_lwbp' => 0,
            
                'utilitieskwhtotal_wbp' => 0,
            
                'utilitieskwhtotal_jumlah' => 0,
            
                'utilitieskwhtotal_createby' => '',
            
                'utilitieskwhtotal_createdate' => date("Y-m-d"),
            
                'utilitieskwhtotal_modifyby' => '',
            
                'utilitieskwhtotal_modifydate' => date("Y-m-d"),
            
                'periode_id' =>'',
            
                'region_id' => '',
            
                'branch_id' => '',
            
                'cosq' => 0,
                'jam_nyala_pln' => 0,
                'jam_nyala_genset' => 0,

				'rowid' => '',
            
        );

        return $data;
    }
 
	/***************** Generate GUID ***************/
	public function GUIDv4 ($trim = true)
	{
		// Windows
		if (function_exists('com_create_guid') === true) {
			if ($trim === true)
				return trim(com_create_guid(), '{}');
			else
				return com_create_guid();
		}

		// OSX/Linux
		if (function_exists('openssl_random_pseudo_bytes') === true) {
			$data = openssl_random_pseudo_bytes(16);
			$data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
			$data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
			return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
		}

		// Fallback (PHP 4.2+)
		mt_srand((double)microtime() * 10000);
		$charid = strtolower(md5(uniqid(rand(), true)));
		$hyphen = chr(45);                  // "-"
		$lbrace = $trim ? "" : chr(123);    // "{"
		$rbrace = $trim ? "" : chr(125);    // "}"
		$guidv4 = $lbrace.
				substr($charid,  0,  8).$hyphen.
				substr($charid,  8,  4).$hyphen.
				substr($charid, 12,  4).$hyphen.
				substr($charid, 16,  4).$hyphen.
				substr($charid, 20, 12).
				$rbrace;
		return $guidv4;
	}
	
	public function getGUID(){
		if (function_exists('com_create_guid')){
			return com_create_guid();
		}else{
			mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);// "-"
			$uuid = chr(123)// "{"
				.substr($charid, 0, 8).$hyphen
				.substr($charid, 8, 4).$hyphen
				.substr($charid,12, 4).$hyphen
				.substr($charid,16, 4).$hyphen
				.substr($charid,20,12)
				.chr(125);// "}"
			return $uuid;
		}
	}

    /**
    *  Save data Post
    *
    *  @return void
    *
    */
    public function save() 
    {
		$sql ="SELECT  id= (CAST(MAX(ISNULL(utilitieskwhtotal_id,0)) AS INT) + 1) from master_utilitieskwhtotal ";
		$utilitieskwhtotal_id=$this->db->query($sql)->row()->id;
		$username = $this->session->userdata('username');
		$lwbp=strip_tags($this->input->post('utilitieskwhtotal_lwbp', TRUE));
		$lwbp=str_replace(',','',$lwbp);
		$wbp=strip_tags($this->input->post('utilitieskwhtotal_wbp', TRUE));
		$wbp=str_replace(',','',$wbp);
		$total=strip_tags($this->input->post('utilitieskwhtotal_jumlah', TRUE));
		$total=str_replace(',','',$total);
		$kva=strip_tags($this->input->post('utilitieskwhtotal_kva', TRUE));
		$kva=str_replace(',','',$kva);
		$cosq=strip_tags($this->input->post('cosq', TRUE));
		$cosq=str_replace(',','',$cosq);
		$jam_nyala_pln=strip_tags($this->input->post('jam_nyala_pln', TRUE));
		$jam_nyala_pln=str_replace(',','',$jam_nyala_pln);
		$jam_nyala_genset=strip_tags($this->input->post('jam_nyala_genset', TRUE));
		$jam_nyala_genset=str_replace(',','',$jam_nyala_genset);
		//$utilitieskwhtotal_descr = strip_tags($this->input->post('utilitieskwhtotal_descr', TRUE));
		//$utilitieskwhtotal_createby = $username;
		$timestamp = time();
		$utilitieskwhtotal_createdate = date('Y-m-d H:i:s',$timestamp);
		//$utilitieskwhtotal_modifyby = NULL;
		//$utilitieskwhtotal_modifydate = NULL;
		//$periode_id = $this->input->post('periode_id', TRUE);
        //$region_id = strip_tags($this->input->post('region_id', TRUE));
        //$branch_id = strip_tags($this->input->post('branch_id', TRUE));
		$rowid =trim(com_create_guid(), '{}');

		$data = array(
        
            'utilitieskwhtotal_id' => $utilitieskwhtotal_id,
        
            'utilitieskwhtotal_descr' => strip_tags($this->input->post('utilitieskwhtotal_descr', TRUE)),
        
            'utilitieskwhtotal_kva' => $kva, //strip_tags($this->input->post('utilitieskwhtotal_kva', TRUE)),
        
            'utilitieskwhtotal_lwbp' => $lwbp, //strip_tags($this->input->post('utilitieskwhtotal_lwbp', TRUE)),
        
            'utilitieskwhtotal_wbp' => $wbp, //strip_tags($this->input->post('utilitieskwhtotal_wbp', TRUE)),
        
            'utilitieskwhtotal_jumlah' =>  $total, //strip_tags($this->input->post('utilitieskwhtotal_jumlah', TRUE)),
        
            'utilitieskwhtotal_createby' => $username, //$this->session->userdata('user_name'),
        
            'utilitieskwhtotal_createdate' => $utilitieskwhtotal_createdate, 
        
            'utilitieskwhtotal_modifyby' => NULL, //$this->session->userdata('user_name'),
        
            'utilitieskwhtotal_modifydate' => NULL, //date('Y-m-d H:i:s'), 
        
            'periode_id' => $this->input->post('periode_id', TRUE),
        
            'region_id' => strip_tags($this->input->post('region_id', TRUE)),
          
            'branch_id' => strip_tags($this->input->post('branch_id', TRUE)),
            //'branch_isdirectcost' => $this->input->post('branch_isdirectcost', TRUE),
			'cosq' => $cosq,
            'jam_nyala_pln' => $jam_nyala_pln,
			'jam_nyala_genset' => $jam_nyala_genset,
			
            'rowid' => $rowid, //idstrip_tags($this->input->post('rowid', TRUE)),
        
        );
       	
        $this->db->insert('master_utilitieskwhtotal', $data);
		
		//$query =  "EXEC MstMstUtilitieskwhtotal_Insert '$utilitieskwhtotal_id' ,'$periode_id' ,$kva ,$lwbp ,$wbp ,$total , '$utilitieskwhtotal_descr' ,'$utilitieskwhtotal_createby' ,'$utilitieskwhtotal_createdate' , '$utilitieskwhtotal_modifyby' ,'$utilitieskwhtotal_modifydate' ,'$region_id' ,'$branch_id' ,'$rowid' ";
		//$check = $this->db->query($query)->row();
		//echo var_dump($check);
		//$utilitieskwhtotal_id = $check->utilitieskwhtotal_id;
		//echo var_dump($utilitieskwhtotal_id);EXIT();
		return $utilitieskwhtotal_id;
    }
     
    
    /**
    *  Update modify data
    *
    *  @param id : Integer
    *
    *  @return void
    *
    */
    public function update($id)
    {
		$username = $this->session->userdata('username');
		$lwbp=strip_tags($this->input->post('utilitieskwhtotal_lwbp', TRUE));
		$lwbp=str_replace(',','',$lwbp);
		$wbp=strip_tags($this->input->post('utilitieskwhtotal_wbp', TRUE));
		$wbp=str_replace(',','',$wbp);
		$total=strip_tags($this->input->post('utilitieskwhtotal_jumlah', TRUE));
		$total=str_replace(',','',$total);
		$kva=strip_tags($this->input->post('utilitieskwhtotal_kva', TRUE));
		$kva=str_replace(',','',$kva);
		$cosq=strip_tags($this->input->post('cosq', TRUE));
		$cosq=str_replace(',','',$cosq);
		$jam_nyala_pln=strip_tags($this->input->post('jam_nyala_pln', TRUE));
		$jam_nyala_pln=str_replace(',','',$jam_nyala_pln);
		$jam_nyala_genset=strip_tags($this->input->post('jam_nyala_genset', TRUE));
		$jam_nyala_genset=str_replace(',','',$jam_nyala_genset);

		
        $data = array(
        
			'utilitieskwhtotal_id' =>strip_tags($this->input->post('utilitieskwhtotal_id', TRUE)),
        
            'utilitieskwhtotal_descr' => strip_tags($this->input->post('utilitieskwhtotal_descr', TRUE)),
        
            'utilitieskwhtotal_kva' => $kva, //strip_tags($this->input->post('utilitieskwhtotal_kva', TRUE)),
        
            'utilitieskwhtotal_lwbp' => $lwbp, //strip_tags($this->input->post('utilitieskwhtotal_lwbp', TRUE)),
        
            'utilitieskwhtotal_wbp' => $wbp, //strip_tags($this->input->post('utilitieskwhtotal_wbp', TRUE)),
        
            'utilitieskwhtotal_jumlah' =>  $total, //strip_tags($this->input->post('utilitieskwhtotal_jumlah', TRUE)),
        
            'utilitieskwhtotal_createby' => strip_tags($this->input->post('utilitieskwhtotal_createby', TRUE)),
        
            'utilitieskwhtotal_createdate' => strip_tags($this->input->post('utilitieskwhtotal_createdate', TRUE)),
        
            'utilitieskwhtotal_modifyby' => $username,
        
            'utilitieskwhtotal_modifydate' => date('Y-m-d H:i:s'), 
        
            'periode_id' => $this->input->post('periode_id', TRUE),
        
            'region_id' => strip_tags($this->input->post('region_id', TRUE)),
          
            'branch_id' => strip_tags($this->input->post('branch_id', TRUE)),
            //'branch_isdirectcost' => $this->input->post('branch_isdirectcost', TRUE),
            'cosq' => $cosq,
            'jam_nyala_pln' => $jam_nyala_pln,
            'jam_nyala_genset' => $jam_nyala_genset,
        
            'rowid' => strip_tags($this->input->post('rowid', TRUE)),
        ); 
        // echo  var_dump($this->session->userdata());
        // echo var_dump($data);exit;
		
        $this->db->where('utilitieskwhtotal_id', $id);
        $this->db->update('master_utilitieskwhtotal', $data);
    }
 
    /**
    *  Delete data by id
    *
    *  @param id : Integer
    *
    *  @return void
    *
    */
    public function destroy($id)
    {       
        $this->db->where('utilitieskwhtotal_id', $id);
        $this->db->delete('master_utilitieskwhtotal');
        
    }

	    // get branch parent
		public function get_periode() 
		{
			$this->db->order_by('periode_id','desc');
			$result = $this->db->get('master_periode')->result();
	
			$ret ['']= 'Pilih Periode :';
			if($result)
			{
				foreach ($result as $key => $row)
				{
					$ret [$row->periode_id] = $row->periode_name;
				}
			}
			
			return $ret;
		}

	
    // get branch parent
    public function get_branch() 
    {
      
		$result = $this->db->query("exec [adm03_MstRegionBranch_SelectCombo] 'branch_isdisabled=0 ' ")
					->result();

        $ret ['']= 'Pilih Store :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->branch_id] = $row->branch_name;
            }
        }
        
        return $ret;
    }
 
	// get branch parent
    public function get_regionbranch() 
    {
      
		$result = $this->db->query("exec [adm03_MstRegionBranch_SelectCombo] '' ")
					->result();

		/*
		$ret ['']= 'Pilih Store :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->branch_id] = $row->branch_name;
            }
        }
        */
        return $result;
    }
 
    
    // get master utilities gas air
    public function get_region() 
    {
      
        $result = $this->db->get('master_region')
                           ->result();

        $ret ['']= 'Pilih Bisnis Unit:';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->region_id] = $row->region_name;
            }
        }
        
        return $ret;
    }


    // get master region
	public function get_regionbranch_all($branch_id)
	{
		  
		$result = $this->db->query("exec adm03_MstBranch_SelectRegion '$branch_id'");
		//echo $this->db->last_query;
        if ($result->num_rows() > 0) 
        {
            return $result->result_array();
        } 
        else 
        {
            return array();
        }
	}

	public function get_branch2($branch_name,$region_id) 
    {
        $result =  $this->db->query("SELECT a.branch_id,a.branch_name,a.branch_isgroup
		from master_branch a 
		left join master_regionbranch b on a.branch_id = b.branch_id WHERE a.branch_isgroup = 0 and b.region_id = $region_id and a.branch_name like '%$branch_name%'") ->result();
		
        return $result;
    }
	


}
