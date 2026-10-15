<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_struktur extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
	function get_trx($strukturunit_id,$strukturunitapprovalauth_line)
	{
		$query = "select 
					b.strukturunit_name,
					a.*
					from master_strukturunitapprovalauth a
					left join master_strukturunit b on a.strukturunit_id = b.strukturunit_id 
					WHERE a.strukturunit_id='$strukturunit_id'
					AND a.strukturunitapprovalauth_line = $strukturunitapprovalauth_line
					";
					// echo $query;
		$hasil = $this->db->query($query);
		if($hasil->num_rows() >0)
		{
			return $hasil->row_array();
		}
	} 
	 
	/** collect save data **/ 
	
	function save_trx(){  
		$this->db->trans_begin(); 
		try {
			$header = $this->insert_trx_header();   
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
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		
	}
	
	/** collect update data **/ 
	
	function update_trx(){  
		$this->db->trans_begin(); 
		try { 
			$header = $this->update_trx_header();
			
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
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		
	}
	
	/** add data area **/ 
	
	/** jurnal header **/ 
	function insert_trx_header(){
		if(!empty($_POST))
		{
			$strukturunit_id = $this->input->post('strukturunit_id'); 
			$strukturunitapprovalauth_line = ($this->get_approval_line($strukturunit_id)+10);
			$strukturunitapprovalauth_seq = $this->input->post('strukturunitapprovalauth_seq'); 
			$strukturunitapprovalauth_position = $this->input->post('strukturunitapprovalauth_position'); 
			$strukturunitapprovalauth_descr = $this->input->post('strukturunitapprovalauth_descr'); 
			$strukturunitapprovalauth_value = $this->input->post('strukturunitapprovalauth_value'); 
			$strukturunitapprovalauth_header = $this->input->post('strukturunitapprovalauth_header'); 
			$strukturunitapprovalauth_minvalues = $this->input->post('strukturunitapprovalauth_minvalues'); 
			$strukturunitapprovalauth_maxvalues = $this->input->post('strukturunitapprovalauth_maxvalues'); 
			$username = $this->input->post('username'); 
			$strukturunitapprovalauth_name = $this->get_userfullname($username); 
			$strukturunitapprovalauth_type = strtoupper($this->input->post('strukturunitapprovalauth_type')); 
			$strukturunitapprovalauth_date = date('Y-m-d'); 
			$disabled = $this->input->post('strukturunitapprovalauth_isdisabled');
			$strukturunitapprovalauth_isdisabled = isset($disabled) ? 1 : 0;
			
			$sql = "INSERT INTO [dbo].[master_strukturunitapprovalauth]
						   ([strukturunit_id]
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
						   ,[strukturunitapprovalauth_type])
					 VALUES
						   ('$strukturunit_id'
						   ,$strukturunitapprovalauth_line
						   ,$strukturunitapprovalauth_seq
						   ,'$strukturunitapprovalauth_name'
						   ,'$strukturunitapprovalauth_position'
						   ,'$strukturunitapprovalauth_descr'
						   ,$strukturunitapprovalauth_value
						   ,'$strukturunitapprovalauth_date'
						   ,$strukturunitapprovalauth_isdisabled
						   ,'$strukturunitapprovalauth_header'
						   ,$strukturunitapprovalauth_minvalues
						   ,$strukturunitapprovalauth_maxvalues
						   ,'$username'
						   ,'$strukturunitapprovalauth_type')";
			// echo "<pre>";echo var_dump($sql);exit;
			$insertH = $this->db->query($sql); 
			return $insertH;
		} 
	}  
	
	function update_trx_header(){
		if(!empty($_POST))
		{
			$strukturunit_id = $this->input->post('strukturunit_id'); 
			$strukturunitapprovalauth_line = $this->input->post('strukturunitapprovalauth_line');
			$strukturunitapprovalauth_seq = $this->input->post('strukturunitapprovalauth_seq'); 
			$strukturunitapprovalauth_position = $this->input->post('strukturunitapprovalauth_position'); 
			$strukturunitapprovalauth_descr = $this->input->post('strukturunitapprovalauth_descr'); 
			$strukturunitapprovalauth_value = $this->input->post('strukturunitapprovalauth_value'); 
			$strukturunitapprovalauth_header = $this->input->post('strukturunitapprovalauth_header'); 
			$strukturunitapprovalauth_minvalues = $this->input->post('strukturunitapprovalauth_minvalues'); 
			$strukturunitapprovalauth_maxvalues = $this->input->post('strukturunitapprovalauth_maxvalues'); 
			$username = $this->input->post('username'); 
			$strukturunitapprovalauth_name = $this->get_userfullname($username); 
			$strukturunitapprovalauth_type = strtoupper($this->input->post('strukturunitapprovalauth_type')); 
			$strukturunitapprovalauth_date = date('Y-m-d'); 
			$disabled = $this->input->post('strukturunitapprovalauth_isdisabled');
			$strukturunitapprovalauth_isdisabled = isset($disabled) ? 1 : 0;
			
			$sql = "
				UPDATE [dbo].[master_strukturunitapprovalauth]
				   SET [strukturunitapprovalauth_seq] = $strukturunitapprovalauth_seq
					  ,[strukturunitapprovalauth_name] = '$strukturunitapprovalauth_name'
					  ,[strukturunitapprovalauth_position] = '$strukturunitapprovalauth_position'
					  ,[strukturunitapprovalauth_descr] = '$strukturunitapprovalauth_descr'
					  ,[strukturunitapprovalauth_value] = $strukturunitapprovalauth_value
					  ,[strukturunitapprovalauth_date] = '$strukturunitapprovalauth_date'
					  ,[strukturunitapprovalauth_isdisabled] = $strukturunitapprovalauth_isdisabled
					  ,[strukturunitapprovalauth_header] = '$strukturunitapprovalauth_header'
					  ,[strukturunitapprovalauth_minvalues] = $strukturunitapprovalauth_minvalues
					  ,[strukturunitapprovalauth_maxvalues] = $strukturunitapprovalauth_maxvalues
					  ,[username] = '$username'
					  ,[strukturunitapprovalauth_type] = '$strukturunitapprovalauth_type'
				 WHERE strukturunit_id = '$strukturunit_id' AND strukturunitapprovalauth_line = $strukturunitapprovalauth_line";
			// echo "<pre>";echo var_dump($sql);exit;
			$updateH = $this->db->query($sql); 
			return $updateH;
		} 
	}
	
	private function get_approval_line($strukturunit_id){
		$query = "SELECT TOP 1 strukturunitapprovalauth_line 
		FROM master_strukturunitapprovalauth
		WHERE strukturunit_id = '$strukturunit_id' 
		ORDER BY strukturunitapprovalauth_line DESC";
		$hasil = $this->db->query($query);
		if($hasil->num_rows() >0)
		{
			return $hasil->row()->strukturunitapprovalauth_line;
		}
		else
		{
			return 0;
		}
	} 
	
	private function get_userfullname($username){
		$query = "
					SELECT user_fullname 
					FROM master_user 
					WHERE user_isdisabled = 0 
					AND username = '$username'";
		$hasil = $this->db->query($query);
		if($hasil->num_rows() >0)
		{
			return $hasil->row()->user_fullname;
		}
		else
		{
			return '-';
		}
	}
	
	/** ubah hanya querynya saja sesuai keperluan**/ 
	function query_allgrid($limit,$top,$sWhere,$jurnalsource_id,$jurnaltype_id){
	// echo var_dump($sWhere);exit;
		$where = (!empty($sWhere) ? $sWhere :'');
		$sqlgrid = "SELECT * FROM (
						SELECT TOP $limit ROW_NUMBER() OVER (ORDER BY a.strukturunit_id desc) AS RowNumber,
						a.*,b.strukturunit_name
					FROM master_strukturunitapprovalauth a 
					LEFT JOIN master_strukturunit b on a.strukturunit_id = b.strukturunit_id 
					$where
					ORDER BY a.strukturunit_id DESC
	  ) AS V
	  WHERE   RowNumber > $top";
	  // echo "<pre/>";echo $sqlgrid;exit;
		return $sqlgrid;
	}
	
	function query_filtergrid($sWhere,$jurnalsource_id,$jurnaltype_id){
		$where = (!empty($sWhere) ? $sWhere :'');
		$sqlgrid = "SELECT COUNT(*) as jml FROM (
					SELECT ROW_NUMBER() OVER (ORDER BY a.strukturunit_id desc) AS RowNumber,
					  a.*,b.strukturunit_name
					FROM master_strukturunitapprovalauth a
					LEFT JOIN master_strukturunit b on a.strukturunit_id = b.strukturunit_id 
			$where		 
			  ) AS V";
		return $sqlgrid;
	}
	
	function query_totalgrid($jurnalsource_id,$jurnaltype_id){
		$sqlgrid="SELECT COUNT(strukturunit_id) AS jml FROM master_strukturunitapprovalauth";
		return $sqlgrid;
	}
	 
	/** function select2 dropdown **/
	
	function get_username(){
		$query="SELECT * FROM master_user WHERE user_isdisabled = 0";
		$hasil = $this->db->query($query);
		if($hasil->num_rows() >0)
		{
			return $hasil->result();
		}
		else
		{
			return array();
		}
	}
	
	function get_strukturunit(){
		$query="SELECT * FROM master_strukturunit";
		$hasil = $this->db->query($query);
		if($hasil->num_rows() >0)
		{
			return $hasil->result();
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
	function qry_alldatalist($limit,$top,$sWhere,$jurnalsource_id,$jurnaltype_id){	 
		return $this->db->query($this->query_allgrid($limit,$top,$sWhere,$jurnalsource_id,$jurnaltype_id))->result_array();
	}
   
	function qry_filteredlist($sWhere,$jurnalsource_id,$jurnaltype_id){      
		$qry="
		  ";
		  return $this->db->query($this->query_filtergrid($sWhere,$jurnalsource_id,$jurnaltype_id))->row_array();	 
	}
   
	function qry_totalalllist($jurnalsource_id,$jurnaltype_id){ 
		  return $this->db->query($this->query_totalgrid($jurnalsource_id,$jurnaltype_id))->row_array();	   
	}
    /** end data table paging and query function **/
	
	//-------------------------------------------------------------------------------------------------------//
	//-------------------------------------------------------------------------------------------------------//
	//-------------------------------------------------------------------------------------------------------// 
}
