<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_agreement extends CI_Model{
    
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
     return $this->db->query($qry)->result_array();    
   }
   
   function qry_filterednew($sWhere){
     $sWhere = empty($sWhere) ? " WHERE loo_type = 0 and isapproved=1 " : $sWhere." AND loo_type = 0 and isapproved=1";
     $qry="select count(loo_id) as jml from transaksi_loo $sWhere";
    return $this->db->query($qry)->row_array();
     
   }
   
   function qry_totalallnew(){
     $qry="select count(loo_id) as jml from transaksi_loo where loo_type=0 and isapproved=1";
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
			  ORDER BY CTE.agreement_createdate DESC
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
   
    function insertagreement($_ref, $ref_id, $ref_type, $_startdate, $_enddate, $_space, $_idr, $_foreign, $_foreign_rate,
        $currency_id, $_term, $_dayterm, $leasetype_id, $_descr, $_tlv, $_createby, $_createdate, $_modifyby, $_modifydate, 
        $channel_id, $region_id, $branch_id, $rekanan_id, $rekananshipping_line, $strukturunit_id, $transaksi_id, 
        $_formula, $_renttype, $_deduct, $_provision, $_contractno, $_startperiod, $_endperiod, $_renewalno, 
        $_isflat, $_installmentflat, $_virtualaccount, $fitting_out, $product_name, $grace_period, $size_indoor, $size_outdoor,
        $_contractlongnumber, $_loonumber, $_lanumber, 
        $r_code, $channel_id, $channel_no, $r_line, $r_type, $r_sdate, $r_edate, $r_rinstm, $r_rinstd, 
        $r_pinst, $r_int, $r_titype, $r_space, $r_per, $r_base, $r_vat, $r_unit, $r_mia, $r_adendum, $r_lumpsum,
        $r_descr, $r_spdate, $r_unitspot, $r_una, $c_line, $c_type, $c_sdate, $c_edate, $c_rinstm, $c_rinstd, 
        $c_pinst, $c_int, $c_titype, $c_space, $c_per, $c_base, $c_vat, $c_unit, $c_mia, $c_adendum, $c_lumpsum,
        $c_descr, $c_spdate, $c_unitspot, $c_una, $de_line, $de_type, $de_sdate, $de_due, $de_titype, $de_unit, $de_space,
        $de_lumpsum, $de_base, $de_mia, $de_vat, $de_una)
    {        

        $timestamp = time();		   

        $_id = gen_id_agree($channel_no, 'AG','sequencer_propertymanagement', $r_code, $channel_id, $timestamp);

        $_virtualaccount = get_va($_contractno);   

        //print_r($_term); exit;
        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     
        $check = $this->db->query("
              INSERT INTO transaksi_agreement
              ( agreement_id, agreement_ref, ref_id, ref_type, agreement_startdate, agreement_enddate, agreement_space,  
                agreement_idr, agreeement_foreign, agreement_foreign_rate, currency_id, agreement_term, agreement_dayterm, agreementleasetype_id,  
                agreement_isrenewal, agreement_descr, agreement_islumpsum, agreement_tlv, agreement_isclosed, agreement_isapproved, agreement_createby, 
                agreement_createdate, agreement_modifyby, agreement_modifydate, channel_id, region_id, branch_id, rekanan_id, rekananshipping_line,
                strukturunit_id, transaksi_id, agreement_formula, agreement_renttype, agreement_deduct, agreement_provision, agreement_contractno,
                agreement_startperiod, agreement_endperiod, agreement_renewalno, agreement_isflat, agreement_installmentflat, agreement_virtualaccount, 
                agreement_contractlongnumber, agreement_loonumber, agreement_lanumber
              )
              VALUES 
              ( '$_id', '$_ref', '$ref_id', '$ref_type', '$_startdate', '$_enddate', $_space, 
                $_idr, $_foreign, $_foreign_rate, '$currency_id', $_term, $_dayterm, '$leasetype_id', 
                0, '$_descr', 0, $_tlv, 0, 0, '$_createby', 
                '$_createdate', '$_modifyby', '$_modifydate', '$channel_id', '$region_id', '$branch_id', '$rekanan_id', '$rekananshipping_line',
                '$strukturunit_id', '$transaksi_id', '$_formula', '$_renttype', $_deduct, $_provision, '$_contractno',
                '$_startperiod', '$_endperiod', '$_renewalno', $_isflat, $_installmentflat, '$_virtualaccount',
                '$_contractlongnumber', '$_loonumber', '$_lanumber'
              )");

        if ($check) {

          $this->db->query(" 
            INSERT INTO transaksi_agreement_printLOI
            ( agreement_id, dagangan, fitting_out, grace_periode, size_indoor, size_outdoor )
            VALUES 
            ('$_id', '$product_name', $fitting_out, $grace_period, $size_indoor, $size_outdoor)"
          );             
        }


        if ($check){

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
            $d_space      = $r_space[$key];
            $d_per        = $r_per[$key];            
            $d_base       = str_replace(',', '',$r_base[$key]);
            $d_vat        = $r_vat[$key];
            $d_unit       = $r_unit[$key];
            $d_mia        = $r_mia[$key];
            $d_adendum    = ($r_adendum[$key]) ? 1 : 0;
            $d_lumpsum    = ($r_lumpsum[$key]) ? 1: 0;
            $d_descr      = $r_descr[$key];
            $d_spdate     = $r_spdate[$key];
            $d_unitspot   = $r_unitspot[$key];
            $d_una        = $r_una[$key];

            $this->db->query(" 
              INSERT INTO transaksi_agreementdetil
              ( agreement_id,  agreementdetil_line,  agreementtype_id,  agreementdetil_startdate, agreementdetil_enddate, agreementdetil_duedate,  agreementdetil_installment, agreementdetil_dayinstallment, agreementdetil_installmentpayment, agreementdetil_interval,  timetype_id,  agreementdetil_percent,   agreementdetil_space, agreementdetil_terms, agreementdetil_baserent, currency_id,  agreementdetil_tax,
                agreementrule_id, agreementdetil_unit, agreementdetil_mia, agreementdetil_isadendum, agreementdetil_islumpsum, 
                agreementdetil_isautodiscount, agreementdetil_descr, agreementdetil_startdatepayment, agreementdetil_ndesc, agreementdetil_unitspot, unit_id )
              VALUES 
              ('$_id', $d_line,'$d_type', '$d_sdate', '$d_edate', 0, 
                $d_rinstm, $d_rinstd, $d_pinst, $d_int, '$d_titype', 
                $d_per, $d_space, $_term, $d_base, 'IDR', $d_vat, 
                0, '$d_una', $d_mia, $d_adendum, $d_lumpsum, 0, 
                '$d_descr', '$d_spdate', NULL, '$d_unitspot', '$d_unit' )");          
          }          
          
        }			

        if ($check){
          if (is_array($c_line)){
            if (count($c_line) >0){
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
                $ch_space      = $c_space[$_c];
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

                $this->db->query(" 
                  INSERT INTO transaksi_agreementdetil
                  ( agreement_id,  agreementdetil_line,  agreementtype_id,  agreementdetil_startdate, agreementdetil_enddate, agreementdetil_duedate,  agreementdetil_installment, agreementdetil_dayinstallment, agreementdetil_installmentpayment, agreementdetil_interval,  timetype_id,  agreementdetil_percent,   agreementdetil_space, agreementdetil_terms, agreementdetil_baserent, currency_id,  agreementdetil_tax,
                    agreementrule_id, agreementdetil_unit, agreementdetil_mia, agreementdetil_isadendum, agreementdetil_islumpsum, 
                    agreementdetil_isautodiscount, agreementdetil_descr, agreementdetil_startdatepayment, agreementdetil_ndesc, agreementdetil_unitspot, unit_id )
                  VALUES 
                  ('$_id', $ch_line,'$ch_type', '$ch_sdate', '$ch_edate', 0, 
                    $ch_rinstm, $ch_rinstd, $ch_pinst, $ch_int, '$ch_titype', 
                    $ch_per, $ch_space, $_term, $ch_base, 'IDR', $ch_vat, 
                    0, '$ch_una', $ch_mia, $ch_adendum, $ch_lumpsum, 0, 
                    '$ch_descr', '$ch_spdate', NULL, '$ch_unitspot', '$ch_unit' )");          
              }  
            }        
          }
        }        

        if ($check){
          if (is_array($de_line)){
            if (count($de_line) >0){
              foreach($de_line as $_d => $_dv){           

                $dp_line       = $de_line[$_d];
                $dp_type       = $de_type[$_d];
                $dp_sdate      = $de_sdate[$_d];
                $dp_due        = $de_due[$_d];
                $dp_titype     = $de_titype[$_d];
                $dp_space      = $de_space[$_d];
                $dp_base       = str_replace(',', '',$de_base[$_d]);
                $dp_vat        = $de_vat[$_d];
                $dp_unit       = $de_unit[$_d];
                $dp_mia        = str_replace(',', '',$de_mia[$_d]);
                $dp_lumpsum    = ($de_lumpsum[$_d]) ? 1: 0;
                $dp_una        = $de_una[$_d];

                $this->db->query(" 
                  INSERT INTO transaksi_agreementdeposit
                  ( agreement_id,  agreementdeposit_line,  agreementtype_id,  agreementdeposit_startdate,  agreementdeposit_duedate,  
                    agreementdeposit_installment,  agreementdeposit_interval,  timetype_id,  agreementdeposit_percent,  agreementdeposit_idr, 
                    agreementdeposit_idrsubtotal , agreementdeposit_foreign,  agreementdeposit_foreignrate,  currency_id,  agreementdeposit_tax, 
                    agreementdeposit_unit, agreementdeposit_space, agreementdeposit_islumpsum, unit_id)
                  VALUES
                  ('$_id', $dp_line, '$dp_type', '$dp_sdate', $dp_due, 
                    1, 1, '$dp_titype', 0, $dp_base, 
                    $dp_mia, 0, 1, 'IDR', $dp_vat, 
                    '$dp_una', $dp_space, $dp_lumpsum, '$dp_unit' )");
              }  
            }        
          }          
        }

        $sp_rentalTLV = "EXEC lm03_TrnAgreementdetil_UpdateTLV '$_id' ";
        $this->db->query($sp_rentalTLV);       

        $sp_depositTLV = "EXEC lm03_TrnAgreementdeposit_UpdateTLV '$_id' ";
        $this->db->query($sp_depositTLV);
			
			return $_id;
			  
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
		    
	function updateagreement($_ref, $ref_id, $ref_type, $_startdate, $_enddate, $_space, 
        $_idr, $_foreign, $_foreign_rate, $currency_id, $_term, $_dayterm, $leasetype_id, $_descr, 
        $_tlv, $_createby, $_createdate, $_modifyby, $_modifydate, 
        $channel_id, $region_id, $branch_id, $rekanan_id, $rekananshipping_line, $strukturunit_id, $transaksi_id, 
        $_formula, $_renttype, $_deduct, $_provision, $_contractno, $_startperiod, $_endperiod, $_renewalno, 
        $_isflat, $_installmentflat, $_virtualaccount, $fitting_out, $product_name, $grace_period, $size_indoor, $size_outdoor,
        $_contractlongnumber, $_loonumber, $_lanumber, 
        $r_code, $channel_id, $channel_no, $r_line, $r_type, $r_sdate, $r_edate, $r_rinstm, $r_rinstd, 
        $r_pinst, $r_int, $r_titype, $r_space, $r_per, $r_base, $r_vat, $r_unit, $r_mia, $r_adendum, $r_lumpsum,
        $r_descr, $r_spdate, $r_unitspot, $r_una, $c_line, $c_type, $c_sdate, $c_edate, $c_rinstm, $c_rinstd, 
        $c_pinst, $c_int, $c_titype, $c_space, $c_per, $c_base, $c_vat, $c_unit, $c_mia, $c_adendum, $c_lumpsum,
        $c_descr, $c_spdate, $c_unitspot, $c_una, $de_line, $de_type, $de_sdate, $de_due, $de_titype, $de_unit, $de_space,
        $de_lumpsum, $de_base, $de_mia, $de_vat, $de_una, $agreement_id){          
      
        $_virtualaccount = get_va($_contractno);
 
  		  $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     
        $check=$this->db->query("
            UPDATE transaksi_agreement
            SET agreement_ref = '$_ref', ref_id = '$ref_id', ref_type = '$ref_type', agreement_startdate = '$_startdate', agreement_enddate='$_enddate', agreement_space='$_space',  
              agreement_idr=$_idr, agreeement_foreign=$_foreign, agreement_foreign_rate=$_foreign_rate, currency_id='$currency_id', agreement_term=$_term, 
              agreement_dayterm = $_dayterm, agreementleasetype_id='$leasetype_id', agreement_descr = '$_descr', 
              agreement_tlv=$_tlv, agreement_createby='$_createby', agreement_createdate='$_createdate', agreement_modifyby='$_modifyby', agreement_modifydate='$_modifydate', 
              channel_id='$channel_id', region_id='$region_id', branch_id='$branch_id', rekanan_id='$rekanan_id', rekananshipping_line=$rekananshipping_line,
              strukturunit_id='$strukturunit_id', transaksi_id='$transaksi_id', agreement_formula=$_formula, agreement_renttype='$_renttype', 
              agreement_deduct=$_deduct, agreement_provision=$_provision, agreement_contractno='$_contractno',
              agreement_startperiod='$_startperiod', agreement_endperiod='$_endperiod', agreement_renewalno='$_renewalno', agreement_isflat=$_isflat, 
              agreement_installmentflat=$_installmentflat, agreement_virtualaccount='$_virtualaccount', 
              agreement_contractlongnumber='$_contractlongnumber', agreement_loonumber='$_loonumber', agreement_lanumber='$_lanumber'
            WHERE agreement_id = '{$agreement_id}'
        ");	

        if ($check){

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
            $d_space      = $r_space[$key];
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

            $this->db->query(" 
              UPDATE transaksi_agreementdetil
              SET agreementtype_id='$d_type',  agreementdetil_startdate='$d_sdate', 
                agreementdetil_enddate = '$d_edate', agreementdetil_duedate = 0,  agreementdetil_installment=$d_rinstm, agreementdetil_dayinstallment=$d_rinstd, 
                agreementdetil_installmentpayment=$d_pinst, agreementdetil_interval=$d_int,  timetype_id='$d_titype',  agreementdetil_percent=$d_per,   
                agreementdetil_space=$d_space, agreementdetil_terms=$_term, agreementdetil_baserent=$d_base, currency_id='IDR',  agreementdetil_tax=$d_vat,
                agreementrule_id=0, agreementdetil_unit='$d_una', agreementdetil_mia=$d_mia, agreementdetil_isadendum=$d_adendum, agreementdetil_islumpsum=$d_lumpsum, 
                agreementdetil_isautodiscount=0, agreementdetil_descr='$d_descr', agreementdetil_startdatepayment='$d_spdate', 
                agreementdetil_ndesc='', agreementdetil_unitspot='$d_unitspot', unit_id='$d_unit'
              WHERE agreement_id = '{$agreement_id}' AND agreementdetil_line=$d_line
            ");          
          }          
          
        }     

        if ($check){
          if (is_array($c_line)){
            if (count($c_line) >0){
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
                $ch_space      = $c_space[$_c];
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

                $this->db->query(" 
                  UPDATE transaksi_agreementdetil
                  SET agreementtype_id='$ch_type',  agreementdetil_startdate='$ch_sdate', 
                    agreementdetil_enddate='$ch_edate', agreementdetil_duedate=0,  agreementdetil_installment=$ch_rinstm, agreementdetil_dayinstallment=$ch_rinstd, 
                    agreementdetil_installmentpayment=$ch_pinst, agreementdetil_interval=$ch_int,  timetype_id='$ch_titype',  agreementdetil_percent=$ch_per,   
                    agreementdetil_space=$ch_space, agreementdetil_terms=$_term, agreementdetil_baserent=$ch_base, currency_id='IDR',  agreementdetil_tax=$ch_vat,
                    agreementrule_id=0, agreementdetil_unit='$ch_una', agreementdetil_mia=$ch_mia, agreementdetil_isadendum=$ch_adendum, agreementdetil_islumpsum=$ch_lumpsum, 
                    agreementdetil_isautodiscount=0, agreementdetil_descr='$ch_descr', agreementdetil_startdatepayment='$ch_spdate', 
                    agreementdetil_ndesc='', agreementdetil_unitspot='$ch_unitspot', unit_id='$ch_unit'
                  WHERE agreement_id = '{$agreement_id}' AND agreementdetil_line=$ch_line

                ");          
              }  
            }        
          }
        }        

        if ($check){
          if (is_array($de_line)){
            if (count($de_line) >0){
              foreach($de_line as $_d => $_dv){           

                $dp_line       = $de_line[$_d];
                $dp_type       = $de_type[$_d];
                $dp_sdate      = $de_sdate[$_d];
                $dp_due        = $de_due[$_d];
                $dp_titype     = $de_titype[$_d];
                $dp_space      = $de_space[$_d];
                $dp_base       = str_replace(',', '',$de_base[$_d]);
                $dp_vat        = $de_vat[$_d];
                $dp_unit       = $de_unit[$_d];
                $dp_mia        = str_replace(',', '',$de_mia[$_d]);
                $dp_lumpsum    = ($de_lumpsum[$_d]) ? 1: 0;
                $dp_una        = $de_una[$_d];

                $this->db->query(" 
                  UPDATE transaksi_agreementdeposit
                  SET agreementtype_id='$dp_type',  agreementdeposit_startdate='$dp_sdate',  
                    agreementdeposit_duedate=$dp_due, agreementdeposit_installment=1,  agreementdeposit_interval=1,  timetype_id='$dp_titype',  
                    agreementdeposit_percent=0,  agreementdeposit_idr=$dp_base, 
                    agreementdeposit_idrsubtotal=$dp_mia , agreementdeposit_foreign=0,  agreementdeposit_foreignrate=1,  currency_id='IDR',  
                    agreementdeposit_tax=$dp_vat, agreementdeposit_unit='$dp_una', agreementdeposit_space=$dp_space, 
                    agreementdeposit_islumpsum=$dp_lumpsum, unit_id='$dp_unit'
                  WHERE agreement_id = '{$agreement_id}' AND agreementdeposit_line=$dp_line
                ");
              }  
            }        
          }          
        }    

        if ($check){

          $sp_rentalTLV = "EXEC lm03_TrnAgreementdetil_UpdateTLV '$agreement_id' ";
          $this->db->query($sp_rentalTLV);           

          $sp_depositTLV = "EXEC lm03_TrnAgreementdeposit_UpdateTLV '$agreement_id' ";
          $this->db->query($sp_depositTLV);

        }        

  }
	
	function deleteagreement($_id){    
   
		$this->db->query("delete from transaksi_agreement where agreement_id='$_id'");
		$this->db->query("delete from transaksi_agreementdetil where agreement_id='$_id'");
    $this->db->query("delete from transaksi_agreementdeposit where agreement_id='$_id'");
    //$this->db->query("delete from transaksi_loounit where loo_id='$loo_id'");
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
              TRANS.transaksi_name, agreement_loonumber, pLOI.dagangan, pLOI.fitting_out, pLOI.grace_periode, pLOI.size_indoor, pLOI.size_outdoor
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
                        'transaksi_name'          => 'Pencatatan Leasing'
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

    function dataapplist(){

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
          WHERE AGR.agreement_isclosed = 0
          ORDER BY agreement_id desc ";

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

 function getPassword($id){

  $qry= " SELECT A.*, B.agreementtype_name
          FROM master_sklterm A inner join master_agreementtype B ON A.skl_atype = B.agreementtype_id
          WHERE A.skl_id = '{$id}' ";

  return $this->db->query($qry)->result_array();   
 }     
    
}
