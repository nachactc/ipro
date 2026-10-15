<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_gas extends CI_Model{
    
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
              SELECT TOP $limit u_rek.rekanan_id, u_rek.rekananshipping_line, u_rek.rekananutilitiesgas_reg, 
                u_rek.rekananutilitiesgas_mfaktor, u_rek.rekananutilitiesgas_pressure, u_rek.rekananutilitiesgas_phmeter,
                u_rek.rekananutilitiesgas_tarif, u_rek.rekananutilitiesgas_admpercent,
                h_rek.rekanan_name, s_rek.rekananshipping_name, s_rek.branch_id,
                ROW_NUMBER() OVER (ORDER BY h_rek.rekanan_name asc) as RowNumber            
              FROM master_rekananutilitiesgas AS u_rek 
                inner join master_rekananshipping AS s_rek 
                  ON u_rek.rekanan_id = s_rek.rekanan_id AND u_rek.rekananshipping_line = s_rek.rekananshipping_line
                inner join master_rekanan AS h_rek ON h_rek.rekanan_id = u_rek.rekanan_id              
          $sWhere )
      SELECT CTE.*
      FROM CTE      
      WHERE RowNumber > $top";      
     return $this->db->query($qry)->result_array();    
   }
   
   function qry_filterreg($sWhere){
     $qry="SELECT COUNT(u_rek.rekananutilitiesgas_reg) as jml           
           FROM master_rekananutilitiesgas AS u_rek 
              inner join master_rekananshipping AS s_rek 
                ON u_rek.rekanan_id = s_rek.rekanan_id AND u_rek.rekananshipping_line = s_rek.rekananshipping_line
              inner join master_rekanan AS h_rek ON h_rek.rekanan_id = u_rek.rekanan_id              
            $sWhere";
    return $this->db->query($qry)->row_array();
     
   }
   
   function qry_totalreg(){
     $qry="SELECT COUNT(u_rek.rekananutilitiesgas_reg) as jml
           FROM master_rekananutilitiesgas AS u_rek 
             inner join master_rekananshipping AS s_rek 
               ON u_rek.rekanan_id = s_rek.rekanan_id AND u_rek.rekananshipping_line = s_rek.rekananshipping_line
             inner join master_rekanan AS h_rek ON h_rek.rekanan_id = u_rek.rekanan_id";
    return $this->db->query($qry)->row_array();
     
   }  
   
    function qry_alldatalist($limit,$top,$sWhere){
	   // echo var_dump($sWhere);
      $sWhere = empty($sWhere) ? " WHERE CTE.utilitiesairgas_type = 'UG' " : $sWhere." AND CTE.utilitiesairgas_type = 'UG' "; 
  	  $qry=" 
        SELECT * FROM (
          SELECT top $limit CTE.utilitiesairgas_id, CTE.utilitiesairgas_descr, CTE.utilitiesairgas_date, 
            CTE.utilitiesairgas_isposted, CTE.utilitiesairgas_createby, utilitiesairgas_createdate,
            ROW_NUMBER() OVER (ORDER BY CTE.utilitiesairgas_id desc) as RowNumber,
            REGION.region_name, BRANCH.branch_name, STRU.strukturunit_name
          FROM transaksi_utilitiesairgas AS CTE
            JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
            JOIN master_strukturunit AS STRU ON CTE.strukturunit_id = STRU.strukturunit_id      
          $sWhere
        ) AS V
        WHERE   RowNumber > $top";
	    return $this->db->query($qry)->result_array();
   }
   
    function qry_filteredlist($sWhere){
      
      $sWhere = empty($sWhere) ? " WHERE CTE.utilitiesairgas_type = 'UG' " : $sWhere." AND CTE.utilitiesairgas_type = 'UG' "; 
	    $qry="
        SELECT COUNT(*) as jml FROM (
  			  SELECT CTE.utilitiesairgas_id
  			  FROM transaksi_utilitiesairgas AS CTE       
            JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
            JOIN master_strukturunit AS STRU ON CTE.strukturunit_id = STRU.strukturunit_id
  			  $sWhere
  			) AS V";

		  return $this->db->query($qry)->row_array();	   
    }
   
    function qry_totalalllist(){
	   
        $qry="SELECT COUNT(utilitiesairgas_id) AS jml FROM transaksi_utilitiesairgas WHERE utilitiesairgas_type = 'UG' ";
		  return $this->db->query($qry)->row_array();	   
    }
   
    function insertgas($_id, $_channel, $_date, $branch_id, $region_id, $strukturunit_id, $_transaksi,
          $_descr, $_createby, $_createdate, $_modifyby, $_modifydate, $dposted, $dline,
          $dtenant_id, $dbrand_line, $ddescr, $dreg, $dagreement, $dstandawal, $dstandakhir,
          $dpemakaian, $dmfactor, $dpressure, $dconversion, $dmassalpg, $dtarif, $djumlah,
          $dphmeter, $dmaterai, $ddenda, $dsubtotal, $dadministrasi, $dtotal, $dtax, $dpemakaianlalu, $dpemakaianavg)
    {        

        $timestamp = time();		
        $now = date("Y-m-d H:i:s", $timestamp);        

        $this->db->trans_begin();

        $sp_insertH = "EXEC [lm03_TrnUtilitiesairgas_Insert] '', '$_date', '$_descr', 0, 'UG', '', '$_createby', '$now', '', '$now',  
            '$region_id', '$branch_id', '$strukturunit_id', '$_transaksi', '$_channel', ''";        
        $result = $this->db->query($sp_insertH)->row_array();
        $_id = $result['utilitiesairgas_id'];

        foreach($dline as $key => $n){          

          $d_line               = $dline[$key];
          $d_descr              = $ddescr[$key];
          $d_tenant_id          = $dtenant_id[$key];
          $d_brand_line         = $dbrand_line[$key];
          $d_reg                = str_replace("'", "''", $dreg[$key]);
          $d_agreement          = $dagreement[$key];
          $d_standawal          = str_replace(',', '', $dstandawal[$key]);
          $d_standakhir         = str_replace(',', '', $dstandakhir[$key]);
          $d_pemakaian          = str_replace(',', '', $dpemakaian[$key]);
          $d_mfactor            = str_replace(',', '', $dmfactor[$key]);
          $d_pressure           = str_replace(',', '', $dpressure[$key]);
          $d_conversion         = str_replace(',', '', $dconversion[$key]);
          $d_massalpg           = str_replace(',', '', $dmassalpg[$key]);
          $d_tarif              = str_replace(',', '', $dtarif[$key]);
          $d_jumlah             = str_replace(',', '', $djumlah[$key]);
          $d_phmeter            = str_replace(',', '', $dphmeter[$key]);
          $d_materai            = empty($dmaterai[$key]) ? 0 : str_replace(',', '', $dmaterai[$key]);
          $d_denda              = empty($ddenda[$key]) ? 0 : str_replace(',', '', $ddenda[$key]);
          $d_subtotal           = str_replace(',', '', $dsubtotal[$key]);
          $d_administrasi       = str_replace(',', '', $dadministrasi[$key]);
          $d_total              = str_replace(',', '', $dtotal[$key]);
          $d_tax                = str_replace(',', '', $dtax[$key]);
          $d_pemakaianlalu      = str_replace(',', '', $dpemakaianlalu[$key]);
          $d_pemakaianavg       = str_replace(',', '', $dpemakaianavg[$key]);

          $sp_InsertD = "EXEC [lm03_TrnUtilitiesairgasdetil_Insert] '$_id', $d_line, '$d_descr', '$d_tenant_id', $d_brand_line,
            '$d_reg', '', '$d_agreement', 0, '', $d_standawal, $d_standakhir, $d_pemakaian, 0, $d_tarif, $d_jumlah, 0, 0, 0, 0, 0, 0,
            0, 0, 0, 0, $d_mfactor, $d_pressure, $d_conversion, $d_massalpg, 0, 0, $d_administrasi, 0, $d_phmeter, $d_materai, 
            $d_denda, $d_subtotal, $d_total, $d_tax, '', $d_pemakaianlalu, $d_pemakaianavg ";
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
		    
	  function updategas($_id, $_channel, $_date, $branch_id, $region_id, $strukturunit_id, $_transaksi,
          $_descr, $_createby, $_createdate, $_modifyby, $_modifydate, $dposted, $dline,
          $dtenant_id, $dbrand_line, $ddescr, $dreg, $dagreement, $dstandawal, $dstandakhir,
          $dpemakaian, $dmfactor, $dpressure, $dconversion, $dmassalpg, $dtarif, $djumlah,
          $dphmeter, $dmaterai, $ddenda, $dsubtotal, $dadministrasi, $dtotal, $dtax, $dstate, $deleted, $dpemakaianlalu, $dpemakaianavg)
    {           

        $timestamp = time();    
        $now = date("Y-m-d H:i:s", $timestamp);        

        $this->db->trans_begin();

        $sp_updateH = "EXEC [lm03_TrnUtilitiesairgas_Update] '{$_id}', '$_date', '$_descr', 0, 'UG', '', '$_createby', '$_createdate', 
            '$_modifyby', '$now', '$region_id', '$branch_id', '$strukturunit_id', '$_transaksi', '$_channel', '' ";
        $this->db->query($sp_updateH);
        
        if (is_array($deleted)){
          if (count($deleted) >0){
            foreach($deleted as $key => $_line){                
                $this->db->query("
                  DELETE FROM transaksi_utilitiesairgasdetil 
                  WHERE utilitiesairgas_id='{$_id}' AND utilitiesairgasdetil_line = {$_line} ");                       
            }
          }
        }                

        foreach($dline as $key => $n){                    

          $d_line               = $dline[$key];
          $d_posted             = $dposted[$key];
          $d_descr              = $ddescr[$key];
          $d_tenant_id          = $dtenant_id[$key];
          $d_brand_line         = $dbrand_line[$key];
          $d_reg                = str_replace("'", "''", $dreg[$key]);
          $d_agreement          = $dagreement[$key];
          $d_standawal          = str_replace(',', '', $dstandawal[$key]);
          $d_standakhir         = str_replace(',', '', $dstandakhir[$key]);
          $d_pemakaian          = str_replace(',', '', $dpemakaian[$key]);
          $d_mfactor            = str_replace(',', '', $dmfactor[$key]);
          $d_pressure           = str_replace(',', '', $dpressure[$key]);
          $d_conversion         = str_replace(',', '', $dconversion[$key]);
          $d_massalpg           = str_replace(',', '', $dmassalpg[$key]);
          $d_tarif              = str_replace(',', '', $dtarif[$key]);
          $d_jumlah             = str_replace(',', '', $djumlah[$key]);
          $d_phmeter            = str_replace(',', '', $dphmeter[$key]);
          $d_materai            = empty($dmaterai[$key]) ? 0 : str_replace(',', '', $dmaterai[$key]);
          $d_denda              = empty($ddenda[$key]) ? 0 : str_replace(',', '', $ddenda[$key]);
          $d_subtotal           = str_replace(',', '', $dsubtotal[$key]);
          $d_administrasi       = str_replace(',', '', $dadministrasi[$key]);
          $d_total              = str_replace(',', '', $dtotal[$key]);
          $d_tax                = str_replace(',', '', $dtax[$key]);
          $d_state              = $dstate[$key];
          $d_pemakaianlalu      = str_replace(',', '', $dpemakaianlalu[$key]);
          $d_pemakaianavg       = str_replace(',', '', $dpemakaianavg[$key]);      


if ($d_total==""){
	$d_total=0;
}
if ($d_administrasi==""){
	$d_administrasi=0;
}

          if ( !$d_posted ) { 

            if ($d_state == "update") {                    
                $sp_UpdateD = "EXEC [lm03_TrnUtilitiesairgasdetil_Update] '$_id', $d_line, '$d_descr', '$d_tenant_id', $d_brand_line,
                  '$d_reg', '', '$d_agreement', 0, '', $d_standawal, $d_standakhir, $d_pemakaian, 0, $d_tarif, $d_jumlah, 0, 0, 0, 0, 0, 0,
                  0, 0, 0, 0, $d_mfactor, $d_pressure, $d_conversion, $d_massalpg, 0, 0, $d_administrasi, 0, $d_phmeter, $d_materai, 
                  $d_denda, $d_subtotal, $d_total, $d_tax, '', $d_pemakaianlalu, $d_pemakaianavg";
                $this->db->query($sp_UpdateD);
            } else{                
                $sp_InsertD = "EXEC [lm03_TrnUtilitiesairgasdetil_Insert] '$_id', $d_line, '$d_descr', '$d_tenant_id', $d_brand_line,
                  '$d_reg', '', '$d_agreement', 0, '', $d_standawal, $d_standakhir, $d_pemakaian, 0, $d_tarif, $d_jumlah, 0, 0, 0, 0, 0, 0,
                  0, 0, 0, 0, $d_mfactor, $d_pressure, $d_conversion, $d_massalpg, 0, 0, $d_administrasi, 0, $d_phmeter, $d_materai, 
                  $d_denda, $d_subtotal, $d_total, $d_tax, '', $d_pemakaianlalu, $d_pemakaianavg";
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
	
	function deletegas($_id){    
   
		$this->db->query("delete from transaksi_utilitiesairgas where utilitiesairgas_id='$_id'");
		$this->db->query("delete from transaksi_utilitiesairgasdetil where utilitiesairgas_id='$_id'");
    //$this->db->query("delete from transaksi_loounit where loo_id='$loo_id'");
	}
    
  function viewgas($_id, $_date ='', $_region='', $_branch=''){     

     if (!empty($_id)){
        return $this->db->query("
           SELECT UG.utilitiesairgas_id, convert(varchar(10),utilitiesairgas_date,120) AS utilitiesairgas_date, 
              utilitiesairgas_descr, utilitiesairgas_isposted, utilitiesairgas_createby, utilitiesairgas_createdate,
              utilitiesairgas_modifyby, utilitiesairgas_modifydate, TRS.transaksi_name,
              UG.region_id, UG.branch_id, UG.strukturunit_id, UG.transaksi_id, UG.channel_id,
              BRA.branch_name, REG.region_name
           FROM transaksi_utilitiesairgas AS UG
              LEFT JOIN master_transaksi TRS ON TRS.transaksi_id = UG.transaksi_id
              LEFT JOIN master_branch AS BRA ON UG.branch_id = BRA.branch_id
              LEFT JOIN master_region AS REG ON UG.region_id = REG.region_id
           WHERE UG.utilitiesairgas_id='$_id'
       ")->result();        
     }else{         
       $timestamp = time();
      
       $now = date("Y-m-d", $timestamp);  

       $result[] = (object) array(                        
                        'utilitiesairgas_id'           =>'auto',
                        'utilitiesairgas_date'         => $_date,
                        'utilitiesairgas_descr'        => '',
                        'utilitiesairgas_createby'     => '',
                        'utilitiesairgas_createdate'   => $now,
                        'utilitiesairgas_modifyby'     => '',
                        'utilitiesairgas_modifydate'   => $now,
                        'region_id'                     => $_region,
                        'region_name'                   => '',
                        'branch_id'                     => $_branch,
                        'branch_name'                   => '',
                        'strukturunit_id'               => '0',
                        'strukturunit_name'             => '',
                        'transaksi_id'                  => '100930',
                        'transaksi_name'                => 'Pencatatan Utilities',
                        'channel_id'                    => $this->session->userdata('channel_id')
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


  function getgasdetil($_id, $_date ='', $_region='', $_branch=''){    
  
    if (!empty($_id)){      

        $sql = "
          SELECT UGD.rekanan_id, REK.rekanan_name, UGD.rekananshipping_line, SHP.rekananshipping_name, 
            UGD.utilitiesairgasdetil_reg AS rekananutilitiesgas_reg,
            UGD.utilitiesairgasdetil_unit AS rekananutilitiesgas_unit,
            UGD.utilitiesairgasdetil_multiplefactor AS rekananutilitiesgas_mfaktor,
            UGD.utilitiesairgasdetil_pressure AS rekananutilitiesgas_pressure,
            UGD.utilitiesairgasdetil_standawal,
            UGD.utilitiesairgasdetil_standakhir,
            UGD.agreement_id,
            UGD.utilitiesairgasdetil_deduct,
            utilitiesairgasdetil_adm,
            UGD.utilitiesairgasdetil_phmeter AS rekananutilitiesgas_phmeter,
            utilitiesairgasdetil_materai,
            utilitiesairgasdetil_denda,
            UGD.utilitiesairgasdetil_tax AS rekananshipping_tax,
            utilitiesairgasdetil_conversionfactor,utilitiesairgasdetil_massalpg, utilitiesairgasdetil_spec1tarif AS utilitiesairgasdetil_harga,
            utilitiesairgasdetil_spec1amount, utilitiesairgasdetil_subtotal, utilitiesairgasdetil_total,
            utilitiesairgasdetil_pemakaian, utilitiesairgasdetil_line, utilitiesairgasdetil_isposted, utilitiesairgasdetil_descr,
            utilitiesairgasdetil_pemakaianlalu, utilitiesairgasdetil_pemakaianavg, utilitiesairgasdetil_link
          FROM transaksi_utilitiesairgasdetil UGD
            LEFT JOIN master_rekanan REK ON REK.rekanan_id = UGD.rekanan_id
            LEFT JOIN master_rekananshipping SHP ON SHP.rekanan_id = UGD.rekanan_id AND SHP.rekananshipping_line = UGD.rekananshipping_line
          WHERE UGD.utilitiesairgas_id = '$_id'
          ORDER BY  utilitiesairgas_id, utilitiesairgasdetil_line ASC";  
        return $this->db->query($sql)->result();  

    }else{       

        $sp = "EXEC [lm03_TrnUtilitiesG4S_SelectTenant] '{$_date}', '{$_region}', '{$_branch}' ";
        $result = $this->db->query($sp);

        //print_r($sp);
        return $result->result();              
    }

  } 

  function getTenantbyid($_date, $_region, $_branch, $_tenant, $_brand){    
        
        $sp = "EXEC [lm03_TrnUtilitiesG4S_SelectTenantbyid] '{$_date}', '{$_region}', '{$_branch}', '{$_tenant}', '{$_brand}'";
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

  function RecalculateGas($_id){    
  
      if (!empty($_id)){                

          $sp = "EXEC lm03_TrnUtilitiesGas_RefreshValue '$_id', '' ";
          $this->db->query($sp);          
          //return $result->result();     
      }
  } 

  function CekTransaction($_date, $_region, $_branch){

      $query = "EXEC [lm03_TrnUtilitiesGas_CekTransaction] '{$_date}', 'branch_id = ''{$_branch}'' and region_id = ''{$_region}'''";      

      $result = $this->db->query($query)->row_array();
      $_id = $result['utilitiesairgas_id'];

    return $_id;
  } 

  function updateLink($_id, $_line, $_name){
      
    $this->db->query("UPDATE transaksi_utilitiesairgasdetil 
                      SET utilitiesairgasdetil_link = '{$_name}' 
                      WHERE utilitiesairgas_id='{$_id}' AND utilitiesairgasdetil_line = $_line");    
  }
    
}
