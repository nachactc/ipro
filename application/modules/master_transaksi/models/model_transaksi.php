<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_transaksi extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
	function get_trx($jurnal_id)
	{
		$query = "SELECT a.*
				FROM master_transaksi a  
				WHERE a.transaksi_id = '$jurnal_id'";
		$hasil = $this->db->query($query);
		if($hasil->num_rows() >0)
		{
			return $hasil->row_array();
		}
	}
	
	function get_jurnaldetilD($transaksi_id)
	{	  
		if($transaksi_id <> '')
		{
			$query = " 
				select 1 as pos_sel,a.pospayment_id,a.transaksipospayment_isdisabled,
				acc_id,acc_id_disc,acc_id_ppn,
				b.pospayment_name 
				from master_transaksipospayment a
				left join master_pospayment b on a.pospayment_id =b.pospayment_id
				WHERE a.transaksi_id = '$transaksi_id'
				UNION ALL
				select DISTINCT 
				0 as pos_sel,a.pospayment_id,a.transaksipospayment_isdisabled,0 as acc_id,0 as acc_id_disc,0 as acc_id_ppn,
				b.pospayment_name 
				from master_transaksipospayment a
				left join master_pospayment b on a.pospayment_id =b.pospayment_id
				where ISNULL(b.pospayment_name,'') <> '' 
				AND  a.transaksi_id <> '$transaksi_id'  AND a.pospayment_id NOT IN (SELECT pospayment_id FROM master_transaksipospayment WHERE transaksi_id = '$transaksi_id')
				ORDER BY b.pospayment_name ASC
				";
		}
		else
		{
			$query = "
				select DISTINCT 
				0 as pos_sel,a.pospayment_id,a.transaksipospayment_isdisabled,0 as acc_id,0 as acc_id_disc,0 as acc_id_ppn,
				b.pospayment_name 
				from master_transaksipospayment a
				left join master_pospayment b on a.pospayment_id =b.pospayment_id
				where ISNULL(b.pospayment_name,'') <> '' 
				ORDER BY b.pospayment_name ASC";
		}
		// echo "<pre/>";echo $query;exit;
		$hasil = $this->db->query($query);
		if($hasil->num_rows() >0)
		{
			return $hasil->result_array();
		}
	}
	
	function get_jurnaldetilK($transaksi_id)
	{
		if($transaksi_id <> '')
		{
			$query = "
			select  1 as agr_sel,a.agreementtype_id,a.transaksiagreementtype_isdisabled,a.transaksiagreementtype_isdisabled,
			acc_id,acc_id_disc,acc_id_ppn,b.agreementtype_name,a.transaksiagreementtype_dk
			from  master_transaksiagreementtype a
			left join master_agreementtype b on a.agreementtype_id =b.agreementtype_id
			WHERE a.transaksi_id = '$transaksi_id' 
			UNION ALL
			select DISTINCT 0 as agr_sel,a.agreementtype_id,a.transaksiagreementtype_isdisabled,a.transaksiagreementtype_isdisabled,
			0 as acc_id,0 as acc_id_disc,0 as acc_id_ppn,b.agreementtype_name,a.transaksiagreementtype_dk
			from  master_transaksiagreementtype a
			left join master_agreementtype b on a.agreementtype_id =b.agreementtype_id 
			where ISNULL(b.agreementtype_name,'') <> '' AND a.transaksi_id <> '$transaksi_id' 
				AND a.agreementtype_id NOT IN (SELECT agreementtype_id FROM master_transaksiagreementtype WHERE transaksi_id = '$transaksi_id')
			ORDER BY b.agreementtype_name ASC";
		}
		else
		{
			$query = "
			select DISTINCT 0 as agr_sel,a.agreementtype_id,a.transaksiagreementtype_isdisabled,a.transaksiagreementtype_isdisabled,
			0 as acc_id,0 as acc_id_disc,0 as acc_id_ppn,b.agreementtype_name,a.transaksiagreementtype_dk
			from  master_transaksiagreementtype a
			left join master_agreementtype b on a.agreementtype_id =b.agreementtype_id 
			where ISNULL(b.agreementtype_name,'') <> ''
			ORDER BY b.agreementtype_name ASC";
		}
		// echo $query;exit;
		$hasil = $this->db->query($query);
		if($hasil->num_rows() >0)
		{
			return $hasil->result_array();
		}
	}
	 
	function get_acc(){
		$query="SELECT * FROM master_acc WHERE acc_isdisabled = 0";
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
	 
	/** collect save data **/ 
	
	function save_trx(){
	$transaksi_id = $this->input->post('transaksi_id'); 
	$this->db->trans_begin(); 
		try {
			$header = $this->insert_trx_header(); 
			// echo var_dump($header);exit;
			if(!empty($transaksi_id))
			{
				$receive_insert = $this->insert_trx_receive();  
				$agreement_insert = $this->insert_trx_agr();
				 
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
				echo "Data tidak Terbentuk!";
				return FALSE; 
			}
			
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		
	}
	
	/** collect update data **/ 
	
	function update_trx(){
	$transaksi_id = $this->input->post('transaksi_id'); 
	 $this->db->trans_begin(); 
		try {
			$transaksi_id = $this->input->post('transaksi_id'); 
			 
			if(!empty($transaksi_id))
			{
				$header = $this->update_trx_header($transaksi_id);
				 
				//check sebelum delete
				if($header)
				{	
					if(!empty($transaksi_id))
					{ 
						$destroyReceive = "DELETE FROM master_transaksipospayment WHERE transaksi_id = '$transaksi_id'"; 
						$this->db->query($destroyReceive);
						
						$destroyAgr = "DELETE FROM master_transaksiagreementtype WHERE transaksi_id = '$transaksi_id'"; 
						$this->db->query($destroyAgr);
						// echo "<pre/>";echo $destroyAgr;exit;
						 
						//insert kembali
						$insertReceive = $this->insert_trx_receive(); 
						$insertAgr = $this->insert_trx_agr(); 
					} 
				}
				else
				{
					return false;
				}
				  
				if ($this->db->trans_status() === FALSE)
				{ 
					$this->db->trans_rollback();
					return FALSE; 
				}
				else
				{
				
				
					$this->db->trans_commit();
					$this->db->trans_complete();
					return true;
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
	function insert_trx_header(){
		if(!empty($_POST))
		{
			$transaksi_id = $this->input->post('transaksi_id'); 
			$transaksi_name = $this->input->post('transaksi_name'); 
			$transaksi_descr = $this->input->post('transaksi_descr');  
			$iteminventorytype_id = $this->input->post('iteminventorytype_id'); 
			$transaksiisdisabled = $this->input->post('transaksi_isdisabled'); 
			$isdisabled = isset($transaksiisdisabled) ? 1 : 0;
			$username = $this->session->userdata('username');
			$date_input = date('Y-m-d');
			$sql = "INSERT INTO master_transaksi
					(transaksi_id,transaksi_name,transaksi_descr,iteminventorytype_id,transaksi_createby,transaksi_createdate,transaksi_isdisabled)
					VALUES
					('$transaksi_id','$transaksi_name','$transaksi_descr','$iteminventorytype_id','$username','$date_input',$isdisabled)";
			// echo "<pre>";echo var_dump($sql);exit;
			$insertH = $this->db->query($sql); 
			return $insertH;
		} 
	} 
	function insert_trx_receive(){
			
			$transaksi_id = $this->input->post('transaksi_id');  
			$isdisabled = $this->input->post('pos_isdisabled'); 
			$acc_id = $this->input->post('acc_id_r'); 
			$acc_id_disc = $this->input->post('acc_id_disc_r'); 
			$acc_id_ppn = $this->input->post('acc_id_ppn_r'); 
			$pospayment_id = $this->input->post('pospayment_id'); 
		 
			$i = 0;
			if(!empty($_POST))
			{  
				foreach($acc_id as $value => $n) {
					$pos_sel = $this->input->post('pos_'.$i); 
					if(intval($pos_sel) >= 1)
					{
						$disabled = isset($isdisabled[$value]) ? $isdisabled[$value] : 0;
						$acc_id_ = isset($acc_id[$value]) ? $acc_id[$value] : '0';
						$acc_id_ppn_ = isset($acc_id_ppn[$value]) ? $acc_id_ppn[$value] : '0';
						$acc_id_disc_ = isset($acc_id_disc[$value]) ? $acc_id_disc[$value] : '0';
						$sql = "INSERT INTO [dbo].[master_transaksipospayment]
									   ([transaksi_id]
									   ,[pospayment_id]
									   ,[transaksipospayment_isdisabled]
									   ,[acc_id]
									   ,[acc_id_ppn]
									   ,[acc_id_disc])
								 VALUES
									   ('$transaksi_id'
									   ,'$pospayment_id[$value]'
									   ,$disabled
									   ,'$acc_id_'
									   ,'$acc_id_ppn_'
									   ,'$acc_id_disc_')";
										
						
						$insertDb = $this->db->query($sql); 
					}
					$i++;
				} 
				return true;
			}
	} 
	function insert_trx_agr(){
		$i=0;
		$transaksi_id = $this->input->post('transaksi_id');  
		$isdisabled = $this->input->post('agr_isdisabled');   
		$acc_id = $this->input->post('acc_id_ag'); 
		$acc_id_disc = $this->input->post('acc_id_disc_ag'); 
		$acc_id_ppn = $this->input->post('acc_id_ppn_ag'); 
		$agreementtype_id = $this->input->post('agreementtype_id'); 
		 
		if(!empty($_POST))
		{ 
			foreach($acc_id as $value => $n) {
			$agr_sel = $this->input->post('agr_'.$i);
			// echo "<pre/>";echo var_dump($_POST);exit;
			if(intval($agr_sel) >= 1)
			{
				$disabled = isset($isdisabled[$value]) ? $isdisabled[$value] : 0;
				$acc_id_ = isset($acc_id[$value]) ? $acc_id[$value] : '0';
				$acc_id_ppn_ = isset($acc_id_ppn[$value]) ? $acc_id_ppn[$value] : '0';
				$acc_id_disc_ = isset($acc_id_disc[$value]) ? $acc_id_disc[$value] : '0';
					$sql = "INSERT INTO [dbo].[master_transaksiagreementtype]
								   ([transaksi_id]
								   ,[agreementtype_id]
								   ,[transaksiagreementtype_isdisabled]
								   ,[transaksiagreementtype_dk]
								   ,[acc_id]
								   ,[acc_id_ppn]
								   ,[acc_id_disc])
							 VALUES
								   ('$transaksi_id'
								   ,'$agreementtype_id[$value]'
								   ,$disabled
								   ,'0'
								   ,'$acc_id_'
								   ,'$acc_id_ppn_'
								   ,'$acc_id_disc_')"; 
					$insertDb = $this->db->query($sql); 
					// echo var_dump($insertDb);exit;
			}   
			$i++;
			}
			return true;
		}
	} 
	function update_trx_header(){
		if(!empty($_POST))
		{
			$transaksi_id = $this->input->post('transaksi_id'); 
			$transaksi_name = $this->input->post('transaksi_name'); 
			$transaksi_descr = $this->input->post('transaksi_descr');  
			$iteminventorytype_id = $this->input->post('iteminventorytype_id'); 
			$username = $this->session->userdata('username');
			$date_input = date('Y-m-d');
			$transaksiisdisabled = $this->input->post('transaksi_isdisabled'); 
			$isdisabled = isset($transaksiisdisabled) ? 1 : 0;
			
			$sql = "UPDATE [dbo].[master_transaksi]
					   SET  [transaksi_name] = '$transaksi_name'
						  ,[transaksi_descr] = '$transaksi_descr'
						  ,[transaksi_isdisabled] = $isdisabled 
						  ,[transaksi_modifyby] = '$username'
						  ,[transaksi_modifydate] = '$date_input'
						  ,[iteminventorytype_id] = '$iteminventorytype_id' 
					 WHERE [transaksi_id] = '$transaksi_id'
					";
			
			$updateH = $this->db->query($sql); 
			return $updateH;
		} 
	}
	
	/** ubah hanya querynya saja sesuai keperluan**/ 
	function query_allgrid($limit,$top,$sWhere,$jurnalsource_id,$jurnaltype_id){
	// echo var_dump($sWhere);exit;
		$where = (!empty($sWhere) ? $sWhere :'');
		$sqlgrid = "SELECT * FROM (
			SELECT TOP $limit ROW_NUMBER() OVER (ORDER BY transaksi_id desc) AS RowNumber,
		 transaksi_id,transaksi_name,transaksi_descr,iteminventorytype_id,transaksi_createby,transaksi_createdate,transaksi_modifydate,transaksi_modifyby,transaksi_isdisabled
		FROM master_transaksi
		$where
		ORDER BY transaksi_id DESC
	  ) AS V
	  WHERE   RowNumber > $top";
	  // echo "<pre/>";echo $sqlgrid;exit;
		return $sqlgrid;
	}
	
	function query_filtergrid($sWhere,$jurnalsource_id,$jurnaltype_id){
		$where = (!empty($sWhere) ? $sWhere :'');
		$sqlgrid = "SELECT COUNT(*) as jml FROM (
					SELECT ROW_NUMBER() OVER (ORDER BY transaksi_id desc) AS RowNumber,
					  transaksi_id,transaksi_name,transaksi_descr,iteminventorytype_id
					FROM master_transaksi
			$where		 
			  ) AS V";
		return $sqlgrid;
	}
	
	function query_totalgrid($jurnalsource_id,$jurnaltype_id){
		$sqlgrid="SELECT COUNT(transaksi_id) AS jml FROM master_transaksi";
		return $sqlgrid;
	}
	 
	/** function select2 dropdown **/
	 
	function get_iteminventorytype()
	{  
		$sql = "SELECT a.iteminventorytype_id,a.iteminventorytype_name FROM master_iteminventorytype a"; 
		 
		
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
