<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_simpay extends CI_Model{
    
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

  function get_simpay($region, $branch, $date){
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

  function get_loobyquery($crit){

        $this->db->select('L.loo_id as id, R.rekanan_id, R.rekanan_name, S.rekananshipping_line, S.rekananshipping_name');
        $this->db->from('transaksi_loo L');
        $this->db->join('master_rekanan R', 'R.rekanan_id = L.rekanan_id');
        $this->db->join('master_rekananshipping S', 'S.rekanan_id = L.rekanan_id and S.rekananshipping_line = L.rekananshipping_line');
        $this->db->where('L.isapproved', 0);
        $this->db->like('S.rekananshipping_name', $crit);
        $query = $this->db->get();

        return $query->result();
  }

  function get_tenantbyquery($crit){

        $this->db->select('R.rekanan_id, R.rekanan_name, S.rekananshipping_line, S.rekananshipping_name');
        $this->db->from('master_rekanan R');
        $this->db->join('master_rekananshipping S', 'S.rekanan_id = R.rekanan_id');
        $this->db->like('S.rekananshipping_name', $crit);
        $query = $this->db->get();

        return $query->result();
  }

  function get_simbyquery($crit){

        $this->db->select('loo_id as id, sim_tenant as tenant, S.branch_id, branch_name as store, S._createby as text');
        $this->db->from('transaksi_sim S');     
        $this->db->join('master_branch B', 'B.branch_id = S.branch_id');
        $this->db->like('loo_id', $crit);
        $query = $this->db->get();

        return $query->result();
  }

  function insertsim($id, $type, $space, $term, $payterm, $baserent, $totalrent, $fee_per, 
      $fee_val, $arp_per, $arp_val, $sc, $sc_val, $pl, $pl_val, $angsuran_bln, $payment_bln, 
      $depo_rent, $depo_sc, $depo_rent_val, $depo_sc_val, $tenant_val, $branch_id, $createby)
  {

        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);

        $this->db->query("DELETE FROM transaksi_sim WHERE loo_id='{$id}' and _createby ='{$createby}'");

        $this->db->query("
            INSERT INTO transaksi_sim
               (loo_id, sim_space, sim_term, sim_payterm, sim_baserent, sim_totalrent, sim_fee_per, sim_fee_val, 
                sim_arp_per, sim_arp_val, sim_sc, sim_sc_val, sim_pl, sim_pl_val, sim_angsuran, sim_payment, 
                sim_depo_rent, sim_depo_sc, sim_depo_rent_val, sim_depo_sc_val, sim_tenant, branch_id, _createby)
            VALUES
            ( '$id', $space, $term, $payterm, $baserent, $totalrent, $fee_per, $fee_val, 
              $arp_per, $arp_val, $sc, $sc_val, $pl, $pl_val, $angsuran_bln, $payment_bln, 
              $depo_rent, $depo_sc, $depo_rent_val, $depo_sc_val, '$tenant_val', '$branch_id', '$createby'
            )");
      
      return true;

  }

  function load_sim($id){

      $this->db->select('S.*, B.branch_name');
      $this->db->from('transaksi_sim S');
      $this->db->join('master_branch B', 'B.branch_id = S.branch_id');
      $this->db->where('loo_id', $id);
      $query = $this->db->get();

      return $query->result_array();
  }

         
}