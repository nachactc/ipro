<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_utilities_kva extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
	 function qry_alldatadialog($limit,$top,$sWhere)
	 {
	   $qry="WITH CTE AS (
 				select top $limit *,ROW_NUMBER() OVER (ORDER BY schedulebooking_id asc) as RowNumber 
				from transaksi_schedulebookingdetil $sWhere)
		     SELECT * FROM CTE WHERE RowNumber > $top";
	   		return $this->db->query($qry)->result_array();	   
   }
   
   function qry_filtereddialog($sWhere){
	   $qry="select count(schedulebooking_id) as jml from transaksi_schedulebookingdetil $sWhere";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalldialog(){
	   $qry="select count(schedulebooking_id) as jml from transaksi_schedulebookingdetil";
		return $this->db->query($qry)->row_array();
	   
   }
   
    function qry_alldatalist($limit,$top,$sWhere){
	   		$qry="WITH CTE AS (
 				select top $limit *,ROW_NUMBER() OVER (ORDER BY utilitieskva_id asc) as RowNumber 
				from master_utilitieskva $sWhere)
				SELECT CTE.* FROM CTE 
    		WHERE CTE.RowNumber > $top";
	   		return $this->db->query($qry)->result_array();	   
   	}
   
    function qry_filteredlist($sWhere){
	   $qry="select count(utilitieskva_id) as jml from master_utilitieskva $sWhere";
		return $this->db->query($qry)->row_array();
	   
   }
   
   function qry_totalalllist(){
	   $qry="select count(utilitieskva_id) as jml from master_utilitieskva";
		return $this->db->query($qry)->row_array();
	   
   }
   
    function insert_utilities_kva($utilitieskva_id, $utilitieskva_name, $utilitieskva_tariflwbp, $utilitieskva_tarifwbp, $utilitieskva_createby, $utilitieskva_createdate,
		$utilitieskva_modifyby,$utilitieskva_modifydate){
				
				$username = $this->session->userdata('username');
				$timestamp = time();
				
				$utilitieskva_createdate = date("Y-m-d H:i:s", $timestamp);   
                                //$rowid = trim(com_create_guid(), '{}');
				$sql ="SELECT  id= newid()";
                                $rowid=$this->db->query($sql)->row()->id;

                                $sql ="SELECT  id= (CAST(MAX(ISNULL(utilitieskva_id,0)) AS INT) + 1) from master_utilitieskva ";
				$utilitieskva_id=$this->db->query($sql)->row()->id;
				
                                $utilitieskva_createby=$username;
				//$query=  "EXEC MstMstUtilitieskva_Insert '$utilitieskva_id' ,'$utilitieskva_name' ,$utilitieskva_tariflwbp,$utilitieskva_tarifwbp,'$utilitieskva_createby','$utilitieskva_createdate','$utilitieskva_modifyby','$utilitieskva_modifydate','$rowid' ";
				//echo var_dump($query);
				
				$check = $this->db->query("
                                    insert into master_utilitieskva
                                    (utilitieskva_id, utilitieskva_name, utilitieskva_tariflwbp, utilitieskva_tarifwbp, utilitieskva_createby, utilitieskva_createdate,rowid)	
                                    values
                                    ('$utilitieskva_id', '$utilitieskva_name', $utilitieskva_tariflwbp, $utilitieskva_tarifwbp, '$utilitieskva_createby', '$utilitieskva_createdate','$rowid')");     
				
                                //$check = $this->db->query($query)->row();
				//echo var_dump($check);
				//$utilitieskva_id = $check->utilitieskva_id;
				//echo var_dump($utilitieskva_id);EXIT();
				return $utilitieskva_id;
			  
    }

		
    
	function update_utilities_kva($utilitieskva_id, $utilitieskva_name, $utilitieskva_tariflwbp, $utilitieskva_tarifwbp, $utilitieskva_createby, $utilitieskva_createdate,
	$utilitieskva_modifyby,$utilitieskva_modifydate){                                
				
				$username = $this->session->userdata('username');
				$timestamp = time();
				$utilitieskva_modifydate = date("Y-m-d H:i:s", $timestamp);     
				$utilitieskva_modifyby=$username;
				
				$check=$this->db->query("
            update master_utilitieskva
						set utilitieskva_name = '$utilitieskva_name', utilitieskva_tariflwbp = $utilitieskva_tariflwbp, utilitieskva_tarifwbp = $utilitieskva_tarifwbp,
						utilitieskva_createby = '$utilitieskva_createby',utilitieskva_createdate = '$utilitieskva_createdate',
						utilitieskva_modifyby= '$utilitieskva_modifyby',utilitieskva_modifydate = '$utilitieskva_modifydate'
            where utilitieskva_id = '$utilitieskva_id'
        ");		

    }
	
	function delete_utilities_kva($utilitieskva_id){
		$check=$this->db->query("delete from master_utilitieskva where utilitieskva_id='$utilitieskva_id'");
	}
    
  function view_utilities_kva($utilitieskva_id){     

     if (isset($utilitieskva_id)){
        return $this->db->query("
           select * from master_utilitieskva 
           where utilitieskva_id ='$utilitieskva_id'
       ")->result();
     }else{         
       $timestamp = time();      
       $now = date("Y-m-d", $timestamp);  

       $result[] = (object) array(                        
                        'utilitieskva_id'         	=>'auto',
                        'utilitieskva_name'       	=> '',
                        'utilitieskva_tariflwbp'    => 0,
                        'utilitieskva_tarifwbp'     => 0,
                        'utilitieskva_createby'     => '',
                        'utilitieskva_createdate' 	=> $now,
                        'utilitieskva_modifyby'     => '',
                        'utilitieskva_modifydate' 	=> $now
                        //'rowid'  										=> ''
       );

       return $result;
     }

   }
    
      
    
}
