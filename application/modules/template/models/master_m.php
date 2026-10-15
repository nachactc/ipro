<?php

class Master_m extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

function get_channelbyid($id){

        //$id = $this->input->post('id');
        
        $this->db->where('channel_id', $id);
        $this->db->select('channel_id, channel_name, channel_number');
        $query = $this->db->get('master_channel');
                
        return $query->result();
    }
    
    function get_region(){

        //$id = $this->input->post('id');
        
        //$this->db->where('ID', $id);
        $this->db->select('region_id, region_name');
        $query = $this->db->get('master_region');
        
        //echo print_r($query);
        return $query->result();
    }

    function get_regionbyid($id){

        //$id = $this->input->post('id');
        
        $this->db->where('region_id', $id);
        $this->db->select('region_id, region_name, region_nameshort');
        $query = $this->db->get('master_region');
                
        return $query->result();
    }

    function get_regionbyquery($val){

        //$id = $this->input->post('id');
        
        $this->db->like('region_name', $val);
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
    
    function get_branchbyall($name){

        $this->db->select('r.branch_id, b.branch_name, r.region_id');
        $this->db->from('master_regionbranch r');
        $this->db->join('master_branch b', 'r.branch_id = b.branch_id');        
        $this->db->like('b.branch_name', $name);
        $query = $this->db->get();

        return $query->result();
    }

    function get_branchbyquery($name, $region_id){

        $this->db->select('r.branch_id, branch_name');
        $this->db->from('master_regionbranch r');
        $this->db->join('master_branch b', 'r.branch_id = b.branch_id');
        $this->db->where('r.region_id', $region_id);
        $this->db->like('b.branch_name', $name);
        $query = $this->db->get();

        return $query->result();
    }

    function get_agrtype(){
        
        //$this->db->where_in('agreementtype_type', $type);
        $this->db->select('agreementtype_id, agreementtype_name');
        $query = $this->db->get('master_agreementtype');
                
        return $query->result();
    }

function get_agrtypefilter($val){
        
        $this->db->select('agreementtype_id, agreementtype_name, agreementtype_type', 'agreementtype_group');
        $this->db->where_in('agreementtype_type', $val);
        $this->db->order_by('agreementtype_name', 'asc');
        $query = $this->db->get('master_agreementtype');
        
        return $query->result();
    }

     function get_agrtypebytype($val){
        
        //$this->db->where_in('agreementtype_type', $val);
        $this->db->select('agreementtype_id, agreementtype_name, agreementtype_type');
        $this->db->order_by('agreementtype_name', 'asc');
        $query = $this->db->get('master_agreementtype');        
        
        return $query->result();
    }
    
    function get_unit(){
        
        $this->db->select('unit_id, unit_name, branch_id');
        $query = $this->db->get('master_unit');
        
        return $query->result();
    } 

    function get_transaksibytype($val){
    
        $this->db->select('t.transaksi_id, t.transaksi_name');
        $this->db->from('master_transaksi t');
        $this->db->join('master_transaksitransaksitype p', 'p.transaksi_id = t.transaksi_id');
        $this->db->where('p.transaksitype_id', $val);
        $query = $this->db->get(); 
        
        //echo print_r($query);
        return $query->result();
    }  

     function get_unittype(){
                
        $this->db->select('unittype_id, unittype_name');
        $query = $this->db->get('master_unittype');
                
        return $query->result();
    } 

    function get_shippingbyquery($rekanan_id){

        //$this->db->where_in('agreementtype_type', $type);
        $this->db->select('rekanan_id, rekananshipping_line, rekananshipping_name');
        $this->db->from('master_rekananshipping');
        $this->db->where('rekanan_id', $rekanan_id);
        $query = $this->db->get();

        return $query->result();
    } 

function get_strukturunit(){
        
        $this->db->select('strukturunit_id, strukturunit_name');
        $query = $this->db->get('master_strukturunit');
        
        return $query->result();
    }
}