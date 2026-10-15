<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_sop_gl extends CI_Model{

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
          select top $limit rekananshipping_line, rekananshipping_name, rekanan_id,
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

   function qry_alldatatenant($limit,$top,$sWhere){
      $qry="WITH CTE AS (
        select top $limit A.rekanan_id as rekanan_id, rekanan_name, branch_id,
          ROW_NUMBER() OVER (ORDER BY rekanan_name asc) as RowNumber
        from master_rekanan as A left join (select MAX(rekanan_id) as rekanan_id, MAX(branch_id) as branch_id from master_rekananshipping group by rekanan_id, branch_id ) as B
          ON A.rekanan_id = B.rekanan_id
        $sWhere )
      SELECT CTE.*
      FROM CTE
      WHERE RowNumber > $top";
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
     $sWhere = empty($sWhere) ? " WHERE schedulepaymentdetil_idr > 0 and invoice_id <> '' and schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1 " : $sWhere." AND schedulepaymentdetil_idr > 0 and invoice_id <> '' and schedulepaymentdetil_ischecked = 1 and schedulepaymentdetil_boisposted = 1  ";

	   $qry="
     SELECT * FROM (
     select top $limit B.region_id, CTE.*,ROW_NUMBER() OVER (ORDER BY CTE.schedulepayment_id desc) as RowNumber,
              REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, agreementtype_name, agreementtype_printouttype, B.branch_id, B.rekanan_id,
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
			  ORDER BY CTE.schedulepaymentdetil_date DESC
			  ) AS V
    	WHERE   RowNumber > $top";

	   //echo $qry;
	   //exit;
	    return $this->db->query($qry)->result_array();
   }

    function qry_filteredlist($sWhere){
       $sWhere = empty($sWhere) ? " WHERE schedulepaymentdetil_idr > 0 " : $sWhere." AND schedulepaymentdetil_idr > 0 ";
	   $qry="SELECT count(*) as jml FROM (
			select CTE.*,ROW_NUMBER() OVER (ORDER BY CTE.schedulepayment_id desc) as RowNumber,
						   REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, F.agreementtype_printouttype, B.region_id, B.branch_id, B.rekanan_id
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
		return $this->db->query($qry)->row_array();

   }

   function qry_totalalllist(){
	   $qry="select count(Schedulepayment_id) as jml from transaksi_schedulepaymentdetil where schedulepaymentdetil_idr > 0 ";
		return $this->db->query($qry)->row_array();

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





  function viewsop_gl($loo_id){

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

   function viewsop_glprint_header($where){

  $sql="
  select A.region_id,A.branch_id,A.rekanan_id,A.rekananshipping_line, A.branch_id + A.rekanan_id   + convert(varchar(5), A.rekananshipping_line) as branchrekananline, branch_name, rekanan_name, rekananshipping_name, region_name  from
  transaksi_schedulepayment as A
  inner join transaksi_schedulepaymentdetil as B
  on A.schedulepayment_id = B.schedulepayment_id
  inner join master_branch as C on A.branch_id = C.branch_id
  inner join master_rekanan as D on A.rekanan_id = D.rekanan_id
  inner join master_rekananshipping as E on A.rekanan_id = E.rekanan_id and A.rekananshipping_line = E.rekananshipping_line
  inner join master_region as F on A.region_id = F.region_id
  $where
 group by A.region_id,A.branch_id,A.rekanan_id,A.rekananshipping_line, branch_name, rekanan_name, rekananshipping_name, region_name
 order by branchrekananline";
     return $this->db->query($sql)->result();
   }

   function viewsop_glprint($startperiode, $endperiode, $enddate){

      $stored_pocedure = "EXEC SP03_Trnsop_VS_GL_Select '$startperiode','$endperiode','$enddate'";
	  //$stored_pocedure = "EXEC adm03_MstAcc_Select '',''";
    $result = $this->db->query($stored_pocedure);
    return $result->result();
   }

   public function get_data_sop_detil($where)
    {
    $stored_pocedure = "EXEC lm03_RptSOP_Ipro '$where'";
    $result = $this->db->query($stored_pocedure);
    return $result->result();
    }

    public function get_data_sop_header($where)
     {
     $stored_pocedure = "EXEC lm03_RptSOP_Ipro_H '$where'";
     $result = $this->db->query($stored_pocedure);
     return $result->result();
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

 public function get_year()
 {
   $StaringDate = date("Y-m-d");
   $ret = array();
   $year = date("Y", strtotime(date("Y-m-d", strtotime($StaringDate)) . " -1 year"));
   $ret[$year] = $year;
   for($x=0;$x<=1;$x++)
   {
     $year = date("Y", strtotime(date("Y-m-d", strtotime($StaringDate))));
     $ret[$year] = $year;
   }
   return $ret;
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
}
