<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
class Model_lareceived extends CI_Model 
{

    public function __construct() 
    {
        parent::__construct();
    }


    /**
     *  Get All data transaksi_lareceived
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
		$query = $this->db->query('SELECT * FROM (
		  SELECT ROW_NUMBER() OVER(ORDER BY A.loo_id asc) AS row,(Count(*) OVER()) AS rows,
			   A.[loo_id]
			  ,A.[la_noloi]
			  ,A.[la_receivedby]
			  ,A.[la_receiveddate]
			  ,A.[la_isreceived]
			  ,A.[la_signdate]
			  ,A.[la_signby]
			  ,A.[la_issigned]
			  ,A.[la_proceeddate]
			  ,A.[la_proceedby]
			  ,A.[la_isproceed]
			  ,C.region_nameshort
			  ,D.branch_name
			  ,E.rekanan_name
			  ,F.rekananshipping_name
		  FROM  [dbo].[transaksi_lareceived]  A
		  LEFT JOIN transaksi_loo B on A.loo_id = B.loo_id
		  LEFT JOIN master_region C on B.region_id = C.region_id
		  LEFT JOIN master_branch D on B.branch_id = D.branch_id
		  LEFT JOIN master_rekanan E on B.rekanan_id = E.rekanan_id
		  LEFT JOIN master_rekananshipping F on  B.rekanan_id = F.rekanan_id and B.rekananshipping_line = F.rekananshipping_line
		) AS VW
		where row>='.$startrow.' and row<='.$endrow.'  
		order by loo_id asc');  
        $result =$query->result_array();
		
		// echo $endrow;
		// echo '<br>';
		//echo $query;
		 // echo $this->db->last_query();
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
     *  Count All transaksi_lareceived
     *    
     *  @return Integer
     *
     */
    public function count_all()
    {
        $this->db->from('transaksi_lareceived');
        return $this->db->count_all_results();
    }
    

    /**
    * Search All transaksi_lareceived
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
        
        $page = 0;
		$startrow =  (((int)$this->uri->segment(3)) - 1 ) ;
		
		$startrow = $startrow <= -1 ? 1 : $startrow;
		$endrow =  ($startrow - 1)  +  $limit;
		$query = $this->db->query("SELECT * FROM (
		  SELECT ROW_NUMBER() OVER(ORDER BY A.loo_id asc) AS row,(Count(*) OVER()) AS rows,
			   A.[loo_id]
			  ,A.[la_noloi]
			  ,A.[la_receivedby]
			  ,A.[la_receiveddate]
			  ,A.[la_isreceived]
			  ,A.[la_signdate]
			  ,A.[la_signby]
			  ,A.[la_issigned]
			  ,A.[la_proceeddate]
			  ,A.[la_proceedby]
			  ,A.[la_isproceed]
			  ,C.region_nameshort
			  ,D.branch_name
			  ,E.rekanan_name
			  ,F.rekananshipping_name
		  FROM  [dbo].[transaksi_lareceived]  A
		  LEFT JOIN transaksi_loo B on A.loo_id = B.loo_id
		  LEFT JOIN master_region C on B.region_id = C.region_id
		  LEFT JOIN master_branch D on B.branch_id = D.branch_id
		  LEFT JOIN master_rekanan E on B.rekanan_id = E.rekanan_id
		  LEFT JOIN master_rekananshipping F on  B.rekanan_id = F.rekanan_id and B.rekananshipping_line = F.rekananshipping_line 
		  WHERE 
		  c.region_nameshort LIKE '%$keyword%' 
		  OR D.branch_name LIKE '%$keyword%' 
		  OR E.rekanan_name  LIKE '%$keyword%' 
		  OR F.rekananshipping_name LIKE '%$keyword%' 
		  OR a.la_receivedby LIKE '%$keyword%' 
		  OR a.la_signby LIKE  '%$keyword%'  
		  OR  a.la_proceedby LIKE  '%$keyword%'    
		  OR  a.loo_id LIKE  '%$keyword%'    
		  OR  a.la_noloi LIKE  '%$keyword%'    
		) AS VW
		where row>=$startrow and row<=$endrow  
		order by loo_id asc");  
        $result =$query->result_array();
		
		// echo $endrow;
		// echo '<br>';
		//echo $query;
		// echo $this->db->last_query();
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
    * Search All transaksi_lareceived
    * @param keyword : mixed
    *
    * @return Integer
    *
    */
    public function count_all_search()
    {
        $keyword = $this->session->userdata('keyword');
        $query = $this->db->query("SELECT COUNT(*) as jml FROM (
		  SELECT ROW_NUMBER() OVER(ORDER BY A.loo_id asc) AS row,(Count(*) OVER()) AS rows,
			   A.[loo_id]
			  ,A.[la_noloi]
			  ,A.[la_receivedby]
			  ,A.[la_receiveddate]
			  ,A.[la_isreceived]
			  ,A.[la_signdate]
			  ,A.[la_signby]
			  ,A.[la_issigned]
			  ,A.[la_proceeddate]
			  ,A.[la_proceedby]
			  ,A.[la_isproceed]
			  ,C.region_nameshort
			  ,D.branch_name
			  ,E.rekanan_name
			  ,F.rekananshipping_name
		  FROM  [dbo].[transaksi_lareceived]  A
		  LEFT JOIN transaksi_loo B on A.loo_id = B.loo_id
		  LEFT JOIN master_region C on B.region_id = C.region_id
		  LEFT JOIN master_branch D on B.branch_id = D.branch_id
		  LEFT JOIN master_rekanan E on B.rekanan_id = E.rekanan_id
		  LEFT JOIN master_rekananshipping F on  B.rekanan_id = F.rekanan_id and B.rekananshipping_line = F.rekananshipping_line 
		  WHERE 
		  c.region_nameshort LIKE '%$keyword%' 
		  OR D.branch_name LIKE '%$keyword%' 
		  OR E.rekanan_name  LIKE '%$keyword%' 
		  OR F.rekananshipping_name LIKE '%$keyword%' 
		  OR a.la_receivedby LIKE '%$keyword%' 
		  OR a.la_signby LIKE  '%$keyword%'  
		  OR  a.la_proceedby LIKE  '%$keyword%'    
		  OR  a.loo_id LIKE  '%$keyword%'    
		  OR  a.la_noloi LIKE  '%$keyword%'    
		) AS VW");        
        
         $result = $query->row();
		 return $result->jml;
    }


    
    
    
    /**
    *  Get One transaksi_lareceived
    *
    *  @param id : Integer
    *
    *  @return array
    *
    */
    public function get_one($id) 
    {
        $this->db->where('loo_id', $id);
        $result = $this->db->get('transaksi_lareceived');

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
    *  Default form data transaksi_lareceived
    *  @return array
    *
    */
    public function add()
    {
        $data = array(
            
                'loo_id' => '',
            
                'la_noloi' => '',
            
                'la_receivedby' => '',
            
                'la_receiveddate' => '',
            
                'la_isreceived' => '',
            
                'la_signdate' => '',
            
                'la_signby' => '',
            
                'la_issigned' => '',
            
                'la_proceeddate' => '',
            
                'la_proceedby' => '',
            
                'la_isproceed' => '',
            
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
		
		if ((int) $this->input->post('la_isreceived') == 1  )
		{
			$RecDate = $this->input->post('la_receiveddate');
			if(!empty($RecDate))
			{
				$la_receiveddate = date("Y-m-d H:i:s",strtotime($this->input->post('la_receiveddate'))); 
			}
			else
			{
				$la_receiveddate = date("Y-m-d H:i:s"); 
			}
			$la_receivedby  = $this->session->userdata('user_fullname'); 
			$la_isreceived = strip_tags($this->input->post('la_isreceived', TRUE));
		}	
		else
		{
			$la_receivedby = "";
			$la_receiveddate = null;
			$la_isreceived = 0;
		}
		if ((int) $this->input->post('la_issigned') == 1)
		{
			$singDate = $this->input->post('la_signdate');
			if(!empty($singDate))
			{
				$la_signdate = date("Y-m-d H:i:s",strtotime($this->input->post('la_signdate', TRUE)));
			}
			else
			{
				$la_signdate = date("Y-m-d H:i:s");
			}
			 
			$la_signby = $this->session->userdata('user_fullname'); 
			$la_issigned = strip_tags($this->input->post('la_issigned', TRUE));	
		}
		else
		{
			$la_signby = "";
			$la_signdate = null;
			$la_issigned = 0;
		}
		if ((int) $this->input->post('la_isproceed')==1)
		{
		    $procDate = $this->input->post('la_proceeddate');
			if(!empty($procDate))
			{
				$la_proceeddate = date("Y-m-d H:i:s",strtotime($this->input->post('la_proceeddate', TRUE))); 
			}
			else
			{
				$la_proceeddate = date("Y-m-d H:i:s"); 
			}
			
			$la_proceedby = $this->session->userdata('user_fullname'); 
			$la_isproceed = strip_tags($this->input->post('la_isproceed', TRUE));	
		} 
		else
		{
			$la_proceedby = "";
			$la_proceeddate =null;
			$la_isproceed = 0;
		}
		 
		
        $data = array(
        
            'loo_id' => strip_tags($this->input->post('loo_id', TRUE)),
        
            'la_noloi' => strip_tags($this->input->post('la_noloi', TRUE)), 
	
		    'la_receivedby' => $la_receivedby,
	
			'la_receiveddate' => $la_receiveddate,
		
			'la_isreceived' => $la_isreceived,
		 
			'la_signdate' => $la_signdate,
	
			'la_signby' => $la_signby,
		
			'la_issigned' => $la_issigned,	
		 
			'la_proceeddate' => $la_proceeddate,
	
			'la_proceedby' => $la_proceedby,
		
			'la_isproceed' => $la_isproceed,	
		 
        );
         
        $this->db->insert('transaksi_lareceived', $data);
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
		// echo $id;
	    // exit;
		$id = str_replace('_', '/',$id); 
		
		$RecDate = $this->input->post('la_receiveddate');
		if(!empty($RecDate))
		{
			$la_receiveddate = date("Y-m-d H:i:s",strtotime($this->input->post('la_receiveddate'))); 
		} 
		$la_receivedby  = $this->session->userdata('user_fullname');  
		$la_isreceived = strip_tags($this->input->post('la_isreceived', TRUE));
	 
	 
		$singDate = $this->input->post('la_signdate');
		if(!empty($singDate))
		{
			$la_signdate = date("Y-m-d H:i:s",strtotime($this->input->post('la_signdate', TRUE)));
		}  
		$la_signby = $this->session->userdata('user_fullname'); 
		$la_issigned = strip_tags($this->input->post('la_issigned', TRUE));	
	 
	 
		$procDate = $this->input->post('la_proceeddate'); 
		if(!empty($procDate))
		{
			$la_proceeddate = date("Y-m-d H:i:s",strtotime($this->input->post('la_proceeddate', TRUE))); 
		}  
		$la_proceedby = $this->session->userdata('user_fullname'); 
		$la_isproceed = strip_tags($this->input->post('la_isproceed', TRUE));	
		 
        $data = array(
        
                'loo_id' => strip_tags($this->input->post('loo_id', TRUE)),
        
                'la_noloi' => strip_tags($this->input->post('la_noloi', TRUE)),
        
                'la_receivedby' => $la_receivedby,
	
				'la_receiveddate' => $la_receiveddate,
			
				'la_isreceived' => $la_isreceived,
			 
				'la_signdate' => $la_signdate,
		
				'la_signby' => $la_signby,
			
				'la_issigned' => $la_issigned,	
			 
				'la_proceeddate' => $la_proceeddate,
		
				'la_proceedby' => $la_proceedby,
			
				'la_isproceed' => $la_isproceed,	
        
        );
        
        
        $this->db->where('loo_id', $id);
        $this->db->update('transaksi_lareceived', $data);
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
	    $id = str_replace('_', '/',$id);
        $this->db->where('loo_id', $id);
        $this->db->delete('transaksi_lareceived');
        
    }
 
	/**
    *  Get Data For Dialog yang kondisi la_issigned = 1 ( sudah di terima )
    *
    *  From transaksi_loireceived
    * 
    *  @return data
    *
    */
	public function get_data_dialog_loo($search='')
	{
		$where = '';
		 if(!empty($search) )
		 {
			$where = " AND ( a.loo_id like '%$search%' OR d.branch_name LIKE '%$search%' OR e.rekanan_name LIKE '%$search%' OR f.rekananshipping_name LIKE '%$search%')";	
		 }
		
		$query = $this->db->query("SELECT a.loo_id,a.loi_no,c.region_nameshort,d.branch_name,e.rekanan_name,f.rekananshipping_name FROM transaksi_loireceived a
		LEFT JOIN transaksi_loo b on a.loo_id = b.loo_id
		LEFT JOIN master_region c on b.region_id = c.region_id
		LEFT JOIN master_branch d on b.branch_id = d.branch_id
		LEFT JOIN master_rekanan e on b.rekanan_id = e.rekanan_id
		LEFT JOIN master_rekananshipping f on b.rekanan_id  = f.rekanan_id and b.rekananshipping_line = f.rekananshipping_line
		WHERE a.loi_issigned = 1 AND ( a.loo_id NOT IN (SELECT loo_id FROM transaksi_lareceived) OR a.loi_no NOT IN (SELECT la_noloi FROM transaksi_lareceived) )
		$where");  
        $result =$query->result_array();
		//echo $search;exit;
		// echo $endrow;
		// echo '<br>';
		//echo $query;
		// echo $this->db->last_query();exit;
		//echo $where;
        if ($result ) 
        {
            return $result ;
        } 
        else 
        {
            return array();
        }
	}
	
	public function get_data_dialog_loo_rows($search='')
	{
		$where = '';
		 if(!empty($search) )
		 {
			$where = " AND ( a.loo_id like '%$search%' OR d.branch_name LIKE '%$search%' OR e.rekanan_name LIKE '%$search%' OR f.rekananshipping_name LIKE '%$search%')";	
		 }
		
		$query = $this->db->query("SELECT count(a.loo_id) 
		FROM transaksi_loireceived a
		LEFT JOIN transaksi_loo b on a.loo_id = b.loo_id
		LEFT JOIN master_region c on b.region_id = c.region_id
		LEFT JOIN master_branch d on b.branch_id = d.branch_id
		LEFT JOIN master_rekanan e on b.rekanan_id = e.rekanan_id
		LEFT JOIN master_rekananshipping f on b.rekanan_id  = f.rekanan_id and b.rekananshipping_line = f.rekananshipping_line
		WHERE a.loi_issigned = 1 AND a.loo_id NOT IN (SELECT loo_id FROM transaksi_lareceived) AND a.loi_no NOT IN (SELECT la_noloi FROM transaksi_lareceived)
		$where");
        $result =$query->num_rows();
		
		// echo $endrow;
		// echo '<br>';
		//echo $query;
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
}
