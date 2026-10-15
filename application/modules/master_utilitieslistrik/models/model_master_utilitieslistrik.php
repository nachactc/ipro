<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_master_utilitieslistrik extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
	 function qry_alldatadialog($limit,$top,$sWhere){
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
     $qry="
			SELECT  * FROM (
			select top $limit  ROW_NUMBER() OVER (ORDER BY utilitieslistrik_id asc) as RowNumber,
			CTE.*,
						   KVA.utilitieskva_name
			  FROM master_utilitieslistrik AS CTE
			  JOIN master_utilitieskva  AS KVA ON CTE.utilitieskva_id = KVA.utilitieskva_id
        $sWhere		
			  ) AS V
    	WHERE   RowNumber > $top";
      //echo $qry;
	   return $this->db->query($qry)->result_array();
   }
   
    function qry_filteredlist($sWhere){

     $qry="SELECT count(*) as jml FROM (
			select CTE.*,ROW_NUMBER() OVER (ORDER BY utilitieslistrik_id desc) as RowNumber,
						   KVA.utilitieskva_name
			  FROM master_utilitieslistrik as CTE
        JOIN master_utilitieskva  AS KVA ON CTE.utilitieskva_id = KVA.utilitieskva_id
			  $sWhere

			  ) AS V";
		return $this->db->query($qry)->row_array();

   }
   
    function qry_totalalllist(){
	   $qry="select count(utilitieslistrik_id) as jml from master_utilitieslistrik as CTE
        JOIN master_utilitieskva  AS KVA ON CTE.utilitieskva_id = KVA.utilitieskva_id";
		return $this->db->query($qry)->row_array();
	   
   }
   
    function insertloo($loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, 
        $loodetil_line,$master_utilitieslistrik_id,$agreementtype_id,$loodetil_baserent){

      $idx=$this->model_loo->insertloo($loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, 
        $loodetil_line,$master_utilitieslistrik_id,$agreementtype_id,$loodetil_baserent);
		    
        $loo_id = generate_id_string('TPC','CO', 10, 'sequencer_jurnal');    
        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     
        $check = $this->db->query("
                 insert into transaksi_loo
                     (loo_id, loo_date, loo_sdate, loo_edate, loo_term, _createby, _createdate, _modifyby, _modifydate, region_id , branch_id, 
                      loodetil_line,$master_utilitieslistrik_id,$agreementtype_id,$loodetil_baserent)	
                 values
                     ('$loo_id','$loo_date', '$loo_sdate', '$loo_edate', '$loo_term, '$descr', 0,'$_createby','$now','$_modifyby','$now','$region','$branch')");     
			
			foreach($coll_line as $key => $n){
				$tcoll_line=$coll_line[$key];
				$tcoll_descr=$coll_descr[$key];
				$tcoll_amount=$coll_amount[$key];
				$tref_id=$ref_id[$key];
				$tref_line=$ref_line[$key];
    			$tcoll_amount= str_replace(',', '',$tcoll_amount);
              	$this->db->query("
                   insert into web_colldetil
                       (coll_id, coll_line, coll_descr, coll_amount, ref_id, ref_line)    
                   values
                       ('$coll_id', $tcoll_line, '$tcoll_descr', $tcoll_amount, '$tref_id', $tref_line)");	
			}
			
			return $coll_id;
			  
    }
 
	function updatemaster_utilitieslistrik($utilitieslistrik_id, $utilitieslistrik_name, $utilitieslistrik_amp, $utilitieslistrik_phase, $utilitieslistrik_kva, $utilitieslistrik_faktor, $utilitieslistrik_issingglemeter, $utilitieslistrik_isadditional, $utilitieslistrik_admpercent, $utilitieslistrik_admamount, $utilitieslistrik_bpju, $utilitieskva_id, $tariflwbp_calcbyuser, $tarifwbp_calcbyuser, $selisih_calcbyuser, $selisihlwbp_calcbyuser, $selisihwbp_calcbyuser, $pemakaianwbp_calcbyuser, $pemakaianlwbp_calcbyuser, $utilitieslistrik_isgenset, $utilitieslistrik_isblocked, $utilitieslistrik_isdisabled, $utilitieslistrik_createby, $utilitieslistrik_createdate, $utilitieslistrik_modifyby, $utilitieslistrik_modifydate){   	
  		$timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp); 
		
		 
		// echo $get_master_utilitieslistriktype_old;
		// echo '<br/>--';
		// echo $master_utilitieslistriktype_id;
		// exit;
		$this->db->trans_begin();

        $sp_insertH = "EXEC [MstMstutilitieslistrik_Update] '$utilitieslistrik_id', '$utilitieslistrik_name', $utilitieslistrik_amp, $utilitieslistrik_phase, $utilitieslistrik_kva, $utilitieslistrik_faktor, $utilitieslistrik_issingglemeter, $utilitieslistrik_isadditional, $utilitieslistrik_admpercent, $utilitieslistrik_admamount, $utilitieslistrik_bpju, '$utilitieskva_id', 
		$tariflwbp_calcbyuser, $tarifwbp_calcbyuser, $selisih_calcbyuser, $selisihlwbp_calcbyuser, $selisihwbp_calcbyuser, $pemakaianwbp_calcbyuser, $pemakaianlwbp_calcbyuser, $utilitieslistrik_isgenset, $utilitieslistrik_isblocked, 
		$utilitieslistrik_isdisabled, '$utilitieslistrik_createby', '$now', '$utilitieslistrik_modifyby', '$now'";        
        $result = $this->db->query($sp_insertH)->row_array();
		//$_id = $result['utilitieslistrik_id'];
		
		if ($this->db->trans_status() === FALSE)
        {               
            //generate an error... or use the log_message() function to log your error
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();

            //return $_id;  
        }
		
		/*
			$this->db->query("
				update master_utilitieslistrik
								
				set
				utilitieslistrik_name			= '$utilitieslistrik_name',
				utilitieslistrik_amp			= '$utilitieslistrik_amp',
				utilitieslistrik_phase			= '$utilitieslistrik_phase',
				utilitieslistrik_kva			= '$utilitieslistrik_kva',
				utilitieslistrik_faktor			= '$utilitieslistrik_faktor',
				utilitieslistrik_issingglemeter	= '$utilitieslistrik_issingglemeter',
				utilitieslistrik_isadditional	= '$utilitieslistrik_isadditional',
				utilitieslistrik_admpercent		= '$utilitieslistrik_admpercent',
				utilitieslistrik_admamount		= '$utilitieslistrik_admamount',
				utilitieslistrik_bpju			= '$utilitieslistrik_bpju',
				utilitieskva_id					= '$utilitieskva_id',
				tariflwbp_calcbyuser			= '$tariflwbp_calcbyuser',
				tarifwbp_calcbyuser				= '$tarifwbp_calcbyuser',
				selisih_calcbyuser				= '$selisih_calcbyuser',
				selisihlwbp_calcbyuser			= '$selisihlwbp_calcbyuser',
				selisihwbp_calcbyuser			= '$selisihwbp_calcbyuser',
				pemakaianwbp_calcbyuser			= '$pemakaianwbp_calcbyuser',
				pemakaianlwbp_calcbyuser		= '$pemakaianlwbp_calcbyuser',
				utilitieslistrik_isgenset		= $utilitieslistrik_isgenset, 				
				utilitieslistrik_isblocked		= '$utilitieslistrik_isblocked',
				utilitieslistrik_isdisabled		= '$utilitieslistrik_isdisabled',
				utilitieslistrik_createby		= '$utilitieslistrik_createby',
				utilitieslistrik_createdate		= '$utilitieslistrik_createdate',
				utilitieslistrik_modifyby		= '$utilitieslistrik_modifyby',
				utilitieslistrik_modifydate		= '$utilitieslistrik_modifydate'
					
				where utilitieslistrik_id = '$utilitieslistrik_id'
			");	
		
        	*/

    }
	
	function savemaster_utilitieslistrik($utilitieslistrik_id, $utilitieslistrik_name, $utilitieslistrik_amp, $utilitieslistrik_phase, $utilitieslistrik_kva, $utilitieslistrik_faktor, $utilitieslistrik_issingglemeter, $utilitieslistrik_isadditional, $utilitieslistrik_admpercent, $utilitieslistrik_admamount, $utilitieslistrik_bpju, $utilitieskva_id, $tariflwbp_calcbyuser, $tarifwbp_calcbyuser, $selisih_calcbyuser, $selisihlwbp_calcbyuser, $selisihwbp_calcbyuser, $pemakaianwbp_calcbyuser, $pemakaianlwbp_calcbyuser, $utilitieslistrik_isgenset, $utilitieslistrik_isblocked, $utilitieslistrik_isdisabled, $utilitieslistrik_createby, $utilitieslistrik_createdate, $utilitieslistrik_modifyby, $utilitieslistrik_modifydate){ 
		$timestamp = time();		
        $now = date("Y-m-d H:i:s", $timestamp);        

        $this->db->trans_begin();

        $sp_insertH = "EXEC [MstMstutilitieslistrik_Insert] '', '$utilitieslistrik_name', $utilitieslistrik_amp, $utilitieslistrik_phase, $utilitieslistrik_kva, $utilitieslistrik_faktor, $utilitieslistrik_issingglemeter, $utilitieslistrik_isadditional, $utilitieslistrik_admpercent, $utilitieslistrik_admamount, $utilitieslistrik_bpju, '$utilitieskva_id', 
		$tariflwbp_calcbyuser, $tarifwbp_calcbyuser, $selisih_calcbyuser, $selisihlwbp_calcbyuser, $selisihwbp_calcbyuser, $pemakaianwbp_calcbyuser, $pemakaianlwbp_calcbyuser, $utilitieslistrik_isgenset, $utilitieslistrik_isblocked, 
		$utilitieslistrik_isdisabled, '$utilitieslistrik_createby', '$now', '', '$now'";        
        $result = $this->db->query($sp_insertH)->row_array();
		//$_id = $result['utilitieslistrik_id'];
		
		if ($this->db->trans_status() === FALSE)
        {               
            //generate an error... or use the log_message() function to log your error
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();

            //return $_id;  
        }
		
	 
	
		 
		 

    }
	
	function get_floor(){

        $this->db->select('lantai_id, lantai_name');
        $query = $this->db->get('master_lantai');

        return $query->result();
    }

	function get_kva(){

        $this->db->select('utilitieskva_id, utilitieskva_name');
        $query = $this->db->get('master_utilitieskva');

        return $query->result();
    }
	
	function get_master_utilitieslistriktype(){

        $this->db->select('master_utilitieslistriktype_id, master_utilitieslistriktype_name');
        $query = $this->db->get('master_master_utilitieslistriktype');

        return $query->result();
    }
	
	function deletemaster_utilitieslistrik($utilitieslistrik_id){
		$timestamp = time();		
        $now = date("Y-m-d H:i:s", $timestamp);        

        $this->db->trans_begin();

        $sp_insertH = "EXEC [MstMstutilitieslistrik_Delete] '$utilitieslistrik_id'";        
        $result = $this->db->query($sp_insertH)->row_array();
		//$_id = $result['utilitieslistrik_id'];
		
		if ($this->db->trans_status() === FALSE)
        {               
            //generate an error... or use the log_message() function to log your error
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();

            //return $_id;  
        }
	}
    
    function viewmaster_utilitieslistrik($utilitieslistrik_id){     
     if (isset($utilitieslistrik_id)){
        return $this->db->query("
           select utilitieslistrik_id,utilitieslistrik_name,utilitieslistrik_amp,utilitieslistrik_phase,
			utilitieslistrik_kva,utilitieslistrik_faktor,utilitieslistrik_issingglemeter,
			utilitieslistrik_isadditional,utilitieslistrik_admpercent,utilitieslistrik_admamount,
			utilitieslistrik_bpju,utilitieskva_id,tariflwbp_calcbyuser,
			tarifwbp_calcbyuser,selisih_calcbyuser,selisihlwbp_calcbyuser,
			selisihwbp_calcbyuser,pemakaianwbp_calcbyuser,pemakaianlwbp_calcbyuser,
			utilitieslistrik_isgenset,utilitieslistrik_isblocked,utilitieslistrik_isdisabled,utilitieslistrik_createby,utilitieslistrik_createdate,utilitieslistrik_modifyby,utilitieslistrik_modifydate
           from master_utilitieslistrik 
           where master_utilitieslistrik.utilitieslistrik_id='$utilitieslistrik_id'
       ")->result();
     }else{         
       $timestamp = time();
      
       $now = date("Y-m-d", $timestamp);  

       $result[] = (object) array(                        
                        'utilitieslistrik_id'         		=>'auto',
                        'utilitieslistrik_name'       		=> '',
                        'utilitieslistrik_amp'       		=> '',
                        'utilitieslistrik_phase'        	=> '',
                        'utilitieslistrik_kva'     			=> '',
                        'utilitieslistrik_faktor'       	=> '',
                        'utilitieslistrik_admpercent'      	=> 0,
                        'utilitieslistrik_admamount' 		=> 0,
                        'utilitieslistrik_issingglemeter'  	=> 0,
                        'utilitieslistrik_isadditional'     => 0,
                        'utilitieslistrik_isgenset'       	=> 0,
                        'utilitieslistrik_isblocked'       	=> 0,
                        'utilitieslistrik_isdisabled'       => 0,
						'utilitieskva_id'       			=> '',
						'utilitieslistrik_bpju'				=> 0,
						'tariflwbp_calcbyuser'				=> 0,
						'tarifwbp_calcbyuser'				=> 0,
						'selisih_calcbyuser'				=> 0,
						'selisihlwbp_calcbyuser'			=> 0,
						'selisihwbp_calcbyuser'				=> 0,
						'pemakaianwbp_calcbyuser'			=> 0,
						'pemakaianlwbp_calcbyuser'			=> 0,					
                        'utilitieslistrik_createby'       	=> '',
                        'utilitieslistrik_createdate'     	=> $now,
                        'utilitieslistrik_modifyby'       	=> '',
                        'utilitieslistrik_modifydate'     	=> $now
       );

       return $result;
     }

   }
    
	function cek_master_utilitieslistrik_status($master_utilitieslistrik_id)
	{
		$sql = "SELECT COUNT(*) as jml FROM transaksi_loomaster_utilitieslistrik WHERE master_utilitieslistrik_id = '$master_utilitieslistrik_id'";
		$result = $this->db->query($sql)->row()->jml;
		 
		if($result == 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
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
	
	function get_branch_list()
	{ 
		// echo var_dump($branch_name);
		// exit;
        $this->db->select('r.branch_id, branch_name,c.region_id,c.region_name');
        $this->db->from('master_regionbranch r');
        $this->db->join('master_branch b', 'r.branch_id = b.branch_id');
        $this->db->join('master_region c', 'c.region_id = r.region_id'); 
        $query = $this->db->get()->result();;

       
		
		$ret ['']= 'Pilih Store :';
        if($query)
        {
            foreach ($query as $key => $row)
            {
                $ret [$row->branch_id] = $row->branch_name;
            }
        }
        //echo var_dump($ret);
        return $ret; 
		
    }
    
}