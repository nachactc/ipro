<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_master_utilitiesgas extends CI_Model{
    
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
			select top $limit  ROW_NUMBER() OVER (ORDER BY utilitiesgas_id asc) as RowNumber,
			CTE.*
			  FROM master_utilitiesgas AS CTE
			  
        $sWhere		
			  ) AS V
    	WHERE   RowNumber > $top";
      //echo $qry;
	   return $this->db->query($qry)->result_array();
   }
   
    function qry_filteredlist($sWhere){

     $qry="SELECT count(*) as jml FROM (
			select CTE.*,ROW_NUMBER() OVER (ORDER BY utilitiesgas_id desc) as RowNumber
			  FROM master_utilitiesgas as CTE
        
			  $sWhere

			  ) AS V";
		return $this->db->query($qry)->row_array();

   }
   
    function qry_totalalllist(){
	   $qry="select count(utilitiesgas_id) as jml from master_utilitiesgas as CTE
        ";
		return $this->db->query($qry)->row_array();
	   
   }
   
    function insertloo($loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, 
        $loodetil_line,$master_utilitiesgas_id,$agreementtype_id,$loodetil_baserent){

      $idx=$this->model_loo->insertloo($loo_date, $loo_sdate, $loo_edate, $loo_term, $_createby, $_modifyby, $region, $branch, 
        $loodetil_line,$master_utilitiesgas_id,$agreementtype_id,$loodetil_baserent);
		    
        $loo_id = generate_id_string('TPC','CO', 10, 'sequencer_jurnal');    
        $timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp);     
        $check = $this->db->query("
                 insert into transaksi_loo
                     (loo_id, loo_date, loo_sdate, loo_edate, loo_term, _createby, _createdate, _modifyby, _modifydate, region_id , branch_id, 
                      loodetil_line,$master_utilitiesgas_id,$agreementtype_id,$loodetil_baserent)	
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
 
	function updatemaster_utilitiesgas($utilitiesgas_id, $utilitiesgas_name, $utilitiesgas_diameterpipa, $utilitiesgas_adm, $utilitiesgas_phairkotor, $utilitiesgas_phmeter, $utilitiesgas_isadditional, $utilitiesgas_tarif, $utilitiesgas_admpercent, $utilitiesgas_mfaktor, $utilitiesgas_pressure, $utilitiesgas_isusedawalakhir, $utilitiesgas_isdisabled, $utilitiesgas_createby, $utilitiesgas_createdate, $utilitiesgas_modifyby, $utilitiesgas_modifydate){   	
  		$timestamp = time();
        $now = date("Y-m-d H:i:s", $timestamp); 
		
		 
		// echo $get_master_utilitiesgastype_old;
		// echo '<br/>--';
		// echo $master_utilitiesgastype_id;
		// exit;
		$this->db->trans_begin();

        $sp_insertH = "EXEC [MstMstutilitiesgas_Update] '$utilitiesgas_id', '$utilitiesgas_name', '$utilitiesgas_diameterpipa', $utilitiesgas_adm, $utilitiesgas_phairkotor, $utilitiesgas_phmeter, $utilitiesgas_isadditional, $utilitiesgas_tarif, $utilitiesgas_mfaktor, $utilitiesgas_pressure, $utilitiesgas_admpercent, $utilitiesgas_isusedawalakhir, $utilitiesgas_isdisabled, 
		'$utilitiesgas_createby', '$utilitiesgas_createdate', '$utilitiesgas_modifyby', '$now'";        
        $result = $this->db->query($sp_insertH)->row_array();
		//$_id = $result['utilitiesgas_id'];
		
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
				update master_utilitiesgas
								
				set
				utilitiesgas_name			= '$utilitiesgas_name',
				utilitiesgas_amp			= '$utilitiesgas_amp',
				utilitiesgas_phase			= '$utilitiesgas_phase',
				utilitiesgas_kva			= '$utilitiesgas_kva',
				utilitiesgas_faktor			= '$utilitiesgas_faktor',
				utilitiesgas_issingglemeter	= '$utilitiesgas_issingglemeter',
				utilitiesgas_isadditional	= '$utilitiesgas_isadditional',
				utilitiesgas_admpercent		= '$utilitiesgas_admpercent',
				utilitiesgas_admamount		= '$utilitiesgas_admamount',
				utilitiesgas_bpju			= '$utilitiesgas_bpju',
				utilitieskva_id					= '$utilitieskva_id',
				tariflwbp_calcbyuser			= '$tariflwbp_calcbyuser',
				tarifwbp_calcbyuser				= '$tarifwbp_calcbyuser',
				selisih_calcbyuser				= '$selisih_calcbyuser',
				selisihlwbp_calcbyuser			= '$selisihlwbp_calcbyuser',
				selisihwbp_calcbyuser			= '$selisihwbp_calcbyuser',
				pemakaianwbp_calcbyuser			= '$pemakaianwbp_calcbyuser',
				pemakaianlwbp_calcbyuser		= '$pemakaianlwbp_calcbyuser',
				utilitiesgas_isgenset		= $utilitiesgas_isgenset, 				
				utilitiesgas_isblocked		= '$utilitiesgas_isblocked',
				utilitiesgas_isdisabled		= '$utilitiesgas_isdisabled',
				utilitiesgas_createby		= '$utilitiesgas_createby',
				utilitiesgas_createdate		= '$utilitiesgas_createdate',
				utilitiesgas_modifyby		= '$utilitiesgas_modifyby',
				utilitiesgas_modifydate		= '$utilitiesgas_modifydate'
					
				where utilitiesgas_id = '$utilitiesgas_id'
			");	
		
        	*/

    }
	
	function savemaster_utilitiesgas($utilitiesgas_id, $utilitiesgas_name, $utilitiesgas_diameterpipa, $utilitiesgas_adm, $utilitiesgas_phairkotor, $utilitiesgas_phmeter, $utilitiesgas_isadditional, $utilitiesgas_tarif, $utilitiesgas_admpercent, $utilitiesgas_mfaktor, $utilitiesgas_pressure, $utilitiesgas_isusedawalakhir, $utilitiesgas_isdisabled, $utilitiesgas_createby, $utilitiesgas_createdate, $utilitiesgas_modifyby, $utilitiesgas_modifydate){ 
		$timestamp = time();		
        $now = date("Y-m-d H:i:s", $timestamp);        

        $this->db->trans_begin();

        $sp_insertH = "EXEC [MstMstutilitiesgas_Insert] '', '$utilitiesgas_name', '$utilitiesgas_diameterpipa', $utilitiesgas_adm, $utilitiesgas_phairkotor, $utilitiesgas_phmeter, $utilitiesgas_isadditional, $utilitiesgas_tarif, $utilitiesgas_mfaktor, $utilitiesgas_pressure, $utilitiesgas_admpercent, $utilitiesgas_isusedawalakhir, $utilitiesgas_isdisabled, 
		'$utilitiesgas_createby', '$now', '', '$now'";        
        $result = $this->db->query($sp_insertH)->row_array();
		//$_id = $result['utilitiesgas_id'];
		
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
	
	function get_master_utilitiesgastype(){

        $this->db->select('master_utilitiesgastype_id, master_utilitiesgastype_name');
        $query = $this->db->get('master_master_utilitiesgastype');

        return $query->result();
    }
	
	function deletemaster_utilitiesgas($utilitiesgas_id){
		$timestamp = time();		
        $now = date("Y-m-d H:i:s", $timestamp);        

        $this->db->trans_begin();

        $sp_insertH = "EXEC [MstMstutilitiesgas_Delete] '$utilitiesgas_id'";        
        $result = $this->db->query($sp_insertH)->row_array();
		//$_id = $result['utilitiesgas_id'];
		
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
    
    function viewmaster_utilitiesgas($utilitiesgas_id){     
     if (isset($utilitiesgas_id)){
        return $this->db->query("
           select utilitiesgas_id,utilitiesgas_name,utilitiesgas_diameterpipa,utilitiesgas_adm,
			utilitiesgas_phairkotor,utilitiesgas_phmeter,utilitiesgas_isadditional,
			utilitiesgas_tarif,utilitiesgas_admpercent,utilitiesgas_mfaktor,utilitiesgas_pressure,
			utilitiesgas_isusedawalakhir,utilitiesgas_isdisabled,utilitiesgas_createby,utilitiesgas_createdate,utilitiesgas_modifyby,utilitiesgas_modifydate
           from master_utilitiesgas 
           where master_utilitiesgas.utilitiesgas_id='$utilitiesgas_id'
       ")->result();
     }else{         
       $timestamp = time();
      
       $now = date("Y-m-d", $timestamp);  

       $result[] = (object) array(                        
                        'utilitiesgas_id'         		=>'auto',
                        'utilitiesgas_name'       		=> '',
                        'utilitiesgas_diameterpipa'     => '',
                        'utilitiesgas_adm'        		=> 0,
                        'utilitiesgas_phairkotor'     	=> 0,
                        'utilitiesgas_phmeter'       	=> 0,
                        'utilitiesgas_isadditional'     => 0,
                        'utilitiesgas_tarif' 			=> 0,
                        'utilitiesgas_admpercent'  		=> 0,
                        'utilitiesgas_mfaktor'     		=> 0,
						'utilitiesgas_pressure'     	=> 0,
                        'utilitiesgas_isusedawalakhir'  => 0,
                        'utilitiesgas_isdisabled'       => 0,										
                        'utilitiesgas_createby'       	=> '',
                        'utilitiesgas_createdate'     	=> $now,
                        'utilitiesgas_modifyby'       	=> '',
                        'utilitiesgas_modifydate'     	=> $now
       );

       return $result;
     }

   }
    
	function cek_master_utilitiesgas_status($master_utilitiesgas_id)
	{
		$sql = "SELECT COUNT(*) as jml FROM transaksi_loomaster_utilitiesgas WHERE master_utilitiesgas_id = '$master_utilitiesgas_id'";
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