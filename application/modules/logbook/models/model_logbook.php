<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_logbook extends CI_Model{

    function __construct(){
        parent::__construct();
    }

	 function qry_alldatadialog($limit,$top,$sWhere){

		 $sWhere = empty($sWhere) ? " WHERE unit_state <> 3 " : $sWhere." AND unit_state <> 3 AND unittype_id = 7";

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
	   $sWhere = empty($sWhere) ? " WHERE unit_state <> 3 " : $sWhere." AND unit_state <> 3 AND unittype_id = 7";

	   $qry="select count(unit_id) as jml from master_unit $sWhere";
		return $this->db->query($qry)->row_array();

   }

   function qry_totalalldialog(){
	   $qry="select count(unit_id) as jml from master_unit where unit_state<>3 AND unittype_id = 7";
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

    function qry_alldatalist($limit,$top,$sWhere){
	// echo var_dump($sWhere);
     $sWhere = empty($sWhere) ? " WHERE isdelete = 0 and isdisable ='0' " : $sWhere." AND isdelete = 0 and isdisable ='0'  ";
	// echo '$limit : ' . $limit . ' $top : ' . $top . ' $sWhere : ' . $sWhere;
	// exit;
	   $qry="
     SELECT * FROM (
     select top $limit  CTE.*,ROW_NUMBER() OVER (ORDER BY REGION.region_nameshort, BRANCH.branch_name, BRAND.rekananshipping_name) as RowNumber, REGION.region_nameshort, REGION.region_name, BRANCH.branch_name, BRAND.rekananshipping_name, rekanan_name, BRAND.rowid  
       
       from transaksi_log_book as CTE
inner join master_region as REGION on CTE.region_id = REGION.region_id
inner join master_branch as BRANCH on CTE.branch_id = BRANCH.branch_id 
inner join master_rekanan as REKANAN on CTE.rekanan_id = REKANAN.rekanan_id 
inner join master_rekananshipping as BRAND on CTE.rekanan_id = BRAND.rekanan_id and CTE.rekananshipping_line = BRAND.rekananshipping_line 
			  $sWhere
			  ORDER BY REGION.region_nameshort, BRANCH.branch_name, BRAND.rekananshipping_name
			  ) AS V
    	WHERE   RowNumber > $top";

	    // echo $qry;
	    // exit;
	   return $this->db->query($qry)->result_array();
   }

    function qry_filteredlist($sWhere){
       $sWhere = empty($sWhere) ? " WHERE  isdelete = 0 and isdisable ='0' " : $sWhere."  and isdelete = 0 and isdisable ='0' ";
	   $qry="SELECT count(*) as jml FROM (
			select CTE.*,ROW_NUMBER() OVER (ORDER BY REGION.region_nameshort, BRANCH.branch_name, BRAND.rekananshipping_name) as RowNumber,
						   REGION.region_nameshort, BRANCH.branch_name, REKANAN.rekanan_name, BRAND.rekananshipping_name
       from transaksi_log_book as CTE
inner join master_region as REGION on CTE.region_id = REGION.region_id
inner join master_branch as BRANCH on CTE.branch_id = BRANCH.branch_id 
inner join master_rekanan as REKANAN on CTE.rekanan_id = REKANAN.rekanan_id 
inner join master_rekananshipping as BRAND on CTE.rekanan_id = BRAND.rekanan_id and CTE.rekananshipping_line = BRAND.rekananshipping_line 
			  $sWhere

			  ) AS V";
	    // echo $qry;
	    // exit;			  
return $this->db->query($qry)->row_array();

   }

   function qry_totalalllist(){
	   $qry="select count(rekanan_id) as jml from transaksi_log_book where isdelete = 0 and isdisable ='0' ";
		// echo $qry;
		// exit();
		return $this->db->query($qry)->row_array();

   }


   function qry_alldataregion($limit,$top,$sWhere){
      $qry="WITH CTE AS (
          select top $limit region_id, region_name,
            ROW_NUMBER() OVER (ORDER BY region_id asc) as RowNumber
          from master_region
          $sWhere )
      SELECT CTE.*
      FROM CTE
      WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();
   }

   function qry_filteredregion($sWhere){
     $qry="select count(region_id) as jml
          from master_region
           $sWhere";
    return $this->db->query($qry)->row_array();

   }

   function qry_totalallregion(){
     $qry="select count(region_id) as jml
          from master_region";
    return $this->db->query($qry)->row_array();

   }

   function qry_alldatabranch($limit,$top,$sWhere){
     $qry="WITH CTE AS (
         select top $limit A.branch_id as branch_id, branch_name, region_id,
           ROW_NUMBER() OVER (ORDER BY branch_name asc) as RowNumber
         from master_branch A
           JOIN master_regionbranch AS B ON A.branch_id = B.branch_id
         $sWhere )
      SELECT CTE.*
      FROM CTE
      WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();
   }

   function qry_filteredbranch($sWhere){
     $qry="select count(A.branch_id) as jml
           from master_branch as A inner join master_regionbranch as B
           on A.branch_id = B.branch_id
           $sWhere";
    return $this->db->query($qry)->row_array();

   }

   function qry_totalallbranch(){
     $qry="select count(A.branch_id) as jml
     from master_branch as A inner join master_regionbranch as B
     on A.branch_id = B.branch_id
          ";
    return $this->db->query($qry)->row_array();

   }

   function qry_alldatabrand($limit,$top,$sWhere){
      $qry="WITH CTE AS (
          select top $limit rekananshipping_line, rekananshipping_name, rekanan_id, rowid, 
            ROW_NUMBER() OVER (ORDER BY rekananshipping_line asc) as RowNumber
          from master_rekananshipping
          $sWhere )
      SELECT CTE.*
      FROM CTE
      WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();
   }

   function qry_filteredbrand($sWhere){
     $qry="select count(rekananshipping_line) as jml
          from master_rekananshipping
           $sWhere";
    return $this->db->query($qry)->row_array();

   }

   function qry_totalallbrand(){
     $qry="select count(rekananshipping_line) as jml
          from master_rekananshipping";
    return $this->db->query($qry)->row_array();

   }


   function qry_alldatatenant($limit,$top,$sWhere){
      $qry="WITH CTE AS (
        select top $limit A.rekanan_id as rekanan_id, rekanan_name, branch_id,
          ROW_NUMBER() OVER (ORDER BY A.rekanan_id asc) as RowNumber
        from master_rekanan as A left join (select MAX(rekanan_id) as rekanan_id, MAX(branch_id) as branch_id from master_rekananshipping group by rekanan_id, branch_id ) as B
          ON A.rekanan_id = B.rekanan_id
        $sWhere )
      SELECT CTE.*
      FROM CTE
      WHERE RowNumber > $top";
		// echo $qry;
		// exit();	  
     return $this->db->query($qry)->result_array();
   }

   function qry_filteredtenant($sWhere){
     $qry="select count(A.rekanan_id) as jml
     from master_rekanan as A left join (select MAX(rekanan_id) as rekanan_id, MAX(branch_id) as branch_id from master_rekananshipping group by rekanan_id, branch_id ) as B
       ON A.rekanan_id = B.rekanan_id
           $sWhere";
    return $this->db->query($qry)->row_array();

   }

   function qry_totalalltenant(){
     $qry="select count(A.rekanan_id) as jml
     from master_rekanan as A left join (select MAX(rekanan_id) as rekanan_id, MAX(branch_id) as branch_id from master_rekananshipping group by rekanan_id, branch_id ) as B
       ON A.rekanan_id = B.rekanan_id";
    return $this->db->query($qry)->row_array();

   }
   
   
  function get_debtorCode($rekanan,$rekananshipping_line)
  {
	 $sql = " SELECT rowid FROM master_rekananshipping WHERE rekanan_id = '$rekanan' and rekananshipping_line = $rekananshipping_line";
	 return $this->db->query($sql)->row();

  }

  function sholdetilby_id($id){
        $sql = "
          SELECT  Tax_no, Tax_status, region_id, Tax_descr, Tax_isdisable, taxbranch_id from master_logbook
		  WHERE Tax_no = '$id'
          ORDER BY  Tax_no ASC";
    return $this->db->query($sql)->result();
  }

  function vdetilunitby_id($id){
        $sql = "
                SELECT LU.*, UNIT.unit_name AS unit_name, LT.lantai_name AS lantai_name, loounit_sdate, loounit_edate, loounit_descr, rekananshipping_name
                FROM transaksi_loounit LU
                  JOIN transaksi_loo LH ON LH.logbook_id = LU.logbook_id
                  JOIN master_unit UNIT ON UNIT.unit_id = LU.unit_id AND UNIT.region_id = LH.region_id AND UNIT.branch_id = LH.branch_id
                  JOIN master_lantai LT ON LT.lantai_id = LU.lantai_id
                  JOIN master_rekananshipping RS ON LU.rekanan_id = RS.rekanan_id AND LU.rekananshipping_line = RS.rekananshipping_line
          WHERE LU.logbook_id = '$id'";
    return $this->db->query($sql)->result();
  }
  
function insertlogbook($region_id, $branch_id, $rekanan_id, $rekananshipping_line, $debtor, $telpno, $telpdate, $result, $user_name)
    {
             
        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     

        $sp_insert = " EXEC [lm03_TrnLogBook_Insert] '$region_id', '$branch_id', '$rekanan_id', $rekananshipping_line, '$debtor', '$now','$telpno','$result','$user_name'";
        // echo $sp_insert;
		// exit;
		$this->db->query($sp_insert); 
		
  		       
      if ($this->db->trans_status() === FALSE)
      { 
          $this->db->trans_rollback();
          return false;
      }else{
          $this->db->trans_commit();

          return $region_id;  
      }
	  
		return $region_id;
			  
    }
	
	function updatelogbook($tax_no, $region_id, $tax_status, $tax_descr, $tax_isdisable, $taxbranch_id){

  		  $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);

		foreach($tax_no as $key => $n){

  				$dtax_no       = $tax_no[$key];
  				$dregion_id       = $region_id[$key];
  				$dtax_status    = $tax_status[$key];
  				$dtax_descr   = $tax_descr[$key];
				$dtax_isdisable      = ($tax_isdisable[$key]) ? 1 : 0;
				
				$dtaxbranch_id      = $taxbranch_id[$key];          
				//echo $dtax_isdisable;
				//exit;
        	$this->db->query("
             update master_logbook
            set tax_isdisable = $dtax_isdisable
            where tax_no = '$dtax_no'
			"); 
        }
         
  }

	function deletelogbook($logbook_id){

    $this->db->query(" UPDATE transaksi_log_book SET isdelete = '1' WHERE logbook_id = '$logbook_id' ");

	}

  function viewlogbook($logbook_id){


     if (isset($logbook_id)){
        return $this->db->query("
           select tax_no, A.region_id, region_name, tax_status, tax_descr, tax_isdisable, taxbranch_id, branch_name
           from master_logbook as A
		   inner join master_region as B on A.region_id = B.region_id
		   left join master_branch as C on A.taxbranch_id = C.branch_id
           where tax_no='$logbook_id'
       ")->result();
     }else{
       $timestamp = time();

       $now = date("Y-m-d", $timestamp);

       $result[] = (object) array(
                        'tax_no'          =>'',
                        'region_id'        => '',
                        'tax_status'       => '',
                        'tax_descr'        => '',
                        'tax_isdisable'       => 0,
                        'taxbranch_id'       => ''
       );

       return $result;
     }

   }

   function viewlooprint($logbook_id){

     if (isset($logbook_id)){
        return $this->db->query("
           select top 1 LOO.logbook_id, convert(varchar(10),logbook_date,120) AS logbook_date,
              convert(varchar(10),logbook_sdate,120) AS logbook_sdate, convert(varchar(10),logbook_edate,120) AS logbook_edate,
              logbook_term,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,c.rekanancontact_name,
			  REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,l.lantai_name,u.unit_name,u.unit_sqm,d.loodetil_baserent

           from transaksi_loo AS LOO
		   JOIN transaksi_loodetil d on LOO.logbook_id=d.logbook_id
		   JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
			  JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
			  JOIN master_unit u on u.unit_id=d.unit_id
			  JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOO.logbook_id='$logbook_id'
       ")->result();
	 }

   }



 function confirmloo($arrCon){

     $action = "return";

     if (is_array($arrCon)){
       if (count($arrCon) >0){
          foreach ($arrCon as $filt){

            $logbook_id     = $filt[0];
            $region_id  = $filt[1];
            $branch_id  = $filt[2];

            $timestamp = time();

            $this->db->trans_begin();

            $this->db->query(" UPDATE transaksi_loo SET isconfirm = '1' WHERE logbook_id = '$logbook_id' ");

            $u_sql = " SELECT DISTINCT unit_id FROM transaksi_loodetil WHERE logbook_id = '$logbook_id' ";

            $q_uid = $this->db->query($u_sql)->result_array();

            foreach($q_uid as $uid){

              $unit_id = $uid['unit_id'];
              $this->db->query("UPDATE master_unit SET unit_state = 3 WHERE unit_id = '$unit_id' and region_id = '$region_id' and branch_id = '$branch_id' ");

            }

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
     }

   }

   function approveloo($arrapp){

    $action = "approve";

     if (is_array($arrapp)){
       if (count($arrapp) >0){
          foreach ($arrapp as $key){

            $logbook_id = $key[0];
            $region_id = $key[1];
            $branch_id = $key[2];

            $this->db->trans_begin();

            $this->db->query(" UPDATE transaksi_loo SET isapproved = '1' WHERE logbook_id = '$logbook_id' ");

            $u_sql = " SELECT DISTINCT unit_id FROM transaksi_loodetil WHERE logbook_id = '$logbook_id' ";

            $q_uid = $this->db->query($u_sql)->result_array();

            foreach($q_uid as $uid){

              $unit_id = $uid['unit_id'];
              $this->db->query(" UPDATE master_unit SET unit_state = 2 WHERE unit_id='$unit_id' and region_id = '$region_id' and branch_id = '$branch_id' ");

            }

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
     }

   }


   function dataconf($uid){

        $sql = "
          SELECT DISTINCT LOH.*,
            REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name,
            UNIT.unit_name, LOD.unit_id
          FROM transaksi_loo LOH
            JOIN transaksi_loodetil LOD ON LOH.logbook_id = LOD.logbook_id
            JOIN master_region AS REGION ON LOH.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOH.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOH.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOH.rekanan_id = BRAND.rekanan_id AND LOH.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOH.region_id AND UNIT.branch_id = LOH.branch_id
          WHERE LOH.isconfirm = '0' AND LOH.isapproved = '1'  AND UNIT.unit_state <> '3' AND LOD.unit_id like '%{$uid}%' ";

        return $this->db->query($sql)->result_array();
    }

    function dataapp($uid){

        $sql = "
          SELECT DISTINCT LOH.*,
            REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name,
            UNIT.unit_name, LOD.unit_id
          FROM transaksi_loo LOH
            JOIN transaksi_loodetil LOD ON LOH.logbook_id = LOD.logbook_id
            JOIN master_region AS REGION ON LOH.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOH.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOH.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOH.rekanan_id = BRAND.rekanan_id AND LOH.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOH.region_id AND UNIT.branch_id = LOH.branch_id
          WHERE LOH.isapproved = '0' AND UNIT.unit_state <> '2' and LOH.unittype_id = 7 AND LOD.unit_id like '%{$uid}%' ";

        return $this->db->query($sql)->result_array();
    }

    function dataprintconf($uid){

        $sql = "
          SELECT DISTINCT LOH.*, REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, UNIT.unit_name, LOD.unit_id
          FROM transaksi_loo LOH
            JOIN transaksi_loodetil LOD ON LOH.logbook_id = LOD.logbook_id
            JOIN master_region AS REGION ON LOH.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOH.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOH.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOH.rekanan_id = BRAND.rekanan_id AND LOH.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOH.region_id AND UNIT.branch_id = LOH.branch_id
          WHERE LOH.isapproved = '0' AND LOH.isconfirm = '1' AND LOD.unit_id like '%{$uid}%' ";

        return $this->db->query($sql)->result_array();
    }

 function getunitloo($uid){
  $sql="select distinct c.unit_name,c.unit_sqm from dbo.transaksi_loodetil a
     inner join transaksi_loo b on a.logbook_id=b.logbook_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.logbook_id='$uid' and a.agreementtype_id='4000'";
     return $this->db->query($sql)->result();
 }

  function gethargasewa($uid){
  $sql="select  a.loodetil_descr+' (' +c.unit_name+' )' as titleharga,a.loodetil_baserent  from dbo.transaksi_loodetil a
     inner join transaksi_loo b on a.logbook_id=b.logbook_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.logbook_id='$uid' and a.agreementtype_id='4000' order by a.unit_id,a.loodetil_line asc";
    return $this->db->query($sql)->result();
 }

 function getservicecharge($uid){
  $sql="select SUM(loodetil_baserent) as servicecharge from transaksi_loodetil
  where logbook_id='$uid' and agreementtype_id='5000'";
  return $this->db->query($sql)->row_array();
 }

  function getpromolevy($uid){
  $sql="select SUM(loodetil_baserent) as promolevy from transaksi_loodetil
  where logbook_id='$uid' and agreementtype_id='6000'";
  return $this->db->query($sql)->row_array();
 }

  function getdepositr($uid){
  $sql="select loodetil_int as depositr,loodetil_baserent from transaksi_loodetil
  where logbook_id='$uid' and agreementtype_id='7000'";
  return $this->db->query($sql)->row_array();
 }

   function dataapplist($uid){

        $sql = "
          SELECT DISTINCT LOH.*,
            REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name,'' as unit_id
          FROM transaksi_loo LOH
            JOIN transaksi_loounit LOU ON LOU.logbook_id = LOH.logbook_id
            JOIN transaksi_loodetil LOD ON LOH.logbook_id = LOD.logbook_id
            JOIN master_region AS REGION ON LOU.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOU.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOU.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOU.rekanan_id = BRAND.rekanan_id AND LOU.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOU.region_id AND UNIT.branch_id = LOU.branch_id
          WHERE LOH.isapproved = '0' AND UNIT.unit_state <> '2' and LOH.unittype_id = 7  AND LOD.unit_id like '%{$uid}%'
          ORDER BY logbook_id desc ";

        return $this->db->query($sql)->result_array();
    }

 function viewconfprint($logbook_id){

     if (isset($logbook_id)){
        return $this->db->query("
           select top 1 LOO.logbook_id,LOO.conf_id, convert(varchar(10),logbook_date,120) AS logbook_date,
              convert(varchar(10),logbook_sdate,120) AS logbook_sdate, convert(varchar(10),logbook_edate,120) AS logbook_edate,
              logbook_term,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,c.rekanancontact_name,
        REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,REKAN.rekanan_address,REKAN.rekanan_city,
        l.lantai_name,u.unit_name,u.unit_sqm,d.loodetil_baserent

           from transaksi_loo AS LOO
       JOIN transaksi_loodetil d on LOO.logbook_id=d.logbook_id
       JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
        JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
        JOIN master_unit u on u.unit_id=d.unit_id
        JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOO.logbook_id='$logbook_id'
       ")->result();
   }

 }

}
