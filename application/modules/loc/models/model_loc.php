<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_loc extends CI_Model{
    
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

   function qry_alldatalook($limit,$top,$sWhere){

     $sWhere = empty($sWhere) ? " WHERE isapproved = 1 AND unittype_id <> 7 AND unittype_id <> 6 " : 
        $sWhere." AND unittype_id <> 7 AND unittype_id <> 6";

     $qry="WITH CTE AS (
        select top $limit *,ROW_NUMBER() OVER (ORDER BY loo_id asc) as RowNumber 
        from transaksi_loo $sWhere)
    SELECT CTE.*, REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name
    FROM CTE 
      JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
      JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
      JOIN master_rekanan AS REKAN ON CTE.rekanan_id = REKAN.rekanan_id
      JOIN master_rekananshipping AS BRAND ON CTE.rekanan_id = BRAND.rekanan_id AND CTE.rekananshipping_line = BRAND.rekananshipping_line            
    WHERE RowNumber > $top
    ORDER BY CTE._createdate DESC ";

     return $this->db->query($qry)->result_array();    
   }
   
   function qry_filteredlook($sWhere){

      $sWhere = empty($sWhere) ? " WHERE isapproved = 1 AND unittype_id <> 7 AND unittype_id <> 6 " : 
        $sWhere." AND unittype_id <> 7 AND unittype_id <> 6";

      $qry="select count(loo_id) as jml from transaksi_loo $sWhere";
    return $this->db->query($qry)->row_array();
     
   }
   
   function qry_totalalllook(){
     $qry="select count(loo_id) as jml from transaksi_loo";
    return $this->db->query($qry)->row_array();
     
   }
   
    function qry_alldatalist($limit,$top,$sWhere){
	// echo var_dump($sWhere);
     $sWhere = empty($sWhere) ? " WHERE isdisabled = 0 AND unittype_id <> 7 AND unittype_id <> 6 " : $sWhere." AND isdisabled = 0 AND unittype_id <> 7 AND unittype_id <> 6";

	   $qry=" 
			SELECT * FROM (
			select top $limit CTE.*,ROW_NUMBER() OVER (ORDER BY loc_id desc) as RowNumber, 
						   REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name
			  FROM transaksi_loc AS CTE       
			  JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
			  JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
			  JOIN master_rekanan AS REKAN ON CTE.rekanan_id = REKAN.rekanan_id
			  JOIN master_rekananshipping AS BRAND ON CTE.rekanan_id = BRAND.rekanan_id AND CTE.rekananshipping_line = BRAND.rekananshipping_line
			  $sWhere 
			  ORDER BY CTE._createdate DESC
			  ) AS V
    	WHERE   RowNumber > $top";
	  
	  // echo $qry;
	   //exit;
	    return $this->db->query($qry)->result_array();
   }
   
    function qry_filteredlist($sWhere){
       $sWhere = empty($sWhere) ? " WHERE isdisabled = 0 AND unittype_id <> 7 AND unittype_id <> 6 " : $sWhere." AND isdisabled = 0 AND unittype_id <> 7 AND unittype_id <> 6";
	   $qry="SELECT count(*) as jml FROM (
			select CTE.*,ROW_NUMBER() OVER (ORDER BY loc_id desc) as RowNumber, 
						   REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name
			  FROM transaksi_loc AS CTE       
			  JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
			  JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
			  JOIN master_rekanan AS REKAN ON CTE.rekanan_id = REKAN.rekanan_id
			  JOIN master_rekananshipping AS BRAND ON CTE.rekanan_id = BRAND.rekanan_id AND CTE.rekananshipping_line = BRAND.rekananshipping_line
			  $sWhere 
			 
			  ) AS V";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalllist(){
	   $qry="select count(loc_id) as jml from transaksi_loc where unittype_id <> 7 AND unittype_id <> 6";
		return $this->db->query($qry)->row_array();
	   
   }
   
    function insertloc($loc_date, $loc_sdate, $loc_edate, $loc_term, $_createby, $_modifyby, $region, $branch, $lease,
        $loc_line,$unit_id,$agrtype_id,$loc_baserent, $r_id, $tenant, $brand, $int, $timetype, $loc_descr, $unit_type, $skl_id, $descr,
        $isper, $percent, $u_line, $u_unit, $u_size, $u_lantai, $d_region, $d_branch, $d_tenant, $d_brand, 
        $u_region, $u_branch, $u_tenant, $u_brand, $product, $fitout, $gperiod, $indoorz, $outdoorz, $ref, $debtor_no, $virtual_acc)
    {


        $datetime1 = date_create($loc_sdate);
        $datetime2 = date_create($loc_edate);
		    $datetime2->modify('+1 day');
        $interval = date_diff($datetime1, $datetime2);

        $loc_term = $interval->m + ($interval->y * 12);

        $timestamp = time();		   

        $loc_id = gen_id_loo($region,'LOC','sequencer_loo', $r_id, $timestamp);

        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     
        $check = $this->db->query("
                 insert into transaksi_loc
                     (loc_id, loc_date, loc_sdate, loc_edate, loc_term, _createby, _createdate,  region_id , branch_id, rekanan_id, rekananshipping_line, loc_type, loc_descr, skl_id, unittype_id, product_name, fitting_out, grace_period,
                      size_indoor, size_outdoor, ref_id, debtor_no, virtual_acc)
                 values
                     ('$loc_id','$loc_date', '$loc_sdate', '$loc_edate', $loc_term,'$_createby','$now','$region','$branch',
                      '$tenant', '$brand', '$lease', '$loc_descr','$skl_id', '$unit_type', '$product', $fitout, $gperiod, $indoorz, 
                      $outdoorz, '$ref', '$debtor_no', '$virtual_acc')");     
			
  			foreach($loc_line as $key => $n){

  				$t_line       = $loc_line[$key];
  				$t_unit       = $unit_id[$key];
  				$t_agrtype    = $agrtype_id[$key];
  				$t_baserent   = $loc_baserent[$key];
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
             insert into transaksi_locdetil
                 (loc_id, locdetil_line, locdetil_baserent, agreementtype_id, unit_id, locdetil_int, timetype_id, locdetil_descr, locdetil_ispercent, locdetil_percent, region_id, branch_id, rekanan_id, rekananshipping_line,locdetil_sdate,locdetil_edate,locdetil_term)
             values
                 ('$loc_id', $t_line, $t_baserent, '$t_agrtype', '$t_unit', $t_int, '$t_timet', '$t_descr', $t_isper, 
                  $t_percent, '$t_region', '$t_branch','$tenant', '$brand', '$loc_sdate', '$loc_edate', $loc_term )");
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
                insert into transaksi_locunit
                    ( loc_id, locunit_line, locunit_space, unit_id, lantai_id, region_id, branch_id, rekanan_id, rekananshipping_line, locunit_sdate, locunit_edate, locunit_term )
                values
                  ( '$loc_id', $_line, $_size, '$_unit', '$_lantai', '$_region', '$_branch', '$tenant', '$brand', '$loc_sdate', '$loc_edate', $loc_term  )");          

          $this->db->query(" UPDATE master_unit SET unit_state = 1 WHERE unit_id='$t_unit' and region_id='$region' and branch_id='$branch' "); 
  			}
			
			return $loc_id;
			  
    }

  function sholdetilby_id($id){          
        $sql = "
          SELECT LD.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name
          FROM transaksi_locdetil LD
            JOIN transaksi_loc LH ON LH.loc_id = LD.loc_id 
            JOIN master_unit UNIT ON UNIT.unit_id = LD.unit_id AND UNIT.region_id = LH.region_id AND UNIT.branch_id = LH.branch_id
            JOIN master_agreementtype AT ON AT.agreementtype_id = LD.agreementtype_id
          WHERE LD.loc_id = '$id'
          ORDER BY  loc_id, locdetil_line ASC";  
    return $this->db->query($sql)->result();      
  }

  function vdetilunitby_id($id){          
        $sql = "
          SELECT LU.*, UNIT.unit_name AS unit_name, LT.lantai_name AS lantai_name
          FROM transaksi_locunit LU 
            JOIN transaksi_loc LH ON LH.loc_id = LU.loc_id
            JOIN master_unit UNIT ON UNIT.unit_id = LU.unit_id AND UNIT.region_id = LH.region_id AND UNIT.branch_id = LH.branch_id
            JOIN master_lantai LT ON LT.lantai_id = LU.lantai_id
          WHERE LU.loc_id = '$id'";  
    return $this->db->query($sql)->result();      
  }
		    
	function updateloc($loc_id, $loc_date, $loc_descr, $loc_sdate, $loc_edate, $loc_term, $_createby, $_modifyby, $region, $branch, 
        $lease, $loc_line,$unit_id,$agrtype_id,$loc_baserent, $tenant, $brand, $int, $timetype, $descr, $isper, $percent,
        $u_line, $u_unit, $u_size, $u_lantai, $unit_type, $skl_id, $d_region, $d_branch, $d_tenant, $d_brand, 
        $u_region, $u_branch, $u_tenant, $u_brand, $product, $fitout, $gperiod, $indoorz, $outdoorz, $ref, $debtor_no, $virtual_acc){        

        $datetime1 = date_create($loc_sdate);
        $datetime2 = date_create($loc_edate);		
		    $datetime2->modify('+1 day');


        $interval = date_diff($datetime1, $datetime2);
        $loc_term = $interval->m + ($interval->y * 12);

  		  $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     
        $check=$this->db->query("
            update transaksi_loc
            set loc_date = '$loc_date', loc_descr = '$loc_descr', loc_sdate = '$loc_sdate', loc_edate = '$loc_edate', loc_term = $loc_term,
                _modifyby = '$_modifyby', _modifydate = '$now', region_id = '$region' , branch_id = '$branch',
                rekanan_id = '$tenant', rekananshipping_line = '$brand', loc_type = '$lease', unittype_id = '$unit_type',
                product_name= '$product', fitting_out = $fitout, grace_period = $gperiod, size_indoor = $indoorz, size_outdoor = $outdoorz,
                ref_id = '$ref', debtor_no = '$debtor_no', virtual_acc = '$virtual_acc'
            where loc_id = '$loc_id'
        ");	    


        if ($check){
          $this->db->query("delete from transaksi_locdetil where loc_id='$loc_id'");  

          foreach($loc_line as $key => $n){

            $t_line       = $loc_line[$key];
            $t_unit       = $unit_id[$key];
            $t_agrtype    = $agrtype_id[$key];
            $t_baserent   = $loc_baserent[$key];          
            $t_baserent   = str_replace(',', '',$t_baserent);            
            $t_int        = $int[$key];   
            $t_timetype   = $timetype[$key];   
            $t_descr      = $descr[$key];
            $t_isper      = ($isper[$key]) ? 1 : 0;
            $t_percent    = $percent[$key];
            $t_region     = $d_region[$key];
            $t_branch     = $d_branch[$key];
            $t_tenant     = $d_tenant[$key];
            $t_brand      = $d_brand[$key];

            $this->db->query("
             insert into transaksi_locdetil
                 (loc_id, locdetil_line, locdetil_baserent, agreementtype_id, unit_id, locdetil_int, timetype_id, locdetil_descr, locdetil_ispercent, locdetil_percent, region_id, branch_id, rekanan_id, rekananshipping_line, locdetil_sdate, locdetil_edate, locdetil_term )
             values
                 ('$loc_id', $t_line, $t_baserent, '$t_agrtype', '$t_unit', $t_int, '$t_timetype', '$t_descr', $t_isper, $t_percent, 
                  '$t_region', '$t_branch', '$tenant', '$brand', '$loc_sdate', '$loc_edate', $loc_term )");
          }

          $this->db->query("delete from transaksi_locunit where loc_id='$loc_id'");  

          foreach($u_line as $key => $n){

            $_line       = $u_line[$key];
            $_unit       = $u_unit[$key];
            $_size       = $u_size[$key];
            $_lantai     = $u_lantai[$key];
            $_region     = $u_region[$key];
            $_branch     = $u_branch[$key];
            $_tenant     = $u_tenant[$key];
            $_brand       = $u_brand[$key];

            $this->db->query("
             insert into transaksi_locunit
                 ( loc_id, locunit_line, locunit_space, unit_id, lantai_id, region_id, branch_id, rekanan_id, rekananshipping_line, 
                  locunit_sdate, locunit_edate, locunit_term )
             values
                 ( '$loc_id', $_line, $_size, '$_unit', '$_lantai', '$_region', '$_branch', '$tenant', '$brand', 
                 '$loc_sdate', '$loc_edate', $loc_term )"); 
          }
          
        }                  
  }
	
	function deleteloc($loc_id){
    
    $this->db->query(" UPDATE transaksi_loc SET isdisabled = '1' WHERE loc_id = '$loc_id' ");

    $u_sql = "
              SELECT DISTINCT b.region_id, b.branch_id, a.unit_id 
              FROM transaksi_locdetil AS A inner join transaksi_loc AS B ON A.loc_id = B.loc_id
              WHERE A.loc_id = '$loc_id' ";

    $q_uid = $this->db->query($u_sql)->result_array();

    foreach($q_uid as $uid){

      $unit_id = $uid['unit_id'];
	  $region_id=$uid['region_id'];
	  $branch_id=$uid['branch_id'];
      $this->db->query("UPDATE master_unit SET unit_state = 2 WHERE unit_id='$unit_id' AND region_id = '$region_id' AND branch_id = '$branch_id'");

    } 
		//$this->db->query("delete from transaksi_loc where loc_id='$loc_id'");
		//$this->db->query("delete from transaksi_locdetil where loc_id='$loc_id'");
    //$this->db->query("delete from transaksi_locunit where loc_id='$loc_id'");
	}
    
  function viewloc($loc_id){     

     if (isset($loc_id)){
        return $this->db->query("
           select loc_id, convert(varchar(10),loc_date,120) AS loc_date, loc_type, unittype_id, loc_descr, skl_id,
              convert(varchar(10),loc_sdate,120) AS loc_sdate, convert(varchar(10),loc_edate,120) AS loc_edate,
              loc_term, _createby, _createdate, _modifyby, _modifydate, region_id, isapproved, isconfirm,
              LOC.branch_id, LOC.rekanan_id, LOC.rekananshipping_line, BRANCH.branch_name, REKAN.rekanan_name, 
              BRAND.rekananshipping_name, LOC.product_name, LOC.fitting_out, LOC.grace_period, LOC.size_indoor, 
              LOC.size_outdoor, LOc.ref_id, LOC.debtor_no, LOC.virtual_acc
           from transaksi_loc AS LOC 
              JOIN master_branch AS BRANCH ON LOC.branch_id = BRANCH.branch_id
              JOIN master_rekanan AS REKAN ON LOC.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOC.rekanan_id = BRAND.rekanan_id AND LOC.rekananshipping_line = BRAND.rekananshipping_line
          where LOC.loc_id='$loc_id'
       ")->result();        
     }else{         
       $timestamp = time();
      
       $now = date("Y-m-d", $timestamp);  

       $result[] = (object) array(                        
                        'loc_id'          =>'auto',
                        'loc_date'        => $now,
                        'loc_sdate'       => $now,
                        'loc_edate'        => $now,
                        'loc_term'       => 0,
                        'region_id'       => '',
                        'branch_id'       => '',
                        'loc_type'       => '',
                        'rekanan_id'       => 0,
                        'rekananshipping_id' => 0,
                        '_createby'       => '',
                        '_createdate'     => $now,
                        '_modifyby'       => '',
                        '_modifydate'     => $now
       ); 

       return $result;
     }

   }
   
   function viewlocprint($loc_id){     

     if (isset($loc_id)){
        return $this->db->query("
           select top 1 LOC.loc_id, convert(varchar(10),loc_date,120) AS loc_date, 
              convert(varchar(10),loc_sdate,120) AS loc_sdate, convert(varchar(10),loc_edate,120) AS loc_edate,
              loc_term,
              LOC.branch_id, LOC.rekanan_id, LOC.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,c.rekanancontact_name,
			  REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,l.lantai_name,u.unit_name,u.unit_sqm,d.locdetil_baserent
			  
           from transaksi_loc AS LOC 
		   JOIN transaksi_locdetil d on LOC.loc_id=d.loc_id
		   JOIN master_branch as branch on branch.branch_id=LOC.branch_id
              JOIN master_rekanan AS REKAN ON LOC.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOC.rekanan_id = BRAND.rekanan_id AND LOC.rekananshipping_line = BRAND.rekananshipping_line
			  JOIN master_rekanancontact as c on c.rekanan_id=LOC.rekanan_id
			  JOIN master_unit u on u.unit_id=d.unit_id
			  JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOC.loc_id='$loc_id'
       ")->result();        
	 }

   }

     function unapproveloc($arrapp){   

    $action = "approve";   

     if (is_array($arrapp)){
       if (count($arrapp) >0){
          foreach ($arrapp as $key){       

            $loc_id = $key[0];
            $region_id = $key[1];
            $branch_id = $key[2];

            $this->db->trans_begin();
          
            $this->db->query(" UPDATE transaksi_loc SET isapproved = '0' WHERE loc_id = '$loc_id' ");

            $u_sql = " SELECT DISTINCT unit_id FROM transaksi_locdetil WHERE loc_id = '$loc_id' ";

            $q_uid = $this->db->query($u_sql)->result_array();

            foreach($q_uid as $uid){

              $unit_id = $uid['unit_id'];
              $this->db->query(" UPDATE master_unit SET unit_state = 1 WHERE unit_id='$unit_id' and region_id = '$region_id' and branch_id = '$branch_id' ");
              
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



 function confirmloc($arrCon){   

     $action = "return";   

     if (is_array($arrCon)){
       if (count($arrCon) >0){
          foreach ($arrCon as $filt){   

            $loc_id     = $filt[0];
            $region_id  = $filt[1];
            $branch_id  = $filt[2];           

            $timestamp = time();

            $this->db->trans_begin();

            $this->db->query(" UPDATE transaksi_loc SET isconfirm = '1' WHERE loc_id = '$loc_id' ");

            $u_sql = " SELECT DISTINCT unit_id FROM transaksi_locdetil WHERE loc_id = '$loc_id' ";

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

   function approveloc($arrapp){   

    $action = "approve";   

     if (is_array($arrapp)){
       if (count($arrapp) >0){
          foreach ($arrapp as $key){       

            $loc_id = $key[0];
            $region_id = $key[1];
            $branch_id = $key[2];

            $this->db->trans_begin();
          
            $this->db->query(" UPDATE transaksi_loc SET isapproved = '1' WHERE loc_id = '$loc_id' ");

            $u_sql = " SELECT DISTINCT unit_id FROM transaksi_locdetil WHERE loc_id = '$loc_id' ";

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
          FROM transaksi_loc LOH
            JOIN transaksi_locunit LOU ON LOU.loc_id = LOH.loc_id
            JOIN transaksi_locdetil LOD ON LOH.loc_id = LOD.loc_id
            JOIN master_region AS REGION ON LOU.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOU.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOU.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOU.rekanan_id = BRAND.rekanan_id AND LOU.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOU.region_id AND UNIT.branch_id = LOU.branch_id
          WHERE LOH.isconfirm = '0' AND LOH.isapproved = '1'  AND UNIT.unit_state <> '3' AND LOD.unit_id like '%{$uid}%' 
          ORDER BY loc_id desc ";    

        return $this->db->query($sql)->result_array();
    }

    function dataapp($uid){

        $sql = " 
          SELECT DISTINCT LOH.*, 
            REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, 
            UNIT.unit_name, LOD.unit_id
          FROM transaksi_loc LOH
            JOIN transaksi_locunit LOU ON LOU.loc_id = LOH.loc_id
            JOIN transaksi_locdetil LOD ON LOH.loc_id = LOD.loc_id
            JOIN master_region AS REGION ON LOU.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOU.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOU.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOU.rekanan_id = BRAND.rekanan_id AND LOU.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOU.region_id AND UNIT.branch_id = LOU.branch_id
          WHERE LOH.isapproved = '0' AND UNIT.unit_state <> '2'  AND LOD.unit_id like '%{$uid}%' 
          ORDER BY loc_id desc ";

        return $this->db->query($sql)->result_array();
    }
 function dataunapplist($uid){

        $sql = " 
          SELECT DISTINCT LOH.*, 
            REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name,'' as unit_id
          FROM transaksi_loc LOH
            JOIN transaksi_locunit LOU ON LOU.loc_id = LOH.loc_id
            JOIN transaksi_locdetil LOD ON LOH.loc_id = LOD.loc_id
            JOIN master_region AS REGION ON LOU.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOU.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOU.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOU.rekanan_id = BRAND.rekanan_id AND LOU.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOU.region_id AND UNIT.branch_id = LOU.branch_id
          WHERE LOH.isapproved = '1' AND LOD.unit_id like '%{$uid}%' 
          ORDER BY loc_id desc ";

        return $this->db->query($sql)->result_array();
    }
   function dataapplist($uid){

        $sql = " 
          SELECT DISTINCT LOH.*, 
            REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name,'' as unit_id
          FROM transaksi_loc LOH
            JOIN transaksi_locunit LOU ON LOU.loc_id = LOH.loc_id
            JOIN transaksi_locdetil LOD ON LOH.loc_id = LOD.loc_id
            JOIN master_region AS REGION ON LOU.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOU.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOU.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOU.rekanan_id = BRAND.rekanan_id AND LOU.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOU.region_id AND UNIT.branch_id = LOU.branch_id
          WHERE LOH.isapproved = '0' AND LOD.unit_id like '%{$uid}%' 
          ORDER BY loc_id desc ";

        return $this->db->query($sql)->result_array();
    }
    function dataprintconf($uid){

        $sql = " 
          SELECT DISTINCT LOH.*, REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, UNIT.unit_name, LOD.unit_id 
          FROM transaksi_loc LOH
            JOIN transaksi_locdetil LOD ON LOH.loc_id = LOD.loc_id
            JOIN master_region AS REGION ON LOH.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOH.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOH.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOH.rekanan_id = BRAND.rekanan_id AND LOH.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id AND UNIT.region_id = LOH.region_id AND UNIT.branch_id = LOH.branch_id
          WHERE LOH.isapproved = '0' AND LOH.isconfirm = '1' AND LOD.unit_id like '%{$uid}%' ";    

        return $this->db->query($sql)->result_array();
    }
    
 function getunitloc($uid){
  $sql="select distinct c.unit_name,c.unit_sqm from dbo.transaksi_locdetil a
     inner join transaksi_loc b on a.loc_id=b.loc_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.loc_id='$uid' and a.agreementtype_id='4000'";  
     return $this->db->query($sql)->result(); 
 }
 
  function gethargasewa($uid){
  $sql="select  a.locdetil_descr+' (' +c.unit_name+' )' as titleharga,a.locdetil_baserent  from dbo.transaksi_locdetil a
     inner join transaksi_loc b on a.loc_id=b.loc_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.loc_id='$uid' and a.agreementtype_id='4000' order by a.unit_id,a.locdetil_line asc"; 
    return $this->db->query($sql)->result(); 
 }
 
 function getservicecharge($uid){
  $sql="select SUM(locdetil_baserent) as servicecharge from transaksi_locdetil 
  where loc_id='$uid' and agreementtype_id='5000'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
  function getpromolevy($uid){
  $sql="select SUM(locdetil_baserent) as promolevy from transaksi_locdetil 
  where loc_id='$uid' and agreementtype_id='6000'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
  function getdepositr($uid){
  $sql="select locdetil_int as depositr,locdetil_baserent from transaksi_locdetil 
  where loc_id='$uid' and agreementtype_id='7000'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
 function viewconfprint($loc_id){     

     if (isset($loc_id)){
        return $this->db->query("
           select top 1 LOC.loc_id,LOC.conf_id, convert(varchar(10),loc_date,120) AS loc_date, 
              convert(varchar(10),loc_sdate,120) AS loc_sdate, convert(varchar(10),loc_edate,120) AS loc_edate,
              loc_term,
              LOC.branch_id, LOC.rekanan_id, LOC.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,c.rekanancontact_name,
        REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,REKAN.rekanan_address,REKAN.rekanan_city,
        l.lantai_name,u.unit_name,u.unit_sqm,d.locdetil_baserent
        
           from transaksi_loc AS LOC 
       JOIN transaksi_locdetil d on LOC.loc_id=d.loc_id
       JOIN master_branch as branch on branch.branch_id=LOC.branch_id
              JOIN master_rekanan AS REKAN ON LOC.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOC.rekanan_id = BRAND.rekanan_id AND LOC.rekananshipping_line = BRAND.rekananshipping_line
        JOIN master_rekanancontact as c on c.rekanan_id=LOC.rekanan_id
        JOIN master_unit u on u.unit_id=d.unit_id
        JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOC.loc_id='$loc_id'
       ")->result();        
   }

 }

 function get_header($id){

    $qry= " SELECT *
            FROM transaksi_loo
            WHERE loo_id = '{$id}' ";

    return $this->db->query($qry)->result_array();   
 }

 function get_detil($id){

    $qry= " SELECT LOO.*, ATYPE.agreementtype_name, UNIT.unit_name
            FROM transaksi_loodetil LOO
              JOIN master_agreementtype ATYPE ON LOO.agreementtype_id = ATYPE.agreementtype_id
              JOIN master_unit UNIT ON LOO.unit_id = UNIT.unit_id
            WHERE LOO.loo_id = '{$id}' ";

    return $this->db->query($qry)->result_array();   
 }    

  function get_unit($id){

    $qry= " SELECT LOO.*, UNIT.unit_name, UNIT.unit_sqm
            FROM transaksi_loounit LOO
              JOIN master_unit UNIT ON LOO.unit_id = UNIT.unit_id
            WHERE loo_id = '{$id}' ";            

    return $this->db->query($qry)->result_array();   
  }    
    
}
