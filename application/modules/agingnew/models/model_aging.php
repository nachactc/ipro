<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_aging extends CI_Model{
    
    function __construct(){
        parent::__construct();
		check_user_login();
		//ini_set("memory_limit","25M"); 
		//ini_set("memory_limit","500M");
		ini_set("sqlsrv.ClientBufferMaxKBSize","524288");
		ini_set("pdo_sqlsrv.client_buffer_max_kb_size","524288");
    }
    
	 
	
	public function get_data_dialog_loo($search='')
	{
		$where = '';
		if($search != '')
		{ 
			$where = " AND (a.loo_id LIKE '%$search%' OR d.branch_name LIKE '%$search%' OR e.rekanan_name LIKE '%$search%' OR f.rekananshipping_name LIKE '%$search%' )";	
		}
		
		$query = $this->db->query("
		SELECT distinct a.loo_id,c.region_nameshort,d.branch_name,e.rekanan_name,f.rekananshipping_name,g.agreement_id
		FROM transaksi_loo a INNER JOIN master_rekanan e on a.rekanan_id = e.rekanan_id
		LEFT JOIN master_rekananshipping f on a.rekanan_id  = f.rekanan_id and a.rekananshipping_line = f.rekananshipping_line
		LEFT JOIN master_region c on a.region_id = c.region_id
		LEFT JOIN master_branch d on a.branch_id = d.branch_id
		INNER JOIN transaksi_agreement g on a.loo_id = g.agreement_loonumber
		WHERE a.loo_id NOT IN (SELECT loo_id FROM transaksi_loireceived) 
		AND agreement_isclosed = 0	 
		$where");  
	
		//echo $this->db->last_query();
        $result =$query->result_array();
		
        if ($result ) 
        {
            return $result ;
        } 
        else 
        {
            return array();
        }
	}
	
	public function get_data_dialog_loo_rows($search='')
	{
		$where = '';
		if($search != '')
		{
			$search = strip_tags($search);
			$where = " AND (d.branch_name LIKE '%$search%' OR e.rekanan_name LIKE '%$search%' OR f.rekananshipping_name LIKE '%$search%' )";	
		}
		
		$query = $this->db->query("
		SELECT COUNT(a.loo_id) AS jml 
		FROM transaksi_loo a INNER JOIN master_rekanan e on a.rekanan_id = e.rekanan_id
		LEFT JOIN master_rekananshipping f on a.rekanan_id  = f.rekanan_id and a.rekananshipping_line = f.rekananshipping_line
		LEFT JOIN master_region c on a.region_id = c.region_id
		LEFT JOIN master_branch d on a.branch_id = d.branch_id
		INNER JOIN transaksi_agreement g on a.loo_id = g.agreement_loonumber
		WHERE a.loo_id NOT IN (SELECT loo_id FROM transaksi_loireceived)
		AND agreement_isclosed = 0
		$where");  
		 
        $result =$query->row_array();
		$vresult=$result['jml'];
        if ($result ) 
        {
           return $vresult ;
        } 
        else 
        {
            return array();
        }
		
		// $query = $this->db->query('SELECT count(loo_id) as jml FROM transaksi_loireceived');  
        // $result =$query->row_array();
		// $vresult=$result['jml'];
        // if ($result ) 
        // {
            // return $vresult ;
        // } 
        // else 
        // {
            // return array();
        // }
	}
	 
   function qry_alldatadialog($limit,$top,$sWhere){
		
		 $sWhere = empty($sWhere) ? " WHERE unit_state <> 3 " : $sWhere." AND unit_state <> 3"; 
        
	   $qry="WITH CTE AS (
 				select top $limit *,ROW_NUMBER() OVER (ORDER BY unit_id asc) as RowNumber 
				from master_unit $sWhere)
		SELECT CTE.*, FLOOR.lantai_name
    FROM CTE 
      JOIN master_lantai AS FLOOR ON CTE.lantai_id = FLOOR.lantai_id
    WHERE RowNumber > $top"; 
	   return $this->db->query($qry)->result_array();	
	   
   }
   
   function qry_filtereddialog($sWhere){
	   $sWhere = empty($sWhere) ? " WHERE unit_state <> 3 " : $sWhere." AND unit_state <> 3";    
	   
	   $qry="select count(unit_id) as jml from master_unit $sWhere";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalldialog(){
	   $qry="select count(unit_id) as jml from master_unit where unit_state<>3";
		return $this->db->query($qry)->row_array();
	   
   }

   function qry_alldatapop($limit,$top,$sWhere){
      $qry="WITH CTE AS (
          select top $limit SHIP.rekanan_id, SHIP.rekananshipping_line, SHIP.rekananshipping_name, REKA.rekanan_name,
            ROW_NUMBER() OVER (ORDER BY REKA.rekanan_name asc) as RowNumber 
          from master_rekananshipping SHIP
            JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id  
          $sWhere )
      SELECT CTE.*
      FROM CTE      
      WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();    
   }
   
   function qry_filteredpop($sWhere){
     $qry="select count(SHIP.rekanan_id) as jml
          from master_rekananshipping SHIP
            JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id $sWhere";
    return $this->db->query($qry)->row_array();
     
   }
   
   function qry_totalallpop(){
     $qry="select count(SHIP.rekanan_id) as jml
          from master_rekananshipping SHIP
            JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id";
    return $this->db->query($qry)->row_array();
     
   }

   function qry_alldataschema($limit,$top,$sWhere){
     $qry="WITH CTE AS (
        select top $limit *,ROW_NUMBER() OVER (ORDER BY skl_id asc) as RowNumber 
        from master_skl $sWhere)
    SELECT CTE.*, UTYPE.unittype_name
    FROM CTE 
      JOIN master_unittype AS UTYPE ON CTE.unittype_id = UTYPE.unittype_id
    WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();    
   }
   
   function qry_filteredschema($sWhere){
     $qry="select count(skl_id) as jml from master_skl $sWhere";
    return $this->db->query($qry)->row_array();
     
   }
   
   function qry_totalallschema(){
     $qry="select count(skl_id) as jml from master_skl";
    return $this->db->query($qry)->row_array();
     
   }
   
    function qry_alldatalist($limit,$top,$sWhere,$orderBy){
    // $sWhere = empty($sWhere) ? " WHERE unittype_id = 6 and isdisabled = 0 " : $sWhere." AND isdisabled = 0 and unittype_id = 6 ";
 
	   $qry=" 
		SELECT * FROM (
			SELECT top $limit ROW_NUMBER() OVER (ORDER BY CTE.loo_id) as RowNumber
			,CTE.id_file
			,CTE.loo_id
			,CTE.agreement_id
			,CTE.no_la
			,CTE.file_name
			,CTE.file_type
			,CTE.file_size
			,CTE.file_desc
			,CTE.createby
			,CTE.createdate
			,CTE.modifyby
			,CTE.modifydate 
			,c.region_nameshort,d.branch_name,e.rekanan_name,f.rekananshipping_name 
			FROM transaksi_la_file CTE 
			inner join transaksi_loo a on a.loo_id=CTE.loo_id 
			INNER JOIN master_rekanan e on a.rekanan_id = e.rekanan_id 
			LEFT JOIN master_rekananshipping f on a.rekanan_id = f.rekanan_id and a.rekananshipping_line = f.rekananshipping_line 
			LEFT JOIN master_region c on a.region_id = c.region_id LEFT JOIN master_branch d on a.branch_id = d.branch_id 
			$sWhere
			$orderBy
		) AS V 
		where RowNumber > $top"; 
	
	   return $this->db->query($qry)->result_array();	   
   }
    
    function qry_filteredlist($sWhere,$orderColumns=''){
    // $sWhere = empty($sWhere) ? " WHERE isdisabled = 0 and unittype_id = 6" : $sWhere." AND isdisabled = 0 and unittype_id = 6";
	 
	   $qry="	   		
			SELECT COUNT(CTE.loo_id) as jml				
			FROM transaksi_la_file CTE 
			inner join transaksi_loo a on a.loo_id=CTE.loo_id 
			INNER JOIN master_rekanan e on a.rekanan_id = e.rekanan_id 
			LEFT JOIN master_rekananshipping f on a.rekanan_id = f.rekanan_id and a.rekananshipping_line = f.rekananshipping_line 
			LEFT JOIN master_region c on a.region_id = c.region_id LEFT JOIN master_branch d on a.branch_id = d.branch_id   
			$sWhere	 
			";
	 
			//echo $qry;
		return $this->db->query($qry)->row_array();
	   
   }
   
    function qry_totalalllist(){
	   $qry="select count(loo_id) as jml from transaksi_la_file";
		return $this->db->query($qry)->row_array();
	   
   }
    
    function dataapp_list($region_id,$branch_id,$unit_id,$lantai_id){
	 
		$lantai_enc = str_replace('+','',$lantai_id);
		$unit_enc = str_replace('+','',$unit_id);
		$unit_id = $unit_id != "0" ? " AND a.unit_id = '$unit_enc'" : "" ;
		$lantai_id =  $lantai_id != "0" ? " AND a.unit_name LIKE '%$lantai_enc%' " : "";
		
        $sql = " 
         select unit_id as '0',
			c.region_name as '1',
			b.branch_name as '2',
			a.unit_name as '3',
			a.unit_sqm as '4',
			a.lantai_id as '5',
			c.region_id as '6',
			b.branch_id as '7'
			from master_unit a 
		left join master_branch b on a.branch_id = b.branch_id 
		left join master_region c on a.region_id = c.region_id 
		where a.region_id = $region_id and a.branch_id = '$branch_id' $unit_id $lantai_id"   ; 
		//echo $sql;
		//echo $lantai_enc;
        return $this->db->query($sql)->result_array();
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

	function get_ReportAging($startdate,$agingdate,$paymentdate,$criteria)
	{
		//debugtest
		//$criteria = '';
		//debug_backtrace
		
		$SP_SQL = "EXEC cp_RptReceivable_Fin_IPRO '$startdate','$agingdate','$paymentdate','$criteria'";
		// echo ($SP_SQL);
		// exit;
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

	function set_ReportAgingV2($startdate,$agingdate,$paymentdate,$criteria)
	{
		$SQL = "
		TRUNCATE TABLE transaksi_agingv2

		INSERT INTO transaksi_agingv2
		(jurnal_id, jurnal_date, periode, jurnal_descr, detil_descr, amount, debet, kredit, acc_id, acc_name, ref_id, ref_line, invoicenumber, invoiceid, region_name, branch_name, branch_idlok, rekanan_name, rekananshipping_name)
		SELECT
				d.jurnal_id , 
				CONVERT(DATE, j.jurnal_bookdate)                                                        AS jurnal_date,
				CONVERT(VARCHAR(6), j.jurnal_bookdate, 112)												AS periode, 
				Replace(Replace(Replace(j.jurnal_descr, Char(13), ''), Char(10), ''), Char(9), '')      AS jurnal_descr, 
				Replace(Replace(Replace(d.jurnaldetil_descr, Char(13), ''), Char(10), ''), Char(9), '') AS detil_descr,
					d.jurnaldetil_idr        AS amount, 
					CASE 
					  WHEN jurnaldetil_idr > 0 THEN jurnaldetil_idr 
					  ELSE 0 
					END 
						   AS Debet, 
					CASE 
					  WHEN jurnaldetil_idr < 0 THEN jurnaldetil_idr 
					  ELSE 0 
					END 
						   AS Kredit, 
				d.acc_id, 
				a.acc_name, 
				d.ref_id, 
				d.ref_line, 
				Isnull(j.jurnal_faktur, '') 
					   AS InvoiceNumber, 
				Isnull(jj.jurnal_faktur, '') 
					   AS InvoiceID, 
				r.region_name, 
				b.branch_name, 
				b.branch_idlok, 
				rk.rekanan_name, 
				rs.rekananshipping_name 
				FROM   transaksi_jurnaldetil d 
					   INNER JOIN transaksi_jurnal j 
							   ON j.jurnal_id = d.jurnal_id 
					   LEFT JOIN transaksi_jurnal jj 
							  ON d.ref_id = jj.jurnal_id 
					   LEFT JOIN master_acc a 
							  ON d.acc_id = a.acc_id 
					   LEFT JOIN master_region r 
							  ON d.region_id = r.region_id 
					   LEFT JOIN master_branch b 
							  ON d.branch_id = b.branch_id 
					   LEFT JOIN master_rekanan rk 
							  ON d.rekanan_id = rk.rekanan_id 
					   LEFT JOIN master_rekananshipping rs 
							  ON d.rekanan_id = rs.rekanan_id 
								 AND d.rekananshipping_line = rs.rekananshipping_line 
				WHERE  j.jurnal_isposted = 1  
					   AND $criteria
				--ORDER  BY rekanan_name,rekananshipping_name,acc_name,j.jurnal_bookdate,d.jurnal_id 
		"; 
		  //ECHO $SQL;exit;
		$this->db->query($SQL);
		
		if ($this->db->trans_status() === FALSE)
		{               
				//generate an error... or use the log_message() function to log your error
				$this->db->trans_rollback();
				return false;
		}else{
				$this->db->trans_commit();

				return true;  
		}
		
	}

	function get_ReportAgingV2Mod($start, $end){
		//$SQL = " SELECT * FROM transaksi_agingv2 ";

		//$result = $this->db->query($SQL);
		//$temp = $result->result();
		// echo "debug";
		//var_dump($result->result());exit;
		//return $result->result();
		sqlsrv_configure('WarningsReturnAsErrors', 0);

      $qPart = "
        SELECT 
					jurnal_id, jurnal_date, periode, jurnal_descr, detil_descr, amount, debet, kredit, acc_id, acc_name, ref_id, ref_line, 
					invoicenumber, invoiceid, region_name, branch_name, branch_idlok, rekanan_name, rekananshipping_name
        FROM  ( SELECT ROW_NUMBER() OVER(ORDER BY jurnal_date asc) AS row, 
								jurnal_id, jurnal_date, periode, jurnal_descr, detil_descr, amount, debet, kredit, acc_id, acc_name, ref_id, ref_line, 
								invoicenumber, invoiceid, region_name, branch_name, branch_idlok, rekanan_name, rekananshipping_name
                FROM dbo.transaksi_agingv2 ) BI
        WHERE BI.row >= $start AND  BI.row <= $end ";

      $record = $this->db->query($qPart)->result();
      
      return $record;

	}

	function get_CountAgingv2() {

		$_SQL = " SELECT count(jurnal_id) as count_rows FROM transaksi_agingv2 ";
		$result = $this->db->query($_SQL)->row();
		$count = $result->count_rows;  

		return $count;      
	}	
	
	/* new 2020 - 02 - 20 */
	/* request from Mr.Agro */
	/* aging v2 */
	function get_ReportAgingV2($startdate,$agingdate,$paymentdate,$criteria)
	{
		$SQL = "
		SELECT
				d.jurnal_id , 
				CONVERT(DATE, j.jurnal_bookdate)                                                        AS jurnal_date,
				CONVERT(VARCHAR(6), j.jurnal_bookdate, 112)												AS periode, 
				Replace(Replace(Replace(j.jurnal_descr, Char(13), ''), Char(10), ''), Char(9), '')      AS jurnal_descr, 
				Replace(Replace(Replace(d.jurnaldetil_descr, Char(13), ''), Char(10), ''), Char(9), '') AS detil_descr,
					d.jurnaldetil_idr        AS amount, 
					CASE 
					  WHEN jurnaldetil_idr > 0 THEN jurnaldetil_idr 
					  ELSE 0 
					END 
						   AS Debet, 
					CASE 
					  WHEN jurnaldetil_idr < 0 THEN jurnaldetil_idr 
					  ELSE 0 
					END 
						   AS Kredit, 
				d.acc_id, 
				a.acc_name, 
				d.ref_id, 
				d.ref_line, 
				Isnull(j.jurnal_faktur, '') 
					   AS InvoiceNumber, 
				Isnull(jj.jurnal_faktur, '') 
					   AS InvoiceID, 
				r.region_name, 
				b.branch_name, 
				b.branch_idlok, 
				rk.rekanan_name, 
				rs.rekananshipping_name 
				FROM   transaksi_jurnaldetil d 
					   INNER JOIN transaksi_jurnal j 
							   ON j.jurnal_id = d.jurnal_id 
					   LEFT JOIN transaksi_jurnal jj 
							  ON d.ref_id = jj.jurnal_id 
					   LEFT JOIN master_acc a 
							  ON d.acc_id = a.acc_id 
					   LEFT JOIN master_region r 
							  ON d.region_id = r.region_id 
					   LEFT JOIN master_branch b 
							  ON d.branch_id = b.branch_id 
					   LEFT JOIN master_rekanan rk 
							  ON d.rekanan_id = rk.rekanan_id 
					   LEFT JOIN master_rekananshipping rs 
							  ON d.rekanan_id = rs.rekanan_id 
								 AND d.rekananshipping_line = rs.rekananshipping_line 
				WHERE  j.jurnal_isposted = 1  
					   AND $criteria
				ORDER  BY rekanan_name,rekananshipping_name,acc_name,j.jurnal_bookdate,d.jurnal_id 
		"; 
		  //ECHO $SQL;exit;
		$result = $this->db->query($SQL);
		//$temp = $result->result();
		// echo "debug";
		 //ECHO var_dump($SQL);exit;
		return $result->result();
		
	}
	
	/* new 2020 - 02 - 21 */
	/* request from Mr.Agro */
	/* aging v3 */
	function get_ReportAgingRaw($startdate,$agingdate,$paymentdate,$criteria)
	{
		//debugtest
		//$criteria = '';
		//debug_backtrace
		
		$SP_SQL = "EXEC cp_RptAgingRawData_IPRO '$startdate','$agingdate','$paymentdate','$criteria'";
		// echo ($SP_SQL);
		// exit;
		$result = $this->db->query($SP_SQL);
		//$temp = $result->result();
		
		
		if($result->num_rows() > 0)
		{
			return $result;
		}
		else
		{
			return 'kosong';
		}
		 
	}
	
	function get_ReportAging_NoProforma($startdate,$agingdate,$paymentdate,$criteria)
	{
		//debugtest
		//$criteria = '';
		//debug_backtrace
		
		$SP_SQL = "EXEC cp_RptReceivable_FinNoPro '$startdate','$agingdate','$paymentdate','$criteria'";
		//echo var_dump($SP_SQL);
		//exit;
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
	
	function get_DepositType()
	{
		$this->db->select('agreementtype_nameshort');
		$this->db->where('agreementtype_group','DEPOSIT');
		$this->db->where("agreementtype_name not like '%Credit Note%' ");
		$hasil = $this->db->get('master_agreementtype');
		if($hasil->num_rows() > 0)
		{
			return $hasil->result();
		}
		else
		{
			return 'kosong';
		}
	}

	function get_Rekanan() {

		$sql = "
			select A.rekanan_id, B.rekananshipping_line 
			from master_rekanan A
			inner join master_rekananshipping B ON A.rekanan_id = B.rekanan_id
			where 
					A.rekanantype_id = '105' 
				and A.rekanan_isdisabled = 0
			order by A.rekanan_id;
		";

		$result = $this->db->query($sql);
		//$temp = $result->result();
		// echo "debug";
		//ECHO var_dump($result->result());exit;
		
		return $result->result();

	}
	
   
 }