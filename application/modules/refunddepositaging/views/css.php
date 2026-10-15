<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

		if ($this->uri->segment(3)=="" || $this->uri->segment(3)=="list"){
?> 
		
table.dataTable td {
    padding:2px;
    font-size: 9pt;
}

#jDetil th, #jDetil td, #jDetil label {
    font-size: 9pt;
    white-space: nowrap;    
}

#chargeTab th, #chargeTab td, #chargeTab label {

    font-size: 9pt;
    white-space: nowrap;    
}

#depositTab th, #depositTab td, #depositTab label {
    font-size: 9pt;
    white-space: nowrap;    
}

#loanTab th, #loanTab td, #loanTab label {
    font-size: 9pt;
    white-space: nowrap;    
}

.detil {
    padding: 2px;
}

label {
  font-size: 9pt;
  font-weight: bold;
}

.select2-container {
  min-width:120px;
}
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