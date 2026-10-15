<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	function sentenceCase($string) { 
    $sentences = preg_split('/([.?!]+)/', $string, -1,PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE); 
    $newString = ''; 
    foreach ($sentences as $key => $sentence) { 
        $newString .= ($key & 1) == 0? 
            ucfirst(strtolower(trim($sentence))) : 
            $sentence.' '; 
    } 
    return trim($newString); 
}  
	 function getMenuloo(){
		  
		$CI =& get_instance();
		$CI->db->distinct();
		$CI->db->select('a.branch_id,b.branch_name');
		$CI->db->from('master_mapmenu a'); 
		$CI->db->join('master_branch b','a.branch_id=b.branch_id','join'); 
		$CI->db->join('master_mapsales c','a.branch_id=c.branch_id','join'); 
		
		   
		$main_menu2 = $CI->db->get();
		
		$vgroupqry = $main_menu2->result(); 
		
		
		foreach ($vgroupqry as $groupqry) {
				
		$CI_sub =& get_instance();
		$group_id=$groupqry->branch_id;
		$group_name=$groupqry->branch_name;
		
		
		echo "<li class='nav-item'>";
        echo "<a href='javascript:;' class='nav-link nav-toggle'>";
		echo "<span class='title'>$group_name</span>";
        echo "<span class='arrow'></span></a>";
		
		if ($main_menu2->num_rows() > 0) { 
        echo "<ul class='sub-menu'>";
		 }
                     
					
		$CI_sub->db->select('a.lantai_id,a.map_filename,a.map_filew,a.map_fileh,b.lantai_name');
		$CI_sub->db->from('master_mapsales a'); 
		$CI->db->join('master_lantai b','a.lantai_id=b.lantai_id','join'); 
 		$CI_sub->db->where('a.branch_id',$group_id);
		$vsubgroupqry= $CI_sub->db->get();
			
		 if ($vsubgroupqry->num_rows() > 0) {  
		   foreach ($vsubgroupqry->result() as $sub) {
			   $lantai=$sub->lantai_id;
			   $lantai_name=$sub->lantai_name;
					echo "<li class='nav-item '>";
                	echo "<a href='".base_url('index.php/salesmap/showmap/'.$lantai.'/'.$group_id.'')."'' class='nav-link '> $lantai_name </a>";
                	echo "</li>";
				}
				echo "</ul></li>";

		}
		
	}
 }

	
	
	

function getTenantLoo1($branchid,$unitid){
		  $CI =& get_instance();
		  $CI->load->model('model_map');
		  $vcontent="";
		  $vhsl=$CI->db->query("select distinct top 2 a.rekanan_id,a.rekananshipping_line,a.loo_id,replace(c.rekananshipping_name,'''','') as rekananshipping_name  from transaksi_loo a inner join transaksi_loodetil b
on a.loo_id=b.loo_id  inner join master_rekananshipping c
on a.rekanan_id=c.rekanan_id and a.rekananshipping_line=c.rekananshipping_line
where a.branch_id='$branchid' and b.unit_id='$unitid' and a.isconfirm='0'");
		foreach ($vhsl->result() as $sub) {
			$vnama=$sub->rekananshipping_name;
			$vid=$sub->loo_id;
   			$vcontent .="$vnama<br>";
			
		}
		return $vcontent;
		  
	  }
	  

	function getTenantLooscbr($branchid,$unitid){
		  $CI =& get_instance();
		  $CI->load->model('model_map');
		  $vcontent="";
		  $vhsl=$CI->db->query("select distinct top 2 a.rekanan_id,a.rekananshipping_line,a.loo_id,replace(c.rekananshipping_name,'''','') as rekananshipping_name from transaksi_loo a inner join transaksi_loodetil b
on a.loo_id=b.loo_id  inner join master_rekananshipping c
on a.rekanan_id=c.rekanan_id and a.rekananshipping_line=c.rekananshipping_line
where a.branch_id='$branchid' and b.unit_id='$unitid' and a.isapproved='1'");
		foreach ($vhsl->result() as $sub) {
			$vnama=$sub->rekananshipping_name;
			$vid=$sub->loo_id;
   			$vcontent .="$vnama<br>";
			
		}
		return $vcontent;
		  
	  }
	  
	   function getTenantLoibr($branchid,$unitid){
		  $CI =& get_instance();
		  $CI->load->model('model_map');
		  $vcontent="";
		  $vhsl=$CI->db->query("select distinct a.rekanan_id,a.rekananshipping_line,a.loo_id,replace(c.rekananshipping_name,'''','') as rekananshipping_name from transaksi_loo a inner join transaksi_loodetil b
on a.loo_id=b.loo_id  inner join master_rekananshipping c
on a.rekanan_id=c.rekanan_id and a.rekananshipping_line=c.rekananshipping_line
where a.branch_id='$branchid' and b.unit_id='$unitid' and a.isapproved='1'");
		foreach ($vhsl->result() as $sub) {
			$vnama=$sub->rekananshipping_name;
			$vid=$sub->loo_id;
			$vcontent .="$vnama<br>";
			
		}
		return $vcontent;
		  
	  }
	  function getTenantLoi($branchid,$unitid){
		  $CI =& get_instance();
		  $CI->load->model('model_map');
		  $vcontent="";
		  $vhsl=$CI->db->query("select distinct a.rekanan_id,a.rekananshipping_line,a.loo_id,c.rekananshipping_name from transaksi_loo a inner join transaksi_loodetil b
on a.loo_id=b.loo_id  inner join master_rekananshipping c
on a.rekanan_id=c.rekanan_id and a.rekananshipping_line=c.rekananshipping_line
where a.branch_id='$branchid' and b.unit_id='$unitid' and a.isapproved='1'");
		foreach ($vhsl->result() as $sub) {
			$vnama=$sub->rekananshipping_name;
			$vid=$sub->loo_id;
			$vcontent .="<tr>";
   			$vcontent .="<td>$vid</td>";
   			$vcontent .="<td>$vnama</td>";
  			$vcontent .="</tr>";
			
		}
		return $vcontent;
		  
	  }
	        
      function getTenantLoo($branchid,$unitid){
		  $CI =& get_instance();
		  $CI->load->model('model_map');
		  $vcontent="";
		  $vhsl=$CI->db->query("select distinct a.rekanan_id,a.rekananshipping_line,a.loo_id,c.rekananshipping_name from transaksi_loo a inner join transaksi_loodetil b
on a.loo_id=b.loo_id  inner join master_rekananshipping c
on a.rekanan_id=c.rekanan_id and a.rekananshipping_line=c.rekananshipping_line
where a.branch_id='$branchid' and b.unit_id='$unitid'");
		foreach ($vhsl->result() as $sub) {
			$vnama=$sub->rekananshipping_name;
			$vid=$sub->loo_id;
			$i_link = str_replace('/', '_', $sub->loo_id);
			$vcontent .="<tr>";
   			$vcontent .="<td>$vid</td>";
   			$vcontent .="<td>$vnama</td>";
			$vcontent .="<td><a href=".base_url('index.php/looprint/looprint/looprintpdf/'.$i_link.'')." target='_blank'><i class='fa fa-print'></i></></td>";
  			$vcontent .="</tr>";
			
		}
		return $vcontent;
		  
	  }

	
	 
          
     