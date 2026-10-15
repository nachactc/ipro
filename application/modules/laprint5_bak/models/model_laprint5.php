<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_laprint5 extends CI_Model{
    
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

  function get_header($loo_id){   

     if (isset($loo_id)){
        return $this->db->query("
            select 
              distinct agreement_id, rekanan_name,rekanan_namereport, agreement_startdate, 
              _bra_.branch_namerpt as branch_name, _bran_.rekananshipping_name, 
              _agr_.agreement_loonumber,
              _agr_.agreement_startdate,
              _agr_.agreement_enddate,
              _agr_.agreement_term, _agr_.agreement_virtualaccount
            from transaksi_agreement _agr_         
              JOIN master_branch as _bra_ on _bra_.branch_id=_agr_.branch_id
              JOIN master_rekanan AS _rek_ ON _rek_.rekanan_id = _agr_.rekanan_id
              JOIN master_rekananshipping AS _bran_ ON _bran_.rekanan_id = _agr_.rekanan_id AND _agr_.rekananshipping_line = _bran_.rekananshipping_line
              LEFT JOIN master_rekanancontact as c on c.rekanan_id=_agr_.rekanan_id
            where agreement_loonumber = '$loo_id'
       ")->result();        
   }
  }

  function get_ruang($loo_id){

    if (isset($loo_id)){
      return $this->db->query("
        SELECT 'Ruang Sewa' as Ruang, AGD.agreementdetil_unit
        FROM transaksi_agreementdetil AGD
          JOIN transaksi_agreement AG ON AG.agreement_id = AGD.agreement_id
        WHERE AGD.agreementtype_id ='4000' and AG.agreement_loonumber = '{$loo_id}' and ISNULL(AGD.agreementdetil_unit,'') <> ''
        GROUP BY AGD.agreementdetil_unit          
      ")->result();
    }
  }  

  function get_area($loo_id){

    if (isset($loo_id)){
      return $this->db->query("
        SELECT 'Area' as Area, AGD.agreementdetil_unit, AGD.agreementdetil_space, AGD.agreementdetil_unitspot 
        FROM transaksi_agreementdetil AGD
          JOIN transaksi_agreement AG
        WHERE AGD.agreementtype_id ='4000' and AG.agreement_loonumber = '{$loo_id}' and ISNULL(AGD.agreementdetil_unit,'') <> ''
        GROUP BY AGD.agreementdetil_unit, AGD.agreementdetil_space, AGD.agreementdetil_unitspot
        ORDER BY AGD.agreementdetil_unitspot            
      ")->result();
    }
  }  
 
   function get_schedule($loo_id){   

     if (isset($loo_id)){
        $hasil =  $this->db->query("
            SELECT * from 
              (SELECT
                (CAST(_typ_.agreementtype_nourut as varchar(2))  +'|'+_typ_.agreementtype_ina) as sp_col
                ,_typ_.agreementtype_nourut as sp_urut
                ,convert(nvarchar(10), _sp_.[schedulepaymentdetil_date], 120) AS sp_date
                ,sum(isnull(_sp_.schedulepaymentdetil_amount,0)) AS sp_amount
                ,_agr_.agreement_startdate
              FROM v_agreement _agr_
                LEFT JOIN transaksi_schedulepaymentdetil _sp_ ON _agr_.agreement_id = _sp_.ref_id              
                LEFT JOIN master_agreementtype _typ_ ON _typ_.agreementtype_id = _sp_.agreementtype_id
              WHERE agreement_loonumber = '{$loo_id}'
                AND _sp_.agreementtype_id in (
                  '2000','2100','4000','20000','35000','7000','7500','7600','1000',
                  '7700','5000','5500','21000','21500','6000','6500','10000','10500')
              GROUP BY _typ_.agreementtype_ina, convert(nvarchar(10), _sp_.[schedulepaymentdetil_date], 120), 
                _typ_.agreementtype_nourut, _agr_.agreement_startdate
            )#sp_table
            order by sp_date
       ");
	   
	   //echo $this->db->last_query();exit;
	   return $hasil->result();        
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
  // $sql="select 
          // distinct c.unit_nameshort as unit_name,c.unit_sqm, d.lantai_name
        // from dbo.transaksi_loodetil a
        // inner join transaksi_loo b on a.loo_id=b.loo_id
        // inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
        // left join master_lantai d on d.lantai_id = c.lantai_id 
        // where a.loo_id='$uid' and (a.agreementtype_id='4000' or a.agreementtype_id='20000')"; 
		 $sql = "SELECT agreement_id,dbo.f_GetUnitName(agreement_id,1) as unit_sqm,dbo.f_GetUnitName(agreement_id,0) as unit_name,'' as lantai_name
		from v_agreement where agreement_loonumber = '$uid'";		
     return $this->db->query($sql)->result(); 
 }
 
  function gethargasewa($loo_id){
  $sql="
        SELECT 'Uang Sewa per Bulan' as Sewa, AGD.agreementdetil_unit, AGD.agreementdetil_space, 
          AGD.agreementdetil_unitspot, AGD.agreementdetil_baserent         
        FROM transaksi_agreementdetil AGD 
          JOIN transaksi_agreement AG ON AG.agreement_id = AGD.agreement_id       
        WHERE AGD.agreementtype_id ='4000' AND AG.agreement_loonumber = '$loo_id' AND ISNULL(AGD.agreementdetil_unit,'') <> ''
        GROUP BY AGD.agreementdetil_unit, AGD.agreementdetil_space, AGD.agreementdetil_unitspot, AGD.agreementdetil_baserent
        "; 
    return $this->db->query($sql)->result(); 
 }

 function gethargapromo($loo_id){
  $sql="select  
          _det_.agreementdetil_baserent
        from transaksi_agreement _agr_  
          inner join transaksi_agreementdetil _det_ on _agr_.agreement_id=_det_.agreement_id
          left join master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
        where _agr_.agreement_loonumber='$loo_id' 
          and (_det_.agreementtype_id='6000' or _det_.agreementtype_id='9000')"; 
    return $this->db->query($sql)->result(); 
 }
 
 function getservicecharge($loo_id){
  $sql="SELECT
          _det_.agreementdetil_baserent, 
          convert(varchar(10),_det_.agreementdetil_startdate,120) AS sdate,
          convert(varchar(10),_det_.agreementdetil_enddate,120) AS edate
        FROM transaksi_agreement _agr_  
          INNER JOIN transaksi_agreementdetil _det_ on _agr_.agreement_id=_det_.agreement_id
          LEFT JOIN master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
        WHERE _agr_.agreement_loonumber='$loo_id'
          AND (_det_.agreementtype_id in ('5000','5500','21000','21500'))"; 
  return $this->db->query($sql)->result(); 
 }
 
  function gettotallease($loo_id){
  $sql="SELECT
          agreement_tlv as total_lease
        FROM transaksi_agreement          
        WHERE agreement_loonumber='$loo_id'         
      "; 
  return $this->db->query($sql)->result(); 
 } 

  function getangsuran($loo_id){
  $sql="SELECT
          SUM(_det_.agreementdetil_installmentpayment) as angsuran
        FROM transaksi_agreement _agr_  
          INNER JOIN transaksi_agreementdetil _det_ on _agr_.agreement_id=_det_.agreement_id
          LEFT JOIN master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
        WHERE _agr_.agreement_loonumber='$loo_id'
          AND (_det_.agreementtype_id='4000' OR _det_.agreementtype_id='20000')
        GROUP BY agreementdetil_unit, agreementdetil_space"; 
  return $this->db->query($sql)->result_array(); 
 }

 function getdepe($loo_id){
  $sql="SELECT DISTINCT
          _typ_.agreementtype_ina  
          ,_det_.agreementdetil_startdate
          ,_det_.agreementdetil_percent
        FROM transaksi_agreement _agr_  
          INNER JOIN transaksi_agreementdetil _det_ on _agr_.agreement_id=_det_.agreement_id
          LEFT JOIN master_agreementtype _typ_ on _typ_.agreementtype_id = _det_.agreementtype_id 
          LEFT JOIN master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
        WHERE _agr_.agreement_loonumber='$loo_id'
          AND (_det_.agreementtype_id='2000' or _det_.agreementtype_id='1000')"; 
  return $this->db->query($sql)->result(); 
 }
 
  function getdeposit($loo_id){
  $sql="select
          _typ_.agreementtype_ina,
          _det_.agreementdeposit_duedate, 
          sum(_det_.agreementdeposit_idrsubtotal) as agreementdeposit_idrsubtotal
        from transaksi_agreement _agr_  
          inner join transaksi_agreementdeposit _det_ on _agr_.agreement_id=_det_.agreement_id
          left join master_agreementtype _typ_ on _typ_.agreementtype_id = _det_.agreementtype_id 
          left join master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdeposit_unit
        where _agr_.agreement_loonumber='$loo_id'
             and (_det_.agreementtype_id='7000' or _det_.agreementtype_id='7500' or _det_.agreementtype_id='7700' or _det_.agreementtype_id='7200')
        group by _typ_.agreementtype_ina, _det_.agreementdeposit_duedate"; 
  return $this->db->query($sql)->result(); 
 }

 function gettdep($loo_id){
  $sql="select
          _typ_.agreementtype_name,  
          _det_.agreementdeposit_idrsubtotal
        from transaksi_agreement _agr_  
          inner join transaksi_agreementdeposit _det_ on _agr_.agreement_id=_det_.agreement_id
          left join master_agreementtype _typ_ on _typ_.agreementtype_id = _det_.agreementtype_id 
          left join master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdeposit_unit
        where _agr_.agreement_loonumber='$loo_id'
          and (_det_.agreementtype_id='8000')"; 
  return $this->db->query($sql)->result(); 
 }

 function gethargafoodcourt($loo_id){
  $sql="select  
          _det_.agreementdetil_baserent, _det_.agreementdetil_mia
        from transaksi_agreement _agr_  
          inner join transaksi_agreementdetil _det_ on _agr_.agreement_id=_det_.agreement_id
          left join master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
        where _agr_.agreement_loonumber='$loo_id' 
          and (_det_.agreementtype_id='10000')"; 
    return $this->db->query($sql)->result(); 
 }
 
 function viewconfprint($loo_id){     
	$query = " select top 1 LOO.loo_id,LOO.conf_id, convert(varchar(10),loo_date,120) AS loo_date, 
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
           where LOO.loo_id='$loo_id'"; 
     if (isset($loo_id)){
        return $this->db->query($query)->result();        
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

 function get_header7($loo_id){
  $sql="select
          distinct
          _agr_.agreement_loonumber,
          _rek_.rekanan_name,
          _reks_.rekananshipping_name,
          _gion_.region_name,
          _gion_.region_id,
          penanggung_jawab, jabatan_pemilik, 
          penyewa, jabatan_penyewa,
          penyewa2, jabatan_penyewa2
        from transaksi_agreement _agr_        
          left join master_region _gion_ on _gion_.region_id = _agr_.region_id    
          left join master_rekanan _rek_ on _rek_.rekanan_id = _agr_.rekanan_id
          left join master_rekananshipping _reks_ on _reks_.rekanan_id = _agr_.rekanan_id AND _reks_.rekananshipping_line = _agr_.rekananshipping_line
          left join master_rekanancontact _ctc_ on _ctc_.rekanan_id = _rek_.rekanan_id
          left join master_laconfig _cfg on _cfg.loo_id = _agr_.agreement_loonumber
        where _agr_.agreement_loonumber='{$loo_id}'"; 
	// echo $sql;
	// exit;
  return $this->db->query($sql)->result(); 
 }
 

 function get_laconfig($loo_id){

  $sql = "select penanggung_jawab, jabatan_pemilik, penyewa, jabatan_penyewa, penyewa2, jabatan_penyewa2 
          from master_laconfig 
          where loo_id = '{$loo_id}'";

  return $this->db->query($sql)->result();
 }
     
    
}