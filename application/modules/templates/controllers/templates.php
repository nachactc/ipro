<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/************************************************************************
 /* COPYRIGHT NOTICE: Copyright 2017 Harris Susanto, ID 50496269.
 /*
 /* This code is not for non-commercial use. Any commercial usage or
 /* duplication requires a licensing agreement from the author who may be
 /* contacted at the following email address: harris78@yahoo.com
 /*
 /* The author assumes no responsibility for any damage caused by the
 /* proper or inproper use of this code.
 /*
 /* Purpose: Template designed to run with CodeIgniter Modular Extensions - HMVC
 /*
 /* Revision History: Oct, 2017
 /************************************************************************/
 

class Templates extends MX_Controller
{
	private $meta_module;

	function __construct() {
		parent::__construct();
	}

	function admin_template($data) {

		
		$data['username'] = $this->session->userdata['username'];
		$data['user_fullname'] = $this->session->userdata['user_fullname'];
		$data['logged_in_since'] = $this->session->userdata['logged_in_since'];
		$data['user_level'] = $this->session->userdata['user_level'];
		$data['branch_id'] = $this->session->userdata['branch_id'];

		$meta['meta_title'] = $data['meta_title'];
		$meta['meta_description'] = $data['meta_description'];
		
		$this->load->view('templates/admin/admin_template_head', $meta);

		$this->load->view('templates/admin/admin_template_header', $data);
		$this->load->view('templates/admin/admin_template_content', $data);
		$this->load->view('templates/admin/admin_template_footer', $data);
	}
	
	function login_template($data) {
		$meta['meta_title'] = $data['meta_title'];
		$meta['meta_description'] = $data['meta_description'];
		
		$this->load->view('templates/login/login_template_head', $meta);

		$this->load->view('templates/login/login_template_header', $data);
		$this->load->view('templates/login/login_template_content', $data);
		$this->load->view('templates/login/login_template_footer', $data);
	}
	
	function error_template($data) {
		$meta['meta_title'] = $data['meta_title'];
		$meta['meta_description'] = $data['meta_description'];
		
		$this->load->view('templates/error/error_template_head', $meta);

		$this->load->view('templates/error/error_template_header', $data);
		$this->load->view('templates/error/error_template_content', $data);
		$this->load->view('templates/error/error_template_footer', $data);
	}

}
