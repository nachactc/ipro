<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_periode extends CI_Model{
    
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
		
	   $qry="	SELECT * FROM (					   
		SELECT top $limit * from (	 
		SELECT a.*,ROW_NUMBER() OVER (ORDER BY a.periode_id desc) as RowNumber
			FROM master_periode a 
		   )v
		  $sWhere 
		  )  CTE
		WHERE CTE.RowNumber >  $top 
		";
	   $output = $this->db->query($qry);
	   // echo $this->db->last_query();
	   return $output->result_array();	
	   
   }
   
    function qry_filteredlist($sWhere){
	 
	  
	   $qry="	SELECT count(*) as jml FROM (					   
		SELECT   * from (	 
		SELECT a.*,ROW_NUMBER() OVER (ORDER BY a.periode_id desc) as RowNumber 
      FROM master_periode a  
	   )v
	  $sWhere 
      )  CTE 
	";
	   // $qry="select count(a.periode_id) as jml from master_periode a inner join master_branch BRANCH on a.branch_id=BRANCH.branch_id $sWhere";
	   $output = $this->db->query($qry);
	  // echo $this->db->last_query();
	   return $output->row_array();	 
	   
   }
   
    function qry_totalalllist(){
	   $qry="select count(periode_id) as jml from master_periode";
		return $this->db->query($qry)->row_array();
	   
   } 
 
	function updateperiode()
	{   	 
		
		$id = $this->input->post('periode_id');
		$isclose = (!empty($this->input->post('periode_isclosed')) ? intval($this->input->post('periode_isclosed')) : 0 );
		$allowsaldoawalentry = (!empty($this->input->post('periode_allowsaldoawalentry')) ? intval($this->input->post('periode_allowsaldoawalentry')) : 0 );
		$islocked = (!empty($this->input->post('periode_islocked')) ? intval($this->input->post('periode_islocked')): 0 ); 
        $data = array( 
		'periode_name' => $this->input->post('periode_name'),
		'periode_datestart' => $this->input->post('periode_datestart'),
		'periode_dateend' => $this->input->post('periode_dateend'),
		'periode_isclosed' => $isclose,
		'periode_allowsaldoawalentry' => $allowsaldoawalentry,
		'periode_islocked' => $islocked,
		);
		// echo var_dump($allowsaldoawalentry);
		// echo var_dump($islocked);
		// exit;
		$this->db->where('periode_id', $id);
		$this->db->update('master_periode',$data); 
		// echo $this->db->last_query();exit;
    }
	
	function saveperiode()
	{  	 
		// echo "<pre/>";
		// echo var_dump($this->input->post('periode_isclosed'));exit;
		$username =  $this->session->userdata('user_fullname');
		$timestamp = time();
		$date = date("Y-m-d H:i:s", $timestamp); 
		$isclose = (!empty($this->input->post('periode_isclosed')) ? intval($this->input->post('periode_isclosed')) : 0 );
		$allowsaldoawalentry = (!empty($this->input->post('periode_allowsaldoawalentry')) ? intval($this->input->post('periode_allowsaldoawalentry')) : 0 );
		$islocked = (!empty($this->input->post('periode_islocked')) ? intval($this->input->post('periode_islocked')): 0 );
        $data = array(
		'periode_id' => $this->input->post('periode_id'),
		'periode_name' => $this->input->post('periode_name'),
		'periode_datestart' => $this->input->post('periode_datestart'),
		'periode_dateend' => $this->input->post('periode_dateend'),
		'periode_isclosed' => $isclose,
		'periode_allowsaldoawalentry' => $allowsaldoawalentry,
		'periode_islocked' => $islocked,
		'periode_createdate' => $date,
		'periode_createby' => $username,
		);
		$this->db->insert('master_periode', $data); 
		//echo var_dump($allowsaldoawalentry);exit;
    } 
	
	function deleteperiode($periode_id){
		//$this->db->query("delete from master_periode where periode_id='$periode_id'");
		/*$this->db->query("delete from web_colldetil where coll_id='$coll_id'");*/
		$this->db->where('periode_id', $periode_id);
        $this->db->delete('master_periode');
	}
    
    function viewperiode($periode_id){     

     if (isset($periode_id)){
        return $this->db->query("
           select *
           from master_periode 
           where master_periode.periode_id='$periode_id'
       ")->result();
     }else{         
       $timestamp = time();
      
       $now = date("Y-m-d", $timestamp);  

       $result[] = (object) array(                        
                        'periode_id'         =>'auto',
                        'periode_name'       => '',
                        'periode_datestart'       => '',
                        'periode_dateend'        => '',
                        'periode_isclosed'     => 0,
                        'periode_allowsaldoawalentry'       => 0,
                        'periode_islocked'      => 0 
       );

       return $result;
     }

   }
      
    
}