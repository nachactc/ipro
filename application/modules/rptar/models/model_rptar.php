<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_rptar extends CI_Model{
    
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

	function get_ReportAR($startdate,$agingdate,$paymentdate,$criteria)
	{
		//debugtest
		//$criteria = '';
		//debug_backtrace
		
		// $SP_SQL = "EXEC cp_RptReceivable_Fin_IPRO '$startdate','$agingdate','$paymentdate','$criteria'";
		//report AR
		/*
		$sp1 = "select 
				d.jurnal_id ,CONVERT(DATE,j.jurnal_bookdate)as jurnal_date, periode=convert(varchar(6),j.jurnal_bookdate,112),
				REPLACE(REPLACE(REPLACE(j.jurnal_descr,CHAR(13),''),CHAR(10),''),CHAR(9),'') as jurnal_descr,REPLACE(REPLACE(REPLACE(d.jurnaldetil_descr,CHAR(13),''),CHAR(10),''),CHAR(9),'') as detil_descr,
				d.jurnaldetil_idr as amount, case when jurnaldetil_idr > 0 then jurnaldetil_idr else 0 end as Debet,  case when jurnaldetil_idr < 0 then jurnaldetil_idr else 0 end as Kredit, d.acc_id, a.acc_name, d.ref_id, d.ref_line  
				, ISNULL(j.jurnal_faktur,'') as InvoiceNumber, ISNULL(jj.jurnal_faktur,'') as InvoiceID, ISNULL(grouptenant_id,'') as TenantGroup
				,r.region_name , b.branch_name , b.branch_idlok, rk.rekanan_name , rs.rekananshipping_name,j.jurnal_source
				from transaksi_jurnaldetil d
				inner join transaksi_jurnal j on j.jurnal_Id =d.jurnal_id 
				left join transaksi_jurnal jj on d.ref_Id =jj.jurnal_id 
				left join master_acc a on d.acc_Id =a.acc_id 
				left join master_region r on d.region_id =r.region_id 
				left join master_branch b on d.branch_id =b.branch_id 
				left join master_rekanan rk on d.rekanan_id =rk.rekanan_id 
				left join master_rekananshipping rs on d.rekanan_id =rs.rekanan_id and d.rekananshipping_line =rs.rekananshipping_line  
				where j.jurnal_isposted =1
				and convert(varchar(10),j.jurnal_bookdate, 120) >= '$agingdate'
				and convert(varchar(10),j.jurnal_bookdate, 120) <= '$startdate'
				and ((d.acc_id in (select acc_id_start from master_accaging where accaging_id='AR') and d.acc_id not in ('1040406','1040101','1020199'))  
				OR d.ACC_ID IN('2030101','2040101','2040102','2040103','2040104') 
				)
				order by rekanan_name, rekananshipping_name, acc_name, j.jurnal_bookdate , d.jurnal_id";
		*/
		$sp1 = "EXEC cp_RptReceivable_ARALL '$agingdate', '$startdate'";
		//echo $sp1;exit;
		$result = $this->db->query($sp1);
		// $temp = $result->result();
		
		 //echo $sp1;exit;
		
		if($result->num_rows() > 0)
		{
			return $result->result();
		}
		else
		{
			return 'kosong';
		}
		 
	}
	
	/* new 2020 - 02 - 20 */
	/* request from Mr.Agro */
	/* aging v2 */
	function get_ReportAgingV2($startdate,$agingdate,$paymentdate,$criteria)
	{ 
		$sp2 = "SELECT 
				 A.jurnal_id, A.jurnaldetil_line, A.acc_id, A.region_id, A.branch_id, A.rekanan_id, A.jurnaldetil_descr, A.jurnaldetil_idr, A.jurnaldetil_foreign,
				 A.ref_id, A.rekananshipping_line, A.sub2_id,
				 B.jurnal_bookdate, B.jurnal_duedate, B.jurnal_descr , ATid = B.sub1_id,
				 ar_id = A.jurnal_id, ar_line = A.jurnaldetil_line,
				 CEKFOREIGN =0,
				 B.sub2_id AS jurnal_contract,
				 B.sub1_id AS doc_type ,
				 isnull(jurnal_faktur,'') as InvoiceNumber
				 INTO #temp_jurnal_invoice
				 FROM transaksi_jurnaldetil A 
				  inner join transaksi_jurnal B on (A.jurnal_id = B.jurnal_id) 
				   and A.jurnaldetil_idr > 0 
				   and convert(varchar(10),B.jurnal_bookdate, 120) >= '$agingdate' 
				   and convert(varchar(10),B.jurnal_bookdate, 120) <= '$startdate' 
				   and B.jurnal_isposted = 1 
				  inner join view_master_accaging_ar C on A.acc_id = C.acc_id
				 WHERE (LEFT(A.jurnal_id,2)<> 'RF' AND LEFT(A.jurnal_id,2) <> 'CA');";
				
		$this->db->query($sp2);
		
		$sp3 = "SELECT 
				 A.jurnal_id, A.jurnaldetil_line, A.acc_id, A.region_id, A.branch_id, A.rekanan_id, A.jurnaldetil_descr, A.jurnaldetil_idr, A.jurnaldetil_foreign,
				 A.ref_id, A.rekananshipping_line, A.sub2_id,
				 B.jurnal_bookdate, B.jurnal_duedate, B.jurnal_descr, ATid = B.sub1_id, ar_id = A.ref_id, ar_line = A.ref_line,
				 CEKFOREIGN = 0,
				 B.sub2_id AS jurnal_contract,
				 B.sub1_id AS doc_type,
				 isnull(jurnal_faktur,'') as InvoiceNumber
				 INTO #temp_jurnal_pembayaran
				 FROM transaksi_jurnaldetil A 
				  inner join transaksi_jurnal B on (A.jurnal_id = B.jurnal_id) 
				   and A.jurnaldetil_idr < 0 
				   and convert(varchar(10),B.jurnal_bookdate, 120) >= '$agingdate' 
				   and convert(varchar(10),B.jurnal_bookdate, 120) <= '$startdate'
				   and B.jurnal_isposted = 1 
				  inner join view_master_accaging_ar C on A.acc_id = C.acc_id";
				
		$this->db->query($sp3);
		
		$sp4 = "
				 SELECT * INTO #temp_ORSP
				 FROM #temp_jurnal_invoice
				 UNION ALL
				 SELECT * FROM #temp_jurnal_pembayaran";
				
		$this->db->query($sp4);
		
		$sp5 = "SELECT 
				 jurnal_id = ar_id, jurnaldetil_line = ar_line, acc_id, 
				 sisa_idr=SUM(jurnaldetil_idr),
				 sisa_foreign=SUM(jurnaldetil_foreign),
				 CEKFOREIGN = SUM(CEKFOREIGN) 
				 INTO #temp_AR
				 FROM #temp_ORSP 
				 GROUP BY ar_id, ar_line, acc_id";
				
		$this->db->query($sp5);
		 
		$sp6 = "SELECT 
				 A.*, B.jurnal_bookdate, B.jurnal_duedate, B.jurnal_descr , ap_id = A.jurnal_id, ap_line = A.jurnaldetil_line,
				 CEKFOREIGN = 0,
				 jurnal_contract = B.sub2_id,
				 doc_type = B.sub1_id 
				 INTO #temp_jurnal_hutang
				 FROM transaksi_jurnaldetil A 
				  inner join transaksi_jurnal B on (A.jurnal_id = B.jurnal_id) and A.jurnaldetil_idr < 0 
				   and convert(varchar(10),B.jurnal_bookdate, 120) >= '$agingdate' 
				   and convert(varchar(10),B.jurnal_bookdate, 120) <= '$startdate'
				  and B.jurnal_isposted = 1  
				 WHERE A.acc_id in (select acc_id from master_acc where accsubgroup_id = '204');  ";
				
		$this->db->query($sp6);
		
		
		$sp7 = " SELECT 
						 A.*, B.jurnal_bookdate, B.jurnal_duedate, B.jurnal_descr, ap_id = A.ref_id, ap_line = A.ref_line,
						 CEKFOREIGN = 0,
						 jurnal_contract = B.sub2_id,
						 doc_type = B.sub1_id
						 INTO #temp_jurnal_pembayaran2
						 FROM transaksi_jurnaldetil A 
						  inner join transaksi_jurnal B on (A.jurnal_id = B.jurnal_id) and A.jurnaldetil_idr > 0 
						  and convert(varchar(10),B.jurnal_bookdate, 120) >= '$agingdate' 
						  and convert(varchar(10),B.jurnal_bookdate, 120) <= '$startdate' 
						  and B.jurnal_isposted = 1   
				 WHERE A.acc_id in (select acc_id from master_acc where accsubgroup_id = '204'); ";
				
		$this->db->query($sp7);
		 
		
		$sp8 = "SELECT * INTO #temp_APPV FROM #temp_jurnal_hutang
				 UNION
				 SELECT * FROM #temp_jurnal_pembayaran2";
				
		$this->db->query($sp8);
		 
		
		$sp9 = "SELECT 
				 jurnal_id = ap_id, jurnaldetil_line = ap_line, acc_id, 
				 sisa_idr=SUM(jurnaldetil_idr),
				 sisa_foreign=SUM(jurnaldetil_foreign),
				 CEKFOREIGN = SUM(CEKFOREIGN) 
				 INTO #temp_AP
				 FROM #temp_APPV 
				 GROUP BY ap_id, ap_line, acc_id;  ";
				
		$this->db->query($sp9); 
		
		
		$sp10 = "select #temp_AR.jurnal_id	
					,#temp_AR.jurnaldetil_idr
					,#temp_AR.jurnaldetil_idr+SUM(ISNULL((
					CASE WHEN #temp_OH.jurnal_isposted = 1 
						AND  convert(varchar(10),#temp_OH.jurnal_bookdate, 120)   >= '$agingdate' 
						AND convert(varchar(10),#temp_OH.jurnal_bookdate, 120)  <= '$startdate'  
						THEN #temp_OR.jurnaldetil_idr ELSE 0 END),0)) AS OS_idr		
				 into #temp_COR
				 from transaksi_jurnaldetil #temp_AR
					inner join #temp_AP ON #temp_AR.jurnal_id = #temp_AP.jurnal_id 
						AND #temp_AR.acc_id in (select #AG.acc_id from view_master_accaging_ar #AG)
						AND #temp_AR.jurnaldetil_idr > 0	
					left join transaksi_jurnaldetil #temp_OR ON #temp_AR.jurnal_id = #temp_OR.ref_id AND #temp_AR.jurnaldetil_line = #temp_OR.ref_line
					left join transaksi_jurnal #temp_OH ON #temp_OH.jurnal_id = #temp_OR.jurnal_id
				group by #temp_AR.jurnal_id, #temp_AR.jurnaldetil_idr;
"; 	
		$this->db->query($sp10);
		$SQL = "SELECT 
				 jurnal_id = B.jurnal_id,  
				 jurnaldetil_descr = REPLACE(REPLACE(REPLACE(B.jurnaldetil_descr,CHAR(13),''),CHAR(10),''),CHAR(9),''),
				 region_id = B.region_id,
				 region_name = C.region_name ,  
				 branch_id = B.branch_id,
				 branch_name = D.branch_name,   
				 rekanan_id = B.rekanan_id,
				 rekanan_name = E.rekanan_name,     
				 rekananshippping_line = B.rekananshipping_line ,
				 rekananshipping_name = F.rekananshipping_name ,   
				 acc_id = A.acc_id,
				 acc_name = G.acc_name,
				 jurnal_bookdate = B.jurnal_bookdate,
				 periode=convert(varchar(6),B.jurnal_bookdate,112),
				 duedate =  B.jurnal_bookdate,    
				 due = DATEDIFF(DAY, B.jurnal_bookdate,$agingdate),  
				 Invoice_Amount   = B.jurnaldetil_idr,
				 0 as settlement_idr,
				 0 as receive_idr,           
				 Aging_Amount = A.sisa_idr,  
				 ref_id = B.ref_id ,
				 faktur_id = ISNULL(CASE WHEN H.faktur_id IS NULL THEN CASE WHEN  B.ref_id <> '' THEN  B.ref_id ELSE B.jurnal_id END WHEN H.faktur_id IS NOT NULL THEN H.faktur_id  END, '0'),  
				 faktur_date = isnull(H.faktur_date, B.jurnal_bookdate),
				 deduct_type = isNULL(E.deduct, 0),  
				 contract_no = ISNULL(B.jurnal_contract, '0'), 
				 transaksi_type = sub2_id,
				 transaksi_trx = ISNULL(CASE WHEN B.sub2_id <> '0000' THEN AG.agreementtype_nameshort ELSE ISNULL(AG.agreementtype_whttype, 'WHT') END, ''), 
				 doc_type = ISNULL(B.doc_type, '0')
				 ,grouptenant_id  =ISNULL(E.grouptenant_id ,'')
				 ,B.InvoiceNumber
				 FROM 
				 #temp_AR A 
				 inner join #temp_jurnal_invoice B on A.jurnal_id = B.jurnal_id and A.jurnaldetil_line = B.jurnaldetil_line
				 LEFT JOIN master_region C on B.region_id = C.region_id
				 LEFT JOIN master_branch D on B.branch_id = D.branch_id
				 LEFT JOIN master_rekanan E on B.rekanan_id = E.rekanan_id
				 LEFT JOIN master_rekananshipping F on B.rekanan_id = F.rekanan_id AND B.rekananshipping_line = F.rekananshipping_line
				 LEFT JOIN master_acc G on B.acc_id = G.acc_id
				 LEFT JOIN transaksi_schedulepaymentdetil H ON B.jurnal_id =  H.schedulepayment_id+CAST(H.schedulepaymentdetil_line as varchar) 
				 LEFT JOIN master_agreementtype AG ON AG.agreementtype_id = B.ATid
				 WHERE
				 (A.sisa_idr>0 or A.sisa_foreign>0)
				 and sub2_id <>'0000'
				 and A.acc_id not in(
				 '1040406', 
				 '1040101', 
				 '1020199' 
				 )
				 UNION ALL
				 SELECT 
				 jurnal_id = B.jurnal_id,
				 jurnal_descr = B.jurnaldetil_descr,
				 region_id = B.region_id,
				 region_name = C.region_name,
				 branch_id = B.branch_id,
				 branch_name = D.branch_name,
				 rekanan_id = B.rekanan_id,
				 rekanan_name = E.rekanan_name,
				 B.rekananshipping_line,
				 F.rekananshipping_name,
				 acc_id = A.acc_id,
				 acc_name = G.acc_name,
				 jurnal_bookdate = B.jurnal_bookdate,
				periode=convert(varchar(6),B.jurnal_bookdate,112),
				 duedate = B.jurnal_bookdate,
				 due = DATEDIFF(DAY, B.jurnal_bookdate, $agingdate),
				 jurnaldetil_idr   = -B.jurnaldetil_idr,
				 [settlement_idr] = 0,
				 [receive_idr] = 0,
				 [amount] = -(A.sisa_idr+OS_idr), 
				 B.ref_id,
				 faktur_id = B.jurnal_id,
				 faktur_date =null,
				 deduct_type = isnull(E.deduct, 0),
				 contract_no = ISNULL(CASE WHEN B.sub1_id <> '0' THEN B.sub1_id ELSE B.jurnal_contract END, '0'),
				 transaksi_type = sub2_id,
				 transaksi_trx = ISNULL(CASE WHEN B.sub2_id <> '0000' THEN AG.agreementtype_nameshort ELSE AG.agreementtype_whttype END, 'WHT'),
				 B.doc_type
				 ,E.grouptenant_id
				 ,InvoiceNumber=''
				 FROM 
				 #temp_AP A 
				  inner join #temp_jurnal_hutang B on A.jurnal_id = B.jurnal_id and A.jurnaldetil_line = B.jurnaldetil_line
				  LEFT JOIN master_region C on B.region_id = C.region_id
				  LEFT JOIN master_branch D on B.branch_id = D.branch_id
				  LEFT JOIN master_rekanan E on B.rekanan_id = E.rekanan_id
				  LEFT JOIN master_rekananshipping F on B.rekanan_id = F.rekanan_id AND B.rekananshipping_line = F.rekananshipping_line
				  LEFT JOIN master_acc G on B.acc_id = G.acc_id
				  LEFT JOIN master_agreementtype AG ON AG.agreementtype_id = B.sub2_id
				  LEFT JOIN #temp_COR CO ON A.jurnal_id = CO.jurnal_id
				 WHERE
						(A.sisa_idr<0 or A.sisa_foreign<0) 
					AND ((A.sisa_idr+CO.OS_idr) <> 0)";
				
		$this->db->query($SQL);
		 
		
		
		$result = $this->db->query($SQL);
		// echo "<pre>";
		// echo var_dump($SQL);
		// echo "</pre>";
		
		$sq11 = "DROP TABLE #temp_jurnal_hutang
				 DROP TABLE #temp_jurnal_pembayaran2
				 DROP TABLE #temp_APPV
				 DROP TABLE #temp_AP
				 DROP TABLE #temp_COR 
				 DROP TABLE #temp_jurnal_invoice
				 DROP TABLE #temp_jurnal_pembayaran
				 DROP TABLE #temp_ORSP
				 DROP TABLE #temp_AR ";
		$this->db->query($sq11);
		
		if($result->num_rows() > 0)
		{
			return $result->result();
		}
		else
		{
			return array();
		}
		
		
		
		
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
	
   
 }