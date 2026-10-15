<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
class Breadcrumbcomponent
{
 protected $data = array();
 

 function __construct() 
 {
 
 }
 
 public function add($title, $uri='') 
 {
  $this->data[] = array('title'=>$title, 'uri'=>$uri);
  return $this;
 }
 
 public function fetch() 
 {
  return $this->data;
 }
 

 public function reset() 
 {
  $this->data = array();
 }
 

 public function show($home_site ="Home", $id = "crumbs"  ) 
 {
  $ci = &get_instance();
  $site = $home_site;
  $breadcrumbs = $this->data;
  $sep="";
  $out  = '<ul id="'.$id.'" class="page-breadcrumb">';
  if ($breadcrumbs && count($breadcrumbs) > 0) {
   $out .= '<li><a  href="' . base_url() .'"/>'. $site . '</a><i class="fa fa-circle"></i></li>';
   $i=1;
   foreach ($breadcrumbs as $crumb): 
 
    if ($i != count($breadcrumbs)) {
     $out .= $sep . '<li><a  href="' .site_url($crumb['uri']). '">'. $crumb['title'] .'</a><i class="fa fa-circle"></i></li>';
    } else {
     $out .= $sep . '<li>'. $crumb['title'] .'</li>';
    }
    $i++;
   endforeach;
  } else {
   $out .= '<li>' . $site . '</li>';
  }
  $out .= '</ul>';
  return $out; 
 }
 
 public function pageTitle($id = "crumbs"  ) 
 {
  $ci = &get_instance();
  $breadcrumbs = $this->data;
  $sep="";
  $out="";
  if ($breadcrumbs && count($breadcrumbs) > 0) {
   $i=1;
   foreach ($breadcrumbs as $crumb): 
 
    if ($i != count($breadcrumbs)) {
     $out .= $crumb['title'] .'&nbsp;';
    } else {
     $out .= $crumb['title'] .'&nbsp;';
    }
    $i++;
   endforeach;
  }
  return $out; 
 }

}