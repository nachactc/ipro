<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_loiprint extends CI_Model{
    
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
  
 
   function viewloiprint($loo_id){     

     if (isset($loo_id)){
        return $this->db->query("select  agreement_id,tanggal,number,kepada,alamat,mobile,email,toko,branch_area,lantai,unit,
CONVERT(DECIMAL(18,0),isnull(luas,0)) as luas,luas_terbilang,
CONVERT(DECIMAL(18,0),isnull(jangka,0)) as jangka,
jangka_terbilang,startdate,enddate,dagangan,
CONVERT(DECIMAL(18,0),isnull(fitting_out,0)) as fitting_out,
CONVERT(DECIMAL(18,0),isnull(grace_periode,0)) as grace_periode,
CONVERT(DECIMAL(18,0),isnull(uang_sewa,0)) as uang_sewa,
CONVERT(DECIMAL(18,0),isnull(total_sewa,0)) as total_sewa,
jml_instalment,
CONVERT(DECIMAL(18,0),isnull(DP_percent,0)) as DP_percent,CONVERT(DECIMAL(18,0),isnull(DP_value,0)) as DP_value,CONVERT(DECIMAL(18,0),isnull(sisa_jangka,0)) as sisa_jangka,CONVERT(DECIMAL(18,0),isnull(sisa_total_sewa,0)) as sisa_total_sewa,
CONVERT(DECIMAL(18,0),isnull(sisa_percent,0)) as sisa_percent,CONVERT(DECIMAL(18,0),isnull(biaya_food_levy,0)) as biaya_food_levy,CONVERT(DECIMAL(18,0),isnull(biaya_service,0)) as biaya_service,
CONVERT(DECIMAL(18,0),isnull(jml_deposit,0)) as jml_deposit, CONVERT(DECIMAL(18,0),isnull(deposit_value,0)) as deposit_value,angsuran1,angsuran2,angsuran3,angsuran4,
CONVERT(DECIMAL(18,0),isnull(telp_deposit,0)) as telp_deposit,CONVERT(DECIMAL(18,0),isnull(telp_service,0)) as telp_service,region_namereport,Print_LOI_Position1,
Print_LOI_Position1_name,Print_LOI_Position2,Print_LOI_Position2_name,TimeType,CONVERT(DECIMAL(18,0),isnull(jml_DP,0)) as jml_DP,CONVERT(DECIMAL(18,0),isnull(angsuran_DP,0)) as angsuran_DP,CONVERT(DECIMAL(18,0),isnull(angsuran_deposit,0)) as angsuran_deposit,CONVERT(DECIMAL(18,0),isnull(angsuran_deposit1,0)) as angsuran_deposit1,
angsuran_deposit2,angsuran_deposit3,region_address,detil_startdate,detil_enddate,agreementype_id,space,baserent,installment,term,
subtotal,detil_startdate1,detil_enddate1,agreementype_id1,space1,baserent1,installment1,term1,subtotal1,detil_startdate2,detil_enddate2,
agreementype_id2,space2,baserent2,installment2,term2,subtotal2,rekanan_pt,branch_namereport,CONVERT(DECIMAL(18,0),isnull(listrik,0)) as listrik,CONVERT(DECIMAL(18,0),isnull(listrik_total,0)) as listrik_total,
Utilities,is_Listrik,is_air,is_gas,jml_hari,jml_bulan,jml_tahun,isdisabled,rekanan_name,CONVERT(DECIMAL(18,0),isnull(biaya_listrik,0)) as biaya_listrik
from transaksi_agreement_printLOI 
           where  agreement_id='$loo_id'
       ")->result();        
	 }

   }
   
   
   function viewatmprint($loo_id){     

     if (isset($loo_id)){
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
    
 function getunitloi($uid){
  $sql="select top 1 agreement_id, unit from transaksi_agreement_printLOI
     where agreement_id='$uid'";  
     return $this->db->query($sql)->result(); 
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
  $sql="select unit from transaksi_agreement_printLOI where agreement_id='$uid' "; 
  return $this->db->query($sql)->row_array(); 
 }

  function getloiunit($uid){
  $sql="select unit from transaksi_agreement_printLOI where agreement_id='$uid' "; 
  return $this->db->query($sql)->row_array(); 
 }
  
 //tambahan
 
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
 
  function getregionidAT($id){
  $sql="select region_id from transaksi_agreementtemp
  where agreement_id='$id'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
  function getregionidAG($id){
  $sql="select region_id from transaksi_agreement
  where agreement_id='$id'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
  function getregionid($uid){
  $sql="select region_id from transaksi_agreement where agreement_id='$uid' "; 
  return $this->db->query($sql)->row_array(); 
 }
 
  function getmasterregion($id){
  $sql="select top 1 * from master_region where region_id = '$id'"; 
  return $this->db->query($sql)->row_array(); 
 }
  function getuangsewaAG($id){
  $sql="select * from transaksi_agreementdetil where agreement_id = '$id' and agreementtype_id ='4000'"; 
  return $this->db->query($sql)->row_array(); 
 }    
   function getuangsewaAT($id){
  $sql="select * from transaksi_agreementtempdetil where agreement_id = '$id' and agreementtype_id ='20000'"; 
  return $this->db->query($sql)->row_array(); 
 }   
  function getDPAG($id){
  $sql="select * from transaksi_agreementdetil where agreement_id = '$id' and agreementtype_id ='2000'"; 
  return $this->db->query($sql)->row_array(); 
 }    
   function getDPAT($id){
  $sql="select * from transaksi_agreementtempdetil where agreement_id = '$id' and agreementtype_id ='2000'"; 
  return $this->db->query($sql)->row_array(); 
 } 
  function getfoodlevyAG($id){
  $sql="select * from transaksi_agreementdetil where agreement_id = '$id' and agreementtype_id ='10000'"; 
  return $this->db->query($sql)->row_array(); 
 }    
   function getfoodlevyAT($id){
  $sql="select * from transaksi_agreementtempdetil where agreement_id = '$id' and agreementtype_id ='10000'"; 
  return $this->db->query($sql)->row_array(); 
 } 
  function getserviceAG($id){
  $sql="select * from transaksi_agreementdetil where agreement_id = '$id' and agreementtype_id ='5000'"; 
  return $this->db->query($sql)->row_array(); 
 }    
   function getserviceAT($id){
  $sql="select * from transaksi_agreementtempdetil where agreement_id = '$id' and agreementtype_id ='21000'"; 
  return $this->db->query($sql)->row_array(); 
 }
  function getdepositAG($id){
  $sql="select top 1 * from transaksi_agreementdeposit where agreement_id = '$id' and agreementtype_id in ('7000','7500')"; 
  return $this->db->query($sql)->row_array(); 
 }    
   function getdepositAT($id){
  $sql="select top 1 * from transaksi_agreementdeposit where agreement_id = '$id' and agreementtype_id in ('7000','7500')"; 
  return $this->db->query($sql)->row_array(); 
 }   
  function getsumdepositAG($id){
  $sql="select CONVERT(DECIMAL(18,0),isnull(sum(agreementdeposit_idr),0)) as agreementdeposit_idr from transaksi_agreementdeposit where agreement_id = '$id' and agreementtype_id in ('7000','7500')"; 
  return $this->db->query($sql)->row_array(); 
 }    
   function getsumdepositAT($id){
  $sql="select CONVERT(DECIMAL(18,0),isnull(sum(agreementdeposit_idr),0)) as agreementdeposit_idr from transaksi_agreementdeposit where agreement_id = '$id' and agreementtype_id in ('7000','7500')"; 
  return $this->db->query($sql)->row_array(); 
 }  
  function gettelpdepositAG($id){
  $sql="select CONVERT(DECIMAL(18,0),isnull(agreementdeposit_idrsubtotal,0)) as agreementdeposit_idr from transaksi_agreementdeposit where agreement_id = '$id' and agreementtype_id = '8000'"; 
  return $this->db->query($sql)->row_array(); 
 }    
   function gettelpdepositAT($id){
  $sql="select CONVERT(DECIMAL(18,0),isnull(agreementdeposit_idrsubtotal,0)) as agreementdeposit_idr from transaksi_agreementdeposit where agreement_id = '$id' and agreementtype_id = '8000'"; 
  return $this->db->query($sql)->row_array(); 
 } 
  function gettelpserviceAG($id){
  $sql="select CONVERT(DECIMAL(18,0),isnull(agreementdeposit_idr,0)) as agreementdeposit_idr from transaksi_agreementdeposit where agreement_id = '$id' and agreementtype_id = '7800'"; 
  return $this->db->query($sql)->row_array(); 
 }    
   function gettelpserviceAT($id){
  $sql="select CONVERT(DECIMAL(18,0),isnull(agreementdeposit_idr,0)) as agreementdeposit_idr from transaksi_agreementdeposit where agreement_id = '$id' and agreementtype_id = '7800'"; 
  return $this->db->query($sql)->row_array(); 
 } 
  function getagreementAG($id){
  $sql="select * from transaksi_agreement where agreement_id = '$id'"; 
  return $this->db->query($sql)->row_array(); 
 } 
  function getagreementAT($id){
  $sql="select * from transaksi_agreementtemp where agreement_id = '$id'"; 
  return $this->db->query($sql)->row_array(); 
 }  
  function getlistrikAG($id){
  $sql="select * from transaksi_agreementdetil where agreement_id = '$id' and agreementtype_id ='9500'"; 
  return $this->db->query($sql)->row_array(); 
 } 
  function getlistrikAT($id){
  $sql="select * from transaksi_agreementtempdetil where agreement_id = '$id' and agreementtype_id ='25500'"; 
  return $this->db->query($sql)->row_array(); 
 } 
}