<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_invoice extends CI_Model{

    function __construct(){
        parent::__construct();
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
    //print_r($qry);
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
          select top $limit SHIP.rekanan_id, SHIP.rekananshipping_line, SHIP.rekananshipping_name, REKA.rekanan_name, SHIP.rowid AS debtor_no,
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

   function qry_alldataregion($limit,$top,$sWhere,$sWhereUser){
      $qry="WITH CTE AS (
          select top $limit A.region_id, region_name,
            ROW_NUMBER() OVER (ORDER BY A.region_id asc) as RowNumber
          from master_region as A inner join master_userregion as B on A.region_id = B.region_id           
          $sWhere $sWhereUser)
      SELECT CTE.*
      FROM CTE
      WHERE RowNumber > $top";
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
	  // echo $qry; exit;
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
          select top $limit rekananshipping_line, rekananshipping_name, rekanan_id,
            ROW_NUMBER() OVER (ORDER BY rekananshipping_line asc) as RowNumber
          from master_rekananshipping as A inner join master_userbranch as B on A.branch_id = B.branch_id 
          $sWhere $sWhereUser)
      SELECT CTE.*
      FROM CTE
      WHERE RowNumber > $top";
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

   function qry_alldataagrtype($limit,$top,$sWhere){
      $qry="WITH CTE AS (
          select top $limit agreementtype_id, agreementtype_name,
            ROW_NUMBER() OVER (ORDER BY agreementtype_name asc) as RowNumber
          from master_agreementtype
          $sWhere )
      SELECT CTE.*
      FROM CTE
      WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();
   }

   function qry_filteredagrtype($sWhere){
     $qry="select count(agreementtype_id) as jml
          from master_agreementtype
           $sWhere";
    return $this->db->query($qry)->row_array();

   }

   function qry_totalallagrtype(){
     $qry="select count(agreementtype_id) as jml
          from master_agreementtype";
    return $this->db->query($qry)->row_array();

   }
   
   function qry_alldataaging($limit,$top,$sWhere){
	$aging_dp = $this->db->query("select * from master_setting where setting_id like '%acc_id_cn_dp%'")->result_array();
	$aging_deposit = $this->db->query("select * from master_setting where setting_id like '%acc_id_cn_deposit%'")->result_array();
     
	$acc_id ="";
	 foreach ($aging_dp as $aRow) {
		if ($acc_id =="") {
			$acc_id = "'" ."'" . $aRow['setting_value'] . "'" ."'";
		}
		else {
			$acc_id= $acc_id  . "," . "'" ."'" . $aRow['setting_value'] . "'" ."'";
		}
	 }
	 foreach ($aging_deposit as $aRow) {
		if ($acc_id =="") {
			$acc_id = "'" ."'" . $aRow['setting_value'] . "'" ."'";
		}
		else {
			$acc_id= $acc_id  . ",". "'" ."'" . $aRow['setting_value'] . "'" ."'";
		}
	 } 
	if ($sWhere =='')
	{
		$sWhere =" and acc_id in (" .  $acc_id . ")";
	}
	else
	{
		$sWhere = str_replace('WHERE', 'and', $sWhere);
		$sWhere = str_replace("'%", "''%", $sWhere);
		$sWhere = str_replace("%'", "%''", $sWhere);
		//$sWhere = str_replace('%', '''%', $sWhere);
		$sWhere =$sWhere . " and acc_id in (" . $acc_id . ")";
	}
    $stored_pocedure = "EXEC cp_TrnJurnalORTRP_SelectInvoiceSingle_ipro '','rekanan_id in (select rekanan_id from master_rekanan)', '$sWhere' ";
    // echo $stored_pocedure; exit;
	$result = $this->db->query($stored_pocedure);

  return $result->result_array();
  
   }

   function qry_filteredaging($sWhere){
     $qry="select top 1 1 as jml
          from transaksi_jurnal";
    return $this->db->query($qry)->row_array();

   }

   function qry_totalallaging(){
     $qry="select count(jurnal_id) as jml
          from transaksi_jurnal";
    return $this->db->query($qry)->row_array();

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

    function qry_alldatalist($limit,$top,$sWhere,$sWhereUser){
	// echo var_dump($sWhere);
     // $sWhere = empty($sWhere) ? " WHERE  schedulepaymentdetil_isdisabled ='0' " : $sWhere."  and schedulepaymentdetil_isdisabled ='0' ";
	// echo '$limit : ' . $limit . ' $top : ' . $top . ' $sWhere : ' . $sWhere;
	// exit;
	   $qry="
     SELECT * FROM (
     select top $limit B.region_id, CTE.*,ROW_NUMBER() OVER (ORDER BY REKAN.rekanan_name ASC) as RowNumber,
              REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, agreementtype_name, agreementtype_nameshort, agreementtype_printouttype, B.branch_id, B.rekanan_id, B.channel_id,
              CONVERT(VARCHAR, schedulepaymentdetil_date, 112) as detildate, CONVERT(VARCHAR, schedulepaymentdetil_posteddate, 112) as postdate, B.rekananshipping_line,
			schedulepaymentdetil_duedate  as  duedate,
			schedulepaymentdetil_duedate  as  duedate2
			
       FROM transaksi_schedulepaymentdetil AS CTE
         inner join Transaksi_schedulepayment B on CTE.Schedulepayment_id=B.schedulepayment_id
         left join master_rekanan REKAN on B.rekanan_id=REKAN.rekanan_id
         left join master_rekananshipping BRAND on B.rekanan_id=BRAND.rekanan_id AND B.rekananshipping_line=BRAND.rekananshipping_line         
         left join Transaksi_agreement E on CTE.ref_id= E.agreement_id
         left join master_agreementtype F on CTE.agreementtype_id = F.agreementtype_id
         left join transaksi_jurnal G on CTE.schedulepayment_id + convert(varchar(10),CTE.schedulepaymentdetil_line) = g.jurnal_id
         inner join master_branch as BRANCH on BRANCH.branch_id = B.branch_id
         inner join master_region as REGION on REGION.region_id = B.region_id
		 inner join master_userbranch as USERBRANCH on BRANCH.branch_id = USERBRANCH.branch_id
			  $sWhere $sWhereUser
			  ORDER BY REKAN.rekanan_name ASC
			  ) AS V
    	WHERE   RowNumber > $top";

	     //var_dump($qry);
	     //exit;
	   return $this->db->query($qry)->result_array();
   }
   
   function qry_alldatalist_tcp($limit,$top,$sWhere,$sWhereUser){
	// echo var_dump($sWhere);
     // $sWhere = empty($sWhere) ? " WHERE  schedulepaymentdetil_isdisabled ='0' " : $sWhere."  and schedulepaymentdetil_isdisabled ='0' ";
	// echo '$limit : ' . $limit . ' $top : ' . $top . ' $sWhere : ' . $sWhere;
	// exit;
	   $qry="
     SELECT * FROM (
     select top $limit B.region_id, CTE.*,ROW_NUMBER() OVER (ORDER BY REKAN.rekanan_name) as RowNumber,
              REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, agreementtype_name, agreementtype_nameshort, agreementtype_printouttype, B.branch_id, B.rekanan_id, B.channel_id,
              CONVERT(VARCHAR, schedulepaymentdetil_date, 112) as detildate, CONVERT(VARCHAR, schedulepaymentdetil_posteddate, 112) as postdate, B.rekananshipping_line,
			schedulepaymentdetil_duedate  as  duedate,
			schedulepaymentdetil_duedate  as  duedate2
			
       FROM transaksi_schedulepaymentdetil AS CTE
         inner join Transaksi_schedulepayment B on CTE.Schedulepayment_id=B.schedulepayment_id
         left join master_rekanan REKAN on B.rekanan_id=REKAN.rekanan_id
         left join master_rekananshipping BRAND on B.rekanan_id=BRAND.rekanan_id AND B.rekananshipping_line=BRAND.rekananshipping_line         
         left join Transaksi_agreement E on CTE.ref_id= E.agreement_id
         left join master_agreementtype F on CTE.agreementtype_id = F.agreementtype_id
         left join transaksi_jurnal G on CTE.schedulepayment_id + convert(varchar(10),CTE.schedulepaymentdetil_line) = g.jurnal_id
         inner join master_branch as BRANCH on BRANCH.branch_id = B.branch_id
         inner join master_region as REGION on REGION.region_id = B.region_id
		 inner join master_userbranch as USERBRANCH on BRANCH.branch_id = USERBRANCH.branch_id
			  $sWhere $sWhereUser and faktur_id is not null and agreementtype_type <>'DEPOSIT'
	union all
	
	 select top $limit B.region_id, CTE.*,ROW_NUMBER() OVER (ORDER BY REKAN.rekanan_name) as RowNumber,
              REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, agreementtype_name, agreementtype_nameshort, agreementtype_printouttype, B.branch_id, B.rekanan_id, B.channel_id,
              CONVERT(VARCHAR, schedulepaymentdetil_date, 112) as detildate, CONVERT(VARCHAR, schedulepaymentdetil_posteddate, 112) as postdate, B.rekananshipping_line, schedulepaymentdetil_duedate  as  duedate,
			schedulepaymentdetil_duedate  as  duedate2
			
       FROM transaksi_schedulepaymentdetil AS CTE
         inner join Transaksi_schedulepayment B on CTE.Schedulepayment_id=B.schedulepayment_id
         left join master_rekanan REKAN on B.rekanan_id=REKAN.rekanan_id
         left join master_rekananshipping BRAND on B.rekanan_id=BRAND.rekanan_id AND B.rekananshipping_line=BRAND.rekananshipping_line         
         left join Transaksi_agreement E on CTE.ref_id= E.agreement_id
         left join master_agreementtype F on CTE.agreementtype_id = F.agreementtype_id
         left join transaksi_jurnal G on CTE.schedulepayment_id + convert(varchar(10),CTE.schedulepaymentdetil_line) = g.jurnal_id
         inner join master_branch as BRANCH on BRANCH.branch_id = B.branch_id
         inner join master_region as REGION on REGION.region_id = B.region_id
		 inner join master_userbranch as USERBRANCH on BRANCH.branch_id = USERBRANCH.branch_id
			  $sWhere $sWhereUser and agreementtype_type ='DEPOSIT'
		
			  ORDER BY REKAN.rekanan_name
			  ) AS V
    	WHERE   RowNumber > $top";

	    // echo $qry;
	    // exit;
	   return $this->db->query($qry)->result_array();
   }
   
	function qry_alldatalist2($limit,$top,$sWhere,$sWhereUser){
	// echo var_dump($sWhere);
     // $sWhere = empty($sWhere) ? " WHERE  schedulepaymentdetil_isdisabled ='0' " : $sWhere."  and schedulepaymentdetil_isdisabled ='0' ";
	// echo '$limit : ' . $limit . ' $top : ' . $top . ' $sWhere : ' . $sWhere;
	// exit;
	   $qry="
     SELECT * FROM (
     select top 1000 B.region_id, CTE.*,ROW_NUMBER() OVER(Partition by CTE.schedulepayment_id, agreementtype_name ORDER BY REKAN.rekanan_name, CTE.schedulepayment_id, schedulepaymentdetil_line, CTE.agreementtype_id) AS Row_Number,
              REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, agreementtype_name, agreementtype_nameshort, agreementtype_printouttype, B.branch_id, B.rekanan_id, B.channel_id,
              CONVERT(VARCHAR, schedulepaymentdetil_date, 112) as detildate, CONVERT(VARCHAR, schedulepaymentdetil_posteddate, 112) as postdate, B.rekananshipping_line,
			schedulepaymentdetil_duedate as  duedate, schedulepaymentdetil_duedate as  duedate2			
       FROM transaksi_schedulepaymentdetil AS CTE
         inner join Transaksi_schedulepayment B on CTE.Schedulepayment_id=B.schedulepayment_id
         left join master_rekanan REKAN on B.rekanan_id=REKAN.rekanan_id
         left join master_rekananshipping BRAND on B.rekanan_id=BRAND.rekanan_id AND B.rekananshipping_line=BRAND.rekananshipping_line         
         left join Transaksi_agreement E on CTE.ref_id= E.agreement_id
         left join master_agreementtype F on CTE.agreementtype_id = F.agreementtype_id
         left join transaksi_jurnal G on CTE.schedulepayment_id + convert(varchar(10),CTE.schedulepaymentdetil_line) = g.jurnal_id
         inner join master_branch as BRANCH on BRANCH.branch_id = B.branch_id
         inner join master_region as REGION on REGION.region_id = B.region_id
		 inner join master_userbranch as USERBRANCH on BRANCH.branch_id = USERBRANCH.branch_id
			  $sWhere $sWhereUser		 			  			  
			  ) AS V
    	WHERE   Row_Number > $top  and Row_Number in ('1','2')
		ORDER by rekanan_name,  Schedulepayment_id,  Schedulepaymentdetil_line, agreementtype_id
		";

	    // echo $qry;
	    // exit;
	   return $this->db->query($qry)->result_array();
   }
    function qry_filteredlist($sWhere,$sWhereUser){
       // $sWhere = empty($sWhere) ? " WHERE  schedulepaymentdetil_isdisabled ='0' " : $sWhere."  and schedulepaymentdetil_isdisabled ='0' ";
	   $qry="SELECT count(*) as jml FROM (
			select CTE.*,ROW_NUMBER() OVER (ORDER BY BRAND.rekananshipping_name asc) as RowNumber,
						   REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, F.agreementtype_printouttype, B.region_id, B.branch_id, B.rekanan_id
               FROM transaksi_schedulepaymentdetil AS CTE
       					inner join Transaksi_schedulepayment B on CTE.Schedulepayment_id=B.schedulepayment_id
       					left join master_rekanan REKAN on B.rekanan_id=REKAN.rekanan_id
       					left join master_rekananshipping BRAND on B.rekanan_id=BRAND.rekanan_id AND B.rekananshipping_line=BRAND.rekananshipping_line       					
       					left join Transaksi_agreement E on CTE.ref_id= E.agreement_id
       					left join master_agreementtype F on CTE.agreementtype_id = F.agreementtype_id
       					left join transaksi_jurnal G on CTE.schedulepayment_id + convert(varchar(10),CTE.schedulepaymentdetil_line) = g.jurnal_id
       					inner join master_branch as BRANCH on BRANCH.branch_id = B.branch_id
       					inner join master_region as REGION on REGION.region_id = B.region_id
						inner join master_userbranch as USERBRANCH on BRANCH.branch_id = USERBRANCH.branch_id
			  $sWhere $sWhereUser

			  ) AS V";
			  
	return $this->db->query($qry)->row_array();

   }
    function qry_filteredlist_tcp($sWhere,$sWhereUser){
       // $sWhere = empty($sWhere) ? " WHERE  schedulepaymentdetil_isdisabled ='0' " : $sWhere."  and schedulepaymentdetil_isdisabled ='0' ";
	   $qry="SELECT count(*) as jml FROM (
			select CTE.*,ROW_NUMBER() OVER (ORDER BY CTE.schedulepayment_id desc) as RowNumber,
						   REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, F.agreementtype_printouttype, B.region_id, B.branch_id, B.rekanan_id
               FROM transaksi_schedulepaymentdetil AS CTE
       					inner join Transaksi_schedulepayment B on CTE.Schedulepayment_id=B.schedulepayment_id
       					left join master_rekanan REKAN on B.rekanan_id=REKAN.rekanan_id
       					left join master_rekananshipping BRAND on B.rekanan_id=BRAND.rekanan_id AND B.rekananshipping_line=BRAND.rekananshipping_line       					
       					left join Transaksi_agreement E on CTE.ref_id= E.agreement_id
       					left join master_agreementtype F on CTE.agreementtype_id = F.agreementtype_id
       					left join transaksi_jurnal G on CTE.schedulepayment_id + convert(varchar(10),CTE.schedulepaymentdetil_line) = g.jurnal_id
       					inner join master_branch as BRANCH on BRANCH.branch_id = B.branch_id
       					inner join master_region as REGION on REGION.region_id = B.region_id
						inner join master_userbranch as USERBRANCH on BRANCH.branch_id = USERBRANCH.branch_id
			  $sWhere $sWhereUser

			  ) AS V";
			  
	return $this->db->query($qry)->row_array();

   }
    function qry_filteredlist2($sWhere,$sWhereUser){
       // $sWhere = empty($sWhere) ? " WHERE  schedulepaymentdetil_isdisabled ='0' " : $sWhere."  and schedulepaymentdetil_isdisabled ='0' ";
	   $qry="SELECT count(*) as jml FROM (
			select CTE.*,ROW_NUMBER() OVER (ORDER BY CTE.schedulepayment_id desc) as RowNumber,
						   REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, F.agreementtype_printouttype, B.region_id, B.branch_id, B.rekanan_id
               FROM transaksi_schedulepaymentdetil AS CTE
       					inner join Transaksi_schedulepayment B on CTE.Schedulepayment_id=B.schedulepayment_id
       					left join master_rekanan REKAN on B.rekanan_id=REKAN.rekanan_id
       					left join master_rekananshipping BRAND on B.rekanan_id=BRAND.rekanan_id AND B.rekananshipping_line=BRAND.rekananshipping_line       					
       					left join Transaksi_agreement E on CTE.ref_id= E.agreement_id
       					left join master_agreementtype F on CTE.agreementtype_id = F.agreementtype_id
       					left join transaksi_jurnal G on CTE.schedulepayment_id + convert(varchar(10),CTE.schedulepaymentdetil_line) = g.jurnal_id
       					inner join master_branch as BRANCH on BRANCH.branch_id = B.branch_id
       					inner join master_region as REGION on REGION.region_id = B.region_id
						inner join master_userbranch as USERBRANCH on BRANCH.branch_id = USERBRANCH.branch_id
			  $sWhere $sWhereUser

			  ) AS V";
			  
return $this->db->query($qry)->row_array();

   }
   function qry_totalalllist($sWhereUser){
	   $qry="select count(Schedulepayment_id) as jml from transaksi_schedulepaymentdetil 
	   where  schedulepaymentdetil_isdisabled ='0' 	   
	   ";
		// echo $qry;
		// exit();
		return $this->db->query($qry)->row_array();

   }
   function qry_totalalllist_tcp($sWhereUser){
	   $qry="select count(Schedulepayment_id) as jml from transaksi_schedulepaymentdetil 
	   where  schedulepaymentdetil_isdisabled ='0' 	   
	   ";
		// echo $qry;
		// exit();
		return $this->db->query($qry)->row_array();

   }   
   function qry_totalalllist2($sWhereUser){
	   $qry="select count(Schedulepayment_id) as jml from transaksi_schedulepaymentdetil 
	   where  schedulepaymentdetil_isdisabled ='0' 	   
	   ";
		// echo $qry;
		// exit();
		return $this->db->query($qry)->row_array();

   }
   function get_BOID($id, $line, $agrtype, $region_id, $region_nameshort, $channel_id)
   {

       $timestamp = time();
       $bo_id = gen_id_boid($channel_id,'LB','sequencer_propertymanagement', $region_id, $timestamp, $agrtype, $region_nameshort);
       //$bo_id = gen_id_invid($channel_id,'IN','sequencer_propertymanagement', $region_id, $timestamp, $agrtype, $region_nameshort);

       $timestamp = time();
       $now = date("Y-m-d H:i:s", $timestamp);


     return $bo_id;

   }

   public function get_INVID($criteria,$channel_id, $branch_id, $agreementtype_id, $bo_id, $proforma_date,$proforma_by)
    {
    $stored_pocedure = "EXEC lm03_TrnSchedulepaymentdetil_Checked '$criteria','$channel_id','$branch_id','$agreementtype_id','$bo_id','$proforma_date','$proforma_by'";
    $result = $this->db->query($stored_pocedure);
    return $result->result();
    }

   public function get_cancel_invoice($bo_id,$schedulepayment_id, $schedulepaymentdetil_line, $username, $isposted, $reason)
    {
    $stored_pocedure = "EXEC lm03_TrnSchedulepaymentdetil_UncheckBO '$bo_id','$schedulepayment_id','$schedulepaymentdetil_line','$username','$isposted','$reason'";
    $result = $this->db->query($stored_pocedure);
    return $result->result();
    }
   public function get_invoice_approved($schedulepayment_id, $schedulepaymentdetil_line, $username, $isposted, $post_date, $reason)
    {
    $stored_pocedure = "EXEC lm03_TrnSchedulepaymentdetil_Approved '$schedulepayment_id','$schedulepaymentdetil_line','$username','$isposted','$post_date','$reason'";
    $result = $this->db->query($stored_pocedure);
    return $result->result();
    }
	
   public function get_cn_posting($schedulepayment_id, $schedulepaymentdetil_line, $username, $isposted, $post_date, $jurnal_id,$jurnaldetil_line,$reason, $cntype, $taxtype)
    {
    $stored_pocedure = "EXEC lm03_TrnSchedulepaymentdetil_CN_posted '$schedulepayment_id','$schedulepaymentdetil_line','$username','$isposted','$post_date','$jurnal_id','$jurnaldetil_line','$reason','$cntype', '$taxtype'";
    $result = $this->db->query($stored_pocedure);
    return $result->result();
    }
   public function invoice_otomatis($schedulepayment_id, $schedulepaymentdetil_line, $button)
    {
	   $timestamp = time();
       $now = date("Y-m-d H:i:s", $timestamp);
	   // echo $button;
	   // exit;
		if ($button=='GENERATE INV MANUAL'){
			$stored_pocedure = "EXEC lm03_TrnSchedulepaymentdetil_Create_INV_Manual '$schedulepayment_id','$schedulepaymentdetil_line','$now'";
		}
		elseif ($button=='OTOMATIS INV'){
			$stored_pocedure = "EXEC lm03_TrnSchedulepaymentdetil_Create_INV_Otomatis";
		}
		elseif ($button=='OTOMATIS UTILITIES INV'){
			$stored_pocedure = "EXEC lm03_TrnSchedulepaymentdetil_Create_INV_Otomatis_Utilities";
		}	
		elseif ($button=='OTOMATIS POSTING'){
			$stored_pocedure = "EXEC lm03_TrnSchedulepaymentdetil_Posting_INV_Otomatis";
		}		
		else {
			$stored_pocedure = "EXEC lm03_TrnSchedulepaymentdetil_Create_INV_Otomatis";
		}
	
	// echo $stored_pocedure;
    $result = $this->db->query($stored_pocedure);
    return $result->result();
    }	
   public function get_cn_posting_tes_error($schedulepayment_id, $schedulepaymentdetil_line, $post_date)
    {
    $stored_pocedure = "EXEC lm03_TrnSchedulepaymentdetil_CN_posted_tes_error '$schedulepayment_id','$schedulepaymentdetil_line','$post_date'";
    $result = $this->db->query($stored_pocedure);
    return $result->result_array();
    }	
	
   function posting_cn($arrapp, $username, $channel_id, $posted){   

      $action = "posting";

       if (is_array($arrapp)){
         if (count($arrapp) >0){
            foreach ($arrapp as $key){             

              $schedulepayment_id    = $key['id'];
              $schedulepaymentdetil_line   = $key['line'];
			  $posteddate   = $key['posteddate'];
			  $jurnal_id = $key['jurnal_id'];
			  $jurnaldetil_line = '0';
			  $reason ='';
			  $cntype =$key['cntype'];
			  $taxtype ='0';
			  $iagrtype =$key['iagrtype'];
			  
			  if ($iagrtype == '7200')
			  {
				  $taxtype ='0';
			  }

			//echo 'bug> $schedulepayment_id : ' . $schedulepayment_id . ' - $schedulepaymentdetil_line : ' . $schedulepaymentdetil_line . ' - $posteddate : ' . $posteddate . ' - $jurnal_id : ' . $jurnal_id . ' - $jurnaldetil_line : ' . $jurnaldetil_line . ' - $reason: ' . $reason . ' - $cntype: ' . $cntype . ' - $taxtype: ' . $taxtype;
			//exit;
              $this->db->trans_begin();

              $posting = "EXEC [lm03_TrnSchedulepaymentdetil_CN_posted] '$schedulepayment_id','$schedulepaymentdetil_line','$username','$posted','$posteddate','$jurnal_id','$jurnaldetil_line','$reason','$cntype', '$taxtype'";
              // $posting = "UPDATE transaksi_utilitieslistrikdetil 
                          // SET utilitieslistrikdetil_ischecked = $posted
                          // WHERE utilitieslistrik_id = '{$_id}' AND utilitieslistrikdetil_line = {$line}";
              $this->db->query($posting);           

              if ($this->db->trans_status() === FALSE)
              {               
                  //generate an error... or use the log_message() function to log your error                  
                  $this->db->trans_rollback();                  
                  return false;
              }else{
                  $this->db->trans_commit();                  
              }
            }
            return true;  
         }
      }
    }  
	
   public function get_cek_or($schedulepayment_id, $schedulepaymentdetil_line)
    {
    $stored_pocedure = "EXEC lm03_TrnSchedulepaymentdetil_Cek_OR '$schedulepayment_id','$schedulepaymentdetil_line'";
    $result = $this->db->query($stored_pocedure);
    return $result->row_array();
    }
	
   public function get_exec_sp($sp)
    {
    //$stored_pocedure = "EXEC lm03_RptSchedulePayment_SelectPrintForm_byFakturID '$invoice_id', '$schedulepayment_id','1'";
    //echo $stored_pocedure; exit;
	$result = $this->db->query($sp);
    return $result->result();
    }	
	
   public function get_invoice_approved_new($schedulepayment_id, $schedulepaymentdetil_line, $username, $isposted, $post_date, $reason)
    {
	
            $this->db->trans_begin();

            $ag_posting = "EXEC lm03_TrnSchedulepaymentdetil_Approved '{$schedulepayment_id}', '{$schedulepaymentdetil_line}', '{$username}', '{$isposted}', '{$post_date}','{$reason}'";
            $this->db->query($ag_posting);    
            //echo $this->db->last_query(); exit;

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

   public function get_invoice_enable($schedulepayment_id, $schedulepaymentdetil_line, $username, $isposted, $post_date, $reason)
    {
	
            $this->db->trans_begin();

            $ag_posting = "update transaksi_schedulepaymentdetil set schedulepaymentdetil_isdisabled = 0 where schedulepayment_id = '$schedulepayment_id' and schedulepaymentdetil_line = '$schedulepaymentdetil_line'";
            $this->db->query($ag_posting);    
            //echo $this->db->last_query(); exit;

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
   public function get_update_postdate($schedulepayment_id, $schedulepaymentdetil_line, $username, $isposted, $post_date, $reason, $periode)
    {
	// $thn=date('Y',strtotime($post_date));
	// $bln=date('M',strtotime($post_date));
	// $periode = substr($thn,2,2) . $bln;
	// echo $post_date; exit;
	
            $this->db->trans_begin();
			$qry ="select * into #temp from transaksi_schedulepaymentdetil where schedulepayment_id = '$schedulepayment_id' and schedulepaymentdetil_line = '$schedulepaymentdetil_line' and schedulepaymentdetil_isposted = 1
			select * from #temp
			update transaksi_schedulepaymentdetil set schedulepaymentdetil_posteddate ='$post_date' where invoice_id = (select invoice_id from #temp)
			update transaksi_jurnal set jurnal_bookdate = '$post_date', periode_id = '$periode' where jurnal_id = (select schedulepayment_id + convert(nvarchar,schedulepaymentdetil_line) from #temp)
			select *  from transaksi_schedulepaymentdetil where invoice_id = (select invoice_id from #temp)
			select * from transaksi_jurnal where jurnal_id = (select schedulepayment_id + convert(nvarchar,schedulepaymentdetil_line) from #temp)

			drop table #temp";
			
            //$ag_posting = "EXEC lm03_TrnSchedulepaymentdetil_Approved '{$schedulepayment_id}', '{$schedulepaymentdetil_line}', '{$username}', '{$isposted}', '{$post_date}','{$reason}'";
            // echo $qry; exit;
			$this->db->query($qry);    
            //echo $this->db->last_query(); exit;

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
   public function get_faktur_update_new($faktur_id, $invoice_id, $schedulepaymentdetil_line, $faktur_date)
    {
	
            $this->db->trans_begin();

            $ag_posting = "EXEC lm03_TrnSchedulepaymentdetil_FakturUpdate '{$faktur_id}', '{$invoice_id}','{$schedulepaymentdetil_line}', '{$faktur_date}'";
            $this->db->query($ag_posting);    
            //echo $this->db->last_query(); exit;

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
   
   public function get_faktur_update($faktur_id, $invoice_id, $schedulepaymentdetil_line, $faktur_date)
    {
    $stored_pocedure = "EXEC lm03_TrnSchedulepaymentdetil_FakturUpdate '$faktur_id','$invoice_id','$schedulepaymentdetil_line','$faktur_date'";
    $result = $this->db->query($stored_pocedure);
    return $result->result();
    }
	
   public function get_master_taxbranch($Criteria)
    {
    $stored_pocedure = "EXEC adm03_MstTaxBranch_Select '$Criteria'";
    $result = $this->db->query($stored_pocedure);
    return $result->row_array();
    }
	
   public function get_master_taxnumber($Criteria)
    {
    $stored_pocedure = "EXEC adm03_MstTaxNo_Create '$Criteria'";
    $result = $this->db->query($stored_pocedure);
    return $result->row_array();
    }
   public function get_schedulepayment($id)
    {
	  $sql="select * from transaksi_schedulepayment
	  where schedulepayment_id='$id'";
	return $this->db->query($sql)->row_array();
    }	
   public function get_periode($periode)
    {
	  $sql="select * from master_periode
	  where periode_id='$periode'";
	return $this->db->query($sql)->row_array();
    }	
   public function get_master_rekanan($id)
    {
	  $sql="select * from master_rekanan
	  where rekanan_id='$id'";
    return $this->db->query($sql)->row_array();
    }	
   public function get_master_agreementtype($id)
    {
	  $sql="select * from master_agreementtype
	  where agreementtype_id='$id'";
    return $this->db->query($sql)->row_array();
    }
	
   public function get_printout_invoice($invoice_id, $schedulepayment_id)
    {
    $stored_pocedure = "EXEC lm03_RptSchedulePayment_SelectPrintForm_byFakturID '$invoice_id', '$schedulepayment_id','1'";
    //echo $stored_pocedure; exit;
	$result = $this->db->query($stored_pocedure);
    return $result->result();
    }
   public function get_printout_utilities_listrik($ref_id)
    {
    $stored_pocedure = "EXEC lm03_TrnUtilitiesairgas_SelectlistriksinglePrintForm '$ref_id'";
    $result = $this->db->query($stored_pocedure);
    return $result->result();
    }
	public function get_printout_utilities_air($ref_id)
    {
    $stored_pocedure = "EXEC lm03_TrnUtilitiesairgas_SelectAirPrintForm '$ref_id'";
    $result = $this->db->query($stored_pocedure);
    return $result->result();
    }
	public function get_printout_utilities_gas($ref_id)
    {
    $stored_pocedure = "EXEC lm03_TrnUtilitiesairgas_SelectAirPrintForm '$ref_id'";
    $result = $this->db->query($stored_pocedure);
    return $result->result();
    }
   public function get_printout_header($invoice_id, $schedulepayment_id)
    {
	  $sql="select top 1 branch_id, rekanan_id, rekanan_id, rekananshipping_line, A.agreementtype_id, agreementtype_type  from transaksi_schedulepaymentdetil as A
			inner join transaksi_schedulepayment as B on A.schedulepayment_id = B.schedulepayment_id 
			inner join master_agreementtype as C on A.agreementtype_id= C.agreementtype_id 
			where invoice_id = '$invoice_id'";
    return $this->db->query($sql)->row_array();
    }
	public function get_printout_Total($invoice_id, $schedulepayment_id)
    {
	  $sql="select invoice_id, faktur_id, SUM(schedulepaymentdetil_idr) as schedulepaymentdetil_idr, SUM(schedulepaymentdetil_idr) / 100 * 10 as Tax, SUM(schedulepaymentdetil_idr) + SUM(schedulepaymentdetil_idr) / 100 * 10 as GrandTotal from transaksi_schedulepaymentdetil 
		where invoice_id = '$invoice_id' and faktur_id ='$schedulepayment_id'
		group by invoice_id, faktur_id ";
    return $this->db->query($sql)->row_array();
    }
	
   public function get_printout_proforma($schedulepayment_id)
    {
    $stored_pocedure = "EXEC lm03_RptSchedulePayment_SelectPrintForm_byFakturID '$invoice_id', '$schedulepayment_id','0'";
    $result = $this->db->query($stored_pocedure);
    return $result->result();
    }
  function getunitspace(){
    $sql="
    select  distinct agreement_id, agreementdetil_unit, agreementdetil_space from transaksi_agreementdetil
    where agreementdetil_unit <> '' AND agreementdetil_space > 0 and agreementtype_id = '4000'
    group by agreement_id, agreementdetil_unit, agreementdetil_space

    union all

    select  distinct agreement_id, agreementps_unit , agreementps_space  from transaksi_agreementps
    where agreementps_unit <> '' AND agreementps_space > 0
    group by agreement_id, agreementps_unit, agreementps_space
    ";
    return $this->db->query($sql)->result();
  }
  
   function get_INVID2($id, $line, $agrtype, $region_id, $region_nameshort, $channel_id)
   {

       $timestamp = time();	   
       //$bo_id = gen_id_boid($channel_id,'LB','sequencer_propertymanagement', $region_id, $timestamp, $agrtype, $region_nameshort);
       $bo_id = gen_id_invid($channel_id,'IN','sequencer_propertymanagement', $region_id, $timestamp, $agrtype, $region_nameshort);

       $timestamp = time();
       $now = date("Y-m-d H:i:s", $timestamp);


     return $bo_id;

   }
  function sholdetilby_id($id){
        $sql = "
          SELECT LD.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name
          FROM transaksi_loodetil LD
            JOIN transaksi_loo LH ON LH.loo_id = LD.loo_id
            JOIN master_unit UNIT ON UNIT.unit_id = LD.unit_id AND UNIT.region_id = LH.region_id AND UNIT.branch_id = LH.branch_id
            JOIN master_agreementtype AT ON AT.agreementtype_id = LD.agreementtype_id
          WHERE LD.loo_id = '$id'
          ORDER BY  loo_id, loodetil_line ASC";
    return $this->db->query($sql)->result();
  }

  function vdetilunitby_id($id){
        $sql = "
          SELECT LU.*, UNIT.unit_name AS unit_name, LT.lantai_name AS lantai_name
          FROM transaksi_loounit LU
            JOIN transaksi_loo LH ON LH.loo_id = LU.loo_id
            JOIN master_unit UNIT ON UNIT.unit_id = LU.unit_id AND UNIT.region_id = LH.region_id AND UNIT.branch_id = LH.branch_id
            JOIN master_lantai LT ON LT.lantai_id = LU.lantai_id
          WHERE LU.loo_id = '$id'";
    return $this->db->query($sql)->result();
  }





  function viewinvoice($loo_id){

     if (isset($loo_id)){
        return $this->db->query("
           select loo_id, convert(varchar(10),loo_date,120) AS loo_date, loo_type, unittype_id, loo_descr, skl_id,
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term, _createby, _createdate, _modifyby, _modifydate, region_id, isapproved, isconfirm,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name,
			  LOO.product_name,LOO.fitting_out,LOO.grace_period ,LOO.size_indoor ,LOO.size_outdoor, LOO.debtor_no, LOO.virtual_acc
           from transaksi_loo AS LOO
              JOIN master_branch AS BRANCH ON LOO.branch_id = BRANCH.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
          where LOO.loo_id='$loo_id'
       ")->result();
     }else{
       $timestamp = time();

       $now = date("Y-m-d", $timestamp);

       $result[] = (object) array(
                        'loo_id'          =>'auto',
                        'loo_date'        => $now,
                        'loo_sdate'       => $now,
                        'loo_edate'        => $now,
                        'loo_term'       => 0,
                        'region_id'       => '',
                        'branch_id'       => '',
                        'loo_type'       => '',
                        'rekanan_id'       => 0,
                        'rekananshipping_id' => 0,
                        '_createby'       => '',
                        '_createdate'     => $now,
                        '_modifyby'       => '',
                        '_modifydate'     => $now,
                        'product_name'     => '',
                        'fitting_out'     => 0,
                        'grace_period'     => 0,
                        'size_indoor'     => 0,
                        'size_outdoor'     => 0,
       );

       return $result;
     }

   }

   function viewlooprint($loo_id){

     if (isset($loo_id)){
        return $this->db->query("
           select top 1 LOO.loo_id, convert(varchar(10),loo_date,120) AS loo_date,
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,c.rekanancontact_name,
			  REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,l.lantai_name,u.unit_name,u.unit_sqm,d.loodetil_baserent

           from transaksi_loo AS LOO
		   JOIN transaksi_loodetil d on LOO.loo_id=d.loo_id
		   JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
			  JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
			  JOIN master_unit u on u.unit_id=d.unit_id
			  JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOO.loo_id='$loo_id'
       ")->result();
	 }

   }









 function getunitloo($uid){
  $sql="select distinct c.unit_name,c.unit_sqm from dbo.transaksi_loodetil a
     inner join transaksi_loo b on a.loo_id=b.loo_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.loo_id='$uid' and a.agreementtype_id='4000'";
     return $this->db->query($sql)->result();
 }

  function gethargasewa($uid){
  $sql="select  a.loodetil_descr+' (' +c.unit_name+' )' as titleharga,a.loodetil_baserent  from dbo.transaksi_loodetil a
     inner join transaksi_loo b on a.loo_id=b.loo_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.loo_id='$uid' and a.agreementtype_id='4000' order by a.unit_id,a.loodetil_line asc";
    return $this->db->query($sql)->result();
 }

 function getmasterregion($id){
  $sql="select * from master_region
  where region_id='$id' ";
  return $this->db->query($sql)->row_array();
 }
 function getservicecharge($uid){
  $sql="select SUM(loodetil_baserent) as servicecharge from transaksi_loodetil
  where loo_id='$uid' and agreementtype_id='5000'";
  return $this->db->query($sql)->row_array();
 }
  function getpromolevy($uid){
  $sql="select SUM(loodetil_baserent) as promolevy from transaksi_loodetil
  where loo_id='$uid' and agreementtype_id='6000'";
  return $this->db->query($sql)->row_array();
 }

  function getdepositr($uid){
  $sql="select loodetil_int as depositr,loodetil_baserent from transaksi_loodetil
  where loo_id='$uid' and agreementtype_id='7000'";
  return $this->db->query($sql)->row_array();
 }

 function viewconfprint($loo_id){

     if (isset($loo_id)){
        return $this->db->query("
           select top 1 LOO.loo_id,LOO.conf_id, convert(varchar(10),loo_date,120) AS loo_date,
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,c.rekanancontact_name,
        REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,REKAN.rekanan_address,REKAN.rekanan_city,
        l.lantai_name,u.unit_name,u.unit_sqm,d.loodetil_baserent

           from transaksi_loo AS LOO
       JOIN transaksi_loodetil d on LOO.loo_id=d.loo_id
       JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
        JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
        JOIN master_unit u on u.unit_id=d.unit_id
        JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOO.loo_id='$loo_id'
       ")->result();
   }

 }

 function getschemadetil($id, $line){

  $qry= " SELECT schedulepayment_id, schedulepaymentdetil_date, schedulepaymentdetil_proformadate, schedulepaymentdetil_joincode, invoice_id, schedulepaymentdetil_idr
          FROM transaksi_schedulepaymentdetil
          WHERE schedulepayment_id = '{$id}' and schedulepaymentdetil_line = '{$line}' ";

  return $this->db->query($qry)->result_array();
 }

 function getskema($id){

  $qry= " SELECT A.*, B.agreementtype_name
          FROM master_sklterm A inner join master_agreementtype B ON A.skl_atype = B.agreementtype_id
          WHERE A.skl_id = '{$id}' ";

  return $this->db->query($qry)->result_array();
 }

 function getPassword($id){

  $qry= " SELECT A.*, B.agreementtype_name
          FROM master_sklterm A inner join master_agreementtype B ON A.skl_atype = B.agreementtype_id
          WHERE A.skl_id = '{$id}' ";

  return $this->db->query($qry)->result_array();
 }
 
 function getaging($where,$where2){

    $stored_pocedure = "EXEC cp_TrnJurnalORTRP_SelectInvoiceSingle_ipro '','$where', '$where2'";
    $result = $this->db->query($stored_pocedure);

  return $result->result();
 }
 
function qry_invoicelist($sWhere){
	// echo var_dump($sWhere);
     $sWhere = empty($sWhere) ? " WHERE schedulepaymentdetil_ishold ='0' " : $sWhere." AND schedulepaymentdetil_ishold ='0'  ";

	   $qry="
     SELECT * FROM (
     select B.region_id, CTE.*,ROW_NUMBER() OVER (ORDER BY CTE.schedulepayment_id desc) as RowNumber,
              REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, agreementtype_name, agreementtype_nameshort, agreementtype_printouttype, B.branch_id, B.rekanan_id, B.channel_id,
              CONVERT(VARCHAR, schedulepaymentdetil_date, 112) as detildate, CONVERT(VARCHAR, schedulepaymentdetil_posteddate, 112) as postdate
       FROM transaksi_schedulepaymentdetil AS CTE
         inner join Transaksi_schedulepayment B on CTE.Schedulepayment_id=B.schedulepayment_id
         left join master_rekanan REKAN on B.rekanan_id=REKAN.rekanan_id
         left join master_rekananshipping BRAND on B.rekanan_id=BRAND.rekanan_id AND B.rekananshipping_line=BRAND.rekananshipping_line
         left join transaksi_print D on CTE.invoice_id=d.transaksi_id
         left join Transaksi_agreement E on CTE.ref_id= E.agreement_id
         left join master_agreementtype F on CTE.agreementtype_id = F.agreementtype_id
         left join transaksi_jurnal G on CTE.schedulepayment_id + convert(varchar(10),CTE.schedulepaymentdetil_line) = g.jurnal_id
         inner join master_branch as BRANCH on BRANCH.branch_id = B.branch_id
         inner join master_region as REGION on REGION.region_id = B.region_id
			  $sWhere
			  ) AS V";

	   //echo $qry;
	   //exit;
	    return $this->db->query($qry)->result();
   }
  
  function gettglinv($inv){
	  $sq=$this->db->query("select FORMAT(cast(schedulepaymentdetil_posteddate as date), 'dd MMMM yyyy')  as tglinv,
 FORMAT(cast(DATEADD(DAY, 14, schedulepaymentdetil_posteddate) as date), 'dd MMMM yyyy') AS tgldue 
 from transaksi_schedulepaymentdetil where invoice_id='$inv'")->row_array();
 
 return $sq;
	  
  }

  function getregion($id){

    $qry= " select * from master_region as A 
    inner join master_userregion as B  on A.region_id = B.region_id
    where username ='$id'";

    return $this->db->query($qry)->result();


 }
 function getmaster_setting($id){
  $sql="select * from master_setting
  where setting_id='$id' ";
  return $this->db->query($sql)->row_array();
 }
 function get_insert_logprint($inv_id,$fak_id,$username){
       $timestamp = time();
       $now = date("Y-m-d h:i:s", $timestamp);
    $qry= "exec lm03_TrnPrint_Insert '$inv_id','$username','$fak_id','1'";

    return $this->db->query($qry)->result();


 }
   function EnableNew($where){

	$stored_pocedure = $where;
	// echo $stored_pocedure;
	// exit;
	$result = $this->db->query($stored_pocedure);
     return $result->result();
   } 
 function getschedulepayment($inv){
  $sql="select top 1 * from transaksi_schedulepaymentdetil as A
  inner join transaksi_schedulepayment as B on A.schedulepayment_id = B.schedulepayment_id
  where invoice_id='$inv' ";
  return $this->db->query($sql)->row_array();
  }
  function getmaster_branch($id){
  $sql="select * from master_branch
  where branch_id='$id' ";
  return $this->db->query($sql)->row_array();
  }
	public function get_hold($id,$line, $ishold)
	{
	$query = "update transaksi_schedulepaymentdetil set schedulepaymentdetil_ishold = '$ishold' where schedulepayment_id = '$id' and schedulepaymentdetil_line = '$line' and schedulepaymentdetil_isposted = 0 and schedulepaymentdetil_ischecked = 0 and schedulepaymentdetil_isdisabled = 0";
	$result = $this->db->query($query);
	return $result->result();
	}  
	public function get_disabled($id,$line, $isdisabled)
	{
	$query = "update transaksi_schedulepaymentdetil set schedulepaymentdetil_isdisabled = '$isdisabled' where schedulepayment_id = '$id' and schedulepaymentdetil_line = '$line' and schedulepaymentdetil_isposted = 0 and schedulepaymentdetil_ischecked = 0 and schedulepaymentdetil_ishold = 0";
	$result = $this->db->query($query);
	return $result->result();
	}
 	
  public function get_update_ppndtp($Criteria_ppn)
    {
	
            $this->db->trans_begin();

            $ag_posting = "EXEC lm03_TrnSchedulepaymentdetil_update_ppndtp '{$Criteria_ppn}'";
            $this->db->query($ag_posting);    
            //echo $this->db->last_query(); exit;

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
  
}
