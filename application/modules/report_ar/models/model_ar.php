<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
class Model_ar extends CI_Model 
{

    public function __construct() 
    {
        parent::__construct();
    }

   
    
	
    public function get_data_ar_report($branch_id,$periode) 
    {  
	 
		//1
		$periode_list =  explode('-',$periode);
		$bln_periode = (strlen($periode_list[1]) === 1 ? '0'.$periode_list[1] : $periode_list[1] );
		$periode_data = $periode_list[0].'-'.$bln_periode; 
		
		$query = "rpt_ipro_ar_Debet ?,?";
		$parameter = array (
		'@periode' => $periode_data,
		'@branch_id' => $branch_id 
		);
		//$query = "EXEC dbo.rpt_ipro_ar_Debet '$periode_data','$branch_id' ";  
	 
		
		$hasil = $this->db->query($query,$parameter);
		//echo $this->db->last_query();
		//exit;
		return $hasil->result_array();  
	}
 
	
	// get branch
    public function get_branch($branch_name,$region_id) 
    {
        $result =  $this->db->query("SELECT a.branch_id,a.branch_name,a.branch_isgroup
		from master_branch a 
		left join master_regionbranch b on a.branch_id = b.branch_id WHERE a.branch_isgroup = 0 and b.region_id = $region_id and a.branch_name like '%$branch_name%'") ->result();  
        return $result;
    }
	// get region
    public function get_region() 
    {
       
        $result = $this->db->get('master_region')
                           ->result();

        $ret ['']= 'Pilih Business Unit :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->region_id] = $row->region_name;
            }
        }
        
        return $ret;
    }
	//get year
	public function get_year()
	{
		$StaringDate = date("Y-m-d");
		$ret = array(); 
		$year = date("Y", strtotime(date("Y-m-d", strtotime($StaringDate)) . " -1 year"));
		$ret[$year] = $year;	 
		for($x=0;$x<=1;$x++)
		{
			$year = date("Y", strtotime(date("Y-m-d", strtotime($StaringDate)) . " + $x year"));
			$ret[$year] = $year;
		} 
		return $ret;
	}
	
	//get month
	public function get_month( $id=NULL )
	{
		$StaringDate = (int)date("m");
		$ret = array(); 
		
		if($id === NULL)
		{
			for($x=1;$x<=12;$x++)
			{
				$yearPrevius = date("Y",strtotime("-1 year"));
				$monthname= getIndoBulan($x);
				$ret[$yearPrevius.'-'.$x] = $monthname.' - '.$yearPrevius;
			}
			
			for($x=1;$x<=$StaringDate;$x++)
			{
				$monthname= getIndoBulan($x);
				$ret[date("Y").'-'.$x] = $monthname.' - '.date("Y");
			} 
			
			return $ret;
		}
		else
		{
			$bln_arr = explode('-',$id);
			$monthname= getIndoBulan($bln_arr[1])." - ".$bln_arr[0];
			return $monthname;
		}
		
	}
	function get_branch_dlg($branch_name="")
	{  
        $this->db->select('r.branch_id, branch_name,c.region_id,c.region_name');
        $this->db->from('master_regionbranch r');
        $this->db->join('master_branch b', 'r.branch_id = b.branch_id');
        $this->db->join('master_region c', 'c.region_id = r.region_id');
		if($branch_name != '')
		{  
			$this->db->like('b.branch_name', $branch_name); 
		}
        $query = $this->db->get();

        $result = $query->result(); 
        return $result; 
		
    }
	
	 public function get_region_dlg() 
    {
       
        $result = $this->db->get('master_region')
                           ->result();

        // $ret ['']= 'Pilih Business Unit :';
        // if($result)
        // {
            // foreach ($result as $key => $row)
            // {
                // $ret [$row->region_id] = $row->region_name;
            // }
        // }
        
        return $result;
    }


	
}