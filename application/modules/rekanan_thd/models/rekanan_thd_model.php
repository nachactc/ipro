<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of master_rekanan
 * @created on : Monday, 16-Oct-2017 07:05:10
 * @author DAUD D. SIMBOLON <daud.simbolon@gmail.com>
 * Copyright 2017    
 */
 
 
class rekanan_thd_model extends CI_Model 
{
	Protected $id_rekanan = 0;
	
    public function __construct() 
    {
        parent::__construct();
    }


    /**
     *  Get All data master_rekanan
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
		$startrow =  (((int)$this->uri->segment(3)) - 1 ) ;
		$startrow = $startrow <= -1 ? 1 : $startrow;
		$endrow =  ($startrow - 1)  +  $limit;
		$query = $this->db->query('
        select * from ( 
            SELECT  ROW_NUMBER() OVER(ORDER BY rekanan_id asc) AS row,(Count(*) OVER()) AS rows,* FROM (
		select r.rekanan_id,r.rekanan_badanhukum,  rekanan_name, rekanan_address, rg.region_name,s.rekananshipping_name,br.branch_name
		from master_rekanan r
		inner join master_rekananshipping s on r.rekanan_id=s.rekanan_id 
		left join master_regionbranch rb on s.branch_id =rb.branch_id
		left join master_region rg on rb.region_id =rg.region_id 
		left join master_branch br on rb.branch_id =br.branch_id 
		where rekanan_isdisabled =0 and rekanantype_id = 105
		group by r.rekanan_id,r.rekanan_badanhukum , rekanan_name, rekanan_address, rg.region_name,s.rekananshipping_name,br.branch_name
		) AS VW ) as HW
		where row>='.$startrow.' and row<='.$endrow.'  
		order by rekanan_id asc');  
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
     *  Count All master_rekanan
     *    
     *  @return Integer
     *
     */
    public function count_all()
    {
        $this->db->from('master_rekanan');
        $this->db->where('rekanan_isdisabled ',0);
        $this->db->where('rekanantype_id ',105);
        return $this->db->count_all_results();
    }
    

    /**
    * Search All master_rekanan
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
        $region = $this->session->userdata('region');
        $branch = $this->session->userdata('branch');
        
		$where = '';
		if(!empty($region))
		{
			if($where != '')
			{
				$where = $where." AND rg.region_id = '$region' ";
			}
			else
			{
				$where = " AND rg.region_id = '$region' ";
			}
		}
		if(!empty($branch))
		{
			if($where != '')
			{
				$where = $where." AND rb.branch_id ='$branch' ";
			}
			else
			{
				$where = " AND rb.branch_id = '$branch' ";
			}
		} 
		if($where == '')
		{
			$where = " and r.rekanan_id like '%$keyword%' or r.rekanan_name like '%$keyword%' or s.rekananshipping_name like '%$keyword%' ";
		}
        $page = 0;
		$startrow =  (((int)$this->uri->segment(3)) - 1 ) ;
		$startrow = $startrow <= -1 ? 1 : $startrow;
		$endrow =  ($startrow - 1)  +  $limit;
		$query = $this->db->query("
		select * from ( SELECT  ROW_NUMBER() OVER(ORDER BY rekanan_id asc) AS row,(Count(*) OVER()) AS rows,* FROM (
		select r.rekanan_id,r.rekanan_badanhukum,  rekanan_name, rekanan_address, rg.region_name ,s.rekananshipping_name,br.branch_name
		from master_rekanan r
		left join master_rekananshipping s on r.rekanan_id=s.rekanan_id 
		left join master_regionbranch rb on s.branch_id =rb.branch_id
		left join master_region rg on rb.region_id =rg.region_id 
		left join master_branch br on rb.branch_id =br.branch_id 
		where rekanan_isdisabled =0 and rekanantype_id = '105'
		$where
		group by r.rekanan_id,r.rekanan_badanhukum , rekanan_name, rekanan_address, rg.region_name,s.rekananshipping_name,br.branch_name
		) AS VW ) as HW 
		
		order by row asc");  
		//where row>=$startrow and row<=$endrow 
		// echo $this->db->last_query();
		// exit;
		 
        $result =$query->result_array();
		
		//echo $startrow;
		//echo $endrow;
		// echo $where;
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
    * Search All master_rekanan
    * @param keyword : mixed
    *
    * @return Integer
    *
    */
    public function count_all_search()
    { 
		$keyword = $this->session->userdata('keyword');
        $region = $this->session->userdata('region');
        $branch = $this->session->userdata('branch');
        
		$where = '';
		if(!empty($region))
		{
			if($where != '')
			{
				$where = $where." AND rg.region_id = '$region' ";
			}
			else
			{
				$where = " AND rg.region_id = '$region' ";
			}
		}
		if(!empty($branch))
		{
			if($where != '')
			{
				$where = $where." AND rb.branch_id ='$branch' ";
			}
			else
			{
				$where = " AND rb.branch_id = '$branch' ";
			}
		} 
		if($where == '')
		{
			$where = " and r.rekanan_id like '%$keyword%' or r.rekanan_name like '%$keyword%'";
		}
		$query = $this->db->query("select count(*) as total from ( SELECT  ROW_NUMBER() OVER(ORDER BY rekanan_id asc) AS row,(Count(*) OVER()) AS rows,* FROM (
		select r.rekanan_id,r.rekanan_badanhukum,  rekanan_name, rekanan_address, rg.region_name ,s.rekananshipping_name,br.branch_name
		from master_rekanan r
		left join master_rekananshipping s on r.rekanan_id=s.rekanan_id 
		left join master_regionbranch rb on s.branch_id =rb.branch_id
		left join master_region rg on rb.region_id =rg.region_id 
		left join master_branch br on rb.branch_id =br.branch_id 
		where rekanan_isdisabled =0 and rekanantype_id = '105'
		$where
		group by r.rekanan_id,r.rekanan_badanhukum , rekanan_name, rekanan_address, rg.region_name,s.rekananshipping_name,br.branch_name
		) AS VW ) as HW  ");   
        $result =$query->row();   
        return $result->total; 
    }

 
    
    /**
    *  Get One master_rekanan
    *
    *  @param id : Integer
    *
    *  @return array
    *
    */
    public function get_one($id) 
    {
        $this->db->where('rekanan_id', $id);
        $result = $this->db->get('master_rekanan');

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
    *  Default form data master_rekanan
    *  @return array
    *
    */
    public function add()
    {
        $data = array(
            
                'rekanan_id' => '',
            
                'rekanan_badanhukum' => 'PT.',
            
                'rekanan_name' => '',
            
                'rekanan_namereport' => '',
            
                'rekanan_address' => '',
            
                'rekanan_city' => '',
            
                'rekanan_telp' => '',
            
                'rekanan_fax' => '',
            
                'rekanan_email' => '',
            
                'rekanan_url' => '',
            
                'rekanan_pkpname' => '',
            
                'rekanan_taxprefix' => '010.',
            
                'rekanan_taxaddress' => '',
            
                'rekanan_buyup' => '',
            
                'rekanan_buyupposition' => '',
            
                'rekanan_buyaddress' => '',
            
                'rekanan_create_by' => '',
            
                'rekanan_create_date' => '',
            
                'rekanan_modified_by' => '',
            
                'rekanan_modified_date' => '',
            
                'rekanan_isdisabled' => 0,
            
                'rekanantype_id' => '',
            
                'rekanan_iderp' => '',
            
                'rekanan_creditlimit' => '',
            
                'rekanan_multiplier' => '',
            
                'rekanan_receivabledisc' => '',
            
                'rekanan_receivabletop' => '',
            
                'taxsign_id' => '',
				
				'deduct' => '',
				
				'grouptenant_id' => 1,
				
				'rekanan_taxnik' => '',
				
				'rekanan_nohp' => '0',
            
        );

        return $data;
    }

    
    
    
    
    /**
    *  Save data Post
    *
    *  @return void
    *
    */
    public function save() 
    {
		
		$id_rekanan =  generate_id_int('','105','sequencer_rekanan');
		
		$id_rekanan = '105'.$id_rekanan; //$id_rekanan != '' ?  ('105'.$id_rekanan + 1) : 0;
		
		
		 
		
        $data = array(
        
            'rekanan_id' => $id_rekanan,
        
            'rekanan_badanhukum' => strip_tags($this->input->post('rekanan_badanhukum', TRUE)),
        
            'rekanan_name' => strip_tags($this->input->post('rekanan_name', TRUE)),
        
            'rekanan_namereport' => strip_tags($this->input->post('rekanan_namereport', TRUE)),
        
            'rekanan_address' => strip_tags($this->input->post('rekanan_address', TRUE)),
        
            'rekanan_city' => strip_tags($this->input->post('rekanan_city', TRUE)),
        
            'rekanan_telp' => strip_tags($this->input->post('rekanan_telp', TRUE)),
        
            'rekanan_fax' => strip_tags($this->input->post('rekanan_fax', TRUE)),
        
            'rekanan_email' => strip_tags($this->input->post('rekanan_email', TRUE)), 
        
            'rekanan_create_by' => $this->session->userdata('user_fullname'),
        
            'rekanan_create_date' => date('Y-m-d'), 
            'rekanan_isdisabled' => strip_tags($this->input->post('rekanan_isdisabled', TRUE)),
        
            'rekanantype_id' => 105,
			 
            'deduct' => strip_tags($this->input->post('deduct', TRUE)),
			
            'taxsign_id' => strip_tags($this->input->post('taxsign_id', TRUE)), 
			
            'rekanan_pkpname' => strip_tags($this->input->post('rekanan_pkpname', TRUE)), 
			
            'rekanan_taxaddress' => strip_tags($this->input->post('rekanan_taxaddress', TRUE)), 
			
            'rekanan_taxnik' => strip_tags($this->input->post('rekanan_taxnik', TRUE)), 
			
            'rekanan_taxprefix' => strip_tags($this->input->post('rekanan_taxprefix', TRUE)), 
			
            'rekanan_nohp' => strip_tags($this->input->post('rekanan_nohp', TRUE)),  
			
        );
        
		$result =  $this->db->insert('master_rekanan', $data);
		
		return $id_rekanan;
		// try {
			// $result = ($result) ? $result : false;  
			// if ($result) {
				// update_generate_last_id(null,'105',$id_rekanan,'sequencer_rekanan');  
			// } 
			// else {
				// throw new Exception("insert rekanan error");
			// }
		// } catch (Exception $e) {
			// log_message('error',$e->getMessage());
			// return;
		// }
       
		
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
        $data = array(
         
            'rekanan_badanhukum' => strip_tags($this->input->post('rekanan_badanhukum', TRUE)),
        
            'rekanan_name' => strip_tags($this->input->post('rekanan_name', TRUE)),
        
            'rekanan_namereport' => strip_tags($this->input->post('rekanan_namereport', TRUE)),
        
            'rekanan_address' => strip_tags($this->input->post('rekanan_address', TRUE)),
        
            'rekanan_city' => strip_tags($this->input->post('rekanan_city', TRUE)),
        
            'rekanan_telp' => strip_tags($this->input->post('rekanan_telp', TRUE)),
        
            'rekanan_fax' => strip_tags($this->input->post('rekanan_fax', TRUE)),
        
            'rekanan_email' => strip_tags($this->input->post('rekanan_email', TRUE)), 
          
            'rekanan_modified_by' => $this->session->userdata('user_fullname'),
        
            'rekanan_modified_date' =>  date('Y-m-d'), 
        
            'rekanan_isdisabled' => strip_tags($this->input->post('rekanan_isdisabled', TRUE)),
        
            'rekanantype_id' =>105,
			 
            'deduct' => strip_tags($this->input->post('deduct', TRUE)),
			
            'grouptenant_id' => strip_tags($this->input->post('grouptenant_id', TRUE)), 
			
			'taxsign_id' => strip_tags($this->input->post('taxsign_id', TRUE)), 
			
            'rekanan_pkpname' => strip_tags($this->input->post('rekanan_pkpname', TRUE)), 
			
            'rekanan_taxaddress' => strip_tags($this->input->post('rekanan_taxaddress', TRUE)), 
			
            'rekanan_taxnik' => strip_tags($this->input->post('rekanan_taxnik', TRUE)), 
			
            'rekanan_taxprefix' => strip_tags($this->input->post('rekanan_taxprefix', TRUE)), 
			
            'rekanan_nohp' => strip_tags($this->input->post('rekanan_nohp', TRUE)), 
        
        );
        
        
        $this->db->where('rekanan_id', $id);
        $this->db->update('master_rekanan', $data);
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
        $this->db->where('rekanan_id', $id);
        $this->db->delete('master_rekanan');
        
    }

	
    /**
    *  combo group tenant 
    *
    */
	
	public function combo_grouptenant()
	{
		//master_grouptenant 
        $result = $this->db->get('master_grouptenant')
                           ->result();

        $ret ['']= 'Pilih Group Tenant :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->grouptenant_id] = $row->grouptenant_name;
            }
        }
        
        return $ret; 
	}

	public function get_templateData($type,$branch_id)
	{
		echo $branch_id;
		//$type = gas / air / listrik
		$this->db->where('branch_id', $branch_id);
        $result = $this->db->get('master_branchutilities'.$type);

        if ($result->num_rows() == 1) 
        {
            return $result->row_array();
        } 
        else 
        {
            return array();
        }
    }

    public function get_one_datas($table,$columnwhere,$keywhere)
	{
		$this->db->where($columnwhere,$keywhere);
		$query = $this->db->get($table);
		// echo $this->db->last_query(); 
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
	}



}
