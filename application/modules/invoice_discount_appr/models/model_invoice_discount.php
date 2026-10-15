<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_invoice_discount extends CI_Model{
    
    function __construct(){
        parent::__construct();
		check_user_login();
    }
    
	 
    function viewdiscount($spid){     

     if (isset($spid)){
        return $this->db->query("
           select 
		   a.*
		   , cast(a.schedulepaymentdiscount_date as date) as tgl
		   , cast(a.schedulepaymentdiscount_mddate as date) as tglmd
		   , b.schedulepaymentdetil_idr,c.rekanan_name,d.rekananshipping_name 
		   from transaksi_schedulepaymentdiscount a
		   left join transaksi_schedulepaymentdetil b on a.schedulepayment_id=b.schedulepayment_id and a.schedulepaymentdiscount_line=b.schedulepaymentdetil_line
           LEFT JOIN transaksi_schedulepayment s ON b.schedulepayment_id = s.schedulepayment_id
		   left join master_rekanan c on c.rekanan_id=s.rekanan_id left join master_rekananshipping d on s.rekanan_id=d.rekanan_id and s.rekananshipping_line=d.rekananshipping_line
		   where a.schedulepayment_id+cast(schedulepaymentdiscount_line as varchar)='$spid' 
       ")->result();  
 	   
     }

    }
   
	/**
	* DISCOUNT 
	* APPROVAL DAN UNAPPROVAL
	* 03-02-2021
	* ari
	**/
	
	/**
	* FUNCTION QUERY 
	**/
	private function sql_auth(){
		//query cek strukturunit auth untuk tipe diskon invoice
		$sql_auth = "	SELECT 
							[strukturunit_id]
						   ,[strukturunitapprovalauth_line]
						   ,[strukturunitapprovalauth_seq]
						   ,[strukturunitapprovalauth_name]
						   ,[strukturunitapprovalauth_position]
						   ,[strukturunitapprovalauth_descr]
						   ,[strukturunitapprovalauth_value]
						   ,[strukturunitapprovalauth_date]
						   ,[strukturunitapprovalauth_isdisabled]
						   ,[strukturunitapprovalauth_header]
						   ,[strukturunitapprovalauth_minvalues]
						   ,[strukturunitapprovalauth_maxvalues]
						   ,[username]
						   ,[strukturunitapprovalauth_type]
						FROM master_strukturunitapprovalauth
						WHERE strukturunitapprovalauth_type = 'DISC-INV' 
						AND strukturunit_id = (select setting_value from master_setting where setting_id = 'strukturunit_appr_disc') ";
		return $sql_auth;
	}
	private function sql_auth_byname($username){
		//query cek strukturunit auth untuk diskon invoice
		$sql_auth = "	SELECT 
							[strukturunit_id]
						   ,[strukturunitapprovalauth_line]
						   ,[strukturunitapprovalauth_seq]
						   ,[strukturunitapprovalauth_name]
						   ,[strukturunitapprovalauth_position]
						   ,[strukturunitapprovalauth_descr]
						   ,[strukturunitapprovalauth_value]
						   ,[strukturunitapprovalauth_date]
						   ,[strukturunitapprovalauth_isdisabled]
						   ,[strukturunitapprovalauth_header]
						   ,[strukturunitapprovalauth_minvalues]
						   ,[strukturunitapprovalauth_maxvalues]
						   ,[username]
						   ,[strukturunitapprovalauth_type]
						FROM master_strukturunitapprovalauth
						WHERE strukturunitapprovalauth_type = 'DISC-INV' 
						AND strukturunit_id = (select setting_value from master_setting where setting_id = 'strukturunit_appr_disc')
						AND username = '$username'";
		return $sql_auth;
	}
	private function sql_discappr($schedulepayment_id,$schedulepaymentdetil_line,$username){
		//query cek transaksi_schedulepaymentdiscountapproval
		$sql_discappr = "
						SELECT 
							[schedulepayment_id]
						   ,[schedulepaymentdiscount_line]
						   ,[schedulepaymentdiscountapproval_line]
						   ,[schedulepaymentdiscountapproval_action]
						   ,[schedulepaymentdiscountapproval_header]
						   ,[schedulepaymentdiscountapproval_name]
						   ,[schedulepaymentdiscountapproval_position]
						   ,[schedulepaymentdiscountapproval_username]
						   ,[schedulepaymentdiscountapproval_date]
						   ,[schedulepaymentdiscountapproval_value]
						   ,[schedulepaymentdiscountapproval_modifydate]
						FROM transaksi_schedulepaymentdiscountapproval
						WHERE schedulepayment_id = '$schedulepayment_id'
						AND schedulepaymentdiscount_line = '$schedulepaymentdetil_line'
						AND schedulepaymentdiscountapproval_username = '$username' 
						";
		return $sql_discappr;
	}
	private function sql_discappr_cekvalue($schedulepayment_id,$schedulepaymentdetil_line){
		//query cek transaksi_schedulepaymentdiscountapproval
		$sql_discapprcek = "
						SELECT 
							[schedulepayment_id]
						   ,[schedulepaymentdiscount_line]
						   ,[schedulepaymentdiscountapproval_line]
						   ,[schedulepaymentdiscountapproval_action]
						   ,[schedulepaymentdiscountapproval_header]
						   ,[schedulepaymentdiscountapproval_name]
						   ,[schedulepaymentdiscountapproval_position]
						   ,[schedulepaymentdiscountapproval_username]
						   ,[schedulepaymentdiscountapproval_date]
						   ,[schedulepaymentdiscountapproval_value]
						   ,[schedulepaymentdiscountapproval_modifydate]
						FROM transaksi_schedulepaymentdiscountapproval
						WHERE schedulepayment_id = '$schedulepayment_id'
						AND schedulepaymentdiscount_line = '$schedulepaymentdetil_line'
						";
		return $sql_discapprcek;
	}
	private function sql_insertdiscappr($schedulepayment_id,$schedulepaymentdiscount_line,$schedulepaymentdiscountapproval_line,$schedulepaymentdiscountapproval_action,$schedulepaymentdiscountapproval_header,$schedulepaymentdiscountapproval_name,$schedulepaymentdiscountapproval_position,$username,$schedulepaymentdiscountapproval_date,$schedulepaymentdiscountapproval_value){
		//query insert transaksi_schedulepaymentdiscountapproval
		$sql_insertdiscappr = "
				INSERT INTO [dbo].[transaksi_schedulepaymentdiscountapproval]
					   (
					   [schedulepayment_id]
					   ,[schedulepaymentdiscount_line]
					   ,[schedulepaymentdiscountapproval_line]
					   ,[schedulepaymentdiscountapproval_action]
					   ,[schedulepaymentdiscountapproval_header]
					   ,[schedulepaymentdiscountapproval_name]
					   ,[schedulepaymentdiscountapproval_position]
					   ,[schedulepaymentdiscountapproval_username]
					   ,[schedulepaymentdiscountapproval_date]
					   ,[schedulepaymentdiscountapproval_value]
					   )
				VALUES
					   (
					   '$schedulepayment_id'
					   ,$schedulepaymentdiscount_line
					   ,$schedulepaymentdiscountapproval_line
					   ,'$schedulepaymentdiscountapproval_action'
					   ,'$schedulepaymentdiscountapproval_header'
					   ,'$schedulepaymentdiscountapproval_name'
					   ,'$schedulepaymentdiscountapproval_position'
					   ,'$username'
					   ,'$schedulepaymentdiscountapproval_date'
					   ,$schedulepaymentdiscountapproval_value
					   )
				";
		return $sql_insertdiscappr;
	}
	private function sql_updatediscappr($schedulepayment_id,$schedulepaymentdiscount_line,$username,$date,$value,$action){
		//update discount approve
		$sql_updatediscappr = "
				UPDATE [dbo].[transaksi_schedulepaymentdiscountapproval]
				   SET [schedulepaymentdiscountapproval_date] = '$date'
					  ,[schedulepaymentdiscountapproval_value] = $value
					  ,[schedulepaymentdiscountapproval_modifydate] = '$date'
					  ,[schedulepaymentdiscountapproval_action] = '$action'
				 WHERE schedulepayment_id = '$schedulepayment_id'
					   AND schedulepaymentdiscount_line = $schedulepaymentdiscount_line
					   AND schedulepaymentdiscountapproval_username = '$username'
		";
		return $sql_updatediscappr;
	}
	private function update_approvediscount($posted,$username,$date,$schedulepayment_id,$schedulepaymentdiscount_line){
		$sqlPosted = "
			UPDATE transaksi_schedulepaymentdiscount
			SET schedulepaymentdiscount_isposted = $posted
			,schedulepaymentdiscount_postedby = '$username'
			,schedulepaymentdiscount_posteddate = '$date'
			WHERE schedulepayment_id = '$schedulepayment_id'
				AND schedulepaymentdiscount_line = $schedulepaymentdiscount_line
		";
		return $sqlPosted;
	}
	/**
	* FUNCTION EKSEKUSI QUERY 
	**/
	function discount_unapprove($schedulepayment_id,$schedulepaymentdetil_line,$username){ 
		
		$this->db->trans_begin();
		
		$num_value = 0;
		$max_value = 0;
		$date = date('Y-m-d');
		$action_appr = 'UNAPPROVE';
		
		//data untuk di unapprove harus sudah ada di tabel discount approval
		$cek_discappr = $this->db->query($this->sql_discappr($schedulepayment_id,$schedulepaymentdetil_line,$username));
		if($cek_discappr->num_rows() > 0)
		{
			$appr_value = $this->db->query($this->sql_auth_byname($username));
			if($appr_value->num_rows() > 0)
			{ 
				$updt_discappr = $this->db->query($this->sql_updatediscappr($schedulepayment_id,$schedulepaymentdetil_line,$username,$date,$num_value,$action_appr));
				if($updt_discappr){
					//update ke transaksi discount nya set isapprove = 0
					$posted = 0;
					$s_username = '';
					//cek angka value approval apakah sudah 0 ?
					$get_allvalue = $this->db->query($this->sql_discappr_cekvalue($schedulepayment_id,$schedulepaymentdetil_line));
					if($get_allvalue->num_rows() > 0)
					{
						// $while_allvalue = $get_allvalue->result();
						// foreach($while_allvalue as $row)
						// {
							// $max_value = $max_value + intval($row->schedulepaymentdiscountapproval_value);
						// }
						if($appr_value->row()->strukturunitapprovalauth_value == 60){
							//update ke transaksi discount nya,set isapprove = 0 
							$update_discount = $this->db->query($this->update_approvediscount($posted,$username,$date,$schedulepayment_id,$schedulepaymentdetil_line));
							$execsp_unapprove = "EXEC lm03_TrnSchedulepaymentdiscount_approved '$schedulepayment_id',$schedulepaymentdetil_line,$posted,'$username' ";
							$this->db->query($execsp_unapprove);
							$dbError = $this->db->error(); 
							if($dbError["code"] != '00000')
							{
								$this->db->trans_rollback();
								return '2 '.$dbError["message"];
							}	
						}
					} 
					$dbError = $this->db->error(); 
					if($dbError["code"] != '00000')
					{
						$this->db->trans_rollback();
						return '2 '.$dbError["message"];
					}	
				}
			} 
		}
		
		if ($this->db->trans_status() === false)
		{ 
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
		}
		return true;
	}
	function discount_approve($schedulepayment_id,$schedulepaymentdetil_line,$username){ 
		
		$is_debug = $this->db->db_debug;

		$this->db->trans_begin();
		
		$this->db->db_debug = false;

		$num_value = 0;
		$max_value = 0;
		$date = date('Y-m-d');
		$action_appr = 'VERIFIED';
		
		//cek data di discount approve
		$cek_discappr = $this->db->query($this->sql_discappr($schedulepayment_id,$schedulepaymentdetil_line,$username));
		if($cek_discappr->num_rows() > 0)
		{
			//jika ada approval di tabel discount approval, maka update data.
			//update data discount approval disini
			//ambil value approval dulu
			$appr_value = $this->db->query($this->sql_auth_byname($username));
			if($appr_value->num_rows() > 0)
			{

				$num_value = $appr_value->row()->strukturunitapprovalauth_value;
				$updt_discappr = $this->db->query($this->sql_updatediscappr($schedulepayment_id,$schedulepaymentdetil_line,$username,$date,$num_value,$action_appr));
				if($updt_discappr){
					//cek angka value approval apakah sudah 60 ?
					$get_allvalue = $this->db->query($this->sql_discappr_cekvalue($schedulepayment_id,$schedulepaymentdetil_line));
					if($get_allvalue->num_rows() > 0)
					{
						$while_allvalue = $get_allvalue->result();
						foreach($while_allvalue as $row)
						{
							$max_value = $max_value + intval($row->schedulepaymentdiscountapproval_value);
						}
						// echo $max_value;exit;
						if($max_value >= 60){
							//update ke transaksi discount nya,set isapprove = 1
							$posted = 1;
							$update_discount = $this->db->query($this->update_approvediscount($posted,$username,$date,$schedulepayment_id,$schedulepaymentdetil_line));
							$execsp_approve = "EXEC lm03_TrnSchedulepaymentdiscount_approved '$schedulepayment_id',$schedulepaymentdetil_line,$posted,'$username' ";								
							$this->db->query($execsp_approve);

							// echo $execsp_approve;exit;
							$dbError = $this->db->error(); 
							if($dbError["code"] != '00000')
							{
								$this->db->trans_rollback();
								return '2 '.$dbError["message"];
							}
						}
						 
						$dbError = $this->db->error(); 
						if($dbError["code"] != '00000')
						{
							$this->db->trans_rollback();
							return '2 '.$dbError["message"];
						}						
					} 
				} 
			} 
		}
		else{
			//kondisi insert data ke approval discount karna data kosong
			$get_apprauth = $this->db->query($this->sql_auth());
			if($get_apprauth->num_rows() > 0)
			{
				$data_apprauth = $get_apprauth->result();
				$appr_line = 10;
				
				foreach($data_apprauth as $auth){ 
					$schedulepaymentdiscountapproval_line =$appr_line;
					$schedulepaymentdiscountapproval_action = '';
					$schedulepaymentdiscountapproval_header = 'APPROVE DISCOUNT';
					$schedulepaymentdiscountapproval_name = $auth->strukturunitapprovalauth_name;
					$schedulepaymentdiscountapproval_position = $auth->strukturunitapprovalauth_position;  
					$schedulepaymentdiscountapproval_date = $date;
					$s_username = $auth->username;  
					$schedulepaymentdiscountapproval_value = 0;
					//$auth->strukturunitapprovalauth_value
					$schedulepaymentdiscountapproval_modifydate = $date;
					
					//insert ke discount approval, dengan sumber data dari strukturunit auth
					$insert_appr = $this->db->query($this->sql_insertdiscappr($schedulepayment_id,$schedulepaymentdetil_line,$schedulepaymentdiscountapproval_line,$schedulepaymentdiscountapproval_action,$schedulepaymentdiscountapproval_header,$schedulepaymentdiscountapproval_name,$schedulepaymentdiscountapproval_position,$s_username,$schedulepaymentdiscountapproval_date,$schedulepaymentdiscountapproval_value) );
					$appr_line = $appr_line+10;
				} 
				$appr_line = 0;
				$dbError = $this->db->error(); 
				if($dbError["code"] != '00000')
				{
					$this->db->trans_rollback();
					return '2 '.$dbError["message"];
				}
			}
			
			//setelah insert data approval,baru approve dengan method update
			$cek_discappr_afterinsert = $this->db->query($this->sql_discappr($schedulepayment_id,$schedulepaymentdetil_line,$username));
			$appr_value = $this->db->query($this->sql_auth_byname($username));
			 
			if($cek_discappr_afterinsert->num_rows() > 0)
			{
				if($appr_value->num_rows() > 0){
					$num_value = $appr_value->row()->strukturunitapprovalauth_value;
					$updt_discappr = $this->db->query($this->sql_updatediscappr($schedulepayment_id,$schedulepaymentdetil_line,$username,$date,$num_value,$action_appr));
					if($updt_discappr){
						//cek angka value approval apakah sudah 100 ?
						$get_allvalue = $this->db->query($this->sql_discappr_cekvalue($schedulepayment_id,$schedulepaymentdetil_line));
						if($get_allvalue->num_rows() > 0)
						{
							$while_allvalue = $get_allvalue->result();
							foreach($while_allvalue as $row)
							{
								$max_value = $max_value + intval($row->schedulepaymentdiscountapproval_value);
							}
							if($max_value >= 60){
								//update ke transaksi discount nya, set isapproved = 1
								$posted = 1;
								$update_discount = $this->db->query($this->update_approvediscount($posted,$username,$date,$schedulepayment_id,$schedulepaymentdetil_line));
								
								$dbError = $this->db->error(); 
								if($dbError["code"] != '00000')
								{
									$this->db->trans_rollback();
									return '2 '.$dbError["message"];
								}
							}
						} 
					}
				} 
			}
		}
		
		
		
		$this->db->db_debug = $is_debug;

		if ($this->db->trans_status() === false)
		{ 
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
		}
		return true;
		
	}
	function status_approval($schedulepayment_id,$schedulepaymentdiscount_line){
		$query = "
				SELECT a.strukturunitapprovalauth_name,
					(CASE b.schedulepaymentdiscountapproval_action
						WHEN 'VERIFIED'
					THEN 'VERIFIED '+convert(nvarchar(20),schedulepaymentdiscountapproval_modifydate,105)
					ELSE 'NOT YET'
					END) AS verification
				FROM master_strukturunitapprovalauth a 
				LEFT JOIN transaksi_schedulepaymentdiscountapproval b
					on a.username=b.schedulepaymentdiscountapproval_username  
					AND b.schedulepayment_id = '$schedulepayment_id'
					AND b.schedulepaymentdiscount_line= $schedulepaymentdiscount_line
				WHERE a.strukturunitapprovalauth_type='DISC-INV'					
				AND a.strukturunit_id = (select setting_value from master_setting where setting_id = 'strukturunit_appr_disc')
				ORDER BY strukturunitapprovalauth_value DESC
		";
		
		$hasil = $this->db->query($query);
		if($hasil->num_rows() > 0)
		{
			return $hasil->result();
		}
		else
		{
			return false;
		}
	}
	
	/**
	* FUNCTION UNTUK BUTTON GRID
	* Jika User Login Termasuk Dalam list authorisasi untuk Approve maka tombol Grid Approve Enabled
	* Jika User Login Sudah Approve Maka Tombol Approve Disabled
	**/
	function userauth_approve($username){
		$query = "SELECT *
				  FROM master_strukturunitapprovalauth
				  WHERE strukturunitapprovalauth_type='DISC-INV'				  
				  AND strukturunit_id = (select setting_value from master_setting where setting_id = 'strukturunit_appr_disc')
				  AND username = '$username'
				 ";
		$hasil = $this->db->query($query);
		if($hasil->num_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	function userauth_done_approve($username,$id){
		$query = "	SELECT 
						schedulepaymentdiscountapproval_username
					FROM 
						transaksi_schedulepaymentdiscountapproval
					WHERE 
						schedulepaymentdiscountapproval_username = '$username'
						AND schedulepayment_id+cast(schedulepaymentdiscount_line as varchar) = '$id'
						AND schedulepaymentdiscountapproval_value > 0
				 "; 
		$hasil = $this->db->query($query);
		if($hasil->num_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function userauth_done_unapprove($username,$id){
		$query = "	SELECT 
						schedulepaymentdiscountapproval_username
					FROM 
						transaksi_schedulepaymentdiscountapproval
					WHERE 
						schedulepaymentdiscountapproval_username = '$username'
						AND schedulepayment_id+cast(schedulepaymentdiscount_line as varchar) = '$id'
						AND schedulepaymentdiscountapproval_action != 'UNAPPROVE' 	
				 ";
		// AND schedulepaymentdiscountapproval_value > 0
		// echo "<pre/>";
		// echo $query;
		$hasil = $this->db->query($query);
		if($hasil->num_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	* LIST GRID DISCOUNT APPROVAL 
	**/
	function get_listdatadiscount_approval($limit, $top, $sWhere){
		$sWhere = (!empty($sWhere) ? "AND ".str_replace('WHERE','',$sWhere):'');
		$query = "
			SELECT * FROM (
			  SELECT top $limit 
				a.*,ROW_NUMBER() OVER (ORDER BY a.schedulepayment_id desc) as RowNumber,
				rekanan_name,rekananshipping_name, branch_name, rs.rowid as debtor,
				sd.schedulepaymentdetil_idr, sd.schedulepaymentdetil_descr,sd.schedulepaymentdetil_amount
			FROM transaksi_schedulepaymentdiscount a 
			LEFT JOIN transaksi_schedulepaymentdetil sd ON a.schedulepayment_id = sd.schedulepayment_id and a.schedulepaymentdiscount_line = sd.schedulepaymentdetil_line 
			LEFT JOIN transaksi_schedulepayment s ON a.schedulepayment_id = s.schedulepayment_id
			LEFT JOIN master_rekanan r ON s.rekanan_id = r.rekanan_id 
			LEFT JOIN master_rekananshipping rs ON s.rekanan_id = rs.rekanan_id and s.rekananshipping_line = rs.rekananshipping_line
			LEFT JOIN master_branch e ON s.branch_id = e.branch_id
			WHERE a.schedulepaymentdiscount_isposted = 0 
			$sWhere
			 ) AS V
			WHERE   RowNumber > $top";
			// echo "<pre/>";
			// echo $query;
		$hasil = $this->db->query($query);
		if($hasil->num_rows() > 0)
		{
			return $hasil->result_array();
		}
		else
		{
			return false;
		}
	} 
	function get_listdatadiscount_approval_filteredlist($sWhere){
		$sWhere = (!empty($sWhere) ? "AND ".str_replace('WHERE','',$sWhere):'');
        $qry = "SELECT count(*) as jml FROM 
			(
			  SELECT 
				a.*
			FROM transaksi_schedulepaymentdiscount a
			LEFT JOIN transaksi_schedulepaymentdiscountapproval b 
				on a.schedulepayment_id = b.schedulepayment_id AND a.schedulepaymentdiscount_line = b.schedulepaymentdiscount_line
			WHERE a.schedulepaymentdiscount_isposted = 0
			AND isnull(b.schedulepaymentdiscountapproval_action,'') = '' 
			 ) AS V ";
        return $this->db->query($qry)->row_array();
    } 
    function get_listdatadiscount_approval_totalalllist(){
        $qry = "select count(schedulepayment_id) as jml from transaksi_schedulepaymentdiscount WHERE schedulepaymentdiscount_isposted = 0";
        return $this->db->query($qry)->row_array(); 
    } 
	/**
	* LIST GRID DISCOUNT UN-APPROVAL 
	**/
	function get_listdatadiscount_unapproval($limit, $top, $sWhere){
		$sWhere = (!empty($sWhere) ? "AND ".str_replace('WHERE','',$sWhere):'');
		$query = "
			SELECT * FROM (
			  SELECT top $limit  
				a.*,ROW_NUMBER() OVER (ORDER BY a.schedulepayment_id desc) as RowNumber,
				rekanan_name,rekananshipping_name, branch_name, rs.rowid as debtor,
				sd.schedulepaymentdetil_idr, sd.schedulepaymentdetil_descr,sd.schedulepaymentdetil_amount
			FROM transaksi_schedulepaymentdiscount a 
			LEFT JOIN transaksi_schedulepaymentdetil sd ON a.schedulepayment_id = sd.schedulepayment_id and a.schedulepaymentdiscount_line = sd.schedulepaymentdetil_line 
			LEFT JOIN transaksi_schedulepayment s ON a.schedulepayment_id = s.schedulepayment_id
			LEFT JOIN master_rekanan r ON s.rekanan_id = r.rekanan_id 
			LEFT JOIN master_rekananshipping rs ON s.rekanan_id = rs.rekanan_id and s.rekananshipping_line = rs.rekananshipping_line
			LEFT JOIN master_branch e ON s.branch_id = e.branch_id
			WHERE a.schedulepaymentdiscount_isposted = 1 
			$sWhere
			) AS V
			WHERE   RowNumber > $top";
			// echo "<pre/>";echo $query;exit;
		$hasil = $this->db->query($query);
		if($hasil->num_rows() > 0)
		{
			return $hasil->result_array();
		}
		else
		{
			return false;
		}
	}
	function get_listdatadiscount_unapproval_filteredlist($sWhere){
		$sWhere = (!empty($sWhere) ? "AND ".str_replace('WHERE','',$sWhere):'');
        $qry = "SELECT count(*) as jml FROM 
			(
			SELECT DISTINCT A.schedulepayment_id
			FROM transaksi_schedulepaymentdiscount a
			LEFT JOIN transaksi_schedulepaymentdiscountapproval b 
				on a.schedulepayment_id = b.schedulepayment_id AND a.schedulepaymentdiscount_line = b.schedulepaymentdiscount_line
			LEFT JOIN transaksi_schedulepayment s ON a.schedulepayment_id = s.schedulepayment_id
			LEFT JOIN master_rekanan r ON s.rekanan_id = r.rekanan_id 
			LEFT JOIN master_rekananshipping rs ON s.rekanan_id = rs.rekanan_id and s.rekananshipping_line = rs.rekananshipping_line
			LEFT JOIN master_branch e ON s.branch_id = e.branch_id
			WHERE a.schedulepaymentdiscount_isposted = 1
			AND b.schedulepaymentdiscountapproval_action  = 'VERIFIED'
			$sWhere
			 ) AS V "; 
		
        return $this->db->query($qry)->row_array();
    } 
    function get_listdatadiscount_unapproval_totalalllist(){
        $qry = "select  count(*) as jml 
				FROM
				(
				SELECT DISTINCT A.schedulepayment_id
				from transaksi_schedulepaymentdiscount  a
				LEFT JOIN transaksi_schedulepaymentdiscountapproval b 
				on a.schedulepayment_id = b.schedulepayment_id AND a.schedulepaymentdiscount_line = b.schedulepaymentdiscount_line
				WHERE a.schedulepaymentdiscount_isposted = 1
				AND b.schedulepaymentdiscountapproval_action  = 'VERIFIED'
				) AS V";
			// echo "<pre/>";
			// echo $qry;	
			// exit;
        return $this->db->query($qry)->row_array();
    }   
	
	/**
	* END DISCOUNT 
	**/
}