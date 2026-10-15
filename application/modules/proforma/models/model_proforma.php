<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_proforma extends CI_Model{
    
  function __construct(){
      parent::__construct();
  }

  function  get_region(){ 
        return $this->db->query("select * from master_region order by region_name asc")->result();
  }

  function  get_branchbyregion($region_id){ 
        return $this->db->query("
          select B.branch_name  
          from master_regionbranch A
              left join master_branch B ON A.branch_id = B.branch_id 
          where A.region_id = '$region_id' ")->result();
  }
 
  function get_agreement($region, $branch, $date){          

    $sql="
        select agreement_id, agreementdetil_unit, rekananshipping_name, isnull(rekananshipping_type, '') AS rekananshipping_type, agreementdetil_space, branch_namerpt,
          SUM(rental_rate) AS rental_rate, SUM(service_charge) AS service_charge, SUM(rental_income) AS rental_income, SUM(service_income) AS service_income
        from (
        select A.agreement_id, B.agreementdetil_unit, C.rekananshipping_name, C.rekananshipping_type, B.agreementdetil_space, D.branch_namerpt,
          B.agreementdetil_baserent AS rental_rate, 
          0 AS service_charge,
          (B.agreementdetil_baserent * B.agreementdetil_space) AS rental_income,
          0 AS service_income
        from transaksi_agreement A
          inner join transaksi_agreementdetil B ON A.agreement_id = B.agreement_id
          left join master_rekananshipping C ON C.rekanan_id = A.rekanan_id AND C.rekananshipping_line = A.rekananshipping_line
          left join master_branch D ON D.branch_id = A.branch_id
        where 
          --A.agreement_id = 'AGTRI1916100001' and
          agreementtype_id = '4000'
          and A.branch_id = '{$branch}'
          and B.agreementdetil_startdate <='{$date}' and B.agreementdetil_enddate >='{$date}'
        union all
        select A.agreement_id, B.agreementdetil_unit, C.rekananshipping_name, C.rekananshipping_type, B.agreementdetil_space, D.branch_namerpt,
          0 AS rental_rate, 
          B.agreementdetil_baserent AS service_charge,
          0 AS rental_income,
          (B.agreementdetil_baserent * B.agreementdetil_space) AS service_income
        from transaksi_agreement A
          inner join transaksi_agreementdetil B ON A.agreement_id = B.agreement_id
          left join master_rekananshipping C ON C.rekanan_id = A.rekanan_id AND C.rekananshipping_line = A.rekananshipping_line
          left join master_branch D ON D.branch_id = A.branch_id
        where
          --A.agreement_id = 'AGTRI1916100001' and
          agreementtype_id = '5000'
          and A.branch_id = '{$branch}'
          and B.agreementdetil_startdate <='{$date}' and B.agreementdetil_enddate >='{$date}'
        )#AG
        group by agreement_id, agreementdetil_unit, agreementdetil_space, rekananshipping_name, rekananshipping_type, branch_namerpt
        order by rekananshipping_type
    "; 
    return $this->db->query($sql)->result_array(); 
  }

  function get_summary($region, $branch, $date){

    $sql = "
        select rekananshipping_type, 
          SUM(agreementdetil_space) AS total_area, 
          branch_namerpt,
          SUM(rental_income) AS rental_income
        from (
        select isnull(C.rekananshipping_type, '') AS rekananshipping_type, B.agreementdetil_space, D.branch_namerpt,        
        (B.agreementdetil_baserent * B.agreementdetil_space) AS rental_income   
        from transaksi_agreement A
          inner join transaksi_agreementdetil B ON A.agreement_id = B.agreement_id
          left join master_rekananshipping C ON C.rekanan_id = A.rekanan_id AND C.rekananshipping_line = A.rekananshipping_line
          left join master_branch D ON D.branch_id = A.branch_id
        where           
          agreementtype_id = '4000'
          and A.branch_id = '{$branch}'
          and B.agreementdetil_startdate <= '{$date}' and B.agreementdetil_enddate >= '{$date}'
        )#AG
        group by rekananshipping_type, branch_namerpt
        order by rekananshipping_type
    ";
    return $this->db->query($sql)->result_array();
  }

  function get_servicesum($region, $branch, $date){
    $sql = "
        select 'service' as rekananshipping_type, 
          SUM(agreementdetil_space) AS total_area, 
          branch_namerpt,
          SUM(service_income) AS service_income
        from (
        select B.agreementdetil_space, D.branch_namerpt,        
        (B.agreementdetil_baserent * B.agreementdetil_space) AS service_income   
        from transaksi_agreement A
          inner join transaksi_agreementdetil B ON A.agreement_id = B.agreement_id
          left join master_rekananshipping C ON C.rekanan_id = A.rekanan_id AND C.rekananshipping_line = A.rekananshipping_line
          left join master_branch D ON D.branch_id = A.branch_id
        where           
          agreementtype_id = '5000'
          and A.branch_id = '{$branch}'
          and B.agreementdetil_startdate <= '{$date}' and B.agreementdetil_enddate >= '{$date}'
        )#AG
        group by branch_namerpt
    ";
    return $this->db->query($sql)->result_array();
  }
         
}