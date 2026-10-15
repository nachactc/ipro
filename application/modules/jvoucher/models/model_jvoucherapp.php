<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_jvoucherapp extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
	 function qry_alldatadialog($limit,$top,$sWhere){
		
		 $sWhere = empty($sWhere) ? " WHERE unit_state <> 3 " : $sWhere." AND unit_state <> 3"; 
        
	   $qry="WITH CTE AS (
 				select top $limit *,ROW_NUMBER() OVER (ORDER BY unit_id asc) as RowNumber 
				from master_unit $sWhere)
		SELECT CTE.*, FLOOR.lantai_name
    FROM CTE 
      JOIN master_lantai AS FLOOR ON CTE.lantai_id = FLOOR.lantai_id
    WHERE RowNumber > $top";
    //print_r($qry);
	   return $this->db->query($qry)->result_array();	   
   }
   
   function qry_filtereddialog($sWhere){
	   $sWhere = empty($sWhere) ? " WHERE unit_state <> 3 " : $sWhere." AND unit_state <> 3";    
	   
	   $qry="select count(unit_id) as jml from master_unit $sWhere";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalldialog(){
	   $qry="select count(unit_id) as jml from master_unit where unit_state<>3";
		return $this->db->query($qry)->row_array();
	   
   }   

   function qry_alldatapop($limit,$top,$sWhere){
      $qry="WITH CTE AS (
          select top $limit SHIP.rekanan_id, SHIP.rekananshipping_line, SHIP.rekananshipping_name, REKA.rekanan_name, SHIP.rowid AS debtor_no,
            ROW_NUMBER() OVER (ORDER BY SHIP.rekananshipping_name asc) as RowNumber 
          from master_rekananshipping SHIP
            JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id  
          $sWhere )
      SELECT CTE.*
      FROM CTE      
      WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();    
   }
   
   function qry_filteredpop($sWhere){
     $qry="select count(SHIP.rekanan_id) as jml
          from master_rekananshipping SHIP
            JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id $sWhere";
    return $this->db->query($qry)->row_array();
     
   }
   
   function qry_totalallpop(){
     $qry="select count(SHIP.rekanan_id) as jml
          from master_rekananshipping SHIP
            JOIN master_rekanan AS REKA ON REKA.rekanan_id = SHIP.rekanan_id";
    return $this->db->query($qry)->row_array();
     
   }   

   function qry_alldatadetil($limit,$top,$sWhere){
     $qry="WITH CTE AS (
          SELECT top $limit ROW_NUMBER() OVER (ORDER BY un.loo_id asc) as RowNumber, un.loo_id, 
            un.rekanan_id, r.rekanan_name, un.rekananshipping_line, rs.rekananshipping_name, rs.rowid AS debtor_no
          FROM transaksi_loounit un
            left join master_rekanan r on un.rekanan_id = r.rekanan_id 
            left join master_rekananshipping rs on un.rekanan_id = rs.rekanan_id and un.rekananshipping_line =rs.rekananshipping_line 
          $sWhere
          GROUP BY un.loo_id, un.rekanan_id, r.rekanan_name, un.rekananshipping_line, rs.rekananshipping_name, rs.rowid
        )       
        SELECT CTE.*
        FROM CTE          
        WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();    
   }
   
   function qry_filtereddetil($sWhere){
     $qry="select count(loo_id) as jml from transaksi_loo $sWhere";
    return $this->db->query($qry)->row_array();
     
   }
   
   function qry_totalalldetil(){
     $qry="select count(loo_id) as jml from transaksi_loo";
    return $this->db->query($qry)->row_array();
     
   }
   
    function qry_alldatalist($limit,$top,$sWhere){
      //$sWhere = empty($sWhere) ? " WHERE jurnal_isdisabled = 0 " : $sWhere." AND jurnal_isdisabled = 0 ";
      $qry=" 
        SELECT * FROM (
    			SELECT TOP $limit VV.*, ROW_NUMBER() OVER (ORDER BY jurnal_id desc) AS RowNumber,
            REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, STRUK.strukturunit_name
          FROM v_jurnal AS VV
              JOIN master_region AS REGION ON VV.region_id = REGION.region_id
              JOIN master_branch AS BRANCH ON VV.branch_id = BRANCH.branch_id
              JOIN master_rekanan AS REKAN ON VV.rekanan_id = REKAN.rekanan_id
              JOIN master_strukturunit AS STRUK ON VV.strukturunit_id = STRUK.strukturunit_id
          $sWhere
          ORDER BY VV.jurnal_id DESC
        ) AS V
        WHERE   RowNumber > $top";	  
        //var_dump($qry);exit;
      return $this->db->query($qry)->result_array();            
    }
    
	function qry_allcanceldatalist($limit,$top,$sWhere){
      $sWhere = empty($sWhere) ? " WHERE  ISNULL(VW.jurnal_isreversed,0) = 0 " : $sWhere." AND ISNULL(VW.jurnal_isreversed,0) = 0 "; 
      $qry=" 
        SELECT * FROM (
    			SELECT TOP $limit VV.*, ROW_NUMBER() OVER (ORDER BY VV.jurnal_id desc) AS RowNumber,
            REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, STRUK.strukturunit_name
          FROM v_jurnal AS VV
              JOIN master_region AS REGION ON VV.region_id = REGION.region_id
              JOIN master_branch AS BRANCH ON VV.branch_id = BRANCH.branch_id
              JOIN master_rekanan AS REKAN ON VV.rekanan_id = REKAN.rekanan_id
              JOIN master_strukturunit AS STRUK ON VV.strukturunit_id = STRUK.strukturunit_id
			  JOIN transaksi_jurnal VW ON VV.jurnal_id = VW.jurnal_id 
          $sWhere
          ORDER BY VV.jurnal_id DESC
        ) AS V
        WHERE   RowNumber > $top";	  
		// echo $qry;exit;
      return $this->db->query($qry)->result_array();
    }
   
    function qry_filteredlist($sWhere){      
        //$sWhere = empty($sWhere) ? " WHERE jurnal_isposted = 0 " : $sWhere." AND jurnal_isposted = 0 ";
  	    $qry="
          SELECT COUNT(*) as jml FROM (
    			  SELECT VV.*, ROW_NUMBER() OVER (ORDER BY jurnal_id desc) AS RowNumber,
              REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, STRUK.strukturunit_name
            FROM v_jurnal AS VV
                JOIN master_region AS REGION ON VV.region_id = REGION.region_id
                JOIN master_branch AS BRANCH ON VV.branch_id = BRANCH.branch_id
                JOIN master_rekanan AS REKAN ON VV.rekanan_id = REKAN.rekanan_id
                JOIN master_strukturunit AS STRUK ON VV.strukturunit_id = STRUK.strukturunit_id
            $sWhere			 
  			  ) AS V";
		  return $this->db->query($qry)->row_array();	 
    }
   
    function qry_totalalllist(){
        $qry= "SELECT COUNT(jurnal_id) AS jml FROM v_jurnal";
		  return $this->db->query($qry)->row_array();	   
    }      
    
  function viewjurnal($_id){     

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

       $result[] = (object) array(                        
                        'agreement_id'            =>'auto',
                        'agreement_startdate'     => $now,
                        'agreement_enddate'       => $now,
                        'agreement_idr'           => 0,
                        'agreement_formula'       => 0,
                        'agreeement_foreign'      => 0,
                        'agreement_foreign_rate'  => 0,
                        'region_id'               => '',
                        'branch_id'               => '',
                        'strukturunit_id'         => '',
                        'loo_type'                => '',
                        'rekanan_id'              => 0,
                        'rekananshipping_id'      => 0,
                        'agreement_createby'      => '',
                        'agreement_createdate'    => $now,
                        'agreement_modifyby'      => '',
                        'agreement_modifydate'    => $now,
                        'product_name'            => '',
                        'fitting_out'             => 0,
                        'grace_period'            => 0,
                        'size_indoor'             => 0,
                        'size_outdoor'            => 0,
                        'transaksi_id'            => '100920',
                        'transaksi_name'          => 'Pencatatan Leasing'
       ); 

       return $result;
     }

   }

    function vdetiljurnal($_id){          
        $sql = "
          SELECT JD.*, AC.acc_name, RG.region_name, BR.branch_name, ST.strukturunit_name
          FROM transaksi_jurnaldetil JD
            LEFT JOIN master_acc AC ON JD.acc_id = AC.acc_id
            LEFT JOIN master_region RG ON JD.region_id = RG.region_id
            LEFT JOIN master_branch BR ON JD.branch_id = BR.branch_id
            LEFT JOIN master_strukturunit ST ON JD.strukturunit_id = ST.strukturunit_id
          WHERE JD.jurnal_id = '$_id'
          ORDER BY  jurnal_id, jurnaldetil_line ASC";  
      return $this->db->query($sql)->result();      
    }  

    function postingjurnal($arrapp, $username, $channel_id, $treat){   

      $action = "posting";

       if (is_array($arrapp)){
         if (count($arrapp) >0){
            foreach ($arrapp as $key){             

              $jurnal_id      = $key['id'];

              $this->db->trans_begin();

              $posting = "EXEC [cp_TrnJurnal_Posting] '{$jurnal_id}', '{$username}', '{$treat}'";
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
    function canceljurnal($arrapp, $username, $channel_id, $treat,$dates){   
 
	$date_sys = date('Y-m-d',strtotime($dates));
       if (is_array($arrapp)){
         if (count($arrapp) >0){
            foreach ($arrapp as $key){             

              $jurnal_id      = $key['id'];
			
              $this->db->trans_begin();

              $posting = "EXEC [cp_TrnJurnal_Reversing] '{$jurnal_id}', '{$username}', '{$date_sys}',1 ";
			  // echo  $posting; exit;
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

  function get_acc(){
      
      $SQL = "
          SELECT acc_id, acc_name
          FROM master_acc ";
      $query = $this->db->query($SQL);      

      return $query->result();
  } 

  function get_periode(){
      
      $SQL = "
          SELECT periode_id, periode_name
          FROM master_periode ";
      $query = $this->db->query($SQL);      

      return $query->result();
  } 
    
  function get_journalsource(){
      $SQL    = "EXEC [cp_MstJurnalSource_Select] '' ";
      $query  = $this->db->query($SQL);

    return $query->result();
  }
}
