<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
class Model_summary_soa extends CI_Model 
{

    public function __construct() 
    {
        parent::__construct();
    }

  
    public function get_data_summary($year,$region,$branch,$startdate,$enddate ) 
    {  
	 
	
		//$this->load->library('table');
		//@branch  @startdate @enddate
		$stored_pocedure = " exec sp_rpt_summary_type '$year','$region','$branch','$startdate','$enddate' ";
	    //echo $stored_pocedure;exit;
		$result = $this->db->query($stored_pocedure); 
		
		// $template = array(
				// 'table_open' => '<table border="1" style="undefined;table-layout: fixed; width: 2400px;" class="tg" id="SummarySOA_'.$year.'_'.date('d_m_Y_s').'">'
		// );

		// $this->table->set_template($template);

		//$data['result'] = $this->table->generate($result);
		$data['result'] = $result->result();
		$data['column'] = $result->list_fields();
		return $data;
    }
	
    public function get_data_forecastdetil($month,$typeTrx,$year) 
    {  
	$criteria = '';
	 
		$stored_pocedure = " exec sp_rpt_ar_forecast_detil '$year','$month','$typeTrx' ";
	    //echo $stored_pocedure;exit;
		$result = $this->db->query($stored_pocedure); 
		return $result->result();
    }
	
	// get branch
    public function get_branch($branch_name,$region_id) 
    {
        $result =  $this->db->query("SELECT a.branch_id,a.branch_name,a.branch_isgroup
		from master_branch a 
		left join master_regionbranch b on a.branch_id = b.branch_id WHERE a.branch_isgroup = 0 and b.region_id = $region_id and a.branch_name like '%$branch_name%'") ->result();
		// $this->db->where('branch_isgroup',0);
        // $result = $this->db->get('master_branch')
                           // ->result();

        // $ret ['']= 'Pilih Store :';
        // if($result)
        // {
            // foreach ($result as $key => $row)
            // {
                // $ret [$row->branch_id] = $row->branch_name;
            // }
        // }
        
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

	 public function get_data_thd_summary($region_id, $branch_id) 
    {  
		$stored_pocedure = "EXEC Rpt03_Select_Tenant_History_Summary '$region_id','$branch_id'";
		$result = $this->db->query($stored_pocedure); 
		return $result->result_array();
    }
	
    public function get_data_thd2($branch_id,$region_id) 
    {   
		$stored_pocedure = "EXEC RptIpro01_Select_Tenant_THD '$branch_id','$region_id'"; 
		//echo $stored_pocedure;exit;
		$result = $this->db->query($stored_pocedure); 
		return $result->result();
    }
	
    public function get_data_thd2_tb($branch_id,$region_id) 
    {   
		$stored_pocedure = "EXEC RptIpro01_Select_Tenant_THD_TB '$branch_id','$region_id'"; 
		//echo $stored_pocedure;exit;
		$result = $this->db->query($stored_pocedure); 
		return $result->result();
    }

    public function get_data_thd2_summary2($branch_id,$region_id) 
    {   
		$stored_pocedure = "EXEC RptIpro01_Select_Tenant_THD_SumProforma '$branch_id','$region_id'"; 
		//echo $stored_pocedure;exit;
		$result = $this->db->query($stored_pocedure); 
		return $result->result();
    }

	public function get_branch_info($branch_id)
	{ 
		$result =  $this->db->query("SELECT a.branch_id,a.branch_name,b.region_id,c.region_namereport,a.branch_openingdate
		from master_branch a 
		left join master_regionbranch b on a.branch_id = b.branch_id 
		left join master_region c on b.region_id = c.region_id
		WHERE a.branch_isgroup = 0 and   a.branch_id =  '$branch_id'") ;
		if($result->num_rows() > 0)
		{
			return $result->row();
		}
		else
		{
			return 'kosong';
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
