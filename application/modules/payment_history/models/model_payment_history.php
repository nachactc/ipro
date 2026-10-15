<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
class Model_payment_history extends CI_Model 
{

    public function __construct() 
    {
        parent::__construct();
    }

  
    public function get_data_payment($branch_id,$region_id ) 
    {  
	$criteria = '';
	
	if($region_id <> '' AND $branch_id <> '')
	{
		$criteria = " SP.region_id = '$region_id' AND SP.branch_id ='$branch_id' ";
	}
	elseif($region_id <> '' AND $branch_id = '')
	{
		$criteria = " SP.region_id = '$region_id' ";
	}
		$stored_pocedure = "SELECT
		  MR.rekanan_id,
		  SP.region_id,
		  SP.branch_id,
		  SH.rekananshipping_name,
		  RE.region_name,
		  BR.branch_name,
		  SPD.schedulepaymentdetil_percentdp,
		  SPD.schedulepaymentdetil_unit,
		  CASE
			WHEN SPD.schedulepaymentdetil_percentdp = 5 THEN CONVERT(nvarchar(10), SPD.schedulepaymentdetil_date, 105)
			ELSE NULL
		  END AS P_5,
		  CASE
			WHEN SPD.schedulepaymentdetil_percentdp = 10 THEN CONVERT(nvarchar(10), SPD.schedulepaymentdetil_date, 105)
			ELSE NULL
		  END AS P_10,
		  CASE
			WHEN SPD.schedulepaymentdetil_percentdp = 15 THEN CONVERT(nvarchar(10), SPD.schedulepaymentdetil_date, 105)
			ELSE NULL
		  END AS P_15,
		  CASE
			WHEN SPD.schedulepaymentdetil_percentdp = 20 THEN CONVERT(nvarchar(10), SPD.schedulepaymentdetil_date, 105)
			ELSE NULL
		  END AS P_20,
		  CASE
			WHEN SPD.agreementtype_id = '7000' OR
			  SPD.agreementtype_id = '7500' THEN CONVERT(nvarchar(10), SPD.schedulepaymentdetil_date, 105)
			ELSE NULL
		  END AS SD,
		  SPD.schedulepayment_id,
		  SPD.invoice_id,
		  SPD.schedulepaymentdetil_amount * 1.1 AS INV_IDR,
		  PV.jurnal_id,
		  SUM(PVD.jurnaldetil_idr) AS PV_IDR,
		  CASE
			WHEN SPD.schedulepaymentdetil_percentdp = 5 THEN CONVERT(nvarchar(10), PV.jurnal_bookdate, 105)
			ELSE NULL
		  END AS P1_5,
		  CASE
			WHEN SPD.schedulepaymentdetil_percentdp = 10 THEN CONVERT(nvarchar(10), PV.jurnal_bookdate, 105)
			ELSE NULL
		  END AS P1_10,
		  CASE
			WHEN SPD.schedulepaymentdetil_percentdp = 15 THEN CONVERT(nvarchar(10), PV.jurnal_bookdate, 105)
			ELSE NULL
		  END AS P1_15,
		  CASE
			WHEN SPD.schedulepaymentdetil_percentdp = 20 THEN CONVERT(nvarchar(10), PV.jurnal_bookdate, 105)
			ELSE NULL
		  END AS P1_20,
		  CASE
			WHEN SPD.agreementtype_id = '7000' OR
			  SPD.agreementtype_id = '7500' THEN CONVERT(nvarchar(10), PV.jurnal_bookdate, 105)
			ELSE NULL
		  END AS SD_PY
		 ,UTTY.unittype_name
		 ,unit.unit_id
		FROM transaksi_schedulepayment SP
		JOIN transaksi_schedulepaymentdetil SPD
		  ON SPD.schedulepayment_id = SP.schedulepayment_id
		JOIN master_rekananshipping SH
		  ON SH.rekanan_id = SP.rekanan_id
		  AND SH.rekananshipping_line = SP.rekananshipping_line
		JOIN master_rekanan MR
		  ON MR.rekanan_id = SP.rekanan_id
		JOIN transaksi_jurnaldetil PVD
		  ON SPD.schedulepayment_id + CAST(schedulepaymentdetil_line AS varchar) = PVD.ref_id
		JOIN transaksi_jurnal PV
		  ON PV.jurnal_id = PVD.jurnal_id
		JOIN master_region RE
		  ON RE.region_id = SP.region_id
		JOIN master_branch BR
		  ON BR.branch_id = SP.branch_id
		LEFT JOIN ( SELECT DISTINCT unit_id,agreement_id FROM  transaksi_agreementdetil  ) AGR ON AGR.agreement_id = SPD.ref_id 
		LEFT JOIN master_unit UNIT on   AGR.unit_id  =  UNIT.unit_id
		LEFT JOIN master_unittype UTTY ON UNIT.unittype_id = UTTY.unittype_id
		WHERE $criteria
		OR (SPD.agreementtype_id = '7000'
		OR SPD.agreementtype_id = '7500'  )
		AND SPD.agreementtype_id = '2000'
		GROUP BY SH.rekananshipping_name,
				 SPD.schedulepaymentdetil_percentdp,
				 SPD.schedulepaymentdetil_unit,
				 SPD.schedulepaymentdetil_date,
				 SPD.schedulepayment_id,
				 SPD.invoice_id,
				 SPD.schedulepaymentdetil_amount,
				 PV.jurnal_id,
				 PV.jurnal_bookdate,
				 SPD.agreementtype_id,
				 BR.branch_name,
				 RE.region_name,
				 MR.rekanan_id,
				 SP.region_id,
				 SP.branch_id,UTTY.unittype_name
				,unit.unit_id";
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
