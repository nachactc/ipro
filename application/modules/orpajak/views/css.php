<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

		if ($this->uri->segment(3)=="" || $this->uri->segment(3)=="list"){
?> 

<?php
		} 
		if ($this->uri->segment(3)=="add" || $this->uri->segment(3)=="edit"){
?> 
	    <style>
			.select2-close-mask{
				z-index: 2099;
			}
			.select2-dropdown{
				z-index: 3051;
			} 
	    </style>  
<?php
		}
?>