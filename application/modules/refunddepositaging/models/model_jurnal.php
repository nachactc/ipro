<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_jurnal extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
	function get_jurnal($jurnal_id)
	{
		$query = "SELECT a.*,b.rekanan_name,c.rekananshipping_name,d.acc_name
				FROM transaksi_jurnal a 
				LEFT JOIN master_rekanan b on a.rekanan_id = b.rekanan_id
				LEFT JOIN master_rekananshipping c on a.rekanan_id = c.rekanan_id AND a.rekananshipping_line = c.rekananshipping_line
				LEFT JOIN master_acc d on a.acc_id = d.acc_id 
				WHERE a.jurnal_id = '$jurnal_id'";
		$hasil = $this->db->query($query);
		if($hasil->num_rows() >0)
		{
			return $hasil->row_array();
		}
	}
	function get_jurnaldetilD($jurnal_id)
	{
		$query = "SELECT a.*,b.rekanan_name,c.rekananshipping_name,d.acc_name 
				FROM transaksi_jurnaldetil a 
				LEFT JOIN master_rekanan b on a.rekanan_id = b.rekanan_id
				LEFT JOIN master_rekananshipping c on a.rekanan_id = c.rekanan_id AND a.rekananshipping_line = c.rekananshipping_line
				LEFT JOIN master_acc d on a.acc_id = d.acc_id 
				WHERE a.jurnal_id = '$jurnal_id' AND a.jurnaldetil_dk ='D' ";
		$hasil = $this->db->query($query);
		if($hasil->num_rows() >0)
		{
			return $hasil->result();
		}
	}
	function get_jurnaldetilK($jurnal_id)
	{
		$query = "SELECT a.*,b.rekanan_name,c.rekananshipping_name,d.acc_name FROM transaksi_jurnaldetil a 
				LEFT JOIN master_rekanan b on a.rekanan_id = b.rekanan_id
				LEFT JOIN master_rekananshipping c on a.rekanan_id = c.rekanan_id AND a.rekananshipping_line = c.rekananshipping_line
				LEFT JOIN master_acc d on a.acc_id = d.acc_id  
				WHERE a.jurnal_id = '$jurnal_id' AND a.jurnaldetil_dk ='K' ";
				 
		$hasil = $this->db->query($query);
		if($hasil->num_rows() >0)
		{
			return $hasil->result();
		}
	}
	function get_jurnaldetilRes($jurnal_id)
	{
		$query = "SELECT a.*,b.rekanan_name,c.rekananshipping_name,d.acc_name FROM transaksi_jurnaldetil a 
				LEFT JOIN master_rekanan b on a.rekanan_id = b.rekanan_id
				LEFT JOIN master_rekananshipping c on a.rekanan_id = c.rekanan_id AND a.rekananshipping_line = c.rekananshipping_line
				LEFT JOIN master_acc d on a.acc_id = d.acc_id 
				WHERE a.ref_id = '$jurnal_id'
				ORDER BY a.jurnal_id,a.acc_id ASC";
		$hasil = $this->db->query($query);
		
		if($hasil->num_rows() >0)
		{
			return $hasil->result();
		}
	}
	function get_jurnaldetilRef($jurnal_id)
	{
		$query = "SELECT a.*,b.rekanan_name,c.rekananshipping_name,d.acc_name FROM transaksi_jurnaldetil a 
				LEFT JOIN master_rekanan b on a.rekanan_id = b.rekanan_id
				LEFT JOIN master_rekananshipping c on a.rekanan_id = c.rekanan_id AND a.rekananshipping_line = c.rekananshipping_line
				LEFT JOIN master_acc d on a.acc_id = d.acc_id  
				WHERE a.jurnal_id IN ( SELECT ref_id FROM transaksi_jurnaldetil WHERE jurnal_id = '$jurnal_id' )
				ORDER BY a.jurnal_id,a.acc_id ASC";
		$hasil = $this->db->query($query);
		if($hasil->num_rows() >0)
		{
			return $hasil->result();
		}
	}
	
	/** collect save data **/ 
	
	function save_jurnal(){
	$jurnal_id = '';
	$this->db->trans_begin(); 
		try {
			$header = $this->insert_jurnal_header(); 
			$jurnal_id = $header;
			if(!empty($jurnal_id))
			{
				$detil_debet = $this->insert_jurnal_detil_d($jurnal_id);  
				$detil_credit = $this->insert_jurnal_detil_k($jurnal_id);
				 
				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					return FALSE; 
				}
				else
				{
					$this->db->trans_commit();
					$this->db->trans_complete();
					return TRUE;
				}
			}
			else
			{
				// return false;
				echo "Jurnal ID tidak Terbentuk!";
				return FALSE; 
			}
			
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		
	}
	
	/** collect update data **/ 
	
	function update_jurnal(){
	$jurnal_id = '';
	$this->db->trans_begin(); 
		try {
			$jurnal_id = $this->input->post('jurnal_id');
			// echo $jurnal_id;exit;
			
			// echo "<pre>";
			// echo var_dump($_POST); 
			// exit;
			
			$header = $this->update_jurnal_header($jurnal_id);
			if(!empty($jurnal_id))
			{
				$sqlDCheck = "SELECT COUNT(*) as jml FROM transaksi_jurnaldetil WHERE jurnal_id = '$jurnal_id' AND jurnaldetil_dk = 'D' ";
				$sqlKCheck = "SELECT COUNT(*) as jml FROM transaksi_jurnaldetil WHERE jurnal_id = '$jurnal_id' AND jurnaldetil_dk = 'K' ";
				$debetCheck = $this->db->query($sqlDCheck);
				$creditCheck = $this->db->query($sqlKCheck);
				
				//check sebelum delete
				if($debetCheck->num_rows()>0 AND $creditCheck->num_rows()>0)
				{ 
					if(!empty($jurnal_id))
					{
						$destroy = "DELETE FROM transaksi_jurnaldetil WHERE jurnal_id = '$jurnal_id'"; 
						$this->db->query($destroy);
					} 
				}
				
				//insert kembali
				$detil_debet = $this->insert_jurnal_detil_d($jurnal_id);
				$detil_credit = $this->insert_jurnal_detil_k($jurnal_id);
				
				
				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					return FALSE; 
				}
				else
				{
					$this->db->trans_commit();
					$this->db->trans_complete();
					return $jurnal_id;
				}
			}
			else
			{
				// return false;
				echo "Jurnal ID tidak Terbentuk!";
			} 
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		
	}
	
	/** add data area **/ 
	
	/** jurnal header **/ 
	function insert_jurnal_header(){
		/** 
		--- parameter yang dibutuhkan insert dari stored procedure nya ----
			@jurnal_id as nvarchar(24) OUTPUT, 
			@jurnal_bookdate as smalldatetime, 
			@jurnal_descr as nvarchar(510), 
			@jurnal_isposted as tinyint, 
			@jurnal_createby as nvarchar(32), 
			@jurnal_createdate as smalldatetime, 
			@jurnal_modifyby as nvarchar(32), 
			@jurnal_modifydate as smalldatetime, 
			@jurnal_postby as nvarchar(32), 
			@jurnal_postdate as smalldatetime, 
			@jurnal_duedate as smalldatetime, 
			@jurnal_faktur as nvarchar(14), 
			@jurnal_source as nvarchar(60), 
			@jurnaltype_id as nvarchar(4), 
			@channel_id as nvarchar(20), 
			@region_id as nvarchar(10), 
			@branch_id as nvarchar(14), 
			@strukturunit_id as nvarchar(14), 
			@rekanan_id as nvarchar(14), 
			@sub1_id as nvarchar(14), 
			@sub2_id as nvarchar(14), 
			@currency_id as nvarchar(20), 
			@currency_rate as numeric(18, 2), 
			@periode_id as nvarchar(8),
			@acc_id as nvarchar(14)
		**/
		$user=$this->session->userdata('user_fullname');
		$date=date('Y-m-d');
		
		$jurnal_bookdate = $this->input->post('jurnal_bookdate');
		$jurnal_descr = $this->input->post('jurnal_descr');
		$jurnal_isposted = 0;
		$jurnal_createby = $user;
		$jurnal_createdate = $date;
		$jurnal_modifyby = '';
		$jurnal_modifydate = $date;
		$jurnal_postby = '';
		$jurnal_postdate = $date;
		$jurnal_duedate = $this->input->post('jurnal_duedate');
		$jurnal_faktur = $this->input->post('jurnal_faktur');
		$jurnal_source = $this->input->post('jurnal_source');
		$jurnaltype_id = $this->input->post('jurnaltype_id');
		$channel_id = $this->input->post('channel_id');
		$region_id = $this->input->post('region_id');
		$branch_id = $this->input->post('branch_id');
		$strukturunit_id = $this->input->post('strukturunit_id');
		$rekanan_id = $this->input->post('rekanan_id');
		$sub1_id = $this->input->post('sub1_id');
		$sub2_id = $this->input->post('sub2_id');
		$currency_id = $this->input->post('currency_id');
		$currency_rate = $this->input->post('currency_rate');
		$periode_id = $this->input->post('periode_id');
		$acc_id = $this->input->post('hacc_id');
		
		$this->db->trans_begin(); 
		$id=''; 
		$spq= "EXEC cp_TrnJurnal_Insert '','$jurnal_bookdate','$jurnal_descr',$jurnal_isposted,'$jurnal_createby',
		'$jurnal_createdate','$jurnal_modifyby','$jurnal_modifydate','$jurnal_postby','$jurnal_postdate','$jurnal_duedate','$jurnal_faktur','$jurnal_source','$jurnaltype_id','$channel_id','$region_id','$branch_id','$strukturunit_id','$rekanan_id','$sub1_id','$sub2_id','$currency_id',$currency_rate,'$periode_id','$acc_id' "; 
		
		// echo var_dump($spq);exit;
		$hasil = $this->db->query($spq); 
		$id = $hasil->row()->jurnal_id;
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;

		}
		else
		{
			$this->db->trans_commit();
			$this->db->trans_complete();
			return $id;
		}
		
	}
	/** jurnal detil debet **/
	function insert_jurnal_detil_d($jurnal_id){
			
			$jurnaldetil_line = $this->input->post('d_jurnaldetil_line');
			$jurnaldetil_dk = 'D';
			$jurnaldetil_descr = $this->input->post('d_jurnaldetil_descr');
			$jurnaldetil_idr = $this->input->post('d_jurnaldetil_idr');
			$jurnaldetil_foreign = $this->input->post('d_jurnaldetil_foreign');
			$jurnaldetil_foreignrate = $this->input->post('d_jurnaldetil_foreignrate');
			$ref_id = $this->input->post('d_ref_id');
			$ref_line = $this->input->post('d_ref_line');
			$currency_id = $this->input->post('d_currency_id');
			$acc_id = $this->input->post('d_acc_id');
			$channel_id = $this->input->post('d_channel_id');
			$region_id = $this->input->post('d_region_id');
			$branch_id = $this->input->post('d_branch_id');
			$strukturunit_id = $this->input->post('d_strukturunit_id');
			$rekananshipping_line = $this->input->post('d_rekananshipping_line');
			$sub1_id = $this->input->post('d_sub1_id');
			$sub2_id = $this->input->post('d_sub2_id');
			$rekanan_id = $this->input->post('d_rekanan_id');
			    
			foreach($jurnaldetil_line as $key => $n)
			{  
				
				$sql = "
					INSERT INTO [dbo].[transaksi_jurnaldetil]
						   (
						   [jurnal_id]
						   ,[jurnaldetil_line]
						   ,[jurnaldetil_dk]
						   ,[jurnaldetil_descr]
						   ,[jurnaldetil_idr]
						   ,[jurnaldetil_foreign]
						   ,[jurnaldetil_foreignrate]
						   ,[ref_id]
						   ,[ref_line]
						   ,[currency_id]
						   ,[acc_id]
						   ,[channel_id]
						   ,[region_id]
						   ,[branch_id]
						   ,[strukturunit_id]
						   ,[rekanan_id]
						   ,[sub1_id]
						   ,[sub2_id]
						   ,[rekananshipping_line] 
						   )
					 VALUES
						   (
						   '$jurnal_id'
						   ,$jurnaldetil_line[$key]
						   ,'$jurnaldetil_dk'
						   ,'$jurnaldetil_descr[$key]'
						   ,$jurnaldetil_idr[$key]
						   ,$jurnaldetil_foreign[$key]
						   ,$jurnaldetil_foreignrate[$key]
						   ,'$ref_id[$key]'
						   ,$ref_line[$key]
						   ,'$currency_id[$key]'
						   ,'$acc_id[$key]'
						   ,'$channel_id[$key]'
						   ,'$region_id[$key]'
						   ,'$branch_id[$key]'
						   ,'$strukturunit_id[$key]'
						   ,'$rekanan_id[$key]'
						   ,'$sub1_id[$key]'
						   ,'$sub2_id[$key]'
						   ,$rekananshipping_line[$key]
						   )
				"; 
				$insertDb = $this->db->query($sql); 
				// echo "<pre>";
				// echo var_dump($rekananshipping_line[$key]);
			}
				// exit;
				return $insertDb;
			 
	}
	/** jurnal detil kredit **/
	function insert_jurnal_detil_k($jurnal_id){
			$jurnaldetil_line = $this->input->post('k_jurnaldetil_line');
			$jurnaldetil_dk = 'K';
			$jurnaldetil_descr = $this->input->post('k_jurnaldetil_descr');
			$jurnaldetil_idr = $this->input->post('k_jurnaldetil_idr');
			$jurnaldetil_foreign = $this->input->post('k_jurnaldetil_foreign');
			$jurnaldetil_foreignrate = $this->input->post('k_jurnaldetil_foreignrate');
			$ref_id = $this->input->post('k_ref_id');
			$ref_line = $this->input->post('k_ref_line');
			$currency_id = $this->input->post('k_currency_id');
			$acc_id = $this->input->post('k_acc_id');
			$channel_id = $this->input->post('k_channel_id');
			$region_id = $this->input->post('k_region_id');
			$branch_id = $this->input->post('k_branch_id');
			$strukturunit_id = $this->input->post('k_strukturunit_id');
			$rekananshipping_line = $this->input->post('k_rekananshipping_line');
			$sub1_id = $this->input->post('k_sub1_id');
			$sub2_id = $this->input->post('k_sub2_id');
			$rekanan_id = $this->input->post('k_rekanan_id');
			
			// $this->db->trans_begin(); 
			foreach($jurnaldetil_line as $key => $n)
			{
				$sql = "
					INSERT INTO [dbo].[transaksi_jurnaldetil]
						   ([jurnal_id]
						   ,[jurnaldetil_line]
						   ,[jurnaldetil_dk]
						   ,[jurnaldetil_descr]
						   ,[jurnaldetil_idr]
						   ,[jurnaldetil_foreign]
						   ,[jurnaldetil_foreignrate]
						   ,[ref_id]
						   ,[ref_line]
						   ,[currency_id]
						   ,[acc_id]
						   ,[channel_id]
						   ,[region_id]
						   ,[branch_id]
						   ,[strukturunit_id]
						   ,[rekanan_id]
						   ,[sub1_id]
						   ,[sub2_id]
						   ,[rekananshipping_line]
						   )
					 VALUES
						   ('$jurnal_id'
						   ,$jurnaldetil_line[$key]
						   ,'$jurnaldetil_dk'
						   ,'$jurnaldetil_descr[$key]'
						   ,($jurnaldetil_idr[$key]*-1)
						   ,$jurnaldetil_foreign[$key]
						   ,$jurnaldetil_foreignrate[$key]
						   ,'$ref_id[$key]'
						   ,$ref_line[$key]
						   ,'$currency_id[$key]'
						   ,'$acc_id[$key]'
						   ,'$channel_id[$key]'
						   ,'$region_id[$key]'
						   ,'$branch_id[$key]'
						   ,'$strukturunit_id[$key]'
						   ,'$rekanan_id[$key]'
						   ,'$sub1_id[$key]'
						   ,'$sub2_id[$key]'
						   ,$rekananshipping_line[$key])
				"; 
				 // echo var_dump($sql);exit; 
				$insertDb = $this->db->query($sql);
				// echo var_dump($insertDb);exit;
			}
			return $insertDb;
	}
	
	/** update data **/
	function update_jurnal_header($jurnal_id){
		/** 
			--- parameter yang dibutuhkan insert dari stored procedure nya ----
			@jurnal_id as nvarchar(24) OUTPUT, 
			@jurnal_bookdate as smalldatetime, 
			@jurnal_descr as nvarchar(510), 
			@jurnal_isposted as tinyint, 
			@jurnal_createby as nvarchar(32), 
			@jurnal_createdate as smalldatetime, 
			@jurnal_modifyby as nvarchar(32), 
			@jurnal_modifydate as smalldatetime, 
			@jurnal_postby as nvarchar(32), 
			@jurnal_postdate as smalldatetime, 
			@jurnal_duedate as smalldatetime, 
			@jurnal_faktur as nvarchar(14), 
			@jurnal_source as nvarchar(60), 
			@jurnaltype_id as nvarchar(4), 
			@channel_id as nvarchar(20), 
			@region_id as nvarchar(10), 
			@branch_id as nvarchar(14), 
			@strukturunit_id as nvarchar(14), 
			@rekanan_id as nvarchar(14), 
			@sub1_id as nvarchar(14), 
			@sub2_id as nvarchar(14), 
			@currency_id as nvarchar(20), 
			@currency_rate as numeric(18, 2), 
			@periode_id as nvarchar(8),
			@acc_id as nvarchar(14)
		**/
		$user=$this->session->userdata('user_fullname');
		$date=date('Y-m-d');
		 
		$jurnal_bookdate = $this->input->post('jurnal_bookdate');
		$jurnal_descr = $this->input->post('jurnal_descr');
		$jurnal_isposted = 0;
		$jurnal_createby = $this->input->post('jurnal_createby');
		$jurnal_createdate =  $this->input->post('jurnal_createdate');
		$jurnal_modifyby = $user;
		$jurnal_modifydate = $date;
		$jurnal_postby = '';
		$jurnal_postdate = $date;
		$jurnal_duedate = $this->input->post('jurnal_duedate');
		$jurnal_faktur = $this->input->post('jurnal_faktur');
		$jurnal_source = $this->input->post('jurnal_source');
		$jurnaltype_id = $this->input->post('jurnaltype_id');
		$channel_id = $this->input->post('channel_id');
		$region_id = $this->input->post('region_id');
		$branch_id = $this->input->post('branch_id');
		$strukturunit_id = $this->input->post('strukturunit_id');
		$rekanan_id = $this->input->post('rekanan_id');
		$sub1_id = $this->input->post('sub1_id');
		$sub2_id = $this->input->post('sub2_id');
		$currency_id = $this->input->post('currency_id');
		$currency_rate = $this->input->post('currency_rate');
		$periode_id = $this->input->post('periode_id');
		$acc_id = $this->input->post('hacc_id');
		
		$this->db->trans_begin(); 
		 
		$spq= "EXEC cp_TrnJurnal_Update '$jurnal_id','$jurnal_bookdate','$jurnal_descr',$jurnal_isposted,'$jurnal_createby',
		'$jurnal_createdate','$jurnal_modifyby','$jurnal_modifydate','$jurnal_postby','$jurnal_postdate','$jurnal_duedate','$jurnal_faktur','$jurnal_source','$jurnaltype_id','$channel_id','$region_id','$branch_id','$strukturunit_id','$rekanan_id','$sub1_id','$sub2_id','$currency_id',$currency_rate,'$periode_id','$acc_id' "; 
		$this->db->query($spq);
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;

		}
		else
		{
			$this->db->trans_commit();
			$this->db->trans_complete();
			return TRUE;
		}
	}
	//---------------------------------------------||----------------------------------------------------------//
	/** ubah hanya querynya saja sesuai keperluan**/ 
	function query_allgrid($limit,$top,$sWhere){
		$where = (!empty($sWhere) ? $sWhere." AND jurnal_source='RF-ListSD' AND jurnaltype_id='RF' " : "WHERE jurnal_source='RF-ListSD' AND jurnaltype_id='RF' AND jurnal_faktur='REFUND' " );
		$sqlgrid = "SELECT * FROM (
			SELECT TOP $limit VV.*, ROW_NUMBER() OVER (ORDER BY jurnal_id desc) AS RowNumber,
		  REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, STRUK.strukturunit_name
		FROM v_jurnal AS VV
			JOIN master_region AS REGION ON VV.region_id = REGION.region_id
			JOIN master_branch AS BRANCH ON VV.branch_id = BRANCH.branch_id
			JOIN master_rekanan AS REKAN ON VV.rekanan_id = REKAN.rekanan_id
			JOIN master_strukturunit AS STRUK ON VV.strukturunit_id = STRUK.strukturunit_id
		$where
		ORDER BY VV.jurnal_createdate DESC
	  ) AS V
	  WHERE   RowNumber > $top ORDER BY jurnal_id DESC";
	  // echo $sqlgrid;exit;
		return $sqlgrid;
	}
	
	function query_filtergrid($sWhere){
		$where = (!empty($sWhere) ? $sWhere." AND jurnal_source='RF-ListSD' AND jurnaltype_id='RF' " : "WHERE jurnal_source='RF-ListSD' AND jurnaltype_id='RF' AND jurnal_faktur='REFUND' " );
		$sqlgrid = "SELECT COUNT(*) as jml FROM (
				  SELECT VV.*, ROW_NUMBER() OVER (ORDER BY jurnal_id desc) AS RowNumber,
			  REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, STRUK.strukturunit_name
			FROM v_jurnal AS VV
				JOIN master_region AS REGION ON VV.region_id = REGION.region_id
				JOIN master_branch AS BRANCH ON VV.branch_id = BRANCH.branch_id
				JOIN master_rekanan AS REKAN ON VV.rekanan_id = REKAN.rekanan_id
				JOIN master_strukturunit AS STRUK ON VV.strukturunit_id = STRUK.strukturunit_id
			$where		 
			  ) AS V";
		return $sqlgrid;
	}
	
	function query_totalgrid(){
		$sqlgrid="SELECT COUNT(jurnal_id) AS jml FROM v_jurnal WHERE jurnal_source='RF-ListSD' AND jurnaltype_id='RF' AND jurnal_faktur='REFUND'";
		return $sqlgrid;
	}
	 
	/** model dialog query **/ 
	function qry_isigriddetildebet(){
		$rekanan_id = $this->input->post('rekanan_id');
		$rekananshipping_line = $this->input->post('rekananshipping_line');  
		if(!empty($_POST))
		{
			$criteria="inv.rekanan_id = ''$rekanan_id'' AND inv.rekananshipping_line = $rekananshipping_line";   
			
			$spq= "EXEC cp_TrnJurnal_SelectSecDep_refund_WPPage '$criteria' ";
			// echo $spq;exit;
			return $this->db->query($spq)->result();
		}
		else
		{
			return false;
		}
		 
	}
	
	function qry_isigriddetilkredit(){
		$rekanan_id = $this->input->post('rekanan_id');
		$rekananshipping_line = $this->input->post('rekananshipping_line');  
		if(!empty($_POST))
		{ 
			$criteria="rekanan_id = ''$rekanan_id'' AND rekananshipping_line = $rekananshipping_line";  
			$criteria2 = "[deduct] = 0"; 
			$spq= "EXEC cp_TrnJurnalOR_SelectInvoiceSingle_SD '', '$criteria','$criteria2' ";  
			 // echo $spq;exit;
			return $this->db->query($spq)->result();
		}
		else
		{
			return false;
		} 
	}
	/** end model dialog query **/
	 
	/** function select2 dropdown **/
	function get_acc(){ 
		$sql = " 
					SELECT 
					acc_id, acc_name, acc_nameshort, acc_descr, acc_isgroup, acc_parent,
					acc_path, acc_isdisabled, acc_ismonetary, acc_createby, acc_createdate, accsubgroup_id, 
					(SELECT count(acc_id) FROM master_acc where source_id = 'RF-ListSD' AND dk = 'K') as rows 
				FROM (
					SELECT *, ROW_NUMBER() OVER(ORDER BY acc_name ASC) AS row FROM
					(
					SELECT 						
						A.acc_id, 
						A.acc_name, 
						A.acc_nameshort, 
						A.acc_descr, 
						A.acc_isgroup, 
						A.acc_parent,
						A.acc_path, 
						A.acc_ismonetary, 
						A.acc_createby, 
						A.acc_createdate,
						A.accsubgroup_id, 
						B.source_id,
						B.dk,
						acc_isdisabled = (case when A.acc_isdisabled=1 then 1 when B.acc_id is null then 1 else 0 end ) 
					FROM master_acc A INNER JOIN master_source_acc B on A.acc_id = B.acc_id and A.acc_isgroup <> 1 
					) TEST where source_id = 'RF-ListSD' AND dk = 'K'
					) S 
		  "; 
		$query = $this->db->query($sql);      

		return $query->result();
	} 
   
	function get_branch(){
	  
	 // $SQL = "
		  //SELECT acc_id, acc_name
		  //FROM master_acc ";
	  
	  $SQL = "select branch_id,branch_name from master_branch";
	  
	  $query = $this->db->query($SQL);      

	  return $query->result();
	} 
  
	function get_periode(){
	  
	  $SQL = "
		  SELECT periode_id, periode_name
		  FROM master_periode where periode_isclosed=0";
	  $query = $this->db->query($SQL);      

	  return $query->result();
	} 
  
	function get_periodeall(){
	  
	  $SQL = "
		  SELECT periode_id, periode_name
		  FROM master_periode";
	  $query = $this->db->query($SQL);      

	  return $query->result();
	} 
    
	function get_journalsource(){
	  $SQL    = "EXEC [cp_MstJurnalSource_Select] '' ";
	  $query  = $this->db->query($SQL);

	return $query->result();
	}

	function get_tenantdata($criteria,$id=''){
		 
		if( !empty($id ) AND $id <> " ")
		{
		// echo var_dump($id);
		// exit;
		// Hardcoded exclude Used Items Solutions base on needs.
		$sql = "SELECT rekanan_id,rekanan_name,rekanan_badanhukum  FROM master_rekanan 
				WHERE rekanan_id = (SELECT rekanan_id 
				FROM master_rekananshipping 
				WHERE rekanan_id + cast(rekananshipping_line as varchar) = '".$id."')";
		}
		else
		{
			// Hardcoded exclude Used Items Solutions base on needs.
			$sql = "SELECT rekanan_id,rekanan_name,rekanan_badanhukum  FROM master_rekanan 
				WHERE rekanan_name LIKE '%". $criteria ."%'";
			
		}
		
		// echo var_dump($sql);
		// exit;
		
		$hdata=$this->db->query($sql);
		if($hdata->num_rows() > 0)
		{
			return $hdata->result();
		}
		else
		{
			return array();
		} 
	}
	
	function get_tradedata($criteria,$rekanan_id=''){
		if(empty($criteria) or $criteria == " "){
			return array();
			exit;
		}
		$sql = "SELECT r.rekanan_id,
				rekananshipping_name = rekanan_name + ' - ' + rekananshipping_name, 
				rekananshipping_line,
				s.branch_id,
				b.region_id,
				c.branch_name,
				d.region_name, s.rowid
				FROM master_rekananshipping s 
				left join master_rekanan r on s.rekanan_id = r.rekanan_id
				left join master_regionbranch b on s.branch_id = b.branch_id
				left join master_branch c on s.branch_id = c.branch_id
				left join master_region d on b.region_id = d.region_id
			WHERE ( rekananshipping_name LIKE '%". $criteria ."%' OR rekanan_name LIKE '%". $criteria ."%' OR s.rowid LIKE '%". $criteria ."%' ) ".(empty($rekanan_id)?"": "AND r.rekanan_id='$rekanan_id' ");
		 // echo "<pre/>";
		 // echo $sql;
		 // exit;
		$hdata=$this->db->query($sql);
		
		if($hdata->num_rows() > 0)
		{
			return $hdata->result();
		}
		else
		{
			return array();
		} 
	}
	 
	function get_acc_select2($criteria)
	{ 
		// echo var_dump($criteria);exit;
		if(empty($criteria) or $criteria == " "){
			return array();
			exit;
		}
		$sql = "SELECT acc_id,acc_name,acc_id+'-'+acc_name as acc_nameuid FROM master_acc 
		WHERE acc_name LIKE '%". $criteria ."%' OR acc_id LIKE '%". $criteria ."%' ";
		$hdata=$this->db->query($sql);
		
		if($hdata->num_rows() > 0)
		{
			return $hdata->result();
		}
		else
		{
			return array();
		} 
	}
	
	function get_strukturunit($username)
	{ 
		// echo var_dump($criteria);exit;
		if(empty($username) or $username == " "){
			$sql = "SELECT a.strukturunit_id,a.strukturunit_name FROM master_strukturunit a"; 
		}
		else
		{
			$sql = "SELECT a.strukturunit_id,a.strukturunit_name FROM master_strukturunit a 
					LEFT JOIN master_user b on a.strukturunit_id = b.strukturunit_id
					WHERE b.username='$username'"; 
		}
		
		$hdata=$this->db->query($sql);
		
		if($hdata->num_rows() > 0)
		{
			return $hdata->result();
		}
		else
		{
			return array();
		} 
	}
	/** end function select2 dropdown **/
	
	//---------------------------------------------||----------------------------------------------------------//
	//------------------------------------------||---||----------------------------------------------------------//
	//-----------------------------------------||------||--------------------------------------------------------//
	/** 02-12-2020 **/ 
	/** function default **/ 
	/** jangan di rubah **/ 
	/** data table paging and query function **/ 
	function qry_alldatalist($limit,$top,$sWhere){	 
		return $this->db->query($this->query_allgrid($limit,$top,$sWhere))->result_array();
	}
   
	function qry_filteredlist($sWhere){      
		$qry="
		  ";
		  return $this->db->query($this->query_filtergrid($sWhere))->row_array();	 
	}
   
	function qry_totalalllist(){ 
		  return $this->db->query($this->query_totalgrid())->row_array();	   
	}
    /** end data table paging and query function **/
	
	//-------------------------------------------------------------------------------------------------------//
	//-------------------------------------------------------------------------------------------------------//
	//-------------------------------------------------------------------------------------------------------// 
	

}
