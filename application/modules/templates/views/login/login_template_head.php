<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>

<!DOCTYPE HTML>

<html>
	<head>
		<title><?php echo $meta_title; ?></title>
		<meta charset="utf-8" />
		<meta name="description" content="<?php echo $meta_description; ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<!--[if lte IE 8]><script src="<?php echo base_url();?>assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="<?php echo base_url();?>assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="<?php echo base_url();?>assets/css/ie9.css" /><![endif]-->
	</head>
	<body>