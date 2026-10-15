<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_query extends CI_Model{
    
    function __construct(){
        parent::__construct();
		check_user_login(); 
    }
     
	public function get_data($query)
	{	   
		$db_builder = $this->load->database('builder', TRUE);
		$db_builder->close();
		$db_builder->reconnect();
		$hasil = $db_builder->query(trim($query)); 
		if ($hasil) 
		{
			return $hasil ;
		} 
		else 
		{
			return array();
		} 
		$db_builder->close();
	}  
	
 }