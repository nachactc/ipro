<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_semester extends CI_Model{
    
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
    public function get_all($limit, $offset) 
    { 
		$page = 0;
		$startrow =  (((int)$this->uri->segment(3)) - 1 ) ;
		
		$startrow = $startrow <= -1 ? 1 : $startrow;
		$endrow =  ($startrow - 1)  +  $limit;
		$query = $this->db->query('SELECT * FROM (
		  SELECT ROW_NUMBER() OVER(ORDER BY a.semester_id asc) AS row,(Count(*) OVER()) AS rows,
			   a.[semester_id]
			  ,a.[branch_id]
			  ,a.[semester_year]
			  ,a.[group_branchid]
			  ,b.branch_name  
			  ,c.semester_name
		  FROM  [dbo].[master_semesterbranch] a   
		  LEFT JOIN master_branch b on a.branch_id = b.branch_id
		  LEFT JOIN master_semester c on a.semester_id = c.semester_id
		) AS VW
		where row>='.$startrow.' and row<='.$endrow.'  
		order by semester_id asc');  
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
     *  Count All master_semesterbranch
     *    
     *  @return Integer
     *
     */
    public function count_all()
    {
        $this->db->from('master_semesterbranch');
        return $this->db->count_all_results();
    }
    

    /**
    * Search All master_semesterbranch
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
		  SELECT ROW_NUMBER() OVER(ORDER BY a.semester_id asc) AS row,(Count(*) OVER()) AS rows,
			   a.[semester_id]
			  ,a.[branch_id]
			  ,a.[semester_year]
			  ,a.[group_branchid]
			  ,b.branch_name  
			  ,c.semester_name
		  FROM  [dbo].[master_semesterbranch] a   
		  LEFT JOIN master_branch b on a.branch_id = b.branch_id
		  LEFT JOIN master_semester c on a.semester_id = c.semester_id
		  WHERE c.semester_name LIKE '%$keyword%' 
		  OR b.branch_name LIKE  '%$keyword%'  
		  OR  a.semester_year LIKE  '%$keyword%'   
		  OR  a.group_branchid LIKE  '%$keyword%'   
		  OR  a.semester_id LIKE  '%$keyword%'   
		) AS VW
		where row>=$startrow and row<=$endrow  
		order by semester_id asc");  
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
    * Search All master_semesterbranch
    * @param keyword : mixed
    *
    * @return Integer
    *
    */
    public function count_all_search()
    {
        $keyword = $this->session->userdata('keyword');
        $this->db->from('master_semesterbranch');        
        
        return $this->db->count_all_results();
    }

 
    /**
    *  Get One master_semesterbranch
    *
    *  @param id : Integer
    *
    *  @return array
    *
    */
    public function get_one($id,$branch_id) 
    {
        $this->db->where('semester_id', $id);
        $this->db->where('branch_id', $branch_id);
        $result = $this->db->get('master_semesterbranch');

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
    *  Default form data master_semesterbranch
    *  @return array
    *
    */
    public function add()
    {
        $data = array(
            
                'semester_id' => '',
            
                'branch_id' => '',
            
                'semester_year' => '',
				
                'group_branchid' => '',
            
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
        $data = array(
        
            'semester_id' => strip_tags($this->input->post('semester_id', TRUE)),
        
            'branch_id' => strip_tags($this->input->post('branch_id', TRUE)),
        
            'semester_year' => strip_tags($this->input->post('semester_year', TRUE)),
			
            'group_branchid' => strip_tags($this->input->post('group_branchid', TRUE)),
        
        );
        
        
        $this->db->insert('master_semesterbranch', $data);
    }
    
     
    /**
    *  Update modify data
    *
    *  @param id : Integer
    *
    *  @return void
    *
    */
    public function update($id,$branch_id)
    {
        $data = array(
        
                'semester_id' => strip_tags($this->input->post('semester_id', TRUE)),
        
                'branch_id' => strip_tags($this->input->post('branch_id', TRUE)),
        
                'semester_year' => strip_tags($this->input->post('semester_year', TRUE)),
				
                'group_branchid' => strip_tags($this->input->post('group_branchid', TRUE)),
        
        );
        
        // echo $this->input->post('semester_year');
		// exit;
		
        $this->db->where('semester_id', $id); 
		$this->db->where('branch_id', $branch_id);
        $this->db->update('master_semesterbranch', $data);
    }
 
    
    /**
    *  Delete data by id
    *
    *  @param id : Integer
    *
    *  @return void
    *
    */
    public function destroy($id,$branch_id)
    {       
        $this->db->where('semester_id', $id);
        $this->db->where('branch_id', $branch_id);
        $this->db->delete('master_semesterbranch');
        
    } 
    
    // get branch
    public function get_branch() 
    {
      
		$this->db->where('branch_isgroup',0);
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

    // get Semester
    public function get_semester() 
    {
      
        $result = $this->db->get('master_semester')
                           ->result();

        $ret ['']= 'Pilih Semester :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->semester_id] = $row->semester_name;
            }
        }
        
        return $ret;
    }
	
    // get Group
    public function get_groupbranch() 
    {
      
        $result = $this->db->get('master_groupbranch')
                           ->result();

        $ret ['']= 'Pilih Group :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->group_branchid] = $row->group_branchid;
            }
        } 
        return $ret;
    }

    
}