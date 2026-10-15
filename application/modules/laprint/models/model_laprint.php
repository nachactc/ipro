<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_laprint extends CI_Model{
    
    function __construct(){
        parent::__construct();
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
  
   function get_LaNoFromAgreement($loo_id)
   {
		$query = "SELECT DISTINCT * FROM (
		select TOP 1 agreement_lanumber from transaksi_agreement
		where agreement_loonumber = '$loo_id'
		union
		select TOP 1 agreement_lanumber from transaksi_agreement
		where agreement_loonumber = '$loo_id'
		) AS V				  
		WHERE ISNULL(agreement_lanumber,'') <> ''
		GROUP BY  agreement_lanumber";
		$hasil =  $this->db->query($query)->row();
		//echo $this->db->last_query();
	    return $hasil;
		
   }
	
   function viewlooprint($loo_id){     
 
     if (isset($loo_id)){
		 
        // $query =  "
           // select top 1 LOO.loo_id, convert(varchar(10),loo_date,120) AS loo_date, 
              // convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              // loo_term,
              // LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name, BRAND.rekananshipping_address,c.rekanancontact_name,REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,l.lantai_name,u.unit_nameshort as unit_name,u.unit_sqm,d.loodetil_baserent,REKAN.grouptenant_id,
			  // ISNULL(BRAND.rekananshipping_type,'') as rekananshipping_type,k.rekananshippingtype_name,BRAND.rekananshipping_contacttelp
           // from transaksi_loo AS LOO 
		   // JOIN transaksi_loodetil d on LOO.loo_id=d.loo_id
		   // JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              // JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              // JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
			  // LEFT JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
			  // JOIN master_unit u on u.unit_id=d.unit_id
			  // JOIN master_lantai l on l.lantai_id=u.lantai_id
			   // LEFT JOIN master_rekananshippingtype k on BRAND.rekananshipping_type = k.rekananshippingtype_id
           // where LOO.loo_id='$loo_id'
       // ";  
	   $query =  " 
 select		 
LOO.loo_id, 
convert(varchar(10),loo_date,120) AS loo_date, 
convert(varchar(10),loo_sdate,120) AS loo_sdate, 
convert(varchar(10),loo_edate,120) AS loo_edate,
loo_term,
LOO.branch_id, LOO.rekanan_id, 
LOO.rekananshipping_line, 
REKAN.rekanan_name,
BRAND.rekananshipping_name, 
BRAND.rekananshipping_address,
c.rekanancontact_name,
REKAN.rekanan_telp,
REKAN.rekanan_email,
branch.branch_name,
--l.lantai_name,
n.agreementdetil_unit as unit_name,
n.agreementdetil_space as unit_sqm,		   
REKAN.grouptenant_id,
ISNULL(BRAND.rekananshipping_type,'') as rekananshipping_type,z.unittype_name as rekananshippingtype_name,BRAND.rekananshipping_contacttelp
from transaksi_loo AS LOO 
JOIN transaksi_loodetil d on LOO.loo_id=d.loo_id
JOIN master_branch as branch on branch.branch_id=LOO.branch_id
JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
LEFT JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
LEFT JOIN master_unittype z on LOO.unittype_id = z.unittype_id
LEFT JOIN master_rekananshippingtype k on LOO.unittype_id = k.rekananshippingtype_id
LEFT JOIN v_agreement m on m.agreement_loonumber = LOO.loo_id --and m.agreement_isapproved = 1 and m.agreement_isclosed = 0
	LEFT JOIN (SELECT DISTINCT agreement_id,unit_id,agreementdetil_unit,agreementdetil_space FROM transaksi_agreementdetil 
	union 
	SELECT DISTINCT agreement_id,unit_id,agreementdetil_unit,agreementdetil_space FROM transaksi_agreementtempdetil) n on m.agreement_id = n.agreement_id
--JOIN master_unit u on u.unit_id=n.unit_id
--JOIN master_lantai l on l.lantai_id=u.lantai_id
where LOO.loo_id='$loo_id'								   
group by LOO.loo_id,  loo_date,loo_sdate, loo_edate,  loo_term,LOO.branch_id, LOO.rekanan_id, 
LOO.rekananshipping_line, 
REKAN.rekanan_name,
BRAND.rekananshipping_name, 
BRAND.rekananshipping_address,
c.rekanancontact_name,
REKAN.rekanan_telp,
REKAN.rekanan_email,
branch.branch_name,   
REKAN.grouptenant_id,BRAND.rekananshipping_type,z.unittype_name,BRAND.rekananshipping_contacttelp,n.agreementdetil_unit,n.agreementdetil_space 
       ";
	   // 
	   // exit;
	  $hasil =  $this->db->query($query)->row();
	   return $hasil;
	  // echo $this->db->last_query(); 
	   
	   // echo var_dump($hasil);
	   // exit;
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
        l.lantai_name,u.unit_name,u.unit_sqm,d.loodetil_baserent,
		REKAN.grouptenant_id,BRAND.rekananshipping_type 
           from transaksi_loo AS LOO 
       JOIN transaksi_loodetil d on LOO.loo_id=d.loo_id
       JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
        JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
        JOIN master_unit u on u.unit_id=d.unit_id
        JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOO.loo_id='$loo_id'
       ")->row();        
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
  
    
}