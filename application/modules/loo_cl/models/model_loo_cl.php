<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_loo_cl extends CI_Model{
    
   function __construct(){
        parent::__construct();
    }
    
   FUNCTION get_agrTypeCasual()
   {
	  $qry="SELECT * FROM master_agreementtype WHERE agreementtype_type in ('UTILITIES TEMP','SERVICE TEMP', 'RENTAL TEMP', 'PS','OTHER','DEPOSIT')"; 
	   return $this->db->query($qry)->result();	
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
     $sWhere = empty($sWhere) ? " WHERE unittype_id = 6 and isdisabled = 0 " : $sWhere." AND isdisabled = 0 and unittype_id = 6 ";

	   $qry=" 
	  SELECT * FROM
	  (
	  select top $limit ROW_NUMBER() OVER (ORDER BY loo_id desc) as RowNumber 
	  ,[loo_id]
      ,CTE.[loo_descr]
      ,CTE.[loo_date]
      ,CTE.[loo_sdate]
      ,CTE.[loo_edate]
      ,CTE.[loo_term]
      ,CTE.[loo_type]
      ,CTE.[loo_pict]
      ,CTE.[_createby]
      ,CTE.[_createdate]
      ,CTE.[_modifyby]
      ,CTE.[_modifydate]
      ,CTE.[isapproved]
      ,CTE.[isconfirm]
      ,CTE.[isdisabled]
      ,CTE.[rent_type]
      ,CTE.[region_id]
      ,CTE.[branch_id]
      ,CTE.[rekanan_id]
      ,CTE.[rekananshipping_line]
      ,CTE.[conf_id]
      ,CTE.[unittype_id]
      ,CTE.[skl_id]
      ,CTE.[ref_id]
      ,CTE.[ismulti]
      ,CTE.[loo_rent_desc]
	  ,REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name
    FROM transaksi_loo CTE       
      LEFT JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
      LEFT JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
      LEFT JOIN master_rekanan AS REKAN ON CTE.rekanan_id = REKAN.rekanan_id
      LEFT JOIN master_rekananshipping AS BRAND ON CTE.rekanan_id = BRAND.rekanan_id AND CTE.rekananshipping_line = BRAND.rekananshipping_line
	$sWhere
	) AS V
    WHERE RowNumber > $top
	order by _createdate DESC";
	//echo $qry;
	   return $this->db->query($qry)->result_array();	   
   }
   
    function qry_filteredlist($sWhere){
     $sWhere = empty($sWhere) ? " WHERE isdisabled = 0 and unittype_id = 6" : $sWhere." AND isdisabled = 0 and unittype_id = 6";
	   $qry="SELECT count(*) as jml FROM
	  (
	  select ROW_NUMBER() OVER (ORDER BY loo_id desc) as RowNumber 
	  ,[loo_id]
      ,CTE.[loo_descr]
      ,CTE.[loo_date]
      ,CTE.[loo_sdate]
      ,CTE.[loo_edate]
      ,CTE.[loo_term]
      ,CTE.[loo_type]
      ,CTE.[loo_pict]
      ,CTE.[_createby]
      ,CTE.[_createdate]
      ,CTE.[_modifyby]
      ,CTE.[_modifydate]
      ,CTE.[isapproved]
      ,CTE.[isconfirm]
      ,CTE.[isdisabled]
      ,CTE.[rent_type]
      ,CTE.[region_id]
      ,CTE.[branch_id]
      ,CTE.[rekanan_id]
      ,CTE.[rekananshipping_line]
      ,CTE.[conf_id]
      ,CTE.[unittype_id]
      ,CTE.[skl_id]
      ,CTE.[ref_id]
      ,CTE.[ismulti]
      ,CTE.[loo_rent_desc]
	  ,REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name
    FROM transaksi_loo CTE       
      LEFT JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
      LEFT JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
      LEFT JOIN master_rekanan AS REKAN ON CTE.rekanan_id = REKAN.rekanan_id
      LEFT JOIN master_rekananshipping AS BRAND ON CTE.rekanan_id = BRAND.rekanan_id AND CTE.rekananshipping_line = BRAND.rekananshipping_line
	$sWhere
	) AS V";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalllist(){
	   $qry="select count(loo_id) as jml from transaksi_loo where unittype_id = 6 and isdisabled = 0";
		return $this->db->query($qry)->row_array();
	   
   }
   
    function insertloo($loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $lease,
        $loo_line,$unit_id,$agrtype_id,$loo_baserent, $tenant, $brand, $int, $timetype, $loo_descr,$r_id,$region, $skl_id, $descr, 
        $isper, $percent, $u_line, $u_unit, $u_size, $u_lantai,$ismulti,$loo_rent_desc,$Objregion_id,$Objbranch_id,$unittype_id,$usdate,$uedate,$branch_inject,
        $d_Region, $d_Branch, $d_Start, $d_End, $product_name,$fitting_out,$grace_period,$size_indoor,$size_outdoor)
    {

		    //echo $branch_inject;exit;		
        $datetime1 = date_create($loo_sdate);
        $datetime2 = date_create($loo_edate);
		$datetime2->modify('+1 day');
        $interval = date_diff($datetime1, $datetime2);

        $loo_term = $interval->m + ($interval->y * 12);

        $timestamp = time();
		
        $loo_id = gen_id_loo_atm($region,'LOO','sequencer_loo', $r_id, $timestamp);
		$loo_id_temp = gen_id_loo_temp_atm($region,'TMP','sequencer_loo', $r_id, $timestamp);
		  
		
        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     
        $check = $this->db->query("
                 insert into transaksi_loo
                     (loo_id, loo_date, loo_sdate, loo_edate, loo_term, _createby, _createdate, _modifyby, _modifydate, region_id , branch_id, rekanan_id, rekananshipping_line, loo_type, loo_descr, skl_id,ismulti,loo_rent_desc,conf_id,unittype_id,ispenawaran, product_name,fitting_out,grace_period,size_indoor,size_outdoor)
                 values
                     ('$loo_id','$loo_date', '$loo_sdate', '$loo_edate', $loo_term,'$_createby','$now','$_modifyby','$now','$region','$branch_inject',
                      '$tenant', '$brand', 1, '$loo_descr','$skl_id',$ismulti,'$loo_rent_desc','$loo_id_temp','$unittype_id','1', '$product_name',$fitting_out,$grace_period,$size_indoor,$size_outdoor)");     
			
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
				$t_Region     = $d_Region[$key];
				$t_Branch     = $d_Branch[$key];
				$t_Start      = $d_Start[$key];
				$t_End        = $d_End[$key]; 
				$t_sdate = date_create($t_Start);
				$t_edate = date_create($t_End);
				$t_edate->modify('+1 day');
				$t_inter = date_diff($t_sdate, $t_edate); 
				$t_term = $t_inter->m + ($t_inter->y * 12);

        	$this->db->query("
             insert into transaksi_loodetil
                 (loo_id, loodetil_line, loodetil_baserent, agreementtype_id, unit_id, loodetil_int, timetype_id, loodetil_descr, loodetil_ispercent, loodetil_percent, region_id, branch_id, rekanan_id, rekananshipping_line, loodetil_sdate, loodetil_edate, loodetil_term )
             values
                 ('$loo_id', $t_line, $t_baserent, '$t_agrtype', '$t_unit', $t_int, '$t_timet', '$t_descr', $t_isper, 
                 $t_percent, '$t_Region', '$t_Branch', '$tenant', '$brand', '$t_Start', '$t_End', $t_term )");
        }

        foreach($u_line as $key => $n){

          $_line        = $u_line[$key];
          $_unit        = $u_unit[$key];
          $_size        = $u_size[$key];
          $_lantai      = $u_lantai[$key];
          $_region_id   = $Objregion_id[$key];
          $_branch_id   = $Objbranch_id[$key];
		      $_startdate   = $usdate[$key];
		      $_enddate     = $uedate[$key];

          $u_sdate = date_create($_startdate);
          $u_edate = date_create($_enddate); 
		  $u_edate->modify('+1 day'); 
          $u_inter = date_diff($u_sdate, $u_edate);

          $u_term = $u_inter->m + ($u_inter->y * 12);
 
		  $debtor_no = $this->get_debtorCode($tenant,$brand)->rowid;
		  $va_no = get_va($debtor_no,$brand);
          $this->db->query("
                insert into transaksi_loounit
                    ( loo_id, loounit_line, loounit_space, unit_id, lantai_id,region_id,branch_id,loounit_sdate,loounit_edate,rekanan_id,rekananshipping_line, loounit_term,virtualaccount )
                values
                  ( '$loo_id', $_line, $_size, '$_unit', '$_lantai','$_region_id','$_branch_id','$_startdate','$_enddate','$tenant', '$brand', $u_term,'$va_no' )");          

          $this->db->query(" UPDATE master_unit SET unit_state = 1 WHERE unit_id='$t_unit' and region_id='$_region_id' and branch_id='$_branch_id' "); 
  			}
			
			return $loo_id;
			  
    }

  function get_debtorCode($rekanan,$rekananshipping_line)
  {
	 $sql = " SELECT rowid FROM master_rekananshipping WHERE rekanan_id = '$rekanan' and rekananshipping_line = $rekananshipping_line";
	 return $this->db->query($sql)->row();
	  
  }
	
  function sholdetilby_id($id){          
        $sql = "
         SELECT LD.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name 
          FROM transaksi_loodetil LD 
          LEFT JOIN transaksi_loo LH ON LH.loo_id = LD.loo_id		
           LEFT JOIN transaksi_loounit LOU ON LH.loo_id = LOU.loo_id  and LOU.unit_id = LD.unit_id
          LEFT JOIN master_unit UNIT ON UNIT.unit_id = LD.unit_id AND UNIT.region_id = LOU.region_id AND UNIT.branch_id = LOU.branch_id 
          LEFT JOIN master_agreementtype AT ON AT.agreementtype_id = LD.agreementtype_id 
			
          WHERE LD.loo_id = '$id'
          ORDER BY  loo_id, loodetil_line ASC";  
    return $this->db->query($sql)->result();      
  }

  function vdetilunitby_id($id){          
        $sql = "
          SELECT LU.*, UNIT.unit_name AS unit_name, LT.lantai_name AS lantai_name,RG.region_name,BR.branch_name,LU.loounit_sdate,LU.loounit_edate
          FROM transaksi_loounit LU 
            LEFT JOIN transaksi_loo LH ON LH.loo_id = LU.loo_id
            LEFT JOIN master_unit UNIT ON UNIT.unit_id = LU.unit_id AND UNIT.region_id = LU.region_id AND UNIT.branch_id = LU.branch_id
            LEFT JOIN master_lantai LT ON LT.lantai_id = LU.lantai_id
			LEFT JOIN master_branch BR ON LU.branch_id = BR.branch_id
			LEFT JOIN master_region RG ON LU.region_id = RG.region_id
          WHERE LU.loo_id = '$id'";  
    return $this->db->query($sql)->result();      
  }
		    
  function updateloo($loo_id ,$loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, 
                $lease, $loo_line,$unit_id,$agrtype_id,$loo_baserent, $tenant, $brand, $int, $timetype, $loo_descr,$region , 
                $skl_id, $descr, $_ispercent, $loo_percent, $u_line, $u_unit, $u_size, $u_lantai,$ismulti,$loo_rent_desc,
                $Objregion_id,$Objbranch_id,$unittype_id,$conf_id,$isapprove,$usdate,$uedate,$branch_inject, 
                $d_Region, $d_Branch, $d_Start, $d_End,$vObjregion_id,$vObjbranch_id, $product_name,$fitting_out,$grace_period,$size_indoor,$size_outdoor)
  {

        $datetime1 = date_create($loo_sdate);
        $datetime2 = date_create($loo_edate);
		
		$datetime2->modify('+1 day');
		
        $interval = date_diff($datetime1, $datetime2);

        $loo_term = $interval->m + ($interval->y * 12);

  		  $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);  
		if($isapprove != 1)
		{
			$syntax = "
            update transaksi_loo
            set loo_date 			= '$loo_date', 
          			loo_descr 				= '$loo_descr', 
          			loo_sdate 				= '$loo_sdate', 
          			loo_edate 				= '$loo_edate', 
          			_createby 				= '$_createby', 
          			loo_term 				= $loo_term,
          			_modifyby 				= '$_modifyby', 
          			_modifydate 			= '$now', 
          			rekanan_id 				= '$tenant', 
          			rekananshipping_line 	= '$brand',  
          			ismulti 				= $ismulti,
          			loo_rent_desc			= '$loo_rent_desc', 
					product_name			= '$product_name',
					fitting_out				= $fitting_out,
					grace_period			= $grace_period,
					size_indoor				= $size_indoor,
					size_outdoor 			= $size_outdoor 
            where conf_id 					= '$conf_id'"; 
			
			$check=$this->db->query($syntax );	 
		}
		else{
			$check=$this->db->query("
            update transaksi_loo
            set loo_date 			= '$loo_date', 
			loo_descr 				= '$loo_descr', 
			loo_sdate 				= '$loo_sdate', 
			loo_edate 				= '$loo_edate', 
			_createby 				= '$_createby', 
			loo_term 				= $loo_term,
			_modifyby 				= '$_modifyby', 
			_modifydate 			= '$now', 
			rekanan_id 				= '$tenant', 
			rekananshipping_line 	= '$brand',  
			ismulti 				= $ismulti,
			loo_rent_desc			= '$loo_rent_desc',
			product_name			= '$product_name',
			fitting_out				= $fitting_out,
			grace_period			= $grace_period,
			size_indoor				= $size_indoor,
			size_outdoor 			= $size_outdoor 
            where loo_id = '$loo_id'
        ");	  
		}
       
 
        if ($check){ 
		    $this->db->query("delete from transaksi_loodetil where loo_id='$loo_id'");  	
			 
          

          foreach($loo_line as $key => $n){

            $t_line       = $loo_line[$key];
            $t_unit       = $unit_id[$key];
            $t_agrtype    = $agrtype_id[$key];
            $t_baserent   = $loo_baserent[$key];          
            $t_baserent   = str_replace(',', '',$t_baserent);            
            $t_int        = $int[$key];   
            $t_timetype   = $timetype[$key];   
            $t_descr      = $descr[$key];
            $t_isper      = ($_ispercent[$key]) ? 1 : 0;
            $t_percent    = $loo_percent[$key];
            $t_Region     = $d_Region[$key];
            $t_Branch     = $d_Branch[$key];
            $t_Start      = $d_Start[$key];
            $t_End        = $d_End[$key];

            $t_sdate = date_create($t_Start);
            $t_edate = date_create($t_End);
			$t_edate->modify('+1 day');
            $t_inter = date_diff($t_sdate, $t_edate);

            $t_term = $t_inter->m + ($t_inter->y * 12);
            

            $this->db->query("
             insert into transaksi_loodetil
                 (loo_id, loodetil_line, loodetil_baserent, agreementtype_id, unit_id, loodetil_int, timetype_id, loodetil_descr, loodetil_ispercent, loodetil_percent,
                  region_id, branch_id, rekanan_id, rekananshipping_line, loodetil_sdate, loodetil_edate, loodetil_term )
             values
                 ('$loo_id', $t_line, $t_baserent, '$t_agrtype', '$t_unit', $t_int, '$t_timetype', '$t_descr', $t_isper, $t_percent,
                 '$t_Region', '$t_Branch', '$tenant', '$brand', '$t_Start', '$t_End', $t_term )");
          }

          $this->db->query("delete from transaksi_loounit where loo_id='$loo_id'");  

           foreach($u_line as $key => $n){

			  $_line       = $u_line[$key];
			  $_unit       = $u_unit[$key];
			  $_size       = $u_size[$key];
			  $_lantai     = $u_lantai[$key];
			  $_region_id  = $vObjregion_id[$key];
			  $_branch_id  = $vObjbranch_id[$key];
			  $_startdate  = $usdate[$key];
			  $_enddate    = $uedate[$key]; 

        $u_sdate = date_create($_startdate);
        $u_edate = date_create($_enddate);
		$u_edate->modify('+1 day');
        $u_inter = date_diff($u_sdate, $u_edate);

        $u_term = $u_inter->m + ($u_inter->y * 12);
			   
			  $this->db->query("
					insert into transaksi_loounit
						( loo_id, loounit_line, loounit_space, unit_id, lantai_id,region_id,branch_id,loounit_sdate,loounit_edate,rekanan_id,rekananshipping_line, loounit_term )
					values
					  ( '$loo_id', $_line, $_size, '$_unit', '$_lantai','$_region_id','$_branch_id','$_startdate','$_enddate','$tenant', '$brand', $u_term)");

			  $this->db->query(" UPDATE master_unit SET unit_state = 1 WHERE unit_id='$t_unit' and region_id='$_region_id' and branch_id='$_branch_id' "); 
				
            }
        }                  
  }
	
  function deleteloo($loo_id){
   
    $this->db->query(" UPDATE transaksi_loo SET isdisabled = '1' WHERE loo_id = '$loo_id' ");

    $u_sql = "
              SELECT DISTINCT B.region_id, B.branch_id, A.unit_id 
              FROM transaksi_loodetil AS A inner join transaksi_loo AS B ON A.loo_id = B.loo_id
              WHERE A.loo_id = '$loo_id' ";

    $q_uid = $this->db->query($u_sql)->result_array();
	 
	 
    foreach($q_uid as $uid){

		$unit_id = $uid['unit_id']; 
		$region_id = $uid['region_id'];
		$branch_id = $uid['branch_id'];
		 
		$this->db->query("UPDATE master_unit SET unit_state = 2 WHERE unit_id='$unit_id' AND region_id = $region_id AND branch_id = $branch_id");

    } 
		// $this->db->query("delete from transaksi_loo where loo_id='$loo_id'");
		// $this->db->query("delete from transaksi_loodetil where loo_id='$loo_id'");
		// $this->db->query("delete from transaksi_loounit where loo_id='$loo_id'");
	}
    
  function viewloo($loo_id){     

     if (isset($loo_id)){
        return $this->db->query("
           select loo_id
		   , convert(varchar(10),loo_date,120) AS loo_date, loo_type, unittype_id, loo_descr, skl_id,
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term, _createby, _createdate, _modifyby, _modifydate, region_id, isapproved, isconfirm,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name,LOO.loo_rent_desc,LOO.ismulti,LOO.conf_id,LOO.ispenawaran,
			  LOO.product_name,LOO.fitting_out,LOO.grace_period ,LOO.size_indoor ,LOO.size_outdoor
           from transaksi_loo AS LOO 
             LEFT JOIN master_branch AS BRANCH ON LOO.branch_id = BRANCH.branch_id
             LEFT JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
             LEFT JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
           where unittype_id = 6 and LOO.loo_id='$loo_id' 
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
          
            $this->db->query(" UPDATE transaksi_loo SET isapproved = '1',isconfirm='1' WHERE conf_id = '$loo_id' ");

/*
            $u_sql = " SELECT DISTINCT unit_id FROM transaksi_loodetil WHERE loo_id = '$loo_id' ";

            $q_uid = $this->db->query($u_sql)->result_array();

            foreach($q_uid as $uid){

              $unit_id = $uid['unit_id'];
              $this->db->query(" UPDATE master_unit SET unit_state = 2 WHERE unit_id='$unit_id' and region_id = '$region_id' and branch_id = '$branch_id' ");
              
            }            
*/

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
            JOIN transaksi_loodetil LOD ON LOH.loo_id = LOD.loo_id
            JOIN master_region AS REGION ON LOH.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOH.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOH.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOH.rekanan_id = BRAND.rekanan_id AND LOH.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOH.region_id AND UNIT.branch_id = LOH.branch_id
          WHERE LOH.isconfirm = '0' AND LOH.isapproved = '1'  AND UNIT.unit_state <> '3' AND LOD.unit_id like '%{$uid}%' ";    

        return $this->db->query($sql)->result_array();
    }
 
  function dataapp($uid){
		 
        $sql = " 
         SELECT DISTINCT 
		 (CASE LOH.isapproved when 1 then LOH.loo_id else LOH.conf_id END) as [loo_id]
      ,LOH.[loo_descr]
      ,LOH.[loo_date]
      ,LOH.[loo_sdate]
      ,LOH.[loo_edate]
      ,LOH.[loo_term]
      ,LOH.[loo_type]
      ,LOH.[loo_pict]
      ,LOH.[_createby]
      ,LOH.[_createdate]
      ,LOH.[_modifyby]
      ,LOH.[_modifydate]
      ,LOH.[isapproved]
      ,LOH.[isconfirm]
      ,LOH.[isdisabled]
      ,LOH.[rent_type]
      ,LOH.[region_id]
      ,LOH.[branch_id]
      ,LOH.[rekanan_id]
      ,LOH.[rekananshipping_line]
      ,LOH.[conf_id]
      ,LOH.[unittype_id]
      ,LOH.[skl_id]
      ,LOH.[ref_id]
      ,LOH.[ismulti]
      ,LOH.[loo_rent_desc]
      ,LOH.[ispenawaran], 
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
          WHERE LOH.ispenawaran = '1' AND LOH.isapproved = 0 and LOH.isconfirm = 0 AND UNIT.unit_state <> '2' AND LOH.unittype_id = 6 AND LOD.unit_id like '%{$uid}%'";

        return $this->db->query($sql)->result_array();
    }
 	
  function dataapp_list($region_id,$branch_id,$unit_id,$lantai_id){
	 
		$lantai_enc = str_replace('+','',$lantai_id);
		$unit_enc = str_replace('+','',$unit_id);
		$unit_id = $unit_id != "0" ? " AND a.unit_id = '$unit_enc'" : "" ;
		$lantai_id =  $lantai_id != "0" ? " AND a.unit_name LIKE '%$lantai_enc%' " : "";
		
        $sql = " 
         select unit_id as '0',
			c.region_name as '1',
			b.branch_name as '2',
			a.unit_name as '3',
			a.unit_sqm as '4',
			a.lantai_id as '5',
			c.region_id as '6',
			b.branch_id as '7'
			from master_unit a 
		left join master_branch b on a.branch_id = b.branch_id 
		left join master_region c on a.region_id = c.region_id 
		where a.region_id = $region_id and a.branch_id = '$branch_id' $unit_id $lantai_id"   ; 
		//echo $sql;
		//echo $lantai_enc;
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
    
	function get_branch_dlg($branch_name="")
	{ 
		// echo var_dump($branch_name);
		// exit;
        $this->db->select('r.branch_id, branch_name,c.region_id,c.region_name');
        $this->db->from('master_regionbranch r');
        $this->db->join('master_branch b', 'r.branch_id = b.branch_id');
        $this->db->join('master_region c', 'c.region_id = r.region_id');
		if($branch_name != '')
		{  
			$this->db->like('b.branch_name', $branch_name); 
		}
        $query = $this->db->get();

        $result = $query->result();
		
		 // $ret ['']= 'Pilih Store :';
        // if($result)
        // {
            // foreach ($result as $key => $row)
            // {
                // $ret [$row->branch_id] = $row->branch_name;
            // }
        // }
        //echo var_dump($ret);
        return $result; 
		
    }
	
	function get_region_bybranch($branch)
	{ 
        $this->db->select('r.region_id as region_id');
        $this->db->from('master_regionbranch r');
        $this->db->join('master_branch b', 'r.branch_id = b.branch_id');
		if($region_id != '')
		{  
			$this->db->where('r.branch_id', $branch); 
		}
        $query = $this->db->get();

        $result = $query->row()->region_id; 
        return $result; 
    }
}