<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_ivp extends CI_Model{
    
    function __construct(){
        parent::__construct();
		check_user_login();
		//ini_set("memory_limit","25M"); 
		//ini_set("memory_limit","500M");
    ini_set('memory_limit', '-1');
		ini_set("sqlsrv.ClientBufferMaxKBSize","524288");
		ini_set("pdo_sqlsrv.client_buffer_max_kb_size","524288");
    }
    	 	
	function set_Data($enddate, $username){
      //debugtest        

      try {

        sqlsrv_configure('WarningsReturnAsErrors', 0);
        $_SQL = " cp_RptInvoiceVSPayment '{$enddate}', '{$enddate}', '{$username}'; ";

        //echo ($_SQL);exit;
        $this->db->query($_SQL);
        $db_error = $this->db->error();

        if($db_error['code'] != 0) {
          throw new Exception('Database error! Error Code ['.$db_error['code'].'] Error: '.$db_error['message']);
          return false;
        }

        return true;

      } catch (Exception $ex) {            
        throw new Exception ($ex->getMessage());
        return;
      }

	}		

  function get_Count( $enddate, $username) {

      $_SQL = " SELECT count(doc_id) as count_rows FROM bi_invoicevspayment ";
      $result = $this->db->query($_SQL)->row();
      $count = $result->count_rows;  

      return $count;      
  }	

  function get_All( $enddate, $username ) {

      sqlsrv_configure('WarningsReturnAsErrors', 0);

      $qPart = "
        SELECT 
          doc_id, doc_type, doc_descr, doc_period, doc_date, doc_line,   
          faktur_no, pro_id, pro_period, pro_date, region_id, region_name, branch_id, branch_name, rekanan_id, rekanan_name,
          rekananshipping_line, rekananshipping_name, contract_no, grouptenant_id, rekananshipping_isactive, agreementtype_groupcollection,
          due, AMOUNT, transaksi_type, Aging_type, salesarea_id, COLL_IDR, All_id, All_date,
          OR_id, OR_type, OR_period, OR_date, tenant_type, p_status, c_status, Aging
        FROM  dbo.bi_invoicevspayment ";

      $record = $this->db->query($qPart)->result_array();
      
      return $record;
  }

  function get_Data( $enddate, $username, $start, $end ) {

      sqlsrv_configure('WarningsReturnAsErrors', 0);

      $qPart = "
        SELECT 
          doc_id, doc_type, doc_descr, doc_period, doc_date, doc_line,   
          faktur_no, pro_id, pro_period, pro_date, region_id, region_name, branch_id, branch_name, rekanan_id, rekanan_name,
          rekananshipping_line, rekananshipping_name, contract_no, grouptenant_id, rekananshipping_isactive, agreementtype_groupcollection,
          due, AMOUNT, transaksi_type, Aging_type, salesarea_id, COLL_IDR, All_id, All_date,
          OR_id, OR_type, OR_period, OR_date, tenant_type, p_status, c_status, Aging
        FROM  ( SELECT ROW_NUMBER() OVER(ORDER BY doc_id desc) AS row, 
                    doc_id, doc_type, doc_descr, doc_period, doc_date, doc_line,   
                    faktur_no, pro_id, pro_period, pro_date, region_id, region_name, branch_id, branch_name, rekanan_id, rekanan_name,
                    rekananshipping_line, rekananshipping_name, contract_no, grouptenant_id, rekananshipping_isactive, agreementtype_groupcollection,
                    due, AMOUNT, transaksi_type, Aging_type, salesarea_id, COLL_IDR, All_id, All_date,
                    OR_id, OR_type, OR_period, OR_date, tenant_type, p_status, c_status, Aging
                FROM dbo.bi_invoicevspayment ) BI
        WHERE BI.row >= $start AND  BI.row <= $end ";

      $record = $this->db->query($qPart)->result_array();
      
      return $record;
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