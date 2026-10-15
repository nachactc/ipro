<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_agreement extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    function qry_alldatapro($limit, $top, $sWhere){     
      $sWhere = empty($sWhere) ? " WHERE provitsharing_isdisabled = 0 " : $sWhere." AND provitsharing_isdisabled = 0 ";  
      $sql = "
        select
          A.*
        from 
          master_provitsharing A
        $sWhere    
        order by  A.provitsharing_id asc
        offset $top rows 
        fetch next $limit rows only;
      ";
      //var_dump($qry);
      return $this->db->query($sql)->result_array();    
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

   
    function qry_alldatapop($limit, $top, $sWhere)
    {

      $qry="
      WITH CTE AS (
        select
          S.rekanan_id, S.rekananshipping_line
          , S.rekananshipping_name, R.rekanan_name
          , S.rowid AS debtor_no
        from 
          master_rekananshipping S
          join master_rekanan AS R ON R.rekanan_id = S.rekanan_id
        $sWhere
      )
    
      SELECT CTE.*
      FROM CTE    
      ORDER BY  CTE.rekananshipping_name asc
      OFFSET $top ROWS 
      FETCH NEXT $limit ROWS ONLY
      ";
      //var_dump($qry);
      return $this->db->query($qry)->result_array();    
    }
 
    function qry_filteredpop($sWhere)
    {
      $qry = "
      select count(S.rekanan_id) as jml
      from master_rekananshipping S  
      JOIN master_rekanan AS R ON R.rekanan_id = S.rekanan_id 
      $sWhere
      ";
      return $this->db->query($qry)->row_array();     
    }
 
    function qry_totalallpop()
    {
      $qry = "
      select count(S.rekanan_id) as jml
      from master_rekananshipping S
      join master_rekanan R ON R.rekanan_id = S.rekanan_id";
      return $this->db->query($qry)->row_array();     
    }

    function qry_alldataunit($limit, $top, $sWhere){

      $qry="
        WITH CTE AS (
          select
            S.unit_id, S.unit_name, S.unit_sqm, R.lantai_id, R.lantai_name, S.unit_state
          from 
            master_unit S
          join 
            master_lantai AS R ON R.lantai_id = S.lantai_id
          $sWhere
        )
      
        SELECT CTE.*
        FROM CTE    
        ORDER BY  CTE.unit_name asc
        OFFSET $top ROWS 
        FETCH NEXT $limit ROWS ONLY
      ";
      //var_dump($qry);
      return $this->db->query($qry)->result_array();    
    }
  
    function qry_filteredunit($sWhere){
      $qry = "
        select 
          count(S.unit_id) as jml
        from 
          master_unit S  
        join 
          master_lantai R ON R.lantai_id = S.lantai_id 
        $sWhere
      ";
      return $this->db->query($qry)->row_array();     
    }
  
    function qry_totalallunit(){
      $qry = "
        select 
          count(S.unit_id) as jml
        from 
          master_unit S
        join 
          master_lantai R ON R.lantai_id = S.lantai_id
      ";
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
	function cekbap($agid,$bapdate,$user){
		
		$sp= " EXEC [lm03_TrnAgreement_logbapdate] '$agid', '$bapdate', '$user'";
		$rs=$this->db->query($sp)->row_array();
		$nil_info=$rs['vinfo'];
		return $nil_info;
		
	}

    function saveHeader($header, $loi, $state)
    {        
        $agreement_id = $header['agreement_id'];
        /** Header */        
        if ($state=='update') {
            /** Header */
            $sp_updateH = " 
            lm03_TrnAgreement_Update
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
            ?, ?, ?, ?, ?, ?, ?, ?, ? 
            ";
            $this->db->query($sp_updateH, $header);                        
            /** LOI Master Update */
            $loi['agreement_id'] = $agreement_id;
            $sp_updatePLOI = " lm03Trnagreement_LOIMasterUpdate ?, ?, ?, ?, ?, ? ";
            $this->db->query($sp_updatePLOI, $loi);
        } else {
            $sp_insertH = " 
                lm03_TrnAgreement_Insert
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ? 
            ";
            $result = $this->db->query($sp_insertH, $header)->row_array();
            $agreement_id = $result['agreement_id'];
            //var_dump($this->db->last_query());die();
            
            $loi['agreement_id'] = $agreement_id;
            $sp_insertPLOI = " lm03Trnagreement_LOIMasterInsert ?, ?, ?, ?, ?, ? ";
            $this->db->query($sp_insertPLOI, $loi);
        }
            
        return $agreement_id;  
    }
    
    function saveRental($rental, $state)
    {
        /** Rental & Charge */
        if ($state=='update') {
            $sp = " 
                EXEC lm03_TrnAgreementdetil_Update 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ? 
            ";
        } else {
            $sp = " 
                EXEC lm03_TrnAgreementdetil_Insert 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ? 
            ";
        }
        $this->db->query($sp, $rental);        
    }
    
    function saveDeposit($deposit, $state)
    {
        /** Deposit */
        if ($state=='update') {
            $sp = " 
                EXEC lm03TrnAgreementdeposit_Update
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?
            ";
        } else {
            $sp = " 
                EXEC lm03TrnAgreementdeposit_Insert 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?
            ";
        }
        $this->db->query($sp, $deposit);        
    }

    function saveLoan($loan, $state)
    {
        /** Loan */
        if ($state=='update') {
            $sp = " 
                EXEC lm03TrnLoan_Update 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ?
            ";
        } else {
            $sp = " 
                EXEC lm03TrnLoan_Update 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ?
            ";
        }
        $this->db->query($sp, $loan);
    }
   
    function saveProfit($profit, $state)
    {
        /** Loan */
        if ($state=='update') {
            $sp = "
                EXEC lm03_TrnAgreementps_Update
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?, ?
            ";
        } else {
            $sp = " 
                EXEC lm03_TrnAgreementps_Insert 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?, ?
            ";
        }
        $this->db->query($sp, $profit);        
    }

    function saveTLV($agreement_id)
    {        
        $sp_rentalTLV = "EXEC [lm03_TrnAgreementdetil_UpdateTLV] ? ";
        $this->db->query($sp_rentalTLV, $agreement_id);       

        $sp_depositTLV = "EXEC [lm03_TrnAgreementdeposit_UpdateTLV] ? ";
        $this->db->query($sp_depositTLV, $agreement_id);
    }

    function vdetilrental($agreement_id)
    {
        $sql = "
        SELECT AGD.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name
        FROM transaksi_agreementdetil AGD
            LEFT JOIN master_unit UNIT ON UNIT.unit_id = AGD.unit_id
            LEFT JOIN master_agreementtype AT ON AT.agreementtype_id = AGD.agreementtype_id            
        WHERE AGD.agreement_id = ? 
            AND AT.agreementtype_type IN ?
            AND AGD.agreementdetil_isnotcount = ?
        ORDER BY  agreement_id, agreementdetil_line ASC
        ";
            
        $params = [
        'agreement_id' => $agreement_id,
        'type' => array('RENTAL', 'RENTAL TEMP'),
        'isnotcount' => 0
        ];
        return $this->db->query($sql, $params)->result();      
    }  

    function vdetilcharge($agreement_id)
    {
        $sql = "
        SELECT AGD.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name
        FROM transaksi_agreementdetil AGD
            LEFT JOIN master_unit UNIT ON UNIT.unit_id = AGD.unit_id
            LEFT JOIN master_agreementtype AT ON AT.agreementtype_id = AGD.agreementtype_id            
        WHERE AGD.agreement_id = ?
            AND AT.agreementtype_type IN ?
            AND AGD.agreementdetil_isnotcount = ?
        ORDER BY  agreement_id, agreementdetil_line ASC
        ";          
        
        $params = [
        'agreement_id' => $agreement_id,
        'type' => array('SERVICE', 'OTHER'),
        'isnotcount' => 0
        ];

        return $this->db->query($sql, $params)->result();      
    }

    function vdetildeposit($agreement_id)
    {
        $sql = "
        SELECT AGD.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name
        FROM transaksi_agreementdeposit AGD
            LEFT JOIN master_unit UNIT ON UNIT.unit_id = AGD.unit_id
            LEFT JOIN master_agreementtype AT ON AT.agreementtype_id = AGD.agreementtype_id            
        WHERE AGD.agreement_id = ? 
            AND AT.agreementtype_type IN ?
        ORDER BY  agreement_id, agreementdeposit_line ASC
        ";  
        $params = [
        'agreement_id' => $agreement_id,
        'type' => array('DEPOSIT')
        ];
        return $this->db->query($sql, $params)->result();
    }

    function vdetilloan($agreement_id)
    {
        $sql = "
        SELECT AGD.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name
        FROM transaksi_loan AGD
            LEFT JOIN master_unit UNIT ON UNIT.unit_id = AGD.unit_id
            LEFT JOIN master_agreementtype AT ON AT.agreementtype_id = AGD.agreementtype_id            
        WHERE AGD.agreement_id = ?         
        ORDER BY  agreement_id, agreementloan_line ASC
        ";  
        return $this->db->query($sql, $agreement_id)->result();      
    }

    function vdetilprofits($agreement_id)
    {
        $this->db->select('tap.*, mu.unit_name, mat.agreementtype_name');
        $this->db->from('transaksi_agreementps tap');
        $this->db->join('master_unit mu', 'mu.unit_id = tap.unit_id');
        $this->db->join('master_agreementtype mat', 'mat.agreementtype_id = tap.agreementtype_id');
        $this->db->where('tap.agreement_id', $agreement_id);
        $this->db->order_by('tap.agreementps_line', 'desc');

        $sql = $this->db->get();

        return $sql->result();

        /*
        $sql = "
        SELECT ATP.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name
        FROM transaksi_agreementps ATP
            LEFT JOIN master_unit UNIT ON UNIT.unit_id = ATP.unit_id
            LEFT JOIN master_agreementtype AT ON AT.agreementtype_id = ATP.agreementtype_id            
        WHERE ATP.agreement_id = ?         
        ORDER BY  agreement_id, agreementps_line ASC
        ";  
        return $this->db->query($sql, $agreement_id)->result();
        */
    }
		    
    function updateagreement($header, $loi, $rental, $charge, $deposit, $loan, $profit, $deleted)
    {

        $agreement_id = $header['agreement_id'];

        $this->db->trans_begin(); 

        /** Header */
        $sp_updateH = " 
        lm03_TrnAgreement_Update
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, ?, ? 
        ";
        $this->db->query($sp_updateH, $header);      

        if (is_array($deleted) || is_object($deleted))
        {
            foreach ($deleted as $rows) {
                # code...
                if (property_exists($deleted, "rental")) {
                foreach ($rows as $row => $value) {
                    # code...
                    $sp = " DELETE FROM transaksi_agreementdetil WHERE agreement_id = ? AND agreementdetil_line = ? ";
                    $this->db->query($sp, array($agreement_id, $value->line));
                }
                }
                
                if (property_exists($deleted, "charge")) {

                foreach ($rows as $row => $value) {
                    # code...
                    $sp = " DELETE FROM transaksi_agreementdetil WHERE agreement_id = ? AND agreementdetil_line = ? ";
                    $this->db->query($sp, array($agreement_id, $value->line));
                }
                }

                if (property_exists($deleted, "deposit")) {

                foreach ($rows as $row => $value) {
                    # code...
                    $sp = " DELETE FROM transaksi_agreementdeposit WHERE agreement_id = ? AND agreementdeposit_line = ? ";
                    $this->db->query($sp, array($agreement_id, $value->line));
                }
                }

                if (property_exists($deleted, "loan")) {

                foreach ($rows as $row => $value) {
                    # code...
                    $sp = " DELETE FROM transaksi_loan WHERE agreement_id = ? AND agreementloan_line = ? ";
                    $this->db->query($sp, array($agreement_id, $value->line));
                }
                }

                if (property_exists($deleted, "profit")) {
                foreach ($rows as $row => $value) {
                    # code...
                    $sp = " DELETE FROM transaksi_agreementps WHERE agreement_id = ? AND agreementps_line = ? ";
                    $this->db->query($sp, array($agreement_id, $value->line));
                }
                }

            }
        }    

        /** Rental */
        //$records = [];
        if (is_array($rental) || is_object($rental))
        {
        foreach ($rental as $col) {
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
                EXEC lm03_TrnAgreementdetil_Update 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ? 
            ";
            } else {
            $sp = " 
                EXEC lm03_TrnAgreementdetil_Insert 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ? 
            ";
            }

            $this->db->query($sp, $record);
        }
        }

        /** Charge */
        //$records = [];
        if (is_array($charge) || is_object($charge))
        {
        foreach ($charge as $col) {
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
                EXEC lm03_TrnAgreementdetil_Update 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ? 
            ";
            } else {
            $sp = " 
                EXEC lm03_TrnAgreementdetil_Insert 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ? 
            ";
            }

            $this->db->query($sp, $record);
        }
        }


        /** Deposit */
        //$records = [];
        if (is_array($deposit) || is_object($deposit))
        {
        foreach ($deposit as $col) {
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
                EXEC lm03TrnAgreementdeposit_Update
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?
            ";
            } else {
            $sp = " 
                EXEC lm03TrnAgreementdeposit_Insert 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?
            ";
            }

            $this->db->query($sp, $record);
        }
        }
        
        
        
        /** Loan */
        //$records = [];
        if (is_array($loan) || is_object($loan))
        {
        foreach ($loan as $col) {
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
                EXEC lm03TrnLoan_Update 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ?
            ";
            } else {
            $sp = " 
                EXEC lm03TrnLoan_Insert 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ?
            ";
            }

            $this->db->query($sp, $record);
        }
        }

        
        /** Profit */
        //$records = [];
        if (is_array($profit) || is_object($profit))
        {
        foreach ($profit as $col) {
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
                EXEC lm03_TrnAgreementps_Update
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?, ?
            ";
            } else {
            $sp = " 
                EXEC lm03_TrnAgreementps_Insert 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?, ?
            ";
            }

            $this->db->query($sp, $record);
        }
        }

        
        /** LOI Master Insert */
        $loi['agreement_id'] = $agreement_id;
        $sp_updatePLOI = " lm03Trnagreement_LOIMasterUpdate ?, ?, ?, ?, ?, ? ";
        $this->db->query($sp_updatePLOI, $loi);

        $sp_rentalTLV = "EXEC [lm03_TrnAgreementdetil_UpdateTLV] ? ";
        //$params['agreement_id'] = $agreement_id;
        $this->db->query($sp_rentalTLV, $agreement_id);       

        $sp_depositTLV = "EXEC [lm03_TrnAgreementdeposit_UpdateTLV] ? ";
        //$params['agreement_id'] = $agreement_id;
        $this->db->query($sp_depositTLV, $agreement_id);

            
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
              agreement_bapdate, agreement_contractlongnumber,
              agreement_closeby,
              agreement_closedate,
              agreement_closereason,
              agreement_closedesc,
              thdstatus_id, 
              thdtype_id, 
              thdgroup_id, 
              thdcat_id
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
                        'agreement_contractlongnumber' => '',
                        'agreement_closeby' => '',
                        'agreement_closedate' => '',
                        'agreement_closereason' => '',
                        'agreement_closedesc' => '',
                        'thdstatus_id' => '', 
                        'thdtype_id' => '', 
                        'thdgroup_id' => '', 
                        'thdcat_id' => ''
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

            $agreement_id   = $key['id'];
            $ref_id         = $key['ref_id'];
            $renewal_number = $key['ren_no'];

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

  
    // get combo_thd_type
    public function combo_thd_type() 
    {
        
      $this->db->order_by('thdtype_name');
      $result = $this->db->get('master_thdtype')->result();

      $ret ['']= 'Pilih Type :';
      if($result)
      {
          foreach ($result as $key => $row)
          {
              $ret [$row->thdtype_id] = $row->thdtype_name;
          }
      }
      
      return $ret;
    }

    // get combo_thd_group
    public function combo_thd_group() 
    {
        
      $this->db->order_by('thdgroup_name');
      $result = $this->db->get('master_thdgroup')->result();
      
      $ret ['']= 'Pilih Group :';
      if($result)
      {
          foreach ($result as $key => $row)
          {
              $ret [$row->thdgroup_id] = $row->thdgroup_name;
          }
      }
      
      return $ret;
    }

      // get combo_thd_type
    public function combo_thd_cat() 
    {
        
      $this->db->order_by('thdcat_name');
      $result = $this->db->get('master_thdcat')->result();
      
      $ret ['']= 'Pilih Category :';
      if($result)
      {
          foreach ($result as $key => $row)
          {
              $ret [$row->thdcat_id] = $row->thdcat_name;
          }
      }
      
      return $ret;
    }

    // get combo_thd_status
    public function combo_thd_status() 
    {
        
        $result = $this->db->get('master_thdstatus')->result();
        
        $ret ['']= 'Pilih Status :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->thdstatus_id] = $row->thdstatus_name;
            }
        }
        
        return $ret;
    }
    
}
