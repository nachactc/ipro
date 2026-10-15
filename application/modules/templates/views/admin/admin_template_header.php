<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>

<div class="page-header navbar navbar-fixed-top">
<div class="page-header-inner">
  <!-- BEGIN LOGO -->
  <div class="page-logo" valign="top">
	<a href="<?php echo base_url(). custom_constants::admin_page_url ?>">
	<img src="<?php echo base_url();?>assets/img/ebyt.png" alt="logo" class="logo-default" /></a>
	<div class="menu-toggler sidebar-toggler">
	  <i class="fa fa-bars" aria-hidden="true" style="color: white;">
	  </i>
	</div>
  </div>
  <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
  <i class="fa fa-bars" aria-hidden="true" style="color: white;"></i>
  </a>
  <div class="top-menu">
	<ul class="nav navbar-nav pull-right">
	  <li class="dropdown dropdown-user">
		<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
		<img alt="" class="img-circle" src="<?php echo base_url();?>assets/img/avatar3_small.jpg" />
		<span class="username username-hide-on-mobile" style="color: white;"> <strong>WELCOME</strong> : <?php echo $user_fullname; ?></span>
		<i class="fa fa-angle-down" style="color: yellow;"></i>
		</a>
		<ul class="dropdown-menu dropdown-menu-default">
		  <li>
			<a href="#">
			<i class="icon-user"></i> My Profile </a>
		  </li>
		  <li>
			<a href="<?php  echo base_url() . custom_constants::logout_url; ?>">
			<i class="icon-key"></i> Log Out </a>
		  </li>
		</ul>
	  </li>
	</ul>
  </div>
</div>
</div>
<div class="clearfix">
</div>