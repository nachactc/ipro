<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 class lib_menu {
 function getMenuWeb($username)
 {
	// get data group menu 
	$CI =& get_instance();
	$query = "select a.group_id,b.group_name,b.group_icon
				 from master_userprogramweb a
				 left join master_groupweb b on a.group_id = b.group_id
				 where username = '$username' AND  b.group_isdisabled = 0
				 group by a.group_id,b.group_name,b.group_icon,b.group_code
				 order by b.group_code ASC";
	$hasil_group = $CI->db->query($query);
	// echo var_dump($query);
	// exit;
	if($hasil_group->num_rows() > 0)
	{
		$menu_group = $hasil_group->result();
	 
		//get data menu
		foreach ( $menu_group as $group) { 
			$group_ids = $group->group_id;
			$query_menu = "select a.group_id,a.program_id,b.program_title,b.program_url,b.program_controller
							from master_userprogramweb a
							left join master_programweb b on a.program_id = b.program_id
							where a.username = '$username' and a.group_id = '$group_ids' and b.program_isdisabled = 0
							order by b.program_title ASC";
			$hasil_menu = $CI->db->query($query_menu);
			//echo var_dump($query_menu); //exit;
			if ($hasil_menu->num_rows() > 0) {  
				//set data group and menu
				$menus = '<li class="nav-item start">
                <a href="javascript:;" class="nav-link nav-toggle">
                <i class="'.$group->group_icon.'"></i>
                <span class="title">'.$group->group_name.'</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
                </a>
					<ul class="sub-menu">';
				//lookup menu
				foreach($hasil_menu->result() as $menu_web)
				{
					$menus .= '<li class="nav-item">
								 <a href="'.base_url($menu_web->program_url).'" class="nav-link ">
								 <span class="title">'.$menu_web->program_title.'</span>
								 </a>
							</li>';
				}
				$menus .= '</ul> 
				</li>';
				echo $menus;	
			}
		}
	}
 }
}