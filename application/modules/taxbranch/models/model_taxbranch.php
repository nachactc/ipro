<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_taxbranch extends CI_Model{

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
    $sWhere = empty($sWhere) ? " WHERE taxbranch_id <> 'XXX' " : $sWhere." AND taxbranch_id <> 'XXX'";
     $qry="
			SELECT * FROM (
			select top $limit CTE.*,ROW_NUMBER() OVER (ORDER BY taxbranch_id desc) as RowNumber,
						   REGION.region_id, region_name, BRANCH.branch_name
			  FROM master_taxbranch AS CTE
			  JOIN master_regionbranch AS REGION ON CTE.branch_id = REGION.branch_id
			  JOIN master_region AS MREGION ON REGION.region_id = MREGION.region_id
        LEFT JOIN master_branch as BRANCH on CTE.taxbranch_id = BRANCH.branch_id
        $sWhere
			  ORDER BY CTE.taxbranch_id
			  ) AS V
    	WHERE   RowNumber > $top";
      //echo $qry;
	   return $this->db->query($qry)->result_array();
   }

    function qry_filteredlist($sWhere){

     $qry="SELECT count(*) as jml FROM (
			select CTE.*,ROW_NUMBER() OVER (ORDER BY taxbranch_id desc) as RowNumber,
						   REGION.region_id, region_name, BRANCH.branch_name
			  FROM master_taxbranch AS CTE
			  JOIN master_regionbranch AS REGION ON CTE.branch_id = REGION.branch_id
			  JOIN master_region AS MREGION ON REGION.region_id = MREGION.region_id
        LEFT JOIN master_branch as BRANCH on CTE.taxbranch_id = BRANCH.branch_id
			  $sWhere

			  ) AS V";
		return $this->db->query($qry)->row_array();

   }

   function qry_totalalllist(){
	   $qry="select count(taxbranch_id) as jml from master_taxbranch";
		return $this->db->query($qry)->row_array();

   }



  function get_debtorCode($rekanan,$rekananshipping_line)
  {
	 $sql = " SELECT rowid FROM master_rekananshipping WHERE rekanan_id = '$rekanan' and rekananshipping_line = $rekananshipping_line";
	 return $this->db->query($sql)->row();

  }

  function sholdetilby_id($id){
        $sql = "
          SELECT  Tax_no, Tax_status, region_id, Tax_descr, Tax_isdisable, taxbranch_id from master_taxbranch
		  WHERE Tax_no = '$id'
          ORDER BY  Tax_no ASC";
    return $this->db->query($sql)->result();
  }

  function vdetilunitby_id($id){
        $sql = "
                SELECT LU.*, UNIT.unit_name AS unit_name, LT.lantai_name AS lantai_name, loounit_sdate, loounit_edate, loounit_descr, rekananshipping_name
                FROM transaksi_loounit LU
                  JOIN transaksi_loo LH ON LH.taxbranch_id = LU.taxbranch_id
                  JOIN master_unit UNIT ON UNIT.unit_id = LU.unit_id AND UNIT.region_id = LH.region_id AND UNIT.branch_id = LH.branch_id
                  JOIN master_lantai LT ON LT.lantai_id = LU.lantai_id
                  JOIN master_rekananshipping RS ON LU.rekanan_id = RS.rekanan_id AND LU.rekananshipping_line = RS.rekananshipping_line
          WHERE LU.taxbranch_id = '$id'";
    return $this->db->query($sql)->result();
  }
  
function inserttaxbranch($taxbranch_id, $branch_id, $branch_name)
    {
             
        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     

        $check = $this->db->query("
                 insert into master_taxbranch
                     (taxbranch_id, line, branch_id, taxbranch_descr, isdisabled)
                 values
                     ('$taxbranch_id',10, '$branch_id', '$branch_name',0)");        
			
			return $taxbranch_id;
			  
    }
	
	function updatetaxbranch($taxbranch_id, $isdisabled){

  		  $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);


        	$this->db->query("
             update master_taxbranch
            set isdisabled = $isdisabled
            where taxbranch_id = '$taxbranch_id'
			"); 
        
         
  }

	function deletetaxbranch($taxbranch_id){

    $this->db->query(" delete from  master_taxbranch WHERE taxbranch_id = '$taxbranch_id' ");

		//$this->db->query("delete from transaksi_loo where taxbranch_id='$taxbranch_id'");
		//$this->db->query("delete from transaksi_loodetil where taxbranch_id='$taxbranch_id'");
    //$this->db->query("delete from transaksi_loounit where taxbranch_id='$taxbranch_id'");
	}

  function viewtaxbranch($taxbranch_id){


     if (isset($taxbranch_id)){
        return $this->db->query("
           select  B.region_id, region_name, A.branch_id, taxbranch_descr, isdisabled, taxbranch_id, branch_name
           from master_taxbranch as A
		   inner join master_regionbranch as B on A.branch_id = B.branch_id
		   left join master_branch as C on A.branch_id = C.branch_id
		   left join master_region as D on B.region_id = D.region_id
           where taxbranch_id='$taxbranch_id'
       ")->result();
     }else{
       $timestamp = time();

       $now = date("Y-m-d", $timestamp);

       $result[] = (object) array(
                        'taxbranch_id'          =>'',
                        'region_id'        => '',
                        'branch_id'       => '',
                        'taxbranch_descr'        => '',
                        'isdisabled'       => 0
       );

       return $result;
     }

   }

   function viewlooprint($taxbranch_id){

     if (isset($taxbranch_id)){
        return $this->db->query("
           select top 1 LOO.taxbranch_id, convert(varchar(10),taxbranch_date,120) AS taxbranch_date,
              convert(varchar(10),taxbranch_sdate,120) AS taxbranch_sdate, convert(varchar(10),taxbranch_edate,120) AS taxbranch_edate,
              taxbranch_term,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,c.rekanancontact_name,
			  REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,l.lantai_name,u.unit_name,u.unit_sqm,d.loodetil_baserent

           from transaksi_loo AS LOO
		   JOIN transaksi_loodetil d on LOO.taxbranch_id=d.taxbranch_id
		   JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
			  JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
			  JOIN master_unit u on u.unit_id=d.unit_id
			  JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOO.taxbranch_id='$taxbranch_id'
       ")->result();
	 }

   }



 function confirmloo($arrCon){

     $action = "return";

     if (is_array($arrCon)){
       if (count($arrCon) >0){
          foreach ($arrCon as $filt){

            $taxbranch_id     = $filt[0];
            $region_id  = $filt[1];
            $branch_id  = $filt[2];

            $timestamp = time();

            $this->db->trans_begin();

            $this->db->query(" UPDATE transaksi_loo SET isconfirm = '1' WHERE taxbranch_id = '$taxbranch_id' ");

            $u_sql = " SELECT DISTINCT unit_id FROM transaksi_loodetil WHERE taxbranch_id = '$taxbranch_id' ";

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

            $taxbranch_id = $key[0];
            $region_id = $key[1];
            $branch_id = $key[2];

            $this->db->trans_begin();

            $this->db->query(" UPDATE transaksi_loo SET isapproved = '1' WHERE taxbranch_id = '$taxbranch_id' ");

            $u_sql = " SELECT DISTINCT unit_id FROM transaksi_loodetil WHERE taxbranch_id = '$taxbranch_id' ";

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
            JOIN transaksi_loodetil LOD ON LOH.taxbranch_id = LOD.taxbranch_id
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
            JOIN transaksi_loodetil LOD ON LOH.taxbranch_id = LOD.taxbranch_id
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
            JOIN transaksi_loodetil LOD ON LOH.taxbranch_id = LOD.taxbranch_id
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
     inner join transaksi_loo b on a.taxbranch_id=b.taxbranch_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.taxbranch_id='$uid' and a.agreementtype_id='4000'";
     return $this->db->query($sql)->result();
 }

  function gethargasewa($uid){
  $sql="select  a.loodetil_descr+' (' +c.unit_name+' )' as titleharga,a.loodetil_baserent  from dbo.transaksi_loodetil a
     inner join transaksi_loo b on a.taxbranch_id=b.taxbranch_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.taxbranch_id='$uid' and a.agreementtype_id='4000' order by a.unit_id,a.loodetil_line asc";
    return $this->db->query($sql)->result();
 }

 function getservicecharge($uid){
  $sql="select SUM(loodetil_baserent) as servicecharge from transaksi_loodetil
  where taxbranch_id='$uid' and agreementtype_id='5000'";
  return $this->db->query($sql)->row_array();
 }

  function getpromolevy($uid){
  $sql="select SUM(loodetil_baserent) as promolevy from transaksi_loodetil
  where taxbranch_id='$uid' and agreementtype_id='6000'";
  return $this->db->query($sql)->row_array();
 }

  function getdepositr($uid){
  $sql="select loodetil_int as depositr,loodetil_baserent from transaksi_loodetil
  where taxbranch_id='$uid' and agreementtype_id='7000'";
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
            JOIN transaksi_loounit LOU ON LOU.taxbranch_id = LOH.taxbranch_id
            JOIN transaksi_loodetil LOD ON LOH.taxbranch_id = LOD.taxbranch_id
            JOIN master_region AS REGION ON LOU.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOU.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOU.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOU.rekanan_id = BRAND.rekanan_id AND LOU.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOU.region_id AND UNIT.branch_id = LOU.branch_id
          WHERE LOH.isapproved = '0' AND UNIT.unit_state <> '2' and LOH.unittype_id = 7  AND LOD.unit_id like '%{$uid}%'
          ORDER BY taxbranch_id desc ";

        return $this->db->query($sql)->result_array();
    }

 function viewconfprint($taxbranch_id){

     if (isset($taxbranch_id)){
        return $this->db->query("
           select top 1 LOO.taxbranch_id,LOO.conf_id, convert(varchar(10),taxbranch_date,120) AS taxbranch_date,
              convert(varchar(10),taxbranch_sdate,120) AS taxbranch_sdate, convert(varchar(10),taxbranch_edate,120) AS taxbranch_edate,
              taxbranch_term,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,c.rekanancontact_name,
        REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,REKAN.rekanan_address,REKAN.rekanan_city,
        l.lantai_name,u.unit_name,u.unit_sqm,d.loodetil_baserent

           from transaksi_loo AS LOO
       JOIN transaksi_loodetil d on LOO.taxbranch_id=d.taxbranch_id
       JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
        JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
        JOIN master_unit u on u.unit_id=d.unit_id
        JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOO.taxbranch_id='$taxbranch_id'
       ")->result();
   }

 }

}
