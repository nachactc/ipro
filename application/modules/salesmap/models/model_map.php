<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_map extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
	 function qry_showunit($lantai,$branchid){
	   $qry="select unit_id,unit_nameshort as unit_name,unit_part,unit_sqm,unit_state,unit_coordinate,unit_coordtype,unittype_id,region_id,branch_id,lantai_id from master_unit where unit_coordinate IS NOT NULL and branch_id='$branchid'  and lantai_id='$lantai'";
	   return $this->db->query($qry)->result();	   
   }
   
   function get_mapimage($lantai,$branchid){
	   $qry="select * from master_mapsales where branch_id='$branchid'  and lantai_id='$lantai'";
	   return $this->db->query($qry)->row_array();	   
   }
   
    function get_floorname($lantai){
	   $qry="select lantai_name from master_lantai where lantai_id='$lantai'";
	   return $this->db->query($qry)->row_array();	   
   }
    function get_branchname($branchid){
	   $qry="select branch_name from master_mapmenu where branch_id='$branchid'";
	   return $this->db->query($qry)->row_array();	   
   }
   
   
  function get_mainmenu(){
	   $qry="SELECT branch_id  FROM master_mapmenu";
	   return $this->db->query($qry)->result();	   
   }
   
   function get_submenu(){
	   $qry="SELECT *  FROM master_mapsales";
	   return $this->db->query($qry)->result();	   
   }
  
  
    
   
    
}