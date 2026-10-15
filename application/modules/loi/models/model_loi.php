<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_loi extends CI_Model{
    
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
          select top $limit SHIP.rekanan_id, SHIP.rekananshipping_line, SHIP.rekananshipping_name, REKA.rekanan_name,
            ROW_NUMBER() OVER (ORDER BY REKA.rekanan_name asc) as RowNumber 
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

   function qry_alldataschema($limit,$top,$sWhere){
     $qry="WITH CTE AS (
        select top $limit *,ROW_NUMBER() OVER (ORDER BY skl_id asc) as RowNumber 
        from master_skl $sWhere)
    SELECT CTE.*, UTYPE.unittype_name
    FROM CTE 
      JOIN master_unittype AS UTYPE ON CTE.unittype_id = UTYPE.unittype_id
    WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();    
   }
   
   function qry_filteredschema($sWhere){
     $qry="select count(skl_id) as jml from master_skl $sWhere";
    return $this->db->query($qry)->row_array();
     
   }
   
   function qry_totalallschema(){
     $qry="select count(skl_id) as jml from master_skl";
    return $this->db->query($qry)->row_array();
     
   }
   
    function qry_alldatalist($limit,$top,$sWhere){
	//echo var_dump($sWhere);
	
    $sWhere = empty($sWhere) ? " WHERE isdisabled = 0 " : $sWhere." AND isdisabled = 0 ";

	   $qry=" 
			SELECT * FROM (
			select top $limit ROW_NUMBER() OVER (ORDER BY agreement_id desc) as RowNumber,
			agreement_id, 
			tanggal, 
			number,
			toko,rekanan_name, unit,branch_area,kepada,alamat
			  FROM transaksi_agreement_printLOI       
			  $sWhere 
			  ORDER BY agreement_id
			  ) AS V
    	WHERE   RowNumber > $top";
	  
	   //echo $qry;
	   //exit;
	    return $this->db->query($qry)->result_array();
   }
   
    function qry_filteredlist($sWhere){
       $sWhere = empty($sWhere) ? " WHERE isdisabled = 0 " : $sWhere." AND isdisabled = 0 ";
	   $qry="SELECT count(*) as jml FROM (
			select CTE.*,ROW_NUMBER() OVER (ORDER BY agreement_id desc) as RowNumber 
			  FROM transaksi_agreement_printLOI AS CTE       			  
			  $sWhere 
			 
			  ) AS V";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalllist(){
	   $qry="select count(agreement_id) as jml from transaksi_agreement_printLOI where isdisabled = 0";
		return $this->db->query($qry)->row_array();
	   
   }
   
    function insertloo($loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, $lease,
        $loo_line,$unit_id,$agrtype_id,$loo_baserent, $r_id, $tenant, $brand, $int, $timetype, $loo_descr, $unit_type, $skl_id, $descr,
        $isper, $percent, $u_line, $u_unit, $u_size, $u_lantai, $d_region, $d_branch, $d_tenant, $d_brand, 
        $u_region, $u_branch, $u_tenant, $u_brand, $product_name,$fitting_out,$grace_period,$size_indoor,$size_outdoor )
    {


        $datetime1 = date_create($loo_sdate);
        $datetime2 = date_create($loo_edate);
		$datetime2->modify('+1 day');
        $interval = date_diff($datetime1, $datetime2);
		

        $loo_term = $interval->m + ($interval->y * 12);

        $timestamp = time();		   

        $loo_id = gen_id_loo($region,'LOO','sequencer_loo', $r_id, $timestamp);

        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     
        $check = $this->db->query("
                 insert into transaksi_loo
                     (loo_id, loo_date, loo_sdate, loo_edate, loo_term, _createby, _createdate,  region_id , branch_id, rekanan_id, rekananshipping_line, loo_type, loo_descr, skl_id, unittype_id, product_name,fitting_out,grace_period,size_indoor,size_outdoor )
                 values
                     ('$loo_id','$loo_date', '$loo_sdate', '$loo_edate', $loo_term,'$_createby','$now','$region','$branch',
                      '$tenant', '$brand', '$lease', '$loo_descr','$skl_id', '$unit_type', '$product_name',$fitting_out,$grace_period,$size_indoor,$size_outdoor )");     
			
  			foreach($loo_line as $key => $n){

  				$t_line       = $loo_line[$key];
  				$t_unit       = $unit_id[$key];
  				$t_agrtype    = $agrtype_id[$key];
  				$t_baserent   = $loo_baserent[$key];
          $t_baserent   = str_replace(',', '',$t_baserent);
          $t_int        = $int[$key];
          $t_timet      = $timetype[$key];
          $t_descr      = $descr[$key];
          $t_isper      = ($isper[$key]) ? 1 : 0;
          $t_percent    = $percent[$key];
          $t_region     = $d_region[$key];
          $t_branch     = $d_branch[$key];
          $t_tenant     = $d_tenant[$key];
          $t_brand      = $d_brand[$key];

        	$this->db->query("
             insert into transaksi_loodetil
                 (loo_id, loodetil_line, loodetil_baserent, agreementtype_id, unit_id, loodetil_int, timetype_id, loodetil_descr, loodetil_ispercent, loodetil_percent, region_id, branch_id, rekanan_id, rekananshipping_line,loodetil_sdate,loodetil_edate,loodetil_term)
             values
                 ('$loo_id', $t_line, $t_baserent, '$t_agrtype', '$t_unit', $t_int, '$t_timet', '$t_descr', $t_isper, 
                  $t_percent, '$t_region', '$t_branch','$tenant', '$brand', '$loo_sdate', '$loo_edate', $loo_term )");
        }

        foreach($u_line as $key => $n){

          $_line       = $u_line[$key];
          $_unit       = $u_unit[$key];
          $_size       = $u_size[$key];
          $_lantai     = $u_lantai[$key];
          $_region     = $u_region[$key];
          $_branch     = $u_branch[$key];
          $_tenant     = $u_tenant[$key];
          $_brand      = $u_brand[$key];

          $this->db->query("
                insert into transaksi_loounit
                    ( loo_id, loounit_line, loounit_space, unit_id, lantai_id, region_id, branch_id, rekanan_id, rekananshipping_line, loounit_sdate, loounit_edate, loounit_term )
                values
                  ( '$loo_id', $_line, $_size, '$_unit', '$_lantai', '$_region', '$_branch', '$tenant', '$brand', '$loo_sdate', '$loo_edate', $loo_term  )");          

          $this->db->query(" UPDATE master_unit SET unit_state = 1 WHERE unit_id='$t_unit' and region_id='$region' and branch_id='$branch' "); 
  			}
			
			return $loo_id;
			  
    }

  function sholdetilby_id($id){          
        $sql = "
          SELECT LD.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name
          FROM transaksi_loodetil LD
            JOIN transaksi_loo LH ON LH.loo_id = LD.loo_id 
            JOIN master_unit UNIT ON UNIT.unit_id = LD.unit_id AND UNIT.region_id = LH.region_id AND UNIT.branch_id = LH.branch_id
            JOIN master_agreementtype AT ON AT.agreementtype_id = LD.agreementtype_id
          WHERE LD.loo_id = '$id'
          ORDER BY  loo_id, loodetil_line ASC";  
    return $this->db->query($sql)->result();      
  }

  function vdetilunitby_id($id){          
        $sql = "
          SELECT LU.*, UNIT.unit_name AS unit_name, LT.lantai_name AS lantai_name
          FROM transaksi_loounit LU 
            JOIN transaksi_loo LH ON LH.loo_id = LU.loo_id
            JOIN master_unit UNIT ON UNIT.unit_id = LU.unit_id AND UNIT.region_id = LH.region_id AND UNIT.branch_id = LH.branch_id
            JOIN master_lantai LT ON LT.lantai_id = LU.lantai_id
          WHERE LU.loo_id = '$id'";  
    return $this->db->query($sql)->result();      
  }
		    
	function updateloi($agreement_id, $kepada, $alamat, $mobile, $email, $lantai, $dagangan, $Utilities,$biaya_listrik,$biaya_service,$jml_deposit,$deposit_value,$angsuran_deposit,$angsuran_deposit1,$telp_deposit,$telp_service){        

        //$datetime1 = date_create($loo_sdate);
       // $datetime2 = date_create($loo_edate);		
		//$datetime2->modify('+1 day');


       // $interval = date_diff($datetime1, $datetime2);
       // $loo_term = $interval->m + ($interval->y * 12);
  		$timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     
        $check=$this->db->query("
            update transaksi_agreement_printLOI
            set kepada = '$kepada', alamat = '$alamat', mobile = '$mobile', email = '$email', lantai = '$lantai',
                dagangan = '$dagangan', Utilities = '$Utilities', biaya_listrik = $biaya_listrik, biaya_service = $biaya_service,  jml_deposit=$jml_deposit, deposit_value= $deposit_value, angsuran_deposit = $angsuran_deposit, angsuran_deposit1 = $angsuran_deposit1, telp_deposit=$telp_deposit, telp_service=$telp_service 
            where agreement_id = '$agreement_id'
        ");	            
          
        }                  
  
	
	function deleteloo($loo_id){
    
    $this->db->query(" UPDATE transaksi_loo SET isdisabled = '1' WHERE loo_id = '$loo_id' ");

    $u_sql = "
              SELECT DISTINCT b.region_id, b.branch_id, a.unit_id 
              FROM transaksi_loodetil AS A inner join transaksi_loo AS B ON A.loo_id = B.loo_id
              WHERE A.loo_id = '$loo_id' ";

    $q_uid = $this->db->query($u_sql)->result_array();

    foreach($q_uid as $uid){

      $unit_id = $uid['unit_id'];
	  $region_id=$uid['region_id'];
	  $branch_id=$uid['branch_id'];
      $this->db->query("UPDATE master_unit SET unit_state = 2 WHERE unit_id='$unit_id' AND region_id = '$region_id' AND branch_id = '$branch_id'");

    } 
		//$this->db->query("delete from transaksi_loo where loo_id='$loo_id'");
		//$this->db->query("delete from transaksi_loodetil where loo_id='$loo_id'");
    //$this->db->query("delete from transaksi_loounit where loo_id='$loo_id'");
	}
    
  function viewloi($loo_id){     

     if (isset($loo_id)){
        return $this->db->query("select agreement_id,tanggal,number,kepada,alamat,mobile,email,toko,branch_area,lantai,unit,luas,luas_terbilang,jangka,jangka_terbilang,convert(varchar(10),startdate,120) as startdate, convert(varchar(10),enddate,120) as enddate,dagangan,
fitting_out,grace_periode,uang_sewa,total_sewa,jml_instalment,DP_percent,DP_value,sisa_jangka,sisa_total_sewa,sisa_percent,biaya_food_levy,CONVERT(DECIMAL(18,0),isnull(biaya_service,0)) as biaya_service,CONVERT(DECIMAL(18,0),isnull(jml_deposit,0)) as jml_deposit,CONVERT(DECIMAL(18,0),isnull(deposit_value,0)) as deposit_value,
angsuran1,angsuran2,angsuran3,angsuran4,CONVERT(DECIMAL(18,0),isnull(telp_deposit,0)) as telp_deposit,CONVERT(DECIMAL(18,0),isnull(telp_service,0)) as telp_service,region_namereport,Print_LOI_Position1,Print_LOI_Position1_name,Print_LOI_Position2,
Print_LOI_Position2_name,TimeType,jml_DP,angsuran_DP,CONVERT(DECIMAL(18,0),isnull(angsuran_deposit,0)) as angsuran_deposit,CONVERT(DECIMAL(18,0),isnull(angsuran_deposit1,0)) as angsuran_deposit1,angsuran_deposit2,
angsuran_deposit3,region_address,detil_startdate,detil_enddate,agreementype_id,space,baserent,installment,term,subtotal,detil_startdate1,detil_enddate1,agreementype_id1,space1,baserent1,
installment1,term1,subtotal1,detil_startdate2,detil_enddate2,agreementype_id2,space2,baserent2,installment2,term2,subtotal2,rekanan_pt,
branch_namereport,listrik,listrik_total,Utilities,is_Listrik,is_air,is_gas,jml_hari,jml_bulan,jml_tahun,isdisabled,
rekanan_name,size_indoor,size_outdoor,isposted, CONVERT(DECIMAL(18,0),isnull(biaya_listrik,0)) as biaya_listrik  from 		 transaksi_agreement_printLOI
          where agreement_id='$loo_id' and isposted ='1'
       ")->result();        
     }else{         
       $timestamp = time();
      
       $now = date("Y-m-d", $timestamp);  

       $result[] = (object) array(                        
                        'loo_id'          =>'auto',
                        'loo_date'        => $now,
                        'loo_sdate'       => $now,
                        'loo_edate'        => $now,
                        'loo_term'       => 0,
                        'region_id'       => '',
                        'branch_id'       => '',
                        'loo_type'       => '',
                        'rekanan_id'       => 0,
                        'rekananshipping_id' => 0,
                        '_createby'       => '',
                        '_createdate'     => $now,
                        '_modifyby'       => '',
                        '_modifydate'     => $now,
                        'product_name'     => '',
                        'fitting_out'     => 0,
                        'grace_period'     => 0,
                        'size_indoor'     => 0,
                        'size_outdoor'     => 0,
       ); 

       return $result;
     }

   }
   
function viewloi2($loo_id){     

     if (isset($loo_id)){
        return $this->db->query("
           select loo_id, convert(varchar(10),loo_date,120) AS loo_date, loo_type, unittype_id, loo_descr, skl_id,
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term, _createby, _createdate, _modifyby, _modifydate, region_id, isapproved, isconfirm,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name,
			  LOO.product_name,LOO.fitting_out,LOO.grace_period ,LOO.size_indoor ,LOO.size_outdoor
           from transaksi_loo AS LOO 
              JOIN master_branch AS BRANCH ON LOO.branch_id = BRANCH.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
          where LOO.loo_id='$loo_id'
       ")->result();        
     }else{         
       $timestamp = time();
      
       $now = date("Y-m-d", $timestamp);  

       $result[] = (object) array(                        
                        'loo_id'          =>'auto',
                        'loo_date'        => $now,
                        'loo_sdate'       => $now,
                        'loo_edate'        => $now,
                        'loo_term'       => 0,
                        'region_id'       => '',
                        'branch_id'       => '',
                        'loo_type'       => '',
                        'rekanan_id'       => 0,
                        'rekananshipping_id' => 0,
                        '_createby'       => '',
                        '_createdate'     => $now,
                        '_modifyby'       => '',
                        '_modifydate'     => $now,
                        'product_name'     => '',
                        'fitting_out'     => 0,
                        'grace_period'     => 0,
                        'size_indoor'     => 0,
                        'size_outdoor'     => 0,
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

            $this->db->trans_begin();

            $this->db->query(" UPDATE transaksi_loo SET isconfirm = '1' WHERE loo_id = '$loo_id' ");

            $u_sql = " SELECT DISTINCT unit_id FROM transaksi_loodetil WHERE loo_id = '$loo_id' ";

            $q_uid = $this->db->query($u_sql)->result_array();

            foreach($q_uid as $uid){

              $unit_id = $uid['unit_id'];
              $this->db->query("UPDATE master_unit SET unit_state = 3 WHERE unit_id = '$unit_id' and region_id = '$region_id' and branch_id = '$branch_id' ");

            }

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

   function approveloo($arrapp){   

    $action = "approve";   

     if (is_array($arrapp)){
       if (count($arrapp) >0){
          foreach ($arrapp as $key){       

            $loo_id = $key[0];
            $region_id = $key[1];
            $branch_id = $key[2];

            $this->db->trans_begin();
          
            $this->db->query(" UPDATE transaksi_loo SET isapproved = '1' WHERE loo_id = '$loo_id' ");

            $u_sql = " SELECT DISTINCT unit_id FROM transaksi_loodetil WHERE loo_id = '$loo_id' ";

            $q_uid = $this->db->query($u_sql)->result_array();

            foreach($q_uid as $uid){

              $unit_id = $uid['unit_id'];
              $this->db->query(" UPDATE master_unit SET unit_state = 2 WHERE unit_id='$unit_id' and region_id = '$region_id' and branch_id = '$branch_id' ");
              
            }            

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

    function dataapp($uid){

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
          WHERE LOH.isapproved = '0' AND UNIT.unit_state <> '2'  AND LOD.unit_id like '%{$uid}%' 
          ORDER BY loo_id desc ";

        return $this->db->query($sql)->result_array();
    }

   function dataapplist($uid){

        $sql = " 
          SELECT DISTINCT LOH.*, 
            REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name,'' as unit_id
          FROM transaksi_loo LOH
            JOIN transaksi_loounit LOU ON LOU.loo_id = LOH.loo_id
            JOIN transaksi_loodetil LOD ON LOH.loo_id = LOD.loo_id
            JOIN master_region AS REGION ON LOU.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOU.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOU.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOU.rekanan_id = BRAND.rekanan_id AND LOU.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOU.region_id AND UNIT.branch_id = LOU.branch_id
          WHERE LOH.isapproved = '0' AND UNIT.unit_state <> '2'  AND LOD.unit_id like '%{$uid}%' 
          ORDER BY loo_id desc ";

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

 function getskema($id){

  $qry= " SELECT A.*, B.agreementtype_name
          FROM master_sklterm A inner join master_agreementtype B ON A.skl_atype = B.agreementtype_id
          WHERE A.skl_id = '{$id}' ";

  return $this->db->query($qry)->result_array();   
 }     
    
}
