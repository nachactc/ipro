<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_or extends CI_Model
{
	
    function __construct()
    {
        parent::__construct();
    }
	
	public function get_header($jurnal_id)
	{
		$query = "SELECT a.*,b.periode_name,c.branch_namerpt as branch_name,d.rekanan_name,e.rekananshipping_name,
		(SELECT abs(SUM(_DTL.jurnaldetil_idr)) FROM transaksi_jurnaldetil _DTL WHERE _DTL.jurnal_id = '{$jurnal_id}' and _DTL.jurnaldetil_idr < 0 ) as jurnal_idr
		FROM transaksi_jurnal a 
		LEFT JOIN master_periode b on a.periode_id = b.periode_id
		LEFT JOIN master_branch c on a.branch_id = c.branch_id
		LEFT JOIN master_rekanan d on a.rekanan_id = d.rekanan_id
		LEFT JOIN master_rekananshipping e on a.rekanan_id = e.rekanan_id and a.rekananshipping_line = e.rekananshipping_line
		WHERE a.jurnal_id ='{$jurnal_id}'"; 
		
		$hasil = $this->db->query($query);
		// echo $query;exit;
		if($hasil->num_rows() === 1)
		{
			return $hasil->row();
		}
		else
		{
			return 'kosong';
		}
	}
	
	public function get_detil($jurnal_id)
	{
		$query = "SELECT 
			a.*, b.acc_name, c.region_name, d.branch_name, f.rekanan_name, g.rekananshipping_name, h.strukturunit_name,
			e.jurnalbilyet_bank,e.jurnalbilyet_no,e.jurnalbilyet_date,e.jurnalbilyet_receiveperson
		FROM transaksi_jurnaldetil a
		LEFT JOIN master_acc b on a.acc_id = b.acc_id
		LEFT JOIN master_region c on a.region_id = c.region_id
		LEFT JOIN master_branch d on a.branch_id = d.branch_id
		LEFT JOIN transaksi_jurnalbilyet e on a.jurnal_id = e.jurnal_id
		LEFT JOIN master_rekanan f on a.rekanan_id = f.rekanan_id
		LEFT JOIN master_rekananshipping g on a.rekanan_id = g.rekanan_id and a.rekananshipping_line = g.rekananshipping_line
		LEFT JOIN master_strukturunit h on a.strukturunit_id = h.strukturunit_id
		WHERE a.jurnal_id ='{$jurnal_id}'
      ORDER BY a.jurnaldetil_idr desc";
		
		$hasil = $this->db->query($query);
		if($hasil->num_rows() >1)
		{
			return $hasil->result();
		}
		else
		{
			return 'kosong';
		}
	}
	
	public function get_bilyet($jurnal_id)
	{
		$query = " SELECT 
         a.currency_id
			, abs(sum(a.jurnaldetil_idr)) as jurnalbilyet_idr
			, abs(sum(a.jurnaldetil_foreign)) as jurnalbilyet_foreign
         , e.jurnalbilyet_bank
         , e.jurnalbilyet_no
         , e.jurnalbilyet_date
         , e.jurnalbilyet_receiveperson
         FROM transaksi_jurnaldetil a
         LEFT JOIN transaksi_jurnalbilyet e on a.jurnal_id = e.jurnal_id
         WHERE a.jurnal_id ='{$jurnal_id}' and a.jurnaldetil_idr < 0
         GROUP BY 
         a.currency_id
         , e.jurnalbilyet_bank
         , e.jurnalbilyet_no
         , e.jurnalbilyet_date
         , e.jurnalbilyet_receiveperson
      ";
		
		$hasil = $this->db->query($query);

		if(count($hasil->row_array()) >1)
		{
			return $hasil->row_array();
		}
		else
		{
			return 'kosong';
		}
	}

	public function get_detil_ref($ref_id, $ref_line)
	{
		// echo $ref_id;
		$query = "SELECT 
			a.*,b.acc_name,c.region_name,d.branch_name
		FROM transaksi_jurnaldetil a
		LEFT JOIN master_acc b on a.acc_id = b.acc_id
		LEFT JOIN master_region c on a.region_id = c.region_id
		LEFT JOIN master_branch d on a.branch_id = d.branch_id 
		WHERE a.jurnal_id ='{$ref_id}' AND a.jurnaldetil_line ='{$ref_line}'";
		$hasil = $this->db->query($query);
		// echo var_dump($hasil->num_rows());
		if($hasil->num_rows() >0)
		{
			return $hasil->result();
		}
		else
		{
			return 'kosong';
		}
	}

   public function get_approval($approvalType)
	{
		// echo $ref_id;
		$query = " SELECT 
      strukturunitapprovalauth_seq
      , strukturunitapprovalauth_name
      , strukturunitapprovalauth_position
      , strukturunitapprovalauth_descr
      , strukturunitapprovalauth_header
      , strukturunitapprovalauth_type
		FROM master_strukturunitapprovalauth
		WHERE strukturunitapprovalauth_type ='{$approvalType}'
      ORDER BY strukturunitapprovalauth_seq asc ";
		$hasil = $this->db->query($query);
		if($hasil->num_rows() >0)
		{
			return $hasil->result();
		}
		else
		{
			return 'kosong';
		}
	}

}

