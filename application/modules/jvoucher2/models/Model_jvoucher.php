<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_jvoucher extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    function insertHeader($header)
    {	

      $sp = " 
        EXEC cp_TrnJurnal_InsertJVIpro 
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ? 
      ";
      return $this->db->query($sp, $header);
    }
	
    function saveDetil($data, $deleted)
    {	
      $is_debug = $this->db->db_debug;
      //$this->db->trans_begin();		
      $this->db->db_debug = false;

      try {

        foreach ($deleted as $rows => $row) {
          # code...          
          $sp = " DELETE FROM transaksi_jurnaldetil WHERE jurnal_id = ? AND jurnaldetil_line = ? ";
          $params = [
            'jurnal_id' => $row->jurnal_id,
            'jurnaldetil_line' => $row->jurnaldetil_line
          ];
          $this->db->query($sp, $params);
        }
        
        //$records = [];
        foreach ($data as $col) {
          # code...
          $record = [];
          foreach ($col as $key => $value) {          
            if ($key=='_state') { continue; }
            $record[$key] = $value;
          }
          $record = array_merge($record, [
            //jikalau ingin menambah atau edit field di result record, dapat dilakukan sesuai contoh sbb:            
            //'agreement_id' => $agreement_id,
          ]);

          if ($col['_state']== "update") {
            $sp = " 
              EXEC cp_TrnJurnaldetil_UpdateJVIpro 
              ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
              ?, ?, ?, ?, ?, ?, ?, ?, ?, ? 
            ";
          } else {
            $sp = " 
              EXEC cp_TrnJurnaldetil_InsertJVIpro 
              ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
              ?, ?, ?, ?, ?, ?, ?, ?, ?, ? 
            ";
          }

          $this->db->query($sp, $record);
        }

        $db_error = $this->db->error();
        if ($db_error['message'] !== '' && !empty($db_error)) {
            throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
            return false; // unreachable retrun statement !!!
        }

      } catch (\Exception $ex) {
        throw $ex;
      } finally {
        
        $this->db->db_debug = $is_debug;
      }
    }
	
    function updateHeader($header)
    {
    
      $spq = "
        EXEC cp_TrnJurnal_UpdateJVIpro 
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ? 
      ";
      return $this->db->query($spq, $header);
    }

    function deleteJurnal($jurnal_id)
    {

      $tableJurnal = array('transaksi_jurnaldetil', 'transaksi_jurnal');
      $this->db->where('jurnal_id', $jurnal_id);
      $this->db->delete($tableJurnal);    
    }
  
    function getDataDetail($jurnal_id)
    {	
      $is_debug = $this->db->db_debug;
      $this->db->db_debug = false;

      try {

        $this->db->select('tjd.*, ma.acc_name, mb.branch_name, ms.strukturunit_name, mr.rekanan_name');
        $this->db->from('transaksi_jurnaldetil tjd');
        $this->db->join('master_acc ma', 'ma.acc_id = tjd.acc_id');
        $this->db->join('master_branch mb', 'mb.branch_id = tjd.branch_id');
        $this->db->join('master_strukturunit ms', 'ms.strukturunit_id = tjd.strukturunit_id');
        $this->db->join('master_rekanan mr', 'mr.rekanan_id = tjd.rekanan_id');
        $this->db->where('tjd.jurnal_id', $jurnal_id);

        $this->db->order_by('tjd.jurnaldetil_line');

        $sql = $this->db->get();
        //$result = $sql->result();

        $db_error = $this->db->error();
        if ($db_error['message'] !== '' && !empty($db_error)) {
            throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
            return false; // unreachable retrun statement !!!
        }

        return $sql->result();
      } catch (\Exception $ex) {
        throw $ex;
      } finally {
        
        $this->db->db_debug = $is_debug;
      }
    }
 
    function qry_alldatapop($limit, $top, $sWhere, $optional){

      $qry="
        WITH CTE AS (
          select
            R.rekanan_id, R.rekanan_name, S.rekananshipping_line, S.rekananshipping_name, S.rowid AS debtor_no
          from 
            master_rekanan R
          left join 
            master_rekananshipping S ON R.rekanan_id = S.rekanan_id $optional
          $sWhere
        )
      
        SELECT CTE.*
        FROM CTE    
        ORDER BY  CTE.rekanan_name asc
        OFFSET $top ROWS 
        FETCH NEXT $limit ROWS ONLY
      ";

      //var_dump($qry);

      return $this->db->query($qry)->result_array();    
    }
   
    function qry_filteredpop($sWhere, $optional){
      $qry = "
        select 
          count(R.rekanan_id) as jml
        from 
          master_rekanan R  
        left join
          master_rekananshipping S ON R.rekanan_id = S.rekanan_id $optional
        $sWhere
      ";
      return $this->db->query($qry)->row_array();     
    }
   
    function qry_totalallpop(){
      $qry = "
        select 
          count(R.rekanan_id) as jml
        from 
          master_rekanan R
        left join 
          master_rekananshipping S ON R.rekanan_id = S.rekanan_id
      ";
      return $this->db->query($qry)->row_array();     
    }
   
    function qry_alldatalist($limit, $top, $sWhere){

      $sWhere = str_replace('WHERE', '', $sWhere);
      $this->db->select('tj.*');
      $this->db->from('transaksi_jurnal tj');
       
      if (!empty($sWhere)) { $this->db->where($sWhere); } 
      
      $this->db->order_by('tj.jurnal_bookdate', 'desc');

      $this->db->limit($limit, $top);
    
      $qry = $this->db->get();

      return $qry->result_array();      
    }
   
    function qry_filteredlist($sWhere){
      
      $sWhere = str_replace('WHERE', '', $sWhere);
      $this->db->select('count(*) jml');
      $this->db->from('transaksi_jurnal tj');
       
      if (!empty($sWhere)) { $this->db->where($sWhere); }

      return $this->db->get()->row_array();
    }
   
    function qry_totalalllist(){
        
      $this->db->select('count(*) jml');
      $this->db->from('transaksi_jurnal tj');
		  return $this->db->get()->row_array();	   
    }
   
    
    function viewjurnal($_id) {

      if (isset($_id)){
        return $this->db->query("
           SELECT TJ.jurnal_id, TJ.jurnal_descr, TJ.jurnal_isdisabled, TJ.jurnal_isposted, TJ.jurnal_isreversed,
              convert(varchar(10),TJ.jurnal_bookdate,120) AS jurnal_bookdate, convert(varchar(10),TJ.jurnal_duedate,120) AS jurnal_duedate,
              TJ.jurnal_createby, TJ.jurnal_createdate, TJ.jurnal_modifyby, TJ.jurnal_modifydate,
              TJ.jurnal_postby, TJ.jurnal_postdate, TJ.jurnal_faktur, TJ.jurnal_source, TJ.jurnaltype_id, TJ.channel_id,
              TJ.region_id, TJ.branch_id, TJ.branch_id, TJ.strukturunit_id, TJ.rekanan_id, TJ.rekananshipping_line, 
              TJ.sub1_id, TJ.sub2_id, TJ.currency_id, TJ.currency_rate, TJ.periode_id, TJ.acc_id,
              BR.branch_name, RE.rekanan_name, RS.rekananshipping_name              
           FROM transaksi_jurnal AS TJ
              LEFT JOIN master_branch AS BR ON TJ.branch_id = BR.branch_id
              LEFT JOIN master_rekanan AS RE ON TJ.rekanan_id = RE.rekanan_id
              LEFT JOIN master_rekananshipping AS RS ON TJ.rekanan_id = RS.rekanan_id AND TJ.rekananshipping_line = RS.rekananshipping_line
           WHERE TJ.jurnal_id='$_id'
        ")->result();        
      }else{         
        $timestamp = time();

        $now = date("Y-m-d", $timestamp);
        $periode = new DateTime($now);
        $periode_id = $periode->format('ym');

        $result[] = (object) array(                        
          'jurnal_id'               => 'auto',
          'jurnal_descr'            => '',
          'jurnal_bookdate'         => $now,
          'jurnal_duedate'          => $now,
          'periode_id'              => $periode_id,
          'region_id'               => '',
          'branch_id'               => '',
          'strukturunit_id'         => '',
          'jurnal_source'           => 'JV-Manual',
          'jurnaltype_id'           => 'JV',
          'rekanan_id'              => 0,
          'rekananshipping_id'      => 0,
          'jurnal_createby'         => '',
          'jurnal_createdate'       => $now,
          'jurnal_modifyby'         => '',
          'jurnal_modifydate'       => $now,
          'jurnal_faktur'           => ''
        ); 

        return $result;
      }
    }

    function get_jurnaldetilRef($jurnal_id)
    {
      $query = "  
        SELECT det.*, head.jurnal_bookdate, b.rekanan_name, c.rekananshipping_name, d.acc_name 
        FROM transaksi_jurnaldetil det 
          INNER JOIN transaksi_jurnal head ON det.jurnal_id = head.jurnal_id
            INNER JOIN transaksi_jurnaldetil ref ON det.jurnal_id = ref.ref_id and det.jurnaldetil_line = ref.ref_line
            LEFT JOIN master_rekanan b on det.rekanan_id = b.rekanan_id
            LEFT JOIN master_rekananshipping c on det.rekanan_id = c.rekanan_id AND det.rekananshipping_line = c.rekananshipping_line
            LEFT JOIN master_acc d on det.acc_id = d.acc_id  
        WHERE ref.jurnal_id = '{$jurnal_id}'        
        ORDER BY det.jurnal_id, det.jurnaldetil_line ASC
      ";
      $hasil = $this->db->query($query);
      if($hasil->num_rows() >0)
      {
        return $hasil->result();
      }
      else
      {
        return array();
      }
    }

    function get_jurnaldetilRes($jurnal_id)
    {
      $query = "  
        SELECT ref.*, head.jurnal_bookdate, b.rekanan_name, c.rekananshipping_name, d.acc_name 
        FROM transaksi_jurnaldetil det 
            INNER JOIN transaksi_jurnaldetil ref ON det.jurnal_id = ref.ref_id and det.jurnaldetil_line = ref.ref_line
            INNER JOIN transaksi_jurnal head ON ref.jurnal_id = head.jurnal_id
            LEFT JOIN master_rekanan b on ref.rekanan_id = b.rekanan_id
            LEFT JOIN master_rekananshipping c on ref.rekanan_id = c.rekanan_id AND ref.rekananshipping_line = c.rekananshipping_line
            LEFT JOIN master_acc d on ref.acc_id = d.acc_id
        WHERE det.jurnal_id = '{$jurnal_id}'        
        ORDER BY ref.jurnal_id, ref.jurnaldetil_line ASC
      ";
      $hasil = $this->db->query($query);
      if($hasil->num_rows() >0)
      {
        return $hasil->result();
      }
      else
      {
        return array();
      }
    }

    function PostJurnal($arrapp, $username, $channel_id) {

      $action = "unapprove";   

      if (is_array($arrapp)){
        if (count($arrapp) >0){
          foreach ($arrapp as $key){       

            $agreement_id   = $key[0];
            $ref_id         = $key[1];
            $renewal_number = $key[2];

            $this->db->trans_begin();

            $ag_posting = "EXEC lm03_TrnAgreement_Posting '{$agreement_id}', '{$username}', 1, '{$ref_id}', '{$renewal_number}', '{$channel_id}' ";
            $this->db->query($ag_posting);    
            //echo $this->db->last_query(); exit;

            if ($this->db->trans_status() === FALSE)
            {               
                //generate an error... or use the log_message() function to log your error
                $this->db->trans_rollback();
                return false;
            }else{
                $this->db->trans_commit();
                return true;
            }

          }  
        }
      }       

    }

    function get_acc() {

      $sql = "cp_MstAcc_SelectBySource_SelectWPage 'source_id = ''JV-Manual'' AND dk = ''D'' AND acc_isgroup = 0 AND acc_isdisabled = 0'";
      $query = $this->db->query($sql);
      return $query->result();
    } 

    function get_branch() {
        
      // $SQL = "
      //SELECT acc_id, acc_name
      //FROM master_acc ";        
      $SQL = "select branch_id,branch_name from master_branch";
      
      $query = $this->db->query($SQL);      

      return $query->result();
    } 

    function get_periode() {
        
        $SQL = "
            SELECT periode_id, periode_name
            FROM master_periode where periode_isclosed=0";
        $query = $this->db->query($SQL);      

        return $query->result();
    } 
  
    function get_periodeall() {
      
      $SQL = "
          SELECT periode_id, periode_name
          FROM master_periode";
      $query = $this->db->query($SQL);      

      return $query->result();
    } 
    
    function get_journalsource() {
        $SQL    = "EXEC [cp_MstJurnalSource_Select] '' ";
        $query  = $this->db->query($SQL);

      return $query->result();
    }

    function get_branchbyquery($name, $region_id) {

      $this->db->select('r.branch_id, b.branch_name, r.region_id');
      $this->db->from('master_regionbranch r');
      $this->db->join('master_branch b', 'r.branch_id = b.branch_id');
      $this->db->where('r.region_id', $region_id);
      $this->db->like('b.branch_name', $name);
      $query = $this->db->get();

      return $query->result();
    }

    public function Lookup($value, $tablename, $field_id, $field_display) {
      $this->db->select('*');
      $this->db->from("$tablename");
      $this->db->where("$field_id", $value);
      $query = $this->db->get();

      // Cek apakah ada hasil
      if ($query->num_rows() > 0) {
          //return $query->row();
          return $query->row()->$field_display;
      } else {
          return false;  // Jika tidak ditemukan, kembalikan false
      }
    }

}
