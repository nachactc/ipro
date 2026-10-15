<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
class master_branchs extends CI_Model 
{

    public function __construct() 
    {
        parent::__construct();
    }


    /**
     *  Get All data master_branch
     *
     *  @param limit  : Integer
     *  @param offset : Integer
     *
     *  @return array
     *
     */
    public function get_all($limit, $offset) 
    {
 
		$page = 0;
		$startrow =  (((int)$this->uri->segment(3)) - 1 ) ;
		$startrow = $startrow <= -1 ? 1 : $startrow;
		$endrow =  ($startrow - 1)  +  $limit;
		$query = $this->db->query('SELECT * FROM (SELECT ROW_NUMBER() OVER(ORDER BY branch_id asc) AS row,(Count(*) OVER()) AS rows,  * FROM master_branch where branch_isdisabled =0) AS VW
		where row>='.$startrow.' and row<='.$endrow.'  
		order by branch_id asc');  
        $result =$query->result_array();
		
		//echo $startrow;
		//echo $endrow;
		//echo $this->db->last_query();
		//exit;
        if ($result ) 
        {
            return $result ;
        } 
        else 
        {
            return array();
        }
    }

    

    /**
     *  Count All master_branch
     *    
     *  @return Integer
     *
     */
    public function count_all()
    {
        $this->db->from('master_branch');
        $this->db->where('branch_isdisabled',0);
        return $this->db->count_all_results();
    }
    

    /**
    * Search All master_branch
    *
    *  @param limit   : Integer
    *  @param offset  : Integer
    *  @param keyword : mixed
    *
    *  @return array
    *
    */
    public function get_search($limit, $offset) 
    {
        $keyword = $this->session->userdata('keyword');
        
        
		$page = 0;
		$startrow =  (((int)$this->uri->segment(3)) - 1 ) ;
		$startrow = $startrow <= -1 ? 1 : $startrow;
		$endrow =  ($startrow - 1)  +  $limit;
		 
		$query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY branch_id asc) AS row,(Count(*) OVER()) AS rows,* FROM master_branch where branch_id like '%$keyword%' or branch_name like '%$keyword%' and branch_isdisabled =0 ) AS VW
		where row>=$startrow and row<=$endrow 
		order by row asc");  
	 
        $result =$query->result_array();
		// echo $startrow ;
		// echo $endrow ;
		// exit;
        if ($result ) 
        {
            return $result ;
        } 
        else 
        {
            return array();
        }
    }

     
    
    /**
    * Search All master_branch
    * @param keyword : mixed
    *
    * @return Integer
    *
    */
    public function count_all_search()
    {
        $keyword = $this->session->userdata('keyword');
        $limit = $this->config->item('per_page');
        $page = 0;
		$startrow =  (((int)$this->uri->segment(3)) - 1 ) ;
		$startrow = $startrow <= -1 ? 1 : $startrow;
		$endrow =  ($startrow - 1)  +  $limit;
		$query = $this->db->query("SELECT count(*) as total FROM (SELECT  ROW_NUMBER() OVER(ORDER BY branch_id asc) AS row,(Count(*) OVER()) AS rows,* FROM master_branch where branch_id like '%$keyword%' or branch_name like '%$keyword%' and branch_isdisabled =0) AS VW
		where row>=$startrow and row<=$endrow  ");  
        $result =$query->row();   
        return $result->total;
    }
 
     
    /**
    *  Get One master_branch
    *
    *  @param id : Integer
    *
    *  @return array
    *
    */
    public function get_one($id) 
    {
        $this->db->where('branch_id', $id);
        $result = $this->db->get('master_branch');
		//echo $this->db->last_query();exit;
        if ($result->num_rows() == 1) 
        {
            return $result->row_array();
        } 
        else 
        {
            return array();
        }
    }
	
 function getutilities_id($id){
  $sql="select utilitieslistrik_id, utilitiesair_id, utilitiesgas_id from master_branch 
  where branch_id='$id'"; 
  return $this->db->query($sql)->row_array(); 
 }
    
    /**
    *  Default form data master_branch
    *  @return array
    *
    */
    public function add()
    {
        $data = array(
            
                'branch_id' => '',
            
                'branch_name' => '',
            
                'branch_address' => '',
            
                'branch_city' => '',
            
                'branch_telp' => '',
            
                'branch_isdisabled' => 0,
            
                'branch_type' => '',
            
                'branch_isgroup' => 0,
            
                'branch_parent' => '',
            
                'branch_path' => '',
            
                'branch_closingdate' => date("Y-m-d"),
            
                'branch_openingdate' => date("Y-m-d"),
            
                'branch_createby' => '',
            
                'branch_createdate' => date("Y-m-d"),
            
                'branch_modifyby' => '',
            
                'branch_modifydate' => date("Y-m-d"),
            
                'branch_extid' => 0,
            
                'branch_nameshort' => '',
             
            
                'branch_isdirectcost' => 0,
            
                'branch_code' => '',
            
                'branch_idlok' => '',
            
                'branch_idutilitiesair' => '',
            
                'branch_totalsqm' => 0,
				
				'branch_namerpt' => '',
				
				'branch_namereport' => '',
            
        );

        return $data;
    }
 
    
    /**
    *  Save data Post
    *
    *  @return void
    *
    */
    public function save() 
    {
		$id_branch = get_one_id('branch_id','master_branch','STRING',7) ;
		$id_parent = strip_tags($this->input->post('branch_parent', TRUE));
		$id_parent = $id_parent == '' ? '' : trim($id_parent); 
		
		// echo $id_branch;
		// echo "<br/>";
		// echo $id_parent;
		// exit;
		
        $data = array(
        
            'branch_id' => $id_branch,
        
            'branch_name' => strip_tags($this->input->post('branch_name', TRUE)),
        
            'branch_address' => strip_tags($this->input->post('branch_address', TRUE)),
        
            'branch_city' => strip_tags($this->input->post('branch_city', TRUE)),
        
            'branch_telp' => strip_tags($this->input->post('branch_telp', TRUE)),
        
            'branch_isdisabled' =>  strip_tags($this->input->post('branch_isdisabled')),
        
            'branch_type' => strip_tags($this->input->post('branch_type', TRUE)),
        
            'branch_isgroup' => strip_tags($this->input->post('branch_isgroup')),
        
            'branch_parent' => $id_parent,
        
            'branch_path' => $id_branch . $id_parent ,
        
            'branch_closingdate' => strip_tags($this->input->post('branch_closingdate', TRUE)),
        
            'branch_openingdate' => strip_tags($this->input->post('branch_openingdate', TRUE)),
        
            'branch_createby' =>$this->session->userdata('user_name'),
        
            'branch_createdate' => date('Y-m-d H:i:s'), 
        
            'branch_extid' => $this->input->post('branch_extid', TRUE),
        
            'branch_nameshort' => strip_tags($this->input->post('branch_nameshort', TRUE)),
          
            'branch_isdirectcost' => $this->input->post('branch_isdirectcost', TRUE),
        
            'branch_code' => strip_tags($this->input->post('branch_code', TRUE)),
        
            'branch_idlok' => strip_tags($this->input->post('branch_idlok', TRUE)),
        
            'branch_idutilitiesair' => strip_tags($this->input->post('branch_idutilitiesair', TRUE)),
        
            'branch_totalsqm' => strip_tags($this->input->post('branch_totalsqm', TRUE)),
			
            'branch_namerpt' => strip_tags($this->input->post('branch_namerpt', TRUE)),
			
            'branch_namereport' => strip_tags($this->input->post('branch_namereport', TRUE)),
        
        );
       
		// echo var_dump($data);exit;
		/* update region branch dulu **/
		$region = $this->input->post('region');
		 if($region != '')
		{
			foreach ($this->input->post('region') as $key => $value)
			{   
				  $this->db->query("exec adm03_MstRegion_Branch_Attach '$value','$id_branch',1 ");
			}
		} 
		/** end **/
		
        $this->db->insert('master_branch', $data);
		
		/* sequencer unit **/
		$dataSequencerUnit = array(
							'branch_id' => $id_branch,
							'lastid'    => '10001',
							'lastdate'	=> date('Y-m-d H:i:s'),
							);
		$this->db->insert('sequencer_unit', $dataSequencerUnit);
		/** end **/
		
		/*acc branch insert*/
		$this->db->query("adm03_MstBranch_InsertACC '$id_branch' ");
		/*acc branch insert*/
		
		
		/* update Utilities listrik dulu **/
		//echo var_dump($_POST);exit;  
		
		$utilitieslistrik_id 				= str_replace(' ', '', $this->input->post('utilitieslistrik_id'));
		$utilitieslistrik_name            	= $this->input->post('utilitieslistrik_name');		
		$utilitieslistrik_amp 				=  $this->input->post('utilitieslistrik_amp');
		$utilitieslistrik_phase 			=  $this->input->post('utilitieslistrik_phase');
		$utilitieslistrik_kva 				=  $this->input->post('utilitieslistrik_kva');
		$utilitieslistrik_faktor 			=  $this->input->post('utilitieslistrik_faktor');
		$utilitieslistrik_issingglemeter 	=  $this->input->post('utilitieslistrik_issingglemeter');
		$utilitieslistrik_isadditional 		=  $this->input->post('utilitieslistrik_isadditional');
		$utilitieslistrik_admpercent 		=  $this->input->post('utilitieslistrik_admpercent');
		$utilitieslistrik_admamount 		=  $this->input->post('utilitieslistrik_admamount');
		$utilitieslistrik_bpju 				=  $this->input->post('utilitieslistrik_bpju');
		$utilitieskva_id 					=  $this->input->post('utilitieskva_id');
		$tariflwbp_calcbyuser 				=  $this->input->post('tariflwbp_calcbyuser');
		$tarifwbp_calcbyuser 				=  $this->input->post('tarifwbp_calcbyuser');
		$selisih_calcbyuser 				=  $this->input->post('selisih_calcbyuser');
		$selisihlwbp_calcbyuser 			=  $this->input->post('selisihlwbp_calcbyuser');
		$selisihwbp_calcbyuser 				=  $this->input->post('selisihwbp_calcbyuser');
		$pemakaianwbp_calcbyuser 			=  $this->input->post('pemakaianwbp_calcbyuser');
		$pemakaianlwbp_calcbyuser 			=  $this->input->post('pemakaianlwbp_calcbyuser');
		$utilitieslistrik_isgenset 			=  $this->input->post('utilitieslistrik_isgenset');
		$utilitieslistrik_isblocked 		=  $this->input->post('utilitieslistrik_isblocked');
		$utilitieslistrik_isdisabled 		=  $this->input->post('utilitieslistrik_isdisabled'); 
	
		//echo var_dump($utilitieslistrik_name);exit; 
		//echo 'bug - '.$utilitieslistrik_isdisabled[0];exit;
		
		$this->db->where('branch_id', $id);
        $this->db->delete('master_branchutilitieslistrik');
		
		if($utilitieslistrik_id != '')
		{
			foreach ( $utilitieslistrik_id as $key => $value)
			{   
				
				$d_utilitieslistrik_id       		= $utilitieslistrik_id[$key];
				$d_utilitieslistrik_name       		= $utilitieslistrik_name[$key];				
				$d_utilitieslistrik_amp 			= $utilitieslistrik_amp[$key];
				$d_utilitieslistrik_phase 			= $utilitieslistrik_phase[$key];
				$d_utilitieslistrik_kva 			= $utilitieslistrik_kva[$key];
				$d_utilitieslistrik_faktor 			= $utilitieslistrik_faktor[$key];
				$d_utilitieslistrik_issingglemeter 	= (int)$utilitieslistrik_issingglemeter[$key];
				$d_utilitieslistrik_isadditional 	= (int)$utilitieslistrik_isadditional[$key];
				$d_utilitieslistrik_admpercent 		= $utilitieslistrik_admpercent[$key];
				$d_utilitieslistrik_admamount 		= $utilitieslistrik_admamount[$key];
				$d_utilitieslistrik_bpju 			= $utilitieslistrik_bpju[$key];
				$d_utilitieskva_id 					= $utilitieskva_id[$key];
				$d_tariflwbp_calcbyuser 			= (int)$tariflwbp_calcbyuser[$key];
				$d_tarifwbp_calcbyuser 				= (int)$tarifwbp_calcbyuser[$key];
				$d_selisih_calcbyuser 				= (int)$selisih_calcbyuser[$key];
				$d_selisihlwbp_calcbyuser 			= (int)$selisihlwbp_calcbyuser[$key];
				$d_selisihwbp_calcbyuser 			= (int)$selisihwbp_calcbyuser[$key];
				$d_pemakaianwbp_calcbyuser 			= (int)$pemakaianwbp_calcbyuser[$key];
				$d_pemakaianlwbp_calcbyuser 		= (int)$pemakaianlwbp_calcbyuser[$key];
				$d_utilitieslistrik_isgenset 		= (int)$utilitieslistrik_isgenset[$key];
				$d_utilitieslistrik_isblocked 		= (int)$utilitieslistrik_isblocked[$key];
				$d_utilitieslistrik_isdisabled 		= (int)$utilitieslistrik_isdisabled[$key];
				
				  //echo $d_utilitieslistrik_amp; exit;
				  $this->db->query("exec adm03_MstBranch_Utilitieslistrik_Insert '$id_branch','$d_utilitieslistrik_id','$d_utilitieslistrik_name',$d_utilitieslistrik_amp, $d_utilitieslistrik_phase, $d_utilitieslistrik_kva, $d_utilitieslistrik_faktor, $d_utilitieslistrik_issingglemeter, $d_utilitieslistrik_isadditional, $d_utilitieslistrik_admpercent, $d_utilitieslistrik_admamount, $d_utilitieslistrik_bpju, '$d_utilitieskva_id', $d_tariflwbp_calcbyuser, $d_tarifwbp_calcbyuser, $d_selisih_calcbyuser, $d_selisihlwbp_calcbyuser, $d_selisihwbp_calcbyuser, $d_pemakaianwbp_calcbyuser, $d_pemakaianlwbp_calcbyuser, $d_utilitieslistrik_isgenset, $d_utilitieslistrik_isblocked, $d_utilitieslistrik_isdisabled");
			} 
		}
		
		/** end  listrik **/
		
		/* update Utilities Air dulu **/
		
		$utilitiesair_id 				= str_replace(' ', '', $this->input->post('utilitiesair_id'));
		$utilitiesair_name            	= $this->input->post('utilitiesair_name');
		$utilitiesair_diameterpipa      = $this->input->post('utilitiesair_diameterpipa');
		$utilitiesair_adm            	= $this->input->post('utilitiesair_adm');
		$utilitiesair_phairkotor        = $this->input->post('utilitiesair_phairkotor');
		$utilitiesair_phmeter           = $this->input->post('utilitiesair_phmeter');
		$utilitiesair_isadditional      = $this->input->post('utilitiesair_isadditional');		
		$phairkotor_isdisabled          = $this->input->post('phairkotor_isdisabled');
		$utilitiesair_admpercent        = $this->input->post('utilitiesair_admpercent');
		$utilitiesair_abonemen          = $this->input->post('utilitiesair_abonemen');
		$utilitiesair_isusedawalakhir   = $this->input->post('utilitiesair_isusedawalakhir');
		$utilitiesair_isdisabled        = $this->input->post('utilitiesair_isdisabled');
		
		//echo var_dump($_POST);exit; 
		//echo 'bug - '.$utilitiesair_isadditional[1];exit;
		
		$this->db->where('branch_id', $id);
        $this->db->delete('master_branchutilitiesair');
		
		if($utilitiesair_id != '')
		{
			foreach ( $utilitiesair_id as $key => $value)
			{   
				
				$d_utilitiesair_id       		= $utilitiesair_id[$key];
				$d_utilitiesair_name       		= $utilitiesair_name[$key];
				$d_utilitiesair_diameterpipa 	= $utilitiesair_diameterpipa[$key];
				$d_utilitiesair_adm 			=  $utilitiesair_adm[$key];
				$d_utilitiesair_phairkotor 		=  $utilitiesair_phairkotor[$key];
				$d_utilitiesair_phmeter 		=  $utilitiesair_phmeter[$key];
				$d_utilitiesair_isadditional 	=  (int)$utilitiesair_isadditional[$key];
				$d_phairkotor_isdisabled 		=  (int)$phairkotor_isdisabled[$key];
				$d_utilitiesair_admpercent 		=  $utilitiesair_admpercent[$key];
				$d_utilitiesair_abonemen 		=  $utilitiesair_abonemen[$key];
				$d_utilitiesair_isusedawalakhir =  (int)$utilitiesair_isusedawalakhir[$key];
				$d_utilitiesair_isdisabled 		=  (int)$utilitiesair_isdisabled[$key];

				
				  //echo $d_utilitiesair_isadditional;
				  $this->db->query("exec adm03_MstBranch_UtilitiesAir_Insert '$id_branch','$d_utilitiesair_id','$d_utilitiesair_name','$d_utilitiesair_diameterpipa',$d_utilitiesair_adm,$d_utilitiesair_phairkotor,$d_utilitiesair_phmeter,$d_utilitiesair_isadditional,$d_phairkotor_isdisabled,$d_utilitiesair_admpercent,$d_utilitiesair_abonemen,$d_utilitiesair_isusedawalakhir,$d_utilitiesair_isdisabled ");
			} 
		}
		
		/** end  Air **/
		
		/* update Utilities gas dulu **/
		
		$utilitiesgas_id 				= str_replace(' ', '', $this->input->post('utilitiesgas_id'));
		$utilitiesgas_name            	= $this->input->post('utilitiesgas_name');
		$utilitiesgas_diameterpipa      = $this->input->post('utilitiesgas_diameterpipa');
		$utilitiesgas_adm            	= $this->input->post('utilitiesgas_adm');
		$utilitiesgas_phairkotor        = $this->input->post('utilitiesgas_phairkotor');
		$utilitiesgas_phmeter           = $this->input->post('utilitiesgas_phmeter');
		$utilitiesgas_isadditional      = $this->input->post('utilitiesgas_isadditional');		
		$utilitiesgas_tarif          	= $this->input->post('utilitiesgas_tarif');
		$utilitiesgas_mfaktor          	= $this->input->post('utilitiesgas_mfaktor');
		$utilitiesgas_pressure          = $this->input->post('utilitiesgas_pressure');
		$utilitiesgas_admpercent        = $this->input->post('utilitiesgas_admpercent');		
		$utilitiesgas_isusedawalakhir   = $this->input->post('utilitiesgas_isusedawalakhir');
		$utilitiesgas_isdisabled        = $this->input->post('utilitiesgas_isdisabled');
		
		//echo var_dump($_POST);exit; 
		//echo 'bug - '.$utilitiesgas_isadditional[1];exit;
		
		$this->db->where('branch_id', $id);
        $this->db->delete('master_branchutilitiesgas');
		
		if($utilitiesgas_id != '')
		{
			foreach ( $utilitiesgas_id as $key => $value)
			{   
				
				$d_utilitiesgas_id       		= $utilitiesgas_id[$key];
				$d_utilitiesgas_name       		= $utilitiesgas_name[$key];
				$d_utilitiesgas_diameterpipa 	= $utilitiesgas_diameterpipa[$key];
				$d_utilitiesgas_adm 			=  $utilitiesgas_adm[$key];
				$d_utilitiesgas_phairkotor 		=  $utilitiesgas_phairkotor[$key];
				$d_utilitiesgas_phmeter 		=  $utilitiesgas_phmeter[$key];
				$d_utilitiesgas_isadditional 	=  (int)$utilitiesgas_isadditional[$key];
				$d_utilitiesgas_tarif 			=  $utilitiesgas_tarif[$key];
				$d_utilitiesgas_mfaktor 		=  $utilitiesgas_mfaktor[$key];
				$d_utilitiesgas_pressure 		=  $utilitiesgas_pressure[$key];
				$d_utilitiesgas_admpercent 		=  $utilitiesgas_admpercent[$key];				
				$d_utilitiesgas_isusedawalakhir =  (int)$utilitiesgas_isusedawalakhir[$key];
				$d_utilitiesgas_isdisabled 		=  (int)$utilitiesgas_isdisabled[$key];

				
				  //echo $d_utilitiesgas_isadditional;
				  $this->db->query("exec adm03_MstBranch_Utilitiesgas_Insert '$id_branch','$d_utilitiesgas_id','$d_utilitiesgas_name','$d_utilitiesgas_diameterpipa',$d_utilitiesgas_adm,$d_utilitiesgas_phairkotor,$d_utilitiesgas_phmeter,$d_utilitiesgas_isadditional,$d_utilitiesgas_tarif,$d_utilitiesgas_mfaktor,$d_utilitiesgas_pressure,$d_utilitiesgas_admpercent,$d_utilitiesgas_isusedawalakhir,$d_utilitiesgas_isdisabled ");
			} 
		}
		
		/** end  gas **/
		
	
    }
     
    
    /**
    *  Update modify data
    *
    *  @param id : Integer
    *
    *  @return void
    *
    */
    public function update($id)
    {
		if($this->input->post('branch_totalsqm') == '')
		{
			$sqm = 0;
		}
		else
		{
			$sqm = $this->input->post('branch_totalsqm');
		}
        $data = array(
        
                'branch_id' => strip_tags($this->input->post('branch_id', TRUE)),
        
                'branch_name' => strip_tags($this->input->post('branch_name', TRUE)),
        
                'branch_address' => strip_tags($this->input->post('branch_address', TRUE)),
        
                'branch_city' => strip_tags($this->input->post('branch_city', TRUE)),
        
                'branch_telp' => strip_tags($this->input->post('branch_telp', TRUE)),
        
                'branch_isdisabled' => strip_tags($this->input->post('branch_isdisabled', TRUE)),
        
                'branch_type' => strip_tags($this->input->post('branch_type', TRUE)),
        
                'branch_isgroup' => strip_tags($this->input->post('branch_isgroup', TRUE)),
        
                'branch_parent' => strip_tags($this->input->post('branch_parent', TRUE)),
        
                'branch_path' => strip_tags($this->input->post('branch_path', TRUE)),
        
                'branch_closingdate' => strip_tags($this->input->post('branch_closingdate', TRUE)),
        
                'branch_openingdate' => strip_tags($this->input->post('branch_openingdate', TRUE)),
          
                'branch_modifyby' => $this->session->userdata('username'),
        
                'branch_modifydate' => date('Y-m-d H:i:s'),
        
                'branch_extid' => strip_tags($this->input->post('branch_extid', TRUE)),
        
                'branch_nameshort' => strip_tags($this->input->post('branch_nameshort', TRUE)),
        
                'rowid' => strip_tags($this->input->post('rowid', TRUE)),
        
                'branch_isdirectcost' => strip_tags($this->input->post('branch_isdirectcost', TRUE)),
        
                'branch_code' => strip_tags($this->input->post('branch_code', TRUE)),
        
                'branch_idlok' => strip_tags($this->input->post('branch_idlok', TRUE)),
        
                'branch_idutilitiesair' => strip_tags($this->input->post('branch_idutilitiesair', TRUE)),
        
                'branch_totalsqm' => $sqm,
				
				'branch_namerpt' => strip_tags($this->input->post('branch_namerpt', TRUE)),
				
				'branch_namereport' => strip_tags($this->input->post('branch_namereport', TRUE)),
        );
        // echo  var_dump($this->session->userdata());
        // echo var_dump($data);exit;
		
		/* update region branch dulu **/
		$this->db->where('branch_id', $id);
        $this->db->delete('master_regionbranch');
		$region = str_replace(' ', '', $this->input->post('region'));
		//echo var_dump($region);exit; 
		if($region != '')
		{
			foreach ( $region as $key => $value)
			{   
				  //echo $value;
				  $this->db->query("exec adm03_MstRegion_Branch_Attach '$value','$id',1 ");
			} 
		}
		
		/** end **/ 
		/* update Utilities listrik dulu **/
		//echo var_dump($_POST);exit;  
		
		$utilitieslistrik_id 				= str_replace(' ', '', $this->input->post('utilitieslistrik_id'));
		$utilitieslistrik_name            	= $this->input->post('utilitieslistrik_name');		
		$utilitieslistrik_amp 				=  $this->input->post('utilitieslistrik_amp');
		$utilitieslistrik_phase 			=  $this->input->post('utilitieslistrik_phase');
		$utilitieslistrik_kva 				=  $this->input->post('utilitieslistrik_kva');
		$utilitieslistrik_faktor 			=  $this->input->post('utilitieslistrik_faktor');
		$utilitieslistrik_issingglemeter 	=  $this->input->post('utilitieslistrik_issingglemeter');
		$utilitieslistrik_isadditional 		=  $this->input->post('utilitieslistrik_isadditional');
		$utilitieslistrik_admpercent 		=  $this->input->post('utilitieslistrik_admpercent');
		$utilitieslistrik_admamount 		=  $this->input->post('utilitieslistrik_admamount');
		$utilitieslistrik_bpju 				=  $this->input->post('utilitieslistrik_bpju');
		$utilitieskva_id 					=  $this->input->post('utilitieskva_id');
		$tariflwbp_calcbyuser 				=  $this->input->post('tariflwbp_calcbyuser');
		$tarifwbp_calcbyuser 				=  $this->input->post('tarifwbp_calcbyuser');
		$selisih_calcbyuser 				=  $this->input->post('selisih_calcbyuser');
		$selisihlwbp_calcbyuser 			=  $this->input->post('selisihlwbp_calcbyuser');
		$selisihwbp_calcbyuser 				=  $this->input->post('selisihwbp_calcbyuser');
		$pemakaianwbp_calcbyuser 			=  $this->input->post('pemakaianwbp_calcbyuser');
		$pemakaianlwbp_calcbyuser 			=  $this->input->post('pemakaianlwbp_calcbyuser');
		$utilitieslistrik_isgenset 			=  $this->input->post('utilitieslistrik_isgenset');
		$utilitieslistrik_isblocked 		=  $this->input->post('utilitieslistrik_isblocked');
		$utilitieslistrik_isdisabled 		=  $this->input->post('utilitieslistrik_isdisabled'); 
	
		//echo var_dump($utilitieslistrik_name);exit; 
		//echo 'bug - '.$utilitieslistrik_isdisabled[0];exit;
		
		$this->db->where('branch_id', $id);
        $this->db->delete('master_branchutilitieslistrik');
		
		if($utilitieslistrik_name != '')
		{
			foreach ( $utilitieslistrik_id as $key => $value)
			{   
				
				$d_utilitieslistrik_id       		= $utilitieslistrik_id[$key];
				$d_utilitieslistrik_name       		= $utilitieslistrik_name[$key];				
				$d_utilitieslistrik_amp 			= $utilitieslistrik_amp[$key];
				$d_utilitieslistrik_phase 			= $utilitieslistrik_phase[$key];
				$d_utilitieslistrik_kva 			= $utilitieslistrik_kva[$key];
				$d_utilitieslistrik_faktor 			= $utilitieslistrik_faktor[$key];
				$d_utilitieslistrik_issingglemeter 	= (int)$utilitieslistrik_issingglemeter[$key];
				$d_utilitieslistrik_isadditional 	= (int)$utilitieslistrik_isadditional[$key];
				$d_utilitieslistrik_admpercent 		= $utilitieslistrik_admpercent[$key];
				$d_utilitieslistrik_admamount 		= $utilitieslistrik_admamount[$key];
				$d_utilitieslistrik_bpju 			= $utilitieslistrik_bpju[$key];
				$d_utilitieskva_id 					= $utilitieskva_id[$key];
				$d_tariflwbp_calcbyuser 			= (int)$tariflwbp_calcbyuser[$key];
				$d_tarifwbp_calcbyuser 				= (int)$tarifwbp_calcbyuser[$key];
				$d_selisih_calcbyuser 				= (int)$selisih_calcbyuser[$key];
				$d_selisihlwbp_calcbyuser 			= (int)$selisihlwbp_calcbyuser[$key];
				$d_selisihwbp_calcbyuser 			= (int)$selisihwbp_calcbyuser[$key];
				$d_pemakaianwbp_calcbyuser 			= (int)$pemakaianwbp_calcbyuser[$key];
				$d_pemakaianlwbp_calcbyuser 		= (int)$pemakaianlwbp_calcbyuser[$key];
				$d_utilitieslistrik_isgenset 		= (int)$utilitieslistrik_isgenset[$key];
				$d_utilitieslistrik_isblocked 		= (int)$utilitieslistrik_isblocked[$key];
				$d_utilitieslistrik_isdisabled 		= (int)$utilitieslistrik_isdisabled[$key];
				
				  //echo $d_utilitieslistrik_amp; exit;
				  $this->db->query("exec adm03_MstBranch_Utilitieslistrik_Insert '$id','$d_utilitieslistrik_id','$d_utilitieslistrik_name',$d_utilitieslistrik_amp, $d_utilitieslistrik_phase, $d_utilitieslistrik_kva, $d_utilitieslistrik_faktor, $d_utilitieslistrik_issingglemeter, $d_utilitieslistrik_isadditional, $d_utilitieslistrik_admpercent, $d_utilitieslistrik_admamount, $d_utilitieslistrik_bpju, '$d_utilitieskva_id', $d_tariflwbp_calcbyuser, $d_tarifwbp_calcbyuser, $d_selisih_calcbyuser, $d_selisihlwbp_calcbyuser, $d_selisihwbp_calcbyuser, $d_pemakaianwbp_calcbyuser, $d_pemakaianlwbp_calcbyuser, $d_utilitieslistrik_isgenset, $d_utilitieslistrik_isblocked, $d_utilitieslistrik_isdisabled");
			} 
		}
		
		/** end  listrik **/
		
		/* update Utilities Air dulu **/
		
		$utilitiesair_id 				= str_replace(' ', '', $this->input->post('utilitiesair_id'));
		$utilitiesair_name            	= $this->input->post('utilitiesair_name');
		$utilitiesair_diameterpipa      = $this->input->post('utilitiesair_diameterpipa');
		$utilitiesair_adm            	= $this->input->post('utilitiesair_adm');
		$utilitiesair_phairkotor        = $this->input->post('utilitiesair_phairkotor');
		$utilitiesair_phmeter           = $this->input->post('utilitiesair_phmeter');
		$utilitiesair_isadditional      = $this->input->post('utilitiesair_isadditional');		
		$phairkotor_isdisabled          = $this->input->post('phairkotor_isdisabled');
		$utilitiesair_admpercent        = $this->input->post('utilitiesair_admpercent');
		$utilitiesair_abonemen          = $this->input->post('utilitiesair_abonemen');
		$utilitiesair_isusedawalakhir   = $this->input->post('utilitiesair_isusedawalakhir');
		$utilitiesair_isdisabled        = $this->input->post('utilitiesair_isdisabled');
		
		//echo var_dump($_POST);exit; 
		//echo 'bug - '.$utilitiesair_isadditional[1];exit;
		
		$this->db->where('branch_id', $id);
        $this->db->delete('master_branchutilitiesair');
		
		if($utilitiesair_id != '')
		{
			foreach ( $utilitiesair_id as $key => $value)
			{   
				
				$d_utilitiesair_id       		= $utilitiesair_id[$key];
				$d_utilitiesair_name       		= $utilitiesair_name[$key];
				$d_utilitiesair_diameterpipa 	= $utilitiesair_diameterpipa[$key];
				$d_utilitiesair_adm 			=  $utilitiesair_adm[$key];
				$d_utilitiesair_phairkotor 		=  $utilitiesair_phairkotor[$key];
				$d_utilitiesair_phmeter 		=  $utilitiesair_phmeter[$key];
				$d_utilitiesair_isadditional 	=  (int)$utilitiesair_isadditional[$key];
				$d_phairkotor_isdisabled 		=  (int)$phairkotor_isdisabled[$key];
				$d_utilitiesair_admpercent 		=  $utilitiesair_admpercent[$key];
				$d_utilitiesair_abonemen 		=  $utilitiesair_abonemen[$key];
				$d_utilitiesair_isusedawalakhir =  (int)$utilitiesair_isusedawalakhir[$key];
				$d_utilitiesair_isdisabled 		=  (int)$utilitiesair_isdisabled[$key];

				
				  //echo $d_utilitiesair_isadditional;
				  $this->db->query("exec adm03_MstBranch_UtilitiesAir_Insert '$id','$d_utilitiesair_id','$d_utilitiesair_name','$d_utilitiesair_diameterpipa',$d_utilitiesair_adm,$d_utilitiesair_phairkotor,$d_utilitiesair_phmeter,$d_utilitiesair_isadditional,$d_phairkotor_isdisabled,$d_utilitiesair_admpercent,$d_utilitiesair_abonemen,$d_utilitiesair_isusedawalakhir,$d_utilitiesair_isdisabled ");
			} 
		}
		
		/** end  Air **/
		
		/* update Utilities gas dulu **/
		
		$utilitiesgas_id 				= str_replace(' ', '', $this->input->post('utilitiesgas_id'));
		$utilitiesgas_name            	= $this->input->post('utilitiesgas_name');
		$utilitiesgas_diameterpipa      = $this->input->post('utilitiesgas_diameterpipa');
		$utilitiesgas_adm            	= $this->input->post('utilitiesgas_adm');
		$utilitiesgas_phairkotor        = $this->input->post('utilitiesgas_phairkotor');
		$utilitiesgas_phmeter           = $this->input->post('utilitiesgas_phmeter');
		$utilitiesgas_isadditional      = $this->input->post('utilitiesgas_isadditional');		
		$utilitiesgas_tarif          	= $this->input->post('utilitiesgas_tarif');
		$utilitiesgas_mfaktor          	= $this->input->post('utilitiesgas_mfaktor');
		$utilitiesgas_pressure          = $this->input->post('utilitiesgas_pressure');
		$utilitiesgas_admpercent        = $this->input->post('utilitiesgas_admpercent');		
		$utilitiesgas_isusedawalakhir   = $this->input->post('utilitiesgas_isusedawalakhir');
		$utilitiesgas_isdisabled        = $this->input->post('utilitiesgas_isdisabled');
		
		//echo var_dump($_POST);exit; 
		//echo 'bug - '.$utilitiesgas_isadditional[1];exit;
		
		$this->db->where('branch_id', $id);
        $this->db->delete('master_branchutilitiesgas');
		
		if($utilitiesgas_id != '')
		{
			foreach ( $utilitiesgas_id as $key => $value)
			{   
				
				$d_utilitiesgas_id       		= $utilitiesgas_id[$key];
				$d_utilitiesgas_name       		= $utilitiesgas_name[$key];
				$d_utilitiesgas_diameterpipa 	= $utilitiesgas_diameterpipa[$key];
				$d_utilitiesgas_adm 			=  $utilitiesgas_adm[$key];
				$d_utilitiesgas_phairkotor 		=  $utilitiesgas_phairkotor[$key];
				$d_utilitiesgas_phmeter 		=  $utilitiesgas_phmeter[$key];
				$d_utilitiesgas_isadditional 	=  (int)$utilitiesgas_isadditional[$key];
				$d_utilitiesgas_tarif 			=  $utilitiesgas_tarif[$key];
				$d_utilitiesgas_mfaktor 		=  $utilitiesgas_mfaktor[$key];
				$d_utilitiesgas_pressure 		=  $utilitiesgas_pressure[$key];
				$d_utilitiesgas_admpercent 		=  $utilitiesgas_admpercent[$key];				
				$d_utilitiesgas_isusedawalakhir =  (int)$utilitiesgas_isusedawalakhir[$key];
				$d_utilitiesgas_isdisabled 		=  (int)$utilitiesgas_isdisabled[$key];

				
				  //echo $d_utilitiesgas_isadditional;
				  $this->db->query("exec adm03_MstBranch_Utilitiesgas_Insert '$id','$d_utilitiesgas_id','$d_utilitiesgas_name','$d_utilitiesgas_diameterpipa',$d_utilitiesgas_adm,$d_utilitiesgas_phairkotor,$d_utilitiesgas_phmeter,$d_utilitiesgas_isadditional,$d_utilitiesgas_tarif,$d_utilitiesgas_mfaktor,$d_utilitiesgas_pressure,$d_utilitiesgas_admpercent,$d_utilitiesgas_isusedawalakhir,$d_utilitiesgas_isdisabled ");
			} 
		}
		
		/** end  gas **/
		
        $this->db->where('branch_id', $id);
        $this->db->update('master_branch', $data);
    }
 
    /**
    *  Delete data by id
    *
    *  @param id : Integer
    *
    *  @return void
    *
    */
    public function destroy($id)
    {       
        $this->db->where('branch_id', $id);
        $this->db->delete('master_branch');
            
        $this->db->where('branch_id', $id);
        $this->db->delete('master_regionbranch');
		
        $this->db->where('branch_id', $id);
        $this->db->delete('master_accbranch');
        
		$this->db->where('branch_id', $id);
        $this->db->delete('master_branchutilitieslistrik');
		
		$this->db->where('branch_id', $id);
        $this->db->delete('master_branchutilitiesair');
		
		$this->db->where('branch_id', $id);
        $this->db->delete('master_branchutilitiesgas');
    }
 
    // get branch parent
    public function get_branch_parent_combo() 
    {
      
        $result = $this->db->get('master_branch')
                           ->result();

        $ret ['']= 'Pilih Parent :';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->branch_id] = $row->branch_name;
            }
        }
        
        return $ret;
    }
 
    
    // get master utilities gas air
    public function get_utilitiesgasir_combo() 
    {
		$this->db->where('utilitiesairgas_type','UA');
		$this->db->where('utilitiesairgas_name','Blok 1');
        $result = $this->db->get('master_utilitiesairgas')
                           ->result();

        $ret ['']= 'Pilih Data:';
        if($result)
        {
            foreach ($result as $key => $row)
            {
                $ret [$row->utilitiesairgas_number] = $row->utilitiesairgas_number.'-->'.$row->utilitiesairgas_name.'-->'.$row->utilitiesairgas_tarif;
            }
        }
        
        return $ret;
    }


    // get master region
	public function get_regionbranch_all($branch_id)
	{
		if($branch_id != '')
		{
			$result = $this->db->query("exec adm03_MstBranch_SelectRegion '$branch_id'");
			//echo $this->db->last_query;
		}
		else
		{
			$result =  $this->db->query("select  0 AS [selected], region_id,region_name from master_region");
		}
		
        if ($result->num_rows() > 0) 
        {
            return $result->result_array();
        } 
        else 
        {
            return array();
        }
	}
	
	// get master listrik
	public function get_utilitieslistrik_all($where)
	{
		
		if($where != '')
		{
			$result = $this->db->query("exec adm03_MstBranch_Utilitieslistrik_SelectALL '','$where'");
			//echo $this->db->last_query;
		}
		else
		{
			$result =  $this->db->query("select  0 AS [selected], utilitieslistrik_id,utilitieslistrik_name, utilitieslistrik_amp from master_utilitieslistrik");
		}
		
        if ($result->num_rows() > 0) 
        {
            return $result->result_array();
        } 
        else 
        {
            return array();
        }
	}
	
	// get master air
	public function get_utilitiesair_all($where)
	{
		
		if($where != '')
		{
			$result = $this->db->query("exec adm03_MstBranch_Utilitiesair_Select '$where'");
			//echo $this->db->last_query;
		}
		else
		{
			$result =  $this->db->query("select  0 AS [selected], utilitieslistrik_id,utilitieslistrik_name, utilitieslistrik_amp from master_utilitieslistrik");
		}
		
        if ($result->num_rows() > 0) 
        {
            return $result->result_array();
        } 
        else 
        {
            return array();
        }
	}	
	
	public function get_utilitiesgas_all($where)
	{
		
		if($where != '')
		{
			$result = $this->db->query("exec adm03_MstBranch_Utilitiesgas_Select '$where'");
			//echo $this->db->last_query;
		}
		else
		{
			$result =  $this->db->query("select  0 AS [selected], utilitieslistrik_id,utilitieslistrik_name, utilitieslistrik_amp from master_utilitieslistrik");
		}
		
        if ($result->num_rows() > 0) 
        {
            return $result->result_array();
        } 
        else 
        {
            return array();
        }
	}
	
	public function get_utilitieskva_all($where)
	{
				 		
      $getUnit = "EXEC [MstMstUtilitieskva_Select] '' ";
      $query = $this->db->query($getUnit);      

      return $query->result();
        
	}

	function qry_alldatalistrik($limit,$top,$sWhere){
     $qry="WITH CTE AS (
        select top $limit *,ROW_NUMBER() OVER (ORDER BY utilitieslistrik_id asc) as RowNumber 
        from master_utilitieslistrik $sWhere)
    SELECT CTE.*, KVA.utilitieskva_name
    FROM CTE 
      JOIN master_utilitieskva AS KVA ON CTE.utilitieskva_id = KVA.utilitieskva_id
    WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();    
   }
   
   function qry_filteredlistrik($sWhere){
     $qry="select count(utilitieslistrik_id) as jml from master_utilitieslistrik $sWhere";
    return $this->db->query($qry)->row_array();
     
   }
   
   function qry_totalalllistrik(){
     $qry="select count(utilitieslistrik_id) as jml from master_utilitieslistrik";
    return $this->db->query($qry)->row_array();
     
   }
   function qry_alldataair($limit,$top,$sWhere){
     $qry="WITH CTE AS (
        select top $limit *,ROW_NUMBER() OVER (ORDER BY utilitiesair_id asc) as RowNumber 
        from master_utilitiesair $sWhere)
    SELECT CTE.*
    FROM CTE       
    WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();    
   }
   
   function qry_filteredair($sWhere){
     $qry="select count(utilitiesair_id) as jml from master_utilitiesair $sWhere";
    return $this->db->query($qry)->row_array();
     
   }
   
   function qry_totalallair(){
     $qry="select count(utilitiesair_id) as jml from master_utilitiesair";
    return $this->db->query($qry)->row_array();
     
   }
   function qry_alldatagas($limit,$top,$sWhere){
     $qry="WITH CTE AS (
        select top $limit *,ROW_NUMBER() OVER (ORDER BY utilitiesgas_id asc) as RowNumber 
        from master_utilitiesgas $sWhere)
    SELECT CTE.*
    FROM CTE       
    WHERE RowNumber > $top";
     return $this->db->query($qry)->result_array();    
   }
   
   function qry_filteredgas($sWhere){
     $qry="select count(utilitiesgas_id) as jml from master_utilitiesgas $sWhere";
    return $this->db->query($qry)->row_array();
     
   }
   
   function qry_totalallgas(){
     $qry="select count(utilitiesgas_id) as jml from master_utilitiesgas";
    return $this->db->query($qry)->row_array();
     
   }
}
