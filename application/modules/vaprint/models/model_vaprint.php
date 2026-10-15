<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_vaprint extends CI_Model{
    
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
  
   function get_rekananshipping($id){          
    $stored_pocedure = "EXEC lm03_rekananshipping_idline '$id'";
    $result = $this->db->query($stored_pocedure);
    return $result->result();     
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
 
 //tambahan
   function getmastershippingarray($id){
    $sql="select * from master_rekananshipping  where rekanan_id +convert(varchar(5), rekananshipping_line) = '$id'"; 
    return $this->db->query($sql)->row_array(); 
  }
   function getmasterregionbranch_byid($id){
    $sql="select * from master_regionbranch   where branch_id = '$id'"; 
    return $this->db->query($sql)->row_array(); 
  }  
   function getVAperagrtype($rekanan_id, $rekananshipping_line, $agreementtype_id){
    $sql="select dbo.[f_get_va_by_rek]('$rekanan_id','$rekananshipping_line','$agreementtype_id') as VA "; 
    return $this->db->query($sql)->row_array(); 
  }  
  function getwebsetting($id){
    $sql="select * from web_setting
    where setting_id='$id'"; 
    return $this->db->query($sql)->row_array(); 
  }
  function getmastersetting($id){
    $sql="select * from master_setting
    where setting_id='$id'"; 
    return $this->db->query($sql)->row_array(); 
  }

  function viewinvprint($loo_id){     

    if (isset($loo_id)){
        return $this->db->query("
          SELECT top 1 
            LOO.loo_id, LOO.virtual_acc,LOO.total_payment,
            convert(varchar(10),loo_date,120) AS loo_date, 
            convert(varchar(10),loo_sdate,120) AS loo_sdate, 
            convert(varchar(10),loo_edate,120) AS loo_edate,    
            LOUN.loounit_space, LOOD.loodetil_baserent, LOOD.loodetil_term,LOOD.loodetil_mia,
            REG.region_name, REG.region_address,
            REK.rekanan_name, REK.rekanan_address, BRAN.rekananshipping_name, BRAN.rowid,
            BRA.branch_namerpt, UNIT.unit_nameshort as unit_name, UNIT.unit_sqm
          from transaksi_loo AS LOO 
          JOIN transaksi_loodetil LOOD on LOO.loo_id=LOOD.loo_id
          JOIN transaksi_loounit LOUN ON LOO.loo_id=LOUN.loo_id
          JOIN master_region AS REG ON REG.region_id = LOO.region_id
          JOIN master_branch as BRA on BRA.branch_id=LOO.branch_id
          JOIN master_rekanan AS REK ON REK.rekanan_id = LOO.rekanan_id
          JOIN master_rekananshipping AS BRAN ON BRAN.rekanan_id = LOO.rekanan_id AND BRAN.rekananshipping_line = LOO.rekananshipping_line  
          JOIN master_unit UNIT on UNIT.unit_id=LOOD.unit_id
          where LOO.loo_id='{$loo_id}' AND LOOD.agreementtype_id = '20000'; 
       ")->result();        
    }

  }

  function getdepe($loo_id){
    $sql="
    SELECT 
          loodetil_percent AS dp 
    FROM transaksi_loodetil 
    WHERE loo_id='{$loo_id}' and agreementtype_id='2000'"; 
    return $this->db->query($sql)->row_array(); 
  }
  
  function getmaster_setting($id){
  $sql="select * from master_setting
  where setting_id='$id' ";
  return $this->db->query($sql)->row_array();
 }

  function getmaster_branch($id){
   $sql="select * from master_branch
   where branch_id='$id' ";
   return $this->db->query($sql)->row_array();
  }
     
    
}