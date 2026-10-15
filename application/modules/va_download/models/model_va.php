<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
class Model_va extends CI_Model 
{

    public function __construct() 
    {
        parent::__construct();
    }

  
    public function get_data_va(  $branch_id,$periode) 
    {  
	 
		//exit;
		$periode_list =  explode('-',$periode);
		$bln_periode = (strlen($periode_list[1]) === 1 ? '0'.$periode_list[1] : $periode_list[1] );
		$periode_data = $periode_list[0].'-'.$bln_periode;
		$query = "EXEC dbo.va_list_periode '$periode_data','$branch_id'"; 
		// echo $query;exit;
		$result = $this->db->query($query); 
		return $result->result_array();
	}
   
    public function get_data_va_insert($branch_id,$periode) 
    {  
	 
		//exit;
		$username = $this->session->userdata('username');
		$periode_list =  explode('-',$periode);
		$bln_periode = (strlen($periode_list[1]) === 1 ? '0'.$periode_list[1] : $periode_list[1] );
		$periode_data = $periode_list[0].'-'.$bln_periode;
		$query2 = "EXEC dbo.va_list_periode '$periode_data','$branch_id'"; 
		$query = "EXEC dbo.va_list_periode_insert '$periode_data','$branch_id','$username' "; 
		
		//echo $query2;
		//exit;
		
		
		$result = $this->db->query($query2); 
		$this->db->query($query); 
		return $result->result_array();
	}
   
	
    public function get_data_va_report(  $branch_id,$periode) 
    {  
	 
		//exit;
		$periode_list =  explode('-',$periode);
		$bln_periode = (strlen($periode_list[1]) === 1 ? '0'.$periode_list[1] : $periode_list[1] );
		$periode_data = $periode_list[0].'-'.$bln_periode;
		$query = "EXEC dbo.va_list_periode_report '$periode_data'"; 
		$result = $this->db->query($query); 
		return $result->result_array();
	}

	// public function get_data_va($region_id, $branch_id,$year) 
    // {  
	 
		// $where = (!empty($branch_id) and $branch_id != 'branch_id' ) ? "AND A.region_id = '$region_id' AND A.branch_id = '$branch_id' and YEAR(A.agreement_createdate) = '$year' " : " AND A.region_id = '$region_id' AND YEAR(A.agreement_createdate) = '$year' ";  
		//// echo $where;
		//// exit;
		// $query = "SELECT 
					// *
				// FROM
				// (
					// select a.region_id,b.region_name,a.branch_id,c.branch_name,d.rekanan_name,e.rekananshipping_name,a.agreement_virtualaccount
					// from transaksi_agreement a
					// left join master_region b on a.region_id = b.region_id
					// left join master_branch c on a.branch_id = c.branch_id
					// left join master_rekanan d on a.rekanan_id = d.rekanan_id
					// left join master_rekananshipping e on a.rekanan_id = e.rekanan_id and a.rekananshipping_line = e.rekananshipping_line
					// where agreement_isclosed = 0
					// and agreement_isapproved = 1	
					// $where
					// union all
					// select a.region_id,b.region_name,a.branch_id,c.branch_name,d.rekanan_name,e.rekananshipping_name,a.agreement_virtualaccount
					// from transaksi_agreementtemp a
					// left join master_region b on a.region_id = b.region_id
					// left join master_branch c on a.branch_id = c.branch_id
					// left join master_rekanan d on a.rekanan_id = d.rekanan_id
					// left join master_rekananshipping e on a.rekanan_id = e.rekanan_id and a.rekananshipping_line = e.rekananshipping_line
					// where agreement_isclosed = 0
					// and agreement_isapproved = 1
					// $where
					// union all
					// select a.region_id,b.region_name,a.branch_id,c.branch_name,d.rekanan_name,e.rekananshipping_name,a.virtualaccount
					// from transaksi_loounit a
					// left join master_region b on a.region_id = b.region_id
					// left join master_branch c on a.branch_id = c.branch_id
					// left join master_rekanan d on a.rekanan_id = d.rekanan_id
					// left join master_rekananshipping e on a.rekanan_id = e.rekanan_id and a.rekananshipping_line = e.rekananshipping_line
					// where ISNULL(isclosed,0) = 0 
					// ".str_replace('agreement_createdate','loounit_sdate',$where)." 
					// and ISNULL(virtualaccount,'') <> ''
				// ) as vw ";
		// $result = $this->db->query($query); 
		// echo $this->db->last_query($where);
		// exit;
		// return $result->result_array();
    // }
	
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
			$monthname= getIndoBulan($bln_arr[1])." - ".date("Y");
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