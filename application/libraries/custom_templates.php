<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Custom_Templates {
    protected $_ci;

    function __construct(){
        $this->_ci =& get_instance(); 
    }

    function display_menu($data=null){
        return $this->_ci->load->view('templates/admin/admin_template_menu', $data); 
    }

    function display_copyright($data=null){
        return $this->_ci->load->view('templates/admin/admin_template_copyright', $data); 
    }
    
}
?>

