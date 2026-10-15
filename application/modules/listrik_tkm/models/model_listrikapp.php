<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_listrikapp extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }   

    function qry_alldatapop($limit,$top,$sWhere){
        $qry="WITH CTE AS (
            SELECT top $limit SHIP.rekanan_id, SHIP.rekananshipping_line, SHIP.rekananshipping_name, REKA.rekanan_name, SHIP.rowid AS debtor_no,
              ROW_NUMBER() OVER (ORDER BY SHIP.rekananshipping_name asc) as RowNumber 
            FROM master_rekananshipping SHIP
              JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id  
            $sWhere )
        SELECT CTE.*
        FROM CTE      
        WHERE RowNumber > $top";
      //print($qry);
      return $this->db->query($qry)->result_array();    
    }
   
    function qry_filteredpop($sWhere){
        $qry="SELECT count(SHIP.rekanan_id) as jml
          FROM master_rekananshipping SHIP
            JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id $sWhere";
      return $this->db->query($qry)->row_array();     
    }
   
    function qry_totalallpop(){
        $qry="SELECT count(SHIP.rekanan_id) as jml
          FROM master_rekananshipping SHIP
            JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id";
      return $this->db->query($qry)->row_array();
    }
   
    function qry_alldatalist($limit,$top,$sWhere){
	   // echo var_dump($sWhere);
  	  $qry=" 
        SELECT * FROM (
          SELECT top $limit CTE.utilitieslistrik_id, CTE.utilitieslistrik_descr, CTE.utilitieslistrik_date, 
            ROW_NUMBER() OVER (ORDER BY CTE.utilitieslistrik_id desc) as RowNumber,
            REGION.region_name, BRANCH.branch_name, STRU.strukturunit_name, REKAN.rekanan_name, REKS.rekananshipping_name,
            LDT.utilitieslistrikdetil_akhir, LDT.utilitieslistrikdetil_standawal, LDT.utilitieslistrikdetil_selisih,
            LDT.utilitieslistrikdetil_jumlah, LDT.utilitieslistrikdetil_line, LDT.utilitieslistrikdetil_jamnyala,
            LDT.utilitieslistrikdetil_kva
          FROM transaksi_utilitieslistrik_tkm AS CTE       
            INNER JOIN transaksi_utilitieslistrikdetil_tkm AS LDT ON CTE.utilitieslistrik_id = LDT.utilitieslistrik_id
            LEFT JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
            LEFT JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
            LEFT JOIN master_strukturunit AS STRU ON CTE.strukturunit_id = STRU.strukturunit_id      
            LEFT JOIN master_rekanan AS REKAN ON LDT.rekanan_id = REKAN.rekanan_id
            LEFT JOIN master_rekananshipping AS REKS ON LDT.rekanan_id = REKS.rekanan_id AND LDT.rekananshipping_line = REKS.rekananshipping_line            
          $sWhere           
          ORDER BY CTE.utilitieslistrik_id DESC
        ) AS V
        WHERE   RowNumber > $top";    

      //print_r($qry);

	    return $this->db->query($qry)->result_array();
   }
   
    function qry_filteredlist($sWhere){
      
	    $qry="
        SELECT COUNT(*) as jml FROM (
  			  SELECT  CTE.utilitieslistrik_id
          FROM transaksi_utilitieslistrik_tkm AS CTE       
            INNER JOIN transaksi_utilitieslistrikdetil_tkm AS LDT ON CTE.utilitieslistrik_id = LDT.utilitieslistrik_id
            LEFT JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
            LEFT JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
            LEFT JOIN master_strukturunit AS STRU ON CTE.strukturunit_id = STRU.strukturunit_id      
            LEFT JOIN master_rekanan AS REKAN ON LDT.rekanan_id = REKAN.rekanan_id
            LEFT JOIN master_rekananshipping AS REKS ON LDT.rekanan_id = REKS.rekanan_id AND LDT.rekananshipping_line = REKS.rekananshipping_line
          $sWhere
  			) AS V";

		  return $this->db->query($qry)->row_array();	   
    }
   
    function qry_totalalllist(){
	   
        $qry="SELECT COUNT(utilitieslistrik_id) AS jml FROM transaksi_utilitieslistrikdetil_tkm";
		  return $this->db->query($qry)->row_array();
	   
    }    

  function vdetil($_id){          
        $sql = "
          SELECT ULD.*, REK.rekanan_name AS rekanan_name, SHP.rekananshipping_name AS rekananshipping_name
          FROM transaksi_utilitieslistrikdetil ULD
            LEFT JOIN master_rekanan REK ON REK.rekanan_id = ULD.rekanan_id
            LEFT JOIN master_rekananshipping SHP ON SHP.rekanan_id = ULD.rekanan_id AND SHP.rekananshipping_line = ULD.rekananshipping_line
          WHERE ULD.utilitieslistrik_id = '$_id'
          ORDER BY  utilitieslistrik_id, utilitieslistrikdetil_line ASC";  
    return $this->db->query($sql)->result();      
  }      

   function postinglistrik($arrapp, $username, $channel_id, $posted){   

      $action = "posting";

       if (is_array($arrapp)){
         if (count($arrapp) >0){
            foreach ($arrapp as $key){             

              $_id    = $key['id'];
              $line   = $key['line'];

              $this->db->trans_begin();

              $posting = "EXEC [lm03_TrnUtilitiesListrik_Posting_tkm] '{$_id}', '{$username}', $posted, '{$channel_id}', $line";
              /*
              $posting = "UPDATE transaksi_utilitieslistrikdetil 
                          SET utilitieslistrikdetil_ischecked = $posted
                          WHERE utilitieslistrik_id = '{$_id}' AND utilitieslistrikdetil_line = {$line}";
              */
              $this->db->query($posting);           

              if ($this->db->trans_status() === FALSE)
              {               
                  //generate an error... or use the log_message() function to log your error                  
                  $this->db->trans_rollback();                  
                  return false;
              }else{
                  $this->db->trans_commit();                  
              }
            }
            return true;  
         }
      }
    }   

    function unapproveagreement($arrapp, $username, $channel_id){   

      $action = "unapprove";   

       if (is_array($arrapp)){
         if (count($arrapp) >0){
            foreach ($arrapp as $key){       

              $agreement_id   = $key[0];
              $ref_id         = $key[1];
              $renewal_number = $key[2];

              $this->db->trans_begin();

              $ag_posting = "EXEC lm03_TrnAgreement_Unposting '{$agreement_id}', '{$username}', 1, '{$channel_id}' ";
              $this->db->query($ag_posting);    

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

  function get_openperiode(){
        
      $this->db->select('periode_id, periode_name');
      $this->db->where('periode_isclosed = 0');
      $query = $this->db->get('master_periode');
        
    return $query->result();
  }

  function get_branchbyall($name){

      $this->db->select('r.branch_id, b.branch_name, r.region_id, c.region_name');
      $this->db->from('master_regionbranch r');
      $this->db->join('master_branch b', 'r.branch_id = b.branch_id');   
      $this->db->join('master_region c', 'c.region_id = r.region_id');     
      $this->db->like('b.branch_name', $name);
      $query = $this->db->get();

    return $query->result();
  }
    
}
