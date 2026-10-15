<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 |------------------------------------------------------------------------------
 |	USED ON ADMIN PAGES TO CHECK USER IS LOGGED IN
 |------------------------------------------------------------------------------
 |
 |	Checks that the user is logged in. This function should be called in every
 |	class __construct where the page requires user to be logged in.
 |
*/

if(!function_exists('check_user_login'))
{
	// Checks if user has verified email and is logged in by default. If email_verification is TRUE then it will also check if user has verified email address
	function check_user_login($email_verification = TRUE) {
		$CI =& get_instance();
		
		// Check that a login session has been set
		if($CI->session->userdata('logged_in'))
		{			
			$CI->load->model("login/mdl_login");
			$CI->mdl_login->set_table("master_user");
			$username = $CI->session->userdata('username');
			$query = $CI->mdl_login->get_where($username);
			foreach($query->result() as $row)
			{
				$db_email_ver = $row->user_fullname;
			}
		}
		else
		{
			redirect(base_url() . custom_constants::login_page_url);
		}
	}
}

?>