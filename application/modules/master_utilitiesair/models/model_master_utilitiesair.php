<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_master_utilitiesair extends CI_Model{
    
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
			select top $limit  ROW_NUMBER() OVER (ORDER BY utilitiesair_id asc) as RowNumber,
			CTE.*
			  FROM master_utilitiesair AS CTE
			  
        $sWhere		
			  ) AS V
    	WHERE   RowNumber > $top";
      //echo $qry;
	   return $this->db->query($qry)->result_array();
   }
   
    function qry_filteredlist($sWhere){

     $qry="SELECT count(*) as jml FROM (
			select CTE.*,ROW_NUMBER() OVER (ORDER BY utilitiesair_id desc) as RowNumber
			  FROM master_utilitiesair as CTE
        
			  $sWhere

			  ) AS V";
		return $this->db->query($qry)->row_array();

   }
   
    function qry_totalalllist(){
	   $qry="select count(utilitiesair_id) as jml from master_utilitiesair as CTE
        ";
		return $this->db->query($qry)->row_array();
	   
   }
   
    function insertloo($loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, 
        $loodetil_line,$master_utilitiesair_id,$agreementtype_id,$loodetil_baserent){

      $idx=$this->model_loo->insertloo($loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, 
        $loodetil_line,$master_utilitiesair_id,$agreementtype_id,$loodetil_baserent);
		    
        $loo_id = generate_id_string('TPC','CO', 10, 'sequencer_jurnal');    
        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     
        $check = $this->db->query("
                 insert into transaksi_loo
                     (loo_id, loo_date, loo_sdate, loo_edate, loo_term, _createby, _createdate, _modifyby, _modifydate, region_id , branch_id, 
                      loodetil_line,$master_utilitiesair_id,$agreementtype_id,$loodetil_baserent)	
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
 
	function updatemaster_utilitiesair($utilitiesair_id, $utilitiesair_name, $utilitiesair_diameterpipa, $utilitiesair_adm, $utilitiesair_phairkotor, $utilitiesair_phmeter, $utilitiesair_isadditional, $phairkotor_isdisabled, $utilitiesair_admpercent, $utilitiesair_abonemen, $utilitiesair_isusedawalakhir, $utilitiesair_isdisabled, $utilitiesair_createby, $utilitiesair_createdate, $utilitiesair_modifyby, $utilitiesair_modifydate){   	
  		$timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp); 
		
		 
		// echo $get_master_utilitiesairtype_old;
		// echo '<br/>--';
		// echo $master_utilitiesairtype_id;
		// exit;
		$this->db->trans_begin();

        $sp_insertH = "EXEC [MstMstutilitiesair_Update] '$utilitiesair_id', '$utilitiesair_name', '$utilitiesair_diameterpipa', $utilitiesair_adm, $utilitiesair_phairkotor, $utilitiesair_phmeter, $utilitiesair_isadditional, $phairkotor_isdisabled, $utilitiesair_admpercent, $utilitiesair_abonemen, $utilitiesair_isusedawalakhir, $utilitiesair_isdisabled, 
		'$utilitiesair_createby', '$utilitiesair_createdate', '$utilitiesair_modifyby', '$now'";        
        $result = $this->db->query($sp_insertH)->row_array();
		//$_id = $result['utilitiesair_id'];
		
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
				update master_utilitiesair
								
				set
				utilitiesair_name			= '$utilitiesair_name',
				utilitiesair_amp			= '$utilitiesair_amp',
				utilitiesair_phase			= '$utilitiesair_phase',
				utilitiesair_kva			= '$utilitiesair_kva',
				utilitiesair_faktor			= '$utilitiesair_faktor',
				utilitiesair_issingglemeter	= '$utilitiesair_issingglemeter',
				utilitiesair_isadditional	= '$utilitiesair_isadditional',
				utilitiesair_admpercent		= '$utilitiesair_admpercent',
				utilitiesair_admamount		= '$utilitiesair_admamount',
				utilitiesair_bpju			= '$utilitiesair_bpju',
				utilitieskva_id					= '$utilitieskva_id',
				tariflwbp_calcbyuser			= '$tariflwbp_calcbyuser',
				tarifwbp_calcbyuser				= '$tarifwbp_calcbyuser',
				selisih_calcbyuser				= '$selisih_calcbyuser',
				selisihlwbp_calcbyuser			= '$selisihlwbp_calcbyuser',
				selisihwbp_calcbyuser			= '$selisihwbp_calcbyuser',
				pemakaianwbp_calcbyuser			= '$pemakaianwbp_calcbyuser',
				pemakaianlwbp_calcbyuser		= '$pemakaianlwbp_calcbyuser',
				utilitiesair_isgenset		= $utilitiesair_isgenset, 				
				utilitiesair_isblocked		= '$utilitiesair_isblocked',
				utilitiesair_isdisabled		= '$utilitiesair_isdisabled',
				utilitiesair_createby		= '$utilitiesair_createby',
				utilitiesair_createdate		= '$utilitiesair_createdate',
				utilitiesair_modifyby		= '$utilitiesair_modifyby',
				utilitiesair_modifydate		= '$utilitiesair_modifydate'
					
				where utilitiesair_id = '$utilitiesair_id'
			");	
		
        	*/

    }
	
	function savemaster_utilitiesair($utilitiesair_id, $utilitiesair_name, $utilitiesair_diameterpipa, $utilitiesair_adm, $utilitiesair_phairkotor, $utilitiesair_phmeter, $utilitiesair_isadditional, $phairkotor_isdisabled, $utilitiesair_admpercent, $utilitiesair_abonemen, $utilitiesair_isusedawalakhir, $utilitiesair_isdisabled, $utilitiesair_createby, $utilitiesair_createdate, $utilitiesair_modifyby, $utilitiesair_modifydate){ 
		$timestamp = time();		
        $now = date("Y-m-d H:i:s", $timestamp);        

        $this->db->trans_begin();

        $sp_insertH = "EXEC [MstMstutilitiesair_Insert] '', '$utilitiesair_name', '$utilitiesair_diameterpipa', $utilitiesair_adm, $utilitiesair_phairkotor, $utilitiesair_phmeter, $utilitiesair_isadditional, $phairkotor_isdisabled, $utilitiesair_admpercent, $utilitiesair_abonemen, $utilitiesair_isusedawalakhir, $utilitiesair_isdisabled, 
		'$utilitiesair_createby', '$now', '', '$now'";        
        $result = $this->db->query($sp_insertH)->row_array();
		//$_id = $result['utilitiesair_id'];
		
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
	
	function get_master_utilitiesairtype(){

        $this->db->select('master_utilitiesairtype_id, master_utilitiesairtype_name');
        $query = $this->db->get('master_master_utilitiesairtype');

        return $query->result();
    }
	
	function deletemaster_utilitiesair($utilitiesair_id){
		$timestamp = time();		
        $now = date("Y-m-d H:i:s", $timestamp);        

        $this->db->trans_begin();

        $sp_insertH = "EXEC [MstMstutilitiesair_Delete] '$utilitiesair_id'";        
        $result = $this->db->query($sp_insertH)->row_array();
		//$_id = $result['utilitiesair_id'];
		
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
    
    function viewmaster_utilitiesair($utilitiesair_id){     
     if (isset($utilitiesair_id)){
        return $this->db->query("
           select utilitiesair_id,utilitiesair_name,utilitiesair_diameterpipa,utilitiesair_adm,
			utilitiesair_phairkotor,utilitiesair_phmeter,utilitiesair_isadditional,
			phairkotor_isdisabled,utilitiesair_admpercent,utilitiesair_abonemen,
			utilitiesair_isusedawalakhir,utilitiesair_isdisabled,utilitiesair_createby,utilitiesair_createdate,utilitiesair_modifyby,utilitiesair_modifydate
           from master_utilitiesair 
           where master_utilitiesair.utilitiesair_id='$utilitiesair_id'
       ")->result();
     }else{         
       $timestamp = time();
      
       $now = date("Y-m-d", $timestamp);  

       $result[] = (object) array(                        
                        'utilitiesair_id'         		=>'auto',
                        'utilitiesair_name'       		=> '',
                        'utilitiesair_diameterpipa'     => '',
                        'utilitiesair_adm'        		=> 0,
                        'utilitiesair_phairkotor'     	=> 0,
                        'utilitiesair_phmeter'       	=> 0,
                        'utilitiesair_isadditional'     => 0,
                        'phairkotor_isdisabled' 		=> 0,
                        'utilitiesair_admpercent'  		=> 0,
                        'utilitiesair_abonemen'     	=> 0,
                        'utilitiesair_isusedawalakhir'  => 0,
                        'utilitiesair_isdisabled'       => 0,										
                        'utilitiesair_createby'       	=> '',
                        'utilitiesair_createdate'     	=> $now,
                        'utilitiesair_modifyby'       	=> '',
                        'utilitiesair_modifydate'     	=> $now
       );

       return $result;
     }

   }
    
	function cek_master_utilitiesair_status($master_utilitiesair_id)
	{
		$sql = "SELECT COUNT(*) as jml FROM transaksi_loomaster_utilitiesair WHERE master_utilitiesair_id = '$master_utilitiesair_id'";
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