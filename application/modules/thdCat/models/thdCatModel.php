<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
class thdCatModel extends CI_Model 
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
				$startrow =  (((int)$this->uri->segment(3)) - 1 ) ;
				$startrow = $startrow <= -1 ? 1 : $startrow;
				$endrow =  ($startrow - 1)  +  $limit;

				$query = $this->db->query('
						SELECT * FROM (
							SELECT ROW_NUMBER() OVER(ORDER BY thdcat_id asc) AS row,(Count(*) OVER()) AS rows,  * 
							FROM master_thdcat
						) AS VW
						where row>='.$startrow.' and row<='.$endrow.'  
						order by thdcat_id asc'
				);  

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
        $this->db->from('master_thdcat');
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
                
				$page = 0;
				$startrow =  (((int)$this->uri->segment(3)) - 1 ) ;
				$startrow = $startrow <= -1 ? 1 : $startrow;
				$endrow =  ($startrow - 1)  +  $limit;
				
				$query = $this->db->query("
						SELECT * FROM (
							SELECT  ROW_NUMBER() OVER(ORDER BY thdcat_id asc) AS row,(Count(*) OVER()) AS rows,* 
							FROM master_thdcat 
							WHERE thdcat_id like '%$keyword%' or thdcat_name like '%$keyword%'
						) AS VW
						where row>=$startrow and row<=$endrow 
						order by row asc
				");  
	 
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
        $limit = $this->config->item('per_page');
        $page = 0;
				$startrow =  (((int)$this->uri->segment(3)) - 1 ) ;
				$startrow = $startrow <= -1 ? 1 : $startrow;
				$endrow =  ($startrow - 1)  +  $limit;

				$query = $this->db->query("
					SELECT count(*) as total FROM (
						SELECT  ROW_NUMBER() OVER(ORDER BY thdcat_id asc) AS row,(Count(*) OVER()) AS rows,* 
						FROM master_thdcat 
						WHERE thdcat_id like '%$keyword%' or 
							thdcat_name like '%$keyword%'
					) AS VW
					where row>=$startrow and row<=$endrow  
				");  

        $result = $query->row();   

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
        $this->db->where('thdcat_id', $id);
        $result = $this->db->get('master_thdcat');
				//echo $this->db->last_query();exit;

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

						'thdcat_id' => '',            
						'thdcat_name' => '',                                     
						'thdcat_createby' => '',            
						'thdcat_createdate' => date("Y-m-d"),            
						'thdcat_modifyby' => '',            
						'thdcat_modifydate' => date("Y-m-d")            
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
				
				$id = strip_tags($this->input->post('thdcat_id', TRUE));
				
				$db_debug = $this->db->db_debug;
				$this->db->db_debug = FALSE; 

				$data = array(
				
						'thdcat_id' => $id, //$id_branch,        
						'thdcat_name' => strip_tags($this->input->post('thdcat_name', TRUE)),        
						'thdcat_createby' =>$this->session->userdata('user_name'),        
						'thdcat_createdate' => date('Y-m-d H:i:s'),                 
				);     
					
				if(!$this->db->insert('master_thdcat', $data)){
					$error = $this->db->error();	
					$this->db->db_debug = $db_debug;									
					$this->session->set_flashdata('error', $error['message']);
					redirect('thdCat/add');	
				};

				$this->db->db_debug = $db_debug;			
				return $id;	
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
				$id = strip_tags($this->input->post('thdcat_id', TRUE));
				
				$db_debug = $this->db->db_debug;
				$this->db->db_debug = FALSE; 

				$data = array(
				
						'thdcat_id' => $id, //$id_branch,        
						'thdcat_name' => strip_tags($this->input->post('thdcat_name', TRUE)),        
						'thdcat_modifyby' =>$this->session->userdata('user_name'),        
						'thdcat_modifydate' => date('Y-m-d H:i:s'),                 
				);     
					
      	$this->db->where('thdcat_id', $id);
				if(!$this->db->update('master_thdcat', $data)){
					$error = $this->db->error();	
					$this->db->db_debug = $db_debug;									
					$this->session->set_flashdata('error', $error['message']);
					redirect('thdCat/edit/'.$id);	
				};

				$this->db->db_debug = $db_debug;
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

        $this->db->where('thdcat_id', $id);
        $this->db->delete('master_thdcat');
    }
 
       
	
   
}
