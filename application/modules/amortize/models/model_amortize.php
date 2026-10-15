<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_amortize extends CI_Model{
    
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
    //print_r($qry);
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

     $exist = "NOT EXISTS ( SELECT agreement_loonumber FROM transaksi_agreement ag WHERE s.loo_id = ag.agreement_loonumber)";
     $sWhere = empty($sWhere) ? " WHERE loo_type=0 and isapproved=1 " : $sWhere." AND loo_type=0 and isapproved=1 ";
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
        $exist = "NOT EXISTS ( SELECT agreement_loonumber FROM transaksi_agreement ag WHERE s.loo_id = ag.agreement_loonumber)";
        $sWhere = empty($sWhere) ? " WHERE loo_type = 0 and isapproved=1 " : $sWhere." AND loo_type = 0 and isapproved=1";
        $sWhere = $sWhere." AND ".$exist;

        $qry="SELECT count(loo_id) as jml FROM transaksi_loo s $sWhere";
    
      return $this->db->query($qry)->row_array();
     
    }
   
   function qry_totalallnew(){
     $qry="SELECT count(loo_id) as jml FROM transaksi_loo WHERE loo_type=0 and isapproved=1";
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
			  FROM transaksi_agreement AS CTE       
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
			  FROM transaksi_agreement AS CTE       
			  JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
			  JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
			  JOIN master_rekanan AS REKAN ON CTE.rekanan_id = REKAN.rekanan_id
			  JOIN master_rekananshipping AS BRAND ON CTE.rekanan_id = BRAND.rekanan_id AND CTE.rekananshipping_line = BRAND.rekananshipping_line
			  $sWhere 
			 
			  ) AS V";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalllist(){
	   $qry="select count(agreement_id) as jml from transaksi_agreement";
		return $this->db->query($qry)->row_array();
	   
   }

    function qry_locall($limit,$top,$sWhere){

      $exist = "NOT EXISTS ( SELECT agreement_loonumber FROM transaksi_agreement ag WHERE s.loc_id = ag.agreement_loonumber)";
      $sWhere = empty($sWhere) ? " WHERE loc_type=0 AND isapproved=1 AND isnull(isdisabled,0)= 0 AND isnull(isclosed,0) = 0" : $sWhere." AND loc_type=0 AND isapproved=1 AND isnull(isdisabled,0)= 0 AND isnull(isclosed,0) = 0";
      $sWhere = $sWhere." AND ".$exist;

      $qry="WITH CTE AS (
          SELECT top $limit ROW_NUMBER() OVER (ORDER BY s.loc_id asc) as RowNumber, s.loc_id, 
            convert(varchar(10),un.locunit_sdate,120) AS loc_sdate, convert(varchar(10),un.locunit_edate,120) AS loc_edate,
            s._createby, s._createdate, s.isdisabled, s.ismulti, s.conf_id, un.locunit_term, s.size_indoor, s.size_outdoor, s.fitting_out, s.grace_period, s.product_name,
            s.isconfirm, s.isapproved, un.region_id, un.branch_id, s.loc_type, s.loc_term, s.loc_date,
            un.rekanan_id, r.rekanan_name ,un.rekananshipping_line, un.isclosed, rs.rekananshipping_name, rg.region_name,b.branch_name,
            rs.rowid AS debtor_no
          FROM transaksi_loc s 
            left join transaksi_locunit un on s.loc_id=un.loc_id
            left join master_region rg on un.region_id = rg.region_id 
            left join master_branch b on un.branch_id = b.branch_id 
            left join master_rekanan r on s.rekanan_id = r.rekanan_id 
            left join master_rekananshipping rs on s.rekanan_id = rs.rekanan_id and s.rekananshipping_line =rs.rekananshipping_line 
          $sWhere
          GROUP BY s.loc_id, un.locunit_sdate, un.locunit_edate, s._createby, s._createdate, s.isdisabled, s.ismulti, s.isconfirm, s.conf_id, s.isapproved,
          un.region_id, un.branch_id, s.loc_type, s.loc_term, s.loc_date, un.rekanan_id, r.rekanan_name ,un.rekananshipping_line, 
          un.isclosed, rs.rekananshipping_name, rg.region_name, b.branch_name, un.locunit_term, rs.rowid, s.size_indoor, s.size_outdoor, 
          s.fitting_out, s.grace_period, s.product_name
        )       
        SELECT CTE.*
        FROM CTE          
        WHERE RowNumber > $top";

        //print_r($qry);exit;
      return $this->db->query($qry)->result_array();    
    }
    
    function qry_locfiltered($sWhere){
        $exist = "NOT EXISTS ( SELECT agreement_loonumber FROM transaksi_agreement ag WHERE s.loc_id = ag.agreement_loonumber)";
        $sWhere = empty($sWhere) ? " WHERE loc_type = 0 and isapproved=1 AND isnull(isdisabled,0)= 0 " : $sWhere." AND loc_type = 0 and isapproved=1 AND isnull(isdisabled,0)= 0 ";
        $sWhere = $sWhere." AND ".$exist;

        $qry="SELECT count(loc_id) as jml FROM transaksi_loc s $sWhere";
    
      return $this->db->query($qry)->row_array();
      
    }
    
    function qry_loctotal(){
      $qry="SELECT count(loc_id) as jml FROM transaksi_loc WHERE loc_type=0 and isapproved=1 AND isnull(isdisabled,0)= 0";
    return $this->db->query($qry)->row_array();
      
    }

    function qry_localldetil($limit,$top,$sWhere){
      $qry="WITH CTE AS (
          SELECT top $limit ROW_NUMBER() OVER (ORDER BY un.loc_id asc) as RowNumber, un.loc_id, 
            un.rekanan_id, r.rekanan_name, un.rekananshipping_line, rs.rekananshipping_name, rs.rowid AS debtor_no
          FROM transaksi_locunit un
            left join master_rekanan r on un.rekanan_id = r.rekanan_id 
            left join master_rekananshipping rs on un.rekanan_id = rs.rekanan_id and un.rekananshipping_line =rs.rekananshipping_line 
          $sWhere
          GROUP BY un.loc_id, un.rekanan_id, r.rekanan_name, un.rekananshipping_line, rs.rekananshipping_name, rs.rowid
        )       
        SELECT CTE.*
        FROM CTE          
        WHERE RowNumber > $top";
      return $this->db->query($qry)->result_array();    
    }
    
    function qry_locfiltereddetil($sWhere){
      $qry="select count(loc_id) as jml from transaksi_loc $sWhere";
    return $this->db->query($qry)->row_array();    
    }
    
    function qry_loctotaldetil(){
      $qry="select count(loc_id) as jml from transaksi_loc";
    return $this->db->query($qry)->row_array();    
    }
   
    function insertagreement($_ref, $ref_id, $ref_type, $_startdate, $_enddate, $_space, $_idr, $_foreign, $_foreign_rate,
        $currency_id, $_term, $_dayterm, $leasetype_id, $_descr, $_tlv, $_createby, $_createdate, $_modifyby, $_modifydate, 
        $channel_id, $region_id, $branch_id, $rekanan_id, $rekananshipping_line, $strukturunit_id, $transaksi_id, 
        $_formula, $_renttype, $_deduct, $_provision, $_contractno, $_startperiod, $_endperiod, $_renewalno, 
        $_isflat, $_installmentflat, $_virtualaccount, $fitting_out, $product_name, $grace_period, $size_indoor, $size_outdoor,
        $_contractlongnumber, $_loonumber, $_lanumber, $_bapdate,
        $r_code, $_channel_id, $channel_no, $r_line, $r_type, $r_sdate, $r_edate, $r_rinstm, $r_rinstd, 
        $r_pinst, $r_int, $r_titype, $r_space, $r_per, $r_base, $r_vat, $r_unit, $r_mia, $r_adendum, $r_lumpsum,
        $r_descr, $r_spdate, $r_unitspot, $r_una, $r_ninst, $c_line, $c_type, $c_sdate, $c_edate, $c_rinstm, $c_rinstd, 
        $c_pinst, $c_int, $c_titype, $c_space, $c_per, $c_base, $c_vat, $c_unit, $c_mia, $c_adendum, $c_lumpsum,
        $c_descr, $c_spdate, $c_unitspot, $c_una, $c_ninst, $de_line, $de_type, $de_sdate, $de_due, $de_titype, $de_unit, $de_space,
        $de_lumpsum, $de_base, $de_mia, $de_vat, $de_una, 
        $l_line, $l_type, $l_sdate, $l_edate, $l_rinstm, $l_rinstd, $l_pinst, $l_int, $l_due, $l_titype, $l_per, $l_unit, $l_space, 
        $l_lumpsum, $l_base, $l_mia, $l_vat, $l_una,$p_line, $p_upload, $p_post, $p_type, $p_sdate, $p_term, 
        $p_dayterm, $p_edate, $p_titype, $p_unit, $p_space, $p_idps, $p_psdesc, $p_omset, $p_lumpsum, $p_mia, $p_vat, $p_una)
    {                

        $timestamp = time();		   

        $_bapdate = (!empty($_bapdate)) ? str_replace('-', '/', $_bapdate) : '';

        $_descr = trim($_descr);

        //$_id = gen_id_agree($channel_no, 'AG','sequencer_propertymanagement', $r_code, $channel_id, $timestamp);
        $_virtualaccount = get_va($_contractno, $branch_id);

        //print_r($_term); exit;
        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);          
        
        $this->db->trans_begin(); 
        
        $sp_insertH = " EXEC [lm03_TrnAgreement_Insert] '', '', '', 0, '$_startdate', '$_enddate', $_idr, $_foreign, $_foreign_rate,
            '$currency_id', $_term, $_dayterm, '$leasetype_id', $_ref, '$_descr', 0, $_tlv, 0, 0, '$_createby', '$_createdate', '', '$now', '$channel_id', 
            '$region_id', '$branch_id', '$rekanan_id', $rekananshipping_line, '$strukturunit_id', '$transaksi_id', $_formula, $_renttype, $_deduct, 
            $_provision, '$_startdate', '$_enddate', '$_contractno', '$_renewalno', $_isflat,$_installmentflat, '$_virtualaccount', '$_contractlongnumber', 
            '$_loonumber', '$_lanumber', '$_bapdate' ";
        $result = $this->db->query($sp_insertH)->row_array();
        $_id = $result['agreement_id'];                      
        
        /** Rental Insert */
        if (is_array($r_line)){        
          foreach($r_line as $key => $n){           

            $d_line       = $r_line[$key];
            $d_type       = $r_type[$key];
            $d_sdate      = $r_sdate[$key];
            $d_edate      = $r_edate[$key];
            $d_rinstm     = $r_rinstm[$key];
            $d_rinstd     = $r_rinstd[$key];
            $d_pinst      = $r_pinst[$key];
            $d_int        = $r_int[$key];
            $d_titype     = $r_titype[$key];
            $d_space      = str_replace(',', '',$r_space[$key]);
            $d_per        = $r_per[$key];            
            $d_base       = str_replace(',', '',$r_base[$key]);
            $d_vat        = $r_vat[$key];
            $d_unit       = $r_unit[$key];
            $d_mia        = str_replace(',', '',$r_mia[$key]);
            $d_adendum    = ($r_adendum[$key]) ? 1 : 0;
            $d_lumpsum    = ($r_lumpsum[$key]) ? 1: 0;
            $d_descr      = $r_descr[$key];
            $d_spdate     = $r_spdate[$key];
            $d_unitspot   = $r_unitspot[$key];
            $d_una        = $r_una[$key];                     
            $d_ninst      = $r_ninst[$key];       
                           
            $sp_insertDT = " EXEC [lm03_TrnAgreementdetil_Insert] '$_id', $d_line, '$d_type', '$d_sdate', '$d_edate', 
              0, $d_rinstm, $d_rinstd, $d_pinst, $d_int, '$d_titype', $d_space, $_term, $d_per, $d_base, '$currency_id',
              $d_vat, 0, '$d_una', $d_mia, $d_adendum, $d_lumpsum, 0, '$d_descr', '$d_spdate', $d_ninst, '$d_unitspot', '$d_unit' ";
            $this->db->query($sp_insertDT);               
          }  
        }      
        
        /** Charge Insert */
        if (is_array($c_line)){        
          foreach($c_line as $_c => $_cv){           

            $ch_line       = $c_line[$_c];
            $ch_type       = $c_type[$_c];
            $ch_sdate      = $c_sdate[$_c];
            $ch_edate      = $c_edate[$_c];
            $ch_rinstm     = $c_rinstm[$_c];
            $ch_rinstd     = $c_rinstd[$_c];
            $ch_pinst      = $c_pinst[$_c];
            $ch_int        = $c_int[$_c];
            $ch_titype     = $c_titype[$_c];
            $ch_space      = str_replace(',', '',$c_space[$_c]);
            $ch_per        = $c_per[$_c];            
            $ch_base       = str_replace(',', '',$c_base[$_c]);
            $ch_vat        = $c_vat[$_c];
            $ch_unit       = $c_unit[$_c];
            $ch_mia        = str_replace(',', '',$c_mia[$_c]);
            $ch_adendum    = ($c_adendum[$_c]) ? 1 : 0;
            $ch_lumpsum    = ($c_lumpsum[$_c]) ? 1: 0;
            $ch_descr      = $c_descr[$_c];
            $ch_spdate     = $c_spdate[$_c];
            $ch_unitspot   = $c_unitspot[$_c];
            $ch_una        = $c_una[$_c];               
            $ch_ninst      = $c_ninst[$_c];
                           
            $sp_insertCH = " EXEC [lm03_TrnAgreementdetil_Insert] '$_id', $ch_line, '$ch_type', '$ch_sdate', '$ch_edate', 
              0, $ch_rinstm, $ch_rinstd, $ch_pinst, $ch_int, '$ch_titype', $ch_space, $_term, $ch_per, $ch_base, '$currency_id',
              $ch_vat, 0, '$ch_una', $ch_mia, $ch_adendum, $ch_lumpsum, 0, '$ch_descr', '$ch_spdate', $ch_ninst, '$ch_unitspot', '$ch_unit' ";
            $this->db->query($sp_insertCH);               
          }  
        }  
        
        /** Deposit Insert */
        if (is_array($de_line)){        
          foreach($de_line as $_d => $_dv){           

            $dp_line       = $de_line[$_d];
            $dp_type       = $de_type[$_d];
            $dp_sdate      = $de_sdate[$_d];
            $dp_due        = $de_due[$_d];
            $dp_titype     = $de_titype[$_d];
            $dp_space      = str_replace(',', '',$de_space[$_d]);
            $dp_base       = str_replace(',', '',$de_base[$_d]);
            $dp_vat        = $de_vat[$_d];
            $dp_unit       = $de_unit[$_d];
            $dp_mia        = str_replace(',', '',$de_mia[$_d]);
            $dp_lumpsum    = ($de_lumpsum[$_d]) ? 1: 0;
            $dp_una        = $de_una[$_d];             
                           
            $sp_insertDP = " EXEC [lm03TrnAgreementdeposit_Insert] '$_id', $dp_line, '$dp_type', '$dp_sdate', $dp_due,
              1, 1, '$dp_titype', 0, $dp_base, $dp_mia, 0, 1, 'IDR', $dp_vat, '$dp_una', $dp_space, $dp_lumpsum, '$dp_unit' ";
            $this->db->query($sp_insertDP);               
          }  
        }         

        /** Loan Insert */
        if (is_array($l_line)){        
          foreach($l_line as $_l => $_lv){           

            $lo_line       = $l_line[$_l];
            $lo_type       = $l_type[$_l];
            $lo_sdate      = $l_sdate[$_l];
            $lo_edate      = $l_edate[$_l];
            $lo_rinstm     = $l_rinstm[$_l];
            $lo_rinstd     = $l_rinstd[$_l];
            $lo_pinst      = $l_pinst[$_l];
            $lo_int        = $l_int[$_l];
            $lo_due        = $l_due[$_l];
            $lo_titype     = $l_titype[$_l];
            $lo_per        = $l_per[$_l];
            $lo_space      = str_replace(',', '',$l_space[$_l]);
            $lo_base       = str_replace(',', '',$l_base[$_l]);
            $lo_vat        = $l_vat[$_l];
            $lo_unit       = $l_unit[$_l];
            $lo_mia        = str_replace(',', '',$l_mia[$_l]);
            $lo_lumpsum    = ($l_lumpsum[$_l]) ? 1: 0;
            $lo_una        = $l_una[$_l];             
                           
            $sp_insertLO = " EXEC [lm03TrnLoan_Insert] '$_id', $lo_line, '$lo_type', '$lo_sdate', '$lo_edate', $lo_pinst,
              $lo_rinstm, 0, $lo_int, '$lo_titype', $lo_per, $lo_mia, 0, 0, 1, 0, 'IDR', $lo_vat, '', '$lo_una',
              $lo_space, $lo_lumpsum, '$lo_unit' ";
            $this->db->query($sp_insertLO);               
          }  
        }   
        /** Profit Sharing Insert */
        if (is_array($p_line)){ 
            foreach($p_line as $key => $n){            
                $pro_line         = $p_line[$key];
                $pro_upload       = $p_upload[$key];
                $pro_post         = $p_post[$key];
                $pro_type         = $p_type[$key];
                $pro_sdate        = $p_sdate[$key];
                $pro_term         = $p_term[$key];
                $pro_dayterm      = $p_dayterm[$key];
                $pro_edate        = $p_edate[$key];
                $pro_titype       = $p_titype[$key];
                $pro_unit         = $p_unit[$key];
                $pro_space        = str_replace(',', '',$p_space[$key]);
                $pro_idps         = $p_idps[$key];
                $pro_psdesc       = $p_psdesc[$key];
                $pro_omset        = str_replace(',', '',$p_omset[$key]);
                $pro_lumpsum      = $p_lumpsum[$key];
                $pro_mia          = str_replace(',', '',$p_mia[$key]);
                $pro_vat          = $p_vat[$key];
                $pro_una          = $p_una[$key];

                $sp_insertPS = " EXEC [lm03_TrnAgreementps_Insert] '$_id', $pro_line, '$pro_type', '$pro_sdate', '$pro_edate', 
                    0, 0, 0, '$pro_titype', '$pro_una', $pro_space, $pro_term, $pro_upload, $pro_post, $pro_mia, $pro_omset, '$currency_id',
                    $pro_vat, 0, 1, 0, '$pro_psdesc', '$pro_idps', $pro_lumpsum, '$pro_unit', $pro_dayterm ";
                $this->db->query($sp_insertPS);             
            } 
        }

        /** LOI Master Insert */
        $sp_insertPLOI = " EXEC [lm03Trnagreement_LOIMasterInsert] '$_id', '$product_name', $fitting_out, $grace_period, $size_indoor, $size_outdoor ";
        $this->db->query($sp_insertPLOI);  

        $sp_rentalTLV = "EXEC [lm03_TrnAgreementdetil_UpdateTLV] '$_id' ";
        $this->db->query($sp_rentalTLV);       

        $sp_depositTLV = "EXEC [lm03_TrnAgreementdeposit_UpdateTLV] '$_id' ";
        $this->db->query($sp_depositTLV);
			
      if ($this->db->trans_status() === FALSE)
      { 
          $this->db->trans_rollback();
          return false;
      }else{
          $this->db->trans_commit();

          return $_id;  
      }				  
    }

  function vdetilrental($_id){          
        $sql = "
          SELECT AGD.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name
          FROM transaksi_agreementdetil AGD
            LEFT JOIN master_unit UNIT ON UNIT.unit_id = AGD.unit_id
            LEFT JOIN master_agreementtype AT ON AT.agreementtype_id = AGD.agreementtype_id            
          WHERE AGD.agreement_id = '$_id' 
            AND AT.agreementtype_type IN ('RENTAL', 'RENTAL TEMP')
            AND AGD.agreementdetil_isnotcount = 0
          ORDER BY  agreement_id, agreementdetil_line ASC";  
    return $this->db->query($sql)->result();      
  }  

  function vdetilcharge($_id){          
        $sql = "
          SELECT AGD.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name
          FROM transaksi_agreementdetil AGD
            LEFT JOIN master_unit UNIT ON UNIT.unit_id = AGD.unit_id
            LEFT JOIN master_agreementtype AT ON AT.agreementtype_id = AGD.agreementtype_id            
          WHERE AGD.agreement_id = '$_id' 
            AND AT.agreementtype_type IN ('SERVICE', 'OTHER')
            AND AGD.agreementdetil_isnotcount = 0
          ORDER BY  agreement_id, agreementdetil_line ASC";          

    return $this->db->query($sql)->result();      
  }

  function vdetildeposit($_id){          
        $sql = "
          SELECT AGD.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name
          FROM transaksi_agreementdeposit AGD
            LEFT JOIN master_unit UNIT ON UNIT.unit_id = AGD.unit_id
            LEFT JOIN master_agreementtype AT ON AT.agreementtype_id = AGD.agreementtype_id            
          WHERE AGD.agreement_id = '$_id' 
            AND AT.agreementtype_type IN ('DEPOSIT')            
          ORDER BY  agreement_id, agreementdeposit_line ASC";  
    return $this->db->query($sql)->result();      
  }

  function vdetilloan($_id){          
        $sql = "
          SELECT AGD.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name
          FROM transaksi_loan AGD
            LEFT JOIN master_unit UNIT ON UNIT.unit_id = AGD.unit_id
            LEFT JOIN master_agreementtype AT ON AT.agreementtype_id = AGD.agreementtype_id            
          WHERE AGD.agreement_id = '$_id'         
          ORDER BY  agreement_id, agreementloan_line ASC";  
    return $this->db->query($sql)->result();      
  }

  function vdetilprofits($_id){          
        $sql = "
          SELECT ATP.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name
          FROM transaksi_agreementps ATP
            LEFT JOIN master_unit UNIT ON UNIT.unit_id = ATP.unit_id
            LEFT JOIN master_agreementtype AT ON AT.agreementtype_id = ATP.agreementtype_id            
          WHERE ATP.agreement_id = '$_id'         
          ORDER BY  agreement_id, agreementps_line ASC";  
    return $this->db->query($sql)->result();      
  }
		    
	function updateagreement($_ref, $ref_id, $ref_type, $_startdate, $_enddate, $_space, 
        $_idr, $_foreign, $_foreign_rate, $currency_id, $_term, $_dayterm, $leasetype_id, $_descr, 
        $_tlv, $_createby, $_createdate, $_modifyby, $_modifydate, 
        $channel_id, $region_id, $branch_id, $rekanan_id, $rekananshipping_line, $strukturunit_id, $transaksi_id, 
        $_formula, $_renttype, $_deduct, $_provision, $_contractno, $_startperiod, $_endperiod, $_renewalno, 
        $_isflat, $_installmentflat, $_virtualaccount, $fitting_out, $product_name, $grace_period, $size_indoor, $size_outdoor,
        $_contractlongnumber, $_loonumber, $_lanumber, $_bapdate,
        $r_code, $_channel_id, $channel_no, $r_line, $r_type, $r_sdate, $r_edate, $r_rinstm, $r_rinstd, 
        $r_pinst, $r_int, $r_titype, $r_space, $r_per, $r_base, $r_vat, $r_unit, $r_mia, $r_adendum, $r_lumpsum,
        $r_descr, $r_spdate, $r_unitspot, $r_una, $r_ninst, $c_line, $c_type, $c_sdate, $c_edate, $c_rinstm, $c_rinstd, 
        $c_pinst, $c_int, $c_titype, $c_space, $c_per, $c_base, $c_vat, $c_unit, $c_mia, $c_adendum, $c_lumpsum,
        $c_descr, $c_spdate, $c_unitspot, $c_una, $c_ninst, $de_line, $de_type, $de_sdate, $de_due, $de_titype, $de_unit, $de_space,
        $de_lumpsum, $de_base, $de_mia, $de_vat, $de_una, 
        $l_line, $l_type, $l_sdate, $l_edate, $l_rinstm, $l_rinstd, $l_pinst, $l_int, $l_due, $l_titype, $l_unit, $l_space, 
        $l_lumpsum, $l_base, $l_mia, $l_vat, $l_una, $p_line, $p_upload, $p_post, $p_type, $p_sdate, $p_term, 
        $p_dayterm, $p_edate, $p_titype, $p_unit, $p_space, $p_idps, $p_psdesc, $p_omset, $p_lumpsum, $p_mia, $p_vat, $p_una,
        $agreement_id, $rstate, $cstate, $dstate, $l_state, $p_state, $deleted){          
      
        $_virtualaccount = get_va($_contractno, $branch_id);        

        $_bapdate = (!empty($_bapdate)) ? str_replace('-', '/', $_bapdate) : '';

        $_descr = trim($_descr);

        $_installmentflat = !empty($_installmentflat) ? $_installmentflat : 0;
        $_dayterm = str_replace(',', '',$_dayterm);
 
  		  $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);

        $this->db->trans_begin(); 
        
        $sp_updateH = " EXEC [lm03_TrnAgreement_Update] '{$agreement_id}', '', '', 0, '$_startdate', '$_enddate', $_idr, $_foreign, $_foreign_rate,
            '$currency_id', $_term, $_dayterm, '$leasetype_id', $_ref, '$_descr', 0, $_tlv, 0, 0, '$_createby', '$_createdate', '', '$now', '$channel_id', 
            '$region_id', '$branch_id', '$rekanan_id', $rekananshipping_line, '$strukturunit_id', '$transaksi_id', $_formula, $_renttype, $_deduct, 
            $_provision, '$_startdate', '$_enddate', '$_contractno', '$_renewalno', $_isflat,$_installmentflat, '$_virtualaccount', '$_contractlongnumber', 
            '$_loonumber', '$_lanumber', '$_bapdate' ";
        $this->db->query($sp_updateH);                     
        
        if (is_array($deleted)){
          if (count($deleted) >0){
            foreach($deleted as $key => $_k){  
                
                $del = explode("|", $deleted[$key]);

                $tipe = $del[0];
                $line = $del[1];

                switch ($tipe) {
                    case "rental":                          
                        $this->db->query("DELETE FROM transaksi_agreementdetil WHERE agreement_id='{$agreement_id}' AND agreementdetil_line = $line ");
                        break;
                    case "deposit":                          
                        $this->db->query("DELETE FROM transaksi_agreementdeposit WHERE agreement_id='{$agreement_id}' AND agreementdeposit_line = $line ");
                        break;
                    case "charge":                          
                        $this->db->query("DELETE FROM transaksi_agreementdetil WHERE agreement_id='{$agreement_id}' AND agreementdetil_line = $line");
                        break;
                    case "loan":                          
                      $this->db->query("DELETE FROM transaksi_loan WHERE agreement_id='{$agreement_id}' AND agreementloan_line = $line ");
                      break; 
                    case "profits":                          
                      $this->db->query("DELETE FROM transaksi_agreementps WHERE agreement_id='{$agreement_id}' AND agreementps_line = $line ");
                      break;  
                }
            }
          }
        }                                         

        if (is_array($r_line)){ 

          foreach($r_line as $key => $n){           

            $d_line       = $r_line[$key];
            $d_type       = $r_type[$key];
            $d_sdate      = $r_sdate[$key];
            $d_edate      = $r_edate[$key];
            $d_rinstm     = $r_rinstm[$key];
            $d_rinstd     = $r_rinstd[$key];
            $d_pinst      = $r_pinst[$key];
            $d_int        = $r_int[$key];
            $d_titype     = $r_titype[$key];
            $d_space      = str_replace(',', '',$r_space[$key]);
            $d_per        = str_replace(',', '',$r_per[$key]);
            $d_base       = str_replace(',', '',$r_base[$key]);
            $d_vat        = $r_vat[$key];
            $d_unit       = $r_unit[$key];
            $d_mia        = str_replace(',', '',$r_mia[$key]);
            $d_adendum    = ($r_adendum[$key]) ? 1 : 0;
            $d_lumpsum    = ($r_lumpsum[$key]) ? 1: 0;
            $d_descr      = $r_descr[$key];
            $d_spdate     = $r_spdate[$key];
            $d_unitspot   = $r_unitspot[$key];
            $d_una        = $r_una[$key];
            $d_ninst      = $r_ninst[$key];
            $d_state      = $rstate[$key];   
            

            if ($d_state == "update") {
                $sp_updateDT = " EXEC [lm03_TrnAgreementdetil_Update] '{$agreement_id}', $d_line, '$d_type', '$d_sdate', '$d_edate', 
                  0, $d_rinstm, $d_rinstd, $d_pinst, $d_int, '$d_titype', $d_space, $_term, $d_per, $d_base, '$currency_id',
                  $d_vat, 0, '$d_una', $d_mia, $d_adendum, $d_lumpsum, 0, '$d_descr', '$d_spdate', $d_ninst, '$d_unitspot', '$d_unit' ";
                $this->db->query($sp_updateDT);                 
              //print_r($sp_updateDT);exit;
            } else {
                $sp_InsertDT = " EXEC [lm03_TrnAgreementdetil_Insert] '{$agreement_id}', $d_line, '$d_type', '$d_sdate', '$d_edate', 
                  0, $d_rinstm, $d_rinstd, $d_pinst, $d_int, '$d_titype', $d_space, $_term, $d_per, $d_base, '$currency_id',
                  $d_vat, 0, '$d_una', $d_mia, $d_adendum, $d_lumpsum, 0, '$d_descr', '$d_spdate', $d_ninst, '$d_unitspot', '$d_unit' ";
                $this->db->query($sp_InsertDT);
            }

          }          
          
        }     

        if (is_array($c_line)){ 
          foreach($c_line as $_c => $_cv){
            $ch_line       = $c_line[$_c];
            $ch_type       = $c_type[$_c];
            $ch_sdate      = $c_sdate[$_c];
            $ch_edate      = $c_edate[$_c];
            $ch_rinstm     = $c_rinstm[$_c];
            $ch_rinstd     = $c_rinstd[$_c];
            $ch_pinst      = $c_pinst[$_c];
            $ch_int        = $c_int[$_c];
            $ch_titype     = $c_titype[$_c];
            $ch_space      = str_replace(',', '',$c_space[$_c]);
            $ch_per        = str_replace(',', '',$c_per[$_c]);
            $ch_base       = str_replace(',', '',$c_base[$_c]);
            $ch_vat        = $c_vat[$_c];
            $ch_unit       = $c_unit[$_c];
            $ch_mia        = str_replace(',', '',$c_mia[$_c]);
            $ch_adendum    = ($c_adendum[$_c]) ? 1 : 0;
            $ch_lumpsum    = ($c_lumpsum[$_c]) ? 1: 0;
            $ch_descr      = $c_descr[$_c];
            $ch_spdate     = $c_spdate[$_c];
            $ch_unitspot   = $c_unitspot[$_c];
            $ch_una        = $c_una[$_c];
            $ch_ninst      = $c_ninst[$_c];
            $ch_state      = $cstate[$_c];

            if ($ch_state == "update") {
                $sp_updateCH = " EXEC [lm03_TrnAgreementdetil_Update] '{$agreement_id}', $ch_line, '$ch_type', '$ch_sdate', '$ch_edate', 
                  0, $ch_rinstm, $ch_rinstd, $ch_pinst, $ch_int, '$ch_titype', $ch_space, $_term, $ch_per, $ch_base, '$currency_id',
                  $ch_vat, 0, '$ch_una', $ch_mia, $ch_adendum, $ch_lumpsum, 0, '$ch_descr', '$ch_spdate', $ch_ninst, '$ch_unitspot', '$ch_unit' ";
                $this->db->query($sp_updateCH);    
            } else {
                $sp_insertCH = " EXEC [lm03_TrnAgreementdetil_Insert] '{$agreement_id}', $ch_line, '$ch_type', '$ch_sdate', '$ch_edate', 
                  0, $ch_rinstm, $ch_rinstd, $ch_pinst, $ch_int, '$ch_titype', $ch_space, $_term, $ch_per, $ch_base, '$currency_id',
                  $ch_vat, 0, '$ch_una', $ch_mia, $ch_adendum, $ch_lumpsum, 0, '$ch_descr', '$ch_spdate', $ch_ninst, '$ch_unitspot', '$ch_unit' ";
                $this->db->query($sp_insertCH);
            }

          }  
        }     

        if (is_array($de_line)){ 
          foreach($de_line as $_d => $_dv){           

            $dp_line       = $de_line[$_d];
            $dp_type       = $de_type[$_d];
            $dp_sdate      = $de_sdate[$_d];
            $dp_due        = $de_due[$_d];
            $dp_titype     = $de_titype[$_d];
            $dp_space      = str_replace(',', '',$de_space[$_d]);
            $dp_base       = str_replace(',', '',$de_base[$_d]);
            $dp_vat        = $de_vat[$_d];
            $dp_unit       = $de_unit[$_d];
            $dp_mia        = str_replace(',', '',$de_mia[$_d]);
            $dp_lumpsum    = ($de_lumpsum[$_d]) ? 1: 0;
            $dp_una        = $de_una[$_d];
            $dp_state      = $dstate[$_d];                

            if ($dp_state == "update") {
                $sp_updateDP = " EXEC [lm03TrnAgreementdeposit_Update] '{$agreement_id}', $dp_line, '$dp_type', '$dp_sdate', $dp_due,
                  1, 1, '$dp_titype', 0, $dp_base, $dp_mia, 0, 1, 'IDR', $dp_vat, '$dp_una', $dp_space, $dp_lumpsum, '$dp_unit' ";
                $this->db->query($sp_updateDP);
            } else {
                $sp_insertDP = " EXEC [lm03TrnAgreementdeposit_Insert] '{$agreement_id}', $dp_line, '$dp_type', '$dp_sdate', $dp_due,
                  1, 1, '$dp_titype', 0, $dp_base, $dp_mia, 0, 1, 'IDR', $dp_vat, '$dp_una', $dp_space, $dp_lumpsum, '$dp_unit' ";
                $this->db->query($sp_insertDP);
            }
            
          }  
        }  
        
        /** Loan Insert */
        if (is_array($l_line)){        
          foreach($l_line as $_l => $_lv){           

            $lo_line       = $l_line[$_l];
            $lo_type       = $l_type[$_l];
            $lo_sdate      = $l_sdate[$_l];
            $lo_edate      = $l_edate[$_l];
            $lo_rinstm     = $l_rinstm[$_l];
            $lo_rinstd     = $l_rinstd[$_l];
            $lo_pinst      = $l_pinst[$_l];
            $lo_int        = $l_int[$_l];
            $lo_due        = $l_due[$_l];
            $lo_titype     = $l_titype[$_l];
            $lo_per        = $l_per[$_l];
            $lo_space      = str_replace(',', '',$l_space[$_l]);
            $lo_base       = str_replace(',', '',$l_base[$_l]);
            $lo_vat        = $l_vat[$_l];
            $lo_unit       = $l_unit[$_l];
            $lo_mia        = str_replace(',', '',$l_mia[$_l]);
            $lo_lumpsum    = ($l_lumpsum[$_l]) ? 1: 0;
            $lo_una        = $l_una[$_l];             
            $lo_state      = $l_state[$_l];  
             
            if ($lo_state == "update") {
                $sp_updateLO = " EXEC [lm03TrnLoan_Update] '{$agreement_id}', $lo_line, '$lo_type', '$lo_sdate', '$lo_edate', $lo_pinst,
                  $lo_rinstm, 0, $lo_int, '$lo_titype', $lo_per, $lo_mia, 0, 0, 1, 0, 'IDR', $lo_vat, '', '$lo_una',
                  $lo_space, $lo_lumpsum, '$lo_unit' ";
                $this->db->query($sp_updateLO);
            } else {
                $sp_insertLO = " EXEC [lm03TrnLoan_Insert] '{$agreement_id}', $lo_line, '$lo_type', '$lo_sdate', '$lo_edate', $lo_pinst,
                  $lo_rinstm, 0, $lo_int, '$lo_titype', $lo_per, $lo_mia, 0, 0, 1, 0, 'IDR', $lo_vat, '', '$lo_una',
                  $lo_space, $lo_lumpsum, '$lo_unit' ";
                $this->db->query($sp_insertLO); 
            }               
          }  
        }   
        /** Profit Sharing Insert */
        if (is_array($p_line)){ 
          foreach($p_line as $key => $n){            
              $pro_line         = $p_line[$key];
              $pro_upload       = $p_upload[$key];
              $pro_post         = $p_post[$key];
              $pro_type         = $p_type[$key];
              $pro_sdate        = $p_sdate[$key];
              $pro_term         = $p_term[$key];
              $pro_dayterm      = $p_dayterm[$key];
              $pro_edate        = $p_edate[$key];
              $pro_titype       = $p_titype[$key];
              $pro_unit         = $p_unit[$key];
              $pro_space        = str_replace(',', '',$p_space[$key]);
              $pro_idps         = $p_idps[$key];
              $pro_psdesc       = $p_psdesc[$key];
              $pro_omset        = str_replace(',', '',$p_omset[$key]);
              $pro_lumpsum      = $p_lumpsum[$key];
              $pro_mia          = str_replace(',', '',$p_mia[$key]);
              $pro_vat          = $p_vat[$key];
              $pro_una          = $p_una[$key];
              $pro_state        = $p_state[$key];

              if ($pro_state == "update") {
                  $sp_updatePS = " EXEC [lm03_TrnAgreementps_Update] '{$agreement_id}', $pro_line, '$pro_type', '$pro_sdate', '$pro_edate', 
                    0, 0, 0, '$pro_titype', '$pro_una', $pro_space, $pro_term, $pro_upload, $pro_post, $pro_mia, $pro_omset, '$currency_id',
                    $pro_vat, 0, 1, 0, '$pro_psdesc', '$pro_idps', $pro_lumpsum, '$pro_unit', $pro_dayterm ";
                  $this->db->query($sp_updatePS);
              } else {
                  $sp_insertPS = " EXEC [lm03_TrnAgreementps_Insert] '{$agreement_id}', $pro_line, '$pro_type', '$pro_sdate', '$pro_edate', 
                    0, 0, 0, '$pro_titype', '$pro_una', $pro_space, $pro_term, $pro_upload, $pro_post, $pro_mia, $pro_omset, '$currency_id',
                    $pro_vat, 0, 1, 0, '$pro_psdesc', '$pro_idps', $pro_lumpsum, '$pro_unit', $pro_dayterm ";
                  $this->db->query($sp_insertPS);
              }          
          } 
        }

        /** LOI Master Insert */
        $sp_updatePLOI = " EXEC [lm03Trnagreement_LOIMasterUpdate] '{$agreement_id}', '$product_name', $fitting_out, $grace_period, $size_indoor, $size_outdoor ";
        $this->db->query($sp_updatePLOI); 

        $sp_rentalTLV = "EXEC [lm03_TrnAgreementdetil_UpdateTLV] '{$agreement_id}' ";
        $this->db->query($sp_rentalTLV);       

        $sp_depositTLV = "EXEC [lm03_TrnAgreementdeposit_UpdateTLV] '{$agreement_id}' ";
        $this->db->query($sp_depositTLV);
			
      if ($this->db->trans_status() === FALSE)
      { 
          $this->db->trans_rollback();
          return false;
      }else{
          $this->db->trans_commit();

          return $agreement_id;  
      }
  }
	
	function deleteagreement($_id, $_username){    
   
    /*
		$this->db->query("delete from transaksi_agreement where agreement_id='$_id'");
		$this->db->query("delete from transaksi_agreementdetil where agreement_id='$_id'");
    $this->db->query("delete from transaksi_agreementdeposit where agreement_id='$_id'");
    //$this->db->query("delete from transaksi_loounit where loo_id='$loo_id'");
    */
    $timestamp = time();
    $now = date("Y-m-d H:i:s", $timestamp);   

    $sp_deleteAG = "EXEC [lm03_TrnAgreement_Delete] '$_id', '', '', '$now', '$now', '', 0, 0, 0, 1, 'IDR', 0, 
        '', 0, '', 0, 0, 0, 0, '$_username', '$now', '$_username', '$now', '', '', '', '', 0, '', '' ";
    $this->db->query($sp_deleteAG);    

    $sp_deletePLOI = "EXEC [lm03_TrnAgreement_DeletePrintLOI] '$_id' ";
    $this->db->query($sp_deletePLOI);
	}
    
	
function qrycekstatus_ag($agreement_id){
	$sq=$this->db->query("select a.strukturunitapprovalauth_name,(CASE WHEN b.agreementverifyapproval_action='VERIFIED'
      THEN 'VERIFIED'
      ELSE 'NOT YET'
 END) AS verification
from master_strukturunitapprovalauth a left join transaksi_verifyagreemnetapproval b
on a.username=b.agreementverifyapproval_username and b.agreement_id='$agreement_id'
where a.strukturunitapprovalauth_type='AG-VRF'")->result();

return $sq;
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
              agreement_contractno, agreement_renewalno, agreement_isflat, agreement_installmentflat, agreement_dayterm,
              AGR.branch_id, AGR.rekanan_id, AGR.rekananshipping_line, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name,
              TRANS.transaksi_name, agreement_loonumber, pLOI.dagangan, pLOI.fitting_out, pLOI.grace_periode, pLOI.size_indoor, pLOI.size_outdoor,
              agreement_bapdate, agreement_contractlongnumber
           FROM transaksi_agreement AS AGR 
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
                        'transaksi_name'          => 'Pencatatan Leasing',
                        'agreement_contractlongnumber' => ''
       ); 

       return $result;
     }

   }
   
   function viewlooprint($loo_id){     

     if (isset($loo_id)){
        return $this->db->query("
           select top 1 LOO.loo_id, convert(varchar(10),loo_date,120) AS loo_date, 
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,c.rekanancontact_name,
			  REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,l.lantai_name,u.unit_name,u.unit_sqm,d.loodetil_baserent
			  
           from transaksi_loo AS LOO 
		   JOIN transaksi_loodetil d on LOO.loo_id=d.loo_id
		   JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
			  JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
			  JOIN master_unit u on u.unit_id=d.unit_id
			  JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOO.loo_id='$loo_id'
       ")->result();        
	 }

   }



 function confirmloo($arrCon){   

     $action = "return";   

     if (is_array($arrCon)){
       if (count($arrCon) >0){
          foreach ($arrCon as $filt){   

            $loo_id     = $filt[0];
            $region_id  = $filt[1];
            $branch_id  = $filt[2];           

            $timestamp = time();

            //$this->db->trans_begin();

            $this->db->query(" UPDATE transaksi_loo SET isconfirm = '1' WHERE loo_id = '$loo_id' ");

            $u_sql = " SELECT DISTINCT unit_id FROM transaksi_loodetil WHERE loo_id = '$loo_id' ";

            $q_uid = $this->db->query($u_sql)->result_array();

            foreach($q_uid as $uid){

              $unit_id = $uid['unit_id'];
              $this->db->query("UPDATE master_unit SET unit_state = 3 WHERE unit_id = '$unit_id' and region_id = '$region_id' and branch_id = '$branch_id' ");

            }
/*
            if ($this->db->trans_status() === FALSE)
            {
                //generate an error... or use the log_message() function to log your error                
                $this->db->trans_rollback();
                return false;
            }else{
                $this->db->trans_commit();
                return true;
            }
*/
          }  
       }
     }

   }

   function approveagreement($arrapp, $username, $channel_id){   

    $action = "unapprove";   
	$ck=0;
     if (is_array($arrapp)){
       if (count($arrapp) >0){
          foreach ($arrapp as $key){            

            $amor_id   = $key['id'];
            $line_id     = $key['line_id'];
            $agtype_id= $key['agtype_id'];
			$jdate = $key['vjdate'];
	if ($jdate==''){
		$ck=0;
	}else{
			$ck=1;
	}

            $this->db->trans_begin();            

            $ag_posting = "EXEC lm03_TrnScheduleamortisasi_posted '{$amor_id}','$line_id','{$username}',1,'$agtype_id','2019-10-30','$jdate',$ck ";
            $this->db->query($ag_posting);    
            //echo $this->db->last_query(); exit;

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
   
    function disapproveagreement($arrapp, $username, $channel_id){   

    $action = "unapprove";   
	$ck=0;
     if (is_array($arrapp)){
       if (count($arrapp) >0){
          foreach ($arrapp as $key){            

            $amor_id   = $key['id'];
            $line_id     = $key['line_id'];
            $agtype_id= $key['agtype_id'];
			$jdate = $key['vjdate'];
	if ($jdate==''){
		$ck=0;
	}else{
			$ck=1;
	}

            $this->db->trans_begin();            

            $ag_posting = "EXEC lm03_TrnScheduleamortisasi_posted '{$amor_id}','$line_id','{$username}',0,'$agtype_id','2019-10-30','$jdate',$ck ";
            $this->db->query($ag_posting);    
            //echo $this->db->last_query(); exit;

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
   
    function disableeagreement($arrapp, $username, $channel_id){   

    $action = "unapprove";   
	$ck=0;
     if (is_array($arrapp)){
       if (count($arrapp) >0){
          foreach ($arrapp as $key){            

            $amor_id   = $key['id'];
            $line_id     = $key['line_id'];
            $agtype_id= $key['agtype_id'];

            $this->db->trans_begin();            

            $ag_posting = "EXEC lm03_TrnScheduleamortisasi_disabled '{$amor_id}','$line_id','{$username}',1,'$agtype_id' ";
            $this->db->query($ag_posting);    
            //echo $this->db->last_query(); exit;

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
   
    function enableagreement($arrapp, $username, $channel_id){   

    $action = "unapprove";   
	$ck=0;
     if (is_array($arrapp)){
       if (count($arrapp) >0){
          foreach ($arrapp as $key){            

            $amor_id   = $key['id'];
            $line_id     = $key['line_id'];
            $agtype_id= $key['agtype_id'];

            $this->db->trans_begin();            

            $ag_posting = "EXEC lm03_TrnScheduleamortisasi_disabled '{$amor_id}','$line_id','{$username}',0,'$agtype_id' ";
            $this->db->query($ag_posting);    
            //echo $this->db->last_query(); exit;

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


   function dataconf($uid){        

        $sql = " 
          SELECT DISTINCT LOH.*, 
            REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, 
            UNIT.unit_name, LOD.unit_id
          FROM transaksi_loo LOH
            JOIN transaksi_loounit LOU ON LOU.loo_id = LOH.loo_id
            JOIN transaksi_loodetil LOD ON LOH.loo_id = LOD.loo_id
            JOIN master_region AS REGION ON LOU.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOU.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOU.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOU.rekanan_id = BRAND.rekanan_id AND LOU.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOU.region_id AND UNIT.branch_id = LOU.branch_id
          WHERE LOH.isconfirm = '0' AND LOH.isapproved = '1'  AND UNIT.unit_state <> '3' AND LOD.unit_id like '%{$uid}%' 
          ORDER BY loo_id desc ";    

        return $this->db->query($sql)->result_array();
    }

    function dataapplist($criteria){
		//$regionid='001';
		//$criteria = "b.scheduleamortisasi_id=''$id''";
		//$criteria = " scheduleamortisasidetil_isposted=0 and scheduleamortisasidetil_isproforma=1  AND  ( a.region_id=''$regionid'') ";
        $sql ="EXEC [tm_TrnScheduleamortisasidetil_SelectPosting] 'TSMB', '$criteria',  '2019-12-31','001'    
           ";

        var_dump($sql);exit;

        return $this->db->query($sql)->result_array();
    }


 function dataapplistenable($criteria){
		//$regionid='001';
		//$criteria = "b.scheduleamortisasi_id=''$id''";
		//$criteria = " scheduleamortisasidetil_isposted=0 and scheduleamortisasidetil_isproforma=1  AND  ( a.region_id=''$regionid'') ";
        $sql ="EXEC [tm_TrnScheduleamortisasidetil_SelectPostingenable] 'TSMB', '$criteria',  '2019-12-12','001'    
           ";

        return $this->db->query($sql)->result_array();
    }
    function dataunapplist(){

        $sql = " 
          SELECT 
            AGR.agreement_id, AGR.agreement_isrenewal, AGR.agreement_isapproved, AGR.agreement_isclosed     
            ,REKAN.rekanan_name
            ,BRAND.rekananshipping_name
            ,AGR.agreement_contractno,REGION.region_nameshort,BRANCH.branch_name
            ,AGR.agreement_contractlongnumber,AGR.agreement_startdate,AGR.agreement_enddate,AGR.agreement_term
            ,AGR.agreement_idr,AGR.agreement_tlv,AGR.agreement_descr,AGR.agreement_createby,AGR.agreement_createdate
            ,AGR.agreement_modifyby,AGR.agreement_modifydate, AGR.ref_id, AGR.agreement_renewalno
          FROM transaksi_agreement AGR
            JOIN master_region AS REGION ON AGR.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON AGR.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON AGR.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON AGR.rekanan_id = BRAND.rekanan_id AND AGR.rekananshipping_line = BRAND.rekananshipping_line 
          WHERE AGR.agreement_isapproved = 1 AND AGR.agreement_isclosed = 0
          ORDER BY agreement_id desc ";

        return $this->db->query($sql)->result_array();
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
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOH.region_id AND UNIT.branch_id = LOH.branch_id
          WHERE LOH.isapproved = '0' AND LOH.isconfirm = '1' AND LOD.unit_id like '%{$uid}%' ";    

        return $this->db->query($sql)->result_array();
    }
    
 function getunitloo($uid){
  $sql="select distinct c.unit_name,c.unit_sqm from dbo.transaksi_loodetil a
     inner join transaksi_loo b on a.loo_id=b.loo_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.loo_id='$uid' and a.agreementtype_id='4000'";  
     return $this->db->query($sql)->result(); 
 }
 
  function gethargasewa($uid){
  $sql="select  a.loodetil_descr+' (' +c.unit_name+' )' as titleharga,a.loodetil_baserent  from dbo.transaksi_loodetil a
     inner join transaksi_loo b on a.loo_id=b.loo_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.loo_id='$uid' and a.agreementtype_id='4000' order by a.unit_id,a.loodetil_line asc"; 
    return $this->db->query($sql)->result(); 
 }
 
 function getservicecharge($uid){
  $sql="select SUM(loodetil_baserent) as servicecharge from transaksi_loodetil 
  where loo_id='$uid' and agreementtype_id='5000'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
  function getpromolevy($uid){
  $sql="select SUM(loodetil_baserent) as promolevy from transaksi_loodetil 
  where loo_id='$uid' and agreementtype_id='6000'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
  function getdepositr($uid){
  $sql="select loodetil_int as depositr,loodetil_baserent from transaksi_loodetil 
  where loo_id='$uid' and agreementtype_id='7000'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
 function viewconfprint($loo_id){     

     if (isset($loo_id)){
        return $this->db->query("
           select top 1 LOO.loo_id,LOO.conf_id, convert(varchar(10),loo_date,120) AS loo_date, 
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
           where LOO.loo_id='$loo_id'
       ")->result();        
   }

 }

 function getdataloo($id, $rek_id, $bra_id){

  $qry= " 
      SELECT l.loo_id, l.loo_descr, l.loo_date, l._createby, l._createdate, l.isapproved, l.isconfirm, l.isdisabled,
            l.size_indoor, l.size_outdoor, l.fitting_out, l.grace_period, l.product_name, d.loodetil_line, d.loodetil_space,
            d.loodetil_int, d.loodetil_descr, d.loodetil_baserent, d.loodetil_ispercent, d.loodetil_percent, d.agreementtype_id, t.agreementtype_name,
            d.unit_id as unit, k.*, un.*,
            u.unit_name, u.unit_sqm,u.unit_state, r.rekanan_name, rs.rekananshipping_name, b.branch_name, rg.region_name, t.agreementtype_type, t.agreementtype_group
      FROM transaksi_loo l 
        left join transaksi_loodetil d on l.loo_id = d.loo_id 
        left join transaksi_loounit un on d.loo_id=un.loo_id and d.unit_id=un.unit_id
        left join master_skl k on l.skl_id = k.skl_id 
        left join master_unit u on un.branch_id = u.branch_id and un.unit_id = u.unit_id 
        left join master_rekanan r on un.rekanan_id = r.rekanan_id 
        left join master_rekananshipping rs on un.rekanan_id = rs.rekanan_id and un.rekananshipping_line = rs.rekananshipping_line 
        left join master_branch b on un.branch_id = b.branch_id 
        left join master_region rg on un.region_id = rg.region_id 
        left join master_agreementtype t on d.agreementtype_id = t.agreementtype_id 
      WHERE l.loo_id ='{$id}' and un.rekanan_id='{$rek_id}' and  un.branch_id='{$bra_id}' and loo_type =0 and isapproved=1 and isnull(isdisabled,0)=0 ";      

  return $this->db->query($qry)->result_array();   
 }   

 function getdataloc($id, $rek_id, $bra_id){

  $qry= " 
      SELECT l.loc_id, l.loc_descr, l.loc_date, l._createby, l._createdate, l.isapproved, l.isconfirm, l.isdisabled,
            l.size_indoor, l.size_outdoor, l.fitting_out, l.grace_period, l.product_name, d.locdetil_line, d.locdetil_space,
            d.locdetil_int, d.locdetil_descr, d.locdetil_baserent, d.locdetil_ispercent, d.locdetil_percent, d.agreementtype_id, t.agreementtype_name,
            d.unit_id as unit, k.*, un.*,
            u.unit_name, u.unit_sqm,u.unit_state, r.rekanan_name, rs.rekananshipping_name, b.branch_name, rg.region_name, t.agreementtype_type, t.agreementtype_group
      FROM transaksi_loc l 
        left join transaksi_locdetil d on l.loc_id = d.loc_id 
        left join transaksi_locunit un on d.loc_id=un.loc_id and d.unit_id=un.unit_id
        left join master_skl k on l.skl_id = k.skl_id 
        left join master_unit u on un.branch_id = u.branch_id and un.unit_id = u.unit_id 
        left join master_rekanan r on un.rekanan_id = r.rekanan_id 
        left join master_rekananshipping rs on un.rekanan_id = rs.rekanan_id and un.rekananshipping_line = rs.rekananshipping_line 
        left join master_branch b on un.branch_id = b.branch_id 
        left join master_region rg on un.region_id = rg.region_id 
        left join master_agreementtype t on d.agreementtype_id = t.agreementtype_id 
      WHERE l.loc_id ='{$id}' and un.rekanan_id='{$rek_id}' and  un.branch_id='{$bra_id}' and loc_type =0 and isapproved=1 and isnull(isdisabled,0)=0 ";            
      
  return $this->db->query($qry)->result_array();   
 }

 function getPassword($id){

  $qry= " SELECT A.*, B.agreementtype_name
          FROM master_sklterm A inner join master_agreementtype B ON A.skl_atype = B.agreementtype_id
          WHERE A.skl_id = '{$id}' ";

  return $this->db->query($qry)->result_array();   
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
    
}
