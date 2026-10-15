<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ($this->uri->segment(4)=="add" || $this->uri->segment(4)=="edit"){
?>
        <!-- load datepicker css for date/time dropdown -->
        <link rel="stylesheet" media="screen, print" href="<?php echo base_url('/assets/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css');?>">
<?php
}      
if ($this->uri->segment(4)=="" || $this->uri->segment(4)=="list"){
?>
        <link rel="stylesheet" media="screen, print" href="<?php echo base_url('/assets/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css');?>">
        <!-- load select2 css for autodropdown using ajax -->
        <link rel="stylesheet" media="screen, print" href="<?php echo base_url('/assets/css/formplugins/select2/select2.bundle.css');?>">
        <!-- load datatable css for datagrid table -->
        <!--<link rel="stylesheet" media="screen, print" href="<?php //echo base_url('/assets/css/datagrid/datatables/datatables.bundle.css');?>">-->
        <link rel="stylesheet" media="screen, print" href="<?php echo base_url('/assets/css/fa-solid.css');?>">
<?php
}
?>