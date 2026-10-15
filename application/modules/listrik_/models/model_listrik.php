<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_listrik extends CI_Model{
    
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

   function qry_allreg($limit,$top,$sWhere){
      $qry="WITH CTE AS (         
              SELECT TOP $limit u_rek.rekanan_id, u_rek.rekananshipping_line, u_rek.rekananutilitieslistrik_reg, 
                u_rek.rekananutilitieslistrik_kva, u_rek.rekananutilitieslistrik_admpercent, u_rek.rekananutilitieslistrik_bpju,
                h_rek.rekanan_name, s_rek.rekananshipping_name, s_rek.branch_id,
                ROW_NUMBER() OVER (ORDER BY h_rek.rekanan_name asc) as RowNumber            
              FROM master_rekananutilitieslistrik AS u_rek 
                inner join master_rekananshipping AS s_rek 
                  ON u_rek.rekanan_id = s_rek.rekanan_id AND u_rek.rekananshipping_line = s_rek.rekananshipping_line
                inner join master_rekanan AS h_rek ON h_rek.rekanan_id = u_rek.rekanan_id              
          $sWhere )
      SELECT CTE.*
      FROM CTE      
      WHERE RowNumber > $top";

      //print_r($qry);
     return $this->db->query($qry)->result_array();    
   }
   
   function qry_filterreg($sWhere){
     $qry="SELECT COUNT(u_rek.rekananutilitieslistrik_reg) as jml           
           FROM master_rekananutilitieslistrik AS u_rek 
              inner join master_rekananshipping AS s_rek 
                ON u_rek.rekanan_id = s_rek.rekanan_id AND u_rek.rekananshipping_line = s_rek.rekananshipping_line
              inner join master_rekanan AS h_rek ON h_rek.rekanan_id = u_rek.rekanan_id              
            $sWhere";
    return $this->db->query($qry)->row_array();
     
   }
   
   function qry_totalreg(){
     $qry="SELECT COUNT(u_rek.rekananutilitieslistrik_reg) as jml
           FROM master_rekananutilitieslistrik AS u_rek 
             inner join master_rekananshipping AS s_rek 
               ON u_rek.rekanan_id = s_rek.rekanan_id AND u_rek.rekananshipping_line = s_rek.rekananshipping_line
             inner join master_rekanan AS h_rek ON h_rek.rekanan_id = u_rek.rekanan_id";
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
          SELECT top $limit CTE.utilitieslistrik_id, CTE.utilitieslistrik_descr, CTE.utilitieslistrik_date, 
            ROW_NUMBER() OVER (ORDER BY CTE.utilitieslistrik_id desc) as RowNumber,
            REGION.region_name, BRANCH.branch_name, STRU.strukturunit_name, MAX(LDT.utilitieslistrikdetil_isposted) AS isposted
          FROM transaksi_utilitieslistrik AS CTE       
            INNER JOIN transaksi_utilitieslistrikdetil AS LDT ON CTE.utilitieslistrik_id = LDT.utilitieslistrik_id
            JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
            JOIN master_strukturunit AS STRU ON CTE.strukturunit_id = STRU.strukturunit_id      
          $sWhere 
          GROUP BY REGION.region_name, BRANCH.branch_name, STRU.strukturunit_name, CTE.utilitieslistrik_id, CTE.utilitieslistrik_descr, CTE.utilitieslistrik_date
          ORDER BY CTE.utilitieslistrik_id DESC
        ) AS V
        WHERE   RowNumber > $top";        
	    return $this->db->query($qry)->result_array();
   }
   
    function qry_filteredlist($sWhere){
      
	    $qry="
        SELECT COUNT(*) as jml FROM (
  			  SELECT CTE.utilitieslistrik_id
  			  FROM transaksi_utilitieslistrik AS CTE       
            JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
            JOIN master_strukturunit AS STRU ON CTE.strukturunit_id = STRU.strukturunit_id
  			  $sWhere
  			) AS V";

		  return $this->db->query($qry)->row_array();	   
   }
   
   function qry_totalalllist(){
	   
      $qry="SELECT COUNT(utilitieslistrik_id) AS jml FROM transaksi_utilitieslistrik";

		return $this->db->query($qry)->row_array();
	   
   }
   
    function insertlistrik($_id, $_channel, $_date, $branch_id, $region_id, $strukturunit_id, $_transaksi, $_descr, 
        $_createby, $_createdate, $_modifyby, $_modifydate, $_type, $dposted, $dline, $dtenant_id, $dbrand_line,
        $ddescr, $dreg, $dagreement, $damp, $dblocked, $dgenset, $dbebankva, $dphase, $dfaktor, $dbpjumaster,
        $dadmamountmaster, $dadmpercentmaster, $dreglimitmaster, $dstandawalwbp, $dstandawallwbp, $dstandawal,
        $dakhir, $dselisihwbp, $dselisihlwbp, $dselisih, $dwbptotal, $dlwbptotal, $dpemakaianwbp, $dpemakaianlwbp, 
        $dtarifwbp, $dtariflwbp, $dbiayawbp, $dbiayalwbp, $dbiaya, $dbpju, $dtagihan, $ddenda, $dadministrasi, $djumlah, $dtax,
        $dselisihlalu, $dselisihavg, $dselisihwbplalu, $dselisihlwbplalu, $dselisihwbpavg, $dselisihlwbpavg, $dstandakhirwbp, $dstandakhirlwbp,
        $wbpgedung, $lwbpgedung, $wbptarif, $lwbptarif,$dbeabeban,$dabonemen)
    {             

        $timestamp = time();		
        $now = date("Y-m-d H:i:s", $timestamp);        

        $wbpgedung = empty($wbpgedung) ? 0 : str_replace(',', '', $wbpgedung);
        $lwbpgedung = empty($lwbpgedung) ? 0 : str_replace(',', '', $lwbpgedung);
        $wbptarif = empty($wbptarif) ? 0 : str_replace(',', '', $wbptarif);
        $lwbptarif = empty($lwbptarif) ? 0 : str_replace(',', '', $lwbptarif);
        
        $this->db->trans_begin();

        $sp_insertH = "EXEC [lm03_TrnUtilitieslistrik_Insert] '', '$_date', '$_descr', 0, '$_createby', '$now', '', '$now',  
            '$_type', '$region_id', '$branch_id', '$strukturunit_id', '$_transaksi', '$_channel', '', $lwbptarif, $wbptarif, $lwbpgedung, $wbpgedung";        
        $result = $this->db->query($sp_insertH)->row_array();
        $_id = $result['utilitieslistrik_id'];

        foreach($dline as $key => $n){          

          $d_line               = $dline[$key];
          $d_descr              = $ddescr[$key];
          $d_tenant_id          = $dtenant_id[$key];
          $d_brand_line         = $dbrand_line[$key];
          $d_reg                = str_replace("'", "''", $dreg[$key]);//$dreg[$key];
          $d_agreement          = $dagreement[$key];
          $d_amp                = empty($damp[$key]) ? 0 : str_replace(',', '', $damp[$key]);;
          $d_blocked            = empty($dblocked[$key]) ? 0 : $dblocked[$key];
          $d_genset             = empty($dgenset[$key]) ? 0 : $dgenset[$key];
          $d_bebankva           = empty($dbebankva[$key]) ? 0 : $dbebankva[$key];
          $d_phase              = $dphase[$key];
          $d_faktor             = $dfaktor[$key];
          $d_bpjumaster         = empty($dbpjumaster[$key]) ? 0 : $dbpjumaster[$key];
          $d_admamountmaster    = empty($dadmamountmaster[$key]) ? 0 : $dadmamountmaster[$key];
          $d_admpercentmaster   = empty($dadmpercentmaster[$key]) ? 0 : $dadmpercentmaster[$key];
          $d_reglimitmaster     = empty($dreglimitmaster[$key]) ? 0 : $dbpjumaster[$key];
          $d_standawalwbp       = str_replace(',', '', $dstandawalwbp[$key]);
          $d_standawallwbp      = str_replace(',', '', $dstandawallwbp[$key]);
          $d_standawal          = empty($dstandawal[$key]) ? 0 : str_replace(',', '', $dstandawal[$key]);
          $d_akhir              = empty($dakhir[$key]) ? 0 : str_replace(',', '', $dakhir[$key]);
          $d_selisihwbp         = str_replace(',', '', $dselisihwbp[$key]);
          $d_selisihlwbp        = str_replace(',', '', $dselisihlwbp[$key]);
          $d_selisih            = str_replace(',', '', $dselisih[$key]);
          $d_wbptotal           = str_replace(',', '', $dwbptotal[$key]);
          $d_lwbptotal          = str_replace(',', '', $dlwbptotal[$key]);
          $d_pemakaianwbp       = str_replace(',', '', $dpemakaianwbp[$key]);
          $d_pemakaianlwbp      = str_replace(',', '', $dpemakaianlwbp[$key]);
          $d_tarifwbp           = str_replace(',', '', $dtarifwbp[$key]);
          $d_tariflwbp          = str_replace(',', '', $dtariflwbp[$key]);
          $d_biayawbp           = str_replace(',', '', $dbiayawbp[$key]);
          $d_biayalwbp          = str_replace(',', '', $dbiayalwbp[$key]);
          $d_biaya              = str_replace(',', '', $dbiaya[$key]);
          $d_bpju               = str_replace(',', '', $dbpju[$key]);
          $d_tagihan            = str_replace(',', '', $dtagihan[$key]);
          $d_denda              = str_replace(',', '', $ddenda[$key]);
          $d_jumlah             = str_replace(',', '', $djumlah[$key]);
          $d_tax                = str_replace(',', '', $dtax[$key]);
          $d_administrasi       = str_replace(',', '', $dadministrasi[$key]);
          $d_pemakaianwbp       = str_replace(',', '', $dpemakaianwbp[$key]);
          $d_pemakaianlwbp      = str_replace(',', '', $dpemakaianlwbp[$key]);
          $d_tarifwbp           = str_replace(',', '', $dtarifwbp[$key]);
          $d_tariflwbp          = str_replace(',', '', $dtariflwbp[$key]);
          $d_biayawbp           = str_replace(',', '', $dbiayawbp[$key]);
          $d_biayalwbp          = str_replace(',', '', $dbiayalwbp[$key]);
          $d_biaya              = str_replace(',', '', $dbiaya[$key]);
          $d_bpju               = str_replace(',', '', $dbpju[$key]);
          $d_tagihan            = str_replace(',', '', $dtagihan[$key]);
          $d_denda              = str_replace(',', '', $ddenda[$key]);
          $d_jumlah             = str_replace(',', '', $djumlah[$key]);
          $d_tax                = str_replace(',', '', $dtax[$key]);
          $d_administrasi       = str_replace(',', '', $dadministrasi[$key]);
          $d_selisihlalu        = empty($dselisihlalu[$key]) ? 0 : str_replace(',', '', $dselisihlalu[$key]);
          $d_selisihavg         = empty($dselisihavg[$key]) ? 0 : str_replace(',', '', $dselisihavg[$key]);
          $d_selisihwbpavg      = empty($dselisihwbpavg[$key]) ? 0 : str_replace(',', '', $dselisihwbpavg[$key]);
          $d_selisihlwbpavg     = empty($dselisihlwbpavg[$key]) ? 0 : str_replace(',', '', $dselisihlwbpavg[$key]);
          $d_selisihwbplalu     = empty($dselisihwbplalu[$key]) ? 0 : str_replace(',', '', $dselisihwbplalu[$key]);
          $d_selisihlwbplalu    = empty($dselisihlwbplalu[$key]) ? 0 : str_replace(',', '', $dselisihlwbplalu[$key]);             
          $d_standakhirwbp      = empty($dstandakhirwbp[$key]) ? 0 : str_replace(',', '', $dstandakhirwbp[$key]);  
          $d_standakhirlwbp     = empty($dstandakhirlwbp[$key]) ? 0 : str_replace(',', '', $dstandakhirlwbp[$key]);     


		$d_beabeban= str_replace(',', '', $dbeabeban[$key]);
		$d_abonemen= str_replace(',', '', $dabonemen[$key]);
		
		if ($d_beabeban==""){
			$d_beabeban=0;
		}
		
		if ($d_abonemen==""){
			$d_abonemen=0;
		}
		
        if ($_type === 'DOUBLE') {
            $d_wbptotal = $wbpgedung;
            $d_lwbptotal =  $lwbpgedung;
            $d_tarifwbp = $wbptarif;
            $d_tariflwbp = $lwbptarif;       
        }
		
		if ($d_administrasi==""){
			$d_administrasi=0;
		}
		
		if ($d_tax==""){
			$d_tax=0;
		}
		
        $sp_InsertD = "EXEC [lm03_TrnUtilitieslistrikdetil_InsertIpro] '$_id', $d_line, '$d_descr', '$d_tenant_id', $d_brand_line,
            '$d_reg', '', '$d_agreement', 0, $d_amp, $d_blocked, $d_genset, $d_bebankva, $d_phase, $d_faktor,  $d_bpjumaster,
            $d_admamountmaster, $d_admpercentmaster, $d_reglimitmaster, $d_standawallwbp, $d_standakhirlwbp, $d_standawalwbp, $d_standakhirwbp, 
            $d_standawal, $d_akhir, $d_selisihlwbp,   $d_selisihwbp, $d_selisih, $d_wbptotal, $d_lwbptotal, $d_pemakaianwbp, $d_pemakaianlwbp,
            $d_tarifwbp, $d_tariflwbp, $d_biayawbp, $d_biayalwbp, $d_biaya, $d_bpju, $d_tagihan, $d_denda, $d_jumlah, $d_tax, 
            $d_administrasi, 0, '', 0, $d_selisihlalu, $d_selisihavg, $d_selisihwbpavg, $d_selisihlwbpavg, $d_selisihwbplalu, $d_selisihlwbplalu,$d_beabeban,$d_abonemen";
          $this->db->query($sp_InsertD);
        }        


        if ($this->db->trans_status() === FALSE)
        {               
            //generate an error... or use the log_message() function to log your error
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();

            return $_id;  
        }		 
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
		    
	function updatelistrik($_id, $_channel, $_date, $branch_id, $region_id, $strukturunit_id, $_transaksi, $_descr, 
        $_createby, $_createdate, $_modifyby, $_modifydate, $_type, $dposted, $dline, $dtenant_id, $dbrand_line,
        $ddescr, $dreg, $dagreement, $damp, $dblocked, $dgenset, $dbebankva, $dphase, $dfaktor, $dbpjumaster,
        $dadmamountmaster, $dadmpercentmaster, $dreglimitmaster, $dstandawalwbp, $dstandawallwbp, $dstandawal,
        $dakhir, $dselisihwbp, $dselisihlwbp, $dselisih, $dwbptotal, $dlwbptotal, $dpemakaianwbp, $dpemakaianlwbp, 
        $dtarifwbp, $dtariflwbp, $dbiayawbp, $dbiayalwbp, $dbiaya, $dbpju, $dtagihan, $ddenda, $dadministrasi, 
        $djumlah, $dtax, $dstate, $deleted, $dselisihlalu, $dselisihavg, $dselisihwbplalu, $dselisihlwbplalu, 
        $dselisihwbpavg, $dselisihlwbpavg, $dstandakhirwbp, $dstandakhirlwbp, $wbpgedung, $lwbpgedung, $wbptarif, $lwbptarif,$dbeabeban,$dabonemen)
    {                

        $timestamp = time();    
        $now = date("Y-m-d H:i:s", $timestamp); 

        $wbpgedung = empty($wbpgedung) ? 0 : str_replace(',', '', $wbpgedung);
        $lwbpgedung = empty($lwbpgedung) ? 0 : str_replace(',', '', $lwbpgedung);
        $wbptarif = empty($wbptarif) ? 0 : str_replace(',', '', $wbptarif);
        $lwbptarif = empty($lwbptarif) ? 0 : str_replace(',', '', $lwbptarif); 

        $this->db->trans_begin();

        $sp_updateH = "EXEC [lm03_TrnUtilitieslistrik_Update] '{$_id}', '$_date', '$_descr', 0, '$_createby', '$_createdate', 
            '$_modifyby', '$now', '$_type', '$region_id', '$branch_id', '$strukturunit_id', '$_transaksi', '$_channel', '', 
            $lwbptarif, $wbptarif, $lwbpgedung, $wbpgedung";        
        $this->db->query($sp_updateH);
        
        if (is_array($deleted)){
          if (count($deleted) >0){
            foreach($deleted as $key => $_line){                
                $this->db->query("
                  DELETE FROM transaksi_utilitieslistrikdetil 
                  WHERE utilitieslistrik_id='{$_id}' AND utilitieslistrikdetil_line = {$_line} ");                       
            }
          }
        }        

        foreach($dline as $key => $n){                    

          $d_line               = $dline[$key];
		 // echo $d_line ;echo "<br>";
          $d_posted             = $dposted[$key];
          $d_descr              = $ddescr[$key];
          $d_tenant_id          = $dtenant_id[$key];
          $d_brand_line         = $dbrand_line[$key];
          $d_reg                = str_replace("'", "''", $dreg[$key]);//$dreg[$key];
          $d_agreement          = $dagreement[$key];
          $d_amp                = empty($damp[$key]) ? 0 : str_replace(',', '', $damp[$key]);
          $d_blocked            = empty($dblocked[$key]) ? 0 : $dblocked[$key];
          $d_genset             = empty($dgenset[$key]) ? 0 : $dgenset[$key];
          $d_bebankva           = empty($dbebankva[$key]) ? 0 : $dbebankva[$key];
          $d_phase              = $dphase[$key];
          $d_faktor             = $dfaktor[$key];
          $d_bpjumaster         = empty($dbpjumaster[$key]) ? 0 : $dbpjumaster[$key];
          $d_admamountmaster    = empty($dadmamountmaster[$key]) ? 0 : $dadmamountmaster[$key];
          $d_admpercentmaster   = empty($dadmpercentmaster[$key]) ? 0 : $dadmpercentmaster[$key];
          $d_reglimitmaster     = empty($dreglimitmaster[$key]) ? 0 : $dbpjumaster[$key];
          $d_standawalwbp       = str_replace(',', '', $dstandawalwbp[$key]);
          $d_standawallwbp      = str_replace(',', '', $dstandawallwbp[$key]);
          $d_standawal          = empty($dstandawal[$key]) ? 0 : str_replace(',', '', $dstandawal[$key]);
          $d_akhir              = empty($dakhir[$key]) ? 0 : str_replace(',', '', $dakhir[$key]);
          $d_selisihwbp         = str_replace(',', '', $dselisihwbp[$key]);
          $d_selisihlwbp        = str_replace(',', '', $dselisihlwbp[$key]);
          $d_selisih            = str_replace(',', '', $dselisih[$key]);
          $d_wbptotal           = str_replace(',', '', $dwbptotal[$key]);
          $d_lwbptotal          = str_replace(',', '', $dlwbptotal[$key]);
          $d_pemakaianwbp       = str_replace(',', '', $dpemakaianwbp[$key]);
          $d_pemakaianlwbp      = str_replace(',', '', $dpemakaianlwbp[$key]);
          $d_tarifwbp           = str_replace(',', '', $dtarifwbp[$key]);
          $d_tariflwbp          = str_replace(',', '', $dtariflwbp[$key]);
          $d_biayawbp           = str_replace(',', '', $dbiayawbp[$key]);
          $d_biayalwbp          = str_replace(',', '', $dbiayalwbp[$key]);
          $d_biaya              = str_replace(',', '', $dbiaya[$key]);
          $d_bpju               = str_replace(',', '', $dbpju[$key]);
          $d_tagihan            = str_replace(',', '', $dtagihan[$key]);
          $d_denda              = str_replace(',', '', $ddenda[$key]);
          $d_jumlah             = str_replace(',', '', $djumlah[$key]);
          $d_tax                = str_replace(',', '', $dtax[$key]);
          $d_administrasi       = str_replace(',', '', $dadministrasi[$key]);
          $d_state              = $dstate[$key];
          $d_selisihlalu        = empty($dselisihlalu[$key]) ? 0 : str_replace(',', '', $dselisihlalu[$key]);
          $d_selisihavg         = empty($dselisihavg[$key]) ? 0 : str_replace(',', '', $dselisihavg[$key]);
          $d_selisihwbpavg      = empty($dselisihwbpavg[$key]) ? 0 : str_replace(',', '', $dselisihwbpavg[$key]);
          $d_selisihlwbpavg     = empty($dselisihlwbpavg[$key]) ? 0 : str_replace(',', '', $dselisihlwbpavg[$key]);
          $d_selisihwbplalu     = empty($dselisihwbplalu[$key]) ? 0 : str_replace(',', '', $dselisihwbplalu[$key]);
          $d_selisihlwbplalu    = empty($dselisihlwbplalu[$key]) ? 0 : str_replace(',', '', $dselisihlwbplalu[$key]);            
          $d_standakhirwbp      = empty($dstandakhirwbp[$key]) ? 0 : str_replace(',', '', $dstandakhirwbp[$key]);  
          $d_standakhirlwbp     = empty($dstandakhirlwbp[$key]) ? 0 : str_replace(',', '', $dstandakhirlwbp[$key]);     
			
			
		$d_beabeban= str_replace(',', '', $dbeabeban[$key]);
		$d_abonemen= str_replace(',', '', $dabonemen[$key]);
		
		if ($d_beabeban==""){ 
			$d_beabeban=0;
		}
		
		if ($d_abonemen==""){
			$d_abonemen=0;
		}
		
		if ($d_administrasi==""){
			$d_administrasi=0;
		}
		
		if ($d_tax==""){
			$d_tax=0;
		}
		
          if ($_type === 'DOUBLE') {
            $d_wbptotal = $wbpgedung;
            $d_lwbptotal =  $lwbpgedung;
            $d_tarifwbp = $wbptarif;
            $d_tariflwbp = $lwbptarif;        
          }

          if ( !$d_posted ) { 

            if ($d_state == "update") {                    
                $sp_UpdateD = "EXEC [lm03_TrnUtilitieslistrikdetil_UpdateIpro] '$_id', $d_line, '$d_descr', '$d_tenant_id', $d_brand_line,
                  '$d_reg', '', '$d_agreement', 0, $d_amp, $d_blocked, $d_genset, $d_bebankva, $d_phase, $d_faktor,  $d_bpjumaster,
                  $d_admamountmaster, $d_admpercentmaster, $d_reglimitmaster, $d_standawallwbp, $d_standakhirlwbp, $d_standawalwbp, $d_standakhirwbp,
                  $d_standawal, $d_akhir, $d_selisihlwbp,   $d_selisihwbp, $d_selisih, $d_wbptotal, $d_lwbptotal, $d_pemakaianwbp, $d_pemakaianlwbp,
                  $d_tarifwbp, $d_tariflwbp, $d_biayawbp, $d_biayalwbp, $d_biaya, $d_bpju, $d_tagihan, $d_denda, $d_jumlah, $d_tax, 
                  '', $d_administrasi, 0, 0, $d_selisihlalu, $d_selisihavg, $d_selisihwbpavg, $d_selisihlwbpavg, $d_selisihwbplalu, $d_selisihlwbplalu,$d_beabeban,$d_abonemen";
                  //var_dump($sp_UpdateD);exit;
                $this->db->query($sp_UpdateD);
            } else{                
                $sp_InsertD = "EXEC [lm03_TrnUtilitieslistrikdetil_InsertIpro] '$_id', $d_line, '$d_descr', '$d_tenant_id', $d_brand_line,
                  '$d_reg', '', '$d_agreement', 0, $d_amp, $d_blocked, $d_genset, $d_bebankva, $d_phase, $d_faktor,  $d_bpjumaster,
                  $d_admamountmaster, $d_admpercentmaster, $d_reglimitmaster, $d_standawallwbp, $d_standakhirlwbp, $d_standawalwbp, $d_standakhirwbp, 
                  $d_standawal, $d_akhir, $d_selisihlwbp,   $d_selisihwbp, $d_selisih, $d_wbptotal, $d_lwbptotal, $d_pemakaianwbp, $d_pemakaianlwbp,
                  $d_tarifwbp, $d_tariflwbp, $d_biayawbp, $d_biayalwbp, $d_biaya, $d_bpju, $d_tagihan, $d_denda, $d_jumlah, $d_tax, 
                  $d_administrasi, 0, '', 0, $d_selisihlalu, $d_selisihavg, $d_selisihwbpavg, $d_selisihlwbpavg, $d_selisihwbplalu, $d_selisihlwbplalu,$d_beabeban,$d_abonemen";
                $this->db->query($sp_InsertD);
            }
          }
        }        

        if ($this->db->trans_status() === FALSE)
        {               
            //generate an error... or use the log_message() function to log your error
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();

            return $_id;
        }        
    }
	
	function deletelistrik($_id){    
   
		$this->db->query("delete from transaksi_utilitieslistrik where utilitieslistrik_id='$_id'");
		$this->db->query("delete from transaksi_utilitieslistrikdetil where utilitieslistrik_id='$_id'");    
    //$this->db->query("delete from transaksi_loounit where loo_id='$loo_id'");
	}
    
  function viewlistrik($_id, $_date ='', $_region='', $_branch=''){     

     if (!empty($_id)){
        return $this->db->query("
           SELECT UTL.utilitieslistrik_id, convert(varchar(10),utilitieslistrik_date,120) AS utilitieslistrik_date, 
              utilitieslistrik_descr, utilitieslistrik_isposted, utilitieslistrik_createby, utilitieslistrik_createdate,
              utilitieslistriktype_id, utilitieslistrik_modifyby, utilitieslistrik_modifydate, TRS.transaksi_name,
              UTL.region_id, UTL.branch_id, UTL.strukturunit_id, UTL.transaksi_id, UTL.channel_id,
              BRA.branch_name, REG.region_name, UTL.utilitieslistrik_lwbptarif, UTL.utilitieslistrik_wbptarif, UTL.utilitieslistrik_lwbpgedung,
              UTL.utilitieslistrik_wbpgedung
           FROM transaksi_utilitieslistrik AS UTL 
              LEFT JOIN master_transaksi TRS ON TRS.transaksi_id = UTL.transaksi_id
              LEFT JOIN master_branch AS BRA ON UTL.branch_id = BRA.branch_id
              LEFT JOIN master_region AS REG ON UTL.region_id = REG.region_id
           WHERE UTL.utilitieslistrik_id='$_id'
       ")->result();        
     }else{         
       $timestamp = time();
      
       $now = date("Y-m-d", $timestamp);  

       $result[] = (object) array(                        
                        'utilitieslistrik_id'           =>'auto',
                        'utilitieslistrik_date'         => $_date,
                        'utilitieslistrik_descr'        => '',
                        'utilitieslistrik_createby'     => '',
                        'utilitieslistrik_createdate'   => $now,
                        'utilitieslistrik_modifyby'     => '',
                        'utilitieslistrik_modifydate'   => $now,
                        'region_id'                     => $_region,
                        'region_name'                   => '',
                        'branch_id'                     => $_branch,
                        'branch_name'                   => '',
                        'strukturunit_id'               => '0',
                        'strukturunit_name'             => '',
                        'transaksi_id'                  => '100930',
                        'transaksi_name'                => 'Pencatatan Utilities',
                        'channel_id'                    => $this->session->userdata('channel_id'),
                        'utilitieslistrik_lwbptarif'    => 0,
                        'utilitieslistrik_wbptarif'     => 0,
                        'utilitieslistrik_lwbpgedung'   => 0,
                        'utilitieslistrik_wbpgedung'    => 0
       ); 

       return $result;
     }

   }   

 function getPassword($id){

  $qry= " SELECT A.*, B.agreementtype_name
          FROM master_sklterm A inner join master_agreementtype B ON A.skl_atype = B.agreementtype_id
          WHERE A.skl_id = '{$id}' ";

  return $this->db->query($qry)->result_array();   
 }     

  function get_openperiode(){
        
        $this->db->select('periode_id, periode_name');
        $this->db->where('periode_isclosed = 0');
        $query = $this->db->get('master_periodeutilities');
        
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


  function getdatadetil($_id, $_date ='', $_region='', $_branch='', $_issingle){    
  
    if (!empty($_id)){      

        $sql = "
          SELECT ULD.*, REK.rekanan_name AS rekanan_name, SHP.rekananshipping_name AS shop_name, 
            utilitieslistrikdetil_reg AS rekananutilitieslistrik_reg,            
            utilitieslistrikdetil_amp AS rekananutilitieslistrik_amp,
            utilitieslistrikdetil_isblocked AS rekananutilitieslistrik_isblocked,
            utilitieslistrikdetil_isgenset AS rekananutilitieslistrik_isgenset,
            utilitieslistrikdetil_bebankva AS rekananutilitieslistrik_kva,
            utilitieslistrikdetil_phase AS rekananutilitieslistrik_phase,
            utilitieslistrikdetil_faktor AS rekananutilitieslistrik_faktor,
            utilitieslistrikdetil_bpjumaster AS rekananutilitieslistrik_bpju,
            utilitieslistrikdetil_admamountmaster AS rekananutilitieslistrik_admamount,
            utilitieslistrikdetil_admpercentmaster AS rekananutilitieslistrik_admpercent,
            utilitieslistrikdetil_reglimitmaster AS rekananutilitieslistrik_reglimit,
            utilitieslistrikdetil_tax AS rekananshipping_tax,
            utilitieslistrikdetil_minkwh          
          FROM transaksi_utilitieslistrikdetil ULD
            LEFT JOIN master_rekanan REK ON REK.rekanan_id = ULD.rekanan_id
            LEFT JOIN master_rekananshipping SHP ON SHP.rekanan_id = ULD.rekanan_id AND SHP.rekananshipping_line = ULD.rekananshipping_line
          WHERE ULD.utilitieslistrik_id = '$_id'
          ORDER BY  utilitieslistrik_id, utilitieslistrikdetil_line ASC";  
        return $this->db->query($sql)->result();  

    }else{       

        $sp = "EXEC LM03_TrnUtilities_SelectTenant '$_date', $_issingle, '$_region', '$_branch' ";
        $result = $this->db->query($sp);
                
        return $result->result();              
    }

  } 

  function getTenantbyid($_date, $_issingle, $_region, $_branch, $_tenant, $_brand){    
        
        $sp = "EXEC LM03_TrnUtilities_SelectTenantbyid '{$_date}', $_issingle, '{$_region}', '{$_branch}', '{$_tenant}', '{$_brand}'";
        $result = $this->db->query($sp);
        //print_r($sp);
        return $result->result();          
  } 

  function getdataagreement($r_id, $r_line ='', $_region='', $_branch=''){

      $sp = "EXEC lm03_TrnAgreement_SelectTenantWS '', 'a.agreement_isclosed=0 
              and a.rekanan_id = ''".$r_id."'' 
              and a.rekananshipping_line= ".$r_line." 
              and a.region_id=''".$_region."'' 
              and a.branch_id= ''".$_branch."''', 1, 10";

      $result = $this->db->query($sp);

      //print_r($sp);
      return $result->result();

  } 

  function RecalculateWattTotal($_id){    
  
      if (!empty($_id)){                

          $sp = "EXEC lm03_TrnUtilitiesListrik_RefreshKwH '$_id', '' ";
          $this->db->query($sp);          
          //return $result->result();     
      }

  } 

  function CekTransaction($_date, $_type, $_region, $_branch){

      $query = "EXEC lm03_TrnUtilitiesListrik_CekTransaction '{$_date}', 'branch_id = ''{$_branch}''
          and region_id = ''{$_region}''
          and utilitieslistriktype_id = ''{$_type}'''";      

      $result = $this->db->query($query)->row_array();
      $_id = $result['utilitieslistrik_id'];

      return $_id;

  }
  
  function updateLink($_id, $_line, $_name){
   		
		$this->db->query("UPDATE transaksi_utilitieslistrikdetil 
                      SET utilitieslistrikdetil_link = '{$_name}' 
                      WHERE utilitieslistrik_id='{$_id}' AND utilitieslistrikdetil_line = $_line");    
	}
    
}
