<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_locprint extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
 
   function sholdetilby_id($id){          
        $sql = "
          SELECT LD.*, UNIT.unit_name AS unit_name, LT.lantai_name AS lantai_name, AT.agreementtype_name AS agreementtype_name
          FROM transaksi_locdetil LD 
            JOIN master_unit UNIT ON UNIT.unit_id = LD.unit_id
            JOIN master_lantai LT ON LT.lantai_id = LD.lantai_id
            JOIN master_agreementtype AT ON AT.agreementtype_id = LD.agreementtype_id
          WHERE loc_id = '$id'";  
    return $this->db->query($sql)->result();      
  }
  
 
   function viewlocprint($loc_id){     

     if (isset($loc_id)){
        return $this->db->query("
          SELECT top 1 LOC.loc_id, convert(varchar(10),loc_date,120) AS loc_date, 
            convert(varchar(10),loc_sdate,120) AS loc_sdate, convert(varchar(10),loc_edate,120) AS loc_edate,            
            loc_term,LOC.product_name,LOC.fitting_out,LOC.grace_period,LOC.size_indoor,LOC.size_outdoor,
            LOC.branch_id, LOC.rekanan_id, LOC.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,            
            BRAND.rekananshipping_contactname, BRAND.rekananshipping_address,c.rekanancontact_name,REKAN.rekanan_telp,
            REKAN.rekanan_email,branch.branch_name,branch.branch_namerpt,l.lantai_name, REG.region_namereport,
            u.unit_nameshort as unit_name,u.unit_sqm,d.locdetil_baserent
          FROM transaksi_loc AS LOC 
          JOIN transaksi_locdetil d on LOC.loc_id=d.loc_id
          JOIN master_region REG on REG.region_id = LOC.region_id
          JOIN master_branch as branch on branch.branch_id=LOC.branch_id
          JOIN master_rekanan AS REKAN ON LOC.rekanan_id = REKAN.rekanan_id
          JOIN master_rekananshipping AS BRAND ON LOC.rekanan_id = BRAND.rekanan_id 
            AND LOC.rekananshipping_line = BRAND.rekananshipping_line
          LEFT JOIN master_rekanancontact as c on c.rekanan_id=LOC.rekanan_id
          JOIN master_unit u on u.unit_id=d.unit_id
          JOIN master_lantai l on l.lantai_id=u.lantai_id
          WHERE LOC.loc_id='$loc_id'
       ")->result();        
	 }

   }
   
   
   function viewatmprint($loc_id){     

     if (isset($loc_id)){
        return $this->db->query("
           select top 1 LOO.loo_id, convert(varchar(10),loo_date,120) AS loo_date,LOO.loo_rent_desc,
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term,LOO.conf_id,LOO.isapproved,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name, BRAND.rekananshipping_address,c.rekanancontact_name,REKAN.rekanan_telp,REKAN.rekanan_address,REKAN.rekanan_email,branch.branch_name,l.lantai_name,u.unit_nameshort as unit_name,u.unit_sqm,d.loodetil_baserent,K.agreementtype_descr
           from transaksi_loo AS LOO 
		   JOIN transaksi_loodetil d on LOO.loo_id=d.loo_id
		   JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
			  LEFT JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
			  JOIN master_unit u on u.unit_id=d.unit_id
			  JOIN master_lantai l on l.lantai_id=u.lantai_id
			  Left Join master_agreementtype K on d.agreementtype_id = K.agreementtype_id
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
    
 function getunitloc($uid){
  $sql="select distinct c.unit_nameshort as unit_name,c.unit_sqm from dbo.transaksi_locdetil a
     inner join transaksi_loc b on a.loc_id=b.loc_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.loc_id='$uid' and (a.agreementtype_id='4000' or a.agreementtype_id='20000')";  
     return $this->db->query($sql)->result(); 
 }
 
  function gethargasewa($uid){
  $sql="select  a.locdetil_descr+' (' +c.unit_name+' )' as titleharga,a.locdetil_baserent  from dbo.transaksi_locdetil a
     inner join transaksi_loc b on a.loc_id=b.loc_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.loc_id='$uid' and (a.agreementtype_id='4000' or a.agreementtype_id='20000') order by a.unit_id,a.locdetil_line asc"; 
    return $this->db->query($sql)->result(); 
 }
 
 function getservicecharge($uid){
  $sql="select SUM(locdetil_baserent) as servicecharge from transaksi_locdetil 
  where loc_id='$uid' and agreementtype_id='5000'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
  function getpromolevy($uid){
  $sql="select SUM(locdetil_baserent) as promolevy from transaksi_locdetil 
  where loc_id='$uid' and agreementtype_id='6000'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
  function getdepositr($uid){
  $sql="select locdetil_int as depositr,locdetil_baserent from transaksi_locdetil 
  where loc_id='$uid' and agreementtype_id='7000'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
 function viewconfprint($loc_id){     

     if (isset($loc_id)){
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
  $sql="select a.locdetil_baserent,b.agreementtype_name,a.locdetil_descr,a.locdetil_ispercent as locdetil_percent  from transaksi_locdetil a
inner join master_agreementtype b on a.agreementtype_id=b.agreementtype_id
where a.loc_id='$uid' and a.agreementtype_id NOT IN ('4000','20000','2000')  order by  a.locdetil_line "; 
  return $this->db->query($sql)->result(); 
 }
 
 function getitemagreementatm($uid){
  $sql="select b.agreementtype_id,a.locdetil_baserent,b.agreementtype_name,a.locdetil_descr,a.locdetil_ispercent as locdetil_percent  from transaksi_locdetil a
inner join master_agreementtype b on a.agreementtype_id=b.agreementtype_id
where a.loc_id='$uid' and a.agreementtype_id NOT IN ('4000','2000') order by  a.locdetil_line"; 
  return $this->db->query($sql)->result(); 
 }
 
  function getlocdesc($uid){
  $sql="select loc_descr from transaksi_loc where loc_id='$uid' "; 
  return $this->db->query($sql)->row_array(); 
 }
 
 //tambahan
 
  function getwebsetting($id){
  $sql="select * from web_setting
  where setting_id='$id'"; 
  return $this->db->query($sql)->row_array(); 
 }

 function viewinvprint($loc_id){     

    if (isset($loc_id)){
        return $this->db->query("
          SELECT top 1 
            LOO.loc_id, LOO.virtual_acc,
            convert(varchar(10),loc_date,120) AS loc_date, 
            convert(varchar(10),loc_sdate,120) AS loc_sdate, 
            convert(varchar(10),loc_edate,120) AS loc_edate,    
            LOUN.locunit_space, LOOD.locdetil_baserent, LOOD.locdetil_term,
            REG.region_name, REG.region_address,
            REK.rekanan_name, REK.rekanan_address, BRAN.rekananshipping_name, BRAN.rowid,
            BRA.branch_namerpt, UNIT.unit_nameshort as unit_name, UNIT.unit_sqm
          from transaksi_loc AS LOO 
          JOIN transaksi_locdetil LOOD on LOO.loc_id=LOOD.loc_id
          JOIN transaksi_locunit LOUN ON LOO.loc_id=LOUN.loc_id
          JOIN master_region AS REG ON REG.region_id = LOO.region_id
          JOIN master_branch as BRA on BRA.branch_id=LOO.branch_id
          JOIN master_rekanan AS REK ON REK.rekanan_id = LOO.rekanan_id
          JOIN master_rekananshipping AS BRAN ON BRAN.rekanan_id = LOO.rekanan_id AND BRAN.rekananshipping_line = LOO.rekananshipping_line  
          JOIN master_unit UNIT on UNIT.unit_id=LOOD.unit_id
          where LOO.loc_id='{$loc_id}' AND LOOD.agreementtype_id = '4000'; 
       ")->result();        
    }

  }

  function getdepe($loc_id){
    $sql="
    SELECT 
          locdetil_percent AS dp 
    FROM transaksi_locdetil 
    WHERE loc_id='{$loc_id}' and agreementtype_id='2000'"; 
    return $this->db->query($sql)->row_array(); 
  }
     
    
}