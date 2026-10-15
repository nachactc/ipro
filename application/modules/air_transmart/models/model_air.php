<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_air extends CI_Model{
    
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
    
	 function qry_allformula($limit,$top,$sWhere){

     $sWhere = empty($sWhere) ? " WHERE utilitiesairgas_type ='UA' " : $sWhere." AND utilitiesairgas_type = 'UA' ";        
	   $qry="WITH CTE AS (
 				SELECT Top $limit *,ROW_NUMBER() OVER (ORDER BY utilitiesairgas_id asc) as RowNumber 
				from master_utilitiesairgas $sWhere)
    		SELECT CTE.*
        FROM CTE           
        WHERE RowNumber > $top";
    //print_r($qry);
	   return $this->db->query($qry)->result_array();	   
   }
   
   function qry_filteredformula($sWhere){

     $sWhere = empty($sWhere) ? " WHERE utilitiesairgas_type ='UA' " : $sWhere." AND utilitiesairgas_type = 'UA' ";	   
	   $qry="SELECT count(utilitiesairgas_id) as jml from master_utilitiesairgas $sWhere";
		return $this->db->query($qry)->row_array();	   
   }
   
   function qry_totalallformula(){
	   $qry="SELECT count(utilitiesairgas_id) as jml from master_utilitiesairgas ";
		return $this->db->query($qry)->row_array();
	   
   }   

   function qry_allreg($limit,$top,$sWhere){
      $qry="WITH CTE AS (         
                SELECT TOP $limit u_rek.rekanan_id, u_rek.rekananshipping_line, u_rek.rekananutilitiesair_reg, 
                  u_rek.rekananutilitiesair_phmeter, u_rek.rekananutilitiesair_abonemen, u_rek.rekananutilitiesair_admpercent,
                  h_rek.rekanan_name, s_rek.rekananshipping_name, s_rek.branch_id,
                  ROW_NUMBER() OVER (ORDER BY h_rek.rekanan_name asc) as RowNumber            
                FROM master_rekananutilitiesair AS u_rek 
                  inner join master_rekananshipping AS s_rek ON u_rek.rekanan_id = s_rek.rekanan_id AND u_rek.rekananshipping_line = s_rek.rekananshipping_line
                  inner join master_rekanan AS h_rek ON h_rek.rekanan_id = u_rek.rekanan_id                
          $sWhere )
          SELECT CTE.*
          FROM CTE      
          WHERE RowNumber > $top";      
      return $this->db->query($qry)->result_array();    
   }
   
   function qry_filterreg($sWhere){
     $qry="SELECT COUNT(u_rek.rekananutilitiesair_reg) as jml           
           FROM master_rekananutilitiesair AS u_rek 
              inner join master_rekananshipping AS s_rek 
                ON u_rek.rekanan_id = s_rek.rekanan_id AND u_rek.rekananshipping_line = s_rek.rekananshipping_line
              inner join master_rekanan AS h_rek ON h_rek.rekanan_id = u_rek.rekanan_id              
            $sWhere";
    return $this->db->query($qry)->row_array();
     
   }
   
   function qry_totalreg(){
     $qry="SELECT COUNT(u_rek.rekananutilitiesair_reg) as jml
           FROM master_rekananutilitiesair AS u_rek 
             inner join master_rekananshipping AS s_rek 
               ON u_rek.rekanan_id = s_rek.rekanan_id AND u_rek.rekananshipping_line = s_rek.rekananshipping_line
             inner join master_rekanan AS h_rek ON h_rek.rekanan_id = u_rek.rekanan_id";
    return $this->db->query($qry)->row_array();
     
   }  
   
    function qry_alldatalist($limit,$top,$sWhere){
	   // echo var_dump($sWhere);
      $sWhere = empty($sWhere) ? " WHERE CTE.utilitiesairgas_type = 'UA' " : $sWhere." AND CTE.utilitiesairgas_type = 'UA' "; 
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
      
      $sWhere = empty($sWhere) ? " WHERE CTE.utilitiesairgas_type = 'UA' " : $sWhere." AND CTE.utilitiesairgas_type = 'UA' "; 
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
	   
        $qry="SELECT COUNT(utilitiesairgas_id) AS jml FROM transaksi_utilitiesairgas WHERE utilitiesairgas_type = 'UA' ";
		  return $this->db->query($qry)->row_array();	   
    }
   
    function insertair($_id, $_channel, $_date, $branch_id, $region_id, $strukturunit_id, $_transaksi,
          $_descr, $_createby, $_createdate, $_modifyby, $_modifydate, $_calcmethod, $dposted, $dline,
          $dtenant_id, $dbrand_line, $ddescr, $dreg, $dagreement, $dstandawal, $dstandakhir,
          $dpipa, $dpemakaian, $dblok1, $dtarifb1, $dtotalb1, $dblok2, $dtarifb2, $dtotalb2,
          $dblok3, $dtarifb3, $dtotalb3, $dblok4, $dtarifb4, $dtotalb4, $dtotalpakai, $dpelihara,
          $dphairkotor, $dphmeter, $dmaterai, $ddenda, $dsubtotal, $dadministrasi, $dtotal, $dtax, $dpemakaianlalu, $dpemakaianavg)
    {        

        $timestamp = time();    
        $now = date("Y-m-d H:i:s", $timestamp);        

        $this->db->trans_begin();

        $sp_insertH = "EXEC [lm03_TrnUtilitiesairgas_Insert] '', '$_date', '$_descr', 0, 'UA', '$_calcmethod', '$_createby', '$now', '', '$now',  
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
          $d_pipa               = $dpipa[$key];
          $d_pemakaian          = str_replace(',', '', $dpemakaian[$key]);
          $d_blok1              = str_replace(',', '', $dblok1[$key]);
          $d_tarifb1            = str_replace(',', '', $dtarifb1[$key]);
          $d_totalb1            = str_replace(',', '', $dtotalb1[$key]);
          $d_blok2              = str_replace(',', '', $dblok2[$key]);
          $d_tarifb2            = str_replace(',', '', $dtarifb2[$key]);
          $d_totalb2            = str_replace(',', '', $dtotalb2[$key]);
          $d_blok3              = str_replace(',', '', $dblok3[$key]);
          $d_tarifb3            = str_replace(',', '', $dtarifb3[$key]);
          $d_totalb3            = str_replace(',', '', $dtotalb3[$key]);
          $d_blok4              = str_replace(',', '', $dblok4[$key]);
          $d_tarifb4            = str_replace(',', '', $dtarifb4[$key]);
          $d_totalb4            = str_replace(',', '', $dtotalb4[$key]);
          $d_totalpakai         = str_replace(',', '', $dtotalpakai[$key]);
          $d_pelihara           = str_replace(',', '', $dpelihara[$key]);
          $d_phairkotor         = str_replace(',', '', $dphairkotor[$key]);
          $d_phmeter            = str_replace(',', '', $dphmeter[$key]);
          $d_materai            = str_replace(',', '', $dmaterai[$key]);
          $d_denda              = str_replace(',', '', $ddenda[$key]);
          $d_subtotal           = str_replace(',', '', $dsubtotal[$key]);
          $d_administrasi       = str_replace(',', '', $dadministrasi[$key]);
          $d_total              = str_replace(',', '', $dtotal[$key]);
          $d_tax                = str_replace(',', '', $dtax[$key]);
          $d_pemakaianlalu      = str_replace(',', '', $dpemakaianlalu[$key]);
          $d_pemakaianavg       = str_replace(',', '', $dpemakaianavg[$key]);

          $sp_InsertD = "EXEC [lm03_TrnUtilitiesairgasdetil_Insert] '$_id', $d_line, '$d_descr', '$d_tenant_id', $d_brand_line,
            '$d_reg', '', '$d_agreement', 0, '$d_pipa', $d_standawal, $d_standakhir, $d_pemakaian, $d_blok1, $d_tarifb1, $d_totalb1, 
            $d_blok2, $d_tarifb2, $d_totalb2, $d_blok3, $d_tarifb3, $d_totalb3, $d_blok4, $d_tarifb4, $d_totalb4, $d_totalpakai, 
            0, 0, 0, 0, 0, $d_pelihara, $d_administrasi, $d_phairkotor, $d_phmeter, $d_materai, $d_denda, $d_subtotal, $d_total, $d_tax, '',
            $d_pemakaianlalu, $d_pemakaianavg ";
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
		    
	function updateair($_id, $_channel, $_date, $branch_id, $region_id, $strukturunit_id, $_transaksi,
          $_descr, $_createby, $_createdate, $_modifyby, $_modifydate, $_calcmethod, $dposted, $dline,
          $dtenant_id, $dbrand_line, $ddescr, $dreg, $dagreement, $dstandawal, $dstandakhir,
          $dpipa, $dpemakaian, $dblok1, $dtarifb1, $dtotalb1, $dblok2, $dtarifb2, $dtotalb2,
          $dblok3, $dtarifb3, $dtotalb3, $dblok4, $dtarifb4, $dtotalb4, $dtotalpakai, $dpelihara,
          $dphairkotor, $dphmeter, $dmaterai, $ddenda, $dsubtotal, $dadministrasi, $dtotal, $dtax, $dstate, $deleted, $dpemakaianlalu, $dpemakaianavg)
    {                

        $timestamp = time();    
        $now = date("Y-m-d H:i:s", $timestamp);        

        $this->db->trans_begin();

        $sp_updateH = "EXEC [lm03_TrnUtilitiesairgas_Update] '{$_id}', '$_date', '$_descr', 0, 'UA', '$_calcmethod', '$_createby', '$_createdate', 
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
          $d_pipa               = $dpipa[$key];
          $d_pemakaian          = str_replace(',', '', $dpemakaian[$key]);
          $d_blok1              = str_replace(',', '', $dblok1[$key]);
          $d_tarifb1            = str_replace(',', '', $dtarifb1[$key]);
          $d_totalb1            = str_replace(',', '', $dtotalb1[$key]);
          $d_blok2              = str_replace(',', '', $dblok2[$key]);
          $d_tarifb2            = str_replace(',', '', $dtarifb2[$key]);
          $d_totalb2            = str_replace(',', '', $dtotalb2[$key]);
          $d_blok3              = str_replace(',', '', $dblok3[$key]);
          $d_tarifb3            = str_replace(',', '', $dtarifb3[$key]);
          $d_totalb3            = str_replace(',', '', $dtotalb3[$key]);
          $d_blok4              = str_replace(',', '', $dblok4[$key]);
          $d_tarifb4            = str_replace(',', '', $dtarifb4[$key]);
          $d_totalb4            = str_replace(',', '', $dtotalb4[$key]);
          $d_totalpakai         = str_replace(',', '', $dtotalpakai[$key]);
          $d_pelihara           = str_replace(',', '', $dpelihara[$key]);
          $d_phairkotor         = str_replace(',', '', $dphairkotor[$key]);
          $d_phmeter            = str_replace(',', '', $dphmeter[$key]);
          $d_materai            = str_replace(',', '', $dmaterai[$key]);
          $d_denda              = str_replace(',', '', $ddenda[$key]);
          $d_subtotal           = str_replace(',', '', $dsubtotal[$key]);
          $d_administrasi       = str_replace(',', '', $dadministrasi[$key]);
          $d_total              = str_replace(',', '', $dtotal[$key]);
          $d_tax                = str_replace(',', '', $dtax[$key]);
          $d_state              = $dstate[$key];      
          $d_pemakaianlalu      = str_replace(',', '', $dpemakaianlalu[$key]);
          $d_pemakaianavg       = str_replace(',', '', $dpemakaianavg[$key]);


          if ( !$d_posted ) { 

            if ($d_state == "update") {                    
                $sp_UpdateD = "EXEC [lm03_TrnUtilitiesairgasdetil_Update] '$_id', $d_line, '$d_descr', '$d_tenant_id', $d_brand_line,
                  '$d_reg', '', '$d_agreement', 0, '$d_pipa', $d_standawal, $d_standakhir, $d_pemakaian, $d_blok1, $d_tarifb1, $d_totalb1, 
                  $d_blok2, $d_tarifb2, $d_totalb2, $d_blok3, $d_tarifb3, $d_totalb3, $d_blok4, $d_tarifb4, $d_totalb4, $d_totalpakai, 
                  0, 0, 0, 0, 0, $d_pelihara, $d_administrasi, $d_phairkotor, $d_phmeter, $d_materai, $d_denda, $d_subtotal, $d_total, $d_tax, '',
                  $d_pemakaianlalu, $d_pemakaianavg";
                $this->db->query($sp_UpdateD);
            } else{                
                $sp_InsertD = "EXEC [lm03_TrnUtilitiesairgasdetil_Insert] '$_id', $d_line, '$d_descr', '$d_tenant_id', $d_brand_line,
                  '$d_reg', '', '$d_agreement', 0, '$d_pipa', $d_standawal, $d_standakhir, $d_pemakaian, $d_blok1, $d_tarifb1, $d_totalb1, 
                  $d_blok2, $d_tarifb2, $d_totalb2, $d_blok3, $d_tarifb3, $d_totalb3, $d_blok4, $d_tarifb4, $d_totalb4, $d_totalpakai, 
                  0, 0, 0, 0, 0, $d_pelihara, $d_administrasi, $d_phairkotor, $d_phmeter, $d_materai, $d_denda, $d_subtotal, $d_total, $d_tax, '',
                  $d_pemakaianlalu, $d_pemakaianavg";
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
	
	function deleteair($_id){    
   
		$this->db->query("delete from transaksi_utilitiesairgas where agreement_id='$_id'");
		$this->db->query("delete from transaksi_utilitiesairgasdetil where agreement_id='$_id'");
    //$this->db->query("delete from transaksi_loounit where loo_id='$loo_id'");
	}
    
  function viewair($_id, $_date ='', $_region='', $_branch='', $_calc){     

     if (!empty($_id)){
        return $this->db->query("
           SELECT UG.utilitiesairgas_id, convert(varchar(10),utilitiesairgas_date,120) AS utilitiesairgas_date, 
              utilitiesairgas_descr, utilitiesairgas_isposted, utilitiesairgas_createby, utilitiesairgas_createdate,
              utilitiesairgas_modifyby, utilitiesairgas_modifydate, TRS.transaksi_name, utilitiesairgas_calcmethodid,
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
                        'channel_id'                    => $this->session->userdata('channel_id'),
                        'utilitiesairgas_calcmethodid'  => $_calc
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


  function getairdetil($_id, $_date ='', $_region='', $_branch='', $_calc){    
  
    if (!empty($_id)){      

        $sql = "
          SELECT UAD.rekanan_id, REK.rekanan_name, UAD.rekananshipping_line, SHP.rekananshipping_name, 
            UAD.utilitiesairgasdetil_reg,
            UAD.utilitiesairgasdetil_unit AS rekananutilitiesgas_unit,
            UAD.utilitiesairgasdetil_multiplefactor AS rekananutilitiesgas_mfaktor,
            UAD.utilitiesairgasdetil_pressure AS rekananutilitiesgas_pressure,
            UAD.utilitiesairgasdetil_unit,
            UAD.utilitiesairgasdetil_standawal,
            UAD.utilitiesairgasdetil_standakhir,
            UAD.agreement_id,            
            UAD.utilitiesairgasdetil_diameterpipa,
            utilitiesairgasdetil_adm,
            UAD.utilitiesairgasdetil_phmeter,
            utilitiesairgasdetil_materai,
            utilitiesairgasdetil_denda,
            UAD.utilitiesairgasdetil_tax AS rekananshipping_tax,
            utilitiesairgasdetil_spec1meter, utilitiesairgasdetil_spec1tarif, utilitiesairgasdetil_spec1amount,
            utilitiesairgasdetil_spec2meter, utilitiesairgasdetil_spec2tarif, utilitiesairgasdetil_spec2amount,
            utilitiesairgasdetil_spec3meter, utilitiesairgasdetil_spec3tarif, utilitiesairgasdetil_spec3amount,
            utilitiesairgasdetil_spec4meter, utilitiesairgasdetil_spec4tarif, utilitiesairgasdetil_spec4amount,     
            utilitiesairgasdetil_specamounttotal, utilitiesairgasdetil_pemeliharaan, utilitiesairgasdetil_phairkotor, 
            utilitiesairgasdetil_subtotal, utilitiesairgasdetil_total,
            utilitiesairgasdetil_pemakaian, utilitiesairgasdetil_line, utilitiesairgasdetil_isposted, 
            utilitiesairgasdetil_descr, utilitiesairgasdetil_pemakaianlalu, utilitiesairgasdetil_pemakaianavg, utilitiesairgasdetil_link
          FROM transaksi_utilitiesairgasdetil UAD
            LEFT JOIN master_rekanan REK ON REK.rekanan_id = UAD.rekanan_id
            LEFT JOIN master_rekananshipping SHP ON SHP.rekanan_id = UAD.rekanan_id AND SHP.rekananshipping_line = UAD.rekananshipping_line
          WHERE UAD.utilitiesairgas_id = '$_id'
          ORDER BY  utilitiesairgas_id, utilitiesairgasdetil_line ASC";  
        return $this->db->query($sql)->result();  

    }else{       

        $sp = "EXEC [lm03_TrnUtilitiesAir_SelectTenant] '{$_date}', '{$_region}', '{$_branch}', '{$_calc}' ";
        $result = $this->db->query($sp);

        //print_r($sp);
        return $result->result();              
    }

  } 

  function getTenantbyid($_date, $_region, $_branch, $_tenant, $_brand, $_calc){    
        
        $sp = "EXEC [lm03_TrnUtilitiesAir_SelectTenantbyid] '{$_date}', '{$_region}', '{$_branch}', '{$_calc}', '{$_tenant}', '{$_brand}'";
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

  function RecalculateAir($_id){    
  
      if (!empty($_id)){                

          $sp = "EXEC lm03_TrnUtilitiesAir_RefreshValue '$_id', '' ";
          $this->db->query($sp);          
          //return $result->result();     
      }
  } 

  function CekTransaction($_date, $_region, $_branch){

      $query = "EXEC [lm03_TrnUtilitiesAir_CekTransaction] '{$_date}', 'branch_id = ''{$_branch}'' and region_id = ''{$_region}'''";      

      $result = $this->db->query($query)->row_array();
      $_id = $result['utilitiesairgas_id'];

    return $_id;
  } 

  function get_CalcMethode($_branch){

      $query = "EXEC [MstUtilitiesairgas_SelectCombobybranch] 'branch_id = ''{$_branch}'' '";      
      
      $result = $this->db->query($query);
        //print_r($sp);
    return $result->result();  
  } 

  function updateLink($_id, $_line, $_name){
      
    $this->db->query("UPDATE transaksi_utilitiesairgasdetil 
                      SET utilitiesairgasdetil_link = '{$_name}' 
                      WHERE utilitiesairgas_id='{$_id}' AND utilitiesairgasdetil_line = $_line");    
  }
    
}
