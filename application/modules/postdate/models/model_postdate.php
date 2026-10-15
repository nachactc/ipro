<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_postdate extends CI_Model{

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
    //$sWhere = empty($sWhere) ? " WHERE postdate_id <> 'XXX' " : $sWhere." AND postdate_id <> 'XXX'";
     $qry="
			SELECT * FROM (
			select top $limit  *,ROW_NUMBER() OVER (ORDER BY posting_date desc) as RowNumber
			  FROM master_postingdate			   
        $sWhere
			  ORDER BY posting_date desc
			  ) AS V
    	WHERE   RowNumber > $top";
      //echo $qry;
	   return $this->db->query($qry)->result_array();
   }

    function qry_filteredlist($sWhere){

     $qry="SELECT count(*) as jml FROM (
			select CTE.*,ROW_NUMBER() OVER (ORDER BY posting_date desc) as RowNumber
			  FROM master_postingdate AS CTE
			  $sWhere

			  ) AS V";
		return $this->db->query($qry)->row_array();

   }

   function qry_totalalllist(){
	   $qry="select count(posting_date) as jml from master_postingdate";
		return $this->db->query($qry)->row_array();

   }



  function get_debtorCode($rekanan,$rekananshipping_line)
  {
	 $sql = " SELECT rowid FROM master_rekananshipping WHERE rekanan_id = '$rekanan' and rekananshipping_line = $rekananshipping_line";
	 return $this->db->query($sql)->row();

  }

  function sholdetilby_id($id){
        $sql = "
          SELECT  Tax_no, Tax_status, region_id, Tax_descr, Tax_isdisable, postdate_id from master_postdate
		  WHERE Tax_no = '$id'
          ORDER BY  Tax_no ASC";
    return $this->db->query($sql)->result();
  }

  function vdetilunitby_id($id){
        $sql = "
                SELECT LU.*, UNIT.unit_name AS unit_name, LT.lantai_name AS lantai_name, loounit_sdate, loounit_edate, loounit_descr, rekananshipping_name
                FROM transaksi_loounit LU
                  JOIN transaksi_loo LH ON LH.postdate_id = LU.postdate_id
                  JOIN master_unit UNIT ON UNIT.unit_id = LU.unit_id AND UNIT.region_id = LH.region_id AND UNIT.branch_id = LH.branch_id
                  JOIN master_lantai LT ON LT.lantai_id = LU.lantai_id
                  JOIN master_rekananshipping RS ON LU.rekanan_id = RS.rekanan_id AND LU.rekananshipping_line = RS.rekananshipping_line
          WHERE LU.postdate_id = '$id'";
    return $this->db->query($sql)->result();
  }
  
function insertpostdate($posting_date,$date_old,$periode,$agreement_type,$due_date)
    {
             
        // $timestamp = time();
        // $now = date("Y-m-d H:i:s", $timestamp);     
		$year = date('Y', strtotime($posting_date));
		$month = date('m', strtotime($posting_date));
		$periode = date('Y-m', strtotime($periode));
        	// $this->db->query("
             // delete from master_postingdate
            // where year(posting_date) = '$year' and month(posting_date) = '$month'
			// ");
			
        $check = $this->db->query("
                 insert into master_postingdate
                     (periode,posting_date,due_date,agreement_type, isdisable)
                 values
                     ('$periode','$posting_date','$due_date','$agreement_type',0)");        
			
			return $posting_date;
			  
    }
	
	function updatepostdate($posting_date,$date_old,$periode,$agreement_type,$due_date){

		$year = date('Y', strtotime($date_old));
		$month = date('m', strtotime($date_old));
		
  		  // $timestamp = time();
        // $now = date("Y-m-d H:i:s", $timestamp);



		
			// $sql ="
             // update master_postingdate
            // set posting_date = '$posting_date'
            // where periode = '$periode' and agreement_type = '$agreement_type'
			// ";
		// echo $sql;
		// exit;
		
        	$this->db->query("
             update master_postingdate
            set posting_date = '$posting_date', due_date = '$due_date'
            where periode = '$periode' and agreement_type = '$agreement_type' 
			"); 
        
         
  }

	function deletepostdate($posting_date,$periode,$type){

    $this->db->query(" delete from  master_postingdate WHERE periode = '$periode' and agreement_type = '$type' ");

		//$this->db->query("delete from transaksi_loo where postdate_id='$postdate_id'");
		//$this->db->query("delete from transaksi_loodetil where postdate_id='$postdate_id'");
    //$this->db->query("delete from transaksi_loounit where postdate_id='$postdate_id'");
	}

  function viewpostdateALL($posting_date){


      
        return $this->db->query("
           select  *
           from master_postingdate
       ")->result();

       return $result;
     

   }

  function viewpostdate($posting_date,$periode,$type){


      
        return $this->db->query("
           select  *
           from master_postingdate
           where posting_date='$posting_date' and periode ='$periode' and agreement_type ='$type'
       ")->result();

       return $result;
     

   }
   
   function viewlooprint($postdate_id){

     if (isset($postdate_id)){
        return $this->db->query("
           select top 1 LOO.postdate_id, convert(varchar(10),postdate_date,120) AS postdate_date,
              convert(varchar(10),postdate_sdate,120) AS postdate_sdate, convert(varchar(10),postdate_edate,120) AS postdate_edate,
              postdate_term,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,c.rekanancontact_name,
			  REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,l.lantai_name,u.unit_name,u.unit_sqm,d.loodetil_baserent

           from transaksi_loo AS LOO
		   JOIN transaksi_loodetil d on LOO.postdate_id=d.postdate_id
		   JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
			  JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
			  JOIN master_unit u on u.unit_id=d.unit_id
			  JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOO.postdate_id='$postdate_id'
       ")->result();
	 }

   }



 function confirmloo($arrCon){

     $action = "return";

     if (is_array($arrCon)){
       if (count($arrCon) >0){
          foreach ($arrCon as $filt){

            $postdate_id     = $filt[0];
            $region_id  = $filt[1];
            $branch_id  = $filt[2];

            $timestamp = time();

            $this->db->trans_begin();

            $this->db->query(" UPDATE transaksi_loo SET isconfirm = '1' WHERE postdate_id = '$postdate_id' ");

            $u_sql = " SELECT DISTINCT unit_id FROM transaksi_loodetil WHERE postdate_id = '$postdate_id' ";

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

            $postdate_id = $key[0];
            $region_id = $key[1];
            $branch_id = $key[2];

            $this->db->trans_begin();

            $this->db->query(" UPDATE transaksi_loo SET isapproved = '1' WHERE postdate_id = '$postdate_id' ");

            $u_sql = " SELECT DISTINCT unit_id FROM transaksi_loodetil WHERE postdate_id = '$postdate_id' ";

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
            JOIN transaksi_loodetil LOD ON LOH.postdate_id = LOD.postdate_id
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
            JOIN transaksi_loodetil LOD ON LOH.postdate_id = LOD.postdate_id
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
            JOIN transaksi_loodetil LOD ON LOH.postdate_id = LOD.postdate_id
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
     inner join transaksi_loo b on a.postdate_id=b.postdate_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.postdate_id='$uid' and a.agreementtype_id='4000'";
     return $this->db->query($sql)->result();
 }

  function gethargasewa($uid){
  $sql="select  a.loodetil_descr+' (' +c.unit_name+' )' as titleharga,a.loodetil_baserent  from dbo.transaksi_loodetil a
     inner join transaksi_loo b on a.postdate_id=b.postdate_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.postdate_id='$uid' and a.agreementtype_id='4000' order by a.unit_id,a.loodetil_line asc";
    return $this->db->query($sql)->result();
 }

 function getservicecharge($uid){
  $sql="select SUM(loodetil_baserent) as servicecharge from transaksi_loodetil
  where postdate_id='$uid' and agreementtype_id='5000'";
  return $this->db->query($sql)->row_array();
 }

  function getpromolevy($uid){
  $sql="select SUM(loodetil_baserent) as promolevy from transaksi_loodetil
  where postdate_id='$uid' and agreementtype_id='6000'";
  return $this->db->query($sql)->row_array();
 }

  function getdepositr($uid){
  $sql="select loodetil_int as depositr,loodetil_baserent from transaksi_loodetil
  where postdate_id='$uid' and agreementtype_id='7000'";
  return $this->db->query($sql)->row_array();
 }

function getbranchname($id){
  $sql="select branch_name from master_branch
  where branch_id='$id'";
  return $this->db->query($sql)->row_array();
 }
   function dataapplist($uid){

        $sql = "
          SELECT DISTINCT LOH.*,
            REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name,'' as unit_id
          FROM transaksi_loo LOH
            JOIN transaksi_loounit LOU ON LOU.postdate_id = LOH.postdate_id
            JOIN transaksi_loodetil LOD ON LOH.postdate_id = LOD.postdate_id
            JOIN master_region AS REGION ON LOU.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOU.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOU.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOU.rekanan_id = BRAND.rekanan_id AND LOU.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOU.region_id AND UNIT.branch_id = LOU.branch_id
          WHERE LOH.isapproved = '0' AND UNIT.unit_state <> '2' and LOH.unittype_id = 7  AND LOD.unit_id like '%{$uid}%'
          ORDER BY postdate_id desc ";

        return $this->db->query($sql)->result_array();
    }

 function viewconfprint($postdate_id){

     if (isset($postdate_id)){
        return $this->db->query("
           select top 1 LOO.postdate_id,LOO.conf_id, convert(varchar(10),postdate_date,120) AS postdate_date,
              convert(varchar(10),postdate_sdate,120) AS postdate_sdate, convert(varchar(10),postdate_edate,120) AS postdate_edate,
              postdate_term,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,c.rekanancontact_name,
        REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,REKAN.rekanan_address,REKAN.rekanan_city,
        l.lantai_name,u.unit_name,u.unit_sqm,d.loodetil_baserent

           from transaksi_loo AS LOO
       JOIN transaksi_loodetil d on LOO.postdate_id=d.postdate_id
       JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
        JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
        JOIN master_unit u on u.unit_id=d.unit_id
        JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOO.postdate_id='$postdate_id'
       ")->result();
   }

 }

}
