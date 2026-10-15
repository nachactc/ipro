<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_varpt extends CI_Model{
    
    function __construct(){
        parent::__construct();
		check_user_login();
		//ini_set("memory_limit","25M"); 
		ini_set("sqlsrv.ClientBufferMaxKBSize","524288");
		ini_set("pdo_sqlsrv.client_buffer_max_kb_size","524288");
    }
    

   function qry_alldatatenant($limit,$top,$sWhere,$sWhereUser){
      $qry="WITH CTE AS (
        select top $limit A.rekanan_id as rekanan_id, rekanan_name, B.branch_id,
          ROW_NUMBER() OVER (ORDER BY rekanan_name asc) as RowNumber
        from master_rekanan as A left join (select MAX(rekanan_id) as rekanan_id, MAX(branch_id) as branch_id from master_rekananshipping group by rekanan_id, branch_id ) as B
          ON A.rekanan_id = B.rekanan_id
		  inner join master_userbranch as C on B.branch_id = C.branch_id 
        $sWhere $sWhereUser)
      SELECT CTE.*
      FROM CTE
      WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();
   }

   function qry_filteredtenant($sWhere,$sWhereUser){
     $qry="select count(A.rekanan_id) as jml
     from master_rekanan as A left join (select MAX(rekanan_id) as rekanan_id, MAX(branch_id) as branch_id from master_rekananshipping group by rekanan_id, branch_id ) as B
       ON A.rekanan_id = B.rekanan_id
	   inner join master_userbranch as C on B.branch_id = C.branch_id 
           $sWhere $sWhereUser";
    return $this->db->query($qry)->row_array();

   }

   function qry_totalalltenant($sWhereUser){
     $qry="select count(A.rekanan_id) as jml
     from master_rekanan as A left join (select MAX(rekanan_id) as rekanan_id, MAX(branch_id) as branch_id from master_rekananshipping group by rekanan_id, branch_id ) as B
       ON A.rekanan_id = B.rekanan_id
	   inner join master_userbranch as C on B.branch_id = C.branch_id $sWhereUser
	   ";
    return $this->db->query($qry)->row_array();

   }
   
   function qry_alldataregion($limit,$top,$sWhere,$sWhereUser){
      $qry="WITH CTE AS (
          select top $limit A.region_id, region_name,
            ROW_NUMBER() OVER (ORDER BY A.region_id asc) as RowNumber
          from master_region as A inner join master_userregion as B on A.region_id = B.region_id           
          $sWhere $sWhereUser)
      SELECT CTE.*
      FROM CTE
      WHERE RowNumber > $top";
	  // echo $qry;
	  // exit;
     return $this->db->query($qry)->result_array();
   }

   function qry_filteredregion($sWhere,$sWhereUser){
     $qry="select count(A.region_id) as jml
          from master_region as A inner join master_userregion as B on A.region_id = B.region_id
           $sWhere $sWhereUser";
    return $this->db->query($qry)->row_array();

   }

   function qry_totalallregion($sWhereUser){
     $qry="select count(A.region_id) as jml
          from master_region as A inner join master_userregion as B on A.region_id = B.region_id $sWhereUser";
    return $this->db->query($qry)->row_array();

   }

   function qry_alldatabranch($limit,$top,$sWhere,$sWhereUser){
     $qry="WITH CTE AS (
         select top $limit A.branch_id as branch_id, branch_name, region_id,
           ROW_NUMBER() OVER (ORDER BY branch_name asc) as RowNumber
         from master_branch A
           JOIN master_regionbranch AS B ON A.branch_id = B.branch_id
		   inner join master_userbranch as C on A.branch_id = C.branch_id
         $sWhere $sWhereUser)
      SELECT CTE.*
      FROM CTE
      WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();
   }

   function qry_filteredbranch($sWhere,$sWhereUser){
     $qry="select count(A.branch_id) as jml
           from master_branch as A inner join master_regionbranch as B
           on A.branch_id = B.branch_id
		   inner join master_userbranch as C on A.branch_id = C.branch_id
           $sWhere $sWhereUser";
    return $this->db->query($qry)->row_array();

   }

   function qry_totalallbranch($sWhereUser){
     $qry="select count(A.branch_id) as jml
     from master_branch as A inner join master_regionbranch as B
     on A.branch_id = B.branch_id
	 inner join master_userbranch as C on A.branch_id = C.branch_id $sWhereUser
          ";
    return $this->db->query($qry)->row_array();

   }

   function qry_alldatabrand($limit,$top,$sWhere,$sWhereUser){
      $qry="WITH CTE AS (
          select top $limit rekananshipping_line, rekananshipping_name, rekanan_id,rekananshipping_namereport,rekananshipping_address,rekananshipping_contactname,rekananshipping_contacthp,rekananshipping_contacttelp,
		  rekananshipping_contactemail,rowid,rekananshipping_type, A.branch_id,
            ROW_NUMBER() OVER (ORDER BY rekananshipping_line asc) as RowNumber
          from master_rekananshipping as A inner join master_userbranch as B on A.branch_id = B.branch_id 
          $sWhere $sWhereUser)
      SELECT CTE.*
      FROM CTE
      WHERE RowNumber > $top";
	  // echo $qry;
	  // exit;
     return $this->db->query($qry)->result_array();
   }

   function qry_filteredbrand($sWhere,$sWhereUser){
     $qry="select count(rekananshipping_line) as jml
          from master_rekananshipping  as A inner join master_userbranch as B on A.branch_id = B.branch_id 
           $sWhere $sWhereUser";
    return $this->db->query($qry)->row_array();

   }

   function qry_totalallbrand($sWhereUser){
     $qry="select count(rekananshipping_line) as jml
          from master_rekananshipping  as A inner join master_userbranch as B on A.branch_id = B.branch_id 
		  $sWhereUser";
    return $this->db->query($qry)->row_array();

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
   
function get_reportOutStanding($sWhere,$startdate,$enddate,$paymentdate){
		
		$timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);	
		
		// echo $sWhere;
		// exit;
		if ($sWhere ==''){
			//$startdate = $now;
			$startdate =$now;
			$enddate = $now;
			$paymentdate = $now;
			$sWhere = " branch_id = ''0000150'' and  transaksi_type <> ''0000'' ";
		}
		else{
			$startdate ='2000-01-01';
			$enddate = $enddate;
			$paymentdate = $enddate;
		}		
		$sWhere = str_replace('WHERE', '', $sWhere);
		$sWhere = str_replace("'%", "''%", $sWhere);
		$sWhere = str_replace("%'", "%''", $sWhere);
		//$sWhere = empty($sWhere) ? " branch_id = ''0000150'' and  transaksi_type <> ''0000'' " : $sWhere." AND  branch_id = ''0000150'' and transaksi_type <> ''0000'' ";
		$SP_SQL = "EXEC cp_RptReceivable_Fin_byhenhen '$enddate','$startdate','$paymentdate','$sWhere'";
		//echo var_dump($SP_SQL);
		//exit;
		//echo $SP_SQL;
		$result = $this->db->query($SP_SQL);
		//$temp = $result->result();\
		//echo $SP_SQL;
		// echo var_dump($result->result());
		// exit;
		
		//echo var_dump($result->result());exit;
		// echo var_dump($SP_SQL);exit;
		// if($result->num_rows() > 0)
		// {
			return $result->result();
		// }
		// else
		// {
			// return 'kosong';
		// }
	   
   }
   
   function qry_alldataaging($limit,$top,$sWhere,$orderBy,$startdate,$enddate,$paymentdate){
		
		$timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);	
		
		// $startdate ='2019-11-20';
		// $agingdate ='2019-05-01';
		// $paymentdate ='2019-11-20';
		//$sWhere ='XXX';
		if ($sWhere ==''){
			//$startdate = $now;
			$startdate =$now;
			$enddate = $now;
			$paymentdate = $now;
			$sWhere = " branch_id = ''0000150'' and  transaksi_type <> ''0000'' ";
			
			$startdate ='2000-01-01';
			//$sWhere = "region_id LIKE '%030%' AND branch_id LIKE '%0000150%' AND #TEMP_Summary.rekanan_id LIKE '%1050259%' AND #TEMP_Summary.rekananshipping_line LIKE '%10%'";
			//$sWhere = "region_id LIKE '%030%' AND branch_id LIKE '%0000321%' AND #TEMP_Summary.rekanan_id LIKE '%1051491%'";
		}
		else{
			$startdate ='2000-01-01';
			$enddate = $enddate;
			$paymentdate = $enddate;
		}
		// echo $sWhere;
		// exit;
		$sWhere = str_replace('WHERE', '', $sWhere);
		$sWhere = str_replace("'%", "''%", $sWhere);
		$sWhere = str_replace("%'", "%''", $sWhere);
		$sWhere = str_replace("startdate", "jurnal_id", $sWhere);
		$sWhere = str_replace("enddate", "jurnal_id", $sWhere);
		$sWhere = str_replace("paymentdate", "jurnal_id", $sWhere);
		$sWhere = $sWhere . ' and due >= 35';
		
		//echo $sWhere;
		//$sWhere = empty($sWhere) ? " branch_id = ''0000150'' and  transaksi_type <> ''0000'' " : $sWhere." AND  branch_id = ''0000150'' and transaksi_type <> ''0000'' ";
		$SP_SQL = "EXEC cp_RptReceivable_Fin_byhenhen '$enddate','$startdate','$paymentdate','$sWhere'";
		//echo var_dump($SP_SQL);		//exit;
		//echo $SP_SQL;
		$result = $this->db->query($SP_SQL);
		//$temp = $result->result();\
		//echo $SP_SQL;
		// echo var_dump($result->result());
		// exit;
		
		//echo var_dump($result->result());exit;
		// echo var_dump($SP_SQL);exit;
		// if($result->num_rows() > 0)
		// {
			return $result->result_array();
		// }
		// else
		// {
			// return 'kosong';
		// }
	   
   }
   
   function qry_filteredaging($sWhere){
	   $sWhere = empty($sWhere) ? " WHERE unit_state <> 3 " : $sWhere." AND unit_state <> 3";    
	   
	   $qry="select count(unit_id) as jml from master_unit";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalallaging(){
	   $qry="select count(unit_id) as jml from master_unit where unit_state<>3";
		return $this->db->query($qry)->row_array();
	   
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
		$agingdate ='2000-01-01';
		$SP_SQL = "EXEC cp_RptReceivable_Fin '$startdate','$agingdate','$paymentdate','$criteria'";
		//echo var_dump($SP_SQL);
		//exit;
		$result = $this->db->query($SP_SQL);
		//$temp = $result->result();\
		// echo $SP_SQL;
		// echo var_dump($result->result());
		// exit;
		
		//echo var_dump($result->result());exit;
		// echo var_dump($SP_SQL);exit;
		if($result->num_rows() > 0)
		{
			return $result->result();
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

   function get_transaksi_jurnal($id){
     $qry="select * from transaksi_jurnal where jurnal_id = '$id'";
	 //echo $qry;
    return $this->db->query($qry)->row_array();
     
   }
   
  function getscheduledetil($id){
    $sql="select * from transaksi_schedulepaymentdetil
    where schedulepayment_id + convert(nvarchar(10),schedulepaymentdetil_line) ='$id'"; 
    return $this->db->query($sql)->row_array(); 
  }     

  function getagreement($id){
    $sql="select agreement_id, agreement_loonumber from transaksi_agreement
    where agreement_id='$id'
	union all
	select agreement_id, agreement_loonumber from transaksi_agreementtemp
    where agreement_id='$id'
	"; 
    return $this->db->query($sql)->row_array(); 
  } 
  function getagreement_bycontract($id){
    $sql="select top 1 agreement_id, agreement_loonumber from transaksi_agreement
    where agreement_contractno='$id'  
	union all
	select top 1 agreement_id, agreement_loonumber from transaksi_agreementtemp
    where agreement_contractno='$id'  order by agreement_id desc
	"; 
    return $this->db->query($sql)->row_array(); 
  }  
  function getagreementdetil_shopunit($id){
    $sql="select top 1 agreement_id, agreementdetil_unit from transaksi_agreementdetil
    where agreement_id='$id'
	union all
	select top 1 agreement_id, agreementdetil_unit from transaksi_agreementtempdetil
    where agreement_id='$id'
	"; 
    return $this->db->query($sql)->row_array(); 
  }  
   function qry_getbranchshort($loid){
	   $qry="select b.branch_nameshort from transaksi_loo a inner join master_branch b 
	on a.branch_id=b.branch_id WHERE loo_id='$loid'";
		return $this->db->query($qry)->row_array();  
   }
  function get_laedit($id){
	 	$qry="select * from master_laconfig where loo_id='$id'";
	 	return $this->db->query($qry)->row_array();	   
   }   
   function get_totalOT($where){
	$timestamp = time();
    $now = date("Y-m-d H:i:s", $timestamp);	
	$agingdate ='2000-01-01';
	   $qry="exec cp_RptReceivable_Fin_TotalOT '$now','$agingdate','$now','$where'";
	   // echo $qry;
	   // exit;
		return $this->db->query($qry)->row_array();  
   }   
  function getmastersetting($id){
    $sql="select * from master_setting
    where setting_id='$id'"; 
    return $this->db->query($sql)->row_array(); 
  }
 function getmasterregion($id){
  $sql="select * from master_region
  where region_id='$id' ";
  return $this->db->query($sql)->row_array();
 }
  function get_nosp($jurnal_id,$jurnal_descr,$region_id,$branch_id,$rekanan_id,$rekananshipping_line,$SP,$enddate){
	 	$qry="exec lm03_rpt_get_noSP '$jurnal_id','$jurnal_descr','$region_id','$branch_id','$rekanan_id','$rekananshipping_line','$SP','$enddate'";
	 	//echo $qry;
		return $this->db->query($qry)->row_array();	   
   }  
  function getsp1sp2($jurnal_id,$jurnal_descr,$region_id,$branch_id,$rekanan_id,$rekananshipping_line,$SP){
	 	$qry="exec lm03_rpt_get_noSP1SP2 '$jurnal_id','$jurnal_descr','$region_id','$branch_id','$rekanan_id','$rekananshipping_line','$SP'";
	 	//echo $qry;
		$result = $this->db->query($qry);
		return $result->result();  
   }   
  function getusersp($id){
    $sql="select * from master_usersp
    where username='$id'"; 
    return $this->db->query($sql)->row_array(); 
  }   
  function getmasterrekananshipping($id,$line){
    $sql="select * from master_rekananshipping
    where rekanan_id='$id' and rekananshipping_line = $line"; 
    return $this->db->query($sql)->row_array(); 
  }  
  function getmasterrekanan($id){
    $sql="select * from master_rekanan
    where rekanan_id='$id'"; 
    return $this->db->query($sql)->row_array(); 
  }   
 function getmasterbranch($id){
  $sql="select * from master_branch
  where branch_id='$id' ";
  return $this->db->query($sql)->row_array();
 }  
 }