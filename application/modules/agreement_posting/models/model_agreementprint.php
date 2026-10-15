<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_agreementprint extends CI_Model{
    
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

    function get_header($_id){   

       if (isset($_id)){
          return $this->db->query("
              select 
                distinct agreement_id, rekanan_name, agreement_startdate, 
                _bra_.branch_namerpt as branch_name, _bran_.rekananshipping_name, 
                _agr_.agreement_loonumber,
                _agr_.agreement_contractlongnumber,
                _agr_.agreement_startdate,
                _agr_.agreement_enddate,
                _agr_.agreement_term, _agr_.agreement_virtualaccount
              from transaksi_agreement _agr_         
                JOIN master_branch as _bra_ on _bra_.branch_id=_agr_.branch_id
                JOIN master_rekanan AS _rek_ ON _rek_.rekanan_id = _agr_.rekanan_id
                JOIN master_rekananshipping AS _bran_ ON _bran_.rekanan_id = _agr_.rekanan_id AND _agr_.rekananshipping_line = _bran_.rekananshipping_line
                LEFT JOIN master_rekanancontact as c on c.rekanan_id=_agr_.rekanan_id
              where agreement_id = '$_id'
         ")->result();        
     }
    }

    function get_ruang($_id){

      if (isset($_id)){
        return $this->db->query("
          SELECT 'Ruang Sewa' as Ruang, AGD.agreementdetil_unit 
          FROM transaksi_agreementdetil AGD
            JOIN transaksi_agreement AG ON AG.agreement_id = AGD.agreement_id
          WHERE AGD.agreementtype_id ='4000' and AG.agreement_id = '{$_id}' and ISNULL(AGD.agreementdetil_unit,'') <> ''
          GROUP BY AGD.agreementdetil_unit          
        ")->result();
      }
    }      
   
     function get_schedule($_id){   

       if (isset($_id)){
          return $this->db->query("
              SELECT * from 
                (SELECT
                  (CAST(_typ_.agreementtype_nourut as varchar(2))  +'|'+_typ_.agreementtype_ina) as sp_col
                  ,_typ_.agreementtype_nourut as sp_urut
                  ,convert(nvarchar(10), _sp_.[schedulepaymentdetil_date], 120) AS sp_date
                  ,sum(isnull(_sp_.schedulepaymentdetil_amount,0)) AS sp_amount
                  ,_agr_.agreement_startdate
                FROM transaksi_agreement _agr_
                  LEFT JOIN transaksi_schedulepaymentdetil _sp_ ON _agr_.agreement_id = _sp_.ref_id              
                  LEFT JOIN master_agreementtype _typ_ ON _typ_.agreementtype_id = _sp_.agreementtype_id
                WHERE agreement_id = '{$_id}'
                  AND _sp_.agreementtype_id in (
                    '1000', '2000','2100','4000','20000','35000','7000','7500','7600',
                    '7700','5000','5500','21000','21500','6000','6500','10000','10500')
                GROUP BY _typ_.agreementtype_ina, convert(nvarchar(10), _sp_.[schedulepaymentdetil_date], 120), 
                  _typ_.agreementtype_nourut, _agr_.agreement_startdate
              )#sp_table
              order by sp_date
         ")->result();        
       }

     }
      
    function getunit($_id){
      $sql="
          SELECT 
            DISTINCT c.unit_nameshort as unit_name,c.unit_sqm, d.lantai_name
          FROM dbo.transaksi_agreementdetil a
            inner join transaksi_agreement b on a.agreement_id=b.agreement_id
            inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
            left join master_lantai d on d.lantai_id = c.lantai_id 
          WHERE b.agreement_id='$_id' AND (a.agreementtype_id='4000' OR a.agreementtype_id='20000')";  
      return $this->db->query($sql)->result(); 
    }
   
    function gethargasewa($_id){
      $sql="
          SELECT 'Uang Sewa per Bulan' as Sewa, AGD.agreementdetil_unit, AGD.agreementdetil_space, 
            AGD.agreementdetil_unitspot, AGD.agreementdetil_baserent         
          FROM transaksi_agreementdetil AGD 
            JOIN transaksi_agreement AG ON AG.agreement_id = AGD.agreement_id       
          WHERE AGD.agreementtype_id ='4000' AND AG.agreement_id = '$_id' AND ISNULL(AGD.agreementdetil_unit,'') <> ''
          GROUP BY AGD.agreementdetil_unit, AGD.agreementdetil_space, AGD.agreementdetil_unitspot, AGD.agreementdetil_baserent
          "; 
      return $this->db->query($sql)->result(); 
    }

    function gethargapromo($_id){
      $sql="
          SELECT  
            _det_.agreementdetil_baserent
          FROM transaksi_agreement _agr_  
            INNER JOIN transaksi_agreementdetil _det_ on _agr_.agreement_id=_det_.agreement_id
            LEFT JOIN master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
          WHERE _agr_.agreement_id='$_id' 
            AND (_det_.agreementtype_id='6000' OR _det_.agreementtype_id='9000')"; 
      return $this->db->query($sql)->result(); 
    }
   
   function getservicecharge($_id){
    $sql="SELECT
            _det_.agreementdetil_baserent, 
            convert(varchar(10),_det_.agreementdetil_startdate,120) AS sdate,
            convert(varchar(10),_det_.agreementdetil_enddate,120) AS edate
          FROM transaksi_agreement _agr_  
            INNER JOIN transaksi_agreementdetil _det_ on _agr_.agreement_id=_det_.agreement_id
            LEFT JOIN master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
          WHERE _agr_.agreement_id='$_id'
            AND (_det_.agreementtype_id in ('5000','5500','21000','21500'))"; 
    return $this->db->query($sql)->result(); 
   }
   
    function gettotallease($_id){
    $sql="SELECT
            agreement_tlv as total_lease
          FROM transaksi_agreement          
          WHERE agreement_id='$_id'         
        "; 
    return $this->db->query($sql)->result(); 
   } 

    function getangsuran($_id){
      $sql="SELECT
              SUM(_det_.agreementdetil_installmentpayment) as angsuran
            FROM transaksi_agreement _agr_  
              INNER JOIN transaksi_agreementdetil _det_ on _agr_.agreement_id=_det_.agreement_id
              LEFT JOIN master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
            WHERE _agr_.agreement_id='$_id'
              AND (_det_.agreementtype_id='4000' OR _det_.agreementtype_id='20000')
            GROUP BY agreementdetil_unit, agreementdetil_space"; 
      return $this->db->query($sql)->result_array(); 
    }

    function getdepe($_id){
      $sql="
          SELECT DISTINCT
            _typ_.agreementtype_ina  
            ,_det_.agreementdetil_startdate
            ,_det_.agreementdetil_percent
          FROM transaksi_agreement _agr_  
            INNER JOIN transaksi_agreementdetil _det_ on _agr_.agreement_id=_det_.agreement_id
            LEFT JOIN master_agreementtype _typ_ on _typ_.agreementtype_id = _det_.agreementtype_id 
            LEFT JOIN master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
          WHERE _agr_.agreement_id='$_id'
            AND (_det_.agreementtype_id='2000' or _det_.agreementtype_id='1000')"; 
      return $this->db->query($sql)->result(); 
    }
   
    function getdeposit($_id){
      $sql="
          SELECT
            _typ_.agreementtype_ina,
            _det_.agreementdeposit_duedate, 
            sum(_det_.agreementdeposit_idrsubtotal) as agreementdeposit_idrsubtotal
          FROM transaksi_agreement _agr_  
            INNER JOIN transaksi_agreementdeposit _det_ on _agr_.agreement_id=_det_.agreement_id
            LEFT JOIN master_agreementtype _typ_ on _typ_.agreementtype_id = _det_.agreementtype_id 
            LEFT JOIN master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdeposit_unit
          WHERE _agr_.agreement_id='$_id'
            and (_det_.agreementtype_id='7000' or _det_.agreementtype_id='7500')
          GROUP BY _typ_.agreementtype_ina, _det_.agreementdeposit_duedate"; 
      return $this->db->query($sql)->result(); 
    }

    function gettdep($_id){
      $sql="
          SELECT
            _typ_.agreementtype_name,  
            _det_.agreementdeposit_idrsubtotal
          FROM transaksi_agreement _agr_  
            INNER JOIN transaksi_agreementdeposit _det_ on _agr_.agreement_id=_det_.agreement_id
            LEFT JOIN master_agreementtype _typ_ on _typ_.agreementtype_id = _det_.agreementtype_id 
            LEFT JOIN master_unit _unit_ on _unit_.branch_id = _agr_.branch_id AND _unit_.unit_id=_det_.agreementdeposit_unit
          WHERE _agr_.agreement_id='$_id'
            AND (_det_.agreementtype_id='8000')"; 
      return $this->db->query($sql)->result(); 
    }

    function gethargafoodcourt($_id){
      $sql="SELECT  
            _det_.agreementdetil_baserent, _det_.agreementdetil_mia
          FROM transaksi_agreement _agr_  
            INNER JOIN transaksi_agreementdetil _det_ on _agr_.agreement_id=_det_.agreement_id
            LEFT JOIN master_unit _unit_ on _unit_.branch_id = _agr_.branch_id and _unit_.unit_id=_det_.agreementdetil_unit
          WHERE _agr_.agreement_id='$_id' 
            and (_det_.agreementtype_id='10000')"; 
      return $this->db->query($sql)->result(); 
    } 
    
}
