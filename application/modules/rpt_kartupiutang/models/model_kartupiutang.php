<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_kartupiutang extends CI_Model{
    
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
		// echo $this->db->last_query();exit;
        $result = $query->result(); 
        return $result; 
		
    }
    function get_schedulepaymentid_dlg($tenant_id="")
	{  
		$tenant_id = ($tenant_id != '') ? " AND (a.rekanan_id + cast (a.rekananshipping_line as varchar))=''$tenant_id'' AND LEFT(schedulepayment_id,2)= ''SP'' " : " AND LEFT(schedulepayment_id,2)= ''SP''" ;
		$criteria = '';
		if($criteria == ''){
			$criteria = "LEFT(a.ref_id,2) NOT IN (''UG'',''UL'',''UA'')".$tenant_id;
		}else{
			$criteria .= $criteria." AND AND LEFT(a.ref_id,2) NOT IN (''UG'',''UL'',''UA'')".$tenant_id;
		}
        $sql = "EXEC ms_MstRekananshipping_Select_SchedulePayment_WPPage '','$criteria'";
		// echo $sql;exit;
		$execQuery = $this->db->query($sql);
		if($execQuery->num_rows() > 0){
			$result = $execQuery->result();
		}else{
			$result = array();
		} 
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

	function get_ReportIncome($criteria)
	{
		//debugtest
		//$criteria = '';
		//debug_backtrace
		
		$SP_SQL = "SELECT     b.schedulepayment_id, 
                             c.agreementtype_name, 
                             b.agreementtype_id, 
                             b.schedulepaymentdetil_descr, 
                             b.schedulepaymentdetil_date, 
                             b.schedulepaymentdetil_duedate, 
                             b.schedulepaymentdetil_idr, 
                             b.schedulepaymentdetil_tax, 
                             b.invoice_id, 
                             b.faktur_id , 
                             d.channel_id, 
                             d.region_id, 
                             d.branch_id, 
                             d.rekanan_id, 
                             d.rekananshipping_line, 
                             d.rekanan_id + Cast(d.rekananshipping_line AS NVARCHAR(10))                AS rekanan,
                             (Isnull(b.schedulepaymentdetil_tax,0) * schedulepaymentdetil_idr / 100.00) AS tax,
                             e.jurnal_id                                                                AS jurnal_id,
                             Sum(jurnaldetil_idr*-1)                                                    AS jurnaldetil_idr,
                             f.jurnal_bookdate                                                          AS jurnal_date,
							 g.rekanan_name,h.rekananshipping_name,h.rowid as debtor,g.rekanan_address, 
							 dbo.f_GetUnitName_String(b.ref_id,b.ref_line,0) as shopunit, 
							 d.schedulepayment_virtualaccount
                  FROM       transaksi_schedulepaymentdetil b 
                  LEFT JOIN  master_agreementtype c 
                  ON         b.agreementtype_id = c.agreementtype_id 
                  INNER JOIN transaksi_schedulepayment d 
                  ON         d.schedulepayment_id = b.schedulepayment_id 
                  LEFT JOIN  transaksi_jurnaldetil e 
                  ON         e.ref_id = b.schedulepayment_id+CONVERT(VARCHAR(10),b.schedulepaymentdetil_line)
                  AND        (LEFT(e.jurnal_id,2) = 'OR' or LEFT(e.jurnal_id,2) = 'CA')  
                  AND        e.jurnaldetil_idr < 0 
                  LEFT JOIN  transaksi_jurnal f 
                  ON         f.jurnal_id = e.jurnal_id
				  LEFT JOIN master_rekanan g on d.rekanan_id = g.rekanan_id
				  LEFT JOIN master_rekananshipping h on  d.rekanan_id = h.rekanan_id AND h.rekananshipping_line = d.rekananshipping_line
                  WHERE      Isnull(b.invoice_id,'') <> '' AND $criteria 
                  GROUP BY   b.schedulepayment_id, 
                             c.agreementtype_name, 
                             c.agreementtype_name, 
                             b.schedulepaymentdetil_descr, 
                             b.schedulepaymentdetil_date, 
                             b.schedulepaymentdetil_duedate, 
                             b.schedulepaymentdetil_idr, 
                             b.schedulepaymentdetil_tax, 
                             b.invoice_id, 
                             b.faktur_id , b.ref_id,b.ref_line,
                             d.channel_id,  d.schedulepayment_virtualaccount,
                             d.region_id, 
                             d.branch_id, 
                             d.rekanan_id , 
                             d.channel_id, 
                             d.region_id, 
                             d.branch_id, 
                             d.rekanan_id, 
                             e.jurnal_id, 
                             f.jurnal_bookdate, 
                             b.agreementtype_id, 
                             d.rekananshipping_line,
							 d.rekananshipping_line,g.rekanan_name,h.rekananshipping_name,h.rowid,g.rekanan_address
							 ORDER BY b.agreementtype_id ASC";
		// echo "<pre/>";echo ($SP_SQL);
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
	
   
 }