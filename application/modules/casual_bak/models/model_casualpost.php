<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_casualpost extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
	 function qry_alldatapro($limit,$top,$sWhere){		      

     $sWhere = empty($sWhere) ? " WHERE provitsharing_isdisabled = 0 " : $sWhere." AND provitsharing_isdisabled = 0 ";    
	   $qry="WITH CTE AS (
 				SELECT top $limit *,ROW_NUMBER() OVER (ORDER BY provitsharing_id asc) as RowNumber 
				FROM master_provitsharing $sWhere)
		SELECT CTE.*
    FROM CTE
    WHERE RowNumber > $top";
    //print_r($qry);
	   return $this->db->query($qry)->result_array();	   
   }
   
   function qry_filteredpro($sWhere){     
      $sWhere = empty($sWhere) ? " WHERE provitsharing_isdisabled = 0 " : $sWhere." AND provitsharing_isdisabled = 0 ";    
	   
      $qry="SELECT COUNT(provitsharing_id) as jml from master_provitsharing $sWhere";
		return $this->db->query($qry)->row_array();	   
   }
   
   function qry_totalallpro(){
	   $qry="SELECT COUNT(provitsharing_id) as jml FROM master_provitsharing WHERE provitsharing_isdisabled = 0";
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

   function qry_alldatanew($limit,$top,$sWhere){

     $exist = "NOT EXISTS ( SELECT agreement_loonumber FROM transaksi_agreementtemp ag WHERE s.loo_id = ag.agreement_loonumber)";
     $sWhere = empty($sWhere) ? " WHERE loo_type=1 and isapproved=1 " : $sWhere." AND loo_type=1 and isapproved=1 ";
     $sWhere = $sWhere." AND ".$exist;

     $qry="WITH CTE AS (
          SELECT top $limit ROW_NUMBER() OVER (ORDER BY s.loo_id asc) as RowNumber, s.loo_id, 
            convert(varchar(10),un.loounit_sdate,120) AS loo_sdate, convert(varchar(10),un.loounit_edate,120) AS loo_edate,
            s._createby, s._createdate, s.isdisabled, s.ismulti, s.conf_id, un.loounit_term, s.size_indoor, s.size_outdoor, s.fitting_out, s.grace_period, s.product_name,
            s.isconfirm, s.isapproved, un.region_id, un.branch_id, s.loo_type, s.loo_term, s.loo_date,
            un.rekanan_id, r.rekanan_name ,un.rekananshipping_line, un.isclosed, rs.rekananshipping_name, rg.region_name,b.branch_name,
            rs.rowid AS debtor_no
          FROM transaksi_loo s 
            left join transaksi_loounit un on s.loo_id=un.loo_id
            left join master_region rg on un.region_id = rg.region_id 
            left join master_branch b on un.branch_id = b.branch_id 
            left join master_rekanan r on s.rekanan_id = r.rekanan_id 
            left join master_rekananshipping rs on s.rekanan_id = rs.rekanan_id and s.rekananshipping_line =rs.rekananshipping_line 
          $sWhere
          GROUP BY s.loo_id, un.loounit_sdate, un.loounit_edate, s._createby, s._createdate, s.isdisabled, s.ismulti, s.isconfirm, s.conf_id, s.isapproved,
          un.region_id, un.branch_id, s.loo_type, s.loo_term, s.loo_date, un.rekanan_id, r.rekanan_name ,un.rekananshipping_line, 
          un.isclosed, rs.rekananshipping_name, rg.region_name, b.branch_name, un.loounit_term, rs.rowid, s.size_indoor, s.size_outdoor, 
          s.fitting_out, s.grace_period, s.product_name
        )       
        SELECT CTE.*
        FROM CTE          
        WHERE RowNumber > $top";

        //print_r($qry);
     return $this->db->query($qry)->result_array();    
   }
   
    function qry_filterednew($sWhere){
        $exist = "NOT EXISTS ( SELECT agreement_loonumber FROM transaksi_agreementtemp ag WHERE s.loo_id = ag.agreement_loonumber)";
        $sWhere = empty($sWhere) ? " WHERE loo_type = 1 and isapproved=1 " : $sWhere." AND loo_type = 1 and isapproved=1";
        $sWhere = $sWhere." AND ".$exist;

        $qry="SELECT count(loo_id) as jml FROM transaksi_loo s $sWhere";
    
      return $this->db->query($qry)->row_array();
     
    }
   
   function qry_totalallnew(){
     $qry="SELECT count(loo_id) as jml FROM transaksi_loo WHERE loo_type=1 and isapproved=1";
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
	   // echo var_dump($sWhere);
	   $qry=" 
			SELECT * FROM (
			  SELECT top $limit CTE.*,ROW_NUMBER() OVER (ORDER BY agreement_id desc) as RowNumber, 
						   REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name
			  FROM transaksi_agreementtemp AS CTE       
			    JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
			    JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
			    JOIN master_rekanan AS REKAN ON CTE.rekanan_id = REKAN.rekanan_id
			    JOIN master_rekananshipping AS BRAND ON CTE.rekanan_id = BRAND.rekanan_id AND CTE.rekananshipping_line = BRAND.rekananshipping_line
			  $sWhere 
			  ORDER BY CTE.agreement_id DESC
			  ) AS V
    	WHERE   RowNumber > $top";	  
      
	    return $this->db->query($qry)->result_array();
    }
   
    function qry_filteredlist($sWhere){
      
  	   $qry="SELECT count(*) as jml FROM (
  			select CTE.*,ROW_NUMBER() OVER (ORDER BY agreement_id desc) as RowNumber, 
  						   REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name
  			  FROM transaksi_agreementtemp AS CTE       
  			  JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
  			  JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
  			  JOIN master_rekanan AS REKAN ON CTE.rekanan_id = REKAN.rekanan_id
  			  JOIN master_rekananshipping AS BRAND ON CTE.rekanan_id = BRAND.rekanan_id AND CTE.rekananshipping_line = BRAND.rekananshipping_line
  			  $sWhere 
  			 
  			  ) AS V";
		  return $this->db->query($qry)->row_array();
	   
    }
   
   function qry_totalalllist(){
	   $qry="select count(agreement_id) as jml from transaksi_agreementtemp";
		return $this->db->query($qry)->row_array();
	   
   }  
    
  function viewagreement($agreement_id){     

     if (isset($agreement_id)){
        return $this->db->query("
           SELECT AGR.agreement_id, agreement_ref, ref_id, ref_type,
              convert(varchar(10),agreement_startdate,120) AS agreement_startdate, convert(varchar(10),agreement_enddate,120) AS agreement_enddate,
              convert(varchar(10),agreement_startperiod,120) AS agreement_startdate, convert(varchar(10),agreement_endperiod,120) AS agreement_endperiod,
              agreement_idr, agreeement_foreign, agreement_foreign_rate, currency_id,agreement_term, agreementleasetype_id, 
              agreement_isrenewal, agreement_descr, agreement_islumpsum,agreement_tlv, agreement_isclosed, agreement_isapproved, 
              agreement_createby, agreement_createdate, agreement_modifyby, agreement_modifydate, AGR.channel_id, AGR.transaksi_id, AGR.region_id,
              AGR.strukturunit_id, agreement_renttype, agreement_deduct, agreement_provision, agreement_formula, agreement_virtualaccount,
              agreement_contractno, agreement_renewalno, agreement_dayterm, agreement_contractlongnumber,
              AGR.branch_id, AGR.rekanan_id, AGR.rekananshipping_line, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name,
              TRANS.transaksi_name, agreement_loonumber, pLOI.dagangan, pLOI.fitting_out, pLOI.grace_periode, pLOI.size_indoor, pLOI.size_outdoor,
              agreement_bapdate
           FROM transaksi_agreementtemp AS AGR 
              JOIN master_branch AS BRANCH ON AGR.branch_id = BRANCH.branch_id
              JOIN master_rekanan AS REKAN ON AGR.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON AGR.rekanan_id = BRAND.rekanan_id AND AGR.rekananshipping_line = BRAND.rekananshipping_line
              JOIN master_transaksi AS TRANS ON AGR.transaksi_id = TRANS.transaksi_id
              LEFT JOIN transaksi_agreement_printLOI AS pLOI ON pLOI.agreement_id = AGR.agreement_id 
           WHERE AGR.agreement_id='$agreement_id'
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
  
  function get_unit($term, $region, $branch, $loonum){
      
      $getUnit = "EXEC [lm03_MstUnit_SelectPage] '', '(( region_id=''{$region}'' and branch_id=''{$branch}'' and unit_state=0 and unit_name like ''%{$term}%'' )
          OR unit_id in ( SELECT unit_id FROM transaksi_loounit WHERE loo_id =''{$loonum}'' ) 
          OR unit_id in ( SELECT unit_id FROM transaksi_locunit where loc_id =''{$loonum}'' ))', 0, 0";
      $query = $this->db->query($getUnit);      

      return $query->result();
  } 

  function get_tenant($term, $branch, $is_branch){      

      $criteria = " rekanantype_id=''105'' AND rekanan_name like ''%{$term}%'' ";

      if (!empty($branch) && $is_branch != false) {

          $criteria .= " AND rekanan_id in (select rekanan_id from master_rekananshipping where branch_id = ''{$branch}'' ) ";
      }      
      
      $SQL = "EXEC [adm03_MstRekanan_SelectWPage] '', '{$criteria}', 1, 100";
      $query = $this->db->query($SQL);      

      return $query->result();
  } 

  function get_trade($term, $branch, $is_branch, $rekanan, $is_rekanan){

      $criteria = " (rekananshipping_name like ''%{$term}%'' OR rowid like ''%{$term}%'') ";

      if (!empty($rekanan) && $is_rekanan != false) {

          $criteria .= " AND rekanan_id = ''{$rekanan}''";
      }      

      if (!empty($branch) && $is_branch != false) {
          $criteria .= " AND branch_id = ''{$branch}''";
      }
      
      $SQL = "EXEC [ms_MstRekananshipping_SelectWPage] '', '{$criteria}', 1, 100";
      $query = $this->db->query($SQL);      

      return $query->result();
  }
  
  function postingcasual($arrapp, $username, $channel_id, $posted){   

    $action = "posting";

     if (is_array($arrapp)){
       if (count($arrapp) >0){
          foreach ($arrapp as $key){             

            $_id    = $key['id'];
            $line   = $key['line'];

            $this->db->trans_begin();

            $posting = "EXEC [lm03_TrnAgreementtemp_Posting] '{$_id}', '{$username}', $posted, '', '', '$channel_id'";
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
    
}
