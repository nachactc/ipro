<?php

class Master_m extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    function get_region(){

        //$id = $this->input->post('id');
        
        //$this->db->where('ID', $id);
        $this->db->select('region_id, region_name');
        $query = $this->db->get('master_region');
        
        //echo print_r($query);
        return $query->result();
    }
    
    function get_branch(){

        //$id = $this->input->post('id');
        
        //$this->db->where('ID', $id);
        $this->db->select('branch_id, branch_name');
        $query = $this->db->get('master_branch');
        
        //echo print_r($query);
        return $query->result();
    }
         
}