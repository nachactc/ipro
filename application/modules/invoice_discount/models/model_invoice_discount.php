<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Model_invoice_discount extends CI_Model{
		
		function __construct(){
			parent::__construct();
			check_user_login();
		}

		function m_actsave()
		{

			$invoice_id = $this->input->post('txtinv');
			$discount_type = $invoice_id !== '' ? 1 : 0;

			$data = array (
				'schedulepayment_id' => $this->input->post('txtspid'),
				'schedulepaymentdiscount_line' => $this->input->post('txtspline'),
				'agreementtype_id' => $this->input->post('txtagid'),
				//'schedulepaymentdiscount_type' => $this->input->post('txtagid'),
				'schedulepaymentdiscount_type' => $discount_type,
				'schedulepaymentdiscount_date' => $this->input->post('txtdate'),
				'schedulepaymentdiscount_mddate' => $this->input->post('txtmddate'),
				'schedulepaymentdiscount_percent' => (float)str_replace(',', '', $this->input->post('txtdiscprosen')),
				'schedulepaymentdiscount_idr' => (float)str_replace(',', '', $this->input->post('txtdiscidr')),
				'invoice_id' => $this->input->post('txtinv'),
				'faktur_id' => $this->input->post('txtfaktur'),
				'schedulepaymentdiscount_descr' => $this->input->post('txtdesc'),
				'createdby' => $this->session->userdata('user_fullname'),
				'createddate' => date('Y-m-d H:i:s')
			);

			$this->db->insert('transaksi_schedulepaymentdiscount', $data);
			
		}
		
		function m_actedit()
		{
			$txtspid = $this->input->post('txtspid');
			$txtspline = $this->input->post('txtspline');

			$data = array (
				'schedulepaymentdiscount_date' => $this->input->post('txtdate'),
				'schedulepaymentdiscount_mddate' => $this->input->post('txtmddate'),
				'schedulepaymentdiscount_percent' => (float)str_replace(',', '', $this->input->post('txtdiscprosen')),
				'schedulepaymentdiscount_idr' => (float)str_replace(',', '', $this->input->post('txtdiscidr')),
				'schedulepaymentdiscount_descr' => $this->input->post('txtdesc'),
				'schedulepaymentdiscount_date' => $this->input->post('txtdate'),
				'modifiedby' => $this->session->userdata('user_fullname'),
				'modifieddate' => date('Y-m-d H:i:s')
			);			

			$this->db->where('schedulepayment_id', $txtspid);
			$this->db->where('schedulepaymentdiscount_line', $txtspline);
			$this->db->update('transaksi_schedulepaymentdiscount', $data);
		}
		
		public function get_data_dialog_invoice_discount($search='')
		{			
			$where = '';
			if($search != '')
			{ 
				$search = trim($search);

				$where = "
				where  				
				-- dd.schedulepayment_id IS NULL
				-- d.ref_id IS NULL 
				d.agreementtype_id in ('4000','5000','5500','6000') 
				and d.schedulepaymentdetil_ishold = 0 
				and d.schedulepaymentdetil_isdisabled = 0 
				and (d.invoice_id = '{$search}'
					OR d.schedulepayment_id = '{$search}'
					OR d.ref_id = '{$search}')";
			}

			$panjang = $_POST['length'];
			$awal = $_POST['start'];

			$sqlBuff = "
			select 
			d.schedulepayment_id
			, schedulepaymentdetil_line
			, d.agreementtype_id
			, schedulepaymentdetil_date
			, schedulepaymentdetil_idr
			, schedulepaymentdetil_descr
			, schedulepaymentdetil_isposted
			, schedulepaymentdetil_postedby
			, schedulepaymentdetil_posteddate
			, schedulepaymentdetil_tax
			, schedulepaymentdetil_isdisabled
			, d.invoice_id
			, d.faktur_id
			, rekanan_name, rekananshipping_name, branch_name, rs.rowid as debtor
			, d.ref_id as agreement_id
			, tj.jurnal_id as response_id
			, dd.schedulepayment_id+cast(dd.schedulepaymentdiscount_line as varchar) as discount_id
			into ##temp_diskon
			from transaksi_schedulepaymentdetil d 
			join transaksi_schedulepayment s ON d.schedulepayment_id = s.schedulepayment_id 
			left join transaksi_schedulepaymentdiscount dd ON d.schedulepayment_id = dd.schedulepayment_id 
				and d.schedulepaymentdetil_line = dd.schedulepaymentdiscount_line
			left join master_rekanan r ON s.rekanan_id = r.rekanan_id 
			left join master_rekananshipping rs ON s.rekanan_id = rs.rekanan_id and s.rekananshipping_line = rs.rekananshipping_line 
			left join master_branch b ON s.branch_id = b.branch_id
			left join transaksi_jurnaldetil tj on tj.ref_id=d.schedulepayment_id + cast(d.schedulepaymentdetil_line as varchar)
			$where	
			";
			$this->db->query($sqlBuff);

			$sql = "
			select * from ##temp_diskon
			where response_id is null and discount_id is null
			order by schedulepayment_id, schedulepaymentdetil_line asc 
			offset $awal rows fetch next $panjang rows only;
			";

			$query = $this->db->query($sql);
			$result = $query->result_array();

			if ($result ) 
			{
				return $result ;
			} 
			else 
			{
				return array();
			}
		}
		
		public function get_data_dialog_invoice_discount_rows($search = '')
		{			
			$sql = "
			select count(*) as jml from ##temp_diskon
			where response_id is null and discount_id is null
			drop table ##temp_diskon; 
			";
			$query = $this->db->query($sql);
			
			$result = $query->row_array();
			$vresult = $result['jml'];

			if ($result ) 
			{
				return $vresult ;
			} 
			else 
			{
				return array();
			}			
		}
		
		function qry_alldatalist($limit, $top, $sWhere, $sOrder)
		{
			// $sWhere = empty($sWhere) ? " WHERE unittype_id = 6 and isdisabled = 0 " : $sWhere." AND isdisabled = 0 and unittype_id = 6 ";
			// $sWhere = " where (d.invoice_id LIKE '%$search%' OR branch_name LIKE '%$search%' OR rekanan_name LIKE '%$search%' OR rekananshipping_name LIKE '%$search%' )";
			
			$sWhere = $sWhere ==='' ? "''" : "'".str_replace("'", "''", $sWhere)."'";	
			$sOrder = $sOrder ==='' ? "''" : "'".str_replace("'", "''", $sOrder)."'";
			//var_dump($sWhere);
			//var_dump($sOrder);
			//exit;
			
			$qry = " exec lm03_TrnSchedulepaymentdiscount_Select $sWhere, $top, $limit, $sOrder ";

			return $this->db->query($qry)->result_array();	   
		}
	
		function qry_filteredlist($sWhere)
		{	
			//$sWhere = " where (d.invoice_id LIKE '%$search%' OR branch_name LIKE '%$search%' OR rekanan_name LIKE '%$search%' OR rekananshipping_name LIKE '%$search%' )";		
			$sWhere = $sWhere ==='' ? "''" : "'".str_replace("'", "''", $sWhere)."'";

			$qry=" exec lm03_TrnSchedulepaymentdiscount_SelectCount $sWhere ";
			return $this->db->query($qry)->row_array();
		}
	
		function qry_totalalllist()
		{	

			$qry=" exec lm03_TrnSchedulepaymentdiscount_SelectCount ";
			return $this->db->query($qry)->row_array();	
		}
    
		function viewdiscount($spid)
		{ 
		
			if (isset($spid)){

				return $this->db->query("
					select 
					a.*
					,cast(a.schedulepaymentdiscount_date as date) as tgl
					,cast(a.schedulepaymentdiscount_mddate as date) as tglmd
					,b.schedulepaymentdetil_idr
					,c.rekanan_name,d.rekananshipping_name
					from transaksi_schedulepaymentdiscount a
					left join transaksi_schedulepaymentdetil b on a.schedulepayment_id=b.schedulepayment_id and a.schedulepaymentdiscount_line=b.schedulepaymentdetil_line
					LEFT JOIN transaksi_schedulepayment s ON b.schedulepayment_id = s.schedulepayment_id
					left join master_rekanan c on c.rekanan_id=s.rekanan_id left join master_rekananshipping d on s.rekanan_id=d.rekanan_id and s.rekananshipping_line=d.rekananshipping_line
					where a.schedulepayment_id+cast(schedulepaymentdiscount_line as varchar)='$spid' 
				")->result();
			}	
		}
    
		function get_branch_dlg($region_id='')
		{ 
			$this->db->select('r.branch_id, branch_name');
			$this->db->from('master_regionbranch r');
			$this->db->join('master_branch b', 'r.branch_id = b.branch_id');
			if($region_id != '')
			{  
			$this->db->where('r.region_id', $region_id); 
			}
			$query = $this->db->get();
			
			$result = $query->result();
			$ret ['']= 'Pilih Store :';
			if($result)
			{
			foreach ($result as $key => $row)
			{
			$ret [$row->branch_id] = $row->branch_name;
			}
			}
			
			return $ret; 
		}
	
		function deleteLOI($uid)
		{
			$uid = str_replace('_', '/', $uid);

			$this->db->where('schedulepayment_id+cast(schedulepaymentdiscount_line as varchar) =', $uid);
			$this->db->where('schedulepaymentdiscount_isposted <>', 1);
			$this->db->delete('transaksi_schedulepaymentdiscount');
		}
	}	