<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_receipt extends CI_Model{
    
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

	function get_ReportReceipt($channel_id,$criteria)
	{ 
		$SP_SQL = "
	SELECT 
		B.jurnal_id, B.jurnal_bookdate, A.region_id, C.region_name, A.branch_id, D.branch_name, A.rekanan_id, E.rekanan_name, A.rekananshipping_line
		,F.rekananshipping_name
		,ISNULL(F.rowid, #SH.schedulepayment_contractno) AS debtor_no
		,A.jurnaldetil_idr
		,INV.jurnaldetil_idr as INV_IDR
		,CASE WHEN A.sub2_id = '0101' THEN 'UNA' ELSE 'OR' END AS OR_TYPE
		,A.ref_id AS invoice_jurnal
		,#SD.invoice_id 
		,#SD.faktur_id
		,B.jurnal_bookdate as invoice_date
		,#SD.agreementtype_id 	
		,AG.agreementtype_nameshort
		,(CASE WHEN E.grouptenant_id = 'group' THEN 'Corporate' ELSE 'Non Corporate' END) AS c_status
	FROM transaksi_jurnaldetil A 
		INNER join transaksi_jurnal B ON A.jurnal_id = B.jurnal_id	
		LEFT JOIN master_region C on A.region_id = C.region_id
		LEFT JOIN master_branch D on A.branch_id = D.branch_id
		LEFT JOIN master_rekanan E on A.rekanan_id = E.rekanan_id
		LEFT JOIN master_rekananshipping F on A.rekanan_id = F.rekanan_id AND A.rekananshipping_line = F.rekananshipping_line
		LEFT JOIN master_acc G on A.acc_id = G.acc_id
		LEFT JOIN transaksi_schedulepaymentdetil #SD ON #SD.schedulepayment_id+CAST(#SD.schedulepaymentdetil_line as varchar) = A.ref_id
		LEFT JOIN transaksi_schedulepayment #SH ON #SH.schedulepayment_id = #SD.schedulepayment_id
		LEFT JOIN master_agreementtype AG ON  AG.agreementtype_id = #SD.agreementtype_id  
		LEFT JOIN transaksi_jurnaldetil INV on A.ref_id = INV.jurnal_id AND A.ref_line = INV.jurnaldetil_line
	WHERE 
		 
		 A.acc_id in (select acc_id from view_master_accaging_ar) 
		and (LEFT(A.jurnal_id,2) = 'OR' OR LEFT(A.jurnal_id,2) = 'OP')
		and B.jurnal_isposted = 1
		and $criteria;";
		//echo ($SP_SQL);
		 //exit;
		
        var_dump($SP_SQL);
        die();
		$result = $this->db->query($SP_SQL);
		//$temp = $result->result();
		
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
	
   
 }