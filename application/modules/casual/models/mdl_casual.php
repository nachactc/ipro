<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_casual extends CI_Model{
    
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
        select top $limit *,ROW_NUMBER() OVER (ORDER BY rekanan_id asc) as RowNumber 
        from master_rekananshipping $sWhere)
    SELECT CTE.*, BRAND.rekanan_name
    FROM CTE 
      JOIN master_rekanan AS BRAND ON CTE.rekanan_id = BRAND.rekanan_id
    WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();    
   }
   
   function qry_filteredpop($sWhere){
     $qry="select count(rekanan_id) as jml from master_rekananshipping $sWhere";
    return $this->db->query($qry)->row_array();
     
   }
   
   function qry_totalallpop(){
     $qry="select count(rekanan_id) as jml from master_rekananshipping";
    return $this->db->query($qry)->row_array();
     
   }
   
    function qry_alldatalist($limit,$top,$sWhere){
     
     $sWhere = empty($sWhere) ? " WHERE isdisabled = 0 " : $sWhere." AND isdisabled = 0";

	   $qry="WITH CTE AS (
 				select top $limit *,ROW_NUMBER() OVER (ORDER BY agreement_id DESC) as RowNumber 
				from transaksi_agreementtemp $sWhere)
		SELECT CTE.*, REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name
    FROM CTE       
      JOIN master_region AS REGION ON CTE.region_id = REGION.region_id
      JOIN master_branch AS BRANCH ON CTE.branch_id = BRANCH.branch_id
      JOIN master_rekanan AS REKAN ON CTE.rekanan_id = REKAN.rekanan_id
      JOIN master_rekananshipping AS BRAND ON CTE.rekanan_id = BRAND.rekanan_id AND CTE.rekananshipping_line = BRAND.rekananshipping_line
    WHERE CTE.RowNumber > $top";
	   return $this->db->query($qry)->result_array();	   
   }
   
    function qry_filteredlist($sWhere){
     $sWhere = empty($sWhere) ? " WHERE isdisabled = 0 " : $sWhere." AND isdisabled = 0";
     
	   $qry="select count(agreement_id) as jml from transaksi_agreementtemp $sWhere";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalllist(){
	   $qry="select count(agreement_id) as jml from transaksi_agreementtemp";
		return $this->db->query($qry)->row_array();
	   
   }
   
    function insertloo($loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, $lease,
        $loo_line,$unit_id,$agrtype_id,$loo_baserent, $loo_space, $r_id, $tenant, $brand, $lantai, $int, $timetype, $descr){


        $datetime1 = date_create($loo_sdate);
        $datetime2 = date_create($loo_edate);
        $interval = date_diff($datetime1, $datetime2);

        $loo_term = $interval->m + ($interval->y * 12);

        $timestamp = time();		   

        $loo_id = gen_id_loo($region,'LOO','sequencer_loo', $r_id, $timestamp);

        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     
        $check = $this->db->query("
                 insert into transaksi_loo
                     (loo_id, loo_date, loo_sdate, loo_edate, loo_term, _createby, _createdate, _modifyby, _modifydate, region_id , branch_id, rekanan_id, rekananshipping_line, loo_type) 			
                 values
                     ('$loo_id','$loo_date', '$loo_sdate', '$loo_edate', $loo_term,'$_createby','$now','$_modifyby','$now','$region','$branch', 
                      '$tenant', '$brand', '$lease')");     
			
  			foreach($loo_line as $key => $n){

  				$t_line       = $loo_line[$key];
  				$t_unit       = $unit_id[$key];
  				$t_agrtype    = $agrtype_id[$key];
  				$t_baserent   = $loo_baserent[$key];
          $t_baserent   = str_replace(',', '',$t_baserent);
          $t_space      = $loo_space[$key];
          $t_lantai     = $lantai[$key];
          $t_int        = $int[$key];
          $t_timet      = $timetype[$key];
          $t_descr      = $descr[$key];

        	$this->db->query("
             insert into transaksi_loodetil
                 (loo_id, loodetil_line, loodetil_space, loodetil_baserent, agreementtype_id, unit_id, lantai_id, loodetil_int, timetype_id, loodetil_descr)
             values
                 ('$loo_id', $t_line, $t_space, $t_baserent, '$t_agrtype', '$t_unit', '$t_lantai', $t_int, '$t_timet', '$t_descr')");

          $this->db->query("UPDATE master_unit SET unit_state = 1 WHERE unit_id='$t_unit'"); 
  			}
			
			return $loo_id;
			  
    }

  function sholdetilby_id($id){          
        $sql = "
          SELECT *
          FROM transaksi_agreementtempdetil
          WHERE agreement_id = '$id'";  
    return $this->db->query($sql)->result();      
  }
		    
	function updateloo($loo_id, $loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, 
        $lease, $loo_line,$unit_id,$agrtype_id,$loo_baserent, $loo_space, $tenant, $brand, $lantai, $int, $timetype, $descr){  

        $datetime1 = date_create($loo_sdate);
        $datetime2 = date_create($loo_edate);
        $interval = date_diff($datetime1, $datetime2);

        $loo_term = $interval->m + ($interval->y * 12);

  		  $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     
        $check=$this->db->query("
            update transaksi_loo
            set loo_date = '$loo_date', loo_sdate = '$loo_sdate', loo_edate = '$loo_edate', _createby = '$_createby', loo_term = $loo_term,
                _modifyby = '$_modifyby', _modifydate = '$now', region_id = '$region' , branch_id = '$branch',
                rekanan_id = '$tenant', rekananshipping_line = '$brand', loo_type = '$lease'
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
            $t_space      = $loo_space[$key];            
            $t_lantai     = $lantai[$key];   
            $t_int        = $int[$key];   
            $t_timetype   = $timetype[$key];   
            $t_descr      = $descr[$key];             

            $this->db->query("
             insert into transaksi_loodetil
                 (loo_id, loodetil_line, loodetil_space, loodetil_baserent, agreementtype_id, unit_id, lantai_id, loodetil_int, timetype_id, loodetil_descr )
             values
                 ('$loo_id', $t_line, $t_space, $t_baserent, '$t_agrtype', '$t_unit', '$t_lantai', $t_int, '$t_timetype', '$t_descr')");
          }
          
        }	

    }
	
	function deleteloo($loo_id){

		//$this->db->query("delete from transaksi_loo where loo_id='$loo_id'");
    $this->db->query(" UPDATE transaksi_loo SET isconfirm = '1', conf_id = '{$con_id}' WHERE loo_id = '$id' ");
    //$this->db->query("delete from transaksi_loodetil where loo_id='$loo_id'");
	}
    
  function viewcasual($agreement_id){     

     if (isset($agreement_id)){
        return $this->db->query("
           select agreement_id, agreement_contractno, agreement_virtualaccount, agreement_contractlongnumber, agreement_term,
              convert(varchar(10),agreement_startdate,120) AS agreement_startdate,
              convert(varchar(10),agreement_enddate,120) AS agreement_enddate,
              agreement_descr, transaksi_id, agreement_createby, agreement_createdate, agreement_modifyby, agreement_modifydate, region_id, 
              agreement_isapproved, agreement_isrenewal, agreement_islumpsum, agreement_isclosed, agreement_tlv,
              AG.branch_id, AG.rekanan_id, AG.rekananshipping_line, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name
           from transaksi_agreementtemp AS AG 
              JOIN master_branch AS BRANCH ON AG.branch_id = BRANCH.branch_id
              JOIN master_rekanan AS REKAN ON AG.rekanan_id = REKAN.rekanan_id
              JOIN master_rekananshipping AS BRAND ON AG.rekanan_id = BRAND.rekanan_id AND AG.rekananshipping_line = BRAND.rekananshipping_line
           where AG.agreement_id='$agreement_id'
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
                        '_modifydate'     => $now
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

    $action = "posting";   

     if (is_array($arrCon)){
       if (count($arrCon) >0){
          foreach ($arrCon as $filt){   

            $id         = $filt['0'];
            $region_id  = $filt['1'];
            $u_id       = $filt['2'];           

            $timestamp = time();

            $this->db->where('region_id', $region_id);
            $this->db->select('region_id, region_name, region_nameshort');
            $r_id = $this->db->get('master_region')->row()->region_nameshort;

            $con_id = gen_id_conf($region_id,'CON','sequencer_loo', $r_id, $timestamp);
          
            $check = $this->db->query(" UPDATE transaksi_loo SET isconfirm = '1', conf_id = '{$con_id}' WHERE loo_id = '$id' ");

            $u_sql = " SELECT DISTINCT unit_id FROM transaksi_loodetil WHERE loo_id = '$id' ";

            $q_uid = $this->db->query($u_sql)->result_array();

            foreach($q_uid as $uid){

              //print_r( $uid['unit_id']);
              $unit_id = $uid['unit_id'];
              $this->db->query("UPDATE master_unit SET unit_state = 2 WHERE unit_id='$unit_id'");

            }            

            if ($check){
               $success = '1';   
            }else{         
               $success = '0';       
            }
          }  
       }
     }
    

     if ($success) {
         $result['success'] = '1';
         $result['data'] = array('action' => $action);
        } else {
         $result['success'] = '0';
         $result['errors'] = array('action' => $action, 'msg' => $msg);        
        }         

        echo json_encode($result);

   }

   function approveloo($arrid){   

    $action = "approve";   

     if (is_array($arrid)){
       if (count($arrid) >0){
          foreach ($arrid as $id){            
          
            $check = $this->db->query("UPDATE transaksi_loo SET isapproved = '1' WHERE loo_id = '$id'");

            $u_sql = " SELECT DISTINCT unit_id FROM transaksi_loodetil WHERE loo_id = '$id' ";

            $q_uid = $this->db->query($u_sql)->result_array();

            foreach($q_uid as $uid){

              $unit_id = $uid['unit_id'];
              $this->db->query("UPDATE master_unit SET unit_state = 3 WHERE unit_id='$unit_id'");
              
            }            

            if ($check){
               $success = '1';   
            }else{         
               $success = '0';       
            }
          }  
       }
     }
    

     if ($success) {
         $result['success'] = '1';
         $result['data'] = array('action' => $action);
        } else {
         $result['success'] = '0';
         $result['errors'] = array('action' => $action, 'msg' => $msg);        
        }         

        echo json_encode($result);

   }


   function dataconf($uid){        

        $sql = " 
          SELECT DISTINCT LOH.*, REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, UNIT.unit_name,
            LOD.unit_id
          FROM transaksi_loo LOH
            JOIN transaksi_loodetil LOD ON LOH.loo_id = LOD.loo_id
            JOIN master_region AS REGION ON LOH.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOH.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOH.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOH.rekanan_id = BRAND.rekanan_id AND LOH.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id
          WHERE LOH.isconfirm = '0' AND LOD.unit_id like '%{$uid}%' ";    

        return $this->db->query($sql)->result_array();
    }

    function dataapp($uid){

        $sql = " 
          SELECT DISTINCT LOH.*, REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, UNIT.unit_name 
          FROM transaksi_loo LOH
            JOIN transaksi_loodetil LOD ON LOH.loo_id = LOD.loo_id
            JOIN master_region AS REGION ON LOH.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOH.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOH.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOH.rekanan_id = BRAND.rekanan_id AND LOH.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id
          WHERE LOH.isapproved = '0' AND LOH.isconfirm = '1' AND UNIT.unit_state <> '3' AND LOD.unit_id like '%{$uid}%' ";    

        return $this->db->query($sql)->result_array();
    }

    function dataprintconf($uid){

        $sql = " 
          SELECT DISTINCT LOH.*, REGION.region_nameshort, BRANCH.branch_name, REKAN.rekanan_name, BRAND.rekananshipping_name, UNIT.unit_name 
          FROM transaksi_loo LOH
            JOIN transaksi_loodetil LOD ON LOH.loo_id = LOD.loo_id
            JOIN master_region AS REGION ON LOH.region_id = REGION.region_id
            JOIN master_branch AS BRANCH ON LOH.branch_id = BRANCH.branch_id
            JOIN master_rekanan AS REKAN ON LOH.rekanan_id = REKAN.rekanan_id
            JOIN master_rekananshipping AS BRAND ON LOH.rekanan_id = BRAND.rekanan_id AND LOH.rekananshipping_line = BRAND.rekananshipping_line
            JOIN master_unit AS UNIT ON UNIT.unit_id = LOD.unit_id
          WHERE LOH.isapproved = '0' AND LOH.isconfirm = '1' AND LOD.unit_id like '%{$uid}%' ";    

        return $this->db->query($sql)->result_array();
    }
    
      
    
}