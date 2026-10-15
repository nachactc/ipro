<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loounit extends CI_Controller{
    
    function __construct(){
        
        parent::__construct();

        // Check login and make sure email has been verified
		$this->load->library('breadcrumbcomponent');
    }
    
    function index(){       
        
    }
    
}  