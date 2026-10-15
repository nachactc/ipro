<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
  
class master_rekananshippings extends CI_Model 
{

    public function __construct() 
    {
        parent::__construct();
    }


    /**
     *  Get All data master_rekananshipping
     *
     *  @param limit  : Integer
     *  @param offset : Integer
     *
     *  @return array
     *
     */
    public function get_all($limit, $offset) 
    {
		$this->db->select('rekanan_id','rekananshipping_line','rekananshipping_address','rekananshipping_contactemail','rekananshipping_contacthp','rekananshipping_contactname','rekananshipping_contacttelp','rekananshipping_desc','rekananshipping_isactive','rekananshipping_type','rekananshipping_name','rekananshipping_namereport','rekananshipping_npwp','rekananshipping_npwp_addr','rekananshipping_npwp_name,master_branch.branch_name as branch_name, rekananshippingtype_name as type_name ');
		$this->db->join('master_branch','master_branch.branch_id = master_rekananshipping.branch_id ');
		$this->db->join('master_rekananshippingtype','master_rekananshippingtype.rekananshipping_type = master_rekananshipping.rekananshipping_type ');
        $result = $this->db->get('master_rekananshipping');

        if ($result->num_rows() > 0) 
        {
            return $result->result_array();
        } 
        else 
        {
            return array();
        }
    }

    

    /**
     *  Count All master_rekananshipping
     *    
     *  @return Integer
     *
     */
    public function count_all()
    {
        $this->db->from('master_rekananshipping');
        return $this->db->count_all_results();
    }
    

    /**
    * Search All master_rekananshipping
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
        
        $this->db->limit($limit, $offset);
        $result = $this->db->get('master_rekananshipping');

        if ($result->num_rows() > 0) 
        {
            return $result->result_array();
        } 
        else 
        {
            return array();
        }
    }

    
    
    
    
    
    /**
    * Search All master_rekananshipping
    * @param keyword : mixed
    *
    * @return Integer
    *
    */
    public function count_all_search()
    {
        $keyword = $this->session->userdata('keyword');
        $this->db->from('master_rekananshipping');        
        
        return $this->db->count_all_results();
    }


    
    
    
    /**
    *  Get One master_rekananshipping
    *
    *  @param id : Integer
    *
    *  @return array
    *
    */
    public function get_one($rekanan_id) 
    {
         
		$query = $this->db->query('SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY rekanan_id asc) AS row,(Count(*) OVER()) AS rows, a.*,b.branch_name,c.rekananshippingtype_name as type_name FROM master_rekananshipping a 
		left join master_branch b on a.branch_id=b.branch_id
		left join master_rekananshippingtype c on c.rekananshippingtype_id = a.rekananshipping_type  
		where a.rekanan_id ='.$rekanan_id.'  ) AS VW 
		order by row asc');  
        $result =$query->result_array();
		 
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
    *  Get One master_rekananshipping
    *
    *  @param id : Integer
    *
    *  @return array
    *
    */
    public function get_one_edit($rekanan_id,$rekananshipping_line) 
    {
         
		$query = $this->db->query('SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY rekanan_id asc) AS row,(Count(*) OVER()) AS rows,* FROM master_rekananshipping where rekanan_id ='.$rekanan_id.' and rekananshipping_line = '.$rekananshipping_line.' ) AS VW 
		order by row asc');  
        $result =$query->row_array();
		 
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
    *  Default form data master_rekananshipping
    *  @return array
    *
    */
    public function add()
    {
        $data = array(
            
                'rekanan_id' => '',
            
                'rekananshipping_line' => '',
            
                'rekananshipping_name' => '',
            
                'rekananshipping_address' => '',
            
                'rekananshipping_contactname' => '',
            
                'rekananshipping_contacthp' => '',
            
                'rekananshipping_contacttelp' => '',
            
                'rekananshipping_contactemail' => '',
            
                'rekananshipping_profitsharringvalue' => '',
            
                'rekananshipping_reglistrik' => '',
            
                'rekananshipping_regair' => '',
            
                'rekananshipping_reggas' => '',
            
                'noreg_air' => '',
            
                'noreg_gas' => '',
            
                'noreg_listrik' => '',
            
                'salesarea_id' => '',
            
                'rowid' => '',
            
                'noreg_solar' => '',
            
                'rekananshipping_regsolar' => '',
            
                'rekananshipping_tax' => '',
            
                'branch_id' => '',
            
                'rekananshipping_isactive' => '',
            
                'rekananshipping_type' => '',
            
                'rekananshipping_desc' => '',
            
                'rekananshipping_namereport' => '',
            
                'rekananshipping_npwp' => '',
            
                'rekananshipping_npwp_addr' => '',
            
                'rekananshipping_npwp_name' => '',
				
                'rekananshipping_type' => '',
				
                'rowid' => '',
				
                'rekananshipping_tax' => '10',
            
        );

        return $data;
    }

    
	public function getDebtorCode($branch_id,$rekanan_id)
	{
		$branch_output = '';
		$sql = "exec cp_getDebtorCode'$branch_id','$rekanan_id',$branch_output OUTPUT"; 
		$result = $this->db->query($sql)->row_array();
		return  $result['debtor'];
	}
    
    
    
    /**
    *  Save data Post
    *
    *  @return void
    *
    */
    public function save($id_rekanan) 
    {
		
		$branch_id = strip_tags($this->input->post('branch_id', TRUE));
		
		if($id_rekanan != '' and $branch_id != '')
		{ 
			  $branch_id = strip_tags($this->input->post('branch_id', TRUE));
			  $ship_name = html_entity_decode($this->input->post('rekananshipping_name'));
			  $ship_nameReport = html_entity_decode($this->input->post('rekananshipping_namereport'));
			  $data = array(
        
					'rekanan_id' => $id_rekanan,
				
					'rekananshipping_line' => ($this->get_line($id_rekanan) + 10),
				
					'rekananshipping_name' =>  $ship_name,
				
					'rekananshipping_address' => strip_tags($this->input->post('rekananshipping_address', TRUE)),
				
					'rekananshipping_contactname' => strip_tags($this->input->post('rekananshipping_contactname', TRUE)),
				
					'rekananshipping_contacthp' => strip_tags($this->input->post('rekananshipping_contacthp', TRUE)),
				
					'rekananshipping_contacttelp' => strip_tags($this->input->post('rekananshipping_contacttelp', TRUE)),
				
					'rekananshipping_contactemail' => strip_tags($this->input->post('rekananshipping_contactemail', TRUE)),
				  
					'branch_id' => $branch_id,
				
					'rekananshipping_isactive' => strip_tags($this->input->post('rekananshipping_isactive', TRUE)),
				
					//'rekananshipping_type' => strip_tags($this->input->post('rekananshipping_type', TRUE)),
				
					'rekananshipping_desc' => strip_tags($this->input->post('rekananshipping_desc', TRUE)),
				
					'rekananshipping_namereport' => $ship_nameReport,
				
					'rekananshipping_npwp' => strip_tags($this->input->post('rekananshipping_npwp', TRUE)),
				
					'rekananshipping_npwp_addr' => strip_tags($this->input->post('rekananshipping_npwp_addr', TRUE)),
				
					'rekananshipping_npwp_name' => strip_tags($this->input->post('rekananshipping_npwp_name', TRUE)),
					
					
					'rekananshipping_type' => strip_tags($this->input->post('rekananshipping_type', TRUE)),
					
					'rekananshipping_tax' => strip_tags($this->input->post('rekananshipping_tax', TRUE)),
					
					'rowid' => $this->getDebtorCode($branch_id,$id_rekanan),
					
				 
				); 
				// echo var_dump($data);
				// exit;
				$this->db->insert('master_rekananshipping', $data);
		}
      
    }
    
    
    

    
    /**
    *  Update modify data
    *
    *  @param id : Integer
    *
    *  @return void
    *
    */
    public function update($id_rekanan,$rekananshipping_line)
    {
		//echo html_entity_decode('&#039;');exit;
		$ship_name =  html_entity_decode( strip_tags($this->input->post('rekananshipping_name', TRUE))) ;
		$ship_nameReport = html_entity_decode( $this->input->post('rekananshipping_namereport'));
        $data = array(
        
                 
        
                'rekananshipping_name' =>$ship_name,
        
                'rekananshipping_address' => strip_tags($this->input->post('rekananshipping_address', TRUE)),
        
                'rekananshipping_contactname' => strip_tags($this->input->post('rekananshipping_contactname', TRUE)),
        
                'rekananshipping_contacthp' => strip_tags($this->input->post('rekananshipping_contacthp', TRUE)),
        
                'rekananshipping_contacttelp' => strip_tags($this->input->post('rekananshipping_contacttelp', TRUE)),
        
                'rekananshipping_contactemail' => strip_tags($this->input->post('rekananshipping_contactemail', TRUE)), 
        
                'branch_id' => strip_tags($this->input->post('branch_id', TRUE)),
        
                'rekananshipping_isactive' => strip_tags($this->input->post('rekananshipping_isactive', TRUE)),
        
                'rekananshipping_type' => strip_tags($this->input->post('rekananshipping_type', TRUE)),
        
                'rekananshipping_desc' => strip_tags($this->input->post('rekananshipping_desc', TRUE)),
        
                'rekananshipping_namereport' => $ship_nameReport,
        
                'rekananshipping_npwp' => strip_tags($this->input->post('rekananshipping_npwp', TRUE)),
        
                'rekananshipping_npwp_addr' => strip_tags($this->input->post('rekananshipping_npwp_addr', TRUE)),
        
                'rekananshipping_npwp_name' => strip_tags($this->input->post('rekananshipping_npwp_name', TRUE)),
				
				'rekananshipping_type' => strip_tags($this->input->post('rekananshipping_type', TRUE)),
					
				'rowid' => strip_tags($this->input->post('rowid', TRUE)),
				
				'rekananshipping_tax' => strip_tags($this->input->post('rekananshipping_tax', TRUE)),
        
        );
        
      
		
        $this->db->where('rekanan_id', $id_rekanan);
        $this->db->where('rekananshipping_line', $rekananshipping_line);
        $this->db->update('master_rekananshipping', $data);
		// echo $this->db->last_query();exit;
    }


    
    
    
    /**
    *  Delete data by id
    *
    *  @param id : Integer
    *
    *  @return void
    *
    */
    public function destroy($id_rekanan,$rekananshipping_line)
    {       
        $this->db->where('rekanan_id', $id_rekanan);
        $this->db->where('rekananshipping_line', $rekananshipping_line);
        $this->db->delete('master_rekananshipping');
        
    }







    
    
    // get ar_alloc_ari
    public function combo_branch() 
    {
      
        $result = $this->db->get('master_branch')
                           ->result();

        $ret ['']= 'Pilih Branch :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->branch_id] = $row->branch_name;
            }
        }
        
        return $ret;
    }
    // get combo_shipping_type
    public function combo_shipping_type() 
    {
      
        $result = $this->db->get('master_rekananshippingtype')
                           ->result();

        $ret ['']= 'Pilih Type :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->rekananshippingtype_id] = $row->rekananshippingtype_name;
            }
        }
        
        return $ret;
    }


	public function get_line($rekanan_id)
	{
		// $this->db->select('rekananshipping_line');
		// $this->db->where('rekanan_id',$rekanan_id);
		// $this->db->order_by('rekananshipping_line','desc');
		// $result = $this->db->get('master_rekananshipping');\
		$query = "SELECT TOP 1 rekananshipping_line FROM master_rekananshipping WHERE rekanan_id = $rekanan_id ORDER BY rekananshipping_line DESC";
		$result = $this->db->query($query)->row_array();
		
		//echo $this->db->last_query();
		 
        return $result['rekananshipping_line'];
        
	}
	
    



}
