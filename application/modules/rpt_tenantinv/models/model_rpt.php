<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_rpt extends CI_Model{
    
    function __construct(){
        parent::__construct();
		check_user_login();
		//ini_set("memory_limit","25M"); 
		ini_set("sqlsrv.ClientBufferMaxKBSize","524288");
		ini_set("pdo_sqlsrv.client_buffer_max_kb_size","524288");
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
    function get_region_dlg($region_name="")
	{  
        $this->db->select('r.region_id, r.region_name');
        $this->db->from('master_region r'); 
		if($region_name != '')
		{  
			$this->db->like('r.region_name', $region_name); 
		}
        $query = $this->db->get();

        $result = $query->result(); 
        return $result; 
		
    }
    
	function get_rekanan_dlg($rekanan_name="")
	{  
        $this->db->select('r.rekanan_id, r.rekanan_name');
        $this->db->from('master_rekanan r'); 
		if($rekanan_name != '')
		{  
			$this->db->like('r.rekanan_name', $rekanan_name); 
		}
        $query = $this->db->get();

        $result = $query->result(); 
        return $result; 
		
    }
   
    function get_rekananshipping_dlg($rekananshipping_name_name="")
	{  
        $this->db->select("r.rekanan_id,r.rekananshipping_line,r.rekananshipping_name+' | '+r.rowid AS rekananshipping_name  ,b.rekanan_name");
        $this->db->from('master_rekananshipping r');
        $this->db->join('master_rekanan b', 'r.rekanan_id = b.rekanan_id'); 
		if($rekananshipping_name_name != '')
		{  
			$this->db->like('r.rekananshipping_name', $rekananshipping_name_name); 
			$this->db->or_like('r.rowid', $rekananshipping_name_name); 
		}
        $query = $this->db->get();
		 
        $result = $query->result(); 
        return $result; 
		
    }
	
	function get_AgrGroup()
	{
		$result = $this->db->query("EXEC Adm03_Mstagreementtypegroupinv_SelectComboDefault '' ");
		if($result->num_rows() > 0)
		{
			return $result->result();
		}
		else
		{
			return 'kosong';
		}
	}
	
	function get_GroupTenant()
	{
		$result = $this->db->query("EXEC adm03_MstTenantGroupType_Select '' ");
		if($result->num_rows() > 0)
		{
			return $result->result();
		}
		else
		{
			return 'kosong';
		}
		
	}
	
	function get_acc_dlg($acc="")
	{
		$this->db->select('r.acc_id, r.acc_name');
        $this->db->from('master_acc r'); 
		if($acc != '')
		{  
			$this->db->like('r.acc_name', $acc); 
			$this->db->or_like('r.acc_id', $acc); 
		}
        $query = $this->db->get();

       if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return 'kosong';
		}
		
	}
	
	function get_PropertGrade()
	{
		$result = $this->db->query("EXEC adm03_MstBranch_SelectComboDefault 'branch_isgroup=1' ");
		if($result->num_rows() > 0)
		{
			return $result->result();
		}
		else
		{
			return 'kosong';
		} 
	}

	function get_ReportIncome($region_id,$criteria,$bln,$thn)
	{
		//debugtest
		//$criteria = '';
		//debug_backtrace
		
		$SP_SQL = "EXEC rpt_incomesummary_3 '$region_id','$criteria','$bln','$thn'";
		// echo ($SP_SQL);
		// exit;
		$result = $this->db->query($SP_SQL); 
		$temp = $result->result();
		
		// ECHO var_dump($temp);
		// exit;
		
		if($result->num_rows() > 0)
		{
			return $result->result();
		}
		else
		{
			return 'kosong';
		}
		 
	}
	 
	  
	function get_MasterSettingValue($setting_id)
	{
		$this->db->select('setting_value');
		$this->db->where('setting_id',$setting_id);
		$hasil = $this->db->get('master_setting');
		if($hasil->num_rows() > 0)
		{
			return $hasil->row();
		}
		else
		{
			return 'kosong';
		}
	}
	
	function get_bln()
	{
		
	}
	
	function get_tenantinv()
	{
		$sql = "
			select a.rekanan_id,a.rekanan_name,b.rekananshipping_name,
			a.rekanan_address as inv_send,
			a.rekanan_email as email,
			a.rekanan_pkpname as fak_npwp_name,a.taxsign_id as fak_npwp,a.rekanan_taxaddress as fak_npwp_addr,
			b.rekananshipping_line,b.rekananshipping_npwp_name as inv_npwp_name,b.rekananshipping_npwp as inv_npwp, b.rekananshipping_npwp_addr as inv_npwp_addr
			from master_rekanan a
			left join master_rekananshipping b on a.rekanan_id = b.rekanan_id
			where a.rekanantype_id in ('105', '106')
			";
		$hasil = $this->db->query($sql);
		if($hasil->num_rows() > 0)
		{
			return $hasil->result();
		}
		else
		{
			return 'kosong';
		}
	}
 }