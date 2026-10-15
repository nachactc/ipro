<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$username_email_input = array(
"name" => "username",
"id" => "username",
"maxlength" => "24",
"placeholder" => "Username",
"required" => "required"
);

$password_input = array(
"name" => "password",
"id" => "password",
"maxlength" => "32",
"placeholder" => "Password",
"required" => "required"
);

$username_email_input['value'] = $this->session->flashdata("username");

// If currently black listed then show time left before removed from black list. Otherwise show the login form
echo form_open(custom_constants::login_page_url,"id='signup-form'");
echo form_input($username_email_input);
echo form_password($password_input);

if(validation_errors()){
	
	echo "<div class='form-errors'>";	
	echo validation_errors();	
	echo "</div>";	
}

if(isset($auth_failed))
{	
	echo "<div class='form-errors'>";	
	echo "<p>Invalid Username/Password</p>";	
	echo "</div>";	
}


if($this->session->flashdata('timed_out'))
{	
	if($this->session->flashdata('timed_out') === 'TRUE')
	{		
		echo "<div class='form-errors'>";		
		echo "<p>Session timed out</p>";		
		echo "</div>";		
	}	
}

echo form_submit("submit", "Sign In");
// Close form-options

if(custom_constants::registration_disable === FALSE)
{	
	//echo "<p class='register-link'>or <a href='" . base_url() . custom_constants::register_url . "'>forgot password</a></p>";	
}


// Close the form
echo form_close();



?>