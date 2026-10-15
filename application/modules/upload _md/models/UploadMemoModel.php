<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_upload extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
 
  function qry_alldatalist($limit,$top,$sWhere){
     $sWhere = empty($sWhere) ? " WHERE  isdisabled = 0 " : $sWhere." AND isdisabled = 0 ";
//inner join transaksi_agreement_printLOI w on x.agreement_id=w.agreement_id $sWhere
	   $qry="WITH CTE AS (
 				select top $limit a.*,x.agreement_id,ROW_NUMBER() OVER (ORDER BY a.loo_id desc) as RowNumber 
	from transaksi_loo a inner join transaksi_agreement x on a.loo_id=x.agreement_loonumber $sWhere
	union
	select top $limit a.*,x.agreement_id,ROW_NUMBER() OVER (ORDER BY a.loo_id desc) as RowNumber 
	from transaksi_loo a inner join transaksi_agreementtemp x on a.loo_id=x.agreement_loonumber $sWhere
	
	)
		SELECT 
		
	  [loo_id]
      ,CTE.[loo_descr]
      ,CTE.[loo_date]
      ,CTE.[loo_sdate]
      ,CTE.[loo_edate]
      ,CTE.[loo_term]
      ,CTE.[loo_type]
      ,CTE.[loo_pict]
      ,CTE.[_createby]
      ,CTE.[_createdate]
      ,CTE.[_modifyby]
      ,CTE.[_modifydate]
      ,CTE.[isapproved]
      ,CTE.[isconfirm]
      ,CTE.[isdisabled]
      ,CTE.[rent_type]
      ,CTE.[region_id]
      ,CTE.[branch_id]
      ,CTE.[rekanan_id]
      ,CTE.[rekananshipping_line]
      ,CTE.[conf_id]
      ,CTE.[unittype_id]
      ,CTE.[skl_id]
      ,CTE.[ref_id]
      ,CTE.[ismulti]
      ,CTE.[loo_rent_desc],CTE.[agreement_id]
	  ,REGION.region_nameshort,REGION.region_address, BRANCH.branch_name, REKAN.rekanan_name,REKAN.rekanan_address, BRAND.rekananshipping_name
    FROM CTE   
	  LEFT JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
      LEFT JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
      LEFT JOIN master_rekanan AS REKAN ON CTE.rekanan_id = REKAN.rekanan_id
      LEFT JOIN master_rekananshipping AS BRAND ON CTE.rekanan_id = BRAND.rekanan_id AND CTE.rekananshipping_line = BRAND.rekananshipping_line
    WHERE CTE.RowNumber > $top";
	
	   return $this->db->query($qry)->result_array();	 
	   
   }
   
   function qry_alldatalistrn($limit,$top,$sWhere){
     $sWhere = empty($sWhere) ? " WHERE  isdisabled = 0 " : $sWhere." AND isdisabled = 0 ";
//inner join transaksi_agreement_printLOI w on x.agreement_id=w.agreement_id $sWhere
	   $qry="WITH CTE AS (
 				select top $limit a.*,x.agreement_id,ROW_NUMBER() OVER (ORDER BY a.loo_id desc) as RowNumber 
	from transaksi_loo a inner join transaksi_agreement x on a.loo_id=x.agreement_loonumber $sWhere
	union
	select top $limit a.*,x.agreement_id,ROW_NUMBER() OVER (ORDER BY a.loo_id desc) as RowNumber 
	from transaksi_loo a inner join transaksi_agreementtemp x on a.loo_id=x.agreement_loonumber $sWhere
	
	)
		SELECT 
		
	  [loo_id]
      ,CTE.[loo_descr]
      ,CTE.[loo_date]
      ,CTE.[loo_sdate]
      ,CTE.[loo_edate]
      ,CTE.[loo_term]
      ,CTE.[loo_type]
      ,CTE.[loo_pict]
      ,CTE.[_createby]
      ,CTE.[_createdate]
      ,CTE.[_modifyby]
      ,CTE.[_modifydate]
      ,CTE.[isapproved]
      ,CTE.[isconfirm]
      ,CTE.[isdisabled]
      ,CTE.[rent_type]
      ,CTE.[region_id]
      ,CTE.[branch_id]
      ,CTE.[rekanan_id]
      ,CTE.[rekananshipping_line]
      ,CTE.[conf_id]
      ,CTE.[unittype_id]
      ,CTE.[skl_id]
      ,CTE.[ref_id]
      ,CTE.[ismulti]
      ,CTE.[loo_rent_desc],CTE.[agreement_id]
	  ,REGION.region_nameshort,REGION.region_address, BRANCH.branch_name, REKAN.rekanan_name,REKAN.rekanan_address, BRAND.rekananshipping_name
    FROM CTE   
	  LEFT JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
      LEFT JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
      LEFT JOIN master_rekanan AS REKAN ON CTE.rekanan_id = REKAN.rekanan_id
      LEFT JOIN master_rekananshipping AS BRAND ON CTE.rekanan_id = BRAND.rekanan_id AND CTE.rekananshipping_line = BRAND.rekananshipping_line
    WHERE CTE.RowNumber > $top";
	
	   return $this->db->query($qry)->result_array();	 
	   
   }
   
    function qry_filteredlist($sWhere){
$sWhere = empty($sWhere) ? " WHERE  a.isdisabled = 0 " : $sWhere." AND a.isdisabled = 0 ";
	 $qry="select count(a.loo_id) as jml from transaksi_loo a inner join transaksi_agreement x
on a.loo_id=x.agreement_loonumber $sWhere";
$rqry1=$this->db->query($qry)->row_array();
$tot1=$rqry1['jml'];

$qry="select count(a.loo_id) as jml from transaksi_loo a inner join transaksi_agreementtemp x
on a.loo_id=x.agreement_loonumber $sWhere";
$rqry2=$this->db->query($qry)->row_array();
$tot2=$rqry2['jml'];

$hasil=$tot1+$tot2;

	 return $hasil;	   
   }
   
   function qry_contactname($looid){
	   $qry="select  top 1 d.rekanancontact_name from transaksi_loo a inner join master_rekanan b on a.rekanan_id=b.rekanan_id inner join
master_rekanancontact d on d.rekanan_id=b.rekanan_id WHERE a.loo_id='$looid'
";
		return $this->db->query($qry)->row_array();	   
   }
   
   function qry_getflbyid($looid){
	   $qry="select top 1 c.lantai_name from transaksi_loo a inner join transaksi_loounit b
on a.loo_id=b.loo_id inner join master_lantai c on b.lantai_id=c.lantai_id
WHERE a.loo_id='$looid'";
	return $this->db->query($qry)->row_array();	   
   }
   
      function qry_getflbyidrn($looid){
	   $qry="select top 1 c.lantai_name from transaksi_loc a inner join transaksi_locunit b
on a.loc_id=b.loc_id inner join master_lantai c on b.lantai_id=c.lantai_id
WHERE a.loc_id='$looid'";
	return $this->db->query($qry)->row_array();	   
   }
   
 function qry_getshipname($loid){  
 $qry="select  b.rekananshipping_name from transaksi_loo a inner join
master_rekananshipping b on b.rekanan_id=a.rekanan_id and b.rekananshipping_line=a.rekananshipping_line
 WHERE a.loo_id='$loid' ";
 return $this->db->query($qry)->row_array(); 
 }
 
  function qry_getshipnamern($loid){  
 $qry="select  b.rekananshipping_name from transaksi_loc a inner join
master_rekananshipping b on b.rekanan_id=a.rekanan_id and b.rekananshipping_line=a.rekananshipping_line
 WHERE a.loc_id='$loid' ";
 return $this->db->query($qry)->row_array(); 
 }
 
    function qry_totalalllist(){
		$sWhere = empty($sWhere) ? " WHERE  a.isdisabled = 0 " : $sWhere." AND a.isdisabled = 0 ";
	   $qry="select count(a.loo_id) as jml from transaksi_loo a inner join transaksi_agreement b
on a.loo_id=b.agreement_loonumber $sWhere";
$r1=$this->db->query($qry)->row_array();
$tot1=$r1['jml'];

$qry="select count(a.loo_id) as jml from transaksi_loo a inner join transaksi_agreementtemp b
on a.loo_id=b.agreement_loonumber $sWhere";
$r2=$this->db->query($qry)->row_array();
$tot2=$r2['jml'];
$hasil=$tot1+$tot2;

		return $hasil;   
   }
   
   function qry_getbranchshort($loid){
	   $qry="select b.branch_nameshort from transaksi_loo a inner join master_branch b 
on a.branch_id=b.branch_id WHERE loo_id='$loid'";
		return $this->db->query($qry)->row_array();  
   }
   
      function qry_getbranchshortrn($loid){
	   $qry="select b.branch_nameshort from transaksi_loc a inner join master_branch b 
on a.branch_id=b.branch_id WHERE loc_id='$loid'";
		return $this->db->query($qry)->row_array();  
   }
   
   
    function qry_getsewa($looid){
	   $qry="select b.agreementdetil_baserent,b.agreementdetil_totalleaseunitrate from transaksi_agreement a inner join transaksi_agreementdetil b
on a.agreement_id=b.agreement_id
where a.agreement_loonumber='$looid' and b.agreementtype_id='4000'";
		return $this->db->query($qry)->row_array();   
   }
   
function qry_getpercendp($looid){
	   $qry="select top 1 sum(a.agreementdetil_percent) as agreementdetil_percent from transaksi_agreementdetil a
inner join transaksi_agreement b on a.agreement_id=b.agreement_id
where b.agreement_loonumber='$looid' and a.agreementtype_id='2000'
group by a.agreementdetil_unit ";
		return $this->db->query($qry)->row_array();   
   }
   
      
function qry_getrupdp($looid){
	   $qry="select agreementdetil_mia from transaksi_agreementdetil a
inner join transaksi_agreement b on a.agreement_id=b.agreement_id
where b.agreement_loonumber='$looid' and a.agreementtype_id='2000' ";
		return $this->db->query($qry)->row_array();   
   }
   
   function qry_getintdp($looid){
	   $qry="select sum(agreementdetil_installmentpayment) as instaldp from transaksi_agreementdetil a
inner join transaksi_agreement b on a.agreement_id=b.agreement_id
where b.agreement_loonumber='$looid' and a.agreementtype_id='2000' ";
		return $this->db->query($qry)->row_array();   
   }
 
  function viewloo($loo_id){     
        return $this->db->query("
          select top 1 loo_id
		   , convert(varchar(10),loo_date,120) AS loo_date, loo_type, unittype_id, loo_descr, skl_id,
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term, loo._createby, loo._createdate, loo._modifyby, loo._modifydate, loo.region_id, loo.isapproved, loo.isconfirm,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line,LOO.product_name,LOO.fitting_out,LOO.grace_period, BRANCH.branch_name, BRANCH.branch_address, BRANCH.branch_namerpt, REKAN.rekanan_name,REKAN.rekanan_address, BRAND.rekananshipping_name,LOO.loo_rent_desc,LOO.ismulti,LOO.conf_id,LOO.ispenawaran
,r.region_namereport,r.region_address,r.region_telp,r.region_fax,x.agreement_term,x.agreement_dayterm,BRAND.rekananshipping_contactname,REKAN.taxsign_id,REKAN.rekanan_taxnik,REKAN.rekanan_telp,REKAN.rekanan_email,BRAND.rekananshipping_address,BRAND.rekananshipping_contactemail,BRAND.rekananshipping_contacthp 
           from transaksi_loo AS LOO 
           inner join transaksi_agreement x on loo.loo_id=x.agreement_loonumber
           inner join master_region r on r.region_id=LOO.region_id
             LEFT JOIN master_branch AS BRANCH ON LOO.branch_id = BRANCH.branch_id
             LEFT JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
             LEFT JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line where LOO.loo_id='$loo_id' 
			 union
			  select top 1 loo_id
		   , convert(varchar(10),loo_date,120) AS loo_date, loo_type, unittype_id, loo_descr, skl_id,
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term, loo._createby, loo._createdate, loo._modifyby, loo._modifydate, loo.region_id, loo.isapproved, loo.isconfirm,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line,LOO.product_name,LOO.fitting_out,LOO.grace_period, BRANCH.branch_name, BRANCH.branch_address, BRANCH.branch_namerpt, REKAN.rekanan_name,REKAN.rekanan_address, BRAND.rekananshipping_name,LOO.loo_rent_desc,LOO.ismulti,LOO.conf_id,LOO.ispenawaran
,r.region_namereport,r.region_address,r.region_telp,r.region_fax,x.agreement_term,x.agreement_dayterm,BRAND.rekananshipping_contactname,REKAN.taxsign_id,REKAN.rekanan_taxnik,REKAN.rekanan_telp,REKAN.rekanan_email,BRAND.rekananshipping_address,BRAND.rekananshipping_contactemail,BRAND.rekananshipping_contacthp 
           from transaksi_loo AS LOO 
           inner join transaksi_agreementtemp x on loo.loo_id=x.agreement_loonumber
           inner join master_region r on r.region_id=LOO.region_id
             LEFT JOIN master_branch AS BRANCH ON LOO.branch_id = BRANCH.branch_id
             LEFT JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
             LEFT JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line where LOO.loo_id='$loo_id' 
       ")->result();  

       return $result;
     }
	 
	 function viewloorn($loo_id){     
        return $this->db->query("
            select top 1 loo_id
		   , convert(varchar(10),loo_date,120) AS loo_date, loo_type, unittype_id, loo_descr, skl_id,
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term, loo._createby, loo._createdate, loo._modifyby, loo._modifydate, loo.region_id, loo.isapproved, loo.isconfirm,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line,LOO.product_name,LOO.fitting_out,LOO.grace_period, BRANCH.branch_name, BRANCH.branch_address, BRANCH.branch_namerpt, REKAN.rekanan_name,REKAN.rekanan_address, BRAND.rekananshipping_name,LOO.loo_rent_desc,LOO.ismulti,LOO.conf_id,LOO.ispenawaran
,r.region_namereport,r.region_address,r.region_telp,r.region_fax,x.agreement_term,x.agreement_dayterm,BRAND.rekananshipping_contactname,REKAN.taxsign_id,REKAN.rekanan_taxnik,REKAN.rekanan_telp,REKAN.rekanan_email
           from transaksi_loo AS LOO 
           inner join transaksi_agreement x on loo.loo_id=x.agreement_loonumber
           inner join master_region r on r.region_id=LOO.region_id
             LEFT JOIN master_branch AS BRANCH ON LOO.branch_id = BRANCH.branch_id
             LEFT JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
             LEFT JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line where LOO.loo_id='$loo_id' 
			 union
			  select top 1 loo_id
		   , convert(varchar(10),loo_date,120) AS loo_date, loo_type, unittype_id, loo_descr, skl_id,
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term, loo._createby, loo._createdate, loo._modifyby, loo._modifydate, loo.region_id, loo.isapproved, loo.isconfirm,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line,LOO.product_name,LOO.fitting_out,LOO.grace_period, BRANCH.branch_name, BRANCH.branch_address, BRANCH.branch_namerpt, REKAN.rekanan_name,REKAN.rekanan_address, BRAND.rekananshipping_name,LOO.loo_rent_desc,LOO.ismulti,LOO.conf_id,LOO.ispenawaran
,r.region_namereport,r.region_address,r.region_telp,r.region_fax,x.agreement_term,x.agreement_dayterm,BRAND.rekananshipping_contactname,REKAN.taxsign_id,REKAN.rekanan_taxnik,REKAN.rekanan_telp,REKAN.rekanan_email
           from transaksi_loo AS LOO 
           inner join transaksi_agreementtemp x on loo.loo_id=x.agreement_loonumber
           inner join master_region r on r.region_id=LOO.region_id
             LEFT JOIN master_branch AS BRANCH ON LOO.branch_id = BRANCH.branch_id
             LEFT JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
             LEFT JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line where LOO.loo_id='$loo_id' 
       ")->result();  

       return $result;
     }
	 
	 
   function sholdetilby_id($id){          
        $sql = "
          SELECT LD.*, UNIT.unit_name AS unit_name, LT.lantai_name AS lantai_name, AT.agreementtype_name AS agreementtype_name
          FROM transaksi_loodetil LD 
            JOIN master_unit UNIT ON UNIT.unit_id = LD.unit_id
            JOIN master_lantai LT ON LT.lantai_id = LD.lantai_id
            JOIN master_agreementtype AT ON AT.agreementtype_id = LD.agreementtype_id
          WHERE loo_id = '$id'";  
    return $this->db->query($sql)->result();      
  }
  
 
   function viewlooprint($loo_id){     

     if (isset($loo_id)){
        return $this->db->query("
           select top 1 LOO.loo_id, convert(varchar(10),loo_date,120) AS loo_date, 
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name, BRAND.rekananshipping_address,c.rekanancontact_name,REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,l.lantai_name,u.unit_nameshort as unit_name,u.unit_sqm,d.loodetil_baserent
           from transaksi_loo AS LOO 
		   JOIN transaksi_loodetil d on LOO.loo_id=d.loo_id
		   JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
			  LEFT JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
			  JOIN master_unit u on u.unit_id=d.unit_id
			  JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOO.loo_id='$loo_id'
       ")->result();        
	 }

   }
   
   
   function viewatmprint($loo_id){     

     if (isset($loo_id)){
        return $this->db->query("
           select top 1 LOO.loo_id, convert(varchar(10),loo_date,120) AS loo_date,LOO.loo_rent_desc,
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term,LOO.conf_id,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name, BRAND.rekananshipping_address,c.rekanancontact_name,REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,l.lantai_name,u.unit_nameshort as unit_name,u.unit_sqm,d.loodetil_baserent
           from transaksi_loo AS LOO 
		   JOIN transaksi_loodetil d on LOO.loo_id=d.loo_id
		   JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
			  LEFT JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
			  JOIN master_unit u on u.unit_id=d.unit_id
			  JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOO.loo_id='$loo_id'
       ")->result();        
	 }

   }
   
    function viewbtsprint($loo_id){     

     if (isset($loo_id)){
        return $this->db->query("
           select top 1 LOO.loo_id, convert(varchar(10),loo_date,120) AS loo_date, 
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term,LOO.ref_id,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name, BRAND.rekananshipping_address,c.rekanancontact_name,REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,l.lantai_name,u.unit_nameshort as unit_name,u.unit_sqm,d.loodetil_baserent,d.loodetil_descr
           from transaksi_loo AS LOO 
		   JOIN transaksi_loodetil d on LOO.loo_id=d.loo_id
		   JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
			 LEFT JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
			  JOIN master_unit u on u.unit_id=d.unit_id
			  JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOO.loo_id='$loo_id'
       ")->result();        
	 }

   }
    function dataprintconf($uid){

        $sql = " 
          SELECT DISTINCT LOH.*, REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, UNIT.unit_name, LOD.unit_id 
          FROM transaksi_loo LOH
            JOIN transaksi_loodetil LOD ON LOH.loo_id = LOD.loo_id
            JOIN master_region AS REGION ON LOH.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOH.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOH.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOH.rekanan_id = BRAND.rekanan_id AND LOH.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id
          WHERE LOH.isapproved = '0' AND LOH.isconfirm = '1' AND LOD.unit_id like '%{$uid}%' ";    

        return $this->db->query($sql)->result_array();
    }
    
 function getunitloo($uid){
  $sql="select distinct c.unit_nameshort as unit_name,c.unit_sqm from dbo.transaksi_loodetil a
     inner join transaksi_loo b on a.loo_id=b.loo_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.loo_id='$uid' and (a.agreementtype_id='4000' or a.agreementtype_id='20000')";  
     return $this->db->query($sql)->result(); 
 }
 
 
 
  function gethargasewarn($uid){
  $sql="select top 1 a.agreementdetil_mia,b.agreement_term from dbo.transaksi_agreementdetil a
     inner join transaksi_agreement b  on a.agreement_id=b.agreement_id 
	 inner join transaksi_loc c on b.agreement_loonumber=c.loc_id
     where b.agreement_loonumber='$uid' and (a.agreementtype_id='4000' or a.agreementtype_id='20000')";  
      return $this->db->query($sql)->row_array();
 }
 
   function getlooidrn($uid){
  $sql="select ref_id from transaksi_loc
     where loc_id='$uid'";  
      return $this->db->query($sql)->row_array();
 }
 
  function gethargasewa($uid){
  $sql="select  a.loodetil_descr+' (' +c.unit_name+' )' as titleharga,a.loodetil_baserent  from dbo.transaksi_loodetil a
     inner join transaksi_loo b on a.loo_id=b.loo_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.loo_id='$uid' and (a.agreementtype_id='4000' or a.agreementtype_id='20000') order by a.unit_id,a.loodetil_line asc"; 
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
 
function getitemagreement($uid){
  $sql="select a.loodetil_baserent,b.agreementtype_name,a.loodetil_descr,a.loodetil_ispercent as loodetil_percent  from transaksi_loodetil a
inner join master_agreementtype b on a.agreementtype_id=b.agreementtype_id
where a.loo_id='$uid' and a.agreementtype_id NOT IN ('4000','20000','2000')  order by  a.loodetil_line "; 
  return $this->db->query($sql)->result(); 
 }
 
 function getitemagreementatm($uid){
  $sql="select b.agreementtype_id,a.loodetil_baserent,b.agreementtype_name,a.loodetil_descr,a.loodetil_ispercent as loodetil_percent  from transaksi_loodetil a
inner join master_agreementtype b on a.agreementtype_id=b.agreementtype_id
where a.loo_id='$uid' and a.agreementtype_id NOT IN ('4000','2000') order by  a.loodetil_line"; 
  return $this->db->query($sql)->result(); 
 }
 
  function getloodesc($uid){
  $sql="select loo_descr from transaksi_loo where loo_id='$uid' "; 
  return $this->db->query($sql)->row_array(); 
 }
 
  function get_loibyid($loo){
	   $qry="select b.* from transaksi_agreement a inner join transaksi_agreement_printLOI b
on a.agreement_id=b.agreement_id and a.agreement_loonumber ='$loo'";
	return $this->db->query($qry)->row_array();	   
   }
   
     function get_countrentloi($loo){
	   $qry="select COUNT(a.agreement_id) as jumlah from transaksi_agreementdetil_printLOI a inner join transaksi_agreement b
on  a.agreement_id=b.agreement_id 
 where  b.agreement_loonumber ='$loo'";
	return $this->db->query($qry)->row_array();	   
   }
   
   function get_detilloirent($loo){
	  /* $qry=" select a.* from transaksi_agreementdetil_printLOI a inner join transaksi_agreement b
on  a.agreement_id=b.agreement_id 
 where  b.agreement_loonumber ='$loo' order by detil_startdate asc";*/
	   $qry="select a.* from transaksi_agreementdetil a inner join transaksi_agreement b
on  a.agreement_id=b.agreement_id 
 where  b.agreement_loonumber ='$loo' 
 and a.agreementtype_id IN ('4000')
 order by a.agreementdetil_startdate asc";
	return $this->db->query($qry)->result();	   
   }
   
      function get_totalrent($loo){
	   $qry="select sum(a.agreementdetil_totalleaserent) as totalrent from transaksi_agreementdetil a inner join transaksi_agreement b
on  a.agreement_id=b.agreement_id 
 where  b.agreement_loonumber ='$loo' 
 and a.agreementtype_id IN ('4000')";
	return $this->db->query($qry)->row_array();   
   }
   
    function get_totalrentindoor($loo){
	   $qry="select sum(a.agreementdetil_totalleaserent) as totalrent from transaksi_agreementdetil a inner join transaksi_agreement b
on  a.agreement_id=b.agreement_id 
 where  b.agreement_loonumber ='$loo' 
 and a.agreementtype_id IN ('4000') and a.agreementdetil_unitspot IN ('Indoor')";
	return $this->db->query($qry)->row_array();   
   }
   
   function get_totalrentoutdoor($loo){
	   $qry="select sum(a.agreementdetil_totalleaserent) as totalrent from transaksi_agreementdetil a inner join transaksi_agreement b
on  a.agreement_id=b.agreement_id 
 where  b.agreement_loonumber ='$loo' 
 and a.agreementtype_id IN ('4000') and a.agreementdetil_unitspot IN ('Outdoor')";
	return $this->db->query($qry)->row_array();   
   }
   
   
      function get_cekarea($loo){
	   $qry="select COUNT(a.agreementdetil_unitspot) as jmlcek from transaksi_agreementdetil a inner join transaksi_agreement b
on  a.agreement_id=b.agreement_id 
where  b.agreement_loonumber ='$loo' 
and a.agreementtype_id IN ('4000')  and a.agreementdetil_unitspot IN ('Indoor')";
	$totindor=$this->db->query($qry)->row_array(); 
	$totindor=$totindor['jmlcek'];  
	
	$qry="select COUNT(a.agreementdetil_unitspot) as jmlcek from transaksi_agreementdetil a inner join transaksi_agreement b
on  a.agreement_id=b.agreement_id 
where  b.agreement_loonumber ='$loo' 
and a.agreementtype_id IN ('4000')  and a.agreementdetil_unitspot IN ('Outdoor')";
	$totoutdor=$this->db->query($qry)->row_array(); 
	$totoutdor=$totoutdor['jmlcek'];  
	$hasil=$totoutdor+$totindor;
	return $hasil;
   }
   
    function get_totaldeposit($looid){
	 	$qry=" select SUM(niltotal) as niltotal from(select sum(agreementdeposit_idrsubtotal) as niltotal from  transaksi_agreementdeposit a inner join transaksi_agreement b
on  a.agreement_id=b.agreement_id 
 where  b.agreement_loonumber ='$looid' and a.agreementtype_id IN ('7000','7500','7700')
 union
 select sum(agreementdeposit_idrsubtotal) as niltotal from  transaksi_agreementdeposit a inner join transaksi_agreementtemp b
on  a.agreement_id=b.agreement_id 
 where  b.agreement_loonumber ='$looid' and a.agreementtype_id IN ('7000','7500','7700')) b
 ";
	 	return $this->db->query($qry)->row_array();	   
   }
   
   function get_detilloirentsingle($loo){
	   $qry=" select top 1 a.* from transaksi_agreementdetil_printLOI a inner join transaksi_agreement b
on  a.agreement_id=b.agreement_id 
 where  b.agreement_loonumber ='$loo' order by detil_startdate asc";
	return $this->db->query($qry)->row_array();	   
   }
    
	
	 function get_intvpelayanan($looid){
	 $qry="select sum(intvpelayanan) as intvpelayanan from (select max(a.agreementdetil_interval) as intvpelayanan from transaksi_agreementdetil a
inner join transaksi_agreement b on a.agreement_id=b.agreement_id
where a.agreementtype_id IN ('5000','5500')
and b.agreement_loonumber='$looid'
union
select max(a.agreementdetil_interval) as intvpelayanan from transaksi_agreementtempdetil a
inner join transaksi_agreementtemp b on a.agreement_id=b.agreement_id
where a.agreementtype_id IN ('5000','5500')
and b.agreement_loonumber='$looid') b
";

	 return $this->db->query($qry)->row_array();	   
   }
   
   function get_nilaipelayanan($looid){
	 $qry="select top 1 a.agreementdetil_baserent from transaksi_agreementdetil a
inner join transaksi_agreement b on a.agreement_id=b.agreement_id
where a.agreementtype_id IN ('5000','5500')
and b.agreement_loonumber='$looid' order by a.agreementdetil_startdate asc";
	 return $this->db->query($qry)->row_array();	   
   }
   
   function get_nilaipromosi($looid){
	 $qry="select top 1 a.agreementdetil_baserent from transaksi_agreementdetil a
inner join transaksi_agreement b on a.agreement_id=b.agreement_id
where a.agreementtype_id IN ('6000','6500')
and b.agreement_loonumber='$looid' order by a.agreementdetil_startdate asc";
	 return $this->db->query($qry)->row_array();	   
   }
   
      function get_nilaigplv($looid){
	 $qry="select top 1 a.agreementdetil_mia from transaksi_agreementdetil a
inner join transaksi_agreement b on a.agreement_id=b.agreement_id
where a.agreementtype_id='9000'
and b.agreement_loonumber='$looid' order by a.agreementdetil_startdate asc";
	 return $this->db->query($qry)->row_array();	   
   }
   
    function get_nilaifood($looid){
	 $qry="select top 1 a.agreementdetil_baserent from transaksi_agreementdetil a
inner join transaksi_agreement b on a.agreement_id=b.agreement_id
where a.agreementtype_id IN ('10000','10500')
and b.agreement_loonumber='$looid' order by a.agreementdetil_startdate asc";
	 return $this->db->query($qry)->row_array();	   
   }
    
	 function get_laedit($looid){
	 	$qry="select * from master_laconfig where loo_id='$looid'";
	 	return $this->db->query($qry)->row_array();	   
   }
   
   function mdl_lasave($loo_id,$txtpemegang1,$txtpemegang2,$txtdewankomisaris,$txtkomut,$txtkomisaris,$txtaggotadir,$txtdirut,$txtdirektur,$txtfitout,$xloo_id,$txttggjawab,$txtjabatanjawab,$txtjabatansewa,$txtdatettd,$tuangsewa,$tbiayaservice,$txtjenisusaha,$txtmerkdagang,
$txtgrace,$txtpenyewa){
	   if (strlen(trim($loo_id)) < 1){
	 	$qry="INSERT INTO master_laconfig
(loo_id,pemegang_saham1,pemegang_saham2,dewan_komisaris,komisaris_utama,komisaris,anggota_direksi,direktur_utama,direktur,pemberitahuan_ftout,penanggung_jawab,jabatan_pemilik,jabatan_penyewa,tgl_sign,uangsewa,uangservice,jenisusaha,merkdagang,graceperiod,penyewa)
VALUES ('$xloo_id','$txtpemegang1','$txtpemegang2','$txtdewankomisaris','$txtkomut','$txtkomisaris','$txtaggotadir','$txtdirut','$txtdirektur','$txtfitout','$txttggjawab','$txtjabatanjawab','$txtjabatansewa','$txtdatettd','$tuangsewa','$tbiayaservice','$txtjenisusaha','$txtmerkdagang','$txtgrace','$txtpenyewa')";

	   }else{
		 $qry="update master_laconfig set pemegang_saham1='$txtpemegang1',pemegang_saham2='$txtpemegang2',dewan_komisaris='$txtdewankomisaris',
komisaris_utama='$txtkomut',komisaris='$txtkomisaris',anggota_direksi='$txtaggotadir',
direktur_utama='$txtdirut',direktur='$txtdirektur',pemberitahuan_ftout='$txtfitout',penanggung_jawab='$txttggjawab',jabatan_pemilik='$txtjabatanjawab',jabatan_penyewa='$txtjabatansewa',tgl_sign='$txtdatettd',uangsewa='$tuangsewa',uangservice='$tbiayaservice'
,jenisusaha='$txtjenisusaha',merkdagang='$txtmerkdagang',graceperiod='$txtgrace',penyewa='$txtpenyewa'
 where loo_id='$loo_id'";  
	   }
	 	return $this->db->query($qry);	   
   }
   
    function getnumfile($loo_id){
	   $qry="select count(loo_id) as jml from master_uploadloo WHERE loo_id='$loo_id'";
		return $this->db->query($qry)->row_array();  
   }
   
   function savedataimg($loo_id,$agrrement_id,$nama_file,$tipe,$description){
	   $qry="insert into master_uploadloo(loo_id,agrrement_id,nama_file,tipe,description) values('$loo_id','$agrrement_id','$nama_file','$tipe','$description')";
		return $this->db->query($qry);  
   }
    
	function deleteupload($looid,$agid,$nama,$tipe){
		$looid = str_replace('_', '/', $looid);
	   $qry="delete from master_uploadloo WHERE loo_id='$looid' and agrrement_id='$agid' and nama_file='$nama' and tipe='$tipe'";
		return $this->db->query($qry);  
   }
   function showupload($looid,$agid,$tipe){
	   $qry="select * from master_uploadloo WHERE loo_id='$looid' and agrrement_id='$agid' and tipe='$tipe'";
		return $this->db->query($qry)->result();  
   }
}