<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_locreceived extends CI_Model{
    
    function __construct(){
        parent::__construct();
		check_user_login();
    }
    function m_actsave(){
		$vusername=$this->session->userdata('user_fullname');
		$loc_id=$this->input->post('loc_id');
		$loc_no=$this->input->post('loc_id');
		//echo var_dump($_POST);exit;
		$loc_processdate=$this->input->post('loc_procesdate');
		$loc_isprocess=$this->input->post('ckproses');
		if ($loc_isprocess=='1'){
			$loc_processby=$vusername;
		}else{
			$loc_processby="";
		}
		$loc_sentdate=$this->input->post('loc_sentdate');
		$loc_issent=$this->input->post('cksent');
		if ($loc_issent=='1'){
		$loc_sentby=$vusername;
		}else{
			$loc_sentby="";
		}
		
		
		$loc_receivedate=$this->input->post('loc_recivedate');
		$loc_isreceived=$this->input->post('ckreceive');
		if ($loc_isreceived=='1'){
			$loc_receivedby=$vusername;
		}else{
			$loc_receivedby="";
		}
		
		$loc_signeddate=$this->input->post('loc_signeddate');
		$loc_issigned=$this->input->post('cksigned');
		
		if ($loc_issigned=='1'){
			$loc_signedby=$vusername;
		}else{
			$loc_signedby="";
		}
		$query = "INSERT INTO transaksi_locreceived
		(loc_id,loc_no,loc_processby,loc_processdate,loc_isprocess,loc_sentby
		,loc_sentdate,loc_issent,loc_receivedby,loc_receivedate,loc_isreceived
		,loc_signedby,loc_signeddate,loc_issigned) values('$loc_id','$loc_no','$loc_processby','$loc_processdate','$loc_isprocess','$loc_sentby'
		,'$loc_sentdate','$loc_issent','$loc_receivedby','$loc_receivedate','$loc_isreceived'
		,'$loc_signedby','$loc_signeddate','$loc_issigned')";
		//echo $query;exit;
		$this->db->query($query);
			}
	
	function queryTableGrid()
	{
		return "(SELECT A.*,B.region_nameshort,C.branch_name,D.rekanan_name,E.rekananshipping_name
		FROM transaksi_locreceived A  
		LEFT JOIN transaksi_loc F on A.loc_id = F.loc_id
		LEFT JOIN master_region B ON F.region_id = B.region_id 
		LEFT JOIN master_branch C on F.branch_id = C.branch_id
		LEFT JOIN master_rekanan D on F.rekanan_id = D.rekanan_id
		LEFT JOIN master_rekananshipping E on F.rekanan_id = E.rekanan_id AND F.rekananshipping_line = E.rekananshipping_line) TMP";
	}
	function m_actedit(){
		$vusername=$this->session->userdata('username');
		$loc_id=$this->input->post('loc_id');
		$loc_no=$this->input->post('loc_id');
		
		$loc_processdate=$this->input->post('loc_procesdate');
		$loc_isprocess=$this->input->post('ckproses');
		if ($loc_isprocess=='1'){
			$loc_processby=$vusername;
		}else{
			$loc_processby="";
		}
		$loc_sentdate=$this->input->post('loc_sentdate');
		$loc_issent=$this->input->post('cksent');
		if ($loc_issent=='1'){
		$loc_sentby=$vusername;
		}else{
			$loc_sentby="";
		}
		
		
		$loc_receivedate=$this->input->post('loc_recivedate');
		$loc_isreceived=$this->input->post('ckreceive');
		if ($loc_isreceived=='1'){
			$loc_receivedby=$vusername;
		}else{
			$loc_receivedby="";
		}
		
		$loc_signeddate=$this->input->post('loc_signeddate');
		$loc_issigned=$this->input->post('cksigned');
		
		if ($loc_issigned=='1'){
			$loc_signedby=$vusername;
		}else{
			$loc_signedby="";
		}

		$this->db->query("update transaksi_locreceived set 					
loc_no='$loc_no',loc_processby='$loc_processby',loc_processdate='$loc_processdate',
loc_isprocess='$loc_isprocess',loc_sentby='$loc_sentby',loc_sentdate='$loc_sentdate',
loc_issent='$loc_issent',loc_receivedby='$loc_receivedby',
loc_receivedate='$loc_receivedate',loc_isreceived='$loc_isreceived',loc_signedby='$loc_signedby',
loc_signeddate='$loc_signeddate',loc_issigned='$loc_issigned'
where loc_id='$loc_id'");
	}
	
	
	public function get_data_dialog_loc($search='')
	{
		$where = '';
		if($search != '')
		{ 
			$where = " AND (a.loc_id LIKE '%$search%' OR d.branch_name LIKE '%$search%' OR e.rekanan_name LIKE '%$search%' OR f.rekananshipping_name LIKE '%$search%' )";	
		}
		
		$query = $this->db->query("
		SELECT distinct a.loc_id,c.region_nameshort,d.branch_name,e.rekanan_name,f.rekananshipping_name
		FROM transaksi_loc a INNER JOIN master_rekanan e on a.rekanan_id = e.rekanan_id
		LEFT JOIN master_rekananshipping f on a.rekanan_id  = f.rekanan_id and a.rekananshipping_line = f.rekananshipping_line
		LEFT JOIN master_region c on a.region_id = c.region_id
		LEFT JOIN master_branch d on a.branch_id = d.branch_id
		WHERE a.loc_id NOT IN (SELECT loc_id FROM transaksi_locreceived)
		$where");  
	
		
        $result =$query->result_array();
		
        if ($result ) 
        {
            return $result ;
        } 
        else 
        {
            return array();
        }
	}
	
	public function get_data_dialog_loc_rows($search='')
	{
		$where = '';
		if($search != '')
		{
			$search = strip_tags($search);
			$where = " AND (d.branch_name LIKE '%$search%' OR e.rekanan_name LIKE '%$search%' OR f.rekananshipping_name LIKE '%$search%' )";	
		}
		
		$query = $this->db->query("
		SELECT COUNT(a.loc_id) AS jml 
		FROM transaksi_loc a INNER JOIN master_rekanan e on a.rekanan_id = e.rekanan_id
		LEFT JOIN master_rekananshipping f on a.rekanan_id  = f.rekanan_id and a.rekananshipping_line = f.rekananshipping_line
		LEFT JOIN master_region c on a.region_id = c.region_id
		LEFT JOIN master_branch d on a.branch_id = d.branch_id
		WHERE a.loc_id NOT IN (SELECT loc_id FROM transaksi_locreceived)
		$where");  
		 
        $result =$query->row_array();
		$vresult=$result['jml'];
        if ($result ) 
        {
           return $vresult ;
        } 
        else 
        {
            return array();
        }
		 
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
    // $sWhere = empty($sWhere) ? " WHERE unittype_id = 6 and isdisabled = 0 " : $sWhere." AND isdisabled = 0 and unittype_id = 6 ";
 
	   $qry=" 
		SELECT * FROM (
		SELECT top $limit ROW_NUMBER() OVER (ORDER BY CTE.loc_id) as RowNumber
		,CTE.loc_id
		,CTE.loc_no
		,CTE.loc_processby
		,CTE.loc_processdate
		,CTE.loc_isprocess
		,CTE.loc_sentby
		,CTE.loc_sentdate
		,CTE.loc_issent
		,CTE.loc_receivedby
		,CTE.loc_receivedate
		,CTE.loc_isreceived
		,CTE.loc_signedby
		,CTE.loc_signeddate
		,CTE.loc_issigned
		,c.region_nameshort,d.branch_name,e.rekanan_name,f.rekananshipping_name 
		FROM transaksi_locreceived CTE 
		inner join transaksi_loc a on a.loc_id=CTE.loc_id 
		INNER JOIN master_rekanan e on a.rekanan_id = e.rekanan_id 
		LEFT JOIN master_rekananshipping f on a.rekanan_id = f.rekanan_id and a.rekananshipping_line = f.rekananshipping_line 
		LEFT JOIN master_region c on a.region_id = c.region_id LEFT JOIN master_branch d on a.branch_id = d.branch_id 
		$sWhere
		) AS V 
		where RowNumber > $top";
	// echo $top."<br/>";
	// echo $limit;
	   return $this->db->query($qry)->result_array();	   
   }
   
    function qry_alldatalist_2($search){
    // $sWhere = empty($sWhere) ? " WHERE unittype_id = 6 and isdisabled = 0 " : $sWhere." AND isdisabled = 0 and unittype_id = 6 ";
		$search = urldecode($search); 
		//echo "-->".$search;
		 if (trim($search) != '' )
		 {
			 $where =  " WHERE CTE.loc_id like '%$search%' or  d.branch_name like '%$search%'  or e.rekanan_name like '%$search%' or f.rekananshipping_name like '%$search%' ";
		 }
		 else
		 { $where = '';}
	   $qry="
		SELECT CTE.*,ROW_NUMBER() OVER (ORDER BY CTE.loc_id desc) as RowNumber ,a.loc_id,c.region_nameshort,d.branch_name,e.rekanan_name,f.rekananshipping_name
    	FROM transaksi_locreceived as CTE inner join transaksi_loc a on a.loc_id=CTE.loc_id
		INNER JOIN master_rekanan e on a.rekanan_id = e.rekanan_id
		LEFT JOIN master_rekananshipping f on a.rekanan_id  = f.rekanan_id and a.rekananshipping_line = f.rekananshipping_line
		LEFT JOIN master_region c on a.region_id = c.region_id
		LEFT JOIN master_branch d on a.branch_id = d.branch_id
		$where";
	
	
	   return $this->db->query($qry)->result_array();	   
   }
   
    function qry_filteredlist($sWhere){
    // $sWhere = empty($sWhere) ? " WHERE isdisabled = 0 and unittype_id = 6" : $sWhere." AND isdisabled = 0 and unittype_id = 6";
	   $qry="select count(loc_id) as jml from transaksi_locreceived";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalllist(){
	   $qry="select count(loc_id) as jml from transaksi_locreceived";
		return $this->db->query($qry)->row_array();
	   
   }
   
    function insertloo($loc_date, $loc_sdate, $loc_edate, $loc_term, $_createby, $_modifyby, $lease,
        $loc_line,$unit_id,$agrtype_id,$loc_baserent, $tenant, $brand, $int, $timetype, $loc_descr,$r_id,$region, $skl_id, $descr, 
        $isper, $percent, $u_line, $u_unit, $u_size, $u_lantai,$ismulti,$loc_rent_desc,$Objregion_id,$Objbranch_id,$unittype_id,$usdate,$uedate,$branch_inject,
        $d_Region, $d_Branch, $d_Start, $d_End)
    {

		    //echo $branch_inject;exit;		
        $datetime1 = date_create($loc_sdate);
        $datetime2 = date_create($loc_edate);
        $interval = date_diff($datetime1, $datetime2);

        $loc_term = $interval->m + ($interval->y * 12);

        $timestamp = time();
		
        $loc_id = gen_id_loo($region,'LOO','sequencer_loo', $r_id, $timestamp);
		    $loc_id_temp = gen_id_loc_temp($region,'TMP','sequencer_loo', $r_id, $timestamp);
		 
		
        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     
        $check = $this->db->query("
                 insert into transaksi_loc
                     (loc_id, loc_date, loc_sdate, loc_edate, loc_term, _createby, _createdate, _modifyby, _modifydate, region_id , branch_id, rekanan_id, rekananshipping_line, loc_type, loc_descr, skl_id,ismulti,loc_rent_desc,conf_id,unittype_id)
                 values
                     ('$loc_id','$loc_date', '$loc_sdate', '$loc_edate', $loc_term,'$_createby','$now','$_modifyby','$now','$region','$branch_inject',
                      '$tenant', '$brand', '$lease', '$loc_descr','$skl_id',$ismulti,'$loc_rent_desc','$loc_id_temp','$unittype_id')");     
			
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
          $t_Region     = $d_Region[$key];
          $t_Branch     = $d_Branch[$key];
          $t_Start      = $d_Start[$key];
          $t_End        = $d_End[$key];

          $t_sdate = date_create($t_Start);
          $t_edate = date_create($t_End);
          $t_inter = date_diff($t_sdate, $t_edate);

          $t_term = $t_inter->m + ($t_inter->y * 12);

        	$this->db->query("
             insert into transaksi_locdetil
                 (loc_id, loodetil_line, loodetil_baserent, agreementtype_id, unit_id, loodetil_int, timetype_id, loodetil_descr, loodetil_ispercent, loodetil_percent, region_id, branch_id, rekanan_id, rekananshipping_line, loodetil_sdate, loodetil_edate, loodetil_term )
             values
                 ('$loc_id', $t_line, $t_baserent, '$t_agrtype', '$t_unit', $t_int, '$t_timet', '$t_descr', $t_isper, 
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
          $u_inter = date_diff($u_sdate, $u_edate);

          $u_term = $u_inter->m + ($u_inter->y * 12);

          $this->db->query("
                insert into transaksi_locunit
                    ( loc_id, loounit_line, loounit_space, unit_id, lantai_id,region_id,branch_id,loounit_sdate,loounit_edate,rekanan_id,rekananshipping_line, loounit_term )
                values
                  ( '$loc_id', $_line, $_size, '$_unit', '$_lantai','$_region_id','$_branch_id','$_startdate','$_enddate','$tenant', '$brand', $u_term )");          

          $this->db->query(" UPDATE master_unit SET unit_state = 1 WHERE unit_id='$t_unit' and region_id='$_region_id' and branch_id='$_branch_id' "); 
  			}
			
			return $loc_id;
			  
    }

  function sholdetilby_id($id){          
        $sql = "
         SELECT LD.*, UNIT.unit_name AS unit_name, AT.agreementtype_name AS agreementtype_name 
          FROM transaksi_locdetil LD 
          LEFT JOIN transaksi_loc LH ON LH.loc_id = LD.loc_id		
           LEFT JOIN transaksi_locunit LOU ON LH.loc_id = LOU.loc_id  and LOU.unit_id = LD.unit_id
          LEFT JOIN master_unit UNIT ON UNIT.unit_id = LD.unit_id AND UNIT.region_id = LOU.region_id AND UNIT.branch_id = LOU.branch_id 
          LEFT JOIN master_agreementtype AT ON AT.agreementtype_id = LD.agreementtype_id 
			
          WHERE LD.loc_id = '$id'
          ORDER BY  loc_id, loodetil_line ASC";  
    return $this->db->query($sql)->result();      
  }

  function vdetilunitby_id($id){          
        $sql = "
          SELECT LU.*, UNIT.unit_name AS unit_name, LT.lantai_name AS lantai_name,RG.region_name,BR.branch_name,LU.loounit_sdate,LU.loounit_edate
          FROM transaksi_locunit LU 
            LEFT JOIN transaksi_loc LH ON LH.loc_id = LU.loc_id
            LEFT JOIN master_unit UNIT ON UNIT.unit_id = LU.unit_id AND UNIT.region_id = LU.region_id AND UNIT.branch_id = LU.branch_id
            LEFT JOIN master_lantai LT ON LT.lantai_id = LU.lantai_id
			LEFT JOIN master_branch BR ON LU.branch_id = BR.branch_id
			LEFT JOIN master_region RG ON LU.region_id = RG.region_id
          WHERE LU.loc_id = '$id'";  
    return $this->db->query($sql)->result();      
  }
		    
  function updateloo($loc_id ,$loc_date, $loc_sdate, $loc_edate, $loc_term, $_createby, $_modifyby, 
                $lease, $loc_line,$unit_id,$agrtype_id,$loc_baserent, $tenant, $brand, $int, $timetype, $loc_descr,$region , 
                $skl_id, $descr, $_ispercent, $loc_percent, $u_line, $u_unit, $u_size, $u_lantai,$ismulti,$loc_rent_desc,
                $Objregion_id,$Objbranch_id,$unittype_id,$conf_id,$isapprove,$usdate,$uedate,$branch_inject, 
                $d_Region, $d_Branch, $d_Start, $d_End,$vObjregion_id,$vObjbranch_id)
  {

        $datetime1 = date_create($loc_sdate);
        $datetime2 = date_create($loc_edate);
        $interval = date_diff($datetime1, $datetime2);

        $loc_term = $interval->m + ($interval->y * 12);

  		  $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);  
		if($isapprove != 1)
		{
			$syntax = "
            update transaksi_loc
            set loc_date 			= '$loc_date', 
          			loc_descr 				= '$loc_descr', 
          			loc_sdate 				= '$loc_sdate', 
          			loc_edate 				= '$loc_edate', 
          			_createby 				= '$_createby', 
          			loc_term 				= $loc_term,
          			_modifyby 				= '$_modifyby', 
          			_modifydate 			= '$now', 
          			rekanan_id 				= '$tenant', 
          			rekananshipping_line 	= '$brand',  
          			ismulti 				= $ismulti,
          			loc_rent_desc			= '$loc_rent_desc'
            where conf_id 			= '$conf_id'"; 
			
			$check=$this->db->query($syntax );	 
		}
		else{
			$check=$this->db->query("
            update transaksi_loc
            set loc_date 			= '$loc_date', 
			loc_descr 				= '$loc_descr', 
			loc_sdate 				= '$loc_sdate', 
			loc_edate 				= '$loc_edate', 
			_createby 				= '$_createby', 
			loc_term 				= $loc_term,
			_modifyby 				= '$_modifyby', 
			_modifydate 			= '$now', 
			rekanan_id 				= '$tenant', 
			rekananshipping_line 	= '$brand',  
			ismulti 				= $ismulti,
			loc_rent_desc			= '$loc_rent_desc'
            where loc_id = '$loc_id'
        ");	  
		}
       
 
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
            $t_isper      = ($_ispercent[$key]) ? 1 : 0;
            $t_percent    = $loc_percent[$key];
            $t_Region     = $d_Region[$key];
            $t_Branch     = $d_Branch[$key];
            $t_Start      = $d_Start[$key];
            $t_End        = $d_End[$key];

            $t_sdate = date_create($t_Start);
            $t_edate = date_create($t_End);
            $t_inter = date_diff($t_sdate, $t_edate);

            $t_term = $t_inter->m + ($t_inter->y * 12);
            

            $this->db->query("
             insert into transaksi_locdetil
                 (loc_id, loodetil_line, loodetil_baserent, agreementtype_id, unit_id, loodetil_int, timetype_id, loodetil_descr, loodetil_ispercent, loodetil_percent,
                  region_id, branch_id, rekanan_id, rekananshipping_line, loodetil_sdate, loodetil_edate, loodetil_term )
             values
                 ('$loc_id', $t_line, $t_baserent, '$t_agrtype', '$t_unit', $t_int, '$t_timetype', '$t_descr', $t_isper, $t_percent,
                 '$t_Region', '$t_Branch', '$tenant', '$brand', '$t_Start', '$t_End', $t_term )");
          }

          $this->db->query("delete from transaksi_locunit where loc_id='$loc_id'");  

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
        $u_inter = date_diff($u_sdate, $u_edate);

        $u_term = $u_inter->m + ($u_inter->y * 12);
			   
			  $this->db->query("
					insert into transaksi_locunit
						( loc_id, loounit_line, loounit_space, unit_id, lantai_id,region_id,branch_id,loounit_sdate,loounit_edate,rekanan_id,rekananshipping_line, loounit_term )
					values
					  ( '$loc_id', $_line, $_size, '$_unit', '$_lantai','$_region_id','$_branch_id','$_startdate','$_enddate','$tenant', '$brand', $u_term)");

			  $this->db->query(" UPDATE master_unit SET unit_state = 1 WHERE unit_id='$t_unit' and region_id='$_region_id' and branch_id='$_branch_id' "); 
				
            }
        }                  
  }
	
  function deleteloo($loc_id){
    
    $this->db->query(" UPDATE transaksi_loc SET isdisabled = '1' WHERE loc_id = '$loc_id' ");

    $u_sql = "
              SELECT DISTINCT region_id, branch_id, unit_id 
              FROM transaksi_locdetil AS A inner join transaksi_loc AS B ON A.loc_id = B.loc_id
              WHERE A.loc_id = '$loc_id' ";

    $q_uid = $this->db->query($u_sql)->result_array();

    foreach($q_uid as $uid){

      $unit_id = $uid['unit_id'];
      $this->db->query("UPDATE master_unit SET unit_state = 2 WHERE unit_id='$unit_id' AND region_id = $region_id AND branch_id = $branch_id");

    } 
		//$this->db->query("delete from transaksi_loc where loc_id='$loc_id'");
		//$this->db->query("delete from transaksi_locdetil where loc_id='$loc_id'");
    //$this->db->query("delete from transaksi_locunit where loc_id='$loc_id'");
	}
    
  function viewloo($loc_id){     

     if (isset($loc_id)){
        return $this->db->query("
           select * from transaksi_locreceived
           where loc_id='$loc_id' 
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
   
  function viewlooprint($loc_id){     

     if (isset($loc_id)){
        return $this->db->query("
           select top 1 LOO.loc_id, convert(varchar(10),loc_date,120) AS loc_date, 
              convert(varchar(10),loc_sdate,120) AS loc_sdate, convert(varchar(10),loc_edate,120) AS loc_edate,
              loc_term,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,c.rekanancontact_name,
			  REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,l.lantai_name,u.unit_name,u.unit_sqm,d.loodetil_baserent
			  
           from transaksi_loc AS LOO 
		   JOIN transaksi_locdetil d on LOO.loc_id=d.loc_id
		   JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
			  JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
			  JOIN master_unit u on u.unit_id=d.unit_id
			  JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOO.loc_id='$loc_id'
       ")->result();        
	 }

   }
 
  function confirmloo($arrCon){   

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

  function approveloo($arrapp){   

    $action = "approve";   

     if (is_array($arrapp)){
       if (count($arrapp) >0){
          foreach ($arrapp as $key){       

            $loc_id = $key[0];
            $region_id = $key[1];
            $branch_id = $key[2];

            $this->db->trans_begin();
          
            $this->db->query(" UPDATE transaksi_loc SET ispenawaran = '1' WHERE conf_id = '$loc_id' ");

/*
            $u_sql = " SELECT DISTINCT unit_id FROM transaksi_locdetil WHERE loc_id = '$loc_id' ";

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
          FROM transaksi_loc LOH
            JOIN transaksi_locdetil LOD ON LOH.loc_id = LOD.loc_id
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
		 (CASE LOH.isapproved when 1 then LOH.loc_id else LOH.conf_id END) as [loc_id]
      ,LOH.[loc_descr]
      ,LOH.[loc_date]
      ,LOH.[loc_sdate]
      ,LOH.[loc_edate]
      ,LOH.[loc_term]
      ,LOH.[loc_type]
      ,LOH.[loc_pict]
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
      ,LOH.[loc_rent_desc]
      ,LOH.[ispenawaran], 
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
          WHERE LOH.ispenawaran = '0' AND UNIT.unit_state <> '2' AND LOH.unittype_id = 6 AND LOD.unit_id like '%{$uid}%'";

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
    
  function getunitloo($uid){
  $sql="select distinct c.unit_name,c.unit_sqm from dbo.transaksi_locdetil a
     inner join transaksi_loc b on a.loc_id=b.loc_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.loc_id='$uid' and a.agreementtype_id='4000'";  
     return $this->db->query($sql)->result(); 
 }
 
  function gethargasewa($uid){
  $sql="select  a.loodetil_descr+' (' +c.unit_name+' )' as titleharga,a.loodetil_baserent  from dbo.transaksi_locdetil a
     inner join transaksi_loc b on a.loc_id=b.loc_id
     inner join master_unit c on b.branch_id=c.branch_id and c.unit_id=a.unit_id
     where a.loc_id='$uid' and a.agreementtype_id='4000' order by a.unit_id,a.loodetil_line asc"; 
    return $this->db->query($sql)->result(); 
 }
 
  function getservicecharge($uid){
  $sql="select SUM(loodetil_baserent) as servicecharge from transaksi_locdetil 
  where loc_id='$uid' and agreementtype_id='5000'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
  function getpromolevy($uid){
  $sql="select SUM(loodetil_baserent) as promolevy from transaksi_locdetil 
  where loc_id='$uid' and agreementtype_id='6000'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
  function getdepositr($uid){
  $sql="select loodetil_int as depositr,loodetil_baserent from transaksi_locdetil 
  where loc_id='$uid' and agreementtype_id='7000'"; 
  return $this->db->query($sql)->row_array(); 
 }
 
 function viewconfprint($loc_id){     

     if (isset($loc_id)){
        return $this->db->query("
           select top 1 LOO.loc_id,LOO.conf_id, convert(varchar(10),loc_date,120) AS loc_date, 
              convert(varchar(10),loc_sdate,120) AS loc_sdate, convert(varchar(10),loc_edate,120) AS loc_edate,
              loc_term,
              LOO.branch_id, LOO.rekanan_id, LOO.rekananshipping_line, REKAN.rekanan_name, BRAND.rekananshipping_name,c.rekanancontact_name,
        REKAN.rekanan_telp,REKAN.rekanan_email,branch.branch_name,REKAN.rekanan_address,REKAN.rekanan_city,
        l.lantai_name,u.unit_name,u.unit_sqm,d.loodetil_baserent
        
           from transaksi_loc AS LOO 
       JOIN transaksi_locdetil d on LOO.loc_id=d.loc_id
       JOIN master_branch as branch on branch.branch_id=LOO.branch_id
              JOIN master_rekanan AS REKAN ON LOO.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON LOO.rekanan_id = BRAND.rekanan_id AND LOO.rekananshipping_line = BRAND.rekananshipping_line
        JOIN master_rekanancontact as c on c.rekanan_id=LOO.rekanan_id
        JOIN master_unit u on u.unit_id=d.unit_id
        JOIN master_lantai l on l.lantai_id=u.lantai_id
           where LOO.loc_id='$loc_id'
       ")->result();        
   }

 }
    
    function get_branch_dlg($region_id='')
	{ 
        $this->db->select('r.branch_id, branch_name');
        $this->db->from('master_regionbranch r');
        $this->db->join('master_branch b', 'r.branch_id = b.branch_id');
		if($region_id != '')
		{  
			$this->db->where('r.region_id', $region_id); 
		}
        $query = $this->db->get();

        $result = $query->result();
		 $ret ['']= 'Pilih Store :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->branch_id] = $row->branch_name;
            }
        }
        
        return $ret; 
    }

  function deleteLOI($uid)
  {
	   $uid = str_replace('_', '/', $uid); 
	  $query = "delete from transaksi_locreceived where loc_id = '$uid'";
	
	 $this->db->query($query);  
  }
}