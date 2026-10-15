<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_locprintbts extends CI_Model{
    
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
           select top 1 loc.loc_id, convert(varchar(10),loc_date,120) AS loc_date, 
              convert(varchar(10),loc_sdate,120) AS loc_sdate, convert(varchar(10),loc_edate,120) AS loc_edate,
              loc_term,loc.product_name,loc.fitting_out,loc.grace_period,loc.size_indoor,loc.size_outdoor,loc.branch_id, loc.rekanan_id, loc.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,BRAND.rekananshipping_contactname, BRAND.rekananshipping_address,c.rekanancontact_name,REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,branch.branch_namerpt,l.lantai_name,u.unit_nameshort as unit_name,u.unit_sqm,d.locdetil_baserent,d.locdetil_descr
           from transaksi_loc AS loc 
		   JOIN transaksi_locdetil d on loc.loc_id=d.loc_id
		   JOIN master_branch as branch on branch.branch_id=loc.branch_id
              JOIN master_rekanan AS REKAN ON loc.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON loc.rekanan_id = BRAND.rekanan_id AND loc.rekananshipping_line = BRAND.rekananshipping_line
			  LEFT JOIN master_rekanancontact as c on c.rekanan_id=loc.rekanan_id
			  JOIN master_unit u on u.unit_id=d.unit_id
			  JOIN master_lantai l on l.lantai_id=u.lantai_id
           where loc.loc_id='$loc_id'
       ")->result();        
	 }

   }
   
   
   function viewatmprint($loc_id){     

     if (isset($loc_id)){
        return $this->db->query("
           select top 1 loc.loc_id, convert(varchar(10),loc_date,120) AS loc_date,loc.loc_rent_desc,
              convert(varchar(10),loc_sdate,120) AS loc_sdate, convert(varchar(10),loc_edate,120) AS loc_edate,
              loc_term,loc.conf_id,loc.isapproved,
              loc.branch_id, loc.rekanan_id, loc.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name, BRAND.rekananshipping_address,c.rekanancontact_name,REKAN.rekanan_telp,REKAN.rekanan_address,REKAN.rekanan_email,branch.branch_name,l.lantai_name,u.unit_nameshort as unit_name,u.unit_sqm,d.locdetil_baserent,K.agreementtype_descr
           from transaksi_loc AS loc 
		   JOIN transaksi_locdetil d on loc.loc_id=d.loc_id
		   JOIN master_branch as branch on branch.branch_id=loc.branch_id
              JOIN master_rekanan AS REKAN ON loc.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON loc.rekanan_id = BRAND.rekanan_id AND loc.rekananshipping_line = BRAND.rekananshipping_line
			  LEFT JOIN master_rekanancontact as c on c.rekanan_id=loc.rekanan_id
			  JOIN master_unit u on u.unit_id=d.unit_id
			  JOIN master_lantai l on l.lantai_id=u.lantai_id
			  Left Join master_agreementtype K on d.agreementtype_id = K.agreementtype_id
           where loc.loc_id='$loc_id'
       ")->result();        
	 }

   }
   
    function viewbtsprint($loc_id){     

     if (isset($loc_id)){
        return $this->db->query("
           select top 1 loc.loc_id, convert(varchar(10),loc_date,120) AS loc_date, 
              convert(varchar(10),loc_sdate,120) AS loc_sdate, convert(varchar(10),loc_edate,120) AS loc_edate,
              loc_term,loc.ref_id,
              loc.branch_id, loc.rekanan_id, loc.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name, BRAND.rekananshipping_address,c.rekanancontact_name,REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,l.lantai_name,u.unit_nameshort as unit_name,u.unit_sqm,d.locdetil_baserent,d.locdetil_descr
           from transaksi_loc AS loc 
		   JOIN transaksi_locdetil d on loc.loc_id=d.loc_id
		   JOIN master_branch as branch on branch.branch_id=loc.branch_id
              JOIN master_rekanan AS REKAN ON loc.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON loc.rekanan_id = BRAND.rekanan_id AND loc.rekananshipping_line = BRAND.rekananshipping_line
			 LEFT JOIN master_rekanancontact as c on c.rekanan_id=loc.rekanan_id
			  JOIN master_unit u on u.unit_id=d.unit_id
			  JOIN master_lantai l on l.lantai_id=u.lantai_id
           where loc.loc_id='$loc_id'
       ")->result();        
	 }

   }
    function dataprintconf($uid){

        $sql = " 
          SELECT DISTINCT LOH.*, REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, UNIT.unit_name, LOD.unit_id 
          FROM transaksi_loc LOH
            JOIN transaksi_locdetil LOD ON LOH.loc_id = LOD.loc_id
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
 
   function getdepositrsc($uid){
  $sql="select SUM(locdetil_baserent) as depositrsc from transaksi_locdetil 
  where loc_id='$uid' and agreementtype_id in ('7000','7500')"; 
  return $this->db->query($sql)->row_array(); 
 }
 
 function gettelponidr($uid){
  $sql="select  locdetil_baserent from transaksi_locdetil 
  where loc_id='$uid' and agreementtype_id='9200'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
 function gettelpondeposit($uid){
  $sql="select  locdetil_baserent from transaksi_locdetil 
  where loc_id='$uid' and agreementtype_id='8000'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
 function gettelponinstal($uid){
  $sql="select  locdetil_baserent from transaksi_locdetil 
  where loc_id='$uid' and agreementtype_id='9810'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
 function viewconfprint($loc_id){     

     if (isset($loc_id)){
        return $this->db->query("
           select top 1 loc.loc_id,loc.conf_id, convert(varchar(10),loc_date,120) AS loc_date, 
              convert(varchar(10),loc_sdate,120) AS loc_sdate, convert(varchar(10),loc_edate,120) AS loc_edate,
              loc_term,
              loc.branch_id, loc.rekanan_id, loc.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,c.rekanancontact_name,
        REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,REKAN.rekanan_address,REKAN.rekanan_city,
        l.lantai_name,u.unit_name,u.unit_sqm,d.locdetil_baserent
        
           from transaksi_loc AS loc 
       JOIN transaksi_locdetil d on loc.loc_id=d.loc_id
       JOIN master_branch as branch on branch.branch_id=loc.branch_id
              JOIN master_rekanan AS REKAN ON loc.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON loc.rekanan_id = BRAND.rekanan_id AND loc.rekananshipping_line = BRAND.rekananshipping_line
        JOIN master_rekanancontact as c on c.rekanan_id=loc.rekanan_id
        JOIN master_unit u on u.unit_id=d.unit_id
        JOIN master_lantai l on l.lantai_id=u.lantai_id
           where loc.loc_id='$loc_id'
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
     
    
}