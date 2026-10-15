<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_listrik extends CI_Model{
    
    function __construct(){
        parent::__construct();
		set_time_limit(0);
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
          SELECT top $limit CTE.utilitieslistrik_id, CTE.utilitieslistrik_descr, CTE.utilitieslistrik_date, CTE.utilitieslistrik_duedate,
            ROW_NUMBER() OVER (ORDER BY CTE.utilitieslistrik_id desc) as RowNumber,
            REGION.region_name, BRANCH.branch_name, STRU.strukturunit_name, MAX(LDT.utilitieslistrikdetil_isposted) AS isposted
          FROM transaksi_utilitieslistrik_tkm AS CTE       
            INNER JOIN transaksi_utilitieslistrikdetil_tkm AS LDT ON CTE.utilitieslistrik_id = LDT.utilitieslistrik_id
            JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
            JOIN master_strukturunit AS STRU ON CTE.strukturunit_id = STRU.strukturunit_id      
          $sWhere 
          GROUP BY REGION.region_name, BRANCH.branch_name, STRU.strukturunit_name, CTE.utilitieslistrik_id, CTE.utilitieslistrik_descr, CTE.utilitieslistrik_date,CTE.utilitieslistrik_duedate
          ORDER BY CTE.utilitieslistrik_id DESC
        ) AS V
        WHERE   RowNumber > $top";        
	    return $this->db->query($qry)->result_array();
   }
   
    function qry_filteredlist($sWhere){
      
	    $qry="
        SELECT COUNT(*) as jml FROM (
  			  SELECT CTE.utilitieslistrik_id
  			  FROM transaksi_utilitieslistrik_tkm AS CTE       
            JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
            JOIN master_strukturunit AS STRU ON CTE.strukturunit_id = STRU.strukturunit_id
  			  $sWhere
  			) AS V";

		  return $this->db->query($qry)->row_array();	   
   }
   
   function qry_totalalllist(){
	   
      $qry="SELECT COUNT(utilitieslistrik_id) AS jml FROM transaksi_utilitieslistrik_tkm";

		return $this->db->query($qry)->row_array();
	   
   }
   
    function insertlistrik($_id, $_channel, $_date, $_duedate, $branch_id, $region_id, $strukturunit_id, $_transaksi, $_descr, 
          $_createby, $_createdate, $_modifyby, $_modifydate, $dposted, $dline, $dmaterai, $dstandawal, $dakhir, 
          $ddescr, $dkva, $dnilwbp, $dagreement, $dniltech, $dnilparams, $dtax, $dstate, $deleted, $type
    )
    {             

        $timestamp = time();		
        $now = date("Y-m-d H:i:s", $timestamp);        
             
        $this->db->trans_begin();

        $sp_insertH = "EXEC [lm03_TrnUtilitieslistrik_Insert_tkm] '', '$_date', '$_duedate', '$_descr', 0, '$_createby', '$now', '', '$now',  
            '$type', '$region_id', '$branch_id', '$strukturunit_id', '$_transaksi', '$_channel', ''";        
        $result = $this->db->query($sp_insertH)->row_array();
        $_id =  $result['utilitieslistrik_id'];              


        foreach($dline as $key => $n){          

          $d_posted             = $dposted[$key];
          $d_descr              = $ddescr[$key];

          $vnilai_join          = $dline[$key];
          
      
          $pieces = explode("#",$vnilai_join);
      
          $d_line = $pieces[0];
          $d_brand_line =$pieces[1];
          $d_tenant_id=$pieces[2];
          //$dRekName=$pieces[3];
          $dRekShop=$pieces[4];         
         
          $vbeban = $dkva[$key];
          $piecesbeban = explode("#", $vbeban);          

          $d_kva                = $piecesbeban[0];
          $d_phase              = $piecesbeban[1];
          $d_faktor             = $piecesbeban[2];
          $d_amp                = $piecesbeban[3];
          $d_unit               = $piecesbeban[4];
          $d_reg                = $this->db->escape($piecesbeban[5]);
          $d_type               = $piecesbeban[6];

          $vtech = $dniltech[$key];
          $ptech = explode("#", $vtech);
          $d_faktorkali         = empty($ptech[0]) ? 0 : str_replace(',', '', $ptech[0]);    
          $d_minjamnyala        = empty($ptech[1]) ? 0 : str_replace(',', '', $ptech[1]);
          $d_tarifpln           = empty($ptech[2]) ? 0 : str_replace(',', '', $ptech[2]);
          $d_tarifgenset        = empty($ptech[3]) ? 0 : str_replace(',', '', $ptech[3]);
          $d_jamgenset          = empty($ptech[4]) ? 0 : str_replace(',', '', $ptech[4]);
          $d_cosq               = empty($ptech[5]) ? 0 : str_replace(',', '', $ptech[5]);
          $d_bea_beban           = empty($ptech[6]) ? 0 : str_replace(',', '', $ptech[6]);
          $d_bea_energi          = empty($ptech[7]) ? 0 : str_replace(',', '', $ptech[7]);

          $vwbp = $dnilwbp[$key];
          $pwbp = explode("#", $vwbp);
          $d_standawallwbp        = (float)empty($pwbp[0]) ? 0 : str_replace(',', '', $pwbp[0]);    
          $d_standakhirlwbp       = (float)empty($pwbp[1]) ? 0 : str_replace(',', '', $pwbp[1]);
          $d_standawalwbp         = (float)empty($pwbp[2]) ? 0 : str_replace(',', '', $pwbp[2]);
          $d_standakhirwbp        = (float)empty($pwbp[3]) ? 0 : str_replace(',', '', $pwbp[3]);
          $d_selisihlwbp          = (float)empty($pwbp[4]) ? 0 : str_replace(',', '', $pwbp[4]);
          $d_selisihwbp           = (float)empty($pwbp[5]) ? 0 : str_replace(',', '', $pwbp[5]);
          $d_totallwbpwbp         = (float)empty($pwbp[6]) ? 0 : str_replace(',', '', $pwbp[6]);
          
          $d_agreement            = empty($dagreement[$key]) ? 0 : str_replace(',', '', $dagreement[$key]); 
        
          $d_standawal          = empty($dstandawal[$key]) ? 0 : str_replace(',', '', $dstandawal[$key]);
          $d_akhir              = empty($dakhir[$key]) ? 0 : str_replace(',', '', $dakhir[$key]);

          $d_wbptotal          = empty($dwbptotal[$key]) ? 0 : str_replace(',', '', $dwbptotal[$key]);
          $d_lwbptotal         = empty($dlwbptotal[$key]) ? 0 : str_replace(',', '', $dlwbptotal[$key]);
          $d_pemakaianwbp      = empty($dpemakaianwbp[$key]) ? 0 : str_replace(',', '', $dpemakaianwbp[$key]);
          $d_pemakaianlwbp     = empty($dpemakaianlwbp[$key]) ? 0 : str_replace(',', '', $dpemakaianlwbp[$key]);
          $d_tarifwbp          = empty($dtarifwbp[$key]) ? 0 : str_replace(',', '', $dtarifwbp[$key]);
          $d_tariflwbp         = empty($dtariflwbp[$key]) ? 0 : str_replace(',', '', $dtariflwbp[$key]);
          $d_biayawbp          = empty($dbiayawbp[$key]) ? 0 : str_replace(',', '', $dbiayawbp[$key]);
          $d_biayalwbp         = empty($dbiayalwbp[$key]) ? 0 : str_replace(',', '', $dbiayalwbp[$key]);          
         
          $d_denda                  = empty($ddenda[$key]) ? 0 : str_replace(',', '', $ddenda[$key]);

          $vparams = $dnilparams[$key];
          $pparams = explode("#", $vparams);
          $d_pemakaiankwh           = (float)empty($pparams[0]) ? 0 : str_replace(',', '', $pparams[0]);    
          $d_jamnyalapln            = (float)empty($pparams[1]) ? 0 : str_replace(',', '', $pparams[1]);
          $d_jamnyalagenset         = (float)empty($pparams[2]) ? 0 : str_replace(',', '', $pparams[2]);
          $d_procentjamnyalapln     = (float)empty($pparams[3]) ? 0 : str_replace(',', '', $pparams[3]);
          $d_procentjamnyalagenset  = (float)empty($pparams[4]) ? 0 : str_replace(',', '', $pparams[4]);
          $d_bpju                   = (float)empty($pparams[5]) ? 0 : str_replace(',', '', $pparams[5]);
          $d_biaya                  = (float)empty($pparams[6]) ? 0 : str_replace(',', '', $pparams[6]);

          $d_state              = $dstate[$key];

          //$d_bpju               = empty($dbpju[$key]) ? 0 : str_replace(',', '', $dbpju[$key]);
          $d_tax                = empty($dtax[$key]) ? 0 : str_replace(',', '', $dtax[$key]);
          $d_materai            = empty($dmaterai[$key]) ? 0 : str_replace(',', '', $dmaterai[$key]);

          $ret = $this->calculateAmount($d_akhir, $d_standawal, $d_kva, $d_faktor, $d_procentjamnyalapln, $d_procentjamnyalagenset, $d_type, $d_minjamnyala, 
            $d_tarifpln, $d_tarifgenset,$d_bea_beban, $d_bpju, $d_biaya, $d_tax, $d_materai);

          $d_selisih              = $ret->selisih;
          $d_jumlahkwh            = $ret->jumlahkwh;
          $d_pemakaiankwhpln      = $ret->pemakaianpln;
          $d_pemakaiankwhgenset   = $ret->pemakaiangenset;
          $d_jamnyala             = $ret->jamnyala;
          $d_biayabeban           = $ret->biayabeban;
          $d_biayapln             = $ret->biayapln;
          $d_biayagenset          = $ret->biayagenset;
          $d_subtotal1            = $ret->subtotal1;
          $d_subtotal2            = $ret->subtotal2;
          $d_tagihan              = $ret->tagihan;
          $d_jumlah               = $ret->jumlah;

          //var_dump($ret);exit;


          if ($type === 'DOUBLE') {
            $d_wbptotal = $wbpgedung;
            $d_lwbptotal =  $lwbpgedung;
            $d_tarifwbp = $wbptarif;
            $d_tariflwbp = $lwbptarif;        
          }

          $sp_InsertD = "EXEC [lm03_TrnUtilitieslistrikdetil_Insert_tkm] '$_id', $d_line, '$d_descr', '$d_tenant_id', $d_brand_line,
            $d_reg, '$d_unit', $d_amp, $d_phase, $d_faktor, $d_standawallwbp, $d_standakhirlwbp, $d_standawalwbp, $d_standakhirwbp, $d_standawal, $d_akhir, 
            $d_selisihlwbp,   $d_selisihwbp, $d_selisih, $d_wbptotal, $d_lwbptotal, $d_pemakaianwbp, $d_pemakaianlwbp,
            $d_tarifwbp, $d_tariflwbp, $d_biayawbp, $d_biayalwbp, $d_biaya, $d_denda, $d_jumlah, $d_faktorkali, $d_kva, $d_minjamnyala,
            $d_tarifpln, $d_tarifgenset, $d_jamgenset,  $d_cosq, $d_totallwbpwbp, $d_pemakaiankwh, $d_jamnyalapln, $d_jamnyalagenset, 
            $d_procentjamnyalapln, $d_procentjamnyalagenset, $d_jumlahkwh, $d_pemakaiankwhpln, $d_pemakaiankwhgenset, $d_jamnyala, $d_biayapln, 
            $d_biayagenset, $d_subtotal1, $d_subtotal2, $d_bpju, $d_tax, $d_materai, $d_tagihan, $d_bea_beban, $d_bea_energi, $d_biayabeban, $d_type, '',
            $d_agreement";          

          $this->db->query($sp_InsertD);     

        }                


        if ($this->db->trans_status() === FALSE)
        {               
            //generate an error... or use the log_message() function to log your error            
            $this->db->trans_rollback();
            return $this->db->error();
        }else{
            $this->db->trans_commit();

            return $_id;  
        }		 
    }

  function vdetil($_id){          
        $sql = "
          SELECT ULD.*, REK.rekanan_name AS rekanan_name, SHP.rekananshipping_name AS rekananshipping_name
          FROM transaksi_utilitieslistrikdetil_tkm ULD
            LEFT JOIN master_rekanan REK ON REK.rekanan_id = ULD.rekanan_id
            LEFT JOIN master_rekananshipping SHP ON SHP.rekanan_id = ULD.rekanan_id AND SHP.rekananshipping_line = ULD.rekananshipping_line
          WHERE ULD.utilitieslistrik_id = '$_id'
          ORDER BY  utilitieslistrik_id, utilitieslistrikdetil_line ASC";  
    return $this->db->query($sql)->result();      
  } 
		    
    function updatelistrik($_id, $_channel, $_date, $_duedate, $branch_id, $region_id, $strukturunit_id, $_transaksi, $_descr, 
          $_createby, $_createdate, $_modifyby, $_modifydate, $dposted, $dline, $dmaterai, $dstandawal, $dakhir, 
          $ddescr, $dkva, $dnilwbp, $dagreement, $dniltech, $dnilparams, $dtax, $dstate, $deleted, $type
    )
    {                

        $timestamp = time();    
        $now = date("Y-m-d H:i:s", $timestamp); 

        $wbpgedung = empty($wbpgedung) ? 0 : str_replace(',', '', $wbpgedung);
        $lwbpgedung = empty($lwbpgedung) ? 0 : str_replace(',', '', $lwbpgedung);
        $wbptarif = empty($wbptarif) ? 0 : str_replace(',', '', $wbptarif);
        $lwbptarif = empty($lwbptarif) ? 0 : str_replace(',', '', $lwbptarif);             

        $this->db->trans_begin();

        $sp_updateH = "EXEC [lm03_TrnUtilitieslistrik_Update_tkm] '{$_id}', '$_date', '$_duedate', '$_descr', 0, '$_createby', '$_createdate', 
            '$_modifyby', '$now', '$type', '$region_id', '$branch_id', '$strukturunit_id', '$_transaksi', '$_channel', ''";        
        $this->db->query($sp_updateH);
        
        if (is_array($deleted)){
          if (count($deleted) >0){
            foreach($deleted as $key => $_line){                
                $this->db->query("
                  DELETE FROM transaksi_utilitieslistrikdetil_tkm 
                  WHERE utilitieslistrik_id='{$_id}' AND utilitieslistrikdetil_line = {$_line} ");                       
            }
          }
        }        

        foreach($dline as $key => $n){                    
          
          $d_posted             = $dposted[$key];
          $d_descr              = $ddescr[$key];

          $vnilai_join          = $dline[$key];
          
			
          $pieces = explode("#",$vnilai_join);
    	
    			$d_line = $pieces[0];
    			$d_brand_line =$pieces[1];
    			$d_tenant_id=$pieces[2];
    			//$dRekName=$pieces[3];
    			$dRekShop=$pieces[4];	



		      //$d_reg                = str_replace("'", "''", $dreg[$key]);//$dreg[$key];
          //$d_agreement          = $dagreement[$key];
         
		      $vbeban = $dkva[$key];
          $piecesbeban = explode("#", $vbeban);

      		$d_kva                = $piecesbeban[0];	  
      		$d_phase              = $piecesbeban[1];
          $d_faktor             = $piecesbeban[2];
          $d_amp                = $piecesbeban[3];
          $d_unit               = $piecesbeban[4];
          $d_reg                = $this->db->escape($piecesbeban[5]);
          $d_type               = $piecesbeban[6];

          $vtech = $dniltech[$key];
          $ptech = explode("#", $vtech);
          $d_faktorkali         = (float)empty($ptech[0]) ? 0 : str_replace(',', '', $ptech[0]);    
          $d_minjamnyala        = (float)empty($ptech[1]) ? 0 : str_replace(',', '', $ptech[1]);
          $d_tarifpln           = (float)empty($ptech[2]) ? 0 : str_replace(',', '', $ptech[2]);
          $d_tarifgenset        = (float)empty($ptech[3]) ? 0 : str_replace(',', '', $ptech[3]);
          $d_jamgenset          = (float)empty($ptech[4]) ? 0 : str_replace(',', '', $ptech[4]);
          $d_cosq               = (float)empty($ptech[5]) ? 0 : str_replace(',', '', $ptech[5]);
          $d_bea_beban           = (float)empty($ptech[6]) ? 0 : str_replace(',', '', $ptech[6]);
          $d_bea_energi          = (float)empty($ptech[7]) ? 0 : str_replace(',', '', $ptech[7]);


          $vwbp = $dnilwbp[$key];
          $pwbp = explode("#", $vwbp);
          $d_standawallwbp        = (float)empty($pwbp[0]) ? 0 : str_replace(',', '', $pwbp[0]);    
          $d_standakhirlwbp       = (float)empty($pwbp[1]) ? 0 : str_replace(',', '', $pwbp[1]);
          $d_standawalwbp         = (float)empty($pwbp[2]) ? 0 : str_replace(',', '', $pwbp[2]);
          $d_standakhirwbp        = (float)empty($pwbp[3]) ? 0 : str_replace(',', '', $pwbp[3]);
          $d_selisihlwbp          = (float)empty($pwbp[4]) ? 0 : str_replace(',', '', $pwbp[4]);
          $d_selisihwbp           = (float)empty($pwbp[5]) ? 0 : str_replace(',', '', $pwbp[5]);
          $d_totallwbpwbp         = (float)empty($pwbp[6]) ? 0 : str_replace(',', '', $pwbp[6]);
          
          $d_agreement            = empty($dagreement[$key]) ? 0 : str_replace(',', '', $dagreement[$key]);          

          $d_standawal          = empty($dstandawal[$key]) ? 0 : str_replace(',', '', $dstandawal[$key]);
          $d_akhir              = empty($dakhir[$key]) ? 0 : str_replace(',', '', $dakhir[$key]);
      
          $d_wbptotal          = empty($dwbptotal[$key]) ? 0 : str_replace(',', '', $dwbptotal[$key]);
          $d_lwbptotal         = empty($dlwbptotal[$key]) ? 0 : str_replace(',', '', $dlwbptotal[$key]);
          $d_pemakaianwbp      = empty($dpemakaianwbp[$key]) ? 0 : str_replace(',', '', $dpemakaianwbp[$key]);
          $d_pemakaianlwbp     = empty($dpemakaianlwbp[$key]) ? 0 : str_replace(',', '', $dpemakaianlwbp[$key]);
          $d_tarifwbp          = empty($dtarifwbp[$key]) ? 0 : str_replace(',', '', $dtarifwbp[$key]);
          $d_tariflwbp         = empty($dtariflwbp[$key]) ? 0 : str_replace(',', '', $dtariflwbp[$key]);
          $d_biayawbp          = empty($dbiayawbp[$key]) ? 0 : str_replace(',', '', $dbiayawbp[$key]);
          $d_biayalwbp         = empty($dbiayalwbp[$key]) ? 0 : str_replace(',', '', $dbiayalwbp[$key]);
          
          $d_denda                  = empty($ddenda[$key]) ? 0 : str_replace(',', '', $ddenda[$key]);        

          $vparams = $dnilparams[$key];
          $pparams = explode("#", $vparams);
          $d_pemakaiankwh           = (float)empty($pparams[0]) ? 0 : str_replace(',', '', $pparams[0]);    
          $d_jamnyalapln            = (float)empty($pparams[1]) ? 0 : str_replace(',', '', $pparams[1]);
          $d_jamnyalagenset         = (float)empty($pparams[2]) ? 0 : str_replace(',', '', $pparams[2]);
          $d_procentjamnyalapln     = (float)empty($pparams[3]) ? 0 : str_replace(',', '', $pparams[3]);
          $d_procentjamnyalagenset  = (float)empty($pparams[4]) ? 0 : str_replace(',', '', $pparams[4]);
          $d_bpju                   = (float)empty($pparams[5]) ? 0 : str_replace(',', '', $pparams[5]);
          $d_biaya                  = (float)empty($pparams[6]) ? 0 : str_replace(',', '', $pparams[6]);

          $d_state              = $dstate[$key];
                  
          $d_tax                = empty($dtax[$key]) ? 0 : str_replace(',', '', $dtax[$key]);
          $d_materai            = empty($dmaterai[$key]) ? 0 : str_replace(',', '', $dmaterai[$key]);          

          $ret = $this->calculateAmount($d_akhir, $d_standawal, $d_kva, $d_faktor, $d_procentjamnyalapln, $d_procentjamnyalagenset, $d_type, $d_minjamnyala, 
            $d_tarifpln, $d_tarifgenset,$d_bea_beban, $d_bpju, $d_biaya, $d_tax, $d_materai);


          $d_selisih              = $ret->selisih;
          $d_jumlahkwh            = $ret->jumlahkwh;
          $d_pemakaiankwhpln      = $ret->pemakaianpln;
          $d_pemakaiankwhgenset   = $ret->pemakaiangenset;
          $d_jamnyala             = $ret->jamnyala;
          $d_biayabeban           = $ret->biayabeban;
          $d_biayapln             = $ret->biayapln;
          $d_biayagenset          = $ret->biayagenset;
          $d_subtotal1            = $ret->subtotal1;
          $d_subtotal2            = $ret->subtotal2;
          $d_tagihan              = $ret->tagihan;
          $d_jumlah               = $ret->jumlah;

          if ($type === 'DOUBLE') {
            $d_wbptotal = $wbpgedung;
            $d_lwbptotal =  $lwbpgedung;
            $d_tarifwbp = $wbptarif;
            $d_tariflwbp = $lwbptarif;        
          }
          

          if ( !$d_posted ) { 

            if ($d_state == "update") {                    
                $sp_UpdateD = "EXEC [lm03_TrnUtilitieslistrikdetil_Update_tkm] '$_id', $d_line, '$d_descr', '$d_tenant_id', $d_brand_line,
                  $d_reg, '$d_unit', $d_amp, $d_phase, $d_faktor, $d_standawallwbp, $d_standakhirlwbp, $d_standawalwbp, $d_standakhirwbp, $d_standawal, $d_akhir, 
                  $d_selisihlwbp,   $d_selisihwbp, $d_selisih, $d_wbptotal, $d_lwbptotal, $d_pemakaianwbp, $d_pemakaianlwbp,
                  $d_tarifwbp, $d_tariflwbp, $d_biayawbp, $d_biayalwbp, $d_biaya, $d_denda, $d_jumlah, $d_faktorkali, $d_kva, $d_minjamnyala,
                  $d_tarifpln, $d_tarifgenset, $d_jamgenset, $d_cosq, $d_totallwbpwbp, $d_pemakaiankwh, $d_jamnyalapln, $d_jamnyalagenset, 
                  $d_procentjamnyalapln, $d_procentjamnyalagenset, $d_jumlahkwh, $d_pemakaiankwhpln, $d_pemakaiankwhgenset, $d_jamnyala, $d_biayapln, 
                  $d_biayagenset, $d_subtotal1, $d_subtotal2, $d_bpju, $d_tax, $d_materai, $d_tagihan, $d_bea_beban, $d_bea_energi, $d_biayabeban, $d_type, '',
                  $d_agreement";
                $this->db->query($sp_UpdateD);
            } else{                              
                $sp_InsertD = "EXEC [lm03_TrnUtilitieslistrikdetil_Insert_tkm] '$_id', $d_line, '$d_descr', '$d_tenant_id', $d_brand_line,
                  $d_reg, '$d_unit', $d_amp, $d_phase, $d_faktor, $d_standawallwbp, $d_standakhirlwbp, $d_standawalwbp, $d_standakhirwbp, $d_standawal, $d_akhir, 
                  $d_selisihlwbp,   $d_selisihwbp, $d_selisih, $d_wbptotal, $d_lwbptotal, $d_pemakaianwbp, $d_pemakaianlwbp,
                  $d_tarifwbp, $d_tariflwbp, $d_biayawbp, $d_biayalwbp, $d_biaya, $d_denda, $d_jumlah, $d_faktorkali, $d_kva, $d_minjamnyala,
                  $d_tarifpln, $d_tarifgenset, $d_jamgenset, $d_cosq, $d_totallwbpwbp, $d_pemakaiankwh, $d_jamnyalapln, $d_jamnyalagenset, 
                  $d_procentjamnyalapln, $d_procentjamnyalagenset, $d_jumlahkwh, $d_pemakaiankwhpln, $d_pemakaiankwhgenset, $d_jamnyala, $d_biayapln, 
                  $d_biayagenset, $d_subtotal1, $d_subtotal2, $d_bpju, $d_tax, $d_materai, $d_tagihan, $d_bea_beban, $d_bea_energi, $d_biayabeban, $d_type, '',
                  $d_agreement";                  
                $this->db->query($sp_InsertD);
            }
          }
        } 




            //var_dump($this->db->last_query());
            //var_dump($this->db->trans_status());exit;
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
   
		$this->db->query("delete from transaksi_utilitieslistrik_tkm where utilitieslistrik_id='$_id'");
		$this->db->query("delete from transaksi_utilitieslistrikdetil_tkm where utilitieslistrik_id='$_id'");    
    //$this->db->query("delete from transaksi_loounit where loo_id='$loo_id'");
	}
    
  function viewlistrik($_id, $_date ='', $_region='', $_branch=''){     

     if (!empty($_id)){
        return $this->db->query("
           SELECT UTL.utilitieslistrik_id, convert(varchar(10),utilitieslistrik_date,120) AS utilitieslistrik_date, 
              utilitieslistrik_descr, utilitieslistrik_isposted, utilitieslistrik_createby, utilitieslistrik_createdate,
              utilitieslistriktype_id, utilitieslistrik_modifyby, utilitieslistrik_modifydate, TRS.transaksi_name,
              UTL.region_id, UTL.branch_id, UTL.strukturunit_id, UTL.transaksi_id, UTL.channel_id,
              BRA.branch_name, REG.region_name, utilitieslistrik_lwbptarif=0, utilitieslistrik_wbptarif=0, utilitieslistrik_lwbpgedung=0,
              utilitieslistrik_wbpgedung=0, utilitieslistrik_duedate
           FROM transaksi_utilitieslistrik_tkm AS UTL 
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


  function getdatadetil($_id, $_date ='', $_region='', $_branch='', $_issingle){    
  
    if (!empty($_id)){      

        $sql = "
          SELECT ULD.*, REK.rekanan_name AS rekanan_name, SHP.rekananshipping_name AS shop_name, 
            utilitieslistrikdetil_reg AS rekananutilitieslistrik_reg,      
            utilitieslistrikdetil_unit AS rekananutilitieslistrik_unit,      
            utilitieslistrikdetil_amp AS rekananutilitieslistrik_amp,
            utilitieslistrikdetil_phase AS rekananutilitieslistrik_phase,
            utilitieslistrikdetil_faktor AS rekananutilitieslistrik_faktor,
            utilitieslistrikdetil_kva AS rekananutilitieslistrik_kva,
            utilitieslistrikdetil_tax AS rekananshipping_tax
          FROM transaksi_utilitieslistrikdetil_tkm ULD
            LEFT JOIN master_rekanan REK ON REK.rekanan_id = ULD.rekanan_id
            LEFT JOIN master_rekananshipping SHP ON SHP.rekanan_id = ULD.rekanan_id AND SHP.rekananshipping_line = ULD.rekananshipping_line
          WHERE ULD.utilitieslistrik_id = '$_id'
          ORDER BY  utilitieslistrik_id, utilitieslistrikdetil_line ASC";  
        return $this->db->query($sql)->result();  

    }else{       

        $sp = "EXEC LM03_TrnUtilities_SelectTenant_TKM_IPRO '$_date', $_issingle, '$_region', '$_branch' ";
        $result = $this->db->query($sp);

        //var_dump($this->db->last_query());exit;
                
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

          $sp = "EXEC lm03_TrnUtilitiesListrik_RefreshKwH_tkm '$_id', '' ";
          
         //print_r($sp);
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
   		
		$this->db->query("UPDATE transaksi_utilitieslistrikdetil_tkm 
                      SET utilitieslistrikdetil_link = '{$_name}' 
                      WHERE utilitieslistrik_id='{$_id}' AND utilitieslistrikdetil_line = $_line");    
	}


  function calculateAmount($saldoakhir, $saldoawal, $kva, $fMeter, $prosenPLN, $prosenGenset, $dtype, $minjamnyala, $tarifPLN, $tarifGenset,
      $beabeban, $bpju, $biaya, $tax, $materai)
  {

      $obj = new \stdClass;

      $selisih = ( $saldoakhir - $saldoawal );
      $jumlahKWH = ( $selisih * $fMeter );
      $pakaiKWHpln = ( $jumlahKWH * $prosenPLN );
      $pakaiKWHgenset = ( $jumlahKWH * $prosenGenset );

      $biayabeban = 0;
      $subtotal1 = 0;
      $jamnyala = 0;


      if ($dtype == 1){

          $jamnyala = ( $pakaiKWHpln / $kva );        

          if ($jamnyala < $minjamnyala) {
              $biayapln = ( $minjamnyala * $tarifPLN * $kva );
          } else {
              $biayapln = ( $pakaiKWHpln * $tarifPLN );
          }

          $biayagenset = ( $pakaiKWHgenset * $tarifGenset );

          $subtotal1 = ( $biayapln + $biayagenset );
      } elseif ($dtype == 2) {        
        // code...
          $biayapln = ( $pakaiKWHpln * $tarifPLN );
          $biayagenset = ( $pakaiKWHgenset * $tarifGenset );    
          $biayabeban = ( $beabeban * $kva );
          $subtotal1 = ( $biayabeban + $biayapln + $biayagenset );
      } else {
          $biayapln = ( $pakaiKWHpln * $tarifPLN );
          $biayagenset = ( $pakaiKWHgenset * $tarifGenset );       
          $subtotal1 = ( $biayabeban + $biayapln + $biayagenset );
      }


      if ( $bpju > 0 ) {
          $subtotal2 = ( $subtotal1 + ( ( $subtotal1 * $bpju ) / 100 ) );        
      } else {
          $subtotal2 = $subtotal1;
      } 

      $tagihan = ( $subtotal2 + ( ( $subtotal2 * $biaya ) / 100 ) );
      $jumlah = ( $tagihan + ( $tagihan * ($tax / 100) ) + $materai );


      $obj->selisih           = $selisih;
      $obj->jumlahkwh         = $jumlahKWH;
      $obj->pemakaianpln      = $pakaiKWHpln;
      $obj->pemakaiangenset   = $pakaiKWHgenset;
      $obj->jamnyala          = $jamnyala;
      $obj->biayabeban        = $biayabeban;
      $obj->biayapln          = $biayapln;
      $obj->biayagenset       = $biayagenset;
      $obj->subtotal1         = $subtotal1;
      $obj->subtotal2         = $subtotal2;
      $obj->tagihan           = $tagihan;
      $obj->jumlah            = $jumlah;


      return $obj;     

         
  }
    
}
