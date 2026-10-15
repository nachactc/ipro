<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_loocasual extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
     function get_unit(){
        
/*
        $this->db->select('unit_id, unit_name');
        $query = $this->db->get('master_unit');  
        return $query->result();*/
		
		return $this->db->query("SELECT unit_id,unit_name FROM master_unit")->result();
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
	// echo var_dump($sWhere);

     $sWhere = empty($sWhere) ? " WHERE isdisabled = 0 AND unittype_id <> 7 AND unittype_id <> 6 and CTE.iscasual=1" : $sWhere." AND isdisabled = 0 AND unittype_id <> 7 AND unittype_id <> 6 and CTE.iscasual=1";

	   $qry=" 
			SELECT * FROM (
			select top $limit CTE.*,ROW_NUMBER() OVER (ORDER BY _createdate desc) as RowNumber, 
						   REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name,t.agreement_id
			  FROM transaksi_loo AS CTE       
			  JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
			  JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
			  JOIN master_rekanan AS REKAN ON CTE.rekanan_id = REKAN.rekanan_id
			  JOIN master_rekananshipping AS BRAND ON CTE.rekanan_id = BRAND.rekanan_id AND CTE.rekananshipping_line = BRAND.rekananshipping_line
			  LEFT JOIN transaksi_agreementtemp t on t.agreement_loonumber=CTE.loo_id
			  $sWhere 
			  ORDER BY CTE._createdate DESC
			  ) AS V
    	WHERE   RowNumber > $top";
      //echo $qry;
	   //exit;
	    return $this->db->query($qry)->result_array();
   }
   
    function qry_filteredlist($sWhere){
       $sWhere = empty($sWhere) ? " WHERE isdisabled = 0 AND unittype_id <> 7 AND unittype_id <> 6 and iscasual=1" : $sWhere." AND isdisabled = 0 AND unittype_id <> 7 AND unittype_id <> 6 and iscasual=1";
	   $qry="SELECT count(*) as jml FROM (
			select CTE.*,ROW_NUMBER() OVER (ORDER BY _createdate desc) as RowNumber, 
						   REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name
			  FROM transaksi_loo AS CTE       
			  JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
			  JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
			  JOIN master_rekanan AS REKAN ON CTE.rekanan_id = REKAN.rekanan_id
			  JOIN master_rekananshipping AS BRAND ON CTE.rekanan_id = BRAND.rekanan_id AND CTE.rekananshipping_line = BRAND.rekananshipping_line
			  $sWhere 
			 
			  ) AS V";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalllist(){
	   $qry="select count(loo_id) as jml from transaksi_loo where unittype_id <> 7 AND unittype_id <> 6 and iscasual=1";
		return $this->db->query($qry)->row_array();
	   
   }
   
    function insertloo($loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, $lease,
        $loo_line,$unit_id,$agrtype_id,$loo_baserent, $r_id, $tenant, $brand, $int, $timetype, $loo_descr, $unit_type, $skl_id, $descr,
        $isper, $percent, $u_line, $u_unit, $u_size, $u_lantai, $d_region, $d_branch, $d_tenant, $d_brand, 
        $u_region, $u_branch, $u_tenant, $u_brand, $product_name,$fitting_out,$grace_period,$size_indoor,$size_outdoor, 
		$debtor_no,$totsize,$tpayment,$chklump,$tmonthly)
    {


        $datetime1 =$loo_sdate;
        $datetime2 = $loo_edate;
		//$datetime2->modify('+1 day');
      //  $interval = date_diff($datetime1, $datetime2);
		

        //$loo_term = $interval->m + ($interval->y * 12);
		
		$qryx="select datediff(day,'$datetime1','$datetime2') as tottgl";
		$rqx=$this->db->query($qryx)->row_array();
		$loo_term = $rqx['tottgl']+1;

        $timestamp = time();		   

        $loo_id = gen_id_loo($region,'LOO','sequencer_loo', $r_id, $timestamp);

        $virtual_account = get_va($debtor_no);        

        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     
        $check = $this->db->query("
                 insert into transaksi_loo
                     (loo_id, loo_date, loo_sdate, loo_edate, loo_term, _createby, _createdate,  region_id , branch_id, rekanan_id, rekananshipping_line, loo_type, loo_descr, skl_id, unittype_id, product_name,fitting_out,grace_period,size_indoor,size_outdoor, debtor_no, virtual_acc,total_size,total_payment,iscasual )
                 values
                     ('$loo_id','$loo_date', '$loo_sdate', '$loo_edate', $loo_term,'$_createby','$now','$region','$branch',
                      '$tenant', '$brand', $lease, '$loo_descr','$skl_id', '$unit_type', '$product_name',$fitting_out,$grace_period,$size_indoor,$size_outdoor,
                      '$debtor_no', '$virtual_account','0','$tpayment','1' )");     
			
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
		  if (isset($chklump[$key])){
		  	$vchklump = $chklump[$key];
		  }else{
			 $vchklump=0;
		  }
		  
		  $vtmonthly =$tmonthly[$key];
		  

        	$this->db->query("
             insert into transaksi_loodetil
                 (loo_id, loodetil_line, loodetil_baserent, agreementtype_id, unit_id, loodetil_int, timetype_id, loodetil_descr, loodetil_ispercent, loodetil_percent, region_id, branch_id, rekanan_id, rekananshipping_line,loodetil_sdate,loodetil_edate,loodetil_term,loodetil_islumpsum,loodetil_mia)
             values
                 ('$loo_id', $t_line, $t_baserent, '$t_agrtype', '$t_unit', $t_int, '$t_timet', '$t_descr', $t_isper, 
                  $t_percent, '$region', '$branch','$tenant', '$brand', '$loo_sdate', '$loo_edate','$loo_term','$vchklump','$vtmonthly' )");
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

$_size=str_replace(",","",$_size);
          $this->db->query("
                insert into transaksi_loounit
                    ( loo_id, loounit_line, loounit_space, unit_id, lantai_id, region_id, branch_id, rekanan_id, rekananshipping_line, loounit_sdate, loounit_edate, loounit_term )
                values
                  ( '$loo_id', $_line, $_size, '$_unit', '$_lantai', '$_region', '$_branch', '$tenant', '$brand', '$loo_sdate', '$loo_edate', $loo_term  )");          

          $this->db->query(" UPDATE master_unit SET unit_state = 1 WHERE unit_id='$t_unit' and region_id='$region' and branch_id='$branch' "); 
  			}
			
			
$rsq=$this->db->query("select b.loodetil_int,c.loounit_space,b.loodetil_baserent,b.loodetil_islumpsum,b.loodetil_line from transaksi_loo a inner join transaksi_loodetil b on a.loo_id=b.loo_id
inner join transaksi_loounit c on a.loo_id=c.loo_id and c.unit_id=b.unit_id
where a.loo_id='$loo_id'")->result();
foreach($rsq as $row){ 
	$vlum=$row->loodetil_islumpsum;
	$vmia=0;
	$vint=$row->loodetil_int;
	$vspace=$row->loounit_space;
	$vbaserent=$row->loodetil_baserent;
	$vline=$row->loodetil_line;
	if ($vlum<>1){
		$vmia=$vint*$vspace*$vbaserent;
		$this->db->query("update transaksi_loodetil set loodetil_mia='$vmia' where loo_id='$loo_id' and loodetil_line='$vline'");
		/*echo "islum"."".$vlum;echo "<br>";
		
		echo "space"."".$vspace;echo "<br>";
		echo "interval"."".$vint;echo "<br>";
		echo "baserent"."".$vbaserent;echo "<br>";
		
		echo "hasil"."".$vmia;echo "<br>";
		echo "line"."".$vline;*/
	}

}
		
	  
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
		    
	function updateloo($loo_id, $loo_date, $loo_descr, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, 
        $lease, $loo_line,$unit_id,$agrtype_id,$loo_baserent, $tenant, $brand, $int, $timetype, $descr, $isper, $percent,
        $u_line, $u_unit, $u_size, $u_lantai, $unit_type, $skl_id, $d_region, $d_branch, $d_tenant, $d_brand, 
        $u_region, $u_branch, $u_tenant, $u_brand, $product_name,$fitting_out,$grace_period,$size_indoor,$size_outdoor,$debtor_no,$tpayment,$chklump,$tmonthly ){        

        $datetime1 = date_create($loo_sdate);
        $datetime2 = date_create($loo_edate);		
		    $datetime2->modify('+1 day');


        $interval = date_diff($datetime1, $datetime2);
        $loo_term = $interval->m + ($interval->y * 12);

        $virtual_account = get_va($debtor_no);
 
  		  $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     
        $check=$this->db->query("
            update transaksi_loo
            set loo_date = '$loo_date', loo_descr = '$loo_descr', loo_sdate = '$loo_sdate', loo_edate = '$loo_edate', loo_term = $loo_term,
                _modifyby = '$_modifyby', _modifydate = '$now', region_id = '$region' , branch_id = '$branch',
                rekanan_id = '$tenant', rekananshipping_line = '$brand', 
				        loo_type = $lease, unittype_id = '$unit_type',
				        product_name= '$product_name',fitting_out=$fitting_out,grace_period=$grace_period,size_indoor=$size_indoor,size_outdoor = $size_outdoor,
                debtor_no = '$debtor_no', virtual_acc = '$virtual_account',total_payment='$tpayment'
            where loo_id = '$loo_id'
        ");	    


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
            $t_isper      = ($isper[$key]) ? 1 : 0;
            $t_percent    = $percent[$key];
            $t_region     = $d_region[$key];
            $t_branch     = $d_branch[$key];
            $t_tenant     = $d_tenant[$key];
            $t_brand      = $d_brand[$key];
			
			 if (isset($chklump[$key])){
		  	$vchklump = $chklump[$key];
		  }else{
			 $vchklump=0;
		  }
		  
		  $vtmonthly =$tmonthly[$key];

            $this->db->query("
             insert into transaksi_loodetil
                 (loo_id, loodetil_line, loodetil_baserent, agreementtype_id, unit_id, loodetil_int, timetype_id, loodetil_descr, loodetil_ispercent, loodetil_percent, region_id, branch_id, rekanan_id, rekananshipping_line, loodetil_sdate, loodetil_edate, loodetil_term,loodetil_islumpsum,loodetil_mia )
             values
                 ('$loo_id', $t_line, $t_baserent, '$t_agrtype', '$t_unit', $t_int, '$t_timetype', '$t_descr', $t_isper, $t_percent, 
                  '$t_region', '$t_branch', '$tenant', '$brand', '$loo_sdate', '$loo_edate', $loo_term,'$vchklump','$vtmonthly' )");
          }

          $this->db->query("delete from transaksi_loounit where loo_id='$loo_id'");  

          foreach($u_line as $key => $n){

            $_line       = $u_line[$key];
            $_unit       = $u_unit[$key];
            $_size       = $u_size[$key];
            $_lantai     = $u_lantai[$key];
            $_region     = $u_region[$key];
            $_branch     = $u_branch[$key];
            $_tenant     = $u_tenant[$key];
            $_brand       = $u_brand[$key];
$_size=str_replace(",","",$_size);
            $this->db->query("
             insert into transaksi_loounit
                 ( loo_id, loounit_line, loounit_space, unit_id, lantai_id, region_id, branch_id, rekanan_id, rekananshipping_line, 
                  loounit_sdate, loounit_edate, loounit_term )
             values
                 ( '$loo_id', $_line, $_size, '$_unit', '$_lantai', '$_region', '$_branch', '$tenant', '$brand', 
                 '$loo_sdate', '$loo_edate', $loo_term )"); 
          }
          
        }   
		
		$rsq=$this->db->query("select b.loodetil_int,c.loounit_space,b.loodetil_baserent,b.loodetil_islumpsum,b.loodetil_line from transaksi_loo a inner join transaksi_loodetil b on a.loo_id=b.loo_id
inner join transaksi_loounit c on a.loo_id=c.loo_id and c.unit_id=b.unit_id
where a.loo_id='$loo_id'")->result();
foreach($rsq as $row){ 
	$vlum=$row->loodetil_islumpsum;
	$vmia=0;
	$vint=$row->loodetil_int;
	$vspace=$row->loounit_space;
	$vbaserent=$row->loodetil_baserent;
	$vline=$row->loodetil_line;
	if ($vlum<>1){
		$vmia=$vint*$vspace*$vbaserent;
		$this->db->query("update transaksi_loodetil set loodetil_mia='$vmia' where loo_id='$loo_id' and loodetil_line='$vline'");
		/*echo "islum"."".$vlum;echo "<br>";
		
		echo "space"."".$vspace;echo "<br>";
		echo "interval"."".$vint;echo "<br>";
		echo "baserent"."".$vbaserent;echo "<br>";
		
		echo "hasil"."".$vmia;echo "<br>";
		echo "line"."".$vline;*/
	}

}
               
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
    
  function viewloo($loo_id){     

     if (isset($loo_id)){
        return $this->db->query("
           select loo_id, convert(varchar(10),loo_date,120) AS loo_date, loo_type, unittype_id, loo_descr, skl_id,
              convert(varchar(10),loo_sdate,120) AS loo_sdate, convert(varchar(10),loo_edate,120) AS loo_edate,
              loo_term, _createby, _createdate, _modifyby, _modifydate, region_id, isapproved, isconfirm,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name,
			  LOO.product_name,LOO.fitting_out,LOO.grace_period ,LOO.size_indoor ,LOO.size_outdoor, LOO.debtor_no, LOO.virtual_acc,LOO.total_size,LOO.total_payment
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


function approveloocs($arrapp){   

    $action = "approve";   

     if (is_array($arrapp)){
		 $tg= date("Y-m-d");
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
			
			
			//$this->db->trans_begin();		
			$eqloo=$this->db->query("select * from transaksi_loo WHERE loo_id = '$loo_id'")->row_array();
			$loo_term=$eqloo['loo_term'];
			$loo_sdate=$eqloo['loo_sdate'];
			$loo_edate=$eqloo['loo_edate'];
			$loo_term=$eqloo['loo_term'];
			$rekanan_id=$eqloo['rekanan_id'];
			$rekananshipping_line=$eqloo['rekananshipping_line'];
			$virtual_acc=$eqloo['virtual_acc'];
			$debtor_no=$eqloo['debtor_no'];
			$total_size=$eqloo['total_size'];
			
			//$datetime1 = date_create($loo_sdate);
        	//$datetime2 = date_create($loo_edate);
	        //echo $datetime1;
			//exit();
			$datetime1 = $loo_sdate;
        	$datetime2 = $loo_edate;
		$qryx="select datediff(day,'$datetime1','$datetime2') as tottgl";
		$rqx=$this->db->query($qryx)->row_array();
		$loo_term = $rqx['tottgl']+1;
			
			 
			$stored_pocedure = "EXEC lm03_TrnAgreementtemp_Insertipro '','','',0,'$loo_sdate','$loo_edate',0,0,0,'0','0','$loo_term','',0,'','',0,0,0,'System','$tg','System','$tg','TRP','$region_id','$branch_id','$rekanan_id','$rekananshipping_line','0020000','100910',1,0,0,0,'$loo_sdate','$loo_edate','$debtor_no','','$virtual_acc','','$loo_id',''";
			$result = $this->db->query($stored_pocedure)->row_array(); 
			$agid=$result['agreement_id'];

			$rq=$this->db->query("select a.*,b.unit_name,c.loounit_space from transaksi_loodetil a inner join master_unit b on a.unit_id=b.unit_id
			inner join transaksi_loounit c on  c.loo_id=a.loo_id and c.unit_id=a.unit_id WHERE  a.loo_id = '$loo_id'")->result();
			if(isset($rq)){
				foreach($rq as $row){ 
				$vline=$row->loodetil_line;
				$agreementtype_id=$row->agreementtype_id;
				$loodetil_percent=$row->loodetil_percent;
				$loodetil_baserent=$row->loodetil_baserent;
				$unit_name=$row->unit_name;
				$loodetil_mia=$row->loodetil_mia;
				$loodetil_islumpsum=$row->loodetil_islumpsum;
				$unit_id=$row->unit_id;
				$totspace=$row->loounit_space;
				$vloodetil_int=$row->loodetil_int;
				$subtot=$vloodetil_int*$loodetil_baserent*$totspace;
				
if ( (trim($agreementtype_id)=='35100') or (trim($agreementtype_id)=='35000') ){
	$stored_pocedure = "lm03_TrnAgreementps_Insert '$agid','$vline','$agreementtype_id','$loo_sdate','$loo_edate',1,1,'$vloodetil_int','MONTH','$unit_name','$totspace',1,0,0,'$loodetil_mia',0,'0',10,0,0,0,'','','$loodetil_islumpsum','$unit_id'";
				$this->db->query($stored_pocedure);

}else if ( (trim($agreementtype_id)=='7000') or (trim($agreementtype_id)=='7500') or (trim($agreementtype_id)=='8000') or (trim($agreementtype_id)=='11000') or (trim($agreementtype_id)=='7600') or (trim($agreementtype_id)=='7700')){
	$stored_pocedure = "lm03TrnAgreementdeposit_Insert '$agid','$vline','$agreementtype_id','$loo_sdate','$loo_term',1,1,'MONTH',0,'$loodetil_baserent','$subtot',0,0,0,0,'$unit_name','$totspace','$loodetil_islumpsum','$unit_id'";
				$this->db->query($stored_pocedure);

}else {
				$stored_pocedure = "EXEC lm03_TrnAgreementtempdetil_Insertipro '$agid','$vline','$agreementtype_id','$loo_sdate','$loo_edate',0,0,'$loo_term',1,1,'MONTH','$totspace',0,'$loodetil_percent','$loodetil_baserent','0',10,0,'$unit_name','$loodetil_mia','$loodetil_islumpsum','','$unit_id'";
				$rqq=$this->db->query($stored_pocedure)->row_array(); 
				}
				
	
				}
				
				$stored_pocedure = "lm03_TrnAgreementtempdetil_UpdateTLV '$agid'";
				$this->db->query($stored_pocedure); 
				
			}
			
			
	
		       

           if ($this->db->trans_status() === FALSE)
            {         
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
          WHERE LOH.isapproved = '0'  AND LOH.iscasual='1'  
            AND LOD.unit_id like '%{$uid}%' 
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

 function getPassword($id){

  $qry= " SELECT A.*, B.agreementtype_name
          FROM master_sklterm A inner join master_agreementtype B ON A.skl_atype = B.agreementtype_id
          WHERE A.skl_id = '{$id}' ";

  return $this->db->query($qry)->result_array();   
 }     
    
}
