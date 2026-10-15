<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_tdr extends CI_Model{
    
    function __construct(){
        parent::__construct();
		check_user_login();
		//ini_set("memory_limit","25M"); 
		//ini_set("memory_limit","500M");
		ini_set("sqlsrv.ClientBufferMaxKBSize","524288");
		ini_set("pdo_sqlsrv.client_buffer_max_kb_size","524288");
    }
    	 	

  function get_region($region_name="")
	{  
      $this->db->select('r.region_id, r.region_name');
      $this->db->from('master_region r'); 

      if($region_name != '')
      {  
        $this->db->like('r.region_name', $region_name); 
      }
        $query = $this->db->get();

        $result = $query->result(); 
        return $result; 		
  }    

	function get_Data($BEG_BAL_DATE, $startdate, $enddate, $criteria)
	{
      //debugtest
      //$criteria = '';
      //debug_backtrace      
      $_SQL = "
      /* SUMMARY TRANSAKSI */
      SELECT B.jurnal_id, B.jurnal_bookdate, A.rekanan_id AS REKAN_ID, A.region_id AS REGION_ID, A.branch_id AS BRANCH_ID, 
            REG.region_name AS UNIT, BRA.branch_name AS STORE, RES.rowid AS CONTRACT_NO, 
            REK.rekanan_name AS TENANT, RES.rekananshipping_name AS BRAND, A.ACC_ID, ACC.ACC_NAME, SUM(A.jurnaldetil_idr) as AMOUNT      
      FROM transaksi_jurnaldetil A 
            inner join transaksi_jurnal B ON A.jurnal_id = B.jurnal_id
            left join master_region REG ON REG.region_id = A.region_id 
            left join master_branch BRA ON BRA.branch_id = A.branch_id 
            left join master_rekanan REK ON REK.rekanan_id = A.rekanan_id
            left join master_rekananshipping RES ON RES.rekanan_id = A.rekanan_id AND RES.rekananshipping_line = A.rekananshipping_line 
            left join master_acc ACC ON ACC.acc_id = A.acc_id
      WHERE    
                B.jurnal_isposted = 1            
            AND (convert(nvarchar(10),B.jurnal_bookdate,120) >= '{$startdate}' AND convert(nvarchar(10),B.jurnal_bookdate,120) <= '{$enddate}')
            AND {$criteria}
      GROUP BY B.jurnal_id, B.jurnal_bookdate, A.rekanan_id, A.region_id, A.branch_id, REG.region_name, 
               BRA.branch_name, RES.rowid, REK.rekanan_name, RES.rekananshipping_name, A.acc_id, ACC.acc_name 
      ORDER BY B.jurnal_bookdate ASC";
    
      //echo ($_SQL);exit;
      $result = $this->db->query($_SQL);
      //$temp = $result->result();      
      
      if($result->num_rows() > 0)
      {
        return $result->result();
      }
      else
      {
        return 'kosong';
      }
		 
	}			
	  
	function get_MasterSettingValue($setting_id)
	{
      $this->db->select('setting_value');
      $this->db->where('setting_id',$setting_id);
      $hasil = $this->db->get('master_setting');
      if($hasil->num_rows() > 0)
      {
        return $hasil->row();
      }
      else
      {
        return 'kosong';
      }
	}		
   
}