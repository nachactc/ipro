<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_query extends CI_Model{
    
    function __construct(){
        parent::__construct();
		check_user_login(); 
    }
     
	public function get_data()
	{	   
		$username = $this->session->userdata('username'); 
		
		$sql = "SELECT * FROM master_user WHERE username = '$username'";
		
		$hasil = $this->db->query($sql);
		return $hasil->row_array();
	} 
	
	public function save_data()
	{
		$username = $this->session->userdata('username'); 
		$password = $this->input->post('chgPwd');
		$userfullname = $this->input->post('userfullname');
		if($password != ''){
			$password = md5($password);
			$sql = "UPDATE master_user 
			SET user_password = '$password' ,
			password_web = '$password',
			user_fullname = '$userfullname' 
			WHERE username = '$username'";
			$hasil = $this->db->query($sql); 
			if($hasil){
				return true;
			}else{
				return false;
			}
		} 
		return false;
	}
	
 }