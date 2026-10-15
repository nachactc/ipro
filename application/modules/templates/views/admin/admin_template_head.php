<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title><?php echo $meta_title; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="description" content="<?php echo $meta_description; ?>" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/dist/img/fave-ico.png');?>">

    <link href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/simple-line-icons/simple-line-icons.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/fixedColumns.bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/components.min.css');?>" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?php echo base_url('assets/css/layout.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/themes/darkblue.min2.css');?>" rel="stylesheet" type="text/css" id="style_color" />

    <link href="<?php echo base_url('assets/plugins/bootstrap-switch/css/bootstrap-switch.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/plugins.min.css');?>" rel="stylesheet" type="text/css" />
   
    <link href="<?php echo base_url('assets/plugins/datatables/datatables.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css');?>" rel="stylesheet" type="text/css" />

  	<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/select2/css/select2-bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/jquery-file-upload/css/jquery.fileupload.css');?>" rel="stylesheet" type="text/css" />
   
    <script src="<?php echo base_url('assets/plugins/jquery.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/select2/js/select2.full.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/js.cookie.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/jquery.blockui.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/scripts/datatable.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/datatables/datatables.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/scripts/app.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/scripts/table-datatables-buttons.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/scripts/layout.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/scripts/jquery.number.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/jsinternal/jsgrid.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/scripts/jqBootstrapValidation.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap-sweetalert/sweetalert.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/scripts/ui-sweetalert.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/scripts/dataTables.fixedColumns.min.js');?>" type="text/javascript"></script>
 
    <script src="<?php echo base_url('assets/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-file-upload/js/vendor/load-image.min.js');?>" type="text/javascript"></script>  
    <script src="<?php echo base_url('assets/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-file-upload/js/jquery.iframe-transport.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-file-upload/js/jquery.fileupload.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-file-upload/js/jquery.fileupload-process.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-file-upload/js/jquery.fileupload-image.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-file-upload/js/jquery.fileupload-validate.js');?>" type="text/javascript"></script>

    <script>    
      $(document).ready(function() {
            //Date picker
            $('#coll_date').datepicker({
                format: "yyyy-mm-dd",
				minView : 2,
                autoclose: true
            })
	  });
    </script>    
    <style>
		.modal-header{
    		background-color: #3498db;
		}
		.modal-title{
    		color: white;
		}
		.modal-dialog{
    		padding-top: 0px;
		}
		label {
    		margin-bottom: 0px !important;
		}
		.form-group {
   		 	margin-bottom: 1px !important;
		}
		.nogaris {
      border-style:none;
    }
    table.dataTable tr {
      cursor: pointer; 
    }
    </style>
  </head>
  <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">
  	<div class="page-wrapper">