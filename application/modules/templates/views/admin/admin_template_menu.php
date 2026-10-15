<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//style="background-color:#2B9ca6"
  
?>
          <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-light " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <li class="sidebar-toggler-wrapper hide">
              <div class="sidebar-toggler">
                <span>
                </span>
              </div>
            </li>
            <li class="nav-item">
              <a href="/index.php" class="nav-link nav-toggle">
              <i class="icon-home" style="color: white;"></i>
              <span class="title" style="color: white;">Home</span>
              </a>
            </li>

            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-briefcase"></i>
                <span class="title">Floor Plan</span><span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                  <?php echo getMenuloo();?>
                </ul>
            </li>
          </ul>